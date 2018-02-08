-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 07 Février 2018 à 14:00
-- Version du serveur :  5.5.54-0+deb7u1
-- Version de PHP :  5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `marchespublics`
--

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
`id_document` int(11) NOT NULL,
  `id_marche` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  `date_mel` date NOT NULL,
  `type` enum('publies','offres') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `marche`
--

CREATE TABLE IF NOT EXISTS `marche` (
`id_marche` int(11) NOT NULL,
  `id_marche_formate` varchar(10) NOT NULL,
  `id_montant` int(11) NOT NULL,
  `date_mel_com` date NOT NULL,
  `redacteur` varchar(255) NOT NULL,
  `type` enum('fournitures','travaux','services') NOT NULL,
  `titre` varchar(255) NOT NULL,
  `objet` text NOT NULL,
  `publicite` varchar(255) NOT NULL,
  `date_attribution` date NOT NULL,
  `num_comptable` varchar(20) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `avenant1` date NOT NULL,
  `avenant2` date NOT NULL,
  `avenant3` date NOT NULL,
  `attributaire` varchar(255) NOT NULL,
  `code_postal` int(11) NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `montant_ht_total` decimal(10,2) NOT NULL,
  `montant_ht_non_soumis_total` decimal(10,2) NOT NULL,
  `taux_tva_total` decimal(10,2) NOT NULL DEFAULT '20.00',
  `montant_ttc_total` decimal(10,2) NOT NULL,
  `infos` varchar(500) NOT NULL,
  `certif_adm` enum('0','1') NOT NULL,
  `montant_ht_attributaire` decimal(10,2) NOT NULL,
  `montant_ht_non_soumis_attributaire` decimal(10,2) NOT NULL,
  `taux_tva_attributaire` decimal(10,2) NOT NULL DEFAULT '20.00',
  `montant_ttc_attributaire` decimal(10,2) NOT NULL,
  `sstraitant` varchar(255) NOT NULL,
  `montant_ht_sstraitant` decimal(10,2) NOT NULL,
  `montant_ht_non_soumis_sstraitant` decimal(10,2) NOT NULL,
  `taux_tva_sstraitant` decimal(10,2) NOT NULL DEFAULT '20.00',
  `montant_ttc_sstraitant` decimal(10,2) NOT NULL,
  `cotraitant_type` enum('solidaire','conjoint','solidaire_conjoint') NOT NULL,
  `cotraitant` varchar(255) NOT NULL,
  `montant_ht_cotraitant` decimal(10,2) NOT NULL,
  `montant_ht_non_soumis_cotraitant` decimal(10,2) NOT NULL,
  `taux_tva_cotraitant` decimal(10,2) NOT NULL DEFAULT '20.00',
  `montant_ttc_cotraitant` decimal(10,2) NOT NULL,
  `tranche_ferme` decimal(10,2) NOT NULL,
  `tranche_conditionnelle1` decimal(10,2) NOT NULL,
  `tranche_conditionnelle2` decimal(10,2) NOT NULL,
  `marche_reconductible` enum('O','N') NOT NULL DEFAULT 'N',
  `date_reconduction_ferme` date NOT NULL,
  `date_engagement_tc1` date NOT NULL,
  `date_engagement_tc2` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `montant`
--

CREATE TABLE IF NOT EXISTS `montant` (
`id_montant` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `actif` enum('0','1') NOT NULL,
  `publi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE IF NOT EXISTS `personne` (
`id_personne` int(11) NOT NULL,
  `login` varchar(40) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `piece`
--

CREATE TABLE IF NOT EXISTS `piece` (
`id_piece` int(11) NOT NULL,
  `id_marche` int(11) NOT NULL,
  `piece` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `document`
--
ALTER TABLE `document`
 ADD PRIMARY KEY (`id_document`);

--
-- Index pour la table `marche`
--
ALTER TABLE `marche`
 ADD PRIMARY KEY (`id_marche`), ADD KEY `id_montant` (`id_montant`);

--
-- Index pour la table `montant`
--
ALTER TABLE `montant`
 ADD PRIMARY KEY (`id_montant`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
 ADD PRIMARY KEY (`id_personne`);

--
-- Index pour la table `piece`
--
ALTER TABLE `piece`
 ADD PRIMARY KEY (`id_piece`), ADD KEY `id_marche` (`id_marche`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `document`
--
ALTER TABLE `document`
MODIFY `id_document` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `marche`
--
ALTER TABLE `marche`
MODIFY `id_marche` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `montant`
--
ALTER TABLE `montant`
MODIFY `id_montant` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
MODIFY `id_personne` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `piece`
--
ALTER TABLE `piece`
MODIFY `id_piece` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `marche`
--
ALTER TABLE `marche`
ADD CONSTRAINT `marche_ibfk_1` FOREIGN KEY (`id_montant`) REFERENCES `montant` (`id_montant`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `piece`
--
ALTER TABLE `piece`
ADD CONSTRAINT `piece_ibfk_1` FOREIGN KEY (`id_marche`) REFERENCES `marche` (`id_marche`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
