-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2025 at 12:04 PM
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
  `id` int(11) NOT NULL COMMENT 'AUTO_INCREMENT',
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
(1, 'noel ivan quimba', 'math', 'noelivanquimba17@gmail.com', 'asas', '0000-00-00 00:00:00', '2025-09-28 06:17:42'),
(3, 'hanna', 'math', 'hannaguintolon@gmail.com', 'asasas', '0000-00-00 00:00:00', '2025-09-28 06:22:47'),
(4, 'hanna', 'math', 'hannaguintolon@gmail.com', 'asasas', '0000-00-00 00:00:00', '2025-09-28 06:23:35'),
(5, 'noel', 'math', 'asasas@gmail.com', 'asas', '0000-00-00 00:00:00', '2025-09-28 06:28:54'),
(6, 'noel', 'math', 'asasas@gmail.com', 'asasas', '0000-00-00 00:00:00', '2025-09-28 06:29:34'),
(7, 'noel', 'noel', 'noelivanquimba17@gmail.com', 'asas', '0000-00-00 00:00:00', '2025-09-28 06:31:05'),
(8, 'noel', 'noel', 'noelivanquimba17@gmail.com', 'helooooo', '0000-00-00 00:00:00', '2025-09-28 06:33:30'),
(9, 'noel', 'noel', 'noelivanquimba17@gmail.com', 'try lang', '0000-00-00 00:00:00', '2025-09-28 06:36:50'),
(10, 'noelivanquimba', 'program', 'noelivanquimba17@gmail.com', 'trying', '0000-00-00 00:00:00', '2025-09-28 09:37:58');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'AUTO_INCREMENT', AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
