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

insert  into `tbl_anggaran`(`tbl_anggaran_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`name`,`tahun`,`budget`,`keterangan`,`status`,`jenis_id`) values (1,'Y','2020-04-25 22:37:57',0,'2020-04-26 00:25:26',0,'Barang - Barang',2020,60000000,'Budget barang 2020','O',1),(2,'Y','2020-04-25 22:38:20',0,'2020-04-26 00:26:38',0,'UANG',2020,60000000,'Anggaran tahun 2020','O',2);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_barang` */

insert  into `tbl_barang`(`tbl_barang_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`,`jenis_id`,`kategori_id`,`keterangan`,`qtyentered`,`qtyavailable`,`unitprice`,`budget`) values (1,'Y','2020-04-25 22:38:45',0,'2020-04-25 23:44:50',0,'PS0001','BUKU',1,1,'Barang baru',500,91,8000,10000000),(2,'Y','2020-04-25 22:39:34',0,'2020-04-25 22:39:34',0,'PS0002','PULPEN',1,1,'Barang baru lagi',150,0,8000,10000000),(3,'Y','2020-04-25 22:40:01',0,'2020-04-25 23:45:08',0,'PS0003','DANA',2,3,'Anggaran',0,0,0,50000000);

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
  PRIMARY KEY (`tbl_barangkeluar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_barangkeluar` */

insert  into `tbl_barangkeluar`(`tbl_barangkeluar_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`documentno`,`tbl_barang_id`,`tbl_instansi_id`,`datetrx`,`status`,`qtyentered`,`unitprice`,`amount`,`keterangan`) values (1,'Y','2020-04-25 22:41:16',0,'2020-04-25 22:41:54',0,'POT-0001',1,2,'2020-04-25','CO',10,8000,80000,'kirim barang keITB'),(2,'Y','2020-04-25 22:41:49',0,'2020-04-25 22:41:56',0,'POT-0002',3,2,'2020-04-25','CO',0,0,10000000,'Sekalian kirim dana juga'),(10,'Y','2020-04-25 23:16:02',0,'2020-04-25 23:20:19',0,'POT-0004',1,2,'2020-04-25','DR',12,8000,96000,''),(11,'Y','2020-04-25 23:19:59',0,'2020-04-25 23:19:59',0,'POT-0005',3,2,'2020-04-25','DR',1,0,1000000,'t'),(14,'Y','2020-04-25 23:27:03',0,'2020-04-25 23:27:03',0,'POT-0006',3,2,'2020-04-25','DR',0,0,4000000,''),(18,'Y','2020-04-25 23:29:16',0,'2020-04-25 23:45:08',0,'POT-0009',3,2,'2020-04-25','CO',0,0,4000000,'Sekalian kirim dana juga');

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

insert  into `tbl_barangmasuk`(`tbl_barangmasuk_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`documentno`,`datetrx`,`tbl_barang_id`,`qtyentered`,`unitprice`,`amount`,`status`,`keterangan`,`file`) values (1,'Y','2020-04-25 22:40:35',0,'2020-04-25 22:40:35',0,'PIN-0001','2020-04-25 00:00:00',1,100,8000,800000,'CO','Barang masuk pertama','item-200425-c3cec7f444.pdf'),(5,'Y','2020-04-25 23:43:38',0,'2020-04-25 23:44:46',0,'PIN-0002','2020-04-25 00:00:00',1,1,8000,8000,'CO','','');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_instansi` */

insert  into `tbl_instansi`(`tbl_instansi_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`,`address`,`email`,`phone`,`budget`) values (2,'Y','2020-04-18 23:54:27',0,'2020-04-25 14:45:44',0,'IS0001','ITB','test 1','okiper12@gmail.com','12313',50000000),(3,'Y','2020-04-18 23:57:11',0,'2020-04-25 14:44:52',0,'IS0002','UI','d','admin@bladephp.co','81211499592',20000000),(4,'Y','2020-04-25 14:46:44',0,'2020-04-28 22:57:27',0,'IS0003','UGM','Jl. Cacing','url@ugm.ac.id','099020',30000000);

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

insert  into `tbl_jenis_logistik`(`tbl_jenis_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`) values (1,'Y','2020-04-06 23:12:00',0,'2020-04-07 09:10:07',0,'TL0001','Barang'),(2,'Y','2020-04-06 23:12:07',0,'2020-04-11 09:39:05',0,'TL0002','Anggaran');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_kategori` */

insert  into `tbl_kategori`(`tbl_kategori_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`,`isdefault`,`jenis_id`) values (1,'Y','2020-04-07 08:30:15',0,'2020-04-07 11:01:27',0,'CA0001','ATK','N',1),(2,'Y','2020-04-07 08:30:26',0,'2020-04-07 11:01:22',0,'CA0002','DOKUMEN','Y',1),(3,'Y','2020-04-07 09:07:43',0,'2020-04-11 09:49:44',2020,'CA0003','UANG','Y',2),(4,'Y','2020-04-11 09:57:08',0,'2020-04-11 09:57:16',0,'CA0004','LEMARI','N',1);

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

insert  into `tbl_menu`(`tbl_menu_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`name`,`seqno`,`url`,`icon`) values (1,'Y','2020-04-16 22:38:41',0,'2020-04-18 23:33:08',0,'Dashboard',1,'','fa fa-dashboard'),(2,'Y','2020-04-16 22:38:56',0,'2020-04-18 23:29:05',0,'Transaction',2,'','fa fa-recycle'),(3,'Y','2020-04-16 22:39:25',0,'2020-04-29 10:01:45',0,'Request Product',3,'request','fa fa-list'),(4,'Y','2020-04-16 22:39:34',0,'2020-04-18 23:29:21',0,'Report',4,'','fa fa-file'),(5,'Y','2020-04-16 22:39:46',0,'2020-04-18 23:29:27',0,'Master Data',5,'','fa fa-laptop'),(6,'Y','2020-04-16 22:40:12',0,'2020-04-18 23:29:37',0,'Setting',6,'','fa fa-users');

/*Table structure for table `tbl_permintaan` */

DROP TABLE IF EXISTS `tbl_permintaan`;

CREATE TABLE `tbl_permintaan` (
  `id_permintaan` int(5) NOT NULL AUTO_INCREMENT,
  `status` int(3) NOT NULL,
  `tanggal` date NOT NULL,
  `id_instansi` int(5) NOT NULL,
  `id_barang` int(5) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `keterangan` text NOT NULL,
  `id_admin` int(3) NOT NULL,
  PRIMARY KEY (`id_permintaan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_permintaan` */

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

insert  into `tbl_submenu`(`tbl_submenu_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`tbl_menu_id`,`name`,`seqno`,`url`) values (1,'Y','2020-04-16 22:40:32',0,'2020-04-18 23:33:19',0,5,'Product',1,'product'),(2,'Y','2020-04-16 22:40:58',0,'2020-04-16 22:40:58',0,5,'Type Logistics',2,'type'),(3,'Y','2020-04-18 23:09:42',0,'2020-04-18 23:09:42',0,5,'Category',3,'category'),(4,'Y','2020-04-18 23:10:11',0,'2020-04-21 10:50:25',0,5,'Menu',6,'menu'),(5,'Y','2020-04-18 23:10:32',0,'2020-04-21 10:50:32',0,5,'Submenu',7,'submenu'),(6,'Y','2020-04-18 23:11:15',0,'2020-04-18 23:11:15',0,5,'Institute',4,'institute'),(7,'Y','2020-04-18 23:26:17',0,'2020-04-18 23:26:37',0,6,'Users',1,'users'),(8,'Y','2020-04-18 23:30:17',0,'2020-04-18 23:30:17',0,2,'Product In',1,'productin'),(9,'Y','2020-04-18 23:30:35',0,'2020-04-18 23:30:35',0,2,'Product Out',2,'productout'),(10,'Y','2020-04-21 10:50:17',0,'2020-04-22 11:07:13',0,5,'Annual Budget',5,'budget'),(11,'Y','2020-04-29 10:00:41',0,'2020-04-29 10:00:41',0,4,'Report Budget Out',1,'rpt_budgetout');

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
  PRIMARY KEY (`tbl_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_user` */

insert  into `tbl_user`(`tbl_user_id`,`isactive`,`created`,`createdby`,`updated`,`updatedby`,`value`,`name`,`password`,`level`) values (1,'Y','2020-04-12 13:00:51',0,'2020-04-12 13:00:51',0,'admin','admin','123',1),(2,'Y','2020-04-12 13:00:51',0,'2020-04-12 13:00:51',0,'Pimpinan','pimpinan','123',2),(3,'Y','2020-04-12 13:00:51',0,'2020-04-12 13:00:51',0,'user','user','123',3),(4,'Y','2020-04-12 13:00:51',0,'2020-04-12 13:00:51',0,'Indra','Indra','123',1),(7,'Y','2020-04-19 00:35:08',0,'2020-04-19 14:16:21',0,'Oki-170903','Oki Permana2','$2y$10$AxuDuVhXiHLBXabIiCQnreRBIqUkBwUZnLHYtFS2gNiVCaUnyT/BC',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
