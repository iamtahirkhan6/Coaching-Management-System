-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2019 at 01:58 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myrl`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned`
--

CREATE TABLE `assigned` (
  `assignment_id` smallint(6) NOT NULL,
  `student_id` smallint(6) NOT NULL,
  `subject_id` smallint(6) NOT NULL,
  `teacher_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `assigned`
--

INSERT INTO `assigned` (`assignment_id`, `student_id`, `subject_id`, `teacher_id`) VALUES
(1, 0, 1, 1),
(2, 0, 4, 1),
(3, 1, 1, 1),
(4, 1, 4, 1),
(5, 1, 6, 3),
(6, 2, 4, 1),
(7, 3, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` smallint(5) UNSIGNED NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_phone_number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `teacher_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_name`, `student_phone_number`, `email`, `password`, `teacher_id`) VALUES
(1, 'Tahir Khan', '8770923395', 'tahir_khan@gmail.com', '0123456789', 1),
(2, 'Kamil Siddiqui', '7224853798', 'kamil_siddiqui@gmail.com', '0123456789', 1),
(3, 'Gabriella Jennings', '1811520725', 'gabriella.jennings@example.com', '123321321', 2),
(4, 'Charlotte E. Knox', '7024532473', 'CharlotteEKnox@dayrep.com', '111111111', 3),
(5, 'Randall Vasquez', '3645135489', 'randall.vasquez@example.com', 'woodman', 1),
(6, 'Sophia Barnett', '4152006306', 'sophia.barnett@gmail.com', '11111111111111111', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` smallint(5) UNSIGNED NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `teacher_id`) VALUES
(4, 'Computer Graphics', 1),
(1, 'Computer Networks', 1),
(2, 'DBMS', 2),
(6, 'Java', 3),
(3, 'Web Development', 5);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` smallint(5) UNSIGNED NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `teacher_phone_number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `teacher_name`, `teacher_phone_number`, `email`, `password`) VALUES
(1, 'Rajesh Sen', '8765238461', 'rajesh_sen@gmail.com', '013254870'),
(2, 'Shweta Gupta', '8456989224', 'shweta_gupta@gmail.com', '77777777x'),
(3, 'Atul Gupta', '7485454798748', 'atulgupta@gmail.com', '1111111111111'),
(4, 'Akriti Sharma', '95954465465', 'AkritiSharma@gmail.com', '111111333333'),
(5, 'Dileep Singh', '897451245484', 'DileepSingh@gmail.com', 'vfnjkgjnav'),
(6, 'Randeep Hooda', '8456325874', 'RandeepHooda@gmail.com', '1222222222222');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned`
--
ALTER TABLE `assigned`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `assignments` (`student_id`,`subject_id`,`teacher_id`) USING BTREE;

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_phone_number` (`student_phone_number`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `unique_subjects` (`subject_name`,`teacher_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned`
--
ALTER TABLE `assigned`
  MODIFY `assignment_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
