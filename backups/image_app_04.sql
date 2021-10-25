-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 23, 2021 at 06:12 PM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `image_app`
--
CREATE DATABASE IF NOT EXISTS `image_app` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `image_app`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` mediumint(9) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Portraits'),
(2, 'Landscapes'),
(3, 'Pet photos');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `body` varchar(2000) DEFAULT NULL,
  `date` datetime NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `body`, `date`, `post_id`, `is_approved`) VALUES
(1, 1, 'This is a comment by the admin, user #1.', '2021-10-13 10:38:12', 1, 1),
(2, 2, 'This is the second comment by user #2.', '2021-10-13 10:38:47', 2, 1),
(3, 1, 'test', '2021-10-18 09:22:26', 2, 1),
(4, 1, 'test tes', '2021-10-18 09:38:22', 2, 1),
(5, 1, 'Hello', '2021-10-19 08:03:31', 2, 1),
(6, 1, 'Hello', '2021-10-19 08:05:29', 2, 1),
(7, 1, 'Hello', '2021-10-19 08:07:32', 2, 1),
(8, 1, 'Hello', '2021-10-19 08:11:21', 2, 1),
(9, 1, 'Hello', '2021-10-19 08:28:55', 2, 1),
(10, 6, 'It&#39;s a bird!', '2021-10-21 10:37:08', 9, 1),
(11, 6, 'It&#39;s a bird!', '2021-10-21 10:44:52', 9, 1),
(12, 6, 'It&#39;s a bird!', '2021-10-21 10:44:59', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` mediumint(9) NOT NULL,
  `title` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `date` datetime NOT NULL,
  `category_id` mediumint(9) NOT NULL,
  `body` varchar(500) NOT NULL,
  `allow_comments` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `image`, `user_id`, `date`, `category_id`, `body`, `allow_comments`, `is_published`) VALUES
(1, 'A deer', 'https://picsum.photos/id/1003/400/400', 1, '2021-03-03 11:00:15', 3, 'this is a sample post for testing\r\n\r\nline break test\r\n\r\nanother break', 1, 1),
(2, 'Blanket Pug', 'https://picsum.photos/id/1062/400/400', 2, '2021-03-01 11:01:15', 1, 'It\'s a pug in a blanket. It\'s in category 1 and written by user 2. comments are off. I posted it on Monday March 1', 0, 1),
(3, 'Canoe', 'https://picsum.photos/id/1011/400/400', 1, '2021-03-01 11:01:15', 2, 'It\'s a person in a canoe', 1, 1),
(4, 'Canyon at Sunset', 'https://picsum.photos/id/1016/400/400', 1, '2021-03-01 11:01:15', 2, 'Look at this view!', 1, 1),
(5, 'Raspberries on a fence', 'https://picsum.photos/id/102/400/400', 2, '2021-03-11 07:31:00', 4, 'Weird place to keep your raspberries', 1, 1),
(6, 'Blanket Pug Part 2', 'https://picsum.photos/id/1025/400/400', 1, '2021-03-11 07:34:27', 2, 'Another little burrito pug', 1, 1),
(7, 'Mountain Bike', 'https://picsum.photos/id/1023/400/400', 1, '2021-03-11 07:35:25', 1, 'Going out to get some air', 1, 1),
(8, 'Aurora Borealis', 'https://picsum.photos/id/1022/400/400', 1, '2021-03-11 07:35:56', 1, 'The northern lights', 0, 1),
(9, 'Vulture', 'https://picsum.photos/id/1024/400/400', 1, '2021-03-11 07:43:37', 3, 'Pretty sure that\'s a vulture', 1, 1),
(10, 'Dream Catcher', 'https://picsum.photos/id/104/400/400', 1, '2021-03-11 07:43:37', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 0, 1),
(11, 'Long exposure at night', 'https://picsum.photos/id/1042/400/400', 2, '2021-03-11 07:43:37', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(12, 'Waves Crashing', 'https://picsum.photos/id/1053/400/400', 1, '2021-03-11 07:43:37', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(13, 'Castle', 'https://picsum.photos/id/1040/400/400', 1, '2021-03-11 07:43:37', 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(14, 'Back Alley', 'https://picsum.photos/id/1047/400/400', 1, '2021-03-11 07:43:37', 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(15, 'Flowers against the sky', 'https://picsum.photos/id/106/400/400', 2, '2021-03-11 07:35:25', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(16, 'Coffee Time', 'https://picsum.photos/id/1060/400/400', 1, '2021-03-11 07:43:37', 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `tag_id` mediumint(9) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `name`) VALUES
(1, 'tag1'),
(2, 'tag2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` mediumint(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(100) DEFAULT NULL,
  `bio` varchar(2000) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `access_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_pic`, `bio`, `is_admin`, `access_token`) VALUES
(1, 'Chloe', 'chloe@gmail.com', '$2y$10$J4SpNf16LheJuRYCCIBE0ev.k/tX44rvVivhwVeDHeR5rIpS3PXIK', 'https://randomuser.me/api/portraits/men/48.jpg', 'This is my bio blurb. I love food.', 1, ''),
(2, 'Nellie', 'nellie@gmail.com', '$2y$10$Tr2H2kCNVgt9Z1gzHdLMD.nstIlyVPE2Zl/3IAyis/n7vyQC7IaaW', 'https://randomuser.me/api/portraits/women/66.jpg', 'This is Nellie\'s new bio', 0, NULL),
(3, 'Kelly', 'kelly@gmail.com', '$2y$10$J2v4Fc0XLsR/WljUPw68uOkxR6wC1MlAnJWGuHnPrg6Z96ghUISxm', NULL, NULL, 0, NULL),
(5, 'Ryan', 'ryan@gmail.com', '$2y$10$J2v4Fc0XLsR/WljUPw68uOkxR6wC1MlAnJWGuHnPrg6Z96ghUISxm', NULL, NULL, 0, NULL),
(6, 'Joe', 'joe@gmail.com', '$2y$10$J2v4Fc0XLsR/WljUPw68uOkxR6wC1MlAnJWGuHnPrg6Z96ghUISxm', NULL, NULL, 0, ''),
(7, 'Miguel', 'miguel@gmail.com', '$2y$10$Tr2H2kCNVgt9Z1gzHdLMD.nstIlyVPE2Zl/3IAyis/n7vyQC7IaaW', NULL, NULL, 0, NULL),
(9, 'Maddy', 'maddy@gmail.com', '$2y$10$x3d9Ul65M5tsgj3roeNxDuOoc3MGdWsX7ZOJDw41wIogcqCpzJI0m', NULL, NULL, 0, NULL),
(10, 'Dean', 'dean@gmail.com', '$2y$10$eAGhOk.lzLLaoiSsP0.T4.lP.c5tJ3GvCxsf4de4N3g/T9u86CJVy', NULL, NULL, 0, NULL),
(11, 'Melissa', 'melissa@gmail.com', '$2y$10$DCA66Y8K.13U3sWWc1exdO83W.lXmPGryAqY2Efh.DBbTHFkTrlw6', NULL, NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
