-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 26 avr. 2024 à 21:46
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
('M', 'Lewandowski', 'Léo', 'leo.lewandowski@student.junia.com', '$argon2i$v=19$m=65536,t=4,p=1$YXZJVkFnanJEL2dvUmxrRA$pc23vI41ZkfShQfpzDDWbKHz5EhwBglD61wJChniy0w', '2024-04-03', 1, '6628fb66c12f15.51178933', 'gif'),
('N', 'Test', 'Test', 'test@junia.com', '$argon2i$v=19$m=65536,t=4,p=1$dG1mOEpWd1hsMEs2Y25pMQ$m3TFeJ657Aq/9DJYSIsQhWlHZVpjp7e2GpnEjLGPWhA', '2024-04-11', 0, '662a84c3ec5670.78596281', 'png');

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
  `description_fr` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `timeType` char(1) DEFAULT NULL,
  `braceletType` char(1) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `watches`
--

INSERT INTO `watches` (`name`, `description_fr`, `description_en`, `timeType`, `braceletType`, `price`, `id`) VALUES
('Spacewalker', 'L\'un de nos premiers modèles, le Spacewalker est indubitablement celui qui représente le mieux Octime. Constitué d\'un alliage d\'acier, de chrome et de régolithe lunaire, ce modèle est extrêmement résistant, étanche et peut supporter une immersion jusqu\'à 100m de profondeur', 'One of our first models, the Spacewalker is undoubtedly the one that represents Octime the best. Forged from an incredible alloy of steel, chrome and lunar regolith, this watch is extremely durable and waterproof, and can even withstand being submerged to 100m depth', 'D', 'M', 149, 1),
('Eclipse', 'description', 'description à rédiger', 'O', 'L', 199, 2);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
