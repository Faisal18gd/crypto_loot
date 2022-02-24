-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: luckyduel-app.cnedifkuze2a.us-east-2.rds.amazonaws.com    Database: admin_app
-- ------------------------------------------------------
-- Server version	5.7.26-log

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED='';

--
-- Table structure for table `aid`
--

DROP TABLE IF EXISTS `aid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aid_aid_unique` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aid`
--

LOCK TABLES `aid` WRITE;
/*!40000 ALTER TABLE `aid` DISABLE KEYS */;
/*!40000 ALTER TABLE `aid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('luckyduel_cacheadminindexearningstotal','d:0;',1576338832),('luckyduel_cachec7221fc1107510e5dfdbb9d6d6a55acb759c2c96','i:1;',1576339268),('luckyduel_cachec7221fc1107510e5dfdbb9d6d6a55acb759c2c96:timer','i:1576339268;',1576339268),('luckyduel_cachee1a38989a65ecc1efa29fa0cbebb412f0c43884c','i:1;',1575813395),('luckyduel_cachee1a38989a65ecc1efa29fa0cbebb412f0c43884c:timer','i:1575813395;',1575813395),('luckyduel_cacheearningstoday','d:0;',1576339082),('luckyduel_cachelatestleads','a:1:{s:3:\"res\";a:1:{i:0;a:3:{s:6:\"payout\";s:0:\"\";s:4:\"user\";s:0:\"\";s:5:\"times\";s:0:\"\";}}}',1576339382),('luckyduel_cacheleaderboard','a:7:{s:6:\"status\";i:1;s:7:\"max_win\";s:4:\"1000\";s:9:\"self_name\";s:5:\"Demo1\";s:11:\"self_avatar\";s:4:\"none\";s:11:\"self_amount\";i:196;s:9:\"self_rank\";i:1;s:6:\"others\";O:29:\"Illuminate\\Support\\Collection\":1:{s:8:\"\0*\0items\";a:1:{i:0;O:8:\"stdClass\":3:{s:4:\"name\";s:5:\"Demo1\";s:6:\"avatar\";s:4:\"none\";s:10:\"amount_cur\";i:196;}}}}',1576340255),('luckyduel_cacheonlineusers','O:27:\"Khill\\Lavacharts\\Lavacharts\":5:{s:35:\"\0Khill\\Lavacharts\\Lavacharts\0locale\";s:2:\"en\";s:36:\"\0Khill\\Lavacharts\\Lavacharts\0volcano\";O:24:\"Khill\\Lavacharts\\Volcano\":2:{s:32:\"\0Khill\\Lavacharts\\Volcano\0charts\";a:1:{s:8:\"GeoChart\";a:1:{s:10:\"Popularity\";O:32:\"Khill\\Lavacharts\\Charts\\GeoChart\":6:{s:10:\"\0*\0options\";a:1:{s:15:\"backgroundColor\";s:7:\"#cad2d3\";}s:40:\"\0Khill\\Lavacharts\\Charts\\Chart\0datatable\";O:37:\"Khill\\Lavacharts\\DataTables\\DataTable\":6:{s:16:\"\0*\0columnFactory\";O:49:\"Khill\\Lavacharts\\DataTables\\Columns\\ColumnFactory\":0:{}s:13:\"\0*\0rowFactory\";N;s:7:\"\0*\0cols\";a:2:{i:0;O:42:\"Khill\\Lavacharts\\DataTables\\Columns\\Column\":5:{s:7:\"\0*\0type\";s:6:\"string\";s:8:\"\0*\0label\";s:7:\"Country\";s:9:\"\0*\0format\";N;s:7:\"\0*\0role\";N;s:10:\"\0*\0options\";a:0:{}}i:1;O:42:\"Khill\\Lavacharts\\DataTables\\Columns\\Column\":5:{s:7:\"\0*\0type\";s:6:\"number\";s:8:\"\0*\0label\";s:5:\"Count\";s:9:\"\0*\0format\";N;s:7:\"\0*\0role\";N;s:10:\"\0*\0options\";a:0:{}}}s:7:\"\0*\0rows\";a:1:{i:0;O:36:\"Khill\\Lavacharts\\DataTables\\Rows\\Row\":1:{s:9:\"\0*\0values\";a:2:{i:0;O:38:\"Khill\\Lavacharts\\DataTables\\Cells\\Cell\":4:{s:4:\"\0*\0v\";s:2:\"US\";s:4:\"\0*\0f\";s:0:\"\";s:4:\"\0*\0p\";N;s:10:\"\0*\0options\";a:0:{}}i:1;O:38:\"Khill\\Lavacharts\\DataTables\\Cells\\Cell\":4:{s:4:\"\0*\0v\";i:1;s:4:\"\0*\0f\";s:0:\"\";s:4:\"\0*\0p\";N;s:10:\"\0*\0options\";a:0:{}}}}}s:17:\"\0*\0dateTimeFormat\";N;s:8:\"timezone\";O:12:\"DateTimeZone\":2:{s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}s:8:\"\0*\0label\";O:29:\"Khill\\Lavacharts\\Values\\Label\":1:{s:8:\"\0*\0value\";s:10:\"Popularity\";}s:12:\"\0*\0elementId\";N;s:19:\"\0*\0renderableStatus\";b:1;s:37:\"\0Khill\\Lavacharts\\Charts\\GeoChart\0png\";b:0;}}}s:36:\"\0Khill\\Lavacharts\\Volcano\0dashboards\";a:0:{}}s:42:\"\0Khill\\Lavacharts\\Lavacharts\0scriptManager\";O:41:\"Khill\\Lavacharts\\Javascript\\ScriptManager\":1:{s:57:\"\0Khill\\Lavacharts\\Javascript\\ScriptManager\0lavaJsRendered\";b:0;}s:12:\"chartFactory\";O:36:\"Khill\\Lavacharts\\Charts\\ChartFactory\":1:{s:50:\"\0Khill\\Lavacharts\\Charts\\ChartFactory\0chartBuilder\";O:38:\"Khill\\Lavacharts\\Builders\\ChartBuilder\":7:{s:7:\"\0*\0type\";s:8:\"GeoChart\";s:12:\"\0*\0datatable\";r:9;s:10:\"\0*\0options\";a:1:{s:15:\"backgroundColor\";s:7:\"#cad2d3\";}s:12:\"\0*\0pngOutput\";b:0;s:17:\"\0*\0materialOutput\";b:0;s:8:\"\0*\0label\";r:42;s:12:\"\0*\0elementId\";N;}}s:11:\"dashFactory\";O:44:\"Khill\\Lavacharts\\Dashboards\\DashboardFactory\":1:{s:57:\"\0Khill\\Lavacharts\\Dashboards\\DashboardFactory\0dashBuilder\";O:42:\"Khill\\Lavacharts\\Builders\\DashboardBuilder\":4:{s:12:\"\0*\0datatable\";N;s:11:\"\0*\0bindings\";a:0:{}s:8:\"\0*\0label\";N;s:12:\"\0*\0elementId\";N;}}}',1576339081),('luckyduel_cachereset_time','s:1:\"1\";',1576367975),('luckyduel_cacheuserstoday','i:1;',1576339082),('luckyduel_cacheuserstotal','i:10;',1576339255);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cpaurls`
--

DROP TABLE IF EXISTS `cpaurls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cpaurls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cpaurls`
--

LOCK TABLES `cpaurls` WRITE;
/*!40000 ALTER TABLE `cpaurls` DISABLE KEYS */;
/*!40000 ALTER TABLE `cpaurls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (1,'Test question','test answer');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_data`
--

DROP TABLE IF EXISTS `game_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(15) NOT NULL,
  `wheel_chances` int(3) NOT NULL DEFAULT '0',
  `wheel_date` varchar(10) DEFAULT '00-00-0000',
  `scratch_won` int(1) NOT NULL DEFAULT '0',
  `lotto_data_1` varchar(10) DEFAULT NULL,
  `lotto_data_2` varchar(10) DEFAULT NULL,
  `lotto_won` int(1) NOT NULL DEFAULT '0',
  `lotto_date_1` varchar(10) NOT NULL DEFAULT '00-00-0000',
  `lotto_date_2` varchar(10) NOT NULL DEFAULT '00-00-0000',
  `lotto_rewarded` varchar(10) NOT NULL DEFAULT '00-00-0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_data`
