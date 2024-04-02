-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2024 at 10:53 AM
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
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `productID` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity_available` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`productID`, `product_name`, `quantity_available`, `unit_price`) VALUES
(3, 'Crabs', 66, 5.00),
(4, 'Shrimp', 10, 3.00),
(7, 'Chicken', 10, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `security_question1` varchar(255) DEFAULT NULL,
  `security_question2` varchar(255) DEFAULT NULL,
  `security_question3` varchar(255) DEFAULT NULL,
  `isOwner` tinyint(1) DEFAULT 0,
  `isManager` tinyint(1) DEFAULT 0,
  `isEmployee` tinyint(1) DEFAULT 0,
  `isAdmin` tinyint(1) DEFAULT 0,
  `reset_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `security_question1`, `security_question2`, `security_question3`, `isOwner`, `isManager`, `isEmployee`, `isAdmin`, `reset_token`) VALUES
(1, 'testuser1', '$2y$10$Kc9HFW14NHRV.zRu4ISeuesrtkYTIX.V/CHQrRtMlz6QsHxon7.9.', 'blue', 'lafayette', 'nissan', 1, 0, 0, 0, '7aa6e6ac3523b2a861ffb9ab97913af11586b8df5d1a8c25b70f4b13d7eb8377'),
(2, 'testemployee1', '$2y$10$JfbKSDBEqaaT5NvwGDzGZ.C0AirE8tFYgkIsXeWQb.pB24Zz3udlm', 'blue', 'lafayette', 'nissan', 0, 0, 1, 0, '80b496694b8791686be4b3e976f5d47ec08796c8aa893966170f8b369fde7e87'),
(3, 'testowner1', '$2y$10$vub8uNUZlswSiWOdtPhGEeHQUTFoZvWZLmHiEc0VWw2/nSjJAPFBS', 'green', 'erath', 'chevrolet', 1, 0, 0, 0, NULL),
(4, 'testmanager1', '$2y$10$6UDqcIPM7o9eqlkZSxD2ZuPKCZXPMYloiRpz1.ZLs5Awh7E4952ee', 'green', 'lafayette', 'nissan', 0, 1, 0, 0, NULL),
(5, 'testnewemployee1', '$2y$10$wQ/A/Evdgh.ZBu2vE4USXecM.mRb5AYprfrfGa/IF0CfMAU06motC', 'purple', 'nowhere', 'moped', 0, 1, 0, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
