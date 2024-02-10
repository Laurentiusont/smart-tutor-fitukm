-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Sep 2023 pada 09.16
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assets`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_aset`
--

CREATE TABLE `data_aset` (
  `kode_aset` int(11) NOT NULL,
  `nama_aset` varchar(45) DEFAULT NULL,
  `tanggal_pembelian` date DEFAULT NULL,
  `biaya_pembelian` int(11) DEFAULT NULL,
  `jumlah_aset` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `nilai_residu` int(11) DEFAULT NULL,
  `masa_manfaat` int(11) DEFAULT NULL,
  `depresiasi` int(11) DEFAULT NULL,
  `kategori_id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `data_aset`
--

INSERT INTO `data_aset` (`kode_aset`, `nama_aset`, `tanggal_pembelian`, `biaya_pembelian`, `jumlah_aset`, `total`, `nilai_residu`, `masa_manfaat`, `depresiasi`, `kategori_id_kategori`) VALUES
(1, 'Komputer', '2021-02-20', 20000000, 5, 100000000, 5000000, 4, 3750000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_karyawan`
--

CREATE TABLE `data_karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama_karyawan` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `jabatan` varchar(45) DEFAULT NULL,
  `divisi` varchar(45) DEFAULT NULL,
  `alamat` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `data_karyawan`
--

INSERT INTO `data_karyawan` (`id_karyawan`, `nama_karyawan`, `jenis_kelamin`, `email`, `telepon`, `jabatan`, `divisi`, `alamat`) VALUES
(1, 'Yehezkiel David Setiawan', 'Laki-laki', '2172003@maranatha.ac.id', '089507647137', 'Frontend Developer', 'IT', 'Cimahi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventory`
--

CREATE TABLE `inventory` (
  `data_karyawan_id_karyawan` int(11) NOT NULL,
  `data_aset_kode_aset` int(11) NOT NULL,
  `data_aset_kategori_id_kategori` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `ruangan` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `inventory`
--

INSERT INTO `inventory` (`data_karyawan_id_karyawan`, `data_aset_kode_aset`, `data_aset_kategori_id_kategori`, `status`, `ruangan`) VALUES
(1, 1, 1, 'aktif', 'lantai 1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Aset Perangkat Keras'),
(2, 'Aset Perangkat Lunak'),
(3, 'Aset Kantor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_buku`
--

CREATE TABLE `nilai_buku` (
  `id_nilai_buku` int(11) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `nilai_buku_tahun4` int(11) DEFAULT NULL,
  `nilai_buku_tahun3` int(11) DEFAULT NULL,
  `nilai_buku_tahun1` int(11) DEFAULT NULL,
  `nilai_buku_tahun2` int(11) DEFAULT NULL,
  `data_aset_kode_aset` int(11) NOT NULL,
  `data_aset_kategori_id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `nilai_buku`
--

INSERT INTO `nilai_buku` (`id_nilai_buku`, `tahun`, `nilai_buku_tahun4`, `nilai_buku_tahun3`, `nilai_buku_tahun1`, `nilai_buku_tahun2`, `data_aset_kode_aset`, `data_aset_kategori_id_kategori`) VALUES
(1, 2021, 8750000, 12500000, 16250000, 20000000, 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `status`, `name`, `updated_at`, `created_at`) VALUES
(1, 'admin@gmail.com', 'bfd59291e825b5f2bbf1eb76569f8fe7', 'aktif', NULL, NULL, NULL),
(2, 'arthur@gmail.com', '$2y$10$T8taA3IuF2qpW/.CAj56uOwlgSFLdG66x.OCOerV01hESfu6/YqIi', NULL, 'arthurito', '2023-09-13 07:04:58', '2023-09-13 07:04:58');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_aset`
--
ALTER TABLE `data_aset`
  ADD PRIMARY KEY (`kode_aset`,`kategori_id_kategori`),
  ADD KEY `fk_data_aset_kategori_idx` (`kategori_id_kategori`);

--
-- Indeks untuk tabel `data_karyawan`
--
ALTER TABLE `data_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`data_karyawan_id_karyawan`,`data_aset_kode_aset`,`data_aset_kategori_id_kategori`),
  ADD KEY `fk_data_karyawan_has_data_aset_data_aset1_idx` (`data_aset_kode_aset`,`data_aset_kategori_id_kategori`),
  ADD KEY `fk_data_karyawan_has_data_aset_data_karyawan1_idx` (`data_karyawan_id_karyawan`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_buku`
--
ALTER TABLE `nilai_buku`
  ADD PRIMARY KEY (`id_nilai_buku`,`data_aset_kode_aset`,`data_aset_kategori_id_kategori`),
  ADD KEY `fk_nilai_buku_data_aset1_idx` (`data_aset_kode_aset`,`data_aset_kategori_id_kategori`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_aset`
--
ALTER TABLE `data_aset`
  MODIFY `kode_aset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_karyawan`
--
ALTER TABLE `data_karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `nilai_buku`
--
ALTER TABLE `nilai_buku`
  MODIFY `id_nilai_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_aset`
--
ALTER TABLE `data_aset`
  ADD CONSTRAINT `fk_data_aset_kategori` FOREIGN KEY (`kategori_id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_data_karyawan_has_data_aset_data_aset1` FOREIGN KEY (`data_aset_kode_aset`,`data_aset_kategori_id_kategori`) REFERENCES `data_aset` (`kode_aset`, `kategori_id_kategori`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_data_karyawan_has_data_aset_data_karyawan1` FOREIGN KEY (`data_karyawan_id_karyawan`) REFERENCES `data_karyawan` (`id_karyawan`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `nilai_buku`
--
ALTER TABLE `nilai_buku`
  ADD CONSTRAINT `fk_nilai_buku_data_aset1` FOREIGN KEY (`data_aset_kode_aset`,`data_aset_kategori_id_kategori`) REFERENCES `data_aset` (`kode_aset`, `kategori_id_kategori`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
