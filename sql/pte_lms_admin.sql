-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 08:53 AM
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
-- Database: `pte_lms_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignemployee`
--

CREATE TABLE `assignemployee` (
  `class_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `assigned_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignstudent`
--

CREATE TABLE `assignstudent` (
  `batch_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `enrollment_date` date DEFAULT NULL,
  `activation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignstudent`
--

INSERT INTO `assignstudent` (`batch_id`, `student_id`, `enrollment_date`, `activation`) VALUES
(15, 1, '2023-09-15', 0),
(16, 2, '2023-09-16', 0),
(52, 3, '2023-09-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `assigntest`
--

CREATE TABLE `assigntest` (
  `batch_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `assigned_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignvideo`
--

CREATE TABLE `assignvideo` (
  `batch_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `assigned_on` date DEFAULT NULL,
  `ispresent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignvideo`
--

INSERT INTO `assignvideo` (`batch_id`, `video_id`, `assigned_on`, `ispresent`) VALUES
(15, 1, '2023-10-16', 1),
(16, 1, '2023-09-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `role` varchar(250) DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `leave_id` int(11) DEFAULT NULL,
  `ispresent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `employee_id`, `student_id`, `role`, `attendance_date`, `leave_id`, `ispresent`) VALUES
(84, NULL, 1, NULL, '2023-09-21', 1, 1),
(85, NULL, 3, NULL, '2023-09-21', NULL, 1),
(86, NULL, 1, NULL, '2023-09-20', NULL, 1),
(87, NULL, 2, NULL, '2023-09-20', NULL, 1),
(88, NULL, 3, NULL, '2023-09-20', NULL, 1),
(89, NULL, 2, NULL, '2023-09-19', NULL, 1),
(90, NULL, 3, NULL, '2023-09-19', NULL, 1),
(91, NULL, 2, NULL, '2023-09-18', NULL, 1),
(92, NULL, 3, NULL, '2023-09-18', NULL, 1),
(93, NULL, 2, NULL, '2023-09-17', NULL, 1),
(94, NULL, 3, NULL, '2023-09-17', NULL, 1),
(95, NULL, 1, NULL, '2023-09-16', NULL, 1),
(96, NULL, 2, NULL, '2023-09-16', NULL, 1),
(97, NULL, 3, NULL, '2023-09-16', NULL, 1),
(98, NULL, 1, NULL, '2023-09-15', NULL, 1),
(99, NULL, 2, NULL, '2023-09-15', NULL, 1),
(100, NULL, 1, NULL, '2023-09-23', NULL, 1),
(101, NULL, 3, NULL, '2023-09-23', NULL, 1),
(102, 57, NULL, NULL, '2023-09-23', NULL, 1),
(103, 60, NULL, NULL, '2023-09-23', NULL, 1),
(104, 63, NULL, NULL, '2023-09-23', NULL, 1),
(105, 66, NULL, NULL, '2023-09-23', NULL, 1),
(106, 57, NULL, NULL, '2023-09-20', NULL, 1),
(107, 58, NULL, NULL, '2023-09-20', NULL, 1),
(108, 60, NULL, NULL, '2023-09-20', NULL, 1),
(109, 61, NULL, NULL, '2023-09-20', NULL, 1),
(110, 62, NULL, NULL, '2023-09-20', NULL, 1),
(111, 63, NULL, NULL, '2023-09-20', NULL, 1),
(112, 64, NULL, NULL, '2023-09-20', NULL, 1),
(113, 65, NULL, NULL, '2023-09-20', NULL, 1),
(114, 66, NULL, NULL, '2023-09-20', NULL, 1),
(115, 67, NULL, NULL, '2023-09-20', NULL, 1),
(116, 68, NULL, NULL, '2023-09-20', NULL, 1),
(117, NULL, 1, NULL, '2023-09-17', NULL, 1),
(118, NULL, 2, NULL, '2023-09-17', NULL, 1),
(119, NULL, 3, NULL, '2023-09-17', NULL, 1),
(120, NULL, 2, NULL, '2023-09-17', NULL, 1),
(121, NULL, 1, NULL, '2023-09-26', NULL, 1),
(122, NULL, 3, NULL, '2023-09-26', NULL, 1),
(123, 57, NULL, NULL, '2023-09-26', NULL, 1),
(124, 58, NULL, NULL, '2023-09-26', NULL, 1),
(125, 61, NULL, NULL, '2023-09-26', NULL, 1),
(126, 64, NULL, NULL, '2023-09-26', NULL, 1),
(127, 66, NULL, NULL, '2023-09-26', NULL, 1),
(128, 68, NULL, NULL, '2023-09-26', NULL, 1),
(129, NULL, 1, NULL, '2023-09-25', NULL, 1),
(130, NULL, 2, NULL, '2023-09-25', NULL, 1),
(131, NULL, 1, NULL, '2023-09-23', NULL, 1),
(132, NULL, 2, NULL, '2023-09-23', NULL, 1),
(133, NULL, 3, NULL, '2023-09-23', NULL, 1),
(134, 57, NULL, NULL, '2023-09-27', NULL, 1),
(135, 58, NULL, NULL, '2023-09-27', NULL, 1),
(136, 60, NULL, NULL, '2023-09-27', NULL, 1),
(137, 61, NULL, NULL, '2023-09-27', NULL, 1),
(138, 62, NULL, NULL, '2023-09-27', NULL, 1),
(139, 68, NULL, NULL, '2023-09-27', NULL, 1),
(140, NULL, 1, NULL, '2023-10-06', NULL, 1),
(141, NULL, 3, NULL, '2023-10-06', NULL, 1),
(142, NULL, 1, NULL, '2023-10-03', NULL, 1),
(143, NULL, 2, NULL, '2023-10-03', NULL, 1),
(144, NULL, 2, NULL, '2023-10-04', NULL, 1),
(145, NULL, 1, NULL, '2023-10-05', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batch_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `program` varchar(250) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `time_from` time DEFAULT NULL,
  `time_to` time DEFAULT NULL,
  `activation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `name`, `program`, `class_id`, `time_from`, `time_to`, `activation`) VALUES
(15, 'Batch01', 'Program I', 1, '12:12:00', '12:12:00', 1),
(16, 'Batch02', 'Program II', 4, '12:12:00', '12:12:00', 1),
(18, 'Batch03', 'Program I', 4, '12:12:00', '12:12:00', 0),
(19, 'Batch04', 'Program I', 1, '12:12:00', '12:12:00', 1),
(20, 'Batch05', 'Program IV', 1, '12:12:00', '12:12:00', 1),
(21, 'Batch06', 'Program IV', 4, '12:12:00', '12:12:00', 0),
(48, 'Batch024', 'Program I', 4, '12:12:00', '12:12:00', 1),
(49, 'Batch_Agie', 'Program IV', 1, '12:12:00', '12:02:00', 0),
(50, 'Batch0121', 'Program I', 4, '12:12:00', '12:12:00', 0),
(51, 'Batch0192', 'Program I', 4, '12:12:00', '12:12:00', 0),
(52, 'Batch09121', 'Program II', 2, '12:12:00', '12:12:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `name`, `days`) VALUES
(1, 'CLASS I', 90),
(2, 'CLASS II', 90),
(3, 'CLASS III', 90),
(4, 'CLASS IV', 90);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `role` varchar(250) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `qualification` varchar(250) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `name`, `email`, `role`, `phone`, `address`, `qualification`, `username`, `password`, `activation`) VALUES
(57, 'asdd', 'asdd@sadas.asdsd', 'asdsd', 702036268, 'asd', 'asdsd', 'asdsa', '$2y$10$10uFMzUKg8CIXhn/IXvX4eHZwlulhtLdxHNXjp.nhWaea6OOSHnyK', 0),
(58, 'asdd', 'asdd@sadas.asdsd', 'asdsd', 702036268, 'asd', 'asdsd', 'asdsa', '$2y$10$8zVM7jt9HF5teiZJZ.8UketzEwBud8o3Pt3DxxFN6jMwz6nNC.i9e', 0),
(60, 'Kamal', 'Wimal@gas.com', 'dfsdf', 702036268, 'asdsd', 'asadasd', 'asdsdsad', '$2y$10$DjbH5N7XEUKaEen1PnzqPecQbfkFIg7xYrrdtNf1WGjdOmDIJyK4C', 1),
(61, 'Kamal', 'Wimal@gas.com', 'dfsdf', 702036268, 'asdsd', 'asadasd', 'asdsdsad', '$2y$10$LGjCqaJBf8qBRT087YSA7.ag.9UHiz7N/ssrOcQpugcM5Fl71XXFO', 1),
(62, 'adwdwd', 'jas@asd.asd', 'xxcxzc', 702036268, 'sdsd', 'zxcsd', 'sdfdsf', '$2y$10$WYkqPbR2HxVrOWF0b455LuXqksCddPzLtzUAvYY0ZHDY9pseOJ4qm', 1),
(63, 'adwdwd', 'jas@asd.asd', 'xxcxzc', 702036268, 'sdsd', 'zxcsd', 'sdfdsf', '$2y$10$dA/Y/rFaOU2hctZvA0lVBuxidEDq5kfnmeu8Gg5N6D7Q9vZAVqFDS', 1),
(64, 'asdasd', 'asdas@asd.asd', 'zxc', 1234567891, 'asdasd', 'asdasd', 'asdasd', '$2y$10$lv/1oLBZD8tGoesxgH4c3uzsogoOXx0bXZGBmVWL5OYEgORHCeoqe', 1),
(65, 'asdasd', '', NULL, 702036268, NULL, NULL, '', '', 1),
(66, 'Sunil', 'Kamal@asd.com', 'asdasd', 891212123, 'asas', 'asas', 'asasas', '$2y$10$OlFlKY8kJIjZMEodbDugPedyW8KL3eFklBidr9NWD18HwgwEH9f3K', 1),
(67, 'KAmala', 'asdasd@asdas.com', 'asasd', 1234567891, 'asdasd', 'sdsadad', 'adadad', '$2y$10$/NBDSFE5GdUu37fAgnp6J.UbVUULjxSIJUXDBtqQrFhs5bJ/6.iHi', 1),
(68, 'adasdasd', 'asdasd@sdsd.sdsd', 'adassad', 1234567891, 'xvxvv', 'xvvxv', 'xvxvvx', '$2y$10$J1VyEb4KoiPY9wYOmMWreemXV51TlVJzosTI9eLj64wZ/VzjPJV6e', 0),
(69, 'Nimala Kasadini', 'nialasd@ukasd.com', 'Instructor', 702036268, '31asd,asdsa asdalasd, asdSASD', 'N/A', 'Nkmasl0912', '$2y$10$L6dx3SF8wirHxZPJk8MrB.fyH3zm6nhw3wlwkEbzhL6hfJ8wHuCeW', 1),
(70, 'Niwantha', 'niwa123@ikma.com', 'Kamalsad', 912034290, 'adasdsdsad', 'kasdmasdasd', 'asdasdasdasd', '$2y$10$LJelHCJN8sqwDbHqMjmkv.YqjgKjbwlKwyP3wjDtoVWuodrZPH246', 0),
(71, 'Kamal', 'Kasdas@asd.com', 'asdasd', 713253017, 'sdasdsad', 'asdasd', 'sdsadad', '$2y$10$fazxZNwnpcRSG.oZGI8/heBQ5F0Jry0ebW9RMWg5xte4XoUcWNK9W', 1),
(72, 'Imalakasd', 'asdasd@asd.com', 'asdasd', 891212191, 'asdsad', 'adasd', 'Kamal', '$2y$10$kknpkzsXH/2Sr57ue20X4utufcliIz3QrNrcJFvjWNo1HxV0.bjU.', 1),
(73, 'adasd', 'janams@zsd.com', 'aasd', 702036268, 'asdasd', 'asdasd', 'a12as', '$2y$10$5Umq8E0sLgzDfYlaxU50vuX6jdSI/iDOIpfJWcHup8Xn4MQ36k0G6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `evaluation_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `attempted_on` date DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `evaluation_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`evaluation_id`, `student_id`, `test_id`, `attempted_on`, `transaction_id`, `evaluation_on`) VALUES
(15, 3, 2, '2023-10-10', 7, '2023-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `leavetable`
--

CREATE TABLE `leavetable` (
  `leave_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `role` varchar(250) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `leave_type` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leavetable`
--

INSERT INTO `leavetable` (`leave_id`, `student_id`, `employee_id`, `role`, `start_date`, `end_date`, `leave_type`, `status`) VALUES
(1, 1, NULL, 'asdasd', '2023-09-21', '2023-09-14', 'asdasda', 'asasd');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `activation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `phone`, `activation`) VALUES
(1, 'Kamal', 702036268, 0),
(2, 'Nimali', 777828290, 1),
(3, 'Shamali', 713253017, 1);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `module` varchar(250) DEFAULT NULL,
  `category` varchar(250) DEFAULT NULL,
  `level` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `name`, `module`, `category`, `level`) VALUES
(1, 'PTE_Listning II Practicle', 'PTE_Listning', 'Listning', 'medium'),
(2, 'PTE_Listning III Practicle', 'PTE_Listning', 'Listning', 'medium'),
(3, 'PTE_Reading III Practicle', 'PTE_Reading', 'Reading', 'medium'),
(4, 'PTE_Reading I Practicle', 'PTE_Reading', 'Reading', 'medium'),
(5, 'PTE_Reading II Practicle', 'PTE_Reading', 'Reading', 'medium');

-- --------------------------------------------------------

--
-- Table structure for table `testass`
--

CREATE TABLE `testass` (
  `batch_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `assigned_on` date DEFAULT NULL,
  `ispresent` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testass`
--

INSERT INTO `testass` (`batch_id`, `test_id`, `assigned_on`, `ispresent`) VALUES
(15, 1, '2023-10-16', 1),
(52, 2, '2023-10-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_no` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `issue` varchar(250) NOT NULL,
  `issue_type` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `comments` varchar(250) DEFAULT NULL,
  `action` varchar(250) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_no`, `date`, `issue`, `issue_type`, `status`, `comments`, `action`, `student_id`, `employee_id`, `rating`) VALUES
(1, '2023-09-21', 'Assign Test', 'Complaint', 'Pending', 'By checking these points and using debugging statements, you can identify and resolve the issue with the tooltips not showing as expected.', 'Re-Ope', 1, NULL, 5),
(2, '2023-09-14', 'Assign Test ', 'Complaint', 'Resolved', 'In this modified code, the tooltip will display the full comment text, regardless of whether it overflows the cell or not. It simply shows the entire text when you hover over the comment column.', NULL, NULL, 60, 4);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `transactiontype` varchar(250) NOT NULL,
  `type` varchar(250) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `transactiontype`, `type`, `amount`, `date`, `description`, `student_id`) VALUES
(2, 'Credit', 'Founding', 1000, '2023-10-06', 'September founding money', NULL),
(3, 'Debit', 'Test payment', 40, '2023-10-07', 'PTE Writing test payment', 1),
(4, 'Debit', 'Test payment', 40, '2023-10-09', 'PTE Writing test payment', 3),
(5, 'Debit', 'Test payment', 40, '2023-10-09', 'PTE Spoken test payment', 2),
(6, 'Debit', 'Test payment', 40, '2023-10-10', 'PTE Grammer test payment', 2),
(7, 'Credit', 'Founding', 500, '2023-10-12', 'September Second founding money', NULL),
(8, 'Debit', 'Test payment', 30, '2023-10-13', 'PTE Spoken test payment', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`) VALUES
(1, 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `video_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `video_file` varchar(250) NOT NULL,
  `module` varchar(250) NOT NULL,
  `time_duration` time DEFAULT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `name`, `video_file`, `module`, `time_duration`, `level`) VALUES
(1, 'PTE_Lesson I', 'lesson1.mp4', 'Lesson I', '24:59:15', 'medium'),
(2, 'PTE_Lesson II', 'lesson121.mp4', 'Lesson II', '24:59:15', 'medium'),
(3, 'PTE_Lesson III', 'lesson11.mp4', 'Lesson III', '24:59:15', 'hard'),
(4, 'PTE_Lesson IV', 'lesson11.mp4', 'Lesson IV', '24:59:15', 'hard');

-- --------------------------------------------------------

--
-- Table structure for table `watched`
--

CREATE TABLE `watched` (
  `student_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `assigned_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignemployee`
--
ALTER TABLE `assignemployee`
  ADD PRIMARY KEY (`class_id`,`employee_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `assignstudent`
--
ALTER TABLE `assignstudent`
  ADD PRIMARY KEY (`batch_id`,`student_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `assigntest`
--
ALTER TABLE `assigntest`
  ADD PRIMARY KEY (`batch_id`,`test_id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `assignvideo`
--
ALTER TABLE `assignvideo`
  ADD PRIMARY KEY (`batch_id`,`video_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `leave_id` (`leave_id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `leavetable`
--
ALTER TABLE `leavetable`
  ADD PRIMARY KEY (`leave_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `testass`
--
ALTER TABLE `testass`
  ADD PRIMARY KEY (`batch_id`,`test_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_no`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`video_id`);

--
-- Indexes for table `watched`
--
ALTER TABLE `watched`
  ADD PRIMARY KEY (`student_id`,`video_id`),
  ADD KEY `video_id` (`video_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `leavetable`
--
ALTER TABLE `leavetable`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignemployee`
--
ALTER TABLE `assignemployee`
  ADD CONSTRAINT `assignemployee_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `assignemployee_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`);

--
-- Constraints for table `assignstudent`
--
ALTER TABLE `assignstudent`
  ADD CONSTRAINT `assignstudent_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `assignstudent_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `assigntest`
--
ALTER TABLE `assigntest`
  ADD CONSTRAINT `assigntest_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `assigntest_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `test` (`test_id`);

--
-- Constraints for table `assignvideo`
--
ALTER TABLE `assignvideo`
  ADD CONSTRAINT `assignvideo_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `assignvideo_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`),
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`leave_id`) REFERENCES `leavetable` (`leave_id`);

--
-- Constraints for table `batch`
--
ALTER TABLE `batch`
  ADD CONSTRAINT `batch_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`);

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `test` (`test_id`),
  ADD CONSTRAINT `evaluation_ibfk_3` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`);

--
-- Constraints for table `leavetable`
--
ALTER TABLE `leavetable`
  ADD CONSTRAINT `leavetable_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `leavetable_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `watched`
--
ALTER TABLE `watched`
  ADD CONSTRAINT `watched_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `watched_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
