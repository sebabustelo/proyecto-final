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

-- Volcando estructura para tabla ipmagna.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.categorias: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
REPLACE INTO `categorias` (`id`, `nombre`, `descripcion`, `created`, `modified`, `activo`) VALUES
	(3, 'Columna', 'set para columnas', '2024-09-09 18:57:10', '2024-09-10 16:09:07', 1),
	(5, 'Complementos', 'set de complementos', '2024-09-10 20:06:21', '2024-09-10 16:09:07', 1),
	(6, 'Pediátricos', 'set pediátricos', '2024-09-10 20:06:56', '2024-09-10 16:09:07', 1),
	(7, 'Rodilla', 'set rodilla', '2024-09-10 20:07:09', '2024-09-10 16:09:07', 1),
	(8, 'Trauma', 'set trauma', '2024-09-10 20:07:18', '2024-09-10 16:09:07', 1),
	(9, 'Cadera', 'set para caderas', '2024-09-10 21:03:22', '2024-09-10 21:09:46', 1);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.configuracion: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
REPLACE INTO `configuracion` (`id`, `clave`, `valor`) VALUES
	(3, 'Mostrar Captcha', 'No'),
	(5, 'skin_admin', 'black-light'),
	(16, 'app_email', 'ipmagna@gmail.com'),
	(24, 'Perfil Cliente', '8');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.consultas
CREATE TABLE IF NOT EXISTS `consultas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motivo` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.consultas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.detalles_pedidos
CREATE TABLE IF NOT EXISTS `detalles_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total_linea` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  CONSTRAINT `detalles_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.detalles_pedidos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `detalles_pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalles_pedidos` ENABLE KEYS */;

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

-- Volcando estructura para tabla ipmagna.estados
CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.estados: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
REPLACE INTO `estados` (`id`, `nombre`, `created`, `modified`, `activo`) VALUES
	(1, 'EN_CAMINO', '2024-09-09 18:59:53', '2024-09-09 18:59:53', 1),
	(2, 'PENDIENTE', '2024-09-09 19:00:01', '2024-09-09 19:05:53', 1),
	(3, 'EN_PROCESO', '2024-09-09 19:00:08', '2024-09-09 19:00:20', 1);
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.kit_cirugias
CREATE TABLE IF NOT EXISTS `kit_cirugias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `precio` decimal(10,0) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `proveedor_id` (`proveedor_id`),
  CONSTRAINT `kit_cirugias_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kit_cirugias_ibfk_2` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.kit_cirugias: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `kit_cirugias` DISABLE KEYS */;
REPLACE INTO `kit_cirugias` (`id`, `nombre`, `descripcion`, `categoria_id`, `proveedor_id`, `stock`, `precio`, `created`, `modified`, `activo`) VALUES
	(6, 'FIN Short Info del pro', 'El tallo corto recto FIN SHORT ofrece una alternativa a las técnicas de revestimiento femoral, manteniendo las características propias de estabilidad que han diferenciado al vástago FIN durante los últimos 30 años.', 9, 1, 10, 50000, '2024-09-11 20:22:15', '2024-09-11 20:22:15', 1),
	(7, 'SMR', 'El tallo de revisión para cadera SMR es un sistema modular diseñado para la reimplantación de prótesis de cadera en casos de pérdida ósea grave (tipos II, III y IV de la società italiana riprotesizzazione-GIR y tipos II y III de Paprosky).', 9, 1, 10, 60000, '2024-09-11 20:38:51', '2024-09-11 20:38:51', 1);
