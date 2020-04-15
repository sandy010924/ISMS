SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `blacklist` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `reason` varchar(255) DEFAULT NULL COMMENT '原因',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blacklist` (`id`, `id_student`, `reason`, `created_at`, `updated_at`) VALUES
(218, 152, '', '2020-03-31 15:22:35', '2020-03-31 15:22:35');

CREATE TABLE `course` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_teacher` int(11) DEFAULT NULL COMMENT '講師ID',
  `name` varchar(40) NOT NULL COMMENT '課程名稱',
  `type` varchar(40) NOT NULL COMMENT '課程類型(1:銷講,2:2階正課,3:3階正課)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `id_type` varchar(40) DEFAULT NULL COMMENT '上一階段ID',
  `courseservices` mediumtext DEFAULT NULL COMMENT '課程服務',
  `money` varchar(100) DEFAULT NULL COMMENT '課程金額'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `course` (`id`, `id_teacher`, `name`, `type`, `created_at`, `updated_at`, `id_type`, `courseservices`, `money`) VALUES
(8, 2, '黑心外匯交易員的告白', '1', '2020-03-23 01:53:05', '2020-03-25 06:45:03', NULL, '課程內容：\r\n\r\n\r\n四組專屬交易策略包含\r\n*三項每日操盤策略\r\n*超過十個季節性交易資訊\r\n*成為一個專職交易員該有的心態\r\n*如何遵守嚴格的風險控管\r\n*學長姊寶貴經驗分享\r\n\r\n---------------------------------\r\n\r\n報名贈送：\r\n\r\n*兩個整天實體培訓課程\r\n*六個月指導教練諮詢\r\n*複訓後交流群組\r\n*終身不限次數免學費複訓（酌收場地費用）\r\n*終身不定期複習會（酌收場地費用）\r\n*指定銀行刷卡分期零利率\r\n*當天完款獲得百支輔導課程影片', '99800'),
(9, 2, '自在交易工作坊', '2', '2020-03-24 08:04:49', '2020-03-26 09:24:53', '8', 'test', '9600'),
(13, 1, 'test', '1', '2020-04-05 17:52:00', '2020-04-05 17:52:00', NULL, NULL, NULL),
(14, 1, 'test2', '2', '2020-04-05 17:52:48', '2020-04-05 17:53:11', '13', 'test\r\ntest\r\ntest', '96000');

CREATE TABLE `debt` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `id_status` int(11) DEFAULT NULL COMMENT '最新狀態ID',
  `name_course` varchar(150) DEFAULT NULL COMMENT '追單課程',
  `status_payment` varchar(200) DEFAULT NULL COMMENT '付款狀態/日期',
  `contact` varchar(150) DEFAULT NULL COMMENT '聯絡內容',
  `person` varchar(150) DEFAULT NULL COMMENT '追單人員',
  `remind_at` timestamp NULL DEFAULT NULL COMMENT '提醒',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `id_registration` int(11) NOT NULL COMMENT '正課報名ID',
  `id_events` varchar(150) DEFAULT NULL COMMENT '場次ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `events_course` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `id_course` int(11) DEFAULT NULL COMMENT '課程ID',
  `name` varchar(40) DEFAULT NULL COMMENT '場次',
  `location` varchar(255) DEFAULT NULL COMMENT '地址',
  `money` varchar(150) DEFAULT NULL COMMENT '現場完款',
  `money_fivedays` varchar(150) DEFAULT NULL COMMENT '五日內完款',
  `money_installment` varchar(150) DEFAULT NULL COMMENT '分期付款',
  `memo` mediumtext DEFAULT NULL COMMENT '備註',
  `host` varchar(100) DEFAULT NULL COMMENT '主持開場',
  `closeorder` varchar(40) DEFAULT NULL COMMENT '結束收單',
  `weather` varchar(40) DEFAULT NULL COMMENT '天氣',
  `staff` varchar(255) DEFAULT NULL COMMENT '工作人員',
  `id_group` varchar(40) DEFAULT NULL COMMENT '群組ID',
  `course_start_at` timestamp NULL DEFAULT NULL COMMENT '課程開始時間',
  `course_end_at` timestamp NULL DEFAULT NULL COMMENT '課程結束時間',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `unpublish` int(11) DEFAULT NULL COMMENT '不公開(0:否,1:是)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `events_course` (`id`, `id_course`, `name`, `location`, `money`, `money_fivedays`, `money_installment`, `memo`, `host`, `closeorder`, `weather`, `staff`, `id_group`, `course_start_at`, `course_end_at`, `created_at`, `updated_at`, `unpublish`) VALUES
