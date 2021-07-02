-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2021 at 09:20 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_shopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `Username` varchar(255) NOT NULL,
  `Items in Cart` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`Username`, `Items in Cart`) VALUES
('manav007', '8'),
('shrey2308', '2,5');

-- --------------------------------------------------------

--
-- Table structure for table `clothes`
--

CREATE TABLE `clothes` (
  `Cloth_id` int(5) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Price` float NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clothes`
--

INSERT INTO `clothes` (`Cloth_id`, `Name`, `Price`, `Category`, `Quantity`) VALUES
(1, 'Mitera Printed Saree', 750, 'Women', 56),
(2, 'Ishinsc Wedding PeacockNavy', 4599, 'Women', 18),
(3, 'Silk Embroidery Saree', 2499, 'Women', 24),
(4, 'Aura cotton sarees', 5999, 'Women', 8),
(5, 'Rangoli Inddus', 899, 'Women', 48),
(6, 'Hawaiian Hangover Shirt', 2499, 'Men', 36),
(7, 'Boohoo Cotton Shirt', 6999, 'Men', 14),
(8, 'Demin Western Shirt', 9999, 'Men', 8),
(9, 'Polo Ralph Cotton Shirt', 14999, 'Men', 12),
(10, 'Ralph Lauren Purple Polo Shirt', 19999, 'Men', 4),
(11, 'Rainbow Dress', 8999, 'Kids', 22),
(12, 'Girls Summer Dress', 5999, 'Kids', 7),
(13, 'Blue Suit for Boys', 9999, 'Kids', 19),
(14, 'Wool Full Sleeve Guess', 8999, 'Kids', 34),
(15, 'Saree Galaxy Turquoise Saree', 15999, 'Kids', 23),
(16, 'Blue Stripes Mask', 199, 'Masks', 128),
(17, 'Cremoly Reusable Mask', 249, 'Masks', 102),
(18, 'Plain Grey Mask', 149, 'Masks', 88),
(19, '2 Ply Cotton Ladies Mask', 199, 'Masks', 56),
(20, 'Army Texture Mask', 299, 'Masks', 26),
(25, 'Mamaearth Face Mask', 349, 'Masks', 75),
(32, 'Sunglasses Brown Tint', 5, 'Men', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `Username` text NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Username`, `Name`, `Password`, `Email`) VALUES
(35, 'shrey23', 'Shrey Ketan Naik', '$2y$10$p2RonROPQGSumSyRkSJ8ZuHTbzKiH1J7lmCgzTRcuTR43BiKdye7K', 'naikshrey2308@gmail.com'),
(38, 'manav007', 'Manav Mistry', '$2y$10$LkCNmcn/MxMmtVLxldw6QOW8vh7cuDfIRzDrLtfANfpYhM1O48MMW', 'manav07@gmail.com'),
(50, 'admin', 'Deep Colors Inc', '$2y$10$asFcK.WbGNRXtZnlj7vDVuMgvGK8VdxqRNPTYNeDPQoDZOK2SBaGG', 'colorsdeep0205@gmail.com'),
(53, 'shrey2308', 'Shrey Ketan Naik', '$2y$10$xW8y.YBpMwXTPTFq1Etnx.9vIXQUV8iBr96MJ.vS765djcClR0eGS', 'naikshrey2308@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `clothes`
--
ALTER TABLE `clothes`
  ADD PRIMARY KEY (`Cloth_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Username` (`Username`(20));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clothes`
--
ALTER TABLE `clothes`
  MODIFY `Cloth_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
