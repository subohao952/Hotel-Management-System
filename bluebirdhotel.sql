-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2025-06-26 23:37:07
-- 服务器版本： 8.0.12
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `bluebirdhotel`
--

-- --------------------------------------------------------

--
-- 表的结构 `emp_login`
--

CREATE TABLE `emp_login` (
  `empid` int(100) NOT NULL,
  `Emp_Email` varchar(50) NOT NULL,
  `Emp_Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `emp_login`
--

INSERT INTO `emp_login` (`empid`, `Emp_Email`, `Emp_Password`) VALUES
(1, 'Admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE `payment` (
  `id` int(30) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `RoomType` varchar(30) NOT NULL,
  `Bed` varchar(30) NOT NULL,
  `NoofRoom` int(30) NOT NULL,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `noofdays` int(30) NOT NULL,
  `roomtotal` double(8,2) NOT NULL,
  `bedtotal` double(8,2) NOT NULL,
  `meal` varchar(30) NOT NULL,
  `mealtotal` double(8,2) NOT NULL,
  `finaltotal` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`id`, `Name`, `Email`, `RoomType`, `Bed`, `NoofRoom`, `cin`, `cout`, `noofdays`, `roomtotal`, `bedtotal`, `meal`, `mealtotal`, `finaltotal`) VALUES
(95, '21231232133', 'tusharpankhaniya2202@gmail.com', 'Superior Room', 'Single', 1, '2025-06-06', '2025-06-07', 1, 450.00, 4.50, 'Room only', 0.00, 454.50),
(101, '3213213321321', 'tusharpankhaniya2202@gmail.com', 'Deluxe Room', 'Double', 1, '2025-06-26', '2025-06-28', 2, 600.00, 12.00, 'Breakfast', 24.00, 636.00),
(102, '23133213', 'tusharpankhaniya2202@gmail.com', 'Deluxe Room', 'Triple', 1, '2025-06-26', '2025-06-27', 1, 300.00, 9.00, 'Full Board', 36.00, 392.98),
(103, '3213213323123', 'tusharpankhaniya2202@gmail.com', 'Single Room', 'Double', 1, '2025-05-27', '2025-05-29', 2, 300.00, 6.00, 'Half Board', 18.00, 337.98),
(106, '3213231', 'tusharpankhaniya2202@gmail.com', 'Guest House', 'Quad', 1, '2025-06-13', '2025-06-14', 1, 220.00, 8.80, 'Full Board', 35.20, 264.00),
(110, 'suhdsad', 'tusharpankhaniya2202@gmail.com', 'Superior Room', 'Single', 1, '2025-06-21', '2025-06-22', 1, 450.00, 4.50, 'Room only', 0.00, 459.00),
(112, '2', 'tusharpankhaniya2202@gmail.com', 'Guest House', 'Single', 1, '2025-06-24', '2025-06-25', 1, 220.00, 2.20, 'Room only', 0.00, 222.20),
(115, 'Reena', 'vishwa26317@gmail.com', 'Deluxe Room', 'Double', 2, '2025-08-01', '2025-08-05', 4, 2400.00, 24.00, 'Breakfast', 48.00, 2519.98);

-- --------------------------------------------------------

--
-- 表的结构 `room`
--

CREATE TABLE `room` (
  `id` int(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `bedding` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `room`
--

INSERT INTO `room` (`id`, `type`, `bedding`) VALUES
(31, '', ''),
(32, '', ''),
(33, '', ''),
(34, '', ''),
(35, '', ''),
(36, '', ''),
(37, '', ''),
(38, '', ''),
(39, '', ''),
(40, '', ''),
(41, '', ''),
(42, '', ''),
(48, 'Superior Room', 'Double'),
(49, 'Superior Room', 'Single'),
(51, 'Deluxe Room', 'Triple'),
(52, 'Superior Room', 'Triple'),
(54, 'Guest House', 'Double'),
(55, 'Deluxe Room', 'Double'),
(56, 'Superior Room', 'Quad'),
(57, '', ''),
(58, 'Guest House', 'Single'),
(59, 'Guest House', 'Quad'),
(61, 'Single Room', 'Single');

-- --------------------------------------------------------

--
-- 表的结构 `roombook`
--

CREATE TABLE `roombook` (
  `id` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Country` varchar(30) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `RoomType` varchar(30) NOT NULL,
  `Bed` varchar(30) NOT NULL,
  `Meal` varchar(30) NOT NULL,
  `NoofRoom` varchar(30) NOT NULL,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `nodays` int(50) NOT NULL,
  `stat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `roombook`
--

INSERT INTO `roombook` (`id`, `Name`, `Email`, `Country`, `Phone`, `RoomType`, `Bed`, `Meal`, `NoofRoom`, `cin`, `cout`, `nodays`, `stat`) VALUES
(95, '21231232133', 'tusharpankhaniya2202@gmail.com', 'Afghanistan', '21212', 'Superior Room', 'Single', 'Room only', '1', '2025-06-06', '2025-06-07', 1, 'Confirm'),
(97, '212', 'tusharpankhaniya2202@gmail.com', 'Albania', '21', 'Superior Room', 'Single', 'Room only', '1', '2025-07-04', '2025-07-05', 1, 'NotConfirm'),
(101, '3213213321321', 'tusharpankhaniya2202@gmail.com', 'Algeria', '23133213', 'Deluxe Room', 'Double', 'Breakfast', '1', '2025-06-26', '2025-06-28', 2, 'Confirm'),
(108, 'dasd', 'tusharpankhaniya2202@gmail.com', 'Albania', '3213', 'Deluxe Room', 'Single', 'Room only', '1', '2025-06-20', '2025-06-26', 6, 'Confirm'),
(111, '212', 'tusharpankhaniya2202@gmail.com', 'Afghanistan', '12112', 'Superior Room', 'Single', 'Room only', '1', '2025-06-24', '2025-06-25', 1, 'NotConfirm'),
(113, 'hahahaha', 'tusharpankhaniya2202@gmail.com', 'Albania', '2312', 'Superior Room', 'Single', 'Room only', '1', '2025-06-25', '2025-06-28', 3, 'Confirm'),
(114, 'dsad', 'tusharpankhaniya2202@gmail.com', 'Albania', '21313', 'Deluxe Room', 'Double', 'Room only', '1', '2025-06-25', '2025-06-26', 1, 'NotConfirm'),
(115, 'Reena', 'vishwa26317@gmail.com', 'United Kingdom', '123456789', 'Deluxe Room', 'Double', 'Breakfast', '2', '2025-08-01', '2025-08-05', 4, 'Confirm'),
(116, '21', 'tusharpankhaniya2202@gmail.com', 'Algeria', '32131', 'Guest House', 'Triple', '', '1', '2025-06-26', '2025-06-27', 1, 'NotConfirm'),
(117, 'hello', 'tusharpankhaniya2202@gmail.com', 'Argentina', '1232443', 'Single Room', 'Single', 'Room only', '1', '2025-06-26', '2025-06-28', 2, 'NotConfirm');

-- --------------------------------------------------------

--
-- 表的结构 `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `clean` time DEFAULT NULL,
  `pool` time DEFAULT NULL,
  `food` decimal(10,2) DEFAULT '0.00',
  `total` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `service`
--

INSERT INTO `service` (`id`, `clean`, `pool`, `food`, `total`) VALUES
(95, NULL, NULL, NULL, '0.00'),
(97, NULL, NULL, '14.97', '14.97'),
(99, '02:02:00', '02:02:00', '65.41', '0.00'),
(100, '02:02:00', '03:03:00', '5.99', '35.99'),
(101, NULL, NULL, NULL, '0.00'),
(102, '02:02:00', '02:21:00', '17.98', '47.98'),
(103, '02:02:00', NULL, '3.98', '13.98'),
(110, NULL, NULL, '4.50', '4.50'),
(111, '02:02:00', NULL, '0.00', '10.00'),
(113, '11:00:00', NULL, '17.98', '27.98'),
(115, '12:00:00', '02:00:00', '17.98', '47.98'),
(117, NULL, NULL, '0.00', '0.00');

-- --------------------------------------------------------

--
-- 表的结构 `signup`
--

CREATE TABLE `signup` (
  `UserID` int(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `signup`
--

INSERT INTO `signup` (`UserID`, `Username`, `Email`, `Password`) VALUES
(1, 'Tushar Pankhaniya', 'tusharpankhaniya2202@gmail.com', '202cb962ac59075b964b07152d234b70'),
(7, '11111', '32@3213.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(10, 'subohao', '1234@gmail.com', '202cb962ac59075b964b07152d234b70'),
(11, 'Reena', 'vishwa26317@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759');

-- --------------------------------------------------------

--
-- 表的结构 `staff`
--

CREATE TABLE `staff` (
  `id` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `work` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 转存表中的数据 `staff`
--

INSERT INTO `staff` (`id`, `name`, `work`) VALUES
(3, 'rohit patel', 'Cook'),
(5, 'tirth', 'Helper'),
(6, 'mohan', 'Helper'),
(7, 'shyam', 'cleaner'),
(8, 'rohan', 'weighter'),
(9, 'hiren', 'weighter'),
(10, 'nikunj', 'weighter'),
(11, 'rekha', 'Cook'),
(15, 'mike', 'weighter'),
(17, 'Alice', 'Manager'),
(18, 'Harry Potter', 'Manager');

--
-- 转储表的索引
--

--
-- 表的索引 `emp_login`
--
ALTER TABLE `emp_login`
  ADD PRIMARY KEY (`empid`);

--
-- 表的索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `roombook`
--
ALTER TABLE `roombook`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`UserID`);

--
-- 表的索引 `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `emp_login`
--
ALTER TABLE `emp_login`
  MODIFY `empid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `room`
--
ALTER TABLE `room`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- 使用表AUTO_INCREMENT `roombook`
--
ALTER TABLE `roombook`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- 使用表AUTO_INCREMENT `signup`
--
ALTER TABLE `signup`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