(22, 8, '台北晚上場', '(台北市中山區松江路131號7樓)', '48800', '50800', '52800', NULL, 'Adam', 'Adam', '毛毛雨', '志桐', '15850476008', '2020-03-24 11:00:00', '2020-03-24 14:00:00', '2020-03-23 01:53:05', '2020-03-27 02:28:06', 0),
(23, 9, '台北場', '台北市', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '1585037089', '2020-03-29 01:00:00', '2020-03-29 11:00:00', '2020-03-24 08:04:49', '2020-03-24 08:04:49', 0),
(24, 9, '台北場', '台北市', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '1585037089', '2020-03-28 01:00:00', '2020-03-28 11:00:00', '2020-03-24 08:04:49', '2020-03-24 08:04:49', 0),
(54, 13, '高雄晚上場', '(高雄市苓雅區中正二路175號13樓)', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '158141880013', '2020-02-11 11:00:00', '2020-02-11 14:00:00', '2020-04-05 17:52:00', '2020-04-05 17:52:00', 0),
(55, 14, '高雄場', 'test', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '1586109168', '2020-04-06 00:00:00', '2020-04-06 04:00:00', '2020-04-05 17:52:48', '2020-04-05 17:52:48', 0);

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `isms_status` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '狀態名稱',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `type` varchar(50) DEFAULT NULL COMMENT '類型(0:銷講、正課,1:追單,2:付款狀態,4:活動狀態)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `isms_status` (`id`, `name`, `created_at`, `updated_at`, `type`) VALUES
(1, '已報名', '2020-03-05 02:41:34', '2020-03-05 02:43:17', '0'),
(2, '我很遺憾', '2020-03-05 02:41:34', '2020-03-05 02:43:17', '0'),
(3, '未到', '2020-03-05 02:41:35', '2020-03-05 02:43:17', '0'),
(4, '報到', '2020-03-05 02:41:35', '2020-03-05 02:43:17', '0'),
(5, '取消', '2020-03-05 02:41:35', '2020-03-05 02:43:17', '0'),
(6, '留單', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '2'),
(7, '完款', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '2'),
(8, '付訂', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '2'),
(9, '退費', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '2'),
(10, '付訂', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '1'),
(11, '完款', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '1'),
(12, '待追', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '1'),
(13, '退款中', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '1'),
(14, '退款完成', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '1'),
(15, '無意願', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '1'),
(16, '推薦其他講師', '2020-03-15 14:38:07', '2020-03-15 14:38:07', '1');

CREATE TABLE `mark` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `name_mark` varchar(40) DEFAULT NULL COMMENT '標記名稱',
  `course_id` varchar(50) DEFAULT NULL COMMENT '課程ID',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `message` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student_group` varchar(100) DEFAULT NULL COMMENT '細分組ID',
  `type` varchar(50) DEFAULT NULL COMMENT '類型(0:簡訊,1:email,2:全部)',
  `title` varchar(255) DEFAULT NULL COMMENT '標題',
  `content` mediumtext DEFAULT NULL COMMENT '內容',
  `send_at` timestamp NULL DEFAULT current_timestamp() COMMENT '發送時間',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

CREATE TABLE `notification` (
  `id` int(11) NOT NULL COMMENT 'id',
  `title` varchar(40) NOT NULL COMMENT '推播標題',
  `content` mediumtext NOT NULL COMMENT '推播內容',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `payment` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `cash` varchar(100) NOT NULL COMMENT '付款金額',
  `pay_model` varchar(20) NOT NULL COMMENT '付款方式(0:現金,1:匯款,2:刷卡:輕鬆付,3:刷卡:一次付)',
  `number` varchar(40) NOT NULL COMMENT '卡號後四碼',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `id_registration` int(11) DEFAULT NULL COMMENT '正課報名ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `refund_reason` mediumtext DEFAULT NULL COMMENT '退費原因',
  `pay_model` varchar(50) DEFAULT NULL COMMENT '當時付款方式',
  `account` varchar(30) DEFAULT NULL COMMENT '帳號/卡號後五碼',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `register` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `id_registration` varchar(50) DEFAULT NULL COMMENT '正課報名ID',
  `id_student` varchar(50) DEFAULT NULL COMMENT '學員ID',
  `id_status` varchar(50) DEFAULT NULL COMMENT '狀態ID',
  `id_events` varchar(50) DEFAULT NULL COMMENT '場次ID',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `memo` mediumtext DEFAULT NULL COMMENT '備註'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `registration` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `id_course` int(11) DEFAULT NULL COMMENT '課程ID',
  `amount_payable` varchar(100) NOT NULL COMMENT '應付金額',
  `amount_paid` varchar(100) NOT NULL COMMENT '已付金額',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `sign` varchar(100) DEFAULT NULL COMMENT '簽名檔案',
  `id_events` int(11) NOT NULL COMMENT '場次ID',
  `status_payment` varchar(100) DEFAULT NULL COMMENT '付款狀態',
  `id_debt` int(11) NOT NULL COMMENT '追單ID',
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

CREATE TABLE `rule` (
  `id` int(11) NOT NULL COMMENT 'id',
  `type` varchar(50) DEFAULT NULL COMMENT '類型(0:黑名單,1:細分組)',
  `name` varchar(200) DEFAULT NULL COMMENT '規則名稱',
  `regulation` varchar(200) DEFAULT NULL COMMENT '規則',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `rule_value` varchar(40) DEFAULT NULL COMMENT '規則Value',
  `rule_status` varchar(40) DEFAULT NULL COMMENT '狀態(0:關閉,1:啟動)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rule` (`id`, `type`, `name`, `regulation`, `created_at`, `updated_at`, `rule_value`, `rule_status`) VALUES
