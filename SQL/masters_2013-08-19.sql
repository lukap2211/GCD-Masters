# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.9)
# Database: masters
# Generation Time: 2013-08-19 10:57:37 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table contents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contents`;

CREATE TABLE `contents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `title` char(255) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` longtext NOT NULL,
  `excerpt` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `geo_lng` decimal(10,6) DEFAULT NULL,
  `geo_lat` decimal(10,6) DEFAULT NULL,
  `map` char(11) NOT NULL DEFAULT '',
  `category` char(11) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `geo_lat` (`geo_lat`),
  KEY `geo_lon` (`geo_lng`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `contents` WRITE;
/*!40000 ALTER TABLE `contents` DISABLE KEYS */;

INSERT INTO `contents` (`id`, `user_id`, `type_id`, `title`, `date`, `date_modified`, `content`, `excerpt`, `status`, `geo_lng`, `geo_lat`, `map`, `category`)
VALUES
	(8,1,1,'Fourth','0000-00-00 00:00:00','2013-08-07 23:35:17','another content',0,0,-6.297806,53.348758,'pho','activity'),
	(9,1,3,'Fourth','0000-00-00 00:00:00','2013-08-12 18:33:01','another content',0,0,-6.348681,53.360925,'pho','history'),
	(10,1,2,'Fourth','0000-00-00 00:00:00','2013-08-12 18:30:08','another content',0,0,-6.336837,53.368480,'pho','study'),
	(11,1,1,'Fourth','0000-00-00 00:00:00','2013-08-19 01:31:45','another content',0,0,-6.279320,53.331180,'gcd','history'),
	(12,1,1,'Fourth','0000-00-00 00:00:00','2013-08-19 01:35:47','another content',0,0,-6.278222,53.331427,'gcd','history'),
	(270,1,1,'test','0000-00-00 00:00:00','2013-08-19 11:40:50','some lukap content',0,0,-6.277700,53.349675,'smi','todo'),
	(271,1,1,'test','0000-00-00 00:00:00','2013-08-19 11:36:39','some lukap content',0,0,-6.279963,53.347664,'smi','todo'),
	(275,1,1,'test','0000-00-00 00:00:00','2013-08-19 11:40:48','some lukap content',0,0,-6.279427,53.349713,'smi','todo'),
	(281,1,1,'test','0000-00-00 00:00:00','2013-08-19 11:40:26','some lukap content',0,0,-6.278279,53.347606,'smi','todo');

/*!40000 ALTER TABLE `contents` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table privileges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `privileges`;

CREATE TABLE `privileges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `privilege` char(255) NOT NULL DEFAULT 'editor',
  PRIMARY KEY (`id`),
  UNIQUE KEY `privilege` (`privilege`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `privileges` WRITE;
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;

INSERT INTO `privileges` (`id`, `privilege`)
VALUES
	(6,'admin'),
	(7,'editor');

/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL DEFAULT '',
  `desc` varchar(1000) NOT NULL DEFAULT '',
  `logo` int(11) DEFAULT NULL,
  `size` char(10) NOT NULL DEFAULT 'normal',
  `debug` int(1) NOT NULL DEFAULT '0',
  `location` int(1) NOT NULL DEFAULT '0',
  `legend` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `name`, `desc`, `logo`, `size`, `debug`, `location`, `legend`)
VALUES
	(1,'Geo CMS','Griffith College Dublin, MScADM, Parti Time. Geo CMS is Luka Puharic\'s  Masters dissertation by practice final project.',NULL,'normal',1,1,1);

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(255) NOT NULL DEFAULT 'html',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;

INSERT INTO `types` (`id`, `type`)
VALUES
	(1,'html'),
	(5,'image'),
	(3,'link'),
	(2,'text'),
	(4,'video');

/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(16) NOT NULL DEFAULT '',
  `password` char(40) NOT NULL DEFAULT '' COMMENT 'sha1 hash',
  `privilege_id` int(2) NOT NULL,
  `bio` text,
  `last_name` char(20) NOT NULL DEFAULT '',
  `first_name` char(20) NOT NULL DEFAULT '',
  `avatar` char(1) DEFAULT 'a',
  `colour` char(6) NOT NULL DEFAULT 'FF3300',
  `email` char(30) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `privilege_id`, `bio`, `last_name`, `first_name`, `avatar`, `colour`, `email`)
VALUES
	(1,'lukap','c2620db242ea54a05abb65364161f7e2',6,'bla blaaa test 123123','Puharic','Luka','a','FF3300',''),
	(2,'superman','84d961568a65073a3bcf0eb216b2a576',7,'Superman bio comes here!','Kent','Clark','a','FF3300',''),
	(3,'batman','ec0e2603172c73a8b644bb9456c1ff6e',6,'Batman bio comes here!','Wayne','Bruce','a','FF3300','');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
