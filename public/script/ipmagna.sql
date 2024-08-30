-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.5.23-MariaDB-0+deb11u1 - Debian 11
-- SO del servidor:              debian-linux-gnu
-- HeidiSQL Versión:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla ipmagna.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.configuracion: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
REPLACE INTO `configuracion` (`id`, `clave`, `valor`) VALUES
	(3, 'Mostrar Captcha', 'No'),
	(5, 'skin_admin', 'black-light'),
	(7, 'app_email_pass_enc', 'X95jZ8+zM546TxUjdsragvnmHKbLOpH+52Bt3w+GDsFejR67kPzS181w08i3/LfdTh6VRwp0ebGmlVFxLCtUqE13lfgwP1dJiCqWw+vid09y8bGfzzrLG6qtbxOJhbhm'),
	(8, 'reCaptchaURL', 'http://recaptcha.mrec.ar'),
	(9, 'reCaptchaPublic', '6LfokXkUAAAAALPPdkZS13PUa7DQ-C0ehL8tQNdM'),
	(10, 'reCaptchaSecret', '6LfokXkUAAAAAP-6DyEGNNyVjuzjK9VZvMZRwI-k'),
	(16, 'app_email', 'ipmagna@gmail.com'),
	(24, 'Perfil Cliente', '8');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.ejemplos
CREATE TABLE IF NOT EXISTS `ejemplos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Volcando datos para la tabla ipmagna.ejemplos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ejemplos` DISABLE KEYS */;
/*!40000 ALTER TABLE `ejemplos` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.obras_sociales
CREATE TABLE IF NOT EXISTS `obras_sociales` (
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

-- Volcando datos para la tabla ipmagna.obras_sociales: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `obras_sociales` DISABLE KEYS */;
/*!40000 ALTER TABLE `obras_sociales` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.rbac_acciones
CREATE TABLE IF NOT EXISTS `rbac_acciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` varchar(100) DEFAULT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `publico` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller` (`controller`,`action`)
) ENGINE=InnoDB AUTO_INCREMENT=252 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_acciones: ~39 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_acciones` DISABLE KEYS */;
REPLACE INTO `rbac_acciones` (`id`, `plugin`, `controller`, `action`, `publico`) VALUES
	(1, 'Rbac', 'RbacUsuarios', 'index', 0),
	(2, 'Rbac', 'RbacUsuarios', 'add', 0),
	(3, 'Rbac', 'RbacUsuarios', 'edit', 0),
	(4, 'Rbac', 'RbacUsuarios', 'eliminar', 0),
	(5, 'Rbac', 'RbacPerfiles', 'index', 0),
	(6, 'Rbac', 'RbacPerfiles', 'agregar', 0),
	(7, 'Rbac', 'RbacPerfiles', 'editar', 0),
	(8, 'Rbac', 'RbacPerfiles', 'eliminar', 0),
	(9, 'Rbac', 'RbacPerfiles', 'getAccionesByVirtualHost', 0),
	(10, 'Rbac', 'RbacAcciones', 'index', 0),
	(11, 'Rbac', 'RbacAcciones', 'eliminar', 0),
	(12, 'Rbac', 'RbacAcciones', 'sincronizar', 0),
	(13, 'Rbac', 'RbacAcciones', 'switchAccion', 0),
	(16, 'Rbac', 'RbacUsuarios', 'validarLoginDB', 0),
	(17, 'Rbac', 'RbacUsuarios', 'login', 0),
	(18, 'Rbac', 'RbacUsuarios', 'changePass', 0),
	(20, 'Rbac', 'RbacUsuarios', 'recuperar', 0),
	(21, 'Rbac', 'RbacUsuarios', 'recuperarPass', 0),
	(27, 'Rbac', 'Configuraciones', 'index', 0),
	(28, 'Rbac', 'Configuraciones', 'editar', 0),
	(111, NULL, 'Ejemplos', '_null', NULL),
	(112, NULL, 'Ejemplos', 'index', NULL),
	(113, NULL, 'Ejemplos', 'ver', NULL),
	(114, NULL, 'Pages', 'display', NULL),
	(124, NULL, 'Pages', '_null', 0),
	(138, 'Rbac', 'Configuraciones', '_null', NULL),
	(139, 'Rbac', 'RbacAcciones', '_null', NULL),
	(141, 'Rbac', 'RbacUsuarios', '_null', NULL),
	(144, 'Rbac', 'RbacPerfiles', '_null', NULL),
	(145, 'Rbac', 'Configuraciones', 'settings', NULL),
	(148, 'Rbac', 'RbacPerfiles', 'getConditions', NULL),
	(150, 'Rbac', 'RbacUsuarios', 'getConditions', NULL),
	(151, 'Rbac', 'RbacUsuarios', 'clear_cache', NULL),
	(154, 'Rbac', 'RbacUsuarios', 'delete', NULL),
	(176, 'Rbac', 'Configuraciones', 'eliminar', NULL),
	(177, 'Rbac', 'Configuraciones', 'agregar', NULL),
	(229, 'Rbac', 'RbacUsuarios', 'logout', 0),
	(250, 'Rbac', 'RbacUsuarios', 'register', 1),
	(251, 'Rbac', 'RbacUsuarios', 'detail', NULL);
/*!40000 ALTER TABLE `rbac_acciones` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.rbac_acciones_rbac_perfiles
CREATE TABLE IF NOT EXISTS `rbac_acciones_rbac_perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rbac_accion_id` int(11) NOT NULL,
  `rbac_perfil_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`rbac_accion_id`,`rbac_perfil_id`),
  KEY `fk_ap_accion_idx` (`rbac_accion_id`),
  KEY `fk_ap_perfil_idx` (`rbac_perfil_id`),
  CONSTRAINT `fk_acion` FOREIGN KEY (`rbac_accion_id`) REFERENCES `rbac_acciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_perfil` FOREIGN KEY (`rbac_perfil_id`) REFERENCES `rbac_perfiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3472 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_acciones_rbac_perfiles: ~34 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` DISABLE KEYS */;
