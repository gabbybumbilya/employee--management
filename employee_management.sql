-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2025 at 02:31 PM
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
-- Database: `employee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `budget` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `budget`) VALUES
(1, 'IT', 500000.00),
(2, 'HR', 300000.00),
(3, 'Finance', 400000.00),
(4, 'Marketing', 350000.00);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `hire_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `salary`, `department_id`, `hire_date`) VALUES
(1, 'John Doe', 'john.doe@company.com', 75000.00, 1, '2022-01-15'),
(2, 'Jane Smith', 'jane.smith@company.com', 65000.00, 2, '2021-03-20'),
(3, 'Mike Johnson', 'mike.johnson@company.com', 82000.00, 1, '2020-11-10'),
(4, 'Sarah Wilson', 'sarah.wilson@company.com', 58000.00, 3, '2023-02-28'),
(5, 'Tom Brown', 'tom.brown@company.com', 72000.00, 4, '2022-07-15'),
(9, 'Gabriel Villanueva', 'example@gmail.com', 78500.00, 1, '2025-10-17'),
(10, 'Ozzy Osbourne', 'ozzy@gmail.com', 58000.00, 3, '2025-10-17'),
(11, 'John Lennon', 'lennon@gmail.com', 30000.00, 4, '2025-10-06'),
(12, 'Paul McCartney', 'paul@gmail.com', 45000.00, 2, '2025-10-17'),
(13, 'George Harrison', 'george@gmail.com', 50000.00, 2, '2025-01-17'),
(14, 'Ringo Starr', 'ringo@gmail.com', 50000.00, 3, '2025-06-18'),
(15, 'Robert Plant', 'plant@gmail.com', 98000.00, 3, '2020-06-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
