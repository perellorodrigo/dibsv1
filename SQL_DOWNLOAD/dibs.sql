-- MySQL dump 10.13  Distrib 5.5.57, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: c9
-- ------------------------------------------------------
-- Server version	5.5.57-0ubuntu0.14.04.1

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
-- Current Database: `c9`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `c9` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `c9`;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (5,'Sofa','2019-01-10 11:35:35','2019-01-10 11:35:35'),(6,'Fridge','2019-01-10 10:36:45','2019-01-10 10:36:45'),(7,'Washer','2019-01-10 17:59:43','2019-01-10 17:59:43'),(8,'Dining Table','2019-02-19 00:13:27','2019-02-19 00:13:27'),(9,'Coffee Tables','2019-02-19 00:45:00','2019-02-19 00:45:00'),(10,'Dining Chairs','2019-02-19 00:45:29','2019-02-19 00:45:29'),(11,'Desks','2019-02-19 00:45:47','2019-02-19 00:45:47'),(12,'Dressers & Drawers','2019-02-19 00:46:08','2019-02-19 00:46:08');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imageurl` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `lat` double(10,6) NOT NULL,
  `lng` double(10,6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `owner_id` int(10) unsigned DEFAULT NULL,
  `dibs_caller_id` int(10) unsigned DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `on_street` tinyint(1) NOT NULL DEFAULT '1',
  `pickup_instructions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `items_category_id_foreign` (`category_id`),
  KEY `items_owner_id_foreign` (`owner_id`),
  KEY `items_dibs_caller_id_foreign` (`dibs_caller_id`),
  CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `items_dibs_caller_id_foreign` FOREIGN KEY (`dibs_caller_id`) REFERENCES `users` (`id`),
  CONSTRAINT `items_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (20,'Good condition armchair','Almost new couch','photos/armchair.jfif',5,-33.950820,151.138800,'2018-12-12 07:04:08','2019-02-19 03:45:51',2,NULL,0,1,NULL),(21,'Nice couch','Some scratches but looks alright','photos/goodcouch.jpeg',5,-33.893562,151.261088,'2018-12-12 07:10:08','2019-02-19 01:59:08',5,NULL,1,1,NULL),(22,'Fridge','A nice fridge','photos/JH1kIvhkE5NK4gvzFZnyot2h6W7Ay5n9CPq9n0cZ.webp',6,-33.885687,151.200621,'2018-12-13 04:30:39','2019-02-18 23:49:21',1,NULL,1,1,NULL),(23,'Good condition washing machine','Only hot water not working.','photos/XbQpKLaKIaTvGRdKOSOwpypO45C68qSsxbijtqGX.jpeg',7,-33.874662,151.180617,'2018-12-17 02:05:06','2019-02-19 00:23:22',4,NULL,1,1,'82 Dudley St, Coogee NSW 2034, Australia. Call me if need help: 0448 555 222'),(43,'Old fridge for free','Still works','photos/D9Gw6NWjD7HRGEfNHPmQaGDYBt8pLyKnuyKcLWgU.jpeg',6,-33.925053,151.252811,'2019-01-16 10:41:30','2019-02-19 00:23:05',1,NULL,1,1,'Get from 28 Bay Street Coogee'),(44,'Dining Table with 8 Chairs','Large 8 seater Dining table 2,2240mm long x 1,210mm wide x 870mm high with 8 timber chairs covers with yellow fabric.','photos/uOtTo7sayx8SKq9tmXY8uiP2mm2pw2u2nsT52Cx2.png',8,-33.880730,151.190970,'2019-02-19 00:18:39','2019-02-19 01:52:22',3,NULL,1,1,'Pickup from AIT Campus'),(45,'Large White Chest of Drawers','Large chest of drawers, originally an IKEA buy a couple of years ago. Generally in very good condition.','photos/dguh6iqrAnFqzdiybeWltH4f2XKih2hFqGYFDQAV.png',12,-33.894943,151.186516,'2019-02-19 00:51:42','2019-02-19 02:00:30',5,NULL,1,1,NULL),(46,'Office/study desk','Solid office/study desk. Simple, practical design, good quality, reasonable condition. White with grey and silver trim. 2 drawers, hole in top for cables. 150cms wide, 75cms deep, 75cms high.','photos/NP5R8bD9oOaTlGwKf0H9ohSIpjEJQa15tooFZ3G1.png',11,-33.886589,151.179475,'2019-02-19 00:53:24','2019-02-19 00:53:24',5,NULL,1,1,NULL),(47,'Glass dining room table','some description','photos/un45ozbfOKbbOYnwu8jUu7ZxNl4WLlZBSa24sGgr.png',8,-33.881775,151.195234,'2019-02-19 03:44:42','2019-02-19 03:47:27',2,NULL,1,1,'null');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `receiver_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,2,23,'Hello, when can I pickup this item?','2019-01-18 23:23:50','2019-01-18 23:23:50'),(2,2,1,23,'Anytime today! My address is 85 coogee bay road. Let me know when you arrive!','2019-01-18 23:29:21','2019-01-18 23:29:21'),(16,3,2,47,'hi, when can i pick it up?','2019-02-19 03:45:18','2019-02-19 03:45:18');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (7,'2014_10_12_000000_create_users_table',1),(8,'2014_10_12_100000_create_password_resets_table',1),(9,'2018_12_10_221054_create_categories_table',1),(12,'2018_12_10_222140_create_items_table',2),(14,'2018_12_16_013816_add_ratings_to_user_table',3),(15,'2018_12_16_015307_add_extrafields_to_items_table',4),(17,'2019_01_18_212708_create_messages_table',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `positive_ratings` int(11) NOT NULL DEFAULT '0',
  `negative_ratings` int(11) NOT NULL DEFAULT '0',
  `approval_rating` double(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Rodrigo','rodrigo_perello@hotmail.com',NULL,'$2y$10$usAAnQo3HdVN0nN90PoB8uYbCB1Wi55tjGwaGfr.l1.GKc/NGZyky','hlqTs9KJf2ENNuWHvnFtIiHQ9CLCEgBPINdfkysPFfUE2YYgzQ8QM214RVbU','2018-12-10 22:22:39','2019-02-18 03:28:27',0,0,0.00),(2,'Rodrigo Perello','6696@ait.nsw.edu.au',NULL,'$2y$10$mYlmkSnb/.FIpEyApnsZcuHz6/M3E7PnxznCT2oDYBcsqTSdS1TAy','zMvu2bnbrXVAXuF64GE3V0VAC3azcfmLRUtGacPatvy22JOVNrHjT9g1jhYX','2018-12-16 02:36:04','2018-12-16 02:36:04',0,0,0.00),(3,'Eric Kalisz','eric@gmail.com',NULL,'$2y$10$Qol0XJ1Hk65tY0m1bGLXoePiscZXxLREZarSJRGCgroapP70hf.ti','ssnLEopPMjVrEghTludE2gTkLZwFkzTAncZRhCOuJBIM4LccAVSL4DI8ApoU','2019-01-30 00:54:20','2019-01-30 00:54:20',0,0,0.00),(4,'John  Doe','john@gmail.com',NULL,'$2y$10$rnHFCEefIO/6ZiwgDori7uYtw.KswiqW/a.ekyKuCymzhqPPjABBq','TEC6fmW5nCVkFT9vVCH7MybZ7ERCk5kst0Sv6nll8QiE3XBbYSAIV4JrkdQW','2019-02-19 00:10:00','2019-02-19 00:10:00',0,0,0.00),(5,'Geoff','geoff@gmail.com',NULL,'$2y$10$smTGSgHAGmXNgHGiFDkvnuxqiBlXzItj5myIGO.bmujl3AN.gNEF6','jhjPg7oPxeWozry164ZhPu34lcAuj5TnMm0JlVA7JfPwd6aoQBjHtfWYz8vo','2019-02-19 00:10:32','2019-02-19 00:10:32',0,0,0.00);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-19  4:18:27
