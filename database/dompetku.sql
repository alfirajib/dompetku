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


-- Dumping database structure for dompetku
DROP DATABASE IF EXISTS `dompetku`;
CREATE DATABASE IF NOT EXISTS `dompetku` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dompetku`;

-- Dumping data for table dompetku.cache: ~0 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('dompetku_cache_5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1793418484),
	('dompetku_cache_5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1793418484;', 1793418484);

-- Dumping data for table dompetku.cache_locks: ~0 rows (approximately)

-- Dumping data for table dompetku.categories: ~8 rows (approximately)
INSERT INTO `categories` (`id`, `user_id`, `name`, `type`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Gaji', 'income', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(2, 2, 'Freelance', 'income', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(3, 2, 'Bonus', 'income', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(4, 2, 'Makanan', 'expense', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(5, 2, 'Transportasi', 'expense', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(6, 2, 'Tagihan', 'expense', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(7, 2, 'Hiburan', 'expense', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(8, 2, 'Belanja', 'expense', '2026-10-30 20:39:42', '2026-10-30 20:39:42');

-- Dumping data for table dompetku.failed_jobs: ~0 rows (approximately)

-- Dumping data for table dompetku.jobs: ~0 rows (approximately)

-- Dumping data for table dompetku.job_batches: ~0 rows (approximately)

-- Dumping data for table dompetku.migrations: ~1 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_10_30_000001_add_role_to_users_table', 1),
	(5, '2026_10_30_000002_create_categories_table', 1),
	(6, '2026_10_30_000003_create_wallets_table', 1),
	(7, '2026_10_30_000004_create_transactions_table', 1);

-- Dumping data for table dompetku.password_reset_tokens: ~0 rows (approximately)

-- Dumping data for table dompetku.sessions: ~0 rows (approximately)

-- Dumping data for table dompetku.transactions: ~31 rows (approximately)
INSERT INTO `transactions` (`id`, `user_id`, `wallet_id`, `category_id`, `type`, `amount`, `description`, `transaction_date`, `created_at`, `updated_at`) VALUES
	(1, 2, 2, 1, 'income', 5000000.00, 'Gaji bulanan', '2026-10-01', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(2, 2, 2, 2, 'income', 1200000.00, 'Proyek website klien', '2026-10-15', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(3, 2, 1, 4, 'expense', 350000.00, 'Makan mingguan', '2026-10-03', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(4, 2, 3, 4, 'expense', 275000.00, 'Pesan makanan online', '2026-10-12', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(5, 2, 1, 4, 'expense', 420000.00, 'Makan akhir bulan', '2026-10-24', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(6, 2, 3, 5, 'expense', 180000.00, 'Ojek online', '2026-10-05', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(7, 2, 1, 5, 'expense', 150000.00, 'Bensin', '2026-10-18', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(8, 2, 2, 6, 'expense', 750000.00, 'Listrik & internet', '2026-10-08', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(9, 2, 3, 7, 'expense', 120000.00, 'Langganan streaming & game', '2026-10-10', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(10, 2, 2, 8, 'expense', 640000.00, 'Kebutuhan bulanan', '2026-10-20', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(11, 2, 2, 1, 'income', 5000000.00, 'Gaji bulanan', '2026-09-01', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(12, 2, 2, 2, 'income', 1200000.00, 'Proyek website klien', '2026-09-15', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(13, 2, 1, 4, 'expense', 350000.00, 'Makan mingguan', '2026-09-03', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(14, 2, 3, 4, 'expense', 275000.00, 'Pesan makanan online', '2026-09-12', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(15, 2, 1, 4, 'expense', 420000.00, 'Makan akhir bulan', '2026-09-24', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(16, 2, 3, 5, 'expense', 180000.00, 'Ojek online', '2026-09-05', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(17, 2, 1, 5, 'expense', 150000.00, 'Bensin', '2026-09-18', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(18, 2, 2, 6, 'expense', 750000.00, 'Listrik & internet', '2026-09-08', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(19, 2, 3, 7, 'expense', 120000.00, 'Langganan streaming & game', '2026-09-10', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(20, 2, 2, 8, 'expense', 640000.00, 'Kebutuhan bulanan', '2026-09-20', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(21, 2, 2, 1, 'income', 5000000.00, 'Gaji bulanan', '2026-08-01', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(22, 2, 2, 2, 'income', 1200000.00, 'Proyek website klien', '2026-08-15', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(23, 2, 1, 4, 'expense', 350000.00, 'Makan mingguan', '2026-08-03', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(24, 2, 3, 4, 'expense', 275000.00, 'Pesan makanan online', '2026-08-12', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(25, 2, 1, 4, 'expense', 420000.00, 'Makan akhir bulan', '2026-08-24', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(26, 2, 3, 5, 'expense', 180000.00, 'Ojek online', '2026-08-05', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(27, 2, 1, 5, 'expense', 150000.00, 'Bensin', '2026-08-18', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(28, 2, 2, 6, 'expense', 750000.00, 'Listrik & internet', '2026-08-08', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(29, 2, 3, 7, 'expense', 120000.00, 'Langganan streaming & game', '2026-08-10', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(30, 2, 2, 8, 'expense', 640000.00, 'Kebutuhan bulanan', '2026-08-20', '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(31, 2, 3, 3, 'income', 800000.00, 'Bonus proyek', '2026-10-22', '2026-10-30 20:39:42', '2026-10-30 20:39:42');

-- Dumping data for table dompetku.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'admin@dompetku.test', '2026-10-30 20:39:41', '$2y$12$QcRIMyrJaspaQO1rOXXR0OCANMIzoqVxBzR1/6CwT7Ik5qy6ypv/S', 'admin', 'gNyXSEVzSTto6E7OGJ2uiFLHWOGGDCJnjPwXndrcYqxD8gWd1CJJqMRThDHD', '2026-10-30 20:39:41', '2026-10-30 20:39:41'),
	(2, 'Budi Santoso', 'budi@dompetku.test', '2026-10-30 20:39:42', '$2y$12$TXVR9Gv7lmVxV6StNv46eetvdQTdh5c6Z3e02k6pEwyQlrd22e20W', 'user', NULL, '2026-10-30 20:39:42', '2026-10-30 20:39:42');

-- Dumping data for table dompetku.wallets: ~3 rows (approximately)
INSERT INTO `wallets` (`id`, `user_id`, `name`, `initial_balance`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Dompet Tunai', 500000.00, '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(2, 2, 'Rekening BCA', 2000000.00, '2026-10-30 20:39:42', '2026-10-30 20:39:42'),
	(3, 2, 'E-Wallet', 250000.00, '2026-10-30 20:39:42', '2026-10-30 20:39:42');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
