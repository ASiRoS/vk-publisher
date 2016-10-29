-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 29, 2016 at 06:01 AM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vk-publisher`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `text` text CHARACTER SET utf8,
  `imagesLinks` text CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `text`, `imagesLinks`) VALUES
(15, 'SELECT text, imagesLinks FROM post WHERE id = \'12\';', '/home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4.jpg'),
(16, '112437872', '/home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4.jpg'),
(17, 'sassas', '/home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4.jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (3rd copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (4th copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (another copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (copy).jpg'),
(18, '112437872\r\nhome_medusa', '/home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4.jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (3rd copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (4th copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (another copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (copy).jpg'),
(19, '112437872\r\nhome_medusa', '/home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4.jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (3rd copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (4th copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (another copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (copy).jpg'),
(20, '112437872\r\nhome_medusa', '/home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4.jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (3rd copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (4th copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (another copy).jpg, /home/asiro/Desktop/sites/mama/vk-publisher/images/kDuBTq-gHc4 (copy).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `VKGroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `postID`, `VKGroupID`) VALUES
(20, 20, 112437872),
(21, 20, 119296602);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postID` (`postID`),
  ADD KEY `postID_2` (`postID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
