-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 06 jan. 2021 à 07:51
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ppe3-slam`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `products_id`, `product_name`, `product_code`, `product_color`, `size`, `price`, `quantity`, `user_email`, `session_id`, `created_at`, `updated_at`) VALUES
(41, 31, 'House', 'multiple', 'White and Brown', '10*10', 20.00, 2, 'weshare@gmail.com', 'bKnMoW6lH0eA6ciYTU47tgeayw5CFUzBkjkBb3F5', '2018-12-06 17:17:37', '2018-12-06 17:17:37'),
(42, 34, 'Lenovo ThinkPad', 'multi-couleur', 'Black', '1', 10.00, 2, 'weshare@gmail.com', 'bKnMoW6lH0eA6ciYTU47tgeayw5CFUzBkjkBb3F5', '2018-12-06 17:18:26', '2018-12-06 17:18:26'),
(40, 30, 'Link House New LC2', 'multiple', 'Gray', 'Small', 10.00, 5, 'weshare@gmail.com', 'SFoV6rkDUv7y5F81nKOo5H3u0ERK3EYkcBQhUrcm', '2018-12-06 16:50:30', '2018-12-06 16:50:30'),
(39, 31, 'House', 'multiple', 'White and Brown', '5*20', 25.00, 4, 'weshare@gmail.com', 'SFoV6rkDUv7y5F81nKOo5H3u0ERK3EYkcBQhUrcm', '2018-12-06 16:49:50', '2018-12-06 16:49:50'),
(36, 33, 'Cole Haan', 'Multiple', 'Brown', '25', 12.00, 1, 'weshare@gmail.com', 'OrHCEFHcACdGNXet3m2jVbzlJS0VybkkeknXXilx', '2018-12-06 01:18:10', '2018-12-06 01:18:10'),
(37, 32, 'Vionic Shoes Brand', 'Multiple', 'All Colors', '30', 20.00, 1, 'weshare@gmail.com', 'OrHCEFHcACdGNXet3m2jVbzlJS0VybkkeknXXilx', '2018-12-06 01:30:33', '2018-12-06 01:30:33'),
(43, 35, 'Cloths', 'Multiple', 'Black', 'S', 2.00, 5, 'weshare@gmail.com', 'bKnMoW6lH0eA6ciYTU47tgeayw5CFUzBkjkBb3F5', '2018-12-06 17:18:31', '2018-12-06 17:18:31'),
(49, 31, 'FeuillesA4', 'SKU-House1', 'mutli-couleur', '5*20', 25.00, 1, 'ppe3.ifide@gmail.com', '0sRbQ5tXqQD5w8M3g88Vn0boeN2zUoHPtbuHHRcB', '2021-01-05 19:27:21', '2021-01-05 19:27:21'),
(50, 32, 'chaises', 'SKU-Vionic1', 'multi-couleur', 'Meduim', 10.00, 1, 'ppe3.ifide@gmail.com', '0sRbQ5tXqQD5w8M3g88Vn0boeN2zUoHPtbuHHRcB', '2021-01-05 19:36:44', '2021-01-05 19:36:44');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `description`, `url`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(12, 0, 'Tech', 'Tech Categorie', 'http://ppe3.ifide.com', 1, NULL, '2020-12-05 23:00:00', '2020-12-16 02:00:00'),
(10, 0, 'Papiterie', 'Papiterie Categorie', 'http://ppe3.ifide.com', 1, NULL, '2020-12-02 23:00:00', '2020-12-16 02:05:53'),
(11, 0, 'Mobiliers', 'Mobiliers Categorie', 'http://ppe3.ifide.com', 1, NULL, '2020-12-02 23:00:00', '2020-12-14 19:30:48'),
(13, 0, ' Mat-Bureau', 'Bureau Categorie', 'http://ppe3.ifide.com', 1, NULL, '2020-12-02 23:00:00', '2020-12-16 02:05:43'),
(14, 12, 'Ancre', 'Ancre-imprimante', 'http://ppe3.ifide.com', 1, NULL, '2020-12-02 23:00:00', '2020-12-14 00:52:37'),
(15, 12, 'Unité centrale', 'Besoin d\'une unité centrale pour votre ordinateur ? Nous vous proposons une sélection d\'unités centrales qui répondront forcément à vos besoins', 'http://ppe3.ifide.com', 1, NULL, '2020-12-02 23:00:00', '2020-12-13 20:17:28'),
(16, 13, 'Pot crayon', 'Gardez vos crayons et stylos à porter de main', 'http://ppe3.ifide.com', 1, NULL, '2020-12-02 23:00:00', '2020-12-14 00:55:30'),
(17, 11, 'Meubles', 'Tables-chaises', 'http://ppe3.ifide.com', 1, NULL, '2020-12-02 23:00:00', '2020-12-14 19:30:23');

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=298 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`, `created_at`, `updated_at`) VALUES
(2, 'CP', 'Comptabilité', NULL, NULL),
(3, 'IF', 'Informatique', NULL, NULL),
(4, 'RH', 'RH', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `NomDepartement` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2014_10_12_000000_create_users_table', 2),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(8, '2018_10_20_040609_create_categories_table', 3),
(9, '2018_10_24_075802_create_products_table', 4),
(10, '2018_11_08_024109_create_product_att_table', 5),
(11, '2018_11_20_055123_create_tblgallery_table', 6),
(12, '2018_11_26_070031_create_cart_table', 7),
(13, '2018_11_28_072535_create_coupons_table', 8),
(15, '2018_12_01_042342_create_countries_table', 10),
(19, '2018_12_03_043804_add_more_fields_to_users_table', 14),
(17, '2018_12_03_093548_create_delivery_address_table', 12),
(18, '2018_12_05_024718_create_orders_table', 13);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categories_id` int(11) NOT NULL,
  `p_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `categories_id`, `p_name`, `p_code`, `p_color`, `description`, `image`, `created_at`, `updated_at`) VALUES
