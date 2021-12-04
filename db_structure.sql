-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 04, 2021 at 05:55 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `subscriptions_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `Merchants`
--

CREATE TABLE `Merchants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Partners`
--

CREATE TABLE `Partners` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Subscriptions`
--

CREATE TABLE `Subscriptions` (
  `merchant` int(11) NOT NULL,
  `partner` int(11) NOT NULL,
  `subscription_type` int(11) NOT NULL,
  `subscription_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Subscription_Types`
--

CREATE TABLE `Subscription_Types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Merchants`
--
ALTER TABLE `Merchants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Partners`
--
ALTER TABLE `Partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Subscriptions`
--
ALTER TABLE `Subscriptions`
  ADD PRIMARY KEY (`subscription_type`,`merchant`,`partner`),
  ADD KEY `FK_PARTNER` (`partner`),
  ADD KEY `FK_MERCHANT` (`merchant`);

--
-- Indexes for table `Subscription_Types`
--
ALTER TABLE `Subscription_Types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Merchants`
--
ALTER TABLE `Merchants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Partners`
--
ALTER TABLE `Partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Subscription_Types`
--
ALTER TABLE `Subscription_Types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Subscriptions`
--
ALTER TABLE `Subscriptions`
  ADD CONSTRAINT `FK_MERCHANT` FOREIGN KEY (`merchant`) REFERENCES `Merchants` (`id`),
  ADD CONSTRAINT `FK_PARTNER` FOREIGN KEY (`partner`) REFERENCES `Partners` (`id`),
  ADD CONSTRAINT `FK_SUBSCRIPTION_TYPE` FOREIGN KEY (`subscription_type`) REFERENCES `Subscription_Types` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
