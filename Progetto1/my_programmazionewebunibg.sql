-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Apr 29, 2024 alle 10:17
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

-- --------------------------------------------------------

--
-- Struttura della tabella `Fattura`
--

CREATE TABLE `Fattura` (
  `Numero` int NOT NULL,
  `Data` date NOT NULL,
  `Imponibile` int NOT NULL,
  `Iva` int NOT NULL,
  `Totale` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

-- --------------------------------------------------------

--
-- Struttura della tabella `Utenza`
--

CREATE TABLE `Utenza` (
  `Codice` varchar(25) NOT NULL,
  `DataAp` date NOT NULL,
  `Indirizzo` varchar(25) NOT NULL,
  `Città` varchar(25) NOT NULL,
  `CodCliente` varchar(25) NOT NULL,
  `Attiva` tinyint(1) NOT NULL,
  `DataCh` date NOT NULL
) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`Codice`);

--
-- Indici per le tabelle `Fattura`
--
ALTER TABLE `Fattura`
  ADD PRIMARY KEY (`Numero`);

--
-- Indici per le tabelle `Lettura`
--
ALTER TABLE `Lettura`
  ADD PRIMARY KEY (`Numero`,`CodUtenza`),
  ADD KEY `CodUtenza` (`CodUtenza`),
  ADD KEY `Numero` (`NumFattura`);

--
-- Indici per le tabelle `Utenza`
--
ALTER TABLE `Utenza`
  ADD PRIMARY KEY (`Codice`),
  ADD KEY `fk_cliente` (`CodCliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
