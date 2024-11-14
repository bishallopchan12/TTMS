-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 07:19 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '331ebd582d369b535917a1fef122f1b3', '2024-09-26 04:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `BookingId` int(11) NOT NULL,
  `PackageId` int(11) DEFAULT NULL,
  `FirstName` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Phone` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `NameOnCard` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `CardNumber` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ExpMonth` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ExpYear` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `CVV` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Country` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `StreetLine1` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `StreetLine2` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `City` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `State1` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Pincode` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Additional_Information` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `CancelledBy` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `BookingTime` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BookingId`, `PackageId`, `FirstName`, `Email`, `Phone`, `NameOnCard`, `CardNumber`, `ExpMonth`, `ExpYear`, `CVV`, `Country`, `StreetLine1`, `StreetLine2`, `City`, `State1`, `Pincode`, `Additional_Information`, `status`, `CancelledBy`, `BookingTime`) VALUES
(37, 0, 'Samba', 'bshallama16@gmail.com', '98232323232', 'asaasasasasasas', '1212121212121212', '21', '2025', '', 'Satdobato', '212', '2121', '1212', '1212', '21212', '2121', 0, NULL, '2024-09-26 10:42:47'),
(38, 1, 'Samba', 'bshallama16@gmail.com', '98232323232', 'asaasasasasasas', '1212121212121212', '21', '2024', '', 'Satdobato', '212', '2121', '1212', 'bagmati', '21212', '2121', 1, NULL, '2024-09-27 11:55:56'),
(39, 3, 'Samba', 'bshallama16@gmail.com', '98232323232', 'asaasasasasasas', '1212324323232323', '21', '2024', '', 'Satdobato', '212', '2121', '1212', 'bagmati', '21212', '32323', 0, NULL, '2024-09-27 12:11:17'),
(40, 6, 'Samba', 'bshallama16@gmail.com', '98232323232', 'sasas', '2323354345345345', '31', '2025', '', '212', '212', '2121', '1212', '211', '21212', '2132', 0, NULL, '2024-09-27 12:15:54'),
(41, 1, 'Bishal lama', 'bipin@gmail.com', '21212122121', 'Bishal Lama', '3323232323232323', '12', '2025', '', 'Satdobato', '212', '2121', '1212', '1212', '21212', 'sdsd', 0, NULL, '2024-09-27 15:31:49'),
(42, 1, 'Samba Dorje Lama', 'samba2081@gmail.com', '98232323232', 'Samba Dorje Lama', '3232323232323232', '32', '2026', '', 'sasasas', '212', '2121', '1212', 'asa', '21212', 'sasas', 0, NULL, '2024-10-21 09:32:14'),
(43, 1, 'Samba', 'samba2081@gmail.com', '98232323232', 'Samba Dorje Lama', '1323131231231231', '12', '2025', '', 'Satdobato', '212', '2121', '1212', '323', '21212', '313123', 0, NULL, '2024-10-30 12:27:42');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `feedbk` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `feedbk`, `created_at`) VALUES
(1, 'bipn karki', 'bshallama16@gmail.com', 'sasas', '2024-09-26 14:16:37'),
(2, 'Hiking', 'dasd@gmail.com', 'adada', '2024-09-27 16:00:41');

-- --------------------------------------------------------

--
-- Table structure for table `near_me`
--

CREATE TABLE `near_me` (
  `PlaceId` int(11) NOT NULL,
  `PlaceName` varchar(200) NOT NULL,
  `Activities` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `placelatlong` varchar(100) DEFAULT NULL,
  `ImageSrc` varchar(255) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `near_me`
--

INSERT INTO `near_me` (`PlaceId`, `PlaceName`, `Activities`, `Description`, `placelatlong`, `ImageSrc`, `CreationDate`) VALUES
(14, ' Basantapur', 'Sightseeing, Historical Exploration, Photography', 'Basantapur Durbar Square is a UNESCO World Heritage site in Kathmandu, known for its historical palaces, temples, and cultural significance.', '27.7040091756425,85.30779451131822', 'uploads/Basantapur.jpg', '2024-09-26 12:14:04'),
(15, 'Begnas Lake', 'Boating, Fishing, Relaxation', ' Begnas Lake is a freshwater lake near Pokhara, providing serene views and opportunities for boating and relaxation.', '28.153892480325993,83.97674560546876', 'uploads/Begnas Lake.jpg', '2024-09-26 12:14:59'),
(16, 'Bhaktapur', 'Heritage Walking, Pottery, Temple Visits', 'Bhaktapur is an ancient city renowned for its well-preserved medieval art, temples, and craftsmanship.', '27.669817747277378,85.4267692565918', 'uploads/bhaktapur.jpg', '2024-09-26 12:16:01'),
(17, 'Boudhanath', 'Pilgrimage, Meditation, Cultural Exploration', 'Boudhanath Stupa is one of the largest stupas in Nepal and a significant site for Tibetan Buddhism.', '27.72146541039002,85.36204218864442', 'uploads/Boudhanath.jpg', '2024-09-26 12:16:29'),
(18, 'Chitwan National Park', 'Wildlife Safari, Bird Watching, Canoeing', 'Chitwan National Park is a UNESCO World Heritage site, famous for its Bengal tigers, rhinos, and diverse wildlife.', '27.675290686695963,84.42701339721681', 'uploads/Chitwan National Park.jpg', '2024-09-26 12:17:22'),
(19, 'Lumbini Museum', ' Historical Exploration, Pilgrimage', ' Lumbini Museum is dedicated to the life of Lord Buddha, showcasing artifacts and historical details from his life.', '27.52509420065489,83.04428100585939', 'uploads/Lumbini Museum.jpg', '2024-09-26 12:18:24'),
(20, 'Lumbini', 'Pilgrimage, Temple Visits', 'Lumbini is the birthplace of Lord Buddha, making it one of the most significant pilgrimage sites for Buddhists.', '27.54906079793732,83.05419445037843', 'uploads/Lumbini.jpg', '2024-09-26 12:19:08'),
(21, 'Nagarkot', 'Trekking, Sunrise Viewing, Relaxation', 'Nagarkot is famous for its panoramic sunrise views of the Himalayas, including Mount Everest.', '27.716632920713657,85.52221298217775', 'uploads/Nagarkot.jpg', '2024-09-26 12:20:01'),
(22, 'Paragliding (Pokhara)', ' Paragliding, Adventure Sports', 'Pokhara is one of the world’s top paragliding destinations, offering stunning aerial views of the lakes and mountains.', '28.201443961600766,83.9842987060547', 'uploads/Paragliding.jpg', '2024-09-26 12:21:15'),
(23, 'Pashupatinath', 'Pilgrimage, Temple Visits', 'Pashupatinath Temple is a sacred Hindu temple on the banks of the Bagmati River, dedicated to Lord Shiva.', '27.70855860578817,85.34818589687349', 'uploads/Pashupatinath.jpg', '2024-09-26 12:22:31'),
(24, 'Patan', 'Heritage Walking, Museum Visits', 'Patan, also known as Lalitpur, is a historic city famous for its ancient art, temples, and craftsmanship.', '27.67334503647425,85.32443895936014', 'uploads/Patan.jpg', '2024-09-26 12:26:01'),
(25, 'Phewa Lake', 'Boating, Paragliding, Fishing', 'Phewa Lake is a scenic freshwater lake in Pokhara, offering picturesque views of Mount Machhapuchhre.', '28.178332874993796,83.99459838867189', 'uploads/Phewa Lake.jpg', '2024-09-26 12:26:42'),
(26, 'Sarangkot ', 'Trekking, Sunrise Viewing, Paragliding', 'Sarangkot is known for its panoramic sunrise views of the Annapurna range and the Pokhara valley below.', '28.192971737460347,83.99665832519533', 'uploads/Sarangkot.jpg', '2024-09-26 12:27:12'),
(27, 'Swayambhunath (Monkey Temple)', 'Pilgrimage, Cultural Exploration', ' Swayambhunath, also known as the Monkey Temple, is a significant Buddhist stupa with panoramic views of Kathmandu.', '27.715690854115657,85.28955817222595', 'uploads/Swoyambhunath.jpg', '2024-09-26 12:27:49'),
(28, 'Taudaha Lake', ' Bird Watching, Fishing, Relaxation', 'Taudaha Lake is a peaceful and small lake located in the outskirts of Kathmandu, popular for birdwatching and its mythological importance.', '27.64863246537657,85.28233766555788', 'uploads/Taudaha.jpg', '2024-09-26 13:40:47'),
(29, 'White Gumba (Seto Gumba)', 'Pilgrimage, Meditation, Sightseeing', 'White Gumba, also known as Seto Gumba, is a Buddhist monastery in the outskirts of Kathmandu known for its architecture and peaceful environment.', '28.204122122635894,83.99189472198488', 'uploads/White Gumba.jpg', '2024-09-26 13:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `packageoffer`
--

CREATE TABLE `packageoffer` (
  `OfferId` int(11) NOT NULL,
  `OfferName` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `OfferLocation` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `OfferDetails` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ActualPrice` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `OfferPrice` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PercentageOff` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `OfferImage` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packageoffer`
