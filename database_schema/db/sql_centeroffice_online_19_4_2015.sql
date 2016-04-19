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

-- Dumping data for table centeroffice.activity: ~49 rows (approximately)
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
	(51, 2, 63, 'project', 21, 0, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', 0, 0, 1461053399, 1461053399, 21, 21, b'0');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;

-- Dumping data for table centeroffice.activity_post: ~0 rows (approximately)
/*!40000 ALTER TABLE `activity_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_post` ENABLE KEYS */;

-- Dumping data for table centeroffice.annoucement: ~0 rows (approximately)
/*!40000 ALTER TABLE `annoucement` DISABLE KEYS */;
/*!40000 ALTER TABLE `annoucement` ENABLE KEYS */;

-- Dumping data for table centeroffice.attend_choice_event: ~0 rows (approximately)
/*!40000 ALTER TABLE `attend_choice_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `attend_choice_event` ENABLE KEYS */;

-- Dumping data for table centeroffice.authority: ~1 rows (approximately)
/*!40000 ALTER TABLE `authority` DISABLE KEYS */;
INSERT INTO `authority` (`id`, `company_id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 'Tổng giám đốc', 'Quyền cho tổng giám đốc', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `authority` ENABLE KEYS */;

-- Dumping data for table centeroffice.authority_assigment: ~4 rows (approximately)
/*!40000 ALTER TABLE `authority_assigment` DISABLE KEYS */;
INSERT INTO `authority_assigment` (`id`, `company_id`, `authority_id`, `action_id`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 1, 1, 0, 0, 0, 0, b'0'),
	(2, 0, 1, 2, 0, 0, 0, 0, b'0'),
	(3, 0, 1, 9, 0, 0, 0, 0, b'0'),
	(4, 0, 1, 16, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `authority_assigment` ENABLE KEYS */;

-- Dumping data for table centeroffice.bank: ~0 rows (approximately)
/*!40000 ALTER TABLE `bank` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank` ENABLE KEYS */;

-- Dumping data for table centeroffice.business_type: ~0 rows (approximately)
/*!40000 ALTER TABLE `business_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `business_type` ENABLE KEYS */;

-- Dumping data for table centeroffice.cache: ~0 rows (approximately)
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;

-- Dumping data for table centeroffice.calendar: ~1 rows (approximately)
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` (`id`, `company_id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 'traning', '', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;

-- Dumping data for table centeroffice.campaign: ~0 rows (approximately)
/*!40000 ALTER TABLE `campaign` DISABLE KEYS */;
/*!40000 ALTER TABLE `campaign` ENABLE KEYS */;

-- Dumping data for table centeroffice.comment: ~0 rows (approximately)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;

-- Dumping data for table centeroffice.company: ~2 rows (approximately)
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` (`id`, `status_id`, `plan_type_detail_id`, `language_id`, `name`, `email`, `address`, `phone_no`, `domain`, `profile_image_path`, `description_title`, `description`, `start_date`, `expired_date`, `language_code`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 0, 0, 'Centeroffice', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, '', 0, 0, 0, 0, b'0'),
	(2, 1, 0, 0, 'Inet', '', NULL, '', NULL, NULL, NULL, NULL, 0, 0, '', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;

-- Dumping data for table centeroffice.company_allocation: ~0 rows (approximately)
/*!40000 ALTER TABLE `company_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_allocation` ENABLE KEYS */;

-- Dumping data for table centeroffice.controller: ~3 rows (approximately)
/*!40000 ALTER TABLE `controller` DISABLE KEYS */;
INSERT INTO `controller` (`id`, `package_id`, `name`, `description`, `package_name`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 'Default', NULL, NULL, 0, 0, 0, 0, b'0'),
	(2, 0, 'Authority', NULL, NULL, 0, 0, 0, 0, b'0'),
	(3, 0, 'Project', NULL, NULL, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `controller` ENABLE KEYS */;

-- Dumping data for table centeroffice.country: ~0 rows (approximately)
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
/*!40000 ALTER TABLE `country` ENABLE KEYS */;

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

-- Dumping data for table centeroffice.department_annoucement: ~0 rows (approximately)
/*!40000 ALTER TABLE `department_annoucement` DISABLE KEYS */;
/*!40000 ALTER TABLE `department_annoucement` ENABLE KEYS */;

-- Dumping data for table centeroffice.email_template: ~4 rows (approximately)
/*!40000 ALTER TABLE `email_template` DISABLE KEYS */;
INSERT INTO `email_template` (`id`, `sending_template_group_id`, `language_id`, `subject`, `body`, `column_name`, `default_from_email`, `remark`, `language_code`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 0, 'New event', '{creator name} created event of {event name}', 'create_event', 'admin@centeroffice.vn', NULL, 'en', 0, 0, 0, 0, b'0'),
	(2, 1, 0, 'Edit event', '{creator name} edited event of {event name}', 'edit_event', 'admin@centeroffice.vn', NULL, 'en', 0, 0, 0, 0, b'0'),
	(3, 1, 0, 'Sự kiện mới', '{creator name} đã tạo sự kiện {event name}', 'create_event', 'admin@centeroffice.vn', NULL, 'vi', 0, 0, 0, 0, b'0'),
	(4, 1, 0, 'Edit event', '{creator name}đã chỉnh sửa lại sự kiện {event name}', 'edit_event', 'admin@centeroffice.vn', NULL, 'vi', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `email_template` ENABLE KEYS */;

-- Dumping data for table centeroffice.employee: ~13 rows (approximately)
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` (`id`, `company_id`, `manager_employee_id`, `authority_id`, `position_id`, `department_id`, `bank_id`, `religion_id`, `marriage_status_id`, `nation_id`, `province_id`, `country_id`, `status_id`, `language_id`, `city_code`, `firstname`, `lastname`, `password`, `email`, `is_admin`, `code`, `card_number`, `birthdate`, `gender`, `street_address_1`, `street_address_2`, `telephone`, `mobile_phone`, `work_phone`, `card_place_id`, `work_email`, `card_number_id`, `card_issue_id`, `bank_number`, `passport_number`, `passport_place`, `passport_expire`, `zip_code`, `passport_issue`, `tax_date_issue`, `tax_code`, `tax_department`, `start_working_date`, `stop_working_date`, `is_visible`, `profile_image_path`, `language_code`, `password_reset_token`, `auth_key`, `last_activity_datetime`, `last_ip_address`, `last_login_datetime`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'Trần Văn Tài', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'millionairetai@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'millionairetai@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', NULL, NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(2, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'duong thanh vang', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'duongthanhvang@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'millionairetai@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '2.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(13, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'vu thuy trinh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'vuthuytrinh@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'vuthuytrinh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '3.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(14, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'vu quoc hoa', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'vuquochoa@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'vuquochoa@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '4.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(15, 1, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'pham van truong', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'phamvantruong@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'phamvantruong@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '5.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(16, 1, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'le cong vinh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'lecongving@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'lecongving@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '6.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(17, 1, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'duong hoang tuan', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'duonghoangtuan@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'duonghoangtuan@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '7.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(18, 1, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'duong van minh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'duongvanminh@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'duongvanminh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '8.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(19, 1, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'nguyen van minh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'nguyenvanminh@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'nguyenvanminh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '9.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(20, 1, 0, 1, 0, 3, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'pham van linh', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'phamvanminh@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'phamvanminh@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '10.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(21, 2, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'ta hong gam', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'tahonggam@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'tahonggam@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '11.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(22, 2, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'le van tam', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'levantam@gmail.com', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'levantam@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', '12.jpg', NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0'),
	(23, 2, 0, 1, 0, 4, 0, 0, 0, 0, 0, 0, 10, 0, NULL, 'Nguyễn Văn Nhật', '', '$2y$13$DfeLFr4DJp9o5i2WKlSUxe/SGRV174jgj6fednbiMy4b/JggsP.vi', 'millionairetai@gmail.com1', b'1', NULL, NULL, 0, b'0', NULL, NULL, NULL, NULL, NULL, NULL, 'millionairetai@gmail.com', NULL, 0, NULL, NULL, NULL, 0, NULL, 0, 0, NULL, NULL, 0, 0, b'1', NULL, NULL, NULL, 'tTMI_AgZHv686il31upWy-And3fg1b2B', 0, NULL, 0, 1450334587, 1450334587, 0, 0, b'0');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;

-- Dumping data for table centeroffice.employee_activity: ~8 rows (approximately)
/*!40000 ALTER TABLE `employee_activity` DISABLE KEYS */;
INSERT INTO `employee_activity` (`id`, `company_id`, `employee_id`, `activity_project`, `activity_task`, `activity_calendar`, `activity_annoucement`, `activity_statergy_map`, `activity_kpi`, `activity_employee`, `activity_contract`, `activity_subject`, `activity_post`, `activity_total`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 1, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 11, 1460106767, 1460251615, 1, 24, b'0'),
	(2, 1, 24, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 1460432558, 1460434734, 24, 24, b'0'),
	(3, 1, 22, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 1460435172, 1460438955, 22, 22, b'0'),
	(4, 1, 20, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 1460896313, 1460967045, 20, 20, b'0'),
	(5, 2, 21, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6, 1460940641, 1461053399, 21, 21, b'0'),
	(6, 1, 16, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1460942521, 1460943326, 16, 16, b'0'),
	(7, 1, 17, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 1460943582, 1460944281, 17, 17, b'0'),
	(8, 1, 13, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 13, 1460963353, 1461053327, 13, 13, b'0');
/*!40000 ALTER TABLE `employee_activity` ENABLE KEYS */;

-- Dumping data for table centeroffice.employee_ip: ~0 rows (approximately)
/*!40000 ALTER TABLE `employee_ip` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_ip` ENABLE KEYS */;

-- Dumping data for table centeroffice.employee_space: ~7 rows (approximately)
/*!40000 ALTER TABLE `employee_space` DISABLE KEYS */;
INSERT INTO `employee_space` (`id`, `company_id`, `employee_id`, `space_project`, `space_task`, `space_calendar`, `space_annoucement`, `space_statergy_map`, `space_kpi`, `space_employee`, `space_contract`, `space_subject`, `space_activity_post`, `space_total`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 32, 24, 6766817, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6766817, 1460192720, 1460434734, 24, 24, b'0'),
	(2, 1, 22, 5125861, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5125861, 1460435171, 1460438955, 22, 22, b'0'),
	(3, 1, 20, 4366512, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4366512, 1460897200, 1460967045, 20, 20, b'0'),
	(4, 2, 21, 7835173, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7835173, 1460940641, 1460962572, 21, 21, b'0'),
	(5, 1, 16, 6196, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6196, 1460942520, 1460943325, 16, 16, b'0'),
	(6, 1, 17, 474879, 0, 0, 0, 0, 0, 0, 0, 0, 0, 474879, 1460943582, 1460944281, 17, 17, b'0'),
	(7, 1, 13, 755589, 0, 0, 0, 0, 0, 0, 0, 0, 0, 755589, 1460963353, 1460963676, 13, 13, b'0');
/*!40000 ALTER TABLE `employee_space` ENABLE KEYS */;

-- Dumping data for table centeroffice.event: ~0 rows (approximately)
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;

-- Dumping data for table centeroffice.event_confirmation: ~0 rows (approximately)
/*!40000 ALTER TABLE `event_confirmation` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_confirmation` ENABLE KEYS */;

-- Dumping data for table centeroffice.file: ~131 rows (approximately)
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
	(107, 1, 38, 20, 'project', 'check box.doc', '19df75c30d954c1d90e276b28e354fd4.doc', '1\\2016\\04\\19df75c30d954c1d90e276b28e354fd4.doc', b'0', 'doc', 54272, 1460967045, 1460967045, 20, 20, b'0');
/*!40000 ALTER TABLE `file` ENABLE KEYS */;

-- Dumping data for table centeroffice.follower: ~0 rows (approximately)
/*!40000 ALTER TABLE `follower` DISABLE KEYS */;
/*!40000 ALTER TABLE `follower` ENABLE KEYS */;

-- Dumping data for table centeroffice.forum: ~0 rows (approximately)
/*!40000 ALTER TABLE `forum` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum` ENABLE KEYS */;

-- Dumping data for table centeroffice.forum_group: ~0 rows (approximately)
/*!40000 ALTER TABLE `forum_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_group` ENABLE KEYS */;

-- Dumping data for table centeroffice.invitation: ~0 rows (approximately)
/*!40000 ALTER TABLE `invitation` DISABLE KEYS */;
/*!40000 ALTER TABLE `invitation` ENABLE KEYS */;

-- Dumping data for table centeroffice.invoice: ~0 rows (approximately)
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;

-- Dumping data for table centeroffice.languague: ~2 rows (approximately)
/*!40000 ALTER TABLE `languague` DISABLE KEYS */;
INSERT INTO `languague` (`id`, `name`, `language_code`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 'Vietnamese', 'vi', 0, 0, 0, 0, b'0'),
	(2, 'English', 'en', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `languague` ENABLE KEYS */;

-- Dumping data for table centeroffice.like: ~0 rows (approximately)
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
/*!40000 ALTER TABLE `like` ENABLE KEYS */;

-- Dumping data for table centeroffice.marriage_status: ~0 rows (approximately)
/*!40000 ALTER TABLE `marriage_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `marriage_status` ENABLE KEYS */;

-- Dumping data for table centeroffice.message: ~0 rows (approximately)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

-- Dumping data for table centeroffice.migration: ~2 rows (approximately)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1450325349),
	('m130524_201442_init', 1450325367);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

-- Dumping data for table centeroffice.nation: ~0 rows (approximately)
/*!40000 ALTER TABLE `nation` DISABLE KEYS */;
/*!40000 ALTER TABLE `nation` ENABLE KEYS */;

-- Dumping data for table centeroffice.news: ~0 rows (approximately)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

-- Dumping data for table centeroffice.news_allocation: ~0 rows (approximately)
/*!40000 ALTER TABLE `news_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_allocation` ENABLE KEYS */;

-- Dumping data for table centeroffice.news_category: ~0 rows (approximately)
/*!40000 ALTER TABLE `news_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_category` ENABLE KEYS */;

-- Dumping data for table centeroffice.notification: ~219 rows (approximately)
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` (`id`, `company_id`, `owner_id`, `owner_table`, `employee_id`, `owner_employee_id`, `type`, `content`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 0, 1, 'project', 1, 1, 'create_project', 'kk  Ngày tạo  Test new databaseTest new databaseTest new databaseTest new database', 1460106767, 1460106767, 1, 1, b'0'),
	(2, 0, 2, 'project', 1, 1, 'create_project', 'kk  Ngày tạo  Test new database with company_id', 1460106964, 1460106964, 1, 1, b'0'),
	(3, 32, 9, 'project', 2, 24, 'create_project', 'kk  Ngày tạo  Test project just integration', 1460192720, 1460192720, 24, 24, b'0'),
	(4, 32, 10, 'project', 2, 24, 'create_project', 'kk  Ngày tạo  Test opera', 1460204129, 1460204129, 24, 24, b'0'),
	(5, 32, 11, 'project', 2, 24, 'create_project', 'kk  Ngày tạo  f', 1460251615, 1460251615, 24, 24, b'0'),
	(6, 1, 12, 'project', 1, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432558, 1460432558, 24, 24, b'0'),
	(7, 1, 12, 'project', 2, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432558, 1460432558, 24, 24, b'0'),
	(8, 1, 12, 'project', 13, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(9, 1, 12, 'project', 14, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(10, 1, 12, 'project', 15, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(11, 1, 12, 'project', 16, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(12, 1, 12, 'project', 17, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(13, 1, 12, 'project', 18, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(14, 1, 12, 'project', 19, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(15, 1, 12, 'project', 20, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(16, 1, 12, 'project', 21, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(17, 1, 12, 'project', 22, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(18, 1, 12, 'project', 23, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(19, 1, 12, 'project', 24, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(20, 1, 12, 'project', 25, 24, 'create_project', 'kk  đã tạo  test upload file', 1460432559, 1460432559, 24, 24, b'0'),
	(21, 1, 13, 'project', 1, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(22, 1, 13, 'project', 2, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(23, 1, 13, 'project', 13, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(24, 1, 13, 'project', 14, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(25, 1, 13, 'project', 15, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(26, 1, 13, 'project', 16, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(27, 1, 13, 'project', 17, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(28, 1, 13, 'project', 18, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(29, 1, 13, 'project', 19, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(30, 1, 13, 'project', 20, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(31, 1, 13, 'project', 21, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(32, 1, 13, 'project', 22, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(33, 1, 13, 'project', 23, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(34, 1, 13, 'project', 24, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(35, 1, 13, 'project', 25, 24, 'create_project', 'kk  đã tạo  Test project upload', 1460434275, 1460434275, 24, 24, b'0'),
	(36, 1, 15, 'project', 1, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(37, 1, 15, 'project', 2, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(38, 1, 15, 'project', 13, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(39, 1, 15, 'project', 14, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(40, 1, 15, 'project', 15, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(41, 1, 15, 'project', 16, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(42, 1, 15, 'project', 17, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(43, 1, 15, 'project', 18, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(44, 1, 15, 'project', 19, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(45, 1, 15, 'project', 20, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(46, 1, 15, 'project', 21, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(47, 1, 15, 'project', 22, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(48, 1, 15, 'project', 23, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(49, 1, 15, 'project', 24, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(50, 1, 15, 'project', 25, 22, 'create_project', 'le van tam  đã tạo  Test insert new record employee', 1460435172, 1460435172, 22, 22, b'0'),
	(51, 1, 20, 'project', 1, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(52, 1, 20, 'project', 2, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(53, 1, 20, 'project', 13, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(54, 1, 20, 'project', 14, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(55, 1, 20, 'project', 15, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(56, 1, 20, 'project', 16, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(57, 1, 20, 'project', 17, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(58, 1, 20, 'project', 18, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(59, 1, 20, 'project', 19, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(60, 1, 20, 'project', 20, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(61, 1, 20, 'project', 21, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(62, 1, 20, 'project', 22, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(63, 1, 20, 'project', 23, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(64, 1, 20, 'project', 24, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438530, 1460438530, 22, 22, b'0'),
	(65, 1, 20, 'project', 25, 22, 'create_project', 'le van tam  đã tạo  Test project manager no show in', 1460438531, 1460438531, 22, 22, b'0'),
	(66, 1, 23, 'project', 1, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', 1460897200, 1460897200, 20, 20, b'0'),
	(67, 1, 23, 'project', 2, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', 1460897201, 1460897201, 20, 20, b'0'),
	(68, 1, 23, 'project', 13, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', 1460897201, 1460897201, 20, 20, b'0'),
	(69, 1, 23, 'project', 14, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', 1460897201, 1460897201, 20, 20, b'0'),
	(70, 1, 23, 'project', 16, 20, 'create_project', 'pham van linh  đã tạo  Test new integration', 1460897201, 1460897201, 20, 20, b'0'),
	(71, 1, 24, 'project', 1, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(72, 1, 24, 'project', 2, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(73, 1, 24, 'project', 13, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(74, 1, 24, 'project', 14, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(75, 1, 24, 'project', 15, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(76, 1, 24, 'project', 16, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(77, 1, 24, 'project', 17, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(78, 1, 24, 'project', 18, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(79, 1, 24, 'project', 19, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(80, 1, 24, 'project', 20, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(81, 1, 24, 'project', 21, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897440, 1460897440, 20, 20, b'0'),
	(82, 1, 24, 'project', 22, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897441, 1460897441, 20, 20, b'0'),
	(83, 1, 24, 'project', 23, 20, 'create_project', 'pham van linh  đã tạo  Test new integrate again.', 1460897441, 1460897441, 20, 20, b'0'),
	(84, 2, 25, 'project', 1, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(85, 2, 25, 'project', 2, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(86, 2, 25, 'project', 13, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(87, 2, 25, 'project', 14, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(88, 2, 25, 'project', 15, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(89, 2, 25, 'project', 16, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(90, 2, 25, 'project', 17, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(91, 2, 25, 'project', 18, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(92, 2, 25, 'project', 19, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(93, 2, 25, 'project', 20, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(94, 2, 25, 'project', 21, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(95, 2, 25, 'project', 22, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(96, 2, 25, 'project', 23, 21, 'create_project', 'ta hong gam  đã tạo  Ta hong gam company 2', 1460940641, 1460940641, 21, 21, b'0'),
	(97, 1, 26, 'project', 1, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', 1460942521, 1460942521, 16, 16, b'0'),
	(98, 1, 26, 'project', 2, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', 1460942521, 1460942521, 16, 16, b'0'),
	(99, 1, 26, 'project', 13, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', 1460942521, 1460942521, 16, 16, b'0'),
	(100, 1, 26, 'project', 14, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', 1460942521, 1460942521, 16, 16, b'0'),
	(101, 1, 26, 'project', 17, 16, 'create_project', 'le cong vinh  đã tạo  Test upload file changeTest upload file change', 1460942521, 1460942521, 16, 16, b'0'),
	(102, 1, 27, 'project', 1, 16, 'create_project', 'le cong vinh  đã tạo  Test new upload filder folder', 1460943326, 1460943326, 16, 16, b'0'),
	(103, 1, 27, 'project', 2, 16, 'create_project', 'le cong vinh  đã tạo  Test new upload filder folder', 1460943326, 1460943326, 16, 16, b'0'),
	(104, 1, 27, 'project', 13, 16, 'create_project', 'le cong vinh  đã tạo  Test new upload filder folder', 1460943326, 1460943326, 16, 16, b'0'),
	(105, 1, 27, 'project', 14, 16, 'create_project', 'le cong vinh  đã tạo  Test new upload filder folder', 1460943326, 1460943326, 16, 16, b'0'),
	(106, 2, 42, 'project', 1, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(107, 2, 42, 'project', 2, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(108, 2, 42, 'project', 13, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(109, 2, 42, 'project', 14, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(110, 2, 42, 'project', 15, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(111, 2, 42, 'project', 16, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(112, 2, 42, 'project', 17, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(113, 2, 42, 'project', 21, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(114, 2, 42, 'project', 22, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(115, 2, 42, 'project', 23, 21, 'create_project', 'ta hong gam  đã tạo  Test add compnay_id employee', 1460971104, 1460971104, 21, 21, b'0'),
	(116, 1, 43, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(117, 1, 43, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(118, 1, 43, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(119, 1, 43, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(120, 1, 43, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(121, 1, 43, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(122, 1, 43, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(123, 1, 43, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(124, 1, 43, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(125, 1, 43, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  Test company id 1', 1460971216, 1460971216, 13, 13, b'0'),
	(126, 1, 57, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981393, 1460981393, 13, 13, b'0'),
	(127, 1, 57, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981394, 1460981394, 13, 13, b'0'),
	(128, 1, 57, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981394, 1460981394, 13, 13, b'0'),
	(129, 1, 57, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981394, 1460981394, 13, 13, b'0'),
	(130, 1, 57, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981394, 1460981394, 13, 13, b'0'),
	(131, 1, 57, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981394, 1460981394, 13, 13, b'0'),
	(132, 1, 57, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981394, 1460981394, 13, 13, b'0'),
	(133, 1, 57, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981394, 1460981394, 13, 13, b'0'),
	(134, 1, 57, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981394, 1460981394, 13, 13, b'0'),
	(135, 1, 57, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  TEst activity model', 1460981394, 1460981394, 13, 13, b'0'),
	(136, 1, 58, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(137, 1, 58, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(138, 1, 58, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(139, 1, 58, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(140, 1, 58, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(141, 1, 58, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(142, 1, 58, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(143, 1, 58, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(144, 1, 58, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(145, 1, 58, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  dsdfdsf', 1461036044, 1461036044, 13, 13, b'0'),
	(146, 1, 59, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(147, 1, 59, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(148, 1, 59, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(149, 1, 59, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(150, 1, 59, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(151, 1, 59, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(152, 1, 59, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(153, 1, 59, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(154, 1, 59, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(155, 1, 59, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(156, 1, 59, 'project', 21, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(157, 1, 59, 'project', 22, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(158, 1, 59, 'project', 23, 13, 'create_project', 'vu thuy trinh  đã tạo  Test email template', 1461036304, 1461036304, 13, 13, b'0'),
	(159, 1, 60, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(160, 1, 60, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(161, 1, 60, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(162, 1, 60, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(163, 1, 60, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(164, 1, 60, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(165, 1, 60, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(166, 1, 60, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(167, 1, 60, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(168, 1, 60, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  dsfsd fds fds  Thông tin dự án', 1461037445, 1461037445, 13, 13, b'0'),
	(169, 1, 61, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(170, 1, 61, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(171, 1, 61, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(172, 1, 61, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(173, 1, 61, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(174, 1, 61, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(175, 1, 61, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(176, 1, 61, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(177, 1, 61, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(178, 1, 61, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(179, 1, 61, 'project', 21, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(180, 1, 61, 'project', 22, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(181, 1, 61, 'project', 23, 13, 'create_project', 'vu thuy trinh  đã tạo  Test change model code.', 1461040866, 1461040866, 13, 13, b'0'),
	(182, 1, 62, 'project', 1, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053327, 1461053327, 13, 13, b'0'),
	(183, 1, 62, 'project', 2, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053327, 1461053327, 13, 13, b'0'),
	(184, 1, 62, 'project', 13, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053327, 1461053327, 13, 13, b'0'),
	(185, 1, 62, 'project', 14, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053327, 1461053327, 13, 13, b'0'),
	(186, 1, 62, 'project', 15, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053327, 1461053327, 13, 13, b'0'),
	(187, 1, 62, 'project', 16, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053327, 1461053327, 13, 13, b'0'),
	(188, 1, 62, 'project', 17, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053327, 1461053327, 13, 13, b'0'),
	(189, 1, 62, 'project', 18, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053327, 1461053327, 13, 13, b'0'),
	(190, 1, 62, 'project', 19, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053327, 1461053327, 13, 13, b'0'),
	(191, 1, 62, 'project', 20, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053328, 1461053328, 13, 13, b'0'),
	(192, 1, 62, 'project', 21, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053328, 1461053328, 13, 13, b'0'),
	(193, 1, 62, 'project', 22, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053328, 1461053328, 13, 13, b'0'),
	(194, 1, 62, 'project', 23, 13, 'create_project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', 1461053328, 1461053328, 13, 13, b'0'),
	(195, 2, 63, 'project', 1, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', 1461053399, 1461053399, 21, 21, b'0'),
	(196, 2, 63, 'project', 2, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', 1461053399, 1461053399, 21, 21, b'0'),
	(197, 2, 63, 'project', 13, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', 1461053399, 1461053399, 21, 21, b'0'),
	(198, 2, 63, 'project', 14, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', 1461053399, 1461053399, 21, 21, b'0'),
	(199, 2, 63, 'project', 21, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', 1461053399, 1461053399, 21, 21, b'0'),
	(200, 2, 63, 'project', 22, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', 1461053399, 1461053399, 21, 21, b'0'),
	(201, 2, 63, 'project', 23, 21, 'create_project', 'ta hong gam  đã tạo  Vu thuy trinh company 1 no see', 1461053399, 1461053399, 21, 21, b'0');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;

-- Dumping data for table centeroffice.package: ~3 rows (approximately)
/*!40000 ALTER TABLE `package` DISABLE KEYS */;
INSERT INTO `package` (`id`, `name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 'member', NULL, 0, 0, 0, 0, b'0'),
	(2, 'frontend', NULL, 0, 0, 0, 0, b'0'),
	(3, 'backend', NULL, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `package` ENABLE KEYS */;

-- Dumping data for table centeroffice.payment_method: ~0 rows (approximately)
/*!40000 ALTER TABLE `payment_method` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_method` ENABLE KEYS */;

-- Dumping data for table centeroffice.period_time: ~0 rows (approximately)
/*!40000 ALTER TABLE `period_time` DISABLE KEYS */;
/*!40000 ALTER TABLE `period_time` ENABLE KEYS */;

-- Dumping data for table centeroffice.plan_type: ~0 rows (approximately)
/*!40000 ALTER TABLE `plan_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `plan_type` ENABLE KEYS */;

-- Dumping data for table centeroffice.plan_type_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `plan_type_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `plan_type_detail` ENABLE KEYS */;

-- Dumping data for table centeroffice.position: ~0 rows (approximately)
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
/*!40000 ALTER TABLE `position` ENABLE KEYS */;

-- Dumping data for table centeroffice.post: ~0 rows (approximately)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;

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

-- Dumping data for table centeroffice.project: ~48 rows (approximately)
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
	(63, 2, 23, 7, 6, 0, 'Vu thuy trinh company 1 no see', 'Ta hong gam company 2 no seeTa hong gam company 2 no seeTa hong gam company 2 no see', 'Ta hong gam company 2 no seeTa hong gam company 2 no seeTa hong gam company 2 no see', NULL, NULL, 87, 0, 0, b'1', 1461053399, 1461053399, 21, 21, b'0');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;

-- Dumping data for table centeroffice.project_participant: ~74 rows (approximately)
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
	(85, 2, 63, 21, 'employee', 1461053399, 1461053399, 21, 21, b'0');
/*!40000 ALTER TABLE `project_participant` ENABLE KEYS */;

-- Dumping data for table centeroffice.province: ~0 rows (approximately)
/*!40000 ALTER TABLE `province` DISABLE KEYS */;
/*!40000 ALTER TABLE `province` ENABLE KEYS */;

-- Dumping data for table centeroffice.religion: ~0 rows (approximately)
/*!40000 ALTER TABLE `religion` DISABLE KEYS */;
/*!40000 ALTER TABLE `religion` ENABLE KEYS */;

-- Dumping data for table centeroffice.remind: ~0 rows (approximately)
/*!40000 ALTER TABLE `remind` DISABLE KEYS */;
/*!40000 ALTER TABLE `remind` ENABLE KEYS */;

-- Dumping data for table centeroffice.reply: ~0 rows (approximately)
/*!40000 ALTER TABLE `reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `reply` ENABLE KEYS */;

-- Dumping data for table centeroffice.requestment: ~0 rows (approximately)
/*!40000 ALTER TABLE `requestment` DISABLE KEYS */;
/*!40000 ALTER TABLE `requestment` ENABLE KEYS */;

-- Dumping data for table centeroffice.requestment_allocation: ~0 rows (approximately)
/*!40000 ALTER TABLE `requestment_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `requestment_allocation` ENABLE KEYS */;

-- Dumping data for table centeroffice.requestment_category: ~0 rows (approximately)
/*!40000 ALTER TABLE `requestment_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `requestment_category` ENABLE KEYS */;

-- Dumping data for table centeroffice.sending_template_group: ~1 rows (approximately)
/*!40000 ALTER TABLE `sending_template_group` DISABLE KEYS */;
INSERT INTO `sending_template_group` (`id`, `name`, `column_name`, `description`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 'event', 'event', NULL, 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `sending_template_group` ENABLE KEYS */;

-- Dumping data for table centeroffice.sms: ~95 rows (approximately)
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
	(108, 1, 62, 23, 'project', 'vu thuy trinh  đã tạo  Ta hong gam company 2 no see', b'1', 0, NULL, 1461053328, 1461053328, 13, 13, b'0');
/*!40000 ALTER TABLE `sms` ENABLE KEYS */;

-- Dumping data for table centeroffice.sms_template: ~4 rows (approximately)
/*!40000 ALTER TABLE `sms_template` DISABLE KEYS */;
INSERT INTO `sms_template` (`id`, `sending_template_group_id`, `language_id`, `body`, `column_name`, `default_from_phone_no`, `language_code`, `datetime_created`, `lastup_datetime`, `created_employee_id`, `lastup_employee_id`, `disabled`) VALUES
	(1, 1, 0, '{creator name} created event of {event name}', 'create_event', '0919644092', 'en', 0, 0, 0, 0, b'0'),
	(2, 1, 0, '{creator name} đã tạo sự kiện {event name}', 'create_event', '0919644092', 'vi', 0, 0, 0, 0, b'0'),
	(3, 1, 0, '{creator name} edited event of {event name}', 'edit_event', '0919644092', 'en', 0, 0, 0, 0, b'0'),
	(4, 1, 0, '{creator name} đã chỉnh sửa sự kiện {event name}', 'edit_event', '0919644092', 'vi', 0, 0, 0, 0, b'0');
/*!40000 ALTER TABLE `sms_template` ENABLE KEYS */;

-- Dumping data for table centeroffice.staff: ~0 rows (approximately)
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;

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

-- Dumping data for table centeroffice.subject: ~0 rows (approximately)
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;

-- Dumping data for table centeroffice.subscriber: ~0 rows (approximately)
/*!40000 ALTER TABLE `subscriber` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriber` ENABLE KEYS */;

-- Dumping data for table centeroffice.system_setting: ~0 rows (approximately)
/*!40000 ALTER TABLE `system_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_setting` ENABLE KEYS */;

-- Dumping data for table centeroffice.task: ~0 rows (approximately)
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
/*!40000 ALTER TABLE `task` ENABLE KEYS */;

-- Dumping data for table centeroffice.task_assignment: ~0 rows (approximately)
/*!40000 ALTER TABLE `task_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_assignment` ENABLE KEYS */;

-- Dumping data for table centeroffice.task_group: ~0 rows (approximately)
/*!40000 ALTER TABLE `task_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_group` ENABLE KEYS */;

-- Dumping data for table centeroffice.task_group_allocation: ~0 rows (approximately)
/*!40000 ALTER TABLE `task_group_allocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_group_allocation` ENABLE KEYS */;

-- Dumping data for table centeroffice.zipcode: ~0 rows (approximately)
/*!40000 ALTER TABLE `zipcode` DISABLE KEYS */;
/*!40000 ALTER TABLE `zipcode` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
