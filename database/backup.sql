-- --------------------------------------------------------
-- Host:                         103.101.225.81
-- Server version:               5.7.27-0ubuntu0.16.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table oketrip.additional
CREATE TABLE IF NOT EXISTS `additional` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.additional: ~0 rows (approximately)
/*!40000 ALTER TABLE `additional` DISABLE KEYS */;
REPLACE INTO `additional` (`id`, `name`, `note`, `image`, `price`, `created_by`, `updated_by`, `active`, `created_at`, `updated_at`) VALUES
	(1, 'FPG insurance', 'asuransi dari fpg', '/dist/img/additional/additional_FPG insurance.jpg', 2500000.00, 'adi', 'adi wielijarni', 'true', '2019-08-14 09:33:45', '2019-08-21 15:15:20');
/*!40000 ALTER TABLE `additional` ENABLE KEYS */;

-- Dumping structure for table oketrip.booking
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` int(11) NOT NULL,
  `telp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itinerary_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Waiting List','Confirm','Cancel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_adult` double(10,2) NOT NULL,
  `total_child` double(10,2) NOT NULL,
  `total_infant` double(10,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_additional` double(10,2) NOT NULL,
  `total_room` double(10,2) NOT NULL,
  `tax` double(10,2) NOT NULL,
  `visa` double(10,2) NOT NULL,
  `agent_com` double(10,2) NOT NULL,
  `tips` double(10,2) NOT NULL,
  `total` double(10,2) NOT NULL,
  `total_remain` double(10,2) NOT NULL,
  `handle_by` int(11) NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.booking: 0 rows
/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;

