CREATE DATABASE IF NOT EXISTS `wtbexampledb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `wtbexampledb`;

CREATE USER 'wtbexample'@'localhost' IDENTIFIED BY 'wtbexample123'
GRANT ALL PRIVILEGES ON wtbexampledb.* TO 'wtbexample'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `wtb_tokens` (
  `ID` int(12) NOT NULL,
  `USERNAME` varchar(128) NOT NULL COMMENT 'User name',
  `TS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IP` varchar(64) NOT NULL,
  `TOKEN` varchar(128) NOT NULL COMMENT 'Tokens are stored in hashed format, as they are passwords and should not be stored in clear text'
);

ALTER TABLE `wtb_tokens` ADD PRIMARY KEY (`ID`);
ALTER TABLE `wtb_tokens` MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

-- This is what needs to be generated into the table from the code
--INSERT INTO `wtb_tokens` (`ID`, `USERNAME`, `TS`, `IP`, `TOKEN`) VALUES (1, 'john', '2014-11-09 16:16:37', '::1', '545f93654d320');

CREATE TABLE IF NOT EXISTS `wtb_user` (
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL COMMENT 'stores sha256 hash, never store clear text passwords in database'
);

-- This is john / foobar, our single test user to start with
INSERT INTO `wtb_user` (`username`, `password`) VALUES ('john', 'c3ab8ff13720e8ad9047dd39466b3c8974e592c2fa383d4a3960714caef0c4f2');