-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 24 mars 2026 à 15:03
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
-- Base de données : `univoix`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lien` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(500) NOT NULL,
  `category` varchar(100) NOT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `titre`, `lien`, `date`, `description`, `category`) VALUES
(6, 'Jeux paralympiques 2026 : quels sont les sports en lice et comment sont-ils adaptés aux différents types de handicap ?', 'https://www.lemonde.fr/les-decodeurs/article/2026/03/04/jeux-paralympiques-2026-quels-sont-les-sports-en-lice-et-comment-sont-ils-adaptes-aux-differents-types-de-handicap_6669453_4355770.html', 'Wed, 04 Mar 2026 06:00:20 +0100', 'La compétition qui se déroule du 6 au 15 mars comporte six disciplines, individuelles ou collectives, qui peuvent être pratiquées par des athlètes assis, debout ou avec un handicap visuel. Explications et détails.', 'handicap');

-- --------------------------------------------------------

--
-- Structure de la table `handicap`
--

DROP TABLE IF EXISTS `handicap`;
CREATE TABLE IF NOT EXISTS `handicap` (
  `id_handicap` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id_handicap`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `handicap`
--

INSERT INTO `handicap` (`id_handicap`, `nom`, `description`) VALUES
(1, 'TDAH', 'Trouble du déficit de l\'attention avec ou sans hyperactivité'),
(2, 'Autisme', 'Trouble du spectre autistique'),
(3, 'Trouble du Spectre Autistique', 'TSA'),
(4, 'Maladie chronique', 'Diabète, endométriose...'),
(5, 'Dyslexie', 'Trouble de la lecture'),
(6, 'Dyscalculie', 'Trouble du calcul'),
(7, 'Dyspraxie', 'Trouble de la coordination'),
(8, 'Troubles anxieux', 'Anxiété généralisée'),
(9, 'Dépression', 'Trouble dépressif'),
(10, 'Haut Potentiel Intellectuel', 'HPI');

-- --------------------------------------------------------

--
-- Structure de la table `inscrit`
--