/*!40000 ALTER TABLE `kit_cirugias` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.obras_sociales
CREATE TABLE IF NOT EXISTS `obras_sociales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `cuit` varchar(20) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.obras_sociales: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `obras_sociales` DISABLE KEYS */;
/*!40000 ALTER TABLE `obras_sociales` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `estado_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_cliente_idx` (`cliente_id`),
  KEY `fk_estado_idx` (`estado_id`),
  CONSTRAINT `fk_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `rbac_usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estado` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.pedidos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.proveedores
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `cuit` varchar(20) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.proveedores: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
REPLACE INTO `proveedores` (`id`, `nombre`, `descripcion`, `direccion`, `telefono`, `email`, `cuit`, `created`, `modified`, `activo`) VALUES
	(1, 'test', 'test', 'test', '432432', 'seba@f.com', '2028999186', '2024-09-09 16:42:10', '2024-09-09 16:42:10', 1);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.rbac_acciones
CREATE TABLE IF NOT EXISTS `rbac_acciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` varchar(100) DEFAULT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `publico` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller` (`controller`,`action`)
) ENGINE=InnoDB AUTO_INCREMENT=292 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_acciones: ~69 rows (aproximadamente)
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
	(12, 'Rbac', 'RbacAcciones', 'sincronizar', 0),
	(13, 'Rbac', 'RbacAcciones', 'switchAccion', 0),
	(16, 'Rbac', 'RbacUsuarios', 'validarLoginDB', 0),
	(17, 'Rbac', 'RbacUsuarios', 'login', 1),
	(18, 'Rbac', 'RbacUsuarios', 'changePass', 0),
	(20, 'Rbac', 'RbacUsuarios', 'recuperar', 0),
	(21, 'Rbac', 'RbacUsuarios', 'recuperarPass', 1),
	(27, 'Rbac', 'Configuraciones', 'index', 0),
	(28, 'Rbac', 'Configuraciones', 'editar', 0),
	(114, NULL, 'Pages', 'display', NULL),
	(124, NULL, 'Pages', 'home2', 0),
	(145, 'Rbac', 'Configuraciones', 'settings', NULL),
	(148, 'Rbac', 'RbacPerfiles', 'getConditions', NULL),
	(150, 'Rbac', 'RbacUsuarios', 'getConditions', NULL),
	(151, 'Rbac', 'RbacUsuarios', 'clear_cache', NULL),
	(154, 'Rbac', 'RbacUsuarios', 'delete', NULL),
	(176, 'Rbac', 'Configuraciones', 'eliminar', NULL),
	(177, 'Rbac', 'Configuraciones', 'agregar', NULL),
	(229, 'Rbac', 'RbacUsuarios', 'logout', 0),
	(250, 'Rbac', 'RbacUsuarios', 'register', 1),
	(251, 'Rbac', 'RbacUsuarios', 'detail', NULL),
	(252, '', 'TipoDocumentos', 'index', NULL),
	(253, '', 'TipoDocumentos', 'view', NULL),
	(254, '', 'TipoDocumentos', 'add', NULL),
	(255, '', 'TipoDocumentos', 'edit', NULL),
	(256, '', 'TipoDocumentos', 'delete', NULL),
	(257, 'Rbac', 'RbacUsuarios', 'registerPassword', 1),
	(258, '', 'Productos', 'index', NULL),
	(259, '', 'Productos', 'view', NULL),
	(260, '', 'Productos', 'add', NULL),
	(261, '', 'Productos', 'edit', NULL),
	(262, '', 'Productos', 'delete', NULL),
	(263, '', 'Productos', 'catalogoCliente', NULL),
	(264, '', 'Informes', 'index', NULL),
	(265, 'Rbac', 'RbacUsuarios', 'recoverPassword', 1),
	(266, 'Rbac', 'RbacUsuarios', 'changePassword', 1),
	(267, '', 'Categorias', 'index', NULL),
	(268, '', 'Categorias', 'add', NULL),
	(269, '', 'Categorias', 'edit', NULL),
	(270, '', 'Categorias', 'delete', NULL),
	(271, '', 'Consultas', 'index', NULL),
	(273, '', 'Estados', 'index', NULL),
	(274, '', 'Estados', 'add', NULL),
	(275, '', 'Estados', 'edit', NULL),
	(276, '', 'Estados', 'delete', NULL),
	(277, '', 'Proveedores', 'index', NULL),
	(278, '', 'Proveedores', 'add', NULL),
	(279, '', 'Proveedores', 'edit', NULL),
	(280, '', 'Proveedores', 'delete', NULL),
	(281, 'Rbac', 'RbacAcciones', 'requireLogin', NULL),
	(282, '', 'Consultas', 'add', NULL),
	(283, '', 'Consultas', 'edit', NULL),
	(284, '', 'Consultas', 'delete', NULL),
	(285, '', 'ObrasSociales', 'index', NULL),
	(286, '', 'ObrasSociales', 'add', NULL),
	(287, '', 'ObrasSociales', 'edit', NULL),
	(288, '', 'ObrasSociales', 'delete', NULL),
	(289, 'Rbac', 'RbacAcciones', 'delete', NULL),
	(290, 'Rbac', 'RbacUsuarios', 'forgetPassword', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3512 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_acciones_rbac_perfiles: ~70 rows (aproximadamente)
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
	(3471, 251, 1),
	(3472, 252, 1),
	(3473, 253, 1),
	(3474, 254, 1),
	(3475, 255, 1),
	(3476, 256, 1),
	(3477, 257, 1),
	(3478, 258, 1),
	(3479, 259, 1),
	(3480, 260, 1),
	(3481, 261, 1),
	(3482, 262, 1),
	(3483, 263, 1),
	(3484, 264, 1),
	(3485, 265, 1),
	(3486, 266, 1),
	(3487, 267, 1),
	(3488, 268, 1),
	(3489, 269, 1),
	(3490, 270, 1),
	(3491, 271, 1),
	(3493, 273, 1),
	(3494, 274, 1),
	(3495, 275, 1),
	(3496, 276, 1),
	(3497, 277, 1),
	(3498, 278, 1),
	(3499, 279, 1),
	(3500, 280, 1),
	(3501, 281, 1),
	(3502, 282, 1),
	(3503, 283, 1),
	(3504, 284, 1),
	(3505, 285, 1),
	(3506, 286, 1),
	(3507, 287, 1),
	(3508, 288, 1),
	(3509, 289, 1),
	(3510, 290, 1);
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

-- Volcando datos para la tabla ipmagna.rbac_perfiles: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_perfiles` DISABLE KEYS */;
REPLACE INTO `rbac_perfiles` (`id`, `descripcion`, `accion_default_id`) VALUES
	(1, 'Administrador', 1),
	(8, 'Cliente', 124);
