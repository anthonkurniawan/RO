-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2021 at 07:49 PM
-- Server version: 8.0.27-0ubuntu0.20.04.1
-- PHP Version: 5.6.40-55+ubuntu20.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ro_pfizer`
--
CREATE DATABASE IF NOT EXISTS `ro_pfizer` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ro_pfizer`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `copy_tag_area`$$
CREATE DEFINER=`test`@`localhost` PROCEDURE `copy_tag_area` ()  BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE CURSOR_TAG_ID INT;
  DECLARE CURSOR_TAGNUM, CURSOR_AREA VARCHAR(255);
  
  DECLARE CURSOR_TAG CURSOR FOR SELECT id, tagnum, area FROM ro_pfizer.tag;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  DROP TEMPORARY TABLE IF EXISTS TempTest;
  CREATE TEMPORARY TABLE TempTest(
    area_id INT,
    tagnum VARCHAR(150) NOT NULL,
    area VARCHAR(150)
  );
    
  OPEN CURSOR_TAG;
  read_loop: LOOP
    FETCH CURSOR_TAG INTO CURSOR_TAG_ID, CURSOR_TAGNUM, CURSOR_AREA;
    IF done THEN
      LEAVE read_loop;
    END IF;
    
    #INSERT INTO TempTest (area_id, tagnum, area) VALUES ( CURSOR_AREA_ID, CURSOR_TAGNUM, CURSOR_AREA);
    #SELECT CURSOR_AREA_ID, CURSOR_TAGNUM, CURSOR_AREA;
    IF NOT EXISTS(SELECT label FROM area where label = CURSOR_AREA) THEN
      SELECT CURSOR_TAG_ID, CURSOR_TAGNUM, CURSOR_AREA; 
      #INSERT INTO area(label) VALUES(CURSOR_AREA); /* copy data to table area if not exists */
    END IF;
    
    /* UPDATE TABLE TAG COLUMN "area_id" according from TABLE "area" */
    SET @id = (SELECT id FROM area WHERE label=CURSOR_AREA);
    #SELECT @id;
    IF (@id IS NOT NULL) THEN 
    	UPDATE tag set area_id = @id WHERE id = CURSOR_TAG_ID;
    END IF;
  END LOOP;
  CLOSE CURSOR_TAG;
  SELECT * FROM TempTest;
END$$

DROP PROCEDURE IF EXISTS `update_area_id`$$
CREATE DEFINER=`test`@`localhost` PROCEDURE `update_area_id` ()  BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE CURSOR_TAG_ID INT;
  DECLARE CURSOR_TAGNUM, CURSOR_AREA, CURSOR_AREA_ID VARCHAR(255);
  
  DECLARE CURSOR_TAG CURSOR FOR SELECT id, tagnum, area, area_id FROM ro_pfizer.tag;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  DROP TEMPORARY TABLE IF EXISTS TempTest;
  CREATE TEMPORARY TABLE TempTest(
    area_id INT,
    tagnum VARCHAR(150) NOT NULL,
    area VARCHAR(150)
  );
    
  OPEN CURSOR_TAG;
  read_loop: LOOP
    FETCH CURSOR_TAG INTO CURSOR_TAG_ID, CURSOR_TAGNUM, CURSOR_AREA, CURSOR_AREA_ID;
    IF done THEN
      LEAVE read_loop;
    END IF;
    
    #INSERT INTO TempTest (area_id, tagnum, area) VALUES ( CURSOR_AREA_ID, CURSOR_TAGNUM, CURSOR_AREA);
    #SELECT CURSOR_AREA_ID, CURSOR_TAGNUM, CURSOR_AREA;

    # FOR IMPORT "area.label"
    /*IF NOT EXISTS(SELECT label FROM area where label = CURSOR_AREA) THEN
      SELECT CURSOR_TAG_ID, CURSOR_TAGNUM, CURSOR_AREA; 
      #INSERT INTO area(label) VALUES(CURSOR_AREA); #copy data to table area if not exists 
    END IF;
    */

    # FOR IMPORT "tag.area_id" BASE ON table area
    #IF EXISTS(SELECT id  from ro_pfizer,area WHERE label_a=CURSOR_AREA) THEN
    #END IF;
    
    /* UPDATE TABLE TAG COLUMN "area_id" according from TABLE "area" */
    IF (CURSOR_AREA_ID='') THEN
        SET @id = (SELECT id FROM area WHERE label_a=CURSOR_AREA);
        #SELECT @id;
        IF (@id IS NOT NULL) THEN 
            UPDATE tag set area_id = @id WHERE id = CURSOR_TAG_ID;
        END IF;
    END IF;
  END LOOP;
  CLOSE CURSOR_TAG;
  SELECT * FROM TempTest;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` int NOT NULL,
  `label_a` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- RELATIONSHIPS FOR TABLE `area`:
--

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `label_a`) VALUES
(1, 'AHU 03'),
(2, 'AHU 09'),
(3, 'AHU 14'),
(4, 'AHU 14A'),
(5, 'AHU 14B'),
(6, 'AHU 15'),
(7, 'AHU 16'),
(8, 'AHU 17'),
(9, 'AHU 18'),
(10, 'AHU 20'),
(11, 'AHU 21'),
(12, 'AHU 24.1'),
(13, 'AHU 24.2'),
(14, 'AHU 25'),
(15, 'AHU 26'),
(16, 'AHU 27'),
(17, 'AHU 28'),
(18, 'AHU 304'),
(19, 'AHU 305'),
(20, 'AHU 9'),
(21, 'AHU 9.2'),
(22, 'AHU 9.3&9.4'),
(23, 'AHU 9.4'),
(24, 'Airlock'),
(25, 'Biologycal Safety Cabinet'),
(26, 'Cimanggis'),
(27, 'Coldbox GD05'),
(28, 'Combantrin Area'),
(29, 'Cooling Stg'),
(30, 'Corridor'),
(31, 'Female Access Area'),
(32, 'Filtration'),
(33, 'Generator'),
(34, 'Gowning'),
(35, 'Isolator'),
(36, 'Janitor Storage'),
(37, 'Kalibrasi'),
(38, 'Kontainer'),
(39, 'Lab. Kalibrasi'),
(40, 'LAF EQU 4'),
(41, 'Laundry'),
(42, 'Lytzen'),
(43, 'Male Access Area'),
(44, 'Mezanine'),
(45, 'Mezzanine'),
(46, 'Micro Lab.'),
(47, 'Mobile'),
(48, 'Ointment'),
(49, 'Other Coump'),
(50, 'Other Liq Fill'),
(51, 'Outside'),
(53, 'Packaging'),
(54, 'Process Oint'),
(55, 'Production'),
(56, 'R-102'),
(57, 'R-103'),
(58, 'R-108'),
(59, 'R-109'),
(60, 'R-110'),
(61, 'R-1100'),
(62, 'R-112'),
(63, 'R-114'),
(64, 'R-1200'),
(65, 'R-123'),
(66, 'R-1300'),
(67, 'R-133'),
(68, 'R-134'),
(69, 'R-135'),
(70, 'R-135 A'),
(71, 'R-135A'),
(72, 'R-136'),
(73, 'R-137'),
(74, 'R-139'),
(75, 'R-140'),
(76, 'R-1400'),
(77, 'R-141'),
(78, 'R-142'),
(79, 'R-143'),
(80, 'R-144A'),
(81, 'R-144B'),
(82, 'R-145'),
(83, 'R-1500'),
(84, 'R-151'),
(85, 'R-152'),
(86, 'R-153'),
(87, 'R-154'),
(88, 'R-155'),
(89, 'R-156'),
(90, 'R-157'),
(91, 'R-158'),
(92, 'R-160'),
(93, 'R-1600'),
(94, 'R-162'),
(95, 'R-163'),
(96, 'R-164'),
(97, 'R-165'),
(98, 'R-166'),
(99, 'R-167'),
(100, 'R-168'),
(101, 'R-1700'),
(102, 'R-182'),
(103, 'R-183'),
(104, 'R-185'),
(105, 'R-190'),
(106, 'R-191'),
(107, 'R-192'),
(108, 'R-193'),
(109, 'R-203'),
(110, 'R-204'),
(111, 'R-209'),
(112, 'R-210'),
(113, 'R-212'),
(114, 'R-213'),
(115, 'R-217'),
(116, 'R-251'),
(117, 'R-253'),
(118, 'R-256'),
(119, 'R-257'),
(120, 'R-258'),
(121, 'R-259'),
(122, 'R-301'),
(123, 'R-302'),
(124, 'R-304'),
(125, 'R-305'),
(126, 'R-306'),
(127, 'R-307'),
(128, 'R-308'),
(129, 'R-309'),
(130, 'R-310'),
(131, 'R-311'),
(132, 'R-312'),
(133, 'R-313'),
(134, 'R-314 '),
(135, 'R-316'),
(136, 'R-317'),
(137, 'R-318'),
(138, 'R-319'),
(139, 'R-321'),
(140, 'R-323'),
(141, 'R-324'),
(142, 'R-328'),
(143, 'R-332'),
(144, 'R-334'),
(145, 'R-5100'),
(146, 'R-5200'),
(147, 'R-5300'),
(148, 'R-5400'),
(149, 'R-5Q001'),
(150, 'R-5Q002'),
(151, 'R-Genset'),
(152, 'R-Stability'),
(153, 'Raw Goods Warehouse'),
(154, 'Sampling booth'),
(155, 'Storage Cold Box'),
(156, 'Storage Coldbox'),
(157, 'Truck Box'),
(158, 'Uniform'),
(159, 'Utilities Area'),
(160, 'Utility'),
(161, 'Utility Area'),
(162, 'Utility Control Room'),
(163, 'UV'),
(164, 'Visine Coump'),
(165, 'Visine Liq'),
(166, 'Ware house'),
(167, 'Warehouse'),
(168, 'Washing Str'),
(234, 'q'),
(235, 'w'),
(236, '4'),
(237, '1'),
(238, 'a'),
(239, 'z'),
(240, 'z1'),
(242, 'x'),
(243, 'x1'),
(244, 's1'),
(245, 'x2'),
(247, 'x211'),
(248, 'x2111'),
(249, 'x211111'),
(250, '11'),
(251, 'w1'),
(252, 'w11'),
(253, 'w111'),
(254, 'w1111'),
(255, 'w111111'),
(256, '3'),
(257, '31'),
(258, '311'),
(260, '411'),
(261, '5'),
(262, '51'),
(263, 'b'),
(264, 'c'),
(265, 'az'),
(266, 'aza'),
(267, 'azaw'),
(268, 'azawa'),
(269, 'azawaa'),
(270, 'azawaaak'),
(271, 'azawaaak1'),
(272, 'azawaaak133'),
(274, 'cc'),
(275, 'ccc'),
(276, 'cccc'),
(277, 'vv'),
(278, 'vv1'),
(279, 'vv11'),
(280, 'vv111'),
(281, 'vv1111'),
(282, 'vv11111'),
(283, 'vv111111'),
(284, '1vv111111'),
(333, 'e'),
(334, 'ew'),
(335, 'ss'),
(336, 'aa'),
(337, 'ww'),
(338, 'qq'),
(339, 'qqq'),
(340, 'ww3'),
(341, 'aasa');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_id` varchar(12) NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- RELATIONSHIPS FOR TABLE `comment`:
--   `user_id`
--       `user` -> `id`
--

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `order_id`, `comment`, `time`) VALUES
(2, 4, '1112021001', 'test comment ahhh.. AJSLAJSLAJSLA aska;ks; skdksdjskjdksjd skdksjdksjdkskdjkskdjskd skdjskdjksjdksdjksjdksjd skdjksdjsj;dsjd;sj; sljnvnldldjfljdf sljsjdljskdjlajdlajd saljdlajdlkjladjlajaks;a askask;aks;aks asla;ls;adfd mmmmmmmmmmmmmmmmm asasjkajsaksjskas askasjakjskajs ashakskajskjas asjasjdjsldjsljdlsjd sdsssssssss sdsldksldklskd sdksldklskdlskds sdsjdksjdksjkdjskdd;sd;skd;skd ksdkshdkhskdhkshdhskd sdjlsjdlsjdsjd sldlskdlskdlskd sdksldklskdlskld sldklskdlskldklskd sldkslkdlskdlsdk sldklskdlskdlskdlskd sldklskdlskdsdjshdjhsjdhjshdjshd skdjksdjksjdkjskd skdjksjdksjdksjdksjkjd', 1626206694),
(7, 2, '1112021001', 'jlajjalkjaja', 1212121);

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `id` int NOT NULL,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- RELATIONSHIPS FOR TABLE `dept`:
--

