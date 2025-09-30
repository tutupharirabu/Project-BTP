<?php

namespace Database\Seeders;

use Log;
use Exception;
use App\Models\Gambar;
use App\Models\Ruangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Enums\Database\GambarDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampleImages = File::files(public_path('assets/img/BTP'));

        Ruangan::factory()
            ->count(5)
            ->create()
            ->each(function ($ruangan) use ($sampleImages) {
                $jumlahGambar = rand(1, 5);
                // Pastikan ada file untuk diupload
                for ($i = 0; $i < $jumlahGambar; $i++) {
                    // Pilih file random dari sampleImages
                    $file = $sampleImages[array_rand($sampleImages)];

                    try {
                        $uploadResult = Cloudinary::upload(
                            $file->getRealPath(),
                            [
                                'folder' => 'spacerent-btp/ruangan-btp/v1',
                                'public_id' => $ruangan->id_ruangan . '_image_' . ($i + 1),
                                'transformation' => [
                                    'width' => 1000,
                                    'crop' => 'limit',
                                    'quality' => 'auto:good',
                                    'fetch_format' => 'webp',
                                ]
                            ]
                        );

                        Gambar::create([
                            RuanganDatabaseColumn::IdRuangan->value => $ruangan->id_ruangan,
                            GambarDatabaseColumn::UrlGambar->value => $uploadResult->getSecurePath(),
                        ]);
                    } catch (Exception $e) {
                        Log::error('Cloudinary upload failed: ' . $e->getMessage());
                    }
                }
            });
    }
}
