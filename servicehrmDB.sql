-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 03, 2020 at 03:23 PM
-- Server version: 5.7.31-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `servicehrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `delegate_manager_id` int(11) NOT NULL DEFAULT '0',
  `department_level` int(5) NOT NULL DEFAULT '0',
  `parent_department` int(11) NOT NULL DEFAULT '0',
  `visible_to_parent` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `manager_id`, `delegate_manager_id`, `department_level`, `parent_department`, `visible_to_parent`) VALUES
(1, 'HR', 8, 0, 9999, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE `leave` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `half_day` tinyint(4) NOT NULL DEFAULT '0',
  `request_date` datetime NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `reject_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave`
--

INSERT INTO `leave` (`id`, `user_id`, `type`, `start_date`, `end_date`, `half_day`, `request_date`, `approved`, `reject_reason`) VALUES
(1, 8, 'hi', '2020-08-03', '2020-08-07', 0, '2020-08-03 14:52:24', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `timestamp` datetime NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `timestamp`, `action`) VALUES
(1, 0, '2019-10-15 18:47:21', 'Successful login'),
(2, 0, '2019-10-16 18:57:12', 'Successful login'),
(3, 10, '2019-10-16 18:58:33', 'Successful login'),
(4, 10, '2019-10-16 18:59:39', 'Successful login'),
(5, 10, '2019-10-16 19:02:41', 'Successful login'),
(6, 10, '2019-10-16 19:04:55', 'Failed login attempt'),
(7, 10, '2019-10-16 19:05:11', 'Successful login'),
(8, 0, '2019-10-16 19:23:18', 'User created successfully'),
(9, 14, '2019-10-16 19:31:22', 'User created successfully'),
(10, 7, '2019-10-16 19:48:11', 'Failed login attempt'),
(11, 6, '2019-10-16 19:48:27', 'Successful login'),
(12, 7, '2019-10-28 18:18:46', 'Failed login attempt'),
(13, 8, '2019-10-28 18:19:14', 'Successful login'),
(14, 8, '2019-10-28 19:24:52', 'Successful login'),
(15, 8, '2019-10-29 10:42:22', 'Successful login'),
(16, 8, '2019-10-29 11:19:47', 'Unauthorised admin access attempt'),
(17, 8, '2019-10-29 11:19:52', 'Unauthorised admin access attempt'),
(18, 8, '2019-10-29 11:23:11', 'Unauthorised admin access attempt'),
(19, 8, '2019-10-29 11:23:12', 'Unauthorised admin access attempt'),
(20, 8, '2019-10-29 11:23:55', 'Unauthorised admin access attempt'),
(21, 8, '2019-10-29 11:24:52', 'Unauthorised admin access attempt'),
(22, 8, '2019-10-29 11:24:54', 'Unauthorised admin access attempt'),
(23, 8, '2019-10-29 11:26:14', 'Unauthorised admin access attempt'),
(24, 8, '2019-10-29 11:26:15', 'Unauthorised admin access attempt'),
(25, 6, '2020-01-29 15:08:51', 'Failed login attempt'),
(26, 6, '2020-01-29 15:10:57', 'Successful login'),
(27, 6, '2020-02-01 17:13:24', 'Successful login'),
(28, 7, '2020-02-01 18:28:11', 'Failed login attempt'),
(29, 6, '2020-02-01 18:29:35', 'Successful login'),
(30, 6, '2020-02-01 18:29:54', 'Successful login'),
(31, 6, '2020-02-01 18:32:31', 'Successful login'),
(32, 8, '2020-02-03 16:29:52', 'Successful login'),
(33, 8, '2020-02-03 18:13:25', 'Successful login'),
(34, 8, '2020-02-04 16:09:05', 'Successful login'),
(35, 8, '2020-02-04 16:47:38', 'Successful login'),
(36, 8, '2020-02-07 14:08:02', 'Successful login'),
(37, 8, '2020-02-11 15:09:10', 'Successful login'),
(38, 8, '2020-02-11 15:58:07', 'Successful login'),
(39, 8, '2020-02-12 16:52:52', 'Successful login'),
(40, 8, '2020-08-03 14:51:37', 'Successful login');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `text` varchar(255) NOT NULL,
  `viewed` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `date`, `text`, `viewed`, `deleted`) VALUES
(1, 8, '2020-08-03 14:58:30', 'Your recent leave request has been approved - see the leave planner for more information.', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `account_locked` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `HR_dept` tinyint(1) NOT NULL DEFAULT '0',
  `department_id` tinyint(1) NOT NULL DEFAULT '0',
  `job_title` varchar(255) NOT NULL DEFAULT 'Employee',
  `holiday_entitlement` double(3,2) NOT NULL DEFAULT '5.60',
  `salary` double(9,2) NOT NULL DEFAULT '0.00',
  `pay_period` varchar(255) NOT NULL DEFAULT 'monthly',
  `weekly_hours` double(5,2) NOT NULL DEFAULT '0.00',
  `address_1` varchar(30) DEFAULT NULL,
  `address_2` varchar(30) DEFAULT NULL,
  `address_3` varchar(30) DEFAULT NULL,
  `address_4` varchar(30) DEFAULT NULL,
  `post_code` varchar(8) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `f_name`, `s_name`, `date_created`, `account_locked`, `admin`, `HR_dept`, `department_id`, `job_title`, `holiday_entitlement`, `salary`, `pay_period`, `weekly_hours`, `address_1`, `address_2`, `address_3`, `address_4`, `post_code`, `contact_number`) VALUES
(6, 'root@localhost.com', '$2y$10$ZHiR958G6WfWCAf/60S1KO1yjvOYm64lKA.N5XfjRSk44glmwwOB.', 'test', 'test', '2019-10-12 19:47:44', 0, 0, 0, 0, '', 5.60, 0.00, 'monthly', 0.00, '', '', '', '', '', ''),
(7, 'josh@email.com', '$2y$10$hd.S6hU7IfpsY8G2AU31QufajHL5Zr.WLKIbQhCMmroUpqWv6Bgfy', 'Test', 'User', '2019-10-12 19:48:19', 0, 0, 0, 0, '', 5.60, 0.00, 'monthly', 0.00, '', '', '', '', '', ''),
(8, 'email@email.com', '$2y$10$oWmOUzn/.VqagMF02J6L.u9nl9cL0/NNUa/3dnxDMNXcK7bQvq.4y', 'HR', 'Administrator', '2019-10-15 18:27:35', 0, 1, 1, 1, 'Admin', 5.60, 30000.65, 'monthly', 37.50, '1 Road', '', 'Preston', 'Lancashire', 'PR1 1PR', '0123456789'),
(9, 'email2@email.com', '$2y$10$E21IMl/BYHRLTWfIpXSSVeVLLXMrcsyXg/avIoJUn.GG4/ADCnRza', 'Test', 'User', '2019-10-15 18:41:36', 0, 0, 0, 0, '', 5.60, 0.00, 'monthly', 0.00, '', '', '', '', '', ''),
(10, 'logtest@email.com', '$2y$10$g/cBeVv4HduVEkwUK3rsZOL3NNAq2IvTmkNR7M4dHTZU3L5OLPvO2', 'Log', 'Test', '2019-10-16 18:48:15', 0, 0, 0, 0, '', 5.60, 0.00, 'monthly', 0.00, '', '', '', '', '', ''),
(11, 'logtest@email.com', '$2y$10$iPh4sNVfWsW2HnOeab4wQu80wEHIIQ18jStGbXP2RUKXxf6NrrAYe', 'Log', 'Test', '2019-10-16 18:54:58', 0, 0, 0, 0, '', 5.60, 0.00, 'monthly', 0.00, '', '', '', '', '', ''),
(12, 'logtest@email.com', '$2y$10$EIHuyw8L0F1tqmW5gbK96OescxL0xcU3lHcuzayQoF5ltDElYayUK', 'Log', 'Test', '2019-10-16 18:57:12', 0, 0, 0, 0, '', 5.60, 0.00, 'monthly', 0.00, '', '', '', '', '', ''),
(13, 'dupemailtest@email.com', '$2y$10$9UvRE5BPBJej1535h3iqJ.uuB0LZQLvgTHhXfUUqTGFaYgBQNsF/u', 'Duplicate', 'Test', '2019-10-16 19:23:18', 0, 0, 0, 0, '', 5.60, 0.00, 'monthly', 0.00, '', '', '', '', '', ''),
(14, 'idtest@email.com', '$2y$10$RbsDpFMMJX846OIClO2kWO8nUtz9BLpT2ZaoAh/yfJkJi0HvpaPn.', 'ID', 'Test', '2019-10-16 19:31:22', 0, 0, 0, 0, '', 5.60, 0.00, 'monthly', 0.00, '', '', '', '', '', ''),
(15, 'new@email.com', '$2y$10$lU31QYEtoij4cR7dp0luvelJ3BhBJChgoUccqjfdRBC4fXXJjVewm', '3August', 'NewUser', '2020-08-03 15:15:03', 0, 0, 0, 0, 'New User', 5.60, 0.00, 'monthly', 0.00, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave`
--
ALTER TABLE `leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `leave`
--
ALTER TABLE `leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
