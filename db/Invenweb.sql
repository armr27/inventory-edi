-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2023 at 10:05 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invenweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(60) DEFAULT NULL,
  `stok` varchar(4) DEFAULT NULL,
  `id_satuan` int(20) DEFAULT NULL,
  `id_jenis` int(20) DEFAULT NULL,
  `foto` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `id_satuan`, `id_jenis`, `foto`) VALUES
('BRG-0001', 'Teh Pucuk Harum', '0', 2, 1, 'd4f130cc51185c56c9effcfa0b4a30a0.jpg'),
('BRG-0002', 'Aqua', '0', 1, 1, 'aqua.jpg'),
('BRG-0003', 'ari', '20', 4, 1, 'foto_3x4-min.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_barang_keluar` varchar(30) NOT NULL,
  `id_user` varchar(30) DEFAULT NULL,
  `tgl_keluar` varchar(20) DEFAULT NULL,
  `progress` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `id_user`, `tgl_keluar`, `progress`) VALUES
('BRG-K-0001', 'USR-0-4', '2023-03-22', 'Selesai'),
('BRG-K-0002', 'USR-002', '2023-03-22', 'Proses');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` varchar(40) NOT NULL,
  `file` varchar(255) NOT NULL,
  `tgl_masuk` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `file`, `tgl_masuk`) VALUES
('IMP-M-0001', '9df9bedc-9b06-4883-a436-bec11a0dc461.xlsx', '2023-03-22'),
('IMP-M-0002', 'MB52_10_Maret_2023_XLS38.xlsx', '2023-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `detail_barang_keluar`
--

CREATE TABLE `detail_barang_keluar` (
  `id_detail` int(11) NOT NULL,
  `id_barang_keluar` varchar(30) NOT NULL,
  `mat_code` int(11) NOT NULL,
  `jumlah_keluar` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_barang_keluar`
--

INSERT INTO `detail_barang_keluar` (`id_detail`, `id_barang_keluar`, `mat_code`, `jumlah_keluar`) VALUES
(1, 'BRG-K-0001', 80000002, 1),
(2, 'BRG-K-0001', 80000003, 1),
(3, 'BRG-K-0002', 80000004, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(20) NOT NULL,
  `nama_jenis` varchar(20) DEFAULT NULL,
  `ket` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `nama_jenis`, `ket`) VALUES
(1, 'Minuman', ''),
(3, 'Kemasan', '');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(20) NOT NULL,
  `nama_satuan` varchar(60) DEFAULT NULL,
  `ket` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`, `ket`) VALUES
(1, 'Box', ''),
(2, 'Unit', ''),
(4, 'Pack', '');

-- --------------------------------------------------------

--
-- Table structure for table `sparepart`
--

CREATE TABLE `sparepart` (
  `Mat_Code` int(11) DEFAULT NULL,
  `Material_Description` varchar(255) DEFAULT NULL,
  `UOM` varchar(10) DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Stock` varchar(5) DEFAULT NULL,
  `Sloc` int(8) NOT NULL,
  `Batch` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sparepart`
--

INSERT INTO `sparepart` (`Mat_Code`, `Material_Description`, `UOM`, `Location`, `Stock`, `Sloc`, `Batch`) VALUES
(80000002, 'MECH SEAL 102AGT06', 'EA', 'R07.B3.03', '1', 1701, 'NEW'),
(80000003, 'MECH SEAL 102AGT07', 'EA', 'R07.B3.03', '1', 1701, 'NEW');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` varchar(10) NOT NULL,
  `nama_supplier` varchar(60) DEFAULT NULL,
  `notelp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `notelp`, `alamat`) VALUES
('SPLY-0001', 'Radhian Sobarna', '087817379229', 'Sumedang'),
('SPLY-0002', 'Heri Perdiansyah', '089829128118', 'Sumedang'),
('SPLY-0003', 'Widi Priansyah', '089876261556', 'Sumedang'),
('SPLY-0004', NULL, NULL, NULL),
('SPLY-0005', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `level` enum('member','admin','kepala gudang') NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `nip`, `level`, `password`, `foto`, `status`) VALUES
('USR-0-4', 'Kevin GGS', 'kevin', 'kevindarkbatman@gmail.com', '123231', 'member', 'cc03e747a6afbbcbf8be7668acfebee5', 'user.png', 'Aktif'),
('USR-002', 'Aldo', 'aldo', 'Aldogantengsmriwing@gmail.com', '123456789', 'member', 'cc03e747a6afbbcbf8be7668acfebee5', '9200fa2ecff5393eb65f01cd3c686689.jpg', 'Aktif'),
('USR-004', 'capybara', 'capybara', 'test@gmail.com', '1232123', 'kepala gudang', 'cc03e747a6afbbcbf8be7668acfebee5', 'capybara1.jpg', 'Aktif'),
('USR-05', 'Edi', 'edi', 'edigaul@gmail.com', '123321', 'admin', 'cc03e747a6afbbcbf8be7668acfebee5', 'user.png', 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`);

--
-- Indexes for table `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
