-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 04:32 AM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `BrandID` int(11) NOT NULL,
  `BrandName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`BrandID`, `BrandName`) VALUES
(2, 'AMD'),
(4, 'ASUS'),
(7, 'Corsair'),
(8, 'G.Skill'),
(6, 'Gigabyte'),
(1, 'Intel'),
(5, 'MSI'),
(3, 'NVIDIA'),
(9, 'Samsung'),
(10, 'Seagate');

-- --------------------------------------------------------

--
-- Table structure for table `budgetpc`
--

CREATE TABLE `budgetpc` (
  `pcID` int(11) NOT NULL,
  `bpcName` varchar(255) NOT NULL,
  `bpcPrice` decimal(10,2) NOT NULL,
  `bpcDescription` text NOT NULL,
  `bpcImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budgetpc`
--

INSERT INTO `budgetpc` (`pcID`, `bpcName`, `bpcPrice`, `bpcDescription`, `bpcImage`) VALUES
(1, 'sample1', 100.00, 'this is a sample1', 'pc1.jpg'),
(2, 'sample2', 200.00, 'this is a sample 2', 'pc1.jpg'),
(3, 'sample3', 300.00, 'this is a sample 3', 'pc1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `created_at`, `updated_at`) VALUES
(9, 22, '2025-04-06 07:34:01', '2025-04-06 07:34:01'),
(10, 21, '2025-04-07 00:37:21', '2025-04-07 00:37:21');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `cart_detail_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price_at_time` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `BrandID` int(11) NOT NULL,
  `ProductTypeID` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Description` text DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `BrandID`, `ProductTypeID`, `Price`, `Stock`, `Description`, `ImageURL`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'Core i9-13900K', 1, 1, 589.99, 15, '13th Gen Intel Core processor with 24 cores.', '/assets/product_img/Core i9-13900K.jpg', '2025-03-26 14:22:42', '2025-04-07 00:31:53'),
