-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 07, 2017 at 04:15 AM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `insta_mails`
--

-- --------------------------------------------------------

--
-- Table structure for table `cron`
--

CREATE TABLE `cron` (
  `id` int(11) NOT NULL,
  `test` varchar(100) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insta_request`
--

CREATE TABLE `insta_request` (
  `id` int(11) NOT NULL,
  `hashtag` varchar(500) NOT NULL,
  `max` varchar(500) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id` int(11) NOT NULL,
  `mail` varchar(500) NOT NULL,
  `username` varchar(500) NOT NULL,
  `url` varchar(500) NOT NULL,
  `followers` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mails_scrap`
--

CREATE TABLE `mails_scrap` (
  `id` int(11) NOT NULL,
  `email` varchar(500) NOT NULL,
  `username` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `followers` int(11) NOT NULL,
  `hashtag` varchar(200) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `externalUrl` varchar(500) DEFAULT NULL,
  `location` varchar(500) DEFAULT NULL,
  `conner` tinyint(4) NOT NULL DEFAULT '0',
  `instagram_unique_id` varchar(100) NOT NULL,
  `fullName` varchar(500) NOT NULL,
  `profilePicUrl` varchar(500) NOT NULL,
  `biography` varchar(500) NOT NULL,
  `followsCount` int(11) NOT NULL,
  `mediaCount` int(11) NOT NULL,
  `isPrivate` int(11) NOT NULL,
  `isVerified` int(11) NOT NULL,
  `country` varchar(500) DEFAULT NULL,
  `city` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `twitter`
--

CREATE TABLE `twitter` (
  `id` int(6) UNSIGNED NOT NULL,
  `mail` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_followers`
--

CREATE TABLE `user_followers` (
  `id` int(11) NOT NULL,
  `email` varchar(500) NOT NULL,
  `username` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `followers` int(11) NOT NULL,
  `hashtag` varchar(200) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `externalUrl` varchar(500) DEFAULT NULL,
  `location` varchar(500) DEFAULT NULL,
  `conner` tinyint(4) NOT NULL DEFAULT '0',
  `instagram_unique_id` varchar(100) NOT NULL,
  `fullName` varchar(500) NOT NULL,
  `profilePicUrl` varchar(500) NOT NULL,
  `biography` varchar(500) NOT NULL,
  `followsCount` int(11) NOT NULL,
  `mediaCount` int(11) NOT NULL,
  `isPrivate` int(11) NOT NULL,
  `isVerified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cron`
--
ALTER TABLE `cron`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insta_request`
--
ALTER TABLE `insta_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mails_scrap`
--
ALTER TABLE `mails_scrap`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `twitter`
--
ALTER TABLE `twitter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_followers`
--
ALTER TABLE `user_followers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cron`
--
ALTER TABLE `cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50839;
--
-- AUTO_INCREMENT for table `insta_request`
--
ALTER TABLE `insta_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=600;
--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45584;
--
-- AUTO_INCREMENT for table `mails_scrap`
--
ALTER TABLE `mails_scrap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1821991;
--
-- AUTO_INCREMENT for table `twitter`
--
ALTER TABLE `twitter`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=901;
--
-- AUTO_INCREMENT for table `user_followers`
--
ALTER TABLE `user_followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
