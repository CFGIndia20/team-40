-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2020 at 08:32 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nudge`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_id` int(10) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(10) NOT NULL,
  `Contact No` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_id`, `Name`, `Email`, `Password`, `Contact No`) VALUES
(1, 'Sai', 'spreddy0002@gmail.com', '0', 9989513251),
(2, 'Mrinal', 'mrinal.1si17cs062@gmail.com', '0', 8296707225),
(3, 'Thomas ', 'Thomas@gmail.com', 'Thomas', 9875461527),
(4, 'Miranda', 'Miranda@gmail.com', 'Miranda', 8759468254),
(5, 'Alvaro', 'Alvaro@gmail.com', 'Alvaro', 8759486257);

-- --------------------------------------------------------

--
-- Table structure for table `assesment`
--

CREATE TABLE `assesment` (
  `Teacher_id` int(11) NOT NULL,
  `Student_id` int(11) NOT NULL,
  `Batch_id` int(11) NOT NULL,
  `Week_id` int(11) NOT NULL,
  `Parameter 1` int(11) NOT NULL,
  `Parameter 2` int(11) NOT NULL,
  `Parameter 3` int(11) NOT NULL,
  `Parameter 4` int(11) NOT NULL,
  `Parameter 5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `Batch_id` int(11) NOT NULL,
  `Time` time NOT NULL,
  `Start_Date` date NOT NULL,
  `End_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`Batch_id`, `Time`, `Start_Date`, `End_Date`) VALUES
(1, '07:00:00', '2020-07-30', '2020-09-16'),
(2, '07:00:00', '2020-07-30', '2020-10-30'),
(3, '10:00:00', '2020-07-10', '2020-07-22'),
(5, '03:00:00', '2020-07-25', '2020-11-25'),
(6, '05:00:00', '2020-07-26', '2020-10-26'),
(8, '05:00:00', '2020-07-28', '2020-07-30');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_id` int(10) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Contact no` bigint(10) NOT NULL,
  `Adhaar No` bigint(12) NOT NULL,
  `Age` int(5) NOT NULL,
  `Marksheet` varchar(50) NOT NULL,
  `Attendance` int(11) DEFAULT NULL,
  `Quiz score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_id`, `Name`, `Email`, `Contact no`, `Adhaar No`, `Age`, `Marksheet`, `Attendance`, `Quiz score`) VALUES
(1, 'Monil', 'monils1999@gmail.com', 9987677296, 123456789123, 21, '', NULL, NULL),
(2, 'Priyanka', 'awatramani1@gmail.com', 9082625021, 3216549887321, 20, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studentbatch`
--

CREATE TABLE `studentbatch` (
  `Student_id` int(10) NOT NULL,
  `Batch_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studentbatch`
--

INSERT INTO `studentbatch` (`Student_id`, `Batch_id`) VALUES
(2, 5),
(1, 9),
(3, 5),
(4, 7),
(5, 2),
(6, 2),
(7, 8),
(8, 5),
(9, 5),
(45, 5),
(41, 5),
(12, 5),
(13, 5),
(15, 5),
(16, 5),
(14, 5),
(10, 5),
(11, 5),
(20, 5),
(21, 5);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `Teacher_id` int(10) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Contact No` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`Teacher_id`, `Name`, `Email`, `Contact No`) VALUES
(1, 'Spandana', 'kotturspandana@gmail.com', 9591257017),
(2, 'Roshni', 'roshni200085@gmail.com', 9067708020);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `Teacher_id` int(10) NOT NULL,
  `Batch_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`Teacher_id`, `Batch_id`) VALUES
(1, 5),
(2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `is_remember` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`Batch_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`Teacher_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `Batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Student_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `Teacher_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