(2, 'Ryzen 9 7950X', 2, 1, 699.99, 10, 'Powerful AMD Ryzen processor with 16 cores.', '/assets/product_img/Ryzen 9 7950X.jpg', '2025-03-26 14:22:42', '2025-05-13 01:56:52'),
(3, 'RTX 4090', 3, 2, 1599.99, 8, 'NVIDIA GeForce RTX 4090 Graphics Card.', '/assets/product_img/RTX 4090.jpg', '2025-03-26 14:22:42', '2025-05-13 01:58:34'),
(4, 'RTX 3070 Ti', 3, 2, 699.99, 12, 'High-performance gaming GPU.', '/assets/product_img/RTX 3070Ti.png', '2025-03-26 14:22:42', '2025-05-13 02:12:16'),
(5, 'Vengeance DDR5 32GB', 7, 3, 199.99, 20, 'Corsair DDR5 RAM 5200 MHz.', '/assets/product_img/Vengeance DDR5 32GB.jpg', '2025-03-26 14:22:42', '2025-05-13 02:01:20'),
(6, 'Trident Z RGB 16GB', 8, 3, 89.99, 25, 'G.Skill RGB RAM for gamers.', '/assets/product_img/Trident Z RGB 16GB.png', '2025-03-26 14:22:42', '2025-05-13 02:12:31'),
(7, 'Z790 Motherboard', 4, 4, 329.99, 14, 'ASUS Z790 motherboard for Intel processors.', '/assets/product_img/Z790 Motherboard.png', '2025-03-26 14:22:42', '2025-05-13 02:12:45'),
(8, '1TB NVMe SSD', 9, 5, 109.99, 30, 'Samsung 980 Pro 1TB SSD.', '/assets/product_img/1TB NVMe SSD.jpg', '2025-03-26 14:22:42', '2025-05-13 02:04:09'),
(9, 'RM850x PSU', 7, 6, 149.99, 18, 'Corsair 850W power supply.', '/assets/product_img/RM850x PSU.jpg', '2025-03-26 14:22:42', '2025-05-13 02:04:41'),
(10, 'H100i Liquid Cooler', 7, 7, 179.99, 10, 'Corsair liquid cooling system.', '/assets/product_img/H100i Liquid Cooler.jpg', '2025-03-26 14:22:42', '2025-05-13 02:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `producttags`
--

CREATE TABLE `producttags` (
  `ProductTagID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `TagID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producttags`
--

INSERT INTO `producttags` (`ProductTagID`, `ProductID`, `TagID`) VALUES
(1, 1, 1),
(2, 1, 4),
(3, 2, 1),
(4, 2, 5),
(5, 3, 1),
(6, 3, 4),
(7, 4, 2),
(8, 4, 4),
(9, 5, 1),
(10, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `producttypes`
--

CREATE TABLE `producttypes` (
  `ProductTypeID` int(11) NOT NULL,
  `ProductTypeName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producttypes`
--

INSERT INTO `producttypes` (`ProductTypeID`, `ProductTypeName`) VALUES
(8, 'Case'),
(7, 'Cooling System'),
(1, 'CPU'),
(2, 'GPU'),
(9, 'Monitor'),
(4, 'Motherboard'),
(6, 'Power Supply'),
(3, 'RAM'),
(10, 'Software'),
(5, 'Storage');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `TagID` int(11) NOT NULL,
  `TagName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`TagID`, `TagName`) VALUES
(4, 'Gaming'),
(1, 'High-end'),
(3, 'Low-end'),
(2, 'Mid-end'),
(5, 'Workstation');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `pwd` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `pwd`) VALUES
(20, 'asd', 'jzleandrew@gmail.com', '$2y$10$oP.k/X0JhQT7z5PaFc7xgO8L.7XNy194evZPIdEt9fdsdlxPsjriu'),
(21, 'qwe', 'qwe@gmail.com', '$2y$10$lZgfUuvFlSBKZ/1zAvD9Mel3RbrQVbouZKWyifO2vWrlXU2ydukTy'),
(22, 'onald', 'onald@gmail.com', '$2y$10$FRbOCOMLnMtxeJr6Q1pPFuWeRKzmKsSLgz9RBx.Ky6HajYcSiVnTa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`BrandID`),
  ADD UNIQUE KEY `BrandName` (`BrandName`);

--
-- Indexes for table `budgetpc`
--
ALTER TABLE `budgetpc`
  ADD PRIMARY KEY (`pcID`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`cart_detail_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `BrandID` (`BrandID`),
  ADD KEY `ProductTypeID` (`ProductTypeID`);

--
-- Indexes for table `producttags`
--
ALTER TABLE `producttags`
  ADD PRIMARY KEY (`ProductTagID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `TagID` (`TagID`);

--
-- Indexes for table `producttypes`
--
ALTER TABLE `producttypes`
  ADD PRIMARY KEY (`ProductTypeID`),
  ADD UNIQUE KEY `ProductTypeName` (`ProductTypeName`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`TagID`),
  ADD UNIQUE KEY `TagName` (`TagName`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `BrandID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `budgetpc`
--
ALTER TABLE `budgetpc`
  MODIFY `pcID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `cart_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `producttags`
--
ALTER TABLE `producttags`
  MODIFY `ProductTagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `producttypes`
--
ALTER TABLE `producttypes`
  MODIFY `ProductTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD CONSTRAINT `cart_details_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`BrandID`) REFERENCES `brands` (`BrandID`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`ProductTypeID`) REFERENCES `producttypes` (`ProductTypeID`) ON DELETE CASCADE;

--
-- Constraints for table `producttags`
--
ALTER TABLE `producttags`
  ADD CONSTRAINT `producttags_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE,
  ADD CONSTRAINT `producttags_ibfk_2` FOREIGN KEY (`TagID`) REFERENCES `tags` (`TagID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
