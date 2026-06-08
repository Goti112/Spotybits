-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bbdd_spotybits
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `linea_pedido`
--

DROP TABLE IF EXISTS `linea_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `linea_pedido` (
  `id_linea` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unidad` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_linea`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `linea_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  CONSTRAINT `linea_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linea_pedido`
--

LOCK TABLES `linea_pedido` WRITE;
/*!40000 ALTER TABLE `linea_pedido` DISABLE KEYS */;
INSERT INTO `linea_pedido` VALUES (2,13,7,1,13.99),(5,32,7,1,13.99),(10,33,7,1,13.99),(11,34,7,1,13.99),(14,40,7,1,13.99),(17,41,7,1,13.99),(19,42,7,1,12.99),(20,43,7,1,12.99),(21,43,15,1,15.99),(22,43,18,1,9.99),(23,43,20,1,7.99),(24,44,7,1,12.99),(25,44,15,1,15.99),(26,44,18,1,9.99),(27,44,20,1,7.99),(28,45,17,1,9.99),(29,45,15,1,15.99),(30,46,15,1,15.99),(31,46,14,1,11.99),(32,47,7,1,12.99),(33,47,12,1,8.99),(34,48,7,1,12.99),(35,48,19,1,7.99),(36,49,7,1,12.99),(37,49,12,1,8.99),(38,50,7,1,12.99),(39,50,12,1,8.99);
/*!40000 ALTER TABLE `linea_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `accion` varchar(255) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_log`),
  KEY `log_ibfk_usuarios` (`id_usuario`),
  CONSTRAINT `log_ibfk_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (3,'2026-01-07 18:00:04','LOGOUT',NULL),(5,'2026-01-07 18:00:14','LOGIN',NULL),(7,'2026-01-07 18:00:24','CREAR_PEDIDO #41',NULL),(9,'2026-01-07 18:00:40','LOGOUT',NULL),(11,'2026-01-07 18:00:47','LOGIN',NULL),(13,'2026-01-07 18:01:03','LOGOUT',NULL),(15,'2026-01-07 22:41:45','LOGIN',NULL),(17,'2026-01-07 23:08:44','LOGOUT',15),(18,'2026-01-07 23:08:50','LOGIN',15),(19,'2026-01-08 12:12:25','LOGIN',15),(20,'2026-01-08 12:12:54','CAMBIAR_ESTADO_PEDIDO #41 -> completado',15),(21,'2026-01-08 12:14:55','EDITAR_PRODUCTO #7',15),(22,'2026-01-08 12:33:06','CREAR_PEDIDO #42',15),(23,'2026-01-08 12:33:12','LOGOUT',15),(24,'2026-01-08 12:52:35','LOGIN',15),(25,'2026-01-08 12:52:44','ELIMINAR_PRODUCTO #11',15),(26,'2026-01-08 12:52:47','ELIMINAR_PRODUCTO #9',15),(27,'2026-01-08 12:52:53','EDITAR_PRODUCTO #7',15),(28,'2026-01-08 12:54:01','CREAR_PRODUCTO #0 Hamburguesa Clasica',15),(29,'2026-01-08 13:10:55','CREAR_PRODUCTO #0 Pasta al pesto',15),(30,'2026-01-08 13:11:45','CREAR_PRODUCTO #0 Ensalada',15),(31,'2026-01-08 13:13:04','CREAR_PRODUCTO #0 Solomillo',15),(32,'2026-01-08 13:14:10','CREAR_PRODUCTO #0 Costillas',15),(33,'2026-01-08 13:14:41','CREAR_PRODUCTO #0 Tiramisú',15),(34,'2026-01-08 13:14:53','CREAR_PRODUCTO #0 Coulant',15),(35,'2026-01-08 13:15:08','CREAR_PRODUCTO #0 Cóctel',15),(36,'2026-01-08 13:15:27','CREAR_PRODUCTO #0 Cóctel',15),(37,'2026-01-08 13:22:05','CREAR_PEDIDO #43',15),(38,'2026-01-08 14:03:18','LOGOUT',15),(39,'2026-01-08 14:04:06','LOGIN',21),(40,'2026-01-08 14:04:08','CREAR_PEDIDO #44',21),(41,'2026-01-08 14:04:18','LOGOUT',21),(42,'2026-01-08 14:04:25','LOGIN',15),(43,'2026-01-08 14:04:36','CAMBIAR_ESTADO_PEDIDO #44 -> completado',15),(44,'2026-01-08 14:04:38','CAMBIAR_ESTADO_PEDIDO #43 -> completado',15),(45,'2026-01-08 14:04:39','CAMBIAR_ESTADO_PEDIDO #42 -> completado',15),(46,'2026-01-08 14:05:59','LOGOUT',15),(47,'2026-01-08 14:06:25','LOGIN',15),(48,'2026-01-08 14:06:30','CREAR_PEDIDO #45',15),(49,'2026-01-08 14:06:36','LOGOUT',15),(50,'2026-01-08 14:07:10','LOGIN',21),(51,'2026-01-08 14:07:14','CREAR_PEDIDO #46',21),(52,'2026-01-08 14:07:32','LOGOUT',21),(53,'2026-01-08 14:08:09','LOGIN',15),(54,'2026-01-08 14:08:25','CAMBIAR_ESTADO_PEDIDO #46 -> completado',15),(55,'2026-01-08 14:08:26','CAMBIAR_ESTADO_PEDIDO #45 -> completado',15),(56,'2026-01-08 15:44:26','LOGIN',15),(57,'2026-01-08 15:44:34','CREAR_PEDIDO #47',15),(58,'2026-01-08 15:46:59','LOGOUT',15),(59,'2026-01-08 16:18:59','LOGIN',15),(60,'2026-01-29 17:24:51','LOGIN',21),(61,'2026-01-29 17:24:55','LOGOUT',21),(62,'2026-01-29 17:35:21','LOGIN',21),(63,'2026-01-29 17:38:03','LOGOUT',21),(64,'2026-01-29 17:38:09','LOGIN',21),(65,'2026-01-29 17:38:35','CAMBIAR_ESTADO_PEDIDO #47 -> completado',21),(66,'2026-01-29 17:38:39','CREAR_PRODUCTO #0 dewf',21),(67,'2026-01-29 17:38:53','ELIMINAR_PRODUCTO #21',21),(68,'2026-01-29 17:43:04','CREAR_PEDIDO #48',21),(69,'2026-01-29 17:43:06','LOGOUT',21),(70,'2026-01-29 17:52:38','LOGIN',21),(71,'2026-01-29 17:53:18','LOGOUT',21),(72,'2026-01-29 17:55:09','LOGIN',21),(73,'2026-01-29 17:58:13','LOGOUT',21),(74,'2026-01-29 17:58:24','LOGIN',21),(75,'2026-01-29 18:58:38','CREAR_PEDIDO #49',21),(76,'2026-01-29 19:06:39','LOGOUT',21),(77,'2026-01-29 19:07:09','LOGIN',21),(78,'2026-01-29 19:12:43','CREAR_PRODUCTO #0 dsadsa',21),(79,'2026-01-29 19:12:50','CAMBIAR_ESTADO_PEDIDO #49 -> completado',21),(80,'2026-01-29 19:13:06','EDITAR_PRODUCTO #12',21),(81,'2026-02-05 17:59:25','LOGIN',22),(82,'2026-02-05 18:44:46','CAMBIAR CONTRASEÑA',22),(83,'2026-02-05 18:50:19','LOGOUT',22),(84,'2026-03-10 15:20:07','LOGIN',21),(85,'2026-03-10 15:20:22','ELIMINAR_PRODUCTO #22',21),(86,'2026-03-10 15:34:31','CREAR_PEDIDO #50',21),(87,'2026-03-19 19:07:25','LOGIN',21);
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oferta`
--

DROP TABLE IF EXISTS `oferta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oferta` (
  `id_oferta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `porcentaje` decimal(5,2) NOT NULL,
  `minimo_compra` decimal(10,2) NOT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_oferta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta`
--

LOCK TABLES `oferta` WRITE;
/*!40000 ALTER TABLE `oferta` DISABLE KEYS */;
INSERT INTO `oferta` VALUES (1,'',10.00,50.00,0),(2,'',0.00,0.00,0),(3,'',0.00,0.00,0),(4,'das',32.00,23.00,0);
/*!40000 ALTER TABLE `oferta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oferta_producto`
--

DROP TABLE IF EXISTS `oferta_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oferta_producto` (
  `id_oferta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descuento` decimal(5,2) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  PRIMARY KEY (`id_oferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta_producto`
--

LOCK TABLES `oferta_producto` WRITE;
/*!40000 ALTER TABLE `oferta_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `oferta_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `importe_total` decimal(10,2) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_oferta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `pedido_ibfk_1` (`id_usuario`),
  KEY `fk_pedido_oferta` (`id_oferta`),
  CONSTRAINT `fk_pedido_oferta` FOREIGN KEY (`id_oferta`) REFERENCES `oferta` (`id_oferta`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedido_ibfk_oferta` FOREIGN KEY (`id_oferta`) REFERENCES `oferta` (`id_oferta`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedido`
--

LOCK TABLES `pedido` WRITE;
/*!40000 ALTER TABLE `pedido` DISABLE KEYS */;
INSERT INTO `pedido` VALUES (5,'2026-01-03',24.50,'completado',NULL,NULL),(6,'2026-01-02',39.99,'completado',NULL,NULL),(11,'2026-01-06',21.00,'completado',NULL,NULL),(13,'2026-01-06',94.99,'completado',NULL,NULL),(32,'2026-01-06',164.99,'completado',21,NULL),(33,'2026-01-06',55.99,'completado',21,NULL),(34,'2026-01-06',34.99,'completado',21,NULL),(37,'2026-01-06',100.00,'completado',21,NULL),(40,'2026-01-07',167.49,'completado',21,3),(41,'2026-01-07',113.99,'completado',21,NULL),(42,'2026-01-08',12.99,'completado',15,NULL),(43,'2026-01-08',46.96,'completado',15,NULL),(44,'2026-01-08',46.96,'completado',21,NULL),(45,'2026-01-08',25.98,'completado',15,NULL),(46,'2026-01-08',27.98,'completado',21,NULL),(47,'2026-01-08',21.98,'completado',15,NULL),(48,'2026-01-29',20.98,'pendiente',21,NULL),(49,'2026-01-29',21.98,'completado',21,NULL),(50,'2026-03-10',21.98,'pendiente',21,NULL);
/*!40000 ALTER TABLE `pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_oferta` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `tipo` varchar(20) NOT NULL DEFAULT 'primer',
  PRIMARY KEY (`id_producto`),
  KEY `id_oferta` (`id_oferta`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_oferta`) REFERENCES `oferta_producto` (`id_oferta`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (7,'Pasta con tomate','Pasta con salsa de tomate y albahaca',12.99,0,NULL,'pasta-tomate.webp','primer'),(12,'Hamburguesa Clasica','Hamburguesa clásica con patatas fritas',8.99,100,NULL,'hamburguesa-clasica.webp','primer'),(13,'Pasta al pesto','Pasta al pesto con tomate cherry',12.99,100,NULL,'pasta-pesto.webp','primer'),(14,'Ensalada','Ensalada mixta con queso de cabra y frutos rojos',11.99,100,NULL,'ensalada.webp','primer'),(15,'Solomillo','Solomillo de ternera con patatas baby y chimichurri',15.99,100,NULL,'solomillo.webp','segundo'),(16,'Costillas','Costillas a la barbacoa con salsa casera y acabado caramelizado',14.99,100,NULL,'costillas.webp\r\n','segundo'),(17,'Tiramisú','Tiramisú clásico',9.99,100,NULL,'tiramisu.webp','postre'),(18,'Coulant','Coulant de chocolate con helado de vainilla',9.99,100,NULL,'coulant.webp','postre'),(19,'Cóctel','Cóctel de frutos rojos con menta',7.99,100,NULL,'coctel1.webp','bebida'),(20,'Cóctel','Cóctel tropical',7.99,100,NULL,'coctel2.webp','bebida');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `tipo_usuario` varchar(50) DEFAULT 'cliente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Juan Pérez','juan@example.com','$2y$10$dJd0GI9OK1epOMODnAXbUOY3fY9btLpqdl1Qd.CrT0niK6eEGz2e2',NULL,NULL,'cliente','2025-12-03 17:50:47'),(15,'Administrador','admin@spotybits.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,'admin','2025-12-24 14:21:35'),(19,'dasdasd','coco12@gmail.com','$2y$10$WsVO8xah/KwzacW9QvPiO.8hfqLaSlUDMRxXUbA9NcJsV8IoogGFO','C/ Sant Antoni Maria Claret Nº12 Bajo 2ª','644315226','cliente','2025-12-12 12:47:55'),(20,'malo','malo1234@gmail.com','$2y$10$i3ccTBeNt3v6.XVoHG9FT.PGFXDNp0EFF8CL1XqGZSmNJFLWPqngG','C/ Sant Antoni Maria Claret Nº12 Bajo 2ª','644315226','cliente','2025-12-17 18:33:34'),(21,'Miquel','mmanz2606@gmail.com','$2y$10$h80wX5fwhhdbttIIfe6JX.ADd7v5N9LuiS2kJ9LmgayL24KW3tgIC','C/ Sant Antoni Maria Claret Nº12 Bajo 2ª','644315226','admin','2026-01-06 19:33:52'),(22,'Miquelaaaadadsd','zorra@gmail.aaaa','$2y$10$aBo6ZDNtkX8Ht/QeEVu3rO3GITbv1F54vLlzDKCppYaghx4jfvXxG','644315226','C/ Sant Antoni Maria','cliente','2026-02-05 16:59:19');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'bbdd_spotybits'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-19 19:09:04
