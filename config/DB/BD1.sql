-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: tienda
-- ------------------------------------------------------
-- Server version	5.7.13-log

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
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Pantalon Caballero',1),(2,'Pantalon Dama',1),(3,'Zapato Caballero',1),(4,'Zapato Dama',1),(5,'Blusa',1),(6,'Ropa interios Dama',1),(7,'Ropa interios Caballero',1),(8,'Acesorios Dama',1),(9,'Acesorio Caballero',1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'prada','hermoza camisa',10,200000,1,1),(2,'polo','camisa de lujo',20,300000,1,2),(3,'estudi f','exclusivo',2,300400,1,3),(4,'zara','solo para gente fina',45,140999,1,4),(5,'levis','lo bueno de la moda',50,345890,1,5),(6,'titoretto','para caballero safisiticados',60,1288890,1,6),(7,'adolfo','lo ultimo en la moda',4,347000,1,7),(8,'el ganso','el buen saber',1,70000,1,8),(9,'h&m','para los mejores',23,89000,1,9),(10,'blanco','para los economicos',43,527000,1,1),(11,'srpingfield','a la moda ',76,1000000,1,2),(12,'cortefial','sin miedo al exito',4,345000,1,3),(13,'mango suit','solo para ganadores',3,650000,1,4),(14,'pimkey','para el buen trabajdor',9,53299,1,5),(15,'zara basica','los que saben de moda',2,17000,1,6);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-29  8:13:53
