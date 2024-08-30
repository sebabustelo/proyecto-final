-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ipmagna
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
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` VALUES (3,'Mostrar Captcha','No'),(5,'skin_admin','black-light'),(7,'app_email_pass_enc','qA/njzCzXuOynw19RKkNPaOzMByL9Z1zzR+mb6QghwHRUFU02YiJFz1dhXdA7fLG3sck71UdQcS3GubJ9mvweFnE2NkLVsqCd/NP6eBP7dH8eG8lEstOvbe1//jPaqbN'),(8,'reCaptchaURL','http://recaptcha.mrec.ar'),(9,'reCaptchaPublic','6LfokXkUAAAAALPPdkZS13PUa7DQ-C0ehL8tQNdM'),(10,'reCaptchaSecret','6LfokXkUAAAAAP-6DyEGNNyVjuzjK9VZvMZRwI-k'),(16,'app_email','pruebas_aplicaciones@mrecic.gov.ar');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ejemplos`
--

DROP TABLE IF EXISTS `ejemplos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ejemplos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ejemplos`
--

LOCK TABLES `ejemplos` WRITE;
/*!40000 ALTER TABLE `ejemplos` DISABLE KEYS */;
/*!40000 ALTER TABLE `ejemplos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `obras_sociales`
--

DROP TABLE IF EXISTS `obras_sociales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `obras_sociales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cuit` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obras_sociales`
--

LOCK TABLES `obras_sociales` WRITE;
/*!40000 ALTER TABLE `obras_sociales` DISABLE KEYS */;
/*!40000 ALTER TABLE `obras_sociales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rbac_acciones`
--

DROP TABLE IF EXISTS `rbac_acciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rbac_acciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` varchar(100) DEFAULT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `publico` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller` (`controller`,`action`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_acciones`
--

LOCK TABLES `rbac_acciones` WRITE;
/*!40000 ALTER TABLE `rbac_acciones` DISABLE KEYS */;
INSERT INTO `rbac_acciones` VALUES (1,'Rbac','RbacUsuarios','index',0),(2,'Rbac','RbacUsuarios','agregar',0),(3,'Rbac','RbacUsuarios','editar',0),(4,'Rbac','RbacUsuarios','eliminar',0),(5,'Rbac','RbacPerfiles','index',0),(6,'Rbac','RbacPerfiles','agregar',0),(7,'Rbac','RbacPerfiles','editar',0),(8,'Rbac','RbacPerfiles','eliminar',0),(9,'Rbac','RbacPerfiles','getAccionesByVirtualHost',0),(10,'Rbac','RbacAcciones','index',0),(11,'Rbac','RbacAcciones','eliminar',0),(12,'Rbac','RbacAcciones','sincronizar',0),(13,'Rbac','RbacAcciones','switchAccion',0),(14,'Rbac','RbacUsuarios','autocompleteLdap',0),(15,'Rbac','RbacUsuarios','validarLoginLdap',0),(16,'Rbac','RbacUsuarios','validarLoginDB',0),(17,'Rbac','RbacUsuarios','login',0),(18,'Rbac','RbacUsuarios','changePass',0),(19,'Rbac','RbacUsuarios','cambiarPerfil',0),(20,'Rbac','RbacUsuarios','recuperar',0),(21,'Rbac','RbacUsuarios','recuperarPass',0),(26,'Rbac','RbacUsuarios','cambiarEntorno',1),(27,'Rbac','Configuraciones','index',0),(28,'Rbac','Configuraciones','editar',0),(111,NULL,'Ejemplos','_null',NULL),(112,NULL,'Ejemplos','index',NULL),(113,NULL,'Ejemplos','ver',NULL),(114,NULL,'Pages','display',NULL),(115,NULL,'Pages','ditic',NULL),(124,NULL,'Pages','_null',0),(138,'Rbac','Configuraciones','_null',NULL),(139,'Rbac','RbacAcciones','_null',NULL),(141,'Rbac','RbacUsuarios','_null',NULL),(144,'Rbac','RbacPerfiles','_null',NULL),(145,'Rbac','Configuraciones','settings',NULL),(148,'Rbac','RbacPerfiles','getConditions',NULL),(150,'Rbac','RbacUsuarios','getConditions',NULL),(151,'Rbac','RbacUsuarios','clear_cache',NULL),(154,'Rbac','RbacUsuarios','delete',NULL),(171,'Db','Db','_null',NULL),(172,'Db','Db','index',NULL),(174,'Db','Db','getClientIP',NULL),(176,'Rbac','Configuraciones','eliminar',NULL),(177,'Rbac','Configuraciones','agregar',NULL),(229,'Rbac','RbacUsuarios','logout',0),(250,'Rbac','RbacUsuarios','register',NULL);
/*!40000 ALTER TABLE `rbac_acciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rbac_acciones_rbac_perfiles`
--

DROP TABLE IF EXISTS `rbac_acciones_rbac_perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rbac_acciones_rbac_perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rbac_accion_id` int(11) NOT NULL,
  `rbac_perfil_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`rbac_accion_id`,`rbac_perfil_id`),
  KEY `fk_ap_accion_idx` (`rbac_accion_id`),
  KEY `fk_ap_perfil_idx` (`rbac_perfil_id`),
  CONSTRAINT `fk_acion` FOREIGN KEY (`rbac_accion_id`) REFERENCES `rbac_acciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_perfil` FOREIGN KEY (`rbac_perfil_id`) REFERENCES `rbac_perfiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3465 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_acciones_rbac_perfiles`
--

LOCK TABLES `rbac_acciones_rbac_perfiles` WRITE;
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` DISABLE KEYS */;
INSERT INTO `rbac_acciones_rbac_perfiles` VALUES (3070,28,1),(3071,27,1),(3095,5,1),(3096,6,1),(3097,7,1),(3102,16,1),(3103,2,1),(3104,4,1),(3105,15,1),(3106,1,1),(3107,3,1),(3108,14,1),(3138,21,1),(3156,17,1),(3157,18,1),(3158,19,1),(3159,20,1),(3160,26,1),(3276,112,1),(3277,113,1),(3278,114,1),(3279,115,1),(3322,145,1),(3325,148,1),(3327,150,1),(3328,151,1),(3331,154,1),(3342,172,1),(3344,174,1),(3346,176,1),(3347,177,1),(3443,229,1),(3457,10,1),(3462,8,1),(3464,250,1);
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rbac_perfiles`
--

DROP TABLE IF EXISTS `rbac_perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rbac_perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `accion_default_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion_UNIQUE` (`descripcion`),
  KEY `rbac_perfiles_ra` (`accion_default_id`),
  CONSTRAINT `rbac_perfiles_ra` FOREIGN KEY (`accion_default_id`) REFERENCES `rbac_acciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_perfiles`
