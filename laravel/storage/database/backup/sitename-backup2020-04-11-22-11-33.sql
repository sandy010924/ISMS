-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: 127.0.0.1	Database: ISMS
-- ------------------------------------------------------
-- Server version 	5.5.5-10.1.29-MariaDB
-- Date: Sat, 11 Apr 2020 22:11:33 +0800

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
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;

-- Dumped table `blacklist` with 0 row(s)
--

--
-- Dumping data for table `course`
--

/*!40000 ALTER TABLE `course` DISABLE KEYS */;
/*!40000 ALTER TABLE `course` ENABLE KEYS */;

-- Dumped table `course` with 0 row(s)
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
/*!40000 ALTER TABLE `events_course` ENABLE KEYS */;

-- Dumped table `events_course` with 0 row(s)
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
INSERT INTO `m_database` VALUES (1,'0410.sql','2020-04-10 15:00:37','2020-04-11 07:55:24'),(2,'isms_server_data.sql','2020-04-10 15:00:37','2020-04-11 07:55:24'),(3,'sitename-backup2020-04-11-22-05-24.sql','2020-04-11 14:05:24','2020-04-11 14:05:24');
/*!40000 ALTER TABLE `m_database` ENABLE KEYS */;

-- Dumped table `m_database` with 3 row(s)
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
INSERT INTO `teacher` VALUES (1,'Juila','','2020-04-10 23:55:19','2020-04-10 23:55:19'),(2,'Jack','','2020-04-10 23:55:19','2020-04-10 23:55:19'),(3,'Mark','','2020-04-10 23:55:19','2020-04-10 23:55:19');
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

-- Dump completed on: Sat, 11 Apr 2020 22:11:33 +0800