-- Dumping structure for table oketrip.booking_additional
CREATE TABLE IF NOT EXISTS `booking_additional` (
  `id` int(11) NOT NULL,
  `id_booking_d` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `additional_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`dt`,`id_booking_d`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.booking_additional: 0 rows
/*!40000 ALTER TABLE `booking_additional` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_additional` ENABLE KEYS */;

-- Dumping structure for table oketrip.booking_d
CREATE TABLE IF NOT EXISTS `booking_d` (
  `id` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `bed` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` int(11) NOT NULL,
  `passport` int(11) NOT NULL,
  `exp_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issuing` int(11) NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room` int(11) NOT NULL,
  `reference` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_person` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`dt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.booking_d: 0 rows
/*!40000 ALTER TABLE `booking_d` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_d` ENABLE KEYS */;

-- Dumping structure for table oketrip.company
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(11) NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.company: 1 rows
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
REPLACE INTO `company` (`id`, `name`, `address`, `phone`, `email`, `city_id`, `image`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'PT Jawa Abadi', 'JL. Manokwari 115', '0897897878', 'jawa.abadi@gmail.com', 3578, '/dist/img/company/leader_PT Jawa Abadi_1.jpg', 'true', 'adi wielijarni', 'adi wielijarni', '2019-09-03 11:03:03', '2019-09-03 11:03:06');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;

-- Dumping structure for table oketrip.destination
CREATE TABLE IF NOT EXISTS `destination` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.destination: ~4 rows (approximately)
/*!40000 ALTER TABLE `destination` DISABLE KEYS */;
REPLACE INTO `destination` (`id`, `name`, `note`, `image`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'Hongkong', 'Travel To Hongkong', NULL, '2019-08-14 09:30:16', 'adi', '2019-08-14 09:30:16', 'adi'),
	(2, 'China', 'Travel to china', NULL, '2019-08-14 09:30:32', 'adi', '2019-08-14 09:30:32', 'adi'),
	(3, 'Dubai', 'Travel to dubai', NULL, '2019-08-14 09:30:44', 'adi', '2019-08-14 09:30:44', 'adi'),
	(4, 'Japan', 'Travel to japan', NULL, '2019-08-14 09:31:00', 'adi', '2019-08-14 09:31:00', 'adi');
/*!40000 ALTER TABLE `destination` ENABLE KEYS */;

-- Dumping structure for table oketrip.group_menu
CREATE TABLE IF NOT EXISTS `group_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.group_menu: ~5 rows (approximately)
/*!40000 ALTER TABLE `group_menu` DISABLE KEYS */;
REPLACE INTO `group_menu` (`id`, `name`, `slug`, `icon`, `url`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Setting', 'setting', 'fas fa-cogs', '-', 'adi', 'adi', '2019-08-14 08:48:34', '2019-08-14 09:10:03'),
	(2, 'User', 'user', 'fas fa-user', '-', 'adi', 'adi', '2019-08-14 08:57:12', '2019-08-14 08:57:12'),
	(3, 'Sales', 'sales', 'fas fa-suitcase-rolling', '-', 'adi', 'adi', '2019-08-14 09:09:53', '2019-08-14 09:09:53'),
	(4, 'Finance', 'finance', 'fas fa-chart-line', '-', 'adi', 'adi', '2019-08-14 09:12:06', '2019-08-14 09:12:06'),
	(5, 'Report', 'report', 'fas fa-book', '-', 'adi', 'adi', '2019-08-14 09:12:53', '2019-08-14 09:12:53');
/*!40000 ALTER TABLE `group_menu` ENABLE KEYS */;

-- Dumping structure for table oketrip.itinerary
CREATE TABLE IF NOT EXISTS `itinerary` (
  `id` int(11) NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `highlight` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term_condition` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `flight_by` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carousel_1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carousel_2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `carousel_3` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_3` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flayer_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_by` int(11) DEFAULT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hot_deals` enum('Y','N') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `itinerary_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.itinerary: ~7 rows (approximately)
/*!40000 ALTER TABLE `itinerary` DISABLE KEYS */;
REPLACE INTO `itinerary` (`id`, `code`, `name`, `destination_id`, `highlight`, `term_condition`, `flight_by`, `additional_id`, `carousel_1`, `carousel_2`, `carousel_3`, `note_1`, `note_2`, `note_3`, `pdf`, `flayer_image`, `summary`, `book_by`, `active`, `hot_deals`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'TR19082100001', '4D HONGKONG, CHINA', '1,2', 'AIRASIA', '<p>AIRASIA</p>', 'AIRASIA', '1', 'dist/img/itinerary/carousel_1_1.jpg', 'dist/img/itinerary/carousel_2_1.jpg', 'dist/img/itinerary/carousel_3_1.jpg', 'AIRASIA', 'AIRASIA', 'AIRASIA', './dist/pdf/itinerary/pdf_1.pdf', 'dist/img/itinerary/flyer_1.jpg', '', NULL, NULL, NULL, 4, 4, '2019-08-21 14:37:01', '2019-08-21 14:37:01'),
	(2, 'TR19082100002', '2D HONGKONG,SURABAYA', '2,3', 'AIRASIA', '<p>AIRASIA</p>', 'AIRASIA', '1', 'dist/img/itinerary/carousel_1_2.jpg', 'dist/img/itinerary/carousel_2_2.jpg', 'dist/img/itinerary/carousel_3_2.jpg', 'AIRASIA', 'AIRASIA', 'AIRASIA', 'dist/pdf/itinerary/pdf_2.pdf', 'dist/img/itinerary/flyer_2.jpg', '', NULL, NULL, NULL, 4, 4, '2019-08-21 14:55:16', '2019-08-21 14:55:16'),
	(3, 'TR19082100003', '3D HONGKONG CHINA', '2,1', 'BLUE ASIA', '<p>BLUE ASIA</p>', 'BLUE ASIA', '1', 'dist/img/itinerary/carousel_1_3.jpg', 'dist/img/itinerary/carousel_2_3.jpg', 'dist/img/itinerary/carousel_3_3.jpg', 'BLUE ASIA', 'BLUE ASIA', 'BLUE ASIA', 'dist/pdf/itinerary/pdf_3.pdf', 'dist/img/itinerary/flyer_3.jpg', '', NULL, NULL, NULL, 4, 4, '2019-08-21 15:05:03', '2019-08-21 15:05:03'),
	(4, 'TR19082100004', '2D HONGKONG, CHINA', '1,2', 'itinerary', '<p>itinerary</p>', 'itinerary', '1', 'dist/img/itinerary/carousel_1_4.jpg', 'dist/img/itinerary/carousel_2_4.jpg', 'dist/img/itinerary/carousel_3_4.jpg', 'itinerary', 'itinerary', 'itinerary', 'dist/pdf/itinerary/pdf_4.pdf', 'dist/img/itinerary/flyer_4.jpg', '', NULL, NULL, NULL, 4, 4, '2019-08-21 15:07:40', '2019-08-21 15:07:40'),
	(5, 'TR19082100005', '1D HONGKONG', '1', 'AIRASIA', '<p>AIRASIA</p>', 'AIRASIA', '1', 'dist/img/itinerary/carousel_1_5.jpg', 'dist/img/itinerary/carousel_2_5.jpg', 'dist/img/itinerary/carousel_3_5.jpg', 'AIRASIA', 'AIRASIA', 'AIRASIA', 'dist/pdf/itinerary/pdf_5.pdf', 'dist/img/itinerary/flyer_5.jpg', '', NULL, NULL, 'Y', 4, 4, '2019-08-21 15:12:26', '2019-08-21 15:12:26'),
	(6, 'TR19082100006', '2D CHINA', '2', 'LION AIR', '<p>LION AIR</p>', 'LION AIR', '1', 'dist/img/itinerary/carousel_1_6.jpg', 'dist/img/itinerary/carousel_2_6.jpg', 'dist/img/itinerary/carousel_3_6.jpg', 'LION AIR', 'LION AIR', 'LION AIR', 'dist/pdf/itinerary/pdf_6.pdf', 'dist/img/itinerary/flyer_6.jpg', '', NULL, NULL, 'Y', 4, 4, '2019-08-21 15:15:04', '2019-08-21 15:15:04'),
	(7, 'TR19082300007', '4D HONGKONG FOR FUN FUN', '1', 'MAKE YOUR TRIP BECOME FUN', '<p>What are Terms and Conditions</p><p>Terms and Conditions agreements act as a legal contract between you (the company) who has the website or mobile app and the user who access your website and mobile app.</p><p>Having a Terms and Conditions agreement is completely optional. No laws require you to have one. Not even the super-strict and wide-reaching General Data Protection Regulation (<a href="https://termsfeed.com/blog/gdpr/" rel="noopener noreferrer nofollow">GDPR</a>).</p><p>It’s up to you to set the rules and guidelines that the user must agree to. You can think of your Terms and Conditions agreement as the legal agreement where you <strong>maintain your rights</strong> to exclude users from your app in the event that they abuse your app, where you maintain your legal rights against potential app abusers, and so on.</p><p>Terms and Conditions are also known as Terms of Service or Terms of Use.</p><p>You can use this agreement anywhere, regardless of what platform your business operates on:</p><ul><li><p>Websites</p></li><li><p>WordPress blogs or blogs on any kind of platform: Joomla!, Drupal etc.</p></li><li><p>E-commerce shops</p></li><li><p>Mobile apps: iOS, Android or Windows phone</p></li><li><p><a href="https://termsfeed.com/blog/facebook-terms-of-service-login-details-app-details/" rel="noopener noreferrer nofollow">Facebook apps</a></p></li><li><p>Desktop apps</p></li><li><p><a href="https://termsfeed.com/blog/terms-use-privacy-policy-saas-applications/" rel="noopener noreferrer nofollow">SaaS apps</a></p></li></ul><p>Desktop apps usually have an <a href="https://termsfeed.com/blog/eula-saas-apps/" rel="noopener noreferrer nofollow">EULA</a> (End-User License Agreement) instead of a Terms and Conditions agreement, but your business can use <em>both</em>. Mobile apps are increasingly using Terms and Conditions along with an EULA if the mobile app has an online service component, i.e. it connects with a server.</p>', 'AIRASIA', '1', 'dist/img/itinerary/carousel_1_7.jpg', 'dist/img/itinerary/carousel_2_7.jpg', 'dist/img/itinerary/carousel_3_7.jpg', 'BRIDGE OF SOUTH HONGKONG', 'BRIDGE OF NORTH HONGKONG', 'BRIDGE OF JAPAN HONGKONG', 'dist/pdf/itinerary/pdf_7.pdf', 'dist/img/itinerary/flyer_7.jpg', '', NULL, 'true', 'Y', 3, 3, '2019-08-23 09:42:16', '2019-09-03 10:55:12');
/*!40000 ALTER TABLE `itinerary` ENABLE KEYS */;

-- Dumping structure for table oketrip.itinerary_detail
CREATE TABLE IF NOT EXISTS `itinerary_detail` (
  `id` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat` int(11) NOT NULL,
  `seat_remain` int(11) NOT NULL,
  `booked_by` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `adult_price` double(10,2) NOT NULL,
  `child_price` double(10,2) NOT NULL,
  `child_bed_price` double(10,2) NOT NULL,
  `infant_price` double(10,2) NOT NULL,
  `minimal_dp` double(10,2) NOT NULL,
  `agent_com` double(10,2) NOT NULL,
  `agent_tip` double(10,2) NOT NULL,
  `agent_visa` double(10,2) NOT NULL,
  `agent_tax` double(10,2) NOT NULL,
  `tour_leader_tips` double(10,2) NOT NULL,
  `final_pdf` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term_pdf` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flayer_jpg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_leader_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.itinerary_detail: ~13 rows (approximately)
/*!40000 ALTER TABLE `itinerary_detail` DISABLE KEYS */;
REPLACE INTO `itinerary_detail` (`id`, `dt`, `code`, `seat`, `seat_remain`, `booked_by`, `start`, `end`, `adult_price`, `child_price`, `child_bed_price`, `infant_price`, `minimal_dp`, `agent_com`, `agent_tip`, `agent_visa`, `agent_tax`, `tour_leader_tips`, `final_pdf`, `term_pdf`, `flayer_jpg`, `tour_leader_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 1, 'TR19082100001/001', 15, 15, 0, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 14:37:01', '2019-08-21 14:37:01'),
	(1, 2, 'TR19082100001/002', 15, 15, 0, '2019-08-21', '2019-08-21', 1750000.00, 1750000.00, 1750000.00, 1750000.00, 75000.00, 75000.00, 75000.00, 75000.00, 75000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 14:37:01', '2019-08-21 14:37:01'),
	(2, 1, 'TR19082100002/001', 15, 15, 0, '2019-08-21', '2019-08-21', 5000000.00, 5000000.00, 5000000.00, 5000000.00, 500000.00, 1000000.00, 1000000.00, 1000000.00, 1000000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 14:55:16', '2019-08-21 14:55:16'),
	(2, 2, 'TR19082100002/002', 10, 10, 0, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 14:55:16', '2019-08-21 14:55:16'),
	(3, 1, 'TR19082100003/001', 15, 15, 0, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 12.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:05:03', '2019-08-21 15:05:03'),
	(3, 2, 'TR19082100003/002', 25, 25, 0, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:05:03', '2019-08-21 15:05:03'),
	(4, 1, 'TR19082100004/001', 15, 15, 0, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:07:40', '2019-08-21 15:07:40'),
	(4, 2, 'TR19082100004/002', 15, 15, 0, '2019-08-21', '2019-08-21', 1250000.00, 1250000.00, 1250000.00, 1250000.00, 2500000.00, 250000.00, 250000.00, 50000.00, 250000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:07:40', '2019-08-21 15:07:40'),
	(5, 1, 'TR19082100005/001', 15, 15, 0, '2019-08-21', '2019-08-21', 1500000.00, 1500000.00, 1500000.00, 1500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:12:26', '2019-08-21 15:12:26'),
	(6, 1, 'TR19082100006/001', 15, 15, 0, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:15:04', '2019-08-21 15:15:04'),
	(6, 2, 'TR19082100006/002', 15, 15, 0, '2019-08-21', '2019-08-23', 5800000.00, 5800000.00, 5800000.00, 5800000.00, 80000.00, 80000.00, 80000.00, 80000.00, 80000.00, 0.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:15:04', '2019-08-21 15:15:04'),
	(7, 1, 'TR19082300007/001', 20, 20, 0, '2019-08-23', '2019-08-23', 3000000.00, 3000000.00, 3000000.00, 3000000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 0.00, NULL, NULL, NULL, NULL, 3, 3, '2019-09-03 10:50:25', '2019-09-03 10:50:25'),
	(7, 2, 'TR19082300007/002', 20, 20, 5, '2019-08-23', '2019-08-23', 3000000.00, 3000000.00, 3000000.00, 1500000.00, 350000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 'dist/pdf/itinerary_detail/final_confirmation_7_2.pdf', 'dist/pdf/itinerary_detail/tata_tertib_7_2.pdf', 'dist/pdf/itinerary_detail/flayer_7_2.jpg', 1, 3, 3, '2019-09-03 10:50:25', '2019-09-03 11:08:56');
/*!40000 ALTER TABLE `itinerary_detail` ENABLE KEYS */;

-- Dumping structure for table oketrip.itinerary_flight
CREATE TABLE IF NOT EXISTS `itinerary_flight` (
  `id` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `flight_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure_airport_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arrival_airport_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arrival` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.itinerary_flight: ~16 rows (approximately)
/*!40000 ALTER TABLE `itinerary_flight` DISABLE KEYS */;
REPLACE INTO `itinerary_flight` (`id`, `dt`, `flight_number`, `departure_airport_code`, `arrival_airport_code`, `departure`, `arrival`) VALUES
	(1, 1, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(1, 2, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(2, 1, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(2, 2, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(2, 3, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(3, 1, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(3, 2, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(4, 1, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(4, 2, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(5, 1, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(6, 1, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(6, 2, 'CX790', 'SUB', 'HKG', '08:30 WIB', '08:30 WIB'),
	(7, 1, 'CX869', 'SUB', 'JKT', '07:00 WIB', '09:30 WIB'),
	(7, 2, 'CY890', 'JKT', 'HKG', '11:00 WIB', '18:00 WIB'),
	(7, 3, 'CZ980', 'HKG', 'JKT', '23:00 WIB', '04:00 WIB'),
	(7, 4, 'CX790', 'JKT', 'SUB', '05:00 WIB', '07:00 WIB');
/*!40000 ALTER TABLE `itinerary_flight` ENABLE KEYS */;

-- Dumping structure for table oketrip.itinerary_schedule
CREATE TABLE IF NOT EXISTS `itinerary_schedule` (
  `id` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `caption` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `eat_service` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.itinerary_schedule: ~17 rows (approximately)
/*!40000 ALTER TABLE `itinerary_schedule` DISABLE KEYS */;
REPLACE INTO `itinerary_schedule` (`id`, `dt`, `caption`, `title`, `eat_service`) VALUES
	(1, 1, 'AIRASIA', 'AIRASIA', 'AIRASIA'),
	(1, 2, 'AIRASIA', 'AIRASIA', 'AIRASIA'),
	(2, 1, 'AIRASIA', 'AIRASIA', 'AIRASIA'),
	(2, 2, 'AIRASIA', 'AIRASIA', 'AIRASIA'),
	(3, 1, 'BLUE ASIA', 'BLUE ASIA', 'BLUE ASIA'),
	(3, 2, 'BLUE ASIA', 'BLUE ASIA', 'BLUE ASIA'),
	(3, 3, 'BLUE ASIA', 'BLUE ASIA', 'BLUE ASIA'),
	(4, 1, 'itinerary', 'itinerary', 'itinerary'),
	(4, 2, 'itinerary', 'itinerary', 'itinerary'),
	(4, 3, 'itinerary', 'itinerary', 'itinerary'),
	(5, 1, 'AIRASIA', 'AIRASIA', 'AIRASIA'),
	(6, 1, 'LION AIR', 'LION AIR', 'LION AIR'),
	(6, 2, 'LION AIR', 'LION AIR', 'LION AIR'),
	(7, 1, 'Berkumpul di bandara juanda pukul 07:00 WIB. Sampai dijakarta pukul 09:30 WIB menunggu keberangkatan ke hongkong pada jam 11:00 WIB. Lalu tiba di hongkong jam 18:00 WIB dan dilanjut istirahat di hotel', 'Check Out Ke Hongkong', 'B/L/D'),
	(7, 2, 'Berkumpul di lobby jam 08:00 WIB untuk bersiap pergi ke disney land hongkong. sampai ke disney land sekitar pukul jam 12:00 WIB. Keluar dari Disney Land Pukul 18:00 WIB langsung menuju hotel untuk istirahat.', 'Ke tempat rekreasi dan spot foto di hongkong', 'B/L/D'),
	(7, 3, 'Berkumpul lobby jam 08:00 WIB dan bersiap siap ke pusat perbelanjaan di hongkong. sampai kesana jam 12:00 WIB berbelanja sampai pukul 17:00 WIB dan kembali ke hotel untuk bersiap check out.  lalu keluar dari hotel pukul 20:00 WIB menuju bandara.', 'Ke tempat perbelanjaan untuk oleh oleh', 'B/L/D'),
	(7, 4, 'sampai bandara pukul 22:00 WIB berangkat ke jakarta pukul 23:00 WIB lalu sampai ke jakarta pukul 04:00 WIB. Ke surabaya pukul 05:00 WIB dan sampai ke bandara juanda jam 07:00 WIB', 'Pulang ke indonesia', 'B');
/*!40000 ALTER TABLE `itinerary_schedule` ENABLE KEYS */;

-- Dumping structure for table oketrip.menu_list
CREATE TABLE IF NOT EXISTS `menu_list` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_menu_id` bigint(20) unsigned NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `menu_list_group_menu_id_foreign` (`group_menu_id`),
  CONSTRAINT `menu_list_group_menu_id_foreign` FOREIGN KEY (`group_menu_id`) REFERENCES `group_menu` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.menu_list: ~18 rows (approximately)
/*!40000 ALTER TABLE `menu_list` DISABLE KEYS */;
REPLACE INTO `menu_list` (`id`, `name`, `icon`, `slug`, `group_menu_id`, `url`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Group Menu', '-', 'group-menu', 1, 'group-menu', 'adi', 'adi', '2019-08-14 08:53:06', '2019-08-14 08:53:06'),
	(2, 'Privilege', '-', 'privilege', 1, 'privilege', 'adi', 'adi', '2019-08-14 08:53:31', '2019-08-14 08:53:31'),
	(3, 'Role', '-', 'role', 1, 'role', 'adi', 'adi', '2019-08-14 08:53:44', '2019-08-14 08:53:44'),
	(4, 'Menu List', '-', 'menu-list', 1, 'menu-list', 'adi', 'adi', '2019-08-14 08:54:06', '2019-08-14 08:54:06'),
	(5, 'Administrator User', '-', 'administrator-user', 2, 'administrator-user', 'adi', 'adi', '2019-08-14 08:59:05', '2019-08-14 09:00:25'),
	(6, 'Agent User', '-', 'agent-user', 2, 'agent-user', 'adi', 'adi', '2019-08-14 09:01:26', '2019-08-14 09:01:26'),
	(7, 'Destination', '-', 'destination', 3, 'destination', 'adi', 'adi', '2019-08-14 09:13:35', '2019-08-14 09:13:35'),
	(8, 'Additional', '-', 'additional', 3, 'additional', 'adi', 'adi', '2019-08-14 09:13:57', '2019-08-14 09:13:57'),
	(9, 'Itinerary', '-', 'itinerary', 3, 'itinerary', 'adi', 'adi', '2019-08-14 09:14:18', '2019-08-14 09:14:18'),
	(10, 'Tour Leader', '-', 'tour-leader', 3, 'tour-leader', 'adi', 'adi', '2019-08-14 09:14:51', '2019-08-14 09:14:51'),
	(11, 'Income Report', '-', 'income-report', 4, 'income-report', 'adi', 'adi', '2019-08-14 09:15:53', '2019-08-14 09:15:53'),
	(12, 'Income Statement', '-', 'income-statement', 4, 'income-statement', 'adi', 'adi', '2019-08-14 09:16:17', '2019-08-14 09:16:17'),
	(13, 'Customer Statistic', '-', 'customer-statistic', 5, 'customer-statistic', 'adi', 'adi', '2019-08-14 09:16:55', '2019-08-14 09:16:55'),
	(14, 'Sales Statistic', '-', 'sales-statistic', 5, 'sales-statistic', 'adi', 'adi', '2019-08-14 09:17:16', '2019-08-14 09:17:16'),
	(15, 'Customer Report', '-', 'customer-report', 5, 'customer-report', 'adi', 'adi', '2019-08-14 09:17:36', '2019-08-14 09:17:36'),
	(16, 'Sales Report', '-', 'sales-report', 5, 'sales-report', 'adi', 'adi', '2019-08-14 09:17:50', '2019-08-14 09:17:50'),
	(17, 'Payment Report', '-', 'payment-report', 5, 'payment-report', 'adi', 'adi', '2019-08-14 09:18:13', '2019-08-14 09:18:13'),
	(18, 'Company', '-', 'company', 2, 'company', 'adi wielijarni', 'adi wielijarni', '2019-09-03 10:58:06', '2019-09-03 10:58:06');
/*!40000 ALTER TABLE `menu_list` ENABLE KEYS */;

-- Dumping structure for table oketrip.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.migrations: ~23 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_06_17_062616_create_destination_table', 1),
	(4, '2019_06_17_065225_add_created_by_to_destination_table', 1),
	(5, '2019_06_23_075752_add_api_token_to_users_table', 1),
	(6, '2019_06_23_081338_token_management', 1),
	(7, '2019_06_25_084157_add_note_to_destination_table', 1),
	(8, '2019_06_25_210454_create_group_menu_table', 1),
	(9, '2019_06_25_210508_create_menu_list_table', 1),
	(10, '2019_06_25_210539_create_privilege_table', 1),
	(11, '2019_06_25_210547_create_role_table', 1),
	(12, '2019_06_28_182241_sessions', 1),
	(13, '2019_07_12_201606_additional', 1),
	(14, '2019_07_21_103414_itinerary', 1),
	(15, '2019_08_02_194644_itinerary_detail', 1),
	(16, '2019_08_02_194728_itinerary_schedule', 1),
	(17, '2019_08_02_194824_itinerary_flight', 1),
	(18, '2019_08_23_143624_tour_leader', 2),
	(19, '2019_08_27_193654_booking', 3),
	(20, '2019_08_27_194852_booking_d', 3),
	(21, '2019_08_27_194910_booking_additional', 3),
	(22, '2019_09_01_103417_company', 3),
	(23, '2019_09_01_104600_regencies', 3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table oketrip.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table oketrip.privilege
CREATE TABLE IF NOT EXISTS `privilege` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_list_id` int(11) NOT NULL,
  `menu_list_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.privilege: ~54 rows (approximately)
/*!40000 ALTER TABLE `privilege` DISABLE KEYS */;
REPLACE INTO `privilege` (`id`, `role_id`, `role_name`, `menu_list_id`, `menu_list_name`, `view`, `create`, `edit`, `delete`, `validation`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Administrator', 1, 'Group Menu', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 08:53:06', '2019-08-14 09:29:37'),
	(2, 1, 'Administrator', 2, 'Privilege', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 08:53:31', '2019-08-14 09:29:37'),
	(3, 1, 'Administrator', 3, 'Role', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 08:53:44', '2019-08-14 09:29:37'),
	(4, 1, 'Administrator', 4, 'Menu List', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 08:54:06', '2019-08-14 09:29:37'),
	(5, 1, 'Administrator', 5, 'Administrator User', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 08:59:05', '2019-08-14 09:29:37'),
	(6, 1, 'Administrator', 6, 'Agent User', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:01:26', '2019-08-14 09:29:37'),
	(7, 1, 'Administrator', 7, 'Destination', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:13:35', '2019-08-14 09:29:37'),
	(8, 1, 'Administrator', 8, 'Additional', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:13:57', '2019-08-14 09:29:37'),
	(9, 1, 'Administrator', 9, 'Itinerary', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:14:18', '2019-08-14 09:29:37'),
	(10, 1, 'Administrator', 10, 'Tour Leader', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:14:51', '2019-08-14 09:29:37'),
	(11, 1, 'Administrator', 11, 'Income Report', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:15:53', '2019-08-14 09:29:37'),
	(12, 1, 'Administrator', 12, 'Income Statement', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:16:17', '2019-08-14 09:29:37'),
	(13, 1, 'Administrator', 13, 'Customer Statistic', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:16:55', '2019-08-14 09:29:37'),
	(14, 1, 'Administrator', 14, 'Sales Statistic', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:17:16', '2019-08-14 09:29:37'),
	(15, 1, 'Administrator', 15, 'Customer Report', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:17:36', '2019-08-14 09:29:37'),
	(16, 1, 'Administrator', 16, 'Sales Report', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:17:50', '2019-08-14 09:29:37'),
	(17, 1, 'Administrator', 17, 'Payment Report', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-08-14 09:18:13', '2019-08-14 09:29:37'),
	(18, 2, 'Master Agent', 1, 'Group Menu', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(19, 2, 'Master Agent', 2, 'Privilege', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(20, 2, 'Master Agent', 3, 'Role', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(21, 2, 'Master Agent', 4, 'Menu List', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(22, 2, 'Master Agent', 5, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(23, 2, 'Master Agent', 6, 'Agent User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(24, 2, 'Master Agent', 7, 'Destination', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(25, 2, 'Master Agent', 8, 'Additional', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(26, 2, 'Master Agent', 9, 'Itinerary', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(27, 2, 'Master Agent', 10, 'Tour Leader', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(28, 2, 'Master Agent', 11, 'Income Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(29, 2, 'Master Agent', 12, 'Income Statement', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(30, 2, 'Master Agent', 13, 'Customer Statistic', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(31, 2, 'Master Agent', 14, 'Sales Statistic', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(32, 2, 'Master Agent', 15, 'Customer Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(33, 2, 'Master Agent', 16, 'Sales Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(34, 2, 'Master Agent', 17, 'Payment Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(35, 3, 'agent', 1, 'Group Menu', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(36, 3, 'agent', 2, 'Privilege', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(37, 3, 'agent', 3, 'Role', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(38, 3, 'agent', 4, 'Menu List', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(39, 3, 'agent', 5, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(40, 3, 'agent', 6, 'Agent User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(41, 3, 'agent', 7, 'Destination', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(42, 3, 'agent', 8, 'Additional', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(43, 3, 'agent', 9, 'Itinerary', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(44, 3, 'agent', 10, 'Tour Leader', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(45, 3, 'agent', 11, 'Income Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(46, 3, 'agent', 12, 'Income Statement', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(47, 3, 'agent', 13, 'Customer Statistic', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(48, 3, 'agent', 14, 'Sales Statistic', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(49, 3, 'agent', 15, 'Customer Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(50, 3, 'agent', 16, 'Sales Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(51, 3, 'agent', 17, 'Payment Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03'),
	(52, 1, 'Administrator', 18, 'Company', 'true', 'true', 'true', 'true', 'true', 'adi wielijarni', 'adi wielijarni', '2019-09-03 10:58:06', '2019-09-03 10:58:06'),
	(53, 2, 'Master Agent', 18, 'Company', 'false', 'false', 'false', 'false', 'false', 'adi wielijarni', 'adi wielijarni', '2019-09-03 10:58:06', '2019-09-03 10:58:06'),
	(54, 3, 'Agent', 18, 'Company', 'false', 'false', 'false', 'false', 'false', 'adi wielijarni', 'adi wielijarni', '2019-09-03 10:58:06', '2019-09-03 10:58:06');
/*!40000 ALTER TABLE `privilege` ENABLE KEYS */;

-- Dumping structure for table oketrip.regencies
CREATE TABLE IF NOT EXISTS `regencies` (
  `id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.regencies: 514 rows
/*!40000 ALTER TABLE `regencies` DISABLE KEYS */;
REPLACE INTO `regencies` (`id`, `province_id`, `name`) VALUES
	(1101, 11, 'KABUPATEN SIMEULUE'),
	(1102, 11, 'KABUPATEN ACEH SINGKIL'),
	(1103, 11, 'KABUPATEN ACEH SELATAN'),
	(1104, 11, 'KABUPATEN ACEH TENGGARA'),
	(1105, 11, 'KABUPATEN ACEH TIMUR'),
	(1106, 11, 'KABUPATEN ACEH TENGAH'),
	(1107, 11, 'KABUPATEN ACEH BARAT'),
	(1108, 11, 'KABUPATEN ACEH BESAR'),
	(1109, 11, 'KABUPATEN PIDIE'),
	(1110, 11, 'KABUPATEN BIREUEN'),
	(1111, 11, 'KABUPATEN ACEH UTARA'),
	(1112, 11, 'KABUPATEN ACEH BARAT DAYA'),
	(1113, 11, 'KABUPATEN GAYO LUES'),
	(1114, 11, 'KABUPATEN ACEH TAMIANG'),
	(1115, 11, 'KABUPATEN NAGAN RAYA'),
	(1116, 11, 'KABUPATEN ACEH JAYA'),
	(1117, 11, 'KABUPATEN BENER MERIAH'),
	(1118, 11, 'KABUPATEN PIDIE JAYA'),
	(1171, 11, 'KOTA BANDA ACEH'),
	(1172, 11, 'KOTA SABANG'),
	(1173, 11, 'KOTA LANGSA'),
	(1174, 11, 'KOTA LHOKSEUMAWE'),
	(1175, 11, 'KOTA SUBULUSSALAM'),
	(1201, 12, 'KABUPATEN NIAS'),
	(1202, 12, 'KABUPATEN MANDAILING NATAL'),
	(1203, 12, 'KABUPATEN TAPANULI SELATAN'),
	(1204, 12, 'KABUPATEN TAPANULI TENGAH'),
	(1205, 12, 'KABUPATEN TAPANULI UTARA'),
	(1206, 12, 'KABUPATEN TOBA SAMOSIR'),
	(1207, 12, 'KABUPATEN LABUHAN BATU'),
	(1208, 12, 'KABUPATEN ASAHAN'),
	(1209, 12, 'KABUPATEN SIMALUNGUN'),
	(1210, 12, 'KABUPATEN DAIRI'),
	(1211, 12, 'KABUPATEN KARO'),
	(1212, 12, 'KABUPATEN DELI SERDANG'),
	(1213, 12, 'KABUPATEN LANGKAT'),
	(1214, 12, 'KABUPATEN NIAS SELATAN'),
	(1215, 12, 'KABUPATEN HUMBANG HASUNDUTAN'),
	(1216, 12, 'KABUPATEN PAKPAK BHARAT'),
	(1217, 12, 'KABUPATEN SAMOSIR'),
	(1218, 12, 'KABUPATEN SERDANG BEDAGAI'),
	(1219, 12, 'KABUPATEN BATU BARA'),
	(1220, 12, 'KABUPATEN PADANG LAWAS UTARA'),
	(1221, 12, 'KABUPATEN PADANG LAWAS'),
	(1222, 12, 'KABUPATEN LABUHAN BATU SELATAN'),
	(1223, 12, 'KABUPATEN LABUHAN BATU UTARA'),
	(1224, 12, 'KABUPATEN NIAS UTARA'),
	(1225, 12, 'KABUPATEN NIAS BARAT'),
	(1271, 12, 'KOTA SIBOLGA'),
	(1272, 12, 'KOTA TANJUNG BALAI'),
	(1273, 12, 'KOTA PEMATANG SIANTAR'),
	(1274, 12, 'KOTA TEBING TINGGI'),
	(1275, 12, 'KOTA MEDAN'),
	(1276, 12, 'KOTA BINJAI'),
	(1277, 12, 'KOTA PADANGSIDIMPUAN'),
	(1278, 12, 'KOTA GUNUNGSITOLI'),
	(1301, 13, 'KABUPATEN KEPULAUAN MENTAWAI'),
	(1302, 13, 'KABUPATEN PESISIR SELATAN'),
	(1303, 13, 'KABUPATEN SOLOK'),
	(1304, 13, 'KABUPATEN SIJUNJUNG'),
	(1305, 13, 'KABUPATEN TANAH DATAR'),
	(1306, 13, 'KABUPATEN PADANG PARIAMAN'),
	(1307, 13, 'KABUPATEN AGAM'),
	(1308, 13, 'KABUPATEN LIMA PULUH KOTA'),
	(1309, 13, 'KABUPATEN PASAMAN'),
	(1310, 13, 'KABUPATEN SOLOK SELATAN'),
	(1311, 13, 'KABUPATEN DHARMASRAYA'),
	(1312, 13, 'KABUPATEN PASAMAN BARAT'),
	(1371, 13, 'KOTA PADANG'),
	(1372, 13, 'KOTA SOLOK'),
	(1373, 13, 'KOTA SAWAH LUNTO'),
	(1374, 13, 'KOTA PADANG PANJANG'),
	(1375, 13, 'KOTA BUKITTINGGI'),
	(1376, 13, 'KOTA PAYAKUMBUH'),
	(1377, 13, 'KOTA PARIAMAN'),
	(1401, 14, 'KABUPATEN KUANTAN SINGINGI'),
	(1402, 14, 'KABUPATEN INDRAGIRI HULU'),
	(1403, 14, 'KABUPATEN INDRAGIRI HILIR'),
	(1404, 14, 'KABUPATEN PELALAWAN'),
	(1405, 14, 'KABUPATEN S I A K'),
	(1406, 14, 'KABUPATEN KAMPAR'),
	(1407, 14, 'KABUPATEN ROKAN HULU'),
	(1408, 14, 'KABUPATEN BENGKALIS'),
	(1409, 14, 'KABUPATEN ROKAN HILIR'),
	(1410, 14, 'KABUPATEN KEPULAUAN MERANTI'),
	(1471, 14, 'KOTA PEKANBARU'),
	(1473, 14, 'KOTA D U M A I'),
	(1501, 15, 'KABUPATEN KERINCI'),
	(1502, 15, 'KABUPATEN MERANGIN'),
	(1503, 15, 'KABUPATEN SAROLANGUN'),
	(1504, 15, 'KABUPATEN BATANG HARI'),
	(1505, 15, 'KABUPATEN MUARO JAMBI'),
	(1506, 15, 'KABUPATEN TANJUNG JABUNG TIMUR'),
	(1507, 15, 'KABUPATEN TANJUNG JABUNG BARAT'),
	(1508, 15, 'KABUPATEN TEBO'),
	(1509, 15, 'KABUPATEN BUNGO'),
	(1571, 15, 'KOTA JAMBI'),
	(1572, 15, 'KOTA SUNGAI PENUH'),
	(1601, 16, 'KABUPATEN OGAN KOMERING ULU'),
	(1602, 16, 'KABUPATEN OGAN KOMERING ILIR'),
	(1603, 16, 'KABUPATEN MUARA ENIM'),
	(1604, 16, 'KABUPATEN LAHAT'),
	(1605, 16, 'KABUPATEN MUSI RAWAS'),
	(1606, 16, 'KABUPATEN MUSI BANYUASIN'),
	(1607, 16, 'KABUPATEN BANYU ASIN'),
	(1608, 16, 'KABUPATEN OGAN KOMERING ULU SELATAN'),
	(1609, 16, 'KABUPATEN OGAN KOMERING ULU TIMUR'),
	(1610, 16, 'KABUPATEN OGAN ILIR'),
	(1611, 16, 'KABUPATEN EMPAT LAWANG'),
	(1612, 16, 'KABUPATEN PENUKAL ABAB LEMATANG ILIR'),
	(1613, 16, 'KABUPATEN MUSI RAWAS UTARA'),
	(1671, 16, 'KOTA PALEMBANG'),
	(1672, 16, 'KOTA PRABUMULIH'),
	(1673, 16, 'KOTA PAGAR ALAM'),
	(1674, 16, 'KOTA LUBUKLINGGAU'),
	(1701, 17, 'KABUPATEN BENGKULU SELATAN'),
	(1702, 17, 'KABUPATEN REJANG LEBONG'),
	(1703, 17, 'KABUPATEN BENGKULU UTARA'),
	(1704, 17, 'KABUPATEN KAUR'),
	(1705, 17, 'KABUPATEN SELUMA'),
	(1706, 17, 'KABUPATEN MUKOMUKO'),
	(1707, 17, 'KABUPATEN LEBONG'),
	(1708, 17, 'KABUPATEN KEPAHIANG'),
	(1709, 17, 'KABUPATEN BENGKULU TENGAH'),
	(1771, 17, 'KOTA BENGKULU'),
	(1801, 18, 'KABUPATEN LAMPUNG BARAT'),
	(1802, 18, 'KABUPATEN TANGGAMUS'),
	(1803, 18, 'KABUPATEN LAMPUNG SELATAN'),
	(1804, 18, 'KABUPATEN LAMPUNG TIMUR'),
	(1805, 18, 'KABUPATEN LAMPUNG TENGAH'),
	(1806, 18, 'KABUPATEN LAMPUNG UTARA'),
	(1807, 18, 'KABUPATEN WAY KANAN'),
	(1808, 18, 'KABUPATEN TULANGBAWANG'),
	(1809, 18, 'KABUPATEN PESAWARAN'),
	(1810, 18, 'KABUPATEN PRINGSEWU'),
	(1811, 18, 'KABUPATEN MESUJI'),
	(1812, 18, 'KABUPATEN TULANG BAWANG BARAT'),
	(1813, 18, 'KABUPATEN PESISIR BARAT'),
	(1871, 18, 'KOTA BANDAR LAMPUNG'),
	(1872, 18, 'KOTA METRO'),
	(1901, 19, 'KABUPATEN BANGKA'),
	(1902, 19, 'KABUPATEN BELITUNG'),
	(1903, 19, 'KABUPATEN BANGKA BARAT'),
	(1904, 19, 'KABUPATEN BANGKA TENGAH'),
	(1905, 19, 'KABUPATEN BANGKA SELATAN'),
	(1906, 19, 'KABUPATEN BELITUNG TIMUR'),
	(1971, 19, 'KOTA PANGKAL PINANG'),
	(2101, 21, 'KABUPATEN KARIMUN'),
	(2102, 21, 'KABUPATEN BINTAN'),
	(2103, 21, 'KABUPATEN NATUNA'),
	(2104, 21, 'KABUPATEN LINGGA'),
	(2105, 21, 'KABUPATEN KEPULAUAN ANAMBAS'),
	(2171, 21, 'KOTA B A T A M'),
	(2172, 21, 'KOTA TANJUNG PINANG'),
	(3101, 31, 'KABUPATEN KEPULAUAN SERIBU'),
	(3171, 31, 'KOTA JAKARTA SELATAN'),
	(3172, 31, 'KOTA JAKARTA TIMUR'),
	(3173, 31, 'KOTA JAKARTA PUSAT'),
	(3174, 31, 'KOTA JAKARTA BARAT'),
	(3175, 31, 'KOTA JAKARTA UTARA'),
	(3201, 32, 'KABUPATEN BOGOR'),
	(3202, 32, 'KABUPATEN SUKABUMI'),
	(3203, 32, 'KABUPATEN CIANJUR'),
	(3204, 32, 'KABUPATEN BANDUNG'),
	(3205, 32, 'KABUPATEN GARUT'),
	(3206, 32, 'KABUPATEN TASIKMALAYA'),
	(3207, 32, 'KABUPATEN CIAMIS'),
	(3208, 32, 'KABUPATEN KUNINGAN'),
	(3209, 32, 'KABUPATEN CIREBON'),
	(3210, 32, 'KABUPATEN MAJALENGKA'),
	(3211, 32, 'KABUPATEN SUMEDANG'),
	(3212, 32, 'KABUPATEN INDRAMAYU'),
	(3213, 32, 'KABUPATEN SUBANG'),
	(3214, 32, 'KABUPATEN PURWAKARTA'),
	(3215, 32, 'KABUPATEN KARAWANG'),
	(3216, 32, 'KABUPATEN BEKASI'),
	(3217, 32, 'KABUPATEN BANDUNG BARAT'),
	(3218, 32, 'KABUPATEN PANGANDARAN'),
	(3271, 32, 'KOTA BOGOR'),
	(3272, 32, 'KOTA SUKABUMI'),
	(3273, 32, 'KOTA BANDUNG'),
	(3274, 32, 'KOTA CIREBON'),
	(3275, 32, 'KOTA BEKASI'),
	(3276, 32, 'KOTA DEPOK'),
	(3277, 32, 'KOTA CIMAHI'),
	(3278, 32, 'KOTA TASIKMALAYA'),
	(3279, 32, 'KOTA BANJAR'),
	(3301, 33, 'KABUPATEN CILACAP'),
	(3302, 33, 'KABUPATEN BANYUMAS'),
	(3303, 33, 'KABUPATEN PURBALINGGA'),
	(3304, 33, 'KABUPATEN BANJARNEGARA'),
	(3305, 33, 'KABUPATEN KEBUMEN'),
	(3306, 33, 'KABUPATEN PURWOREJO'),
	(3307, 33, 'KABUPATEN WONOSOBO'),
	(3308, 33, 'KABUPATEN MAGELANG'),
	(3309, 33, 'KABUPATEN BOYOLALI'),
	(3310, 33, 'KABUPATEN KLATEN'),
	(3311, 33, 'KABUPATEN SUKOHARJO'),
	(3312, 33, 'KABUPATEN WONOGIRI'),
	(3313, 33, 'KABUPATEN KARANGANYAR'),
	(3314, 33, 'KABUPATEN SRAGEN'),
	(3315, 33, 'KABUPATEN GROBOGAN'),
	(3316, 33, 'KABUPATEN BLORA'),
	(3317, 33, 'KABUPATEN REMBANG'),
	(3318, 33, 'KABUPATEN PATI'),
	(3319, 33, 'KABUPATEN KUDUS'),
	(3320, 33, 'KABUPATEN JEPARA'),
	(3321, 33, 'KABUPATEN DEMAK'),
	(3322, 33, 'KABUPATEN SEMARANG'),
	(3323, 33, 'KABUPATEN TEMANGGUNG'),
	(3324, 33, 'KABUPATEN KENDAL'),
	(3325, 33, 'KABUPATEN BATANG'),
	(3326, 33, 'KABUPATEN PEKALONGAN'),
	(3327, 33, 'KABUPATEN PEMALANG'),
	(3328, 33, 'KABUPATEN TEGAL'),
	(3329, 33, 'KABUPATEN BREBES'),
	(3371, 33, 'KOTA MAGELANG'),
	(3372, 33, 'KOTA SURAKARTA'),
	(3373, 33, 'KOTA SALATIGA'),
	(3374, 33, 'KOTA SEMARANG'),
	(3375, 33, 'KOTA PEKALONGAN'),
	(3376, 33, 'KOTA TEGAL'),
	(3401, 34, 'KABUPATEN KULON PROGO'),
	(3402, 34, 'KABUPATEN BANTUL'),
	(3403, 34, 'KABUPATEN GUNUNG KIDUL'),
	(3404, 34, 'KABUPATEN SLEMAN'),
	(3471, 34, 'KOTA YOGYAKARTA'),
	(3501, 35, 'KABUPATEN PACITAN'),
	(3502, 35, 'KABUPATEN PONOROGO'),
	(3503, 35, 'KABUPATEN TRENGGALEK'),
	(3504, 35, 'KABUPATEN TULUNGAGUNG'),
	(3505, 35, 'KABUPATEN BLITAR'),
	(3506, 35, 'KABUPATEN KEDIRI'),
	(3507, 35, 'KABUPATEN MALANG'),
	(3508, 35, 'KABUPATEN LUMAJANG'),
	(3509, 35, 'KABUPATEN JEMBER'),
	(3510, 35, 'KABUPATEN BANYUWANGI'),
	(3511, 35, 'KABUPATEN BONDOWOSO'),
	(3512, 35, 'KABUPATEN SITUBONDO'),
	(3513, 35, 'KABUPATEN PROBOLINGGO'),
	(3514, 35, 'KABUPATEN PASURUAN'),
	(3515, 35, 'KABUPATEN SIDOARJO'),
	(3516, 35, 'KABUPATEN MOJOKERTO'),
	(3517, 35, 'KABUPATEN JOMBANG'),
	(3518, 35, 'KABUPATEN NGANJUK'),
	(3519, 35, 'KABUPATEN MADIUN'),
	(3520, 35, 'KABUPATEN MAGETAN'),
	(3521, 35, 'KABUPATEN NGAWI'),
	(3522, 35, 'KABUPATEN BOJONEGORO'),
	(3523, 35, 'KABUPATEN TUBAN'),
	(3524, 35, 'KABUPATEN LAMONGAN'),
	(3525, 35, 'KABUPATEN GRESIK'),
	(3526, 35, 'KABUPATEN BANGKALAN'),
	(3527, 35, 'KABUPATEN SAMPANG'),
	(3528, 35, 'KABUPATEN PAMEKASAN'),
	(3529, 35, 'KABUPATEN SUMENEP'),
	(3571, 35, 'KOTA KEDIRI'),
	(3572, 35, 'KOTA BLITAR'),
	(3573, 35, 'KOTA MALANG'),
	(3574, 35, 'KOTA PROBOLINGGO'),
	(3575, 35, 'KOTA PASURUAN'),
	(3576, 35, 'KOTA MOJOKERTO'),
	(3577, 35, 'KOTA MADIUN'),
	(3578, 35, 'KOTA SURABAYA'),
	(3579, 35, 'KOTA BATU'),
	(3601, 36, 'KABUPATEN PANDEGLANG'),
	(3602, 36, 'KABUPATEN LEBAK'),
	(3603, 36, 'KABUPATEN TANGERANG'),
	(3604, 36, 'KABUPATEN SERANG'),
	(3671, 36, 'KOTA TANGERANG'),
	(3672, 36, 'KOTA CILEGON'),
	(3673, 36, 'KOTA SERANG'),
	(3674, 36, 'KOTA TANGERANG SELATAN'),
	(5101, 51, 'KABUPATEN JEMBRANA'),
	(5102, 51, 'KABUPATEN TABANAN'),
	(5103, 51, 'KABUPATEN BADUNG'),
	(5104, 51, 'KABUPATEN GIANYAR'),
	(5105, 51, 'KABUPATEN KLUNGKUNG'),
	(5106, 51, 'KABUPATEN BANGLI'),
	(5107, 51, 'KABUPATEN KARANG ASEM'),
	(5108, 51, 'KABUPATEN BULELENG'),
	(5171, 51, 'KOTA DENPASAR'),
	(5201, 52, 'KABUPATEN LOMBOK BARAT'),
	(5202, 52, 'KABUPATEN LOMBOK TENGAH'),
	(5203, 52, 'KABUPATEN LOMBOK TIMUR'),
	(5204, 52, 'KABUPATEN SUMBAWA'),
	(5205, 52, 'KABUPATEN DOMPU'),
	(5206, 52, 'KABUPATEN BIMA'),
	(5207, 52, 'KABUPATEN SUMBAWA BARAT'),
	(5208, 52, 'KABUPATEN LOMBOK UTARA'),
	(5271, 52, 'KOTA MATARAM'),
	(5272, 52, 'KOTA BIMA'),
	(5301, 53, 'KABUPATEN SUMBA BARAT'),
	(5302, 53, 'KABUPATEN SUMBA TIMUR'),
	(5303, 53, 'KABUPATEN KUPANG'),
	(5304, 53, 'KABUPATEN TIMOR TENGAH SELATAN'),
	(5305, 53, 'KABUPATEN TIMOR TENGAH UTARA'),
	(5306, 53, 'KABUPATEN BELU'),
	(5307, 53, 'KABUPATEN ALOR'),
	(5308, 53, 'KABUPATEN LEMBATA'),
	(5309, 53, 'KABUPATEN FLORES TIMUR'),
	(5310, 53, 'KABUPATEN SIKKA'),
	(5311, 53, 'KABUPATEN ENDE'),
	(5312, 53, 'KABUPATEN NGADA'),
	(5313, 53, 'KABUPATEN MANGGARAI'),
	(5314, 53, 'KABUPATEN ROTE NDAO'),
	(5315, 53, 'KABUPATEN MANGGARAI BARAT'),
	(5316, 53, 'KABUPATEN SUMBA TENGAH'),
	(5317, 53, 'KABUPATEN SUMBA BARAT DAYA'),
	(5318, 53, 'KABUPATEN NAGEKEO'),
	(5319, 53, 'KABUPATEN MANGGARAI TIMUR'),
	(5320, 53, 'KABUPATEN SABU RAIJUA'),
	(5321, 53, 'KABUPATEN MALAKA'),
	(5371, 53, 'KOTA KUPANG'),
	(6101, 61, 'KABUPATEN SAMBAS'),
	(6102, 61, 'KABUPATEN BENGKAYANG'),
	(6103, 61, 'KABUPATEN LANDAK'),
	(6104, 61, 'KABUPATEN MEMPAWAH'),
	(6105, 61, 'KABUPATEN SANGGAU'),
	(6106, 61, 'KABUPATEN KETAPANG'),
	(6107, 61, 'KABUPATEN SINTANG'),
	(6108, 61, 'KABUPATEN KAPUAS HULU'),
	(6109, 61, 'KABUPATEN SEKADAU'),
	(6110, 61, 'KABUPATEN MELAWI'),
	(6111, 61, 'KABUPATEN KAYONG UTARA'),
	(6112, 61, 'KABUPATEN KUBU RAYA'),
	(6171, 61, 'KOTA PONTIANAK'),
	(6172, 61, 'KOTA SINGKAWANG'),
	(6201, 62, 'KABUPATEN KOTAWARINGIN BARAT'),
	(6202, 62, 'KABUPATEN KOTAWARINGIN TIMUR'),
	(6203, 62, 'KABUPATEN KAPUAS'),
	(6204, 62, 'KABUPATEN BARITO SELATAN'),
	(6205, 62, 'KABUPATEN BARITO UTARA'),
	(6206, 62, 'KABUPATEN SUKAMARA'),
	(6207, 62, 'KABUPATEN LAMANDAU'),
	(6208, 62, 'KABUPATEN SERUYAN'),
	(6209, 62, 'KABUPATEN KATINGAN'),
	(6210, 62, 'KABUPATEN PULANG PISAU'),
	(6211, 62, 'KABUPATEN GUNUNG MAS'),
	(6212, 62, 'KABUPATEN BARITO TIMUR'),
	(6213, 62, 'KABUPATEN MURUNG RAYA'),
	(6271, 62, 'KOTA PALANGKA RAYA'),
	(6301, 63, 'KABUPATEN TANAH LAUT'),
	(6302, 63, 'KABUPATEN KOTA BARU'),
	(6303, 63, 'KABUPATEN BANJAR'),
	(6304, 63, 'KABUPATEN BARITO KUALA'),
	(6305, 63, 'KABUPATEN TAPIN'),
	(6306, 63, 'KABUPATEN HULU SUNGAI SELATAN'),
	(6307, 63, 'KABUPATEN HULU SUNGAI TENGAH'),
	(6308, 63, 'KABUPATEN HULU SUNGAI UTARA'),
	(6309, 63, 'KABUPATEN TABALONG'),
	(6310, 63, 'KABUPATEN TANAH BUMBU'),
	(6311, 63, 'KABUPATEN BALANGAN'),
	(6371, 63, 'KOTA BANJARMASIN'),
	(6372, 63, 'KOTA BANJAR BARU'),
	(6401, 64, 'KABUPATEN PASER'),
	(6402, 64, 'KABUPATEN KUTAI BARAT'),
	(6403, 64, 'KABUPATEN KUTAI KARTANEGARA'),
	(6404, 64, 'KABUPATEN KUTAI TIMUR'),
	(6405, 64, 'KABUPATEN BERAU'),
	(6409, 64, 'KABUPATEN PENAJAM PASER UTARA'),
	(6411, 64, 'KABUPATEN MAHAKAM HULU'),
	(6471, 64, 'KOTA BALIKPAPAN'),
	(6472, 64, 'KOTA SAMARINDA'),
	(6474, 64, 'KOTA BONTANG'),
	(6501, 65, 'KABUPATEN MALINAU'),
	(6502, 65, 'KABUPATEN BULUNGAN'),
	(6503, 65, 'KABUPATEN TANA TIDUNG'),
	(6504, 65, 'KABUPATEN NUNUKAN'),
	(6571, 65, 'KOTA TARAKAN'),
	(7101, 71, 'KABUPATEN BOLAANG MONGONDOW'),
	(7102, 71, 'KABUPATEN MINAHASA'),
	(7103, 71, 'KABUPATEN KEPULAUAN SANGIHE'),
	(7104, 71, 'KABUPATEN KEPULAUAN TALAUD'),
	(7105, 71, 'KABUPATEN MINAHASA SELATAN'),
	(7106, 71, 'KABUPATEN MINAHASA UTARA'),
	(7107, 71, 'KABUPATEN BOLAANG MONGONDOW UTARA'),
	(7108, 71, 'KABUPATEN SIAU TAGULANDANG BIARO'),
	(7109, 71, 'KABUPATEN MINAHASA TENGGARA'),
	(7110, 71, 'KABUPATEN BOLAANG MONGONDOW SELATAN'),
	(7111, 71, 'KABUPATEN BOLAANG MONGONDOW TIMUR'),
	(7171, 71, 'KOTA MANADO'),
	(7172, 71, 'KOTA BITUNG'),
	(7173, 71, 'KOTA TOMOHON'),
	(7174, 71, 'KOTA KOTAMOBAGU'),
	(7201, 72, 'KABUPATEN BANGGAI KEPULAUAN'),
	(7202, 72, 'KABUPATEN BANGGAI'),
	(7203, 72, 'KABUPATEN MOROWALI'),
	(7204, 72, 'KABUPATEN POSO'),
	(7205, 72, 'KABUPATEN DONGGALA'),
	(7206, 72, 'KABUPATEN TOLI-TOLI'),
	(7207, 72, 'KABUPATEN BUOL'),
	(7208, 72, 'KABUPATEN PARIGI MOUTONG'),
	(7209, 72, 'KABUPATEN TOJO UNA-UNA'),
	(7210, 72, 'KABUPATEN SIGI'),
	(7211, 72, 'KABUPATEN BANGGAI LAUT'),
	(7212, 72, 'KABUPATEN MOROWALI UTARA'),
	(7271, 72, 'KOTA PALU'),
	(7301, 73, 'KABUPATEN KEPULAUAN SELAYAR'),
	(7302, 73, 'KABUPATEN BULUKUMBA'),
	(7303, 73, 'KABUPATEN BANTAENG'),
	(7304, 73, 'KABUPATEN JENEPONTO'),
	(7305, 73, 'KABUPATEN TAKALAR'),
	(7306, 73, 'KABUPATEN GOWA'),
	(7307, 73, 'KABUPATEN SINJAI'),
	(7308, 73, 'KABUPATEN MAROS'),
	(7309, 73, 'KABUPATEN PANGKAJENE DAN KEPULAUAN'),
	(7310, 73, 'KABUPATEN BARRU'),
	(7311, 73, 'KABUPATEN BONE'),
	(7312, 73, 'KABUPATEN SOPPENG'),
	(7313, 73, 'KABUPATEN WAJO'),
	(7314, 73, 'KABUPATEN SIDENRENG RAPPANG'),
	(7315, 73, 'KABUPATEN PINRANG'),
	(7316, 73, 'KABUPATEN ENREKANG'),
	(7317, 73, 'KABUPATEN LUWU'),
	(7318, 73, 'KABUPATEN TANA TORAJA'),
	(7322, 73, 'KABUPATEN LUWU UTARA'),
	(7325, 73, 'KABUPATEN LUWU TIMUR'),
	(7326, 73, 'KABUPATEN TORAJA UTARA'),
	(7371, 73, 'KOTA MAKASSAR'),
	(7372, 73, 'KOTA PAREPARE'),
	(7373, 73, 'KOTA PALOPO'),
	(7401, 74, 'KABUPATEN BUTON'),
	(7402, 74, 'KABUPATEN MUNA'),
	(7403, 74, 'KABUPATEN KONAWE'),
	(7404, 74, 'KABUPATEN KOLAKA'),
	(7405, 74, 'KABUPATEN KONAWE SELATAN'),
	(7406, 74, 'KABUPATEN BOMBANA'),
	(7407, 74, 'KABUPATEN WAKATOBI'),
	(7408, 74, 'KABUPATEN KOLAKA UTARA'),
	(7409, 74, 'KABUPATEN BUTON UTARA'),
	(7410, 74, 'KABUPATEN KONAWE UTARA'),
	(7411, 74, 'KABUPATEN KOLAKA TIMUR'),
	(7412, 74, 'KABUPATEN KONAWE KEPULAUAN'),
	(7413, 74, 'KABUPATEN MUNA BARAT'),
	(7414, 74, 'KABUPATEN BUTON TENGAH'),
	(7415, 74, 'KABUPATEN BUTON SELATAN'),
	(7471, 74, 'KOTA KENDARI'),
	(7472, 74, 'KOTA BAUBAU'),
	(7501, 75, 'KABUPATEN BOALEMO'),
	(7502, 75, 'KABUPATEN GORONTALO'),
	(7503, 75, 'KABUPATEN POHUWATO'),
	(7504, 75, 'KABUPATEN BONE BOLANGO'),
	(7505, 75, 'KABUPATEN GORONTALO UTARA'),
	(7571, 75, 'KOTA GORONTALO'),
	(7601, 76, 'KABUPATEN MAJENE'),
	(7602, 76, 'KABUPATEN POLEWALI MANDAR'),
	(7603, 76, 'KABUPATEN MAMASA'),
	(7604, 76, 'KABUPATEN MAMUJU'),
	(7605, 76, 'KABUPATEN MAMUJU UTARA'),
	(7606, 76, 'KABUPATEN MAMUJU TENGAH'),
	(8101, 81, 'KABUPATEN MALUKU TENGGARA BARAT'),
	(8102, 81, 'KABUPATEN MALUKU TENGGARA'),
	(8103, 81, 'KABUPATEN MALUKU TENGAH'),
	(8104, 81, 'KABUPATEN BURU'),
	(8105, 81, 'KABUPATEN KEPULAUAN ARU'),
	(8106, 81, 'KABUPATEN SERAM BAGIAN BARAT'),
	(8107, 81, 'KABUPATEN SERAM BAGIAN TIMUR'),
	(8108, 81, 'KABUPATEN MALUKU BARAT DAYA'),
	(8109, 81, 'KABUPATEN BURU SELATAN'),
	(8171, 81, 'KOTA AMBON'),
	(8172, 81, 'KOTA TUAL'),
	(8201, 82, 'KABUPATEN HALMAHERA BARAT'),
	(8202, 82, 'KABUPATEN HALMAHERA TENGAH'),
	(8203, 82, 'KABUPATEN KEPULAUAN SULA'),
	(8204, 82, 'KABUPATEN HALMAHERA SELATAN'),
	(8205, 82, 'KABUPATEN HALMAHERA UTARA'),
	(8206, 82, 'KABUPATEN HALMAHERA TIMUR'),
	(8207, 82, 'KABUPATEN PULAU MOROTAI'),
	(8208, 82, 'KABUPATEN PULAU TALIABU'),
	(8271, 82, 'KOTA TERNATE'),
	(8272, 82, 'KOTA TIDORE KEPULAUAN'),
	(9101, 91, 'KABUPATEN FAKFAK'),
	(9102, 91, 'KABUPATEN KAIMANA'),
	(9103, 91, 'KABUPATEN TELUK WONDAMA'),
	(9104, 91, 'KABUPATEN TELUK BINTUNI'),
	(9105, 91, 'KABUPATEN MANOKWARI'),
	(9106, 91, 'KABUPATEN SORONG SELATAN'),
	(9107, 91, 'KABUPATEN SORONG'),
	(9108, 91, 'KABUPATEN RAJA AMPAT'),
	(9109, 91, 'KABUPATEN TAMBRAUW'),
	(9110, 91, 'KABUPATEN MAYBRAT'),
	(9111, 91, 'KABUPATEN MANOKWARI SELATAN'),
	(9112, 91, 'KABUPATEN PEGUNUNGAN ARFAK'),
	(9171, 91, 'KOTA SORONG'),
	(9401, 94, 'KABUPATEN MERAUKE'),
	(9402, 94, 'KABUPATEN JAYAWIJAYA'),
	(9403, 94, 'KABUPATEN JAYAPURA'),
	(9404, 94, 'KABUPATEN NABIRE'),
	(9408, 94, 'KABUPATEN KEPULAUAN YAPEN'),
	(9409, 94, 'KABUPATEN BIAK NUMFOR'),
	(9410, 94, 'KABUPATEN PANIAI'),
	(9411, 94, 'KABUPATEN PUNCAK JAYA'),
	(9412, 94, 'KABUPATEN MIMIKA'),
	(9413, 94, 'KABUPATEN BOVEN DIGOEL'),
	(9414, 94, 'KABUPATEN MAPPI'),
	(9415, 94, 'KABUPATEN ASMAT'),
	(9416, 94, 'KABUPATEN YAHUKIMO'),
	(9417, 94, 'KABUPATEN PEGUNUNGAN BINTANG'),
	(9418, 94, 'KABUPATEN TOLIKARA'),
	(9419, 94, 'KABUPATEN SARMI'),
	(9420, 94, 'KABUPATEN KEEROM'),
	(9426, 94, 'KABUPATEN WAROPEN'),
	(9427, 94, 'KABUPATEN SUPIORI'),
	(9428, 94, 'KABUPATEN MAMBERAMO RAYA'),
	(9429, 94, 'KABUPATEN NDUGA'),
	(9430, 94, 'KABUPATEN LANNY JAYA'),
	(9431, 94, 'KABUPATEN MAMBERAMO TENGAH'),
	(9432, 94, 'KABUPATEN YALIMO'),
	(9433, 94, 'KABUPATEN PUNCAK'),
	(9434, 94, 'KABUPATEN DOGIYAI'),
	(9435, 94, 'KABUPATEN INTAN JAYA'),
	(9436, 94, 'KABUPATEN DEIYAI'),
	(9471, 94, 'KOTA JAYAPURA');
/*!40000 ALTER TABLE `regencies` ENABLE KEYS */;

-- Dumping structure for table oketrip.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.role: ~3 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
REPLACE INTO `role` (`id`, `name`, `note`, `active`, `type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'Top level of admin user', 'true', 'true', '1', 'adi', '2019-08-14 08:50:45', '2019-08-14 09:29:37'),
	(2, 'Master Agent', 'Top level of agent', 'true', 'true', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(3, 'Agent', 'Below level of master agent', 'true', 'true', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Dumping structure for table oketrip.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.sessions: ~0 rows (approximately)
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

-- Dumping structure for table oketrip.token_management
CREATE TABLE IF NOT EXISTS `token_management` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `access_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_at` datetime NOT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.token_management: ~4 rows (approximately)
/*!40000 ALTER TABLE `token_management` DISABLE KEYS */;
REPLACE INTO `token_management` (`id`, `user_id`, `access_token`, `expired_at`, `is_active`, `created_at`, `updated_at`) VALUES
	(66, 1, 'YjY4YTQ5ODQ1ZmZiYmVhNmM1MDQ3OGI4MWY2MDM1NjBjZDhiZjU2YQ==', '2019-08-15 09:03:07', 1, '2019-08-14 09:03:07', '2019-08-14 09:03:07'),
	(436, 2, 'OWUxMWRhNDYzNjI1MDYzYWQwZmZjNmM2M2IyMmYxMDczN2JiM2MyNw==', '2019-08-15 16:16:26', 1, '2019-08-14 16:16:26', '2019-08-14 16:16:26'),
	(1495, 4, 'YjFmMGNjMjcwNjAyNGI0NTQzZWI4ZGY0NGJhMWQ4YzEwZDc5NWMwMQ==', '2019-08-23 16:51:18', 1, '2019-08-22 16:51:18', '2019-08-22 16:51:18'),
	(2110, 3, 'MmM3YmQ1YTRiZDUyOTJkZTY0MDkxMWJkMDQ1MGNmN2Q2MmE2MDIyNA==', '2019-09-06 16:36:32', 1, '2019-09-05 16:36:32', '2019-09-05 16:36:32');
/*!40000 ALTER TABLE `token_management` ENABLE KEYS */;

-- Dumping structure for table oketrip.tour_leader
CREATE TABLE IF NOT EXISTS `tour_leader` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_exp_date` date NOT NULL,
  `issuing` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.tour_leader: ~2 rows (approximately)
/*!40000 ALTER TABLE `tour_leader` DISABLE KEYS */;
REPLACE INTO `tour_leader` (`id`, `name`, `address`, `phone`, `passport`, `passport_exp_date`, `issuing`, `gender`, `birth_date`, `birth_place`, `image`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Lukmans', 'Nginden Intan', '23434343', '21321321321321', '2019-08-23', 'dsfsf', 'male', '2019-08-23', 'surabaya', '/dist/img/user/admin_Lukman.jpg', 'adi wielijarni', 'adi wielijarni', '2019-08-23 16:30:24', '2019-08-23 17:44:58'),
	(2, 'sdfa', 'asdaswdas', '2343423', '234234234', '2019-08-23', '343243', 'male', '2019-08-23', '34343', '/dist/img/user/admin_sdfa.jpg', 'adi wielijarni', 'adi wielijarni', '2019-08-23 17:45:15', '2019-08-23 17:45:15');
/*!40000 ALTER TABLE `tour_leader` ENABLE KEYS */;

-- Dumping structure for table oketrip.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `type_user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oketrip.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `api_token`, `remember_token`, `role_id`, `company_id`, `type_user`, `active`, `image`, `created_at`, `updated_at`) VALUES
	(3, 'adi wielijarni', 'dewa17a@gmail.com', NULL, '$2y$10$.hdraGNS2OHKn9bl9./EluhSQ.pIHveoGBDW4HXg0Gv0RGvelo/RG', NULL, NULL, 1, NULL, 'ADMIN', 'true', '/dist/img/user/admin_adi wielijarni.jpg', '2019-08-15 08:33:38', '2019-08-15 08:47:14'),
	(4, 'adi wielijarni', 'adiyani17a@gmail.com', NULL, '$2y$10$J2tJPk/CLx4ANfJEt6BCAeRo0qhY5szmN5ZuY/.uVLC13ziK7Q1Qa', NULL, NULL, 1, NULL, 'ADMIN', 'true', '/dist/img/user/admin_adi wielijarni.jpg', '2019-08-15 11:06:59', '2019-08-15 13:55:45'),
	(5, 'PT Jawa Abadi', 'jawa.abadi@gmail.com', NULL, '$2y$10$jHujawgPG84uKpFqQj.ndujpLjg6FGtd1qs.TJKGUyxQz5qJJXjiq', NULL, NULL, 2, 1, 'AGENT', 'true', '/dist/img/user/admin_PT Jawa Abadi.jpg', '2019-09-03 11:04:16', '2019-09-03 11:04:16');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
