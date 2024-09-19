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
	(9, 'Cadera', 'set para caderas', '2024-09-10 21:03:22', '2024-09-14 00:18:28', 1);
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
  `cliente_id` int(11) DEFAULT NULL,
  `usuario_respuesta_id` int(11) DEFAULT NULL,
  `motivo` text NOT NULL,
  `respuesta` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_id` (`cliente_id`),
  KEY `fk_usuario_respuesta_id` (`usuario_respuesta_id`),
  CONSTRAINT `fk_cliente_id` FOREIGN KEY (`cliente_id`) REFERENCES `rbac_usuarios` (`id`),
  CONSTRAINT `fk_usuario_respuesta_id` FOREIGN KEY (`usuario_respuesta_id`) REFERENCES `rbac_usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.consultas: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
REPLACE INTO `consultas` (`id`, `cliente_id`, `usuario_respuesta_id`, `motivo`, `respuesta`, `created`, `modified`) VALUES
	(1, 2966, 2923, 'En nuestra empresa, valoramos la comunicación directa con nuestros usuarios y clientes. A través de esta página de consultas, te brindamos la oportunidad de plantear tus preguntas, inquietudes o comentarios relacionados con nuestros productos, servicios o cualquier aspecto de nuestra operación. Nuestro equipo de atención al cliente está dedicado a ofrecer respuestas rápidas y eficientes para garantizar que tu experiencia con nosotros sea lo más satisfactoria posible.', NULL, '2024-09-19 15:49:57', '2024-09-19 18:56:31');
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
  `descripcion` varchar(300) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.estados: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
REPLACE INTO `estados` (`id`, `nombre`, `descripcion`, `activo`, `created`, `modified`) VALUES
	(1, 'EN_CAMINO', NULL, 1, '2024-09-09 18:59:53', '2024-09-09 18:59:53'),
	(2, 'PENDIENTE', 'Estado inicial', 1, '2024-09-09 19:00:01', '2024-09-13 23:32:25'),
	(3, 'EN_PROCESO', NULL, 1, '2024-09-09 19:00:08', '2024-09-09 19:00:20');
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.kit_cirugias: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `kit_cirugias` DISABLE KEYS */;
REPLACE INTO `kit_cirugias` (`id`, `nombre`, `descripcion`, `categoria_id`, `proveedor_id`, `stock`, `precio`, `created`, `modified`, `activo`) VALUES
	(6, 'FIN Short Info del pro', 'El tallo corto recto FIN SHORT ofrece una alternativa a las técnicas de revestimiento femoral, manteniendo las características propias de estabilidad que han diferenciado al vástago FIN durante los últimos 30 años.', 9, 1, 10, 50000, '2024-09-11 20:22:15', '2024-09-11 20:22:15', 1),
	(7, 'SMR', 'El tallo de revisión para cadera SMR es un sistema modular diseñado para la reimplantación de prótesis de cadera en casos de pérdida ósea grave (tipos II, III y IV de la società italiana riprotesizzazione-GIR y tipos II y III de Paprosky).', 9, 1, 10, 60000, '2024-09-11 20:38:51', '2024-09-11 20:38:51', 1),
	(29, 'Walter Sebastián ', 'fsafdas', 9, 1, 324, 234234, '2024-09-12 20:12:12', '2024-09-12 20:12:12', 1),
	(30, 'Walter Sebastián ', 'fsafdas', 9, 1, 324, 234234, '2024-09-12 20:32:39', '2024-09-12 20:32:39', 1),
	(31, 'Walter Sebastián ', 'fsafdas', 9, 1, 324, 234234, '2024-09-17 15:53:59', '2024-09-17 15:53:59', 1);
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
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.obras_sociales: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `obras_sociales` DISABLE KEYS */;
REPLACE INTO `obras_sociales` (`id`, `nombre`, `direccion`, `telefono`, `email`, `cuit`, `created`, `modified`, `activo`) VALUES
	(2, 'Osde', 'trelles 2552, caba', '123134', 'osde@gmail.com', '204567893', '2024-09-13 11:39:50', '2024-09-13 11:43:28', 1);
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

