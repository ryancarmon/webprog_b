-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 31. Mai 2017 um 12:46
-- Server-Version: 10.1.13-MariaDB
-- PHP-Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `thwitter`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `likes`
--

CREATE TABLE `likes` (
  `User` int(11) NOT NULL,
  `Post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `likes`
--

INSERT INTO `likes` (`User`, `Post`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE `posts` (
  `ID` int(11) NOT NULL,
  `User` int(11) NOT NULL,
  `Timestamp` int(20) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`ID`, `User`, `Timestamp`, `Text`) VALUES
(1, 1, 1496227139, 'Lorem ipsum dolor sit amet&comma; consetetur sadipscing elitr&comma; sed diam nonumy eirmod tempor invidunt ut labore et dolore magna git gud erat&comma; sed diam voluptua&period; At vero eos et accusam e'),
(2, 2, 1496227192, 'Ich bin nur ein Beispiel'),
(3, 2, 1496227200, 'Ich putze hier nur');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(128) NOT NULL,
  `Mail` varchar(200) NOT NULL,
  `Image` varchar(100) NOT NULL DEFAULT 'logo.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`, `Mail`, `Image`) VALUES
(1, 'Bla', 'f38cfe2e2facbcc742bad63f91ad55637300cb45', 'abc', 'logo.jpg'),
(2, 'Testuser', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'mail@test.de', 'logo.jpg');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`User`,`Post`),
  ADD KEY `FK_LikesPost` (`Post`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_PostsUser` (`User`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `FK_LikesPost` FOREIGN KEY (`Post`) REFERENCES `posts` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_LikesUser` FOREIGN KEY (`User`) REFERENCES `users` (`ID`);

--
-- Constraints der Tabelle `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_PostsUser` FOREIGN KEY (`User`) REFERENCES `users` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
