-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `wrs_node`;
CREATE DATABASE `wrs_node` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `wrs_node`;

DROP TABLE IF EXISTS `tree`;
CREATE TABLE `tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch` varchar(50) NOT NULL,
  `sub_branch` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2020-12-28 12:25:26
