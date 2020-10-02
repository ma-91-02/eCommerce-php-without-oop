-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2020 at 12:56 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(256, 'Hand Made', 'Hand Made Items', 0, 1, 0, 0, 0),
(257, 'Computers', 'Computers Items', 0, 2, 0, 0, 0),
(258, 'Cell Phones', 'Cell Phones', 0, 3, 1, 1, 1),
(259, 'Clothing', 'Clothing And Fashion', 0, 4, 0, 0, 0),
(263, 'Nokia', 'Nokia Phone', 258, 2, 0, 0, 0),
(265, 'Tool', 'Tool', 0, 7, 0, 0, 0),
(266, 'Boxes', 'Boxes Hand Made', 256, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(10, 'Thank You', 1, '2020-09-01', 21, 1),
(11, 'This Is Very Good', 1, '2020-09-02', 19, 1),
(23, 'hi ', 1, '2020-09-24', 21, 1),
(37, 'Very Good Cable', 1, '2020-09-24', 21, 1),
(39, 'This Is Very Nice Game', 1, '2020-09-24', 22, 27),
(40, 'fd', 0, '2020-09-24', 26, 1),
(41, 'fd', 0, '2020-09-24', 26, 1),
(42, 'hi after required', 0, '2020-09-24', 26, 1),
(43, 'hi after required', 0, '2020-09-24', 26, 1),
(44, 'hi after required', 0, '2020-09-24', 26, 1),
(45, 'hi after required', 0, '2020-09-24', 26, 1),
(46, 'hi after required', 0, '2020-09-24', 26, 1),
(47, 'hi after required', 0, '2020-09-24', 26, 1),
(48, 'hi after required', 0, '2020-09-24', 26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `tags`) VALUES
(17, 'Speaker', 'Very Good Speaker', '15', '2020-09-21', 'China', '', '1', 0, 1, 257, 1, ''),
(18, 'Yeti Blue Mic', 'Very Good Microphone', '110', '2020-09-21', 'USA', '', '1', 0, 1, 257, 1, ''),
(19, 'iPhone 8', 'Apple iPhone 8', '400', '2020-09-21', 'USA', '', '2', 0, 1, 258, 1, ''),
(20, 'Magic Mouse', 'Apple Magic Mouse', '150', '2020-09-22', 'USA', '', '1', 0, 1, 257, 1, ''),
(21, 'Network Cable', 'Cat 9 Network Cable', '100', '2020-09-22', 'USA', '', '1', 0, 1, 257, 1, ''),
(22, 'Game', 'Game For Camputer', '120', '2020-09-24', 'USA', '', '1', 0, 1, 257, 33, ''),
(23, 'iPhone 6', 'Very Cool Phone', '200', '2020-09-24', 'USA', '', '2', 0, 1, 258, 33, ''),
(25, 'Good Box', 'Nice Hand', '40', '2020-09-24', 'Karea', '', '1', 0, 1, 256, 33, ''),
(26, 'mohamed', 'mohamed', '10000000000000', '2020-09-24', 'iraq', '', '4', 0, 1, 256, 27, ''),
(27, 'iphone 7', 'iphone from USA', '200', '2020-09-24', 'china', '', '3', 0, 0, 258, 27, ''),
(28, 'iPhone x ', 'iPhone X', '600', '2020-09-24', 'USA', '', '3', 0, 0, 258, 1, ''),
(29, 'iPhone X Max', 'iPhone X Max', '800', '2020-09-24', 'Karea', '', '3', 0, 0, 258, 1, 'aliexperes'),
(30, 'samsung A71', 'Samsung A71', '400', '2020-09-24', 'Karea', '', '1', 0, 1, 258, 1, ''),
(32, 'Wooden Game', 'A Good Wooden Game', '100', '2020-09-29', 'iraq', '', '1', 0, 1, 256, 35, 'Al-zurfi, Hand, Discount, Gurantee'),
(33, 'Diablo lll', 'Good Playstation 4 Game', '70', '2020-09-29', 'USA', '', '1', 0, 1, 257, 1, 'RPG, Online, Game'),
(34, 'iphone 7', 'iphone from USA', '200', '2020-09-29', 'USA', '', '1', 0, 1, 258, 1, ' Discount'),
(35, 'iphone 7', 'iphone from USA', '200', '2020-09-29', 'USA', '', '1', 0, 1, 258, 1, ' Discount');

-- --------------------------------------------------------

--
-- Table structure for table `langs`
--

CREATE TABLE `langs` (
  `id` int(11) NOT NULL,
  `lang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `langs`
--

INSERT INTO `langs` (`id`, `lang`) VALUES
(0, 0),
(0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL COMMENT 'to identify user',
  `Username` varchar(255) NOT NULL COMMENT 'username to login',
  `Password` varchar(255) NOT NULL COMMENT 'password to login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identify user group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approval',
  `Date` date DEFAULT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'ma', '6b0d31c0d563223024da45691584643ac78c96e8', 'ma@your-ma.com', 'Company', 1, 1, 1, '2020-08-01', ''),
(27, 'Ahmed', '356a192b7913b04c54574d18c28d46e6395428ab', 'ahmed@gmail.com', 'Ahmed Jameal', 1, 1, 1, '2020-09-20', ''),
(33, 'ali1', '356a192b7913b04c54574d18c28d46e6395428ab', 'ali@gmail.com', 'ali alzurfi', 0, 0, 0, '2020-09-21', ''),
(34, 'Manar', '356a192b7913b04c54574d18c28d46e6395428ab', 'manar@gmail.com', 'manar hussien', 0, 0, 0, '2020-09-21', ''),
(35, 'Mhaa', '356a192b7913b04c54574d18c28d46e6395428ab', 'mhaa@gmail.com', 'Mhaa Hussin', 0, 0, 0, '2020-09-22', ''),
(36, 'Murtaza', '356a192b7913b04c54574d18c28d46e6395428ab', 'murtaza@gmail.com', 'Murtaza Hussien', 0, 0, 0, '2020-09-23', ''),
(37, 'slava', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Slava@mail.com', '', 0, 0, 0, '2020-09-23', ''),
(38, 'kalid', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'kalid@gmail.com', '', 0, 0, 0, '2020-09-23', ''),
(39, 'gfhghdgh', 'fe17eaf14082fe24d7d27c0bd426a28ca04c0987', 'murtaza_hussin@gamil.com', 'ali alzurfi', 0, 0, 1, '2020-09-30', '8605676092_6Untitled.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to identify user', AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
