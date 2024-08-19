-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 19, 2024 at 12:43 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_btp`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gambar`
--

CREATE TABLE `gambar` (
  `id_gambar` int(10) UNSIGNED NOT NULL,
  `id_ruangan` int(10) UNSIGNED DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gambar`
--

INSERT INTO `gambar` (`id_gambar`, `id_ruangan`, `url`, `created_at`, `updated_at`) VALUES
(1, 1, 'ruangan/nI7IlsUCFjSy5Wh6sSToDCHL49kDMDK7aoIOKUPw.jpg', '2024-07-23 04:03:06', '2024-07-23 04:59:30'),
(2, 1, 'ruangan/E1WjY5Cte6jIYCozVmSxE4pItGFFag3YWSG7g8zL.jpg', '2024-07-23 04:03:06', '2024-07-23 04:59:30'),
(3, 1, 'ruangan/tDg1rlSzC7cGXhgd5xFsePF6V31L3jUxgRGOIEPs.jpg', '2024-07-23 04:59:30', '2024-07-23 04:59:30'),
(4, 2, 'ruangan/GdWFF4rlfiXtlNMG1C8nwaEpahwFg6DJZndUqzwf.jpg', '2024-07-23 05:03:57', '2024-07-23 05:03:57'),
(5, 3, 'ruangan/9bOHQKvGyWFk4ycQCgOptPuPtJjGnVjS6n4qMO2p.jpg', '2024-07-23 05:07:07', '2024-07-23 05:07:07'),
(6, 4, 'ruangan/MDkywox9tCDvOrfYMGM0s1dFsYdN2HlVIkMZGyA3.jpg', '2024-07-23 05:20:35', '2024-07-23 05:20:35'),
(7, 5, 'ruangan/bkGUiuU8L6szKyPJgoUxy5E2m3I7IrUgE5ESeNeP.jpg', '2024-07-23 05:27:05', '2024-07-23 05:27:05'),
(8, 6, 'ruangan/XfdxW3kOUkEAQ6pIWBriYNADfaMQ6Jzdq97l15fZ.jpg', '2024-07-23 05:29:19', '2024-07-23 05:29:19'),
(9, 7, 'ruangan/fx9lQYegm9X8h4WjOvpI9xJPdSrMTnGBSvXGqucj.jpg', '2024-07-23 05:31:32', '2024-07-23 05:31:32'),
(10, 8, 'ruangan/uQbERs2ns28URybygj4Q4ytjIef4E3KaBuwsDEf9.jpg', '2024-07-23 05:38:27', '2024-07-23 05:38:27'),
(11, 8, 'ruangan/Cvl3hveporrpbz56zRBvdO1zs5eCZey1j25CbgNT.jpg', '2024-07-23 05:38:27', '2024-07-23 05:38:27'),
(12, 9, 'ruangan/U6oKK4b1cC7Tz5054z5q4MjqKWmptQuDg3gdadk0.jpg', '2024-07-23 05:43:39', '2024-07-23 05:43:39'),
(13, 10, 'ruangan/3r2DRehYyNTd4vcd2eAEjQQprjXfQfvPDiKQWWxJ.jpg', '2024-07-23 05:48:39', '2024-07-23 05:48:39'),
(14, 11, 'ruangan/x0Ybmje89EF2yZG6rMjfw1T8bzOKduPH5DSeX7fz.jpg', '2024-07-23 05:53:48', '2024-07-23 05:53:48'),
(15, 12, 'ruangan/Ff7Vlb9gwdept8UkgujXRSNQhZwhVm8c0hDK2ZhV.jpg', '2024-07-23 05:58:43', '2024-07-23 05:58:43'),
(16, 13, 'ruangan/SqsgmylKw3GfItPzzto7JeNCUwuqjKunlg7H1YZU.jpg', '2024-07-23 06:06:51', '2024-07-23 06:06:51'),
(17, 14, 'ruangan/TfnIrLlFUhAhVIEQjtLTaEPN5SId9cy74Qs3ikRs.jpg', '2024-07-23 06:09:38', '2024-07-23 06:09:38'),
(18, 15, 'ruangan/amQxR45NvzOJAzNzVM8RBoHu5Niuv35FZfrQUiAr.jpg', '2024-07-23 06:12:45', '2024-07-23 06:12:45'),
(19, 16, 'ruangan/4kaVWwCiQg99rTxgz0CvILlW7atfs9AMnHsz5r5c.jpg', '2024-07-23 06:17:59', '2024-07-23 06:17:59'),
(21, 18, 'ruangan/QpMaJyVsZ87FdVJisaVKzkDE3orbi9oCnPs62LDQ.jpg', '2024-08-15 08:55:29', '2024-08-15 17:29:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_03_28_135521_create_users_table', 1),
(5, '2024_03_29_072615_create_ruangan_table', 1),
(6, '2024_04_28_140654_create_peminjaman_table', 1),
(7, '2024_05_01_164322_create_gambar_table', 1),
(15, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(16, '2019_08_19_000000_create_failed_jobs_table', 1),
(17, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(18, '2024_03_28_135521_create_users_table', 1),
(19, '2024_03_29_072615_create_ruangan_table', 1),
(20, '2024_04_28_140654_create_peminjaman_table', 1),
(21, '2024_05_01_164322_create_gambar_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(10) UNSIGNED NOT NULL,
  `id_users` int(10) UNSIGNED DEFAULT NULL,
  `nama_peminjam` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `nomor_induk` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `id_ruangan` int(10) UNSIGNED DEFAULT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `total_harga` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_users`, `nama_peminjam`, `role`, `nomor_induk`, `nomor_telepon`, `id_ruangan`, `tanggal_mulai`, `tanggal_selesai`, `jumlah`, `total_harga`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, NULL, 'salsa', 'Mahasiswa', '1303200053', '082253072253', 2, '2024-08-15 08:00:00', '2024-08-15 12:00:00', 13, 'Rp 335.500', 'Menunggu', 'tes', '2024-08-15 08:23:39', '2024-08-15 08:23:39'),
