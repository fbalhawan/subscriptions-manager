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

--
-- Dumping data for table `Merchants`
--

INSERT INTO `Merchants` (`id`, `name`, `email`, `password`) VALUES
(17, 'Prof. Jade Conroy I', 'amueller@beatty.com', '2c74d56c23646846f9eda53c1773981b');

--
-- Dumping data for table `Partners`
--

INSERT INTO `Partners` (`id`, `name`, `description`) VALUES
(1, 'Subscription Partner 1', 'Subscription Partner 1'),
(33, 'balhawan.fouad@gmail.com', 'password');

--
-- Dumping data for table `Subscriptions`
--

INSERT INTO `Subscriptions` (`merchant`, `partner`, `subscription_type`, `subscription_status`) VALUES
(17, 1, 1, 'PENDING'),
(17, 1, 2, 'PENDING');

--
-- Dumping data for table `Subscription_Types`
--

INSERT INTO `Subscription_Types` (`id`, `name`, `description`) VALUES
(1, 'Sub1', 'This is the first subscription type'),
(2, 'Sub2', 'This is the second subscription type');
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
