-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Apr 29, 2024 alle 21:52
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
-- Struttura della tabella `Utenza`
--

CREATE TABLE `Utenza` (
  `Codice` varchar(25) NOT NULL,
  `DataAp` date NOT NULL,
  `Indirizzo` varchar(25) NOT NULL,
  `Città` varchar(25) NOT NULL,
  `CodCliente` varchar(25) NOT NULL,
  `Attiva` tinyint(1) NOT NULL,
  `DataCh` date DEFAULT NULL
) ;

--
-- Dump dei dati per la tabella `Utenza`
--

INSERT INTO `Utenza` (`Codice`, `DataAp`, `Indirizzo`, `Città`, `CodCliente`, `Attiva`, `DataCh`) VALUES
('UT01', '2024-01-01', 'Via Garibaldi 10', 'Milano', 'ABC12345', 1, NULL),
('UT02', '2024-02-01', 'Via Leonardo 20', 'Roma', 'DEF67890', 1, NULL),
('UT03', '2024-03-01', 'Via Marconi 27', 'San paolo', '2', 1, NULL);

--
-- Indici per le tabelle scaricate
--

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
