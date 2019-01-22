-- MySQL dump 10.13  Distrib 5.7.24-26, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bilit
-- ------------------------------------------------------
-- Server version	5.7.24-26

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
/*!50717 SELECT COUNT(*) INTO @rocksdb_has_p_s_session_variables FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'performance_schema' AND TABLE_NAME = 'session_variables' */;
/*!50717 SET @rocksdb_get_is_supported = IF (@rocksdb_has_p_s_session_variables, 'SELECT COUNT(*) INTO @rocksdb_is_supported FROM performance_schema.session_variables WHERE VARIABLE_NAME=\'rocksdb_bulk_load\'', 'SELECT 0') */;
/*!50717 PREPARE s FROM @rocksdb_get_is_supported */;
/*!50717 EXECUTE s */;
/*!50717 DEALLOCATE PREPARE s */;
/*!50717 SET @rocksdb_enable_bulk_load = IF (@rocksdb_is_supported, 'SET SESSION rocksdb_bulk_load = 1', 'SET @rocksdb_dummy_bulk_load = 0') */;
/*!50717 PREPARE s FROM @rocksdb_enable_bulk_load */;
/*!50717 EXECUTE s */;
/*!50717 DEALLOCATE PREPARE s */;

--
-- Table structure for table `backend_migration`
--

DROP TABLE IF EXISTS `backend_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_migration`
--

