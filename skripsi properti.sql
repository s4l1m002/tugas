-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for skripsi_property
DROP DATABASE IF EXISTS `skripsi_property`;
CREATE DATABASE IF NOT EXISTS `skripsi_property` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `skripsi_property`;

-- Dumping structure for table skripsi_property.cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.cache: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.cache_locks: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.contacts
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `property_id` bigint unsigned DEFAULT NULL,
  `marketing_id` bigint unsigned DEFAULT NULL,
  `pelanggan_id` bigint unsigned DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.contacts: ~7 rows (approximately)
INSERT INTO `contacts` (`id`, `property_id`, `marketing_id`, `pelanggan_id`, `pesan`, `status`, `created_at`, `updated_at`) VALUES
	(1, 8, 4, 7, NULL, 'new', NULL, NULL),
	(2, 8, 4, 7, NULL, 'new', NULL, NULL),
	(3, 8, 4, 7, NULL, 'new', NULL, NULL),
	(4, 8, 4, 7, NULL, 'new', NULL, NULL),
	(5, 10, 4, 7, NULL, 'new', NULL, NULL),
	(6, 13, 4, 7, NULL, 'new', NULL, NULL),
	(7, 14, 4, 7, NULL, 'new', NULL, NULL),
	(8, 13, 4, 7, NULL, 'new', NULL, NULL);

-- Dumping structure for table skripsi_property.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.jobs: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.job_batches: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.migrations: ~12 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_11_12_000522_create_properties_table', 2),
	(5, '2025_11_12_000724_add_role_to_users_table', 2),
	(6, '2025_11_12_124037_create_contacts_table', 3),
	(9, '2025_11_13_012922_add_status_to_tabel_property', 4),
	(18, '2025_11_12_000522_create_property_table', 5),
	(19, '2025_11_15_114604_create_tabel_transaksi_table', 6),
	(20, '2025_11_25_091148_add_role_column_to_users_table', 6),
	(21, '2025_12_21_065126_rename_marketing_id_to_user_id_in_properties', 6),
	(22, '2025_12_22_070929_recreate_properties_table', 6),
	(23, '2025_12_23_124504_create_notifications_table', 7),
	(24, '2025_12_26_130000_fix_contacts_table', 8),
	(25, '2025_12_27_000000_add_payment_fields_to_tabel_transaksi', 9),
	(26, '2025_12_28_000000_add_bukti_to_tabel_transaksi', 10),
	(27, '2025_12_29_000000_add_visited_to_properties', 11),
	(28, '2026_01_05_000000_add_documents_to_properties', 12),
	(29, '2026_01_05_000001_add_commission_tax_to_tabel_transaksi', 12),
	(30, '2026_01_05_000002_backfill_documents_from_transactions', 13);

