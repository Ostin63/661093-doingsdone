CREATE DATABASE doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
`id` INT NOT AUTO_INCREMENT,
`date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
`email` VARCHAR(255) NOT NULL,
`name` VARCHAR(255) NOT NULL,
`password` VARCHAR(64) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `email`(`email`)
);

CREATE TABLE projects (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(64) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `name`(`name`)
);

CREATE TABLE tasks (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`date_creation` TIMESTAMP,
`date_completion` TIMESTAMP,
`date_term` TIMESTAMP,
`name` VARCHAR(255) NOT NULL,
`file` VARCHAR(255),
`category_id` INT NOT NULL,
`done` BIT NOT NULL DEFAULT b'0',
PRIMARY KEY (`id`),
UNIQUE KEY `name`(`name`),
KEY `category`(`category_id`)
);


