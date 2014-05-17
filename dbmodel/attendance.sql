SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
SHOW WARNINGS;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`auth`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`auth` (
  `auth_id` INT NOT NULL AUTO_INCREMENT,
  `key_name` VARCHAR(64) NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`auth_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `auth_id` INT NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NULL,
  `password` VARCHAR(40) NULL,
  `active` TINYINT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `name_UNIQUE` (`username` ASC),
  INDEX `fk_user_auth1_idx` (`auth_id` ASC),
  CONSTRAINT `fk_user_auth1`
    FOREIGN KEY (`auth_id`)
    REFERENCES `mydb`.`auth` (`auth_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`client`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`client` (
  `client_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NULL,
  `password` VARCHAR(40) NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`user_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`user_info` (
  `user_info_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `fbid` INT NULL,
  `first_name` VARCHAR(20) NULL,
  `last_name` VARCHAR(30) NULL,
  `birthday` DATE NULL,
  `link` VARCHAR(100) NULL,
  `timezone` TIMESTAMP NULL,
  `locale` VARCHAR(5) NULL,
  `username` VARCHAR(20) NULL,
  UNIQUE INDEX `fbid_UNIQUE` (`fbid` ASC),
  UNIQUE INDEX `id_user_UNIQUE` (`user_id` ASC),
  PRIMARY KEY (`user_info_id`),
  CONSTRAINT `fk_user_info_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`event_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`event_type` (
  `event_type_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL,
  PRIMARY KEY (`event_type_id`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`event`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`event` (
  `event_id` INT NOT NULL AUTO_INCREMENT,
  `created_by` INT NOT NULL,
  `event_type_id` INT NOT NULL,
  `name` VARCHAR(255) NULL,
  `perex` VARCHAR(1000) NULL,
  `content` TEXT NULL,
  `location` VARCHAR(150) NULL,
  `start_date` TIMESTAMP NULL,
  `end_date` TIMESTAMP NULL,
  `last_change` TIMESTAMP NULL,
  `lock` TINYINT NULL,
  PRIMARY KEY (`event_id`),
  INDEX `fk_event_user1_idx` (`created_by` ASC),
  INDEX `fk_event_event_type1_idx` (`event_type_id` ASC),
  CONSTRAINT `fk_event_user1`
    FOREIGN KEY (`created_by`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_event_event_type1`
    FOREIGN KEY (`event_type_id`)
    REFERENCES `mydb`.`event_type` (`event_type_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`user_event`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`user_event` (
  `user_event_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  INDEX `fk_user_event_event1_idx` (`event_id` ASC),
  INDEX `fk_user_event_user1_idx` (`user_id` ASC),
  PRIMARY KEY (`user_event_id`),
  CONSTRAINT `fk_user_event_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_event_event1`
    FOREIGN KEY (`event_id`)
    REFERENCES `mydb`.`event` (`event_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`wallet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`wallet` (
  `wallet_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `credit` DECIMAL NULL,
  PRIMARY KEY (`wallet_id`),
  CONSTRAINT `fk_wallet_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`transaction` (
  `transaction_id` INT NOT NULL AUTO_INCREMENT,
  `wallet_id` INT NOT NULL,
  `previous_amount` DECIMAL NULL,
  `current_amount` DECIMAL NULL,
  PRIMARY KEY (`transaction_id`),
  INDEX `fk_transaction_wallet1_idx` (`wallet_id` ASC),
  CONSTRAINT `fk_transaction_wallet1`
    FOREIGN KEY (`wallet_id`)
    REFERENCES `mydb`.`wallet` (`wallet_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`group` (
  `group_id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NOT NULL,
  `name` VARCHAR(100) NULL,
  PRIMARY KEY (`group_id`),
  INDEX `fk_group_client1_idx` (`client_id` ASC),
  CONSTRAINT `fk_group_client1`
    FOREIGN KEY (`client_id`)
    REFERENCES `mydb`.`client` (`client_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mydb`.`group_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`group_user` (
  `group_user_id` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`group_user_id`),
  INDEX `fk_group_user_user1_idx` (`user_id` ASC),
  INDEX `fk_group_user_group1_idx` (`group_id` ASC),
  CONSTRAINT `fk_group_user_group1`
    FOREIGN KEY (`group_id`)
    REFERENCES `mydb`.`group` (`group_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_group_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`user` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `mydb`.`auth`
-- -----------------------------------------------------
START TRANSACTION;
USE `mydb`;
INSERT INTO `mydb`.`auth` (`auth_id`, `key_name`, `name`) VALUES (1, 'admin', 'Admin');
INSERT INTO `mydb`.`auth` (`auth_id`, `key_name`, `name`) VALUES (2, 'manager', 'Správce');
INSERT INTO `mydb`.`auth` (`auth_id`, `key_name`, `name`) VALUES (3, 'user', 'Uživatel');
INSERT INTO `mydb`.`auth` (`auth_id`, `key_name`, `name`) VALUES (4, 'guest', 'Host');

COMMIT;


-- -----------------------------------------------------
-- Data for table `mydb`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `mydb`;
INSERT INTO `mydb`.`user` (`user_id`, `auth_id`, `username`, `email`, `password`, `active`) VALUES (1, 1, 'Admin', 'Rohlicek.z@seznam.cz', '37afd0185410537902af9408871a2b08a97edfe5', true);

COMMIT;


-- -----------------------------------------------------
-- Data for table `mydb`.`client`
-- -----------------------------------------------------
START TRANSACTION;
USE `mydb`;
INSERT INTO `mydb`.`client` (`client_id`, `email`, `password`) VALUES (1, 'Rohlicek.z@seznam.cz', 'b8101f066ae2206f48460d330db4c2c8854e2704');

COMMIT;


-- -----------------------------------------------------
-- Data for table `mydb`.`event_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `mydb`;
INSERT INTO `mydb`.`event_type` (`event_type_id`, `name`) VALUES (1, 'Oslava');
INSERT INTO `mydb`.`event_type` (`event_type_id`, `name`) VALUES (2, 'Trénink');
INSERT INTO `mydb`.`event_type` (`event_type_id`, `name`) VALUES (3, 'Zápas');

COMMIT;

