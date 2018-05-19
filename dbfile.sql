CREATE DATABASE  IF NOT EXISTS `poloniexbot` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `poloniexbot`;
-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: poloniexbot
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

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
-- Table structure for table `login_info`
--

DROP TABLE IF EXISTS `login_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_info`
--

LOCK TABLES `login_info` WRITE;
/*!40000 ALTER TABLE `login_info` DISABLE KEYS */;
INSERT INTO `login_info` VALUES (1,'usr@gmail.com','$2y$10$rDbGORLkDnZR6fxrqPy4DOuvvLS1K12L/CKN/vv7O..kfOiJOfqBu',1),(2,'usr2@gmail.com','$2y$10$rDbGORLkDnZR6fxrqPy4DOuvvLS1K12L/CKN/vv7O..kfOiJOfqBu',1);
/*!40000 ALTER TABLE `login_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poloniex_buy_orders`
--

DROP TABLE IF EXISTS `poloniex_buy_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poloniex_buy_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ordernumber` varchar(45) DEFAULT NULL,
  `currencypair` varchar(45) DEFAULT NULL,
  `amount` varchar(45) DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `total` varchar(45) DEFAULT NULL,
  `tradeid` varchar(45) DEFAULT NULL,
  `active` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poloniex_buy_orders`
--

LOCK TABLES `poloniex_buy_orders` WRITE;
/*!40000 ALTER TABLE `poloniex_buy_orders` DISABLE KEYS */;
INSERT INTO `poloniex_buy_orders` VALUES (1,0,'23180226582','BTC_BTCD','0.05972513',0.15495618,'2018-04-28 14:29:28',0.0122287,'0.00073036','1715876','2'),(2,0,'23180226582','BTC_BTCD','0.09561940',0.15495618,'2018-04-28 14:29:28',0.0123878,'0.00118451','1715877','2'),(3,0,'18532636982','BTC_SBD','5.29783521',5.28459063,'2018-05-01 00:49:39',0.00036213,'0.00191850','900385','2'),(4,0,'9186018793','BTC_BCN','2853.42835820',2846.29478731,'2018-05-03 06:04:27',0.00000067,'0.00191179','2504506','2'),(5,0,'23317766996','BTC_XBC','0.11617282',0.11588239,'2018-05-03 19:28:30',0.00770082,'0.00089462','1160646','2'),(6,0,'11812061158','BTC_HUC','113.39597871',113.11248877,'2018-05-03 23:53:28',0.00001691,'0.00191752','752593','2'),(7,0,'17474922598','BTC_BTM','23.64184923',23.58274461,'2018-05-04 06:29:29',0.00008079,'0.00191002','777289','2'),(8,0,'43533911673','BTC_DCR','0.16449980',0.16408856,'2018-05-04 06:54:27',0.01045,'0.00171902','2531803','2');
/*!40000 ALTER TABLE `poloniex_buy_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poloniex_sell_orders`
--

DROP TABLE IF EXISTS `poloniex_sell_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poloniex_sell_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ordernumber` varchar(45) DEFAULT NULL,
  `currencypair` varchar(45) DEFAULT NULL,
  `amount` varchar(45) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `total` varchar(45) DEFAULT NULL,
  `tradeid` varchar(45) DEFAULT NULL,
  `active` char(1) DEFAULT '1',
  `buy_order_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poloniex_sell_orders`
--

LOCK TABLES `poloniex_sell_orders` WRITE;
/*!40000 ALTER TABLE `poloniex_sell_orders` DISABLE KEYS */;
INSERT INTO `poloniex_sell_orders` VALUES (1,0,'23180687121','BTC_BTCD','0.15495618','2018-04-28 14:57:06',0.0120188,'0.00186239','1715971','1',1),(2,0,'18532652966','BTC_SBD','3.02135373','2018-05-01 00:50:02',0.00035092,'0.00106025','900392','1',3),(3,0,'18532652966','BTC_SBD','2.26323690','2018-05-01 00:50:02',0.00035092,'0.00079421','900393','1',3),(4,0,'23317996766','BTC_XBC','0.11588239','2018-05-03 20:16:09',0.00756346,'0.00087647','1160675','1',5),(5,0,'11812075144','BTC_HUC','97.91562744','2018-05-03 23:54:02',0.00001633,'0.00159896','752595','1',6),(6,0,'11812075144','BTC_HUC','15.19686133','2018-05-03 23:54:02',0.00001633,'0.00024816','752596','1',6),(7,0,'43534046538','BTC_DCR','0.16408856','2018-05-04 06:55:03',0.0104684,'0.00171774','2531864','1',8),(8,0,'17475009511','BTC_BTM','23.58274461','2018-05-04 06:56:02',0.00008082,'0.00190595','777307','1',7);
/*!40000 ALTER TABLE `poloniex_sell_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poloniex_sell_triggers`
--

DROP TABLE IF EXISTS `poloniex_sell_triggers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poloniex_sell_triggers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `profit_target` float DEFAULT NULL,
  `stop_loss` float DEFAULT NULL,
  `tsl_arm` float DEFAULT NULL,
  `tsl` varchar(45) DEFAULT NULL,
  `active` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poloniex_sell_triggers`
--

LOCK TABLES `poloniex_sell_triggers` WRITE;
/*!40000 ALTER TABLE `poloniex_sell_triggers` DISABLE KEYS */;
INSERT INTO `poloniex_sell_triggers` VALUES (1,1,10,0.3,5,'0.5','1');
/*!40000 ALTER TABLE `poloniex_sell_triggers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poloniex_trade_limits`
--

DROP TABLE IF EXISTS `poloniex_trade_limits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poloniex_trade_limits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `trade_limit` double DEFAULT NULL,
  `max_amount` float DEFAULT NULL,
  `min_amount` float DEFAULT NULL,
  `active` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poloniex_trade_limits`
--

LOCK TABLES `poloniex_trade_limits` WRITE;
/*!40000 ALTER TABLE `poloniex_trade_limits` DISABLE KEYS */;
INSERT INTO `poloniex_trade_limits` VALUES (1,1,1,20,10,'1');
/*!40000 ALTER TABLE `poloniex_trade_limits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poloniex_tsl_orders`
--

DROP TABLE IF EXISTS `poloniex_tsl_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poloniex_tsl_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currencypair` varchar(45) DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `buy_order_id` int(5) DEFAULT NULL,
  `active` char(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poloniex_tsl_orders`
--

LOCK TABLES `poloniex_tsl_orders` WRITE;
/*!40000 ALTER TABLE `poloniex_tsl_orders` DISABLE KEYS */;
INSERT INTO `poloniex_tsl_orders` VALUES (1,'BTC_BCN',0.0000007,2853.4283582,2846.29478731,4,'2');
/*!40000 ALTER TABLE `poloniex_tsl_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'poloniexbot'
--

--
-- Dumping routines for database 'poloniexbot'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-05  1:02:08
