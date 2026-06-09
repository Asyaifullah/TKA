-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2026 at 11:07 AM
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
-- Database: `sitlakeb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `admin_name` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `target_type` varchar(50) DEFAULT NULL,
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
  `surat_wajib_lapor` varchar(255) DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `escalation_log`
--

CREATE TABLE `escalation_log` (
  `id` int(11) NOT NULL,
  `tka_id` int(11) NOT NULL,
  `dari_user_id` int(11) DEFAULT NULL COMMENT 'user yang mengirim eskalasi (bisa NULL jika sistem)',
  `ke_user_id` int(11) DEFAULT NULL,
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
  `ttd_path` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `jenis_notifikasi` enum('Baru','Perpanjangan','Jangka Pendek') DEFAULT NULL,
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
(1, 'Admin Utama', 'admin@tka.com', '$2y$10$7KwK2Rxa0sjBlRZkkUlSFeoq6/eF8CLzshXlqHb44XS3Obr3xVt26', 'Dinas', 'Kantor', '081234567890', NULL, 'admin', '2026-04-07 05:08:59', '2026-04-07 07:26:59', 1, NULL, NULL);

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
  ADD KEY `tka_id` (`tka_id`),
  ADD KEY `fk_al_user` (`user_id`);

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
  ADD KEY `from_to` (`from_user_id`,`to_user_id`),
  ADD KEY `fk_chatmsg_to` (`to_user_id`);

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
  ADD KEY `tka_id` (`tka_id`),
  ADD KEY `idx_esc_tka` (`tka_id`),
  ADD KEY `idx_esc_dari` (`dari_user_id`),
  ADD KEY `idx_esc_ke` (`ke_user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `security_attempts`
--
ALTER TABLE `security_attempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `security_attempts`
--
ALTER TABLE `security_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tka`
--
ALTER TABLE `tka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD CONSTRAINT `fk_adminlog_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `approval_log`
--
ALTER TABLE `approval_log`
  ADD CONSTRAINT `approval_log_ibfk_1` FOREIGN KEY (`tka_id`) REFERENCES `tka` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_al_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `berkas`
--
ALTER TABLE `berkas`
  ADD CONSTRAINT `berkas_ibfk_1` FOREIGN KEY (`tka_id`) REFERENCES `tka` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `fk_chat_from` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_chat_to` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `escalation_log`
--
ALTER TABLE `escalation_log`
  ADD CONSTRAINT `fk_esc_dari` FOREIGN KEY (`dari_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_esc_ke` FOREIGN KEY (`ke_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_esc_tka` FOREIGN KEY (`tka_id`) REFERENCES `tka` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tka`
--
ALTER TABLE `tka`
  ADD CONSTRAINT `tka_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
