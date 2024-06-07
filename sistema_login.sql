-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2024 a las 20:20:59
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
-- Base de datos: `sistema_login`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_contencion`
--

CREATE TABLE `acciones_contencion` (
  `id` int(11) NOT NULL,
  `reporte_id` int(11) NOT NULL,
  `accion` text NOT NULL,
  `fecha` date NOT NULL,
  `responsable` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acciones_plan`
--

CREATE TABLE `acciones_plan` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `accion` text NOT NULL,
  `fecha` date NOT NULL,
  `responsable` varchar(255) NOT NULL,
  `evidencia` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_accion`
--

CREATE TABLE `planes_accion` (
  `id` int(11) NOT NULL,
  `reporte_id` int(11) NOT NULL,
  `cambios_sistema` text NOT NULL,
  `riesgos_oportunidades` text DEFAULT NULL,
  `eficacia_acciones` text DEFAULT NULL,
  `cierre_ac` varchar(255) DEFAULT NULL,
  `firma_fecha` date DEFAULT NULL,
  `objetivos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `origen` varchar(255) NOT NULL,
  `otro_origen` varchar(255) DEFAULT NULL,
  `solicita` varchar(255) NOT NULL,
  `puesto_solicita` varchar(255) NOT NULL,
  `responsable` varchar(255) NOT NULL,
  `puesto_responsable` varchar(255) NOT NULL,
  `verificador` varchar(255) NOT NULL,
  `puesto_verificador` varchar(255) NOT NULL,
  `descripcion_problema` text NOT NULL,
  `requiere_analisis` enum('Si','No') NOT NULL,
  `causa_raiz` text DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `contrasena`, `rol`) VALUES
(1, 'shani', 'bautista', 'perla.shani24@gmail.com', '$2y$10$LFQwd1ftYgo7c0uyAPO9gukrePgYj9smA7b3a3FBhGzTIejrnYaz6', 'usuario'),
(3, 'perla', 'hernandez', 'shanibautista@hotmail.com', '$2y$10$yDt75j.tkVUSTzbw8SIiCeDhjX68DET79GXcVOknAWHM6oTeyB1L2', 'usuario'),
(8, 'hjv', 'vhj,', 'ghck@hotmail.com', '$2y$10$Q4weNtew0FI9n6E.wTFBceqZQVR3oTssJFXmMxTm5upF2rl6.FBmW', 'usuario'),
(9, 'daegwr', 'gwegwe', 'weg@hotmail.com', '$2y$10$GCJCGdTAdgHG/zAmYJ4wD.58yM43FQ82lUBZxPfSNZP9DY1FUiHeG', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones_contencion`
--
ALTER TABLE `acciones_contencion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reporte_id` (`reporte_id`);

--
-- Indices de la tabla `acciones_plan`
--
ALTER TABLE `acciones_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indices de la tabla `planes_accion`
--
ALTER TABLE `planes_accion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reporte_id` (`reporte_id`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones_contencion`
--
ALTER TABLE `acciones_contencion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `acciones_plan`
--
ALTER TABLE `acciones_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planes_accion`
--
ALTER TABLE `planes_accion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acciones_contencion`
--
ALTER TABLE `acciones_contencion`
  ADD CONSTRAINT `acciones_contencion_ibfk_1` FOREIGN KEY (`reporte_id`) REFERENCES `reportes` (`id`);

--
-- Filtros para la tabla `acciones_plan`
--
ALTER TABLE `acciones_plan`
  ADD CONSTRAINT `acciones_plan_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `planes_accion` (`id`);

--
-- Filtros para la tabla `planes_accion`
--
ALTER TABLE `planes_accion`
  ADD CONSTRAINT `planes_accion_ibfk_1` FOREIGN KEY (`reporte_id`) REFERENCES `reportes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
