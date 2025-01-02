-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 01, 2025 at 10:49 PM
-- Server version: 9.1.0
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `FS25_MODLIST`
--

-- --------------------------------------------------------

--
-- Table structure for table `mods`
--

CREATE TABLE `mods` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `hash` varchar(255) NOT NULL DEFAULT '',
  `size` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `modFolderPath` varchar(255) NOT NULL DEFAULT '',
  `firstRun` int NOT NULL DEFAULT '0',
  `installComplete` int NOT NULL DEFAULT '0',
  `hostname` varchar(255) NOT NULL DEFAULT '',
  `sql_host` varchar(255) NOT NULL DEFAULT '',
  `sql_port` int NOT NULL DEFAULT '0',
  `sql_user` varchar(255) NOT NULL DEFAULT '',
  `sql_pass` varchar(255) NOT NULL DEFAULT '',
  `sql_db` varchar(255) NOT NULL DEFAULT '',
  `indexerRunning` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings`, `modFolderPath`, `firstRun`, `installComplete`, `hostname`, `sql_host`, `sql_port`, `sql_user`, `sql_pass`, `sql_db`, `indexerRunning`) VALUES
('settings', '', 1, 0, '', '', 3306, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `sessionid` varchar(255) NOT NULL DEFAULT '',
  `lastLogin` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `ip`, `sessionid`, `lastLogin`) VALUES
(1, 'admin', '057ba03d6c44104863dc7361fe4578965d1887360f90a0895882e58a6248fc86', '172.20.0.1', 'bvq7bs824t528oaa1na5ijtnrt', '1735501780');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mods`
--
ALTER TABLE `mods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mods`
--
ALTER TABLE `mods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
