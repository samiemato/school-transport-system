-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2025 at 08:20 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_transport`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `journey_date` date NOT NULL,
  `pickup_time` time DEFAULT NULL,
  `dropoff_time` time DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `distance` decimal(5,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `pickup_address` varchar(255) DEFAULT NULL,
  `pickup_lat` decimal(10,8) DEFAULT NULL,
  `pickup_lng` decimal(11,8) DEFAULT NULL,
  `dropoff_location` varchar(255) DEFAULT NULL,
  `dropoff_address` varchar(255) DEFAULT NULL,
  `dropoff_lat` decimal(10,8) DEFAULT NULL,
  `dropoff_lng` decimal(11,8) DEFAULT NULL,
  `service_type` varchar(50) NOT NULL DEFAULT 'daily',
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `no_of_students` int(11) NOT NULL DEFAULT 1,
  `driver_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `school_id`, `student_id`, `route_id`, `vehicle_id`, `pickup_location`, `booking_date`, `journey_date`, `pickup_time`, `dropoff_time`, `status`, `distance`, `created_at`, `pickup_address`, `pickup_lat`, `pickup_lng`, `dropoff_location`, `dropoff_address`, `dropoff_lat`, `dropoff_lng`, `service_type`, `amount`, `payment_status`, `no_of_students`, `driver_remarks`) VALUES
