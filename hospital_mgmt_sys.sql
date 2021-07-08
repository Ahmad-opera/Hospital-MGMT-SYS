-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2021 at 04:58 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_mgmt_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `patient_id` int(255) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `drugs_prescription` text NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `pharmacy_close` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `date`, `patient_id`, `doctor_name`, `note`, `drugs_prescription`, `closed`, `pharmacy_close`) VALUES
(1, '2021-07-05 00:29:04', 46, 'Doc Tor', 'something here', 'Panadol Extra 2-2-2 3days\nFlagyl 2-2-2 4days', 1, 0),

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE `drugs` (
  `id` int(11) NOT NULL,
  `drug_name` varchar(255) NOT NULL,
  `drug_manufacturer` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `qty_type` varchar(16) NOT NULL,
  `in_stock` tinyint(1) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drugs`
--

INSERT INTO `drugs` (`id`, `drug_name`, `drug_manufacturer`, `price`, `qty_type`, `in_stock`, `stock`) VALUES
(1, 'Panadol', 'Emzor', 60, 'tablet', 1, 0),
(2, 'Flagyl', 'Flagyl', 70, 'tablet', 1, 0),
(3, 'Amoxicilin', 'Emzor', 300, 'card', 1, 0),
(4, 'Paracetamol', 'Pharmaceuticals', 50, 'syrup', 1, 300),
(5, 'Septol', 'Septol', 400, 'pack', 1, 30),
(6, 'Strepsils', 'Strepsils', 430, 'card', 1, 100),
(7, 'Amoxil', 'Pharmaceuticals', 200, 'card', 1, 20),
(8, 'Talazon', 'Emzor', 30, 'card', 1, 50),
(9, 'Amoxil', 'Pharmaceuticals', 500, 'capsules', 1, 0),
(10, 'Arthemeter', 'Emzor', 400, 'tablet', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `genotype` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `full_name`, `gender`, `dob`, `address`, `phone_number`, `blood_group`, `genotype`, `created_on`) VALUES
(46, 'Jane Doe Doe', 'female', '2002-07-06', 'somewhere', '348723487', 'B', 'AS', '2021-07-05 00:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` int(11) NOT NULL,
  `items` text NOT NULL,
  `total` int(10) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sold_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `items`, `total`, `paid`, `date`, `sold_by`) VALUES
(37, '[{\"id\":\"1\",\"drug_name\":\"Panadol\",\"qty\":\"6\",\"qty_type\":\"tablet\",\"price\":60},{\"id\":\"2\",\"drug_name\":\"Flagyl\",\"qty\":\"4\",\"qty_type\":\"tablet\",\"price\":70}]', 640, 0, '2021-07-05 00:30:59', 'pharmacist'),
(38, '[{\"id\":\"1\",\"drug_name\":\"Panadol\",\"qty\":1,\"qty_type\":\"tablet\",\"price\":60},{\"id\":\"4\",\"drug_name\":\"Paracetamol\",\"qty\":1,\"qty_type\":\"syrup\",\"price\":50}]', 110, 0, '2021-07-05 01:54:15', 'pharmacist');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `role`, `password`, `email`, `status`) VALUES
(1, 'admin', 'User Name', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'test@gmail.com', 1),
(2, 'doctor', 'Doc Tor', 'doctor', 'f9f16d97c90d8c6f2cab37bb6d1f1992', 'doc@gmail.com', 1),
(8, 'receptionist', '', 'receptionist', '0a9b3767c8b9b69cea129110e8daeda2', 'receptionist@gg.cc', 1),
(9, 'pharmacist', '', 'pharmacist', 'fd3051577824ada21b3df777812c66fa', 'test@test.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drugs`
--
ALTER TABLE `drugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `drugs`
--
ALTER TABLE `drugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
