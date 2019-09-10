-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.37 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table oke_trip.booking
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` int(11) NOT NULL,
  `telp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itinerary_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Waiting List','Confirm','Cancel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_adult` double(10,2) NOT NULL,
  `total_child_no_bed` double(10,2) NOT NULL,
  `total_child_with_bed` double(10,2) NOT NULL,
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

-- Dumping data for table oke_trip.booking: 0 rows
/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;

-- Dumping structure for table oke_trip.booking_additional
CREATE TABLE IF NOT EXISTS `booking_additional` (
  `id` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `id_booking_pax` int(11) NOT NULL,
  `additional_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`dt`,`id_booking_pax`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.booking_additional: 0 rows
/*!40000 ALTER TABLE `booking_additional` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_additional` ENABLE KEYS */;

-- Dumping structure for table oke_trip.booking_d
CREATE TABLE IF NOT EXISTS `booking_d` (
  `id` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `bed` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bed` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`dt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.booking_d: 0 rows
/*!40000 ALTER TABLE `booking_d` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_d` ENABLE KEYS */;

-- Dumping structure for table oke_trip.booking_pax
CREATE TABLE IF NOT EXISTS `booking_pax` (
  `id` int(11) NOT NULL,
  `dt` int(11) NOT NULL,
  `id_booking_d` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `passport` int(11) NOT NULL,
  `exp_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issuing` int(11) NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`dt`,`id_booking_d`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.booking_pax: 0 rows
/*!40000 ALTER TABLE `booking_pax` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_pax` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
