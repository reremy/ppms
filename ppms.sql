-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 01:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppms`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blogID` int(11) NOT NULL,
  `blogEntry` text NOT NULL,
  `blogImg` varchar(100) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `updatedDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `blog` (`blogID`, `blogEntry`, `blogImg`, `createdBy`, `updatedDate`) VALUES
(1, 'Top 5 Coffee Recipes to Try at Home', 'uploads/blog-coffee.jpg', 2, '2024-12-17'),
(2, 'The Joy of Pre-loved Books', 'uploads/blog-books.jpg', 3, '2024-12-18'),
(3, 'How to Create the Perfect Breakfast Set', 'uploads/blog-food.jpg', 4, '2024-12-19');


-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(100) NOT NULL,
  `categoryDesc` varchar(100) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryName`, `categoryDesc`, `createDate`) VALUES
(1, 'books', 'pre-loved books', '2024-12-03 16:00:00'),
(2, 'coffee', 'for coffee lovers', '2024-12-04 11:38:01'),
(3, 'food', 'food category', '2024-12-04 11:38:01');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int(11) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `productImg` varchar(100) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `productQty` int(11) NOT NULL,
  `productPrice` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `productImg`, `categoryID`, `productQty`, `productPrice`) VALUES
(1, 'Coffee Latte', 'uploads/coffee1.jpeg', 2, 5, 8.90),
(2, 'Coffee Cappucino', 'uploads/Cappucino.jpeg', 2, 7, 9.90),
(3, 'Coffee Bot', 'uploads/coffee4-s.jpeg', 2, 5, 6.00),
(4, 'Soto Ayam', 'uploads/soto-ayam.jpg', 3, 5, 9.90),
(5, 'Kopi  Gohson', 'uploads/coffee5-s.jpeg', 2, 3, 10.00),
(6, 'Coffee Set', 'uploads/Coffee Set.jpeg', 2, 3, 12.50),
(7, 'Breakfast Set', 'uploads/coffee2.jpeg', 3, 4, 9.90),
(8, 'Nasi Goreng Telur', 'uploads/nasi-goreng.jpg', 3, 10, 6.50),
(9, 'Mee Sup', 'uploads/maggi-sup.jpg', 3, 4, 9.90),
(10, 'Nasi Ayam', 'uploads/nasi-ayam.jpg', 3, 12, 12.00),
(11, 'Book 1', 'uploads/book1.jpeg', 1, 4, 1.00),
(12, 'Book 2', 'uploads/book2.jpeg', 1, 3, 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservationID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `orderAmt` decimal(8,2) NOT NULL,
  `reservationDate` date NOT NULL DEFAULT current_timestamp(),
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservationID`, `userID`, `orderAmt`, `reservationDate`, `status`) VALUES
(5, 1, 21.90, '2024-12-17', 1),
(7, 1, 14.90, '2024-12-17', 1),
(8, 1, 8.90, '2024-12-17', 1),
(9, 1, 30.80, '2024-12-17', 1),
(14, 2, 6.00, '2024-12-17', 1),
(15, 2, 10.00, '2024-12-17', 1),
(17, 5, 19.90, '2024-12-17', 1),
(26, 5, 10.00, '2024-12-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_detail`
--

CREATE TABLE `reservation_detail` (
  `lineID` int(11) NOT NULL,
  `reservationID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `orderQuantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_detail`
--

INSERT INTO `reservation_detail` (`lineID`, `reservationID`, `productID`, `orderQuantity`) VALUES
(1, 5, 7, 1),
(2, 5, 10, 1),
(3, 7, 7, 1),
(4, 7, 11, 5),
(5, 8, 1, 1),
(6, 9, 1, 1),
(7, 9, 4, 1),
(8, 9, 10, 1),
(15, 14, 3, 1),
(16, 15, 5, 1),
(20, 17, 2, 1),
(21, 17, 5, 1),
(29, 26, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewID` int(11) NOT NULL,
  `reservationID` int(11) NOT NULL,
  `reviewText` text NOT NULL,
  `rating` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `reviewBy` int(11) NOT NULL,
  `reviewDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `review` (`reviewID`, `reservationID`, `reviewText`, `rating`, `productID`, `reviewBy`, `reviewDate`) VALUES
(1, 5, 'The coffee latte was fantastic! Highly recommend.', 5, 1, 2, '2024-12-18'),
(2, 7, 'Loved the Nasi Ayam. Great taste and presentation.', 4, 10, 3, '2024-12-19'),
(3, 8, 'The books were in excellent condition. A great find!', 5, 11, 4, '2024-12-20'),
(4, 9, 'Mee Sup was a bit too salty for my taste.', 3, 9, 5, '2024-12-21'),
(5, 9, 'Breakfast set was okay, but could have more variety.', 4, 7, 2, '2024-12-22');


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userPwd` varchar(255) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `regDate` date NOT NULL DEFAULT current_timestamp(),
  `userRoles` int(2) NOT NULL DEFAULT 2 COMMENT '1 - System Admin, 2 - Normal User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userName`, `userPwd`, `userEmail`, `regDate`, `userRoles`) VALUES
(1, 'admin1', '$2y$10$hMpchm/FkrnNuftMoMs/i.rdxecP3icfeAcGdT6mBZxNKM.WF3r0W', 'admin1@email.com', '2024-12-16', 1),
(2, 'user1', '$2y$10$Xbsopm11vCGLgPkhHkRSGuDQzFqQSn4zWEFcSM7W/U5B91rStsBwO', 'user1@email.com', '2024-12-16', 2),
(3, 'user2', '$2y$10$UU12nkXR.muKnCiW/7XoNOatJGVUFcxnFO.U9UD/6usFvyrUy5Yc2', 'user2@email.com', '2024-12-17', 2),
(4, 'user3', '$2y$10$Z8YFrqG/cQr/P/gT.RER6u3k5rVBIfqPsN9m1kTO29.m9h9Ox3z5q', 'user3@email.com', '2024-12-17', 2),
(5, 'user4', '$2y$10$nSSUd8AF6LPyZHDtd4LRpesd65dUdJCpQ3S6plQd7DZpFEVvLpROu', 'user4@mail.com', '2024-12-17', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogID`),
  ADD KEY `createdBy` (`createdBy`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservationID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `reservation_detail`
--
ALTER TABLE `reservation_detail`
  ADD PRIMARY KEY (`lineID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `reservationID` (`reservationID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `userID` (`reviewBy`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blogID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reservation_detail`
--
ALTER TABLE `reservation_detail`
  MODIFY `lineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`createdBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation_detail`
--
ALTER TABLE `reservation_detail`
  ADD CONSTRAINT `reservation_detail_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_detail_ibfk_2` FOREIGN KEY (`reservationID`) REFERENCES `reservation` (`reservationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`reviewBy`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
