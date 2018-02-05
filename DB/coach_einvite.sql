-- MySQL dump 10.13  Distrib 5.6.19, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: coach_einvite
-- ------------------------------------------------------
-- Server version	5.6.19-0ubuntu0.14.04.4

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
-- Table structure for table `coach_award`
--

DROP TABLE IF EXISTS `coach_award`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coach_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL,
  `awardcode` varchar(100) DEFAULT NULL,
  `callnumber` varchar(50) DEFAULT NULL,
  `memname` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT '',
  `sex` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '性别，0未定义，1男，2女',
  `guide` varchar(50) DEFAULT NULL,
  `meettime` enum('1','2') NOT NULL DEFAULT '1' COMMENT '用户场次.1,1.30，2,3.30',
  `meet1status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '13.30进场状态.0,没有进入.1,已经进入',
  `meet2status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '15.30进场状态.0,没有进入.1,已经进入',
  `dinnerstatus` enum('0','1') NOT NULL DEFAULT '0' COMMENT '晚宴状态.0,没有进入.1,已经进入',
  `inmeettime` varchar(50) DEFAULT NULL,
  `indinnertime` varchar(50) DEFAULT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coach_award`
--

LOCK TABLES `coach_award` WRITE;
/*!40000 ALTER TABLE `coach_award` DISABLE KEYS */;
-- INSERT INTO `coach_award` VALUES (1,'','','18516180500','2016-10-13 04:32:06'),(2,'','','18516180507','2016-10-13 04:32:20'),(3,NULL,NULL,'18516180506','2016-10-13 06:23:16'),(4,NULL,NULL,'18516180505','2016-10-13 06:23:26'),(5,NULL,NULL,'18516180504','2016-10-13 06:23:32'),(6,NULL,NULL,'18516180503','2016-10-13 06:23:40'),(7,NULL,NULL,'18516180502','2016-10-13 06:23:45'),(8,NULL,NULL,'18516180501','2016-10-13 06:23:52');
/*!40000 ALTER TABLE `coach_award` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coach_userinfo`
--

DROP TABLE IF EXISTS `coach_userinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coach_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `userhandurl` varchar(500) DEFAULT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coach_userinfo`
--

LOCK TABLES `coach_userinfo` WRITE;
/*!40000 ALTER TABLE `coach_userinfo` DISABLE KEYS */;
INSERT INTO `coach_userinfo` VALUES (2,'wwssssssssssssssssadawdawad','nickname','http://test.com/asdasdawdawdawdawdawdawdawd',2,'2016-10-13 05:42:33');
/*!40000 ALTER TABLE `coach_userinfo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-13  6:24:43
DROP TABLE IF EXISTS `coach_trytimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coach_trytimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL,
  `trytimes` int(3) DEFAULT '0',
  `city` varchar(50) DEFAULT '',
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
