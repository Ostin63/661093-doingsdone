CREATE DATABASE doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE categories (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(255) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `name`(`name`)
);

CREATE TABLE tasks_list (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(255) NOT NULL,
`date` TIMESTAMP,
`category_id` INT NOT NULL,
`done` BIT NOT NULL DEFAULT b'0',
PRIMARY KEY (`id`),
UNIQUE KEY `name`(`name`),
KEY `category`(`category_id`)
);