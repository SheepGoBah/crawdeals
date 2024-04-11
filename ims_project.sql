-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2024 at 11:25 PM
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
-- Database: `ims_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL,
  `C_Name` varchar(100) DEFAULT NULL,
  `C_Phone` varchar(20) DEFAULT NULL,
  `C_City` varchar(100) DEFAULT NULL,
  `C_State` varchar(50) DEFAULT NULL,
  `C_Street` varchar(100) DEFAULT NULL,
  `C_Postal` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_ID`, `C_Name`, `C_Phone`, `C_City`, `C_State`, `C_Street`, `C_Postal`) VALUES
(1, 'Jane Doe', '1-234-5678', 'Lafayette', 'Louisiana', '1005 Angel Drive', '70503'),
(2, 'Jane Doe', '1-234-5678', 'Lafayette', 'Louisiana', '1005 Angel Drive', '70503'),
(3, 'John Doe', '1-213-2332', 'Erath', 'Louisiana', '103 Geniveve', '30021'),
(4, 'Jason', 'Smith', 'Lang', 'Caster', '102 Drive', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

CREATE TABLE `customer_order` (
  `Order_ID` int(11) NOT NULL,
  `Order_Date` date DEFAULT NULL,
  `Total_Order_Cost` decimal(10,2) DEFAULT NULL,
  `personnel_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_order_details`
--

CREATE TABLE `customer_order_details` (
  `Order_ID` int(11) DEFAULT NULL,
  `Product_ID` int(11) DEFAULT NULL,
  `Unit_Cost` decimal(10,2) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Total_Cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `Product_ID` int(11) NOT NULL,
  `Product_Name` varchar(100) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Unit_Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`Product_ID`, `Product_Name`, `Quantity`, `Unit_Price`) VALUES
(1, 'Shrimp', 100, 6.00),
(2, 'Crabs', 100, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

CREATE TABLE `personnel` (
  `Personnel_id` int(11) NOT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Security_Question1` varchar(100) DEFAULT NULL,
  `Security_Question2` varchar(100) DEFAULT NULL,
  `Security_Question3` varchar(100) DEFAULT NULL,
  `isOwner` tinyint(1) DEFAULT NULL,
  `isManager` tinyint(1) DEFAULT NULL,
  `isEmployee` tinyint(1) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `Reset_Token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personnel`
--

INSERT INTO `personnel` (`Personnel_id`, `Username`, `Password`, `Security_Question1`, `Security_Question2`, `Security_Question3`, `isOwner`, `isManager`, `isEmployee`, `isAdmin`, `Reset_Token`) VALUES
(1, 'testowner1', '$2y$10$pKcBEA.jgxWX6a8kiqGXgOEyIyzw1nEcWcfD30o8TTGpQtFxG/94e', 'blue', 'lafayette', 'nissan', 0, 1, 0, NULL, 'b67bb0454ed8b4642b5a878535947b7d500ba457328f4035b018efef8974bfbb'),
(2, 'testowner2', '$2y$10$7./o9hJjzF08SSkz0WCPRe6dl2NhKYZUIfT7bnYDU8Zy3njKdOEfq', 'blue', 'lafayette', 'nissan', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `Purchase_Order_ID` int(11) NOT NULL,
  `Purchase_Order_Date` date DEFAULT NULL,
  `PO_Total_Cost` decimal(10,2) DEFAULT NULL,
  `Personnel_ID` int(11) DEFAULT NULL,
  `Supplier_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_details`
--

CREATE TABLE `purchase_order_details` (
  `Purchase_Order_ID` int(11) DEFAULT NULL,
  `Product_ID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Purchase_Unit_Cost` decimal(10,2) DEFAULT NULL,
  `Purchase_Total_Cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `Supplier_ID` int(11) NOT NULL,
  `S_Name` varchar(100) DEFAULT NULL,
  `S_Phone` varchar(20) DEFAULT NULL,
  `S_City` varchar(100) DEFAULT NULL,
  `S_State` varchar(50) DEFAULT NULL,
  `S_Street` varchar(100) DEFAULT NULL,
  `S_Postal` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_ID`);

--
-- Indexes for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `personnel_id` (`personnel_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customer_order_details`
--
ALTER TABLE `customer_order_details`
  ADD KEY `Order_ID` (`Order_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`Product_ID`);

--
-- Indexes for table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`Personnel_id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`Purchase_Order_ID`),
  ADD KEY `Personnel_ID` (`Personnel_ID`),
  ADD KEY `Supplier_ID` (`Supplier_ID`);

--
-- Indexes for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  ADD KEY `Purchase_Order_ID` (`Purchase_Order_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Supplier_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_order`
--
ALTER TABLE `customer_order`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `Personnel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `Purchase_Order_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Supplier_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_order`
--
ALTER TABLE `customer_order`
  ADD CONSTRAINT `customer_order_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`Personnel_id`),
  ADD CONSTRAINT `customer_order_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Customer_ID`);

--
-- Constraints for table `customer_order_details`
--
ALTER TABLE `customer_order_details`
  ADD CONSTRAINT `customer_order_details_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `customer_order` (`Order_ID`),
  ADD CONSTRAINT `customer_order_details_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `inventory` (`Product_ID`);

--
-- Constraints for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD CONSTRAINT `purchase_order_ibfk_1` FOREIGN KEY (`Personnel_ID`) REFERENCES `personnel` (`Personnel_id`),
  ADD CONSTRAINT `purchase_order_ibfk_2` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier` (`Supplier_ID`);

--
-- Constraints for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  ADD CONSTRAINT `purchase_order_details_ibfk_1` FOREIGN KEY (`Purchase_Order_ID`) REFERENCES `purchase_order` (`Purchase_Order_ID`),
  ADD CONSTRAINT `purchase_order_details_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `inventory` (`Product_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
