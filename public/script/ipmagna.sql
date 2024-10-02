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
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (3,'Columna','set para columnas','2024-09-09 18:57:10','2024-09-23 15:18:22',1),(5,'Complementos','set de complementos','2024-09-10 20:06:21','2024-09-10 16:09:07',1),(6,'Pediátricos','set pediátricos','2024-09-10 20:06:56','2024-09-10 16:09:07',1),(7,'Rodilla','set rodilla','2024-09-10 20:07:09','2024-09-10 16:09:07',1),(8,'Trauma','set trauma','2024-09-10 20:07:18','2024-09-10 16:09:07',1),(9,'Cadera','set para caderas','2024-09-10 21:03:22','2024-09-14 00:18:28',1);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` VALUES (3,'Mostrar Captcha','No'),(5,'skin_admin','black-light'),(16,'app_email','ipmagna@gmail.com'),(24,'Perfil Cliente','8');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultas`
--

DROP TABLE IF EXISTS `consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consulta_estado_id` int(11) NOT NULL,
  `usuario_consulta_id` int(11) NOT NULL,
  `usuario_respuesta_id` int(11) DEFAULT NULL,
  `motivo` text NOT NULL,
  `respuesta` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_id` (`usuario_consulta_id`),
  KEY `fk_usuario_respuesta_id` (`usuario_respuesta_id`),
  KEY `fk_consulta_estado_id_idx` (`consulta_estado_id`),
  CONSTRAINT `fk_cliente_id` FOREIGN KEY (`usuario_consulta_id`) REFERENCES `rbac_usuarios` (`id`),
  CONSTRAINT `fk_consulta_estado_id` FOREIGN KEY (`consulta_estado_id`) REFERENCES `consultas_estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_respuesta_id` FOREIGN KEY (`usuario_respuesta_id`) REFERENCES `rbac_usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
