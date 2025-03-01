-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2025 at 08:23 AM
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
-- Database: `enomyfinances`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_register`
--

CREATE TABLE `admin_register` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_register`
--

INSERT INTO `admin_register` (`id`, `fullname`, `email`, `password`, `created_at`) VALUES
(1, 'Tharini Rehansa Rajapaksha', 'RakithaKesaridu@gmail.com', '$2y$10$RCIDd31zjjE8NNtDbBslAODZCpUgC.VsBixllBx27UcWR3PylUczy', '2025-01-04 11:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `advisors`
--

CREATE TABLE `advisors` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advisors`
--

INSERT INTO `advisors` (`id`, `fullname`, `email`) VALUES
(1, 'John Doe', 'john.doe@example.com'),
(2, 'Jane Smith', 'jane.smith@example.com'),
(3, 'Alice Johnson', 'alice.johnson@example.com'),
(4, 'Jonny Do Little', 'jonny.do@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `advisor_bookings`
--

CREATE TABLE `advisor_bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `advisor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_informed` varchar(3) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advisor_bookings`
--

INSERT INTO `advisor_bookings` (`id`, `user_id`, `fullname`, `email`, `advisor_id`, `appointment_date`, `appointment_time`, `message`, `created_at`, `is_informed`) VALUES
(3, 1, 'Tharini Rehansa Rajapaksha', '123.rehansa@gmail.com', 2, '2025-01-15', '10:00:00', 'Need advise about Investment ', '2025-01-10 08:25:47', 'Yes'),
(4, 2, 'Anna Watson', 'Anna@gmail.com', 3, '2025-01-23', '15:00:00', 'Would like to have advice about Student loan', '2025-01-10 08:41:41', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `client_profiles`
--

CREATE TABLE `client_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `dependents` int(11) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `account_status` enum('Active','Deactivated','Suspended') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_profiles`
--

INSERT INTO `client_profiles` (`id`, `user_id`, `title`, `first_name`, `last_name`, `dob`, `marital_status`, `dependents`, `nationality`, `email`, `phone`, `address`, `city`, `zip`, `account_status`) VALUES
(2, 1, 'Mrs', 'Tharini', 'Rajapaksha', '2000-10-27', 'Married', 2, 'Sri Lankan', '123.rehansa@gmail.com', '+94771740070', '8 canal economic center road', 'Dambulla', '21100', 'Active'),
(3, 2, 'Ms', 'Anna', 'Watson', '1999-06-15', 'Single', 0, 'Sri Lankan', 'Anna@gmail.com', '0112837433', '7 hills salmal road colombo 4', 'Colombo', '20000', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `client_register`
--

CREATE TABLE `client_register` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `account_status` enum('Active','Deactivated','Suspended') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_register`
--

INSERT INTO `client_register` (`id`, `fullname`, `email`, `password`, `created_at`, `account_status`) VALUES
(1, 'Tharini Rehansa Rajapaksha', '123.rehansa@gmail.com', '$2y$10$WarW4yTaHsylTxQQRNpgy..06XPmpsJnQYCZk.14ExzoI59zhxfzy', '2025-01-04 09:32:46', 'Active'),
(2, 'Anna Emily Watson', 'Anna@gmail.com', '$2y$10$lTP6iHewPcr/Sutxz3Irt.O1aJME8yB7zif85r2EVPfYij3bvCH8C', '2025-01-10 08:30:33', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('read','unread') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`id`, `name`, `email`, `message`, `created_at`, `status`) VALUES
(1, 'Anna Watson', 'Anna@gmail.com', 'May I know how to contact the branch Manager please', '2025-01-10 08:33:37', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `currency_exchange_rates`
--

CREATE TABLE `currency_exchange_rates` (
  `id` int(11) NOT NULL,
  `from_currency` varchar(3) NOT NULL,
  `to_currency` varchar(3) NOT NULL,
  `exchange_rate` decimal(10,6) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency_exchange_rates`
--

INSERT INTO `currency_exchange_rates` (`id`, `from_currency`, `to_currency`, `exchange_rate`, `last_updated`) VALUES
(1, 'GBP', 'USD', 1.301400, '2025-01-14 14:59:43'),
(2, 'GBP', 'EUR', 1.170000, '2025-01-14 14:59:43'),
(3, 'GBP', 'BRL', 5.250000, '2025-01-14 14:59:43'),
(4, 'GBP', 'JPY', 150.000000, '2025-01-14 14:59:43'),
(5, 'GBP', 'TRY', 27.450000, '2025-01-14 14:59:43'),
(6, 'USD', 'EUR', 0.820000, '2025-01-14 14:59:43'),
(7, 'USD', 'BRL', 4.030000, '2025-01-14 14:59:43'),
(8, 'USD', 'JPY', 115.000000, '2025-01-14 14:59:43'),
(9, 'USD', 'TRY', 21.100000, '2025-01-14 14:59:43'),
(10, 'EUR', 'BRL', 4.920000, '2025-01-14 14:59:43'),
(11, 'EUR', 'JPY', 140.000000, '2025-01-14 14:59:43'),
(12, 'EUR', 'TRY', 25.800000, '2025-01-14 14:59:43'),
(13, 'BRL', 'JPY', 23.000000, '2025-01-14 14:59:43'),
(14, 'BRL', 'TRY', 5.200000, '2025-01-14 14:59:43'),
(15, 'JPY', 'TRY', 0.230000, '2025-01-14 14:59:43');

-- --------------------------------------------------------

--
-- Table structure for table `error_logs`
--

CREATE TABLE `error_logs` (
  `id` int(11) NOT NULL,
  `error_message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `error_logs`
--

INSERT INTO `error_logs` (`id`, `error_message`, `created_at`) VALUES
(1, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(2, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(3, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(4, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(5, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(6, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(7, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(8, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(9, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(10, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(11, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(12, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(13, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(14, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(15, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(16, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(17, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(18, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(19, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(20, 'Invalid investment type selected.', '2025-01-06 10:19:34'),
(21, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(22, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(23, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(24, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(25, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(26, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(27, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(28, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(29, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(30, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(31, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(32, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(33, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(34, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(35, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(36, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(37, 'Invalid investment type selected.', '2025-01-06 10:19:35'),
(38, 'Invalid investment type selected.', '2025-01-06 10:19:36'),
(39, 'Invalid investment type selected.', '2025-01-06 10:19:36'),
(40, 'Invalid investment type selected.', '2025-01-06 10:19:36'),
(41, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(42, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(43, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(44, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(45, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(46, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(47, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(48, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(49, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(50, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(51, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(52, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(53, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(54, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(55, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(56, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(57, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(58, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(59, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(60, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(61, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(62, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(63, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(64, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(65, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(66, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(67, 'Invalid investment type selected.', '2025-01-06 10:19:39'),
(68, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(69, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(70, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(71, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(72, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(73, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(74, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(75, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(76, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(77, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(78, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(79, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(80, 'Invalid investment type selected.', '2025-01-06 10:19:40'),
(81, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(82, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(83, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(84, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(85, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(86, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(87, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(88, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(89, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(90, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(91, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(92, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(93, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(94, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(95, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(96, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(97, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(98, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(99, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(100, 'Invalid investment type selected.', '2025-01-06 10:20:14'),
(101, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(102, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(103, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(104, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(105, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(106, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(107, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(108, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(109, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(110, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(111, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(112, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(113, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(114, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(115, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(116, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(117, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(118, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(119, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(120, 'Invalid investment type selected.', '2025-01-06 10:20:15'),
(121, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(122, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(123, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(124, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(125, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(126, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(127, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(128, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(129, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(130, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(131, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(132, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(133, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(134, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(135, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(136, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(137, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(138, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(139, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(140, 'Invalid investment type selected.', '2025-01-06 10:20:21'),
(141, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(142, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(143, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(144, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(145, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(146, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(147, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(148, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(149, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(150, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(151, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(152, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(153, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(154, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(155, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(156, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(157, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(158, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(159, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(160, 'Invalid investment type selected.', '2025-01-06 10:20:56'),
(161, 'Invalid investment type selected.', '2025-01-06 10:26:21'),
(162, 'Invalid investment type selected.', '2025-01-06 10:26:21'),
(163, 'Invalid investment type selected.', '2025-01-06 10:26:21'),
(164, 'Invalid investment type selected.', '2025-01-06 10:26:21'),
(165, 'Invalid investment type selected.', '2025-01-06 10:26:21'),
(166, 'Invalid investment type selected.', '2025-01-06 10:26:21'),
(167, 'Invalid investment type selected.', '2025-01-06 10:26:21'),
(168, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(169, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(170, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(171, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(172, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(173, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(174, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(175, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(176, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(177, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(178, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(179, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(180, 'Invalid investment type selected.', '2025-01-06 10:26:22'),
(181, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(182, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(183, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(184, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(185, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(186, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(187, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(188, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(189, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(190, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(191, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(192, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(193, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(194, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(195, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(196, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(197, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(198, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(199, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(200, 'Invalid investment type selected.', '2025-01-06 10:26:23'),
(201, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(202, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(203, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(204, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(205, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(206, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(207, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(208, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(209, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(210, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(211, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(212, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(213, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(214, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(215, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(216, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(217, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(218, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(219, 'Invalid investment type selected.', '2025-01-06 10:26:28'),
(220, 'Invalid investment type selected.', '2025-01-06 10:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `finance_staff`
--

CREATE TABLE `finance_staff` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `hire_date` date NOT NULL,
  `address` text DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','On Leave') DEFAULT 'Active',
  `profile_picture` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_staff`
--

INSERT INTO `finance_staff` (`id`, `full_name`, `email`, `position`, `salary`, `phone`, `hire_date`, `address`, `department`, `status`, `profile_picture`, `dob`, `gender`) VALUES
(1, 'John Doe', 'johndoe@example.com', 'Finance Manager', 75000.00, '+1234567890', '2019-10-01', '123 Main Street, Cityville, Countryland', 'Accounting', 'Active', 'https://example.com/profile/johndoe.jpg', '1998-06-17', 'Male'),
(2, 'Jane Smith', 'janesmith@example.com', 'Accountant', 60000.00, '+1987654321', '2020-11-01', '456 Oak Avenue, Townsville, Countryland', 'Accounting', 'Active', 'https://example.com/profile/janesmith.jpg', '1992-06-17', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `investment_data`
--

CREATE TABLE `investment_data` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `monthly_income` decimal(10,2) NOT NULL,
  `guarantor_name` varchar(255) DEFAULT NULL,
  `guarantor_contact` varchar(15) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `lump_sum` decimal(10,2) DEFAULT NULL,
  `monthly_investment` decimal(10,2) DEFAULT NULL,
  `investment_type` varchar(255) DEFAULT NULL,
  `one_year_min` decimal(10,2) DEFAULT NULL,
  `one_year_max` decimal(10,2) DEFAULT NULL,
  `five_year_min` decimal(10,2) DEFAULT NULL,
  `five_year_max` decimal(10,2) DEFAULT NULL,
  `ten_year_min` decimal(10,2) DEFAULT NULL,
  `ten_year_max` decimal(10,2) DEFAULT NULL,
  `profit` decimal(10,2) DEFAULT NULL,
  `fees` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `investment_data`
--

INSERT INTO `investment_data` (`id`, `fullname`, `email`, `contact_number`, `address`, `monthly_income`, `guarantor_name`, `guarantor_contact`, `client_id`, `lump_sum`, `monthly_investment`, `investment_type`, `one_year_min`, `one_year_max`, `five_year_min`, `five_year_max`, `ten_year_min`, `ten_year_max`, `profit`, `fees`, `tax`, `created_at`, `status`) VALUES
(13, 'Tharini Rajapaksha', '123.rehansa@gmail.com', '0771740070', '8 canal economic center road dambulla', 4500.00, 'Emily Cruse', '25648953214', 1, 8000.00, 500.00, 'basicSavings', 8400.00, 8600.00, 40210.25, 41485.03, 73031.16, 76488.25, 8488.25, 680.00, 848.83, '2025-01-09 09:11:41', 'Pending'),
(16, 'Anna Watson', 'Anna@gmail.com', '0771740070', '7 hills salmal road colombo 4', 8500.00, 'Emily Cruse', '25648953214', NULL, 5500.00, 850.00, 'savingsPlus', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-13 08:12:01', 'Pending'),
(17, 'Anna Watson', 'Anna@gmail.com', '0771740070', '7 hills salmal road colombo 4', 8500.00, 'Emily Cruse', '25648953214', NULL, 5500.00, 850.00, 'savingsPlus', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-13 08:13:17', 'Pending'),
(19, 'Anna Watson', 'Anna@gmail.com', '0771740070', '7 hills salmal road colombo 4', 8500.00, 'Emily Cruse', '25648953214', NULL, 55000.00, 850.00, 'savingsPlus', 8400.00, 8600.00, 40210.25, 41485.03, 73031.16, 76488.25, 8488.25, 680.00, 848.83, '2025-01-13 08:20:30', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `loan_applications`
--

CREATE TABLE `loan_applications` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `nic_passport` varchar(50) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `loan_type` varchar(50) NOT NULL,
  `loan_amount` decimal(10,2) NOT NULL,
  `repayment_period` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `id_proof` varchar(255) NOT NULL,
  `address_proof` varchar(255) NOT NULL,
  `income_proof` varchar(255) NOT NULL,
  `monthly_income` decimal(15,2) DEFAULT NULL,
  `guarantor_name` varchar(255) DEFAULT NULL,
  `guarantor_contact` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_applications`
--

INSERT INTO `loan_applications` (`id`, `fullname`, `gender`, `dob`, `nationality`, `nic_passport`, `marital_status`, `address`, `postal_code`, `contact_number`, `occupation`, `email`, `loan_type`, `loan_amount`, `repayment_period`, `purpose`, `id_proof`, `address_proof`, `income_proof`, `monthly_income`, `guarantor_name`, `guarantor_contact`, `status`) VALUES
(1, 'Tharini Rehansa Rajapaksha', 'Female', '2000-10-27', 'Sri Lankan', '200080104340', 'Single', '8 canal economic center road dambulla', '21100', '0771740070', 'IT Assistant', '123.rehansa@gmail.com', 'Personal', 450000.00, 24, 'I am willing to continue my higher studies ', '', '', '', NULL, NULL, NULL, 'Approved'),
(2, 'Tharini Rehansa Rajapaksha', 'Female', '1997-10-21', 'Sri Lankan', '200080104340', 'Married', '8 canal economic center road Dambulla', '21100', '0771740070', 'IT Assistant', '123.rehansa@gmail.com', 'Personal', 100000.00, 12, '0', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 65000.00, 'Jane Doe', '07752645222', 'Approved'),
(3, 'Anna Watson', 'Female', '1999-07-14', 'Sri Lankan', '456215878951', 'Married', '7 hills salmal road colombo 4', '25000', '0112837433', 'IT Assistant', 'Anna@gmail.com', 'Personal', 500000.00, 12, '0', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/download.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 100000.00, 'Jane Doe', '07752645222', 'Pending'),
(4, 'Tharini Rehansa Rajapaksha', 'Female', '1993-10-20', 'Sri Lankan', '456215878951', 'Married', '7 hills rose stresst colombo', '25000', '0112837433', 'IT Assistant', '123.rehansa@gmail.com', 'Business', 850000.00, 18, '0', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', 250000.00, 'Jane Doe', '07752645222', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `mortgage_applications`
--

CREATE TABLE `mortgage_applications` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `loan_amount` decimal(15,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `loan_duration` int(11) NOT NULL,
  `property_address` varchar(255) NOT NULL,
  `property_value` decimal(15,2) NOT NULL,
  `down_payment` decimal(15,2) NOT NULL,
  `employment_status` varchar(50) NOT NULL,
  `employer_name` varchar(255) DEFAULT NULL,
  `annual_income` decimal(15,2) NOT NULL,
  `additional_income` varchar(255) DEFAULT NULL,
  `loan_purpose` varchar(50) NOT NULL,
  `id_proof` varchar(255) NOT NULL,
  `address_proof` varchar(255) NOT NULL,
  `income_proof` varchar(255) NOT NULL,
  `property_documents` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mortgage_applications`
--

INSERT INTO `mortgage_applications` (`id`, `fullname`, `address`, `gender`, `dob`, `email`, `contact`, `loan_amount`, `interest_rate`, `loan_duration`, `property_address`, `property_value`, `down_payment`, `employment_status`, `employer_name`, `annual_income`, `additional_income`, `loan_purpose`, `id_proof`, `address_proof`, `income_proof`, `property_documents`, `submitted_at`, `status`) VALUES
(2, 'Tharini Rehansa Rajapaksha', '8 canal economic center road dambulla', 'Female', '2000-10-27', '123.rehansa@gmail.com', '0771740070', 150000.00, 5.00, 12, '123', 2500000.00, 25000.00, '0', 'ABC Corporation', 800000.00, 'Freelancing', 'Purchase', 'uploads/1635039844549.jpeg', 'uploads/List of Tables.txt', 'uploads/Guidelines.pdf', 'uploads/Guidelines.pdf', '2025-01-09 06:08:00', 'Approved'),
(3, 'Tharini Rehansa Rajapaksha', '8 canal economic center road dambulla', 'Female', '2000-10-27', '123.rehansa@gmail.com', '0771740070', 150000.00, 5.00, 12, '123', 2500000.00, 25000.00, '0', 'ABC Corporation', 800000.00, 'Freelancing', 'Purchase', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/List of Tables.txt', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', '2025-01-09 06:12:27', 'Pending'),
(4, 'Tharini Rehansa Rajapaksha', '8 canal economic center road dambulla', 'Female', '1996-07-17', 'Anna@gmail.com', '0771740070', 550000.00, 12.00, 18, '123 Lakeview Lane, Colombo 7', 2500000.00, 25000.00, 'Employed', 'ABC Corporation', 800000.00, 'Freelancing', 'Purchase', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/List of Tables.txt', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/List of Tables.txt', '2025-01-09 06:17:36', 'Pending'),
(5, 'Tharini Rehansa Rajapaksha', '8 canal economic center road dambulla', 'Female', '1996-07-17', 'Anna@gmail.com', '0771740070', 550000.00, 12.00, 18, '123 Lakeview Lane, Colombo 7', 2500000.00, 25000.00, 'Employed', 'ABC Corporation', 800000.00, 'Freelancing', 'Purchase', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/List of Tables.txt', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/List of Tables.txt', '2025-01-09 06:21:21', 'Pending'),
(6, 'Anna Watson', '7 hills salmal road colombo 4', 'Female', '1991-02-05', 'Anna@gmail.com', '0771740070', 450000.00, 8.00, 18, '123 Lakeview Lane, Colombo 7', 1200000.00, 45000.00, 'Employed', 'ABC Corporation', 700000.00, '', 'Renovation', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', '2025-01-14 07:49:10', 'Pending'),
(7, 'Anna Watson', '7 hills salmal road colombo 4', 'Male', '1994-02-16', 'Anna@gmail.com', '0771740070', 9000000.00, 14.00, 24, '123 Lakeview Lane, Colombo 7', 7500000.00, 45000.00, 'Employed', 'ABC Corporation', 800000.00, 'Freelancing', 'Purchase', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/download.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/download.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/download.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/download.jpeg', '2025-01-14 07:51:03', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `savings_applications`
--

CREATE TABLE `savings_applications` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `marital_status` enum('Single','Married','Divorced') DEFAULT NULL,
  `nic_passport` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_document` varchar(255) DEFAULT NULL,
  `address_proof` varchar(255) DEFAULT NULL,
  `tax_information` varchar(255) DEFAULT NULL,
  `account_type` varchar(50) NOT NULL,
  `joint_fullname` varchar(255) DEFAULT NULL,
  `joint_contact_number` varchar(15) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savings_applications`
--

INSERT INTO `savings_applications` (`id`, `fullname`, `gender`, `dob`, `marital_status`, `nic_passport`, `address`, `email`, `postal_code`, `nationality`, `contact_number`, `application_date`, `id_document`, `address_proof`, `tax_information`, `account_type`, `joint_fullname`, `joint_contact_number`, `status`) VALUES
(7, 'Tharini Rehansa Rajapaksha', 'Female', '2001-02-14', 'Single', '200080104340', '8 canal economic center road dambulla', '123.rehansa@gmail.com', '21100', 'Sri Lankan', '0771740070', '2025-01-09 07:43:10', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/1635039844549.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'Student', NULL, NULL, 'Approved'),
(8, 'Anna Watson', 'Female', '1987-10-21', 'Married', '456215878951', '7 hills salmal road colombo 4', 'Anna@gmail.com', '21100', 'Sri Lankan', '94779970602', '2025-01-09 07:46:55', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/download.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'Joint', 'Anna Cruse Watson', '94779970602', 'Pending'),
(9, 'Anna Watson', 'Female', '1998-06-10', 'Single', '456215878951', '7 hills salmal road colombo 4', 'Anna@gmail.com', '21100', 'Sri Lankan', '0112837433', '2025-01-10 08:38:09', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/download.jpeg', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/Guidelines.pdf', 'Student', NULL, NULL, 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_register`
--
ALTER TABLE `admin_register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `advisors`
--
ALTER TABLE `advisors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advisor_bookings`
--
ALTER TABLE `advisor_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `advisor_id` (`advisor_id`);

--
-- Indexes for table `client_profiles`
--
ALTER TABLE `client_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `client_register`
--
ALTER TABLE `client_register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_exchange_rates`
--
ALTER TABLE `currency_exchange_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `error_logs`
--
ALTER TABLE `error_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_staff`
--
ALTER TABLE `finance_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `investment_data`
--
ALTER TABLE `investment_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `loan_applications`
--
ALTER TABLE `loan_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mortgage_applications`
--
ALTER TABLE `mortgage_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `savings_applications`
--
ALTER TABLE `savings_applications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_register`
--
ALTER TABLE `admin_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `advisors`
--
ALTER TABLE `advisors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `advisor_bookings`
--
ALTER TABLE `advisor_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `client_profiles`
--
ALTER TABLE `client_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `client_register`
--
ALTER TABLE `client_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currency_exchange_rates`
--
ALTER TABLE `currency_exchange_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `error_logs`
--
ALTER TABLE `error_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `finance_staff`
--
ALTER TABLE `finance_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `investment_data`
--
ALTER TABLE `investment_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `loan_applications`
--
ALTER TABLE `loan_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mortgage_applications`
--
ALTER TABLE `mortgage_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `savings_applications`
--
ALTER TABLE `savings_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advisor_bookings`
--
ALTER TABLE `advisor_bookings`
  ADD CONSTRAINT `advisor_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `client_register` (`id`),
  ADD CONSTRAINT `advisor_bookings_ibfk_2` FOREIGN KEY (`advisor_id`) REFERENCES `advisors` (`id`);

--
-- Constraints for table `client_profiles`
--
ALTER TABLE `client_profiles`
  ADD CONSTRAINT `client_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `client_register` (`id`);

--
-- Constraints for table `investment_data`
--
ALTER TABLE `investment_data`
  ADD CONSTRAINT `investment_data_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client_register` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
