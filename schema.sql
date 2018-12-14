CREATE DATABASE doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
`email` VARCHAR(255) NOT NULL,
`name` VARCHAR(255) NOT NULL,
`password` VARCHAR(64) NOT NULL,
`token`VARCHAR(64) DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `email`(`email`)
);

CREATE TABLE projects (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(64) NOT NULL,
`author_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `author_name`(`author_id`, `name`)
);

CREATE TABLE tasks (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`date_creation` DATETIME,
`date_completion` DATETIME,
`date_term` DATETIME DEFAULT NULL,
`file` VARCHAR(255),
`name` VARCHAR(255) NOT NULL,
`done` BIT NOT NULL DEFAULT b'0',
`project_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `project_name`(`project_id`, `name`)
);

//создание индекса для поля
CREATE FULLTEXT INDEX task_search ON tasks(name)
