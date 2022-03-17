-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 17 مارس 2022 الساعة 20:43
-- إصدار الخادم: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `products2`
--

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Approve` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Approve`) VALUES
(6, 'السياسة', 1),
(7, 'الطبخ', 0),
(8, 'الاقتصاد', 0);

-- --------------------------------------------------------

--
-- بنية الجدول `items`
--

CREATE TABLE `items` (
  `ItemID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Date` varchar(255) NOT NULL,
  `quentity` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  `cat_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `items`
--

INSERT INTO `items` (`ItemID`, `Name`, `Description`, `Price`, `Date`, `quentity`, `image`, `Status`, `cat_id`) VALUES
(15, 'games', 'this is very goods', '9000', '03-17-2022', '12', '63261_4.png', 0, 6),
(16, 'khalifa alqiadi', 'this is very goods', '9000', '03-17-2022', '12', '87836_6.jpg', 0, 6);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `total` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`UserID`, `FullName`, `Email`, `Password`, `Location`, `avatar`, `total`) VALUES
(1, 'khalifa alqiadi', 'khalifa.alqaidi@gmail.com', '2778cb15047b69e5e1e166cbb0d8c4323c9595c6', 'sanaa', NULL, -337800),
(2, 'khalifa alqiadi', 'khaled@gmail.com', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'sanaa', NULL, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `wallet`
--

CREATE TABLE `wallet` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0,
  `pulleds` int(11) NOT NULL DEFAULT 0,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `wallet`
--

INSERT INTO `wallet` (`ID`, `userid`, `total`, `pulleds`, `Date`) VALUES
(1, 1, 10000, 0, '2022-03-11'),
(2, 1, 10000, 0, '2022-03-11'),
(3, 1, 20000, 0, '2022-03-11'),
(4, 2, 2500, 0, '2022-03-11'),
(5, 2, 1000, 0, '2022-03-11'),
(6, 1, 128000, 0, '2022-03-11'),
(7, 1, 5000, 0, '2022-03-11'),
(8, 1, 10000, 0, '2022-03-12'),
(9, 1, 20000, 0, '2022-03-12'),
(10, 1, 10000, 0, '2022-03-12');

-- --------------------------------------------------------

--
-- بنية الجدول `withdraw`
--

CREATE TABLE `withdraw` (
  `ID` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `withdraw` int(11) NOT NULL DEFAULT 0,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- إرجاع أو استيراد بيانات الجدول `withdraw`
--

INSERT INTO `withdraw` (`ID`, `userid`, `withdraw`, `Date`) VALUES
(21, 1, 40000, '2022-03-12'),
(22, 1, 20000, '2022-03-12'),
(23, 1, 140000, '2022-03-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `b_1` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `b_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