--
-- Dumping data for table `dept`
--

INSERT INTO `dept` (`id`, `code`, `label`) VALUES
(1, 'eng', 'Engineering'),
(2, 'prod', 'Production'),
(3, 'wh', 'Warehouse'),
(4, 'qo', 'Quality Operation'),
(5, 'qa', 'Quality Assurance');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int NOT NULL,
  `date` datetime NOT NULL,
  `userid` int DEFAULT NULL,
  `event` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `assign_to` int NOT NULL,
  `region_id` int NOT NULL,
  `initiator_id` int NOT NULL,
  `dept_id` int NOT NULL,
  `tag_num` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N/A',
  `item_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `area_id` int NOT NULL,
  `priority` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `detail_desc` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `ehs_assest` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N/A',
  `ehs_hazard` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N/A',
  `ehs_hazard_risk` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `replacement` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `create_at` datetime NOT NULL,
  `update_at` int NOT NULL,
  `complete_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- RELATIONSHIPS FOR TABLE `orders`:
--   `dept_id`
--       `dept` -> `id`
--

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `assign_to`, `region_id`, `initiator_id`, `dept_id`, `tag_num`, `item_desc`, `area_id`, `priority`, `status`, `title`, `detail_desc`, `ehs_assest`, `ehs_hazard`, `ehs_hazard_risk`, `replacement`, `create_at`, `update_at`, `complete_at`) VALUES
('1112021001', 4, 1, 1, 1, 'AC-001', 'Dehumidifier 14-2', 11, 2, 2, 'TEST akhskahsakhskaksha ashakshkahs aksjkasjkajskajs aksjaksjkajskajsak asjasjkajsakjsksjakjs jshjdhsjhdjshd ksdjksjdksdkjskdjs sdjskdjksjdksjkdj sdjskjdksjdksjd skjdksjdksjkdskjd sdjsljdlsdjsl sdlsdlsjdlj alsjlaslajslajs lajlsjalsjlajs <br> alsjlaslajs a', 'test zzzzzzzzzzz asasa ask;as;aks asalsalsjal askask;aks aska;sk;aska aska;sk;aks aska;ska;asas assas;aks;ka;sk ask;as;ask;a asa;sk;aks;ak laslaslakslaks aska;ks;aks;aks a;sa;ks;aks;aks;ka;ksjjasalslajs asklasklakslaks aslkalslakslask askalsklakslkalsklaks askalsklakslaklsk asaaaaaaaaa', 'N/A', 'N/A', 'N/A', NULL, '2021-11-01 03:04:54', 1637256470, '2021-11-02 10:58:07'),
('1112021002', 1, 1, 4, 3, 'WS-33-13310', 'Weight', 66, 2, 1, 'asasasasas', 'asasasdfdf', 'N/A', 'N/A', NULL, NULL, '2021-11-10 23:16:35', 1636622276, NULL),
('1112021003', 2, 1, 1, 1, 'AC-016', 'AHU System 3', 45, 2, 1, 'axxxx', 'a', 'N/A', 'N/A', NULL, NULL, '2021-11-12 14:42:17', 1636703001, NULL),
('2112021001', 40, 2, 1, 1, 'ENG-INS-ATM302', 'Anak Timbang', 39, 1, 1, 'asasa', 'asas', 'N/A', 'N/A', NULL, NULL, '2021-11-15 23:05:18', 1637258959, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
  `id` int NOT NULL,
  `dept_id` int NOT NULL DEFAULT '1',
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- RELATIONSHIPS FOR TABLE `region`:
--   `dept_id`
--       `dept` -> `id`
--

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`id`, `dept_id`, `nama`) VALUES
(1, 1, 'Maintenace'),
(2, 1, 'Utility'),
(3, 1, 'Calibration'),
(4, 1, 'Automation'),
(5, 1, 'Facility'),
(6, 1, 'EHS'),
(7, 1, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int NOT NULL,
  `area_id` int DEFAULT NULL,
  `tagnum` varchar(150) NOT NULL,
  `desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- RELATIONSHIPS FOR TABLE `tag`:
--   `area_id`
--       `area` -> `id`
--

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `area_id`, `tagnum`, `desc`) VALUES
(1, 84, 'BR-21-15101', 'Balance Indicator'),
(2, 84, 'BR-21-15102', 'Balance Indicator'),
(3, 87, 'BR-21-15401', 'Balance Indicator'),
(4, 137, 'BR-21-15501', 'Balance Indicator'),
(5, 97, 'BR-21-15502', 'Balance Indicator'),
(6, 140, 'BR-21-15503', 'Balance Indicator'),
(7, 86, 'BR-21-16501', 'Balance Indicator'),
(8, 88, 'BR-21-16502', 'Balance Indicator'),
(9, 86, 'BR-21-31601', 'Balance Indicator'),
(10, 60, 'BR-22-11001', 'Balance Indicator'),
(11, 60, 'BR-22-11002', 'Balance Indicator'),
(12, 60, 'BR-22-11005', 'Balance Indicator'),
(13, 60, 'BR-22-11006', 'Check Weigher'),
(14, 60, 'BR-22-11008', 'Balance Indicator'),
(15, 60, 'BR-22-11010', 'Balance Indicator'),
(16, 60, 'BR-22-11011', 'Balance Readout'),
(17, 60, 'BR-22-11012', 'Balance Indicator'),
(18, 60, 'BR-22-11013', 'Balance Indicator'),
(19, 60, 'BR-22-11014', 'Balance Indicator'),
(20, 60, 'BR-22-11015', 'Check Weigher'),
(21, 60, 'BR-22-11016', 'Balance'),
(22, 79, 'BR-25-14302', 'Balance Indicator'),
(23, 66, 'BR-32-11201', 'Balance Indicator'),
(24, 60, 'BR-33-10302', 'Balance Indicator'),
(25, 57, 'BR-33-10306', 'Balance Indicator'),
(26, 139, 'BR-33-10307', 'Balance Indicator'),
(27, 67, 'BR-33-10308', 'Balance Indicator'),
(28, 67, 'BR-33-32802', 'Balance Readout'),
(29, 142, 'BR-33-32803', 'Balance Readout'),
(30, 135, 'BR-33-32804', 'Balance Readout'),
(31, 142, 'BR-33-32805', 'Balance Indicator'),
(32, 67, 'BR-93-00101-A', 'Balance Indicator'),
(33, 67, 'BR-93-00101-B', 'Balance Indicator'),
(34, 60, 'BR-93-00101-C', 'Balance Indicator'),
(35, 99, 'BR-93-02101', 'Balance Indicator'),
(36, 92, 'BR-93-02102', 'Balance Indicator'),
(37, 69, 'CIT-11-13503-CB', 'Conductivity Transmitter'),
(38, 69, 'CIT-11-13506-CB', 'Conductivity Transmitter'),
(39, 69, 'CIT-11-13507-CB', 'Conductivity Meter'),
(40, 69, 'CIT-11-13508-CB', 'Conductivity Meter'),
(41, 69, 'CIT-11-13509-CB', 'Conductivity Meter'),
(42, 72, 'CIT-11-13605-CB', 'Conductivity Meter'),
(43, 72, 'CIT-11-13606-CB', 'Conductivity Meter'),
(44, 72, 'CIT-11-13607-CB', 'Conductivity Meter'),
(45, 72, 'CIT-11-13608-CB', 'Conductivity Meter'),
(46, 126, 'CIT-11-30602', 'Conductivity Meter'),
(47, 126, 'CIT-19-30601', 'Conductivity Transmitter'),
(48, 44, 'DPI-19-33201', 'Differential Pressure'),
(49, 84, 'DPI-21-15101', 'Differential Pressure Digital'),
(50, 85, 'DPI-21-15203', 'Differential Pressure Digital'),
(51, 87, 'DPI-21-15403', 'Differential Pressure Digital'),
(52, 88, 'DPI-21-15501', 'Differential Pressure Digital'),
(53, 89, 'DPI-21-15603', 'Differential Pressure Digital'),
(54, 90, 'DPI-21-15703', 'Differential Pressure Digital'),
(55, 91, 'DPI-21-15803', 'Differential Pressure Digital'),
(56, 92, 'DPI-21-16001', 'Differential Pressure'),
(57, 92, 'DPI-21-16002', 'Differential Pressure Digital'),
(58, 94, 'DPI-21-16204', 'Differential Pressure Digital'),
(59, 95, 'DPI-21-16303', 'Differential Pressure Digital'),
(60, 96, 'DPI-21-16403', 'Differential Pressure Digital'),
(61, 97, 'DPI-21-16501', 'Differential Pressure Digital'),
(62, 98, 'DPI-21-16603', 'Differential Pressure Digital'),
(63, 99, 'DPI-21-16703', 'Differential Pressure Digital'),
(64, 100, 'DPI-21-16803', 'Differential Pressure Digital'),
(65, 122, 'DPI-21-30104', 'Differential Pressure Digital'),
(66, 122, 'DPI-21-30105', 'Differential Pressure Indicator'),
(67, 122, 'DPI-21-30106', 'Differential Pressure Indicator'),
(68, 122, 'DPI-21-30107', 'Differential Pressure Indicator'),
(69, 123, 'DPI-21-30203', 'Differential Pressure Digital'),
(70, 130, 'DPI-21-31001', 'Differential Pressure Digital'),
(71, 131, 'DPI-21-31101', 'Differential Pressure Digital'),
(72, 132, 'DPI-21-31201', 'Differential Pressure Digital'),
(73, 133, 'DPI-21-31301', 'Differential Pressure Digital'),
(74, 104, 'DPI-26-18501-COM', 'Differential Pressure'),
(75, 104, 'DPI-26-18502-COM', 'Differential Pressure'),
(76, 104, 'DPI-26-18504-COM', 'Differential Pressure'),
(77, 104, 'DPI-26-18505-COM', 'Differential Pressure'),
(78, 104, 'DPI-26-18506-COM', 'Differential Pressure'),
(79, 104, 'DPI-26-18507-COM', 'Differential Pressure'),
(80, 116, 'DPI-26-25101', 'Differential Pressure'),
(81, 116, 'DPI-26-25102', 'Differential Pressure'),
(82, 116, 'DPI-26-25103', 'Differential Pressure'),
(83, 116, 'DPI-26-25104', 'Differential Pressure'),
(84, 116, 'DPI-26-25105', 'Differential Pressure'),
(85, 116, 'DPI-26-25106', 'Differential Pressure'),
(86, 116, 'DPI-26-25107', 'Differential Pressure'),
(87, 116, 'DPI-26-25108', 'Differential Pressure'),
(88, 119, 'DPI-26-25701', 'Differential Pressure'),
(89, 63, 'DPI-31-11401', 'Differential Pressure'),
(90, 63, 'DPI-31-11402', 'Differential Pressure'),
(91, 63, 'DPI-31-11403', 'Differential Pressure'),
(92, 63, 'DPI-31-11404', 'Differential Pressure'),
(93, 67, 'DPI-33-13302', 'Differential Pressure'),
(94, 67, 'DPI-33-13303', 'Differential Pressure'),
(95, 67, 'DPI-33-13304-MOV', 'Differential Pressure Gauge'),
(96, 67, 'DPI-33-13305', 'Differential Pressure'),
(97, 142, 'DPI-33-32801', 'Differential Pressure Gauge'),
(98, 142, 'DPI-33-32802', 'Differential Pressure Gauge'),
(99, 142, 'DPI-33-32803', 'Differential Pressure Gauge'),
(100, 63, 'DPI-41-11405', 'Differential Pressure Gauge'),
(101, 63, 'DPI-41-11406', 'Differential Pressure Gauge'),
(102, 118, 'DPI-42-25601-BSC', 'Differential Pressure Gauge'),
(103, 75, 'DPS-24-14001', 'Differential Pressure Switch'),
(104, 75, 'DPS-24-14002', 'Differential Pressure Switch'),
(105, 75, 'DPS-24-14003', 'Differential Pressure Switch'),
(106, 75, 'DPS-24-14004', 'Differential Pressure Switch'),
(107, 8, 'DPT-13-33305', 'Differential Pressure Transmitter'),
(108, 11, 'DPT-13-33308', 'Differential Pressure Transmitter'),
(109, 5, 'DPT-13-33314', 'Differential Pressure Transmitter'),
(110, 13, 'DPT-13-33320', 'Differential Pressure Transmitter'),
(111, 14, 'DPT-13-33323', 'Differential Pressure Transmitter'),
(112, 17, 'DPT-13-33326', 'Differential Pressure Transmitter'),
(113, 23, 'DPT-13-33328', 'Differential Pressure Transmitter'),
(114, 136, 'DPT-21-31701', 'Differential Pressure Transmitter'),
(115, 137, 'DPT-21-31801', 'Differential Pressure Transmitter'),
(116, 138, 'DPT-21-31901', 'Differential Pressure Transmitter'),
(117, 139, 'DPT-21-32101', 'Differential Pressure Transmitter'),
(118, 140, 'DPT-21-32301', 'Differential Pressure Transmitter'),
(119, 141, 'DPT-21-32401', 'Differential Pressure Transmitter'),
(120, 60, 'DPT-22-11001', 'Differential Pressure Transmitter'),
(121, 60, 'DPT-22-11002', 'Differential Pressure Transmitter'),
(122, 60, 'DPT-22-11003', 'Differential Pressure Transmitter'),
(123, 60, 'DPT-22-11004', 'Differential Pressure Transmitter'),
(124, 60, 'DPT-22-11005', 'Differential Pressure Transmitter'),
(125, 60, 'DPT-22-11006', 'Differential Pressure Transmitter'),
(126, 60, 'DPT-22-11007', 'Differential Pressure Transmitter'),
(127, 60, 'DPT-22-11008', 'Differential Pressure Transmitter'),
(128, 63, 'DPT-31-11401', 'Differential Pressure Transmitter'),
(129, 63, 'DPT-31-11402', 'Differential Pressure Transmitter'),
(130, 63, 'DPT-31-11403', 'Differential Pressure Transmitter'),
(131, 117, 'DPT-42-25301', 'Differential Pressure Transmitter'),
(132, 117, 'DPT-42-25302', 'Differential Pressure Transmitter'),
(133, 39, 'ENG-INS-16010001', 'Thermometer Calibration KIT'),
(134, 37, 'ENG-INS-25DT0047', 'Digital Manometer'),
(135, 39, 'ENG-INS-58506H', 'Temperature Calibration Block HTR'),
(136, 39, 'ENG-INS-58506L', 'Temperature Calibration Block LTR'),
(137, 39, 'ENG-INS-ATM301', 'Anak Timbang'),
(138, 39, 'ENG-INS-ATM302', 'Anak Timbang'),
(139, 39, 'ENG-INS-ATM303', 'Anak Timbang'),
(140, 39, 'ENG-INS-ATM304', 'Anak Timbang'),
(141, 39, 'ENG-INS-ATM305', 'Anak Timbang'),
(142, 92, 'FM-21-16001', 'Flow Meter'),
(143, 139, 'FM-21-32101', 'Flow Meter'),
(144, 15, 'FT-13-33301', 'Air Flow Tranmitter'),
(145, 16, 'FT-13-33302', 'Air Flow Tranmitter'),
(146, 140, 'FT-21-32301', 'Air Flow Sensor'),
(147, 69, 'I/P-11-13516.1-JB', 'I/P Converter'),
(148, 69, 'I/P-11-1353.1-JB', 'I/P Converter'),
(149, 72, 'I/P-11-13610.10-CB', 'I/P Converter'),
(150, 72, 'I/P-11-13610.5-CB', 'I/P Converter'),
(151, 72, 'I/P-11-13615.15-CB', 'I/P Converter'),
(152, 72, 'I/P-11-13615.1-CB', 'I/P Converter'),
(153, 72, 'I/P-11-13620-CB', 'I/P Converter'),
(154, 144, 'PI-11-33402-BMI', 'Pressure Gauge'),
(155, 60, 'PI-21-11011', 'Vacuum  Gauge'),
(156, 60, 'PI-21-11012', 'Pressure  Gauge'),
(157, 92, 'PI-21-16002', 'Pressure Gauge'),
(158, 92, 'PI-21-16003', 'Pressure Gauge'),
(159, 130, 'PI-21-31001', 'Pressure Gauge'),
(160, 130, 'PI-21-31002', 'Pressure Gauge'),
(161, 136, 'PI-21-31702', 'Pressure Indicator'),
(162, 139, 'PI-21-32101', 'Pressure Gauge'),
(163, 139, 'PI-21-32102', 'Pressure Gauge'),
(164, 139, 'PI-21-32103', 'Pressure Gauge'),
(165, 139, 'PI-21-32104', 'Pressure Gauge'),
(166, 140, 'PI-21-32301', 'Pressure Gauge'),
(167, 140, 'PI-21-32302', 'Pressure Gauge'),
(168, 60, 'PI-22-11003', 'Pressure Indicator'),
(169, 75, 'PI-24-14005', 'Pressure Gauge'),
(170, 82, 'PI-24-14503', 'Pressure Gauge'),
(171, 82, 'PI-24-14511', 'Pressure Gauge'),
(172, 81, 'PI-25-14401-B', 'Pressure Gauge'),
(173, 81, 'PI-25-14402-B', 'Pressure Gauge'),
(174, 81, 'PI-25-14404-B', 'Pressure Gauge'),
(175, 69, 'PSL-11-1351.1-PT', 'Pressure Switch Low'),
(176, 69, 'PSL-11-13530-DMP', 'Pressure Switch Low'),
(177, 72, 'PSL-11-13609-PMS', 'Pressure Switch Low'),
(178, 72, 'PSL-11-13610-PMS', 'Pressure Switch Low'),
(179, 72, 'PSL-11-13611-PMS', 'Pressure Switch Low'),
(180, 144, 'PSL-11-33401-BMI', 'Pressure Switch Low'),
(181, 144, 'PSL-11-33402-BMI', 'Pressure Switch Low'),
(182, 65, 'PSL-23-12373-GET', 'Pressure Switch'),
(183, 65, 'PSL-23-12374-GET', 'Pressure Switch'),
(184, 119, 'PSL-26-25701-GET', 'Pressure Switch Low'),
(185, 119, 'PSL-42-25701', 'Pressure Switch Low'),
(186, 119, 'PSL-42-25702', 'Pressure Switch Low'),
(187, 72, 'PT-11-13610.1-WPU', 'Pressure Transmitter'),
(188, 72, 'PT-11-13615.1-PMS', 'Pressure Transmitter'),
(189, 72, 'PT-11-13620-PSG', 'Pressure Transmitter'),
(190, 122, 'PT-21-30101', 'Pressure For Convert to Flow Indicator'),
(191, 140, 'PT-21-32301', 'Pressure Transmitter'),
(192, 65, 'PT-23-12303-GET', 'Pressure Transmitter'),
(193, 65, 'PT-23-12304-GET', 'Pressure Transmitter'),
(194, 78, 'PT-25-14201-KRG', 'Pressure Transmitter'),
(195, 63, 'PT-31-11401', 'Pressure Transmitter'),
(196, 119, 'PT-42-25701-GET', 'Pressure Transmitter'),
(197, 72, 'R-11-13602-PMS', 'Temperature Recorder'),
(198, 78, 'R-25-14202-KRG-CH1', 'Recorder'),
(199, 78, 'R-25-14202-KRG-CH2', 'Recorder'),
(200, 78, 'R-25-14202-KRG-CH3', 'Recorder'),
(201, 91, 'RH-21-15802', 'Temperature & RH Indicator'),
(202, 56, 'RH-41-10201', 'RH Recorder'),
(203, 152, 'RH-41-21010', 'RH Recorder'),
(204, 152, 'RH-41-21011', 'RH Recorder'),
(205, 152, 'RH-41-21012', 'RH Recorder'),
(206, 152, 'RH-41-21013', 'RH Recorder'),
(207, 152, 'RH-41-21014', 'RH Recorder'),
(208, 152, 'RH-41-21015', 'RH Recorder'),
(209, 152, 'RH-41-21016', 'RH Recorder'),
(210, 152, 'RH-41-21018', 'RH Recorder'),
(211, 152, 'RH-41-21019', 'Chamber'),
(212, 117, 'RH-42-25301', 'Hygrometer'),
(213, 147, 'RH-99-5300-001', 'RH Indicator (Hygrometer)'),
(214, 147, 'RH-99-5300-002', 'RH Indicator (Hygrometer)'),
(215, 124, 'TC-11-30401', 'Temperature Controller'),
(216, 124, 'TC-11-30402', 'Temperature Controller'),
(217, 125, 'TC-11-30501-CT', 'Temperature Transmitter'),
(218, 144, 'TC-11-33401-HW', 'Temperature Controller'),
(219, 151, 'TC-19-33201', 'Temperature Control'),
(220, 140, 'TC-21-15503', 'Temperature Controller'),
(221, 90, 'TC-21-15701-DK', 'Temperature Controller'),
(222, 90, 'TC-21-15702-DK', 'Temperature Controller'),
(223, 90, 'TC-21-15703-DK', 'Temperature Controller'),
(224, 90, 'TC-21-15704-DK', 'Temperature Controller'),
(225, 92, 'TC-21-16004', 'Temperature Controller'),
(226, 98, 'TC-21-16602', 'Temperature Controller'),
(227, 100, 'TC-21-16801', 'Temperature Controller'),
(228, 131, 'TC-21-31101-UHL', 'Temperature Controller'),
(229, 131, 'TC-21-31102-UHL', 'Temperature Controller'),
(230, 131, 'TC-21-31103-UHL', 'Temperature Controller'),
(231, 60, 'TC-22-11001', 'Temperature Controller'),
(232, 60, 'TC-22-11002', 'Temperature Controller'),
(233, 60, 'TC-22-11004', 'Temperature Controller'),
(234, 106, 'TC-27-19102', 'Temperature Controller'),
(235, 112, 'TC-41-21001-INC', 'Temperature Controller'),
(236, 114, 'TC-41-21001-OVN', 'Temperature Controller'),
(237, 112, 'TC-41-21003', 'Temperature Controller'),
(238, 112, 'TC-41-21004', 'Temperature Controller'),
(239, 112, 'TC-41-21005', 'Oil Bath'),
(240, 152, 'TC-41-21010', 'Temperature Controller'),
(241, 152, 'TC-41-21011', 'Temperature Transmitter'),
(242, 152, 'TC-41-21012', 'Temperature Transmitter'),
(243, 152, 'TC-41-21013', 'Temperature Transmitter'),
(244, 152, 'TC-41-21014', 'Temperature Transmitter'),
(245, 152, 'TC-41-21015', 'Temperature Transmitter'),
(246, 152, 'TC-41-21016', 'Temperature Transmitter'),
(247, 112, 'TC-41-21017', 'Temperature Controller'),
(248, 152, 'TC-41-21018', 'Temperature Transmitter'),
(249, 152, 'TC-41-21019', 'Chamber'),
(250, 112, 'TC-41-21019-FRN', 'Temperature Controller'),
(251, 120, 'TC-41-21201-WTB', 'Temperature Controller'),
(252, 119, 'TC-41-21202-HTP', 'Temperature Controller'),
(253, 121, 'TC-42-25901-INC', 'Temperature Controller'),
(254, 121, 'TC-42-25901-OVN', 'Temperature Controller'),
(255, 121, 'TC-42-25902', 'Temperature Controller'),
(256, 121, 'TC-42-25903-FRI', 'Temperature Controller'),
(257, 66, 'TC-99-1300-001', 'Temperature Control'),
(258, 66, 'TC-99-1300-002', 'Temperature Control'),
(259, 66, 'TC-99-1300-003', 'Temperature Control'),
(260, 66, 'TC-99-1300-004', 'Temperature Control'),
(261, 92, 'THT-21-16001', 'Temperatur Humidity trasmitter'),
(262, 92, 'THT-21-16001.', 'Temperature Humidity Transmitter'),
(263, 99, 'THT-21-16701', 'Temperatur Humidity trasmitter'),
(264, 99, 'THT-21-16701.', 'Temperature Humidity Transmitter'),
(265, 67, 'THT-33-13301', 'Temperatur Humidity trasmitter'),
(266, 67, 'THT-33-13301.', 'Temperature Humidity Transmitter'),
(267, 100, 'TI/RH-21-16801', 'Temperature/Humidity Indicator'),
(268, 100, 'TI/RH-21-16801.', 'Temperature/Humidity Indicator'),
(269, 100, 'TI/RH-21-16802', 'Thermohygrometer Indicator'),
(270, 100, 'TI/RH-21-16802.', 'Thermohygrometer Indicator'),
(271, 123, 'TI/RH-21-30202', 'Temperature & RH Indicator'),
(272, 123, 'TI/RH-21-30202.', 'Temperature & RH Indicator'),
(273, 132, 'TI/RH-21-31201', 'Temperature/Humidity Indicator'),
(274, 132, 'TI/RH-21-31201.', 'Temperature/Humidity Indicator'),
(275, 75, 'TI/RH-24-14001', 'Temperature/Humidity Indicator'),
(276, 75, 'TI/RH-24-14001.', 'Temperature/Humidity Indicator'),
(277, 67, 'TI/RH-33-13302', 'Thermohygrometer Indicator'),
(278, 67, 'TI/RH-33-13302.', 'Thermohygrometer Indicator'),
(279, 142, 'TI/RH-33-32801', 'Temperature/Humidity Indicator'),
(280, 142, 'TI/RH-33-32801.', 'Temperature/Humidity Indicator'),
(281, 111, 'TI/RH-41-20901', 'Temperature Room Indicator'),
(282, 111, 'TI/RH-41-20901.', 'Humidity Room Indicator'),
(283, 113, 'TI/RH-41-21201', 'Temperature Room Indicator'),
(284, 113, 'TI/RH-41-21201.', 'Humidity Room Indicator'),
(285, 114, 'TI/RH-41-21301', 'Temperature Room Indicator'),
(286, 114, 'TI/RH-41-21301.', 'Humidity Room Indicator'),
(287, 121, 'TI/RH-42-25910', 'Temperature Room Indicator'),
(288, 121, 'TI/RH-42-25910.', 'Humidity Room Indicator'),
(289, 147, 'TI/RH-99-5300-002', 'Thermohygrometer Indicator'),
(290, 147, 'TI/RH-99-5300-002.', 'Thermohygrometer Indicator'),
(291, 72, 'TI-12-13601', 'Temperature Indicator'),
(292, 72, 'TI-12-13602', 'Temperature Indicator'),
(293, 72, 'TI-12-13603', 'Temperature Indicator'),
(294, 72, 'TI-12-13604', 'Temperature Indicator'),
(295, 72, 'TI-12-13605', 'Temperature Indicator'),
(296, 72, 'TI-12-13606', 'Temperature Indicator'),
(297, 72, 'TI-12-13607', 'Temperature Indicator'),
(298, 86, 'TI-21-15302', 'Valprobe II Logger Kaye'),
(299, 91, 'TI-21-15802', 'Temperature & RH Indicator'),
(300, 92, 'TI-21-16603', 'Temperature Indicator'),
(301, 98, 'TI-21-16604', 'Temperature Indicator'),
(302, 122, 'TI-21-30101', 'Temperature Indicator'),
(303, 122, 'TI-21-30102', 'Temperature Indicator'),
(304, 122, 'TI-21-30103', 'Temperature Indicator'),
(305, 122, 'TI-21-30104', 'Sensor Bypass Temperature Indicator'),
(306, 134, 'TI-21-31401', 'Temperature Indicator'),
(307, 139, 'TI-21-32101', 'Temperature Indicator'),
(308, 139, 'TI-21-32102', 'Temperature Indicator'),
(309, 139, 'TI-21-32103', 'Temperature Indicator'),
(310, 60, 'TI-22-11001', 'Temperature Indicator'),
(311, 60, 'TI-22-11007', 'Temperature Indicator'),
(312, 65, 'TI-23-12307-GET', 'Temperature Indicator'),
(313, 65, 'TI-23-12307-SPV-GET', 'Temperature Indicator'),
(314, 65, 'TI-23-12312-GET', 'Temperature Indicator'),
(315, 65, 'TI-23-12312-SPV-GET', 'Temperature Indicator'),
(316, 77, 'TI-24-14101', 'Temperature Indicator'),
(317, 78, 'TI-25-14201', 'Temperature Indicator'),
(318, 80, 'TI-25-14401-A', 'Temperature Indicator'),
(319, 80, 'TI-25-14402-A', 'Temperature Indicator'),
(320, 81, 'TI-25-14403-B', 'Temperature Indicator'),
(321, 81, 'TI-25-14404-B', 'Temperature Indicator'),
(322, 106, 'TI-25-19101', 'Temperature Mixing Tank 1000L'),
(323, 121, 'TI-26-25901-PRC', 'Temperature Indicator'),
(324, 121, 'TI-26-25902-PRC', 'Temperature Indicator'),
(325, 106, 'TI-27-19101', 'Temperature Indicator'),
(326, 108, 'TI-27-19302', 'Temperature Indicator'),
(327, 156, 'TI-31-10201-WH', 'Temperature Gauge'),
(328, 155, 'TI-31-18101', 'Temperature Indicator'),
(329, 27, 'TI-31-18102', 'Temperature Indicator'),
(330, 62, 'TI-32-11201', 'Temperature Indicator'),
(331, 62, 'TI-32-11202', 'Temperature Indicator'),
(332, 62, 'TI-32-11203', 'Temperature Indicator'),
(333, 62, 'TI-32-11204', 'Temperature Indicator'),
(334, 62, 'TI-32-11205', 'Temperature Indicator'),
(335, 62, 'TI-32-11206', 'Temperature Indicator'),
(336, 62, 'TI-32-11207', 'Temperature Indicator'),
(337, 62, 'TI-32-11208', 'Temperature Indicator'),
(338, 93, 'TI-39-18102-CMGS', 'Temperature Indicator'),
(339, 56, 'TI-41-10201', 'Temperature Indicator'),
(340, 102, 'TI-41-18202', 'Temperature Indicator'),
(341, 103, 'TI-41-18305', 'Temperature Indicator'),
(342, 103, 'TI-41-18306', 'Temperature Indicator'),
(343, 112, 'TI-41-21001', 'Temperature Room Indicator'),
(344, 112, 'TI-41-21011', 'Thermometer of Pycnometer'),
(345, 112, 'TI-41-21012', 'Thermometer of Pycnometer'),
(346, 112, 'TI-41-21013', 'Thermometer of Pycnometer'),
(347, 112, 'TI-41-21014', 'Thermometer of Pycnometer'),
(348, 112, 'TI-41-21401', 'Temperature Indicator'),
(349, 119, 'TI-42-21002', 'Temperature Indicator'),
(350, 115, 'TI-42-21702', 'Temperature Indicator'),
(351, 117, 'TI-42-25302', 'Temperature Transmitter'),
(352, 117, 'TI-42-25303', 'Temperature Indicator'),
(353, 118, 'TI-42-25602', 'Temperature Indicator'),
(354, 119, 'TI-42-25701-GET', 'Temperature Indicator'),
(355, 119, 'TI-42-25703', 'Temperature Indicator'),
(356, 119, 'TI-42-25705', 'Temperature Indicator'),
(357, 121, 'TI-42-25707', 'BOD Inkubator'),
(358, 119, 'TI-42-25708-WTB', 'Water Bath'),
(359, 121, 'TI-42-25903', 'Temperature Indicator'),
(360, 113, 'TI-42-25907', 'Temperature Indicator'),
(361, 112, 'TI-42-25908', 'Temperature Indicator'),
(362, 121, 'TI-42-25911', 'Temperature Indicator'),
(363, 121, 'TI-42-25912', 'Temperature Indicator'),
(364, 121, 'TI-42-25914', 'Temperature sensor'),
(365, 61, 'TI-91-018', 'Temperature Indicator'),
(366, 64, 'TI-91-019', 'Temperature Indicator'),
(367, 61, 'TI-99-1100-003', 'Temperature Indicator'),
(368, 61, 'TI-99-1100-004', 'Temperature Indicator'),
(369, 64, 'TI-99-1200-002', 'Temperature Indicator'),
(370, 66, 'TI-99-1300-005', 'Temperature Indicator'),
(371, 66, 'TI-99-1300-006', 'Temperature Indicator'),
(372, 66, 'TI-99-1300-007', 'Temperature Indicator'),
(373, 66, 'TI-99-1300-008', 'Temperature Indicator'),
(374, 76, 'TI-99-1400-003', 'Temperature Indicator'),
(375, 76, 'TI-99-1400-004', 'Temperature Indicator'),
(376, 93, 'TI-99-1600-002', 'Temperature Indicator'),
(377, 101, 'TI-99-1700-004', 'Temperature Indicator'),
(378, 101, 'TI-99-1700-005', 'Temperature Indicator'),
(379, 101, 'TI-99-1700-006', 'Temperature Indicator'),
(380, 145, 'TI-99-5100-003', 'Temperature Indicator'),
(381, 145, 'TI-99-5100-004', 'Temperature Indicator'),
(382, 83, 'TI-99-5100-005', 'Temperature Indicator'),
(383, 146, 'TI-99-5200-003', 'Temperature Indicator'),
(384, 146, 'TI-99-5200-004', 'Temperature Indicator'),
(385, 148, 'TI-99-5400-002', 'Temperature Indicator'),
(386, 149, 'TI-99-5Q001-003', 'Temperature Indicator'),
(387, 149, 'TI-99-5Q001-004', 'Temperature Indicator'),
(388, 150, 'TI-99-5Q002-003', 'Temperature Indicator'),
(389, 150, 'TI-99-5Q002-004', 'Temperature Indicator'),
(390, 38, 'TI-99-CRXU', 'Temperature Indicator'),
(391, 38, 'TI-99-CRXU-5254372', 'Thermometer Indicator Thermocouple'),
(392, 38, 'TI-99-KKTU', 'Temperature Indicator'),
(393, 38, 'TI-99-KKTU-6042937', 'Thermometer Indicator Thermocouple'),
(394, 157, 'TI-99-Truck-001', 'Temperature Indicator'),
(395, 58, 'TM-21-10801', 'Timer'),
(396, 58, 'TM-21-10802', 'Timer'),
(397, 122, 'TM-21-30101', 'Sensor Current Step Time Indicator'),
(398, 138, 'TM-21-31901', 'Timer'),
(399, 138, 'TM-21-31903', 'Timer'),
(400, 138, 'TM-21-31904', 'Timer'),
(401, 119, 'TM-26-25701', 'Timer'),
(402, 78, 'TSL-25-14201', 'Temperature Switch'),
(403, 109, 'TT-12-20301', 'Temperature Transmitter'),
(404, 110, 'TT-12-20401', 'Temperature Transmitter'),
(405, 126, 'TT-12-30601', 'Temperature Transmitter'),
(406, 127, 'TT-12-30701', 'Temperature Transmitter'),
(407, 128, 'TT-12-30801', 'Temperature Transmitter'),
(408, 129, 'TT-12-30901', 'Temperature Transmitter'),
(409, 130, 'TT-12-31001', 'Temperature Transmitter'),
(410, 91, 'TT-21-15801-UHL', 'Temperature Transmitter'),
(411, 91, 'TT-21-15802-UHL', 'Temperature Transmitter'),
(412, 91, 'TT-21-15803-UHL', 'Temperature Transmitter'),
(413, 130, 'TT-21-31001', 'Temperature Transmitter'),
(414, 130, 'TT-21-31002', 'Temperature Transmitter'),
(415, 130, 'TT-21-31003', 'Temperature Transmitter'),
(416, 130, 'TT-21-31004', 'Temperature Transmitter'),
(417, 140, 'TT-21-32301', 'Temperature Transmitter'),
(418, 140, 'TT-21-32302', 'Temperature Transmitter'),
(419, 140, 'TT-21-32303', 'Temperature Transmitter'),
(420, 60, 'TT-22-11001', 'Temperature Transmitter'),
(421, 60, 'TT-22-11002', 'Temperature Transmitter'),
(422, 60, 'TT-22-11003', 'Temperature Transmitter'),
(423, 60, 'TT-22-11004', 'Temperature Transmitter'),
(424, 60, 'TT-22-11005', 'Temperature Transmitter'),
(425, 60, 'TT-22-11006', 'Temperature Transmitter'),
(426, 60, 'TT-22-11007', 'Temperature Transmitter'),
(427, 60, 'TT-22-11008', 'Temperature Transmitter'),
(428, 60, 'TT-22-11009', 'Temperature Transmitter'),
(429, 65, 'TT-23-12303-GET', 'Temperature Transmitter'),
(430, 78, 'TT-25-14201-KRG', 'Temperature Transmitter'),
(431, 119, 'TT-26-25702-GET', 'Temperature Transmitter'),
(432, 119, 'TT-26-25703-GET', 'Temperature Transmitter'),
(433, 56, 'TT-31-10201', 'Temperatur Trasmitter'),
(434, 56, 'TT-31-10202', 'Temperatur Trasmitter'),
(435, 56, 'TT-31-10204', 'Temperatur Trasmitter'),
(436, 56, 'TT-31-10205', 'Temperatur Trasmitter'),
(437, 56, 'TT-31-10206', 'Temperatur Trasmitter'),
(438, 56, 'TT-31-10207', 'Temperatur Trasmitter'),
(439, 56, 'TT-31-10208', 'Temperature Indicator'),
(440, 117, 'TT-42-25301', 'Temperature Transmitter'),
(441, 86, 'WS-21-13701', 'Weight'),
(442, 86, 'WS-21-13702', 'Weight'),
(443, 86, 'WS-21-13703', 'Weight'),
(444, 86, 'WS-21-13704', 'Weight'),
(445, 86, 'WS-21-13705', 'Weight'),
(446, 86, 'WS-21-13706', 'Weight'),
(447, 86, 'WS-21-13707', 'Weight'),
(448, 86, 'WS-21-13708', 'Weight'),
(449, 107, 'WS-21-13709', 'Weight'),
(450, 107, 'WS-21-13710', 'Weight'),
(451, 107, 'WS-21-13711', 'Weight'),
(452, 79, 'WS-21-13712', 'Weight'),
(453, 79, 'WS-21-13713', 'Weight'),
(454, 79, 'WS-21-13714', 'Weight'),
(455, 79, 'WS-21-13715', 'Weight'),
(456, 79, 'WS-21-13716', 'Weight'),
(457, 79, 'WS-21-13717', 'Weight'),
(458, 74, 'WS-21-13718', 'Weight'),
(459, 60, 'WS-21-13719', 'Weight'),
(460, 60, 'WS-21-13720', 'Weight'),
(461, 60, 'WS-21-13721', 'Weight'),
(462, 60, 'WS-21-13722', 'Weight'),
(463, 60, 'WS-21-13723', 'Weight'),
(464, 60, 'WS-21-13724', 'Weight'),
(465, 60, 'WS-21-13725', 'Weight'),
(466, 60, 'WS-21-13726', 'Weight'),
(467, 60, 'WS-21-13727', 'Weight'),
(468, 60, 'WS-21-13728', 'Weight'),
(469, 60, 'WS-21-13729', 'Weight'),
(470, 60, 'WS-21-13730', 'Weight'),
(471, 60, 'WS-21-13731', 'Weight'),
(472, 60, 'WS-21-13732', 'Weight'),
(473, 60, 'WS-21-13733', 'Weight'),
(474, 60, 'WS-21-13734', 'Weight'),
(475, 74, 'WS-21-13736', 'Weight'),
(476, 74, 'WS-21-13737', 'Weight'),
(477, 74, 'WS-21-13738', 'Weight'),
(478, 86, 'WS-21-13739', 'Weight'),
(479, 86, 'WS-21-13740', 'Weight'),
(480, 86, 'WS-21-13741', 'Weight'),
(481, 86, 'WS-21-13742', 'Weight'),
(482, 86, 'WS-21-13743', 'Weight'),
(483, 86, 'WS-21-13744', 'Weight'),
(484, 86, 'WS-21-13745', 'Weight'),
(485, 86, 'WS-21-13746', 'Weight'),
(486, 67, 'WS-31-17701', 'Weight'),
(487, 67, 'WS-33-13307', 'Weight'),
(488, 67, 'WS-33-13308', 'Weight'),
(489, 67, 'WS-33-13309', 'Weight'),
(490, 67, 'WS-33-13310', 'Weight'),
(491, 67, 'WS-33-13311', 'Weight'),
(492, 67, 'WS-33-13313', 'Weight'),
(493, 67, 'WS-33-13319', 'Weight'),
(494, 67, 'WS-33-13322', 'Weight'),
(495, 67, 'WS-33-13323', 'Weight'),
(496, 67, 'WS-33-13325', 'Weight'),
(497, 67, 'WS-33-13326', 'Weight'),
(498, 67, 'WS-33-13327', 'Weight'),
(499, 67, 'WS-33-13328', 'Weight'),
(500, 66, 'WS-39-001', 'Anak Timbang F1'),
(501, 66, 'WS-39-002', 'Anak Timbang F1'),
(502, 66, 'WS-39-003', 'Anak Timbang M1'),
(503, 66, 'WS-39-004', 'Anak Timbang M1'),
(504, 118, 'WS-42-25701', 'Anak Timbangan'),
(505, 118, 'WS-42-25702', 'Anak Timbangan'),
(506, 118, 'WS-42-25703', 'Anak Timbangan'),
(507, 118, 'WS-42-25704', 'Anak Timbangan'),
(508, 121, 'TI-42-25915', 'Temperature Indicator'),
(509, 160, 'PI-11-33201', 'Pressure Indicator'),
(510, 160, 'PI-11-33202', 'Pressure Indicator'),
(511, 140, 'DPI-21-32301', 'Differential Pressure Indicator'),
(512, 125, 'PI-11-30501-OFA', 'Pressure Gauge'),
(513, 125, 'PI-11-30502-OFA', 'Pressure Gauge'),
(514, 125, 'PI-11-30503-OFA', 'Pressure Gauge'),
(515, 125, 'PI-11-30504-OFA', 'Pressure Gauge'),
(516, 125, 'PI-11-30505-OFA', 'Pressure Gauge'),
(517, 144, 'PI-11-33401-BMI', 'Pressure Gauge'),
(518, 144, 'PI-11-33401-HD', 'Pressure Gauge'),
(519, 144, 'PI-11-33402-HD', 'Pressure Gauge'),
(520, 144, 'PI-11-33402-TK', 'Pressure Gauge'),
(521, 144, 'PI-11-33403-BMI', 'Pressure Gauge'),
(522, 144, 'PI-11-33404-BMI', 'Pressure Gauge'),
(523, 144, 'PSL-11-33403', 'Pressure Switch Low'),
(524, 125, 'SV-11-30501-OFA', 'Safety Valve'),
(525, 125, 'SV-11-30502-OFA', 'Safety Valve'),
(526, 69, 'TC-11-1356.1-CB', 'Temperature Controller'),
(527, 69, 'TC-11-1356.2-CB', 'Temperature Controller'),
(528, 73, 'TC-23-13701', 'Temperature Controller'),
(529, 144, 'TI-11-33401-BMI', 'Temperature Indicator'),
(530, 144, 'TI-11-33401-HW', 'Temperature Indicator'),
(531, 144, 'TI-11-33402-BMI', 'Temperature Indicator'),
(532, 144, 'TI-11-33403-BMI', 'Temperature Indicator'),
(533, 144, 'TI-11-33404-BMI', 'Temperature Indicator'),
(534, 144, 'TI-11-33405-BMI', 'Temperature Indicator'),
(535, 144, 'TI-11-33406-BMI', 'Temperature Indicator'),
(536, 138, 'PI-21-31901', 'Pressure Indicator'),
(537, 140, 'PI-21-32304', 'Pressure Indicator'),
(538, 140, 'PI-21-32305', 'Pressure Indicator'),
(539, 140, 'PI-21-32306', 'Pressure Indicator'),
(540, 137, 'PI-21-31801', 'Pressure Indicator'),
(541, 141, 'PI-21-32401', 'Pressure Indicator'),
(542, 141, 'PI-21-32402', 'Pressure Indicator'),
(543, 141, 'PI-21-32403', 'Pressure Indicator'),
(544, 141, 'PI-21-32404', 'Pressure Indicator'),
(545, 141, 'PI-21-32405', 'Pressure Indicator'),
(546, 138, 'TM-21-31902', 'Timer Indicator'),
(547, 122, 'PT-21-30102', 'Pressure For Convert to Flow Indicator'),
(548, 122, 'TI-21-30105', 'Temperature Indicator'),
(549, 140, 'PI-21-32307', 'Pressure Indicator'),
(550, 138, 'PI-21-31902', 'Pressure Indicator'),
(551, 138, 'PI-21-31903', 'Pressure Indicator'),
(552, 137, 'PI-21-31802', 'Pressure Indicator'),
(553, 4, 'DPI-12-20502A-BF1', 'Differential Pressure Gauge'),
(554, 5, 'DPI-12-20502B-BF1', 'Differential Pressure Gauge'),
(555, 4, 'DPI-12-20503A-BF2', 'Differential Pressure Gauge'),
(556, 5, 'DPI-12-20503B-BF2', 'Differential Pressure Gauge'),
(557, 4, 'DPI-12-20504A-HF', 'Differential Pressure Gauge'),
(558, 5, 'DPI-12-20504B-HF', 'Differential Pressure Gauge'),
(559, 122, 'DPI-12-30101-GLT', 'Differential Pressure Gauge'),
(560, 122, 'DPI-12-30102-GLT', 'Differential Pressure Gauge'),
(561, 7, 'DPI-12-30401-AHU', 'Differential Pressure Gauge'),
(562, 7, 'DPI-12-30402-AHU', 'Differential Pressure Gauge'),
(563, 7, 'DPI-12-30403-AHU', 'Differential Pressure Gauge'),
(564, 11, 'DPI-12-30701-AHU', 'Differential Pressure Gauge'),
(565, 11, 'DPI-12-30702-AHU', 'Differential Pressure Gauge'),
(566, 11, 'DPI-12-30703-AHU', 'Differential Pressure Gauge'),
(567, 11, 'DPI-12-30901-AHU', 'Differential Pressure Gauge'),
(568, 11, 'DPI-12-30902-AHU', 'Differential Pressure Gauge'),
(569, 11, 'DPI-12-30903-AHU', 'Differential Pressure Gauge'),
(570, 11, 'DPI-12-30904-AHU', 'Differential Pressure Gauge'),
(571, 11, 'DPI-12-30905-AHU', 'Differential Pressure Gauge'),
(572, 11, 'DPI-12-30906-AHU', 'Differential Pressure Gauge'),
(573, 11, 'DPI-12-30907-AHU', 'Differential Pressure Gauge'),
(574, 11, 'DPI-12-30908-AHU', 'Differential Pressure Gauge'),
(575, 133, 'DPI-21-31301-LAF', 'Differential Pressure'),
(576, 7, 'DPT-13-33301', 'Differential Pressure Transmitter'),
(577, 7, 'DPT-13-33302', 'Differential Pressure Transmitter'),
(578, 8, 'DPT-13-33303', 'Differential Pressure Transmitter'),
(579, 8, 'DPT-13-33304', 'Differential Pressure Transmitter'),
(580, 11, 'DPT-13-33306', 'Differential Pressure Transmitter'),
(581, 11, 'DPT-13-33307', 'Differential Pressure Transmitter'),
(582, 4, 'DPT-13-33309', 'Differential Pressure Transmitter'),
(583, 4, 'DPT-13-33310', 'Differential Pressure Transmitter'),
(584, 4, 'DPT-13-33311', 'Differential Pressure Transmitter'),
(585, 5, 'DPT-13-33312', 'Differential Pressure Transmitter'),
(586, 5, 'DPT-13-33313', 'Differential Pressure Transmitter'),
(587, 21, 'DPT-13-33315', 'Differential Pressure Transmitter'),
(588, 21, 'DPT-13-33316', 'Differential Pressure Transmitter'),
(589, 12, 'DPT-13-33317', 'Differential Pressure Transmitter'),
(590, 13, 'DPT-13-33318', 'Differential Pressure Transmitter'),
(591, 13, 'DPT-13-33319', 'Differential Pressure Transmitter'),
(592, 14, 'DPT-13-33321', 'Differential Pressure Transmitter'),
(593, 14, 'DPT-13-33322', 'Differential Pressure Transmitter'),
(594, 17, 'DPT-13-33324', 'Differential Pressure Transmitter'),
(595, 17, 'DPT-13-33325', 'Differential Pressure Transmitter'),
(596, 23, 'DPT-13-33327', 'Differential Pressure Transmitter'),
(597, 69, 'PI-11-13501-DMP', 'Pressure Gauge'),
(598, 69, 'PI-11-13501-RO', 'Pressure Gauge'),
(599, 69, 'PI-11-13502-DMP', 'Pressure Gauge'),
(600, 69, 'PI-11-13502-RO', 'Pressure Gauge'),
(601, 69, 'PI-11-13503-DMP', 'Pressure Gauge'),
(602, 69, 'PI-11-13503-RO', 'Pressure Gauge'),
(603, 69, 'PI-11-13504-DMP', 'Pressure Gauge'),
(604, 69, 'PI-11-13504-RO', 'Pressure Gauge'),
(605, 69, 'PI-11-13505-DMP', 'Pressure Gauge'),
(606, 69, 'PI-11-13506-DMP', 'Pressure Gauge'),
(607, 69, 'PI-11-1351.1-PT', 'Pressure Gauge'),
(608, 69, 'PI-11-1351.2-PT', 'Pressure Gauge'),
(609, 69, 'PI-11-13516.2', 'Pressure Gauge'),
(610, 69, 'PI-11-1353.1-PT', 'Pressure Gauge'),
(611, 69, 'PI-11-1353.2-PT', 'Pressure Gauge'),
(612, 69, 'PI-11-1355.1A-DMP', 'Pressure Gauge'),
(613, 69, 'PI-11-1355.1B-DMP', 'Pressure Gauge'),
(614, 69, 'PI-11-1355.2A-DMP', 'Pressure Gauge'),
(615, 69, 'PI-11-1355.2B-DMP', 'Pressure Gauge'),
(616, 69, 'PI-11-1355.3A-DMP', 'Pressure Gauge'),
(617, 69, 'PI-11-1355.3B-DMP', 'Pressure Gauge'),
(618, 69, 'PI-11-1355.4A-DMP', 'Pressure Gauge'),
(619, 69, 'PI-11-1355.4B-DMP', 'Pressure Gauge'),
(620, 69, 'PI-11-1356.1A-DMP', 'Pressure Gauge'),
(621, 69, 'PI-11-1356.1B-DMP', 'Pressure Gauge'),
(622, 69, 'PI-11-1356.2A-DMP', 'Pressure Gauge'),
(623, 69, 'PI-11-1356.2B-DMP', 'Pressure Gauge'),
(624, 72, 'PI-11-136011-PMS', 'Pressure Gauge'),
(625, 72, 'PI-11-136020.1-PSG', 'Pressure Gauge'),
(626, 72, 'PI-11-136020-PSG', 'Pressure Gauge'),
(627, 72, 'PI-11-13609-PMS', 'Pressure Gauge'),
(628, 72, 'PI-11-13610.1-PWU', 'Pressure Gauge'),
(629, 72, 'PI-11-13610.2-PWU', 'Pressure Gauge'),
(630, 72, 'PI-11-13615.1-PWU ', 'Pressure Gauge'),
(631, 72, 'PI-11-13615.2-PMS', 'Pressure Gauge'),
(632, 124, 'PI-11-30401-CH', 'Pressure Gauge'),
(633, 124, 'PI-11-30402-CH', 'Pressure Gauge'),
(634, 124, 'PI-11-30403-CH', 'Pressure Gauge'),
(635, 124, 'PI-11-30404-CH', 'Pressure Gauge'),
(636, 124, 'PI-11-30405-CH', 'Pressure Gauge'),
(637, 124, 'PI-11-30406-CH', 'Pressure Gauge'),
(638, 125, 'PI-11-30501-CH', 'Pressure Gauge'),
(639, 125, 'PI-11-30502-CH', 'Pressure Gauge'),
(640, 125, 'PI-11-30503-CH', 'Pressure Gauge'),
(641, 125, 'PI-11-30504-CH', 'Pressure Gauge'),
(642, 125, 'PI-11-30505-CH', 'Pressure Gauge'),
(643, 126, 'PI-11-30601', 'Pressure Indicator'),
(644, 126, 'PI-11-30602', 'Pressure Indicator'),
(645, 126, 'PI-11-30603', 'Pressure Indicator'),
(646, 126, 'PI-11-30604', 'Pressure Indicator'),
(647, 126, 'PI-11-30605', 'Pressure Indicator'),
(648, 126, 'PI-11-30606', 'Pressure Indicator'),
(649, 126, 'PI-11-30607', 'Pressure Indicator'),
(650, 126, 'PI-11-30608', 'Pressure Indicator'),
(651, 144, 'PI-11-33403-HD', 'Pressure Gauge'),
(652, 144, 'PI-11-33404-HD', 'Pressure Gauge'),
(653, 144, 'PI-11-33405-HD', 'Pressure Gauge'),
(654, 144, 'PI-11-33406-HD', 'Pressure Gauge'),
(655, 144, 'PI-11-33407-HD', 'Pressure Gauge'),
(656, 20, 'PI-12-20101', 'Pressure Gauge'),
(657, 20, 'PI-12-20102', 'Pressure Gauge'),
(658, 20, 'PI-12-20103', 'Pressure Gauge'),
(659, 20, 'PI-12-20104', 'Pressure Gauge'),
(660, 6, 'PI-12-20301', 'Pressure Gauge'),
(661, 6, 'PI-12-20302', 'Pressure Gauge'),
(662, 9, 'PI-12-20401', 'Pressure Gauge'),
(663, 9, 'PI-12-20402', 'Pressure Gauge'),
(664, 1, 'PI-12-30101', 'Pressure Gauge'),
(665, 1, 'PI-12-30102', 'Pressure Gauge'),
(666, 3, 'PI-12-30301', 'Pressure Gauge'),
(667, 3, 'PI-12-30302', 'Pressure Gauge'),
(668, 3, 'PI-12-30303', 'Pressure Gauge'),
(669, 3, 'PI-12-30304', 'Pressure Gauge'),
(670, 7, 'PI-12-30401', 'Pressure Gauge'),
(671, 7, 'PI-12-30402', 'Pressure Gauge'),
(672, 8, 'PI-12-30501', 'Pressure Gauge'),
(673, 8, 'PI-12-30502', 'Pressure Gauge'),
(674, 10, 'PI-12-30601', 'Pressure Gauge'),
(675, 10, 'PI-12-30602', 'Pressure Gauge'),
(676, 70, 'PI-13-40001-CHO', 'Pressure Gauge'),
(677, 70, 'PI-13-40002-CHO', 'Pressure Gauge'),
(678, 70, 'PI-13-40003-CHO', 'Pressure Gauge'),
(679, 70, 'PI-13-40004-CHO', 'Pressure Gauge'),
(680, 68, 'PI-16-30001-BC', 'Pressure Gauge'),
(681, 68, 'PI-16-30001-TC', 'Pressure Gauge'),
(682, 68, 'PI-16-30002-SC', 'Pressure Gauge'),
(683, 143, 'PI-17-13402-WT', 'Pressure Gauge'),
(684, 68, 'PI-17-13403-HWT', 'Pressure Gauge'),
(685, 143, 'PI-17-33201', 'Pressure Gauge'),
(686, 143, 'PI-17-33202', 'Pressure Gauge'),
(687, 143, 'PI-17-33203', 'Pressure Gauge'),
(688, 143, 'PI-17-33204', 'Pressure Gauge'),
(689, 143, 'PI-17-33205', 'Pressure Gauge'),
(690, 143, 'PI-17-33206', 'Pressure Gauge'),
(691, 161, 'PI-17-40001-HP', 'Pressure Gauge'),
(692, 161, 'PI-17-40001-PG', 'Pressure Gauge'),
(693, 161, 'PI-17-40002-HP', 'Pressure Gauge'),
(694, 161, 'PI-17-40002-PG', 'Pressure Gauge'),
(695, 161, 'PI-17-40003-HP', 'Pressure Gauge'),
(696, 161, 'PI-17-40003-SF', 'Pressure Gauge'),
(697, 161, 'PI-17-40004-SF', 'Pressure Gauge'),
(698, 161, 'PI-17-40005-FP', 'Pressure Gauge'),
(699, 126, 'PI-19-30601', 'Pressure Gauge'),
(700, 126, 'PI-19-30602', 'Pressure Gauge'),
(701, 126, 'PI-19-30603', 'Pressure Gauge'),
(702, 126, 'PI-19-30604', 'Pressure Gauge'),
(703, 126, 'PI-19-30605', 'Pressure Gauge'),
(704, 126, 'PI-19-30606', 'Pressure Gauge'),
(705, 126, 'PI-19-30607', 'Pressure Gauge'),
(706, 126, 'PI-19-30608', 'Pressure Gauge'),
(707, 126, 'PI-19-30609', 'Pressure Gauge'),
(708, 161, 'PI-19-33201', 'Pressure Indicator'),
(709, 161, 'PI-19-33202', 'Pressure Indicator'),
(710, 84, 'PI-21-15101', 'Pressure Gauge'),
(711, 84, 'PI-21-15102', 'Vacuum Gauge'),
(712, 87, 'PI-21-15401', 'Pressure Gauge'),
(713, 87, 'PI-21-15403', 'Pressure Gauge'),
(714, 87, 'PI-21-15404', 'Pressure Gauge'),
(715, 88, 'PI-21-15501', 'Vacuum  Gauge'),
(716, 91, 'PI-21-15801-UHL', 'Pressure Gauge'),
(717, 91, 'PI-21-15802-UHL', 'Pressure Gauge'),
(718, 91, 'PI-21-15803-UHL', 'Pressure Gauge'),
(719, 91, 'PI-21-15804-UHL', 'Pressure Gauge'),
(720, 98, 'PI-21-16601', 'Pressure Gauge'),
(721, 98, 'PI-21-16602', 'Pressure Gauge'),
(722, 98, 'PI-21-16603', 'Pressure Gauge'),
(723, 98, 'PI-21-16604', 'Pressure Gauge'),
(724, 130, 'PI-21-31003', 'Pressure Indicator'),
(725, 131, 'PI-21-31101-UHL', 'Pressure Gauge'),
(726, 131, 'PI-21-31102-UHL', 'Pressure Gauge'),
(727, 136, 'PI-21-31701', 'Pressure Indicator'),
(728, 140, 'PI-21-32303', 'Pressure Indicator'),
(729, 60, 'PI-22-11001', 'Pressure Gauge'),
(730, 60, 'PI-22-11002', 'Pressure Gauge'),
(731, 60, 'PI-22-11004', 'Pressure Indicator'),
(732, 65, 'PI-23-12301', 'Pressure Indicator'),
(733, 65, 'PI-23-12301-GET', 'Pressure Gauge'),
(734, 65, 'PI-23-12302-GET', 'Pressure Gauge'),
(735, 65, 'PI-23-12302-GNR', 'Pressure Gauge'),
(736, 65, 'PI-23-12303-GET', 'Pressure Gauge'),
(737, 65, 'PI-23-12304-GET', 'Pressure Gauge'),
(738, 65, 'PI-23-12305-GET', 'Pressure Gauge'),
(739, 78, 'PI-25-30001-KRG', 'Pressure Gauge'),
(740, 78, 'PI-25-30002-KRG', 'Pressure Gauge'),
(741, 80, 'PI-29-144A01', 'Pressure Indicator'),
(742, 119, 'PI-42-25701', 'Pressure Indicator'),
(743, 119, 'PI-42-25702', 'Pressure Indicator'),
(744, 126, 'PS-11-30601', 'Pressure Switch'),
(745, 126, 'PS-11-30602', 'Pressure Switch'),
(746, 126, 'PS-11-30603', 'Pressure Switch'),
(747, 126, 'PS-11-30604', 'Pressure Switch'),
(748, 143, 'PSL-17-33201', 'Pressure Switch Low'),
(749, 143, 'PSL-17-33202', 'Pressure Switch Low'),
(750, 143, 'PSL-17-33203', 'Pressure Switch'),
(751, 62, 'RH-32-11208', 'Humidity Indicator'),
(752, 143, 'SV-17-33201', 'Safety Valve'),
(753, 143, 'SV-17-33202', 'Safety Valve'),
(754, 7, 'THT-13-33301', 'Temperature Humidity Transmitter'),
(755, 7, 'THT-13-33301.', 'Temperature Humidity Transmitter'),
(756, 4, 'THT-13-33303', 'Temperature Humidity Transmitter'),
(757, 4, 'THT-13-33303.', 'Temperature Humidity Transmitter'),
(758, 15, 'THT-13-33304', 'Temperature Humidity Transmitter'),
(759, 5, 'THT-13-33305', 'Temperature Humidity Transmitter'),
(760, 5, 'THT-13-33305.', 'Temperature Humidity Transmitter'),
(761, 22, 'THT-13-33306', 'Temperatur Humidity trasmitter'),
(762, 22, 'THT-13-33306.', 'Temperature Humidity Transmitter'),
(763, 15, 'THT-13-33308', 'Temperature Humidity Transmitter'),
(764, 8, 'THT-13-33309', 'Temperatur Humidity trasmitter'),
(765, 8, 'THT-13-33309.', 'Temperature Humidity Transmitter'),
(766, 16, 'THT-13-33314', 'Temperature Humidity Transmitter'),
(767, 18, 'TI-11-30401-CH', 'Temperature Gauge'),
(768, 18, 'TI-11-30402-CH', 'Temperature Gauge'),
(769, 18, 'TI-11-30403-CH', 'Temperature Gauge'),
(770, 18, 'TI-11-30404-CH', 'Temperature Gauge'),
(771, 19, 'TI-11-30501-CH', 'Temperature Gauge'),
(772, 19, 'TI-11-30502-CH', 'Temperature Gauge'),
(773, 19, 'TI-11-30503-CH', 'Temperature Gauge'),
(774, 126, 'TI-11-30601', 'Temperature Indicator'),
(775, 126, 'TI-11-30602', 'Temperature Indicator'),
(776, 2, 'TI-12-20101', 'Temperature Gauge'),
(777, 2, 'TI-12-20102', 'Temperature Gauge'),
(778, 2, 'TI-12-20103', 'Temperature Gauge'),
(779, 2, 'TI-12-20104', 'Temperature Gauge'),
(780, 6, 'TI-12-20301', 'Temperature Gauge'),
(781, 6, 'TI-12-20302', 'Temperature Gauge'),
(782, 9, 'TI-12-20401', 'Temperature Gauge'),
(783, 9, 'TI-12-20402', 'Temperature Gauge'),
(784, 1, 'TI-12-30101', 'Temperature Gauge'),
(785, 1, 'TI-12-30102', 'Temperature Gauge'),
(786, 3, 'TI-12-30302', 'Temperature Gauge'),
(787, 3, 'TI-12-30303', 'Temperature Gauge'),
(788, 3, 'TI-12-30304', 'Temperature Gauge'),
(789, 7, 'TI-12-30401', 'Temperature Gauge'),
(790, 7, 'TI-12-30402', 'Temperature Gauge'),
(791, 8, 'TI-12-30501', 'Temperature Gauge'),
(792, 8, 'TI-12-30502', 'Temperature Gauge'),
(793, 10, 'TI-12-30601', 'Temperature Gauge'),
(794, 10, 'TI-12-30602', 'Temperature Gauge'),
(795, 71, 'TI-13-40001-CHO', 'Temperature Gauge'),
(796, 71, 'TI-13-40002-CHO', 'Temperature Gauge'),
(797, 71, 'TI-13-40003-CHO', 'Temperature Gauge'),
(798, 71, 'TI-13-40004-CHO', 'Temperature Gauge'),
(799, 68, 'TI-14-13401-BBL', 'Temperature Gauge'),
(800, 68, 'TI-15-13401-L', 'Temperature Gauge'),
(801, 68, 'TI-15-13402-L', 'Temperature Gauge'),
(802, 68, 'TI-15-13403-L', 'Temperature Gauge'),
(803, 68, 'TI-17-13401-HWT', 'Temperature Gauge'),
(804, 68, 'TI-17-13402-HWT', 'Temperature Gauge'),
(805, 68, 'TI-17-30001-STM', 'Temperature Gauge'),
(806, 65, 'TI-23-12301-WFI', 'Temperature Gauge'),
(807, 84, 'TM-21-15101', 'Timer'),
(808, 84, 'TM-21-15102', 'Timer'),
(809, 84, 'TM-21-15103', 'Timer'),
(810, 84, 'TM-21-15104', 'Timer'),
(811, 87, 'TM-21-15401', 'Timer'),
(812, 87, 'TM-21-15402', 'Timer'),
(813, 87, 'TM-21-15404', 'Timer'),
(814, 96, 'PI-21-16401', 'Pressure Indicator'),
(815, 59, 'PI-21-10901', 'Pressure Indicator'),
(816, 94, 'PI-21-16201', 'Pressure Indicator'),
(817, 78, 'TI-25-14202', 'Temperature Indicator'),
(818, 105, 'TI-25-19102', 'Temperature Indicator'),
(819, 159, 'AC-001', 'Dehumidifier 14-2'),
(820, 159, 'AC-002', 'Dehumidifier 9-3'),
(821, 45, 'AC-015', 'Level Control Valve'),
(822, 45, 'AC-016', 'AHU System 3'),
(823, 45, 'AC-017', 'AHU System 5'),
(824, 45, 'AC-018', 'AHU System 14 A'),
(825, 45, 'AC-019', 'AHU System 14 B'),
(826, 45, 'AC-021', 'AHU System 15'),
(827, 45, 'AC-022', 'AHU System 16'),
(828, 45, 'AC-023', 'AHU System 17'),
(829, 45, 'AC-024', 'AHU System 18'),
(830, 45, 'AC-026', 'AHU System 20'),
(831, 45, 'AC-027', 'Exhaust Fan System 4'),
(832, 45, 'AC-050', 'Fan Toilet'),
(833, 166, 'AC-052', 'AHU System 23'),
(834, 45, 'AC-055', 'AHU System 9-1'),
(835, 45, 'AC-056', 'AHU System 9-2'),
(836, 45, 'AC-058', 'AHU System 24.1'),
(837, 45, 'AC-059', 'AHU System 24.2'),
(838, 45, 'AC-060', 'Dehumidifier 24.2'),
(839, 45, 'AC-061', 'AHU System 25'),
(840, 45, 'AC-062', 'AHU System 26'),
(841, 45, 'AC-063', 'AHU System 27'),
(842, 45, 'AC-064', 'AHU System 28'),
(843, 26, 'AC-065', 'Dehumidifier 1'),
(844, 26, 'AC-066', 'Dehumidifier 2'),
(845, 167, 'AC-067', 'Dehumidifier'),
(846, 26, 'AC-068', 'Air Conditioner 1300A'),
(847, 26, 'AC-069', 'Air Conditioner 1300B'),
(848, 26, 'AC-070', 'Air Conditioner 1300C'),
(849, 26, 'AC-071', 'Air Conditioner 1300D'),
(850, 162, 'CSV-004-00 ', 'BMS Gandaria SCADA/BMS web View'),
(851, 33, 'U-002', 'Fuel Trans.Pump'),
(852, 33, 'U-004', 'Battery Charger'),
(853, 51, 'U-005', 'Fuel Main Tank 1'),
(854, 159, 'U-015', 'Air Compressor 1'),
(855, 159, 'U-016', 'Air Compressor 2'),
(856, 159, 'U-018-1', 'Air Dryer 1'),
(857, 159, 'U-018-2', 'Air Dryer 2'),
(858, 159, 'U-019', 'Hot Water Mixing Tank'),
(859, 159, 'U-020', 'Hot Water Pump'),
(860, 159, 'U-021', 'Hot Water Storage Tank'),
(861, 159, 'U-021-2', 'Potable Water Tank A'),
(862, 159, 'U-022', 'Submersible Pump No.2'),
(863, 159, 'U-024', 'Well W. Main Tank 50 M3'),
(864, 159, 'U-025', 'Well W. Main Tank 100 M3'),
(865, 159, 'U-026', 'Transfer Pump'),
(866, 159, 'U-027', 'Degisifier'),
(867, 159, 'U-028', 'Clorinator'),
(868, 159, 'U-029', 'Sand Filter'),
(869, 159, 'U-030', 'Daily Well Water Pump 1 (PW A)'),
(870, 159, 'U-031', 'Daily Well Water Pump 2 (PW B)'),
(871, 51, 'U-034', 'N2 Liquid Tank'),
(872, 51, 'U-035', 'N2 Filter'),
(873, 159, 'U-036', 'Demi Plant Unit'),
(874, 159, 'U-037', 'PSG Unit'),
(875, 159, 'U-038', 'Neutralizer Unit'),
(876, 51, 'U-039', 'Stand by cold water pump A'),
(877, 45, 'U-040', 'AHU sytem 21.1'),
(878, 45, 'U-041', 'AHU system 22.2'),
(879, 159, 'U-042', 'Oil Free Air ZT-37'),
(880, 159, 'U-043-1', 'Blower 1'),
(881, 159, 'U-043-2', 'Blower 2'),
(882, 159, 'U-044', 'Sand Filter Pump Waste Water 1'),
(883, 159, 'U-045', 'Carbon Filter Pump Waste Water 2'),
(884, 159, 'U-046', 'Electric Drying'),
(885, 41, 'U-047', 'Washing Machine'),
(886, 41, 'U-048', 'Draying machine'),
(887, 53, 'U-049', 'Floor Polisher'),
(888, 161, 'U-050', 'Holding Tank Air Compressor'),
(889, 159, 'U-052', 'Waste Water Pump'),
(890, 159, 'U-055', 'WPU tank and loop'),
(891, 159, 'U-056', 'WFI tank and loop'),
(892, 159, 'U-057', 'WFI production'),
(893, 51, 'U-058-1', 'Jocky pump'),
(894, 28, 'U-067', 'Lift'),
(895, 159, 'U-070', 'Fuel Main Tank 2'),
(896, 159, 'U-075', 'Trane 1 Chiller'),
(897, 159, 'U-075-2', 'Trane 2 Chiller'),
(898, 159, 'U-076', 'Cooling water pump 1 '),
(899, 159, 'U-077', 'Chiller water pump 1'),
(900, 51, 'U-078', 'Water Cooler LBC 500'),
(901, 153, 'U-079', 'Hand Dryer'),
(902, 159, 'U-080', 'Tapproge CCS 1'),
(903, 159, 'U-080-2', 'Tapproge CCS 2'),
(904, 159, 'U-081', 'Reverse Osmosis Demin'),
(905, 159, 'U-082', 'Holding Tank Oil Free'),
(906, 159, 'U-083', 'Cooling water pump 2'),
(907, 159, 'U-084', 'Chiller water pump 2'),
(908, 43, 'U-085', 'Hand Dryer'),
(909, 43, 'U-086', 'Hand Dryer'),
(910, 31, 'U-087', 'Hand Dryer'),
(911, 31, 'U-088', 'Hand Dryer'),
(912, 158, 'U-089', 'Hand Dryer'),
(913, 45, 'U-090', 'Compressed Air Dryer'),
(914, 161, 'U-091', 'Holding Tank for Boiler'),
(915, 161, 'U-096', 'Miura Boiler 1'),
(916, 161, 'U-097', 'Miura Boiler 2'),
(917, 161, 'U-098', 'Reverse Osmosis Raw Water'),
(918, 161, 'U-099', 'Carbon Filter Raw Water'),
(919, 161, 'U-100', 'Dessicant Dryer'),
(920, 161, 'U-101', 'OFA Compressor Water Lubricated'),
(921, 161, 'U-102', 'Yamaha Sand & Corbon Water Filter'),
(922, 161, 'U-104', 'Water Filter 5 µ for Mitshui Seiki Compressor'),
(923, 36, 'U-107', 'Vacuum Cleaner Delvin'),
(924, 55, 'U-108', 'Vacuum Cleaner Krisbow'),
(925, 161, 'U-109', 'Potable Water Tank B'),
(926, 51, 'U-110', 'Water Cooling Tower LRC 250'),
(927, 161, 'U-111', 'AiCool Chiller'),
(928, 161, 'U-112', 'OFA Compressor Water Lubricated 2'),
(929, 161, 'U-113', 'Water Filter 5 µ for Mitshui Seiki Compressor 2'),
(930, 161, 'U-114', 'Chlorinator 2'),
(931, 33, 'U-115', 'Perkins Genset'),
(932, 154, 'HF-31-11401', 'HEPA Ceiling'),
(933, 154, 'HF-31-11402', 'HEPA Ceiling'),
(934, 154, 'HF-31-11403', 'HEPA Ceiling'),
(935, 154, 'HF-31-11404', 'HEPA Ceiling'),
(936, 154, 'HF-31-11405', 'HEPA Ceiling'),
(937, 154, 'HF-31-11406', 'HEPA Ceiling'),
(938, 154, 'HF-31-11407', 'HEPA Ceiling'),
(939, 154, 'HF-31-11408', 'HEPA Ceiling'),
(940, 154, 'HF-31-11409', 'HEPA Ceiling'),
(941, 48, 'HF-25-14301-P20', 'Laminar Air Flow'),
(942, 48, 'HF-25-14302-P20', 'Laminar Air Flow'),
(943, 48, 'HF-25-14303', 'HEPA Ceiling'),
(944, 48, 'HF-25-14304', 'HEPA Ceiling'),
(945, 54, 'HF-25-14201', 'HEPA Ceiling'),
(946, 54, 'HF-25-14202', 'HEPA Ceiling'),
(947, 40, 'HF-21605', 'Laminar Air Flow'),
(948, 46, 'HF-26-25301', 'HEPA Ceiling'),
(949, 34, 'HF-26-25401', 'HEPA Ceiling'),
(950, 24, 'HF-26-25501', 'HEPA Ceiling'),
(951, 46, 'HF-26-25601', 'HEPA Ceiling'),
(952, 164, 'HF-25-14401-A', 'HEPA Ceiling'),
(953, 49, 'HF-25-14401-B', 'HEPA Ceiling'),
(954, 49, 'HF-25-14402-B', 'HEPA Ceiling'),
(955, 168, 'HF-23-12301-P21', 'Laminar Air Flow'),
(956, 168, 'HF-23-12302-P21', 'Laminar Air Flow'),
(957, 168, 'HF-23-12303-P21', 'Laminar Air Flow'),
(958, 168, 'HF-23-12304-P21', 'Laminar Air Flow'),
(959, 168, 'HF-23-12305-P21', 'Laminar Air Flow'),
(960, 42, 'HF-23-12301-PI7', 'Laminar Air Flow'),
(961, 42, 'HF-23-12302-PI7', 'Laminar Air Flow'),
(962, 42, 'HF-23-12303-P17', 'Laminar Air Flow'),
(963, 42, 'HF-23-12304-PI7', 'Laminar Air Flow'),
(964, 34, 'HF-24-12703', 'HEPA Ceiling'),
(965, 24, 'HF-24-12803', 'HEPA Ceiling'),
(966, 30, 'HF-24-12605', 'HEPA Ceiling'),
(967, 30, 'HF-24-12606', 'HEPA Ceiling'),
(968, 163, 'HF-24-12903', 'HEPA Ceiling'),
(969, 165, 'HF-24-14014', 'HEPA Ceiling'),
(970, 165, 'HF-24-14015', 'HEPA Ceiling'),
(971, 165, 'HF-24-14016', 'HEPA Ceiling'),
(972, 165, 'HF-24-14017', 'HEPA Ceiling'),
(973, 50, 'HF-24-14108', 'HEPA Ceiling'),
(974, 50, 'HF-24-14109', 'HEPA Ceiling'),
(975, 32, 'HF-24-14503', 'HEPA Ceiling'),
(976, 50, 'HF-24-14101-PI9', 'Laminar Air Flow'),
(977, 50, 'HF-24-14102-PI9', 'Laminar Air Flow'),
(978, 50, 'HF-24-14103-PI9', 'Laminar Air Flow'),
(979, 50, 'HF-24-14104-PI9', 'Laminar Air Flow'),
(980, 165, 'HF-24-14005-PI8', 'Laminar Air Flow'),
(981, 165, 'HF-24-14006-PI8', 'Laminar Air Flow'),
(982, 165, 'HF-24-14007-PI8', 'Laminar Air Flow'),
(983, 165, 'HF-24-14008-PI8', 'Laminar Air Flow'),
(984, 165, 'HF-24-14009-P18', 'Laminar Air Flow'),
(985, 165, 'HF-24-12501-P25', 'Laminar Air Flow'),
(986, 29, 'HF-24-12502-P25', 'Laminar Air Flow'),
(987, 29, 'HF-24-12503-P25', 'Laminar Air Flow'),
(988, 29, 'HF-24-12504-P25', 'Laminar Air Flow'),
(989, 29, 'HF-24-12505-P25', 'Laminar Air Flow'),
(990, 29, 'HF-24-12506-P25', 'Laminar Air Flow'),
(991, 29, 'HF-24-12507-P25', 'Laminar Air Flow'),
(992, 29, 'HF-24-12508-P25', 'Laminar Air Flow'),
(993, 47, 'HF-24003-MOB', 'Laminar Air Flow'),
(994, 35, 'HF-42-25301', 'HEPA Ceiling'),
(995, 35, 'HF-42-25302', 'HEPA Ceiling'),
(996, 25, 'HF-42-25601-BSC', 'HEPA Ceiling'),
(997, 25, 'HF-42-25602-BSC', 'HEPA Ceiling');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dept_id` int NOT NULL,
  `status` smallint NOT NULL DEFAULT '1',
  `role` int NOT NULL DEFAULT '2',
  `spv` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `signature` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `priv` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` int NOT NULL,
  `updated_at` int DEFAULT NULL,
  `last_loged` int DEFAULT NULL,
  `auth_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- RELATIONSHIPS FOR TABLE `user`:
--

--
-- Dumping data for table `user`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `email`, `dept_id`, `status`, `role`, `spv`, `signature`, `priv`, `created_at`, `updated_at`, `last_loged`, `auth_key`, `password_hash`, `access_token`, `password_reset_token`) VALUES
(1, 'admin', 'Admin User', 'anthon.awan@gmail.com', 1, 1, 1, '', '', '', 1625132687, 1637316909, 1637315856, 'o_vQHseuaqDp6j3g31mQz_NMvJO3kFfJ', '$2y$13$e8gIxO2RHl.UFFWnhrTwd.Upuw8xaflr7xv/9UtX6tCjYVwB5opiK', '_e7cWKC1w7eHVUyjgN6Nr17zyCj8-RnI_admin', NULL),
(2, 'init', 'Initiator user', 'int@int.com', 1, 1, 2, '', '', '', 1625135463, 1633292325, 1633320102, 'wjraTFgE-qDVZSX7URI4HzxZyWBY3hrL', '$2y$13$z7irJ651MgrkuBGvVuSec.bJqW6ozSepWk3BeezCtSx8eAals.7xm', 'xvNAYEvH6SfdNGzaRIzHHbqRn1Es7A1W_init', NULL),
(3, 'spv', 'Supervisor user', 'spv@spv.com', 2, 1, 2, '', '', '', 1625153413, 1633381719, 1633503369, 'DTy7AYVRqzDJ4P73tYUh6IBPQhVBbJLf', '$2y$13$LWp9rHkbu.T3tMSzJMx/geyssur3xQ8N/scQXMMYz03R6BIUgvlYy', 'xL9t4X_fDS5cWgU1NBOqgrM_8RJ4gdkq_spv', NULL),
(4, 'test', 'test user', 'blaquecry@gmail.com', 3, 1, 1, NULL, NULL, NULL, 1625344438, 1636477121, 1636622230, 'MJ8lZAefo2x_6WycakQYxyh4CDIqysre', '$2y$13$lILhFrqlrBqzEtXFtqr.1e4KLwombZJHe3P12skByKENmmswpmD5i', 'zwZvZ5x5-rLLs5oNOiYYA2cIK0LP4bZ8_test', NULL),
(6, 'wendy', 'Setiadi Ruswendy', 'Setiadi.uswendy@test.com', 1, 1, 2, NULL, NULL, NULL, 1626208286, 1633301085, 1633503689, 'OTeO3x2kCWL8sDzcH9J88B5l4bAKbe5-', '$2y$13$PSLpXHUTwyrU5H0voNXhxO/pntEgC6R3rK05notH8gmjquXFwSc3C', 'yk8pv2XcOQdsOOr_f3GU6OgocppY6cbn_wendy', NULL),
(7, 'suratno', 'Suratno Suratno', 'Suratno.suratno@test.com', 5, 1, 2, '', '', '', 1626208521, 1636354280, 1633329764, '8bYXFB5rVc6HwlYPRDHvOtNOgKyNAjPX', '$2y$13$SrJN4xPuEAQtJglzVahhwekJ1m06viO9LrpMhbKUO/uamBIowwsGG', '50e3EXVP5Z7d9J_uy_HpgvIZHbs362Ud_suratno', NULL),
(8, 'init2', 'init2 user', 'init@init.com', 4, 1, 2, NULL, NULL, NULL, 1633290050, 1633290050, 0, 'Ajoc645CwZcusfV7_V713osnZO3OTM2e', '$2y$13$wS8Ua8IJ5GLuH1danwDgZ.KqpEiERf3pOnYwl9hIK3uWI1xhnMbW2', 'Z_ox8pxj5LXG5taqfYIG1VVbY18RJ39H_init2', NULL),
(40, 'blaq', 'blaq', 'a@a.com', 4, 1, 2, NULL, NULL, NULL, 1636880221, 1636880222, 1637184598, 'K3KujDUYXrD4vr8h97vk-CJdHsap6bjN', '$2y$13$Jts4PecGbY7fS6Y4CYG0CeoZdZcjzmdOKY1FRdI1QjcJfsL0rq5p2', 'gjRjHv4pFCrclFm0lUtTUiE4rZ1UrtPV_blaq', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `userid_2` (`userid`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `initiator_id` (`initiator_id`),
  ADD KEY `assign_to` (`assign_to`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagnum` (`tagnum`),
  ADD KEY `area_id` (`area_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dept`
--
ALTER TABLE `dept`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=925;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1051;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `dept` (`id`);

--
-- Constraints for table `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `region_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `dept` (`id`);

--
-- Constraints for table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
