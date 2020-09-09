-- 2019/12/10 新建資料表

-- menu table
CREATE TABLE IF NOT EXISTS `menu`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `ref` VARCHAR(10) NOT NULL COMMENT '模組編號',
   `title` VARCHAR(40) NOT NULL COMMENT '標題',
   `title_en` VARCHAR(40) NOT NULL COMMENT '英文標題',
   `href` VARCHAR(40) NOT NULL COMMENT '連結',
   `target` VARCHAR(10) NOT NULL COMMENT '分頁開啟設定',
   `sort` VARCHAR(10) NOT NULL COMMENT '頁面排序',
   `iscontrol` VARCHAR(10) NOT NULL COMMENT '頁面是否被控制(否 = 0,是 = 1)',     
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- role table
CREATE TABLE IF NOT EXISTS `role`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `name` VARCHAR(40) NOT NULL COMMENT '角色名稱',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- member table
CREATE TABLE IF NOT EXISTS `member`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `name` VARCHAR(40) NOT NULL COMMENT '姓名',
   `id_role` INT COMMENT '角色ID',   
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_role) REFERENCES role (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- notification 推播
CREATE TABLE IF NOT EXISTS `notification`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `title` VARCHAR(40) NOT NULL COMMENT '推播標題',
   `content` VARCHAR(65535) NOT NULL COMMENT '推播內容',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- teacher 講師資料表
CREATE TABLE IF NOT EXISTS `teacher`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `name` VARCHAR(40) NOT NULL COMMENT '講師姓名',
   `phone` VARCHAR(40) NOT NULL COMMENT '電話',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- course 課程資料表
CREATE TABLE IF NOT EXISTS `course`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_teacher` INT COMMENT '講師ID',  
   `name` VARCHAR(40) NOT NULL COMMENT '課程名稱',
   `location` VARCHAR(40) NOT NULL COMMENT '課程地點',
   `course_at` timestamp not null default  CURRENT_TIMESTAMP COMMENT '課程日期',
   `memo` VARCHAR(65535) NOT NULL COMMENT '課程備註',
   `type` VARCHAR(40) NOT NULL COMMENT '課程類型(0:銷講,1:正課)',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_teacher) REFERENCES teacher (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- student 學員資料表
CREATE TABLE IF NOT EXISTS `student`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `name` VARCHAR(40) NOT NULL COMMENT '學員姓名',
   `sex` VARCHAR(5)  NULL COMMENT '性別',
   `id_identity` VARCHAR(20)  NULL COMMENT '身分證',
   `phone` VARCHAR(20) NOT NULL COMMENT '電話',
   `email` VARCHAR(20) NOT NULL COMMENT 'email',
   `birthday` VARCHAR(30)  NULL COMMENT '生日',
   `company` VARCHAR(30)  NULL COMMENT '公司名稱',   
   `profession` VARCHAR(30) NOT NULL COMMENT '職業',
   `address` VARCHAR(40) NOT NULL COMMENT '居住地區',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- isms_status  報名狀態資料表
CREATE TABLE IF NOT EXISTS `wcm_status`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `name` VARCHAR(40) NOT NULL COMMENT '狀態名稱',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- sales_registration  銷講報名資料表
CREATE TABLE IF NOT EXISTS `sales_registration`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_student` INT COMMENT '學員ID',  
   `id_course` INT COMMENT '課程ID',  
   `id_status` INT COMMENT '報名狀態ID',  
   `pay_model` VARCHAR(20) NOT NULL COMMENT '付款方式',
   `account` VARCHAR(20) NOT NULL COMMENT '帳號/卡號後四碼',   
   `course_content` VARCHAR(65535) NOT NULL COMMENT '想聽到講座內容有哪些?',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_student) REFERENCES student (id),
   FOREIGN KEY (id_course) REFERENCES course (id),
   FOREIGN KEY (id_status) REFERENCES wcm_status (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- payment   繳款明細資料表
CREATE TABLE IF NOT EXISTS `payment`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_student` INT COMMENT '學員ID',  
   `cash` VARCHAR(100) NOT NULL COMMENT '付款金額',
   `pay_model` VARCHAR(40) NOT NULL COMMENT '付款方式',
   `number` VARCHAR(40) NOT NULL COMMENT '卡號後四碼',
   `person` VARCHAR(40) NOT NULL COMMENT '服務人員',   
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_student) REFERENCES student (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- registration  報名資料表
CREATE TABLE IF NOT EXISTS `registration`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_student` INT COMMENT '學員ID',  
   `id_course` INT COMMENT '課程ID',  
   `id_status` INT COMMENT '狀態ID',  
   `id_payment` INT COMMENT '繳款明細ID',  
   `amount_payable` INT NOT NULL COMMENT '應付金額',
   `amount_paid` VARCHAR(100) NOT NULL COMMENT '已付金額',
   `person` VARCHAR(40) NOT NULL COMMENT '追單人員',
   `memo` VARCHAR(65535) NOT NULL COMMENT '備註',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_student) REFERENCES student (id),
   FOREIGN KEY (id_course) REFERENCES course (id),
   FOREIGN KEY (id_payment) REFERENCES payment (id),
   FOREIGN KEY (id_status) REFERENCES wcm_status (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 課程資料表 - 新增欄位、更改欄位型態(2020/01/11)

ALTER TABLE `course` ADD COLUMN Events VARCHAR(40) COMMENT'場次';
ALTER TABLE `course` ADD COLUMN course_end_at timestamp  null COMMENT '課程結束時間';
ALTER TABLE `course` CHANGE COLUMN course_at course_start_at timestamp  null COMMENT '課程開始時間';

-- 修改狀態資料表名稱(2020/01/11)
ALTER TABLE `wcm_status` RENAME TO `isms_status`;

-- 新增狀態資料(2020/01/11)
INSERT INTO `isms_status` (`name`) VALUES ('銷講報名成功');
INSERT INTO `isms_status` (`name`) VALUES ('我很遺憾');

-- 更改資料型態(2020/01/09)
ALTER TABLE `sales_registration` CHANGE COLUMN course_content course_content VARCHAR(65535) null;


-- 新增講師資料(2020/01/13)
INSERT INTO `teacher` (`name`) VALUES ('Juila');
INSERT INTO `teacher` (`name`) VALUES ('Jack');
INSERT INTO `teacher` (`name`) VALUES ('Mark');

-- 課程資料表 - 新增欄位、更改欄位註解(2020/02/01)
ALTER TABLE `course` ADD COLUMN id_type VARCHAR(40) COMMENT '上一階段ID';
ALTER TABLE `course` ADD COLUMN id_group VARCHAR(40) NULL COMMENT '群組ID';
ALTER TABLE `course` CHANGE COLUMN type type VARCHAR(40) NOT NULL COMMENT '課程類型(1:銷講,2:2階正課,3:3階正課)';
ALTER TABLE `course` ADD COLUMN courseservices VARCHAR(65535) COMMENT'課程服務';

-- 付款資料表 - 新增欄位、更改欄位註解(2020/02/01)
ALTER TABLE `payment` ADD COLUMN type_invoice VARCHAR(20) COMMENT '統一發票(0:捐贈社會福利機構(由無極限國際公司另行辦理),1:二聯式,2:三聯式)';
ALTER TABLE `payment` ADD COLUMN number_taxid VARCHAR(40) NULL COMMENT '統編';
ALTER TABLE `payment` ADD COLUMN companytitle VARCHAR(40) NULL COMMENT '抬頭';
ALTER TABLE `payment` CHANGE COLUMN pay_model pay_model VARCHAR(20) NOT NULL COMMENT '付款方式(0:現金,1:匯款,2:刷卡:輕鬆付,3:刷卡:一次付)';

-- 報名資料表 - 新增欄位(2020/02/01)
ALTER TABLE `registration` ADD COLUMN sign VARCHAR(100) NULL COMMENT '簽名檔案';

-- 余佩珊改資料(2020/02/03)
INSERT INTO `isms_status` (`name`) VALUES ('未到');
INSERT INTO `isms_status` (`name`) VALUES ('報到');
INSERT INTO `isms_status` (`name`) VALUES ('取消');
UPDATE `isms_status` SET `name`='已報名' WHERE `id`=1;

-- 銷售講座報名資料表 - 新增欄位(2020/02/05)
ALTER TABLE `sales_registration` ADD COLUMN submissiondate VARCHAR(150) COMMENT 'Submission Date';
ALTER TABLE `sales_registration` ADD COLUMN datasource VARCHAR(255) NULL COMMENT '表單來源';
ALTER TABLE `sales_registration` ADD COLUMN memo VARCHAR(65535) NULL COMMENT '報名備註';

-- 學生資料表 - 更改email長度(2020/02/05)
ALTER TABLE `student` CHANGE COLUMN email email VARCHAR(150) NOT NULL COMMENT 'email';

-- 銷售講座改是否為空值(2020/02/07)
ALTER TABLE `sales_registration` CHANGE COLUMN pay_model pay_model VARCHAR(20)  NULL COMMENT '付款方式';
ALTER TABLE `sales_registration` CHANGE COLUMN account account VARCHAR(20)  NULL COMMENT '帳號/卡號後四碼';

-- 學生資料表改是否為空值(2020/02/07)
ALTER TABLE `student` CHANGE COLUMN address address VARCHAR(40)  NULL COMMENT '居住地區';

-- 銷售講座報名資料表 - 新增欄位(2020/02/07)
ALTER TABLE `sales_registration` ADD COLUMN events VARCHAR(50) COMMENT '追蹤場次(給我很遺憾用)';


-- 課程資料表 - 新增欄位(2020/02/14)
ALTER TABLE `course` ADD COLUMN host VARCHAR(40) COMMENT '主持開場';
ALTER TABLE `course` ADD COLUMN closeOrder VARCHAR(40) NULL COMMENT '結束收單';
ALTER TABLE `course` ADD COLUMN weather VARCHAR(40) COMMENT '天氣';
ALTER TABLE `course` ADD COLUMN staff VARCHAR(255) NULL COMMENT '工作人員';

-- 使用者資料表 - 新增欄位(2020/02/17)
ALTER TABLE `users` ADD COLUMN account VARCHAR(40) COMMENT '帳號';
ALTER TABLE `users` ADD COLUMN role VARCHAR(40) COMMENT '角色';

-- 刪除使用者資料(2020/02/17)
delete from users;
-- 使用者資料表 - 新增資料(2020/02/17)
INSERT INTO users (`account`,`name`,`role`,`email`,`password`) VALUES ('admin','管理員','admin','admin@gmail.com','$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S');
INSERT INTO users (`account`,`name`,`role`,`email`,`password`) VALUES ('dataanalysis','數據分析人員','dataanalysis','dataanalysis@gmail.com','$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S');
INSERT INTO users (`account`,`name`,`role`,`email`,`password`) VALUES ('marketer','行銷人員','marketer','marketer@gmail.com','$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S');
INSERT INTO users (`account`,`name`,`role`,`email`,`password`) VALUES ('accountant','財會人員','accountant','accountant@gmail.com','$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S');
INSERT INTO users (`account`,`name`,`role`,`email`,`password`) VALUES ('staff','現場人員','staff','staff@gmail.com','$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S');
INSERT INTO users (`account`,`name`,`role`,`email`,`password`) VALUES ('teacher','講師','teacher','teacher@gmail.com','$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S');

-- 講師           -> teacher
-- 現場人員       -> staff
-- 財會人員       -> accountant
-- 行銷人員       -> marketer
-- 數據分析人員   -> dataanalysis
-- 管理員         -> admin

-- 更改學員資料欄位 (2020/02/18)
ALTER TABLE `student` CHANGE COLUMN profession profession VARCHAR(30) null COMMENT '職業';
ALTER TABLE `student` CHANGE COLUMN email email VARCHAR(20) null COMMENT 'email';


-- 增加學員資料欄位 - 判斷是否為黑名單(2020/02/22)
ALTER TABLE `student` ADD COLUMN check_blacklist int NOT NULL DEFAULT '0' COMMENT '判斷是否為黑名單(1:是,0:否)';

-- blacklist  黑名單資料表(2020/02/22)
CREATE TABLE IF NOT EXISTS `blacklist`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_student` INT COMMENT '學員ID',  
   `reason` VARCHAR(255)  NULL COMMENT '原因',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_student) REFERENCES student (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- student_group  細分組資料表(2020/02/22)
CREATE TABLE IF NOT EXISTS `student_group`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_student` INT COMMENT '學員ID',  
   `id_group` VARCHAR(150)  NULL COMMENT '分組ID',
   `name` VARCHAR(150)  NULL COMMENT '細分組名稱',
   `condition` VARCHAR(200)  NULL COMMENT '條件',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_student) REFERENCES student (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- rule  規則資料表(2020/02/22)
CREATE TABLE IF NOT EXISTS `rule`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `type` VARCHAR(50)  NULL COMMENT '類型(0:黑名單,1:細分組)',
   `name` VARCHAR(200)  NULL COMMENT '規則名稱',
   `regulation` VARCHAR(200)  NULL COMMENT '規則',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- message  推播資料表(2020/02/22)
CREATE TABLE IF NOT EXISTS `message`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_student_group` VARCHAR(100) COMMENT '細分組ID',  
   `type` VARCHAR(50)  NULL COMMENT '類型(0:簡訊,1:email,2:全部)',
   `title` VARCHAR(255)  NULL COMMENT '標題',
   `content` VARCHAR(65535)  NULL COMMENT '內容',
   `send_at` timestamp  null default  CURRENT_TIMESTAMP	 COMMENT '發送時間',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 規則資料表 - 新增欄位(2020/03/01)
ALTER TABLE `rule` ADD COLUMN rule_value VARCHAR(40) NULL COMMENT '規則Value';
ALTER TABLE `rule` ADD COLUMN rule_status VARCHAR(40) NULL COMMENT '狀態(0:關閉,1:啟動)';

-- 規則資料表 - 新增資料(2020/03/01)
INSERT INTO rule (`type`,`name`,`regulation`,`rule_value`,`rule_status`)  VALUES ('0','單一課程累積_未到幾次','0','0','1');
INSERT INTO rule (`type`,`name`,`regulation`,`rule_value`,`rule_status`)  VALUES ('0','單一課程累積_取消幾次','0','1','1');
INSERT INTO rule (`type`,`name`,`regulation`,`rule_value`,`rule_status`)  VALUES ('0','單一課程累積_未到+取消幾次','0','2','1');
INSERT INTO rule (`type`,`name`,`regulation`,`rule_value`,`rule_status`)  VALUES ('0','單一課程累積_出席幾次但未留單','0','3','1');
INSERT INTO rule (`type`,`name`,`regulation`,`rule_value`,`rule_status`)  VALUES ('0','所有課程累積_未到幾次','0','4','1');
INSERT INTO rule (`type`,`name`,`regulation`,`rule_value`,`rule_status`)  VALUES ('0','所有課程累積_取消幾次','0','5','1');
INSERT INTO rule (`type`,`name`,`regulation`,`rule_value`,`rule_status`)  VALUES ('0','所有課程累積_未到+取消幾次','0','6','1');



-- 大改版(2020/03/04)--------------------------------------------------

-- 修改student欄位大小 - email 
ALTER TABLE student CHANGE COLUMN email email VARCHAR(150) null COMMENT 'email';

-- events_course  課程場次資料表
CREATE TABLE IF NOT EXISTS `events_course`(
   `id` INT  AUTO_INCREMENT COMMENT 'ID',
   `id_course` INT COMMENT '課程ID',  
   `name` VARCHAR(40)  NULL COMMENT '場次',
   `location` VARCHAR(255)  NULL COMMENT '地址',
   `money` VARCHAR(150)  NULL COMMENT '現場完款',
   `money_fivedays` VARCHAR(150)  NULL COMMENT '五日內完款',
   `money_installment` VARCHAR(150)  NULL COMMENT '分期付款',
   `memo` VARCHAR(65535)  NULL COMMENT '備註',
   `host` VARCHAR(100)  NULL COMMENT '主持開場',
   `closeorder` VARCHAR(40)  NULL COMMENT '結束收單',
   `weather` VARCHAR(40)  NULL COMMENT '天氣',
   `staff` VARCHAR(255)  NULL COMMENT '工作人員',
   `id_group` VARCHAR(40)  NULL COMMENT '群組ID',
   `course_start_at` timestamp  NULL COMMENT '課程開始時間',
   `course_end_at` timestamp  NULL COMMENT '課程結束時間',
   `created_at` timestamp not NULL default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not NULL default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_course) REFERENCES course (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 刪除課程資料表欄位
ALTER TABLE `course` DROP COLUMN `location`;
ALTER TABLE `course` DROP COLUMN `course_start_at`;
ALTER TABLE `course` DROP COLUMN `memo`;
ALTER TABLE `course` DROP COLUMN `Events`;
ALTER TABLE `course` DROP COLUMN `course_end_at`; 
ALTER TABLE `course` DROP COLUMN `id_group`;
ALTER TABLE `course` DROP COLUMN `host`;
ALTER TABLE `course` DROP COLUMN `closeOrder`;
ALTER TABLE `course` DROP COLUMN `weather`;
ALTER TABLE `course` DROP COLUMN `staff`;


-- 增加課程資料表欄位 - 金額
-- ALTER TABLE `course` ADD COLUMN id_events INT NOT NULL COMMENT '場次ID',
-- ADD FOREIGN KEY (id_events) REFERENCES events_course(id);
ALTER TABLE `course` ADD COLUMN money VARCHAR(100) NULL COMMENT '課程金額';

-- 增加銷講資料表欄位 - 場次ID
ALTER TABLE `sales_registration` ADD COLUMN id_events INT NOT NULL COMMENT '場次ID',
ADD FOREIGN KEY (id_events) REFERENCES events_course(id);

-- 增加正課資料表欄位 - 場次ID
ALTER TABLE `registration` ADD COLUMN id_events INT NOT NULL COMMENT '場次ID',
ADD FOREIGN KEY (id_events) REFERENCES events_course(id);
ALTER TABLE `registration` ADD COLUMN status_payment VARCHAR(100) NULL COMMENT '付款狀態';


-- 增加狀態資料表 - 類型、更新資料
ALTER TABLE `isms_status` ADD COLUMN type VARCHAR(50) NULL COMMENT '類型(0:銷講、正課,1:追單,2:付款狀態,4:活動狀態)';
UPDATE `isms_status` SET type = '0' WHERE id = '1' or id = '2' or id = '3' or id = '4' or id = '5';

-- 刪掉資料表
DROP TABLE `member` ;
DROP TABLE `role` ;
DROP TABLE `menu` ;


-- mark  標記資料表
CREATE TABLE IF NOT EXISTS `mark`(
   `id` INT  AUTO_INCREMENT COMMENT 'ID',
   `id_student` INT COMMENT '學員ID', 
   `name_mark` VARCHAR(40)  NULL COMMENT '標記名稱',
   `name_course` VARCHAR(150)  NULL COMMENT '課程名稱',
   `created_at` timestamp not NULL default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not NULL default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_student) REFERENCES student (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- debt  追單資料表
CREATE TABLE IF NOT EXISTS `debt`(
   `id` INT  AUTO_INCREMENT COMMENT 'ID',
   `id_student` INT COMMENT '學員ID', 
   `id_status` INT COMMENT '最新狀態ID',  
   `name_course` VARCHAR(150)  NULL COMMENT '追單課程',
   `status_payment` VARCHAR(200)  NULL COMMENT '付款狀態/日期',
   `contact` VARCHAR(150)  NULL COMMENT '聯絡內容',
   `person` VARCHAR(150)  NULL COMMENT '追單人員',
   `remind_at` timestamp  NULL COMMENT '提醒',
   `created_at` timestamp not NULL default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not NULL default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_student) REFERENCES student (id),
   FOREIGN KEY (id_status) REFERENCES isms_status (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 增加正課資料表欄位 - 追單ID
-- ALTER TABLE `registration` ADD COLUMN id_debt INT NOT NULL COMMENT '追單ID',
-- ADD FOREIGN KEY (id_debt) REFERENCES debt(id);

-- 刪除正課資料表欄位
ALTER TABLE `registration` DROP COLUMN `person`;


-- refund   退費資料表
CREATE TABLE IF NOT EXISTS `refund`(
   `id` INT  AUTO_INCREMENT COMMENT 'ID',
   `id_registration` INT COMMENT '正課報名ID', 
   `id_student` INT COMMENT '學員ID', 
   `submissiondate` timestamp  NULL COMMENT 'SubmissionDate',
   `refund_date` timestamp  NULL COMMENT '申請退費日期',
   `name_student` VARCHAR(100)  NULL COMMENT '姓名',
   `phone` VARCHAR(100)  NULL COMMENT '連絡電話',
   `email` VARCHAR(100)  NULL COMMENT 'email',
   `name_course` VARCHAR(150)  NULL COMMENT '申請退款課程',
   `refund_reason` VARCHAR(65535)  NULL COMMENT '退費原因',
   `pay_model` VARCHAR(50)  NULL COMMENT '當時付款方式',
   `account` VARCHAR(30)  NULL COMMENT '帳號/卡號後五碼',
   `created_at` timestamp not NULL default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not NULL default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` ),
   FOREIGN KEY (id_student) REFERENCES student (id),
   FOREIGN KEY (id_registration) REFERENCES registration (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 新增狀態資料
INSERT INTO isms_status (`name`,`type`)  VALUES ('留單','2');
INSERT INTO isms_status (`name`,`type`)  VALUES ('完款','2');
INSERT INTO isms_status (`name`,`type`)  VALUES ('付訂','2');
INSERT INTO isms_status (`name`,`type`)  VALUES ('退費','2');
INSERT INTO isms_status (`name`,`type`)  VALUES ('付訂','1');
INSERT INTO isms_status (`name`,`type`)  VALUES ('完款','1');
INSERT INTO isms_status (`name`,`type`)  VALUES ('待追','1');
INSERT INTO isms_status (`name`,`type`)  VALUES ('退款中','1');
INSERT INTO isms_status (`name`,`type`)  VALUES ('退款完成','1');
INSERT INTO isms_status (`name`,`type`)  VALUES ('無意願','1');
INSERT INTO isms_status (`name`,`type`)  VALUES ('推薦其他講師','1');


-- 增加追單資料表欄位 - 正課報名ID
ALTER TABLE `debt` ADD COLUMN id_registration INT NOT NULL COMMENT '正課報名ID',
ADD FOREIGN KEY (id_registration) REFERENCES registration(id);


-- 刪除正課資料表欄位
-- ALTER TABLE registration DROP FOREIGN KEY `registration_ibfk_6`;
-- ALTER TABLE `registration` DROP COLUMN `id_debt`;

-- 新增正課表單資料欄位 - 我想參加課程
ALTER TABLE `registration` ADD COLUMN registration_join VARCHAR(20) NULL COMMENT '我想參加課程(0:現場最優惠價格,1:五日內優惠價格)';

-- 修改課程資料表外部鍵
ALTER TABLE course DROP FOREIGN KEY `course_ibfk_1`;


-- 新增正課表單資料欄位 (2020/03/13)
ALTER TABLE `registration` ADD COLUMN id_group INT NULL COMMENT '群組ID';
ALTER TABLE `registration` ADD COLUMN source_events INT NULL COMMENT '來源場次ID';
ALTER TABLE `registration` ADD COLUMN pay_date timestamp NULL COMMENT '付款日期';
ALTER TABLE `registration` ADD COLUMN pay_memo VARCHAR(40) NULL COMMENT '付款備註';
ALTER TABLE `registration` ADD COLUMN person VARCHAR(40) NULL COMMENT '服務人員';
ALTER TABLE `registration` ADD COLUMN type_invoice VARCHAR(20) NULL COMMENT '統一發票';
ALTER TABLE `registration` ADD COLUMN number_taxid VARCHAR(40) NULL COMMENT '統編';
ALTER TABLE `registration` ADD COLUMN companytitle VARCHAR(40) NULL COMMENT '抬頭';

-- 刪除付款資料表欄位 (2020/03/13)
ALTER TABLE `payment` DROP COLUMN `person`;
ALTER TABLE `payment` DROP COLUMN `type_invoice`;
ALTER TABLE `payment` DROP COLUMN `number_taxid`;
ALTER TABLE `payment` DROP COLUMN `companytitle`;


-- register   報到資料表 Rocky(2020/03/14)
CREATE TABLE IF NOT EXISTS `register`(
   `id` INT  AUTO_INCREMENT COMMENT 'ID',
   `id_registration` VARCHAR(50) COMMENT '正課報名ID', 
   `id_student` VARCHAR(50) COMMENT '學員ID', 
   `id_status` VARCHAR(50) COMMENT '狀態ID', 
   `id_events` VARCHAR(50) COMMENT '場次ID',    
   `created_at` timestamp not NULL default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not NULL default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 增加付款資料表欄位 - 正課報名ID
ALTER TABLE `payment` ADD COLUMN id_registration INT  NULL COMMENT '正課報名ID';

-- 刪掉正課資料表欄位
ALTER TABLE registration DROP FOREIGN KEY `registration_ibfk_3`;
ALTER TABLE registration DROP FOREIGN KEY `registration_ibfk_4`;

ALTER TABLE `registration` DROP COLUMN `id_status`;
ALTER TABLE `registration` DROP COLUMN `id_payment`;


-- 增加報到資料表欄位 - 備註
ALTER TABLE `register` ADD COLUMN memo VARCHAR(65535) NULL COMMENT '備註';

-- 刪掉正課資料表欄位 - 備註
ALTER TABLE `registration` DROP COLUMN `memo`;

-- 刪掉細分組資料表 - 學員ID Rocky (2020/03/16)
ALTER TABLE student_group DROP FOREIGN KEY `student_group_ibfk_1`;
ALTER TABLE `student_group` DROP COLUMN `id_student`;

-- student_group  細分組詳細資料資料表 Rocky (2020/03/16)
CREATE TABLE IF NOT EXISTS `student_groupdetail`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_student`  VARCHAR(150) COMMENT '學員ID',  
   `id_group` VARCHAR(150)  NULL COMMENT '分組ID',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 修改標記資料表欄位 Rocky (2020/03/17)
ALTER TABLE `mark` CHANGE COLUMN name_course course_id VARCHAR(50) null COMMENT '課程ID';

-- 增加場次資料表欄位 - 不公開(針對正課)
ALTER TABLE `events_course` ADD COLUMN unpublish INT NULL COMMENT '不公開(0:否,1:是)';


-- 追單資料表 - 刪掉正課報名表外部鍵連接 Rocky(2020/03/31)
ALTER TABLE debt DROP FOREIGN KEY `debt_ibfk_3`;

-- 追單資料表 - 增加場次ID Rocky(2020/03/31)
ALTER TABLE `debt` ADD COLUMN id_events VARCHAR(150) NULL COMMENT '場次ID';

-- 正課資料表 - 刪掉外部鍵連接 Rocky(2020/03/31)
ALTER TABLE registration DROP FOREIGN KEY `registration_ibfk_2`;
ALTER TABLE registration DROP FOREIGN KEY `registration_ibfk_5`;

-- 銷講資料表 -刪掉外部鍵 Rocky(2020/03/31)
ALTER TABLE sales_registration DROP FOREIGN KEY `sales_registration_ibfk_2`;
ALTER TABLE sales_registration DROP FOREIGN KEY `sales_registration_ibfk_4`;

-- 追單資料表 - 報名日期 Sandy(2020/04/01)
ALTER TABLE `registration` ADD COLUMN submissiondate VARCHAR(150) NULL COMMENT 'Submission Date';

-- 退費資料表 - 增加退費審核 Sandy(2020/04/02)
ALTER TABLE `refund` ADD COLUMN review INT NULL COMMENT '審核(0:審核中,1:通過,2:未通過)' DEFAULT 0;




-- m_database  備份資料表 Rocky (2020/04/10)
CREATE TABLE IF NOT EXISTS `m_database`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `filename`  VARCHAR(150) COMMENT '檔名',  
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `m_database` (`filename`,`created_at`) VALUES ('0410.sql','	2020-04-10 23:00:37');



-- 新增狀態資料 Sandy(2020/04/12)
ALTER TABLE `isms_status` modify COLUMN type VARCHAR(50) NULL COMMENT '類型(0:銷講、正課,1:追單,2:付款狀態,4:活動狀態,5:訊息狀態)';
INSERT INTO isms_status (`name`,`type`)  VALUES ('已建立','5');
INSERT INTO isms_status (`name`,`type`)  VALUES ('草稿','5');
INSERT INTO isms_status (`name`,`type`)  VALUES ('已傳送','5');
INSERT INTO isms_status (`name`,`type`)  VALUES ('無法傳送','5');
INSERT INTO isms_status (`name`,`type`)  VALUES ('已預約','5');

-- 訊息資料表 - 狀態ID Sandy(2020/04/12)
ALTER TABLE `message` ADD COLUMN name VARCHAR(65535) NULL COMMENT '訊息名稱';
ALTER TABLE `message` ADD COLUMN id_status INT NULL COMMENT '狀態ID';
ALTER TABLE `message` ADD COLUMN id_teacher INT NULL COMMENT '講師ID';
ALTER TABLE `message` ADD COLUMN id_course INT NULL COMMENT '課程ID';
ALTER TABLE `message` ADD COLUMN memo INT NULL COMMENT '狀態備註(傳送失敗用)';

-- sender 寄件資料表 Sandy (2020/04/12)
CREATE TABLE IF NOT EXISTS `sender`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_message`  INT COMMENT '訊息ID',  
   `id_student` INT NULL COMMENT '學員ID',
   `phone` VARCHAR(100) NULL COMMENT '發送號碼',
   `email` VARCHAR(100) NULL COMMENT '發送信箱',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 標記資料表 - 課程ID Sandy(2020/04/12)
ALTER TABLE `mark` ADD COLUMN id_course VARCHAR(150) NULL COMMENT '課程ID';

-- 寄件資料表 更新學員ID欄位 Sandy(2020/04/15)
ALTER TABLE `sender` modify COLUMN id_student VARCHAR(10) NULL COMMENT '學員ID';

-- 寄件資料表 - 新增狀態ID、備註、簡訊序號 Sandy(2020/04/15)
ALTER TABLE `sender` ADD COLUMN id_status INT NULL COMMENT '狀態ID';
ALTER TABLE `sender` ADD COLUMN memo VARCHAR(150) NULL COMMENT '狀態備註(傳送失敗用)';
ALTER TABLE `sender` ADD COLUMN msgid VARCHAR(50) NULL COMMENT '簡訊序號';

-- user資料表 - 刪掉資料 Rocky(2020/04/16)
DELETE FROM users WHERE email = 'dataanalysis@gmail.com';

-- user資料表 - 更新資料 Rocky(2020/04/16)
UPDATE users set name = '臨時人員' WHERE email = 'staff@gmail.com';
UPDATE users set name = '財務人員' WHERE email = 'accountant@gmail.com';

-- user資料表 - 新增資料 Rocky(2020/04/16)
INSERT INTO users (`account`,`name`,`role`,`email`,`password`) VALUES ('saleser','業務人員','saleser','saleser@gmail.com','$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S');
INSERT INTO users (`account`,`name`,`role`,`email`,`password`) VALUES ('msaleser','業務主管','msaleser','msaleser@gmail.com','$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S');
INSERT INTO users (`account`,`name`,`role`,`email`,`password`) VALUES ('officestaff','行政人員','officestaff','officestaff@gmail.com','$2y$10$NEehULmc8BofwNXy0a/Lve99pvz41NA7iE2.Sm0OfRoMk3X5FRi9S');


-- 標記資料表 - 課程ID Sandy(2020/04/17)
ALTER TABLE `mark` ADD COLUMN id_events VARCHAR(50) NULL COMMENT '場次ID';


-- 修改細分組資料表 - 條件欄位長度大小 Rocky (2020/04/18)
ALTER TABLE `student_group` CHANGE COLUMN `condition` `condition` VARCHAR(65535) null COMMENT '條件';


-- 場次資料表 - 各項成本欄位 Rocky(2020/04/25)
ALTER TABLE `events_course` ADD COLUMN cost_ad VARCHAR(200) NULL COMMENT '廣告成本';
ALTER TABLE `events_course` ADD COLUMN cost_message VARCHAR(200) NULL COMMENT '訊息成本';
ALTER TABLE `events_course` ADD COLUMN cost_events VARCHAR(200) NULL COMMENT '場地成本';

-- 正課資料表 - 發票欄位 Rocky(2020/04/25)
ALTER TABLE `registration` ADD COLUMN invoice VARCHAR(150) NULL COMMENT '發票號碼';
ALTER TABLE `registration` ADD COLUMN invoice_created_at timestamp NULL COMMENT '開立日期';


-- bonus  獎金資料表 Rocky(2020/04/26)
CREATE TABLE IF NOT EXISTS `bonus`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_events` VARCHAR(100)  NULL COMMENT '場次ID',
   `id_course` VARCHAR(100)  NULL COMMENT '課程ID',
   `id_group` VARCHAR(100)  NULL COMMENT '群組ID',
   `name` VARCHAR(70)  NULL COMMENT '姓名',
   `status` VARCHAR(10)  NULL COMMENT '狀態(0:不啟用,1:啟用)',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- bonus_rule  獎金規則資料表 Rocky(2020/04/26)
CREATE TABLE IF NOT EXISTS `bonus_rule`(
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `id_bonus` VARCHAR(100)  NULL COMMENT '獎金ID',
   `name` VARCHAR(200)  NULL COMMENT '規則名稱',
   `name_id` VARCHAR(50)  NULL COMMENT '規則ID',
   `value` VARCHAR(200)  NULL COMMENT '規則',
   `status` VARCHAR(10)  NULL COMMENT '狀態(0:不啟用,1:啟用)',
   `created_at` timestamp not null default  CURRENT_TIMESTAMP	 COMMENT '創建日期',
   `updated_at` timestamp not null default  CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 	 COMMENT '更新日期',
   PRIMARY KEY ( `id` )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- sender資料表重新命名為receiver   Sandy (2020/04/27)
ALTER TABLE sender RENAME TO receiver;

-- 獎金資料表 - 刪除欄位 Rocky(2020/04/27)
ALTER TABLE `bonus` DROP COLUMN `id_events`;
ALTER TABLE `bonus` DROP COLUMN `id_course`;
ALTER TABLE `bonus` DROP COLUMN `id_group`;

-- 正課資料表 - 備註欄位 Rocky(2020/04/28)
ALTER TABLE `registration` ADD COLUMN memo VARCHAR(250) NULL COMMENT '備註';


-- 訊息資料表 - 簡訊封數欄位 Sandy(2020/04/28)
ALTER TABLE `message` ADD COLUMN sms_num int NULL COMMENT '簡訊封數';


-- User資料表 - 講師ID欄位 Rocky(2020/05/01)
ALTER TABLE `users` ADD COLUMN id_teacher VARCHAR(90) NULL COMMENT '講師ID';


-- 修改標記資料表欄位 Sandy (2020/05/04)
ALTER TABLE `registration` CHANGE COLUMN `amount_payable` `amount_payable` INT null COMMENT '應付金額';

-- User資料表 - 狀態欄位 Rocky(2020/05/07)
ALTER TABLE `users` ADD COLUMN status VARCHAR(10) NULL COMMENT '狀態(0:暫停,1:啟用)';

-- User資料表 - 更新狀態欄位 Rocky(2020/05/07)
UPDATE users SET status = '1';

-- 正課資料表 - 來源欄位 Sandy(2020/05/13)
ALTER TABLE `registration` ADD COLUMN datasource VARCHAR(20) NULL COMMENT '表單來源';

-- 修改場次資料表 訊息成本欄位 Sandy (2020/05/13)
ALTER TABLE `events_course` modify COLUMN cost_message INT NOT NULL DEFAULT 0 COMMENT '訊息成本';


-- 正課資料表 - 新增原始付款狀態欄位 Rocky(2020/05/18)
ALTER TABLE `registration` ADD COLUMN status_payment_original VARCHAR(30) NULL COMMENT '原始付款狀態';

-- 追單資料表 - 新增付款狀態欄位 Rocky(2020/05/18)
ALTER TABLE `debt` ADD COLUMN status_payment_name VARCHAR(30) NULL COMMENT '付款狀態名稱';


-- 正課資料表 - 刪除欄位 Sandy (2020/05/31)
ALTER TABLE `registration` DROP COLUMN `datasource`;

-- 修改正課表單資料欄位 - 我想參加課程 Sandy (2020/05/31)
ALTER TABLE `registration` modify COLUMN registration_join VARCHAR(20) NULL COMMENT '我想參加課程(0:現場最優惠價格,1:五日內優惠價格,2:分期優惠價格)';

-- 追單資料表 - 刪掉外部鍵 Rocky (2020/06/19)
ALTER TABLE debt DROP FOREIGN KEY `debt_ibfk_1`;
ALTER TABLE debt DROP FOREIGN KEY `debt_ibfk_2`;

-- 修改正課表單資料欄位 - 統一發票 Sandy (2020/06/27)
ALTER TABLE `registration` modify COLUMN type_invoice VARCHAR(20) NULL COMMENT '統一發票(0:捐贈社會福利機構（由無極限國際公司另行辦理）,1:二聯式,2:三聯式)';

-- 銷講資料表 - 增加備註欄位 Rocky(2020/07/02)
ALTER TABLE `sales_registration` ADD COLUMN memo2 VARCHAR(100)  NULL  COMMENT '備註(填是否付費)';

-- 新增資料 - 狀態資料表 Rocky(2020/07/02)
INSERT INTO isms_status (`name`,`type`)  VALUES ('通知下一梯次課程時間','1');

-- 課程資料表 - 新增刷卡連結欄位 Sandy(2020/07/06)
ALTER TABLE `course` ADD COLUMN pay_url INT NULL COMMENT '刷卡連結';

-- 付款資料表 - 更改欄位註解(2020/07/09)
ALTER TABLE `payment` CHANGE COLUMN pay_model pay_model VARCHAR(20) NOT NULL COMMENT '付款方式(0:現金,1:匯款,2:刷卡:輕鬆付,3:刷卡:一次付,4:現金分期)';


-- 新增活動資料表 Rocky(2020/08/04)
CREATE TABLE `activity` (
   `id` INT  AUTO_INCREMENT COMMENT 'id',
   `submissiondate` varchar(150) DEFAULT NULL COMMENT 'Submission Date',
  `id_student` int(11) DEFAULT NULL COMMENT '學員ID',
  `id_course` int(11) DEFAULT NULL COMMENT '課程ID',
   `id_events` int(11) NOT NULL COMMENT '場次ID',
  `id_status` int(11) DEFAULT NULL COMMENT '報名狀態ID',
  `course_content` mediumtext,
  `memo` mediumtext COMMENT '備註',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建日期',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日期',
  PRIMARY KEY ( `id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 課程資料表 - 修改刷卡連結欄位 Sandy(2020/08/11)
ALTER TABLE `course` modify COLUMN pay_url VARCHAR(255) NULL COMMENT '刷卡連結';


-- 新增資料 - 狀態資料表 Rocky(2020/08/13)
INSERT INTO isms_status (`name`,`type`)  VALUES ('參與','4');


-- 課程資料表 - 修改不公開欄位說明 Sandy(2020/09/09)
ALTER TABLE `events_course` modify COLUMN unpublish INT NULL COMMENT '不公開(0:上架,1:取消,2:下架)';