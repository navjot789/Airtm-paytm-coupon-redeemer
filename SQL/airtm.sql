-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 29, 2020 at 07:09 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airtm`
--

-- --------------------------------------------------------

--
-- Table structure for table `coupon_pytm`
--

DROP TABLE IF EXISTS `coupon_pytm`;
CREATE TABLE IF NOT EXISTS `coupon_pytm` (
  `cp_id` int(11) NOT NULL AUTO_INCREMENT,
  `code_pytm` varchar(12) NOT NULL,
  `cdate` varchar(30) NOT NULL,
  `assoc_amt` int(3) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'redeem:1 | Not: 0',
  PRIMARY KEY (`cp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon_pytm`
--

INSERT INTO `coupon_pytm` (`cp_id`, `code_pytm`, `cdate`, `assoc_amt`, `status`) VALUES
(1, 'AY65HDSDRFDW', '', 10, 0),
(2, 'AY75H6HDKS53', '', 5, 1),
(3, 'AY65HDSHGFT5', '07/09/2020 04:23:21 PM', 25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reedemers`
--

DROP TABLE IF EXISTS `reedemers`;
CREATE TABLE IF NOT EXISTS `reedemers` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `cp_id` int(11) NOT NULL DEFAULT '0',
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `otp` varchar(26) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'verify:1 | Not: 0',
  `cdate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reedemers`
--

INSERT INTO `reedemers` (`rid`, `cp_id`, `fname`, `lname`, `email`, `otp`, `status`, `cdate`) VALUES
(80, 1, 'Navjot', 'singh', 'tomig88707@questza.com', 'qB5YbWCanp2xlNirHkm3eGuos', 1, '2020-11-28 22:45:33'),
(79, 2, 'kvita', 'kumari', 'web.dev.nav@gmail.com', 'pXTPoABCkw0vJcrl4uYIMGZje', 1, '2020-11-28 22:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `reedemers_details`
--

DROP TABLE IF EXISTS `reedemers_details`;
CREATE TABLE IF NOT EXISTS `reedemers_details` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL,
  `p_no` varchar(10) NOT NULL,
  `cdate` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`did`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reedemers_details`
--

INSERT INTO `reedemers_details` (`did`, `rid`, `p_no`, `cdate`) VALUES
(10, 80, '9041240382', '2020-11-28 22:46:15'),
(9, 79, '1111111111', '2020-11-28 22:40:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
