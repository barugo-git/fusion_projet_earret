-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 22 août 2025 à 14:13
-- Version du serveur : 9.3.0
-- Version de PHP : 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `affecter_section`
--

CREATE TABLE `affecter_section` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `greffier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `conseiller_rapporteur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `section_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_affectation` datetime DEFAULT NULL,
  `motif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delai_traitement` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `affecter_structure`
--

CREATE TABLE `affecter_structure` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `de_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_affection` datetime DEFAULT NULL,
  `motif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delai_traitement` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `affecter_user`
--

CREATE TABLE `affecter_user` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `destinataire_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `expediteur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_affection` datetime DEFAULT NULL,
  `motif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delai_traitement` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `arrets`
--

CREATE TABLE `arrets` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `created_by_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_arret` datetime DEFAULT NULL,
  `titrage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resume` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `commentaire` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `arret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_arret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forclusion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `arrondissement`
--

CREATE TABLE `arrondissement` (
  `id` int NOT NULL,
  `commune_id` int DEFAULT NULL,
  `lib_arrond` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `audience` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `date_date_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_audience` datetime DEFAULT NULL,
  `avis_audience` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentaire` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date` datetime DEFAULT NULL,
  `heure_audience` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avis_paquet`
--

CREATE TABLE `avis_paquet` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `avis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commune`
--

CREATE TABLE `commune` (
  `id` int NOT NULL,
  `departement_id` int DEFAULT NULL,
  `libcom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `conseiller_partie` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `partie_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `nom_cabinet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_avocat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom_avocat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_avocat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `date`
--

CREATE TABLE `date` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `deliberation_dossiers`
--

CREATE TABLE `deliberation_dossiers` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `avis_deliberation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id` int NOT NULL,
  `lib_dep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Structure de la table `dossier`
--

CREATE TABLE `dossier` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `objet_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `provenance_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `requerant_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `defendeur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `created_by_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `reference_enregistrement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  `type_dossier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_dossier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intitule_objet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_dossier_complet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat_dossier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_ouverture` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `nature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autorisation` tinyint(1) DEFAULT NULL,
  `clos` tinyint(1) DEFAULT NULL,
  `date_cloture` date DEFAULT NULL,
  `motif_cloture` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `arrete_attaquee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consignation` tinyint(1) DEFAULT NULL,
  `memoire_ampliatif` tinyint(1) DEFAULT NULL,
  `date_memoire_ampliatif` datetime DEFAULT NULL,
  `memoire_en_defense` tinyint(1) DEFAULT NULL,
  `date_memoire_en_defense` datetime DEFAULT NULL,
  `date_consignation` date DEFAULT NULL,
  `preuve_consignation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_memoire_ampliatif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_memoire_en_defense` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_suivi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `externe` tinyint(1) DEFAULT NULL,
  `annotation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_autorisation` datetime DEFAULT NULL,
  `statut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calendrier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rapport_cr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation_description_requerante` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observation_fichier_requerante` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observation_description_defendeur` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observation_fichier_defendeur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rapport_description_cr` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fin_mesures_instruction` tinyint(1) DEFAULT NULL,
  `fin_mesures_instruction_at` datetime DEFAULT NULL,
  `recu_consignation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_preuve_consignation_requerant` date DEFAULT NULL,
  `preuve_consignation_requerant` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dossier_audience`
--

CREATE TABLE `dossier_audience` (
  `dossier_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `audience_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dossier_pieces_jointes`
--

CREATE TABLE `dossier_pieces_jointes` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `instructions`
--

CREATE TABLE `instructions` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delais` int DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `instructions`
--

INSERT INTO `instructions` (`id`, `libelle`, `delais`, `active`) VALUES
(0x01962afe01bf7bbc90d545da6ff939fe, 'Paiement de consignation', 15, 1),
(0x01962e59901f7c81bd335b318626ed9e, 'Production de mémoire ampliatif', 60, 1),
(0x01962e5a1ac6770ead0951e7eba0094f, 'Mise en demeure pour production de mémoire ampliantif', 30, 1),
(0x01962e72374a7e80913aa005ef40c8e9, 'Constitution d\'avocats', 2, 1),
(0x01962e78160a77d9bc0401459d074bcf, 'Communiquer les noms des conseils', 2, 1),
(0x01962e7f2b9773dfafa6ab077ed02a84, 'Communiquer les clonclusions du parquet aux deux parties', 30, 1),
(0x01962eb9fa6071a08977e7a78b258b48, 'Produire les conclusions du Parquet', 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

CREATE TABLE `log` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `user_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `level` smallint NOT NULL,
  `level_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mesures_instructions`
--

CREATE TABLE `mesures_instructions` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `conseiller_rapporteur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `greffier_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `created_at` datetime NOT NULL,
  `date` datetime DEFAULT NULL,
  `parties_concernes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `termine` tinyint(1) DEFAULT NULL,
  `termine_at` datetime NOT NULL,
  `alerte_envoyee` tinyint(1) DEFAULT NULL,
  `instruction_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `observations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `delais` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `modele_rapport`
--

CREATE TABLE `modele_rapport` (
  `id` int NOT NULL,
  `structure_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `section_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `nom_fichier` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fichier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `update_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `type_rapport` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `mouvement` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `user_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `statut_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `date_mouvement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `objet`
--

CREATE TABLE `objet` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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

CREATE TABLE `paiement_consignation` (
  `id` int NOT NULL,
  `dossier_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `consignation` tinyint(1) NOT NULL,
  `id_transaction` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_paiement` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `montant` double NOT NULL,
  `preuve_consignation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode_paiement` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `partie`
--

CREATE TABLE `partie` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `localite_id` int DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenoms` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intitule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

CREATE TABLE `pieces` (
  `id` int NOT NULL,
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `auteur_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `description_piece` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updaded_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `nature_piece` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `provenance`
--

CREATE TABLE `provenance` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rapport`
--

CREATE TABLE `rapport` (
  `id` int NOT NULL,
  `created_by_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `modele_rapport_id` int NOT NULL,
  `dossier_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `fichier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `update_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `donnees` json DEFAULT NULL,
  `statut` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'brouillon',
  `type_rapport` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse_mesures_instructions`
--

CREATE TABLE `reponse_mesures_instructions` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `mesure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `reponse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_mise_directive` datetime DEFAULT NULL,
  `date_notification` datetime DEFAULT NULL,
  `reponse_partie` tinyint(1) DEFAULT NULL,
  `termine` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `representant`
--

CREATE TABLE `representant` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `partie_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `user_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `selector` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
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

CREATE TABLE `section` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `code_section` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
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

CREATE TABLE `statut` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id`, `libelle`) VALUES
(0x019244e462f67503849247a2a4ce3b54, 'Consignation et production de mémoire ampliatif'),
(0x019244e4e99079f78845234ccb9e0e77, 'Communication de dossier  au Parquet Général pour production de conclusions'),
(0x019244e589327b368e7e93b96aebf286, 'Communication de conclusions aux parties ayant préalablement produit un mémoireossiers en attente des observations des parties'),
(0x019244e70d367422a778709a35473109, 'Dossier au rapport'),
(0x01924c13b5557dc7b4e877c9045cc194, 'Dossiers audiencé'),
(0x0196a2c8b1ec7d928b25f6f5832f37ab, 'Dossier vidé'),
(0x0196abecbbee7f2a9c4b1d4185a02716, 'Dossier renvoyé à l\'instruction'),
(0x0196abed837478df84a003158161817f, 'Arrêt signé et dossier communiqué au greffe des arrêts pour notification'),
(0x0196abef5a2270edb19e0f4fe3d79f29, 'Communication de mémoire ampliatif pour production de mémoire en défense');

-- --------------------------------------------------------

--
-- Structure de la table `structure`
--

CREATE TABLE `structure` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `code_structure` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
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

CREATE TABLE `user` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `structure_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `sections_id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenoms` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `password_change_required` tinyint(1) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `structure_id`, `sections_id`, `email`, `roles`, `password`, `nom`, `prenoms`, `telephone`, `actif`, `last_login`, `titre`, `token`, `is_verified`, `password_change_required`, `photo`) VALUES
(0x0191ae5bdf5e74168ee884cbf400a848, 0x0191ae4735af763ba31742744906c8cf, 0x0191ae4c55177898bbfb0184686c1b32, 'akarimou@coursupreme.bj', '[\"ROLE_SUPER_ADMIN\"]', '$2y$13$Jq1OyXvPmH9jVIbMRsbgcu9WL/QR152s9/dsG4u4zh3SyGZtC3KFi', 'KARIMOU AMADOU', 'Abdoul Nassirou', '97719794', 1, NULL, 'AUTRES AGENTS', NULL, 0, 0, NULL),
(0x019247db9589746e82c0b0a473ef9bd3, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247da5132794aa006f669ea980f71, 'pcj@gmail.com', '[\"ROLE_PCJ\"]', '$2y$13$OhV.SQt9kd4hsFrw3ZZknuDbvHI1ejzgIYi2Arx1.442HEB1u2Zlq', 'PCJ', 'PCJ', '55555555', 1, NULL, 'PRESIDENT DE STRUCTURE', NULL, 0, 0, NULL),
(0x019247decd437f328344f05ee9731722, 0x0191ce9931287240af7cef77ed00541a, 0x0191cec4ab23725291e516a97cf8479c, 'bo@gmail.com', '[\"ROLE_BUREAU_ORIENTATION\"]', '$2y$13$FwkhdwkwnFI/ZvJO.8NoVescAsg2n2L9dPdewVqYbxeEd5yV8iy1a', 'BO', 'BO', '66666666', 1, NULL, 'AUTRES AGENTS', NULL, 0, 0, NULL),
(0x019247e18da472258c9b2ffb0ac456f7, 0x0191ce9931287240af7cef77ed00541a, 0x0191cec4ab23725291e516a97cf8479c, 'gec@gmail.com', '[\"ROLE_GREFFIER_EN_CHEF\"]', '$2y$13$p0/B56tzXQ3gJ2vnYmFiZuowdVLXwFrFNcbMEZ/2dqJSRgGI34Flq', 'GEC', 'Gec', '22222222', 1, NULL, 'GREFFIER EN CHEF', NULL, 0, 0, NULL),
(0x019247e3bd727123b8a3cbedf6b2da9a, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'cr@gmail.com', '[\"ROLE_CONSEILLER\"]', '$2y$13$k14kYH9sngHTpePWQy0qJOWE/2dt7e84eVvzaNu9uJZI52MXawOVa', 'RAPPORTEUR', 'Conseiller', '222222', 1, NULL, 'CONSEILLER', NULL, 0, 0, NULL),
(0x019247e59b0875bcbbf0a4a9e3e43d55, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'greffier1cj@gmail.com', '[\"ROLE_GREFFIER\"]', '$2y$13$M7DGyFykSfdbTM7xkaxVV.1848UHm7L8PX0U1xvnS5z10ssJRKzM6', 'GREFFIER', 'CJ', '11111111', 1, NULL, 'GREFFIER', NULL, 0, 0, NULL),
(0x01926c99522e7199b98627e2811e830d, 0x0191ae4201167fab94810a32b44f2ec4, 0x01926c9761d877b9a4a31281f6f9b131, 'pca@gmail.com', '[\"ROLE_PCA\"]', '$2y$13$JnWFJ77oRIpZxRx11to0M.dtkS2/A34BUpEILOZSQBssPerAoSlKa', 'PCA', 'PCA', '97771222', 1, NULL, 'PRESIDENT DE STRUCTURE', NULL, 0, 0, NULL),
(0x01926c9aaf887863b3ea7bd16dd11dec, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, 'greffier1ca@gmail.com', '[\"ROLE_GREFFIER\"]', '$2y$13$V5gGn7TAaUJ.dWupMyYDwOJu4L0UKyaAIwY9bX0VQjDEKWbN85pcm', 'Greffier', 'CA', '12121212', 1, NULL, 'GREFFIER', NULL, 0, 0, NULL),
(0x01926d02517577f5b25c975f840c6c67, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, 'crca@gmail.com', '[\"ROLE_CONSEILLER\"]', '$2y$13$79P37Rjc3DaSTvLP5rkLLODdT3FDMOoMnVAzuv59WQBSZbzKrxvgC', 'cr', 'CA', '11111111', 1, NULL, 'CONSEILLER', NULL, 0, 0, NULL),
(0x0192b3ce60507473afadd28e50c30437, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae4aed3b7c9082409530f8a470d8, 'crcj@gmail.com', '[\"ROLE_CONSEILLER\"]', '$2y$13$ZX/V/DPv..NM8/tJxjrR6uYBtpvgkDI8WUWNnfcKeZL8xKXK4y2O.', 'CONSEILLER', 'Rapporeur', '61510059', 1, NULL, 'CONSEILLER', NULL, 0, 0, NULL),
(0x0192b3d0796673feb54bbbec0868c022, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae4aed3b7c9082409530f8a470d8, 'greffiercj@gmail.com', '[\"ROLE_GREFFIER\"]', '$2y$13$69WWE.xnZQR4XnhDmDgwNeDqWiREXkO5K2GWyVDnhblvMG1SBIpBy', 'Greffier', 'CJ', '97719794', 1, NULL, 'GREFFIER', NULL, 0, 0, NULL),
(0x0194835d29a875f180f18b99267cf632, 0x0191ae4735af763ba31742744906c8cf, 0x0191ae4c55177898bbfb0184686c1b32, 'abdoul.ousmane@coursupreme.bj', '[\"ROLE_SUPER_ADMIN\"]', '$2y$13$Sfoy0milV1NFtQhgBxBwrOZZxGVEWhfd.k6ls0DTW7HjedLAz1yEa', 'OUSMANE', 'Abdoul Matine', '0197210388', 1, NULL, 'AUTRES AGENTS', NULL, 0, 1, NULL),
(0x019483b39f8c7ae6926901a9664bebca, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'wilfrid.araba@coursupreme.bj', '[\"ROLE_CONSEILLER\"]', '$2y$13$0oyEW38U0LPkYiqlCfUuIeYZ4p7Ikyiqcg00pJmPLmiRN4bTYIjhm', 'ARABA', 'Wilfrid', '11111111', 1, NULL, 'CONSEILLER', NULL, 0, 0, NULL),
(0x019488fa678f7082b35c3a62a09c50ee, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae4aed3b7c9082409530f8a470d8, 'aisanoussi@coursupreme.bj', '[\"ROLE_CONSEILLER\"]', '$2y$13$hsAT.p3hVZ2CWCsD3GILrOI35/JhylCIxK6WxrP1yDoqVxq6EDKom', 'SANOUSSI', 'Ismaël Anselme', '11111111111', 1, NULL, 'CONSEILLER', NULL, 0, 0, NULL),
(0x01948900efb571268e22fa213a704571, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae49b7c374339114c93d422afabe, 'olawani@coursupreme.bj', '[\"ROLE_CONSEILLER\"]', '$2y$13$W..T/2lenzZnh6DpTdduOOHTEEdXAwCPd7xl3AG4BLiUK.fGqWWeW', 'LAWANI Olatoundji', 'Badirou', '1111111111', 1, NULL, 'CONSEILLER', NULL, 0, 1, NULL),
(0x01948912f0167f72911f0e2b0f72dc79, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'ladjado@coursupreme.bj', '[\"ROLE_GREFFIER\"]', '$2y$13$1TKClauoRLPffC0wox/2uuW3lRY74WzfuF0DWRxgu402g7APH7OPC', 'ADJADO', 'Oussou Léonce', '111111111', 1, NULL, 'GREFFIER', NULL, 0, 1, NULL),
(0x0194891796857eccaed88aab5733c771, 0x0191ae417a7373ec9e2d67ba9adab788, 0x0191ae49b7c374339114c93d422afabe, 'kaffewe@coursupreme.bj', '[\"ROLE_GREFFIER\"]', '$2y$13$h0f3Hv4v4SgI4e.qM18VVeqD/pgON66Z0.6LifshHxc7QQsjZYKJS', 'AFFEWE', 'Kodjihounkan Appolinaire', '111111111', 1, NULL, 'GREFFIER', NULL, 0, 1, NULL),
(0x0194892208b47baf9650aaeaf92f3394, 0x0191ae417a7373ec9e2d67ba9adab788, 0x019247d9aed4773ca611df385483f6bf, 'helene.nahum@coursupreme.bj', '[\"ROLE_GREFFIER\"]', '$2y$13$otlANf.wOPjoEIEo9VGBXODPsethDUgqumKw4yeNXoKmb8vQEJ8uK', 'NAHUM', 'Hélène', '111111111', 1, NULL, 'GREFFIER', NULL, 0, 1, NULL),
(0x0194896af3ce7ec4a25e609cd899bd90, 0x0191ae4201167fab94810a32b44f2ec4, 0x0191ae4b392b7cd2a8b7e5d1c3a35640, 'apinassirou@gmail.com', '[\"ROLE_PROCUREUR_GENERAL\"]', '$2y$13$TE2wWnsgu1uTO7juhJ7hheuJWHGk/4SIR0DJNyWuG1lKDohV4xzHK', 'TEST', 'TESt', '11111111', NULL, NULL, 'AVOCAT GENERAL', NULL, 0, 1, NULL),
(0x0194897883f176a6a7b27c6b2af8ef00, 0x0194896f56e8727e944341a5550a573f, 0x01948971cb937a7ea50221480581bfe8, 'djidonou.afaton@coursupreme.bj', '[\"ROLE_PROCUREUR_GENERAL\"]', '$2y$13$RQ0IoMGV0BGs48gjFTGS0eIz/ek9OVa2oOfT2IxJBwb01PlECjQia', 'AFATON', 'Djidonou Saturnin', '11111111', 1, NULL, 'PROCUREUR GENERAL', NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_dossier`
--

CREATE TABLE `user_dossier` (
  `id` binary(16) NOT NULL COMMENT '(DC2Type:uuid)',
  `user_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `dossier_id` binary(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `many_to_one` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_affectation` datetime DEFAULT NULL,
  `delai` int DEFAULT NULL,
  `nature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `village`
--

CREATE TABLE `village` (
  `id` int NOT NULL,
  `arrondissement_id` int DEFAULT NULL,
  `lib_village` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Index pour les tables déchargées
--

--
-- Index pour la table `affecter_section`
--
ALTER TABLE `affecter_section`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_B8209495611C0C56` (`dossier_id`),
  ADD KEY `IDX_B82094952EDDA160` (`greffier_id`),
  ADD KEY `IDX_B82094959D18E664` (`conseiller_rapporteur_id`),
  ADD KEY `IDX_B8209495D823E37A` (`section_id`);

--
-- Index pour la table `affecter_structure`
--
ALTER TABLE `affecter_structure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FD63FCBA611C0C56` (`dossier_id`),
  ADD KEY `IDX_FD63FCBA2534008B` (`structure_id`),
  ADD KEY `IDX_FD63FCBA3F683D83` (`de_id`);

--
-- Index pour la table `affecter_user`
--
ALTER TABLE `affecter_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_50D5A332611C0C56` (`dossier_id`),
  ADD KEY `IDX_50D5A332A4F84F6E` (`destinataire_id`),
  ADD KEY `IDX_50D5A33210335F61` (`expediteur_id`);

--
-- Index pour la table `arrets`
--
ALTER TABLE `arrets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FC0D335BB03A8386` (`created_by_id`),
  ADD KEY `IDX_FC0D335B611C0C56` (`dossier_id`);

--
-- Index pour la table `arrondissement`
--
ALTER TABLE `arrondissement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3A3B64C4131A4F72` (`commune_id`);

--
-- Index pour la table `audience`
--
ALTER TABLE `audience`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FDCD941881703196` (`date_date_id`);

--
-- Index pour la table `avis_paquet`
--
ALTER TABLE `avis_paquet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_672321A0611C0C56` (`dossier_id`);

--
-- Index pour la table `commune`
--
ALTER TABLE `commune`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E2E2D1EECCF9E01E` (`departement_id`);

--
-- Index pour la table `conseiller_partie`
--
ALTER TABLE `conseiller_partie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C90F7691E075F7A4` (`partie_id`);

--
-- Index pour la table `date`
--
ALTER TABLE `date`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `deliberation_dossiers`
--
ALTER TABLE `deliberation_dossiers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_53ED245B611C0C56` (`dossier_id`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dossier`
--
ALTER TABLE `dossier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3D48E037F520CF5A` (`objet_id`),
  ADD KEY `IDX_3D48E0372534008B` (`structure_id`),
  ADD KEY `IDX_3D48E037C24AFBDB` (`provenance_id`),
  ADD KEY `IDX_3D48E0374A93DAA5` (`requerant_id`),
  ADD KEY `IDX_3D48E03730AA44A2` (`defendeur_id`),
  ADD KEY `IDX_3D48E037B03A8386` (`created_by_id`);

--
-- Index pour la table `dossier_audience`
--
ALTER TABLE `dossier_audience`
  ADD PRIMARY KEY (`dossier_id`,`audience_id`),
  ADD KEY `IDX_D58D766F611C0C56` (`dossier_id`),
  ADD KEY `IDX_D58D766F848CC616` (`audience_id`);

--
-- Index pour la table `dossier_pieces_jointes`
--
ALTER TABLE `dossier_pieces_jointes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4B2B8238611C0C56` (`dossier_id`);

--
-- Index pour la table `instructions`
--
ALTER TABLE `instructions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8F3F68C5A76ED395` (`user_id`);

--
-- Index pour la table `mesures_instructions`
--
ALTER TABLE `mesures_instructions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3514FE2611C0C56` (`dossier_id`),
  ADD KEY `IDX_3514FE29D18E664` (`conseiller_rapporteur_id`),
  ADD KEY `IDX_3514FE22EDDA160` (`greffier_id`),
  ADD KEY `IDX_3514FE262A10F76` (`instruction_id`);

--
-- Index pour la table `modele_rapport`
--
ALTER TABLE `modele_rapport`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BBB95A4E2534008B` (`structure_id`),
  ADD KEY `IDX_BBB95A4ED823E37A` (`section_id`);

--
-- Index pour la table `mouvement`
--
ALTER TABLE `mouvement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5B51FC3EA76ED395` (`user_id`),
  ADD KEY `IDX_5B51FC3E611C0C56` (`dossier_id`),
  ADD KEY `IDX_5B51FC3EF6203804` (`statut_id`);

--
-- Index pour la table `objet`
--
ALTER TABLE `objet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiement_consignation`
--
ALTER TABLE `paiement_consignation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_A3AEEFE8611C0C56` (`dossier_id`);

--
-- Index pour la table `partie`
--
ALTER TABLE `partie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_59B1F3D924DD2B5` (`localite_id`);

--
-- Index pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B92D7472611C0C56` (`dossier_id`),
  ADD KEY `IDX_B92D747260BB6FE6` (`auteur_id`);

--
-- Index pour la table `provenance`
--
ALTER TABLE `provenance`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rapport`
--
ALTER TABLE `rapport`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_BE34A09C611C0C56` (`dossier_id`),
  ADD KEY `IDX_BE34A09CEEACDBB7` (`modele_rapport_id`),
  ADD KEY `IDX_BE34A09CB03A8386` (`created_by_id`);

--
-- Index pour la table `reponse_mesures_instructions`
--
ALTER TABLE `reponse_mesures_instructions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E64881E843AB22FA` (`mesure_id`);

--
-- Index pour la table `representant`
--
ALTER TABLE `representant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_80D5DBC9E075F7A4` (`partie_id`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4E977E5C2534008B` (`structure_id`);

--
-- Index pour la table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2D737AEF2534008B` (`structure_id`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `structure`
--
ALTER TABLE `structure`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD KEY `IDX_8D93D6492534008B` (`structure_id`),
  ADD KEY `IDX_8D93D649577906E4` (`sections_id`);

--
-- Index pour la table `user_dossier`
--
ALTER TABLE `user_dossier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6545FE3DA76ED395` (`user_id`),
  ADD KEY `IDX_6545FE3D611C0C56` (`dossier_id`);

--
-- Index pour la table `village`
--
ALTER TABLE `village`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4E6C7FAA407DBC11` (`arrondissement_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `arrondissement`
--
ALTER TABLE `arrondissement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=547;

--
-- AUTO_INCREMENT pour la table `commune`
--
ALTER TABLE `commune`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `modele_rapport`
--
ALTER TABLE `modele_rapport`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `paiement_consignation`
--
ALTER TABLE `paiement_consignation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pieces`
--
ALTER TABLE `pieces`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rapport`
--
ALTER TABLE `rapport`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `village`
--
ALTER TABLE `village`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5305;

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
  ADD CONSTRAINT `FK_3514FE262A10F76` FOREIGN KEY (`instruction_id`) REFERENCES `instructions` (`id`),
  ADD CONSTRAINT `FK_3514FE29D18E664` FOREIGN KEY (`conseiller_rapporteur_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `mouvement`
--
ALTER TABLE `mouvement`
  ADD CONSTRAINT `FK_5B51FC3E611C0C56` FOREIGN KEY (`dossier_id`) REFERENCES `dossier` (`id`),
  ADD CONSTRAINT `FK_5B51FC3EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_5B51FC3EF6203804` FOREIGN KEY (`statut_id`) REFERENCES `statut` (`id`);

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