(9, '0', '單一課程累積_未到幾次', '1', '2020-03-05 02:44:32', '2020-03-26 05:11:59', '0', '0'),
(10, '0', '單一課程累積_取消幾次', '1', '2020-03-05 02:44:32', '2020-03-26 05:11:59', '1', '0'),
(11, '0', '單一課程累積_未到+取消幾次', '1', '2020-03-05 02:44:32', '2020-03-26 05:11:59', '2', '0'),
(12, '0', '單一課程累積_出席幾次但未留單', '1', '2020-03-05 02:44:32', '2020-03-26 05:11:59', '3', '0'),
(13, '0', '所有課程累積_未到幾次', '0', '2020-03-05 02:44:32', '2020-03-26 05:11:59', '4', '0'),
(14, '0', '所有課程累積_取消幾次', '1', '2020-03-05 02:44:32', '2020-03-26 05:11:59', '5', '0'),
(15, '0', '所有課程累積_未到+取消幾次', '2', '2020-03-05 02:44:32', '2020-03-26 05:11:59', '6', '0');

CREATE TABLE `sales_registration` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `id_course` int(11) DEFAULT NULL COMMENT '課程ID',
  `id_status` int(11) DEFAULT NULL COMMENT '報名狀態ID',
  `pay_model` varchar(20) DEFAULT NULL COMMENT '付款方式',
  `account` varchar(20) DEFAULT NULL COMMENT '帳號/卡號後四碼',
  `course_content` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `submissiondate` varchar(150) DEFAULT NULL COMMENT 'Submission Date',
  `datasource` varchar(255) DEFAULT NULL COMMENT '表單來源',
  `memo` mediumtext DEFAULT NULL COMMENT '報名備註',
  `events` varchar(50) DEFAULT NULL COMMENT '追蹤場次(給我很遺憾用)',
  `id_events` int(11) NOT NULL COMMENT '場次ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sales_registration` (`id`, `id_student`, `id_course`, `id_status`, `pay_model`, `account`, `course_content`, `created_at`, `updated_at`, `submissiondate`, `datasource`, `memo`, `events`, `id_events`) VALUES
