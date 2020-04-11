SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


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

INSERT INTO `m_database` (`id`, `filename`, `created_at`, `updated_at`) VALUES
(1, '0410.sql', '2020-04-10 15:00:37', '2020-04-11 07:55:24');

INSERT INTO `rule` (`id`, `type`, `name`, `regulation`, `created_at`, `updated_at`, `rule_value`, `rule_status`) VALUES
(1, '0', '單一課程累積_未到幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '0', '1'),
(2, '0', '單一課程累積_取消幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '1', '1'),
(3, '0', '單一課程累積_未到+取消幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '2', '1'),
(4, '0', '單一課程累積_出席幾次但未留單', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '3', '1'),
(5, '0', '所有課程累積_未到幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '4', '1'),
(6, '0', '所有課程累積_取消幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '5', '1'),
(7, '0', '所有課程累積_未到+取消幾次', '0', '2020-04-11 07:55:21', '2020-04-11 07:55:21', '6', '1');

INSERT INTO `teacher` (`id`, `name`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Juila', '', '2020-04-11 07:55:19', '2020-04-11 07:55:19'),
(2, 'Jack', '', '2020-04-11 07:55:19', '2020-04-11 07:55:19'),
(3, 'Mark', '', '2020-04-11 07:55:19', '2020-04-11 07:55:19');

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `account`, `role`) VALUES
(1, '管理員', 'admin@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'admin', 'admin'),
(2, '數據分析人員', 'dataanalysis@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'dataanalysis', 'dataanalysis'),
(3, '行銷人員', 'marketer@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'marketer', 'marketer'),
(4, '財會人員', 'accountant@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'accountant', 'accountant'),
(5, '現場人員', 'staff@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'staff', 'staff'),
(6, '講師', 'teacher@gmail.com', NULL, '$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S', NULL, NULL, NULL, 'teacher', 'teacher');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
