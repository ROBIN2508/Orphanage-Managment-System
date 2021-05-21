-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2021 at 11:46 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orphanage_managment`
--

-- --------------------------------------------------------

--
-- Table structure for table `orp_admin`
--

CREATE TABLE `orp_admin` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `father_name` varchar(30) NOT NULL,
  `address` varchar(40) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `acc_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orp_admin`
--

INSERT INTO `orp_admin` (`id`, `admin_id`, `name`, `father_name`, `address`, `mobile_no`, `email`, `password`, `acc_type`) VALUES
(1, 'admin', 'admin', 'admin', 'localhost', '8080', 'admin@admin.com', 'admin123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orp_details`
--

CREATE TABLE `orp_details` (
  `id` int(11) NOT NULL,
  `orp_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orp_donation`
--

CREATE TABLE `orp_donation` (
  `id` int(11) NOT NULL,
  `donation_id` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `method_of_pay` varchar(50) NOT NULL,
  `total_amount` varchar(30) NOT NULL,
  `tnx_id` varchar(30) NOT NULL,
  `donate_by` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orp_widrow`
--

CREATE TABLE `orp_widrow` (
  `id` int(11) NOT NULL,
  `widrow_req_id` varchar(30) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `user_id` varchar(30) NOT NULL,
  `orp_gender` varchar(10) NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT '0',
  `orp_id` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orp_admin`
--
ALTER TABLE `orp_admin`
  ADD PRIMARY KEY (`admin_id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `orp_details`
--
ALTER TABLE `orp_details`
  ADD PRIMARY KEY (`orp_id`) USING BTREE,
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `orp_donation`
--
ALTER TABLE `orp_donation`
  ADD UNIQUE KEY `tnx_id` (`tnx_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `orp_widrow`
--
ALTER TABLE `orp_widrow`
  ADD PRIMARY KEY (`widrow_req_id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orp_admin`
--
ALTER TABLE `orp_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orp_details`
--
ALTER TABLE `orp_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orp_donation`
--
ALTER TABLE `orp_donation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orp_widrow`
--
ALTER TABLE `orp_widrow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
