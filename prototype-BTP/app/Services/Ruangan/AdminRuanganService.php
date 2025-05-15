<?php

namespace App\Services\Ruangan;

use App\Models\Gambar;
use App\Models\Ruangan;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRuanganRequest;
use App\Http\Requests\UpdateRuanganRequest;
use App\Interfaces\Repositories\AdminRuanganRepositoryInterface;

class AdminRuanganService
{
  protected AdminRuanganRepositoryInterface $adminRuanganRepository;

  public function __construct(AdminRuanganRepositoryInterface $adminRuanganRepository)
  {
    $this->adminRuanganRepository = $adminRuanganRepository;
  }

  public function storeRuangan(StoreRuanganRequest $request): void
  {
    $validatedData = $request->validated();

    $validatedData['keterangan'] = $request->input('keterangan') ?? 'Tidak ada keterangan';
    $validatedData['status'] = 'Tersedia';
    $validatedData['id_users'] = Auth::id();

    $ruangan = $this->adminRuanganRepository->createRuangan($validatedData);

    if ($request->hasFile('url')) {
      foreach ($request->file('url') as $index => $file) {
        if (!$file || !$file->isValid())
          continue;

        try {
          $cloudinary = new Cloudinary();
          $uploadResult = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
              'folder' => 'spacerent-btp/ruangan-btp',
              'public_id' => $ruangan->id_ruangan . '_image_' . ($index + 1)
            ]
          );

          Gambar::create([
            'id_ruangan' => $ruangan->id_ruangan,
            'url' => $uploadResult['secure_url']
          ]);
        } catch (\Exception $e) {
          \Log::error('Error uploading to Cloudinary', [
            'message' => $e->getMessage(),
            'file_index' => $index
          ]);
          continue;
        }
      }
    }
  }

  public function updateRuangan(Ruangan $ruangan, UpdateRuanganRequest $request): void
  {
    $validatedData = $request->validated();

    $ruangan->fill($validatedData);
    $ruangan->id_users = Auth::id();
    $ruangan->keterangan = $request->input('keterangan') ?? 'Tidak ada keterangan';
    $ruangan->save();

    if ($request->hasFile('url')) {
      $existingGambar = $ruangan->gambar
        ->sortBy(function ($gambar) {
          preg_match('/_image_(\d+)/', $gambar->url, $matches);
          return isset($matches[1]) ? (int) $matches[1] : 999;
        })
        ->values();

      foreach ($request->file('url') as $index => $file) {
        if (!$file || !$file->isValid())
          continue;

        try {
          $cloudinary = new Cloudinary();
          $public_id = $ruangan->id_ruangan . '_image_' . ($index + 1);
          $uploadResult = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
              'folder' => 'spacerent-btp/ruangan-btp',
              'public_id' => $public_id,
              'overwrite' => true
            ]
          );

          if (isset($existingGambar[$index])) {
            $gambar = Gambar::find($existingGambar[$index]->id_gambar);
            if ($gambar) {
              $gambar->url = $uploadResult['secure_url'];
              $gambar->save();
            }
          } else {
            Gambar::create([
              'id_ruangan' => $ruangan->id_ruangan,
              'url' => $uploadResult['secure_url']
            ]);
          }
        } catch (\Exception $e) {
          \Log::error('Error replacing image in Cloudinary', [
            'message' => $e->getMessage(),
            'file_index' => $index
          ]);
          continue;
        }
      }
    }
  }
}