-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2023 at 08:53 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectrooms`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `commentText` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `totalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`uid`, `rid`, `sdate`, `edate`, `totalPrice`) VALUES
(20, 1, '2023-01-02', '2023-01-10', 4324);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `rate` double NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`ID`, `name`, `description`, `price`, `rate`, `picture`) VALUES
(1, 'Grate room in bahrain', 'this room is the good and big room you can find it in different and things that take you to other dimensions we can make your life easier than you expected.', 540.5, 0, '1672511155963b07eb3d402ecurology-6CJg-fOTYs4-unsplash-min.jpg'),
(2, 'Grate room in manama', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 505.6, 2.6666666666667, '167251144958363b07fd9bddeadavid-huynh-9ps71BtpdWk-unsplash-min.jpg'),
(3, 'Room name good one', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, n voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 300, 4.3333333333333, '167251155956663b080475a982sidekix-media-r_y2VBvEOIE-unsplash-min.jpg'),
(5, 'Nice room to have', 'this room is good and big room you can find it in different and things that take you to another dimensions we can make your life easier than you expected.', 240.4, 4, '167251421098563b08aa2df5f3visualsofdana-T5pL6ciEn-I-unsplash.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT 'defaultimg.jpg',
  `about` varchar(255) NOT NULL,
  `type` varchar(8) NOT NULL DEFAULT 'regular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `userName`, `name`, `email`, `password`, `picture`, `about`, `type`) VALUES
(5, 'abood2001', 'abdull aktham', 'email2001@gmail.com', '$2y$10$0SemuQtThBRM4.8zf86NDOvNVPyEyeNr3Ptc77FVPPxRhOnqTDove', '167260790410863b1f8a0e3fd9images.jpg', 'I love to play with my self', 'admin'),
(20, 'mohmadEsa', 'JasemEsa', 'Jasem-esa@yahoo.com', '$2y$10$Fvl5hdzdJT3PTXVHitVPkOlbgThze8eKpyg.Tgl8yakdNc4oLJ1ja', '167263077266963b251f455e31images1.jpg', 'nice person', 'regular');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD KEY `uid` (`uid`,`rid`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD KEY `uid` (`uid`,`rid`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`rid`) REFERENCES `room` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`rid`) REFERENCES `room` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
