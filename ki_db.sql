-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2024 at 04:40 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ki_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `school_id` varchar(50) NOT NULL,
  `class_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `school_id`, `class_name`) VALUES
(1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `educators`
--

CREATE TABLE `educators` (
  `name` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `emergency_contact` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `educators`
--

INSERT INTO `educators` (`name`, `gender`, `phone_number`, `emergency_contact`, `email`, `dob`, `location`, `school`) VALUES
('karl ben', 'male', '0549724470', '7777778855', 'h@t.com', '2024-06-12', 'yt', 'school1'),
('isaac', 'male', '0849724876', '7777778855', 'heabax50@rc3s.com', '2024-06-26', 'ga', 'school2'),
('isaac nyann', 'female', '1240937796', '7777778855', 'hebabax50@rc3s.com', '2024-07-06', 'yt', 'school1'),
('isaac', 'male', '1240935596', '1240937598', 'hebabax850@rc3s.com', '2024-06-12', 'town', 'school3'),
('kodi smoke', 'female', '1240937599', '7777778855', 'kofi@g.com', '2024-06-13', 'kotokrom', 'school3'),
('Henry Bon', 'male', '0549724776', '7777778855', 'philnita.gh2@gmail.com', '2024-06-18', 'jcvjvjj', 'school2'),
('big one', 'male', '0549784476', '1240937598', 'u@gt.com', '2024-06-11', 'fiapre', 'school1'),
('Henry Bonney', 'male', '0549724876', '7777778855', 'user5@site.com', '2024-06-13', '', 'school2'),
('Kwams jon', 'male', '0589724476', '1240937598', 'user@sike.com', '2024-06-28', 'cnc', 'school1'),
('isaac nyann', 'male', '0549724476', '7777778855', 'user@site.com', '2024-06-13', '', 'school2'),
('isaac nyann', 'male', '0549424476', '1240937598', 'uyer@site.com', '2024-06-14', 'gh', 'school3');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `school_id` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `town` varchar(50) NOT NULL,
  `educator` varchar(50) NOT NULL,
  `school_name` varchar(100) NOT NULL,
  `school_logo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`school_id`, `region`, `town`, `educator`, `school_name`, `school_logo`) VALUES
('', '', '', '', '', ''),
('0', 'south', 'fukuoka', 'bright', 'glory prep', 'uploads/passport.png');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `passport_picture` varchar(100) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `hand` varchar(10) NOT NULL,
  `foot` varchar(10) NOT NULL,
  `eye_sight` varchar(20) NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `guardian_name` varchar(100) NOT NULL,
  `guardian_phone_number` varchar(15) NOT NULL,
  `guardian_whatsapp_number` varchar(15) DEFAULT NULL,
  `guardian_email_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','educator','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'henry', '$2y$10$mcLkkWHLjohJ6aHVzDHLluniMtniZvXLz6tSgc1b9SpCehidxVbfO', 'admin'),
(2, 'isaac', '$2y$10$5HOSLbTpchNfXVWa1hH4nu1Wlz0C7/OjU8dEJo6mDySkwEYY79CeG', 'educator'),
(3, 'cat123', '$2y$10$njDQsWcu3m8yGk.u0R.Yuu0vtHX0zIJp7HMl62Fhuvlg1vpDXTGca', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `educators`
--
ALTER TABLE `educators`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
