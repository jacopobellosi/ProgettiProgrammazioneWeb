-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Apr 29, 2024 alle 21:53
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
-- Struttura della tabella `Cliente`
--

CREATE TABLE `Cliente` (
  `Codice` int NOT NULL,
  `CF` varchar(255) NOT NULL,
  `RagSoc` varchar(255) NOT NULL,
  `Indirizzo` varchar(255) NOT NULL,
  `Citta` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `Cliente`
--

INSERT INTO `Cliente` (`Codice`, `CF`, `RagSoc`, `Indirizzo`, `Citta`) VALUES
(1, 'ABC12345', 'Cliente1 Srl', 'Via Roma 1', 'Milano'),
(2, 'DEF67890', 'Cliente2 Spa', 'Via Verdi 2', 'Roma'),
(3, 'GHI54321', 'Cliente3 Snc', 'Corso Italia 3', 'Napoli'),
(4, 'JKL98765', 'Cliente4 Sas', 'Via Dante 4', 'Firenze'),
(5, 'MNO54321', 'Cliente5 Srl', 'Piazza Garibaldi 5', 'Torino');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`Codice`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
