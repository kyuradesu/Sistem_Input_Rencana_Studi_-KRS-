-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2025 at 11:59 PM
-- Server version: 8.0.30
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bengkel_coding`
--

-- --------------------------------------------------------

--
-- Table structure for table `inputmhs`
--

CREATE TABLE `inputmhs` (
  `id` int NOT NULL,
  `namaMhs` varchar(255) NOT NULL,
  `nim` varchar(15) NOT NULL UNIQUE,
  `ipk` float NOT NULL,
  `sks` int NOT NULL,
  `matakuliah` text NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `jwl_matakuliah`
--

CREATE TABLE `jwl_matakuliah` (
  `id` int NOT NULL,
  `matakuliah` varchar(250) NOT NULL,
  `sks` int NOT NULL,
  `kelp` varchar(10) NOT NULL,
  `ruangan` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jwl_mhs`
--

CREATE TABLE `jwl_mhs` (
  `id` int NOT NULL,
  `mhs_id` int NOT NULL,
  `matakuliah` varchar(255) NOT NULL,
  `sks` int NOT NULL,
  `kelp` varchar(50) NOT NULL,
  `ruangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inputmhs`
--
ALTER TABLE `inputmhs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jwl_matakuliah`
--
ALTER TABLE `jwl_matakuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jwl_mhs`
--
ALTER TABLE `jwl_mhs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mhs_id` (`mhs_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inputmhs`
--
ALTER TABLE `inputmhs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
    
--
-- AUTO_INCREMENT for table `jwl_matakuliah`
--
ALTER TABLE `jwl_matakuliah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jwl_mhs`
--
ALTER TABLE `jwl_mhs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jwl_mhs`
--
ALTER TABLE `jwl_mhs`
  ADD CONSTRAINT `jwl_mhs_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `inputmhs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
