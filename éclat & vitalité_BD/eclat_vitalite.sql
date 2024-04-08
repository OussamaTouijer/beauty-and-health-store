-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 08 avr. 2024 à 18:31
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
  `icone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `libelle`, `description`, `date_creation`, `icone`) VALUES
(1, 'Soins du visage', 'Produits pour nettoyer, hydrater et protéger la peau du visage.', '2024-04-08 15:00:00', 'icone_visage.png'),
(2, 'Maquillage', 'Produits cosmétiques pour embellir le visage, les yeux, les lèvres, etc.', '2024-04-08 15:00:00', 'icone_maquillage.png'),
(3, 'Soins capillaires', 'Produits pour laver, hydrater et coiffer les cheveux.', '2024-04-08 15:00:00', 'icone_cheveux.png'),
(4, 'Produits de bain et de douche', 'Produits pour l\'hygiène corporelle, tels que les gels douche et les savons.', '2024-04-08 15:00:00', 'icone_bain.png'),
(5, 'Soins du corps', 'Produits pour hydrater et prendre soin de la peau du corps.', '2024-04-08 15:00:00', 'icone_corps.png'),
(6, 'Parfums et fragrances', 'Parfums et eaux de toilette pour hommes et femmes.', '2024-04-08 15:00:00', 'icone_parfum.png'),
(7, 'Produits de bien-être', 'Produits pour favoriser le bien-être mental et physique.', '2024-04-08 15:00:00', 'icone_bien_etre.png'),
(8, 'Soins des mains et des pieds', 'Produits pour hydrater et prendre soin des mains et des pieds.', '2024-04-08 15:00:00', 'icone_mains_pieds.png'),
(9, 'Produits solaires', 'Produits pour protéger la peau des rayons UV.', '2024-04-08 15:00:00', 'icone_solaire.png'),
(10, 'Produits anti-âge', 'Produits pour réduire les signes de vieillissement de la peau.', '2024-04-08 15:00:00', 'icone_anti_age.png'),
(11, 'Soins pour peaux sensibles', 'Produits doux et hypoallergéniques pour les peaux sensibles.', '2024-04-08 15:00:00', 'icone_peau_sensible.png'),
(12, 'Produits naturels et biologiques', 'Produits fabriqués à partir d\'ingrédients naturels et biologiques.', '2024-04-08 15:00:00', 'icone_naturel.png'),
(13, 'Produits pour hommes', 'Produits de soin spécifiques pour les hommes.', '2024-04-08 15:00:00', 'icone_homme.png'),
(14, 'Soins dentaires', 'Produits pour l\'hygiène bucco-dentaire, tels que le dentifrice et le fil dentaire.', '2024-04-08 15:00:00', 'icone_dentaire.png'),
(15, 'Produits de relaxation et de méditation', 'Produits pour favoriser la relaxation et la méditation.', '2024-04-08 15:00:00', 'icone_relaxation.png'),
(16, 'Soins pour les yeux', 'Produits pour le contour des yeux et les cernes.', '2024-04-08 15:00:00', 'icone_yeux.png'),
(17, 'Produits pour la maternité et la grossesse', 'Produits adaptés aux femmes enceintes et aux jeunes mamans.', '2024-04-08 15:00:00', 'icone_maternite.png'),
(18, 'Accessoires de beauté', 'Accessoires utiles pour les routines de beauté, tels que les pinceaux et les éponges.', '2024-04-08 15:00:00', 'icone_accessoires.png'),
(19, 'Soins des ongles', 'Produits pour prendre soin des ongles des mains et des pieds.', '2024-04-08 15:00:00', 'icone_ongles.png'),
(20, 'Produits de régime et de nutrition', 'Produits pour favoriser une alimentation saine et équilibrée.', '2024-04-08 15:00:00', 'icone_nutrition.png');

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
  `discount` decimal(10,2) DEFAULT NULL,
  `id_categorie` int DEFAULT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idCategori` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `libelle`, `prix`, `discount`, `id_categorie`, `date_creation`, `description`, `image`, `color`) VALUES
