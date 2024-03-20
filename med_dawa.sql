-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2024 at 07:27 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `med_dawa`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` text NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `category_date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `category_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `admin_id` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `order_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `order_amount` varchar(255) NOT NULL DEFAULT '0.0',
  `date_of_arrival` datetime DEFAULT NULL,
  `alphanum_oid` varchar(30) DEFAULT NULL,
  `shipping_id` varchar(30) DEFAULT NULL,
  `place` varchar(30) DEFAULT NULL,
  `label` varchar(30) DEFAULT NULL,
  `added_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` varchar(30) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_offer_price` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `num_reviews` int(11) NOT NULL DEFAULT 0,
  `product_tax` float(10,2) DEFAULT NULL,
  `product_tax_type` enum('percent','amount') NOT NULL DEFAULT 'percent',
  `product_discount` float(10,2) DEFAULT NULL,
  `product_discount_type` enum('percent','amount') NOT NULL DEFAULT 'percent',
  `product_image` varchar(255) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_short_description` text DEFAULT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_group` enum('featured','no') NOT NULL DEFAULT 'no',
  `tag_id` varchar(30) DEFAULT NULL,
  `category_id` varchar(30) NOT NULL,
  `subcategory_id` varchar(30) DEFAULT NULL,
  `brand_id` varchar(30) DEFAULT NULL,
  `product_in_stock` enum('yes','no') NOT NULL,
  `unit_id` varchar(30) DEFAULT NULL,
  `product_capacity` varchar(255) DEFAULT NULL,
  `product_date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `product_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `admin_id` varchar(30) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `date_created` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `comments` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_users` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
