-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2019 at 10:05 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magebit`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `attribute_name` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `attribute_content` varchar(1000) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `user_id`, `attribute_name`, `attribute_content`) VALUES
(1, 1, 'Lorem', ' Pellentesque eros tellus, laoreet non orci ac, condimentum consectetur ante. Maecenas erat mauris, dignissim et ex ut, suscipit accumsan odio. Nunc vestibulum ex urna. Ut tempor a urna ut ultrices. Aliquam erat volutpat. Nulla eu lorem eget arcu lobortis scelerisque. Vestibulum quis dignissim neque. In lobortis consectetur tortor, eu iaculis enim. Nam lobortis neque quis ultrices suscipit. Ut dignissim tellus massa, eu placerat leo imperdiet et.'),
(2, 1, 'asd', 'Pellentesque tincidunt leo id eleifend placerat. Duis mattis nibh tellus, sit amet hendrerit nisi interdum vitae. Proin enim massa, venenatis in iaculis eget, pulvinar non tellus. Curabitur vel vestibulum risus, et efficitur nunc. Duis iaculis mattis metus, vitae convallis tortor mollis laoreet. Morbi placerat dapibus interdum.'),
(3, 1, 'test', 'Maecenas augue tortor, tincidunt vel turpis nec, maximus cursus orci. Donec elementum nisi non porta condimentum. Vestibulum maximus dictum metus, eget cursus erat venenatis non. Duis varius suscipit libero sit amet rutrum.'),
(4, 3, 'Speech', 'above average'),
(5, 3, 'Age:', 'Died at 69'),
(6, 3, 'Notes', 'Committed suicide at the command of his student, emperor Nero.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `pwd` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(1000) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pwd`, `email`) VALUES
(1, 'User1', 'pwd', 'email@email.com'),
(2, 'someone', 'asd', 'test'),
(3, 'Seneka', 'asd', 'asd@asd.asd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
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
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
