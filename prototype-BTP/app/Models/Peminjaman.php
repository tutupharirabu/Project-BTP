<?php

namespace App\Models;

use App\Models\Users;
use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Database\UsersDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Database\PeminjamanDatabaseColumn;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Peminjaman extends Model
{
    use HasFactory, HasUuids;
    protected $table = PeminjamanDatabaseColumn::Peminjaman->value;
    protected $primaryKey = PeminjamanDatabaseColumn::IdPeminjaman->value;
    protected $fillable = [
            PeminjamanDatabaseColumn::NamaPenyewa->value,
            PeminjamanDatabaseColumn::StatusPenyewa->value,
            PeminjamanDatabaseColumn::NomorIndukPenyewa->value,
            PeminjamanDatabaseColumn::NomorTeleponPenyewa->value,
            PeminjamanDatabaseColumn::TanggalMulai->value,
            PeminjamanDatabaseColumn::TanggalSelesai->value,
            PeminjamanDatabaseColumn::JumlahPeserta->value,
            PeminjamanDatabaseColumn::TotalHarga->value,
            PeminjamanDatabaseColumn::StatusPeminjamanPenyewa->value,
            PeminjamanDatabaseColumn::KeteranganPenyewaan->value,
            PeminjamanDatabaseColumn::UrlKtp->value,
            PeminjamanDatabaseColumn::UrlKtm->value,
            PeminjamanDatabaseColumn::UrlNpwp->value,
            PeminjamanDatabaseColumn::KtpPublicId->value,
            PeminjamanDatabaseColumn::KtpFormat->value,
            PeminjamanDatabaseColumn::KtmPublicId->value,
            PeminjamanDatabaseColumn::KtmFormat->value,
            PeminjamanDatabaseColumn::NpwpPublicId->value,
            PeminjamanDatabaseColumn::NpwpFormat->value,
            RuanganDatabaseColumn::IdRuangan->value
        ];
    protected $dates = [PeminjamanDatabaseColumn::TanggalMulai->value, PeminjamanDatabaseColumn::TanggalSelesai->value];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, UsersDatabaseColumn::IdUsers->value, UsersDatabaseColumn::IdUsers->value);
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, RuanganDatabaseColumn::IdRuangan->value, RuanganDatabaseColumn::IdRuangan->value);
    }

    protected function generateSignedUrl(?string $publicId, ?string $format): ?string
    {
        if (!$publicId) {
            return null;
        }

        $ttl = (int) config('services.cloudinary.signed_url_ttl', 3600);

        $options = [
            'resource_type' => 'image',
            'type' => 'upload',
        ];

        if ($ttl > 0) {
            $options['expires_at'] = time() + $ttl;
        }

        return Cloudinary::uploadApi()->privateDownloadUrl(
            $publicId,
            $format ?: 'jpg',
            $options
        );
    }

    public function getKtpSignedUrlAttribute(): ?string
    {
        return $this->generateSignedUrl($this->{PeminjamanDatabaseColumn::KtpPublicId->value} ?? null, $this->{PeminjamanDatabaseColumn::KtpFormat->value} ?? null);
    }

    public function getKtmSignedUrlAttribute(): ?string
    {
        return $this->generateSignedUrl($this->{PeminjamanDatabaseColumn::KtmPublicId->value} ?? null, $this->{PeminjamanDatabaseColumn::KtmFormat->value} ?? null);
    }

    public function getNpwpSignedUrlAttribute(): ?string
    {
        return $this->generateSignedUrl($this->{PeminjamanDatabaseColumn::NpwpPublicId->value} ?? null, $this->{PeminjamanDatabaseColumn::NpwpFormat->value} ?? null);
    }
}
