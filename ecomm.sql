-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2025 at 03:00 PM
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
-- Database: `ecomm`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, NULL, 'GSWJWCifM0u3mwisBaCUYDPtcsRX3Qm5iwqPOA5d', 1, 1, 350.00, '2025-10-22 15:25:14', '2025-10-22 15:25:14'),
(4, 3, NULL, 2, 2, 1200.00, '2025-10-24 06:53:59', '2025-10-24 06:54:07');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Honey', 'honey', 'Pure and organic honey from natural sources', 'categories/1761308138_honey-pot-4d7c98d.jpg', NULL, 1, 0, '2025-10-22 15:21:50', '2025-10-24 06:15:38'),
(2, 'Ghee & Butters', 'ghee-butters', 'Pure ghee and organic butters', 'categories/1761308195_91CVt92XwkL._SL1500_.jpg', NULL, 1, 0, '2025-10-22 15:21:50', '2025-10-24 06:16:35'),
(3, 'Oils', 'oils', 'Cold-pressed and organic oils', 'categories/1761308324_images.jpg', NULL, 1, 0, '2025-10-22 15:21:50', '2025-10-24 06:18:44'),
(4, 'Spices', 'spices', 'Fresh and organic spices', 'categories/1761309495_honey-pot-4d7c98d.jpg', NULL, 1, 0, '2025-10-22 15:21:50', '2025-10-24 06:38:15'),
(5, 'Nuts & Seeds', 'nuts-seeds', 'Premium quality nuts and seeds', 'categories/1761308509_images (1).jpg', NULL, 1, 0, '2025-10-22 15:21:50', '2025-10-24 06:21:49'),
(6, 'Dry Fruits', 'dry-fruits', 'Natural and dried fruits', 'categories/1761308522_images (1).jpg', NULL, 1, 0, '2025-10-22 15:21:50', '2025-10-24 06:22:02'),
(7, 'Sweeteners', 'sweeteners', 'Natural sugar alternatives', 'categories/1761309475_images (2).jpg', NULL, 1, 0, '2025-10-22 15:21:50', '2025-10-24 06:37:55'),
(8, 'Dates', 'dates', NULL, 'categories/1761309957_honey-pot-4d7c98d.jpg', NULL, 1, 0, '2025-10-24 06:45:57', '2025-10-24 06:45:57');

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
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(12, '2019_08_19_000000_create_failed_jobs_table', 1),
(13, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(14, '2025_10_15_111959_create_categories_table', 1),
(15, '2025_10_15_112002_create_products_table', 1),
(16, '2025_10_15_112003_create_carts_table', 1),
(17, '2025_10_15_112005_create_orders_table', 1),
(18, '2025_10_15_112006_create_order_items_table', 1),
(19, '2025_10_23_100625_add_role_to_users_table', 2),
(20, '2025_10_23_110122_add_order_to_categories_table', 3),
(21, '2025_10_23_111431_add_parent_id_to_categories_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `shipping` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `shipping_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`shipping_address`)),
  `billing_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`billing_address`)),
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `subtotal`, `tax`, `shipping`, `total`, `status`, `shipping_address`, `billing_address`, `payment_method`, `payment_status`, `shipped_at`, `delivered_at`, `created_at`, `updated_at`) VALUES
(1, 'ORD-ZBCB1BDI', 1, 350.00, 17.50, 50.00, 417.50, 'pending', '{\"first_name\":\"Bitesoftsolution\",\"last_name\":\"Masud\",\"address\":\"Chittagong\",\"city\":\"ctg\",\"state\":\"fff\",\"zip\":\"3890\",\"phone\":\"01789839899\"}', '{\"first_name\":\"Bitesoftsolution\",\"last_name\":\"Masud\",\"address\":\"Chittagong\",\"city\":\"ctg\",\"state\":\"fff\",\"zip\":\"3890\",\"phone\":\"01789839899\"}', 'bkash', 'pending', NULL, NULL, '2025-10-22 15:30:05', '2025-10-22 15:30:05'),
(2, 'ORD-M24TXMC9', 1, 350.00, 17.50, 50.00, 417.50, 'pending', '{\"first_name\":\"Masud\",\"last_name\":\"Masud\",\"address\":\"Chittagong\",\"city\":\"fgsd\",\"state\":\"rt\",\"zip\":\"3890\",\"phone\":\"01789839899\"}', '{\"first_name\":\"Masud\",\"last_name\":\"Masud\",\"address\":\"Chittagong\",\"city\":\"fgsd\",\"state\":\"rt\",\"zip\":\"3890\",\"phone\":\"01789839899\"}', 'cash_on_delivery', 'pending', NULL, NULL, '2025-10-22 15:30:42', '2025-10-22 15:30:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 350.00, 350.00, '2025-10-22 15:30:05', '2025-10-22 15:30:05'),
(2, 2, 1, 1, 350.00, 350.00, '2025-10-22 15:30:42', '2025-10-22 15:30:42');

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `short_description`, `price`, `compare_price`, `sku`, `quantity`, `is_active`, `is_featured`, `image`, `images`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Pure Wildflower Honey', 'pure-wildflower-honey', '100% pure wildflower honey, natural and unprocessed. Rich in antioxidants and enzymes.', 'Natural wildflower honey', 350.00, 400.00, 'HNY-001', 48, 1, 1, 'products/1761170719_ghee-2-r3kwtq2hjtzui2npuago48s4ehttaedhbbme2xi73k.jpg', '[\"products\\/1761170719_ghee-2-r3kwtq2hjtzui2npuago48s4ehttaedhbbme2xi73k.jpg\"]', 1, '2025-10-22 15:21:50', '2025-10-22 16:05:19'),
(2, 'Manuka Honey UMF 10+', 'manuka-honey-umf-10', 'Premium manuka honey with UMF 10+ rating. Known for its health benefits.', 'Premium manuka honey', 1200.00, NULL, 'HNY-002', 20, 1, 1, 'products/1761170733_Designer-r3kwtry5xi2f5akzjb9x98b1l9kjpskxzkxd1hfer4.jpeg', NULL, 1, '2025-10-22 15:21:50', '2025-10-22 16:05:33'),
(3, 'Acacia Honey', 'acacia-honey', 'Light and delicate acacia honey with a subtle flavor. Perfect for daily use.', 'Light acacia honey', 450.00, 500.00, 'HNY-003', 30, 1, 0, 'products/1761170746_Designer-r3kwtry5xi2f5akzjb9x98b1l9kjpskxzkxd1hfer4.jpeg', NULL, 1, '2025-10-22 15:21:50', '2025-10-22 16:05:46'),
(4, 'Organic Cow Ghee', 'organic-cow-ghee', 'Pure organic ghee made from grass-fed cow milk. Rich in healthy fats and vitamins.', 'Pure organic cow ghee', 650.00, NULL, 'GGH-001', 40, 1, 1, 'products/1761309535_images (2).jpg', NULL, 2, '2025-10-22 15:21:50', '2025-10-24 06:38:55'),
(5, 'Desi Ghee (100% Pure)', 'desi-ghee-100-pure', 'Traditional desi ghee made using the ancient butter-churning method.', 'Traditional desi ghee', 750.00, 800.00, 'GGH-002', 35, 1, 1, 'products/1761309544_honey-pot-4d7c98d.jpg', NULL, 2, '2025-10-22 15:21:50', '2025-10-24 06:39:04'),
(6, 'Cold-Pressed Mustard Oil', 'cold-pressed-mustard-oil', 'Pure cold-pressed mustard oil, unrefined and organic. Perfect for cooking.', 'Cold-pressed mustard oil', 220.00, 250.00, 'OIL-001', 100, 1, 1, 'products/1761309550_images (1).jpg', NULL, 3, '2025-10-22 15:21:50', '2025-10-24 06:39:10'),
(7, 'Extra Virgin Olive Oil', 'extra-virgin-olive-oil', 'Premium extra virgin olive oil, cold-pressed and organic. Rich in antioxidants.', 'Extra virgin olive oil', 1200.00, NULL, 'OIL-002', 25, 1, 1, 'products/1761309558_91CVt92XwkL._SL1500_.jpg', NULL, 3, '2025-10-22 15:21:50', '2025-10-24 06:39:18'),
(8, 'Coconut Oil (Cold-Pressed)', 'coconut-oil-cold-pressed', 'Organic cold-pressed coconut oil, unrefined and virgin. Great for cooking and skin care.', 'Cold-pressed coconut oil', 280.00, 320.00, 'OIL-003', 60, 1, 0, 'products/1761309565_images.jpg', NULL, 3, '2025-10-22 15:21:50', '2025-10-24 06:39:25'),
(9, 'Premium Turmeric Powder', 'premium-turmeric-powder', 'Pure organic turmeric powder, rich in curcumin. Anti-inflammatory properties.', 'Pure turmeric powder', 150.00, 180.00, 'SPC-001', 80, 1, 1, 'products/1761309655_download.jpg', NULL, 4, '2025-10-22 15:21:50', '2025-10-24 06:40:55'),
(10, 'Ceylon Cinnamon Sticks', 'ceylon-cinnamon-sticks', 'Premium Ceylon cinnamon sticks, known for their sweet and delicate flavor.', 'Ceylon cinnamon sticks', 350.00, NULL, 'SPC-002', 45, 1, 0, 'products/1761309670_ghee-2-r3kwtq2hjtzui2npuago48s4ehttaedhbbme2xi73k.jpg', NULL, 4, '2025-10-22 15:21:50', '2025-10-24 06:41:10'),
(11, 'Kashmiri Red Chilli Powder', 'kashmiri-red-chilli-powder', 'Premium Kashmiri red chilli powder, vibrant red color with mild heat.', 'Kashmiri chilli powder', 200.00, 240.00, 'SPC-003', 55, 1, 0, 'products/1761309684_Designer-r3kwtry5xi2f5akzjb9x98b1l9kjpskxzkxd1hfer4.jpeg', NULL, 4, '2025-10-22 15:21:50', '2025-10-24 06:41:24'),
(12, 'Premium California Almonds', 'premium-california-almonds', 'Premium California almonds, rich in vitamin E and healthy fats.', 'California almonds', 750.00, 800.00, 'NTS-001', 70, 1, 1, NULL, NULL, 5, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(13, 'Premium Cashew Nuts', 'premium-cashew-nuts', 'Premium cashew nuts, rich and buttery flavor. Great for snacking.', 'Premium cashews', 900.00, NULL, 'NTS-002', 40, 1, 1, NULL, NULL, 5, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(14, 'Organic Pumpkin Seeds', 'organic-pumpkin-seeds', 'Organic pumpkin seeds, rich in zinc and magnesium.', 'Organic pumpkin seeds', 320.00, 350.00, 'NTS-003', 30, 1, 0, NULL, NULL, 5, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(15, 'Premium Iranian Dates', 'premium-iranian-dates', 'Premium Iranian dates, naturally sweet and rich in nutrients.', 'Iranian dates', 500.00, 550.00, 'DFR-001', 35, 1, 1, NULL, NULL, 6, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(16, 'Premium Dried Figs', 'premium-dried-figs', 'Premium dried figs, naturally sweet and rich in fiber.', 'Dried figs', 800.00, NULL, 'DFR-002', 20, 1, 0, NULL, NULL, 6, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(17, 'Organic Jaggery', 'organic-jaggery', 'Organic jaggery, unrefined sugar with minerals. Healthier alternative to white sugar.', 'Organic jaggery', 200.00, 230.00, 'SWG-001', 90, 1, 0, NULL, NULL, 7, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(18, 'Premium Raw Honey', 'premium-raw-honey', '100% pure raw honey, unfiltered and unpasteurized preserving all natural enzymes and nutrients.', 'Raw and unprocessed honey', 400.00, 450.00, 'HNY-004', 25, 1, 1, NULL, NULL, 1, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(19, 'Organic Cold-Pressed Coconut Oil', 'organic-cold-pressed-coconut-oil', 'Premium organic coconut oil, cold-pressed and unrefined. Perfect for cooking and skin care.', 'Organic coconut oil', 320.00, NULL, 'OIL-004', 40, 1, 1, NULL, NULL, 3, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(20, 'Premium Kashmiri Saffron', 'premium-kashmiri-saffron', 'The finest Kashmiri saffron threads, known for their rich color and aromatic flavor.', 'Premium saffron', 2500.00, NULL, 'SPC-004', 15, 1, 1, NULL, NULL, 4, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(21, 'Premium Walnuts (California)', 'premium-walnuts-california', 'Premium California walnuts, rich in omega-3 fatty acids and antioxidants.', 'California walnuts', 600.00, 650.00, 'NTS-004', 30, 1, 0, NULL, NULL, 5, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(22, 'Premium Iranian Raisins', 'premium-iranian-raisins', 'Premium quality Iranian raisins, naturally sweet and plump.', 'Iranian raisins', 250.00, 280.00, 'DFR-003', 35, 1, 0, NULL, NULL, 6, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(23, 'Organic Maple Syrup', 'organic-maple-syrup', 'Pure organic maple syrup from Canadian maple trees, rich and natural flavor.', 'Pure organic maple syrup', 850.00, 950.00, 'SWG-002', 25, 1, 1, NULL, NULL, 7, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(24, 'Premium Turmeric & Ginger Powder', 'premium-turmeric-ginger-powder', 'Organic blend of turmeric and ginger powder with anti-inflammatory properties.', 'Turmeric & ginger blend', 280.00, NULL, 'SPC-005', 60, 1, 0, NULL, NULL, 4, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(25, 'Raw Almond Butter', 'raw-almond-butter', 'Creamy raw almond butter made from premium California almonds, no added sugar.', 'Raw almond butter', 420.00, 480.00, 'NTS-005', 45, 1, 1, NULL, NULL, 5, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(26, 'Premium Mixed Dry Fruits', 'premium-mixed-dry-fruits', 'Assorted premium dry fruits including almonds, cashews, pistachios, and raisins.', 'Mixed dry fruits pack', 1200.00, 1350.00, 'DFR-004', 40, 1, 1, NULL, NULL, 6, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(27, 'Cold-Pressed Sesame Oil', 'cold-pressed-sesame-oil', 'Organic cold-pressed sesame oil with rich, nutty flavor perfect for cooking.', 'Cold-pressed sesame oil', 300.00, 350.00, 'OIL-005', 35, 1, 0, NULL, NULL, 3, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(28, 'Premium Matcha Green Tea', 'premium-matcha-green-tea', 'Highest quality ceremonial grade matcha green tea powder from Japan.', 'Ceremonial grade matcha', 1800.00, NULL, 'SPC-006', 20, 1, 1, NULL, NULL, 4, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(29, 'Organic Virgin Olive Oil', 'organic-virgin-olive-oil', 'Premium organic extra virgin olive oil from Mediterranean olives.', 'Organic extra virgin olive oil', 950.00, 1100.00, 'OIL-006', 30, 1, 1, NULL, NULL, 3, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(30, 'Premium Brazilian Coffee Beans', 'premium-brazilian-coffee-beans', 'Premium quality Arabica coffee beans from Brazil with rich aroma and flavor.', 'Premium coffee beans', 750.00, 850.00, 'SPC-007', 25, 1, 1, NULL, NULL, 4, '2025-10-22 15:21:50', '2025-10-22 15:21:50'),
(31, 'Agnes chowdhury', 'agnes-chowdhury', '6gsdgsg', 'afsa', 555.00, 44.00, '34345', 1, 1, 1, 'products/1761169599_2023_05_22_15_25_IMG_1843.JPG', '[\"products\\/1761169679_Designer-r3kwtry5xi2f5akzjb9x98b1l9kjpskxzkxd1hfer4.jpeg\",\"products\\/1761169679_ghee-2-r3kwtq2hjtzui2npuago48s4ehttaedhbbme2xi73k.jpg\",\"products\\/1761169679_hotel 1.jpg\"]', 2, '2025-10-22 15:46:39', '2025-10-22 15:47:59');

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Masud', 'robinctgpoly@gmail.com', NULL, '$2y$12$m0SsIpNcgHMOxYNh3ABfJO/hlBXEeKV98epqzepkvmIJ77HeLyOoW', NULL, '2025-10-22 15:29:23', '2025-10-22 15:29:23', 'user'),
(2, 'Agnes Chowdhury', 'agneschowdhury03@gmail.com', NULL, '$2y$12$DsbggoF0ynJ741XiA03n2uvcgK0yF9QOXJoFeJk7YcHOdC80TMnU2', NULL, '2025-10-23 04:03:24', '2025-10-23 04:03:24', 'user'),
(3, 'Admin User', 'admin@gmail.com', NULL, '$2y$12$AAfhVft/TDrmAd0Fd9ur5uunA6ovSF91ERzJoritVQz2Ifv9FkIQK', NULL, '2025-10-23 04:07:17', '2025-10-23 04:07:35', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_user_id_session_id_index` (`user_id`,`session_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
