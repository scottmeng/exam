CREATE DATABASE  IF NOT EXISTS `FYP_CodeCrunch` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `FYP_CodeCrunch`;
-- MySQL dump 10.13  Distrib 5.6.19, for osx10.7 (i386)
--
-- Host: 127.0.0.1    Database: FYP_CodeCrunch
-- ------------------------------------------------------
-- Server version	5.6.23

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
-- Table structure for table `course_user`
--

DROP TABLE IF EXISTS `course_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `course_user_course_id_foreign` (`course_id`),
  KEY `course_user_user_id_foreign` (`user_id`),
  KEY `course_user_role_id_foreign` (`role_id`),
  CONSTRAINT `course_user_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  CONSTRAINT `course_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `course_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_user`
--

LOCK TABLES `course_user` WRITE;
/*!40000 ALTER TABLE `course_user` DISABLE KEYS */;
INSERT INTO `course_user` VALUES (1,1,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,2,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,1,2,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,2,2,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,1,4,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,1,3,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,1,5,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,1,6,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,1,7,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(10,1,8,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,1,9,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,1,10,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,1,11,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,1,12,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,1,13,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(16,1,14,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(17,1,15,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(18,1,16,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(19,1,17,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(20,1,18,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(21,1,19,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(22,1,20,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(23,1,21,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(24,1,22,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(25,1,23,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(26,1,24,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(27,1,25,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(28,1,26,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(29,1,27,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(30,1,28,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(31,1,29,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(32,1,30,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(33,1,31,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(34,1,32,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(35,1,33,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(36,1,34,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(37,1,35,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(38,1,36,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(39,1,37,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(40,1,38,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(41,1,39,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(42,1,40,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(43,1,41,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(44,1,42,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(45,1,43,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(46,1,44,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(47,1,45,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(48,1,46,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(49,1,47,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(50,1,48,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(51,1,49,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(52,1,50,3,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `course_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nus_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'CS1010J','Programming Methodology','<b>Welcome to your first programming course!</b><br><br>\n                Here you will learn algorithms, languages and other essential programming skills.<br><br>\n                Plese take note of the following important dates: \n                <li><mark><small>Assignment 1 due: March 3rd;</small></mark></li>\n                <li><mark><small>Final Exam: May 2nd(pm)</small></mark></li>','2015-04-19 16:05:55','2015-04-19 16:30:03'),(2,'CS2010','Algorithms and Data Structure','<h4>Welcome!</h4><br>\n                Please be prepared for a lot of learnings and assignments too!','2015-04-19 16:05:55','2015-04-19 16:30:03');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_question`
--

DROP TABLE IF EXISTS `exam_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  `index` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `exam_question_exam_id_foreign` (`exam_id`),
  KEY `exam_question_question_id_foreign` (`question_id`),
  CONSTRAINT `exam_question_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  CONSTRAINT `exam_question_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_question`
--

LOCK TABLES `exam_question` WRITE;
/*!40000 ALTER TABLE `exam_question` DISABLE KEYS */;
INSERT INTO `exam_question` VALUES (22,3,4,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(31,3,27,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(32,3,30,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(36,3,28,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(37,3,31,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(38,4,13,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(39,4,29,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(40,4,30,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(41,4,31,4,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `exam_question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course_id` int(10) unsigned NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `examstate_id` int(10) unsigned NOT NULL DEFAULT '1',
  `duration` int(11) NOT NULL DEFAULT '60',
  `fullmarks` int(11) NOT NULL DEFAULT '100',
  `totalqn` int(11) NOT NULL DEFAULT '0',
  `starttime` datetime DEFAULT NULL,
  `randomizeQuestions` tinyint(1) NOT NULL DEFAULT '0',
  `grace_period` int(11) NOT NULL DEFAULT '15',
  `general_feedback` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `exams_course_id_foreign` (`course_id`),
  KEY `exams_examstate_id_foreign` (`examstate_id`),
  CONSTRAINT `exams_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  CONSTRAINT `exams_examstate_id_foreign` FOREIGN KEY (`examstate_id`) REFERENCES `examstates` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exams`
--

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;
INSERT INTO `exams` VALUES (1,'CS2010 Midterm Test',2,'<p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><span><strong>Please read these instructions carefully.</strong><span class=\"Apple-converted-space\"> </span>A candidate who breaches any of the Examination Regulations will be liable to disciplinary action<span class=\"Apple-converted-space\"> </span></span><span>including (but not limited to) suspension or expulsion from the university.</span><u><span></span></u><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Timings</span></u></b><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>The examination hall will be open for admission <b>10</b> minutes before the time scheduled for the commencement of the examination. You are to find your allocated seat but </span><strong>do not </strong><span>turn over the question paper until instructed at the time of commencement of the examination.</span><br/></li></ul><p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Personal Belongings</span></u></b></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>Photography is not allowed in the examination hall at all </span><span>times.</span><br/></li><li><span>The University will not be responsible for the loss of any belongings in or outside the examination hal</span><br/></li></ul><p></p><p></p>',1,60,0,0,NULL,0,15,NULL,'2015-04-13 23:08:43','2015-04-19 16:06:02'),(2,'CS2010 Sit in Lab',2,'<p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><span><strong>Please read these instructions carefully.</strong><span class=\"Apple-converted-space\"> </span>A candidate who breaches any of the Examination Regulations will be liable to disciplinary action<span class=\"Apple-converted-space\"> </span></span><span>including (but not limited to) suspension or expulsion from the university.</span><u><span></span></u><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Timings</span></u></b><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>The examination hall will be open for admission <b>10</b> minutes before the time scheduled for the commencement of the examination. You are to find your allocated seat but </span><strong>do not </strong><span>turn over the question paper until instructed at the time of commencement of the examination.</span><br/></li></ul><p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Personal Belongings</span></u></b></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>Photography is not allowed in the examination hall at all </span><span>times.</span><br/></li><li><span>The University will not be responsible for the loss of any belongings in or outside the examination hal</span><br/></li></ul><p></p><p></p>',1,60,0,0,NULL,0,15,NULL,'2015-04-13 23:08:43','2015-04-19 16:06:02'),(3,'CS1010J Quiz 1',1,'<p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><span><strong>Please read these instructions carefully.</strong><span class=\"Apple-converted-space\"> </span>A candidate who breaches any of the Examination Regulations will be liable to disciplinary action<span class=\"Apple-converted-space\"> </span></span><span>including (but not limited to) suspension or expulsion from the university.</span><u><span></span></u><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Timings</span></u></b><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>The examination hall will be open for admission <b>10</b> minutes before the time scheduled for the commencement of the examination. You are to find your allocated seat but </span><strong>do not </strong><span>turn over the question paper until instructed at the time of commencement of the examination.</span><br/></li></ul><p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Personal Belongings</span></u></b></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>Photography is not allowed in the examination hall at all </span><span>times.</span><br/></li><li><span>The University will not be responsible for the loss of any belongings in or outside the examination hal</span><br/></li></ul><p></p><p></p>',2,60,50,5,'2015-04-15 14:00:00',0,15,NULL,'2015-04-13 23:08:43','2015-04-15 06:27:32'),(4,'CS1010J Quiz 2',1,'<p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><span><strong>Please read these instructions carefully.</strong><span class=\"Apple-converted-space\"> </span>A candidate who breaches any of the Examination Regulations will be liable to disciplinary action<span class=\"Apple-converted-space\"> </span></span><span>including (but not limited to) suspension or expulsion from the university.</span><u><span></span></u><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Timings</span></u></b><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>The examination hall will be open for admission <b>10</b> minutes before the time scheduled for the commencement of the examination. You are to find your allocated seat but </span><strong>do not </strong><span>turn over the question paper until instructed at the time of commencement of the examination.</span><br/></li></ul><p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Personal Belongings</span></u></b></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>Photography is not allowed in the examination hall at all </span><span>times.</span><br/></li><li><span>The University will not be responsible for the loss of any belongings in or outside the examination hal</span><br/></li></ul><p></p><p></p>',2,60,40,4,'2015-04-19 15:00:00',0,15,NULL,'2015-04-13 23:08:43','2015-04-19 16:23:36');
/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examstates`
--

