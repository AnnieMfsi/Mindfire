-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 17, 2016 at 10:35 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `RegistrationInfo`
--

-- --------------------------------------------------------

--
-- Table structure for table `Address`
--

CREATE TABLE IF NOT EXISTS `Address` (
  `addressId` int(15) NOT NULL AUTO_INCREMENT,
  `addressType` enum('residence','office') NOT NULL,
  `street` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip` int(15) NOT NULL,
  `state` varchar(25) NOT NULL,
  `empId` int(10) NOT NULL,
  PRIMARY KEY (`addressId`),
  KEY `empId` (`empId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=315 ;

-- --------------------------------------------------------

--
-- Table structure for table `Communication`
--

CREATE TABLE IF NOT EXISTS `Communication` (
  `CommId` int(10) NOT NULL AUTO_INCREMENT,
  `CommMedium` varchar(25) NOT NULL,
  PRIMARY KEY (`CommId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
--
-- Dumping data for table `Communication`
--

INSERT INTO `Communication` (`CommId`, `CommMedium`) VALUES
(1, 'Email'),
(2, 'Message'),
(3, 'Phone'),
(4, 'Any');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE IF NOT EXISTS `Employee` (
  `empId` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(10) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `middleName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `gender` enum('male','female','others','') NOT NULL,
  `phone` int(12) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `maritalStatus` enum('married','unmarried','divorced','widow','widower','single') NOT NULL,
  `empStatus` enum('employed','unemployed','student','self-employed') NOT NULL,
  `employer` varchar(30) NOT NULL,
  `commId` varchar(10) NOT NULL,
  `image` varchar(30) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`empId`),
  KEY `commId` (`commId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
