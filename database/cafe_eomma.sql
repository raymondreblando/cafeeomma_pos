-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 03:05 AM
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
(1, '5659b391-4e4a-11ee-8673-088fc30176f9', 'Cafe Eomma', 'CafeEomma', 'Female', '09322550100', 'Polangui, Albay', '$2y$10$gb269VmwmlHb9Jq2eytBUeenwnKj6yDrhBQjdtItqnI7G/1vS.90S', 'b2fd54eb-4e49-11ee-8673-088fc30176f9', 'active', 0, '2023-09-08 15:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `cart_id` varchar(200) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `size_id` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_summary`
--

CREATE TABLE `cart_summary` (
  `id` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `vat` float(10,2) NOT NULL,
  `discount` float(10,2) NOT NULL,
  `cash` float(10,2) NOT NULL,
  `order_change` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_summary`
--

INSERT INTO `cart_summary` (`id`, `subtotal`, `amount`, `vat`, `discount`, `cash`, `order_change`) VALUES
(4, '0.00', 0.00, 0.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_id` varchar(200) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_status` tinyint(4) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `ing_id` varchar(200) NOT NULL,
  `ing_name` varchar(100) NOT NULL,
  `ing_stocks` int(11) NOT NULL,
  `ing_unit` varchar(30) NOT NULL,
  `reorder_level` int(11) NOT NULL,
  `reorder_unit` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_cost`
--

CREATE TABLE `ingredient_cost` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `size_id` varchar(200) NOT NULL,
  `ing_id` varchar(200) NOT NULL,
  `ing_amount` varchar(100) NOT NULL,
  `ing_unit` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `inventory_id` varchar(200) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `inventory_stocks` int(11) NOT NULL,
  `inventory_value` float(10,2) NOT NULL,
  `reorder_level` int(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `menu_id` varchar(200) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_price` float(10,2) NOT NULL,
  `category_id` varchar(200) NOT NULL,
  `menu_status` tinyint(4) NOT NULL DEFAULT 1,
  `is_soldout` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `referrence_id` varchar(200) NOT NULL,
  `notif_type` varchar(50) NOT NULL,
  `status` varchar(30) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `staff_id` varchar(200) NOT NULL,
  `order_no` int(11) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `subtotal` float(10,2) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `discount` float(10,2) NOT NULL,
  `vat` float(10,2) NOT NULL,
  `cash` int(11) NOT NULL,
  `order_change` float(10,2) NOT NULL,
  `order_status` varchar(30) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `size_price` float(10,2) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredient_cost`
--
ALTER TABLE `ingredient_cost`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_summary`
--
ALTER TABLE `cart_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredient_cost`
--
ALTER TABLE `ingredient_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderred_items`
--
ALTER TABLE `orderred_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
