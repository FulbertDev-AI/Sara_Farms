-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 02 juin 2026 à 20:05
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sara_farms`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sujet` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lu` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `financial_records`
--

DROP TABLE IF EXISTS `financial_records`;
CREATE TABLE IF NOT EXISTS `financial_records` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_transaction` enum('revenu','depense') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `categorie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date_transaction` date NOT NULL,
  `reference_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `financial_records`
--

INSERT INTO `financial_records` (`id`, `type_transaction`, `montant`, `categorie`, `description`, `date_transaction`, `reference_id`, `created_at`) VALUES
(1, 'depense', 750000.00, 'Achat Intrants', 'Stock ajouté', '2026-05-31', 1, '2026-05-31 20:08:43'),
(2, 'revenu', 1950.00, 'Vente', 'Commande #1', '2026-06-01', 1, '2026-06-01 01:39:41'),
(3, 'revenu', 1200.00, 'Vente', 'Commande #4', '2026-06-01', 4, '2026-06-01 19:20:46'),
(4, 'revenu', 1500.00, 'Vente', 'Commande #5', '2026-06-02', 5, '2026-06-02 14:00:14'),
(5, 'depense', 3825.00, 'Achat Intrants', 'Stock ajouté', '2026-06-02', 3, '2026-06-02 14:03:41'),
(6, 'revenu', 50000.00, 'Vente', 'Test vente produits', '2026-06-02', 1, '2026-06-02 19:36:47'),
(7, 'depense', 15000.00, 'Achat Intrants', 'Achat graines', '2026-06-02', NULL, '2026-06-02 19:36:47'),
(8, 'revenu', 50000.00, 'Vente', 'Test vente produits', '2026-06-02', 1, '2026-06-02 19:40:11'),
(9, 'depense', 15000.00, 'Achat Intrants', 'Achat graines', '2026-06-02', NULL, '2026-06-02 19:40:11');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('en_attente','validee','rejetee') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'en_attente',
  `payment_method` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'livraison',
  `mobile_money_reference` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_status` enum('pending','completed','failed') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `motif_rejet` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `payment_method`, `mobile_money_reference`, `payment_status`, `motif_rejet`, `created_at`, `updated_at`) VALUES
(1, 1, 1950.00, 'validee', 'mobile_money', NULL, 'pending', NULL, '2026-06-01 01:39:09', '2026-06-01 01:39:41'),
(2, 1, 1200.00, 'rejetee', 'livraison', NULL, 'pending', 'Produit indisponible, rupture de stock', '2026-06-01 01:41:54', '2026-06-01 01:42:36'),
(3, 2, 1500.00, 'en_attente', 'livraison', NULL, 'pending', NULL, '2026-06-01 09:31:59', '2026-06-01 09:31:59'),
(4, 2, 1200.00, 'validee', 'livraison', NULL, 'pending', NULL, '2026-06-01 19:20:02', '2026-06-01 19:20:46'),
(5, 2, 1500.00, 'validee', 'mobile_money', NULL, 'pending', NULL, '2026-06-02 13:55:57', '2026-06-02 14:00:14'),
(6, 2, 1500.00, 'rejetee', 'livraison', NULL, 'pending', 'Rupture de fromage', '2026-06-02 13:56:14', '2026-06-02 14:00:05'),
(7, 4, 12500.00, 'validee', 'livraison', NULL, 'pending', NULL, '2026-06-02 19:36:46', '2026-06-02 19:36:46'),
(8, 4, 5000.00, 'rejetee', 'mobile_money', NULL, 'pending', 'Stock insuffisant', '2026-06-02 19:36:46', '2026-06-02 19:36:46'),
(9, 4, 12500.00, 'en_attente', 'livraison', NULL, 'pending', NULL, '2026-06-02 19:36:49', '2026-06-02 19:36:49'),
(10, 6, 12500.00, 'validee', 'livraison', NULL, 'pending', NULL, '2026-06-02 19:40:11', '2026-06-02 19:40:11'),
(11, 6, 5000.00, 'rejetee', 'mobile_money', NULL, 'pending', 'Stock insuffisant', '2026-06-02 19:40:11', '2026-06-02 19:40:11'),
(12, 6, 12500.00, 'en_attente', 'livraison', NULL, 'pending', NULL, '2026-06-02 19:40:12', '2026-06-02 19:40:12');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantite` int NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantite`, `prix_unitaire`) VALUES
(1, 1, 4, 1, 1500.00),
(2, 1, 2, 1, 450.00),
(3, 2, 3, 1, 1200.00),
(4, 3, 4, 1, 1500.00),
(5, 4, 3, 1, 1200.00),
(6, 5, 4, 1, 1500.00),
(7, 6, 4, 1, 1500.00),
(8, 7, 10, 2, 4000.00),
(9, 7, 9, 3, 1500.00),
(10, 9, 10, 2, 4000.00),
(11, 9, 9, 3, 1500.00),
(12, 10, 10, 2, 4000.00),
(13, 10, 9, 3, 1500.00),
(14, 12, 10, 2, 4000.00),
(15, 12, 9, 3, 1500.00);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `prix` decimal(10,2) NOT NULL,
  `categorie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock_disponible` int DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'default.jpg',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `nom`, `description`, `prix`, `categorie`, `stock_disponible`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Banane', 'Des bananes bio sorties directement de la ferme', 400.00, '', 12, '6a1c8d0ada044_licence-en-topographie-plan.png', 0, '2026-05-31 19:33:31', '2026-05-31 19:33:54'),
