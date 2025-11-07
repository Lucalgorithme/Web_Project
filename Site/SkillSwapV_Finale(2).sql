-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 07 nov. 2025 à 21:03
-- Version du serveur : 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `SkillSwapV_Finale`
--

-- --------------------------------------------------------

--
-- Structure de la table `competences_acquises`
--

CREATE TABLE `competences_acquises` (
  `idComp` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `competences_acquises`
--

INSERT INTO `competences_acquises` (`idComp`, `nom`, `description`, `utilisateur`) VALUES
(1, 'Codage WEB', 'je code du WEB backend Frontend', 1),
(2, 'Code C', 'Le codage en C ', 1),
(3, 'JavaScript', 'Maîtrise avancée de JavaScript ES6+, frameworks React et Node.js', 3),
(4, 'Python', 'Développement backend avec Django et Flask, scripts d\'automatisation', 3),
(5, 'Musique piano', 'Je peux vous apprendre le piano.', 2),
(6, 'Photoshop', 'Retouche photo professionnelle et création graphique', 4),
(9, 'Design UX/UI', 'Création d\'interfaces utilisateur intuitives, prototypage avec Figma', 4),
(42, 'Web - Frontend/backend', 'Je peux vous apprendre les bonnes pratiques', 1),
(43, 'Cuisine', 'je peux vous apprendre la cuisine', 2),
(44, 'Création de jeu ', 'Je peux vous aider à créer un jeu', 46);

-- --------------------------------------------------------

--
-- Structure de la table `competences_recherche`
--

CREATE TABLE `competences_recherche` (
  `idCompRecherche` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `competences_recherche`
--

INSERT INTO `competences_recherche` (`idCompRecherche`, `nom`, `description`, `utilisateur`) VALUES
(1, 'Cuisine asiatique', 'J\'aimerais apprendre la cuisine thaï et japonaise', 2),
(2, 'Cuisine', 'je veux apprendre la cuisine française ?', 1),
(3, 'JavaScript', 'Veut comprendre le développement frontend pour mieux collaborer', 4),
(4, 'Marketing Digital', 'Souhaite acquérir des compétences en stratégie marketing online', 4),
(7, 'Design UX/UI', 'Souhaite apprendre les bases du design pour améliorer ses interfaces', 3),
(13, 'Electronique', 'Je voudrais apprendre le fonctionnement des AOP', 1),
(14, 'Avalam', 'Je voudrais battre Lukaz sur avalam', 46);

-- --------------------------------------------------------

--
-- Structure de la table `echanges`
--

CREATE TABLE `echanges` (
  `idEchange` int(11) NOT NULL,
  `idUser1` int(11) NOT NULL,
  `idComp1` int(11) NOT NULL,
  `idUser2` int(11) NOT NULL,
  `idComp2` int(11) NOT NULL,
  `validationUser1` int(11) NOT NULL DEFAULT 0,
  `voteUser1` int(11) NOT NULL DEFAULT 0,
  `voteUser2` int(11) NOT NULL DEFAULT 0,
  `actif` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `echanges`
--

INSERT INTO `echanges` (`idEchange`, `idUser1`, `idComp1`, `idUser2`, `idComp2`, `validationUser1`, `voteUser1`, `voteUser2`, `actif`) VALUES
(12, 1, 1, 2, 5, 1, 0, 1, 0),
(13, 1, 1, 2, 43, 1, 0, 1, 0),
(15, 1, 2, 2, 43, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `echanges_token`
--

CREATE TABLE `echanges_token` (
  `idEchangeToken` int(11) NOT NULL,
  `idUser1` int(11) NOT NULL,
  `idComp1` int(11) NOT NULL,
  `idUser2` int(11) NOT NULL,
  `token` int(11) NOT NULL,
  `validationUser1` int(11) NOT NULL DEFAULT 0,
  `voteUser1` int(11) NOT NULL DEFAULT 0,
  `voteUser2` int(11) NOT NULL DEFAULT 0,
  `actif` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `echanges_token`
--

INSERT INTO `echanges_token` (`idEchangeToken`, `idUser1`, `idComp1`, `idUser2`, `token`, `validationUser1`, `voteUser1`, `voteUser2`, `actif`) VALUES
(12, 4, 6, 1, 25, 0, 0, 0, 0),
(15, 3, 4, 2, 25, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `user_id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(7, 1, 'profil_1.png', 'ressources/profil/profil_1.png', '2025-06-05 21:31:30'),
(8, 46, 'profil_46.jpg', 'ressources/profil/profil_46.jpg', '2025-06-06 07:21:27'),
(11, 2, 'profil_2.jpg', 'ressources/profil/profil_2.jpg', '2025-06-06 11:15:43');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `idMessage` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `auteur` int(11) NOT NULL,
  `idEchange` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`idMessage`, `contenu`, `auteur`, `idEchange`) VALUES
(28, 'Salut comment ça va', 1, 12),
(29, 'bonjour', 1, 13),
(30, 'bien et vous ', 2, 12),
(31, 'on commence', 2, 12),
(32, 'slt on commence ?', 2, 13),
(34, '*******', 1, 15),
(35, '***', 2, 12),
(36, 'connaissance', 2, 12),
(37, '*****', 2, 12),
(38, 'Bonjour', 2, 12);

-- --------------------------------------------------------

--
-- Structure de la table `messages_token`
--

CREATE TABLE `messages_token` (
  `idMessageToken` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `auteur` int(11) NOT NULL,
  `idEchangeToken` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages_token`
--

INSERT INTO `messages_token` (`idMessageToken`, `contenu`, `auteur`, `idEchangeToken`) VALUES
(17, 'salut Python m\'intéresse beaucoup', 2, 15);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `passe` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `bio` text NOT NULL DEFAULT '',
  `token` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `passe`, `role`, `bio`, `token`) VALUES
(1, 'anto', 'html', 'admin', 'salut moi c\'est antonin', 75),
(2, 'luca', 'css', 'admin', 'Je suis Admin', 999950),
(3, 'AlexDev', 'password123', 'user', 'Développeur full-stack passionné par les nouvelles technologies', 100),
(4, 'MariePro', 'password456', 'user', 'Designer UX/UI avec 5 ans d\'expérience, toujours curieuse d\'apprendre', 175),
(45, 'pierre', '##jhTYVFR454', 'user', '', 100),
(46, 'Vincent Sélenne', 'avalam', 'user', 'j\'ai créé avalam', 200);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `competences_acquises`
--
ALTER TABLE `competences_acquises`
  ADD PRIMARY KEY (`idComp`),
  ADD KEY `utilisateur` (`utilisateur`);

--
-- Index pour la table `competences_recherche`
--
ALTER TABLE `competences_recherche`
  ADD PRIMARY KEY (`idCompRecherche`),
  ADD KEY `utilisateur` (`utilisateur`);

--
-- Index pour la table `echanges`
--
ALTER TABLE `echanges`
  ADD PRIMARY KEY (`idEchange`),
  ADD KEY `idUser1` (`idUser1`,`idComp1`,`idUser2`,`idComp2`),
  ADD KEY `idUser2` (`idUser2`),
  ADD KEY `idComp1` (`idComp1`),
  ADD KEY `idComp2` (`idComp2`);

--
-- Index pour la table `echanges_token`
--
ALTER TABLE `echanges_token`
  ADD PRIMARY KEY (`idEchangeToken`),
  ADD KEY `idUser1` (`idUser1`,`idComp1`),
  ADD KEY `idComp1` (`idComp1`),
  ADD KEY `idUser2` (`idUser2`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `Auteur` (`auteur`) USING BTREE,
  ADD KEY `idEchange` (`idEchange`);

--
-- Index pour la table `messages_token`
--
ALTER TABLE `messages_token`
  ADD PRIMARY KEY (`idMessageToken`),
  ADD KEY `auteur` (`auteur`,`idEchangeToken`),
  ADD KEY `idEchangeToken` (`idEchangeToken`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `competences_acquises`
--
ALTER TABLE `competences_acquises`
  MODIFY `idComp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `competences_recherche`
--
ALTER TABLE `competences_recherche`
  MODIFY `idCompRecherche` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `echanges`
--
ALTER TABLE `echanges`
  MODIFY `idEchange` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `echanges_token`
--
ALTER TABLE `echanges_token`
  MODIFY `idEchangeToken` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `messages_token`
--
ALTER TABLE `messages_token`
  MODIFY `idMessageToken` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `competences_acquises`
--
ALTER TABLE `competences_acquises`
  ADD CONSTRAINT `competences_acquises_ibfk_1` FOREIGN KEY (`utilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `competences_recherche`
--
ALTER TABLE `competences_recherche`
  ADD CONSTRAINT `competences_recherche_ibfk_1` FOREIGN KEY (`utilisateur`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `echanges`
--
ALTER TABLE `echanges`
  ADD CONSTRAINT `echanges_ibfk_1` FOREIGN KEY (`idUser1`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `echanges_ibfk_2` FOREIGN KEY (`idUser2`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `echanges_ibfk_3` FOREIGN KEY (`idComp1`) REFERENCES `competences_acquises` (`idComp`),
  ADD CONSTRAINT `echanges_ibfk_4` FOREIGN KEY (`idComp2`) REFERENCES `competences_acquises` (`idComp`);

--
-- Contraintes pour la table `echanges_token`
--
ALTER TABLE `echanges_token`
  ADD CONSTRAINT `echanges_token_ibfk_1` FOREIGN KEY (`idComp1`) REFERENCES `competences_acquises` (`idComp`),
  ADD CONSTRAINT `echanges_token_ibfk_2` FOREIGN KEY (`idUser1`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `echanges_token_ibfk_3` FOREIGN KEY (`idUser2`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`auteur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`idEchange`) REFERENCES `echanges` (`idEchange`);

--
-- Contraintes pour la table `messages_token`
--
ALTER TABLE `messages_token`
  ADD CONSTRAINT `messages_token_ibfk_1` FOREIGN KEY (`auteur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `messages_token_ibfk_2` FOREIGN KEY (`idEchangeToken`) REFERENCES `echanges_token` (`idEchangeToken`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
