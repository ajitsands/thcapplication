-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 03, 2024 at 06:32 PM
-- Server version: 5.7.15-log
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `feedback`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback_options`
--

CREATE TABLE `feedback_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `option_text` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback_options`
--

INSERT INTO `feedback_options` (`id`, `question_id`, `option_text`) VALUES
(1, 1, 'Ajit'),
(2, 1, 'Kumar'),
(3, 1, 'Sinu'),
(4, 1, 'Anu'),
(5, 2, 'Koratty'),
(6, 2, 'Chalakudy'),
(7, 2, 'Angamaly'),
(8, 3, 'Please discribe');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_questions`
--

CREATE TABLE `feedback_questions` (
  `id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback_questions`
--

INSERT INTO `feedback_questions` (`id`, `question_text`, `type`) VALUES
(1, 'What is your name', 'radio'),
(2, 'Where are you staying', 'checkbox'),
(3, 'Do you have Friends', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_responses`
--

CREATE TABLE `feedback_responses` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback_responses`
--

INSERT INTO `feedback_responses` (`id`, `question_id`, `option_id`, `user_id`) VALUES
(1, 1, 1, 1),
(2, 2, 6, 1),
(3, 2, 7, 1),
(4, 1, 2, 1),
(5, 2, 5, 1),
(6, 2, 6, 1),
(7, 2, 7, 1),
(8, 1, 4, 1),
(9, 2, 5, 1),
(10, 1, 4, 1),
(11, 2, 5, 1),
(12, 2, 6, 1),
(13, 2, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback_text_responses`
--

CREATE TABLE `feedback_text_responses` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `response_text` varchar(5000) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback_text_responses`
--

INSERT INTO `feedback_text_responses` (`id`, `question_id`, `response_text`, `user_id`) VALUES
(0, 3, 'Same', 1),
(0, 3, 'I ahave many friends', 1),
(0, 3, 'I have many friends', 1),
(0, 3, 'Same', 1),
(0, 3, 'I ahave many friends', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback_options`
--
ALTER TABLE `feedback_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `feedback_questions`
--
ALTER TABLE `feedback_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback_responses`
--
ALTER TABLE `feedback_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `option_id` (`option_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback_options`
--
ALTER TABLE `feedback_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `feedback_questions`
--
ALTER TABLE `feedback_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `feedback_responses`
--
ALTER TABLE `feedback_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback_options`
--
ALTER TABLE `feedback_options`
  ADD CONSTRAINT `feedback_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `feedback_questions` (`id`);

--
-- Constraints for table `feedback_responses`
--
ALTER TABLE `feedback_responses`
  ADD CONSTRAINT `feedback_responses_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `feedback_questions` (`id`),
  ADD CONSTRAINT `feedback_responses_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `feedback_options` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
