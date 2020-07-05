-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jul 2020 pada 16.40
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventori_isma`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `tbl_barang_id` int(10) NOT NULL,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(10) NOT NULL,
  `value` varchar(6) NOT NULL,
  `name` varchar(60) NOT NULL,
  `jenis_id` int(10) NOT NULL,
  `kategori_id` int(10) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `qtyentered` decimal(10,0) NOT NULL,
  `qtyavailable` decimal(10,0) NOT NULL DEFAULT 0,
  `unitprice` int(11) NOT NULL,
  `budget` bigint(20) NOT NULL,
  `budgetAnggaranAvailable` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`tbl_barang_id`, `isactive`, `created`, `createdby`, `updated`, `updatedby`, `value`, `name`, `jenis_id`, `kategori_id`, `keterangan`, `qtyentered`, `qtyavailable`, `unitprice`, `budget`, `budgetAnggaranAvailable`) VALUES
(1, 'Y', '2020-07-05 13:27:47', 1, '2020-07-05 13:30:34', 1, 'PS0001', 'KOMPUTER', 1, 1, 'New', '10', '9', 3000000, 30000000, 0),
(3, 'Y', '2020-07-05 14:11:53', 1, '2020-07-05 14:24:42', 1, 'PS0002', 'SPPD', 2, 3, 'oke', '0', '0', 0, 60000000, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`tbl_barang_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `tbl_barang_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
