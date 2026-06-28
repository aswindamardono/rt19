-- ============================================================
-- TABLE: tb_struktur (Struktur Organisasi RT-19)
-- Jalankan sekali via phpMyAdmin / MySQL CLI
-- ============================================================

USE `rt19_orchid_regency`;

CREATE TABLE IF NOT EXISTS `tb_struktur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(100) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_urutan` (`urutan`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed 13 jabatan default
INSERT INTO `tb_struktur` (`jabatan`, `nama`, `urutan`) VALUES
('Ketua RT',                    NULL,  1),
('Wakil Ketua RT',              NULL,  2),
('Bendahara 1',                 NULL,  3),
('Bendahara 2',                 NULL,  4),
('Sekretaris 1',                NULL,  5),
('Sekretaris 2',                NULL,  6),
('SIE Pembangunan',             NULL,  7),
('SIE Keamanan',                NULL,  8),
('SIE Konsumsi',                NULL,  9),
('SIE Seni & Olahraga',         NULL, 10),
('SIE Pendataan',               NULL, 11),
('SIE Pendanaan',               NULL, 12),
('SIE Perlengkapan & Humas',    NULL, 13);
