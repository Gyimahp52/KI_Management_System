-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 02:56 PM
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
('04ff6054', 'class3', 'DRI0640'),
('48692667', 'class2', 'HAN0085'),
('8bf0d97b', 'class1', 'TAN0160'),
('b8fd584d', 'class2', 'TAN0160'),
('c063117b', 'class1', 'ACC0323');

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
('kofi ben', 'male', '0789724476', '7777778855', 'henrybonney92@gmail.com', '2024-07-23', 'jcvjvjj', 'school3'),
('satou-san', 'male', '0546924476', '0247778855', 'ita.gh2@gmail.com', '2024-07-23', 'fiapre', 'school3'),
('kodi smoke', 'female', '1240937599', '7777778855', 'kofi@g.com', '2024-06-13', 'kotokrom', 'school3'),
('Henry Bon', 'male', '0549724776', '7777778855', 'philnita.gh2@gmail.com', '2024-06-18', 'jcvjvjj', 'school2'),
('james', 'male', '1240937726', '7756778855', 'pp@gmail.com', '2024-07-25', 'yt', 'school1'),
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
('ACC0323', 'Bono Region', 'fukuoka', 'ben', 'accra high', 'uploads/green man.PNG'),
('DRI0299', 'Northern Region', 'fukuoka', 'koo', 'drieamfield', 'uploads/green man.PNG'),
('DRI0640', 'Northern Region', 'osaka', 'ben', 'drieamfield', 'uploads/class.PNG'),
('HAN0085', 'Northern Region', 'osaka', 'ben', 'hansonhigh', ''),
('ROG0143', 'Ashanti', 'osaka', 'Bridget', 'roger prep', ''),
('TAN0160', 'Northern Region', 'fukuoka', 'ben', 'tanoso high', '');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(8) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passport_picture` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `hand` enum('Left','Right','Ambidextrous') NOT NULL,
  `race` enum('Asian','Black','Hispanic','White','Other') NOT NULL,
  `eye_sight` enum('Normal','Nearsighted','Farsighted') NOT NULL,
  `height_cm` int(11) NOT NULL,
  `weight_kg` int(11) NOT NULL,
  `class_id` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `password`, `passport_picture`, `name`, `date_of_birth`, `gender`, `hand`, `race`, `eye_sight`, `height_cm`, `weight_kg`, `class_id`) VALUES
('DR92234', '123456', '555', 'henry', '2024-07-25', 'Male', 'Right', 'Black', '', 58, 23, '04ff6054');

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
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
