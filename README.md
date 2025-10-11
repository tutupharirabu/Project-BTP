# SpaceRent BTP

Aplikasi manajemen peminjaman dan okupansi ruang BTP yang dibangun dengan Laravel 10, Vite, dan ekosistem Postgres/Redis. Project ini mendukung dua alur pengembangan utama:

- **Laravel Sail (Docker)** untuk lingkungan yang terisolasi dan seragam.
- **PHP lokal (tanpa Docker)** untuk pengembangan ringan dengan `php artisan serve`.

Panduan ini menyesuaikan dengan konfigurasi yang sudah ada di repositori.

## Prasyarat

- Git
- Composer 2.x
- Node.js 20.x + npm (atau jalankan via Sail)
- Jika memakai Sail: Docker Desktop / Podman yang mendukung Compose v2
- Jika tanpa Sail: PHP 8.1 atau 8.2, ekstensi yang diperlukan Laravel, MySQL/MariaDB (atau Postgres), dan Redis

## Persiapan Konfigurasi

1. Duplikasikan file contoh environment dan sesuaikan nilainya.

   ```bash
   cp .env.example .env
   ```

2. Setel variabel dasar:

   ```
   APP_NAME=SpacerentBTP
   APP_ENV=local
   APP_URL=https://SpaceRentBTP-v1.localhost
   ```

3. Tentukan koneksi database, cache, dan queue sesuai mode yang dipakai:

   **Menggunakan Sail (Postgres & Redis di dalam container):**

   ```
   DB_CONNECTION=pgsql
   DB_HOST=pgsql
   DB_PORT=5432
   DB_DATABASE=db_btp
   DB_USERNAME=sail
   DB_PASSWORD=password

   REDIS_HOST=redis
   REDIS_PORT=6379
   REDIS_PASSWORD=null
   ```

   **Menggunakan PHP lokal (MySQL & Redis di host):**

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_btp
   DB_USERNAME=your_user
   DB_PASSWORD=your_password

   REDIS_HOST=127.0.0.1
   REDIS_PORT=6379
   ```

4. Konfigurasikan integrasi pihak ketiga (mis. `CLOUDINARY_URL`, kredensial e-mail) dengan nilai milik Anda sendiri.

5. Generate application key jika belum ada:

   ```bash
   php artisan key:generate
   ```

## Menjalankan dengan Laravel Sail

1. Instal dependensi PHP di host (dibutuhkan sebelum `./vendor/bin/sail` tersedia).

   ```bash
   composer install
   ```

2. Bangun dan jalankan kontainer.

   ```bash
   ./vendor/bin/sail up -d --build
   ```

   Alias `sail` bisa ditambahkan agar perintah lebih singkat:

   ```bash
   alias sail='[ -f sail ] && bash sail || ./vendor/bin/sail'
   ```

3. Jalankan migrasi dan seeder awal.

   ```bash
   sail artisan migrate --seed
   ```

4. Instal dependensi front-end dan mulai Vite dev server (berjalan di dalam kontainer).

   ```bash
   sail npm install
   sail npm run dev
   ```

   Untuk build production gunakan `sail npm run build`.

5. Aplikasi dapat diakses melalui:

   - HTTPS: `https://SpaceRentBTP-v1.localhost`
   - HTTP: `http://localhost`
   - Mailpit: `http://localhost:8025`

   Sertifikat pengembangan tersimpan di `docker/nginx/ssl`. Tambahkan ke trusted root jika ingin menghindari peringatan browser.

6. Hentikan layanan saat selesai.

   ```bash
   sail down
   ```

## Menjalankan tanpa Docker (`php artisan serve`)

1. Pastikan dependency sistem tersedia (PHP 8.1/8.2 dengan ekstensi `pdo_mysql`/`pdo_pgsql`, `bcmath`, `intl`, `pcntl`, `redis`, dan Redis server lokal).

2. Pasang dependency PHP dan JavaScript.

   ```bash
   composer install
   npm install
   ```

3. Jalankan migrasi dan seeder.

   ```bash
   php artisan migrate --seed
   ```

4. Mulai server aplikasi.

   ```bash
   php artisan serve --host=127.0.0.1 --port=8000
   ```

5. Di terminal terpisah jalankan Vite agar asset dimuat.

   ```bash
   npm run dev
   ```

6. Jika memakai queue/cron, jalankan worker yang dibutuhkan:

   ```bash
   php artisan queue:work
   php artisan schedule:work
   ```

## Perintah Harian

- Jalankan ulang cache konfigurasi: `php artisan optimize:clear`
- Pengujian otomatis: `php artisan test`
- Sinkronisasi storage link: `php artisan storage:link`
- Regenerasi sertifikat lokal: `bash docker/nginx/ssl/generate-keys.sh`

## Struktur Docker

- `docker-compose.yml` menjalankan `nginx`, `php-fpm`, `pgsql`, `redis`, dan `mailpit` di jaringan `sail`.
- `docker/php-fpm/Dockerfile.dev` membangun image PHP 8.4 dengan ekstensi tambahan (imagick, redis, memcached, soap, dsb) dan Node.js 20 untuk proses build asset.
- `docker/nginx/sites/dev/laravel.conf` mengarahkan domain `SpaceRentBTP-v1.localhost` ke `public/index.php` dan memaksa HTTPS.

## Tips & Troubleshooting

- Pastikan folder `storage` dan `bootstrap/cache` writable. Sail men-set otomatis, namun pada lingkungan lokal gunakan `chmod -R 775`.
- Jika asset tidak ter-update, jalankan `npm run build` atau hapus `public/build`.
- Ubah port default (80/443/5432) di `.env` apabila bentrok dengan layanan lain.
- Saat mengubah env, jalankan `php artisan config:clear` agar perubahan terbaca.

---

Selamat mengembangkan SpaceRent BTP! Jika menemukan kendala khusus, dokumentasikan di issue tracker proyek ini.
