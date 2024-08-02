-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2024 at 06:02 PM
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
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(11) NOT NULL,
  `year_name` varchar(9) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `year_name`, `start_date`, `end_date`) VALUES
(1, '2023/2024', '2024-07-01', '2024-10-30'),
(2, '2024/2025', '2024-01-01', '2024-12-01'),
(3, '2025/2026', '2024-07-01', '2024-10-10');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(8) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `school_id` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `school_id`) VALUES
(1, 'Nursery 1', 'DRE0751'),
(2, 'Nursery 2', 'DRE0751'),
(3, 'KG-1', 'DRE0751'),
(4, 'KG-2', 'DRE0751'),
(5, 'CLASS 1A', 'DRE0751'),
(6, 'CLASS 1B', 'DRE0751'),
(7, 'CLASS 2A', 'DRE0751'),
(8, 'CLASS 2B', 'DRE0751'),
(9, 'CLASS 3A', 'DRE0751'),
(10, 'CLASS 3B', 'DRE0751'),
(11, 'CLASS 4A', 'DRE0751'),
(12, 'CLASS 4B', 'DRE0751'),
(13, 'CLASS 5A', 'DRE0751'),
(14, 'CLASS 5B', 'DRE0751'),
(15, 'CLASS 6', 'DRE0751');

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
-- Table structure for table `historical_school_themes`
--

