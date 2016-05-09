--Create job table
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
ENGINE=InnoDB