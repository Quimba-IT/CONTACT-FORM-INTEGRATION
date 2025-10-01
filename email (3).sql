-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 01:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `messages` text NOT NULL,
  `sent_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `name`, `subject`, `recipient_email`, `messages`, `sent_at`, `created_at`) VALUES
(1, 'Noel ivan Quimba', 'program', 'Quimba123@gmail.com', 'try kong mag work ba siya', '0000-00-00 00:00:00', '2025-09-29 06:19:05'),
(2, 'Noel ivan Quimba', 'program', 'Quimba123@gmail.com', 'TRY', '2025-09-29 14:23:36', '2025-09-29 06:23:36'),
(3, 'Quimba', 'program', 'gwapo@gmail.com', 'wqwqwqwqwq', '2025-09-29 19:52:44', '2025-09-29 11:52:44'),
(15, 'Quimba', 'program', 'gwapo@gmail.com', '1234567', '2025-09-29 21:01:52', '2025-09-29 13:01:52'),
(16, 'Quimba', 'program', 'gwapo@gmail.com', 'wqwqwqwqwq', '2025-09-29 21:02:18', '2025-09-29 13:02:18'),
(18, 'ronaldo', 'sports', 'ronaldo@gmail.com', 'best sports', '2025-10-01 18:07:20', '2025-10-01 10:07:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
