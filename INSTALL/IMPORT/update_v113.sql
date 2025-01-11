-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 11, 2025 at 07:09 PM
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
-- Table structure for table `settings`
--

ALTER TABLE `settings` ADD `ftp_host` varchar(255) NOT NULL DEFAULT '';
ALTER TABLE `settings` ADD `ftp_port` int NOT NULL DEFAULT '21';
ALTER TABLE `settings` ADD `ftp_user` varchar(255) NOT NULL DEFAULT '';
ALTER TABLE `settings` ADD `ftp_pass` varchar(255) NOT NULL DEFAULT '';
ALTER TABLE `settings` ADD `ftp_path` varchar(255) NOT NULL DEFAULT '/profile/mods';
ALTER TABLE `settings` ADD  `fs_restapi_careerSavegame` varchar(255) NOT NULL DEFAULT '';
  

--
-- Dumping data for table `settings`
--

UPDATE IGNORE `settings` SET `settings` = 'settings',`modFolderPath` = '',`firstRun` = 0,`installComplete` = 1,`hostname` = 'https://fs25.rotjong.xyz',`sql_host` = 'db',`sql_port` = 3306,`sql_user` = 'MYSQL_USER',`sql_pass` = 'MYSQL_PASS',`sql_db` = 'FS25_MODLIST',`indexerRunning` = 0,`ftp_host` = 'FTP_HOST',`ftp_port` = 21,`ftp_user` = 'FTP_USER',`ftp_pass` = 'FTP_PASS',`ftp_path` = '/profile/mods',`fs_restapi_careerSavegame` = '' WHERE `settings`.`settings` = 'settings';