--

LOCK TABLES `rbac_perfiles` WRITE;
/*!40000 ALTER TABLE `rbac_perfiles` DISABLE KEYS */;
INSERT INTO `rbac_perfiles` VALUES (1,'Administrador',1);
/*!40000 ALTER TABLE `rbac_perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rbac_token`
--

DROP TABLE IF EXISTS `rbac_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rbac_token` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `validez` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_token`
--

LOCK TABLES `rbac_token` WRITE;
/*!40000 ALTER TABLE `rbac_token` DISABLE KEYS */;
INSERT INTO `rbac_token` VALUES (1,'0hl3vihL7R4TqbeOH8o0vwgX',2923,'2024-08-30 14:29:31','2024-08-30 14:29:31',1440);
/*!40000 ALTER TABLE `rbac_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rbac_usuarios`
--

DROP TABLE IF EXISTS `rbac_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rbac_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perfil_id` int(11) NOT NULL,
  `usuario` varchar(120) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `tipo_documento_id` int(11) DEFAULT NULL,
  `documento` varchar(45) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `seed` varchar(64) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` varchar(16) DEFAULT NULL,
  `modified_by` varchar(16) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`usuario`),
  KEY `FK_rbac_usuarios_rbac_perfiles` (`perfil_id`),
  CONSTRAINT `FK_rbac_usuarios_rbac_perfiles` FOREIGN KEY (`perfil_id`) REFERENCES `rbac_perfiles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2924 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_usuarios`
--

LOCK TABLES `rbac_usuarios` WRITE;
/*!40000 ALTER TABLE `rbac_usuarios` DISABLE KEYS */;
INSERT INTO `rbac_usuarios` VALUES (2901,1,'Flor','Florencia','Tigani',NULL,NULL,'flor@gmail.com','bdb402fd82aee66e477e15f0d31b6cac806896cc42bbdfe02eedd7e23b5c3b0d','1f4477bad7af3616c1f933a02bfabe4e',1,'2019-10-28 14:50:04','2019-10-28 14:50:04',NULL,NULL,NULL),(2902,1,'Facu','Facundo','Ramirez',NULL,NULL,'facu@gmail.com','','5c151c2a9b76f9ef26d7e0f0d00c9a89',1,NULL,NULL,NULL,NULL,NULL),(2907,1,'seba','Walter Sebastián ','Bustelo',NULL,NULL,'sebabustelo@gmail.com','51c172189a8c884a4949382a0748097103b2596900ae899c1b94a0e6b5555cf0','dfbd282c18300fa0eccceea6c5fac41f',1,NULL,NULL,NULL,'2907',NULL),(2923,1,'sebabustelo@gmail.com','Sebastian','Bustelo',NULL,NULL,NULL,'561dfe66b045305d0462693148c03140a89914d8f6ef08f88c8f4b284e24be35','79514e888b8f2acacc68738d0cbb803e',1,'2024-08-30 14:29:31','2024-08-30 14:29:31','2907','2907',NULL);
/*!40000 ALTER TABLE `rbac_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_documentos`
--

DROP TABLE IF EXISTS `tipo_documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_documentos`
--

LOCK TABLES `tipo_documentos` WRITE;
/*!40000 ALTER TABLE `tipo_documentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_archivo` varchar(65) NOT NULL,
  `nombre_original` varchar(64) NOT NULL,
  `hash_archivo` varchar(64) NOT NULL,
  `extension_archivo` varchar(10) NOT NULL,
  `hash_llave` varchar(64) NOT NULL,
  `subdir_zero` varchar(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uploads`
--

LOCK TABLES `uploads` WRITE;
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-30 10:31:39