REPLACE INTO `rbac_acciones_rbac_perfiles` (`id`, `rbac_accion_id`, `rbac_perfil_id`) VALUES
	(3070, 28, 1),
	(3071, 27, 1),
	(3095, 5, 1),
	(3096, 6, 1),
	(3097, 7, 1),
	(3102, 16, 1),
	(3103, 2, 1),
	(3104, 4, 1),
	(3106, 1, 1),
	(3107, 3, 1),
	(3138, 21, 1),
	(3156, 17, 1),
	(3157, 18, 1),
	(3159, 20, 1),
	(3276, 112, 1),
	(3277, 113, 1),
	(3278, 114, 1),
	(3322, 145, 1),
	(3325, 148, 1),
	(3327, 150, 1),
	(3328, 151, 1),
	(3331, 154, 1),
	(3346, 176, 1),
	(3347, 177, 1),
	(3443, 229, 1),
	(3457, 10, 1),
	(3462, 8, 1),
	(3464, 250, 1),
	(3465, 17, 8),
	(3466, 114, 8),
	(3468, 124, 8),
	(3469, 229, 8),
	(3470, 12, 1),
	(3471, 251, 1);
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.rbac_perfiles
CREATE TABLE IF NOT EXISTS `rbac_perfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `accion_default_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion_UNIQUE` (`descripcion`),
  KEY `rbac_perfiles_ra` (`accion_default_id`),
  CONSTRAINT `rbac_perfiles_ra` FOREIGN KEY (`accion_default_id`) REFERENCES `rbac_acciones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_perfiles: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_perfiles` DISABLE KEYS */;
REPLACE INTO `rbac_perfiles` (`id`, `descripcion`, `accion_default_id`) VALUES
	(1, 'Administrador', 1),
	(8, 'Cliente', 114);
/*!40000 ALTER TABLE `rbac_perfiles` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.rbac_token
CREATE TABLE IF NOT EXISTS `rbac_token` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `validez` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_token: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_token` DISABLE KEYS */;
REPLACE INTO `rbac_token` (`id`, `token`, `usuario_id`, `created`, `modified`, `validez`) VALUES
	(1, '0hl3vihL7R4TqbeOH8o0vwgX', 2923, '2024-08-30 14:29:31', '2024-08-30 14:29:31', 1440);
/*!40000 ALTER TABLE `rbac_token` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.rbac_usuarios
CREATE TABLE IF NOT EXISTS `rbac_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perfil_id` int(11) NOT NULL,
  `usuario` varchar(120) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `tipo_documento_id` int(11) DEFAULT NULL,
  `documento` varchar(45) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `celular` varchar(50) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `seed` varchar(64) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` varchar(16) DEFAULT NULL,
  `modified_by` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`usuario`),
  KEY `FK_rbac_usuarios_rbac_perfiles` (`perfil_id`),
  KEY `FK_tipo_documento` (`tipo_documento_id`),
  CONSTRAINT `FK_rbac_usuarios_rbac_perfiles` FOREIGN KEY (`perfil_id`) REFERENCES `rbac_perfiles` (`id`),
  CONSTRAINT `FK_tipo_documento` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documentos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2927 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_usuarios: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_usuarios` DISABLE KEYS */;
REPLACE INTO `rbac_usuarios` (`id`, `perfil_id`, `usuario`, `nombre`, `apellido`, `tipo_documento_id`, `documento`, `direccion`, `celular`, `password`, `seed`, `activo`, `created`, `modified`, `created_by`, `modified_by`) VALUES
	(2901, 1, 'flor@gmail.com', 'Florencia', 'Tigani', 1, '30215654', 'Tinogasta 987', NULL, 'bdb402fd82aee66e477e15f0d31b6cac806896cc42bbdfe02eedd7e23b5c3b0d', '1f4477bad7af3616c1f933a02bfabe4e', 1, '2019-10-28 14:50:04', '2024-08-30 18:01:45', NULL, '2923'),
	(2902, 1, 'facu@gmail.com', 'Facundo', 'Ramirez', 1, '38025652', 'Camargo 1512', NULL, '', '5c151c2a9b76f9ef26d7e0f0d00c9a89', 1, NULL, '2024-08-30 18:01:13', NULL, '2923'),
	(2923, 1, 'sebabustelo@gmail.com', 'Sebastian', 'Bustelo', 1, '28999186', 'Juan Agustín Garcia 1854', NULL, '561dfe66b045305d0462693148c03140a89914d8f6ef08f88c8f4b284e24be35', '79514e888b8f2acacc68738d0cbb803e', 1, '2024-08-30 14:29:31', '2024-08-30 14:29:31', '2907', '2907');
/*!40000 ALTER TABLE `rbac_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.tipo_documentos
CREATE TABLE IF NOT EXISTS `tipo_documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.tipo_documentos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `tipo_documentos` DISABLE KEYS */;
REPLACE INTO `tipo_documentos` (`id`, `descripcion`) VALUES
	(1, 'DNI'),
	(2, 'LE'),
	(3, 'PASAPORTE');
/*!40000 ALTER TABLE `tipo_documentos` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.uploads
CREATE TABLE IF NOT EXISTS `uploads` (
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

-- Volcando datos para la tabla ipmagna.uploads: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
