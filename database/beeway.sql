-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 17 mei 2023 om 08:52
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beeway`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `beeway`
--

CREATE TABLE `beeway` (
  `beewayid` int(11) NOT NULL,
  `schoolid` int(11) NOT NULL,
  `groupid` varchar(11) NOT NULL,
  `beewayname` varchar(155) NOT NULL,
  `begood` varchar(3) DEFAULT NULL,
  `beenough` varchar(3) DEFAULT NULL,
  `benotgood` varchar(3) DEFAULT NULL,
  `mainthemeid` varchar(11) NOT NULL,
  `disciplineid` varchar(11) NOT NULL,
  `concretegoal` varchar(2500) DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) DEFAULT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) DEFAULT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `beeway`
--

INSERT INTO `beeway` (`beewayid`, `schoolid`, `groupid`, `beewayname`, `begood`, `beenough`, `benotgood`, `mainthemeid`, `disciplineid`, `concretegoal`, `status`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(1, 1, '1', 'eerste beeway', '0', '12', '45', '1', '1', 'beeway doel, leuk he', '0', '2023-05-03 08:15:03', 1, '2023-05-03 08:15:03', 1, 0, NULL, NULL),
(2, 1, '2', 'tweede beeway', '67', '12', '45', '2', '2', 'beeway doel, leuk he', '0', '2023-05-03 08:15:42', 1, '2023-05-03 08:15:42', 1, 0, NULL, NULL),
(3, 2, '1', 'derde beeway', '23', '567', '23', '2', '2', 'beeway doel, stom he', '0', '2023-05-03 08:16:14', 1, '2023-05-03 08:16:14', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `beewayobservation`
--

CREATE TABLE `beewayobservation` (
  `observationid` int(11) NOT NULL,
  `beewayid` int(11) NOT NULL,
  `dataclass` varchar(2500) DEFAULT NULL,
  `learninggoal` varchar(2500) DEFAULT NULL,
  `evaluation` varchar(2500) DEFAULT NULL,
  `workgoal` varchar(2500) DEFAULT NULL,
  `action` varchar(2500) DEFAULT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `beewayplanning`
--

CREATE TABLE `beewayplanning` (
  `planningid` int(11) NOT NULL,
  `beewayid` varchar(11) NOT NULL,
  `planning` varchar(155) DEFAULT NULL,
  `planningwhat` varchar(2500) DEFAULT NULL,
  `planningwho` varchar(2500) DEFAULT NULL,
  `planningdeadline` datetime DEFAULT NULL,
  `planningdone` varchar(4) DEFAULT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) DEFAULT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) DEFAULT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `disciplines`
--

CREATE TABLE `disciplines` (
  `disciplineid` int(11) NOT NULL,
  `disciplinename` varchar(55) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `disciplines`
--

INSERT INTO `disciplines` (`disciplineid`, `disciplinename`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(1, 'rekenen', '2023-05-03 08:16:59', 1, '2023-05-03 08:16:59', 1, 0, NULL, NULL),
(2, 'lezen', '2023-05-03 08:17:16', 1, '2023-05-03 08:17:16', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groups`
--