CREATE TABLE `historical_school_themes` (
  `id` int(11) NOT NULL,
  `school_id` varchar(8) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `academic_year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `historical_school_themes`
--

INSERT INTO `historical_school_themes` (`id`, `school_id`, `theme_id`, `term_id`, `academic_year_id`) VALUES
(1, 'GLO0018', 1, 1, 1),
(2, 'GLO0018', 2, 1, 1),
(3, 'GLO0018', 3, 1, 1),
(4, 'GLO0018', 4, 1, 1),
(5, 'GLO0018', 5, 1, 1),
(6, 'GLO0018', 6, 1, 1),
(7, 'GLO0018', 7, 1, 1),
(8, 'GLO0018', 1, 2, 1),
(9, 'GLO0018', 2, 2, 1),
(10, 'GLO0018', 3, 2, 1),
(11, 'GLO0018', 1, 2, 3),
(12, 'GLO0018', 2, 2, 3),
(13, 'GLO0018', 1, 2, 1),
(14, 'GLO0018', 2, 2, 1),
(15, 'GLO0018', 3, 2, 1),
(16, 'GLO0018', 8, 9, 1),
(17, 'GLO0018', 9, 9, 1),
(18, 'GLO0018', 10, 9, 1),
(19, 'GLO0018', 8, 9, 1),
(20, 'GLO0018', 9, 9, 1),
(22, 'GLO0018', 8, 10, 3),
(23, 'GLO0018', 12, 18, 3),
(24, 'GLO0018', 13, 18, 3),
(25, 'GLO0018', 14, 18, 3),
(26, 'GLO0018', 15, 18, 3),
(27, 'GLO0018', 16, 18, 3),
(28, 'MEL0947', 12, 18, 3),
(29, 'MEL0947', 13, 18, 3),
(30, 'MEL0947', 14, 18, 3),
(31, 'MEL0947', 15, 18, 3),
(32, 'MEL0947', 16, 18, 3),
(33, 'ROG0014', 12, 18, 3),
(34, 'ROG0014', 13, 18, 3),
(35, 'ROG0014', 14, 18, 3),
(36, 'ROG0014', 15, 18, 3),
(37, 'ROG0014', 16, 18, 3),
(38, 'ROG0503', 12, 18, 3),
(39, 'ROG0503', 13, 18, 3),
(40, 'ROG0503', 14, 18, 3),
(41, 'ROG0503', 15, 18, 3),
(42, 'ROG0503', 16, 18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `historical_student_scores`
--

CREATE TABLE `historical_student_scores` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `date_assessed` date DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `academic_year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `historical_student_scores`
--

INSERT INTO `historical_student_scores` (`id`, `student_id`, `theme_id`, `score`, `date_assessed`, `term_id`, `academic_year_id`) VALUES
(1, 2, 1, 2, '2024-07-02', 1, 1),
(2, 2, 2, 3, '2024-07-02', 1, 1),
(3, 2, 3, 4, '2024-07-02', 1, 1),
(4, 2, 4, 5, '2024-07-02', 1, 1),
(5, 2, 5, 3, '2024-07-02', 1, 1),
(6, 2, 6, 6, '2024-07-02', 1, 1),
(7, 2, 7, 3, '2024-07-02', 1, 1),
(8, 2, 1, 2, '2024-07-02', 2, 1),
(9, 2, 2, 5, '2024-07-02', 2, 1),
(10, 2, 3, 8, '2024-07-02', 2, 1),
(11, 2, 1, 2, '2024-07-02', 2, 1),
(12, 2, 2, 5, '2024-07-02', 2, 1),
(13, 2, 1, 2, '2024-07-16', 2, 1),
(14, 2, 2, 5, '2024-07-16', 2, 1),
(15, 2, 3, 0, '2024-07-16', 2, 1),
(23, 2, 1, 2, '2024-07-01', 2, 3),
(24, 2, 2, 3, '2024-07-01', 2, 3),
(25, 2, 1, 2, '2024-07-17', 2, 3),
(26, 2, 2, 2, '2024-07-17', 2, 3),
(27, 2, 1, 8, '2024-07-26', 2, 1),
(28, 2, 2, 8, '2024-07-26', 2, 1),
(29, 2, 3, 7, '2024-07-26', 2, 1),
(30, 2, 8, 2, '2024-07-29', 9, 1),
(31, 0, 33, 8, '2024-08-01', 25, 1),
(32, 0, 34, 3, '2024-08-01', 25, 1),
(33, 0, 35, 5, '2024-08-01', 25, 1),
(34, 0, 40, 5, '2024-08-01', 25, 1),
(35, 0, 33, 3, '2024-08-01', 25, 1),
(36, 0, 34, 4, '2024-08-01', 25, 1),
(37, 0, 35, 3, '2024-08-01', 25, 1),
(38, 0, 40, 4, '2024-08-01', 25, 1),
(39, 0, 33, 4, '2024-08-01', 25, 1),
(40, 0, 34, 4, '2024-08-01', 25, 1),
(41, 0, 35, 3, '2024-08-01', 25, 1),
(42, 0, 33, 3, '2024-08-01', 25, 1),
(43, 0, 33, 5, '2024-08-01', 25, 1),
(44, 0, 33, 4, '2024-08-01', 25, 1),
(45, 0, 33, 3, '2024-08-01', 25, 1),
(46, 0, 33, 7, '2024-08-01', 25, 1),
(47, 0, 33, 3, '2024-08-01', 25, 1),
(48, 0, 33, 3, '2024-08-01', 25, 1);

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
('DRE0751', 'Bono Region', 'Sunyani', '3', 'Dreamfield International School', ''),
('GLO0018', 'Bono Region', 'Fiapre', 'james', 'Glory Int', 'WOOD ENGRAVING.PNG'),
('MEL0947', 'Bono Region', 'jons', 'isaac', 'meloody Int', '_commission__jonathan_2_by_adpong_df47j85-fullview.jpg'),
('ROG0014', 'Bono Region', 'fukuoka', 'mane', 'gh', 'classssesss.PNG'),
('ROG0503', 'Bono Region', 'osaka', 'james', 'roger prep ', 'MSE2.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `school_themes`
--

CREATE TABLE `school_themes` (
  `id` int(11) NOT NULL,
  `school_id` varchar(8) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_themes`
--

INSERT INTO `school_themes` (`id`, `school_id`, `theme_id`, `term_id`) VALUES
(115, 'GLO0018', 33, 18),
(117, 'MEL0947', 33, 18),
(118, 'MEL0947', 34, 18),
(119, 'MEL0947', 35, 18),
(120, 'DRE0751', 34, 18),
(121, 'DRE0751', 35, 18),
(122, 'DRE0751', 40, 18),
(125, 'DRE0751', 33, 25),
(126, 'DRE0751', 41, 25);

-- --------------------------------------------------------

--
-- Table structure for table `sel_themes`
--

CREATE TABLE `sel_themes` (
  `id` int(11) NOT NULL,
  `theme_name` varchar(255) DEFAULT NULL,
  `competency` varchar(255) DEFAULT NULL,
  `character_strength` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sel_themes`
--

INSERT INTO `sel_themes` (`id`, `theme_name`, `competency`, `character_strength`) VALUES
(33, 'flexibility ', 'SOH', 'SOH'),
(34, 'gh', 'fy', 'uj'),
(35, 'fg', 'ghf', 'ftgh'),
(36, 'fg', 'ghf', 'uj'),
(37, 'fg', 'fy', 'ftgh'),
(38, 'fg', 'ghfg', 'ftgh'),
(39, 'gh', 'ghf', 'ffh'),
(40, 'fg', 'ghf', 'ftgh'),
(41, 'gh', 'ghfg', 'uj');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(50) NOT NULL,
  `class_id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `hand` enum('Right','Left','Ambidextrous') DEFAULT NULL,
  `foot` enum('Right','Left') DEFAULT NULL,
  `eye_sight` varchar(50) DEFAULT NULL,
  `medical_condition` text DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` mediumint(9) DEFAULT NULL,
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
('DR0001', 1, 'Jerone Boahen Dekyi', '2021-10-20', 'Male', '', '', '', '', 0, 0, 'Mark Dekyi', '024532260', '024532260', '', ''),
('DR0002', 1, 'Kwame Ameyaw Nyarko', '2021-02-13', 'Male', '', '', '', '', 0, 0, 'Mercy Baah Nyarko', '0243241025', '0241906908', 'nyarkomercy74@gmail.com', ''),
('DR0003', 1, 'Janelle Maame Boahemaa', '2021-03-18', 'Female', '', '', '', '', 0, 0, 'Abigail Aboagyewaa', '', '0554375143', '', ''),
('DR0004', 1, 'Merrick Gyau Anokye', '2021-12-07', 'Male', '', '', '', '', 0, 0, 'Anokye Kwame Derrick', '0249147278', '0249147278', 'derrickolatore@gmail.com', ''),
('DR0005', 1, 'Blessing Amoabea Antepim', '2021-09-08', 'Female', '', '', '', '', 0, 0, 'Lydia Nyarko', '0244902063', '0244902063', '', ''),
('DR0006', 1, 'Arhin Baah Will', '2021-05-18', 'Male', '', '', '', '', 0, 0, 'Reyford Kweku Arhin', '0249592591', '0249592591', 'rex2015ford@gmail.com', ''),
('DR0007', 1, 'Apenteng Nana Adwoa Nyamekye', '2021-10-25', 'Female', '', '', '', '', 0, 0, 'Kwau Apenteng', '0551241353', '0207095583', '', ''),
('DR0008', 1, 'Apenteng Awuradwoa Nyamekye', '2021-10-25', 'Female', '', '', '', '', 0, 0, 'Kwau Apenteng', '0551241353', '0551241353', '', ''),
('DR0009', 1, 'Liannah Nhyia Mensah', '2021-10-09', 'Female', '', '', '', '', 0, 0, '', '0550191244', '055019244', '', ''),
('DR0010', 1, 'Ohenebaba Laurena Asantewaa Gyan', '2021-04-07', 'Female', '', '', '', '', 0, 0, 'Mr. Gyan', '0248708263', '0248708263', '', ''),
('DR0011', 9, 'Stephens Abraham Vak Abraham', '2015-06-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Suzzy Owusu', '0547972625', '0547972625', NULL, NULL),
('DR0012', 9, 'Elvis Nana Yeboah Bimpong', '2015-06-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Afia Frimpomaa', '0241471428', '0241471428', NULL, NULL),
('DR0013', 9, 'Prisca Effah', '2015-04-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Effah', '0243878692', '0243878692', 'reffah7@gmail.com', NULL),
('DR0014', 9, 'Nana Aksoua Kusi Adu Asare', '2015-06-28', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Vida Obeng', '0547813015', '0547813015', 'nyarkodll@gmail.com', NULL),
('DR0015', 9, 'Diamondtina Yireukyiwaa Aseidu', '2016-06-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ofori Asiedu Francis', '0243967877', '0243967877', 'francisoforiasiedu@gmail.com', NULL),
('DR0016', 9, 'Jeffery Kwabena Yeboaah', '2015-07-07', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charlotte Kumi', '0248381430', '0248381430', 'charlottekumi34@gmail.com', NULL),
('DR0017', 9, 'Angel Adwoa Asiamah', '2015-11-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abigail A. Sarpong', '0242577380', '0242577380', 'asarpongbiggles@gmail.com', NULL),
('DR0018', 9, 'Lilian Serwaa Yeboah', '2015-12-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Martha Asuamah Yeboah', '0245098694', '0245098694', NULL, NULL),
('DR0019', 9, 'Melody Brako Gyan', '2016-07-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Saah', '0541486676', '0541486676', NULL, NULL),
('DR0020', 9, 'Damoah Miracle Godfred', '2015-10-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Jospeh Kwasi Ampem', '0243451669', '0243451669', 'jakpee2006@yahoo.com', NULL),
('DR0021', 9, 'Edwin Addo Asamoah', '2014-12-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Prince Asamoah', '0244082901', '0244082901', 'prinmoah@gmail.com', NULL),
('DR0022', 9, 'Imam Biesoh-Adjoa Sayibu Kankah', '2015-10-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rafatu Sayibu', '0557291712', '0244082901', 'issifusayibu@yahoo.com', NULL),
('DR0023', 9, 'Ohemaa Audrey Asare', '2015-03-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephen Asare', '0246275797', '0246275797', 'asderrick46@gmail.com', NULL),
('DR0024', 9, 'Aseda Dankwah Boateng', '2015-09-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Gershon Gyamfi Boateng', '0024682107', '0246275797', 'gershon.gyamfi@gmai.com', NULL),
('DR0025', 9, 'Richmond Ofosu Manu', '2015-09-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Seth Manu', '0205169494', '0205169494', NULL, NULL),
('DR0026', 9, 'Lilian Arthur Mintah', '2015-03-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Lydia Okyere', '0241506737', '0207453125', 'lydiaokyere74@gmail.com', NULL),
('DR0027', 9, 'Quaye Klenam Petra', '2015-07-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Fiahortu Ama', '0206666870', '0206666870', 'fiahortuama@gmail.com', NULL),
('DR0028', 9, 'Fiona Owusu Ampofo', '2014-10-11', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bona Elizabeth', '0546311848', '0546311848', 'bonae760@gmail.com', NULL),
('DR0029', 9, 'Owusuaa Boakye Elikharis', '2016-03-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Asamoah Bemma Rachael', '0247162260', '0504595700', 'rachealbemma@gmail.com', NULL),
('DR0030', 9, 'Emmanuella Afriyie Kyere', '2015-05-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Aseiduwaa Rosemary', '0558650022', '0558650022', NULL, NULL),
('DR0031', 9, 'Duchess Kukua Nyarba Newton', '2015-12-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Pearl R.L. Newton', '0244679386', '0243151031', 'praspad1983@gmail.com', NULL),
('DR0032', 9, 'Jesse Opoku Gyan', '2015-09-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Alice Pimma', '0242262275', '0242262275', 'alicepimma4@gmail.com', NULL),
('DR0033', 9, 'Edwin Addo Asamaoh', '2014-04-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Prince Asamoah', '0244082901', '0244082901', 'prinmoah@gmail.com', NULL),
('DR0034', 9, 'Authur Kwadow Nimson', '2015-09-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0540832713', '0540832713', 'oduroblessing88@gmail.com', NULL),
('DR0035', 9, 'Eliezer Agyie Darkowaa', '2016-03-11', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Afia Owusuwaa', '0206810692', '0206810692', NULL, NULL),
('DR0036', 8, 'Desmond Anim Kofi', '2016-02-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Anim Atta Yaw', '0248775246', '0248775246', 'atta74850@gmail.com', NULL),
('DR0037', 8, 'Caleb Dannu Jnr', '2017-06-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Daanu Peter Blanskon', '0244114971', '0205668028', 'pdaanu@yahoo.com', NULL),
('DR0038', 8, 'Audrey Nhyira Owusu', '2017-01-26', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Cecilia Ntiamoah', '0245897910', '0245897910', 'ceciliantiamoah2@gmail.com', NULL),
('DR0039', 8, 'Cherish Adom Kissiwaa Waye', '2017-10-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rev.Waye Agyemang Badu', '0249831548', '0249831548', 'kumiclara17@gmail.com', NULL),
('DR0040', 8, 'Imran Abu Sadigue', '2017-11-13', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abu Sadigue', '0500639586', '0245813263', 'stacyamenor2@gmail.com', NULL),
('DR0041', 8, 'Jeremiah Okpoti Adjei', '2017-03-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Jonathan Adjei Akpor', '0207114772', '0207114772', 'jakpor@gmail.com', NULL),
('DR0042', 8, 'Oppong Kyere Pamela', '2014-08-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Somea Esther', '0557591929', '0557591929', NULL, NULL),
('DR0043', 8, 'Tei Ackwerh', '2017-01-28', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Enock Tetteh Ackwerh', '0246196881', '0246196881', 'celestinakorankye0@gmail.com', NULL),
('DR0044', 8, 'Nanama Sikafour Carabel Kyeremeh', '2016-09-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ampaabeng Kyeremeh', '0206319590', NULL, NULL, NULL),
('DR0045', 8, 'Samuel Dapaah', '2017-11-24', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Apostle Collins Dapaah', '0208190034', '0248266764', 'owusushadrach553@gmail.com', NULL),
('DR0046', 8, 'Afua Kyerewaa Nyarko', '2016-12-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Peter Nyarko', '0243241025', '0243241025', 'nnana2g@gmail.com', NULL),
('DR0047', 8, 'Samuel Osborn', '2016-03-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Sunny & Goodness', '0247418787', '0247418787', 'sunnychigozie77@gmail.com', NULL),
('DR0048', 8, 'Henry Opoku Boakye', '2017-01-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Bismark Opoku-Boakye', '0244242342', '0247418787', 'bopokuboakye@gmail.com', NULL),
('DR0049', 8, 'Danielle Aseda Ankah', '2016-12-11', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Michael Abraham Ankah', '0244853175', '0244853175', NULL, NULL),
('DR0050', 8, 'Adjei Nkunim Linette', '2017-01-13', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Eric Adjei', '0246893300', '0246893300', 'ericuspapaa@gmail.com', NULL),
('DR0051', 8, 'Takyiwaa Yeboaa Stephanie', '2017-03-27', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephen Kwabena Yeboah', '0558061236', '0558061236', NULL, NULL),
('DR0052', 8, 'Kingsford Kwame Kankam', '2016-03-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Knonama', '0245468482', '0245468482', 'obaapapeggie@gmail.com', NULL),
('DR0053', 8, 'Heleb Boateng Awuah', '2016-07-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Awuah Baffour Desmond', '0242323683', '0242323683', 'desbee20@gmail.com', NULL),
('DR0054', 8, 'Francis Kyere', '2016-09-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Kyere', '0244964700', '0244964700', 'maviskyere1983@gmail.com', NULL),
('DR0055', 8, 'Nubia Dedo Tetteh', '2016-06-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Joseph Tetteh', '0537263929', '0537263929', 'nenekpabitey7@gmail.com', NULL),
('DR0056', 8, 'Lucky Borngreat Boateng', '2016-01-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0595970993', '0595970993', 'Adams.boateng@gmail.com', NULL),
('DR0057', 10, 'Akyere Appiah-Kusi', '2016-03-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Elvis Brenya Appiah-Kusi', '0208433595', '0208433595', 'appikusi@yahoo.co.uk', NULL),
('DR0058', 10, 'Vida Elikm Sogbey', '2016-03-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Noble Sogbey', '0554370224', '0208433595', 'sogbeynoble1@gmail.com', NULL),
('DR0059', 10, 'Alvin Addai Frimpong', '2015-11-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Twenewaa Ernestina', '0243772626', '0243772626', 'etwenewaa@gmail.com', NULL),
('DR0060', 10, 'Chrispin Virsob Bangkewa Kuunifaa', '2015-03-17', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Lana Lydia Bewaale', '0242714153', '0242714153', 'leelan8444@gmail.com', NULL),
('DR0061', 10, 'Evodia Benewaa Acheaw', '2016-04-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ivy Sarbi-Ababio', '0245947095', '0245947095', NULL, NULL),
('DR0062', 10, 'Ohemaa Kuowa Osarfo Nyantakyi', '2016-02-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Osarfo Nyantakyi Emmanuel', '0245145156', '0245145156', NULL, NULL),
('DR0063', 10, 'Aaron Korkpoe', '2015-01-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adombor Prsicilla', '0594711505', '0594711505', 'adomborpriscilla@yahoo.com', NULL),
('DR0064', 10, 'Abena Boaduwaa Amponsah', '2015-03-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ing. Emmanuel Osafo', '0503601335', '0503601335', NULL, NULL),
('DR0065', 10, 'Paa Kwesi Nhyiraba Mbir Mefful', '2015-05-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Mefful', '0249292007', '0249292007', 'francismefful@gmail.com', NULL),
('DR0066', 10, 'Yeboah Garand Adjei', '2015-04-07', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Evans A. yeboah', '0208779050', '0243465398', 'yevans628@gmail.com', NULL),
('DR0067', 10, 'Joycelin Pokuaa Amponsah', '2015-07-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Amoako Fordjour', '0208935417', '0026494413', 'jenkofy@gmail.com', NULL),
('DR0068', 10, 'Margaret Semefa Dzameshie', '2015-02-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Dzameshie', '0547947194', '0547947194', 'vivianboateng348@gmail.com', NULL),
('DR0069', 10, 'Sallah Hawayn Mashat', '2014-04-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0537957288', '0537957288', NULL, NULL),
('DR0070', 10, 'Nathan Serwah sikapa Essel', '2015-12-17', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Essel', '0243948966', '0243948966', 'samuelessel408@gmail.com', NULL),
('DR0071', 10, 'Diana Amponsah', '2014-03-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0542540266', NULL, NULL, NULL),
('DR0072', 10, 'Nathaniel Obeng Kwasi', '2016-01-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Obeng Owura Kwadwo', '0208361408', NULL, NULL, NULL),
('DR0073', 10, 'Aaliyah Nana Abena Adams', '2015-10-13', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Andriana Aning', '0244214344', '0244214344', 'andriana1231988@gmail.com', NULL),
('DR0074', 10, 'Phineaas Fofie', '2015-06-23', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Fofie Christian', '0208826160', '0208826160', 'fofiechristian041@gmail.com', NULL),
('DR0075', 10, 'Dishnell Pomaa Amponsah', '2015-10-22', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anastasia Opoku Yeboah', '0265043914', '0265043914', 'anastasiabanson507@gmail.com', NULL),
('DR0076', 10, 'Michelle Nana Yaa Ntim', '2012-09-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rebecca Mensah', '0547271337', '0547271337', 'mensbeccs34@gmail.com', NULL),
('DR0077', 3, 'Brett Perry Mensah', '2019-04-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0550191244', '0550191244', NULL, NULL),
('DR0078', 3, 'Gloria Acheampong Kankam', '0000-00-00', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Konama', '0245468482', '0245468482', 'margaretkonama85@gmail.com', NULL),
('DR0079', 3, 'Daisy EwuraAdwoa Newton', '2020-05-18', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Pearl Rachel L. Newton', '0244679386', '0243151031', 'prapad1983@gmail.com', NULL),
('DR0080', 3, 'Adinkrah Noreen Agyei', '2019-07-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Gabriel Adinkra', '0557668311', '0557668311', 'nkukeziah7@gmail.com', NULL),
('DR0081', 3, 'Eugene Afriyie Osei', '2020-08-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Osei Antwi Dennis', '0556521655', '0508449959', 'oseidennis611@gmail.com', NULL),
('DR0082', 3, 'Apenteng Ohenemaa Yaa Agyemang', '2019-11-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Kwasi Apenteng', '0551241353', '0207095583', 'hiakwasi@gmail.com', NULL),
('DR0083', 3, 'Jeremy Kwabena Yeboah', '2019-12-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charlotte Kumi', '0248381430', '0248381430', 'charlottekumi34@gmail.com', NULL),
('DR0084', 3, 'Christian Adu-Poku Antwi', '2020-02-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Meshack Akwasi Antwi', '0205972854', '0243914831', NULL, NULL),
('DR0085', 3, 'Ankama Tachie Adom', '2020-05-04', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Tachie Yeboah Samuel', '0248152771', '0248152771', NULL, NULL),
('DR0086', 3, 'Raphael Adu Sarpong', '2019-08-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Bright Kofi Adu', '0245915876', '0245915876', 'brightadukofi@gmail.com', NULL),
('DR0087', 3, 'Jason Ayiyie Damoah Appiah', '2020-01-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Vivian Oforiwaa Damoah', '0208385405', '0208385405', 'vivianoforiwaa435@gmail.com', NULL),
('DR0088', 3, 'Emmanuella Elinam Zugah', '2020-05-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Zugah', '0243402456', '0243402456', 'kwamezugah@gmail.com', NULL),
('DR0089', 3, 'Daisy Nana-Mansah  Danso', '2019-12-31', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Azure Naomi', '0247116644', '0247116644', 'abawahnaomi94@gmail.com', NULL),
('DR0090', 3, 'Asne Osei-Adasa', '2024-11-14', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0245172863', '0245172863', 'oseikojo2a@gmail.com', NULL),
('DR0091', 4, 'Israel Ohene Gyan', '2019-04-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Saah', '0541486676', '0548054829', NULL, NULL),
('DR0092', 4, 'Fauqiyat Abu-Sadique', '2018-11-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abu-Sadique Seidu', '0245813263', '0206355143', 'Sadiqueabu1983@gmail.com', NULL),
('DR0093', 4, 'Edward Addo Sampaney', '2019-05-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Victoria Appiah', '0246410171', '0240862805', NULL, NULL),
('DR0094', 4, 'Joseph Amoo Ankah', '2019-06-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abraham Michael Ankah', '0244853175', '0244853175', 'supermike2765@gmail.com', NULL),
('DR0095', 4, 'Derrick Oppong Akantoa', '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Nana B. Akantoa', '0200181726', '0205287957', NULL, NULL),
('DR0096', 4, 'Jeffery Osei Djan', '2019-05-20', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Djan Emmanuel', '0544936689', '0247459303', NULL, NULL),
('DR0097', 4, 'Adjei Aseda Belva', '2018-11-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Eric Adjei', '0246893300', '0246893300', 'ericuspapaa@gamil.com', NULL),
('DR0098', 4, 'Irene Tukaata Ninfaazu', '2017-06-28', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samson Kpen-Nyine Ninfaazu', '0544400909', '0544400909', 'ogedesam@yahoo.com', NULL),
('DR0099', 4, 'Jefferey Arhin Dekyi', '2018-12-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mark Dekyi', '0245322618', '0245322618', NULL, NULL),
('DR0100', 4, 'Wesley Isidore Afriyie Mills', '2018-08-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mercy Mills', '0243768462', '0243768462', 'mercymills68@gmail.com', NULL),
('DR0101', 4, 'Rochelle Edith Sien', '2019-03-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Kyere', '0244964700', '0244964700', 'maviskyere1983@gmail.com', NULL),
('DR0102', 4, 'Kwaku Oppong Yeboah', '2018-03-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Lydia Kyere', '0246071057', '0246071057', 'obaakyere@gmail.com', NULL),
('DR0103', 4, 'Sampson Tettey Kabu', '2019-04-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Linda Adjei', '0547706057', '0547706057', 'kabusampson@gmail.com', NULL),
('DR0104', 4, 'Opoku Yeboah Cyril', '2019-12-23', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Opoku Prince Akantoa', '0242262275', '0242262275', 'alicepimma4@gmail.com', NULL),
('DR0105', 4, 'Yaa Agyeiwaa Nyarko', '2018-08-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Peter Nyarko', '0241906908', '0243241023', 'NNANA2G@GMAIL.COM', NULL),
('DR0106', 4, 'Israel Armah Adjei', '2019-01-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Veronica Kugblenu-Kantoh', '0243866873', '0243866873', 'obdat86@gmail.com', NULL),
('DR0107', 4, 'Konadu Joelyn Okyere', '2022-02-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Michael Effah Boateng', '0249716384', '0249716384', 'Michaeleffahboateng@gmail.com', NULL),
('DR0108', 4, 'Justice Gyimah Owusu', '2019-03-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mow Salamatu', '0245773331', '0245773331', 'Mowsalamatu69@gmail.com', NULL),
('DR0109', 4, 'Derick Akantoa', '2018-07-27', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0503819400', '0503819400', 'evelynakantoa@yahoo.com', NULL),
('DR0110', 4, 'Salifu Aayan', '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ramatu Salif', '0200036556', '0204209872', NULL, NULL),
('DR0111', 4, 'Andriana Dyice Jefferson-Yeribu', '2018-10-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abigail Anyan', '0243382565', '0243382565', 'abigailanyan@gmail.com', NULL),
('DR0112', 4, 'Samarhil Abu Sadique', '0000-00-00', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Fati Abu Sadique Seid', '0206355143', '0245813263', 'Sadiqueabu1983@gmail.com', NULL),
('DR0113', 4, 'Fedora Ama Anumel', '2019-07-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anthony Anumel', '0549706486', '0201364817', 'anthonyanumel87@gmail.com', NULL),
('DR0114', 4, 'Lawrencia Nyameye Ahia Quarcoo', '2019-06-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Juanita Ahia Quarcoo', '0209162150', '0209162150', 'juan83p@yahoo.com', NULL),
('DR0115', 13, 'Brenya Appiah-Kusi', '2013-10-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Diana Nketiah', '0205264063', '0244964700', 'nketiahdiana@yahoo.com', NULL),
('DR0116', 13, 'Mabel Agyeiwaa Ohemaa', '2013-02-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Emelia Saakuu', '0554379651', NULL, NULL, NULL),
('DR0117', 13, 'Jeffery Obiri Yeboah', '2010-08-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abrefa', '0242864336', '0242864336', 'charleskumahabrefa@gmail.com', NULL),
('DR0118', 13, 'Malvin Nsiah Korsash', '2013-04-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Aboagye Korsah', '0249631910', '0249631910', 'kwasikorsah80@gmail.com', NULL),
('DR0119', 13, 'Michelle Chinoso John', '2015-08-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Blessed Joy Chinoso', '0257645998', '0257645998', NULL, NULL),
('DR0120', 13, 'Kwabena Amankona Sakyi', '2013-10-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Sakyi', '0508803427', '0508803427', 'richardsakyi95@yahoo.com', NULL),
('DR0121', 13, 'Ataa Yaa Bernice', '2012-11-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Manu', '0024078459', '0024078459', NULL, NULL),
('DR0122', 13, 'Michelle Amosiwaa Asumadu', '2013-09-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Frimpong Salomey', '0244180889', '0244180889', 'ilady65921@gmail.com', NULL),
('DR0123', 13, 'Ivan Osei Asiamah', '2014-01-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abigail A. Sarpong', '0242577380', '0242577380', 'asarpongbiggles@gmail.com', NULL),
('DR0124', 13, 'Daniel Akantoa', '2013-03-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Nana Bennett Akantoa', '0261587629', '0205287957', NULL, NULL),
('DR0125', 13, 'Christel Naa-mwin Barika', '2013-09-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Lydia Bewak Lana', '0242714153', NULL, 'leelan84ww@yahoo.com', NULL),
('DR0126', 13, 'Richmond Okyere Ampoe Martinson', '2013-06-25', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Victoria Ofori Odette', '0540539484', '0540539484', 'odetteofori589@gmail.com', NULL),
('DR0127', 13, 'Gerald Kwabena Nina', '2011-12-27', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Emmanuel Bawa', '0208402309', '0208402309', 'patba54@gmail.com', NULL),
('DR0128', 13, 'Kelvin Owusu Donkor', '2012-04-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Juliet Owusus Donkor', '0540769799', '0540769799', NULL, NULL),
('DR0129', 13, 'Bridget Afriyie Kwarteng', '2013-04-17', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Vera Adoma Boakye', '0246221722', '0246221722', NULL, NULL),
('DR0130', 13, 'Prince Yeboah Yaang', '2013-08-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Stella/Richmond Yeboah', '0247048542', '0247048542', NULL, NULL),
('DR0131', 13, 'Devlyn Nhyira Obour', '2013-09-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Linda Twumasi', '0247633708', '0202333904', 'lintwumasi17@gmail.com', NULL),
('DR0132', 13, 'Nana Fosu Oteng-Ampofo', '2013-12-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Belinda D. Oteng-Ampofo', '0243267585', '0243267585', 'lynoteng1@outlook.com', NULL),
('DR0133', 13, 'Joseph Nathan Naounou', '2013-11-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Rose Naounou', '0598446229', '0598446229', 'rosnaounou7777@gmail.com', NULL),
('DR0134', 13, 'Gyasi Afia Agyemang', '2013-12-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Kwasi Apenteng', '0551241353', '0207095583', 'hiakwasi@gmail.com', NULL),
('DR0135', 13, 'Caleb Akyea Mensah', '2013-12-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adjei-Kwaa Mavis', '0241692990', '0241692990', NULL, NULL),
('DR0136', 6, 'Samuel Godwin', '2011-01-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Sunny & Goodness', '0247418787', '0247418787', 'sannychigozie770@gmail.com', NULL),
('DR0137', 6, 'Michael Abban Nuku', '2012-06-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'David Abban', '0245831138', '0245831138', 'abbans34.ad@gmail.com', NULL),
('DR0138', 6, 'Hanzzy Nana Aba Darllington', '2012-12-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ampofo Stella Ofori', '0541140449', '0541140449', NULL, NULL),
('DR0139', 6, 'Treymaine Carter Apraku', '2013-01-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Emma Ohenewaa', '0542677660', '0542677660', 'eohenewaa2102@gmail.com', NULL),
('DR0140', 6, 'Lordina Opoku Afrifa', '2012-09-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Naomi Amakwaa yeboah', '0244823663', '0244823663', 'naomiyeboahamankwaa22@gmail.com', NULL),
('DR0141', 6, 'Keizia Tiwaah Amponsah', '2012-07-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Amoako Fordjour', '0208935417', '0246494413', 'jenkofy@gmail.com', NULL),
('DR0142', 6, 'Nhyira Ama Adomako', '2013-09-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Adomako Johnson', '0248096810', '0208391963', NULL, NULL),
('DR0143', 6, 'Michelle Emmanuella Sieh', '2012-08-26', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'mavis Kyere', '0249664700', '0244823663', 'maviskyere1983@gmail.com', NULL),
('DR0144', 6, 'Vera Serwaa Kwakye', '2011-04-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Evelyn Asamoah Mensah', '0209173274', '0209173274', 'evelynasamoah26@gmail.com', NULL),
('DR0145', 6, 'Yeboah Badu Joycelyn', '2011-10-07', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Badu Johnson', '0201364119', '0547691448', 'jbadu268@gmail.com', NULL),
('DR0146', 6, 'Emile Owusu Ampofo', '2012-02-29', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bona Elizabeth', '0546311848', '0546311848', 'bonae760@gmail.com', NULL),
('DR0147', 6, 'Lordfred Yeboah', '2012-01-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Philomina Nketia', '0245077710', '0245077710', 'philomenayeboah82@gmail.com', NULL),
('DR0148', 6, 'Raihan Tipaya Shahadu', '2012-03-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mohammed Shani Shahadu', '0243880696', '0243880696', 'smshahdu@gmail.com', NULL),
('DR0149', 6, 'Nina Anim Boateng', '2012-10-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Anim Atta Yaw', '0248775246', '0248775246', 'atta74850@gmail.com', NULL),
('DR0150', 6, 'Princewell Kwadwo Asamoah', '2011-12-05', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Emelia Dadzie/ Prince Asamoah', '0244082901', '0244082901', 'prinmoah@gmail.ccom', NULL),
('DR0151', 6, 'Agyei Lilian', '2011-12-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Faustina Owusuaa', '0240627059', NULL, NULL, NULL),
('DR0152', 6, 'Prosper Ekow Abaidoo', '2010-10-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abaidoo Elizabeth', '0553646650', '0553646650', 'abaidooe3744@gmail.com', NULL),
('DR0153', 6, 'Asante Fonic', '2010-07-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0246868012', '0246868012', NULL, NULL),
('DR0154', 6, 'Adwoa Tumwaa Sakyi', '2012-10-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Sakyi', '0508803427', '0508803427', 'richardsakyi95@yahoo.com', NULL),
('DR0155', 6, 'Richmond Acheampong Christian', '2012-09-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Acheampng', '0243906745', '0243906745', 'richhandofgod45@gmail.com', NULL),
('DR0156', 6, 'Frimpong Isaace Kwame', '2011-09-17', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Isaac Frimpong Kofi', '0505903790', '0248866869', NULL, NULL),
('DR0157', 6, 'Agyemang Kingsforda', '2013-03-17', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Doris Ferka Oduro', '0557343019', '0554204014', NULL, NULL),
('DR0158', 6, 'Ayele Serwaa Elsie', '2012-11-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Asamoah Constance', '0552531981', '0201122678', NULL, NULL),
('DR0159', 6, 'Emmanuella Efua Egyir', '2013-05-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Patience Kyeraa', '0550720005', '0550720005', 'patiencekyeraa055@gmail.com', NULL),
('DR0160', 6, 'Mariam Lumenga Abdulai', '2012-09-18', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abdulai Sadia Zuberiru', '0554120451', '0554120451', 'abdulaisadiazubeiru@gmail.com', NULL),
('DR0161', 6, 'Gillian Duncan Kwarteng', '2012-11-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Joshua Amo Frimpong', '0555887873', '0555887873', 'mary.yzma@gmail.com', NULL),
('DR0162', 6, 'Boateng Nhyira Owusuaa', '2011-10-27', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Munufie Oforiwaa Adwoa', '0209639818', '0554323970', 'oforiwaamunufie@gamil.vom', NULL),
('DR0163', 6, 'Opoku Duah Michael', '2012-12-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Prince Opoku Akantoa', '0242262275', '0242262275', 'alicepimma4@gmail.com', NULL),
('DR0164', 6, 'Fidaus Pomaa Ibrahim', '2012-03-22', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bertha Temea', '0244047300', '0244047300', 'berthatemea@gmail.com', NULL),
('DR0165', 2, 'Astala Tyrese Apraku Twum', '2021-01-11', 'Male', '', '', '', '', 0, 0, 'Emma Ohenewaa', '0542677660', '0542677660', 'eohenewaa2101@gmail.com', ''),
('DR0166', 2, 'Adelaide Bermah effah', '2020-06-06', 'Female', '', '', '', '', 0, 0, 'Richard Effah', '0243898692', '0243898692', 'reffah7@gmail.com', ''),
('DR0167', 2, 'Aimee Aseda Afua Anumel', '2021-05-14', 'Female', '', '', '', '', 0, 0, 'Anthony Anumel', '0549706486', '0549706486', 'anthonyanumel81@gmail.com', ''),
('DR0168', 2, 'Blessing Banyap', '2021-03-09', 'Female', '', '', '', '', 0, 0, 'Moldabire Cynthia', '0540673451', '0540673451', 'cynthiamoldabire55@gmail.com', ''),
('DR0169', 2, 'Jawzad Katari Shahadu', '2021-03-02', 'Female', '', '', '', '', 0, 0, 'Mohammed Shani Shahadu', '0243880696', '0243880696', 'smshahdu@gmail.com', ''),
('DR0170', 2, 'Dzeamesi Mawuelipkim Benhamin Korsi', '2022-03-22', 'Male', '', '', '', '', 0, 0, 'Priscilla Badu Ntow', '0534687672', '0534687672', 'priscillantow12@gmail.com', ''),
('DR0171', 2, 'Kendra Boakye acheampong', '2021-01-09', 'Female', '', '', '', '', 0, 0, 'Amankwaa Abigail', '0256439936', '0256439936', 'izay.bobby@yahoo.com', ''),
('DR0172', 2, 'Eunice Afriyie Tweneboah Essel', '2020-06-02', 'Female', '', '', '', '', 0, 0, 'Samuel Essel', '0243948966', '0243948966', 'samuelessel408@gmail.com', ''),
('DR0173', 2, 'Mufti Abu Sadigue', '2020-08-20', 'Male', '', '', '', '', 0, 0, 'Abu Sadigue', '0245813263', '0500639586', 'stacyameno2@gmail.com', ''),
('DR0174', 2, 'Richlet Adepa Lolo', '2021-04-03', 'Female', '', '', '', '', 0, 0, 'Oppong Evans', '0247812626', '0247812626', '', ''),
('DR0175', 2, 'Aaron Amoah Manu', '2021-03-30', 'Male', '', '', '', '', 0, 0, 'Seth Manu', '0205169494', '0243841433', '', ''),
('DR0176', 2, 'Carol-Annie Awindol Amidini', '2020-10-10', 'Female', '', '', '', '', 0, 0, 'Theresa Ndago', '0243210497', '0243210497', 'thessndago@gmail.com', ''),
('DR0177', 2, 'Frank Adu Kwabena', '0000-00-00', 'Male', '', '', '', '', 0, 0, '', '0247981771', '0200914151', '', ''),
('DR0178', 2, 'Abigail Agyeiwaa Asiamah', '2020-05-15', 'Female', '', '', '', '', 0, 0, 'Abigail Agyeiwaa Sarpong', '0242577380', '0242577380', 'asarpongbiggles@gmail.com', ''),
('DR0179', 2, 'Ellena Ansu-Yeboah', '2021-02-10', 'Female', '', '', '', '', 0, 0, 'Lydia Kyere', '0246071057', '0246071057', 'obaakyere@gmail.com', ''),
('DR0180', 2, 'Richmond Nyametease Ahia Quarcoo', '2020-09-30', 'Male', '', '', '', '', 0, 0, 'Juanita Ahia Quarcoo', '0209162150', '0209162150', 'juan83p@yahoo.com', ''),
('DR0181', 12, 'Edrick Quaicoe Okyere', '2013-09-25', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charles Okyere', '0243841518', '0243841518', NULL, NULL),
('DR0182', 12, 'Oswald Takyi Adofo', '2014-10-23', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Gyiraa Vida', '0557282805', '0557282805', NULL, NULL),
('DR0183', 12, 'Shaun Raphael Sieh', '2014-05-05', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Kyere', '0244964700', '0244964700', 'maviskyere1983@gmail.com', NULL),
('DR0184', 12, 'Meldrick Kwakye Ampaw', '2014-07-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Sarah Ayiwa Aning', '0202365092', '0243955930', 'sarahyiwaaning@gmail.com', NULL),
('DR0185', 12, 'Kingsley Ackah Kwaw', '2014-09-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kingsford Ackah Kwaw', '0207387141', '0207387141', 'kingsfordackah01@gmail.com', NULL),
('DR0186', 12, 'Ofori Kusi Cyril', '2014-12-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kusi Francise-Alice Nyarko', '0506105015', '0208073033', NULL, NULL),
('DR0187', 12, 'David Kingsley Modey', '2014-04-17', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ameyaw Gyan', '0243413933', '+447909238783\n', 'nanayaw86@gmail.com', NULL),
('DR0188', 12, 'Eric Kwame Danso Snr.', '2013-06-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Agyeiwaa', '0243223539', '0243223539', 'margaretagyeiwaa400@gmail.com', NULL),
('DR0189', 12, 'Alexandra Boatemaa Oduro', '2014-12-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Helena Agyeiwaaa', '0502548650', '0502548650', 'helenaagyeiwaa76@gmail.com', NULL),
('DR0190', 12, 'Bryce Annor Walfred', '2014-05-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kyeraa Felicia', '0549187744', '0502548650', 'anor.emma@gmail.com', NULL),
('DR0191', 12, 'Twumasi Vanessah', '2014-09-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Twumasi Kwaku Emmanuel', '0547639020', '0502548650', 'etwumasikwaku@gmail.com', NULL),
('DR0192', 12, 'Beverly Nana Kumi Acheaw', '2014-12-29', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Quansah Sam Bernice', '0540183992', '0540183992', 'bernicequansah28@gmail.com', NULL),
('DR0193', 12, 'Ernest Agyemang Badu Kyeremeh', '2014-01-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ampaabeng Kyeremeh', '0206319590', '0206319590', NULL, NULL),
('DR0194', 12, 'Nhyira Ayisi Boateng', '2013-09-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Gershon Gyamfi Boateng', '0246825107', '0246825107', 'gershon.gyamfi@gmail.com', NULL),
('DR0195', 12, 'Vince Dankwah', '2014-06-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ruth Serwaa', '0544642864', '0544642864', 'joseph.dankwah@icloud.com', NULL),
('DR0196', 12, 'Enoch Korkpoe', '2013-11-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adombor Priscilla', '0594711505', '0594711505', 'adomborpriscilla@yahoo.com', NULL),
('DR0197', 12, 'Shamima Halkida Abdulai', '2015-01-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abdulai Sadia Zubeiru', '0554120451', '0554120451', 'abdulaisadiazubeiru', NULL),
('DR0198', 12, 'Edrick Okyere Quaicoe', '2013-09-25', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Okyere Charles', '0243841518', '0243841518', NULL, NULL),
('DR0199', 12, 'Herbert Oppong Badu', '2014-10-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Badu Johnson', '0547691448', '0547691448', 'jbadu268@gmail.com', NULL),
('DR0200', 11, 'Jessica Pokuaa Boakye', '2014-03-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bismark Opoku-Boakye', '0244242342', '0244242342', 'bopokuboakye@gmail.com', NULL),
('DR0201', 11, 'Majorie Gyemea Mensah', '2015-02-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Evelyn Asamoah Mensah', '2091732744', '0244242342', 'evelynasamoah16@gmail.com', NULL),
('DR0202', 11, 'Reginald Nana Asomaning', '2014-10-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kingsford Aomaning', '0243131906', '0243131906', 'kingsfordasomanin@gmail.com', NULL),
('DR0203', 11, 'Adjei-Nkansah Nyamekye Vanessa', '2014-10-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Eric Adjei', '0246893300', '0246893300', 'ericuspapaa@gmail.com', NULL),
('DR0204', 11, 'Lauretta Achiaa Obiri', '2014-11-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Douglas Addo', '0024862805', '0024862805', 'douglasaddo12@gmail.com', NULL),
('DR0205', 11, 'Osarfo Sikapa Kwartemaa Osarfo Nyantakyi', '2014-09-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Osarfo Nyantakyi Emmanuel', '0245145156', '0245145156', NULL, NULL),
('DR0206', 11, 'Persis Arkoh Adu', '2013-10-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bright Kofi Adu', '0245915876', '0245145156', 'brightadukofi@gmail.com', NULL),
('DR0207', 11, 'Vicentia Oforiwaa Asiedu', '2015-03-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ofori Asiedu Francis', '0243967877', '0245145156', 'francisoforiasiedu@gmail.com', NULL),
('DR0208', 11, 'Hrriet Nyarko Manu', '2011-03-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Seth Manu', '0243844433', '0205169494', NULL, NULL),
('DR0209', 11, 'Macbill Habel Clinton', '2012-05-20', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'I-raw Baman Lucky Clinton', '0244444849', '0245145156', 'info.mapping.gh@gmail.com', NULL),
('DR0210', 11, 'Ekow Dede Painstill', '2012-03-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Josephine Ehuren', '0244788898', '0244788898', 'jehuren38@gmail.com', NULL),
('DR0211', 11, 'Kofi Owusu Ameyaw', '2014-02-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ameyaw Gyan', '0243413933', '0243413933', NULL, NULL),
('DR0212', 11, 'Perez Amoako Danso', '2014-10-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Danso Kingsley', '0542737548', '0243413933', 'pastordansokingsley@gmail.com', NULL),
('DR0213', 11, 'Keziah Adinkrah Yeboah', '2014-11-30', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Agyeiwaa Augustina', '0557668311', '0243413933', 'nkukeziah7@gmail.com', NULL),
('DR0214', 11, 'Richlove Nketiah Kyere', '2013-07-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Aseiduwaa Rosemary', '0558650022', '0558650022', NULL, NULL),
('DR0215', 11, 'Pascaline Fredua-Agyeman', '2015-04-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Yvonne Fiamor', '0248978994', '0248978994', 'amayvonne23@gmail.com', NULL),
('DR0216', 11, 'Belvia Ocran', '2014-10-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Leticia Sam-Ocran', '0242761555', '0248978994', 'leticiasam17@gmail.com', NULL),
('DR0217', 11, 'Daniel Adjei Manu', '2013-11-16', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Cecilia Biney', '0246465968', '0248978994', 'cecil.maab@gmail.com', NULL),
('DR0218', 11, 'Gyamfi Prisca', '2014-06-07', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Foriwaa Georgina', '0507575033', '0552541498', NULL, NULL),
('DR0219', 11, 'Caleb Kwaku Nina', '2014-04-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Patience Bajike', '0244754354', '0248978994', 'patba54@gmail.com', NULL),
('DR0220', 11, 'Ransford Owusu Bumangama', '2014-12-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Winifred Baah', '0241173318', '0241173318', NULL, NULL),
('DR0221', 11, 'Eric Kwame Danso Jnr', '2013-06-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Agyeiwaa', '0243223539', '0243223539', 'margaretagyeiwaa400@gmail.com', NULL),
('DR0222', 11, 'Owusu Fosuaah Franklina', '2014-12-28', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Frank Owusu', '0244135757', '0244135757', 'frankowusu129@yahoo.com', NULL),
('DR0223', 11, 'Evangeline Aseda Ahia Quarcoo', '2015-02-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Juanita Ahia Quarcoo', '0209162150', '0209162150', 'juan83p@yahoo.com', NULL),
('DR0224', 13, 'Kwabena Pako Adu', '2013-06-11', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adu Emmauel', '0242759406', '0242759406', 'papasource@gmail.com', NULL),
('DR0225', 13, 'Falconer Kojo Prah', '2013-06-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kojo Kum Prah', '0244781908', '0244781908', 'prahkojo77@gmail.com', NULL),
('DR0226', 13, 'Cedella Mills', '2013-09-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Mercy Mills', '0243768462', NULL, 'mercymills68@gmail.com', NULL),
('DR0227', 13, 'Mercedes Agyeiwaa Anokye', '2013-11-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anokye Kwame Derrick', '0249147278', '0249147278', 'derrickolator@gmail.com', NULL),
('DR0228', 13, 'Naawemuo Junior', '2013-11-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Roger Wemuo', '0555721930', '0202332005', 'rogerwemuo@gmail.com', NULL),
('DR0229', 13, 'Thelma Appiah', '2013-03-03', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Meri Abubakari / Samuel Appiah', '0550326606', '0550326606', 'meriabubakari@gmail.com', NULL),
('DR0230', 13, 'Lewis Anyietewin Akanpami', '2013-12-11', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephanie Akua Ntow', '0246379546', '0246379546', 'steph.ntow1986@gmail.com', NULL),
('DR0231', 13, 'Tetteh Wayoe Ackwerh', '2013-03-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Celestina Korankye & Enoch', '0246196881', '0246196881', 'celestinakorankye0@gmail.com', NULL),
('DR0232', 13, 'Clinton Amen Brainy', '2010-10-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'I-Raw Baman Lucky Clinton', '0244444849', '0244444849', 'info.mapping.gh@gmail.com', NULL),
('DR0233', 13, 'Samuella Nana Yaa Abban', '2014-06-04', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'David Abban', '0245831138', '0245831138', 'abbans34.ad@gmail.com', NULL),
('DR0234', 13, 'Ataa Yaa Benedicta', '2012-11-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Manu', '2407801159', '0245831138', NULL, NULL),
('DR0235', 13, 'Aseidu Agyemang Kelvin', '2012-03-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Rosemond Aseidu Acheampong', '0544828628', '0205893463', 'nkofi8930@gmail.com', NULL),
('DR0236', 13, 'Christopher Annobil Fiifi Mefful', '2013-04-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Mefful', '0249292007', '0249292007', 'francismefful@gmail.com', NULL),
('DR0237', 13, 'Eric Opoku Kusi', '2013-10-30', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rita Oti Manu', '0206796763', '0206796763', 'ritaotimanu@gmail.com', NULL),
('DR0238', 5, 'Gerald Agyei Yeboah', '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Doris Adubea Boakye', '0209128555', '0209128555', 'DorisAdubea44@gmail.com', NULL),
('DR0239', 5, 'Jayden Kwabena Yeboah', '2017-11-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charlotte Kumi', '0248381430', '0248381430', 'charlottekumi34@gmail.com', NULL),
('DR0240', 5, 'Lucy Akomah Frimpong', '2017-08-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Asenso', '0550760444', '0550760444', 'mavisasenso@gmail.com', NULL),
('DR0241', 5, 'Priscilla Nkunim Nti', '2018-10-31', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Edward Nti', '0244079391', '0244079391', NULL, NULL),
('DR0242', 5, 'Stamley Nkunim Oppong', '2017-05-20', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Oppong Evans', '0247812626', '0247812626', NULL, NULL),
('DR0243', 5, 'Elianna Ajiabadek Akanpani', '2017-09-29', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephanie Akua Ntow', '0246379546', '0246379546', 'Steph.ntow1986@gmail.com', NULL),
('DR0244', 5, 'Isreal Fosu Nyamekye', '2018-08-27', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Fosu Rockson', '0558060344', '0558060344', 'livingrock75@gmail.com', NULL),
('DR0245', 5, 'Kwasi Kesse Sayan', '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Dora Tuah', '0541339977', '0541339977', NULL, NULL),
('DR0246', 5, 'Peter Domena Attafuah', '2018-02-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Miriam Otubea Attafuah', '0245788214', '0245788214', 'miriamotoo7@gmail.com', NULL),
('DR0247', 5, 'Spio Garbra Georgeth', '2018-09-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Gloria Asuamah', '0249513710', '0249513710', NULL, NULL),
('DR0248', 5, 'Chelsea Adwoa Kosowaa Kwarteng', '2018-12-31', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Sarah Amporofi', '0546440558', '0546440558', 'Sarahamprofi23@gmail.com', NULL),
('DR0249', 5, 'Korri-Norngne Kyla Yaaku', '2017-09-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Gifty Arthur Yaaka', '0244988388', '0578665535', 'giftyyarth@gmail.com', NULL),
('DR0250', 5, 'Edwin Addo Frimpong', '2017-12-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Twenewaa Ernestina', '0243772626', '0243772626', 'etwenewaa0@gmail.com', NULL),
('DR0251', 5, 'Bervelyn Aning Anokye', '2018-10-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anokye Kwame Derrick', '0249147278', '0249147278', 'derrickolator@gmail.com', NULL),
('DR0252', 5, 'Raphael Adusei', '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret konama', '0245468482', '0245468482', 'obaapapeggie@gmail.com', NULL),
('DR0253', 5, 'Jamima Adbulai Sidabo', '0000-00-00', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abdulai Sadia Zubeiru', '0242706571', '0242706571', 'abzubeiru@gmail.com', NULL),
('DR0254', 5, 'Kristodea Efua Baawa Mefful', '2018-04-27', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Mefful', '0249292007', '0249292007', 'francismefful@gmail.com', NULL),
('DR0255', 5, 'Ewurama Asereba Essel', '2017-11-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Essel', '0243948966', '0243948966', 'Samuelessel408@gmail.com', NULL),
('DR0256', 5, 'Gifted Aseda Teye Nanor', '2018-06-30', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephen Y. Nanor', '0246355077', '0246355077', 'stephananor97@gmail.com', NULL),
('DR0257', 5, 'Goldie Naana Asantewaa', '2017-11-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Sophia Asantewaa', NULL, '0209154665', NULL, NULL),
('DR0258', 5, 'Victory Afriyie Asomanmg', '2017-10-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Kingsford Asomanmg', '0243131906', '0243131906', NULL, NULL),
('DR0259', 6, 'Tachie Yeboah Elton', '2019-10-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Tachie Yeboah Samuel', '0248152771', '0248152771', NULL, NULL),
('DR0260', 6, 'Ohene Katakyie Osarfo Nyantakyi', '2018-07-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Nyantakyiwaa Helena', '0546999646', '0546999646', 'helenqsarfosikapamaame15@gmail.com', NULL),
('DR0261', 6, 'Akyea Mensah Mcjosh', '2018-04-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adjei-Kwaa Mavis', '0241692990', '0241692990', NULL, NULL),
('DR0262', 6, 'Takyi Yaa Nora', '2018-05-03', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0556465771', '0556465771', 'padyjulia3@gmail.com', NULL),
('DR0263', 6, 'Ampensrah Nyarko Evangle', '2017-07-07', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Elizebeth Nkankomago', '0208318945', NULL, 'lampensrahemmanuel123@gmail.com', NULL),
('DR0264', 6, 'Agyei Kofi Seth', '2017-07-07', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abaidoo Elizabeth', '0553646650', '0553646650', 'abaidooe3H@gmail.com', NULL),
('DR0265', 6, 'Spendylove A. Yeboah', '0000-00-00', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Clement Yeboah', '0612486626', '34612486606', 'clementyeboah24@gmail.com', NULL),
('DR0266', 6, 'Othniel Bennet Quaye', '2018-05-31', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Fiahortu Ama Beatrice', '0206666870', '0548698427', 'fiahortuama@gmail.com', NULL),
('DR0267', 6, 'Othniel Amissah Danso', '2017-10-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Danso Kingsley', '0542737548', '0542737548', 'pastordansokingsly@gmail.com', NULL),
('DR0268', 6, 'Geuel Nhyira Kyeremer Antwi', '2018-01-31', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Victoria Pomaa', '0547548655', '0547548655', 'victoriapomaa24@gmail.com', NULL),
('DR0269', 6, 'Salima Awomlie Ayomah', '2019-06-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0542937506', '0206626983', 'surayyayaro@gmail.com', NULL),
('DR0270', 6, 'Alexis-Desmond Manuel Asiedu', '0000-00-00', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Amarie Adna Awurama', '0209228620', '0209228620', 'adnaamarie17@gmail.com', NULL),
('DR0271', 6, 'Duke Kwamena A. Newton', '2018-02-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Pearl Rachel Newton', '0243151031', '0243151031', NULL, NULL),
('DR0272', 6, 'Dasnel Osei-Adasa', '2017-04-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0245172863', '0245172863', '0seikojo2a@gmail.com', NULL),
('DR0273', 6, 'Nova Sarpomaa Gyan', '2018-05-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Owusu Sarpomaa Mavis', '0509591709', '0509591709', 'mavisowusu123@gmail.com', NULL),
('DR0274', 6, 'Mcdiamond Frimpong-Manso', '2017-07-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Frimpong Yeboah', '0244348745', '0244348745', 'RFRIMPONG262@GMAIL.COM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_scores`
--

CREATE TABLE `student_scores` (
  `id` int(11) NOT NULL,
  `student_id` varchar(25) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL,
  `date_assessed` date DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_scores`
--

INSERT INTO `student_scores` (`id`, `student_id`, `theme_id`, `date_assessed`, `term_id`, `score`) VALUES
(221, 'DR0001', 33, '2024-08-02', 25, 5),
(222, 'DR0001', 34, '2024-08-02', 25, 4),
(223, 'DR0001', 35, '2024-08-02', 25, 4),
(224, 'DR0001', 40, '2024-08-02', 25, 4),
(225, 'DR0001', 41, '2024-08-02', 25, 5),
(226, 'DR0002', 33, '2024-08-02', 25, 4);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `academic_year_id` int(11) DEFAULT NULL,
  `term_number` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `academic_year_id`, `term_number`, `start_date`, `end_date`) VALUES
(25, 1, 1, '2024-08-01', '2024-09-30'),
(26, 1, 2, '2024-08-01', '2024-10-30');

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
(6, 'isaac', '$2y$10$w4OeJCh0RC.jjuaJHHeVM.MiUYsqq1KTaUvIGp.O9DuWiQQhx3RKa', 'educator'),
(7, 'james', '$2y$10$6L9zk9ddf/1hlyTx93XKt.9FqmI3z72CNH2B9AOEwoAt5Y0zttJhq', 'educator'),
(10, 'DR58479', '$2y$10$NzTmCffUsDBGJFUtu/AAUOKAmFf2A05FS5TMcNVJWUU6poUuVsQha', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `your_table_name`
--

CREATE TABLE `your_table_name` (
  `student_id` text DEFAULT NULL,
  `class_id` bigint(20) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `dob` text DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `hand` double DEFAULT NULL,
  `foot` double DEFAULT NULL,
  `eye_sight` double DEFAULT NULL,
  `medical_condition` double DEFAULT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `parent_name` text DEFAULT NULL,
  `parent_phone` double DEFAULT NULL,
  `parent_whatsapp` double DEFAULT NULL,
  `parent_email` text DEFAULT NULL,
  `passport_picture` double DEFAULT NULL,
  `source_sheet` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `your_table_name`
--

INSERT INTO `your_table_name` (`student_id`, `class_id`, `name`, `dob`, `gender`, `hand`, `foot`, `eye_sight`, `medical_condition`, `height`, `weight`, `parent_name`, `parent_phone`, `parent_whatsapp`, `parent_email`, `passport_picture`, `source_sheet`) VALUES
('DR0077', 3, 'Brett Perry Mensah', '2019-04-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 550191244, 550191244, NULL, NULL, 'KG1'),
('DR0078', 3, 'Gloria Acheampong Kankam', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Konama', 245468482, 245468482, 'margaretkonama85@gmail.com', NULL, 'KG1'),
('DR0079', 3, 'Daisy EwuraAdwoa Newton', '2020-05-18', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Pearl Rachel L. Newton', 244679386, 243151031, 'prapad1983@gmail.com', NULL, 'KG1'),
('DR0080', 3, 'Adinkrah Noreen Agyei', '2019-07-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Gabriel Adinkra', 557668311, 557668311, 'nkukeziah7@gmail.com', NULL, 'KG1'),
('DR0081', 3, 'Eugene Afriyie Osei', '2020-08-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Osei Antwi Dennis', 556521655, 508449959, 'oseidennis611@gmail.com', NULL, 'KG1'),
('DR0082', 3, 'Apenteng Ohenemaa Yaa Agyemang', '2019-11-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Kwasi Apenteng', 551241353, 207095583, 'hiakwasi@gmail.com', NULL, 'KG1'),
('DR0083', 3, 'Jeremy Kwabena Yeboah', '2019-12-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charlotte Kumi', 248381430, 248381430, 'charlottekumi34@gmail.com', NULL, 'KG1'),
('DR0084', 3, 'Christian Adu-Poku Antwi', '2020-02-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Meshack Akwasi Antwi', 205972854, 243914831, NULL, NULL, 'KG1'),
('DR0085', 3, 'Ankama Tachie Adom', '2020-05-04', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Tachie Yeboah Samuel', 248152771, 248152771, NULL, NULL, 'KG1'),
('DR0086', 3, 'Raphael Adu Sarpong', '2019-08-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Bright Kofi Adu', 245915876, 245915876, 'brightadukofi@gmail.com', NULL, 'KG1'),
('DR0087', 3, 'Jason Ayiyie Damoah Appiah', '2020-01-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Vivian Oforiwaa Damoah', 208385405, 208385405, 'vivianoforiwaa435@gmail.com', NULL, 'KG1'),
('DR0088', 3, 'Emmanuella Elinam Zugah', '2020-05-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Zugah', 243402456, 243402456, 'kwamezugah@gmail.com', NULL, 'KG1'),
('DR0089', 3, 'Daisy Nana-Mansah  Danso', '2019-12-31', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Azure Naomi', 247116644, 247116644, 'abawahnaomi94@gmail.com', NULL, 'KG1'),
('DR0090', 3, 'Asne Osei-Adasa', '2024-11-14', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 245172863, 245172863, 'oseikojo2a@gmail.com', NULL, 'KG1'),
('DR0091', 4, 'Israel Ohene Gyan', '2019-04-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Saah', 541486676, 548054829, NULL, NULL, 'KG2'),
('DR0092', 4, 'Fauqiyat Abu-Sadique', '2018-11-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abu-Sadique Seidu', 245813263, 206355143, 'Sadiqueabu1983@gmail.com', NULL, 'KG2'),
('DR0093', 4, 'Edward Addo Sampaney', '2019-05-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Victoria Appiah', 246410171, 240862805, NULL, NULL, 'KG2'),
('DR0094', 4, 'Joseph Amoo Ankah', '2019-06-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abraham Michael Ankah', 244853175, 244853175, 'supermike2765@gmail.com', NULL, 'KG2'),
('DR0095', 4, 'Derrick Oppong Akantoa', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Nana B. Akantoa', 200181726, 205287957, NULL, NULL, 'KG2'),
('DR0096', 4, 'Jeffery Osei Djan', '2019-05-20', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Djan Emmanuel', 544936689, 247459303, NULL, NULL, 'KG2'),
('DR0097', 4, 'Adjei Aseda Belva', '2018-11-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Eric Adjei', 246893300, 246893300, 'ericuspapaa@gamil.com', NULL, 'KG2'),
('DR0098', 4, 'Irene Tukaata Ninfaazu', '2017-06-28', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samson Kpen-Nyine Ninfaazu', 544400909, 544400909, 'ogedesam@yahoo.com', NULL, 'KG2'),
('DR0099', 4, 'Jefferey Arhin Dekyi', '2018-12-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mark Dekyi', 245322618, 245322618, NULL, NULL, 'KG2'),
('DR0100', 4, 'Wesley Isidore Afriyie Mills', '2018-08-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mercy Mills', 243768462, 243768462, 'mercymills68@gmail.com', NULL, 'KG2'),
('DR0101', 4, 'Rochelle Edith Sien', '2019-03-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Kyere', 244964700, 244964700, 'maviskyere1983@gmail.com', NULL, 'KG2'),
('DR0102', 4, 'Kwaku Oppong Yeboah', '2018-03-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Lydia Kyere', 246071057, 246071057, 'obaakyere@gmail.com', NULL, 'KG2'),
('DR0103', 4, 'Sampson Tettey Kabu', '2019-04-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Linda Adjei', 547706057, 547706057, 'kabusampson@gmail.com', NULL, 'KG2'),
('DR0104', 4, 'Opoku Yeboah Cyril', '2019-12-23', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Opoku Prince Akantoa', 242262275, 242262275, 'alicepimma4@gmail.com', NULL, 'KG2'),
('DR0105', 4, 'Yaa Agyeiwaa Nyarko', '2018-08-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Peter Nyarko', 241906908, 243241023, 'NNANA2G@GMAIL.COM', NULL, 'KG2'),
('DR0106', 4, 'Israel Armah Adjei', '2019-01-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Veronica Kugblenu-Kantoh', 243866873, 243866873, 'obdat86@gmail.com', NULL, 'KG2'),
('DR0107', 4, 'Konadu Joelyn Okyere', '2022-02-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Michael Effah Boateng', 249716384, 249716384, 'Michaeleffahboateng@gmail.com', NULL, 'KG2'),
('DR0108', 4, 'Justice Gyimah Owusu', '2019-03-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mow Salamatu', 245773331, 245773331, 'Mowsalamatu69@gmail.com', NULL, 'KG2'),
('DR0109', 4, 'Derick Akantoa', '2018-07-27', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 503819400, 503819400, 'evelynakantoa@yahoo.com', NULL, 'KG2'),
('DR0110', 4, 'Salifu Aayan', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ramatu Salif', 200036556, 204209872, NULL, NULL, 'KG2'),
('DR0111', 4, 'Andriana Dyice Jefferson-Yeribu', '2018-10-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abigail Anyan', 243382565, 243382565, 'abigailanyan@gmail.com', NULL, 'KG2'),
('DR0112', 4, 'Samarhil Abu Sadique', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Fati Abu Sadique Seid', 206355143, 245813263, 'Sadiqueabu1983@gmail.com', NULL, 'KG2'),
('DR0113', 4, 'Fedora Ama Anumel', '2019-07-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anthony Anumel', 549706486, 201364817, 'anthonyanumel87@gmail.com', NULL, 'KG2'),
('DR0114', 4, 'Lawrencia Nyameye Ahia Quarcoo', '2019-06-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Juanita Ahia Quarcoo', 209162150, 209162150, 'juan83p@yahoo.com', NULL, 'KG2'),
('DR0238', 5, 'Gerald Agyei Yeboah', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Doris Adubea Boakye', 209128555, 209128555, 'DorisAdubea44@gmail.com', NULL, 'CLASS1A'),
('DR0239', 5, 'Jayden Kwabena Yeboah', '2017-11-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charlotte Kumi', 248381430, 248381430, 'charlottekumi34@gmail.com', NULL, 'CLASS1A'),
('DR0240', 5, 'Lucy Akomah Frimpong', '2017-08-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Asenso', 550760444, 550760444, 'mavisasenso@gmail.com', NULL, 'CLASS1A'),
('DR0241', 5, 'Priscilla Nkunim Nti', '2018-10-31', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Edward Nti', 244079391, 244079391, NULL, NULL, 'CLASS1A'),
('DR0242', 5, 'Stamley Nkunim Oppong', '2017-05-20', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Oppong Evans', 247812626, 247812626, NULL, NULL, 'CLASS1A'),
('DR0243', 5, 'Elianna Ajiabadek Akanpani', '2017-09-29', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephanie Akua Ntow', 246379546, 246379546, 'Steph.ntow1986@gmail.com', NULL, 'CLASS1A'),
('DR0244', 5, 'Isreal Fosu Nyamekye', '2018-08-27', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Fosu Rockson', 558060344, 558060344, 'livingrock75@gmail.com', NULL, 'CLASS1A'),
('DR0245', 5, 'Kwasi Kesse Sayan', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Dora Tuah', 541339977, 541339977, NULL, NULL, 'CLASS1A'),
('DR0246', 5, 'Peter Domena Attafuah', '2018-02-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Miriam Otubea Attafuah', 245788214, 245788214, 'miriamotoo7@gmail.com', NULL, 'CLASS1A'),
('DR0247', 5, 'Spio Garbra Georgeth', '2018-09-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Gloria Asuamah', 249513710, 249513710, NULL, NULL, 'CLASS1A'),
('DR0248', 5, 'Chelsea Adwoa Kosowaa Kwarteng', '2018-12-31', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Sarah Amporofi', 546440558, 546440558, 'Sarahamprofi23@gmail.com', NULL, 'CLASS1A'),
('DR0249', 5, 'Korri-Norngne Kyla Yaaku', '2017-09-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Gifty Arthur Yaaka', 244988388, 578665535, 'giftyyarth@gmail.com', NULL, 'CLASS1A'),
('DR0250', 5, 'Edwin Addo Frimpong', '2017-12-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Twenewaa Ernestina', 243772626, 243772626, 'etwenewaa0@gmail.com', NULL, 'CLASS1A'),
('DR0251', 5, 'Bervelyn Aning Anokye', '2018-10-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anokye Kwame Derrick', 249147278, 249147278, 'derrickolator@gmail.com', NULL, 'CLASS1A'),
('DR0252', 5, 'Raphael Adusei', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret konama', 245468482, 245468482, 'obaapapeggie@gmail.com', NULL, 'CLASS1A'),
('DR0253', 5, 'Jamima Adbulai Sidabo', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abdulai Sadia Zubeiru', 242706571, 242706571, 'abzubeiru@gmail.com', NULL, 'CLASS1A'),
('DR0254', 5, 'Kristodea Efua Baawa Mefful', '2018-04-27', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Mefful', 249292007, 249292007, 'francismefful@gmail.com', NULL, 'CLASS1A'),
('DR0255', 5, 'Ewurama Asereba Essel', '2017-11-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Essel', 243948966, 243948966, 'Samuelessel408@gmail.com', NULL, 'CLASS1A'),
('DR0256', 5, 'Gifted Aseda Teye Nanor', '2018-06-30', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephen Y. Nanor', 246355077, 246355077, 'stephananor97@gmail.com', NULL, 'CLASS1A'),
('DR0257', 5, 'Goldie Naana Asantewaa', '2017-11-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Sophia Asantewaa', NULL, 209154665, NULL, NULL, 'CLASS1A'),
('DR0258', 5, 'Victory Afriyie Asomanmg', '2017-10-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Kingsford Asomanmg', 243131906, 243131906, NULL, NULL, 'CLASS1A'),
('DR0258', 6, 'Tachie Yeboah Elton', '2019-10-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Tachie Yeboah Samuel', 248152771, 248152771, NULL, NULL, 'CLASS1B'),
('DR0259', 6, 'Ohene Katakyie Osarfo Nyantakyi', '2018-07-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Nyantakyiwaa Helena', 546999646, 546999646, 'helenqsarfosikapamaame15@gmail.com', NULL, 'CLASS1B'),
('DR0260', 6, 'Akyea Mensah Mcjosh', '2018-04-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adjei-Kwaa Mavis', 241692990, 241692990, NULL, NULL, 'CLASS1B'),
('DR0261', 6, 'Takyi Yaa Nora', '2018-05-03', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 556465771, 556465771, 'padyjulia3@gmail.com', NULL, 'CLASS1B'),
('DR0262', 6, 'Ampensrah Nyarko Evangle', '2017-07-07', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Elizebeth Nkankomago', 208318945, NULL, 'lampensrahemmanuel123@gmail.com', NULL, 'CLASS1B'),
('DR0263', 6, 'Agyei Kofi Seth', '2017-07-07', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abaidoo Elizabeth', 553646650, 553646650, 'abaidooe3H@gmail.com', NULL, 'CLASS1B'),
('DR0264', 6, 'Spendylove A. Yeboah', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Clement Yeboah', 612486626, 34612486606, 'clementyeboah24@gmail.com', NULL, 'CLASS1B'),
('DR0265', 6, 'Othniel Bennet Quaye', '2018-05-31', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Fiahortu Ama Beatrice', 206666870, 548698427, 'fiahortuama@gmail.com', NULL, 'CLASS1B'),
('DR0266', 6, 'Othniel Amissah Danso', '2017-10-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Danso Kingsley', 542737548, 542737548, 'pastordansokingsly@gmail.com', NULL, 'CLASS1B'),
('DR0267', 6, 'Geuel Nhyira Kyeremer Antwi', '2018-01-31', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Victoria Pomaa', 547548655, 547548655, 'victoriapomaa24@gmail.com', NULL, 'CLASS1B'),
('DR0268', 6, 'Salima Awomlie Ayomah', '2019-06-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 542937506, 206626983, 'surayyayaro@gmail.com', NULL, 'CLASS1B'),
('DR0269', 6, 'Alexis-Desmond Manuel Asiedu', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Amarie Adna Awurama', 209228620, 209228620, 'adnaamarie17@gmail.com', NULL, 'CLASS1B'),
('DR0270', 6, 'Duke Kwamena A. Newton', '2018-02-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Pearl Rachel Newton', 243151031, 243151031, NULL, NULL, 'CLASS1B'),
('DR0271', 6, 'Dasnel Osei-Adasa', '2017-04-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 245172863, 245172863, '0seikojo2a@gmail.com', NULL, 'CLASS1B'),
('DR0272', 6, 'Nova Sarpomaa Gyan', '2018-05-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Owusu Sarpomaa Mavis', 509591709, 509591709, 'mavisowusu123@gmail.com', NULL, 'CLASS1B'),
('DR0273', 6, 'Mcdiamond Frimpong-Manso', '2017-07-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Frimpong Yeboah', 244348745, 244348745, 'RFRIMPONG262@GMAIL.COM', NULL, 'CLASS1B'),
('DR0036', 8, 'Desmond Anim Kofi', '2016-02-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Anim Atta Yaw', 248775246, 248775246, 'atta74850@gmail.com', NULL, 'CLASS2B'),
('DR0037', 8, 'Caleb Dannu Jnr', '2017-06-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Daanu Peter Blanskon', 244114971, 205668028, 'pdaanu@yahoo.com', NULL, 'CLASS2B'),
('DR0038', 8, 'Audrey Nhyira Owusu', '2017-01-26', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Cecilia Ntiamoah', 245897910, 245897910, 'ceciliantiamoah2@gmail.com', NULL, 'CLASS2B'),
('DR0039', 8, 'Cherish Adom Kissiwaa Waye', '2017-10-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rev.Waye Agyemang Badu', 249831548, 249831548, 'kumiclara17@gmail.com', NULL, 'CLASS2B'),
('DR0040', 8, 'Imran Abu Sadigue', '2017-11-13', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abu Sadigue', 500639586, 245813263, 'stacyamenor2@gmail.com', NULL, 'CLASS2B'),
('DR0041', 8, 'Jeremiah Okpoti Adjei', '2017-03-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Jonathan Adjei Akpor', 207114772, 207114772, 'jakpor@gmail.com', NULL, 'CLASS2B'),
('DR0042', 8, 'Oppong Kyere Pamela', '2014-08-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Somea Esther', 557591929, 557591929, NULL, NULL, 'CLASS2B'),
('DR0043', 8, 'Tei Ackwerh', '2017-01-28', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Enock Tetteh Ackwerh', 246196881, 246196881, 'celestinakorankye0@gmail.com', NULL, 'CLASS2B'),
('DR0044', 8, 'Nanama Sikafour Carabel Kyeremeh', '2016-09-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ampaabeng Kyeremeh', 206319590, NULL, NULL, NULL, 'CLASS2B'),
('DR0045', 8, 'Samuel Dapaah', '2017-11-24', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Apostle Collins Dapaah', 208190034, 248266764, 'owusushadrach553@gmail.com', NULL, 'CLASS2B'),
('DR0046', 8, 'Afua Kyerewaa Nyarko', '2016-12-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Peter Nyarko', 243241025, 243241025, 'nnana2g@gmail.com', NULL, 'CLASS2B'),
('DR0047', 8, 'Samuel Osborn', '2016-03-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Sunny & Goodness', 247418787, 247418787, 'sunnychigozie77@gmail.com', NULL, 'CLASS2B'),
('DR0048', 8, 'Henry Opoku Boakye', '2017-01-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Bismark Opoku-Boakye', 244242342, 247418787, 'bopokuboakye@gmail.com', NULL, 'CLASS2B'),
('DR0049', 8, 'Danielle Aseda Ankah', '2016-12-11', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Michael Abraham Ankah', 244853175, 244853175, NULL, NULL, 'CLASS2B'),
('DR0050', 8, 'Adjei Nkunim Linette', '2017-01-13', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Eric Adjei', 246893300, 246893300, 'ericuspapaa@gmail.com', NULL, 'CLASS2B'),
('DR0051', 8, 'Takyiwaa Yeboaa Stephanie', '2017-03-27', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephen Kwabena Yeboah', 558061236, 558061236, NULL, NULL, 'CLASS2B'),
('DR0052', 8, 'Kingsford Kwame Kankam', '2016-03-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Knonama', 245468482, 245468482, 'obaapapeggie@gmail.com', NULL, 'CLASS2B'),
('DR0053', 8, 'Heleb Boateng Awuah', '2016-07-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Awuah Baffour Desmond', 242323683, 242323683, 'desbee20@gmail.com', NULL, 'CLASS2B'),
('DR0054', 8, 'Francis Kyere', '2016-09-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Kyere', 244964700, 244964700, 'maviskyere1983@gmail.com', NULL, 'CLASS2B'),
('DR0055', 8, 'Nubia Dedo Tetteh', '2016-06-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Joseph Tetteh', 537263929, 537263929, 'nenekpabitey7@gmail.com', NULL, 'CLASS2B'),
('DR0056', 8, 'Lucky Borngreat Boateng', '2016-01-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 595970993, 595970993, 'Adams.boateng@gmail.com', NULL, 'CLASS2B'),
('DR0011', 9, 'Stephens Abraham Vak Abraham', '2015-06-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Suzzy Owusu', 547972625, 547972625, NULL, NULL, 'CLASS3A'),
('DR0012', 9, 'Elvis Nana Yeboah Bimpong', '2015-06-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Afia Frimpomaa', 241471428, 241471428, NULL, NULL, 'CLASS3A'),
('DR0013', 9, 'Prisca Effah', '2015-04-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Effah', 243878692, 243878692, 'reffah7@gmail.com', NULL, 'CLASS3A'),
('DR0014', 9, 'Nana Aksoua Kusi Adu Asare', '2015-06-28', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Vida Obeng', 547813015, 547813015, 'nyarkodll@gmail.com', NULL, 'CLASS3A'),
('DR0015', 9, 'Diamondtina Yireukyiwaa Aseidu', '2016-06-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ofori Asiedu Francis', 243967877, 243967877, 'francisoforiasiedu@gmail.com', NULL, 'CLASS3A'),
('DR0016', 9, 'Jeffery Kwabena Yeboaah', '2015-07-07', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charlotte Kumi', 248381430, 248381430, 'charlottekumi34@gmail.com', NULL, 'CLASS3A'),
('DR0017', 9, 'Angel Adwoa Asiamah', '2015-11-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abigail A. Sarpong', 242577380, 242577380, 'asarpongbiggles@gmail.com', NULL, 'CLASS3A'),
('DR0018', 9, 'Lilian Serwaa Yeboah', '2015-12-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Martha Asuamah Yeboah', 245098694, 245098694, NULL, NULL, 'CLASS3A'),
('DR0019', 9, 'Melody Brako Gyan', '2016-07-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Saah', 541486676, 541486676, NULL, NULL, 'CLASS3A'),
('DR0020', 9, 'Damoah Miracle Godfred', '2015-10-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Jospeh Kwasi Ampem', 243451669, 243451669, 'jakpee2006@yahoo.com', NULL, 'CLASS3A'),
('DR0021', 9, 'Edwin Addo Asamoah', '2014-12-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Prince Asamoah', 244082901, 244082901, 'prinmoah@gmail.com', NULL, 'CLASS3A'),
('DR0022', 9, 'Imam Biesoh-Adjoa Sayibu Kankah', '2015-10-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rafatu Sayibu', 557291712, 244082901, 'issifusayibu@yahoo.com', NULL, 'CLASS3A'),
('DR0023', 9, 'Ohemaa Audrey Asare', '2015-03-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephen Asare', 246275797, 246275797, 'asderrick46@gmail.com', NULL, 'CLASS3A'),
('DR0024', 9, 'Aseda Dankwah Boateng', '2015-09-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Gershon Gyamfi Boateng', 24682107, 246275797, 'gershon.gyamfi@gmai.com', NULL, 'CLASS3A'),
('DR0025', 9, 'Richmond Ofosu Manu', '2015-09-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Seth Manu', 205169494, 205169494, NULL, NULL, 'CLASS3A'),
('DR0026', 9, 'Lilian Arthur Mintah', '2015-03-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Lydia Okyere', 241506737, 207453125, 'lydiaokyere74@gmail.com', NULL, 'CLASS3A'),
('DR0027', 9, 'Quaye Klenam Petra', '2015-07-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Fiahortu Ama', 206666870, 206666870, 'fiahortuama@gmail.com', NULL, 'CLASS3A'),
('DR0028', 9, 'Fiona Owusu Ampofo', '2014-10-11', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bona Elizabeth', 546311848, 546311848, 'bonae760@gmail.com', NULL, 'CLASS3A'),
('DR0029', 9, 'Owusuaa Boakye Elikharis', '2016-03-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Asamoah Bemma Rachael', 247162260, 504595700, 'rachealbemma@gmail.com', NULL, 'CLASS3A'),
('DR0030', 9, 'Emmanuella Afriyie Kyere', '2015-05-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Aseiduwaa Rosemary', 558650022, 558650022, NULL, NULL, 'CLASS3A'),
('DR0031', 9, 'Duchess Kukua Nyarba Newton', '2015-12-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Pearl R.L. Newton', 244679386, 243151031, 'praspad1983@gmail.com', NULL, 'CLASS3A'),
('DR0032', 9, 'Jesse Opoku Gyan', '2015-09-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Alice Pimma', 242262275, 242262275, 'alicepimma4@gmail.com', NULL, 'CLASS3A'),
('DR0033', 9, 'Edwin Addo Asamaoh', '2014-04-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Prince Asamoah', 244082901, 244082901, 'prinmoah@gmail.com', NULL, 'CLASS3A'),
('DR0034', 9, 'Authur Kwadow Nimson', '2015-09-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 540832713, 540832713, 'oduroblessing88@gmail.com', NULL, 'CLASS3A'),
('DR0035', 9, 'Eliezer Agyie Darkowaa', '2016-03-11', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Afia Owusuwaa', 206810692, 206810692, NULL, NULL, 'CLASS3A'),
('DR0057', 10, 'Akyere Appiah-Kusi', '2016-03-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Elvis Brenya Appiah-Kusi', 208433595, 208433595, 'appikusi@yahoo.co.uk', NULL, 'CLASS3B'),
('DR0058', 10, 'Vida Elikm Sogbey', '2016-03-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Noble Sogbey', 554370224, 208433595, 'sogbeynoble1@gmail.com', NULL, 'CLASS3B'),
('DR0059', 10, 'Alvin Addai Frimpong', '2015-11-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Twenewaa Ernestina', 243772626, 243772626, 'etwenewaa@gmail.com', NULL, 'CLASS3B'),
('DR0060', 10, 'Chrispin Virsob Bangkewa Kuunifaa', '2015-03-17', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Lana Lydia Bewaale', 242714153, 242714153, 'leelan8444@gmail.com', NULL, 'CLASS3B'),
('DR0061', 10, 'Evodia Benewaa Acheaw', '2016-04-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ivy Sarbi-Ababio', 245947095, 245947095, NULL, NULL, 'CLASS3B'),
('DR0062', 10, 'Ohemaa Kuowa Osarfo Nyantakyi', '2016-02-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Osarfo Nyantakyi Emmanuel', 245145156, 245145156, NULL, NULL, 'CLASS3B'),
('DR0063', 10, 'Aaron Korkpoe', '2015-01-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adombor Prsicilla', 594711505, 594711505, 'adomborpriscilla@yahoo.com', NULL, 'CLASS3B'),
('DR0064', 10, 'Abena Boaduwaa Amponsah', '2015-03-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ing. Emmanuel Osafo', 503601335, 503601335, NULL, NULL, 'CLASS3B'),
('DR0065', 10, 'Paa Kwesi Nhyiraba Mbir Mefful', '2015-05-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Mefful', 249292007, 249292007, 'francismefful@gmail.com', NULL, 'CLASS3B'),
('DR0066', 10, 'Yeboah Garand Adjei', '2015-04-07', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Evans A. yeboah', 208779050, 243465398, 'yevans628@gmail.com', NULL, 'CLASS3B'),
('DR0067', 10, 'Joycelin Pokuaa Amponsah', '2015-07-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Amoako Fordjour', 208935417, 26494413, 'jenkofy@gmail.com', NULL, 'CLASS3B'),
('DR0068', 10, 'Margaret Semefa Dzameshie', '2015-02-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Dzameshie', 547947194, 547947194, 'vivianboateng348@gmail.com', NULL, 'CLASS3B'),
('DR0069', 10, 'Sallah Hawayn Mashat', '2014-04-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 537957288, 537957288, NULL, NULL, 'CLASS3B'),
('DR0070', 10, 'Nathan Serwah sikapa Essel', '2015-12-17', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Essel', 243948966, 243948966, 'samuelessel408@gmail.com', NULL, 'CLASS3B'),
('DR0071', 10, 'Diana Amponsah', '2014-03-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 542540266, NULL, NULL, NULL, 'CLASS3B'),
('DR0072', 10, 'Nathaniel Obeng Kwasi', '2016-01-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Obeng Owura Kwadwo', 208361408, NULL, NULL, NULL, 'CLASS3B'),
('DR0073', 10, 'Aaliyah Nana Abena Adams', '2015-10-13', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Andriana Aning', 244214344, 244214344, 'andriana1231988@gmail.com', NULL, 'CLASS3B'),
('DR0074', 10, 'Phineaas Fofie', '2015-06-23', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Fofie Christian', 208826160, 208826160, 'fofiechristian041@gmail.com', NULL, 'CLASS3B'),
('DR0075', 10, 'Dishnell Pomaa Amponsah', '2015-10-22', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anastasia Opoku Yeboah', 265043914, 265043914, 'anastasiabanson507@gmail.com', NULL, 'CLASS3B'),
('DR0076', 10, 'Michelle Nana Yaa Ntim', '2012-09-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rebecca Mensah', 547271337, 547271337, 'mensbeccs34@gmail.com', NULL, 'CLASS3B'),
('DR0200', 11, 'Jessica Pokuaa Boakye', '2014-03-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bismark Opoku-Boakye', 244242342, 244242342, 'bopokuboakye@gmail.com', NULL, 'CLASS4A'),
('DR0201', 11, 'Majorie Gyemea Mensah', '2015-02-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Evelyn Asamoah Mensah', 2091732744, 244242342, 'evelynasamoah16@gmail.com', NULL, 'CLASS4A'),
('DR0202', 11, 'Reginald Nana Asomaning', '2014-10-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kingsford Aomaning', 243131906, 243131906, 'kingsfordasomanin@gmail.com', NULL, 'CLASS4A'),
('DR0203', 11, 'Adjei-Nkansah Nyamekye Vanessa', '2014-10-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Eric Adjei', 246893300, 246893300, 'ericuspapaa@gmail.com', NULL, 'CLASS4A'),
('DR0204', 11, 'Lauretta Achiaa Obiri', '2014-11-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Douglas Addo', 24862805, 24862805, 'douglasaddo12@gmail.com', NULL, 'CLASS4A'),
('DR0205', 11, 'Osarfo Sikapa Kwartemaa Osarfo Nyantakyi', '2014-09-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Osarfo Nyantakyi Emmanuel', 245145156, 245145156, NULL, NULL, 'CLASS4A'),
('DR0206', 11, 'Persis Arkoh Adu', '2013-10-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bright Kofi Adu', 245915876, 245145156, 'brightadukofi@gmail.com', NULL, 'CLASS4A'),
('DR0207', 11, 'Vicentia Oforiwaa Asiedu', '2015-03-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ofori Asiedu Francis', 243967877, 245145156, 'francisoforiasiedu@gmail.com', NULL, 'CLASS4A'),
('DR0208', 11, 'Hrriet Nyarko Manu', '2011-03-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Seth Manu', 243844433, 205169494, NULL, NULL, 'CLASS4A'),
('DR0209', 11, 'Macbill Habel Clinton', '2012-05-20', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'I-raw Baman Lucky Clinton', 244444849, 245145156, 'info.mapping.gh@gmail.com', NULL, 'CLASS4A'),
('DR0210', 11, 'Ekow Dede Painstill', '2012-03-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Josephine Ehuren', 244788898, 244788898, 'jehuren38@gmail.com', NULL, 'CLASS4A'),
('DR0211', 11, 'Kofi Owusu Ameyaw', '2014-02-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ameyaw Gyan', 243413933, 243413933, NULL, NULL, 'CLASS4A'),
('DR0212', 11, 'Perez Amoako Danso', '2014-10-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Danso Kingsley', 542737548, 243413933, 'pastordansokingsley@gmail.com', NULL, 'CLASS4A'),
('DR0213', 11, 'Keziah Adinkrah Yeboah', '2014-11-30', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Agyeiwaa Augustina', 557668311, 243413933, 'nkukeziah7@gmail.com', NULL, 'CLASS4A'),
('DR0214', 11, 'Richlove Nketiah Kyere', '2013-07-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Aseiduwaa Rosemary', 558650022, 558650022, NULL, NULL, 'CLASS4A'),
('DR0215', 11, 'Pascaline Fredua-Agyeman', '2015-04-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Yvonne Fiamor', 248978994, 248978994, 'amayvonne23@gmail.com', NULL, 'CLASS4A'),
('DR0216', 11, 'Belvia Ocran', '2014-10-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Leticia Sam-Ocran', 242761555, 248978994, 'leticiasam17@gmail.com', NULL, 'CLASS4A'),
('DR0217', 11, 'Daniel Adjei Manu', '2013-11-16', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Cecilia Biney', 246465968, 248978994, 'cecil.maab@gmail.com', NULL, 'CLASS4A'),
('DR0218', 11, 'Gyamfi Prisca', '2014-06-07', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Foriwaa Georgina', 507575033, 552541498, NULL, NULL, 'CLASS4A'),
('DR0219', 11, 'Caleb Kwaku Nina', '2014-04-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Patience Bajike', 244754354, 248978994, 'patba54@gmail.com', NULL, 'CLASS4A'),
('DR0220', 11, 'Ransford Owusu Bumangama', '2014-12-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Winifred Baah', 241173318, 241173318, NULL, NULL, 'CLASS4A'),
('DR0221', 11, 'Eric Kwame Danso Jnr', '2013-06-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Agyeiwaa', 243223539, 243223539, 'margaretagyeiwaa400@gmail.com', NULL, 'CLASS4A'),
('DR0222', 11, 'Owusu Fosuaah Franklina', '2014-12-28', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Frank Owusu', 244135757, 244135757, 'frankowusu129@yahoo.com', NULL, 'CLASS4A'),
('DR0223', 11, 'Evangeline Aseda Ahia Quarcoo', '2015-02-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Juanita Ahia Quarcoo', 209162150, 209162150, 'juan83p@yahoo.com', NULL, 'CLASS4A'),
('DR0181', 12, 'Edrick Quaicoe Okyere', '2013-09-25', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charles Okyere', 243841518, 243841518, NULL, NULL, 'CLASS4B'),
('DR0182', 12, 'Oswald Takyi Adofo', '2014-10-23', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Gyiraa Vida', 557282805, 557282805, NULL, NULL, 'CLASS4B'),
('DR0183', 12, 'Shaun Raphael Sieh', '2014-05-05', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Kyere', 244964700, 244964700, 'maviskyere1983@gmail.com', NULL, 'CLASS4B'),
('DR0184', 12, 'Meldrick Kwakye Ampaw', '2014-07-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Sarah Ayiwa Aning', 202365092, 243955930, 'sarahyiwaaning@gmail.com', NULL, 'CLASS4B'),
('DR0185', 12, 'Kingsley Ackah Kwaw', '2014-09-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kingsford Ackah Kwaw', 207387141, 207387141, 'kingsfordackah01@gmail.com', NULL, 'CLASS4B'),
('DR0186', 12, 'Ofori Kusi Cyril', '2014-12-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kusi Francise-Alice Nyarko', 506105015, 208073033, NULL, NULL, 'CLASS4B'),
('DR0187', 12, 'David Kingsley Modey', '2014-04-17', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ameyaw Gyan', 243413933, 447909238783, 'nanayaw86@gmail.com', NULL, 'CLASS4B'),
('DR0188', 12, 'Eric Kwame Danso Snr.', '2013-06-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Agyeiwaa', 243223539, 243223539, 'margaretagyeiwaa400@gmail.com', NULL, 'CLASS4B'),
('DR0189', 12, 'Alexandra Boatemaa Oduro', '2014-12-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Helena Agyeiwaaa', 502548650, 502548650, 'helenaagyeiwaa76@gmail.com', NULL, 'CLASS4B'),
('DR0190', 12, 'Bryce Annor Walfred', '2014-05-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kyeraa Felicia', 549187744, 502548650, 'anor.emma@gmail.com', NULL, 'CLASS4B'),
('DR0191', 12, 'Twumasi Vanessah', '2014-09-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Twumasi Kwaku Emmanuel', 547639020, 502548650, 'etwumasikwaku@gmail.com', NULL, 'CLASS4B'),
('DR0192', 12, 'Beverly Nana Kumi Acheaw', '2014-12-29', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Quansah Sam Bernice', 540183992, 540183992, 'bernicequansah28@gmail.com', NULL, 'CLASS4B'),
('DR0193', 12, 'Ernest Agyemang Badu Kyeremeh', '2014-01-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ampaabeng Kyeremeh', 206319590, 206319590, NULL, NULL, 'CLASS4B'),
('DR0194', 12, 'Nhyira Ayisi Boateng', '2013-09-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Gershon Gyamfi Boateng', 246825107, 246825107, 'gershon.gyamfi@gmail.com', NULL, 'CLASS4B'),
('DR0195', 12, 'Vince Dankwah', '2014-06-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ruth Serwaa', 544642864, 544642864, 'joseph.dankwah@icloud.com', NULL, 'CLASS4B'),
('DR0196', 12, 'Enoch Korkpoe', '2013-11-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adombor Priscilla', 594711505, 594711505, 'adomborpriscilla@yahoo.com', NULL, 'CLASS4B'),
('DR0197', 12, 'Shamima Halkida Abdulai', '2015-01-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abdulai Sadia Zubeiru', 554120451, 554120451, 'abdulaisadiazubeiru', NULL, 'CLASS4B'),
('DR0198', 12, 'Edrick Okyere Quaicoe', '2013-09-25', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Okyere Charles', 243841518, 243841518, NULL, NULL, 'CLASS4B'),
('DR0199', 12, 'Herbert Oppong Badu', '2014-10-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Badu Johnson', 547691448, 547691448, 'jbadu268@gmail.com', NULL, 'CLASS4B'),
('DR0115', 13, 'Brenya Appiah-Kusi', '2013-10-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Diana Nketiah', 205264063, 244964700, 'nketiahdiana@yahoo.com', NULL, 'CLASS5A'),
('DR0116', 13, 'Mabel Agyeiwaa Ohemaa', '2013-02-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Emelia Saakuu', 554379651, NULL, NULL, NULL, 'CLASS5A'),
('DR0117', 13, 'Jeffery Obiri Yeboah', '2010-08-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abrefa', 242864336, 242864336, 'charleskumahabrefa@gmail.com', NULL, 'CLASS5A'),
('DR0118', 13, 'Malvin Nsiah Korsash', '2013-04-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Aboagye Korsah', 249631910, 249631910, 'kwasikorsah80@gmail.com', NULL, 'CLASS5A'),
('DR0119', 13, 'Michelle Chinoso John', '2015-08-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Blessed Joy Chinoso', 257645998, 257645998, NULL, NULL, 'CLASS5A'),
('DR0120', 13, 'Kwabena Amankona Sakyi', '2013-10-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Sakyi', 508803427, 508803427, 'richardsakyi95@yahoo.com', NULL, 'CLASS5A'),
('DR0121', 13, 'Ataa Yaa Bernice', '2012-11-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Manu', 24078459, 24078459, NULL, NULL, 'CLASS5A'),
('DR0122', 13, 'Michelle Amosiwaa Asumadu', '2013-09-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Frimpong Salomey', 244180889, 244180889, 'ilady65921@gmail.com', NULL, 'CLASS5A'),
('DR0123', 13, 'Ivan Osei Asiamah', '2014-01-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abigail A. Sarpong', 242577380, 242577380, 'asarpongbiggles@gmail.com', NULL, 'CLASS5A'),
('DR0124', 13, 'Daniel Akantoa', '2013-03-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Nana Bennett Akantoa', 261587629, 205287957, NULL, NULL, 'CLASS5A'),
('DR0125', 13, 'Christel Naa-mwin Barika', '2013-09-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Lydia Bewak Lana', 242714153, NULL, 'leelan84ww@yahoo.com', NULL, 'CLASS5A'),
('DR0126', 13, 'Richmond Okyere Ampoe Martinson', '2013-06-25', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Victoria Ofori Odette', 540539484, 540539484, 'odetteofori589@gmail.com', NULL, 'CLASS5A'),
('DR0127', 13, 'Gerald Kwabena Nina', '2011-12-27', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Emmanuel Bawa', 208402309, 208402309, 'patba54@gmail.com', NULL, 'CLASS5A'),
('DR0128', 13, 'Kelvin Owusu Donkor', '2012-04-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Juliet Owusus Donkor', 540769799, 540769799, NULL, NULL, 'CLASS5A'),
('DR0129', 13, 'Bridget Afriyie Kwarteng', '2013-04-17', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Vera Adoma Boakye', 246221722, 246221722, NULL, NULL, 'CLASS5A'),
('DR0130', 13, 'Prince Yeboah Yaang', '2013-08-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Stella/Richmond Yeboah', 247048542, 247048542, NULL, NULL, 'CLASS5A'),
('DR0131', 13, 'Devlyn Nhyira Obour', '2013-09-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Linda Twumasi', 247633708, 202333904, 'lintwumasi17@gmail.com', NULL, 'CLASS5A'),
('DR0132', 13, 'Nana Fosu Oteng-Ampofo', '2013-12-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Belinda D. Oteng-Ampofo', 243267585, 243267585, 'lynoteng1@outlook.com', NULL, 'CLASS5A'),
('DR0133', 13, 'Joseph Nathan Naounou', '2013-11-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Rose Naounou', 598446229, 598446229, 'rosnaounou7777@gmail.com', NULL, 'CLASS5A'),
('DR0134', 13, 'Gyasi Afia Agyemang', '2013-12-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Kwasi Apenteng', 551241353, 207095583, 'hiakwasi@gmail.com', NULL, 'CLASS5A'),
('DR0135', 13, 'Caleb Akyea Mensah', '2013-12-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adjei-Kwaa Mavis', 241692990, 241692990, NULL, NULL, 'CLASS5A'),
('DR0224', 13, 'Kwabena Pako Adu', '2013-06-11', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adu Emmauel', 242759406, 242759406, 'papasource@gmail.com', NULL, 'CLASS5B'),
('DR0225', 13, 'Falconer Kojo Prah', '2013-06-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kojo Kum Prah', 244781908, 244781908, 'prahkojo77@gmail.com', NULL, 'CLASS5B'),
('DR0226', 13, 'Cedella Mills', '2013-09-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Mercy Mills', 243768462, NULL, 'mercymills68@gmail.com', NULL, 'CLASS5B'),
('DR0227', 13, 'Mercedes Agyeiwaa Anokye', '2013-11-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anokye Kwame Derrick', 249147278, 249147278, 'derrickolator@gmail.com', NULL, 'CLASS5B'),
('DR0228', 13, 'Naawemuo Junior', '2013-11-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Roger Wemuo', 555721930, 202332005, 'rogerwemuo@gmail.com', NULL, 'CLASS5B'),
('DR0229', 13, 'Thelma Appiah', '2013-03-03', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Meri Abubakari / Samuel Appiah', 550326606, 550326606, 'meriabubakari@gmail.com', NULL, 'CLASS5B'),
('DR0230', 13, 'Lewis Anyietewin Akanpami', '2013-12-11', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephanie Akua Ntow', 246379546, 246379546, 'steph.ntow1986@gmail.com', NULL, 'CLASS5B'),
('DR0231', 13, 'Tetteh Wayoe Ackwerh', '2013-03-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Celestina Korankye & Enoch', 246196881, 246196881, 'celestinakorankye0@gmail.com', NULL, 'CLASS5B'),
('DR0232', 13, 'Clinton Amen Brainy', '2010-10-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'I-Raw Baman Lucky Clinton', 244444849, 244444849, 'info.mapping.gh@gmail.com', NULL, 'CLASS5B'),
('DR0233', 13, 'Samuella Nana Yaa Abban', '2014-06-04', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'David Abban', 245831138, 245831138, 'abbans34.ad@gmail.com', NULL, 'CLASS5B'),
('DR0234', 13, 'Ataa Yaa Benedicta', '2012-11-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Manu', 2407801159, 245831138, NULL, NULL, 'CLASS5B'),
('DR0235', 13, 'Aseidu Agyemang Kelvin', '2012-03-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Rosemond Aseidu Acheampong', 544828628, 205893463, 'nkofi8930@gmail.com', NULL, 'CLASS5B'),
('DR0236', 13, 'Christopher Annobil Fiifi Mefful', '2013-04-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Mefful', 249292007, 249292007, 'francismefful@gmail.com', NULL, 'CLASS5B'),
('DR0237', 13, 'Eric Opoku Kusi', '2013-10-30', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rita Oti Manu', 206796763, 206796763, 'ritaotimanu@gmail.com', NULL, 'CLASS5B'),
('DR0136', 6, 'Samuel Godwin', '2011-01-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Sunny & Goodness', 247418787, 247418787, 'sannychigozie770@gmail.com', NULL, 'CLASS6'),
('DR0137', 6, 'Michael Abban Nuku', '2012-06-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'David Abban', 245831138, 245831138, 'abbans34.ad@gmail.com', NULL, 'CLASS6'),
('DR0138', 6, 'Hanzzy Nana Aba Darllington', '2012-12-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ampofo Stella Ofori', 541140449, 541140449, NULL, NULL, 'CLASS6'),
('DR0139', 6, 'Treymaine Carter Apraku', '2013-01-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Emma Ohenewaa', 542677660, 542677660, 'eohenewaa2102@gmail.com', NULL, 'CLASS6'),
('DR0140', 6, 'Lordina Opoku Afrifa', '2012-09-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Naomi Amakwaa yeboah', 244823663, 244823663, 'naomiyeboahamankwaa22@gmail.com', NULL, 'CLASS6'),
('DR0141', 6, 'Keizia Tiwaah Amponsah', '2012-07-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Amoako Fordjour', 208935417, 246494413, 'jenkofy@gmail.com', NULL, 'CLASS6'),
('DR0142', 6, 'Nhyira Ama Adomako', '2013-09-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Adomako Johnson', 248096810, 208391963, NULL, NULL, 'CLASS6'),
('DR0143', 6, 'Michelle Emmanuella Sieh', '2012-08-26', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'mavis Kyere', 249664700, 244823663, 'maviskyere1983@gmail.com', NULL, 'CLASS6'),
('DR0144', 6, 'Vera Serwaa Kwakye', '2011-04-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Evelyn Asamoah Mensah', 209173274, 209173274, 'evelynasamoah26@gmail.com', NULL, 'CLASS6'),
('DR0145', 6, 'Yeboah Badu Joycelyn', '2011-10-07', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Badu Johnson', 201364119, 547691448, 'jbadu268@gmail.com', NULL, 'CLASS6'),
('DR0146', 6, 'Emile Owusu Ampofo', '2012-02-29', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bona Elizabeth', 546311848, 546311848, 'bonae760@gmail.com', NULL, 'CLASS6'),
('DR0147', 6, 'Lordfred Yeboah', '2012-01-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Philomina Nketia', 245077710, 245077710, 'philomenayeboah82@gmail.com', NULL, 'CLASS6'),
('DR0148', 6, 'Raihan Tipaya Shahadu', '2012-03-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mohammed Shani Shahadu', 243880696, 243880696, 'smshahdu@gmail.com', NULL, 'CLASS6'),
('DR0149', 6, 'Nina Anim Boateng', '2012-10-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Anim Atta Yaw', 248775246, 248775246, 'atta74850@gmail.com', NULL, 'CLASS6'),
('DR0150', 6, 'Princewell Kwadwo Asamoah', '2011-12-05', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Emelia Dadzie/ Prince Asamoah', 244082901, 244082901, 'prinmoah@gmail.ccom', NULL, 'CLASS6'),
('DR0151', 6, 'Agyei Lilian', '2011-12-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Faustina Owusuaa', 240627059, NULL, NULL, NULL, 'CLASS6'),
('DR0152', 6, 'Prosper Ekow Abaidoo', '2010-10-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abaidoo Elizabeth', 553646650, 553646650, 'abaidooe3744@gmail.com', NULL, 'CLASS6'),
('DR0153', 6, 'Asante Fonic', '2010-07-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 246868012, 246868012, NULL, NULL, 'CLASS6'),
('DR0154', 6, 'Adwoa Tumwaa Sakyi', '2012-10-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Sakyi', 508803427, 508803427, 'richardsakyi95@yahoo.com', NULL, 'CLASS6'),
('DR0155', 6, 'Richmond Acheampong Christian', '2012-09-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Acheampng', 243906745, 243906745, 'richhandofgod45@gmail.com', NULL, 'CLASS6'),
('DR0156', 6, 'Frimpong Isaace Kwame', '2011-09-17', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Isaac Frimpong Kofi', 505903790, 248866869, NULL, NULL, 'CLASS6'),
('DR0157', 6, 'Agyemang Kingsforda', '2013-03-17', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Doris Ferka Oduro', 557343019, 554204014, NULL, NULL, 'CLASS6'),
('DR0158', 6, 'Ayele Serwaa Elsie', '2012-11-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Asamoah Constance', 552531981, 201122678, NULL, NULL, 'CLASS6'),
('DR0159', 6, 'Emmanuella Efua Egyir', '2013-05-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Patience Kyeraa', 550720005, 550720005, 'patiencekyeraa055@gmail.com', NULL, 'CLASS6'),
('DR0160', 6, 'Mariam Lumenga Abdulai', '2012-09-18', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abdulai Sadia Zuberiru', 554120451, 554120451, 'abdulaisadiazubeiru@gmail.com', NULL, 'CLASS6'),
('DR0161', 6, 'Gillian Duncan Kwarteng', '2012-11-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Joshua Amo Frimpong', 555887873, 555887873, 'mary.yzma@gmail.com', NULL, 'CLASS6'),
('DR0162', 6, 'Boateng Nhyira Owusuaa', '2011-10-27', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Munufie Oforiwaa Adwoa', 209639818, 554323970, 'oforiwaamunufie@gamil.vom', NULL, 'CLASS6'),
('DR0163', 6, 'Opoku Duah Michael', '2012-12-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Prince Opoku Akantoa', 242262275, 242262275, 'alicepimma4@gmail.com', NULL, 'CLASS6'),
('DR0164', 6, 'Fidaus Pomaa Ibrahim', '2012-03-22', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bertha Temea', 244047300, 244047300, 'berthatemea@gmail.com', NULL, 'CLASS6'),
('DR0077', 3, 'Brett Perry Mensah', '2019-04-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 550191244, 550191244, NULL, NULL, 'KG1'),
('DR0078', 3, 'Gloria Acheampong Kankam', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Konama', 245468482, 245468482, 'margaretkonama85@gmail.com', NULL, 'KG1'),
('DR0079', 3, 'Daisy EwuraAdwoa Newton', '2020-05-18', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Pearl Rachel L. Newton', 244679386, 243151031, 'prapad1983@gmail.com', NULL, 'KG1'),
('DR0080', 3, 'Adinkrah Noreen Agyei', '2019-07-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Gabriel Adinkra', 557668311, 557668311, 'nkukeziah7@gmail.com', NULL, 'KG1'),
('DR0081', 3, 'Eugene Afriyie Osei', '2020-08-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Osei Antwi Dennis', 556521655, 508449959, 'oseidennis611@gmail.com', NULL, 'KG1'),
('DR0082', 3, 'Apenteng Ohenemaa Yaa Agyemang', '2019-11-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Kwasi Apenteng', 551241353, 207095583, 'hiakwasi@gmail.com', NULL, 'KG1'),
('DR0083', 3, 'Jeremy Kwabena Yeboah', '2019-12-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charlotte Kumi', 248381430, 248381430, 'charlottekumi34@gmail.com', NULL, 'KG1'),
('DR0084', 3, 'Christian Adu-Poku Antwi', '2020-02-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Meshack Akwasi Antwi', 205972854, 243914831, NULL, NULL, 'KG1'),
('DR0085', 3, 'Ankama Tachie Adom', '2020-05-04', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Tachie Yeboah Samuel', 248152771, 248152771, NULL, NULL, 'KG1'),
('DR0086', 3, 'Raphael Adu Sarpong', '2019-08-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Bright Kofi Adu', 245915876, 245915876, 'brightadukofi@gmail.com', NULL, 'KG1'),
('DR0087', 3, 'Jason Ayiyie Damoah Appiah', '2020-01-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Vivian Oforiwaa Damoah', 208385405, 208385405, 'vivianoforiwaa435@gmail.com', NULL, 'KG1'),
('DR0088', 3, 'Emmanuella Elinam Zugah', '2020-05-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Zugah', 243402456, 243402456, 'kwamezugah@gmail.com', NULL, 'KG1'),
('DR0089', 3, 'Daisy Nana-Mansah  Danso', '2019-12-31', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Azure Naomi', 247116644, 247116644, 'abawahnaomi94@gmail.com', NULL, 'KG1'),
('DR0090', 3, 'Asne Osei-Adasa', '2024-11-14', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 245172863, 245172863, 'oseikojo2a@gmail.com', NULL, 'KG1'),
('DR0091', 4, 'Israel Ohene Gyan', '2019-04-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Saah', 541486676, 548054829, NULL, NULL, 'KG2'),
('DR0092', 4, 'Fauqiyat Abu-Sadique', '2018-11-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abu-Sadique Seidu', 245813263, 206355143, 'Sadiqueabu1983@gmail.com', NULL, 'KG2'),
('DR0093', 4, 'Edward Addo Sampaney', '2019-05-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Victoria Appiah', 246410171, 240862805, NULL, NULL, 'KG2'),
('DR0094', 4, 'Joseph Amoo Ankah', '2019-06-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abraham Michael Ankah', 244853175, 244853175, 'supermike2765@gmail.com', NULL, 'KG2'),
('DR0095', 4, 'Derrick Oppong Akantoa', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Nana B. Akantoa', 200181726, 205287957, NULL, NULL, 'KG2'),
('DR0096', 4, 'Jeffery Osei Djan', '2019-05-20', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Djan Emmanuel', 544936689, 247459303, NULL, NULL, 'KG2'),
('DR0097', 4, 'Adjei Aseda Belva', '2018-11-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Eric Adjei', 246893300, 246893300, 'ericuspapaa@gamil.com', NULL, 'KG2'),
('DR0098', 4, 'Irene Tukaata Ninfaazu', '2017-06-28', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samson Kpen-Nyine Ninfaazu', 544400909, 544400909, 'ogedesam@yahoo.com', NULL, 'KG2'),
('DR0099', 4, 'Jefferey Arhin Dekyi', '2018-12-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mark Dekyi', 245322618, 245322618, NULL, NULL, 'KG2'),
('DR0100', 4, 'Wesley Isidore Afriyie Mills', '2018-08-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mercy Mills', 243768462, 243768462, 'mercymills68@gmail.com', NULL, 'KG2'),
('DR0101', 4, 'Rochelle Edith Sien', '2019-03-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Kyere', 244964700, 244964700, 'maviskyere1983@gmail.com', NULL, 'KG2'),
('DR0102', 4, 'Kwaku Oppong Yeboah', '2018-03-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Lydia Kyere', 246071057, 246071057, 'obaakyere@gmail.com', NULL, 'KG2'),
('DR0103', 4, 'Sampson Tettey Kabu', '2019-04-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Linda Adjei', 547706057, 547706057, 'kabusampson@gmail.com', NULL, 'KG2'),
('DR0104', 4, 'Opoku Yeboah Cyril', '2019-12-23', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Opoku Prince Akantoa', 242262275, 242262275, 'alicepimma4@gmail.com', NULL, 'KG2'),
('DR0105', 4, 'Yaa Agyeiwaa Nyarko', '2018-08-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Peter Nyarko', 241906908, 243241023, 'NNANA2G@GMAIL.COM', NULL, 'KG2'),
('DR0106', 4, 'Israel Armah Adjei', '2019-01-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Veronica Kugblenu-Kantoh', 243866873, 243866873, 'obdat86@gmail.com', NULL, 'KG2'),
('DR0107', 4, 'Konadu Joelyn Okyere', '2022-02-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Michael Effah Boateng', 249716384, 249716384, 'Michaeleffahboateng@gmail.com', NULL, 'KG2'),
('DR0108', 4, 'Justice Gyimah Owusu', '2019-03-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mow Salamatu', 245773331, 245773331, 'Mowsalamatu69@gmail.com', NULL, 'KG2'),
('DR0109', 4, 'Derick Akantoa', '2018-07-27', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 503819400, 503819400, 'evelynakantoa@yahoo.com', NULL, 'KG2'),
('DR0110', 4, 'Salifu Aayan', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ramatu Salif', 200036556, 204209872, NULL, NULL, 'KG2'),
('DR0111', 4, 'Andriana Dyice Jefferson-Yeribu', '2018-10-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abigail Anyan', 243382565, 243382565, 'abigailanyan@gmail.com', NULL, 'KG2'),
('DR0112', 4, 'Samarhil Abu Sadique', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Fati Abu Sadique Seid', 206355143, 245813263, 'Sadiqueabu1983@gmail.com', NULL, 'KG2');
INSERT INTO `your_table_name` (`student_id`, `class_id`, `name`, `dob`, `gender`, `hand`, `foot`, `eye_sight`, `medical_condition`, `height`, `weight`, `parent_name`, `parent_phone`, `parent_whatsapp`, `parent_email`, `passport_picture`, `source_sheet`) VALUES
('DR0113', 4, 'Fedora Ama Anumel', '2019-07-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anthony Anumel', 549706486, 201364817, 'anthonyanumel87@gmail.com', NULL, 'KG2'),
('DR0114', 4, 'Lawrencia Nyameye Ahia Quarcoo', '2019-06-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Juanita Ahia Quarcoo', 209162150, 209162150, 'juan83p@yahoo.com', NULL, 'KG2'),
('DR0238', 5, 'Gerald Agyei Yeboah', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Doris Adubea Boakye', 209128555, 209128555, 'DorisAdubea44@gmail.com', NULL, 'CLASS1A'),
('DR0239', 5, 'Jayden Kwabena Yeboah', '2017-11-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charlotte Kumi', 248381430, 248381430, 'charlottekumi34@gmail.com', NULL, 'CLASS1A'),
('DR0240', 5, 'Lucy Akomah Frimpong', '2017-08-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Asenso', 550760444, 550760444, 'mavisasenso@gmail.com', NULL, 'CLASS1A'),
('DR0241', 5, 'Priscilla Nkunim Nti', '2018-10-31', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Edward Nti', 244079391, 244079391, NULL, NULL, 'CLASS1A'),
('DR0242', 5, 'Stamley Nkunim Oppong', '2017-05-20', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Oppong Evans', 247812626, 247812626, NULL, NULL, 'CLASS1A'),
('DR0243', 5, 'Elianna Ajiabadek Akanpani', '2017-09-29', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephanie Akua Ntow', 246379546, 246379546, 'Steph.ntow1986@gmail.com', NULL, 'CLASS1A'),
('DR0244', 5, 'Isreal Fosu Nyamekye', '2018-08-27', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Fosu Rockson', 558060344, 558060344, 'livingrock75@gmail.com', NULL, 'CLASS1A'),
('DR0245', 5, 'Kwasi Kesse Sayan', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Dora Tuah', 541339977, 541339977, NULL, NULL, 'CLASS1A'),
('DR0246', 5, 'Peter Domena Attafuah', '2018-02-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Miriam Otubea Attafuah', 245788214, 245788214, 'miriamotoo7@gmail.com', NULL, 'CLASS1A'),
('DR0247', 5, 'Spio Garbra Georgeth', '2018-09-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Gloria Asuamah', 249513710, 249513710, NULL, NULL, 'CLASS1A'),
('DR0248', 5, 'Chelsea Adwoa Kosowaa Kwarteng', '2018-12-31', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Sarah Amporofi', 546440558, 546440558, 'Sarahamprofi23@gmail.com', NULL, 'CLASS1A'),
('DR0249', 5, 'Korri-Norngne Kyla Yaaku', '2017-09-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Gifty Arthur Yaaka', 244988388, 578665535, 'giftyyarth@gmail.com', NULL, 'CLASS1A'),
('DR0250', 5, 'Edwin Addo Frimpong', '2017-12-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Twenewaa Ernestina', 243772626, 243772626, 'etwenewaa0@gmail.com', NULL, 'CLASS1A'),
('DR0251', 5, 'Bervelyn Aning Anokye', '2018-10-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anokye Kwame Derrick', 249147278, 249147278, 'derrickolator@gmail.com', NULL, 'CLASS1A'),
('DR0252', 5, 'Raphael Adusei', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret konama', 245468482, 245468482, 'obaapapeggie@gmail.com', NULL, 'CLASS1A'),
('DR0253', 5, 'Jamima Adbulai Sidabo', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abdulai Sadia Zubeiru', 242706571, 242706571, 'abzubeiru@gmail.com', NULL, 'CLASS1A'),
('DR0254', 5, 'Kristodea Efua Baawa Mefful', '2018-04-27', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Mefful', 249292007, 249292007, 'francismefful@gmail.com', NULL, 'CLASS1A'),
('DR0255', 5, 'Ewurama Asereba Essel', '2017-11-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Essel', 243948966, 243948966, 'Samuelessel408@gmail.com', NULL, 'CLASS1A'),
('DR0256', 5, 'Gifted Aseda Teye Nanor', '2018-06-30', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephen Y. Nanor', 246355077, 246355077, 'stephananor97@gmail.com', NULL, 'CLASS1A'),
('DR0257', 5, 'Goldie Naana Asantewaa', '2017-11-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Sophia Asantewaa', NULL, 209154665, NULL, NULL, 'CLASS1A'),
('DR0258', 5, 'Victory Afriyie Asomanmg', '2017-10-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Kingsford Asomanmg', 243131906, 243131906, NULL, NULL, 'CLASS1A'),
('DR0258', 6, 'Tachie Yeboah Elton', '2019-10-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Tachie Yeboah Samuel', 248152771, 248152771, NULL, NULL, 'CLASS1B'),
('DR0259', 6, 'Ohene Katakyie Osarfo Nyantakyi', '2018-07-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Nyantakyiwaa Helena', 546999646, 546999646, 'helenqsarfosikapamaame15@gmail.com', NULL, 'CLASS1B'),
('DR0260', 6, 'Akyea Mensah Mcjosh', '2018-04-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adjei-Kwaa Mavis', 241692990, 241692990, NULL, NULL, 'CLASS1B'),
('DR0261', 6, 'Takyi Yaa Nora', '2018-05-03', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 556465771, 556465771, 'padyjulia3@gmail.com', NULL, 'CLASS1B'),
('DR0262', 6, 'Ampensrah Nyarko Evangle', '2017-07-07', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Elizebeth Nkankomago', 208318945, NULL, 'lampensrahemmanuel123@gmail.com', NULL, 'CLASS1B'),
('DR0263', 6, 'Agyei Kofi Seth', '2017-07-07', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abaidoo Elizabeth', 553646650, 553646650, 'abaidooe3H@gmail.com', NULL, 'CLASS1B'),
('DR0264', 6, 'Spendylove A. Yeboah', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Clement Yeboah', 612486626, 34612486606, 'clementyeboah24@gmail.com', NULL, 'CLASS1B'),
('DR0265', 6, 'Othniel Bennet Quaye', '2018-05-31', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Fiahortu Ama Beatrice', 206666870, 548698427, 'fiahortuama@gmail.com', NULL, 'CLASS1B'),
('DR0266', 6, 'Othniel Amissah Danso', '2017-10-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Danso Kingsley', 542737548, 542737548, 'pastordansokingsly@gmail.com', NULL, 'CLASS1B'),
('DR0267', 6, 'Geuel Nhyira Kyeremer Antwi', '2018-01-31', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Victoria Pomaa', 547548655, 547548655, 'victoriapomaa24@gmail.com', NULL, 'CLASS1B'),
('DR0268', 6, 'Salima Awomlie Ayomah', '2019-06-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 542937506, 206626983, 'surayyayaro@gmail.com', NULL, 'CLASS1B'),
('DR0269', 6, 'Alexis-Desmond Manuel Asiedu', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Amarie Adna Awurama', 209228620, 209228620, 'adnaamarie17@gmail.com', NULL, 'CLASS1B'),
('DR0270', 6, 'Duke Kwamena A. Newton', '2018-02-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Pearl Rachel Newton', 243151031, 243151031, NULL, NULL, 'CLASS1B'),
('DR0271', 6, 'Dasnel Osei-Adasa', '2017-04-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 245172863, 245172863, '0seikojo2a@gmail.com', NULL, 'CLASS1B'),
('DR0272', 6, 'Nova Sarpomaa Gyan', '2018-05-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Owusu Sarpomaa Mavis', 509591709, 509591709, 'mavisowusu123@gmail.com', NULL, 'CLASS1B'),
('DR0273', 6, 'Mcdiamond Frimpong-Manso', '2017-07-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Frimpong Yeboah', 244348745, 244348745, 'RFRIMPONG262@GMAIL.COM', NULL, 'CLASS1B'),
('DR0036', 8, 'Desmond Anim Kofi', '2016-02-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Anim Atta Yaw', 248775246, 248775246, 'atta74850@gmail.com', NULL, 'CLASS2B'),
('DR0037', 8, 'Caleb Dannu Jnr', '2017-06-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Daanu Peter Blanskon', 244114971, 205668028, 'pdaanu@yahoo.com', NULL, 'CLASS2B'),
('DR0038', 8, 'Audrey Nhyira Owusu', '2017-01-26', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Cecilia Ntiamoah', 245897910, 245897910, 'ceciliantiamoah2@gmail.com', NULL, 'CLASS2B'),
('DR0039', 8, 'Cherish Adom Kissiwaa Waye', '2017-10-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rev.Waye Agyemang Badu', 249831548, 249831548, 'kumiclara17@gmail.com', NULL, 'CLASS2B'),
('DR0040', 8, 'Imran Abu Sadigue', '2017-11-13', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abu Sadigue', 500639586, 245813263, 'stacyamenor2@gmail.com', NULL, 'CLASS2B'),
('DR0041', 8, 'Jeremiah Okpoti Adjei', '2017-03-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Jonathan Adjei Akpor', 207114772, 207114772, 'jakpor@gmail.com', NULL, 'CLASS2B'),
('DR0042', 8, 'Oppong Kyere Pamela', '2014-08-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Somea Esther', 557591929, 557591929, NULL, NULL, 'CLASS2B'),
('DR0043', 8, 'Tei Ackwerh', '2017-01-28', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Enock Tetteh Ackwerh', 246196881, 246196881, 'celestinakorankye0@gmail.com', NULL, 'CLASS2B'),
('DR0044', 8, 'Nanama Sikafour Carabel Kyeremeh', '2016-09-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ampaabeng Kyeremeh', 206319590, NULL, NULL, NULL, 'CLASS2B'),
('DR0045', 8, 'Samuel Dapaah', '2017-11-24', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Apostle Collins Dapaah', 208190034, 248266764, 'owusushadrach553@gmail.com', NULL, 'CLASS2B'),
('DR0046', 8, 'Afua Kyerewaa Nyarko', '2016-12-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Peter Nyarko', 243241025, 243241025, 'nnana2g@gmail.com', NULL, 'CLASS2B'),
('DR0047', 8, 'Samuel Osborn', '2016-03-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Sunny & Goodness', 247418787, 247418787, 'sunnychigozie77@gmail.com', NULL, 'CLASS2B'),
('DR0048', 8, 'Henry Opoku Boakye', '2017-01-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Bismark Opoku-Boakye', 244242342, 247418787, 'bopokuboakye@gmail.com', NULL, 'CLASS2B'),
('DR0049', 8, 'Danielle Aseda Ankah', '2016-12-11', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Michael Abraham Ankah', 244853175, 244853175, NULL, NULL, 'CLASS2B'),
('DR0050', 8, 'Adjei Nkunim Linette', '2017-01-13', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Eric Adjei', 246893300, 246893300, 'ericuspapaa@gmail.com', NULL, 'CLASS2B'),
('DR0051', 8, 'Takyiwaa Yeboaa Stephanie', '2017-03-27', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephen Kwabena Yeboah', 558061236, 558061236, NULL, NULL, 'CLASS2B'),
('DR0052', 8, 'Kingsford Kwame Kankam', '2016-03-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Knonama', 245468482, 245468482, 'obaapapeggie@gmail.com', NULL, 'CLASS2B'),
('DR0053', 8, 'Heleb Boateng Awuah', '2016-07-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Awuah Baffour Desmond', 242323683, 242323683, 'desbee20@gmail.com', NULL, 'CLASS2B'),
('DR0054', 8, 'Francis Kyere', '2016-09-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Kyere', 244964700, 244964700, 'maviskyere1983@gmail.com', NULL, 'CLASS2B'),
('DR0055', 8, 'Nubia Dedo Tetteh', '2016-06-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Joseph Tetteh', 537263929, 537263929, 'nenekpabitey7@gmail.com', NULL, 'CLASS2B'),
('DR0056', 8, 'Lucky Borngreat Boateng', '2016-01-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 595970993, 595970993, 'Adams.boateng@gmail.com', NULL, 'CLASS2B'),
('DR0011', 9, 'Stephens Abraham Vak Abraham', '2015-06-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Suzzy Owusu', 547972625, 547972625, NULL, NULL, 'CLASS3A'),
('DR0012', 9, 'Elvis Nana Yeboah Bimpong', '2015-06-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Afia Frimpomaa', 241471428, 241471428, NULL, NULL, 'CLASS3A'),
('DR0013', 9, 'Prisca Effah', '2015-04-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Effah', 243878692, 243878692, 'reffah7@gmail.com', NULL, 'CLASS3A'),
('DR0014', 9, 'Nana Aksoua Kusi Adu Asare', '2015-06-28', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Vida Obeng', 547813015, 547813015, 'nyarkodll@gmail.com', NULL, 'CLASS3A'),
('DR0015', 9, 'Diamondtina Yireukyiwaa Aseidu', '2016-06-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ofori Asiedu Francis', 243967877, 243967877, 'francisoforiasiedu@gmail.com', NULL, 'CLASS3A'),
('DR0016', 9, 'Jeffery Kwabena Yeboaah', '2015-07-07', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charlotte Kumi', 248381430, 248381430, 'charlottekumi34@gmail.com', NULL, 'CLASS3A'),
('DR0017', 9, 'Angel Adwoa Asiamah', '2015-11-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abigail A. Sarpong', 242577380, 242577380, 'asarpongbiggles@gmail.com', NULL, 'CLASS3A'),
('DR0018', 9, 'Lilian Serwaa Yeboah', '2015-12-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Martha Asuamah Yeboah', 245098694, 245098694, NULL, NULL, 'CLASS3A'),
('DR0019', 9, 'Melody Brako Gyan', '2016-07-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Saah', 541486676, 541486676, NULL, NULL, 'CLASS3A'),
('DR0020', 9, 'Damoah Miracle Godfred', '2015-10-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Jospeh Kwasi Ampem', 243451669, 243451669, 'jakpee2006@yahoo.com', NULL, 'CLASS3A'),
('DR0021', 9, 'Edwin Addo Asamoah', '2014-12-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Prince Asamoah', 244082901, 244082901, 'prinmoah@gmail.com', NULL, 'CLASS3A'),
('DR0022', 9, 'Imam Biesoh-Adjoa Sayibu Kankah', '2015-10-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rafatu Sayibu', 557291712, 244082901, 'issifusayibu@yahoo.com', NULL, 'CLASS3A'),
('DR0023', 9, 'Ohemaa Audrey Asare', '2015-03-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephen Asare', 246275797, 246275797, 'asderrick46@gmail.com', NULL, 'CLASS3A'),
('DR0024', 9, 'Aseda Dankwah Boateng', '2015-09-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Gershon Gyamfi Boateng', 24682107, 246275797, 'gershon.gyamfi@gmai.com', NULL, 'CLASS3A'),
('DR0025', 9, 'Richmond Ofosu Manu', '2015-09-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Seth Manu', 205169494, 205169494, NULL, NULL, 'CLASS3A'),
('DR0026', 9, 'Lilian Arthur Mintah', '2015-03-19', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Lydia Okyere', 241506737, 207453125, 'lydiaokyere74@gmail.com', NULL, 'CLASS3A'),
('DR0027', 9, 'Quaye Klenam Petra', '2015-07-09', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Fiahortu Ama', 206666870, 206666870, 'fiahortuama@gmail.com', NULL, 'CLASS3A'),
('DR0028', 9, 'Fiona Owusu Ampofo', '2014-10-11', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bona Elizabeth', 546311848, 546311848, 'bonae760@gmail.com', NULL, 'CLASS3A'),
('DR0029', 9, 'Owusuaa Boakye Elikharis', '2016-03-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Asamoah Bemma Rachael', 247162260, 504595700, 'rachealbemma@gmail.com', NULL, 'CLASS3A'),
('DR0030', 9, 'Emmanuella Afriyie Kyere', '2015-05-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Aseiduwaa Rosemary', 558650022, 558650022, NULL, NULL, 'CLASS3A'),
('DR0031', 9, 'Duchess Kukua Nyarba Newton', '2015-12-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Pearl R.L. Newton', 244679386, 243151031, 'praspad1983@gmail.com', NULL, 'CLASS3A'),
('DR0032', 9, 'Jesse Opoku Gyan', '2015-09-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Alice Pimma', 242262275, 242262275, 'alicepimma4@gmail.com', NULL, 'CLASS3A'),
('DR0033', 9, 'Edwin Addo Asamaoh', '2014-04-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Prince Asamoah', 244082901, 244082901, 'prinmoah@gmail.com', NULL, 'CLASS3A'),
('DR0034', 9, 'Authur Kwadow Nimson', '2015-09-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 540832713, 540832713, 'oduroblessing88@gmail.com', NULL, 'CLASS3A'),
('DR0035', 9, 'Eliezer Agyie Darkowaa', '2016-03-11', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Afia Owusuwaa', 206810692, 206810692, NULL, NULL, 'CLASS3A'),
('DR0057', 10, 'Akyere Appiah-Kusi', '2016-03-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Elvis Brenya Appiah-Kusi', 208433595, 208433595, 'appikusi@yahoo.co.uk', NULL, 'CLASS3B'),
('DR0058', 10, 'Vida Elikm Sogbey', '2016-03-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Noble Sogbey', 554370224, 208433595, 'sogbeynoble1@gmail.com', NULL, 'CLASS3B'),
('DR0059', 10, 'Alvin Addai Frimpong', '2015-11-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Twenewaa Ernestina', 243772626, 243772626, 'etwenewaa@gmail.com', NULL, 'CLASS3B'),
('DR0060', 10, 'Chrispin Virsob Bangkewa Kuunifaa', '2015-03-17', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Lana Lydia Bewaale', 242714153, 242714153, 'leelan8444@gmail.com', NULL, 'CLASS3B'),
('DR0061', 10, 'Evodia Benewaa Acheaw', '2016-04-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ivy Sarbi-Ababio', 245947095, 245947095, NULL, NULL, 'CLASS3B'),
('DR0062', 10, 'Ohemaa Kuowa Osarfo Nyantakyi', '2016-02-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Osarfo Nyantakyi Emmanuel', 245145156, 245145156, NULL, NULL, 'CLASS3B'),
('DR0063', 10, 'Aaron Korkpoe', '2015-01-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adombor Prsicilla', 594711505, 594711505, 'adomborpriscilla@yahoo.com', NULL, 'CLASS3B'),
('DR0064', 10, 'Abena Boaduwaa Amponsah', '2015-03-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ing. Emmanuel Osafo', 503601335, 503601335, NULL, NULL, 'CLASS3B'),
('DR0065', 10, 'Paa Kwesi Nhyiraba Mbir Mefful', '2015-05-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Mefful', 249292007, 249292007, 'francismefful@gmail.com', NULL, 'CLASS3B'),
('DR0066', 10, 'Yeboah Garand Adjei', '2015-04-07', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Evans A. yeboah', 208779050, 243465398, 'yevans628@gmail.com', NULL, 'CLASS3B'),
('DR0067', 10, 'Joycelin Pokuaa Amponsah', '2015-07-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Amoako Fordjour', 208935417, 26494413, 'jenkofy@gmail.com', NULL, 'CLASS3B'),
('DR0068', 10, 'Margaret Semefa Dzameshie', '2015-02-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Dzameshie', 547947194, 547947194, 'vivianboateng348@gmail.com', NULL, 'CLASS3B'),
('DR0069', 10, 'Sallah Hawayn Mashat', '2014-04-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 537957288, 537957288, NULL, NULL, 'CLASS3B'),
('DR0070', 10, 'Nathan Serwah sikapa Essel', '2015-12-17', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Essel', 243948966, 243948966, 'samuelessel408@gmail.com', NULL, 'CLASS3B'),
('DR0071', 10, 'Diana Amponsah', '2014-03-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 542540266, NULL, NULL, NULL, 'CLASS3B'),
('DR0072', 10, 'Nathaniel Obeng Kwasi', '2016-01-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Obeng Owura Kwadwo', 208361408, NULL, NULL, NULL, 'CLASS3B'),
('DR0073', 10, 'Aaliyah Nana Abena Adams', '2015-10-13', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Andriana Aning', 244214344, 244214344, 'andriana1231988@gmail.com', NULL, 'CLASS3B'),
('DR0074', 10, 'Phineaas Fofie', '2015-06-23', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Fofie Christian', 208826160, 208826160, 'fofiechristian041@gmail.com', NULL, 'CLASS3B'),
('DR0075', 10, 'Dishnell Pomaa Amponsah', '2015-10-22', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anastasia Opoku Yeboah', 265043914, 265043914, 'anastasiabanson507@gmail.com', NULL, 'CLASS3B'),
('DR0076', 10, 'Michelle Nana Yaa Ntim', '2012-09-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rebecca Mensah', 547271337, 547271337, 'mensbeccs34@gmail.com', NULL, 'CLASS3B'),
('DR0200', 11, 'Jessica Pokuaa Boakye', '2014-03-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bismark Opoku-Boakye', 244242342, 244242342, 'bopokuboakye@gmail.com', NULL, 'CLASS4A'),
('DR0201', 11, 'Majorie Gyemea Mensah', '2015-02-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Evelyn Asamoah Mensah', 2091732744, 244242342, 'evelynasamoah16@gmail.com', NULL, 'CLASS4A'),
('DR0202', 11, 'Reginald Nana Asomaning', '2014-10-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kingsford Aomaning', 243131906, 243131906, 'kingsfordasomanin@gmail.com', NULL, 'CLASS4A'),
('DR0203', 11, 'Adjei-Nkansah Nyamekye Vanessa', '2014-10-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Eric Adjei', 246893300, 246893300, 'ericuspapaa@gmail.com', NULL, 'CLASS4A'),
('DR0204', 11, 'Lauretta Achiaa Obiri', '2014-11-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Douglas Addo', 24862805, 24862805, 'douglasaddo12@gmail.com', NULL, 'CLASS4A'),
('DR0205', 11, 'Osarfo Sikapa Kwartemaa Osarfo Nyantakyi', '2014-09-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Osarfo Nyantakyi Emmanuel', 245145156, 245145156, NULL, NULL, 'CLASS4A'),
('DR0206', 11, 'Persis Arkoh Adu', '2013-10-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bright Kofi Adu', 245915876, 245145156, 'brightadukofi@gmail.com', NULL, 'CLASS4A'),
('DR0207', 11, 'Vicentia Oforiwaa Asiedu', '2015-03-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ofori Asiedu Francis', 243967877, 245145156, 'francisoforiasiedu@gmail.com', NULL, 'CLASS4A'),
('DR0208', 11, 'Hrriet Nyarko Manu', '2011-03-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Seth Manu', 243844433, 205169494, NULL, NULL, 'CLASS4A'),
('DR0209', 11, 'Macbill Habel Clinton', '2012-05-20', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'I-raw Baman Lucky Clinton', 244444849, 245145156, 'info.mapping.gh@gmail.com', NULL, 'CLASS4A'),
('DR0210', 11, 'Ekow Dede Painstill', '2012-03-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Josephine Ehuren', 244788898, 244788898, 'jehuren38@gmail.com', NULL, 'CLASS4A'),
('DR0211', 11, 'Kofi Owusu Ameyaw', '2014-02-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ameyaw Gyan', 243413933, 243413933, NULL, NULL, 'CLASS4A'),
('DR0212', 11, 'Perez Amoako Danso', '2014-10-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Danso Kingsley', 542737548, 243413933, 'pastordansokingsley@gmail.com', NULL, 'CLASS4A'),
('DR0213', 11, 'Keziah Adinkrah Yeboah', '2014-11-30', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Agyeiwaa Augustina', 557668311, 243413933, 'nkukeziah7@gmail.com', NULL, 'CLASS4A'),
('DR0214', 11, 'Richlove Nketiah Kyere', '2013-07-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Aseiduwaa Rosemary', 558650022, 558650022, NULL, NULL, 'CLASS4A'),
('DR0215', 11, 'Pascaline Fredua-Agyeman', '2015-04-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Yvonne Fiamor', 248978994, 248978994, 'amayvonne23@gmail.com', NULL, 'CLASS4A'),
('DR0216', 11, 'Belvia Ocran', '2014-10-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Leticia Sam-Ocran', 242761555, 248978994, 'leticiasam17@gmail.com', NULL, 'CLASS4A'),
('DR0217', 11, 'Daniel Adjei Manu', '2013-11-16', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Cecilia Biney', 246465968, 248978994, 'cecil.maab@gmail.com', NULL, 'CLASS4A'),
('DR0218', 11, 'Gyamfi Prisca', '2014-06-07', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Foriwaa Georgina', 507575033, 552541498, NULL, NULL, 'CLASS4A'),
('DR0219', 11, 'Caleb Kwaku Nina', '2014-04-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Patience Bajike', 244754354, 248978994, 'patba54@gmail.com', NULL, 'CLASS4A'),
('DR0220', 11, 'Ransford Owusu Bumangama', '2014-12-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Winifred Baah', 241173318, 241173318, NULL, NULL, 'CLASS4A'),
('DR0221', 11, 'Eric Kwame Danso Jnr', '2013-06-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Agyeiwaa', 243223539, 243223539, 'margaretagyeiwaa400@gmail.com', NULL, 'CLASS4A'),
('DR0222', 11, 'Owusu Fosuaah Franklina', '2014-12-28', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Frank Owusu', 244135757, 244135757, 'frankowusu129@yahoo.com', NULL, 'CLASS4A'),
('DR0223', 11, 'Evangeline Aseda Ahia Quarcoo', '2015-02-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Juanita Ahia Quarcoo', 209162150, 209162150, 'juan83p@yahoo.com', NULL, 'CLASS4A'),
('DR0181', 12, 'Edrick Quaicoe Okyere', '2013-09-25', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Charles Okyere', 243841518, 243841518, NULL, NULL, 'CLASS4B'),
('DR0182', 12, 'Oswald Takyi Adofo', '2014-10-23', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Gyiraa Vida', 557282805, 557282805, NULL, NULL, 'CLASS4B'),
('DR0183', 12, 'Shaun Raphael Sieh', '2014-05-05', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mavis Kyere', 244964700, 244964700, 'maviskyere1983@gmail.com', NULL, 'CLASS4B'),
('DR0184', 12, 'Meldrick Kwakye Ampaw', '2014-07-15', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Sarah Ayiwa Aning', 202365092, 243955930, 'sarahyiwaaning@gmail.com', NULL, 'CLASS4B'),
('DR0185', 12, 'Kingsley Ackah Kwaw', '2014-09-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kingsford Ackah Kwaw', 207387141, 207387141, 'kingsfordackah01@gmail.com', NULL, 'CLASS4B'),
('DR0186', 12, 'Ofori Kusi Cyril', '2014-12-04', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kusi Francise-Alice Nyarko', 506105015, 208073033, NULL, NULL, 'CLASS4B'),
('DR0187', 12, 'David Kingsley Modey', '2014-04-17', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ameyaw Gyan', 243413933, 447909238783, 'nanayaw86@gmail.com', NULL, 'CLASS4B'),
('DR0188', 12, 'Eric Kwame Danso Snr.', '2013-06-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Margaret Agyeiwaa', 243223539, 243223539, 'margaretagyeiwaa400@gmail.com', NULL, 'CLASS4B'),
('DR0189', 12, 'Alexandra Boatemaa Oduro', '2014-12-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Helena Agyeiwaaa', 502548650, 502548650, 'helenaagyeiwaa76@gmail.com', NULL, 'CLASS4B'),
('DR0190', 12, 'Bryce Annor Walfred', '2014-05-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kyeraa Felicia', 549187744, 502548650, 'anor.emma@gmail.com', NULL, 'CLASS4B'),
('DR0191', 12, 'Twumasi Vanessah', '2014-09-02', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Twumasi Kwaku Emmanuel', 547639020, 502548650, 'etwumasikwaku@gmail.com', NULL, 'CLASS4B'),
('DR0192', 12, 'Beverly Nana Kumi Acheaw', '2014-12-29', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Quansah Sam Bernice', 540183992, 540183992, 'bernicequansah28@gmail.com', NULL, 'CLASS4B'),
('DR0193', 12, 'Ernest Agyemang Badu Kyeremeh', '2014-01-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ampaabeng Kyeremeh', 206319590, 206319590, NULL, NULL, 'CLASS4B'),
('DR0194', 12, 'Nhyira Ayisi Boateng', '2013-09-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Gershon Gyamfi Boateng', 246825107, 246825107, 'gershon.gyamfi@gmail.com', NULL, 'CLASS4B'),
('DR0195', 12, 'Vince Dankwah', '2014-06-12', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Ruth Serwaa', 544642864, 544642864, 'joseph.dankwah@icloud.com', NULL, 'CLASS4B'),
('DR0196', 12, 'Enoch Korkpoe', '2013-11-03', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adombor Priscilla', 594711505, 594711505, 'adomborpriscilla@yahoo.com', NULL, 'CLASS4B'),
('DR0197', 12, 'Shamima Halkida Abdulai', '2015-01-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abdulai Sadia Zubeiru', 554120451, 554120451, 'abdulaisadiazubeiru', NULL, 'CLASS4B'),
('DR0198', 12, 'Edrick Okyere Quaicoe', '2013-09-25', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Okyere Charles', 243841518, 243841518, NULL, NULL, 'CLASS4B'),
('DR0199', 12, 'Herbert Oppong Badu', '2014-10-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Badu Johnson', 547691448, 547691448, 'jbadu268@gmail.com', NULL, 'CLASS4B'),
('DR0115', 13, 'Brenya Appiah-Kusi', '2013-10-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Diana Nketiah', 205264063, 244964700, 'nketiahdiana@yahoo.com', NULL, 'CLASS5A'),
('DR0116', 13, 'Mabel Agyeiwaa Ohemaa', '2013-02-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Emelia Saakuu', 554379651, NULL, NULL, NULL, 'CLASS5A'),
('DR0117', 13, 'Jeffery Obiri Yeboah', '2010-08-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abrefa', 242864336, 242864336, 'charleskumahabrefa@gmail.com', NULL, 'CLASS5A'),
('DR0118', 13, 'Malvin Nsiah Korsash', '2013-04-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Aboagye Korsah', 249631910, 249631910, 'kwasikorsah80@gmail.com', NULL, 'CLASS5A'),
('DR0119', 13, 'Michelle Chinoso John', '2015-08-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Blessed Joy Chinoso', 257645998, 257645998, NULL, NULL, 'CLASS5A'),
('DR0120', 13, 'Kwabena Amankona Sakyi', '2013-10-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Sakyi', 508803427, 508803427, 'richardsakyi95@yahoo.com', NULL, 'CLASS5A'),
('DR0121', 13, 'Ataa Yaa Bernice', '2012-11-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Manu', 24078459, 24078459, NULL, NULL, 'CLASS5A'),
('DR0122', 13, 'Michelle Amosiwaa Asumadu', '2013-09-05', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Frimpong Salomey', 244180889, 244180889, 'ilady65921@gmail.com', NULL, 'CLASS5A'),
('DR0123', 13, 'Ivan Osei Asiamah', '2014-01-09', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abigail A. Sarpong', 242577380, 242577380, 'asarpongbiggles@gmail.com', NULL, 'CLASS5A'),
('DR0124', 13, 'Daniel Akantoa', '2013-03-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Nana Bennett Akantoa', 261587629, 205287957, NULL, NULL, 'CLASS5A'),
('DR0125', 13, 'Christel Naa-mwin Barika', '2013-09-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Lydia Bewak Lana', 242714153, NULL, 'leelan84ww@yahoo.com', NULL, 'CLASS5A'),
('DR0126', 13, 'Richmond Okyere Ampoe Martinson', '2013-06-25', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Victoria Ofori Odette', 540539484, 540539484, 'odetteofori589@gmail.com', NULL, 'CLASS5A'),
('DR0127', 13, 'Gerald Kwabena Nina', '2011-12-27', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Emmanuel Bawa', 208402309, 208402309, 'patba54@gmail.com', NULL, 'CLASS5A'),
('DR0128', 13, 'Kelvin Owusu Donkor', '2012-04-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Juliet Owusus Donkor', 540769799, 540769799, NULL, NULL, 'CLASS5A'),
('DR0129', 13, 'Bridget Afriyie Kwarteng', '2013-04-17', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Vera Adoma Boakye', 246221722, 246221722, NULL, NULL, 'CLASS5A'),
('DR0130', 13, 'Prince Yeboah Yaang', '2013-08-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Stella/Richmond Yeboah', 247048542, 247048542, NULL, NULL, 'CLASS5A'),
('DR0131', 13, 'Devlyn Nhyira Obour', '2013-09-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Linda Twumasi', 247633708, 202333904, 'lintwumasi17@gmail.com', NULL, 'CLASS5A'),
('DR0132', 13, 'Nana Fosu Oteng-Ampofo', '2013-12-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Belinda D. Oteng-Ampofo', 243267585, 243267585, 'lynoteng1@outlook.com', NULL, 'CLASS5A'),
('DR0133', 13, 'Joseph Nathan Naounou', '2013-11-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Rose Naounou', 598446229, 598446229, 'rosnaounou7777@gmail.com', NULL, 'CLASS5A'),
('DR0134', 13, 'Gyasi Afia Agyemang', '2013-12-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Kwasi Apenteng', 551241353, 207095583, 'hiakwasi@gmail.com', NULL, 'CLASS5A'),
('DR0135', 13, 'Caleb Akyea Mensah', '2013-12-18', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adjei-Kwaa Mavis', 241692990, 241692990, NULL, NULL, 'CLASS5A'),
('DR0224', 13, 'Kwabena Pako Adu', '2013-06-11', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Adu Emmauel', 242759406, 242759406, 'papasource@gmail.com', NULL, 'CLASS5B'),
('DR0225', 13, 'Falconer Kojo Prah', '2013-06-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Kojo Kum Prah', 244781908, 244781908, 'prahkojo77@gmail.com', NULL, 'CLASS5B'),
('DR0226', 13, 'Cedella Mills', '2013-09-15', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Mercy Mills', 243768462, NULL, 'mercymills68@gmail.com', NULL, 'CLASS5B'),
('DR0227', 13, 'Mercedes Agyeiwaa Anokye', '2013-11-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Anokye Kwame Derrick', 249147278, 249147278, 'derrickolator@gmail.com', NULL, 'CLASS5B'),
('DR0228', 13, 'Naawemuo Junior', '2013-11-10', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Roger Wemuo', 555721930, 202332005, 'rogerwemuo@gmail.com', NULL, 'CLASS5B'),
('DR0229', 13, 'Thelma Appiah', '2013-03-03', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Meri Abubakari / Samuel Appiah', 550326606, 550326606, 'meriabubakari@gmail.com', NULL, 'CLASS5B'),
('DR0230', 13, 'Lewis Anyietewin Akanpami', '2013-12-11', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Stephanie Akua Ntow', 246379546, 246379546, 'steph.ntow1986@gmail.com', NULL, 'CLASS5B'),
('DR0231', 13, 'Tetteh Wayoe Ackwerh', '2013-03-14', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Celestina Korankye & Enoch', 246196881, 246196881, 'celestinakorankye0@gmail.com', NULL, 'CLASS5B'),
('DR0232', 13, 'Clinton Amen Brainy', '2010-10-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'I-Raw Baman Lucky Clinton', 244444849, 244444849, 'info.mapping.gh@gmail.com', NULL, 'CLASS5B'),
('DR0233', 13, 'Samuella Nana Yaa Abban', '2014-06-04', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'David Abban', 245831138, 245831138, 'abbans34.ad@gmail.com', NULL, 'CLASS5B'),
('DR0234', 13, 'Ataa Yaa Benedicta', '2012-11-08', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Manu', 2407801159, 245831138, NULL, NULL, 'CLASS5B'),
('DR0235', 13, 'Aseidu Agyemang Kelvin', '2012-03-08', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Rosemond Aseidu Acheampong', 544828628, 205893463, 'nkofi8930@gmail.com', NULL, 'CLASS5B'),
('DR0236', 13, 'Christopher Annobil Fiifi Mefful', '2013-04-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Francis Mefful', 249292007, 249292007, 'francismefful@gmail.com', NULL, 'CLASS5B'),
('DR0237', 13, 'Eric Opoku Kusi', '2013-10-30', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Rita Oti Manu', 206796763, 206796763, 'ritaotimanu@gmail.com', NULL, 'CLASS5B'),
('DR0136', 6, 'Samuel Godwin', '2011-01-19', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Sunny & Goodness', 247418787, 247418787, 'sannychigozie770@gmail.com', NULL, 'CLASS6'),
('DR0137', 6, 'Michael Abban Nuku', '2012-06-22', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'David Abban', 245831138, 245831138, 'abbans34.ad@gmail.com', NULL, 'CLASS6'),
('DR0138', 6, 'Hanzzy Nana Aba Darllington', '2012-12-20', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Ampofo Stella Ofori', 541140449, 541140449, NULL, NULL, 'CLASS6'),
('DR0139', 6, 'Treymaine Carter Apraku', '2013-01-21', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Emma Ohenewaa', 542677660, 542677660, 'eohenewaa2102@gmail.com', NULL, 'CLASS6'),
('DR0140', 6, 'Lordina Opoku Afrifa', '2012-09-01', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Naomi Amakwaa yeboah', 244823663, 244823663, 'naomiyeboahamankwaa22@gmail.com', NULL, 'CLASS6'),
('DR0141', 6, 'Keizia Tiwaah Amponsah', '2012-07-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Janet Amoako Fordjour', 208935417, 246494413, 'jenkofy@gmail.com', NULL, 'CLASS6'),
('DR0142', 6, 'Nhyira Ama Adomako', '2013-09-21', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Adomako Johnson', 248096810, 208391963, NULL, NULL, 'CLASS6'),
('DR0143', 6, 'Michelle Emmanuella Sieh', '2012-08-26', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'mavis Kyere', 249664700, 244823663, 'maviskyere1983@gmail.com', NULL, 'CLASS6'),
('DR0144', 6, 'Vera Serwaa Kwakye', '2011-04-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Evelyn Asamoah Mensah', 209173274, 209173274, 'evelynasamoah26@gmail.com', NULL, 'CLASS6'),
('DR0145', 6, 'Yeboah Badu Joycelyn', '2011-10-07', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Badu Johnson', 201364119, 547691448, 'jbadu268@gmail.com', NULL, 'CLASS6'),
('DR0146', 6, 'Emile Owusu Ampofo', '2012-02-29', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bona Elizabeth', 546311848, 546311848, 'bonae760@gmail.com', NULL, 'CLASS6'),
('DR0147', 6, 'Lordfred Yeboah', '2012-01-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Philomina Nketia', 245077710, 245077710, 'philomenayeboah82@gmail.com', NULL, 'CLASS6'),
('DR0148', 6, 'Raihan Tipaya Shahadu', '2012-03-06', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Mohammed Shani Shahadu', 243880696, 243880696, 'smshahdu@gmail.com', NULL, 'CLASS6'),
('DR0149', 6, 'Nina Anim Boateng', '2012-10-23', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Samuel Anim Atta Yaw', 248775246, 248775246, 'atta74850@gmail.com', NULL, 'CLASS6'),
('DR0150', 6, 'Princewell Kwadwo Asamoah', '2011-12-05', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Emelia Dadzie/ Prince Asamoah', 244082901, 244082901, 'prinmoah@gmail.ccom', NULL, 'CLASS6'),
('DR0151', 6, 'Agyei Lilian', '2011-12-25', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Faustina Owusuaa', 240627059, NULL, NULL, NULL, 'CLASS6'),
('DR0152', 6, 'Prosper Ekow Abaidoo', '2010-10-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Abaidoo Elizabeth', 553646650, 553646650, 'abaidooe3744@gmail.com', NULL, 'CLASS6'),
('DR0153', 6, 'Asante Fonic', '2010-07-29', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 246868012, 246868012, NULL, NULL, 'CLASS6'),
('DR0154', 6, 'Adwoa Tumwaa Sakyi', '2012-10-10', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Sakyi', 508803427, 508803427, 'richardsakyi95@yahoo.com', NULL, 'CLASS6'),
('DR0155', 6, 'Richmond Acheampong Christian', '2012-09-01', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Richard Acheampng', 243906745, 243906745, 'richhandofgod45@gmail.com', NULL, 'CLASS6'),
('DR0156', 6, 'Frimpong Isaace Kwame', '2011-09-17', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Isaac Frimpong Kofi', 505903790, 248866869, NULL, NULL, 'CLASS6'),
('DR0157', 6, 'Agyemang Kingsforda', '2013-03-17', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Doris Ferka Oduro', 557343019, 554204014, NULL, NULL, 'CLASS6'),
('DR0158', 6, 'Ayele Serwaa Elsie', '2012-11-16', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Asamoah Constance', 552531981, 201122678, NULL, NULL, 'CLASS6'),
('DR0159', 6, 'Emmanuella Efua Egyir', '2013-05-24', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Patience Kyeraa', 550720005, 550720005, 'patiencekyeraa055@gmail.com', NULL, 'CLASS6'),
('DR0160', 6, 'Mariam Lumenga Abdulai', '2012-09-18', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Abdulai Sadia Zuberiru', 554120451, 554120451, 'abdulaisadiazubeiru@gmail.com', NULL, 'CLASS6'),
('DR0161', 6, 'Gillian Duncan Kwarteng', '2012-11-06', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Joshua Amo Frimpong', 555887873, 555887873, 'mary.yzma@gmail.com', NULL, 'CLASS6'),
('DR0162', 6, 'Boateng Nhyira Owusuaa', '2011-10-27', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Munufie Oforiwaa Adwoa', 209639818, 554323970, 'oforiwaamunufie@gamil.vom', NULL, 'CLASS6'),
('DR0163', 6, 'Opoku Duah Michael', '2012-12-26', 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 'Prince Opoku Akantoa', 242262275, 242262275, 'alicepimma4@gmail.com', NULL, 'CLASS6'),
('DR0164', 6, 'Fidaus Pomaa Ibrahim', '2012-03-22', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, 'Bertha Temea', 244047300, 244047300, 'berthatemea@gmail.com', NULL, 'CLASS6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `historical_school_themes`
--
ALTER TABLE `historical_school_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `historical_student_scores`
--
ALTER TABLE `historical_student_scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_themes`
--
ALTER TABLE `school_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sel_themes`
--
ALTER TABLE `sel_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `student_scores`
--
ALTER TABLE `student_scores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `educators`
--
ALTER TABLE `educators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `historical_school_themes`
--
ALTER TABLE `historical_school_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `historical_student_scores`
--
ALTER TABLE `historical_student_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `school_themes`
--
ALTER TABLE `school_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `sel_themes`
--
ALTER TABLE `sel_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `student_scores`
--
ALTER TABLE `student_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
