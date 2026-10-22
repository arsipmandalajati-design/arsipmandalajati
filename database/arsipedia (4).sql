-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260707.3e756d69dd
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 20, 2026 at 10:44 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arsipedia`
--

-- --------------------------------------------------------

--
-- Table structure for table `agendas`
--

CREATE TABLE `agendas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `penyelenggara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tempat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notulen` text COLLATE utf8mb4_unicode_ci,
  `surat_masuk_id` bigint UNSIGNED DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `materi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kebutuhan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_wa` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penanggung_jawab` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokumentasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kursi` int DEFAULT '0',
  `meja` int DEFAULT '0',
  `proyektor` int DEFAULT '0',
  `mic` int DEFAULT '0',
  `sound_system` int DEFAULT '0',
  `kabel_roll` int DEFAULT '0',
  `lainnya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasil_kegiatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hasil_materi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jumlah_peserta` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agendas`
--

INSERT INTO `agendas` (`id`, `user_id`, `nama_kegiatan`, `tanggal`, `penyelenggara`, `keterangan`, `created_at`, `updated_at`, `tempat`, `status`, `notulen`, `surat_masuk_id`, `jam_mulai`, `jam_selesai`, `materi`, `kebutuhan`, `status_wa`, `penanggung_jawab`, `dokumentasi`, `kursi`, `meja`, `proyektor`, `mic`, `sound_system`, `kabel_roll`, `lainnya`, `hasil_kegiatan`, `hasil_materi`, `catatan`, `jumlah_peserta`) VALUES
(8, 1, 'PETUGASAN', '2026-08-26', 'Kelurahan JatiHandap', 'cgdhfhj', '2026-08-24 10:46:35', '2026-08-24 10:46:35', 'Aula Kecamatan', 'Terjadwal', NULL, 27, '08:00:00', '12:00:00', 'RAPAT EVALUASI', NULL, NULL, NULL, NULL, 80, 2, 2, 2, 2, 2, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `arsips`
--

CREATE TABLE `arsips` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_arsip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_arsip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_arsip` date NOT NULL,
  `file_arsip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nomor_registrasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retensi_tahun` int NOT NULL DEFAULT '5',
  `tanggal_kadaluarsa` date DEFAULT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arsips`
--

INSERT INTO `arsips` (`id`, `kode_arsip`, `nama_arsip`, `tanggal_arsip`, `file_arsip`, `created_at`, `updated_at`, `nomor_registrasi`, `retensi_tahun`, `tanggal_kadaluarsa`, `kategori`) VALUES
(19, 'No.HM.03.01/001-Subbag.Umum-Kec.MDLJ/T/VIII/2026', 'PETUGASAN', '2026-08-24', 'surat_masuk/8QsuTJipwUetoNTh3vzTT8n5X6rUr5H0FUtCF5Je.pdf', '2026-08-24 10:46:35', '2026-08-24 10:46:35', 'No.HM.03.01/001-Subbag.Umum-Kec.MDLJ/T/VIII/2026', 5, NULL, 'Surat Masuk'),
(20, 'No.HM.03.01/002-Subbag.Umum-Kec.MDLJ/T/VIII/2026', 'SURAT PEMOHONAN', '2026-08-18', 'surat_masuk/HPbHPkCmGSOXbvHECPGEObrRyZGKRCfcuAFXbnML.pdf', '2026-08-24 10:51:12', '2026-08-24 10:51:12', 'No.HM.03.01/002-Subbag.Umum-Kec.MDLJ/T/VIII/2026', 5, NULL, 'Surat Masuk');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-adminarsip@gmail.com|127.0.0.1', 'i:1;', 1782912361),
('laravel-cache-adminarsip@gmail.com|127.0.0.1:timer', 'i:1782912361;', 1782912361);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kode_arsips`
--

