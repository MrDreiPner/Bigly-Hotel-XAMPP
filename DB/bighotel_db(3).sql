-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2022 at 07:25 PM
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
('Join us on our Bigliest Opening Day!\r\nWe are excited to invite you to an evening full of entertainment, food and drinks!...\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.   \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet,', 'Bigly Hotel Opening!', '../uploads/news/BiglyOpening_61e83e4c0c825-thumb.jpg', '2022-01-01', '17:37:32', 1, 60),
('Have a sneak peek at our new rooms!', 'New Special Rooms!', '../uploads/news/sneekyRoom_61e83e7c7d444-thumb.jpg', '2022-01-07', '13:22:12', 1, 61),
('HURRAY!\r\nFinally our doors are open to all our visitors!\r\nRejoice!\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.   \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet,', '3... 2... 1... WE ARE OPEN!', '../uploads/news/HereWeGo_61e83ead297c8-thumb.jpg', '2022-01-09', '14:22:09', 1, 62),
('Every guest has the BIGLY chance to win a weekend at this fancy castle!', 'Collaboration in Medieval fashion', '../uploads/news/BiglyCastle_61e83eec32111-thumb.jpg', '2022-01-16', '10:24:37', 1, 63),
('Get a sniff and a whiff out here!\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.   \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet,', 'Refreshing BIGLY outdoor Event', NULL, '2022-01-17', '09:04:09', 0, 64),
('We are happy to announce another collab with our partners in Cold Country!', 'Now this is different...', '../uploads/news/coldPlace_61e83f834c93d-thumb.jpg', '2022-01-19', '17:42:43', 1, 65);

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
(24, 'Bugs in my BED!', 'How can this happen in the BIGLIEST hotel?!?!', '../uploads/service/bug.png_61e848025ea15-thumb.png', '', 'open', 63, '2022-01-19', '18:18:58'),
(25, 'Shower busted!', 'Not only are there bugs... also my shower is broken!', '../uploads/service/Glass_164669_02.jpg_61e84864f3f29-thumb.jpg', 'Damn. On our way. Also please explain how.', 'resolved', 63, '2022-01-19', '18:20:37'),
(26, 'Where is Waldo?', 'No really... where is he?', '../uploads/service/2_Waldo_Illustration.png_61e848fde8a6a-thumb.png', '', 'open', 66, '2022-01-19', '18:23:10'),
(27, 'Credentials WRONG!', 'Name and email are wrong! How can I fix ?!', NULL, '', 'open', 66, '2022-01-19', '18:26:43'),
(28, 'TEST!', 'Testing!', NULL, 'Test worked. Have a nice day.', 'resolved', 66, '2022-01-19', '18:26:59'),
(29, 'Please fix the pipe', 'The pipe has been leaking for days now. Please someone fix it. Thank you &lt;3', '../uploads/service/LeakyPipe.jpg_61e84a49d9dc7-thumb.jpg', '', 'open', 45, '2022-01-19', '18:28:41'),
(30, 'Where did Marko go?', 'We haven&#039;t seen Marko in 5 hours. Pleae report when he is back.', NULL, 'He left the company.', 'resolved', 45, '2022-01-19', '18:43:09'),
(31, 'Why does the page change when I post?', 'How is this possible? I want explanations!', NULL, 'I am not a dev.', 'unresolved', 45, '2022-01-19', '18:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `anrede` enum('Male','Female','Non-Binary','NA') DEFAULT NULL,
  `vorname` varchar(50) DEFAULT NULL,
  `nachname` varchar(50) DEFAULT NULL,
  `room` int(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `role` enum('Admin','Service','Guest') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `email`, `anrede`, `vorname`, `nachname`, `room`, `active`, `role`) VALUES
(45, 'admin', '$2y$10$8XIqPtU88pFl0Tfs8FV7Q.thphC.QVI3FttvMBXSJPXJw5eUMsNLi', 'admin@admin.at', 'NA', 'Adminimus', 'Gottschalk', 1, 1, 'Admin'),
(46, 'service', '$2y$10$Q5f8T04mKPVTN8gCU0Ob4OzOmL9Zj6wIrQlxSogUMjM8dRGxQgnnS', 'service@biglyhotel.at', 'NA', 'Dilbert', 'Milbert', 0, 1, 'Service'),
(56, 'guest', '$2y$10$yxd9ZZw43HTipd9toBjqPertENK5CWl74Lq8m.Bl/kpaSrmVrDtDq', 'guest@biglyhotel.at', 'Male', 'Max', 'Mustermann', 101, 1, 'Guest'),
(60, 'service1@biglyhotel.at', '$2y$10$tdQfpVSfQJfhZ469TUxo7..g3zDc0OQm4JKkun1VCY/iv0M8cjI9O', 'service1@biglyhotel.at', 'NA', 'Service', 'Person', 0, 0, 'Service'),
(61, 'service2@biglyhotel.at', '$2y$10$MXwlKLxzIKJLFmh4MP/9YOBfAyGjRpz0Zj32CMKaDl2dw/7jcrh1i', 'service2@biglyhotel.at', 'NA', 'Service', 'Person', 0, 1, 'Service'),
(62, 'MarlieMusterfrau', '$2y$10$L.mEm.MUmi8p6p5f./Ea3e4kLGdkpJy68ndral6iL8uGYYOXr6d2W', 'guest2@web.at', 'Female', 'Marlies', 'Musterfrau', 153, 0, 'Guest'),
(63, 'RonnDonn', '$2y$10$V1M6ak6KruImSlZ4kjznsem00HFp.Llje36.TUREa2XY.QOf.h4vO', 'guest1@web.at', 'Female', 'Donnie', 'Ronnie', 23, 1, 'Guest'),
(65, 'SmartestDerek', '$2y$10$mj1lM5O5VrzpxPnYB9F2CODDAg1KedLCsWJHuXX3XtP53tEA4WOl6', 'guest2@biglyhotel.at', 'Male', 'Derek', 'Smart', 90, 0, 'Guest'),
(66, 'guest3@web.at', '$2y$10$0u8xDQWp3UavWmg/Acdx8urD4NmrUTIPJA3SD5nqdFTVXwpPx1Azu', 'guest3@web.at', 'Non-Binary', 'Loius', 'Treis', 102, 1, 'Guest');

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
  MODIFY `news_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
