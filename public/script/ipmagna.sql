-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2024 a las 15:04:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ipmagna`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `clave` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `valor` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `clave`, `valor`) VALUES
(3, 'Mostrar Captcha', 'No'),
(5, 'skin_admin', 'black-light'),
(7, 'app_email_pass_enc', 'qA/njzCzXuOynw19RKkNPaOzMByL9Z1zzR+mb6QghwHRUFU02YiJFz1dhXdA7fLG3sck71UdQcS3GubJ9mvweFnE2NkLVsqCd/NP6eBP7dH8eG8lEstOvbe1//jPaqbN'),
(8, 'reCaptchaURL', 'http://recaptcha.mrec.ar'),
(9, 'reCaptchaPublic', '6LfokXkUAAAAALPPdkZS13PUa7DQ-C0ehL8tQNdM'),
(10, 'reCaptchaSecret', '6LfokXkUAAAAAP-6DyEGNNyVjuzjK9VZvMZRwI-k'),
(16, 'app_email', 'pruebas_aplicaciones@mrecic.gov.ar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejemplos`
--

CREATE TABLE `ejemplos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rbac_acciones`
--

CREATE TABLE `rbac_acciones` (
  `id` int(11) NOT NULL,
  `plugin` varchar(100) DEFAULT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) DEFAULT NULL,
  `publico` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rbac_acciones`
--

INSERT INTO `rbac_acciones` (`id`, `plugin`, `controller`, `action`, `publico`) VALUES
(1, 'Rbac', 'RbacUsuarios', 'index', 0),
(2, 'Rbac', 'RbacUsuarios', 'agregar', 0),
(3, 'Rbac', 'RbacUsuarios', 'editar', 0),
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
(14, 'Rbac', 'RbacUsuarios', 'autocompleteLdap', 0),
(15, 'Rbac', 'RbacUsuarios', 'validarLoginLdap', 0),
(16, 'Rbac', 'RbacUsuarios', 'validarLoginDB', 0),
(17, 'Rbac', 'RbacUsuarios', 'login', 0),
(18, 'Rbac', 'RbacUsuarios', 'changePass', 0),
(19, 'Rbac', 'RbacUsuarios', 'cambiarPerfil', 0),
(20, 'Rbac', 'RbacUsuarios', 'recuperar', 0),
(21, 'Rbac', 'RbacUsuarios', 'recuperarPass', 0),
(26, 'Rbac', 'RbacUsuarios', 'cambiarEntorno', 1),
(27, 'Rbac', 'Configuraciones', 'index', 0),
(28, 'Rbac', 'Configuraciones', 'editar', 0),
(111, NULL, 'Ejemplos', '_null', NULL),
(112, NULL, 'Ejemplos', 'index', NULL),
(113, NULL, 'Ejemplos', 'ver', NULL),
(114, NULL, 'Pages', 'display', NULL),
(115, NULL, 'Pages', 'ditic', NULL),
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
(171, 'Db', 'Db', '_null', NULL),
(172, 'Db', 'Db', 'index', NULL),
(174, 'Db', 'Db', 'getClientIP', NULL),
(176, 'Rbac', 'Configuraciones', 'eliminar', NULL),
(177, 'Rbac', 'Configuraciones', 'agregar', NULL),
(229, 'Rbac', 'RbacUsuarios', 'logout', 0),
(250, 'Rbac', 'RbacUsuarios', 'register', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rbac_acciones_rbac_perfiles`
--

