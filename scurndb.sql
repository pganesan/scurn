-- MySQL dump
--
-- Database: scurndb
-- ------------------------------------------------------
-- Server version	5.5.13

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
-- Table structure for table `forum_categories`
--

DROP TABLE IF EXISTS `forum_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum_categories` (
  `cat_id` int(8) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_description` varchar(255) NOT NULL,
  `cat_created_on` datetime NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_name_unique` (`cat_name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_categories`
--

LOCK TABLES `forum_categories` WRITE;
/*!40000 ALTER TABLE `forum_categories` DISABLE KEYS */;
INSERT INTO `forum_categories` VALUES (1,'Recycling','Importance of recycling','2011-11-21 21:00:25'),(2,'Recyclable Items','Items you can Recycle at Home','2011-11-21 21:00:25'),(4,'Importance of Recycling','Why recycling is so important?','2011-11-20 21:00:25'),(6,'Recycle Reuse','Reuse tips','2011-11-21 21:00:25'),(7,'Reduce and Reuse','Reduce Reuse Recycle','2011-11-21 21:00:25'),(10,'Save The World - It\'s not too late','Start Recycling Now!!','2011-11-20 21:00:25'),(12,'Teach your kids about recycling','You can learn the importance of recycling at any age','2011-11-21 21:00:25');
/*!40000 ALTER TABLE `forum_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_posts`
--

DROP TABLE IF EXISTS `forum_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum_posts` (
  `post_id` int(8) NOT NULL AUTO_INCREMENT,
  `post_content` text NOT NULL,
  `post_date` datetime NOT NULL,
  `post_topic` int(8) NOT NULL,
  `post_by` int(11) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `post_topic_idx` (`post_topic`),
  KEY `post_by_idx` (`post_by`),
  CONSTRAINT `post_by_fk` FOREIGN KEY (`post_by`) REFERENCES `scurn_member` (`member_id`) ON UPDATE CASCADE,
  CONSTRAINT `post_topic_fk` FOREIGN KEY (`post_topic`) REFERENCES `forum_topics` (`topic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_posts`
--

LOCK TABLES `forum_posts` WRITE;
/*!40000 ALTER TABLE `forum_posts` DISABLE KEYS */;
INSERT INTO `forum_posts` VALUES (1,'this is message posted','2011-11-21 21:00:25',3,1),(2,'This is my second pretty message','2011-11-22 11:50:59',3,1),(3,'This is my third message','2011-11-22 11:51:09',3,1),(4,'I can write too!','2011-11-22 12:05:27',3,9),(5,'Let me post something today','2011-11-23 11:06:24',3,1),(6,'This is message for topic2','2011-11-23 11:09:06',4,1),(7,'I made a purse! Check it out and please provide your comments','2011-11-30 15:56:54',5,1),(8,'How to create a grocery bag?','2011-11-30 15:57:43',6,1),(9,'Did you know about SCURN educational programs on recycling?','2011-11-30 15:58:29',7,1),(10,'There is going to be a session on recycling. Professor Mark will be presenting on 12/10/2011. Kindly plan to attend.','2011-11-30 16:01:20',8,1),(11,'Water Wastage! We need to take a serious look','2011-11-30 16:02:21',9,1),(12,'What temperature should I set my thermostat in winter? ANy ideas?','2011-11-30 16:03:28',10,1),(13,'I know a waste collection organization which does great work. Let me know if anybody wants to work for them','2011-11-30 16:05:08',11,1),(14,'The recycling lunch bags that I bought from this web site was very useful. My kid loves it!','2011-11-30 16:06:37',12,10),(15,'Glad to know!','2011-11-30 16:07:18',12,9),(16,'Yeah, I bought 2 bags as well. They are pretty sturdy. I was surprised!','2011-11-30 16:08:18',12,1),(17,'Hmm...may be I should get one. Thanks for the info','2011-11-30 16:10:18',12,15),(18,'Yeah, you should :)','2011-11-30 16:12:18',12,10),(19,'Oh, are they hiring? Do send me an email with the link to their website. I would like to give it a shot!','2011-11-30 16:20:19',11,14),(20,'Yes, they are. I sent you an email. Good luck!','2011-11-30 16:21:19',11,1),(21,'Thanks Poornima!','2011-11-30 16:22:19',11,14),(22,'I think it\\\'s never too early to teach your little ones','2011-11-30 16:27:40',13,15),(23,'Kids  are really fast learners','2011-11-30 16:30:19',14,10),(24,'Yes whenever milk in the carton is over, I ask my son to trash into the separate garbage cans provided for the recyclable items.','2011-11-30 16:31:19',14,1),(25,'Yeah, I started teaching my 5 year old too!','2011-11-30 16:32:19',14,15),(26,'Hey can you send me few tips on how to teach these little ones? My wife was curious and we would love to learn','2011-11-30 16:33:19',14,14),(27,'Sure John, I will send you an email. Say Hi to Angela:)','2011-11-30 16:34:19',14,15),(28,'Thanks for the tips, Sharon','2011-11-30 16:35:19',14,14),(29,'No problem John','2011-11-30 16:36:19',14,15);
/*!40000 ALTER TABLE `forum_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_topics`
--

DROP TABLE IF EXISTS `forum_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum_topics` (
  `topic_id` int(8) NOT NULL AUTO_INCREMENT,
  `topic_subject` varchar(255) NOT NULL,
  `topic_date` datetime NOT NULL,
  `topic_cat` int(8) NOT NULL,
  `topic_by` int(11) NOT NULL,
  PRIMARY KEY (`topic_id`),
  KEY `topic_by_idx` (`topic_by`),
  KEY `topic_cat_idx` (`topic_cat`),
  CONSTRAINT `topic_cat_fk` FOREIGN KEY (`topic_cat`) REFERENCES `forum_categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `topic_by_fk` FOREIGN KEY (`topic_by`) REFERENCES `scurn_member` (`member_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_topics`
--

LOCK TABLES `forum_topics` WRITE;
/*!40000 ALTER TABLE `forum_topics` DISABLE KEYS */;
INSERT INTO `forum_topics` VALUES (3,'History of Recycling','2011-11-21 21:00:25',1,1),(4,'Recycling mechanisms','2011-11-23 11:09:06',1,1),(5,'Personal Items','2011-11-30 15:56:54',2,1),(6,'Grocery bags','2011-11-30 15:57:43',2,1),(7,'Did you know?','2011-11-30 15:58:29',4,1),(8,'Session on Recyling','2011-11-30 16:01:20',4,1),(9,'How to reduce wastage?','2011-11-30 16:02:21',6,1),(10,'Energy saving tips','2011-11-30 16:03:28',7,1),(11,'Recycling programs in U.S.','2011-11-30 16:05:08',10,1),(12,'Programs for kids','2011-11-30 16:06:37',12,1),(13,'I teach my 3 year old about recycling','2011-11-30 16:27:40',1,15),(14,'I teach my 3 year old about recycling','2011-11-30 16:30:19',12,10);
/*!40000 ALTER TABLE `forum_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_order`
--

DROP TABLE IF EXISTS `item_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_order` (
  `order_number` int(11) NOT NULL,
  `item_code` int(11) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  PRIMARY KEY (`order_number`,`item_code`),
  KEY `order_number_idx` (`order_number`),
  KEY `item_code_idx` (`item_code`),
  CONSTRAINT `item_code_fk` FOREIGN KEY (`item_code`) REFERENCES `scurn_inventory` (`item_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `order_number_fk` FOREIGN KEY (`order_number`) REFERENCES `scurn_order` (`order_number`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_order`
--

LOCK TABLES `item_order` WRITE;
/*!40000 ALTER TABLE `item_order` DISABLE KEYS */;
INSERT INTO `item_order` VALUES (1,10203044,1),(1,10203046,1),(2,10203040,1),(2,10203041,1),(3,10203040,3),(3,10203041,2),(4,10203043,2),(4,10203046,3),(5,10203043,2),(5,10203046,3),(6,10203044,2),(6,10203046,3),(7,10203045,2),(8,10203043,2),(8,10203045,4),(9,10203043,1),(9,10203044,2),(10,10203047,1),(10,10203048,3),(11,10203040,1),(11,10203041,1),(12,10203041,1),(12,10203043,1),(13,10203043,1),(13,10203044,1),(14,10203040,1),(14,10203041,1),(15,10203041,3),(15,10203042,1);
/*!40000 ALTER TABLE `item_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_payment`
--

DROP TABLE IF EXISTS `member_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_payment` (
  `member_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `card_type` varchar(45) NOT NULL,
  `card_number` varchar(19) DEFAULT NULL,
  `card_name` varchar(45) NOT NULL,
  `exp_mm` int(2) NOT NULL,
  `exp_y` int(4) NOT NULL,
  PRIMARY KEY (`member_payment_id`),
  KEY `member_payment_unique` (`member_id`,`card_type`),
  KEY `member_id_idx` (`member_id`),
  KEY `member_id_fk` (`member_id`),
  CONSTRAINT `member_id_fk` FOREIGN KEY (`member_id`) REFERENCES `scurn_member` (`member_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_payment`
--

LOCK TABLES `member_payment` WRITE;
/*!40000 ALTER TABLE `member_payment` DISABLE KEYS */;
INSERT INTO `member_payment` VALUES (1,1,'VISA','4258-1458-2658-1479','Poornima Ganesan',5,2014),(4,9,'VISA','4785-1589-5789-3658','Brinda Sivalingam',4,2012),(6,14,'VISA','4088-7596-3458-6896','John Smith',8,2014);
/*!40000 ALTER TABLE `member_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scurn_inventory`
--

DROP TABLE IF EXISTS `scurn_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scurn_inventory` (
  `item_code` int(11) NOT NULL,
  `item_name` varchar(45) NOT NULL,
  `item_desc` varchar(200) DEFAULT NULL,
  `price` decimal(5,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_image_url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`item_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scurn_inventory`
--

LOCK TABLES `scurn_inventory` WRITE;
/*!40000 ALTER TABLE `scurn_inventory` DISABLE KEYS */;
INSERT INTO `scurn_inventory` VALUES (10203040,'Bassage Plates','12.5\" diameter plates',30.00,9,'../images/plates.jpg'),(10203041,'Bagasse Bowls','5\" diameter flat bottom bowls',39.00,21,'../images/bowls.jpg'),(10203042,'Sustainable Wood Bookshelf','',75.00,0,'../images/bookshelf.jpg'),(10203043,'Compostable Cellulose Bags','Leak and odour proof',5.00,1,'../images/compost-bag.jpg'),(10203044,'Paper Cup Holders','',2.00,44,'../images/cupholder.jpg'),(10203045,'Cotton Lunch Bags','Dimensions: 7\"W x 9.5\"H x 5\"D',20.00,94,'../images/lunchbag.jpg'),(10203046,'Pen Holder','Size: 80*80*110MM',5.49,35,'../images/penholder.jpg'),(10203047,'Recyclable Comb','',3.49,99,'../images/comb.jpg'),(10203048,'Recyclable Purse','',10.00,300,'../images/purse.jpg'),(10203049,'Lamp','',20.99,400,'../images/lamp2.jpg'),(10203050,'Umbrella','',15.00,700,'../images/umbrella.jpg');
/*!40000 ALTER TABLE `scurn_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scurn_member`
--

DROP TABLE IF EXISTS `scurn_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scurn_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) NOT NULL,
  `member_addr1` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `member_pwd` varchar(45) NOT NULL,
  `member_uname` varchar(45) NOT NULL,
  `state` varchar(2) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `scurn_member_unique` (`member_uname`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scurn_member`
--

LOCK TABLES `scurn_member` WRITE;
/*!40000 ALTER TABLE `scurn_member` DISABLE KEYS */;
INSERT INTO `scurn_member` VALUES (1,'Poornima','','Ganesan','4257 Fifth street','Sunnyvale',94086,'pganesan@scurn.com','408-758-1256','pg123','pganesan','CA'),(9,'Brinda','','Sivalingam','145 Third Ave','Sanjose',94785,'brinda_s@abc.com','','bs123*','bsivalingam','CA'),(10,'Preeti','','Yadav','175 Second Street','Sanjose',97856,'preeti@cnn.com','','p123','pthorat','CA'),(14,'John','N','Smith','45 California Street','Mountain View',94578,'jsmith@yahoo.com','408-245-6896','jsmith123','jsmith','CA'),(15,'Sharon','','Mossman','49 Boston Street','Oakland',97856,'smoss@gmail.com','408-789-3688','smoss12','smoss','CA');
/*!40000 ALTER TABLE `scurn_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scurn_order`
--

DROP TABLE IF EXISTS `scurn_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scurn_order` (
  `order_number` int(11) NOT NULL AUTO_INCREMENT,
  `member_payment_id` int(11) DEFAULT NULL,
  `totalprice` decimal(6,2) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `middlename` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `shipping_addr1` varchar(100) DEFAULT NULL,
  `shipping_addr2` varchar(100) DEFAULT NULL,
  `shipping_zipcode` int(11) DEFAULT NULL,
  `shipping_code` int(11) NOT NULL,
  PRIMARY KEY (`order_number`),
  KEY `member_payment_id_idx` (`member_payment_id`),
  KEY `shipping_code_idx` (`shipping_code`),
  CONSTRAINT `member_payment_id_fk` FOREIGN KEY (`member_payment_id`) REFERENCES `member_payment` (`member_payment_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `shipping_code_fk` FOREIGN KEY (`shipping_code`) REFERENCES `scurn_shipping` (`shipping_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scurn_order`
--

LOCK TABLES `scurn_order` WRITE;
/*!40000 ALTER TABLE `scurn_order` DISABLE KEYS */;
INSERT INTO `scurn_order` VALUES (1,1,10.74,'Poornima','','Ganesan','4257 First street',NULL,94086,1),(2,NULL,83.53,'Cameron','','Diaz','25 Second NW Street',NULL,96875,2),(3,NULL,187.69,'Julia','','Roberts','56 Mary Ave',NULL,98769,1),(4,1,30.72,'Poornima','','Ganesan','4257 First street',NULL,94086,1),(5,1,30.72,'Poornima','','Ganesan','4257 First street',NULL,94086,1),(6,1,24.86,'Poornima','','Ganesan','4257 First street',NULL,94086,1),(7,1,43.93,'Poornima','','Ganesan','4257 First street',NULL,94086,1),(8,1,95.69,'Poornima','','Ganesan','4257 First street NW',NULL,94086,2),(9,NULL,16.59,'Preeti','','Yadav','175 Second Street',NULL,97856,2),(10,1,40.51,'Poornima','','Ganesan','4257 First street',NULL,94086,2),(11,1,75.18,'Poornima','','Ganesan','4257 First street',NULL,94086,2),(12,1,47.84,'Poornima','','Ganesan','4257 First street',NULL,94086,1),(13,1,11.71,'Poornima','','Ganesan','4257 First street',NULL,94086,1),(14,1,72.25,'Poornima','','Ganesan','4257 First street',NULL,94086,1),(15,4,192.36,'Brinda','','Sivalingam','145 Third Ave',NULL,94785,1);
/*!40000 ALTER TABLE `scurn_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scurn_quiz`
--

DROP TABLE IF EXISTS `scurn_quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scurn_quiz` (
  `question_no` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(500) NOT NULL,
  `answer_choice2` varchar(255) NOT NULL,
  `answer_choice3` varchar(255) NOT NULL,
  `answer_choice4` varchar(255) NOT NULL,
  `right_answer` varchar(255) NOT NULL,
  `q_no` int(8) NOT NULL,
  `answer_choice5` varchar(255) NOT NULL,
  PRIMARY KEY (`question_no`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scurn_quiz`
--

LOCK TABLES `scurn_quiz` WRITE;
/*!40000 ALTER TABLE `scurn_quiz` DISABLE KEYS */;
INSERT INTO `scurn_quiz` VALUES (1,'The Department of agriculture found a way to make disposal diapers out of','leaves','chicken feathers	','magazines	','magazines	',1,'news papers'),(2,'Every ton of new glass produced generates.....lb. of air polution?','27.8 lbs','33.1 lbs','42.7 lbs','27.8 lbs',2,'47.3 lbs'),(3,'Using recycled glass to produce new glass products reduces air pollution by...%?','1-13%','14-20%','21-28%','14-20%',3,'29-35%'),(4,'To manufacture 85 millions of paper, how many trees must be cut down and processed?','1.4 billion','3 billion','5.2 billion','1.4 billion',4,'6 billion'),(5,'Seminole County residents throw away more of this material than any other?','Plastic','Paper','Glass','Paper',5,'Steel'),(6,'Over 5 billion aluminium cans are recycled each year. If laid end to end,these cans would form a line reaching from?','Orlando to Miami','Los Angeles to New York','Earth to Moon','Earth to Moon',6,'New York to Paris'),(7,'Recycling one ton of paper saves?','10 trees','17 trees','13 trees','17 trees',7,'03 trees'),(8,'For each $1,000.00 of fast food served, the solid waste created equals?','10 lbs.','10 lbs.','25 lbs.','200 lbs.',8,'500 lbs.'),(9,'The percent of solid waste recycled in Japan is 50%, western Europe is 30% and the United States is?','10%','30%','50%','10%',9,'100%'),(10,'How many pounds of plastic are thrown out yearly by Americans?','500 million	','5 billion','10 billion','20 billion',10,'20 billion');
/*!40000 ALTER TABLE `scurn_quiz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scurn_shipping`
--

DROP TABLE IF EXISTS `scurn_shipping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scurn_shipping` (
  `shipping_code` int(11) NOT NULL,
  `shipping_type` varchar(45) NOT NULL,
  `shipping_cost` decimal(3,2) NOT NULL,
  PRIMARY KEY (`shipping_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scurn_shipping`
--

LOCK TABLES `scurn_shipping` WRITE;
/*!40000 ALTER TABLE `scurn_shipping` DISABLE KEYS */;
INSERT INTO `scurn_shipping` VALUES (1,'STANDARD',4.99),(2,'PRIORITY',7.99),(3,'OVERNIGHT',9.99);
/*!40000 ALTER TABLE `scurn_shipping` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
