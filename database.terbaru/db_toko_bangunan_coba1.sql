-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_toko_bangunan_coba1
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang` (
  `idbarang` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` char(1) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `kuantitas` varchar(20) NOT NULL,
  `idsatuan` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`idbarang`),
  KEY `fk_barang_satuan` (`idsatuan`),
  CONSTRAINT `fk_barang_satuan` FOREIGN KEY (`idsatuan`) REFERENCES `satuan` (`idsatuan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES (1,'S','Semen Tiga Roda','50',1,1,62000),(2,'S','Besi Beton Polos','10',2,1,85000),(3,'P','Paku Beton ','5',3,1,22000),(4,'F','Cat Tembok Putih','5',4,1,185000),(5,'P','Triplek','9',5,1,95000);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_penerimaan`
--

DROP TABLE IF EXISTS `detail_penerimaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_penerimaan` (
  `iddetail_penerimaan` bigint(20) NOT NULL AUTO_INCREMENT,
  `idpenerimaan` bigint(20) NOT NULL,
  `barang_idbarang` int(11) NOT NULL,
  `jumlah_terima` int(11) NOT NULL,
  `harga_satuan_terima` int(11) NOT NULL,
  `sub_total_terima` int(11) NOT NULL,
  PRIMARY KEY (`iddetail_penerimaan`),
  KEY `fk_dpenerimaan_penerimaan` (`idpenerimaan`),
  KEY `fk_dpenerimaan_barang` (`barang_idbarang`),
  CONSTRAINT `fk_dpenerimaan_barang` FOREIGN KEY (`barang_idbarang`) REFERENCES `barang` (`idbarang`),
  CONSTRAINT `fk_dpenerimaan_penerimaan` FOREIGN KEY (`idpenerimaan`) REFERENCES `penerimaan` (`idpenerimaan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_penerimaan`
--

LOCK TABLES `detail_penerimaan` WRITE;
/*!40000 ALTER TABLE `detail_penerimaan` DISABLE KEYS */;
INSERT INTO `detail_penerimaan` VALUES (1,1,1,100,62000,6200000),(2,2,2,6,1000,6000),(3,3,3,1,7000,7000),(4,4,3,7,5000,35000);
/*!40000 ALTER TABLE `detail_penerimaan` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_detail_penerimaan_kartu_stok
AFTER INSERT ON detail_penerimaan
FOR EACH ROW
BEGIN
    DECLARE v_stok_baru INT;
 
    SET v_stok_baru = fn_stok_terakhir(NEW.barang_idbarang) + NEW.jumlah_terima;
 
    INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang)
    VALUES ('M', NEW.jumlah_terima, 0, v_stok_baru, NEW.idpenerimaan, NEW.barang_idbarang);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detail_pengadaan`
--

DROP TABLE IF EXISTS `detail_pengadaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_pengadaan` (
  `iddetail_pengadaan` bigint(20) NOT NULL AUTO_INCREMENT,
  `harga_satuan` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `idpengadaan` bigint(20) NOT NULL,
  PRIMARY KEY (`iddetail_pengadaan`),
  KEY `fk_dpengadaan_barang` (`idbarang`),
  KEY `fk_dpengadaan_pengadaan` (`idpengadaan`),
  CONSTRAINT `fk_dpengadaan_barang` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`),
  CONSTRAINT `fk_dpengadaan_pengadaan` FOREIGN KEY (`idpengadaan`) REFERENCES `pengadaan` (`idpengadaan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_pengadaan`
--

LOCK TABLES `detail_pengadaan` WRITE;
/*!40000 ALTER TABLE `detail_pengadaan` DISABLE KEYS */;
INSERT INTO `detail_pengadaan` VALUES (1,62000,100,6200000,1,1),(2,1000,6,6000,2,2),(4,5000,7,35000,3,4),(5,7000,1,7000,3,5);
/*!40000 ALTER TABLE `detail_pengadaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_penjualan`
--

DROP TABLE IF EXISTS `detail_penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_penjualan` (
  `iddetail_penjualan` bigint(20) NOT NULL AUTO_INCREMENT,
  `harga_satuan` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `penjualan_idpenjualan` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  PRIMARY KEY (`iddetail_penjualan`),
  KEY `fk_dpenjualan_penjualan` (`penjualan_idpenjualan`),
  KEY `fk_dpenjualan_barang` (`idbarang`),
  CONSTRAINT `fk_dpenjualan_barang` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`),
  CONSTRAINT `fk_dpenjualan_penjualan` FOREIGN KEY (`penjualan_idpenjualan`) REFERENCES `penjualan` (`idpenjualan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_penjualan`
--

LOCK TABLES `detail_penjualan` WRITE;
/*!40000 ALTER TABLE `detail_penjualan` DISABLE KEYS */;
INSERT INTO `detail_penjualan` VALUES (1,71300,5,356500,1,1),(2,71300,1,71300,2,1),(3,68200,6,409200,3,1);
/*!40000 ALTER TABLE `detail_penjualan` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_detail_penjualan_kartu_stok
AFTER INSERT ON detail_penjualan
FOR EACH ROW
BEGIN
    DECLARE v_stok_baru INT;
 
    SET v_stok_baru = fn_stok_terakhir(NEW.idbarang) - NEW.jumlah;
 
    INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang)
    VALUES ('J', 0, NEW.jumlah, v_stok_baru, NEW.penjualan_idpenjualan, NEW.idbarang);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detail_retur`
--

DROP TABLE IF EXISTS `detail_retur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_retur` (
  `iddetail_retur` int(11) NOT NULL AUTO_INCREMENT,
  `jumlah` int(11) NOT NULL,
  `alasan` varchar(200) NOT NULL,
  `idretur` bigint(20) NOT NULL,
  `iddetail_penerimaan` bigint(20) NOT NULL,
  PRIMARY KEY (`iddetail_retur`),
  KEY `fk_dretur_retur` (`idretur`),
  KEY `fk_dretur_dpenerimaan` (`iddetail_penerimaan`),
  CONSTRAINT `fk_dretur_dpenerimaan` FOREIGN KEY (`iddetail_penerimaan`) REFERENCES `detail_penerimaan` (`iddetail_penerimaan`),
  CONSTRAINT `fk_dretur_retur` FOREIGN KEY (`idretur`) REFERENCES `retur` (`idretur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_retur`
--

LOCK TABLES `detail_retur` WRITE;
/*!40000 ALTER TABLE `detail_retur` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_retur` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trg_detail_retur_kartu_stok
AFTER INSERT ON detail_retur
FOR EACH ROW
BEGIN
    DECLARE v_idbarang  INT;
    DECLARE v_stok_baru INT;

    SET v_idbarang  = fn_idbarang_penerimaan(NEW.iddetail_penerimaan);
    SET v_stok_baru = fn_stok_terakhir(v_idbarang) - NEW.jumlah;

    INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang)
    VALUES ('R', 0, NEW.jumlah, v_stok_baru, NEW.idretur, v_idbarang);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `kartu_stok`
--

DROP TABLE IF EXISTS `kartu_stok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kartu_stok` (
  `idkartu_stok` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_transaksi` char(1) NOT NULL,
  `masuk` int(11) NOT NULL DEFAULT 0,
  `keluar` int(11) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `idtransaksi` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  PRIMARY KEY (`idkartu_stok`),
  KEY `fk_kartustok_barang` (`idbarang`),
  CONSTRAINT `fk_kartustok_barang` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kartu_stok`
--

LOCK TABLES `kartu_stok` WRITE;
/*!40000 ALTER TABLE `kartu_stok` DISABLE KEYS */;
INSERT INTO `kartu_stok` VALUES (1,'M',100,0,100,'2026-11-20 15:07:39',1,1),(2,'J',0,5,95,'2026-11-20 16:14:21',1,1),(3,'J',0,1,94,'2026-11-20 16:37:43',2,1),(4,'M',6,0,6,'2026-11-20 16:49:58',2,2),(5,'M',1,0,1,'2026-11-23 03:42:16',3,3),(6,'M',7,0,8,'2026-11-23 03:43:25',4,3),(7,'J',0,6,88,'2026-11-23 03:46:09',3,1);
/*!40000 ALTER TABLE `kartu_stok` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `margin_penjualan`
--

DROP TABLE IF EXISTS `margin_penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `margin_penjualan` (
  `idmargin_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `persen` double NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `iduser` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idmargin_penjualan`),
  KEY `fk_margin_user` (`iduser`),
  CONSTRAINT `fk_margin_user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `margin_penjualan`
--

LOCK TABLES `margin_penjualan` WRITE;
/*!40000 ALTER TABLE `margin_penjualan` DISABLE KEYS */;
INSERT INTO `margin_penjualan` VALUES (1,'2026-01-01 01:00:00',5,0,1,'2026-11-23 03:36:30'),(2,'2026-02-01 01:00:00',7.5,0,1,'2026-11-23 03:36:30'),(3,'2026-03-01 01:00:00',10,1,1,'2026-11-23 03:36:30'),(4,'2026-05-01 01:00:00',12.5,0,2,'2026-11-23 03:36:30'),(5,'2026-08-01 01:00:00',15,0,1,'2026-11-23 03:36:30');
/*!40000 ALTER TABLE `margin_penjualan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penerimaan`
--

DROP TABLE IF EXISTS `penerimaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penerimaan` (
  `idpenerimaan` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` char(1) NOT NULL,
  `idpengadaan` bigint(20) NOT NULL,
  `iduser` int(11) NOT NULL,
  PRIMARY KEY (`idpenerimaan`),
  KEY `fk_penerimaan_pengadaan` (`idpengadaan`),
  KEY `fk_penerimaan_user` (`iduser`),
  CONSTRAINT `fk_penerimaan_pengadaan` FOREIGN KEY (`idpengadaan`) REFERENCES `pengadaan` (`idpengadaan`),
  CONSTRAINT `fk_penerimaan_user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerimaan`
--

LOCK TABLES `penerimaan` WRITE;
/*!40000 ALTER TABLE `penerimaan` DISABLE KEYS */;
INSERT INTO `penerimaan` VALUES (1,'2026-11-20 15:07:39','S',1,1),(2,'2026-11-20 16:49:58','S',2,1),(3,'2026-11-23 03:42:16','S',5,1),(4,'2026-11-23 03:43:25','S',4,1);
/*!40000 ALTER TABLE `penerimaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengadaan`
--

DROP TABLE IF EXISTS `pengadaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengadaan` (
  `idpengadaan` bigint(20) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_iduser` int(11) NOT NULL,
  `status` char(1) NOT NULL,
  `vendor_idvendor` int(11) NOT NULL,
  `subtotal_nilai` int(11) NOT NULL DEFAULT 0,
  `ppn` int(11) NOT NULL DEFAULT 0,
  `total_nilai` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idpengadaan`),
  KEY `fk_pengadaan_user` (`user_iduser`),
  KEY `fk_pengadaan_vendor` (`vendor_idvendor`),
  CONSTRAINT `fk_pengadaan_user` FOREIGN KEY (`user_iduser`) REFERENCES `user` (`iduser`),
  CONSTRAINT `fk_pengadaan_vendor` FOREIGN KEY (`vendor_idvendor`) REFERENCES `vendor` (`idvendor`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengadaan`
--

LOCK TABLES `pengadaan` WRITE;
/*!40000 ALTER TABLE `pengadaan` DISABLE KEYS */;
INSERT INTO `pengadaan` VALUES (1,'2026-11-02 01:36:50',5,'S',1,6200000,682000,6882000),(2,'2026-11-20 16:49:21',1,'S',2,6000,660,6660),(4,'2026-11-23 03:38:52',1,'S',3,35000,3850,38850),(5,'2026-11-23 03:39:38',1,'S',2,7000,770,7770);
/*!40000 ALTER TABLE `pengadaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penjualan`
--

DROP TABLE IF EXISTS `penjualan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penjualan` (
  `idpenjualan` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `subtotal_nilai` int(11) NOT NULL DEFAULT 0,
  `ppn` int(11) NOT NULL DEFAULT 0,
  `total_nilai` int(11) NOT NULL DEFAULT 0,
  `iduser` int(11) NOT NULL,
  `idmargin_penjualan` int(11) NOT NULL,
  PRIMARY KEY (`idpenjualan`),
  KEY `fk_penjualan_user` (`iduser`),
  KEY `fk_penjualan_margin` (`idmargin_penjualan`),
  CONSTRAINT `fk_penjualan_margin` FOREIGN KEY (`idmargin_penjualan`) REFERENCES `margin_penjualan` (`idmargin_penjualan`),
  CONSTRAINT `fk_penjualan_user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan`
--

LOCK TABLES `penjualan` WRITE;
/*!40000 ALTER TABLE `penjualan` DISABLE KEYS */;
INSERT INTO `penjualan` VALUES (1,'2026-11-20 16:14:21',356500,39215,395715,1,5),(2,'2026-11-20 16:37:43',71300,7843,79143,1,5),(3,'2026-11-23 03:46:08',409200,45012,454212,1,3);
/*!40000 ALTER TABLE `penjualan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retur`
--

DROP TABLE IF EXISTS `retur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `retur` (
  `idretur` bigint(20) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `idpenerimaan` bigint(20) NOT NULL,
  `iduser` int(11) NOT NULL,
  PRIMARY KEY (`idretur`),
  KEY `fk_retur_penerimaan` (`idpenerimaan`),
  KEY `fk_retur_user` (`iduser`),
  CONSTRAINT `fk_retur_penerimaan` FOREIGN KEY (`idpenerimaan`) REFERENCES `penerimaan` (`idpenerimaan`),
  CONSTRAINT `fk_retur_user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retur`
--

LOCK TABLES `retur` WRITE;
/*!40000 ALTER TABLE `retur` DISABLE KEYS */;
/*!40000 ALTER TABLE `retur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role` (
  `idrole` int(11) NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(100) NOT NULL,
  PRIMARY KEY (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Admin'),(2,'Pemilik Toko'),(3,'Kasir'),(4,'Staf Penerimaan dan Gudang'),(5,'Staf Pengadaan');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `satuan`
--

DROP TABLE IF EXISTS `satuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `satuan` (
  `idsatuan` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_satuan` varchar(45) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`idsatuan`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `satuan`
--

LOCK TABLES `satuan` WRITE;
/*!40000 ALTER TABLE `satuan` DISABLE KEYS */;
INSERT INTO `satuan` VALUES (1,'Sak',1),(2,'Batang',1),(3,'Kg',1),(4,'Kaleng',1),(5,'Lembar',1);
/*!40000 ALTER TABLE `satuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `idrole` int(11) NOT NULL,
  PRIMARY KEY (`iduser`),
  KEY `fk_user_role` (`idrole`),
  CONSTRAINT `fk_user_role` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'rayhaan.admin','545de52dd793ec8b0a1eb1d7e483becc5006a16c127da3834bd4615254811226',1),(2,'hendra.owner','f3ced14ae179bfb6173d1ab1506a18ca6ff893a390133ac21f2a73619892aee3',2),(3,'siti.kasir','e53c2215fe4352f82b50ac0fd8600add19724b409092d288f51324b399dbc36d',3),(4,'andi.gudang','7cb4a765dc148940f2be91bbd09e87b59fd3fcb9e2c8262c2e6f5df02768c582',4),(5,'rina.pengadaan','9a78035e293c76f7d2a0790995e9d4daf4074782dda3c2c4a71d912a1fdd949d',5);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendor` (
  `idvendor` int(11) NOT NULL AUTO_INCREMENT,
  `nama_vendor` varchar(100) NOT NULL,
  `badan_hukum` char(1) NOT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`idvendor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor`
--

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
INSERT INTO `vendor` VALUES (1,'PT Semen Nusantara Perkasa','P','A'),(2,'CV Baja Karya Utama','C','A'),(3,'UD Sinar Paku Jaya','U','A'),(4,'PT Warna Indah Cemerlang','P','A'),(5,'CV Kayu Lestari','C','N');
/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_barang`
--

DROP TABLE IF EXISTS `view_barang`;
/*!50001 DROP VIEW IF EXISTS `view_barang`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_barang` AS SELECT 
 1 AS `idbarang`,
 1 AS `nama_barang`,
 1 AS `kuantitas`,
 1 AS `jenis_barang`,
 1 AS `jenis_satuan`,
 1 AS `harga`,
 1 AS `status_barang`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_margin_penjualan`
--

DROP TABLE IF EXISTS `view_margin_penjualan`;
/*!50001 DROP VIEW IF EXISTS `view_margin_penjualan`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_margin_penjualan` AS SELECT 
 1 AS `idmargin_penjualan`,
 1 AS `persen`,
 1 AS `status_margin`,
 1 AS `ditetapkan_oleh`,
 1 AS `created_at`,
 1 AS `updated_at`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_penerimaan`
--

DROP TABLE IF EXISTS `view_penerimaan`;
/*!50001 DROP VIEW IF EXISTS `view_penerimaan`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_penerimaan` AS SELECT 
 1 AS `idpenerimaan`,
 1 AS `created_at`,
 1 AS `idpengadaan`,
 1 AS `username`,
 1 AS `total_nilai`,
 1 AS `status`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_pengadaan`
--

DROP TABLE IF EXISTS `view_pengadaan`;
/*!50001 DROP VIEW IF EXISTS `view_pengadaan`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_pengadaan` AS SELECT 
 1 AS `idpengadaan`,
 1 AS `timestamp`,
 1 AS `username`,
 1 AS `nama_vendor`,
 1 AS `subtotal_nilai`,
 1 AS `ppn`,
 1 AS `total_nilai`,
 1 AS `status`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_penjualan`
--

DROP TABLE IF EXISTS `view_penjualan`;
/*!50001 DROP VIEW IF EXISTS `view_penjualan`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_penjualan` AS SELECT 
 1 AS `idpenjualan`,
 1 AS `created_at`,
 1 AS `username`,
 1 AS `subtotal_nilai`,
 1 AS `ppn`,
 1 AS `total_nilai`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_role`
--

DROP TABLE IF EXISTS `view_role`;
/*!50001 DROP VIEW IF EXISTS `view_role`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_role` AS SELECT 
 1 AS `idrole`,
 1 AS `nama_role`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_satuan`
--

DROP TABLE IF EXISTS `view_satuan`;
/*!50001 DROP VIEW IF EXISTS `view_satuan`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_satuan` AS SELECT 
 1 AS `idsatuan`,
 1 AS `jenis_satuan`,
 1 AS `status_satuan`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_user`
--

DROP TABLE IF EXISTS `view_user`;
/*!50001 DROP VIEW IF EXISTS `view_user`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_user` AS SELECT 
 1 AS `iduser`,
 1 AS `username`,
 1 AS `nama_role`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_vendor`
--

DROP TABLE IF EXISTS `view_vendor`;
/*!50001 DROP VIEW IF EXISTS `view_vendor`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_vendor` AS SELECT 
 1 AS `idvendor`,
 1 AS `nama_vendor`,
 1 AS `badan_hukum`,
 1 AS `status_vendor`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'db_toko_bangunan_coba1'
--
/*!50003 DROP FUNCTION IF EXISTS `fn_harga_jual` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_harga_jual`(p_idbarang INT) RETURNS int(11)
    READS SQL DATA
BEGIN
    DECLARE v_harga INT DEFAULT 0;
 
    SELECT harga INTO v_harga
    FROM barang
    WHERE idbarang = p_idbarang;
 
    RETURN ROUND(v_harga * (1 + fn_margin_aktif() / 100));
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_hitung_ppn` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_hitung_ppn`(p_subtotal INT) RETURNS int(11)
    DETERMINISTIC
BEGIN
    RETURN ROUND(p_subtotal * 0.11);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_hitung_subtotal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_hitung_subtotal`(p_harga INT, p_jumlah INT) RETURNS int(11)
BEGIN
    RETURN p_harga * p_jumlah;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_idbarang_penerimaan` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_idbarang_penerimaan`(p_iddetail_penerimaan BIGINT) RETURNS int(11)
    READS SQL DATA
BEGIN
    DECLARE v_idbarang INT DEFAULT NULL;

    SELECT barang_idbarang INTO v_idbarang
    FROM detail_penerimaan
    WHERE iddetail_penerimaan = p_iddetail_penerimaan;

    RETURN v_idbarang;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_idmargin_aktif` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_idmargin_aktif`() RETURNS int(11)
    READS SQL DATA
BEGIN
    DECLARE v_id INT DEFAULT NULL;
 
    SELECT idmargin_penjualan INTO v_id
    FROM margin_penjualan
    WHERE status = 1
    ORDER BY idmargin_penjualan DESC
    LIMIT 1;
 
    RETURN v_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_margin_aktif` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_margin_aktif`() RETURNS double
    READS SQL DATA
BEGIN
    DECLARE v_persen DOUBLE DEFAULT 0;
 
    SELECT persen INTO v_persen
    FROM margin_penjualan
    WHERE status = 1
    ORDER BY idmargin_penjualan DESC
    LIMIT 1;
 
    RETURN v_persen;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_stok_terakhir` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_stok_terakhir`(p_idbarang INT) RETURNS int(11)
    READS SQL DATA
BEGIN
    DECLARE v_stok INT DEFAULT 0;

    SELECT stock INTO v_stok
    FROM kartu_stok
    WHERE idbarang = p_idbarang
    ORDER BY idkartu_stok DESC
    LIMIT 1;

    RETURN v_stok;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `fn_sudah_diterima` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_sudah_diterima`(p_idpengadaan BIGINT) RETURNS tinyint(4)
    READS SQL DATA
BEGIN
        DECLARE v_jumlah INT DEFAULT 0;

        SELECT COUNT(*) INTO v_jumlah
        FROM penerimaan
        WHERE idpengadaan = p_idpengadaan;

        RETURN IF(v_jumlah > 0, 1, 0);
    END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_buat_pengadaan` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buat_pengadaan`(
    IN  p_iduser      INT,
    IN  p_idvendor    INT,
    IN  p_idbarang    INT,
    IN  p_jumlah      INT,
    IN  p_harga       INT,
    OUT p_idpengadaan BIGINT
)
BEGIN
    DECLARE v_subtotal INT;
    DECLARE v_ppn      INT;
 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
 
    IF p_jumlah <= 0 OR p_harga <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jumlah dan harga harus lebih dari 0';
    END IF;
 
    START TRANSACTION;
 
    SET v_subtotal = fn_hitung_subtotal(p_harga, p_jumlah);
    SET v_ppn      = fn_hitung_ppn(v_subtotal);
 
    INSERT INTO pengadaan (user_iduser, status, vendor_idvendor, subtotal_nilai, ppn, total_nilai)
    VALUES (p_iduser, 'P', p_idvendor, v_subtotal, v_ppn, v_subtotal + v_ppn);
 
    SET p_idpengadaan = LAST_INSERT_ID();
 
    INSERT INTO detail_pengadaan (harga_satuan, jumlah, sub_total, idbarang, idpengadaan)
    VALUES (p_harga, p_jumlah, v_subtotal, p_idbarang, p_idpengadaan);
 
    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_buat_penjualan` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buat_penjualan`(
    IN  p_iduser      INT,
    IN  p_idbarang    INT,
    IN  p_jumlah      INT,
    OUT p_idpenjualan INT
)
BEGIN
    DECLARE v_idmargin INT;
    DECLARE v_harga    INT;
    DECLARE v_subtotal INT;
    DECLARE v_ppn      INT;
 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
 
    IF p_jumlah <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jumlah harus lebih dari 0';
    END IF;
 
    IF fn_stok_terakhir(p_idbarang) < p_jumlah THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok tidak mencukupi';
    END IF;
 
    SET v_idmargin = fn_idmargin_aktif();
    IF v_idmargin IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tidak ada margin penjualan yang aktif';
    END IF;
 
    SET v_harga    = fn_harga_jual(p_idbarang);
    SET v_subtotal = fn_hitung_subtotal(v_harga, p_jumlah);
    SET v_ppn      = fn_hitung_ppn(v_subtotal);
 
    START TRANSACTION;
 
    INSERT INTO penjualan (subtotal_nilai, ppn, total_nilai, iduser, idmargin_penjualan)
    VALUES (v_subtotal, v_ppn, v_subtotal + v_ppn, p_iduser, v_idmargin);
 
    SET p_idpenjualan = LAST_INSERT_ID();
 
    INSERT INTO detail_penjualan (harga_satuan, jumlah, subtotal, penjualan_idpenjualan, idbarang)
    VALUES (v_harga, p_jumlah, v_subtotal, p_idpenjualan, p_idbarang);
 
    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_buat_retur` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buat_retur`(
    IN  p_iduser              INT,
    IN  p_iddetail_penerimaan BIGINT,
    IN  p_jumlah              INT,
    IN  p_alasan              VARCHAR(200),
    OUT p_idretur             BIGINT
)
BEGIN
    DECLARE v_idpenerimaan  BIGINT DEFAULT NULL;
    DECLARE v_jumlah_terima INT    DEFAULT 0;
    DECLARE v_sudah_retur   INT    DEFAULT 0;
    DECLARE v_idbarang      INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    SELECT idpenerimaan, jumlah_terima
    INTO v_idpenerimaan, v_jumlah_terima
    FROM detail_penerimaan
    WHERE iddetail_penerimaan = p_iddetail_penerimaan;

    IF v_idpenerimaan IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Detail penerimaan tidak ditemukan';
    END IF;

    SELECT IFNULL(SUM(jumlah), 0) INTO v_sudah_retur
    FROM detail_retur
    WHERE iddetail_penerimaan = p_iddetail_penerimaan;

    IF p_jumlah <= 0 OR p_jumlah + v_sudah_retur > v_jumlah_terima THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jumlah retur tidak valid (melebihi jumlah yang diterima)';
    END IF;

    SET v_idbarang = fn_idbarang_penerimaan(p_iddetail_penerimaan);
    IF fn_stok_terakhir(v_idbarang) < p_jumlah THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok tidak mencukupi untuk diretur';
    END IF;

    START TRANSACTION;

    INSERT INTO retur (idpenerimaan, iduser)
    VALUES (v_idpenerimaan, p_iduser);

    SET p_idretur = LAST_INSERT_ID();

    INSERT INTO detail_retur (jumlah, alasan, idretur, iddetail_penerimaan)
    VALUES (p_jumlah, p_alasan, p_idretur, p_iddetail_penerimaan);

    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_terima_pengadaan` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_terima_pengadaan`(
    IN  p_idpengadaan  BIGINT,
    IN  p_iduser       INT,
    OUT p_idpenerimaan BIGINT
)
BEGIN
    DECLARE v_ada INT DEFAULT 0;
 
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
 
    SELECT COUNT(*) INTO v_ada FROM pengadaan WHERE idpengadaan = p_idpengadaan;
    IF v_ada = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pengadaan tidak ditemukan';
    END IF;
 
    IF fn_sudah_diterima(p_idpengadaan) = 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pengadaan ini sudah pernah diterima';
    END IF;
 
    START TRANSACTION;
 
    INSERT INTO penerimaan (status, idpengadaan, iduser)
    VALUES ('S', p_idpengadaan, p_iduser);
 
    SET p_idpenerimaan = LAST_INSERT_ID();
 
    INSERT INTO detail_penerimaan
        (idpenerimaan, barang_idbarang, jumlah_terima, harga_satuan_terima, sub_total_terima)
    SELECT p_idpenerimaan, idbarang, jumlah, harga_satuan,
           fn_hitung_subtotal(harga_satuan, jumlah)
    FROM detail_pengadaan
    WHERE idpengadaan = p_idpengadaan;
 
    UPDATE pengadaan SET status = 'S' WHERE idpengadaan = p_idpengadaan;
 
    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `view_barang`
--

/*!50001 DROP VIEW IF EXISTS `view_barang`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_barang` AS select `b`.`idbarang` AS `idbarang`,`b`.`nama` AS `nama_barang`,`b`.`kuantitas` AS `kuantitas`,case `b`.`jenis` when 'S' then 'Material Struktur' when 'F' then 'Finishing' when 'P' then 'Perlengkapan' else 'Lainnya' end AS `jenis_barang`,`s`.`jenis_satuan` AS `jenis_satuan`,`b`.`harga` AS `harga`,case `b`.`status` when 1 then 'Aktif' else 'Nonaktif' end AS `status_barang` from (`barang` `b` join `satuan` `s` on(`b`.`idsatuan` = `s`.`idsatuan`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_margin_penjualan`
--

/*!50001 DROP VIEW IF EXISTS `view_margin_penjualan`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_margin_penjualan` AS select `m`.`idmargin_penjualan` AS `idmargin_penjualan`,`m`.`persen` AS `persen`,case `m`.`status` when 1 then 'Aktif' else 'Tidak Aktif' end AS `status_margin`,`u`.`username` AS `ditetapkan_oleh`,`m`.`created_at` AS `created_at`,`m`.`updated_at` AS `updated_at` from (`margin_penjualan` `m` join `user` `u` on(`m`.`iduser` = `u`.`iduser`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_penerimaan`
--

/*!50001 DROP VIEW IF EXISTS `view_penerimaan`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_penerimaan` AS select `pr`.`idpenerimaan` AS `idpenerimaan`,`pr`.`created_at` AS `created_at`,`pr`.`idpengadaan` AS `idpengadaan`,`u`.`username` AS `username`,`pg`.`total_nilai` AS `total_nilai`,`pr`.`status` AS `status` from ((`penerimaan` `pr` join `pengadaan` `pg` on(`pr`.`idpengadaan` = `pg`.`idpengadaan`)) join `user` `u` on(`pr`.`iduser` = `u`.`iduser`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_pengadaan`
--

/*!50001 DROP VIEW IF EXISTS `view_pengadaan`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_pengadaan` AS select `p`.`idpengadaan` AS `idpengadaan`,`p`.`timestamp` AS `timestamp`,`u`.`username` AS `username`,`v`.`nama_vendor` AS `nama_vendor`,`p`.`subtotal_nilai` AS `subtotal_nilai`,`p`.`ppn` AS `ppn`,`p`.`total_nilai` AS `total_nilai`,`p`.`status` AS `status` from ((`pengadaan` `p` join `user` `u` on(`p`.`user_iduser` = `u`.`iduser`)) join `vendor` `v` on(`p`.`vendor_idvendor` = `v`.`idvendor`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_penjualan`
--

/*!50001 DROP VIEW IF EXISTS `view_penjualan`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_penjualan` AS select `pj`.`idpenjualan` AS `idpenjualan`,`pj`.`created_at` AS `created_at`,`u`.`username` AS `username`,`pj`.`subtotal_nilai` AS `subtotal_nilai`,`pj`.`ppn` AS `ppn`,`pj`.`total_nilai` AS `total_nilai` from (`penjualan` `pj` join `user` `u` on(`pj`.`iduser` = `u`.`iduser`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_role`
--

/*!50001 DROP VIEW IF EXISTS `view_role`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_role` AS select `role`.`idrole` AS `idrole`,`role`.`nama_role` AS `nama_role` from `role` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_satuan`
--

/*!50001 DROP VIEW IF EXISTS `view_satuan`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_satuan` AS select `satuan`.`idsatuan` AS `idsatuan`,`satuan`.`jenis_satuan` AS `jenis_satuan`,case `satuan`.`status` when 1 then 'Aktif' else 'Nonaktif' end AS `status_satuan` from `satuan` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_user`
--

/*!50001 DROP VIEW IF EXISTS `view_user`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_user` AS select `u`.`iduser` AS `iduser`,`u`.`username` AS `username`,`r`.`nama_role` AS `nama_role` from (`user` `u` join `role` `r` on(`u`.`idrole` = `r`.`idrole`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_vendor`
--

/*!50001 DROP VIEW IF EXISTS `view_vendor`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_vendor` AS select `vendor`.`idvendor` AS `idvendor`,`vendor`.`nama_vendor` AS `nama_vendor`,case `vendor`.`badan_hukum` when 'P' then 'PT' when 'C' then 'CV' when 'U' then 'UD' else 'Lainnya' end AS `badan_hukum`,case `vendor`.`status` when 'A' then 'Aktif' else 'Nonaktif' end AS `status_vendor` from `vendor` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-27  1:49:44
