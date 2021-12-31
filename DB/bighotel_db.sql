-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2021 at 11:31 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bighotel_db`
--
CREATE DATABASE IF NOT EXISTS `bighotel_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bighotel_db`;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `content` text DEFAULT NULL,
  `headline` varchar(50) DEFAULT NULL,
  `imgpath` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `news_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketID` int(255) NOT NULL,
  `text_guest` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `text_service` text NOT NULL,
  `resolved` int(4) NOT NULL,
  `userID` int(255) NOT NULL,
  `Date` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `pw_notiz` varchar(100) NOT NULL COMMENT 'Nur für PW merken zur Arbeit -> LÖSCHEN!',
  `password` varchar(255) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `anrede` enum('Herr','Frau','Non-Binary','NA') DEFAULT NULL,
  `vorname` varchar(50) DEFAULT NULL,
  `nachname` varchar(50) DEFAULT NULL,
  `room` int(255) DEFAULT NULL,
  `userID` int(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `role` enum('Admin','Service','Guest') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `pw_notiz`, `password`, `email`, `anrede`, `vorname`, `nachname`, `room`, `userID`, `active`, `role`) VALUES
('admin', 'admin', '$2y$10$z0mpART0vg14vQuCndUKI.ZNhM7UbYX8GVVM/jKQvx3NFZjvd38F6', 'admin@admin.at', 'NA', '', '', 0, 45, 1, 'Admin'),
('service@biglyhotel.at', 'service123', '$2y$10$Q5f8T04mKPVTN8gCU0Ob4OzOmL9Zj6wIrQlxSogUMjM8dRGxQgnnS', 'service@biglyhotel.at', 'NA', '', '', 0, 46, 1, 'Service'),
('guest@biglyhotel.at', 'guest123', '$2y$10$yxd9ZZw43HTipd9toBjqPertENK5CWl74Lq8m.Bl/kpaSrmVrDtDq', 'guest@biglyhotel.at', 'NA', 'Max', 'Mustermann', 0, 56, 1, 'Guest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticketID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
