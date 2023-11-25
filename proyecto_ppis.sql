-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2023 a las 16:35:52
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_ppis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` smallint(6) NOT NULL,
  `id_subproceso_nivel2` smallint(6) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `observaciones` text NOT NULL,
  `docentes_responsables` smallint(6) NOT NULL,
  `presupuesto_proyectado` decimal(10,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `progreso` varchar(30) NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `id_subproceso_nivel2`, `nombre`, `descripcion`, `observaciones`, `docentes_responsables`, `presupuesto_proyectado`, `fecha_inicio`, `fecha_fin`, `estado`, `progreso`, `fecha_sys`) VALUES
(9, 16, 'ACREDITACIÓN MATEMATICAS', 'asd', '', 147, 0.00, '2023-11-14', '2023-11-15', 1, 'Pendiente', '2023-11-14 16:26:02'),
(10, 15, 'ACREDITACIÓN 2.0', 'Acreditacion 2.0', '', 147, 0.00, '2023-12-15', '2024-01-17', 1, 'En Progreso', '2023-11-14 16:35:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_usuarios`
--

CREATE TABLE `actividades_usuarios` (
  `id` smallint(6) NOT NULL,
  `id_actividad` smallint(6) NOT NULL,
  `id_usuario` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avances`
--

CREATE TABLE `avances` (
  `id` smallint(6) NOT NULL,
  `id_actividades_usuarios` smallint(6) NOT NULL,
  `nombre_avance` varchar(50) NOT NULL,
  `texto_avance` text NOT NULL,
  `archivo_avance` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `avances`
--

INSERT INTO `avances` (`id`, `id_actividades_usuarios`, `nombre_avance`, `texto_avance`, `archivo_avance`, `fecha_registro`) VALUES
(13, 9, 'asd', 'asd', 'archivos_avances/index.php', '2023-11-14 22:28:11'),
(14, 9, 'xxxxxxx', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'archivos_avances/pendientes proy.txt', '2023-11-14 22:28:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE `periodos` (
  `id` smallint(6) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `periodos`
--

INSERT INTO `periodos` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`, `fecha_sys`, `estado`) VALUES
(27, '2023B', '2023-01-01', '2023-12-31', '2023-11-10 01:01:56', 1),
(28, '2024A', '2023-11-10', '2023-11-11', '2023-11-10 23:47:11', 1),
(29, '2025A', '2023-11-12', '2023-11-20', '2023-11-10 23:28:33', 0),
(30, '2026', '2023-11-22', '2023-11-23', '2023-11-14 15:25:31', 1),
(31, '2030', '2023-11-13', '2023-11-13', '2023-11-14 16:32:48', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos`
--

CREATE TABLE `procesos` (
  `id` smallint(6) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `id_periodo` smallint(6) NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `procesos`
--

INSERT INTO `procesos` (`id`, `nombre`, `descripcion`, `categoria`, `id_periodo`, `fecha_sys`, `estado`) VALUES
(27, 'Compras pendientes', 'Realizar todas las compras pendientes', 'Importante', 27, '2023-11-14 15:32:37', 1),
(28, 'ACREDITACION', 'Acreditación del programa de Ingeniería de Sistemas.', 'Baja urgencia', 27, '2023-11-14 15:33:12', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Docente'),
(3, 'Auditor'),
(4, 'Decano'),
(5, 'Coordinador'),
(6, 'Asistente'),
(7, 'SuperUsuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subprocesos`
--

CREATE TABLE `subprocesos` (
  `id` smallint(6) NOT NULL,
  `id_proceso` smallint(6) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `subprocesos`
--

INSERT INTO `subprocesos` (`id`, `id_proceso`, `nombre`, `descripcion`, `fecha_sys`, `estado`) VALUES
(8, 27, 'Compras Tecnologia', 'comprar todo lo relacionado con tecnologia', '2023-11-10 23:52:24', 0),
(9, 28, 'Paso 1: Ambiente Laboral', 'Verificación de contratación de docentesssss', '2023-11-14 16:33:21', 1),
(10, 28, 'Paso 2: Relación con empresas', 'Contactos con empresas.', '2023-11-09 02:43:27', 1),
(11, 28, 'Paso 3: Egresados', 'Contactos con egresados.', '2023-11-09 02:44:01', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subprocesos_nivel2`
--

CREATE TABLE `subprocesos_nivel2` (
  `id` smallint(6) NOT NULL,
  `id_subproceso` smallint(6) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `subprocesos_nivel2`
--

INSERT INTO `subprocesos_nivel2` (`id`, `id_subproceso`, `nombre`, `fecha_sys`, `estado`) VALUES
(14, 8, 'Compras sala 2', '2023-11-03 23:00:11', 0),
(15, 11, 'Encuesta principal de percepción.', '2023-11-10 23:54:18', 1),
(16, 11, 'Encuesta Final', '2023-11-09 02:46:33', 1),
(17, 10, 'Realizar convenios', '2023-11-10 23:54:36', 0),
(18, 10, 'Realizar pasantias', '2023-11-10 23:54:32', 0),
(19, 9, 'Matriz de dedicación laboral', '2023-11-10 23:54:29', 0),
(20, 11, 'Contacto directo', '2023-11-10 23:54:25', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` smallint(6) NOT NULL,
  `usuario` varchar(245) NOT NULL,
  `pass` varchar(245) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `documento` varchar(10) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `tipo_usuario` int(2) NOT NULL,
  `fecha_sys` datetime NOT NULL,
  `cambio_pass` tinyint(1) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `pass`, `nombre`, `apellido`, `email`, `documento`, `telefono`, `tipo_usuario`, `fecha_sys`, `cambio_pass`, `estado`) VALUES
(141, 'cardosojr2002@gmail.com', '$2y$10$ccm8pw1KVMKPuVovo2SSweSMYTRFCm4fvvx5Xf.j6NGdwVF5E353G', 'Arley', 'Cardoso', 'cardosojr2002@gmail.com', '1006126548', '3152807418', 7, '2023-05-16 20:50:51', 0, 1),
(147, 'diazguerra2@gmail.com', '$2y$10$lz30oUGyZ9OXchQdFrw1Iue0EZlr0UCz3qg.TOS/kJ14z2hENdNam', 'Carlos Mario', 'cabezas', 'diazguerra2@gmail.com', '1001515202', '3505778899', 5, '2023-06-09 01:25:32', 0, 1),
(160, 'jhair@saez.com', '$2y$10$lmvLTSWytizG/F.x3XrR6.NuIN9mpNMMoiQEFxd3leq.VYlmsBRQO', 'Jhair ', 'Saez', 'jhair@saez.com', '1155447775', '3115544555', 6, '2023-10-28 15:14:30', 0, 1),
(180, 'barriosdm2@gmail.com', '$2y$10$AiJR7LFVhjhruQVsFKnAAetjZRKZjaM0B3qsxy5aUSHk2Ns0urVpO', 'Mariana', 'Barrios Diaz', 'barriosdm2@gmail.com', '1005772697', '3152807418', 2, '2023-10-29 12:05:02', 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_subproceso_nivel2` (`id_subproceso_nivel2`),
  ADD KEY `docentes_responsables` (`docentes_responsables`);

--
-- Indices de la tabla `actividades_usuarios`
--
ALTER TABLE `actividades_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_actividad` (`id_actividad`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `avances`
--
ALTER TABLE `avances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_actividad` (`id_actividades_usuarios`);

--
-- Indices de la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `procesos`
--
ALTER TABLE `procesos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periodo` (`id_periodo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subprocesos`
--
ALTER TABLE `subprocesos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proceso` (`id_proceso`) USING BTREE;

--
-- Indices de la tabla `subprocesos_nivel2`
--
ALTER TABLE `subprocesos_nivel2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_subproceso` (`id_subproceso`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `tipo_usuario` (`tipo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `actividades_usuarios`
--
ALTER TABLE `actividades_usuarios`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `avances`
--
ALTER TABLE `avances`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `procesos`
--
ALTER TABLE `procesos`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `subprocesos`
--
ALTER TABLE `subprocesos`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `subprocesos_nivel2`
--
ALTER TABLE `subprocesos_nivel2`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_subproceso_nivel2`) REFERENCES `subprocesos_nivel2` (`id`),
  ADD CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`docentes_responsables`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `actividades_usuarios`
--
ALTER TABLE `actividades_usuarios`
  ADD CONSTRAINT `actividades_usuarios_ibfk_5` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `actividades_usuarios_ibfk_6` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id`);

--
-- Filtros para la tabla `procesos`
--
ALTER TABLE `procesos`
  ADD CONSTRAINT `procesos_ibfk_1` FOREIGN KEY (`id_periodo`) REFERENCES `periodos` (`id`);

--
-- Filtros para la tabla `subprocesos`
--
ALTER TABLE `subprocesos`
  ADD CONSTRAINT `subprocesos_ibfk_1` FOREIGN KEY (`id_proceso`) REFERENCES `procesos` (`id`);

--
-- Filtros para la tabla `subprocesos_nivel2`
--
ALTER TABLE `subprocesos_nivel2`
  ADD CONSTRAINT `subprocesos_nivel2_ibfk_1` FOREIGN KEY (`id_subproceso`) REFERENCES `subprocesos` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_usuario`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
