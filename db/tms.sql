-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2023 at 10:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
(1, 'admin', '202cb962ac59075b964b07152d234b70', '2020-05-11 05:48:49');

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
(31, 18, 'Anjali', 'anjalis3455@gmail.com', '6307134789', 'Anjali Singh', '2154795623', '87', '8954', '', 'United states', 'PATNA', 'apa', 'lambhua', 'patna', '212356', 'Helooooo', 2, 'a', '2023-05-29 10:51:28'),


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
(17, 'Chitwan National Park', 'Chitwan', 'Chitwan National Park is Nepal’s first national park and a UNESCO World Heritage Site. Famous for its wildlife, visitors can enjoy jungle safaris and spot endangered species like the Bengal tiger, one-horned rhinoceros, and various bird species. The park offers guided tours, elephant safaris, canoeing, and jungle walks, making it a paradise for nature lovers and adventurers alike. Located in the subtropical lowlands of Nepal, Chitwan provides a serene getaway into the heart of the wilderness.', '7500', '6800', '9%', 'nepal_chitwan.jpg', '2023-05-20 11:00:00', NULL),
(18, 'Nagarkot - Scenic Mountain Village', 'Nagarkot', 'Nagarkot is a small village located about 32 km from Kathmandu, famous for its panoramic views of the Himalayas, including Mount Everest on a clear day. It is a popular destination for those looking to witness breathtaking sunrises and sunsets over the Himalayas. Surrounded by terraced fields and pine forests, Nagarkot offers a tranquil retreat with a wide range of hiking trails and opportunities for mountain biking. It is a perfect destination for those seeking nature, serenity, and stunning mountain vistas.', '6800', '6100', '10%', 'nepal_nagarkot.jpg', '2023-05-20 11:30:00', NULL),
(19, 'Bhaktapur - City of Devotees', 'Bhaktapur', 'Bhaktapur is an ancient city known for its well-preserved medieval architecture, rich culture, and traditional craftsmanship. The city is a UNESCO World Heritage Site, and its Durbar Square is filled with intricate temples, statues, and courtyards. Bhaktapur is famous for its pottery, wood carvings, and the annual Bisket Jatra festival. A visit to Bhaktapur is like stepping back in time, with its narrow streets and local artisans showcasing their skills. It is a must-visit for history buffs and cultural enthusiasts.', '7200', '6700', '7%', 'nepal_bhaktapur.jpg', '2023-05-20 12:00:00', NULL),
(20, 'Bandipur - Hilltop Town', 'Bandipur', 'Bandipur is a charming hilltop town in Nepal that offers spectacular views of the Himalayas and is known for its well-preserved Newari culture. The town has a laid-back atmosphere, with its cobblestone streets and traditional houses adding to its old-world charm. Bandipur is ideal for relaxing and taking in the stunning mountain scenery. Visitors can also explore nearby caves, temples, and hiking trails. It is a hidden gem, offering a peaceful escape from the bustling cities of Nepal.', '6000', '5500', '8%', 'nepal_bandipur.jpg', '2023-05-20 12:30:00', NULL),
(21, 'Sagarmatha National Park', 'Everest Region', 'Sagarmatha National Park is home to Mount Everest, the world’s highest peak, and is a UNESCO World Heritage Site. The park is famous for its rugged terrain, glaciers, and deep valleys, making it a haven for trekkers and mountaineers. It is also home to various endangered species, including the snow leopard and red panda. The park offers numerous trekking routes, including the famous Everest Base Camp trek, which attracts adventurers from around the world seeking to experience the grandeur of the Himalayas.', '9500', '8800', '7%', 'nepal_sagarmatha.jpg', '2023-05-20 13:00:00', NULL);

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
(19, 'Kathmandu Valley', 'Kathmandu-Nepal', 'Kathmandu Valley, a UNESCO World Heritage Site, is rich in history and culture. It is home to seven World Heritage monuments, including the Swayambhunath (Monkey Temple), Boudhanath Stupa, and the Durbar Squares of Kathmandu, Patan, and Bhaktapur. The valley is known for its ancient architecture, vibrant streets, and rich cultural heritage. The intricate wood carvings, centuries-old temples, and religious practices reflect the essence of Nepal’s spiritual and artistic identity.', 'kathmandu_valley.jpg', '2023-05-20 10:00:00', NULL),
(20, 'Pokhara - Gateway to Annapurna', 'Pokhara-Nepal', 'Pokhara is a peaceful lakeside town, and one of the most popular tourist destinations in Nepal. It is the gateway to the Annapurna Circuit, a popular trekking route, and offers stunning views of the Annapurna range, including Machhapuchhre (Fishtail) Mountain. Visitors can enjoy boating on Phewa Lake, paragliding, and exploring the nearby caves and waterfalls. Pokhara’s tranquil ambiance and natural beauty make it a perfect retreat for nature lovers and adventurers alike.', 'pokhara_nepal.jpg', '2023-05-20 10:30:00', NULL),
(21, 'Lumbini - Birthplace of Buddha', 'Lumbini-Nepal', 'Lumbini is the birthplace of Lord Buddha and a UNESCO World Heritage Site. It is one of the most important pilgrimage sites for Buddhists from around the world. The Maya Devi Temple, marking the spot where Buddha was born, is the centerpiece of the Lumbini complex. The surrounding area is dotted with monasteries and meditation centers built by various countries. Lumbini offers a serene atmosphere for those seeking spiritual peace and reflection.', 'lumbini_nepal.jpg', '2023-05-20 11:00:00', NULL),
(22, 'Chitwan National Park', 'Chitwan-Nepal', 'Chitwan National Park is Nepal’s first national park and a UNESCO World Heritage Site. It is known for its rich biodiversity and offers jungle safaris, bird watching, and the opportunity to see endangered species such as the one-horned rhinoceros and Bengal tiger. Chitwan is perfect for nature lovers who wish to experience the subtropical wilderness and wildlife of Nepal.', 'chitwan_national_park.jpg', '2023-05-20 11:30:00', NULL),
(23, 'Nagarkot - Scenic Himalayan View', 'Nagarkot-Nepal', 'Nagarkot is a small hill station near Kathmandu that offers panoramic views of the Himalayan range, including Mount Everest on clear days. It is popular for watching breathtaking sunrises and sunsets over the Himalayas. Surrounded by terraced fields and pine forests, Nagarkot is a favorite destination for trekkers and those seeking a peaceful escape from the city.', 'nagarkot_nepal.jpg', '2023-05-20 12:00:00', NULL),
(24, 'Bhaktapur Durbar Square', 'Bhaktapur-Nepal', 'Bhaktapur, a UNESCO World Heritage Site, is renowned for its medieval architecture, vibrant culture, and traditional craftsmanship. The Durbar Square in Bhaktapur is filled with intricate temples and statues. It’s a place where visitors can experience Nepal’s rich history and culture firsthand. Bhaktapur is famous for its pottery, wood carvings, and festivals, making it a cultural hub.', 'bhaktapur_nepal.jpg', '2023-05-20 12:30:00', NULL),
(25, 'Bandipur - Hilltop Heritage Town', 'Bandipur-Nepal', 'Bandipur is a picturesque hilltop town with stunning views of the Himalayas. It is known for its well-preserved Newari culture and old-world charm, with cobblestone streets and traditional houses. Bandipur offers a peaceful environment with plenty of hiking trails and scenic beauty. It is perfect for those looking to immerse themselves in Nepal’s rural charm and natural beauty.', 'bandipur_nepal.jpg', '2023-05-20 13:00:00', NULL),
(26, 'Sagarmatha National Park - Everest Region', 'Everest Region-Nepal', 'Sagarmatha National Park is home to Mount Everest, the highest peak in the world. The park is a UNESCO World Heritage Site and offers numerous trekking routes, including the famous Everest Base Camp trek. The park is known for its dramatic scenery, glaciers, and diverse wildlife, including the snow leopard. It is a destination for trekkers and adventurers seeking the grandeur of the Himalayas.', 'sagarmatha_national_park.jpg', '2023-05-20 13:30:00', NULL);

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
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbltourpackages`
--

INSERT INTO `tbltourpackages` 
(`PackageId`, `PackageName`, `PackageType`, `PackageLocation`, `PackagePrice`, `PackageFetures`, `PackageDetails`, `PackageImage`, `Creationdate`, `UpdationDate`) 
VALUES
(1, 'Kathmandu Valley Tour', 'Family Package', 'Kathmandu', 4500, 'Free pickup and drop facility', 'Explore the rich cultural heritage of Kathmandu Valley, including UNESCO World Heritage Sites like Swayambhunath Stupa, Pashupatinath Temple, and Bhaktapur Durbar Square...', 'kathmandu_valley.jpg', '2023-05-19 05:57:39', '2023-05-19 05:57:39'),
(2, 'Annapurna Base Camp Trek', 'Adventure Package', 'Annapurna Region', 12000, 'Guided trek, meals included', 'Experience the stunning beauty of the Annapurna Range. This trek takes you through lush forests, picturesque villages, and offers breathtaking mountain views...', 'annapurna_base_camp.jpg', '2023-05-19 05:58:00', '2023-05-19 05:58:00'),
(3, 'Pokhara Lakeside Retreat', 'Couple Package', 'Pokhara', 5500, 'Free pickup and drop facility', 'Enjoy a romantic getaway at Pokhara, famous for its serene lakes, stunning mountain views, and adventure sports like paragliding and boating...', 'pokhara_lakeside.jpg', '2023-05-19 05:58:30', '2023-05-19 05:58:30'),
(4, 'Chitwan National Park Safari', 'Family Package', 'Chitwan', 7000, 'Free pickup and drop facility', 'Embark on a wildlife safari in Chitwan National Park, home to diverse wildlife including Bengal tigers, one-horned rhinoceroses, and elephants. Enjoy jungle walks and canoeing...', 'chitwan_safari.jpg', '2023-05-19 05:59:00', '2023-05-19 05:59:00'),
(5, 'Everest Base Camp Trek', 'Adventure Package', 'Everest Region', 15000, 'Guided trek, meals included', 'Trek to the base of the world’s highest peak, Mt. Everest. This challenging trek offers breathtaking views of the Himalayas and a glimpse into Sherpa culture...', 'everest_base_camp.jpg', '2023-05-19 05:59:30', '2023-05-19 05:59:30'),
(6, 'Lumbini Pilgrimage Tour', 'Cultural Package', 'Lumbini', 4000, 'Free pickup and drop facility', 'Visit the birthplace of Lord Buddha in Lumbini. Explore the sacred garden, Maya Devi Temple, and various monasteries built by different countries...', 'lumbini_pilgrimage.jpg', '2023-05-19 06:00:00', '2023-05-19 06:00:00'),
(7, 'Nagarkot Sunrise Tour', 'Couple Package', 'Nagarkot', 3000, 'Free pickup and drop facility', 'Experience the breathtaking sunrise over the Himalayas from Nagarkot, a popular hill station near Kathmandu. Ideal for couples seeking a romantic getaway...', 'nagarkot_sunrise.jpg', '2023-05-19 06:00:30', '2023-05-19 06:00:30');


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
(9, 'Samba Dorje Lama ', 'sambadorje2024@gmail.com', '456', 'user', 'active', '2023-05-29 08:21:20', '2023-05-29 19:59:45')
;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingId`);

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
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `packageoffer`
--
ALTER TABLE `packageoffer`
  MODIFY `OfferId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbldestination`
--
ALTER TABLE `tbldestination`
  MODIFY `DestinationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE distances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_from INT NOT NULL,
    location_to INT NOT NULL,
    distance INT NOT NULL,
    FOREIGN KEY (location_from) REFERENCES locations(id),
    FOREIGN KEY (location_to) REFERENCES locations(id)
);

