-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2019 at 10:28 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `his`
--

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `diag_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `temp` varchar(256) DEFAULT NULL,
  `bp` varchar(256) DEFAULT NULL,
  `presp1` varchar(256) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `remarks` varchar(256) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`diag_id`, `user_id`, `temp`, `bp`, `presp1`, `test_id`, `remarks`, `created`) VALUES
(2, 11, 'temp', 'bp', 'presp', 0, 'presp', '2019-05-26 09:41:49'),
(3, 16, 'temp', 'bp', 'presp', 1, 'presp', '2019-07-17 08:14:01');

-- --------------------------------------------------------

--
-- Table structure for table `drug`
--

CREATE TABLE `drug` (
  `drug_id` int(11) NOT NULL,
  `name` varchar(11) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `presp` varchar(256) DEFAULT NULL,
  `price` int(30) DEFAULT NULL,
  `qty` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drug`
--

INSERT INTO `drug` (`drug_id`, `name`, `expiry`, `presp`, `price`, `qty`) VALUES
(5, 'ARV', '2024-01-01', '10 Per day', 5000, -5),
(6, 'drug', '2023-01-01', '2 times a day', 5000, 0),
(7, 'Aspirin', '2019-05-29', '10 Per day', 5000, 0),
(8, 'Drug1', '2019-06-28', '2 times a day', 5000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `growth`
--

CREATE TABLE `growth` (
  `user_id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `bmi` int(100) NOT NULL DEFAULT '0',
  `headc` int(100) NOT NULL DEFAULT '0',
  `gender` varchar(100) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `growth`
--

INSERT INTO `growth` (`user_id`, `weight`, `height`, `bmi`, `headc`, `gender`, `created`) VALUES
(11, 80, 100, 0, 0, NULL, '2019-05-29 08:50:41'),
(11, 100, 120, 0, 0, NULL, '2019-05-29 08:50:56'),
(11, 110, 140, 0, 0, NULL, '2019-05-29 08:51:08'),
(11, 120, 160, 0, 0, NULL, '2019-05-29 08:55:31'),
(11, 140, 180, 0, 0, NULL, '2019-05-29 08:56:04'),
(11, 140, 180, 0, 2, '0', '2019-07-09 14:18:03'),
(11, 140, 180, 0, 2, NULL, '2019-07-09 14:21:33'),
(11, 140, 180, 0, 2, NULL, '2019-07-09 14:22:56'),
(11, 140, 180, 0, 2, NULL, '2019-07-09 14:23:20'),
(11, 140, 180, 0, 2, 'male', '2019-07-09 14:35:09'),
(11, 140, 180, 0, 2, 'male', '2019-07-09 14:35:16'),
(11, 140, 180, 0, 2, 'female', '2019-07-09 14:35:44'),
(16, 20, 10, 11, 100, 'male', '2019-07-11 07:56:50'),
(16, 40, 20, 12, 300, 'male', '2019-07-11 07:57:11'),
(16, 50, 29, 20, 400, 'male', '2019-07-11 07:57:31');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(256) DEFAULT NULL,
  `lastname` varchar(256) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text,
  `married` varchar(256) DEFAULT NULL,
  `dor` date DEFAULT NULL,
  `contact` varchar(256) DEFAULT NULL,
  `referred` varchar(30) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`user_id`, `firstname`, `lastname`, `dob`, `address`, `married`, `dor`, `contact`, `referred`, `reason`) VALUES
(16, 'Brian', 'Msyamboza', '2019-01-01', 'P.O. Box 32153', 'married', '2019-07-11', 'Contact', 'Manchester United', 'not interested anymore');

-- --------------------------------------------------------

--
-- Table structure for table `requisitions`
--

CREATE TABLE `requisitions` (
  `req_id` int(255) NOT NULL,
  `drug_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0',
  `email` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requisitions`
--

INSERT INTO `requisitions` (`req_id`, `drug_id`, `qty`, `created`, `status`, `email`) VALUES
(167, 5, 1, '2019-05-29 14:41:40', 1, 'brianmsyamboza@gmail.com'),
(167, 6, 1, '2019-05-29 14:41:40', 1, 'brianmsyamboza@gmail.com'),
(167, 7, 1, '2019-05-29 14:41:40', 1, 'brianmsyamboza@gmail.com'),
(236, 7, 1, '2019-05-29 14:53:12', 1, 'brianmsyamboza@gmail.com'),
(236, 6, 1, '2019-05-29 14:53:12', 1, 'brianmsyamboza@gmail.com'),
(236, 5, 1, '2019-05-29 14:53:12', 1, 'brianmsyamboza@gmail.com'),
(235, 7, 1, '2019-05-29 14:55:48', 1, 'brianmsyamboza@gmail.com'),
(235, 6, 1, '2019-05-29 14:55:48', 1, 'brianmsyamboza@gmail.com'),
(235, 5, 3, '2019-05-29 14:55:48', 1, 'brianmsyamboza@gmail.com'),
(56, 7, 3, '2019-05-29 14:56:42', 1, 'brianmsyamboza@gmail.com'),
(56, 6, 1, '2019-05-29 14:56:42', 1, 'brianmsyamboza@gmail.com'),
(243, 7, 1, '2019-05-29 14:57:30', 1, 'brianmsyamboza@gmail.com'),
(136, 7, 3, '2019-05-29 14:58:15', 1, 'brianmsyamboza@gmail.com'),
(136, 6, 1, '2019-05-29 14:58:15', 1, 'brianmsyamboza@gmail.com'),
(55, 7, 1, '2019-05-29 19:34:00', 1, 'brianmsyamboza@gmail.com'),
(182, 5, 1, '2019-05-29 19:36:19', 1, 'brianmsyamboza@gmail.com'),
(193, 5, 5, '2019-06-28 08:11:00', 0, 'brianmsyamboza@gmail.com'),
(3, 5, 5, '2019-06-28 08:11:51', 2, 'brianmsyamboza@gmail.com'),
(131, 5, 5, '2019-06-28 08:13:12', 0, 'brianmsyamboza@gmail.com'),
(180, 5, 5, '2019-06-28 08:13:38', 0, 'brianmsyamboza@gmail.com'),
(162, 5, 5, '2019-06-28 08:14:57', 0, 'brianmsyamboza@gmail.com'),
(193, 5, 5, '2019-06-28 08:16:03', 0, 'brianmsyamboza@gmail.com'),
(177, 8, 5, '2019-06-28 08:16:18', 0, 'brianmsyamboza@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `result` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `test_name`, `result`, `user_id`) VALUES
(1, 'Malaria', 'Positive', 16),
(2, 'Malaria', 'Positive', 16),
(3, 'Malaria', 'Positive', 16),
(4, 'Malaria', 'Positive', 16),
(5, 'AIDS', 'negative', 16),
(6, 'AIDS', 'negative', 16);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `role`) VALUES
(1, 'yussuf@gmail.com', '123', 'admin'),
(2, 'seifudin@gmail.com', '1234', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`diag_id`);

--
-- Indexes for table `drug`
--
ALTER TABLE `drug`
  ADD PRIMARY KEY (`drug_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diagnosis`
--
ALTER TABLE `diagnosis`
  MODIFY `diag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `drug`
--
ALTER TABLE `drug`
  MODIFY `drug_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