CREATE TABLE `kode_arsips` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_arsip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kode_arsips`
--

INSERT INTO `kode_arsips` (`id`, `kode`, `nama_arsip`, `created_at`, `updated_at`) VALUES
(2, 'HM.01', 'Penerangan dan Publikasi ', NULL, NULL),
(3, 'HM.02', 'Dengar Pendapat/Hearing ', NULL, NULL),
(4, 'HM.03', 'Hubungan Antar Lembaga', NULL, NULL),
(5, 'HM.03.01', 'Forkompimda ', NULL, NULL),
(6, 'HM.03.02', 'Organisasi Kearsipan Nasional dan Internasional ', NULL, NULL),
(7, 'HM.03.03', 'Instansi Vertikal ', NULL, NULL),
(8, 'HM.03.04', 'Organisasi Kemasyarakatan ', NULL, NULL),
(9, 'HM.03.05', 'Perguruan Tinggi/Sekolah', NULL, NULL),
(10, 'HM.03.06', 'Partai Politik ', NULL, NULL),
(11, 'HM.03.07', 'Swasta ', NULL, NULL),
(12, 'HM.03.08', 'Bakohumas ', NULL, NULL),
(13, 'HM.04', 'Keprotokolan ', NULL, NULL),
(14, 'HM.04.01', 'Upacara/Acara Kedinasan ', NULL, NULL),
(15, 'HM.04.02', 'Kunjungan ', NULL, NULL),
(16, 'HM.04.03', 'Agenda Pimpinan', NULL, NULL),
(17, 'HM.05', 'Dokumentasi dan Penerbitan', NULL, NULL),
(18, 'HM.06', 'Penghargaan/Tanda Kenang-kenangan', NULL, NULL),
(19, 'HM.07', 'Ucapan ', NULL, NULL),
(20, 'HM.08', 'Dokumen Hosting ', NULL, NULL),
(21, 'HK', 'Hukum', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `slug`, `route`, `icon`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'dashboard', 'dashboard', 'bi bi-grid', 1, NULL, NULL),
(2, 'Data User', 'users', 'users.index', 'bi bi-people', 2, NULL, NULL),
(3, 'Data Pejabat', 'pejabat', 'pejabat.index', 'bi bi-person-badge', 3, NULL, NULL),
(4, 'Kode Arsip', 'kodearsip', 'kodearsip.index', 'bi bi-folder', 4, NULL, NULL),
(5, 'Data Arsip', 'arsip', 'arsip.index', 'bi bi-folder', 5, NULL, NULL),
(6, 'Surat Masuk', 'suratmasuk', 'suratmasuk.index', 'bi bi-envelope-open', 6, NULL, NULL),
(7, 'Surat Keluar', 'suratkeluar', 'suratkeluar.index', 'bi bi-envelope-arrow-up', 7, NULL, NULL),
(8, 'Agenda Kegiatan', 'agenda', 'agenda.index', 'bi bi-calendar-event', 8, NULL, NULL),
(9, 'Laporan', 'laporan', 'laporan.index', 'bi bi-file-earmark-text', 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_24_075607_create_roles_table', 1),
(5, '2026_05_24_075616_create_pejabats_table', 1),
(6, '2026_05_24_075639_create_surat_keluars_table', 1),
(7, '2026_05_24_075702_create_agendas_table', 1),
(8, '2026_05_26_133526_add_role_to_users_table', 1),
(9, '2026_05_27_045131_create_surat_masuks_table', 1),
(10, '2026_05_27_061731_create_arsips_table', 1),
(11, '2026_05_27_120026_add_file_surat_to_surat_masuks_table', 1),
(12, '2026_05_27_125821_create_kode_arsips_table', 1),
(13, '2026_05_28_035557_add_kode_arsip_id_to_surat_masuks_table', 1),
(14, '2026_05_28_103844_add_judul_to_surat_masuks_table', 1),
(15, '2026_05_28_135440_add_kode_arsip_id_to_surat_keluars_table', 2),
(16, '2026_06_20_032735_add_disposisi_to_surat_masuks_table', 2),
(17, '2026_06_20_043202_create_surat_keluars_table', 3),
(18, '2026_06_23_145609_create_arsips_table', 3),
(19, '2026_07_05_215648_create_notifications_table', 4),
(20, '2026_07_06_202701_add_reference_id_to_notifications_table', 4),
(21, '2026_06_30_074711_add_role_to_users_table', 4),
(22, '2026_06_30_103843_add_photo_to_users_table', 4),
(23, '2026_07_04_163921_add_status_disposisi_to_surat_masuks_table', 4),
(24, '2026_07_04_181036_change_catatan_admin_nullable_on_surat_masuks', 4),
(25, '2026_07_04_210201_update_agendas_table', 4),
(26, '2026_07_04_213246_add_booking_fields_to_surat_masuk_table', 4),
(27, '2026_07_05_123540_update_surat_masuk_id_nullable_on_agendas', 4),
(28, '2026_07_05_145527_change_dokumentasi_nullable_on_agendas', 4),
(29, '2026_07_05_170837_update_agendas_add_kebutuhan', 4),
(30, '2026_07_05_172855_add_kebutuhan_to_agendas_table', 4),
(31, '2026_07_05_173710_add_nomor_wa_to_users_table', 4),
(32, '2026_07_05_215648_create_notifications_table', 4),
(33, '2026_07_06_140803_add_booking_fields_to_surat_masuks_table', 4),
(34, '2026_07_06_142334_add_kegiatan_to_surat_masuks_table', 4),
(35, '2026_07_06_143509_change_lampiran_nullable_on_agendas_table', 4),
(36, '2026_07_06_143611_drop_lampiran_from_agendas_table', 4),
(37, '2026_07_06_182927_add_materi_dokumentasi_to_agendas_table', 4),
(38, '2026_07_06_183658_add_reference_to_notifications_table', 4),
(39, '2026_07_06_202701_add_reference_id_to_notifications_table', 4),
(40, '2026_07_09_011926_add_detail_surat_to_surat_masuks_table', 5),
(41, '2026_07_11_095729_add_booking_columns_to_surat_masuks_table', 6),
(42, '2026_07_12_211552_add_hasil_to_agendas_table', 7),
(43, '2026_07_20_114542_update_surat_masuks_table', 8),
(44, '2026_07_20_153703_add_nomor_urut_to_surat_masuks_table', 8),
(45, '2026_07_20_154616_add_nomor_registrasi_to_surat_masuks_table', 8),
(46, '2026_07_23_211306_add_disposisi_fields_to_surat_keluars_table', 8),
(47, '2026_07_24_165953_add_logistik_to_agendas_table', 9),
(48, '2026_07_24_231220_add_notulen_to_agendas_table', 10),
(49, '2026_07_25_211505_add_retensi_to_arsips_table', 11),
(50, '2026_07_25_212423_add_tanggal_kadaluarsa_to_arsips_table', 12),
(51, '2026_07_30_125409_create_menus_table', 12),
(52, '2026_07_30_125409_create_role_menu_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reference_id` bigint UNSIGNED DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `judul`, `pesan`, `jenis`, `reference_id`, `is_read`, `created_at`, `updated_at`) VALUES
(4, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"RAPAT\".', 'surat', 8, 1, '2026-07-11 02:23:51', '2026-07-24 10:33:53'),
(5, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"RAPAT\".', 'surat', 9, 1, '2026-07-11 02:59:44', '2026-07-24 10:33:53'),
(6, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"Surat Undangan\".', 'surat', 10, 1, '2026-07-11 03:05:35', '2026-07-24 10:33:53'),
(12, 1, 'Agenda Baru', 'Pegawai Kecamatan membuat agenda \"RAPAT\".', 'agenda', 3, 1, '2026-07-11 12:03:09', '2026-07-24 10:33:53'),
(13, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"PETUGASAN\".', 'surat', 14, 1, '2026-07-11 15:04:44', '2026-07-24 10:33:53'),
(14, 1, 'Agenda Dihapus', 'Agenda \"Rapat\" telah dihapus.', 'agenda', NULL, 1, '2026-07-12 13:46:02', '2026-07-24 10:33:53'),
(18, 1, 'Agenda Baru', 'Pegawai Kecamatan membuat agenda \"RAPAT\".', 'agenda', 4, 1, '2026-07-12 16:06:44', '2026-07-24 10:33:53'),
(19, 1, 'Agenda Diperbarui', 'Agenda \"RAPAT\" berhasil diperbarui.', 'agenda', 4, 1, '2026-07-12 16:07:27', '2026-07-24 10:33:53'),
(20, 1, 'Agenda Dihapus', 'Agenda \"RAPAT\" telah dihapus.', 'agenda', NULL, 1, '2026-07-12 16:14:46', '2026-07-24 10:33:53'),
(24, 1, 'Agenda Dihapus', 'Agenda \"PETUGASAN\" telah dihapus.', 'agenda', NULL, 1, '2026-07-24 10:36:13', '2026-07-26 15:14:19'),
(25, 1, 'Agenda Dihapus', 'Agenda \"RAPAT\" telah dihapus.', 'agenda', NULL, 1, '2026-07-24 10:36:20', '2026-07-26 15:14:19'),
(27, 1, 'Agenda Dihapus', 'Agenda \"BANTUAN\" telah dihapus.', 'agenda', NULL, 1, '2026-07-25 14:10:09', '2026-07-26 15:14:19'),
(28, 1, 'Agenda Dihapus', 'Agenda \"Surat Undangan\" telah dihapus.', 'agenda', NULL, 1, '2026-07-25 14:10:14', '2026-07-26 15:14:19'),
(37, 1, 'Surat Masuk Baru', 'EVY OKTAVIYANTI, S.STP., MM menambahkan surat \"PETUGASAN\".', 'surat', 27, 1, '2026-08-24 10:46:35', '2026-09-08 07:56:28'),
(38, 1, 'Disposisi Baru', 'Anda menerima disposisi surat \"PETUGASAN\".', 'surat', 27, 1, '2026-08-24 10:47:06', '2026-09-08 07:56:28'),
(39, 1, 'Surat Masuk Baru', 'EVY OKTAVIYANTI, S.STP., MM menambahkan surat \"SURAT PEMOHONAN\".', 'surat', 28, 1, '2026-08-24 10:51:12', '2026-09-08 07:56:28'),
(40, 1, 'Disposisi Baru', 'Anda menerima disposisi surat \"SURAT PEMOHONAN\".', 'surat', 28, 1, '2026-08-24 10:51:43', '2026-09-08 07:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pejabats`
--

CREATE TABLE `pejabats` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pejabat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanda_tangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `golongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pejabats`
--

INSERT INTO `pejabats` (`id`, `nama_pejabat`, `nip`, `jabatan`, `tanda_tangan`, `created_at`, `updated_at`, `user_id`, `golongan`, `unit_kerja`) VALUES
(2, NULL, '197102082007011012', 'Kepala Sub Bagian Umum, Kepegawaian, Data dan Informasi Kec. Mandalajati', NULL, '2026-07-26 11:15:59', '2026-07-26 11:15:59', 2, 'III/b', 'Sub Bagian Umum dan Kepegawaian'),
(3, NULL, '198007132011012004', 'Kepala Seksi Kesejahteraan Sosial Kec. Mandalajati', NULL, '2026-07-26 11:19:34', '2026-07-26 11:19:34', 4, 'III/d', 'Seksi Kesejahteraan Sosial (Kesos)'),
(4, NULL, '19999', 'Camat Mandalajati', NULL, '2026-07-29 14:19:59', '2026-07-29 14:19:59', 1, '1', 'Kepala Kecamatan Mandalajati');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `module`) VALUES
(31, 'lihat', 'dashboard'),
(32, 'lihat', 'suratmasuk'),
(33, 'tambah', 'suratmasuk'),
(34, 'ubah', 'suratmasuk'),
(35, 'disposisi', 'suratmasuk'),
(36, 'hapus', 'suratmasuk'),
(37, 'lihat', 'suratkeluar'),
(38, 'tambah', 'suratkeluar'),
(39, 'ubah', 'suratkeluar'),
(40, 'verifikasi', 'suratkeluar'),
(41, 'hapus', 'suratkeluar'),
(42, 'lihat', 'agenda'),
(43, 'tambah', 'agenda'),
(44, 'ubah', 'agenda'),
(45, 'hapus', 'agenda'),
(46, 'lihat', 'users'),
(47, 'tambah', 'users'),
(48, 'ubah', 'users'),
(49, 'hapus', 'users'),
(50, 'lihat', 'pejabat'),
(51, 'tambah', 'pejabat'),
(52, 'ubah', 'pejabat'),
(53, 'hapus', 'pejabat'),
(54, 'lihat', 'kodearsip'),
(55, 'tambah', 'kodearsip'),
(56, 'ubah', 'kodearsip'),
(57, 'hapus', 'kodearsip'),
(58, 'lihat', 'arsip'),
(59, 'tambah', 'arsip'),
(60, 'ubah', 'arsip'),
(61, 'hapus', 'arsip'),
(62, 'cetak', 'laporan'),
(63, 'lihat', 'laporan');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nama_role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2026-07-30 07:14:33', '2026-07-30 07:14:33'),
(2, 'Pegawai', '2026-07-30 07:14:33', '2026-07-30 07:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 37),
(2, 38),
(2, 39),
(2, 42),
(2, 43),
(2, 44),
(2, 54),
(2, 58),
(2, 59),
(2, 60);

-- --------------------------------------------------------

--
-- Table structure for table `role_menu`
--

CREATE TABLE `role_menu` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_menu`
--

INSERT INTO `role_menu` (`id`, `role_id`, `menu_id`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 2, 6, 0, NULL, NULL),
(9, 1, 7, 0, NULL, NULL),
(10, 1, 8, 0, NULL, NULL),
(12, 1, 5, 0, NULL, NULL),
(13, 1, 4, 0, NULL, NULL),
(14, 1, 3, 0, NULL, NULL),
(17, 2, 7, 0, NULL, NULL),
(18, 2, 8, 0, NULL, NULL),
(19, 2, 1, 0, NULL, NULL),
(21, 1, 2, 0, NULL, NULL),
(24, 1, 1, 0, NULL, NULL),
(25, 1, 9, 0, NULL, NULL),
(27, 1, 6, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CUMeRfGL75PMjY2aD27yqMryh0ffRjUz6KHprgh0', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibjhHRVlzWjRBemtQNnJENTRrdTlIWFRaT0dzY0NlMmU2YVp2bTVBSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcnNpcCI7czo1OiJyb3V0ZSI7czoxMToiYXJzaXAuaW5kZXgiO31zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1782896962),
('D2sA6IUFrHi7H6D1n8RWnfQtA8kTdqZLBktwQvnf', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieEJrUUFJV3ZIQXZ2czNKWVZLTVVDcXRGa3EwR21HdWVKUk9BQmZqWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1782999543),
('gT2AAXdipFcKNW3B8R76pHCkvNIVVQTDeEQOUvLl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiczR2MmZETmZlUGFrTnV2VWNFR0hMZEFGZXB2c2tKR1BzeFFCQm5OaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1782912302),
('xRq94xlQv8OZFc9n5drRrcmFFRbTqLBeckRcw3kz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZVhqWjhOQUI3WDRkZENRY01ic3FUT1A0WEIzQmZKcEJGaURTUEdYNCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3VzZXJzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VycyI7czo1OiJyb3V0ZSI7czoxMToidXNlcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1782877391);

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluars`
--

CREATE TABLE `surat_keluars` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kode_arsip_id` bigint UNSIGNED DEFAULT NULL,
  `nomor_urut` int DEFAULT NULL,
  `nomor_registrasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum ACC',
  `user_disposisi_id` bigint UNSIGNED DEFAULT NULL,
  `catatan_disposisi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `disposisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_keluars`
--

INSERT INTO `surat_keluars` (`id`, `user_id`, `kode_arsip_id`, `nomor_urut`, `nomor_registrasi`, `nomor_surat`, `judul`, `tujuan`, `tanggal_surat`, `perihal`, `file_surat`, `status`, `user_disposisi_id`, `catatan_disposisi`, `created_at`, `updated_at`, `disposisi`) VALUES
(8, 1, 3, NULL, NULL, '001.PEL', 'SURAT TUGAS', 'KELURAHAN', '2026-08-25', 'TUGAS SASAPU', 'surat_keluar/xJ9K70u4nK4sdUtWUOir028896Q1FR8mDu3jqIWf.pdf', 'Belum ACC', NULL, NULL, '2026-08-26 15:33:40', '2026-08-26 15:33:40', '-');

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuks`
--

CREATE TABLE `surat_masuks` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_registrasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nomor_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_manual` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tanggal_kadaluarsa` date DEFAULT NULL,
  `tanggal_diterima` date DEFAULT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_arsip_id` bigint UNSIGNED NOT NULL,
  `nomor_urut` int DEFAULT NULL,
  `jenis_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sumber_arsip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disposisi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tgl_batas_disposisi` date DEFAULT NULL,
  `pejabat_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Menunggu Verifikasi',
  `status_acc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `user_disposisi_id` bigint UNSIGNED DEFAULT NULL,
  `catatan_admin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tempat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_kegiatan` date DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `materi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jumlah_peserta` int NOT NULL DEFAULT '0',
  `kursi` int NOT NULL DEFAULT '0',
  `meja` int NOT NULL DEFAULT '0',
  `proyektor` int NOT NULL DEFAULT '0',
  `mic` int NOT NULL DEFAULT '0',
  `lainnya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_surat_asal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_masuks`
--

INSERT INTO `surat_masuks` (`id`, `nomor_registrasi`, `user_id`, `nomor_surat`, `nomor_manual`, `pengirim`, `tanggal_surat`, `tanggal_kadaluarsa`, `tanggal_diterima`, `perihal`, `created_at`, `updated_at`, `file_surat`, `kode_arsip_id`, `nomor_urut`, `jenis_surat`, `sumber_arsip`, `judul`, `disposisi`, `tgl_batas_disposisi`, `pejabat_id`, `status`, `status_acc`, `user_disposisi_id`, `catatan_admin`, `tempat`, `tanggal_kegiatan`, `jam_mulai`, `jam_selesai`, `materi`, `jumlah_peserta`, `kursi`, `meja`, `proyektor`, `mic`, `lainnya`, `no_surat_asal`) VALUES
(27, 'No.HM.03.01/001-Subbag.Umum-Kec.MDLJ/T/VIII/2026', 1, '001/Jthndp/2026', NULL, 'Kelurahan JatiHandap', '2026-08-24', NULL, NULL, 'cgdhfhj', '2026-08-24 10:46:35', '2026-08-24 10:47:06', 'surat_masuk/8QsuTJipwUetoNTh3vzTT8n5X6rUr5H0FUtCF5Je.pdf', 5, 1, 'Internal', NULL, 'PETUGASAN', NULL, NULL, NULL, 'Sudah Disposisi', 'pending', 1, 'diteruskan', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL),
(28, 'No.HM.03.01/002-Subbag.Umum-Kec.MDLJ/T/VIII/2026', 1, '421p/ 1245 - Disdik / 2026', NULL, 'Dinas Pendidikan', '2026-08-18', NULL, NULL, 'pemohonan petugassan', '2026-08-24 10:51:12', '2026-08-24 10:51:43', 'surat_masuk/HPbHPkCmGSOXbvHECPGEObrRyZGKRCfcuAFXbnML.pdf', 5, 2, 'Eksternal', NULL, 'SURAT PEMOHONAN', NULL, NULL, NULL, 'Sudah Disposisi', 'pending', 1, 'diteruskan', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_wa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `photo`, `nomor_wa`) VALUES
(1, 1, 'EVY OKTAVIYANTI, S.STP., MM', 'adminarsip@mandja.com', NULL, '$2y$12$28Gq/6rso89xZD3zaERGDet3gWUSQTaG.wocfAI8nuFoPWSI7FF4G', 'eZNxECWGAbweQZ1ajj8JHjAi5qTzJEoAecvHZT07wyQtt2Aixpqtn1VTm0wE', '2026-05-28 07:20:15', '2026-07-29 14:19:59', 'Admin', 'profile/user_1.png', '62'),
(2, 2, 'Adang Sugandi,SE., MM', 'pegawaiarsip@mandja.com', NULL, '$2y$12$/bp9DH2uxsMrOXIuCQoZj.gRS/RRieI8ZRek7E8FuvdeU2ypjaik6', NULL, NULL, '2026-07-26 11:15:59', 'Pegawai', 'profile/user_2.png', NULL),
(4, 2, 'Lina Yulinar,S.IP., M.A.P', 'pegawaikesosarsip@mandja.com', NULL, '$2y$12$cESEoQN0wWEz57uTfiq.LeK/bsiHkVtoLNeHkQMOeRn9NlcI2BI6a', NULL, '2026-07-26 11:19:34', '2026-07-26 11:19:34', 'Pegawai', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_permissions`
--

CREATE TABLE `user_has_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_agenda_surat` (`surat_masuk_id`);

--
-- Indexes for table `arsips`
--
ALTER TABLE `arsips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kode_arsips`
--
ALTER TABLE `kode_arsips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pejabats`
--
ALTER TABLE `pejabats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`);

--
-- Indexes for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_menu_role_id_menu_id_unique` (`role_id`,`menu_id`),
  ADD KEY `role_menu_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `surat_keluars`
--
ALTER TABLE `surat_keluars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_keluars_user_disposisi_id_foreign` (`user_disposisi_id`);

--
-- Indexes for table `surat_masuks`
--
ALTER TABLE `surat_masuks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_masuks_user_id_foreign` (`user_id`),
  ADD KEY `surat_masuks_kode_arsip_id_foreign` (`kode_arsip_id`),
  ADD KEY `fk_surat_pejabat` (`pejabat_id`),
  ADD KEY `fk_surat_user_disposisi` (`user_disposisi_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_has_permissions`
--
ALTER TABLE `user_has_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_permission_unique` (`user_id`,`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `arsips`
--
ALTER TABLE `arsips`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kode_arsips`
--
ALTER TABLE `kode_arsips`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pejabats`
--
ALTER TABLE `pejabats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_menu`
--
ALTER TABLE `role_menu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `surat_keluars`
--
ALTER TABLE `surat_keluars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `surat_masuks`
--
ALTER TABLE `surat_masuks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_has_permissions`
--
ALTER TABLE `user_has_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `fk_agenda_surat` FOREIGN KEY (`surat_masuk_id`) REFERENCES `surat_masuks` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD CONSTRAINT `role_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_menu_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surat_keluars`
--
ALTER TABLE `surat_keluars`
  ADD CONSTRAINT `surat_keluars_user_disposisi_id_foreign` FOREIGN KEY (`user_disposisi_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `surat_masuks`
--
ALTER TABLE `surat_masuks`
  ADD CONSTRAINT `fk_surat_pejabat` FOREIGN KEY (`pejabat_id`) REFERENCES `pejabats` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_surat_user_disposisi` FOREIGN KEY (`user_disposisi_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `surat_masuks_kode_arsip_id_foreign` FOREIGN KEY (`kode_arsip_id`) REFERENCES `kode_arsips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `surat_masuks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
