CREATE DATABASE IF NOT EXISTS `wrenchppmdb`;

USE `wrenchppmdb`;

CREATE USER IF NOT EXISTS 'wrenchppm'@'%' IDENTIFIED BY 'wrenchppm123';
GRANT ALL PRIVILEGES ON wrenchppmdb.* TO 'wrenchppm'@'%';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `wtb_tokens` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(64) DEFAULT NULL,
  `token` varchar(128) NOT NULL,
  `encoder` boolean NOT NULL DEFAULT false,
  `revoked` boolean NOT NULL DEFAULT false,
  UNIQUE KEY `uq_wtb_tokens_token` (`token`)
);

CREATE TABLE IF NOT EXISTS `wtb_publisher_minutes` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `application` varchar(128) NOT NULL,
  `session` varchar(128) NOT NULL,
  `total_seconds` decimal(12,3) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uq_wtb_publisher_minutes_session` (`username`, `application`, `session`)
);

CREATE TABLE IF NOT EXISTS `wtb_disconnects` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `session` varchar(128) NOT NULL,
  `stream` varchar(128) DEFAULT NULL,
  `elapsed_seconds` decimal(12,3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `wtb_tokens` (`username`, `token`, `encoder`)
VALUES ('publisher1', 'publishsecret', true)
ON DUPLICATE KEY UPDATE
  `username` = VALUES(`username`),
  `encoder` = VALUES(`encoder`),
  `revoked` = false;
