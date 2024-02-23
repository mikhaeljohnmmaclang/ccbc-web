-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2023 at 04:44 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commitments`
--

CREATE TABLE `commitments` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `amount` double UNSIGNED NOT NULL,
  `year` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commitments`
--

INSERT INTO `commitments` (`id`, `name`, `member_id`, `amount`, `year`, `created_at`, `updated_at`) VALUES
(1, 'firstfruit', 1, 21700, '2023', '2023-01-17 05:58:27', NULL),
(2, 'firstfruit', 2, 12998, '2023', '2023-01-17 06:08:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descriptions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requested_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` double UNSIGNED DEFAULT NULL,
  `recorded_by` bigint(20) DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `birthdate`, `address`, `contact_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mikhael Maclang', 'mikhaeljohnmmaclang@gmail.com', '1997-07-02', 'Malolos, Bulacan', NULL, '1', '2023-01-17 01:52:11', '2023-01-17 06:24:08'),
(2, 'Philip Jason Bersamen', NULL, '1997-04-25', NULL, NULL, '1', '2023-01-17 06:00:42', '2023-01-17 06:26:38');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_01_17_202946_create_activity_logs_table', 1),
(3, '2023_01_17_202946_create_commitments_table', 1),
(4, '2023_01_17_202946_create_expenses_table', 1),
(5, '2023_01_17_202946_create_failed_jobs_table', 1),
(6, '2023_01_17_202946_create_members_table', 1),
(7, '2023_01_17_202946_create_ministries_table', 1),
(8, '2023_01_17_202946_create_offerings_table', 1),
(9, '2023_01_17_202946_create_password_resets_table', 1),
(10, '2023_01_17_202946_create_users_table', 1),
(11, '2023_01_17_202947_add_foreign_keys_to_commitments_table', 1),
(12, '2023_01_17_202947_add_foreign_keys_to_expenses_table', 1),
(13, '2023_01_17_202947_add_foreign_keys_to_offerings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ministries`
--

CREATE TABLE `ministries` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ministries`
--

INSERT INTO `ministries` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Care', '1', '2023-01-18 10:45:13', '2023-01-18 10:45:13'),
(2, 'YDC', '1', '2023-01-17 04:54:51', '0000-00-00 00:00:00'),
(3, 'LEM', '1', '2023-01-17 05:48:11', '2023-01-17 05:48:11'),
(4, 'Firstfruits', '1', '2023-01-17 07:56:27', '0000-00-00 00:00:00'),
(5, 'Choir', '1', '2023-01-17 10:01:39', '0000-00-00 00:00:00'),
(6, 'Prayer Breakfast', '1', '2023-01-17 10:01:47', '0000-00-00 00:00:00'),
(7, 'M&M', '1', '2023-01-17 10:02:09', '0000-00-00 00:00:00'),
(8, 'Mission', '1', '2023-01-17 10:02:16', '0000-00-00 00:00:00'),
(9, 'Tithes', '1', '2023-01-17 10:05:52', '0000-00-00 00:00:00'),
(10, 'Offering', '1', '2023-01-17 10:06:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `offerings`
--

CREATE TABLE `offerings` (
  `id` bigint(20) NOT NULL,
  `ministry_id` bigint(20) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `date` date DEFAULT NULL,
  `amount` double UNSIGNED DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offerings`
--

INSERT INTO `offerings` (`id`, `ministry_id`, `member_id`, `date`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(21, 10, 1, '2023-01-17', 1, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(22, 9, 1, '2023-01-17', 2, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(23, 8, 1, '2023-01-17', 3, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(24, 7, 1, '2023-01-17', 4, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(25, 6, 1, '2023-01-17', 5, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(26, 5, 1, '2023-01-17', 6, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(27, 4, 1, '2023-01-17', 7, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(28, 3, 1, '2023-01-17', 8, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(29, 2, 1, '2023-01-17', 9, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(30, 1, 1, '2023-01-17', 10, '1', '2023-01-17 15:08:09', '2023-01-17 15:08:09'),
(31, 10, 2, '2023-01-17', 0, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(32, 9, 2, '2023-01-17', 0, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(33, 8, 2, '2023-01-17', 0, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(34, 7, 2, '2023-01-17', 0, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(35, 6, 2, '2023-01-17', 0, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(36, 5, 2, '2023-01-17', 0, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(37, 4, 2, '2023-01-17', 100, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(38, 3, 2, '2023-01-17', 0, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(39, 2, 2, '2023-01-17', 0, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(40, 1, 2, '2023-01-17', 0, '1', '2023-01-17 15:14:39', '2023-01-17 15:14:39'),
(41, 4, 1, '2023-01-18', 400, '1', '2023-01-18 13:00:18', '2023-01-18 13:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Staff','Admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL COMMENT '1=Active, 0=Inactive',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `status`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', 'Admin', NULL, 1, '$2y$10$40GVT2Qc9CGGWEogdPIqI.jSM5ZdIeqsHrtp.YZiPDD3FscBeNEDm', NULL, '2023-01-16 14:18:11', '2023-01-16 14:18:11'),
(3, 'Grace Lingo', 'grace@mail.com', 'Staff', NULL, 1, '$2y$10$fyfqGKC3RKWqtwXDCOELR.T7ggMgZnj.Gseo5n.1z2b9aHOXtpMxO', NULL, '2023-01-16 16:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commitments`
--
ALTER TABLE `commitments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commitments_members_id` (`member_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_user_id` (`recorded_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `handlers_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ministries`
--
ALTER TABLE `ministries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offerings`
--
ALTER TABLE `offerings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offerings_ministries_id` (`ministry_id`),
  ADD KEY `offerings_members_id` (`member_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commitments`
--
ALTER TABLE `commitments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ministries`
--
ALTER TABLE `ministries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `offerings`
--
ALTER TABLE `offerings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commitments`
--
ALTER TABLE `commitments`
  ADD CONSTRAINT `commitments_members_id` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_user_id` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `offerings`
--
ALTER TABLE `offerings`
  ADD CONSTRAINT `offerings_members_id` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `offerings_ministries_id` FOREIGN KEY (`ministry_id`) REFERENCES `ministries` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