(2, 'Banane', 'Bananes locales mûries naturellement sur pied, sélectionnées pour leur goût sucré et leur fraîcheur.\r\nUnité de vente : Régime (ou Main pour le détail)', 3000.00, '', 10, '6a1f014a5411a_banane.jpg', 1, '2026-05-31 19:34:53', '2026-06-02 16:14:02'),
(3, 'Tomates', 'Tomates locales fermes et cueillies à maturité. Idéales pour les salades et la cuisine quotidienne.\r\nUnité de vente : kg', 500.00, '', 54, '6a1efc4701689_tomates.jpg', 1, '2026-05-31 20:03:55', '2026-06-02 15:53:54'),
(4, 'Fromage local traditionnel (Wagashi)', 'Fromage de lait frais de vache, fabriqué de façon artisanale et sans conservateurs.\r\nUnité de vente : Bloc / Unité', 1000.00, '', 32, '6a1f031fe92f9_fromage.webp', 1, '2026-05-31 20:05:17', '2026-06-02 16:21:51'),
(5, 'Alvéole d\'œufs frais', 'Œufs frais de ferme, calibrés et triés quotidiennement. Riches en nutriments.\r\nUnité de vente : Alvéole (30 œufs)', 3000.00, '', 50, '6a1f00e0cbde9_this-salted-egg-boiled-very-260nw-2575115715.webp', 1, '2026-06-02 15:59:40', '2026-06-02 16:12:16'),
(6, 'Maïs grain local', 'Maïs séché naturellement, trié et idéal pour la consommation ou l\'élevage.\r\nUnité de vente : Sac (50 kg)', 15000.00, '', 189, '6a1f01c06b9f1_mais.jpg', 1, '2026-06-02 16:00:39', '2026-06-02 16:16:00'),
(7, 'Volaille', 'Poulets élevés en plein air, nourris aux grains de la ferme et prêts pour la consommation.\r\nUnité de vente : Unité', 3500.00, '', 2000, '6a1f0208e2c1c_volaille.jpg', 1, '2026-06-02 16:02:09', '2026-06-02 16:17:12'),
(8, 'Légumes', 'Assortiment de légumes frais récoltés le matin même : carottes, poivrons et choux.\r\nUnité de vente : Panier', 5000.00, '', 39, '6a1f02409a6f5_legume.jpg', 1, '2026-06-02 16:03:31', '2026-06-02 16:18:08'),
(9, 'Semences', 'Semences locales à haut rendement, certifiées et adaptées au climat ouest-africain.\r\nUnité de vente : kg', 1500.00, '', 78, '6a1f028945216_semences.jpg', 1, '2026-06-02 16:06:43', '2026-06-02 16:19:21'),
(10, 'Miel pur naturel', 'Miel brut filtré à froid, issu directement des ruches éco-responsables de notre ferme.\r\nUnité de vente : Litre', 4000.00, '', 90, '6a1f02637146a_miel.jpg', 1, '2026-06-02 16:09:01', '2026-06-02 16:18:43'),
(11, 'Tomates Premium Test (Modifiée)', 'Tomates de qualité supérieure - MODIFIED', 6000.00, 'Légumes Bio', 65, 'tomates_test_mod.jpg', 0, '2026-06-02 19:36:45', '2026-06-02 19:36:45'),
(12, 'Tomates Premium Test (Modifiée)', 'Tomates de qualité supérieure - MODIFIED', 6000.00, 'Légumes Bio', 65, 'tomates_test_mod.jpg', 0, '2026-06-02 19:40:10', '2026-06-02 19:40:10');

-- --------------------------------------------------------

