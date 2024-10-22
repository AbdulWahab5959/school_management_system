-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 10:07 AM
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
(1, 'One', 4, 'A', 25, 2500, 1, '2024-10-11 09:49:45', '2024-10-21 05:36:11'),
(4, 'One', 5, 'C', 25, 1500, 1, '2024-10-12 09:42:18', '2024-10-21 06:08:46'),
(6, 'One', 1, 'B', 25, 2500, 1, '2024-10-14 12:22:57', '2024-10-21 10:23:35'),
(8, 'Three', 0, 'A', 25, 3000, 1, '2024-10-21 10:30:27', '2024-10-21 10:30:27');

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
(2, 'test444', 'test444@gmail.com', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '1234567', 1, '../dashboard_assets/img/uploads/6716ac653fe6b.jpg', 1, 'aaaa bbbbb ccc ddd eee', '2024-10-10 10:47:39', '2024-10-21 16:32:35'),
(3, 'test224', 'test224@gmail.com', '$2y$10$cItcBg1IViRfiDUhioRS2.ZLwuaQ6m.WjwINuzP9Cp/oulIk9x2FC', '1111111 2222 33333 4444', NULL, '../dashboard_assets/img/uploads/profile2.jpg', 0, 'aaaaaaa bbbbb cccccccc', '2024-10-10 10:59:20', '2024-10-21 06:33:33'),
(7, 'test1234', 'test1234@gmail.com', '$2y$10$u4mRpUH6m9C/iTGsN29yVup/JZlQHlMuhkJIjFLkzcqY6NjjVwKry', '1111111 2222 33333', 1, '../dashboard_assets/img/uploads/profile2.jpg', 1, 'ssssssssssss aaaaaaaaaa cccccccc', '2024-10-11 18:56:51', '2024-10-14 04:02:08'),
(8, 'test15', 'test15@gmail.com', '$2y$04$nVF/E7IPkOq8wVz/FjS3v.ftvFg2BUmMsEtudwC8JVtxIxHSswOF2', '1111111 2222 33333 4444', 6, '../dashboard_assets/img/uploads/mlane.jpg', 1, 'aaa bb cc', '2024-10-14 06:20:57', '2024-10-21 05:46:32'),
(28, 'Jane Smith', 'jane.smith2@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '2345678901', 1, '../dashboard_assets/img/uploads/profile2.jpg', 1, '456 Elm St', '2024-10-21 07:17:48', '2024-10-21 06:05:10'),
(29, 'Alice Johnson', 'alice.johnson3@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '3456789012', 6, '../dashboard_assets/img/uploads/profile2.jpg', 1, '789 Oak St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(30, 'Bob Brown', 'bob.brown4@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '4567890123', 1, '../dashboard_assets/img/uploads/profile2.jpg', 1, '101 Maple St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(31, 'Charlie Davis', 'charlie.davis5@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '5678901234', 4, '../dashboard_assets/img/uploads/profile2.jpg', 1, '202 Birch St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(32, 'David Wilson', 'david.wilson6@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '6789012345', 6, '../dashboard_assets/img/uploads/profile2.jpg', 1, '303 Pine St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(34, 'Frank Miller', 'frank.miller8@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '8901234567', 4, '../dashboard_assets/img/uploads/profile2.jpg', 1, '505 Walnut St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(35, 'Grace Lee', 'grace.lee9@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '9012345678', 6, '../dashboard_assets/img/uploads/profile2.jpg', 1, '606 Cherry St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(36, 'Hank Young', 'hank.young10@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '0123456789', 1, '../dashboard_assets/img/uploads/profile2.jpg', 1, '707 Aspen St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(37, 'Ivy King', 'ivy.king11@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '9876543210', 4, '../dashboard_assets/img/uploads/profile2.jpg', 1, '808 Cypress St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(38, 'Jack Green', 'jack.green12@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '8765432109', 6, '../dashboard_assets/img/uploads/profile2.jpg', 1, '909 Willow St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(39, 'Karen Hill', 'karen.hill13@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '7654321098', 1, '../dashboard_assets/img/uploads/profile2.jpg', 1, '100 Magnolia St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(40, 'Leo Scott', 'leo.scott14@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '6543210987', 4, '../dashboard_assets/img/uploads/profile2.jpg', 1, '111 Fir St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(41, 'Mona Adams', 'mona.adams15@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '5432109876', 6, '../dashboard_assets/img/uploads/profile2.jpg', 1, '122 Spruce St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(42, 'Nick Harris', 'nick.harris16@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '4321098765', 1, '../dashboard_assets/img/uploads/profile2.jpg', 1, '133 Hemlock St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(43, 'Olive Martin', 'olive.martin17@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '3210987654', 4, '../dashboard_assets/img/uploads/profile2.jpg', 1, '144 Alder St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(44, 'Paul Baker', 'paul.baker18@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '2109876543', 6, '../dashboard_assets/img/uploads/profile2.jpg', 1, '155 Poplar St', '2024-10-21 07:17:48', '2024-10-21 07:17:48');

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
(1, 'test2', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1W9BFstRs/m', '12345678', 'test2@gmail.com', '../dashboard_assets/img/uploads/6716abb2136bf.jpg', 1, 'aaa, aaaaaa, bbbb', '2024-10-10 03:37:27', '2024-10-21 16:30:03'),
(4, 'test1122', '$2y$10$hH/7BjYKc3YzlnXSdrCISeeqBG4QGM5bLe/8gZCIn3j9JU.ACbhsK', '1111111 2222 33333', 'test1122@gmail.com', '../dashboard_assets/img/uploads/profile2.jpg', 1, 'aaaaaaaaaa bbbbbbbb cccccc', '2024-10-12 09:23:46', '2024-10-21 05:34:12'),
(5, 'test4', '$2y$10$wvEc2yleaJv6G/kcomIHV.SfVjqere2huUgUmh/vK8Xq2/.dRsr4q', '111111112222222', 'test444@gmail.com', '../dashboard_assets/img/uploads/chadengle.jpg', 1, 'aaaa bbbbbb ccccccc ddddd', '2024-10-12 10:00:53', '2024-10-21 06:35:06');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
