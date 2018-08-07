-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 07 août 2018 à 18:59
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Message table';

--
-- Déchargement des données de la table `t_message`
--

INSERT INTO `t_message` (`msg_id`, `usr_id`, `msg_content`, `msg_date`) VALUES
(1, 1, 'Ceci est un message de test', '2018-08-07 14:00:00'),
(2, 1, 'Ceci est un autre message de test', '2018-08-07 17:00:00'),
(3, 2, 'Salut, ça va ?', '2018-08-07 18:24:00'),
(4, 1, 'Test', '2018-08-07 18:45:13');

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
CREATE TABLE IF NOT EXISTS `t_user` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `usr_login` varchar(32) NOT NULL COMMENT 'Login',
  `usr_password` varchar(128) NOT NULL COMMENT 'Hash password',
  `usr_date_inscription` datetime DEFAULT NULL COMMENT 'Inscription date',
  `usr_date_connection` datetime DEFAULT NULL COMMENT 'Last connection date',
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='User table';

--
-- Déchargement des données de la table `t_user`
--

INSERT INTO `t_user` (`usr_id`, `usr_login`, `usr_password`, `usr_date_inscription`, `usr_date_connection`) VALUES
(1, 'user1', '$2y$10$yO2xhvTVMOKhUxvRQi3b5OISDyiy.fFFx9kMXKtxfHXhOspRCPEyi', NULL, '2018-08-07 18:15:49'),
(2, 'user2', '$2y$10$yO2xhvTVMOKhUxvRQi3b5OISDyiy.fFFx9kMXKtxfHXhOspRCPEyi', NULL, '2018-08-07 18:27:00');

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
