-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 06:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websecproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('bit_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"d\";s:12:\"display_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:26:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:7:\"testing\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:7:\"Testing\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:22:\"products_for_customers\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:22:\"Products For Customers\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:5;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"add-users\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:9:\"Add Users\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:10:\"edit-users\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:10:\"Edit Users\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:12:\"delete-users\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:12:\"Delete Users\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:10:\"show-users\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:10:\"Show Users\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:13:\"show-products\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:13:\"Show Products\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"buy-products\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:12:\"Buy Products\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:12:\"add-products\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:12:\"Add Products\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:9;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:13:\"edit-products\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:13:\"Edit Products\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:10;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:15:\"delete-products\";s:1:\"c\";s:3:\"web\";s:1:\"d\";s:15:\"Delete Products\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:11;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:13:\"spatie_manage\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:14:\"spatie_addRole\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:15:\"spatie_editRole\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:20:\"spatie_addPermission\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:21:\"spatie_editPermission\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:23:\"spatie_assignPermission\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:17:\"spatie_assignRole\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:17:\"spatie_deleteRole\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:23:\"spatie_deletePermission\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:20:\"edit_return_requests\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:21;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:18:\"show_users_profile\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:22;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:12:\"manage-users\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:23;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:14:\"manage_sellers\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:24;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:13:\"manage_orders\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:25;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:15:\"manage_products\";s:1:\"c\";s:3:\"web\";s:1:\"d\";N;s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:8:\"Customer\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:7:\"Manager\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:6:\"Seller\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:8:\"Employee\";s:1:\"c\";s:3:\"web\";}}}', 1748277745);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 20, '2025-05-22 13:41:05', '2025-05-22 13:41:05'),
(2, 21, '2025-05-23 10:29:34', '2025-05-23 10:29:34'),
(3, 24, '2025-05-23 14:37:52', '2025-05-23 14:37:52'),
(4, 25, '2025-05-23 16:23:22', '2025-05-23 16:23:22'),
(6, 27, '2025-05-24 03:52:11', '2025-05-24 03:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_24_141318_create_permission_tables', 1),
(5, '2025_05_16_170728_create_oauth_auth_codes_table', 2),
(6, '2025_05_16_170729_create_oauth_access_tokens_table', 2),
(7, '2025_05_16_170730_create_oauth_refresh_tokens_table', 2),
(8, '2025_05_16_170731_create_oauth_clients_table', 2),
(9, '2025_05_16_170732_create_oauth_device_codes_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 21),
(1, 'App\\Models\\User', 28),
(2, 'App\\Models\\User', 27),
(3, 'App\\Models\\User', 26),
(4, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 24),
(4, 'App\\Models\\User', 25),
(5, 'App\\Models\\Users', 1),
(5, 'App\\Models\\User', 6),
(5, 'App\\Models\\User', 7),
(5, 'App\\Models\\User', 8),
(5, 'App\\Models\\User', 9),
(5, 'App\\Models\\User', 10),
(5, 'App\\Models\\User', 11),
(5, 'App\\Models\\User', 12),
(5, 'App\\Models\\User', 13),
(5, 'App\\Models\\User', 14),
(5, 'App\\Models\\User', 15),
(5, 'App\\Models\\User', 16),
(5, 'App\\Models\\User', 17),
(5, 'App\\Models\\User', 18),
(5, 'App\\Models\\User', 19),
(5, 'App\\Models\\User', 20);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) NOT NULL,
  `owner_type` varchar(255) DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect_uris` text NOT NULL,
  `grant_types` text NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_device_codes`
--

