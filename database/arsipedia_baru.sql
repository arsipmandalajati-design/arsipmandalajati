-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260707.3e756d69dd
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2026 at 04:08 AM
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
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agendas`
--

INSERT INTO `agendas` (`id`, `user_id`, `nama_kegiatan`, `tanggal`, `penyelenggara`, `keterangan`, `created_at`, `updated_at`, `tempat`, `status`, `surat_masuk_id`, `jam_mulai`, `jam_selesai`, `materi`, `kebutuhan`, `status_wa`, `penanggung_jawab`, `dokumentasi`, `kursi`, `meja`, `proyektor`, `mic`, `sound_system`, `kabel_roll`, `lainnya`, `hasil_kegiatan`, `hasil_materi`, `catatan`) VALUES
(2, 2, 'PETUGASAN', '2026-07-14', 'KASUBAG', NULL, '2026-07-11 04:31:37', '2026-07-11 04:31:37', 'Aula Kecamatan', 'Diproses', 12, '08:00:00', '09:00:00', 'RAPAT EVALUASI', NULL, NULL, NULL, NULL, 50, 2, 2, 2, 2, 2, NULL, NULL, NULL, NULL),
(4, 2, 'RAPAT', '2026-07-13', 'PKK', 'GFFHFH', '2026-07-12 16:06:44', '2026-07-12 16:07:27', 'Ruang Rapat', 'Terjadwal', 15, '08:00:00', '10:00:00', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `arsips`
--

CREATE TABLE `arsips` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_arsip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_arsip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_arsip` date NOT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_arsip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arsips`
--

INSERT INTO `arsips` (`id`, `kode_arsip`, `nama_arsip`, `tanggal_arsip`, `kategori`, `file_arsip`, `created_at`, `updated_at`) VALUES
(1, 'HM', 'pppp', '2026-06-23', 'Surat Keluar', 'arsip/CEdu4c3zBXjo6jNQb3hD3j3AJmCdzKkNGEkjIxUz.docx', '2026-06-24 06:32:44', '2026-06-24 06:32:44'),
(4, 'HM.02', 'RAPAT', '2026-07-06', 'Surat Masuk', 'surat/utcLemi3Asn1nr46tLkB4MYCkPkUqQfAiedoiYbF.pdf', '2026-07-11 02:23:51', '2026-07-11 02:23:51'),
(5, 'HM.03.02', 'RAPAT', '2026-07-06', 'Surat Masuk', 'surat_masuk/xvGfKnxVsyBHUMV8Ym8Xu68hDceDzoEFmFtBPM1S.pdf', '2026-07-11 02:59:44', '2026-07-11 02:59:44'),
(6, 'HM.04.03', 'Surat Undangan', '2026-07-06', 'Surat Masuk', 'surat_masuk/bQ5s2GDursXakRt1Z2oa3Sjc3qcYnmjhyKp6T9Iq.pdf', '2026-07-11 03:05:35', '2026-07-11 03:05:35'),
(10, 'HM.05', 'RAPAT', '2026-07-10', 'Surat Masuk', 'surat_masuk/FvuNdloiFDYjzNfYKoC1Nhg3IR1wGyeXpg6pWMuO.pdf', '2026-07-12 16:04:37', '2026-07-12 16:04:37');

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
(42, '2026_07_12_211552_add_hasil_to_agendas_table', 7);

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
(1, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"PETUGASAN\".', 'surat', 7, 1, '2026-07-08 17:39:13', '2026-07-10 16:50:42'),
(2, 2, 'Surat Diverifikasi', 'Surat \"PETUGASAN\" telah diverifikasi.', 'surat', 7, 1, '2026-07-10 20:09:15', '2026-07-10 20:10:34'),
(3, 2, 'Disposisi Baru', 'Anda menerima disposisi surat \"PETUGASAN\".', 'surat', 7, 1, '2026-07-10 20:10:00', '2026-07-10 20:10:34'),
(4, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"RAPAT\".', 'surat', 8, 0, '2026-07-11 02:23:51', '2026-07-11 02:23:51'),
(5, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"RAPAT\".', 'surat', 9, 0, '2026-07-11 02:59:44', '2026-07-11 02:59:44'),
(6, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"Surat Undangan\".', 'surat', 10, 0, '2026-07-11 03:05:35', '2026-07-11 03:05:35'),
(7, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"PETUGASAN\".', 'surat', 12, 0, '2026-07-11 04:31:37', '2026-07-11 04:31:37'),
(8, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"PETUGASAN\".', 'surat', 13, 0, '2026-07-11 09:22:42', '2026-07-11 09:22:42'),
(9, 2, 'Disposisi Baru', 'Anda menerima disposisi surat \"RAPAT\".', 'surat', 11, 1, '2026-07-11 11:52:44', '2026-07-11 11:54:11'),
(10, 2, 'Disposisi Baru', 'Anda menerima disposisi surat \"PETUGASAN\".', 'surat', 13, 1, '2026-07-11 11:53:18', '2026-07-11 11:54:11'),
(11, 2, 'Disposisi Baru', 'Anda menerima disposisi surat \"PETUGASAN\".', 'surat', 12, 1, '2026-07-11 11:53:36', '2026-07-11 11:54:11'),
(12, 1, 'Agenda Baru', 'Pegawai Kecamatan membuat agenda \"RAPAT\".', 'agenda', 3, 0, '2026-07-11 12:03:09', '2026-07-11 12:03:09'),
(13, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"PETUGASAN\".', 'surat', 14, 0, '2026-07-11 15:04:44', '2026-07-11 15:04:44'),
(14, 1, 'Agenda Dihapus', 'Agenda \"Rapat\" telah dihapus.', 'agenda', NULL, 0, '2026-07-12 13:46:02', '2026-07-12 13:46:02'),
(15, 1, 'Surat Masuk Baru', 'Pegawai Kecamatan menambahkan surat \"RAPAT\".', 'surat', 15, 0, '2026-07-12 16:04:37', '2026-07-12 16:04:37'),
(16, 2, 'Surat Diverifikasi', 'Surat \"RAPAT\" telah diverifikasi.', 'surat', 15, 0, '2026-07-12 16:05:11', '2026-07-12 16:05:11'),
(17, 2, 'Disposisi Baru', 'Anda menerima disposisi surat \"RAPAT\".', 'surat', 15, 0, '2026-07-12 16:05:26', '2026-07-12 16:05:26'),
(18, 1, 'Agenda Baru', 'Pegawai Kecamatan membuat agenda \"RAPAT\".', 'agenda', 4, 0, '2026-07-12 16:06:44', '2026-07-12 16:06:44'),
(19, 1, 'Agenda Diperbarui', 'Agenda \"RAPAT\" berhasil diperbarui.', 'agenda', 4, 0, '2026-07-12 16:07:27', '2026-07-12 16:07:27'),
(20, 1, 'Agenda Dihapus', 'Agenda \"RAPAT\" telah dihapus.', 'agenda', NULL, 0, '2026-07-12 16:14:46', '2026-07-12 16:14:46');

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
  `nama_pejabat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanda_tangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `nomor_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_keluars`
