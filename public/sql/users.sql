-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2023 at 12:37 PM
-- Server version: 10.4.26-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbcc_db_cbcc`
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `status`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', 'Admin', NULL, 1, '$2y$10$40GVT2Qc9CGGWEogdPIqI.jSM5ZdIeqsHrtp.YZiPDD3FscBeNEDm', NULL, '2023-01-16 14:18:11', '2023-01-16 14:18:11'),
(3, 'Grace Lingo', 'grace@mail.com', 'Staff', NULL, 1, '$2y$10$fyfqGKC3RKWqtwXDCOELR.T7ggMgZnj.Gseo5n.1z2b9aHOXtpMxO', NULL, '2023-01-16 16:00:00', NULL),
(4, 'Malou Espiritu', 'espiritumalou92@gmail.com', 'Staff', NULL, 1, '$2y$10$gki2Nr9VKDH.cw8wuIrM4e.ykMSdVU9cyzR7R4Z6/gNs.b6HBcIt.', NULL, '2023-01-29 00:00:00', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
