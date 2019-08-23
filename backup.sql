-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.37 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table oke_trip.additional
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

-- Dumping data for table oke_trip.additional: ~1 rows (approximately)
/*!40000 ALTER TABLE `additional` DISABLE KEYS */;
REPLACE INTO `additional` (`id`, `name`, `note`, `image`, `price`, `created_by`, `updated_by`, `active`, `created_at`, `updated_at`) VALUES
	(1, 'FPG insurance', 'asuransi dari fpg', '/dist/img/additional/additional_FPG insurance.jpg', 2500000.00, 'adi', 'adi wielijarni', 'true', '2019-08-14 09:33:45', '2019-08-21 15:15:20');
/*!40000 ALTER TABLE `additional` ENABLE KEYS */;

-- Dumping structure for table oke_trip.destination
CREATE TABLE IF NOT EXISTS `destination` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.destination: ~4 rows (approximately)
/*!40000 ALTER TABLE `destination` DISABLE KEYS */;
REPLACE INTO `destination` (`id`, `name`, `note`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'Hongkong', 'Travel To Hongkong', '2019-08-14 09:30:16', 'adi', '2019-08-14 09:30:16', 'adi'),
	(2, 'China', 'Travel to china', '2019-08-14 09:30:32', 'adi', '2019-08-14 09:30:32', 'adi'),
	(3, 'Dubai', 'Travel to dubai', '2019-08-14 09:30:44', 'adi', '2019-08-14 09:30:44', 'adi'),
	(4, 'Japan', 'Travel to japan', '2019-08-14 09:31:00', 'adi', '2019-08-14 09:31:00', 'adi');
/*!40000 ALTER TABLE `destination` ENABLE KEYS */;

-- Dumping structure for table oke_trip.group_menu
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

