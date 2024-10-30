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

-- Volcando estructura para tabla iron_gym.actividades
CREATE TABLE IF NOT EXISTS `actividades` (
  `id_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `precio_mensual` decimal(10,2) DEFAULT NULL,
  `precio_clase` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_actividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.actividades: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `actividades` DISABLE KEYS */;
REPLACE INTO `actividades` (`id_actividad`, `nombre`, `descripcion`, `precio_mensual`, `precio_clase`) VALUES
	(1, 'Yoga', 'Clase de yoga para principiantes.', 1500.00, 300.00),
	(2, 'Pilates', 'Entrenamiento de pilates para tonificar.', 1600.00, 320.00),
	(3, 'Zumba', 'Clase de zumba para divertirse y ejercitarse.', 1400.00, 280.00),
	(4, 'Entrenamiento Funcional', 'Entrenamiento de cuerpo completo.', 1800.00, 360.00);
/*!40000 ALTER TABLE `actividades` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.actividad_sede
CREATE TABLE IF NOT EXISTS `actividad_sede` (
  `id_actividad_sede` int(11) NOT NULL AUTO_INCREMENT,
  `id_actividad` int(11) NOT NULL,
  `id_sede` int(11) NOT NULL,
  PRIMARY KEY (`id_actividad_sede`),
  KEY `id_actividad` (`id_actividad`),
  KEY `id_sede` (`id_sede`),
  CONSTRAINT `actividad_sede_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id_actividad`),
  CONSTRAINT `actividad_sede_ibfk_2` FOREIGN KEY (`id_sede`) REFERENCES `sedes` (`id_sede`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.actividad_sede: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `actividad_sede` DISABLE KEYS */;
REPLACE INTO `actividad_sede` (`id_actividad_sede`, `id_actividad`, `id_sede`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 3, 2),
	(4, 4, 3);
/*!40000 ALTER TABLE `actividad_sede` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.admin: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
REPLACE INTO `admin` (`id_admin`, `email`, `usuario`, `contrasena`) VALUES
	(1, 'admin1@example.com', 'admin1', 'password1'),
	(2, 'admin2@example.com', 'admin2', 'password2');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `apellido` varchar(150) NOT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `altura` int(11) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `id_tipo_documento` int(11) NOT NULL,
  `numero_documento` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_nacimiento` date DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email` (`email`),
  KEY `tipo_documento` (`id_tipo_documento`),
  CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento` (`id_tipo_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.cliente: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
REPLACE INTO `cliente` (`id_cliente`, `nombre`, `apellido`, `genero`, `telefono`, `email`, `direccion`, `altura`, `localidad`, `codigo_postal`, `id_tipo_documento`, `numero_documento`, `fecha_registro`, `fecha_nacimiento`, `contrasena`) VALUES
	(1, 'Juan', 'Pérez', 'Masculino', '1234567890', 'juan.perez@example.com', 'Calle Falsa 123', 175, 'Ciudad A', 1000, 1, 12345678, '2024-10-30 19:03:19', '1990-01-01', 'password1'),
	(2, 'María', 'Gómez', 'Femenino', '0987654321', 'maria.gomez@example.com', 'Calle Verdadera 456', 160, 'Ciudad B', 2000, 2, 87654321, '2024-10-30 19:03:19', '1985-05-15', 'password2');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.cliente_membresia
CREATE TABLE IF NOT EXISTS `cliente_membresia` (
  `id_cliente_membresia` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_membresia` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_expiracion` date NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `vencido` tinyint(1) DEFAULT NULL,
  `id_pago` int(11) NOT NULL,
  PRIMARY KEY (`id_cliente_membresia`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_membresia` (`id_membresia`),
  KEY `id_pago` (`id_pago`),
  CONSTRAINT `cliente_membresia_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `cliente_membresia_ibfk_2` FOREIGN KEY (`id_membresia`) REFERENCES `membresias` (`id_membresia`),
  CONSTRAINT `cliente_membresia_ibfk_3` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.cliente_membresia: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cliente_membresia` DISABLE KEYS */;
REPLACE INTO `cliente_membresia` (`id_cliente_membresia`, `id_cliente`, `id_membresia`, `fecha_inicio`, `fecha_expiracion`, `fecha_registro`, `vencido`, `id_pago`) VALUES
	(1, 1, 1, '2024-01-01', '2025-01-01', '2024-10-30 19:06:00', 0, 1),
	(2, 2, 2, '2024-02-01', '2025-02-01', '2024-10-30 19:06:00', 0, 2);
/*!40000 ALTER TABLE `cliente_membresia` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.dia_horario
CREATE TABLE IF NOT EXISTS `dia_horario` (
  `id_dia_horario` int(11) NOT NULL AUTO_INCREMENT,
  `id_actividad_sede` int(11) NOT NULL,
  `dia` varchar(255) DEFAULT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `cupos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dia_horario`),
  KEY `id_actividad_sede` (`id_actividad_sede`),
  CONSTRAINT `dia_horario_ibfk_1` FOREIGN KEY (`id_actividad_sede`) REFERENCES `actividad_sede` (`id_actividad_sede`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.dia_horario: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `dia_horario` DISABLE KEYS */;
REPLACE INTO `dia_horario` (`id_dia_horario`, `id_actividad_sede`, `dia`, `horario`, `cupos`) VALUES
	(1, 1, 'Lunes', '08:00 - 09:00', 10),
	(2, 2, 'Martes', '09:00 - 10:00', 15),
	(3, 3, 'Miércoles', '10:00 - 11:00', 12),
	(4, 4, 'Jueves', '11:00 - 12:00', 8);
/*!40000 ALTER TABLE `dia_horario` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.membresias
CREATE TABLE IF NOT EXISTS `membresias` (
  `id_membresia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `accesos` int(11) DEFAULT NULL,
  `descuento` decimal(4,2) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_membresia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.membresias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `membresias` DISABLE KEYS */;
REPLACE INTO `membresias` (`id_membresia`, `nombre`, `accesos`, `descuento`, `precio`) VALUES
	(1, 'Mensual', 10, 0.10, 1500.00),
	(2, 'Trimestral', 30, 0.15, 4000.00),
	(3, 'Anual', 365, 0.20, 12000.00);
/*!40000 ALTER TABLE `membresias` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.no_cliente
CREATE TABLE IF NOT EXISTS `no_cliente` (
  `id_no_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `numero_telefono` varchar(15) NOT NULL,
  PRIMARY KEY (`id_no_cliente`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.no_cliente: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `no_cliente` DISABLE KEYS */;
REPLACE INTO `no_cliente` (`id_no_cliente`, `nombre`, `apellido`, `mail`, `numero_telefono`) VALUES
	(1, 'Carlos', 'Sánchez', 'carlos.sanchez@example.com', '1231231234'),
	(2, 'Laura', 'Martinez', 'laura.martinez@example.com', '4564564567');
/*!40000 ALTER TABLE `no_cliente` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.pagos
CREATE TABLE IF NOT EXISTS `pagos` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `monto` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL,
  `metodo_pago` varchar(255) NOT NULL,
  `pagado` tinyint(1) DEFAULT NULL,
  `comprobante` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.pagos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
REPLACE INTO `pagos` (`id_pago`, `monto`, `fecha`, `metodo_pago`, `pagado`, `comprobante`) VALUES
	(1, 1500.00, '2024-10-30 19:05:30', 'Tarjeta de Crédito', 1, 'comp1.pdf'),
	(2, 4000.00, '2024-10-30 19:05:30', 'Transferencia', 1, 'comp2.pdf');
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.reservas
CREATE TABLE IF NOT EXISTS `reservas` (
  `id_reservas` int(11) NOT NULL AUTO_INCREMENT,
  `id_dia_horario` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_no_cliente` int(11) DEFAULT NULL,
  `id_pago` int(11) DEFAULT NULL,
  `estado_reserva` tinyint(1) DEFAULT 1,
  `fecha_reserva` datetime NOT NULL,
  PRIMARY KEY (`id_reservas`),
  KEY `id_dia_horario` (`id_dia_horario`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_no_cliente` (`id_no_cliente`),
  KEY `id_pago` (`id_pago`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_dia_horario`) REFERENCES `dia_horario` (`id_dia_horario`),
  CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`id_no_cliente`) REFERENCES `no_cliente` (`id_no_cliente`),
  CONSTRAINT `reservas_ibfk_4` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.reservas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
REPLACE INTO `reservas` (`id_reservas`, `id_dia_horario`, `id_cliente`, `id_no_cliente`, `id_pago`, `estado_reserva`, `fecha_reserva`) VALUES
	(1, 1, 1, NULL, 1, 1, '2024-10-30 19:06:00'),
	(2, 2, NULL, 1, 2, 1, '2024-10-30 19:06:00');
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.sedes
CREATE TABLE IF NOT EXISTS `sedes` (
  `id_sede` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `altura` int(11) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `numero_telefono` varchar(20) NOT NULL,
  PRIMARY KEY (`id_sede`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.sedes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `sedes` DISABLE KEYS */;
REPLACE INTO `sedes` (`id_sede`, `nombre`, `direccion`, `altura`, `localidad`, `codigo_postal`, `numero_telefono`) VALUES
	(1, 'Recoleta', 'Av. Santa Fe', 1234, 'CABA', 1416, '1140875458'),
	(2, 'Lomas de Zamora', 'Av. Hipólito Yrigoyen', 4321, 'Lomas de Zamora', 1132, '1140875477'),
	(3, 'Adrogue', 'Calle Brown', 567, 'Almirante Brown', 1284, '1140875444');
/*!40000 ALTER TABLE `sedes` ENABLE KEYS */;

-- Volcando estructura para tabla iron_gym.tipo_documento
CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_tipo_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla iron_gym.tipo_documento: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tipo_documento` DISABLE KEYS */;
REPLACE INTO `tipo_documento` (`id_tipo_documento`, `tipo`) VALUES
	(1, 'DNI'),
	(2, 'Pasaporte'),
	(3, 'Licencia de Conducir');
/*!40000 ALTER TABLE `tipo_documento` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
