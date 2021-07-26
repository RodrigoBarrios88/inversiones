-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 31-07-2017 a las 06:27:33
-- Versión del servidor: 5.6.28
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `asms`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_alumnos`
--

CREATE TABLE `inscripcion_alumnos` (
  `alu_cui_new` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `alu_cui_old` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `alu_tipo_cui` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `alu_codigo_interno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `alu_nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `alu_apellido` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `alu_fecha_nacimiento` date NOT NULL,
  `alu_genero` varchar(1) COLLATE utf8_spanish_ci NOT NULL COMMENT 'M-> MASCULINO, F->FEMENINO',
  `alu_tipo_sangre` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `alu_alergico_a` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `alu_emergencia` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `alu_emergencia_telefono` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `alu_cliente_factura` bigint(20) NOT NULL COMMENT 'Cliente enlazado para facturación',
  `alu_fec_registro` date NOT NULL,
  `alu_fecha_edit` datetime NOT NULL,
  `alu_usuario_edit` bigint(20) NOT NULL,
  `alu_situacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_boleta_cobro`
--

CREATE TABLE `inscripcion_boleta_cobro` (
  `bol_codigo` bigint(20) NOT NULL COMMENT 'Codigo de boleta',
  `bol_cuenta` int(11) NOT NULL COMMENT 'Codigo de Cuenta',
  `bol_banco` int(11) NOT NULL COMMENT 'Codigo de Banco',
  `bol_alumno` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Codigo de Alumno',
  `bol_codigo_interno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `bol_referencia` varchar(15) COLLATE utf8_spanish_ci NOT NULL COMMENT 'No. de Documento o de Boleta de Pago ',
  `bol_monto` decimal(10,2) NOT NULL COMMENT 'Monto a Pagar',
  `bol_descuento` decimal(10,2) NOT NULL,
  `bol_motivo_descuento` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `bol_motivo` varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Motivo del Pago',
  `bol_fecha_registro` datetime NOT NULL COMMENT 'Fecha que se emite la boleta',
  `bol_fecha_pago` date NOT NULL COMMENT 'Fecha en la que se debe pagar',
  `bol_usuario` bigint(20) NOT NULL,
  `bol_situacion` int(11) NOT NULL COMMENT 'Activa->1 o Anulada->0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Boleta de Cobro para mensualidades o colegiaturas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_comentarios`
--

