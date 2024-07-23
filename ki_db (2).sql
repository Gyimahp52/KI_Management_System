-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2024 at 11:47 AM
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
  `class_id` varchar(8) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `school_id` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `school_id`) VALUES
('6695595c', 'fp2', 'ROG0014'),
('66955961', 'fp3', 'ROG0014'),
('66965caf', 'grade 1', 'GLO0018'),
('6696d062', 'pena', 'ROG0014');

-- --------------------------------------------------------

--
-- Table structure for table `educators`
--

CREATE TABLE `educators` (
  `id` int(11) NOT NULL,
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

INSERT INTO `educators` (`id`, `name`, `gender`, `phone_number`, `emergency_contact`, `email`, `dob`, `location`, `school`) VALUES
(1, 'karl ben', 'male', '0549724470', '7777778855', 'h@t.com', '2024-06-12', 'yt', 'school1'),
(3, 'isaac nyann', 'female', '1240937796', '7777778855', 'hebabax50@rc3s.com', '2024-07-06', 'yt', 'school1'),
(4, 'isaac', 'male', '1240935596', '1240937598', 'hebabax850@rc3s.com', '2024-06-12', 'town', 'school3'),
(5, 'kofi ben', 'male', '0789724476', '7777778855', 'henrybonney92@gmail.com', '2024-07-23', 'jcvjvjj', 'school3'),
(6, 'satou-san', 'male', '0546924476', '0247778855', 'ita.gh2@gmail.com', '2024-07-23', 'fiapre', 'school3'),
(10, 'james', 'male', '1240937726', '7756778855', 'pp@gmail.com', '2024-07-25', 'yt', 'dreamfield'),
(16, 'james jons', 'male', '0543724476', '1240237598', 'admin@james.com', '2024-07-16', 'fiapre', 'school1');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` varchar(8) NOT NULL,
  `region` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `educator` varchar(255) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `school_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `region`, `town`, `educator`, `school_name`, `school_logo`) VALUES
('GLO0018', 'Bono Region', 'Fiapre', 'james', 'Glory Int', 'WOOD ENGRAVING.PNG'),
('MEL0947', 'Bono Region', 'jons', 'isaac', 'meloody Int', '_commission__jonathan_2_by_adpong_df47j85-fullview.jpg'),
('ROG0014', 'Bono Region', 'fukuoka', 'mane', 'gh', 'classssesss.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `class_id` varchar(8) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `hand` enum('Right','Left','Ambidextrous') DEFAULT NULL,
  `foot` enum('Right','Left') DEFAULT NULL,
  `eye_sight` varchar(50) DEFAULT NULL,
  `medical_condition` text DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `parent_name` varchar(100) DEFAULT NULL,
  `parent_phone` varchar(20) DEFAULT NULL,
  `parent_whatsapp` varchar(20) DEFAULT NULL,
  `parent_email` varchar(100) DEFAULT NULL,
  `passport_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `class_id`, `name`, `dob`, `gender`, `hand`, `foot`, `eye_sight`, `medical_condition`, `height`, `weight`, `parent_name`, `parent_phone`, `parent_whatsapp`, `parent_email`, `passport_picture`) VALUES
(2, '66965caf', 'isaac nyann', '2024-07-18', 'Male', 'Right', 'Right', 'blue', 'bad', '27.00', '43.00', 'James ', '0579724476', '0579724476', 'amin@admin.com', 'df2b5rz-62f53641-fd10-4ec2-a009-c01e45f7c8bb.jpg');

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
(3, 'cat123', '$2y$10$njDQsWcu3m8yGk.u0R.Yuu0vtHX0zIJp7HMl62Fhuvlg1vpDXTGca', 'student'),
(4, 'FIXGQMU', '$2y$10$b80YNvLAqkPQfDFZ2EtLIOIR65gtwFAWJM0cNdq.PdYkz3VypC.3O', 'student'),
(5, 'GLZMFQX', '$2y$10$b8qL6YW2nJ/XuyQJBjm4o.E0qsnednTkVtLLofEOFgJja0dzrzQBm', 'student'),
(6, 'isaac', '$2y$10$w4OeJCh0RC.jjuaJHHeVM.MiUYsqq1KTaUvIGp.O9DuWiQQhx3RKa', 'educator'),
(7, 'james', '$2y$10$6L9zk9ddf/1hlyTx93XKt.9FqmI3z72CNH2B9AOEwoAt5Y0zttJhq', 'educator');

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `educators`
--
ALTER TABLE `educators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