DROP TABLE IF EXISTS `inscrit`;
CREATE TABLE IF NOT EXISTS `inscrit` (
  `id_inscrit` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `age` int NOT NULL,
  `pseudo` text NOT NULL,
  `role` text NOT NULL,
  `importance_signalement` int NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ville` text NOT NULL,
  `mot_de_passe` text NOT NULL,
  `specialite` varchar(100) DEFAULT NULL,
  `daltonisme` varchar(100) NOT NULL,
  `dyslexie` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_inscrit`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `inscrit`
--

INSERT INTO `inscrit` (`id_inscrit`, `nom`, `prenom`, `age`, `pseudo`, `role`, `importance_signalement`, `email`, `ville`, `mot_de_passe`, `specialite`, `daltonisme`, `dyslexie`) VALUES
(3, 'Medecin', 'Deux', 20, 'dalii', 'specialiste', 0, 'medecin2@gmail.com', 'bobigny', 'dalila93', 'Psychologue', '', 0),
(5, 'Regi', 'Luca', 22, 'luca', 'admin', 10, 'luca@gmail.com', 'Dugny', 'luca', NULL, 'aucun', 0),
(6, 'Medecin', 'Un', 56, 'medecin1', 'specialiste', 0, 'medecin1@gmail.com', 'Sarcelles', 'luca', 'Diabète', '', 0),
(8, 'Kharfouche', 'Joseph', 34, 'josephk', 'specialiste', 0, 'test3@gmail.com', 'OUI', 'luca', 'Psychologue', 'protanopie', 0);

-- --------------------------------------------------------

--
-- Structure de la table `inscrithandicap`
--

DROP TABLE IF EXISTS `inscrithandicap`;
CREATE TABLE IF NOT EXISTS `inscrithandicap` (
  `ref_handicap` int NOT NULL,
  `ref_inscrit` int NOT NULL,
  KEY `fk_handicap_inscrithandicap` (`ref_handicap`),
  KEY `fk_inscrit_inscrithandicap` (`ref_inscrit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `inscrithandicap`
--

INSERT INTO `inscrithandicap` (`ref_handicap`, `ref_inscrit`) VALUES
(2, 3),
(9, 3),
(6, 3),
(5, 3),
(5, 8),
(2, 5);

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
CREATE TABLE IF NOT EXISTS `reponse` (
  `id_reponse` int NOT NULL AUTO_INCREMENT,
  `contenu` text NOT NULL,
  `date_reponse` date NOT NULL,
  `ref_inscrit` int NOT NULL,
  `ref_sujet` int NOT NULL,
  PRIMARY KEY (`id_reponse`),
  KEY `fk_sujet_reponse` (`ref_sujet`),
  KEY `fk_inscrit_reponse` (`ref_inscrit`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`id_reponse`, `contenu`, `date_reponse`, `ref_inscrit`, `ref_sujet`) VALUES
(14, 'jreth', '2026-03-24', 5, 18);

-- --------------------------------------------------------

--
-- Structure de la table `signalement`
--

DROP TABLE IF EXISTS `signalement`;
CREATE TABLE IF NOT EXISTS `signalement` (
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `ref_signalant` int NOT NULL,
  `ref_signale` int NOT NULL,
  `id_signalement` int NOT NULL AUTO_INCREMENT,
  `titre` text NOT NULL,
  PRIMARY KEY (`id_signalement`),
  KEY `fk_inscrit_signalement` (`ref_signalant`),
  KEY `fk_inscrit_signale` (`ref_signale`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sujet`
--

DROP TABLE IF EXISTS `sujet`;
CREATE TABLE IF NOT EXISTS `sujet` (
  `id_sujet` int NOT NULL AUTO_INCREMENT,
  `titre` text NOT NULL,
  `contenu` text NOT NULL,
  `date_sujet` date NOT NULL,
  `categorie_sujet` text NOT NULL,
  `ref_inscrit` int NOT NULL,
  PRIMARY KEY (`id_sujet`),
  KEY `fk_inscrit_sujet` (`ref_inscrit`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `sujet`
--

INSERT INTO `sujet` (`id_sujet`, `titre`, `contenu`, `date_sujet`, `categorie_sujet`, `ref_inscrit`) VALUES
(15, 'Hello World !', 'Bonjour le monde !', '2026-03-17', 'Jeux,Ecole', 5),
(17, 'Je m\'appelle Joseph', 'Hello Team', '2026-03-24', 'Jeux,Ecole', 5),
(18, 'Luca Regi', 'Luca Regi', '2026-03-24', 'Aide', 5);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `inscrithandicap`
--
ALTER TABLE `inscrithandicap`
  ADD CONSTRAINT `fk_handicap_inscrithandicap` FOREIGN KEY (`ref_handicap`) REFERENCES `handicap` (`id_handicap`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscrit_inscrithandicap` FOREIGN KEY (`ref_inscrit`) REFERENCES `inscrit` (`id_inscrit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `fk_inscrit_reponse` FOREIGN KEY (`ref_inscrit`) REFERENCES `inscrit` (`id_inscrit`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_sujet_reponse` FOREIGN KEY (`ref_sujet`) REFERENCES `sujet` (`id_sujet`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `signalement`
--
ALTER TABLE `signalement`
  ADD CONSTRAINT `fk_inscrit_signale` FOREIGN KEY (`ref_signale`) REFERENCES `inscrit` (`id_inscrit`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_inscrit_signalement` FOREIGN KEY (`ref_signalant`) REFERENCES `inscrit` (`id_inscrit`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `sujet`
--
ALTER TABLE `sujet`
  ADD CONSTRAINT `fk_inscrit_sujet` FOREIGN KEY (`ref_inscrit`) REFERENCES `inscrit` (`id_inscrit`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
