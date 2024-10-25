-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 24, 2024 at 07:42 PM
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
-- Database: `web_konser`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(55) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_user`, `nama`, `email`, `phone`, `password`, `role`) VALUES
(1, '123', '123@gmail.com', '123', '$2y$10$mi4ryx9u4IX2yyVXtLV.fuNbAD.92jkq4eReLrmLnqjBwbHQFLrji', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `event_konser`
--

CREATE TABLE `event_konser` (
  `id_event` int(11) NOT NULL,
  `nama_event` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `banner_event` varchar(255) NOT NULL,
  `status_event` enum('open','closed','canceled') DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `list_partisipan_event`
--

CREATE TABLE `list_partisipan_event` (
  `id_partisipan` int(20) NOT NULL,
  `id_user` int(20) NOT NULL,
  `id_event` int(20) NOT NULL,
  `tanggal_register` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipe_tiket` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `status` enum('approved','pending','rejected','canceled','event canceled') DEFAULT 'pending',
  `no_tiket` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `tipe_tiket` varchar(55) NOT NULL,
  `jumlah_sold` int(11) DEFAULT NULL,
  `kuota` int(11) NOT NULL,
  `harga` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `event_konser`
--
ALTER TABLE `event_konser`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `list_partisipan_event`
--
ALTER TABLE `list_partisipan_event`
  ADD PRIMARY KEY (`id_partisipan`),
  ADD KEY `fk_event_id` (`id_event`),
  ADD KEY `fk_id_user` (`id_user`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id_tiket`),
  ADD KEY `fk_tiket` (`id_event`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_konser`
--
ALTER TABLE `event_konser`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `list_partisipan_event`
--
ALTER TABLE `list_partisipan_event`
  MODIFY `id_partisipan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `list_partisipan_event`
--
ALTER TABLE `list_partisipan_event`
  ADD CONSTRAINT `fk_event_id` FOREIGN KEY (`id_event`) REFERENCES `event_konser` (`id_event`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `fk_tiket` FOREIGN KEY (`id_event`) REFERENCES `event_konser` (`id_event`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
