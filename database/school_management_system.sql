-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 17, 2024 at 10:39 PM
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
-- Database: `school_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `teacher_id`, `student_id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(5, 1, 2, '2024-10-14', 'present', '2024-10-17 04:04:43', '2024-10-17 04:04:43'),
(6, 1, 7, '2024-10-09', 'present', '2024-10-16 06:24:39', '2024-10-16 06:24:39'),
(9, 1, 2, '2024-10-16', 'present', '2024-10-17 04:04:43', '2024-10-17 04:04:43'),
(10, 1, 7, '2024-10-16', 'present', '2024-10-15 19:00:00', '2024-10-15 19:00:00'),
(21, 1, 2, '2024-10-17', 'present', '2024-10-17 04:04:43', '2024-10-17 04:04:43'),
(22, 1, 7, '2024-10-17', 'absent', '2024-10-17 04:01:51', '2024-10-17 04:01:51');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `section` varchar(10) NOT NULL,
  `strength` int(11) NOT NULL,
  `fees` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `name`, `teacher_id`, `section`, `strength`, `fees`, `status`, `created_at`, `updated_at`) VALUES
(1, 'One', 1, 'A', 25, 2500, 1, '2024-10-11 09:49:45', '2024-10-14 02:40:15'),
(2, 'Two', NULL, 'A', 25, 1500, 0, '2024-10-12 09:42:18', '2024-10-15 05:00:32'),
(6, 'One', NULL, 'B', 25, 2500, 0, '2024-10-14 12:22:57', '2024-10-15 08:49:05');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `profile_picture` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `email`, `password`, `profile_picture`, `created_at`, `updated_at`) VALUES
(7, 'admin', 'admin@gmail.com', '$2y$04$KGTc5LJW5.blnvaG0YyZYuVzJ5DmghM4QT2EVG0ocT5J4N9U0yWCG', '../dashboard_assets/img/uploads/profile2.jpg', '2024-10-09 05:26:09', '2024-10-16 22:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(250) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `profileimage` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `email`, `password`, `phone`, `class_id`, `profileimage`, `status`, `address`, `created_at`, `updated_at`) VALUES
(2, 'test444', 'test1@gmail.com', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '1234567', NULL, '../dashboard_assets/img/uploads/profile2.jpg', 1, 'aaaa bbbbb ccc ddd eee', '2024-10-10 10:47:39', '2024-10-17 17:21:12'),
(3, 'test224', 'test224@gmail.com', '$2y$10$cItcBg1IViRfiDUhioRS2.ZLwuaQ6m.WjwINuzP9Cp/oulIk9x2FC', '1111111 2222 33333 4444', NULL, '../dashboard_assets/img/uploads/profile2.jpg', 1, 'aaaaaaa bbbbb cccccccc', '2024-10-10 10:59:20', '2024-10-17 17:21:11'),
(8, 'test15', 'test15@gmail.com', '$2y$04$nVF/E7IPkOq8wVz/FjS3v.ftvFg2BUmMsEtudwC8JVtxIxHSswOF2', '1111111 2222 33333 4444', NULL, '../dashboard_assets/img/uploads/mlane.jpg', 1, 'aaa bb cc', '2024-10-14 06:20:57', '2024-10-14 08:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profileimage` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `password`, `phone`, `email`, `profileimage`, `status`, `address`, `created_at`, `updated_at`) VALUES
(1, 'test22', '$2y$04$KGTc5LJW5.blnvaG0YyZYuVzJ5DmghM4QT2EVG0ocT5J4N9U0yWCG', '1234567', 'test22@gmail.com', '../dashboard_assets/img/uploads/profile2.jpg', 1, 'aaa, aaaaaa, bbbb', '2024-10-10 03:37:27', '2024-10-14 09:04:30'),
(4, 'test1122', '$2y$10$hH/7BjYKc3YzlnXSdrCISeeqBG4QGM5bLe/8gZCIn3j9JU.ACbhsK', '1111111 2222 33333', 'test1122@gmail.com', '../dashboard_assets/img/uploads/profile2.jpg', 0, 'aaaaaaaaaa bbbbbbbb cccccc', '2024-10-12 09:23:46', '2024-10-15 08:49:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
