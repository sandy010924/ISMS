-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: 127.0.0.1	Database: ISMS
-- ------------------------------------------------------
-- Server version 	5.5.5-10.1.29-MariaDB
-- Date: Sat, 11 Apr 2020 22:33:08 +0800

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `blacklist`
--

/*!40000 ALTER TABLE `blacklist` DISABLE KEYS */;
INSERT INTO `blacklist` VALUES (218,152,'','2020-03-31 15:22:35','2020-03-31 15:22:35');
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;

-- Dumped table `blacklist` with 1 row(s)
--

--
-- Dumping data for table `course`
--

/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (8,2,'黑心外匯交易員的告白','1','2020-03-23 01:53:05','2020-03-25 06:45:03',NULL,'課程內容：\r\n\r\n\r\n四組專屬交易策略包含\r\n*三項每日操盤策略\r\n*超過十個季節性交易資訊\r\n*成為一個專職交易員該有的心態\r\n*如何遵守嚴格的風險控管\r\n*學長姊寶貴經驗分享\r\n\r\n---------------------------------\r\n\r\n報名贈送：\r\n\r\n*兩個整天實體培訓課程\r\n*六個月指導教練諮詢\r\n*複訓後交流群組\r\n*終身不限次數免學費複訓（酌收場地費用）\r\n*終身不定期複習會（酌收場地費用）\r\n*指定銀行刷卡分期零利率\r\n*當天完款獲得百支輔導課程影片','99800'),(9,2,'自在交易工作坊','2','2020-03-24 08:04:49','2020-03-26 09:24:53','8','test','9600'),(13,1,'test','1','2020-04-05 17:52:00','2020-04-05 17:52:00',NULL,NULL,NULL),(14,1,'test2','2','2020-04-05 17:52:48','2020-04-05 17:53:11','13','test\r\ntest\r\ntest','96000');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;

-- Dumped table `course` with 4 row(s)
--

--
-- Dumping data for table `debt`
--

/*!40000 ALTER TABLE `debt` DISABLE KEYS */;
/*!40000 ALTER TABLE `debt` ENABLE KEYS */;

-- Dumped table `debt` with 0 row(s)
--

--
-- Dumping data for table `events_course`
--

/*!40000 ALTER TABLE `events_course` DISABLE KEYS */;
INSERT INTO `events_course` VALUES (22,8,'台北晚上場','(台北市中山區松江路131號7樓)','48800','50800','52800',NULL,'Adam','Adam','毛毛雨','志桐','15850476008','2020-03-24 11:00:00','2020-03-24 14:00:00','2020-03-23 01:53:05','2020-03-27 02:28:06',0),(23,9,'台北場','台北市',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'1585037089','2020-03-29 01:00:00','2020-03-29 11:00:00','2020-03-24 08:04:49','2020-03-24 08:04:49',0),(24,9,'台北場','台北市',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'1585037089','2020-03-28 01:00:00','2020-03-28 11:00:00','2020-03-24 08:04:49','2020-03-24 08:04:49',0),(54,13,'高雄晚上場','(高雄市苓雅區中正二路175號13樓)',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'158141880013','2020-02-11 11:00:00','2020-02-11 14:00:00','2020-04-05 17:52:00','2020-04-05 17:52:00',0),(55,14,'高雄場','test',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,'1586109168','2020-04-06 00:00:00','2020-04-06 04:00:00','2020-04-05 17:52:48','2020-04-05 17:52:48',0);
/*!40000 ALTER TABLE `events_course` ENABLE KEYS */;

-- Dumped table `events_course` with 5 row(s)
--

--
-- Dumping data for table `isms_status`
--

/*!40000 ALTER TABLE `isms_status` DISABLE KEYS */;
INSERT INTO `isms_status` VALUES (1,'已報名','2020-04-11 07:55:19','2020-04-11 07:55:22','0'),(2,'我很遺憾','2020-04-11 07:55:19','2020-04-11 07:55:22','0'),(3,'未到','2020-04-11 07:55:20','2020-04-11 07:55:22','0'),(4,'報到','2020-04-11 07:55:20','2020-04-11 07:55:22','0'),(5,'取消','2020-04-11 07:55:20','2020-04-11 07:55:22','0'),(6,'留單','2020-04-11 07:55:22','2020-04-11 07:55:22','2'),(7,'完款','2020-04-11 07:55:22','2020-04-11 07:55:22','2'),(8,'付訂','2020-04-11 07:55:22','2020-04-11 07:55:22','2'),(9,'退費','2020-04-11 07:55:22','2020-04-11 07:55:22','2'),(10,'付訂','2020-04-11 07:55:22','2020-04-11 07:55:22','1'),(11,'完款','2020-04-11 07:55:22','2020-04-11 07:55:22','1'),(12,'待追','2020-04-11 07:55:22','2020-04-11 07:55:22','1'),(13,'退款中','2020-04-11 07:55:22','2020-04-11 07:55:22','1'),(14,'退款完成','2020-04-11 07:55:22','2020-04-11 07:55:22','1'),(15,'無意願','2020-04-11 07:55:22','2020-04-11 07:55:22','1'),(16,'推薦其他講師','2020-04-11 07:55:22','2020-04-11 07:55:22','1');
/*!40000 ALTER TABLE `isms_status` ENABLE KEYS */;

