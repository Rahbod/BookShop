/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : book

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-09-29 13:57:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_admins
-- ----------------------------
DROP TABLE IF EXISTS `ym_admins`;
CREATE TABLE `ym_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(11) unsigned NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `ym_admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admins
-- ----------------------------
INSERT INTO `ym_admins` VALUES ('24', 'admin', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'admin@gmial.com', '1');
INSERT INTO `ym_admins` VALUES ('27', 'ad', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'sa@sda.sad', '3');

-- ----------------------------
-- Table structure for ym_admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_admin_roles`;
CREATE TABLE `ym_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'عنوان نقش',
  `role` varchar(255) NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admin_roles
-- ----------------------------
INSERT INTO `ym_admin_roles` VALUES ('1', 'مدیر', 'admin');
INSERT INTO `ym_admin_roles` VALUES ('2', 'ناظر', 'validator');
INSERT INTO `ym_admin_roles` VALUES ('3', 'پشتیبان', 'supporter');

-- ----------------------------
-- Table structure for ym_books
-- ----------------------------
DROP TABLE IF EXISTS `ym_books`;
CREATE TABLE `ym_books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `publisher_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `status` enum('disable','enable') CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT 'enable',
  `price` double DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `description` longtext,
  `change_log` longtext,
  `permissions` longtext,
  `size` float DEFAULT NULL,
  `confirm` enum('pending','refused','accepted','change_required') DEFAULT 'pending',
  `publisher_name` varchar(50) DEFAULT NULL,
  `seen` tinyint(1) unsigned DEFAULT '0' COMMENT 'دیده شده',
  `download` int(12) unsigned DEFAULT '0' COMMENT 'تعداد دریافت',
  `deleted` tinyint(1) unsigned DEFAULT '0' COMMENT 'حذف شده',
  PRIMARY KEY (`id`),
  KEY `developer_id` (`publisher_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `ym_books_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `ym_book_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_books
-- ----------------------------
INSERT INTO `ym_books` VALUES ('25', 'موبوگرام', '45', '5', 'enable', '10000', null, '<p>sadf</p>\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', '<p>asdfsadf</p>\r\n', '[\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a Wi-Fi\"]', null, 'accepted', null, '122', '0', '0');
INSERT INTO `ym_books` VALUES ('35', 'برنامه آزمایشیasd', null, '5', 'enable', '250000', null, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 'sdf', '[\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a Wi-Fi\"]', null, 'accepted', 'masoud', '146', '0', '0');
INSERT INTO `ym_books` VALUES ('36', 'تلگرام', '45', '11', 'enable', '50000', 's8kEb1464260978.png', '<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد. لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>\r\n', '<p>sdf</p>\r\n', '[\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a Wi-Fi\"]', null, 'accepted', null, '176', '0', '0');
INSERT INTO `ym_books` VALUES ('37', 'فیسبوک', '43', '2', 'enable', '0', null, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 'd', '[\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a Wi-Fi\"]', null, 'pending', null, '0', '0', '0');
INSERT INTO `ym_books` VALUES ('38', 'شطرنج', '43', '2', 'enable', '0', null, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 's', '[\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a Wi-Fi\"]', null, 'pending', null, '1', '0', '0');
INSERT INTO `ym_books` VALUES ('39', 'آسفالت', '43', '2', 'enable', '0', null, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 'f', '[\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a Wi-Fi\"]', null, 'accepted', null, '6', '0', '0');
INSERT INTO `ym_books` VALUES ('44', null, '43', null, 'enable', null, null, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', '', null, null, 'pending', null, '0', '0', '0');
INSERT INTO `ym_books` VALUES ('45', null, '43', null, 'enable', null, null, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', '', null, null, 'pending', null, '0', '0', '0');
INSERT INTO `ym_books` VALUES ('46', 'برنامه آزمایشی', null, '5', 'enable', '0', null, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', '<p>asdfsadfasf</p>\r\n', '[\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a Wi-Fi\"]', null, 'accepted', 'masoud', '0', '0', '0');
INSERT INTO `ym_books` VALUES ('47', 'برنامه جدید', null, '5', 'enable', '0', null, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', '<p>asfsfsf</p>\r\n', '[\"\\u0645\\u0634\\u0627\\u0647\\u062f\\u0647\\u0654 \\u0627\\u062a\\u0635\\u0627\\u0644\\u0627\\u062a Wi-Fi\"]', null, 'accepted', 'masoud', '1', '0', '0');
INSERT INTO `ym_books` VALUES ('48', null, null, null, 'enable', null, null, 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', null, null, null, 'pending', null, '0', '0', '0');
INSERT INTO `ym_books` VALUES ('49', null, '45', null, 'enable', null, null, '', '', null, null, 'pending', null, '0', '0', '0');
INSERT INTO `ym_books` VALUES ('50', null, '45', null, 'enable', null, null, '', '', '[\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0648\\u0636\\u0639\\u06cc\\u062a \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0634\\u0628\\u06a9\\u0647 Wi-Fi\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u0637\\u0644\\u0627\\u0639\\u0627\\u062a \\u0634\\u0628\\u06a9\\u0647\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0627\\u06cc\\u0646\\u062a\\u0631\\u0646\\u062a\",\"\\u0645\\u062f\\u06cc\\u0631\\u06cc\\u062a \\u062d\\u0627\\u0641\\u0638\\u0647 \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062d\\u0627\\u0641\\u0638\\u0647 \\u0647\\u0627\\u06cc \\u062e\\u0627\\u0631\\u062c\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u062a\\u0645\\u0627\\u0633 \\u062a\\u0644\\u0641\\u0646\\u06cc\",\"RECEIVE_BOOT_COMPLETED\",\"\\u0645\\u0645\\u0627\\u0646\\u0639\\u062a \\u0627\\u0632 \\u0628\\u0647 \\u062e\\u0648\\u0627\\u0628 \\u0631\\u0641\\u062a\\u0646 \\u062f\\u0633\\u062a\\u06af\\u0627\\u0647\",\"\\u0627\\u0631\\u0633\\u0627\\u0644 \\u067e\\u06cc\\u0627\\u0645\\u06a9\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 NFC\",\"ACCESS_SUPERUSER\",\"\\u062f\\u0631\\u06cc\\u0627\\u0641\\u062a \\u0644\\u06cc\\u0633\\u062a \\u062d\\u0633\\u0627\\u0628 \\u0647\\u0627\\u06cc \\u06a9\\u0627\\u0631\\u0628\\u0631\\u06cc\",\"\\u062f\\u0633\\u062a\\u0631\\u0633\\u06cc \\u0628\\u0647 \\u0645\\u062e\\u0627\\u0637\\u0628\\u06cc\\u0646\"]', null, 'pending', null, '0', '0', '0');

-- ----------------------------
-- Table structure for ym_book_advertises
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_advertises`;
CREATE TABLE `ym_book_advertises` (
  `app_id` int(10) unsigned NOT NULL COMMENT 'برنامه',
  `cover` varchar(200) COLLATE utf8_persian_ci NOT NULL COMMENT 'تصویر کاور',
  `fade_color` varchar(6) COLLATE utf8_persian_ci DEFAULT '000' COMMENT 'رنگ زمینه',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT 'وضعیت',
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`app_id`),
  CONSTRAINT `ym_book_advertises_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_advertises
-- ----------------------------
INSERT INTO `ym_book_advertises` VALUES ('36', 'Kt6pU1472554557.png', 'fff', '1', '1472554562');

-- ----------------------------
-- Table structure for ym_book_buys
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_buys`;
CREATE TABLE `ym_book_buys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_book_buys_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_buys_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_book_buys
-- ----------------------------
INSERT INTO `ym_book_buys` VALUES ('1', '25', '43', '1366491579');
INSERT INTO `ym_book_buys` VALUES ('4', '25', '45', '1470731854');
INSERT INTO `ym_book_buys` VALUES ('5', '35', '45', '1470735262');

-- ----------------------------
-- Table structure for ym_book_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_categories`;
CREATE TABLE `ym_book_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `path` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`) USING BTREE,
  CONSTRAINT `ym_book_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `ym_book_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_book_categories