DROP TABLE IF EXISTS `examstates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `examstates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examstates`
--

LOCK TABLES `examstates` WRITE;
/*!40000 ALTER TABLE `examstates` DISABLE KEYS */;
INSERT INTO `examstates` VALUES (1,'draft','draft state','2015-04-19 16:05:55','2015-04-19 16:05:55'),(2,'active','active state','2015-04-19 16:05:55','2015-04-19 16:05:55'),(3,'published','grading finished, published to students','2015-04-19 16:05:55','2015-04-19 16:05:55'),(4,'expired','archived, no longer accessible','2015-04-19 16:05:55','2015-04-19 16:05:55');
/*!40000 ALTER TABLE `examstates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examsubmissions`
--

DROP TABLE IF EXISTS `examsubmissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `examsubmissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `exam_id` int(10) unsigned NOT NULL,
  `grader_id` int(10) unsigned DEFAULT NULL,
  `total_marks` int(11) NOT NULL DEFAULT '0',
  `submissionstate_id` int(10) unsigned NOT NULL DEFAULT '1',
  `comment` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `examsubmissions_user_id_foreign` (`user_id`),
  KEY `examsubmissions_exam_id_foreign` (`exam_id`),
  KEY `examsubmissions_grader_id_foreign` (`grader_id`),
  KEY `examsubmissions_submissionstate_id_foreign` (`submissionstate_id`),
  CONSTRAINT `examsubmissions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  CONSTRAINT `examsubmissions_grader_id_foreign` FOREIGN KEY (`grader_id`) REFERENCES `users` (`id`),
  CONSTRAINT `examsubmissions_submissionstate_id_foreign` FOREIGN KEY (`submissionstate_id`) REFERENCES `submissionstates` (`id`),
  CONSTRAINT `examsubmissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examsubmissions`
--