-- Dumped table `isms_status` with 16 row(s)
--

--
-- Dumping data for table `m_database`
--

/*!40000 ALTER TABLE `m_database` DISABLE KEYS */;
INSERT INTO `m_database` VALUES (1,'sitename-backup2020-04-11-22-33-06.sql','2020-04-11 14:33:07','2020-04-11 14:33:07');
/*!40000 ALTER TABLE `m_database` ENABLE KEYS */;

-- Dumped table `m_database` with 1 row(s)
--

--
-- Dumping data for table `mark`
--

/*!40000 ALTER TABLE `mark` DISABLE KEYS */;
/*!40000 ALTER TABLE `mark` ENABLE KEYS */;

-- Dumped table `mark` with 0 row(s)
--

--
-- Dumping data for table `message`
--

/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

-- Dumped table `message` with 0 row(s)
--

--
-- Dumping data for table `migrations`
--

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumped table `migrations` with 0 row(s)
--

--
-- Dumping data for table `notification`
--

/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;

-- Dumped table `notification` with 0 row(s)
--

--
-- Dumping data for table `payment`
--

/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;

-- Dumped table `payment` with 0 row(s)
--

--
-- Dumping data for table `refund`
--

/*!40000 ALTER TABLE `refund` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund` ENABLE KEYS */;

-- Dumped table `refund` with 0 row(s)
--

--
-- Dumping data for table `register`
--

/*!40000 ALTER TABLE `register` DISABLE KEYS */;
/*!40000 ALTER TABLE `register` ENABLE KEYS */;

-- Dumped table `register` with 0 row(s)
--

--
-- Dumping data for table `registration`
--

/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration` ENABLE KEYS */;

-- Dumped table `registration` with 0 row(s)
--

--
-- Dumping data for table `rule`
--

/*!40000 ALTER TABLE `rule` DISABLE KEYS */;
INSERT INTO `rule` VALUES (1,'0','單一課程累積_未到幾次','0','2020-04-11 07:55:21','2020-04-11 07:55:21','0','1'),(2,'0','單一課程累積_取消幾次','0','2020-04-11 07:55:21','2020-04-11 07:55:21','1','1'),(3,'0','單一課程累積_未到+取消幾次','0','2020-04-11 07:55:21','2020-04-11 07:55:21','2','1'),(4,'0','單一課程累積_出席幾次但未留單','0','2020-04-11 07:55:21','2020-04-11 07:55:21','3','1'),(5,'0','所有課程累積_未到幾次','0','2020-04-11 07:55:21','2020-04-11 07:55:21','4','1'),(6,'0','所有課程累積_取消幾次','0','2020-04-11 07:55:21','2020-04-11 07:55:21','5','1'),(7,'0','所有課程累積_未到+取消幾次','0','2020-04-11 07:55:21','2020-04-11 07:55:21','6','1');
/*!40000 ALTER TABLE `rule` ENABLE KEYS */;

-- Dumped table `rule` with 7 row(s)
--

--
-- Dumping data for table `sales_registration`
--

/*!40000 ALTER TABLE `sales_registration` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_registration` ENABLE KEYS */;

-- Dumped table `sales_registration` with 0 row(s)
--

--
-- Dumping data for table `student`
--

/*!40000 ALTER TABLE `student` DISABLE KEYS */;
/*!40000 ALTER TABLE `student` ENABLE KEYS */;

-- Dumped table `student` with 0 row(s)
--

--
-- Dumping data for table `student_group`
--

/*!40000 ALTER TABLE `student_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_group` ENABLE KEYS */;

-- Dumped table `student_group` with 0 row(s)
--

--
-- Dumping data for table `student_groupdetail`
--

/*!40000 ALTER TABLE `student_groupdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_groupdetail` ENABLE KEYS */;

-- Dumped table `student_groupdetail` with 0 row(s)
--

--
-- Dumping data for table `teacher`
--

/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` VALUES (1,'Juila','','2020-04-11 07:55:19','2020-04-11 07:55:19'),(2,'Jack','','2020-04-11 07:55:19','2020-04-11 07:55:19'),(3,'Mark','','2020-04-11 07:55:19','2020-04-11 07:55:19');
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;

-- Dumped table `teacher` with 3 row(s)
--

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'管理員','admin@gmail.com',NULL,'$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S',NULL,NULL,NULL,'admin','admin'),(2,'數據分析人員','dataanalysis@gmail.com',NULL,'$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S',NULL,NULL,NULL,'dataanalysis','dataanalysis'),(3,'行銷人員','marketer@gmail.com',NULL,'$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S',NULL,NULL,NULL,'marketer','marketer'),(4,'財會人員','accountant@gmail.com',NULL,'$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S',NULL,NULL,NULL,'accountant','accountant'),(5,'現場人員','staff@gmail.com',NULL,'$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S',NULL,NULL,NULL,'staff','staff'),(6,'講師','teacher@gmail.com',NULL,'$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S',NULL,NULL,NULL,'teacher','teacher');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumped table `users` with 6 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Sat, 11 Apr 2020 22:33:08 +0800
