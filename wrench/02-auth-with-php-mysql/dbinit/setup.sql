CREATE DATABASE IF NOT EXISTS `wtbexampledb`;

USE `wtbexampledb`;

CREATE USER 'wtbexample'@'%' IDENTIFIED BY 'wtbexample123';

GRANT ALL PRIVILEGES ON wtbexampledb.* TO 'wtbexample'@'%';

FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `wtb_tokens` (
  `ID` int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `USERNAME` varchar(128) NOT NULL COMMENT 'User name',
  `TS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IP` varchar(64) NOT NULL,
  `TOKEN` varchar(128) NOT NULL COMMENT 'Tokens are stored in hashed format, as they are passwords and should not be stored in clear text'
);

-- This is what needs to be generated into the table from the code
-- INSERT INTO `wtb_tokens` (`ID`, `USERNAME`, `TS`, `IP`, `TOKEN`) VALUES (1, 'john', '2014-11-09 16:16:37', '::1', '545f93654d320');

CREATE TABLE IF NOT EXISTS `wtb_user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'stores hash, never store clear text passwords in database'
);

-- This is john / foobar, our single test user to start with
INSERT INTO `wtb_user` (`username`, `password`) VALUES ('john', '$2y$10$NLrhk0HuIF3zQQatdZ5XMu2pNjpH..y73rd7bB.Pl7Ja2YyF/2NV6');