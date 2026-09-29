-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: db_sme
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `alerts_detect`
--

DROP TABLE IF EXISTS `alerts_detect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alerts_detect` (
  `id_alert` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_profile` bigint unsigned NOT NULL,
  `alert_type` varchar(100) NOT NULL,
  `saverity` enum('Low','Medium','High','Critical') NOT NULL,
  `message` text NOT NULL,
  `is_resolved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_alert`),
  KEY `alerts_detect_sme_profiles_FK` (`id_profile`),
  CONSTRAINT `alerts_detect_sme_profiles_FK` FOREIGN KEY (`id_profile`) REFERENCES `sme_profiles` (`id_profile`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts_detect`
--

LOCK TABLES `alerts_detect` WRITE;
/*!40000 ALTER TABLE `alerts_detect` DISABLE KEYS */;
/*!40000 ALTER TABLE `alerts_detect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_categories`
--

DROP TABLE IF EXISTS `business_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_categories` (
  `id_category` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id_category`),
  UNIQUE KEY `business_categories_unique` (`category_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_categories`
--

LOCK TABLES `business_categories` WRITE;
/*!40000 ALTER TABLE `business_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `business_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collaboration_rooms`
--

DROP TABLE IF EXISTS `collaboration_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collaboration_rooms` (
  `id_room` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_match` bigint unsigned NOT NULL,
  `room_status` enum('Active','Archived') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_room`),
  KEY `collaboration_rooms_match_requests_FK` (`id_match`),
  CONSTRAINT `collaboration_rooms_match_requests_FK` FOREIGN KEY (`id_match`) REFERENCES `match_requests` (`id_match`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collaboration_rooms`
--

LOCK TABLES `collaboration_rooms` WRITE;
/*!40000 ALTER TABLE `collaboration_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `collaboration_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `connection_listings`
--

DROP TABLE IF EXISTS `connection_listings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `connection_listings` (
  `id_listing` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `id_profile` bigint unsigned NOT NULL,
  `type` enum('Mentor','Supplier','B2B_Partner','Investor') NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Open','Closed','Draft') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Open',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_listing`),
  KEY `connection_listings_users_FK` (`id_user`),
  KEY `connection_listings_sme_profiles_FK` (`id_profile`),
  CONSTRAINT `connection_listings_sme_profiles_FK` FOREIGN KEY (`id_profile`) REFERENCES `sme_profiles` (`id_profile`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `connection_listings_users_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `connection_listings`
--

LOCK TABLES `connection_listings` WRITE;
/*!40000 ALTER TABLE `connection_listings` DISABLE KEYS */;
/*!40000 ALTER TABLE `connection_listings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostic_assessments`
--

DROP TABLE IF EXISTS `diagnostic_assessments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagnostic_assessments` (
  `id_assessment` int NOT NULL AUTO_INCREMENT,
  `id_profile` bigint unsigned NOT NULL,
  `overall_score` decimal(5,2) DEFAULT NULL,
  `health_status` enum('Healthy','At Risk','Critical') DEFAULT NULL,
  `assessment_date` timestamp NOT NULL,
  PRIMARY KEY (`id_assessment`),
  KEY `diagnostic_assessments_sme_profiles_FK` (`id_profile`),
  CONSTRAINT `diagnostic_assessments_sme_profiles_FK` FOREIGN KEY (`id_profile`) REFERENCES `sme_profiles` (`id_profile`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostic_assessments`
--

LOCK TABLES `diagnostic_assessments` WRITE;
/*!40000 ALTER TABLE `diagnostic_assessments` DISABLE KEYS */;
/*!40000 ALTER TABLE `diagnostic_assessments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostic_frameworks`
--

DROP TABLE IF EXISTS `diagnostic_frameworks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagnostic_frameworks` (
  `id_framework` int NOT NULL AUTO_INCREMENT,
  `parameter_key` varchar(100) NOT NULL,
  `title` varchar(150) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `benchmark_value` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id_framework`),
  UNIQUE KEY `diagnostic_frameworks_unique` (`parameter_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostic_frameworks`
--

LOCK TABLES `diagnostic_frameworks` WRITE;
/*!40000 ALTER TABLE `diagnostic_frameworks` DISABLE KEYS */;
/*!40000 ALTER TABLE `diagnostic_frameworks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostic_results`
--

DROP TABLE IF EXISTS `diagnostic_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagnostic_results` (
  `id_result` int NOT NULL AUTO_INCREMENT,
  `id_assessment` int NOT NULL,
  `id_framework` int NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `finding_notes` text,
  `action_recommendation` text,
  PRIMARY KEY (`id_result`),
  KEY `diagnostic_results_diagnostic_assessments_FK` (`id_assessment`),
  KEY `diagnostic_results_diagnostic_frameworks_FK` (`id_framework`),
  CONSTRAINT `diagnostic_results_diagnostic_assessments_FK` FOREIGN KEY (`id_assessment`) REFERENCES `diagnostic_assessments` (`id_assessment`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `diagnostic_results_diagnostic_frameworks_FK` FOREIGN KEY (`id_framework`) REFERENCES `diagnostic_frameworks` (`id_framework`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostic_results`
--

LOCK TABLES `diagnostic_results` WRITE;
/*!40000 ALTER TABLE `diagnostic_results` DISABLE KEYS */;
/*!40000 ALTER TABLE `diagnostic_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `market_indicators`
--

DROP TABLE IF EXISTS `market_indicators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `market_indicators` (
  `id_indicator` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_category` bigint unsigned NOT NULL,
  `indicator_name` varchar(100) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `recorded_at` timestamp NOT NULL,
  PRIMARY KEY (`id_indicator`),
  KEY `market_indicators_business_categories_FK` (`id_category`),
  CONSTRAINT `market_indicators_business_categories_FK` FOREIGN KEY (`id_category`) REFERENCES `business_categories` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `market_indicators`
--

LOCK TABLES `market_indicators` WRITE;
/*!40000 ALTER TABLE `market_indicators` DISABLE KEYS */;
/*!40000 ALTER TABLE `market_indicators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_requests`
--

DROP TABLE IF EXISTS `match_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `match_requests` (
  `id_match` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_listing` bigint unsigned NOT NULL,
  `id_requester_user` bigint unsigned NOT NULL,
  `pitch_message` text,
  `status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_match`),
  KEY `match_requests_users_FK` (`id_requester_user`),
  KEY `match_requests_connection_listings_FK` (`id_listing`),
  CONSTRAINT `match_requests_connection_listings_FK` FOREIGN KEY (`id_listing`) REFERENCES `connection_listings` (`id_listing`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `match_requests_users_FK` FOREIGN KEY (`id_requester_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_requests`
--

LOCK TABLES `match_requests` WRITE;
/*!40000 ALTER TABLE `match_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `match_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_attachments`
--

DROP TABLE IF EXISTS `media_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_attachments` (
  `id_media` bigint unsigned NOT NULL AUTO_INCREMENT,
  `entity_type` varchar(50) NOT NULL,
  `entity_id` bigint NOT NULL,
  `file_url` varchar(100) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `uploaded_at` timestamp NOT NULL,
  PRIMARY KEY (`id_media`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_attachments`
--

LOCK TABLES `media_attachments` WRITE;
/*!40000 ALTER TABLE `media_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id_messages` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_room` bigint unsigned NOT NULL,
  `id_sender` bigint unsigned NOT NULL,
  `message_body` text NOT NULL,
  `sent_at` timestamp NOT NULL,
  PRIMARY KEY (`id_messages`),
  KEY `messages_collaboration_rooms_FK` (`id_room`),
  KEY `messages_users_FK` (`id_sender`),
  CONSTRAINT `messages_collaboration_rooms_FK` FOREIGN KEY (`id_room`) REFERENCES `collaboration_rooms` (`id_room`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `messages_users_FK` FOREIGN KEY (`id_sender`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id_notif` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `action_url` varchar(100) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_notif`),
  KEY `notifications_users_FK` (`id_user`),
  CONSTRAINT `notifications_users_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews_ratings`
--

DROP TABLE IF EXISTS `reviews_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews_ratings` (
  `id_rating` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_reviewer_user` bigint unsigned NOT NULL,
  `id_target_user` bigint unsigned NOT NULL,
  `id_room` bigint unsigned NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `review_text` text,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_rating`),
  KEY `reviews_ratings_users_FK` (`id_reviewer_user`),
  KEY `reviews_ratings_users_FK_1` (`id_target_user`),
  KEY `reviews_ratings_collaboration_rooms_FK` (`id_room`),
  CONSTRAINT `reviews_ratings_collaboration_rooms_FK` FOREIGN KEY (`id_room`) REFERENCES `collaboration_rooms` (`id_room`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reviews_ratings_users_FK` FOREIGN KEY (`id_reviewer_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reviews_ratings_users_FK_1` FOREIGN KEY (`id_target_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews_ratings`
--

LOCK TABLES `reviews_ratings` WRITE;
/*!40000 ALTER TABLE `reviews_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `simulation_outputs`
--

DROP TABLE IF EXISTS `simulation_outputs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `simulation_outputs` (
  `id_output` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_scenario` bigint unsigned NOT NULL,
  `projected_revenue` decimal(15,2) DEFAULT NULL,
  `projected_profit` decimal(15,2) DEFAULT NULL,
  `projected_cash_runway` int DEFAULT NULL,
  `risk_score` decimal(5,2) DEFAULT NULL,
  `calculated_at` timestamp NOT NULL,
  PRIMARY KEY (`id_output`),
  KEY `simulation_outputs_simulation_scenarios_FK` (`id_scenario`),
  CONSTRAINT `simulation_outputs_simulation_scenarios_FK` FOREIGN KEY (`id_scenario`) REFERENCES `simulation_scenarios` (`id_scenario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `simulation_outputs`
--

LOCK TABLES `simulation_outputs` WRITE;
/*!40000 ALTER TABLE `simulation_outputs` DISABLE KEYS */;
/*!40000 ALTER TABLE `simulation_outputs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `simulation_scenarios`
--

DROP TABLE IF EXISTS `simulation_scenarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `simulation_scenarios` (
  `id_scenario` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_profile` bigint unsigned NOT NULL,
  `scenario_name` varchar(150) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_scenario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `simulation_scenarios`
--

LOCK TABLES `simulation_scenarios` WRITE;
/*!40000 ALTER TABLE `simulation_scenarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `simulation_scenarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `simulation_variables`
--

DROP TABLE IF EXISTS `simulation_variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `simulation_variables` (
  `id_variable` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_scenario` bigint unsigned NOT NULL,
  `variable_name` varchar(100) NOT NULL,
  `change_type` enum('percentage','fixed_amount') NOT NULL,
  `value_change` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id_variable`),
  KEY `simulation_variables_simulation_scenarios_FK` (`id_scenario`),
  CONSTRAINT `simulation_variables_simulation_scenarios_FK` FOREIGN KEY (`id_scenario`) REFERENCES `simulation_scenarios` (`id_scenario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `simulation_variables`
--

LOCK TABLES `simulation_variables` WRITE;
/*!40000 ALTER TABLE `simulation_variables` DISABLE KEYS */;
/*!40000 ALTER TABLE `simulation_variables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sme_metrics_logs`
--

DROP TABLE IF EXISTS `sme_metrics_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sme_metrics_logs` (
  `id_metrics` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_profile` bigint unsigned NOT NULL,
  `period_date` date NOT NULL,
  `revenue` decimal(15,2) NOT NULL DEFAULT '0.00',
  `expenses` decimal(15,2) NOT NULL DEFAULT '0.00',
  `order_count` int NOT NULL DEFAULT '0',
  `cash_on_hand` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id_metrics`),
  KEY `sme_metrics_logs_sme_profiles_FK` (`id_profile`),
  CONSTRAINT `sme_metrics_logs_sme_profiles_FK` FOREIGN KEY (`id_profile`) REFERENCES `sme_profiles` (`id_profile`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sme_metrics_logs`
--

LOCK TABLES `sme_metrics_logs` WRITE;
/*!40000 ALTER TABLE `sme_metrics_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `sme_metrics_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sme_profiles`
--

DROP TABLE IF EXISTS `sme_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sme_profiles` (
  `id_profile` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `id_category` bigint unsigned NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `legal_type` varchar(100) DEFAULT NULL,
  `address` text,
  `city` varchar(100) NOT NULL,
  `established_year` int NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_profile`),
  KEY `sme_profiles_users_FK` (`id_user`),
  KEY `sme_profiles_business_categories_FK` (`id_category`),
  CONSTRAINT `sme_profiles_business_categories_FK` FOREIGN KEY (`id_category`) REFERENCES `business_categories` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sme_profiles_users_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sme_profiles`
--

LOCK TABLES `sme_profiles` WRITE;
/*!40000 ALTER TABLE `sme_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `sme_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_logs`
--

DROP TABLE IF EXISTS `system_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_logs` (
  `id_logs` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `action_type` varchar(100) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id_logs`),
  KEY `system_logs_users_FK` (`id_user`),
  CONSTRAINT `system_logs_users_FK` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_logs`
--

LOCK TABLES `system_logs` WRITE;
/*!40000 ALTER TABLE `system_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('sme_owner','mentor','investor','admin','user') NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_sme'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-24 11:57:47
