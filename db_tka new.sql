-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2026 at 09:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tka`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `target_type` varchar(50) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `admin_id`, `admin_name`, `action`, `target_type`, `target_id`, `description`, `ip_address`, `created_at`) VALUES
(1, 1, 'Admin Utama', 'EXPORT_PERUSAHAAN_CSV', NULL, NULL, 'Mengekspor data perusahaan ke CSV', '::1', '2026-04-07 19:10:11'),
(2, 1, 'Admin Utama', 'EDIT_TEMPLATE', 'template', 1, 'Mengedit template surat', '::1', '2026-04-07 19:26:47'),
(3, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-07 19:26:59'),
(4, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-07 19:33:52'),
(5, 1, 'Admin Utama', 'EDIT_TEMPLATE', 'template', 1, 'Mengedit template surat', '::1', '2026-04-07 19:46:42'),
(6, 1, 'Admin Utama', 'EDIT_TEMPLATE', 'template', 1, 'Mengedit template surat', '::1', '2026-04-07 19:46:58'),
(7, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 10, 'Menonaktifkan perusahaan ID 10', '::1', '2026-04-07 19:51:08'),
(8, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 10, 'Mengaktifkan perusahaan ID 10', '::1', '2026-04-07 19:51:10'),
(9, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 8, 'Menonaktifkan perusahaan ID 8', '::1', '2026-04-07 19:51:13'),
(10, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 8, 'Mengaktifkan perusahaan ID 8', '::1', '2026-04-07 19:51:38'),
(11, 1, 'Admin Utama', 'DELETE_USER', 'user', 6, 'Menghapus perusahaan ID 6', '::1', '2026-04-07 19:51:42'),
(12, 1, 'Admin Utama', 'DELETE_USER', 'user', 7, 'Menghapus perusahaan ID 7', '::1', '2026-04-07 19:51:44'),
(13, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-07 19:56:50'),
(14, 1, 'Admin Utama', 'EDIT_FOOTER', 'settings', 1, 'Mengedit footer website', '::1', '2026-04-07 20:46:42'),
(15, 1, 'Admin Utama', 'EDIT_FOOTER', 'settings', 1, 'Mengedit footer website', '::1', '2026-04-07 20:58:34'),
(16, 1, 'Admin Utama', 'EXPORT_PERUSAHAAN_CSV', NULL, NULL, 'Mengekspor data perusahaan ke CSV', '::1', '2026-04-07 21:07:32'),
(17, 1, 'Admin Utama', 'EDIT_TEMPLATE', 'template', 1, 'Mengedit template surat', '::1', '2026-04-08 05:54:25'),
(18, 2, 'Kasi 1', 'APPROVE', 'tka', 8, 'Approve pengajuan TKA oyen yg oyen oleh kasi', '::1', '2026-04-08 06:51:31'),
(19, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-08 12:17:28'),
(20, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 8, 'Menonaktifkan perusahaan ID 8', '::1', '2026-04-08 12:19:37'),
(21, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 8, 'Mengaktifkan perusahaan ID 8', '::1', '2026-04-08 12:20:19'),
(22, 1, 'Admin Utama', 'DELETE_TKA', 'tka', 5, 'Menghapus TKA oyen smit', '::1', '2026-04-08 14:51:51'),
(23, 1, 'Admin Utama', 'DELETE_USER', 'user', 13, 'Menghapus perusahaan ID 13', '::1', '2026-04-08 17:59:36'),
(24, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 11, 'Menonaktifkan perusahaan ID 11', '::1', '2026-04-08 18:04:58'),
(25, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 10, 'Menonaktifkan perusahaan ID 10', '::1', '2026-04-08 18:05:00'),
(26, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 11, 'Mengaktifkan perusahaan ID 11', '::1', '2026-04-08 18:05:38'),
(27, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 10, 'Mengaktifkan perusahaan ID 10', '::1', '2026-04-08 18:05:40'),
(28, 2, 'Kasi 1', 'APPROVE', 'tka', 9, 'Approve pengajuan TKA oyen bala oleh kasi', '::1', '2026-04-09 07:15:38'),
(29, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 14, 'Menonaktifkan perusahaan ID 14', '::1', '2026-04-09 07:28:02'),
(30, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 14, 'Mengaktifkan perusahaan ID 14', '::1', '2026-04-09 07:28:03'),
(31, 2, 'Kasi 1', 'REJECT', 'tka', 12, 'Reject pengajuan TKA asdasdasdasd oleh kasi', '::1', '2026-04-09 07:52:32'),
(32, 3, 'Kabid 1', 'REJECT', 'tka', 9, 'Reject pengajuan TKA oyen bala oleh kabid', '::1', '2026-04-09 07:53:40'),
(33, 0, 'Sistem', 'USER_REGISTER', 'user', 15, 'Pendaftaran akun baru: nemo@nemo.com (Perusahaan: nemoinka)', '::1', '2026-04-09 08:45:27'),
(34, 2, 'Kasi 1', 'APPROVE', 'tka', 13, 'Approve pengajuan TKA oyen bajak laut oleh kasi', '::1', '2026-04-09 10:10:47'),
(35, 3, 'Kabid 1', 'APPROVE', 'tka', 13, 'Approve pengajuan TKA oyen bajak laut oleh kabid', '::1', '2026-04-09 10:11:14'),
(36, 4, 'Sekdis 1', 'APPROVE', 'tka', 13, 'Approve pengajuan TKA oyen bajak laut oleh sekdis', '::1', '2026-04-09 10:11:31'),
(37, 5, 'Kadis 1', 'APPROVE', 'tka', 13, 'Approve pengajuan TKA oyen bajak laut oleh kadis', '::1', '2026-04-09 10:11:50'),
(38, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Surat Keterangan TKA Siap', '::1', '2026-04-09 10:28:53'),
(39, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Surat Keterangan TKA Siap', '::1', '2026-04-09 10:29:00'),
(40, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Pengumuman Penting', '::1', '2026-04-09 10:29:11'),
(41, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Data TKA Perlu Dilengkapi', '::1', '2026-04-09 10:31:02'),
(42, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Pengumuman Penting', '::1', '2026-04-09 10:31:51'),
(43, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Data TKA Perlu Dilengkapi', '::1', '2026-04-09 10:32:16'),
(44, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Surat Keterangan TKA Siap', '::1', '2026-04-09 10:35:05'),
(45, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Verifikasi TKA Berhasil', '::1', '2026-04-09 10:59:14'),
(46, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Verifikasi TKA Berhasil', '::1', '2026-04-09 11:00:17'),
(47, 9, 'Admin Baru', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Verifikasi TKA Berhasil', '::1', '2026-04-09 18:25:57'),
(48, 0, 'Sistem', 'USER_REGISTER', 'user', 16, 'Pendaftaran akun baru: budiabadi@budiabadi.com (Perusahaan: Pt budi abadi)', '::1', '2026-04-10 10:28:46'),
(49, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 16, 'Mengirim notifikasi ke user ID 16: tidak sesuai datanya', '::1', '2026-04-10 10:34:41'),
(50, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 16, 'Menonaktifkan perusahaan ID 16', '::1', '2026-04-10 10:36:08'),
(51, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 16, 'Mengaktifkan perusahaan ID 16', '::1', '2026-04-10 10:36:38'),
(52, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-10 10:36:58'),
(53, 2, 'Kepala Seksi', 'APPROVE', 'tka', 14, 'Approve pengajuan TKA oyen oleh kasi', '::1', '2026-04-10 10:40:39'),
(54, 3, 'kepala bidang', 'APPROVE', 'tka', 14, 'Approve pengajuan TKA oyen oleh kabid', '::1', '2026-04-10 10:41:26'),
(55, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 14, 'Approve pengajuan TKA oyen oleh sekdis', '::1', '2026-04-10 10:42:03'),
(56, 5, 'kepala dinas', 'APPROVE', 'tka', 14, 'Approve pengajuan TKA oyen oleh kadis', '::1', '2026-04-10 10:42:20'),
(57, 1, 'Admin Utama', 'EDIT_TKA', 'tka', 14, 'Mengedit data TKA ID 14', '::1', '2026-04-10 10:55:28'),
(58, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-10 12:09:15'),
(59, 1, 'Admin Utama', 'EDIT_OFFICER', 'user', 5, 'Mengedit data petugas ID 5', '::1', '2026-04-10 20:19:04'),
(60, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 16, 'Menonaktifkan perusahaan ID 16', '::1', '2026-04-18 13:54:09'),
(61, 1, 'Admin Utama', 'TOGGLE_STATUS', 'user', 16, 'Mengaktifkan perusahaan ID 16', '::1', '2026-04-18 13:54:13'),
(62, 1, 'Admin Utama', 'RESET_PASSWORD', 'user', 16, 'Reset password perusahaan ID 16', '::1', '2026-04-18 13:54:22'),
(63, 1, 'Admin Utama', 'RESET_PASSWORD', 'user', 16, 'Reset password perusahaan ID 16', '::1', '2026-04-18 13:54:28'),
(64, 3, 'kepala bidang', 'APPROVE', 'tka', 8, 'Approve pengajuan TKA oyen yg oyen oleh kabid', '::1', '2026-04-18 16:28:32'),
(65, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 8, 'Approve pengajuan TKA oyen yg oyen oleh sekdis', '::1', '2026-04-18 16:28:43'),
(66, 5, 'kepala dinas', 'APPROVE', 'tka', 8, 'Approve pengajuan TKA oyen yg oyen oleh kadis', '::1', '2026-04-18 16:29:01'),
(67, 2, 'Kepala Seksi', 'APPROVE', 'tka', 11, 'Approve pengajuan TKA oyen mulolita oleh kasi', '::1', '2026-04-18 16:35:18'),
(68, 3, 'kepala bidang', 'APPROVE', 'tka', 11, 'Approve pengajuan TKA oyen mulolita oleh kabid', '::1', '2026-04-18 16:35:29'),
(69, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 11, 'Approve pengajuan TKA oyen mulolita oleh sekdis', '::1', '2026-04-18 16:36:45'),
(70, 5, 'kepala dinas', 'APPROVE', 'tka', 11, 'Approve pengajuan TKA oyen mulolita oleh kadis', '::1', '2026-04-18 16:36:56'),
(71, 2, 'Kepala Seksi', 'APPROVE', 'tka', 15, 'Approve pengajuan TKA oyen smit oleh kasi', '::1', '2026-04-18 17:01:50'),
(72, 3, 'kepala bidang', 'APPROVE', 'tka', 15, 'Approve pengajuan TKA oyen smit oleh kabid', '::1', '2026-04-18 17:02:01'),
(73, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 15, 'Approve pengajuan TKA oyen smit oleh sekdis', '::1', '2026-04-18 17:02:13'),
(74, 5, 'kepala dinas', 'APPROVE', 'tka', 15, 'Approve pengajuan TKA oyen smit oleh kadis', '::1', '2026-04-18 17:02:22'),
(75, 2, 'Kepala Seksi', 'APPROVE', 'tka', 16, 'Approve pengajuan TKA oyen oleh kasi', '::1', '2026-04-18 19:11:20'),
(76, 3, 'kepala bidang', 'APPROVE', 'tka', 16, 'Approve pengajuan TKA oyen oleh kabid', '::1', '2026-04-18 19:11:33'),
(77, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 16, 'Approve pengajuan TKA oyen oleh sekdis', '::1', '2026-04-18 19:11:44'),
(78, 5, 'kepala dinas', 'APPROVE', 'tka', 16, 'Approve pengajuan TKA oyen oleh kadis', '::1', '2026-04-18 19:11:56'),
(79, 2, 'Kepala Seksi', 'APPROVE', 'tka', 17, 'Approve pengajuan TKA oyen xxx oleh kasi', '::1', '2026-04-18 19:52:51'),
(80, 3, 'kepala bidang', 'APPROVE', 'tka', 17, 'Approve pengajuan TKA oyen xxx oleh kabid', '::1', '2026-04-18 19:53:02'),
(81, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 17, 'Approve pengajuan TKA oyen xxx oleh sekdis', '::1', '2026-04-18 19:53:13'),
(82, 5, 'kepala dinas', 'APPROVE', 'tka', 17, 'Approve pengajuan TKA oyen xxx oleh kadis', '::1', '2026-04-18 19:53:29'),
(83, 1, 'Admin Utama', 'INPUT_NOMOR_SURAT', 'tka', 17, 'Menginput nomor surat 005/HR/WI/I/2026 untuk TKA oyen xxx', '::1', '2026-04-20 16:23:41'),
(84, 1, 'Admin Utama', 'INPUT_NOMOR_SURAT', 'tka', 16, 'Menginput nomor surat 005/HW/RI/I/2026 untuk TKA oyen', '::1', '2026-04-20 16:51:36'),
(85, 2, 'Kepala Seksi', 'APPROVE', 'tka', 18, 'Approve pengajuan TKA Oyem Gembrot oleh kasi', '::1', '2026-04-21 13:03:34'),
(86, 3, 'kepala bidang', 'APPROVE', 'tka', 18, 'Approve pengajuan TKA Oyem Gembrot oleh kabid', '::1', '2026-04-21 13:03:51'),
(87, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 18, 'Approve pengajuan TKA Oyem Gembrot oleh sekdis', '::1', '2026-04-21 13:04:10'),
(88, 5, 'kepala dinas', 'APPROVE', 'tka', 18, 'Approve pengajuan TKA Oyem Gembrot oleh kadis', '::1', '2026-04-21 13:04:51'),
(89, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Surat Keterangan TKA Siap', '::1', '2026-04-21 14:18:09'),
(90, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Surat Keterangan TKA Siap', '::1', '2026-04-21 14:18:52'),
(91, 1, 'Admin Utama', 'EXPORT_PERUSAHAAN_CSV', NULL, NULL, 'Mengekspor data perusahaan ke CSV', '::1', '2026-04-21 14:22:15'),
(92, 0, 'Sistem', 'USER_REGISTER', 'user', 17, 'Pendaftaran akun baru: Nital@gmail.com (Perusahaan: Pt Nital)', '::1', '2026-04-21 16:14:50'),
(93, 2, 'Kepala Seksi', 'APPROVE', 'tka', 19, 'Approve pengajuan TKA John libau oleh kasi', '::1', '2026-04-21 17:01:59'),
(94, 3, 'kepala bidang', 'APPROVE', 'tka', 19, 'Approve pengajuan TKA John libau oleh kabid', '::1', '2026-04-21 17:02:10'),
(95, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 19, 'Approve pengajuan TKA John libau oleh sekdis', '::1', '2026-04-21 17:02:20'),
(96, 5, 'kepala dinas', 'APPROVE', 'tka', 19, 'Approve pengajuan TKA John libau oleh kadis', '::1', '2026-04-21 17:02:35'),
(97, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Surat Keterangan TKA Siap', '::1', '2026-04-22 12:51:06'),
(98, 1, 'Admin Utama', 'EXPORT_TKA_CSV', NULL, NULL, 'Mengekspor data TKA ke CSV', '::1', '2026-04-22 14:32:07'),
(99, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-22 14:37:35'),
(100, 1, 'Admin Utama', 'EXPORT_TKA_CSV', NULL, NULL, 'Mengekspor data TKA ke CSV', '::1', '2026-04-22 14:39:28'),
(101, 1, 'Admin Utama', 'EXPORT_TKA_CSV', NULL, NULL, 'Mengekspor data TKA ke CSV', '::1', '2026-04-22 14:40:40'),
(102, 1, 'Admin Utama', 'SEND_NOTIFICATION', 'user', 8, 'Mengirim notifikasi ke user ID 8: Verifikasi TKA Berhasil', '::1', '2026-04-22 14:44:28'),
(103, 1, 'Admin Utama', 'DELETE_TKA', 'tka', 1, 'Menghapus TKA oyen', '::1', '2026-04-22 15:44:33'),
(104, 1, 'Admin Utama', 'ADD_OFFICER', 'user', 23, 'Menambahkan petugas baru: hoka (role kasi)', '::1', '2026-04-22 15:56:00'),
(105, 1, 'Admin Utama', 'DELETE_OFFICER', 'user', 23, 'Menghapus petugas ID 23', '::1', '2026-04-22 15:56:13'),
(106, 2, 'Kepala Seksi', 'APPROVE', 'tka', 21, 'Approve pengajuan TKA oyen oma oleh kasi', '::1', '2026-04-22 16:23:44'),
(107, 3, 'kepala bidang', 'APPROVE', 'tka', 21, 'Approve pengajuan TKA oyen oma oleh kabid', '::1', '2026-04-22 16:24:22'),
(108, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 21, 'Approve pengajuan TKA oyen oma oleh sekdis', '::1', '2026-04-22 16:24:49'),
(109, 5, 'kepala dinas', 'APPROVE', 'tka', 21, 'Approve pengajuan TKA oyen oma oleh kadis', '::1', '2026-04-22 16:25:12'),
(110, 2, 'Kepala Seksi', 'REJECT', 'tka', 22, 'Reject pengajuan TKA oyen nyawit oleh kasi', '::1', '2026-04-22 16:52:54'),
(111, 2, 'Kepala Seksi', 'APPROVE', 'tka', 25, 'Approve pengajuan TKA oyen yg oyen oleh kasi', '::1', '2026-04-22 20:31:32'),
(112, 3, 'kepala bidang', 'REJECT', 'tka', 25, 'Reject pengajuan TKA oyen yg oyen oleh kabid', '::1', '2026-04-22 20:31:57'),
(113, 2, 'Kepala Seksi', 'APPROVE', 'tka', 24, 'Approve pengajuan TKA mana oyen oleh kasi', '::1', '2026-04-22 20:33:31'),
(114, 3, 'kepala bidang', 'APPROVE', 'tka', 24, 'Approve pengajuan TKA mana oyen oleh kabid', '::1', '2026-04-22 20:33:45'),
(115, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 24, 'Approve pengajuan TKA mana oyen oleh sekdis', '::1', '2026-04-22 20:33:56'),
(116, 5, 'kepala dinas', 'APPROVE', 'tka', 24, 'Approve pengajuan TKA mana oyen dede oleh kadis', '::1', '2026-04-22 20:34:44'),
(117, 2, 'Kepala Seksi', 'APPROVE', 'tka', 28, 'Approve pengajuan TKA oyen yg oyen oleh kasi', '::1', '2026-04-22 21:11:03'),
(118, 2, 'Kepala Seksi', 'APPROVE', 'tka', 29, 'Approve pengajuan TKA oyen yag oyen oleh kasi', '::1', '2026-04-22 21:53:52'),
(119, 1, 'Admin Utama', 'RESET_PASSWORD', 'user', 27, 'Reset password perusahaan ID 27', '::1', '2026-04-23 07:33:01'),
(120, 2, 'Kepala Seksi', 'REJECT', 'tka', 32, 'Reject pengajuan TKA kim jong un oleh kasi', '::1', '2026-04-23 12:31:24'),
(121, 2, 'Kepala Seksi', 'REJECT', 'tka', 32, 'Reject pengajuan TKA kim jong un oleh kasi', '::1', '2026-04-23 12:56:58'),
(122, 2, 'Kepala Seksi', 'APPROVE', 'tka', 32, 'Approve pengajuan TKA kim jong un oleh kasi', '::1', '2026-04-23 12:57:57'),
(123, 1, 'Admin Utama', 'ADD_OFFICER', 'user', 30, 'Menambahkan petugas baru: maca (role operator)', '::1', '2026-04-23 13:20:13'),
(124, 1, 'Admin Utama', 'ADD_OFFICER', 'user', 31, 'Menambahkan petugas baru: Operator 1 (role operator)', '::1', '2026-04-23 17:02:39'),
(125, 1, 'Admin Utama', 'DELETE_OFFICER', 'user', 30, 'Menghapus petugas ID 30', '::1', '2026-04-23 17:02:47'),
(126, 1, 'Admin Utama', 'ADD_OFFICER', 'user', 32, 'Menambahkan petugas baru: admin operator (role admin)', '::1', '2026-04-23 17:09:39'),
(127, 1, 'Admin Utama', 'EDIT_OFFICER', 'user', 32, 'Mengedit data petugas ID 32', '::1', '2026-04-23 17:12:28'),
(128, 1, 'Admin Utama', 'EDIT_OFFICER', 'user', 32, 'Mengedit data petugas ID 32', '::1', '2026-04-23 17:12:40'),
(129, 1, 'Admin Utama', 'EDIT_OFFICER', 'user', 31, 'Mengedit data petugas ID 31', '::1', '2026-04-23 17:13:23'),
(130, 1, 'Admin Utama', 'DELETE_OFFICER', 'user', 31, 'Menghapus petugas ID 31', '::1', '2026-04-23 17:17:16'),
(131, 1, 'Admin Utama', 'ADD_OFFICER', 'user', 33, 'Menambahkan petugas baru: admin (role kasi)', '::1', '2026-04-23 17:17:48'),
(132, 1, 'Admin Utama', 'EDIT_OFFICER', 'user', 33, 'Mengedit data petugas ID 33', '::1', '2026-04-23 17:19:42'),
(133, 1, 'Admin Utama', 'EDIT_OFFICER', 'user', 33, 'Mengedit data petugas ID 33', '::1', '2026-04-23 17:20:08'),
(134, 1, 'Admin Utama', 'EDIT_OFFICER', 'user', 33, 'Mengedit data petugas ID 33', '::1', '2026-04-23 17:21:00'),
(135, 1, 'Admin Utama', 'EDIT_OFFICER', 'user', 33, 'Mengedit data petugas ID 33', '::1', '2026-04-23 17:21:34'),
(136, 1, 'Admin Utama', 'EDIT_OFFICER', 'user', 32, 'Mengedit data petugas ID 32', '::1', '2026-04-23 17:47:50'),
(137, 32, 'admin operator', 'EDIT_OFFICER', 'user', 32, 'Mengedit data petugas ID 32', '::1', '2026-04-23 17:49:01'),
(138, 2, 'Kepala Seksi', 'REJECT', 'tka', 26, 'Reject pengajuan TKA oyen yg oyen oleh kasi', '::1', '2026-04-24 12:55:31'),
(139, 1, 'Admin Utama', 'EDIT_USER', 'user', 34, 'Mengedit data perusahaan ID 34', '::1', '2026-04-24 16:16:46'),
(140, 1, 'Admin Utama', 'EDIT_USER', 'user', 28, 'Mengedit data perusahaan ID 28', '::1', '2026-04-24 16:30:41'),
(141, 1, 'Admin Utama', 'EXPORT_PERUSAHAAN_CSV', NULL, NULL, 'Mengekspor data perusahaan ke CSV', '::1', '2026-04-24 16:45:53'),
(142, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-24 16:57:31'),
(143, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 2-2026', '::1', '2026-04-25 08:47:30'),
(144, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 09:52:41'),
(145, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 09:57:43'),
(146, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 2-2026', '::1', '2026-04-25 09:59:55'),
(147, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 13:51:40'),
(148, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 13:55:05'),
(149, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 13:56:05'),
(150, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 3-2026', '::1', '2026-04-25 13:58:14'),
(151, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:03:28'),
(152, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:04:34'),
(153, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:09:20'),
(154, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:10:12'),
(155, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:14:42'),
(156, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:15:36'),
(157, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:16:12'),
(158, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:18:10'),
(159, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:19:00'),
(160, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:19:32'),
(161, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:24:48'),
(162, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:25:30'),
(163, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 14:31:23'),
(164, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 16:56:24'),
(165, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:02:09'),
(166, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:04:42'),
(167, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:05:56'),
(168, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:07:19'),
(169, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:08:01'),
(170, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:08:59'),
(171, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:15:34'),
(172, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:16:51'),
(173, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:20:36'),
(174, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:21:49'),
(175, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:22:59'),
(176, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:24:28'),
(177, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:25:23'),
(178, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:28:55'),
(179, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:30:19'),
(180, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:32:02'),
(181, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:34:18'),
(182, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:39:14'),
(183, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:41:51'),
(184, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:43:00'),
(185, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:47:30'),
(186, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:50:47'),
(187, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:54:11'),
(188, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 17:58:03'),
(189, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 18:00:18'),
(190, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 18:02:14'),
(191, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 18:05:36'),
(192, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 4-2026', '::1', '2026-04-25 18:06:39'),
(193, 1, 'Admin Utama', 'CETAK_LAPORAN', NULL, NULL, 'Cetak laporan bulanan 3-2026', '::1', '2026-04-28 13:32:47'),
(194, 3, 'kepala bidang', 'APPROVE', 'tka', 34, 'Approve pengajuan TKA KOMOKIYAKAWA oleh kabid', '::1', '2026-04-28 13:43:52'),
(195, 4, 'Sekretaris Dinas ', 'APPROVE', 'tka', 34, 'Approve pengajuan TKA KOMOKIYAKAWA oleh sekdis', '::1', '2026-04-28 13:44:37'),
(196, 5, 'kepala dinas', 'APPROVE', 'tka', 34, 'Approve pengajuan TKA KOMOKIYAKAWA oleh kadis', '::1', '2026-04-28 13:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `approval_log`
--

CREATE TABLE `approval_log` (
  `id` int(11) NOT NULL,
  `tka_id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('approve','reject') NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `sla_deadline` datetime DEFAULT NULL,
  `warned_at` datetime DEFAULT NULL,
  `is_overdue` tinyint(1) DEFAULT 0,
  `escalated_at` datetime DEFAULT NULL,
  `delegated_to` int(11) DEFAULT NULL,
  `delegated_by` int(11) DEFAULT NULL,
  `delegated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approval_log`
