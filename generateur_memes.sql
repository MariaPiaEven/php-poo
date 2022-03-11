-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 11 mars 2022 à 16:52
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `generateur_memes`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(10) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'Trending'),
(2, 'Populaire'),
(3, 'Classique');

-- --------------------------------------------------------

--
-- Structure de la table `meme`
--

CREATE TABLE `meme` (
  `id` int(10) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `nom_image` varchar(255) NOT NULL,
  `id_createur` int(10) NOT NULL,
  `id_categorie` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `meme`
--

INSERT INTO `meme` (`id`, `titre`, `nom_image`, `id_createur`, `id_categorie`) VALUES
(2, 'Ancient Aliens', 'Ancient-Aliens.jpg', 1, 2),
(3, 'Batman Slapping Robin', 'Batman-Slapping-Robin.jpg', 1, 1),
(4, 'doge', 'doge.jpg', 1, 1),
(5, 'Hide the Pain Harold', 'Hide-the-Pain-Harold.jpg', 1, 1),
(8, 'Mocking-Spongebob', 'Mocking-Spongebob.jpg', 1, 1),
(10, 'One Does Not Simply', 'One-Does-Not-Simply.jpg', 1, 1),
(11, 'Oprah You Get A', 'Oprah-You-Get-A.jpg', 1, 1),
(13, 'success', 'success.jpg', 1, 1),
(15, 'X Everywhere', 'X-Everywhere.jpg', 1, 1),
(16, 'Drake Hotline Bling', 'Drake-Hotline-Bling.jpg', 1, 1),
(17, 'Two-Buttons', 'Two-Buttons.jpg', 1, 1),
(18, 'Distracted Boyfriend', 'Distracted-Boyfriend.jpg', 1, 1),
(19, 'Running Away Balloon', 'Running-Away-Balloon.jpg', 1, 1),
(20, 'Buff Doge vs. Cheems', 'Buff-Doge-vs-Cheems.png', 1, 1),
(21, 'Woman Yelling At Cat', 'Woman-Yelling-At-Cat.jpg', 1, 1),
(22, 'Waiting Skeleton', 'Waiting-Skeleton.jpg', 1, 1),
(23, 'Disaster Girl', 'Disaster-Girl.jpg', 1, 1),
(24, 'I Bet He\'s Thinking About Other Women', 'I-Bet-He-s-Thinking-About-Other-Women.jpg', 1, 1),
(25, 'Monkey Puppet', 'Monkey-Puppet.jpg', 1, 1),
(26, 'This Is Fine', 'This-Is-Fine.jpg', 1, 1),
(27, 'the Rock Driving', 'The-Rock-Driving.jpg', 1, 1),
(28, 'Roll Safe Think About It', 'Roll-Safe-Think-About-It.jpg', 1, 1),
(29, 'Laughing Leo', 'Laughing-Leo.png', 1, 1),
(30, 'Evil Kermit', 'Evil-Kermit.jpg', 1, 1),
(31, 'Unsettled Tom', 'Unsettled-Tom.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(10) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `mail`, `mot_de_passe`, `admin`) VALUES
(1, '', 'tototo', '$2y$10$iiqmPLte8i5trRtHz43lEexLj0Ij7GYVTL7tyDsjJM19d.IXxFpdK', 0),
(10, 'maria', 'piapiapia', '$2y$10$BuMgTenUpfrjWIc7WjAWz.8UwHhXGZcO6NwfOsxEiudKZSikqZXU.', 0),
(11, 'tetete', 'tetete', '$2y$10$JTLH9TJ9QQlJjKkynKD1hOnSR9p.YSYc.CxekBSC8jR6OJkEPcAd.', 0),
(31, 'tttttt', 'tttttt', '$2y$10$kIzwVSCj4qNuoVoplvFLWObyFbQICMaxSGNu6mQTwRBF7EmdYnELK', 0),
(32, 'ttttt', 'ttttt', '$2y$10$NA8qU5.fea3N8KOWrTgpDO00LR5W3cHsXXx1j4ZcuqnNH8Nurthbm', 0),
(33, 'ttttt', 'ttttt', '$2y$10$2Ppy.7ylkMZucRAbzWH0lOdtGLkmmMu2H2hASqWFw79tq.GNEv4Be', 0),
(34, 'rrrrr', 'rrrrr', '$2y$10$F9rStA2ZfaXF9W5odvdgYu/I50oLnqi7q0FxNQWKl3.Dl9hZv02HW', 0),
(35, 'uuuuu', 'uuuuu', '$2y$10$mQNX1vbuDt9lvgsJ/lqMluMZtQS7PGCL88wO2kAXzuuJS47H/8qMC', 0),
(36, 'ppppp', 'ppppp', '$2y$10$DQbn5rgqabSuZjY80yldL.Au4H4cqG9JgFE4iCM.RKE6h5negha.u', 0),
(37, '00000', '00000', '$2y$10$75/puNf5xA6pl6k7IP7jj.lS1cMWxW0ylstlY7gxzZvWPkQNN6zCu', 0),
(38, '11111', '11111', '$2y$10$7JN1UycJ9OaVoF6YLERHQeSTnKx510BKyCOSsZMmYcVjGwOgUk0We', 0),
(39, '00000', '00000', '$2y$10$drx4XL3CkKslcmdIJWB9vO81TMrhhmfEeQiR0OA7dOAhQS2.t2rGO', 0),
(40, '00000', '00000', '$2y$10$a1ad0YEQ9l0Lid0Om3g8xeXoJ/SmZBIJlUx92/1.S00QEupoYS/gy', 0),
(41, '00000', '00000', '$2y$10$F6vEopmiEfAbgocCvDnTA.ogKbTrc2poZhZGdLRlgQjWzVWUzrcC2', 0),
(42, '00000', '00000', '$2y$10$Fu5GMG8Knv1Iq6uWXxpbZO8ev6.kckg1BtUOaKCIKNE8trbRF.iD6', 0),
(43, '00000', '00000', '$2y$10$opjyStBmWFIQnSinsB9RUO4hQh/Mh0bdLC9MTn4kUexUBWWA/qoBO', 0),
(44, '00000', '00000', '$2y$10$4ki0FutiywuMdeqifbhoPuhzVBZxp30jACLq7o6JY9zyaOQZ5TjdW', 0),
(45, '00000', '00000', '$2y$10$X4Ops6eUcrHGeqq9NIIXae2Q2kuZQWbE6xYqE72GJivyhzGy11Po2', 0),
(46, '00000', '00000', '$2y$10$P8/8OudHLN8IplplxXT2E.Y0ZUtdCzsuVPfs/KS2OpcHvKUEQhbR.', 0),
(47, '00000', '00000', '$2y$10$OHjfkAu82oU.EshNxlSXvOXp3aDhBTQcQEf1KA.q7FT8aCGcH/DvC', 0),
(48, '00000', '00000', '$2y$10$iP8OVbi1QvOsyhnuLP7f1uxYf5uFdXxN3mRyCZrIKlILu6o00sEoC', 0),
(49, '00000', '00000', '$2y$10$4EFDzJH9v2FuMQ7rl2Wqcugd3ZzyCGDP4XQ77DcDMp0AzuzUjmXva', 0),
(50, '77777', '77777', '$2y$10$jbMnmG1iVgA3J8N3cyO8SuFpj69upPllQwdR4u1aLDSEywNT9zB/O', 0),
(51, '88888', '88888', '$2y$10$M45An4nrhfmRU6mW.kJ3dO0u/f8dAHReGx9f9XJiDRFqVuwThCjnK', 0),
(52, '77777', '77777', '$2y$10$ozHmD3ggsx0bp6dCWf8F0eo.jqTArwaTq2nLNqkp76p.vpO7IKKfO', 0),
(53, '77777', '77777', '$2y$10$SLyzMeo1lPchVe79sSFLgOcVKC.L3boMZ3C47q1i7e/QcL5u4Ta26', 0),
(54, '77777', '77777', '$2y$10$8u8cZEVp8M5SJzh87SXzjecsDpW9vZOLdChcaLJyLA.RTiW0xygdO', 0),
(55, '77777', '77777', '$2y$10$DTW8H6CfTQLcmu.n3eH.SO7IeVK6fvHyFjgZBhPjQ68mDmLE7Cyfu', 0),
(56, '77777', '77777', '$2y$10$LYzQXhkXa95J5nupr2YAWu0l3wxCr2VlIgjxK7kIcmkQK67zMG1Jy', 0),
(57, '77777', '77777', '$2y$10$ongamXYohUbxYIDVmV.qfuDdTALRr6gZUaqD8UUxrwLxzNybSTMFi', 0),
(58, '77777', '77777', '$2y$10$0Hb0waLATln2/PpSEJM3Re60SlGeTAOWzwiX7GzE47xiYMC9xJDqi', 0),
(59, '77777', '77777', '$2y$10$UEfTKNaMNcmDaqK..qsMAOLbqDK8ymUh2tHu5Z8jQJuYD6rE6oPnW', 0),
(60, '77777', '77777', '$2y$10$38VCKQgKAjmaI3vxhWMpUeYgYe/zlOzX/1g33IL/bjVTrPKwiktBi', 0),
(61, '77777', '77777', '$2y$10$6Yj74sBcCy.Oz6MLXSAqCOWt0xrTvb37uwa7q0pD9r0Ux3UXscjOa', 0),
(62, '77777', '77777', '$2y$10$mGm3CUt8d.FSwfKj0v3jAOH1WSz8i.aotDxWTwvHmnw/GG99sMqmu', 0),
(63, '77777', '77777', '$2y$10$e.nTrwSV6WNyb2d3xfr6GO5pb4HKAVXitGujjw3pdPipQ0AuZn4J6', 0),
(64, '77777', '77777', '$2y$10$f7NFbBhMwTQVnJnu/KMTvOmGMs2C/IcnR3pXId7IfTs1cklZARmYe', 0),
(65, '77777', '77777', '$2y$10$1FprgvXsXntxHaPHTgf2f.TZjomsiRa1SCj7CDClh.W0apSSlE/72', 0),
(66, '77777', '77777', '$2y$10$rIQDc0I12ELNkrulfRR3WORNEi23FRWHyeYXO4tr4kmEg67BaADZO', 0),
(67, '77777', '77777', '$2y$10$X3JxCK/czIdPTXUFuMTtye8KWfpOkN53EHjejPSX6WmT/gD1/UPPe', 0),
(68, '77777', '77777', '$2y$10$l5KGOWtXTGfGc7daY4oLverQF1zeIlibXyHqV9839eQ12vumRx0vq', 0),
(69, '77777', '77777', '$2y$10$I9F23mHkHHV4sPRAeM74Ee4POP7Bpn.uuS8o0oQGvgS8ze9xcnb8y', 0),
(70, '77777', '77777', '$2y$10$JC9sW.bFE76zM6ZPs/IAYOg90WY1UAPmVclPvgBQNX2ekPPVuHvSe', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilise`
--

CREATE TABLE `utilise` (
  `id_utilisateur` int(11) NOT NULL,
  `id_meme` int(11) NOT NULL,
  `date_de_creation` date NOT NULL,
  `texte_1` varchar(255) NOT NULL,
  `texte_2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilise`
--

INSERT INTO `utilise` (`id_utilisateur`, `id_meme`, `date_de_creation`, `texte_1`, `texte_2`) VALUES
(1, 2, '2022-03-08', 'TEXTE A', 'TEXTE B'),
(1, 2, '2022-03-08', 'deuxieme essai 1', 'deuxieme essai 2');

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE `vote` (
  `id_utilisateur` int(10) NOT NULL,
  `id_meme` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `meme`
--
ALTER TABLE `meme`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_meme_createur` (`id_createur`),
  ADD KEY `fk_meme_categorie` (`id_categorie`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilise`
--
ALTER TABLE `utilise`
  ADD KEY `fk_utilise_utilisateur` (`id_utilisateur`),
  ADD KEY `fk_utilise_meme` (`id_meme`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `meme`
--
ALTER TABLE `meme`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `meme`
--
ALTER TABLE `meme`
  ADD CONSTRAINT `fk_meme_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `fk_meme_createur` FOREIGN KEY (`id_createur`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `utilise`
--
ALTER TABLE `utilise`
  ADD CONSTRAINT `fk_utilise_meme` FOREIGN KEY (`id_meme`) REFERENCES `meme` (`id`),
  ADD CONSTRAINT `fk_utilise_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
