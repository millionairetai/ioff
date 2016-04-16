-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2016 at 02:56 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `centeroffice`
--
CREATE DATABASE IF NOT EXISTS `centeroffice` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `centeroffice`;

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

CREATE TABLE IF NOT EXISTS `action` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `controller_id` smallint(6) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `url` text COLLATE utf8_unicode_ci,
  `is_display_menu` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `controller_id` (`controller_id`),
  KEY `is_display_menu` (`is_display_menu`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `action`
--

INSERT INTO `action` (`id`, `controller_id`, `name`, `description`, `url`, `is_display_menu`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 1, 'test', NULL, '', b'0', 0, 0, 0, b'0'),
(2, 1, 'index', NULL, '', b'0', 0, 0, 0, b'0'),
(5, 1, 'index2', 'index2', 'indexsssssssssssssssssssssssssssssssssss', b'1', 1451472407, 1451473235, 1, b'1'),
(6, 1, '3fdsfds', 'dswe', '', b'0', 1451473844, 1451473844, 1, b'0'),
(7, 3, 'ttttt', 'sdf', '', b'0', 1451474083, 1451474083, 1, b'1'),
(8, 9, 'sssssss', 'sad7sdf', '', b'0', 1451474128, 1451474567, 2, b'0'),
(9, 2, 'index', NULL, '', b'0', 0, 0, 0, b'0'),
(13, 1, 'test', 'sdf asd', '', b'0', 1451553577, 1451558010, 2, b'1'),
(14, 1, 'newtest', 'aswio', '', b'0', 1451553667, 1451553667, 2, b'0'),
(15, 1, 'create', 'asweiow', '', b'0', 1451553718, 1451557205, 2, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) unsigned NOT NULL,
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_id` int(11) unsigned NOT NULL,
  `parent_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `content` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `owner_table` (`owner_table`),
  KEY `employee_id` (`employee_id`),
  KEY `parent_employee_id` (`parent_employee_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_post`
--

CREATE TABLE IF NOT EXISTS `activity_post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `owner_table` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `parent_employee_id` bigint(20) NOT NULL DEFAULT '0',
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `content_parse` text COLLATE utf8_unicode_ci NOT NULL,
  `total_like` int(11) NOT NULL DEFAULT '0',
  `total_comment` int(11) NOT NULL DEFAULT '0',
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_table` (`owner_table`),
  KEY `parent_employee_id` (`parent_employee_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `annoucement`
--

CREATE TABLE IF NOT EXISTS `annoucement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `is_importance` bit(1) NOT NULL DEFAULT b'0',
  `date_new_to` int(11) unsigned DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `authority`
--

CREATE TABLE IF NOT EXISTS `authority` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `authority`
--

INSERT INTO `authority` (`id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 'Tổng giám đốc', 'Quyền cho tổng giám đốc', 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `authority_assigment`
--

CREATE TABLE IF NOT EXISTS `authority_assigment` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `authority_id` smallint(6) unsigned NOT NULL,
  `action_id` smallint(6) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `action_id` (`action_id`),
  KEY `authority_id` (`authority_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `authority_assigment`
--

INSERT INTO `authority_assigment` (`id`, `authority_id`, `action_id`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 1, 1, 0, 0, 0, b'0'),
(2, 1, 2, 0, 0, 0, b'0'),
(3, 1, 9, 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `address` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cache_hash` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cache_data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_table` (`owner_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 'traning', '', 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `parent_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `activity_post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `total_like` int(11) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `parent_employee_id` (`parent_employee_id`),
  KEY `activity_post_id` (`activity_post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `controller`
--

CREATE TABLE IF NOT EXISTS `controller` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` smallint(6) unsigned DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `component_id` (`module_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `controller`
--

INSERT INTO `controller` (`id`, `module_id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 1, 'Default', NULL, 0, 0, 0, b'0'),
(2, 1, 'Authority', NULL, 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE IF NOT EXISTS `criteria` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `strategy_map_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `strategy_map_id` (`strategy_map_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 'Account department', NULL, 0, 0, 0, b'0'),
(2, 'Sale department', NULL, 0, 0, 0, b'0'),
(3, 'Marketing department', NULL, 0, 0, 0, b'0'),
(4, 'Inventory department', NULL, 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `department_annoucement`
--

CREATE TABLE IF NOT EXISTS `department_annoucement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `annoucement_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  KEY `annoucement_id` (`annoucement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `sending_template_group_id` smallint(3) unsigned NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `default_from_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8_unicode_ci,
  `language_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `sending_template_group_id` (`sending_template_group_id`),
  KEY `column_name` (`column_name`),
  KEY `language_code` (`language_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `sending_template_group_id`, `subject`, `body`, `column_name`, `default_from_email`, `remark`, `language_code`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 1, 'New event', '{creator name} created event of {event name}', 'create_event', 'admin@centeroffice.vn', NULL, 'en', 0, 0, 0, b'0'),
(2, 1, 'Edit event', '{creator name} edited event of {event name}', 'edit_event', 'admin@centeroffice.vn', NULL, 'en', 0, 0, 0, b'0'),
(3, 1, 'Sự kiện mới', '{creator name} đã tạo sự kiện {event name}', 'create_event', 'admin@centeroffice.vn', NULL, 'vi', 0, 0, 0, b'0'),
(4, 1, 'Edit event', '{creator name}đã chỉnh sửa lại sự kiện {event name}', 'edit_event', 'admin@centeroffice.vn', NULL, 'vi', 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `manager_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `authority_id` smallint(6) unsigned NOT NULL,
  `position_id` int(11) unsigned NOT NULL,
  `department_id` smallint(6) unsigned NOT NULL,
  `bank_id` int(11) unsigned NOT NULL,
  `religion_id` int(11) unsigned NOT NULL,
  `marriage_status_id` int(11) unsigned NOT NULL,
  `nation_id` int(11) unsigned NOT NULL,
  `province_id` int(11) unsigned NOT NULL,
  `country_id` int(11) unsigned NOT NULL,
  `status_id` smallint(3) unsigned NOT NULL,
  `city_code` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `is_admin` bit(1) NOT NULL DEFAULT b'0',
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` int(11) unsigned NOT NULL,
  `gender` bit(1) NOT NULL DEFAULT b'0',
  `street_address_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_place_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_email` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_number_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_issue_id` bigint(20) unsigned DEFAULT '0',
  `bank_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_place` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_expire` int(11) unsigned DEFAULT '0',
  `zip_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passport_issue` int(11) unsigned DEFAULT '0',
  `tax_date_issue` int(11) unsigned DEFAULT '0',
  `tax_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_department` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_working_date` int(11) unsigned NOT NULL DEFAULT '0',
  `is_visible` bit(1) NOT NULL DEFAULT b'1',
  `profile_image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_activity_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `last_ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `manager_employee_id` (`manager_employee_id`),
  KEY `authority_id` (`authority_id`),
  KEY `position_id` (`position_id`),
  KEY `department_id` (`department_id`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `manager_employee_id`, `authority_id`, `position_id`, `department_id`, `bank_id`, `religion_id`, `marriage_status_id`, `nation_id`, `province_id`, `country_id`, `status_id`, `city_code`, `firstname`, `lastname`, `username`, `password`, `email`, `is_admin`, `code`, `card_number`, `birthdate`, `gender`, `street_address_1`, `street_address_2`, `telephone`, `mobile_phone`, `work_phone`, `card_place_id`, `work_email`, `card_number_id`, `card_issue_id`, `bank_number`, `passport_number`, `passport_place`, `passport_expire`, `zip_code`, `passport_issue`, `tax_date_issue`, `tax_code`, `tax_department`, `start_working_date`, `is_visible`, `profile_image_path`, `password_reset_token`, `auth_key`, `last_activity_datetime`, `last_ip_address`, `last_login_datetime`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 10, NULL, 'kk', '', 'millionairetai', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'millionairetai@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'millionairetai@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '1.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(2, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 10, NULL, 'duong thanh vang', '', 'duongthanhvang', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'duongthanhvang@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'millionairetai@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '2.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(13, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 10, NULL, 'vu thuy trinh', '', 'vuthuytrinh', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'vuthuytrinh@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'vuthuytrinh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '3.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(14, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 10, NULL, 'vu quoc hoa', '', 'vuquochoa', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'vuquochoa@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'vuquochoa@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '4.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(15, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 10, NULL, 'pham van truong', '', 'phamvantruong', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'phamvantruong@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'phamvantruong@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '5.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(16, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 10, NULL, 'le cong vinh', '', 'lecongving', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'lecongving@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'lecongving@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '6.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(17, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 10, NULL, 'duong hoang tuan', '', 'duonghoangtuan', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'duonghoangtuan@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'duonghoangtuan@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '7.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(18, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, NULL, 'duong van minh', '', 'duongvanminh', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'duongvanminh@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'duongvanminh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '8.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(19, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, NULL, 'nguyen van minh', '', 'nguyenvanminh', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'nguyenvanminh@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'nguyenvanminh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '9.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(20, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, NULL, 'pham van linh', '', 'phamvanminh', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'phamvanminh@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'phamvanminh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '10.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(21, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, NULL, 'ta hong gam', '', 'tahonggam', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'tahonggam@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'tahonggam@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '11.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0'),
(22, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, NULL, 'le van tam', '', 'levantam', '$2y$13$4PBC.2axsR/FtmQR8n6TO.Wd7TxD4TsHLDG/zGFEwYhidxfalMIkW', 'levantam@gmail.com', b'0', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'levantam@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, b'1', '12.jpg', NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `employee_activity`
--

CREATE TABLE IF NOT EXISTS `employee_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `activity_project` bigint(20) NOT NULL DEFAULT '0',
  `activity_task` bigint(20) NOT NULL DEFAULT '0',
  `activity_calendar` bigint(20) NOT NULL DEFAULT '0',
  `activity_annoucement` bigint(20) NOT NULL DEFAULT '0',
  `activity_statergy_map` bigint(20) NOT NULL DEFAULT '0',
  `activity_kpi` bigint(20) NOT NULL DEFAULT '0',
  `activity_employee` bigint(20) NOT NULL DEFAULT '0',
  `activity_contract` bigint(20) NOT NULL DEFAULT '0',
  `activity_subject` bigint(20) NOT NULL DEFAULT '0',
  `activity_post` bigint(20) NOT NULL DEFAULT '0',
  `activity_total` bigint(20) NOT NULL DEFAULT '0',
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_ip`
--

CREATE TABLE IF NOT EXISTS `employee_ip` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `type` (`type`),
  KEY `ip_address` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_space`
--

CREATE TABLE IF NOT EXISTS `employee_space` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `space_ project` bigint(20) NOT NULL DEFAULT '0',
  `space_task` bigint(20) NOT NULL DEFAULT '0',
  `space_calendar` bigint(20) NOT NULL DEFAULT '0',
  `space_annoucement` bigint(20) NOT NULL DEFAULT '0',
  `space_statergy_map` bigint(20) NOT NULL DEFAULT '0',
  `space_kpi` bigint(20) NOT NULL DEFAULT '0',
  `space_employee` bigint(20) NOT NULL DEFAULT '0',
  `space_contract` bigint(20) NOT NULL DEFAULT '0',
  `space_subject` bigint(20) NOT NULL DEFAULT '0',
  `space_post` bigint(20) NOT NULL DEFAULT '0',
  `space_total` bigint(20) NOT NULL DEFAULT '0',
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employee_strategy`
--

CREATE TABLE IF NOT EXISTS `employee_strategy` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `strategy_id` int(11) unsigned NOT NULL DEFAULT '0',
  `old_content` text COLLATE utf8_unicode_ci NOT NULL,
  `new_content` text COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `strategy_id` (`strategy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `calendar_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `end_datetime` int(11) NOT NULL DEFAULT '0',
  `is_public` bit(1) NOT NULL DEFAULT b'1',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `calendar_id` (`calendar_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) unsigned NOT NULL,
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_object` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `encoded_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `is_image` bit(1) NOT NULL DEFAULT b'0',
  `file_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_size` int(11) unsigned DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_object` (`owner_object`),
  KEY `encoded_name` (`encoded_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE IF NOT EXISTS `follower` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL,
  `task_id` bigint(20) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `forum_group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `order_value` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_new_top` bit(1) NOT NULL DEFAULT b'1',
  `is_closed` bit(1) NOT NULL DEFAULT b'0',
  `is_reviewed_post` bit(1) NOT NULL DEFAULT b'0',
  `is_authority_post` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `forum_group_id` (`forum_group_id`),
  KEY `employee_id` (`employee_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_group`
--

CREATE TABLE IF NOT EXISTS `forum_group` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frequency`
--

CREATE TABLE IF NOT EXISTS `frequency` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invitation`
--

CREATE TABLE IF NOT EXISTS `invitation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned NOT NULL,
  `owner_id` int(11) unsigned NOT NULL COMMENT 'id of department and employee',
  `owner_table` varchar(99) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'department' COMMENT '[department, employee]',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `employee_id` (`owner_id`),
  KEY `object` (`owner_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kpi`
--

CREATE TABLE IF NOT EXISTS `kpi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_kpi_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `kpi_group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `strategy_id` int(11) unsigned NOT NULL,
  `unit_measure_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL,
  `status_id` smallint(3) unsigned NOT NULL,
  `frequency_id` smallint(6) unsigned NOT NULL,
  `assignee_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `target_value` double unsigned NOT NULL,
  `start_datetime` int(11) unsigned DEFAULT '0',
  `end_datetime` int(11) unsigned DEFAULT '0',
  `percent` smallint(3) unsigned NOT NULL,
  `trend` smallint(3) unsigned DEFAULT '1',
  `is_share` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `parent_kpi_id` (`parent_kpi_id`),
  KEY `strategy_id` (`strategy_id`),
  KEY `employee_id` (`employee_id`),
  KEY `status_id` (`status_id`),
  KEY `frequency_id` (`frequency_id`),
  KEY `assignee_id` (`assignee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_group`
--

CREATE TABLE IF NOT EXISTS `kpi_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_report_time`
--

CREATE TABLE IF NOT EXISTS `kpi_report_time` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `department_id` smallint(6) NOT NULL DEFAULT '0',
  `report_datetime` int(11) NOT NULL DEFAULT '0',
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_result`
--

CREATE TABLE IF NOT EXISTS `kpi_result` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `kpi_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `kpi_report_time_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `rank_id` int(10) unsigned NOT NULL DEFAULT '0',
  `value` double unsigned NOT NULL,
  `grade` smallint(6) unsigned NOT NULL,
  `role_report` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `kpi_id` (`kpi_id`),
  KEY `kpi_report_time_id` (`kpi_report_time_id`),
  KEY `role_report` (`role_report`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `kpi_result_evaluation`
--

CREATE TABLE IF NOT EXISTS `kpi_result_evaluation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kpi_report_time_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `role_report` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'role_report: employee, direct_manager, director',
  `classification` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `part_a` smallint(6) unsigned NOT NULL,
  `part_b` smallint(6) unsigned NOT NULL,
  `point_part_a` smallint(6) unsigned NOT NULL,
  `point_part_b` smallint(6) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `kpi_report_time_id` (`kpi_report_time_id`),
  KEY `employee_id` (`employee_id`),
  KEY `role_report` (`role_report`),
  KEY `classification` (`classification`),
  KEY `part_a` (`part_a`),
  KEY `part_b` (`part_b`),
  KEY `point_part_a` (`point_part_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `marriage_status`
--

CREATE TABLE IF NOT EXISTS `marriage_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1450325349),
('m130524_201442_init', 1450325367);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `package_id` smallint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `package_id`, `name`, `description`, `version`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 1, 'authority', 'authority', '1.0', 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `nation`
--

CREATE TABLE IF NOT EXISTS `nation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) unsigned NOT NULL,
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_id` int(11) unsigned NOT NULL,
  `owner_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `content` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `owner_table` (`owner_table`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_employee_id` (`owner_employee_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `is_active` bit(1) NOT NULL DEFAULT b'1',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `name`, `description`, `is_active`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 'common', 'common', b'1', 0, 0, 0, b'0'),
(2, 'work', 'work', b'1', 0, 0, 0, b'0'),
(3, 'kpi', 'kpi', b'1', 0, 0, 0, b'0'),
(4, 'hrm', 'hrm', b'1', 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `percent`
--

CREATE TABLE IF NOT EXISTS `percent` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `criteria_id` int(11) unsigned NOT NULL DEFAULT '0',
  `position_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `value` tinyint(3) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `criteria_id` (`criteria_id`),
  KEY `position_id` (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `parent_post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `is_reviewed` bit(1) NOT NULL DEFAULT b'1',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`),
  KEY `parent_post_id` (`parent_post_id`),
  KEY `employee_id` (`employee_id`),
  KEY `is_reviewed` (`is_reviewed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `priority`
--

CREATE TABLE IF NOT EXISTS `priority` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL,
  `lastup_datetime` int(11) unsigned NOT NULL,
  `lastup_employee_id` int(11) unsigned NOT NULL,
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `priority`
--

INSERT INTO `priority` (`id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 'High', NULL, 0, 0, 0, b'0'),
(2, 'Medium', NULL, 0, 0, 0, b'0'),
(3, 'Normal', NULL, 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `manager_project_id` int(11) unsigned NOT NULL,
  `priority_id` smallint(3) unsigned NOT NULL,
  `status_id` smallint(3) unsigned NOT NULL,
  `parent_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `start_datetime` int(11) unsigned DEFAULT '0',
  `duedatetime` int(11) unsigned DEFAULT '0',
  `completed_percent` smallint(3) unsigned NOT NULL DEFAULT '0',
  `estimate_hour` smallint(6) unsigned DEFAULT '0',
  `worked_hour` smallint(6) unsigned DEFAULT '0',
  `is_public` bit(1) NOT NULL DEFAULT b'1',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL,
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `manager_project_id` (`manager_project_id`),
  KEY `priority_id` (`priority_id`),
  KEY `status_id` (`status_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_participant`
--

CREATE TABLE IF NOT EXISTS `project_participant` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `owner_id` int(11) unsigned NOT NULL,
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '[department and employee]',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `employee_id` (`owner_id`),
  KEY `owner_table` (`owner_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

CREATE TABLE IF NOT EXISTS `province` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `name` (`name`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE IF NOT EXISTS `rank` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE IF NOT EXISTS `religion` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `remind`
--

CREATE TABLE IF NOT EXISTS `remind` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `remind_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `minute_before` int(11) unsigned NOT NULL DEFAULT '0',
  `repeated_time` int(11) unsigned NOT NULL,
  `is_snoozing` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_id` (`owner_id`),
  KEY `owner_table` (`owner_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `requestment`
--

CREATE TABLE IF NOT EXISTS `requestment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `requestment_group_id` int(11) NOT NULL DEFAULT '0',
  `reviewing_employee_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `datetime` int(11) NOT NULL DEFAULT '0',
  `period_time` smallint(5) NOT NULL,
  `reason` text COLLATE utf8_unicode_ci,
  `is_accept` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `requestment_group_id` (`requestment_group_id`),
  KEY `reviewing_employee_id` (`reviewing_employee_id`),
  KEY `is_accept` (`is_accept`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `requestment_group`
--

CREATE TABLE IF NOT EXISTS `requestment_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sending_template_group`
--

CREATE TABLE IF NOT EXISTS `sending_template_group` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `column_name` (`column_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sending_template_group`
--

INSERT INTO `sending_template_group` (`id`, `name`, `column_name`, `description`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 'event', 'event', NULL, 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE IF NOT EXISTS `sms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'table join to',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_success` bit(1) NOT NULL DEFAULT b'1',
  `fee` int(11) unsigned DEFAULT '0',
  `agency_gateway` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_table` (`owner_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_template`
--

CREATE TABLE IF NOT EXISTS `sms_template` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `sending_template_group_id` smallint(3) unsigned NOT NULL,
  `body` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `default_from_phone_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `sending_template_group_id` (`sending_template_group_id`),
  KEY `column_name` (`column_name`),
  KEY `language_code` (`language_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sms_template`
--

INSERT INTO `sms_template` (`id`, `sending_template_group_id`, `body`, `column_name`, `default_from_phone_no`, `language_code`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 1, '{creator name} created event of {event name}', 'create_event', '0919644092', 'en', 0, 0, 0, b'0'),
(2, 1, '{creator name} đã tạo sự kiện {event name}', 'create_event', '0919644092', 'vi', 0, 0, 0, b'0'),
(3, 1, '{creator name} edited event of {event name}', 'edit_event', '0919644092', 'en', 0, 0, 0, b'0'),
(4, 1, '{creator name} đã chỉnh sửa sự kiện {event name}', 'edit_event', '0919644092', 'vi', 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `standard_evaluation`
--

CREATE TABLE IF NOT EXISTS `standard_evaluation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rank_id` int(10) NOT NULL DEFAULT '0',
  `kpi_id` bigint(20) NOT NULL DEFAULT '0',
  `min_value` double NOT NULL,
  `max_value` double NOT NULL,
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `rank_id` (`rank_id`),
  KEY `kpi_id` (`kpi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `column_name` (`column_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `description`, `column_name`, `datetime_created`, `lastup_datetime`, `lastup_employee_id`, `disabled`) VALUES
(1, 'New ', NULL, 'project', 0, 0, 0, b'0'),
(2, 'In progress', NULL, 'project', 0, 0, 0, b'0'),
(3, 'Complete', NULL, 'project', 0, 0, 0, b'0'),
(4, 'Close', NULL, 'project', 0, 0, 0, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `strategy`
--

CREATE TABLE IF NOT EXISTS `strategy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `criteria_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `criteria_id` (`criteria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `strategy_map`
--

CREATE TABLE IF NOT EXISTS `strategy_map` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status_id` smallint(3) unsigned NOT NULL,
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `vision` mediumtext COLLATE utf8_unicode_ci,
  `mission` mediumtext COLLATE utf8_unicode_ci,
  `start_datetime` int(11) unsigned DEFAULT '0',
  `end_datetime` int(11) unsigned DEFAULT '0',
  `is_public` bit(1) NOT NULL DEFAULT b'1',
  `is_default` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `status_id` (`status_id`),
  KEY `is_public` (`is_public`),
  KEY `is_default` (`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `is_reviewed` bit(1) NOT NULL DEFAULT b'1',
  `total_view` int(11) unsigned NOT NULL DEFAULT '0',
  `total_reply` int(11) unsigned DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `is_reviewed` (`is_reviewed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `system_setting`
--

CREATE TABLE IF NOT EXISTS `system_setting` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `column_name` (`column_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL DEFAULT '0',
  `priority_id` smallint(3) unsigned NOT NULL,
  `status_id` smallint(3) unsigned NOT NULL,
  `kpi_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL,
  `task_group_id` smallint(3) unsigned NOT NULL DEFAULT '0',
  `requestment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` mediumtext COLLATE utf8_unicode_ci,
  `start_datetime` int(11) unsigned DEFAULT '0',
  `duedatetime` int(11) unsigned DEFAULT '0',
  `estimate_hour` smallint(5) unsigned DEFAULT '0',
  `worked_hour` smallint(5) unsigned DEFAULT '0',
  `completed_percent` smallint(5) unsigned DEFAULT '0',
  `is_public` bit(1) NOT NULL DEFAULT b'1',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL,
  `lastup_employee_id` int(11) unsigned NOT NULL,
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `priority_id` (`priority_id`),
  KEY `status_id` (`status_id`),
  KEY `kpi_id` (`kpi_id`),
  KEY `parent_id` (`parent_id`),
  KEY `employee_id` (`employee_id`),
  KEY `requestment_id` (`requestment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_assignment`
--

CREATE TABLE IF NOT EXISTS `task_assignment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` bigint(20) unsigned NOT NULL,
  `employee_id` int(11) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_group`
--

CREATE TABLE IF NOT EXISTS `task_group` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `unit_measure`
--

CREATE TABLE IF NOT EXISTS `unit_measure` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `value` double unsigned DEFAULT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE IF NOT EXISTS `version` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `package_id` smallint(3) unsigned NOT NULL,
  `value` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
