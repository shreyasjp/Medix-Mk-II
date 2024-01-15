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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-docs`
--

LOCK TABLES `medix-docs` WRITE;
/*!40000 ALTER TABLE `medix-docs` DISABLE KEYS */;
INSERT INTO `medix-docs` VALUES (1,2,'XRay#1','Medical Imagery','Image','png','../Uploads/6595f8a670aac_Screenshot 2023-06-07 222641.png','',2,'2024-01-04 00:15:34',0),(2,2,'BloodReport#1','Medical Test Report','Document','pdf','../Uploads/6595f8cdda6c4_dummy.pdf','',2,'2024-01-04 00:16:13',0),(3,4,'Scan#1','Medical Imagery','Image','png','../Uploads/6595f9a7cb808_Screenshot 2023-06-28 062945.png','',4,'2024-01-04 00:19:51',0),(4,4,'Discharge Summary 3','Discharge Summary','Document','pdf','../Uploads/6595f9db563da_INPUT DEVICES-Canva Presenation (16-9).pdf','',4,'2024-01-04 00:20:43',0),(5,3,'#1','Medical History Record','Text','txt','../Uploads/6595fbf39a2e2_Sony MDR-ZX110 Crinacle X Harman.txt','',3,'2024-01-04 00:29:39',0),(6,3,'#2','Patient Information','Document','pdf','../Uploads/6595fc1a3e7e1_DT20234932933_Application (1).pdf','Info',3,'2024-01-04 00:30:18',0),(7,3,'#3','Discharge Summary','Document','pdf','../Uploads/6595fc2f484b6_dummy.pdf','',3,'2024-01-04 00:30:39',0),(8,3,'#4','Medical Imagery','Video','mp4','../Uploads/6595fc454eb43_Meet – qfi-eyqe-nou - Google Chrome 2023-12-25 10-00-42.mp4','',3,'2024-01-04 00:31:01',0),(9,3,'#5','Prescription','Image','png','../Uploads/6595fc7e9030c_Screenshot 2023-09-08 033243.png','',3,'2024-01-04 00:31:58',0);
/*!40000 ALTER TABLE `medix-docs` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-docs-sharing`
--

