-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Dez 2021 um 13:40
-- Server-Version: 10.4.22-MariaDB
-- PHP-Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bighotel_db`
--
CREATE DATABASE IF NOT EXISTS `bighotel_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bighotel_db`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
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
-- Tabellenstruktur für Tabelle `tickets`
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
-- Tabellenstruktur für Tabelle `user`
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
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`username`, `pw_notiz`, `password`, `email`, `anrede`, `vorname`, `nachname`, `room`, `userID`, `active`, `role`) VALUES
('admin', 'admin', '$2y$10$z0mpART0vg14vQuCndUKI.ZNhM7UbYX8GVVM/jKQvx3NFZjvd38F6', 'admin@admin.at', 'NA', '', '', 0, 45, 1, 'Admin'),
('service@biglyhotel.at', 'service123', '$2y$10$Q5f8T04mKPVTN8gCU0Ob4OzOmL9Zj6wIrQlxSogUMjM8dRGxQgnnS', 'service@biglyhotel.at', 'NA', '', '', 0, 46, 1, 'Service'),
('marko@polo.xd', 'mario123', '$2y$10$e8iRj7IOxXl5Q4yVDPQ6he1X5MXzrAWQgIqbhZHXJKwoG0C0MRy/2', 'marko@polo.xd', 'Herr', 'Marko', 'Polo', 69, 49, 1, 'Guest'),
('elektriker@biglyhotel.at', 'service321', '$2y$10$DT7PEdiJinCC5cgvVZyrx.Ks444ELKtZcbIYY/QqiaOXUAkkP2WiO', 'elektriker@biglyhotel.at', 'NA', '', '', 0, 50, 1, 'Service'),
('reception@biglyhotel.at', 'verysavepasswordamk123', '$2y$10$zoTsE6qCFwUxuVKF1fbUnO6wAM59cXYflCk60L5pwgvk7vBvDNOOq', 'reception@biglyhotel.at', 'NA', '', '', 0, 51, 1, 'Admin'),
('pat@rat.gat', 'BeeBoo!', '$2y$10$o3DCGdBMgDO9DrFlhAiR6.s1wYwTGCVCPGr2G7QmuriWS.yTsdgRO', 'pat@rat.gat', 'NA', 'Pat', 'Rick', 231, 52, 1, 'Service'),
('tom@gott.de', 'qwert213:&quot;break;&quot;', '$2y$10$mmcJWJ3HHClTz6Wilo6j4O5Z/5eG4mGzoWLXJeFOtKIIpVNBwKWnG', 'tom@gott.de', 'Non-Binary', 'Thomas', 'Gottschalk', 321, 53, 1, 'Guest'),
('gfgf@gmail.com', 'Pcela1', '$2y$10$JDzRM8DlD.7q8sVU3ew.P.3am1vWZdEBe3H51VLAWRlNCQskKUeuq', 'gfgf@gmail.com', 'Frau', 'Andrea', 'Topalovic', 5, 54, 1, 'Guest');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indizes für die Tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticketID`),
  ADD KEY `userID` (`userID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`) USING BTREE;

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
