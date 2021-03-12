-- MySQL dump 10.13  Distrib 8.0.23, for osx10.16 (x86_64)
--
-- Host: 127.0.0.1    Database: muz
-- ------------------------------------------------------
-- Server version	8.0.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `user_photos`
--

DROP TABLE IF EXISTS `user_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6D24FBE4A76ED395` (`user_id`),
  CONSTRAINT `FK_6D24FBE4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_photos`
--

LOCK TABLES `user_photos` WRITE;
/*!40000 ALTER TABLE `user_photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_swipe`
--

DROP TABLE IF EXISTS `user_swipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_swipe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `referral_id` int NOT NULL,
  `likes` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_399B12F1A76ED395` (`user_id`),
  KEY `IDX_399B12F13CCAA4B7` (`referral_id`),
  CONSTRAINT `FK_399B12F13CCAA4B7` FOREIGN KEY (`referral_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_399B12F1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_swipe`
--

LOCK TABLES `user_swipe` WRITE;
/*!40000 ALTER TABLE `user_swipe` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_swipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `api_token` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('M','F','O') COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` int NOT NULL,
  `preferred_number` int NOT NULL,
  `latitude` decimal(10,0) NOT NULL,
  `longitude` decimal(10,0) NOT NULL,
  `like_count` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E97BA2F5EB` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'samson_ms_kuphal@swaniawski.net','nZctwDPGwH','Ms. Samson Kuphal','452ffb47f013de753c3c','M',78,1,-69,-124,5),(2,'bradly_iv_bruen@gulgowski.biz','N4tJTcbnFq','Bradly Bruen IV','8c3ef9f1b633e6558d5b','F',40,8,-46,108,0),(3,'sydneeweissnat@mann.biz','QL2PYiEpYw','Sydnee Weissnat','900c065938c7a4885bf1','F',39,1,-9,49,0),(4,'korey_harris@rennersmitham.org','Od6CGYODUQ','Korey Harris','240e0474e6195bf58051','M',70,1,-10,133,0),(5,'mr_jamaal_dickens@fahey.name','gLHlH6N8Wh','Mr. Jamaal Dickens','e8e3702ff1df9c7794a4','F',43,4,40,-75,0),(6,'schultz_birdie@watsica.com','9ojGTPC8By','Birdie Schultz','61edfa34ef1ea20e2f31','M',58,1,-20,102,0),(7,'gavin_hansen_miss@sanford.net','XZGP6gk9Nv','Miss Gavin Hansen','60307b702d2569793b58','F',21,1,-47,-36,9),(8,'elisha_predovic@labadie.com','VBtJMQbel5','Elisha Predovic','0eb9fd58fd2cca1614bc','F',93,1,88,-11,7),(9,'stanton_carmel_mrs@dietrich.biz','pXg6WGA9z7','Mrs. Carmel Stanton','2da0cef8c7f0cfbcc859','F',89,1,-75,-173,6),(10,'hortenseconroy@waters.net','ULCSxhqG5S','Hortense Conroy','ebf077592d1f3e25d5fa','F',50,8,-62,48,0),(11,'jaylan_steuber_mrs@orn.com','c5ZwdM3RK7','Mrs. Jaylan Steuber','791a7a2d0f78a7ff8f3b','M',80,3,61,112,0),(12,'lockman_brittany@williamson.info','ErGsSAbEdn','Brittany Lockman','ee6da9fa617385a706f5','M',78,6,81,136,0),(13,'champlinrowena@thiel.net','hcqXEn5fIh','Rowena Champlin','3990995573fd6db5d238','M',65,4,-47,-68,0),(14,'purdy_nellie_miss@ankunding.org','892m2Uzq5u','Miss Nellie Purdy','b24122d6e31bba79ae17','M',32,6,-75,-179,0),(15,'missmrazdonato@stracke.net','TfuFzzYaC4','Miss Donato Mraz','983e47966d5f63780b3c','M',78,8,4,116,0),(16,'gutkowski_veronica_mrs@kassulke.net','ZYOcOceGMu','Mrs. Veronica Gutkowski','49eade94d9d770e0df80','F',34,10,-5,111,0),(17,'sandrahudson@kuphalschoen.info','U0cO2emWIo','Sandra Hudson','58b4eb215def13e43a97','M',71,7,-27,28,0),(18,'mrs_zaria_quitzon@lockman.com','UlV6trwdlt','Mrs. Zaria Quitzon','23d413f0d960edaad134','F',60,7,-86,20,0),(19,'dianadrwillms@hagenes.net','cFhS8hfZu6','Dr. Diana Willms','22ba7d02ef301140bdea','F',24,4,8,-159,0),(20,'dietrich_monica@miller.com','djlEVgNPPg','Monica Dietrich','ecd09ce3432f6e295e72','F',56,9,21,-49,0),(21,'lavern_schoen@pfannerstill.net','c1iQoCOyBL','Lavern Schoen','eae64280134150eaaca7','M',30,4,-52,-91,0),(22,'adalberto_schinner@marquardt.biz','nDBVJyP0xG','Adalberto Schinner','432e5c7ccf060f92a6b7','F',77,9,-33,-101,0);
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

-- Dump completed on 2021-03-11 19:04:57
