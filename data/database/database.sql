-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 07 août 2018 à 14:58
-- Version du serveur :  5.7.19
-- Version de PHP :  7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `kiara`
--
CREATE DATABASE IF NOT EXISTS `kiara` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kiara`;

-- --------------------------------------------------------

--
-- Structure de la table `t_message`
--

DROP TABLE IF EXISTS `t_message`;
CREATE TABLE IF NOT EXISTS `t_message` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Message ID',
  `usr_id` int(11) NOT NULL COMMENT 'Author',
  `msg_content` text NOT NULL COMMENT 'Content',
  `msg_date` datetime NOT NULL COMMENT 'Date',
  PRIMARY KEY (`msg_id`),
  KEY `usr_id` (`usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Message table';

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
CREATE TABLE IF NOT EXISTS `t_user` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `usr_login` varchar(32) NOT NULL COMMENT 'Login',
  `usr_password` varchar(128) NOT NULL COMMENT 'Hash password',
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User table';

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_message`
--
ALTER TABLE `t_message`
  ADD CONSTRAINT `fk_message_usr_id_user` FOREIGN KEY (`usr_id`) REFERENCES `t_user` (`usr_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
