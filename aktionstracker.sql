-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 185.61.137.168:3306
-- Erstellungszeit: 19. Apr 2021 um 02:01
-- Server-Version: 10.3.25-MariaDB-0ubuntu0.20.04.1
-- PHP-Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `npeproau_aktionstracker`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `actions`
--

INSERT INTO `actions` (`id`, `name`, `points`) VALUES
(1, 'Pacific Bank', 4),
(2, 'Fleeca Bank', 3),
(3, 'Ammunation Raub', 2),
(4, 'Waffentruck', 2),
(5, 'Asservatentruck', 5),
(6, 'Drogentruck', 1),
(7, 'FIB Raub', 4),
(8, 'Gangshop auffuellen', 1),
(9, 'Gangshop attacken', 1),
(10, 'Gangshop deffen', 1),
(11, 'Gangwar attacken', 1),
(12, 'Gangwar deffen', 2),
(13, 'Abgestuerzter Heli', 1),
(14, 'Humane Labs Raub', 5),
(15, 'Kronzeuge', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buys`
--

CREATE TABLE `buys` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `finished_actions`
--

CREATE TABLE `finished_actions` (
  `id` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `lobby` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `creator` int(11) NOT NULL,
  `lobbyItem` varchar(255) NOT NULL DEFAULT 'NONE',
  `lobbyCash` int(11) NOT NULL DEFAULT 0,
  `member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `lobby` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lobbys`
--

CREATE TABLE `lobbys` (
  `id` int(11) NOT NULL,
  `action` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creator` int(11) NOT NULL,
  `item` varchar(255) NOT NULL DEFAULT 'NONE',
  `cash` int(11) NOT NULL DEFAULT 0,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lobby_member`
--

CREATE TABLE `lobby_member` (
  `id` int(11) NOT NULL,
  `lobby` int(11) NOT NULL,
  `member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sells`
--

CREATE TABLE `sells` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `statistics`
--

CREATE TABLE `statistics` (
  `uid` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `Pacific_Bank` int(11) NOT NULL DEFAULT 0,
  `Fleeca_Bank` int(11) NOT NULL DEFAULT 0,
  `Ammunation_Raub` int(11) NOT NULL DEFAULT 0,
  `Waffentruck` int(11) NOT NULL DEFAULT 0,
  `Asservatentruck` int(11) NOT NULL DEFAULT 0,
  `Drogentruck` int(11) NOT NULL DEFAULT 0,
  `FIB_Raub` int(11) NOT NULL DEFAULT 0,
  `Gangshop_auffuellen` int(11) NOT NULL DEFAULT 0,
  `Gangshop_attacken` int(11) NOT NULL DEFAULT 0,
  `Gangshop_deffen` int(11) NOT NULL DEFAULT 0,
  `Gangwar_attacken` int(11) NOT NULL DEFAULT 0,
  `Gangwar_deffen` int(11) NOT NULL DEFAULT 0,
  `Abgestuerzter_Heli` int(11) NOT NULL DEFAULT 0,
  `Humane_Labs_Raub` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `storageItems`
--

CREATE TABLE `storageItems` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `storageItems`
--

INSERT INTO `storageItems` (`id`, `name`) VALUES
(1, 'Waehle ein Item...'),
(2, 'Haftbombe'),
(3, 'Aceton'),
(4, 'Benzol'),
(5, '40%iges Methylamin'),
(6, 'Phenylaceton'),
(7, 'Methamphetamin'),
(8, 'Schokoriegel'),
(9, 'Metallteile'),
(10, 'Benzinkanister'),
(11, 'Repairkit'),
(12, 'Spitzhacke'),
(13, 'Presslufthammer'),
(14, 'Eisenerz'),
(15, 'Golderz'),
(16, 'Kaliumnitrat'),
(17, 'Medikit'),
(18, 'Schwarzpulver'),
(19, 'Hanf'),
(20, 'Hanfsteckling'),
(21, 'Angelrute'),
(22, 'Angelhaken'),
(23, 'Fischernetz'),
(24, 'Holzkiste'),
(25, 'Forelle'),
(26, 'A Munition'),
(27, 'B Munition'),
(28, 'D Munition'),
(29, 'F Munition'),
(30, 'Muschel'),
(31, 'Geld'),
(32, 'Kuerbis'),
(33, 'Brechstange'),
(34, 'Perle'),
(35, 'Kartoffel'),
(36, 'Zwiebel'),
(37, 'Karotte'),
(38, 'Karotte'),
(39, 'Salat'),
(40, 'Gurke'),
(41, 'Weizen'),
(42, 'Duenger'),
(43, 'Eier'),
(44, 'Fleisch'),
(45, 'Milch'),
(46, 'Schutzweste'),
(47, 'Weihnachtslos');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userdata`
--

CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `rank` int(11) NOT NULL DEFAULT 0,
  `isEligible` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `buys`
--
ALTER TABLE `buys`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `finished_actions`
--
ALTER TABLE `finished_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `lobbys`
--
ALTER TABLE `lobbys`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `lobby_member`
--
ALTER TABLE `lobby_member`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `sells`
--
ALTER TABLE `sells`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`uid`);

--
-- Indizes für die Tabelle `storageItems`
--
ALTER TABLE `storageItems`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT für Tabelle `buys`
--
ALTER TABLE `buys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `finished_actions`
--
ALTER TABLE `finished_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `lobbys`
--
ALTER TABLE `lobbys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `lobby_member`
--
ALTER TABLE `lobby_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `sells`
--
ALTER TABLE `sells`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `storageItems`
--
ALTER TABLE `storageItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT für Tabelle `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
