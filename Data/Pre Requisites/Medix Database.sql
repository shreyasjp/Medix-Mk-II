CREATE DATABASE  IF NOT EXISTS `medix` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `medix`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: medix
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `medix-docs`
--

DROP TABLE IF EXISTS `medix-docs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-docs` (
  `doc_id` int NOT NULL AUTO_INCREMENT,
  `owner` int NOT NULL,
  `document_name` varchar(256) NOT NULL,
  `document_type` varchar(128) NOT NULL,
  `file-type` varchar(256) NOT NULL,
  `file_extension` varchar(64) NOT NULL,
  `file_path` longtext NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `uploaded_by` int DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_verified` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`doc_id`),
  UNIQUE KEY `doc_id_UNIQUE` (`doc_id`),
  KEY `user-docs_idx` (`owner`),
  KEY `user-docs-uploader_idx` (`uploaded_by`),
  CONSTRAINT `user-docs-owner` FOREIGN KEY (`owner`) REFERENCES `medix-users` (`mx_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user-docs-uploader` FOREIGN KEY (`uploaded_by`) REFERENCES `medix-users` (`mx_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `medix-docs-sharing`
--

DROP TABLE IF EXISTS `medix-docs-sharing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-docs-sharing` (
  `doc-sharing-id` int NOT NULL AUTO_INCREMENT,
  `doc_id` int NOT NULL,
  `owner` int NOT NULL,
  `shared_with` int NOT NULL,
  `view_access` int NOT NULL,
  `edit_access` int NOT NULL,
  `download_access` int NOT NULL,
  PRIMARY KEY (`doc-sharing-id`),
  UNIQUE KEY `doc-sharing-id_UNIQUE` (`doc-sharing-id`),
  KEY `user-docs-sharing-owner_idx` (`owner`),
  KEY `user-docs-sharing-receiver_idx` (`shared_with`),
  KEY `docs-docs-sharing_idx` (`doc_id`),
  CONSTRAINT `docs-docs-sharing` FOREIGN KEY (`doc_id`) REFERENCES `medix-docs` (`doc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user-docs-sharing-owner` FOREIGN KEY (`owner`) REFERENCES `medix-users` (`mx_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user-docs-sharing-receiver` FOREIGN KEY (`shared_with`) REFERENCES `medix-users` (`mx_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `medix-medical-personnel`
--

DROP TABLE IF EXISTS `medix-medical-personnel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-medical-personnel` (
  `mx_id` int NOT NULL,
  `role` varchar(100) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `city` int DEFAULT '0',
  `phone` varchar(20) DEFAULT '0',
  `document-location` longtext NOT NULL,
  `document_status` int NOT NULL DEFAULT '0',
  `verification_status` int NOT NULL DEFAULT '0',
  `validator_id` int DEFAULT NULL,
  `validator_message` longtext,
  `available` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`mx_id`),
  UNIQUE KEY `mx_id_UNIQUE` (`mx_id`),
  KEY `user-validator_idx` (`validator_id`),
  CONSTRAINT `user-medical-personnel` FOREIGN KEY (`mx_id`) REFERENCES `medix-users` (`mx_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user-validator` FOREIGN KEY (`validator_id`) REFERENCES `medix-validators` (`validator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `medix-sharing`
--

DROP TABLE IF EXISTS `medix-sharing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-sharing` (
  `sharing_id` int NOT NULL AUTO_INCREMENT,
  `mx_id` int NOT NULL,
  `doc_mx_id` int NOT NULL,
  `message` longtext,
  PRIMARY KEY (`sharing_id`),
  UNIQUE KEY `sharing_id_UNIQUE` (`sharing_id`),
  KEY `user-sharing_idx` (`mx_id`),
  KEY `user-sharing-doc_idx` (`doc_mx_id`),
  CONSTRAINT `user-sharing-doc` FOREIGN KEY (`doc_mx_id`) REFERENCES `medix-users` (`mx_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user-sharing-user` FOREIGN KEY (`mx_id`) REFERENCES `medix-users` (`mx_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `medix-user-profile`
--

DROP TABLE IF EXISTS `medix-user-profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-user-profile` (
  `mx_id` int NOT NULL,
  `age` int NOT NULL,
  `gender` varchar(8) NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `blood_group` varchar(15) NOT NULL,
  `profile_pic_location` longtext,
  `completion_status` int NOT NULL,
  PRIMARY KEY (`mx_id`),
  UNIQUE KEY `mx_id_UNIQUE` (`mx_id`),
  CONSTRAINT `user-profile` FOREIGN KEY (`mx_id`) REFERENCES `medix-users` (`mx_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `medix-user-sessions`
--

DROP TABLE IF EXISTS `medix-user-sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-user-sessions` (
  `mx_id` int NOT NULL,
  `token` varchar(128) NOT NULL,
  `expiry` datetime NOT NULL,
  PRIMARY KEY (`mx_id`),
  UNIQUE KEY `mx_id_UNIQUE` (`mx_id`),
  CONSTRAINT `user-session` FOREIGN KEY (`mx_id`) REFERENCES `medix-users` (`mx_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `medix-users`
--

DROP TABLE IF EXISTS `medix-users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-users` (
  `mx_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mx_id`),
  UNIQUE KEY `mx_id_UNIQUE` (`mx_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `medix-validators`
--

DROP TABLE IF EXISTS `medix-validators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-validators` (
  `validator_id` int NOT NULL AUTO_INCREMENT,
  `password` varchar(128) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`validator_id`),
  UNIQUE KEY `validator_id_UNIQUE` (`validator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-08 15:00:20
