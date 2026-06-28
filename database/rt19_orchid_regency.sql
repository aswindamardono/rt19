-- ============================================================
-- DATABASE: RT-19 Orchid Regency Management System
-- Version: 1.0.0
-- Engine: MySQL 5.7+ / MariaDB 10.3+
-- Charset: utf8mb4
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+07:00";

-- ============================================================
-- CREATE DATABASE
-- ============================================================
CREATE DATABASE IF NOT EXISTS `rt19_orchid_regency`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `rt19_orchid_regency`;

-- ============================================================
-- TABLE: tb_role
-- ============================================================
DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE `tb_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_role` (`id`, `nama_role`, `deskripsi`) VALUES
(1, 'Super Admin', 'Kelola seluruh data, user, warga, keuangan, surat, pengumuman'),
(2, 'Ketua RT', 'Melihat seluruh laporan, approval surat, monitoring tunggakan'),
(3, 'Bendahara', 'Kelola pemasukan, pengeluaran, iuran, cetak laporan, sync Google Sheets'),
(4, 'Sekretaris', 'Kelola surat menyurat, pengumuman, melihat data warga'),
(5, 'Warga', 'Melihat status pembayaran, mengajukan surat, melihat pengumuman');

-- ============================================================
-- TABLE: tb_users
-- ============================================================
DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `fk_user_role` (`role_id`),
  CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default Super Admin: admin / admin123
INSERT INTO `tb_users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role_id`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@rt19orchid.id', 1),
(2, 'ketuart', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ketua RT-19', 'ketuart@rt19orchid.id', 2),
(3, 'bendahara', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bendahara RT-19', 'bendahara@rt19orchid.id', 3),
(4, 'sekretaris', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sekretaris RT-19', 'sekretaris@rt19orchid.id', 4);

-- ============================================================
-- TABLE: tb_warga
-- ============================================================
DROP TABLE IF EXISTS `tb_warga`;
CREATE TABLE `tb_warga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nik` (`nik`),
  KEY `idx_no_kk` (`no_kk`),
  KEY `idx_nama` (`nama_lengkap`),
  KEY `idx_rt_rw` (`rt`, `rw`),
  KEY `fk_warga_user` (`user_id`),
  CONSTRAINT `fk_warga_user` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: tb_pemasukan
-- ============================================================
DROP TABLE IF EXISTS `tb_pemasukan`;
CREATE TABLE `tb_pemasukan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `kategori` enum('Iuran Bulanan','Donasi','Sumbangan','Lainnya') NOT NULL DEFAULT 'Iuran Bulanan',
  `keterangan` text DEFAULT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bukti` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tanggal_masuk` (`tanggal`),
  KEY `idx_kategori_masuk` (`kategori`),
  KEY `fk_pemasukan_user` (`created_by`),
  CONSTRAINT `fk_pemasukan_user` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: tb_pengeluaran
-- ============================================================
DROP TABLE IF EXISTS `tb_pengeluaran`;
CREATE TABLE `tb_pengeluaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `kategori` enum('Kebersihan','Keamanan','Sosial','Infrastruktur','Operasional','Lainnya') NOT NULL DEFAULT 'Operasional',
  `keterangan` text DEFAULT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `bukti` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tanggal_keluar` (`tanggal`),
  KEY `idx_kategori_keluar` (`kategori`),
  KEY `fk_pengeluaran_user` (`created_by`),
  CONSTRAINT `fk_pengeluaran_user` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: tb_iuran
-- ============================================================
DROP TABLE IF EXISTS `tb_iuran`;
CREATE TABLE `tb_iuran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warga_id` int(11) NOT NULL,
  `bulan` tinyint(2) NOT NULL,
  `tahun` year NOT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tanggal_bayar` date DEFAULT NULL,
  `metode_bayar` enum('Tunai','Transfer','QRIS') DEFAULT NULL,
  `status` enum('Lunas','Belum Bayar') NOT NULL DEFAULT 'Belum Bayar',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_iuran` (`warga_id`, `bulan`, `tahun`),
  KEY `idx_bulan_tahun` (`bulan`, `tahun`),
  KEY `idx_status_iuran` (`status`),
  KEY `fk_iuran_user` (`created_by`),
  CONSTRAINT `fk_iuran_warga` FOREIGN KEY (`warga_id`) REFERENCES `tb_warga` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_iuran_user` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: tb_pengajuan_surat
-- ============================================================
DROP TABLE IF EXISTS `tb_pengajuan_surat`;
CREATE TABLE `tb_pengajuan_surat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomor_surat` (`nomor_surat`),
  KEY `idx_status_surat` (`status`),
  KEY `idx_jenis_surat` (`jenis_surat`),
  KEY `fk_surat_warga` (`warga_id`),
  KEY `fk_surat_approved` (`approved_by`),
  CONSTRAINT `fk_surat_warga` FOREIGN KEY (`warga_id`) REFERENCES `tb_warga` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_surat_approved` FOREIGN KEY (`approved_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: tb_pengumuman
-- ============================================================
DROP TABLE IF EXISTS `tb_pengumuman`;
CREATE TABLE `tb_pengumuman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_publish` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tanggal_publish` (`tanggal_publish`),
  KEY `fk_pengumuman_user` (`created_by`),
  CONSTRAINT `fk_pengumuman_user` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: tb_notifikasi
-- ============================================================
DROP TABLE IF EXISTS `tb_notifikasi`;
CREATE TABLE `tb_notifikasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warga_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('iuran','pengumuman','surat','umum') DEFAULT 'umum',
  `status_baca` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status_baca` (`status_baca`),
  KEY `fk_notif_warga` (`warga_id`),
  KEY `fk_notif_user` (`user_id`),
  CONSTRAINT `fk_notif_warga` FOREIGN KEY (`warga_id`) REFERENCES `tb_warga` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE: tb_pengaturan
-- ============================================================
DROP TABLE IF EXISTS `tb_pengaturan`;
CREATE TABLE `tb_pengaturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_setting` varchar(100) NOT NULL,
  `value_setting` text DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_setting` (`key_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tb_pengaturan` (`key_setting`, `value_setting`, `keterangan`) VALUES
('nama_rt', 'RT-19', 'Nama RT'),
('nama_perumahan', 'Orchid Regency', 'Nama Perumahan'),
('alamat_lengkap', 'Perumahan Orchid Regency, Sidoarjo, Jawa Timur', 'Alamat Lengkap'),
('kelurahan', 'Sidoarjo', 'Kelurahan'),
('kecamatan', 'Sidoarjo', 'Kecamatan'),
('kabupaten', 'Sidoarjo', 'Kabupaten'),
('provinsi', 'Jawa Timur', 'Provinsi'),
('nominal_iuran', '50000', 'Nominal Iuran Bulanan Default'),
('batas_bayar', '10', 'Batas Tanggal Pembayaran Iuran'),
('google_sheet_id', '', 'ID Google Spreadsheet'),
('google_credentials_path', '', 'Path ke file credentials Google Service Account'),
('nama_ketua_rt', 'Ketua RT-19', 'Nama Ketua RT'),
('email_rt', 'rt19orchid@gmail.com', 'Email RT'),
('wa_gateway_url', '', 'URL WhatsApp Gateway API'),
('wa_gateway_token', '', 'Token WhatsApp Gateway API');

-- ============================================================
-- TABLE: tb_log_activity
-- ============================================================
DROP TABLE IF EXISTS `tb_log_activity`;
CREATE TABLE `tb_log_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `modul` varchar(50) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_log_user` (`user_id`),
  CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
