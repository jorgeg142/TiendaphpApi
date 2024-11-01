-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2024 a las 19:03:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `valoracion` int(1) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `id_producto`, `id_usuario`, `valoracion`, `comentario`, `fecha`) VALUES
(7, 6, 6, 3, 'esta crudo', '2024-10-03 00:07:39'),
(8, 7, 6, 1, 'asdsd', '2024-10-03 17:26:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden`
--

CREATE TABLE `detalle_orden` (
  `id` int(11) NOT NULL,
  `id_orden` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 0 COMMENT 'false=no comprado, true=comprado',
  `precio` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_orden`
--

INSERT INTO `detalle_orden` (`id`, `id_orden`, `id_producto`, `id_usuario`, `cantidad`, `estado`, `precio`) VALUES
(100, 92, 6, 6, 1, 1, 10000),
(101, 93, 7, 6, 1, 1, 30000),
(104, 97, 5, 6, 1, 1, 20000),
(105, 97, 12, 6, 1, 1, 100000),
(108, 100, 12, 6, 1, 1, 100000),
(111, 104, 12, 6, 1, 1, 100000),
(112, 105, 5, 6, 1, 1, 20000),
(113, 106, 7, 6, 1, 1, 30000),
(114, 107, 6, 6, 1, 1, 10000),
(115, 108, 7, 6, 1, 1, 30000),
(118, 111, 6, 6, 2, 1, 20000),
(119, 111, 5, 6, 2, 1, 40000),
(120, 112, 5, 6, 2, 1, 40000),
(121, 112, 6, 6, 2, 1, 20000),
(122, 112, 7, 6, 2, 1, 60000),
(123, 112, 12, 6, 2, 1, 200000),
(125, 114, 7, 6, 1, 1, 30000),
(126, 115, 7, 6, 1, 1, 30000),
(127, 115, 12, 6, 2, 1, 200000),
(128, 116, 5, 6, 1, 1, 20000),
(129, 116, 5, 6, 2, 1, 40000),
(130, 117, 5, 6, 1, 1, 20000),
(131, 119, 13, 6, 2, 1, 24000),
(132, 120, 13, 6, 1, 1, 12000),
(133, 121, 13, 6, 2, 1, 24000),
(134, 122, 6, 6, 1, 1, 10000),
(135, 123, 5, 6, 1, 1, 20000),
(137, 124, 5, 6, 1, 1, 20000),
(138, 125, 6, 9, 1, 1, 10000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(11) NOT NULL,
  `estado` int(2) NOT NULL DEFAULT 2,
  `fecha` datetime DEFAULT current_timestamp(),
  `total` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id`, `estado`, `fecha`, `total`) VALUES
(91, 1, '2024-10-05 05:57:08', 100000),
(92, 1, '2024-10-05 06:02:51', 10000),
(93, 1, '2024-10-05 06:08:06', 30000),
(94, 1, '2024-10-05 15:12:42', 10000),
(95, 1, '2024-10-05 15:12:43', 10000),
(96, 1, '2024-10-05 15:17:37', 20000),
(97, 1, '2024-10-05 15:50:32', 120000),
(100, 1, '2024-10-05 16:12:56', 100000),
(101, 2, '2024-10-05 16:13:51', 100000),
(104, 1, '2024-10-05 17:11:33', 100000),
(105, 2, '2024-10-05 17:20:41', 20000),
(106, 2, '2024-10-05 17:56:51', 30000),
(107, 2, '2024-10-05 18:27:05', 10000),
(108, 2, '2024-10-05 18:27:32', 30000),
(111, 2, '2024-10-05 19:31:41', 60000),
(112, 2, '2024-10-05 19:37:32', 320000),
(114, 2, '2024-10-05 20:21:59', 30000),
(115, 2, '2024-10-05 21:03:42', 230000),
(116, 2, '2024-10-05 21:07:21', 60000),
(117, 2, '2024-10-05 21:35:05', 20000),
(118, 2, '2024-10-05 21:35:06', 20000),
(119, 2, '2024-10-05 23:13:59', 24000),
(120, 2, '2024-10-05 23:16:17', 12000),
(121, 2, '2024-10-06 04:16:44', 24000),
(122, 1, '2024-10-06 04:18:08', 10000),
(123, 2, '2024-10-07 03:55:49', 20000),
(124, 1, '2024-10-07 14:55:50', 20000),
(125, 2, '2024-10-07 15:01:43', 10000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_orden` int(11) DEFAULT NULL,
  `id_transaccion` varchar(100) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `monto` int(8) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `enlace_pago` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_orden`, `id_transaccion`, `estado`, `monto`, `fecha_pago`, `metodo_pago`, `enlace_pago`) VALUES
(3, 101, 'demo101', 1, 100000, '2024-10-05 14:15:20', 'AdamsPay', ''),
(6, 104, 'demo104', 1, 100000, '2024-10-05 15:11:33', 'AdamsPay', ''),
(7, 105, 'demo105', 1, 20000, '2024-10-05 15:20:41', 'AdamsPay', ''),
(8, 106, 'demo106', 1, 30000, '2024-10-05 15:56:51', 'AdamsPay', ''),
(9, 107, 'demo107', 1, 10000, '2024-10-05 16:27:05', 'AdamsPay', ''),
(10, 108, 'demo108', 1, 30000, '2024-10-05 16:27:32', 'AdamsPay', ''),
(12, 111, 'demo111', 1, 60000, '2024-10-05 17:31:41', 'AdamsPay', ''),
(13, 112, 'demo112', 1, 320000, '2024-10-05 17:37:32', 'AdamsPay', ''),
(15, 114, 'demo114', 1, 30000, '2024-10-05 18:21:59', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo114'),
(16, 115, 'demo115', 1, 230000, '2024-10-05 19:03:42', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo115'),
(17, 116, 'demo116', 1, 60000, '2024-10-05 19:07:21', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo116'),
(18, 117, 'demo117', 1, 20000, '2024-10-05 19:35:05', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo117'),
(19, 118, 'demo118', 1, 20000, '2024-10-05 19:35:06', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo118'),
(20, 119, 'demo119', 1, 24000, '2024-10-05 21:13:59', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo119'),
(21, 120, 'demo120', 1, 12000, '2024-10-05 21:16:17', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo120'),
(22, 121, 'demo121', 1, 24000, '2024-10-06 02:16:44', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo121'),
(23, 122, 'demo122', 2, 10000, '2024-10-06 02:18:08', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo122'),
(24, 123, 'demo123', 1, 20000, '2024-10-07 01:55:49', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo123'),
(25, 124, 'demo124', 2, 20000, '2024-10-07 12:55:50', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo124'),
(26, 125, 'demo125', 1, 10000, '2024-10-07 13:01:43', 'AdamsPay', 'https://staging.adamspay.com/pay/don-onofre413/debt/demo125');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` int(8) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` varchar(200) DEFAULT 'imagendefecto.png',
  `stock` int(2) NOT NULL DEFAULT 0,
  `puntuacion_total` decimal(7,2) NOT NULL DEFAULT 0.00,
  `numero_reseñas` int(11) NOT NULL DEFAULT 0,
  `puntuacion_media` decimal(5,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `estado`, `imagen`, `stock`, `puntuacion_total`, `numero_reseñas`, `puntuacion_media`) VALUES
(5, 'Pollo de goma', 'Es un pollo. Es de Goma. No está vivo. No es comestible', 20000, 1, '2023-11-12 - 13-21-05-pollo-de-goma.jpg', 0, 10.00, 2, 5.000),
(6, 'Gamba', 'Es una gamba. En singular', 10000, 1, '2023-11-12 - 13-12-17-Gamba.jpg', 2, 9.00, 3, 3.000),
(7, 'Pollo (Sin Goma)', 'En un pollo. No es de goma. Es comestible', 30000, 1, '2023-11-12 - 13-14-48-pollo-crudo.jpg', 4, 6.50, 3, 2.167),
(12, 'fuente', 'fuente xbox', 100000, 1, '2024-10-03 - 23-18-53-200-240V-EU-AC-Adapter-Charger-Power-Supply-Cable-Cord-for-Microsoft-Xbox-360-Console.jpg_640x640.jpg', 4, 0.00, 0, 0.000),
(13, 'kirara', 'es kirara :3', 12000, 0, '2024-10-05 - 22-59-18-ScreenShot_20240826162520.png', 1, 0.00, 0, 0.000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo_rol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `usuario_id`, `tipo_rol_id`) VALUES
(1, 6, 1),
(2, 4, 2),
(3, 5, 2),
(4, 3, 2),
(5, 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_estado_ordenes`
--

CREATE TABLE `tipos_estado_ordenes` (
  `id` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_estado_ordenes`
--

INSERT INTO `tipos_estado_ordenes` (`id`, `nombre_estado`, `descripcion`) VALUES
(1, 'pendiente', 'La orden ha sido creada, pero aún no se ha pagado.'),
(2, 'procesando', 'La orden ha sido pagada y está en proceso de preparación.'),
(3, 'completada', 'La orden ha sido enviada/entregada al cliente.'),
(4, 'cancelada', 'La orden fue cancelada, ya sea por el cliente o por falta de pago.'),
(5, 'fallida', 'Algo salió mal y la orden no puede ser procesada.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_estado_pagos`
--

CREATE TABLE `tipos_estado_pagos` (
  `id` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_estado_pagos`
--

INSERT INTO `tipos_estado_pagos` (`id`, `nombre_estado`, `descripcion`) VALUES
(1, 'aprobado', 'El pago fue realizado y confirmado por la pasarela.'),
(2, 'pendiente', 'El pago aún no se ha confirmado (ej., si es una transferencia o cheque).'),
(3, 'fallido', 'El intento de pago fue rechazado o fallido por la pasarela.'),
(4, 'reembolsado', 'Si el pago fue reembolsado al cliente.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_roles`
--

CREATE TABLE `tipos_roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_roles`
--

INSERT INTO `tipos_roles` (`id`, `nombre`, `descripcion`) VALUES
(1, 'admin', 'es administrador'),
(2, 'usuario', 'Es usuario normal y corriente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `password`) VALUES
(3, 'pepe', '1234'),
(4, 'Gonzalo', '1234'),
(5, 'Larry Kaleche', '1234'),
(6, 'JN142', '123'),
(7, 'prueba1', '123'),
(8, 'prueba2', '1234'),
(9, 'x', 'x');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `comentarios_ibfk_1` (`id_producto`);

--
-- Indices de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_orden` (`id_orden`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `detalle_orden_ibfk_3` (`id_usuario`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estado` (`estado`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_orden` (`id_orden`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `tipo_rol_id` (`tipo_rol_id`);

--
-- Indices de la tabla `tipos_estado_ordenes`
--
ALTER TABLE `tipos_estado_ordenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_estado_pagos`
--
ALTER TABLE `tipos_estado_pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_roles`
--
ALTER TABLE `tipos_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipos_estado_ordenes`
--
ALTER TABLE `tipos_estado_ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipos_estado_pagos`
--
ALTER TABLE `tipos_estado_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipos_roles`
--
ALTER TABLE `tipos_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD CONSTRAINT `detalle_orden_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id`),
  ADD CONSTRAINT `detalle_orden_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalle_orden_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `fk_estado` FOREIGN KEY (`estado`) REFERENCES `tipos_estado_ordenes` (`id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id`),
  ADD CONSTRAINT `pagos_ibfk_3` FOREIGN KEY (`estado`) REFERENCES `tipos_estado_pagos` (`id`);

--
-- Filtros para la tabla `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `roles_ibfk_2` FOREIGN KEY (`tipo_rol_id`) REFERENCES `tipos_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
