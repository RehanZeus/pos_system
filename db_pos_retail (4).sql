-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 04:34 PM
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
(22, '2026-01-10-110858', 'App\\Database\\Migrations\\InitialUsers', 'default', 'App', 1768756207, 1),
(23, '2026-01-10-110906', 'App\\Database\\Migrations\\InitialInventory', 'default', 'App', 1768756207, 1),
(24, '2026-01-10-110916', 'App\\Database\\Migrations\\InitialSales', 'default', 'App', 1768756207, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `purchase_price` decimal(15,2) NOT NULL DEFAULT 0.00,
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

INSERT INTO `products` (`id`, `category_id`, `barcode`, `name`, `description`, `purchase_price`, `price`, `stock`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, 7, '899111001', 'Beras Ramos 5kg - Topi Koki', 'Beras premium 5kg', 0.00, 13000.00, 1, NULL, '2026-01-12 15:33:37', NULL, NULL),
(15, 7, '899111002', 'Gula Pasir 1kg - Gulaku', 'Gula pasir kristal', 0.00, 14500.00, 80, NULL, '2026-01-12 15:33:37', NULL, NULL),
(16, 7, '899111003', 'Minyak Goreng 1L - Bimoli', 'Minyak goreng sawit', 0.00, 16500.00, 50, NULL, '2026-01-12 15:33:37', NULL, NULL),
(17, 8, '899111004', 'Aqua Botol 600ml', 'Air mineral', 0.00, 4500.00, 200, NULL, '2026-01-12 15:34:31', NULL, NULL),
(18, 8, '899111005', 'Le Minerale 600ml', 'Air mineral', 0.00, 5000.00, 180, NULL, '2026-01-12 15:34:31', NULL, NULL),
(19, 8, '899111006', 'Teh Pucuk Harum 350ml', 'Minuman teh', 0.00, 7000.00, 150, NULL, '2026-01-12 15:34:31', NULL, NULL),
(20, 9, '899111008', 'Chitato Sapi Panggang', 'Snack kentang', 0.00, 4000.00, 138, NULL, '2026-01-12 15:34:46', NULL, NULL),
(21, 9, '899111009', 'Taro Net Seaweed', 'Snack jagung', 0.00, 3500.00, 160, NULL, '2026-01-12 15:34:46', NULL, NULL),
(22, 9, '899111010', 'Qtela Balado', 'Keripik singkong', 0.00, 3000.00, 200, NULL, '2026-01-12 15:34:46', NULL, NULL),
(23, 10, '899111011', 'Royco Ayam 8gr', 'Kaldu ayam', 0.00, 5000.00, 180, NULL, '2026-01-12 15:35:03', NULL, NULL),
(24, 10, '899111012', 'Masako Sapi 11gr', 'Kaldu sapi', 0.00, 5500.00, 159, NULL, '2026-01-12 15:35:03', NULL, NULL),
(25, 10, '899111013', 'Kecap Manis ABC 135ml', 'Kecap manis', 0.00, 9000.00, 120, NULL, '2026-01-12 15:35:03', NULL, NULL),
(26, 11, '899111014', 'Sabun Lifebuoy Merah', 'Sabun mandi', 0.00, 6500.00, 100, NULL, '2026-01-12 15:35:17', NULL, NULL),
(27, 11, '899111015', 'Shampoo Pantene 70ml', 'Shampoo sachet', 0.00, 8500.00, 86, NULL, '2026-01-12 15:35:17', NULL, NULL),
(28, 13, '899111020', 'Pulpen Standard AE7', 'Pulpen hitam', 0.00, 3500.00, 200, NULL, '2026-01-12 15:35:50', NULL, NULL),
(29, 13, '899111021', 'Pensil Faber Castell 2B', 'Pensil tulis', 0.00, 4000.00, 218, NULL, '2026-01-12 15:35:50', NULL, NULL),
(30, 15, '899700900001', 'Ultra Milk Coklat 250ml', 'Susu UHT', 0.00, 8000.00, 90, NULL, '2026-01-13 12:17:33', NULL, NULL),
(31, 15, '899700900002', 'Indomilk Plain', 'Susu UHT', 0.00, 8500.00, 85, NULL, '2026-01-13 12:17:33', NULL, NULL),
(32, 16, '899701000001', 'Nugget Kanzler', 'Nugget ayam', 0.00, 22000.00, 30, NULL, '2026-01-13 12:17:55', NULL, NULL),
(33, 16, '899701000002', 'Sosis So Nice', 'Sosis ayam', 0.00, 19500.00, 35, NULL, '2026-01-13 12:17:55', NULL, NULL),
(34, 17, '899701100001', 'Indomie Goreng', 'Mie instan', 0.00, 3500.00, 200, NULL, '2026-01-13 12:18:13', NULL, NULL),
(35, 17, '899701100002', 'Mie Sedaap Soto', 'Mie instan', 0.00, 3800.00, 180, NULL, '2026-01-13 12:18:13', NULL, NULL),
(36, 18, '899701200001', 'Indomie Goreng Dus (40)', 'Grosir mie instan', 0.00, 350000.00, 9, NULL, '2026-01-13 12:18:37', NULL, NULL),
(37, 18, '899701200002', 'Aqua 600ml Dus', 'Grosir air mineral', 0.00, 320000.00, 12, NULL, '2026-01-13 12:18:37', NULL, NULL),
(40, 14, '899700800001', 'Gudang Garam Surya', 'Rokok kretek', 0.00, 29000.00, 39, NULL, '2026-01-13 12:20:08', NULL, NULL),
(41, 14, '899700800002', 'Djarum Super', 'Rokok filter', 25000.00, 30000.00, 30, NULL, '2026-01-13 12:20:08', '2026-01-19 15:26:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `pay_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_no`, `user_id`, `total_price`, `pay_amount`, `payment_method`, `created_at`) VALUES
(1, 'INV-20260119001652-709', 3, 8500.00, 10000.00, 'CASH', '2026-01-19 00:16:52'),
(2, 'INV-20260119144101-253', 3, 8500.00, 10000.00, 'CASH', '2026-01-19 14:41:01'),
(3, 'INV-20260119151344-813', 3, 30000.00, 50000.00, 'CASH', '2026-01-19 15:13:44'),
(4, 'INV-20260119152208-233', 3, 30000.00, 60000.00, 'CASH', '2026-01-19 15:22:08'),
(5, 'INV-20260119162233-705', 3, 13000.00, 15000.00, 'CASH', '2026-01-19 16:22:33'),
(6, 'INV-20260119162324-630', 3, 13000.00, 15000.00, 'CASH', '2026-01-19 16:23:24'),
(7, 'INV-20260119162948-181', 3, 13000.00, 15000.00, 'CASH', '2026-01-19 16:29:48'),
(8, 'INV-20260119163000-319', 3, 13000.00, 13000.00, 'CASH', '2026-01-19 16:30:00'),
(9, 'INV-20260119163426-244', 3, 715000.00, 720000.00, 'CASH', '2026-01-19 16:34:26'),
(10, 'INV-20260119163545-661', 3, 30000.00, 30000.00, 'CASH', '2026-01-19 16:35:45'),
(11, 'INV-20260119163606-656', 3, 30000.00, 30000.00, 'CASH', '2026-01-19 16:36:06'),
(12, 'INV-20260128221315-529', 3, 4000.00, 5000.00, 'CASH', '2026-01-28 22:13:15');

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
(2, 1, 27, 8500.00, 1, 8500.00),
(3, 2, 27, 8500.00, 1, 8500.00),
(4, 3, 41, 30000.00, 1, 30000.00),
(5, 4, 41, 30000.00, 1, 30000.00),
(6, 5, 14, 13000.00, 1, 13000.00),
(7, 6, 14, 13000.00, 1, 13000.00),
(8, 7, 14, 13000.00, 1, 13000.00),
(9, 8, 14, 13000.00, 1, 13000.00),
(10, 9, 14, 13000.00, 55, 715000.00),
(11, 10, 41, 30000.00, 1, 30000.00),
(12, 11, 41, 30000.00, 1, 30000.00),
(13, 12, 29, 4000.00, 1, 4000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` enum('owner','gudang','kasir') NOT NULL DEFAULT 'kasir',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`, `created_at`, `updated_at`) VALUES
(1, 'gudang', '$2y$10$Tah8ePM/6GR8RxHQkYKxwugBv01fJFIcFJc6QyOGeY6q8k1QNbLAi', 'Staf Gudang', 'gudang', '2026-01-19 00:10:18', NULL),
(2, 'kasir', '$2y$10$/LlH1Y1oaFv8ngbFuXECoOqMd0nZsUuFT5N4j4LbV9c0vPQehT6Je', 'Kasir Utama', 'kasir', '2026-01-19 00:10:18', NULL),
(3, 'owner', '$2y$10$dYa9ceF80TXLrLu5PF1p6upXqD16hRt3xWBCsuji/H8lVeFONP6ni', 'Pemilik Toko', 'owner', '2026-01-19 00:10:18', NULL);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