CREATE TABLE `oauth_device_codes` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `user_code` char(8) NOT NULL,
  `scopes` text NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` char(80) NOT NULL,
  `access_token_id` char(80) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `cart_id`, `city`, `shipping_address`, `payment_method`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(5, 20, 1, 'IDK', 'IDK BRO', 'cash_on_delivery', 16016, 'accepted', '2025-05-23', '2025-05-24'),
(6, 20, 1, 'IDK', 'IDK BRO', 'cash_on_delivery', 8108, 'accepted', '2025-05-23', '2025-05-24'),
(7, 20, 1, 'IDK', 'IDK BRO', 'cash_on_delivery', 16016, 'pending', '2025-05-23', '2025-05-23'),
(8, 20, 1, 'pls workpls workpls workpls work', 'pls workpls workpls workpls work', 'cash_on_delivery', 80085, 'accepted', '2025-05-24', '2025-05-24'),
(9, 20, 1, 'pls workpls workpls workpls work', 'IDK BRO', 'cash_on_delivery', 16016, 'pending', '2025-05-24', '2025-05-24'),
(10, 20, 1, 'pls workpls workpls workpls work', 'IDK BRO', 'cash_on_delivery', 8466, 'pending', '2025-05-24', '2025-05-24');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `total` int(11) GENERATED ALWAYS AS (`quantity` * `price`) STORED,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_image`, `quantity`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'Testing Name', '89.jpeg', 2, 8008, NULL, '2025-05-23 00:28:53', '2025-05-23 00:28:53'),
(2, 6, 2, 'idk', 'idk', 1, 100, NULL, '2025-05-23 03:50:18', '2025-05-23 03:50:18'),
(3, 6, 1, 'Testing Name', '89.jpeg', 1, 8008, NULL, '2025-05-23 03:50:18', '2025-05-23 03:50:18'),
(4, 7, 1, 'Testing Name', '89.jpeg', 2, 8008, NULL, '2025-05-23 04:25:34', '2025-05-23 04:25:34'),
(6, 9, 1, 'Testing Name', '89.jpeg', 2, 8008, NULL, '2025-05-24 06:45:19', '2025-05-24 06:45:19'),
(7, 10, 7, 'TESTING AGAIN', 'TESTING ONCE MORE', 2, 900, NULL, '2025-05-24 06:49:35', '2025-05-24 06:49:35'),
(8, 10, 8, 'bbbbbbbbbb', '6666.png', 1, 6666, NULL, '2025-05-24 06:49:35', '2025-05-24 06:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'testing', 'web', 'Testing', '2025-05-15 17:07:57', '2025-05-15 17:07:57'),
(2, 'products_for_customers', 'web', 'Products For Customers', '2025-05-23 07:13:36', '2025-05-23 07:13:36'),
(3, 'add-users', 'web', 'Add Users', '2025-05-23 10:30:42', '2025-05-23 10:30:42'),
(4, 'edit-users', 'web', 'Edit Users', '2025-05-23 10:30:42', '2025-05-23 10:30:42'),
(5, 'delete-users', 'web', 'Delete Users', '2025-05-23 10:30:42', '2025-05-23 10:30:42'),
(6, 'show-users', 'web', 'Show Users', '2025-05-23 10:30:42', '2025-05-23 10:30:42'),
(7, 'show-products', 'web', 'Show Products', '2025-05-23 10:30:42', '2025-05-23 10:30:42'),
(8, 'buy-products', 'web', 'Buy Products', '2025-05-23 10:30:42', '2025-05-23 10:30:42'),
(17, 'add-products', 'web', 'Add Products', '2025-05-23 14:02:50', '2025-05-23 14:02:50'),
(18, 'edit-products', 'web', 'Edit Products', '2025-05-23 14:02:50', '2025-05-23 14:02:50'),
(19, 'delete-products', 'web', 'Delete Products', '2025-05-23 14:02:50', '2025-05-23 14:02:50'),
(21, 'spatie_manage', 'web', 'Spatie Manage', '2025-05-25 12:11:38', '2025-05-25 12:11:38'),
(22, 'spatie_addRole', 'web', 'Spatie Add Role', '2025-05-25 12:11:55', '2025-05-25 12:11:55'),
(23, 'spatie_editRole', 'web', 'Spatie Edit Role', '2025-05-25 12:12:19', '2025-05-25 12:12:19'),
(24, 'spatie_addPermission', 'web', 'Spatie Add Permission', '2025-05-25 12:12:33', '2025-05-25 12:12:33'),
(25, 'spatie_editPermission', 'web', 'Spatie Edit Permission', '2025-05-25 12:12:51', '2025-05-25 12:12:51'),
(26, 'spatie_assignPermission', 'web', 'Spatie Assign Permission', '2025-05-25 12:13:08', '2025-05-25 12:13:08'),
(27, 'spatie_assignRole', 'web', 'Spatie Assign Role', '2025-05-25 12:13:19', '2025-05-25 12:13:19'),
(28, 'spatie_deleteRole', 'web', 'Spatie Delete Role', '2025-05-25 12:13:30', '2025-05-25 12:13:30'),
(29, 'spatie_deletePermission', 'web', 'Spatie Delete Permission', '2025-05-25 12:13:54', '2025-05-25 12:13:54'),
(30, 'edit_return_requests', 'web', 'Edit Return Requests', '2025-05-25 12:20:39', '2025-05-25 12:20:39'),
(31, 'show_users_profile', 'web', 'Show Users Profile', '2025-05-25 12:58:57', '2025-05-25 12:58:57'),
(32, 'manage-users', 'web', 'Manage Users', '2025-05-25 13:00:24', '2025-05-25 13:00:24'),
(33, 'manage_sellers', 'web', 'Manage Sellers', '2025-05-25 13:14:24', '2025-05-25 13:14:24'),
(34, 'manage_orders', 'web', 'Manage Orders', '2025-05-25 13:14:47', '2025-05-25 13:14:47'),
(35, 'manage_products', 'web', 'Manage Products', '2025-05-25 13:15:33', '2025-05-25 13:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `model` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `price`, `stock`, `model`, `description`, `seller_id`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Testing Code', 'Testing Name', 8008, 8006, 'Testing Model', 'Testing Description', 22, '89.jpeg', 'approved', '2025-05-15', '2025-05-24', NULL),
(2, 'idk', 'idk', 100, 100, 'idk', 'idk', 22, 'idk', 'approved', '2025-05-21', '2025-05-24', NULL),
(7, '900', 'TESTING AGAIN', 900, 898, '9002B', '9002B', 25, 'TESTING ONCE MORE', 'approved', '2025-05-24', '2025-05-24', NULL),
(8, '6666bbbb', 'bbbbbbbbbb', 6666, 6665, '6666bbbbb', '60000bbbbbbbbb', 25, '6666.png', 'approved', '2025-05-24', '2025-05-24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2025-05-15 15:43:24', '2025-05-15 15:43:24'),
(2, 'Manager', 'web', '2025-05-15 15:44:00', '2025-05-15 15:44:00'),
(3, 'Employee', 'web', '2025-05-15 15:44:00', '2025-05-15 15:44:00'),
(4, 'Seller', 'web', '2025-05-15 15:44:49', '2025-05-15 15:44:49'),
(5, 'Customer', 'web', '2025-05-15 15:44:49', '2025-05-15 15:44:49'),
(6, 'Banned', 'web', '2025-05-15 15:45:02', '2025-05-24 09:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 5),
(2, 1),
(2, 5),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 4),
(8, 1),
(17, 1),
(17, 4),
(18, 1),
(18, 4),
(19, 1),
(19, 4),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(30, 3),
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(31, 5),
(32, 1),
(32, 2),
(33, 1),
(33, 3),
(34, 1),
(34, 3),
(35, 1),
(35, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ITsnJHA725na7ZIQfCnIURRfiqiw6wLQ6Bvny8fG', 20, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT2RLeGROVjJtRzgwb1ZSc1dGOHBTRWR0akswaGVpUUh3WGxTU0xCZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovL2JpdC5sb2NhbC5jb20vcHJvZHVjdHMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyODoiaHR0cDovL2JpdC5sb2NhbC5jb20vcHJvZmlsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIwO30=', 1748191464);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `force_change_password` tinyint(1) DEFAULT 0,
  `credit` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `google_id` text DEFAULT NULL,
  `google_token` text DEFAULT NULL,
  `google_refresh_token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `force_change_password`, `credit`, `remember_token`, `google_id`, `google_token`, `google_refresh_token`, `created_at`, `updated_at`) VALUES
(20, 'Belal', 'bellobelal2018@gmail.com', '2025-05-04 14:45:13', '$2y$12$lUWrkm0xjfsn6tcmzvfB3OuZ6Z2W66K6a9Bq0as3oX6ePCIB24QNa', 0, 80000, NULL, NULL, NULL, NULL, '2025-05-22 13:41:05', '2025-05-22 13:41:05'),
(21, 'galal galal', 'ga8616401@gmail.com', '2025-05-04 14:45:21', '$2y$12$vewAwFUG40L.7ML/4q6.8ubOEaeLOuKgFBLmvBmViVrsv3Qd2nx8O', 0, 80000, NULL, NULL, NULL, NULL, '2025-05-23 10:29:34', '2025-05-23 10:29:34'),
(22, 'seller 1', 'seller1@gmail.com', '2025-05-04 14:45:24', '$2y$12$2sUqnRiMjKEmWsdZtM5gEuF42wdTg8pgybeNzJE0XngP3dtk5YZKS', 0, 80000, NULL, NULL, NULL, NULL, '2025-05-23 10:44:56', '2025-05-23 10:44:56'),
(24, 'seller 2', 'seller2@gmail.com', '2025-05-04 14:45:26', '$2y$12$rhDmYgrx7UNh/VOR9k.HyOY9F.88/.w1xn6otW5klp4uNo1NVYKqq', 0, 80000, NULL, NULL, NULL, NULL, '2025-05-23 14:37:52', '2025-05-23 14:37:52'),
(25, 'Belal', 'belalmine223@gmail.com', '2025-05-04 14:45:29', '$2y$12$DojOJigops1YXk/G2hRUqObBoIOI4LJbcN837Z6dVfQbG9zb5N.oK', 0, 80000, NULL, NULL, NULL, NULL, '2025-05-23 16:23:21', '2025-05-23 16:23:21'),
(26, 'Belal', 'belal@belal.com', '2025-05-04 14:45:32', '$2y$12$zpIOfg1lzmYmz2c1N2LmregeFjdDnMZ3KSzgOce2sbvffiKuD4w8S', 0, 80000, NULL, NULL, NULL, NULL, '2025-05-24 02:42:12', '2025-05-24 02:42:12'),
(27, 'Belal', 'belal@belal2.com', '2025-05-04 14:45:35', '$2y$12$mhDtT5YYN.FlP8ITpbkKYuYI2XVivNJmGktJkXSEnDJG3Sr8dneTa', 0, 80000, NULL, NULL, NULL, NULL, '2025-05-24 03:52:11', '2025-05-24 03:52:11'),
(28, 'Admin', 'Admin@Admin.com', '2025-05-04 14:45:38', '$2y$12$m18gNjrwxhlQBIeBOVeNGuaK4hRFbHwGsvMMnCI6k8KMY8zFNwXgC', 0, 80000, NULL, NULL, NULL, NULL, '2025-05-24 08:21:47', '2025-05-24 08:21:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`);

--
-- Indexes for table `oauth_device_codes`
--
ALTER TABLE `oauth_device_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  ADD KEY `oauth_device_codes_user_id_index` (`user_id`),
  ADD KEY `oauth_device_codes_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_seller_id` (`seller_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_seller_id` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
