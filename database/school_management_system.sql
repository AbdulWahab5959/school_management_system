-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2024 at 11:52 AM
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
  `class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('Present','Leave','Absent','') DEFAULT 'Present',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `class_id`, `teacher_id`, `student_id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(27, 10, 6, 182, '2024-10-27', 'Leave', '2024-10-27 10:37:49', '2024-10-27 10:37:49'),
(28, 10, 6, 185, '2024-10-27', 'Leave', '2024-10-27 10:37:49', '2024-10-27 10:37:49'),
(31, 10, 6, 182, '2024-10-27', 'Present', '2024-10-27 11:16:15', '2024-10-27 11:16:15'),
(32, 10, 6, 185, '2024-10-27', 'Present', '2024-10-27 11:16:15', '2024-10-27 11:16:15'),
(33, 10, 6, 182, '2024-10-02', 'Absent', '2024-10-27 11:19:21', '2024-10-27 11:19:21'),
(34, 10, 6, 185, '2024-10-02', 'Absent', '2024-10-27 11:19:21', '2024-10-27 11:19:21'),
(35, 10, 6, 182, '2024-10-28', 'Present', '2024-10-27 11:39:28', '2024-10-27 11:39:28'),
(36, 10, 6, 185, '2024-10-28', 'Present', '2024-10-27 11:39:28', '2024-10-27 11:39:28'),
(57, 10, 6, 182, '2024-10-29', 'Present', '2024-10-29 13:20:59', '2024-10-29 13:20:59'),
(58, 10, 6, 185, '2024-10-29', 'Present', '2024-10-29 13:20:59', '2024-10-29 13:20:59'),
(71, 10, 6, 182, '2024-10-30', 'Present', '2024-10-30 06:38:20', '2024-10-30 06:38:20'),
(72, 10, 6, 185, '2024-10-30', 'Present', '2024-10-30 06:38:20', '2024-10-30 06:38:20'),
(75, 10, 6, 182, '2024-10-31', 'Present', '2024-10-31 00:49:49', '2024-10-31 00:54:03'),
(76, 10, 6, 185, '2024-10-31', 'Present', '2024-10-31 00:49:49', '2024-10-31 00:54:03');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_record`
--

CREATE TABLE `attendance_record` (
  `id` int(11) NOT NULL,
  `class_id` varchar(255) NOT NULL,
  `title` varchar(10) NOT NULL DEFAULT 'Marked',
  `start_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attendance_record`
--

INSERT INTO `attendance_record` (`id`, `class_id`, `title`, `start_time`) VALUES
(5, '10', 'Marked', '2024-10-30'),
(6, '10', 'Marked', '2024-10-31');

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
(1, 'Class 1', 11, 'A', 25, 2500, 0, '2024-10-11 09:49:45', '2024-10-23 07:54:24'),
(2, 'Class 2', 3, 'A', 25, 1500, 1, '2024-10-12 09:42:18', '2024-10-25 14:02:41'),
(3, 'Class 1', 21, 'B', 25, 2500, 1, '2024-10-14 12:22:57', '2024-10-25 07:17:57'),
(4, 'Class 3', 1, 'A', 25, 3000, 1, '2024-10-21 10:30:27', '2024-10-23 10:08:11'),
(5, 'Class 4', 9, 'A', 25, 2500, 1, '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(6, 'Class 5', 8, 'A', 25, 2400, 1, '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(7, 'Class 6', 10, 'A', 25, 2300, 1, '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(8, 'Class 7', 4, 'A', 25, 2200, 1, '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(9, 'Class 8', 5, 'A', 25, 2100, 1, '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(10, 'Class 9', 6, 'A', 25, 2000, 1, '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(11, 'Class 10', 7, 'A', 25, 1900, 1, '2024-10-11 09:49:45', '2024-10-22 12:09:02');

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
(7, 'admin', 'admin@gmail.com', '$2y$04$KGTc5LJW5.blnvaG0YyZYuVzJ5DmghM4QT2EVG0ocT5J4N9U0yWCG', '../uploads/profile2.jpg', '2024-10-09 05:26:09', '2024-10-23 16:09:10');

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
(2, 'test4', 'test4@gmail.com', '$2y$10$vXui8IoKg1zW6FGAPckzzeSL8tN5AkErZBqx2C830OxLzv0o/F26e', '1234567', 2, '../uploads/67191dd33ad85.jpg', 1, 'aaaa bbbbb ccc ddd ', '2024-10-10 10:47:39', '2024-10-25 07:24:06'),
(3, 'test224', 'test224@gmail.com', '$2y$10$cItcBg1IViRfiDUhioRS2.ZLwuaQ6m.WjwINuzP9Cp/oulIk9x2FC', '1111111 2222 33333 4444', NULL, '../uploads/profile2.jpg', 0, 'aaaaaaa bbbbb cccccccc', '2024-10-10 10:59:20', '2024-10-21 06:33:33'),
(7, 'test1234', 'test1234@gmail.com', '$2y$10$u4mRpUH6m9C/iTGsN29yVup/JZlQHlMuhkJIjFLkzcqY6NjjVwKry', '1111111 2222 33333', 1, '../uploads/profile2.jpg', 1, 'ssssssssssss aaaaaaaaaa cccccccc', '2024-10-11 18:56:51', '2024-10-14 04:02:08'),
(8, 'test15', 'test15@gmail.com', '$2y$04$nVF/E7IPkOq8wVz/FjS3v.ftvFg2BUmMsEtudwC8JVtxIxHSswOF2', '1111111 2222 33333 4444', 6, '../uploads/mlane.jpg', 1, 'aaa bb cc', '2024-10-14 06:20:57', '2024-10-21 05:46:32'),
(29, 'Alice Johnson', 'alice.johnson3@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '3456789012', 6, '../uploads/mlane.jpg', 1, '789 Oak St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(31, 'Charlie Davis', 'charlie.davis5@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '5678901234', 4, '../uploads/profile2.jpg', 1, '202 Birch St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(32, 'David Wilson', 'david.wilson6@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '6789012345', 6, '../uploads/mlane.jpg', 1, '303 Pine St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(34, 'Frank Miller', 'frank.miller8@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '8901234567', 4, '../uploads/profile2.jpg', 1, '505 Walnut St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(35, 'Grace Lee', 'grace.lee9@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '9012345678', 6, '../uploads/mlane.jpg', 1, '606 Cherry St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(37, 'Ivy King', 'ivy.king11@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '9876543210', 4, '../uploads/profile2.jpg', 1, '808 Cypress St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(38, 'Jack Green', 'jack.green12@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '8765432109', 6, '../uploads/mlane.jpg', 1, '909 Willow St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(39, 'Karen Hill', 'karen.hill13@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '7654321098', 1, '../uploads/profile2.jpg', 1, '100 Magnolia St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(40, 'Leo Scott', 'leo.scott14@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '6543210987', 4, '../uploads/profile2.jpg', 1, '111 Fir St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(41, 'Mona Adams', 'mona.adams15@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '5432109876', 6, '../uploads/profile2.jpg', 1, '122 Spruce St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(42, 'Nick Harris', 'nick.harris16@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '4321098765', 1, '../uploads/profile2.jpg', 1, '133 Hemlock St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(43, 'Olive Martin', 'olive.martin17@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '3210987654', 4, '../uploads/profile2.jpg', 1, '144 Alder St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(44, 'Paul Baker', 'paul.baker18@school.edu', '$2y$10$kG.vHby6WPdT4Mh2/OyxSOPt1lSqRENMkMFo8/rZM56hG.ETo45Sa', '2109876543', 6, '../uploads/profile2.jpg', 1, '155 Poplar St', '2024-10-21 07:17:48', '2024-10-21 07:17:48'),
(45, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(46, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(47, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(48, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(49, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(50, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(51, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(52, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(53, 'Test Student 9', 'test9@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 9, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(54, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(55, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(56, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(57, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(58, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(59, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(60, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(61, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(62, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(63, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(64, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(65, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(66, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(67, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(68, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(69, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(70, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(71, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(72, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(73, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(74, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(75, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(76, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(77, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(78, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(79, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(80, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(81, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(82, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(83, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(84, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(85, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(86, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(87, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(88, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(89, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(90, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(91, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(92, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(93, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(94, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(95, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(96, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(97, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(98, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(99, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(100, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(101, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(102, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(103, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(104, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(105, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(106, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(107, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(108, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(109, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(110, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(111, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(112, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(113, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(114, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(115, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(116, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(117, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(118, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(119, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(120, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(121, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(122, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(123, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(124, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(125, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(126, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(127, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(128, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(129, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(130, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(131, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(132, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(133, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(134, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(135, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(136, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(137, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(138, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(139, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(140, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(141, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(142, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(143, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(144, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(145, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(146, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(147, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(148, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(149, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(150, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(151, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(152, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(153, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(154, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(155, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(156, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(157, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(158, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(159, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(160, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(161, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(162, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(163, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(164, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(165, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(166, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(167, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(168, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(169, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(170, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(171, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(172, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(173, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(174, 'Test Student 1', 'test1@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(175, 'Test Student 2', 'test2@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(176, 'Test Student 3', 'test3@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 3, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(177, 'Test Student 4', 'test4@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 4, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(178, 'Test Student 5', 'test5@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 5, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(179, 'Test Student 6', 'test6@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 6, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(180, 'Test Student 7', 'test7@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 7, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(181, 'Test Student 8', 'test8@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 8, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(182, 'Test Student 10', 'test10@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 10, '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(183, 'Test Student 11', 'test11@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 1, '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(184, 'Test Student 12', 'test12@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 2, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(185, 'Test Student 100', 'test100@gmail.com', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 10, '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02');

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
(1, 'test2', '$2y$10$2vLJAm/.za8Z/oFHgaQsZuOfQgy1salwgTa4qvCzl7u.km9pCRFyi', '12345678', 'test22@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaa, aaaaaa, bbbb', '2024-10-10 03:37:27', '2024-10-23 08:21:57'),
(2, 'test1122', '$2y$10$hH/7BjYKc3YzlnXSdrCISeeqBG4QGM5bLe/8gZCIn3j9JU.ACbhsK', '1111111 2222 33333', 'test1122@gmail.com', '../uploads/6716abb2136bf.jpg', 0, 'aaaaaaaaaa bbbbbbbb cccccc', '2024-10-12 09:23:46', '2024-10-23 07:21:11'),
(3, 'test4', '$2y$10$wvEc2yleaJv6G/kcomIHV.SfVjqere2huUgUmh/vK8Xq2/.dRsr4q', '111111112222222', 'test444@gmail.com', '../uploads/6716abb2136bf.jpg', 0, 'aaaa bbbbbb ccccccc ddddd', '2024-10-12 10:00:53', '2024-10-23 07:16:46'),
(4, 'Teacher 4', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher4@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(5, 'Teacher 5', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher5@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(6, 'Teacher 6', '$2y$10$2vLJAm/.za8Z/oFHgaQsZuOfQgy1salwgTa4qvCzl7u.km9pCRFyi', '12345678', 'teacher6@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(7, 'Teacher 7', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher7@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(8, 'Teacher 8', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher8@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(9, 'Teacher 9', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher9@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(10, 'Teacher 10', '$2y$10$2vLJAm/.za8Z/oFHgaQsZuOfQgy1salwgTa4qvCzl7u.km9pCRFyi', '12345678', 'teacher10@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(11, 'Teacher 11', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher11@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-23 07:06:15'),
(12, 'Teacher 12', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher12@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(13, 'Teacher 13', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher13@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(14, 'Teacher 14', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher14@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(15, 'Teacher 15', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher15@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(16, 'Teacher 16', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher16@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(17, 'Teacher 17', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher17@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(18, 'Teacher 18', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher18@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(19, 'Teacher 19', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher19@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(20, 'Teacher 20', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher20@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(21, 'Teacher 1', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher1@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(22, 'Teacher 2', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher2@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'aaaaaa', '2024-10-11 09:49:45', '2024-10-22 12:09:02'),
(23, 'Teacher 3', '$2y$10$EfvNdfjmx4nDWkH02TYugOwgczn2MtJMviTFp.jliR1...', '12345678', 'teacher3@gmail.com', '../uploads/6716abb2136bf.jpg', 1, 'bbbb', '2024-10-11 09:49:45', '2024-10-22 12:09:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`) USING BTREE;

--
-- Indexes for table `attendance_record`
--
ALTER TABLE `attendance_record`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `fk_class` (`class_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `attendance_record`
--
ALTER TABLE `attendance_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
