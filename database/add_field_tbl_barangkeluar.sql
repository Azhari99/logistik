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

/*Table structure for table `tbl_barangkeluar` */

DROP TABLE IF EXISTS `tbl_barangkeluar`;

CREATE TABLE `tbl_barangkeluar` (
  `tbl_barangkeluar_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `documentno` varchar(30) NOT NULL,
  `tbl_barang_id` int(10) NOT NULL,
  `tbl_instansi_id` int(10) NOT NULL,
  `datetrx` date NOT NULL,
  `status` char(2) NOT NULL,
  `qtyentered` decimal(10,0) NOT NULL,
  `unitprice` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `file` varchar(500) NOT NULL,
  PRIMARY KEY (`tbl_barangkeluar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_barangkeluar` */

insert  into `tbl_barangkeluar`(`tbl_barangkeluar_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`documentno`,`tbl_barang_id`,`tbl_instansi_id`,`datetrx`,`status`,`qtyentered`,`unitprice`,`amount`,`keterangan`,`file`) values (1,'Y','2020-06-01 00:44:09',1,'2020-06-01 01:14:21',1,'POT-0001',1,2,'2020-06-01','CO',1,1000000,2000000,'Test 2','item_200601_004409_87b79f263e.pdf'),(2,'Y','2020-06-01 00:47:42',1,'2020-06-01 02:31:26',1,'POT-0002',1,2,'2020-06-01','CO',8,5000000,40000000,'',''),(4,'Y','2020-06-01 00:58:58',1,'2020-06-01 01:28:16',1,'POT-0003',1,2,'2020-06-01','CO',1,5000000,5000000,'','item_200601_005858_d1942b48f0.pdf');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
