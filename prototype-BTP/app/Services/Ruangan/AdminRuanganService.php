<?php

namespace App\Services\Ruangan;

use App\Enums\Database\GambarDatabaseColumn;
use Exception;
use App\Models\Gambar;
use App\Models\Ruangan;
use Illuminate\Support\Str;
use App\Enums\StatusRuangan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Enums\Database\UsersDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Http\Requests\Ruangan\StoreRuanganRequest;
use App\Http\Requests\Ruangan\UpdateRuanganRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Interfaces\Repositories\Ruangan\AdminRuanganRepositoryInterface;

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

    if (empty($validatedData[RuanganDatabaseColumn::GroupIdRuangan->value])) {
      $validatedData[RuanganDatabaseColumn::GroupIdRuangan->value] = Str::uuid()->toString();
    }

    $validatedData[RuanganDatabaseColumn::KeteranganRuangan->value] = $request->input(RuanganDatabaseColumn::KeteranganRuangan->value) ?? 'Tidak ada keterangan';
    $validatedData[RuanganDatabaseColumn::StatusRuangan->value] = StatusRuangan::Tersedia->value;
    $validatedData[UsersDatabaseColumn::IdUsers->value] = Auth::id();

    $ruangan = $this->adminRuanganRepository->createRuangan($validatedData);

    if ($request->hasFile(GambarDatabaseColumn::UrlGambar->value)) {
      foreach ($request->file(GambarDatabaseColumn::UrlGambar->value) as $index => $file) {
        if (!$file || !$file->isValid())
          continue;

        try {
          // Gunakan facade CloudinaryLabs untuk Laravel, bukan new Cloudinary()
          $uploadResult = Cloudinary::upload(
            $file->getRealPath(),
            [
              'folder' => 'spacerent-btp/ruangan-btp/v1',
              'public_id' => $ruangan->id_ruangan . '_image_' . ($index + 1)
            ]
          );

          Gambar::create([
            RuanganDatabaseColumn::IdRuangan->value => $ruangan->id_ruangan,
            GambarDatabaseColumn::UrlGambar->value => $uploadResult->getSecurePath()
          ]);
        } catch (Exception $e) {
          Log::error('Error uploading to Cloudinary', [
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
    $ruangan->keterangan = $request->input(RuanganDatabaseColumn::KeteranganRuangan->value) ?? 'Tidak ada keterangan';
    $ruangan->save();

    if ($request->hasFile(GambarDatabaseColumn::UrlGambar->value)) {
      $existingGambar = $ruangan->gambars
        ->sortBy(function ($gambar) {
          preg_match('/_image_(\d+)/', $gambar->url, $matches);
          return isset($matches[1]) ? (int) $matches[1] : 999;
        })
        ->values();

      foreach ($request->file(GambarDatabaseColumn::UrlGambar->value) as $index => $file) {
        if (!$file || !$file->isValid())
          continue;

        try {
          $public_id = $ruangan->id_ruangan . '_image_' . ($index + 1);
          $uploadResult = Cloudinary::upload(
            $file->getRealPath(),
            [
              'folder' => 'spacerent-btp/ruangan-btp/v1',
              'public_id' => $public_id,
              'overwrite' => true
            ]
          );

          if (isset($existingGambar[$index])) {
            $gambar = Gambar::find($existingGambar[$index]->id_gambar);
            if ($gambar) {
              $gambar->url = $uploadResult->getSecurePath();
              $gambar->save();
            }
          } else {
            Gambar::create([
              RuanganDatabaseColumn::IdRuangan->value => $ruangan->id_ruangan,
              GambarDatabaseColumn::UrlGambar->value => $uploadResult->getSecurePath()
            ]);
          }
        } catch (Exception $e) {
          Log::error('Error replacing image in Cloudinary', [
            'message' => $e->getMessage(),
            'file_index' => $index
          ]);
          continue;
        }
      }
    }
  }
}