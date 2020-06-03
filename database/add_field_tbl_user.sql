/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.1.31-MariaDB : Database - db_inventori_isma
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_inventori_isma` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_inventori_isma`;

/*Table structure for table `tbl_user` */

DROP TABLE IF EXISTS `tbl_user`;

CREATE TABLE `tbl_user` (
  `tbl_user_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `value` varchar(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(10) NOT NULL,
  `lastlogin` timestamp NULL DEFAULT NULL,
  `changedpassword` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tbl_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_user` */

insert  into `tbl_user`(`tbl_user_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`,`password`,`level`,`lastlogin`,`changedpassword`) values (1,'Y','2020-05-04 12:52:53',1,'2020-05-31 18:49:47',1,'admin','Awn Admin','$2y$10$l3yJgjZu9F62I32efAKr/utUWErHYWgLAYLqwkD6LsOPCTWqP5YuW',1,'2020-06-02 13:30:33','2020-05-31 18:49:47'),(2,'Y','2020-05-31 12:21:39',1,'2020-05-31 12:26:20',2,'Oki-170903','Oki Permana','$2y$10$Cb9Iuyq7s1DrUQ/I/jRNBOe2zy1DB.RmGdCzSsdi15BVA6A/wQ3HK',3,'2020-05-31 12:23:03','2020-05-31 12:26:20');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
