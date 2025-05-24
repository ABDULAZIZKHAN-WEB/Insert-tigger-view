-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 08:55 AM
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
-- Database: `evidence-in-php`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertManufacturer` (IN `m_name` VARCHAR(50), IN `m_address` VARCHAR(100), IN `m_contact` VARCHAR(50))   BEGIN
    INSERT INTO Manufacturer (name, address, contact_no)
    VALUES (m_name, m_address, m_contact);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `address`, `contact_no`) VALUES
(1, 'Sony', 'Tokyo, Japan', '+81-3-1234-5678'),
(2, 'Samsung', 'Seoul, South Korea', '+82-2-9876-5432'),
(3, 'Apple', 'Cupertino, USA', '+1-800-275-2273'),
(4, 'Dell', 'Round Rock, Texas, USA', '+1-800-624-9896'),
(5, 'Lenovo', 'Beijing, China', '+86-10-5886-8888'),
(7, 'aci', 'dhaka', '+88026646634'),
(8, '465', 'erytr', 'tfhg'),
(10, 'sadsdfsdff', 'retytuyiu', '01254566'),
(11, 'jhuma', 'retytuyiu', '01254566'),
(12, 'jhuma', 'dhaka', '01254566fghgf');

--
-- Triggers `manufacturer`
--
DELIMITER $$
CREATE TRIGGER `after_delete_manufacturer` AFTER DELETE ON `manufacturer` FOR EACH ROW BEGIN
    DELETE FROM Product WHERE manufacturer_id = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `price` int(5) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `manufacturer_id`) VALUES
(1, 'PlayStation 5', 150000, 1),
(2, 'Bravia TV', 12000, 1),
(3, 'Galaxy S21', 35000, 2),
(4, 'Galaxy Tab S8', 45000, 2),
(5, 'iPhone 16', 100000, 3),
(6, 'MacBook Air', 200000, 3),
(7, 'tv 1 V', 15000, 1),
(8, 'Galaxy Watch 6', 4000, 2),
(9, 'iPad Pro', 50000, 3),
(10, 'XPS 13 Laptop', 89000, 4),
(11, 'ThinkPad X1 Carbon', 36000, 5);

-- --------------------------------------------------------

--
-- Stand-in structure for view `products_view`
-- (See below for the actual view)
--
CREATE TABLE `products_view` (
`id` int(11)
,`name` varchar(50)
,`price` int(5)
,`manufacturer_id` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `products_view`
--
DROP TABLE IF EXISTS `products_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `products_view`  AS SELECT `product`.`id` AS `id`, `product`.`name` AS `name`, `product`.`price` AS `price`, `product`.`manufacturer_id` AS `manufacturer_id` FROM `product` WHERE `product`.`price` > 5000 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
