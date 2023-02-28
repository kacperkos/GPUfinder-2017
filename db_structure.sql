-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- MySQL version: 5.7.36
-- PHP version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Structure for table `card`
--

DROP TABLE IF EXISTS `card`;
CREATE TABLE IF NOT EXISTS `card` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `hashrate` double NOT NULL,
  `power` int(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Structure for table `crypto`
--

DROP TABLE IF EXISTS `crypto`;
CREATE TABLE IF NOT EXISTS `crypto` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `symbol` text COLLATE utf8_polish_ci NOT NULL,
  `price` double NOT NULL,
  `efficiency` double NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Structure for table `hashrate`
--

DROP TABLE IF EXISTS `hashrate`;
CREATE TABLE IF NOT EXISTS `hashrate` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `card_id` int(255) NOT NULL,
  `crypto_id` int(255) NOT NULL,
  `hashrate` double NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Structure for table `offer`
--

DROP TABLE IF EXISTS `offer`;
CREATE TABLE IF NOT EXISTS `offer` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `card_id` int(255) NOT NULL,
  `source` text COLLATE utf8_polish_ci NOT NULL,
  `source_id` bigint(255) NOT NULL,
  `price` double NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
