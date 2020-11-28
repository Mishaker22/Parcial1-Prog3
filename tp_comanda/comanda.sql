-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2020 a las 10:15:48
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `clave` varchar(270) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `usuario`, `email`, `clave`) VALUES
(1, 'alex mora', 'alexillo', 'alexillo@gmail.com', '$2y$10$ehsBYQNtFIvOVtZTTl2AN.tCV/bIExD5gsxnkDp4zy2M0Vlmp9DMC'),
(2, 'ricardo herran', 'rasta', 'ras@gmail.com', '$2y$10$N5UtTP8VVq0lCTmlDdixNe5a.Swe5lj0MbMl/zhRqrk2VKQaLJtBu'),
(3, 'oscar munoz', 'louchon', 'fercho@gmail.com', '$2y$10$x3RAiA/kqmCH3nq1klhbKuibURtJFyOpktmvnwmZJTq.uUCPZ/XE2'),
(4, 'diego pena', 'diego', 'diego@gmail.com', '$2y$10$CMxbAlkIlVOk8qq0TU1ubeBrMZOOBCtxDJLFW7fb1H5UDS537aMQK');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandas`
--

CREATE TABLE `comandas` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comandas`
--

INSERT INTO `comandas` (`id`, `id_pedido`, `total`) VALUES
(1, 4, 200),
(2, 2, 920),
(3, 1, 620);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `email` varchar(80) NOT NULL,
  `clave` varchar(270) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `id_sector` int(20) DEFAULT NULL,
  `operaciones` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`id`, `nombre`, `usuario`, `email`, `clave`, `tipo`, `id_sector`, `operaciones`) VALUES
