-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 11, 2013 at 05:07 AM
-- Server version: 5.5.23
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lab6oneo_ideabreaker`
--

-- --------------------------------------------------------

--
-- Table structure for table `zerolan_adsense`
--

CREATE TABLE IF NOT EXISTS `zerolan_adsense` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `size` varchar(50) NOT NULL DEFAULT '',
  `sbtitle` mediumtext,
  `status` enum('Y','N','E') NOT NULL DEFAULT 'N',
  `link` varchar(200) NOT NULL DEFAULT '',
  `banner` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `key1` (`size`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `zerolan_adsense`
--

INSERT INTO `zerolan_adsense` (`id`, `size`, `sbtitle`, `status`, `link`, `banner`) VALUES
(14, '790x80', 'Banner1', 'Y', 'http://www.google.com', 'banners/14.png'),
(16, '', 'Banner2', 'Y', 'http://www.google.com', 'banners/16.png'),
(17, '790x80', 'Banner3', 'Y', 'http://www.google.com', 'banners/17.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