(2, NULL, 'udin', 'Pegawai', '12345678910', '081235678910', 2, '2024-08-16 08:00:00', '2024-08-17 10:30:00', 4, 'Rp 2.500', 'Menunggu', 'tes', '2024-08-15 08:33:23', '2024-08-15 08:33:23'),
(3, NULL, 'umar', 'Mahasiswa', '1303200053', '082253072253', 2, '2024-08-17 08:00:00', '2024-08-17 12:00:00', 4, 'Rp 335.500', 'Menunggu', 'tes', '2024-08-15 08:38:30', '2024-08-15 08:38:30'),
(4, NULL, 'ahmad', 'Pegawai', '123456789010', '0812345678910', 2, '2024-08-15 08:00:00', '2024-08-16 11:30:00', 2, 'Rp 0', 'Menunggu', 'tes', '2024-08-15 08:40:43', '2024-08-15 08:40:43'),
(5, NULL, 'salsa', 'Umum', '0', '0812345678910', 2, '2024-08-15 08:00:00', '2024-08-15 12:00:00', 3, 'Rp 335.500', 'Menunggu', 'tes', '2024-08-15 09:43:59', '2024-08-15 09:43:59'),
(6, NULL, 'udin', 'Pegawai', '1303200053', '082253072253', 15, '2024-08-15 08:00:00', '2024-08-16 10:00:00', 3, 'Rp 0', 'Menunggu', '8', '2024-08-15 09:45:05', '2024-08-15 09:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(10) UNSIGNED NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL,
  `ukuran` varchar(255) NOT NULL,
  `kapasitas_minimal` bigint(20) NOT NULL,
  `kapasitas_maksimal` bigint(20) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `harga_ruangan` varchar(255) NOT NULL,
  `tersedia` tinyint(1) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `id_users` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `ukuran`, `kapasitas_minimal`, `kapasitas_maksimal`, `satuan`, `lokasi`, `harga_ruangan`, `tersedia`, `keterangan`, `status`, `id_users`, `created_at`, `updated_at`) VALUES
