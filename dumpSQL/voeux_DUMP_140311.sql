-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 11 Mars 2014 à 14:06
-- Version du serveur: 5.5.33
-- Version de PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `voeux`
--
CREATE DATABASE IF NOT EXISTS `voeux` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `voeux`;

-- --------------------------------------------------------

--
-- Structure de la table `contenu`
--

DROP TABLE IF EXISTS `contenu`;
CREATE TABLE `contenu` (
  `module` varchar(45) NOT NULL COMMENT 'Nom du module (FK vers l''attribut ident de module)',
  `partie` varchar(20) NOT NULL COMMENT 'Mon de la partie du module, par exemple CM, CM partie 1, CM partie 1, TD (si un seul TD), TD 1, TD 2, TP 1, TP 2, etc.',
  `type` varchar(45) NOT NULL COMMENT 'Type de la partie, à choisir parmis {CM, TD, TP, projet}',
  `hed` varchar(45) NOT NULL COMMENT 'Nombre d''heures équivalent TD associées à la partie',
  `enseignant` varchar(10) DEFAULT NULL COMMENT 'Enseignant assurant la partie de cours (FK vers l''attribut login de user)',
  PRIMARY KEY (`module`,`partie`),
  KEY `FK_contenu_module_idx` (`module`),
  KEY `FK_contenu_enseignant_idx` (`enseignant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `contenu`
--

INSERT INTO `contenu` VALUES('ALGOC1', 'CM', 'CM', '22', 'fgoasdoue');
INSERT INTO `contenu` VALUES('ALGOC1', 'TD 1', 'TD', '14', 'fgoasdoue');
INSERT INTO `contenu` VALUES('ALGOC1', 'TD 2', 'TD', '14', 'kabbaci');
INSERT INTO `contenu` VALUES('ALGOC1', 'TD 3', 'TD', '14', 'nestibal');
INSERT INTO `contenu` VALUES('ALGOC1', 'TP 1', 'TP', '18', 'fgoasdoue');
INSERT INTO `contenu` VALUES('ALGOC1', 'TP 2', 'TP', '18', NULL);
INSERT INTO `contenu` VALUES('ALGOC1', 'TP 3', 'TP', '18', NULL);
INSERT INTO `contenu` VALUES('ALGOC1', 'TP 4', 'TP', '18', NULL);
INSERT INTO `contenu` VALUES('ALGOC1', 'TP 5', 'TP', '18', NULL);
INSERT INTO `contenu` VALUES('ALGOC2', 'CM', 'CM', '15', 'fgoasdoue');
INSERT INTO `contenu` VALUES('ALGOC2', 'TD', 'TD', '6', NULL);
INSERT INTO `contenu` VALUES('ALGOC2', 'TP 1', 'TP', '14', NULL);
INSERT INTO `contenu` VALUES('ALGOC2', 'TP 2', 'TP', '14', 'kabbaci');
INSERT INTO `contenu` VALUES('BD', 'CM', 'CM', '27', 'opivert');
INSERT INTO `contenu` VALUES('BD', 'TD', 'TD', '16', NULL);
INSERT INTO `contenu` VALUES('BD', 'TP 1', 'TP', '20', NULL);
INSERT INTO `contenu` VALUES('BD', 'TP 2', 'TP', '20', NULL);
INSERT INTO `contenu` VALUES('DOO', 'CM', 'CM', '24', NULL);
INSERT INTO `contenu` VALUES('DOO', 'TD', 'TD', '8', NULL);
INSERT INTO `contenu` VALUES('DOO', 'TP 1', 'TP', '18', NULL);
INSERT INTO `contenu` VALUES('DOO', 'TP 2', 'TP', '18', NULL);
INSERT INTO `contenu` VALUES('FONDSE', 'CM', 'CM', '30', NULL);
INSERT INTO `contenu` VALUES('FONDSE', 'TD', 'TD', '10', NULL);
INSERT INTO `contenu` VALUES('INTROSE', 'CM partie 1', 'CM', '15', 'jpettier');
INSERT INTO `contenu` VALUES('INTROSE', 'CM partie 2', 'CM', '6', 'jpettier');
INSERT INTO `contenu` VALUES('JavaIHM', 'CM', 'CM', '18', 'vthion');
INSERT INTO `contenu` VALUES('JavaIHM', 'TP', 'TP', '24', 'vthion');
INSERT INTO `contenu` VALUES('MDD', 'CM', 'CM', '18', 'hjaudoin');
INSERT INTO `contenu` VALUES('MDD', 'TD', 'TD', '8', 'hjaudoin');
INSERT INTO `contenu` VALUES('RESIMREII', 'CM partie 1', 'CM', '10', 'fgoasdoue');
INSERT INTO `contenu` VALUES('RESIMREII', 'CM partie 2', 'CM', '10', NULL);
INSERT INTO `contenu` VALUES('RESIMREII', 'TD EII2', 'TD', '10', 'fgoasdoue');
INSERT INTO `contenu` VALUES('RESIMREII', 'TD IMR1', 'TD', '10', NULL);
INSERT INTO `contenu` VALUES('SAR', 'CM', 'CM', '12', 'vbarreaud');
INSERT INTO `contenu` VALUES('SAR', 'TP partie 1', 'TP', '10', 'vbarreaud');
INSERT INTO `contenu` VALUES('SAR', 'TP partie 2', 'TP', '10', NULL);
INSERT INTO `contenu` VALUES('SDD', 'CM', 'CM', '33', 'hjaudoin');
INSERT INTO `contenu` VALUES('SDD', 'TD', 'TD', '20', 'hjaudoin');
INSERT INTO `contenu` VALUES('SDD', 'TP 1', 'TP', '22', NULL);
INSERT INTO `contenu` VALUES('SDD', 'TP 2', 'TP', '22', NULL);
INSERT INTO `contenu` VALUES('UML', 'CM', 'CM', '15', NULL);
INSERT INTO `contenu` VALUES('UML', 'Projet', 'Projet', '8', NULL);
INSERT INTO `contenu` VALUES('UML', 'TD', 'TD', '6', NULL);
INSERT INTO `contenu` VALUES('UML', 'TP', 'TP', '4', NULL);
INSERT INTO `contenu` VALUES('UnixP', 'CM', 'CM', '9', 'vthion');
INSERT INTO `contenu` VALUES('UnixP', 'TP 1', 'TP', '18', 'vthion');
INSERT INTO `contenu` VALUES('UnixP', 'TP 2', 'TP', '18', 'kabbaci');
INSERT INTO `contenu` VALUES('UnixU', 'CM', 'CM', '3', 'kabbaci');
INSERT INTO `contenu` VALUES('UnixU', 'TP 1', 'TP', '18', NULL);
INSERT INTO `contenu` VALUES('UnixU', 'TP 2', 'TP', '18', 'hjaudoin');

-- --------------------------------------------------------

--
-- Structure de la table `decharge`
--

DROP TABLE IF EXISTS `decharge`;
CREATE TABLE `decharge` (
  `enseignant` varchar(10) NOT NULL COMMENT 'Login de l''enseignant concerné par une décharge',
  `decharge` int(11) NOT NULL DEFAULT '0' COMMENT 'Nombre d''heures TOTALES de décharge',
  PRIMARY KEY (`enseignant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `decharge`
--

INSERT INTO `decharge` VALUES('hjaudoin', 10);
INSERT INTO `decharge` VALUES('opivert', 14);
INSERT INTO `decharge` VALUES('vthion', 22);

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

DROP TABLE IF EXISTS `enseignant`;
CREATE TABLE `enseignant` (
  `login` varchar(10) NOT NULL COMMENT 'Login (identifiant) de l''enseignant.\nPour simuler un utilisateur non enseignant, simplement indiquer un service statutaire à 0.',
  `pwd` varchar(20) NOT NULL DEFAULT 'servicesENSSAT' COMMENT 'Mot de passe',
  `nom` varchar(40) NOT NULL COMMENT 'Nom de famille',
  `prenom` varchar(40) NOT NULL COMMENT 'Prénom',
  `statut` varchar(45) NOT NULL COMMENT 'Statut à choisir parmis {administratif, contractuel, titulaire, vacataire)',
  `statutaire` int(11) DEFAULT '192' COMMENT 'Service statutaire de l''enseignant. Les éventuelles décharges sont indiquées dans la table decharge. \n',
  `actif` int(1) NOT NULL DEFAULT '1' COMMENT 'Indique si l''enseignant est actif, à choisir parmi 0 pour inactif et 1 pour actif',
  `administrateur` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `enseignant`
--

INSERT INTO `enseignant` VALUES('ahadjali', 'servicesENSSAT', 'Hadjali', 'Allel', 'permanent', 192, 0, 0);
INSERT INTO `enseignant` VALUES('bvozel', 'servicesENSSAT', 'Vozel', 'Benoit', 'titulaire', 192, 1, 0);
INSERT INTO `enseignant` VALUES('dguennec', 'servicesENSSAT', 'Guennec', 'David', 'contractuel', 192, 1, 0);
INSERT INTO `enseignant` VALUES('fgoasdoue', 'servicesENSSAT', 'Goasdoué', 'François', 'titulaire', 192, 1, 0);
INSERT INTO `enseignant` VALUES('glecorve', 'servicesENSSAT', 'Lecorvé', 'Gwénolé', 'titulaire', 192, 1, 0);
INSERT INTO `enseignant` VALUES('hjaudoin', 'servicesENSSAT', 'Jaudoin', 'Hélène', 'titulaire', 192, 1, 0);
INSERT INTO `enseignant` VALUES('jpettier', 'servicesENSSAT', 'Pettier', 'Jean-Christophe', 'titulaire', 192, 1, 0);
INSERT INTO `enseignant` VALUES('kabbaci', 'servicesENSSAT', 'Abbaci', 'Katia', 'contractuel', 192, 1, 0);
INSERT INTO `enseignant` VALUES('nestibal', 'servicesENSSAT', 'Estibal', 'Nicolas', 'contractuel', 192, 1, 0);
INSERT INTO `enseignant` VALUES('opivert', 'servicesENSSAT', 'Pivert', 'Olivier', 'titulaire', 192, 1, 0);
INSERT INTO `enseignant` VALUES('pbosc', 'servicesENSSAT', 'Bosc', 'Patrick', 'titulaire', 192, 1, 0);
INSERT INTO `enseignant` VALUES('pcrepieux', 'servicesENSSAT', 'Crepieux', 'Pierre', 'vacataire', 192, 1, 0);
INSERT INTO `enseignant` VALUES('vbarreaud', 'servicesENSSAT', 'Barreaud', 'Vincent', 'titulaire', 192, 1, 0);
INSERT INTO `enseignant` VALUES('vthion', 'servicesENSSAT', 'Thion', 'Virginie', 'titulaire', 192, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `ident` varchar(10) NOT NULL COMMENT 'identifiant du module',
  `public` varchar(20) NOT NULL COMMENT 'Formation, à choisir parmi {par exemple, EII2, TC, Commun IMR1-EII2}',
  `semestre` varchar(10) NOT NULL DEFAULT 'S1',
  `libelle` varchar(50) NOT NULL COMMENT 'Label (nom long) du module',
  `responsable` varchar(10) DEFAULT NULL COMMENT 'Responsable du module (FK vers login de user)',
  PRIMARY KEY (`ident`),
  KEY `FK_module_responsable_idx` (`responsable`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `module`
--

INSERT INTO `module` VALUES('ALGOC1', 'TC', 'S1', 'Algorithmique et language C 1', 'fgoasdoue');
INSERT INTO `module` VALUES('ALGOC2', 'LSI1', 'S1', 'Algorithmique et language C 2', NULL);
INSERT INTO `module` VALUES('BD', 'LSI1', 'S2', 'Bases de données', NULL);
INSERT INTO `module` VALUES('DOO', 'LSI1', 'S2', 'Développement Orienté Objet', NULL);
INSERT INTO `module` VALUES('FONDSE', 'LSI1', 'S2', 'Fondement des Systèmes d''Exploitation', NULL);
INSERT INTO `module` VALUES('INTROSE', 'LSI1', 'S1', 'Introduction aux systèmes d''exploitatiob', 'jpettier');
INSERT INTO `module` VALUES('JavaIHM', 'LSI2', 'S1', 'Java Interfaces graphiques', NULL);
INSERT INTO `module` VALUES('MDD', 'LSI1', 'S1', 'Modèle de données', 'hjaudoin');
INSERT INTO `module` VALUES('PROGWEB', 'LSI1', 'S2', 'Programmation Web', NULL);
INSERT INTO `module` VALUES('RESIMREII', 'commun IMR1 et EII2', 'S1', 'Réseaux IMR1 et EII2', NULL);
INSERT INTO `module` VALUES('SAR', 'LSI3', 'S1', 'Systèmes et algorithmes répartis', NULL);
INSERT INTO `module` VALUES('SDD', 'LSI1', 'S2', 'Structures de données', NULL);
INSERT INTO `module` VALUES('UML', 'LSI2', 'S1', 'Méthode de conception UML/RUP', 'hjaudoin');
INSERT INTO `module` VALUES('UnixP', 'LSI1', 'S2', 'Unix programmation', NULL);
INSERT INTO `module` VALUES('UnixU', 'LSI1', 'S1', 'Unix utilisation', 'glecorve');
INSERT INTO `module` VALUES('XML', 'LSI2', 'S2', 'Langages XML et XSLT', 'vthion');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `services`
--
DROP VIEW IF EXISTS `services`;

DROP TABLE IF EXISTS `services`;

CREATE VIEW `services` AS select `enseignant`.`login` AS `login`,`enseignant`.`nom` AS `nom`,`enseignant`.`prenom` AS `prenom`,(`enseignant`.`statutaire` - ifnull(`decharge`.`decharge`,0)) AS `statutaire`,ifnull(sum(`contenu`.`hed`),0) AS `service` from ((`enseignant` left join `contenu` on((`contenu`.`enseignant` = `enseignant`.`login`))) left join `decharge` on((`enseignant`.`login` = `decharge`.`enseignant`))) where (`enseignant`.`actif` = 1) group by `enseignant`.`login`;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `contenu`
--
ALTER TABLE `contenu`
  ADD CONSTRAINT `FK_contenu_enseignant` FOREIGN KEY (`enseignant`) REFERENCES `enseignant` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_contenu_module` FOREIGN KEY (`module`) REFERENCES `module` (`ident`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `decharge`
--
ALTER TABLE `decharge`
  ADD CONSTRAINT `FK_decharge_enseignant` FOREIGN KEY (`enseignant`) REFERENCES `enseignant` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `FK_module_resp` FOREIGN KEY (`responsable`) REFERENCES `enseignant` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