-- Dumping structure for table skripsi_property.notifications
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.notifications: ~53 rows (approximately)
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
	('0234431d-7635-4bc2-9dc9-1982ade6cfe6', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":4,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', '2025-12-27 04:39:49', '2025-12-27 02:36:33', '2025-12-27 04:39:49'),
	('0d6ceb06-db71-48dc-9a59-742d303d855f', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 3, '{"property_id":14,"judul":"rahayu","text":"Properti baru menunggu persetujuan: rahayu"}', NULL, '2025-12-27 18:14:05', '2025-12-27 18:14:05'),
	('163d147c-e56b-4676-b03b-29c9f3b89cae', 'App\\Notifications\\PaymentConfirmed', 'App\\Models\\User', 7, '{"type":"payment_confirmed","transaction_id":2,"property_id":10,"message":"Pembayaran untuk properti ID 10 telah dikonfirmasi lunas.","text":"<strong>Pembayaran Dikonfirmasi<\\/strong><br>Transaksi #2 untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/10\\">#10<\\/a> telah LUNAS."}', NULL, '2026-01-14 03:52:46', '2026-01-14 03:52:46'),
	('1b2b2948-c7db-4293-aca0-3b478e8ba675', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":7,"property_id":14,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 14 dari Pelanggan Tester."}', NULL, '2025-12-28 06:50:28', '2025-12-28 06:50:28'),
	('1dc3e60f-f3d6-40b2-9068-647f28ad4387', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 3, '{"property_id":11,"judul":"rumah kopo","text":"Properti baru menunggu persetujuan: rumah kopo"}', NULL, '2025-12-26 18:40:26', '2025-12-26 18:40:26'),
	('22e0ae92-8a8c-4e15-9522-04b7967d8dbb', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 6, '{"property_id":16,"judul":"rumah pasteur","text":"Properti baru menunggu persetujuan: rumah pasteur"}', NULL, '2025-12-28 06:54:11', '2025-12-28 06:54:11'),
	('286cb222-90fa-4ac8-8e29-44ddf6967e53', 'App\\Notifications\\PaymentSubmitted', 'App\\Models\\User', 6, '{"type":"payment_submitted","transaction_id":2,"property_id":10,"pelanggan_id":7,"payment_method":"transfer","rekening":"123456789","message":"Pelanggan telah mengirim bukti pembayaran untuk properti ID 10","text":"<strong>Pembayaran Diterima<\\/strong><br>Pelanggan telah melaporkan pembayaran untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/10\\">#10<\\/a>. Metode: transfer (Rek: 123456789)"}', '2025-12-27 22:11:54', '2025-12-27 21:57:02', '2025-12-27 22:11:54'),
	('2d1cf621-61fa-45c1-944f-9597382b9ab5', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":12,"judul":"rumah kopo","old_status":"pending","new_status":"published","text":"Status properti \'rumah kopo\' berubah dari pending menjadi published"}', NULL, '2025-12-26 21:19:28', '2025-12-26 21:19:28'),
	('31dd3f61-2093-4119-b927-b8ab2125aec3', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":14,"judul":"rahayu","old_status":"pending","new_status":"published","text":"Status properti \'rahayu\' berubah dari pending menjadi published"}', NULL, '2025-12-27 18:39:32', '2025-12-27 18:39:32'),
	('36ad990b-96ae-47fb-9fe3-ec2afee28cf4', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 6, '{"property_id":12,"judul":"rumah kopo","text":"Properti baru menunggu persetujuan: rumah kopo"}', '2026-01-04 08:26:16', '2025-12-26 21:17:56', '2026-01-04 08:26:16'),
	('3f4f8713-41ff-4fa7-b0f4-2f77a0cdfe29', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":9,"judul":"Rumah Minimalis Contoh","old_status":"rejected","new_status":"rejected","text":"Status properti \'Rumah Minimalis Contoh\' berubah dari rejected menjadi rejected"}', NULL, '2026-01-14 03:53:06', '2026-01-14 03:53:06'),
	('41d9c069-b873-48eb-bc97-491dfd9f6531', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":4,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', NULL, '2025-12-27 02:36:30', '2025-12-27 02:36:30'),
	('4936144f-a9f7-42ab-b715-762152f68d69', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 6, '{"property_id":14,"judul":"rahayu","text":"Properti baru menunggu persetujuan: rahayu"}', NULL, '2025-12-27 18:14:05', '2025-12-27 18:14:05'),
	('4b92900f-69d6-4daf-9ad2-0d2ecda05185', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":2,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', NULL, '2025-12-26 04:23:34', '2025-12-26 04:23:34'),
	('4dafba86-6b30-47b3-9923-e6b20186651a', 'App\\Notifications\\PaymentConfirmed', 'App\\Models\\User', 4, '{"type":"payment_confirmed","transaction_id":1,"property_id":8,"message":"Pembayaran untuk properti ID 8 telah dikonfirmasi lunas.","text":"<strong>Pembayaran Dikonfirmasi<\\/strong><br>Transaksi #1 untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/8\\">#8<\\/a> telah LUNAS."}', NULL, '2025-12-28 06:30:51', '2025-12-28 06:30:51'),
	('551d6849-b446-4d3c-9fcf-ef2ef57269a2', 'App\\Notifications\\PaymentSubmitted', 'App\\Models\\User', 3, '{"type":"payment_submitted","transaction_id":3,"property_id":16,"pelanggan_id":7,"payment_method":"transfer","rekening":"123456789","message":"Pelanggan telah mengirim bukti pembayaran untuk properti ID 16","text":"<strong>Pembayaran Diterima<\\/strong><br>Pelanggan telah melaporkan pembayaran untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/16\\">#16<\\/a>. Metode: transfer (Rek: 123456789)"}', NULL, '2025-12-28 06:56:05', '2025-12-28 06:56:05'),
	('5830303b-5962-4a44-bba4-5216db90cfce', 'App\\Notifications\\PaymentRejected', 'App\\Models\\User', 16, '{"type":"payment_rejected","transaction_id":4,"property_id":9,"message":"Pembayaran untuk properti ID 9 ditolak oleh admin.","text":"<strong>Pembayaran Ditolak<\\/strong><br>Transaksi #4 untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/9\\">#9<\\/a> telah DITOLAK."}', NULL, '2026-01-14 04:05:24', '2026-01-14 04:05:24'),
	('5eff676b-fb47-4729-ba3b-aa4bc49dbb56', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":7,"property_id":14,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 14 dari Pelanggan Tester."}', NULL, '2025-12-28 06:50:39', '2025-12-28 06:50:39'),
	('5f223d21-948d-47dc-af9f-978465809bc9', 'App\\Notifications\\PaymentSubmitted', 'App\\Models\\User', 3, '{"type":"payment_submitted","transaction_id":1,"property_id":8,"pelanggan_id":7,"payment_method":"cash","rekening":"123456789","message":"Pelanggan telah mengirim bukti pembayaran untuk properti ID 8","text":"<strong>Pembayaran Diterima<\\/strong><br>Pelanggan telah melaporkan pembayaran untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/8\\">#8<\\/a>. Metode: cash (Rek: 123456789)"}', '2025-12-27 22:10:22', '2025-12-27 21:56:37', '2025-12-27 22:10:22'),
	('602fa18e-422a-4684-8e03-245c665c9f92', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":3,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', NULL, '2025-12-26 19:18:44', '2025-12-26 19:18:44'),
	('674a9b35-b56c-4cf0-b1b4-541addeb2fae', 'App\\Notifications\\PaymentSubmitted', 'App\\Models\\User', 6, '{"type":"payment_submitted","transaction_id":1,"property_id":8,"pelanggan_id":7,"payment_method":"cash","rekening":"123456789","message":"Pelanggan telah mengirim bukti pembayaran untuk properti ID 8","text":"<strong>Pembayaran Diterima<\\/strong><br>Pelanggan telah melaporkan pembayaran untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/8\\">#8<\\/a>. Metode: cash (Rek: 123456789)"}', '2025-12-27 22:10:43', '2025-12-27 21:56:37', '2025-12-27 22:10:43'),
	('694f080a-e9bf-44e3-a5be-488da4571aad', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 3, '{"property_id":13,"judul":"rumah cibaduyut","text":"Properti baru menunggu persetujuan: rumah cibaduyut"}', NULL, '2025-12-27 00:31:32', '2025-12-27 00:31:32'),
	('6b5a0947-c22c-4410-b541-aa3e4aaa9fb9', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":9,"judul":"Rumah Minimalis Contoh","old_status":"rejected","new_status":"rejected","text":"Status properti \'Rumah Minimalis Contoh\' berubah dari rejected menjadi rejected"}', NULL, '2026-01-14 03:52:44', '2026-01-14 03:52:44'),
	('6f3effb0-1be2-455a-ac3a-b4e91b5dd458', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":8,"property_id":13,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 13 dari Pelanggan Tester."}', NULL, '2025-12-28 06:52:09', '2025-12-28 06:52:09'),
	('76045649-698a-4ee9-ab3c-5b2f5628f85f', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":13,"judul":"rumah cibaduyut","old_status":"pending","new_status":"published","text":"Status properti \'rumah cibaduyut\' berubah dari pending menjadi published"}', '2025-12-27 01:07:36', '2025-12-27 00:34:00', '2025-12-27 01:07:36'),
	('79c45bdf-16a2-437d-9e9d-cd7c4d2d4999', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":4,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', '2025-12-26 19:39:06', '2025-12-26 19:18:52', '2025-12-26 19:39:06'),
	('7ee7fd57-17eb-4046-8ade-890090804ed0', 'App\\Notifications\\PaymentSubmitted', 'App\\Models\\User', 6, '{"type":"payment_submitted","transaction_id":4,"property_id":9,"pelanggan_id":16,"payment_method":"transfer","rekening":"123456789","message":"Pelanggan telah mengirim bukti pembayaran untuk properti ID 9","text":"<strong>Pembayaran Diterima<\\/strong><br>Pelanggan telah melaporkan pembayaran untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/9\\">#9<\\/a>. Metode: transfer (Rek: 123456789)"}', NULL, '2026-01-14 03:43:39', '2026-01-14 03:43:39'),
	('8cdd8738-f34c-4a49-9181-820075ffa534', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 6, '{"property_id":15,"judul":"rumah dago","text":"Properti baru menunggu persetujuan: rumah dago"}', NULL, '2025-12-28 06:16:56', '2025-12-28 06:16:56'),
	('94c77c16-bc21-47db-a26a-70de37325b5f', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":4,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', NULL, '2025-12-27 02:36:34', '2025-12-27 02:36:34'),
	('9770c0a2-ce29-4713-a042-77b8ee167b89', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":8,"judul":"Rumah tki","old_status":"pending","new_status":"published","text":"Status properti \'Rumah tki\' berubah dari pending menjadi published"}', '2025-12-24 16:43:24', '2025-12-24 05:08:10', '2025-12-24 16:43:24'),
	('a59b6361-a82c-4ffd-a81e-471de7fd7d53', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 3, '{"property_id":15,"judul":"rumah dago","text":"Properti baru menunggu persetujuan: rumah dago"}', NULL, '2025-12-28 06:16:56', '2025-12-28 06:16:56'),
	('a6989f20-057c-428b-bccd-ebcc6a97b068', 'App\\Notifications\\PaymentSubmitted', 'App\\Models\\User', 3, '{"type":"payment_submitted","transaction_id":4,"property_id":9,"pelanggan_id":16,"payment_method":"transfer","rekening":"123456789","message":"Pelanggan telah mengirim bukti pembayaran untuk properti ID 9","text":"<strong>Pembayaran Diterima<\\/strong><br>Pelanggan telah melaporkan pembayaran untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/9\\">#9<\\/a>. Metode: transfer (Rek: 123456789)"}', NULL, '2026-01-14 03:43:39', '2026-01-14 03:43:39'),
	('a82a0c12-e7f2-4316-bd86-9e193ab76347', 'App\\Notifications\\PaymentConfirmed', 'App\\Models\\User', 4, '{"type":"payment_confirmed","transaction_id":3,"property_id":16,"message":"Pembayaran untuk properti ID 16 telah dikonfirmasi lunas.","text":"<strong>Pembayaran Dikonfirmasi<\\/strong><br>Transaksi #3 untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/16\\">#16<\\/a> telah LUNAS."}', '2025-12-28 18:17:10', '2025-12-28 06:56:43', '2025-12-28 18:17:10'),
	('acc58427-19ec-455e-8b54-8f6769f2c77f', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":9,"judul":"Rumah Minimalis Contoh","old_status":"pending_transaction","new_status":"rejected","text":"Status properti \'Rumah Minimalis Contoh\' berubah dari pending_transaction menjadi rejected"}', NULL, '2026-01-14 03:52:40', '2026-01-14 03:52:40'),
	('ad7ea136-efd7-4966-aa4c-417313e7e9ec', 'App\\Notifications\\PaymentConfirmed', 'App\\Models\\User', 4, '{"type":"payment_confirmed","transaction_id":2,"property_id":10,"message":"Pembayaran untuk properti ID 10 telah dikonfirmasi lunas.","text":"<strong>Pembayaran Dikonfirmasi<\\/strong><br>Transaksi #2 untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/10\\">#10<\\/a> telah LUNAS."}', NULL, '2026-01-14 03:52:47', '2026-01-14 03:52:47'),
	('b06fb248-53e0-45ad-98de-43e43b416c8d', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":15,"judul":"rumah dago","old_status":"pending","new_status":"rejected","text":"Status properti \'rumah dago\' berubah dari pending menjadi rejected"}', NULL, '2025-12-28 06:38:17', '2025-12-28 06:38:17'),
	('b2f7682e-edb4-4b72-8520-2eb95ef4596c', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":8,"property_id":13,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 13 dari Pelanggan Tester."}', '2025-12-28 06:53:12', '2025-12-28 06:52:18', '2025-12-28 06:53:12'),
	('b9317692-cf09-486a-a94c-75ea0825fc17', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":4,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', NULL, '2025-12-27 02:36:33', '2025-12-27 02:36:33'),
	('b9dc09b6-2241-46ea-a1c4-df7c2a5bbfef', 'App\\Notifications\\PaymentConfirmed', 'App\\Models\\User', 7, '{"type":"payment_confirmed","transaction_id":1,"property_id":8,"message":"Pembayaran untuk properti ID 8 telah dikonfirmasi lunas.","text":"<strong>Pembayaran Dikonfirmasi<\\/strong><br>Transaksi #1 untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/8\\">#8<\\/a> telah LUNAS."}', NULL, '2025-12-28 06:30:51', '2025-12-28 06:30:51'),
	('c0eb97c7-e42e-4615-9c4b-8848372acf34', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":16,"judul":"rumah pasteur","old_status":"pending","new_status":"published","text":"Status properti \'rumah pasteur\' berubah dari pending menjadi published"}', NULL, '2025-12-28 06:54:51', '2025-12-28 06:54:51'),
	('c121890a-2255-4558-9c33-c4c1ebb19a48', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 3, '{"property_id":12,"judul":"rumah kopo","text":"Properti baru menunggu persetujuan: rumah kopo"}', NULL, '2025-12-26 21:17:56', '2025-12-26 21:17:56'),
	('c23e2d46-b7e3-4524-a66e-802593ab20a3', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 6, '{"property_id":11,"judul":"rumah kopo","text":"Properti baru menunggu persetujuan: rumah kopo"}', NULL, '2025-12-26 18:40:26', '2025-12-26 18:40:26'),
	('cc057c76-d48a-4aa8-b704-b0680fd92832', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 3, '{"property_id":16,"judul":"rumah pasteur","text":"Properti baru menunggu persetujuan: rumah pasteur"}', '2025-12-28 06:55:07', '2025-12-28 06:54:11', '2025-12-28 06:55:07'),
	('cc3b1ed5-f155-4435-93aa-e0562120fde4', 'App\\Notifications\\PaymentSubmitted', 'App\\Models\\User', 6, '{"type":"payment_submitted","transaction_id":3,"property_id":16,"pelanggan_id":7,"payment_method":"transfer","rekening":"123456789","message":"Pelanggan telah mengirim bukti pembayaran untuk properti ID 16","text":"<strong>Pembayaran Diterima<\\/strong><br>Pelanggan telah melaporkan pembayaran untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/16\\">#16<\\/a>. Metode: transfer (Rek: 123456789)"}', NULL, '2025-12-28 06:56:06', '2025-12-28 06:56:06'),
	('d2ca4bb2-a412-4e1c-824e-ca6519ddc1cc', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":11,"judul":"rumah kopo","old_status":"pending","new_status":"rejected","text":"Status properti \'rumah kopo\' berubah dari pending menjadi rejected"}', '2025-12-26 19:15:36', '2025-12-26 18:41:26', '2025-12-26 19:15:36'),
	('d602cfdd-27e1-46d1-b23a-0196f2cb9951', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":9,"judul":"Rumah Minimalis Contoh","old_status":"rejected","new_status":"rejected","text":"Status properti \'Rumah Minimalis Contoh\' berubah dari rejected menjadi rejected"}', NULL, '2026-01-14 03:53:04', '2026-01-14 03:53:04'),
	('d839f646-fc12-4d9c-a5f4-3e3007ec24ca', 'App\\Notifications\\PaymentSubmitted', 'App\\Models\\User', 3, '{"type":"payment_submitted","transaction_id":2,"property_id":10,"pelanggan_id":7,"payment_method":"transfer","rekening":"123456789","message":"Pelanggan telah mengirim bukti pembayaran untuk properti ID 10","text":"<strong>Pembayaran Diterima<\\/strong><br>Pelanggan telah melaporkan pembayaran untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/10\\">#10<\\/a>. Metode: transfer (Rek: 123456789)"}', NULL, '2025-12-27 21:57:02', '2025-12-27 21:57:02'),
	('db64b7b4-c52f-43bc-ae30-8f6a27f4f008', 'App\\Notifications\\PropertyStatusChanged', 'App\\Models\\User', 4, '{"property_id":9,"judul":"Rumah Minimalis Contoh","old_status":"rejected","new_status":"rejected","text":"Status properti \'Rumah Minimalis Contoh\' berubah dari rejected menjadi rejected"}', NULL, '2026-01-14 03:52:49', '2026-01-14 03:52:49'),
	('db88b1c8-b1bc-4f49-81dc-08d2241858f2', 'App\\Notifications\\PaymentRejected', 'App\\Models\\User', 4, '{"type":"payment_rejected","transaction_id":4,"property_id":9,"message":"Pembayaran untuk properti ID 9 ditolak oleh admin.","text":"<strong>Pembayaran Ditolak<\\/strong><br>Transaksi #4 untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/9\\">#9<\\/a> telah DITOLAK."}', NULL, '2026-01-14 04:05:24', '2026-01-14 04:05:24'),
	('df9dd964-4099-47e9-891d-7437ca8d0bfc', 'App\\Notifications\\NewProperty', 'App\\Models\\User', 6, '{"property_id":13,"judul":"rumah cibaduyut","text":"Properti baru menunggu persetujuan: rumah cibaduyut"}', '2025-12-27 00:53:28', '2025-12-27 00:31:32', '2025-12-27 00:53:28'),
	('e848f45b-6259-419f-8523-1335fff64f4b', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":6,"property_id":13,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 13 dari Pelanggan Tester."}', '2025-12-28 06:15:19', '2025-12-28 06:14:40', '2025-12-28 06:15:19'),
	('ece2fede-a8c6-4a85-9c2e-221ffb400aaa', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":5,"property_id":10,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 10 dari Pelanggan Tester."}', '2025-12-27 04:32:14', '2025-12-27 04:27:40', '2025-12-27 04:32:14'),
	('ee4e2208-43a2-464b-aa30-ad4ffb47b0a2', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":3,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', '2025-12-26 20:49:30', '2025-12-26 04:23:41', '2025-12-26 20:49:30'),
	('f0c5b461-6d4b-4ab3-8cb0-78568421c3c2', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":3,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', NULL, '2025-12-26 19:18:40', '2025-12-26 19:18:40'),
	('fd7e3398-3d71-40c2-ad78-9deba3e29dee', 'App\\Notifications\\PaymentConfirmed', 'App\\Models\\User', 7, '{"type":"payment_confirmed","transaction_id":3,"property_id":16,"message":"Pembayaran untuk properti ID 16 telah dikonfirmasi lunas.","text":"<strong>Pembayaran Dikonfirmasi<\\/strong><br>Transaksi #3 untuk properti <a href=\\"http:\\/\\/127.0.0.1:8000\\/property\\/16\\">#16<\\/a> telah LUNAS."}', '2025-12-28 06:57:04', '2025-12-28 06:56:43', '2025-12-28 06:57:04'),
	('ff0fbce5-2ea9-4d68-9d3b-d792b873d7d6', 'App\\Notifications\\NewContact', 'App\\Models\\User', 4, '{"contact_id":3,"property_id":8,"from_name":"Pelanggan Tester","from_email":"pelanggan@example.test","message":null,"text":"Anda menerima permintaan kontak untuk properti ID: 8 dari Pelanggan Tester."}', '2025-12-26 04:27:17', '2025-12-26 04:25:46', '2025-12-26 04:27:17');

-- Dumping structure for table skripsi_property.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.properties
DROP TABLE IF EXISTS `properties`;
CREATE TABLE IF NOT EXISTS `properties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `luas_tanah` int DEFAULT NULL,
  `luas_bangunan` int DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `imb_complete` tinyint(1) NOT NULL DEFAULT '0',
  `pbb_complete` tinyint(1) NOT NULL DEFAULT '0',
  `sertifikat_complete` tinyint(1) NOT NULL DEFAULT '0',
  `visited` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approved_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.properties: ~7 rows (approximately)
INSERT INTO `properties` (`id`, `user_id`, `judul`, `deskripsi`, `harga`, `alamat`, `luas_tanah`, `luas_bangunan`, `gambar`, `status`, `imb_complete`, `pbb_complete`, `sertifikat_complete`, `visited`, `tanggal_upload`, `approved_by`, `created_at`, `updated_at`) VALUES
	(8, 4, 'Rumah tki', 'nice', 200000000.00, 'tki', 100, 100, 'storage/properties/V00pyD7vmKlOteRPuVgRIv608nfp2EY5IcOLHvjj.jpg', 'sold', 1, 1, 1, 1, '2025-12-24 06:52:46', NULL, '2025-12-23 23:52:46', '2025-12-28 18:16:49'),
	(9, 4, 'Rumah Minimalis Contoh', 'Rumah 2 kamar, lokasi strategis.', 450000000.00, 'Jl. Contoh No.1', 100, 80, 'storage/properties/HhbQjTSWpI5yjVoJ6rpRXJkcihn8Q2OG1wG5bH7H.jpg', 'published', 0, 0, 0, 0, '2025-12-24 07:09:04', NULL, '2025-12-24 00:09:04', '2026-01-14 04:05:24'),
	(10, 4, 'Ruko Siap Pakai', 'Ruko 2 lantai cocok untuk usaha.', 750000000.00, 'Jl. Contoh No.2', 120, 200, 'storage/properties/rumah_minimalis.jpg', 'sold', 1, 1, 1, 0, '2025-12-24 07:09:04', NULL, '2025-12-24 00:09:04', '2026-01-14 03:52:46'),
	(12, 4, 'rumah kopo', 'nicee', 300000000.00, 'kopo', 100, 50, 'storage/properties/yHXo7awqp8qW4ZhligPJMhxgXfsByJ2YtxdgmPmx.jpg', 'published', 0, 0, 0, 0, '2025-12-27 04:17:55', NULL, '2025-12-26 21:17:55', '2025-12-26 21:19:28'),
	(13, 4, 'rumah cibaduyut', 'lt1', 500000000.00, 'cibaduyut', 60, 70, 'storage/properties/V00pyD7vmKlOteRPuVgRIv608nfp2EY5IcOLHvjj.jpg', 'published', 0, 0, 0, 0, '2025-12-27 07:31:31', NULL, '2025-12-27 00:31:31', '2025-12-27 00:33:59'),
	(14, 4, 'rahayu', 'lengkap', 900000000.00, 'rahayu', 80, 80, 'storage/properties/yHXo7awqp8qW4ZhligPJMhxgXfsByJ2YtxdgmPmx.jpg', 'published', 0, 0, 0, 1, '2025-12-28 01:14:05', NULL, '2025-12-27 18:14:05', '2025-12-28 18:16:39'),
	(16, 4, 'rumah pasteur', 'lantai 1,2,3 bagus', 650000000.00, 'pasteur', 60, 50, 'storage/properties/rumah-pasteur_1766930051_69513683b19fe.jpg', 'sold', 1, 1, 1, 1, '2025-12-28 13:54:11', NULL, '2025-12-28 06:54:11', '2025-12-28 18:16:37');

-- Dumping structure for table skripsi_property.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.sessions: ~4 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('e1w9dqamTrfqzKggjqf4D92J4JOy6bGEehI0SrUV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibDhrTUI4Vm5ZRG1mUWwzTG5NazB5c2dsa0V3V21rcVdRUnhLR09LaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774486132),
	('KOIOShGA2dea0OmIOuwKCEKcbLICPJOqYo8MauBE', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZVFxN3dOR0VsZERUMG5RZE1PeGtCOTRvdG9LV3pLb2ZnNVhvRGtwbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZW5kaW5nIjtzOjU6InJvdXRlIjtzOjEzOiJhZG1pbi5wZW5kaW5nIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1768374088),
	('Nk7dc5FfEmkYSvDf2rUXRXhIBZpP4bES5EOAJsH3', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMWFuUEJpZVVDZG8yakZvWlU5NUtSbG5qcTg3UThwelRkclJqSGVKSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYXJrZXRpbmciO3M6NToicm91dGUiO3M6MjY6Im1hcmtldGluZy5wcm9wZXJ0aWVzLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1768298900),
	('OWKqzAowe9hcfD4EK05WCZuVVR4yKypRNBtjMeLz', 16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUGJWeDhibmE5RG02eE5scVBla2lvTzZhcXluSE1mQmVnYVh0dTVLMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ub3RpZmljYXRpb25zIjtzOjU6InJvdXRlIjtzOjE5OiJub3RpZmljYXRpb25zLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTY7fQ==', 1768389133);

-- Dumping structure for table skripsi_property.tabel approval property
DROP TABLE IF EXISTS `tabel approval property`;
CREATE TABLE IF NOT EXISTS `tabel approval property` (
  `approval_id` int NOT NULL,
  `property_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `tanggal_approval` date NOT NULL,
  `status_approval` enum('diterima','ditolak') NOT NULL,
  `catatan` text NOT NULL,
  PRIMARY KEY (`approval_id`),
  KEY `property_id` (`property_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table skripsi_property.tabel approval property: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.tabel komisi
DROP TABLE IF EXISTS `tabel komisi`;
CREATE TABLE IF NOT EXISTS `tabel komisi` (
  `komisi_id` int NOT NULL,
  `transaksi_id` int NOT NULL,
  `marketing_id` int NOT NULL,
  `nilai_komisi` decimal(15,2) NOT NULL,
  `tanggal_hitung` date NOT NULL,
  PRIMARY KEY (`komisi_id`),
  KEY `transaksi_id` (`transaksi_id`),
  KEY `marketing_id` (`marketing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table skripsi_property.tabel komisi: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.tabel kontak
DROP TABLE IF EXISTS `tabel kontak`;
CREATE TABLE IF NOT EXISTS `tabel kontak` (
  `kontak_id` int NOT NULL,
  `pelanggan_id` int NOT NULL,
  `marketing_id` int NOT NULL,
  `pesan` text NOT NULL,
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`kontak_id`),
  KEY `pelanggan_id` (`pelanggan_id`),
  KEY `marketing_id` (`marketing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table skripsi_property.tabel kontak: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.tabel laporan
DROP TABLE IF EXISTS `tabel laporan`;
CREATE TABLE IF NOT EXISTS `tabel laporan` (
  `laporan_id` int NOT NULL,
  `periode` varchar(20) NOT NULL,
  `dibuat_oleh` int NOT NULL,
  `total_transaksi` int NOT NULL,
  `total_komisi` decimal(15,2) NOT NULL DEFAULT (0),
  `total_pajak` decimal(15,2) NOT NULL DEFAULT (0),
  `tanggal_buat` date NOT NULL,
  PRIMARY KEY (`laporan_id`),
  KEY `dibuat_oleh` (`dibuat_oleh`),
  KEY `total_transaksi` (`total_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table skripsi_property.tabel laporan: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.tabel pembayaran komisi
DROP TABLE IF EXISTS `tabel pembayaran komisi`;
CREATE TABLE IF NOT EXISTS `tabel pembayaran komisi` (
  `pembayaran_id` int NOT NULL,
  `komisi_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `metode_bayar` varchar(50) NOT NULL,
  `status_bayar` enum('lunas','belum') NOT NULL,
  PRIMARY KEY (`pembayaran_id`),
  KEY `komisi_id` (`komisi_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table skripsi_property.tabel pembayaran komisi: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.tabel transaksi
DROP TABLE IF EXISTS `tabel transaksi`;
CREATE TABLE IF NOT EXISTS `tabel transaksi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `property_id` bigint unsigned NOT NULL,
  `marketing_id` bigint unsigned NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL,
  `komisi_persen` decimal(5,2) NOT NULL,
  `komisi_marketing` decimal(15,2) NOT NULL,
  `status_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.tabel transaksi: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.tabel transaksi property
DROP TABLE IF EXISTS `tabel transaksi property`;
CREATE TABLE IF NOT EXISTS `tabel transaksi property` (
  `transaksi_id` int NOT NULL,
  `property_id` int NOT NULL,
  `pelanggan_id` int NOT NULL,
  `marketing_id` int NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT (0),
  `status_transaksi` enum('proses','selesai','batal') NOT NULL,
  PRIMARY KEY (`transaksi_id`),
  KEY `property_id` (`property_id`),
  KEY `pelanggan_id` (`pelanggan_id`),
  KEY `marketing_id` (`marketing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table skripsi_property.tabel transaksi property: ~0 rows (approximately)

-- Dumping structure for table skripsi_property.tabel_transaksi
DROP TABLE IF EXISTS `tabel_transaksi`;
CREATE TABLE IF NOT EXISTS `tabel_transaksi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `property_id` bigint unsigned NOT NULL,
  `marketing_id` bigint unsigned NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL,
  `komisi_persen` decimal(5,2) NOT NULL,
  `komisi_marketing` decimal(15,2) NOT NULL,
  `office_fee` decimal(15,2) DEFAULT NULL,
  `marketing_gross` decimal(15,2) DEFAULT NULL,
  `office_share` decimal(15,2) DEFAULT NULL,
  `marketing_tax` decimal(15,2) DEFAULT NULL,
  `marketing_net` decimal(15,2) DEFAULT NULL,
  `buyer_seller_tax` decimal(15,2) DEFAULT NULL,
  `pembayaran_metode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembayaran_rekening` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pelanggan_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tabel_transaksi_pelanggan_id_foreign` (`pelanggan_id`),
  CONSTRAINT `tabel_transaksi_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.tabel_transaksi: ~4 rows (approximately)
INSERT INTO `tabel_transaksi` (`id`, `property_id`, `marketing_id`, `tanggal_transaksi`, `harga_jual`, `komisi_persen`, `komisi_marketing`, `office_fee`, `marketing_gross`, `office_share`, `marketing_tax`, `marketing_net`, `buyer_seller_tax`, `pembayaran_metode`, `pembayaran_rekening`, `bukti`, `status_pembayaran`, `created_at`, `updated_at`, `pelanggan_id`) VALUES
	(1, 8, 4, '2025-12-28', 200000000.00, 2.00, 4000000.00, NULL, NULL, NULL, NULL, NULL, NULL, 'cash', '123456789', NULL, 'paid', '2025-12-27 21:56:37', '2025-12-28 06:30:51', 7),
	(2, 10, 4, '2025-12-28', 750000000.00, 2.00, 15000000.00, 22500000.00, 15750000.00, 6750000.00, 393750.00, 15356250.00, 56250000.00, 'transfer', '123456789', NULL, 'paid', '2025-12-27 21:57:02', '2026-01-14 03:52:46', 7),
	(3, 16, 4, '2025-12-28', 650000000.00, 2.00, 13000000.00, NULL, NULL, NULL, NULL, NULL, NULL, 'transfer', '123456789', NULL, 'paid', '2025-12-28 06:56:05', '2025-12-28 06:56:43', 7),
	(4, 9, 4, '2026-01-14', 450000000.00, 2.00, 9000000.00, NULL, NULL, NULL, NULL, NULL, NULL, 'transfer', '123456789', NULL, 'rejected', '2026-01-14 03:43:38', '2026-01-14 04:05:24', 16);

-- Dumping structure for table skripsi_property.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table skripsi_property.users: ~9 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Test User', 'test@example.com', '2025-11-12 18:43:43', '$2y$12$qLH6b2JKnyXxyJujf/rrcuDH8fsrF63nbF/Q7hFBo.IYLGdqcxrMq', 'pelanggan', 'f6R6LmI31J', '2025-11-12 18:43:44', '2025-12-23 05:04:43'),
	(2, 'admin', 'admin@gmail.com', NULL, '$2y$12$HkLh5Ees1eG3Xj3rdEVkz.oPKduaH9cZj8km2hWpoAGJYWhPziv.y', 'pelanggan', NULL, '2025-11-25 03:50:44', '2025-12-23 05:04:43'),
	(3, 'Admin Tester', 'admin@example.test', NULL, '$2y$12$uwWL/.SkBk/srslR8xM1Ne2waNMKCguQgnOfG8MeY8BayJC4cYs/O', 'admin', NULL, '2025-12-23 05:04:11', '2025-12-24 04:48:13'),
	(4, 'Marketing Tester', 'marketing@example.test', NULL, '$2y$12$o3M0RHSq/l.zpqRlj0PEuePTVf6krY4b4Ffg/6VMKiHQqrU3QV2Za', 'marketing', NULL, '2025-12-23 05:04:11', '2025-12-24 04:48:13'),
	(5, 'Pajak', 'pajak@example.test', NULL, '$2y$12$I3I7cS9f.HWg8F8mFYYMR.MvC/8EXTGaUHSu3shzlSuKOn39pdob.', 'pelanggan', NULL, '2025-12-23 05:04:11', '2025-12-23 05:04:43'),
	(6, 'Ketua Tester', 'ketua@example.test', NULL, '$2y$12$5RZ/AOQaEeIbbBwnGRMJu.ozYDBn4BGtgCE.xlkZcV70fBNSSuaH6', 'ketua', NULL, '2025-12-23 05:04:11', '2025-12-24 04:48:14'),
	(7, 'Pelanggan Tester', 'pelanggan@example.test', NULL, '$2y$12$3.bL42iZSRum8zIdi/bzCeaZrIen6ezD4wMJNxeMGHCCy1n3ZRlRS', 'pelanggan', NULL, '2025-12-23 05:04:11', '2025-12-24 04:48:14'),
	(8, 'pengguna', 'pengguna@gmail.com', NULL, '$2y$12$q/LdVRuZHWhtQH.cp/sNTOs8oPuIIjX51PbJ1Q8IrEq6doyhan1gu', 'pelanggan', NULL, '2025-12-23 03:24:51', '2025-12-23 05:04:43'),
	(9, 'pelanggan', 'pelanggan@gmail.com', NULL, '$2y$12$PK59OWscIHnVsXvev3K2H.dqlAqLdL8MQbR2NHMvM2epkYTEMiieu', 'pelanggan', NULL, '2025-12-23 03:25:37', '2025-12-23 05:04:43'),
	(15, 'user', 'user@gmail.com', NULL, '$2y$12$e7ghsxb0CXY3Po6C1YPe3OgF6GyWqF4xli6wewy6TVm9L1Y9P8b/a', 'pelanggan', NULL, '2026-01-06 23:57:05', '2026-01-06 23:57:05'),
	(16, 'iya', 'iya@gmail.com', NULL, '$2y$12$SR0jirfoTw5Mmtu6CSamdOuBcDUTxkhS5dE5yC2NPurdWy1Nq14EW', 'pelanggan', NULL, '2026-01-13 22:58:17', '2026-01-13 22:58:17');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
