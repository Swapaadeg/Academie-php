-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : ven. 06 juin 2025 à 14:25
-- Version du serveur : 8.0.42
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `academie`
--

-- --------------------------------------------------------

--
-- Structure de la table `bestiaire`
--

CREATE TABLE `bestiaire` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text,
  `type` varchar(50) NOT NULL,
  `img` varchar(255) NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bestiaire`
--

INSERT INTO `bestiaire` (`id`, `nom`, `description`, `type`, `img`, `user_id`) VALUES
(2, 'Cyclope', 'Géant de la mythologie grecque, généralement forgeron ou bâtisseur, qui n\'avait qu\'un gros œil au milieu du front', 'mi-bête', '174911671489.jpg', 4),
(3, 'Centaure', 'Un centaure est une créature de la mythologie grecque mi-homme et mi-cheval. la tête, les bras et le torse sont humains et attachés à la taille au corps et aux jambes d\'un cheval.', 'mi-bête', '1749117318754.jpg', 2),
(4, 'Harpie', 'Ce sont des divinités de la dévastation et de la vengeance divine. plus rapides que le vent, invulnérables, caquetantes, elles dévorent tout sur leur passage. elles empoisonnent les airs, et souillent la verdure.', 'mi-bête', '1749117421566.jpg', 2),
(5, 'Fantôme', 'Un fantôme est une apparition, une vision ou une illusion, interprétée comme une manifestation surnaturelle d\'une personne décédée.', 'mort-vivante', '1749117483949.jpg', 2),
(6, 'Succube', 'Un succube est un démon judéo-chrétien féminin qui séduit les hommes et abuse d\'eux durant leur sommeil et leurs rêves. les succubes servent lilith. leur pendant masculin est l\'incube.', 'démoniaque', '1749117530230.jpg', 2),
(7, 'Seigneur des abîmes', 'Les seigneurs des abîmes sont en général de grands sacs à points de vie. ils possèdent une grande force physique, ce qui leur permet d\'infliger de lourds dégâts. ils ont des sorts s\'approchant plus de la démonologie. ils utilisent une lance à double tranchants.', 'démoniaque', '1749130815672.jpg', 3),
(8, 'Kirin', 'Mi-dragon, mi-licorne, cette créature majestueuse est entourée d\'une aura de mystère et de légende, captivant l\'imagination des passionnés de mythologie et des amateurs de dragons à travers le monde. le kirin, souvent méconnu, incarne un symbolisme riche et profond dans les cultures asiatiques, où il est vénéré comme un porteur de sagesse, de prospérité, et de paix.', 'aquatique', '1749117747312.jpg', 3),
(9, 'Kappa', 'Le kappa est décrit comme dégageant une odeur forte et fétide, semblable à une odeur de poisson. la plupart des représentations font du kappa une créature avec une queue extrêmement courte, voire dépourvue de cet appendice.', 'aquatique', '1749117793963.jpg', 3),
(10, 'Lamassu', 'Le lamassu est un être céleste de l\'ancienne religion mésopotamienne. il porte une tête humaine, symbole de l\'intelligence ; un corps de taureau, symbole de la force ; et des ailes d\'aigle, symbole de la liberté . Il possède parfois des cornes et des oreilles de taureau.', 'mort-vivante', '1749117856319.jpg', 3),
(11, 'Cerbère', 'Il est représenté avec une queue de dragon, et des têtes de serpents sur l\'échine. cerbère est un monstre de la mythologie grecque et romaine, préposé à la garde des enfers, où il ne laisse pénétrer aucun humain vivant, d\'où il ne permet à aucune ombre de s\'échapper.', 'démoniaque', '1749117906794.jpg', 6),
(12, 'Tourmenteur', 'Les tourmenteurs sont vêtus d\'une longue capuche noire, ont une peau en cuir avec des veines noires saillantes. ils n\'ont pas de visage, celui-ci est entièrement noir. ils ont la taille d\'enfants et montent parfois des araignées géantes.', 'démoniaque', '1749117944825.jpg', 6),
(13, 'Minotaure', 'Le minotaure est un monstre fabuleux au corps d\'un homme et à tête d\'un taureau. monstre d\'une puissance incroyable, il est dangereux pour quiconque l\'approche', 'mi-bête', '1749118056782.png', 7),
(14, 'Liche', 'Un sorcier mort qui se maintient dans un état mort-vivant grâce à ses pouvoirs magiques.\r\n\r\nles liches sont habituellement des créatures maléfiques, hautement intelligentes, autonomes et surtout, très puissantes. mais la transformation d’un sorcier en liche peut se faire pour des raisons diverses, pas toujours maléfiques.', 'mort-vivante', '1749118129295.jpg', 5),
(15, 'Squelette', 'Un squelette ou skellington est, un personnage mort-vivant qui a perdu sa chair putréfiée, son corps n\'étant plus composé que de ses os qui sont maintenus en « vie » magiquement ou grâce à tout autre phénomène surnaturel.', 'mort-vivante', '1749118165673.jpg', 5);

-- --------------------------------------------------------

--
-- Structure de la table `elements`
--

CREATE TABLE `elements` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `elements`
--

INSERT INTO `elements` (`id`, `nom`) VALUES
(3, 'Air'),
(2, 'Eau'),
(1, 'Feu'),
(4, 'Lumière'),
(7, 'Terre');

-- --------------------------------------------------------

--
-- Structure de la table `sorts`
--

CREATE TABLE `sorts` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL,
  `element_id` int NOT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `sorts`
--

INSERT INTO `sorts` (`id`, `nom`, `img`, `element_id`, `user_id`) VALUES
(2, 'Soin', '17491984474.webp', 4, 4),
(3, 'Armure Céleste', '1749198469780.webp', 4, 4),
(4, 'Blizzard', '17492020609461.webp', 2, 2),
(5, 'Cercle de l&#039;Hiver', '1749199054739.webp', 2, 2),
(6, 'Boule de Feu', '1749199103761.webp', 1, 3),
(7, 'Tempête de Feu', '174919911834.webp', 1, 3),
(8, 'retribution', '1749199141122.webp', 4, 3),
(9, 'Elementaire d&#039;air', '1749199191773.webp', 3, 5),
(10, 'Armure de Glace', '1749199213959.webp', 2, 5),
(11, 'Elémentaire d&#039;eau', '1749199277478.webp', 2, 5),
(12, 'Mur de Glace', '1749199291330.webp', 2, 5),
(13, 'Bouclier de feu', '1749199325432.webp', 1, 6),
(14, 'Elementair de Feu', '1749199343193.webp', 1, 6),
(15, 'Immolation', '1749199352720.webp', 1, 6),
(16, 'vent violent', '1749199381369.webp', 3, 7),
(17, 'Elémentaire de Lumière', '1749199452101.webp', 4, 4),
(18, 'Purification', '1749199477546.webp', 4, 4),
(19, 'Eclair', '1749204914520.webp', 3, 7);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'Catherine', '$2y$10$/8jQkLwfp7kXMLfdNL26eeZrx5kEkS5e0lXjCsKcl0XRwHDFqIf3W', 'admin'),
(2, 'anastasya', '$2y$10$7p2rAnEFxBdurq0ts608e.g5yTssLbXUHVcSfQfmoHTn2MBi0pIsi', 'eleve'),
(3, 'kiril', '$2y$10$p1pT54FDJKgID4g2tGKdweTeIyRL6oA1znCnqklgraEINu0.uLgyG', 'eleve'),
(4, 'anton', '$2y$10$mxbjBaKXYDaBDCXPHPC2NOgXI11.7BWpCfgIEPuH8HcjTtNhwtXaG', 'eleve'),
(5, 'irina', '$2y$10$ppeowdF8IPzD.oycK0or6.kxP1qvwZa4oGDMACyFGSlEVL7vsxf/.', 'eleve'),
(6, 'jorgen', '$2y$10$n1YfZg104egCdm/TeiK.V.LgsRaY1c3Tcvoan2DFimfaprLDMxARe', 'eleve'),
(7, 'kalindra', '$2y$10$bGQeplnj9GJv/9zuV/zGk.f6Wd9G6Vm8XgqkDDKgzeVM.pEXJ7IEK', 'eleve');

-- --------------------------------------------------------

--
-- Structure de la table `user_elements`
--

CREATE TABLE `user_elements` (
  `user_id` int NOT NULL,
  `element_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_elements`
--

INSERT INTO `user_elements` (`user_id`, `element_id`) VALUES
(3, 1),
(6, 1),
(2, 2),
(4, 2),
(5, 2),
(5, 3),
(7, 3),
(3, 4),
(4, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bestiaire`
--
ALTER TABLE `bestiaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`user_id`);

--
-- Index pour la table `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `sorts`
--
ALTER TABLE `sorts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sorts_element` (`element_id`),
  ADD KEY `fk_sorts_user` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `user_elements`
--
ALTER TABLE `user_elements`
  ADD PRIMARY KEY (`user_id`,`element_id`),
  ADD KEY `element_id` (`element_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bestiaire`
--
ALTER TABLE `bestiaire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `elements`
--
ALTER TABLE `elements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `sorts`
--
ALTER TABLE `sorts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bestiaire`
--
ALTER TABLE `bestiaire`
  ADD CONSTRAINT `bestiaire_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sorts`
--
ALTER TABLE `sorts`
  ADD CONSTRAINT `fk_sorts_element` FOREIGN KEY (`element_id`) REFERENCES `elements` (`id`),
  ADD CONSTRAINT `fk_sorts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sorts_ibfk_1` FOREIGN KEY (`element_id`) REFERENCES `elements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sorts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `user_elements`
--
ALTER TABLE `user_elements`
  ADD CONSTRAINT `user_elements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_elements_ibfk_2` FOREIGN KEY (`element_id`) REFERENCES `elements` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
