-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 27, 2018 at 03:52 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `park`
--

-- --------------------------------------------------------

--
-- Table structure for table `movement`
--

CREATE TABLE `movement` (
  `id` int(11) NOT NULL,
  `car` varchar(128) NOT NULL,
  `type` enum('entry','exit') NOT NULL,
  `parking` int(11) NOT NULL,
  `camera` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Entry and exits of cars in parking';

--
-- Dumping data for table `movement`
--

INSERT INTO `movement` (`id`, `car`, `type`, `parking`, `camera`, `time`) VALUES
(4, 'RAC356B', 'entry', 1, 1, '2018-09-14 06:46:18'),
(5, 'RAC356B', 'entry', 1, 1, '2018-09-14 06:57:29'),
(6, 'RAC356B', 'entry', 1, 1, '2018-09-25 06:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE `parking` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `location` varchar(128) NOT NULL COMMENT 'Textual location of text',
  `lat` double NOT NULL,
  `lng` double NOT NULL COMMENT 'longitude location',
  `addedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `name`, `location`, `lat`, `lng`, `addedDate`) VALUES
(1, 'Telecom House Parking', '8 KG 7 Ave, Kigali', -1.954704, 30.103006, '2018-09-25 10:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `parking_roles`
--

CREATE TABLE `parking_roles` (
  `id` int(11) NOT NULL,
  `parking` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `role` varchar(16) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking_roles`
--

INSERT INTO `parking_roles` (`id`, `parking`, `user`, `role`, `createdDate`) VALUES
(1, 1, 1, 'admin', '2018-09-25 11:16:17');

-- --------------------------------------------------------

--
-- Table structure for table `templatetable`
--

CREATE TABLE `templatetable` (
  `id` int(11) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int(11) NOT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `archived` enum('no','yes','','') NOT NULL DEFAULT 'no',
  `archievedDate` timestamp NULL DEFAULT NULL,
  `archivedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='this helps in tables creation';

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `email` varchar(1024) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` int(11) NOT NULL,
  `updatedDate` timestamp NULL DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `archived` enum('no','yes','','') NOT NULL DEFAULT 'no',
  `archievedDate` timestamp NULL DEFAULT NULL,
  `archivedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='this helps in tables creation';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phoneNumber`, `password`, `createdDate`, `createdBy`, `updatedDate`, `updatedBy`, `archived`, `archievedDate`, `archivedBy`) VALUES
(1, 'Placide', 'placidelunis@gmail.com', '+250784762982', 'placide', '2018-09-25 11:15:02', 1, NULL, NULL, 'no', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movement`
--
ALTER TABLE `movement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking`
--
ALTER TABLE `parking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_roles`
--
ALTER TABLE `parking_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role-parking` (`parking`),
  ADD KEY `role-user` (`user`);

--
-- Indexes for table `templatetable`
--
ALTER TABLE `templatetable`
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
-- AUTO_INCREMENT for table `movement`
--
ALTER TABLE `movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `parking`
--
ALTER TABLE `parking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parking_roles`
--
ALTER TABLE `parking_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `templatetable`
--
ALTER TABLE `templatetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parking_roles`
--
ALTER TABLE `parking_roles`
  ADD CONSTRAINT `role-parking` FOREIGN KEY (`parking`) REFERENCES `parking` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `role-user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