--

LOCK TABLES `game_data` WRITE;
/*!40000 ALTER TABLE `game_data` DISABLE KEYS */;
INSERT INTO `game_data` VALUES (1,'5DD6BB123B8A3',1,'21-11-2019',0,NULL,NULL,0,'00-00-0000','00-00-0000','00-00-0000'),(2,'F072364377917',1,'14-12-2019',0,'4933565540',NULL,0,'12-12-2019','00-00-0000','00-00-0000'),(3,'5DD9F95F71624',2,'24-11-2019',0,NULL,NULL,0,'00-00-0000','00-00-0000','00-00-0000'),(4,'5DDD4DAD7AD9F',1,'26-11-2019',0,'3337564060',NULL,0,'26-11-2019','00-00-0000','00-00-0000'),(5,'5DDF1032E959D',1,'02-12-2019',0,NULL,NULL,0,'00-00-0000','00-00-0000','00-00-0000'),(6,'5DECD37472AF9',3,'10-12-2019',0,'2332215112',NULL,0,'08-12-2019','00-00-0000','00-00-0000'),(7,'5DF4FBF629539',1,'14-12-2019',0,NULL,NULL,0,'00-00-0000','00-00-0000','00-00-0000');
/*!40000 ALTER TABLE `game_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_scratcher_config`
--

DROP TABLE IF EXISTS `game_scratcher_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_scratcher_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `front_image` text NOT NULL,
  `icon_image` text NOT NULL,
  `cost` int(11) NOT NULL DEFAULT '0',
  `free` int(1) NOT NULL DEFAULT '1',
  `min_win` int(11) NOT NULL DEFAULT '10',
  `max_win` int(11) NOT NULL DEFAULT '100',
  `cash_win` int(11) NOT NULL DEFAULT '1',
  `difficulty` int(3) NOT NULL DEFAULT '50',
  `bgcolor` varchar(7) NOT NULL DEFAULT '#1493ff',
  `link` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_scratcher_config`
--

LOCK TABLES `game_scratcher_config` WRITE;
/*!40000 ALTER TABLE `game_scratcher_config` DISABLE KEYS */;
INSERT INTO `game_scratcher_config` VALUES (1,'https://ludgyad.luckyduel.com/uploads/1574528341_front.jpg','https://ludgyad.luckyduel.com/uploads/1574256351_icon.png',100,1,10,150,50000,50,'#F8C97A',''),(2,'https://ludgyad.luckyduel.com/uploads/1574529031_front.jpg','https://ludgyad.luckyduel.com/uploads/1574345578_icon.png',20,1,50,250,10000,60,'#428026','');
/*!40000 ALTER TABLE `game_scratcher_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_scratcher_store`
--

DROP TABLE IF EXISTS `game_scratcher_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_scratcher_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(15) NOT NULL,
  `store` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_scratcher_store`
--

LOCK TABLES `game_scratcher_store` WRITE;
/*!40000 ALTER TABLE `game_scratcher_store` DISABLE KEYS */;
INSERT INTO `game_scratcher_store` VALUES (1,'F072364377917','a:0:{}'),(2,'5DD6BB123B8A3','a:1:{i:0;a:2:{s:2:\"id\";i:2;s:8:\"quantity\";i:1;}}'),(3,'5DD9F95F71624','a:1:{i:0;a:2:{s:2:\"id\";i:2;s:8:\"quantity\";i:1;}}'),(4,'5DDD4DAD7AD9F','a:1:{i:0;a:2:{s:2:\"id\";i:2;s:8:\"quantity\";i:1;}}'),(5,'5DDF1032E959D','a:1:{i:0;a:2:{s:2:\"id\";i:1;s:8:\"quantity\";i:1;}}'),(6,'5DECD37472AF9','a:1:{i:0;a:2:{s:2:\"id\";i:2;s:8:\"quantity\";i:1;}}'),(7,'5DEE8A5957135','a:2:{i:0;a:2:{s:2:\"id\";i:1;s:8:\"quantity\";i:1;}i:1;a:2:{s:2:\"id\";i:2;s:8:\"quantity\";i:1;}}'),(8,'5DF243E9C5AF2','a:2:{i:0;a:2:{s:2:\"id\";i:1;s:8:\"quantity\";i:1;}i:1;a:2:{s:2:\"id\";i:2;s:8:\"quantity\";i:1;}}'),(9,'5DF4FBF629539','a:1:{i:0;a:2:{s:2:\"id\";i:1;s:8:\"quantity\";i:1;}}');
/*!40000 ALTER TABLE `game_scratcher_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_wheel`
--

DROP TABLE IF EXISTS `game_wheel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_wheel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,3) NOT NULL,
  `easiness` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_wheel`
--

LOCK TABLES `game_wheel` WRITE;
/*!40000 ALTER TABLE `game_wheel` DISABLE KEYS */;
INSERT INTO `game_wheel` VALUES (17,100.000,0),(18,2.000,5),(19,10.000,4),(20,4.000,5),(21,50.000,1),(22,6.000,3),(23,8.000,4),(24,12.000,3),(25,14.000,3),(26,17.000,3),(27,20.000,2),(28,22.000,2),(29,23.000,2);
/*!40000 ALTER TABLE `game_wheel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaderboard`
--

DROP TABLE IF EXISTS `leaderboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leaderboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL DEFAULT '',
  `userid` varchar(14) NOT NULL,
  `avatar` text NOT NULL,
  `amount_cur` int(11) NOT NULL,
  `amount_prv` int(11) NOT NULL DEFAULT '0',
  `date_cur` varchar(10) NOT NULL,
  `date_prv` varchar(10) NOT NULL DEFAULT '00-00-0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaderboard`
--

LOCK TABLES `leaderboard` WRITE;
/*!40000 ALTER TABLE `leaderboard` DISABLE KEYS */;
INSERT INTO `leaderboard` VALUES (1,'Kegan Coleman','F072364377917','https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=10157072364377917&height=50&width=50&ext=1576848384&hash=AeQWN_gGXZGpqC18',76,0,'20-11-2019','00-00-0000'),(2,'cole','5DD6BB123B8A3','none',82,0,'21-11-2019','00-00-0000'),(3,'Cole Dole','5DD9F95F71624','none',89,0,'24-11-2019','00-00-0000'),(4,'Aaliyanur','5DDD4DAD7AD9F','none',68,0,'26-11-2019','00-00-0000'),(5,'Rao Touseef','5DDF1032E959D','none',99,0,'28-11-2019','00-00-0000'),(6,'ali','5DECD37472AF9','none',87,0,'08-12-2019','00-00-0000'),(7,'Demo1','5DF4FBF629539','none',196,0,'14-12-2019','00-00-0000');
/*!40000 ALTER TABLE `leaderboard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2017_12_17_063101_create_withdrawreqs_table',1),(4,'2017_12_17_114919_create_faqs_table',1),(5,'2017_12_22_060236_cpa',1),(6,'2017_12_22_134032_reward_type',1),(7,'2018_01_06_152451_create_notification_ids_table',2),(8,'2018_02_11_064632_create_misc_table',3),(10,'2018_02_12_062309_create_slider_table',4),(11,'2018_02_15_100756_create_alloffers_table',5),(12,'2018_02_17_091514_create_customoffers_table',6),(13,'2018_03_02_133233_create_cpv_table',7),(14,'2018_03_06_084358_create_cpaurls_table',8),(18,'2018_05_14_082448_create_aid_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misc`
--

DROP TABLE IF EXISTS `misc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `misc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `misc_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `misc`
--

LOCK TABLES `misc` WRITE;
/*!40000 ALTER TABLE `misc` DISABLE KEYS */;
INSERT INTO `misc` VALUES (1,'lotto_winner','4152181814',NULL,NULL),(2,'lotto_draw_date','12-12-2019',NULL,NULL);
/*!40000 ALTER TABLE `misc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_ids`
--

DROP TABLE IF EXISTS `notification_ids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_ids` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_token` text COLLATE utf8mb4_unicode_ci,
  `userinfo` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_ids`
--

LOCK TABLES `notification_ids` WRITE;
/*!40000 ALTER TABLE `notification_ids` DISABLE KEYS */;
INSERT INTO `notification_ids` VALUES (1,'kegan.coleman@icloud.com','fy64PmRKCbY:APA91bGxK105N39fbUjkgDRK27WOsUtbqB2umEThcAektpCyQ4DejDrOlQa3zihgM8z8NcuaZjC6UPk8vaSf8mEdWsuNRN9DlcoqDHPjZRW4dxGwWeX0ROZUL5r23h5Hr6uiAkiFlUvG','osversion=7.0<br>app_version=1.0<br>fingerprint=samsung/zerolteacg/zerolteacg:7.0/NRD90M/G925R7WWU3DRI2:user/release-keys<br>brand=samsung<br>uuid=ffffffff-f632-a291-ffff-ffff9504801a<br>hardware=samsungexynos7420<br>model=SM-G925R7','2019-11-20 21:26:24','2019-12-14 14:57:00',NULL),(2,'dole@cole.com','egnkyE-bJ4E:APA91bHxJuxKF-Yfy8a403DxyQFB1F3yBOOqZRCVrmUfF7hzYxV5VkwdfX05lRV9wph0Z_U3MhkTEpNLjluZIm3lsoi7M0EeUw76s6Fcmd_jR0XXH4uTnDwL9m9e_Z4bSScO7JJnoavq','osversion=7.0<br>app_version=1.0<br>fingerprint=samsung/zerolteacg/zerolteacg:7.0/NRD90M/G925R7WWU3DRI2:user/release-keys<br>brand=samsung<br>uuid=ffffffff-f632-a291-ffff-ffff9504801a<br>hardware=samsungexynos7420<br>model=SM-G925R7','2019-11-22 00:28:02','2019-11-22 00:37:55',NULL),(3,'developer@titancastle.com','ewI8NvvZE0s:APA91bECxHE5NOsVBDM48JwYfCc0R8j2RJQVW-W96dOBPTtGO1ZGg8N-mEPgg9T1FKiYjYL5erZkNbBqeEBMy1VcBxzNGLH8o_YlycoqAfeIXMLjUP3RH1fyUVwiXHlbfQo1wzKS8KJb','osversion=7.0<br>app_version=1.0<br>fingerprint=samsung/zerolteacg/zerolteacg:7.0/NRD90M/G925R7WWU3DRI2:user/release-keys<br>brand=samsung<br>uuid=ffffffff-f632-a291-ffff-ffff9504801a<br>hardware=samsungexynos7420<br>model=SM-G925R7','2019-11-24 11:30:39','2019-11-24 11:31:34',NULL),(4,'aaliya@yahoo.com','e64CZQEV-IY:APA91bFu1p8TP0TxNychPtY1lc4PEQoft6A3qJ-nRZWguhaLVzA3XRYG1Pxka9Fi9p04d_JMJZWOwb350m_OZjpp9Hu9C34AvdxzGgu61pdbJPa4Vv-Q6onj2bbG8zLUtUv7DGhkg7Gc','osversion=7.0<br>app_version=1.0<br>fingerprint=xiaomi/mido/mido:7.0/NRD90M/V11.0.2.0.NCFMIXM:user/release-keys<br>brand=xiaomi<br>uuid=ffffffff-c818-83dc-ffff-fffff54b764f<br>hardware=qcom<br>model=Redmi Note 4','2019-11-27 00:07:09','2019-11-27 00:09:49',NULL),(5,'raotouseefahmad1258@gmail.com','cZY735-58M0:APA91bGTch2_rvkMJtOFbhj24ScLFbQN_iikTuw9lUaSX_vcqCvQkObxl6dIsU1v3HtIuXKdtlkN0kcqYrGiYfKBk2sDfSJ0d3r3rJEWNQjFYVcsl0oMQW6pObiMEGwNmdub0jybtCCV','osversion=7.1.1<br>app_version=1.0<br>fingerprint=OPPO/CPH1723/CPH1723:7.1.1/N6F26Q/1567750220:user/release-keys<br>brand=OPPO<br>uuid=00000000-2e7c-9f59-0000-00001aff37f8<br>hardware=mt6763<br>model=CPH1723','2019-11-28 08:09:22','2019-12-01 20:44:34',NULL),(6,'ali@aa.com','e4ocllfAnUY:APA91bECR_U4rlabjYEmAlTB8etmgHEA9WTrBc0LOg_V8vjOiKCZYLE0YGTkEq6jiqcdl7ZVi3oWEd3AMx_INJay-UIoRvX5hmtS8yw1k_oH6Zj8oauNh648u4aeJ00530Zh3K-LKdBs','app_version=1.0<br>fingerprint=google/sdk_gphone_x86/generic_x86:9/PSR1.180720.075/5124027:user/release-keys<br>model=Android SDK built for x86<br>osversion=9<br>uuid=ffffffff-bf43-71d1-ffff-ffffef05ac4a<br>brand=google<br>hardware=ranchu','2019-12-08 18:41:56','2019-12-10 15:58:21',NULL),(7,'thhtjkhf@jyj.com','fX7N_GJaeSw:APA91bEDUghDtn9oqTUDFNvx_MTQsZuTOdmZYkdMOvfdljGeC4thjAOoR5h6svrcSMKFs35iPW2LLLJgpB18WbXfAL_w9ZhnkvPEHoyliMduyTYz4-7mAn3tLhk1Y5b7oGE8X5g97XMn','info=osversion=7.1.1<br>app_version=1.0<br>fingerprint=google/volantis/flounder:7.1.1/N4F26M/3562722:user/release-keys<br>brand=google<br>uuid=ffffffff-fd00-85f5-0000-0000259e7a1b<br>hardware=flounder<br>model=Nexus 9<br>cc=','2019-12-09 17:54:33','2019-12-09 17:54:33',NULL),(8,'demo@demo.com','ewI8NvvZE0s:APA91bECxHE5NOsVBDM48JwYfCc0R8j2RJQVW-W96dOBPTtGO1ZGg8N-mEPgg9T1FKiYjYL5erZkNbBqeEBMy1VcBxzNGLH8o_YlycoqAfeIXMLjUP3RH1fyUVwiXHlbfQo1wzKS8KJb','osversion=7.0<br>app_version=1.0<br>fingerprint=samsung/zerolteacg/zerolteacg:7.0/NRD90M/G925R7WWU3DRI2:user/release-keys<br>brand=samsung<br>uuid=ffffffff-f632-a291-ffff-ffff9504801a<br>hardware=samsungexynos7420<br>model=SM-G925R7','2019-12-12 13:43:05','2019-12-12 13:45:17',NULL),(9,'demo@demo1.com','fy64PmRKCbY:APA91bGxK105N39fbUjkgDRK27WOsUtbqB2umEThcAektpCyQ4DejDrOlQa3zihgM8z8NcuaZjC6UPk8vaSf8mEdWsuNRN9DlcoqDHPjZRW4dxGwWeX0ROZUL5r23h5Hr6uiAkiFlUvG','osversion=7.0<br>app_version=1.0<br>fingerprint=samsung/zerolteacg/zerolteacg:7.0/NRD90M/G925R7WWU3DRI2:user/release-keys<br>brand=samsung<br>uuid=ffffffff-f632-a291-ffff-ffff9504801a<br>hardware=samsungexynos7420<br>model=SM-G925R7','2019-12-14 15:12:54','2019-12-14 15:18:12',NULL);
/*!40000 ALTER TABLE `notification_ids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_users`
--

DROP TABLE IF EXISTS `online_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(20) NOT NULL DEFAULT 'US',
  `ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_users`
--

LOCK TABLES `online_users` WRITE;
/*!40000 ALTER TABLE `online_users` DISABLE KEYS */;
INSERT INTO `online_users` VALUES (8,'US','172.26.6.15',1576338922);
/*!40000 ALTER TABLE `online_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `points`
--

DROP TABLE IF EXISTS `points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(14) NOT NULL,
  `note` varchar(30) DEFAULT NULL,
  `amount` int(9) NOT NULL DEFAULT '0',
  `date` varchar(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `points`
--

LOCK TABLES `points` WRITE;
/*!40000 ALTER TABLE `points` DISABLE KEYS */;
/*!40000 ALTER TABLE `points` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reward_type`
--

DROP TABLE IF EXISTS `reward_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reward_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_link` text COLLATE utf8mb4_unicode_ci,
  `points` mediumint(9) NOT NULL,
  `descr` text COLLATE utf8mb4_unicode_ci,
  `country` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_coin` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reward_type`
--

LOCK TABLES `reward_type` WRITE;
/*!40000 ALTER TABLE `reward_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `reward_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(14) NOT NULL,
  `is_adearn` int(1) NOT NULL DEFAULT '0',
  `network` varchar(20) DEFAULT NULL,
  `note` varchar(30) DEFAULT NULL,
  `amount` int(9) NOT NULL DEFAULT '0',
  `ip_address` varchar(11) NOT NULL DEFAULT '---',
  `date` varchar(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
INSERT INTO `tokens` VALUES (1,'F072364377917',0,NULL,'scratcher',76,'---','1574256699','2019-11-20 13:31:39'),(2,'F072364377917',0,NULL,'reward',200,'---','1574257242','2019-11-20 13:40:42'),(3,'F072364377917',0,NULL,'scratcher',95,'---','1574353252','2019-11-21 16:20:52'),(4,'F072364377917',0,NULL,'scratcher',93,'---','1574353279','2019-11-21 16:21:19'),(5,'F072364377917',0,NULL,'scratcher',77,'---','1574353352','2019-11-21 16:22:32'),(6,'F072364377917',0,NULL,'scratcher',115,'---','1574353407','2019-11-21 16:23:27'),(7,'F072364377917',0,NULL,'scratcher',48,'---','1574353543','2019-11-21 16:25:43'),(8,'F072364377917',0,NULL,'scratcher',73,'---','1574353602','2019-11-21 16:26:42'),(9,'5DD6BB123B8A3',0,NULL,'scratcher',74,'---','1574353693','2019-11-21 16:28:13'),(10,'5DD6BB123B8A3',0,NULL,'wheel',8,'---','1574354409','2019-11-21 16:40:09'),(11,'F072364377917',0,NULL,'scratcher',67,'---','1574428907','2019-11-22 13:21:47'),(12,'F072364377917',0,NULL,'wheel',14,'---','1574498511','2019-11-23 08:41:51'),(13,'F072364377917',0,NULL,'wheel',2,'---','1574498541','2019-11-23 08:42:21'),(14,'F072364377917',0,NULL,'scratcher',48,'---','1574529886','2019-11-23 17:24:46'),(15,'F072364377917',0,NULL,'scratcher',126,'---','1574530118','2019-11-23 17:28:38'),(16,'F072364377917',0,NULL,'checkin',8,'---','1574566122','2019-11-24 03:28:42'),(17,'5DD9F95F71624',0,NULL,'wheel',17,'---','1574566320','2019-11-24 03:32:00'),(18,'5DD9F95F71624',0,NULL,'scratcher',50,'---','1574566415','2019-11-24 03:33:35'),(19,'5DD9F95F71624',0,NULL,'wheel',22,'---','1574566442','2019-11-24 03:34:02'),(20,'5DDD4DAD7AD9F',0,NULL,'scratcher',64,'---','1574784507','2019-11-26 16:08:27'),(21,'5DDD4DAD7AD9F',0,NULL,'wheel',4,'---','1574784561','2019-11-26 16:09:21'),(22,'5DDF1032E959D',0,NULL,'scratcher',99,'---','1574899788','2019-11-28 00:09:48'),(23,'5DDF1032E959D',0,NULL,'wheel',12,'---','1575252112','2019-12-02 02:01:52'),(24,'5DECD37472AF9',0,NULL,'checkin',3,'---','1575801779','2019-12-08 10:42:59'),(25,'5DECD37472AF9',0,NULL,'wheel',2,'---','1575802013','2019-12-08 10:46:53'),(26,'5DECD37472AF9',0,NULL,'wheel',14,'---','1575802037','2019-12-08 10:47:17'),(27,'5DECD37472AF9',0,NULL,'wheel',12,'---','1575803364','2019-12-08 11:09:24'),(28,'5DECD37472AF9',0,NULL,'scratcher',59,'---','1575806334','2019-12-08 11:58:54'),(29,'5DECD37472AF9',0,NULL,'checkin',7,'---','1575985374','2019-12-10 13:42:54'),(30,'5DECD37472AF9',0,NULL,'wheel',2,'---','1575985405','2019-12-10 13:43:25'),(31,'5DECD37472AF9',0,NULL,'wheel',2,'---','1575986656','2019-12-10 14:04:16'),(32,'5DECD37472AF9',0,NULL,'wheel',6,'---','1575994765','2019-12-10 16:19:25'),(33,'F072364377917',0,NULL,'checkin',1,'---','1576157031','2019-12-12 13:23:51'),(34,'F072364377917',0,NULL,'scratcher',55,'---','1576157096','2019-12-12 13:24:56'),(35,'F072364377917',0,NULL,'scratcher',45,'---','1576163642','2019-12-12 15:14:02'),(36,'F072364377917',0,NULL,'wheel',14,'---','1576163713','2019-12-12 15:15:13'),(37,'F072364377917',0,NULL,'scratcher',68,'---','1576164005','2019-12-12 15:20:05'),(38,'F072364377917',0,NULL,'wheel',6,'---','1576164039','2019-12-12 15:20:39'),(39,'F072364377917',0,NULL,'wheel',2,'---','1576334211','2019-12-14 14:36:51'),(40,'F072364377917',0,NULL,'scratcher',51,'---','1576335469','2019-12-14 14:57:49'),(41,'F072364377917',0,NULL,'scratcher',79,'---','1576335724','2019-12-14 15:02:04'),(42,'5DF4FBF629539',0,NULL,'scratcher',64,'---','1576336400','2019-12-14 15:13:20'),(43,'5DF4FBF629539',0,NULL,'scratcher',112,'---','1576336421','2019-12-14 15:13:41'),(44,'5DF4FBF629539',0,NULL,'wheel',20,'---','1576336581','2019-12-14 15:16:21'),(45,'F072364377917',0,NULL,'scratcher',75,'---','1576338597','2019-12-14 15:49:57'),(46,'F072364377917',0,NULL,'scratcher',56,'---','1576338690','2019-12-14 15:51:30');
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ip` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` mediumint(9) NOT NULL DEFAULT '0',
  `ref_earn` mediumint(9) NOT NULL DEFAULT '0',
  `pending` mediumint(9) NOT NULL DEFAULT '0',
  `available` mediumint(9) NOT NULL DEFAULT '0',
  `c_balance` int(11) NOT NULL DEFAULT '0',
  `c_pending` int(11) NOT NULL DEFAULT '0',
  `c_available` int(11) NOT NULL DEFAULT '0',
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `referred_by` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banned` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refid` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'yes',
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress` int(1) DEFAULT '0',
  `check_in` int(10) NOT NULL DEFAULT '0',
  `ref_state` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `fbp` int(1) NOT NULL DEFAULT '0',
  `twp` int(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vpn` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','none','admin@mintservice.ltd','$2y$10$lvDVPijS7Qv0A6gsk0stHePIy1jsafVczcIwaKYcffDUT3Bzp4VCm',0,0,0,0,0,0,0,'','none',NULL,'5A3D1E1E99DB3','yes',NULL,0,1520837123,'received',0,0,'X0Fsag4KIB1EfL4d6l0oIOkxP6vqkikZkboK2bThJGgNE16o9cp2gra5mqD2',0,'2018-02-01 09:00:46','2019-10-04 05:52:20'),(3,'Kegan Coleman',NULL,'kegan.coleman@icloud.com','$2y$10$aCxRg82/OLOIPe8pg0VBQehZ48JGGuI9SQI/Vcz30EGj.c4BYafRy',214,0,0,214,0,0,0,'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=10157072364377917&height=50&width=50&ext=1576848384&hash=AeQWN_gGXZGpqC18','none',NULL,'F072364377917','yes','us',13,1576243431,'no',0,0,NULL,0,'2019-11-20 21:26:24','2019-12-14 15:51:30'),(4,'cole','167.172.142.15','dole@cole.com','$2y$10$VsCdmrqdgs4SB62a3dMwiuGXVIPQ67FVCAvvJtMzD241vYFJ2o6.K',82,0,0,82,0,0,0,'none','none',NULL,'5DD6BB123B8A3','yes','us',1,0,'no',0,0,NULL,0,'2019-11-22 00:28:02','2019-11-22 00:40:09'),(5,'Cole Dole','167.172.142.15','developer@titancastle.com','$2y$10$LJ5olpYtHLBh7dQZtSLzrOkWmE21E1aS6Ggb1Ud3wZnZ5ys79R3T.',89,0,0,89,0,0,0,'none','none',NULL,'5DD9F95F71624','yes','us',1,0,'no',0,0,NULL,0,'2019-11-24 11:30:39','2019-11-24 11:34:02'),(6,'Aaliyanur','167.172.142.15','aaliya@yahoo.com','$2y$10$LeqOSBntxiKOvrttlXTdW.jGWLTlpU0UarmaZtID0TPh3dJtTuYWO',68,0,0,68,0,0,0,'none','none',NULL,'5DDD4DAD7AD9F','yes','pk',1,0,'no',0,0,NULL,0,'2019-11-27 00:07:09','2019-11-27 00:09:21'),(7,'Rao Touseef','167.172.142.15','raotouseefahmad1258@gmail.com','$2y$10$jw8LkkWSPgAmuek8gJtTIOsEuoipZF3/OwJhW/9WtCNmKn4zewVqG',111,0,0,111,0,0,0,'none','none',NULL,'5DDF1032E959D','yes','pk',0,0,'no',0,0,NULL,0,'2019-11-28 08:09:23','2019-12-02 10:01:52'),(8,'ali','167.172.142.15','ali@aa.com','$2y$10$10iOpipE6rs4f0bMgYu8heKFmsE.mjru4OgBPRuCx3SoG55Wn.NUe',107,0,0,107,0,0,0,'none','none',NULL,'5DECD37472AF9','yes','pk',1,1576071774,'no',0,0,NULL,0,'2019-12-08 18:41:56','2019-12-10 16:19:25'),(9,'jhjhhm gjg','172.26.6.15','thhtjkhf@jyj.com','$2y$10$wP1cqV/BY8Eqvq7ub1cSveEvVu277xDQBmik4NWF0OVmhtegFqcN.',0,0,0,0,0,0,0,'none','none',NULL,'5DEE8A5957135','yes',NULL,0,0,'no',0,0,NULL,0,'2019-12-09 17:54:33','2019-12-09 17:54:33'),(10,'Demo','172.26.6.15','demo@demo.com','$2y$10$5CCGhMHQ8cXcqTIkxpgS9OWAQcJMabufs6zBHLAhs0JbXUw9EgdTa',0,0,0,0,0,0,0,'none','none',NULL,'5DF243E9C5AF2','yes','us',0,0,'no',0,0,NULL,0,'2019-12-12 13:43:05','2019-12-12 13:43:05'),(11,'Demo1','172.26.6.15','demo@demo1.com','$2y$10$mP6nEZED0daIcGZYwdawhu6lXdRJ0LHUFtIRREyZr7HdlUUNOnmYy',96,0,0,96,0,0,0,'none','none',NULL,'5DF4FBF629539','yes','us',1,0,'no',0,0,NULL,0,'2019-12-14 15:12:54','2019-12-14 15:16:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdrawreqs`
--

DROP TABLE IF EXISTS `withdrawreqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdrawreqs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` mediumint(9) NOT NULL,
  `is_cash` int(1) NOT NULL DEFAULT '0',
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdrawreqs`
--

LOCK TABLES `withdrawreqs` WRITE;
/*!40000 ALTER TABLE `withdrawreqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdrawreqs` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-15 15:39:35
