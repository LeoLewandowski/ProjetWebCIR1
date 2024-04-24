-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 24 avr. 2024 à 15:07
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
-- Base de données : `octime`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE `accounts` (
  `gender` char(1) NOT NULL DEFAULT 'N',
  `name` varchar(64) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` longtext NOT NULL,
  `birth` date NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `id` char(23) NOT NULL,
  `pfp_extension` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `accounts`
--

INSERT INTO `accounts` (`gender`, `name`, `surname`, `email`, `password`, `birth`, `admin`, `id`, `pfp_extension`) VALUES
('M', 'Lewandowski', 'Léo', 'leo.lewandowski@student.junia.com', '$argon2i$v=19$m=65536,t=4,p=1$YXZJVkFnanJEL2dvUmxrRA$pc23vI41ZkfShQfpzDDWbKHz5EhwBglD61wJChniy0w', '2024-04-03', 0, '6628fb66c12f15.51178933', 'png');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `subject` text NOT NULL,
  `content` text NOT NULL,
  `image` longblob NOT NULL,
  `user_id` char(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table pour page "contact"';

-- --------------------------------------------------------

--
-- Structure de la table `shopping_carts`
--

CREATE TABLE `shopping_carts` (
  `product_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `client_id` char(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `watches`
--

CREATE TABLE `watches` (
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(8000) DEFAULT NULL,
  `timeType` char(1) DEFAULT NULL,
  `braceletType` char(1) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `watches`
--

INSERT INTO `watches` (`name`, `description`, `timeType`, `braceletType`, `price`, `id`) VALUES
('Spacewalker', 'L\'un de nos premiers modèles, le Spacewalker est indubitablement celui qui représente le mieux Octime. Constitué d\'un alliage d\'acier, de chrome et de régolithe lunaire, ce modèle est extrêmement résistant, étanche et peut supporter une immersion jusqu\'à 100m de profondeur', 'D', 'L', 55, 1),
('Eclipse', 'description', 'O', 'M', 75, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `pfp` (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `watches`
--
ALTER TABLE `watches`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `watches`
--
ALTER TABLE `watches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`id`);

--
-- Contraintes pour la table `shopping_carts`
--
ALTER TABLE `shopping_carts`
  ADD CONSTRAINT `client_id_FK` FOREIGN KEY (`client_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `product_id_FK` FOREIGN KEY (`product_id`) REFERENCES `watches` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
