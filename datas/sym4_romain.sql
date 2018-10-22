-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 21 oct. 2018 à 19:13
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données :  `sym4_romain`
--

CREATE DATABASE IF NOT EXISTS `sym4_romain` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sym4_romain`;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `idarticles` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `thetitle` varchar(180) NOT NULL,
  `thetxt` text NOT NULL,
  `thedate` datetime DEFAULT CURRENT_TIMESTAMP,
  `auteurs_idauteurs` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`idarticles`),
  KEY `fk_articles_auteurs_idx` (`auteurs_idauteurs`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`idarticles`, `thetitle`, `thetxt`, `thedate`, `auteurs_idauteurs`) VALUES
(1, 'Le Platonisme', 'Le platonisme est une théorie philosophique selon laquelle il existe des entités intelligibles en soi, dont le contenu est indépendant de la contingence de l\'expérience sensible.\r\n\r\ne platonisme est une théorie philosophique selon laquelle il existe des entités intelligibles en soi, dont le contenu est indépendant de la contingence de l\'expérience sensible. Ces entités, suivant la version du platonisme dont on parle, peuvent être les concepts (les Idées généralement, comme chez Plotin), les nombres (platonisme mathématique), ou encore les valeurs logiques (dans le logicisme de Frege par exemple). \r\n\r\nCette théorie est une des réponses envisageables, avec le nominalisme et le conceptualisme (Pierre Abélard), à la question du statut ontologique des concepts à valeur cognitive (idées, nombres ou contenus propositionnels).', '2018-10-21 21:05:09', 2),
(2, 'La Renaissance', 'La Renaissance est une période historique qui eut comme origine la Renaissance italienne : une Pré-Renaissance se produisit dans plusieurs villes d\'Italie dès le XIVe siècle, se propagea au XVe siècle dans la plus grande partie de l\'Italie,...\r\n\r\na Renaissance est une période historique qui eut comme origine la Renaissance italienne : une Pré-Renaissance se produisit dans plusieurs villes d\'Italie dès le XIVe siècle (Trecento), se propagea au XVe siècle dans la plus grande partie de l\'Italie, en Espagne, dans certaines enclaves d\'Europe du Nord et d\'Allemagne, sous la forme de ce qu\'on nomme la première Renaissance (Quattrocento), puis gagna la totalité de l\'Europe au XVIe siècle (Cinquecento).\r\n\r\nDans le courant du XVe et au XVIe siècle, ce mouvement permit à l\'Europe de se lancer dans des expéditions maritimes d\'envergure mondiale, connues sous le nom de grandes découvertes.\r\n\r\nLa Renaissance s\'accompagna aussi d\'un ensemble de réformes religieuses.\r\n\r\nSelon l\'historien anglais John Hale, ce fut à cette époque que le mot Europe entra dans le langage courant et fut pourvu d\'un cadre de référence solidement appuyé sur des cartes et d\'un ensemble d\'images affirmant son identité visuelle et culturelle.\r\n\r\nLa découpe historique de cette époque charnière entre l\'époque médiévale et l\'époque moderne est sujette à un débat interprétatif entre historiens et historiennes de l\'art. Certains parlent d\'une Renaissance du XIIe siècle. En réalité, l\'emploi même de Renaissance découle d\'une vision de l\'Histoire visant à lui donner un sens, ce qui correspond au régime de pensée de l\'idéalisme allemand du XIXe siècle, surtout au travers des concepts de Hegel. Cette manière de percevoir l\'Histoire étant elle-même controversée, le lecteur se reportera à l\'article indiqué la Renaissance du XIIe siècle eut effectivement lieu, elle fut cependant interrompue par une période particulièrement complexe en Europe : le XIVe siècle vit la peste noire décimer plus du tiers de la population européenne. Les conflits de la guerre de Cent Ans expliquent que ce qu\'on nomme couramment la Renaissance (objet de cet article) commença bien plus tôt en Italie que dans le reste de l\'Europe, en France surtout.', '2018-10-21 21:11:57', 1);

-- --------------------------------------------------------

--
-- Structure de la table `articles_has_sections`
--

DROP TABLE IF EXISTS `articles_has_sections`;
CREATE TABLE IF NOT EXISTS `articles_has_sections` (
  `articles_idarticles` int(10) UNSIGNED NOT NULL,
  `sections_idsections` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`articles_idarticles`,`sections_idsections`),
  KEY `fk_articles_has_sections_sections1_idx` (`sections_idsections`),
  KEY `fk_articles_has_sections_articles1_idx` (`articles_idarticles`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles_has_sections`