--

INSERT INTO `surat_keluars` (`id`, `user_id`, `kode_arsip_id`, `nomor_surat`, `judul`, `pengirim`, `tujuan`, `tanggal_surat`, `perihal`, `file_surat`, `created_at`, `updated_at`) VALUES
(4, 1, 2, 'No.HM.01/035-Pel.DN-Kec.MDLJ/T/VI/2026', 'PETUGASAN', 'kesos', 'camat', '2026-06-24', 'TUGAS', 'surat/d0ENOW5iUdcRTudSpBI8catetCjfSRL9eK8wCyBX.pdf', '2026-06-23 00:12:01', '2026-06-23 00:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuks`
--

CREATE TABLE `surat_masuks` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nomor_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_manual` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_arsip_id` bigint UNSIGNED NOT NULL,
  `jenis_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sumber_arsip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disposisi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pejabat_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Menunggu Verifikasi',
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
  `sound_system` int NOT NULL DEFAULT '0',
  `kabel_roll` int NOT NULL DEFAULT '0',
  `lainnya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_masuks`
--

INSERT INTO `surat_masuks` (`id`, `user_id`, `nomor_surat`, `nomor_manual`, `pengirim`, `tanggal_surat`, `perihal`, `created_at`, `updated_at`, `file_surat`, `kode_arsip_id`, `jenis_surat`, `sumber_arsip`, `judul`, `disposisi`, `pejabat_id`, `status`, `user_disposisi_id`, `catatan_admin`, `tempat`, `tanggal_kegiatan`, `jam_mulai`, `jam_selesai`, `materi`, `jumlah_peserta`, `kursi`, `meja`, `proyektor`, `mic`, `sound_system`, `kabel_roll`, `lainnya`) VALUES
(7, 2, 'No.HM.02/035-Pel.DN-Kec.MDLJ/T/VII/2026', NULL, 'KASUBAG', '2026-07-06', 'FHRHBFBF', '2026-07-08 17:39:13', '2026-07-10 20:10:00', 'surat/s13TEc8sZggrfZBKfyGKFDL3aC8omhjt2ukXiVDi.pdf', 3, NULL, NULL, 'PETUGASAN', NULL, NULL, 'Sudah Disposisi', 2, 'OKE', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, NULL),
(11, 2, 'No.HM.08/200-PLN-Kec.MDLJ/T/VII/2026', NULL, 'PKK', '2026-07-06', 'dhdydfjyjy', '2026-07-11 04:28:26', '2026-07-12 16:14:46', 'surat_masuk/68P8wtJoBQYKK0RGszTawgcfPzyYgWTlo7unPKDL.pdf', 20, 'Internal', 'Dokumen Digital', 'RAPAT', NULL, NULL, 'Sudah Disposisi', 2, 'OKAY', 'Aula Kecamatan', '2026-07-13', '08:00:00', '10:00:00', 'RAPAT EVALUASI', 50, 50, 3, 2, 2, 2, 2, NULL),
(12, 2, 'No.HM.06/035-Pel.DN-Kec.MDLJ/T/VII/2026', NULL, 'KASUBAG', '2026-07-07', 'hfjffuf', '2026-07-11 04:31:37', '2026-07-11 11:53:36', 'surat_masuk/FCM1Dl8RLAYlIoqLNdYYunp8aBLoWgd0Qos6kjuB.pdf', 18, 'Internal', 'Dokumen Digital', 'PETUGASAN', NULL, NULL, 'Sudah Disposisi', 2, 'HGHGJ', 'Aula Kecamatan', '2026-07-14', '08:00:00', '09:00:00', 'RAPAT EVALUASI', 50, 50, 2, 2, 2, 2, 2, NULL),
(13, 2, 'No.HK/200-PLN-Kec.MDLJ/T/VII/2026', NULL, 'KASUBAG', '2026-07-06', 'chcjhcjhch', '2026-07-11 09:22:42', '2026-07-11 11:53:18', 'surat_masuk/0REeKJaY7PzdPE2eNE4Ik0DefI0Zr5mGhfVt3uzf.pdf', 21, 'Internal', 'Dokumen Digital', 'PETUGASAN', NULL, NULL, 'Sudah Disposisi', 2, 'FHFHF', 'Aula Kecamatan', '2026-07-14', '08:00:00', '10:00:00', 'RAPAT EVALUASI', 15, 15, 1, 1, 2, 2, 3, NULL),
(15, 2, 'No.HM.05/035-Pel.DN-Kec.MDLJ/T/VII/2026', NULL, 'PKK', '2026-07-10', 'GFFHFH', '2026-07-12 16:04:37', '2026-07-12 16:06:44', 'surat_masuk/FvuNdloiFDYjzNfYKoC1Nhg3IR1wGyeXpg6pWMuO.pdf', 17, 'Internal', 'Dokumen Digital', 'RAPAT', NULL, NULL, 'Sudah Dijadikan Agenda', 2, 'HFHH', 'Ruang Rapat', '2026-07-14', '08:00:00', '10:00:00', NULL, 50, 50, 2, 2, 2, 2, 2, NULL);

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
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_wa` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `photo`, `nomor_wa`) VALUES
(1, 1, 'Camat Mandalajati', 'adminarsip@mandja.com', NULL, '$2y$12$Zb6pFsgYiA3SJQzUoKCpU.JMdMz4118tSorKc7m8qb42ecVs5Vi..', NULL, '2026-05-28 07:20:15', '2026-06-30 10:41:07', 'admin', 'profile/user_1.png', NULL),
(2, 2, 'Pegawai Kecamatan', 'pegawaiarsip@mandja.com', NULL, '$2y$12$I3Dg75tsZM5kOb5S1HPBb.t7N.hfEiJCsgn1cWqHToYTGZ3Tz7Vka', NULL, NULL, '2026-06-30 13:43:11', 'pegawai', 'profile/user_2.png', NULL);

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `arsips`
--
ALTER TABLE `arsips`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pejabats`
--
ALTER TABLE `pejabats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_keluars`
--
ALTER TABLE `surat_keluars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `surat_masuks`
--
ALTER TABLE `surat_masuks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `fk_agenda_surat` FOREIGN KEY (`surat_masuk_id`) REFERENCES `surat_masuks` (`id`) ON DELETE SET NULL;

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
