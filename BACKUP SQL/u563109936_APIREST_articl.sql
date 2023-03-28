-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 28 mars 2023 à 09:43
-- Version du serveur : 10.6.10-MariaDB-cll-lve
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u563109936_APIREST_articl`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id_art` int(11) NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_publication` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_publication` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `auteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_art`, `contenu`, `nom_publication`, `date_publication`, `auteur`) VALUES
(1, 'Jadore les animaux et je men occupe très bien', 'Animaux', '2023-03-28 09:28:04', 3),
(2, 'Je ne mange plus de viandes', 'Végétarien', '2023-03-28 09:29:49', 3),
(3, 'Les chats sont les plus beaux animaux du monde', 'Chats', '2023-03-28 09:29:49', 3),
(4, 'Jai une voiture et je pollue beaucoup', 'Ma voiture', '2023-03-28 09:29:49', 3),
(5, 'Je suis un fou dans la vie', 'MyLife', '2023-03-28 09:30:43', 5),
(6, 'Jadore sortir voir mes amis', 'Friends', '2023-03-28 09:33:16', 5),
(7, 'Manger est ma passion', 'Miam', '2023-03-28 09:33:16', 5),
(8, 'Je suis un article de moi', 'ArticleMoi', '2023-03-28 09:33:16', 5),
(9, 'le cheval, le cheval cest trop génial', 'Cheval', '2023-03-28 09:33:57', 4),
(10, 'Jai une voiture mais je ne peux pas la conduire tous le temps', 'TristeCar', '2023-03-28 09:36:19', 4),
(11, 'Je vis actuellement dans une maison dont je ne paye pas le loyer', 'House', '2023-03-28 09:36:19', 4),
(12, 'Mon surnom est elenouille', 'Surnom', '2023-03-28 09:36:19', 4);

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_auteur` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `ressentiment` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_auteur`, `id_article`, `ressentiment`) VALUES
(3, 6, 0),
(3, 9, 0),
(3, 10, 1),
(3, 12, 0),
(4, 1, 1),
(4, 4, 1),
(4, 5, 0),
(4, 8, 1),
(5, 2, 1),
(5, 9, 1),
(5, 10, 1),
(5, 12, 0);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `nom`) VALUES
(1, 'Administrateur'),
(2, 'Publisher');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `pseudo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `pseudo`, `mdp`, `role`) VALUES
(1, 'Teo', '$2y$12$mHZ/MuCS9OThKsr1tx4Xku1J6GoMEM/0te/CEAEICjClrd0sdRQkW', 1),
(2, 'Arthur', '$2y$12$S30WMMoXQS3juzMEKUNOVu7eQfCUkxUzdpXbwwvgk57HKskh8m51e', 1),
(3, 'Nicolas', '$2y$12$pcl8PyTuK4uPv2zKaQ5rAOw3h6oNBjbxOJMv17g3aTDnZesTy6pC6', 2),
(4, 'Elena', '$2y$12$miYIWQgU13GtIi2Hcp7DQOqNlluLzRYRH0SOSJXIc9DH0rnoSR4CG', 2),
(5, 'Fantin', '$2y$12$pD5gHJ7l6ZZzcMvTzSzTbOrAvmJOpVrgCkt/ZKi0PCz2mL3howdru', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_art`),
  ADD KEY `auteur` (`auteur`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_auteur`,`id_article`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_art` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`auteur`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`id_auteur`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id_art`),
  ADD CONSTRAINT `avis_ibfk_3` FOREIGN KEY (`id_auteur`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