(7, 2, 8, NULL, 53, NULL, 'School', '2025-09-03', '2025-05-04', '18:06:00', NULL, 'cancelled', '5.00', '2025-09-03 22:49:26', NULL, NULL, NULL, 'School', NULL, NULL, NULL, 'daily', '0.00', 'pending', 1, NULL),
(11, 2, 4, NULL, 36, NULL, 'School', '2025-09-04', '2025-09-04', '21:09:00', NULL, 'cancelled', '5.00', '2025-09-04 20:21:52', NULL, NULL, NULL, 'School', NULL, NULL, NULL, 'daily', '0.00', 'pending', 1, NULL),
(12, 2, 8, NULL, 42, NULL, 'School', '2025-09-04', '2025-09-04', '09:00:00', NULL, 'cancelled', '5.00', '2025-09-04 21:32:23', NULL, NULL, NULL, 'School', NULL, NULL, NULL, 'daily', '0.00', 'pending', 1, NULL),
(13, 2, 1, NULL, 30, NULL, 'School', '2025-09-04', '2025-09-04', '12:09:00', NULL, 'cancelled', '5.00', '2025-09-04 21:42:05', NULL, NULL, NULL, 'School', NULL, NULL, NULL, 'daily', '0.00', 'pending', 1, NULL),
(14, 2, 8, NULL, 51, NULL, 'School', '2025-09-06', '2025-09-06', '21:00:00', NULL, 'cancelled', '5.00', '2025-09-06 18:46:25', NULL, NULL, NULL, 'School', NULL, NULL, NULL, 'daily', '0.00', 'pending', 1, NULL),
(16, 0, 0, 2, NULL, NULL, 'Hillcrest International School', '0000-00-00', '2025-09-07', '12:00:00', NULL, 'confirmed', NULL, '2025-09-07 21:09:24', NULL, NULL, NULL, 'Gacharage', NULL, NULL, NULL, 'event', '0.00', 'pending', 1, NULL),
(17, 0, 0, 2, NULL, NULL, 'Hillcrest International School', '0000-00-00', '2025-09-07', '12:00:00', NULL, 'confirmed', NULL, '2025-09-07 21:16:05', NULL, NULL, NULL, 'Gacharage', NULL, NULL, NULL, 'daily', '50.00', 'paid', 1, NULL),
(18, 0, 0, 2, NULL, NULL, 'Hillcrest International School', '0000-00-00', '2025-09-07', '12:00:00', NULL, 'confirmed', NULL, '2025-09-07 21:49:43', NULL, NULL, NULL, 'Gacharage', NULL, NULL, NULL, 'daily', '50.00', 'pending', 1, NULL),
(19, 0, 0, 2, NULL, NULL, 'Hillcrest International School', '0000-00-00', '2025-09-07', '12:00:00', NULL, 'confirmed', NULL, '2025-09-07 21:49:45', NULL, NULL, NULL, 'Gacharage', NULL, NULL, NULL, 'daily', '50.00', 'paid', 1, NULL),
(20, 0, 0, 2, NULL, NULL, 'Nairobi International School', '0000-00-00', '2025-09-07', '12:00:00', NULL, 'confirmed', NULL, '2025-09-07 21:50:26', NULL, NULL, NULL, 'Gacharage', NULL, NULL, NULL, 'daily', '50.00', 'paid', 1, NULL),
(21, 0, 0, 2, NULL, NULL, 'Nairobi International School', '0000-00-00', '2025-09-07', '12:00:00', NULL, 'confirmed', NULL, '2025-09-07 21:52:00', NULL, NULL, NULL, 'Gacharage', NULL, NULL, NULL, 'event', '100.00', 'pending', 1, NULL),
(22, 0, 0, 2, NULL, NULL, 'St Agnes Educational Centre', '0000-00-00', '2025-12-09', '12:38:00', NULL, 'confirmed', NULL, '2025-09-07 22:14:10', NULL, NULL, NULL, 'Gacharage', NULL, NULL, NULL, 'daily', '150.00', 'pending', 3, NULL),
(23, 0, 0, 2, NULL, NULL, 'Nairobi International School', '0000-00-00', '2025-09-08', '17:00:00', NULL, 'confirmed', NULL, '2025-09-08 04:28:25', NULL, NULL, NULL, 'Riruta', NULL, NULL, NULL, 'event', '200.00', 'pending', 2, NULL),
(24, 0, 0, 2, NULL, NULL, 'Hillcrest International School', '0000-00-00', '2025-09-08', '15:49:00', NULL, 'confirmed', NULL, '2025-09-08 13:53:08', NULL, NULL, NULL, 'Dagoretti Corner', NULL, NULL, NULL, 'daily', '250.00', 'pending', 5, NULL),
(25, 0, 0, 2, NULL, NULL, 'Brookhouse School', '0000-00-00', '2025-09-08', '08:00:00', NULL, 'confirmed', NULL, '2025-09-08 14:37:57', NULL, NULL, NULL, 'Kawangware', NULL, NULL, NULL, 'daily', '200.00', 'pending', 4, NULL),
(26, 0, 0, 2, NULL, NULL, 'Nairobi International School', '0000-00-00', '2025-09-12', '08:00:00', NULL, 'confirmed', NULL, '2025-09-08 14:54:17', NULL, NULL, NULL, 'Mutuini', NULL, NULL, NULL, 'daily', '200.00', 'pending', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('pickup','dropoff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `type`) VALUES
(1, 'St Agnes Educational Centre', 'pickup'),
(2, 'West Nairobi School', 'pickup'),
(3, 'Nairobi International School', 'pickup'),
(4, 'Brookhouse School', 'pickup'),
(5, 'Hillcrest International School', 'pickup'),
(6, 'Dagoretti Corner', 'dropoff'),
(7, 'Riruta', 'dropoff'),
(8, 'Kawangware', 'dropoff'),
(9, 'Gacharage', 'dropoff'),
(10, 'Mutuini', 'dropoff');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','completed','failed') DEFAULT 'pending',
  `transaction_code` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `amount`, `payment_method`, `payment_status`, `transaction_code`, `transaction_id`, `payment_date`) VALUES
(2, 14, '5000.00', 'mpesa', 'pending', 'SIMULATED', NULL, '2025-09-06 19:49:46'),
(5, 23, '0.00', NULL, 'completed', 'DEMO_RECEIPT_1757295229', NULL, '2025-09-08 04:33:49'),
(6, 18, '0.00', NULL, 'completed', 'DEMO_RECEIPT_1757324854', NULL, '2025-09-08 12:47:34'),
(7, 16, '0.00', NULL, 'completed', 'DEMO_RECEIPT_1757324950', NULL, '2025-09-08 12:49:10'),
(8, 24, '0.00', NULL, 'completed', 'DEMO_RECEIPT_1757328801', NULL, '2025-09-08 13:53:21'),
(9, 25, '0.00', NULL, 'completed', 'DEMO_RECEIPT_1757331508', NULL, '2025-09-08 14:38:28'),
(10, 26, '0.00', NULL, 'completed', 'DEMO_RECEIPT_1757332508', NULL, '2025-09-08 14:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `route_name` varchar(100) NOT NULL,
  `start_point` varchar(100) NOT NULL,
  `end_point` varchar(100) NOT NULL,
  `stops` text DEFAULT NULL,
  `distance` decimal(5,2) DEFAULT NULL,
  `estimated_time` time DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `school_id`, `route_name`, `start_point`, `end_point`, `stops`, `distance`, `estimated_time`, `price`) VALUES
(30, 1, 'Westlands', '', '', NULL, NULL, NULL, '10.00'),
(31, 1, 'South B', '', '', NULL, NULL, NULL, '3000.00'),
(32, 1, 'Karen', '', '', NULL, NULL, NULL, '4500.00'),
(33, 1, 'Kasarani', '', '', NULL, NULL, NULL, '3600.00'),
(34, 2, 'Ruiru', '', '', NULL, NULL, NULL, '4800.00'),
(35, 2, 'Thika Town', '', '', NULL, NULL, NULL, '6000.00'),
(36, 2, 'Buruburu', '', '', NULL, NULL, NULL, '3600.00'),
(37, 2, 'Langata', '', '', NULL, NULL, NULL, '3800.00'),
(38, 3, 'Donholm', '', '', NULL, NULL, NULL, '3500.00'),
(39, 3, 'Embakasi', '', '', NULL, NULL, NULL, '4000.00'),
(40, 3, 'Pipeline', '', '', NULL, NULL, NULL, '4100.00'),
(41, 4, 'Syokimau', '', '', NULL, NULL, NULL, '4500.00'),
(42, 4, 'Athi River', '', '', NULL, NULL, NULL, '4800.00'),
(43, 4, 'Ruaka', '', '', NULL, NULL, NULL, '3700.00'),
(44, 1, 'Westlands', '', '', NULL, NULL, NULL, '5000.00'),
(45, 1, 'Karen', '', '', NULL, NULL, NULL, '5500.00'),
(46, 1, 'Donholm', '', '', NULL, NULL, NULL, '4500.00'),
(47, 1, 'South B', '', '', NULL, NULL, NULL, '4000.00'),
(48, 1, 'Embakasi', '', '', NULL, NULL, NULL, '4800.00'),
(49, 2, 'Ruiru', '', '', NULL, NULL, NULL, '6000.00'),
(50, 2, 'Kasarani', '', '', NULL, NULL, NULL, '5200.00'),
(51, 2, 'Zimmerman', '', '', NULL, NULL, NULL, '5000.00'),
(52, 3, 'Langata', '', '', NULL, NULL, NULL, '4700.00'),
(53, 3, 'Buruburu', '', '', NULL, NULL, NULL, '4300.00'),
(54, 1, 'Westlands', '', '', NULL, NULL, NULL, '5000.00'),
(55, 1, 'Karen', '', '', NULL, NULL, NULL, '4500.00'),
(56, 2, 'Ruiru', '', '', NULL, NULL, NULL, '6000.00'),
(57, 3, 'Donholm', '', '', NULL, NULL, NULL, '4000.00');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `school_name`, `created_at`) VALUES
(1, 'St Agnes Educational Centre', '2025-09-03 19:16:14'),
(2, 'Nairobi Primary School', '2025-09-03 19:16:14'),
(3, 'Sunrise Academy', '2025-09-03 19:16:14'),
(4, 'Greenwood School', '2025-09-03 19:16:14'),
(5, 'Madaraka Junior School', '2025-09-03 19:16:14'),
(6, 'Imara Academy', '2025-09-03 19:16:14'),
(7, 'Joyland Academy', '2025-09-03 19:16:14'),
(8, 'Brookside Preparatory', '2025-09-03 19:16:14'),
(9, 'St Agnes Educational Centre', '2025-09-03 19:19:41'),
(10, 'Nairobi Primary School', '2025-09-03 19:19:41'),
(11, 'Sunrise Academy', '2025-09-03 19:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` enum('admin','student','driver') DEFAULT 'student',
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_type`, `full_name`, `phone`, `address`, `created_at`, `is_admin`) VALUES
(1, 'jo', '$2y$10$PWuzd8c7R05kp5L61MBT/.whX.cV3/9CSMTGPXxQb5JT61MeERYqq', 'josbosimwenda@gmail.com', 'student', 'Jonathan bos', '0768062600', 'highrise', '2025-08-26 12:03:30', 0),
(2, 'sam', '$2y$10$MCzsaoLrYQSuMSVq9WCYTezUKeq0Fp5rxd3nuFqAm1uxdJvnOtagq', 'samsonmatowe220@gmail.com', 'student', 'samson matowe', '0719559707', 'ahero', '2025-08-26 23:28:51', 0),
(7, 'ADMIN', '$2y$10$8mf6fsMQ81HPvNujCEEPoOtJnLWN1BPdvgbuP9.0Kh6NFcoQlZeWu', 'admin@example.com', 'admin', 'ADMIN', '0719559707', 'kawangware', '2025-09-03 12:52:04', 0),
(8, 'DRIVER1', '$2y$10$2Jf.uK.VpxnzMjYJ.5VnfuGGmZoFEQPJC42SowYn9O4fBFH2KP9Xa', 'driver.example@gmail.com', 'driver', 'DRIVER', '0769532064', ': Kawangware 56, near St. John\'s Primary School\r\nKawangware, Nairobi', '2025-09-03 12:56:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive','maintenance') DEFAULT 'active',
  `driver_notes` text DEFAULT NULL,
  `assigned_route_id` int(11) DEFAULT NULL,
  `vehicle_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `route_id` (`route_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_number` (`vehicle_number`),
  ADD KEY `driver_id` (`driver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