LOCK TABLES `backend_migration` WRITE;
/*!40000 ALTER TABLE `backend_migration` DISABLE KEYS */;
INSERT INTO `backend_migration` VALUES ('m000000_000000_base',1525287887),('m140209_132017_init',1525287890),('m140403_174025_create_account_table',1525287890),('m140504_113157_update_tables',1525287893),('m140504_130429_create_token_table',1525287894),('m140830_171933_fix_ip_field',1525287895),('m140830_172703_change_account_table_name',1525287895),('m141222_110026_update_ip_field',1525287895),('m141222_135246_alter_username_length',1525287896),('m150614_103145_update_social_account_table',1525287900),('m150623_212711_fix_username_notnull',1525287900),('m151218_234654_add_timezone_to_profile',1525287900),('m160929_103127_add_last_login_at_to_user_table',1525287901),('m180406_183718_add_fullname_column_cellphone_column_dob_column_gender_column_country_column_division_column_city_column_address_column_to_user_table',1525289230),('m180414_100722_create_event_general_info_table',1525723586),('m180507_193618_create_event_speaker_table',1525723739),('m180518_093733_add_media_column_to_event_general_info_table',1526637293),('m180524_202920_add_faq_column_to_event_general_info',1527193856),('m180525_055639_create_event_partner_table',1527227974),('m180531_053249_add_seat_seattings_seat_map_column_to_event_general_info',1527745062),('m180601_180224_create_event_schedule_table',1528041823),('m180604_202836_create_cart_items_table',1531083493),('m180605_072608_add_price_type_column_to_event_general_info',1528183643),('m180605_095403_create_event_price_table',1528202765),('m180615_073626_add_opening_start_hours_column_to_event_general_info',1529048411),('m180622_061150_add_location_column_to_event_general_info',1529649025),('m180622_062834_drop_country_division_city_column_from_event_general_info_table',1529649026),('m180622_080659_drop_country_division_city_column_from_user_table',1529655098),('m180622_080827_add_location_column_to_user_table',1529655192),('m180629_145059_add_sub_title_column_to_event_general_info_table',1530283902),('m180701_153129_add_tickets_qty_column_to_event_general_info_table',1530459189),('m180709_091028_create_catalog_product_table',1531145767),('m180709_160601_drop_seats_column_from_event_general_info_table',1531152427),('m180817_063927_create_sales_order_table',1534582810),('m180819_085258_add_merchant_id_column_to_catalog_product_table',1534693579),('m180819_174000_create_sales_order_item_table',1534700888),('m180819_212046_drop_ticket_type_column_from_sales_order_table',1534713704),('m180913_163627_create_message_table',1536961006),('m180913_165530_create_order_message_relation_table',1537106198),('m180926_200950_add_created_at_column_to_message_table',1538056936),('m180927_140927_add_new_column_to_order_message_relation_table',1538057478),('m181216_111019_drop_billing_address_column_from_sales_order_table',1544958660),('m181216_111148_add_billing_data_column_to_sales_order_table',1544958799),('m181216_111714_add_product_data_column_to_sales_order_item_table',1544959108),('tigrov\\country\\migrations\\m170405_112954_init',1525287903);
/*!40000 ALTER TABLE `backend_migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_items` (
  `user_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `quantity` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`product_id`),
  KEY `idx-cart_items-user_id` (`user_id`),
  KEY `idx-cart_items-product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalog_product`
--

DROP TABLE IF EXISTS `catalog_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalog_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `entity_type` int(3) NOT NULL,
  `entity_model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price_id` int(11) NOT NULL,
  `price_model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `merchant_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-catalog_product-entity_id` (`entity_id`),
  KEY `idx-catalog_product-price_id` (`price_id`),
  KEY `idx-catalog_product-merchant_id` (`merchant_id`),
  CONSTRAINT `fk-catalog_product-merchant_id` FOREIGN KEY (`merchant_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalog_product`
--

LOCK TABLES `catalog_product` WRITE;
/*!40000 ALTER TABLE `catalog_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalog_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-message-merchant_id` (`merchant_id`),
  CONSTRAINT `fk-message-merchant_id` FOREIGN KEY (`merchant_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_message_relation`
--

DROP TABLE IF EXISTS `order_message_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_message_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `entity_type` int(3) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `message_id` text COLLATE utf8_unicode_ci,
  `new` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx-order_message_relation-order_id` (`order_id`),
  KEY `idx-order_message_relation-entity_id` (`entity_id`),
  KEY `idx-order_message_relation-entity_type` (`entity_type`),
  KEY `idx-order_message_relation-customer_id` (`customer_id`),
  CONSTRAINT `fk-order_message_relation-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-order_message_relation-order_id` FOREIGN KEY (`order_id`) REFERENCES `sales_order` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_message_relation`
--

LOCK TABLES `order_message_relation` WRITE;
/*!40000 ALTER TABLE `order_message_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_message_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_order`
--

DROP TABLE IF EXISTS `sales_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `status` int(4) NOT NULL,
  `grand_total` decimal(15,4) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_info` text COLLATE utf8_unicode_ci,
  `billing_data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-sales_order-customer_id` (`customer_id`),
  CONSTRAINT `fk-sales_order-customer_id` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order`
--

LOCK TABLES `sales_order` WRITE;
/*!40000 ALTER TABLE `sales_order` DISABLE KEYS */;
INSERT INTO `sales_order` VALUES (1,1,2,1134000.0000,'2018-12-18 11:44:50','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(2,1,2,1134000.0000,'2018-12-18 11:45:19','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(3,1,2,1134000.0000,'2018-12-18 11:45:28','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(4,1,2,1134000.0000,'2018-12-18 11:45:53','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(5,1,2,1134000.0000,'2018-12-18 11:46:28','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(6,1,2,1134000.0000,'2018-12-18 11:46:48','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(7,1,2,1134000.0000,'2018-12-18 11:47:09','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(8,1,2,1134000.0000,'2018-12-18 11:47:44','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(9,1,2,1134000.0000,'2018-12-18 11:48:38','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(10,1,2,1134000.0000,'2018-12-18 11:52:20','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(11,1,2,1134000.0000,'2018-12-18 11:53:32','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(12,1,2,1134000.0000,'2018-12-18 11:53:55','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}');
/*!40000 ALTER TABLE `sales_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_order_item`
--

DROP TABLE IF EXISTS `sales_order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `ticket_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_data` blob,
  PRIMARY KEY (`id`),
  KEY `idx-sales_order_item-order_id` (`order_id`),
  KEY `idx-sales_order_item-merchant_id` (`merchant_id`),
  CONSTRAINT `fk-sales_order_item-merchant_id` FOREIGN KEY (`merchant_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-sales_order_item-order_id` FOREIGN KEY (`order_id`) REFERENCES `sales_order` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order_item`
--

LOCK TABLES `sales_order_item` WRITE;
/*!40000 ALTER TABLE `sales_order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_account`
--

DROP TABLE IF EXISTS `social_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  UNIQUE KEY `account_unique_code` (`code`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_account`
--

LOCK TABLES `social_account` WRITE;
/*!40000 ALTER TABLE `social_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL,
  `fullname` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cellphone` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `address` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin@admin.com','$2y$10$iY8w/QlWo4Lm19dUxojpC.zYKAPKQwAxZjRC1OP7IEEZgmSx56eRG','XjLA1RmDqH2V1t14O9iUPdCUs0adZyHA',1525289391,NULL,NULL,'127.0.0.1',1525289391,1545143643,0,1545144069,'Omid','09123456789','1983-03-25',1,'Valiasr','Tehran Province, Iran');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!50112 SET @disable_bulk_load = IF (@is_rocksdb_supported, 'SET SESSION rocksdb_bulk_load = @old_rocksdb_bulk_load', 'SET @dummy_rocksdb_bulk_load = 0') */;
/*!50112 PREPARE s FROM @disable_bulk_load */;
/*!50112 EXECUTE s */;
/*!50112 DEALLOCATE PREPARE s */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-18 20:39:37
