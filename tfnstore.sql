-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2018 at 01:06 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tfnstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `feed` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feeds`
--

INSERT INTO `feeds` (`id`, `title`, `feed`, `created`, `modified`) VALUES
(4, 'usdrate', '11966.4', '2018-01-22 08:13:29', '2018-01-22 08:13:29'),
(5, 'btcltc', '0.016470817500000000000000', '2018-01-22 08:39:16', '2018-01-22 08:39:16'),
(6, 'btceth', '0.091549090000000000000000', '2018-01-22 08:39:16', '2018-01-22 08:39:16'),
(8, 'btcdoge', '0.000000633333333333330000', '2018-01-22 08:39:16', '2018-01-22 08:39:16'),
(9, 'btcbch', '0.152011000000000000000000', '2018-01-22 08:39:16', '2018-01-22 08:39:16'),
(10, 'current_price', '0.5', '2018-01-22 09:08:47', '2018-01-22 09:08:47');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `conversion_rate` double DEFAULT NULL,
  `frg_amount` double DEFAULT NULL,
  `txn_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirms` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `email_confirmed` int(1) NOT NULL,
  `reset_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `wallet_id`, `amount`, `conversion_rate`, `frg_amount`, `txn_id`, `confirms`, `status`, `email_confirmed`, `reset_password`, `created`, `modified`) VALUES
(3, 13, 4, 2.52, 11966.4, 60310.656, 'mytxid', 1, 1, 0, NULL, '2018-01-23 00:14:30', '2018-01-23 00:14:30'),
(4, 13, 5, 2.52, 0.00757872, 0.0381967488, 'mytxidKJ', 2, 100, 0, NULL, '2018-01-23 00:20:22', '2018-01-23 00:20:22'),
(5, 13, 6, 20.525, 1095.513030576, 44970.81, 'mytxidfddKJ', 2, 2, 0, NULL, '2018-01-23 00:28:57', '2018-01-23 00:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `first_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `2fa` int(2) NOT NULL COMMENT '0-2fa disabled, 1-2fa enabled',
  `2fa_secret` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ref_id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `referrer` int(11) DEFAULT NULL,
  `frg_wallet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type_id`, `first_name`, `last_name`, `username`, `password`, `2fa`, `2fa_secret`, `ref_id`, `referrer`, `frg_wallet`, `created`, `modified`) VALUES
(13, 2, 'obumneke', 'gffgfg', 'jeffucee10@gmail.com', '$2a$10$8h/GTyWvBNkfaTJDveO2muzEFvlMyg.ZQCeMJ0bBcyEZ5rwIdhSya', 0, 'JPHU6DUW3A3LFJXHGJPK5NRVHV5Q6ZIJ', '2BySgjBd6', NULL, 'ghjbunoiiolop', '2018-01-21 22:35:48', '2018-01-21 22:35:48'),
(14, 2, 'obumneke', 'gffgfg', 'jeffucee10@gmailf.com', '$2a$10$UGKfgJ7zZOrw8NLkxMk.OuuuABXhe/EN83xOtXsYUMaHVP3255.aG', 0, NULL, 'nY3QFZcSZ', NULL, '', '2018-01-21 22:40:57', '2018-01-21 22:40:57'),
(15, 2, 'obumneke', 'gffgfg', 'jeffucee10@gmailf.fcom', '$2a$10$xXxqO3BnTib4RqXYI4mlPOZG63AzedmsnUdoYEP4eMhG0BAaMC9pC', 0, NULL, '5qQTzGKeB', NULL, '', '2018-01-21 22:47:00', '2018-01-21 22:47:00'),
(16, 2, 'obumneke', 'gffgfg', 'jeffucfee10@gmailf.fcom', '$2a$10$ujA/UaD4l3n2Jvfg56A.sOBhNJSDiFs3dVLOoeUkQ6gd/egz9ZHDK', 0, NULL, 'kz74zEwA4', NULL, '', '2018-01-21 22:50:21', '2018-01-21 22:50:21');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pubkey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `currency`, `address`, `pubkey`, `created`, `modified`) VALUES
(4, 13, 'BTC', '34GW9zrnXWHvMAzkKofSuwrkWyTR4JsVx8', '1P3TaMup1jkT3NaiRm6oFJ7wejjXLHsynR', '2018-01-22 15:27:56', '2018-01-22 15:27:56'),
(5, 13, 'DOGE', 'DFV3emihSuAQu5Td5FoMpWdueczHkpYgy4', NULL, '2018-01-22 15:29:37', '2018-01-22 15:29:37'),
(6, 13, 'ETH', '0xb0887bb3e734fd5f25ad7a673b8cfbe9edcdf2b8', NULL, '2018-01-22 15:34:43', '2018-01-22 15:34:43'),
(7, 13, 'LTC', 'LbLgoeEGkQvmnR9En1x9tyZAHzDFqcEpCX', NULL, '2018-01-23 07:33:22', '2018-01-23 07:33:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
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
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
