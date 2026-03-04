-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql110.infinityfree.com
-- Generation Time: Mar 04, 2026 at 11:25 AM
-- Server version: 11.4.10-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_37169829_cryptup`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@admin.com', 'admin123', '2025-07-17 05:44:39');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `coin` varchar(150) NOT NULL,
  `coin_amount` float NOT NULL,
  `address_to` varchar(255) NOT NULL,
  `status` varchar(150) NOT NULL DEFAULT 'verifying',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `coin`, `coin_amount`, `address_to`, `status`, `created_at`) VALUES
(1, '1', 'BTC', 0.007, '0xhjvjhdcjhsjhvxjhvsjahvkjdvkjkagvdkshvkajbkchv', 'verifying', '2025-07-24 22:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `code` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Elizabeth Stevenson', 'eliza@mailinator.com', '00000000', 'pending', '2025-07-19 14:01:37', '2025-07-25 09:33:28'),
(2, 'Clinton Green', 'fcloudin@gmail.com', '00000000', NULL, '2025-07-29 21:57:34', '2025-07-29 14:35:41'),
(4, 'Elton', 'Eltonemma51@gmail.com', '369528Ab$', NULL, '2025-08-04 13:42:59', '2025-08-04 13:42:59'),
(6, 'Clinton', 'fcloudin@gmail.com', '00000000', NULL, '2025-08-04 16:02:15', '2025-08-04 16:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `users_coins`
--

CREATE TABLE `users_coins` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `coin` varchar(150) NOT NULL,
  `aka` varchar(100) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `coin_balance` float DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_coins`
--

INSERT INTO `users_coins` (`id`, `user_id`, `coin`, `aka`, `price`, `balance`, `coin_balance`, `address`, `created_at`) VALUES
(1, '1', 'Bitcoin', 'BTC', 25000, 1200, 0.03454, 'bc1qjl6aj97yarysskj2270kvjm9nk3u3ktrg6qvem', '2025-07-24 08:46:56'),
(4, '1', 'USDC', 'USDC', NULL, NULL, 56, 'jhrkhgkjshgkjhghkjdhgjkdhgkjhskjdfhkjdh', '2025-07-28 14:17:06'),
(5, '1', 'Ethereum', 'ETH', NULL, NULL, 0.451, '0x8522D34C0dDAD7E2B9234Fa8D92b7A231f70Acfd', '2025-07-29 06:02:54'),
(6, '4', 'USDC', 'USDC', NULL, NULL, 20000, '0x8522D34C0dDAD7E2B9234Fa8D92b7A231f70Acfd', '2025-08-04 13:55:59'),
(7, '6', 'Stellar', 'XLM', NULL, NULL, 0.45, 'nbegiuriusbefejblswigzzebrgjedvmb', '2025-08-04 16:17:29'),
(8, '2', 'Cardano', 'ADA', NULL, NULL, 5, 'nbegiuriusbefejblswigzzebrgjedvmb', '2025-08-04 16:20:21');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `coin` varchar(255) NOT NULL,
  `aka` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_phrases`
--

CREATE TABLE `wallet_phrases` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `wallet` varchar(150) NOT NULL,
  `phrase` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallet_phrases`
--

INSERT INTO `wallet_phrases` (`id`, `user_id`, `wallet`, `phrase`, `created_at`, `updated_at`) VALUES
(3, '1', 'Trust wallet', 'word word word word word word word word word word word word', '2025-07-19 16:47:41', '2025-07-19 16:47:41'),
(4, '1', 'Phantom', 'phrase phrase phrase phrase phrase phrase phrase phrase phrase phrase phrase phrase', '2025-07-25 09:34:17', '2025-07-25 09:34:17'),
(5, '2', 'Trust wallet', 'dream dream dream dream dream dream dream dream dream dream dream dream', '2025-07-29 14:37:12', '2025-07-29 14:37:12'),
(6, '4', 'Trust Wallet ', 'dose actress carpet fat plastic inherit old breeze roof skirt civil square', '2025-08-04 13:45:17', '2025-08-04 13:45:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_coins`
--
ALTER TABLE `users_coins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_phrases`
--
ALTER TABLE `wallet_phrases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_coins`
--
ALTER TABLE `users_coins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_phrases`
--
ALTER TABLE `wallet_phrases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