(28, 12, 'Imprimante', '12152', 'blanc', 'Le traceur Canon imagePROGRAF PRO-4100S est une imprimante grand format permettant de réaliser des tirages graphiques et de posters. Assurant une ...', '1607891799-imprimante.jpg', '2020-12-05 19:35:12', '2020-12-13 19:37:00'),
(27, 15, 'Unité centrale bureau', '785', 'milti-couleurs', 'Besoin d\'une&nbsp;unité centrale&nbsp;pour votre ordinateur ? Nous vous proposons une sélection d\'unités centrales&nbsp;qui répondront forcément à vos besoins', '1607894713-unite-centrale-bureau.jpg', '2020-12-05 19:30:25', '2020-12-13 20:25:14'),
(29, 12, 'ordinateurs', '1252', 'gris', 'Pc avec unité central', '1607887984-ordinateurs.jpg', '2020-12-05 19:38:44', '2020-12-13 18:33:04'),
(30, 12, 'souris', '252', 'gris', 'Souris souple et rapide&nbsp;', '1607887905-souris.jpg', '2020-12-05 19:42:22', '2020-12-13 18:31:46'),
(31, 10, 'FeuillesA4', '5214', 'mutli-couleur', 'Multi-coleur', '1607887771-feuillesa4.jpg', '2020-12-05 19:47:10', '2020-12-13 18:29:32'),
(32, 11, 'chaises', '5265', 'multi-couleur', 'tables de bureau', '1607887696-chaises.jpg', '2020-12-05 19:50:07', '2020-12-13 18:28:16'),
(33, 12, 'claviers', '75659', 'noir', 'Alors, joueur, travailleur ou les deux à la fois, quel&nbsp;clavier&nbsp;est fait pour vous&nbsp;', '1607887649-claviers.png', '2020-12-05 19:55:03', '2020-12-13 21:02:28'),
(34, 13, 'stylos', '1252', 'bleu', 'Stylos de toutes les couleurs', '1607887579-stylos.jpg', '2020-12-05 20:02:12', '2020-12-13 19:44:06'),
(36, 12, 'Classeurs', '7854', 'noir', 'classeurs', '1609196436-classeurs.jpg', '2020-12-28 22:00:40', '2020-12-28 22:00:40'),
(37, 12, 'disque-dur', '7854', 'noir', 'disque dur externe', '1609196624-disque-dur.jpg', '2020-12-28 22:03:44', '2020-12-28 22:03:44');

-- --------------------------------------------------------

--
-- Structure de la table `product_att`
--

