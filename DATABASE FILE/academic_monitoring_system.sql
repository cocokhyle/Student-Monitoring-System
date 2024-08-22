-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2023 at 02:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academic_monitoring_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(1, 'Admin', '', 'admin@mail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblattendance`
--

CREATE TABLE `tblattendance` (
  `Id` int(10) NOT NULL,
  `admissionNo` varchar(255) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `sessionTermId` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `dateTimeTaken` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblattendance`
--

INSERT INTO `tblattendance` (`Id`, `admissionNo`, `classId`, `classArmId`, `sessionTermId`, `status`, `dateTimeTaken`) VALUES
(206, '3', '11', '7', '4', '0', '2023-03-29'),
(207, '2', '11', '17', '10', '0', '2023-07-23'),
(208, '2', '11', '17', '10', '0', '2023-07-24'),
(209, '2', '11', '17', '10', '0', '2023-09-03'),
(210, '2', '11', '17', '10', '0', '2023-09-11'),
(211, '2', '11', '17', '10', '0', '2023-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `tblclass`
--

CREATE TABLE `tblclass` (
  `Id` int(10) NOT NULL,
  `className` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclass`
--

INSERT INTO `tblclass` (`Id`, `className`) VALUES
(6, 'Grade 1'),
(7, 'Grade 2'),
(8, 'Grade 3'),
(9, 'Grade 4'),
(10, 'Grade 5'),
(11, 'Grade 6');

-- --------------------------------------------------------

--
-- Table structure for table `tblclassarms`
--

CREATE TABLE `tblclassarms` (
  `Id` int(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmName` varchar(255) NOT NULL,
  `isAssigned` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclassarms`
--

INSERT INTO `tblclassarms` (`Id`, `classId`, `classArmName`, `isAssigned`) VALUES
(23, '11', 'D', '1'),
(22, '11', 'C', '1'),
(21, '10', 'D', '1'),
(20, '10', 'C', '1'),
(19, '10', 'B', '1'),
(18, '10', 'A', '1'),
(17, '11', 'B', '1'),
(16, '11', 'A', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblclassteacher`
--

CREATE TABLE `tblclassteacher` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phoneNo` varchar(50) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblclassteacher`
--

INSERT INTO `tblclassteacher` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`, `phoneNo`, `classId`, `classArmId`, `dateCreated`) VALUES
(15, 'Aubrey', 'Panganiban', 'aub@email.com', 'pass123', '5', '10', '20', '2023-07-12'),
(14, 'John', 'Doe', 'john@email.com', 'pass123', '09303288267', '10', '19', '2023-07-12'),
(13, 'Nicole', 'Balajadia', 'nic@email.com', 'pass123', '09303288266', '10', '18', '2023-07-12'),
(11, 'jeff', 'bual', 'jeffb@email.com', 'pass123', '09303288265', '11', '16', '2023-07-07'),
(12, 'khyle', 'yanes', 'khy@email.com', 'pass123', '09303288261', '11', '17', '2023-07-07'),
(16, 'Zhe', 'Reyes', 'zhe@email.com', 'pass123', '6', '10', '21', '2023-07-12'),
(17, 'Jenuel', 'Fajardo', 'jen@email.com', 'pass123', '7', '11', '22', '2023-07-12'),
(18, 'Pat', 'Landrito', 'pat@email.com', 'pass123', '8', '11', '23', '2023-07-12');

-- --------------------------------------------------------

--
-- Table structure for table `tblgrades`
--

CREATE TABLE `tblgrades` (
  `id` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `grade` float NOT NULL,
  `termId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `isGraded` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblgrades`
--

INSERT INTO `tblgrades` (`id`, `subjectId`, `studentId`, `grade`, `termId`, `sessionId`, `isGraded`) VALUES
(27, 16, 2, 90, 7, 10, 1),
(28, 16, 2, 89, 8, 11, 1),
(29, 16, 2, 59, 9, 12, 1),
(30, 15, 2, 70, 7, 10, 1),
(31, 17, 2, 95, 7, 10, 1),
(32, 18, 2, 74, 7, 10, 1),
(33, 19, 2, 95, 7, 10, 1),
(34, 20, 2, 89, 7, 10, 1),
(35, 21, 2, 70, 7, 10, 1),
(36, 22, 2, 70, 7, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblperformance`
--

CREATE TABLE `tblperformance` (
  `id` int(11) NOT NULL,
  `subjectName` varchar(255) NOT NULL,
  `taskName` varchar(255) NOT NULL,
  `studentId` int(11) NOT NULL,
  `grade` float NOT NULL,
  `termId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `isGraded` int(11) NOT NULL,
  `isMarked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblperformance`
--

INSERT INTO `tblperformance` (`id`, `subjectName`, `taskName`, `studentId`, `grade`, `termId`, `sessionId`, `isGraded`, `isMarked`) VALUES
(2, 'ENG06', 'ass 1', 2, 90, 7, 10, 1, 1),
(3, 'MATH06', 'task 1', 2, 91, 7, 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblquarterly`
--

CREATE TABLE `tblquarterly` (
  `id` int(11) NOT NULL,
  `subjectName` varchar(255) NOT NULL,
  `asstName` varchar(255) NOT NULL,
  `studentId` int(11) NOT NULL,
  `grade` float NOT NULL,
  `termId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `isGraded` int(11) NOT NULL,
  `isMarked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblquarterly`
--

INSERT INTO `tblquarterly` (`id`, `subjectName`, `asstName`, `studentId`, `grade`, `termId`, `sessionId`, `isGraded`, `isMarked`) VALUES
(2, 'MATH06', 'ass 1', 2, 93, 7, 10, 1, 1),
(5, 'MATH06', 'ass 2', 2, 100, 7, 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblsessionterm`
--

CREATE TABLE `tblsessionterm` (
  `Id` int(10) NOT NULL,
  `sessionName` varchar(50) NOT NULL,
  `termId` varchar(50) NOT NULL,
  `isActive` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblsessionterm`
--

INSERT INTO `tblsessionterm` (`Id`, `sessionName`, `termId`, `isActive`, `dateCreated`) VALUES
(11, '2023-24', '8', '0', '2023-07-12'),
(10, '2023-24', '7', '1', '2023-07-09'),
(12, '2023-24', '9', '0', '2023-09-09'),
(13, '2023-24', '10', '0', '2023-09-09');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `otherName` varchar(255) NOT NULL,
  `admissionNumber` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `dateCreated` varchar(50) NOT NULL,
  `session` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`Id`, `firstName`, `lastName`, `otherName`, `admissionNumber`, `password`, `classId`, `classArmId`, `dateCreated`, `session`) VALUES
(25, 'Doe', 'Dan', '', '3', '12345', '10', '18', '2023-07-12', '11'),
(24, 'ada', 'aa', '', '2', '12345', '11', '17', '2023-07-12', '11'),
(23, 'asd', 'ss', '', '1', '12345', '11', '16', '2023-07-12', '11'),
(26, 'Nic', 'Nac', '', '4', '12345', '10', '19', '2023-07-12', '11');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE `tblsubjects` (
  `Id` int(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `subjectName` varchar(255) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `isAssigned` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsubjects`
--

INSERT INTO `tblsubjects` (`Id`, `classId`, `subjectName`, `teacherId`, `isAssigned`) VALUES
(16, '11', 'MATH06', 12, '1'),
(15, '11', 'ENG06', 18, '1'),
(17, '11', 'AP06', 18, '1'),
(18, '11', 'SCI06', 15, '1'),
(19, '11', 'FIL06', 15, '1'),
(20, '11', 'TLE06', 16, '1'),
(21, '11', 'ESP06', 16, '1'),
(22, '11', 'MAPEH06', 12, '1'),
(23, '10', 'MATH05', 13, '1'),
(24, '10', 'ENG05', 13, '1'),
(25, '10', 'AP05', 11, '1'),
(26, '10', 'SCI05', 11, '1'),
(27, '10', 'FIL05', 14, '1'),
(28, '10', 'TLE05', 14, '1'),
(29, '10', 'ESP05', 17, '1'),
(30, '10', 'MAPEH05', 17, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbltasks`
--

CREATE TABLE `tbltasks` (
  `taskId` int(11) NOT NULL,
  `taskName` int(11) NOT NULL,
  `taskType` int(11) NOT NULL,
  `subjectName` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblterm`
--

CREATE TABLE `tblterm` (
  `Id` int(10) NOT NULL,
  `termName` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblterm`
--

INSERT INTO `tblterm` (`Id`, `termName`) VALUES
(7, 'First Grading'),
(8, 'Second Grading'),
(9, 'Third Grading'),
(10, 'Fourth Grading');

-- --------------------------------------------------------

--
-- Table structure for table `tblwrittenworks`
--

CREATE TABLE `tblwrittenworks` (
  `id` int(11) NOT NULL,
  `subjectName` varchar(255) NOT NULL,
  `activityName` varchar(255) NOT NULL,
  `studentId` int(11) NOT NULL,
  `grade` float NOT NULL,
  `termId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `isGraded` int(11) NOT NULL,
  `isMarked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblwrittenworks`
--

INSERT INTO `tblwrittenworks` (`id`, `subjectName`, `activityName`, `studentId`, `grade`, `termId`, `sessionId`, `isGraded`, `isMarked`) VALUES
(2, 'MAPEH06', 'act 1', 2, 91, 7, 10, 1, 1),
(3, 'MAPEH06', 'act 2', 2, 59, 7, 10, 1, 1),
(4, 'MAPEH06', 'act 3', 2, 69, 7, 10, 1, 1),
(5, 'MATH06', 'act 1', 2, 80, 7, 10, 1, 1),
(6, 'MATH06', 'act 2', 2, 70, 7, 10, 1, 1),
(7, 'MATH06', 'act 3', 2, 89, 7, 10, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblattendance`
--
ALTER TABLE `tblattendance`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclass`
--
ALTER TABLE `tblclass`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclassarms`
--
ALTER TABLE `tblclassarms`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblclassteacher`
--
ALTER TABLE `tblclassteacher`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblgrades`
--
ALTER TABLE `tblgrades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblperformance`
--
ALTER TABLE `tblperformance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblquarterly`
--
ALTER TABLE `tblquarterly`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbltasks`
--
ALTER TABLE `tbltasks`
  ADD PRIMARY KEY (`taskId`);

--
-- Indexes for table `tblterm`
--
ALTER TABLE `tblterm`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblwrittenworks`
--
ALTER TABLE `tblwrittenworks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblattendance`
--
ALTER TABLE `tblattendance`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `tblclass`
--
ALTER TABLE `tblclass`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblclassarms`
--
ALTER TABLE `tblclassarms`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblclassteacher`
--
ALTER TABLE `tblclassteacher`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblgrades`
--
ALTER TABLE `tblgrades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tblperformance`
--
ALTER TABLE `tblperformance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblquarterly`
--
ALTER TABLE `tblquarterly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblsessionterm`
--
ALTER TABLE `tblsessionterm`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tblterm`
--
ALTER TABLE `tblterm`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblwrittenworks`
--
ALTER TABLE `tblwrittenworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