LOCK TABLES `medix-docs-sharing` WRITE;
/*!40000 ALTER TABLE `medix-docs-sharing` DISABLE KEYS */;
INSERT INTO `medix-docs-sharing` VALUES (1,4,4,1,1,0,1),(2,4,4,3,1,0,1);
/*!40000 ALTER TABLE `medix-docs-sharing` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `medix-medical-personnel`
--

LOCK TABLES `medix-medical-personnel` WRITE;
/*!40000 ALTER TABLE `medix-medical-personnel` DISABLE KEYS */;
INSERT INTO `medix-medical-personnel` VALUES (1,'Medical Doctor','Apollo Hospital',110076,'+91 2635392583','../MedProID/6595f5d1e49d6_dummy.pdf',1,1,1,NULL,0),(3,'Radiologist','Scan Centre',683542,'+918921769021','../MedProID/6595fba4d3b83_IXZ-MAA Indigo.pdf',1,0,NULL,NULL,0),(4,'Medical Doctor','FortisC DOC',110019,'06410677256','../MedProID/6595fa326f755_Twist\'N\'Turn.pdf',1,0,NULL,NULL,0);
/*!40000 ALTER TABLE `medix-medical-personnel` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-sharing`
--

LOCK TABLES `medix-sharing` WRITE;
/*!40000 ALTER TABLE `medix-sharing` DISABLE KEYS */;
INSERT INTO `medix-sharing` VALUES (1,2,1,''),(2,3,1,''),(3,4,1,''),(4,5,1,'');
/*!40000 ALTER TABLE `medix-sharing` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `medix-user-profile`
--

LOCK TABLES `medix-user-profile` WRITE;
/*!40000 ALTER TABLE `medix-user-profile` DISABLE KEYS */;
INSERT INTO `medix-user-profile` VALUES (1,35,'Male',165,60,'O+','../ProfileImages/6595f4a6a4df0_1.jpg',1),(2,42,'Female',161,53,'A-','../ProfileImages/6595f646636b8_8.jpg',1),(3,20,'Male',173,69,'O+','../ProfileImages/6595f7797667b_WhatsApp Image 2024-01-04 at 05.39.51_8cb250f7.jpg',1),(4,59,'Male',168,55,'O+','../ProfileImages/6595f972721a4_5.jpg',1),(5,31,'Male',179,88,'AB-','../ProfileImages/6595fb0e3451d_80.jpg',1);
/*!40000 ALTER TABLE `medix-user-profile` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `medix-user-sessions`
--

LOCK TABLES `medix-user-sessions` WRITE;
/*!40000 ALTER TABLE `medix-user-sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `medix-user-sessions` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-users`
--

LOCK TABLES `medix-users` WRITE;
/*!40000 ALTER TABLE `medix-users` DISABLE KEYS */;
INSERT INTO `medix-users` VALUES (1,'soman.aditi@palla.in','Nazir Chaudhuri','$argon2id$v=19$m=65536,t=4,p=1$dFNBQUZiN3hLQU9KemRXSw$BGV8gyOfEUskkfpw2vY7JEZYJGCPP2QpkUVyK0eTYuI','d81a671178dd52036f2c8bc55a4d981649515c2f8dea506ac6972313aac216dc','2024-01-03 23:57:29','2024-01-03 23:57:29'),(2,'rosina2011@gmail.com','Jennifer W Lightfoot','$argon2id$v=19$m=65536,t=4,p=1$M1BLUXdkelM4ajRBSTJvSQ$qDAQoZau3WqoEfUhMWjRjIXm6mnpPqwJ6B4vXU1Esdk','11a6460f6816917c4aa0e9b46c7e6be9f1a4d6b75e074884909a77118e7d5e22','2024-01-04 00:04:37','2024-01-04 00:04:37'),(3,'shreyasjayaprakashcr7@gmail.com','Shreyas','$argon2id$v=19$m=65536,t=4,p=1$UlJZVUFGMW9xQlpoU3QubQ$f7AKHNuUjCWlzpzQ4ggWU0Wy1o6z/HvkidF00PLOhIg','e4ad55f1c37d1889aa9a2f3f91b2071d1d40706b533ddcd2f52c6bc2542bf455','2024-01-04 00:08:22','2024-01-04 00:08:22'),(4,'rkaul@balakrishnan.co.in','Habib Rao Datta','$argon2id$v=19$m=65536,t=4,p=1$clBtZS8ydVJoODFGbFRGaQ$ut6hJKPKXVncmjeL8XTsoFFSU17YQdVESMnhIR3U2Gc','fa4f269099e2147bec549a2c76f602a7987704b866dfccc1fbcec106eb1fbd40','2024-01-04 00:18:10','2024-01-04 00:18:10'),(5,'bianka.denes@gmail.com','Joseph B Wagner','$argon2id$v=19$m=65536,t=4,p=1$V3lsNHBkdXRQdmtiS2EwMA$cgvR3i3faIRib6gylIjPQ44LxpNRu5DnFnKOc+cAX/U','a0fb210524f42b30166e42583a4834eee376a36fd73d1f1b50c489f38412f0f9','2024-01-04 00:25:12','2024-01-04 00:25:12');
/*!40000 ALTER TABLE `medix-users` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-validators`
--

LOCK TABLES `medix-validators` WRITE;
/*!40000 ALTER TABLE `medix-validators` DISABLE KEYS */;
INSERT INTO `medix-validators` VALUES (1,'$argon2id$v=19$m=65536,t=4,p=1$UlJZVUFGMW9xQlpoU3QubQ$f7AKHNuUjCWlzpzQ4ggWU0Wy1o6z/HvkidF00PLOhIg','e4ad55f1c37d1889aa9a2f3f91b2071d1d40706b533ddcd2f52c6bc2542bf455','validator1@medix.in');
/*!40000 ALTER TABLE `medix-validators` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-04  6:04:48