--

INSERT INTO `approval_log` (`id`, `tka_id`, `role`, `level`, `user_id`, `status`, `catatan`, `created_at`, `sla_deadline`, `warned_at`, `is_overdue`, `escalated_at`, `delegated_to`, `delegated_by`, `delegated_at`) VALUES
(5, 6, 'kasi', NULL, NULL, 'approve', '', '2026-04-07 15:53:09', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(6, 6, 'kabid', NULL, NULL, 'approve', '', '2026-04-07 15:53:29', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(7, 6, 'sekdis', NULL, NULL, 'approve', '', '2026-04-07 15:54:03', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(8, 6, 'kadis', NULL, NULL, 'approve', '', '2026-04-07 15:54:24', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(10, 3, 'kasi', NULL, NULL, 'reject', 'sama tidak jelas', '2026-04-07 15:56:07', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(11, 4, 'kasi', NULL, NULL, 'reject', 'ini juga', '2026-04-07 15:56:14', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(13, 7, 'kasi', NULL, NULL, 'approve', '', '2026-04-07 18:06:17', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(14, 7, 'kabid', NULL, NULL, 'approve', '', '2026-04-07 18:15:58', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(15, 7, 'sekdis', NULL, NULL, 'approve', '', '2026-04-07 18:16:30', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(16, 7, 'kadis', NULL, NULL, 'approve', '', '2026-04-07 18:16:49', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(17, 8, 'kasi', NULL, NULL, 'approve', '', '2026-04-08 06:51:31', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(18, 9, 'kasi', NULL, NULL, 'approve', '', '2026-04-09 07:15:38', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(19, 12, 'kasi', NULL, NULL, 'reject', 'belom isi Data Detail yang Diisi Perusahaan', '2026-04-09 07:52:32', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(20, 9, 'kabid', NULL, NULL, 'reject', 'belom isi form', '2026-04-09 07:53:40', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(21, 13, 'kasi', NULL, NULL, 'approve', 'aman', '2026-04-09 10:10:47', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(22, 13, 'kabid', NULL, NULL, 'approve', 'aman', '2026-04-09 10:11:13', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(23, 13, 'sekdis', NULL, NULL, 'approve', 'aman', '2026-04-09 10:11:31', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(24, 13, 'kadis', NULL, NULL, 'approve', 'aman', '2026-04-09 10:11:50', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(25, 14, 'kasi', NULL, NULL, 'approve', '', '2026-04-10 10:40:39', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(26, 14, 'kabid', NULL, NULL, 'approve', 'sjbhshsghgsh', '2026-04-10 10:41:26', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(27, 14, 'sekdis', NULL, NULL, 'approve', '', '2026-04-10 10:42:03', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(28, 14, 'kadis', NULL, NULL, 'approve', '', '2026-04-10 10:42:20', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(29, 8, 'kabid', NULL, NULL, 'approve', '', '2026-04-18 16:28:32', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(30, 8, 'sekdis', NULL, NULL, 'approve', '', '2026-04-18 16:28:43', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(31, 8, 'kadis', NULL, NULL, 'approve', '', '2026-04-18 16:29:01', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(32, 11, 'kasi', NULL, NULL, 'approve', '', '2026-04-18 16:35:18', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(33, 11, 'kabid', NULL, NULL, 'approve', '', '2026-04-18 16:35:29', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(34, 11, 'sekdis', NULL, NULL, 'approve', '', '2026-04-18 16:36:45', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(35, 11, 'kadis', NULL, NULL, 'approve', '', '2026-04-18 16:36:56', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(36, 15, 'kasi', NULL, NULL, 'approve', '', '2026-04-18 17:01:50', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(37, 15, 'kabid', NULL, NULL, 'approve', '', '2026-04-18 17:02:01', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(38, 15, 'sekdis', NULL, NULL, 'approve', '', '2026-04-18 17:02:13', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(39, 15, 'kadis', NULL, NULL, 'approve', '', '2026-04-18 17:02:22', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(40, 16, 'kasi', NULL, NULL, 'approve', '', '2026-04-18 19:11:20', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(41, 16, 'kabid', NULL, NULL, 'approve', '', '2026-04-18 19:11:33', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(42, 16, 'sekdis', NULL, NULL, 'approve', '', '2026-04-18 19:11:44', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(43, 16, 'kadis', NULL, NULL, 'approve', '', '2026-04-18 19:11:56', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(44, 17, 'kasi', NULL, NULL, 'approve', '', '2026-04-18 19:52:51', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(45, 17, 'kabid', NULL, NULL, 'approve', '', '2026-04-18 19:53:02', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(46, 17, 'sekdis', NULL, NULL, 'approve', '', '2026-04-18 19:53:13', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(47, 17, 'kadis', NULL, NULL, 'approve', '', '2026-04-18 19:53:29', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(48, 18, 'kasi', NULL, NULL, 'approve', 'aman', '2026-04-21 13:03:34', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(49, 18, 'kabid', NULL, NULL, 'approve', 'next', '2026-04-21 13:03:51', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(50, 18, 'sekdis', NULL, NULL, 'approve', 'next lagi', '2026-04-21 13:04:10', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(51, 18, 'kadis', NULL, NULL, 'approve', 'sipp mnice', '2026-04-21 13:04:51', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(52, 19, 'kasi', NULL, NULL, 'approve', '', '2026-04-21 17:01:59', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(53, 19, 'kabid', NULL, NULL, 'approve', '', '2026-04-21 17:02:10', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(54, 19, 'sekdis', NULL, NULL, 'approve', '', '2026-04-21 17:02:20', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(55, 19, 'kadis', NULL, NULL, 'approve', '', '2026-04-21 17:02:35', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(56, 21, 'kasi', NULL, NULL, 'approve', '', '2026-04-22 16:23:44', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(57, 21, 'kabid', NULL, NULL, 'approve', '', '2026-04-22 16:24:22', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(58, 21, 'sekdis', NULL, NULL, 'approve', '', '2026-04-22 16:24:49', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(59, 21, 'kadis', NULL, NULL, 'approve', '', '2026-04-22 16:25:12', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(60, 22, 'kasi', NULL, NULL, 'reject', '#anti oyen', '2026-04-22 16:52:54', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(61, 25, 'kasi', NULL, NULL, 'approve', NULL, '2026-04-22 20:31:32', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(62, 25, 'kabid', NULL, NULL, 'reject', 'blablabla', '2026-04-22 20:31:57', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(63, 24, 'kasi', NULL, NULL, 'approve', NULL, '2026-04-22 20:33:31', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(64, 24, 'kabid', NULL, NULL, 'approve', NULL, '2026-04-22 20:33:45', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(65, 24, 'sekdis', NULL, NULL, 'approve', NULL, '2026-04-22 20:33:56', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(66, 24, 'kadis', NULL, NULL, 'approve', NULL, '2026-04-22 20:34:44', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(67, 28, 'kasi', NULL, NULL, 'approve', NULL, '2026-04-22 21:11:03', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(68, 29, 'kasi', NULL, NULL, 'approve', NULL, '2026-04-22 21:53:52', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(69, 32, 'kasi', NULL, NULL, 'reject', 'belom', '2026-04-23 12:31:24', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(70, 32, 'kasi', NULL, NULL, 'reject', 'kurang jelas', '2026-04-23 12:56:58', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(71, 32, 'kasi', NULL, NULL, 'approve', NULL, '2026-04-23 12:57:57', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(72, 26, 'kasi', NULL, NULL, 'reject', 'belom mengisi data diri', '2026-04-24 12:55:31', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(73, 34, 'kasi', NULL, NULL, 'approve', NULL, '2026-04-28 13:40:12', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(74, 33, 'kasi', NULL, NULL, 'approve', NULL, '2026-04-28 13:41:59', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(75, 33, '', 2, NULL, '', 'Diteruskan dari Kepala Seksi', '2026-04-28 13:41:59', '2026-04-30 13:41:59', NULL, 0, NULL, NULL, NULL, NULL),
(76, 34, 'kabid', NULL, NULL, 'approve', NULL, '2026-04-28 13:43:52', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(77, 34, '', 3, NULL, '', 'Diteruskan dari Kepala Bidang', '2026-04-28 13:43:52', '2026-05-01 13:43:52', NULL, 0, NULL, NULL, NULL, NULL),
(78, 34, 'sekdis', NULL, NULL, 'approve', NULL, '2026-04-28 13:44:37', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(79, 34, '', 4, NULL, '', 'Diteruskan dari Sekretaris Dinas', '2026-04-28 13:44:37', '2026-05-01 13:44:37', NULL, 0, NULL, NULL, NULL, NULL),
(80, 34, 'kadis', NULL, NULL, 'approve', 'clear', '2026-04-28 13:47:06', NULL, NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `approval_sla`
--

CREATE TABLE `approval_sla` (
  `id` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL COMMENT '1=Kasi,2=Kabid,3=Sekdis,4=Kadis',
  `nama_level` varchar(50) NOT NULL,
  `sla_jam` int(11) NOT NULL COMMENT 'deadline dalam jam',
  `reminder_jam` int(11) DEFAULT NULL COMMENT 'jam ke berapa reminder dikirim',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approval_sla`
--

INSERT INTO `approval_sla` (`id`, `level`, `nama_level`, `sla_jam`, `reminder_jam`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kepala Seksi', 48, 24, '2026-04-28 12:44:38', '2026-04-28 12:44:38'),
(2, 2, 'Kepala Bidang', 48, 24, '2026-04-28 12:44:38', '2026-04-28 12:44:38'),
(3, 3, 'Sekretaris Dinas', 72, 48, '2026-04-28 12:44:38', '2026-04-28 12:44:38'),
(4, 4, 'Kepala Dinas', 72, 48, '2026-04-28 12:44:38', '2026-04-28 12:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `berkas`
--

CREATE TABLE `berkas` (
  `id` int(11) NOT NULL,
  `tka_id` int(11) NOT NULL,
  `surat_permohonan` varchar(255) DEFAULT NULL,
  `passport` varchar(255) DEFAULT NULL,
  `kitas` varchar(255) DEFAULT NULL,
  `stm` varchar(255) DEFAULT NULL,
  `rptka` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `surat_kuasa` varchar(255) DEFAULT NULL,
  `ktp` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berkas`
--

INSERT INTO `berkas` (`id`, `tka_id`, `surat_permohonan`, `passport`, `kitas`, `stm`, `rptka`, `notifikasi`, `bukti_bayar`, `surat_kuasa`, `ktp`, `foto`) VALUES
(1, 6, '6_surat_permohonan_1775551846.pdf', '6_passport_1775551846.pdf', '6_kitas_1775551846.pdf', '6_stm_1775551846.pdf', '6_rptka_1775551847.pdf', '6_notifikasi_1775551847.pdf', '6_bukti_bayar_1775551847.pdf', '6_surat_kuasa_1775551847.pdf', '6_ktp_1775551847.jpg', '6_foto_1775551847.jpg'),
(2, 7, '7_surat_permohonan_1775559656.pdf', '7_passport_1775559656.pdf', '7_kitas_1775559656.pdf', '7_stm_1775559656.pdf', '7_rptka_1775559656.pdf', '7_notifikasi_1775559656.pdf', '7_bukti_bayar_1775559656.pdf', '7_surat_kuasa_1775559656.pdf', '7_ktp_1775559656.jpg', '7_foto_1775559656.jpg'),
(3, 8, '8_surat_permohonan_1775604357.pdf', '8_passport_1775604357.pdf', '8_kitas_1775604357.pdf', '8_stm_1775604357.pdf', '8_rptka_1775604357.pdf', '8_notifikasi_1775604357.pdf', '8_bukti_bayar_1775604357.pdf', '8_surat_kuasa_1775604357.pdf', '8_ktp_1775604357.jpg', '8_foto_1775604357.jpg'),
(4, 9, '9_surat_permohonan_1775633592.pdf', '9_passport_1775633592.pdf', '9_kitas_1775633592.pdf', '9_stm_1775633592.pdf', '9_rptka_1775633592.pdf', '9_notifikasi_1775633592.pdf', '9_bukti_bayar_1775633592.pdf', '9_surat_kuasa_1775633592.pdf', '9_ktp_1775633592.jpg', '9_foto_1775633592.jpg'),
(5, 11, '11_surat_permohonan_1775693979.pdf', '11_passport_1775693979.pdf', '11_kitas_1775693979.pdf', '11_stm_1775693979.pdf', '11_rptka_1775693979.pdf', '11_notifikasi_1775693979.pdf', '11_bukti_bayar_1775693979.pdf', '11_surat_kuasa_1775693979.pdf', '11_ktp_1775693979.jpg', '11_foto_1775693979.jpeg'),
(6, 12, '12_surat_permohonan_1775695640.pdf', '12_passport_1775695640.pdf', '12_kitas_1775695640.pdf', '12_stm_1775695640.pdf', '12_rptka_1775695640.pdf', '12_notifikasi_1775695640.pdf', '12_bukti_bayar_1775695640.pdf', '12_surat_kuasa_1775695640.pdf', '12_ktp_1775695640.jpg', '12_foto_1775695641.jpg'),
(7, 13, '13_surat_permohonan_1775704181.pdf', '13_passport_1775704181.pdf', '13_kitas_1775704181.pdf', '13_stm_1775704181.pdf', '13_rptka_1775704181.pdf', '13_notifikasi_1775704181.pdf', '13_bukti_bayar_1775704181.pdf', '13_surat_kuasa_1775704181.pdf', '13_ktp_1775704181.jpg', '13_foto_1775704181.jpg'),
(8, 14, '14_surat_permohonan_1775791863.pdf', '14_passport_1775791863.pdf', '14_kitas_1775791863.pdf', '14_stm_1775791863.pdf', '14_rptka_1775791863.pdf', '14_notifikasi_1775791863.pdf', '14_bukti_bayar_1775791863.pdf', '14_surat_kuasa_1775791863.pdf', '14_ktp_1775791863.jpg', '14_foto_1775791863.jpg'),
(9, 15, '15_surat_permohonan_1776506362.pdf', '15_passport_1776506362.pdf', '15_kitas_1776506362.pdf', '15_stm_1776506362.pdf', '15_rptka_1776506362.pdf', '15_notifikasi_1776506362.pdf', '15_bukti_bayar_1776506362.pdf', '15_surat_kuasa_1776506362.pdf', '15_ktp_1776506362.jpeg', '15_foto_1776506362.jpeg'),
(10, 16, '16_surat_permohonan_1776514148.pdf', '16_passport_1776514148.pdf', '16_kitas_1776514148.pdf', '16_stm_1776514148.pdf', '16_rptka_1776514148.pdf', '16_notifikasi_1776514148.pdf', '16_bukti_bayar_1776514148.pdf', '16_surat_kuasa_1776514149.pdf', '16_ktp_1776514149.jpeg', '16_foto_1776514149.jpeg'),
(11, 17, '17_surat_permohonan_1776516711.pdf', '17_passport_1776516711.pdf', '17_kitas_1776516711.pdf', '17_stm_1776516711.pdf', '17_rptka_1776516711.pdf', '17_notifikasi_1776516711.pdf', '17_bukti_bayar_1776516711.pdf', '17_surat_kuasa_1776516711.pdf', '17_ktp_1776516711.jpeg', '17_foto_1776516711.jpeg'),
(12, 18, '18_surat_permohonan_1776751230.pdf', '18_passport_1776751230.pdf', '18_kitas_1776751230.pdf', '18_stm_1776751230.pdf', '18_rptka_1776751230.pdf', '18_notifikasi_1776751230.pdf', '18_bukti_bayar_1776751230.pdf', '18_surat_kuasa_1776751230.pdf', '18_ktp_1776751230.jpg', '18_foto_1776751230.jpg'),
(13, 19, '19_surat_permohonan_1776763095.pdf', '19_passport_1776763095.pdf', '19_kitas_1776763095.pdf', '19_stm_1776763095.pdf', '19_rptka_1776763095.pdf', '19_notifikasi_1776763095.pdf', '19_bukti_bayar_1776763095.pdf', '19_surat_kuasa_1776763095.pdf', '19_ktp_1776763095.jpg', '19_foto_1776763095.jpg'),
(14, 21, '21_surat_permohonan_1776849079.pdf', '21_passport_1776849079.pdf', '21_kitas_1776849079.pdf', '21_stm_1776849079.pdf', '21_rptka_1776849079.pdf', '21_notifikasi_1776849079.pdf', '21_bukti_bayar_1776849079.pdf', '21_surat_kuasa_1776849079.pdf', '21_ktp_1776849079.jpg', '21_foto_1776849079.jpg'),
(15, 22, '22_surat_permohonan_1776850499.pdf', '22_passport_1776850499.pdf', '22_kitas_1776850499.pdf', '22_stm_1776850499.pdf', '22_rptka_1776850499.pdf', '22_notifikasi_1776850499.pdf', '22_bukti_bayar_1776850499.pdf', '22_surat_kuasa_1776850499.pdf', '22_ktp_1776850499.jpg', '22_foto_1776850499.jpg'),
(17, 24, '24_surat_permohonan_1776864122.pdf', '24_passport_1776861152.pdf', '24_kitas_1776861152.pdf', '24_stm_1776861152.pdf', '24_rptka_1776861152.pdf', '24_notifikasi_1776861152.pdf', '24_bukti_bayar_1776861152.pdf', '24_surat_kuasa_1776861152.pdf', '24_ktp_1776861152.jpg', '24_foto_1776861152.jpg'),
(18, 25, '25_surat_permohonan_1776862416.pdf', '25_passport_1776862416.pdf', '25_kitas_1776862416.pdf', '25_stm_1776862416.pdf', '25_rptka_1776862416.pdf', '25_notifikasi_1776862416.pdf', '25_bukti_bayar_1776862416.pdf', '25_surat_kuasa_1776862416.pdf', '25_ktp_1776862416.jpg', '25_foto_1776862416.jpg'),
(19, 26, '26_surat_permohonan_1776865922.pdf', '26_passport_1776865922.pdf', '26_kitas_1776865922.pdf', '26_stm_1776865922.pdf', '26_rptka_1776865922.pdf', '26_notifikasi_1776865922.pdf', '26_bukti_bayar_1776865922.pdf', '26_surat_kuasa_1776865922.pdf', '26_ktp_1776865922.jpg', '26_foto_1776865922.jpg'),
(20, 28, '28_surat_permohonan_1776866314.pdf', '28_passport_1776866314.pdf', '28_kitas_1776866314.pdf', '28_stm_1776866314.pdf', '28_rptka_1776866314.pdf', '28_notifikasi_1776866314.pdf', '28_bukti_bayar_1776866314.pdf', '28_surat_kuasa_1776866314.pdf', '28_ktp_1776866314.jpg', '28_foto_1776866314.jpg'),
(21, 29, '29_surat_permohonan_1776866508.pdf', '29_passport_1776866508.pdf', '29_kitas_1776866508.pdf', '29_stm_1776866508.pdf', '29_rptka_1776866508.pdf', '29_notifikasi_1776866508.pdf', '29_bukti_bayar_1776866508.pdf', '29_surat_kuasa_1776866508.pdf', '29_ktp_1776866508.jpg', '29_foto_1776866508.jpg'),
(22, 30, '30_surat_permohonan_1776870388.pdf', '30_passport_1776870388.pdf', '30_kitas_1776870388.pdf', '30_stm_1776870388.pdf', '30_rptka_1776870388.pdf', '30_notifikasi_1776870388.pdf', '30_bukti_bayar_1776870388.pdf', '30_surat_kuasa_1776870388.pdf', '30_ktp_1776870388.jpg', '30_foto_1776870388.jpg'),
(24, 32, '32_surat_permohonan_1776923586.pdf', '32_passport_1776922078.pdf', NULL, '32_stm_1776922078.pdf', '32_rptka_1776922078.pdf', '32_notifikasi_1776922078.pdf', '32_bukti_bayar_1776922078.pdf', '32_surat_kuasa_1776922078.pdf', '32_ktp_1776922078.jpg', '32_foto_1776922078.jpg'),
(25, 33, '33_surat_permohonan_1777355998.pdf', '33_passport_1777355998.pdf', '33_kitas_1777355998.pdf', '33_stm_1777355998.pdf', '33_rptka_1777355998.pdf', '33_notifikasi_1777355998.pdf', '33_bukti_bayar_1777355998.pdf', '33_surat_kuasa_1777355998.pdf', '33_ktp_1777355998.jpg', '33_foto_1777355998.jpg'),
(26, 34, '34_surat_permohonan_1777358204.pdf', '34_passport_1777358204.pdf', '34_kitas_1777358204.pdf', '34_stm_1777358204.pdf', '34_rptka_1777358204.pdf', '34_notifikasi_1777358204.pdf', '34_bukti_bayar_1777358204.pdf', '34_surat_kuasa_1777358204.pdf', '34_ktp_1777358204.jpg', '34_foto_1777358204.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `is_read_admin` tinyint(1) DEFAULT 0,
  `is_read_user` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `from_user_id`, `to_user_id`, `message`, `is_read`, `is_read_admin`, `is_read_user`, `created_at`) VALUES
(1, 8, 1, 'halo', 1, 1, 0, '2026-04-09 11:42:47'),
(2, 8, 1, 'halo', 1, 1, 0, '2026-04-09 11:42:54'),
(3, 1, 8, 'heyooo', 1, 0, 1, '2026-04-09 11:43:05'),
(4, 8, 1, 'halooo', 1, 1, 0, '2026-04-09 11:48:02'),
(5, 1, 8, 'test', 1, 0, 1, '2026-04-09 11:48:55'),
(6, 8, 1, 'test123', 1, 1, 0, '2026-04-09 11:49:14'),
(7, 8, 1, 'test', 1, 1, 0, '2026-04-09 11:51:11'),
(8, 8, 1, 'pak kenapa isi webnya eror yaaa', 1, 1, 0, '2026-04-09 11:51:43'),
(9, 1, 8, 'eror dibagian apa ya pak biar bisa kami cek', 1, 0, 1, '2026-04-09 11:52:15'),
(10, 14, 1, 'heyoooo', 1, 1, 0, '2026-04-09 16:29:17'),
(11, 16, 1, 'info acc kasi kapan', 1, 1, 0, '2026-04-10 10:32:46'),
(12, 1, 16, 'tanggal 7 april', 1, 0, 0, '2026-04-10 10:35:05'),
(13, 16, 1, 'baik min', 1, 1, 0, '2026-04-10 10:35:22'),
(14, 8, 1, 'test', 1, 1, 0, '2026-04-10 11:58:28'),
(15, 8, 1, 'tes', 1, 1, 0, '2026-04-21 14:37:28'),
(16, 8, 1, 'test', 0, 1, 0, '2026-04-21 14:48:43'),
(17, 8, 1, 'tes', 0, 1, 0, '2026-04-21 14:49:13'),
(18, 1, 8, 'test', 0, 0, 1, '2026-04-21 14:51:50'),
(19, 1, 8, 'tes', 0, 0, 1, '2026-04-24 15:49:26'),
(20, 8, 1, 'tes', 0, 1, 0, '2026-04-24 15:49:37'),
(21, 8, 1, 'sadada', 0, 1, 0, '2026-04-24 15:49:39'),
(22, 8, 1, 'asda', 0, 1, 0, '2026-04-24 15:49:39'),
(23, 8, 1, 'assdas', 0, 1, 0, '2026-04-24 15:49:40'),
(24, 8, 1, 'as', 0, 1, 0, '2026-04-24 15:49:40'),
(25, 8, 1, 'as', 0, 1, 0, '2026-04-24 15:49:41'),
(26, 8, 1, 'asda', 0, 1, 0, '2026-04-24 15:49:41'),
(27, 1, 8, 'asdadsnadadnakdkasd', 0, 0, 1, '2026-04-24 15:50:02'),
(28, 8, 1, 'test', 0, 1, 0, '2026-04-24 16:02:29'),
(29, 8, 1, 'test', 0, 1, 0, '2026-04-24 16:03:14'),
(30, 8, 1, 'test', 0, 1, 0, '2026-04-24 16:03:34'),
(31, 1, 8, 'test', 0, 0, 1, '2026-04-25 10:01:01'),
(32, 1, 8, 'ses', 0, 0, 1, '2026-04-25 10:01:09'),
(33, 1, 8, 'tes', 0, 0, 1, '2026-04-25 10:02:17'),
(34, 8, 1, 'asdasdasd', 0, 1, 0, '2026-04-25 10:02:25'),
(35, 8, 1, 'asdasdasd', 0, 1, 0, '2026-04-25 10:02:27'),
(36, 8, 1, 'asdasda', 0, 1, 0, '2026-04-25 10:02:28'),
(37, 8, 1, 'adasd', 0, 1, 0, '2026-04-25 10:02:29'),
(38, 8, 1, 'adadsa', 0, 1, 0, '2026-04-25 10:02:30'),
(39, 8, 1, 'heyo', 0, 1, 0, '2026-04-25 10:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('ne8is0pde4hbepuplpaq1t91rr83vvgb', '::1', 1777354633, ''),
('hnt4qoje3brmelhpjgkfl5pod3rmjump', '::1', 1777359973, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373335393039333b6c6f676765645f696e7c623a313b757365725f69647c733a313a2231223b6e616d617c733a31313a2241646d696e205574616d61223b726f6c657c733a353a2261646d696e223b7065727573616861616e7c733a353a2244696e6173223b),
('nlh2vahd9kohtooplfqn5g5nf755me2l', '::1', 1777360029, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737373335393936313b6c6f676765645f696e7c623a313b757365725f69647c733a323a223239223b6e616d617c733a343a226d6f6c69223b726f6c657c733a343a2275736572223b7065727573616861616e7c733a31393a2250542e206e656d6f20696b616e206162616469223b);

-- --------------------------------------------------------

--
-- Table structure for table `escalation_log`
--

CREATE TABLE `escalation_log` (
  `id` int(11) NOT NULL,
  `tka_id` int(11) NOT NULL,
  `dari_user_id` int(11) DEFAULT NULL COMMENT 'user yang mengirim eskalasi (bisa NULL jika sistem)',
  `ke_user_id` int(11) NOT NULL COMMENT 'user penerima notifikasi eskalasi',
  `level_asal` tinyint(4) NOT NULL COMMENT 'level yang overdue',
  `jenis` enum('eskalasi','overdue_warning','force_approve') NOT NULL DEFAULT 'eskalasi',
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT 'info',
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `link`, `is_read`, `created_at`) VALUES
(1, 1, 'Notifikasi Uji Coba', 'Ini adalah notifikasi testing untuk melihat lonceng.', 'info', NULL, 0, '2026-04-09 09:16:17'),
(2, 8, 'Selamat Datang!', 'Ini adalah notifikasi pertama Anda. Admin akan mengirim notifikasi jika surat sudah siap.', 'info', NULL, 1, '2026-04-09 09:38:58'),
(3, 8, 'Surat Keterangan TKA Siap', 'Surat keterangan untuk TKA atas nama [Nama TKA] telah selesai. Silakan download di menu Data TKA.', 'info', '', 1, '2026-04-09 05:28:53'),
(4, 8, 'Surat Keterangan TKA Siap', 'Surat keterangan untuk TKA atas nama [Nama TKA] telah selesai. Silakan download di menu Data TKA.', 'info', '', 1, '2026-04-09 05:29:00'),
(5, 8, 'Pengumuman Penting', 'Ada pembaruan sistem. Mohon perhatikan informasi terbaru di website.', 'info', '', 1, '2026-04-09 05:29:11'),
(6, 8, 'Data TKA Perlu Dilengkapi', 'Data detail TKA Anda belum lengkap. Silakan lengkapi di menu Data TKA.', 'info', '', 1, '2026-04-09 05:31:02'),
(7, 8, 'Pengumuman Penting', 'Ada pembaruan sistem. Mohon perhatikan informasi terbaru di website.', 'info', '', 1, '2026-04-09 05:31:51'),
(8, 8, 'Data TKA Perlu Dilengkapi', 'Data detail TKA Anda belum lengkap. Silakan lengkapi di menu Data TKA.', 'info', '', 1, '2026-04-09 05:32:16'),
(9, 8, 'Surat Keterangan TKA Siap', 'Surat keterangan untuk TKA atas nama [Nama TKA] telah selesai. Silakan download di menu Data TKA.', 'info', '', 1, '2026-04-09 05:35:05'),
(10, 8, 'Verifikasi TKA Berhasil', 'Pengajuan TKA Anda telah diverifikasi dan disetujui. Status dapat dilihat di dashboard.', 'info', '', 1, '2026-04-09 05:59:14'),
(11, 8, 'Verifikasi TKA Berhasil', 'Pengajuan TKA Anda telah diverifikasi dan disetujui. Status dapat dilihat di dashboard.', 'info', '', 1, '2026-04-09 11:00:17'),
(12, 8, 'Verifikasi TKA Berhasil', 'Pengajuan TKA Anda telah diverifikasi dan disetujui. Status dapat dilihat di dashboard.', 'info', '', 1, '2026-04-09 18:25:57'),
(13, 16, 'tidak sesuai datanya', 'nomor rptka', 'info', '', 0, '2026-04-10 10:34:41'),
(14, 8, 'Surat Keterangan TKA Siap', 'Surat keterangan untuk TKA oyen xxx telah siap. Silakan download di menu Data TKA.', 'info', 'http://localhost/tka/user/data_tka', 1, '2026-04-20 16:23:41'),
(15, 8, 'Surat Keterangan TKA Siap', 'Surat keterangan untuk TKA oyen telah siap. Silakan download di menu Data TKA.', 'info', 'http://localhost/tka/user/data_tka', 1, '2026-04-20 16:51:36'),
(16, 8, 'Nomor Surat Telah Ditentukan', 'Nomor surat untuk TKA oyen xxx telah siap. Silakan download surat.', 'info', 'http://localhost/tka/user/detail/17', 1, '2026-04-21 12:08:58'),
(17, 8, 'Nomor Surat Telah Ditentukan', 'Nomor surat untuk TKA Oyem Gembrot telah siap. Silakan download surat.', 'info', 'http://localhost/tka/user/detail/18', 1, '2026-04-21 13:05:49'),
(18, 8, 'Surat Keterangan TKA Siap', 'Surat keterangan untuk TKA atas nama [Nama TKA] telah selesai. Silakan download di menu Data TKA.', 'info', '', 1, '2026-04-21 14:18:09'),
(19, 8, 'Surat Keterangan TKA Siap', 'Surat keterangan untuk TKA atas nama oyen gembrot telah selesai. Silakan download di menu Data TKA.', 'info', '', 1, '2026-04-21 14:18:52'),
(20, 17, 'Nomor Surat Telah Ditentukan', 'Nomor surat untuk TKA John libau telah siap. Silakan download surat.', 'info', 'http://localhost/tka/user/detail/19', 0, '2026-04-21 17:03:10'),
(21, 8, 'Surat Keterangan TKA Siap', 'Surat keterangan untuk TKA atas nama [Nama TKA] telah selesai. Silakan download di menu Data TKA.', 'info', '', 1, '2026-04-22 12:51:06'),
(22, 8, 'Verifikasi TKA Berhasil', 'Pengajuan TKA Anda telah diverifikasi dan disetujui. Status dapat dilihat di dashboard.', 'info', '', 1, '2026-04-22 14:44:28'),
(23, 8, 'Nomor Surat Telah Ditentukan', 'Nomor surat untuk TKA oyen telah siap. Silakan download surat.', 'info', 'http://localhost/tka/user/detail/16', 1, '2026-04-22 15:46:54'),
(24, 21, 'Nomor Surat Telah Ditentukan', 'Nomor surat untuk TKA oyen oma telah siap. Silakan download surat.', 'info', 'http://localhost/tka/user/detail/21', 0, '2026-04-22 16:26:03'),
(25, 8, 'Nomor Surat Telah Ditentukan', 'Nomor surat untuk TKA mana oyen dede telah siap. Silakan download surat.', 'info', 'http://localhost/tka/user/detail/24', 1, '2026-04-22 20:35:28'),
(26, 8, 'perpanjangan', 'askjdadsbadbashd', 'info', '', 1, '2026-04-23 18:11:32'),
(27, 8, 'Pengumuman Penting', 'Ada pembaruan sistem. Mohon perhatikan informasi terbaru di website.', 'info', '', 1, '2026-04-23 18:18:38'),
(28, 29, '', 'Pengajuan TKA Anda (ID: 34) telah disetujui oleh Kepala Bidang dan diteruskan ke tahap berikutnya.', 'approval', NULL, 0, '2026-04-28 13:43:52'),
(29, 4, '', 'Pengajuan TKA baru (ID: 34) menunggu persetujuan Anda.', 'info', NULL, 0, '2026-04-28 13:43:52'),
(30, 29, '', 'Pengajuan TKA Anda (ID: 34) telah disetujui oleh Sekretaris Dinas dan diteruskan ke tahap berikutnya.', 'approval', NULL, 0, '2026-04-28 13:44:37'),
(31, 5, '', 'Pengajuan TKA baru (ID: 34) menunggu persetujuan Anda.', 'info', NULL, 0, '2026-04-28 13:44:37'),
(32, 29, '', 'Pengajuan TKA Anda (ID: 34) telah disetujui oleh Kepala Dinas dan telah selesai. Surat izin dapat diunduh.', 'approval', NULL, 0, '2026-04-28 13:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `otp_verification`
--

CREATE TABLE `otp_verification` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `type` enum('register','reset') DEFAULT 'register'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otp_verification`
--

INSERT INTO `otp_verification` (`id`, `email`, `otp_code`, `expires_at`, `created_at`, `type`) VALUES
(1, 'mongko@mongko.com', '758796', '2026-04-08 12:42:20', '2026-04-08 17:32:20', 'register'),
(2, 'admin@mail.com', '508166', '2026-04-08 12:44:54', '2026-04-08 17:34:54', 'register'),
(16, 'maca@maca.com', '918741', '2026-04-18 16:24:10', '2026-04-18 16:14:10', 'reset');

-- --------------------------------------------------------

--
-- Table structure for table `security_attempts`
--

CREATE TABLE `security_attempts` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security_attempts`
--

INSERT INTO `security_attempts` (`id`, `email`, `attempts`, `locked_until`, `updated_at`) VALUES
(3, 'henhue@mail.com', 5, '2026-04-23 10:21:04', '2026-04-23 01:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `surat_template`
--

CREATE TABLE `surat_template` (
  `id` int(1) NOT NULL DEFAULT 1,
  `header` text DEFAULT NULL,
  `footer` text DEFAULT NULL,
  `kepala_dinas` varchar(100) DEFAULT NULL,
  `nip_kepala_dinas` varchar(50) DEFAULT NULL,
  `ttd_path` varchar(255) DEFAULT NULL,
  `nomor_surat_format` varchar(100) DEFAULT '503/{id}/DISNAKER/{tahun}',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_template`
--

INSERT INTO `surat_template` (`id`, `header`, `footer`, `kepala_dinas`, `nip_kepala_dinas`, `ttd_path`, `nomor_surat_format`, `updated_at`) VALUES
(1, '<h2>PEMERINTAH KOTA BEKASI</h2><h3>DINAS TENAGA KERJA</h3><p>Jl. Jend. A. Yani No.13 Bekasi, Jawa Barat Kode Pos. 17141</p><p>Telp/Fax. (021) 8852144 Email: disnaker@kotabekasi.go.id</p><hr>', '<p>Demikian Surat ini disampaikan dan dibuat untuk dipergunakan sebagaimana mestinya.</p>', 'Dra. IKA INDAH YARTI, M.Si.', '19670114 198610 2001', 'uploads/ttd/ttd_kepala_dinas_1776853423.jpg', '503/561/DISNAKER/2026', '2026-04-22 17:23:43');

-- --------------------------------------------------------

--
-- Table structure for table `tka`
--

CREATE TABLE `tka` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_tka` varchar(150) NOT NULL,
  `status` enum('DRAFT','MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS','SELESAI','DITOLAK') DEFAULT 'DRAFT',
  `overdue_flag` tinyint(1) DEFAULT 0,
  `estimasi_selesai` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `passport_no` varchar(50) DEFAULT NULL,
  `passport_expiry` date DEFAULT NULL,
  `kitas_no` varchar(50) DEFAULT NULL,
  `stm_no` varchar(50) DEFAULT NULL,
  `rptka_no` varchar(50) DEFAULT NULL,
  `rptka_date` date DEFAULT NULL,
  `notifikasi_no` varchar(50) DEFAULT NULL,
  `notifikasi_date` date DEFAULT NULL,
  `jenis_notifikasi` enum('Baru','Perpanjangan') DEFAULT NULL,
  `masa_berlaku_notifikasi` varchar(50) DEFAULT NULL,
  `lunas_dkp` enum('Lunas','Belum Lunas') DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `negara_asal` varchar(50) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat_tinggal` text DEFAULT NULL,
  `lokasi_kerja` varchar(100) DEFAULT NULL,
  `bidang_usaha` varchar(100) DEFAULT NULL,
  `surat_dikirim` tinyint(1) DEFAULT 0,
  `nomor_surat_manual` varchar(100) DEFAULT NULL,
  `tanggal_surat_manual` date DEFAULT NULL,
  `nomor_surat_keluar` varchar(100) DEFAULT NULL,
  `nomor_surat_permohonan` varchar(100) DEFAULT NULL,
  `surat_teks_approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tka`
--

INSERT INTO `tka` (`id`, `user_id`, `nama_tka`, `status`, `overdue_flag`, `estimasi_selesai`, `created_at`, `updated_at`, `passport_no`, `passport_expiry`, `kitas_no`, `stm_no`, `rptka_no`, `rptka_date`, `notifikasi_no`, `notifikasi_date`, `jenis_notifikasi`, `masa_berlaku_notifikasi`, `lunas_dkp`, `jabatan`, `tempat_lahir`, `tanggal_lahir`, `negara_asal`, `jenis_kelamin`, `alamat_tinggal`, `lokasi_kerja`, `bidang_usaha`, `surat_dikirim`, `nomor_surat_manual`, `tanggal_surat_manual`, `nomor_surat_keluar`, `nomor_surat_permohonan`, `surat_teks_approved`) VALUES
(3, 8, 'oyen', 'DITOLAK', 0, NULL, '2026-04-07 15:21:29', '2026-04-07 15:56:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0),
(4, 8, 'oyen', 'DITOLAK', 0, NULL, '2026-04-07 15:23:36', '2026-04-07 15:56:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0),
(6, 8, 'oyen smit', 'SELESAI', 0, NULL, '2026-04-07 15:50:46', '2026-04-07 17:36:10', '123123123', '2028-06-15', '12312312', '12312312', '12312312', '2026-04-07', '12312312', '2026-04-14', NULL, NULL, NULL, 'asdasdasd', 'asdasd', '1998-06-15', 'ewfwf', 'Laki-laki', 'wefwefwe', 'wefwfwef', NULL, 0, NULL, NULL, NULL, NULL, 0),
(7, 8, 'oyen negerr', 'SELESAI', 0, NULL, '2026-04-07 18:00:56', '2026-04-07 18:16:49', '123123123', '2026-04-23', '234234234', '234234234', '234234234', '2025-12-04', '123123123', '2026-04-09', NULL, NULL, NULL, '234234234', '234234234', '2008-02-27', 'sdscsdfsdf', 'Perempuan', 'dsfsdfsdf', 'sdfsdfsdf', NULL, 0, NULL, NULL, NULL, NULL, 0),
(8, 8, 'oyen yg oyen', 'SELESAI', 0, NULL, '2026-04-08 06:25:57', '2026-04-18 16:28:57', '234234234', '2000-04-23', '12312323131', '12312312', '2123123123', '0000-00-00', '234234243', '2000-02-20', NULL, NULL, NULL, 'new oyen', 'Jakarta', '2222-02-21', 'indonesia', 'Perempuan', 'sdaasdasdasd', 'asdasdasdas', NULL, 0, NULL, NULL, NULL, NULL, 0),
(9, 8, 'oyen bala', 'DRAFT', 0, NULL, '2026-04-08 14:33:12', '2026-04-24 12:59:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0),
(11, 14, 'oyen mulolita', 'SELESAI', 0, NULL, '2026-04-09 07:19:39', '2026-04-18 16:36:56', '86533733', '2026-04-22', '123412312', '12312412', '12313123', '2026-04-04', '12312312', '2026-04-29', NULL, NULL, NULL, 'new oyen', 'Jakarta', '2026-04-16', 'indonesia', 'Laki-laki', 'dsfsdfdsf', 'rumah oma', NULL, 0, NULL, NULL, NULL, NULL, 0),
(12, 14, 'asdasdasdasd', 'DITOLAK', 0, NULL, '2026-04-09 07:47:20', '2026-04-09 07:52:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0),
(13, 8, 'oyen bajak laut', 'SELESAI', 0, NULL, '2026-04-09 10:09:41', '2026-04-09 10:11:50', '86533733', '2026-04-23', '234523523', '5433534', '34534534', '2026-04-17', '23423423', '2026-04-07', NULL, NULL, NULL, 'new oyen gen', 'Jakarta', '2026-04-15', 'indonesia', 'Laki-laki', 'vdfgdfgdfg', 'rumah oma', NULL, 0, NULL, NULL, NULL, NULL, 0),
(14, 16, 'oyen swbbd', 'SELESAI', 0, NULL, '2026-04-10 10:31:03', '2026-04-10 10:55:28', '6545676', '2026-04-22', '5644565', '5437654567', '654567654', '2026-04-21', '76567865', '2026-04-14', NULL, NULL, NULL, 'new oyen', 'Jakarta', '2026-04-21', 'indonesia', 'Laki-laki', 'hgfghjhgh', 'jhgfhghj', NULL, 0, NULL, NULL, NULL, NULL, 0),
(15, 8, 'oyen smit', 'SELESAI', 0, NULL, '2026-04-18 16:59:21', '2026-04-18 17:02:22', '124312412', '2026-04-23', '12321312', '121342314', '234341123', '2026-04-10', '212412', '2026-04-18', 'Baru', '2345234234', 'Lunas', 'manager', 'Jakarta', '2026-04-24', 'indonesia', 'Laki-laki', 'dfsgdfgdfg', 'asdjhajsdhas', 'manufaktur', 0, NULL, NULL, NULL, NULL, 0),
(16, 8, 'oyen', 'SELESAI', 0, NULL, '2026-04-18 19:09:08', '2026-04-22 15:46:54', '86533733', '2026-04-20', '5644565', '934882394', '893892348923', '2026-04-23', '12312312', '2026-04-18', 'Baru', '2345234234', 'Lunas', 'new oyen', 'Jakarta', '2026-04-24', 'indonesia', 'Laki-laki', 'afsdgsdgsg', 'dsfdsfsdfds', 'manufaktur', 0, '005/HW/RI/I/2026', '2026-04-20', '005/HX/CI/I/2029', '005/TR/LV/2026', 1),
(17, 8, 'oyen xxx', 'SELESAI', 0, NULL, '2026-04-18 19:51:51', '2026-04-21 12:08:58', '86533733', '2026-04-16', '12312323131', '5437654567', '12312312', '2026-04-15', '12312312', '2026-04-24', 'Baru', 'dfgdgfhfg', 'Lunas', 'asdasdasd', 'Jakarta', '2026-04-01', 'indonesia', 'Laki-laki', 'dghfgh', 'asdasdasd', 'manufaktur', 0, '005/HR/WI/I/2026', '2026-04-20', '005/HX/CI/I/2026', '005/TR/LV/2026', 1),
(18, 8, 'Oyem Gembrot', 'SELESAI', 0, NULL, '2026-04-21 13:00:30', '2026-04-21 13:05:49', '124891234712394', '2026-04-29', '12312312', '12424124', '1252324534', '2026-04-30', '2312312312', '2026-04-30', 'Baru', '01-02-2025 s/d 08-08-2026', 'Lunas', 'manager', 'Belanda', '2026-04-01', 'Oyenil', 'Laki-laki', 'Jl. Melati No. 10, RT 04 RW 06 Kel. Sukamaju, Kec. Cibinong Kab. Bogor, Jawa Barat 16912', 'Cikarang', 'manufaktur', 0, NULL, NULL, '015/HT/NI/I/2026', '065/RR/KI/I/2026', 1),
(19, 17, 'John libau', 'SELESAI', 0, NULL, '2026-04-21 16:18:15', '2026-04-21 17:03:10', '6545676', '2026-04-29', '12312323131', '12312312', ' B.3/54643/PK.04.00/VIII/2025', '2026-04-30', 'B.3/115909/PK.04.01/IX/2025', '2026-04-22', 'Baru', '01-02-2025 s/d 08-08-2026', 'Lunas', 'new oyen', 'Jakarta', '2026-04-30', 'indonesia', 'Laki-laki', ' Jl. HR Rasuna Said Blok X.5 Kav. 4-9, Kuningan, Jakarta Selatan, 12950.', 'rumah oma', 'Manufaktur', 0, NULL, NULL, '005/LX/CI/I/2026', '005/MR/LV/2026', 1),
(21, 21, 'oyen oma', 'SELESAI', 0, NULL, '2026-04-22 16:11:19', '2026-04-22 16:26:03', '86533733', '2026-04-16', '12312312', '934882394', ' B.3/54643/PK.04.00/VIII/2025', '2026-04-30', 'B.3/115909/PK.04.01/IX/2025', '2026-04-29', 'Perpanjangan', '01-02-2025 s/d 08-08-2026', 'Belum Lunas', 'new oyen', 'Jakarta', '2026-04-30', 'indonesia', 'Laki-laki', 'ahsdbadhasd', 'rumah oma', 'Manufaktur', 0, NULL, NULL, '005/HX/CI/I/2029', '005/TR/LV/2026', 1),
(22, 21, 'oyen nyawit', 'DITOLAK', 0, NULL, '2026-04-22 16:34:59', '2026-04-22 16:52:54', '86533733', '2026-04-30', '12312323131', '934882394', 'B.3/54643/PK.04.00/VIII/2025', '2026-04-30', ' B.3/115909/PK.04.01/IX/2025', '2026-04-30', 'Perpanjangan', '01-02-2025 s/d 08-08-2026', 'Lunas', 'new oyen', 'Jakarta', '2026-04-30', 'indonesia', 'Laki-laki', 'a,nfjafnadflafndlfjsdf', 'rumah oma', 'Manufaktur', 0, NULL, NULL, NULL, NULL, 0),
(24, 8, 'mana oyen dede', 'SELESAI', 0, NULL, '2026-04-22 19:32:32', '2026-04-22 20:35:28', '124891234712394', '2026-04-30', '12312323131', '5437654567', ' B.3/54643/PK.04.00/VIII/2025', '2026-04-30', ' B.3/115909/PK.04.01/IX/2025', '2026-04-30', 'Perpanjangan', '01-02-2025 s/d 08-08-2026', 'Belum Lunas', 'new oyen', 'Jakarta', '2026-04-30', 'Oyenil', 'Laki-laki', 'abdkaikdabsdbkasd', 'rumah oma', 'pengusaha rumah', 0, NULL, NULL, '005/HX/CI/I/2026', '005/TR/LV/2026', 1),
(25, 8, 'oyen yg oyen', 'DRAFT', 0, NULL, '2026-04-22 19:53:36', '2026-04-24 11:18:30', '86533733', '2026-04-30', '12312312', '934882394', 'B.3/54643/PK.04.00/VIII/2025', '2026-04-30', 'B.3/115909/PK.04.01/IX/2025', '2026-04-03', 'Baru', '01-02-2025 s/d 08-08-2026', 'Lunas', 'manager', 'Jakarta', '2026-04-30', 'dytch', 'Laki-laki', 'asdfafadas', 'asdassdads', 'Manufaktur ori', 0, NULL, NULL, NULL, NULL, 0),
(26, 8, 'oyen yg oyen', 'DRAFT', 0, NULL, '2026-04-22 20:52:02', '2026-04-24 12:56:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0),
(28, 8, 'oyen yg oyen', 'MENUNGGU_KABID', 0, NULL, '2026-04-22 20:58:34', '2026-04-22 21:11:03', '124891234712394', '2026-04-30', '12312323131', '934882394', 'B.3/54643/PK.04.00/VIII/2025', '2026-05-01', 'B.3/115909/PK.04.01/IX/2025', '2026-04-30', 'Baru', '01-02-2025 s/d 08-08-2026', 'Lunas', 'asdasdasd', 'Jakarta', '2026-04-30', 'indonesia', 'Perempuan', 'dasdasdasdasd', 'asdassdads', 'Manufaktur ori', 0, NULL, NULL, NULL, NULL, 0),
(29, 8, 'oyen yag oyen', 'MENUNGGU_KABID', 0, NULL, '2026-04-22 21:01:48', '2026-04-22 21:53:52', '124891234712394', '2026-04-30', '12312323131', '934882394', 'B.3/54643/PK.04.00/VIII/2025', '2026-04-30', ' B.3/115909/PK.04.01/IX/2025', '0000-00-00', 'Baru', '01-02-2025 s/d 08-08-2026', 'Lunas', 'new oyen', 'Jakarta', '2026-04-30', 'ewfwf', 'Laki-laki', 'kjdbsakdjavbhjkasd', 'rumah oma', 'pengusaha rumah', 0, NULL, NULL, NULL, NULL, 0),
(30, 8, 'oyen oma', 'DRAFT', 0, NULL, '2026-04-22 22:06:28', '2026-04-22 22:06:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0),
(32, 29, 'kim jong un', 'MENUNGGU_KABID', 0, NULL, '2026-04-23 12:27:58', '2026-04-23 12:57:57', '86533733', '2026-04-30', '12312323131', '934882394', ' B.3/54643/PK.04.00/VIII/2025', '2026-04-30', 'B.3/115909/PK.04.01/IX/2025', '2026-04-30', 'Baru', '01-02-2025 s/d 08-08-2026', 'Lunas', 'manager', 'Belanda', '2026-04-30', 'belanda', 'Laki-laki', 'kbfksfkbskdfsdf', 'Cikarang', 'Manufaktur oriiginal', 0, NULL, NULL, NULL, NULL, 0),
(33, 8, 'oyeniga', 'MENUNGGU_KABID', 0, NULL, '2026-04-28 12:59:58', '2026-04-28 13:41:59', '124891234712394', '2026-04-30', '12312323131', '934882394', ' B.3/54643/PK.04.00/VIII/2025', '2026-04-30', ' B.3/115909/PK.04.01/IX/2025', '2026-04-30', 'Perpanjangan', '01-02-2025 s/d 08-08-2026', 'Lunas', 'new oyen', 'Oma House', '2026-04-08', 'Mola', 'Laki-laki', 'Pavilion Shop no 48, Jababeka,cikarang, bekasi, Jawa Barat, 17550\r\n', 'rumah oma', 'manufaktur', 0, NULL, NULL, NULL, NULL, 0),
(34, 29, 'KOMOKIYAKAWA', 'SELESAI', 0, NULL, '2026-04-28 13:36:44', '2026-04-28 13:59:17', '89083095893', '2026-04-29', '12312323131', '934882394', ' B.3/54643/PK.04.00/VIII/2025', '2026-04-30', ' B.3/115909/PK.04.01/IX/2025', '2026-04-29', 'Baru', '01-02-2025 s/d 08-08-2026', 'Lunas', 'manager', 'Bekasi', '2026-04-14', 'Bekasi', 'Perempuan', 'Pavilion Shop no 48, Jababeka,cikarang, bekasi, Jawa Barat, 17550', 'Rumah Sendiri', 'Manufaktur ori', 0, NULL, NULL, '94/HX/CMI/I/2026', '05/TR/LV/2020', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `perusahaan` varchar(150) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `role` enum('user','admin','kasi','kabid','sekdis','kadis','operator') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `security_question` varchar(255) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `perusahaan`, `alamat`, `no_hp`, `nip`, `role`, `created_at`, `updated_at`, `is_active`, `security_question`, `security_answer`) VALUES
(1, 'Admin Utama', 'admin@tka.com', '$2y$10$7KwK2Rxa0sjBlRZkkUlSFeoq6/eF8CLzshXlqHb44XS3Obr3xVt26', 'Dinas', 'Kantor', '081234567890', NULL, 'admin', '2026-04-07 05:08:59', '2026-04-07 07:26:59', 1, NULL, NULL),
(2, 'Kepala Seksi', 'kasi@tka.com', '$2y$10$7KwK2Rxa0sjBlRZkkUlSFeoq6/eF8CLzshXlqHb44XS3Obr3xVt26', 'Dinas', 'Kantor', '081234567891', NULL, 'kasi', '2026-04-07 05:08:59', '2026-04-09 09:34:26', 1, NULL, NULL),
(3, 'kepala bidang', 'kabid@tka.com', '$2y$10$7KwK2Rxa0sjBlRZkkUlSFeoq6/eF8CLzshXlqHb44XS3Obr3xVt26', 'Dinas', 'Kantor', '081234567892', NULL, 'kabid', '2026-04-07 05:08:59', '2026-04-09 09:39:24', 1, NULL, NULL),
(4, 'Sekretaris Dinas ', 'sekdis@tka.com', '$2y$10$7KwK2Rxa0sjBlRZkkUlSFeoq6/eF8CLzshXlqHb44XS3Obr3xVt26', 'Dinas', 'Kantor', '081234567893', NULL, 'sekdis', '2026-04-07 05:08:59', '2026-04-09 09:40:40', 1, NULL, NULL),
(5, 'kepala dinas', 'kadis@tka.com', '$2y$10$7KwK2Rxa0sjBlRZkkUlSFeoq6/eF8CLzshXlqHb44XS3Obr3xVt26', 'Dinas', 'Kantor', '088888888888', '90077869809', 'kadis', '2026-04-07 05:08:59', '2026-04-10 13:19:04', 1, NULL, NULL),
(8, 'maca', 'maca@maca.com', '$2y$10$DgpUdw6pNgAxNga23vd7fO7HcJGKWc80EUmxPIFyFbwWL/ZXazM8S', 'maca', '12412414 adsdaqdas', '1231241241', NULL, 'user', '2026-04-07 06:12:51', '2026-04-08 05:20:19', 1, NULL, NULL),
(9, 'Admin Baru', 'admin2@tka.com', '$2a$12$Fy1loPmVXkTqXT2UGeZ65esA1sR/J1BUh.IVOoxwp9Zs3V/B6y3OS', 'Dinas', 'Alamat', '081234567890', NULL, 'admin', '2026-04-07 06:21:18', '2026-04-09 09:42:52', 1, NULL, NULL),
(10, 'neecow', 'coor@mail.com', '$2y$10$2MWkQpYGAIeOtsfVpLD6Y.gE8Mm1qxDFhnH4SsmVD2UDGDNFhR4rq', 'coorporet', 'asdasdasdasdasdasd', '0976876521', NULL, 'user', '2026-04-07 11:34:51', '2026-04-08 11:05:40', 1, NULL, NULL),
(11, 'dahdhjadj', 'lolo@lolo.com', '$2y$10$bYM8m7SAIbj22KAS5Y2E3eLKaqyKPyXF3xlSl/NqAl2aaaHy2U2IC', 'sdbhdsfbhsdbhf', 'jdshfkkshfkhsd', '129147038704', NULL, 'user', '2026-04-08 10:42:06', '2026-04-08 11:05:38', 1, NULL, NULL),
(12, 'jadsasdadhdsh', 'mailh@mail.com', '$2y$10$/1LyPNF5vhJY51ptsJ6znOD9FG47OvROHW4MvcIB31mQuqTptSQii', 'adjssdjsdjnds', 'bhadbhadhas', '8r8932734', NULL, 'user', '2026-04-08 10:43:00', '2026-04-08 10:43:00', 1, NULL, NULL),
(14, 'dakadhahd', 'heh@heh.com', '$2y$10$3FRqWeuMqJFzfDQpDxo9Oe4OVgu4.T918jbw6QehhNzYzPHfms.H6', 'akabfkabf', 'hsuytdf', '876545678', NULL, 'user', '2026-04-08 11:47:41', '2026-04-09 00:28:03', 1, NULL, NULL),
(15, 'nemo', 'nemo@nemo.com', '$2y$10$3BZlbC9vufj0H8ICOns8KuLiJMI/4fFYrYbceZJZ5rKSo0Pp.xhMm', 'nemoinka', 'jhijhhijygiygiyigygiyiy', '067788667', NULL, 'user', '2026-04-09 01:45:27', '2026-04-09 01:45:27', 1, NULL, NULL),
(16, 'neecow', 'budiabadi@budiabadi.com', '$2y$10$xXsJ7nHbuhxWGuxC9b3oSO9KSi2DQ77YYMQsE6osG10jqWN4hLGhK', 'Pt budi abadi', 'GGFGNBVBNMBV', '7556676556', NULL, 'user', '2026-04-10 03:28:46', '2026-04-18 06:54:28', 1, NULL, NULL),
(17, 'Helati Munawan', 'Nital@gmail.com', '$2y$10$3qzoiXhvFTNipAHvDVPIVe.S8.efK1PCeAr8Yrlu.vFLS1bZdcxdu', 'Pt Nital', 'Jl. Merpati Putih No. 17\r\nKembang Putihan, Pandak\r\nBantul, D.I. Yogyakarta 55761', '0866543342599', NULL, 'user', '2026-04-21 09:14:50', '2026-04-21 09:14:50', 1, NULL, NULL),
(18, 'ashar', 'ayam@mail.com', '$2y$10$v0oUFlmBA30T3m74VBbg4ejP5MDAgfby.hgfL5ATXyb1Pr9nZDCVm', 'PT. Ayam abadi', 'new', '2723121331213', NULL, 'user', '2026-04-22 08:06:39', '2026-04-22 08:06:39', 1, NULL, NULL),
(19, 'neecow', 'nem@nem.com', '$2y$10$Iat5J82AHrCQRHzuYl1X3uflOlAUbIumqNXlJ2SZ802O2xu.lUUeO', 'nem@nem', 'sederhana', '9876789', NULL, 'user', '2026-04-22 08:07:37', '2026-04-22 08:07:37', 1, NULL, NULL),
(20, 'heh', 'henhue@mail.com', '$2y$10$/vB/2XH7NUceAZpKRHWjsOMN/hsRYK0Ne2H1ME8gYL0gZRTYef6tq', 'dsakdskabd', 'dsjandasdknasjd', '2131802389193', NULL, 'user', '2026-04-22 08:22:28', '2026-04-22 08:22:28', 1, NULL, NULL),
(21, 'heh', 'henhue@gmail.com', '$2y$10$x6lKICBoCKbfRio7yIJ8wes6HPp52whrVUKzG6YcNjB66LNZIiA9O', 'dsakdskabd', 'dsjandasdknasjd', '2131802389193', NULL, 'user', '2026-04-22 08:39:16', '2026-04-22 09:42:41', 1, NULL, NULL),
(22, 'heh', 'henhue@henhue.com', '$2y$10$hD8oo4qfdZRNcq2CL0undehbJNerzLdRjCH5UiD35vcoD60/wzEIO', 'dsakdskabd', 'dsjandasdknasjd', '2131802389193', NULL, 'user', '2026-04-22 08:41:24', '2026-04-22 08:41:24', 1, NULL, NULL),
(24, 'nemo', 'KoMper@gmail.com', '$2y$10$r3RicCHrZHbrLmWyyHFNwOWwKJvp.aqZ71KLJc84Yg2P3OR0yZuXO', 'KoMper', 'dsjandasdknasjd', '2131802389193', NULL, 'user', '2026-04-22 23:31:02', '2026-04-22 23:31:02', 1, NULL, NULL),
(25, 'monika', 'mongka@gmail.com', '$2y$10$w1QbHAkfUlUWuYBd5DqV1OzNa5JDokRcr8MTNv6J4Rna/40soLdWK', 'Mongka liuer', 'dsjandasdknasjd', '8773489234898', NULL, 'user', '2026-04-22 23:49:49', '2026-04-22 23:49:49', 1, 'Siapa nama ibu kandung Anda?', 'oyen'),
(26, 'monkela', 'monkela@mail.com', '$2y$10$YIFGpSDmh36467AfmhsgJeE77g4RzC2dStfHwy6ZmjfagEzYvtDDa', 'dsakdskabd', 'dsjandasdknasjd', '2131802389193', NULL, 'user', '2026-04-23 00:10:46', '2026-04-23 00:10:46', 1, 'Siapa nama ibu kandung Anda?', 'oyen'),
(27, 'oyen', 'oyen@oyen.com', '$2y$10$BSPnaHCSasYH6ZX93IcOFuTA7wSb82wfz.6eSeCznpIHCXtLoOGdG', 'oyen abadi sukses', 'asdajdsadsbuiasdiiuasd', '89038289234', NULL, 'user', '2026-04-23 00:31:36', '2026-04-23 00:34:03', 1, 'Siapa nama hewan peliharaan pertama Anda?', 'oyen'),
(28, 'heh', 'henhuelll@mail.com', '$2y$10$uKUSY/aHj/Uvp5gOFubSFOw86s02smJNTOxic9F7DsPzyGs3qodSy', 'dsakdskabd', 'dsjandasdknasjd', '2131802389193', NULL, 'user', '2026-04-23 05:01:43', '2026-04-23 05:01:43', 1, 'Apa makanan favorit Anda?', 'ayam'),
(29, 'moli', 'ikanabadi@ikanabadi.com', '$2y$10$.qtfT.A5ucVkI77Xkz5Ife7FZs1DyMRhyAjYX4iS2q4/nTGxBLpdq', 'PT. nemo ikan abadi', 'jdnjsfnisniisf', '867857754', NULL, 'user', '2026-04-23 05:26:31', '2026-04-23 05:26:31', 1, 'Siapa nama hewan peliharaan pertama Anda?', 'oyen'),
(32, 'admin operator', 'admin@operator.com', '$2y$10$Cyd.YTYhdy7Z4Ky0TOyZ3uFFuWvJKyAdgSorelMxJ2t.KsZ6QCmTm', '-', '-', '083123131231', '987675789', 'operator', '2026-04-23 10:09:39', '2026-04-23 10:49:01', 1, NULL, NULL),
(33, 'admin', 'kasi1@tka.com', '$2y$10$dUOgBmlFYChllD4rlmYb5uUsCyEnKROdof9yCJra/18zG2RPB58Wa', '-', '-', '45845745', '8857575', 'admin', '2026-04-23 10:17:48', '2026-04-23 10:21:34', 1, NULL, NULL),
(34, 'monkela', 'henhuex@mail.com', '$2y$10$ZM5uEVC1.si6TNXuwREnXuCtTmHN3eav/LKIE9Y2mhPNlPWbbMb0u', 'dsakdskabd', 'dsjandasdknasjd', '2131802389193', NULL, 'user', '2026-04-24 03:13:23', '2026-04-24 09:16:46', 1, 'Siapa nama hewan peliharaan pertama Anda?', 'oyen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `approval_log`
--
ALTER TABLE `approval_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tka_id` (`tka_id`);

--
-- Indexes for table `approval_sla`
--
ALTER TABLE `approval_sla`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `level` (`level`);

--
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tka_id` (`tka_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_to` (`from_user_id`,`to_user_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `escalation_log`
--
ALTER TABLE `escalation_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tka_id` (`tka_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `security_attempts`
--
ALTER TABLE `security_attempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `surat_template`
--
ALTER TABLE `surat_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tka`
--
ALTER TABLE `tka`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `approval_log`
--
ALTER TABLE `approval_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `approval_sla`
--
ALTER TABLE `approval_sla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `berkas`
--
ALTER TABLE `berkas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `escalation_log`
--
ALTER TABLE `escalation_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `security_attempts`
--
ALTER TABLE `security_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tka`
--
ALTER TABLE `tka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approval_log`
--
ALTER TABLE `approval_log`
  ADD CONSTRAINT `approval_log_ibfk_1` FOREIGN KEY (`tka_id`) REFERENCES `tka` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `berkas`
--
ALTER TABLE `berkas`
  ADD CONSTRAINT `berkas_ibfk_1` FOREIGN KEY (`tka_id`) REFERENCES `tka` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tka`
--
ALTER TABLE `tka`
  ADD CONSTRAINT `tka_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
