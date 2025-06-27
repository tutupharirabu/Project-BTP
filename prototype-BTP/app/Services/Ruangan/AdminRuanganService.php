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
    $groupIdRuangan = RuanganDatabaseColumn::GroupIdRuangan->value;
    $keteranganRuangan = RuanganDatabaseColumn::KeteranganRuangan->value;
    $statusRuangan = RuanganDatabaseColumn::StatusRuangan->value;
    $idUsers = UsersDatabaseColumn::IdUsers->value;
    $urlGambar = GambarDatabaseColumn::UrlGambar->value;

    $validatedData = $request->validated();

    if (empty($validatedData[$groupIdRuangan])) {
      $validatedData[$groupIdRuangan] = Str::uuid()->toString();
    }

    $validatedData[$keteranganRuangan] = $request->input($keteranganRuangan) ?? 'Tidak ada keterangan';
    $validatedData[$statusRuangan] = StatusRuangan::Tersedia->value;
    $validatedData[$idUsers] = Auth::id();

    $ruangan = $this->adminRuanganRepository->createRuangan($validatedData);

    if ($request->hasFile($urlGambar)) {
      foreach ($request->file($urlGambar) as $index => $file) {
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
            $urlGambar => $uploadResult->getSecurePath()
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
    $keteranganRuangan = RuanganDatabaseColumn::KeteranganRuangan->value;
    $idUsers = UsersDatabaseColumn::IdUsers->value;
    $urlGambar = GambarDatabaseColumn::UrlGambar->value;

    $validatedData = $request->validated();

    $ruangan->fill($validatedData);
    $ruangan->$idUsers = Auth::id();
    $ruangan->$keteranganRuangan = $request->input($keteranganRuangan) ?? 'Tidak ada keterangan';
    $ruangan->save();

    if ($request->hasFile($urlGambar)) {
      $existingGambar = $ruangan->gambars
        ->sortBy(function ($gambar) {
          preg_match('/_image_(\d+)/', $gambar->url, $matches);
          return isset($matches[1]) ? (int) $matches[1] : 999;
        })
        ->values();

      foreach ($request->file($urlGambar) as $index => $file) {
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
              $urlGambar => $uploadResult->getSecurePath()
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