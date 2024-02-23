-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 02:03 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.3.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cbcc`
--

--
-- Dumping data for table `ministries`
--

INSERT INTO `ministries` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tithe', '1', '2023-01-27 12:54:24', '2023-01-17 05:17:57'),
(2, 'Offering', '1', '2023-01-27 12:55:20', '0000-00-00 00:00:00'),
(3, 'Firstfruits', '1', '2023-01-27 12:55:12', '2023-01-17 05:48:11'),
(4, 'Mission', '1', '2023-01-27 12:54:13', '0000-00-00 00:00:00'),
(5, 'Care', '1', '2023-01-27 12:55:09', '0000-00-00 00:00:00'),
(6, 'Ladies', '1', '2023-01-27 12:56:00', '0000-00-00 00:00:00'),
(7, 'Men', '1', '2023-01-27 12:54:56', '0000-00-00 00:00:00'),
(8, 'Youth', '1', '2023-01-27 12:55:02', '0000-00-00 00:00:00'),
(9, 'Choir', '1', '2023-01-27 12:56:07', '2023-01-27 10:48:35'),
(10, 'Prayer Breakfast', '1', '2023-01-27 12:56:15', '0000-00-00 00:00:00'),
(11, 'Circle of Faith', '1', '2023-01-27 10:48:47', '0000-00-00 00:00:00'),
(12, 'Creative Team', '1', '2023-01-27 10:48:58', '0000-00-00 00:00:00'),
(13, 'DVBS', '1', '2023-01-27 10:49:08', '0000-00-00 00:00:00'),
(14, 'Prison', '1', '2023-01-27 10:49:24', '0000-00-00 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