CREATE TABLE `groups` (
  `groupid` int(11) NOT NULL,
  `groups` varchar(3) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `groups`
--

INSERT INTO `groups` (`groupid`, `groups`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(1, '2', '2023-05-03 08:18:01', 1, '2023-05-03 08:18:01', 1, 0, NULL, NULL),
(2, '6', '2023-05-03 08:18:09', 1, '2023-05-03 08:18:09', 1, 0, NULL, NULL),
(3, '3', '2023-05-09 13:54:26', 0, '2023-05-09 13:54:26', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `linkgroups`
--

CREATE TABLE `linkgroups` (
  `linkgroupsid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `linkgroups`
--

INSERT INTO `linkgroups` (`linkgroupsid`, `userid`, `groupid`, `archive`) VALUES
(1, 3, 1, 1),
(2, 3, 2, 1),
(4, 21, 1, 0),
(5, 21, 2, 0),
(6, 26, 2, 0),
(7, 27, 1, 0),
(8, 27, 3, 0),
(9, 24, 1, 1),
(10, 24, 2, 1),
(11, 24, 2, 0),
(12, 29, 2, 0),
(13, 30, 3, 1),
(14, 30, 3, 0),
(15, 33, 1, 1),
(16, 33, 2, 1),
(17, 33, 3, 1),
(18, 33, 1, 0),
(19, 33, 3, 0),
(20, 3, 1, 0),
(21, 3, 2, 0),
(22, 42, 2, 1),
(23, 42, 2, 0),
(24, 44, 2, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `userid` varchar(11) NOT NULL,
  `useragent` varchar(255) NOT NULL,
  `action` tinyint(1) NOT NULL COMMENT '0=select\r\n1=insert\r\n2=update\r\n3=delete\r\n4=login\r\n5=logout',
  `tableid` tinyint(4) NOT NULL COMMENT '1=beeway\r\n2=disciplines\r\n3=groups\r\n4=maintheme\r\n5=schools\r\n6=users',
  `interactionid` int(11) NOT NULL,
  `error` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=no error\r\n1=error'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `logs`
--

INSERT INTO `logs` (`id`, `date`, `userid`, `useragent`, `action`, `tableid`, `interactionid`, `error`) VALUES
(49, '2023-05-09 06:16:40', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(50, '2023-05-09 07:03:15', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 24, 0),
(51, '2023-05-09 12:02:21', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 26, 0),
(52, '2023-05-09 12:06:52', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(53, '2023-05-09 12:08:05', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(54, '2023-05-09 12:11:31', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(55, '2023-05-09 12:12:49', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(56, '2023-05-09 12:12:55', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(57, '2023-05-09 12:21:49', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 27, 0),
(58, '2023-05-09 14:08:54', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 24, 0),
(59, '2023-05-09 14:09:21', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 24, 0),
(60, '2023-05-09 14:09:29', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 24, 0),
(61, '2023-05-09 14:11:45', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 24, 0),
(62, '2023-05-09 14:12:36', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 24, 0),
(63, '2023-05-09 14:13:27', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 24, 0),
(64, '2023-05-10 06:17:55', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(65, '2023-05-10 11:44:37', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(66, '2023-05-10 12:13:13', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(67, '2023-05-10 12:13:47', '3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 3, 0),
(68, '2023-05-10 12:14:01', '3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 3, 0),
(69, '2023-05-10 12:14:09', '3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 3, 0),
(70, '2023-05-10 12:16:23', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(71, '2023-05-10 12:16:34', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(72, '2023-05-10 12:25:33', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(73, '2023-05-10 12:34:34', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(74, '2023-05-10 12:34:40', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(75, '2023-05-10 13:45:35', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(76, '2023-05-10 13:45:44', '28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 28, 0),
(77, '2023-05-10 13:45:50', '28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 28, 0),
(78, '2023-05-10 13:45:54', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(79, '2023-05-10 13:59:35', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 29, 0),
(80, '2023-05-10 14:01:32', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 30, 0),
(81, '2023-05-10 14:01:40', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 30, 0),
(82, '2023-05-10 14:06:56', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 31, 0),
(83, '2023-05-10 14:13:28', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 32, 0),
(84, '2023-05-10 14:14:24', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 33, 0),
(85, '2023-05-10 14:14:38', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 33, 0),
(86, '2023-05-11 06:07:37', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(87, '2023-05-11 06:29:04', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(88, '2023-05-11 06:31:44', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(89, '2023-05-11 06:32:05', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(90, '2023-05-11 06:32:32', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(91, '2023-05-11 06:34:36', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(92, '2023-05-11 06:34:45', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(93, '2023-05-11 06:35:00', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(94, '2023-05-11 06:35:10', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(95, '2023-05-11 06:35:15', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(96, '2023-05-11 06:35:48', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(97, '2023-05-11 06:36:01', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(98, '2023-05-11 06:37:05', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(99, '2023-05-11 06:51:10', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 34, 0),
(100, '2023-05-11 06:51:55', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 35, 0),
(101, '2023-05-11 06:52:42', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 36, 0),
(102, '2023-05-11 10:49:47', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(103, '2023-05-12 06:05:14', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(104, '2023-05-12 06:46:48', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(105, '2023-05-12 07:02:23', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 5, 5, 0),
(106, '2023-05-12 07:02:39', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 5, 5, 0),
(107, '2023-05-12 07:02:48', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 5, 5, 0),
(108, '2023-05-12 07:03:31', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 7, 0),
(109, '2023-05-12 07:03:31', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 37, 0),
(111, '2023-05-12 07:06:01', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 9, 0),
(112, '2023-05-12 07:06:46', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 10, 0),
(113, '2023-05-12 07:06:54', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 11, 0),
(114, '2023-05-12 07:06:54', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 38, 0),
(115, '2023-05-12 07:08:19', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 12, 0),
(116, '2023-05-12 07:08:59', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 13, 0),
(117, '2023-05-12 07:08:59', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 39, 0),
(118, '2023-05-12 07:10:00', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 14, 0),
(119, '2023-05-12 07:10:00', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 40, 0),
(120, '2023-05-12 07:10:10', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 15, 0),
(121, '2023-05-12 07:11:29', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 16, 0),
(122, '2023-05-12 07:11:29', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 41, 0),
(123, '2023-05-12 07:11:42', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 17, 0),
(124, '2023-05-12 07:22:09', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 3, 0),
(125, '2023-05-12 07:25:51', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 42, 0),
(126, '2023-05-12 07:44:55', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 2, 6, 42, 0),
(127, '2023-05-15 06:37:05', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(128, '2023-05-15 07:51:34', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 3, 6, 42, 0),
(129, '2023-05-15 09:24:39', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 5, 18, 0),
(130, '2023-05-15 09:24:39', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 43, 0),
(131, '2023-05-15 09:28:05', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 3, 6, 0, 0),
(132, '2023-05-15 10:08:21', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 1, 6, 44, 0),
(133, '2023-05-15 10:08:28', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 3, 6, 44, 0),
(134, '2023-05-15 10:10:58', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 3, 6, 44, 0),
(135, '2023-05-15 12:04:42', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(136, '2023-05-15 12:04:49', '3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 3, 0),
(137, '2023-05-15 12:04:54', '3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 3, 0),
(138, '2023-05-15 12:04:56', '3', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 3, 0),
(139, '2023-05-15 12:05:07', '2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 2, 0),
(140, '2023-05-15 12:43:15', '2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 2, 0),
(141, '2023-05-15 12:43:25', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(142, '2023-05-15 12:49:52', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 5, 6, 1, 0),
(143, '2023-05-15 12:50:07', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36', 4, 6, 1, 0),
(144, '2023-05-16 06:06:12', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 4, 6, 1, 0),
(145, '2023-05-16 06:38:55', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 5, 6, 1, 0),
(146, '2023-05-16 06:39:03', '2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 4, 6, 2, 0),
(147, '2023-05-16 13:40:27', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 4, 6, 1, 0),
(148, '2023-05-17 06:01:55', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 4, 6, 1, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `maintheme`
--

CREATE TABLE `maintheme` (
  `themeid` int(11) NOT NULL,
  `schoolid` varchar(11) NOT NULL,
  `namethemep1` varchar(55) NOT NULL,
  `namethemep2` varchar(55) NOT NULL,
  `namethemep3` varchar(55) NOT NULL,
  `namethemep4` varchar(55) NOT NULL,
  `namethemep5` varchar(55) NOT NULL,
  `schoolyear` varchar(10) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `maintheme`
--

INSERT INTO `maintheme` (`themeid`, `schoolid`, `namethemep1`, `namethemep2`, `namethemep3`, `namethemep4`, `namethemep5`, `schoolyear`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(1, '1', 'test thema 1', 'naam p2', 'naam p3', 'naam p4', 'naam p5', '1', '2023-05-03 08:19:06', 1, '2023-05-03 08:19:06', 1, 0, NULL, NULL),
(2, '1', 'test thema 2', 'naam p2', 'naam p3', 'naam p4', 'naam p5', '1', '2023-05-03 08:19:14', 1, '2023-05-03 08:19:14', 1, 0, NULL, NULL),
(3, '2', 'test thema 3', 'naam p2', 'naam p3', 'naam p4', 'naam p5', '1', '2023-05-03 08:19:14', 1, '2023-05-03 08:19:14', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `schools`
--

CREATE TABLE `schools` (
  `schoolid` int(11) NOT NULL,
  `schoolname` varchar(155) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `schools`
--

INSERT INTO `schools` (`schoolid`, `schoolname`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(0, '', '2023-05-03 08:19:39', 1, '2023-05-03 08:19:39', 1, 0, NULL, NULL),
(1, 'mijnschool', '2023-05-03 08:19:49', 1, '2023-05-03 08:19:49', 1, 0, NULL, NULL),
(2, 'nietmijnschool', '2023-05-03 16:06:18', 1, '2023-05-03 16:06:18', 1, 0, NULL, NULL),
(18, 'test', '2023-05-15 11:24:39', 1, '2023-05-15 11:24:39', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `schoolid` int(11) DEFAULT NULL,
  `firstname` varchar(55) NOT NULL,
  `lastname` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp(),
  `createdby` int(11) NOT NULL,
  `updatedat` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedby` int(11) NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT 0,
  `deletedat` datetime DEFAULT NULL,
  `deletedby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`userid`, `schoolid`, `firstname`, `lastname`, `email`, `password`, `role`, `createdat`, `createdby`, `updatedat`, `updatedby`, `archive`, `deletedat`, `deletedby`) VALUES
(0, 0, 'system', '', '', '', 3, '2023-05-09 09:29:55', 0, '2023-05-09 09:29:55', 0, 1, '2023-05-15 11:28:05', 1),
(1, 0, 'superuser', 'test', 'test@test.nl', '$2y$10$PEIaTvE2w3VJw/t9iagKSu8tL1eUiGjYJqtkQ8snMoOWvW1lin6Lu', 2, '2023-05-03 08:20:53', 1, '2023-05-03 08:20:53', 1, 0, NULL, NULL),
(2, 1, 'school admin', 'test', 'een@test.nl', '$2y$10$PEIaTvE2w3VJw/t9iagKSu8tL1eUiGjYJqtkQ8snMoOWvW1lin6Lu', 1, '2023-05-03 08:21:20', 1, '2023-05-03 08:21:20', 1, 0, NULL, NULL),
(3, 1, 'school docent', 'test', 'twee@test.nl', '$2y$10$6tu2bFF0P/PtwzJWNMTC2e8VxJdleCTpvNZ5a3Nx5.9HKO5f0Jfgm', 1, '2023-05-10 16:14:24', 1, '2023-05-10 16:14:24', 1, 0, NULL, NULL),
(42, 2, 'delete user', 'test 2', 'asdf@asdf', '$2y$10$.4VBe1364rgYjD/fvSSqY.64SD4HP0H6bUgfsWz0HKDusI0PwbM9y', 1, '2023-05-12 09:25:51', 1, '2023-05-12 09:25:51', 1, 1, '2023-05-15 09:51:34', 1),
(43, 18, 'schooladmin', 'one', 'test', '$2y$10$PBm3hWlzKW7./VtKbUxcXOxrR/vnhtTaf2HwmwLeEH2zTOmhL.K9K', 1, '2023-05-15 11:24:39', 1, '2023-05-15 11:24:39', 1, 0, NULL, NULL),
(44, 1, 'sdf', 'sdfsdf', 'drie@test.nl', '$2y$10$YUgM9m45UsTyyYUrB41hGeuoUK9UC8Ww9JSaAZlhewB3sGwwDAB0u', 1, '2023-05-15 12:08:21', 1, '2023-05-15 12:08:21', 1, 1, '2023-05-15 12:10:58', 1);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `beeway`
--
ALTER TABLE `beeway`
  ADD PRIMARY KEY (`beewayid`);

--
-- Indexen voor tabel `beewayobservation`
--
ALTER TABLE `beewayobservation`
  ADD PRIMARY KEY (`observationid`);

--
-- Indexen voor tabel `beewayplanning`
--
ALTER TABLE `beewayplanning`
  ADD PRIMARY KEY (`planningid`);

--
-- Indexen voor tabel `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`disciplineid`);

--
-- Indexen voor tabel `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupid`);

--
-- Indexen voor tabel `linkgroups`
--
ALTER TABLE `linkgroups`
  ADD PRIMARY KEY (`linkgroupsid`);

--
-- Indexen voor tabel `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `maintheme`
--
ALTER TABLE `maintheme`
  ADD PRIMARY KEY (`themeid`);

--
-- Indexen voor tabel `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`schoolid`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `beeway`
--
ALTER TABLE `beeway`
  MODIFY `beewayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `beewayobservation`
--
ALTER TABLE `beewayobservation`
  MODIFY `observationid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `beewayplanning`
--
ALTER TABLE `beewayplanning`
  MODIFY `planningid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `disciplineid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `linkgroups`
--
ALTER TABLE `linkgroups`
  MODIFY `linkgroupsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT voor een tabel `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT voor een tabel `maintheme`
--
ALTER TABLE `maintheme`
  MODIFY `themeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `schools`
--
ALTER TABLE `schools`
  MODIFY `schoolid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
