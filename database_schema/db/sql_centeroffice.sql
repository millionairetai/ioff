-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.32 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for centeroffice
CREATE DATABASE IF NOT EXISTS `centeroffice` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `centeroffice`;


-- Dumping structure for table centeroffice.action
CREATE TABLE IF NOT EXISTS `action` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `controller_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `url` text COLLATE utf8_unicode_ci,
  `is_display_menu` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `controller_id` (`controller_id`),
  KEY `is_display_menu` (`is_display_menu`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.action: ~11 rows (approximately)
/*!40000 ALTER TABLE `action` DISABLE KEYS */;
INSERT INTO `action` (`id`, `controller_id`, `name`, `description`, `url`, `is_display_menu`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 'test', NULL, '', b'0', 0, 0, 0, 0, b'0'),
	(2, 1, 'index', NULL, '', b'0', 0, 0, 0, 0, b'0'),
	(5, 1, 'index2', 'index2', 'indexsssssssssssssssssssssssssssssssssss', b'1', 1451472407, 1451473235, 0, 1, b'1'),
	(6, 1, '3fdsfds', 'dswe', '', b'0', 1451473844, 1451473844, 0, 1, b'0'),
	(7, 3, 'ttttt', 'sdf', '', b'0', 1451474083, 1451474083, 0, 1, b'1'),
	(8, 9, 'sssssss', 'sad7sdf', '', b'0', 1451474128, 1451474567, 0, 2, b'0'),
	(9, 2, 'index', NULL, '', b'0', 0, 0, 0, 0, b'0'),
	(13, 1, 'test', 'sdf asd', '', b'0', 1451553577, 1451558010, 0, 2, b'1'),
	(14, 1, 'newtest', 'aswio', '', b'0', 1451553667, 1451553667, 0, 2, b'0'),
	(15, 1, 'create', 'asweiow', '', b'0', 1451553718, 1451557205, 0, 2, b'1'),
	(16, 3, 'create', 'asweiow', NULL, b'0', 1451553718, 1451557205, 0, 2, b'0');
/*!40000 ALTER TABLE `action` ENABLE KEYS */;


-- Dumping structure for table centeroffice.activity
CREATE TABLE IF NOT EXISTS `activity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_id` bigint(20) unsigned NOT NULL,
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_id` int(11) unsigned NOT NULL,
  `parent_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `content` text COLLATE utf8_unicode_ci,
  `total_comment` int(11) unsigned DEFAULT '0',
  `total_like` int(11) unsigned DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `owner_table` (`owner_table`),
  KEY `employee_id` (`employee_id`),
  KEY `parent_employee_id` (`parent_employee_id`),
  KEY `type` (`type`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.activity: ~69 rows (approximately)
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` (`id`, `company_id`, `owner_id`, `owner_table`, `employee_id`, `parent_employee_id`, `type`, `content`, `total_comment`, `total_like`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 1, 'project', 1, 0, 'create_project', 'kk  Ngày tạo  Test new databaseTest new databaseTest new databaseTest new database', 0, 0, 1460106767, 1460106767, 1, 1, b'0'),
	(2, 0, 2, 'project', 1, 0, 'create_project', 'kk  Ngày tạo  Test new database with company_id', 0, 0, 1460106964, 1460106964, 1, 1, b'0'),
	(3, 1, 3, 'project', 1, 0, 'create_project', 'kk  Ngày tạo  Yii::$app->user->getId()', 0, 0, 1460108501, 1460108501, 1, 1, b'0'),
	(4, 24, 4, 'project', 24, 0, 'create_project', 'kk  Ngày tạo  Test company_id', 0, 0, 1460162126, 1460162126, 24, 24, b'0'),
	(5, 99, 5, 'project', 99, 0, 'create_project', 'kk  Ngày tạo  return 999return 999return 999return 999return 999return 999return 999', 0, 0, 1460162202, 1460162202, 99, 99, b'0'),
	(6, 24, 6, 'project', 24, 0, 'create_project', 'kk  Ngày tạo  Thông tin dự án', 0, 0, 1460169662, 1460169662, 24, 24, b'0'),
	(7, 32, 7, 'project', 24, 0, 'create_project', 'kk  Ngày tạo  test com', 0, 0, 1460171440, 1460171440, 24, 24, b'0'),
	(8, 32, 8, 'project', 24, 0, 'create_project', 'kk  Ngày tạo  Tên dự án', 0, 0, 1460171712, 1460171712, 24, 24, b'0'),
	(9, 32, 9, 'project', 24, 0, 'create_project', 'kk  Ngày tạo  Test project just integration', 0, 0, 1460192720, 1460192720, 24, 24, b'0'),
	(10, 32, 10, 'project', 24, 0, 'create_project', 'kk  Ngày tạo  Test opera', 0, 0, 1460204128, 1460204128, 24, 24, b'0'),
	(11, 32, 11, 'project', 24, 0, 'create_project', 'kk  Ngày tạo  f', 0, 0, 1460251615, 1460251615, 24, 24, b'0'),
	(12, 1, 12, 'project', 24, 0, 'create_project', 'kk  đã tạo  test upload file', 0, 0, 1460432558, 1460432558, 24, 24, b'0'),
	(13, 1, 13, 'project', 24, 0, 'create_project', 'kk  đã tạo  Test project upload', 0, 0, 1460434275, 1460434275, 24, 24, b'0'),
	(14, 1, 14, 'project', 24, 0, 'create_project', 'kk  đã tạo  Upload same file name mutilple', 0, 0, 1460434734, 1460434734, 24, 24, b'0'),
	(15, 1, 15, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 0, 0, 1460435172, 1460435172, 22, 22, b'0'),
	(16, 1, 16, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test project manager', 0, 0, 1460437527, 1460437527, 22, 22, b'0'),
	(17, 1, 17, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test project manager', 0, 0, 1460437572, 1460437572, 22, 22, b'0'),
	(18, 1, 18, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test project manager', 0, 0, 1460437607, 1460437607, 22, 22, b'0'),
	(19, 1, 19, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test same file name error', 0, 0, 1460438032, 1460438032, 22, 22, b'0'),
	(20, 1, 20, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 0, 0, 1460438530, 1460438530, 22, 22, b'0'),
	(21, 1, 21, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test project manager for', 0, 0, 1460438955, 1460438955, 22, 22, b'0'),
	(22, 1, 22, 'project', 20, 0, 'create_project', 'pham van linh  đã tạo  Thông tin dự án', 0, 0, 1460896313, 1460896313, 20, 20, b'0'),
	(23, 1, 23, 'project', 20, 0, 'create_project', 'pham van linh  đã tạo  Test new integration', 0, 0, 1460897200, 1460897200, 20, 20, b'0'),
	(24, 1, 24, 'project', 20, 0, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 0, 0, 1460897440, 1460897440, 20, 20, b'0'),
	(25, 2, 25, 'project', 21, 0, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 0, 0, 1460940641, 1460940641, 21, 21, b'0'),
	(26, 1, 26, 'project', 16, 0, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', 0, 0, 1460942521, 1460942521, 16, 16, b'0'),
	(27, 1, 27, 'project', 16, 0, 'create_project', 'le cong vinh  đã tạo  Test new upload filder folder', 0, 0, 1460943325, 1460943325, 16, 16, b'0'),
	(28, 1, 28, 'project', 17, 0, 'create_project', 'duong hoang tuan  đã tạo  Test upload by compnay 1 duonghoangtuan', 0, 0, 1460943582, 1460943582, 17, 17, b'0'),
	(29, 1, 29, 'project', 17, 0, 'create_project', 'duong hoang tuan  đã tạo  Test company 1 duoongh hoang tuan', 0, 0, 1460943701, 1460943701, 17, 17, b'0'),
	(30, 1, 30, 'project', 17, 0, 'create_project', 'duong hoang tuan  đã tạo  TEst new 1 duong hoang tuan', 0, 0, 1460944015, 1460944015, 17, 17, b'0'),
	(31, 1, 31, 'project', 17, 0, 'create_project', 'duong hoang tuan  đã tạo  dfdsfds', 0, 0, 1460944167, 1460944167, 17, 17, b'0'),
	(32, 1, 32, 'project', 17, 0, 'create_project', 'duong hoang tuan  đã tạo  . DIRECTORY_SEPARATOR. DIRECTORY_SEPARATOR. DIRECTORY_SEPARATOR', 0, 0, 1460944281, 1460944281, 17, 17, b'0'),
	(33, 2, 33, 'project', 21, 0, 'create_project', 'ta hong gam  đã tạo  Test company_id upload', 0, 0, 1460962410, 1460962410, 21, 21, b'0'),
	(34, 2, 34, 'project', 21, 0, 'create_project', 'ta hong gam  đã tạo  TEst new upload new', 0, 0, 1460962572, 1460962572, 21, 21, b'0'),
	(35, 1, 35, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1', 0, 0, 1460963353, 1460963353, 13, 13, b'0'),
	(36, 1, 36, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Vu thuy trinh company id 111111111111111111111111', 0, 0, 1460963619, 1460963619, 13, 13, b'0'),
	(37, 1, 37, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Vu thuy trinh company id 1333333333333333', 0, 0, 1460963676, 1460963676, 13, 13, b'0'),
	(38, 1, 38, 'project', 20, 0, 'create_project', 'pham van linh  đã tạo  Test new adn compnay _id', 0, 0, 1460967045, 1460967045, 20, 20, b'0'),
	(39, 2, 41, 'project', 21, 0, 'create_project', 'ta hong gam  đã tạo  Test no choice priority', 0, 0, 1460970448, 1460970448, 21, 21, b'0'),
	(40, 2, 42, 'project', 21, 0, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 0, 0, 1460971103, 1460971103, 21, 21, b'0'),
	(41, 1, 43, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 0, 0, 1460971216, 1460971216, 13, 13, b'0'),
	(42, 1, 44, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  d fads fasdfsd', 0, 0, 1460971475, 1460971475, 13, 13, b'0'),
	(43, 1, 46, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Test expand range of value estimate time.', 0, 0, 1460979358, 1460979358, 13, 13, b'0'),
	(44, 1, 56, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  teasfd', 0, 0, 1460981343, 1460981343, 13, 13, b'0'),
	(45, 1, 57, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 0, 0, 1460981393, 1460981393, 13, 13, b'0'),
	(46, 1, 58, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 0, 0, 1461036043, 1461036043, 13, 13, b'0'),
	(47, 1, 59, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 0, 0, 1461036304, 1461036304, 13, 13, b'0'),
	(48, 1, 60, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 0, 0, 1461037445, 1461037445, 13, 13, b'0'),
	(49, 1, 61, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 0, 0, 1461040866, 1461040866, 13, 13, b'0'),
	(50, 1, 62, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 0, 0, 1461053327, 1461053327, 13, 13, b'0'),
	(51, 2, 63, 'project', 21, 0, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', 0, 0, 1461053399, 1461053399, 21, 21, b'0'),
	(52, 2, 64, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  dfadsfdsf', 0, 0, 1461058151, 1461058151, 22, 22, b'0'),
	(53, 2, 65, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  test safaris', 0, 0, 1461129962, 1461129962, 22, 22, b'0'),
	(54, 1, 66, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Test sending email', 0, 0, 1461136235, 1461136235, 13, 13, b'0'),
	(55, 1, 67, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Test bug sending email', 0, 0, 1461136312, 1461136312, 13, 13, b'0'),
	(56, 1, 68, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  dfdfdsfds', 0, 0, 1461137202, 1461137202, 13, 13, b'0'),
	(62, 1, 74, 'project', 13, 0, 'create_project', 'vu thuy trinh  Created date  {Add project name em template}', 0, 0, 1461137909, 1461137909, 13, 13, b'0'),
	(63, 2, 75, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test safarais', 0, 0, 1461143719, 1461143719, 22, 22, b'0'),
	(64, 2, 76, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test safaris', 0, 0, 1461143877, 1461143877, 22, 22, b'0'),
	(65, 2, 77, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Check again Hung task.', 0, 0, 1461168668, 1461168668, 22, 22, b'0'),
	(66, 1, 78, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  aaa', 0, 0, 1461280058, 1461280058, 13, 13, b'0'),
	(67, 1, 79, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', 0, 0, 1461282768, 1461282768, 13, 13, b'0'),
	(68, 1, 80, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  abc', 0, 0, 1461299599, 1461299599, 13, 13, b'0'),
	(69, 1, 81, 'project', 19, 0, 'create_project', 'nguyen van minh  đã tạo  Test employe chooose member', 0, 0, 1461347985, 1461347985, 19, 19, b'0'),
	(70, 1, 82, 'project', 19, 0, 'create_project', 'nguyen van minh  đã tạo  a', 0, 0, 1461348462, 1461348462, 19, 19, b'0'),
	(71, 1, 83, 'project', 13, 0, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', 0, 0, 1461349941, 1461349941, 13, 13, b'0'),
	(72, 2, 84, 'project', 22, 0, 'create_project', 'le van tam  đã tạo  Test safaris', 0, 0, 1461350137, 1461350137, 22, 22, b'0'),
	(73, 2, 85, 'project', 21, 0, 'create_project', 'ta hong gam  đã tạo  TEst opera', 0, 0, 1461350392, 1461350392, 21, 21, b'0'),
	(74, 1, 86, 'project', 14, 0, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', 0, 0, 1461350647, 1461350647, 14, 14, b'0');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;


-- Dumping structure for table centeroffice.activity_post
CREATE TABLE IF NOT EXISTS `activity_post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `owner_id` bigint(20) NOT NULL DEFAULT '0',
  `employee_id` int(11) NOT NULL DEFAULT '0',
  `owner_table` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `parent_employee_id` bigint(20) NOT NULL DEFAULT '0',
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `content_parse` text COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) NOT NULL DEFAULT '0',
  `created_employee_id` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_table` (`owner_table`),
  KEY `parent_employee_id` (`parent_employee_id`),
  KEY `parent_id` (`parent_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.activity_post: ~0 rows (approximately)
/*!40000 ALTER TABLE `activity_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_post` ENABLE KEYS */;


-- Dumping structure for table centeroffice.annoucement
CREATE TABLE IF NOT EXISTS `annoucement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` text COLLATE utf8_unicode_ci NOT NULL,
  `is_importance` bit(1) NOT NULL DEFAULT b'0',
  `date_new_to` int(11) unsigned DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.annoucement: ~0 rows (approximately)
/*!40000 ALTER TABLE `annoucement` DISABLE KEYS */;
/*!40000 ALTER TABLE `annoucement` ENABLE KEYS */;


-- Dumping structure for table centeroffice.attend_choice_event
CREATE TABLE IF NOT EXISTS `attend_choice_event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` int(11) unsigned NOT NULL DEFAULT '0',
  `column_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no_confirm',
  `description` mediumtext COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `column_name` (`column_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.attend_choice_event: ~0 rows (approximately)
/*!40000 ALTER TABLE `attend_choice_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `attend_choice_event` ENABLE KEYS */;


-- Dumping structure for table centeroffice.authority
CREATE TABLE IF NOT EXISTS `authority` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.authority: ~1 rows (approximately)
/*!40000 ALTER TABLE `authority` DISABLE KEYS */;
INSERT INTO `authority` (`id`, `company_id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 'Tổng giám đốc', 'Quyền cho tổng giám đốc', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `authority` ENABLE KEYS */;


-- Dumping structure for table centeroffice.authority_assigment
CREATE TABLE IF NOT EXISTS `authority_assigment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `authority_id` smallint(6) unsigned NOT NULL,
  `action_id` smallint(6) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `action_id` (`action_id`),
  KEY `authority_id` (`authority_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.authority_assigment: ~4 rows (approximately)
/*!40000 ALTER TABLE `authority_assigment` DISABLE KEYS */;
INSERT INTO `authority_assigment` (`id`, `company_id`, `authority_id`, `action_id`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 1, 1, 0, 0, 0, 0, b'0'),
	(2, 0, 1, 2, 0, 0, 0, 0, b'0'),
	(3, 0, 1, 9, 0, 0, 0, 0, b'0'),
	(4, 0, 1, 16, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `authority_assigment` ENABLE KEYS */;


-- Dumping structure for table centeroffice.bank
CREATE TABLE IF NOT EXISTS `bank` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `address` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.bank: ~0 rows (approximately)
/*!40000 ALTER TABLE `bank` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank` ENABLE KEYS */;


-- Dumping structure for table centeroffice.business_type
CREATE TABLE IF NOT EXISTS `business_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.business_type: ~0 rows (approximately)
/*!40000 ALTER TABLE `business_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `business_type` ENABLE KEYS */;


-- Dumping structure for table centeroffice.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cache_hash` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cache_data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_table` (`owner_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.cache: ~0 rows (approximately)
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;


-- Dumping structure for table centeroffice.calendar
CREATE TABLE IF NOT EXISTS `calendar` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.calendar: ~5 rows (approximately)
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` (`id`, `company_id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 'Traning', '', 0, 0, 0, 0, b'0'),
	(2, 1, 'Meeting', '', 0, 0, 0, 0, b'0'),
	(3, 1, 'Happy hour', '', 0, 0, 0, 0, b'0'),
	(4, 2, 'Checking', '', 0, 0, 0, 0, b'0'),
	(5, 2, 'Education', '', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;


-- Dumping structure for table centeroffice.campaign
CREATE TABLE IF NOT EXISTS `campaign` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `start_date` int(11) unsigned NOT NULL DEFAULT '0',
  `end_date` int(11) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.campaign: ~0 rows (approximately)
/*!40000 ALTER TABLE `campaign` DISABLE KEYS */;
/*!40000 ALTER TABLE `campaign` ENABLE KEYS */;


-- Dumping structure for table centeroffice.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `parent_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `activity_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `total_like` int(11) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `parent_employee_id` (`parent_employee_id`),
  KEY `activity_post_id` (`activity_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.comment: ~0 rows (approximately)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;


-- Dumping structure for table centeroffice.company
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `plan_type_detail_id` int(11) unsigned NOT NULL DEFAULT '0',
  `language_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_title` mediumtext COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `start_date` int(11) unsigned NOT NULL DEFAULT '0',
  `expired_date` int(11) unsigned NOT NULL DEFAULT '0',
  `language_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `email` (`email`),
  KEY `plan_type_detail_id` (`plan_type_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.company: ~2 rows (approximately)
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` (`id`, `status_id`, `plan_type_detail_id`, `language_id`, `name`, `email`, `address`, `phone_no`, `domain`, `profile_image_path`, `description_title`, `description`, `start_date`, `expired_date`, `language_code`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 0, 0, 'Centeroffice', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, '', 0, 0, 0, 0, b'0'),
	(2, 1, 0, 0, 'Inet', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, '', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;


-- Dumping structure for table centeroffice.company_allocation
CREATE TABLE IF NOT EXISTS `company_allocation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL,
  `business_type_id` int(11) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `business_type_id` (`business_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.company_allocation: ~0 rows (approximately)
/*!40000 ALTER TABLE `company_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_allocation` ENABLE KEYS */;


-- Dumping structure for table centeroffice.controller
CREATE TABLE IF NOT EXISTS `controller` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `package_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `package_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `package_id` (`package_id`),
  KEY `package_name` (`package_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.controller: ~3 rows (approximately)
/*!40000 ALTER TABLE `controller` DISABLE KEYS */;
INSERT INTO `controller` (`id`, `package_id`, `name`, `description`, `package_name`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 'Default', NULL, NULL, 0, 0, 0, 0, b'0'),
	(2, 0, 'Authority', NULL, NULL, 0, 0, 0, 0, b'0'),
	(3, 0, 'Project', NULL, NULL, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `controller` ENABLE KEYS */;


-- Dumping structure for table centeroffice.country
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.country: ~0 rows (approximately)
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
/*!40000 ALTER TABLE `country` ENABLE KEYS */;


-- Dumping structure for table centeroffice.department
CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.department: ~6 rows (approximately)
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` (`id`, `company_id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 2, 'Martketing', NULL, 0, 0, 0, 0, b'0'),
	(2, 2, 'Sale', NULL, 0, 0, 0, 0, b'0'),
	(3, 1, 'Tiếp thị', NULL, 0, 0, 0, 0, b'0'),
	(4, 1, 'Kỹ thuật', NULL, 0, 0, 0, 0, b'0'),
	(5, 1, 'Bán hàng', NULL, 0, 0, 0, 0, b'0'),
	(6, 1, 'Giám đốc', NULL, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;


-- Dumping structure for table centeroffice.department_annoucement
CREATE TABLE IF NOT EXISTS `department_annoucement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `department_id` int(11) unsigned NOT NULL DEFAULT '0',
  `annoucement_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  KEY `annoucement_id` (`annoucement_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.department_annoucement: ~0 rows (approximately)
/*!40000 ALTER TABLE `department_annoucement` DISABLE KEYS */;
/*!40000 ALTER TABLE `department_annoucement` ENABLE KEYS */;


-- Dumping structure for table centeroffice.email_template
CREATE TABLE IF NOT EXISTS `email_template` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `sending_template_group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `language_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `default_from_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8_unicode_ci,
  `language_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `sending_template_group_id` (`sending_template_group_id`),
  KEY `column_name` (`column_name`),
  KEY `language_code` (`language_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.email_template: ~6 rows (approximately)
/*!40000 ALTER TABLE `email_template` DISABLE KEYS */;
INSERT INTO `email_template` (`id`, `sending_template_group_id`, `language_id`, `subject`, `body`, `column_name`, `default_from_email`, `remark`, `language_code`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 0, 'New event', '{creator name} created event of {event name}', 'create_event', 'admin@centeroffice.vn', NULL, 'en', 0, 0, 0, 0, b'0'),
	(2, 1, 0, 'Edit event', '{creator name} edited event of {event name}', 'edit_event', 'admin@centeroffice.vn', NULL, 'en', 0, 0, 0, 0, b'0'),
	(3, 1, 0, 'Sự kiện mới', '{creator name} đã tạo sự kiện {project name}', 'create_event', 'admin@centeroffice.vn', NULL, 'vi', 0, 0, 0, 0, b'0'),
	(4, 1, 0, 'Edit event', '{creator name}đã chỉnh sửa lại sự kiện {event name}', 'edit_event', 'admin@centeroffice.vn', NULL, 'vi', 0, 0, 0, 0, b'0'),
	(5, 1, 0, 'Tao dự án mới', '{creator name} đã tạo dự án {project name}', 'create_project', 'admin@centeroffice.vn', NULL, 'vi', 0, 0, 0, 0, b'0'),
	(6, 1, 0, 'Create project', '{creator name} created project of {project name}', 'create_project', 'admin@centeroffice.vn', NULL, 'en', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `email_template` ENABLE KEYS */;


-- Dumping structure for table centeroffice.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `manager_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `authority_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `position_id` int(11) unsigned NOT NULL DEFAULT '0',
  `department_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `bank_id` int(11) unsigned NOT NULL DEFAULT '0',
  `religion_id` int(11) unsigned NOT NULL DEFAULT '0',
  `marriage_status_id` int(11) unsigned NOT NULL DEFAULT '0',
  `nation_id` int(11) unsigned NOT NULL DEFAULT '0',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0',
  `country_id` int(11) unsigned NOT NULL DEFAULT '0',
  `status_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `language_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `city_code` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `is_admin` bit(1) NOT NULL DEFAULT b'0',
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` int(11) unsigned NOT NULL DEFAULT '0',
  `gender` bit(1) NOT NULL DEFAULT b'0',
  `street_address_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_place_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT '0',
  `work_email` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_number_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT '0',
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
  `stop_working_date` int(11) unsigned NOT NULL DEFAULT '0',
  `is_visible` bit(1) NOT NULL DEFAULT b'1',
  `profile_image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_activity_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `last_ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `manager_employee_id` (`manager_employee_id`),
  KEY `authority_id` (`authority_id`),
  KEY `position_id` (`position_id`),
  KEY `department_id` (`department_id`),
  KEY `email` (`email`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.employee: ~13 rows (approximately)
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` (`id`, `company_id`, `manager_employee_id`, `authority_id`, `position_id`, `department_id`, `bank_id`, `religion_id`, `marriage_status_id`, `nation_id`, `province_id`, `country_id`, `status_id`, `language_id`, `city_code`, `firstname`, `lastname`, `password`, `email`, `is_admin`, `code`, `card_number`, `birthdate`, `gender`, `street_address_1`, `street_address_2`, `telephone`, `mobile_phone`, `work_phone`, `card_place_id`, `work_email`, `card_number_id`, `card_issue_id`, `bank_number`, `passport_number`, `passport_place`, `passport_expire`, `zip_code`, `passport_issue`, `tax_date_issue`, `tax_code`, `tax_department`, `start_working_date`, `stop_working_date`, `is_visible`, `profile_image_path`, `language_code`, `password_reset_token`, `auth_key`, `last_activity_datetime`, `last_ip_address`, `last_login_datetime`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'Trần Văn Tài', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'millionairetai@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'millionairetai@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', NULL, NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(2, 1, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'duong thanh vang', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'duongthanhvang@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'millionairetai@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '2.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(13, 1, 0, 1, 0, 5, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'vu thuy trinh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'vuthuytrinh@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'vuthuytrinh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '3.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(14, 1, 0, 1, 0, 6, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'vu quoc hoa', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'vuquochoa@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'vuquochoa@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '4.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(15, 1, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'pham van truong', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'phamvantruong@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'phamvantruong@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '5.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(16, 1, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'le cong vinh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'lecongving@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'lecongving@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '6.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(17, 1, 0, 1, 0, 5, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'duong hoang tuan', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'duonghoangtuan@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'duonghoangtuan@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '7.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(18, 1, 0, 1, 0, 6, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'duong van minh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'duongvanminh@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'duongvanminh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '8.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(19, 1, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'nguyen van minh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'nguyenvanminh@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'nguyenvanminh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '9.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(20, 1, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'pham van linh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'phamvanminh@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'phamvanminh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '10.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(21, 2, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'ta hong gam', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'tahonggam@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'tahonggam@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '11.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(22, 2, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'le van tam', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'levantam@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'levantam@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '12.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(23, 2, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'Nguyễn Văn Nhật', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'millionairetai@gmail.com1', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'millionairetai@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', NULL, NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;


-- Dumping structure for table centeroffice.employee_activity
CREATE TABLE IF NOT EXISTS `employee_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '0',
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
  `created_employee_id` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.employee_activity: ~11 rows (approximately)
/*!40000 ALTER TABLE `employee_activity` DISABLE KEYS */;
INSERT INTO `employee_activity` (`id`, `company_id`, `employee_id`, `activity_project`, `activity_task`, `activity_calendar`, `activity_annoucement`, `activity_statergy_map`, `activity_kpi`, `activity_employee`, `activity_contract`, `activity_subject`, `activity_post`, `activity_total`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 1, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 11, 1460106767, 1460251615, 1, 24, b'0'),
	(2, 1, 24, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 1460432558, 1460434734, 24, 24, b'0'),
	(3, 1, 22, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 8, 1460435172, 1461129962, 22, 22, b'0'),
	(4, 1, 20, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 1460896313, 1460967045, 20, 20, b'0'),
	(5, 2, 21, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 1460940641, 1461350392, 21, 21, b'0'),
	(6, 1, 16, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1460942521, 1460943326, 16, 16, b'0'),
	(7, 1, 17, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 1460943582, 1460944281, 17, 17, b'0'),
	(8, 1, 13, 21, 0, 0, 0, 0, 0, 0, 0, 0, 0, 21, 1460963353, 1461349941, 13, 13, b'0'),
	(9, 2, 22, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 1461058151, 1461350137, 22, 22, b'0'),
	(10, 1, 19, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1461347985, 1461348462, 19, 19, b'0'),
	(11, 1, 14, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1461350647, 1461350647, 14, 14, b'0');
/*!40000 ALTER TABLE `employee_activity` ENABLE KEYS */;


-- Dumping structure for table centeroffice.employee_ip
CREATE TABLE IF NOT EXISTS `employee_ip` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `type` (`type`),
  KEY `ip_address` (`ip_address`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.employee_ip: ~0 rows (approximately)
/*!40000 ALTER TABLE `employee_ip` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_ip` ENABLE KEYS */;


-- Dumping structure for table centeroffice.employee_space
CREATE TABLE IF NOT EXISTS `employee_space` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `employee_id` int(11) NOT NULL,
  `space_project` bigint(20) NOT NULL DEFAULT '0',
  `space_task` bigint(20) NOT NULL DEFAULT '0',
  `space_calendar` bigint(20) NOT NULL DEFAULT '0',
  `space_annoucement` bigint(20) NOT NULL DEFAULT '0',
  `space_statergy_map` bigint(20) NOT NULL DEFAULT '0',
  `space_kpi` bigint(20) NOT NULL DEFAULT '0',
  `space_employee` bigint(20) NOT NULL DEFAULT '0',
  `space_contract` bigint(20) NOT NULL DEFAULT '0',
  `space_subject` bigint(20) NOT NULL DEFAULT '0',
  `space_activity_post` bigint(20) NOT NULL DEFAULT '0',
  `space_total` bigint(20) NOT NULL DEFAULT '0',
  `datetime_created` int(11) NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) NOT NULL DEFAULT '0',
  `created_employee_id` int(11) NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.employee_space: ~10 rows (approximately)
/*!40000 ALTER TABLE `employee_space` DISABLE KEYS */;
INSERT INTO `employee_space` (`id`, `company_id`, `employee_id`, `space_project`, `space_task`, `space_calendar`, `space_annoucement`, `space_statergy_map`, `space_kpi`, `space_employee`, `space_contract`, `space_subject`, `space_activity_post`, `space_total`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 32, 24, 6766817, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6766817, 1460192720, 1460434734, 24, 24, b'0'),
	(2, 1, 22, 5279356, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5279356, 1460435171, 1461129961, 22, 22, b'0'),
	(3, 1, 20, 4366512, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4366512, 1460897200, 1460967045, 20, 20, b'0'),
	(4, 2, 21, 20224448, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20224448, 1460940641, 1461350392, 21, 21, b'0'),
	(5, 1, 16, 6196, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6196, 1460942520, 1460943325, 16, 16, b'0'),
	(6, 1, 17, 474879, 0, 0, 0, 0, 0, 0, 0, 0, 0, 474879, 1460943582, 1460944281, 17, 17, b'0'),
	(7, 1, 13, 21382858, 0, 0, 0, 0, 0, 0, 0, 0, 0, 21382858, 1460963353, 1461349941, 13, 13, b'0'),
	(8, 2, 22, 24662694, 0, 0, 0, 0, 0, 0, 0, 0, 0, 24662694, 1461168668, 1461350137, 22, 22, b'0'),
	(9, 1, 19, 19368688, 0, 0, 0, 0, 0, 0, 0, 0, 0, 19368688, 1461348462, 1461348462, 19, 19, b'0'),
	(10, 1, 14, 11906943, 0, 0, 0, 0, 0, 0, 0, 0, 0, 11906943, 1461350646, 1461350647, 14, 14, b'0');
/*!40000 ALTER TABLE `employee_space` ENABLE KEYS */;


-- Dumping structure for table centeroffice.event
CREATE TABLE IF NOT EXISTS `event` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `calendar_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` text COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `end_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `is_public` bit(1) NOT NULL DEFAULT b'1',
  `color` char(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '3b91ad',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `calendar_id` (`calendar_id`),
  KEY `employee_id` (`employee_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.event: ~0 rows (approximately)
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;


-- Dumping structure for table centeroffice.event_confirmation
CREATE TABLE IF NOT EXISTS `event_confirmation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `event_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `confirm_event_id` int(11) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `employee_id` (`employee_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.event_confirmation: ~0 rows (approximately)
/*!40000 ALTER TABLE `event_confirmation` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_confirmation` ENABLE KEYS */;


-- Dumping structure for table centeroffice.file
CREATE TABLE IF NOT EXISTS `file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_id` bigint(20) unsigned NOT NULL,
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_object` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `encoded_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `is_image` bit(1) NOT NULL DEFAULT b'0',
  `file_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_size` int(11) unsigned DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_object` (`owner_object`),
  KEY `encoded_name` (`encoded_name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.file: ~231 rows (approximately)
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
INSERT INTO `file` (`id`, `company_id`, `owner_id`, `employee_id`, `owner_object`, `name`, `encoded_name`, `path`, `is_image`, `file_type`, `file_size`, `lastup_datetime`, `datetime_created`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 32, 9, 24, 'project', 'Copy (3) of New Stories (Highway Blues).wma', '', '9/9_Copy (3) of New Stories (Highway Blues).wma', b'0', 'wma', 760748, 1460192720, 1460192720, 24, 24, b'0'),
	(2, 32, 9, 24, 'project', 'Copy of New Stories (Highway Blues).wma', '', '9/9_Copy of New Stories (Highway Blues).wma', b'0', 'wma', 760748, 1460192720, 1460192720, 24, 24, b'0'),
	(3, 32, 9, 24, 'project', 'New Stories (Highway Blues).wma', '', '9/9_New Stories (Highway Blues).wma', b'0', 'wma', 760748, 1460192720, 1460192720, 24, 24, b'0'),
	(4, 1, 12, 24, 'project', 'New Stories (Highway Blues).wma', '5ffbc8c21e2ac1a27c87171ac0c6f9fe.wma', '2016\\04\\5ffbc8c21e2ac1a27c87171ac0c6f9fe.wma', b'0', 'wma', 760748, 1460432558, 1460432558, 24, 24, b'0'),
	(5, 1, 12, 24, 'project', 'Copy (4) of New Stories (Highway Blues).wma', 'a88a0d315fab8d1ff49c049e4c6a4bde.wma', '2016\\04\\a88a0d315fab8d1ff49c049e4c6a4bde.wma', b'0', 'wma', 760748, 1460432558, 1460432558, 24, 24, b'0'),
	(6, 1, 12, 24, 'project', 'Copy (3) of New Stories (Highway Blues).wma', 'a88a0d315fab8d1ff49c049e4c6a4bde.wma', '2016\\04\\a88a0d315fab8d1ff49c049e4c6a4bde.wma', b'0', 'wma', 760748, 1460432558, 1460432558, 24, 24, b'0'),
	(7, 1, 12, 24, 'project', 'Copy (2) of New Stories (Highway Blues).wma', '0ca3709722bb91c1cdcd4a52b1837f76.wma', '2016\\04\\0ca3709722bb91c1cdcd4a52b1837f76.wma', b'0', 'wma', 760748, 1460432558, 1460432558, 24, 24, b'0'),
	(8, 1, 12, 24, 'project', 'Beethoven\'s Symphony No. 9 (Scherzo).mp3', 'ba34b4157f7e97c63defd89c363bf734.mp3', '2016\\04\\ba34b4157f7e97c63defd89c363bf734.mp3', b'0', 'mp3', 613638, 1460432558, 1460432558, 24, 24, b'0'),
	(9, 1, 13, 24, 'project', 'New Stories (Highway Blues).wma', '1beb233de4fc2b51d7632cf4b484eff5.wma', '2016\\04\\1beb233de4fc2b51d7632cf4b484eff5.wma', b'0', 'wma', 760748, 1460434275, 1460434275, 24, 24, b'0'),
	(10, 1, 14, 24, 'project', 'test same file name.txt', 'ebd2981def4704eb2f0445dff6a14674.txt', '2016\\04\\ebd2981def4704eb2f0445dff6a14674.txt', b'0', 'txt', 2494, 1460434733, 1460434733, 24, 24, b'0'),
	(11, 1, 14, 24, 'project', 'test same file name.txt', 'a2888b32b3b9a7ab4387041061103166.txt', '2016\\04\\a2888b32b3b9a7ab4387041061103166.txt', b'0', 'txt', 2494, 1460434734, 1460434734, 24, 24, b'0'),
	(12, 1, 14, 24, 'project', 'test same file name.txt', 'aa22d8791ff557686a3fd57ead0ff694.txt', '2016\\04\\aa22d8791ff557686a3fd57ead0ff694.txt', b'0', 'txt', 2494, 1460434734, 1460434734, 24, 24, b'0'),
	(13, 1, 14, 24, 'project', 'https___transhop.kiotvi99et.pdf', 'aa22d8791ff557686a3fd57ead0ff694.pdf', '2016\\04\\aa22d8791ff557686a3fd57ead0ff694.pdf', b'0', 'pdf', 59713, 1460434734, 1460434734, 24, 24, b'0'),
	(14, 1, 15, 22, 'project', 'VPProjects.rar', 'a11361c798931e40d9e1efa5de533357.rar', '2016\\04\\a11361c798931e40d9e1efa5de533357.rar', b'0', 'rar', 4749359, 1460435171, 1460435171, 22, 22, b'0'),
	(15, 1, 16, 22, 'project', 'transhop.kiotviet.vn-Sale.mdi', 'be4b1eebf9b6d83a3725a92d89c1eab9.mdi', '2016\\04\\be4b1eebf9b6d83a3725a92d89c1eab9.mdi', b'0', 'mdi', 11456, 1460437527, 1460437527, 22, 22, b'0'),
	(16, 1, 16, 22, 'project', 'Book1.xls', '77a387f45d3bffef034b4202e022ef07.xls', '2016\\04\\77a387f45d3bffef034b4202e022ef07.xls', b'0', 'xls', 19456, 1460437527, 1460437527, 22, 22, b'0'),
	(17, 1, 16, 22, 'project', 'Book1.xls', '77a387f45d3bffef034b4202e022ef07.xls', '2016\\04\\77a387f45d3bffef034b4202e022ef07.xls', b'0', 'xls', 19456, 1460437527, 1460437527, 22, 22, b'0'),
	(18, 1, 16, 22, 'project', 'Book1.xls', '77a387f45d3bffef034b4202e022ef07.xls', '2016\\04\\77a387f45d3bffef034b4202e022ef07.xls', b'0', 'xls', 19456, 1460437527, 1460437527, 22, 22, b'0'),
	(19, 1, 16, 22, 'project', 'Book1.xls', '77a387f45d3bffef034b4202e022ef07.xls', '2016\\04\\77a387f45d3bffef034b4202e022ef07.xls', b'0', 'xls', 19456, 1460437527, 1460437527, 22, 22, b'0'),
	(20, 1, 17, 22, 'project', 'transhop.kiotviet.vn-Sale.mdi', 'b3d41fd129f3631deb185a8ed7b7317c.mdi', '2016\\04\\b3d41fd129f3631deb185a8ed7b7317c.mdi', b'0', 'mdi', 11456, 1460437572, 1460437572, 22, 22, b'0'),
	(21, 1, 17, 22, 'project', 'Book1.xls', 'c2bec2a0d49e9bea196d60966356879c.xls', '2016\\04\\c2bec2a0d49e9bea196d60966356879c.xls', b'0', 'xls', 19456, 1460437572, 1460437572, 22, 22, b'0'),
	(22, 1, 17, 22, 'project', 'Book1.xls', 'c2bec2a0d49e9bea196d60966356879c.xls', '2016\\04\\c2bec2a0d49e9bea196d60966356879c.xls', b'0', 'xls', 19456, 1460437572, 1460437572, 22, 22, b'0'),
	(23, 1, 17, 22, 'project', 'Book1.xls', 'f5e63efafb21b169bb843cf42e4e520f.xls', '2016\\04\\f5e63efafb21b169bb843cf42e4e520f.xls', b'0', 'xls', 19456, 1460437572, 1460437572, 22, 22, b'0'),
	(24, 1, 17, 22, 'project', 'Book1.xls', 'd815d58b9f1d3a4183e9e9a0cce64517.xls', '2016\\04\\d815d58b9f1d3a4183e9e9a0cce64517.xls', b'0', 'xls', 19456, 1460437572, 1460437572, 22, 22, b'0'),
	(25, 1, 18, 22, 'project', 'transhop.kiotviet.vn-Sale.mdi', '67a048cc4b638a582bb5eeac0a73a3ac.mdi', '2016\\04\\67a048cc4b638a582bb5eeac0a73a3ac.mdi', b'0', 'mdi', 11456, 1460437607, 1460437607, 22, 22, b'0'),
	(26, 1, 18, 22, 'project', 'Book1.xls', '34d58d6e51081ef6210818032b29f4ee.xls', '2016\\04\\34d58d6e51081ef6210818032b29f4ee.xls', b'0', 'xls', 19456, 1460437607, 1460437607, 22, 22, b'0'),
	(27, 1, 18, 22, 'project', 'Book1.xls', '58ea11ecf460bac793ff92a3bcbbbb02.xls', '2016\\04\\58ea11ecf460bac793ff92a3bcbbbb02.xls', b'0', 'xls', 19456, 1460437607, 1460437607, 22, 22, b'0'),
	(28, 1, 18, 22, 'project', 'Book1.xls', '36dd474c734b90919306d360e31a7c99.xls', '2016\\04\\36dd474c734b90919306d360e31a7c99.xls', b'0', 'xls', 19456, 1460437607, 1460437607, 22, 22, b'0'),
	(29, 1, 18, 22, 'project', 'Book1.xls', '36dd474c734b90919306d360e31a7c99.xls', '2016\\04\\36dd474c734b90919306d360e31a7c99.xls', b'0', 'xls', 19456, 1460437607, 1460437607, 22, 22, b'0'),
	(30, 1, 19, 22, 'project', 'transhop.kiotviet.vn-Sale.mdi', '42773dc37214d0f86c9fca227e97cae2.mdi', '2016\\04\\42773dc37214d0f86c9fca227e97cae2.mdi', b'0', 'mdi', 11456, 1460438032, 1460438032, 22, 22, b'0'),
	(31, 1, 19, 22, 'project', 'test same file name.txt', '200c08a8487a5f0c30f6c5e375c19e8b.txt', '2016\\04\\200c08a8487a5f0c30f6c5e375c19e8b.txt', b'0', 'txt', 2494, 1460438032, 1460438032, 22, 22, b'0'),
	(32, 1, 19, 22, 'project', 'test same file name.txt', '200c08a8487a5f0c30f6c5e375c19e8b.txt', '2016\\04\\200c08a8487a5f0c30f6c5e375c19e8b.txt', b'0', 'txt', 2494, 1460438032, 1460438032, 22, 22, b'0'),
	(33, 1, 19, 22, 'project', 'test same file name.txt', '776bc6176b6b889f9efea69fa6b17dbb.txt', '2016\\04\\776bc6176b6b889f9efea69fa6b17dbb.txt', b'0', 'txt', 2494, 1460438032, 1460438032, 22, 22, b'0'),
	(34, 1, 19, 22, 'project', 'transhop.kiotviet.vn-Sale.mdi', '776bc6176b6b889f9efea69fa6b17dbb.mdi', '2016\\04\\776bc6176b6b889f9efea69fa6b17dbb.mdi', b'0', 'mdi', 11456, 1460438032, 1460438032, 22, 22, b'0'),
	(35, 1, 20, 22, 'project', 'transhop.kiotviet.vn-Sale.mdi', '8425aaa83d39c8b1ea74d85924eb91e5.mdi', '2016\\04\\8425aaa83d39c8b1ea74d85924eb91e5.mdi', b'0', 'mdi', 11456, 1460438530, 1460438530, 22, 22, b'0'),
	(36, 1, 20, 22, 'project', 'transhop.kiotviet.vn-Sale.mdi', 'f45b6c4b1bb9bd3af396da2e38655ff0.mdi', '2016\\04\\f45b6c4b1bb9bd3af396da2e38655ff0.mdi', b'0', 'mdi', 11456, 1460438530, 1460438530, 22, 22, b'0'),
	(37, 1, 20, 22, 'project', 'transhop.kiotviet.vn-Sale.mdi', 'edcbf3bf273bb22ab9a4d06048f08303.mdi', '2016\\04\\edcbf3bf273bb22ab9a4d06048f08303.mdi', b'0', 'mdi', 11456, 1460438530, 1460438530, 22, 22, b'0'),
	(38, 1, 21, 22, 'project', 'Book1.xls', '00a0be60c9e35a837aa96bb19a362b3c.xls', '2016\\04\\00a0be60c9e35a837aa96bb19a362b3c.xls', b'0', 'xls', 19456, 1460438955, 1460438955, 22, 22, b'0'),
	(39, 1, 21, 22, 'project', 'test same file name.txt', 'e4b130e182c4bb8a314b6c8706776019.txt', '2016\\04\\e4b130e182c4bb8a314b6c8706776019.txt', b'0', 'txt', 2494, 1460438955, 1460438955, 22, 22, b'0'),
	(40, 1, 21, 22, 'project', 'test same file name.txt', 'c2026c01737539c167b6ae5e2ebbd4cb.txt', '2016\\04\\c2026c01737539c167b6ae5e2ebbd4cb.txt', b'0', 'txt', 2494, 1460438955, 1460438955, 22, 22, b'0'),
	(41, 1, 21, 22, 'project', 'Book1.xls', 'c2026c01737539c167b6ae5e2ebbd4cb.xls', '2016\\04\\c2026c01737539c167b6ae5e2ebbd4cb.xls', b'0', 'xls', 19456, 1460438955, 1460438955, 22, 22, b'0'),
	(42, 1, 23, 20, 'project', '_administrator_2015_3_Plan.xlsx', '87ee969d9ed11f5ded029380e38a4155.xlsx', '2016\\04\\87ee969d9ed11f5ded029380e38a4155.xlsx', b'0', 'xlsx', 14807, 1460897200, 1460897200, 20, 20, b'0'),
	(43, 1, 24, 20, 'project', '01-activity-diagram-re.png', '056d1545d557411d95b7840b919b6441.png', '2016\\04\\056d1545d557411d95b7840b919b6441.png', b'1', 'png', 153495, 1460897440, 1460897440, 20, 20, b'0'),
	(44, 1, 24, 20, 'project', '8_voduythanh.doc', '4fb8c5383c4185555acccef143a6f7b5.doc', '2016\\04\\4fb8c5383c4185555acccef143a6f7b5.doc', b'0', 'doc', 3407360, 1460897440, 1460897440, 20, 20, b'0'),
	(45, 1, 24, 20, 'project', 'angular.min (5).js', '0b110855e992f5e2a4cfa1f30401f38c.js', '2016\\04\\0b110855e992f5e2a4cfa1f30401f38c.js', b'0', 'js', 152491, 1460897440, 1460897440, 20, 20, b'0'),
	(46, 1, 24, 20, 'project', 'bia1-141126195009-conversion-gate02.doc', 'a21ddc33007dc9854290be60d43e86fe.doc', '2016\\04\\a21ddc33007dc9854290be60d43e86fe.doc', b'0', 'doc', 430592, 1460897440, 1460897440, 20, 20, b'0'),
	(47, 2, 25, 21, 'project', '5-bieu-hien-cua-nguoi-39.htm', '9e1fa4971905875d6fae4a506ff5255d.htm', '2016\\04\\9e1fa4971905875d6fae4a506ff5255d.htm', b'0', 'htm', 1425, 1460940641, 1460940641, 21, 21, b'0'),
	(48, 2, 25, 21, 'project', 'ico-menu.png', 'aadbf569b21c9679cb69f34f82ecf31b.png', '2016\\04\\aadbf569b21c9679cb69f34f82ecf31b.png', b'1', 'png', 366, 1460940641, 1460940641, 21, 21, b'0'),
	(49, 2, 25, 21, 'project', 'g-ic.png', 'ca818455420f57be5494c1a359ce9090.png', '2016\\04\\ca818455420f57be5494c1a359ce9090.png', b'1', 'png', 1712, 1460940641, 1460940641, 21, 21, b'0'),
	(50, 2, 25, 21, 'project', 'VPProjects.rar', 'b3d1a2b4894f7eef0acaa09a7660a5df.rar', '2016\\04\\b3d1a2b4894f7eef0acaa09a7660a5df.rar', b'0', 'rar', 4749359, 1460940641, 1460940641, 21, 21, b'0'),
	(51, 2, 25, 21, 'project', 'Book1.xls', 'b3e5531bd3bbd3b80bbd6020dbfc912f.xls', '2016\\04\\b3e5531bd3bbd3b80bbd6020dbfc912f.xls', b'0', 'xls', 19456, 1460940641, 1460940641, 21, 21, b'0'),
	(52, 2, 25, 21, 'project', '01-activity-diagram-re.png', 'f3c87f126219e9b7e664e50e74b96c04.png', '2016\\04\\f3c87f126219e9b7e664e50e74b96c04.png', b'1', 'png', 153495, 1460940641, 1460940641, 21, 21, b'0'),
	(53, 2, 25, 21, 'project', '01-activity-diagram-re.png', 'a4256dcab208c7e4be9277f4c78a7817.png', '2016\\04\\a4256dcab208c7e4be9277f4c78a7817.png', b'1', 'png', 153495, 1460940641, 1460940641, 21, 21, b'0'),
	(54, 2, 25, 21, 'project', '01-activity-diagram-re.png', '46e4687cb9a8e17d4d28099cbee1fa23.png', '2016\\04\\46e4687cb9a8e17d4d28099cbee1fa23.png', b'1', 'png', 153495, 1460940641, 1460940641, 21, 21, b'0'),
	(55, 2, 25, 21, 'project', '01-activity-diagram-re.png', '2f534bb8f410a9f27da72c2ed4081b8d.png', '2016\\04\\2f534bb8f410a9f27da72c2ed4081b8d.png', b'1', 'png', 153495, 1460940641, 1460940641, 21, 21, b'0'),
	(56, 2, 25, 21, 'project', '01-activity-diagram-re.png', '9242500c24c0a24f4745388811dbf754.png', '2016\\04\\9242500c24c0a24f4745388811dbf754.png', b'1', 'png', 153495, 1460940641, 1460940641, 21, 21, b'0'),
	(57, 2, 25, 21, 'project', '01-activity-diagram-re.png', 'e6ae7aff3a38f972c6fe974ed05ebb1c.png', '2016\\04\\e6ae7aff3a38f972c6fe974ed05ebb1c.png', b'1', 'png', 153495, 1460940641, 1460940641, 21, 21, b'0'),
	(58, 2, 25, 21, 'project', 'angular.min (4).js', 'f4016f2674c2c0463e01f0bb2177acde.js', '2016\\04\\f4016f2674c2c0463e01f0bb2177acde.js', b'0', 'js', 148199, 1460940641, 1460940641, 21, 21, b'0'),
	(59, 2, 25, 21, 'project', 'angular.min (5).js', 'ca9bd53cb66f9a379b4c7bc8ba585395.js', '2016\\04\\ca9bd53cb66f9a379b4c7bc8ba585395.js', b'0', 'js', 152491, 1460940641, 1460940641, 21, 21, b'0'),
	(60, 2, 25, 21, 'project', 'angular.min (6).js', 'f47ae2e2aee9940850c50fbcce665e10.js', '2016\\04\\f47ae2e2aee9940850c50fbcce665e10.js', b'0', 'js', 152491, 1460940641, 1460940641, 21, 21, b'0'),
	(61, 2, 25, 21, 'project', 'angular.min (7).js', '7d3d290c2c663a2babfd5e1fefcc0c5f.js', '2016\\04\\7d3d290c2c663a2babfd5e1fefcc0c5f.js', b'0', 'js', 108238, 1460940641, 1460940641, 21, 21, b'0'),
	(62, 2, 25, 21, 'project', 'check box.doc', '4ebf7bd2159fcedc0523d3f5c1038a85.doc', '2016\\04\\4ebf7bd2159fcedc0523d3f5c1038a85.doc', b'0', 'doc', 54272, 1460940641, 1460940641, 21, 21, b'0'),
	(63, 2, 25, 21, 'project', 'gantt-chart_L(1).xls', '1f200dd5d5c9f427307d728114ae92c4.xls', '2016\\04\\1f200dd5d5c9f427307d728114ae92c4.xls', b'0', 'xls', 171008, 1460940641, 1460940641, 21, 21, b'0'),
	(64, 2, 25, 21, 'project', 'CANHAN_THANG_8_2015.xls', 'e76558cb89c690ec1a7f982a93b7fd44.xls', '2016\\04\\e76558cb89c690ec1a7f982a93b7fd44.xls', b'0', 'xls', 3859, 1460940641, 1460940641, 21, 21, b'0'),
	(65, 2, 25, 21, 'project', '.travis.yml', 'af1c33e481b34ff672761a0b903fc8c3.yml', '2016\\04\\af1c33e481b34ff672761a0b903fc8c3.yml', b'0', 'yml', 234, 1460940641, 1460940641, 21, 21, b'0'),
	(66, 2, 25, 21, 'project', 'CONTRIBUTING.md', '0af9351ed79390db4d4abb293e8406b4.md', '2016\\04\\0af9351ed79390db4d4abb293e8406b4.md', b'0', 'md', 430, 1460940641, 1460940641, 21, 21, b'0'),
	(67, 1, 26, 16, 'project', 'bower.json', 'ae74fc85378e1e4bbb26cc109c4c83e5.json', '2016\\04\\ae74fc85378e1e4bbb26cc109c4c83e5.json', b'0', 'json', 382, 1460942520, 1460942520, 16, 16, b'0'),
	(68, 1, 26, 16, 'project', '.travis.yml', '7e301eb0c453fd1304db1883c85e5dc3.yml', '2016\\04\\7e301eb0c453fd1304db1883c85e5dc3.yml', b'0', 'yml', 234, 1460942520, 1460942520, 16, 16, b'0'),
	(69, 1, 26, 16, 'project', '.travis.yml', '12a6907b88218a872ed4e5a1434f7eb3.yml', '2016\\04\\12a6907b88218a872ed4e5a1434f7eb3.yml', b'0', 'yml', 234, 1460942521, 1460942521, 16, 16, b'0'),
	(70, 1, 26, 16, 'project', '.travis.yml', 'c0b2a3d8a2a8a4637c06ccf0ff7a1e7a.yml', '2016\\04\\c0b2a3d8a2a8a4637c06ccf0ff7a1e7a.yml', b'0', 'yml', 234, 1460942521, 1460942521, 16, 16, b'0'),
	(71, 1, 26, 16, 'project', '.jshintrc', '5a55f05a41be50ab30a2b7feebf19286.jshintrc', '2016\\04\\5a55f05a41be50ab30a2b7feebf19286.jshintrc', b'0', 'jshintrc', 176, 1460942521, 1460942521, 16, 16, b'0'),
	(72, 1, 26, 16, 'project', 'package.json', '87e2ebc8024cff8ba61d7f67057b233d.json', '2016\\04\\87e2ebc8024cff8ba61d7f67057b233d.json', b'0', 'json', 755, 1460942521, 1460942521, 16, 16, b'0'),
	(73, 1, 26, 16, 'project', 'package.json', '61d6e2598ef20e89fbba5125da2102ca.json', '2016\\04\\61d6e2598ef20e89fbba5125da2102ca.json', b'0', 'json', 755, 1460942521, 1460942521, 16, 16, b'0'),
	(74, 1, 26, 16, 'project', 'CONTRIBUTING.md', 'fc230a0e36a762115230f8195cda78e7.md', '2016\\04\\fc230a0e36a762115230f8195cda78e7.md', b'0', 'md', 430, 1460942521, 1460942521, 16, 16, b'0'),
	(75, 1, 27, 16, 'project', '.travis.yml', 'eb2a2932602358093c7d8f2d5be68e8b.yml', '1\\2016\\2016\\eb2a2932602358093c7d8f2d5be68e8b.yml', b'0', 'yml', 234, 1460943325, 1460943325, 16, 16, b'0'),
	(76, 1, 27, 16, 'project', '.travis.yml', '5aa2ca22f5928df7b96b7f4b08c18470.yml', '1\\2016\\2016\\5aa2ca22f5928df7b96b7f4b08c18470.yml', b'0', 'yml', 234, 1460943325, 1460943325, 16, 16, b'0'),
	(77, 1, 27, 16, 'project', 'CONTRIBUTING.md', 'bcc499dd7fc2b11f6e5d7dcc5d69d7c1.md', '1\\2016\\2016\\bcc499dd7fc2b11f6e5d7dcc5d69d7c1.md', b'0', 'md', 430, 1460943325, 1460943325, 16, 16, b'0'),
	(78, 1, 27, 16, 'project', 'package.json', 'af899de8e67245cb3d57fe791e5d28ea.json', '1\\2016\\2016\\af899de8e67245cb3d57fe791e5d28ea.json', b'0', 'json', 755, 1460943325, 1460943325, 16, 16, b'0'),
	(79, 1, 27, 16, 'project', 'LICENSE', 'db637bd21c6bfb0bfab169335809060c.LICENSE', '1\\2016\\2016\\db637bd21c6bfb0bfab169335809060c.LICENSE', b'0', 'LICENSE', 1109, 1460943325, 1460943325, 16, 16, b'0'),
	(80, 1, 27, 16, 'project', '.travis.yml', 'bc44bec47d81e3201992acf300335826.yml', '1\\2016\\2016\\bc44bec47d81e3201992acf300335826.yml', b'0', 'yml', 234, 1460943325, 1460943325, 16, 16, b'0'),
	(81, 1, 28, 17, 'project', 'bower.json', 'cfa11e06627b05d74f31b87357e4f7fd.json', '1\\2016\\2016\\cfa11e06627b05d74f31b87357e4f7fd.json', b'0', 'json', 227, 1460943582, 1460943582, 17, 17, b'0'),
	(82, 1, 28, 17, 'project', 'bower.json', '5024afd17ba569af8bf4762aa3352d9c.json', '1\\2016\\2016\\5024afd17ba569af8bf4762aa3352d9c.json', b'0', 'json', 227, 1460943582, 1460943582, 17, 17, b'0'),
	(83, 1, 28, 17, 'project', 'app.js', 'b2e193fcd8071e540d10b718ef66bbdc.js', '1\\2016\\2016\\b2e193fcd8071e540d10b718ef66bbdc.js', b'0', 'js', 3447, 1460943582, 1460943582, 17, 17, b'0'),
	(84, 1, 28, 17, 'project', 'app.js', 'af4ce422d50747cd7c4e134d532f97a5.js', '1\\2016\\2016\\af4ce422d50747cd7c4e134d532f97a5.js', b'0', 'js', 3447, 1460943582, 1460943582, 17, 17, b'0'),
	(85, 1, 28, 17, 'project', 'index.html', '8202dfa2af27c5b4888c314ecebb7946.html', '1\\2016\\2016\\8202dfa2af27c5b4888c314ecebb7946.html', b'0', 'html', 7081, 1460943582, 1460943582, 17, 17, b'0'),
	(86, 1, 28, 17, 'project', 'index.html', '108ea9a112578116ca73965ae29bc8ba.html', '1\\2016\\2016\\108ea9a112578116ca73965ae29bc8ba.html', b'0', 'html', 7081, 1460943582, 1460943582, 17, 17, b'0'),
	(87, 1, 29, 17, 'project', 'styles.css', 'a221cf715be00dacaf4e3d83d6b52232.css', '1\\2016\\04\\a221cf715be00dacaf4e3d83d6b52232.css', b'0', 'css', 46, 1460943701, 1460943701, 17, 17, b'0'),
	(88, 1, 29, 17, 'project', 'index.html', '248b07fe5bb9a54859819f773596f275.html', '1\\2016\\04\\248b07fe5bb9a54859819f773596f275.html', b'0', 'html', 2754, 1460943701, 1460943701, 17, 17, b'0'),
	(89, 1, 29, 17, 'project', 'index.html', '1ca93074f59a7ddbb135b954d7357269.html', '1\\2016\\04\\1ca93074f59a7ddbb135b954d7357269.html', b'0', 'html', 2754, 1460943701, 1460943701, 17, 17, b'0'),
	(90, 1, 30, 17, 'project', 'select2Spec.js', 'd29259b430eb0bb9949be769b5b47a2a.js', '1\\2016\\04\\d29259b430eb0bb9949be769b5b47a2a.js', b'0', 'js', 17054, 1460944015, 1460944015, 17, 17, b'0'),
	(91, 1, 30, 17, 'project', 'karma.conf.js', '8d99e37488afb8a1a84777225324de69.js', '1\\2016\\04\\8d99e37488afb8a1a84777225324de69.js', b'0', 'js', 1730, 1460944015, 1460944015, 17, 17, b'0'),
	(92, 1, 31, 17, 'project', 'angular.min (6).js', '8546d977d204e841fee05bd717916548.js', '1\\2016\\04\\8546d977d204e841fee05bd717916548.js', b'0', 'js', 152491, 1460944167, 1460944167, 17, 17, b'0'),
	(93, 1, 31, 17, 'project', 'angular.min (7).js', '243148a90e1ae6a0b03f6f2dad4a47f2.js', '1\\2016\\04\\243148a90e1ae6a0b03f6f2dad4a47f2.js', b'0', 'js', 108238, 1460944167, 1460944167, 17, 17, b'0'),
	(94, 1, 32, 17, 'project', '_administrator_2015_3_Plan.xlsx', '11a8f27b1645ad8f634647104100ece2.xlsx', '1\\2016\\04\\11a8f27b1645ad8f634647104100ece2.xlsx', b'0', 'xlsx', 14807, 1460944281, 1460944281, 17, 17, b'0'),
	(95, 1, 32, 17, 'project', '01-activity-diagram-re.png', 'e95f45fbce4aa8aa65a02d6ba4f78b74.png', '1\\2016\\04\\e95f45fbce4aa8aa65a02d6ba4f78b74.png', b'1', 'png', 153495, 1460944281, 1460944281, 17, 17, b'0'),
	(96, 2, 33, 21, 'project', '01-activity-diagram-re.png', '27a9ea4767b9a08bc226a3eaa14f76c4.png', '2\\2016\\04\\27a9ea4767b9a08bc226a3eaa14f76c4.png', b'1', 'png', 153495, 1460962410, 1460962410, 21, 21, b'0'),
	(97, 2, 33, 21, 'project', 'angular.min (7).js', 'de753654d03e041b7e423059f3c593b5.js', '2\\2016\\04\\de753654d03e041b7e423059f3c593b5.js', b'0', 'js', 108238, 1460962410, 1460962410, 21, 21, b'0'),
	(98, 2, 33, 21, 'project', 'btford-angular-socket-io-seed-76f22c6.zip', 'a0cbc5588d4bb81d71313ceb5a1d550d.zip', '2\\2016\\04\\a0cbc5588d4bb81d71313ceb5a1d550d.zip', b'0', 'zip', 396605, 1460962410, 1460962410, 21, 21, b'0'),
	(99, 2, 34, 21, 'project', '01-activity-diagram-re.png', '24232c158d819f5018071131c0ca2e84.png', '2\\2016\\04\\24232c158d819f5018071131c0ca2e84.png', b'1', 'png', 153495, 1460962572, 1460962572, 21, 21, b'0'),
	(100, 2, 34, 21, 'project', 'angular.min (7).js', '6d9af3d650bbbbd1bbeff44e0b65c95f.js', '2\\2016\\04\\6d9af3d650bbbbd1bbeff44e0b65c95f.js', b'0', 'js', 108238, 1460962572, 1460962572, 21, 21, b'0'),
	(101, 2, 34, 21, 'project', 'bia1-141126195009-conversion-gate02.doc', '377b047752904dd73d6aa548d56f58ad.doc', '2\\2016\\04\\377b047752904dd73d6aa548d56f58ad.doc', b'0', 'doc', 430592, 1460962572, 1460962572, 21, 21, b'0'),
	(102, 1, 35, 13, 'project', '_administrator_2015_3_Plan.xlsx', 'a727315e09d0d95e5cec7e7ae87f7d18.xlsx', '1\\2016\\04\\a727315e09d0d95e5cec7e7ae87f7d18.xlsx', b'0', 'xlsx', 14807, 1460963353, 1460963353, 13, 13, b'0'),
	(103, 1, 35, 13, 'project', 'angular-adminlte-master.zip', '6de8af358131f819c8d84c0717d4c786.zip', '1\\2016\\04\\6de8af358131f819c8d84c0717d4c786.zip', b'0', 'zip', 156695, 1460963353, 1460963353, 13, 13, b'0'),
	(104, 1, 36, 13, 'project', 'bia1-141126195009-conversion-gate02.doc', 'e0648ea7a0272767d6c11fb0c156e9fc.doc', '1\\2016\\04\\e0648ea7a0272767d6c11fb0c156e9fc.doc', b'0', 'doc', 430592, 1460963619, 1460963619, 13, 13, b'0'),
	(105, 1, 37, 13, 'project', '01-activity-diagram-re.png', 'da00f3a9e5936bec5560649222a225bf.png', '1\\2016\\04\\da00f3a9e5936bec5560649222a225bf.png', b'1', 'png', 153495, 1460963676, 1460963676, 13, 13, b'0'),
	(106, 1, 38, 20, 'project', '01-activity-diagram-re.png', '0b4d2fdeb13c4b7629c7dcd261cff9b2.png', '1\\2016\\04\\0b4d2fdeb13c4b7629c7dcd261cff9b2.png', b'1', 'png', 153495, 1460967045, 1460967045, 20, 20, b'0'),
	(107, 1, 38, 20, 'project', 'check box.doc', '19df75c30d954c1d90e276b28e354fd4.doc', '1\\2016\\04\\19df75c30d954c1d90e276b28e354fd4.doc', b'0', 'doc', 54272, 1460967045, 1460967045, 20, 20, b'0'),
	(108, 2, 65, 22, 'project', '01-activity-diagram-re.png', 'f3151768e6150b1088c6592bd391935e.png', '2016\\04\\f3151768e6150b1088c6592bd391935e.png', b'1', 'png', 153495, 1461129961, 1461129961, 22, 22, b'0'),
	(109, 1, 74, 13, 'project', '_administrator_2015_3_Plan.xlsx', 'a908974601d27875502297e914457172.xlsx', '2016\\04\\a908974601d27875502297e914457172.xlsx', b'0', 'xlsx', 14807, 1461137909, 1461137909, 13, 13, b'0'),
	(110, 2, 77, 22, 'project', '_administrator_2015_3_Plan.xlsx', '39ce122b390d8e10abd6180a7a291b9a.xlsx', '2\\2016\\04\\39ce122b390d8e10abd6180a7a291b9a.xlsx', b'0', 'xlsx', 14807, 1461168668, 1461168668, 22, 22, b'0'),
	(111, 2, 77, 22, 'project', '8_voduythanh.doc', 'f329255e0aacb6966d84e94128605bc4.doc', '2\\2016\\04\\f329255e0aacb6966d84e94128605bc4.doc', b'0', 'doc', 3407360, 1461168668, 1461168668, 22, 22, b'0'),
	(112, 2, 77, 22, 'project', '01-activity-diagram-re.png', '419f7c1ecffb754a441f9fab0f3ee5c1.png', '2\\2016\\04\\419f7c1ecffb754a441f9fab0f3ee5c1.png', b'1', 'png', 153495, 1461168668, 1461168668, 22, 22, b'0'),
	(113, 2, 77, 22, 'project', 'angular.min (6).js', '9be6eb355d78aba9b3b7acd8081bbcd8.js', '2\\2016\\04\\9be6eb355d78aba9b3b7acd8081bbcd8.js', b'0', 'js', 152491, 1461168668, 1461168668, 22, 22, b'0'),
	(114, 2, 77, 22, 'project', 'angular.min (4).js', 'a9ba9c0c13739018fe1c35740f8107cc.js', '2\\2016\\04\\a9ba9c0c13739018fe1c35740f8107cc.js', b'0', 'js', 148199, 1461168668, 1461168668, 22, 22, b'0'),
	(115, 2, 77, 22, 'project', 'angular.min (5).js', '0263d4fb85f3435cdee7b169d0b5af91.js', '2\\2016\\04\\0263d4fb85f3435cdee7b169d0b5af91.js', b'0', 'js', 152491, 1461168668, 1461168668, 22, 22, b'0'),
	(116, 2, 77, 22, 'project', 'angular.min (6).js', '3d99d6673233961f2e6f205200d78420.js', '2\\2016\\04\\3d99d6673233961f2e6f205200d78420.js', b'0', 'js', 152491, 1461168668, 1461168668, 22, 22, b'0'),
	(117, 2, 77, 22, 'project', 'angular.min (7).js', 'a97908e7d607ac58e30642d14705aee2.js', '2\\2016\\04\\a97908e7d607ac58e30642d14705aee2.js', b'0', 'js', 108238, 1461168668, 1461168668, 22, 22, b'0'),
	(118, 2, 77, 22, 'project', '22989470.png', '19a22ff0e0f668d3678fad168d6b37da.png', '2\\2016\\04\\19a22ff0e0f668d3678fad168d6b37da.png', b'1', 'png', 230141, 1461168668, 1461168668, 22, 22, b'0'),
	(119, 2, 77, 22, 'project', 'angular.min (4).js', 'd904ebb7a04e78f486d78279f7fde75a.js', '2\\2016\\04\\d904ebb7a04e78f486d78279f7fde75a.js', b'0', 'js', 148199, 1461168668, 1461168668, 22, 22, b'0'),
	(120, 2, 77, 22, 'project', 'angular.min (5).js', '6eb44c76e130c602f5e661a9c56f7f14.js', '2\\2016\\04\\6eb44c76e130c602f5e661a9c56f7f14.js', b'0', 'js', 152491, 1461168668, 1461168668, 22, 22, b'0'),
	(121, 2, 77, 22, 'project', 'angular.min (6).js', '66ffbbd433cc1591930beefde25b9618.js', '2\\2016\\04\\66ffbbd433cc1591930beefde25b9618.js', b'0', 'js', 152491, 1461168668, 1461168668, 22, 22, b'0'),
	(122, 2, 77, 22, 'project', 'angular.min (7).js', '7d60fa02128987eede164a5a72bc5813.js', '2\\2016\\04\\7d60fa02128987eede164a5a72bc5813.js', b'0', 'js', 108238, 1461168668, 1461168668, 22, 22, b'0'),
	(123, 2, 77, 22, 'project', '01-activity-diagram-re.png', '9b14e7c144bbada97df10015d57dbc1c.png', '2\\2016\\04\\9b14e7c144bbada97df10015d57dbc1c.png', b'1', 'png', 153495, 1461168668, 1461168668, 22, 22, b'0'),
	(124, 2, 77, 22, 'project', '01-activity-diagram-re.png', '333627d0c323e53f87a89079bb9e22f4.png', '2\\2016\\04\\333627d0c323e53f87a89079bb9e22f4.png', b'1', 'png', 153495, 1461168668, 1461168668, 22, 22, b'0'),
	(125, 2, 77, 22, 'project', '01-activity-diagram-re.png', '0d203265f893f5ce3a53fb8ab3a053e1.png', '2\\2016\\04\\0d203265f893f5ce3a53fb8ab3a053e1.png', b'1', 'png', 153495, 1461168668, 1461168668, 22, 22, b'0'),
	(126, 2, 77, 22, 'project', '01-activity-diagram-re.png', '276776703435c55a6a83adefa8e6f527.png', '2\\2016\\04\\276776703435c55a6a83adefa8e6f527.png', b'1', 'png', 153495, 1461168668, 1461168668, 22, 22, b'0'),
	(127, 2, 77, 22, 'project', '01-activity-diagram-re.png', 'b79197978291d2cafcf7e5ebf6722194.png', '2\\2016\\04\\b79197978291d2cafcf7e5ebf6722194.png', b'1', 'png', 153495, 1461168668, 1461168668, 22, 22, b'0'),
	(128, 2, 77, 22, 'project', '01-activity-diagram-re.png', 'ea4204fc913a30a1d73de1ce290695d9.png', '2\\2016\\04\\ea4204fc913a30a1d73de1ce290695d9.png', b'1', 'png', 153495, 1461168668, 1461168668, 22, 22, b'0'),
	(129, 2, 77, 22, 'project', '01-activity-diagram-re.png', '5242eae57ca2fc8df881559de568fd99.png', '2\\2016\\04\\5242eae57ca2fc8df881559de568fd99.png', b'1', 'png', 153495, 1461168668, 1461168668, 22, 22, b'0'),
	(130, 1, 78, 13, 'project', '8_voduythanh.doc', 'e9d5107e8f3b71d0a7635da427fee2c9.doc', '1\\2016\\04\\e9d5107e8f3b71d0a7635da427fee2c9.doc', b'0', 'doc', 3407360, 1461280058, 1461280058, 13, 13, b'0'),
	(131, 1, 78, 13, 'project', '8_voduythanh.doc', '298b49c0f71bc8d67edc0e1f78a3e2da.doc', '1\\2016\\04\\298b49c0f71bc8d67edc0e1f78a3e2da.doc', b'0', 'doc', 3407360, 1461280058, 1461280058, 13, 13, b'0'),
	(132, 1, 78, 13, 'project', '8_voduythanh.doc', 'c1cf1c821ffcd6c63c723f96dd9e8419.doc', '1\\2016\\04\\c1cf1c821ffcd6c63c723f96dd9e8419.doc', b'0', 'doc', 3407360, 1461280058, 1461280058, 13, 13, b'0'),
	(133, 1, 80, 13, 'project', '8_voduythanh.doc', 'a850497b5ebaf8ffcf9511d4fec1b4fa.doc', '1\\2016\\04\\a850497b5ebaf8ffcf9511d4fec1b4fa.doc', b'0', 'doc', 3407360, 1461299599, 1461299599, 13, 13, b'0'),
	(134, 1, 80, 13, 'project', '8_voduythanh.doc', '97f4798fa44872b3261f0fc724767b8d.doc', '1\\2016\\04\\97f4798fa44872b3261f0fc724767b8d.doc', b'0', 'doc', 3407360, 1461299599, 1461299599, 13, 13, b'0'),
	(135, 1, 80, 13, 'project', '8_voduythanh.doc', '348d6e0ceccca45512203bfb4a25ca50.doc', '1\\2016\\04\\348d6e0ceccca45512203bfb4a25ca50.doc', b'0', 'doc', 3407360, 1461299599, 1461299599, 13, 13, b'0'),
	(136, 1, 82, 19, 'project', '22989470.png', '34a3069860ffb19794c82c16be0b6f23.png', '1\\2016\\04\\34a3069860ffb19794c82c16be0b6f23.png', b'1', 'png', 230141, 1461348462, 1461348462, 19, 19, b'0'),
	(137, 1, 82, 19, 'project', 'AdminLTE-master.zip', 'cc8a037ccfc62d9d855626eb623f9730.zip', '1\\2016\\04\\cc8a037ccfc62d9d855626eb623f9730.zip', b'0', 'zip', 6921391, 1461348462, 1461348462, 19, 19, b'0'),
	(138, 1, 82, 19, 'project', '8_voduythanh.doc', '0f71fc1acc85a91abf5790eda8ca1682.doc', '1\\2016\\04\\0f71fc1acc85a91abf5790eda8ca1682.doc', b'0', 'doc', 3407360, 1461348462, 1461348462, 19, 19, b'0'),
	(139, 1, 82, 19, 'project', '22989470.png', 'f9dfbcd1636b55b2f53f88e2e2303946.png', '1\\2016\\04\\f9dfbcd1636b55b2f53f88e2e2303946.png', b'1', 'png', 230141, 1461348462, 1461348462, 19, 19, b'0'),
	(140, 1, 82, 19, 'project', '01-activity-diagram-re.png', '6a884e4e446298c7973b4e280ef6d6d0.png', '1\\2016\\04\\6a884e4e446298c7973b4e280ef6d6d0.png', b'1', 'png', 153495, 1461348462, 1461348462, 19, 19, b'0'),
	(141, 1, 82, 19, 'project', '01-activity-diagram-re.png', 'bb9f78fc6453ab3c1cec04cd0fa4c8c5.png', '1\\2016\\04\\bb9f78fc6453ab3c1cec04cd0fa4c8c5.png', b'1', 'png', 153495, 1461348462, 1461348462, 19, 19, b'0'),
	(142, 1, 82, 19, 'project', '22989470.png', '73cb0d943e707c5360cf6d5f96049c80.png', '1\\2016\\04\\73cb0d943e707c5360cf6d5f96049c80.png', b'1', 'png', 230141, 1461348462, 1461348462, 19, 19, b'0'),
	(143, 1, 82, 19, 'project', '_administrator_2015_3_Plan.xlsx', '22f45319751bdd59b2b11ca759fe90ef.xlsx', '1\\2016\\04\\22f45319751bdd59b2b11ca759fe90ef.xlsx', b'0', 'xlsx', 14807, 1461348462, 1461348462, 19, 19, b'0'),
	(144, 1, 82, 19, 'project', 'Congviec_lanh_dao_17072015164507.xlsx', '9ea19f1893e09ba8c2832cf9634b0bee.xlsx', '1\\2016\\04\\9ea19f1893e09ba8c2832cf9634b0bee.xlsx', b'0', 'xlsx', 10026, 1461348462, 1461348462, 19, 19, b'0'),
	(145, 1, 82, 19, 'project', '22989470.png', '574303f52fd72a2e4c0447a8d07fb42c.png', '1\\2016\\04\\574303f52fd72a2e4c0447a8d07fb42c.png', b'1', 'png', 230141, 1461348462, 1461348462, 19, 19, b'0'),
	(146, 1, 82, 19, 'project', '01-activity-diagram-re.png', 'a29d484e288096962dbedb7299cb6d5a.png', '1\\2016\\04\\a29d484e288096962dbedb7299cb6d5a.png', b'1', 'png', 153495, 1461348462, 1461348462, 19, 19, b'0'),
	(147, 1, 82, 19, 'project', '01-activity-diagram-re.png', 'fbd127fbb8f8e78d772ab387434d7eb7.png', '1\\2016\\04\\fbd127fbb8f8e78d772ab387434d7eb7.png', b'1', 'png', 153495, 1461348462, 1461348462, 19, 19, b'0'),
	(148, 1, 82, 19, 'project', '01-activity-diagram-re.png', '3e6ba88e65796f61aed8a167030a866b.png', '1\\2016\\04\\3e6ba88e65796f61aed8a167030a866b.png', b'1', 'png', 153495, 1461348462, 1461348462, 19, 19, b'0'),
	(149, 1, 82, 19, 'project', '8_voduythanh.doc', 'f451ba3e65d3a86dea70a242f8298866.doc', '1\\2016\\04\\f451ba3e65d3a86dea70a242f8298866.doc', b'0', 'doc', 3407360, 1461348462, 1461348462, 19, 19, b'0'),
	(150, 1, 82, 19, 'project', '_administrator_2015_3_Plan.xlsx', '1fba877b49155f7b6edb4b63aa7ba198.xlsx', '1\\2016\\04\\1fba877b49155f7b6edb4b63aa7ba198.xlsx', b'0', 'xlsx', 14807, 1461348462, 1461348462, 19, 19, b'0'),
	(151, 1, 82, 19, 'project', 'DanhSachChiTietHoaDon.xlsx', 'f37daed5d6da583fdc463eb1b9d1126e.xlsx', '1\\2016\\04\\f37daed5d6da583fdc463eb1b9d1126e.xlsx', b'0', 'xlsx', 18806, 1461348462, 1461348462, 19, 19, b'0'),
	(152, 1, 82, 19, 'project', '8_voduythanh.doc', '9b5a7c50a7f58c4548a22ee2289b9643.doc', '1\\2016\\04\\9b5a7c50a7f58c4548a22ee2289b9643.doc', b'0', 'doc', 3407360, 1461348462, 1461348462, 19, 19, b'0'),
	(153, 1, 82, 19, 'project', '_administrator_2015_3_Plan.xlsx', '3b207c2c315455a7b2ac8909f754f687.xlsx', '1\\2016\\04\\3b207c2c315455a7b2ac8909f754f687.xlsx', b'0', 'xlsx', 14807, 1461348462, 1461348462, 19, 19, b'0'),
	(154, 1, 82, 19, 'project', '22989470.png', 'e0fdbd790e2b0037435cdf4a7abea137.png', '1\\2016\\04\\e0fdbd790e2b0037435cdf4a7abea137.png', b'1', 'png', 230141, 1461348462, 1461348462, 19, 19, b'0'),
	(155, 1, 82, 19, 'project', 'watch.htm', '5559969e658d3dfb98e94879b4023f09.htm', '1\\2016\\04\\5559969e658d3dfb98e94879b4023f09.htm', b'0', 'htm', 233784, 1461348462, 1461348462, 19, 19, b'0'),
	(156, 1, 83, 13, 'project', '_administrator_2015_3_Plan.xlsx', '08c8be74ee438a9618ce6e73b56a96b1.xlsx', '1\\2016\\04\\08c8be74ee438a9618ce6e73b56a96b1.xlsx', b'0', 'xlsx', 14807, 1461349941, 1461349941, 13, 13, b'0'),
	(157, 1, 83, 13, 'project', '01-activity-diagram-re.png', '5735ea543460fc175321a66ff53580c1.png', '1\\2016\\04\\5735ea543460fc175321a66ff53580c1.png', b'1', 'png', 153495, 1461349941, 1461349941, 13, 13, b'0'),
	(158, 2, 84, 22, 'project', '01-activity-diagram-re.png', '61a4a28ac354c40fc793c9a96e83ea97.png', '2\\2016\\04\\61a4a28ac354c40fc793c9a96e83ea97.png', b'1', 'png', 153495, 1461350137, 1461350137, 22, 22, b'0'),
	(159, 2, 84, 22, 'project', '01-activity-diagram-re.png', '6167666cebbaaa70bd5f5ef477ce4226.png', '2\\2016\\04\\6167666cebbaaa70bd5f5ef477ce4226.png', b'1', 'png', 153495, 1461350137, 1461350137, 22, 22, b'0'),
	(160, 2, 84, 22, 'project', '01-activity-diagram-re.png', 'c8337f52fd99a77d163df90c4d1ba9db.png', '2\\2016\\04\\c8337f52fd99a77d163df90c4d1ba9db.png', b'1', 'png', 153495, 1461350137, 1461350137, 22, 22, b'0'),
	(161, 2, 84, 22, 'project', '8_voduythanh.doc', '04a5edd0f7aa4e010c70adaca815eccc.doc', '2\\2016\\04\\04a5edd0f7aa4e010c70adaca815eccc.doc', b'0', 'doc', 3407360, 1461350137, 1461350137, 22, 22, b'0'),
	(162, 2, 84, 22, 'project', '01-activity-diagram-re.png', '5e3c740d8f5f9a43b16216b204299816.png', '2\\2016\\04\\5e3c740d8f5f9a43b16216b204299816.png', b'1', 'png', 153495, 1461350137, 1461350137, 22, 22, b'0'),
	(163, 2, 84, 22, 'project', '_administrator_2015_3_Plan.xlsx', '91f729145f64f4c38d7968a9c973c2be.xlsx', '2\\2016\\04\\91f729145f64f4c38d7968a9c973c2be.xlsx', b'0', 'xlsx', 14807, 1461350137, 1461350137, 22, 22, b'0'),
	(164, 2, 84, 22, 'project', '01-activity-diagram-re.png', '0ae311bbdefc77ef351562409843f280.png', '2\\2016\\04\\0ae311bbdefc77ef351562409843f280.png', b'1', 'png', 153495, 1461350137, 1461350137, 22, 22, b'0'),
	(165, 2, 84, 22, 'project', '8_voduythanh.doc', '16c40f6f621f278868512e1dcb91730d.doc', '2\\2016\\04\\16c40f6f621f278868512e1dcb91730d.doc', b'0', 'doc', 3407360, 1461350137, 1461350137, 22, 22, b'0'),
	(166, 2, 84, 22, 'project', '01-activity-diagram-re.png', 'e9c72c731863586f4d247cb173c59853.png', '2\\2016\\04\\e9c72c731863586f4d247cb173c59853.png', b'1', 'png', 153495, 1461350137, 1461350137, 22, 22, b'0'),
	(167, 2, 84, 22, 'project', '_administrator_2015_3_Plan.xlsx', 'ab69b9f4e931e846a864b884c0a89dc7.xlsx', '2\\2016\\04\\ab69b9f4e931e846a864b884c0a89dc7.xlsx', b'0', 'xlsx', 14807, 1461350137, 1461350137, 22, 22, b'0'),
	(168, 2, 84, 22, 'project', '8_voduythanh.doc', '4def629a9e52333a771fa67448f0869a.doc', '2\\2016\\04\\4def629a9e52333a771fa67448f0869a.doc', b'0', 'doc', 3407360, 1461350137, 1461350137, 22, 22, b'0'),
	(169, 2, 84, 22, 'project', '01-activity-diagram-re.png', '85073e47d6f5281bbfed477bee2b6fa7.png', '2\\2016\\04\\85073e47d6f5281bbfed477bee2b6fa7.png', b'1', 'png', 153495, 1461350137, 1461350137, 22, 22, b'0'),
	(170, 2, 84, 22, 'project', '8_voduythanh.doc', '1db941de448ad868fca0dd80b7ccc871.doc', '2\\2016\\04\\1db941de448ad868fca0dd80b7ccc871.doc', b'0', 'doc', 3407360, 1461350137, 1461350137, 22, 22, b'0'),
	(171, 2, 84, 22, 'project', '_administrator_2015_3_Plan.xlsx', 'fdb6a526b2d99de234b6b2ea181602dd.xlsx', '2\\2016\\04\\fdb6a526b2d99de234b6b2ea181602dd.xlsx', b'0', 'xlsx', 14807, 1461350137, 1461350137, 22, 22, b'0'),
	(172, 2, 84, 22, 'project', '_administrator_2015_3_Plan.xlsx', '3971745a19dda86af4482b764cb61894.xlsx', '2\\2016\\04\\3971745a19dda86af4482b764cb61894.xlsx', b'0', 'xlsx', 14807, 1461350137, 1461350137, 22, 22, b'0'),
	(173, 2, 84, 22, 'project', '8_voduythanh.doc', '983cbb8f2e66c063b897f72149f3f3c9.doc', '2\\2016\\04\\983cbb8f2e66c063b897f72149f3f3c9.doc', b'0', 'doc', 3407360, 1461350137, 1461350137, 22, 22, b'0'),
	(174, 2, 84, 22, 'project', '_administrator_2015_3_Plan.xlsx', '0a6514457fc0862807457f3b58aeee06.xlsx', '2\\2016\\04\\0a6514457fc0862807457f3b58aeee06.xlsx', b'0', 'xlsx', 14807, 1461350137, 1461350137, 22, 22, b'0'),
	(175, 2, 84, 22, 'project', '01-activity-diagram-re.png', 'a1dd381d9fecae409c8c7398733bb037.png', '2\\2016\\04\\a1dd381d9fecae409c8c7398733bb037.png', b'1', 'png', 153495, 1461350137, 1461350137, 22, 22, b'0'),
	(176, 2, 84, 22, 'project', '01-activity-diagram-re.png', 'bc3f7f93c76d3ccf628850b92abdb457.png', '2\\2016\\04\\bc3f7f93c76d3ccf628850b92abdb457.png', b'1', 'png', 153495, 1461350137, 1461350137, 22, 22, b'0'),
	(177, 2, 84, 22, 'project', '_administrator_2015_3_Plan.xlsx', '0e3610902043ad0b94e1d700e47cb567.xlsx', '2\\2016\\04\\0e3610902043ad0b94e1d700e47cb567.xlsx', b'0', 'xlsx', 14807, 1461350137, 1461350137, 22, 22, b'0'),
	(178, 2, 85, 21, 'project', 'hotline_transparent.png', '3d2a4c9cbc89a777051494b62e45e844.png', '2\\2016\\04\\3d2a4c9cbc89a777051494b62e45e844.png', b'1', 'png', 3092, 1461350392, 1461350392, 21, 21, b'0'),
	(179, 2, 85, 21, 'project', 'ico-menu.png', '26759eb606356437342daf4f4d1db534.png', '2\\2016\\04\\26759eb606356437342daf4f4d1db534.png', b'1', 'png', 366, 1461350392, 1461350392, 21, 21, b'0'),
	(180, 2, 85, 21, 'project', '01-activity-diagram-re.png', '7d51f4f69a5c365878a5bb646b8ac85c.png', '2\\2016\\04\\7d51f4f69a5c365878a5bb646b8ac85c.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(181, 2, 85, 21, 'project', '01-activity-diagram-re.png', '4256f60f29161fbc20d499ce8cb685a0.png', '2\\2016\\04\\4256f60f29161fbc20d499ce8cb685a0.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(182, 2, 85, 21, 'project', '_administrator_2015_3_Plan.xlsx', 'd1967f59c567362a1562dae1da9ceb8e.xlsx', '2\\2016\\04\\d1967f59c567362a1562dae1da9ceb8e.xlsx', b'0', 'xlsx', 14807, 1461350392, 1461350392, 21, 21, b'0'),
	(183, 2, 85, 21, 'project', '01-activity-diagram-re.png', '635bebcf430f63f638e0bf904a0e8d19.png', '2\\2016\\04\\635bebcf430f63f638e0bf904a0e8d19.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(184, 2, 85, 21, 'project', '01-activity-diagram-re.png', '5e877fe0b6eb207c4e8285c246a1620a.png', '2\\2016\\04\\5e877fe0b6eb207c4e8285c246a1620a.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(185, 2, 85, 21, 'project', '01-activity-diagram-re.png', 'c8480180cab55c645b39948cdeaad0bc.png', '2\\2016\\04\\c8480180cab55c645b39948cdeaad0bc.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(186, 2, 85, 21, 'project', '01-activity-diagram-re.png', 'bea251974282b7d26917eed834065103.png', '2\\2016\\04\\bea251974282b7d26917eed834065103.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(187, 2, 85, 21, 'project', '01-activity-diagram-re.png', '25e82f12e05e93ccdcdc1f188ccdaa9b.png', '2\\2016\\04\\25e82f12e05e93ccdcdc1f188ccdaa9b.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(188, 2, 85, 21, 'project', '01-activity-diagram-re.png', '36471d5d0c07e14e9ed2936157fe72c1.png', '2\\2016\\04\\36471d5d0c07e14e9ed2936157fe72c1.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(189, 2, 85, 21, 'project', '01-activity-diagram-re.png', 'bfbc43a609c7868c1a336d970035c9b9.png', '2\\2016\\04\\bfbc43a609c7868c1a336d970035c9b9.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(190, 2, 85, 21, 'project', '8_voduythanh.doc', 'c556eb64a82f2c8b80c81bbb9d4c06f9.doc', '2\\2016\\04\\c556eb64a82f2c8b80c81bbb9d4c06f9.doc', b'0', 'doc', 3407360, 1461350392, 1461350392, 21, 21, b'0'),
	(191, 2, 85, 21, 'project', '01-activity-diagram-re.png', '08629bae78726da4f949d6a5f3cb80a1.png', '2\\2016\\04\\08629bae78726da4f949d6a5f3cb80a1.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(192, 2, 85, 21, 'project', '8_voduythanh.doc', '9e07b952bea39ef4e270b96d3dd28d53.doc', '2\\2016\\04\\9e07b952bea39ef4e270b96d3dd28d53.doc', b'0', 'doc', 3407360, 1461350392, 1461350392, 21, 21, b'0'),
	(193, 2, 85, 21, 'project', '01-activity-diagram-re.png', 'cbfb80f515a48d030c15add0ecde7cc3.png', '2\\2016\\04\\cbfb80f515a48d030c15add0ecde7cc3.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(194, 2, 85, 21, 'project', '01-activity-diagram-re.png', 'd079f7e085988c854c45abe212c91b08.png', '2\\2016\\04\\d079f7e085988c854c45abe212c91b08.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(195, 2, 85, 21, 'project', '8_voduythanh.doc', '7d7677a1853b5bf2ac11c2b44d81558a.doc', '2\\2016\\04\\7d7677a1853b5bf2ac11c2b44d81558a.doc', b'0', 'doc', 3407360, 1461350392, 1461350392, 21, 21, b'0'),
	(196, 2, 85, 21, 'project', '01-activity-diagram-re.png', '7c0fcdf01669b54d57d52a2b1e0e3b84.png', '2\\2016\\04\\7c0fcdf01669b54d57d52a2b1e0e3b84.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(197, 2, 85, 21, 'project', '01-activity-diagram-re.png', '73be30091099672003e84b0c4807145f.png', '2\\2016\\04\\73be30091099672003e84b0c4807145f.png', b'1', 'png', 153495, 1461350392, 1461350392, 21, 21, b'0'),
	(198, 1, 86, 14, 'project', 'transhop.kiotviet.vn-Sale.mdi', '72d005f697eb2f9fe787ba8c335c4a52.mdi', '1\\2016\\04\\72d005f697eb2f9fe787ba8c335c4a52.mdi', b'0', 'mdi', 11456, 1461350646, 1461350646, 14, 14, b'0'),
	(199, 1, 86, 14, 'project', 'https___transhfgfop.kiotviet.pdf', '24785dc3f25478d94b21e7130e3c92bf.pdf', '1\\2016\\04\\24785dc3f25478d94b21e7130e3c92bf.pdf', b'0', 'pdf', 59773, 1461350646, 1461350646, 14, 14, b'0'),
	(200, 1, 86, 14, 'project', 'Book1.xls', '0672ba32d4ab841c79a6f4c4d9fbf7cb.xls', '1\\2016\\04\\0672ba32d4ab841c79a6f4c4d9fbf7cb.xls', b'0', 'xls', 19456, 1461350646, 1461350646, 14, 14, b'0'),
	(201, 1, 86, 14, 'project', '_administrator_2015_3_Plan.xlsx', '38abe82174c2951f5ea385cf8b89d4e1.xlsx', '1\\2016\\04\\38abe82174c2951f5ea385cf8b89d4e1.xlsx', b'0', 'xlsx', 14807, 1461350646, 1461350646, 14, 14, b'0'),
	(202, 1, 86, 14, 'project', '01-activity-diagram-re.png', 'fa3d8d34d8fdc3c6967d11c0bc67a057.png', '1\\2016\\04\\fa3d8d34d8fdc3c6967d11c0bc67a057.png', b'1', 'png', 153495, 1461350646, 1461350646, 14, 14, b'0'),
	(203, 1, 86, 14, 'project', '01-activity-diagram-re.png', 'fa1a12e310e32a54898f6b3479c3110b.png', '1\\2016\\04\\fa1a12e310e32a54898f6b3479c3110b.png', b'1', 'png', 153495, 1461350646, 1461350646, 14, 14, b'0'),
	(204, 1, 86, 14, 'project', '01-activity-diagram-re.png', '01b9502d06b4d7687a1230477c36dc27.png', '1\\2016\\04\\01b9502d06b4d7687a1230477c36dc27.png', b'1', 'png', 153495, 1461350646, 1461350646, 14, 14, b'0'),
	(205, 1, 86, 14, 'project', '01-activity-diagram-re.png', '465d52c7c6d416ccb159fc08cda2001c.png', '1\\2016\\04\\465d52c7c6d416ccb159fc08cda2001c.png', b'1', 'png', 153495, 1461350646, 1461350646, 14, 14, b'0'),
	(206, 1, 86, 14, 'project', '01-activity-diagram-re.png', '9f00928df489a83d922e05cf0166d693.png', '1\\2016\\04\\9f00928df489a83d922e05cf0166d693.png', b'1', 'png', 153495, 1461350646, 1461350646, 14, 14, b'0'),
	(207, 1, 86, 14, 'project', '_administrator_2015_3_Plan.xlsx', 'fc909d180fc472cc86bfbdfc2a938f85.xlsx', '1\\2016\\04\\fc909d180fc472cc86bfbdfc2a938f85.xlsx', b'0', 'xlsx', 14807, 1461350646, 1461350646, 14, 14, b'0'),
	(208, 1, 86, 14, 'project', '01-activity-diagram-re.png', '8dad5cbbd47fa4fa01895ce3f68b7c89.png', '1\\2016\\04\\8dad5cbbd47fa4fa01895ce3f68b7c89.png', b'1', 'png', 153495, 1461350646, 1461350646, 14, 14, b'0'),
	(209, 1, 86, 14, 'project', '_administrator_2015_3_Plan.xlsx', '4e46a8f4c66dc18a69a54aa30606873c.xlsx', '1\\2016\\04\\4e46a8f4c66dc18a69a54aa30606873c.xlsx', b'0', 'xlsx', 14807, 1461350646, 1461350646, 14, 14, b'0'),
	(210, 1, 86, 14, 'project', '01-activity-diagram-re.png', 'a72a590101e2ea4fdb63182b46445efe.png', '1\\2016\\04\\a72a590101e2ea4fdb63182b46445efe.png', b'1', 'png', 153495, 1461350646, 1461350646, 14, 14, b'0'),
	(211, 1, 86, 14, 'project', '01-activity-diagram-re.png', '0bd3589e8288b24c21455f1b849fa3b2.png', '1\\2016\\04\\0bd3589e8288b24c21455f1b849fa3b2.png', b'1', 'png', 153495, 1461350646, 1461350646, 14, 14, b'0'),
	(212, 1, 86, 14, 'project', '8_voduythanh.doc', '8bf166c377d5538befab8837b6791d1c.doc', '1\\2016\\04\\8bf166c377d5538befab8837b6791d1c.doc', b'0', 'doc', 3407360, 1461350646, 1461350646, 14, 14, b'0'),
	(213, 1, 86, 14, 'project', '8_voduythanh.doc', 'ac9234a9f8cae35e649da786f592d36b.doc', '1\\2016\\04\\ac9234a9f8cae35e649da786f592d36b.doc', b'0', 'doc', 3407360, 1461350647, 1461350647, 14, 14, b'0'),
	(214, 1, 86, 14, 'project', '8_voduythanh.doc', 'ca1d9cd96f34ab4b34412ac5e7379c17.doc', '1\\2016\\04\\ca1d9cd96f34ab4b34412ac5e7379c17.doc', b'0', 'doc', 3407360, 1461350647, 1461350647, 14, 14, b'0'),
	(215, 1, 86, 14, 'project', '01-activity-diagram-re.png', 'daec42c447a91bf7e77b1eadf04962c6.png', '1\\2016\\04\\daec42c447a91bf7e77b1eadf04962c6.png', b'1', 'png', 153495, 1461350647, 1461350647, 14, 14, b'0'),
	(216, 1, 86, 14, 'project', '01-activity-diagram-re.png', '04dcb4577100b7e756ce7d9ae335e166.png', '1\\2016\\04\\04dcb4577100b7e756ce7d9ae335e166.png', b'1', 'png', 153495, 1461350647, 1461350647, 14, 14, b'0'),
	(217, 1, 86, 14, 'project', '_administrator_2015_3_Plan.xlsx', '4f3f5c7c9c150358dc7e158490b5104f.xlsx', '1\\2016\\04\\4f3f5c7c9c150358dc7e158490b5104f.xlsx', b'0', 'xlsx', 14807, 1461350647, 1461350647, 14, 14, b'0');
/*!40000 ALTER TABLE `file` ENABLE KEYS */;


-- Dumping structure for table centeroffice.follower
CREATE TABLE IF NOT EXISTS `follower` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL,
  `task_id` bigint(20) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `task_id` (`task_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.follower: ~0 rows (approximately)
/*!40000 ALTER TABLE `follower` DISABLE KEYS */;
/*!40000 ALTER TABLE `follower` ENABLE KEYS */;


-- Dumping structure for table centeroffice.forum
CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `forum_group_id` int(11) unsigned NOT NULL DEFAULT '0',
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
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `forum_group_id` (`forum_group_id`),
  KEY `employee_id` (`employee_id`),
  KEY `name` (`name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.forum: ~0 rows (approximately)
/*!40000 ALTER TABLE `forum` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum` ENABLE KEYS */;


-- Dumping structure for table centeroffice.forum_group
CREATE TABLE IF NOT EXISTS `forum_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.forum_group: ~0 rows (approximately)
/*!40000 ALTER TABLE `forum_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_group` ENABLE KEYS */;


-- Dumping structure for table centeroffice.invitation
CREATE TABLE IF NOT EXISTS `invitation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `event_id` bigint(20) unsigned NOT NULL,
  `owner_id` int(11) unsigned NOT NULL COMMENT 'id of department and employee',
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'department' COMMENT '[department, employee]',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `employee_id` (`owner_id`),
  KEY `object` (`owner_table`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.invitation: ~0 rows (approximately)
/*!40000 ALTER TABLE `invitation` DISABLE KEYS */;
/*!40000 ALTER TABLE `invitation` ENABLE KEYS */;


-- Dumping structure for table centeroffice.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned DEFAULT NULL,
  `employee_id` int(11) unsigned NOT NULL,
  `staff_id` mediumint(9) unsigned DEFAULT '0',
  `plan_type_detail_id` int(11) unsigned DEFAULT NULL,
  `campaign_id` int(11) unsigned DEFAULT NULL,
  `period_time_id` int(11) unsigned NOT NULL,
  `payment_method_id` int(11) unsigned DEFAULT NULL,
  `invoice_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `total_money` int(11) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `plan_type_detail_id` (`plan_type_detail_id`),
  KEY `period_time_id` (`period_time_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.invoice: ~0 rows (approximately)
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;


-- Dumping structure for table centeroffice.languague
CREATE TABLE IF NOT EXISTS `languague` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `language_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `language_code` (`language_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.languague: ~2 rows (approximately)
/*!40000 ALTER TABLE `languague` DISABLE KEYS */;
INSERT INTO `languague` (`id`, `name`, `language_code`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 'Vietnamese', 'vi', 0, 0, 0, 0, b'0'),
	(2, 'English', 'en', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `languague` ENABLE KEYS */;


-- Dumping structure for table centeroffice.like
CREATE TABLE IF NOT EXISTS `like` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'activity',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_id` (`owner_id`),
  KEY `owner_table` (`owner_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.like: ~0 rows (approximately)
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
/*!40000 ALTER TABLE `like` ENABLE KEYS */;


-- Dumping structure for table centeroffice.marriage_status
CREATE TABLE IF NOT EXISTS `marriage_status` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.marriage_status: ~0 rows (approximately)
/*!40000 ALTER TABLE `marriage_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `marriage_status` ENABLE KEYS */;


-- Dumping structure for table centeroffice.message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.message: ~0 rows (approximately)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;


-- Dumping structure for table centeroffice.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.migration: ~2 rows (approximately)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1450325349),
	('m130524_201442_init', 1450325367);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;


-- Dumping structure for table centeroffice.nation
CREATE TABLE IF NOT EXISTS `nation` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.nation: ~0 rows (approximately)
/*!40000 ALTER TABLE `nation` DISABLE KEYS */;
/*!40000 ALTER TABLE `nation` ENABLE KEYS */;


-- Dumping structure for table centeroffice.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `content_parse` text COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.news: ~0 rows (approximately)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;


-- Dumping structure for table centeroffice.news_allocation
CREATE TABLE IF NOT EXISTS `news_allocation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(11) unsigned NOT NULL,
  `news_category_id` int(11) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `news_category_id` (`news_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.news_allocation: ~0 rows (approximately)
/*!40000 ALTER TABLE `news_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_allocation` ENABLE KEYS */;


-- Dumping structure for table centeroffice.news_category
CREATE TABLE IF NOT EXISTS `news_category` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.news_category: ~0 rows (approximately)
/*!40000 ALTER TABLE `news_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_category` ENABLE KEYS */;


-- Dumping structure for table centeroffice.notification
CREATE TABLE IF NOT EXISTS `notification` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_id` bigint(20) unsigned NOT NULL,
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_id` int(11) unsigned NOT NULL,
  `owner_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `content` mediumtext COLLATE utf8_unicode_ci,
  `is_seen` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `owner_table` (`owner_table`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_employee_id` (`owner_employee_id`),
  KEY `type` (`type`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.notification: ~299 rows (approximately)
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` (`id`, `company_id`, `owner_id`, `owner_table`, `employee_id`, `owner_employee_id`, `type`, `content`, `is_seen`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 1, 'project', 1, 1, 'create_project', 'kk  Ngày tạo  Test new databaseTest new databaseTest new databaseTest new database', b'0', 1460106767, 1460106767, 1, 1, b'0'),
	(2, 0, 2, 'project', 1, 1, 'create_project', 'kk  Ngày tạo  Test new database with company_id', b'0', 1460106964, 1460106964, 1, 1, b'0'),
	(3, 32, 9, 'project', 2, 24, 'create_project', 'kk  Ngày tạo  Test project just integration', b'0', 1460192720, 1460192720, 24, 24, b'0'),
	(4, 32, 10, 'project', 2, 24, 'create_project', 'kk  Ngày tạo  Test opera', b'0', 1460204129, 1460204129, 24, 24, b'0'),
	(5, 32, 11, 'project', 2, 24, 'create_project', 'kk  Ngày tạo  f', b'0', 1460251615, 1460251615, 24, 24, b'0'),
	(6, 1, 12, 'project', 1, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432558, 1460432558, 24, 24, b'0'),
	(7, 1, 12, 'project', 2, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432558, 1460432558, 24, 24, b'0'),
	(8, 1, 12, 'project', 13, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(9, 1, 12, 'project', 14, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(10, 1, 12, 'project', 15, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(11, 1, 12, 'project', 16, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(12, 1, 12, 'project', 17, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(13, 1, 12, 'project', 18, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(14, 1, 12, 'project', 19, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(15, 1, 12, 'project', 20, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(16, 1, 12, 'project', 21, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(17, 1, 12, 'project', 22, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(18, 1, 12, 'project', 23, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(19, 1, 12, 'project', 24, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(20, 1, 12, 'project', 25, 24, 'create_project', 'kk  đã tạo  test upload file', b'0', 1460432559, 1460432559, 24, 24, b'0'),
	(21, 1, 13, 'project', 1, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(22, 1, 13, 'project', 2, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(23, 1, 13, 'project', 13, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(24, 1, 13, 'project', 14, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(25, 1, 13, 'project', 15, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(26, 1, 13, 'project', 16, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(27, 1, 13, 'project', 17, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(28, 1, 13, 'project', 18, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(29, 1, 13, 'project', 19, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(30, 1, 13, 'project', 20, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(31, 1, 13, 'project', 21, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(32, 1, 13, 'project', 22, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(33, 1, 13, 'project', 23, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(34, 1, 13, 'project', 24, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(35, 1, 13, 'project', 25, 24, 'create_project', 'kk  đã tạo  Test project upload', b'0', 1460434275, 1460434275, 24, 24, b'0'),
	(36, 1, 15, 'project', 1, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(37, 1, 15, 'project', 2, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(38, 1, 15, 'project', 13, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(39, 1, 15, 'project', 14, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(40, 1, 15, 'project', 15, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(41, 1, 15, 'project', 16, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(42, 1, 15, 'project', 17, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(43, 1, 15, 'project', 18, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(44, 1, 15, 'project', 19, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(45, 1, 15, 'project', 20, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(46, 1, 15, 'project', 21, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(47, 1, 15, 'project', 22, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(48, 1, 15, 'project', 23, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(49, 1, 15, 'project', 24, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(50, 1, 15, 'project', 25, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', b'0', 1460435172, 1460435172, 22, 22, b'0'),
	(51, 1, 20, 'project', 1, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(52, 1, 20, 'project', 2, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(53, 1, 20, 'project', 13, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(54, 1, 20, 'project', 14, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(55, 1, 20, 'project', 15, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(56, 1, 20, 'project', 16, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(57, 1, 20, 'project', 17, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(58, 1, 20, 'project', 18, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(59, 1, 20, 'project', 19, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(60, 1, 20, 'project', 20, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(61, 1, 20, 'project', 21, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(62, 1, 20, 'project', 22, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(63, 1, 20, 'project', 23, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(64, 1, 20, 'project', 24, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438530, 1460438530, 22, 22, b'0'),
	(65, 1, 20, 'project', 25, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', b'0', 1460438531, 1460438531, 22, 22, b'0'),
	(66, 1, 23, 'project', 1, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', b'0', 1460897200, 1460897200, 20, 20, b'0'),
	(67, 1, 23, 'project', 2, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', b'0', 1460897201, 1460897201, 20, 20, b'0'),
	(68, 1, 23, 'project', 13, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', b'0', 1460897201, 1460897201, 20, 20, b'0'),
	(69, 1, 23, 'project', 14, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', b'0', 1460897201, 1460897201, 20, 20, b'0'),
	(70, 1, 23, 'project', 16, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', b'0', 1460897201, 1460897201, 20, 20, b'0'),
	(71, 1, 24, 'project', 1, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(72, 1, 24, 'project', 2, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(73, 1, 24, 'project', 13, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(74, 1, 24, 'project', 14, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(75, 1, 24, 'project', 15, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(76, 1, 24, 'project', 16, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(77, 1, 24, 'project', 17, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(78, 1, 24, 'project', 18, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(79, 1, 24, 'project', 19, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(80, 1, 24, 'project', 20, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(81, 1, 24, 'project', 21, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897440, 1460897440, 20, 20, b'0'),
	(82, 1, 24, 'project', 22, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897441, 1460897441, 20, 20, b'0'),
	(83, 1, 24, 'project', 23, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', b'0', 1460897441, 1460897441, 20, 20, b'0'),
	(84, 2, 25, 'project', 1, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(85, 2, 25, 'project', 2, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(86, 2, 25, 'project', 13, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(87, 2, 25, 'project', 14, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(88, 2, 25, 'project', 15, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(89, 2, 25, 'project', 16, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(90, 2, 25, 'project', 17, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(91, 2, 25, 'project', 18, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(92, 2, 25, 'project', 19, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(93, 2, 25, 'project', 20, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(94, 2, 25, 'project', 21, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(95, 2, 25, 'project', 22, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(96, 2, 25, 'project', 23, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'0', 1460940641, 1460940641, 21, 21, b'0'),
	(97, 1, 26, 'project', 1, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'0', 1460942521, 1460942521, 16, 16, b'0'),
	(98, 1, 26, 'project', 2, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'0', 1460942521, 1460942521, 16, 16, b'0'),
	(99, 1, 26, 'project', 13, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'0', 1460942521, 1460942521, 16, 16, b'0'),
	(100, 1, 26, 'project', 14, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'0', 1460942521, 1460942521, 16, 16, b'0'),
	(101, 1, 26, 'project', 17, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'0', 1460942521, 1460942521, 16, 16, b'0'),
	(102, 1, 27, 'project', 1, 16, 'create_project', 'le cong vinh  đã tạo  Test new upload filder folder', b'0', 1460943326, 1460943326, 16, 16, b'0'),
	(103, 1, 27, 'project', 2, 16, 'create_project', 'le cong vinh  đã tạo  Test new upload filder folder', b'0', 1460943326, 1460943326, 16, 16, b'0'),
	(104, 1, 27, 'project', 13, 16, 'create_project', 'le cong vinh  đã tạo  Test new upload filder folder', b'0', 1460943326, 1460943326, 16, 16, b'0'),
	(105, 1, 27, 'project', 14, 16, 'create_project', 'le cong vinh  đã tạo  Test new upload filder folder', b'0', 1460943326, 1460943326, 16, 16, b'0'),
	(106, 2, 42, 'project', 1, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(107, 2, 42, 'project', 2, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(108, 2, 42, 'project', 13, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(109, 2, 42, 'project', 14, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(110, 2, 42, 'project', 15, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(111, 2, 42, 'project', 16, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(112, 2, 42, 'project', 17, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(113, 2, 42, 'project', 21, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(114, 2, 42, 'project', 22, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(115, 2, 42, 'project', 23, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'0', 1460971104, 1460971104, 21, 21, b'0'),
	(116, 1, 43, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(117, 1, 43, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(118, 1, 43, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(119, 1, 43, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(120, 1, 43, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(121, 1, 43, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(122, 1, 43, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(123, 1, 43, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(124, 1, 43, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(125, 1, 43, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(126, 1, 57, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981393, 1460981393, 13, 13, b'0'),
	(127, 1, 57, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981394, 1460981394, 13, 13, b'0'),
	(128, 1, 57, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981394, 1460981394, 13, 13, b'0'),
	(129, 1, 57, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981394, 1460981394, 13, 13, b'0'),
	(130, 1, 57, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981394, 1460981394, 13, 13, b'0'),
	(131, 1, 57, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981394, 1460981394, 13, 13, b'0'),
	(132, 1, 57, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981394, 1460981394, 13, 13, b'0'),
	(133, 1, 57, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981394, 1460981394, 13, 13, b'0'),
	(134, 1, 57, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981394, 1460981394, 13, 13, b'0'),
	(135, 1, 57, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', b'0', 1460981394, 1460981394, 13, 13, b'0'),
	(136, 1, 58, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(137, 1, 58, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(138, 1, 58, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(139, 1, 58, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(140, 1, 58, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(141, 1, 58, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(142, 1, 58, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(143, 1, 58, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(144, 1, 58, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(145, 1, 58, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', b'0', 1461036044, 1461036044, 13, 13, b'0'),
	(146, 1, 59, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(147, 1, 59, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(148, 1, 59, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(149, 1, 59, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(150, 1, 59, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(151, 1, 59, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(152, 1, 59, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(153, 1, 59, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(154, 1, 59, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(155, 1, 59, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(156, 1, 59, 'project', 21, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(157, 1, 59, 'project', 22, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(158, 1, 59, 'project', 23, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(159, 1, 60, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(160, 1, 60, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(161, 1, 60, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(162, 1, 60, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(163, 1, 60, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(164, 1, 60, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(165, 1, 60, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(166, 1, 60, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(167, 1, 60, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(168, 1, 60, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(169, 1, 61, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(170, 1, 61, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(171, 1, 61, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(172, 1, 61, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(173, 1, 61, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(174, 1, 61, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(175, 1, 61, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(176, 1, 61, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(177, 1, 61, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(178, 1, 61, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(179, 1, 61, 'project', 21, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(180, 1, 61, 'project', 22, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(181, 1, 61, 'project', 23, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', b'0', 1461040866, 1461040866, 13, 13, b'0'),
	(182, 1, 62, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053327, 1461053327, 13, 13, b'0'),
	(183, 1, 62, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053327, 1461053327, 13, 13, b'0'),
	(184, 1, 62, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053327, 1461053327, 13, 13, b'0'),
	(185, 1, 62, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053327, 1461053327, 13, 13, b'0'),
	(186, 1, 62, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053327, 1461053327, 13, 13, b'0'),
	(187, 1, 62, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053327, 1461053327, 13, 13, b'0'),
	(188, 1, 62, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053327, 1461053327, 13, 13, b'0'),
	(189, 1, 62, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053327, 1461053327, 13, 13, b'0'),
	(190, 1, 62, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053327, 1461053327, 13, 13, b'0'),
	(191, 1, 62, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053328, 1461053328, 13, 13, b'0'),
	(192, 1, 62, 'project', 21, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053328, 1461053328, 13, 13, b'0'),
	(193, 1, 62, 'project', 22, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053328, 1461053328, 13, 13, b'0'),
	(194, 1, 62, 'project', 23, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'0', 1461053328, 1461053328, 13, 13, b'0'),
	(195, 2, 63, 'project', 1, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', b'0', 1461053399, 1461053399, 21, 21, b'0'),
	(196, 2, 63, 'project', 2, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', b'0', 1461053399, 1461053399, 21, 21, b'0'),
	(197, 2, 63, 'project', 13, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', b'0', 1461053399, 1461053399, 21, 21, b'0'),
	(198, 2, 63, 'project', 14, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', b'0', 1461053399, 1461053399, 21, 21, b'0'),
	(199, 2, 63, 'project', 21, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', b'0', 1461053399, 1461053399, 21, 21, b'0'),
	(200, 2, 63, 'project', 22, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', b'0', 1461053399, 1461053399, 21, 21, b'0'),
	(201, 2, 63, 'project', 23, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', b'0', 1461053399, 1461053399, 21, 21, b'0'),
	(202, 2, 64, 'project', 1, 22, 'create_project', 'le van tam  đã tạo  dfadsfdsf', b'0', 1461058151, 1461058151, 22, 22, b'0'),
	(203, 2, 64, 'project', 2, 22, 'create_project', 'le van tam  đã tạo  dfadsfdsf', b'0', 1461058151, 1461058151, 22, 22, b'0'),
	(204, 2, 64, 'project', 13, 22, 'create_project', 'le van tam  đã tạo  dfadsfdsf', b'0', 1461058151, 1461058151, 22, 22, b'0'),
	(205, 2, 64, 'project', 14, 22, 'create_project', 'le van tam  đã tạo  dfadsfdsf', b'0', 1461058151, 1461058151, 22, 22, b'0'),
	(206, 2, 64, 'project', 21, 22, 'create_project', 'le van tam  đã tạo  dfadsfdsf', b'0', 1461058151, 1461058151, 22, 22, b'0'),
	(207, 2, 64, 'project', 22, 22, 'create_project', 'le van tam  đã tạo  dfadsfdsf', b'0', 1461058151, 1461058151, 22, 22, b'0'),
	(208, 2, 64, 'project', 23, 22, 'create_project', 'le van tam  đã tạo  dfadsfdsf', b'0', 1461058151, 1461058151, 22, 22, b'0'),
	(209, 2, 65, 'project', 13, 22, 'create_project', 'le van tam  đã tạo  test safaris', b'0', 1461129963, 1461129963, 22, 22, b'0'),
	(210, 2, 65, 'project', 14, 22, 'create_project', 'le van tam  đã tạo  test safaris', b'0', 1461129966, 1461129966, 22, 22, b'0'),
	(211, 2, 65, 'project', 15, 22, 'create_project', 'le van tam  đã tạo  test safaris', b'0', 1461129966, 1461129966, 22, 22, b'0'),
	(212, 2, 65, 'project', 16, 22, 'create_project', 'le van tam  đã tạo  test safaris', b'0', 1461129966, 1461129966, 22, 22, b'0'),
	(213, 2, 65, 'project', 17, 22, 'create_project', 'le van tam  đã tạo  test safaris', b'0', 1461129966, 1461129966, 22, 22, b'0'),
	(214, 1, 66, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Test sending email', b'0', 1461136235, 1461136235, 13, 13, b'0'),
	(215, 1, 66, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Test sending email', b'0', 1461136235, 1461136235, 13, 13, b'0'),
	(216, 1, 66, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Test sending email', b'0', 1461136235, 1461136235, 13, 13, b'0'),
	(217, 1, 66, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Test sending email', b'0', 1461136235, 1461136235, 13, 13, b'0'),
	(218, 1, 66, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Test sending email', b'0', 1461136235, 1461136235, 13, 13, b'0'),
	(219, 1, 67, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Test bug sending email', b'0', 1461136312, 1461136312, 13, 13, b'0'),
	(220, 1, 68, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  dfdfdsfds', b'0', 1461137202, 1461137202, 13, 13, b'0'),
	(221, 1, 68, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  dfdfdsfds', b'0', 1461137202, 1461137202, 13, 13, b'0'),
	(222, 1, 68, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  dfdfdsfds', b'0', 1461137202, 1461137202, 13, 13, b'0'),
	(223, 1, 68, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  dfdfdsfds', b'0', 1461137202, 1461137202, 13, 13, b'0'),
	(224, 2, 75, 'project', 21, 22, 'create_project', 'le van tam  đã tạo  Test safarais', b'0', 1461143720, 1461143720, 22, 22, b'0'),
	(225, 2, 75, 'project', 22, 22, 'create_project', 'le van tam  đã tạo  Test safarais', b'0', 1461143720, 1461143720, 22, 22, b'0'),
	(226, 2, 75, 'project', 23, 22, 'create_project', 'le van tam  đã tạo  Test safarais', b'0', 1461143721, 1461143721, 22, 22, b'0'),
	(227, 2, 76, 'project', 1, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(228, 2, 76, 'project', 2, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(229, 2, 76, 'project', 13, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(230, 2, 76, 'project', 14, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(231, 2, 76, 'project', 15, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(232, 2, 76, 'project', 16, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(233, 2, 76, 'project', 17, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(234, 2, 76, 'project', 21, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(235, 2, 76, 'project', 22, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(236, 2, 76, 'project', 23, 22, 'create_project', 'le van tam  đã tạo  Test safaris', b'0', 1461143877, 1461143877, 22, 22, b'0'),
	(237, 2, 77, 'project', 1, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(238, 2, 77, 'project', 2, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(239, 2, 77, 'project', 13, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(240, 2, 77, 'project', 14, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(241, 2, 77, 'project', 15, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(242, 2, 77, 'project', 16, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(243, 2, 77, 'project', 17, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(244, 2, 77, 'project', 21, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(245, 2, 77, 'project', 22, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(246, 2, 77, 'project', 23, 22, 'create_project', 'le van tam  đã tạo  Check again Hung task.', b'0', 1461168669, 1461168669, 22, 22, b'0'),
	(247, 1, 78, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(248, 1, 78, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(249, 1, 78, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(250, 1, 78, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(251, 1, 78, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(252, 1, 78, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(253, 1, 78, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(254, 1, 78, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(255, 1, 78, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(256, 1, 78, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(257, 1, 78, 'project', 21, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(258, 1, 78, 'project', 22, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(259, 1, 78, 'project', 23, 13, 'create_project', 'vu thuy trinh  đã tạo  aaa', b'0', 1461280059, 1461280059, 13, 13, b'0'),
	(260, 1, 79, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(261, 1, 79, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(262, 1, 79, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(263, 1, 79, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(264, 1, 79, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(265, 1, 79, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(266, 1, 79, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(267, 1, 79, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(268, 1, 79, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(269, 1, 79, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  để tháng 5', b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(270, 1, 80, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(271, 1, 80, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(272, 1, 80, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(273, 1, 80, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(274, 1, 80, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(275, 1, 80, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(276, 1, 80, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(277, 1, 80, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(278, 1, 80, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(279, 1, 80, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  abc', b'0', 1461299599, 1461299599, 13, 13, b'0'),
	(280, 1, 83, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(281, 1, 83, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(282, 1, 83, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(283, 1, 83, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(284, 1, 83, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(285, 1, 83, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(286, 1, 83, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(287, 1, 83, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(288, 1, 83, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(289, 1, 83, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(290, 2, 85, 'project', 21, 21, 'create_project', 'ta hong gam  đã tạo  TEst opera', b'0', 1461350392, 1461350392, 21, 21, b'0'),
	(291, 2, 85, 'project', 22, 21, 'create_project', 'ta hong gam  đã tạo  TEst opera', b'0', 1461350392, 1461350392, 21, 21, b'0'),
	(292, 2, 85, 'project', 23, 21, 'create_project', 'ta hong gam  đã tạo  TEst opera', b'0', 1461350392, 1461350392, 21, 21, b'0'),
	(293, 1, 86, 'project', 1, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0'),
	(294, 1, 86, 'project', 2, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0'),
	(295, 1, 86, 'project', 13, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0'),
	(296, 1, 86, 'project', 14, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0'),
	(297, 1, 86, 'project', 15, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0'),
	(298, 1, 86, 'project', 16, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0'),
	(299, 1, 86, 'project', 17, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0'),
	(300, 1, 86, 'project', 18, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0'),
	(301, 1, 86, 'project', 19, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0'),
	(302, 1, 86, 'project', 20, 14, 'create_project', 'vu quoc hoa  đã tạo  Test cococ', b'0', 1461350647, 1461350647, 14, 14, b'0');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;


-- Dumping structure for table centeroffice.package
CREATE TABLE IF NOT EXISTS `package` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` mediumtext COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.package: ~3 rows (approximately)
/*!40000 ALTER TABLE `package` DISABLE KEYS */;
INSERT INTO `package` (`id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 'member', NULL, 0, 0, 0, 0, b'0'),
	(2, 'frontend', NULL, 0, 0, 0, 0, b'0'),
	(3, 'backend', NULL, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `package` ENABLE KEYS */;


-- Dumping structure for table centeroffice.payment_method
CREATE TABLE IF NOT EXISTS `payment_method` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.payment_method: ~0 rows (approximately)
/*!40000 ALTER TABLE `payment_method` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_method` ENABLE KEYS */;


-- Dumping structure for table centeroffice.period_time
CREATE TABLE IF NOT EXISTS `period_time` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `length` smallint(6) unsigned NOT NULL DEFAULT '0',
  `description` mediumtext COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `length` (`length`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.period_time: ~0 rows (approximately)
/*!40000 ALTER TABLE `period_time` DISABLE KEYS */;
/*!40000 ALTER TABLE `period_time` ENABLE KEYS */;


-- Dumping structure for table centeroffice.plan_type
CREATE TABLE IF NOT EXISTS `plan_type` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.plan_type: ~0 rows (approximately)
/*!40000 ALTER TABLE `plan_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `plan_type` ENABLE KEYS */;


-- Dumping structure for table centeroffice.plan_type_detail
CREATE TABLE IF NOT EXISTS `plan_type_detail` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `plan_type_id` int(11) unsigned NOT NULL DEFAULT '0',
  `max_user` smallint(6) unsigned NOT NULL,
  `max_storage_capacity` int(11) unsigned NOT NULL,
  `fee` int(10) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `plan_type_id` (`plan_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.plan_type_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `plan_type_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `plan_type_detail` ENABLE KEYS */;


-- Dumping structure for table centeroffice.position
CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.position: ~0 rows (approximately)
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
/*!40000 ALTER TABLE `position` ENABLE KEYS */;


-- Dumping structure for table centeroffice.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `subject_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `parent_post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `is_reviewed` bit(1) NOT NULL DEFAULT b'1',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`),
  KEY `parent_post_id` (`parent_post_id`),
  KEY `employee_id` (`employee_id`),
  KEY `is_reviewed` (`is_reviewed`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.post: ~0 rows (approximately)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;


-- Dumping structure for table centeroffice.priority
CREATE TABLE IF NOT EXISTS `priority` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.priority: ~8 rows (approximately)
/*!40000 ALTER TABLE `priority` DISABLE KEYS */;
INSERT INTO `priority` (`id`, `company_id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 'Thấp', NULL, 0, 0, 0, 0, b'0'),
	(2, 1, 'Bình thường', NULL, 0, 0, 0, 0, b'0'),
	(3, 1, 'Cao', NULL, 0, 0, 0, 0, b'0'),
	(4, 1, 'Khẩn cấp', NULL, 0, 0, 0, 0, b'0'),
	(5, 2, 'Gấp', NULL, 0, 0, 0, 0, b'0'),
	(6, 2, 'Làm ngay', NULL, 0, 0, 0, 0, b'0'),
	(7, 2, 'Chuyển ngay', NULL, 0, 0, 0, 0, b'0'),
	(8, 2, 'Nộp ngày mai', NULL, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `priority` ENABLE KEYS */;


-- Dumping structure for table centeroffice.project
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `manager_project_id` int(11) unsigned DEFAULT '0',
  `priority_id` int(11) unsigned NOT NULL,
  `status_id` int(11) unsigned NOT NULL,
  `parent_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `start_datetime` int(11) unsigned DEFAULT '0',
  `duedatetime` int(11) unsigned DEFAULT '0',
  `completed_percent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `estimate_hour` int(11) unsigned DEFAULT '0',
  `worked_hour` int(11) unsigned DEFAULT '0',
  `is_public` bit(1) NOT NULL DEFAULT b'1',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `manager_project_id` (`manager_project_id`),
  KEY `priority_id` (`priority_id`),
  KEY `status_id` (`status_id`),
  KEY `parent_id` (`parent_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.project: ~63 rows (approximately)
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` (`id`, `company_id`, `manager_project_id`, `priority_id`, `status_id`, `parent_id`, `name`, `description`, `description_parse`, `start_datetime`, `duedatetime`, `completed_percent`, `estimate_hour`, `worked_hour`, `is_public`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 2, 2, 2, 0, 'Test new databaseTest new databaseTest new databaseTest new database', 'Test new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new database', 'Test new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new databaseTest new database', NULL, NULL, 39, 443, 97, b'1', 1460106767, 1460106767, 1, 1, b'0'),
	(2, 0, 2, 1, 1, 0, 'Test new database with company_id', 'fdsfsfTest new database with company_id', 'fdsfsfTest new database with company_id', NULL, NULL, 73, 0, 0, b'1', 1460106964, 1460106964, 1, 1, b'0'),
	(3, 1, 0, 1, 1, 0, 'Yii::$app->user->getId()', 'Yii::$app->user->getId()', 'Yii::$app->user->getId()', NULL, NULL, 49, 0, 0, b'0', 1460108500, 1460108500, 1, 1, b'0'),
	(4, 24, 0, 1, 2, 0, 'Test company_id', 'Test company_idTest company_idTest company_idTest company_idTest company_idTest company_idTest company_id', 'Test company_idTest company_idTest company_idTest company_idTest company_idTest company_idTest company_id', NULL, NULL, 53, 0, 0, b'1', 1460162126, 1460162126, 24, 24, b'0'),
	(5, 99, 0, 1, 1, 0, 'return 999return 999return 999return 999return 999return 999return 999', 'return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999', 'return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999return 999', NULL, NULL, 0, 0, 0, b'0', 1460162202, 1460162202, 99, 99, b'0'),
	(6, 24, 0, 1, 1, 0, 'Thông tin dự án', 'Thông tin dự án', 'Thông tin dự án', NULL, NULL, 57, 0, 0, b'0', 1460169662, 1460169662, 24, 24, b'0'),
	(7, 32, 0, 1, 1, 0, 'test com', 'test comtest comtest comtest comtest comtest comtest comtest comtest com', 'test comtest comtest comtest comtest comtest comtest comtest comtest com', NULL, NULL, 42, 0, 0, b'0', 1460171439, 1460171439, 24, 24, b'0'),
	(8, 32, 24, 1, 1, 0, 'Tên dự án', 'sdfsfs', 'sdfsfs', NULL, NULL, 0, 0, 0, b'0', 1460171712, 1460171712, 24, 24, b'0'),
	(9, 32, 24, 1, 2, 0, 'Test project just integration', 'Test project just integrationTest project just integration', 'Test project just integrationTest project just integration', 1460444400, 1461999600, 49, 444, 434, b'1', 1460192719, 1460192719, 24, 24, b'0'),
	(10, 32, 24, 1, 1, 0, 'Test opera', 'Test operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest opera', 'Test operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest operaTest opera', NULL, NULL, 0, 0, 0, b'0', 1460204128, 1460204128, 24, 24, b'0'),
	(11, 32, 24, 1, 1, 0, 'f', 'hfh', 'hfh', NULL, NULL, 55, 0, 0, b'0', 1460251615, 1460251615, 24, 24, b'0'),
	(12, 1, 2, 3, 1, 0, 'test upload file', 'test upload filetest upload filetest upload filetest upload filetest upload file', 'test upload filetest upload filetest upload filetest upload filetest upload file', NULL, NULL, 40, 444, 0, b'1', 1460432557, 1460432557, 24, 24, b'0'),
	(13, 1, 2, 1, 1, 0, 'Test project upload', 'Test project upload', 'Test project upload', 1461308400, 1464332400, 39, 0, 0, b'0', 1460434274, 1460434274, 24, 24, b'0'),
	(14, 1, 0, 1, 3, 0, 'Upload same file name mutilple', 'Upload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilplevv', 'Upload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilpleUpload same file name mutilplevv', NULL, NULL, 41, 544, 0, b'1', 1460434733, 1460434733, 24, 24, b'0'),
	(15, 1, 13, 2, 1, 0, 'Test insert new record employee', 'Test insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employee', 'Test insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employeeTest insert new record employee', 1461222000, 1461308400, 55, 32, 0, b'1', 1460435171, 1460435171, 22, 22, b'0'),
	(16, 1, 0, 1, 1, 0, 'Test project manager', 'Test project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project manager', 'Test project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project manager', 1461308400, 1461999600, 70, 32, 0, b'1', 1460437527, 1460437527, 22, 22, b'0'),
	(17, 1, 0, 1, 1, 0, 'Test project manager', 'Test project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project manager', 'Test project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project manager', 1461308400, 1461999600, 70, 32, 0, b'1', 1460437572, 1460437572, 22, 22, b'0'),
	(18, 1, 0, 1, 1, 0, 'Test project manager', 'Test project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project manager', 'Test project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project managerTest project manager', 1461308400, 1461999600, 70, 32, 0, b'1', 1460437607, 1460437607, 22, 22, b'0'),
	(19, 1, 0, 2, 1, 0, 'Test same file name error', 'Test same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name error', 'Test same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name errorTest same file name error', 1460703600, 1461999600, 58, 32, 0, b'1', 1460438031, 1460438031, 22, 22, b'0'),
	(20, 1, 15, 3, 2, 0, 'Test project manager no show in', 'Test project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show in', 'Test project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show inTest project manager no show in', 1460703600, 1461999600, 69, 1344, 0, b'1', 1460438530, 1460438530, 22, 22, b'0'),
	(21, 1, 0, 1, 1, 0, 'Test project manager for', 'Test project manager for Test project manager for Test project manager for Test project manager for Test project manager for', 'Test project manager for Test project manager for Test project manager for Test project manager for Test project manager for', NULL, NULL, 52, 0, 0, b'0', 1460438955, 1460438955, 22, 22, b'0'),
	(22, 1, 0, 3, 1, 0, 'Thông tin dự án', 'Thông tin dự Thông tin dự ánThông tin dự án', 'Thông tin dự Thông tin dự ánThông tin dự án', NULL, NULL, 0, 0, 0, b'0', 1460896313, 1460896313, 20, 20, b'0'),
	(23, 1, 2, 3, 3, 0, 'Test new integration', 'Test new integrationTest new integrationTest new integrationTest new integration', 'Test new integrationTest new integrationTest new integrationTest new integration', 1459926000, 1461999600, 0, 0, 0, b'0', 1460897200, 1460897200, 20, 20, b'0'),
	(24, 1, 13, 4, 3, 0, 'Test new integrate again.', 'Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.', 'Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.Test new integrate again.', NULL, NULL, 87, 0, 0, b'1', 1460897440, 1460897440, 20, 20, b'0'),
	(25, 2, 2, 3, 2, 0, 'Ta hong gam company 2', 'Ta hong gam company 2 Ta hong gam company 2 Ta hong gam company 2 Ta hong gam company 2 Ta hong gam company 2', 'Ta hong gam company 2 Ta hong gam company 2 Ta hong gam company 2 Ta hong gam company 2 Ta hong gam company 2', 1461999600, 1461999600, 90, 23423423, 0, b'1', 1460940641, 1460940641, 21, 21, b'0'),
	(26, 1, 13, 1, 1, 0, 'Test upload file changeTest upload file change', 'Test upload file changeTest upload file changeTest upload file change', 'Test upload file changeTest upload file changeTest upload file change', NULL, NULL, 92, 0, 0, b'0', 1460942520, 1460942520, 16, 16, b'0'),
	(27, 1, 2, 1, 1, 0, 'Test new upload filder folder', 'Test new upload filder folderTest new upload filder folder', 'Test new upload filder folderTest new upload filder folder', NULL, NULL, 0, 0, 0, b'0', 1460943325, 1460943325, 16, 16, b'0'),
	(28, 1, 0, 3, 2, 0, 'Test upload by compnay 1 duonghoangtuan', 'Test upload by compnay 1 duonghoangtuanTest upload by compnay 1 duonghoangtuanTest upload by compnay 1 duonghoangtuan', 'Test upload by compnay 1 duonghoangtuanTest upload by compnay 1 duonghoangtuanTest upload by compnay 1 duonghoangtuan', 1461999600, 1465023600, 51, 0, 0, b'0', 1460943582, 1460943582, 17, 17, b'0'),
	(29, 1, 0, 1, 1, 0, 'Test company 1 duoongh hoang tuan', 'Test company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuan', 'Test company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuanTest company 1 duoongh hoang tuan', NULL, NULL, 57, 0, 0, b'1', 1460943700, 1460943700, 17, 17, b'0'),
	(30, 1, 0, 1, 1, 0, 'TEst new 1 duong hoang tuan', 'TEst new 1 duong hoang tuan TEst new 1 duong hoang tuan TEst new 1 duong hoang tuan', 'TEst new 1 duong hoang tuan TEst new 1 duong hoang tuan TEst new 1 duong hoang tuan', NULL, NULL, 0, 0, 0, b'0', 1460944015, 1460944015, 17, 17, b'0'),
	(31, 1, 0, 1, 1, 0, 'dfdsfds', 'fgsdfds', 'fgsdfds', NULL, NULL, 0, 0, 0, b'0', 1460944167, 1460944167, 17, 17, b'0'),
	(32, 1, 0, 1, 1, 0, '. DIRECTORY_SEPARATOR. DIRECTORY_SEPARATOR. DIRECTORY_SEPARATOR', '. DIRECTORY_SEPARATOR. DIRECTORY_SEPARATOR. DIRECTORY_SEPARATOR', '. DIRECTORY_SEPARATOR. DIRECTORY_SEPARATOR. DIRECTORY_SEPARATOR', NULL, NULL, 0, 0, 0, b'0', 1460944281, 1460944281, 17, 17, b'0'),
	(33, 2, 0, 2, 2, 0, 'Test company_id upload', 'Test company_id uploadTest company_id uploadTest company_id upload', 'Test company_id uploadTest company_id uploadTest company_id upload', NULL, NULL, 58, 0, 0, b'0', 1460962410, 1460962410, 21, 21, b'0'),
	(34, 2, 0, 4, 4, 0, 'TEst new upload new', 'TEst new upload new', 'TEst new upload new', NULL, NULL, 65, 0, 0, b'0', 1460962572, 1460962572, 21, 21, b'0'),
	(35, 1, 0, 1, 1, 0, 'Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1', 'Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1', 'Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1', NULL, NULL, 0, 0, 0, b'0', 1460963352, 1460963352, 13, 13, b'0'),
	(36, 1, 0, 3, 2, 0, 'Vu thuy trinh company id 111111111111111111111111', 'Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1', 'Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1', NULL, NULL, 18, 0, 0, b'0', 1460963619, 1460963619, 13, 13, b'0'),
	(37, 1, 0, 1, 1, 0, 'Vu thuy trinh company id 1333333333333333', 'Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1', 'Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1Vu thuy trinh company id 1', NULL, NULL, 68, 0, 0, b'0', 1460963676, 1460963676, 13, 13, b'0'),
	(38, 1, 0, 1, 1, 0, 'Test new adn compnay _id', 'Test new adn compnay _idTest new adn compnay _id', 'Test new adn compnay _idTest new adn compnay _id', NULL, NULL, 34, 0, 0, b'0', 1460967045, 1460967045, 20, 20, b'0'),
	(41, 2, 2, 5, 5, 0, 'Test no choice priority', 'Test no choice priorityTest no choice priorityTest no choice priorityTest no choice priority', 'Test no choice priorityTest no choice priorityTest no choice priorityTest no choice priority', NULL, NULL, 68, 0, 0, b'0', 1460970448, 1460970448, 21, 21, b'0'),
	(42, 2, 23, 7, 6, 0, 'Test add compnay_id employee', 'Test add compnay_id employeeTest add compnay_id employeeTest add compnay_id employee', 'Test add compnay_id employeeTest add compnay_id employeeTest add compnay_id employee', NULL, NULL, 64, 0, 0, b'0', 1460971103, 1460971103, 21, 21, b'0'),
	(43, 1, 14, 1, 1, 0, 'Test company id 1', 'Test company id 1Test company id 1Test company id 1Test company id 1', 'Test company id 1Test company id 1Test company id 1Test company id 1', NULL, NULL, 0, 0, 0, b'0', 1460971216, 1460971216, 13, 13, b'0'),
	(44, 1, 0, 3, 2, 0, 'd fads fasdfsd', 'saf asfds', 'saf asfds', NULL, NULL, 0, 0, 0, b'0', 1460971475, 1460971475, 13, 13, b'0'),
	(46, 1, 0, 1, 2, 0, 'Test expand range of value estimate time.', 'Test expand range of value estimate time.', 'Test expand range of value estimate time.', 1460703600, 1461913200, 0, 4294967295, 0, b'0', 1460979358, 1460979358, 13, 13, b'0'),
	(56, 1, 0, 1, 1, 0, 'teasfd', 'sdfadsf', 'sdfadsf', NULL, NULL, 0, 0, 0, b'0', 1460981343, 1460981343, 13, 13, b'0'),
	(57, 1, 0, 1, 1, 0, 'TEst activity model', 'TEst activity modelTEst activity model', 'TEst activity modelTEst activity model', NULL, NULL, 0, 0, 0, b'0', 1460981393, 1460981393, 13, 13, b'0'),
	(58, 1, 0, 1, 1, 0, 'dsdfdsf', 'sdfsdf', 'sdfsdf', NULL, NULL, 0, 0, 0, b'0', 1461036043, 1461036043, 13, 13, b'0'),
	(59, 1, 2, 1, 1, 0, 'Test email template', 'Test email templateTest email templateTest email templateTest email template', 'Test email templateTest email templateTest email templateTest email template', NULL, NULL, 54, 0, 0, b'0', 1461036304, 1461036304, 13, 13, b'0'),
	(60, 1, 2, 1, 1, 0, 'dsfsd fds fds  Thông tin dự án', 'dsfds fdsf sdfd', 'dsfds fdsf sdfd', NULL, NULL, 0, 0, 0, b'0', 1461037445, 1461037445, 13, 13, b'0'),
	(61, 1, 2, 3, 2, 0, 'Test change model code.', 'Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.', 'Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.Test change model code.', NULL, NULL, 83, 3444444444, 0, b'1', 1461040865, 1461040865, 13, 13, b'0'),
	(62, 1, 2, 3, 1, 0, 'Ta hong gam company 2 no see', 'Ta hong gam company 2 no see', 'Ta hong gam company 2 no see', NULL, NULL, 95, 3232, 0, b'1', 1461053327, 1461053327, 13, 13, b'0'),
	(63, 2, 23, 7, 6, 0, 'Vu thuy trinh company 1 no see', 'Ta hong gam company 2 no seeTa hong gam company 2 no seeTa hong gam company 2 no see', 'Ta hong gam company 2 no seeTa hong gam company 2 no seeTa hong gam company 2 no see', NULL, NULL, 87, 0, 0, b'1', 1461053399, 1461053399, 21, 21, b'0'),
	(64, 2, 21, 5, 5, 0, 'dfadsfdsf', 'sdfdsfsf', 'sdfdsfsf', NULL, NULL, 0, 0, 0, b'0', 1461058150, 1461058150, 22, 22, b'0'),
	(65, 2, 2, 1, 1, 0, 'test safaris', 'test safaristest safaristest safaristest safaris', 'test safaristest safaristest safaristest safaris', NULL, NULL, 56, 0, 0, b'1', 1461129959, 1461129959, 22, 22, b'0'),
	(66, 1, 2, 1, 1, 0, 'Test sending email', 'Test sending emailTest sending emailTest sending emailTest sending email', 'Test sending emailTest sending emailTest sending emailTest sending email', 1460790000, NULL, 63, 0, 0, b'1', 1461136234, 1461136234, 13, 13, b'0'),
	(67, 1, 2, 1, 1, 0, 'Test bug sending email', 'Test bug sending emailTest bug sending emailTest bug sending emailTest bug sending email', 'Test bug sending emailTest bug sending emailTest bug sending emailTest bug sending email', 1459839600, 1461308400, 70, 0, 0, b'0', 1461136312, 1461136312, 13, 13, b'0'),
	(68, 1, 2, 1, 1, 0, 'dfdfdsfds', 'sdfsdf', 'sdfsdf', NULL, NULL, 0, 0, 0, b'0', 1461137201, 1461137201, 13, 13, b'0'),
	(74, 1, 0, 1, 2, 0, '{Add project name em template}', '{Add project name em template}', '{Add project name em template}', 1460530800, 1461913200, 56, 0, 0, b'1', 1461137909, 1461137909, 13, 13, b'0'),
	(75, 2, 21, 1, 1, 0, 'Test safarais', 'Test safarais', 'Test safarais', NULL, NULL, 47, 0, 0, b'1', 1461143718, 1461143718, 22, 22, b'0'),
	(76, 2, 21, 7, 6, 0, 'Test safaris', 'Test safaris Test safaris Test safaris', 'Test safaris Test safaris Test safaris', NULL, NULL, 53, 666663430, 0, b'1', 1461143877, 1461143877, 22, 22, b'0'),
	(77, 2, 21, 7, 6, 0, 'Check again Hung task.', 'descriptiona descriptionadescriptionadescriptionadescriptiona', 'descriptiona descriptionadescriptionadescriptionadescriptiona', 1460790000, 1461999600, 51, 444444444, 0, b'1', 1461168668, 1461168668, 22, 22, b'0'),
	(78, 1, 2, 1, 1, 0, 'aaa', 'aaaa', 'aaaa', 1461481200, 1485936000, 39, 44, 0, b'0', 1461280058, 1461280058, 13, 13, b'0'),
	(79, 1, 2, 1, 1, 0, 'để tháng 5', 'để tháng 5để tháng 5để tháng 5để tháng 5', 'để tháng 5để tháng 5để tháng 5để tháng 5', 1461049200, 1461999600, 0, 0, 0, b'0', 1461282768, 1461282768, 13, 13, b'0'),
	(80, 1, 20, 1, 1, 0, 'abc', 'abc', 'abc', 1461481200, 1474614000, 17, 45, 0, b'1', 1461299599, 1461299599, 13, 13, b'0'),
	(81, 1, 0, 1, 1, 0, 'Test employe chooose member', 'Test employe chooose member', 'Test employe chooose member', NULL, NULL, 54, 0, 0, b'0', 1461347985, 1461347985, 19, 19, b'0'),
	(82, 1, 0, 1, 1, 0, 'a', 'a', 'a', NULL, NULL, 0, 0, 0, b'0', 1461348461, 1461348461, 19, 19, b'0'),
	(83, 1, 2, 2, 2, 0, 'Test chromeTest chromeTest chromeTest chrome', 'Test chromeTest chromeTest chromeTest chromeTest chromeTest chrome', 'Test chromeTest chromeTest chromeTest chromeTest chromeTest chrome', NULL, NULL, 30, 566677775, 0, b'0', 1461349941, 1461349941, 13, 13, b'0'),
	(84, 2, 21, 5, 5, 0, 'Test safaris', 'Test safaris', 'Test safaris', NULL, NULL, 0, 0, 0, b'0', 1461350137, 1461350137, 22, 22, b'0'),
	(85, 2, 21, 5, 5, 0, 'TEst opera', 'TEst operaTEst operaTEst opera', 'TEst operaTEst operaTEst opera', NULL, NULL, 0, 0, 0, b'0', 1461350392, 1461350392, 21, 21, b'0'),
	(86, 1, 2, 1, 1, 0, 'Test cococ', 'Test cococ', 'Test cococ', NULL, NULL, 0, 0, 0, b'0', 1461350646, 1461350646, 14, 14, b'0');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;


-- Dumping structure for table centeroffice.project_participant
CREATE TABLE IF NOT EXISTS `project_participant` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `project_id` int(11) unsigned NOT NULL,
  `owner_id` int(11) unsigned NOT NULL,
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '[department and employee]',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `employee_id` (`owner_id`),
  KEY `owner_table` (`owner_table`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.project_participant: ~120 rows (approximately)
/*!40000 ALTER TABLE `project_participant` DISABLE KEYS */;
INSERT INTO `project_participant` (`id`, `company_id`, `project_id`, `owner_id`, `owner_table`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 1, 1, 'employee', 1460106767, 1460106767, 1, 1, b'0'),
	(2, 0, 2, 1, 'employee', 1460106964, 1460106964, 1, 1, b'0'),
	(3, 32, 8, 1, 'department', 1460171712, 1460171712, 24, 24, b'0'),
	(4, 32, 9, 1, 'department', 1460192719, 1460192719, 24, 24, b'0'),
	(5, 32, 9, 2, 'department', 1460192719, 1460192719, 24, 24, b'0'),
	(6, 32, 9, 2, 'employee', 1460192719, 1460192719, 24, 24, b'0'),
	(7, 32, 10, 1, 'department', 1460204128, 1460204128, 24, 24, b'0'),
	(8, 32, 10, 2, 'department', 1460204128, 1460204128, 24, 24, b'0'),
	(9, 32, 10, 2, 'employee', 1460204128, 1460204128, 24, 24, b'0'),
	(10, 32, 11, 1, 'department', 1460251615, 1460251615, 24, 24, b'0'),
	(11, 32, 11, 2, 'department', 1460251615, 1460251615, 24, 24, b'0'),
	(12, 32, 11, 2, 'employee', 1460251615, 1460251615, 24, 24, b'0'),
	(13, 1, 12, 1, 'department', 1460432557, 1460432557, 24, 24, b'0'),
	(14, 1, 12, 16, 'employee', 1460432557, 1460432557, 24, 24, b'0'),
	(15, 1, 12, 17, 'employee', 1460432557, 1460432557, 24, 24, b'0'),
	(16, 1, 12, 18, 'employee', 1460432557, 1460432557, 24, 24, b'0'),
	(17, 1, 13, 1, 'department', 1460434274, 1460434274, 24, 24, b'0'),
	(18, 1, 13, 16, 'employee', 1460434274, 1460434274, 24, 24, b'0'),
	(19, 1, 13, 17, 'employee', 1460434274, 1460434274, 24, 24, b'0'),
	(20, 1, 13, 19, 'employee', 1460434274, 1460434274, 24, 24, b'0'),
	(21, 1, 13, 18, 'employee', 1460434274, 1460434274, 24, 24, b'0'),
	(22, 1, 15, 2, 'employee', 1460435171, 1460435171, 22, 22, b'0'),
	(23, 1, 15, 14, 'employee', 1460435171, 1460435171, 22, 22, b'0'),
	(24, 1, 20, 2, 'department', 1460438530, 1460438530, 22, 22, b'0'),
	(25, 1, 20, 1, 'department', 1460438530, 1460438530, 22, 22, b'0'),
	(26, 1, 20, 20, 'employee', 1460438530, 1460438530, 22, 22, b'0'),
	(27, 1, 23, 1, 'department', 1460897200, 1460897200, 20, 20, b'0'),
	(28, 1, 23, 13, 'employee', 1460897200, 1460897200, 20, 20, b'0'),
	(29, 1, 23, 14, 'employee', 1460897200, 1460897200, 20, 20, b'0'),
	(30, 1, 23, 16, 'employee', 1460897200, 1460897200, 20, 20, b'0'),
	(31, 1, 24, 1, 'department', 1460897440, 1460897440, 20, 20, b'0'),
	(32, 1, 24, 2, 'department', 1460897440, 1460897440, 20, 20, b'0'),
	(33, 1, 24, 19, 'employee', 1460897440, 1460897440, 20, 20, b'0'),
	(34, 1, 24, 20, 'employee', 1460897440, 1460897440, 20, 20, b'0'),
	(35, 1, 24, 22, 'employee', 1460897440, 1460897440, 20, 20, b'0'),
	(36, 1, 24, 21, 'employee', 1460897440, 1460897440, 20, 20, b'0'),
	(37, 1, 24, 23, 'employee', 1460897440, 1460897440, 20, 20, b'0'),
	(38, 1, 24, 18, 'employee', 1460897440, 1460897440, 20, 20, b'0'),
	(39, 2, 25, 1, 'department', 1460940641, 1460940641, 21, 21, b'0'),
	(40, 2, 25, 16, 'employee', 1460940641, 1460940641, 21, 21, b'0'),
	(41, 2, 25, 18, 'employee', 1460940641, 1460940641, 21, 21, b'0'),
	(42, 2, 25, 17, 'employee', 1460940641, 1460940641, 21, 21, b'0'),
	(43, 2, 25, 19, 'employee', 1460940641, 1460940641, 21, 21, b'0'),
	(44, 2, 25, 21, 'employee', 1460940641, 1460940641, 21, 21, b'0'),
	(45, 2, 25, 20, 'employee', 1460940641, 1460940641, 21, 21, b'0'),
	(46, 2, 25, 15, 'employee', 1460940641, 1460940641, 21, 21, b'0'),
	(47, 2, 25, 22, 'employee', 1460940641, 1460940641, 21, 21, b'0'),
	(48, 2, 25, 23, 'employee', 1460940641, 1460940641, 21, 21, b'0'),
	(49, 1, 26, 1, 'department', 1460942520, 1460942520, 16, 16, b'0'),
	(50, 1, 26, 2, 'employee', 1460942520, 1460942520, 16, 16, b'0'),
	(51, 1, 26, 17, 'employee', 1460942520, 1460942520, 16, 16, b'0'),
	(52, 1, 27, 1, 'department', 1460943325, 1460943325, 16, 16, b'0'),
	(53, 2, 42, 1, 'department', 1460971103, 1460971103, 21, 21, b'0'),
	(54, 2, 42, 2, 'department', 1460971103, 1460971103, 21, 21, b'0'),
	(55, 2, 42, 21, 'employee', 1460971103, 1460971103, 21, 21, b'0'),
	(56, 2, 42, 22, 'employee', 1460971103, 1460971103, 21, 21, b'0'),
	(57, 1, 43, 18, 'employee', 1460971216, 1460971216, 13, 13, b'0'),
	(58, 1, 43, 2, 'employee', 1460971216, 1460971216, 13, 13, b'0'),
	(59, 1, 43, 13, 'employee', 1460971216, 1460971216, 13, 13, b'0'),
	(60, 1, 43, 15, 'employee', 1460971216, 1460971216, 13, 13, b'0'),
	(65, 1, 57, 3, 'department', 1460981393, 1460981393, 13, 13, b'0'),
	(66, 1, 58, 5, 'department', 1461036043, 1461036043, 13, 13, b'0'),
	(67, 1, 59, 4, 'department', 1461036304, 1461036304, 13, 13, b'0'),
	(68, 1, 59, 14, 'employee', 1461036304, 1461036304, 13, 13, b'0'),
	(69, 1, 59, 15, 'employee', 1461036304, 1461036304, 13, 13, b'0'),
	(70, 1, 59, 16, 'employee', 1461036304, 1461036304, 13, 13, b'0'),
	(71, 1, 60, 3, 'department', 1461037445, 1461037445, 13, 13, b'0'),
	(72, 1, 60, 5, 'department', 1461037445, 1461037445, 13, 13, b'0'),
	(73, 1, 60, 13, 'employee', 1461037445, 1461037445, 13, 13, b'0'),
	(74, 1, 60, 15, 'employee', 1461037445, 1461037445, 13, 13, b'0'),
	(75, 1, 60, 16, 'employee', 1461037445, 1461037445, 13, 13, b'0'),
	(76, 1, 61, 5, 'department', 1461040865, 1461040865, 13, 13, b'0'),
	(77, 1, 61, 4, 'department', 1461040865, 1461040865, 13, 13, b'0'),
	(78, 1, 61, 13, 'employee', 1461040865, 1461040865, 13, 13, b'0'),
	(79, 1, 62, 4, 'department', 1461053327, 1461053327, 13, 13, b'0'),
	(80, 1, 62, 3, 'department', 1461053327, 1461053327, 13, 13, b'0'),
	(81, 1, 62, 6, 'department', 1461053327, 1461053327, 13, 13, b'0'),
	(82, 1, 62, 14, 'employee', 1461053327, 1461053327, 13, 13, b'0'),
	(83, 1, 62, 15, 'employee', 1461053327, 1461053327, 13, 13, b'0'),
	(84, 2, 63, 1, 'department', 1461053399, 1461053399, 21, 21, b'0'),
	(85, 2, 63, 21, 'employee', 1461053399, 1461053399, 21, 21, b'0'),
	(86, 2, 64, 1, 'department', 1461058151, 1461058151, 22, 22, b'0'),
	(87, 2, 64, 22, 'employee', 1461058151, 1461058151, 22, 22, b'0'),
	(88, 2, 65, 2, 'department', 1461129959, 1461129959, 22, 22, b'0'),
	(89, 2, 65, 13, 'employee', 1461129959, 1461129959, 22, 22, b'0'),
	(90, 2, 65, 14, 'employee', 1461129959, 1461129959, 22, 22, b'0'),
	(91, 2, 65, 15, 'employee', 1461129959, 1461129959, 22, 22, b'0'),
	(92, 2, 65, 16, 'employee', 1461129959, 1461129959, 22, 22, b'0'),
	(93, 1, 66, 2, 'department', 1461136235, 1461136235, 13, 13, b'0'),
	(94, 1, 66, 14, 'employee', 1461136235, 1461136235, 13, 13, b'0'),
	(95, 1, 66, 13, 'employee', 1461136235, 1461136235, 13, 13, b'0'),
	(96, 1, 66, 15, 'employee', 1461136235, 1461136235, 13, 13, b'0'),
	(97, 1, 67, 14, 'employee', 1461136312, 1461136312, 13, 13, b'0'),
	(98, 1, 68, 1, 'department', 1461137201, 1461137201, 13, 13, b'0'),
	(99, 1, 68, 14, 'employee', 1461137201, 1461137201, 13, 13, b'0'),
	(100, 2, 75, 22, 'employee', 1461143718, 1461143718, 22, 22, b'0'),
	(101, 2, 76, 1, 'department', 1461143877, 1461143877, 22, 22, b'0'),
	(102, 2, 76, 2, 'department', 1461143877, 1461143877, 22, 22, b'0'),
	(103, 2, 76, 22, 'employee', 1461143877, 1461143877, 22, 22, b'0'),
	(104, 2, 77, 2, 'department', 1461168668, 1461168668, 22, 22, b'0'),
	(105, 2, 77, 1, 'department', 1461168668, 1461168668, 22, 22, b'0'),
	(106, 2, 77, 22, 'employee', 1461168668, 1461168668, 22, 22, b'0'),
	(107, 1, 78, 4, 'department', 1461280058, 1461280058, 13, 13, b'0'),
	(108, 1, 78, 13, 'employee', 1461280058, 1461280058, 13, 13, b'0'),
	(109, 1, 78, 15, 'employee', 1461280058, 1461280058, 13, 13, b'0'),
	(110, 1, 78, 16, 'employee', 1461280058, 1461280058, 13, 13, b'0'),
	(111, 1, 78, 14, 'employee', 1461280058, 1461280058, 13, 13, b'0'),
	(112, 1, 79, 3, 'department', 1461282768, 1461282768, 13, 13, b'0'),
	(113, 1, 79, 13, 'employee', 1461282768, 1461282768, 13, 13, b'0'),
	(114, 1, 80, 3, 'department', 1461299599, 1461299599, 13, 13, b'0'),
	(115, 1, 80, 2, 'employee', 1461299599, 1461299599, 13, 13, b'0'),
	(116, 1, 80, 14, 'employee', 1461299599, 1461299599, 13, 13, b'0'),
	(117, 1, 80, 17, 'employee', 1461299599, 1461299599, 13, 13, b'0'),
	(118, 1, 83, 3, 'department', 1461349941, 1461349941, 13, 13, b'0'),
	(119, 1, 83, 14, 'employee', 1461349941, 1461349941, 13, 13, b'0'),
	(120, 2, 85, 1, 'department', 1461350392, 1461350392, 21, 21, b'0'),
	(121, 2, 85, 2, 'department', 1461350392, 1461350392, 21, 21, b'0'),
	(122, 2, 85, 22, 'employee', 1461350392, 1461350392, 21, 21, b'0'),
	(123, 1, 86, 3, 'department', 1461350646, 1461350646, 14, 14, b'0'),
	(124, 1, 86, 13, 'employee', 1461350646, 1461350646, 14, 14, b'0');
/*!40000 ALTER TABLE `project_participant` ENABLE KEYS */;


-- Dumping structure for table centeroffice.province
CREATE TABLE IF NOT EXISTS `province` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `name` (`name`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.province: ~0 rows (approximately)
/*!40000 ALTER TABLE `province` DISABLE KEYS */;
/*!40000 ALTER TABLE `province` ENABLE KEYS */;


-- Dumping structure for table centeroffice.religion
CREATE TABLE IF NOT EXISTS `religion` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.religion: ~0 rows (approximately)
/*!40000 ALTER TABLE `religion` DISABLE KEYS */;
/*!40000 ALTER TABLE `religion` ENABLE KEYS */;


-- Dumping structure for table centeroffice.remind
CREATE TABLE IF NOT EXISTS `remind` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci,
  `remind_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `minute_before` int(11) unsigned NOT NULL DEFAULT '0',
  `repeated_time` int(11) unsigned NOT NULL DEFAULT '0',
  `is_snoozing` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_id` (`owner_id`),
  KEY `owner_table` (`owner_table`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.remind: ~0 rows (approximately)
/*!40000 ALTER TABLE `remind` DISABLE KEYS */;
/*!40000 ALTER TABLE `remind` ENABLE KEYS */;


-- Dumping structure for table centeroffice.reply
CREATE TABLE IF NOT EXISTS `reply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `message_id` int(11) unsigned DEFAULT '0',
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  KEY `employee_id` (`employee_id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.reply: ~0 rows (approximately)
/*!40000 ALTER TABLE `reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `reply` ENABLE KEYS */;


-- Dumping structure for table centeroffice.requestment
CREATE TABLE IF NOT EXISTS `requestment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `requestment_category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `review_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `period_time` smallint(6) unsigned NOT NULL,
  `reason` mediumtext COLLATE utf8_unicode_ci,
  `is_accept` bit(1) NOT NULL DEFAULT b'0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `requestment_group_id` (`requestment_category_id`),
  KEY `reviewing_employee_id` (`review_employee_id`),
  KEY `is_accept` (`is_accept`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.requestment: ~0 rows (approximately)
/*!40000 ALTER TABLE `requestment` DISABLE KEYS */;
/*!40000 ALTER TABLE `requestment` ENABLE KEYS */;


-- Dumping structure for table centeroffice.requestment_allocation
CREATE TABLE IF NOT EXISTS `requestment_allocation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `requestment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `task_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `requestment_id` (`requestment_id`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.requestment_allocation: ~0 rows (approximately)
/*!40000 ALTER TABLE `requestment_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `requestment_allocation` ENABLE KEYS */;


-- Dumping structure for table centeroffice.requestment_category
CREATE TABLE IF NOT EXISTS `requestment_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` mediumtext COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.requestment_category: ~0 rows (approximately)
/*!40000 ALTER TABLE `requestment_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `requestment_category` ENABLE KEYS */;


-- Dumping structure for table centeroffice.sending_template_group
CREATE TABLE IF NOT EXISTS `sending_template_group` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `column_name` (`column_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.sending_template_group: ~1 rows (approximately)
/*!40000 ALTER TABLE `sending_template_group` DISABLE KEYS */;
INSERT INTO `sending_template_group` (`id`, `name`, `column_name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 'event', 'event', NULL, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `sending_template_group` ENABLE KEYS */;


-- Dumping structure for table centeroffice.sms
CREATE TABLE IF NOT EXISTS `sms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `owner_table` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'table join to',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_success` bit(1) NOT NULL DEFAULT b'1',
  `fee` int(11) unsigned DEFAULT '0',
  `agency_gateway` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `employee_id` (`employee_id`),
  KEY `owner_table` (`owner_table`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.sms: ~203 rows (approximately)
/*!40000 ALTER TABLE `sms` DISABLE KEYS */;
INSERT INTO `sms` (`id`, `company_id`, `owner_id`, `employee_id`, `owner_table`, `content`, `is_success`, `fee`, `agency_gateway`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 2, 1, 'project', 'kk  Ngày tạo  Test new database with company_id', b'1', 0, NULL, 1460106964, 1460106964, 1, 1, b'0'),
	(2, 32, 9, 2, 'project', 'kk  Ngày tạo  Test project just integration', b'1', 0, NULL, 1460192720, 1460192720, 24, 24, b'0'),
	(3, 32, 10, 2, 'project', 'kk  Ngày tạo  Test opera', b'1', 0, NULL, 1460204129, 1460204129, 24, 24, b'0'),
	(4, 32, 11, 2, 'project', 'kk  Ngày tạo  f', b'1', 0, NULL, 1460251615, 1460251615, 24, 24, b'0'),
	(5, 1, 12, 1, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432558, 1460432558, 24, 24, b'0'),
	(6, 1, 12, 2, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432558, 1460432558, 24, 24, b'0'),
	(7, 1, 12, 13, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(8, 1, 12, 14, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(9, 1, 12, 15, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(10, 1, 12, 16, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(11, 1, 12, 17, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(12, 1, 12, 18, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(13, 1, 12, 19, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(14, 1, 12, 20, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(15, 1, 12, 21, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(16, 1, 12, 22, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(17, 1, 12, 23, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(18, 1, 12, 24, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(19, 1, 12, 25, 'project', 'kk  đã tạo  test upload file', b'1', 0, NULL, 1460432559, 1460432559, 24, 24, b'0'),
	(20, 1, 15, 1, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(21, 1, 15, 2, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(22, 1, 15, 13, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(23, 1, 15, 14, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(24, 1, 15, 15, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(25, 1, 15, 16, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(26, 1, 15, 17, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(27, 1, 15, 18, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(28, 1, 15, 19, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(29, 1, 15, 20, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(30, 1, 15, 21, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(31, 1, 15, 22, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(32, 1, 15, 23, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(33, 1, 15, 24, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(34, 1, 15, 25, 'project', 'le van tam  đã tạo  Test insert new record employee', b'1', 0, NULL, 1460435172, 1460435172, 22, 22, b'0'),
	(35, 1, 20, 1, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(36, 1, 20, 2, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(37, 1, 20, 13, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(38, 1, 20, 14, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(39, 1, 20, 15, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(40, 1, 20, 16, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(41, 1, 20, 17, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(42, 1, 20, 18, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(43, 1, 20, 19, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(44, 1, 20, 20, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(45, 1, 20, 21, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(46, 1, 20, 22, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(47, 1, 20, 23, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438530, 1460438530, 22, 22, b'0'),
	(48, 1, 20, 24, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438531, 1460438531, 22, 22, b'0'),
	(49, 1, 20, 25, 'project', 'le van tam  đã tạo  Test project manager no show in', b'1', 0, NULL, 1460438531, 1460438531, 22, 22, b'0'),
	(50, 1, 23, 1, 'project', 'pham van linh  đã tạo  Test new integration', b'1', 0, NULL, 1460897201, 1460897201, 20, 20, b'0'),
	(51, 1, 23, 2, 'project', 'pham van linh  đã tạo  Test new integration', b'1', 0, NULL, 1460897201, 1460897201, 20, 20, b'0'),
	(52, 1, 23, 13, 'project', 'pham van linh  đã tạo  Test new integration', b'1', 0, NULL, 1460897201, 1460897201, 20, 20, b'0'),
	(53, 1, 23, 14, 'project', 'pham van linh  đã tạo  Test new integration', b'1', 0, NULL, 1460897201, 1460897201, 20, 20, b'0'),
	(54, 1, 23, 16, 'project', 'pham van linh  đã tạo  Test new integration', b'1', 0, NULL, 1460897201, 1460897201, 20, 20, b'0'),
	(55, 1, 24, 1, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(56, 1, 24, 2, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(57, 1, 24, 13, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(58, 1, 24, 14, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(59, 1, 24, 15, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(60, 1, 24, 16, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(61, 1, 24, 17, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(62, 1, 24, 18, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(63, 1, 24, 19, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(64, 1, 24, 20, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(65, 1, 24, 21, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897440, 1460897440, 20, 20, b'0'),
	(66, 1, 24, 22, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897441, 1460897441, 20, 20, b'0'),
	(67, 1, 24, 23, 'project', 'pham van linh  đã tạo  Test new integrate again.', b'1', 0, NULL, 1460897441, 1460897441, 20, 20, b'0'),
	(68, 2, 25, 1, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(69, 2, 25, 2, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(70, 2, 25, 13, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(71, 2, 25, 14, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(72, 2, 25, 15, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(73, 2, 25, 16, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(74, 2, 25, 17, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(75, 2, 25, 18, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(76, 2, 25, 19, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(77, 2, 25, 20, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(78, 2, 25, 21, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(79, 2, 25, 22, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(80, 2, 25, 23, 'project', 'ta hong gam  đã tạo  Ta hong gam company 2', b'1', 0, NULL, 1460940641, 1460940641, 21, 21, b'0'),
	(81, 1, 26, 1, 'project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'1', 0, NULL, 1460942521, 1460942521, 16, 16, b'0'),
	(82, 1, 26, 2, 'project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'1', 0, NULL, 1460942521, 1460942521, 16, 16, b'0'),
	(83, 1, 26, 13, 'project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'1', 0, NULL, 1460942521, 1460942521, 16, 16, b'0'),
	(84, 1, 26, 14, 'project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'1', 0, NULL, 1460942521, 1460942521, 16, 16, b'0'),
	(85, 1, 26, 17, 'project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', b'1', 0, NULL, 1460942521, 1460942521, 16, 16, b'0'),
	(86, 2, 42, 1, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(87, 2, 42, 2, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(88, 2, 42, 13, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(89, 2, 42, 14, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(90, 2, 42, 15, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(91, 2, 42, 16, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(92, 2, 42, 17, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(93, 2, 42, 21, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(94, 2, 42, 22, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(95, 2, 42, 23, 'project', 'ta hong gam  đã tạo  Test add compnay_id employee', b'1', 0, NULL, 1460971104, 1460971104, 21, 21, b'0'),
	(96, 1, 62, 1, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053327, 1461053327, 13, 13, b'0'),
	(97, 1, 62, 2, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053327, 1461053327, 13, 13, b'0'),
	(98, 1, 62, 13, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053327, 1461053327, 13, 13, b'0'),
	(99, 1, 62, 14, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053327, 1461053327, 13, 13, b'0'),
	(100, 1, 62, 15, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053327, 1461053327, 13, 13, b'0'),
	(101, 1, 62, 16, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053327, 1461053327, 13, 13, b'0'),
	(102, 1, 62, 17, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053327, 1461053327, 13, 13, b'0'),
	(103, 1, 62, 18, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053327, 1461053327, 13, 13, b'0'),
	(104, 1, 62, 19, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053328, 1461053328, 13, 13, b'0'),
	(105, 1, 62, 20, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053328, 1461053328, 13, 13, b'0'),
	(106, 1, 62, 21, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053328, 1461053328, 13, 13, b'0'),
	(107, 1, 62, 22, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053328, 1461053328, 13, 13, b'0'),
	(108, 1, 62, 23, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053328, 1461053328, 13, 13, b'0'),
	(109, 2, 64, 1, 'project', 'le van tam  đã tạo  dfadsfdsf', b'1', 0, NULL, 1461058151, 1461058151, 22, 22, b'0'),
	(110, 2, 64, 2, 'project', 'le van tam  đã tạo  dfadsfdsf', b'1', 0, NULL, 1461058151, 1461058151, 22, 22, b'0'),
	(111, 2, 64, 13, 'project', 'le van tam  đã tạo  dfadsfdsf', b'1', 0, NULL, 1461058151, 1461058151, 22, 22, b'0'),
	(112, 2, 64, 14, 'project', 'le van tam  đã tạo  dfadsfdsf', b'1', 0, NULL, 1461058151, 1461058151, 22, 22, b'0'),
	(113, 2, 64, 21, 'project', 'le van tam  đã tạo  dfadsfdsf', b'1', 0, NULL, 1461058151, 1461058151, 22, 22, b'0'),
	(114, 2, 64, 22, 'project', 'le van tam  đã tạo  dfadsfdsf', b'1', 0, NULL, 1461058151, 1461058151, 22, 22, b'0'),
	(115, 2, 64, 23, 'project', 'le van tam  đã tạo  dfadsfdsf', b'1', 0, NULL, 1461058151, 1461058151, 22, 22, b'0'),
	(116, 2, 65, 13, 'project', 'le van tam  đã tạo  test safaris', b'1', 0, NULL, 1461129964, 1461129964, 22, 22, b'0'),
	(117, 2, 65, 14, 'project', 'le van tam  đã tạo  test safaris', b'1', 0, NULL, 1461129966, 1461129966, 22, 22, b'0'),
	(118, 2, 65, 15, 'project', 'le van tam  đã tạo  test safaris', b'1', 0, NULL, 1461129966, 1461129966, 22, 22, b'0'),
	(119, 2, 65, 16, 'project', 'le van tam  đã tạo  test safaris', b'1', 0, NULL, 1461129966, 1461129966, 22, 22, b'0'),
	(120, 2, 65, 17, 'project', 'le van tam  đã tạo  test safaris', b'1', 0, NULL, 1461129966, 1461129966, 22, 22, b'0'),
	(121, 2, 77, 1, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(122, 2, 77, 2, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(123, 2, 77, 13, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(124, 2, 77, 14, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(125, 2, 77, 15, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(126, 2, 77, 16, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(127, 2, 77, 17, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(128, 2, 77, 21, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(129, 2, 77, 22, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(130, 2, 77, 23, 'project', 'le van tam  đã tạo  Check again Hung task.', b'1', 0, NULL, 1461168669, 1461168669, 22, 22, b'0'),
	(131, 1, 80, 1, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(132, 1, 80, 2, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(133, 1, 80, 13, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(134, 1, 80, 14, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(135, 1, 80, 15, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(136, 1, 80, 16, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(137, 1, 80, 17, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(138, 1, 80, 18, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(139, 1, 80, 19, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(140, 1, 80, 20, 'project', 'vu thuy trinh  đã tạo  abc', b'1', 0, NULL, 1461299599, 1461299599, 13, 13, b'0'),
	(141, 1, 83, 1, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(142, 1, 83, 2, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(143, 1, 83, 13, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(144, 1, 83, 14, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(145, 1, 83, 15, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(146, 1, 83, 16, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(147, 1, 83, 17, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(148, 1, 83, 18, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(149, 1, 83, 19, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(150, 1, 83, 20, 'project', 'vu thuy trinh  đã tạo  Test chromeTest chromeTest chromeTest chrome', b'1', 0, NULL, 1461349941, 1461349941, 13, 13, b'0'),
	(151, 2, 85, 21, 'project', 'ta hong gam  đã tạo  TEst opera', b'1', 0, NULL, 1461350392, 1461350392, 21, 21, b'0'),
	(152, 2, 85, 22, 'project', 'ta hong gam  đã tạo  TEst opera', b'1', 0, NULL, 1461350392, 1461350392, 21, 21, b'0'),
	(153, 2, 85, 23, 'project', 'ta hong gam  đã tạo  TEst opera', b'1', 0, NULL, 1461350392, 1461350392, 21, 21, b'0'),
	(154, 1, 86, 1, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0'),
	(155, 1, 86, 2, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0'),
	(156, 1, 86, 13, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0'),
	(157, 1, 86, 14, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0'),
	(158, 1, 86, 15, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0'),
	(159, 1, 86, 16, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0'),
	(160, 1, 86, 17, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0'),
	(161, 1, 86, 18, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0'),
	(162, 1, 86, 19, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0'),
	(163, 1, 86, 20, 'project', 'vu quoc hoa  đã tạo  Test cococ', b'1', 0, NULL, 1461350647, 1461350647, 14, 14, b'0');
/*!40000 ALTER TABLE `sms` ENABLE KEYS */;


-- Dumping structure for table centeroffice.sms_template
CREATE TABLE IF NOT EXISTS `sms_template` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `sending_template_group_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `language_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `body` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `default_from_phone_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `sending_template_group_id` (`sending_template_group_id`),
  KEY `column_name` (`column_name`),
  KEY `language_code` (`language_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.sms_template: ~4 rows (approximately)
/*!40000 ALTER TABLE `sms_template` DISABLE KEYS */;
INSERT INTO `sms_template` (`id`, `sending_template_group_id`, `language_id`, `body`, `column_name`, `default_from_phone_no`, `language_code`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 0, '{creator name} created event of {event name}', 'create_event', '0919644092', 'en', 0, 0, 0, 0, b'0'),
	(2, 1, 0, '{creator name} đã tạo sự kiện {event name}', 'create_event', '0919644092', 'vi', 0, 0, 0, 0, b'0'),
	(3, 1, 0, '{creator name} edited event of {event name}', 'edit_event', '0919644092', 'en', 0, 0, 0, 0, b'0'),
	(4, 1, 0, '{creator name} đã chỉnh sửa sự kiện {event name}', 'edit_event', '0919644092', 'vi', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `sms_template` ENABLE KEYS */;


-- Dumping structure for table centeroffice.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `authority_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `job_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `phone_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `leaving_date` int(11) unsigned DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `name` (`name`),
  KEY `email` (`email`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.staff: ~0 rows (approximately)
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;


-- Dumping structure for table centeroffice.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `column_name` (`column_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.status: ~7 rows (approximately)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id`, `company_id`, `name`, `description`, `column_name`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 'Mở', NULL, 'project', 0, 0, 0, 0, b'0'),
	(2, 1, 'Đang làm', NULL, 'project', 0, 0, 0, 0, b'0'),
	(3, 1, 'Hoàn thành', NULL, 'project', 0, 0, 0, 0, b'0'),
	(4, 1, 'Đóng', NULL, 'project', 0, 0, 0, 0, b'0'),
	(5, 2, 'Mở 2', NULL, 'project', 0, 0, 0, 0, b'0'),
	(6, 2, 'Đóng 2', NULL, 'project', 0, 0, 0, 0, b'0'),
	(7, 2, 'Hoàn thanh 2', NULL, 'project', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;


-- Dumping structure for table centeroffice.subject
CREATE TABLE IF NOT EXISTS `subject` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `is_reviewed` bit(1) NOT NULL DEFAULT b'1',
  `total_view` int(11) unsigned NOT NULL DEFAULT '0',
  `total_reply` int(11) unsigned DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `is_reviewed` (`is_reviewed`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.subject: ~0 rows (approximately)
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;


-- Dumping structure for table centeroffice.subscriber
CREATE TABLE IF NOT EXISTS `subscriber` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.subscriber: ~0 rows (approximately)
/*!40000 ALTER TABLE `subscriber` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriber` ENABLE KEYS */;


-- Dumping structure for table centeroffice.system_setting
CREATE TABLE IF NOT EXISTS `system_setting` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `column_name` varchar(99) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique column',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `column_name` (`column_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.system_setting: ~0 rows (approximately)
/*!40000 ALTER TABLE `system_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_setting` ENABLE KEYS */;


-- Dumping structure for table centeroffice.task
CREATE TABLE IF NOT EXISTS `task` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `project_id` int(11) unsigned NOT NULL DEFAULT '0',
  `priority_id` int(11) unsigned NOT NULL DEFAULT '0',
  `status_id` int(11) unsigned NOT NULL DEFAULT '0',
  `kpi_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_parse` mediumtext COLLATE utf8_unicode_ci,
  `start_datetime` int(11) unsigned DEFAULT '0',
  `duedatetime` int(11) unsigned DEFAULT '0',
  `estimate_hour` int(11) unsigned DEFAULT '0',
  `worked_hour` int(11) unsigned DEFAULT '0',
  `completed_percent` tinyint(3) unsigned DEFAULT '0',
  `is_public` bit(1) NOT NULL DEFAULT b'1',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `priority_id` (`priority_id`),
  KEY `status_id` (`status_id`),
  KEY `kpi_id` (`kpi_id`),
  KEY `parent_id` (`parent_id`),
  KEY `employee_id` (`employee_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.task: ~0 rows (approximately)
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
/*!40000 ALTER TABLE `task` ENABLE KEYS */;


-- Dumping structure for table centeroffice.task_assignment
CREATE TABLE IF NOT EXISTS `task_assignment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `task_id` bigint(20) unsigned NOT NULL,
  `employee_id` int(11) unsigned NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`),
  KEY `employee_id` (`employee_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.task_assignment: ~0 rows (approximately)
/*!40000 ALTER TABLE `task_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_assignment` ENABLE KEYS */;


-- Dumping structure for table centeroffice.task_group
CREATE TABLE IF NOT EXISTS `task_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `project_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `project_id` (`project_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.task_group: ~0 rows (approximately)
/*!40000 ALTER TABLE `task_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_group` ENABLE KEYS */;


-- Dumping structure for table centeroffice.task_group_allocation
CREATE TABLE IF NOT EXISTS `task_group_allocation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `task_group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `task_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `task_group_id` (`task_group_id`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.task_group_allocation: ~0 rows (approximately)
/*!40000 ALTER TABLE `task_group_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_group_allocation` ENABLE KEYS */;


-- Dumping structure for table centeroffice.zipcode
CREATE TABLE IF NOT EXISTS `zipcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_created` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_datetime` int(11) unsigned NOT NULL DEFAULT '0',
  `created_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `lastup_employee_id` int(11) unsigned NOT NULL DEFAULT '0',
  `disabled` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  KEY `zipcode` (`zipcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table centeroffice.zipcode: ~0 rows (approximately)
/*!40000 ALTER TABLE `zipcode` DISABLE KEYS */;
/*!40000 ALTER TABLE `zipcode` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
