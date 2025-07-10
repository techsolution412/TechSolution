-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 10 juil. 2025 à 18:56
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `connexions_admin` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `adresse_ip` varchar(50) DEFAULT NULL,
  `date_connexion` datetime DEFAULT current_timestamp(),
  `statut` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(14, 1, 'Polo412', '::1', '2025-07-09 23:15:46', 'succès'),
(15, 3, 'Hitler', '::1', '2025-07-10 01:07:18', 'echec'),
(16, 3, 'Hitler', '::1', '2025-07-10 01:07:27', 'echec'),
(17, 3, 'Hitler', '::1', '2025-07-10 01:09:00', 'echec'),
(18, 3, 'Hitler', '::1', '2025-07-10 01:09:03', 'echec'),
(19, 3, 'Hitler', '::1', '2025-07-10 01:09:37', 'succès'),
(20, 3, 'Hitler', '::1', '2025-07-10 15:51:56', 'succès'),
(21, 3, 'Hitler', '::1', '2025-07-10 16:25:32', 'succès');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL DEFAULT current_timestamp(),
  `service` enum('SiteWeb','applicatonMobile','E-commerce','Maintenance','Installation') NOT NULL,
  `statut` enum('en cours','en attente','termine','en retard','archive') NOT NULL DEFAULT 'en attente',
  `dateCreation` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`id`, `nom`, `email`, `telephone`, `date`, `heure`, `service`, `statut`, `dateCreation`, `message`) VALUES
(1, 'test', 'test@gmail.com', '787518823', '2025-07-10', '20:04:00', 'SiteWeb', 'archive', '2025-07-10 16:14:52', 'test'),
(2, 'test', 'ghostshooter672@gmail.com', '787518822', '2025-07-11', '21:15:00', 'Installation', 'en attente', '2025-07-10 16:15:46', 'test');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `connexions_admin`
--
ALTER TABLE `connexions_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Index pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `connexions_admin`
--
ALTER TABLE `connexions_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
