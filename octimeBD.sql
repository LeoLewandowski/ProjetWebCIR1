-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 28 avr. 2024 à 11:28
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
-- Base de données : `octimebd`
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
('N', 'Test', 'Test-deux', 'test@junia.com', '$argon2i$v=19$m=65536,t=4,p=1$dG1mOEpWd1hsMEs2Y25pMQ$m3TFeJ657Aq/9DJYSIsQhWlHZVpjp7e2GpnEjLGPWhA', '2024-04-11', 0, '662a84c3ec5670.78596281', 'png'),
('M', 'Lewandowski', 'Léo', 'admin@junia.com', '$argon2i$v=19$m=65536,t=4,p=1$Ujh3bkQyRlZaYW1hQVBmTQ$m5hWLugNdEs4oeFpN4VeMrPfIqsQppVS8UYzZc+fAuQ', '2024-04-23', 1, '662e13a3e5a5c1.94251494', 'jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `subject` text NOT NULL,
  `content` text NOT NULL,
  `user_id` char(23) NOT NULL,
  `img_extension` varchar(4) DEFAULT NULL,
  `id` char(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table pour page "contact"';

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`subject`, `content`, `user_id`, `img_extension`, `id`) VALUES
('Test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', '662a84c3ec5670.78596281', 'png', '662cc8f1cd0a96.80243253'),
('Amogus', 'When the imposter is sus! 😳 \r\n\r\n⠀⠀⠀⡯⡯⡾⠝⠘⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢊⠘⡮⣣⠪⠢⡑⡌\r\n⠀⠀⠀⠟⠝⠈⠀⠀⠀⠡⠀⠠⢈⠠⢐⢠⢂⢔⣐⢄⡂⢔⠀⡁⢉⠸⢨⢑⠕⡌\r\n⠀⠀⡀⠁⠀⠀⠀⡀⢂⠡⠈⡔⣕⢮⣳⢯⣿⣻⣟⣯⣯⢷⣫⣆⡂⠀⠀⢐⠑⡌\r\n⢀⠠⠐⠈⠀⢀⢂⠢⡂⠕⡁⣝⢮⣳⢽⡽⣾⣻⣿⣯⡯⣟⣞⢾⢜⢆⠀⡀⠀⠪\r\n⣬⠂⠀⠀⢀⢂⢪⠨⢂⠥⣺⡪⣗⢗⣽⢽⡯⣿⣽⣷⢿⡽⡾⡽⣝⢎⠀⠀⠀⢡\r\n⣿⠀⠀⠀⢂⠢⢂⢥⢱⡹⣪⢞⡵⣻⡪⡯⡯⣟⡾⣿⣻⡽⣯⡻⣪⠧⠑⠀⠁⢐\r\n⣿⠀⠀⠀⠢⢑⠠⠑⠕⡝⡎⡗⡝⡎⣞⢽⡹⣕⢯⢻⠹⡹⢚⠝⡷⡽⡨⠀⠀⢔\r\n⣿⡯⠀⢈⠈⢄⠂⠂⠐⠀⠌⠠⢑⠱⡱⡱⡑⢔⠁⠀⡀⠐⠐⠐⡡⡹⣪⠀⠀⢘\r\n⣿⣽⠀⡀⡊⠀⠐⠨⠈⡁⠂⢈⠠⡱⡽⣷⡑⠁⠠⠑⠀⢉⢇⣤⢘⣪⢽⠀⢌⢎\r\n⣿⢾⠀⢌⠌⠀⡁⠢⠂⠐⡀⠀⢀⢳⢽⣽⡺⣨⢄⣑⢉⢃⢭⡲⣕⡭⣹⠠⢐⢗\r\n⣿⡗⠀⠢⠡⡱⡸⣔⢵⢱⢸⠈⠀⡪⣳⣳⢹⢜⡵⣱⢱⡱⣳⡹⣵⣻⢔⢅⢬⡷\r\n⣷⡇⡂⠡⡑⢕⢕⠕⡑⠡⢂⢊⢐⢕⡝⡮⡧⡳⣝⢴⡐⣁⠃⡫⡒⣕⢏⡮⣷⡟\r\n⣷⣻⣅⠑⢌⠢⠁⢐⠠⠑⡐⠐⠌⡪⠮⡫⠪⡪⡪⣺⢸⠰⠡⠠⠐⢱⠨⡪⡪⡰\r\n⣯⢷⣟⣇⡂⡂⡌⡀⠀⠁⡂⠅⠂⠀⡑⡄⢇⠇⢝⡨⡠⡁⢐⠠⢀⢪⡐⡜⡪⡊\r\n⣿⢽⡾⢹⡄⠕⡅⢇⠂⠑⣴⡬⣬⣬⣆⢮⣦⣷⣵⣷⡗⢃⢮⠱⡸⢰⢱⢸⢨⢌\r\n⣯⢯⣟⠸⣳⡅⠜⠔⡌⡐⠈⠻⠟⣿⢿⣿⣿⠿⡻⣃⠢⣱⡳⡱⡩⢢⠣⡃⠢⠁\r\n⡯⣟⣞⡇⡿⣽⡪⡘⡰⠨⢐⢀⠢⢢⢄⢤⣰⠼⡾⢕⢕⡵⣝⠎⢌⢪⠪⡘⡌⠀\r\n⡯⣳⠯⠚⢊⠡⡂⢂⠨⠊⠔⡑⠬⡸⣘⢬⢪⣪⡺⡼⣕⢯⢞⢕⢝⠎⢻⢼⣀⠀\r\n⠁⡂⠔⡁⡢⠣⢀⠢⠀⠅⠱⡐⡱⡘⡔⡕⡕⣲⡹⣎⡮⡏⡑⢜⢼⡱⢩⣗⣯⣟\r\n⢀⢂⢑⠀⡂⡃⠅⠊⢄⢑⠠⠑⢕⢕⢝⢮⢺⢕⢟⢮⢊⢢⢱⢄⠃⣇⣞⢞⣞⢾\r\n⢀⠢⡑⡀⢂⢊⠠⠁⡂⡐⠀⠅⡈⠪⠪⠪⠣⠫⠑⡁⢔⠕⣜⣜⢦⡰⡎⡯⡾⡽', '662a84c3ec5670.78596281', 'png', '662ccadf7cc823.32427261'),
('Jojo ref', 'Mon nom est Yoshikage Kira. J&#039;ai 33 ans. Ma maison est située dans la partie nord-est de Morioh, où se trouvent toutes les villas, et je ne suis pas marié. Je travaille comme employé pour les grands magasins Kame Yu et je rentre chez moi tous les jours à 20 heures au plus tard. Je ne fume pas, mais je bois de temps en temps. Je suis au lit à 23 heures et m&#039;assure de dormir huit heures, quoi qu&#039;il arrive. Après avoir bu un verre de lait chaud et fait environ vingt minutes d&#039;étirements avant d&#039;aller me coucher, je n&#039;ai généralement aucun problème à dormir jusqu&#039;au matin. Comme un bébé, je me réveille le matin sans fatigue ni stress. On m&#039;a dit qu&#039;il n&#039;y avait pas de problèmes lors de mon dernier examen. J&#039;essaie d&#039;expliquer que je suis une personne qui souhaite vivre une vie très calme. Je prends soin de ne pas m&#039;inquiéter d&#039;ennemis tels que gagner ou perdre, cela me ferait perdre le sommeil la nuit. C&#039;est comme ça que je traite avec la société et je sais que c&#039;est ce qui m&#039;apporte le bonheur. Bien que, si je devais me battre, je ne perdrais face à personne.', '662a84c3ec5670.78596281', NULL, '662ccbcaecd828.96796049');

-- --------------------------------------------------------

--
-- Structure de la table `shopping_carts`
--

CREATE TABLE `shopping_carts` (
  `product_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `client_id` char(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `shopping_carts`
--

INSERT INTO `shopping_carts` (`product_id`, `count`, `client_id`) VALUES
(1, 4, '662a84c3ec5670.78596281');

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
('Eclipse', 'L&#039;Eclipse est notre &quot;montre star&quot; ici, à Octime. Son histoire est unique, car elle est la première montre produite par notre compagnie (et dans le monde entier !) à utiliser le système d&#039;heures octales au lieu du système classique. Elle est forgée à partir de régolithe lunaire, de titane et de chrome.', 'The Eclipse is our &quot;star watch&quot; here at Octime. It&#039;s history is unique, as it is the first ever watch produced in our company (and in the world !) that uses an octal hour system instead of the regular one. It is made out of lunar regolith, titanium and chrome.', 'O', 'M', 199, 2);

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
  ADD PRIMARY KEY (`id`),
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
