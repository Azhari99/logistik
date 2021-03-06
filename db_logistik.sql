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

/*Table structure for table `keys` */

DROP TABLE IF EXISTS `keys`;

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `keys` */

insert  into `keys`(`id`,`user_id`,`key`,`level`,`ignore_limits`,`is_private_key`,`ip_addresses`,`date_created`) values (1,1,'inv123',1,0,0,NULL,20200406);

/*Table structure for table `tbl_anggaran` */

DROP TABLE IF EXISTS `tbl_anggaran`;

CREATE TABLE `tbl_anggaran` (
  `tbl_anggaran_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `tahun` year(4) NOT NULL,
  `budget` bigint(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'O',
  `jenis_id` int(10) NOT NULL,
  PRIMARY KEY (`tbl_anggaran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_anggaran` */

insert  into `tbl_anggaran`(`tbl_anggaran_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`name`,`tahun`,`budget`,`keterangan`,`status`,`jenis_id`) values (1,'Y','2020-05-13 12:55:52',1,'2020-05-13 13:00:31',1,'UANG',2020,60000000,'TEST 1','O',2),(2,'Y','2020-05-13 13:46:03',1,'2020-05-13 13:46:03',1,'BARANG - BARANG',2020,60000000,'TEST 1','O',1);

/*Table structure for table `tbl_barang` */

DROP TABLE IF EXISTS `tbl_barang`;

