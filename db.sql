-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 09, 2025 at 04:12 AM
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
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `description`, `price`, `stock`, `image`, `category`, `created_at`) VALUES
(1, 'tarpaulin', ' Very nice', 10000, 100, 'girl.jpg', 'banner', '2025-05-03 10:08:54'),
(2, 'poster', ' This is a poster to post stuff', 100, 20, 'mountain.jpg', 'banner', '2025-05-03 11:43:04'),
(3, 'test', ' cool', 100, 20, 'mountain.jpg', 'banner', '2025-05-03 11:44:20'),
(4, 'tshirt', ' shirt', 100, 10, 'cat.png', 'shirts', '2025-05-03 12:27:36'),
(5, 'stickers', ' nice stickers', 10000, 200, 'japan.jpg', 'sticker', '2025-05-03 12:47:21'),
(6, 'mug', 'Mug with custom design', 200, 20, 'wallpaper.png', 'miscellaneous', '2025-05-04 06:53:59'),
(7, 'shoes', ' shoes', 2000, 10, 'cringe.png', 'clothing', '2025-05-05 06:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','shipped','completed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(2, 1, '2025-05-05 03:30:10', NULL, 'pending'),
(3, 5, '2025-05-05 03:39:26', NULL, 'pending'),
(4, 5, '2025-05-05 05:04:24', NULL, 'pending'),
(5, 5, '2025-05-05 05:09:27', NULL, 'pending'),
(6, 5, '2025-05-05 05:14:22', NULL, 'pending'),
(7, 6, '2025-05-05 06:04:23', NULL, 'pending'),
(8, 6, '2025-05-05 06:04:27', NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `quantity`, `price`, `total_price`) VALUES
(1, 2, 2, 1, 100.00, 100.00),
(2, 2, 4, 1, 100.00, 100.00),
(3, 2, 6, 10, 200.00, 2000.00),
(4, 3, 2, 1, 100.00, 100.00),
(5, 4, 2, 1, 100.00, 100.00),
(6, 5, 2, 1, 100.00, 100.00),
(7, 5, 5, 1, 10000.00, 10000.00),
(8, 5, 3, 1, 100.00, 100.00),
(9, 5, 3, 1, 100.00, 100.00),
(10, 7, 4, 2, 100.00, 200.00),
(11, 7, 5, 1, 10000.00, 10000.00),
(12, 8, 4, 2, 100.00, 200.00),
(13, 8, 5, 1, 10000.00, 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone_number`) VALUES
(1, 'pib', 'pib', 'pib@gmail.com', '09999999999'),
(4, 'pibble', 'pibble', 'pibble@mail.com', '0999999999'),
(5, 'test', 'test', 'test@gmal.com', '9832982394'),
(6, 'gaby', 'pass', 'gab@gab.com', '6969696969');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `unique_phone_number` (`phone_number`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
