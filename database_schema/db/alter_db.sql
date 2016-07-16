-- Create job table
CREATE TABLE `job` (
	`id` SMALLINT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`description` MEDIUMTEXT NULL COLLATE 'utf8_unicode_ci',
	`datetime_created` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`lastup_datetime` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`created_employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`lastup_employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`disabled` BIT(1) NOT NULL DEFAULT b'0',
	PRIMARY KEY (`id`),
	INDEX `name` (`name`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

-- Add total_storage and total_employee to company table.
ALTER TABLE `company`
	ADD COLUMN `total_storage` BIGINT(20) UNSIGNED NULL DEFAULT '0' AFTER `language_code`;
ALTER TABLE `company`
	ADD COLUMN `total_employee` SMALLINT(6) UNSIGNED NULL DEFAULT '0' AFTER `total_storage`;

-- START#################################### 21/5/2016#################################### 
-- Create task_post table.
CREATE TABLE `task_post` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`company_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`task_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
	`employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`parent_employee_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
	`parent_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
	`content` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
	`content_parse` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
	`datetime_created` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`lastup_datetime` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`created_employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`lastup_employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`disabled` BIT(1) NOT NULL DEFAULT b'0',
	PRIMARY KEY (`id`),
	INDEX `task_id` (`task_id`),
	INDEX `employee_id` (`employee_id`),
	INDEX `parent_employee_id` (`parent_employee_id`),
	INDEX `parent_id` (`parent_id`),
	INDEX `company_id` (`company_id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;

-- Create project_post
CREATE TABLE `project_post` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`company_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`project_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
	`employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`parent_employee_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
	`parent_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
	`content` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
	`content_parse` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
	`datetime_created` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`lastup_datetime` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`created_employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`lastup_employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`disabled` BIT(1) NOT NULL DEFAULT b'0',
	PRIMARY KEY (`id`),
	INDEX `project_id` (`project_id`),
	INDEX `employee_id` (`employee_id`),
	INDEX `parent_employee_id` (`parent_employee_id`),
	INDEX `parent_id` (`parent_id`),
	INDEX `company_id` (`company_id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;

-- Create event_post
CREATE TABLE `event_post` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`company_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`event_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
	`employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`parent_employee_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
	`parent_id` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
	`content` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
	`content_parse` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
	`datetime_created` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`lastup_datetime` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`created_employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`lastup_employee_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
	`disabled` BIT(1) NOT NULL DEFAULT b'0',
	PRIMARY KEY (`id`),
	INDEX `event_id` (`event_id`),
	INDEX `employee_id` (`employee_id`),
	INDEX `parent_employee_id` (`parent_employee_id`),
	INDEX `parent_id` (`parent_id`),
	INDEX `company_id` (`company_id`)
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
;

-- Drop activity_post
DROP TABLE `activity_post`;

-- END#################################### 21/5/2016#################################### 

-- Add is_all_day column into event table # 23/5sms_template/2016
ALTER TABLE `event`
	ADD COLUMN `is_all_day` BIT NOT NULL DEFAULT b'0' AFTER `color`;
-- ------------------------------------------------------------------
