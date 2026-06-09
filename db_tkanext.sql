-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2026 at 11:47 AM
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
-- Database: `db_tkanext`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL COMMENT 'Kode aksi: APPROVE, DELETE_TKA, dll',
  `target_type` varchar(50) DEFAULT NULL COMMENT 'Objek yang dikenai: tka, user, dll',
  `target_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approval_log`
--

CREATE TABLE `approval_log` (
  `id` int(11) NOT NULL,
  `tka_id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL COMMENT 'kasi / kabid / sekdis / kadis',
  `level` tinyint(4) DEFAULT NULL COMMENT '1=Kasi, 2=Kabid, 3=Sekdis, 4=Kadis',
  `user_id` int(11) DEFAULT NULL,
  `status` enum('approve','reject') NOT NULL,
  `catatan` text DEFAULT NULL,
  `sla_deadline` datetime DEFAULT NULL,
  `warned_at` datetime DEFAULT NULL,
  `is_overdue` tinyint(1) DEFAULT 0,
  `escalated_at` datetime DEFAULT NULL,
  `delegated_to` int(11) DEFAULT NULL,
  `delegated_by` int(11) DEFAULT NULL,
  `delegated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approval_sla`
--

CREATE TABLE `approval_sla` (
  `id` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL COMMENT '1=Kasi, 2=Kabid, 3=Sekdis, 4=Kadis',
  `nama_level` varchar(50) NOT NULL,
  `sla_jam` int(11) NOT NULL COMMENT 'Batas waktu dalam jam',
  `reminder_jam` int(11) DEFAULT NULL COMMENT 'Kirim reminder di jam ke berapa',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approval_sla`
--

INSERT INTO `approval_sla` (`id`, `level`, `nama_level`, `sla_jam`, `reminder_jam`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kepala Seksi', 48, 24, '2026-05-06 12:06:17', '2026-05-06 12:06:17'),
(2, 2, 'Kepala Bidang', 48, 24, '2026-05-06 12:06:17', '2026-05-06 12:06:17'),
(3, 3, 'Sekretaris Dinas', 72, 48, '2026-05-06 12:06:17', '2026-05-06 12:06:17'),
(4, 4, 'Kepala Dinas', 72, 48, '2026-05-06 12:06:17', '2026-05-06 12:06:17');

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
('dv8jdrtk7g718vu2kjhvbe7d64dpef6q', '::1', 1778069897, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737383036393830373b6c6f676765645f696e7c623a313b757365725f69647c733a313a2231223b6e616d617c733a31313a2241646d696e205574616d61223b726f6c657c733a353a2261646d696e223b7065727573616861616e7c733a353a2244696e6173223b);

-- --------------------------------------------------------

--
-- Table structure for table `escalation_log`
--

CREATE TABLE `escalation_log` (
  `id` int(11) NOT NULL,
  `tka_id` int(11) NOT NULL,
  `dari_user_id` int(11) DEFAULT NULL COMMENT 'NULL jika dikirim otomatis sistem',
  `ke_user_id` int(11) NOT NULL,
  `level_asal` tinyint(4) NOT NULL COMMENT 'Level yang melewati SLA',
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

-- --------------------------------------------------------

--
-- Table structure for table `otp_verification`
--

CREATE TABLE `otp_verification` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL,
  `type` enum('register','reset') DEFAULT 'register',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `surat_template`
--

CREATE TABLE `surat_template` (
  `id` int(1) NOT NULL DEFAULT 1,
  `kepala_dinas` varchar(100) DEFAULT NULL,
  `nip_kepala_dinas` varchar(50) DEFAULT NULL,
  `ttd_path` varchar(255) DEFAULT NULL COMMENT 'Path file gambar tanda tangan',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_template`
--

INSERT INTO `surat_template` (`id`, `kepala_dinas`, `nip_kepala_dinas`, `ttd_path`, `updated_at`) VALUES
(1, NULL, NULL, NULL, '2026-05-06 12:06:17');

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
  `nomor_surat_manual` varchar(100) DEFAULT NULL,
  `tanggal_surat_manual` date DEFAULT NULL,
  `nomor_surat_keluar` varchar(100) DEFAULT NULL,
  `nomor_surat_permohonan` varchar(100) DEFAULT NULL,
  `surat_dikirim` tinyint(1) DEFAULT 0,
  `surat_teks_approved` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `security_question` varchar(255) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `perusahaan`, `alamat`, `no_hp`, `nip`, `role`, `is_active`, `security_question`, `security_answer`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin@tka.com', '$2y$10$7KwK2Rxa0sjBlRZkkUlSFeoq6/eF8CLzshXlqHb44XS3Obr3xVt26', 'Dinas', 'Kantor', '081234567890', NULL, 'admin', 1, NULL, NULL, '2026-05-06 12:06:16', '2026-05-06 12:06:16');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_log`
--
ALTER TABLE `approval_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_sla`
--
ALTER TABLE `approval_sla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `berkas`
--
ALTER TABLE `berkas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `escalation_log`
--
ALTER TABLE `escalation_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_attempts`
--
ALTER TABLE `security_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tka`
--
ALTER TABLE `tka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Constraints for table `escalation_log`
--
ALTER TABLE `escalation_log`
  ADD CONSTRAINT `escalation_log_ibfk_1` FOREIGN KEY (`tka_id`) REFERENCES `tka` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tka`
--
ALTER TABLE `tka`
  ADD CONSTRAINT `tka_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
