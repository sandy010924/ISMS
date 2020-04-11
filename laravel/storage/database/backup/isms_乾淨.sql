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
-- 資料表結構 `blacklist`
--

CREATE TABLE `blacklist` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `reason` varchar(255) DEFAULT NULL COMMENT '原因',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `closeorder` varchar(40) DEFAULT NULL COMMENT '結束收單',
  `weather` varchar(40) DEFAULT NULL COMMENT '天氣',
  `staff` varchar(255) DEFAULT NULL COMMENT '工作人員',
  `id_group` varchar(40) DEFAULT NULL COMMENT '群組ID',
  `course_start_at` timestamp NULL DEFAULT NULL COMMENT '課程開始時間',
  `course_end_at` timestamp NULL DEFAULT NULL COMMENT '課程結束時間',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `unpublish` int(11) DEFAULT NULL COMMENT '不公開(0:否,1:是)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `isms_status`
--

CREATE TABLE `isms_status` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '狀態名稱',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `type` varchar(50) DEFAULT NULL COMMENT '類型(0:銷講、正課,1:追單,2:付款狀態,4:活動狀態)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `isms_status`
--

INSERT INTO `isms_status` (`id`, `name`, `created_at`, `updated_at`, `type`) VALUES
(1, '已報名', '2020-04-11 07:55:19', '2020-04-11 07:55:22', '0'),
(2, '我很遺憾', '2020-04-11 07:55:19', '2020-04-11 07:55:22', '0'),
(3, '未到', '2020-04-11 07:55:20', '2020-04-11 07:55:22', '0'),
(4, '報到', '2020-04-11 07:55:20', '2020-04-11 07:55:22', '0'),
(5, '取消', '2020-04-11 07:55:20', '2020-04-11 07:55:22', '0'),
(6, '留單', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '2'),
(7, '完款', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '2'),
(8, '付訂', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '2'),
(9, '退費', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '2'),
(10, '付訂', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '1'),
(11, '完款', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '1'),
(12, '待追', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '1'),
(13, '退款中', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '1'),
(14, '退款完成', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '1'),
(15, '無意願', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '1'),
(16, '推薦其他講師', '2020-04-11 07:55:22', '2020-04-11 07:55:22', '1');

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
(1, '0410.sql', '2020-04-10 15:00:37', '2020-04-11 07:55:24');

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
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `review` int(11) DEFAULT '0' COMMENT '審核(0:審核中,1:通過,2:未通過)'
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
  `companytitle` varchar(40) DEFAULT NULL COMMENT '抬頭',
  `submissiondate` varchar(150) DEFAULT NULL COMMENT 'Submission Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, '0', '單一課程累積_未到幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '0', '1'),
(2, '0', '單一課程累積_取消幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '1', '1'),
(3, '0', '單一課程累積_未到+取消幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '2', '1'),
(4, '0', '單一課程累積_出席幾次但未留單', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '3', '1'),
(5, '0', '所有課程累積_未到幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '4', '1'),
(6, '0', '所有課程累積_取消幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '5', '1'),
(7, '0', '所有課程累積_未到+取消幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '6', '1');

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
  `submissiondate` varchar(150) DEFAULT NULL COMMENT 'Submission Date',
  `datasource` varchar(255) DEFAULT NULL COMMENT '表單來源',
  `memo` mediumtext COMMENT '報名備註',
  `events` varchar(50) DEFAULT NULL COMMENT '追蹤場次(給我很遺憾用)',
  `id_events` int(11) NOT NULL COMMENT '場次ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '學員姓名',
  `sex` varchar(5) DEFAULT NULL COMMENT '性別',
  `id_identity` varchar(20) DEFAULT NULL COMMENT '身分證',
  `phone` varchar(20) NOT NULL COMMENT '電話',
  `email` varchar(150) DEFAULT NULL COMMENT 'email',
  `birthday` varchar(30) DEFAULT NULL COMMENT '生日',
  `company` varchar(30) DEFAULT NULL COMMENT '公司名稱',
  `profession` varchar(30) DEFAULT NULL COMMENT '職業',
  `address` varchar(40) DEFAULT NULL COMMENT '居住地區',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  `check_blacklist` int(11) NOT NULL DEFAULT '0' COMMENT '判斷是否為黑名單(1:是,0:否)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Juila', '', '2020-04-11 07:55:19', '2020-04-11 07:55:19'),
(2, 'Jack', '', '2020-04-11 07:55:19', '2020-04-11 07:55:19'),
(3, 'Mark', '', '2020-04-11 07:55:19', '2020-04-11 07:55:19');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `account` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '帳號',
  `role` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '角色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `account`, `role`) VALUES
(1, '管理員', 'admin@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'admin', 'admin'),
(2, '數據分析人員', 'dataanalysis@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'dataanalysis', 'dataanalysis'),
(3, '行銷人員', 'marketer@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'marketer', 'marketer'),
(4, '財會人員', 'accountant@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'accountant', 'accountant'),
(5, '現場人員', 'staff@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'staff', 'staff'),
(6, '講師', 'teacher@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'teacher', 'teacher');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`);

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
-- 使用資料表 AUTO_INCREMENT `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `debt`
--
ALTER TABLE `debt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用資料表 AUTO_INCREMENT `events_course`
--
ALTER TABLE `events_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `refund`
--
ALTER TABLE `refund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用資料表 AUTO_INCREMENT `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用資料表 AUTO_INCREMENT `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `rule`
--
ALTER TABLE `rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=8;

--
-- 使用資料表 AUTO_INCREMENT `sales_registration`
--
ALTER TABLE `sales_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `student_group`
--
ALTER TABLE `student_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `student_groupdetail`
--
ALTER TABLE `student_groupdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

--
-- 使用資料表 AUTO_INCREMENT `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=4;

--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `blacklist`
--
ALTER TABLE `blacklist`
  ADD CONSTRAINT `blacklist_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`);

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
