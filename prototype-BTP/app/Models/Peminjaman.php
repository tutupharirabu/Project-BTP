<?php

namespace App\Models;

use App\Models\Users;
use App\Models\Ruangan;
use App\Models\PeminjamanSession;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Database\UsersDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Database\PeminjamanDatabaseColumn;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
            PeminjamanDatabaseColumn::InvoiceNumber->value,
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

    public function sessions(): HasMany
    {
        return $this->hasMany(
            PeminjamanSession::class,
            'peminjaman_id',
            PeminjamanDatabaseColumn::IdPeminjaman->value
        )->orderBy('tanggal_mulai');
    }

    public function getSessionRangesAttribute(): array
    {
        if (!$this->relationLoaded('sessions')) {
            $this->setRelation('sessions', $this->sessions()->get());
        }

        $sessions = $this->getRelation('sessions');

        if ($sessions->isEmpty()) {
            if ($this->{PeminjamanDatabaseColumn::TanggalMulai->value} && $this->{PeminjamanDatabaseColumn::TanggalSelesai->value}) {
                return [
                    Carbon::parse($this->{PeminjamanDatabaseColumn::TanggalMulai->value})->format('H:i') .
                    ' - ' .
                    Carbon::parse($this->{PeminjamanDatabaseColumn::TanggalSelesai->value})->format('H:i'),
                ];
            }

            return [];
        }

        return $sessions->map(function (PeminjamanSession $session) {
            return Carbon::parse($session->tanggal_mulai)->format('H:i') . ' - ' . Carbon::parse($session->tanggal_selesai)->format('H:i');
        })->values()->all();
    }

    public function getSessionRangeStringAttribute(): string
    {
        return implode(', ', $this->session_ranges);
    }

    public static function nextInvoiceNumber(): string
    {
        $now = Carbon::now();
        $prefix = 'INV-' . $now->format('Ymd');

        $latest = static::query()
            ->whereDate(PeminjamanDatabaseColumn::CreatedAt->value, $now->toDateString())
            ->whereNotNull(PeminjamanDatabaseColumn::InvoiceNumber->value)
            ->where(PeminjamanDatabaseColumn::InvoiceNumber->value, 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderBy(PeminjamanDatabaseColumn::InvoiceNumber->value, 'desc')
            ->value(PeminjamanDatabaseColumn::InvoiceNumber->value);

        $nextSequence = $latest
            ? ((int) substr($latest, -4)) + 1
            : 1;

        return sprintf('%s-%04d', $prefix, $nextSequence);
    }

    public function ensureInvoiceNumber(): void
    {
        if ($this->{PeminjamanDatabaseColumn::InvoiceNumber->value}) {
            return;
        }

        $this->getConnection()->transaction(function () {
            $this->refresh();

            if (!$this->{PeminjamanDatabaseColumn::InvoiceNumber->value}) {
                $this->{PeminjamanDatabaseColumn::InvoiceNumber->value} = static::nextInvoiceNumber();
                $this->save();
            }
        });
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
