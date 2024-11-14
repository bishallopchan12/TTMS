-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 07:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbltourpackages`
--

CREATE TABLE `tbltourpackages` (
  `PackageId` int(11) NOT NULL,
  `PackageName` varchar(200) DEFAULT NULL,
  `PackageType` varchar(150) DEFAULT NULL,
  `PackageLocation` varchar(100) DEFAULT NULL,
  `PackagePrice` int(11) DEFAULT NULL,
  `PackageFetures` varchar(255) DEFAULT NULL,
  `PackageDetails` mediumtext DEFAULT NULL,
  `PackageImage` varchar(100) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbltourpackages`
--

INSERT INTO `tbltourpackages` (`PackageId`, `PackageName`, `PackageType`, `PackageLocation`, `PackagePrice`, `PackageFetures`, `PackageDetails`, `PackageImage`, `Creationdate`, `UpdationDate`, `views`) VALUES
(1, 'Kathmandu Cultural Tour', 'Cultural', 'Kathmandu', 12000, 'Sightseeing, Heritage, Temples', 'Explore the rich cultural heritage of Kathmandu, including visits to UNESCO World Heritage sites like Basantapur Durbar Square, Pashupatinath, and Swayambhunath (Monkey Temple).', 'kathmandu_tour.jpg', '2024-09-26 14:00:48', '2024-10-30 12:27:17', 18),
(2, 'Pokhara Adventure Package', 'Adventure', 'Pokhara', 15000, 'Boating, Paragliding, Trekking', 'A thrilling adventure in Pokhara, where you can enjoy paragliding, boating in Phewa Lake, and hiking to Sarangkot for a breathtaking sunrise view.', 'pokhara_adventure.jpg', '2024-09-26 14:00:48', '2024-09-27 12:06:55', 6),
(3, 'Chitwan Jungle Safari', 'Wildlife', 'Chitwan National Park', 18000, 'Wildlife Safari, Bird Watching, Canoeing', 'Experience the wildlife of Nepal with a jungle safari in Chitwan National Park. Witness the endangered one-horned rhinoceros, Bengal tigers, and other diverse species.', 'chitwan_safari.jpg', '2024-09-26 14:00:48', '2024-09-28 12:46:04', 32),
(4, 'Lumbini Pilgrimage Tour', 'Pilgrimage', 'Lumbini', 10000, 'Buddhist Pilgrimage, Meditation, Museum Visit', 'Visit the birthplace of Lord Buddha in Lumbini, a UNESCO World Heritage Site, and explore the Lumbini Museum, monasteries, and meditation centers.', 'lumbini_tour.jpg', '2024-09-26 14:00:48', '2024-09-27 11:54:29', 2),
(5, 'Nagarkot Hill Station Getaway', 'Leisure', 'Nagarkot', 8000, 'Sunrise View, Relaxation, Short Hiking', 'A perfect getaway to Nagarkot to enjoy the stunning sunrise view of the Himalayas, including Mount Everest, and short hikes around the tranquil hill station.', 'nagarkot_getaway.jpg', '2024-09-26 14:00:48', NULL, 0),
(6, 'Boudhanath Stupa Meditation Package', 'Spiritual', 'Boudhanath', 9000, 'Meditation, Cultural Exploration', 'Immerse yourself in spiritual peace with a meditation retreat at Boudhanath Stupa, one of the largest stupas in Nepal, surrounded by Tibetan monasteries.', 'boudhanath_meditation.jpg', '2024-09-26 14:00:48', '2024-09-27 12:15:27', 3),
(7, 'Begnas Lake Retreat', 'Leisure', 'Begnas Lake', 11000, 'Boating, Fishing, Relaxation', 'A relaxing retreat by the serene Begnas Lake, offering boating, fishing, and peaceful surroundings far from the hustle and bustle of city life.', 'begnas_retreat.jpg', '2024-09-26 14:00:48', '2024-09-28 12:47:11', 1),
(8, 'Patan Heritage Walk', 'Cultural', 'Patan', 7000, 'Heritage Walk, Temples, Museums', 'Discover the ancient city of Patan, known for its rich history, art, and architecture. Visit Patan Durbar Square, the Golden Temple, and local museums.', 'patan_walk.jpg', '2024-09-26 14:00:48', NULL, 0),
(9, 'Sarangkot Paragliding Experience', 'Adventure', 'Sarangkot', 13000, 'Paragliding, Sunrise View, Trekking', 'Soar high above Pokhara valley with a paragliding experience from Sarangkot. Also, enjoy trekking and a beautiful sunrise over the Himalayas.', 'sarangkot_paragliding.jpg', '2024-09-26 14:00:48', NULL, 0),
(10, 'Swoyambhunath Cultural Day Trip', 'Cultural', 'Swoyambhunath', 6000, 'Heritage, Pilgrimage, City View', 'A day trip to Swoyambhunath (Monkey Temple), offering panoramic views of Kathmandu city and a deep dive into the Buddhist culture and history.', 'swoyambhunath_daytrip.jpg', '2024-09-26 14:00:48', '2024-09-27 11:03:59', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  ADD PRIMARY KEY (`PackageId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
