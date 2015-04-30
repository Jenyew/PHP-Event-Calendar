-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2015 at 07:24 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php-event-calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_assigned`
--

CREATE TABLE IF NOT EXISTS `category_assigned` (
  `handle` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` smallint(5) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`handle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category_types`
--

CREATE TABLE IF NOT EXISTS `category_types` (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `descrption` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Event ID',
  `title` varchar(255) NOT NULL COMMENT 'Event Title',
  `description` text COMMENT 'Event Description',
  `start` datetime NOT NULL COMMENT 'Event Start Time',
  `end` datetime NOT NULL COMMENT 'Event End Time',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Event Creation Time',
  `author` smallint(5) unsigned NOT NULL COMMENT 'Event Author User ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `handle` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint(5) unsigned NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `expire` datetime DEFAULT NULL,
  PRIMARY KEY (`handle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `email` varchar(255) DEFAULT NULL COMMENT 'User Email',
  `firstName` varchar(255) DEFAULT NULL COMMENT 'User''s First Name',
  `lastName` varchar(255) DEFAULT NULL COMMENT 'User''s Last Name',
  `password` char(128) NOT NULL COMMENT 'User Password',
  `created` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Date/Time User Is Created',
  `lastLogin` datetime DEFAULT NULL COMMENT 'User Last Loged In',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `firstName`, `lastName`, `password`, `created`, `lastLogin`) VALUES
(1, 'test@test.com', 'John', 'Smith', 'Password1', '2015-04-23 17:36:20', NULL),
(2, 'test2@test.com', 'Jane', 'Smith', 'password2', '2015-04-23 17:52:29', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
