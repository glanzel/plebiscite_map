-- phpMyAdmin SQL Dump
-- version 5.0.0-rc1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 15. Okt 2020 um 18:15
-- Server-Version: 10.4.11-MariaDB-1:10.4.11+maria~bionic-log
-- PHP-Version: 7.3.14-5+ubuntu19.10.1+deb.sury.org+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `dwe`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `points`
--

CREATE TABLE `points` (
  `id` char(36) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Strasse` varchar(200) NOT NULL,
  `Nr` varchar(10) NOT NULL,
  `PLZ` int(5) NOT NULL,
  `Stadt` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Beschreibung` text DEFAULT NULL,
  `Laengengrad` double DEFAULT NULL,
  `Breitengrad` double DEFAULT NULL,
  `Kategorie` varchar(200) DEFAULT NULL,
  `Details` text DEFAULT NULL,
  `Details_intern` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stamm_orte`
--

CREATE TABLE `stamm_orte` (
  `id` int(11) NOT NULL,
  `bezirk` varchar(40) COLLATE utf8_bin NOT NULL,
  `ort` varchar(40) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Liste möglicher Orte für Temine';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `termindetails`
--

CREATE TABLE `termindetails` (
  `id` int(11) NOT NULL,
  `treffpunkt` text COLLATE utf8_bin DEFAULT NULL,
  `kommentar` longtext COLLATE utf8_bin DEFAULT NULL,
  `kontakt` text COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='naehere Infos zu Terminen';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `termine`
--

CREATE TABLE `termine` (
  `id` int(11) NOT NULL,
  `beginn` datetime DEFAULT NULL,
  `ende` datetime DEFAULT NULL,
  `ort` int(11) DEFAULT NULL,
  `typ` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `details` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` char(36) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_bin NOT NULL,
  `password` varchar(200) COLLATE utf8_bin NOT NULL,
  `token` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `verified` tinyint(4) DEFAULT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `stamm_orte`
--
ALTER TABLE `stamm_orte`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `termindetails`
--
ALTER TABLE `termindetails`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `termine`
--
ALTER TABLE `termine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Termine_Ort_fk` (`ort`),
  ADD KEY `Termine_TerminDetails_fk` (`details`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `stamm_orte`
--
ALTER TABLE `stamm_orte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `termindetails`
--
ALTER TABLE `termindetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `termine`
--
ALTER TABLE `termine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `termine`
--
ALTER TABLE `termine`
  ADD CONSTRAINT `Termine_Ort_fk` FOREIGN KEY (`ort`) REFERENCES `stamm_orte` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Termine_TerminDetails_fk` FOREIGN KEY (`details`) REFERENCES `termindetails` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