DROP TABLE IF EXISTS `product_att`;
CREATE TABLE IF NOT EXISTS `product_att` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_att`
--

INSERT INTO `product_att` (`id`, `products_id`, `sku`, `size`, `price`, `stock`, `created_at`, `updated_at`) VALUES
(14, 34, 'SKU-Lenovo X1', 'L', 10.00, 1, '2018-12-05 19:08:43', '2018-12-05 19:08:43'),
(13, 35, 'SKU-Red', 'S', 2.00, 1, '2018-12-05 19:08:08', '2018-12-05 19:08:08'),
(12, 35, 'SKU-White', 'L', 6.00, 2, '2018-12-05 19:07:42', '2018-12-05 19:07:42'),
(11, 35, 'SKU-Black', 'M', 5.00, 1, '2018-12-05 19:07:11', '2018-12-05 19:07:11'),
(15, 34, 'SKU-Carbon', 'M', 4.00, 1, '2018-12-05 19:09:05', '2018-12-05 19:09:05'),
(16, 33, 'SKU-Haan1', '25', 12.00, 1, '2018-12-05 19:09:45', '2018-12-05 19:09:45'),
(17, 33, 'SKU-Haan2', '22', 10.00, 1, '2018-12-05 19:09:58', '2018-12-05 19:09:58'),
(18, 33, 'SKU-Haan3', '19', 2.00, 1, '2018-12-05 19:10:16', '2018-12-05 19:10:16'),
(19, 32, 'SKU-Vionic1', 'Meduim', 10.00, 1, '2018-12-05 19:11:02', '2018-12-05 19:11:02'),
(20, 32, 'SKU-Vionic2', 'short', 15.00, 1, '2018-12-05 19:11:24', '2018-12-05 19:11:24'),
(21, 32, 'SKU-Vionic3', 'long', 20.00, 1, '2018-12-05 19:11:38', '2018-12-05 19:11:38'),
(22, 31, 'SKU-House1', '5*20', 25.00, 1, '2018-12-05 19:12:13', '2018-12-05 19:12:13'),
(23, 31, 'SKU-House2', '10*10', 20.00, 1, '2018-12-05 19:12:30', '2018-12-05 19:12:30'),
(24, 31, 'SKU-House3', '20*20', 20.00, 1, '2018-12-05 19:12:46', '2018-12-05 19:12:46'),
(25, 30, 'SKU-Link House1', 'Small', 10.00, 1, '2018-12-05 19:13:06', '2018-12-05 19:13:06'),
(26, 30, 'SKU-House2', 'Medium', 15.00, 1, '2018-12-05 19:13:23', '2018-12-05 19:13:23'),
(27, 30, 'SKU-House3', 'Large', 5.00, 1, '2018-12-05 19:14:55', '2018-12-05 19:14:55'),
(28, 29, 'SKU-Prius1', 'One ', 12.00, 1, '2018-12-05 19:15:43', '2018-12-05 19:15:43'),
(29, 28, 'SKU-Lexus Red', 'Red', 12.00, 1, '2018-12-05 19:16:28', '2018-12-05 19:16:28'),
(30, 28, 'SKU-Lexus2', 'Black', 11.00, 1, '2018-12-05 19:16:48', '2018-12-05 19:16:48'),
(31, 28, 'SKU-Lexus3', 'White', 12.00, 1, '2018-12-05 19:17:02', '2018-12-05 19:17:02'),
(32, 27, 'SKU-Hilander', ' Black', 50.00, 1, '2018-12-05 19:17:35', '2018-12-05 19:17:35'),
(33, 27, 'SKU-Hilander1', 'White', 20.00, 1, '2018-12-05 19:17:46', '2018-12-05 19:17:46'),
(34, 27, 'SKU-Hilande3', ' Red', 20.00, 1, '2018-12-05 19:18:01', '2018-12-05 19:18:01');

-- --------------------------------------------------------

--
-- Structure de la table `tblgallery`
--

DROP TABLE IF EXISTS `tblgallery`;
CREATE TABLE IF NOT EXISTS `tblgallery` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tblgallery`
--