CREATE TABLE `rbac_acciones_rbac_perfiles` (
  `id` int(11) NOT NULL,
  `rbac_accion_id` int(11) NOT NULL,
  `rbac_perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rbac_acciones_rbac_perfiles`
--

INSERT INTO `rbac_acciones_rbac_perfiles` (`id`, `rbac_accion_id`, `rbac_perfil_id`) VALUES
(3070, 28, 1),
(3071, 27, 1),
(3095, 5, 1),
(3096, 6, 1),
(3097, 7, 1),
(3102, 16, 1),
(3103, 2, 1),
(3104, 4, 1),
(3105, 15, 1),
(3106, 1, 1),
(3107, 3, 1),
(3108, 14, 1),
(3138, 21, 1),
(3156, 17, 1),
(3157, 18, 1),
(3158, 19, 1),
(3159, 20, 1),
(3160, 26, 1),
(3276, 112, 1),
(3277, 113, 1),
(3278, 114, 1),
(3279, 115, 1),
(3322, 145, 1),
(3325, 148, 1),
(3327, 150, 1),
(3328, 151, 1),
(3331, 154, 1),
(3342, 172, 1),
(3344, 174, 1),
(3346, 176, 1),
(3347, 177, 1),
(3443, 229, 1),
(3457, 10, 1),
(3462, 8, 1),
(3464, 250, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rbac_perfiles`
--

CREATE TABLE `rbac_perfiles` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `accion_default_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rbac_perfiles`
--

INSERT INTO `rbac_perfiles` (`id`, `descripcion`, `accion_default_id`) VALUES
(1, 'Administrador', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rbac_token`
--

CREATE TABLE `rbac_token` (
  `id` int(10) NOT NULL,
  `token` varchar(500) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `validez` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rbac_usuarios`
--

CREATE TABLE `rbac_usuarios` (
  `id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `usuario` varchar(120) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `seed` varchar(64) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` varchar(16) DEFAULT NULL,
  `modified_by` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `rbac_usuarios`
--

INSERT INTO `rbac_usuarios` (`id`, `perfil_id`, `usuario`, `nombre`, `apellido`, `correo`, `password`, `seed`, `activo`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(2901, 1, 'Flor', 'Florencia', 'Tigani', 'flor@gmail.com', 'bdb402fd82aee66e477e15f0d31b6cac806896cc42bbdfe02eedd7e23b5c3b0d', '1f4477bad7af3616c1f933a02bfabe4e', 1, '2019-10-28 14:50:04', '2019-10-28 14:50:04', NULL, NULL),
(2902, 1, 'Facu', 'Facundo', 'Ramirez', 'facu@gmail.com', '', '5c151c2a9b76f9ef26d7e0f0d00c9a89', 1, NULL, NULL, NULL, NULL),
(2907, 1, 'seba', 'Walter Sebastián ', 'Bustelo', 'sebabustelo@gmail.com', 'bdb402fd82aee66e477e15f0d31b6cac806896cc42bbdfe02eedd7e23b5c3b0f', 'dfbd282c18300fa0eccceea6c5fac41f', 1, NULL, NULL, NULL, '2907');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `nombre_archivo` varchar(65) NOT NULL,
  `nombre_original` varchar(64) NOT NULL,
  `hash_archivo` varchar(64) NOT NULL,
  `extension_archivo` varchar(10) NOT NULL,
  `hash_llave` varchar(64) NOT NULL,
  `subdir_zero` varchar(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ejemplos`
--
ALTER TABLE `ejemplos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rbac_acciones`
--
ALTER TABLE `rbac_acciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `controller` (`controller`,`action`);

--
-- Indices de la tabla `rbac_acciones_rbac_perfiles`
--
ALTER TABLE `rbac_acciones_rbac_perfiles`
  ADD PRIMARY KEY (`id`,`rbac_accion_id`,`rbac_perfil_id`),
  ADD KEY `fk_ap_accion_idx` (`rbac_accion_id`),
  ADD KEY `fk_ap_perfil_idx` (`rbac_perfil_id`);

--
-- Indices de la tabla `rbac_perfiles`
--
ALTER TABLE `rbac_perfiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `descripcion_UNIQUE` (`descripcion`),
  ADD KEY `rbac_perfiles_ra` (`accion_default_id`);

--
-- Indices de la tabla `rbac_token`
--
ALTER TABLE `rbac_token`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rbac_usuarios`
--
ALTER TABLE `rbac_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_UNIQUE` (`usuario`),
  ADD KEY `FK_rbac_usuarios_rbac_perfiles` (`perfil_id`);

--
-- Indices de la tabla `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `ejemplos`
--
ALTER TABLE `ejemplos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `rbac_acciones`
--
ALTER TABLE `rbac_acciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT de la tabla `rbac_acciones_rbac_perfiles`
--
ALTER TABLE `rbac_acciones_rbac_perfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3465;

--
-- AUTO_INCREMENT de la tabla `rbac_perfiles`
--
ALTER TABLE `rbac_perfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rbac_token`
--
ALTER TABLE `rbac_token`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rbac_usuarios`
--
ALTER TABLE `rbac_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2923;

--
-- AUTO_INCREMENT de la tabla `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `rbac_acciones_rbac_perfiles`
--
ALTER TABLE `rbac_acciones_rbac_perfiles`
  ADD CONSTRAINT `fk_acion` FOREIGN KEY (`rbac_accion_id`) REFERENCES `rbac_acciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_perfil` FOREIGN KEY (`rbac_perfil_id`) REFERENCES `rbac_perfiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rbac_perfiles`
--
ALTER TABLE `rbac_perfiles`
  ADD CONSTRAINT `rbac_perfiles_ra` FOREIGN KEY (`accion_default_id`) REFERENCES `rbac_acciones` (`id`);

--
-- Filtros para la tabla `rbac_usuarios`
--
ALTER TABLE `rbac_usuarios`
  ADD CONSTRAINT `FK_rbac_usuarios_rbac_perfiles` FOREIGN KEY (`perfil_id`) REFERENCES `rbac_perfiles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