--
-- Structure de la table `raw_materials`
--

DROP TABLE IF EXISTS `raw_materials`;
CREATE TABLE IF NOT EXISTS `raw_materials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `categorie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock_actuel` int DEFAULT '0',
  `seuil_alerte` int DEFAULT '10',
  `cout_moyen` decimal(10,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `raw_materials`
--

INSERT INTO `raw_materials` (`id`, `nom`, `categorie`, `stock_actuel`, `seuil_alerte`, `cout_moyen`, `created_at`) VALUES
(1, 'Angrais chimique', '', 90, 10, 0.00, '2026-05-31 20:08:11'),
(2, 'Grains de tomate', '', 29, 10, 0.00, '2026-05-31 20:09:14'),
(3, 'Poussins de race', '', 3, 10, 0.00, '2026-05-31 20:13:37'),
(4, 'Graines de Maïs Test', 'Semences', 100, 20, 0.00, '2026-06-02 19:36:46'),
(5, 'Graines de Maïs Test', 'Semences', 100, 20, 0.00, '2026-06-02 19:40:11');

-- --------------------------------------------------------

--
-- Structure de la table `stock_movements`
--

DROP TABLE IF EXISTS `stock_movements`;
CREATE TABLE IF NOT EXISTS `stock_movements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_element` enum('produit','intrant') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `element_id` int NOT NULL,
  `type_mouvement` enum('entree','sortie','ajustement','consommation') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quantite` int NOT NULL,
  `cout_unitaire` decimal(10,2) DEFAULT '0.00',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date_mouvement` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `type_element`, `element_id`, `type_mouvement`, `quantite`, `cout_unitaire`, `description`, `date_mouvement`) VALUES
(1, 'intrant', 1, 'entree', 50, 15000.00, 'Achat intrants', '2026-05-31 20:08:43'),
(2, 'produit', 4, 'sortie', 1, 1500.00, 'Vente commande #1', '2026-06-01 01:39:41'),
(3, 'produit', 2, 'sortie', 1, 450.00, 'Vente commande #1', '2026-06-01 01:39:41'),
(4, 'produit', 3, 'sortie', 1, 1200.00, 'Vente commande #4', '2026-06-01 19:20:46'),
(5, 'produit', 4, 'sortie', 1, 1500.00, 'Vente commande #5', '2026-06-02 14:00:14'),
(6, 'intrant', 3, 'entree', 3, 1275.00, 'Achat intrants', '2026-06-02 14:03:41'),
(7, 'produit', 1, 'sortie', 10, 5000.00, 'Vente test', '2026-06-02 19:36:47'),
(8, 'produit', 1, 'sortie', 10, 5000.00, 'Vente test', '2026-06-02 19:40:11');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('client','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'client',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `telephone`, `role`, `created_at`) VALUES
(1, 'Admin', 'Sara', 'admin@sarafarms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'admin', '2026-05-24 03:10:38'),
(2, 'Abalo', 'Ama', 'abalo@gmail.com', '$2y$10$VF1gpH891ZMP7unjcEgwqO.LXeK9kwM9oVMCQgJi/sTJkH5IoJaDW', '92503877', 'client', '2026-05-31 19:00:58'),
(3, 'Client', 'Test', 'client@test.com', '$2y$10$A5wjrCXv6I4EX4DnCF.tv.9bR4ml6zLdU9mQ1RJ9bJf4gTT8ENXlS', '90000000', 'client', '2026-06-02 16:59:31'),
(4, 'Test', 'User', 'test_1780429003@sarafarms.com', '$2y$10$KXC4KnrB6/PH6QGL0Lc8u.U07LKgszq5xPVi.c95mqXAm7tMDa.im', '0123456789', 'client', '2026-06-02 19:36:44'),
(5, 'Client', 'Test', 'client_1780429008@test.com', '$2y$10$YlC3kno24DdL8KsEHnS1HuSoj1M3OiP4NMgA5e8PoedwuMOMqOI7O', '0123456789', 'client', '2026-06-02 19:36:48'),
(6, 'Test', 'User', 'test_1780429210@sarafarms.com', '$2y$10$N7ZNJf/5fpQKsRQ3X1bwSu7cmpWD7L.sZ62cOKU6GRs46ettPFQj2', '0123456789', 'client', '2026-06-02 19:40:10'),
(7, 'Client', 'Test', 'client_1780429211@test.com', '$2y$10$S1SL.lfLX3JPn4baESTSFeJZPgRU65V1DJTBbiogH9WDgNDdp8lHq', '0123456789', 'client', '2026-06-02 19:40:12');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
