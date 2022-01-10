-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2022 at 03:07 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

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
  `date` date NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL,
  `news_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`content`, `headline`, `imgpath`, `date`, `active`, `news_id`) VALUES
('This is an example of pure sigma Male Energy', 'Breaking', 'uploads/news/SIGMAnews_61dc0c1268486-thumb.jpg', '2022-01-10', 1, 6),
('is not a mimic i swear', 'Great Chest Ahead', 'uploads/news/mimic_61dc10807838f-thumb.jpg', '2022-01-10', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketID` int(255) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `text_guest` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `text_service` text NOT NULL,
  `resolved` int(4) NOT NULL,
  `userID` int(255) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticketID`, `Title`, `text_guest`, `image_path`, `text_service`, `resolved`, `userID`, `Date`, `status`) VALUES
(1, 'great chest was actually mimic', 'WTF', 'uploads/service/service_1641813878_61dc17768c68d-thumb.jpg', 'h', 0, 56, '0000-00-00', 1),
(2, 'i died', 'but its ok', 'uploads/service/service_1641814064_61dc18307d54b-thumb.jpg', 'hj', 0, 45, '2022-01-10', 1),
(3, 'pokemon', 'i play pokemon go everyday, and it is detrimental to my sanity', 'uploads/service/service_1641822622_61dc399e0b282-thumb.jpg', 'j', 0, 45, '2022-01-10', 1),
(4, 'lucky mf', 'i jealous', 'uploads/service/service_1641822664_61dc39c85a917-thumb.jpg', 'g', 0, 45, '2022-01-10', 1),
(5, 'so horny', 'wow', 'uploads/service/service_1641822698_61dc39ea84a19-thumb.jpg', 'h', 0, 45, '2022-01-10', 1),
(6, 'natu', 'a', 'uploads/service/service_1641822718_61dc39feacfb4-thumb.jpg', '', 0, 45, '2022-01-10', 1);

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
  MODIFY `news_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