INSERT INTO `tblgallery` (`id`, `products_id`, `image`, `created_at`, `updated_at`) VALUES
(56, 28, '288781607979272.jpg', '2020-12-14 19:54:39', '2020-12-14 19:54:39'),
(55, 30, '4240851607896535.jpg', '2020-12-13 20:55:35', '2020-12-13 20:55:35'),
(54, 30, '38711607896524.jpg', '2020-12-13 20:55:24', '2020-12-13 20:55:24'),
(14, 29, '5146071544063935.JPG', '2020-12-05 19:38:55', '2020-12-05 19:38:55'),
(15, 29, '762811544063935.jpg', '2020-12-05 19:38:55', '2020-12-05 19:38:55'),
(16, 29, '3716041544063935.jpg', '2020-12-05 19:38:56', '2020-12-05 19:38:56'),
(17, 30, '6832831544064156.jpg', '2020-12-05 19:42:37', '2020-12-05 19:42:37'),
(18, 30, '1655391544064157.jpg', '2020-12-05 19:42:37', '2020-12-05 19:42:37'),
(19, 30, '4693601544064157.jpg', '2020-12-05 19:42:37', '2020-12-05 19:42:37'),
(52, 27, '2810551607894731.jpg', '2020-12-13 20:25:32', '2020-12-13 20:25:32'),
(21, 31, '8167501544064441.jpg', '2020-12-05 19:47:22', '2020-12-05 19:47:22'),
(22, 31, '3887071544064442.jpg', '2020-12-05 19:47:22', '2020-12-05 19:47:22'),
(49, 31, '4452101607892694.jpg', '2020-12-13 19:51:34', '2020-12-13 19:51:34'),
(47, 32, '2268161607892518.jpg', '2020-12-13 19:48:40', '2020-12-13 19:48:40'),
(48, 32, '7010591607892533.jpg', '2020-12-13 19:48:54', '2020-12-13 19:48:54'),
(45, 33, '6726181607892453.jpg', '2020-12-13 19:47:33', '2020-12-13 19:47:33'),
(46, 33, '2467121607892465.jpg', '2020-12-13 19:47:46', '2020-12-13 19:47:46'),
(44, 34, '4886061607892397.jpg', '2020-12-13 19:46:38', '2020-12-13 19:46:38'),
(42, 34, '1381801607892373.png', '2020-12-13 19:46:14', '2020-12-13 19:46:14'),
(43, 34, '4591421607892384.jpg', '2020-12-13 19:46:24', '2020-12-13 19:46:24'),
(50, 31, '5566471607892714.jpg', '2020-12-13 19:51:54', '2020-12-13 19:51:54'),
(40, 35, '226281607892073.jpg', '2020-12-13 19:41:13', '2020-12-13 19:41:13'),
(39, 35, '46911607892072.jpg', '2020-12-13 19:41:13', '2020-12-13 19:41:13'),
(38, 35, '792791607892039.jpg', '2020-12-13 19:40:41', '2020-12-13 19:40:41'),
(51, 31, '9183111607892714.jpg', '2020-12-13 19:51:55', '2020-12-13 19:51:55'),
(53, 27, '6774311607894743.jpg', '2020-12-13 20:25:43', '2020-12-13 20:25:43'),
(57, 28, '4840941607979703.jpeg', '2020-12-14 20:01:44', '2020-12-14 20:01:44'),
(58, 28, '9146191607979704.jpg', '2020-12-14 20:01:44', '2020-12-14 20:01:44');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` tinyint(4) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `admin`, `remember_token`, `created_at`, `updated_at`, `address`, `city`, `state`, `country`, `pincode`, `mobile`) VALUES
(7, 'admin', 'Admin@admin.com', NULL, '$2y$10$116m/C5SjcQxe.QWqEljdeRB0HnYXOMdfzGJctSjKatAA4AKZHNVi', 1, 'laqsQnzLBxYOkxr2vXwuXflSARIhJldka4OFriPRykKDb4q7qXzIsVibagub', '2020-12-22 14:58:10', '2020-12-22 14:58:10', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Mamadou', 'utilisateur@utilisateur.com', NULL, '$2y$10$UQ3N4B66kv2HYo.DuJn9leMHG3O3lpuFxnbnyp5pLa33xmJVoG.ry', NULL, 'oT0YKFyx7bypYoFsVWcTedTVkkywoWWZrFQu3EbugL1YHynWRT4G3NgMOIbt', '2020-12-13 17:45:59', '2020-12-13 17:45:59', NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
