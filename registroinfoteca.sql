-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2024 a las 04:33:43
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
-- Base de datos: `registroinfoteca`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarLockers` ()   BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 40 DO
        INSERT INTO lockers (numero_locker) VALUES (i);
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cubiculos`
--

CREATE TABLE `cubiculos` (
  `id` int(11) NOT NULL,
  `numero_cubiculo` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'disponible',
  `fecha_reservacion` date DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `hora_entrada` time DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `tipo_cubiculo` varchar(50) DEFAULT NULL,
  `credencial_imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cubiculos`
--

INSERT INTO `cubiculos` (`id`, `numero_cubiculo`, `estado`, `fecha_reservacion`, `usuario`, `hora_entrada`, `hora_salida`, `tipo_cubiculo`, `credencial_imagen`) VALUES
(1, 1, 'Ocupado', '2024-11-03', 'carlo', '20:18:00', '20:19:00', 'Grande', 'credenciales_cubiculos/qrEntrada.jpeg'),
(2, 2, 'Disponible', NULL, NULL, NULL, NULL, 'Mediano', NULL),
(3, 3, 'Disponible', NULL, NULL, NULL, NULL, 'Chico', 'null'),
(4, 4, 'Disponible', NULL, NULL, NULL, NULL, 'Chico', NULL),
(5, 5, 'Disponible', NULL, NULL, NULL, NULL, 'Grande', NULL),
(6, 6, 'Disponible', NULL, NULL, NULL, NULL, 'Mediano', NULL),
(7, 7, 'Disponible', NULL, NULL, NULL, NULL, 'Mediano', NULL),
(8, 8, 'Disponible', NULL, NULL, NULL, NULL, 'Chico', NULL),
(9, 9, 'Disponible', NULL, NULL, NULL, NULL, 'Grande', NULL),
(10, 10, 'Disponible', NULL, NULL, NULL, NULL, 'Mediano', NULL),
(11, 11, 'Disponible', NULL, NULL, NULL, NULL, 'Lectura', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lockers`
--

CREATE TABLE `lockers` (
  `id` int(11) NOT NULL,
  `numero_locker` int(11) NOT NULL,
  `ocupado` tinyint(1) DEFAULT 0,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_reserva` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `lockers`
--

INSERT INTO `lockers` (`id`, `numero_locker`, `ocupado`, `usuario_id`, `fecha_reserva`) VALUES
(1, 1, 1, 1, '2024-11-03 18:28:06'),
(2, 2, 0, 0, '0000-00-00 00:00:00'),
(3, 3, 0, 0, '0000-00-00 00:00:00'),
(4, 4, 0, 0, '0000-00-00 00:00:00'),
(5, 5, 0, 0, '0000-00-00 00:00:00'),
(6, 6, 0, 0, '0000-00-00 00:00:00'),
(7, 7, 0, 0, '0000-00-00 00:00:00'),
(8, 8, 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `qr_adentro`
--

CREATE TABLE `qr_adentro` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `entrada` timestamp NULL DEFAULT NULL,
  `salida` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `qr_adentro`
--

INSERT INTO `qr_adentro` (`id`, `usuario_id`, `entrada`, `salida`) VALUES
(10, 1, '2024-11-03 23:58:11', '2024-11-03 23:58:29'),
(11, 1, '2024-11-04 00:05:30', '2024-11-03 17:08:55'),
(12, 1, '2024-11-03 17:09:10', '2024-11-03 17:09:47'),
(13, 1, '2024-11-03 17:10:01', '2024-11-03 17:40:57'),
(14, 1, '2024-11-03 17:10:10', '2024-11-03 17:40:49'),
(15, 1, '2024-11-03 17:12:00', '2024-11-03 17:40:45'),
(16, 1, '2024-11-03 17:12:09', '2024-11-03 17:40:18'),
(17, 1, '2024-11-03 17:12:39', '2024-11-03 17:39:55'),
(18, 1, '2024-11-03 17:12:49', '2024-11-03 17:27:53'),
(19, 1, '2024-11-03 17:41:06', '2024-11-03 17:42:31'),
(20, 1, '2024-11-03 17:42:38', '2024-11-03 17:43:10'),
(21, 1, '2024-11-03 17:43:48', '2024-11-03 17:44:07'),
(22, 1, '2024-11-03 18:15:16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones_activas`
--

CREATE TABLE `sesiones_activas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `inicio_sesion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fin_sesion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sesiones_activas`
--

INSERT INTO `sesiones_activas` (`id`, `usuario_id`, `inicio_sesion`, `fin_sesion`) VALUES
(2, 1, '2024-11-02 05:07:09', '2024-11-02 13:13:09'),
(3, 1, '2024-11-02 09:46:12', '2024-11-02 17:51:40'),
(4, 1, '2024-11-02 10:52:31', NULL),
(5, 1, '2024-11-02 11:07:49', NULL),
(6, 1, '2024-11-02 11:20:23', NULL),
(7, 1, '2024-11-03 16:53:53', '2024-11-03 17:04:15'),
(8, 1, '2024-11-03 17:05:11', NULL),
(9, 1, '2024-11-03 17:27:39', NULL),
(10, 1, '2024-11-04 02:12:38', NULL),
(11, 1, '2024-11-04 02:57:10', NULL),
(12, 1, '2024-11-04 02:57:23', NULL),
(13, 1, '2024-11-04 02:58:10', NULL),
(14, 1, '2024-11-04 02:58:18', '2024-11-04 02:58:59'),
(15, 1, '2024-11-04 03:11:49', '2024-11-04 03:15:26'),
(16, 1, '2024-11-04 03:18:43', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `matricula` varchar(50) DEFAULT NULL,
  `tipo_usuario` enum('interno','externo') NOT NULL,
  `credencial` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_completo`, `correo`, `usuario`, `contrasena`, `matricula`, `tipo_usuario`, `credencial`, `fecha_registro`) VALUES
(1, 'Carlo', 'carlo@uadec.edu.mx', 'carlo123', '$2y$10$r2kR14sk1F5p9/WwFDWjee3gRJkmjhv4GWnroPRlaF8PvurwAZELe', '22090926', 'interno', '', '2024-10-31 16:40:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lockers`
--
ALTER TABLE `lockers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `qr_adentro`
--
ALTER TABLE `qr_adentro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_idfk` (`usuario_id`);

--
-- Indices de la tabla `sesiones_activas`
--
ALTER TABLE `sesiones_activas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lockers`
--
ALTER TABLE `lockers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `qr_adentro`
--
ALTER TABLE `qr_adentro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `sesiones_activas`
--
ALTER TABLE `sesiones_activas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `qr_adentro`
--
ALTER TABLE `qr_adentro`
  ADD CONSTRAINT `usuario_idfk` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `sesiones_activas`
--
ALTER TABLE `sesiones_activas`
  ADD CONSTRAINT `sesiones_activas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
