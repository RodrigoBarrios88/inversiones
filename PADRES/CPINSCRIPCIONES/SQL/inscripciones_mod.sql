ALTER TABLE `app_padres` ADD `pad_tipo_dpi` VARCHAR(35) NOT NULL AFTER `pad_cui`;

ALTER TABLE `app_padres` ADD `pad_fec_nac ` DATE NOT NULL AFTER `pad_apellido`, ADD `pad_parentesco` VARCHAR(1) NOT NULL AFTER `pad_fec_nac `,
ADD `pad_estado_civil` VARCHAR(1) NOT NULL AFTER `pad_parentesco`, ADD `pad_nacionalidad` INT(100) NOT NULL AFTER `pad_estado_civil`;

ALTER TABLE `app_padres` CHANGE `pad_nacionalidad` `pad_nacionalidad` VARCHAR(150) NOT NULL;

ALTER TABLE `app_padres` ADD `pad_celular` VARCHAR(25) NOT NULL AFTER `pad_telefono`;

ALTER TABLE `app_padres`  ADD `pad_departamento` INT NOT NULL  AFTER `pad_direccion`,  ADD `pad_municipio` INT NOT NULL  AFTER `pad_departamento`;

ALTER TABLE `app_padres`  ADD `pad_telefono_trabajo` VARCHAR(10) NOT NULL  AFTER `pad_lugar_trabajo`,  ADD `pad_profesion` VARCHAR(150) NOT NULL  AFTER `pad_telefono_trabajo`;





CREATE TABLE `inscripcion_status` (
  `stat_contrato` int(11) NOT NULL,
  `stat_alumno` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `stat_dpi_firmante` bigint(20) NOT NULL,
  `stat_tipo_dpi` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `stat_nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `stat_apellido` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `stat_fec_nac` date NOT NULL,
  `stat_parentesco` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `stat_estado_civil` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `stat_nacionalidad` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `stat_mail` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `stat_telefono` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `stat_celular` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `stat_direccion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `stat_departamento` int(11) NOT NULL,
  `stat_municipio` int(11) NOT NULL,
  `stat_lugar_trabajo` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `stat_telefono_trabajo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `stat_profesion` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `stat_fechor_registro` datetime NOT NULL,
  `stat_situacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inscripcion_status`
--
ALTER TABLE `inscripcion_status`
  ADD PRIMARY KEY (`stat_contrato`);