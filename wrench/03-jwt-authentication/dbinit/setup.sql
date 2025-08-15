CREATE DATABASE IF NOT EXISTS `wtbexampledb`;

USE `wtbexampledb`;

CREATE USER 'wtbexample'@'%' IDENTIFIED BY 'wtbexample123';

GRANT ALL PRIVILEGES ON wtbexampledb.* TO 'wtbexample'@'%';

FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `wtb_user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'stores hash, never store clear text passwords in database'
);

-- This is john / foobar, our single test user to start with
INSERT INTO `wtb_user` (`username`, `password`) VALUES ('john', '$2y$10$NLrhk0HuIF3zQQatdZ5XMu2pNjpH..y73rd7bB.Pl7Ja2YyF/2NV6');