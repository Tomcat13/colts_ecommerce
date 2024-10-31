-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 11:14 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `colts_db`
--
CREATE DATABASE IF NOT EXISTS `colts_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `colts_db`;

-- --------------------------------------------------------

--
-- Table structure for table `invoice details`
--

CREATE TABLE `invoice details` (
  `transaction_id` int(8) NOT NULL,
  `invoice_id` int(10) NOT NULL,
  `products_id` int(10) NOT NULL,
  `quantity_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice details`
--

INSERT INTO `invoice details` (`transaction_id`, `invoice_id`, `products_id`, `quantity_id`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `primary order`
--

CREATE TABLE `primary order` (
  `invoice_id` int(12) NOT NULL,
  `customer_id` int(12) NOT NULL,
  `invoice_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `primary order`
--

INSERT INTO `primary order` (`invoice_id`, `customer_id`, `invoice_date`) VALUES
(1, 1, '2023-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(12) NOT NULL,
  `product` varchar(50) NOT NULL,
  `brand` varchar(25) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `purchase_price` decimal(8,2) NOT NULL,
  `type` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product`, `brand`, `price`, `purchase_price`, `type`) VALUES
(1, 'Booze', 'Bud Light', 8.00, 2.00, 1),
(2, 'Water', 'Aquafina', 6.00, 0.25, 4),
(3, 'Lemonade', 'Minute Maid', 6.00, 1.50, 2),
(4, 'Soda', 'CokeCola', 8.00, 0.20, 2),
(5, 'Coffee', 'Starbucks', 4.00, 1.00, 2),
(6, 'Vintage Peyton Manning T-Shirt', 'COLTS', 80.99, 10.80, 3),
(7, 'Colts Home Jersey', 'COLTS', 24.99, 5.20, 3),
(8, 'Colts Away Jersey', 'COLTS', 50.04, 10.80, 3),
(9, 'Darius Leonard Defense Shirt', 'COLTS', 80.99, 10.40, 3),
(10, '#1 Seller cool t-shirt', 'COLTS!', 45.95, 8.95, 3),
(11, 'Nachos', 'Xochitl Corn Tortilla Chi', 10.00, 2.30, 4),
(12, 'Pretzels', 'Pretzel Co.', 5.00, 0.60, 4),
(13, 'Hot Dogs', 'Nathans', 10.00, 1.00, 1),
(14, 'Hamburgers', 'Sam\'s Choice', 15.00, 2.50, 1),
(15, 'Potato', 'Idaho', 8.00, 2.50, 1),
(16, 'MVP Ticket', 'COLTS TICKETS!', 350.00, 5.90, 4),
(17, 'Suite Tickets', 'COLTS TICKETS!', 500.00, 5.90, 4),
(18, 'Nose Bleed Tickets', 'COLTS TICKETS!', 50.00, 0.24, 4),
(19, 'On-Field Tickets', 'COLTS TICKETS!', 250.00, 5.50, 4),
(20, 'Regular Tickets', 'COLTS TICKETS!', 150.00, 2.40, 4);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `type_id` tinyint(2) NOT NULL,
  `category` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `category`) VALUES
(1, 'food'),
(2, 'drink'),
(3, 'merchandise'),
(4, 'tickets');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `role` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `role`) VALUES
(1, 'Evan', 'Deal', 'evan.deal@gmail.com', 'evdeal', 'password', 1),
(2, 'Thomas', 'Reedy', 'thomas.reedy@gmail.com', 'tbreedy', 'password', 1),
(3, 'Kyle', 'Wicker', 'kyle.wicker@gmail.com', 'kywicker', 'password', 1),
(4, 'Sri', 'Majji', 'sri.majji@gmail.com', 'srmajji', 'password', 1),
(5, 'Kevin', 'Gates', 'kevin.gates@gmail.com', 'kegates', 'password', 2),
(6, 'Chris', 'Paul', 'chris.paul@gmail.com', 'chpaul', 'password', 3),
(7, 'jackie', 'chan', 'jackie.chan@gmail.com', 'jachan', 'password', 4),
(9, 'a', 's', 'a@gmail.com', 's', 'a', 2),
(10, 'a', 's', 'as@gmail.com', 'as', 'as', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice details`
--
ALTER TABLE `invoice details`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `primary order`
--
ALTER TABLE `primary order`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice details`
--
ALTER TABLE `invoice details`
  MODIFY `transaction_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `primary order`
--
ALTER TABLE `primary order`
  MODIFY `invoice_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `type_id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice details`
--
ALTER TABLE `invoice details`
  ADD CONSTRAINT `invoice details_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `primary order` (`invoice_id`),
  ADD CONSTRAINT `invoice details_ibfk_2` FOREIGN KEY (`products_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `primary order`
--
ALTER TABLE `primary order`
  ADD CONSTRAINT `primary order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`type`) REFERENCES `types` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