--

INSERT INTO `articles_has_sections` (`articles_idarticles`, `sections_idsections`) VALUES
(2, 1),
(2, 3),
(2, 4),
(1, 6),
(2, 6);

-- --------------------------------------------------------

--
-- Structure de la table `auteurs`
--

DROP TABLE IF EXISTS `auteurs`;
CREATE TABLE IF NOT EXISTS `auteurs` (
  `idauteurs` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `thelog` varchar(60) NOT NULL,
  `thepwd` varchar(120) NOT NULL,
  `thename` varchar(160) NOT NULL,
  PRIMARY KEY (`idauteurs`),
  UNIQUE KEY `lenom_UNIQUE` (`thelog`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `auteurs`
--

INSERT INTO `auteurs` (`idauteurs`, `thelog`, `thepwd`, `thename`) VALUES
(1, 'Thierry', 'Thierry', 'Jacques Thierry'),
(2, 'Stéphanie', 'Stéphanie', 'Dupuis Stéphanie');

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `idsections` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `thesection` varchar(120) NOT NULL,
  `thedesc` varchar(500) NOT NULL,
  PRIMARY KEY (`idsections`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sections`
--

INSERT INTO `sections` (`idsections`, `thesection`, `thedesc`) VALUES
(1, 'Athéisme', 'L\'athéisme est une attitude ou une doctrine qui ne conçoit pas l\'existence ou affirme l\'inexistence de quelque dieu, divinité ou entité surnaturelle que ce soit, contrairement, par exemple, au déisme, au théisme...'),
(2, 'Empirisme', 'L\'empirisme sert à désigner un ensemble de théories philosophiques qui font de l\'expérience sensible l\'origine de toute connaissance valide et de tout plaisir esthétique.'),
(3, 'Hédonisme', 'L\'hédonisme plaisir, et du verbe ?d?µa? se réjouir, selon lequel sont constitués les adjectifs ?d??, ?de?a et ?d? ; hédus, hédeïa, hédu ; doux, agréable ou aimable) est une doctrine philosophique selon laquelle la recherche du plaisir...'),
(4, 'Idéalisme', 'On nomme idéalisme toute prééminence donnée à des formes abstraites ou représentations mentales sur la réalité, qu\'elle soit expérimentée ou qu\'elle soit inconnaissable ; ces formes étant comme l\'essence des caractères certains de la réalité,...'),
(5, 'Matérialisme', 'Le matérialisme est une philosophie qui affirme que la substance du monde est de nature matérielle.'),
(6, 'Rationalisme', 'Le rationalisme est la doctrine qui pose la raison discursive comme seule source envisageable de toute connaissance réelle.'),
(7, 'Réalisme', 'Le terme réalisme peut se rapporter à plusieurs choses ...');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk_articles_auteurs` FOREIGN KEY (`auteurs_idauteurs`) REFERENCES `auteurs` (`idauteurs`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `articles_has_sections`
--
ALTER TABLE `articles_has_sections`
  ADD CONSTRAINT `fk_articles_has_sections_articles1` FOREIGN KEY (`articles_idarticles`) REFERENCES `articles` (`idarticles`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_articles_has_sections_sections1` FOREIGN KEY (`sections_idsections`) REFERENCES `sections` (`idsections`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;