INSERT INTO `consultas` VALUES (3,6,2923,2923,'Solicito información detallada sobre el kit quirúrgico FIN SHORT]. Quisiera saber más acerca de las especificaciones técnicas, precios y tiempos de entrega.','asdfsadf','2024-09-20 01:16:19','2024-09-20 04:08:36'),(4,6,2923,2923,'saasdfsdaf','ok esta todo bien','2024-09-25 12:25:41','2024-09-25 12:30:54');
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultas_estados`
--

DROP TABLE IF EXISTS `consultas_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultas_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas_estados`
--

LOCK TABLES `consultas_estados` WRITE;
/*!40000 ALTER TABLE `consultas_estados` DISABLE KEYS */;
INSERT INTO `consultas_estados` VALUES (5,'PENDIENTE','Es el estado inicial cuando el usuario cliente envia una consulta desde el portal',1,'2024-09-20 00:10:22','2024-09-20 00:10:22'),(6,'RESPONDIDO','La consulta del cliente fue respondida por un usuario de IPMAGNA',1,'2024-09-20 00:31:43','2024-09-20 00:31:43');
/*!40000 ALTER TABLE `consultas_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalles_pedidos`
--

DROP TABLE IF EXISTS `detalles_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalles_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `fk_producto_id_idx` (`producto_id`),
  CONSTRAINT `detalles_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_producto_id` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalles_pedidos`
--

LOCK TABLES `detalles_pedidos` WRITE;
/*!40000 ALTER TABLE `detalles_pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalles_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direcciones`
--

DROP TABLE IF EXISTS `direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `direcciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rbac_usuario_id` int(11) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `piso` varchar(10) DEFAULT NULL,
  `departamento` varchar(10) DEFAULT NULL,
  `localidad_id` int(11) NOT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_direcciones_usuarios` (`rbac_usuario_id`),
  KEY `FK_direcciones_localidades_idx` (`localidad_id`),
  CONSTRAINT `FK_direcciones_localidades` FOREIGN KEY (`localidad_id`) REFERENCES `localidades` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `FK_direcciones_usuarios` FOREIGN KEY (`rbac_usuario_id`) REFERENCES `rbac_usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direcciones`
--

LOCK TABLES `direcciones` WRITE;
/*!40000 ALTER TABLE `direcciones` DISABLE KEYS */;
INSERT INTO `direcciones` VALUES (23,2990,'padilla','752','2','32',286,NULL),(24,2923,'terrero','1589','2','31',286,NULL);
/*!40000 ALTER TABLE `direcciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localidades`
--

DROP TABLE IF EXISTS `localidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `localidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provincia_id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fk_localidades_provincia` (`provincia_id`),
  CONSTRAINT `fk_localidades_provincia` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2080 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localidades`
--

LOCK TABLES `localidades` WRITE;
/*!40000 ALTER TABLE `localidades` DISABLE KEYS */;
INSERT INTO `localidades` VALUES (1,1,'25 de Mayo',1),(2,1,'3 de febrero',1),(3,1,'A. Alsina',1),(4,1,'A. Gonzáles Cháves',1),(5,1,'Aguas Verdes',1),(6,1,'Alberti',1),(7,1,'Arrecifes',1),(8,1,'Ayacucho',1),(9,1,'Azul',1),(10,1,'Bahía Blanca',1),(11,1,'Balcarce',1),(12,1,'Baradero',1),(13,1,'Benito Juárez',1),(14,1,'Berisso',1),(15,1,'Bolívar',1),(16,1,'Bragado',1),(17,1,'Brandsen',1),(18,1,'Campana',1),(19,1,'Cañuelas',1),(20,1,'Capilla del Señor',1),(21,1,'Capitán Sarmiento',1),(22,1,'Carapachay',1),(23,1,'Carhue',1),(24,1,'Cariló',1),(25,1,'Carlos Casares',1),(26,1,'Carlos Tejedor',1),(27,1,'Carmen de Areco',1),(28,1,'Carmen de Patagones',1),(29,1,'Castelli',1),(30,1,'Chacabuco',1),(31,1,'Chascomús',1),(32,1,'Chivilcoy',1),(33,1,'Colón',1),(34,1,'Coronel Dorrego',1),(35,1,'Coronel Pringles',1),(36,1,'Coronel Rosales',1),(37,1,'Coronel Suarez',1),(38,1,'Costa Azul',1),(39,1,'Costa Chica',1),(40,1,'Costa del Este',1),(41,1,'Costa Esmeralda',1),(42,1,'Daireaux',1),(43,1,'Darregueira',1),(44,1,'Del Viso',1),(45,1,'Dolores',1),(46,1,'Don Torcuato',1),(47,1,'Ensenada',1),(48,1,'Escobar',1),(49,1,'Exaltación de la Cruz',1),(50,1,'Florentino Ameghino',1),(51,1,'Garín',1),(52,1,'Gral. Alvarado',1),(53,1,'Gral. Alvear',1),(54,1,'Gral. Arenales',1),(55,1,'Gral. Belgrano',1),(56,1,'Gral. Guido',1),(57,1,'Gral. Lamadrid',1),(58,1,'Gral. Las Heras',1),(59,1,'Gral. Lavalle',1),(60,1,'Gral. Madariaga',1),(61,1,'Gral. Pacheco',1),(62,1,'Gral. Paz',1),(63,1,'Gral. Pinto',1),(64,1,'Gral. Pueyrredón',1),(65,1,'Gral. Rodríguez',1),(66,1,'Gral. Viamonte',1),(67,1,'Gral. Villegas',1),(68,1,'Guaminí',1),(69,1,'Guernica',1),(70,1,'Hipólito Yrigoyen',1),(71,1,'Ing. Maschwitz',1),(72,1,'Junín',1),(73,1,'La Plata',1),(74,1,'Laprida',1),(75,1,'Las Flores',1),(76,1,'Las Toninas',1),(77,1,'Leandro N. Alem',1),(78,1,'Lincoln',1),(79,1,'Loberia',1),(80,1,'Lobos',1),(81,1,'Los Cardales',1),(82,1,'Los Toldos',1),(83,1,'Lucila del Mar',1),(84,1,'Luján',1),(85,1,'Magdalena',1),(86,1,'Maipú',1),(87,1,'Mar Chiquita',1),(88,1,'Mar de Ajó',1),(89,1,'Mar de las Pampas',1),(90,1,'Mar del Plata',1),(91,1,'Mar del Tuyú',1),(92,1,'Marcos Paz',1),(93,1,'Mercedes',1),(94,1,'Miramar',1),(95,1,'Monte',1),(96,1,'Monte Hermoso',1),(97,1,'Munro',1),(98,1,'Navarro',1),(99,1,'Necochea',1),(100,1,'Olavarría',1),(101,1,'Partido de la Costa',1),(102,1,'Pehuajó',1),(103,1,'Pellegrini',1),(104,1,'Pergamino',1),(105,1,'Pigüé',1),(106,1,'Pila',1),(107,1,'Pilar',1),(108,1,'Pinamar',1),(109,1,'Pinar del Sol',1),(110,1,'Polvorines',1),(111,1,'Pte. Perón',1),(112,1,'Puán',1),(113,1,'Punta Indio',1),(114,1,'Ramallo',1),(115,1,'Rauch',1),(116,1,'Rivadavia',1),(117,1,'Rojas',1),(118,1,'Roque Pérez',1),(119,1,'Saavedra',1),(120,1,'Saladillo',1),(121,1,'Salliqueló',1),(122,1,'Salto',1),(123,1,'San Andrés de Giles',1),(124,1,'San Antonio de Areco',1),(125,1,'San Antonio de Padua',1),(126,1,'San Bernardo',1),(127,1,'San Cayetano',1),(128,1,'San Clemente del Tuyú',1),(129,1,'San Nicolás',1),(130,1,'San Pedro',1),(131,1,'San Vicente',1),(132,1,'Santa Teresita',1),(133,1,'Suipacha',1),(134,1,'Tandil',1),(135,1,'Tapalqué',1),(136,1,'Tordillo',1),(137,1,'Tornquist',1),(138,1,'Trenque Lauquen',1),(139,1,'Tres Lomas',1),(140,1,'Villa Gesell',1),(141,1,'Villarino',1),(142,1,'Zárate',1),(143,2,'11 de Septiembre',1),(144,2,'20 de Junio',1),(145,2,'25 de Mayo',1),(146,2,'Acassuso',1),(147,2,'Adrogué',1),(148,2,'Aldo Bonzi',1),(149,2,'Área Reserva Cinturón Ecológico',1),(150,2,'Avellaneda',1),(151,2,'Banfield',1),(152,2,'Barrio Parque',1),(153,2,'Barrio Santa Teresita',1),(154,2,'Beccar',1),(155,2,'Bella Vista',1),(156,2,'Berazategui',1),(157,2,'Bernal Este',1),(158,2,'Bernal Oeste',1),(159,2,'Billinghurst',1),(160,2,'Boulogne',1),(161,2,'Burzaco',1),(162,2,'Carapachay',1),(163,2,'Caseros',1),(164,2,'Castelar',1),(165,2,'Churruca',1),(166,2,'Ciudad Evita',1),(167,2,'Ciudad Madero',1),(168,2,'Ciudadela',1),(169,2,'Claypole',1),(170,2,'Crucecita',1),(171,2,'Dock Sud',1),(172,2,'Don Bosco',1),(173,2,'Don Orione',1),(174,2,'El Jagüel',1),(175,2,'El Libertador',1),(176,2,'El Palomar',1),(177,2,'El Tala',1),(178,2,'El Trébol',1),(179,2,'Ezeiza',1),(180,2,'Ezpeleta',1),(181,2,'Florencio Varela',1),(182,2,'Florida',1),(183,2,'Francisco Álvarez',1),(184,2,'Gerli',1),(185,2,'Glew',1),(186,2,'González Catán',1),(187,2,'Gral. Lamadrid',1),(188,2,'Grand Bourg',1),(189,2,'Gregorio de Laferrere',1),(190,2,'Guillermo Enrique Hudson',1),(191,2,'Haedo',1),(192,2,'Hurlingham',1),(193,2,'Ing. Sourdeaux',1),(194,2,'Isidro Casanova',1),(195,2,'Ituzaingó',1),(196,2,'José C. Paz',1),(197,2,'José Ingenieros',1),(198,2,'José Marmol',1),(199,2,'La Lucila',1),(200,2,'La Reja',1),(201,2,'La Tablada',1),(202,2,'Lanús',1),(203,2,'Llavallol',1),(204,2,'Loma Hermosa',1),(205,2,'Lomas de Zamora',1),(206,2,'Lomas del Millón',1),(207,2,'Lomas del Mirador',1),(208,2,'Longchamps',1),(209,2,'Los Polvorines',1),(210,2,'Luis Guillón',1),(211,2,'Malvinas Argentinas',1),(212,2,'Martín Coronado',1),(213,2,'Martínez',1),(214,2,'Merlo',1),(215,2,'Ministro Rivadavia',1),(216,2,'Monte Chingolo',1),(217,2,'Monte Grande',1),(218,2,'Moreno',1),(219,2,'Morón',1),(220,2,'Muñiz',1),(221,2,'Olivos',1),(222,2,'Pablo Nogués',1),(223,2,'Pablo Podestá',1),(224,2,'Paso del Rey',1),(225,2,'Pereyra',1),(226,2,'Piñeiro',1),(227,2,'Plátanos',1),(228,2,'Pontevedra',1),(229,2,'Quilmes',1),(230,2,'Rafael Calzada',1),(231,2,'Rafael Castillo',1),(232,2,'Ramos Mejía',1),(233,2,'Ranelagh',1),(234,2,'Remedios de Escalada',1),(235,2,'Sáenz Peña',1),(236,2,'San Antonio de Padua',1),(237,2,'San Fernando',1),(238,2,'San Francisco Solano',1),(239,2,'San Isidro',1),(240,2,'San José',1),(241,2,'San Justo',1),(242,2,'San Martín',1),(243,2,'San Miguel',1),(244,2,'Santos Lugares',1),(245,2,'Sarandí',1),(246,2,'Sourigues',1),(247,2,'Tapiales',1),(248,2,'Temperley',1),(249,2,'Tigre',1),(250,2,'Tortuguitas',1),(251,2,'Tristán Suárez',1),(252,2,'Trujui',1),(253,2,'Turdera',1),(254,2,'Valentín Alsina',1),(255,2,'Vicente López',1),(256,2,'Villa Adelina',1),(257,2,'Villa Ballester',1),(258,2,'Villa Bosch',1),(259,2,'Villa Caraza',1),(260,2,'Villa Celina',1),(261,2,'Villa Centenario',1),(262,2,'Villa de Mayo',1),(263,2,'Villa Diamante',1),(264,2,'Villa Domínico',1),(265,2,'Villa España',1),(266,2,'Villa Fiorito',1),(267,2,'Villa Guillermina',1),(268,2,'Villa Insuperable',1),(269,2,'Villa José León Suárez',1),(270,2,'Villa La Florida',1),(271,2,'Villa Luzuriaga',1),(272,2,'Villa Martelli',1),(273,2,'Villa Obrera',1),(274,2,'Villa Progreso',1),(275,2,'Villa Raffo',1),(276,2,'Villa Sarmiento',1),(277,2,'Villa Tesei',1),(278,2,'Villa Udaondo',1),(279,2,'Virrey del Pino',1),(280,2,'Wilde',1),(281,2,'William Morris',1),(282,3,'Agronomía',1),(283,3,'Almagro',1),(284,3,'Balvanera',1),(285,3,'Barracas',1),(286,3,'Belgrano',1),(287,3,'Boca',1),(288,3,'Boedo',1),(289,3,'Caballito',1),(290,3,'Chacarita',1),(291,3,'Coghlan',1),(292,3,'Colegiales',1),(293,3,'Constitución',1),(294,3,'Flores',1),(295,3,'Floresta',1),(296,3,'La Paternal',1),(297,3,'Liniers',1),(298,3,'Mataderos',1),(299,3,'Monserrat',1),(300,3,'Monte Castro',1),(301,3,'Nueva Pompeya',1),(302,3,'Núñez',1),(303,3,'Palermo',1),(304,3,'Parque Avellaneda',1),(305,3,'Parque Chacabuco',1),(306,3,'Parque Chas',1),(307,3,'Parque Patricios',1),(308,3,'Puerto Madero',1),(309,3,'Recoleta',1),(310,3,'Retiro',1),(311,3,'Saavedra',1),(312,3,'San Cristóbal',1),(313,3,'San Nicolás',1),(314,3,'San Telmo',1),(315,3,'Vélez Sársfield',1),(316,3,'Versalles',1),(317,3,'Villa Crespo',1),(318,3,'Villa del Parque',1),(319,3,'Villa Devoto',1),(320,3,'Villa Gral. Mitre',1),(321,3,'Villa Lugano',1),(322,3,'Villa Luro',1),(323,3,'Villa Ortúzar',1),(324,3,'Villa Pueyrredón',1),(325,3,'Villa Real',1),(326,3,'Villa Riachuelo',1),(327,3,'Villa Santa Rita',1),(328,3,'Villa Soldati',1),(329,3,'Villa Urquiza',1),(330,4,'Aconquija',1),(331,4,'Ancasti',1),(332,4,'Andalgalá',1),(333,4,'Antofagasta',1),(334,4,'Belén',1),(335,4,'Capayán',1),(336,4,'Capital',1),(338,4,'Corral Quemado',1),(339,4,'El Alto',1),(340,4,'El Rodeo',1),(341,4,'F.Mamerto Esquiú',1),(342,4,'Fiambalá',1),(343,4,'Hualfín',1),(344,4,'Huillapima',1),(345,4,'Icaño',1),(346,4,'La Puerta',1),(347,4,'Las Juntas',1),(348,4,'Londres',1),(349,4,'Los Altos',1),(350,4,'Los Varela',1),(351,4,'Mutquín',1),(352,4,'Paclín',1),(353,4,'Poman',1),(354,4,'Pozo de La Piedra',1),(355,4,'Puerta de Corral',1),(356,4,'Puerta San José',1),(357,4,'Recreo',1),(358,4,'S.F.V de 4',1),(359,4,'San Fernando',1),(360,4,'San Fernando del Valle',1),(361,4,'San José',1),(362,4,'Santa María',1),(363,4,'Santa Rosa',1),(364,4,'Saujil',1),(365,4,'Tapso',1),(366,4,'Tinogasta',1),(367,4,'Valle Viejo',1),(368,4,'Villa Vil',1),(369,5,'Aviá Teraí',1),(370,5,'Barranqueras',1),(371,5,'Basail',1),(372,5,'Campo Largo',1),(373,5,'Capital',1),(374,5,'Capitán Solari',1),(375,5,'Charadai',1),(376,5,'Charata',1),(377,5,'Chorotis',1),(378,5,'Ciervo Petiso',1),(379,5,'Cnel. Du Graty',1),(380,5,'Col. Benítez',1),(381,5,'Col. Elisa',1),(382,5,'Col. Popular',1),(383,5,'Colonias Unidas',1),(384,5,'Concepción',1),(385,5,'Corzuela',1),(386,5,'Cote Lai',1),(387,5,'El Sauzalito',1),(388,5,'Enrique Urien',1),(389,5,'Fontana',1),(390,5,'Fte. Esperanza',1),(391,5,'Gancedo',1),(392,5,'Gral. Capdevila',1),(393,5,'Gral. Pinero',1),(394,5,'Gral. San Martín',1),(395,5,'Gral. Vedia',1),(396,5,'Hermoso Campo',1),(397,5,'I. del Cerrito',1),(398,5,'J.J. Castelli',1),(399,5,'La Clotilde',1),(400,5,'La Eduvigis',1),(401,5,'La Escondida',1),(402,5,'La Leonesa',1),(403,5,'La Tigra',1),(404,5,'La Verde',1),(405,5,'Laguna Blanca',1),(406,5,'Laguna Limpia',1),(407,5,'Lapachito',1),(408,5,'Las Breñas',1),(409,5,'Las Garcitas',1),(410,5,'Las Palmas',1),(411,5,'Los Frentones',1),(412,5,'Machagai',1),(413,5,'Makallé',1),(414,5,'Margarita Belén',1),(415,5,'Miraflores',1),(416,5,'Misión N. Pompeya',1),(417,5,'Napenay',1),(418,5,'Pampa Almirón',1),(419,5,'Pampa del Indio',1),(420,5,'Pampa del Infierno',1),(421,5,'Pdcia. de La Plaza',1),(422,5,'Pdcia. Roca',1),(423,5,'Pdcia. Roque Sáenz Peña',1),(424,5,'Pto. Bermejo',1),(425,5,'Pto. Eva Perón',1),(426,5,'Puero Tirol',1),(427,5,'Puerto Vilelas',1),(428,5,'Quitilipi',1),(429,5,'Resistencia',1),(430,5,'Sáenz Peña',1),(431,5,'Samuhú',1),(432,5,'San Bernardo',1),(433,5,'Santa Sylvina',1),(434,5,'Taco Pozo',1),(435,5,'Tres Isletas',1),(436,5,'Villa Ángela',1),(437,5,'Villa Berthet',1),(438,5,'Villa R. Bermejito',1),(439,6,'Aldea Apeleg',1),(440,6,'Aldea Beleiro',1),(441,6,'Aldea Epulef',1),(442,6,'Alto Río Sengerr',1),(443,6,'Buen Pasto',1),(444,6,'Camarones',1),(445,6,'Carrenleufú',1),(446,6,'Cholila',1),(447,6,'Co. Centinela',1),(448,6,'Colan Conhué',1),(449,6,'Comodoro Rivadavia',1),(450,6,'Corcovado',1),(451,6,'Cushamen',1),(452,6,'Dique F. Ameghino',1),(453,6,'Dolavón',1),(454,6,'Dr. R. Rojas',1),(455,6,'El Hoyo',1),(456,6,'El Maitén',1),(457,6,'Epuyén',1),(458,6,'Esquel',1),(459,6,'Facundo',1),(460,6,'Gaimán',1),(461,6,'Gan Gan',1),(462,6,'Gastre',1),(463,6,'Gdor. Costa',1),(464,6,'Gualjaina',1),(465,6,'J. de San Martín',1),(466,6,'Lago Blanco',1),(467,6,'Lago Puelo',1),(468,6,'Lagunita Salada',1),(469,6,'Las Plumas',1),(470,6,'Los Altares',1),(471,6,'Paso de los Indios',1),(472,6,'Paso del Sapo',1),(473,6,'Pto. Madryn',1),(474,6,'Pto. Pirámides',1),(475,6,'Rada Tilly',1),(476,6,'Rawson',1),(477,6,'Río Mayo',1),(478,6,'Río Pico',1),(479,6,'Sarmiento',1),(480,6,'Tecka',1),(481,6,'Telsen',1),(482,6,'Trelew',1),(483,6,'Trevelin',1),(484,6,'Veintiocho de Julio',1),(485,7,'Achiras',1),(486,7,'Adelia Maria',1),(487,7,'Agua de Oro',1),(488,7,'Alcira Gigena',1),(489,7,'Aldea Santa Maria',1),(490,7,'Alejandro Roca',1),(491,7,'Alejo Ledesma',1),(492,7,'Alicia',1),(493,7,'Almafuerte',1),(494,7,'Alpa Corral',1),(495,7,'Alta Gracia',1),(496,7,'Alto Alegre',1),(497,7,'Alto de Los Quebrachos',1),(498,7,'Altos de Chipion',1),(499,7,'Amboy',1),(500,7,'Ambul',1),(501,7,'Ana Zumaran',1),(502,7,'Anisacate',1),(503,7,'Arguello',1),(504,7,'Arias',1),(505,7,'Arroyito',1),(506,7,'Arroyo Algodon',1),(507,7,'Arroyo Cabral',1),(508,7,'Arroyo Los Patos',1),(509,7,'Assunta',1),(510,7,'Atahona',1),(511,7,'Ausonia',1),(512,7,'Avellaneda',1),(513,7,'Ballesteros',1),(514,7,'Ballesteros Sud',1),(515,7,'Balnearia',1),(516,7,'Bañado de Soto',1),(517,7,'Bell Ville',1),(518,7,'Bengolea',1),(519,7,'Benjamin Gould',1),(520,7,'Berrotaran',1),(521,7,'Bialet Masse',1),(522,7,'Bouwer',1),(523,7,'Brinkmann',1),(524,7,'Buchardo',1),(525,7,'Bulnes',1),(526,7,'Cabalango',1),(527,7,'Calamuchita',1),(528,7,'Calchin',1),(529,7,'Calchin Oeste',1),(530,7,'Calmayo',1),(531,7,'Camilo Aldao',1),(532,7,'Caminiaga',1),(533,7,'Cañada de Luque',1),(534,7,'Cañada de Machado',1),(535,7,'Cañada de Rio Pinto',1),(536,7,'Cañada del Sauce',1),(537,7,'Canals',1),(538,7,'Candelaria Sud',1),(539,7,'Capilla de Remedios',1),(540,7,'Capilla de Siton',1),(541,7,'Capilla del Carmen',1),(542,7,'Capilla del Monte',1),(543,7,'Capital',1),(544,7,'Capitan Gral B. O´Higgins',1),(545,7,'Carnerillo',1),(546,7,'Carrilobo',1),(547,7,'Casa Grande',1),(548,7,'Cavanagh',1),(549,7,'Cerro Colorado',1),(550,7,'Chaján',1),(551,7,'Chalacea',1),(552,7,'Chañar Viejo',1),(553,7,'Chancaní',1),(554,7,'Charbonier',1),(555,7,'Charras',1),(556,7,'Chazón',1),(557,7,'Chilibroste',1),(558,7,'Chucul',1),(559,7,'Chuña',1),(560,7,'Chuña Huasi',1),(561,7,'Churqui Cañada',1),(562,7,'Cienaga Del Coro',1),(563,7,'Cintra',1),(564,7,'Col. Almada',1),(565,7,'Col. Anita',1),(566,7,'Col. Barge',1),(567,7,'Col. Bismark',1),(568,7,'Col. Bremen',1),(569,7,'Col. Caroya',1),(570,7,'Col. Italiana',1),(571,7,'Col. Iturraspe',1),(572,7,'Col. Las Cuatro Esquinas',1),(573,7,'Col. Las Pichanas',1),(574,7,'Col. Marina',1),(575,7,'Col. Prosperidad',1),(576,7,'Col. San Bartolome',1),(577,7,'Col. San Pedro',1),(578,7,'Col. Tirolesa',1),(579,7,'Col. Vicente Aguero',1),(580,7,'Col. Videla',1),(581,7,'Col. Vignaud',1),(582,7,'Col. Waltelina',1),(583,7,'Colazo',1),(584,7,'Comechingones',1),(585,7,'Conlara',1),(586,7,'Copacabana',1),(588,7,'Coronel Baigorria',1),(589,7,'Coronel Moldes',1),(590,7,'Corral de Bustos',1),(591,7,'Corralito',1),(592,7,'Cosquín',1),(593,7,'Costa Sacate',1),(594,7,'Cruz Alta',1),(595,7,'Cruz de Caña',1),(596,7,'Cruz del Eje',1),(597,7,'Cuesta Blanca',1),(598,7,'Dean Funes',1),(599,7,'Del Campillo',1),(600,7,'Despeñaderos',1),(601,7,'Devoto',1),(602,7,'Diego de Rojas',1),(603,7,'Dique Chico',1),(604,7,'El Arañado',1),(605,7,'El Brete',1),(606,7,'El Chacho',1),(607,7,'El Crispín',1),(608,7,'El Fortín',1),(609,7,'El Manzano',1),(610,7,'El Rastreador',1),(611,7,'El Rodeo',1),(612,7,'El Tío',1),(613,7,'Elena',1),(614,7,'Embalse',1),(615,7,'Esquina',1),(616,7,'Estación Gral. Paz',1),(617,7,'Estación Juárez Celman',1),(618,7,'Estancia de Guadalupe',1),(619,7,'Estancia Vieja',1),(620,7,'Etruria',1),(621,7,'Eufrasio Loza',1),(622,7,'Falda del Carmen',1),(623,7,'Freyre',1),(624,7,'Gral. Baldissera',1),(625,7,'Gral. Cabrera',1),(626,7,'Gral. Deheza',1),(627,7,'Gral. Fotheringham',1),(628,7,'Gral. Levalle',1),(629,7,'Gral. Roca',1),(630,7,'Guanaco Muerto',1),(631,7,'Guasapampa',1),(632,7,'Guatimozin',1),(633,7,'Gutenberg',1),(634,7,'Hernando',1),(635,7,'Huanchillas',1),(636,7,'Huerta Grande',1),(637,7,'Huinca Renanco',1),(638,7,'Idiazabal',1),(639,7,'Impira',1),(640,7,'Inriville',1),(641,7,'Isla Verde',1),(642,7,'Italó',1),(643,7,'James Craik',1),(644,7,'Jesús María',1),(645,7,'Jovita',1),(646,7,'Justiniano Posse',1),(647,7,'Km 658',1),(648,7,'L. V. Mansilla',1),(649,7,'La Batea',1),(650,7,'La Calera',1),(651,7,'La Carlota',1),(652,7,'La Carolina',1),(653,7,'La Cautiva',1),(654,7,'La Cesira',1),(655,7,'La Cruz',1),(656,7,'La Cumbre',1),(657,7,'La Cumbrecita',1),(658,7,'La Falda',1),(659,7,'La Francia',1),(660,7,'La Granja',1),(661,7,'La Higuera',1),(662,7,'La Laguna',1),(663,7,'La Paisanita',1),(664,7,'La Palestina',1),(666,7,'La Paquita',1),(667,7,'La Para',1),(668,7,'La Paz',1),(669,7,'La Playa',1),(670,7,'La Playosa',1),(671,7,'La Población',1),(672,7,'La Posta',1),(673,7,'La Puerta',1),(674,7,'La Quinta',1),(675,7,'La Rancherita',1),(676,7,'La Rinconada',1),(677,7,'La Serranita',1),(678,7,'La Tordilla',1),(679,7,'Laborde',1),(680,7,'Laboulaye',1),(681,7,'Laguna Larga',1),(682,7,'Las Acequias',1),(683,7,'Las Albahacas',1),(684,7,'Las Arrias',1),(685,7,'Las Bajadas',1),(686,7,'Las Caleras',1),(687,7,'Las Calles',1),(688,7,'Las Cañadas',1),(689,7,'Las Gramillas',1),(690,7,'Las Higueras',1),(691,7,'Las Isletillas',1),(692,7,'Las Junturas',1),(693,7,'Las Palmas',1),(694,7,'Las Peñas',1),(695,7,'Las Peñas Sud',1),(696,7,'Las Perdices',1),(697,7,'Las Playas',1),(698,7,'Las Rabonas',1),(699,7,'Las Saladas',1),(700,7,'Las Tapias',1),(701,7,'Las Varas',1),(702,7,'Las Varillas',1),(703,7,'Las Vertientes',1),(704,7,'Leguizamón',1),(705,7,'Leones',1),(706,7,'Los Cedros',1),(707,7,'Los Cerrillos',1),(708,7,'Los Chañaritos (C.E)',1),(709,7,'Los Chanaritos (R.S)',1),(710,7,'Los Cisnes',1),(711,7,'Los Cocos',1),(712,7,'Los Cóndores',1),(713,7,'Los Hornillos',1),(714,7,'Los Hoyos',1),(715,7,'Los Mistoles',1),(716,7,'Los Molinos',1),(717,7,'Los Pozos',1),(718,7,'Los Reartes',1),(719,7,'Los Surgentes',1),(720,7,'Los Talares',1),(721,7,'Los Zorros',1),(722,7,'Lozada',1),(723,7,'Luca',1),(724,7,'Luque',1),(725,7,'Luyaba',1),(726,7,'Malagueño',1),(727,7,'Malena',1),(728,7,'Malvinas Argentinas',1),(729,7,'Manfredi',1),(730,7,'Maquinista Gallini',1),(731,7,'Marcos Juárez',1),(732,7,'Marull',1),(733,7,'Matorrales',1),(734,7,'Mattaldi',1),(735,7,'Mayu Sumaj',1),(736,7,'Media Naranja',1),(737,7,'Melo',1),(738,7,'Mendiolaza',1),(739,7,'Mi Granja',1),(740,7,'Mina Clavero',1),(741,7,'Miramar',1),(742,7,'Morrison',1),(743,7,'Morteros',1),(744,7,'Mte. Buey',1),(745,7,'Mte. Cristo',1),(746,7,'Mte. De Los Gauchos',1),(747,7,'Mte. Leña',1),(748,7,'Mte. Maíz',1),(749,7,'Mte. Ralo',1),(750,7,'Nicolás Bruzone',1),(751,7,'Noetinger',1),(752,7,'Nono',1),(753,7,'Nueva 7',1),(754,7,'Obispo Trejo',1),(755,7,'Olaeta',1),(756,7,'Oliva',1),(757,7,'Olivares San Nicolás',1),(758,7,'Onagolty',1),(759,7,'Oncativo',1),(760,7,'Ordoñez',1),(761,7,'Pacheco De Melo',1),(762,7,'Pampayasta N.',1),(763,7,'Pampayasta S.',1),(764,7,'Panaholma',1),(765,7,'Pascanas',1),(766,7,'Pasco',1),(767,7,'Paso del Durazno',1),(768,7,'Paso Viejo',1),(769,7,'Pilar',1),(770,7,'Pincén',1),(771,7,'Piquillín',1),(772,7,'Plaza de Mercedes',1),(773,7,'Plaza Luxardo',1),(774,7,'Porteña',1),(775,7,'Potrero de Garay',1),(776,7,'Pozo del Molle',1),(777,7,'Pozo Nuevo',1),(778,7,'Pueblo Italiano',1),(779,7,'Puesto de Castro',1),(780,7,'Punta del Agua',1),(781,7,'Quebracho Herrado',1),(782,7,'Quilino',1),(783,7,'Rafael García',1),(784,7,'Ranqueles',1),(785,7,'Rayo Cortado',1),(786,7,'Reducción',1),(787,7,'Rincón',1),(788,7,'Río Bamba',1),(789,7,'Río Ceballos',1),(790,7,'Río Cuarto',1),(791,7,'Río de Los Sauces',1),(792,7,'Río Primero',1),(793,7,'Río Segundo',1),(794,7,'Río Tercero',1),(795,7,'Rosales',1),(796,7,'Rosario del Saladillo',1),(797,7,'Sacanta',1),(798,7,'Sagrada Familia',1),(799,7,'Saira',1),(800,7,'Saladillo',1),(801,7,'Saldán',1),(802,7,'Salsacate',1),(803,7,'Salsipuedes',1),(804,7,'Sampacho',1),(805,7,'San Agustín',1),(806,7,'San Antonio de Arredondo',1),(807,7,'San Antonio de Litín',1),(808,7,'San Basilio',1),(809,7,'San Carlos Minas',1),(810,7,'San Clemente',1),(811,7,'San Esteban',1),(812,7,'San Francisco',1),(813,7,'San Ignacio',1),(814,7,'San Javier',1),(815,7,'San Jerónimo',1),(816,7,'San Joaquín',1),(817,7,'San José de La Dormida',1),(818,7,'San José de Las Salinas',1),(819,7,'San Lorenzo',1),(820,7,'San Marcos Sierras',1),(821,7,'San Marcos Sud',1),(822,7,'San Pedro',1),(823,7,'San Pedro N.',1),(824,7,'San Roque',1),(825,7,'San Vicente',1),(826,7,'Santa Catalina',1),(827,7,'Santa Elena',1),(828,7,'Santa Eufemia',1),(829,7,'Santa Maria',1),(830,7,'Sarmiento',1),(831,7,'Saturnino M.Laspiur',1),(832,7,'Sauce Arriba',1),(833,7,'Sebastián Elcano',1),(834,7,'Seeber',1),(835,7,'Segunda Usina',1),(836,7,'Serrano',1),(837,7,'Serrezuela',1),(838,7,'Sgo. Temple',1),(839,7,'Silvio Pellico',1),(840,7,'Simbolar',1),(841,7,'Sinsacate',1),(842,7,'Sta. Rosa de Calamuchita',1),(843,7,'Sta. Rosa de Río Primero',1),(844,7,'Suco',1),(845,7,'Tala Cañada',1),(846,7,'Tala Huasi',1),(847,7,'Talaini',1),(848,7,'Tancacha',1),(849,7,'Tanti',1),(850,7,'Ticino',1),(851,7,'Tinoco',1),(852,7,'Tío Pujio',1),(853,7,'Toledo',1),(854,7,'Toro Pujio',1),(855,7,'Tosno',1),(856,7,'Tosquita',1),(857,7,'Tránsito',1),(858,7,'Tuclame',1),(859,7,'Tutti',1),(860,7,'Ucacha',1),(861,7,'Unquillo',1),(862,7,'Valle de Anisacate',1),(863,7,'Valle Hermoso',1),(864,7,'Vélez Sarfield',1),(865,7,'Viamonte',1),(866,7,'Vicuña Mackenna',1),(867,7,'Villa Allende',1),(868,7,'Villa Amancay',1),(869,7,'Villa Ascasubi',1),(870,7,'Villa Candelaria N.',1),(871,7,'Villa Carlos Paz',1),(872,7,'Villa Cerro Azul',1),(873,7,'Villa Ciudad de América',1),(874,7,'Villa Ciudad Pque Los Reartes',1),(875,7,'Villa Concepción del Tío',1),(876,7,'Villa Cura Brochero',1),(877,7,'Villa de Las Rosas',1),(878,7,'Villa de María',1),(879,7,'Villa de Pocho',1),(880,7,'Villa de Soto',1),(881,7,'Villa del Dique',1),(882,7,'Villa del Prado',1),(883,7,'Villa del Rosario',1),(884,7,'Villa del Totoral',1),(885,7,'Villa Dolores',1),(886,7,'Villa El Chancay',1),(887,7,'Villa Elisa',1),(888,7,'Villa Flor Serrana',1),(889,7,'Villa Fontana',1),(890,7,'Villa Giardino',1),(891,7,'Villa Gral. Belgrano',1),(892,7,'Villa Gutierrez',1),(893,7,'Villa Huidobro',1),(894,7,'Villa La Bolsa',1),(895,7,'Villa Los Aromos',1),(896,7,'Villa Los Patos',1),(897,7,'Villa María',1),(898,7,'Villa Nueva',1),(899,7,'Villa Pque. Santa Ana',1),(900,7,'Villa Pque. Siquiman',1),(901,7,'Villa Quillinzo',1),(902,7,'Villa Rossi',1),(903,7,'Villa Rumipal',1),(904,7,'Villa San Esteban',1),(905,7,'Villa San Isidro',1),(906,7,'Villa 21',1),(907,7,'Villa Sarmiento (G.R)',1),(908,7,'Villa Sarmiento (S.A)',1),(909,7,'Villa Tulumba',1),(910,7,'Villa Valeria',1),(911,7,'Villa Yacanto',1),(912,7,'Washington',1),(913,7,'Wenceslao Escalante',1),(914,7,'Ycho Cruz Sierras',1),(915,8,'Alvear',1),(916,8,'Bella Vista',1),(917,8,'Berón de Astrada',1),(918,8,'Bonpland',1),(919,8,'Caá Cati',1),(920,8,'Capital',1),(921,8,'Chavarría',1),(922,8,'Col. C. Pellegrini',1),(923,8,'Col. Libertad',1),(924,8,'Col. Liebig',1),(925,8,'Col. Sta Rosa',1),(926,8,'Concepción',1),(927,8,'Cruz de Los Milagros',1),(928,8,'Curuzú-Cuatiá',1),(929,8,'Empedrado',1),(930,8,'Esquina',1),(931,8,'Estación Torrent',1),(932,8,'Felipe Yofré',1),(933,8,'Garruchos',1),(934,8,'Gdor. Agrónomo',1),(935,8,'Gdor. Martínez',1),(936,8,'Goya',1),(937,8,'Guaviravi',1),(938,8,'Herlitzka',1),(939,8,'Ita-Ibate',1),(940,8,'Itatí',1),(941,8,'Ituzaingó',1),(942,8,'José Rafael Gómez',1),(943,8,'Juan Pujol',1),(944,8,'La Cruz',1),(945,8,'Lavalle',1),(946,8,'Lomas de Vallejos',1),(947,8,'Loreto',1),(948,8,'Mariano I. Loza',1),(949,8,'Mburucuyá',1),(950,8,'Mercedes',1),(951,8,'Mocoretá',1),(952,8,'Mte. Caseros',1),(953,8,'Nueve de Julio',1),(954,8,'Palmar Grande',1),(955,8,'Parada Pucheta',1),(956,8,'Paso de La Patria',1),(957,8,'Paso de Los Libres',1),(958,8,'Pedro R. Fernandez',1),(959,8,'Perugorría',1),(960,8,'Pueblo Libertador',1),(961,8,'Ramada Paso',1),(962,8,'Riachuelo',1),(963,8,'Saladas',1),(964,8,'San Antonio',1),(965,8,'San Carlos',1),(966,8,'San Cosme',1),(967,8,'San Lorenzo',1),(968,8,'20 del Palmar',1),(969,8,'San Miguel',1),(970,8,'San Roque',1),(971,8,'Santa Ana',1),(972,8,'Santa Lucía',1),(973,8,'Santo Tomé',1),(974,8,'Sauce',1),(975,8,'Tabay',1),(976,8,'Tapebicuá',1),(977,8,'Tatacua',1),(978,8,'Virasoro',1),(979,8,'Yapeyú',1),(980,8,'Yataití Calle',1),(981,9,'Alarcón',1),(982,9,'Alcaraz',1),(983,9,'Alcaraz N.',1),(984,9,'Alcaraz S.',1),(985,9,'Aldea Asunción',1),(986,9,'Aldea Brasilera',1),(987,9,'Aldea Elgenfeld',1),(988,9,'Aldea Grapschental',1),(989,9,'Aldea Ma. Luisa',1),(990,9,'Aldea Protestante',1),(991,9,'Aldea Salto',1),(992,9,'Aldea San Antonio (G)',1),(993,9,'Aldea San Antonio (P)',1),(994,9,'Aldea 19',1),(995,9,'Aldea San Miguel',1),(996,9,'Aldea San Rafael',1),(997,9,'Aldea Spatzenkutter',1),(998,9,'Aldea Sta. María',1),(999,9,'Aldea Sta. Rosa',1),(1000,9,'Aldea Valle María',1),(1001,9,'Altamirano Sur',1),(1002,9,'Antelo',1),(1003,9,'Antonio Tomás',1),(1004,9,'Aranguren',1),(1005,9,'Arroyo Barú',1),(1006,9,'Arroyo Burgos',1),(1007,9,'Arroyo Clé',1),(1008,9,'Arroyo Corralito',1),(1009,9,'Arroyo del Medio',1),(1010,9,'Arroyo Maturrango',1),(1011,9,'Arroyo Palo Seco',1),(1012,9,'Banderas',1),(1013,9,'Basavilbaso',1),(1014,9,'Betbeder',1),(1015,9,'Bovril',1),(1016,9,'Caseros',1),(1017,9,'Ceibas',1),(1018,9,'Cerrito',1),(1019,9,'Chajarí',1),(1020,9,'Chilcas',1),(1021,9,'Clodomiro Ledesma',1),(1022,9,'Col. Alemana',1),(1023,9,'Col. Avellaneda',1),(1024,9,'Col. Avigdor',1),(1025,9,'Col. Ayuí',1),(1026,9,'Col. Baylina',1),(1027,9,'Col. Carrasco',1),(1028,9,'Col. Celina',1),(1029,9,'Col. Cerrito',1),(1030,9,'Col. Crespo',1),(1031,9,'Col. Elia',1),(1032,9,'Col. Ensayo',1),(1033,9,'Col. Gral. Roca',1),(1034,9,'Col. La Argentina',1),(1035,9,'Col. Merou',1),(1036,9,'Col. Oficial Nª3',1),(1037,9,'Col. Oficial Nº13',1),(1038,9,'Col. Oficial Nº14',1),(1039,9,'Col. Oficial Nº5',1),(1040,9,'Col. Reffino',1),(1041,9,'Col. Tunas',1),(1042,9,'Col. Viraró',1),(1043,9,'Colón',1),(1044,9,'Concepción del Uruguay',1),(1045,9,'Concordia',1),(1046,9,'Conscripto Bernardi',1),(1047,9,'Costa Grande',1),(1048,9,'Costa San Antonio',1),(1049,9,'Costa Uruguay N.',1),(1050,9,'Costa Uruguay S.',1),(1051,9,'Crespo',1),(1052,9,'Crucecitas 3ª',1),(1053,9,'Crucecitas 7ª',1),(1054,9,'Crucecitas 8ª',1),(1055,9,'Cuchilla Redonda',1),(1056,9,'Curtiembre',1),(1057,9,'Diamante',1),(1058,9,'Distrito 6º',1),(1059,9,'Distrito Chañar',1),(1060,9,'Distrito Chiqueros',1),(1061,9,'Distrito Cuarto',1),(1062,9,'Distrito Diego López',1),(1063,9,'Distrito Pajonal',1),(1064,9,'Distrito Sauce',1),(1065,9,'Distrito Tala',1),(1066,9,'Distrito Talitas',1),(1067,9,'Don Cristóbal 1ª Sección',1),(1068,9,'Don Cristóbal 2ª Sección',1),(1069,9,'Durazno',1),(1070,9,'El Cimarrón',1),(1071,9,'El Gramillal',1),(1072,9,'El Palenque',1),(1073,9,'El Pingo',1),(1074,9,'El Quebracho',1),(1075,9,'El Redomón',1),(1076,9,'El Solar',1),(1077,9,'Enrique Carbo',1),(1079,9,'Espinillo N.',1),(1080,9,'Estación Campos',1),(1081,9,'Estación Escriña',1),(1082,9,'Estación Lazo',1),(1083,9,'Estación Raíces',1),(1084,9,'Estación Yerúa',1),(1085,9,'Estancia Grande',1),(1086,9,'Estancia Líbaros',1),(1087,9,'Estancia Racedo',1),(1088,9,'Estancia Solá',1),(1089,9,'Estancia Yuquerí',1),(1090,9,'Estaquitas',1),(1091,9,'Faustino M. Parera',1),(1092,9,'Febre',1),(1093,9,'Federación',1),(1094,9,'Federal',1),(1095,9,'Gdor. Echagüe',1),(1096,9,'Gdor. Mansilla',1),(1097,9,'Gilbert',1),(1098,9,'González Calderón',1),(1099,9,'Gral. Almada',1),(1100,9,'Gral. Alvear',1),(1101,9,'Gral. Campos',1),(1102,9,'Gral. Galarza',1),(1103,9,'Gral. Ramírez',1),(1104,9,'Gualeguay',1),(1105,9,'Gualeguaychú',1),(1106,9,'Gualeguaycito',1),(1107,9,'Guardamonte',1),(1108,9,'Hambis',1),(1109,9,'Hasenkamp',1),(1110,9,'Hernandarias',1),(1111,9,'Hernández',1),(1112,9,'Herrera',1),(1113,9,'Hinojal',1),(1114,9,'Hocker',1),(1115,9,'Ing. Sajaroff',1),(1116,9,'Irazusta',1),(1117,9,'Isletas',1),(1118,9,'J.J De Urquiza',1),(1119,9,'Jubileo',1),(1120,9,'La Clarita',1),(1121,9,'La Criolla',1),(1122,9,'La Esmeralda',1),(1123,9,'La Florida',1),(1124,9,'La Fraternidad',1),(1125,9,'La Hierra',1),(1126,9,'La Ollita',1),(1127,9,'La Paz',1),(1128,9,'La Picada',1),(1129,9,'La Providencia',1),(1130,9,'La Verbena',1),(1131,9,'Laguna Benítez',1),(1132,9,'Larroque',1),(1133,9,'Las Cuevas',1),(1134,9,'Las Garzas',1),(1135,9,'Las Guachas',1),(1136,9,'Las Mercedes',1),(1137,9,'Las Moscas',1),(1138,9,'Las Mulitas',1),(1139,9,'Las Toscas',1),(1140,9,'Laurencena',1),(1141,9,'Libertador San Martín',1),(1142,9,'Loma Limpia',1),(1143,9,'Los Ceibos',1),(1144,9,'Los Charruas',1),(1145,9,'Los Conquistadores',1),(1146,9,'Lucas González',1),(1147,9,'Lucas N.',1),(1148,9,'Lucas S. 1ª',1),(1149,9,'Lucas S. 2ª',1),(1150,9,'Maciá',1),(1151,9,'María Grande',1),(1152,9,'María Grande 2ª',1),(1153,9,'Médanos',1),(1154,9,'Mojones N.',1),(1155,9,'Mojones S.',1),(1156,9,'Molino Doll',1),(1157,9,'Monte Redondo',1),(1158,9,'Montoya',1),(1159,9,'Mulas Grandes',1),(1160,9,'Ñancay',1),(1161,9,'Nogoyá',1),(1162,9,'Nueva Escocia',1),(1163,9,'Nueva Vizcaya',1),(1164,9,'Ombú',1),(1165,9,'Oro Verde',1),(1166,9,'Paraná',1),(1167,9,'Pasaje Guayaquil',1),(1168,9,'Pasaje Las Tunas',1),(1169,9,'Paso de La Arena',1),(1170,9,'Paso de La Laguna',1),(1171,9,'Paso de Las Piedras',1),(1172,9,'Paso Duarte',1),(1173,9,'Pastor Britos',1),(1174,9,'Pedernal',1),(1175,9,'Perdices',1),(1176,9,'Picada Berón',1),(1177,9,'Piedras Blancas',1),(1178,9,'Primer Distrito Cuchilla',1),(1179,9,'Primero de Mayo',1),(1180,9,'Pronunciamiento',1),(1181,9,'Pto. Algarrobo',1),(1182,9,'Pto. Ibicuy',1),(1183,9,'Pueblo Brugo',1),(1184,9,'Pueblo Cazes',1),(1185,9,'Pueblo Gral. Belgrano',1),(1186,9,'Pueblo Liebig',1),(1187,9,'Puerto Yeruá',1),(1188,9,'Punta del Monte',1),(1189,9,'Quebracho',1),(1190,9,'Quinto Distrito',1),(1191,9,'Raices Oeste',1),(1192,9,'Rincón de Nogoyá',1),(1193,9,'Rincón del Cinto',1),(1194,9,'Rincón del Doll',1),(1195,9,'Rincón del Gato',1),(1196,9,'Rocamora',1),(1197,9,'Rosario del Tala',1),(1198,9,'San Benito',1),(1199,9,'San Cipriano',1),(1200,9,'San Ernesto',1),(1201,9,'San Gustavo',1),(1202,9,'San Jaime',1),(1203,9,'San José',1),(1204,9,'San José de Feliciano',1),(1205,9,'San Justo',1),(1206,9,'San Marcial',1),(1207,9,'San Pedro',1),(1208,9,'San Ramírez',1),(1209,9,'San Ramón',1),(1210,9,'San Roque',1),(1211,9,'San Salvador',1),(1212,9,'San Víctor',1),(1213,9,'Santa Ana',1),(1214,9,'Santa Anita',1),(1215,9,'Santa Elena',1),(1216,9,'Santa Lucía',1),(1217,9,'Santa Luisa',1),(1218,9,'Sauce de Luna',1),(1219,9,'Sauce Montrull',1),(1220,9,'Sauce Pinto',1),(1221,9,'Sauce Sur',1),(1222,9,'Seguí',1),(1223,9,'Sir Leonard',1),(1224,9,'Sosa',1),(1225,9,'Tabossi',1),(1226,9,'Tezanos Pinto',1),(1227,9,'Ubajay',1),(1228,9,'Urdinarrain',1),(1229,9,'Veinte de Septiembre',1),(1230,9,'Viale',1),(1231,9,'Victoria',1),(1232,9,'Villa Clara',1),(1233,9,'Villa del Rosario',1),(1234,9,'Villa Domínguez',1),(1235,9,'Villa Elisa',1),(1236,9,'Villa Fontana',1),(1237,9,'Villa Gdor. Etchevehere',1),(1238,9,'Villa Mantero',1),(1239,9,'Villa Paranacito',1),(1240,9,'Villa Urquiza',1),(1241,9,'Villaguay',1),(1242,9,'Walter Moss',1),(1243,9,'Yacaré',1),(1244,9,'Yeso Oeste',1),(1245,10,'Buena Vista',1),(1246,10,'Clorinda',1),(1247,10,'Col. Pastoril',1),(1248,10,'Cte. Fontana',1),(1249,10,'El Colorado',1),(1250,10,'El Espinillo',1),(1251,10,'Estanislao Del Campo',1),(1253,10,'Fortín Lugones',1),(1254,10,'Gral. Lucio V. Mansilla',1),(1255,10,'Gral. Manuel Belgrano',1),(1256,10,'Gral. Mosconi',1),(1257,10,'Gran Guardia',1),(1258,10,'Herradura',1),(1259,10,'Ibarreta',1),(1260,10,'Ing. Juárez',1),(1261,10,'Laguna Blanca',1),(1262,10,'Laguna Naick Neck',1),(1263,10,'Laguna Yema',1),(1264,10,'Las Lomitas',1),(1265,10,'Los Chiriguanos',1),(1266,10,'Mayor V. Villafañe',1),(1267,10,'Misión San Fco.',1),(1268,10,'Palo Santo',1),(1269,10,'Pirané',1),(1270,10,'Pozo del Maza',1),(1271,10,'Riacho He-He',1),(1272,10,'San Hilario',1),(1273,10,'San Martín II',1),(1274,10,'Siete Palmas',1),(1275,10,'Subteniente Perín',1),(1276,10,'Tres Lagunas',1),(1277,10,'Villa Dos Trece',1),(1278,10,'Villa Escolar',1),(1279,10,'Villa Gral. Güemes',1),(1280,11,'Abdon Castro Tolay',1),(1281,11,'Abra Pampa',1),(1282,11,'Abralaite',1),(1283,11,'Aguas Calientes',1),(1284,11,'Arrayanal',1),(1285,11,'Barrios',1),(1286,11,'Caimancito',1),(1287,11,'Calilegua',1),(1288,11,'Cangrejillos',1),(1289,11,'Caspala',1),(1290,11,'Catuá',1),(1291,11,'Cieneguillas',1),(1292,11,'Coranzulli',1),(1293,11,'Cusi-Cusi',1),(1294,11,'El Aguilar',1),(1295,11,'El Carmen',1),(1296,11,'El Cóndor',1),(1297,11,'El Fuerte',1),(1298,11,'El Piquete',1),(1299,11,'El Talar',1),(1300,11,'Fraile Pintado',1),(1301,11,'Hipólito Yrigoyen',1),(1302,11,'Huacalera',1),(1303,11,'Humahuaca',1),(1304,11,'La Esperanza',1),(1305,11,'La Mendieta',1),(1306,11,'La Quiaca',1),(1307,11,'Ledesma',1),(1308,11,'Libertador Gral. San Martin',1),(1309,11,'Maimara',1),(1310,11,'Mina Pirquitas',1),(1311,11,'Monterrico',1),(1312,11,'Palma Sola',1),(1313,11,'Palpalá',1),(1314,11,'Pampa Blanca',1),(1315,11,'Pampichuela',1),(1316,11,'Perico',1),(1317,11,'Puesto del Marqués',1),(1318,11,'Puesto Viejo',1),(1319,11,'Pumahuasi',1),(1320,11,'Purmamarca',1),(1321,11,'Rinconada',1),(1322,11,'Rodeitos',1),(1323,11,'Rosario de Río Grande',1),(1324,11,'San Antonio',1),(1325,11,'San Francisco',1),(1326,11,'San Pedro',1),(1327,11,'San Rafael',1),(1328,11,'San Salvador',1),(1329,11,'Santa Ana',1),(1330,11,'Santa Catalina',1),(1331,11,'Santa Clara',1),(1332,11,'Susques',1),(1333,11,'Tilcara',1),(1334,11,'Tres Cruces',1),(1335,11,'Tumbaya',1),(1336,11,'Valle Grande',1),(1337,11,'Vinalito',1),(1338,11,'Volcán',1),(1339,11,'Yala',1),(1340,11,'Yaví',1),(1341,11,'Yuto',1),(1342,12,'Abramo',1),(1343,12,'Adolfo Van Praet',1),(1344,12,'Agustoni',1),(1345,12,'Algarrobo del Aguila',1),(1346,12,'Alpachiri',1),(1347,12,'Alta Italia',1),(1348,12,'Anguil',1),(1349,12,'Arata',1),(1350,12,'Ataliva Roca',1),(1351,12,'Bernardo Larroude',1),(1352,12,'Bernasconi',1),(1353,12,'Caleufú',1),(1354,12,'Carro Quemado',1),(1355,12,'Catriló',1),(1356,12,'Ceballos',1),(1357,12,'Chacharramendi',1),(1358,12,'Col. Barón',1),(1359,12,'Col. Santa María',1),(1360,12,'Conhelo',1),(1361,12,'Coronel Hilario Lagos',1),(1362,12,'Cuchillo-Có',1),(1363,12,'Doblas',1),(1364,12,'Dorila',1),(1365,12,'Eduardo Castex',1),(1366,12,'Embajador Martini',1),(1367,12,'Falucho',1),(1368,12,'Gral. Acha',1),(1369,12,'Gral. Manuel Campos',1),(1370,12,'Gral. Pico',1),(1371,12,'Guatraché',1),(1372,12,'Ing. Luiggi',1),(1373,12,'Intendente Alvear',1),(1374,12,'Jacinto Arauz',1),(1375,12,'La Adela',1),(1376,12,'La Humada',1),(1377,12,'La Maruja',1),(1379,12,'La Reforma',1),(1380,12,'Limay Mahuida',1),(1381,12,'Lonquimay',1),(1382,12,'Loventuel',1),(1383,12,'Luan Toro',1),(1384,12,'Macachín',1),(1385,12,'Maisonnave',1),(1386,12,'Mauricio Mayer',1),(1387,12,'Metileo',1),(1388,12,'Miguel Cané',1),(1389,12,'Miguel Riglos',1),(1390,12,'Monte Nievas',1),(1391,12,'Parera',1),(1392,12,'Perú',1),(1393,12,'Pichi-Huinca',1),(1394,12,'Puelches',1),(1395,12,'Puelén',1),(1396,12,'Quehue',1),(1397,12,'Quemú Quemú',1),(1398,12,'Quetrequén',1),(1399,12,'Rancul',1),(1400,12,'Realicó',1),(1401,12,'Relmo',1),(1402,12,'Rolón',1),(1403,12,'Rucanelo',1),(1404,12,'Sarah',1),(1405,12,'Speluzzi',1),(1406,12,'Sta. Isabel',1),(1407,12,'Sta. Rosa',1),(1408,12,'Sta. Teresa',1),(1409,12,'Telén',1),(1410,12,'Toay',1),(1411,12,'Tomas M. de Anchorena',1),(1412,12,'Trenel',1),(1413,12,'Unanue',1),(1414,12,'Uriburu',1),(1415,12,'Veinticinco de Mayo',1),(1416,12,'Vertiz',1),(1417,12,'Victorica',1),(1418,12,'Villa Mirasol',1),(1419,12,'Winifreda',1),(1420,13,'Arauco',1),(1421,13,'Capital',1),(1422,13,'Castro Barros',1),(1423,13,'Chamical',1),(1424,13,'Chilecito',1),(1425,13,'Coronel F. Varela',1),(1426,13,'Famatina',1),(1427,13,'Gral. A.V.Peñaloza',1),(1428,13,'Gral. Belgrano',1),(1429,13,'Gral. J.F. Quiroga',1),(1430,13,'Gral. Lamadrid',1),(1431,13,'Gral. Ocampo',1),(1432,13,'Gral. San Martín',1),(1433,13,'Independencia',1),(1434,13,'Rosario Penaloza',1),(1435,13,'San Blas de Los Sauces',1),(1436,13,'Sanagasta',1),(1437,13,'Vinchina',1),(1438,14,'Capital',1),(1439,14,'Chacras de Coria',1),(1440,14,'Dorrego',1),(1441,14,'Gllen',1),(1442,14,'Godoy Cruz',1),(1443,14,'Gral. Alvear',1),(1444,14,'Guaymallén',1),(1445,14,'Junín',1),(1446,14,'La Paz',1),(1447,14,'Las Heras',1),(1448,14,'Lavalle',1),(1449,14,'Luján',1),(1450,14,'Luján De Cuyo',1),(1451,14,'Maipú',1),(1452,14,'Malargüe',1),(1453,14,'Rivadavia',1),(1454,14,'San Carlos',1),(1455,14,'San Martín',1),(1456,14,'San Rafael',1),(1457,14,'Sta. Rosa',1),(1458,14,'Tunuyán',1),(1459,14,'Tupungato',1),(1460,14,'Villa Nueva',1),(1461,15,'Alba Posse',1),(1462,15,'Almafuerte',1),(1463,15,'Apóstoles',1),(1464,15,'Aristóbulo Del Valle',1),(1465,15,'Arroyo Del Medio',1),(1466,15,'Azara',1),(1467,15,'Bdo. De Irigoyen',1),(1468,15,'Bonpland',1),(1469,15,'Caá Yari',1),(1470,15,'Campo Grande',1),(1471,15,'Campo Ramón',1),(1472,15,'Campo Viera',1),(1473,15,'Candelaria',1),(1474,15,'Capioví',1),(1475,15,'Caraguatay',1),(1476,15,'Cdte. Guacurarí',1),(1477,15,'Cerro Azul',1),(1478,15,'Cerro Corá',1),(1479,15,'Col. Alberdi',1),(1480,15,'Col. Aurora',1),(1481,15,'Col. Delicia',1),(1482,15,'Col. Polana',1),(1483,15,'Col. Victoria',1),(1484,15,'Col. Wanda',1),(1485,15,'Concepción De La Sierra',1),(1486,15,'Corpus',1),(1487,15,'Dos Arroyos',1),(1488,15,'Dos de Mayo',1),(1489,15,'El Alcázar',1),(1490,15,'El Dorado',1),(1491,15,'El Soberbio',1),(1492,15,'Esperanza',1),(1493,15,'F. Ameghino',1),(1494,15,'Fachinal',1),(1495,15,'Garuhapé',1),(1496,15,'Garupá',1),(1497,15,'Gdor. López',1),(1498,15,'Gdor. Roca',1),(1499,15,'Gral. Alvear',1),(1500,15,'Gral. Urquiza',1),(1501,15,'Guaraní',1),(1502,15,'H. Yrigoyen',1),(1503,15,'Iguazú',1),(1504,15,'Itacaruaré',1),(1505,15,'Jardín América',1),(1506,15,'Leandro N. Alem',1),(1507,15,'Libertad',1),(1508,15,'Loreto',1),(1509,15,'Los Helechos',1),(1510,15,'Mártires',1),(1512,15,'Mojón Grande',1),(1513,15,'Montecarlo',1),(1514,15,'Nueve de Julio',1),(1515,15,'Oberá',1),(1516,15,'Olegario V. Andrade',1),(1517,15,'Panambí',1),(1518,15,'Posadas',1),(1519,15,'Profundidad',1),(1520,15,'Pto. Iguazú',1),(1521,15,'Pto. Leoni',1),(1522,15,'Pto. Piray',1),(1523,15,'Pto. Rico',1),(1524,15,'Ruiz de Montoya',1),(1525,15,'San Antonio',1),(1526,15,'San Ignacio',1),(1527,15,'San Javier',1),(1528,15,'San José',1),(1529,15,'San Martín',1),(1530,15,'San Pedro',1),(1531,15,'San Vicente',1),(1532,15,'Santiago De Liniers',1),(1533,15,'Santo Pipo',1),(1534,15,'Sta. Ana',1),(1535,15,'Sta. María',1),(1536,15,'Tres Capones',1),(1537,15,'Veinticinco de Mayo',1),(1538,15,'Wanda',1),(1539,16,'Aguada San Roque',1),(1540,16,'Aluminé',1),(1541,16,'Andacollo',1),(1542,16,'Añelo',1),(1543,16,'Bajada del Agrio',1),(1544,16,'Barrancas',1),(1545,16,'Buta Ranquil',1),(1546,16,'Capital',1),(1547,16,'Caviahué',1),(1548,16,'Centenario',1),(1549,16,'Chorriaca',1),(1550,16,'Chos Malal',1),(1551,16,'Cipolletti',1),(1552,16,'Covunco Abajo',1),(1553,16,'Coyuco Cochico',1),(1554,16,'Cutral Có',1),(1555,16,'El Cholar',1),(1556,16,'El Huecú',1),(1557,16,'El Sauce',1),(1558,16,'Guañacos',1),(1559,16,'Huinganco',1),(1560,16,'Las Coloradas',1),(1561,16,'Las Lajas',1),(1562,16,'Las Ovejas',1),(1563,16,'Loncopué',1),(1564,16,'Los Catutos',1),(1565,16,'Los Chihuidos',1),(1566,16,'Los Miches',1),(1567,16,'Manzano Amargo',1),(1569,16,'Octavio Pico',1),(1570,16,'Paso Aguerre',1),(1571,16,'Picún Leufú',1),(1572,16,'Piedra del Aguila',1),(1573,16,'Pilo Lil',1),(1574,16,'Plaza Huincul',1),(1575,16,'Plottier',1),(1576,16,'Quili Malal',1),(1577,16,'Ramón Castro',1),(1578,16,'Rincón de Los Sauces',1),(1579,16,'San Martín de Los Andes',1),(1580,16,'San Patricio del Chañar',1),(1581,16,'Santo Tomás',1),(1582,16,'Sauzal Bonito',1),(1583,16,'Senillosa',1),(1584,16,'Taquimilán',1),(1585,16,'Tricao Malal',1),(1586,16,'Varvarco',1),(1587,16,'Villa Curí Leuvu',1),(1588,16,'Villa del Nahueve',1),(1589,16,'Villa del Puente Picún Leuvú',1),(1590,16,'Villa El Chocón',1),(1591,16,'Villa La Angostura',1),(1592,16,'Villa Pehuenia',1),(1593,16,'Villa Traful',1),(1594,16,'Vista Alegre',1),(1595,16,'Zapala',1),(1596,17,'Aguada Cecilio',1),(1597,17,'Aguada de Guerra',1),(1598,17,'Allén',1),(1599,17,'Arroyo de La Ventana',1),(1600,17,'Arroyo Los Berros',1),(1601,17,'Bariloche',1),(1602,17,'Calte. Cordero',1),(1603,17,'Campo Grande',1),(1604,17,'Catriel',1),(1605,17,'Cerro Policía',1),(1606,17,'Cervantes',1),(1607,17,'Chelforo',1),(1608,17,'Chimpay',1),(1609,17,'Chinchinales',1),(1610,17,'Chipauquil',1),(1611,17,'Choele Choel',1),(1612,17,'Cinco Saltos',1),(1613,17,'Cipolletti',1),(1614,17,'Clemente Onelli',1),(1615,17,'Colán Conhue',1),(1616,17,'Comallo',1),(1617,17,'Comicó',1),(1618,17,'Cona Niyeu',1),(1619,17,'Coronel Belisle',1),(1620,17,'Cubanea',1),(1621,17,'Darwin',1),(1622,17,'Dina Huapi',1),(1623,17,'El Bolsón',1),(1624,17,'El Caín',1),(1625,17,'El Manso',1),(1626,17,'Gral. Conesa',1),(1627,17,'Gral. Enrique Godoy',1),(1628,17,'Gral. Fernandez Oro',1),(1629,17,'Gral. Roca',1),(1630,17,'Guardia Mitre',1),(1631,17,'Ing. Huergo',1),(1632,17,'Ing. Jacobacci',1),(1633,17,'Laguna Blanca',1),(1634,17,'Lamarque',1),(1635,17,'Las Grutas',1),(1636,17,'Los Menucos',1),(1637,17,'Luis Beltrán',1),(1638,17,'Mainqué',1),(1639,17,'Mamuel Choique',1),(1640,17,'Maquinchao',1),(1641,17,'Mencué',1),(1642,17,'Mtro. Ramos Mexia',1),(1643,17,'Nahuel Niyeu',1),(1644,17,'Naupa Huen',1),(1645,17,'Ñorquinco',1),(1646,17,'Ojos de Agua',1),(1647,17,'Paso de Agua',1),(1648,17,'Paso Flores',1),(1649,17,'Peñas Blancas',1),(1650,17,'Pichi Mahuida',1),(1651,17,'Pilcaniyeu',1),(1652,17,'Pomona',1),(1653,17,'Prahuaniyeu',1),(1654,17,'Rincón Treneta',1),(1655,17,'Río Chico',1),(1656,17,'Río Colorado',1),(1657,17,'Roca',1),(1658,17,'San Antonio Oeste',1),(1659,17,'San Javier',1),(1660,17,'Sierra Colorada',1),(1661,17,'Sierra Grande',1),(1662,17,'Sierra Pailemán',1),(1663,17,'Valcheta',1),(1664,17,'Valle Azul',1),(1665,17,'Viedma',1),(1666,17,'Villa Llanquín',1),(1667,17,'Villa Mascardi',1),(1668,17,'Villa Regina',1),(1669,17,'Yaminué',1),(1670,18,'A. Saravia',1),(1671,18,'Aguaray',1),(1672,18,'Angastaco',1),(1673,18,'Animaná',1),(1674,18,'Cachi',1),(1675,18,'Cafayate',1),(1676,18,'Campo Quijano',1),(1677,18,'Campo Santo',1),(1678,18,'Capital',1),(1679,18,'Cerrillos',1),(1680,18,'Chicoana',1),(1681,18,'Col. Sta. Rosa',1),(1682,18,'Coronel Moldes',1),(1683,18,'El Bordo',1),(1684,18,'El Carril',1),(1685,18,'El Galpón',1),(1686,18,'El Jardín',1),(1687,18,'El Potrero',1),(1688,18,'El Quebrachal',1),(1689,18,'El Tala',1),(1690,18,'Embarcación',1),(1691,18,'Gral. Ballivian',1),(1692,18,'Gral. Güemes',1),(1693,18,'Gral. Mosconi',1),(1694,18,'Gral. Pizarro',1),(1695,18,'Guachipas',1),(1696,18,'Hipólito Yrigoyen',1),(1697,18,'Iruyá',1),(1698,18,'Isla De Cañas',1),(1699,18,'J. V. Gonzalez',1),(1700,18,'La Caldera',1),(1701,18,'La Candelaria',1),(1702,18,'La Merced',1),(1703,18,'La Poma',1),(1704,18,'La Viña',1),(1705,18,'Las Lajitas',1),(1706,18,'Los Toldos',1),(1707,18,'Metán',1),(1708,18,'Molinos',1),(1709,18,'Nazareno',1),(1710,18,'Orán',1),(1711,18,'Payogasta',1),(1712,18,'Pichanal',1),(1713,18,'Prof. S. Mazza',1),(1714,18,'Río Piedras',1),(1715,18,'Rivadavia Banda Norte',1),(1716,18,'Rivadavia Banda Sur',1),(1717,18,'Rosario de La Frontera',1),(1718,18,'Rosario de Lerma',1),(1719,18,'Saclantás',1),(1721,18,'San Antonio',1),(1722,18,'San Carlos',1),(1723,18,'San José De Metán',1),(1724,18,'San Ramón',1),(1725,18,'Santa Victoria E.',1),(1726,18,'Santa Victoria O.',1),(1727,18,'Tartagal',1),(1728,18,'Tolar Grande',1),(1729,18,'Urundel',1),(1730,18,'Vaqueros',1),(1731,18,'Villa San Lorenzo',1),(1732,19,'Albardón',1),(1733,19,'Angaco',1),(1734,19,'Calingasta',1),(1735,19,'Capital',1),(1736,19,'Caucete',1),(1737,19,'Chimbas',1),(1738,19,'Iglesia',1),(1739,19,'Jachal',1),(1740,19,'Nueve de Julio',1),(1741,19,'Pocito',1),(1742,19,'Rawson',1),(1743,19,'Rivadavia',1),(1745,19,'San Martín',1),(1746,19,'Santa Lucía',1),(1747,19,'Sarmiento',1),(1748,19,'Ullum',1),(1749,19,'Valle Fértil',1),(1750,19,'Veinticinco de Mayo',1),(1751,19,'Zonda',1),(1752,20,'Alto Pelado',1),(1753,20,'Alto Pencoso',1),(1754,20,'Anchorena',1),(1755,20,'Arizona',1),(1756,20,'Bagual',1),(1757,20,'Balde',1),(1758,20,'Batavia',1),(1759,20,'Beazley',1),(1760,20,'Buena Esperanza',1),(1761,20,'Candelaria',1),(1762,20,'Capital',1),(1763,20,'Carolina',1),(1764,20,'Carpintería',1),(1765,20,'Concarán',1),(1766,20,'Cortaderas',1),(1767,20,'El Morro',1),(1768,20,'El Trapiche',1),(1769,20,'El Volcán',1),(1770,20,'Fortín El Patria',1),(1771,20,'Fortuna',1),(1772,20,'Fraga',1),(1773,20,'Juan Jorba',1),(1774,20,'Juan Llerena',1),(1775,20,'Juana Koslay',1),(1776,20,'Justo Daract',1),(1777,20,'La Calera',1),(1778,20,'La Florida',1),(1779,20,'La Punilla',1),(1780,20,'La Toma',1),(1781,20,'Lafinur',1),(1782,20,'Las Aguadas',1),(1783,20,'Las Chacras',1),(1784,20,'Las Lagunas',1),(1785,20,'Las Vertientes',1),(1786,20,'Lavaisse',1),(1787,20,'Leandro N. Alem',1),(1788,20,'Los Molles',1),(1789,20,'Luján',1),(1790,20,'Mercedes',1),(1791,20,'Merlo',1),(1792,20,'Naschel',1),(1793,20,'Navia',1),(1794,20,'Nogolí',1),(1795,20,'Nueva Galia',1),(1796,20,'Papagayos',1),(1797,20,'Paso Grande',1),(1798,20,'Potrero de Los Funes',1),(1799,20,'Quines',1),(1800,20,'Renca',1),(1801,20,'Saladillo',1),(1802,20,'San Francisco',1),(1803,20,'San Gerónimo',1),(1804,20,'San Martín',1),(1805,20,'San Pablo',1),(1806,20,'Santa Rosa de Conlara',1),(1807,20,'Talita',1),(1808,20,'Tilisarao',1),(1809,20,'Unión',1),(1810,20,'Villa de La Quebrada',1),(1811,20,'Villa de Praga',1),(1812,20,'Villa del Carmen',1),(1813,20,'Villa Gral. Roca',1),(1814,20,'Villa Larca',1),(1815,20,'Villa Mercedes',1),(1816,20,'Zanjitas',1),(1817,21,'Calafate',1),(1818,21,'Caleta Olivia',1),(1819,21,'Cañadón Seco',1),(1820,21,'Comandante Piedrabuena',1),(1821,21,'El Calafate',1),(1822,21,'El Chaltén',1),(1823,21,'Gdor. Gregores',1),(1824,21,'Hipólito Yrigoyen',1),(1825,21,'Jaramillo',1),(1826,21,'Koluel Kaike',1),(1827,21,'Las Heras',1),(1828,21,'Los Antiguos',1),(1829,21,'Perito Moreno',1),(1830,21,'Pico Truncado',1),(1831,21,'Pto. Deseado',1),(1832,21,'Pto. San Julián',1),(1833,21,'Pto. 21',1),(1834,21,'Río Cuarto',1),(1835,21,'Río Gallegos',1),(1836,21,'Río Turbio',1),(1837,21,'Tres Lagos',1),(1838,21,'Veintiocho De Noviembre',1),(1839,22,'Aarón Castellanos',1),(1840,22,'Acebal',1),(1841,22,'Aguará Grande',1),(1842,22,'Albarellos',1),(1843,22,'Alcorta',1),(1844,22,'Aldao',1),(1845,22,'Alejandra',1),(1846,22,'Álvarez',1),(1847,22,'Ambrosetti',1),(1848,22,'Amenábar',1),(1849,22,'Angélica',1),(1850,22,'Angeloni',1),(1851,22,'Arequito',1),(1852,22,'Arminda',1),(1853,22,'Armstrong',1),(1854,22,'Arocena',1),(1855,22,'Arroyo Aguiar',1),(1856,22,'Arroyo Ceibal',1),(1857,22,'Arroyo Leyes',1),(1858,22,'Arroyo Seco',1),(1859,22,'Arrufó',1),(1860,22,'Arteaga',1),(1861,22,'Ataliva',1),(1862,22,'Aurelia',1),(1863,22,'Avellaneda',1),(1864,22,'Barrancas',1),(1865,22,'Bauer Y Sigel',1),(1866,22,'Bella Italia',1),(1867,22,'Berabevú',1),(1868,22,'Berna',1),(1869,22,'Bernardo de Irigoyen',1),(1870,22,'Bigand',1),(1871,22,'Bombal',1),(1872,22,'Bouquet',1),(1873,22,'Bustinza',1),(1874,22,'Cabal',1),(1875,22,'Cacique Ariacaiquin',1),(1876,22,'Cafferata',1),(1877,22,'Calchaquí',1),(1878,22,'Campo Andino',1),(1879,22,'Campo Piaggio',1),(1880,22,'Cañada de Gómez',1),(1881,22,'Cañada del Ucle',1),(1882,22,'Cañada Rica',1),(1883,22,'Cañada Rosquín',1),(1884,22,'Candioti',1),(1885,22,'Capital',1),(1886,22,'Capitán Bermúdez',1),(1887,22,'Capivara',1),(1888,22,'Carcarañá',1),(1889,22,'Carlos Pellegrini',1),(1890,22,'Carmen',1),(1891,22,'Carmen Del Sauce',1),(1892,22,'Carreras',1),(1893,22,'Carrizales',1),(1894,22,'Casalegno',1),(1895,22,'Casas',1),(1896,22,'Casilda',1),(1897,22,'Castelar',1),(1898,22,'Castellanos',1),(1899,22,'Cayastá',1),(1900,22,'Cayastacito',1),(1901,22,'Centeno',1),(1902,22,'Cepeda',1),(1903,22,'Ceres',1),(1904,22,'Chabás',1),(1905,22,'Chañar Ladeado',1),(1906,22,'Chapuy',1),(1907,22,'Chovet',1),(1908,22,'Christophersen',1),(1909,22,'Classon',1),(1910,22,'Cnel. Arnold',1),(1911,22,'Cnel. Bogado',1),(1912,22,'Cnel. Dominguez',1),(1913,22,'Cnel. Fraga',1),(1914,22,'Col. Aldao',1),(1915,22,'Col. Ana',1),(1916,22,'Col. Belgrano',1),(1917,22,'Col. Bicha',1),(1918,22,'Col. Bigand',1),(1919,22,'Col. Bossi',1),(1920,22,'Col. Cavour',1),(1921,22,'Col. Cello',1),(1922,22,'Col. Dolores',1),(1923,22,'Col. Dos Rosas',1),(1924,22,'Col. Durán',1),(1925,22,'Col. Iturraspe',1),(1926,22,'Col. Margarita',1),(1927,22,'Col. Mascias',1),(1928,22,'Col. Raquel',1),(1929,22,'Col. Rosa',1),(1930,22,'Col. San José',1),(1931,22,'Constanza',1),(1932,22,'Coronda',1),(1933,22,'Correa',1),(1934,22,'Crispi',1),(1935,22,'Cululú',1),(1936,22,'Curupayti',1),(1937,22,'Desvio Arijón',1),(1938,22,'Diaz',1),(1939,22,'Diego de Alvear',1),(1940,22,'Egusquiza',1),(1941,22,'El Arazá',1),(1942,22,'El Rabón',1),(1943,22,'El Sombrerito',1),(1944,22,'El Trébol',1),(1945,22,'Elisa',1),(1946,22,'Elortondo',1),(1947,22,'Emilia',1),(1948,22,'Empalme San Carlos',1),(1949,22,'Empalme Villa Constitucion',1),(1950,22,'Esmeralda',1),(1951,22,'Esperanza',1),(1952,22,'Estación Alvear',1),(1953,22,'Estacion Clucellas',1),(1954,22,'Esteban Rams',1),(1955,22,'Esther',1),(1956,22,'Esustolia',1),(1957,22,'Eusebia',1),(1958,22,'Felicia',1),(1959,22,'Fidela',1),(1960,22,'Fighiera',1),(1961,22,'Firmat',1),(1962,22,'Florencia',1),(1963,22,'Fortín Olmos',1),(1964,22,'Franck',1),(1965,22,'Fray Luis Beltrán',1),(1966,22,'Frontera',1),(1967,22,'Fuentes',1),(1968,22,'Funes',1),(1969,22,'Gaboto',1),(1970,22,'Galisteo',1),(1971,22,'Gálvez',1),(1972,22,'Garabalto',1),(1973,22,'Garibaldi',1),(1974,22,'Gato Colorado',1),(1975,22,'Gdor. Crespo',1),(1976,22,'Gessler',1),(1977,22,'Godoy',1),(1978,22,'Golondrina',1),(1979,22,'Gral. Gelly',1),(1980,22,'Gral. Lagos',1),(1981,22,'Granadero Baigorria',1),(1982,22,'Gregoria Perez De Denis',1),(1983,22,'Grutly',1),(1984,22,'Guadalupe N.',1),(1985,22,'Gödeken',1),(1986,22,'Helvecia',1),(1987,22,'Hersilia',1),(1988,22,'Hipatía',1),(1989,22,'Huanqueros',1),(1990,22,'Hugentobler',1),(1991,22,'Hughes',1),(1992,22,'Humberto 1º',1),(1993,22,'Humboldt',1),(1994,22,'Ibarlucea',1),(1995,22,'Ing. Chanourdie',1),(1996,22,'Intiyaco',1),(1997,22,'Ituzaingó',1),(1998,22,'Jacinto L. Aráuz',1),(1999,22,'Josefina',1),(2000,22,'Juan B. Molina',1),(2001,22,'Juan de Garay',1),(2002,22,'Juncal',1),(2003,22,'La Brava',1),(2004,22,'La Cabral',1),(2005,22,'La Camila',1),(2006,22,'La Chispa',1),(2007,22,'La Clara',1),(2008,22,'La Criolla',1),(2009,22,'La Gallareta',1),(2010,22,'La Lucila',1),(2011,22,'La Pelada',1),(2012,22,'La Penca',1),(2013,22,'La Rubia',1),(2014,22,'La Sarita',1),(2015,22,'La Vanguardia',1),(2016,22,'Labordeboy',1),(2017,22,'Laguna Paiva',1),(2018,22,'Landeta',1),(2019,22,'Lanteri',1),(2020,22,'Larrechea',1),(2021,22,'Las Avispas',1),(2022,22,'Las Bandurrias',1),(2023,22,'Las Garzas',1),(2024,22,'Las Palmeras',1),(2025,22,'Las Parejas',1),(2026,22,'Las Petacas',1),(2027,22,'Las Rosas',1),(2028,22,'Las Toscas',1),(2029,22,'Las Tunas',1),(2030,22,'Lazzarino',1),(2031,22,'Lehmann',1),(2032,22,'Llambi Campbell',1),(2033,22,'Logroño',1),(2034,22,'Loma Alta',1),(2035,22,'López',1),(2036,22,'Los Amores',1),(2037,22,'Los Cardos',1),(2038,22,'Los Laureles',1),(2039,22,'Los Molinos',1),(2040,22,'Los Quirquinchos',1),(2041,22,'Lucio V. Lopez',1),(2042,22,'Luis Palacios',1),(2043,22,'Ma. Juana',1),(2044,22,'Ma. Luisa',1),(2045,22,'Ma. Susana',1),(2046,22,'Ma. Teresa',1),(2047,22,'Maciel',1),(2048,22,'Maggiolo',1),(2049,22,'Malabrigo',1),(2050,22,'Marcelino Escalada',1),(2051,22,'Margarita',1),(2052,22,'Matilde',1),(2053,22,'Mauá',1),(2054,22,'Máximo Paz',1),(2055,22,'Melincué',1),(2056,22,'Miguel Torres',1),(2057,22,'Moisés Ville',1),(2058,22,'Monigotes',1),(2059,22,'Monje',1),(2060,22,'Monte Obscuridad',1),(2061,22,'Monte Vera',1),(2062,22,'Montefiore',1),(2063,22,'Montes de Oca',1),(2064,22,'Murphy',1),(2065,22,'Ñanducita',1),(2066,22,'Naré',1),(2067,22,'Nelson',1),(2068,22,'Nicanor E. Molinas',1),(2069,22,'Nuevo Torino',1),(2070,22,'Oliveros',1),(2071,22,'Palacios',1),(2072,22,'Pavón',1),(2073,22,'Pavón Arriba',1),(2079,29,'aaaa',1);
/*!40000 ALTER TABLE `localidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes_medicas`
--

DROP TABLE IF EXISTS `ordenes_medicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordenes_medicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT '0',
  `file_name` varchar(255) DEFAULT NULL,
  `file_extension` varchar(10) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  CONSTRAINT `fk_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes_medicas`
