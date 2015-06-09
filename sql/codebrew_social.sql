-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 03, 2015 at 07:42 AM
-- Server version: 5.5.42
-- PHP Version: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `codebrew_social`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'jindal.ankit89@gmail.com', 'c81e728d9d4c2f636f067f89cc14862c');

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE IF NOT EXISTS `budget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash_id` int(11) NOT NULL,
  `price_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`id`, `user_id`, `hash_id`, `price_id`) VALUES
(58, 38, 87, 1),
(59, 38, 88, 1),
(60, 38, 89, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_temp`
--

CREATE TABLE IF NOT EXISTS `email_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_mail` text COLLATE utf8_unicode_ci NOT NULL,
  `body_mail` text COLLATE utf8_unicode_ci NOT NULL,
  `support_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('Verify Account','Reset Password') COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `email_temp`
--

INSERT INTO `email_temp` (`id`, `subject_mail`, `body_mail`, `support_email`, `type`, `url`) VALUES
(1, 'SocialChange - User Verification', 'We have received your SocialChange account request.									', 'info@socialchange.media', 'Verify Account', 'www.socialchange.media'),
(2, 'SocialChange - Recover Password', 'We have received your password SocialChange reset request.			', 'info@socialchange.media', 'Reset Password', 'www.socialchange.media');

-- --------------------------------------------------------

--
-- Table structure for table `hash_tags`
--

CREATE TABLE IF NOT EXISTS `hash_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `description` varchar(300) NOT NULL,
  `users` int(20) NOT NULL,
  `set_cap` int(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `hash_tags`
--

INSERT INTO `hash_tags` (`id`, `user_id`, `title`, `description`, `users`, `set_cap`, `created_on`) VALUES
(87, 38, '#SocialChangeUS', '', 25, 1000, '2015-05-29 10:10:06'),
(88, 38, '#BrandSomethingGreat', '', 14, 1000, '2015-05-29 10:28:00'),
(89, 38, '#FabSocialChange', 'Famous', 6, 1000, '2015-05-30 22:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `instagram`
--

CREATE TABLE IF NOT EXISTS `instagram` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `access_token` text COLLATE utf8_unicode_ci NOT NULL,
  `hash_id` int(11) NOT NULL,
  `inst_username` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `cron_status` tinyint(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `instagram`
--

INSERT INTO `instagram` (`id`, `user_id`, `access_token`, `hash_id`, `inst_username`, `date`, `cron_status`, `created_on`) VALUES
(14, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:29:28'),
(13, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:29:28'),
(12, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:29:29'),
(11, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:28:36'),
(5, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:28:36'),
(6, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:28:37'),
(7, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:28:37'),
(8, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:06:11'),
(9, 44, '1508021713.81822e9.8d060d0d9d964dfdb7f44c6379848c99', 87, 'rajat_cb', '2015-05-29', 1, '2015-05-29 09:06:12'),
(18, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:29:29'),
(15, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 10:10:06'),
(16, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 09:47:44'),
(17, 44, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 87, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 10:39:36'),
(19, 44, '1508021713.81822e9.8d060d0d9d964dfdb7f44c6379848c99', 88, 'rajat_cb', '2015-05-29', 1, '2015-05-29 09:29:30'),
(20, 44, '1508021713.81822e9.8d060d0d9d964dfdb7f44c6379848c99', 88, 'rajat_cb', '2015-05-29', 1, '2015-05-29 10:10:07'),
(21, 44, '1508021713.81822e9.8d060d0d9d964dfdb7f44c6379848c99', 87, 'rajat_cb', '2015-05-29', 1, '2015-05-29 10:39:36'),
(22, 46, '2028525090.81822e9.4b9289ebbab64cebb1efa38d81e2a5ee', 89, 'richadhiman.codebrew', '2015-05-29', 1, '2015-05-29 10:39:36'),
(23, 44, '1508021713.81822e9.8d060d0d9d964dfdb7f44c6379848c99', 89, 'rajat_cb', '2015-05-29', 1, '2015-05-29 10:39:37'),
(24, 44, '1508021713.81822e9.8d060d0d9d964dfdb7f44c6379848c99', 89, 'rajat_cb', '2015-05-29', 1, '2015-05-29 10:39:37'),
(25, 46, '1508021713.81822e9.8d060d0d9d964dfdb7f44c6379848c99', 89, 'rajat_cb', '2015-05-29', 1, '2015-05-29 10:43:43');

-- --------------------------------------------------------

--
-- Table structure for table `payout`
--

CREATE TABLE IF NOT EXISTS `payout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount_earned` double NOT NULL,
  `amount_paid` decimal(20,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `payout`
--

INSERT INTO `payout` (`id`, `user_id`, `amount_earned`, `amount_paid`, `status`) VALUES
(1, 7, 0.4, 0.00, 0),
(2, 12, 4.12, 0.00, 0),
(3, 2, 12.05, 0.00, 0),
(4, 18, 6.28, 0.00, 0),
(5, 42, 0.035, 0.00, 0),
(6, 43, 0.135, 0.00, 0),
(7, 37, 0.46499999999999997, 0.00, 0),
(12, 44, 0.4, 0.00, 0),
(9, 46, 0.5, 0.00, 0),
(10, 47, 0.07, 0.00, 0),
(11, 49, 0.2, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

CREATE TABLE IF NOT EXISTS `pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(20,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=187 ;

--
-- Dumping data for table `pricing`
--

INSERT INTO `pricing` (`id`, `price`) VALUES
(1, 0.10),
(2, 0.20),
(3, 0.30),
(4, 0.40),
(5, 0.50),
(6, 0.60),
(7, 0.70),
(8, 0.80),
(9, 0.90),
(10, 1.00),
(11, 1.10),
(12, 1.20),
(13, 1.30),
(14, 1.40),
(15, 1.50),
(16, 1.60),
(17, 1.70),
(18, 1.80),
(19, 1.90),
(20, 2.00),
(21, 2.10),
(22, 2.20),
(23, 2.30),
(24, 2.40),
(25, 2.50),
(26, 2.60),
(27, 2.70),
(28, 2.80),
(29, 2.90),
(30, 3.00),
(31, 3.10),
(32, 3.20),
(33, 3.30),
(34, 3.40),
(35, 3.50),
(36, 3.60),
(37, 3.70),
(38, 3.80),
(39, 3.90),
(40, 4.00),
(41, 4.10),
(42, 4.20),
(43, 4.30),
(44, 4.40),
(45, 4.50),
(46, 4.60),
(47, 4.70),
(48, 4.80),
(49, 4.90),
(50, 5.00),
(51, 5.10),
(52, 5.20),
(53, 5.30),
(54, 5.40),
(55, 5.50),
(56, 5.60),
(57, 5.70),
(58, 5.80),
(59, 5.90),
(60, 6.00),
(61, 6.10),
(62, 6.20),
(63, 6.30),
(64, 6.40),
(65, 6.50),
(66, 6.60),
(67, 6.70),
(68, 6.80),
(69, 6.90),
(70, 7.00),
(71, 7.10),
(72, 7.20),
(73, 7.30),
(74, 7.40),
(75, 7.50),
(76, 7.60),
(77, 7.70),
(78, 7.80),
(79, 7.90),
(80, 8.00),
(81, 8.10),
(82, 8.20),
(83, 8.30),
(84, 8.40),
(85, 8.50),
(86, 8.60),
(87, 8.70),
(88, 8.80),
(89, 8.90),
(90, 9.00),
(91, 9.10),
(92, 9.20),
(93, 9.30),
(94, 9.40),
(95, 9.50),
(96, 9.60),
(97, 9.70),
(98, 9.80),
(99, 9.90),
(100, 10.00),
(101, 10.10),
(102, 10.20),
(103, 10.30),
(104, 10.40),
(105, 10.50),
(106, 10.60),
(107, 10.70),
(108, 10.80),
(109, 10.90),
(110, 11.00),
(111, 11.10),
(112, 11.20),
(113, 11.30),
(114, 11.40),
(115, 11.50),
(116, 11.60),
(117, 11.70),
(118, 11.80),
(119, 11.90),
(120, 12.00),
(121, 12.10),
(122, 12.20),
(123, 12.30),
(124, 12.40),
(125, 12.50),
(126, 12.60),
(127, 12.70),
(128, 12.80),
(129, 12.90),
(130, 13.00),
(131, 13.10),
(132, 13.20),
(133, 13.30),
(134, 13.40),
(135, 13.50),
(136, 13.60),
(137, 13.70),
(138, 13.80),
(139, 13.90),
(140, 14.00),
(141, 14.10),
(142, 14.20),
(143, 14.30),
(144, 14.40),
(145, 14.50),
(146, 14.60),
(147, 14.70),
(148, 14.80),
(149, 14.90),
(150, 15.00),
(151, 15.10),
(152, 15.20),
(153, 15.30),
(154, 15.40),
(155, 15.50),
(156, 15.60),
(157, 15.70),
(158, 15.80),
(159, 15.90),
(160, 16.00),
(161, 16.10),
(162, 16.20),
(163, 16.30),
(164, 16.40),
(165, 16.50),
(166, 16.60),
(167, 16.70),
(168, 16.80),
(169, 16.90),
(170, 17.00),
(171, 17.10),
(172, 17.20),
(173, 17.30),
(174, 17.40),
(175, 17.50),
(176, 17.60),
(177, 17.70),
(178, 17.80),
(179, 17.90),
(180, 18.00),
(181, 18.10),
(182, 18.20),
(183, 18.30),
(184, 18.40),
(185, 18.50),
(186, 18.60);

-- --------------------------------------------------------

--
-- Table structure for table `social_provider`
--

CREATE TABLE IF NOT EXISTS `social_provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider` varchar(50) NOT NULL,
  `hash_id` int(11) NOT NULL,
  `count` int(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

--
-- Dumping data for table `social_provider`
--

INSERT INTO `social_provider` (`id`, `user_id`, `provider`, `hash_id`, `count`, `created_on`) VALUES
(72, 42, 'twitter', 87, 1, '2015-05-13 05:48:37'),
(73, 43, 'twitter', 87, 6, '2015-05-29 10:27:42'),
(74, 37, 'twitter', 87, 3, '2015-05-13 23:22:37'),
(75, 37, 'tumblr', 87, 1, '2015-05-13 23:21:46'),
(76, 37, 'facebook', 87, 2, '2015-05-13 23:23:42'),
(84, 46, 'facebook', 87, 2, '2015-05-22 04:23:46'),
(86, 46, 'twitter', 87, 3, '2015-05-29 11:11:28'),
(87, 46, 'tumblr', 87, 1, '2015-05-21 06:26:45'),
(88, 47, 'twitter', 87, 1, '2015-05-21 06:42:31'),
(89, 47, 'tumblr', 87, 1, '2015-05-21 06:48:59'),
(90, 37, 'facebook', 88, 3, '2015-05-28 03:41:11'),
(91, 46, 'facebook', 88, 3, '2015-05-22 04:35:06'),
(92, 49, 'twitter', 88, 1, '2015-05-22 13:19:28'),
(98, 44, 'twitter', 88, 13, '2015-05-29 13:26:27'),
(99, 44, 'tumblr', 87, 5, '2015-05-27 10:36:29'),
(100, 44, 'tumblr', 88, 4, '2015-05-27 10:38:16'),
(101, 44, 'facebook', 87, 14, '2015-06-01 09:29:32'),
(102, 44, 'facebook', 88, 18, '2015-06-01 09:33:43'),
(103, 44, 'twitter', 87, 11, '2015-05-28 05:10:11'),
(104, 49, 'facebook', 87, 4, '2015-05-26 12:25:46'),
(105, 49, 'facebook', 88, 2, '2015-05-26 12:48:29'),
(106, 46, 'tumblr', 88, 2, '2015-05-26 13:20:55'),
(107, 37, 'twitter', 88, 2, '2015-05-28 03:41:18'),
(108, 37, 'tumblr', 88, 1, '2015-05-28 03:37:18'),
(109, 44, 'instagram', 87, 90, '2015-05-29 10:39:36'),
(110, 43, 'twitter', 88, 2, '2015-05-29 10:29:00'),
(111, 43, 'twitter', 89, 2, '2015-05-29 10:28:35'),
(112, 44, 'instagram', 89, 6, '2015-05-29 10:39:37'),
(113, 46, 'instagram', 89, 4, '2015-05-29 10:43:43'),
(114, 37, 'twitter', 89, 1, '2015-05-30 22:30:27'),
(115, 37, 'facebook', 89, 3, '2015-05-30 22:30:55'),
(116, 37, 'tumblr', 89, 1, '2015-05-30 22:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token_key` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=52 ;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token_key`, `user_id`) VALUES
(1, '', 1),
(2, '6974bca22d289a049d0c18ae0c013682', 2),
(3, '3ce04cb70239c925e44d50cddeb9db92', 3),
(4, '9e6716e94573f5046799fc27c7999751', 4),
(5, '', 5),
(6, '9ba2e7e37d2c0296b686425335cd5054', 6),
(7, 'acdc3bf424802e9376a7f39a4a3219e3', 7),
(8, '', 38),
(9, 'a742c1470a600472a1ae505a0b8cd5bc', 8),
(10, 'a742c1470a600472a1ae505a0b8cd5bc', 8),
(11, '7ba7a4cc042495352555b16b25743359', 9),
(12, 'be6d7de2083a675e5e6d63424deb26b0', 10),
(13, '', 11),
(14, 'fac03cf08f7c059b83985c600b0dd79c', 12),
(15, '5ed5512599f98e96c691e27e35da255e', 13),
(16, '910c9be3dc78ddc597145efc1e733764', 14),
(17, '97b5ccf205264d22f7a248bcf4cf5a73', 17),
(18, '', 18),
(19, 'd0586c05d8e52fd694c4560ea1009446', 19),
(20, '', 20),
(21, '4c466e1a0d8963d9771958193fa9b567', 21),
(35, '6b2f78335871286833f6d5f0e86ae44d', 35),
(29, '', 29),
(32, '70ae783b4df96c372ab6e51ec93ea7b5', 32),
(22, 'a8180df6aee8570237c3f2f2b37e3a31', 22),
(23, '5b093d46596f5d965bb204b8610f51e0', 23),
(28, '2dabac67fc19c73297dd7ffaae84586e', 28),
(24, '63b36b9931e50c383598fb8707a7529f', 24),
(25, '3eed6058e5296b438efcfc85a9261091', 25),
(26, '5e6e893105d9ee44ca20770cc2567259', 26),
(27, 'b1f10b2d33d534a389ef1094e35fe7f2', 27),
(30, '', 30),
(31, '976faa3518ee039f2ad815fa547a58de', 31),
(34, '191e4f097dd55c63ad0eff83c7dcafa0', 34),
(33, '', 33),
(36, 'b7d5fa87c01df0ffd365b20d41f378a7', 36),
(37, 'afb2c6ca4b81b8864cacf9a830a725f6', 37),
(38, '', 38),
(39, '8621656cc75f054a03e4a21cd669e5ab', 39),
(40, '2fe1c25429d0bbd8941a9605398b3af6', 40),
(41, '', 41),
(42, '8dc8d675025f811b2acb3b052577e109', 42),
(43, 'df74934906d510bc45374edc7f4c4416', 43),
(44, '6f074332cd0eca1d0c76ae6b96ef72f7', 44),
(45, '', 45),
(46, '3f4af2e73a43463141c7c16fdd4dc1ee', 46),
(47, '', 47),
(48, '094102681f7d0c28d08106dc0240da1d', 48),
(50, 'bedb9f9c87d05fd96f6850093cf7595d', 50),
(49, '', 49),
(51, 'a5b34f2446bc384c305c2a6a664bde53', 51);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fbid` bigint(20) NOT NULL,
  `twitterid` varchar(200) NOT NULL,
  `googleid` varchar(200) NOT NULL COMMENT 'same as tumbler username',
  `instagram_id` varchar(200) NOT NULL,
  `email` varchar(80) NOT NULL,
  `role` varchar(80) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `contact_number` bigint(15) NOT NULL,
  `paypal_email` varchar(50) NOT NULL,
  `tax_id` varchar(50) NOT NULL,
  `brand_name` varchar(30) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `is_live` tinyint(1) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fbid`, `twitterid`, `googleid`, `instagram_id`, `email`, `role`, `username`, `password`, `contact_number`, `paypal_email`, `tax_id`, `brand_name`, `pic`, `is_live`, `verified`, `created_on`) VALUES
(37, 0, '', '', '', 'darklyfunny@gmail.com', 'Member', 'Darklyfunny', '38756fec98f243e8f7d271af6624a983', 55555555, 'darklyfunny@gmail.com', '', 'Member', 'Img_554e1c00d2a67880.jpg', 1, 1, '2015-05-09 14:39:09'),
(38, 10100630869724144, '2904000043', 'socialchangeus', '1570922849', 'info@SocialChange.media', 'Brand', 'SocialChange', '88e926400e88f25c68edfcb985b46acc', 5555555, '', '', 'SocialChange', 'Img_554e999148a01197.jpg', 1, 1, '2015-05-09 23:40:22'),
(40, 0, '', '', '', 'jazran@yahoo.com', 'Member', 'jazran', '14b49e93fc437a1b393ba47045c7293f', 3106915000, 'jazran@yahoo.com', '', 'Member', 'Img_5551a5e795dd6743.jpg', 1, 1, '2015-05-12 07:04:21'),
(41, 0, '', '', '', 'drewryan10@gmail.com', 'Member', 'drewryan10', 'd0199f51d2728db6011945145a1b607a', 3109033747, 'drewryan10@gmail.com', '', 'Member', 'Img_5552be24ebb3a302.jpg', 1, 1, '2015-05-13 03:15:16'),
(42, 0, '', '', '', 'rachel.reyesbergano@gmail.com', 'Member', 'drchelbella', '37718a94264031b73b9b9278549d5a98', 8183916133, 'rachel.reyesbergano@gmail.com', '', 'Member', 'Img_5552e23a319c0627.jpg', 1, 1, '2015-05-13 05:34:02'),
(43, 0, '', '', '', 'sizzletoburn@live.com', 'Member', 'divadoll', 'ceb8bc5d1d1b7564314231077287d9d3', 9495008879, 'sizzletoburn@live.com', '', 'Member', 'Img_555320e53b620994.jpg', 1, 1, '2015-05-13 10:01:34'),
(44, 0, '', '', '', 'singlasheena94@gmail.com', 'Member', 'sheena', 'c4ca4238a0b923820dcc509a6f75849b', 245621356489, 'singlasheena94@gmail.com', '', 'Member', 'Img_555b0eeb85450918.jpg', 1, 1, '2015-05-19 10:26:43'),
(45, 841598152550102, '2829647142', 'richadhiman', '2028525090', 'laxmi.codebrew@gmail.com', 'Brand', '1', 'c4ca4238a0b923820dcc509a6f75849b', 456123789456, '', '', '1', 'Img_555b1c5deda70030.jpg', 1, 1, '2015-05-28 13:07:33'),
(46, 0, '', '', '', 'richadhiman.codebrew@gmail.com', 'Member', 'richa', 'c4ca4238a0b923820dcc509a6f75849b', 213456789123, 'richadhiman.codebrew@gmail.com', '', 'Member', 'Img_555b215573d45701.jpg', 1, 1, '2015-05-19 11:41:23'),
(47, 0, '', '', '', 'Jindal.ankit89@gmail.com', 'Member', 'Ankit', 'c4ca4238a0b923820dcc509a6f75849b', 123456789123, 'Jindal.ankit89@gmail.com', '', 'Member', 'Img_555d7cee5decd028.jpg', 1, 1, '2015-05-21 06:38:06'),
(48, 0, '', '', '', 'dhs@shs.shsh', 'Member', 'shhs', 'b1964e826b37068a23729ef4f8d03421', 455454545454, 'shhs@dj.jjd', '', 'Member', 'Img_555f166144487762.jpg', 0, 0, '2015-05-22 11:43:29'),
(49, 0, '', '', '', 'roohi6222@gmail.com', 'Member', 'RichaDhiman', 'c4ca4238a0b923820dcc509a6f75849b', 789456123789, 'roohi6222@gmail.com', '', 'Member', 'Img_555f2b055ba5b930.jpg', 1, 1, '2015-05-22 13:16:32'),
(50, 0, '', '', '', 'ritu.codebrew@gmail.com', 'Brand', 'ritu', 'c4ca4238a0b923820dcc509a6f75849b', 123456789123, '', '', 'ritu', 'Img_5568475d798af185.jpg', 0, 0, '2015-05-29 11:02:53'),
(51, 0, '', '', '', 'binit.codebrew@gmail.com', 'Brand', 'binit', 'c4ca4238a0b923820dcc509a6f75849b', 13245678945, '', '', 'binit', 'Img_5568491853d27560.jpg', 0, 0, '2015-05-29 11:10:16');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hash_tags`
--
ALTER TABLE `hash_tags`
  ADD CONSTRAINT `hash_tags_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_provider`
--
ALTER TABLE `social_provider`
  ADD CONSTRAINT `social_provider_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
