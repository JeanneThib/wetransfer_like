-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Lun 17 Décembre 2018 à 14:34
-- Version du serveur :  10.3.11-MariaDB-1:10.3.11+maria~bionic-log
-- Version de PHP :  7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_transfert`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(4) NOT NULL,
  `login` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`id`, `login`, `password`) VALUES
(1, 'yYquLShOyHnwMw52C/a2YA==', 'n4lAjRnx5Po2dBTQ9I2naw==');

-- --------------------------------------------------------

--
-- Structure de la table `file_download`
--

CREATE TABLE `file_download` (
  `id` int(4) NOT NULL,
  `download_date` date DEFAULT NULL,
  `extension` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_upload_id` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `file_upload`
--

CREATE TABLE `file_upload` (
  `id` int(4) NOT NULL,
  `name` varchar(110) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  `size` int(4) DEFAULT NULL,
  `extension` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `file_download`
--
ALTER TABLE `file_download`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `file_upload`
--
ALTER TABLE `file_upload`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `file_download`
--
ALTER TABLE `file_download`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `file_upload`
--
ALTER TABLE `file_upload`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
