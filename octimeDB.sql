-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 26 mars 2024 à 17:43
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
-- Structure de la table `translations`
--

CREATE TABLE `translations` (
  `name` varchar(255) NOT NULL,
  `txt` text NOT NULL,
  `langs` set('fr','en') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `translations`
--

INSERT INTO `translations` (`name`, `txt`, `langs`) VALUES
('characteristics', 'Caractéristiques', 'fr'),
('characteristics', 'Characteristics', 'en'),
('timeTitle', 'Système temporel', 'fr'),
('timeTitle', 'Time system', 'en'),
('timeTypeO', 'Octal (8h)', 'fr,en'),
('timeTypeD', 'Duodécimal (12h)', 'fr'),
('timeTypeD', 'Duodecimal (12h)', 'en'),
('braceletTitle', 'Matière du bracelet', 'fr'),
('braceletTitle', 'Bracelet composition', 'en'),
('braceletTypeS', 'Silicone', 'fr'),
('braceletTypeS', 'Rubber', 'en'),
('braceletTypeL', 'Leather', 'en'),
('braceletTypeL', 'Cuir', 'fr'),
('braceletTypeM', 'Metal', 'en'),
('braceletTypeM', 'Métal', 'fr'),
('price', 'Price', 'en'),
('price', 'Prix', 'fr'),
('watchNotFound', '<h3>Désolé, cette montre n\'existe pas</h3><br><h4>Veuillez retourner sur <a href=\'/products\'>la page des produits</a>', 'fr'),
('watchNotFound', '<h3>Sorry, this watch does not exist</h3><br><h4>Please go bac to the <a href=\'/products\'>products page</a>', 'en');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