LOCK TABLES `examsubmissions` WRITE;
/*!40000 ALTER TABLE `examsubmissions` DISABLE KEYS */;
INSERT INTO `examsubmissions` VALUES (1,3,3,NULL,19,3,NULL,'2015-04-15 06:28:11','2015-04-19 16:15:28'),(2,4,3,NULL,15,3,NULL,'2015-04-15 06:38:46','2015-04-19 16:21:46'),(3,5,3,NULL,29,3,NULL,'2015-04-15 06:40:55','2015-04-19 16:19:52'),(4,7,3,NULL,16,3,NULL,'2015-04-15 06:42:06','2015-04-19 16:14:01'),(5,8,3,NULL,27,3,NULL,'2015-04-15 06:42:55','2015-04-19 16:17:17'),(6,9,3,NULL,26,3,NULL,'2015-04-15 06:43:42','2015-04-19 16:14:54'),(7,10,3,NULL,35,3,NULL,'2015-04-15 06:47:22','2015-04-19 16:14:20'),(8,13,3,NULL,25,3,NULL,'2015-04-15 06:48:31','2015-04-19 16:19:31'),(9,14,3,NULL,25,3,NULL,'2015-04-15 06:49:54','2015-04-19 16:19:11'),(10,15,3,NULL,15,3,NULL,'2015-04-15 06:50:45','2015-04-19 16:15:55'),(11,16,3,NULL,22,3,NULL,'2015-04-15 06:51:40','2015-04-19 16:18:13'),(12,17,3,NULL,33,3,NULL,'2015-04-15 06:52:35','2015-04-19 16:12:12'),(13,18,3,NULL,13,3,NULL,'2015-04-15 06:53:08','2015-04-19 16:22:08'),(14,19,3,NULL,20,3,NULL,'2015-04-15 06:53:47','2015-04-19 16:13:31'),(15,20,3,NULL,20,3,NULL,'2015-04-15 06:55:00','2015-04-19 16:15:11'),(16,21,3,NULL,17,3,NULL,'2015-04-15 06:55:35','2015-04-19 16:20:12'),(17,22,3,NULL,25,3,NULL,'2015-04-15 06:56:21','2015-04-19 16:21:04'),(18,23,3,NULL,33,3,NULL,'2015-04-15 06:56:54','2015-04-19 16:18:38'),(19,24,3,NULL,12,3,NULL,'2015-04-15 06:57:30','2015-04-19 16:20:41'),(20,25,3,NULL,39,3,NULL,'2015-04-15 06:58:02','2015-04-19 16:14:35'),(21,26,3,NULL,23,3,NULL,'2015-04-15 06:58:36','2015-04-19 16:12:33'),(22,27,3,NULL,41,3,NULL,'2015-04-15 06:59:05','2015-04-19 16:13:14'),(23,28,3,NULL,33,3,NULL,'2015-04-15 06:59:32','2015-04-19 16:11:54'),(24,5,4,NULL,0,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:05'),(25,6,4,NULL,0,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:25:06'),(26,7,4,NULL,0,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:18'),(27,8,4,NULL,0,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:16'),(28,9,4,NULL,0,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:28:22');
/*!40000 ALTER TABLE `examsubmissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci,
  `question_id` int(10) unsigned NOT NULL,
  `correctOption` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `options_question_id_foreign` (`question_id`),
  CONSTRAINT `options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (13,'Hello World',4,0,'2015-04-14 20:11:54','2015-04-14 20:35:49'),(14,'Hello',4,0,'2015-04-14 20:11:54','2015-04-14 20:35:49'),(15,'Hello World War',4,0,'2015-04-14 20:11:54','2015-04-14 20:35:49'),(16,'Compilation Error',4,1,'2015-04-14 20:11:54','2015-04-14 20:11:54'),(17,'Error: No case statement specified',28,0,'2015-04-15 00:55:54','2015-04-15 00:55:54'),(18,'Error: No default specified',28,1,'2015-04-15 00:55:54','2015-04-15 00:55:54'),(19,'No Error',28,0,'2015-04-15 00:55:54','2015-04-15 00:55:54'),(20,'Error: infinite loop occurs',28,0,'2015-04-15 00:55:54','2015-04-15 00:55:54'),(21,'x=31, y=502, z=502',29,0,'2015-04-15 00:59:07','2015-04-15 00:59:07'),(22,'x=31, y=500, z=500',29,1,'2015-04-15 00:59:07','2015-04-15 00:59:07'),(23,'x=31, y=498, z=498',29,0,'2015-04-15 00:59:07','2015-04-15 00:59:07'),(24,'x=31, y=504, z=504',29,0,'2015-04-15 00:59:07','2015-04-15 00:59:07'),(25,'The array int num[26]; can store 26 elements.',30,1,'2015-04-15 01:02:58','2015-04-15 01:02:58'),(26,'The expression num[1] designates the very first element in the array.',30,0,'2015-04-15 01:02:58','2015-04-15 01:02:58'),(27,'It is necessary to initialize the array at the time of declaration.',30,0,'2015-04-15 01:02:58','2015-04-15 01:02:58'),(28,'The declaration num[SIZE] is allowed if SIZE is a macro.',30,1,'2015-04-15 01:02:58','2015-04-15 01:02:58');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questiontype_id` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `compiler_enable` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'c',
  `marking_scheme` text COLLATE utf8_unicode_ci,
  `full_marks` int(11) NOT NULL DEFAULT '0',
  `suggested_answer` text COLLATE utf8_unicode_ci,
  `general_feedback` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `questions_questiontype_id_foreign` (`questiontype_id`),
  KEY `questions_course_id_foreign` (`course_id`),
  CONSTRAINT `questions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  CONSTRAINT `questions_questiontype_id_foreign` FOREIGN KEY (`questiontype_id`) REFERENCES `questiontypes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (4,1,1,'Java Syntax - Tracing','<p>What is the output of the following program?</p><p><br/></p><pre><code>public class HelloWorld {&#10;&#10;    public static void main(String[] args) {&#10;        System.out.println(&#34;Hello, World&#34;);&#10;    }&#10;&#10;}</code></pre><br/>',0,'c','',10,NULL,NULL,'2015-04-14 00:26:47','2015-04-14 23:50:45'),(13,4,1,'C Basics','<p>Please write your version of hello world in C.</p>',0,'c','Programs that fails compilation will lost half of the marks',10,NULL,NULL,'2015-04-14 23:54:25','2015-04-14 23:54:25'),(27,4,1,'Arrays','<p>Create a program that creates an array of five hard-coded floating-point values, then prints out just the second value.<br/></p>',0,'c',NULL,10,NULL,NULL,'2015-04-15 00:42:44','2015-04-15 00:42:44'),(28,1,1,'C Syntax - Detect Error','<p>Point out the error, if any in the program.</p><p><span id=\"selectionBoundary_1429096037107_8736632845830172\" class=\"rangySelectionBoundary\">&#65279;</span></p><pre><code>int main()&#10;{&#10;int a = 10;&#10;switch(a)&#10;{&#10;}&#10;printf(&#34;This is c program.&#34;);&#10;return 0;&#10;}</code></pre><br/><br/><p></p>',0,'c','MCQ auto graded',10,NULL,NULL,'2015-04-15 00:55:54','2015-04-15 03:27:32'),(29,1,1,'Pointers','<p>What will be the output of the following program?</p><p><br/></p><p></p><pre><code>int main()&#10;{&#10;    int x=30, *y, *z;&#10;    y=&amp;x; /* Assume address of x is 500 and integer is 4 byte size */&#10;    z=y;&#10;    *y++=*z++;&#10;    x++;&#10;    printf(&#34;x=%d, y=%d, z=%d\n&#34;, x, y, z);&#10;    return 0;&#10;}</code></pre><br/><br/><p></p>',0,'c',NULL,10,NULL,NULL,'2015-04-15 00:59:07','2015-04-19 16:23:33'),(30,2,1,'Array Concepts','<p>Which of the following statements are correct about an array? (You could select multiple answers)</p>',0,'c',NULL,15,NULL,NULL,'2015-04-15 01:02:58','2015-04-19 16:23:33'),(31,3,1,'C Concepts - Basic','<p>What is the keyword used to transfer control from a function back to the calling function?<br/></p>',0,'c','\'return\' gets full marks',5,NULL,NULL,'2015-04-15 01:04:40','2015-04-15 03:11:49');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionsubmissions`
--

DROP TABLE IF EXISTS `questionsubmissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionsubmissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `answer` text COLLATE utf8_unicode_ci,
  `question_id` int(10) unsigned NOT NULL,
  `examsubmission_id` int(10) unsigned NOT NULL,
  `marks_obtained` int(11) DEFAULT NULL,
  `submissionstate_id` int(10) unsigned NOT NULL DEFAULT '1',
  `comment` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `questionsubmissions_question_id_foreign` (`question_id`),
  KEY `questionsubmissions_examsubmission_id_foreign` (`examsubmission_id`),
  KEY `questionsubmissions_submissionstate_id_foreign` (`submissionstate_id`),
  CONSTRAINT `questionsubmissions_examsubmission_id_foreign` FOREIGN KEY (`examsubmission_id`) REFERENCES `examsubmissions` (`id`),
  CONSTRAINT `questionsubmissions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  CONSTRAINT `questionsubmissions_submissionstate_id_foreign` FOREIGN KEY (`submissionstate_id`) REFERENCES `submissionstates` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionsubmissions`
--

LOCK TABLES `questionsubmissions` WRITE;
/*!40000 ALTER TABLE `questionsubmissions` DISABLE KEYS */;
INSERT INTO `questionsubmissions` VALUES (1,'',4,1,0,3,'system automatic grading','2015-04-15 06:35:08','2015-04-19 16:11:25'),(2,'#include <std.io>\n\nint main(){\n    float * arr=[1.0,2.0,3.0,4.0,5.0];\n    printf(arr[1]);\n    return 0;\n}',27,1,2,3,NULL,'2015-04-15 06:37:41','2015-04-19 16:15:18'),(3,'',30,1,7,3,NULL,'2015-04-15 06:37:50','2015-04-19 16:15:24'),(4,'',28,1,10,3,'system automatic grading','2015-04-15 06:37:59','2015-04-19 16:11:25'),(5,'test',31,1,0,3,NULL,'2015-04-15 06:38:07','2015-04-19 16:15:28'),(6,'',4,2,0,3,'system automatic grading','2015-04-15 06:39:32','2015-04-19 16:11:25'),(7,'#include<stdio.h>\n\nmain()\n{\n    printf(\"The Second Value\");\n\n}',27,2,5,3,'Failed compilation','2015-04-15 06:40:16','2015-04-19 16:21:20'),(8,'',30,2,5,3,'One correct one wrong','2015-04-15 06:40:23','2015-04-19 16:21:40'),(9,'',28,2,0,3,'system automatic grading','2015-04-15 06:40:28','2015-04-19 16:11:25'),(10,'return',31,2,5,3,NULL,'2015-04-15 06:40:32','2015-04-19 16:21:46'),(11,NULL,4,3,10,3,'system automatic grading','2015-04-15 06:40:55','2015-04-19 16:11:25'),(12,'#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,3,7,3,NULL,'2015-04-15 06:40:55','2015-04-19 16:19:38'),(13,NULL,30,3,7,3,NULL,'2015-04-15 06:40:55','2015-04-19 16:19:48'),(14,NULL,28,3,0,3,'system automatic grading','2015-04-15 06:40:55','2015-04-19 16:11:25'),(15,'return',31,3,5,3,NULL,'2015-04-15 06:40:55','2015-04-19 16:19:52'),(16,NULL,4,4,10,3,'system automatic grading','2015-04-15 06:42:06','2015-04-19 16:11:25'),(17,'#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,4,6,3,NULL,'2015-04-15 06:42:06','2015-04-19 16:13:44'),(18,NULL,30,4,0,3,NULL,'2015-04-15 06:42:06','2015-04-19 16:13:56'),(19,NULL,28,4,0,3,'system automatic grading','2015-04-15 06:42:06','2015-04-19 16:11:25'),(20,'return',31,4,0,3,NULL,'2015-04-15 06:42:06','2015-04-19 16:14:01'),(21,NULL,4,5,10,3,'system automatic grading','2015-04-15 06:42:55','2015-04-19 16:11:25'),(22,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,5,5,3,'Failed Compilation','2015-04-15 06:42:55','2015-04-19 16:16:54'),(23,NULL,30,5,7,3,'One correct one wrong','2015-04-15 06:42:55','2015-04-19 16:17:08'),(24,NULL,28,5,0,3,'system automatic grading','2015-04-15 06:42:55','2015-04-19 16:11:25'),(25,'return',31,5,5,3,'correct!','2015-04-15 06:42:55','2015-04-19 16:17:17'),(26,NULL,4,6,0,3,'system automatic grading','2015-04-15 06:43:42','2015-04-19 16:11:25'),(27,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,6,6,3,NULL,'2015-04-15 06:43:42','2015-04-19 16:14:42'),(28,NULL,30,6,15,3,NULL,'2015-04-15 06:43:42','2015-04-19 16:14:48'),(29,NULL,28,6,0,3,'system automatic grading','2015-04-15 06:43:42','2015-04-19 16:11:25'),(30,'RETURN',31,6,5,3,NULL,'2015-04-15 06:43:42','2015-04-19 16:14:54'),(31,NULL,4,7,0,3,'system automatic grading','2015-04-15 06:47:22','2015-04-19 16:11:25'),(32,'#include<stdio.h>\n#include<conio.h>\nvoid main() {\n   int numArray[10];\n   int i, sum = 0;\n   int *ptr;\n \n   printf(\"\nEnter 10 elements : \");\n \n   for (i = 0; i < 10; i++)\n      scanf(\"%d\", &numArray[i]);\n \n   ptr = numArray; /* a=&a[0] */\n \n   for (i = 0; i < 10; i++) {\n      sum = sum + *ptr;\n      ptr++;\n   }\n \n   printf(\"The sum of array elements : %d\", sum);\n}',27,7,8,3,NULL,'2015-04-15 06:47:22','2015-04-19 16:14:08'),(33,NULL,30,7,12,3,NULL,'2015-04-15 06:47:22','2015-04-19 16:14:14'),(34,NULL,28,7,10,3,'system automatic grading','2015-04-15 06:47:22','2015-04-19 16:11:25'),(35,'return',31,7,5,3,NULL,'2015-04-15 06:47:22','2015-04-19 16:14:20'),(36,NULL,4,8,0,3,'system automatic grading','2015-04-15 06:48:31','2015-04-19 16:11:25'),(37,'\n2\n3\n4\n5\n6\n7\n8\n9\n10\n11\n12\n13\n14\n15\n16\n17\n18\n19\n20\n21\n#include<stdio.h>\n \nint main() {\n   int i, arr[50], num;\n \n   printf(\"\nEnter no of elements :\");\n   scanf(\"%d\", &num);\n \n   //Reading values into Array\n   printf(\"\nEnter the values :\");\n   for (i = 0; i < num; i++) {\n      scanf(\"%d\", &arr[i]);\n   }\n \n   //Printing of all elements of array\n   for (i = 0; i < num; i++) {\n      printf(\"\narr[%d] = %d\", i, arr[i]);\n   }\n \n   return (0);\n}',27,8,0,3,NULL,'2015-04-15 06:48:31','2015-04-19 16:19:21'),(38,NULL,30,8,10,3,NULL,'2015-04-15 06:48:31','2015-04-19 16:19:27'),(39,NULL,28,8,10,3,'system automatic grading','2015-04-15 06:48:31','2015-04-19 16:11:25'),(40,'RETURN',31,8,5,3,NULL,'2015-04-15 06:48:31','2015-04-19 16:19:31'),(41,NULL,4,9,0,3,'system automatic grading','2015-04-15 06:49:54','2015-04-19 16:11:25'),(42,'#include<stdio.h>\n \nint main() {\n   int i, arr[50], num;\n \n   printf(\"\nEnter no of elements :\");\n   scanf(\"%d\", &num);\n \n   //Reading values into Array\n   printf(\"\nEnter the values :\");\n   for (i = 0; i < num; i++) {\n      scanf(\"%d\", &arr[i]);\n   }\n \n   //Printing of all elements of array\n   for (i = 0; i < num; i++) {\n      printf(\"\narr[%d] = %d\", i, arr[i]);\n   }\n \n   return (0);\n}',27,9,10,3,NULL,'2015-04-15 06:49:54','2015-04-19 16:18:58'),(43,NULL,30,9,10,3,NULL,'2015-04-15 06:49:54','2015-04-19 16:19:06'),(44,NULL,28,9,0,3,'system automatic grading','2015-04-15 06:49:54','2015-04-19 16:11:25'),(45,'break',31,9,5,3,NULL,'2015-04-15 06:49:54','2015-04-19 16:19:11'),(46,NULL,4,10,0,3,'system automatic grading','2015-04-15 06:50:45','2015-04-19 16:11:25'),(47,'#include<stdio.h>\n \nint main() {\n   int i, arr[50], num;\n \n   printf(\"\nEnter no of elements :\");\n   scanf(\"%d\", &num);\n \n   //Reading values into Array\n   printf(\"\nEnter the values :\");\n   for (i = 0; i < num; i++) {\n      scanf(\"%d\", &arr[i]);\n   }\n \n   //Printing of all elements of array\n   for (i = 0; i < num; i++) {\n      printf(\"\narr[%d] = %d\", i, arr[i]);\n   }\n \n   return (0);\n}',27,10,5,3,NULL,'2015-04-15 06:50:45','2015-04-19 16:15:42'),(48,NULL,30,10,10,3,NULL,'2015-04-15 06:50:45','2015-04-19 16:15:49'),(49,NULL,28,10,0,3,'system automatic grading','2015-04-15 06:50:45','2015-04-19 16:11:25'),(50,'goto',31,10,0,3,NULL,'2015-04-15 06:50:45','2015-04-19 16:15:55'),(51,NULL,4,11,0,3,'system automatic grading','2015-04-15 06:51:40','2015-04-19 16:11:25'),(52,'#include<stdio.h>\n \nint main() {\n   int arr1[30], arr2[30], i, num;\n \n   printf(\"\nEnter no of elements :\");\n   scanf(\"%d\", &num);\n \n   //Accepting values into Array\n   printf(\"\nEnter the values :\");\n   for (i = 0; i < num; i++) {\n      scanf(\"%d\", &arr1[i]);\n   }\n \n   /* Copying data from array \'a\' to array \'b */\n   for (i = 0; i < num; i++) {\n      arr2[i] = arr1[i];\n   }\n \n   //Printing of all elements of array\n   printf(\"The copied array is :\");\n   for (i = 0; i < num; i++)\n      printf(\"\narr2[%d] = %d\", i, arr2[i]);\n \n   return (0);\n}',27,11,7,3,NULL,'2015-04-15 06:51:40','2015-04-19 16:17:57'),(53,NULL,30,11,10,3,'one missing','2015-04-15 06:51:40','2015-04-19 16:18:08'),(54,NULL,28,11,0,3,'system automatic grading','2015-04-15 06:51:40','2015-04-19 16:11:25'),(55,'Return;',31,11,5,3,NULL,'2015-04-15 06:51:40','2015-04-19 16:18:13'),(56,NULL,4,12,0,3,'system automatic grading','2015-04-15 06:52:35','2015-04-19 16:11:25'),(57,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,12,8,3,NULL,'2015-04-15 06:52:35','2015-04-19 16:12:12'),(58,NULL,30,12,10,3,NULL,'2015-04-15 06:52:35','2015-04-19 16:12:10'),(59,NULL,28,12,10,3,'system automatic grading','2015-04-15 06:52:35','2015-04-19 16:11:25'),(60,'rerturn',31,12,5,3,NULL,'2015-04-15 06:52:35','2015-04-19 16:12:08'),(61,NULL,4,13,0,3,'system automatic grading','2015-04-15 06:53:08','2015-04-19 16:11:25'),(62,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,13,0,3,NULL,'2015-04-15 06:53:08','2015-04-19 16:21:54'),(63,NULL,30,13,0,3,NULL,'2015-04-15 06:53:08','2015-04-19 16:21:59'),(64,NULL,28,13,10,3,'system automatic grading','2015-04-15 06:53:08','2015-04-19 16:11:25'),(65,'Returb',31,13,3,3,'spelling error','2015-04-15 06:53:08','2015-04-19 16:22:08'),(66,NULL,4,14,0,3,'system automatic grading','2015-04-15 06:53:47','2015-04-19 16:11:25'),(67,'#include<stdio.h>\n#include<stdlib.h>\n \nint main() {\n   int num;\n   char marks[3];\n \n   printf(\"Please Enter Marks : \");\n   scanf(\"%s\", marks);\n \n   num = atoi(marks);\n   printf(\"\nMarks : %d\", num);\n \n   return (0);\n}',27,14,6,3,NULL,'2015-04-15 06:53:47','2015-04-19 16:13:20'),(68,NULL,30,14,10,3,NULL,'2015-04-15 06:53:47','2015-04-19 16:13:27'),(69,NULL,28,14,0,3,'system automatic grading','2015-04-15 06:53:47','2015-04-19 16:11:25'),(70,'break',31,14,4,3,NULL,'2015-04-15 06:53:47','2015-04-19 16:13:31'),(71,NULL,4,15,0,3,'system automatic grading','2015-04-15 06:55:00','2015-04-19 16:11:25'),(72,'#include<stdio.h>\n#include<stdlib.h>\n \nint main() {\n   int num;\n   char marks[3];\n \n   printf(\"Please Enter Marks : \");\n   scanf(\"%s\", marks);\n \n   num = atoi(marks);\n   printf(\"\nMarks : %d\", num);\n \n   return (0);\n}',27,15,10,3,NULL,'2015-04-15 06:55:00','2015-04-19 16:15:01'),(73,NULL,30,15,5,3,NULL,'2015-04-15 06:55:00','2015-04-19 16:15:07'),(74,NULL,28,15,0,3,'system automatic grading','2015-04-15 06:55:00','2015-04-19 16:11:25'),(75,'return',31,15,5,3,NULL,'2015-04-15 06:55:00','2015-04-19 16:15:11'),(76,NULL,4,16,0,3,'system automatic grading','2015-04-15 06:55:35','2015-04-19 16:11:25'),(77,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,16,5,3,NULL,'2015-04-15 06:55:35','2015-04-19 16:20:03'),(78,NULL,30,16,12,3,NULL,'2015-04-15 06:55:35','2015-04-19 16:20:08'),(79,NULL,28,16,0,3,'system automatic grading','2015-04-15 06:55:35','2015-04-19 16:11:25'),(80,'switch',31,16,0,3,NULL,'2015-04-15 06:55:35','2015-04-19 16:20:12'),(81,NULL,4,17,0,3,'system automatic grading','2015-04-15 06:56:21','2015-04-19 16:11:25'),(82,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,17,5,3,NULL,'2015-04-15 06:56:21','2015-04-19 16:20:57'),(83,NULL,30,17,5,3,NULL,'2015-04-15 06:56:21','2015-04-19 16:21:00'),(84,NULL,28,17,10,3,'system automatic grading','2015-04-15 06:56:21','2015-04-19 16:11:25'),(85,'return',31,17,5,3,NULL,'2015-04-15 06:56:21','2015-04-19 16:21:04'),(86,NULL,4,18,0,3,'system automatic grading','2015-04-15 06:56:54','2015-04-19 16:11:25'),(87,'#include<stdio.h>\n#include<stdlib.h>\n \nint main() {\n   int num;\n   char marks[3];\n \n   printf(\"Please Enter Marks : \");\n   scanf(\"%s\", marks);\n \n   num = atoi(marks);\n   printf(\"\nMarks : %d\", num);\n \n   return (0);\n}',27,18,8,3,NULL,'2015-04-15 06:56:54','2015-04-19 16:18:27'),(88,NULL,30,18,10,3,NULL,'2015-04-15 06:56:54','2015-04-19 16:18:33'),(89,NULL,28,18,10,3,'system automatic grading','2015-04-15 06:56:54','2015-04-19 16:11:25'),(90,'test',31,18,5,3,NULL,'2015-04-15 06:56:54','2015-04-19 16:18:38'),(91,NULL,4,19,0,3,'system automatic grading','2015-04-15 06:57:30','2015-04-19 16:11:25'),(92,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,19,7,3,NULL,'2015-04-15 06:57:30','2015-04-19 16:20:24'),(93,NULL,30,19,0,3,NULL,'2015-04-15 06:57:30','2015-04-19 16:20:32'),(94,NULL,28,19,0,3,'system automatic grading','2015-04-15 06:57:30','2015-04-19 16:11:25'),(95,'return',31,19,5,3,NULL,'2015-04-15 06:57:30','2015-04-19 16:20:41'),(96,NULL,4,20,10,3,'system automatic grading','2015-04-15 06:58:02','2015-04-19 16:11:25'),(97,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,20,8,3,NULL,'2015-04-15 06:58:02','2015-04-19 16:14:26'),(98,NULL,30,20,8,3,NULL,'2015-04-15 06:58:02','2015-04-19 16:14:31'),(99,NULL,28,20,10,3,'system automatic grading','2015-04-15 06:58:02','2015-04-19 16:11:25'),(100,'return',31,20,3,3,NULL,'2015-04-15 06:58:02','2015-04-19 16:14:35'),(101,NULL,4,21,0,3,'system automatic grading','2015-04-15 06:58:36','2015-04-19 16:11:25'),(102,'#include<stdio.h>\n#include<stdlib.h>\n \nint main() {\n   int num;\n   char marks[3];\n \n   printf(\"Please Enter Marks : \");\n   scanf(\"%s\", marks);\n \n   num = atoi(marks);\n   printf(\"\nMarks : %d\", num);\n \n   return (0);\n}',27,21,10,3,NULL,'2015-04-15 06:58:36','2015-04-19 16:12:19'),(103,NULL,30,21,10,3,NULL,'2015-04-15 06:58:36','2015-04-19 16:12:26'),(104,NULL,28,21,0,3,'system automatic grading','2015-04-15 06:58:36','2015-04-19 16:11:25'),(105,'return',31,21,3,3,NULL,'2015-04-15 06:58:36','2015-04-19 16:12:33'),(106,NULL,4,22,10,3,'system automatic grading','2015-04-15 06:59:05','2015-04-19 16:11:25'),(107,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,22,10,3,NULL,'2015-04-15 06:59:05','2015-04-19 16:12:56'),(108,NULL,30,22,6,3,NULL,'2015-04-15 06:59:05','2015-04-19 16:13:06'),(109,NULL,28,22,10,3,'system automatic grading','2015-04-15 06:59:05','2015-04-19 16:11:25'),(110,'return',31,22,5,3,NULL,'2015-04-15 06:59:05','2015-04-19 16:13:14'),(111,NULL,4,23,10,3,'system automatic grading','2015-04-15 06:59:32','2015-04-19 16:11:25'),(112,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,23,10,3,NULL,'2015-04-15 06:59:32','2015-04-19 16:11:42'),(113,NULL,30,23,8,3,NULL,'2015-04-15 06:59:32','2015-04-19 16:11:49'),(114,NULL,28,23,0,3,'system automatic grading','2015-04-15 06:59:32','2015-04-19 16:11:25'),(115,'return',31,23,5,3,NULL,'2015-04-15 06:59:32','2015-04-19 16:11:54'),(116,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\")\n\n}',13,24,NULL,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:32'),(117,NULL,29,24,NULL,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:05'),(118,NULL,30,24,NULL,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:05'),(119,'return',31,24,NULL,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:55'),(120,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',13,25,NULL,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:25:45'),(121,NULL,29,25,NULL,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:25:06'),(122,NULL,30,25,NULL,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:25:06'),(123,'switch',31,25,NULL,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:26:01'),(124,'/* Hello World program */\n\n#include<stdio.h>\n\nint main()\n{\n    printf(\"Hello World\");\n\n}',13,26,NULL,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:44'),(125,NULL,29,26,NULL,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:18'),(126,NULL,30,26,NULL,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:18'),(127,'return',31,26,NULL,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:56'),(128,'/* Hello World program */\n\n#include<stdio.h>\n\nint main()\n{\n    printf(\"Hello World\")\n\n}',13,27,NULL,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:46'),(129,NULL,29,27,NULL,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:16'),(130,NULL,30,27,NULL,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:16'),(131,'return',31,27,NULL,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:58'),(132,'/* Hello World program */\n\n#include<stdio.h>\n\nint main()\n{\n    printf(\"Hello World War\");\n\n}',13,28,NULL,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:28:52'),(133,NULL,29,28,NULL,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:28:22'),(134,NULL,30,28,NULL,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:28:22'),(135,'goto',31,28,NULL,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:29:05');
/*!40000 ALTER TABLE `questionsubmissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questiontypes`
--

DROP TABLE IF EXISTS `questiontypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questiontypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questiontypes`
--

LOCK TABLES `questiontypes` WRITE;
/*!40000 ALTER TABLE `questiontypes` DISABLE KEYS */;
INSERT INTO `questiontypes` VALUES (1,'MCQ','Multiple Choice Questions','2015-04-19 16:05:55','2015-04-19 16:05:55'),(2,'MRQ','Multiple Response Questions','2015-04-19 16:05:55','2015-04-19 16:05:55'),(3,'Short Answer Question','short answer questions, can be coding or non-coding','2015-04-19 16:05:55','2015-04-19 16:05:55'),(4,'Coding Question','Requires coding in student responses','2015-04-19 16:05:55','2015-04-19 16:05:55');
/*!40000 ALTER TABLE `questiontypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','administrator of the course','2015-04-19 16:05:55','2015-04-19 16:05:55'),(2,'facilitator','facilitator of the course','2015-04-19 16:05:55','2015-04-19 16:05:55'),(3,'student','student of the course','2015-04-19 16:05:55','2015-04-19 16:05:55');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `selected_options`
--

DROP TABLE IF EXISTS `selected_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `selected_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option_id` int(10) unsigned NOT NULL,
  `qnsubmission_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `selected_options_option_id_foreign` (`option_id`),
  KEY `selected_options_qnsubmission_id_foreign` (`qnsubmission_id`),
  CONSTRAINT `selected_options_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`),
  CONSTRAINT `selected_options_qnsubmission_id_foreign` FOREIGN KEY (`qnsubmission_id`) REFERENCES `questionsubmissions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `selected_options`
--

LOCK TABLES `selected_options` WRITE;
/*!40000 ALTER TABLE `selected_options` DISABLE KEYS */;
INSERT INTO `selected_options` VALUES (2,25,3,'2015-04-15 06:37:50','2015-04-15 06:37:50'),(3,26,3,'2015-04-15 06:37:50','2015-04-15 06:37:50'),(4,18,4,'2015-04-15 06:37:59','2015-04-15 06:37:59'),(5,14,1,'2015-04-15 06:38:17','2015-04-15 06:38:17'),(7,26,8,'2015-04-15 06:40:23','2015-04-15 06:40:23'),(8,27,8,'2015-04-15 06:40:23','2015-04-15 06:40:23'),(9,28,8,'2015-04-15 06:40:23','2015-04-15 06:40:23'),(10,19,9,'2015-04-15 06:40:28','2015-04-15 06:40:28'),(11,15,6,'2015-04-15 06:40:41','2015-04-15 06:40:41'),(12,16,11,'2015-04-15 06:41:00','2015-04-15 06:41:00'),(13,25,13,'2015-04-15 06:41:31','2015-04-15 06:41:31'),(14,27,13,'2015-04-15 06:41:31','2015-04-15 06:41:31'),(15,17,14,'2015-04-15 06:41:35','2015-04-15 06:41:35'),(17,26,18,'2015-04-15 06:42:25','2015-04-15 06:42:25'),(18,25,18,'2015-04-15 06:42:25','2015-04-15 06:42:25'),(19,27,18,'2015-04-15 06:42:25','2015-04-15 06:42:25'),(20,28,18,'2015-04-15 06:42:25','2015-04-15 06:42:25'),(21,19,19,'2015-04-15 06:42:29','2015-04-15 06:42:29'),(22,16,16,'2015-04-15 06:42:40','2015-04-15 06:42:40'),(23,16,21,'2015-04-15 06:43:07','2015-04-15 06:43:07'),(24,26,23,'2015-04-15 06:43:22','2015-04-15 06:43:22'),(25,28,23,'2015-04-15 06:43:22','2015-04-15 06:43:22'),(26,17,24,'2015-04-15 06:43:25','2015-04-15 06:43:25'),(27,13,26,'2015-04-15 06:45:36','2015-04-15 06:45:36'),(28,25,28,'2015-04-15 06:45:46','2015-04-15 06:45:46'),(29,26,28,'2015-04-15 06:45:46','2015-04-15 06:45:46'),(30,19,29,'2015-04-15 06:45:49','2015-04-15 06:45:49'),(31,14,31,'2015-04-15 06:47:27','2015-04-15 06:47:27'),(32,25,33,'2015-04-15 06:48:09','2015-04-15 06:48:09'),(33,27,33,'2015-04-15 06:48:09','2015-04-15 06:48:09'),(34,18,34,'2015-04-15 06:48:12','2015-04-15 06:48:12'),(35,13,36,'2015-04-15 06:48:36','2015-04-15 06:48:36'),(36,25,38,'2015-04-15 06:49:36','2015-04-15 06:49:36'),(37,18,39,'2015-04-15 06:49:39','2015-04-15 06:49:39'),(38,13,41,'2015-04-15 06:50:00','2015-04-15 06:50:00'),(39,25,43,'2015-04-15 06:50:26','2015-04-15 06:50:26'),(40,27,43,'2015-04-15 06:50:26','2015-04-15 06:50:26'),(41,19,44,'2015-04-15 06:50:28','2015-04-15 06:50:28'),(42,13,46,'2015-04-15 06:50:49','2015-04-15 06:50:49'),(43,25,48,'2015-04-15 06:51:14','2015-04-15 06:51:14'),(44,17,49,'2015-04-15 06:51:19','2015-04-15 06:51:19'),(45,13,51,'2015-04-15 06:51:43','2015-04-15 06:51:43'),(46,25,53,'2015-04-15 06:52:14','2015-04-15 06:52:14'),(47,20,54,'2015-04-15 06:52:18','2015-04-15 06:52:18'),(48,13,56,'2015-04-15 06:52:38','2015-04-15 06:52:38'),(49,25,58,'2015-04-15 06:52:48','2015-04-15 06:52:48'),(50,18,59,'2015-04-15 06:52:51','2015-04-15 06:52:51'),(51,13,61,'2015-04-15 06:53:12','2015-04-15 06:53:12'),(52,26,63,'2015-04-15 06:53:20','2015-04-15 06:53:20'),(53,18,64,'2015-04-15 06:53:24','2015-04-15 06:53:24'),(54,13,66,'2015-04-15 06:53:54','2015-04-15 06:53:54'),(55,26,68,'2015-04-15 06:54:34','2015-04-15 06:54:34'),(56,17,69,'2015-04-15 06:54:37','2015-04-15 06:54:37'),(57,14,71,'2015-04-15 06:55:05','2015-04-15 06:55:05'),(58,27,73,'2015-04-15 06:55:14','2015-04-15 06:55:14'),(59,28,73,'2015-04-15 06:55:14','2015-04-15 06:55:14'),(60,19,74,'2015-04-15 06:55:17','2015-04-15 06:55:17'),(62,27,78,'2015-04-15 06:55:49','2015-04-15 06:55:49'),(63,17,79,'2015-04-15 06:55:55','2015-04-15 06:55:55'),(64,13,76,'2015-04-15 06:56:10','2015-04-15 06:56:10'),(65,13,81,'2015-04-15 06:56:24','2015-04-15 06:56:24'),(66,25,83,'2015-04-15 06:56:33','2015-04-15 06:56:33'),(67,18,84,'2015-04-15 06:56:37','2015-04-15 06:56:37'),(68,14,86,'2015-04-15 06:56:58','2015-04-15 06:56:58'),(69,26,88,'2015-04-15 06:57:08','2015-04-15 06:57:08'),(70,18,89,'2015-04-15 06:57:11','2015-04-15 06:57:11'),(71,13,91,'2015-04-15 06:57:33','2015-04-15 06:57:33'),(72,26,93,'2015-04-15 06:57:43','2015-04-15 06:57:43'),(73,27,93,'2015-04-15 06:57:43','2015-04-15 06:57:43'),(74,17,94,'2015-04-15 06:57:48','2015-04-15 06:57:48'),(75,16,96,'2015-04-15 06:58:06','2015-04-15 06:58:06'),(76,26,98,'2015-04-15 06:58:16','2015-04-15 06:58:16'),(77,18,99,'2015-04-15 06:58:20','2015-04-15 06:58:20'),(78,14,101,'2015-04-15 06:58:42','2015-04-15 06:58:42'),(79,26,103,'2015-04-15 06:58:49','2015-04-15 06:58:49'),(80,19,104,'2015-04-15 06:58:52','2015-04-15 06:58:52'),(81,16,106,'2015-04-15 06:59:09','2015-04-15 06:59:09'),(82,25,108,'2015-04-15 06:59:16','2015-04-15 06:59:16'),(83,18,109,'2015-04-15 06:59:20','2015-04-15 06:59:20'),(84,16,111,'2015-04-15 06:59:37','2015-04-15 06:59:37'),(85,27,113,'2015-04-15 06:59:46','2015-04-15 06:59:46'),(86,19,114,'2015-04-15 06:59:49','2015-04-15 06:59:49'),(87,22,117,'2015-04-19 16:24:44','2015-04-19 16:24:44'),(88,25,118,'2015-04-19 16:24:49','2015-04-19 16:24:49'),(89,27,118,'2015-04-19 16:24:49','2015-04-19 16:24:49'),(90,22,121,'2015-04-19 16:25:48','2015-04-19 16:25:48'),(92,26,122,'2015-04-19 16:26:02','2015-04-19 16:26:02'),(93,22,125,'2015-04-19 16:26:47','2015-04-19 16:26:47'),(94,25,126,'2015-04-19 16:26:52','2015-04-19 16:26:52'),(95,27,126,'2015-04-19 16:26:52','2015-04-19 16:26:52'),(96,21,129,'2015-04-19 16:27:49','2015-04-19 16:27:49'),(99,26,130,'2015-04-19 16:28:00','2015-04-19 16:28:00'),(100,28,130,'2015-04-19 16:28:00','2015-04-19 16:28:00'),(101,21,133,'2015-04-19 16:28:56','2015-04-19 16:28:56'),(102,27,134,'2015-04-19 16:28:59','2015-04-19 16:28:59'),(103,28,134,'2015-04-19 16:28:59','2015-04-19 16:28:59');
/*!40000 ALTER TABLE `selected_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submissionstates`
--

DROP TABLE IF EXISTS `submissionstates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `submissionstates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submissionstates`
--

