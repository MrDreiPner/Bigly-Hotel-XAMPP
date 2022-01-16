-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2022 at 09:37 PM
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
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL,
  `news_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`content`, `headline`, `imgpath`, `date`, `time`, `active`, `news_id`) VALUES
('Is true... source: trust me bro\r\n\r\nUpdate: is really true. Wow', 'Trump has covid-20', 'uploads/news/_61e4105b4cdc7-thumb.jpg', '2022-01-16', '13:32:27', 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketID` int(255) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `text_guest` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `text_service` text NOT NULL,
  `resolved` enum('open','resolved','unresolved') NOT NULL,
  `userID` int(255) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticketID`, `Title`, `text_guest`, `image_path`, `text_service`, `resolved`, `userID`, `Date`, `Time`) VALUES
(1, 'great chest was actually mimic', 'WTF', 'uploads/service/service_1641813878_61dc17768c68d-thumb.jpg', 'Out of estus', 'open', 56, '0000-00-00', '20:21:47'),
(2, 'i died', 'but its ok', 'uploads/service/service_1641814064_61dc18307d54b-thumb.jpg', 'Respawn in 3... 2... 1... dead', 'open', 45, '2022-01-10', '20:21:47'),
(3, 'pokemon', 'i play pokemon go everyday, and it is detrimental to my sanity', 'uploads/service/service_1641822622_61dc399e0b282-thumb.jpg', 'Actually boney boi', 'open', 45, '2022-01-10', '20:21:47'),
(4, 'lucky mf', 'i jealous', 'uploads/service/service_1641822664_61dc39c85a917-thumb.jpg', 'g', 'open', 45, '2022-01-10', '20:21:47'),
(5, 'so horny', 'wow', 'uploads/service/service_1641822698_61dc39ea84a19-thumb.jpg', 'Going to horny jail', 'resolved', 45, '2022-01-10', '20:21:47'),
(6, 'natu', 'a', 'uploads/service/service_1641822718_61dc39feacfb4-thumb.jpg', 'DIS WORKED!', 'unresolved', 45, '2022-01-10', '20:21:47'),
(8, 'Pls', 'Work', NULL, '', 'resolved', 45, '2022-01-15', '20:30:20'),
(9, 'Pls help me', 'I am stuck and cant get out', NULL, 'Sry there is no room zero.', 'open', 56, '2022-01-16', '13:30:17'),
(11, 'Need    oil', 'Please send oil. Need to find Sarah Connor', 'uploads/service/service_1642342822_61e429a6989ea-thumb.jpg', '', 'open', 57, '2022-01-16', '15:20:22'),
(12, 'Send oil now', 'Send oil now or I shall eXterminate youuuuuuuuuuuuuuuuuuuuuuuuu', 'uploads/service/service_1642342926_61e42a0e326cf-thumb.jpg', '', 'open', 57, '2022-01-16', '15:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pw_notiz` varchar(100) NOT NULL COMMENT 'Nur für PW merken zur Arbeit -> LÖSCHEN!',
  `password` varchar(255) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `anrede` enum('Herr','Frau','Non-Binary','NA') DEFAULT NULL,
  `vorname` varchar(50) DEFAULT NULL,
  `nachname` varchar(50) DEFAULT NULL,
  `room` int(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `role` enum('Admin','Service','Guest') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `pw_notiz`, `password`, `email`, `anrede`, `vorname`, `nachname`, `room`, `active`, `role`) VALUES
(45, 'admin', 'admin', '$2y$10$8XIqPtU88pFl0Tfs8FV7Q.thphC.QVI3FttvMBXSJPXJw5eUMsNLi', 'admin@admin.at', 'NA', 'Adminimus', 'Gottschalk', 1, 1, 'Admin'),
(46, 'service@biglyhotel.at', 'service123', '$2y$10$Q5f8T04mKPVTN8gCU0Ob4OzOmL9Zj6wIrQlxSogUMjM8dRGxQgnnS', 'service@biglyhotel.at', 'NA', 'Dilbert', 'Milbert', 0, 1, 'Service'),
(56, 'guest', 'guest123', '$2y$10$yxd9ZZw43HTipd9toBjqPertENK5CWl74Lq8m.Bl/kpaSrmVrDtDq', 'guest@biglyhotel.at', 'NA', 'Max', 'Mustermann', 0, 1, 'Guest'),
(57, 'DominosPizza', 'polo', '$2y$10$bnEFGBwVp8mFsl2GpLcpMOc3arusMNuUUYB5wMPlVgLG0sNLBGeCS', 'jonas@brothers.xd', 'Non-Binary', 'Donald', 'Schwarzenegger', 911, 0, 'Guest');

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
  MODIFY `news_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

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
