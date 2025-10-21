-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2025 at 02:26 AM
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
(1, 'IT', 5000000.00),
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
(19, 'Paul McCartney', 'paul@gmail.com', 50000.00, 1, '2023-03-25'),
(20, 'George Harrison', 'george@gmail.com', 88000.00, 2, '2024-05-16'),
(22, 'John Lennon', 'lennon@gmail.com', 58000.00, 4, '2025-10-01'),
(23, 'Ringo Starr', 'ringo@gmail.com', 23000.00, 3, '2025-08-09'),
(24, 'Robert Plant', 'plant@gmail.com', 80000.00, 2, '2025-10-03'),
(25, 'Ozzy Osbourne', 'ozzy@gmail.com', 90000.00, 2, '2025-10-14'),
(26, 'Jimmy Page', 'jimmy@gmail.com', 70000.00, 4, '2025-01-08'),
(27, 'John Paul Jones', 'jones@gmail.com', 56000.00, 1, '2024-04-17'),
(28, 'Eric Clapton', 'eric@gmail.com', 43000.00, 3, '2025-05-06'),
(29, 'Freddie Mercury', 'freddie@gmail.com', 34000.00, 1, '2025-10-15'),
(30, 'Mick Jagger', 'mick@gmail.com', 38000.00, 3, '2025-02-12'),
(32, 'Keith Richards', 'keith@gmail.com', 67000.00, 4, '2025-09-26'),
(33, 'Bob Dylan', 'dylan@gmail.com', 89000.00, 1, '2023-06-20'),
(34, 'David Gilmour', 'david@gmail.com', 95231.00, 1, '2020-02-11');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
