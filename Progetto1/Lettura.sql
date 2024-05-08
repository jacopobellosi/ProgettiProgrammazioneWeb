-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 05, 2024 alle 17:43
-- Versione del server: 8.0.32
-- Versione PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_programmazionewebunibg`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Lettura`
--

CREATE TABLE `Lettura` (
  `Numero` int NOT NULL,
  `CodUtenza` varchar(25) NOT NULL,
  `Data` date NOT NULL,
  `Valore` int NOT NULL,
  `NumFattura` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Lettura`
--
ALTER TABLE `Lettura`
  ADD PRIMARY KEY (`Numero`,`CodUtenza`),
  ADD KEY `CodUtenza` (`CodUtenza`),
  ADD KEY `Numero` (`NumFattura`),
  ADD KEY `Numero_2` (`Numero`),
  ADD KEY `CodUtenza_2` (`CodUtenza`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