/*!40000 ALTER TABLE `rbac_perfiles` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.rbac_token
CREATE TABLE IF NOT EXISTS `rbac_token` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `token` varchar(500) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `validez` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_TOKEN` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_token: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_token` DISABLE KEYS */;
REPLACE INTO `rbac_token` (`id`, `token`, `usuario_id`, `created`, `modified`, `validez`) VALUES
	(14, 'MQ3xmCQitRywvdfpvarXVSQ2', 2936, '2024-09-04 19:35:40', '2024-09-04 19:35:40', 1440),
	(18, 'UHMsmmVcqyFvwafN931y-W-4', 2923, NULL, NULL, 1440),
	(19, 'tv8-L5hziU-yosrvjnfmdI7p', 2923, NULL, NULL, 1440),
	(20, 'lO25JWYyEOJFQFV4oqn7V-1R', 2923, NULL, NULL, 1440);
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
) ENGINE=InnoDB AUTO_INCREMENT=2939 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_usuarios: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_usuarios` DISABLE KEYS */;
REPLACE INTO `rbac_usuarios` (`id`, `perfil_id`, `usuario`, `nombre`, `apellido`, `tipo_documento_id`, `documento`, `direccion`, `celular`, `password`, `seed`, `activo`, `created`, `modified`, `created_by`, `modified_by`) VALUES
	(2901, 1, 'flor@gmail.com', 'Florencia', 'Tigani', 1, '30215654', 'Tinogasta 987', NULL, 'bdb402fd82aee66e477e15f0d31b6cac806896cc42bbdfe02eedd7e23b5c3b0d', '1f4477bad7af3616c1f933a02bfabe4e', 1, '2019-10-28 14:50:04', '2024-08-30 18:01:45', NULL, '2923'),
	(2902, 1, 'facu@gmail.com', 'Facundo', 'Ramirez', 1, '38025652', 'Camargo 1512', NULL, '', '5c151c2a9b76f9ef26d7e0f0d00c9a89', 1, NULL, '2024-08-30 18:01:13', NULL, '2923'),
	(2923, 1, 'sebabustelo@gmail.com', 'Sebastian', 'Bustelo', 1, '28999186', 'Juan Agustín Garcia 1854', NULL, '561dfe66b045305d0462693148c03140a89914d8f6ef08f88c8f4b284e24be35', '79514e888b8f2acacc68738d0cbb803e', 1, '2024-08-30 14:29:31', '2024-08-30 14:29:31', '2907', '2907'),
	(2936, 8, 'zebabustelo@gmail.com', 'Sebastian', 'Bustelo', 1, '28999186', 'Padilla 752', NULL, NULL, NULL, 1, '2024-09-04 19:35:40', '2024-09-04 22:57:17', NULL, '2923');
/*!40000 ALTER TABLE `rbac_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.tipo_documentos
CREATE TABLE IF NOT EXISTS `tipo_documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion_UNIQUE` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.tipo_documentos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `tipo_documentos` DISABLE KEYS */;
REPLACE INTO `tipo_documentos` (`id`, `descripcion`, `created`, `modified`, `activo`) VALUES
	(1, 'DNI', '2024-09-04 20:48:19', '2024-09-04 20:52:56', 1),
	(2, 'LE', '2024-09-04 20:48:19', '2024-09-04 20:52:56', 1),
	(3, 'PASAPORTE', '2024-09-04 20:48:19', '2024-09-04 20:52:56', 1);
