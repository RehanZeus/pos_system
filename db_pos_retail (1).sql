-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2026 at 06:28 AM
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
-- Database: `db_pos_retail`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `deleted_at`) VALUES
(7, 'Sembako', NULL),
(8, 'Minuman Kemasan', NULL),
(9, 'Makanan Ringan', NULL),
(10, 'Bumbu & Bahan Masak', NULL),
(11, 'Perawatan Tubuh', NULL),
(12, 'Kebersihan Rumah', NULL),
(13, 'ATK', NULL),
(14, 'Rokok', NULL),
(15, 'Susu & Olahan', NULL),
(16, 'Frozen Food', NULL),
(17, 'Mie Instan', NULL),
(18, 'Produk Grosir (Dus)', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-01-10-110858', 'App\\Database\\Migrations\\InitialUsers', 'default', 'App', 1768044558, 1),
(2, '2026-01-10-110906', 'App\\Database\\Migrations\\InitialInventory', 'default', 'App', 1768044558, 1),
(3, '2026-01-10-110916', 'App\\Database\\Migrations\\InitialSales', 'default', 'App', 1768044558, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `purchase_price` decimal(10,2) DEFAULT 0.00,
  `barcode` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `purchase_price`, `barcode`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, 7, 11000.00, '899111001', 'Beras Ramos 5kg - Topi Koki', 'Beras premium 5kg', 13000.00, 60, NULL, '2026-01-12 15:33:37', '2026-01-12 15:33:37', NULL),
(15, 7, 12500.00, '899111002', 'Gula Pasir 1kg - Gulaku', 'Gula pasir kristal', 14500.00, 80, NULL, '2026-01-12 15:33:37', '2026-01-12 15:33:37', NULL),
(16, 7, 14000.00, '899111003', 'Minyak Goreng 1L - Bimoli', 'Minyak goreng sawit', 16500.00, 50, NULL, '2026-01-12 15:33:37', '2026-01-12 15:33:37', NULL),
(17, 8, 2800.00, '899111004', 'Aqua Botol 600ml', 'Air mineral', 4500.00, 200, NULL, '2026-01-12 15:34:31', '2026-01-12 15:34:31', NULL),
(18, 8, 3200.00, '899111005', 'Le Minerale 600ml', 'Air mineral', 5000.00, 180, NULL, '2026-01-12 15:34:31', '2026-01-12 15:34:31', NULL),
(19, 8, 4500.00, '899111006', 'Teh Pucuk Harum 350ml', 'Minuman teh', 7000.00, 150, NULL, '2026-01-12 15:34:31', '2026-01-12 15:34:31', NULL),
(20, 9, 2200.00, '899111008', 'Chitato Sapi Panggang', 'Snack kentang', 4000.00, 138, NULL, '2026-01-12 15:34:46', '2026-01-12 15:34:46', NULL),
(21, 9, 1800.00, '899111009', 'Taro Net Seaweed', 'Snack jagung', 3500.00, 160, NULL, '2026-01-12 15:34:46', '2026-01-12 15:34:46', NULL),
(22, 9, 1500.00, '899111010', 'Qtela Balado', 'Keripik singkong', 3000.00, 200, NULL, '2026-01-12 15:34:46', '2026-01-12 15:34:46', NULL),
(23, 10, 3000.00, '899111011', 'Royco Ayam 8gr', 'Kaldu ayam', 5000.00, 180, NULL, '2026-01-12 15:35:03', '2026-01-12 15:35:03', NULL),
(24, 10, 3500.00, '899111012', 'Masako Sapi 11gr', 'Kaldu sapi', 5500.00, 159, NULL, '2026-01-12 15:35:03', '2026-01-12 15:35:03', NULL),
(25, 10, 6000.00, '899111013', 'Kecap Manis ABC 135ml', 'Kecap manis', 9000.00, 120, NULL, '2026-01-12 15:35:03', '2026-01-12 15:35:03', NULL),
(26, 11, 3500.00, '899111014', 'Sabun Lifebuoy Merah', 'Sabun mandi', 6500.00, 100, NULL, '2026-01-12 15:35:17', '2026-01-12 15:35:17', NULL),
(27, 11, 5000.00, '899111015', 'Shampoo Pantene 70ml', 'Shampoo sachet', 8500.00, 88, NULL, '2026-01-12 15:35:17', '2026-01-12 15:35:17', NULL),
(28, 13, 1800.00, '899111020', 'Pulpen Standard AE7', 'Pulpen hitam', 3500.00, 200, NULL, '2026-01-12 15:35:50', '2026-01-12 15:35:50', NULL),
(29, 13, 2200.00, '899111021', 'Pensil Faber Castell 2B', 'Pensil tulis', 4000.00, 219, NULL, '2026-01-12 15:35:50', '2026-01-12 15:35:50', NULL),
(30, 15, 6200.00, '899700900001', 'Ultra Milk Coklat 250ml', 'Susu UHT', 8000.00, 90, NULL, '2026-01-13 12:17:33', '2026-01-13 12:17:33', NULL),
(31, 15, 6800.00, '899700900002', 'Indomilk Plain', 'Susu UHT', 8500.00, 85, NULL, '2026-01-13 12:17:33', '2026-01-13 12:17:33', NULL),
(32, 16, 18000.00, '899701000001', 'Nugget Kanzler', 'Nugget ayam', 22000.00, 30, NULL, '2026-01-13 12:17:55', '2026-01-13 12:17:55', NULL),
(33, 16, 16000.00, '899701000002', 'Sosis So Nice', 'Sosis ayam', 19500.00, 35, NULL, '2026-01-13 12:17:55', '2026-01-13 12:17:55', NULL),
(34, 17, 2800.00, '899701100001', 'Indomie Goreng', 'Mie instan', 3500.00, 200, NULL, '2026-01-13 12:18:13', '2026-01-13 12:18:13', NULL),
(35, 17, 3000.00, '899701100002', 'Mie Sedaap Soto', 'Mie instan', 3800.00, 180, NULL, '2026-01-13 12:18:13', '2026-01-13 12:18:13', NULL),
(36, 18, 310000.00, '899701200001', 'Indomie Goreng Dus (40)', 'Grosir mie instan', 350000.00, 9, NULL, '2026-01-13 12:18:37', '2026-01-13 12:18:37', NULL),
(37, 18, 280000.00, '899701200002', 'Aqua 600ml Dus', 'Grosir air mineral', 320000.00, 12, NULL, '2026-01-13 12:18:37', '2026-01-13 12:18:37', NULL),
(40, 14, 25000.00, '899700800001', 'Gudang Garam Surya', 'Rokok kretek', 29000.00, 39, NULL, '2026-01-13 12:20:08', '2026-01-13 12:20:08', NULL),
(41, 14, 23000.00, '899700800002', 'Djarum Super', 'Rokok filter', 27000.00, 34, NULL, '2026-01-13 12:20:08', '2026-01-13 12:20:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `pay_amount` decimal(15,2) DEFAULT 0.00,
  `payment_method` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_no`, `user_id`, `total_price`, `pay_amount`, `payment_method`, `created_at`) VALUES
(34, 'INV-20260112153838-567', 6, 16500.00, 20000.00, 'CASH', '2026-01-12 15:38:38'),
(35, 'INV-20260112160950-651', 6, 18000.00, 20000.00, 'CASH', '2026-01-12 16:09:50'),
(36, 'INV-20260113122152-127', 2, 406000.00, 410000.00, 'CASH', '2026-01-13 12:21:52');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `sale_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `price_at_time` decimal(15,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `price_at_time`, `qty`, `subtotal`) VALUES
(1, 34, 27, 8500.00, 1, 8500.00),
(2, 34, 20, 4000.00, 1, 4000.00),
(3, 34, 29, 4000.00, 1, 4000.00),
(4, 35, 24, 5500.00, 1, 5500.00),
(5, 35, 20, 4000.00, 1, 4000.00),
(6, 35, 27, 8500.00, 1, 8500.00),
(7, 36, 41, 27000.00, 1, 27000.00),
(8, 36, 40, 29000.00, 1, 29000.00),
(9, 36, 36, 350000.00, 1, 350000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` enum('admin','kasir','owner') NOT NULL DEFAULT 'kasir',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$LfMB32.GJKUtJ99mSeqQYOTgtTxbGD25dbFMRCaNFBjpCoM/zRajW', 'Super Admin', 'admin', '2026-01-10 18:32:15', NULL),
(2, 'kasir', '$2y$10$gaqtwSeM4slPYyXGbrThAO/dRTGM1NNQaRJkhm0YZ4XOaqAIQfRVy', 'Kasir Utama', 'kasir', '2026-01-10 18:32:15', NULL),
(6, 'owner', '$2y$10$GKFg6EGq38DX6d9DSm3u9Oo.Jr6Xl2h3MQ921UwQ/oC/NABymoVU.', 'Pemilik Toko', 'owner', '2026-01-11 20:49:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `full_name`, `phone`, `address`, `city`, `created_at`, `updated_at`) VALUES
(1, 1, 'Roni', '08123456789', 'mersi', 'purwokerto', NULL, NULL),
(2, 1, 'Roni', '08123456789', 'mersi', 'purwokerto', NULL, NULL),
(3, 1, 'Roni', '08123456789', 'mersi', 'purwokerto', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`),
  ADD KEY `sales_user_id_foreign` (`user_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_fk` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
