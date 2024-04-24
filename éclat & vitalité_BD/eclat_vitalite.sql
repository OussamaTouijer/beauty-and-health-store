-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 24 avr. 2024 à 00:50
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `eclat_vitalite`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) DEFAULT NULL,
  `description` text,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `libelle`, `description`, `date_creation`, `date_modification`) VALUES
(1, 'Soins du visage', 'Produits pour nettoyer, hydrater et protéger la peau du visage.', '2024-04-24 00:38:07', '2024-04-24 00:38:07'),
(2, 'Maquillage', 'Produits cosmétiques pour embellir le visage, les yeux, les lèvres, etc.', '2024-04-08 15:00:00', NULL),
(3, 'Fond de teint liquide longue tenue', 'Obtenez un teint parfait avec notre fond de teint liquide longue tenue, disponible dans plusieurs nuances.', '2024-04-08 15:00:00', '2024-04-15 18:44:38'),
(4, 'Produits de bain et de douche', 'Produits pour l\'hygiène corporelle, tels que les gels douche et les savons.', '2024-04-08 15:00:00', NULL),
(5, 'Soins du corps', 'Produits pour hydrater et prendre soin de la peau du corps', '2024-04-08 15:00:00', '2024-04-14 16:35:44'),
(6, 'Parfums et fragrances', 'Parfums et eaux de toilette pour hommes et femmes.', '2024-04-24 00:39:11', '2024-04-24 00:39:11'),
(7, 'Produits de bien-être', 'Produits pour favoriser le bien-être mental et physique.', '2024-04-08 15:00:00', NULL),
(8, 'Soins des mains et des pieds', 'Produits pour hydrater et prendre soin des mains et des pieds.', '2024-04-08 15:00:00', NULL),
(9, 'Produits solaires', 'Produits pour protéger la peau des rayons UV.', '2024-04-08 15:00:00', NULL),
(10, 'Produits anti-âge', 'Produits pour réduire les signes de vieillissement de la peau.', '2024-04-08 15:00:00', NULL),
(11, 'Soins pour peaux sensibles', 'Produits doux et hypoallergéniques pour les peaux sensibles.', '2024-04-08 15:00:00', NULL),
(12, 'Produits naturels et biologiques', 'Produits fabriqués à partir d\'ingrédients naturels et biologiques.', '2024-04-08 15:00:00', NULL),
(13, 'Produits pour hommes', 'Produits de soin spécifiques pour les hommes.', '2024-04-08 15:00:00', NULL),
(14, 'Soins dentaires', 'Produits pour l\'hygiène bucco-dentaire, tels que le dentifrice et le fil dentaire.', '2024-04-08 15:00:00', NULL),
(15, 'Produits de relaxation et de méditation', 'Produits pour favoriser la relaxation et la méditation.', '2024-04-08 15:00:00', NULL),
(16, 'Soins pour les yeux', 'Produits pour le contour des yeux et les cernes.', '2024-04-08 15:00:00', NULL),
(17, 'Produits pour la maternité et la grossesse', 'Produits adaptés aux femmes enceintes et aux jeunes mamans.', '2024-04-08 15:00:00', NULL),
(18, 'Accessoires de beauté', 'Accessoires utiles pour les routines de beauté, tels que les pinceaux et les éponges.', '2024-04-08 15:00:00', NULL),
(19, 'Soins des ongles', 'Produits pour prendre soin des ongles des mains et des pieds.', '2024-04-08 15:00:00', NULL),
(20, 'Produits de régime et de nutrition', 'Produits pour favoriser une alimentation saine et équilibrée.', '2024-04-08 15:00:00', '2024-04-14 17:00:40'),
(29, 'أسامة اتويجر', '1', '2024-04-14 17:47:44', '2024-04-14 17:47:44'),
(31, 'h', 'h', '2024-04-15 18:30:14', '2024-04-15 18:30:14');

-- --------------------------------------------------------