-- Volcando estructura para tabla ipmagna.productos
CREATE TABLE IF NOT EXISTS `productos` (
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
  KEY `fk_categoria` (`categoria_id`),
  KEY `fk_proveedor` (`proveedor_id`),
  CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.productos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
REPLACE INTO `productos` (`id`, `nombre`, `categoria_id`, `proveedor_id`, `descripcion_breve`, `descripcion_larga`, `stock`, `precio`, `created`, `modified`, `activo`) VALUES
	(34, 'FIN SHORT ', 9, 1, 'El tallo corto recto FIN SHORT ofrece una alternativa a las técnicas de revestimiento femoral, manteniendo las características propias de estabilidad que han diferenciado al vástago FIN durante los últimos 30 años.', NULL, 10, 50000, '2024-09-13 01:35:12', '2024-09-12 21:07:02', 1);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.productos_archivos
CREATE TABLE IF NOT EXISTS `productos_archivos` (
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.productos_archivos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `productos_archivos` DISABLE KEYS */;
REPLACE INTO `productos_archivos` (`id`, `producto_id`, `file_name`, `file_extension`, `file_size`, `file_path`, `created`, `modified`, `es_principal`) VALUES
	(7, 34, '1726184112_fin_short.jpg', 'jpg', 21307, 'D:\\sitios\\ipmagna\\public\\webroot\\img/productos/1726184112_fin_short.jpg', '2024-09-13 01:35:12', '2024-09-13 01:35:12', 1),
	(16, 34, '1726756339_Jellyfish.jpg', 'jpg', 775702, '/var/www/public/webroot/img/productos/1726756339_Jellyfish.jpg', '2024-09-19 14:32:19', '2024-09-19 14:32:19', 0);
/*!40000 ALTER TABLE `productos_archivos` ENABLE KEYS */;

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
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla ipmagna.proveedores: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
REPLACE INTO `proveedores` (`id`, `nombre`, `descripcion`, `direccion`, `telefono`, `email`, `cuit`, `created`, `modified`, `activo`) VALUES
	(1, 'DIRT', 'test', 'test', '432432', 'seba@f.com', '20289991868', '2024-09-09 16:42:10', '2024-09-14 03:26:56', 1),
	(2, 'PVE', 'sdfsf', 'Agustín García 1854', '01140876458', 'sebabustelo@gmail.com', '20289991868', '2024-09-14 03:16:53', '2024-09-14 03:17:14', 1);
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.rbac_acciones
CREATE TABLE IF NOT EXISTS `rbac_acciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` varchar(100) DEFAULT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `publico` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller` (`controller`,`action`)
) ENGINE=InnoDB AUTO_INCREMENT=306 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_acciones: ~67 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_acciones` DISABLE KEYS */;
REPLACE INTO `rbac_acciones` (`id`, `plugin`, `controller`, `action`, `publico`) VALUES
	(1, 'Rbac', 'RbacUsuarios', 'index', 0),
	(2, 'Rbac', 'RbacUsuarios', 'add', 0),
	(3, 'Rbac', 'RbacUsuarios', 'edit', 0),
	(5, 'Rbac', 'RbacPerfiles', 'index', 0),
	(10, 'Rbac', 'RbacAcciones', 'index', 0),
	(12, 'Rbac', 'RbacAcciones', 'sincronizar', 0),
	(13, 'Rbac', 'RbacAcciones', 'switchAccion', 0),
	(16, 'Rbac', 'RbacUsuarios', 'validarLoginDB', 0),
	(17, 'Rbac', 'RbacUsuarios', 'login', 1),
	(18, 'Rbac', 'RbacUsuarios', 'changePass', 0),
	(20, 'Rbac', 'RbacUsuarios', 'recuperar', 0),
	(21, 'Rbac', 'RbacUsuarios', 'recuperarPass', 1),
	(27, 'Rbac', 'Configuraciones', 'index', 0),
	(114, NULL, 'Pages', 'display', 0),
	(124, NULL, 'Pages', 'home2', 0),
	(151, 'Rbac', 'RbacUsuarios', 'clear_cache', 0),
	(154, 'Rbac', 'RbacUsuarios', 'delete', 0),
	(229, 'Rbac', 'RbacUsuarios', 'logout', 0),
	(250, 'Rbac', 'RbacUsuarios', 'register', 1),
	(251, 'Rbac', 'RbacUsuarios', 'detail', 0),
	(252, '', 'TipoDocumentos', 'index', 0),
	(254, '', 'TipoDocumentos', 'add', 0),
	(255, '', 'TipoDocumentos', 'edit', 0),
	(256, '', 'TipoDocumentos', 'delete', 0),
	(257, 'Rbac', 'RbacUsuarios', 'registerPassword', 1),
	(258, '', 'Productos', 'index', 0),
	(259, '', 'Productos', 'view', 0),
	(260, '', 'Productos', 'add', 0),
	(261, '', 'Productos', 'edit', 0),
	(262, '', 'Productos', 'delete', 0),
	(263, '', 'Productos', 'catalogoCliente', 0),
	(264, '', 'Informes', 'index', 0),
	(266, 'Rbac', 'RbacUsuarios', 'changePassword', 1),
	(267, '', 'Categorias', 'index', 0),
	(268, '', 'Categorias', 'add', 0),
	(269, '', 'Categorias', 'edit', 0),
	(270, '', 'Categorias', 'delete', 0),
	(271, '', 'Consultas', 'index', 0),
	(273, '', 'Estados', 'index', 0),
	(274, '', 'Estados', 'add', 0),
	(275, '', 'Estados', 'edit', 0),
	(276, '', 'Estados', 'delete', 0),
	(277, '', 'Proveedores', 'index', 0),
	(278, '', 'Proveedores', 'add', 0),
	(279, '', 'Proveedores', 'edit', 0),
	(280, '', 'Proveedores', 'delete', 0),
	(281, 'Rbac', 'RbacAcciones', 'requireLogin', 0),
	(282, '', 'Consultas', 'add', 0),
	(283, '', 'Consultas', 'edit', 0),
	(284, '', 'Consultas', 'delete', 0),
	(285, '', 'ObrasSociales', 'index', 0),
	(286, '', 'ObrasSociales', 'add', 0),
	(287, '', 'ObrasSociales', 'edit', 0),
	(288, '', 'ObrasSociales', 'delete', 0),
	(289, 'Rbac', 'RbacAcciones', 'delete', 0),
	(290, 'Rbac', 'RbacUsuarios', 'forgetPassword', 1),
	(292, '', 'Pedidos', 'misPedidos', 0),
	(293, 'Rbac', 'Configuraciones', 'add', 0),
	(294, 'Rbac', 'Configuraciones', 'edit', 0),
	(295, 'Rbac', 'Configuraciones', 'delete', 0),
	(296, 'Rbac', 'RbacPerfiles', 'add', 0),
	(297, 'Rbac', 'RbacPerfiles', 'edit', 0),
	(298, 'Rbac', 'RbacPerfiles', 'delete', 0),
	(302, '', 'Consultas', 'view', 0),
	(303, '', 'ProductosArchivos', 'delete', 0),
	(304, '', 'ProductosArchivos', 'add', 0),
	(305, '', 'Consultas', 'response', 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=3534 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_acciones_rbac_perfiles: ~71 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_acciones_rbac_perfiles` DISABLE KEYS */;
REPLACE INTO `rbac_acciones_rbac_perfiles` (`id`, `rbac_accion_id`, `rbac_perfil_id`) VALUES
	(3071, 27, 1),
	(3095, 5, 1),
	(3102, 16, 1),
	(3103, 2, 1),
	(3106, 1, 1),
	(3107, 3, 1),
	(3138, 21, 1),
	(3156, 17, 1),
	(3157, 18, 1),
	(3159, 20, 1),
	(3278, 114, 1),
	(3328, 151, 1),
	(3331, 154, 1),
	(3443, 229, 1),
	(3457, 10, 1),
	(3464, 250, 1),
	(3465, 17, 8),
	(3466, 114, 8),
	(3468, 124, 8),
	(3469, 229, 8),
	(3470, 12, 1),
	(3471, 251, 1),
	(3472, 252, 1),
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
	(3486, 266, 1),
	(3487, 267, 1),
	(3488, 268, 1),
	(3489, 269, 1),
	(3490, 270, 1),
	(3491, 271, 1),
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
	(3510, 290, 1),
	(3512, 292, 1),
	(3515, 293, 1),
	(3516, 294, 1),
	(3517, 295, 1),
	(3518, 296, 1),
	(3519, 297, 1),
	(3520, 298, 1),
	(3522, 273, 1),
	(3523, 302, 1),
	(3527, 263, 8),
	(3528, 268, 8),
	(3531, 303, 1),
	(3532, 304, 1),
	(3533, 305, 1);
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
	(1, 'Administrador', 258),
	(8, 'Cliente', 263);
/*!40000 ALTER TABLE `rbac_perfiles` ENABLE KEYS */;

-- Volcando estructura para tabla ipmagna.rbac_token
CREATE TABLE IF NOT EXISTS `rbac_token` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rbac_usuario_id` int(11) NOT NULL,
  `token` varchar(500) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `validez` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_TOKEN` (`token`),
  KEY `fk_rbac_usuario_idx` (`rbac_usuario_id`),
  CONSTRAINT `fk_rbac_usuarios` FOREIGN KEY (`rbac_usuario_id`) REFERENCES `rbac_usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_token: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_token` DISABLE KEYS */;
REPLACE INTO `rbac_token` (`id`, `rbac_usuario_id`, `token`, `created`, `modified`, `validez`) VALUES
	(43, 2966, 'XSBlD3cCVlard0OjYqD7hIxJ', '2024-09-18 12:55:15', '2024-09-18 12:55:15', 1440);
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
) ENGINE=InnoDB AUTO_INCREMENT=2967 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla ipmagna.rbac_usuarios: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `rbac_usuarios` DISABLE KEYS */;
REPLACE INTO `rbac_usuarios` (`id`, `perfil_id`, `usuario`, `nombre`, `apellido`, `tipo_documento_id`, `documento`, `direccion`, `celular`, `password`, `seed`, `activo`, `created`, `modified`, `created_by`, `modified_by`) VALUES
	(2901, 1, 'flor@gmail.com', 'Florencia', 'Tigani', 1, '30215654', 'Tinogasta 987', NULL, 'bdb402fd82aee66e477e15f0d31b6cac806896cc42bbdfe02eedd7e23b5c3b0d', '1f4477bad7af3616c1f933a02bfabe4e', 1, '2019-10-28 14:50:04', '2024-08-30 18:01:45', NULL, '2923'),
	(2902, 1, 'facu@gmail.com', 'Facundo', 'Ramirez', 1, '38025652', 'Camargo 1512', NULL, '', '5c151c2a9b76f9ef26d7e0f0d00c9a89', 1, NULL, '2024-08-30 18:01:13', NULL, '2923'),
	(2923, 1, 'sebabustelo@gmail.com', 'Sebastian', 'Bustelo', 1, '28999186', 'Juan Agustín Garcia 1854', NULL, '561dfe66b045305d0462693148c03140a89914d8f6ef08f88c8f4b284e24be35', '79514e888b8f2acacc68738d0cbb803e', 1, '2024-08-30 14:29:31', '2024-08-30 14:29:31', '2907', '2907'),
	(2966, 8, 'zebabustelo@gmail.com', 'Walter Sebastian', 'Bustelo', 1, '28999186', 'padilla 752', '2342342', '23c3b7b5bdd600601f685f89e6bb28e55735380f355233bc4acfe935d0aad657', NULL, 1, '2024-09-18 12:01:22', '2024-09-18 12:07:10', NULL, NULL);
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
  CONSTRAINT `fk_kit_cirugia` FOREIGN KEY (`kit_cirugia_id`) REFERENCES `kit_cirugias` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
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