--

LOCK TABLES `ordenes_medicas` WRITE;
/*!40000 ALTER TABLE `ordenes_medicas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordenes_medicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_cliente_idx` (`cliente_id`),
  KEY `fk_estado_idx` (`estado_id`),
  CONSTRAINT `fk_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `rbac_usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estado` FOREIGN KEY (`estado_id`) REFERENCES `pedidos_estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos_estados`
--

DROP TABLE IF EXISTS `pedidos_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_estados`
--

LOCK TABLES `pedidos_estados` WRITE;
/*!40000 ALTER TABLE `pedidos_estados` DISABLE KEYS */;
INSERT INTO `pedidos_estados` VALUES (1,'EN_CAMINO',NULL,1,'2024-09-09 18:59:53','2024-09-09 18:59:53'),(2,'PENDIENTE','Estado inicial',1,'2024-09-09 19:00:01','2024-09-13 23:32:25'),(3,'EN_PROCESO',NULL,1,'2024-09-09 19:00:08','2024-09-09 19:00:20');
/*!40000 ALTER TABLE `pedidos_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `descripcion_breve` varchar(300) NOT NULL,
  `descripcion_larga` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `precio` decimal(10,0) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fk_proveedor` (`proveedor_id`),
  KEY `fk_categoria` (`categoria_id`),
  CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `fk_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (34,'FIN SHORT ',9,1,'El tallo corto recto FIN SHORT ofrece una alternativa a las técnicas de revestimiento femoral, manteniendo las características propias de estabilidad que han diferenciado al vástago FIN durante los últimos 30 años.',NULL,10,650000,'2024-09-13 01:35:12','2024-09-27 04:38:52',1);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_archivos`
--

DROP TABLE IF EXISTS `productos_archivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_archivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_extension` varchar(10) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  `es_principal` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `fk_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_archivos`
--

LOCK TABLES `productos_archivos` WRITE;
/*!40000 ALTER TABLE `productos_archivos` DISABLE KEYS */;
INSERT INTO `productos_archivos` VALUES (18,34,'1727115976_kmod-rev2.jpg','jpg',29750,'D:\\sitios\\ipmagna\\public\\webroot\\img/productos/1727115976_kmod-rev2.jpg','2024-09-23 20:26:16','2024-09-23 20:26:16',0);
/*!40000 ALTER TABLE `productos_archivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_precios`
--

DROP TABLE IF EXISTS `productos_precios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_precios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `precio` decimal(10,2) NOT NULL,
  `fecha_desde` datetime NOT NULL,
  `fecha_hasta` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_precios`
--

LOCK TABLES `productos_precios` WRITE;
/*!40000 ALTER TABLE `productos_precios` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos_precios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `cuit` varchar(20) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'DIRT','test','test','432432','seba@f.com','20289991868','2024-09-09 16:42:10','2024-09-14 03:26:56',1),(2,'PVE','sdfsf','Agustín García 1854','01140876458','sebabustelo@gmail.com','20289991868','2024-09-14 03:16:53','2024-09-14 03:17:14',1);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincias`
--

DROP TABLE IF EXISTS `provincias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provincias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincias`
--

LOCK TABLES `provincias` WRITE;
/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
INSERT INTO `provincias` VALUES (1,'Buenos Aires',1),(2,'Buenos Aires-GBA',1),(3,'Capital Federal',1),(4,'Catamarca',1),(5,'Chaco',1),(6,'Chubut',1),(7,'Córdoba',1),(8,'Corrientes',1),(9,'Entre Ríos',1),(10,'Formosa',1),(11,'Jujuy',1),(12,'La Pampa',1),(13,'La Rioja',1),(14,'Mendoza',1),(15,'Misiones',1),(16,'Neuquén',1),(17,'Río Negro',1),(18,'Salta',1),(19,'San Juan',1),(20,'San Luis',1),(21,'Santa Cruz',1),(22,'Santa Fe',1),(23,'Santiago del Estero',1),(24,'Tierra del Fuego',1),(25,'Tucumán',1),(29,'aaa',1);
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;
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
  `publico` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller` (`controller`,`action`)
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_acciones`
--

LOCK TABLES `rbac_acciones` WRITE;
/*!40000 ALTER TABLE `rbac_acciones` DISABLE KEYS */;
INSERT INTO `rbac_acciones` VALUES (1,'Rbac','RbacUsuarios','index',0),(2,'Rbac','RbacUsuarios','add',0),(3,'Rbac','RbacUsuarios','edit',0),(5,'Rbac','RbacPerfiles','index',0),(10,'Rbac','RbacAcciones','index',0),(12,'Rbac','RbacAcciones','sincronizar',0),(13,'Rbac','RbacAcciones','switchAccion',0),(16,'Rbac','RbacUsuarios','validarLoginDB',0),(17,'Rbac','RbacUsuarios','login',1),(18,'Rbac','RbacUsuarios','changePass',0),(27,'Rbac','Configuraciones','index',0),(114,NULL,'Pages','display',0),(124,NULL,'Pages','home2',0),(151,'Rbac','RbacUsuarios','clear_cache',0),(154,'Rbac','RbacUsuarios','delete',0),(250,'Rbac','RbacUsuarios','register',1),(251,'Rbac','RbacUsuarios','detail',0),(252,'','TipoDocumentos','index',0),(254,'','TipoDocumentos','add',0),(255,'','TipoDocumentos','edit',0),(256,'','TipoDocumentos','delete',0),(257,'Rbac','RbacUsuarios','registerPassword',1),(258,'','Productos','index',0),(259,'','Productos','view',0),(260,'','Productos','add',0),(261,'','Productos','edit',0),(262,'','Productos','delete',0),(263,'','Productos','catalogoCliente',0),(264,'','Informes','index',0),(266,'Rbac','RbacUsuarios','changePassword',1),(267,'','Categorias','index',0),(268,'','Categorias','add',0),(269,'','Categorias','edit',0),(270,'','Categorias','delete',0),(271,'','Consultas','index',0),(277,'','Proveedores','index',0),(278,'','Proveedores','add',0),(279,'','Proveedores','edit',0),(280,'','Proveedores','delete',0),(281,'Rbac','RbacAcciones','requireLogin',0),(282,'','Consultas','add',0),(283,'','Consultas','edit',0),(284,'','Consultas','delete',0),(289,'Rbac','RbacAcciones','delete',0),(290,'Rbac','RbacUsuarios','forgetPassword',1),(292,'','Pedidos','misPedidos',0),(293,'Rbac','Configuraciones','add',0),(294,'Rbac','Configuraciones','edit',0),(295,'Rbac','Configuraciones','delete',0),(296,'Rbac','RbacPerfiles','add',0),(297,'Rbac','RbacPerfiles','edit',0),(298,'Rbac','RbacPerfiles','delete',0),(302,'','Consultas','view',0),(303,'','ProductosArchivos','delete',0),(304,'','ProductosArchivos','add',0),(305,'','Consultas','response',0),(306,'','PedidoEstados','index',0),(307,'','PedidoEstados','add',0),(308,'','PedidoEstados','edit',0),(309,'','PedidoEstados','delete',0),(310,'','ProductosArchivos','index',0),(311,'','ProductosArchivos','view',0),(312,'','ProductosArchivos','edit',0),(313,'','ConsultasEstados','index',0),(314,'','ConsultasEstados','add',0),(315,'','ConsultasEstados','edit',0),(316,'','PedidosEstados','index',0),(317,'','PedidosEstados','add',0),(318,'','PedidosEstados','edit',0),(319,'','PedidosEstados','delete',0),(320,'','ConsultasEstados','delete',0),(321,'Db','Db','index',0),(322,'Db','Db','getClientIP',0),(323,'','Localidades','index',0),(324,'','Localidades','add',0),(325,'','Localidades','edit',0),(326,'','Localidades','delete',0),(327,'','Provincias','index',0),(328,'','Provincias','add',0),(329,'','Provincias','edit',0),(330,'','Provincias','delete',0),(331,'','Localidades','localidades',1),(332,'','Productos','categorias',0),(333,'Rbac','RbacUsuarios','checkUsername',1),(334,'Rbac','RbacUsuarios','editMyUser',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3576 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_acciones_rbac_perfiles`
--

LOCK TABLES `rbac_acciones_rbac_perfiles` WRITE;
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` DISABLE KEYS */;
INSERT INTO `rbac_acciones_rbac_perfiles` VALUES (3071,27,1),(3095,5,1),(3102,16,1),(3103,2,1),(3106,1,1),(3107,3,1),(3156,17,1),(3157,18,1),(3278,114,1),(3328,151,1),(3331,154,1),(3457,10,1),(3464,250,1),(3465,17,8),(3466,114,8),(3468,124,8),(3470,12,1),(3471,251,1),(3472,252,1),(3474,254,1),(3475,255,1),(3476,256,1),(3477,257,1),(3478,258,1),(3479,259,1),(3480,260,1),(3481,261,1),(3482,262,1),(3483,263,1),(3484,264,1),(3486,266,1),(3487,267,1),(3488,268,1),(3489,269,1),(3490,270,1),(3491,271,1),(3497,277,1),(3498,278,1),(3499,279,1),(3500,280,1),(3501,281,1),(3502,282,1),(3503,283,1),(3504,284,1),(3509,289,1),(3510,290,1),(3512,292,1),(3515,293,1),(3516,294,1),(3517,295,1),(3518,296,1),(3519,297,1),(3520,298,1),(3523,302,1),(3527,263,8),(3528,268,8),(3531,303,1),(3532,304,1),(3533,305,1),(3534,306,1),(3535,307,1),(3536,308,1),(3537,309,1),(3538,310,1),(3539,311,1),(3540,312,1),(3541,313,1),(3542,314,1),(3543,315,1),(3544,316,1),(3545,317,1),(3546,318,1),(3547,319,1),(3548,320,1),(3549,321,1),(3550,322,1),(3551,323,1),(3552,324,1),(3553,325,1),(3554,326,1),(3555,327,1),(3556,328,1),(3557,329,1),(3558,330,1),(3560,251,8),(3573,332,1),(3574,292,8),(3575,332,8);
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_perfiles`
--

LOCK TABLES `rbac_perfiles` WRITE;
/*!40000 ALTER TABLE `rbac_perfiles` DISABLE KEYS */;
INSERT INTO `rbac_perfiles` VALUES (1,'Administrador',258),(8,'Cliente',263);
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
  `rbac_usuario_id` int(11) NOT NULL,
  `token` varchar(500) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `validez` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_TOKEN` (`token`),
  KEY `fk_rbac_usuario_idx` (`rbac_usuario_id`),
  CONSTRAINT `fk_rbac_usuarios` FOREIGN KEY (`rbac_usuario_id`) REFERENCES `rbac_usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_token`
--

LOCK TABLES `rbac_token` WRITE;
/*!40000 ALTER TABLE `rbac_token` DISABLE KEYS */;
INSERT INTO `rbac_token` VALUES (61,2923,'uWM2sUlvGvJPGvPYSS2NiC1e','2024-09-28 03:32:50','2024-09-28 03:32:50',1440),(62,2923,'5sJJ0JgjDsoId3nXbtpl8rlu','2024-09-28 03:36:06','2024-09-28 03:36:06',1440),(63,2923,'1sFH-bJdEwv8IePztz4Ew7F8','2024-09-28 03:39:17','2024-09-28 03:39:17',1440),(66,2923,'A8qJRfy1lBs67ifs-dKb5Uyg','2024-09-28 12:57:45','2024-09-28 12:57:45',1440),(73,2990,'2_BymI7gYz3RCsk05xeGzJ3z','2024-10-02 01:21:31','2024-10-02 01:21:31',1440);
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
  `usuario` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `tipo_documento_id` int(11) DEFAULT NULL,
  `documento` varchar(10) DEFAULT NULL,
  `cuit` int(12) DEFAULT NULL,
  `razon_social` varchar(300) DEFAULT NULL,
  `celular` int(15) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `seed` varchar(64) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` varchar(16) DEFAULT NULL,
  `modified_by` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`usuario`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `FK_rbac_usuarios_rbac_perfiles` (`perfil_id`),
  KEY `FK_tipo_documento` (`tipo_documento_id`),
  CONSTRAINT `FK_rbac_usuarios_rbac_perfiles` FOREIGN KEY (`perfil_id`) REFERENCES `rbac_perfiles` (`id`),
  CONSTRAINT `FK_tipo_documento` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documentos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2991 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rbac_usuarios`
--

LOCK TABLES `rbac_usuarios` WRITE;
/*!40000 ALTER TABLE `rbac_usuarios` DISABLE KEYS */;
INSERT INTO `rbac_usuarios` VALUES (2901,1,'florenciatigani','flor@gmail.com','María Florencia','Tigani',1,'María Flor',NULL,NULL,NULL,'33a47f95b1fca05597aec141e7a3221e90a20dac6e73c3e38b09931229212713','d57edf2d2082b0865e15d11edaecdb20',1,'2019-10-28 14:50:04','2024-08-30 18:01:45',NULL,'2923'),(2923,1,'sebabustelo','sebabustelo@gmail.com','Sebastian','Bustelo',1,'28999186',NULL,NULL,2147483647,'d685328db63350ce310941e16d676d09b88bd3e8630c334a883edf0ee0f8d4fa','07a500b0097c2725b5ee843d28259d8456e320f9e71bb70e1370e4de3671dc92',1,'2024-08-30 14:29:31','2024-09-28 13:01:15','2907','2907'),(2990,8,'seba','zebabustelo@gmail.com','Walter Sebastian','Bustelo',1,'3242342342',NULL,NULL,2147483647,'3fdcd73112bf99eb7ea6038cf346a2b01488e54da2d4b53bee38197c826705bb','07a500b0097c2725b5ee843d28259d8456e320f9e71bb70e1370e4de3671dc92',1,'2024-10-02 01:14:20','2024-10-02 01:22:57',NULL,NULL);
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
  `descripcion` varchar(200) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion_UNIQUE` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_documentos`
--

LOCK TABLES `tipo_documentos` WRITE;
/*!40000 ALTER TABLE `tipo_documentos` DISABLE KEYS */;
INSERT INTO `tipo_documentos` VALUES (1,'DNI','2024-09-04 20:48:19','2024-09-04 20:52:56',1),(2,'LE','2024-09-04 20:48:19','2024-09-04 20:52:56',1),(3,'PASAPORTE','2024-09-04 20:48:19','2024-09-04 20:52:56',1);
/*!40000 ALTER TABLE `tipo_documentos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-02  8:33:12
