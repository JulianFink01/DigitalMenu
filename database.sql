-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: sql7.freemysqlhosting.net
-- Erstellungszeit: 17. Aug 2020 um 07:23
-- Server-Version: 5.5.62-0ubuntu0.14.04.1
-- PHP-Version: 7.0.33-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `sql7360320`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `name_it` text,
  `description_it` text,
  `subkategorie` int(11) DEFAULT NULL,
  `icon` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `kategorie`
--

INSERT INTO `kategorie` (`id`, `name`, `description`, `name_it`, `description_it`, `subkategorie`, `icon`) VALUES
(22, 'Weine', 'Viel WEin, das muss sein', NULL, NULL, NULL, 'IMG_9917.jpg'),
(26, 'Weine2', 'Weine 2 > Weine 1', NULL, NULL, 22, 'IMG_9878.jpg'),
(28, 'jf', 'hfhfghfgh', NULL, NULL, 22, 'schlern.png'),
(29, 'Bier', 'hallo', NULL, NULL, NULL, '_FNK3274.JPG'),
(30, 'essen', 'bes', NULL, NULL, NULL, '15254.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `produkt`
--

CREATE TABLE `produkt` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `name_it` text,
  `description` text,
  `description_it` text,
  `price` float DEFAULT NULL,
  `kategorie` int(11) DEFAULT NULL,
  `zutaten` text,
  `zutaten_it` text,
  `hersteller` text,
  `status` tinyint(1) DEFAULT NULL,
  `icon` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `produkt`
--

INSERT INTO `produkt` (`id`, `name`, `name_it`, `description`, `description_it`, `price`, `kategorie`, `zutaten`, `zutaten_it`, `hersteller`, `status`, `icon`) VALUES
(7, 'Kategorie eins', NULL, 'das ist die erste kategorie', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'IMG_9906.jpg'),
(8, 'Kategorie1', NULL, 'Beschreibung von test 1', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'IMG_9906.jpg'),
(9, 'Weine', NULL, 'weine sind gut aber weed besser', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'IMG_9917.jpg'),
(10, 'Bier', NULL, 'Trink Bier hier', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'IMG_9906.jpg'),
(14, 'test icon', NULL, 'test icon', NULL, 334, 26, 'vieles', NULL, NULL, 1, 'bild2.png'),
(15, 'eeee', NULL, 'eee', NULL, 420, 26, 'eee', NULL, NULL, 1, 'INF4-12-5.png'),
(16, 'no', NULL, 'no', NULL, 322, 26, 'no', NULL, NULL, 1, '15254.png');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subkategorie` (`subkategorie`);

--
-- Indizes für die Tabelle `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategorie` (`kategorie`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT für Tabelle `produkt`
--
ALTER TABLE `produkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  ADD CONSTRAINT `kategorie_ibfk_1` FOREIGN KEY (`subkategorie`) REFERENCES `kategorie` (`id`),
  ADD CONSTRAINT `kategorie_ibfk_2` FOREIGN KEY (`subkategorie`) REFERENCES `kategorie` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `produkt`
--
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt_ibfk_1` FOREIGN KEY (`kategorie`) REFERENCES `kategorie` (`id`),
  ADD CONSTRAINT `produkt_ibfk_2` FOREIGN KEY (`kategorie`) REFERENCES `kategorie` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