(1, 'Nettoyant pour le visage à l\'acide hyaluronique', 15.99, 747.00, 1, '2024-04-04 01:49:03', 'Nettoyez en profondeur votre peau avec notre nettoyant à l\'acide hyaluronique qui hydrate et apaise.', 'nettoyant_visage.jpg', 'Bleu'),
(2, 'Crème hydratante à la vitamine C', 24.99, 131.00, 1, '2024-04-04 01:49:03', 'Hydratez et illuminez votre peau avec notre crème à la vitamine C, idéale pour une peau éclatante.', 'creme_vitamine_c.jpg', 'Blanc'),
(3, 'Fond de teint liquide longue tenue', 19.99, 423.00, 2, '2024-04-04 01:49:03', 'Obtenez un teint parfait avec notre fond de teint liquide longue tenue, disponible dans plusieurs nuances.', 'fond_de_teint.jpg', 'Beige'),
(4, 'Palette d\'ombres à paupières neutres', 29.99, 719.00, 2, '2024-04-04 01:49:03', 'Créez des looks sublimes avec notre palette d\'ombres à paupières neutres, parfaite pour toutes les occasions.', 'palette_ombres_paupieres.jpg', 'Marron'),
(5, 'Shampooing fortifiant à l\'huile d\'argan', 12.99, 318.00, 3, '2024-04-04 01:49:03', 'Renforcez et hydratez vos cheveux avec notre shampooing à l\'huile d\'argan, idéal pour tous types de cheveux.', 'shampooing_argan.jpg', 'Jaune'),
(6, 'Masque capillaire réparateur à la kératine', 18.99, 437.00, 3, '2024-04-04 01:49:03', 'Réparez et nourrissez vos cheveux en profondeur avec notre masque capillaire à la kératine, pour des cheveux doux et soyeux.', 'masque_keratine.jpg', 'Vert'),
(81, 'Gel douche parfumé à la lavande', 9.99, 129.00, 4, '2024-04-08 15:08:13', 'Détendez-vous sous la douche avec notre gel douche parfumé à la lavande, pour une peau propre et douce.', 'gel_douche_lavande.jpg', 'Violet'),
(82, 'Boules de bain effervescentes à l\'eucalyptus', 7.99, 4.00, 4, '2024-04-08 15:08:13', 'Transformez votre bain en un moment de détente avec nos boules de bain effervescentes à l\'eucalyptus.', 'boules_bain_eucalyptus.jpg', 'Vert'),
(83, 'Lotion corporelle hydratante à l\'aloe vera', 14.99, 234.00, 5, '2024-04-08 15:08:13', 'Hydratez et adoucissez votre peau avec notre lotion corporelle à l\'aloe vera, pour une peau douce et soyeuse.', 'lotion_corporelle_aloe_vera.jpg', 'Bleu'),
(84, 'Exfoliant corporel à la noix de coco', 17.99, 259.00, 5, '2024-04-08 15:08:13', 'Exfoliez en douceur votre peau avec notre exfoliant corporel à la noix de coco, pour une peau lisse et éclatante.', 'exfoliant_corporel_noix_coco.jpg', 'Marron'),
(85, 'Eau de parfum floral pour femmes', 49.99, 290.00, 6, '2024-04-08 15:08:13', 'Enveloppez-vous dans notre eau de parfum floral, un mélange envoûtant de fleurs pour une touche de féminité.', 'eau_parfum_floral.jpg', 'Rose'),
(86, 'Eau de toilette boisée pour hommes', 39.99, 72.00, 6, '2024-04-08 15:08:13', 'Affirmez votre masculinité avec notre eau de toilette boisée, un parfum audacieux et raffiné.', 'eau_toilette_boisee.jpg', 'Marron'),
(87, 'Huile essentielle de lavande pour la relaxation', 12.99, 91.00, 7, '2024-04-08 15:08:13', 'Apaisez votre esprit et votre corps avec notre huile essentielle de lavande, idéale pour la relaxation.', 'huile_lavande.jpg', 'Violet'),
(88, 'Complément alimentaire à base de probiotiques pour la digestion', 29.99, 238.00, 7, '2024-04-08 15:08:13', 'Maintenez un système digestif sain avec notre complément alimentaire à base de probiotiques.', 'complement_probiotiques.jpg', 'Vert'),
(89, 'Crème nourrissante pour les mains à l\'huile d\'amande', 9.99, 15.00, 8, '2024-04-08 15:08:13', 'Nourrissez et protégez vos mains avec notre crème à l\'huile d\'amande, pour des mains douces et hydratées.', 'creme_mains_amande.jpg', 'Blanc'),
(90, 'Kit de pédicure pour le soin des pieds à domicile', 19.99, 263.00, 8, '2024-04-08 15:08:13', 'Prenez soin de vos pieds à domicile avec notre kit de pédicure complet, pour des pieds doux et soignés.', 'kit_pedicure.jpg', 'Rose'),
(91, 'Crème solaire SPF 50+ à large spectre', 14.99, 68.00, 9, '2024-04-08 15:08:13', 'Protégez votre peau des rayons UV avec notre crème solaire SPF 50+, résistante à l\'eau et à large spectre.', 'creme_solaire.jpg', 'Jaune'),
(92, 'Spray bronzant progressif à l\'huile de coco', 19.99, 153.00, 9, '2024-04-08 15:08:13', 'Obtenez un bronzage progressif et naturel avec notre spray bronzant à l\'huile de coco, pour une peau dorée.', 'spray_bronzant.jpg', 'Marron'),
(93, 'Sérum anti-rides à l\'acide hyaluronique', 34.99, 258.00, 10, '2024-04-08 15:08:13', 'Réduisez visiblement les rides et ridules avec notre sérum anti-rides à l\'acide hyaluronique.', 'serum_anti_rides.jpg', 'Bleu'),
(94, 'Crème de nuit raffermissante aux peptides', 39.99, 232.00, 10, '2024-04-08 15:08:13', 'Raffermissez et régénérez votre peau pendant la nuit avec notre crème de nuit aux peptides.', 'creme_nuit_raffermissante.jpg', 'Blanc'),
(95, 'Lait démaquillant doux sans parfum', 12.99, 86.00, 11, '2024-04-08 15:08:13', 'Démaquillez votre peau en douceur avec notre lait démaquillant sans parfum, idéal pour les peaux sensibles.', 'lait_demaquillant.jpg', 'Blanc'),
(96, 'Crème apaisante pour le visage à l\'avoine colloïdale', 16.99, 34.00, 11, '2024-04-08 15:08:13', 'Apaisez et hydratez votre peau avec notre crème visage à l\'avoine colloïdale, pour une peau douce et confortable.', 'creme_avoine.jpg', 'Beige'),
(97, 'Baume à lèvres bio à la cire d\'abeille', 5.99, 211.00, 12, '2024-04-08 15:08:13', 'Nourrissez vos lèvres avec notre baume à lèvres bio à la cire d\'abeille, pour des lèvres douces et hydratées.', 'baume_levres.jpg', 'Rose'),
(98, 'Déodorant naturel sans aluminium à la pierre d\'alun', 8.99, 54.00, 12, '2024-04-08 15:08:13', 'Restez frais toute la journée avec notre déodorant naturel sans aluminium à la pierre d\'alun.', 'deodorant_naturel.jpg', 'Blanc'),
(99, 'Gel de rasage hydratant à l\'aloe vera', 14.99, 234.00, 13, '2024-04-08 15:08:13', 'Obtenez un rasage doux et confortable avec notre gel de rasage hydratant à l\'aloe vera.', 'gel_rasage.jpg', 'Bleu'),
(100, 'Baume après-rasage rafraîchissant à la menthe', 12.99, 109.00, 13, '2024-04-08 15:08:13', 'Apaisez et rafraîchissez votre peau après le rasage avec notre baume après-rasage à la menthe.', 'baume_apres_rasage.jpg', 'Vert'),
(101, 'Dentifrice blanchissant au charbon actif', 7.99, 140.00, 14, '2024-04-08 15:08:13', 'Blanchissez naturellement vos dents avec notre dentifrice au charbon actif, pour un sourire éclatant.', 'dentifrice_charbon.jpg', 'Noir'),
(102, 'Brosse à dents électrique rechargeable', 29.99, 75.00, 14, '2024-04-08 15:08:13', 'Nettoyez vos dents en profondeur avec notre brosse à dents électrique rechargeable, pour une hygiène bucco-dentaire optimale.', 'brosse_dents_electrique.jpg', 'Blanc'),
(103, 'Bougie parfumée à la lavande pour la relaxation', 12.99, 253.00, 15, '2024-04-08 15:08:13', 'Créez une ambiance apaisante avec notre bougie parfumée à la lavande, parfaite pour la relaxation.', 'bougie_lavande.jpg', 'Violet'),
(104, 'Tapis de yoga antidérapant en caoutchouc naturel', 29.99, 141.00, 15, '2024-04-08 15:08:13', 'Pratiquez le yoga en toute sécurité avec notre tapis de yoga antidérapant en caoutchouc naturel.', 'tapis_yoga.jpg', 'Green'),
(105, 'Crème contour des yeux hydratante à l\'acide hyaluronique', 19.99, 243.00, 16, '2024-04-08 15:08:13', 'Hydratez et atténuez les cernes avec notre crème contour des yeux à l\'acide hyaluronique.', 'creme_contour_yeux.jpg', 'Bleu'),
(106, 'Patchs défatigants pour les yeux à la vitamine C', 14.99, 195.00, 16, '2024-04-08 15:08:13', 'Redonnez de l\'éclat à votre regard avec nos patchs défatigants pour les yeux à la vitamine C.', 'patchs_yeux.jpg', 'Vert'),
(107, 'Huile anti-vergetures pour femmes enceintes', 24.99, 242.00, 17, '2024-04-08 15:08:13', 'Prévenez l\'apparition des vergetures pendant la grossesse avec notre huile anti-vergetures spécialement formulée.', 'huile_vergetures.jpg', 'Jaune'),
(108, 'Crème apaisante pour les mamelons allaitants', 19.99, 25.00, 17, '2024-04-08 15:08:13', 'Apaisez et protégez vos mamelons pendant l\'allaitement avec notre crème apaisante.', 'creme_mamelons.jpg', 'Blanc'),
(109, 'Ensemble de pinceaux de maquillage professionnels', 34.99, 300.00, 18, '2024-04-08 15:08:13', 'Obtenez des résultats professionnels avec notre ensemble de pinceaux de maquillage haut de gamme.', 'pinceaux_maquillage.jpg', 'Noir'),
(110, 'Éponge de maquillage sans latex', 9.99, 225.00, 18, '2024-04-08 15:08:13', 'Appliquez votre maquillage en douceur avec notre éponge sans latex, idéale pour un fini parfait.', 'eponge_maquillage.jpg', 'Rose'),
(111, 'Vernis à ongles longue tenue à séchage rapide', 6.99, 223.00, 19, '2024-04-08 15:08:13', 'Sublimez vos ongles avec notre vernis longue tenue à séchage rapide, disponible dans une large gamme de couleurs.', 'vernis_ongles.jpg', 'Rouge'),
(112, 'Kit de manucure professionnel avec lime à ongles et cuticules', 14.99, 139.00, 19, '2024-04-08 15:08:13', 'Prenez soin de vos ongles à domicile avec notre kit de manucure professionnel complet.', 'kit_manucure.jpg', 'Blanc'),
(113, 'Complément alimentaire protéiné pour la gestion du poids', 29.99, 26.00, 20, '2024-04-08 15:08:13', 'Maintenez votre poids idéal avec notre complément alimentaire protéiné, parfait pour la gestion du poids.', 'complement_proteine.jpg', 'Vert'),
(114, 'Barres énergétiques aux fruits secs et graines bio', 19.99, 12.00, 20, '2024-04-08 15:08:13', 'Rechargez vos batteries avec nos barres énergétiques aux fruits secs et graines bio, idéales pour une pause saine.', 'barres_energetiques.jpg', 'Jaune');

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
  `user_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `user_type`, `created_at`, `telephone`, `address`, `ville`) VALUES
(1, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '1234', 'client', NULL, '0656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE'),
(2, 'yassin', 'OUSSAMA', 'gayg@gusgd', 'oussama', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE'),
(3, 'TOUIJER', 'OUSSAMA', 'assalanass12@gmail.com', 'anass7781', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE'),
(4, 'TOUIJER', 'OUSSAMA', 'assalanass12@gmail.com', 'anass7781', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE'),
(5, 'TOUIJER', 'OUSSAMA', 'assalanass12@gmail.com', 'anass7781', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE'),
(6, 'TOUIJER', 'OUSSAMA', 'assalanass12@gmail.com', 'anass7781', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE'),
(7, 'TOUIJER', 'OUSSAMA', 'assalanass12@gmail.com', 'anass7781', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE'),
(8, 'TOUIJER', 'OUSSAMA', 'assalanass12@gmail.com', 'anass7781', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE'),
(9, NULL, NULL, 'oussama5touijer@gmail.com', '1234', 'client', NULL, NULL, NULL, NULL),
(10, NULL, NULL, 'oussama5touijer@gmail.com', '1111', 'client', NULL, NULL, NULL, NULL),
(11, 'saad', 'saad', 'saad@gmail.com', '934b535800b1cba8f96a5d72f72f1611', 'client', NULL, '12345678997', 'hay chikhe lamfadal', 'SALE'),
(12, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '$2y$10$mjS9FpyRr9VVbRLDWMptC.MaNeyEoWGVJY0y6PH1fqAA4tInRL3Hm', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'RABAT HASSAN RABAT'),
(13, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '$2y$10$Ed4OG/t.dJ3RA/HBjNRXdOuR5nujlq6RV55d/OvLkHvKHsFeUWwdi', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'RABAT HASSAN RABAT'),
(14, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '$2y$10$q/39JMuSQJkXLEgv50g5tu51rB6m7Fp1oJBLmBZt9STEzECU9Bo8m', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'RABAT HASSAN RABAT'),
(15, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '$2y$10$k/AXhlqp59WVUHy1Gkzaf.lGjc4fK5Um.sb2ZgSrXbPUHW.O0yM8O', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'RABAT HASSAN RABAT'),
(16, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '$2y$10$jwrgeWTdbjBVLA5.e3UQP./QjgXADeAeI5/wstXj.whJL0xQTRdgm', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'RABAT HASSAN RABAT'),
(17, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '$2y$10$vplt.2RvRmtgl8rxII67ieYDj2QiXJlQhyeqIKUs7cN3uYoNmkYoG', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'RABAT HASSAN RABAT'),
(18, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '$2y$10$lPBQT1Ijz04t0C35UwKaPOCqYWxNg/ir/gu7iSr2JkGGLvVW/.Jua', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'RABAT HASSAN RABAT'),
(19, 'TOUIJER', 'OUSSAMA', 'oussama5touijer@gmail.com', '$2y$10$5OsxwlZYA6JyVd0ZwM.CZunumLonZb4Fuycp/2W3myBMh9vZWJpa2', 'client', NULL, '+212656159393', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE'),
(20, 'Qacciri', 'OUSSAMA', 'qr@gmail.com', '$2y$10$pSvLUw7krBgVTEnQ/Vq0xOGSsEXx7TiOkngjFVMTNy.5rfAWRogx6', 'client', NULL, '+212610605738', 'HAY CHIKHE LAMFADAL RUE MATMATA N 113 SALE', 'SALE');

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