LOCK TABLES `submissionstates` WRITE;
/*!40000 ALTER TABLE `submissionstates` DISABLE KEYS */;
INSERT INTO `submissionstates` VALUES (1,'submitted','grading not started','2015-04-19 16:05:55','2015-04-19 16:05:55'),(2,'grading','grading in progress','2015-04-19 16:05:55','2015-04-19 16:05:55'),(3,'graded','grading finished','2015-04-19 16:05:55','2015-04-19 16:05:55');
/*!40000 ALTER TABLE `submissionstates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nus_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Lingyi','A000',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'Scott','A1234567',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'Idola','Z5227052',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'Emily','T6887776',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'Nayda','J8330385',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'Ronan','P3228996',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'Leandra','N6273104',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,'Chiquita','B5218601',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,'Ahmed','A5997942',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(10,'Deanna','K3116209',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,'Jolene','Q2184929',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,'Hakeem','Y4379818',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,'Drew','Q9031617',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,'Dai','F9219556',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,'David','S7065308',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(16,'Francesca','G6212075',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(17,'Blossom','E1550349',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(18,'Kim','D3343836',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(19,'Tarik','X0449702',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(20,'Dane','X7908301',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(21,'Willa','V6125436',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(22,'Hanae','F4381616',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(23,'Dennis','W0411519',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(24,'Britanney','J0176270',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(25,'Emmanuel','Y0120262',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(26,'Armando','Z7224521',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(27,'Hayfa','X7316038',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(28,'Wesley','L6374975',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(29,'Sara','S0352486',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(30,'Yardley','C6903709',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(31,'Nathaniel','J8527911',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(32,'Germaine','O8199520',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(33,'Ciara','N9485065',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(34,'Giselle','X0692904',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(35,'Regina','T3533662',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(36,'Ryder','N8527801',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(37,'Drake','G8809986',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(38,'Geraldine','B4224835',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(39,'Plato','H8042528',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(40,'Geraldine','L1829030',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(41,'Uriel','C3040232',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(42,'Rudyard','I1731841',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(43,'Alvin','P7044310',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(44,'Joel','B0912160',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(45,'Zeph','Z8459276',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(46,'Morgan','U4016411',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(47,'Ralph','P0445880',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(48,'Hu','X3497604',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(49,'Winifred','T3100718',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(50,'Noelle','I2009791',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00');
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

-- Dump completed on 2015-04-20  0:33:08
