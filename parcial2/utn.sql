-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2020 a las 00:24:44
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
-- Base de datos: `utn`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcions`
--

CREATE TABLE `inscripcions` (
  `id` int(3) NOT NULL,
  `id_alumno` int(3) NOT NULL,
  `id_materia` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inscripcions`
--

INSERT INTO `inscripcions` (`id`, `id_alumno`, `id_materia`) VALUES
(1, 5, 4),
(2, 6, 4),
(3, 7, 4),
(4, 7, 1),
(5, 7, 2),
(6, 7, 3),
(7, 7, 1),
(8, 7, 2),
(9, 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `cuatrimestre` int(11) NOT NULL,
  `cupos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `nombre`, `cuatrimestre`, `cupos`) VALUES
(1, 'P3', 3, 18),
(2, 'Lab3', 3, 22),
(3, 'matematicas', 1, 29),
(4, 'sistemas operativos', 2, 12),
(5, 'sistemas operativos', 2, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id` int(3) NOT NULL,
  `id_profesor` int(3) NOT NULL,
  `id_alumno` int(3) NOT NULL,
  `id_materia` int(3) NOT NULL,
  `nota` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id`, `id_profesor`, `id_alumno`, `id_materia`, `nota`) VALUES
(1, 4, 2, 4, 9),
(2, 8, 2, 4, 9),
(3, 8, 6, 1, 7),
(4, 8, 6, 1, 7),
(5, 8, 3, 1, 8),
(6, 8, 5, 3, 10),
(7, 8, 5, 3, 11),
(8, 8, 5, 3, 1),
(9, 8, 5, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `clave` varchar(300) NOT NULL,
  `tipo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `email`, `clave`, `tipo`) VALUES
(1, 'pepe', 'pepe@mail.com', '$2y$10$Mtgmpo6t7yA9nd4M22srLeKhStDT/B2jRs1AXaOG2L7uELxLvsq.m', 'alumno'),
(2, 'mishaker', 'mishaker22@mail.com', '$2y$10$k7s4.Z1qDrXwI86D2puHbuqi44rJd8aMbozZCkKJRIz9oLbdkTLTu', 'admin'),
(3, 'andrea', 'andrecilla@mail.com', '$2y$10$K/o740etTvY59exgPDvaW.YYIn4e01D7wFVtm3L4rc.akp3hLvpQa', 'profesor'),
(4, 'nubis', 'admin@mail.com', '$2y$10$VOE6VNW9TI05xCvhBKuy9Owe1vg/Glp91tWhy8x8.CsAwOLpGWJBa', 'profesor'),
(5, 'danis', 'danispa@mail.com', '$2y$10$wawMVl2epw3qPp.cpjjwieJXYphsR72fldQxiSublewxzcua92/mS', 'alumno'),
(6, 'mateo', 'mateo@mail.com', '$2y$10$H2HFKHYuJi7G06DKh8yMpOFHVak3U.DKyUZj2Mlf53JyLtmV/tGkS', 'alumno'),
(7, 'rasricardo', 'ras18@mail.com', '$2y$10$auJrVFtKqAeY6mHPPzXAue975sw8iQkqLtmkwpxo53qU9sq6oxRTG', 'alumno'),
(8, 'lucas', 'lucas21@mail.com', '$2y$10$WzyA1O44qflPDPoA2J7zjePAShGLSpAWS2WUVGRENxWEVOA9Zm67O', 'profesor'),
(9, 'lucas10', 'lucas421@mail.com', '$2y$10$q0FcU1wdl3khJ8/fLFLQYeyLGnbE7fYYljPAFQBpWdC1AZn6ab/Lu', 'profesor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inscripcions`
--
ALTER TABLE `inscripcions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inscripcions`
--
ALTER TABLE `inscripcions`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
