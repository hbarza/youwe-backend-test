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
INSERT INTO `backend_migration` VALUES ('m000000_000000_base',1525287887),('m140209_132017_init',1525287890),('m140403_174025_create_account_table',1525287890),('m140504_113157_update_tables',1525287893),('m140504_130429_create_token_table',1525287894),('m140830_171933_fix_ip_field',1525287895),('m140830_172703_change_account_table_name',1525287895),('m141222_110026_update_ip_field',1525287895),('m141222_135246_alter_username_length',1525287896),('m150614_103145_update_social_account_table',1525287900),('m150623_212711_fix_username_notnull',1525287900),('m151218_234654_add_timezone_to_profile',1525287900),('m160929_103127_add_last_login_at_to_user_table',1525287901),('m180406_183718_add_fullname_column_cellphone_column_dob_column_gender_column_country_column_division_column_city_column_address_column_to_user_table',1525289230),('m180414_100722_create_event_general_info_table',1525723586),('m180507_193618_create_event_speaker_table',1525723739),('m180518_093733_add_media_column_to_event_general_info_table',1526637293),('m180524_202920_add_faq_column_to_event_general_info',1527193856),('m180525_055639_create_event_partner_table',1527227974),('m180531_053249_add_seat_seattings_seat_map_column_to_event_general_info',1527745062),('m180601_180224_create_event_schedule_table',1528041823),('m180604_202836_create_cart_items_table',1531083493),('m180605_072608_add_price_type_column_to_event_general_info',1528183643),('m180605_095403_create_event_price_table',1528202765),('m180615_073626_add_opening_start_hours_column_to_event_general_info',1529048411),('m180622_061150_add_location_column_to_event_general_info',1529649025),('m180622_062834_drop_country_division_city_column_from_event_general_info_table',1529649026),('m180622_080659_drop_country_division_city_column_from_user_table',1529655098),('m180622_080827_add_location_column_to_user_table',1529655192),('m180629_145059_add_sub_title_column_to_event_general_info_table',1530283902),('m180701_153129_add_tickets_qty_column_to_event_general_info_table',1530459189),('m180709_091028_create_catalog_product_table',1531145767),('m180709_160601_drop_seats_column_from_event_general_info_table',1531152427),('m180817_063927_create_sales_order_table',1534582810),('m180819_085258_add_merchant_id_column_to_catalog_product_table',1534693579),('m180819_174000_create_sales_order_item_table',1534700888),('m180819_212046_drop_ticket_type_column_from_sales_order_table',1534713704),('m180913_163627_create_message_table',1536961006),('m180913_165530_create_order_message_relation_table',1537106198),('m180926_200950_add_created_at_column_to_message_table',1538056936),('m180927_140927_add_new_column_to_order_message_relation_table',1538057478),('m181216_111019_drop_billing_address_column_from_sales_order_table',1544958660),('m181216_111148_add_billing_data_column_to_sales_order_table',1544958799),('m181216_111714_add_product_data_column_to_sales_order_item_table',1544959108),('m181225_124437_create_saman_sep_micro_transaction_table',1545744644),('m181226_103011_add_verifiaction_result_column_to_saman_sep_micro_transaction_table',1545820225),('m181229_172901_add_ticket_info_columns_column_to_sales_order_item_table',1546104609),('tigrov\\country\\migrations\\m170405_112954_init',1525287903);
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
INSERT INTO `profile` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1000,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order`
--

LOCK TABLES `sales_order` WRITE;
/*!40000 ALTER TABLE `sales_order` DISABLE KEYS */;
INSERT INTO `sales_order` VALUES (1,1,2,1134000.0000,'2018-12-18 11:44:50','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(2,1,2,1134000.0000,'2018-12-18 11:45:19','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(3,1,2,1134000.0000,'2018-12-18 11:45:28','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(4,1,2,1134000.0000,'2018-12-18 11:45:53','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(5,1,2,1134000.0000,'2018-12-18 11:46:28','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(6,1,2,1134000.0000,'2018-12-18 11:46:48','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(7,1,2,1134000.0000,'2018-12-18 11:47:09','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(8,1,2,1134000.0000,'2018-12-18 11:47:44','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(9,1,2,1134000.0000,'2018-12-18 11:48:38','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(10,1,2,1134000.0000,'2018-12-18 11:52:20','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(11,1,2,1134000.0000,'2018-12-18 11:53:32','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(12,1,2,1134000.0000,'2018-12-18 11:53:55','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"gender\":\"1\",\"cell_phone\":\"09123456789\",\"terms\":[\"1\"]}'),(13,1,2,1620000.0000,'2018-12-19 03:22:00','SepMicro',NULL,_binary '{\"firstname\":\"تست\",\"lastname\":\"تستر\",\"cell_phone\":\"09123456789\",\"email\":null,\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(14,1,2,1200000.0000,'2018-12-19 06:35:37','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(15,1,2,1296000.0000,'2018-12-19 07:00:14','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(16,1,2,648000.0000,'2018-12-19 07:01:12','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(17,1,2,1620000.0000,'2018-12-19 08:31:50','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(18,1,2,1620000.0000,'2018-12-19 08:44:35','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(19,1,2,1620000.0000,'2018-12-19 08:45:17','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(20,1,2,1620000.0000,'2018-12-19 08:45:33','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(21,1,2,1620000.0000,'2018-12-19 08:45:52','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(22,1,2,1620000.0000,'2018-12-19 08:46:23','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(23,1,2,1620000.0000,'2018-12-19 08:47:44','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(24,1,2,1134000.0000,'2018-12-19 08:50:52','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(25,1,2,400000.0000,'2018-12-19 08:59:21','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(26,1,2,2754000.0000,'2018-12-19 09:03:13','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(27,1,2,2430000.0000,'2018-12-19 09:50:41','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(28,1,2,2592000.0000,'2018-12-19 10:08:43','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(29,1,2,4740000.0000,'2018-12-19 10:18:47','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(30,1,2,810000.0000,'2018-12-19 10:22:47','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(31,1,2,1620000.0000,'2018-12-19 10:28:22','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(32,1,2,1620000.0000,'2018-12-19 10:29:48','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(33,1,2,4050000.0000,'2018-12-19 11:06:20','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(34,1,2,1296000.0000,'2018-12-19 11:11:24','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(35,1,2,1296000.0000,'2018-12-19 11:14:40','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(36,1,2,1296000.0000,'2018-12-19 12:23:18','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(37,1,2,1296000.0000,'2018-12-19 12:30:49','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(38,1,2,648000.0000,'2018-12-22 02:20:39','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(39,1,2,648000.0000,'2018-12-22 02:21:01','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(40,1,2,480000.0000,'2018-12-22 02:22:56','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(41,1,2,1296000.0000,'2018-12-22 09:15:58','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(42,1,2,1296000.0000,'2018-12-25 04:11:43','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(43,1,2,1296000.0000,'2018-12-25 04:12:05','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(44,1,2,1296000.0000,'2018-12-25 04:12:14','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(45,1,2,1296000.0000,'2018-12-25 04:12:16','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(46,1,2,1296000.0000,'2018-12-25 04:13:01','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(47,1,2,1296000.0000,'2018-12-25 04:15:59','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(48,1,2,1296000.0000,'2018-12-25 04:17:42','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(49,1,2,1296000.0000,'2018-12-25 04:18:44','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(50,1,2,1296000.0000,'2018-12-25 04:19:43','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(51,1,2,1296000.0000,'2018-12-25 04:20:04','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(52,1,2,1296000.0000,'2018-12-25 04:33:25','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(53,1,2,1000.0000,'2018-12-25 10:15:48','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(54,1,2,1000.0000,'2018-12-26 04:17:45','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(55,1,2,1000.0000,'2018-12-29 02:01:02','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(56,1,2,1000.0000,'2018-12-29 02:15:45','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(57,1,2,1000.0000,'2018-12-29 02:17:51','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(58,1,2,1000.0000,'2018-12-29 02:23:31','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(59,1,2,1000.0000,'2018-12-29 02:24:13','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(60,1,2,1000.0000,'2018-12-29 02:26:12','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(61,1,2,1000.0000,'2018-12-29 02:27:24','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(62,1,2,1000.0000,'2018-12-29 02:28:40','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(63,1,2,1000.0000,'2018-12-29 03:02:36','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(64,1,2,1000.0000,'2018-12-29 03:49:16','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(65,1,2,1000.0000,'2018-12-29 03:49:59','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(66,1,2,1000.0000,'2018-12-29 03:52:32','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(67,1,3,1000.0000,'2018-12-29 13:34:05','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(68,1,3,1000.0000,'2018-12-29 14:49:25','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(69,1,3,1000.0000,'2018-12-30 02:02:43','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}'),(70,1,3,1000.0000,'2018-12-30 03:27:28','SepMicro',NULL,_binary '{\"firstname\":\"امید\",\"lastname\":\"برزا\",\"cellphone\":\"09123456789\",\"email\":\"admin@admin.com\",\"city\":null,\"address\":null,\"extra_data\":null,\"template\":null}');
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
  `ticket_provider` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `ticket_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ticket_status` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-sales_order_item-order_id` (`order_id`),
  KEY `idx-sales_order_item-merchant_id` (`merchant_id`),
  CONSTRAINT `fk-sales_order_item-merchant_id` FOREIGN KEY (`merchant_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-sales_order_item-order_id` FOREIGN KEY (`order_id`) REFERENCES `sales_order` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order_item`
--

LOCK TABLES `sales_order_item` WRITE;
/*!40000 ALTER TABLE `sales_order_item` DISABLE KEYS */;
INSERT INTO `sales_order_item` VALUES (1,23,1,'تهران - مشهد (1397-09-28)',810000.0000,2,'bus',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11293320-31310000\",\"price\":\"810000\",\"discount\":\"0\",\"company\":\"تعاونی 4 میهن نور آریا پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T15:15:00Z\",\"seat_numbers\":\"10,11\"}}',NULL,NULL,NULL,NULL),(2,24,1,'تهران - مشهد (1397-09-28)',567000.0000,2,'bus',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"10920849-31310000\",\"price\":\"810000\",\"discount\":\"30\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T13:00:00Z\",\"seat_numbers\":\"11,10\"}}',NULL,NULL,NULL,NULL),(3,25,1,'تهران - اصفهان (<span class=\"ltr\">1397-09-28</span>)',400000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"اصفهان\",\"destination\":\"21310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"10872186-21310000\",\"price\":\"400000\",\"discount\":\"0\",\"company\":\"تعاونی 4 میهن نور آریا پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"صفه\",\"departure\":\"2018-12-19T20:00:00Z\",\"seat_numbers\":\"25\"}}',NULL,NULL,NULL,NULL),(4,26,1,'تهران - شیراز (<span class=\"ltr inline-block\">1397-09-28</span>)',688500.0000,4,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"شیراز\",\"destination\":\"41310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"10934178-41310000\",\"price\":\"810000\",\"discount\":\"15\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"کاراندیش\",\"departure\":\"2018-12-19T15:15:00Z\",\"seat_numbers\":\"8,7,5,4\"}}',NULL,NULL,NULL,NULL),(5,27,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-09-28</span>)',810000.0000,3,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11293320-31310000\",\"price\":\"810000\",\"discount\":\"0\",\"company\":\"تعاونی 4 میهن نور آریا پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T15:15:00Z\",\"seat_numbers\":\"6,5,4\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/order/item/details.phtml\"}',NULL,NULL,NULL,NULL),(6,28,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-09-28</span>)',648000.0000,4,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"10920879-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T15:30:00Z\",\"seat_numbers\":\"13,16,15,14\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(7,29,1,'مشهد - تهران (<span class=\"ltr inline-block\">1397-09-28</span>)',790000.0000,6,'اتوبوس',_binary '{\"origin_name\":\"مشهد\",\"origin\":\"31310000\",\"destination_name\":\"تهران\",\"destination\":\"11320000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11171753-11320000\",\"price\":\"790000\",\"discount\":\"0\",\"company\":\"پیک صبا مشهد\",\"boarding\":\"مشهد (خراسان )\",\"dropping\":\"جنوب (خزانه)\",\"departure\":\"2018-12-19T19:15:00Z\",\"seat_numbers\":\"12,9,8,11,10,7\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(8,29,1,'مشهد - تهران (<span class=\"ltr inline-block\">1397-09-28</span>)',790000.0000,6,'اتوبوس',_binary '{\"origin_name\":\"مشهد\",\"origin\":\"31310000\",\"destination_name\":\"تهران\",\"destination\":\"11320000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11171753-11320000\",\"price\":\"790000\",\"discount\":\"0\",\"company\":\"پیک صبا مشهد\",\"boarding\":\"مشهد (خراسان )\",\"dropping\":\"جنوب (خزانه)\",\"departure\":\"2018-12-19T19:15:00Z\",\"seat_numbers\":\"12,9,8,11,10,7\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(9,30,1,'تهران - شیراز (<span class=\"ltr inline-block\">1397-09-28</span>)',810000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"شیراز\",\"destination\":\"41310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"10911505-95410000\",\"price\":\"810000\",\"discount\":\"0\",\"company\":\"تعاونی6 ایمن سفر ایرانیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"Shiraz\",\"departure\":\"2018-12-19T14:30:00Z\",\"seat_numbers\":\"24\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm.phtml\"}',NULL,NULL,NULL,NULL),(10,31,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-09-28</span>)',810000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11279580-31310000\",\"price\":\"810000\",\"discount\":\"0\",\"company\":\"تعاونی5 کیان سفرپاسارگاد پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T15:15:00Z\",\"seat_numbers\":\"15,14\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/information.phtml\"}',NULL,NULL,NULL,NULL),(11,32,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-09-28</span>)',810000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11055055-31310000\",\"price\":\"810000\",\"discount\":\"0\",\"company\":\"تعاونی 9 راه پیما پارسیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T15:15:00Z\",\"seatmap\":\"{\\\"5\\\":\\\"m[1,1]m[4,4]m[7,7]a[10,10]_m[14,14]a[17,17]a[20,20]a[23,23]\\\",\\\"4\\\":\\\"m[2,2]m[5,5]m[8,8]a[11,11]_m[15,15]a[18,18]a[21,21]a[24,24]\\\",\\\"3\\\":\\\"_________\\\",\\\"2\\\":\\\"_________\\\",\\\"1\\\":\\\"m[3,3]m[6,6]m[9,9]a[12,12]a[13,13]a[16,16]a[19,19]a[22,22]a[25,25]\\\"}\",\"rows_count\":\"9\",\"seat_numbers\":\"13,12\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/information.phtml\"}',NULL,NULL,NULL,NULL),(12,33,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-09-28</span>)',810000.0000,5,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11279580-31310000\",\"price\":\"810000\",\"discount\":\"0\",\"company\":\"تعاونی5 کیان سفرپاسارگاد پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T15:15:00Z\",\"seat_numbers\":\"14,15,17,18,21\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(13,34,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-09-28</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"10920914-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T17:00:00Z\",\"seat_numbers\":\"16,19\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(14,35,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-09-28</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"10920879-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T15:30:00Z\",\"seat_numbers\":\"7,8\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(15,36,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-09-28</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"10920879-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T15:30:00Z\",\"seat_numbers\":\"7,8\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(16,37,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-09-28</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-19\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"10920879-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-19T15:30:00Z\",\"seat_numbers\":\"7,8\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(17,38,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-01</span>)',648000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-22\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337437-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی6 ایمن سفر ایرانیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-22T07:30:00Z\",\"seat_numbers\":\"16\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(18,39,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-01</span>)',648000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-22\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337437-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی6 ایمن سفر ایرانیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-22T07:30:00Z\",\"seat_numbers\":\"16\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(19,40,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-01</span>)',480000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-22\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11357809-31310000\",\"price\":\"480000\",\"discount\":\"0\",\"company\":\"تعاونی5 کیان سفرپاسارگاد پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-22T07:00:00Z\",\"seat_numbers\":\"12\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(20,41,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-01</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-22\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11310342-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-22T15:30:00Z\",\"seat_numbers\":\"12,9\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(21,42,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11257664-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T13:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(22,43,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11257664-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T13:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(23,44,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11257664-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T13:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(24,45,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11257664-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T13:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(25,46,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11257664-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T13:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(26,47,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11257664-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T13:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(27,48,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11257664-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T13:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(28,49,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11257664-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی 7 عدل پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T13:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(29,50,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337500-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی6 ایمن سفر ایرانیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T09:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(30,51,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337500-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی6 ایمن سفر ایرانیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T09:00:00Z\",\"seat_numbers\":\"11,10\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(31,52,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337500-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی6 ایمن سفر ایرانیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T09:00:00Z\",\"seat_numbers\":\"8,7\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(32,53,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-04</span>)',810000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-25\",\"departing_persian\":\"1397/10/04\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11243727-31310000\",\"price\":\"810000\",\"discount\":\"0\",\"company\":\"تعاونی 17 پیک صبا پایانه بیهقی\",\"boarding\":\"پایانه  بیهقی\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-25T14:30:00Z\",\"seat_numbers\":\"12\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(33,54,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-06</span>)',648000.0000,2,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-27\",\"departing_persian\":\"1397/10/06\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337375-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی6 ایمن سفر ایرانیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-27T05:00:00Z\",\"seat_numbers\":\"13,14\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(34,55,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-08</span>)',648000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2018-12-29\",\"departing_persian\":\"1397/10/08\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337444-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی6 ایمن سفر ایرانیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2018-12-29T07:00:00Z\",\"seat_numbers\":\"13\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(35,56,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-08</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2018-12-29\",\"departing_persian\":\"1397/10/08\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11361435-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2018-12-29T19:50:00Z\",\"seat_numbers\":\"9\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(36,57,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-08</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2018-12-29\",\"departing_persian\":\"1397/10/08\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11361435-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2018-12-29T19:50:00Z\",\"seat_numbers\":\"9\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(37,58,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-08</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2018-12-29\",\"departing_persian\":\"1397/10/08\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11361435-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2018-12-29T19:50:00Z\",\"seat_numbers\":\"6\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(38,59,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-08</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2018-12-29\",\"departing_persian\":\"1397/10/08\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11361435-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2018-12-29T19:50:00Z\",\"seat_numbers\":\"6\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(39,60,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-08</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2018-12-29\",\"departing_persian\":\"1397/10/08\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11361435-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2018-12-29T19:50:00Z\",\"seat_numbers\":\"6\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(40,61,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-08</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2018-12-29\",\"departing_persian\":\"1397/10/08\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11361435-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2018-12-29T19:50:00Z\",\"seat_numbers\":\"6\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(41,62,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-08</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2018-12-29\",\"departing_persian\":\"1397/10/08\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11361435-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2018-12-29T19:50:00Z\",\"seat_numbers\":\"6\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(42,63,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-08</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2018-12-29\",\"departing_persian\":\"1397/10/08\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11361435-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2018-12-29T19:50:00Z\",\"seat_numbers\":\"6\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(43,64,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-30</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2019-01-20\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337756-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2019-01-20T03:15:00Z\",\"seat_numbers\":\"1\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(44,65,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-30</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2019-01-20\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337756-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2019-01-20T03:15:00Z\",\"seat_numbers\":\"1\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(45,66,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-30</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2019-01-20\",\"departing_persian\":\"1397/10/30\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337756-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2019-01-20T03:15:00Z\",\"seat_numbers\":\"1\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(46,67,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-30</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2019-01-20\",\"departing_persian\":\"1397/10/30\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337756-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2019-01-20T03:15:00Z\",\"seat_numbers\":\"5\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}','safar',3777291,'279980160769',0),(47,68,1,'تهران - مشهد (<span class=\"ltr inline-block\">1397-10-30</span>)',648000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"مشهد\",\"destination\":\"31310000\",\"departing\":\"2019-01-20\",\"departing_persian\":\"1397/10/30\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337354-31310000\",\"price\":\"810000\",\"discount\":\"20\",\"company\":\"تعاونی6 ایمن سفر ایرانیان پایانه جنوب\",\"boarding\":\"پایانه  جنوب\",\"dropping\":\"امام رضا\",\"departure\":\"2019-01-20T04:00:00Z\",\"seat_numbers\":\"12\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(48,69,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-30</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2019-01-20\",\"departing_persian\":\"1397/10/30\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337756-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2019-01-20T03:15:00Z\",\"seat_numbers\":\"3\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL),(49,70,1,'تهران - قم (<span class=\"ltr inline-block\">1397-10-30</span>)',140000.0000,1,'اتوبوس',_binary '{\"origin_name\":\"تهران\",\"origin\":\"11320000\",\"destination_name\":\"قم\",\"destination\":\"14310000\",\"departing\":\"2019-01-20\",\"departing_persian\":\"1397/10/30\",\"reservation\":{\"provider\":\"safar\",\"bus_id\":\"11337756-21310000\",\"price\":\"140000\",\"discount\":\"0\",\"company\":\"تعاونی 7 عدل پایانه غرب\",\"boarding\":\"پایانه  غرب\",\"dropping\":\"Qom\",\"departure\":\"2019-01-20T03:15:00Z\",\"seat_numbers\":\"13\"},\"template\":\"@app/modules/Codnitive/Bus/views/templates/process/confirm/_details.phtml\"}',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `sales_order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saman_sep_micro_transaction`
--

DROP TABLE IF EXISTS `saman_sep_micro_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saman_sep_micro_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `state_code` int(5) NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_num` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trance_no` int(11) DEFAULT NULL,
  `verifiaction_result` decimal(15,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`),
  UNIQUE KEY `ref_num` (`ref_num`),
  KEY `idx-saman_sep_micro_transaction-order_id` (`order_id`),
  KEY `idx-saman_sep_micro_transaction-ref_num` (`ref_num`),
  CONSTRAINT `fk-saman_sep_micro_transaction-order_id` FOREIGN KEY (`order_id`) REFERENCES `sales_order` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saman_sep_micro_transaction`
--

LOCK TABLES `saman_sep_micro_transaction` WRITE;
/*!40000 ALTER TABLE `saman_sep_micro_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `saman_sep_micro_transaction` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin@admin.com','$2y$10$iY8w/QlWo4Lm19dUxojpC.zYKAPKQwAxZjRC1OP7IEEZgmSx56eRG','XjLA1RmDqH2V1t14O9iUPdCUs0adZyHA',1525289391,NULL,NULL,'127.0.0.1',1525289391,1545208127,0,1546147957,'امید برزا','09123456789','1983-03-25',1,'Valiasr','Tehran Province, Iran'),(1000,'test','test@tester.com','$2y$10$4nOzAwj9z4bsAEU9JH.jwuDAoiayXHiiWxrd6YyvuHm9pbJDTR5PG','Inn3b9z5ozV61Xs9Z_4m1MbKxNMfTKOX',1545210579,NULL,NULL,'127.0.0.1',1545210579,1545210579,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
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

-- Dump completed on 2018-12-30 10:29:02
