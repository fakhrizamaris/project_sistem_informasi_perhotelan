-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 28, 2025 at 04:43 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id_kamar` int NOT NULL,
  `tipe_kamar` enum('standar','deluxe','suite') DEFAULT NULL,
  `no_kamar` int DEFAULT NULL,
  `harga` varchar(50) DEFAULT NULL,
  `status` enum('kosong','terisi','dibooking','maintenance') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id_kamar`, `tipe_kamar`, `no_kamar`, `harga`, `status`, `created_at`, `updated_at`) VALUES
(2, 'standar', 2, '1000000', 'kosong', '2025-08-28 01:18:38', '2025-08-28 01:18:38'),
(3, 'deluxe', 3, '2000000', 'dibooking', '2025-08-28 01:18:52', '2025-08-28 01:18:52'),
(5, 'suite', 10, '3000000', 'kosong', '2025-08-28 15:25:06', '2025-08-28 15:25:06');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `status` enum('aktif','non_aktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_reservasi` int NOT NULL,
  `metode` enum('cash','transfer','kartu_kredit','e_wallet') NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `status` enum('pending','berhasil','gagal') DEFAULT 'pending',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` int NOT NULL,
  `id_tamu` int NOT NULL,
  `id_kamar` int NOT NULL,
  `tgl_checkin` date NOT NULL,
  `tgl_checkout` date NOT NULL,
  `total_biaya` decimal(12,2) NOT NULL,
  `status` enum('pending','confirmed','checkin','checkout','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id_reservasi`, `id_tamu`, `id_kamar`, `tgl_checkin`, `tgl_checkout`, `total_biaya`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 2, '2025-08-28', '2025-08-29', 1000000.00, 'checkout', '2025-08-28 01:43:36', '2025-08-28 02:07:08'),
(4, 1, 3, '2025-08-28', '2025-08-30', 4000000.00, 'checkout', '2025-08-28 01:47:07', '2025-08-28 02:06:16'),
(6, 3, 2, '2025-08-28', '2025-08-29', 1000000.00, 'cancelled', '2025-08-28 08:14:49', '2025-08-28 15:03:34'),
(8, 3, 3, '2025-08-28', '2025-08-30', 4000000.00, 'confirmed', '2025-08-28 15:09:59', '2025-08-28 15:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `tamu`
--

CREATE TABLE `tamu` (
  `id_tamu` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `no_identitas` varchar(20) NOT NULL,
  `alamat` text,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tamu`
--

INSERT INTO `tamu` (`id_tamu`, `id_user`, `nama`, `no_identitas`, `alamat`, `no_hp`, `email`, `created_at`) VALUES
(1, NULL, 'asdasd', '123123123123', 'asdasd1312', '14123123123', 'djamaris@gmail.com', '2025-08-27 15:09:24'),
(3, 8, 'FAKHRI DJAMARIS', '1203891238912829312', NULL, '081959243545', 'fajarahmadkurniadi@gmail.com', '2025-08-28 03:52:50'),
(4, 10, 'FAKHRI DJAMARIS', '12312312312314', '', '081959243545', 'mahasiswa1@mahasiswa.com', '2025-08-28 16:00:21'),
(5, 11, 'FAKHRI DJAMARIS', '13123123123123123', '', '081959243545', 'perusahaan1@perusahaan.com', '2025-08-28 16:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('admin','resepsionis','manajer','tamu') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin123', 'admin1', 'admin', '2025-08-27 01:49:57', '2025-08-27 01:49:57'),
(3, 'admin2', '$2y$10$YVNfUSNKLhm0RDMBAFntHuLH6se3bWskL.GmvQ4ZqGN2fMArA/q2O', 'admin2', 'admin', '2025-08-27 01:54:43', '2025-08-27 01:54:43'),
(4, 'manajer', '$2y$10$83W2aYma5hLXW5RnVhv5m.9dbBPrXyVxcEdSd4W1Qfv18YVUjIJIS', 'Manajer', 'manajer', '2025-08-27 01:56:59', '2025-08-27 01:56:59'),
(8, 'fajar', '$2y$10$xn17/JIhpAjSqJUYXgMIL.FnzFqA5M7cJD.g9N.Fqcpqvo.JTJP0S', 'FAKHRI DJAMARIS', 'tamu', '2025-08-28 03:52:50', '2025-08-28 03:52:50'),
(10, 'fakhri', '$2y$10$v4jYWN7sHujX/I0EQuM.qObQszLVYXaCsCt4Bp8h5TWcGrRs5KOc.', 'FAKHRI DJAMARIS', 'tamu', '2025-08-28 16:00:21', '2025-08-28 16:00:21'),
(11, 'user1', '$2y$10$EjAJUa7TuK1siz82I2Fu4OR5tcEiaNjmml1hcFMU31IRuO2z7q0zS', 'FAKHRI DJAMARIS', 'tamu', '2025-08-28 16:00:56', '2025-08-28 16:00:56'),
(12, 'resepsionis', '$2y$10$eAj8VJBUeOsMrO2zfbtWcOgBUxiw1tKhjVWs5EPsE81R7PyyZ8U4q', 'tes', 'resepsionis', '2025-08-28 16:20:19', '2025-08-28 16:20:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id_kamar`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_reservasi` (`id_reservasi`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `id_tamu` (`id_tamu`),
  ADD KEY `id_kamar` (`id_kamar`);

--
-- Indexes for table `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id_tamu`),
  ADD UNIQUE KEY `no_identitas` (`no_identitas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id_kamar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id_tamu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`);

--
-- Constraints for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD CONSTRAINT `reservasi_ibfk_1` FOREIGN KEY (`id_tamu`) REFERENCES `tamu` (`id_tamu`),
  ADD CONSTRAINT `reservasi_ibfk_2` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id_kamar`);

--
-- Constraints for table `tamu`
--
ALTER TABLE `tamu`
  ADD CONSTRAINT `tamu_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