CREATE TABLE `inscripcion_comentarios` (
  `comen_codigo` int(11) NOT NULL,
  `comen_contrato` int(11) NOT NULL,
  `comen_alumno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `comen_comentario` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `comen_usuario_registro` bigint(20) NOT NULL,
  `comen_fechor_registro` datetime NOT NULL,
  `comen_situacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_grado`
--

CREATE TABLE `inscripcion_grado` (
  `gra_nivel` int(11) NOT NULL,
  `gra_codigo` int(11) NOT NULL,
  `gra_descripcion` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `gra_situacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `inscripcion_grado`
--

INSERT INTO `inscripcion_grado` (`gra_nivel`, `gra_codigo`, `gra_descripcion`, `gra_situacion`) VALUES
(1, 1, 'MATERNAL', 1),
(1, 2, 'PREKINDER', 1),
(1, 3, 'KINDER', 1),
(1, 4, 'PREPARATORIA', 1),
(2, 1, 'PRIMERO', 1),
(2, 2, 'SEGUNDO', 1),
(2, 3, 'TERCERO', 1),
(2, 4, 'CUARTO', 1),
(2, 5, 'QUINTO', 1),
(2, 6, 'SEXTO', 1),
(3, 1, 'PRIMERO BASICO', 1),
(3, 2, 'SEGUNDO BASICO', 1),
(3, 3, 'TERCERO BASICO', 1),
(4, 1, 'CUARTO BACHILLERATO', 1),
(4, 2, 'QUINTO BACHILLERATO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_grado_alumno`
--

CREATE TABLE `inscripcion_grado_alumno` (
  `graa_nivel` int(11) NOT NULL,
  `graa_grado` int(11) NOT NULL,
  `graa_alumno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `graa_situacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_nivel`
--

CREATE TABLE `inscripcion_nivel` (
  `niv_codigo` int(11) NOT NULL,
  `niv_descripcion` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `niv_situacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `inscripcion_nivel`
--

INSERT INTO `inscripcion_nivel` (`niv_codigo`, `niv_descripcion`, `niv_situacion`) VALUES
(1, 'PREESCOLAR', 1),
(2, 'PRIMARIA', 1),
(3, 'SECUNDARIA', 1),
(4, 'DIVERSIFICADO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_padre_alumno`
--

CREATE TABLE `inscripcion_padre_alumno` (
  `pa_padre` bigint(20) NOT NULL,
  `pa_alumno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `pa_fec_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_pago_boleta_cobro`
--

CREATE TABLE `inscripcion_pago_boleta_cobro` (
  `pag_codigo` bigint(20) NOT NULL,
  `pag_alumno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `pag_codigo_interno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `pag_referencia` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `pag_cuenta` int(11) NOT NULL,
  `pag_banco` int(11) NOT NULL,
  `pag_carga` bigint(20) NOT NULL,
  `pag_transaccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `pag_efectivo` decimal(10,2) NOT NULL,
  `pag_cheques_propios` decimal(10,2) NOT NULL,
  `pag_otros_bancos` decimal(10,2) NOT NULL,
  `pag_online` decimal(10,2) NOT NULL,
  `pag_fechor` datetime NOT NULL,
  `pag_usuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_seguro`
--

CREATE TABLE `inscripcion_seguro` (
  `seg_alumno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `seg_tiene_seguro` int(11) NOT NULL DEFAULT '0',
  `seg_poliza` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `seg_aseguradora` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `seg_plan` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `seg_asegurado_principal` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `seg_instrucciones` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `seg_comentarios` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion_status`
--

CREATE TABLE `inscripcion_status` (
  `stat_contrato` int(11) NOT NULL,
  `stat_alumno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `stat_dpi_firmante` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `stat_nombre_firmante` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `stat_direccion_firmante` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `stat_telefono_firmante` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `stat_fechor_registro` datetime NOT NULL,
  `stat_situacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inscripcion_alumnos`
--
ALTER TABLE `inscripcion_alumnos`
  ADD PRIMARY KEY (`alu_cui_new`),
  ADD KEY `alu_cliente_factura` (`alu_cliente_factura`);

--
-- Indices de la tabla `inscripcion_boleta_cobro`
--
ALTER TABLE `inscripcion_boleta_cobro`
  ADD PRIMARY KEY (`bol_codigo`),
  ADD KEY `bol_alumno` (`bol_alumno`),
  ADD KEY `bol_cuenta` (`bol_cuenta`,`bol_banco`);

--
-- Indices de la tabla `inscripcion_comentarios`
--
ALTER TABLE `inscripcion_comentarios`
  ADD PRIMARY KEY (`comen_codigo`,`comen_contrato`,`comen_alumno`);

--
-- Indices de la tabla `inscripcion_grado`
--
ALTER TABLE `inscripcion_grado`
  ADD PRIMARY KEY (`gra_nivel`,`gra_codigo`);

--
-- Indices de la tabla `inscripcion_grado_alumno`
--
ALTER TABLE `inscripcion_grado_alumno`
  ADD PRIMARY KEY (`graa_nivel`,`graa_grado`,`graa_alumno`),
  ADD KEY `graa_alumno` (`graa_alumno`);

--
-- Indices de la tabla `inscripcion_nivel`
--
ALTER TABLE `inscripcion_nivel`
  ADD PRIMARY KEY (`niv_codigo`);

--
-- Indices de la tabla `inscripcion_padre_alumno`
--
ALTER TABLE `inscripcion_padre_alumno`
  ADD PRIMARY KEY (`pa_padre`,`pa_alumno`),
  ADD KEY `pa_alumno` (`pa_alumno`);

--
-- Indices de la tabla `inscripcion_pago_boleta_cobro`
--
ALTER TABLE `inscripcion_pago_boleta_cobro`
  ADD PRIMARY KEY (`pag_codigo`),
  ADD KEY `pag_referencia` (`pag_referencia`),
  ADD KEY `pag_cuenta` (`pag_cuenta`,`pag_banco`),
  ADD KEY `pag_referencia_2` (`pag_referencia`),
  ADD KEY `pag_alumno` (`pag_alumno`);

--
-- Indices de la tabla `inscripcion_seguro`
--
ALTER TABLE `inscripcion_seguro`
  ADD PRIMARY KEY (`seg_alumno`);

--
-- Indices de la tabla `inscripcion_status`
--
ALTER TABLE `inscripcion_status`
  ADD PRIMARY KEY (`stat_contrato`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inscripcion_pago_boleta_cobro`
--
ALTER TABLE `inscripcion_pago_boleta_cobro`
  MODIFY `pag_codigo` bigint(20) NOT NULL AUTO_INCREMENT;