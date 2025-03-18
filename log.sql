-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2023 at 11:48 AM
-- Server version: 8.0.27
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `log`
--

-- --------------------------------------------------------

--
-- Table structure for table `cell_data`
--

CREATE TABLE `cell_data` (
  `id` int NOT NULL,
  `cell_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `max` int DEFAULT NULL,
  `booked` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cell_data`
--

INSERT INTO `cell_data` (`id`, `cell_no`, `max`, `booked`) VALUES
(1, 'A101', 2, 1),
(2, 'A102', 5, 0),
(3, 'A103', 2, NULL),
(4, 'A104', 2, NULL),
(5, 'A105', 2, NULL),
(6, 'A106', 2, NULL),
(7, 'A107', NULL, NULL),
(8, 'A108', NULL, NULL),
(9, 'A109', NULL, NULL),
(10, 'A110', NULL, NULL),
(11, 'A111', NULL, NULL),
(12, 'A112', NULL, NULL),
(13, 'A113', NULL, NULL),
(14, 'A114', NULL, NULL),
(15, 'A115', NULL, NULL),
(16, 'A1166', 150, 1),
(17, 'A12', 50, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chegg_answers`
--

CREATE TABLE `chegg_answers` (
  `id` int NOT NULL,
  `Q_Link` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `A_Link` varchar(3500) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chegg_answers`
--

INSERT INTO `chegg_answers` (`id`, `Q_Link`, `A_Link`) VALUES
(1, 'https://www.chegg.com/homework-help/questions-and-answers/design-disinfection-tanks-chlorination-tank-water-treatment-plant-designed-supply-daily-fl-q50562069', 'gAnei_302336396_470108291689002_4188615182933673042_n.jpg'),
(2, 'https://www.chegg.com/homework-help/questions-and-answers/estimate-constant-rate-withdrawal-1375-ha-reservoir-month-30-days-reservoir-level-dropped--q55389369?trackid=17b5eb98262d&strackid=610b3e587f52', 'jE2lg_301316294_414875287450742_4519288778897939598_n.jpg'),
(3, 'https://www.chegg.com/homework-help/questions-and-answers/check-weather-65-following-figure-pending-pending-enable-65-without-affecting-interrupt-d7-q97879385', 'EKBKG_ben.10.omniverse.s01e01.the.more.things.change.pt.1.720p.web-dl.x264-pahe.in-thumb.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chegg_question`
--

CREATE TABLE `chegg_question` (
  `id` int NOT NULL,
  `Unique_ID` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `User_ID` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `Q_Link` varchar(3500) COLLATE utf8mb4_general_ci NOT NULL,
  `Unique_Q_Link` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `Create_Time` datetime NOT NULL,
  `Status` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chegg_question`
--

INSERT INTO `chegg_question` (`id`, `Unique_ID`, `User_ID`, `Q_Link`, `Unique_Q_Link`, `Create_Time`, `Status`) VALUES
(1, '83dceee182677d1740c454a682ff3b6c', '83dceee182677d1740c454a682ff3b6c', 'https://www.chegg.com/homework-help/questions-and-answers/estimate-constant-rate-withdrawal-1375-ha-reservoir-month-30-days-reservoir-level-dropped--q55389369?trackid=17b5eb98262d&strackid=610b3e587f52', '/RxIVgJafllK1LakDz7Sqtasf1FQOVTuGeU3UCvIeOgv1SI3SIEzCLrcpNE2psFjzakHAZ7DzIPXCN++Xg+SLlCA4VH905j7AYpZlPEGp/NeTYgYZWdm2teCkwHCjxGApXXmjKashwrYpfhsklzTvN6RStI2yYYB2LtuAk0m/1xIrlH2W+PwU/KRnHqKZLcaeq4droH617FOy7VQenzKvoqGWLgKonc+gwr/pOHaJ2/+fZdu/r+o+VcWa3Q24lp6s6pAleQCmsOt', '2022-09-10 20:05:30', 'Done'),
(2, '64f5f5c363bce9a92dcef28205ab9051', '64f5f5c363bce9a92dcef28205ab9051', 'https://www.chegg.com/homework-help/questions-and-answers/design-disinfection-tanks-chlorination-tank-water-treatment-plant-designed-supply-daily-fl-q50562069', '/RxIVgJafllK1LakDz7Sqtasf1FQOVTuGeU3UCvIeOgv1SI3SIEzCLrcpNE2psFjzakHAZ7DzIPXCN6oWQ+YIQmBpUH7043qA5BE1u1Kp/cdUZJBbmt41NKKkU2H1UnbpWnmz7/kgw7etuUolAPbssSIR5Fx1NsJ2KxpAlsm/1Bdtlv7BL3pRvSYiXqKd7EGc+Yf74H617RIxb5Tenw=', '2022-09-10 20:06:04', 'Done'),
(3, '7e5d10eaf21bca9f52283980f25e3022', '7e5d10eaf21bca9f52283980f25e3022', 'https://www.chegg.com/homework-help/questions-and-answers/check-weather-65-following-figure-pending-pending-enable-65-without-affecting-interrupt-d7-q97879385', '/RxIVgJafllK1LakDz7Sqtasf1FQOVTuGeU3UCvIeOgv1SI3SIEzCLrcpNE2psFjzakHAZ7DzIPXCNmlTwWUYlOArUb62JmiVtEA3+wLv/kEU48LIGV93NWRmgGD2UjR4XPgjKSsmgvDvfAohR/fsdyAD8kw1NwMzapyWktu7V9cvV3rQKD7G+2ahDKcZK0afuYdtIH627NFxLVQdHA=', '2022-09-11 20:51:03', 'Done');

-- --------------------------------------------------------

--
-- Table structure for table `crime`
--

CREATE TABLE `crime` (
  `id` int NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crime`
--

INSERT INTO `crime` (`id`, `value`, `name`, `status`) VALUES
(1, 'checking', 'Checking', 'yes'),
(2, 'ok', 'OK', 'yes'),
(3, 'checking1111111111111111111', 'Checking1111111111111111111', 'yes'),
(4, 'kidnapping', 'kidnapping', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `division` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `division`) VALUES
(1, 'Dhaka', 'Dhaka Division'),
(2, 'Gazipur', 'Dhaka Division'),
(3, 'Narayanganj', 'Dhaka Division'),
(4, 'Narsingdi', 'Dhaka Division'),
(5, 'Manikganj', 'Dhaka Division'),
(6, 'Tangail', 'Dhaka Division'),
(7, 'Mymensingh', 'Mymensingh Division'),
(8, 'Jamalpur', 'Mymensingh Division'),
(9, 'Sherpur', 'Mymensingh Division'),
(10, 'Netrokona', 'Mymensingh Division'),
(11, 'Chittagong', 'Chittagong Division'),
(12, 'Comilla', 'Chittagong Division'),
(13, 'Feni', 'Chittagong Division'),
(14, 'Noakhali', 'Chittagong Division'),
(15, 'Rangamati', 'Chittagong Division'),
(16, 'Khagrachari', 'Chittagong Division'),
(17, 'Bandarban', 'Chittagong Division'),
(18, 'Cox\'s Bazar', 'Chittagong Division'),
(19, 'Sylhet', 'Sylhet Division'),
(20, 'Moulvibazar', 'Sylhet Division'),
(21, 'Habiganj', 'Sylhet Division'),
(22, 'Sunamganj', 'Sylhet Division'),
(23, 'Rajshahi', 'Rajshahi Division'),
(24, 'Naogaon', 'Rajshahi Division'),
(25, 'Natore', 'Rajshahi Division'),
(26, 'Sirajganj', 'Rajshahi Division'),
(27, 'Pabna', 'Rajshahi Division'),
(28, 'Bogra', 'Rajshahi Division'),
(29, 'Khulna', 'Khulna Division'),
(30, 'Jessore', 'Khulna Division'),
(31, 'Satkhira', 'Khulna Division'),
(32, 'Kushtia', 'Khulna Division'),
(33, 'Magura', 'Khulna Division'),
(34, 'Narail', 'Khulna Division'),
(35, 'Chuadanga', 'Khulna Division'),
(36, 'Meherpur', 'Khulna Division'),
(37, 'Rangpur', 'Rangpur Division'),
(38, 'Nilphamari', 'Rangpur Division'),
(39, 'Lalmonirhat', 'Rangpur Division'),
(40, 'Kurigram', 'Rangpur Division'),
(41, 'Gaibandha', 'Rangpur Division'),
(42, 'Thakurgaon', 'Rangpur Division'),
(43, 'Panchagarh', 'Rangpur Division'),
(44, 'Bagerhat', 'Khulna Division'),
(45, 'Jhenaidah', 'Khulna Division'),
(46, 'Madaripur', 'Dhaka Division'),
(47, 'Shariatpur', 'Dhaka Division'),
(48, 'Rajbari', 'Dhaka Division'),
(49, 'Kishoreganj', 'Dhaka Division'),
(50, 'Faridpur', 'Dhaka Division'),
(51, 'Gopalganj', 'Dhaka Division'),
(52, 'Bhola', 'Barisal Division'),
(53, 'Patuakhali', 'Barisal Division'),
(54, 'Pirojpur', 'Barisal Division'),
(55, 'Jhalokati', 'Barisal Division'),
(56, 'Barisal', 'Barisal Division'),
(57, 'Barguna', 'Barisal Division');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int NOT NULL,
  `page_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `page_link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `page_name`, `page_link`, `role`, `status`) VALUES
(11, 'Prisoner Management', 'prison/index.php', 'admin', 'yes'),
(12, 'Prisoner Management', 'prison/index.php', 'officer', 'no'),
(13, 'Prisoner Management', 'prison/index.php', 'administrator', 'yes'),
(21, 'Approve', 'approve/approve.php', 'admin', 'yes'),
(22, 'Approve', 'approve/approve.php', 'officer', 'yes'),
(23, 'Approve', 'approve/approve.php', 'administrator', 'yes'),
(31, 'Administrator Management', 'administrator/administrator.php', 'admin', 'yes'),
(41, 'Officer Management', 'office/officer.php', 'administrator', 'no'),
(42, 'Officer Management', 'office/officer.php', 'admin', 'yes'),
(51, 'Guard Management', 'guard/guard.php', 'administrator ', 'yes'),
(52, 'Guard Management', 'guard/guard.php', 'admin', 'yes'),
(61, 'Staff Management', 'staff/staff.php', 'administrator', 'yes'),
(62, 'Staff Management', 'staff/staff.php', 'admin', 'yes'),
(71, 'Visitor Management', 'visit/visitor.php', 'admin                     ', 'yes'),
(72, 'Visitor Management', 'visit/visitor.php', 'administrator', 'yes'),
(73, 'Visitor Management', 'visit/visitor.php', 'officer ', 'yes'),
(74, 'Visitor Management', 'visit/visitor.php', 'guard', 'yes'),
(81, 'Cell Block Management', 'cell/cell_block.php', 'admin', 'yes'),
(91, 'Crime Management', 'crime/crime_list.php', 'admin', 'yes'),
(92, 'Crime Management', 'crime/crime_list.php', 'administrator', 'yes'),
(104, 'Crime Management', 'crime/crime_list.php', 'officer', 'yes'),
(111, 'Web Settings', 'web/', 'admin', 'yes'),
(121, 'Visiting request ', 'visit/req_visit.php', 'visitor', 'yes'),
(122, 'Requests', 'request/request.php', 'admin', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `meta_data`
--

CREATE TABLE `meta_data` (
  `id` int NOT NULL,
  `meta_field` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `meta_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meta_data`
--

INSERT INTO `meta_data` (`id`, `meta_field`, `meta_value`) VALUES
(21, 'need', 'You are not allow to access.\r\nSubmit your relevant document to approve your account.'),
(22, 'doc_upload_only', 'Thanks for submitting your relevant document.\r\nYou will get verified very soon if your relevant document is ok.'),
(25, 'reject', 'your verification is rejected.'),
(26, 'yes', '');

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE `msg` (
  `id` int NOT NULL,
  `sender` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reciver` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text` text COLLATE utf8mb4_general_ci,
  `seen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msg`
--

INSERT INTO `msg` (`id`, `sender`, `reciver`, `text`, `seen`, `time`) VALUES
(17, 'e6c1bdddfbaa02ab50fadbc8a8ae9026', 'e8e4eafcd8e0ea7169bd104466174247', 'submit all documents', '0', '2023-05-15 01:02:09');

-- --------------------------------------------------------

--
-- Table structure for table `prisoner_list`
--

CREATE TABLE `prisoner_list` (
  `id` int NOT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cell_no` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `visitor` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prisoner_img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `dob` date DEFAULT NULL,
  `marital` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `complexion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `eye` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `crimes` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sentence` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL,
  `emergency_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `emergency_phone` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `emergency_relation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prisoner_list`
--

INSERT INTO `prisoner_list` (`id`, `unique_id`, `cell_no`, `visitor`, `name`, `prisoner_img`, `address`, `dob`, `marital`, `complexion`, `eye`, `crimes`, `sentence`, `start_time`, `end_time`, `emergency_name`, `emergency_phone`, `emergency_relation`) VALUES
(8, '1684090583', 'A101', 'allow', 'prisoner1', 'prisoner_img/1684090583_Rerej_admin_acq5j_screenshot_2023-03-08-19-01-31-92_9a0991d06c39f5556bb727ecc6fd035e.jpg', 'Dhaka', '2023-05-31', 'married', 'fair', 'black', 'kindnap', '5', '2023-05-15', '2023-05-20', 'Emergency Contact ', '017777777777', 'Uncle'),
(9, '1684483237', 'A1166', 'allow', 'Prisoner2', 'prisoner_img/1684483237_yGyru_img-7621.jpg', 'Prisoner2', '2023-05-26', 'Prisoner2', 'Prisoner2', 'Prisoner2', 'checking, ok, checking1111111111111111111', '1', '2023-06-10', '2023-06-09', 'Prisoner2 of Emergency Contact Name:', '5555', 'uncle');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` int NOT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `msg` text COLLATE utf8mb4_general_ci,
  `time` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `unique_id`, `msg`, `time`) VALUES
(1, '1684090583', 'b olockkgv', '2023-05-19'),
(2, '1684090583', 'check', '2023-05-19'),
(3, '1684090583', 'aaaaaaaaaaaaaaaaaaa', '2023-05-19'),
(4, '1684483237', '1', '2023-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int NOT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prisoner_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `relation` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `req` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `approve` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `who` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `to_time` time DEFAULT NULL,
  `to_data` date DEFAULT NULL,
  `from_time` time DEFAULT NULL,
  `from_data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `unique_id`, `prisoner_id`, `name`, `dob`, `relation`, `img`, `req`, `approve`, `text`, `who`, `to_time`, `to_data`, `from_time`, `from_data`) VALUES
(10, '75f055a2da55469f88becb11d745cd8e', '1684090583', 'avdva', '2023-05-30', 'Relation', 'request/1684090583_jT2n1_admin_1sjmm_signin-image.jpg', '1', 'reject', NULL, NULL, '17:52:00', '2023-06-08', '17:53:00', '2023-06-07');

-- --------------------------------------------------------

--
-- Table structure for table `rule_names`
--

CREATE TABLE `rule_names` (
  `id` int NOT NULL,
  `value_rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rule_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `audience` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rule_names`
--

INSERT INTO `rule_names` (`id`, `value_rule`, `rule_name`, `audience`) VALUES
(1, 'visitor', 'visitor', 'public'),
(2, 'staff', 'staff', 'public'),
(3, 'officer', 'officer', 'public'),
(4, 'administrator', 'administrator', 'public'),
(5, 'lawyer', 'Lawyer', 'public'),
(15, 'guard', 'guard', 'public');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `unique_id_php` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `verification` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `login_attempt` int NOT NULL,
  `block` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inert_time` timestamp NOT NULL,
  `approved` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `who_approved` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doc` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `unique_id_php`, `full_name`, `email`, `password`, `verification`, `role`, `login_attempt`, `block`, `inert_time`, `approved`, `who_approved`, `img`, `doc`) VALUES
(1, 'e6c1bdddfbaa02ab50fadbc8a8ae9026', 'Admin', 'root', 'pFoP', '1', 'admin', 0, 'no', '2022-05-13 16:39:13', 'yes', NULL, 'user_img/Admin_1SjMm_signin-image.jpg', 'user_doc/Admin_0d7rj_aaaaaa_fzntk_admin_acnlr_1681904232639.jpg'),
(48, 'e8e4eafcd8e0ea7169bd104466174247', 'admin1', 'admin1', '9AxRTx9R', '1', 'administrator', 0, 'no', '2023-05-14 18:27:58', 'yes', 'Admin', NULL, NULL),
(49, 'bf44568ee709f4e0581129fdc11d008d', 'admin2', 'admin2', '9AxRTx9S', '1', 'administrator', 0, 'no', '2023-05-14 18:28:52', 'need', NULL, NULL, NULL),
(50, '3b7b7bd663ae52d56b066345e9b075fe', 'admin3', 'admin3', '9AxRTx9T', '1', 'administrator', 0, 'no', '2023-05-14 18:29:14', 'need', NULL, NULL, NULL),
(51, '75f055a2da55469f88becb11d745cd8e', 'visitor1', 'visitor1', '4wFPTwUPI0c=', '1', 'visitor', 0, 'no', '2023-05-14 18:30:17', 'yes', 'Admin', NULL, NULL),
(52, 'ea38d21db513c503554df698df2268ac', 'visitor2', 'visitor2', '4wFPTwUPI0Q=', '1', 'visitor', 0, 'no', '2023-05-14 18:30:40', 'need', NULL, NULL, NULL),
(53, '7563dc764ca4caacd99be44eee2fd866', 'visitor3', 'visitor3', '4wFPTwUPI0U=', '1', 'visitor', 0, 'no', '2023-05-14 18:31:10', 'need', NULL, NULL, NULL),
(54, '35ece8aae894e8979d4b7dcd01670e4d', 'staff1', 'staff1', '5hxdQBdR', '1', 'staff', 0, 'no', '2023-05-14 18:31:33', 'yes', 'Admin', NULL, NULL),
(55, '4faa3aeec152fc794fd51b99e8562789', 'staff2', 'staff2', '5hxdQBdS', '1', 'staff', 0, 'no', '2023-05-14 18:31:59', 'need', NULL, NULL, NULL),
(56, 'd53b0c9c8fd3df353a453eca13870e6b', 'staff3', 'staff3', '5hxdQBdT', '1', 'staff', 0, 'no', '2023-05-14 18:32:22', 'need', NULL, NULL, NULL),
(57, '78efcafd4548c3ea56436d3ba9749a5c', 'officer1', 'officer1', '+g5aTxIFI0c=', '1', 'officer', 0, 'no', '2023-05-14 18:33:08', 'yes', 'Admin', NULL, NULL),
(58, '38142509bf283af0c440cdf6c03d9a1e', 'officer2', 'officer2', '+g5aTxIFI0Q=', '1', 'officer', 0, 'no', '2023-05-14 18:33:29', 'need', NULL, NULL, NULL),
(59, '88fb49d05f784096bcfb6e7fd2fa83ce', 'officer3', 'officer3', '+g5aTxIFI0U=', '1', 'officer', 0, 'no', '2023-05-14 18:33:49', 'need', NULL, NULL, NULL),
(60, '7ecd85c183a22da1d463974f787722b8', 'lawyer1', 'lawyer1', '+QlLXxQSYA==', '1', 'lawyer', 0, 'no', '2023-05-14 18:34:22', 'yes', 'Admin', NULL, NULL),
(61, '1f1cd6a5cdb13ffb7c3d483b71683e3e', 'lawyer2', 'lawyer2', '+QlLXxQSYw==', '1', 'lawyer', 0, 'no', '2023-05-14 18:34:45', 'need', NULL, NULL, NULL),
(62, 'eccc485dc4d63980bdd0a10774548498', 'lawyer3', 'lawyer3', '+QlLXxQSYg==', '1', 'lawyer', 0, 'no', '2023-05-14 18:35:06', 'need', NULL, NULL, NULL),
(63, 'd4bfb5ca565e3bb943fc515f4f8805d7', 'guard1', 'guard1', '8h1dVBVR', '1', 'guard', 0, 'no', '2023-05-14 18:35:39', 'doc_upload_only', 'Admin', NULL, 'user_doc/guard1_pGCxK_1.jpg'),
(64, 'c286bd33ac2ff97a3f8d6cf4f0ccdba0', 'guard2', 'guard2', '8h1dVBVS', '1', 'guard', 0, 'no', '2023-05-14 18:36:00', 'need', NULL, NULL, NULL),
(65, 'a802e70159ffed9d155e848f89f5d20f', 'guard3', 'guard3', '8h1dVBVT', '1', 'guard', 0, 'no', '2023-05-14 18:36:20', 'need', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_meta`
--

CREATE TABLE `users_meta` (
  `id` int NOT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone_number` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `city` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `dob` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `marital_status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_meta`
--

INSERT INTO `users_meta` (`id`, `unique_id`, `phone_number`, `gender`, `address`, `city`, `dob`, `marital_status`) VALUES
(9, 'd4bfb5ca565e3bb943fc515f4f8805d7', '12347', 'male', 'Address Demo', 'Cox\'s Bazar', '2023-05-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `id` int NOT NULL,
  `unique_id_php` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_verify` int DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone_verify` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verify`
--

INSERT INTO `verify` (`id`, `unique_id_php`, `email`, `email_verify`, `phone`, `phone_verify`) VALUES
(98, 'd4bfb5ca565e3bb943fc515f4f8805d7', NULL, NULL, '12347', 978930);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cell_data`
--
ALTER TABLE `cell_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chegg_answers`
--
ALTER TABLE `chegg_answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Q_Link` (`Q_Link`);

--
-- Indexes for table `chegg_question`
--
ALTER TABLE `chegg_question`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Unique_ID` (`Unique_ID`);

--
-- Indexes for table `crime`
--
ALTER TABLE `crime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta_data`
--
ALTER TABLE `meta_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prisoner_list`
--
ALTER TABLE `prisoner_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rule_names`
--
ALTER TABLE `rule_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id_php` (`unique_id_php`);

--
-- Indexes for table `users_meta`
--
ALTER TABLE `users_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cell_data`
--
ALTER TABLE `cell_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `chegg_answers`
--
ALTER TABLE `chegg_answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chegg_question`
--
ALTER TABLE `chegg_question`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `crime`
--
ALTER TABLE `crime`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `meta_data`
--
ALTER TABLE `meta_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `msg`
--
ALTER TABLE `msg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `prisoner_list`
--
ALTER TABLE `prisoner_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rule_names`
--
ALTER TABLE `rule_names`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users_meta`
--
ALTER TABLE `users_meta`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `verify`
--
ALTER TABLE `verify`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
