-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: May 17, 2016 at 04:30 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `testdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `symbols`
--

CREATE TABLE `symbols` (
  `id` int(11) NOT NULL,
  `author` text NOT NULL,
  `post` text NOT NULL,
  `hashtags` text NOT NULL,
  `tags` text NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` int(11) NOT NULL,
  `hours` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `symbols`
--

INSERT INTO `symbols` (`id`, `author`, `post`, `hashtags`, `tags`, `likes`, `dislikes`, `date`, `time`, `hours`) VALUES
(24, '@j', 'This is really good', '#testing', '', 1, 1, '0000-00-00', 0, 0),
(32, '@these', 'Kind of works', '#testing', '', 1, 0, '0000-00-00', 0, 0),
(33, '@that', 'It worked!', '#testing', '', 0, 0, '0000-00-00', 0, 0),
(34, '@Julian', 'I''m in!', '#testing #working', '', 2, 0, '0000-00-00', 0, 0),
(35, '@Julian', 'This is so good', '#reversing', '', 0, 0, '0000-00-00', 0, 0),
(37, '@Julian', 'Hey!', '#isaac', '', 0, 0, '0000-00-00', 0, 0),
(38, '@Charlie Hughes', 'Ugghhhh', '#IDon''tLikeHashtags', '', 0, 0, '0000-00-00', 0, 0),
(41, '@NotZackNathan', '#hashtag', '', '', 0, 0, '0000-00-00', 0, 0),
(42, '@test', 'This tests the date', '#date', '@Isaac', 1, 0, '2016-05-06', 0, 0),
(43, '@test', 'Testing. This should be one day back', '#newdate', '@isaacng', 0, 0, '2016-05-05', 0, 0),
(44, '@asd', '', '#carrytheteam', '', 1, 0, '2016-05-06', 0, 0),
(45, '@asd', '', '', '@julian', 1, 0, '2016-05-06', 0, 0),
(46, '@Julian', 'Wow, the dates work', '#newpost #twohashtags', '@asd', 2, 0, '2016-05-07', 0, 0),
(48, '@Julian', '', '#hello', '', 0, 0, '2016-05-07', 0, 0),
(49, '@Julian', '', '#hello #hey', '', 4, 0, '2016-05-07', 0, 0),
(52, '@Julian', 'Hello #autohashtags - this works well', '#autohashtags ', '', 1, 0, '2016-05-07', 0, 0),
(55, '@Julian', 'It''s my very own tweet #tweets @asd @test', '#tweets ', '@asd @test ', 2, 1, '2016-05-07', 0, 0),
(56, '@julian', 'The new error #error messages look so good @julian', '#error ', '@julian ', 8, 3, '2016-05-07', 0, 0),
(58, '@test', '"Hello"', '', '', 10, 3, '2016-05-08', 0, 0),
(59, '@test', 'Hello #test', '#test ', '', 25, 13, '2016-05-09', 0, 0),
(60, '@test', 'Testing the time #testing', '#testing ', '', 15, 5, '2016-05-11', 9, 0),
(61, '@test', 'This shows time and date', '', '', 9, 16, '2016-05-12', 38, 0),
(62, '@test', 'Testing the time', '', '', 2, 8, '2016-05-12', 26, 0),
(63, '@test', 'Also testing the time function', '', '', 1, 0, '2016-05-16', 1463400104, 0),
(64, '@test', 'Testing the time #testing', '#testing ', '', 6, 0, '2016-05-16', 1463424636, 0),
(65, '@test', 'One final test for the program #testing @julian', '#testing ', '@julian ', 1, 0, '2016-05-17', 1463493588, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` char(64) NOT NULL,
  `salt` char(16) NOT NULL,
  `email` varchar(225) NOT NULL,
  `bio` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `bio`) VALUES
(1, 'test', '68b1b2f150f62deff233bd033c3952f620bc524b678af9dc41979ba299432e4e', '203a60d44b5cb80', 'test@gmail.com', 'This is my new bio. I can write what ever I want!'),
(2, 'julian', '559fa5822874d2bf64523b19fc397cc3198abc41f59de9d4880a4efd5b086d17', '5370039f319fbe9f', 'julian.samek@ucc.on.ca', 'Hey, I''m Julian and I''m one of the creators of this awesome website.'),
(3, 'username', '22538fce6eed10bed514ba3e4677b28ebf5f672172e79f20a465c8b99cceb310', '73011553b5210f9', 'username@mail.mail', ''),
(4, 'adil', '3191462157712ba7fc4c5ea352d94da18d754e073553270c1e508db3f2d6125a', '682873b537a3ede1', 'adil.natal@ucc.on.ca', 'I''m Adil. I''m better than Carson in every way'),
(5, 'jul', '96b188699bbb3b568d160f14e0ef0a13519d90d84f358e14cdb3a88596701541', '18ab273f2e1f0524', 'julian@gmail.com', ''),
(6, 'chef_samek', '4e5e68fba0fd407a4d937cfadb62d9584d5d0b2a85a8fe08fbd072dde07d2e6c', '6e4edf826765727f', 'chef@gmail.com', ''),
(7, 'new', 'a88bcb6f22a94370eb219568e90efcad466ae955ac6a1f51fc0e8f617cf4e9f5', '7235208164782c7', 'new@gmail.com', ''),
(8, 'Juliana', 'aed742e4be064ca25ed362688f69d346f7aeae485b16d317f6d254cb6d0014c2', '39e5e8e47de7f2c', 'gam@gmail.com', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `symbols`
--
ALTER TABLE `symbols`
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
-- AUTO_INCREMENT for table `symbols`
--
ALTER TABLE `symbols`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