/*!40000 ALTER TABLE `tipo_documentos` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.uploads
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_archivo` varchar(65) NOT NULL,
  `nombre_original` varchar(64) NOT NULL,
  `hash_archivo` varchar(64) NOT NULL,
  `extension_archivo` varchar(10) NOT NULL,
  `hash_llave` varchar(64) NOT NULL,
  `kit_cirugia_id` int(11) NOT NULL,
  `es_principal` tinyint(1) DEFAULT 0,
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_kit_cirugia_idx` (`kit_cirugia_id`),
  CONSTRAINT `fk_kit_cirugia` FOREIGN KEY (`kit_cirugia_id`) REFERENCES `kit_cirugias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.uploads: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
REPLACE INTO `uploads` (`id`, `nombre_archivo`, `nombre_original`, `hash_archivo`, `extension_archivo`, `hash_llave`, `kit_cirugia_id`, `es_principal`, `modified`, `created`) VALUES
	(2, '3419cd8eaee05212db42d3d7a4cffc3d85bb', 'fin_short', 'b8fa3419cd8eaee05212db42d3d7a4cffc3d85bb', 'jpg', '8abeb247ffcea274d8674a24a2bd9146735d749605f8ec7f7ddc339c09bdb903', 6, 1, '2024-09-11 16:23:32', '2024-09-11 20:22:15'),
	(3, 'edae2fbed15e959b3d0eb54e7fbf6a6ab46d', 'smr', 'acffedae2fbed15e959b3d0eb54e7fbf6a6ab46d', 'jpg', '44e53781c2c307e3ec7b60237283009c77209ed64d5689b7d87108feb9062892', 7, 1, '2024-09-11 20:38:51', '2024-09-11 20:38:51');
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