(2, 'michell quintero hernandez', 'mishaker22', 'mishaker22@gmail.com', '$2y$10$m5jiNK7mnHtsOGrYjrd6NODqinNU7AQ.NiL9LGNtOZWpWzZCbdP4q', 'socio', 5, 0),
(3, 'jessica quintero hernandez', 'andrecilla', 'andrecilla17@gmail.com', '$2y$10$WsAR4qWzyhlPHHGbfbSjDe4Vbp9SyuQOZ7jmNTtS0/vttl/EqQK9u', 'mozo', 6, 5),
(4, 'nicoll quintero hernandez', 'niki23', 'nikis23@gmail.com', '$2y$10$41u7QoRRLDAnBzwJSeQRiuV18GltBQxaLGq5S7xyb/D0lm0WyjHEC', 'bartender', 1, 1),
(5, 'nubia hernandez', 'nubis', 'rabiolis@gmail.com', '$2y$10$UEGHQq9k2EAVYEfIU7mHA.eRbxYiA08YDf8YBCMDwusGpzqdFaSxy', 'cocinero', 3, 2),
(6, 'daniel quintero', 'danis', 'danispa@gmail.com', '$2y$10$t7FeChro9Pbl3YkB4/C0FeSwPpt23S5e8JARRmf/XdYHa.G/hvFCG', 'cervecero', 2, 4),
(8, 'sebas rojas', 'rivera', 'rivera@gmail.com', '$2y$10$VCs0D3JaOcLWypaAljB3neM..Lhmn505AHNTiVZqPalFyUv28Y9aW', 'cocinero', 3, 4),
(9, 'chris', 'carrera', 'chris@gmail.com', '$2y$10$j/jyQbBkYPqKWWBBak1o2.JL4h5PFmWzzysAQSF/d36qLamj2hSle', 'bartender', 1, 2),
(10, 'diacu', 'radoeff', 'radoef@gmail.com', '$2y$10$Pd2neBrYmFmmzICNohR8zOG9lYCbhhBcGDSgZRsV0tVD2D68KsGDW', 'cervecero', 2, 4),
(11, 'steffa pelo', 'peloalex', 'steffi@gmail.com', '$2y$10$lBfQ5aW.GMPrLvBXdfZL9uK0Px6VYu.7NOfiGj6Ced6mGGQ1dhQHS', 'cocinero', 3, 3),
(12, 'camila parotti', 'parotti', 'camila@gmail.com', '$2y$10$dzMyDh8ITHBngiDKrpqspOx9P0NzlRs7Bl5J0bODlHMLlheCEvrnW', 'mozo', 6, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_mesa`
--

CREATE TABLE `estado_mesa` (
  `id` int(11) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_mesa`
--

INSERT INTO `estado_mesa` (`id`, `estado`) VALUES
(1, 'con cliente esperando pedido'),
(2, 'con clientes comiendo'),
(3, 'con clientes pagando'),
(4, 'cliente se retira'),
(5, 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedidos`
--

CREATE TABLE `estado_pedidos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `tiempo` time NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_pedidos`
--

INSERT INTO `estado_pedidos` (`id`, `id_pedido`, `tiempo`, `estado`) VALUES
(1, 4, '00:00:00', 'COBRADO'),
(2, 2, '00:00:00', 'COBRADO'),
(3, 3, '00:15:00', 'EN PREPARACION'),
(4, 1, '00:00:00', 'PAGADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(2) NOT NULL,
  `codigo` varchar(5) NOT NULL,
  `id_estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigo`, `id_estado`) VALUES
(1, '1707O', 4),
(2, '2205R', 2),
(3, '0911M', 4),
(4, '1804H', 5),
(5, '2702F', 5),
(6, '1708J', 5),
(7, '2812N', 5),
(8, '1909K', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_mesero` int(11) NOT NULL,
  `items` varchar(200) NOT NULL,
  `codigo_mesa` varchar(5) NOT NULL,
  `codigo_pedido` varchar(5) NOT NULL,
  `estado` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_cliente`, `id_mesero`, `items`, `codigo_mesa`, `codigo_pedido`, `estado`) VALUES
(1, 1, 12, 'fernet;papas;rubia', '1708J', '67d0f', 'PAGADO'),
(2, 1, 3, 'vino;hamburguesa', '1707O', 'aeaf2', 'COBRADO'),
(3, 2, 3, 'tiramisu;lingote', '2205R', '28385', 'EN PREPARACION'),
(4, 3, 12, 'negra;roja', '0911M', 'b16ae', 'COBRADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pendientes`
--

CREATE TABLE `pendientes` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pendientes`
--

INSERT INTO `pendientes` (`id`, `id_item`, `id_empleado`, `estado`) VALUES
(4, 1, 4, 'PENDIENTE'),
(8, 7, 10, 'PENDIENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `item` varchar(30) NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(3) NOT NULL,
  `sector` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `item`, `precio`, `cantidad`, `sector`) VALUES
(1, 'vino', 500, 13, 1),
(2, 'piña colada', 350, 5, 1),
(3, 'fernet', 220, 41, 1),
(4, 'mohito', 180, 20, 1),
(5, 'rubia', 100, 34, 2),
(6, 'roja', 100, 16, 2),
(7, 'negra', 100, 49, 2),
(8, 'hamburguesa', 420, 49, 3),
(9, 'pizza', 480, 43, 3),
(10, 'papas', 300, 27, 3),
(11, 'tacos', 320, 25, 3),
(12, 'tiramisu', 250, 9, 4),
(13, 'chesecake', 280, 8, 4),
(14, 'brownie', 200, 20, 4),
(15, 'lingote', 180, 7, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id` int(11) NOT NULL,
  `sector` varchar(50) NOT NULL,
  `tipo_empleado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`id`, `sector`, `tipo_empleado`) VALUES
(1, 'Barra de tragos y vinos', 'bartender'),
(2, 'barra chopera', 'cervecero'),
(3, 'Cocina', 'cocinero'),
(4, 'candy bar', 'cocinero'),
(5, 'administrador', 'socio'),
(6, 'salon', 'mozo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_mesa`
--
ALTER TABLE `estado_mesa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_pedidos`
--
ALTER TABLE `estado_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pendientes`
--
ALTER TABLE `pendientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comandas`
--
ALTER TABLE `comandas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `estado_mesa`
--
ALTER TABLE `estado_mesa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estado_pedidos`
--
ALTER TABLE `estado_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pendientes`
--
ALTER TABLE `pendientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
