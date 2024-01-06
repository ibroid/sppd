-- phpMyAdmin SQL Dump
-- version 5.2.0-1.fc35.remi
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 06, 2024 at 06:13 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sppd`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessible_menu`
--

CREATE TABLE `accessible_menu` (
  `id` int NOT NULL,
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `accessible_menu`
--

INSERT INTO `accessible_menu` (`id`, `role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2022-10-24 15:19:53', NULL),
(2, 1, 2, '2022-10-24 15:19:53', NULL),
(3, 1, 3, '2022-10-24 15:20:05', NULL),
(4, 1, 4, '2022-10-24 15:20:05', NULL),
(5, 1, 5, '2022-10-24 15:20:21', NULL),
(6, 1, 6, '2022-10-24 15:20:21', NULL),
(7, 1, 7, '2022-10-24 15:30:37', NULL),
(8, 1, 8, '2022-10-24 15:30:37', NULL),
(10, 1, 9, '2022-10-24 15:30:49', NULL),
(11, 2, 1, '2022-10-25 14:11:53', NULL),
(12, 2, 2, '2022-10-25 14:11:53', NULL),
(13, 2, 3, '2022-10-25 14:12:12', NULL),
(14, 2, 7, '2022-10-25 14:12:12', NULL),
(15, 3, 1, '2022-10-25 14:12:32', NULL),
(16, 3, 2, '2022-10-25 14:12:32', NULL),
(17, 3, 4, '2022-10-25 14:13:16', NULL),
(18, 3, 5, '2022-10-25 14:13:16', NULL),
(19, 3, 6, '2022-10-25 14:14:01', NULL),
(43, 4, 1, '2022-10-26 00:09:23', '2022-10-26 00:09:23'),
(44, 4, 4, '2022-10-26 00:09:23', '2022-10-26 00:09:23'),
(45, 4, 8, '2022-10-26 00:09:23', '2022-10-26 00:09:23'),
(51, 5, 1, '2023-07-31 02:45:25', '2023-07-31 02:45:25'),
(52, 5, 4, '2023-07-31 02:45:25', '2023-07-31 02:45:25'),
(53, 5, 8, '2023-07-31 02:45:25', '2023-07-31 02:45:25'),
(54, 6, 1, '2023-11-02 03:14:13', '2023-11-02 03:14:13'),
(55, 6, 2, '2023-11-02 03:14:13', '2023-11-02 03:14:13'),
(56, 6, 7, '2023-11-02 03:14:13', '2023-11-02 03:14:13'),
(57, 6, 8, '2023-11-02 03:14:13', '2023-11-02 03:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `biaya`
--

CREATE TABLE `biaya` (
  `id` int NOT NULL,
  `surat_dinas_id` int DEFAULT NULL,
  `keperluan` varchar(256) DEFAULT NULL,
  `biaya` varchar(50) DEFAULT NULL,
  `jumlah` varchar(50) DEFAULT NULL,
  `keterangan` varchar(256) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `id` int NOT NULL,
  `surat_masuk_id` int NOT NULL,
  `pegawai_id` int NOT NULL,
  `nomor_agenda` int NOT NULL,
  `isi_disposisi` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disposisi_order`
--

CREATE TABLE `disposisi_order` (
  `id` int NOT NULL,
  `order_priority` int NOT NULL,
  `jabatan_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `golongan`
--

CREATE TABLE `golongan` (
  `id` int NOT NULL,
  `kode_golongan` varchar(10) DEFAULT NULL,
  `nama_golongan` varchar(255) DEFAULT NULL,
  `aktif` char(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `golongan`
--

INSERT INTO `golongan` (`id`, `kode_golongan`, `nama_golongan`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'I/a', 'Juru Muda', '1', NULL, NULL),
(2, 'I/b', 'Juru Muda Tingkat I', '1', NULL, NULL),
(3, 'I/c', 'Juru', '1', NULL, NULL),
(4, 'I/d', 'Juru Tingkat I', '1', NULL, NULL),
(5, 'II/a', 'Pengatur Muda', '1', NULL, NULL),
(6, 'II/b', 'Pengatur Muda Tingkat I', '1', NULL, NULL),
(7, 'II/c', 'Pengatur', '1', NULL, NULL),
(8, 'II/d', 'Pengatur Tingkat I', '1', NULL, NULL),
(9, 'III/a', 'Penata Muda', '1', NULL, NULL),
(10, 'III/b', 'Penata Muda Tingkat I', '1', NULL, NULL),
(11, 'III/c', 'Penata', '1', NULL, NULL),
(12, 'III/d', 'Penata Tingkat I', '1', NULL, NULL),
(13, 'IV/a', 'Pembina', '1', NULL, NULL),
(14, 'IV/b', 'Pembina Tingkat I', '1', NULL, NULL),
(15, 'IV/c', 'Pembina Utama Muda', '1', NULL, NULL),
(16, 'IV/d', 'Pembina Utama Madya', '1', NULL, NULL),
(17, 'IV/e', 'Pembina Utama', '1', NULL, NULL),
(18, '--', 'Non Asn', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hak_penomoran`
--

CREATE TABLE `hak_penomoran` (
  `id` int NOT NULL,
  `role_id` int NOT NULL,
  `kode` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `hak_penomoran`
--

INSERT INTO `hak_penomoran` (`id`, `role_id`, `kode`, `created_at`, `updated_at`) VALUES
(8, 3, 'WKPA', '2024-01-05 03:46:28', '2024-01-05 03:46:28'),
(9, 3, 'SPA', '2024-01-05 03:46:28', '2024-01-05 03:46:28'),
(10, 4, 'KPA', '2024-01-05 03:46:37', '2024-01-05 03:46:37'),
(11, 4, 'WKPA', '2024-01-05 03:46:37', '2024-01-05 03:46:37'),
(12, 4, 'SPA', '2024-01-05 03:46:37', '2024-01-05 03:46:37'),
(14, 6, 'KPA', '2024-01-05 03:46:47', '2024-01-05 03:46:47'),
(15, 6, 'PPA', '2024-01-05 03:46:47', '2024-01-05 03:46:47'),
(24, 1, 'KPA', '2024-01-05 04:10:45', '2024-01-05 04:10:45'),
(25, 1, 'WKPA', '2024-01-05 04:10:45', '2024-01-05 04:10:45'),
(26, 1, 'SPA', '2024-01-05 04:10:45', '2024-01-05 04:10:45'),
(27, 1, 'PPA', '2024-01-05 04:10:45', '2024-01-05 04:10:45'),
(28, 2, 'KPA', '2024-01-05 04:10:49', '2024-01-05 04:10:49'),
(29, 2, 'WKPA', '2024-01-05 04:10:49', '2024-01-05 04:10:49'),
(30, 2, 'SPA', '2024-01-05 04:10:49', '2024-01-05 04:10:49'),
(31, 5, 'PPA', '2024-01-05 04:10:55', '2024-01-05 04:10:55');

-- --------------------------------------------------------

--
-- Table structure for table `identitas_publik`
--

CREATE TABLE `identitas_publik` (
  `id` int NOT NULL,
  `surat_masuk_id` int DEFAULT NULL,
  `nama` varchar(124) NOT NULL,
  `nomor_telepon` varchar(20) NOT NULL,
  `ip_forward` varchar(24) NOT NULL,
  `remote_addr` varchar(24) NOT NULL,
  `platform` varchar(191) NOT NULL,
  `http_referer` varchar(124) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instrumen`
--

CREATE TABLE `instrumen` (
  `id` int NOT NULL,
  `tujuan` varchar(256) DEFAULT NULL,
  `maksud` varchar(512) DEFAULT NULL,
  `perihal` varchar(256) DEFAULT NULL,
  `tanggal_penugasan` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ins_pegawai`
--

CREATE TABLE `ins_pegawai` (
  `id` int NOT NULL,
  `instrumen_id` int DEFAULT NULL,
  `pegawai_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int NOT NULL,
  `nama_jabatan` varchar(100) DEFAULT NULL,
  `atasan_langsung` int DEFAULT NULL,
  `atasan_pemberi_izin` int DEFAULT NULL,
  `aktif` char(1) DEFAULT '1',
  `single` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `atasan_langsung`, `atasan_pemberi_izin`, `aktif`, `single`, `created_at`, `updated_at`) VALUES
(1, 'Ketua', 1, 1, '1', 1, NULL, NULL),
(2, 'Wakil Ketua', 1, 1, '1', 1, NULL, NULL),
(4, 'Panitera', 1, 1, '1', 1, NULL, NULL),
(5, 'Sekretaris', 1, 1, '1', 1, NULL, NULL),
(7, 'Panitera Muda Hukum', 4, 1, '1', 1, NULL, NULL),
(10, 'Panitera Pengganti', 4, 1, '1', 0, NULL, NULL),
(30, 'Hakim ', 1, 1, '1', 0, '2022-06-21 11:53:10', '2022-06-21 11:53:10'),
(31, 'Jurusita', 4, 1, '1', 0, '2022-06-21 11:53:29', '2022-06-21 11:53:29'),
(32, 'Jurusita Pengganti', 4, 1, '1', 0, '2022-06-21 12:33:34', '2022-06-21 12:33:34'),
(33, 'Panitera Muda Permohonan', 4, 1, '1', 1, '2022-06-21 12:37:37', '2022-06-21 12:37:37'),
(34, 'Panitera Muda Gugatan', 4, 1, '1', 1, '2022-06-21 12:37:52', '2022-06-21 12:37:52'),
(35, 'Kasubbag Umum dan Keuangan', 5, 1, '1', 1, '2022-06-21 12:38:09', '2022-06-21 12:38:09'),
(36, 'Kasubbag Perencanaan, IT dan Pelaporan', 5, 1, '1', 1, '2022-06-21 12:38:43', '2022-06-21 12:38:43'),
(37, 'Kasubbag Kepegawaian, Organisasi dan Tata Laksana', 5, 1, '1', 1, '2022-06-21 12:39:06', '2022-06-21 12:39:06'),
(40, 'PPNPN', 35, 5, '1', 0, '2023-07-04 08:26:34', NULL),
(43, 'Bendahara Pengeluaran', 35, 5, '1', 0, '2023-07-21 06:33:38', '2023-07-21 06:33:38'),
(44, 'Bendahara Penerimaan', 35, 5, '1', 0, '2023-07-21 06:36:23', '2023-07-21 06:36:23'),
(45, 'Analis Pengelolaan Keuangan APBN', 5, 1, '1', 0, '2023-07-21 07:35:12', '2023-07-21 07:35:12'),
(46, 'Analis Perkara Peradilan', 34, 4, '1', 0, '2023-07-21 08:00:31', '2023-07-21 08:00:31'),
(47, 'Pengelola Perkara ', 34, 4, '1', 0, '2023-07-21 08:01:11', '2023-07-21 08:01:11'),
(48, 'Pengelola Perkara ', 7, 4, '1', 0, '2023-07-21 08:01:25', '2023-07-21 08:01:25'),
(49, 'Pengelola BMN', 35, 5, '1', 0, '2023-07-21 08:01:39', '2023-07-21 08:01:39'),
(51, 'Analis Kepegawaian', 37, 5, '1', 0, '2023-11-02 02:37:00', '2023-11-02 02:37:00'),
(52, 'Pranata Komputer', 36, 5, '1', 0, '2023-11-02 02:37:50', '2023-11-02 02:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `kode_beban_mak`
--

CREATE TABLE `kode_beban_mak` (
  `id` int NOT NULL,
  `nomor_kode` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kode_beban_mak`
--

INSERT INTO `kode_beban_mak` (`id`, `nomor_kode`, `created_at`, `updated_at`) VALUES
(1, '1066.EBA.994.001.H.524111', '2023-07-27 06:49:08', NULL),
(2, '1066.EBA.994.001.H.524113', '2023-07-27 06:49:55', NULL),
(3, '1053.QCA.001.051.A.524113', '2023-07-27 06:50:46', NULL),
(4, '1053.QCA.002.051.A.524113', '2023-07-27 06:50:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kode_surat`
--

CREATE TABLE `kode_surat` (
  `id` int NOT NULL,
  `kode_surat` varchar(10) NOT NULL,
  `keterangan` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kode_surat`
--

INSERT INTO `kode_surat` (`id`, `kode_surat`, `keterangan`, `created_at`, `updated_at`) VALUES
(4, 'OT.1', '-', '2023-07-27 07:42:11', NULL),
(5, 'OT.1.1', '-', '2023-07-27 07:42:17', NULL),
(6, 'OT.1.2', '-', '2023-07-27 07:42:24', NULL),
(7, 'OT.1.3', '-', '2023-07-27 07:42:30', NULL),
(8, 'OT.1.4', '-', '2023-07-27 07:42:37', NULL),
(9, 'HM.00', '-', '2023-07-27 07:42:46', NULL),
(10, 'HM.01', '-', '2023-07-27 07:42:54', NULL),
(11, 'HM.01.1', '-', '2023-07-27 07:43:01', NULL),
(12, 'HM.01.2', '-', '2023-07-27 07:43:06', NULL),
(13, 'HM.02', '-', '2023-07-27 07:43:12', NULL),
(14, 'HM.02.1', '-', '2023-07-27 07:44:27', NULL),
(15, 'HM.02.2', '-', '2023-07-27 07:44:32', NULL),
(16, 'HM.02.3', '-', '2023-07-27 07:44:37', NULL),
(17, 'KP.00', '-', '2023-07-27 07:44:43', NULL),
(18, 'KP.00.1', '-', '2023-07-27 07:44:48', NULL),
(19, 'KP.00.2', '-', '2023-07-27 07:44:52', NULL),
(20, 'KP.00.3', '-', '2023-07-27 07:44:57', NULL),
(21, 'KP.01', '-', '2023-07-27 07:45:02', NULL),
(22, 'KP.01.1', '-', '2023-07-27 07:45:08', NULL),
(23, 'KP.01.2', '-', '2023-07-27 07:45:13', NULL),
(24, 'KP.02', '-', '2023-07-27 07:45:19', NULL),
(25, 'KP.02.1', '-', '2023-07-27 07:45:28', NULL),
(26, 'KP.02.2', '-', '2023-07-27 07:45:33', NULL),
(27, 'KP.03', '-', '2023-07-27 07:45:38', NULL),
(28, 'KP.04', '-', '2023-07-27 07:45:48', NULL),
(29, 'KP.04.1', '-', '2023-07-27 07:46:04', NULL),
(30, 'KP.04.2', '-', '2023-07-27 07:46:13', NULL),
(31, 'KP.04.3', '-', '2023-07-27 07:47:14', NULL),
(32, 'KP.04.4', '-', '2023-07-27 07:47:40', NULL),
(33, 'KP.04.5', '-', '2023-07-27 08:56:54', NULL),
(34, 'KP.04.6', '-', '2023-07-27 08:56:59', NULL),
(35, 'KP.05', '-', '2023-07-27 08:57:04', NULL),
(36, 'KP.05.1', '-', '2023-07-27 08:57:09', NULL),
(37, 'KP.05.2', '-', '2023-07-27 08:57:13', NULL),
(38, 'KP.05.3', '-', '2023-07-27 08:57:18', NULL),
(39, 'KP.05.4', '-', '2023-07-27 08:57:22', NULL),
(40, 'KP.05.5', '-\r\n', '2023-07-27 08:57:28', NULL),
(41, 'KP.05.6', '-', '2023-07-27 08:57:32', NULL),
(42, 'KP.05.7', '-', '2023-07-27 08:57:37', NULL),
(43, 'KP.05.8', '-', '2023-07-27 08:57:41', NULL),
(44, 'KP.06', '-', '2023-07-27 08:57:48', NULL),
(45, 'KU.00', '-', '2023-07-27 08:57:57', NULL),
(46, 'KU.01', '-', '2023-07-27 08:58:02', NULL),
(47, 'KU.02', '-', '2023-07-27 08:58:05', NULL),
(48, 'KU.03', '-', '2023-07-27 08:58:10', NULL),
(49, 'KU.04', '-', '2023-07-27 08:58:15', NULL),
(50, 'KU.04.1', '-', '2023-07-27 08:58:20', NULL),
(51, 'KU.04.2', '-', '2023-07-27 08:58:24', NULL),
(52, 'KU.05', '-', '2023-07-27 08:58:27', NULL),
(53, 'KU.06', '-', '2023-07-27 08:58:31', NULL),
(54, 'KS.00', '-', '2023-07-27 08:58:35', NULL),
(55, 'PL.01', '-', '2023-07-27 08:58:39', NULL),
(56, 'PL.02', '-', '2023-07-27 08:58:46', NULL),
(57, 'PL.03', '-', '2023-07-27 08:58:50', NULL),
(58, 'PL.04', '-', '2023-07-27 08:58:55', NULL),
(59, 'PL.05', '-', '2023-07-27 08:58:59', NULL),
(60, 'PL.06', '-', '2023-07-27 08:59:04', NULL),
(61, 'PL.07', '-', '2023-07-27 08:59:07', NULL),
(62, 'PL.08', '-', '2023-07-27 08:59:10', NULL),
(63, 'PL.09', '-', '2023-07-27 08:59:15', NULL),
(64, 'HK.00', '-', '2023-07-27 08:59:19', NULL),
(65, 'HK.01', '-', '2023-07-27 08:59:37', NULL),
(66, 'HK.02', '-', '2023-07-27 08:59:47', NULL),
(67, 'HK.03', '-', '2023-07-27 08:59:52', NULL),
(68, 'HK.04', '-', '2023-07-27 08:59:56', NULL),
(69, 'HK.05', '-', '2023-07-27 09:00:00', NULL),
(70, 'HK.06', '-', '2023-07-27 09:00:05', NULL),
(71, 'HK.07', '-', '2023-07-27 09:00:09', NULL),
(72, 'PP.00', '-', '2023-07-27 09:00:13', NULL),
(73, 'PP.00.1', '-', '2023-07-27 09:00:19', NULL),
(74, 'PP.00.2', '-', '2023-07-27 09:00:27', NULL),
(75, 'PP.00.3', '-', '2023-07-27 09:00:32', NULL),
(76, 'PP.00.4', '-', '2023-07-27 09:00:37', NULL),
(77, 'PP.01', '-', '2023-07-27 09:00:41', NULL),
(78, 'PP.01.1', '-', '2023-07-27 09:00:55', NULL),
(79, 'PP.01.2', '-', '2023-07-27 09:00:57', NULL),
(80, 'PP.01.3', '-', '2023-07-27 09:01:04', NULL),
(81, 'PB.00', '-', '2023-07-27 09:01:09', NULL),
(82, 'PB.01', '-', '2023-07-27 09:01:13', NULL),
(83, 'PB.02', '-', '2023-07-27 09:01:18', NULL),
(84, 'PS.03', '-', '2023-07-27 09:01:25', NULL),
(85, 'PS.04', '-', '2023-07-27 09:01:29', NULL),
(86, 'PS.05', '-', '2023-07-27 09:01:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_pegawai`
--

CREATE TABLE `master_pegawai` (
  `id` int NOT NULL,
  `nama` varchar(64) DEFAULT NULL,
  `nip` varchar(35) DEFAULT NULL,
  `jabatan_id` int DEFAULT NULL,
  `golongan_id` int DEFAULT NULL,
  `aktif` int DEFAULT '1',
  `nomor_telepon` varchar(16) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int NOT NULL,
  `menu_name` varchar(64) NOT NULL,
  `menu_link` varchar(100) NOT NULL,
  `sub` json DEFAULT NULL,
  `menu_icon` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_name`, `menu_link`, `sub`, `menu_icon`, `created_at`, `updated_at`) VALUES
(1, 'Home', '/', '{}', '<i class=\"bi bi-grid-fill\"></i>', '2022-10-23 17:33:36', NULL),
(2, 'Instrumen', '#', '[{\"sub_link\": \"instrumen\", \"sub_name\": \"Buat Instrumen\"}, {\"sub_link\": \"instrumen/daftar\", \"sub_name\": \"Daftar Instrumen\"}]', '<i class=\"bi bi-bookmark-fill\"></i>', '2022-10-23 17:33:36', NULL),
(3, 'Surat Tugas', '#', '[{\"sub_link\": \"penugasan\", \"sub_name\": \"Buat Surat Tugas\"}, {\"sub_link\": \"penugasan/daftar\", \"sub_name\": \"Daftar Surat Tugas\"}]', '<i class=\"bi bi-calendar3\"></i>', '2022-10-23 17:35:57', NULL),
(4, 'Penomoran', '#', '[{\"sub_link\": \"penomoran\", \"sub_name\": \"Penomoran Surat Keluar\"}, {\"sub_link\": \"penomoran/daftar\", \"sub_name\": \"Daftar Kode Surat\"}]', '<i class=\"bi bi-file-text\"></i>', '2022-10-23 17:35:57', NULL),
(5, 'SPD', '#', '[{\"sub_link\": \"sppd\", \"sub_name\": \"Buat Surat Dinas\"}, {\"sub_link\": \"sppd/daftar\", \"sub_name\": \"Daftar Surat Dinas\"}]', '<i class=\"bi bi-calendar2\"></i>', '2022-10-23 17:38:22', NULL),
(6, 'Keuangan', 'keuangan', '{}', '<i class=\"bi bi-file-ruled-fill\"></i>', '2022-10-23 17:38:22', NULL),
(7, 'Kepegawaian', '#', '[{\"sub_link\": \"kepegawaian\", \"sub_name\": \"Pegawai\"}, {\"sub_link\": \"kepegawaian/plh\", \"sub_name\": \"Pejabat PLH\"}, {\"sub_link\": \"kepegawaian/jabatan\", \"sub_name\": \"Master Jabatan\"}]', '<i class=\"bi bi-people\"></i>', '2022-10-23 17:43:04', NULL),
(8, 'Persuratan', '#', '[{\"sub_link\": \"surat/surat_masuk\", \"sub_name\": \"Surat Masuk\"}, {\"sub_link\": \"surat/surat_keluar\", \"sub_name\": \"Surat Keluar\"}, {\"sub_link\": \"surat/laporan\", \"sub_name\": \"Laporan\"}, {\"sub_link\": \"surat/generate\", \"sub_name\": \"Generate Surat\"}]', '<i class=\"bi bi-envelope-fill\"></i>', '2022-10-23 17:43:04', NULL),
(9, 'Pengaturan', '#', '[{\"sub_link\": \"app/setting\", \"sub_name\": \"Umum\"}, {\"sub_link\": \"app/pengguna\", \"sub_name\": \"Pengguna\"}, {\"sub_link\": \"app/role\", \"sub_name\": \"Role\"}, {\"sub_link\": \"penomoran/hak_akses\", \"sub_name\": \"Hak Penomoran\"}, {\"sub_link\": \"penomoran/nomor_terakhir\", \"sub_name\": \"Nomor Terakhir\"}, {\"sub_link\": \"app/notification_config\", \"sub_name\": \"Notifikasi\"}]', '<i class=\"bi bi-gear\"></i>', '2022-10-23 17:44:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nomor_surat_terakhir`
--

CREATE TABLE `nomor_surat_terakhir` (
  `id` int UNSIGNED NOT NULL,
  `kode` varchar(32) NOT NULL,
  `nomor` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `nomor_surat_terakhir`
--

INSERT INTO `nomor_surat_terakhir` (`id`, `kode`, `nomor`, `created_at`, `updated_at`) VALUES
(1, 'KPA', 113, '2024-01-04 14:31:46', '2024-01-05 11:20:37'),
(2, 'WKPA', 0, '2024-01-04 14:31:46', '2024-01-05 16:47:28'),
(3, 'SPA', 0, '2024-01-04 14:33:39', '2024-01-04 14:33:39'),
(4, 'PPA', 0, '2024-01-04 14:33:39', '2024-01-04 14:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int NOT NULL,
  `surat_tugas_id` int NOT NULL,
  `nama` varchar(191) DEFAULT NULL,
  `jabatan` varchar(191) DEFAULT NULL,
  `pangkat` varchar(191) DEFAULT NULL,
  `golongan` varchar(64) DEFAULT NULL,
  `nip` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pejabat_plh`
--

CREATE TABLE `pejabat_plh` (
  `id` int NOT NULL,
  `nama_pejabat` varchar(191) DEFAULT NULL,
  `nip_pejabat` varchar(30) DEFAULT NULL,
  `jabatan` varchar(64) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `value` varchar(512) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `catatan` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `name`, `value`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'nama_ketua', 'Dr. Drs. M. FAUZI ARDI, S.H., M.H.', '', '2022-01-17 04:36:14', '2023-07-21 06:01:38'),
(2, 'nip_ketua', '196810021994031004', '', '2022-01-17 04:36:33', '2023-07-21 06:01:22'),
(3, 'referensi_dipa_01', 'Segala biaya yang timbul akibat pelaksanaan surat tugas ini, dibebankan pada Daftar Isian Pelaksanaan Anggaran (DIPA) Pengadilan Agama Jakarta Utara Tahun Anggaran 2023 Nomor SP DIPA - 005.01.2.400622/2023 tanggal 30 November 2022.                          ', '', '2022-01-17 05:04:31', '2023-07-21 10:44:30'),
(4, 'referensi_dipa_04', 'Segala biaya yang timbul akibat pelaksanaan surat tugas ini, dibebankan pada Daftar Isian Pelaksanaan Anggaran (DIPA) Pengadilan Agama Jakarta Utara Tahun Anggaran 2023 Nomor SP DIPA - 005.04.2.400623/2023 tanggal 30 November 2022.          ', '', '2022-01-25 13:18:01', '2023-07-21 10:44:18'),
(5, 'nama_wakil', 'RUSLAN, S.Ag., S.H., M.H.', '', '2022-01-25 13:22:36', '2023-07-21 06:01:07'),
(6, 'nip_wakil', '197110071998031003', '', '2022-01-25 13:22:41', '2023-07-21 06:00:51'),
(7, 'nama_sekretaris', 'Drs. SAFE\'I AGUSTIAN', '', '2022-01-25 13:22:43', '2023-07-21 06:00:06'),
(8, 'nip_sekretaris', '196808131994031002', '', '2022-01-25 13:23:02', '2023-07-21 05:59:56'),
(9, 'nama_ppk', 'Najamudin, S.Ag.,S.H.,M.H.', '', '2022-01-25 13:23:22', '2022-06-21 07:49:56'),
(10, 'nip_ppk', '197711082006041003', '', '2022-01-25 13:23:33', '2023-07-21 05:59:38'),
(11, 'nama_panitera', 'DINDIN PAHRUDIN, S.H.,M.H.', '', '2022-01-25 13:26:42', '2023-07-21 06:00:35'),
(12, 'nip_panitera', '197406051999031003', '', '2022-01-25 13:26:57', '2023-11-30 09:11:17'),
(13, 'nama_bendahara', 'Aprilinda Ramadhina, S.E.', '', '2022-01-26 03:54:31', '2023-07-21 05:58:39'),
(14, 'nip_bendahara', '198904212019032012', '', '2022-01-26 03:54:34', '2023-07-21 05:58:36'),
(15, 'nomor_surat', 'W9-A5/{nomor}/{kode_surat}/{bulan_angka}/{tahun}', 'Format nomor surat keluar', '2022-01-26 04:42:14', '2023-07-24 09:25:24'),
(16, 'template_surat_tugas', 'template_surat_tugas_transport.docx', '', '2022-01-28 16:16:57', '2023-07-24 09:34:01'),
(17, 'nama_satker', 'Pengadilan Agama Jakarta Utara', '', '2022-01-29 13:26:57', '2023-07-21 06:02:40'),
(18, 'logo_satker', '1689919368.png', '', '2022-02-07 03:13:37', '2023-07-21 06:02:48'),
(19, 'plt_sekretaris', 'NIHIL', '', '2022-02-10 05:39:07', '2022-10-23 09:44:18'),
(20, 'nip_plt_sekretaris', '1452', '', '2022-02-10 05:39:09', '2023-07-24 07:34:36'),
(21, 'nrt_surat_masuk', '11', 'Nomor Register Terakhir dari Surat Masuk', NULL, '2024-01-05 08:46:44'),
(22, 'alamat_satker', 'Jl. Raya Plumpang Semper No.5, Tugu Selatan, Koja, Jakarta Utara', 'Alamat Satuan Kerja', NULL, NULL),
(23, 'fax_satker', '021-43800421', 'Fax Satuan Kerja', NULL, NULL),
(24, 'telp_satker', '021-43934701', 'Nomor Telepon Satuan Kerja', NULL, NULL),
(25, 'nnr_surat_masuk', '0', 'Next Nomor Register Surat Masuk', NULL, NULL),
(26, 'nrt_surat_keluar', '113', 'Nomor Register Terakhir Surat Keluar', NULL, '2024-01-04 07:41:47'),
(28, 'web_satker', 'https://pa-jakartautara.go.id', '', NULL, NULL),
(29, 'email_satker', 'pengadilanagama.jakut@gmail.com', '', NULL, NULL),
(30, 'maintenance', '0', 'Untuk menampilkan peringatan maintenance', NULL, '2024-01-05 11:20:56'),
(31, 'mobile_allowed_ip', '103.177.176.25', 'IP yang dibolehkan untuk akses aplikasi mobile\n1. ip kantor paju', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_riil`
--

CREATE TABLE `pengeluaran_riil` (
  `id` int NOT NULL,
  `surat_dinas_id` int DEFAULT NULL,
  `keperluan` varchar(191) DEFAULT NULL,
  `harga` varchar(20) DEFAULT NULL,
  `jumlah` varchar(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `role_name` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2022-10-23 16:40:25', '2022-10-23 16:40:25'),
(2, 'Kepegawaian', '2022-10-23 16:40:25', '2022-10-23 16:40:25'),
(3, 'Umum', '2022-10-23 16:41:03', '2022-10-23 16:41:03'),
(4, 'Petugas Surat', '2022-10-23 16:41:03', '2022-10-26 00:09:23'),
(5, 'Petugas Tabayun', '2022-10-26 00:25:46', '2023-07-31 02:45:25'),
(6, 'Panitera', '2023-11-02 03:14:13', '2023-11-02 03:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `surat_dinas`
--

CREATE TABLE `surat_dinas` (
  `id` int NOT NULL,
  `surat_tugas_id` int DEFAULT NULL,
  `nomor_surat` varchar(72) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tanggal_berangkat` date DEFAULT NULL,
  `tanggal_tiba` date DEFAULT NULL,
  `tanggal_pulang` date DEFAULT NULL,
  `tanggal_pencairan` date DEFAULT NULL,
  `maksud_perjalanan` text,
  `transportasi` varchar(191) DEFAULT NULL,
  `tempat_berangkat` varchar(256) DEFAULT NULL,
  `tempat_tujuan` varchar(256) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id` int NOT NULL,
  `nomor_surat` varchar(191) DEFAULT NULL,
  `kode_surat` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `tujuan` varchar(191) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `perihal` varchar(124) DEFAULT NULL,
  `ringkasan_isi` text,
  `tanggal_dikirim` date NOT NULL,
  `catatan` varchar(124) DEFAULT NULL,
  `file` varchar(64) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `klasifikasi_surat` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar_relation`
--

CREATE TABLE `surat_keluar_relation` (
  `id` int NOT NULL,
  `surat_keluar_id` int NOT NULL,
  `jenis_relation` varchar(191) NOT NULL,
  `relation_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id` int NOT NULL,
  `nomor_register` int NOT NULL,
  `nomor_surat` varchar(191) DEFAULT NULL,
  `kode_surat` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `tanggal_diterima` date DEFAULT NULL,
  `asal` varchar(225) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `perihal` varchar(512) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ringkasan_isi` text,
  `catatan` varchar(124) DEFAULT NULL,
  `file` varchar(64) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surat_terhapus`
--

CREATE TABLE `surat_terhapus` (
  `id` int NOT NULL,
  `asal` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `tujuan` varchar(191) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `perihal` varchar(191) NOT NULL,
  `nomor_surat` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ringkasan_isi` text NOT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `tanggal_dikirim` date DEFAULT NULL,
  `tanggal_diterima` date DEFAULT NULL,
  `deleted_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_tugas`
--

CREATE TABLE `surat_tugas` (
  `id` int NOT NULL,
  `perihal` text NOT NULL,
  `menimbang` text,
  `dasar_hukum` text,
  `tujuan` text,
  `tugas` text,
  `nomor_surat` varchar(64) DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surat_tugas`
--

INSERT INTO `surat_tugas` (`id`, `perihal`, `menimbang`, `dasar_hukum`, `tujuan`, `tugas`, `nomor_surat`, `tanggal_surat`, `created_at`, `updated_at`) VALUES
(113, 'Sidang Keliling tanggal 3 s.d 4 Agustus 2023', 'Sehubungan dengan pelaksanaan Sidang Keliling pada wilayah hukum Pengadilan Agama Jakarta Utara serta dalam rangka memberikan pelayanan prima kepada masyarakat, dengan ini kami menugaskan yang nama-namanya tercantum dibawah ini.', 'Surat Keputusan Ketua Pengadilan Agama Jakarta Utara Nomor : W9-A5/155/HK.05/SK/7/2023 tanggal 28 Juli 2023 tentang Tim Sidang Keliling Pengadilan Agama Jakarta Utara Di Kabupaten Administrasi Kepulauan Seribu Tahun Anggaran 2023.', 'Pulau Pramuka, Kabupaten Administrasi Kepulauan Seribu, Kota Jakarta Utara, DKI Jakarta', 'Melaksanakan Sidang Keliling di Pulau Pramuka Kabupaten Administrasi Kepulauan Seribu Provinsi DKI Jakarta  yang akan dilaksanakan pada :\r\nHari Kamis s.d Jum’at, tanggal 3 s.d 4 Agustus 2023 Pukul 06.00 WIB s.d Selesai.\r\n', 'W9-A5/3164/HK.05/7/2023', '2023-07-31', '2023-07-31 02:56:11', '2023-07-31 03:10:52'),
(120, 'Kegiatan Pelayanan Terpadu Keliling (PTK)', 'Sehubungan dengan pelaksanaan Kegiatan Pelayanan Terpadu Keliling sebagai Solusi Pelayanan Publik Terapung (SI PITUNG) Tahun Anggaran 2023, dengan ini kami menugaskan pegawai yang namanya tercantum dalam surat tugas ini.', 'Surat Kepala Unit Pengelola Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Administrasi Kepulauan Seribu Nomor : 423/TM.03.1 tanggal 31 Juli 2023 perihal Undangan.', 'Pulau Sabira, Kelurahan Pulau Harapan, Kepulauan Seribu', 'Kegiatan Pelayanan Terpadu Keliling ', 'W9-A5/3200/HK.05/8/2023', '2023-08-01', '2023-08-01 10:13:05', '2023-08-01 10:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `template_surat`
--

CREATE TABLE `template_surat` (
  `id` int NOT NULL,
  `nama_template` varchar(124) NOT NULL,
  `keterangan` varchar(191) NOT NULL,
  `filename` varchar(124) NOT NULL,
  `jenis_template` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `template_surat`
--

INSERT INTO `template_surat` (`id`, `nama_template`, `keterangan`, `filename`, `jenis_template`, `created_at`, `updated_at`) VALUES
(6, 'Template Surat Keluar (Umum)', 'Surat Biasa (Umum)', 'template_surat_keluar_umum.docx', 1, '2023-07-29 08:23:33', '2023-07-29 08:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `pegawai_id` int DEFAULT NULL,
  `role_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `pegawai_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$vfgOzt97CTFgypNbFFwSKe6A0M0QKkgUb4LA0TKppcbR6sipkuXVK', 1, 1, '2022-01-31 01:40:54', '2023-07-29 16:14:26'),
(8, 'surat', '$2y$10$zRJ781PxkFdkBHCnkLo9Ce2LTS8cxYe1QonW6DaIrmir0/cUlV3mu', 2, 4, '2022-10-25 08:15:29', '2023-07-24 06:51:27'),
(9, 'tabayun', '$2y$10$F20loR.qj38xWxCfCAo80euJs1JconZYcwtWV1/Mn8PoT7GZKUKgm', 49, 5, '2023-07-31 02:44:42', '2023-07-31 02:45:40'),
(10, 'panitera', '$2y$10$.YVeXyybFs8IkytiNVosmeADwztcQzgW0YjX2cRzyg7vApnP2nTmy', 6, 6, '2023-11-02 03:15:27', '2023-11-02 03:15:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessible_menu`
--
ALTER TABLE `accessible_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disposisi_order`
--
ALTER TABLE `disposisi_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `golongan`
--
ALTER TABLE `golongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hak_penomoran`
--
ALTER TABLE `hak_penomoran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `identitas_publik`
--
ALTER TABLE `identitas_publik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instrumen`
--
ALTER TABLE `instrumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ins_pegawai`
--
ALTER TABLE `ins_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kode_beban_mak`
--
ALTER TABLE `kode_beban_mak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kode_surat`
--
ALTER TABLE `kode_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_pegawai`
--
ALTER TABLE `master_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomor_surat_terakhir`
--
ALTER TABLE `nomor_surat_terakhir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pejabat_plh`
--
ALTER TABLE `pejabat_plh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran_riil`
--
ALTER TABLE `pengeluaran_riil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_dinas`
--
ALTER TABLE `surat_dinas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keluar_relation`
--
ALTER TABLE `surat_keluar_relation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_terhapus`
--
ALTER TABLE `surat_terhapus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_tugas`
--
ALTER TABLE `surat_tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_surat`
--
ALTER TABLE `template_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessible_menu`
--
ALTER TABLE `accessible_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `biaya`
--
ALTER TABLE `biaya`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disposisi_order`
--
ALTER TABLE `disposisi_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `golongan`
--
ALTER TABLE `golongan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hak_penomoran`
--
ALTER TABLE `hak_penomoran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `identitas_publik`
--
ALTER TABLE `identitas_publik`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instrumen`
--
ALTER TABLE `instrumen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ins_pegawai`
--
ALTER TABLE `ins_pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `kode_beban_mak`
--
ALTER TABLE `kode_beban_mak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kode_surat`
--
ALTER TABLE `kode_surat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `master_pegawai`
--
ALTER TABLE `master_pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nomor_surat_terakhir`
--
ALTER TABLE `nomor_surat_terakhir`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pejabat_plh`
--
ALTER TABLE `pejabat_plh`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `pengeluaran_riil`
--
ALTER TABLE `pengeluaran_riil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `surat_dinas`
--
ALTER TABLE `surat_dinas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_keluar_relation`
--
ALTER TABLE `surat_keluar_relation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_terhapus`
--
ALTER TABLE `surat_terhapus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_tugas`
--
ALTER TABLE `surat_tugas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `template_surat`
--
ALTER TABLE `template_surat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
