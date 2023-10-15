-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2023 at 03:07 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafe_eomma`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role_id` varchar(200) NOT NULL,
  `account_status` varchar(20) NOT NULL,
  `profile` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `fullname`, `username`, `gender`, `contact_number`, `address`, `password`, `role_id`, `account_status`, `profile`, `date_created`) VALUES
(1, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Cafe Eomma', 'CafeEomma', 'Female', '09322550100', 'Polangui, Albay', '$2y$10$gb269VmwmlHb9Jq2eytBUeenwnKj6yDrhBQjdtItqnI7G/1vS.90S', 'b2fd54eb-4e49-11ee-8673-088fc30176f9', 'active', 0, '2023-09-08 15:15:00'),
(2, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Alesha Monastero', 'AleshaM', 'Female', '09322550101', 'San Juan, Oas, Albay', '$2y$10$n/itDVmpx5uSzzzx71cgYuQOyH7j0X3Vaat0hk/nywGZDQgWetkji', 'b2fd6f62-4e49-11ee-8673-088fc30176f9', 'active', 1, '2023-09-08 22:03:19'),
(3, 'e7d61509-46ae-4dd8-9a65-da36c48a7d38', 'Arthur Nery', 'ArthurN', 'Male', '09526152162', 'Balogo, Oas, Albay', '$2y$10$jLOoHKUJgi0GNNJ7OZe1a.ONufRuODHWaD22Hq7P5i15fy0V4Ucju', 'b2fd6f62-4e49-11ee-8673-088fc30176f9', 'active', 1, '2023-09-08 22:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `cart_id` varchar(200) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `size_id` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_summary`
--

CREATE TABLE `cart_summary` (
  `id` int(11) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `vat` float(10,2) NOT NULL,
  `discount` float(10,2) NOT NULL,
  `cash` int(11) NOT NULL,
  `order_change` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_summary`
--

INSERT INTO `cart_summary` (`id`, `amount`, `vat`, `discount`, `cash`, `order_change`) VALUES
(4, 0.00, 0.00, 0.00, 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_id` varchar(200) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_id`, `category_name`, `date_created`) VALUES
(1, '0a3f6425-310c-4d13-8ece-951e72414912', 'Donut', '2023-09-08 16:35:37'),
(2, '46347ad2-c130-4460-87ab-c0f6d9496082', 'Milk Tea', '2023-09-08 16:36:20');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `inventory_id` varchar(200) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `inventory_stocks` int(11) NOT NULL,
  `inventory_value` int(11) NOT NULL,
  `reorder_level` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `inventory_id`, `menu_id`, `inventory_stocks`, `inventory_value`, `reorder_level`, `date_created`) VALUES
(1, '3d1a9dca-0e53-4c40-ba26-a516351e3b0c', 'eb2e65e3-5a52-4c3a-980e-e71d036137b0', 94, 5500, 20, '2023-09-08 20:33:13'),
(2, '79f51904-6d4a-4445-ae00-7449f67616eb', '0bac22d9-b9ea-4f22-aecd-2daa0b1d97be', 9, 890, 5, '2023-09-09 10:34:16'),
(3, '8eefc8e9-324b-4413-ab0d-633d44241c94', 'dd8aacc6-867f-4910-92a2-7a0cb4a770f8', 19, 1580, 10, '2023-09-09 11:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_price` int(11) NOT NULL,
  `category_id` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_id`, `menu_name`, `menu_price`, `category_id`, `date_created`) VALUES
(1, 'eb2e65e3-5a52-4c3a-980e-e71d036137b0', 'Choco Sprinkles', 55, '0a3f6425-310c-4d13-8ece-951e72414912', '2023-09-08 18:17:17'),
(2, '0bac22d9-b9ea-4f22-aecd-2daa0b1d97be', 'Golden Hour', 89, '46347ad2-c130-4460-87ab-c0f6d9496082', '2023-09-08 18:17:50'),
(3, 'dd8aacc6-867f-4910-92a2-7a0cb4a770f8', 'Milky Moods', 79, '46347ad2-c130-4460-87ab-c0f6d9496082', '2023-09-09 11:00:35');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `status` varchar(30) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `menu_id`, `status`, `date_created`) VALUES
(2, '0bac22d9-b9ea-4f22-aecd-2daa0b1d97be', 'Read', '2023-09-10 10:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `orderred_items`
--

CREATE TABLE `orderred_items` (
  `id` int(11) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size_id` varchar(200) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderred_items`
--

INSERT INTO `orderred_items` (`id`, `order_id`, `menu_id`, `amount`, `quantity`, `size_id`, `date_added`) VALUES
(10, 'ef9f3406-a700-4c73-90d7-acf15521c8fb', 'eb2e65e3-5a52-4c3a-980e-e71d036137b0', '55', 1, '', '2023-09-09 18:54:24'),
(11, '54bbcb75-cdd3-4b58-897f-e53d5875f779', '0bac22d9-b9ea-4f22-aecd-2daa0b1d97be', '79', 1, '602365da-5f81-40b7-8a86-fa92a79cf17b', '2023-09-09 18:54:57'),
(12, '54bbcb75-cdd3-4b58-897f-e53d5875f779', 'dd8aacc6-867f-4910-92a2-7a0cb4a770f8', '79', 1, '617835df-1766-4739-a37c-b316bcb4d822', '2023-09-09 18:54:57'),
(19, '91d7cf3e-d7b5-4189-842a-a885cbdef098', 'eb2e65e3-5a52-4c3a-980e-e71d036137b0', '55', 2, '', '2023-09-10 09:59:17'),
(20, '91d7cf3e-d7b5-4189-842a-a885cbdef098', '0bac22d9-b9ea-4f22-aecd-2daa0b1d97be', '79', 1, '602365da-5f81-40b7-8a86-fa92a79cf17b', '2023-09-10 09:59:17'),
(21, 'aac9a190-7c78-4d4a-9f37-00fabfa3b74a', '0bac22d9-b9ea-4f22-aecd-2daa0b1d97be', '69', 3, '928d396c-0e17-42a6-b15a-8a990f614bbb', '2023-09-10 10:23:04'),
(24, '65c1dc6f-fc8b-43d6-9ff4-b338d0f19fca', 'eb2e65e3-5a52-4c3a-980e-e71d036137b0', '55', 1, '', '2023-09-17 19:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `order_no` varchar(30) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `discount` float(10,2) NOT NULL,
  `vat` float(10,2) NOT NULL,
  `cash` int(11) NOT NULL,
  `order_change` float(10,2) NOT NULL,
  `order_status` varchar(30) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `order_no`, `order_quantity`, `amount`, `discount`, `vat`, `cash`, `order_change`, `order_status`, `date_added`) VALUES
(9, 'ef9f3406-a700-4c73-90d7-acf15521c8fb', '949618', 1, 57.75, 0.00, 2.75, 60, 2.25, 'Completed', '2023-09-09 18:54:24'),
(10, '54bbcb75-cdd3-4b58-897f-e53d5875f779', '889607', 2, 132.72, 33.18, 7.90, 150, 17.28, 'Completed', '2023-09-09 18:54:57'),
(13, '91d7cf3e-d7b5-4189-842a-a885cbdef098', '919007', 3, 158.76, 39.69, 9.45, 160, 1.24, 'Completed', '2023-09-10 09:59:17'),
(14, 'aac9a190-7c78-4d4a-9f37-00fabfa3b74a', '456917', 3, 217.35, 0.00, 10.35, 220, 2.65, 'Completed', '2023-09-10 10:23:04'),
(16, '65c1dc6f-fc8b-43d6-9ff4-b338d0f19fca', '445590', 1, 57.75, 0.00, 2.75, 60, 2.25, 'Completed', '2023-09-17 19:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_id` varchar(200) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_id`, `role_name`, `date_created`) VALUES
(1, 'b2fd54eb-4e49-11ee-8673-088fc30176f9', 'Admin', '2023-09-08 15:14:22'),
(2, 'b2fd6f62-4e49-11ee-8673-088fc30176f9', 'Employee', '2023-09-08 15:14:22');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `size_id` varchar(200) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `size` varchar(20) NOT NULL,
  `size_price` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size_id`, `menu_id`, `size`, `size_price`, `date_created`) VALUES
(1, '928d396c-0e17-42a6-b15a-8a990f614bbb', '0bac22d9-b9ea-4f22-aecd-2daa0b1d97be', '12oz', 69, '2023-09-08 18:17:50'),
(2, '602365da-5f81-40b7-8a86-fa92a79cf17b', '0bac22d9-b9ea-4f22-aecd-2daa0b1d97be', '14oz', 79, '2023-09-08 18:17:50'),
(3, 'e4bddac9-08dc-4f7c-800a-38683370e3d6', '0bac22d9-b9ea-4f22-aecd-2daa0b1d97be', '16oz', 89, '2023-09-08 18:17:50'),
(4, '303eed33-b23b-47eb-a971-99d0effb3d1f', 'dd8aacc6-867f-4910-92a2-7a0cb4a770f8', '14oz', 69, '2023-09-09 11:00:35'),
(5, '617835df-1766-4739-a37c-b316bcb4d822', 'dd8aacc6-867f-4910-92a2-7a0cb4a770f8', '16oz', 79, '2023-09-09 11:00:35');

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `user_id`, `type`, `date_created`) VALUES
(1, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged In', '2023-09-09 08:47:28'),
(2, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged Out', '2023-09-09 08:49:16'),
(3, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-09 08:49:53'),
(4, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged In', '2023-09-09 10:34:03'),
(5, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged Out', '2023-09-09 10:34:20'),
(6, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged In', '2023-09-09 10:59:24'),
(7, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged Out', '2023-09-09 11:18:28'),
(8, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-09 17:03:56'),
(9, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged In', '2023-09-09 17:08:46'),
(10, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged Out', '2023-09-09 19:14:50'),
(11, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged In', '2023-09-09 19:15:02'),
(12, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged Out', '2023-09-09 20:52:59'),
(13, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-09 20:53:28'),
(14, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged Out', '2023-09-09 21:55:52'),
(15, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-10 08:24:24'),
(16, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged Out', '2023-09-10 09:59:49'),
(17, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged In', '2023-09-10 09:59:59'),
(18, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged Out', '2023-09-10 10:21:59'),
(19, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-10 10:22:08'),
(20, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged Out', '2023-09-10 10:23:13'),
(21, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged In', '2023-09-10 10:23:20'),
(22, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged Out', '2023-09-10 10:36:57'),
(23, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-10 10:37:07'),
(24, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged Out', '2023-09-10 10:37:29'),
(25, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged In', '2023-09-10 10:37:40'),
(26, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Logged Out', '2023-09-10 10:37:56'),
(27, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-11 06:45:21'),
(28, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged Out', '2023-09-11 06:54:38'),
(29, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-13 17:57:10'),
(30, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-17 12:59:14'),
(31, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged Out', '2023-09-17 12:59:36'),
(32, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-17 19:14:10'),
(33, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged Out', '2023-09-17 19:21:30'),
(34, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged In', '2023-09-18 09:07:23'),
(35, '7bf80a51-5c90-4129-91fb-5885c592598f', 'Logged Out', '2023-09-18 09:07:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_summary`
--
ALTER TABLE `cart_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderred_items`
--
ALTER TABLE `orderred_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `cart_summary`
--
ALTER TABLE `cart_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orderred_items`
--
ALTER TABLE `orderred_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
