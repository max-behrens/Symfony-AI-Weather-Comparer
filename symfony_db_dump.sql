-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: symfony_db
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `calculations`
--

DROP TABLE IF EXISTS `calculations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calculations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `calculations` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ai_response` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calculations`
--

LOCK TABLES `calculations` WRITE;
/*!40000 ALTER TABLE `calculations` DISABLE KEYS */;
INSERT INTO `calculations` VALUES (3,'test1','test2',''),(4,'Temperature Volatility: 6.92, Humidity','Temperature: undefined\nHumidity: undefined\nPressure: undefined',''),(5,'Temperature Volatility: 2.24, Humidity Volatility: -5.54, Pressure Volatility: -0.29','Temperature: undefined\nHumidity: undefined\nPressure: undefined',''),(6,'Temperature Volatility: 6.92, Humidity Volatility: -7.81, Pressure Volatility: -0.2','Temperature: undefined\nHumidity: undefined\nPressure: undefined',''),(7,'Temperature Volatility: 6.92, Humidity Volatility: -7.81, Pressure Volatility: -0.2','Temperature: undefined\nHumidity: undefined\nPressure: undefined','London'),(8,'Temperature Volatility: 6.92, Humidity Volatility: -7.81, Pressure Volatility: -0.2','Temperature: undefined\nHumidity: undefined\nPressure: undefined','Londo'),(9,'Temperature Volatility: 35.5, Humidity Volatility: 28.44, Pressure Volatility: -0.37','Temperature: undefined\nHumidity: undefined\nPressure: undefined','tokyo'),(10,'Temperature Volatility: 2.24, Humidity Volatility: -5.54, Pressure Volatility: -0.29','Temperature: undefined\nHumidity: undefined\nPressure: undefined','Liverpool'),(11,'test1','test2','test3'),(12,'Temperature Volatility: 6.92, Humidity Volatility: -7.81, Pressure Volatility: -0.2','Temperature: undefined\nHumidity: undefined\nPressure: undefined','London'),(13,'Temperature Volatility: 6.92, Humidity Volatility: -7.81, Pressure Volatility: -0.2','Temperature: undefined\nHumidity: undefined\nPressure: undefined','London'),(14,'Temperature Volatility: -0.48, Humidity Volatility: 0.72, Pressure Volatility: -0.36','Temperature: undefined\nHumidity: undefined\nPressure: undefined','Glasgow'),(15,'Temperature Volatility: 35.5, Humidity Volatility: 28.44, Pressure Volatility: -0.37','Temperature: undefined\nHumidity: undefined\nPressure: undefined','tokyo'),(16,'Temperature Volatility: -23.18, Humidity Volatility: 13.57, Pressure Volatility: -0.17','Temperature: undefined\nHumidity: undefined\nPressure: undefined','Bremen 2'),(17,'Temperature Volatility: 1.99, Humidity Volatility: 6.52, Pressure Volatility: -0.05','Temperature: undefined\nHumidity: undefined\nPressure: undefined','Kolkata'),(18,'Temperature Volatility: -4.3, Humidity Volatility: -2.5, Pressure Volatility: -0.07','Temperature: undefined\r\nHumidity: undefined\r\nPressure: undefined','London'),(19,'','',''),(20,'','',''),(21,'','',''),(22,'','',''),(23,'','',''),(24,'','',''),(25,'Temperature Changes: -12.64,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 20.27,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.4,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08','Temperature Changes: -12.64,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 20.27,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.4,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08','Temperature Changes: -12.64,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 20.27,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.4,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08'),(26,'','',''),(27,'Temperature Changes: -12.64,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 20.27,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.4,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08','',''),(28,'Temperature Changes: -12.64,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 20.27,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.4,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08','',''),(29,'Temperature Changes: -36.66,15.76,48.12,60.22\nAverage Temperature Changes: 31.03\nHumidity Changes: -14.29,133.33,-44.05,27.66\nAverage Humidity Changes: 29.24\nPressure Changes: 1.18,-0.19,0.39,-0.58\nAverage Pressure Changes: -0.1','',''),(30,'Temperature Changes: -36.66,15.76,48.12,60.22\nAverage Temperature Changes: 31.03\nHumidity Changes: -14.29,133.33,-44.05,27.66\nAverage Humidity Changes: 29.24\nPressure Changes: 1.18,-0.19,0.39,-0.58\nAverage Pressure Changes: -0.1','','tokyo'),(31,'Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','N/A'),(32,'Temperature Changes: -11.68,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 18.67,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.4,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08','','Liverpool'),(33,'Temperature Changes: -36.66,15.76,48.12,60.22\nAverage Temperature Changes: 31.03\nHumidity Changes: -16.28,133.33,-44.05,27.66\nAverage Humidity Changes: 29.24\nPressure Changes: 1.18,-0.19,0.39,-0.58\nAverage Pressure Changes: -0.1','','tokyo'),(34,'Temperature Changes: -9.55,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 17.11,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.4,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08','','Liverpool'),(35,'Temperature Changes: -11.08,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 17.11,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.3,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08','','Liverpool'),(36,'Temperature Changes: -11.08,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 17.11,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.3,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08','','Liverpool'),(37,'Temperature Changes: -11.16,-3.43,16.55,-53.85\nAverage Temperature Changes: -10.18\nHumidity Changes: 14.1,-5.62,-15.48,30.99\nAverage Humidity Changes: 2.47\nPressure Changes: 0.3,-0.3,-0.3,0.3\nAverage Pressure Changes: -0.08','','Liverpool'),(38,'Temperature Changes: 39.86,-19.88,5.62,-5.02\nAverage Temperature Changes: -4.82\nHumidity Changes: 0,0,3.75,6.02\nAverage Humidity Changes: 2.44\nPressure Changes: 0,-0.49,-0.69,-0.7\nAverage Pressure Changes: -0.47','','Bremen'),(39,'Temperature Changes: -19.55,43.17,20.45,24.91\nAverage Temperature Changes: 22.13\nHumidity Changes: -12.5,80,-36.51,70\nAverage Humidity Changes: 28.37\nPressure Changes: 1.18,-0.39,0.49,-0.68\nAverage Pressure Changes: -0.15','','tokyo'),(40,'Temperature Changes: -15.03,1.67,21.01,-52.62\nAverage Temperature Changes: -7.49\nHumidity Changes: 8.33,-5.49,-17.44,18.31\nAverage Humidity Changes: -1.16\nPressure Changes: 0.3,-0.3,-0.2,0.3\nAverage Pressure Changes: -0.05','','Liverpool'),(41,'Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','N/A'),(42,'Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','N/A'),(43,'Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','N/A'),(44,'test2','test2','test2'),(45,'Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','','N/A'),(46,'Temperature Changes: N/A\nAverage Temperature Changes: N/A\nHumidity Changes: N/A\nAverage Humidity Changes: N/A\nPressure Changes: N/A\nAverage Pressure Changes: N/A','','N/A'),(47,'Temperature Changes: -8.92,5.57,8.98,-36.92\nAverage Temperature Changes: -5.59\nHumidity Changes: 2.74,1.33,7.89,-1.22\nAverage Humidity Changes: 2\nPressure Changes: 0,-0.59,-0.3,0\nAverage Pressure Changes: -0.22','','London'),(48,'test3','test3','test3'),(50,'Temperature Changes: -16.89,-50.55,-33.27,27.63\nAverage Temperature Changes: -14.05\nHumidity Changes: 8.57,5.26,-13.75,10.14\nAverage Humidity Changes: 0.41\nPressure Changes: -0.1,0.7,-0.4,0.2\nAverage Pressure Changes: 0.13','','Liverpool'),(51,'test1','test1','test1'),(53,'test1','test1','twstw'),(56,'Temperature Changes: -57.03,-33.87,44.21,-41.85\nAverage Temperature Changes: -7.88\nHumidity Changes: 2.94,7.14,8,2.47\nAverage Humidity Changes: 4.4\nPressure Changes: 0.8,-0.49,0,0.1\nAverage Pressure Changes: -0.1','Temperature Explanation: \\nThe temperature in Liverpool has been fluctuating over the past few days. The temperature changes recorded were -57.03, -33.87, 44.21, and -41.85. These values represent the relative rate of change in temperature between each forecasted day. The average temperature change over this period is -7.88 units. Despite the fluctuations, it indicates a significant swing in temperature over the analyzed days.\\n\\nHumidity:\\nThe humidity levels in Liverpool have also shown variability in recent days. The humidity changes recorded were 2.94, 7.14, 8, and 2.47. These numbers represent the relative rate of change in humidity between each forecasted day. The average humidity change over this period is 4.4 units. This suggests fluctuations in moisture levels in the air during the analyzed days.\\n\\nPressure:\\nThe pressure readings in Liverpool have experienced some shifts as well. The pressure changes recorded were 0.8, -0.49, 0, and 0.1. These values reflect the relative rate of change in pressure between each forecasted day. The average pressure change over this period is -0.1 units. The fluctuations in pressure values indicate alterations in atmospheric conditions over the specified days.\",\nHumidity Explanation: \\nThe humidity levels in Liverpool have also shown variability in recent days. The humidity changes recorded were 2.94, 7.14, 8, and 2.47. These numbers represent the relative rate of change in humidity between each forecasted day. The average humidity change over this period is 4.4 units. This suggests fluctuations in moisture levels in the air during the analyzed days.\\n\\nPressure:\\nThe pressure readings in Liverpool have experienced some shifts as well. The pressure changes recorded were 0.8, -0.49, 0, and 0.1. These values reflect the relative rate of change in pressure between each forecasted day. The average pressure change over this period is -0.1 units. The fluctuations in pressure values indicate alterations in atmospheric conditions over the specified days.\",\nPressure Explanation: \\nThe pressure readings in Liverpool have experienced some shifts as well. The pressure changes recorded were 0.8, -0.49, 0, and 0.1. These values reflect the relative rate of change in pressure between each forecasted day. The average pressure change over this period is -0.1 units. The fluctuations in pressure values indicate alterations in atmospheric conditions over the specified days.\",','Liverpool'),(57,'Temperature Changes: -60.82,-33.87,44.21,-41.85\nAverage Temperature Changes: -7.88\nHumidity Changes: 6.06,7.14,8,2.47\nAverage Humidity Changes: 4.4\nPressure Changes: 0.8,-0.49,0,0.1\nAverage Pressure Changes: -0.1','Temperature Explanation: \\nThe temperature in Liverpool has been fluctuating significantly over the past few days. The temperature changes ranged from a decrease of 60.82 units to an increase of 44.21 units relative to the previous days. The average temperature change over this period was a decrease of 7.88 units. These values are not in Celsius but represent the relative rate of change between each forecasted day.\\n\\nHumidity:\\nThe humidity levels in Liverpool have also shown variations in recent days. The humidity changes ranged from an increase of 6.06 units to 8 units relative to the previous days. The average humidity change over this period was 4.4 units.\\n\\nPressure:\\nThe atmospheric pressure in Liverpool exhibited some fluctuations as well. The pressure changes ranged from an increase of 0.8 units to a decrease of 0.49 units relative to the previous days. The average pressure change over this period was a decrease of 0.1 units.\",\nHumidity Explanation: \\nThe humidity levels in Liverpool have also shown variations in recent days. The humidity changes ranged from an increase of 6.06 units to 8 units relative to the previous days. The average humidity change over this period was 4.4 units.\\n\\nPressure:\\nThe atmospheric pressure in Liverpool exhibited some fluctuations as well. The pressure changes ranged from an increase of 0.8 units to a decrease of 0.49 units relative to the previous days. The average pressure change over this period was a decrease of 0.1 units.\",\nPressure Explanation: \\nThe atmospheric pressure in Liverpool exhibited some fluctuations as well. The pressure changes ranged from an increase of 0.8 units to a decrease of 0.49 units relative to the previous days. The average pressure change over this period was a decrease of 0.1 units.\",','Liverpool'),(58,'Temperature Changes: -52.22,-64.72,145.86,7.34\nAverage Temperature Changes: 22.12\nHumidity Changes: 16.88,3.33,-11.83,14.63\nAverage Humidity Changes: 1.53\nPressure Changes: -0.1,-0.2,0.1,0.4\nAverage Pressure Changes: 0.08','Temperature Explanation: \\nThe temperature in Bremen has been fluctuating significantly over the past few days. The temperature changes have ranged from a decrease of 52.22 relative units to an increase of 145.86 relative units. The average temperature change over this period is 22.12 relative units. It seems like there have been both drastic drops and substantial increases in temperature within these days.\\n\\nHumidity:\\nThe humidity levels in Bremen have also shown fluctuations in the recent days. The changes in humidity range from a decrease of 11.83 relative units to an increase of 16.88 relative units. On average, the humidity change is around 1.53 relative units.\\n\\nPressure:\\nThe atmospheric pressure in Bremen has experienced variations in the past few days. The pressure changes have been between a decrease of 0.2 relative units to an increase of 0.4 relative units. The average pressure change for this period is 0.08 relative units. This indicates that the atmospheric pressure has been shifting slightly within the observed timeframe.\",\nHumidity Explanation: \\nThe humidity levels in Bremen have also shown fluctuations in the recent days. The changes in humidity range from a decrease of 11.83 relative units to an increase of 16.88 relative units. On average, the humidity change is around 1.53 relative units.\\n\\nPressure:\\nThe atmospheric pressure in Bremen has experienced variations in the past few days. The pressure changes have been between a decrease of 0.2 relative units to an increase of 0.4 relative units. The average pressure change for this period is 0.08 relative units. This indicates that the atmospheric pressure has been shifting slightly within the observed timeframe.\",\nPressure Explanation: \\nThe atmospheric pressure in Bremen has experienced variations in the past few days. The pressure changes have been between a decrease of 0.2 relative units to an increase of 0.4 relative units. The average pressure change for this period is 0.08 relative units. This indicates that the atmospheric pressure has been shifting slightly within the observed timeframe.\",','Bremen');
/*!40000 ALTER TABLE `calculations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20250206170357','2025-02-06 17:04:15',107),('DoctrineMigrations\\Version20250206173322','2025-02-06 17:33:38',74),('DoctrineMigrations\\Version20250206183233','2025-02-06 18:37:58',126),('DoctrineMigrations\\Version20250206191533','2025-02-06 19:16:06',75),('DoctrineMigrations\\Version20250206191630','2025-02-06 19:16:52',73),('DoctrineMigrations\\Version20250208120003','2025-02-08 12:01:02',255),('DoctrineMigrations\\Version20250208123900','2025-02-08 12:39:41',84);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-09 22:39:15
