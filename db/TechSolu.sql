-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 09 juil. 2025 à 23:21
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `techsolutions`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `pseudo`, `mot_de_passe`) VALUES
(1, 'Polo412', '$2y$10$o6An//WfNv8wNfAfV6Swne1TFbeEn800BsXoRh8ypiapBBmcWQrvW'),
(2, 'Polo412', '$2y$10$yiuq7.ykQu4hZlDvW6VQ5OQJs9eKbfN.YifWPyYdKYkB1LFRllxdu'),
(3, 'Hitler', '$2y$10$HGsZssTclDDf55T0PV29ie9YFWuJUecCP4eGAKPFUegDxxiPP9/vq');

-- --------------------------------------------------------

--
-- Structure de la table `connexions_admin`
--

DROP TABLE IF EXISTS `connexions_admin`;
CREATE TABLE IF NOT EXISTS `connexions_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `adresse_ip` varchar(50) DEFAULT NULL,
  `date_connexion` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `connexions_admin`
--

INSERT INTO `connexions_admin` (`id`, `admin_id`, `pseudo`, `adresse_ip`, `date_connexion`, `statut`) VALUES
(1, 3, 'Hitler', '::1', '2025-07-08 10:23:35', 'succès'),
(2, 1, 'Polo412', '192.168.1.119', '2025-07-08 10:23:57', 'succès'),
(3, 3, 'Hitler', '::1', '2025-07-08 11:38:36', 'succès'),
(4, 0, 'hunter412', '192.168.1.119', '2025-07-08 11:39:40', 'échec'),
(5, 1, 'Polo412', '192.168.1.119', '2025-07-08 11:41:23', 'succès'),
(6, 1, 'Polo412', '::1', '2025-07-09 11:21:35', 'succès'),
(7, 1, 'Polo412', '::1', '2025-07-09 11:24:03', 'succès'),
(8, 3, 'Hitler', '::1', '2025-07-09 14:14:40', 'succès'),
(9, 0, 'dghsjs', '::1', '2025-07-09 23:09:26', 'echec'),
(10, 0, 'lsoejjfk', '::1', '2025-07-09 23:09:32', 'echec'),
(11, 0, 'aeztdvd', '::1', '2025-07-09 23:09:38', 'echec'),
(12, 0, 'aeztdvd', '::1', '2025-07-09 23:11:36', 'echec'),
(13, 0, 'zteyegd', '::1', '2025-07-09 23:11:46', 'echec'),
(14, 1, 'Polo412', '::1', '2025-07-09 23:15:46', 'succès');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

DROP TABLE IF EXISTS `rendezvous`;
CREATE TABLE IF NOT EXISTS `rendezvous` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `heure` timestamp NOT NULL,
  `service` enum('SiteWeb','applicatonMobile','E-commerce','Maintenance','Installation') NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`id`, `nom`, `email`, `telephone`, `date`, `heure`, `service`, `message`) VALUES
(1, 'mbourou ndiaye', 'dimitricyrille@gmail.com', '78 120 45 87', '2025-07-31', '0000-00-00 00:00:00', 'Maintenance', 'mon pc beug depuis un moment et il est lent je voudrais savoir si je peux avoir une maintenance'),
(2, 'admin test', 'admintest@gmail.com', '77 965 00 32', '2025-07-28', '0000-00-00 00:00:00', 'applicatonMobile', 'je voudrais une application qui me gere mes journees'),
(3, 'Hitler', 'hitler@gmail.com', '78 145 32 02', '2025-07-02', '0000-00-00 00:00:00', 'applicatonMobile', 'je voudrais une application mobile je pourrais avoir les modalites concernant '),
(4, 'hunter', 'polo@gmail.com', '75 120 41 20', '2025-07-16', '0000-00-00 00:00:00', 'Installation', ''),
(5, 'stackys', 'babo214@gmail.com', '+221781550030', '2025-07-30', '0000-00-00 00:00:00', 'Installation', 'je veux installer un nouveau systeme sur ma machine');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