(1, 'R PLC (B205)', '5 x 5', 1, 10, 'Seat / Bulan', 'Gedung B', '1000000', 1, '~', 'Tersedia', 1, '2024-07-23 04:03:06', '2024-08-15 08:56:35'),
(2, 'R Training (B204)', '7 X 5', 1, 20, 'Halfday / 4 Jam', 'Gedung B', '300000', 1, '• Full AC\r\n• LCD Proyektor', 'Tersedia', 1, '2024-07-23 05:03:57', '2024-08-15 09:11:22'),
(3, 'Private 10 (B206)', '3,5 X 5', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 05:07:07', '2024-08-15 09:06:26'),
(4, 'Private 8 (B202)', '3,4 X 3,2', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 05:20:35', '2024-08-15 09:06:04'),
(5, 'Private 9 (B203)', '5 X 3,3', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 05:27:05', '2024-08-15 09:05:47'),
(6, 'Private 12 (B208)', 'Bentuk 1: 6,5 X 5; Bentuk 2: 1,8 X 3,4', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 05:29:19', '2024-08-15 09:05:29'),
(7, 'Private 11 (B207)', '3,5 X 5', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 05:31:32', '2024-08-15 09:05:13'),
(8, 'R Rapat / Training (B201 A dan B201 B)', '16,5 X 6,5', 10, 30, 'Halfday / 4 Jam', 'Gedung B', '500000', 1, '• Full AC\r\n• LCD Proyektor', 'Tersedia', 1, '2024-07-23 05:38:27', '2024-08-15 09:10:41'),
(9, 'Private 6 (B110)', '5 X 5', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 05:43:39', '2024-08-15 09:04:47'),
(10, 'Private 7 (B111)', '3,6 X 3', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 05:48:39', '2024-08-15 09:04:27'),
(11, 'Coworking Space 2(B108 - B109)', '10,5 X 5', 10, 30, 'Seat / Bulan', 'Gedung B', '350000', 1, '• Internet\r\n• Mini Longue\r\n• Full AC\r\n• Free Parking\r\n• Meeting Room\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 05:53:48', '2024-08-15 09:08:32'),
(12, 'Private 4 (B104)', '5 X 5', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 05:58:43', '2024-08-15 09:03:59'),
(13, 'Private 3 (B103)', '5 X 5,5', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 06:06:51', '2024-08-15 09:03:42'),
(14, 'Private 2 (B102)', '5 X 5', 1, 4, 'Seat / Bulan', 'Gedung B', '1000000', 1, '• Alamat Strategis \r\n• Titik Pertemuan \r\n• Internet\r\n• Full AC\r\n• Free Parking\r\n• Access Card\r\n• 24/7 Security\r\n• Musholla\r\n• Mini Longue\r\n• Meeting Room\r\n• Networking\r\n• Pantry', 'Tersedia', 1, '2024-07-23 06:09:38', '2024-08-15 09:03:17'),
(15, 'R Rapat (B105)', '5 X 6', 1, 4, 'Halfday / 4 Jam', 'Gedung B', '500000', 1, '• Tempat nyaman dan bersih\r\n• LCD Proyektor\r\n• Papan Tulis\r\n• Layar atau TV', 'Tersedia', 1, '2024-07-23 06:12:45', '2024-08-15 08:59:49'),
(16, 'Multimedia (A)', '5 X 5', 10, 60, 'Halfday / 4 Jam', 'Gedung A', '500000', 1, '• Internet\r\n• Full AC\r\n• LCD Proyektor\r\n• Sound System', 'Tersedia', 1, '2024-07-23 06:17:59', '2024-08-15 08:58:06'),
(18, 'Aula(C)', '5 x 5', 80, 120, 'Halfday / 4 Jam', 'Gedung C', '650000', 1, '• Full AC\r\n• Internet\r\n• LCD Proyektor\r\n• Sound System', 'Tersedia', 2, '2024-08-15 08:55:29', '2024-08-15 17:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `username`, `email`, `role`, `nama_lengkap`, `password`, `created_at`, `updated_at`) VALUES
(1, 'dhilPetugas', 'dhilPetugas@gmail.com', 'petugas', 'Muhammad Fadhil Ardiansyah Supiyan', '$2y$12$O1tWJ0stOp.Pw6Ocgn/zQOEjh5peOcdkmyt4IN2kzuMLIybhtUnuG', '2024-08-03 16:26:14', '2024-08-03 16:26:14'),
(2, 'admin', 'admin@gmail.com', 'petugas', 'Admin', '$2y$12$maAe3/aZ4N5Dav/xFpmCouULgSoj6eUwnSykxslLcIAZ1bqxqpaL2', '2024-08-15 17:25:06', '2024-08-15 17:25:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`id_gambar`),
  ADD KEY `gambar_id_ruangan_foreign` (`id_ruangan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `peminjaman_id_users_foreign` (`id_users`),
  ADD KEY `peminjaman_id_ruangan_foreign` (`id_ruangan`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`),
  ADD KEY `ruangan_id_users_foreign` (`id_users`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gambar`
--
ALTER TABLE `gambar`
  MODIFY `id_gambar` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gambar`
--
ALTER TABLE `gambar`
  ADD CONSTRAINT `gambar_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`),
  ADD CONSTRAINT `peminjaman_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD CONSTRAINT `ruangan_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
