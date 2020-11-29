-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2020 at 06:43 PM
-- Server version: 10.5.8-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expmgr`
--

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `card_id` int(11) NOT NULL,
  `card_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`card_id`, `card_name`, `uid`) VALUES
(2, 'HDFC', 9),
(3, 'Egg ICICI', 10),
(4, 'Egg SBI', 10),
(5, 'HDFC Card', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `eid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`eid`, `uid`, `amount`, `title`, `payment_type`, `type`, `date`, `bank`, `card_id`) VALUES
(18, 1, 111, 'Milk', 'cashPayment', 'debit', '2020-11-26', NULL, NULL),
(19, 1, 111, 'Milk', 'cashPayment', 'debit', '2020-11-26', NULL, NULL),
(20, 1, 20000, 'Salary', 'cashPayment', 'credit', '2020-11-25', NULL, NULL),
(21, 9, 60000, 'Salary', 'cardPayment', 'debit', '2020-11-27', NULL, NULL),
(22, 10, 3000, 'Dined Out', 'cashPayment', 'debit', '2020-11-27', NULL, NULL),
(23, 10, 5000, 'Takeout', 'internetBanking', 'credit', '2020-11-05', '3470-1100', NULL),
(24, 10, 4070, 'Egg Purchase', 'cardPayment', 'credit', '2020-10-30', NULL, NULL),
(25, 10, 70001, 'Mayo Purchase', 'cardPayment', 'debit', '2020-09-07', NULL, NULL),
(26, 10, 491, 'chicken', 'cashPayment', 'debit', '2020-11-03', NULL, NULL),
(27, 10, 400, 'KFC', 'cardPayment', 'credit', '2020-10-26', NULL, NULL),
(28, 10, 6009, 'goo', 'internetBanking', 'credit', '2020-11-07', '1234-5678', NULL),
(29, 1, 200, 'Milk', 'cardPayment', 'debit', '2020-11-27', NULL, NULL),
(30, 1, 100, 'MMM', 'cardPayment', 'debit', '2020-11-26', NULL, NULL),
(31, 1, 1, 's', 'cardPayment', 'debit', '2020-11-19', NULL, NULL),
(32, 1, 9, 'k', 'cardPayment', 'debit', '2020-11-26', NULL, NULL),
(37, 1, 200, 'sdsd', 'cashPayment', 'credit', '2020-11-26', NULL, 5),
(39, 1, 111, 'lskjd', 'cardPayment', 'debit', '2020-11-26', NULL, 5),
(40, 1, 12, '897897', 'cardPayment', 'debit', '2020-11-26', NULL, 5),
(41, 1, 100, 'akjdhaskjdh', 'internetBanking', 'debit', '2020-11-18', 'SBI', NULL),
(42, 1, 111, 'kjhjkh', 'internetBanking', 'debit', '2020-11-26', 'askldhaslkdj', NULL),
(43, 11, 8767, 'khkjhjkh', 'cardPayment', 'debit', '2020-11-12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `username`, `email`, `pass`, `extra`) VALUES
(1, 'Mushrif', 'mushrifshahreyar@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(2, 'test', 'test@tmail.com', 'a53a7673bf4dbcf3558724b3d005ea04', NULL),
(3, 'Elon Musk', 'Iss_cheek_badi_hai_musk_musk@musk.com', '2fc5c7ce2ac13cb688dd74f500b1bc00', NULL),
(4, 'vito', 'varun@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(5, 'abhikmp', 'abhikampurath@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', NULL),
(9, 'mushrif', 'mushrif@gmail', '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(10, 'egg', 'egg@gmail.com', '0e9312087f58f367d001ec9bae8f325a', NULL),
(11, 'test', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`eid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `expense_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