-- ----------------------------
INSERT INTO `ym_book_categories` VALUES ('1', 'برنامه ها', null, null);
INSERT INTO `ym_book_categories` VALUES ('2', 'بازی ها', null, null);
INSERT INTO `ym_book_categories` VALUES ('3', 'آموزش ها', null, null);
INSERT INTO `ym_book_categories` VALUES ('4', 'آب و هوا', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('5', 'ماجراجویی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('6', 'اخبار و مجلات', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('7', 'ارتباطات', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('8', 'پزشکی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('9', 'استراتژی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('10', 'خانوادگی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('11', 'تفننی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('12', 'مذهبی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('13', 'آموزش', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('14', 'ابزار‌ها', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('15', 'اجتماعی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('16', 'اخبار و مجلات', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('17', 'پزشکی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('18', 'پس‌زمینهٔ زنده', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('19', 'حمل و نقل', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('20', 'خرید', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('21', 'سبک زندگی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('22', 'سرگرمی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('23', 'سلامت و تناسب اندام', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('24', 'سیر و سفر', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('25', 'شخصی‌سازی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('26', 'صوت و موسیقی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('27', 'عکاسی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('28', 'کاربردی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('29', 'کتابخانه و دمو', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('30', 'کتاب‌ها و مراجع', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('31', 'کسب و کار', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('32', 'کمیک', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('33', 'مالی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('34', 'ورزشی', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('35', 'ویجت‌ها', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('36', 'ویدیو و رسانه', '1', '1-');
INSERT INTO `ym_book_categories` VALUES ('37', 'آموزشی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('38', 'استراتژی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('39', 'تخته‌ای', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('40', 'خانوادگی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('41', 'دانستنی‌ها', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('42', 'رقابتی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('43', 'شبیه‌سازی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('44', 'کلمات', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('45', 'ماجراجویی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('46', 'مسابقه و سرعت', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('47', 'معمایی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('48', 'موسیقایی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('49', 'نقش‌آفرینی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('50', 'ورزشی', '2', '2-');
INSERT INTO `ym_book_categories` VALUES ('51', 'هیجان‌‌انگیز', '2', '2-');

-- ----------------------------
-- Table structure for ym_book_discounts
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_discounts`;
CREATE TABLE `ym_book_discounts` (
  `app_id` int(11) unsigned NOT NULL,
  `start_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ شروع',
  `end_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ پایان',
  `percent` int(3) unsigned DEFAULT NULL COMMENT 'درصد',
  PRIMARY KEY (`app_id`),
  CONSTRAINT `ym_book_discounts_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_discounts
-- ----------------------------
INSERT INTO `ym_book_discounts` VALUES ('35', '1470730245', '1471764600', '20');
INSERT INTO `ym_book_discounts` VALUES ('36', '1470764600', '1571764600', '20');

-- ----------------------------
-- Table structure for ym_book_images
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_images`;
CREATE TABLE `ym_book_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned DEFAULT NULL,
  `image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`book_id`) USING BTREE,
  CONSTRAINT `ym_book_images_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_images
-- ----------------------------
INSERT INTO `ym_book_images` VALUES ('1', '36', 'SkDnJ1471243156.jpg');
INSERT INTO `ym_book_images` VALUES ('2', '36', 'SkDnJ1471243156.jpg');
INSERT INTO `ym_book_images` VALUES ('3', '36', 'SkDnJ1471243156.jpg');
INSERT INTO `ym_book_images` VALUES ('4', '36', 'SkDnJ1471243156.jpg');
INSERT INTO `ym_book_images` VALUES ('5', '35', 'SkDnJ1471243156.jpg');

-- ----------------------------
-- Table structure for ym_book_packages
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_packages`;
CREATE TABLE `ym_book_packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `book_id` int(10) unsigned DEFAULT NULL COMMENT 'برنامه',
  `version` varchar(20) DEFAULT NULL COMMENT 'نسخه',
  `package_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'نام بسته',
  `file_name` varchar(255) DEFAULT NULL COMMENT 'فایل',
  `create_date` varchar(20) DEFAULT NULL COMMENT 'تاریخ بارگذاری',
  `publish_date` varchar(20) DEFAULT NULL COMMENT 'تاریخ انتشار',
  `status` enum('pending','accepted','refused','change_required') DEFAULT 'pending' COMMENT 'وضعیت',
  `reason` text CHARACTER SET utf8 COLLATE utf8_persian_ci COMMENT 'دلیل',
  `for` enum('new_app','old_app') CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`book_id`) USING BTREE,
  CONSTRAINT `ym_book_packages_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_book_packages
-- ----------------------------
INSERT INTO `ym_book_packages` VALUES ('24', '25', '2.1.4', 'ir.tgbs.android.iranapp2', '2.1.4-ir.tgbs.android.iranapp.apk', '1464260466', '1470123513', 'accepted', 'تعویض نام', 'new_app');
INSERT INTO `ym_book_packages` VALUES ('25', '35', '1.0.1', 'ir.tgbs.android.iranapp3', '1.0.1-ir.tgbs.android.iranapp.ipa', '1464260572', '1464353232', 'pending', 'به این دلیل', 'old_app');
INSERT INTO `ym_book_packages` VALUES ('33', '36', '2.1.4', 'ir.tgbs.android.iranapp123', '2.1.4-ir.tgbs.android.iranapp.apk', '1464419435', '1469083395', 'accepted', '', 'old_app');
INSERT INTO `ym_book_packages` VALUES ('36', '37', '1.0.1', 'ir.tgbs.android.iranapp321', '2.1.4-ir.tgbs.android.iranapp.apk', '1464421114', '1464421114', 'pending', '', 'new_app');
INSERT INTO `ym_book_packages` VALUES ('37', '38', '2.1.4', 'ir.tgbs.android.iranapp1232', '2.1.4-ir.tgbs.android.iranapp.apk', '1464774674', null, 'pending', '', 'new_app');
INSERT INTO `ym_book_packages` VALUES ('40', '47', '1.0.2', 'asdfghj', '1.0.2-asdfghj.xap', '1467092821', '1467092821', 'accepted', null, null);
INSERT INTO `ym_book_packages` VALUES ('41', '50', '2.1.4', 'ir.tgbs.android.iranapp', '2.1.4-ir.tgbs.android.iranapp.apk', '1473059653', null, 'pending', null, 'new_app');

-- ----------------------------
-- Table structure for ym_book_platforms
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_platforms`;
CREATE TABLE `ym_book_platforms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `file_types` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_book_platforms
-- ----------------------------
INSERT INTO `ym_book_platforms` VALUES ('1', 'android', 'اندروید', 'apk');
INSERT INTO `ym_book_platforms` VALUES ('2', 'ios', 'آی او اس', 'ipa');
INSERT INTO `ym_book_platforms` VALUES ('3', 'windowsphone', 'ویندوزفون', 'xap,appx');

-- ----------------------------
-- Table structure for ym_book_ratings
-- ----------------------------
DROP TABLE IF EXISTS `ym_book_ratings`;
CREATE TABLE `ym_book_ratings` (
  `user_id` int(11) unsigned NOT NULL,
  `book_id` int(11) unsigned NOT NULL,
  `rate` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`book_id`),
  KEY `app_id` (`book_id`) USING BTREE,
  CONSTRAINT `ym_book_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_book_ratings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_book_ratings
-- ----------------------------
INSERT INTO `ym_book_ratings` VALUES ('44', '36', '4');
INSERT INTO `ym_book_ratings` VALUES ('45', '35', '5');
INSERT INTO `ym_book_ratings` VALUES ('45', '36', '5');

-- ----------------------------
-- Table structure for ym_comments
-- ----------------------------
DROP TABLE IF EXISTS `ym_comments`;
CREATE TABLE `ym_comments` (
  `owner_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `owner_id` int(12) NOT NULL,
  `comment_id` int(12) NOT NULL AUTO_INCREMENT,
  `parent_comment_id` int(12) DEFAULT NULL,
  `creator_id` int(12) DEFAULT NULL,
  `user_name` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_email` varchar(128) COLLATE utf8_persian_ci DEFAULT NULL,
  `comment_text` text COLLATE utf8_persian_ci,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `owner_name` (`owner_name`,`owner_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_comments
-- ----------------------------
INSERT INTO `ym_comments` VALUES ('Apps', '36', '97', null, '45', null, null, 'سلام', '1472623774', null, '0');

-- ----------------------------
-- Table structure for ym_counter_save
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_save`;
CREATE TABLE `ym_counter_save` (
  `save_name` varchar(10) NOT NULL,
  `save_value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`save_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_counter_save
-- ----------------------------
INSERT INTO `ym_counter_save` VALUES ('counter', '126');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457661');
INSERT INTO `ym_counter_save` VALUES ('max_count', '5');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1457598600');
INSERT INTO `ym_counter_save` VALUES ('yesterday', '0');

-- ----------------------------
-- Table structure for ym_counter_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_users`;
CREATE TABLE `ym_counter_users` (
  `user_ip` varchar(255) NOT NULL,
  `user_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_counter_users
-- ----------------------------
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1475138463');

-- ----------------------------
-- Table structure for ym_pages
-- ----------------------------
DROP TABLE IF EXISTS `ym_pages`;
CREATE TABLE `ym_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `summary` text COMMENT 'متن',
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`) USING BTREE,
  CONSTRAINT `ym_pages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_page_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('1', 'درباره ما', 'متن صفحه درباره ما', '1');
INSERT INTO `ym_pages` VALUES ('2', 'تماس با ما', 'متن صفحه تماس با ما', '1');
INSERT INTO `ym_pages` VALUES ('3', 'راهنما', 'متن صفحه راهنما', '1');
INSERT INTO `ym_pages` VALUES ('4', 'شرایط استفاده از خدمات', 'متن صفحه شرایط استفاده از خدمات', '1');
INSERT INTO `ym_pages` VALUES ('5', 'حریم شخصی', 'متن صفحه حریم شخصی', '1');
INSERT INTO `ym_pages` VALUES ('6', 'متن راهنمای تسویه حساب', 'متن راهنما', '1');
INSERT INTO `ym_pages` VALUES ('7', 'قرارداد توسعه دهندگان', 'متن قرارداد', '1');

-- ----------------------------
-- Table structure for ym_page_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_page_categories`;
CREATE TABLE `ym_page_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `slug` varchar(255) DEFAULT NULL COMMENT 'آدرس',
  `multiple` tinyint(1) unsigned DEFAULT '1' COMMENT 'چند صحفه ای',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_page_categories
-- ----------------------------
INSERT INTO `ym_page_categories` VALUES ('1', 'صفحات استاتیک', 'base', '1');

-- ----------------------------
-- Table structure for ym_site_setting
-- ----------------------------
DROP TABLE IF EXISTS `ym_site_setting`;
CREATE TABLE `ym_site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_site_setting
-- ----------------------------
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'نیازمندی های آنلاین ');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', 'تابلو ');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', 'خرید، فروش، دست دوم، خودرو، املاک، موبایل، وسایل خانگی، تبلت، پوشاک ، نوزاد و سیسمونی، صوتی و تصویری، دوربین عکاسی فیلمبرداری، کنسول بازی، آرایشی، بهداشتی، زیبایی، جواهر، بدلیجات، ساعت، آنتیک، خدمات، آگهی، نیازمندی، استخدام،');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', 'تابلو فضای داد و ستد آنلاین و نیازمندی های خرید و فروش اینترنتی رایگان در بخش های املاک، خودرو، وسایل خانگی، موبایل، پوشاک، آنتیک، آرایشی زیبایی بهداشتی، عکاسی و ...');
INSERT INTO `ym_site_setting` VALUES ('5', 'buy_credit_options', 'گزینه های خرید اعتبار', '[\"5000\",\"10000\",\"20000\"]');
INSERT INTO `ym_site_setting` VALUES ('6', 'min_credit', 'حداقل اعتبار جهت تبدیل عضویت', '1000');
INSERT INTO `ym_site_setting` VALUES ('7', 'tax', 'میزان مالیات (درصد)', '9');
INSERT INTO `ym_site_setting` VALUES ('8', 'commission', 'حق کمیسیون (درصد)', '15');

-- ----------------------------
-- Table structure for ym_tickets
-- ----------------------------
DROP TABLE IF EXISTS `ym_tickets`;
CREATE TABLE `ym_tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه تیکت',
  `user_id` int(10) unsigned DEFAULT NULL,
  `status` enum('waiting','pending','open','close') COLLATE utf8_persian_ci DEFAULT 'waiting' COMMENT 'وضعیت تیکت',
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ',
  `subject` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'موضوع',
  `department_id` int(10) unsigned DEFAULT NULL COMMENT 'بخش',
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_tickets_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `ym_ticket_departments` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_tickets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_tickets
-- ----------------------------

-- ----------------------------
-- Table structure for ym_ticket_departments
-- ----------------------------
DROP TABLE IF EXISTS `ym_ticket_departments`;
CREATE TABLE `ym_ticket_departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'عنوان',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_ticket_departments
-- ----------------------------
INSERT INTO `ym_ticket_departments` VALUES ('1', 'مدیریت');
INSERT INTO `ym_ticket_departments` VALUES ('2', 'بخش فنی');
INSERT INTO `ym_ticket_departments` VALUES ('3', 'بخش پرداخت ها');

-- ----------------------------
-- Table structure for ym_ticket_messages
-- ----------------------------
DROP TABLE IF EXISTS `ym_ticket_messages`;
CREATE TABLE `ym_ticket_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(10) unsigned DEFAULT NULL COMMENT 'تیکت',
  `sender` enum('admin','supporter','user') COLLATE utf8_persian_ci DEFAULT NULL,
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ',
  `text` text COLLATE utf8_persian_ci COMMENT 'متن',
  `attachment` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'فایل ضمیمه',
  `visit` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`) USING BTREE,
  CONSTRAINT `ym_ticket_messages_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `ym_tickets` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_ticket_messages
-- ----------------------------

-- ----------------------------
-- Table structure for ym_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_users`;
CREATE TABLE `ym_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(10) unsigned DEFAULT NULL,
  `create_date` varchar(20) DEFAULT NULL,
  `status` enum('pending','active','blocked','deleted') DEFAULT 'pending',
  `verification_token` varchar(100) DEFAULT NULL,
  `change_password_request_count` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('43', '', '$2a$12$s8yAVo/JZ3Z86w5iFQV/7OIOGEwhyBCWj1Jw5DrlIqHERUF2otno2', 'gharagozlu.masoud@gmail.com', '2', '1460634664', 'active', 'ec0bfa4e54eed8afb0d7fb0305d52759', '1');
INSERT INTO `ym_users` VALUES ('44', '', '$2a$12$s8yAVo/JZ3Z86w5iFQV/7OIOGEwhyBCWj1Jw5DrlIqHERUF2otno2', 'mr.m.gharagozlu@gmail.com', '2', '1460634664', 'deleted', 'ec0bfa4e54eed8afb0d7fb0305d52759', '0');
INSERT INTO `ym_users` VALUES ('45', '', '$2a$12$NSBVAHtMkDLy65.hD5/i5e2WR3kUoeScIqwEC2u2EcrEpAghglYlK', 'yusef.mobasheri@gmail.com', '2', '1469083948', 'active', '9905d5fa6ac0ca05af43125a1f85123d', '0');

-- ----------------------------
-- Table structure for ym_user_book_bookmark
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_book_bookmark`;
CREATE TABLE `ym_user_book_bookmark` (
  `user_id` int(10) unsigned DEFAULT NULL,
  `app_id` int(10) unsigned DEFAULT NULL,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `app_id` (`app_id`) USING BTREE,
  CONSTRAINT `ym_user_book_bookmark_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ym_user_book_bookmark_ibfk_2` FOREIGN KEY (`app_id`) REFERENCES `ym_books` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_book_bookmark
-- ----------------------------
INSERT INTO `ym_user_book_bookmark` VALUES ('45', '36');

-- ----------------------------
-- Table structure for ym_user_details
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_details`;
CREATE TABLE `ym_user_details` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `fa_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام فارسی',
  `en_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام انگلیسی',
  `fa_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت فارسی',
  `en_web_url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس سایت انگلیسی',
  `national_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد ملی',
  `national_card_image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تصویر کارت ملی',
  `phone` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تلفن',
  `zip_code` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد پستی',
  `address` varchar(1000) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نشانی دقیق پستی',
  `credit` double DEFAULT NULL COMMENT 'اعتبار',
  `developer_id` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه توسعه دهنده',
  `details_status` enum('refused','pending','accepted') CHARACTER SET utf8 DEFAULT 'pending' COMMENT 'وضعیت اطلاعات کاربر',
  `monthly_settlement` tinyint(4) DEFAULT '0' COMMENT 'تسویه حساب ماهانه',
  `iban` varchar(24) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شماره شبا',
  `nickname` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام نمایشی',
  `type` enum('real','legal') CHARACTER SET utf8 DEFAULT 'real' COMMENT 'نوع حساب',
  `post` enum('ceo','board') CHARACTER SET utf8 DEFAULT NULL COMMENT 'سمت',
  `company_name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام شرکت',
  `registration_number` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شماره ثبت',
  `registration_certificate_image` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تصویر گواهی ثبت شرکت',
  `score` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('43', 'مسعود قراگوزلو', 'masoud', '', '', '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '1760', 'masouud', 'accepted', '1', '123456789123456789123456', 'Masoud', 'real', null, null, null, null, '0');
INSERT INTO `ym_user_details` VALUES ('44', 'مسعود قراگوزلو', null, '', null, null, null, '38888888', '3718958691', 'قم - همونجا', '2000', null, 'pending', '0', null, 'وای ام', 'legal', 'ceo', 'وب ایران', '134644535', 'OPxRK1466844466.jpg', '0');
INSERT INTO `ym_user_details` VALUES ('45', 'یوسف مبشری', 'yusef', null, null, '0370518926', 'ULcy91460814012.jpg', '09373252746', '3718895691', 'بلوار سوم خرداد', '4991000', 'Yusef', 'accepted', '1', '23423', null, 'real', null, null, null, null, '0');

-- ----------------------------
-- Table structure for ym_user_dev_id_requests
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_dev_id_requests`;
CREATE TABLE `ym_user_dev_id_requests` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `requested_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'شناسه درخواستی',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `ym_user_dev_id_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_dev_id_requests
-- ----------------------------

-- ----------------------------
-- Table structure for ym_user_notifications
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_notifications`;
CREATE TABLE `ym_user_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `message` varchar(500) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'متن پیام',
  `seen` tinyint(4) NOT NULL COMMENT 'مشاهده شده',
  `date` varchar(30) NOT NULL COMMENT 'زمان',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_user_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_notifications
-- ----------------------------
INSERT INTO `ym_user_notifications` VALUES ('2', '43', 'اطلاعات شما توسط مدیر سیستم تایید شد.', '1', '1461845059');
INSERT INTO `ym_user_notifications` VALUES ('3', '43', 'شناسه شما توسط مدیر سیستم تایید شد.', '1', '1461845059');
INSERT INTO `ym_user_notifications` VALUES ('4', '43', 'برنامه  برنامه لیدکامب - لکنت کودکان تایید شده است.', '1', '1461845059');
INSERT INTO `ym_user_notifications` VALUES ('6', '43', 'برنامه برنامه آزمایشی تایید شده است.', '1', '1464262310');
INSERT INTO `ym_user_notifications` VALUES ('7', '43', 'برنامه برنامه آزمایشی تایید شده است.', '1', '1464262422');
INSERT INTO `ym_user_notifications` VALUES ('8', '43', 'برنامه برنامه آزمایشی تایید شده است.', '1', '1464353232');
INSERT INTO `ym_user_notifications` VALUES ('9', '43', 'بسته asdfsdf توسط مدیر سیستم حذف شد.', '1', '1464358109');
INSERT INTO `ym_user_notifications` VALUES ('10', '43', 'بسته ir.tgbs.android.iranappasd توسط مدیر سیستم حذف شد.', '1', '1464358330');
INSERT INTO `ym_user_notifications` VALUES ('13', '43', 'بسته ir.tgbs.android.iranapp3 توسط مدیر سیستم رد شد.', '1', '1465459197');
INSERT INTO `ym_user_notifications` VALUES ('14', '43', 'بسته ir.tgbs.android.iranapp2 نیاز به تغییر دارد.', '1', '1465459228');
INSERT INTO `ym_user_notifications` VALUES ('15', null, 'بسته ir.tgbs.android.iranapp توسط مدیر سیستم حذف شد.', '0', '1467040015');
INSERT INTO `ym_user_notifications` VALUES ('16', '43', 'بسته ir.tgbs.android.iranapp123 توسط مدیر سیستم تایید شد.', '0', '1469083395');
INSERT INTO `ym_user_notifications` VALUES ('17', '43', 'برنامه تلگرام نیاز به تغییرات دارد.', '0', '1469083457');
INSERT INTO `ym_user_notifications` VALUES ('18', '45', 'بسته ir.tgbs.android.iranapp2 توسط مدیر سیستم تایید شد.', '1', '1470122805');
INSERT INTO `ym_user_notifications` VALUES ('19', '45', 'برنامه موبوگرام رد شده است.', '1', '1470123368');
INSERT INTO `ym_user_notifications` VALUES ('20', '45', 'برنامه موبوگرام نیاز به تغییرات دارد.', '1', '1470123486');
INSERT INTO `ym_user_notifications` VALUES ('21', '45', 'برنامه موبوگرام تایید شده است.', '1', '1470123513');

-- ----------------------------
-- Table structure for ym_user_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_roles`;
CREATE TABLE `ym_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_roles
-- ----------------------------
INSERT INTO `ym_user_roles` VALUES ('1', 'کاربر معمولی', 'user');
INSERT INTO `ym_user_roles` VALUES ('2', 'توسعه دهنده', 'developer');

-- ----------------------------
-- Table structure for ym_user_settlement
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_settlement`;
CREATE TABLE `ym_user_settlement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `amount` varchar(15) DEFAULT NULL COMMENT 'مبلغ',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  `iban` varchar(24) DEFAULT NULL COMMENT 'شماره شبا',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_user_settlement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_settlement
-- ----------------------------
INSERT INTO `ym_user_settlement` VALUES ('28', '43', '19000', '1462175546', '234242342');

-- ----------------------------
-- Table structure for ym_user_transactions
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_transactions`;
CREATE TABLE `ym_user_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT 'کاربر',
  `amount` varchar(10) DEFAULT NULL COMMENT 'مقدار',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ',
  `status` enum('unpaid','paid') DEFAULT 'unpaid' COMMENT 'وضعیت',
  `token` varchar(50) DEFAULT NULL COMMENT 'کد رهگیری',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `ym_user_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_transactions
-- ----------------------------
INSERT INTO `ym_user_transactions` VALUES ('1', '43', '5000', '1461646925', 'paid', 'j2343jk4h2k4h24h', 'خرید اعتبار از طریق درگاه زرین پال');
INSERT INTO `ym_user_transactions` VALUES ('4', '45', '100', '1470118630', 'unpaid', null, null);
