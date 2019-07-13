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

-- Dumping structure for table oke_trip.additional
CREATE TABLE IF NOT EXISTS `additional` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `active` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.additional: ~0 rows (approximately)
/*!40000 ALTER TABLE `additional` DISABLE KEYS */;
REPLACE INTO `additional` (`id`, `name`, `note`, `image`, `price`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(2, 'tes', 'tes', '/dist/img/additional/additional_tes.jpg', 100000.00, 'true', 'adi', 'adi', '2019-07-12 22:27:38', '2019-07-12 22:33:34');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.destination: ~2 rows (approximately)
/*!40000 ALTER TABLE `destination` DISABLE KEYS */;
REPLACE INTO `destination` (`id`, `name`, `note`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 'tes', 'ete', '2019-07-12 20:09:58', 'adi', '2019-07-12 20:09:58', 'adi'),
	(2, 'gdfgfd', 'gfdgfdgd', '2019-07-12 20:10:04', 'adi', '2019-07-12 20:10:04', 'adi');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.group_menu: ~5 rows (approximately)
/*!40000 ALTER TABLE `group_menu` DISABLE KEYS */;
REPLACE INTO `group_menu` (`id`, `name`, `slug`, `icon`, `url`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(6, 'Setting', 'setting', 'fas fa-cogs', '-', 'adi', 'adi', '2019-07-06 18:59:01', '2019-07-06 18:59:01'),
	(7, 'User', 'user', 'fas fa-user', '-', 'adi', 'adi', '2019-07-06 18:59:37', '2019-07-06 18:59:37'),
	(8, 'Product', 'product', 'fab fa-product-hunt', '-', 'adi', 'adi', '2019-07-06 19:01:02', '2019-07-06 19:01:02'),
	(9, 'FInance', 'finance', 'fas fa-balance-scale', '-', 'adi', 'adi', '2019-07-06 19:02:13', '2019-07-06 19:02:13'),
	(10, 'Report', 'report', 'fas fa-chart-line', '-', 'adi', 'adi', '2019-07-06 19:02:53', '2019-07-06 19:02:53');
/*!40000 ALTER TABLE `group_menu` ENABLE KEYS */;

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

-- Dumping data for table oke_trip.menu_list: ~16 rows (approximately)
/*!40000 ALTER TABLE `menu_list` DISABLE KEYS */;
REPLACE INTO `menu_list` (`id`, `name`, `icon`, `slug`, `group_menu_id`, `url`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Group Menu', '', 'group-menu', 6, 'group-menu', 'adi', 'adi', '2019-07-06 19:03:30', '2019-07-06 19:03:30'),
	(2, 'Menu List', '', 'menu-list', 6, 'menu-list', 'adi', 'adi', '2019-07-06 19:03:54', '2019-07-06 19:03:54'),
	(3, 'Role', '', 'role', 6, 'role', 'adi', 'adi', '2019-07-06 19:04:12', '2019-07-06 19:04:12'),
	(4, 'Privilege', '', 'privilege', 6, 'privilege', 'adi', 'adi', '2019-07-06 19:04:27', '2019-07-06 19:04:27'),
	(5, 'Administrator User', '', 'administrator-user', 7, 'administrator-user', 'adi', 'adi', '2019-07-06 19:13:35', '2019-07-06 19:13:35'),
	(6, 'Agent User', '', 'agent-user', 7, 'agent-user', 'adi', 'adi', '2019-07-06 19:14:10', '2019-07-06 19:14:10'),
	(7, 'Destination', '-', 'destination', 8, 'destination', 'adi', 'adi', '2019-07-06 19:14:59', '2019-07-06 19:20:06'),
	(8, 'Additional', '', 'additional', 8, 'additional', 'adi', 'adi', '2019-07-06 19:15:34', '2019-07-06 19:15:34'),
	(9, 'Itinerary', '-', 'itinerary', 8, 'itinerary', 'adi', 'adi', '2019-07-06 19:17:59', '2019-07-06 19:20:23'),
	(10, 'Tour Leader', '', 'tour-leader', 8, 'tour-leader', 'adi', 'adi', '2019-07-06 19:18:49', '2019-07-06 19:18:49'),
	(11, 'Income Report', '-', 'income-report', 9, 'income-report', 'adi', 'adi', '2019-07-06 19:30:34', '2019-07-06 19:30:34'),
	(12, 'Income Statement', '-', 'income-statement', 9, 'income-statement', 'adi', 'adi', '2019-07-06 19:30:58', '2019-07-06 19:30:58'),
	(13, 'Sales Statistic', '-', 'sales-statistic', 10, 'sales-statistic', 'adi', 'adi', '2019-07-06 19:33:12', '2019-07-06 19:33:12'),
	(14, 'Customer Report', '-', 'customer-report', 10, 'customer-report', 'adi', 'adi', '2019-07-06 19:34:10', '2019-07-06 19:34:10'),
	(15, 'Sales Report', '-', 'sales-report', 10, 'sales-report', 'adi', 'adi', '2019-07-06 19:34:47', '2019-07-06 19:34:47'),
	(16, 'Payment Report', '-', 'payment-report', 10, 'payment-report', 'adi', 'adi', '2019-07-06 19:35:04', '2019-07-06 19:35:04');
/*!40000 ALTER TABLE `menu_list` ENABLE KEYS */;

-- Dumping structure for table oke_trip.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.migrations: ~13 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(15, '2014_10_12_000000_create_users_table', 1),
	(16, '2014_10_12_100000_create_password_resets_table', 1),
	(17, '2019_06_17_062616_create_destination_table', 1),
	(18, '2019_06_17_065225_add_created_by_to_destination_table', 1),
	(19, '2019_06_23_075752_add_api_token_to_users_table', 1),
	(20, '2019_06_23_081338_token_management', 1),
	(21, '2019_06_25_084157_add_note_to_destination_table', 1),
	(22, '2019_06_25_210454_create_group_menu_table', 1),
	(23, '2019_06_25_210508_create_menu_list_table', 1),
	(24, '2019_06_25_210539_create_privilege_table', 1),
	(25, '2019_06_25_210547_create_role_table', 1),
	(26, '2019_06_28_182241_sessions', 1),
	(27, '2019_07_12_201606_additional', 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.privilege: ~102 rows (approximately)
/*!40000 ALTER TABLE `privilege` DISABLE KEYS */;
REPLACE INTO `privilege` (`id`, `role_id`, `role_name`, `menu_list_id`, `menu_list_name`, `view`, `create`, `edit`, `delete`, `validation`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Developer', 1, 'Group Menu', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:07:43', '2019-07-06 19:07:43'),
	(2, 1, 'Developer', 2, 'Menu List', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:07:43', '2019-07-06 19:07:43'),
	(3, 1, 'Developer', 3, 'Role', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:07:43', '2019-07-06 19:07:43'),
	(4, 1, 'Developer', 4, 'Privilege', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:07:43', '2019-07-06 19:07:43'),
	(5, 2, 'Master Administrator', 1, 'Group Menu', 'false', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:08:23', '2019-07-06 19:39:13'),
	(6, 2, 'Master Administrator', 2, 'Menu List', 'false', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:08:23', '2019-07-06 19:39:22'),
	(7, 2, 'Master Administrator', 3, 'Role', 'false', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:08:23', '2019-07-06 19:39:36'),
	(8, 2, 'Master Administrator', 4, 'Privilege', 'false', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:08:23', '2019-07-06 19:41:30'),
	(9, 3, 'Supervisor Administrator', 1, 'Group Menu', 'false', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:10:27', '2019-07-06 19:41:31'),
	(10, 3, 'Supervisor Administrator', 2, 'Menu List', 'false', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:10:27', '2019-07-06 19:41:33'),
	(11, 3, 'Supervisor Administrator', 3, 'Role', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:10:27', '2019-07-06 19:10:27'),
	(12, 3, 'Supervisor Administrator', 4, 'Privilege', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:10:27', '2019-07-06 19:10:27'),
	(13, 4, 'Administrator', 1, 'Group Menu', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:10:46', '2019-07-06 19:10:46'),
	(14, 4, 'Administrator', 2, 'Menu List', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:10:46', '2019-07-06 19:10:46'),
	(15, 4, 'Administrator', 3, 'Role', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:10:46', '2019-07-06 19:10:46'),
	(16, 4, 'Administrator', 4, 'Privilege', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:10:46', '2019-07-06 19:10:46'),
	(17, 5, 'Master Agent', 1, 'Group Menu', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:11:03', '2019-07-06 19:11:03'),
	(18, 5, 'Master Agent', 2, 'Menu List', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:11:03', '2019-07-06 19:11:03'),
	(19, 5, 'Master Agent', 3, 'Role', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:11:03', '2019-07-06 19:11:03'),
	(20, 5, 'Master Agent', 4, 'Privilege', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:11:03', '2019-07-06 19:11:03'),
	(21, 6, 'Agent', 1, 'Group Menu', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:11:15', '2019-07-06 19:11:15'),
	(22, 6, 'Agent', 2, 'Menu List', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:11:15', '2019-07-06 19:11:15'),
	(23, 6, 'Agent', 3, 'Role', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:11:15', '2019-07-06 19:11:15'),
	(24, 6, 'Agent', 4, 'Privilege', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:11:15', '2019-07-06 19:11:15'),
	(25, 1, 'Developer', 5, 'Administrator User', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:13:35', '2019-07-06 19:13:35'),
	(26, 2, 'Master Administrator', 5, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:13:35', '2019-07-06 19:13:35'),
	(27, 3, 'Supervisor Administrator', 5, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:13:35', '2019-07-06 19:13:35'),
	(28, 4, 'Administrator', 5, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:13:35', '2019-07-06 19:13:35'),
	(29, 5, 'Master Agent', 5, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:13:35', '2019-07-06 19:13:35'),
	(30, 6, 'Agent', 5, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:13:35', '2019-07-06 19:13:35'),
	(31, 1, 'Developer', 6, 'Agent User', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:14:10', '2019-07-06 19:14:10'),
	(32, 2, 'Master Administrator', 6, 'Agent User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:10', '2019-07-06 19:14:10'),
	(33, 3, 'Supervisor Administrator', 6, 'Agent User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:10', '2019-07-06 19:14:10'),
	(34, 4, 'Administrator', 6, 'Agent User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:10', '2019-07-06 19:14:10'),
	(35, 5, 'Master Agent', 6, 'Agent User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:10', '2019-07-06 19:14:10'),
	(36, 6, 'Agent', 6, 'Agent User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:10', '2019-07-06 19:14:10'),
	(37, 1, 'Developer', 7, 'Destination', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:14:59', '2019-07-06 19:14:59'),
	(38, 2, 'Master Administrator', 7, 'Destination', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:59', '2019-07-06 19:14:59'),
	(39, 3, 'Supervisor Administrator', 7, 'Destination', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:59', '2019-07-06 19:14:59'),
	(40, 4, 'Administrator', 7, 'Destination', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:59', '2019-07-06 19:14:59'),
	(41, 5, 'Master Agent', 7, 'Destination', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:59', '2019-07-06 19:14:59'),
	(42, 6, 'Agent', 7, 'Destination', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:14:59', '2019-07-06 19:14:59'),
	(43, 1, 'Developer', 8, 'Additional', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:15:34', '2019-07-06 19:15:34'),
	(44, 2, 'Master Administrator', 8, 'Additional', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:15:34', '2019-07-06 19:15:34'),
	(45, 3, 'Supervisor Administrator', 8, 'Additional', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:15:34', '2019-07-06 19:15:34'),
	(46, 4, 'Administrator', 8, 'Additional', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:15:34', '2019-07-06 19:15:34'),
	(47, 5, 'Master Agent', 8, 'Additional', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:15:34', '2019-07-06 19:15:34'),
	(48, 6, 'Agent', 8, 'Additional', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:15:34', '2019-07-06 19:15:34'),
	(49, 1, 'Developer', 9, 'Itinerary', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:17:59', '2019-07-06 19:17:59'),
	(50, 2, 'Master Administrator', 9, 'Itinerary', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:17:59', '2019-07-06 19:17:59'),
	(51, 3, 'Supervisor Administrator', 9, 'Itinerary', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:17:59', '2019-07-06 19:17:59'),
	(52, 4, 'Administrator', 9, 'Itinerary', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:17:59', '2019-07-06 19:17:59'),
	(53, 5, 'Master Agent', 9, 'Itinerary', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:17:59', '2019-07-06 19:17:59'),
	(54, 6, 'Agent', 9, 'Itinerary', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:17:59', '2019-07-06 19:17:59'),
	(55, 1, 'Developer', 10, 'Tour Leader', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:18:49', '2019-07-06 19:18:49'),
	(56, 2, 'Master Administrator', 10, 'Tour Leader', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:18:49', '2019-07-06 19:18:49'),
	(57, 3, 'Supervisor Administrator', 10, 'Tour Leader', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:18:49', '2019-07-06 19:18:49'),
	(58, 4, 'Administrator', 10, 'Tour Leader', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:18:49', '2019-07-06 19:18:49'),
	(59, 5, 'Master Agent', 10, 'Tour Leader', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:18:49', '2019-07-06 19:18:49'),
	(60, 6, 'Agent', 10, 'Tour Leader', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:18:49', '2019-07-06 19:18:49'),
	(61, 1, 'Developer', 11, 'Administrator User', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:23:53', '2019-07-06 19:23:53'),
	(62, 2, 'Master Administrator', 11, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:23:53', '2019-07-06 19:23:53'),
	(63, 3, 'Supervisor Administrator', 11, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:23:53', '2019-07-06 19:23:53'),
	(64, 4, 'Administrator', 11, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:23:53', '2019-07-06 19:23:53'),
	(65, 5, 'Master Agent', 11, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:23:53', '2019-07-06 19:23:53'),
	(66, 6, 'Agent', 11, 'Administrator User', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:23:53', '2019-07-06 19:23:53'),
	(67, 1, 'Developer', 11, 'Income Report', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:30:34', '2019-07-06 19:30:34'),
	(68, 2, 'Master Administrator', 11, 'Income Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:34', '2019-07-06 19:30:34'),
	(69, 3, 'Supervisor Administrator', 11, 'Income Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:34', '2019-07-06 19:30:34'),
	(70, 4, 'Administrator', 11, 'Income Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:34', '2019-07-06 19:30:34'),
	(71, 5, 'Master Agent', 11, 'Income Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:35', '2019-07-06 19:30:35'),
	(72, 6, 'Agent', 11, 'Income Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:35', '2019-07-06 19:30:35'),
	(73, 1, 'Developer', 12, 'Income Statement', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:30:58', '2019-07-06 19:30:58'),
	(74, 2, 'Master Administrator', 12, 'Income Statement', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:58', '2019-07-06 19:30:58'),
	(75, 3, 'Supervisor Administrator', 12, 'Income Statement', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:58', '2019-07-06 19:30:58'),
	(76, 4, 'Administrator', 12, 'Income Statement', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:58', '2019-07-06 19:30:58'),
	(77, 5, 'Master Agent', 12, 'Income Statement', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:58', '2019-07-06 19:30:58'),
	(78, 6, 'Agent', 12, 'Income Statement', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:30:58', '2019-07-06 19:30:58'),
	(79, 1, 'Developer', 13, 'Sales Statistic', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:33:12', '2019-07-06 19:33:12'),
	(80, 2, 'Master Administrator', 13, 'Sales Statistic', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:33:12', '2019-07-06 19:33:12'),
	(81, 3, 'Supervisor Administrator', 13, 'Sales Statistic', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:33:12', '2019-07-06 19:33:12'),
	(82, 4, 'Administrator', 13, 'Sales Statistic', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:33:12', '2019-07-06 19:33:12'),
	(83, 5, 'Master Agent', 13, 'Sales Statistic', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:33:12', '2019-07-06 19:33:12'),
	(84, 6, 'Agent', 13, 'Sales Statistic', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:33:12', '2019-07-06 19:33:12'),
	(85, 1, 'Developer', 14, 'Customer Report', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:34:10', '2019-07-06 19:34:10'),
	(86, 2, 'Master Administrator', 14, 'Customer Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:10', '2019-07-06 19:34:10'),
	(87, 3, 'Supervisor Administrator', 14, 'Customer Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:10', '2019-07-06 19:34:10'),
	(88, 4, 'Administrator', 14, 'Customer Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:10', '2019-07-06 19:34:10'),
	(89, 5, 'Master Agent', 14, 'Customer Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:10', '2019-07-06 19:34:10'),
	(90, 6, 'Agent', 14, 'Customer Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:10', '2019-07-06 19:34:10'),
	(91, 1, 'Developer', 15, 'Sales Report', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:34:47', '2019-07-06 19:34:47'),
	(92, 2, 'Master Administrator', 15, 'Sales Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:47', '2019-07-06 19:34:47'),
	(93, 3, 'Supervisor Administrator', 15, 'Sales Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:47', '2019-07-06 19:34:47'),
	(94, 4, 'Administrator', 15, 'Sales Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:47', '2019-07-06 19:34:47'),
	(95, 5, 'Master Agent', 15, 'Sales Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:47', '2019-07-06 19:34:47'),
	(96, 6, 'Agent', 15, 'Sales Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:34:47', '2019-07-06 19:34:47'),
	(97, 1, 'Developer', 16, 'Payment Report', 'true', 'true', 'true', 'true', 'true', 'adi', 'adi', '2019-07-06 19:35:04', '2019-07-06 19:35:04'),
	(98, 2, 'Master Administrator', 16, 'Payment Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:35:04', '2019-07-06 19:35:04'),
	(99, 3, 'Supervisor Administrator', 16, 'Payment Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:35:04', '2019-07-06 19:35:04'),
	(100, 4, 'Administrator', 16, 'Payment Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:35:04', '2019-07-06 19:35:04'),
	(101, 5, 'Master Agent', 16, 'Payment Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:35:04', '2019-07-06 19:35:04'),
	(102, 6, 'Agent', 16, 'Payment Report', 'false', 'false', 'false', 'false', 'false', 'adi', 'adi', '2019-07-06 19:35:04', '2019-07-06 19:35:04');
/*!40000 ALTER TABLE `privilege` ENABLE KEYS */;

-- Dumping structure for table oke_trip.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.role: ~6 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
REPLACE INTO `role` (`id`, `name`, `note`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
	(1, 'Developer', 'Developer Top Level', 'true', 'adi', 'adi', '2019-07-06 19:07:43', '2019-07-06 19:11:24'),
	(2, 'Master Administrator', 'Top Level for Administrator User', 'true', 'adi', 'adi', '2019-07-06 19:08:23', '2019-07-06 19:11:25'),
	(3, 'Supervisor Administrator', 'Below Master Administrator Level', 'true', 'adi', 'adi', '2019-07-06 19:10:27', '2019-07-06 19:12:03'),
	(4, 'Administrator', 'Below Supervisor Administrator Level', 'true', 'adi', 'adi', '2019-07-06 19:10:46', '2019-07-06 19:11:22'),
	(5, 'Master Agent', 'Top Level for Agent user', 'true', 'adi', 'adi', '2019-07-06 19:11:03', '2019-07-06 19:12:01'),
	(6, 'Agent', 'Below Master Agent Level', 'true', 'adi', 'adi', '2019-07-06 19:11:15', '2019-07-06 19:11:23');
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

-- Dumping data for table oke_trip.sessions: ~2 rows (approximately)
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
REPLACE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('77Od0oYzYzRVrJ1jnNgxDa8PmZLlJwCMJakvV2Ig', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYkFSdFVLVFRaQWE4a1REOWJuMll1dWdtWGFmenBMejlTd0tDVFdMWCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRkaXRpb25hbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1562940641),
	('ADFV7Esxk1mr3q5AKZWO444JpzcFBU9h9fEt6JQ7', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRTRkV1d1aU1wQ2RjbVp0VDEwY2RzM21QN1R4RzlQYkYyRVNHUzVZUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRkaXRpb25hbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1562945345),
	('GmyZMGCdibC2kbjcALAXsPkafLk7y6vACdQN6kHX', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiN0xRenoxcUd1dUJiNzUzSldhR3V2WWhtb20ydzZwdGR6Rkhva1VYayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRkaXRpb25hbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1562945258),
	('GyOObTTTFsuNn3I5OoZgCwciiLennOARauuyTsoa', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRms3ZlcxeHFoMHBHbFRTRDVEQ1dkcXI1MVRxelp6bmN4WVhUSlBRbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRkaXRpb25hbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1562945475),
	('ldIheNAyzJrBPKixlceYbq2n0QvXirgl4auzCNCZ', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRUxHMlZCb2MwTWt5cWlnQjZZbmtFWWNDdUdEVVlCWGRaT2QwS3J4QyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRkaXRpb25hbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1562942606),
	('MXa2TtY24C1OyBqTONmkRpXb193ZqS0NirXxX0On', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV3FXWUp5TVA5NE9lczJSTHREQTJDS0x1NjRhMWQ5Y29YclVvU3lOcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRkaXRpb25hbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1562945164),
	('rDP23xkEGiXluegO4ZWMNFwaovHvVXJm0dCrYqFW', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSXozZlczbzh0THQ1ekF0SzVmUURXOTRzeWJYcmZrMmhMZWNZVEVKZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRkaXRpb25hbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1562944123),
	('tinRec6OvGYUicJlZCbPIv6TojFTCsDwFr5895A2', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNXBaYTJZc3RmakVuZXFUNUswcWE3QTNQeFJ0d0VvdnhZVXpUZ01rNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRkaXRpb25hbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1562945614),
	('vNpiixZTxHjx8xXHz3pgagQy7J3sbmEFDhy4oaV4', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV3ppYlh6bUMyTkE4MG9lMzBJV0ZDM05UempiUkZZdldTN3NjbERGMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRkaXRpb25hbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1562945796);
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
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.token_management: ~1 rows (approximately)
/*!40000 ALTER TABLE `token_management` DISABLE KEYS */;
REPLACE INTO `token_management` (`id`, `user_id`, `access_token`, `expired_at`, `is_active`, `created_at`, `updated_at`) VALUES
	(109, 2, 'MmYyNTU1NjAxODVlNWVhYTJiNTUyZjI2M2Q1M2UzNTY3ZmEwMDA1OQ==', '2019-07-13 22:36:36', 1, '2019-07-12 22:36:36', '2019-07-12 22:36:36');
/*!40000 ALTER TABLE `token_management` ENABLE KEYS */;

-- Dumping structure for table oke_trip.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `type_user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table oke_trip.users: ~9 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `api_token`, `remember_token`, `role_id`, `type_user`, `active`, `image`, `created_at`, `updated_at`) VALUES
	(2, 'adi', 'dewa17a@gmail.com', NULL, '$2y$10$5ejufWlc.ZaTSZItqbGsr.1Gix0ElC6WlKHeYVBgjMOz6blBqHIUu', NULL, NULL, 1, 'ADMIN', 'true', '/dist/img/user/admin_tes123_2019-07-10.jpg', '2019-07-06 18:55:05', '2019-07-12 20:04:50'),
	(4, 'tes', 'adiwieli@gmail.com', NULL, '$2y$10$2.0ZJhWP2Z3aXfPxoiDxkOQzHLP7czBWSgLfBUshOfJ4ngEVWN0KG', NULL, NULL, 2, 'ADMIN', 'true', '/dist/img/user/admin_tes_2019-07-09.jpg', '2019-07-09 19:33:30', '2019-07-09 19:33:30'),
	(5, 'tes', 'tes@gmail.com', NULL, '$2y$10$J0Zde4llDOkGwN6G8RDO/eaIM0dkhZwnK1JhOgWfrk8Q0t8KaYK6u', NULL, NULL, 6, 'ADMIN', 'true', '/dist/img/user/admin_tes_2019-07-10.jpg', '2019-07-10 18:55:20', '2019-07-10 18:55:20'),
	(6, 'anjing123', 'anjing@gmail.com', NULL, '$2y$10$lYCTPxLO..uwuFcJ9JnoReQj1laMsNs5uQGbYHdNTmuQOg.Ofj9sa', NULL, NULL, 3, 'ADMIN', 'true', '/dist/img/user/admin_anjing_2019-07-10.jpg', '2019-07-10 18:55:53', '2019-07-12 20:01:56'),
	(7, 'asw', 'asw@gmail.com', NULL, '$2y$10$4DyFe7hke/icfWLIlcxesedSHJPHhiKf0FbQ112w6bouoc0ULCQKO', NULL, NULL, 5, 'ADMIN', 'true', '/dist/img/user/admin_asw_2019-07-10.jpg', '2019-07-10 19:00:16', '2019-07-10 19:00:16'),
	(8, 'tes123', 'tes123@gmail.com', NULL, '$2y$10$eE3A2WUZUq89x0hzv0muuOeQqFYWOzPD0zYfZPuYknUGSfXgVqvZW', NULL, NULL, 4, 'ADMIN', 'true', '/dist/img/user/admin_tes123_2019-07-10.jpg', '2019-07-10 19:03:12', '2019-07-10 19:03:12'),
	(9, 'asd123', 'asd123@gmail.com', NULL, '$2y$10$GmSTdlP0QE4pTaBVGfUYOeRBapAxw96HDSxVQT6.32MXaHv5JSZwy', NULL, NULL, 5, 'ADMIN', 'true', '/dist/img/user/admin_asd123_2019-07-10.jpg', '2019-07-10 19:03:55', '2019-07-10 19:03:55'),
	(10, 'te', 'yui@gmail.com', NULL, '$2y$10$r/UsyGAjTnBOz57BX/LlGOuSROytua96TSd5xGXMnYCd0S0IHL7fS', NULL, NULL, 3, 'ADMIN', 'true', '/dist/img/user/admin_te_2019-07-12.jpg', '2019-07-12 20:07:53', '2019-07-12 20:07:53'),
	(11, 'tr', 'fdg@gmail.com', NULL, '$2y$10$3ox.4pStw1bI27LO6ssp7OMFO4dDcTmNgBpQbDE8EtF23GGqi0/Eu', NULL, NULL, 5, 'AGENT', 'true', '/dist/img/user/admin_tr_2019-07-12.jpg', '2019-07-12 20:09:18', '2019-07-12 20:09:18');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
