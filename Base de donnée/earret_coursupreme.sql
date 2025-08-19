-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 30 avr. 2025 à 11:13
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `earret_coursupreme`
--

-- --------------------------------------------------------

--
-- Structure de la table `affecter_section`
--

DROP TABLE IF EXISTS `affecter_section`;
CREATE TABLE IF NOT EXISTS `affecter_section` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `greffier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `conseiller_rapporteur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `section_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_affectation` datetime DEFAULT NULL,
  `motif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delai_traitement` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B8209495611C0C56` (`dossier_id`),
  KEY `IDX_B82094952EDDA160` (`greffier_id`),
  KEY `IDX_B82094959D18E664` (`conseiller_rapporteur_id`),
  KEY `IDX_B8209495D823E37A` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `affecter_section`
--

INSERT INTO `affecter_section` (`id`, `dossier_id`, `greffier_id`, `conseiller_rapporteur_id`, `section_id`, `date_affectation`, `motif`, `delai_traitement`) VALUES
(0x0194843fed47733ab2f54d4359a0e5ba, 0x0194843582e077fea1bc68f937e43c87, 0x019247e59b0875bcbbf0a4a9e3e43d55, 0x019483b39f8c7ae6926901a9664bebca, 0x019247d9aed4773ca611df385483f6bf, '2025-01-20 00:00:00', 'pour rapport', 100),
(0x0194846e516c7d5f8f410cf346b5b1d5, 0x019484568c83775ebc5d838133d4004b, 0x019247e59b0875bcbbf0a4a9e3e43d55, 0x019483b39f8c7ae6926901a9664bebca, 0x019247d9aed4773ca611df385483f6bf, '2025-01-20 00:00:00', 'pour instructions et rapport', 500),
(0x01955c15679d7c07b5ad51ee68876d22, 0x01955bc52dc671ce9c69e837f752086a, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x01926d02517577f5b25c975f840c6c67, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, '2025-03-03 00:00:00', 'A traiter attentivement', 30),
(0x019565df1b5671d0b43446776e8382ef, 0x019565b3c2f9743f9f0d270d6d71e732, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x01926d02517577f5b25c975f840c6c67, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, '2025-03-05 00:00:00', 'Chers conseiller et greffier veuillez analyser correctement le dossier', 30),
(0x01967838508674e2936682d02380fbdc, 0x01967751f55b7c56ac4ef1736bae2c1d, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x01926d02517577f5b25c975f840c6c67, 0x0191ae4ba09c74e79f91e998773af8e0, '2025-04-27 00:00:00', 'Dossier à traité avec attention', 90);

-- --------------------------------------------------------

--
-- Structure de la table `affecter_structure`
--

DROP TABLE IF EXISTS `affecter_structure`;
CREATE TABLE IF NOT EXISTS `affecter_structure` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `de_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_affection` datetime DEFAULT NULL,
  `motif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delai_traitement` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FD63FCBA611C0C56` (`dossier_id`),
  KEY `IDX_FD63FCBA2534008B` (`structure_id`),
  KEY `IDX_FD63FCBA3F683D83` (`de_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `affecter_structure`
--

INSERT INTO `affecter_structure` (`id`, `dossier_id`, `structure_id`, `de_id`, `date_affection`, `motif`, `delai_traitement`) VALUES
(0x01955e01eeab76f1bcc77225a971a46e, 0x01955bc52dc671ce9c69e837f752086a, 0x0194896f56e8727e944341a5550a573f, 0x0191ae4201167fab94810a32b44f2ec4, '2025-03-03 00:00:00', 'Documents au complet', NULL),
(0x01955e3ec69970f08eb0b71c45613d4b, 0x01955bc52dc671ce9c69e837f752086a, 0x0194896f56e8727e944341a5550a573f, 0x0191ae4201167fab94810a32b44f2ec4, '2025-03-04 00:00:00', 'A traité', NULL),
(0x0195618961a97e2f8c7a3ac1ace48233, 0x01955bc52dc671ce9c69e837f752086a, 0x0194896f56e8727e944341a5550a573f, 0x0191ae4201167fab94810a32b44f2ec4, '2025-03-04 00:00:00', 'Pour analyse', NULL),
(0x0195619ca5597909b00339770062b836, 0x01955bc52dc671ce9c69e837f752086a, 0x0191ae4201167fab94810a32b44f2ec4, 0x0194896f56e8727e944341a5550a573f, '2025-03-04 14:43:30', 'C\'est correct', NULL),
(0x0195636de41d74dd87d6c9a46ee967d0, 0x01955bc52dc671ce9c69e837f752086a, 0x0191ae4201167fab94810a32b44f2ec4, 0x0194896f56e8727e944341a5550a573f, '2025-03-04 23:11:41', 'Tranché', NULL),
(0x0195664adc397c2197f2166563d7310f, 0x01955bc52dc671ce9c69e837f752086a, 0x0194896f56e8727e944341a5550a573f, 0x0191ae4201167fab94810a32b44f2ec4, '2025-03-05 00:00:00', 'Votre avis juridique', NULL),
(0x0195664cfb577fc4b60cf7a513135c0f, 0x01955bc52dc671ce9c69e837f752086a, 0x0194896f56e8727e944341a5550a573f, 0x0191ae4201167fab94810a32b44f2ec4, '2025-03-05 00:00:00', 'Avis', NULL),
(0x0195664e55dc76abb97a781d1cb391ad, 0x01955bc52dc671ce9c69e837f752086a, 0x0191ae4201167fab94810a32b44f2ec4, 0x0194896f56e8727e944341a5550a573f, '2025-03-05 12:36:04', 'A trancher', NULL),
(0x019566baad4b7dcbb5b6c773098ff984, 0x019565b3c2f9743f9f0d270d6d71e732, 0x0194896f56e8727e944341a5550a573f, 0x0191ae4201167fab94810a32b44f2ec4, '2025-03-05 00:00:00', 'Votre avis', NULL),
(0x0196786acc617f6ab89a2964473b0556, 0x019565b3c2f9743f9f0d270d6d71e732, 0x0194896f56e8727e944341a5550a573f, 0x0191ae4201167fab94810a32b44f2ec4, '2025-04-27 00:00:00', 'Vos conclusions sont attendues', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `affecter_user`
--

DROP TABLE IF EXISTS `affecter_user`;
CREATE TABLE IF NOT EXISTS `affecter_user` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `destinataire_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `expediteur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_affection` datetime DEFAULT NULL,
  `motif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delai_traitement` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_50D5A332611C0C56` (`dossier_id`),
  KEY `IDX_50D5A332A4F84F6E` (`destinataire_id`),
  KEY `IDX_50D5A33210335F61` (`expediteur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `affecter_user`
--

INSERT INTO `affecter_user` (`id`, `dossier_id`, `destinataire_id`, `expediteur_id`, `date_affection`, `motif`, `delai_traitement`) VALUES
(0x019566b4f0d476c696b4f9bd9edace68, 0x019565b3c2f9743f9f0d270d6d71e732, 0x01926c99522e7199b98627e2811e830d, 0x01926d02517577f5b25c975f840c6c67, '2025-03-05 14:28:08', 'Rapport de fin d\'instruction', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `arrets`
--

DROP TABLE IF EXISTS `arrets`;
CREATE TABLE IF NOT EXISTS `arrets` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `created_by_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_arret` datetime DEFAULT NULL,
  `titrage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resume` longtext COLLATE utf8mb4_unicode_ci,
  `commentaire` longtext COLLATE utf8mb4_unicode_ci,
  `arret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_arret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forclusion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FC0D335BB03A8386` (`created_by_id`),
  KEY `IDX_FC0D335B611C0C56` (`dossier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `arrondissement`
--

DROP TABLE IF EXISTS `arrondissement`;
CREATE TABLE IF NOT EXISTS `arrondissement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commune_id` int DEFAULT NULL,
  `lib_arrond` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3A3B64C4131A4F72` (`commune_id`)
) ENGINE=InnoDB AUTO_INCREMENT=547 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `arrondissement`
--

INSERT INTO `arrondissement` (`id`, `commune_id`, `lib_arrond`) VALUES
(1, 1, 'FOUNOUGO'),
(2, 1, 'GOMPAROU'),
(3, 1, 'GOUMORI'),
(4, 1, 'KOKEY'),
(5, 1, 'KOKIBOROU'),
(6, 1, 'OUNET'),
(7, 1, 'SOMPEROUKOU'),
(8, 1, 'SOROKO'),
(9, 1, 'TOURA'),
(10, 1, 'BANIKOARA'),
(11, 2, 'BAGOU'),
(12, 2, 'GOUNAROU'),
(13, 2, 'SORI'),
(14, 2, 'SOUGOU-KPAN-TROSSI'),
(15, 2, 'WARA'),
(16, 2, 'GOGOUNOU'),
(17, 3, 'ANGARADEBOU'),
(18, 3, 'BENSEKOU'),
(19, 3, 'DONWARI'),
(20, 3, 'KASSAKOU'),
(21, 3, 'SAAH'),
(22, 3, 'SAM'),
(23, 3, 'SONSORO'),
(24, 3, 'KANDI 1'),
(25, 3, 'KANDI 2'),
(26, 3, 'KANDI 3'),
(27, 4, 'BIRNI LAFIA'),
(28, 4, 'BOGO-BOGO'),
(29, 4, 'KOMPA'),
(30, 4, 'MONSEY'),
(31, 4, 'KARIMAMA'),
(32, 5, 'GAROU'),
(33, 5, 'GUENE'),
(34, 5, 'MADECALI'),
(35, 5, 'TOUMBOUTOU'),
(36, 5, 'MALANVILLE'),
(37, 6, 'LIBANTE'),
(38, 6, 'LIBOUSSOU'),
(39, 6, 'LOUGOU'),
(40, 6, 'SOKOTINDJI'),
(41, 6, 'SEGBANA'),
(42, 7, 'DIPOLI'),
(43, 7, 'KORONTIERE'),
(44, 7, 'KOUSSOUCOINGOU'),
(45, 7, 'MANTA'),
(46, 7, 'NATA'),
(47, 7, 'TABOTA'),
(48, 7, 'BOUKOUMBE'),
(49, 8, 'DATORI'),
(50, 8, 'KOUNTORI'),
(51, 8, 'TAPOGA'),
(52, 8, 'COBLY'),
(53, 9, 'BRIGNAMARO'),
(54, 9, 'FIROU'),
(55, 9, 'KAOBAGOU'),
(56, 9, 'KEROU'),
(57, 10, 'BIRNI'),
(58, 10, 'CHABI-COUMA'),
(59, 10, 'FOO-TANCE'),
(60, 10, 'GUILMARO'),
(61, 10, 'OROUKAYO'),
(62, 10, 'KOUANDE'),
(63, 11, 'DASSARI'),
(64, 11, 'GOUANDE'),
(65, 11, 'NODI'),
(66, 11, 'TANTEGA'),
(67, 11, 'TCHANHOUNCOSSI'),
(68, 11, 'MATERI'),
(69, 12, 'KOTOPOUNGA'),
(70, 12, 'KOUABA'),
(71, 12, 'KOUANDATA'),
(72, 12, 'PERMA'),
(73, 12, 'TCHOUMI-TCHOUMI'),
(74, 12, 'NATITINGOU I'),
(75, 12, 'NATITINGOU II'),
(76, 12, 'NATITINGOU III'),
(77, 12, 'PEPORIYAKOU'),
(78, 13, 'GNEMASSON'),
(79, 13, 'TOBRE'),
(80, 13, 'PEHUNCO'),
(81, 14, 'COTIAKOU'),
(82, 14, 'N\'DAHONTA'),
(83, 14, 'TAIACOU'),
(84, 14, 'TANONGOU'),
(85, 14, 'TANGUIETA'),
(86, 15, 'KOUARFA'),
(87, 15, 'TAMPEGRE'),
(88, 15, 'TOUKOUNTOUNA'),
(89, 16, 'AKASSATO'),
(90, 16, 'GODOMEY'),
(91, 16, 'GOLO-DJIGBE'),
(92, 16, 'HEVIE'),
(93, 16, 'KPANROUN'),
(94, 16, 'OUEDO'),
(95, 16, 'TOGBA'),
(96, 16, 'ZINVIE'),
(97, 16, 'ABOMEY-CALAVI'),
(98, 17, 'AGBANOU'),
(99, 17, 'AHOUANNONZOUN'),
(100, 17, 'ATTOGON'),
(101, 17, 'AVAKPA'),
(102, 17, 'AYOU'),
(103, 17, 'HINVI'),
(104, 17, 'LISSEGAZOUN'),
(105, 17, 'LON-AGONMEY'),
(106, 17, 'SEKOU'),
(107, 17, 'TOKPA'),
(108, 17, 'ALLADA CENTRE'),
(109, 17, 'TOGOUDO'),
(110, 18, 'AGANMALOME'),
(111, 18, 'AGBANTO'),
(112, 18, 'AGONKANME'),
(113, 18, 'DEDOME'),
(114, 18, 'DEKANME'),
(115, 18, 'SEGBEYA'),
(116, 18, 'SEGBOHOUE'),
(117, 18, 'TOKPA-DOME'),
(118, 18, 'KPOMASSE CENTRE'),
(119, 19, 'AVLEKETE'),
(120, 19, 'DJEGBADJI'),
(121, 19, 'GAKPE'),
(122, 19, 'HOUAKPE-DAHO'),
(123, 19, 'PAHOU'),
(124, 19, 'SAVI'),
(125, 19, 'OUIDAH I'),
(126, 19, 'OUIDAH II'),
(127, 19, 'OUIDAH III'),
(128, 19, 'OUIDAH IV'),
(129, 20, 'AHOMEY-LOKPO'),
(130, 20, 'DEKANMEY'),
(131, 20, 'GANVIE 1'),
(132, 20, 'GANVIE 2'),
(133, 20, 'HOUEDO-AGUEKON'),
(134, 20, 'VEKKY'),
(135, 20, 'SO-AVA'),
(136, 21, 'AGUE'),
(137, 21, 'COLLI'),
(138, 21, 'COUSSI'),
(139, 21, 'DAME'),
(140, 21, 'DJANGLANME'),
(141, 21, 'HOUEGBO'),
(142, 21, 'KPOME'),
(143, 21, 'SEHOUE'),
(144, 21, 'SEY'),
(145, 21, 'TOFFO'),
(146, 22, 'AVAME'),
(147, 22, 'AZOHOUE-ALIHO'),
(148, 22, 'AZOHOUE-CADA'),
(149, 22, 'TORI-CADA'),
(150, 22, 'TORI-GARE'),
(151, 22, 'TORI-BOSSITO'),
(152, 23, 'ADJAN'),
(153, 23, 'DAWE'),
(154, 23, 'DJIGBE'),
(155, 23, 'DODJI-BATA'),
(156, 23, 'HEKANME'),
(157, 23, 'KOUNDOKPOE'),
(158, 23, 'SEDJE-DENOU'),
(159, 23, 'SEDJE-HOUEGOUDO'),
(160, 23, 'TANGBO'),
(161, 23, 'YOKPO'),
(162, 23, 'ZE'),
(163, 24, 'BEROUBOUAY'),
(164, 24, 'BOUANRI'),
(165, 24, 'GAMIA'),
(166, 24, 'INA'),
(167, 24, 'BEMBEREKE'),
(168, 25, 'BASSO'),
(169, 25, 'BOUCA'),
(170, 25, 'DERASSI'),
(171, 25, 'DUNKASSA'),
(172, 25, 'PEONGA'),
(173, 25, 'KALALE'),
(174, 26, 'BORI'),
(175, 26, 'GBEGOUROU'),
(176, 26, 'OUENOU'),
(177, 26, 'SIRAROU'),
(178, 26, 'N\'DALI'),
(179, 27, 'BIRO'),
(180, 27, 'GNONKOUROKALI'),
(181, 27, 'OUENOU'),
(182, 27, 'SEREKALI'),
(183, 27, 'SUYA'),
(184, 27, 'TASSO'),
(185, 27, 'NIKKI'),
(186, 28, '1ER ARRONDISSEMENT'),
(187, 28, '2EME ARRONDISSEMENT'),
(188, 28, '3EME ARRONDISSEMENT'),
(189, 29, 'GNINSY'),
(190, 29, 'GUINAGOUROU'),
(191, 29, 'KPEBIE'),
(192, 29, 'PANE'),
(193, 29, 'SONTOU'),
(194, 29, 'PERERE'),
(195, 30, 'FO-BOURE'),
(196, 30, 'SEKERE'),
(197, 30, 'SIKKI'),
(198, 30, 'SINENDE'),
(199, 31, 'ALAFIAROU'),
(200, 31, 'BETEROU'),
(201, 31, 'GORO'),
(202, 31, 'KIKA'),
(203, 31, 'SANSON'),
(204, 31, 'TCHATCHOU'),
(205, 31, 'TCHAOUROU'),
(206, 32, 'AGOUA'),
(207, 32, 'AKPASSI'),
(208, 32, 'ATOKOLIBE'),
(209, 32, 'BOBE'),
(210, 32, 'GOUKA'),
(211, 32, 'KOKO'),
(212, 32, 'LOUGBA'),
(213, 32, 'PIRA'),
(214, 32, 'BANTE'),
(215, 33, 'AKOFFODJOULE'),
(216, 33, 'GBAFFO'),
(217, 33, 'KERE'),
(218, 33, 'KPINGNI'),
(219, 33, 'LEMA'),
(220, 33, 'PAOUINGNAN'),
(221, 33, 'SOCLOGBO'),
(222, 33, 'TRE'),
(223, 33, 'DASSA I'),
(224, 33, 'DASSA II'),
(225, 34, 'AKLAMPA'),
(226, 34, 'ASSANTE'),
(227, 34, 'GOME'),
(228, 34, 'KPAKPAZA'),
(229, 34, 'MAGOUMI'),
(230, 34, 'OUEDEME'),
(231, 34, 'SOKPONTA'),
(232, 34, 'THIO'),
(233, 34, 'ZAFFE'),
(234, 34, 'GLAZOUE'),
(235, 35, 'CHALLA-OGOI'),
(236, 35, 'DJEGBE'),
(237, 35, 'GBANLIN'),
(238, 35, 'IKEMON'),
(239, 35, 'KILIBO'),
(240, 35, 'LAMINOU'),
(241, 35, 'ODOUGBA'),
(242, 35, 'TOUI'),
(243, 35, 'OUESSE'),
(244, 36, 'DJALLOUKOU'),
(245, 36, 'DOUME'),
(246, 36, 'GOBADA'),
(247, 36, 'KPATABA'),
(248, 36, 'LAHOTAN'),
(249, 36, 'LEMA'),
(250, 36, 'LOGOZOHE'),
(251, 36, 'MONKPA'),
(252, 36, 'OTTOLA'),
(253, 36, 'OUESSE'),
(254, 36, 'TCHETTI'),
(255, 36, 'SAVALOU-AGA'),
(256, 36, 'SAVALOU-AGBADO'),
(257, 36, 'SAVALOU-ATTAKE'),
(258, 37, 'BESSE'),
(259, 37, 'KABOUA'),
(260, 37, 'OFFE'),
(261, 37, 'OKPARA'),
(262, 37, 'SAKIN'),
(263, 37, 'ADIDO'),
(264, 37, 'BONI'),
(265, 37, 'PLATEAU'),
(266, 38, 'ATOMEY'),
(267, 38, 'AZOVE'),
(268, 38, 'DEKPO-CENTRE'),
(269, 38, 'GODOHOU'),
(270, 38, 'KISSAMEY'),
(271, 38, 'LONKLY'),
(272, 38, 'APLAHOUE'),
(273, 39, 'ADJINTIMEY'),
(274, 39, 'BETOUMEY'),
(275, 39, 'GOHOMEY'),
(276, 39, 'HOUEGAMEY'),
(277, 39, 'KINKINHOUE'),
(278, 39, 'KOKOHOUE'),
(279, 39, 'KPOBA'),
(280, 39, 'SOKOUHOUE'),
(281, 39, 'DJAKOTOMEY I'),
(282, 39, 'DJAKOTOMEY II'),
(283, 40, 'AYOMI'),
(284, 40, 'DEVE'),
(285, 40, 'HONTON'),
(286, 40, 'LOKOGOHOUE'),
(287, 40, 'MADJRE'),
(288, 40, 'TOTCHANGNI CENTRE'),
(289, 40, 'TOTA'),
(290, 41, 'ADJAHONME'),
(291, 41, 'AHOGBEYA'),
(292, 41, 'AYAHOHOUE'),
(293, 41, 'DJOTTO'),
(294, 41, 'HONDJIN'),
(295, 41, 'LANTA'),
(296, 41, 'TCHIKPE'),
(297, 41, 'KLOUEKANME'),
(298, 42, 'ADOUKANDJI'),
(299, 42, 'AHODJINNAKO'),
(300, 42, 'AHOMADEGBE'),
(301, 42, 'BANIGBE'),
(302, 42, 'GNIZOUNME'),
(303, 42, 'HLASSAME'),
(304, 42, 'LOKOGBA'),
(305, 42, 'TCHITO'),
(306, 42, 'TOHOU'),
(307, 42, 'ZALLI'),
(308, 42, 'LALO'),
(309, 43, 'ADJIDO'),
(310, 43, 'AVEDJIN'),
(311, 43, 'DOKO'),
(312, 43, 'HOUEDOGLI'),
(313, 43, 'MISSINKO'),
(314, 43, 'TANNOU-GOLA'),
(315, 43, 'TOVIKLIN'),
(316, 44, 'ALEDJO'),
(317, 44, 'MANIGRI'),
(318, 44, 'PENESSOULOU'),
(319, 44, 'BASSILA'),
(320, 45, 'ANANDANA'),
(321, 45, 'PABEGOU'),
(322, 45, 'SINGRE'),
(323, 45, 'COPARGO'),
(324, 46, 'BAREI'),
(325, 46, 'BARIENOU'),
(326, 46, 'BELLEFOUNGOU'),
(327, 46, 'BOUGOU'),
(328, 46, 'KOLOCONDE'),
(329, 46, 'ONKLOU'),
(330, 46, 'PARTAGO'),
(331, 46, 'PELEBINA'),
(332, 46, 'SEROU'),
(333, 46, 'DJOUGOU I'),
(334, 46, 'DJOUGOU II'),
(335, 46, 'DJOUGOU III'),
(336, 47, 'BADJOUDE'),
(337, 47, 'KOMDE'),
(338, 47, 'SEMERE 1'),
(339, 47, 'SEMERE 2'),
(340, 47, 'TCHALINGA'),
(341, 47, 'OUAKE'),
(342, 48, '1ER ARRONDISSEMENT'),
(343, 48, '2EME ARRONDISSEMENT'),
(344, 48, '3EME ARRONDISSEMENT'),
(345, 48, '4EME ARRONDISSEMENT'),
(346, 48, '5EME ARRONDISSEMENT'),
(347, 48, '6EME ARRONDISSEMENT'),
(348, 48, '7EME ARRONDISSEMENT'),
(349, 48, '8EME ARRONDISSEMENT'),
(350, 48, '9EME ARRONDISSEMENT'),
(351, 48, '10EME ARRONDISSEMENT'),
(352, 48, '11EME ARRONDISSEMENT'),
(353, 48, '12EME ARRONDISSEMENT'),
(354, 48, '13EME ARRONDISSEMENT'),
(355, 49, 'ADOHOUN'),
(356, 49, 'ATCHANNOU'),
(357, 49, 'DEDEKPOE'),
(358, 49, 'KPINNOU'),
(359, 49, 'ATHIEME'),
(360, 50, 'AGBODJI'),
(361, 50, 'BADAZOUIN'),
(362, 50, 'GBAKPODJI'),
(363, 50, 'LOBOGO'),
(364, 50, 'POSSOTOME'),
(365, 50, 'YEGODOE'),
(366, 50, 'BOPA'),
(367, 51, 'AGATOGBO'),
(368, 51, 'AKODEHA'),
(369, 51, 'OUEDEME-PEDAH'),
(370, 51, 'OUMAKO'),
(371, 51, 'COME'),
(372, 52, 'ADJAHA'),
(373, 52, 'AGOUE'),
(374, 52, 'AVLO'),
(375, 52, 'DJANGLANMEY'),
(376, 52, 'GBEHOUE'),
(377, 52, 'SAZUE'),
(378, 52, 'GRAND-POPO'),
(379, 53, 'DAHE'),
(380, 53, 'DOUTOU'),
(381, 53, 'HONHOUE'),
(382, 53, 'ZOUNGBONOU'),
(383, 53, 'HOUEYOGBE'),
(384, 53, 'SE'),
(385, 54, 'AGAME'),
(386, 54, 'HOUIN'),
(387, 54, 'KOUDO'),
(388, 54, 'OUEDEME-ADJA'),
(389, 54, 'LOKOSSA'),
(390, 55, 'AGLOGBE'),
(391, 55, 'HONVIE'),
(392, 55, 'MALANHOUI'),
(393, 55, 'MEDEDJONOU'),
(394, 55, 'ADJARRA 1'),
(395, 55, 'ADJARRA 2'),
(396, 56, 'AKPADANOU'),
(397, 56, 'AWONOU'),
(398, 56, 'AZOWLISSE'),
(399, 56, 'DEME'),
(400, 56, 'GANGBAN'),
(401, 56, 'KODE'),
(402, 56, 'TOGBOTA'),
(403, 56, 'ADJOHOUN'),
(404, 57, 'AVAGBODJI'),
(405, 57, 'HOUEDOME'),
(406, 57, 'ZOUNGAME'),
(407, 58, 'GOME-SOTA'),
(408, 58, 'KATAGON'),
(409, 58, 'VAKON'),
(410, 58, 'ZOUNGBOME'),
(411, 58, 'AKPRO-MISSERETE'),
(412, 59, 'ATCHOUKPA'),
(413, 59, 'DJOMON'),
(414, 59, 'GBOZOUME'),
(415, 59, 'KOUTI'),
(416, 59, 'OUANHO'),
(417, 59, 'SADO'),
(418, 59, 'AVRANKOU'),
(419, 60, 'AFFAME'),
(420, 60, 'ATCHONSA'),
(421, 60, 'DAME-WOGON'),
(422, 60, 'HOUNVIGUE'),
(423, 60, 'BONOU'),
(424, 61, 'DEKIN'),
(425, 61, 'GBEKO'),
(426, 61, 'HOUEDOMEY'),
(427, 61, 'HOZIN'),
(428, 61, 'KESSOUNOU'),
(429, 61, 'ZOUNGUE'),
(430, 61, 'DANGBO'),
(431, 62, '1ER ARRONDISSEMENT'),
(432, 62, '2EME ARRONDISSEMENT'),
(433, 62, '3EME ARRONDISSEMENT'),
(434, 62, '4EME ARRONDISSEMENT'),
(435, 62, '5EME ARRONDISSEMENT'),
(436, 63, 'AGBLANGANDAN'),
(437, 63, 'AHOLOUYEME'),
(438, 63, 'DJEREGBE'),
(439, 63, 'EKPE'),
(440, 63, 'TOHOUE'),
(441, 63, 'SEME-PODJI'),
(442, 64, 'IKPINLE'),
(443, 64, 'KPOULOU'),
(444, 64, 'MASSE'),
(445, 64, 'OKO-AKARE'),
(446, 64, 'TATONNONKON'),
(447, 64, 'ADJA-OUERE'),
(448, 65, 'BANIGBE'),
(449, 65, 'DAAGBE'),
(450, 65, 'KO-KOUMOLOU'),
(451, 65, 'LAGBE'),
(452, 65, 'TCHAADA'),
(453, 65, 'IFANGNI'),
(454, 66, 'ADAKPLAME'),
(455, 66, 'IDIGNY'),
(456, 66, 'KPANKOU'),
(457, 66, 'ODOMETA'),
(458, 66, 'OKPOMETA'),
(459, 66, 'KETOU'),
(460, 67, 'AHOYEYE'),
(461, 67, 'IGANA'),
(462, 67, 'ISSABA'),
(463, 67, 'TOWE'),
(464, 67, 'POBE'),
(465, 68, 'AGUIDI'),
(466, 68, 'ITA-DJEBOU'),
(467, 68, 'TAKON'),
(468, 68, 'YOKO'),
(469, 68, 'SAKETE 1'),
(470, 68, 'SAKETE 2'),
(471, 69, 'AGBOKPA'),
(472, 69, 'DETOHOU'),
(473, 69, 'SEHOUN'),
(474, 69, 'ZOUNZONME'),
(475, 69, 'DJEGBE'),
(476, 69, 'HOUNLI'),
(477, 69, 'VIDOLE'),
(478, 70, 'ADANHONDJIGO'),
(479, 70, 'ADINGNIGON'),
(480, 70, 'KINTA'),
(481, 70, 'KPOTA'),
(482, 70, 'LISSAZOUNME'),
(483, 70, 'SAHE'),
(484, 70, 'SINWE'),
(485, 70, 'TANVE'),
(486, 70, 'ZOUNGOUNDO'),
(487, 70, 'AGBANGNIZOUN'),
(488, 71, 'AGONGOINTO'),
(489, 71, 'AVOGBANNA'),
(490, 71, 'GNIDJAZOUN'),
(491, 71, 'LISSEZOUN'),
(492, 71, 'OUASSAHO'),
(493, 71, 'PASSAGON'),
(494, 71, 'SACLO'),
(495, 71, 'SODOHOME'),
(496, 71, 'BOHICON I'),
(497, 71, 'BOHICON II'),
(498, 72, 'HOUEKO'),
(499, 72, 'ADOGBE'),
(500, 72, 'GOUNLI'),
(501, 72, 'HOUIN-HOUNSO'),
(502, 72, 'LAINTA-COGBE'),
(503, 72, 'NAOGON'),
(504, 72, 'SOLI'),
(505, 72, 'ZOGBA'),
(506, 73, 'AGONDJI'),
(507, 73, 'AGOUNA'),
(508, 73, 'DAN'),
(509, 73, 'DOHOUIME'),
(510, 73, 'GOBAIX'),
(511, 73, 'HOUTO'),
(512, 73, 'MONSOUROU'),
(513, 73, 'MOUGNON'),
(514, 73, 'OUMBEGAME'),
(515, 73, 'SETTO'),
(516, 73, 'ZOUNKON'),
(517, 73, 'DJIDJA CENTRE'),
(518, 74, 'DASSO'),
(519, 74, 'SAGON'),
(520, 74, 'TOHOUES'),
(521, 74, 'OUINHI CENTRE'),
(522, 75, 'AGONLIN-HOUEGBO'),
(523, 75, 'BANAME'),
(524, 75, 'DON-TAN'),
(525, 75, 'DOVI'),
(526, 75, 'KPEDEKPO'),
(527, 75, 'ZAGNANADO CENTRE'),
(528, 76, 'ALLAHE'),
(529, 76, 'ASSANLIN'),
(530, 76, 'HOUNGOME'),
(531, 76, 'KPAKPAME'),
(532, 76, 'KPOZOUN'),
(533, 76, 'ZA-TANTA'),
(534, 76, 'ZEKO'),
(535, 76, 'ZA-KPOTA'),
(536, 77, 'AKIZA'),
(537, 77, 'AVLAME'),
(538, 77, 'CANA I'),
(539, 77, 'CANA II'),
(540, 77, 'DOME'),
(541, 77, 'KOUSSOUKPA'),
(542, 77, 'KPOKISSA'),
(543, 77, 'MASSI'),
(544, 77, 'TANWE-HESSOU'),
(545, 77, 'ZOUKOU'),
(546, 77, 'ZOGBODOMEY CENTRE');

-- --------------------------------------------------------

--
-- Structure de la table `audience`
--

DROP TABLE IF EXISTS `audience`;
CREATE TABLE IF NOT EXISTS `audience` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `date_date_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_audience` datetime DEFAULT NULL,
  `avis_audience` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentaire` longtext COLLATE utf8mb4_unicode_ci,
  `date` datetime DEFAULT NULL,
  `heure_audience` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FDCD941881703196` (`date_date_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avis_paquet`
--

DROP TABLE IF EXISTS `avis_paquet`;
CREATE TABLE IF NOT EXISTS `avis_paquet` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `avis` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_672321A0611C0C56` (`dossier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commune`
--

DROP TABLE IF EXISTS `commune`;
CREATE TABLE IF NOT EXISTS `commune` (
  `id` int NOT NULL AUTO_INCREMENT,
  `departement_id` int DEFAULT NULL,
  `libcom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E2E2D1EECCF9E01E` (`departement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commune`
--

INSERT INTO `commune` (`id`, `departement_id`, `libcom`) VALUES
(1, 1, 'BANIKOARA'),
(2, 1, 'GOGOUNOU'),
(3, 1, 'KANDI'),
(4, 1, 'KARIMAMA'),
(5, 1, 'MALANVILLE'),
(6, 1, 'SEGBANA'),
(7, 2, 'BOUKOUMBE'),
(8, 2, 'COBLY'),
(9, 2, 'KEROU'),
(10, 2, 'KOUANDE'),
(11, 2, 'MATERI'),
(12, 2, 'NATITINGOU'),
(13, 2, 'OUASSA-PEHUNCO'),
(14, 2, 'TANGUIETA'),
(15, 2, 'TOUKOUNTOUNA'),
(16, 3, 'ABOMEY-CALAVI'),
(17, 3, 'ALLADA'),
(18, 3, 'KPOMASSE'),
(19, 3, 'OUIDAH'),
(20, 3, 'SO-AVA'),
(21, 3, 'TOFFO'),
(22, 3, 'TORI-BOSSITO'),
(23, 3, 'ZE'),
(24, 4, 'BEMBEREKE'),
(25, 4, 'KALALE'),
(26, 4, 'N\'DALI'),
(27, 4, 'NIKKI'),
(28, 4, 'PARAKOU'),
(29, 4, 'PERERE'),
(30, 4, 'SINENDE'),
(31, 4, 'TCHAOUROU'),
(32, 5, 'BANTE'),
(33, 5, 'DASSA-ZOUME'),
(34, 5, 'GLAZOUE'),
(35, 5, 'OUESSE'),
(36, 5, 'SAVALOU'),
(37, 5, 'SAVE'),
(38, 6, 'APLAHOUE'),
(39, 6, 'DJAKOTOMEY'),
(40, 6, 'DOGBO'),
(41, 6, 'KLOUEKANMEY'),
(42, 6, 'LALO'),
(43, 6, 'TOVIKLIN'),
(44, 7, 'BASSILA'),
(45, 7, 'COPARGO'),
(46, 7, 'DJOUGOU'),
(47, 7, 'OUAKE'),
(48, 8, 'COTONOU'),
(49, 9, 'ATHIEME'),
(50, 9, 'BOPA'),
(51, 9, 'COME'),
(52, 9, 'GRAND-POPO'),
(53, 9, 'HOUEYOGBE'),
(54, 9, 'LOKOSSA'),
(55, 10, 'ADJARRA'),
(56, 10, 'ADJOHOUN'),
(57, 10, 'AGUEGUES'),
(58, 10, 'AKPRO-MISSERETE'),
(59, 10, 'AVRANKOU'),
(60, 10, 'BONOU'),
(61, 10, 'DANGBO'),
(62, 10, 'PORTO-NOVO'),
(63, 10, 'SEME-PODJI'),
(64, 11, 'ADJA-OUERE'),
(65, 11, 'IFANGNI'),
(66, 11, 'KETOU'),
(67, 11, 'POBE'),
(68, 11, 'SAKETE'),
(69, 12, 'ABOMEY'),
(70, 12, 'AGBANGNIZOUN'),
(71, 12, 'BOHICON'),
(72, 12, 'COVE'),
(73, 12, 'DJIDJA'),
(74, 12, 'OUINHI'),
(75, 12, 'ZAGNANADO'),
(76, 12, 'ZA-KPOTA'),
(77, 12, 'ZOGBODOMEY');

-- --------------------------------------------------------

--
-- Structure de la table `conseiller_partie`
--

DROP TABLE IF EXISTS `conseiller_partie`;
CREATE TABLE IF NOT EXISTS `conseiller_partie` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `partie_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `nom_cabinet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_avocat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom_avocat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_avocat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C90F7691E075F7A4` (`partie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `conseiller_partie`
--

INSERT INTO `conseiller_partie` (`id`, `partie_id`, `nom_cabinet`, `nom_avocat`, `prenom_avocat`, `telephone`, `email`, `adresse_avocat`, `created_at`, `update_at`) VALUES
(0x0194843582e175528622352521b1b1d0, 0x0194843582e077fea1bc68f938369b36, 'SCPA 2H', 'SCPA 2H', 'SCPA 2H', '11111111', 'w.araba@hotmail.fr', 'Zobadjé', NULL, NULL),
(0x01967751f5657e95aa6c4d9014785412, 0x01967751f55c7edc92c185c1b29aab23, 'Structure Juridique', 'SALAMI', 'Mohamed', '0198751423', 'mohamed@gmail.com', 'Cotonou', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `date`
--

DROP TABLE IF EXISTS `date`;
CREATE TABLE IF NOT EXISTS `date` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `deliberation_dossiers`
--

DROP TABLE IF EXISTS `deliberation_dossiers`;
CREATE TABLE IF NOT EXISTS `deliberation_dossiers` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `avis_deliberation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_53ED245B611C0C56` (`dossier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lib_dep` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id`, `lib_dep`) VALUES
(1, 'ALIBORI'),
(2, 'ATACORA'),
(3, 'ATLANTIQUE'),
(4, 'BORGOU'),
(5, 'COLLINES'),
(6, 'COUFFO'),
(7, 'DONGA'),
(8, 'LITTORAL'),
(9, 'MONO'),
(10, 'OUEME'),
(11, 'PLATEAU'),
(12, 'ZOU');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dossier`
--

DROP TABLE IF EXISTS `dossier`;
CREATE TABLE IF NOT EXISTS `dossier` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `objet_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `provenance_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `requerant_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `defendeur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `created_by_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `reference_enregistrement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  `type_dossier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_dossier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intitule_objet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_dossier_complet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat_dossier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ouverture` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autorisation` tinyint(1) DEFAULT NULL,
  `clos` tinyint(1) DEFAULT NULL,
  `date_cloture` date DEFAULT NULL,
  `motif_cloture` longtext COLLATE utf8mb4_unicode_ci,
  `arrete_attaquee` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consignation` tinyint(1) DEFAULT NULL,
  `recu_consignation` tinyint(1) DEFAULT NULL,
  `memoire_ampliatif` tinyint(1) DEFAULT NULL,
  `date_memoire_ampliatif` datetime DEFAULT NULL,
  `memoire_en_defense` tinyint(1) DEFAULT NULL,
  `date_memoire_en_defense` datetime DEFAULT NULL,
  `date_consignation` date DEFAULT NULL,
  `date_preuve_consignation_requerant` date DEFAULT NULL COMMENT '(DC2Type:date_immutable)',
  `preuve_consignation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preuve_consignation_requerant` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_memoire_ampliatif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_memoire_en_defense` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_suivi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `externe` tinyint(1) DEFAULT NULL,
  `annotation` longtext COLLATE utf8mb4_unicode_ci,
  `date_autorisation` datetime DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calendrier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rapport_cr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation_description_requerante` longtext COLLATE utf8mb4_unicode_ci,
  `observation_fichier_requerante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation_description_defendeur` longtext COLLATE utf8mb4_unicode_ci,
  `observation_fichier_defendeur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rapport_description_cr` longtext COLLATE utf8mb4_unicode_ci,
  `fin_mesures_instruction` tinyint(1) DEFAULT NULL,
  `fin_mesures_instruction_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3D48E037F520CF5A` (`objet_id`),
  KEY `IDX_3D48E0372534008B` (`structure_id`),
  KEY `IDX_3D48E037C24AFBDB` (`provenance_id`),
  KEY `IDX_3D48E0374A93DAA5` (`requerant_id`),
  KEY `IDX_3D48E03730AA44A2` (`defendeur_id`),
  KEY `IDX_3D48E037B03A8386` (`created_by_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dossier`
--

INSERT INTO `dossier` (`id`, `objet_id`, `structure_id`, `provenance_id`, `requerant_id`, `defendeur_id`, `created_by_id`, `reference_enregistrement`, `date_enregistrement`, `type_dossier`, `reference_dossier`, `intitule_objet`, `reference_dossier_complet`, `etat_dossier`, `date_ouverture`, `created_at`, `updated_at`, `nature`, `autorisation`, `clos`, `date_cloture`, `motif_cloture`, `arrete_attaquee`, `consignation`, `recu_consignation`, `memoire_ampliatif`, `date_memoire_ampliatif`, `memoire_en_defense`, `date_memoire_en_defense`, `date_consignation`, `date_preuve_consignation_requerant`, `preuve_consignation`, `preuve_consignation_requerant`, `url_memoire_ampliatif`, `url_memoire_en_defense`, `code_suivi`, `externe`, `annotation`, `date_autorisation`, `statut`, `calendrier`, `rapport_cr`, `observation_description_requerante`, `observation_fichier_requerante`, `observation_description_defendeur`, `observation_fichier_defendeur`, `rapport_description_cr`, `fin_mesures_instruction`, `fin_mesures_instruction_at`) VALUES
(0x0194843582e077fea1bc68f937e43c87, 0x0191ae521f867b0a882b85f87316eedc, 0x0191ae417a7373ec9e2d67ba9adab788, NULL, 0x0194843582e077fea1bc68f938369b36, 0x0194843610fb770babf4ab1bb62fe69e, 0x019247decd437f328344f05ee9731722, NULL, '2025-01-20 14:57:05', NULL, 'N°2024-122/C.J-CM', NULL, NULL, 'OUVERT', '2025-01-20 15:04:05', NULL, NULL, NULL, 1, NULL, NULL, NULL, 'Arrêt n°033/CM/2023 du 30 Mars 2023', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'hVHYOhC', 1, 'GEC ouvrir dossier', '2025-01-20 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0x01955bc52dc671ce9c69e837f752086a, 0x0191ae5155ab7b359e4bc3823e046c34, 0x0191ae4201167fab94810a32b44f2ec4, NULL, 0x01955bc52dc773f0a6613057991bb0b9, 0x01955bc6673675c28f71ea8c7c70c93d, 0x019247decd437f328344f05ee9731722, 'DJMC1234', '2025-03-03 00:00:00', 'ordinaire', 'N°2025-122/D.J-M.O', 'Ordinaire', NULL, 'CONCLUSION DISPONIBLE', '2025-03-03 12:44:30', NULL, NULL, NULL, 1, NULL, NULL, NULL, 'Arrêt n°039/CM/2023 du 30 Mars 2024', 0, NULL, 0, '0000-00-00 00:00:00', 0, NULL, '0000-00-00', NULL, 'N02025-122-D-J-M-O-67c618bdc06a7.pdf', NULL, 'N02025-122-D-J-M-O-67c622165764e.pdf', NULL, 'V0Owgym', 1, 'GEC ouvrir le dossier', '2025-03-03 00:00:00', 'Dossier au Rôle', 'calendrier/Certificat-de-naissance-67fd8aacd770c.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(0x019565b3c2f9743f9f0d270d6d71e732, 0x0191ae5155ab7b359e4bc3823e046c34, 0x0191ae4201167fab94810a32b44f2ec4, NULL, 0x019565b3c2fa7a4b9525039c38918d40, 0x019565b4e6157f5e90ea5a9c87e7e00e, 0x019247decd437f328344f05ee9731722, 'N2571A12', '2025-03-05 00:00:00', 'ordinaire', 'N°2025-05-03-/D.D-P.A', 'Administrative', 'N°2025-05-03-/D.D-P.A/CA', 'AFFECTE', '2025-03-05 10:30:06', NULL, NULL, NULL, 1, NULL, NULL, NULL, 'N° 91-11.900', 1, 1, 1, '2025-03-07 00:00:00', 1, '0000-00-00 00:00:00', '2025-04-20', '2025-04-29', 'consignations/preuve_consignation_019565b3-c2f9-743f-9f0d-270d6d71e732-68045321d2cd3.pdf', 'piecesJointes/N°2025-05-03-/D.D-P.A-6811576c59273.pdf', '', 'N02025-05-03-D-D-P-A-67c838b1b99de.pdf\r\n', 'NPEdiNI', 1, 'GEC ouverture du dossier', '2025-03-05 00:00:00', 'Dossier au Rôle', 'calendrier/Carte d\'identité 1.pdf', 'N02025-05-03-D-D-P-A-67c85f78ee51a.pdf', NULL, NULL, NULL, NULL, 'A trancher', 1, '2025-03-05 14:28:07'),
(0x01967751f55b7c56ac4ef1736bae2c1d, 0x0191ae521f867b0a882b85f87316eedc, 0x0191ae4201167fab94810a32b44f2ec4, NULL, 0x01967751f55c7edc92c185c1b29aab23, 0x0196775319e67b3a94b0c385943f0093, 0x019247decd437f328344f05ee9731722, 'N2871C13', '2025-04-27 00:00:00', 'ordinaire', 'N°2025-05-27-/I.A-B.R ', 'Administrative', 'N°2025-05-27-/I.A-B.R ', 'OUVERT', '2025-04-27 17:03:01', NULL, NULL, NULL, 1, NULL, NULL, NULL, 'Arrêt n°040/LB/2023 du 27 Avril 2025', 0, 0, 0, '0000-00-00 00:00:00', 0, NULL, '0000-00-00', '0000-00-00', '', '', '', NULL, 'wKjuRFR', 1, 'GEC ouvrir le dossier', '2025-04-27 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `dossier_audience`
--

DROP TABLE IF EXISTS `dossier_audience`;
CREATE TABLE IF NOT EXISTS `dossier_audience` (
  `dossier_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `audience_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  PRIMARY KEY (`dossier_id`,`audience_id`),
  KEY `IDX_D58D766F611C0C56` (`dossier_id`),
  KEY `IDX_D58D766F848CC616` (`audience_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dossier_pieces_jointes`
--

DROP TABLE IF EXISTS `dossier_pieces_jointes`;
CREATE TABLE IF NOT EXISTS `dossier_pieces_jointes` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4B2B8238611C0C56` (`dossier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dossier_pieces_jointes`
--

INSERT INTO `dossier_pieces_jointes` (`id`, `dossier_id`, `name`, `url`) VALUES
(0x019484379f197c33851254fd2d301796, 0x0194843582e077fea1bc68f937e43c87, 'Acte de Pouvoir', 'Acte-de-Pourvoi-n-27-678e64414456d.pdf'),
(0x019484379f197c33851254fd2de6dfa1, 0x0194843582e077fea1bc68f937e43c87, 'Arrêt attaqué', 'ARRETN-033CM2023-Cour-d-Appel-de-Cotonou-678e644145492.pdf'),
(0x019484379f197c33851254fd2e6c4dcd, 0x0194843582e077fea1bc68f937e43c87, 'Jugement', 'JUGEMENT-N-007-TPI-PC-Cotonou-678e6441466ef.pdf'),
(0x0194845be071764ba9fcc4314ebc9479, 0x019484568c83775ebc5d838133d4004b, 'Acte de pourvoi', 'ORDONNANCE-2025-004-DE-BANSOU-CHERIFATOU-678e6d89469b7.pdf'),
(0x01954d553f287f01ba2e756369577c21, 0x01954d505cee728e963fc927a1029883, 'Pièce d\'identité', 'chiro-67c1e26754791.png'),
(0x01955bc894527071aed16a01085eac8a, 0x01955bc52dc671ce9c69e837f752086a, 'Carte d\'identité', 'Carte-d-identite-recto-verso-67c5939a91fa5.pdf'),
(0x01955bc894537cb7ad2fe8451ed53749, 0x01955bc52dc671ce9c69e837f752086a, 'Certificat de naissance', 'Certificat-de-naissance-67c5939aa5ebb.pdf'),
(0x019565ba6c577908a7c6e4e46c5f3c08, 0x019565b3c2f9743f9f0d270d6d71e732, 'Carte d\'identité', 'Carte-d-identite-recto-verso-67c81f5705b01.pdf'),
(0x019565ba6c587ecd90f941f30415528f, 0x019565b3c2f9743f9f0d270d6d71e732, 'Certificat de naissance', 'Certificat-de-naissance-67c81f57181dd.pdf'),
(0x01967756224a742188d56c93aac489aa, 0x01967751f55b7c56ac4ef1736bae2c1d, 'Carte d\'identité', 'piecesJointes/Cartedidentit1-680e5c92ba998.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `user_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `level` smallint NOT NULL,
  `level_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F3F68C5A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `log`
--

INSERT INTO `log` (`id`, `user_id`, `message`, `context`, `level`, `level_name`, `extra`, `created_at`) VALUES
(0x01948439852a718bb9facb85531c2380, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-20 14:59:09'),
(0x0194843aab9d7add9c79b22de6d101df, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-20 15:00:25'),
(0x0194843bf38279c894e5e90c23e4eda4, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-20 15:01:49'),
(0x0194843ea6d977c1a82fb02f0cd52bbe, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-20 15:04:46'),
(0x019484506c567cb0a03b8c4af9f22d36, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:13:\"10.102.10.252\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-20 15:24:10'),
(0x0194845f989c77c8b9759b7a5faccca8, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-20 15:40:45'),
(0x01948463a85670848ea4428f47ce23c7, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-20 15:45:11'),
(0x019484668dc2769e928a713dc65fee53, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-20 15:48:21'),
(0x01948469c94076f5a2d43550a753084f, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-20 15:51:52'),
(0x019488ee177b7eb99279cb6643f3f885, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:13:\"10.102.10.252\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-21 12:54:52'),
(0x019488fdd6c772ff86083345c0760f78, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-21 13:12:04'),
(0x019489102ffe722889d66c5328fff206, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:12:\"41.216.47.50\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-01-21 13:32:07'),
(0x01953c93096b7a5d8821758ef4e648b8, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-25 10:07:04'),
(0x01953cbd05b97ce686de2cb4d7489250, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-25 10:52:55'),
(0x01953cc2ce1973c7bc7ecf8b0f09f17a, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-25 10:59:14'),
(0x01953cc2efc47c259d424991e3c2d1e6, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-25 10:59:23'),
(0x01953da243207aa3bba0f7836fa988e9, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-25 15:03:19'),
(0x01953dc45214756d902c68fcf4d684c8, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-25 15:40:31'),
(0x01954d3060ab77c8ab55ab88653d545a, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-28 15:32:50'),
(0x01954d6ab905713c9851aea58d23c07e, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-28 16:36:34'),
(0x01954d7142bb7e68b446d96062a72fbe, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-28 16:43:43'),
(0x01954d786f5e78499432a52ef8ae49db, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-02-28 16:51:33'),
(0x019550cf42c376d08464e4c1374566d4, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-01 08:25:15'),
(0x019550d0f1097ba4bbe4869040dcbefb, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-01 08:27:05'),
(0x019550d1853a7feeb9c4df857a4a72f1, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-01 08:27:43'),
(0x019550d1a07a7d85b9f9c947750f038a, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-01 08:27:50'),
(0x019550d28d9272a79894dd123870b850, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-01 08:28:50'),
(0x019551c664f57484a1723602afb44404, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-01 12:55:11'),
(0x0195521b1ea97ef080feaa071816ddc8, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-01 14:27:43'),
(0x01955231a4547485bd8ef5606d80f2d4, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-01 14:52:19'),
(0x01955bd0283d7856bea4463803e2436d, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 11:42:03'),
(0x01955bd139b773a0942b6fcc7412a060, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 11:43:13'),
(0x01955bd9c7b974ddb8b52e4073097504, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 11:52:33'),
(0x01955be7af9576b0b1704de13035ce50, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 12:07:45'),
(0x01955becbc5f7cbfbb3c3d5b293263b7, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 12:13:16'),
(0x01955bf0eb937fcaa06c92ccba858a4f, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 12:17:50'),
(0x01955bf58b4c7a31988c4b7773f2f11f, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 12:22:53'),
(0x01955c01abe87128877257e58ee4c323, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 12:36:08'),
(0x01955c05a50f7275a15937359623630b, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 12:40:28'),
(0x01955c17bfc17c2782b6f9d4ba18ffa3, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 13:00:15'),
(0x01955c1ab3b67059bb01fb13a6304868, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 13:03:28'),
(0x01955c2513487e4ab2d72a768ea73977, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 13:14:48'),
(0x01955c25b9f074fd85c4043a83421c64, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 13:15:31'),
(0x01955c382e587da6b9690705fb5347df, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 13:35:40'),
(0x01955c38f66b72119541d221e47e7a43, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 13:36:31'),
(0x01955c5ef2c57ff594b3fcbc698fbe91, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 14:18:01'),
(0x01955c6be9fc7254aa0e6c8537d5eae2, NULL, 'Notre premier log', 'a:0:{}', 200, 'INFO', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 14:32:11'),
(0x01955ce8db1b7374a1371afa404d9844, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 16:48:39'),
(0x01955cecbb36772e8ef815cd9536c206, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 16:52:53'),
(0x01955dd926017f1ba46d9037eaaa9b89, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 21:11:07'),
(0x01955de6b1d67d6182b05b088edabddf, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 21:25:54'),
(0x01955e0041c07fa29ace668c9123b08f, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 21:53:50'),
(0x01955e02e69c704bbce2ae6c6831a420, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 21:56:43'),
(0x01955e378fb57f5fab3e45569e171abf, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 22:54:14'),
(0x01955e3ae97f7e2aa4df5559696b62c6, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 22:57:54'),
(0x01955e3dcb987e598d2466ffa1adb54a, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 23:01:03'),
(0x01955e40ec7279c0becc1619485aa922, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 23:04:28'),
(0x01955e43907f7164afbd7de66e6d0c19, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-03 23:07:21'),
(0x0195604c890a7618a7e6a775ab1cdde4, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 08:36:23'),
(0x01956060fe147d8a8fd9688914c4268c, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 08:58:44'),
(0x0195607234847ff18fe62b259fd2bd75, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 09:17:32'),
(0x019561788c8e7ec3a19d14e26fdcb04a, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 14:04:05'),
(0x0195617cbc1074729db62f136a17b4de, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 14:08:39'),
(0x019561822bcc7dafb901d4ad7ea9dc9e, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 14:14:35'),
(0x01956184220d7e49a62c006859846fc8, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 14:16:44'),
(0x01956187ab4d7e3891adf11100661960, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 14:20:36'),
(0x019561a32ab5714d90ceed89a2fc64cc, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 14:50:38'),
(0x019561fcd1067016986cb3ab127befdf, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 16:28:33'),
(0x0195636ee218730e967ccf88c4a39679, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-04 23:12:46'),
(0x019565be4ec479bfbd12afabc675d637, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 09:58:45'),
(0x019565bf3eeb7f749f29a97779d9ed93, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 09:59:47'),
(0x019565d5aceb7a738a829f06a82cd1a0, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 10:24:17'),
(0x019565d850527e85aa2d2a56b777e332, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 10:27:10'),
(0x019565dcf49c750796f2692c8b7ef068, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 10:32:14'),
(0x019565e00e397b16a2c184ea48e9e9df, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 10:35:37'),
(0x019565e51b10767198f0a998eaf3f463, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 10:41:08'),
(0x019565ede5d07896ab788de67e69ad7f, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 10:50:44'),
(0x019565f161d77c80a35ca95e60b4eb7d, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 10:54:32'),
(0x0195660401a376339a8712da0488f5d8, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 11:14:53'),
(0x01956605f6f575b1b6eb781e234c4d9c, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 11:17:01'),
(0x019566088bc67e7d8172612a887396c6, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 11:19:50'),
(0x0195660cd6d476c99f4aa52a97748a75, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 11:24:32'),
(0x0195660f6a06751f8d2469e68d7c5154, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 11:27:21'),
(0x0195661408e67d5a92cbc975408529be, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 11:32:23'),
(0x0195661949ef71018747147beb4f73cf, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 11:38:08'),
(0x019566428dc77ab1809f88027a6ba82b, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 12:23:12'),
(0x0195664513677cfe9f27ada13fc80126, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 12:25:57'),
(0x0195664812cb7f9e960f74db25cf39c9, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 12:29:14'),
(0x01956649aa617785a6647ad9c4cd0743, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 12:30:58'),
(0x0195664c1738729b8f66c3c88a8d60fa, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 12:33:37'),
(0x019566a0835e78ae98b2eb26cedfceef, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 14:05:50'),
(0x019566a89bed7d468b24c07eccd74a32, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 14:14:40'),
(0x019566b830567fe8a71bb559272828a9, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 14:31:41'),
(0x019566b8b598749fa4bb743b78b3bfcc, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 14:32:16'),
(0x019566b973e774adbc396cf64470b32b, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 14:33:04'),
(0x019566bb2f927fc98fbabeae575e487f, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 14:34:58'),
(0x019566d064dc703e9652f81bf42d7d23, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 14:58:08'),
(0x019566e1eb497920966482af4d2ddd41, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-05 15:17:16'),
(0x019575f1d45a7e37bd70fd287eb3901b, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-08 13:28:57'),
(0x019575f489117403b2689a09eb1de941, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-08 13:31:55'),
(0x019576ce2aed773293104a1d73f62723, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-08 17:29:37'),
(0x019576d077287c9ebb28a92e669dccaf, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-08 17:32:08'),
(0x01957c80fc32719dbcee8adf9f079285, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-09 20:03:02'),
(0x01957f7419107d65bb9bbca903721867, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-10 09:47:49'),
(0x0195804530f673c9b6e9bedbf859edf9, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-10 13:36:13'),
(0x0195809b60767865bc660edceeabe69f, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-10 15:10:21'),
(0x019581c83773707189e2dd06e87fce59, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-10 20:38:57'),
(0x0195846104fb79309bdafb0f2c22279c, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-11 08:45:05'),
(0x0195846184e073ec9317772d1cfc2cc2, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-11 08:45:38'),
(0x019585aaa095795abe3b1f15928777e8, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-11 14:45:06'),
(0x01958f087cc97f67b9462400ac0bfa49, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-13 10:24:13'),
(0x01958f08fbbb7f648e4e9fa8fa473829, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-13 10:24:45'),
(0x019594137cb47293be5c6f288c951455, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-14 09:54:19'),
(0x01959413b7477e068fd5f7e0a60a949b, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-14 09:54:34'),
(0x01959e34cd2c76479220a5804562171f, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-16 09:06:55'),
(0x01959fe0ce437165bdee8790b69443d3, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-16 16:54:25'),
(0x0195a33aa1497a189abfc79c021f74fa, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-17 08:31:23'),
(0x0195a44de42a7005b98eddccf6d19e33, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-17 13:32:02'),
(0x0195a44e0ef57a80976e3f5f8bf43d9d, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-17 13:32:13'),
(0x0195a44fb98179a19b3d0919faba5cab, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-17 13:34:03'),
(0x0195a455e7177f3f9a0ceba69729efae, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-17 13:40:48'),
(0x0195a469886371869dc2cd966eee7d4a, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-17 14:02:14'),
(0x0195a49fb1907fa2b82393b889b3642d, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-17 15:01:23'),
(0x0195a4a018177c9781fdc974c9b3df74, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-17 15:01:50'),
(0x0195a6033db674a49c20676c8da06c5d, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-17 21:29:45'),
(0x0195af12eff07c10b583f7ed0f5bcb5b, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-19 15:43:28'),
(0x0195b385fa17779280efba53acb760d4, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-20 12:27:36'),
(0x0195b7f7215677cd8bf467bb3aea8df1, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-21 09:09:41'),
(0x0195ccaaf92d75dcade58dfbee310651, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-25 09:38:31'),
(0x0195cdf03fcf77ebb379f90dd9e8738d, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-25 15:33:49'),
(0x0195cf15f6e679aa8d8ca60e38530ef8, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-25 20:54:38'),
(0x0195cf22cd8d7620a4680bb6fa77ae95, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-25 21:08:39'),
(0x0195cf5f780d7e4c8f567b62e385896b, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-25 22:14:55'),
(0x0195d1ca65e27e14a02b1af504184644, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-26 09:30:57'),
(0x0195d231611571e1af00f15c313d84cb, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-26 11:23:26'),
(0x0195d2fefbb972418bc7a9e4926cde37, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-26 15:08:00'),
(0x0195d3696616774d9c93eb57cbd4431b, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-26 17:04:14'),
(0x0195d370cdd679fb93cb15a70de8891c, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-26 17:12:20'),
(0x0195d80de4e777ceb500dbf306cc5038, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-27 14:42:24'),
(0x0195d814c7477a849f0ea8addb4d0d01, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-03-27 14:49:55'),
(0x0195f592764970c7a3f93228301abfc1, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-02 08:16:11'),
(0x0195f5f5e57b720e98bed79e1096269a, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-02 10:04:47'),
(0x0195faa4f1ad75499a90b1b03ef4e4cb, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-03 07:54:28'),
(0x0195fff5d6b87538a14fc3dcff23bb19, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-04 08:40:56'),
(0x0195fff66ce27aecb5629bd24921f4cb, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-04 08:41:34'),
(0x01960088fab07c9b9de14392d12c9b51, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-04 11:21:39'),
(0x0196014658be7aa4a34ca3f128177de3, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-04 14:48:29'),
(0x0196014727a0770e96546c82aacf67f3, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-04 14:49:22'),
(0x01960cbdada8748bb1f4cf90972aa116, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-06 20:14:39'),
(0x01960f97436d7e1b9a765070ded41f44, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-07 09:31:33'),
(0x01961524722f74599310ed7b4471ba60, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-08 11:23:52'),
(0x0196152553ec7325a21b5a6fe5390b31, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-08 11:24:50'),
(0x0196157247af72aa8a4cfa814911b513, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-08 12:48:53'),
(0x019617ae717a72f98648434e4f6cd6bc, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-08 23:13:50'),
(0x019619ae1fb879018e6f6df4d0bc208d, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-09 08:32:43'),
(0x0196251cf9ca78798aceb700cc5653fc, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-11 13:49:38'),
(0x0196317644ba77c3a79180a3565a2749, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-13 23:22:36'),
(0x019631790af770aab5007597c6c23164, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-13 23:25:38'),
(0x0196340f9ab278559386cbeda0e4ec5d, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-14 11:29:20'),
(0x01963525e68577debba144367bfdfaea, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-14 16:33:18'),
(0x0196352632dd7bdba0dc5e61ad39dc0d, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-14 16:33:38'),
(0x019636511ff377dfb9d56e4d027629c5, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-14 22:00:08'),
(0x019636560bd274c0bbeb0bc92b32c6ea, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-14 22:05:30'),
(0x0196365784887d2d8e856b6e24b7f0b8, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-14 22:07:07'),
(0x01963879f1b17be8b20adffb4116c765, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-15 08:03:58'),
(0x0196393b8e257ba9996449935362ee30, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-15 11:35:26'),
(0x0196393f4a767d7a9476c40ad80755d0, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-15 11:39:31'),
(0x019639da5360760d82b74f01b96b841f, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-15 14:28:51'),
(0x01963b930c657ca5a852ef1f3e2d7e98, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-15 22:30:14'),
(0x01963da276c67967afe3bf3ec8c6ac7c, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-16 08:06:19'),
(0x01963debeadd7bf480f3241f4b7a3973, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-16 09:26:33'),
(0x01963dfdfa3a7f959429845f419a6cdd, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-16 09:46:17'),
(0x01963e047f69785eb0d6ec518b2f3ddb, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-16 09:53:24'),
(0x01963e5c3c24704fb36427d14c899ff3, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-16 11:29:14'),
(0x019640cc63497d2a9e000e46ee1434fb, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-16 22:50:58'),
(0x019640cd5f6d79ef9f61b2527335b614, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-16 22:52:03'),
(0x019640ce9b207b4080b2ff55098fe2dd, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-16 22:53:24'),
(0x019643149b787b4981c61f4474e7b891, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-17 09:29:06'),
(0x01964316cee575b68cdb94bb2215ea86, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-17 09:31:30'),
(0x01964317005a78b3b82c0f1899179947, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-17 09:31:43'),
(0x0196431780f678839aa46af181f7b2d7, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-17 09:32:15'),
(0x01964317bdc8758e9f752733e0218bfb, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-17 09:32:31'),
(0x019647ed41cd78aea69bda37edaee35f, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-18 08:04:13'),
(0x019647ee20877d0aa8e013a692d94daf, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-18 08:05:10'),
(0x019647f3a29f7d0d8e69cfb94ed80a78, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-18 08:11:11'),
(0x019648ce976e7626bc982bf4fb888289, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-18 12:10:20'),
(0x019648cf219a73c08bdfd1b9c6da61fa, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-18 12:10:56'),
(0x01964940e806779da620af8f00bc2954, NULL, 'Notre premier log', 'a:0:{}', 200, 'Info', 'a:3:{s:8:\"ClientIp\";s:9:\"127.0.0.1\";s:3:\"Url\";s:0:\"\";s:5:\"route\";s:9:\"app_index\";}', '2025-04-18 14:15:12');

-- --------------------------------------------------------

--
-- Structure de la table `mesures_instructions`
--

DROP TABLE IF EXISTS `mesures_instructions`;
CREATE TABLE IF NOT EXISTS `mesures_instructions` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `conseiller_rapporteur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `greffier_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `instruction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delais` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `parties_concernes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `termine` tinyint(1) DEFAULT NULL,
  `termine_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3514FE2611C0C56` (`dossier_id`),
  KEY `IDX_3514FE29D18E664` (`conseiller_rapporteur_id`),
  KEY `IDX_3514FE22EDDA160` (`greffier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mesures_instructions`
--

INSERT INTO `mesures_instructions` (`id`, `dossier_id`, `conseiller_rapporteur_id`, `greffier_id`, `instruction`, `delais`, `created_at`, `date`, `parties_concernes`, `nature`, `termine`, `termine_at`) VALUES
(0x01955cee1a4e73d78b622eaaf64c5cea, 0x01955bc52dc671ce9c69e837f752086a, 0x01926d02517577f5b25c975f840c6c67, 0x01926c9aaf887863b3ea7bd16dd11dec, 'Paiement consignation', 15, NULL, NULL, 'Requérant', NULL, NULL, NULL),
(0x01955defb94970b5bb538eaeb928bc6f, 0x01955bc52dc671ce9c69e837f752086a, 0x01926d02517577f5b25c975f840c6c67, 0x01926c9aaf887863b3ea7bd16dd11dec, 'Mémoire ampliatif', 90, NULL, NULL, 'Requérant', NULL, NULL, NULL),
(0x01955df89ce370a88ee4a6584ae433e7, 0x01955bc52dc671ce9c69e837f752086a, 0x01926d02517577f5b25c975f840c6c67, 0x01926c9aaf887863b3ea7bd16dd11dec, 'Mémoire en défense', 90, NULL, NULL, 'Défendeur', NULL, NULL, NULL),
(0x01955e3c15d171f7b3c148a5bd15b483, 0x01955bc52dc671ce9c69e837f752086a, 0x019550bf36c07f7d95b7873ccaa0080a, 0x019550b7b7f17ba896c1859e11a38412, 'Chargé de l\'affaire', 30, NULL, '2025-03-03 22:59:10', NULL, 'PG', NULL, NULL),
(0x019565e15b267e5e8b8eef84eb67ab45, 0x019565b3c2f9743f9f0d270d6d71e732, 0x01926d02517577f5b25c975f840c6c67, 0x01926c9aaf887863b3ea7bd16dd11dec, 'Paiement des frais de consignation', 15, '0000-00-00 00:00:00', '2025-04-06 21:59:04', 'Requérant', NULL, 1, '2025-04-06 21:59:04'),
(0x01956612b49973d0b3b28f453d6c026f, 0x019565b3c2f9743f9f0d270d6d71e732, 0x01926d02517577f5b25c975f840c6c67, 0x01926c9aaf887863b3ea7bd16dd11dec, 'Rédaction du mémoire ampliatif', 60, NULL, NULL, 'Requérant', NULL, 1, '2025-04-06 21:59:04'),
(0x01956620bad97d9cb7c4d7e7f7ade08b, 0x019565b3c2f9743f9f0d270d6d71e732, 0x01926d02517577f5b25c975f840c6c67, 0x01926c9aaf887863b3ea7bd16dd11dec, 'Rédaction mémoire de défense', 60, NULL, NULL, 'Défendeur', NULL, 1, '2025-04-06 21:59:04'),
(0x0196786e03617764a6b455acc16aca3f, 0x019565b3c2f9743f9f0d270d6d71e732, 0x019550bf36c07f7d95b7873ccaa0080a, 0x019550b7b7f17ba896c1859e11a38412, 'Donnez vos conclusions au dossier', 15, NULL, '2025-04-27 18:06:37', NULL, 'PG', NULL, NULL),
(0x01967baf4ce5738cb8482fff6d357b9e, 0x01967751f55b7c56ac4ef1736bae2c1d, 0x01926d02517577f5b25c975f840c6c67, 0x01926c9aaf887863b3ea7bd16dd11dec, 'Dit au réquérant de payer la consignation', 15, NULL, NULL, 'Requérant', NULL, NULL, NULL),
(0x01967e1fe9e1787590dce3d54d2d1e92, 0x01967751f55b7c56ac4ef1736bae2c1d, 0x01926d02517577f5b25c975f840c6c67, 0x01926c9aaf887863b3ea7bd16dd11dec, 'Dites au requérant de rédiger un mémoire ampliatif', 60, NULL, NULL, 'Requérant', NULL, NULL, NULL),
(0x01967e28d5fa7a749870d31e126e3a5d, 0x01967751f55b7c56ac4ef1736bae2c1d, 0x01926d02517577f5b25c975f840c6c67, 0x01926c9aaf887863b3ea7bd16dd11dec, 'Dites au défendeur de rédiger son mémoire en défense', 60, NULL, NULL, 'Défendeur', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `modele_rapport`
--

DROP TABLE IF EXISTS `modele_rapport`;
CREATE TABLE IF NOT EXISTS `modele_rapport` (
  `id` int NOT NULL AUTO_INCREMENT,
  `structure_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `section_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `nom_fichier` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `update_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `type_rapport` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BBB95A4E2534008B` (`structure_id`),
  KEY `IDX_BBB95A4ED823E37A` (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modele_rapport`
--

INSERT INTO `modele_rapport` (`id`, `structure_id`, `section_id`, `nom_fichier`, `fichier`, `created_at`, `update_at`, `type_rapport`) VALUES
(6, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, 'ADMINISTRATIVE_SECTION_1_DECHEANCHE', 'models/ADMINISTRATIVE_SECTION_1_DECHEANCE-6810b6eb62a4e.docx', '2025-03-21 12:06:01', '2025-04-29 11:24:24', 'Déchéance'),
(7, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4ba09c74e79f91e998773af8e0, 'ADMINISTRATIVE_SECTION_2_DECHEANCE', 'models/ADMINISTRATIVE_SECTION_2_DECHEANCE-6810b730c5a8e.docx', '2025-04-14 16:01:05', '2025-04-29 11:25:34', 'Déchéance'),
(8, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4bf4197f3599a70eae583cd1b9, 'ADMINISTRATIVE_SECTION_3_DECHEANCHE', 'models/ADMINISTRATIVE_SECTION_3_DECHEANCE-6810b74dadcc2.docx', '2025-04-14 16:39:07', '2025-04-29 11:26:03', 'Déchéance'),
(9, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, 'ADMINISTRATIVE_SECTION_1_FORCLUSION', 'models/ADMINISTRATIVE_SECTION_1_FORCLUSION-6810b8f6afbb8.docx', '2025-04-14 16:42:17', '2025-04-29 11:33:08', 'Forclusion'),
(10, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4ba09c74e79f91e998773af8e0, 'ADMINISTRATIVE_SECTION_2_FORCLUSION', 'models/ADMINISTRATIVE_SECTION_2_FORCLUSION-6810b92cb7f12.docx', '2025-04-14 16:43:21', '2025-04-29 11:34:02', 'Forclusion'),
(11, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4bf4197f3599a70eae583cd1b9, 'ADMINISTRATIVE_SECTION_3_FORCLUSION', 'models/ADMINISTRATIVE_SECTION_3_FORCLUSION-6810b950d7e3a.docx', '2025-04-14 16:44:31', '2025-04-29 11:34:38', 'Forclusion'),
(13, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'JUDICIAIRE_SECTION_1_FORCLUSION', 'models/JUDICIAIRE_SECTION_1_FORCLUSION-6810b9c9e0dd0.docx', '2025-04-14 16:46:18', '2025-04-29 11:36:39', 'Forclusion'),
(14, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae49b7c374339114c93d422afabe, 'JUDICIAIRE_SECTION_2_FORCLUSION', 'models/JUDICIAIRE_SECTION_2_FORCLUSION-6810b9fc30ed8.docx', '2025-04-14 16:46:59', '2025-04-29 11:37:29', 'Forclusion'),
(15, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, 'ADMINISTRATIVE_SECTION_1_FOND', 'models/ADMINISTRATIVE_SECTION_1_FOND-6810fc76ae3ea.docx', '2025-04-14 16:53:04', '2025-04-29 16:21:07', 'Fond'),
(16, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4ba09c74e79f91e998773af8e0, 'ADMINISTRATIVE_SECTION_2_FOND', 'models/ADMINISTRATIVE_SECTION_2_FOND-6810fc915d7bd.docx', '2025-04-14 16:54:25', '2025-04-29 16:21:35', 'Fond'),
(17, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4bf4197f3599a70eae583cd1b9, 'ADMINISTRATIVE_SECTION_3_FOND', 'models/ADMINISTRATIVE_SECTION_3_FOND-6810fcb3d4d85.docx', '2025-04-14 16:55:23', '2025-04-29 16:22:09', 'Fond'),
(18, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'JUDICIAIRE_SECTION_1_FOND', 'models/JUDICIAIRE_SECTION_1_FOND-6810fce745a28.docx', '2025-04-14 16:56:51', '2025-04-29 16:23:01', 'Fond'),
(19, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae49b7c374339114c93d422afabe, 'JUDICIAIRE_SECTION_2_FOND', 'models/JUDICIAIRE_SECTION_2_FOND-6810fd18d5cc7.docx', '2025-04-14 17:03:53', '2025-04-29 16:23:50', 'Fond'),
(20, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae4aed3b7c9082409530f8a470d8, 'JUDICIAIRE_SECTION_3_FOND', 'models/JUDICIARE_SECTION_3_FOND-6810fd357876f.docx', '2025-04-14 17:06:06', '2025-04-29 16:24:19', 'Fond'),
(25, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'JUDICIAIRE_SECTION_1_DECHEANCE', 'models/JUDICIAIRE_SECTION_1_DECHEANCE-6810b76b5d368.docx', '2025-04-14 17:43:31', '2025-04-29 11:26:33', 'Déchéance'),
(26, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae49b7c374339114c93d422afabe, 'JUDICIAIRE_SECTION_2_DECHEANCE', 'models/JUDICIAIRE_SECTION_2_DECHEANCE-6810b791ec1c2.docx', '2025-04-14 17:57:57', '2025-04-29 11:27:11', 'Déchéance'),
(27, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae4aed3b7c9082409530f8a470d8, 'JUDICIAIRE_SECTION_3_DECHEANCE', 'models/JUDICIAIRE_SECTION_3_DECHEANCE-6810b7fd75ec8.docx', '2025-04-14 17:59:00', '2025-04-29 11:28:59', 'Déchéance'),
(44, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae4aed3b7c9082409530f8a470d8, 'JUDICIAIRE_SECTION_3_FORCLUSION', 'models/JUDICIAIRE_SECTION_3_FORCLUSION-6810ba420c0dc.docx', '2025-04-29 11:38:39', NULL, 'Forclusion');

-- --------------------------------------------------------

--
-- Structure de la table `mouvement`
--

DROP TABLE IF EXISTS `mouvement`;
CREATE TABLE IF NOT EXISTS `mouvement` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `user_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `statut_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_mouvement` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5B51FC3EA76ED395` (`user_id`),
  KEY `IDX_5B51FC3E611C0C56` (`dossier_id`),
  KEY `IDX_5B51FC3EF6203804` (`statut_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mouvement`
--

INSERT INTO `mouvement` (`id`, `user_id`, `dossier_id`, `statut_id`, `date_mouvement`) VALUES
(0x01955c2a1c7e73488b2da66590c36bbe, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x01955bc52dc671ce9c69e837f752086a, 0x019244e462f67503849247a2a4ce3b54, '2025-03-03 13:19:00'),
(0x01955c364cae7719a06daa694a18881d, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x01955bc52dc671ce9c69e837f752086a, 0x019244e4e99079f78845234ccb9e0e77, '2025-03-03 13:33:00'),
(0x01955dd15f1a7d68bf1eb88e322e26c6, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x01955bc52dc671ce9c69e837f752086a, 0x019244e589327b368e7e93b96aebf286, '2025-03-03 21:02:00'),
(0x019566327fc778b6861798583c2128b8, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x019565b3c2f9743f9f0d270d6d71e732, 0x019244e589327b368e7e93b96aebf286, '2025-03-05 12:05:00'),
(0x01956636b4fc77ffa080d8021033b331, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x019565b3c2f9743f9f0d270d6d71e732, 0x019244e4e99079f78845234ccb9e0e77, '2025-03-05 12:07:00'),
(0x019566b4ed357518a92097d89c612e38, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x019565b3c2f9743f9f0d270d6d71e732, 0x019244e589327b368e7e93b96aebf286, '2025-03-05 14:28:07');

-- --------------------------------------------------------

--
-- Structure de la table `nom_fichier`
--

DROP TABLE IF EXISTS `nom_fichier`;
CREATE TABLE IF NOT EXISTS `nom_fichier` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `objet`
--

DROP TABLE IF EXISTS `objet`;
CREATE TABLE IF NOT EXISTS `objet` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `objet`
--

INSERT INTO `objet` (`id`, `name`) VALUES
(0x0191ae5088a371c4b0edef4e0307635c, 'Recours en annulation'),
(0x0191ae5104ae76d7b3681567d9daf0e4, 'Rabais d\'arrêt'),
(0x0191ae5155ab7b359e4bc3823e046c34, 'Recours en reconstitution de carrière'),
(0x0191ae5191427864bd3d053ff605aa3e, 'Recours en rectification d’erreurs matérielles'),
(0x0191ae51d984725f99864abd1720194c, 'Reexamen'),
(0x0191ae51ff087864afaa0fcd83ba58d2, 'Recours de plein contentieux'),
(0x0191ae521f867b0a882b85f87316eedc, 'Recours en cassation'),
(0x0191ae5243ae796d88509ce7d134342e, 'Requêtes aux fins de désignation d\'instruction'),
(0x0191ae52646f7b128d06dc787897cf87, 'Requêtes aux fins de renvoi pour cause de suspicion légitime'),
(0x0191ae528dca732387a877d68482e0a4, 'Requêtes au fin de récusation'),
(0x019251cb87e573a288e4f4f3554bd8cc, 'Recours en interprétation'),
(0x019251ccac047873b844447660eb8a3c, 'Recours en contrôle juridictionnel de la décentralisation');

-- --------------------------------------------------------

--
-- Structure de la table `paiement_consignation`
--

DROP TABLE IF EXISTS `paiement_consignation`;
CREATE TABLE IF NOT EXISTS `paiement_consignation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dossier_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `consignation` tinyint(1) NOT NULL,
  `id_transaction` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_paiement` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `montant` double NOT NULL,
  `preuve_consignation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode_paiement` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A3AEEFE8611C0C56` (`dossier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiement_consignation`
--

INSERT INTO `paiement_consignation` (`id`, `dossier_id`, `consignation`, `id_transaction`, `date_paiement`, `montant`, `preuve_consignation`, `mode_paiement`) VALUES
(21, 0x019565b3c2f9743f9f0d270d6d71e732, 1, '315637', '2025-04-20 01:51:29', 15000, 'consignations/preuve_consignation_019565b3-c2f9-743f-9f0d-270d6d71e732-68045321d2cd3.pdf', 'MTN');

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

DROP TABLE IF EXISTS `partie`;
CREATE TABLE IF NOT EXISTS `partie` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `localite_id` int DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenoms` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intitule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_59B1F3D924DD2B5` (`localite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `partie`
--

INSERT INTO `partie` (`id`, `localite_id`, `nom`, `prenoms`, `sexe`, `telephone`, `email`, `adresse`, `type`, `intitule`, `status`) VALUES
(0x0194843582e077fea1bc68f938369b36, 343, 'HODE', 'Coth', 'm', '11111111', 'w.araba@hotmail.fr', 'Zobadjé', 'physique', NULL, 'REQUERANT'),
(0x0194843610fb770babf4ab1bb62fe69e, NULL, 'YEKINI', 'Bahiralaï', 'm', '11111111', 'w.araba@hotmail.com', 'Zobadjé', 'physique', NULL, 'DEFENDEUR'),
(0x019484568c83775ebc5d838134671b75, 472, 'AGBANHA', 'JEAN', 'm', '0199555222', 'w.araba@hotmail.fr', 'ABOMEY Q', 'physique', NULL, 'REQUERANT'),
(0x0194845874bc73c88677728445ee9e66, NULL, 'ADJEHOUNNOU', 'Norbert', 'm', '11223366', 'matines1@yahoo.fr', 'ABOMEY Q', 'physique', NULL, 'DEFENDEUR'),
(0x01955bc52dc773f0a6613057991bb0b9, 1, 'DOSSOU', 'Jack', 'm', '0197542103', 'amira7073@gmail.com', 'Cotonou/Apkakpa', 'physique', NULL, 'REQUERANT'),
(0x01955bc6673675c28f71ea8c7c70c93d, NULL, 'MIGAN', 'Charle', 'm', '0197542103', 'haqqdwest@gmail.com', 'Cotonou/Apkakpa', 'physique', NULL, 'DEFENDEUR'),
(0x019565b3c2fa7a4b9525039c38918d40, 431, 'Doè', 'Dupont', 'm', '0195741220', 'amire7073@gmail.com', 'Avakpa/Gbègor', 'physique', NULL, 'REQUERANT'),
(0x019565b4e6157f5e90ea5a9c87e7e00e, NULL, 'Paul', 'Alain', 'm', '0197172419', 'alain@gmail.com', 'Cotonou/Qtr-Jack', 'physique', NULL, 'DEFENDEUR'),
(0x019565c3f2c37580b6c885d642e9f9b9, 81, 'Ali', 'Parcis', 'm', '0154789521', 'parcis@gmail.com', 'lome', 'physique', NULL, 'REQUERANT'),
(0x019565c5570d721db0d83edf5c78ba9f, 287, 'Varo', 'Iman', 'm', '0122874559', 'varo@gmail.com', 'come', 'physique', NULL, 'DEFENDEUR'),
(0x01967751f55c7edc92c185c1b29aab23, 344, 'ISIAKA', 'Abdoul', 'm', '0197541820', 'abdoul@gmail.com', 'Avenue-Benin/PB03', 'physique', NULL, 'REQUERANT'),
(0x0196775319e67b3a94b0c385943f0093, NULL, 'BAKOLE', 'Rahim', 'm', '0197451324', 'rahim@gmail.com', 'Porto-Novo', 'physique', NULL, 'DEFENDEUR');

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

DROP TABLE IF EXISTS `pieces`;
CREATE TABLE IF NOT EXISTS `pieces` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `auteur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `description_piece` longtext COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updaded_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `nature_piece` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B92D7472611C0C56` (`dossier_id`),
  KEY `IDX_B92D747260BB6FE6` (`auteur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `preuve_consignation_requerant`
--

DROP TABLE IF EXISTS `preuve_consignation_requerant`;
CREATE TABLE IF NOT EXISTS `preuve_consignation_requerant` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `provenance`
--

DROP TABLE IF EXISTS `provenance`;
CREATE TABLE IF NOT EXISTS `provenance` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rapport`
--

DROP TABLE IF EXISTS `rapport`;
CREATE TABLE IF NOT EXISTS `rapport` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_by_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `modele_rapport_id` int NOT NULL,
  `dossier_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `fichier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `update_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `donnees` json DEFAULT NULL,
  `statut` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'brouillon',
  `type_rapport` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BE34A09C611C0C56` (`dossier_id`),
  KEY `IDX_BE34A09CEEACDBB7` (`modele_rapport_id`),
  KEY `IDX_BE34A09CB03A8386` (`created_by_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse_mesures_instructions`
--

DROP TABLE IF EXISTS `reponse_mesures_instructions`;
CREATE TABLE IF NOT EXISTS `reponse_mesures_instructions` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `mesure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `reponse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_mise_directive` datetime DEFAULT NULL,
  `date_notification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `reponse_partie` tinyint(1) DEFAULT NULL,
  `termine` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E64881E843AB22FA` (`mesure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reponse_mesures_instructions`
--

INSERT INTO `reponse_mesures_instructions` (`id`, `mesure_id`, `reponse`, `date_mise_directive`, `date_notification`, `reponse_partie`, `termine`) VALUES
(0x01955dc054b57123a8862f5f0ee8723d, 0x01955cee1a4e73d78b622eaaf64c5cea, 'Paiement effectué', '2025-03-03 00:00:00', '2025-03-20 10:40:01', 1, 1),
(0x01955df2505678d3a356efc1964dc1f0, 0x01955defb94970b5bb538eaeb928bc6f, 'Enregistrement du mémoire ampliatif', '2025-03-03 00:00:00', '2025-03-20 10:40:01', 1, 1),
(0x01955dfeebb37334937ab1ad24319f4b, 0x01955df89ce370a88ee4a6584ae433e7, 'Mémoire en défense', '2025-03-03 00:00:00', '2025-03-20 10:40:01', 1, 1),
(0x01956180f906795caa4bec77907d82c5, 0x01955e3c15d171f7b3c148a5bd15b483, 'J\'ai contacté les deux parties', '2025-03-08 00:00:00', '0000-00-00 00:00:00', NULL, NULL),
(0x019565e93a427478942b4f289b6c5032, 0x019565e15b267e5e8b8eef84eb67ab45, 'Il a payé le 5 mars 2025', '2025-03-05 00:00:00', '2025-04-23 10:40:01', 1, 1),
(0x019566161eed7d6392c2ad050e8c536c, 0x01956612b49973d0b3b28f453d6c026f, 'Rédaction de mémoire ampliatif effectué le 05/03/2025', '2025-03-05 00:00:00', '2025-03-20 00:00:00', 1, 1),
(0x01956622f6137617a4e0b1e822142923, 0x01956620bad97d9cb7c4d7e7f7ade08b, 'Il a rédiger le mémoire en défense le 07/03/2025', '2025-03-05 00:00:00', '2025-03-20 10:40:01', 1, 1),
(0x01967bb40cd67bd7a3ccc462ec7d434d, 0x01967baf4ce5738cb8482fff6d357b9e, 'Il vient de payer la consignation', '2025-04-27 00:00:00', '2025-04-27 00:00:00', 1, 1),
(0x01967e25aae77347a9f35ab715a78fd1, 0x01967e1fe9e1787590dce3d54d2d1e92, 'J\'ai contacté le requérant de rédiger son mémoire ampliatif', '2025-04-28 00:00:00', '2025-04-28 00:00:00', 1, 1),
(0x01967e2c9f6f7b9bbcf865dc527b98e5, 0x01967e28d5fa7a749870d31e126e3a5d, 'J\'ai contacté le défendeur pour la rédaction de son mémoire en défense', '2025-01-28 00:00:00', '2025-01-28 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `representant`
--

DROP TABLE IF EXISTS `representant`;
CREATE TABLE IF NOT EXISTS `representant` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `partie_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_80D5DBC9E075F7A4` (`partie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `representant`
--

INSERT INTO `representant` (`id`, `partie_id`, `nom`, `prenom`, `email`, `telephone`, `adresse`) VALUES
(0x00000000000000000000000000000000, 0x019565c5570d721db0d83edf5c78ba9f, 'SALAMI', 'Mohamed', 'salami@gmail.com', '0197842113', 'Paris/Lille');

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `user_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reset_password_request`
--

INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
(0x01948372194c7860bc213a21c8cccfbb, 0x0191ae5bdf5e74168ee884cbf400a848, 'isfhvLvvnC1NiXTesAlg', 'ycocn57ZT7DWjEISgNj7JDqPWCn3q883m8eT/3OqW/M=', '2025-01-20 11:21:20', '2025-01-20 12:21:20');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4E977E5C2534008B` (`structure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id`, `structure_id`, `nom`) VALUES
(0x01921e4d0e547f47a155fdb0d148a78d, 0x0191ae4201167fab94810a32b44f2ec4, 'ABRAHAM ZINZINDOHOUE'),
(0x01921e543cc57f18bc0604b32f6d30a0, 0x0191ae417a7373ec9e2d67ba9adab788, 'FREDERIC N. HOUNDETON');

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `code_section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2D737AEF2534008B` (`structure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `section`
--

INSERT INTO `section` (`id`, `structure_id`, `code_section`, `name`) VALUES
(0x0191ae49b7c374339114c93d422afabe, 0x0191ae417a7373ec9e2d67ba9adab788, 'SECTION 2', 'SECTION DES AFFAIRES DE DROIT PENAL ET DES PROCEDURES SPECIALES PENALES'),
(0x0191ae4aed3b7c9082409530f8a470d8, 0x0191ae417a7373ec9e2d67ba9adab788, 'SECTION 3', 'SECTION DES AFFAIRES DU DROIT FONCIER'),
(0x0191ae4b392b7cd2a8b7e5d1c3a35640, 0x0191ae4201167fab94810a32b44f2ec4, 'SECT1', 'SECTION 1'),
(0x0191ae4ba09c74e79f91e998773af8e0, 0x0191ae4201167fab94810a32b44f2ec4, 'SECT2', 'SECTION 2'),
(0x0191ae4bf4197f3599a70eae583cd1b9, 0x0191ae4201167fab94810a32b44f2ec4, 'SECT3', 'SECTION 3'),
(0x0191ae4c55177898bbfb0184686c1b32, 0x0191ae4735af763ba31742744906c8cf, 'SI', 'SERVICE INFORMATIQUE'),
(0x0191cec4ab23725291e516a97cf8479c, 0x0191ce9931287240af7cef77ed00541a, 'GC', 'Greffe Central'),
(0x019247d9aed4773ca611df385483f6bf, 0x0191ae417a7373ec9e2d67ba9adab788, 'SECTION 1', 'SECTION DES AFFAIRES CIVILES COMMERCIALES ET SOCIALES'),
(0x019247da5132794aa006f669ea980f71, 0x0191ae417a7373ec9e2d67ba9adab788, 'PCJ', 'PCJ'),
(0x01926c9761d877b9a4a31281f6f9b131, 0x0191ae4201167fab94810a32b44f2ec4, 'PCA', 'PCA'),
(0x01948971cb937a7ea50221480581bfe8, 0x0194896f56e8727e944341a5550a573f, 'PG', 'Parquet Général'),
(0x0194897218b27c04aac4f6478c928d84, 0x0194896f56e8727e944341a5550a573f, 'PAG', 'Premier Avocat Général'),
(0x0194897267747a468b55e0dbf7922ad0, 0x0194896f56e8727e944341a5550a573f, 'AG', 'Avocat Général');

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

DROP TABLE IF EXISTS `statut`;
CREATE TABLE IF NOT EXISTS `statut` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id`, `libelle`) VALUES
(0x019244e462f67503849247a2a4ce3b54, 'Dossier en attente de paiement de consignation'),
(0x019244e4e99079f78845234ccb9e0e77, 'Dossier en instruction'),
(0x019244e589327b368e7e93b96aebf286, 'Dossier au Rôle'),
(0x019244e70d367422a778709a35473109, 'Dossier vidé : Arrêt disponible'),
(0x01924c13b5557dc7b4e877c9045cc194, 'Dossier Délibéré : En attente de l\'arrêt');

-- --------------------------------------------------------

--
-- Structure de la table `structure`
--

DROP TABLE IF EXISTS `structure`;
CREATE TABLE IF NOT EXISTS `structure` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `code_structure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `structure`
--

INSERT INTO `structure` (`id`, `code_structure`, `name`) VALUES
(0x0191ae417a7373ec9e2d67ba9adab788, 'CJ', 'Chambre Judiciaire'),
(0x0191ae4201167fab94810a32b44f2ec4, 'CA', 'Chambre Administrative'),
(0x0191ae4735af763ba31742744906c8cf, 'SG', 'Secrétariat Général'),
(0x0191ce9931287240af7cef77ed00541a, 'GC', 'Greffe Central'),
(0x0194896f56e8727e944341a5550a573f, 'PG', 'Parquet Général');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `sections_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenoms` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `password_change_required` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D6492534008B` (`structure_id`),
  KEY `IDX_8D93D649577906E4` (`sections_id`)
) ;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `structure_id`, `sections_id`, `email`, `roles`, `password`, `nom`, `prenoms`, `telephone`, `actif`, `last_login`, `titre`, `token`, `is_verified`, `password_change_required`) VALUES
(0x0191ae5bdf5e74168ee884cbf400a848, 0x0191ae4735af763ba31742744906c8cf, 0x0191ae4c55177898bbfb0184686c1b32, 'akarimou@coursupreme.bj', '[\"ROLE_SUPER_ADMIN\"]', '$2y$13$Jq1OyXvPmH9jVIbMRsbgcu9WL/QR152s9/dsG4u4zh3SyGZtC3KFi', 'KARIMOU AMADOU', 'Abdoul Nassirou', '97719794', 1, NULL, 'AUTRES AGENTS', NULL, 0, 0),
(0x019247db9589746e82c0b0a473ef9bd3, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247da5132794aa006f669ea980f71, 'pcj@gmail.com', '[\"ROLE_PCJ\"]', '$2y$13$Xl31MGGaSevDI0RbhpSPr.ZJ7k/KT2o1YPmIuCOSCqtkfl7U6cNeq', 'PCJ', 'PCJ', '55555555', 1, NULL, 'PRESIDENT DE STRUCTURE', NULL, 0, 0),
(0x019247decd437f328344f05ee9731722, 0x0191ce9931287240af7cef77ed00541a, 0x0191cec4ab23725291e516a97cf8479c, 'bo@gmail.com', '[\"ROLE_BUREAU_ORIENTATION\"]', '$2y$13$uWALf4Ayy1s0iG4SfWTGP.7e0FUdt8Byt5Fwn8F1sOrOIHvN3sJWG', 'BO', 'Bo', '0197421899', 1, NULL, 'AUTRES AGENTS', NULL, 0, 0),
(0x019247e18da472258c9b2ffb0ac456f7, 0x0191ce9931287240af7cef77ed00541a, 0x0191cec4ab23725291e516a97cf8479c, 'gec@gmail.com', '[\"ROLE_GREFFIER_EN_CHEF\"]', '$2y$13$tkahV6h8FY0POrPCxyGsmebFRznwVVpkLM2x.jwbSMMDGQnJ3UNDC', 'GEC', 'Gec', '0195231745', 1, NULL, 'GREFFIER EN CHEF', NULL, 1, 0),
(0x019247e3bd727123b8a3cbedf6b2da9a, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'cr@gmail.com', '[\"ROLE_CONSEILLER\"]', '$2y$13$k14kYH9sngHTpePWQy0qJOWE/2dt7e84eVvzaNu9uJZI52MXawOVa', 'RAPPORTEUR', 'Conseiller', '222222', 1, NULL, 'CONSEILLER', NULL, 0, 0),
(0x019247e59b0875bcbbf0a4a9e3e43d55, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'greffier1cj@gmail.com', '[\"ROLE_GREFFIER\"]', '$2y$13$M7DGyFykSfdbTM7xkaxVV.1848UHm7L8PX0U1xvnS5z10ssJRKzM6', 'GREFFIER', 'CJ', '11111111', 1, NULL, 'GREFFIER', NULL, 0, 0),
(0x01926c99522e7199b98627e2811e830d, 0x0191ae4201167fab94810a32b44f2ec4, 0x01926c9761d877b9a4a31281f6f9b131, 'pca@gmail.com', '[\"ROLE_PCA\"]', '$2y$13$7MKlFqogPyq3QaP5.Z5oVu/JyKByHMQAsNuYLaf8q21Md3CwMQU8y', 'PCA', 'PCA', '0197771222', 1, NULL, 'PRESIDENT DE STRUCTURE', NULL, 0, 0),
(0x01926c9aaf887863b3ea7bd16dd11dec, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, 'greffier1ca@gmail.com', '[\"ROLE_GREFFIER\"]', '$2y$13$IR2V.2c.PY2psnYLCiYQOe0xbCwXEI5Aqx2S1wEkT1GqVTJ0P65Pe', 'Greffier', 'CA', '0197452118', 1, NULL, 'GREFFIER', NULL, 1, 0),
(0x01926d02517577f5b25c975f840c6c67, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, 'crca@gmail.com', '[\"ROLE_CONSEILLER\"]', '$2y$13$Wg89Lb5.AbHalxay4Cqen.GPZp5oU.10x4gvVmu5Km5MtJarjXepa', 'CR', 'CA', '0197451280', 1, NULL, 'CONSEILLER', NULL, 0, 0),
(0x0192b3ce60507473afadd28e50c30437, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae4aed3b7c9082409530f8a470d8, 'crcj@gmail.com', '[\"ROLE_CONSEILLER\"]', '$2y$13$0R8SUq0MSEc2/2RE7XHfPunRKcd5dIgZuJPkfJGrO6VIWuVMxP1hG', 'CONSEILLER', 'Rapporeur', '61510059', 1, NULL, 'CONSEILLER', NULL, 0, 0),
(0x0192b3d0796673feb54bbbec0868c022, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae4aed3b7c9082409530f8a470d8, 'greffiercj@gmail.com', '[\"ROLE_GREFFIER\"]', '$2y$13$69WWE.xnZQR4XnhDmDgwNeDqWiREXkO5K2GWyVDnhblvMG1SBIpBy', 'Greffier', 'CJ', '97719794', 1, NULL, 'GREFFIER', NULL, 0, 0),
(0x0194835d29a875f180f18b99267cf632, 0x0191ae4735af763ba31742744906c8cf, 0x0191ae4c55177898bbfb0184686c1b32, 'abdoul.ousmane@coursupreme.bj', '[\"ROLE_SUPER_ADMIN\"]', '$2y$13$Sfoy0milV1NFtQhgBxBwrOZZxGVEWhfd.k6ls0DTW7HjedLAz1yEa', 'OUSMANE', 'Abdoul Matine', '0197210388', 1, NULL, 'AUTRES AGENTS', NULL, 0, 1),
(0x019483b39f8c7ae6926901a9664bebca, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'wilfrid.araba@coursupreme.bj', '[\"ROLE_CONSEILLER\"]', '$2y$13$.NVaz.fmAwhmISTLhleIBOUG.p6iwsia2ZX32qp1/jQqO1HIJUVLi', 'ARABA', 'Wilfrid', '11111111', 1, NULL, 'CONSEILLER', NULL, 0, 0),
(0x019488fa678f7082b35c3a62a09c50ee, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae4aed3b7c9082409530f8a470d8, 'aisanoussi@coursupreme.bj', '[\"ROLE_CONSEILLER\"]', '$2y$13$ZoaFTw45Pf67nBd2r4v9TOYCvSUDuf/.9w38/h4wRIJAXiBBXvmLy', 'SANOUSSI', 'Ismaël Anselme', '11111111111', 1, NULL, 'CONSEILLER', NULL, 0, 1),
(0x01948900efb571268e22fa213a704571, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae49b7c374339114c93d422afabe, 'olawani@coursupreme.bj', '[\"ROLE_CONSEILLER\"]', '$2y$13$W..T/2lenzZnh6DpTdduOOHTEEdXAwCPd7xl3AG4BLiUK.fGqWWeW', 'LAWANI Olatoundji', 'Badirou', '1111111111', 1, NULL, 'CONSEILLER', NULL, 0, 1),
(0x01948912f0167f72911f0e2b0f72dc79, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'ladjado@coursupreme.bj', '[\"ROLE_GREFFIER\"]', '$2y$13$1TKClauoRLPffC0wox/2uuW3lRY74WzfuF0DWRxgu402g7APH7OPC', 'ADJADO', 'Oussou Léonce', '111111111', 1, NULL, 'GREFFIER', NULL, 0, 1),
(0x0194891796857eccaed88aab5733c771, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae49b7c374339114c93d422afabe, 'kaffewe@coursupreme.bj', '[\"ROLE_GREFFIER\"]', '$2y$13$h0f3Hv4v4SgI4e.qM18VVeqD/pgON66Z0.6LifshHxc7QQsjZYKJS', 'AFFEWE', 'Kodjihounkan Appolinaire', '111111111', 1, NULL, 'GREFFIER', NULL, 0, 1),
(0x0194892208b47baf9650aaeaf92f3394, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'helene.nahum@coursupreme.bj', '[\"ROLE_GREFFIER\"]', '$2y$13$otlANf.wOPjoEIEo9VGBXODPsethDUgqumKw4yeNXoKmb8vQEJ8uK', 'NAHUM', 'Hélène', '111111111', 1, NULL, 'GREFFIER', NULL, 0, 1),
(0x0194896af3ce7ec4a25e609cd899bd90, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, 'apinassirou@gmail.com', '[\"ROLE_PROCUREUR_GENERAL\"]', '$2y$13$TE2wWnsgu1uTO7juhJ7hheuJWHGk/4SIR0DJNyWuG1lKDohV4xzHK', 'TEST', 'TESt', '11111111', NULL, NULL, 'AVOCAT GENERAL', NULL, 0, 1),
(0x0194897883f176a6a7b27c6b2af8ef00, 0x0194896f56e8727e944341a5550a573f, 0x01948971cb937a7ea50221480581bfe8, 'djidonou.afaton@coursupreme.bj', '[\"ROLE_PROCUREUR_GENERAL\"]', '$2y$13$P2e12H11z50kp.Fh.YRuXuCaa1NDFWPnuNUpWUMbH3DwUEZsvSg3K', 'AFATON', 'Djidonou Saturnin', '11111111', 1, NULL, 'PROCUREUR GENERAL', NULL, 0, 1),
(0x01955074c3fd763ab358043325474cd5, 0x0191ae4735af763ba31742744906c8cf, 0x0191ae4c55177898bbfb0184686c1b32, 'amir@gmail.com', '[\"ROLE_SUPER_ADMIN\"]', '$2y$13$odZfgJB2qPB6Vba4vJTx8OPLXuTBl8p6XbRdIycrgbbk10q7Lc2q.', 'ABIOLA', 'EL-Amir', '0156139200', 1, NULL, 'AUTRES AGENTS', NULL, 0, 0),
(0x0195508f0a72717abf3d36a12f2ab273, 0x0194896f56e8727e944341a5550a573f, 0x01948971cb937a7ea50221480581bfe8, 'pcs@gmail.com', '[\"ROLE_PCS\"]', '$2y$13$A73NijTH6jkHpK8TTBO11eoCtf5xw1etOeT7sY5MhiQFoC/WBzWSu', 'PCS', 'PCS', '0195421473', 1, NULL, 'PRESIDENT DE LA COUR', NULL, 0, 0),
(0x019550b43d6f7a249698403fc4aa41aa, 0x0194896f56e8727e944341a5550a573f, 0x01948971cb937a7ea50221480581bfe8, 'psca@gmail.com', '[\"ROLE_PRESIDENT_DE_SECTION\"]', '$2y$13$xhYr41srDJvrYFQTQJhgSehR0LQrc0y2HFqkIeo521.ArJsSrI6MS', 'PSCA', 'PSCA', '0197894215', 1, NULL, 'PRESIDENT DE SECTION', NULL, 0, 1),
(0x019550b7b7f17ba896c1859e11a38412, 0x0191ae4201167fab94810a32b44f2ec4, 0x0194897267747a468b55e0dbf7922ad0, 'ag1ca@gmail.com', '[\"ROLE_AVOCAT_GENERAL\"]', '$2y$13$cKNa.SM0bLRkGQ.HNn26FOwvVc24t9NMji3JJPO5o6IVINW36wafK', 'AGCA', 'AGCA', '0197451873', 1, NULL, 'AVOCAT GENERAL', NULL, 0, 0),
(0x019550bf36c07f7d95b7873ccaa0080a, 0x0194896f56e8727e944341a5550a573f, 0x0191cec4ab23725291e516a97cf8479c, 'pg@gmail.com', '[\"ROLE_PROCUREUR_GENERAL\"]', '$2y$13$d92PM00jEg31ClTIpOLq6ulN9x/NUaFW1L05pQTFslBQdIHt3J1zy', 'PG', 'PG', '0197453124', 1, NULL, 'PROCUREUR GENERAL', NULL, 0, 0),
(0x019550c6e4257b949593c557cb78b372, 0x0191ce9931287240af7cef77ed00541a, 0x0191cec4ab23725291e516a97cf8479c, 'audi1ca@gmail.com', '[\"ROLE_GREFFIER\"]', '$2y$13$JodtQ2qbvWgk5jLbsMrod.BDzjNkl58pwVrL2kWMWcSDIXKjJdRlu', 'Auditeur', 'CA', '0198745314', 1, NULL, 'AUDITEUR', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user_dossier`
--

DROP TABLE IF EXISTS `user_dossier`;
CREATE TABLE IF NOT EXISTS `user_dossier` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `user_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `many_to_one` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` longtext COLLATE utf8mb4_unicode_ci,
  `date_affectation` datetime DEFAULT NULL,
  `delai` int DEFAULT NULL,
  `nature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6545FE3DA76ED395` (`user_id`),
  KEY `IDX_6545FE3D611C0C56` (`dossier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_dossier`
--

INSERT INTO `user_dossier` (`id`, `user_id`, `dossier_id`, `many_to_one`, `profil`, `instructions`, `date_affectation`, `delai`, `nature`) VALUES
(0x0194843fed47733ab2f54d4358c522dd, 0x019247e59b0875bcbbf0a4a9e3e43d55, 0x0194843582e077fea1bc68f937e43c87, NULL, 'GREFFIER EN CHEF', NULL, '2025-01-20 15:06:09', NULL, NULL),
(0x0194846e516c7d5f8f410cf345f9be81, 0x019247e59b0875bcbbf0a4a9e3e43d55, 0x019484568c83775ebc5d838133d4004b, NULL, 'GREFFIER EN CHEF', NULL, '2025-01-20 15:56:49', NULL, NULL),
(0x01955c15679b7cea89f61523dd3f94b4, 0x01926d02517577f5b25c975f840c6c67, 0x01955bc52dc671ce9c69e837f752086a, NULL, 'CONSEILLER RAPPORTEUR', NULL, '2025-03-03 12:57:41', NULL, NULL),
(0x01955c15679c7709bbc6c72a42c3a393, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x01955bc52dc671ce9c69e837f752086a, NULL, 'GREFFIER', NULL, '2025-03-03 12:57:41', NULL, NULL),
(0x01955e3c149b7424b5afaff3c47fccaf, 0x019550b7b7f17ba896c1859e11a38412, 0x01955bc52dc671ce9c69e837f752086a, NULL, 'AVOCAT GENERAL', NULL, '2025-03-03 22:59:07', NULL, 'AFFECTATION'),
(0x019565df1b537efea8477ea236d5f6ba, 0x01926d02517577f5b25c975f840c6c67, 0x019565b3c2f9743f9f0d270d6d71e732, NULL, 'CONSEILLER RAPPORTEUR', NULL, '2025-03-05 10:34:35', NULL, NULL),
(0x019565df1b5479658ae3bd312ac5a13b, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x019565b3c2f9743f9f0d270d6d71e732, NULL, 'GREFFIER', NULL, '2025-03-05 10:34:35', NULL, NULL),
(0x01967838508476608633c44c0dcce148, 0x01926d02517577f5b25c975f840c6c67, 0x01967751f55b7c56ac4ef1736bae2c1d, NULL, 'CONSEILLER RAPPORTEUR', NULL, '2025-04-27 17:07:58', NULL, NULL),
(0x0196783850857b89bfff8f8622404bef, 0x01926c9aaf887863b3ea7bd16dd11dec, 0x01967751f55b7c56ac4ef1736bae2c1d, NULL, 'GREFFIER', NULL, '2025-04-27 17:07:58', NULL, NULL),
(0x0196786e025c713dba7e11a063508aaa, 0x019550b7b7f17ba896c1859e11a38412, 0x019565b3c2f9743f9f0d270d6d71e732, NULL, 'AVOCAT GENERAL', NULL, '2025-04-27 18:06:34', NULL, 'AFFECTATION');

-- --------------------------------------------------------

--
-- Structure de la table `village`
--

DROP TABLE IF EXISTS `village`;
CREATE TABLE IF NOT EXISTS `village` (
  `id` int NOT NULL AUTO_INCREMENT,
  `arrondissement_id` int DEFAULT NULL,
  `lib_village` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4E6C7FAA407DBC11` (`arrondissement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5305 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `village`
--

INSERT INTO `village` (`id`, `arrondissement_id`, `lib_village`) VALUES
(4249, 429, 'YOKON'),
(4250, 429, 'ZOUNGUE'),
(4251, 429, 'ZOUNGUE SAI LAGARE'),
(4252, 429, 'ZOUNTA'),
(4253, 430, 'DANGBO'),
(4254, 430, 'DANGBO HONME'),
(4255, 430, 'DOGLA'),
(4256, 430, 'DOKOME'),
(4257, 430, 'KE'),
(4258, 430, 'MONNOTOKPA'),
(4259, 430, 'TOVE'),
(4260, 431, 'ACCRON-GOGANKOMEY'),
(4261, 431, 'ADJEGOUNLE'),
(4262, 431, 'ADOMEY'),
(4263, 431, 'AHOUANTIKOMEY'),
(4264, 431, 'AKPASSA ODO OBA'),
(4265, 431, 'AVASSA BAGORO AGBOKOMEY'),
(4266, 431, 'AYETORO'),
(4267, 431, 'AYIMLONFIDE'),
(4268, 431, 'DEGUEKOME'),
(4269, 431, 'DOTA-ATTINGBANSA-AZONZAKOMEY'),
(4270, 431, 'GANTO'),
(4271, 431, 'GBASSOU-ITABODO'),
(4272, 431, 'GBECON'),
(4273, 431, 'GUEVIE-ZINKOMEY'),
(4274, 431, 'HONDJI-HONNOU FILLA'),
(4275, 431, 'HOUEGBO-HLINKOMEY'),
(4276, 431, 'HOUEYOGBE-GBEDJI'),
(4277, 431, 'HOUEZOUNMEY'),
(4278, 431, 'IDI-ARABA'),
(4279, 431, 'ILEFIE'),
(4280, 431, 'KPOTA SANDODO'),
(4281, 431, 'LOKOSSA'),
(4282, 431, 'OGANLA-GARE-EST'),
(4283, 431, 'SADOGNON-ADJEGOUNLE'),
(4284, 431, 'SADOGNON-WOUSSA'),
(4285, 431, 'SAGBO KOSSOUKODE'),
(4286, 431, 'SOKOMEY-TOFFINKOMEY'),
(4287, 431, 'TOGOH - ADANKOMEY'),
(4288, 431, 'VEKPA'),
(4289, 432, 'AGBOKOU AGA'),
(4290, 432, 'AGBOKOU BASSODJI MAIRIE'),
(4291, 432, 'AGBOKOU CENTRE SOCIAL'),
(4292, 432, 'AGBOKOU ODO'),
(4293, 432, 'ATTAKE OLORY-TOGBE'),
(4294, 432, 'ATTAKE YIDI'),
(4295, 432, 'DJEGAN DAHO'),
(4296, 432, 'DONOUKIN LISSESSA'),
(4297, 432, 'GBEZOUNKPA'),
(4298, 432, 'GUEVIE DJEGANTO'),
(4299, 432, 'HINKOUDE'),
(4300, 432, 'KANDEVIE RADIO HOKON'),
(4301, 432, 'KOUTONGBE'),
(4302, 432, 'SEDJEKO'),
(4303, 432, 'TCHINVIE'),
(4304, 432, 'ZOUNKPA HOUETO'),
(4305, 433, 'ADJINA NORD'),
(4306, 433, 'ADJINA SUD'),
(4307, 433, 'AVAKPA KPODJI'),
(4308, 433, 'AVAKPA-TOKPA'),
(4309, 433, 'DJASSIN  DAHO'),
(4310, 433, 'DJASSIN ZOUNME'),
(4311, 433, 'FOUN-FOUN DJAGUIDI'),
(4312, 433, 'FOUN-FOUN GBEGO'),
(4313, 433, 'FOUN-FOUN SODJI'),
(4314, 433, 'FOUN-FOUN TOKPA'),
(4315, 433, 'HASSOU AGUE'),
(4316, 433, 'OGANLA  ATAKPAME'),
(4317, 433, 'OGANLA NORD'),
(4318, 433, 'OGANLA POSTE'),
(4319, 433, 'OGANLA SOKE'),
(4320, 433, 'OGANLA SUD'),
(4321, 433, 'OUINLINDA AHOLOUKOMEY'),
(4322, 433, 'OUINLINDA HOPITAL'),
(4323, 433, 'ZEBOU AGA'),
(4324, 433, 'ZEBOU AHOUANGBO'),
(4325, 433, 'ZEBOU -ITATIGRI'),
(4326, 433, 'ZEBOU -MASSE'),
(4327, 434, 'ANAVIE'),
(4328, 434, 'ANAVIE VOIRIE'),
(4329, 434, 'DJEGAN KPEVI'),
(4330, 434, 'DODJI'),
(4331, 434, 'GBEDJROMEDE FUSION'),
(4332, 434, 'GBODJE'),
(4333, 434, 'GUEVIE'),
(4334, 434, 'HLOGOU OU HLONGOU'),
(4335, 434, 'HOUINME CHATEAU D\'EAU'),
(4336, 434, 'HOUINME DJAGUIDI'),
(4337, 434, 'HOUINME GANTO'),
(4338, 434, 'HOUINME GBEDJROMEDE'),
(4339, 434, 'HOUNSA'),
(4340, 434, 'HOUNSOUKO'),
(4341, 434, 'KANDEVIE  MISSOGBE'),
(4342, 434, 'KANDEVIE OWODE'),
(4343, 434, 'KPOGBONME'),
(4344, 434, 'SETO - GBODJE'),
(4345, 435, 'AKONABOE'),
(4346, 435, 'DJLADO'),
(4347, 435, 'DOWA'),
(4348, 435, 'DOWA  ALIOGBOGO'),
(4349, 435, 'DOWA  DEDOME'),
(4350, 435, 'HOUINVIE'),
(4351, 435, 'LOUHO'),
(4352, 435, 'OUANDO'),
(4353, 435, 'OUANDO CLEKANME'),
(4354, 435, 'OUANDO KOTIN'),
(4355, 435, 'TOKPOTA DADJROUGBE'),
(4356, 435, 'TOKPOTA DAVO'),
(4357, 435, 'TOKPOTA VEDO'),
(4358, 435, 'TOKPOTA ZEBE'),
(4359, 435, 'TOKPOTA ZINLIVALI'),
(4360, 436, 'AGBALILAME'),
(4361, 436, 'AGBLANGANDAN'),
(4362, 436, 'AKPOKPOTA'),
(4363, 436, 'DAVATIN'),
(4364, 436, 'GBAKPODJI'),
(4365, 436, 'KADJACOME'),
(4366, 436, 'KPAKPAKANME'),
(4367, 436, 'LOKOKOUKOUME'),
(4368, 436, 'MOUDOKOME'),
(4369, 436, 'SEKANDJI'),
(4370, 436, 'SEKANDJI ALLAMANDOSSI'),
(4371, 436, 'SEKANDJI HOUEYOGBE'),
(4372, 437, 'AGONSA GBO'),
(4373, 437, 'AHOLOUYEME'),
(4374, 437, 'DENOU'),
(4375, 437, 'DJEHO'),
(4376, 437, 'GOHO'),
(4377, 437, 'KETONOU'),
(4378, 437, 'TORRI-AGONSA'),
(4379, 438, 'AWANOU'),
(4380, 438, 'DJEREGBE'),
(4381, 438, 'DJEREGBE HOUELA'),
(4382, 438, 'GBEHONME'),
(4383, 438, 'GBOKPA'),
(4384, 438, 'HOUEKE'),
(4385, 438, 'HOUINTA'),
(4386, 439, 'DJEFFA GLEGBONOU'),
(4387, 439, 'DJEFFA HOUEDOME'),
(4388, 439, 'DJEFFA HOUEDOME  GBAGO'),
(4389, 439, 'DJEFFA KOWENOU'),
(4390, 439, 'EKPE  WECHINDAHOME'),
(4391, 439, 'EKPE GBEDJAME'),
(4392, 439, 'EKPE KANHONNOU'),
(4393, 439, 'EKPE-KPECOME'),
(4394, 439, 'EKPE-MARINA'),
(4395, 439, 'EKPE-PK10'),
(4396, 439, 'EKPE-SEYIVE'),
(4397, 439, 'TCHONVI'),
(4398, 439, 'TCHONVI AGBOLOGOUN'),
(4399, 440, 'AHLOME'),
(4400, 440, 'AYOKPO'),
(4401, 440, 'DJA'),
(4402, 440, 'GLOGBO'),
(4403, 440, 'GLOGBO PLAGE'),
(4404, 440, 'HOVIDOKPO'),
(4405, 440, 'KPOGUIDI'),
(4406, 440, 'KRAKE-DAHO'),
(4407, 440, 'TOHOUE'),
(4408, 440, 'WEGBEGO-ADIEME'),
(4409, 441, 'AGONGO'),
(4410, 441, 'OKOUN-SEME'),
(4411, 441, 'PODJI-AGUE'),
(4412, 441, 'PODJI-AGUE GBAGO'),
(4413, 441, 'PODJI-MISSERETE'),
(4414, 441, 'SEME-PODJI'),
(4415, 442, 'ADJEGOUNLE'),
(4416, 442, 'ATTAN-EWE'),
(4417, 442, 'ATTAN-OUIGNAN-AYETEDJOU'),
(4418, 442, 'FOUDITI'),
(4419, 442, 'IGBO-IROKO'),
(4420, 442, 'IGBO-ORO'),
(4421, 442, 'IKPINLE-ITARAKA'),
(4422, 442, 'IKPINLE-SEKANME'),
(4423, 442, 'IKPINLE-YENAWA'),
(4424, 442, 'ILAKO-ABIALA'),
(4425, 442, 'IMORO'),
(4426, 442, 'ITA-BOLARINWA'),
(4427, 442, 'KADJOLA'),
(4428, 443, 'HOUEDAME'),
(4429, 443, 'IGBO-AIDIN'),
(4430, 443, 'IGBO-AKPORO'),
(4431, 443, 'IGBO-IROKO'),
(4432, 443, 'KPOULOU'),
(4433, 443, 'KPOULOU-IDI-EKPE'),
(4434, 443, 'KPOULOU-ITCHOUGAN'),
(4435, 443, 'TOWI'),
(4436, 443, 'TROBOSSI'),
(4437, 444, 'ABADAGO'),
(4438, 444, 'ADJODA'),
(4439, 444, 'AYELADJOU'),
(4440, 444, 'DANHIME'),
(4441, 444, 'EGBE-AGBO'),
(4442, 444, 'ICHOUGBO'),
(4443, 444, 'IGBO-IKOKO'),
(4444, 444, 'ITA AHOLOU'),
(4445, 444, 'MASSE'),
(4446, 444, 'MASSE-ADJEGOUNLE'),
(4447, 444, 'MOWOBANI'),
(4448, 444, 'OGOURO'),
(4449, 444, 'OKE-OLA'),
(4450, 444, 'OKO-DJEGUEDE'),
(4451, 444, 'OWOCHANDE'),
(4452, 444, 'TEFFI-OKEIGBALA'),
(4453, 445, 'ADJELEMIDE'),
(4454, 445, 'ITA-ARO'),
(4455, 445, 'ITA-EGBEBI'),
(4456, 445, 'ITA-EGBEBI-ALAKPAROU'),
(4457, 445, 'ITA-OGOU'),
(4458, 445, 'IWINKA'),
(4459, 445, 'KOKOROKEHOUN'),
(4460, 445, 'OBANIGBE-FOUDITI'),
(4461, 445, 'OGOUKPATE'),
(4462, 445, 'OKO-AKARE'),
(4463, 445, 'OLOGO'),
(4464, 445, 'OLOGO AKPAKPA'),
(4465, 446, 'ADJAGLO'),
(4466, 446, 'DJIDAGBA'),
(4467, 446, 'GBANOU'),
(4468, 446, 'ITCHAGBA-GBADODO'),
(4469, 446, 'ITCHANGNI'),
(4470, 446, 'LOGOU'),
(4471, 446, 'MISSEBO'),
(4472, 446, 'OLOHOUNGBODJE'),
(4473, 446, 'OUIGNAN-GBADODO'),
(4474, 446, 'TATONNONKON'),
(4475, 446, 'TATONNONKON JARDIN'),
(4476, 447, 'AFFACHA'),
(4477, 447, 'AFFESSEDA'),
(4478, 447, 'DAGBLA'),
(4479, 447, 'DOGBO'),
(4480, 447, 'EGBE'),
(4481, 447, 'GBAGBATA'),
(4482, 447, 'HOUELI-GABA'),
(4483, 447, 'IGBA'),
(4484, 447, 'ITCHEDE'),
(4485, 447, 'IWOYE-OKO-IGBO'),
(4486, 447, 'OBEKE-OUERE'),
(4487, 447, 'OKE-ODAN'),
(4488, 447, 'OKE-ODO'),
(4489, 447, 'OKOFFIN'),
(4490, 447, 'TOFFO'),
(4491, 448, 'AKADJA'),
(4492, 448, 'AKADJA-AGAMADIN'),
(4493, 448, 'AKADJA-GBODJE'),
(4494, 448, 'AKADJA-GOUTEDO'),
(4495, 448, 'BANIGBE GARE'),
(4496, 448, 'BANIGBE LOKOSSA'),
(4497, 448, 'BANIGBE-NAGOT'),
(4498, 448, 'DANGBAN'),
(4499, 448, 'DOOKE'),
(4500, 448, 'DOOKE-HANZOUME'),
(4501, 448, 'DOOKE-SEDJE'),
(4502, 448, 'HEGO'),
(4503, 448, 'LOKOSSA-ALIHOGODO'),
(4504, 448, 'LOUBE'),
(4505, 448, 'SEDO'),
(4506, 449, 'ADANMAYI'),
(4507, 449, 'DAAGBE-DJEDJE'),
(4508, 449, 'DAAGBE-NAGOT'),
(4509, 449, 'DAN'),
(4510, 449, 'DJEGOU-AYIDJEDO'),
(4511, 449, 'DJEGOU-DJEDJE'),
(4512, 449, 'DJEGOU-NAGOT'),
(4513, 449, 'GBLOGBLO'),
(4514, 449, 'GBLOGBLO AGBODJEDO'),
(4515, 449, 'LOKO-KOUKOU'),
(4516, 450, 'KITIGBO'),
(4517, 450, 'KO-AGONKESSA'),
(4518, 450, 'KO-AYIDJEDO'),
(4519, 450, 'KO-DOGBA'),
(4520, 450, 'KO-GBEGODO'),
(4521, 450, 'KO-HOUEZE'),
(4522, 450, 'KO-KOUMOLOU'),
(4523, 450, 'KO-OGOU'),
(4524, 450, 'KO-ZOUNGODO'),
(4525, 451, 'HOUMBO-DJEDJE'),
(4526, 451, 'HOUMBO-NAGOT'),
(4527, 451, 'KOUYE'),
(4528, 451, 'LAGBE'),
(4529, 451, 'OKEDJERE'),
(4530, 451, 'SOBE'),
(4531, 451, 'SOBE-AYELAWADJE'),
(4532, 451, 'SOKOU'),
(4533, 451, 'SOKOU-ALIHOGBOGO'),
(4534, 451, 'ZIAN'),
(4535, 452, 'AGBODJEDO'),
(4536, 452, 'DESSAH'),
(4537, 452, 'KETOU GBECON'),
(4538, 452, 'KETOUKPE'),
(4539, 452, 'KO-ANAGODO'),
(4540, 452, 'MONGBA'),
(4541, 452, 'TAMONDO'),
(4542, 452, 'TCHAADA CENTRE'),
(4543, 453, 'ARAROMI'),
(4544, 453, 'AYETEDJOU'),
(4545, 453, 'BAODJO'),
(4546, 453, 'GANMI'),
(4547, 453, 'GBOKOU'),
(4548, 453, 'GBOKOUTOU'),
(4549, 453, 'IDI-ORO'),
(4550, 453, 'IFANGNI-ODOFIN'),
(4551, 453, 'IGOLO'),
(4552, 453, 'IGUIGNANHOUN'),
(4553, 453, 'IKO'),
(4554, 453, 'ITA-ELEKPETE'),
(4555, 453, 'ITA-KPAKO'),
(4556, 453, 'ITA-SOUMBA'),
(4557, 453, 'IYOKO'),
(4558, 453, 'OKE-ODJA'),
(4559, 453, 'SORI'),
(4560, 454, 'ADAKPLAME'),
(4561, 454, 'AGONLIN-KPAHOU'),
(4562, 454, 'AGUIGADJI'),
(4563, 454, 'DOGO'),
(4564, 454, 'EDENOU'),
(4565, 454, 'EWE'),
(4566, 454, 'GBAKA-NANZE'),
(4567, 454, 'KINWO'),
(4568, 454, 'KOZOUNVI'),
(4569, 454, 'OHIZIHAN'),
(4570, 455, 'AKPAKAME'),
(4571, 455, 'ALAGBE-ILLIKIMOUN'),
(4572, 455, 'AWAYA'),
(4573, 455, 'AYEKOTONIAN'),
(4574, 455, 'EFFEOUTE'),
(4575, 455, 'EMEDA-IGBOILOUKAN'),
(4576, 455, 'IDIGNY'),
(4577, 455, 'IDJEDJE'),
(4578, 455, 'IGBO-IGANNAN'),
(4579, 455, 'ILLADJI'),
(4580, 455, 'ILLARA-KANGA'),
(4581, 455, 'ILLECHIN'),
(4582, 455, 'ILLIKIMOUN'),
(4583, 455, 'ILLIKIMOUN-KOLLY'),
(4584, 455, 'ISSELOU'),
(4585, 455, 'IWESSOUN'),
(4586, 455, 'IWOYE-BENIN'),
(4587, 455, 'OBATEDO'),
(4588, 455, 'OGUELETE'),
(4589, 456, 'ADJOZOUNME'),
(4590, 456, 'AGOZOUNME'),
(4591, 456, 'AGUIDI'),
(4592, 456, 'AKPAMBAOU'),
(4593, 456, 'ALAKOUTA'),
(4594, 456, 'AYEKOU'),
(4595, 456, 'AYETEDJOU'),
(4596, 456, 'GANGNIGON'),
(4597, 456, 'GBEGON'),
(4598, 456, 'IGBOOLA-OFIRI'),
(4599, 456, 'KAJOLA'),
(4600, 456, 'KPANKOU'),
(4601, 456, 'MOWODANI'),
(4602, 456, 'ODOKOTO'),
(4603, 456, 'SODJI'),
(4604, 456, 'VEDJI'),
(4605, 456, 'WOROKO'),
(4606, 456, 'ZOUNKPE-ETIGBO'),
(4607, 457, 'ATANKA'),
(4608, 457, 'ATAN-OCHOUKPA'),
(4609, 457, 'BOLOROUNFE'),
(4610, 457, 'IGBO-EDE'),
(4611, 457, 'KEWI'),
(4612, 457, 'ODOMETA'),
(4613, 457, 'OLOKA'),
(4614, 458, 'IDJOU'),
(4615, 458, 'IKOKO'),
(4616, 458, 'IMONLE-AYO'),
(4617, 458, 'OFIA'),
(4618, 458, 'OKPOMETA'),
(4619, 458, 'OMOU'),
(4620, 459, 'ASSENA'),
(4621, 459, 'ATCHOUBI'),
(4622, 459, 'AWAI'),
(4623, 459, 'AYELAWADJE'),
(4624, 459, 'DAGBANDJI'),
(4625, 459, 'IDADJE'),
(4626, 459, 'IDENA'),
(4627, 459, 'IDJABO'),
(4628, 459, 'IDOUFIN'),
(4629, 459, 'IGUI-OLOU'),
(4630, 459, 'INANSE'),
(4631, 459, 'IRADIGBAN'),
(4632, 459, 'MASSAFE'),
(4633, 459, 'OBAFEMI'),
(4634, 459, 'ODI-ARO'),
(4635, 459, 'OGUIDIGBO'),
(4636, 459, 'OKE-OLA'),
(4637, 459, 'OLOROUNSHOGO'),
(4638, 459, 'OSSOKODJO'),
(4639, 460, 'AHOYEYE'),
(4640, 460, 'AKPAMAN'),
(4641, 460, 'BANIGBE'),
(4642, 460, 'IDI-ORO'),
(4643, 460, 'IGBIDI'),
(4644, 460, 'ISSALE-IBERE'),
(4645, 460, 'ITA-ADELEYE'),
(4646, 460, 'OKE-ITA'),
(4647, 461, 'AGBELE'),
(4648, 461, 'AKPATE'),
(4649, 461, 'EGUELOU'),
(4650, 461, 'IGANA'),
(4651, 461, 'IGBO-ASSOGBA'),
(4652, 461, 'IHORO'),
(4653, 461, 'ILLEMON'),
(4654, 461, 'OGOUBA'),
(4655, 462, 'ABBA'),
(4656, 462, 'ATCHAGA'),
(4657, 462, 'GBANAGO'),
(4658, 462, 'IGBO-EWE'),
(4659, 462, 'ILLEKPA'),
(4660, 462, 'ILLOULOFIN'),
(4661, 462, 'ISSABA'),
(4662, 462, 'ITCHAGBA'),
(4663, 462, 'ITCHAKPO'),
(4664, 462, 'ITCHEDE'),
(4665, 462, 'ITCHOCHE'),
(4666, 462, 'IWOYE'),
(4667, 462, 'KADJOLA'),
(4668, 462, 'KETTY'),
(4669, 462, 'ONIGBOLO'),
(4670, 462, 'OUIGNAN-ILE'),
(4671, 463, 'CHAFFOU'),
(4672, 463, 'IBATE'),
(4673, 463, 'IGA'),
(4674, 463, 'IGBO-EDE'),
(4675, 463, 'IGBOKOFIN-EGUELOU'),
(4676, 463, 'IGBO-OCHO'),
(4677, 463, 'LAFENWA'),
(4678, 463, 'OTEKOTAN'),
(4679, 463, 'TOWE'),
(4680, 464, 'ADJEGOUNLE'),
(4681, 464, 'ADJISSOU'),
(4682, 464, 'AKOUHO'),
(4683, 464, 'AYERE-AGBAROU'),
(4684, 464, 'AYETEDJOU'),
(4685, 464, 'IDOGAN'),
(4686, 464, 'IGBOICHE'),
(4687, 464, 'ILLOUSSA-OSSOMOU'),
(4688, 464, 'ISSALE-AFFIN II'),
(4689, 464, 'ISSALE-AFFIN DOUANE'),
(4690, 464, 'ITA-ATINGA'),
(4691, 464, 'ITCHEKO'),
(4692, 464, 'MAMAGUE'),
(4693, 464, 'OKE ATA'),
(4694, 464, 'OKE OLA'),
(4695, 464, 'POBE-NORD'),
(4696, 464, 'TALALA'),
(4697, 465, 'AGADA-HOUNME'),
(4698, 465, 'AKPECHI'),
(4699, 465, 'ASSA-GAME'),
(4700, 465, 'ASSA-IDIOCHE'),
(4701, 465, 'BARIGBO-OWODE'),
(4702, 465, 'IBADJA SODJI'),
(4703, 465, 'IDJIBORO'),
(4704, 465, 'IGBO EGAN'),
(4705, 465, 'IKPEDJILE'),
(4706, 465, 'ILLAKO IDIORO'),
(4707, 465, 'ILLORO AGUIDI'),
(4708, 465, 'ILLOUGOU-KOSSOMI'),
(4709, 465, 'ITA ALABE'),
(4710, 465, 'ITA-AYINLA'),
(4711, 465, 'KOBEDJO'),
(4712, 465, 'MAKPA'),
(4713, 465, 'MODOGAN'),
(4714, 466, 'ADJEGOUNLE'),
(4715, 466, 'ARAROMI'),
(4716, 466, 'ATTAN OKOUTA-KADJOLA'),
(4717, 466, 'ATTAN-ONIBEDJI'),
(4718, 466, 'AYETORO OKE AWO'),
(4719, 466, 'IGBA'),
(4720, 466, 'IGBO-ABIKOU'),
(4721, 466, 'IGBO-ASSAN'),
(4722, 466, 'IGBOLA'),
(4723, 466, 'ILLAKO FAADJI-ITA AKPINTY'),
(4724, 466, 'IWERE'),
(4725, 466, 'MAKPOHOU'),
(4726, 467, 'ADJOHOUN-KOLLE'),
(4727, 467, 'ADJOHOUN-KOLLEDJEDJE'),
(4728, 467, 'AKADJA'),
(4729, 467, 'AYIDJEDO'),
(4730, 467, 'AYITA'),
(4731, 467, 'DRA'),
(4732, 467, 'GBAGLA NOUNAGNON'),
(4733, 467, 'GBOUGBOUTA'),
(4734, 467, 'HOUEGBO'),
(4735, 467, 'IKEMON'),
(4736, 467, 'OKE'),
(4737, 467, 'TAKON CENTRE'),
(4738, 468, 'ADANMAYI'),
(4739, 468, 'ARAROMI'),
(4740, 468, 'GBAGLA-YOVOGBEDJI'),
(4741, 468, 'ILLASSO NAGOT'),
(4742, 468, 'ILLASSO SAHARO'),
(4743, 468, 'OKEIGBO'),
(4744, 468, 'SAHARO DJEDJE'),
(4745, 468, 'SAHARO NAGOT'),
(4746, 468, 'SANRIN-KPINLE'),
(4747, 468, 'TOTA'),
(4748, 468, 'YOKO CENTRE'),
(4749, 469, 'ARAROMI'),
(4750, 469, 'ARIBIDESSI'),
(4751, 469, 'ATTEWO LARA'),
(4752, 469, 'DAGBAO'),
(4753, 469, 'DEGOUN'),
(4754, 469, 'DJOKO'),
(4755, 469, 'GBOKOUDAI'),
(4756, 469, 'IGBO-EYE'),
(4757, 469, 'ITA ORO-IREDE'),
(4758, 469, 'KADJOLA'),
(4759, 469, 'KOLOGBO MEKE'),
(4760, 469, 'KOSSI'),
(4761, 469, 'MIROKO'),
(4762, 469, 'MORO'),
(4763, 469, 'ODANYOGOUN'),
(4764, 469, 'ODELLA'),
(4765, 469, 'SODJI'),
(4766, 469, 'SURU LERE'),
(4767, 470, 'AGONSA'),
(4768, 470, 'DEGUE'),
(4769, 470, 'GBOZOUNMON'),
(4770, 470, 'HOUNME'),
(4771, 470, 'IGBO-AKPA'),
(4772, 470, 'ISSALE EKO'),
(4773, 470, 'ITA GBOKOU'),
(4774, 470, 'ODANREGOUN'),
(4775, 470, 'WAI'),
(4776, 470, 'YOGOU TOHOU'),
(4777, 470, 'ZIMON'),
(4778, 471, 'AKOUESSA'),
(4779, 471, 'DOKON'),
(4780, 471, 'GNANSATA'),
(4781, 471, 'OUEME'),
(4782, 471, 'SONOU AKOUTA'),
(4783, 471, 'SONOU FIYE'),
(4784, 472, 'ALLOMAKANME'),
(4785, 472, 'DETOHOU CENTRE'),
(4786, 472, 'GUEGUEZOGON'),
(4787, 472, 'KODJI CENTRE'),
(4788, 472, 'WO-TANGADJI'),
(4789, 473, 'HOUAO'),
(4790, 473, 'HOUELI'),
(4791, 473, 'LELE'),
(4792, 473, 'SEHOUN'),
(4793, 474, 'DILIKOTCHO'),
(4794, 474, 'GBEHIZANKON'),
(4795, 474, 'LEGBAHOLI'),
(4796, 474, 'LOKOKANME'),
(4797, 474, 'ZOUNZONME'),
(4798, 475, 'DJEGBE'),
(4799, 475, 'DJIME'),
(4800, 475, 'GBECON-HOUEGBO'),
(4801, 475, 'GOHO'),
(4802, 475, 'SOGBO-ALIHO'),
(4803, 475, 'SOHOUE'),
(4804, 475, 'TOHIZANLY'),
(4805, 476, 'AGBLOME'),
(4806, 476, 'AGNANGNAN'),
(4807, 476, 'AZALI'),
(4808, 476, 'GBEKON HOUNLI'),
(4809, 476, 'VEKPA'),
(4810, 476, 'WANKON'),
(4811, 476, 'ZASSA'),
(4812, 477, 'ADANDOKPODJI'),
(4813, 477, 'AGBODJANNANGAN'),
(4814, 477, 'AHOUAGA'),
(4815, 477, 'DOGUEME'),
(4816, 477, 'DOTA'),
(4817, 477, 'HOUNTONDJI'),
(4818, 477, 'SADA'),
(4819, 478, 'ADANHONDJIGON'),
(4820, 478, 'AZOZOUNDJI'),
(4821, 478, 'GNIZINTA'),
(4822, 478, 'KPATINME'),
(4823, 478, 'TANGOUDO'),
(4824, 479, 'ADINGNIGON'),
(4825, 479, 'MAKPEHOGON'),
(4826, 479, 'TOSSOTA'),
(4827, 480, 'AGBIDIME'),
(4828, 480, 'AHISSATOGON'),
(4829, 480, 'DANLI'),
(4830, 480, 'GBINDOUNME'),
(4831, 480, 'WEDJE'),
(4832, 481, 'AHOUAKANME'),
(4833, 481, 'AKODEBAKOU'),
(4834, 481, 'HAGBLADOU'),
(4835, 481, 'KPOTA'),
(4836, 481, 'ZOUNME'),
(4837, 482, 'DILLY-FANOU'),
(4838, 482, 'HOUNDO'),
(4839, 482, 'LISSAZOUNME'),
(4840, 482, 'MIGNONHITO'),
(4841, 482, 'OUNGBENOUDO'),
(4842, 482, 'SEKIDJATO'),
(4843, 482, 'ZOUNGBO-GBLOME'),
(4844, 483, 'ABIGO'),
(4845, 483, 'FONLI'),
(4846, 483, 'GBOZOUN 1'),
(4847, 483, 'GBOZOUN 2'),
(4848, 483, 'LOUKPE'),
(4849, 483, 'SOHOUE-DOVOTA'),
(4850, 484, 'ADJIDO'),
(4851, 484, 'DODOME'),
(4852, 484, 'HOUNTO'),
(4853, 484, 'LEGO'),
(4854, 485, 'DEKANME'),
(4855, 485, 'GBOLI'),
(4856, 485, 'HODJA'),
(4857, 485, 'HOUALA'),
(4858, 485, 'KPODJI'),
(4859, 485, 'TANVE'),
(4860, 485, 'TOWETA'),
(4861, 486, 'DODJI'),
(4862, 486, 'KANZOUN'),
(4863, 486, 'KPOTO'),
(4864, 486, 'TOKPA'),
(4865, 486, 'ZOUNGOUDO'),
(4866, 487, 'AGBANGNIZOUN'),
(4867, 487, 'AKPEHO-DOKPA'),
(4868, 487, 'AKPEHO-SEME'),
(4869, 487, 'AVALI'),
(4870, 487, 'AZANKPANTO'),
(4871, 487, 'TANTA'),
(4872, 488, 'FLELI'),
(4873, 488, 'MANABOE'),
(4874, 488, 'ZAKANME'),
(4875, 488, 'ZOUNGOUDO'),
(4876, 489, 'ADAME'),
(4877, 489, 'AGBOKOU'),
(4878, 489, 'AHOUADANOU'),
(4879, 489, 'GBETO'),
(4880, 489, 'ZOUNGOUDO'),
(4881, 489, 'ZOUNZONME'),
(4882, 490, 'ADAME-ADATO'),
(4883, 490, 'ALIGOUDO'),
(4884, 490, 'GNIDJAZOUN'),
(4885, 491, 'ADAGAME-LISEZOUN'),
(4886, 491, 'DAKPA'),
(4887, 491, 'HOUNDON'),
(4888, 491, 'LISSEZOUN'),
(4889, 492, 'AHOUALI'),
(4890, 492, 'ATTOGOUIN'),
(4891, 492, 'OUASSAHO'),
(4892, 492, 'VOLLI'),
(4893, 492, 'WANGNASSA'),
(4894, 492, 'ZOUNZONSA'),
(4895, 493, 'DJONOUTA'),
(4896, 493, 'HELOU'),
(4897, 493, 'LOTCHO'),
(4898, 493, 'MASSE-GBAME'),
(4899, 493, 'SOKPADELLI'),
(4900, 493, 'TOVIGOME'),
(4901, 494, 'ATCHONME'),
(4902, 494, 'SACLO-ALIKPA'),
(4903, 494, 'SACLO-SOKON'),
(4904, 495, 'ADANMINAKOUGON'),
(4905, 495, 'ALIKPA'),
(4906, 495, 'EDJEGBINMEGON'),
(4907, 495, 'LOKODAVE'),
(4908, 495, 'LOKOZOUN'),
(4909, 495, 'MADJE'),
(4910, 495, 'SODOHOME CENTRE'),
(4911, 495, 'TODO'),
(4912, 495, 'VEHOU'),
(4913, 495, 'ZOUNKPA-AGBOTOGON'),
(4914, 496, 'AGBADJAGON'),
(4915, 496, 'AGBANGON'),
(4916, 496, 'AGBANWEME'),
(4917, 496, 'AHOUAME'),
(4918, 496, 'AIWEME'),
(4919, 496, 'DJESSOUHOGON'),
(4920, 496, 'DJOGNANGBO'),
(4921, 496, 'HEZONHO'),
(4922, 496, 'HOUNDONHO'),
(4923, 496, 'KPATALOCOLI'),
(4924, 496, 'SEHOUEHO HOUNDONHO'),
(4925, 496, 'SEME'),
(4926, 497, 'ADAME-AHITO'),
(4927, 497, 'AGONVEZOUN'),
(4928, 497, 'AHOUAME-AHITO'),
(4929, 497, 'DOKON'),
(4930, 497, 'GANCON-PONSA'),
(4931, 497, 'GBANHICON'),
(4932, 497, 'HONMEHO'),
(4933, 497, 'KODOTA'),
(4934, 497, 'KPOCON'),
(4935, 497, 'SILIHO'),
(4936, 497, 'SOGBA'),
(4937, 497, 'ZAKPO-ADAGAME'),
(4938, 498, 'AGNANGAN'),
(4939, 498, 'HOUNDO'),
(4940, 498, 'HOUNVIGUELI'),
(4941, 498, 'YENAWA'),
(4942, 498, 'ZOUNGOUDO'),
(4943, 499, 'AZEHOUNHOLI'),
(4944, 499, 'DOME'),
(4945, 499, 'VOLI'),
(4946, 499, 'ZOUNSEGO'),
(4947, 500, 'AHITO'),
(4948, 500, 'DOME'),
(4949, 500, 'HOUNHOLI'),
(4950, 500, 'KPAGOUDO'),
(4951, 501, 'AGBANGNANHOUE'),
(4952, 501, 'AZONHOLI'),
(4953, 501, 'DAHOUE'),
(4954, 501, 'DAHOUIGON'),
(4955, 501, 'GANDAHOGON'),
(4956, 501, 'SESLAME'),
(4957, 501, 'TOUE'),
(4958, 502, 'ADJA'),
(4959, 502, 'AGA'),
(4960, 502, 'BAGON'),
(4961, 502, 'DANGBEHONOU'),
(4962, 502, 'DEKPADA'),
(4963, 502, 'MAKPEGON'),
(4964, 503, 'AGA'),
(4965, 503, 'AIZONDO'),
(4966, 503, 'ATTOGON'),
(4967, 503, 'FINANGNON'),
(4968, 503, 'HOUETON'),
(4969, 503, 'HOUEYIHO'),
(4970, 504, 'ABAYAHOUE'),
(4971, 504, 'AGA'),
(4972, 504, 'AGOSSOUHOUE'),
(4973, 504, 'VEME'),
(4974, 505, 'AKPATCHIHOUE'),
(4975, 505, 'FONLI'),
(4976, 505, 'SEKON-DJAKPA'),
(4977, 505, 'ZOGOLI'),
(4978, 506, 'AGBLOKPA'),
(4979, 506, 'AVOKANZOUN'),
(4980, 506, 'DJOHO'),
(4981, 506, 'FONKPAME'),
(4982, 506, 'GOUTCHON'),
(4983, 506, 'SAVAKON'),
(4984, 507, 'ASSAN'),
(4985, 507, 'AWOTRELE'),
(4986, 507, 'DENOU'),
(4987, 507, 'DJREKPEDJI'),
(4988, 507, 'GANGAN'),
(4989, 507, 'KOUDAGBA'),
(4990, 507, 'KOUEKOUEKANME'),
(4991, 507, 'SANKPITI'),
(4992, 507, 'TOKPE'),
(4993, 507, 'ZOUNGAHOU'),
(4994, 508, 'AGBOHOUTOGON'),
(4995, 508, 'ASSANTOUN'),
(4996, 508, 'DAANON-KPOTA'),
(4997, 508, 'DAN'),
(4998, 508, 'DRIDJI'),
(4999, 508, 'HANAGBO'),
(5000, 508, 'LALO'),
(5001, 508, 'LINSINLIN'),
(5002, 508, 'WOKOU'),
(5003, 509, 'BOHOUE'),
(5004, 509, 'DOHOUIME'),
(5005, 509, 'HEVI'),
(5006, 509, 'HONHOUN'),
(5007, 509, 'HOUKPA'),
(5008, 509, 'ZADAKON'),
(5009, 510, 'AHOKANME'),
(5010, 510, 'BETTA'),
(5011, 510, 'BOOKOU'),
(5012, 510, 'GOBAIX'),
(5013, 510, 'LAGBADO'),
(5014, 510, 'LAKPO'),
(5015, 511, 'AKLINME'),
(5016, 511, 'AMONTIKA'),
(5017, 511, 'CHIE'),
(5018, 511, 'HOUTO'),
(5019, 511, 'KOKOROKO'),
(5020, 511, 'VEVI'),
(5021, 512, 'AMAKPA'),
(5022, 512, 'FONKPODJI'),
(5023, 512, 'GOUNOUKOUIN'),
(5024, 512, 'KATAKENON (KAKA TEHOU)'),
(5025, 512, 'KOHOUGON'),
(5026, 512, 'KOUGBADJI'),
(5027, 512, 'LOBETA'),
(5028, 512, 'MONSOUROU'),
(5029, 512, 'YAGBANOUGON'),
(5030, 513, 'ADAME-HOUEGLO'),
(5031, 513, 'KPAKPANENE'),
(5032, 513, 'LELE-ADATO'),
(5033, 513, 'MOUGNON-AKE'),
(5034, 513, 'MOUGNON-KOSSOU'),
(5035, 513, 'TOSSOTA'),
(5036, 514, 'ADAME'),
(5037, 514, 'AHITO'),
(5038, 514, 'AIHOUIDJI'),
(5039, 514, 'KINGBE'),
(5040, 514, 'KPETETA'),
(5041, 514, 'LOTCHO-AHOUAME'),
(5042, 514, 'LOTCHO-DAHO'),
(5043, 514, 'SOZOUN'),
(5044, 514, 'TANNOUHO'),
(5045, 515, 'GBADAGBA'),
(5046, 515, 'KASSEHLO'),
(5047, 515, 'MAGASSA'),
(5048, 515, 'NONTCHEDIGBE'),
(5049, 515, 'SALOUDJI'),
(5050, 515, 'SETTO'),
(5051, 515, 'TOKEGON'),
(5052, 515, 'TOKOUNKOUN'),
(5053, 516, 'AHOZOUN'),
(5054, 516, 'AYOGBE'),
(5055, 516, 'DANMLONKOU'),
(5056, 516, 'ZOUNKON'),
(5057, 516, 'ZOUNME'),
(5058, 517, 'AGONDOKPOE'),
(5059, 517, 'AGONHOHOUN'),
(5060, 517, 'DJESSI'),
(5061, 517, 'DJIDJA-ALIGOUDO'),
(5062, 517, 'DONA'),
(5063, 517, 'GBIHOUNGON'),
(5064, 517, 'HOUNVI'),
(5065, 517, 'KOME'),
(5066, 517, 'MADJAVI'),
(5067, 517, 'SAWLAKPA'),
(5068, 517, 'SOVLEGNI'),
(5069, 517, 'WOGBAYE'),
(5070, 517, 'YE'),
(5071, 517, 'ZAKAN'),
(5072, 517, 'ZINKANME'),
(5073, 518, 'AGONKON'),
(5074, 518, 'BOSSA KPOTA'),
(5075, 518, 'BOSSA TOGOUDO'),
(5076, 518, 'GBOKPAGO'),
(5077, 518, 'GNANLI'),
(5078, 518, 'HOUANVE'),
(5079, 518, 'OUSSA'),
(5080, 518, 'TANNOU'),
(5081, 518, 'TOZOUNGO'),
(5082, 518, 'YAAGO'),
(5083, 518, 'ZOUNGUE'),
(5084, 519, 'ADAME'),
(5085, 519, 'AHOGO'),
(5086, 519, 'AIZE'),
(5087, 519, 'DOLIVI'),
(5088, 519, 'GAKOU'),
(5089, 519, 'HINVEDO'),
(5090, 519, 'HOUEDJA'),
(5091, 519, 'ILAKA-OZOKPODJI'),
(5092, 519, 'ODJA-IDOSSOU'),
(5093, 519, 'TEVEDJI'),
(5094, 520, 'AKASSA'),
(5095, 520, 'ALLABANDE'),
(5096, 520, 'DOKODJI'),
(5097, 520, 'GANGBAN'),
(5098, 520, 'HOUNNOUME'),
(5099, 520, 'KOLLY-HOUSSA'),
(5100, 520, 'MIDJANNANGNAN'),
(5101, 521, 'ADOGON'),
(5102, 521, 'AHICON'),
(5103, 521, 'AKANTE ZALOKO'),
(5104, 521, 'AKANTE ZOUNGO'),
(5105, 521, 'GANHOUNME'),
(5106, 521, 'HOLLI'),
(5107, 521, 'HOUAIDJA'),
(5108, 521, 'KINSODJI'),
(5109, 521, 'MANFOUGBON'),
(5110, 521, 'MONZOUNGOUDO'),
(5111, 521, 'OUOKON-AHLAN'),
(5112, 521, 'OUOKON-ZOUNGOME'),
(5113, 522, 'AYOGO'),
(5114, 522, 'BAME'),
(5115, 522, 'DOHOUNME'),
(5116, 522, 'HOUEGBO-AGA'),
(5117, 522, 'HOUEGBO-DO'),
(5118, 522, 'ZOUNGO-WOKPA'),
(5119, 523, 'AGBLADOHO'),
(5120, 523, 'AKOHAGON'),
(5121, 523, 'ASSIANGBOME'),
(5122, 523, 'GBATEZOUNME'),
(5123, 523, 'GBONOU'),
(5124, 523, 'MASSAGBO'),
(5125, 523, 'N\'DOKPO'),
(5126, 523, 'SOWE'),
(5127, 523, 'ZINGON'),
(5128, 524, 'DON-ALIHO'),
(5129, 524, 'DON-TOHOME'),
(5130, 524, 'GOBLIDJI'),
(5131, 524, 'TAN-ADJA'),
(5132, 524, 'TAN-HOUEGBO'),
(5133, 525, 'DIZIGO'),
(5134, 525, 'DOVE'),
(5135, 525, 'KLOBO'),
(5136, 525, 'LEGBADO'),
(5137, 525, 'SAGBOVI'),
(5138, 525, 'VODO'),
(5139, 525, 'ZOUNNOU'),
(5140, 526, 'AGONGBODJI'),
(5141, 526, 'AGONVE'),
(5142, 526, 'AHLAN'),
(5143, 526, 'AZAKPA'),
(5144, 526, 'KPOTO'),
(5145, 526, 'LOKO-ALANKPE'),
(5146, 526, 'WOMETO'),
(5147, 526, 'ZANTAN-IGBO-OLA'),
(5148, 527, 'DOGA-AGA'),
(5149, 527, 'DOGA-ALIKON'),
(5150, 527, 'DOGA-DOME'),
(5151, 527, 'KINGON'),
(5152, 527, 'TOKPLEGBE'),
(5153, 527, 'ZAGNANADO'),
(5154, 527, 'ZONMON'),
(5155, 527, 'ZOUNGOUDO'),
(5156, 528, 'ALLAHE'),
(5157, 528, 'AMLIHOHOUE-JARDIN'),
(5158, 528, 'DANGBEGON'),
(5159, 528, 'DOGBANLIN'),
(5160, 528, 'GANHOUA'),
(5161, 528, 'HEHOUNLI'),
(5162, 528, 'ZA-HLA'),
(5163, 529, 'ADJOKAN'),
(5164, 529, 'AKADJAME'),
(5165, 529, 'ASSANLIN'),
(5166, 529, 'KPOLOKOE'),
(5167, 529, 'SOWEKPA'),
(5168, 529, 'ZOUNZONME'),
(5169, 530, 'ADAME'),
(5170, 530, 'AKETEKPA'),
(5171, 530, 'FOLLY'),
(5172, 530, 'HOUNGOME'),
(5173, 530, 'KOGUEDE'),
(5174, 530, 'KPOKPOE'),
(5175, 531, 'AFFOSSOWOGBA'),
(5176, 531, 'DAVEGO'),
(5177, 531, 'DRAME'),
(5178, 531, 'KPAKPAME'),
(5179, 531, 'MLINKPIN-GUINGNIN'),
(5180, 531, 'SOME'),
(5181, 531, 'TANGBE'),
(5182, 531, 'TOGADJI'),
(5183, 532, 'ADOVI'),
(5184, 532, 'AHOSSOUGON'),
(5185, 532, 'AITEDEKPA'),
(5186, 532, 'DOTAN'),
(5187, 532, 'HOUANGON'),
(5188, 532, 'KPAKPASSA'),
(5189, 532, 'LOKOLI'),
(5190, 532, 'LONTONKPA'),
(5191, 532, 'YADIN'),
(5192, 532, 'ZOUNGOUDO'),
(5193, 533, 'ADIKOGON'),
(5194, 533, 'AGBAKOU'),
(5195, 533, 'AGONDOKPOE'),
(5196, 533, 'AGONKANME'),
(5197, 533, 'ALLIGOUDO'),
(5198, 533, 'DOUTIN'),
(5199, 533, 'HOUANLIKPA'),
(5200, 533, 'KEOU'),
(5201, 533, 'SOHOUNGO'),
(5202, 533, 'TANTA'),
(5203, 533, 'YOHOUE'),
(5204, 533, 'ZA-AGA'),
(5205, 534, 'ADAWEME'),
(5206, 534, 'ADJOKO'),
(5207, 534, 'AGONGBO'),
(5208, 534, 'DANTOTA'),
(5209, 534, 'ZEKO'),
(5210, 535, 'ADJIDO'),
(5211, 535, 'AGBOGBOMEY'),
(5212, 535, 'AGBOKPA'),
(5213, 535, 'DETEKPA'),
(5214, 535, 'DJOITIN'),
(5215, 535, 'DOKPA'),
(5216, 535, 'GNADOKPA'),
(5217, 535, 'HOUKANME'),
(5218, 535, 'KEMONDJI'),
(5219, 535, 'KODOTA'),
(5220, 535, 'SOGBELANKOU'),
(5221, 535, 'SOHOUNTA'),
(5222, 535, 'ZA-KEKERE'),
(5223, 535, 'ZA-KPOTA'),
(5224, 535, 'ZA-ZOUNME'),
(5225, 536, 'AKIZA'),
(5226, 536, 'DENOU-LISSEZIN'),
(5227, 536, 'DJIHIZIDE'),
(5228, 536, 'DON-AGONLIN'),
(5229, 536, 'DON-AKADJAME'),
(5230, 536, 'GOME'),
(5231, 536, 'GUEME'),
(5232, 536, 'SEME'),
(5233, 536, 'TOGBIN'),
(5234, 536, 'TOVLAME'),
(5235, 537, 'ALLADAHO'),
(5236, 537, 'AVAVI'),
(5237, 537, 'AVLAME'),
(5238, 537, 'KOTOKPA'),
(5239, 537, 'SAMIONKPA'),
(5240, 537, 'TOHOMEY'),
(5241, 537, 'YOKON'),
(5242, 538, 'DEGUELI'),
(5243, 538, 'DODOME'),
(5244, 538, 'DOGOUDO'),
(5245, 538, 'GANDJEKPINDJI'),
(5246, 538, 'GBAME'),
(5247, 538, 'KPOTA'),
(5248, 538, 'MALE'),
(5249, 539, 'AGOUNA'),
(5250, 539, 'DOHOUNVE'),
(5251, 539, 'GBANGNANME'),
(5252, 539, 'HADAGON'),
(5253, 539, 'ZOUNGBO-BOGON'),
(5254, 539, 'ZOUNGBO-ZOUNME'),
(5255, 540, 'AGA'),
(5256, 540, 'AGOITA'),
(5257, 540, 'BOLAME'),
(5258, 540, 'DOME'),
(5259, 540, 'DOME-GO'),
(5260, 540, 'GBAFFO'),
(5261, 540, 'GOHISSANOU'),
(5262, 540, 'KESSEDJOGON'),
(5263, 541, 'DEME'),
(5264, 541, 'KOUSSOUKPA'),
(5265, 541, 'LOKOLI'),
(5266, 541, 'SAMIONTA'),
(5267, 541, 'TCHIHEIGON'),
(5268, 542, 'AHOUANDJITOME'),
(5269, 542, 'AVANNANKANME'),
(5270, 542, 'DEHOUNTA'),
(5271, 542, 'DOGO'),
(5272, 542, 'GBEDIN'),
(5273, 542, 'HINZOUNME'),
(5274, 542, 'KPOKISSA'),
(5275, 543, 'HLAGBA-DENOU'),
(5276, 543, 'HLAGBA-DENOU ATCHA'),
(5277, 543, 'HLAGBA-LONME'),
(5278, 543, 'HLAGBA-OUASSA'),
(5279, 543, 'HLAGBA-ZAKPO'),
(5280, 543, 'HON'),
(5281, 543, 'MASSI'),
(5282, 543, 'MASSI ALLIGOUDO'),
(5283, 543, 'ZALIMEY'),
(5284, 543, 'ZOUNGOUDO'),
(5285, 544, 'AGADJALIGBO'),
(5286, 544, 'AGBLATA'),
(5287, 544, 'DON-ZOUKOUTOUDJA'),
(5288, 544, 'OUASSA'),
(5289, 544, 'TANWE-HESSOU'),
(5290, 544, 'TEGON'),
(5291, 544, 'TOWE'),
(5292, 545, 'AGRIMEY'),
(5293, 545, 'BOGNONGNON'),
(5294, 545, 'DOHOUE'),
(5295, 545, 'HLANHONOU'),
(5296, 545, 'KOTO'),
(5297, 545, 'ZOUKOU'),
(5298, 546, 'AHOUNDOME'),
(5299, 546, 'ATCHIA'),
(5300, 546, 'DOVOGON'),
(5301, 546, 'HAYA'),
(5302, 546, 'ZADO-ADAGON'),
(5303, 546, 'ZADO-GAGBE'),
(5304, 546, 'ZOGBODOMEY');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affecter_section`
--
ALTER TABLE `affecter_section`
  ADD CONSTRAINT `FK_B82094952EDDA160` FOREIGN KEY (`greffier_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B8209495611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`),
  ADD CONSTRAINT `FK_B82094959D18E664` FOREIGN KEY (`conseiller_rapporteur_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B8209495D823E37A` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`);

--
-- Contraintes pour la table `affecter_structure`
--
ALTER TABLE `affecter_structure`
  ADD CONSTRAINT `FK_FD63FCBA2534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`),
  ADD CONSTRAINT `FK_FD63FCBA3F683D83` FOREIGN KEY (`de_id`) REFERENCES `structure` (`id`),
  ADD CONSTRAINT `FK_FD63FCBA611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`);

--
-- Contraintes pour la table `affecter_user`
--
ALTER TABLE `affecter_user`
  ADD CONSTRAINT `FK_50D5A33210335F61` FOREIGN KEY (`expediteur_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_50D5A332611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`),
  ADD CONSTRAINT `FK_50D5A332A4F84F6E` FOREIGN KEY (`destinataire_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `arrets`
--
ALTER TABLE `arrets`
  ADD CONSTRAINT `FK_FC0D335B611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`),
  ADD CONSTRAINT `FK_FC0D335BB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `arrondissement`
--
ALTER TABLE `arrondissement`
  ADD CONSTRAINT `FK_3A3B64C4131A4F72` FOREIGN KEY (`commune_id`) REFERENCES `commune` (`id`);

--
-- Contraintes pour la table `audience`
--
ALTER TABLE `audience`
  ADD CONSTRAINT `FK_FDCD941881703196` FOREIGN KEY (`date_date_id`) REFERENCES `date` (`id`);

--
-- Contraintes pour la table `avis_paquet`
--
ALTER TABLE `avis_paquet`
  ADD CONSTRAINT `FK_672321A0611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`);

--
-- Contraintes pour la table `commune`
--
ALTER TABLE `commune`
  ADD CONSTRAINT `FK_E2E2D1EECCF9E01E` FOREIGN KEY (`departement_id`) REFERENCES `departement` (`id`);

--
-- Contraintes pour la table `conseiller_partie`
--
ALTER TABLE `conseiller_partie`
  ADD CONSTRAINT `FK_C90F7691E075F7A4` FOREIGN KEY (`partie_id`) REFERENCES `partie` (`id`);

--
-- Contraintes pour la table `deliberation_dossiers`
--
ALTER TABLE `deliberation_dossiers`
  ADD CONSTRAINT `FK_53ED245B611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`);

--
-- Contraintes pour la table `dossier`
--
ALTER TABLE `dossier`
  ADD CONSTRAINT `FK_3D48E0372534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`),
  ADD CONSTRAINT `FK_3D48E03730AA44A2` FOREIGN KEY (`defendeur_id`) REFERENCES `partie` (`id`),
  ADD CONSTRAINT `FK_3D48E0374A93DAA5` FOREIGN KEY (`requerant_id`) REFERENCES `partie` (`id`),
  ADD CONSTRAINT `FK_3D48E037B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_3D48E037C24AFBDB` FOREIGN KEY (`provenance_id`) REFERENCES `provenance` (`id`),
  ADD CONSTRAINT `FK_3D48E037F520CF5A` FOREIGN KEY (`objet_id`) REFERENCES `objet` (`id`);

--
-- Contraintes pour la table `dossier_audience`
--
ALTER TABLE `dossier_audience`
  ADD CONSTRAINT `FK_D58D766F611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D58D766F848CC616` FOREIGN KEY (`audience_id`) REFERENCES `audience` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `dossier_pieces_jointes`
--
ALTER TABLE `dossier_pieces_jointes`
  ADD CONSTRAINT `FK_4B2B8238611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`);

--
-- Contraintes pour la table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `FK_8F3F68C5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `mesures_instructions`
--
ALTER TABLE `mesures_instructions`
  ADD CONSTRAINT `FK_3514FE22EDDA160` FOREIGN KEY (`greffier_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_3514FE2611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`),
  ADD CONSTRAINT `FK_3514FE29D18E664` FOREIGN KEY (`conseiller_rapporteur_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `modele_rapport`
--
ALTER TABLE `modele_rapport`
  ADD CONSTRAINT `FK_BBB95A4E2534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`),
  ADD CONSTRAINT `FK_BBB95A4ED823E37A` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`);

--
-- Contraintes pour la table `mouvement`
--
ALTER TABLE `mouvement`
  ADD CONSTRAINT `FK_5B51FC3E611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`),
  ADD CONSTRAINT `FK_5B51FC3EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_5B51FC3EF6203804` FOREIGN KEY (`statut_id`) REFERENCES `statut` (`id`);

--
-- Contraintes pour la table `paiement_consignation`
--
ALTER TABLE `paiement_consignation`
  ADD CONSTRAINT `FK_A3AEEFE8611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`);

--
-- Contraintes pour la table `partie`
--
ALTER TABLE `partie`
  ADD CONSTRAINT `FK_59B1F3D924DD2B5` FOREIGN KEY (`localite_id`) REFERENCES `arrondissement` (`id`);

--
-- Contraintes pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD CONSTRAINT `FK_B92D747260BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B92D7472611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`);

--
-- Contraintes pour la table `rapport`
--
ALTER TABLE `rapport`
  ADD CONSTRAINT `FK_BE34A09C611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`),
  ADD CONSTRAINT `FK_BE34A09CB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_BE34A09CEEACDBB7` FOREIGN KEY (`modele_rapport_id`) REFERENCES `modele_rapport` (`id`);

--
-- Contraintes pour la table `reponse_mesures_instructions`
--
ALTER TABLE `reponse_mesures_instructions`
  ADD CONSTRAINT `FK_E64881E843AB22FA` FOREIGN KEY (`mesure_id`) REFERENCES `mesures_instructions` (`id`);

--
-- Contraintes pour la table `representant`
--
ALTER TABLE `representant`
  ADD CONSTRAINT `FK_80D5DBC9E075F7A4` FOREIGN KEY (`partie_id`) REFERENCES `partie` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `FK_4E977E5C2534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`);

--
-- Contraintes pour la table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `FK_2D737AEF2534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6492534008B` FOREIGN KEY (`structure_id`) REFERENCES `structure` (`id`),
  ADD CONSTRAINT `FK_8D93D649577906E4` FOREIGN KEY (`sections_id`) REFERENCES `section` (`id`);

--
-- Contraintes pour la table `user_dossier`
--
ALTER TABLE `user_dossier`
  ADD CONSTRAINT `FK_6545FE3D611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`),
  ADD CONSTRAINT `FK_6545FE3DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `village`
--
ALTER TABLE `village`
  ADD CONSTRAINT `FK_4E6C7FAA407DBC11` FOREIGN KEY (`arrondissement_id`) REFERENCES `arrondissement` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
