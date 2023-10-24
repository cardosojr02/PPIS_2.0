-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-09-2023 a las 20:04:51
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `docentes_responsables` smallint(6) NOT NULL,
  `presupuesto_proyectado` decimal(10,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `id_subproceso_nivel2`, `nombre`, `descripcion`, `docentes_responsables`, `presupuesto_proyectado`, `fecha_inicio`, `fecha_fin`, `estado`, `fecha_sys`) VALUES
(3, 2, 'Compra Pcs', 'asd', 141, '56549448.00', '2023-09-02', '2023-09-09', 0, '2023-09-02 19:44:06'),
(4, 2, 'asd', 'asd', 147, '5555.00', '2023-09-01', '2023-09-09', 0, '2023-09-02 19:57:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE `periodos` (
  `id` smallint(6) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `periodos`
--

INSERT INTO `periodos` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`, `fecha_sys`) VALUES
(10, '2024AB', '2023-08-02', '2023-12-17', '2023-07-04 14:35:22'),
(12, '2025A', '2023-09-02', '2023-09-16', '2023-09-02 17:43:56'),
(13, '2027', '2023-09-02', '2023-09-09', '2023-09-02 17:44:13'),
(14, '2028AAA', '2023-09-02', '2023-09-09', '2023-09-02 17:45:43'),
(16, 'JUNIOR', '2023-09-02', '2023-09-09', '2023-09-02 17:48:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procesos`
--

CREATE TABLE `procesos` (
  `id` smallint(6) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `categoria` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `id_periodo` smallint(6) NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `procesos`
--

INSERT INTO `procesos` (`id`, `nombre`, `descripcion`, `categoria`, `id_periodo`, `fecha_sys`) VALUES
(24, 'ACREDITACION', 'Acreditacion', 'IMPORTANTE', 10, '2023-09-02 19:37:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(20) COLLATE utf8_spanish_ci NOT NULL
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
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `subprocesos`
--

INSERT INTO `subprocesos` (`id`, `id_proceso`, `nombre`, `descripcion`, `fecha_sys`) VALUES
(2, 24, 'Personal', 'asd', '2023-09-02 19:37:21'),
(3, 24, 'Personal', 'asd', '2023-09-02 19:43:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subprocesos_nivel2`
--

CREATE TABLE `subprocesos_nivel2` (
  `id` smallint(6) NOT NULL,
  `id_subproceso` smallint(6) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_sys` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `subprocesos_nivel2`
--

INSERT INTO `subprocesos_nivel2` (`id`, `id_subproceso`, `nombre`, `fecha_sys`) VALUES
(2, 2, 'Vigilancia', '2023-09-02 19:43:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` smallint(6) NOT NULL,
  `usuario` varchar(245) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(245) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `documento` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_usuario` int(2) NOT NULL,
  `fecha_sys` datetime NOT NULL,
  `cambio_pass` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `pass`, `nombre`, `apellido`, `email`, `documento`, `telefono`, `tipo_usuario`, `fecha_sys`, `cambio_pass`) VALUES
(141, 'admin', '$2y$10$ccm8pw1KVMKPuVovo2SSweSMYTRFCm4fvvx5Xf.j6NGdwVF5E353G', 'Arley', 'Cardoso', 'cardosojr2002@gmail.com', '1006126548', '3152807418', 1, '2023-05-16 20:50:51', 0),
(144, 'leo', '$2y$10$EjYToBVTNIaYChn8QNDXgeDB.QeZypCYiXqt495XYsa3DlRhkIadm', 'Leo', 'Casas', 'leocasas@leo.co', 'leocasas@l', 'leocasas@l', 2, '2023-05-23 23:49:32', 0),
(145, 'lu', '$2y$10$DZdjPh6SYQc6OQPCDFGvQeUrswnaFk.d7wMmlA.qCDQ97bP45qHRe', 'Lu', 'Yung', 'luy@luy.co', '54487587', '32255486', 2, '2023-05-23 23:52:53', 0),
(146, 'MBarrios Diaz48', '$2y$10$7wejTeof2tHTXmJZBO/Oh.s5ah9Z..5C63C22tTPkS2phPrc1s1jG', 'Mariana', 'Barrios Diaz', 'barriosdm2@gmail.com', '1006126548', '3152807418', 2, '2023-06-09 01:16:36', 0),
(147, 'CCardoso Cabezas20', '$2y$10$0PzD.jsx6WKsgZsADkDeGuZmHLGo6p2pVVGSr10bkl/MAT3rO.Ria', 'Carlos Mario', 'Cardoso Cabezas', 'diazguerra2@gmail.com', '1001515202', '3505778899', 2, '2023-06-09 01:25:32', 0),
(148, 'JTorres Perez99', '$2y$10$LAnq6nc3QeGWZlCIXgCTzukrdV8F/oOJYajKiIupkYjtMgN9Sf2Pe', 'Juliana', 'Torres Perez', 'sandra.bermudez01@hotmail.com', '999999999', '314447788', 2, '2023-06-09 01:42:01', 0),
(149, 'etorres24', '$2y$10$SNybC/IYxWyfEgJuYCmrCO9XWI/XpSvtaP/fmfUtRHDLTgR6QhQtO', 'Erick', 'Torres', 'erick@erixk.com', '93121224', '3118336963', 2, '2023-07-04 10:32:41', 0),
(150, 'ncano24', '$2y$10$/wLgADG3oNFxjkxpDo1.tuoQBh4UFPqp/xJHW2RASmXCqs0gZyy.K', 'Natanael', 'Cano', 'nategentilex1@gmail.com', '93121224', '3118336963', 2, '2023-07-04 10:33:17', 0),
(151, 'flleras97', '$2y$10$P1Y1YKpNvHDo9uAHp0LF3OMvlfVK1AUO65jvCmw7EsHzLFz1TBa6.', 'Federico', 'Lleras', 'fede@lleras.co', '1005772697', '3118336963', 2, '2023-07-04 10:36:44', 0),
(152, 'pperez97', '$2y$10$hNbVEoZetvhrG/lYiig3e.RO5OWN/ZpPj/QaicWO772DUfyc5Tp9W', 'Pepo', 'Perez', 'Pepo@itfip.edu.co', '1005772697', '3118336963', 2, '2023-09-02 15:06:15', 0),
(153, 'aasd23', '$2y$10$2wAd3v5cTuHTrdJ/d7wiXu9iBi71LZu8yOD9IL2.hfhpXfI6cnLWa', 'asd', 'asd', 'asd@gmail.com', '123', '123', 2, '2023-09-04 13:32:19', 0);

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
  ADD KEY `tipo_usuario` (`tipo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `procesos`
--
ALTER TABLE `procesos`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `subprocesos`
--
ALTER TABLE `subprocesos`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `subprocesos_nivel2`
--
ALTER TABLE `subprocesos_nivel2`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

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
