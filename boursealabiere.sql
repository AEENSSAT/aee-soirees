-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 02 Mai 2017 à 17:24
-- Version du serveur :  5.5.54-0+deb8u1
-- Version de PHP :  5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `boursealabiere`
--

-- --------------------------------------------------------

--
-- Structure de la table `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` varchar(255) NOT NULL,
  `textValue` varchar(255) DEFAULT NULL,
  `booleanValue` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `configs`
--

INSERT INTO `configs` (`id`, `textValue`, `booleanValue`) VALUES
('priceDown', NULL, 1),
('priceUp', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `drinks`
--

CREATE TABLE IF NOT EXISTS `drinks` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `currentPrice` int(11) NOT NULL,
  `previousPrice` int(11) NOT NULL,
  `history` text NOT NULL,
  `isEnable` tinyint(1) NOT NULL,
  `salesCount` int(11) NOT NULL,
  `estimatedRevenue` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `drinks`
--

INSERT INTO `drinks` (`id`, `name`, `currentPrice`, `previousPrice`, `history`, `isEnable`, `salesCount`, `estimatedRevenue`) VALUES
(1, 'Biere1', 10, 8, '["5","15","20","2","25","20","2","2","2","10","7","2","8"]', 1, 31, 287),
(2, 'Biere2', 3, 8, '["3","20","30","10","2","100","10","8"]', 1, 20, 164);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `drinks`
--
ALTER TABLE `drinks`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `drinks`
--
ALTER TABLE `drinks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