--
-- Structure de la table `commands`
--

DROP TABLE IF EXISTS `commands`;
CREATE TABLE IF NOT EXISTS `commands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_client` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `valide` tinyint(1) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_command`
--

DROP TABLE IF EXISTS `ligne_command`;
CREATE TABLE IF NOT EXISTS `ligne_command` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_produit` int DEFAULT NULL,
  `id_commande` int DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `discount` bigint DEFAULT NULL,
  `id_categorie` int DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_idCategori` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `libelle`, `prix`, `discount`, `id_categorie`, `date_creation`, `description`, `image`, `color`, `date_modification`) VALUES
(1, 'Nettoyant pour le visage à l\'acide hyaluronique', 15.99, 5346, 1, '2024-04-24 00:41:58', 'Nettoyez en profondeur votre peau avec notre nettoyant à l\'acide hyaluronique qui hydrate et apaise.', 'nettoyant_visage.jpg', 'Bleu', '2024-04-24 00:41:58'),
(2, 'Crème hydratante à la vitamine C', 24.99, 23451, 1, '2024-04-24 00:46:28', 'Hydratez et illuminez votre peau avec notre crème à la vitamine C, idéale pour une peau éclatante.', 'creme_vitamine_c.jpg', 'Blanc', '2024-04-24 00:46:28'),
(3, 'Fond de teint liquide longue tenue', 19.99, 423, 2, '2024-04-04 01:49:03', 'Obtenez un teint parfait avec notre fond de teint liquide longue tenue, disponible dans plusieurs nuances.', 'fond_de_teint.jpg', 'Beige', '2024-04-14 18:10:43'),
(4, 'Palette d\'ombres à paupières neutres', 29.99, 719, 2, '2024-04-04 01:49:03', 'Créez des looks sublimes avec notre palette d\'ombres à paupières neutres, parfaite pour toutes les occasions.', 'palette_ombres_paupieres.jpg', 'Marron', '2024-04-14 18:10:43'),
(5, 'Shampooing fortifiant à l\'huile d\'argan', 12.99, 318, 3, '2024-04-04 01:49:03', 'Renforcez et hydratez vos cheveux avec notre shampooing à l\'huile d\'argan, idéal pour tous types de cheveux.', 'shampooing_argan.jpg', 'Jaune', '2024-04-14 18:10:43'),
(6, 'Masque capillaire réparateur à la kératine', 18.99, 437, 3, '2024-04-04 01:49:03', 'Réparez et nourrissez vos cheveux en profondeur avec notre masque capillaire à la kératine, pour des cheveux doux et soyeux.', 'masque_keratine.jpg', 'Vert', '2024-04-14 18:10:43'),
(81, 'Gel douche parfumé à la lavande', 9.99, 129, 4, '2024-04-08 15:08:13', 'Détendez-vous sous la douche avec notre gel douche parfumé à la lavande, pour une peau propre et douce.', 'gel_douche_lavande.jpg', 'Violet', '2024-04-14 18:10:43'),
(82, 'Boules de bain effervescentes à l\'eucalyptus', 7.99, 4, 4, '2024-04-08 15:08:13', 'Transformez votre bain en un moment de détente avec nos boules de bain effervescentes à l\'eucalyptus.', 'boules_bain_eucalyptus.jpg', 'Vert', '2024-04-14 18:10:43'),
(83, 'Lotion corporelle hydratante à l\'aloe vera', 14.99, 234, 5, '2024-04-08 15:08:13', 'Hydratez et adoucissez votre peau avec notre lotion corporelle à l\'aloe vera, pour une peau douce et soyeuse.', 'lotion_corporelle_aloe_vera.jpg', 'Bleu', '2024-04-14 18:10:43'),
(84, 'Exfoliant corporel à la noix de coco', 17.99, 259, 5, '2024-04-08 15:08:13', 'Exfoliez en douceur votre peau avec notre exfoliant corporel à la noix de coco, pour une peau lisse et éclatante.', 'exfoliant_corporel_noix_coco.jpg', 'Marron', '2024-04-14 18:10:43'),
(87, 'Huile essentielle de lavande pour la relaxation', 12.99, 91, 7, '2024-04-08 15:08:13', 'Apaisez votre esprit et votre corps avec notre huile essentielle de lavande, idéale pour la relaxation.', 'huile_lavande.jpg', 'Violet', '2024-04-14 18:10:43'),
(88, 'Complément alimentaire à base de probiotiques pour la digestion', 29.99, 238, 7, '2024-04-08 15:08:13', 'Maintenez un système digestif sain avec notre complément alimentaire à base de probiotiques.', 'complement_probiotiques.jpg', 'Vert', '2024-04-14 18:10:43'),
(89, 'Crème nourrissante pour les mains à l\'huile d\'amande', 9.99, 15, 8, '2024-04-08 15:08:13', 'Nourrissez et protégez vos mains avec notre crème à l\'huile d\'amande, pour des mains douces et hydratées.', 'creme_mains_amande.jpg', 'Blanc', '2024-04-14 18:10:43'),
(90, 'Kit de pédicure pour le soin des pieds à domicile', 19.99, 263, 8, '2024-04-08 15:08:13', 'Prenez soin de vos pieds à domicile avec notre kit de pédicure complet, pour des pieds doux et soignés.', 'kit_pedicure.jpg', 'Rose', '2024-04-14 18:10:43'),
(91, 'Crème solaire SPF 50+ à large spectre', 14.99, 68, 9, '2024-04-08 15:08:13', 'Protégez votre peau des rayons UV avec notre crème solaire SPF 50+, résistante à l\'eau et à large spectre.', 'creme_solaire.jpg', 'Jaune', '2024-04-14 18:10:43'),
(92, 'Spray bronzant progressif à l\'huile de coco', 19.99, 153, 9, '2024-04-08 15:08:13', 'Obtenez un bronzage progressif et naturel avec notre spray bronzant à l\'huile de coco, pour une peau dorée.', 'spray_bronzant.jpg', 'Marron', '2024-04-14 18:10:43'),
(93, 'Sérum anti-rides à l\'acide hyaluronique', 34.99, 258, 10, '2024-04-08 15:08:13', 'Réduisez visiblement les rides et ridules avec notre sérum anti-rides à l\'acide hyaluronique.', 'serum_anti_rides.jpg', 'Bleu', '2024-04-14 18:10:43'),
(94, 'Crème de nuit raffermissante aux peptides', 39.99, 232, 10, '2024-04-08 15:08:13', 'Raffermissez et régénérez votre peau pendant la nuit avec notre crème de nuit aux peptides.', 'creme_nuit_raffermissante.jpg', 'Blanc', '2024-04-14 18:10:43'),
(95, 'Lait démaquillant doux sans parfum', 12.99, 86, 11, '2024-04-08 15:08:13', 'Démaquillez votre peau en douceur avec notre lait démaquillant sans parfum, idéal pour les peaux sensibles.', 'lait_demaquillant.jpg', 'Blanc', '2024-04-14 18:10:43'),
(96, 'Crème apaisante pour le visage à l\'avoine colloïdale', 16.99, 34, 11, '2024-04-08 15:08:13', 'Apaisez et hydratez votre peau avec notre crème visage à l\'avoine colloïdale, pour une peau douce et confortable.', 'creme_avoine.jpg', 'Beige', '2024-04-14 18:10:43'),
(97, 'Baume à lèvres bio à la cire d\'abeille', 5.99, 211, 12, '2024-04-08 15:08:13', 'Nourrissez vos lèvres avec notre baume à lèvres bio à la cire d\'abeille, pour des lèvres douces et hydratées.', 'baume_levres.jpg', 'Rose', '2024-04-14 18:10:43'),
(98, 'Déodorant naturel sans aluminium à la pierre d\'alun', 8.99, 54, 12, '2024-04-08 15:08:13', 'Restez frais toute la journée avec notre déodorant naturel sans aluminium à la pierre d\'alun.', 'deodorant_naturel.jpg', 'Blanc', '2024-04-14 18:10:43'),
(99, 'Gel de rasage hydratant à l\'aloe vera', 14.99, 234, 13, '2024-04-08 15:08:13', 'Obtenez un rasage doux et confortable avec notre gel de rasage hydratant à l\'aloe vera.', 'gel_rasage.jpg', 'Bleu', '2024-04-14 18:10:43'),
(100, 'Baume après-rasage rafraîchissant à la menthe', 12.99, 109, 13, '2024-04-08 15:08:13', 'Apaisez et rafraîchissez votre peau après le rasage avec notre baume après-rasage à la menthe.', 'baume_apres_rasage.jpg', 'Vert', '2024-04-14 18:10:43'),
(101, 'Dentifrice blanchissant au charbon actif', 7.99, 140, 14, '2024-04-08 15:08:13', 'Blanchissez naturellement vos dents avec notre dentifrice au charbon actif, pour un sourire éclatant.', 'dentifrice_charbon.jpg', 'Noir', '2024-04-14 18:10:43'),
(102, 'Brosse à dents électrique rechargeable', 29.99, 75, 14, '2024-04-08 15:08:13', 'Nettoyez vos dents en profondeur avec notre brosse à dents électrique rechargeable, pour une hygiène bucco-dentaire optimale.', 'brosse_dents_electrique.jpg', 'Blanc', '2024-04-14 18:10:43'),
(103, 'Bougie parfumée à la lavande pour la relaxation', 12.99, 253, 15, '2024-04-08 15:08:13', 'Créez une ambiance apaisante avec notre bougie parfumée à la lavande, parfaite pour la relaxation.', 'bougie_lavande.jpg', 'Violet', '2024-04-14 18:10:43'),
(104, 'Tapis de yoga antidérapant en caoutchouc naturel', 29.99, 141, 15, '2024-04-08 15:08:13', 'Pratiquez le yoga en toute sécurité avec notre tapis de yoga antidérapant en caoutchouc naturel.', 'tapis_yoga.jpg', 'Green', '2024-04-14 18:10:43'),
(105, 'Crème contour des yeux hydratante à l\'acide hyaluronique', 19.99, 243, 16, '2024-04-08 15:08:13', 'Hydratez et atténuez les cernes avec notre crème contour des yeux à l\'acide hyaluronique.', 'creme_contour_yeux.jpg', 'Bleu', '2024-04-14 18:10:43'),
(106, 'Patchs défatigants pour les yeux à la vitamine C', 14.99, 195, 16, '2024-04-08 15:08:13', 'Redonnez de l\'éclat à votre regard avec nos patchs défatigants pour les yeux à la vitamine C.', 'patchs_yeux.jpg', 'Vert', '2024-04-14 18:10:43'),
(107, 'Huile anti-vergetures pour femmes enceintes', 24.99, 242, 17, '2024-04-08 15:08:13', 'Prévenez l\'apparition des vergetures pendant la grossesse avec notre huile anti-vergetures spécialement formulée.', 'huile_vergetures.jpg', 'Jaune', '2024-04-14 18:10:43'),
(108, 'Crème apaisante pour les mamelons allaitants', 19.99, 25, 17, '2024-04-08 15:08:13', 'Apaisez et protégez vos mamelons pendant l\'allaitement avec notre crème apaisante.', 'creme_mamelons.jpg', 'Blanc', '2024-04-14 18:10:43'),
(109, 'Ensemble de pinceaux de maquillage professionnels', 34.99, 300, 18, '2024-04-08 15:08:13', 'Obtenez des résultats professionnels avec notre ensemble de pinceaux de maquillage haut de gamme.', 'pinceaux_maquillage.jpg', 'Noir', '2024-04-14 18:10:43'),
(110, 'Éponge de maquillage sans latex', 9.99, 225, 18, '2024-04-08 15:08:13', 'Appliquez votre maquillage en douceur avec notre éponge sans latex, idéale pour un fini parfait.', 'eponge_maquillage.jpg', 'Rose', '2024-04-14 18:10:43'),
(111, 'Vernis à ongles longue tenue à séchage rapide', 6.99, 223, 19, '2024-04-08 15:08:13', 'Sublimez vos ongles avec notre vernis longue tenue à séchage rapide, disponible dans une large gamme de couleurs.', 'vernis_ongles.jpg', 'Rouge', '2024-04-14 18:10:43'),
(112, 'Kit de manucure professionnel avec lime à ongles et cuticules', 14.99, 139, 19, '2024-04-08 15:08:13', 'Prenez soin de vos ongles à domicile avec notre kit de manucure professionnel complet.', 'kit_manucure.jpg', 'Blanc', '2024-04-14 18:10:43'),
(113, 'Complément alimentaire protéiné pour la gestion du poids', 29.99, 26, 20, '2024-04-08 15:08:13', 'Maintenez votre poids idéal avec notre complément alimentaire protéiné, parfait pour la gestion du poids.', 'complement_proteine.jpg', 'Vert', '2024-04-14 18:10:43'),
(114, 'Barres énergétiques aux fruits secs et graines bio', 13.99, 12, 2, '2024-04-08 15:08:13', 'Rechargez vos batteries avec nos barres énergétiques aux fruits secs et graines bio, idéales pour une pause saine.', 'barres_energetiques.jpg', 'Jaune', '2024-04-21 23:34:15'),
(115, 'Soins du visageooooo', 10.00, 10, 2, '2024-04-14 19:13:16', 'gghhbhj', 'dsbsj.ipg', 'bleu', '2024-04-14 19:13:16'),
(117, 'yassin', 10.00, 11, 10, '2024-04-15 18:51:38', 'dcedd', 'dsb2sj.ipg', 'bleu', '2024-04-15 18:51:38'),
(118, 'Touijer Oussama11', 11.00, 111, 2, '2024-04-17 02:19:37', 'sa', 'd2sbsj.ipg', 'bleu2', '2024-04-17 02:19:37');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` enum('client','admin') DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `etat` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `user_type`, `telephone`, `address`, `ville`, `date_creation`, `date_modification`, `etat`) VALUES
(21, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '$2y$10$H8OKDA9MhuAohrTO1G7wSujhGA2zvOmCGlfREh/xmeLQHJbL1trKK', 'admin', '0610605738', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'Salé', '2024-04-09 01:22:10', '2024-04-22 23:30:34', 0),
(22, 'sanae', 'yousri', 'sanae@gmail.com', '$2y$10$v36lnopd5PvP7VQvm1XuFeEDCCnmPH/Ykpbipr4d1WiXgPEtbnHuK', 'client', '0645364564', 'HAY Horia RUE MtochN 113 Asilah', 'Asilah', '2024-04-09 01:29:31', '2024-04-22 23:32:58', 0),
(23, 'Youness', 'Wyday', 'youness@gmail.com', '$2y$10$RY1mxT1LP4jiPJnqyQUoXezkIDGmXSI3v/q6jOfkJN/PbnM4whDVe', 'client', '0645132435', 'HAY karima RUE MATMATA N 113 SALE', 'Agadir', '2024-04-22 19:30:23', '2024-04-22 19:30:23', 0),
(24, 'simo', 'simo', 'simo@gmail.com', '$2y$10$TVDqgoeioQRTMc4iKw.UGufc0/b8UvGf/CeeXBm8ayQtjNhxmn3xy', 'client', '0613242526', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'Khemisset', '2024-04-22 23:10:38', '2024-04-22 23:10:38', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_idCategori` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
