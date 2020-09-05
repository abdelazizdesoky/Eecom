-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2020 at 08:56 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shops`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `ordering` int(11) DEFAULT NULL,
  `visiablty` tinyint(4) NOT NULL DEFAULT 0,
  `allow_com` tinyint(4) NOT NULL DEFAULT 0,
  `allow_ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `parent`, `ordering`, `visiablty`, `allow_com`, `allow_ads`) VALUES
(5, 'Computer', 'computer', 0, 2, 1, 1, 1),
(6, 'Hand made', 'appliction home', 0, 3, 1, 1, 1),
(7, 'Tools', 'Tools', 0, 4, 1, 1, 1),
(8, 'nokia', 'nokia phone', 11, 1, 1, 1, 1),
(11, 'Mobil', 'Mobil phone', 0, 6, 1, 1, 1),
(13, 'iphon', 'mobil iphpn', 11, 2, 1, 1, 1),
(14, 'pc', 'pc computer', 5, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `com_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `comment`, `status`, `com_date`, `item_id`, `user_id`) VALUES
(28, 'good iphone', 1, '2020-08-30', 52, 5),
(29, 'good heater', 1, '2020-08-30', 51, 17);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `country_made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `approve` smallint(6) NOT NULL DEFAULT 0,
  `cat_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `description`, `price`, `add_date`, `country_made`, `image`, `status`, `rating`, `approve`, `cat_id`, `member_id`, `img`, `tags`) VALUES
(49, 'royal', 'royal jaz', '200000', '2020-08-23', 'egypt', '', '5', 0, 1, 7, 5, '516748-2.jpg', 'royal,new,home'),
(50, 'simfer', 'simfer ovien', '200', '2020-08-23', 'egypt', '', '1', 0, 1, 5, 5, '1483693-3.png', 'simfer,new,home'),
(51, 'atlantic', 'atlantic heater', '100', '2020-08-23', 'egypt', '', '2', 0, 1, 6, 5, '6734358-1.png', 'atlantic,new,home'),
(52, 'iphon', 'iphon 6 3-32g', '200', '2020-08-23', 'china', '', '5', 0, 1, 11, 5, 'img.png', 'mobil,iphone'),
(53, 'samsung', 'mobil samsung  n95', '222', '2020-08-23', 'china', '', '3', 0, 1, 11, 1, '7610395-san.jpg', 'mobil,iphone');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'avtar.jpg',
  `data_reg` date NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `rank_id` int(11) NOT NULL DEFAULT 0,
  `reg_sta` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `fullname`, `email`, `avatar`, `data_reg`, `group_id`, `rank_id`, `reg_sta`) VALUES
(1, 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'administrator', 'admin@admin', '553955_images (2).jpg', '2020-06-22', 1, 1, 1),
(5, 'adele', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'adell', 'adel@shop', 'avtar.jpg', '2020-06-27', 0, 0, 1),
(6, 'zezo', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'zezo', 'zezo@zshop', '652687_facebook-login-user-profile-avatar-computer-network-chart-eyewear-cartoon-head-png-clip-art.png', '2020-06-28', 0, 0, 1),
(10, 'user', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'user', 'user@admin.com', '653146_images (2).jpg', '2020-07-03', 0, 0, 1),
(11, 'osama2', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'osama', 'osama@admin.com', '176023_facebook-login-user-profile-avatar-computer-network-chart-eyewear-cartoon-head-png-clip-art.png', '2020-07-05', 0, 0, 1),
(12, 'osama3', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', 'osama@admin.com', 'avtar.jpg', '2020-07-05', 0, 0, 1),
(13, 'osama4', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', 'osama@admin.com', 'avtar.jpg', '2020-07-05', 0, 0, 1),
(17, 'ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ahmed ali', 'ahmed@zshop.com', '792440_facebook-login-user-profile-avatar-computer-network-chart-eyewear-cartoon-head-png-clip-art.png', '2020-08-15', 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `con-3` (`item_id`),
  ADD KEY `con-4` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `cons-1` (`member_id`),
  ADD KEY `cons-2` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `con-3` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `con-4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cons-1` FOREIGN KEY (`member_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cons-2` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
