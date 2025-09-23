-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2025 a las 19:00:17
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
-- Base de datos: `proyecto_inv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `nombre_producto` varchar(100) DEFAULT NULL,
  `estado_producto` varchar(50) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_ingreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo`, `categoria`, `nombre_producto`, `estado_producto`, `cantidad`, `precio`, `fecha_ingreso`) VALUES
(13, '09', 'Paq. Papas', 'Papas Margarita Original', 'NUEVO', 15, 50000.00, '2025-08-25'),
(14, '10', 'Bebidas', '7Up', 'NUEVO', 4, 5000.00, '2025-08-25'),
(15, '111', 'Bebidas', 'Té Lipton', 'NUEVO', 8, 500000.00, '2025-08-25'),
(16, '12', 'Paq. Papas', 'Papas Natural Mix', 'NUEVO', 15, 2000.00, '2025-08-25'),
(23, '01', 'Paq. Papas', 'Papas Rizadas', 'NUEVO', 12, 3000.00, '2025-08-25'),
(25, '03', 'Paq. Papas', 'De Todito', 'NUEVO', 30, 3000.00, '2025-08-25'),
(26, '04', 'Bebidas', 'Quatro', 'NUEVO', 300, 5600.00, '2025-08-25'),
(27, '06', 'Paq. Ponques', 'Chocorramo', 'NUEVO', 45, 2500.00, '2025-08-25'),
(29, '001', 'Bebidas', 'Qatro', 'NUEVO', 85, 3200.00, '2025-08-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperacion`
--

CREATE TABLE `recuperacion` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expiracion` datetime NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `fecha_registro`) VALUES
(1, 'juan', 'juan@gmail.com', '$2y$10$quuZMB7JxLgrr.m5tn8KeeAd0HalMmDh5.cZD3U1Jwdvdy5SkaH7i', '2025-08-27 12:58:17'),
(2, 'david', 'david@gmail.com', '$2y$10$ZYDt.WtYRh0kd8Kt/39Nte8vttntCnoFxTW2RhPZ2oCrzVgrN6ppO', '2025-08-27 13:03:54'),
(3, 'ruiz', 'ruiz@gmail.com', '$2y$10$XKVu2GH7FI8UCaUdhfGHpOBwNenXHgdKX.CAn.s.k.VMPxyyAr8.K', '2025-08-27 13:09:09'),
(4, 'ana', 'ana@gmail.com', '$2y$10$Dsp8sy0X7l3dKABWR.jGTe6HeP3gbr1O2BRDZx3b3U7.Qvi3AC1ym', '2025-08-27 13:11:37'),
(5, 'lolo', 'lolo@gmail.com', '$2y$10$peA5DlAWphO4tBtSWbMuw.YwV98L3pvy3S4VSpDAWLXECX3spDC4W', '2025-08-28 13:15:42'),
(6, 'marcos', 'marcos@gmail.com', '$2y$10$KZwnjt.IPrD216aFBiV/4eJbiqKpuhh9URwmlktJwxVTfsl.uZ5xe', '2025-08-28 13:16:24'),
(7, 'polo', 'polo@gmail.com', '$2y$10$JMXr.d.fs21HItpiwUm2MOmJ3bE.p18Y57qcIt3xdvqgcqa.R9nZy', '2025-08-28 13:17:51'),
(8, 'pali', 'pali@gmail.com', '$2y$10$JyVCcvTR/A2MyZWWZlb3dOLQGjXs38vlfp9oqSGPaPbeo8FAtYfCG', '2025-08-28 13:18:23'),
(9, 'dani', 'dani@gmail.com', '$2y$10$L/9FpxOH5jDpNYgLIb/E9eJefzqNC04KJoVLUWHng58twwBHQw62K', '2025-08-28 01:45:13'),
(10, 'nicolas', 'nt885659@gmail.com', '$2y$10$MHvQ.YGbZOrpgpR8paGGJuLj7ts.3icoCvyvl3G09zM2S4bcJdSaK', '2025-08-28 16:34:20'),
(11, 'yeral', 'yeye@gmail.com', '$2y$10$Nmph76ztiiUVGvt6yOyq1uXHM0NuuMtCNe5aBqf/cxjrm0gH41Vo.', '2025-08-28 01:21:02'),
(12, 'juan', 'juan1@gmail.com', '$2y$10$BxlIEP1T3Tg0P1nVVw087OdZQEWENd.6plpxMXT7LGPcwEbmkzNOS', '2025-08-28 16:05:55'),
(13, 'Juan', 'davidserranoruiz01@gmail.com', '$2y$10$566XpWK2RvzpYxzP2QsnDOdVKaOtdQD.S7zbFjxwO9APHXNudG222', '2025-08-28 16:51:16'),
(14, 'Sebastian', 'sebastianguzman266@gmail.com', '$2y$10$JT4RbAQN9BnjvJseGt9lPOf1VIi2GHEZvernTMsKeXqrG/eS2puEG', '2025-08-29 07:45:55');
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventass`
--

CREATE TABLE `ventass` (
  `id_venta` int(11) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `cantidad_vendida` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `nombre_comprador` varchar(255) NOT NULL,
  `telefono_comprador` varchar(20) NOT NULL,
  `direccion_comprador` text NOT NULL,
  `fecha_venta` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(10) DEFAULT 'Activa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventass`
--

INSERT INTO `ventass` (`id_venta`, `producto`, `cantidad_vendida`, `precio`, `total`, `nombre_comprador`, `telefono_comprador`, `direccion_comprador`, `fecha_venta`, `estado`) VALUES
(1, 'Quatro', 20, 5600.00, 0.00, 'Nicolas', '3206346853', 'cll 58i bis 7878', '2025-08-28 05:00:00', 'Activa'),
(2, '7Up', 1, 5000.00, 0.00, 'Nicolas', '3206346853', 'cll 58i bis 7878', '2025-08-28 05:00:00', 'Activa'),
(3, 'Quatro', 10, 5600.00, 0.00, 'popkpkp', '53153', '351312', '2025-08-28 05:00:00', 'Activa'),
(4, 'Qatro', 15, 3200.00, 0.00, 'juan', '31212112', '1233135', '2025-08-28 05:00:00', 'Activa'),
(5, 'Chocorramo', 2, 2500.00, 0.00, 'eddeded', '563636', '452545', '2025-08-28 05:00:00', 'Activa'),
(6, 'Chocorramo', 10, 2500.00, 0.00, 'tgfgb', '45432', '4325', '2025-08-28 23:29:28', 'Activa'),
(7, 'Chocorramo', 1, 2500.00, 0.00, 'mgjmndg', '5745', '643643', '2025-08-28 16:31:51', 'Activa');

--
-- Disparadores `ventass`
--
DELIMITER $$
CREATE TRIGGER `restar_inventario` AFTER INSERT ON `ventass` FOR EACH ROW BEGIN
  UPDATE productos
  SET cantidad = cantidad - NEW.cantidad_vendida
  WHERE nombre_producto = NEW.producto;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `recuperacion`
--
ALTER TABLE `recuperacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `ventass`
--
ALTER TABLE `ventass`
  ADD PRIMARY KEY (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `recuperacion`
--
ALTER TABLE `recuperacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ventass`
--
ALTER TABLE `ventass`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