(229, 113, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-04-02 13:42:00', '2020-03-22 22:48:17', 'adp2', '朱庭強', NULL, 22),
(230, 114, 8, 5, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:32:09', '2020-03-22 20:43:31', 'seven', NULL, NULL, 22),
(231, 115, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-22 18:47:59', 'ellen', NULL, NULL, 22),
(232, 116, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 11:02:25', '2020-03-22 18:24:26', 'adp2', NULL, NULL, 22),
(233, 117, 8, 4, NULL, NULL, '外匯基礎及交易方式', '2020-03-23 01:53:05', '2020-03-24 10:51:07', '2020-03-22 17:42:47', 'adp', NULL, NULL, 22),
(234, 118, 8, 3, NULL, NULL, '外匯之必勝絕技', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-22 15:00:36', 'adp', NULL, NULL, 22),
(235, 119, 8, 3, NULL, NULL, '你沒老婆小孩吧！全都是騙我的…你這騙心賊', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-22 13:11:13', 'adp', NULL, NULL, 22),
(236, 120, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-22 09:53:11', 'adp2', NULL, NULL, 22),
(237, 121, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-22 09:40:37', 'adp2', NULL, NULL, 22),
(238, 122, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-22 08:20:29', 'adp2', NULL, NULL, 22),
(239, 123, 8, 4, NULL, NULL, '台灣股市', '2020-03-23 01:53:05', '2020-03-24 10:43:27', '2020-03-22 01:21:03', 'adp2', NULL, NULL, 22),
(240, 124, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 10:41:37', '2020-03-21 23:39:28', 'sunnie', NULL, NULL, 22),
(241, 125, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 10:43:21', '2020-03-21 23:38:37', 'sunnie', NULL, NULL, 22),
(242, 126, 8, 3, NULL, NULL, '股票投資理財', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-21 23:03:59', 'adp', NULL, NULL, 22),
(243, 127, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-21 22:20:28', 'adp2', NULL, NULL, 22),
(244, 128, 8, 4, NULL, NULL, '完全沒有投資經驗，到處都是講座書籍，需要尋找適合的投資方式', '2020-03-23 01:53:05', '2020-03-24 11:07:48', '2020-03-21 13:15:31', 'adp2', NULL, NULL, 22),
(245, 129, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 11:03:20', '2020-03-21 13:09:51', 'adp2', NULL, NULL, 22),
(246, 130, 8, 3, NULL, NULL, '外匯操作技術', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-21 10:37:58', 'adp', NULL, NULL, 22),
(247, 131, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 10:41:20', '2020-03-21 09:12:23', 'ellen', NULL, NULL, 22),
(248, 132, 8, 4, NULL, NULL, '如何操作', '2020-03-23 01:53:05', '2020-03-24 10:41:53', '2020-03-21 08:22:33', 'adp2', NULL, NULL, 22),
(249, 133, 8, 3, NULL, NULL, '股市投資', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-21 04:47:40', 'adp', NULL, NULL, 22),
(250, 134, 8, 3, NULL, NULL, '財務自由', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-20 15:47:00', 'adp2', NULL, NULL, 22),
(251, 135, 8, 4, NULL, NULL, '小額無風險投資', '2020-03-23 01:53:05', '2020-03-24 10:43:04', '2020-03-20 10:13:31', 'adp2', NULL, NULL, 22),
(252, 136, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-20 08:12:00', 'adp2', NULL, NULL, 22),
(253, 137, 8, 4, NULL, NULL, '產生被動收入', '2020-03-23 01:53:05', '2020-03-24 10:50:53', '2020-03-19 20:51:13', 'adp', NULL, NULL, 22),
(254, 138, 8, 4, NULL, NULL, '股票操作時機、技巧', '2020-03-23 01:53:05', '2020-03-24 10:51:24', '2020-03-19 20:35:44', 'adp', NULL, NULL, 22),
(255, 139, 8, 3, NULL, NULL, '期貨操作技巧', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-19 06:56:10', 'adp', NULL, NULL, 22),
(256, 140, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-19 06:07:24', 'MGGDN', NULL, NULL, 22),
(257, 141, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-19 01:16:34', 'adp2', NULL, NULL, 22),
(258, 142, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-18 21:32:19', 'adp2', NULL, NULL, 22),
(259, 143, 8, 3, NULL, NULL, '如何投資獲利才能在十年內獲得財務自由', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-18 21:10:26', 'adp2', NULL, NULL, 22),
(260, 144, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 11:22:59', '2020-03-18 11:27:55', 'MGS', '廖傑均', NULL, 22),
(261, 145, 8, 5, NULL, NULL, '財富自由', '2020-03-23 01:53:05', '2020-03-24 06:27:50', '2020-03-18 08:50:50', 'adp2', NULL, NULL, 22),
(262, 146, 8, 3, NULL, NULL, '如何判斷進出場時機', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-18 01:31:10', 'adp', NULL, NULL, 22),
(263, 147, 8, 3, NULL, NULL, '外匯', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-18 00:45:11', 'adp2', NULL, NULL, 22),
(264, 148, 8, 3, NULL, NULL, '外匯', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-17 23:23:32', 'adp2', NULL, NULL, 22),
(265, 149, 8, 3, NULL, NULL, '如何投資', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-17 21:17:48', 'adp', NULL, NULL, 22),
(266, 150, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 11:00:29', '2020-03-17 09:50:26', 'adp', NULL, NULL, 22),
(267, 151, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 10:42:27', '2020-03-17 02:31:54', 'adp', NULL, NULL, 22),
(268, 152, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-16 21:22:17', 'adp2', NULL, NULL, 22),
(269, 153, 8, 4, NULL, NULL, '簡單的操作，短時間如何的選股', '2020-03-23 01:53:05', '2020-03-24 10:50:33', '2020-03-16 20:23:42', 'MGS', NULL, NULL, 22),
(270, 154, 8, 3, NULL, NULL, '如何穩定投資', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-15 00:40:17', 'adp', NULL, NULL, 22),
(271, 155, 8, 3, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-12 16:45:38', 'adp', NULL, NULL, 22),
(272, 156, 8, 4, NULL, NULL, NULL, '2020-03-23 01:53:05', '2020-03-24 10:50:22', '2020-03-12 12:13:17', 'adp2', '郭', NULL, 22),
(273, 157, 8, 3, NULL, NULL, '賺錢', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-11 17:56:49', 'adp', NULL, NULL, 22),
(274, 158, 8, 3, NULL, NULL, '操作外匯', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-07 16:42:47', 'adp2', NULL, NULL, 22),
(275, 159, 8, 3, NULL, NULL, '如何精準投資', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-06 22:46:40', 'adp2', NULL, NULL, 22),
(276, 160, 8, 3, NULL, NULL, '股市操作', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-06 15:01:43', 'adp', NULL, NULL, 22),
(277, 161, 8, 3, NULL, NULL, '賺錢', '2020-03-23 01:53:05', '2020-03-24 06:25:14', '2020-03-05 20:29:03', 'ellenhp', NULL, NULL, 22),
(278, 162, 8, 3, NULL, NULL, '賺錢', '2020-03-24 06:25:09', '2020-03-24 06:25:14', '2020-03-24 10:26:26', 'ellenhp2', NULL, NULL, 22),
(279, 163, 8, 4, NULL, NULL, NULL, '2020-03-24 06:25:09', '2020-03-24 11:05:06', '2020-03-23 18:08:05', 'adp', NULL, NULL, 22),
(280, 164, 8, 3, NULL, NULL, '如何操作股票', '2020-03-24 06:25:09', '2020-03-24 06:25:14', '2020-03-23 13:01:19', 'adp2', NULL, NULL, 22),
(281, 165, 8, 4, NULL, NULL, '', '2020-03-24 10:52:21', '2020-03-24 10:52:21', '2020-03-24 18:52:21', '現場', '現場報名', NULL, 22),
(323, 204, 13, 1, NULL, NULL, NULL, '2020-04-05 17:52:00', '2020-04-05 17:52:00', '2020-02-05 12:37:44', 'hhj2', NULL, NULL, 54);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期',
  `check_blacklist` int(11) NOT NULL DEFAULT 0 COMMENT '判斷是否為黑名單(1:是,0:否)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `student` (`id`, `name`, `sex`, `id_identity`, `phone`, `email`, `birthday`, `company`, `profession`, `address`, `created_at`, `updated_at`, `check_blacklist`) VALUES
(113, 'Bruce Chu', '', '', '0912895768', 'olajuding@gmail.com', '', '', '自由業', NULL, '2020-03-23 01:53:05', '2020-04-02 13:42:00', 0),
(114, '王惟民', '', '', '0922625330', 'andywm_wang@yahoo.com.tw', '', '', '顧問', NULL, '2020-03-23 01:53:05', '2020-03-26 05:12:05', 0),
(115, '沈育蓁', '', '', '0923223149', 'joyceshen26@gmail.com', '', '', '金屬工程', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(116, '陳梓涵', '', '', '0935189393', 'pennymiss4@gmail.com', '', '', '品檢人員', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(117, '潘佳駿', '', '', '0909131731', 'panrock0603@gmail.com', '', '', '顧問', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(118, '謝小棠', '', '', '0986968971', 'ok20121210@gmail.com', '', '', '業務主任', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(119, '陳宥任', '', '', '0927529877', 'chen.sandy@kimo.com', '', '', '無業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(120, '王譽琇', '', '', '0919424113', 'annalife99@yahoo.com', '', '', '無', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(121, '蕭顗庭', '', '', '0989121108', 'mickey_hsiao@yahoo.com.tw', '', '', '助工', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(122, '翁振輝', '', '', '0975122204', 'berserker.01.tw@hotmail.com', '', '', 'Rd', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(123, '張傑瑞', '', '', '0953770805', 'jerry585168101@gmail.com', '', '', '退休', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(124, '葉佑翔', '', '', '0983559978', 'yayosiang@gmail.com', '', '', '自由業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(125, '張以柔', '', '', '0970176683', 'freakoutseven@gmail.com', '', '', '自由業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(126, '陳恩熙', '', '', '0936115266', 'think173@gmail.com', '', '', '自由業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(127, 'Lisa', '', '', '0918873819', 'linlishao8268@gmail.com', '', '', '服務業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(128, '劉小魚', '', '', '0911933838', 'zoeliu828@gmail.com', '', '', '銷售', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(129, '周志傑', '', '', '0970663804', 'jeffcchou@qq.com', '', '', '服務業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(130, '元均', '', '', '0909338807', 'jinfeng0824@gmail.comcom', '', '', '家管', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(131, '袁先生', '', '', '0926428302', 'mdmsgwx@yahoo.com.tw', '', '', '自己創業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(132, '羅曼玲', '', '', '0911559714', 's29281620@gmail.com', '', '', '行政', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(133, '王大明', '', '', '0938066925', 'damin0929@163.com', '', '', '退休', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(134, '王舒云', '', '', '0905065408', 'ks.19o_o@yahoo.com.tw', '', '', '美容師', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(135, '徐睿希', '', '', '0927066359', 'hoin1234567@kimo.com', '', '', '護理', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(136, '賴英詩', '', '', '0939913312', 'us_0328@yahoo.com.tw', '', '', '造型師', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(137, '楊舒涵', '', '', '0919305289', 'alinayang0908@gmail.com', '', '', '服務', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(138, '易邵韓', '', '', '0979002200', 'Eason779621@gmail.com', '', '', '商', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(139, '曾伊莉', '', '', '0920647805', 'anita01110111@gmail.com', '', '', '金融', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(140, 'Snow', '', '', '0988186891', 'ladycool.snow@gmail.com', '', '', 'Free', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(141, ',馮雅婷', '', '', '0911742765', 'Cake806@yahoo.com.tw', '', '', '美髮', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(142, '林洲田', '', '', '0909219657', 'biginlin@gmail.com', '', '', '網路事業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(143, '陳佩宜', '', '', '0960368545', 'hp30530@gmail.com', '', '', '上班族', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(144, '廖先生', '', '', '0934369699', 'kk048260@gmail.com', '', '', '金融', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(145, '葉惠菁', '', '', '0932225030', 'jing90@kimo.com', '', '', '美睫師', NULL, '2020-03-23 01:53:05', '2020-03-26 05:12:06', 0),
(146, '凌富華', '', '', '0988239497', 'grace062614@gmail.com', '', '', '會計', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(147, '王淑娟', '', '', '0920170898', 'helen19661119@gmail.com', '', '', '清潔', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(148, 'Eva chou', '', '', '0918995112', 'evacello1212@yahoo.com.tw', '', '', '上班族', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(149, '林庭毅', '', '', '0905078180', 'ohshit98@icloud.com', '', '', '保全', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(150, '章容甄', '', '', '0922006959', 'changjungchen@gmail.com', '', '', '都市計畫', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(151, '黃薏庭', '', '', '0920625439', 'nanabo09@hotmail.com', '', '', '採購', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(152, '陳勇汀', '', '', '0920156881', 'ekin0929@hotmail.com', '', '', '金融', NULL, '2020-03-23 01:53:05', '2020-03-31 15:22:35', 1),
(153, '李沛蓉', '', '', '0919928179', 'f.77889910@gmail.com', '', '', '無', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(154, '邱鈺娟', '', '', '0918585125', 'v10505@yahoo.com.tw', '', '', '工程師', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(155, '蘇聖心', '', '', '0909531096', 'sandysu@everfuntravel.com', '', '', '旅遊業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(156, 'Iris kuo', '', '', '0975315613', 'kuoiris5613@gmail.com', '', '', '業務', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(157, '陳先生', '', '', '0909251777', 'sevenabu@gmail.com', '', '', '商', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(158, 'Magic', '', '', '0955461098', 'william80342@gmail.com', '', '', '無', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(159, 'Alyson kuo', '', '', '0911565255', 'kaizokuo708@gmail.com', '', '', '設計師', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(160, '林怡菁', '', '', '0920745945', '660129aki@gmail.com', '', '', '設計業', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(161, '廖先偉', '', '', '0920609626', 'qqww1215@gmail.com', '', '', '工程', NULL, '2020-03-23 01:53:05', '2020-03-23 01:53:05', 0),
(162, '林庭毅', '', '', '0905078190', 'ohshit98@icloud.com', '', '', '保全', NULL, '2020-03-24 06:25:09', '2020-03-24 06:25:09', 0),
(163, '陳炳男', '', '', '0952790036', 'cbn369@gmail.com', '', '', '退休', NULL, '2020-03-24 06:25:09', '2020-03-24 06:25:09', 0),
(164, '林佑瑄', '', '', '0908159045', 'siroha1215@gmail.com', '', '', '網拍業者', NULL, '2020-03-24 06:25:09', '2020-03-24 06:25:09', 0),
(165, '陳誌陞', '', '', '0980098144', NULL, '', '', NULL, NULL, '2020-03-24 10:52:21', '2020-03-24 10:52:21', 0),
(166, 'test', '男', '123456789', '0900000000', '000@gmail.com', '1999-01-01', NULL, NULL, '000', '2020-03-25 06:09:07', '2020-03-25 06:09:07', 0),
(167, '鄭雅裕', '', '', '0909838999', 'sade408@gmail.comp', '', '', '自由', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(168, '陳柏亘', '', '', '0978830678', 'paikengc@usc.edu', '', '', 'Ss', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(169, '徐莉莉', '', '', '0968778849', 'kirin.liu@gmail.com', '', '', '職員', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(170, '林英娜', '', '', '0928384825', 'ena6666@gmaiI.xn--com-ft1hy65c', '', '', '自由', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(171, '詹家維', '', '', '0926325181', 'jacks1220@hotmail.com', '', '', '師傅', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(172, '詹美玲', '', '', '0955073432', 'birdiechan@pchome.com.tw', '', '', '網拍', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(173, '陳淑金', '', '', '0931968277', 'shu83ching@mail.com', '', '', '金融業', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(174, '楊子賢', '', '', '0987821380', 'me83111@icloud.com', '', '', '夜市攤販', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(175, '陳世哲', '', '', '0913225313', 'brianchen0401@gmail.com', '', '', '待業', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(176, '鍾政憲', '', '', '0987673395', 'bmghty97@gmail.com', '', '', '總經理', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(177, 'Chen', '', '', '0916357361', 'ilovethisgame47@gmail.com', '', '', '行政人員', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(178, '呂玲玲', '', '', '0972856602', 'ling_ling_lu@yahoo.com', '', '', '無', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(179, '海霞', '', '', '0907282619', '369728596@qq.com', '', '', '銷售', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(180, '何恭杰', '', '', '0900162318', 'a0968309648@icloud.com', '', '', '工', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(181, '陳彥宏', '', '', '0928485777', 'zzxxccvv2010@gmail.com', '', '', '員工', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(182, '李湘美', '', '', '0989664045', 'rimey0107@gmail.com', '', '', '美容師', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(183, '蕭文華', '', '', '0910318940', 'ryangela88@gmail.com', '', '', '餐廳', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(184, '黃美雪', '', '', '0939623689', 'sherryhwung@gmail.com', '', '', '無', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(185, '詹怡婷', '', '', '0931570401', '15801758994@qq.com', '', '', '待業中', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(186, '蔡秀足', '', '', '0938569685', 'lanny0086@gmail.com', '', '', '家管', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(187, '張瓊良', '', '', '0932922566', 'td27532108@yahoo.com.tw', '', '', '商，經理', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(188, 'marko', '', '', '0909234131', 'marko1126@gmail.com', '', '', '商', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(189, '簡佑堉', '', '', '0918211706', 'a951210233@yahoo.com.tw', '', '', '營業員', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(190, '林小玲', '', '', '0989647145', 'chinwei016@gmail.com', '', '', '自由業', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(191, '蔡佩玲', '', '', '0926283131', 'i9280pepe@gmail.com', '', '', '服務業', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(192, '王雪虹', '', '', '0988970258', 'snowrainbow101@gmail.com', '', '', '財務規劃', NULL, '2020-03-26 03:12:10', '2020-03-26 03:12:10', 0),
(193, '張三', '', '', '0935434248', 'peter1@test.com', '', '', '餐飲業', '新北', '2020-03-26 10:12:24', '2020-03-26 10:12:24', 0),
(194, '李四', '', '', '0934434234', 'yoyo@test.com', '', '', '服務業', '台東', '2020-03-26 10:12:24', '2020-03-26 10:12:24', 0),
(195, '吳阿杰', '', '', '0978203943', '2312@test.com', '', '', '設計業', '嘉義', '2020-03-26 10:12:24', '2020-03-26 10:12:24', 0),
(196, '周明倫', '', '', '0920849432', 'ddd@test.com', '', '', '服務業', '南投', '2020-03-26 10:12:24', '2020-03-26 10:12:24', 0),
(197, '王曉花', '', '', '0932342999', 'aaa@test.com', '', '', '資訊業', '基隆', '2020-03-26 10:12:24', '2020-03-26 10:12:24', 0),
(198, '吳曉華', '', '', '0923424430', 'bbb@test.com', '', '', '服務業', '嘉義', '2020-03-26 10:12:24', '2020-03-26 10:12:24', 0),
(199, '蔡阿嘎', '', '', '0977674301', 'ccc@test.com', '', '', '服務業', '基隆', '2020-03-26 10:12:24', '2020-03-26 10:12:24', 0),
(200, 'test', '男', 'S000000000', '000', '000@test.com', '1979-08-22', 'test', 'test', 'test', '2020-03-31 15:24:20', '2020-04-01 02:27:38', 0),
(201, '000', '男', '11', '221', NULL, '1938-01-01', NULL, NULL, '', '2020-03-31 15:27:50', '2020-03-31 15:27:50', 0),
(202, 'test01', NULL, NULL, '0977', NULL, NULL, NULL, NULL, '', '2020-04-01 00:10:29', '2020-04-01 00:11:17', 0),
(203, '123', NULL, NULL, '2223', NULL, NULL, NULL, NULL, '', '2020-04-01 00:12:13', '2020-04-01 00:16:13', 0),
(204, '涂景翔', '', '', '0935285935', 'tsimon7000@yahoo.com.tw', '', '', '手工皂', NULL, '2020-04-05 17:52:00', '2020-04-05 17:52:00', 0),
(205, 'test', NULL, NULL, '123123123', NULL, NULL, NULL, NULL, '', '2020-04-05 17:53:44', '2020-04-05 17:53:44', 0);

CREATE TABLE `student_group` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_group` varchar(150) DEFAULT NULL COMMENT '分組ID',
  `name` varchar(150) DEFAULT NULL COMMENT '細分組名稱',
  `condition` varchar(200) DEFAULT NULL COMMENT '條件',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `student_group` (`id`, `id_group`, `name`, `condition`, `created_at`, `updated_at`) VALUES
(9, NULL, '0324黑心銷講報到', NULL, '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(12, NULL, 'test2', NULL, '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(13, NULL, 'test2', NULL, '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(14, NULL, 'test0407', '1 - 篩選器1:請選擇/2020/04/07 - 2020/04/07/名單資料<br><hr>2 - 篩選器1:請選擇/2020/04/07 - 2020/04/07/名單資料<br>2 - 篩選器2:請選擇/2020/04/07 - 2020/04/07/名單資料<br><hr>3 - 篩選器1:請選擇/2020/04/07 - 2020/04/07/名單資料<br>3 - 篩選器2:請選擇', '2020-04-07 04:53:51', '2020-04-07 04:53:51');

CREATE TABLE `student_groupdetail` (
  `id` int(11) NOT NULL COMMENT 'id',
  `id_student` varchar(150) DEFAULT NULL COMMENT '學員ID',
  `id_group` varchar(150) DEFAULT NULL COMMENT '分組ID',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `student_groupdetail` (`id`, `id_student`, `id_group`, `created_at`, `updated_at`) VALUES
(13, '2', '7', '2020-03-22 12:42:39', '2020-03-22 12:42:39'),
(14, '3', '7', '2020-03-22 12:42:39', '2020-03-22 12:42:39'),
(15, '2', '8', '2020-03-22 12:42:43', '2020-03-22 12:42:43'),
(16, '3', '8', '2020-03-22 12:42:43', '2020-03-22 12:42:43'),
(17, '113', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(18, '116', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(19, '117', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(20, '123', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(21, '124', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(22, '125', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(23, '128', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(24, '129', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(25, '131', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(26, '132', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(27, '135', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(28, '137', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(29, '138', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(30, '144', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(31, '150', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(32, '151', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(33, '153', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(34, '156', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(35, '163', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(36, '165', '9', '2020-03-26 05:28:29', '2020-03-26 05:28:29'),
(77, '113', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(78, '114', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(79, '115', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(80, '116', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(81, '117', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(82, '118', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(83, '119', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(84, '120', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(85, '121', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(86, '122', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(87, '123', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(88, '124', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(89, '125', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(90, '126', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(91, '127', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(92, '128', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(93, '129', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(94, '130', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(95, '131', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(96, '132', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(97, '133', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(98, '134', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(99, '135', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(100, '136', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(101, '137', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(102, '138', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(103, '139', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(104, '140', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(105, '141', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(106, '142', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(107, '143', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(108, '144', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(109, '145', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(110, '146', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(111, '147', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(112, '148', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(113, '149', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(114, '150', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(115, '151', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(116, '152', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(117, '153', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(118, '154', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(119, '155', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(120, '156', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(121, '157', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(122, '158', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(123, '159', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(124, '160', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(125, '161', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(126, '162', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(127, '163', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(128, '164', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(129, '165', '12', '2020-03-26 09:33:47', '2020-03-26 09:33:47'),
(130, '113', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(131, '114', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(132, '115', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(133, '116', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(134, '117', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(135, '118', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(136, '119', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(137, '120', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(138, '121', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(139, '122', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(140, '123', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(141, '124', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(142, '125', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(143, '126', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(144, '127', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(145, '128', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(146, '129', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(147, '130', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(148, '131', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(149, '132', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(150, '133', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(151, '134', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(152, '135', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(153, '136', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(154, '137', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(155, '138', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(156, '139', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(157, '140', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(158, '141', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(159, '142', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(160, '143', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(161, '144', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(162, '145', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(163, '146', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(164, '147', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(165, '148', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(166, '149', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(167, '150', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(168, '151', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(169, '152', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(170, '153', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(171, '154', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(172, '155', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(173, '156', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(174, '157', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(175, '158', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(176, '159', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(177, '160', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(178, '161', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(179, '162', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(180, '163', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(181, '164', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37'),
(182, '165', '13', '2020-03-26 09:44:37', '2020-03-26 09:44:37');

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '講師姓名',
  `phone` varchar(40) NOT NULL COMMENT '電話',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `teacher` (`id`, `name`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Juila', '', '2020-03-05 02:41:35', '2020-03-05 02:41:35'),
(2, 'Jack', '', '2020-03-05 02:41:35', '2020-03-05 02:41:35'),
(3, 'Mark', '', '2020-03-05 02:41:35', '2020-03-05 02:41:35'),
(4, '百萬狙擊操盤手', '', '2020-03-26 03:12:09', '2020-03-26 03:12:09'),
(5, 'test', '', '2020-03-26 10:12:24', '2020-03-26 10:12:24'),
(6, 'test02', '', '2020-03-26 10:13:24', '2020-03-26 10:13:24');

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

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `account`, `role`) VALUES
(1, '管理員', 'admin@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'admin', 'admin'),
(2, '數據分析人員', 'dataanalysis@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'dataanalysis', 'dataanalysis'),
(3, '行銷人員', 'marketer@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'marketer', 'marketer'),
(4, '財會人員', 'accountant@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'accountant', 'accountant'),
(5, '現場人員', 'staff@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'staff', 'staff'),
(6, '講師', 'teacher@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'teacher', 'teacher');


ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`);

ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_teacher` (`id_teacher`);

ALTER TABLE `debt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_status` (`id_status`),
  ADD KEY `id_registration` (`id_registration`);

ALTER TABLE `events_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_course` (`id_course`);

ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `isms_status`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`);

ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`);

ALTER TABLE `refund`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_registration` (`id_registration`);

ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_course` (`id_course`),
  ADD KEY `id_events` (`id_events`),
  ADD KEY `id_debt` (`id_debt`);

ALTER TABLE `rule`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sales_registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_course` (`id_course`),
  ADD KEY `id_status` (`id_status`),
  ADD KEY `id_events` (`id_events`);

ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `student_group`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `student_groupdetail`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);


ALTER TABLE `blacklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=219;

ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=15;

ALTER TABLE `debt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

ALTER TABLE `events_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=56;

ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `isms_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=17;

ALTER TABLE `mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;

ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id';

ALTER TABLE `refund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=13;

ALTER TABLE `rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=16;

ALTER TABLE `sales_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=324;

ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=206;

ALTER TABLE `student_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=15;

ALTER TABLE `student_groupdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=183;

ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=7;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `blacklist`
  ADD CONSTRAINT `blacklist_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`);

ALTER TABLE `debt`
  ADD CONSTRAINT `debt_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `debt_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `isms_status` (`id`);

ALTER TABLE `events_course`
  ADD CONSTRAINT `events_course_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `course` (`id`);

ALTER TABLE `mark`
  ADD CONSTRAINT `mark_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`);

ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`);

ALTER TABLE `refund`
  ADD CONSTRAINT `refund_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `refund_ibfk_2` FOREIGN KEY (`id_registration`) REFERENCES `registration` (`id`);

ALTER TABLE `registration`
  ADD CONSTRAINT `registration_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `registration_ibfk_6` FOREIGN KEY (`id_debt`) REFERENCES `debt` (`id`);

ALTER TABLE `sales_registration`
  ADD CONSTRAINT `sales_registration_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `sales_registration_ibfk_3` FOREIGN KEY (`id_status`) REFERENCES `isms_status` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
