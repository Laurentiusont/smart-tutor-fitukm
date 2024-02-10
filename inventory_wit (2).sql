-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2023 at 12:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_wit`
--

-- --------------------------------------------------------

--
-- Table structure for table `history_pemakaian`
--

CREATE TABLE `history_pemakaian` (
  `id` int(11) NOT NULL,
  `nomor_induk_old` varchar(20) DEFAULT NULL,
  `nomor_induk_new` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `ruangan_old` varchar(20) DEFAULT NULL,
  `ruangan_new` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kode_aset` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `history_pemakaian`
--

INSERT INTO `history_pemakaian` (`id`, `nomor_induk_old`, `nomor_induk_new`, `tanggal`, `ruangan_old`, `ruangan_new`, `created_at`, `updated_at`, `kode_aset`) VALUES
(16, NULL, '3667256256257', '2023-11-06', NULL, 'AB', NULL, NULL, 'LP-01'),
(17, '3667256256257', '3667256256256', '2023-11-06', 'AB', 'AB', NULL, NULL, 'LP-01'),
(18, NULL, '54321', '2023-11-10', NULL, 'R2', NULL, NULL, 'MOU-20231010125050');

-- --------------------------------------------------------

--
-- Table structure for table `history_perbaikan`
--

CREATE TABLE `history_perbaikan` (
  `id` int(11) NOT NULL,
  `tanggal_perbaikan` date DEFAULT NULL,
  `biaya` int(11) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `tanggal_kerusakan` date NOT NULL,
  `tanggal_selesai_perbaikan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kode_aset` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `history_perbaikan`
--

INSERT INTO `history_perbaikan` (`id`, `tanggal_perbaikan`, `biaya`, `deskripsi`, `tanggal_kerusakan`, `tanggal_selesai_perbaikan`, `created_at`, `updated_at`, `kode_aset`) VALUES
(3, '2023-11-06', 1000000, 'LCD rusak', '2023-11-03', '2023-11-10', '2023-11-05 23:22:48', '2023-11-05 23:23:36', 'LP-01'),
(5, '2023-11-07', NULL, 'Tidak berfungsi', '2023-11-06', NULL, '2023-11-09 22:52:43', '2023-11-13 00:52:54', 'MOU-20231010125050'),
(6, NULL, NULL, 'LCD rusak', '2023-11-06', NULL, '2023-11-10 00:40:18', '2023-11-10 00:40:18', 'LP-01');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `kode_aset` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `merk` varchar(45) NOT NULL,
  `tanggal` date NOT NULL,
  `harga` int(11) NOT NULL,
  `nilai_residu` int(11) DEFAULT NULL,
  `masa_manfaat` int(11) DEFAULT NULL,
  `depresiasi` int(11) DEFAULT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `id_kategori` varchar(3) DEFAULT NULL,
  `tahun_1` int(11) DEFAULT NULL,
  `tahun_2` int(11) DEFAULT NULL,
  `tahun_3` int(11) DEFAULT NULL,
  `tahun_4` int(11) DEFAULT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `vendor` varchar(100) DEFAULT NULL,
  `nomor_induk` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`kode_aset`, `nama`, `merk`, `tanggal`, `harga`, `nilai_residu`, `masa_manfaat`, `depresiasi`, `deskripsi`, `status`, `id_kategori`, `tahun_1`, `tahun_2`, `tahun_3`, `tahun_4`, `img_url`, `vendor`, `nomor_induk`, `created_at`, `updated_at`) VALUES