-- Dumping data for table oke_trip.group_menu: ~5 rows (approximately)
/*!40000 ALTER TABLE `group_menu` DISABLE KEYS */;
REPLACE INTO `group_menu` (`id`, `name`, `slug`, `icon`, `url`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Setting', 'setting', 'fas fa-cogs', '-', 'adi', 'adi', '2019-08-14 08:48:34', '2019-08-14 09:10:03'),
	(2, 'User', 'user', 'fas fa-user', '-', 'adi', 'adi', '2019-08-14 08:57:12', '2019-08-14 08:57:12'),
	(3, 'Sales', 'sales', 'fas fa-suitcase-rolling', '-', 'adi', 'adi', '2019-08-14 09:09:53', '2019-08-14 09:09:53'),
	(4, 'Finance', 'finance', 'fas fa-chart-line', '-', 'adi', 'adi', '2019-08-14 09:12:06', '2019-08-14 09:12:06'),
	(5, 'Report', 'report', 'fas fa-book', '-', 'adi', 'adi', '2019-08-14 09:12:53', '2019-08-14 09:12:53');
/*!40000 ALTER TABLE `group_menu` ENABLE KEYS */;

-- Dumping structure for table oke_trip.itinerary
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
  `book_by` int(11) DEFAULT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `itinerary_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.itinerary: ~7 rows (approximately)
/*!40000 ALTER TABLE `itinerary` DISABLE KEYS */;
REPLACE INTO `itinerary` (`id`, `code`, `name`, `destination_id`, `highlight`, `term_condition`, `flight_by`, `additional_id`, `carousel_1`, `carousel_2`, `carousel_3`, `note_1`, `note_2`, `note_3`, `pdf`, `flayer_image`, `book_by`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'TR19082100001', '4D HONGKONG, CHINA', '1,2', 'AIRASIA', '<p>AIRASIA</p>', 'AIRASIA', '1', 'dist/img/itinerary/carousel_1_1.jpg', 'dist/img/itinerary/carousel_2_1.jpg', 'dist/img/itinerary/carousel_3_1.jpg', 'AIRASIA', 'AIRASIA', 'AIRASIA', './dist/pdf/itinerary/pdf_1.pdf', 'dist/img/itinerary/flyer_1.jpg', NULL, NULL, 4, 4, '2019-08-21 14:37:01', '2019-08-21 14:37:01'),
	(2, 'TR19082100002', '2D HONGKONG,SURABAYA', '2,3', 'AIRASIA', '<p>AIRASIA</p>', 'AIRASIA', '1', 'dist/img/itinerary/carousel_1_2.jpg', 'dist/img/itinerary/carousel_2_2.jpg', 'dist/img/itinerary/carousel_3_2.jpg', 'AIRASIA', 'AIRASIA', 'AIRASIA', 'dist/pdf/itinerary/pdf_2.pdf', 'dist/img/itinerary/flyer_2.jpg', NULL, NULL, 4, 4, '2019-08-21 14:55:16', '2019-08-21 14:55:16'),
	(3, 'TR19082100003', '3D HONGKONG CHINA', '2,1', 'BLUE ASIA', '<p>BLUE ASIA</p>', 'BLUE ASIA', '1', 'dist/img/itinerary/carousel_1_3.jpg', 'dist/img/itinerary/carousel_2_3.jpg', 'dist/img/itinerary/carousel_3_3.jpg', 'BLUE ASIA', 'BLUE ASIA', 'BLUE ASIA', 'dist/pdf/itinerary/pdf_3.pdf', 'dist/img/itinerary/flyer_3.jpg', NULL, NULL, 4, 4, '2019-08-21 15:05:03', '2019-08-21 15:05:03'),
	(4, 'TR19082100004', '2D HONGKONG, CHINA', '1,2', 'itinerary', '<p>itinerary</p>', 'itinerary', '1', 'dist/img/itinerary/carousel_1_4.jpg', 'dist/img/itinerary/carousel_2_4.jpg', 'dist/img/itinerary/carousel_3_4.jpg', 'itinerary', 'itinerary', 'itinerary', 'dist/pdf/itinerary/pdf_4.pdf', 'dist/img/itinerary/flyer_4.jpg', NULL, NULL, 4, 4, '2019-08-21 15:07:40', '2019-08-21 15:07:40'),
	(5, 'TR19082100005', '1D HONGKONG', '1', 'AIRASIA', '<p>AIRASIA</p>', 'AIRASIA', '1', 'dist/img/itinerary/carousel_1_5.jpg', 'dist/img/itinerary/carousel_2_5.jpg', 'dist/img/itinerary/carousel_3_5.jpg', 'AIRASIA', 'AIRASIA', 'AIRASIA', 'dist/pdf/itinerary/pdf_5.pdf', 'dist/img/itinerary/flyer_5.jpg', NULL, NULL, 4, 4, '2019-08-21 15:12:26', '2019-08-21 15:12:26'),
	(6, 'TR19082100006', '2D CHINA', '2', 'LION AIR', '<p>LION AIR</p>', 'LION AIR', '1', 'dist/img/itinerary/carousel_1_6.jpg', 'dist/img/itinerary/carousel_2_6.jpg', 'dist/img/itinerary/carousel_3_6.jpg', 'LION AIR', 'LION AIR', 'LION AIR', 'dist/pdf/itinerary/pdf_6.pdf', 'dist/img/itinerary/flyer_6.jpg', NULL, NULL, 4, 4, '2019-08-21 15:15:04', '2019-08-21 15:15:04'),
	(7, 'TR19082300007', '4D HONGKONG FOR FUN', '1', 'MAKE YOUR TRIP BECOME FUN', '<p>What are Terms and Conditions</p><p>Terms and Conditions agreements act as a legal contract between you (the company) who has the website or mobile app and the user who access your website and mobile app.</p><p>Having a Terms and Conditions agreement is completely optional. No laws require you to have one. Not even the super-strict and wide-reaching General Data Protection Regulation (<a href="https://termsfeed.com/blog/gdpr/" rel="noopener noreferrer nofollow">GDPR</a>).</p><p>It’s up to you to set the rules and guidelines that the user must agree to. You can think of your Terms and Conditions agreement as the legal agreement where you <strong>maintain your rights</strong> to exclude users from your app in the event that they abuse your app, where you maintain your legal rights against potential app abusers, and so on.</p><p>Terms and Conditions are also known as Terms of Service or Terms of Use.</p><p>You can use this agreement anywhere, regardless of what platform your business operates on:</p><ul><li><p>Websites</p></li><li><p>WordPress blogs or blogs on any kind of platform: Joomla!, Drupal etc.</p></li><li><p>E-commerce shops</p></li><li><p>Mobile apps: iOS, Android or Windows phone</p></li><li><p><a href="https://termsfeed.com/blog/facebook-terms-of-service-login-details-app-details/" rel="noopener noreferrer nofollow">Facebook apps</a></p></li><li><p>Desktop apps</p></li><li><p><a href="https://termsfeed.com/blog/terms-use-privacy-policy-saas-applications/" rel="noopener noreferrer nofollow">SaaS apps</a></p></li></ul><p>Desktop apps usually have an <a href="https://termsfeed.com/blog/eula-saas-apps/" rel="noopener noreferrer nofollow">EULA</a> (End-User License Agreement) instead of a Terms and Conditions agreement, but your business can use <em>both</em>. Mobile apps are increasingly using Terms and Conditions along with an EULA if the mobile app has an online service component, i.e. it connects with a server.</p>', 'AIRASIA', '1', 'dist/img/itinerary/carousel_1_7.jpg', 'dist/img/itinerary/carousel_2_7.jpg', 'dist/img/itinerary/carousel_3_7.jpg', 'BRIDGE OF SOUTH HONGKONG', 'BRIDGE OF NORTH HONGKONG', 'BRIDGE OF JAPAN HONGKONG', 'dist/pdf/itinerary/pdf_7.pdf', 'dist/img/itinerary/flyer_7.jpg', NULL, NULL, 3, 3, '2019-08-23 09:42:16', '2019-08-23 09:42:16');
/*!40000 ALTER TABLE `itinerary` ENABLE KEYS */;

-- Dumping structure for table oke_trip.itinerary_detail
CREATE TABLE IF NOT EXISTS `itinerary_detail` (
  `id` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat` int(11) NOT NULL,
  `seat_remain` int(11) NOT NULL,
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
  `final_pdf` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `term_pdf` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flayer_jpg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tour_leader_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.itinerary_detail: ~13 rows (approximately)
/*!40000 ALTER TABLE `itinerary_detail` DISABLE KEYS */;
REPLACE INTO `itinerary_detail` (`id`, `dt`, `code`, `seat`, `seat_remain`, `start`, `end`, `adult_price`, `child_price`, `child_bed_price`, `infant_price`, `minimal_dp`, `agent_com`, `agent_tip`, `agent_visa`, `agent_tax`, `final_pdf`, `term_pdf`, `flayer_jpg`, `tour_leader_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 1, 'TR19082100001/001', 15, 15, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 14:37:01', '2019-08-21 14:37:01'),
	(1, 2, 'TR19082100001/002', 15, 15, '2019-08-21', '2019-08-21', 1750000.00, 1750000.00, 1750000.00, 1750000.00, 75000.00, 75000.00, 75000.00, 75000.00, 75000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 14:37:01', '2019-08-21 14:37:01'),
	(2, 1, 'TR19082100002/001', 15, 15, '2019-08-21', '2019-08-21', 5000000.00, 5000000.00, 5000000.00, 5000000.00, 500000.00, 1000000.00, 1000000.00, 1000000.00, 1000000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 14:55:16', '2019-08-21 14:55:16'),
	(2, 2, 'TR19082100002/002', 10, 10, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 14:55:16', '2019-08-21 14:55:16'),
	(3, 1, 'TR19082100003/001', 15, 15, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 12.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:05:03', '2019-08-21 15:05:03'),
	(3, 2, 'TR19082100003/002', 25, 25, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, 2500000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:05:03', '2019-08-21 15:05:03'),
	(4, 1, 'TR19082100004/001', 15, 15, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:07:40', '2019-08-21 15:07:40'),
	(4, 2, 'TR19082100004/002', 15, 15, '2019-08-21', '2019-08-21', 1250000.00, 1250000.00, 1250000.00, 1250000.00, 2500000.00, 250000.00, 250000.00, 50000.00, 250000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:07:40', '2019-08-21 15:07:40'),
	(5, 1, 'TR19082100005/001', 15, 15, '2019-08-21', '2019-08-21', 1500000.00, 1500000.00, 1500000.00, 1500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:12:26', '2019-08-21 15:12:26'),
	(6, 1, 'TR19082100006/001', 15, 15, '2019-08-21', '2019-08-21', 2500000.00, 2500000.00, 2500000.00, 2500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:15:04', '2019-08-21 15:15:04'),
	(6, 2, 'TR19082100006/002', 15, 15, '2019-08-21', '2019-08-23', 5800000.00, 5800000.00, 5800000.00, 5800000.00, 80000.00, 80000.00, 80000.00, 80000.00, 80000.00, NULL, NULL, NULL, NULL, 4, 4, '2019-08-21 15:15:04', '2019-08-21 15:15:04'),
	(7, 1, 'TR19082300007/001', 20, 20, '2019-08-23', '2019-08-23', 3000000.00, 3000000.00, 3000000.00, 3000000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, NULL, NULL, NULL, NULL, 3, 3, '2019-08-23 09:42:16', '2019-08-23 09:42:16'),
	(7, 2, 'TR19082300007/002', 20, 20, '2019-08-23', '2019-08-23', 3000000.00, 3000000.00, 3000000.00, 1500000.00, 500000.00, 500000.00, 500000.00, 500000.00, 500000.00, NULL, NULL, NULL, NULL, 3, 3, '2019-08-23 09:42:16', '2019-08-23 09:42:16');
/*!40000 ALTER TABLE `itinerary_detail` ENABLE KEYS */;

-- Dumping structure for table oke_trip.itinerary_flight
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

-- Dumping data for table oke_trip.itinerary_flight: ~16 rows (approximately)
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

-- Dumping structure for table oke_trip.itinerary_schedule
CREATE TABLE IF NOT EXISTS `itinerary_schedule` (
  `id` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `caption` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `eat_service` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.itinerary_schedule: ~17 rows (approximately)
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

-- Dumping structure for table oke_trip.menu_list
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

-- Dumping data for table oke_trip.menu_list: ~17 rows (approximately)
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
	(17, 'Payment Report', '-', 'payment-report', 5, 'payment-report', 'adi', 'adi', '2019-08-14 09:18:13', '2019-08-14 09:18:13');
/*!40000 ALTER TABLE `menu_list` ENABLE KEYS */;

-- Dumping structure for table oke_trip.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.migrations: ~18 rows (approximately)
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
	(18, '2019_08_23_143624_tour_leader', 2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table oke_trip.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table oke_trip.privilege
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.privilege: ~51 rows (approximately)
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
	(51, 3, 'agent', 17, 'Payment Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03');
/*!40000 ALTER TABLE `privilege` ENABLE KEYS */;

-- Dumping structure for table oke_trip.role
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

-- Dumping data for table oke_trip.role: ~3 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
REPLACE INTO `role` (`id`, `name`, `note`, `active`, `type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'Top level of admin user', 'true', 'true', '1', 'adi', '2019-08-14 08:50:45', '2019-08-14 09:29:37'),
	(2, 'Master Agent', 'Top level of agent', 'true', 'true', 'adi', 'adi', '2019-08-14 09:26:46', '2019-08-14 09:26:46'),
	(3, 'Agent', 'Below level of master agent', 'true', 'true', 'adi', 'adi', '2019-08-14 09:27:03', '2019-08-14 09:27:03');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Dumping structure for table oke_trip.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.sessions: ~0 rows (approximately)
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

-- Dumping structure for table oke_trip.token_management
CREATE TABLE IF NOT EXISTS `token_management` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `access_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_at` datetime NOT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1740 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.token_management: ~4 rows (approximately)
/*!40000 ALTER TABLE `token_management` DISABLE KEYS */;
REPLACE INTO `token_management` (`id`, `user_id`, `access_token`, `expired_at`, `is_active`, `created_at`, `updated_at`) VALUES
	(66, 1, 'YjY4YTQ5ODQ1ZmZiYmVhNmM1MDQ3OGI4MWY2MDM1NjBjZDhiZjU2YQ==', '2019-08-15 09:03:07', 1, '2019-08-14 09:03:07', '2019-08-14 09:03:07'),
	(436, 2, 'OWUxMWRhNDYzNjI1MDYzYWQwZmZjNmM2M2IyMmYxMDczN2JiM2MyNw==', '2019-08-15 16:16:26', 1, '2019-08-14 16:16:26', '2019-08-14 16:16:26'),
	(1495, 4, 'YjFmMGNjMjcwNjAyNGI0NTQzZWI4ZGY0NGJhMWQ4YzEwZDc5NWMwMQ==', '2019-08-23 16:51:18', 1, '2019-08-22 16:51:18', '2019-08-22 16:51:18'),
	(1739, 3, 'MzczOGRhNzRhNzNiN2JlZmZkYjY1NzQ5YjU3NTNiZjBlMzJmMjY4Mg==', '2019-08-24 17:44:12', 1, '2019-08-23 17:44:12', '2019-08-23 17:44:12');
/*!40000 ALTER TABLE `token_management` ENABLE KEYS */;

-- Dumping structure for table oke_trip.tour_leader
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

-- Dumping data for table oke_trip.tour_leader: ~1 rows (approximately)
/*!40000 ALTER TABLE `tour_leader` DISABLE KEYS */;
REPLACE INTO `tour_leader` (`id`, `name`, `address`, `phone`, `passport`, `passport_exp_date`, `issuing`, `gender`, `birth_date`, `birth_place`, `image`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Lukmans', 'Nginden Intan', '23434343', '21321321321321', '2019-08-23', 'dsfsf', 'male', '2019-08-23', 'surabaya', '/dist/img/user/admin_Lukman.jpg', 'adi wielijarni', 'adi wielijarni', '2019-08-23 16:30:24', '2019-08-23 17:44:58'),
	(2, 'sdfa', 'asdaswdas', '2343423', '234234234', '2019-08-23', '343243', 'male', '2019-08-23', '34343', '/dist/img/user/admin_sdfa.jpg', 'adi wielijarni', 'adi wielijarni', '2019-08-23 17:45:15', '2019-08-23 17:45:15');
/*!40000 ALTER TABLE `tour_leader` ENABLE KEYS */;

-- Dumping structure for table oke_trip.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `type_user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `api_token`, `remember_token`, `role_id`, `type_user`, `active`, `image`, `created_at`, `updated_at`) VALUES
	(3, 'adi wielijarni', 'dewa17a@gmail.com', NULL, '$2y$10$.hdraGNS2OHKn9bl9./EluhSQ.pIHveoGBDW4HXg0Gv0RGvelo/RG', NULL, NULL, 1, 'ADMIN', 'true', '/dist/img/user/admin_adi wielijarni.jpg', '2019-08-15 08:33:38', '2019-08-15 08:47:14'),
	(4, 'adi wielijarni', 'adiyani17a@gmail.com', NULL, '$2y$10$J2tJPk/CLx4ANfJEt6BCAeRo0qhY5szmN5ZuY/.uVLC13ziK7Q1Qa', NULL, NULL, 1, 'ADMIN', 'true', '/dist/img/user/admin_adi wielijarni.jpg', '2019-08-15 11:06:59', '2019-08-15 13:55:45');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
