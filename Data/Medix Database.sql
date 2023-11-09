CREATE DATABASE  IF NOT EXISTS `medix-db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `medix-db`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: medix-db
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
  `document_name` varchar(256) NOT NULL,
  `document_type` varchar(128) NOT NULL,
  `file-type` varchar(256) NOT NULL,
  `description` longtext,
  `file_path` varchar(256) NOT NULL,
  `owner` int NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` int NOT NULL,
  `is_verified` int NOT NULL,
  `file_extension` varchar(45) NOT NULL,
  PRIMARY KEY (`doc_id`),
  UNIQUE KEY `doc_id_UNIQUE` (`doc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-docs`
--

LOCK TABLES `medix-docs` WRITE;
/*!40000 ALTER TABLE `medix-docs` DISABLE KEYS */;
INSERT INTO `medix-docs` VALUES (32,'srhydjtjtdjtd','Operative Report','Document','tjtjtjttjsthjhjtttttshsrjttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt','../Uploads/65410be5d20d4_To.pdf',52,'2023-10-31 14:15:01',52,1,'pdf'),(37,'jkyjky','Discharge Summary','Other','','../Uploads/65421a408c4ec_RenewalPaymentSlip.pdf',52,'2023-11-01 09:28:32',52,0,'pdf'),(38,'tjjy','Prescription','Other','','../Uploads/65421a56019e5_Screenshot 2023-10-27 105021.png',52,'2023-11-01 09:28:54',52,0,'png'),(39,'ryio','Medical History Record','Image','','../Uploads/65423607c7b54_To.pdf',51,'2023-11-01 11:27:03',51,0,'pdf'),(41,'gjj','Medical History Record','Image','hjj','../Uploads/6544f19581726_testdp.png',52,'2023-11-03 13:11:49',52,0,'png'),(43,'hyjjh','Medical History Record','Image','','../Uploads/6545ede29ddd0_Consent letter.pdf',65,'2023-11-04 07:08:18',65,0,'pdf'),(44,'fvdf','Patient Information','Image','ddd','../Uploads/65475d201e32c_Flat.csv.txt',52,'2023-11-05 09:15:12',52,0,'txt'),(45,'333','Medical History Record','Image','333','../Uploads/65476331bdaf8_KZ EDX Pro Harman.txt',52,'2023-11-05 09:41:05',52,1,'txt'),(46,'htjj','Medical History Record','Text','thhtrshhhrrshrshrhsrhshrshrs','../Uploads/654763d35b029_Flat.csv.txt',52,'2023-11-05 09:43:47',52,1,'txt'),(47,'sss','Medical History Record','Image','sssss','../Uploads/65476539a17e2_crinacle-harman oe 2018.csv',52,'2023-11-05 09:49:45',52,1,'csv');
/*!40000 ALTER TABLE `medix-docs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medix-docs-sharing`
--

DROP TABLE IF EXISTS `medix-docs-sharing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-docs-sharing` (
  `doc_id` int NOT NULL,
  `owner` int NOT NULL,
  `shared_with` int NOT NULL,
  `view_access` int NOT NULL,
  `edit_access` int NOT NULL,
  `download_access` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-docs-sharing`
--

LOCK TABLES `medix-docs-sharing` WRITE;
/*!40000 ALTER TABLE `medix-docs-sharing` DISABLE KEYS */;
INSERT INTO `medix-docs-sharing` VALUES (15,51,52,1,1,1),(21,52,51,1,1,1),(22,52,51,1,1,1),(37,52,63,1,0,1),(37,52,53,1,0,1),(37,52,51,1,0,1),(37,52,56,1,0,1),(37,52,58,1,0,1),(37,52,57,1,0,1);
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
  `document_status` int NOT NULL,
  `document-location` varchar(128) DEFAULT NULL,
  `verification_status` varchar(20) NOT NULL,
  `role` varchar(60) DEFAULT NULL,
  `comments` longtext,
  `validator_id` varchar(255) DEFAULT NULL,
  `medpro_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`mx_id`),
  UNIQUE KEY `medpro_id_UNIQUE` (`medpro_id`),
  CONSTRAINT `mx_id_medical_personnel` FOREIGN KEY (`mx_id`) REFERENCES `medix-users` (`mx_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-medical-personnel`
--

LOCK TABLES `medix-medical-personnel` WRITE;
/*!40000 ALTER TABLE `medix-medical-personnel` DISABLE KEYS */;
INSERT INTO `medix-medical-personnel` VALUES (51,1,'http://localhost/code/Medix/main//Verify/651ec239e1c5a_Flowy Blue.png','Approved','Medical Doctor','suiimandan','lh44@gmail.com',1),(54,1,'http://localhost/code/Medix/main/Verify/651f19fcad2b0_Scan_20220428 (3).jpg','dd','','zz','lh44@gmail.com',2),(55,0,NULL,'Approved',NULL,NULL,'lh44@gmail.com',3);
/*!40000 ALTER TABLE `medix-medical-personnel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medix-sharing`
--

DROP TABLE IF EXISTS `medix-sharing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-sharing` (
  `mx_id` int NOT NULL,
  `doc_mx_id` int NOT NULL,
  `message` longtext,
  `sharing_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sharing_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-sharing`
--

LOCK TABLES `medix-sharing` WRITE;
/*!40000 ALTER TABLE `medix-sharing` DISABLE KEYS */;
INSERT INTO `medix-sharing` VALUES (52,52,'',4),(52,52,'',5),(52,52,'',6),(64,52,'HEHEHEHEHE',7),(63,52,'dghh',8);
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
  `height` decimal(6,3) NOT NULL,
  `weight` decimal(6,3) NOT NULL,
  `blood_group` varchar(15) NOT NULL,
  `completion_status` varchar(30) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `profile_pic_location` longtext,
  PRIMARY KEY (`mx_id`),
  CONSTRAINT `mx_id` FOREIGN KEY (`mx_id`) REFERENCES `medix-users` (`mx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-user-profile`
--

LOCK TABLES `medix-user-profile` WRITE;
/*!40000 ALTER TABLE `medix-user-profile` DISABLE KEYS */;
INSERT INTO `medix-user-profile` VALUES (51,85,185.000,85.000,'O-','1','Male',NULL),(52,58,185.000,54.000,'Unknown','1','Male','../ProfileImages/65440233abd3f_IMG_20231011_130617762.jpg'),(53,55,78.000,98.000,'A-','1','Male',NULL),(54,58,55.000,55.000,'A+','1','Male',NULL),(55,100,100.000,100.000,'Special','1','Female',NULL),(58,32,188.000,84.000,'O-','1','male',NULL),(59,55,156.000,95.000,'A+','1','Male',NULL),(60,88,88.000,88.000,'A+','1','Male',NULL),(61,55,55.000,555.000,'A+','1','Female',NULL),(62,55,55.000,55.000,'A+','1','Male','../ProfileImages/65440233abd3f_IMG_20231011_130617762.jpg'),(63,21,178.000,78.000,'A+','1','Male','../ProfileImages/654402923ea91_PXL_20231026_040243678.jpg'),(64,75,180.000,76.000,'O+','1','Female','../ProfileImages/65440339aca42_PXL_20231026_040243678.jpg'),(65,54,200.000,500.000,'A+','1','Male','../ProfileImages/6545ed87a86e3_testdp.png'),(66,55,179.000,60.000,'B+','1','Male','../ProfileImages/654a0a435a515_mourinho-was-furious-with-solskjaers-post-match-comments-abo-1a0853-sc.jpg');
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
  `expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-user-sessions`
--

LOCK TABLES `medix-user-sessions` WRITE;
/*!40000 ALTER TABLE `medix-user-sessions` DISABLE KEYS */;
INSERT INTO `medix-user-sessions` VALUES (52,'a337242bf3376ea9520700098545511b80bdb0a95b8839fb278ac46ed9dca63e','2023-11-26 07:05:44'),(52,'614c0a162a736c45489943bfb83a54198ad4b3e4f74a87465726d86166ba6ebe','2023-11-26 07:36:45');
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
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`),
  UNIQUE KEY `mx_id_UNIQUE` (`mx_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-users`
--

LOCK TABLES `medix-users` WRITE;
/*!40000 ALTER TABLE `medix-users` DISABLE KEYS */;
INSERT INTO `medix-users` VALUES (53,'Shreyas','23@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$dExUdndQam9oZTdMZEM1dg$kp7kFiGDABZAg1tMa15bVHuJm5hvl6l1srMItLLH1ns','09c19ffe15bac8c6a9b37bf3b7ab60c17522f32cbc0d1097ec0ff39e608a2d4a','2023-10-05 18:06:46','2023-10-05 18:06:46'),(56,'Carlos','CARLOS@GMAIL.COM','$argon2id$v=19$m=65536,t=4,p=1$WGR3dWFURERUYU5kNVFJMQ$R7kqHW5Qo1Rj3S390JFERfInO+8tuTGV2D/rlH/vyZA','37312d41955479854414c2fdccfb375bdb2352cb654ca97f58c96103b0b7db75','2023-11-01 20:24:28','2023-11-01 20:24:28'),(57,'Carlos','Carlos2@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$dDdpZ3NyS1VpODRNOTZ4ZA$+RXlroWxCurWx2Vc8gX8FekYn3VNIAHao1yw3xTnCg8','a3d5d08fd1ccad178ab1a53f0e66ac69f5c5d8f92d23e0436c71b4de45832c62','2023-11-01 20:25:36','2023-11-01 20:25:36'),(64,'Carlos','CARRLOS@GMAIL.COM','$argon2id$v=19$m=65536,t=4,p=1$QU9NZkJueFpnM2lWSFU2Qw$ghRE7zp+kSLc/VHe9xKW4pxORfGqLu35L/5//fyPYlM','6db0f860a45e855b97907b36a6e6d36bdf5121718b87c4ae7296ca7221abd7c2','2023-11-02 20:14:23','2023-11-02 20:14:23'),(62,'hjhyyhj','ehtjhyte@rhjk','$argon2id$v=19$m=65536,t=4,p=1$NmExVEpNUGhka2pWWDguUA$Ca16NlyXKdV8QryjcNO5Ue+jwLB7AJT4tuyZ4slihUg','b012b73aa95cdd5056bf64fc311d5dfd1e15d730f92421627e3ef5a1ed72e8e4','2023-11-02 20:06:28','2023-11-02 20:06:28'),(66,'Ukrikrishnan','hari@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$M3hGNDlJa2p0NmFvdEcxbg$yLhRUzm6Htafvx7fC+JAAOGhmoyuXiJDp0LnRnf1EHk','ae159f7e1770095f7316e41b58c32095a0fb0a25f72aca786f50f9297a7bd57c','2023-11-07 09:56:37','2023-11-07 09:56:37'),(60,'ghthj','jtj@fgfg','$argon2id$v=19$m=65536,t=4,p=1$dFJ0enBnSGVCcXRkWkI5VQ$g4Dh9wWsrQdmAurdXXDQ/Lh62y7eSUkJmk1rlILRtXQ','8c2390ccef96dde5b678d65e6cc10d5375e27f94fc24fde8389b29cb0adfa095','2023-11-02 19:59:15','2023-11-02 19:59:15'),(58,'Ham','lh44@amg.com','$argon2id$v=19$m=65536,t=4,p=1$aTJ6UzU5VXB4OVd5WXlQeQ$AV2vtQIFWHKZK0nD3NChdHYmWi+SQGcJ7Upg+NvPP40','8b3cb154fd3639b770df2f904a0a78236dcab50c0cfc23e781771b5d9ed835dc','2023-11-02 19:51:26','2023-11-02 19:51:26'),(59,'Carlos','lh44@amg1.com','$argon2id$v=19$m=65536,t=4,p=1$YmI3aDk5OTAvd2p2Y1liMg$5LXyA2gyUhEAG4ZVKATlOQ6YZQraIlmMKlhBOCw8TWQ','7403833457e018edd35e24913742ec0f570d856ce17f7df86fc617b788d73652','2023-11-02 19:55:30','2023-11-02 19:55:30'),(65,'rhyk','lh44@amg11.com','$argon2id$v=19$m=65536,t=4,p=1$ZG5wdko4S1hOQjV6YXRtQg$lLDsCqzCelMp9eDTyrOajw3I+rSYTLlBHyZPMe1iJtY','ce6dbf0dd1042f4b45b6e4bd8146e68c6e963206ca1b82b4896bb1ee18ae5093','2023-11-04 07:06:24','2023-11-04 07:06:24'),(51,'Shreyas','lh44@gmail.com','$argon2id$v=19$m=65536,t=4,p=1$LkRuSWRYS3M0ak9HQzM4cA$FivQz2DIZmTptsbiWLf7Y2QjDMIxPwtqE0bkyx6r1lM','6bffe264674637c12d4886fe994a2c5e667b6863976319c380b1b6853d5e21a1','2023-10-05 13:08:14','2023-10-05 13:08:14'),(55,'Name','Name@example.com','$argon2id$v=19$m=65536,t=4,p=1$Z2JITWJORy5Hcy5JL0NPbw$izb4hVsa23b5Sd0cvNi95zqtal5i9EA0LhRLFu43a7M','8efcf86a15b93521bc59d73a4293db5ffe339b67f9641f847433d70e4b06a73c','2023-10-06 02:46:10','2023-10-06 02:46:10'),(61,'sghh','rhh@aeegg','$argon2id$v=19$m=65536,t=4,p=1$cnYvMkJZVzBIc0lILml3Tw$IqhUIGIaNl3Bctz1JksWsaCj0FSWMLZeYfUFsEzRUkI','c89e03c3cb15b14a81d0906aa95dedf31b6367e0699db46ce7f81c86c5aa5aeb','2023-11-02 20:02:34','2023-11-02 20:02:34'),(63,'Vinicius','rma@mail.com','$argon2id$v=19$m=65536,t=4,p=1$QTRjd0xsMVpoWVZJQWNnaA$VmsYGKNUuwRxLURJenFjd+MlLLf3RqSgHudMJ+b/a0k','cfbb83869d1651df2b40bcc92cbb727abdfad8567eb51ea6c3a6ceb1e3050741','2023-11-02 20:11:41','2023-11-02 20:11:41'),(52,'Shreyas Jayaprakash','shreyasjayaprakashcr7@hmail.com','$argon2id$v=19$m=65536,t=4,p=1$bVVLUThELlRML05RNFh4QQ$hLuEVivVFt8Im79dqvOPuYcaLvRYOM7vpU3BZ834JvE','8b6d769f9e3ba9320da89bdf177d6f4dc1cc315ab87591e0c82f9da90d95e12d','2023-10-05 16:15:16','2023-10-27 18:52:38'),(54,'Shreyas','suii@ok.com','$argon2id$v=19$m=65536,t=4,p=1$dXpuN2NaWkxkdHMvN2RWaw$gSHJwNqiDRt9cV1i5zm8Y+DsHx4RgO7pq4tkYIVEhic','870879331bc8db86ffd7175139cee5f482b860264d72fd0a002b6014565d924d','2023-10-05 20:17:35','2023-10-05 20:17:35');
/*!40000 ALTER TABLE `medix-users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medix-validators`
--

DROP TABLE IF EXISTS `medix-validators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medix-validators` (
  `id` varchar(255) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medix-validators`
--

LOCK TABLES `medix-validators` WRITE;
/*!40000 ALTER TABLE `medix-validators` DISABLE KEYS */;
INSERT INTO `medix-validators` VALUES ('lh44@gmail.com','6bffe264674637c12d4886fe994a2c5e667b6863976319c380b1b6853d5e21a1','$argon2id$v=19$m=65536,t=4,p=1$LkRuSWRYS3M0ak9HQzM4cA$FivQz2DIZmTptsbiWLf7Y2QjDMIxPwtqE0bkyx6r1lM');
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

-- Dump completed on 2023-11-09  6:44:22