CREATE TABLE `tbl_barang` (
  `tbl_barang_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `value` varchar(6) NOT NULL,
  `name` varchar(60) NOT NULL,
  `jenis_id` int(10) NOT NULL,
  `kategori_id` int(10) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `qtyentered` decimal(10,0) NOT NULL,
  `qtyavailable` decimal(10,0) NOT NULL DEFAULT '0',
  `unitprice` int(11) NOT NULL,
  `budget` bigint(20) NOT NULL,
  PRIMARY KEY (`tbl_barang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_barang` */

insert  into `tbl_barang`(`tbl_barang_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`,`jenis_id`,`kategori_id`,`keterangan`,`qtyentered`,`qtyavailable`,`unitprice`,`budget`) values (1,'Y','2020-06-01 00:41:14',1,'2020-06-01 02:31:26',1,'PS0001','KOMPUTER',1,1,'New Product',200,7,1000000,40000000);

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

/*Table structure for table `tbl_barangmasuk` */

DROP TABLE IF EXISTS `tbl_barangmasuk`;

CREATE TABLE `tbl_barangmasuk` (
  `tbl_barangmasuk_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `documentno` varchar(30) NOT NULL,
  `datetrx` datetime NOT NULL,
  `tbl_barang_id` int(10) NOT NULL,
  `qtyentered` decimal(10,0) NOT NULL,
  `unitprice` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `status` char(2) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `file` varchar(500) NOT NULL,
  PRIMARY KEY (`tbl_barangmasuk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_barangmasuk` */

insert  into `tbl_barangmasuk`(`tbl_barangmasuk_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`documentno`,`datetrx`,`tbl_barang_id`,`qtyentered`,`unitprice`,`amount`,`status`,`keterangan`,`file`) values (1,'Y','2020-06-01 00:43:19',1,'2020-06-01 00:43:19',1,'PIN-0001','2020-06-01 00:00:00',1,20,1000000,20000000,'CO','Test 1','item_200601_004319_caeebb7564.pdf'),(2,'Y','2020-06-01 00:46:56',1,'2020-06-01 00:46:56',1,'PIN-0002','2020-06-01 00:00:00',1,1,2000000,2000000,'CO','Test 1',''),(5,'Y','2020-06-02 15:18:00',1,'2020-06-02 15:18:00',1,'PIN-0003','2020-06-02 00:00:00',1,1,1000000,1000000,'DR','','item_200602_151800_559046474b.pdf');

/*Table structure for table `tbl_instansi` */

DROP TABLE IF EXISTS `tbl_instansi`;

CREATE TABLE `tbl_instansi` (
  `tbl_instansi_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `value` varchar(6) NOT NULL,
  `name` varchar(60) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `budget` bigint(20) NOT NULL,
  PRIMARY KEY (`tbl_instansi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_instansi` */

insert  into `tbl_instansi`(`tbl_instansi_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`,`address`,`email`,`phone`,`budget`) values (2,'Y','2020-05-13 12:59:52',1,'2020-05-31 20:52:31',1,'IS0001','ITB','Jl. Test 1 Jl. Test 1 Jl. Test 1','itb@ac.id','02410102020',50000000),(3,'Y','2020-05-30 13:07:49',1,'2020-05-30 13:07:49',1,'IS0002','UI','Jl. Cacing','ui@ac.id','02410102020',60000000);

/*Table structure for table `tbl_jenis_logistik` */

DROP TABLE IF EXISTS `tbl_jenis_logistik`;

CREATE TABLE `tbl_jenis_logistik` (
  `tbl_jenis_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` decimal(10,0) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` decimal(10,0) NOT NULL,
  `value` varchar(6) DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`tbl_jenis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_jenis_logistik` */

insert  into `tbl_jenis_logistik`(`tbl_jenis_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`) values (1,'Y','2020-05-13 13:30:25',1,'2020-05-13 13:30:37',1,'TL0001','Barang'),(2,'Y','2020-05-13 13:30:41',1,'2020-05-13 13:30:41',1,'TL0002','Anggaran');

/*Table structure for table `tbl_kategori` */

DROP TABLE IF EXISTS `tbl_kategori`;

CREATE TABLE `tbl_kategori` (
  `tbl_kategori_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `value` varchar(6) NOT NULL,
  `name` varchar(60) NOT NULL,
  `isdefault` char(1) NOT NULL DEFAULT 'N',
  `jenis_id` int(10) NOT NULL,
  PRIMARY KEY (`tbl_kategori_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_kategori` */

insert  into `tbl_kategori`(`tbl_kategori_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`,`isdefault`,`jenis_id`) values (1,'Y','2020-05-13 13:31:07',1,'2020-05-13 13:31:07',1,'CA0001','ATK','N',1),(2,'Y','2020-05-13 13:31:13',1,'2020-05-13 13:31:13',1,'CA0002','DOKUMEN','N',1),(3,'Y','2020-05-13 13:32:07',1,'2020-05-13 13:32:07',1,'CA0003','UANG','N',2);

/*Table structure for table `tbl_menu` */

DROP TABLE IF EXISTS `tbl_menu`;

CREATE TABLE `tbl_menu` (
  `tbl_menu_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `seqno` decimal(10,0) NOT NULL,
  `url` varchar(25) NOT NULL,
  `icon` varchar(60) NOT NULL,
  PRIMARY KEY (`tbl_menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_menu` */

insert  into `tbl_menu`(`tbl_menu_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`name`,`seqno`,`url`,`icon`) values (1,'Y','2020-05-13 09:48:58',1,'2020-05-13 09:48:58',1,'Dashboard',1,'','fa fa-dashboard'),(2,'Y','2020-05-13 09:49:32',1,'2020-05-13 09:49:32',1,'Transaction',2,'','fa fa-recycle'),(3,'Y','2020-05-13 09:49:59',1,'2020-05-13 09:49:59',1,'Request Product',3,'requestin','fa fa-list'),(4,'Y','2020-05-13 09:50:16',1,'2020-05-13 09:50:16',1,'Report',4,'','fa fa-file'),(5,'Y','2020-05-13 10:01:43',1,'2020-05-13 10:01:43',1,'Master Data',5,'','fa fa-laptop'),(6,'Y','2020-05-13 10:02:25',1,'2020-05-13 10:03:13',1,'Setting',6,'','fa fa-users');

/*Table structure for table `tbl_permintaan` */

DROP TABLE IF EXISTS `tbl_permintaan`;

CREATE TABLE `tbl_permintaan` (
  `tbl_permintaan_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `documentno` varchar(30) NOT NULL,
  `tbl_barang_id` int(5) NOT NULL,
  `tbl_instansi_id` int(5) NOT NULL,
  `datetrx` date NOT NULL,
  `status` char(2) NOT NULL,
  `qtyentered` int(10) NOT NULL,
  `unitprice` int(11) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`tbl_permintaan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_permintaan` */

insert  into `tbl_permintaan`(`tbl_permintaan_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`documentno`,`tbl_barang_id`,`tbl_instansi_id`,`datetrx`,`status`,`qtyentered`,`unitprice`,`amount`,`keterangan`) values (1,'Y','2020-06-01 02:46:00',0,'2020-06-01 02:46:00',0,'POT-2004',1,2,'2020-06-01','CO',10,10000,100000,'test');

/*Table structure for table `tbl_submenu` */

DROP TABLE IF EXISTS `tbl_submenu`;

CREATE TABLE `tbl_submenu` (
  `tbl_submenu_id` int(10) NOT NULL AUTO_INCREMENT,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdby` int(10) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedby` int(10) NOT NULL,
  `tbl_menu_id` int(10) NOT NULL,
  `name` varchar(60) NOT NULL,
  `seqno` decimal(10,0) NOT NULL,
  `url` varchar(25) NOT NULL,
  PRIMARY KEY (`tbl_submenu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_submenu` */

insert  into `tbl_submenu`(`tbl_submenu_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`tbl_menu_id`,`name`,`seqno`,`url`) values (1,'Y','2020-05-13 10:41:44',1,'2020-05-13 10:41:44',1,5,'Product',1,'product'),(2,'Y','2020-05-13 10:42:22',1,'2020-05-13 10:42:36',1,5,'Category',2,'category'),(3,'Y','2020-05-13 10:42:56',1,'2020-05-13 10:42:56',1,5,'Type Logistics',3,'type'),(4,'Y','2020-05-13 10:43:33',1,'2020-05-13 10:43:33',1,5,'Annual Budget',4,'budget'),(5,'Y','2020-05-13 10:48:14',1,'2020-05-13 10:49:09',1,5,'Menu',6,'menu'),(6,'Y','2020-05-13 10:48:25',1,'2020-05-13 10:49:15',1,5,'Submenu',7,'submenu'),(7,'Y','2020-05-13 10:48:45',1,'2020-05-13 10:48:45',1,5,'Institute',5,'institute'),(8,'Y','2020-05-13 10:49:39',1,'2020-05-13 10:49:39',1,6,'Users',1,'users'),(9,'Y','2020-05-13 10:49:57',1,'2020-05-13 10:49:57',1,4,'Report Product Budget Out',1,'rpt_budgetout'),(10,'Y','2020-05-13 10:50:34',1,'2020-05-13 10:51:10',1,2,'Product In',1,'productin'),(11,'Y','2020-05-13 10:50:47',1,'2020-05-13 10:50:47',1,2,'Product Out',2,'productout');

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
