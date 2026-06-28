-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2026 at 05:50 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rt19_orchid_regency`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_iuran`
--

CREATE TABLE `tb_iuran` (
  `id` int(11) NOT NULL,
  `warga_id` int(11) NOT NULL,
  `bulan` tinyint(2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_bayar` date DEFAULT NULL,
  `metode_bayar` enum('Tunai','Transfer','QRIS') DEFAULT NULL,
  `status` enum('Lunas','Belum Bayar') NOT NULL DEFAULT 'Belum Bayar',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_iuran`
--

INSERT INTO `tb_iuran` (`id`, `warga_id`, `bulan`, `tahun`, `nominal`, `tanggal_bayar`, `metode_bayar`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 2026, '50000.00', '2026-06-25', 'QRIS', 'Lunas', 1, '2026-06-24 08:21:30', '2026-06-25 14:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log_activity`
--

CREATE TABLE `tb_log_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `modul` varchar(50) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_log_activity`
--

INSERT INTO `tb_log_activity` (`id`, `user_id`, `aktivitas`, `modul`, `ip_address`, `created_at`) VALUES
(1, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-23 06:20:11'),
(2, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-23 11:25:43'),
(3, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-23 17:13:11'),
(4, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-24 03:20:30'),
(5, 1, 'Logout dari sistem', 'Auth', '::1', '2026-06-24 03:46:39'),
(6, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-24 03:46:52'),
(7, 1, 'Logout dari sistem', 'Auth', '::1', '2026-06-24 03:59:55'),
(8, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-24 04:38:00'),
(9, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-24 06:27:57'),
(10, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-25 08:53:49'),
(11, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-25 15:25:38'),
(12, 1, 'Logout dari sistem', 'Auth', '::1', '2026-06-25 16:09:18'),
(13, 1, 'Login ke sistem', 'Auth', '::1', '2026-06-25 16:40:16'),
(14, 1, 'Logout dari sistem', 'Auth', '::1', '2026-06-25 17:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `tb_notifikasi`
--

CREATE TABLE `tb_notifikasi` (
  `id` int(11) NOT NULL,
  `warga_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('iuran','pengumuman','surat','umum') DEFAULT 'umum',
  `status_baca` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemasukan`
--

CREATE TABLE `tb_pemasukan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` enum('Iuran Bulanan','Donasi','Sumbangan','Lainnya') NOT NULL DEFAULT 'Iuran Bulanan',
  `keterangan` text DEFAULT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bukti` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pemasukan`
--

INSERT INTO `tb_pemasukan` (`id`, `tanggal`, `kategori`, `keterangan`, `nominal`, `bukti`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2026-06-23', 'Iuran Bulanan', 'anu', '50000.00', NULL, 1, '2026-06-23 12:15:10', '2026-06-23 12:15:10'),
(2, '2026-06-23', 'Donasi', 'aaa', '100000.00', NULL, 1, '2026-06-23 12:15:24', '2026-06-23 12:15:24'),
(3, '2026-06-25', 'Iuran Bulanan', 'Iuran Bpk/Ibu anu Bln 6/2026', '50000.00', NULL, 1, '2026-06-25 14:09:38', '2026-06-25 14:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengajuan_surat`
--

CREATE TABLE `tb_pengajuan_surat` (
  `id` int(11) NOT NULL,
  `nomor_surat` varchar(50) DEFAULT NULL,
  `warga_id` int(11) NOT NULL,
  `jenis_surat` enum('Surat Keterangan Domisili','Surat Pengantar SKCK','Surat Pengantar Nikah','Surat Keterangan Tidak Mampu','Surat Keterangan Usaha') NOT NULL,
  `keperluan` text DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `status` enum('Diajukan','Diproses','Selesai','Ditolak') NOT NULL DEFAULT 'Diajukan',
  `catatan` text DEFAULT NULL,
  `dokumen_pendukung` varchar(255) DEFAULT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengajuan_surat`
--

INSERT INTO `tb_pengajuan_surat` (`id`, `nomor_surat`, `warga_id`, `jenis_surat`, `keperluan`, `tanggal_pengajuan`, `status`, `catatan`, `dokumen_pendukung`, `file_pdf`, `approved_by`, `created_at`, `updated_at`) VALUES
(2, NULL, 1, 'Surat Pengantar SKCK', 'azza', '2026-06-23', 'Diajukan', NULL, NULL, NULL, NULL, '2026-06-23 22:54:01', '2026-06-23 22:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengaturan`
--

CREATE TABLE `tb_pengaturan` (
  `id` int(11) NOT NULL,
  `key_setting` varchar(100) NOT NULL,
  `value_setting` text DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengaturan`
--

INSERT INTO `tb_pengaturan` (`id`, `key_setting`, `value_setting`, `keterangan`) VALUES
(1, 'nama_rt', 'RT-19', 'Nama RT'),
(2, 'nama_perumahan', 'Orchid Regency', 'Nama Perumahan'),
(3, 'alamat_lengkap', 'Perumahan Orchid Regency, Sidoarjo, Jawa Timur', 'Alamat Lengkap'),
(4, 'kelurahan', 'Sidoarjo', 'Kelurahan'),
(5, 'kecamatan', 'Sidoarjo', 'Kecamatan'),
(6, 'kabupaten', 'Sidoarjo', 'Kabupaten'),
(7, 'provinsi', 'Jawa Timur', 'Provinsi'),
(8, 'nominal_iuran', '50000', 'Nominal Iuran Bulanan Default'),
(9, 'batas_bayar', '10', 'Batas Tanggal Pembayaran Iuran'),
(10, 'google_sheet_id', '', 'ID Google Spreadsheet'),
(11, 'google_credentials_path', '', 'Path ke file credentials Google Service Account'),
(12, 'nama_ketua_rt', 'Ketua RT-19', 'Nama Ketua RT'),
(13, 'email_rt', 'rt19orchid@gmail.com', 'Email RT'),
(14, 'wa_gateway_url', '', 'URL WhatsApp Gateway API'),
(15, 'wa_gateway_token', '', 'Token WhatsApp Gateway API');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengeluaran`
--

CREATE TABLE `tb_pengeluaran` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` enum('Kebersihan','Keamanan','Sosial','Infrastruktur','Operasional','Lainnya') NOT NULL DEFAULT 'Operasional',
  `keterangan` text DEFAULT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bukti` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengeluaran`
--

INSERT INTO `tb_pengeluaran` (`id`, `tanggal`, `kategori`, `keterangan`, `nominal`, `bukti`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2026-06-25', 'Kebersihan', 'asas', '50000.00', NULL, 1, '2026-06-25 14:03:20', '2026-06-25 14:03:20');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengumuman`
--

CREATE TABLE `tb_pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_publish` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengumuman`
--

INSERT INTO `tb_pengumuman` (`id`, `judul`, `isi`, `gambar`, `tanggal_publish`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'anu', 'anu', NULL, '2026-06-23', 1, 1, '2026-06-23 12:14:03', '2026-06-23 12:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `tb_role`
--

CREATE TABLE `tb_role` (
  `id` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_role`
--

INSERT INTO `tb_role` (`id`, `nama_role`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Kelola seluruh data, user, warga, keuangan, surat, pengumuman', '2026-06-23 10:19:40', '2026-06-23 10:19:40'),
(2, 'Ketua RT', 'Melihat seluruh laporan, approval surat, monitoring tunggakan', '2026-06-23 10:19:40', '2026-06-23 10:19:40'),
(3, 'Bendahara', 'Kelola pemasukan, pengeluaran, iuran, cetak laporan, sync Google Sheets', '2026-06-23 10:19:40', '2026-06-23 10:19:40'),
(4, 'Sekretaris', 'Kelola surat menyurat, pengumuman, melihat data warga', '2026-06-23 10:19:40', '2026-06-23 10:19:40'),
(5, 'Warga', 'Melihat status pembayaran, mengajukan surat, melihat pengumuman', '2026-06-23 10:19:40', '2026-06-23 10:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `tb_struktur`
--

CREATE TABLE `tb_struktur` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `jabatan` varchar(100) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_struktur`
--

INSERT INTO `tb_struktur` (`id`, `parent_id`, `jabatan`, `nama`, `no_hp`, `foto`, `deskripsi`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Ketua RT', 'Kusuma Widuri', NULL, NULL, NULL, 1, 1, '2026-06-24 09:37:21', '2026-06-24 10:49:06'),
(2, 1, 'Wakil Ketua RT', 'Kamto', NULL, NULL, NULL, 2, 1, '2026-06-24 09:37:21', '2026-06-24 10:49:15'),
(3, 1, 'Bendahara 1', NULL, NULL, NULL, NULL, 3, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04'),
(4, 3, 'Bendahara 2', NULL, NULL, NULL, NULL, 4, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04'),
(5, 1, 'Sekretaris 1', 'Dimas', NULL, NULL, NULL, 5, 1, '2026-06-24 09:37:21', '2026-06-24 10:49:28'),
(6, 5, 'Sekretaris 2', NULL, NULL, NULL, NULL, 6, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04'),
(7, 1, 'SIE Pembangunan', NULL, NULL, NULL, NULL, 7, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04'),
(8, 1, 'SIE Keamanan', NULL, NULL, NULL, NULL, 8, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04'),
(9, 1, 'SIE Konsumsi', NULL, NULL, NULL, NULL, 9, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04'),
(10, 1, 'SIE Seni & Olahraga', NULL, NULL, NULL, NULL, 10, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04'),
(11, 1, 'SIE Pendataan', NULL, NULL, NULL, NULL, 11, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04'),
(12, 1, 'SIE Pendanaan', NULL, NULL, NULL, NULL, 12, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04'),
(13, 1, 'SIE Perlengkapan & Humas', NULL, NULL, NULL, NULL, 13, 1, '2026-06-24 09:37:21', '2026-06-24 10:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role_id`, `foto`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$UILc1DTUS2EosbYezMFZ/.Q8PLSDxn9USVdwPVICh9e6RgSX1zMhm', 'Administrator', 'admin@rt19orchid.id', 1, 'default.png', 1, '2026-06-25 16:40:16', '2026-06-23 10:19:40', '2026-06-25 21:40:16'),
(2, 'ketuart', '$2y$12$UILc1DTUS2EosbYezMFZ/.Q8PLSDxn9USVdwPVICh9e6RgSX1zMhm', 'Ketua RT-19', 'ketuart@rt19orchid.id', 2, 'default.png', 1, NULL, '2026-06-23 10:19:40', '2026-06-23 11:18:48'),
(3, 'bendahara', '$2y$12$UILc1DTUS2EosbYezMFZ/.Q8PLSDxn9USVdwPVICh9e6RgSX1zMhm', 'Bendahara RT-19', 'bendahara@rt19orchid.id', 3, 'default.png', 1, NULL, '2026-06-23 10:19:40', '2026-06-23 11:18:48'),
(4, 'sekretaris', '$2y$12$UILc1DTUS2EosbYezMFZ/.Q8PLSDxn9USVdwPVICh9e6RgSX1zMhm', 'Sekretaris RT-19', 'sekretaris@rt19orchid.id', 4, 'default.png', 1, NULL, '2026-06-23 10:19:40', '2026-06-23 11:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `tb_warga`
--

CREATE TABLE `tb_warga` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nik` varchar(16) NOT NULL,
  `no_kk` varchar(16) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `rt` varchar(5) DEFAULT '019',
  `rw` varchar(5) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status_perkawinan` enum('Belum Kawin','Kawin','Cerai Hidup','Cerai Mati') DEFAULT 'Belum Kawin',
  `pekerjaan` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `status_aktif` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_warga`
--

INSERT INTO `tb_warga` (`id`, `user_id`, `nik`, `no_kk`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `rt`, `rw`, `no_hp`, `email`, `status_perkawinan`, `pekerjaan`, `foto`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, NULL, '111', '111', 'anu', 'Laki-laki', 'anu', '2010-02-02', '111', '019', '', '111', NULL, 'Kawin', 'anu', 'default.png', 1, '2026-06-23 12:16:44', '2026-06-23 12:16:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_iuran`
--
ALTER TABLE `tb_iuran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_iuran` (`warga_id`,`bulan`,`tahun`),
  ADD KEY `idx_bulan_tahun` (`bulan`,`tahun`),
  ADD KEY `idx_status_iuran` (`status`),
  ADD KEY `fk_iuran_user` (`created_by`);

--
-- Indexes for table `tb_log_activity`
--
ALTER TABLE `tb_log_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_user` (`user_id`);

--
-- Indexes for table `tb_notifikasi`
--
ALTER TABLE `tb_notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status_baca` (`status_baca`),
  ADD KEY `fk_notif_warga` (`warga_id`),
  ADD KEY `fk_notif_user` (`user_id`);

--
-- Indexes for table `tb_pemasukan`
--
ALTER TABLE `tb_pemasukan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tanggal_masuk` (`tanggal`),
  ADD KEY `idx_kategori_masuk` (`kategori`),
  ADD KEY `fk_pemasukan_user` (`created_by`);

--
-- Indexes for table `tb_pengajuan_surat`
--
ALTER TABLE `tb_pengajuan_surat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_surat` (`nomor_surat`),
  ADD KEY `idx_status_surat` (`status`),
  ADD KEY `idx_jenis_surat` (`jenis_surat`),
  ADD KEY `fk_surat_warga` (`warga_id`),
  ADD KEY `fk_surat_approved` (`approved_by`);

--
-- Indexes for table `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_setting` (`key_setting`);

--
-- Indexes for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tanggal_keluar` (`tanggal`),
  ADD KEY `idx_kategori_keluar` (`kategori`),
  ADD KEY `fk_pengeluaran_user` (`created_by`);

--
-- Indexes for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tanggal_publish` (`tanggal_publish`),
  ADD KEY `fk_pengumuman_user` (`created_by`);

--
-- Indexes for table `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_struktur`
--
ALTER TABLE `tb_struktur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_urutan` (`urutan`),
  ADD KEY `idx_active` (`is_active`),
  ADD KEY `idx_parent` (`parent_id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- Indexes for table `tb_warga`
--
ALTER TABLE `tb_warga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `idx_no_kk` (`no_kk`),
  ADD KEY `idx_nama` (`nama_lengkap`),
  ADD KEY `idx_rt_rw` (`rt`,`rw`),
  ADD KEY `fk_warga_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_iuran`
--
ALTER TABLE `tb_iuran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_log_activity`
--
ALTER TABLE `tb_log_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tb_notifikasi`
--
ALTER TABLE `tb_notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pemasukan`
--
ALTER TABLE `tb_pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_pengajuan_surat`
--
ALTER TABLE `tb_pengajuan_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_role`
--
ALTER TABLE `tb_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_struktur`
--
ALTER TABLE `tb_struktur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_warga`
--
ALTER TABLE `tb_warga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_iuran`
--
ALTER TABLE `tb_iuran`
  ADD CONSTRAINT `fk_iuran_user` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_iuran_warga` FOREIGN KEY (`warga_id`) REFERENCES `tb_warga` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_log_activity`
--
ALTER TABLE `tb_log_activity`
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_notifikasi`
--
ALTER TABLE `tb_notifikasi`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notif_warga` FOREIGN KEY (`warga_id`) REFERENCES `tb_warga` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pemasukan`
--
ALTER TABLE `tb_pemasukan`
  ADD CONSTRAINT `fk_pemasukan_user` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_pengajuan_surat`
--
ALTER TABLE `tb_pengajuan_surat`
  ADD CONSTRAINT `fk_surat_approved` FOREIGN KEY (`approved_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_surat_warga` FOREIGN KEY (`warga_id`) REFERENCES `tb_warga` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  ADD CONSTRAINT `fk_pengeluaran_user` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  ADD CONSTRAINT `fk_pengumuman_user` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tb_warga`
--
ALTER TABLE `tb_warga`
  ADD CONSTRAINT `fk_warga_user` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
