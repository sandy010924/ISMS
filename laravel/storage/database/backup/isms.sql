-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 
-- 伺服器版本: 10.1.29-MariaDB
-- PHP 版本： 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `isms`
--

-- --------------------------------------------------------

--
-- 資料表結構 `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_teacher` int(11) DEFAULT NULL COMMENT '講師ID',
  `name` varchar(40) NOT NULL COMMENT '課程名稱',
  `type` varchar(40) NOT NULL COMMENT '課程類型(1:銷講,2:2階正課,3:3階正課)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `id_type` varchar(40) DEFAULT NULL COMMENT '上一階段ID',
  `courseservices` mediumtext COMMENT '課程服務',
  `money` varchar(100) DEFAULT NULL COMMENT '課程金額'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `course`
--

INSERT INTO `course` (`id`, `id_teacher`, `name`, `type`, `created_at`, `updated_at`, `id_type`, `courseservices`, `money`) VALUES
(32, 2, '測試正課', '2', '2020-03-31 15:00:37', '2020-03-31 15:01:31', '33', 'test', '343'),
(33, 2, 'test', '1', '2020-03-31 15:01:20', '2020-03-31 15:01:20', NULL, NULL, NULL),
(34, 17, 'dsfs', '1', '2020-04-10 15:56:02', '2020-04-10 15:56:02', NULL, NULL, NULL),
(35, 1, '434', '1', '2020-04-10 16:14:28', '2020-04-10 16:14:28', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `debt`
--

CREATE TABLE `debt` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `id_status` int(11) DEFAULT NULL COMMENT '最新狀態ID',
  `name_course` varchar(150) DEFAULT NULL COMMENT '追單課程',
  `status_payment` varchar(200) DEFAULT NULL COMMENT '付款狀態/日期',
  `contact` varchar(150) DEFAULT NULL COMMENT '聯絡內容',
  `person` varchar(150) DEFAULT NULL COMMENT '追單人員',
  `remind_at` timestamp NULL DEFAULT NULL COMMENT '提醒',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `id_registration` int(11) NOT NULL COMMENT '正課報名ID',
  `id_events` varchar(150) DEFAULT NULL COMMENT '場次ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `debt`
--

INSERT INTO `debt` (`id`, `id_student`, `id_status`, `name_course`, `status_payment`, `contact`, `person`, `remind_at`, `created_at`, `updated_at`, `id_registration`, `id_events`) VALUES
(2, 1423, NULL, '測試正課', 'test', NULL, 'dsfsfd', '2020-03-31 15:55:19', '2020-03-31 15:05:03', '2020-04-02 14:02:12', 5, NULL),
(18, 1424, 13, 'test', NULL, NULL, 'test', '2020-04-17 16:00:00', '2020-04-03 01:37:14', '2020-04-19 16:00:00', 0, NULL),
(19, 1425, 12, 'test', 'test', 'test', 'test', '2020-04-25 16:00:00', '2020-04-03 16:00:00', '2020-04-03 13:53:07', 0, NULL),
(20, 1424, 12, 'ter', 'te', '陳致佑', 'tew', '2020-04-17 16:00:00', '2020-04-17 16:00:00', '2020-04-17 16:00:00', 0, NULL),
(23, 1425, 10, 'ter', 'te', '陳致佑', 'tew', '2020-04-17 16:00:00', '2020-04-17 16:00:00', '2020-04-03 14:02:45', 0, NULL),
(24, 1425, 13, 'test', 'te', '陳致佑', 'test', '2020-04-17 16:00:00', '2020-04-17 16:00:00', '2020-04-03 14:02:43', 0, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `events_course`
--

CREATE TABLE `events_course` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `id_course` int(11) DEFAULT NULL COMMENT '課程ID',
  `name` varchar(40) DEFAULT NULL COMMENT '場次',
  `location` varchar(255) DEFAULT NULL COMMENT '地址',
  `money` varchar(150) DEFAULT NULL COMMENT '現場完款',
  `money_fivedays` varchar(150) DEFAULT NULL COMMENT '五日內完款',
  `money_installment` varchar(150) DEFAULT NULL COMMENT '分期付款',
  `memo` mediumtext COMMENT '備註',
  `host` varchar(100) DEFAULT NULL COMMENT '主持開場',
  `closeOrder` varchar(40) DEFAULT NULL COMMENT '結束收單',
  `weather` varchar(40) DEFAULT NULL COMMENT '天氣',
  `staff` varchar(255) DEFAULT NULL COMMENT '工作人員',
  `id_group` varchar(40) DEFAULT NULL COMMENT '群組ID',
  `course_start_at` timestamp NULL DEFAULT NULL COMMENT '課程開始時間',
  `course_end_at` timestamp NULL DEFAULT NULL COMMENT '課程結束時間',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `unpublish` int(11) DEFAULT NULL COMMENT '不公開(0:否,1:是)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `events_course`
--

INSERT INTO `events_course` (`id`, `id_course`, `name`, `location`, `money`, `money_fivedays`, `money_installment`, `memo`, `host`, `closeOrder`, `weather`, `staff`, `id_group`, `course_start_at`, `course_end_at`, `created_at`, `updated_at`, `unpublish`) VALUES
(1654, 32, '台中晚上場', 'test', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '1585666837', '2020-03-31 15:00:00', '2020-03-31 15:00:00', '2020-03-31 15:00:37', '2020-03-31 15:00:37', 0),
(1655, 32, '台中晚上場', 'test', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '1585666837', '2020-04-01 15:00:00', '2020-04-01 15:00:00', '2020-03-31 15:00:37', '2020-03-31 15:00:37', 0),
(1656, 32, '台中晚上場', 'test', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '1585666837', '2020-04-30 15:00:00', '2020-04-30 15:00:00', '2020-03-31 15:00:37', '2020-03-31 15:00:37', 0),
(1657, 33, '台北晚上場', ' (台北市金山南路一段17號5樓)(博宇藝享空間)', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '158288760033', '2020-02-28 11:00:00', '2020-02-28 13:30:00', '2020-03-31 15:01:20', '2020-03-31 15:01:20', 0),
(1658, 33, '台北晚上場', ' (台北市金山南路一段17號5樓)(博宇藝享空間)', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '158375160033', '2020-03-09 11:00:00', '2020-03-09 13:30:00', '2020-03-31 15:01:20', '2020-03-31 15:01:20', 0),
(1659, 33, '台北晚上場', ' (台北市金山南路一段17號5樓)(博宇藝享空間)', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '158383800033', '2020-03-10 11:00:00', '2020-03-10 13:30:00', '2020-03-31 15:01:20', '2020-03-31 15:01:20', 0),
(1660, 33, '台北晚上場', ' (台北市金山南路一段17號5樓)(博宇藝享空間)', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '158392440033', '2020-03-11 11:00:00', '2020-03-11 13:30:00', '2020-03-31 15:01:20', '2020-03-31 15:01:20', 0),
(1661, 34, '台北晚上場', ' (台北市金山南路一段17號5樓)(博宇藝享空間)', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '158288760034', '2020-02-28 11:00:00', '2020-02-28 13:30:00', '2020-04-10 15:56:02', '2020-04-10 15:56:02', 0),
(1662, 35, '台北晚上場', ' (台北市金山南路一段17號5樓)(博宇藝享空間)', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '158288760035', '2020-02-28 11:00:00', '2020-02-28 13:30:00', '2020-04-10 16:14:28', '2020-04-10 16:14:28', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `isms_status`
--

CREATE TABLE `isms_status` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '狀態名稱',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `type` varchar(50) DEFAULT NULL COMMENT '類型(0:銷講、正課,1:追單,2:付款狀態)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `isms_status`
--

INSERT INTO `isms_status` (`id`, `name`, `created_at`, `updated_at`, `type`) VALUES
(1, '已報名', '2020-02-03 15:54:01', '2020-03-04 16:05:17', '0'),
(2, '我很遺憾', '2020-02-03 15:54:02', '2020-03-04 16:05:17', '0'),
(3, '未到', '2020-02-03 15:54:02', '2020-03-04 16:05:17', '0'),
(4, '報到', '2020-02-03 15:54:02', '2020-03-04 16:05:17', '0'),
(5, '取消', '2020-02-03 15:54:02', '2020-03-04 16:05:17', '0'),
(6, '留單', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '2'),
(7, '完款', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '2'),
(8, '付訂', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '2'),
(9, '退費', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '2'),
(10, '付訂', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '1'),
(11, '完款', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '1'),
(12, '待追', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '1'),
(13, '退款中', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '1'),
(14, '退款完成', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '1'),
(15, '無意願', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '1'),
(16, '推薦其他講師', '2020-03-05 15:21:07', '2020-03-05 15:21:07', '1');

-- --------------------------------------------------------

--
-- 資料表結構 `mark`
--

CREATE TABLE `mark` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `name_mark` varchar(40) DEFAULT NULL COMMENT '標記名稱',
  `course_id` varchar(50) DEFAULT NULL COMMENT '課程ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student_group` varchar(100) DEFAULT NULL COMMENT '細分組ID',
  `type` varchar(50) DEFAULT NULL COMMENT '類型(0:簡訊,1:email,2:全部)',
  `title` varchar(255) DEFAULT NULL COMMENT '標題',
  `content` mediumtext COMMENT '內容',
  `send_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '發送時間',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `m_database`
--

CREATE TABLE `m_database` (
  `id` int(11) NOT NULL COMMENT 'id',
  `filename` varchar(150) DEFAULT NULL COMMENT '檔名',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `m_database`
--

INSERT INTO `m_database` (`id`, `filename`, `created_at`, `updated_at`) VALUES
(1, '0410.sql', '2020-04-10 15:00:37', '2020-04-10 14:03:38');

-- --------------------------------------------------------

--
-- 資料表結構 `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL COMMENT 'id',
  `title` varchar(40) NOT NULL COMMENT '推播標題',
  `content` mediumtext NOT NULL COMMENT '推播內容',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `cash` varchar(100) NOT NULL COMMENT '付款金額',
  `pay_model` varchar(20) NOT NULL COMMENT '付款方式(0:現金,1:匯款,2:刷卡:輕鬆付,3:刷卡:一次付)',
  `number` varchar(40) NOT NULL COMMENT '卡號後四碼',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `id_registration` int(11) DEFAULT NULL COMMENT '正課報名ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `payment`
--

INSERT INTO `payment` (`id`, `id_student`, `cash`, `pay_model`, `number`, `created_at`, `updated_at`, `id_registration`) VALUES
(2, 1423, '33', '0', '33', '2020-03-31 15:05:03', '2020-03-31 15:05:03', 5);

-- --------------------------------------------------------

--
-- 資料表結構 `refund`
--

CREATE TABLE `refund` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `id_registration` int(11) DEFAULT NULL COMMENT '正課報名ID',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `submissiondate` timestamp NULL DEFAULT NULL COMMENT 'SubmissionDate',
  `refund_date` timestamp NULL DEFAULT NULL COMMENT '申請退費日期',
  `name_student` varchar(100) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(100) DEFAULT NULL COMMENT '連絡電話',
  `email` varchar(100) DEFAULT NULL COMMENT 'email',
  `name_course` varchar(150) DEFAULT NULL COMMENT '申請退款課程',
  `refund_reason` mediumtext COMMENT '退費原因',
  `pay_model` varchar(50) DEFAULT NULL COMMENT '當時付款方式',
  `account` varchar(30) DEFAULT NULL COMMENT '帳號/卡號後五碼',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `id_registration` varchar(50) DEFAULT NULL COMMENT '正課報名ID',
  `id_student` varchar(50) DEFAULT NULL COMMENT '學員ID',
  `id_status` varchar(50) DEFAULT NULL COMMENT '狀態ID',
  `id_events` varchar(50) DEFAULT NULL COMMENT '場次ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `memo` mediumtext COMMENT '備註'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `register`
--

INSERT INTO `register` (`id`, `id_registration`, `id_student`, `id_status`, `id_events`, `created_at`, `updated_at`, `memo`) VALUES
(1, '2', '871', '7', '1615', '2020-03-15 15:14:07', '2020-03-20 10:05:33', NULL),
(2, '4', '872', '5', '1622', '2020-03-20 08:16:15', '2020-03-20 10:03:04', ''),
(3, '5', '1423', '1', '1654', '2020-03-31 15:05:03', '2020-03-31 15:05:03', ''),
(4, '5', '1423', '1', '1655', '2020-03-31 15:05:03', '2020-03-31 15:05:03', ''),
(5, '5', '1423', '1', '1656', '2020-03-31 15:05:03', '2020-03-31 15:05:03', '');

-- --------------------------------------------------------

--
-- 資料表結構 `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `id_course` int(11) DEFAULT NULL COMMENT '課程ID',
  `amount_payable` varchar(100) NOT NULL COMMENT '應付金額',
  `amount_paid` varchar(100) NOT NULL COMMENT '已付金額',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `sign` varchar(100) DEFAULT NULL COMMENT '簽名檔案',
  `id_events` int(11) NOT NULL COMMENT '場次ID',
  `status_payment` varchar(100) DEFAULT NULL COMMENT '付款狀態',
  `registration_join` varchar(20) DEFAULT NULL COMMENT '我想參加課程(0:現場最優惠價格,1:五日內優惠價格)',
  `id_group` int(11) DEFAULT NULL COMMENT '群組ID',
  `source_events` int(11) DEFAULT NULL COMMENT '來源場次ID',
  `pay_date` timestamp NULL DEFAULT NULL COMMENT '付款日期',
  `pay_memo` varchar(40) DEFAULT NULL COMMENT '付款備註',
  `person` varchar(40) DEFAULT NULL COMMENT '服務人員',
  `type_invoice` varchar(20) DEFAULT NULL COMMENT '統一發票',
  `number_taxid` varchar(40) DEFAULT NULL COMMENT '統編',
  `companytitle` varchar(40) DEFAULT NULL COMMENT '抬頭'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `registration`
--

INSERT INTO `registration` (`id`, `id_student`, `id_course`, `amount_payable`, `amount_paid`, `created_at`, `updated_at`, `sign`, `id_events`, `status_payment`, `registration_join`, `id_group`, `source_events`, `pay_date`, `pay_memo`, `person`, `type_invoice`, `number_taxid`, `companytitle`) VALUES
(5, 1423, 32, '', '', '2020-03-31 15:05:03', '2020-03-31 15:05:03', '', 1656, '6', '0', 1585666837, 1660, NULL, '', '', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `rule`
--

CREATE TABLE `rule` (
  `id` int(11) NOT NULL COMMENT 'id',
  `type` varchar(50) DEFAULT NULL COMMENT '類型(0:黑名單,1:細分組)',
  `name` varchar(200) DEFAULT NULL COMMENT '規則名稱',
  `regulation` varchar(200) DEFAULT NULL COMMENT '規則',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `rule_value` varchar(40) DEFAULT NULL COMMENT '規則Value',
  `rule_status` varchar(40) DEFAULT NULL COMMENT '狀態(0:關閉,1:啟動)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `rule`
--

INSERT INTO `rule` (`id`, `type`, `name`, `regulation`, `created_at`, `updated_at`, `rule_value`, `rule_status`) VALUES
(1, '0', '單一課程累積_未到幾次', '1', '2020-03-01 13:37:51', '2020-03-07 13:06:55', '0', '1'),
(2, '0', '單一課程累積_取消幾次', '1', '2020-03-01 13:40:35', '2020-03-07 13:06:55', '1', '1'),
(3, '0', '單一課程累積_未到+取消幾次', '1', '2020-03-01 13:40:35', '2020-03-07 13:06:55', '2', '1'),
(4, '0', '單一課程累積_出席幾次但未留單', '1', '2020-03-01 13:40:35', '2020-03-07 13:06:55', '3', '1'),
(5, '0', '所有課程累積_未到幾次', '2', '2020-03-01 13:40:35', '2020-03-07 13:06:55', '4', '1'),
(6, '0', '所有課程累積_取消幾次', '2', '2020-03-01 13:40:35', '2020-03-07 13:06:55', '5', '1'),
(7, '0', '所有課程累積_未到+取消幾次', '5', '2020-03-01 13:40:35', '2020-03-07 13:06:55', '6', '1');

-- --------------------------------------------------------

--
-- 資料表結構 `sales_registration`
--

CREATE TABLE `sales_registration` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `id_course` int(11) DEFAULT NULL COMMENT '課程ID',
  `id_status` int(11) DEFAULT NULL COMMENT '報名狀態ID',
  `pay_model` varchar(20) DEFAULT NULL COMMENT '付款方式',
  `account` varchar(20) DEFAULT NULL COMMENT '帳號/卡號後四碼',
  `course_content` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `datasource` varchar(255) DEFAULT NULL COMMENT '表單來源',
  `memo` mediumtext COMMENT '報名備註',
  `submissiondate` varchar(150) DEFAULT NULL COMMENT 'Submission Date',
  `events` varchar(50) DEFAULT NULL COMMENT '追蹤場次(給我很遺憾用)',
  `id_events` int(11) NOT NULL COMMENT '場次ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `sales_registration`
--

INSERT INTO `sales_registration` (`id`, `id_student`, `id_course`, `id_status`, `pay_model`, `account`, `course_content`, `created_at`, `updated_at`, `datasource`, `memo`, `submissiondate`, `events`, `id_events`) VALUES
(2412, 1421, 33, 3, NULL, NULL, 'test5', '2020-03-31 15:01:20', '2020-03-31 15:17:53', 'test5', NULL, '2020-01-05 15:33:46', NULL, 1657),
(2413, 1422, 33, 1, NULL, NULL, 'test4', '2020-03-31 15:01:20', '2020-03-31 15:01:20', 'test4', NULL, '2020-01-05 15:33:46', NULL, 1658),
(2414, 1423, 33, 3, NULL, NULL, 'test3', '2020-03-31 15:01:20', '2020-04-09 11:50:09', 'test3', NULL, '2020-01-05 15:33:46', NULL, 1659),
(2415, 1424, 33, 3, NULL, NULL, 'test2', '2020-03-31 15:01:20', '2020-03-31 15:02:01', 'test2', NULL, '2020-01-05 15:33:46', NULL, 1660),
(2417, 1427, 35, 1, NULL, NULL, 'test5', '2020-04-10 16:14:28', '2020-04-10 16:14:28', 'fb', NULL, '2020-01-05 15:33:46', NULL, 1662);

-- --------------------------------------------------------

--
-- 資料表結構 `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '學員姓名',
  `sex` varchar(5) DEFAULT NULL COMMENT '性別',
  `id_identity` varchar(20) DEFAULT NULL COMMENT '身分證',
  `phone` varchar(20) DEFAULT NULL COMMENT '電話',
  `email` varchar(255) DEFAULT NULL COMMENT 'email',
  `birthday` varchar(30) DEFAULT NULL COMMENT '生日',
  `company` varchar(30) DEFAULT NULL COMMENT '公司名稱',
  `profession` varchar(30) DEFAULT NULL COMMENT '職業',
  `address` varchar(40) DEFAULT NULL COMMENT '居住地區',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `check_blacklist` int(11) NOT NULL DEFAULT '0' COMMENT '判斷是否為黑名單(1:是,0:否)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `student`
--

INSERT INTO `student` (`id`, `name`, `sex`, `id_identity`, `phone`, `email`, `birthday`, `company`, `profession`, `address`, `created_at`, `updated_at`, `check_blacklist`) VALUES
(1421, '測試資料_5', '', '', '098555', '5924@gmail.com', '', '', 'job5', NULL, '2020-03-31 15:01:20', '2020-03-31 15:01:20', 0),
(1422, '測試資料_4', '', '', '098123', '111124@gmail.com', '', '', 'job4', NULL, '2020-03-31 15:01:20', '2020-03-31 15:01:20', 0),
(1423, '測試資料_3', '女', '2131', '098456', '33333924@gmail.com', '2020-05-14', '3232', 'job3', '323223', '2020-03-31 15:01:20', '2020-04-09 11:50:09', 0),
(1424, '測試資料_2', '', '', '0985789', '44444@gmail.com', '', '', 'job2', NULL, '2020-03-31 15:01:20', '2020-03-31 15:01:20', 0),
(1425, 'esdfsf', '', '', '234234', 'fsdfsdfsf', '', '', '3232', '台北', '2020-03-31 15:18:10', '2020-03-31 15:18:10', 0),
(1427, '測試資料_0410_2', '', '', '0904102', '0410@gmail.com', '', '', 'job5', NULL, '2020-04-10 16:14:28', '2020-04-10 16:14:28', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `student_group`
--

CREATE TABLE `student_group` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_group` varchar(150) DEFAULT NULL COMMENT '分組ID',
  `name` varchar(150) DEFAULT NULL COMMENT '細分組名稱',
  `condition` varchar(200) DEFAULT NULL COMMENT '條件',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `student_group`
--

INSERT INTO `student_group` (`id`, `id_group`, `name`, `condition`, `created_at`, `updated_at`) VALUES
(24, NULL, 'test1', NULL, '2020-04-03 09:50:52', '2020-04-03 09:50:52'),
(25, NULL, 'test2', NULL, '2020-04-03 09:50:56', '2020-04-03 09:50:56'),
(26, NULL, '1', '1. 銷講/test/2020/04/04 - 2020/04/04/名單資料<br>2. 銷講/test/2020/04/04 - 2020/04/04/名單資料<br>3. 銷講/test/2020/02/03 - 2020/05/20/名單資料<br>篩選器1:請選擇/2020/04/09 - 2020/04/09/名單資料<br>', '2020-04-03 16:49:54', '2020-04-09 10:06:18'),
(27, NULL, 'test2', '<hr>篩選器1:銷講/test/2020/04/09 - 2020/04/09/名單資料<br><hr>篩選器1:銷講/test/2020/02/04 - 2020/07/01/名單資料<br>', '2020-04-05 11:37:01', '2020-04-09 10:20:23'),
(28, NULL, '04091123232213', '<hr>篩選器1:銷講/test/2020/03/03 - 2020/04/28/名單資料/目前職業/是/job3<br>篩選器2:銷講/test/2020/03/03 - 2020/04/23/名單資料/目前職業/未/job<br><hr>篩選器1:銷講/test/2020/03/03 - 2020/04/28/名單資料/目前職業/是/job3<br>篩選器2:銷講/test/2020/03/0', '2020-04-09 11:54:30', '2020-04-09 11:54:57');

-- --------------------------------------------------------

--
-- 資料表結構 `student_groupdetail`
--

CREATE TABLE `student_groupdetail` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` varchar(150) DEFAULT NULL COMMENT '學員ID',
  `id_group` varchar(150) DEFAULT NULL COMMENT '分組ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `student_groupdetail`
--

INSERT INTO `student_groupdetail` (`id`, `id_student`, `id_group`, `created_at`, `updated_at`) VALUES
(18, '872', '13', '2020-03-20 10:06:45', '2020-03-20 10:06:45'),
(19, '871', '13', '2020-03-20 10:06:45', '2020-03-20 10:06:45'),
(21, '1421', '24', '2020-04-03 09:50:52', '2020-04-03 09:50:52'),
(22, '1422', '24', '2020-04-03 09:50:52', '2020-04-03 09:50:52'),
(23, '1423', '24', '2020-04-03 09:50:52', '2020-04-03 09:50:52'),
(24, '1424', '24', '2020-04-03 09:50:52', '2020-04-03 09:50:52'),
(25, '1421', '25', '2020-04-03 09:50:56', '2020-04-03 09:50:56'),
(26, '1422', '25', '2020-04-03 09:50:56', '2020-04-03 09:50:56'),
(27, '1423', '25', '2020-04-03 09:50:56', '2020-04-03 09:50:56'),
(28, '1424', '25', '2020-04-03 09:50:56', '2020-04-03 09:50:56'),
(29, '1421', '26', '2020-04-03 16:49:54', '2020-04-03 16:49:54'),
(30, '1422', '26', '2020-04-03 16:49:54', '2020-04-03 16:49:54'),
(31, '1423', '26', '2020-04-03 16:49:54', '2020-04-03 16:49:54'),
(32, '1424', '26', '2020-04-03 16:49:54', '2020-04-03 16:49:54'),
(33, '1422', '27', '2020-04-05 11:37:01', '2020-04-05 11:37:01'),
(34, '1421', '27', '2020-04-05 11:37:01', '2020-04-05 11:37:01'),
(35, '1423', '27', '2020-04-05 11:37:01', '2020-04-05 11:37:01'),
(36, '1424', '27', '2020-04-09 10:20:23', '2020-04-09 10:20:23'),
(37, '1423', '28', '2020-04-09 11:54:30', '2020-04-09 11:54:30'),
(38, '1421', '28', '2020-04-09 11:54:50', '2020-04-09 11:54:50'),
(39, '1422', '28', '2020-04-09 11:54:50', '2020-04-09 11:54:50'),
(40, '1424', '28', '2020-04-09 11:54:50', '2020-04-09 11:54:50');

-- --------------------------------------------------------

--
-- 資料表結構 `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '講師姓名',
  `phone` varchar(40) NOT NULL COMMENT '電話',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Juila', '', '2020-02-03 15:54:02', '2020-02-03 15:54:02'),
(2, 'Jack', '', '2020-02-03 15:54:02', '2020-02-03 15:54:02'),
(3, 'Mark', '', '2020-02-03 15:54:02', '2020-02-03 15:54:02'),
(4, 'yuyu', '', '2020-03-31 13:00:28', '2020-03-31 13:00:28'),
(5, 'sdfdsfsdfsd', '', '2020-03-31 13:02:34', '2020-03-31 13:02:34'),
(6, 'sfsf', '', '2020-03-31 13:03:20', '2020-03-31 13:03:20'),
(7, 'fdsffs', '', '2020-03-31 13:04:22', '2020-03-31 13:04:22'),
(8, 'fsfs', '', '2020-03-31 13:04:48', '2020-03-31 13:04:48'),
(9, 'dfdsfds', '', '2020-03-31 13:17:24', '2020-03-31 13:17:24'),
(10, 'utyutyuyt', '', '2020-03-31 13:29:20', '2020-03-31 13:29:20'),
(11, 'tutyu', '', '2020-03-31 13:29:30', '2020-03-31 13:29:30'),
(12, 'grerge', '', '2020-03-31 13:30:40', '2020-03-31 13:30:40'),
(13, 'feew', '', '2020-03-31 13:33:10', '2020-03-31 13:33:10'),
(14, 'tes', '', '2020-03-31 14:15:42', '2020-03-31 14:15:42'),
(15, 'wrerewwer', '', '2020-03-31 14:17:19', '2020-03-31 14:17:19'),
(16, 'ewfew', '', '2020-03-31 14:17:32', '2020-03-31 14:17:32'),
(17, 'dsfds', '', '2020-04-10 15:56:00', '2020-04-10 15:56:00');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `account` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '帳號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `account`) VALUES
(8, '管理員', 'admin', 'admin@gmail.com', NULL, '$2y$10$0krSRlyK4KUL4Okef8GP7./Z.DFe7/HSwM/yER2Z9sInOfGTmzeS2', NULL, NULL, '2020-02-19 14:26:57', 'admin'),
(9, '數據分析人員', 'dataanalysis', 'dataanalysis@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'dataanalysis'),
(10, '行銷人員', 'marketer', 'marketer@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'marketer'),
(11, '財會人員', 'accountant', 'accountant@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'accountant'),
(12, '現場人員', 'staff', 'staff@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'staff'),
(13, 'test', 'teacher', 'teacher@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, '2020-02-18 15:34:24', 'teacher'),
(20, 'admin', 'marketer', '', NULL, '$2y$10$tdRrGEwKmlarNs7ZPYCjC.4uMCmg7xZ83uHC1WLDFhFZEZ7dkd/ku', NULL, NULL, '2020-02-20 13:53:05', 'test343333');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_teacher` (`id_teacher`);

--
-- 資料表索引 `debt`
--
ALTER TABLE `debt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_status` (`id_status`),
  ADD KEY `id_registration` (`id_registration`);

--
-- 資料表索引 `events_course`
--
ALTER TABLE `events_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_course` (`id_course`);

--
-- 資料表索引 `isms_status`
--
ALTER TABLE `isms_status`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `mark`
--
ALTER TABLE `mark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`);

--
-- 資料表索引 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `m_database`
--
ALTER TABLE `m_database`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`);

--
-- 資料表索引 `refund`
--
ALTER TABLE `refund`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_registration` (`id_registration`);

--
-- 資料表索引 `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_course` (`id_course`),
  ADD KEY `id_events` (`id_events`);

--
-- 資料表索引 `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `sales_registration`
--
ALTER TABLE `sales_registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_course` (`id_course`),
  ADD KEY `id_status` (`id_status`),
  ADD KEY `id_events` (`id_events`);

--
-- 資料表索引 `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `student_group`
--
ALTER TABLE `student_group`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `student_groupdetail`
--
ALTER TABLE `student_groupdetail`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=36;

--
-- 使用資料表 AUTO_INCREMENT `debt`
--
ALTER TABLE `debt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=25;

--
-- 使用資料表 AUTO_INCREMENT `events_course`
--
ALTER TABLE `events_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=1663;

--
-- 使用資料表 AUTO_INCREMENT `isms_status`
--
ALTER TABLE `isms_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=17;

--
-- 使用資料表 AUTO_INCREMENT `mark`
--
ALTER TABLE `mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用資料表 AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表 AUTO_INCREMENT `m_database`
--
ALTER TABLE `m_database`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;

--
-- 使用資料表 AUTO_INCREMENT `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=3;

--
-- 使用資料表 AUTO_INCREMENT `refund`
--
ALTER TABLE `refund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用資料表 AUTO_INCREMENT `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;

--
-- 使用資料表 AUTO_INCREMENT `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=6;

--
-- 使用資料表 AUTO_INCREMENT `rule`
--
ALTER TABLE `rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=8;

--
-- 使用資料表 AUTO_INCREMENT `sales_registration`
--
ALTER TABLE `sales_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2418;

--
-- 使用資料表 AUTO_INCREMENT `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1428;

--
-- 使用資料表 AUTO_INCREMENT `student_group`
--
ALTER TABLE `student_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=29;

--
-- 使用資料表 AUTO_INCREMENT `student_groupdetail`
--
ALTER TABLE `student_groupdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=41;

--
-- 使用資料表 AUTO_INCREMENT `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=18;

--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `debt`
--
ALTER TABLE `debt`
  ADD CONSTRAINT `debt_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `debt_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `isms_status` (`id`);

--
-- 資料表的 Constraints `events_course`
--
ALTER TABLE `events_course`
  ADD CONSTRAINT `events_course_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `course` (`id`);

--
-- 資料表的 Constraints `mark`
--
ALTER TABLE `mark`
  ADD CONSTRAINT `mark_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`);

--
-- 資料表的 Constraints `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`);

--
-- 資料表的 Constraints `refund`
--
ALTER TABLE `refund`
  ADD CONSTRAINT `refund_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `refund_ibfk_2` FOREIGN KEY (`id_registration`) REFERENCES `registration` (`id`);

--
-- 資料表的 Constraints `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `registration_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`);

--
-- 資料表的 Constraints `sales_registration`
--
ALTER TABLE `sales_registration`
  ADD CONSTRAINT `sales_registration_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `sales_registration_ibfk_3` FOREIGN KEY (`id_status`) REFERENCES `isms_status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
