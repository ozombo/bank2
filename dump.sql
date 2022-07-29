-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 29, 2022 at 04:00 PM
-- Server version: 5.7.32
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `online`
--

-- --------------------------------------------------------

--
-- Table structure for table `incoming`
--

CREATE TABLE `incoming` (
  `id` int(32) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` int(32) NOT NULL,
  `date` varchar(255) NOT NULL,
  `amount` int(32) NOT NULL,
  `status` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `incoming`
--

INSERT INTO `incoming` (`id`, `sender`, `receiver`, `date`, `amount`, `status`) VALUES
(1, 'Jane Predence', 1, '07/07/2022', 7500, 1),
(2, 'Femi', 2, '07/07/2022', 5000, 1),
(3, 'Didi', 1, '07/07/2022', 1200, 2);

-- --------------------------------------------------------

--
-- Table structure for table `outgoing`
--

CREATE TABLE `outgoing` (
  `id` int(32) NOT NULL,
  `receiver_account` int(12) NOT NULL,
  `swift_code` varchar(255) NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `sender` int(32) NOT NULL,
  `date` varchar(255) NOT NULL,
  `amount` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `outgoing`
--

INSERT INTO `outgoing` (`id`, `receiver_account`, `swift_code`, `receiver_name`, `email_address`, `sender`, `date`, `amount`) VALUES
(1, 1, '1', '1', 'oyexs911@yahoo.com', 1, '1659104360', 100);

-- --------------------------------------------------------

--
-- Table structure for table `userz`
--

CREATE TABLE `userz` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `year` varchar(255) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `account_number` int(10) NOT NULL,
  `account_branch` varchar(255) NOT NULL,
  `last_login` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userz`
--

INSERT INTO `userz` (`id`, `name`, `state`, `city`, `email`, `password`, `zip`, `country`, `picture`, `year`, `account_type`, `account_number`, `account_branch`, `last_login`) VALUES
(1, 'Admin', 'None', 'None', 'admin@admin.admin', '080c0c7d22cbf7f3739734513cdfd9ad', '00190', 'None', '', '1908', 'Current', 1000000001, 'None', '1659083020'),
(2, 'Adebambo Oyelaja', 'Lagos', 'Ejigbo', 'admin@admin.admins', '5cf1bc1b9a2ada1ae9e29079aae1aefa', '100001', 'a', NULL, '1988', '1', 1, '1', '1659095308');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `incoming`
--
ALTER TABLE `incoming`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outgoing`
--
ALTER TABLE `outgoing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userz`
--
ALTER TABLE `userz`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incoming`
--
ALTER TABLE `incoming`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `outgoing`
--
ALTER TABLE `outgoing`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userz`
--
ALTER TABLE `userz`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