--

INSERT INTO `packageoffer` (`OfferId`, `OfferName`, `OfferLocation`, `OfferDetails`, `ActualPrice`, `OfferPrice`, `PercentageOff`, `OfferImage`, `Creationdate`, `UpdationDate`) VALUES
(13, 'Kathmandu Valley', 'Kathmandu', 'Kathmandu Valley is the cultural heart of Nepal. The valley includes the cities of Kathmandu, Bhaktapur, and Patan, which are known for their ancient temples, stupas, and vibrant festivals. Visitors can explore UNESCO World Heritage Sites like Pashupatinath Temple, Boudhanath Stupa, Swayambhunath (Monkey Temple), and the Durbar Squares. The city offers a unique blend of tradition, spirituality, and modernity.', '5000', '4500', '10%', 'kathmanduvalley.jpg', '2024-09-26 01:15:00', NULL),
(14, 'Pokhara', 'Gandaki', 'Pokhara, located in the Gandaki Province, is famous for its stunning views of the Annapurna mountain range and the serene Phewa Lake. It is a base for trekkers heading to the Annapurna Circuit. Visitors can enjoy paragliding, boating, and visiting attractions like Davis Falls, the World Peace Pagoda, and Gupteshwor Cave. The city is known for its laid-back atmosphere and breathtaking natural beauty.', '7000', '6300', '10%', 'Pokhara.jpg', '2024-09-17 01:25:00', NULL),
(15, 'Chitwan National Park', 'Chitwan', 'Chitwan National Park is one of Nepal’s most popular destinations for wildlife enthusiasts. It offers jungle safaris, where visitors can spot Bengal tigers, one-horned rhinoceros, elephants, and various bird species. The park also provides opportunities for canoeing, birdwatching, and cultural experiences with the Tharu community. It is a perfect destination for nature and wildlife lovers.', '6000', '5400', '10%', 'ChitwanNationalPark.jpg', '2023-09-26 01:30:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbldestination`
--

CREATE TABLE `tbldestination` (
  `DestinationId` int(11) NOT NULL,
  `DestinationName` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `DestinationLocation` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `DestinationDetails` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `DestinationImage` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbldestination`
--

INSERT INTO `tbldestination` (`DestinationId`, `DestinationName`, `DestinationLocation`, `DestinationDetails`, `DestinationImage`, `Creationdate`, `UpdationDate`) VALUES
(24, 'Bandipur', 'Nepal', 'Bandipur is a hilltop settlement and a municipality in Tanahun District. It is known for its preserved, old-time cultural atmosphere and offers breathtaking views of the Himalayas.', '66f53df918ab7.jpg', '2024-09-26 10:56:57', NULL),
(25, 'Bhaktapur', 'Nepal', 'Bhaktapur, also known as Bhadgaon, is an ancient city near Kathmandu, renowned for its rich culture, temples, artwork, and pottery. It is one of the UNESCO World Heritage Sites in the Kathmandu Valley.', '66f53e0cc9b0b.jpg', '2024-09-26 10:57:16', NULL),
(26, 'Chitwan National Park', ' Nepal', 'Chitwan National Park is a UNESCO World Heritage site famous for its diverse wildlife, including Bengal tigers, one-horned rhinos, and a wide variety of birds. It\'s one of the most popular ecotourism destinations in Nepal.', '66f53e1f1b248.jpg', '2024-09-26 10:57:35', NULL),
(27, 'Kathmandu Valley', 'Nepal', 'The Kathmandu Valley is a cultural and historical region filled with temples, palaces, and religious sites. It contains several UNESCO World Heritage Sites, including the famous Swayambhunath (Monkey Temple) and Pashupatinath Temple.', '66f53e5419767.jpg', '2024-09-26 10:58:28', NULL),
(28, 'Lumbini', 'Nepal', 'Lumbini is the birthplace of Siddhartha Gautama, who later became the Buddha. It is a sacred pilgrimage site for Buddhists, and the area is home to many monasteries and stupas. It\'s also a UNESCO World Heritage Site.', '66f53e66a25d6.jpg', '2024-09-26 10:58:46', NULL),
(29, 'Nagarkot', 'Nepal', 'Nagarkot is a popular hill station known for its stunning sunrise views of the Himalayas, including Mount Everest. It is also a great spot for short treks and enjoying nature.', '66f53e781366b.jpg', '2024-09-26 10:59:04', NULL),
(30, 'Pokhara', 'Nepal', 'Pokhara is a city in central Nepal known for its beautiful lakes, stunning mountain views, and adventure sports like paragliding and trekking. It\'s a gateway to the Annapurna Circuit and a favorite among travelers for relaxation and sightseeing.', '66f53e879d647.jpg', '2024-09-26 10:59:19', NULL),
(31, 'Sagarmatha National Park', 'Nepal', 'Sagarmatha National Park is home to Mount Everest and several other prominent peaks of the Himalayas. It\'s a UNESCO World Heritage Site and offers visitors a chance to experience both the natural beauty and rich Sherpa culture of the region.', '66f53ec18b4ee.jpg', '2024-09-26 11:00:17', NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `RegDate`, `UpdationDate`) VALUES
(12, 'Bishal Lama', 'bshallama16@gmail.com', 'Bishal@123', 'user', 'active', '2024-09-26 10:36:48', NULL),
(13, 'beepin Karki', 'bipin@gmail.com', 'bipin@123', 'user', 'active', '2024-09-27 15:26:30', NULL),
(14, 'Samba Dorje Lama', 'samba2081@gmail.com', 'Samba@123', 'user', 'active', '2024-10-21 09:31:05', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingId`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `near_me`
--
ALTER TABLE `near_me`
  ADD PRIMARY KEY (`PlaceId`);

--
-- Indexes for table `packageoffer`
--
ALTER TABLE `packageoffer`
  ADD PRIMARY KEY (`OfferId`);

--
-- Indexes for table `tbldestination`
--
ALTER TABLE `tbldestination`
  ADD PRIMARY KEY (`DestinationId`);

--
-- Indexes for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  ADD PRIMARY KEY (`PackageId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `near_me`
--
ALTER TABLE `near_me`
  MODIFY `PlaceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `packageoffer`
--
ALTER TABLE `packageoffer`
  MODIFY `OfferId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbldestination`
--
ALTER TABLE `tbldestination`
  MODIFY `DestinationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