('KOM-20231013112210', 'Komputer', 'Acer', '2023-11-06', 5000000, NULL, NULL, NULL, 'hghese', 'normal', 'APL', NULL, NULL, NULL, NULL, NULL, 'PT.', '3667256256257', '2023-11-12 21:22:53', '2023-11-13 00:40:09'),
('LP-01', 'Laptop', 'Asus', '2023-10-30', 6000000, 1500000, 4, 1125000, 'RAM 8', 'rusak', 'APK', 4875000, 3750000, 2625000, 1500000, 'post-images/pZSSqSGFag7PrtgXulaQRtKftZTBm949v5SbT98Z.png', 'PT.', '3667256256257', '2023-11-05 23:17:25', '2023-11-10 00:40:17'),
('MOU-20231010125050', 'Mouse', 'X', '2023-11-01', 1000000, 250000, 4, 187500, 'hsdhgd', 'perbaikan', 'AK', 812500, 625000, 437500, 250000, 'post-images/Zmbk0kvbhSTlFDUFprNIZdTT5qAeV04i5odC5W3Q.png', 'PT.', '54321', '2023-11-09 22:51:36', '2023-11-13 00:54:19');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `nomor_induk` varchar(20) NOT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `divisi` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`nomor_induk`, `img_url`, `nama`, `gender`, `email`, `telepon`, `jabatan`, `divisi`, `alamat`, `created_at`, `updated_at`) VALUES
('3667256256256', NULL, 'Yehezkiel', 0, '2172005@maranatha.ac.id', '087555', 'direktur', 'IT', 'Cimahi', '2023-10-24 06:43:32', '2023-10-24 06:43:32'),
('3667256256257', 'post-images/ZuIpi3TBYSwWN9iUlDPIjWYR3BTqxIimkrv0Wkix.png', 'Hengki', 0, 'hengki@gmail.com', '0976555', 'Staff Biasa', 'Hacking', 'Jl. Kircon', '2023-10-25 21:21:05', '2023-10-31 20:27:58'),
('54321', 'post-images/xAsDsW8PnIqvtMK5L6hLEElE4L48vHxIl8kAy4H0.png', 'Salma', 1, 'salma@gmail.com', '+6289123456780', 'Staff', 'IT', 'Bandung', '2023-11-05 23:21:34', '2023-11-12 21:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` varchar(3) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama`, `created_at`, `updated_at`) VALUES
('AK', 'Aset Kantor', '2023-11-09 22:53:56', '2023-11-09 22:53:56'),
('APK', 'Aset Perangkat Keras', '2023-10-25 08:14:38', '2023-10-25 08:14:38'),
('APL', 'Aset Perangkat Lunak', '2023-11-05 23:14:23', '2023-11-05 23:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `pemakaian`
--

CREATE TABLE `pemakaian` (
  `id` int(11) NOT NULL,
  `kode_aset` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_ruangan` varchar(5) DEFAULT NULL,
  `nomor_induk` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pemakaian`
--

INSERT INTO `pemakaian` (`id`, `kode_aset`, `created_at`, `updated_at`, `id_ruangan`, `nomor_induk`) VALUES
(5, 'LP-01', '2023-11-05 23:17:25', '2023-11-05 23:21:53', 'R1', '3667256256256'),
(7, 'MOU-20231010125050', '2023-11-09 22:51:36', '2023-11-09 23:51:09', 'R2', '54321'),
(10, 'KOM-20231013112210', '2023-11-12 21:22:53', '2023-11-12 21:22:53', NULL, NULL);

--
-- Triggers `pemakaian`
--
DELIMITER $$
CREATE TRIGGER `update_pemakaian` AFTER UPDATE ON `pemakaian` FOR EACH ROW BEGIN

IF(NEW.nomor_induk OR NEW.id_ruangan) THEN

INSERT INTO history_pemakaian (nomor_induk_old, nomor_induk_new, tanggal, ruangan_old, ruangan_new, kode_aset) VALUES (OLD.nomor_induk, NEW.nomor_induk, CURDATE(),OLD.id_ruangan, NEW.id_ruangan, NEW.kode_aset );

END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` varchar(5) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama`, `created_at`, `updated_at`) VALUES
('R1', 'Ruangan 1', '2023-11-05 23:13:50', '2023-11-08 23:49:58'),
('R2', 'Ruangan 2', '2023-11-05 23:14:05', '2023-11-08 23:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(3, 'admin', 'admin@gmail.com', '$2y$10$T8taA3IuF2qpW/.CAj56uOwlgSFLdG66x.OCOerV01hESfu6/YqIi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history_pemakaian`
--
ALTER TABLE `history_pemakaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_history_pemakaian_inventory1_idx` (`kode_aset`);

--
-- Indexes for table `history_perbaikan`
--
ALTER TABLE `history_perbaikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_history_perbaikan_inventory1_idx` (`kode_aset`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`kode_aset`),
  ADD KEY `fk_inventory_kategori1_idx` (`id_kategori`),
  ADD KEY `fk_inventory_karyawan1_idx` (`nomor_induk`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`nomor_induk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pemakaian`
--
ALTER TABLE `pemakaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pemakaian_inventory1_idx` (`kode_aset`),
  ADD KEY `fk_pemakaian_ruangan1_idx` (`id_ruangan`),
  ADD KEY `fk_pemakaian_karyawan1_idx` (`nomor_induk`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history_pemakaian`
--
ALTER TABLE `history_pemakaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `history_perbaikan`
--
ALTER TABLE `history_perbaikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pemakaian`
--
ALTER TABLE `pemakaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_pemakaian`
--
ALTER TABLE `history_pemakaian`
  ADD CONSTRAINT `fk_history_pemakaian_inventory1` FOREIGN KEY (`kode_aset`) REFERENCES `inventory` (`kode_aset`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `history_perbaikan`
--
ALTER TABLE `history_perbaikan`
  ADD CONSTRAINT `fk_history_perbaikan_inventory1` FOREIGN KEY (`kode_aset`) REFERENCES `inventory` (`kode_aset`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_inventory_karyawan1` FOREIGN KEY (`nomor_induk`) REFERENCES `karyawan` (`nomor_induk`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inventory_kategori1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pemakaian`
--
ALTER TABLE `pemakaian`
  ADD CONSTRAINT `fk_pemakaian_inventory1` FOREIGN KEY (`kode_aset`) REFERENCES `inventory` (`kode_aset`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pemakaian_karyawan1` FOREIGN KEY (`nomor_induk`) REFERENCES `karyawan` (`nomor_induk`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pemakaian_ruangan1` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
