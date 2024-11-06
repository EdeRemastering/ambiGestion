-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2024 a las 05:26:29
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
-- Base de datos: `sgpac2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambientes`
--

CREATE TABLE `ambientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `numero` int(11) NOT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `descripcion` varchar(100) NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `red_conocimiento_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ambientes`
--

INSERT INTO `ambientes` (`id`, `numero`, `alias`, `capacidad`, `descripcion`, `tipo_id`, `estado_id`, `red_conocimiento_id`, `created_at`, `updated_at`) VALUES
(93243, 18, 'DESARROLLO', 30, 'computadoras 30', 4, 9, 3, '2024-10-22 06:18:41', '2024-10-22 06:18:41'),
(93244, 17, 'Redes', 35, 'redes de conexion cableadas (fibra optica, utp), y conexiones inhalambricas', 4, 10, 3, '2024-10-22 17:20:15', '2024-10-22 17:20:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambiente_programacions`
--

CREATE TABLE `ambiente_programacions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ambiente_id` bigint(20) UNSIGNED NOT NULL,
  `ficha_id` bigint(20) UNSIGNED NOT NULL,
  `jornada_id` bigint(20) UNSIGNED NOT NULL,
  `competencia_id` bigint(20) UNSIGNED NOT NULL,
  `resultado_aprendizaje_id` bigint(20) UNSIGNED NOT NULL,
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `horas_asignadas` int(11) DEFAULT 6,
  `estado` enum('programado','en_curso','completado') NOT NULL DEFAULT 'programado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ambiente_programacions`
--

INSERT INTO `ambiente_programacions` (`id`, `ambiente_id`, `ficha_id`, `jornada_id`, `competencia_id`, `resultado_aprendizaje_id`, `persona_id`, `fecha`, `hora_inicio`, `hora_fin`, `horas_asignadas`, `estado`, `created_at`, `updated_at`) VALUES
(524722, 93243, 5, 2, 5, 12, 23, '2024-10-28', '13:00:00', '19:00:00', 6, 'programado', '2024-11-02 21:04:36', '2024-11-02 21:04:36'),
(524723, 93243, 5, 2, 5, 13, 17, '2024-10-29', '13:00:00', '19:00:00', 6, 'programado', '2024-11-02 23:46:12', '2024-11-02 23:46:12'),
(524724, 93243, 6, 1, 5, 15, 17, '2024-10-30', '07:00:00', '13:00:00', 6, 'programado', '2024-11-03 00:42:32', '2024-11-03 00:42:32'),
(524727, 93244, 7, 3, 5, 14, 17, '2024-11-05', '19:00:00', '22:00:00', 6, 'programado', '2024-11-05 18:30:40', '2024-11-05 18:30:40'),
(524728, 93244, 6, 2, 5, 14, 23, '2024-11-05', '13:00:00', '19:00:00', 6, 'programado', '2024-11-05 19:28:29', '2024-11-05 19:28:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cedulas_autorizadas`
--

CREATE TABLE `cedulas_autorizadas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `documento` varchar(255) NOT NULL,
  `tipo` enum('instructor','aprendiz') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cedulas_autorizadas`
--

INSERT INTO `cedulas_autorizadas` (`id`, `documento`, `tipo`, `created_at`, `updated_at`) VALUES
(1, '1038805081', 'aprendiz', '2024-11-01 20:28:37', '2024-11-01 20:28:37'),
(2, '1032178212', 'aprendiz', '2024-11-02 00:30:44', '2024-11-02 00:30:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competencias`
--

CREATE TABLE `competencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `duracion_horas` int(11) DEFAULT NULL,
  `programa_formacion_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `competencias`
--

INSERT INTO `competencias` (`id`, `codigo`, `descripcion`, `duracion_horas`, `programa_formacion_id`, `created_at`, `updated_at`) VALUES
(5, '574', 'entorno de desarrollo HTML, CSS Y JS BASICOS', 200, 5, '2024-10-23 08:58:58', '2024-10-23 08:58:58'),
(6, '5744', 'entorno de creacion HTML, CSS Y JS', 200, 5, '2024-10-23 09:05:33', '2024-10-23 09:05:33'),
(7, '21554', 'APRENDER LAS RAZONES POR LA CUAL SE HACEN ESTOS PROGRAMAS', 50, 6, '2024-10-29 22:47:28', '2024-10-29 22:47:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competencia_instructor`
--

CREATE TABLE `competencia_instructor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `competencia_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `horas_asignadas` int(11) NOT NULL,
  `estado` enum('activo','finalizado','cancelado') NOT NULL DEFAULT 'activo',
  `horario` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`horario`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `competencia_instructor`
--

INSERT INTO `competencia_instructor` (`id`, `competencia_id`, `instructor_id`, `fecha_inicio`, `fecha_fin`, `horas_asignadas`, `estado`, `horario`, `created_at`, `updated_at`) VALUES
(1, 5, 23, '2024-10-28', '2024-11-25', 200, 'activo', '[{\"dia\":\"lunes\",\"hora_inicio\":\"13:00\",\"hora_fin\":\"19:00\"}]', '2024-10-28 06:38:17', '2024-10-28 06:38:17'),
(2, 6, 17, '2024-10-01', '2024-11-25', 200, 'activo', '[{\"dia\":\"martes\",\"hora_inicio\":\"13:00\",\"hora_fin\":\"19:00\"}]', '2024-10-28 07:16:44', '2024-10-28 07:16:44'),
(3, 7, 23, '2024-10-29', '2025-02-01', 50, 'activo', '[{\"dia\":\"miercoles\",\"hora_inicio\":\"13:00\",\"hora_fin\":\"19:00\"}]', '2024-10-29 22:48:46', '2024-10-29 22:48:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `descripcion`) VALUES
(1, 'Vinculado'),
(2, 'Contratista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_ambiente`
--

CREATE TABLE `estado_ambiente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_ambiente`
--

INSERT INTO `estado_ambiente` (`id`, `nombre`) VALUES
(9, 'DISPONIBLE'),
(10, 'OCUPADO'),
(11, 'NOVEDAD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_novedad`
--

CREATE TABLE `estado_novedad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_novedad`
--

INSERT INTO `estado_novedad` (`id`, `nombre`) VALUES
(1, 'pendiente'),
(2, 'solucionado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_recurso`
--

CREATE TABLE `estado_recurso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_recurso`
--

INSERT INTO `estado_recurso` (`id`, `nombre`) VALUES
(1, 'disponible'),
(2, 'mantenimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo_ficha` varchar(255) NOT NULL,
  `instructor_lider` bigint(20) UNSIGNED NOT NULL,
  `numero_aprendices` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_fin_lectiva` date NOT NULL,
  `fecha_inicio_practica` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `programa_formacion_id` bigint(20) UNSIGNED NOT NULL,
  `red_conocimiento_id` bigint(20) UNSIGNED NOT NULL,
  `jornada_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`id`, `codigo_ficha`, `instructor_lider`, `numero_aprendices`, `fecha_inicio`, `fecha_fin`, `fecha_fin_lectiva`, `fecha_inicio_practica`, `hora_entrada`, `hora_salida`, `programa_formacion_id`, `red_conocimiento_id`, `jornada_id`, `created_at`, `updated_at`) VALUES
(5, '2673033', 23, 27, '2023-01-23', '2025-04-23', '2024-10-23', '2024-10-24', '13:00:00', '19:00:00', 5, 3, 2, '2024-11-02 05:07:08', '2024-11-02 05:07:08'),
(6, '2673007', 17, 27, '2024-11-02', '2027-02-02', '2026-08-02', '2026-08-03', '07:00:00', '13:00:00', 5, 3, 1, '2024-11-03 00:37:54', '2024-11-03 00:37:54'),
(7, '2457890', 17, 15, '2024-11-03', '2026-11-03', '2026-05-03', '2026-05-04', '19:00:00', '22:00:00', 6, 3, 3, '2024-11-03 15:40:38', '2024-11-03 15:40:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_sanguineos`
--

CREATE TABLE `grupo_sanguineos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grupo_sanguineos`
--

INSERT INTO `grupo_sanguineos` (`id`, `descripcion`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructor_red_conocimiento`
--

CREATE TABLE `instructor_red_conocimiento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `red_conocimiento_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `instructor_red_conocimiento`
--

INSERT INTO `instructor_red_conocimiento` (`id`, `persona_id`, `red_conocimiento_id`, `created_at`, `updated_at`) VALUES
(1, 23, 3, NULL, NULL),
(2, 17, 3, '2024-10-28 06:35:37', '2024-10-28 06:35:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornadas`
--

CREATE TABLE `jornadas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `jornadas`
--

INSERT INTO `jornadas` (`id`, `nombre`, `hora_inicio`, `hora_fin`, `created_at`, `updated_at`) VALUES
(1, 'Mañana', '07:00:00', '13:00:00', '2024-10-13 07:40:48', '2024-10-13 07:40:48'),
(2, 'Tarde', '13:00:00', '19:00:00', '2024-10-13 07:41:24', '2024-10-13 07:41:24'),
(3, 'Noche', '19:00:00', '22:00:00', '2024-10-13 08:02:25', '2024-10-13 08:02:25'),
(4, 'MEDIA MAÑANA 1', '07:00:00', '10:00:00', '2024-10-13 08:03:10', '2024-10-13 08:03:10'),
(5, 'MEDIA MAÑANA 2', '10:00:00', '13:00:00', '2024-10-13 08:03:43', '2024-10-13 08:03:43'),
(6, 'MEDIA TARDE 1', '13:00:00', '16:00:00', '2024-10-13 08:05:23', '2024-10-13 08:05:23'),
(7, 'MEDIA TARDE 2', '16:00:00', '19:00:00', '2024-10-13 08:05:58', '2024-10-13 08:05:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_10_12_040347_create_red_conocimientos_table', 1),
(2, '2024_10_12_043615_add_red_conocimiento_to_programa_formacions_table', 2),
(3, '2024_10_12_052531_create_jornadas_table', 2),
(4, '2024_10_12_052750_create_fichas_table', 2),
(5, '2024_10_12_060400_add_new_dates_to_fichas_table', 2),
(6, '2024_10_12_072128_add_duracion_horas_to_competencias_table', 2),
(7, '2024_10_12_073020_add_duracion_horas_to_resultado_aprendizajes_table', 2),
(8, '2024_10_13_004137_add_is_manually_edited_to_resultado_aprendizajes_table', 2),
(9, '2024_10_13_005301_add_is_manually_edited_to_resultado_aprendizajes', 2),
(10, '2024_10_13_012056_add_is_manually_edited_to_resultado_aprendizajes_table', 2),
(11, '2024_10_13_051340_add_codigo_ficha_to_personas_table', 3),
(12, '2024_10_13_174209_create_tipo_ambiente_table', 4),
(13, '2024_10_14_021113_create_tipos_ambiente_table', 5),
(14, '2024_10_14_021239_create_novedades_table', 5),
(15, '2024_10_14_021612_create_estados_novedad_table', 6),
(16, '2024_10_22_125612_create_instructor_red_conocimiento_table', 7),
(17, '2024_10_23_041026_create_competencia_instructor_table', 8),
(18, '2024_11_01_141721_create_cedulas_autorizadas_table', 9),
(19, '2024_11_01_205852_modify_fichas_table_add_numero_aprendices', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedad`
--

CREATE TABLE `novedad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `id_recurso` int(11) NOT NULL,
  `descripcion` varchar(256) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL,
  `fecha_solucion` timestamp NULL DEFAULT NULL,
  `descripcion_solucion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `novedad`
--

INSERT INTO `novedad` (`id`, `nombre`, `id_recurso`, `descripcion`, `fecha_registro`, `estado`, `fecha_solucion`, `descripcion_solucion`) VALUES
(1, 'jl', 3, 'k', '2024-11-01 17:27:12', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `documento` varchar(255) NOT NULL,
  `pnombre` varchar(255) NOT NULL,
  `snombre` varchar(255) DEFAULT NULL,
  `papellido` varchar(255) NOT NULL,
  `sapellido` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `tipo_sangre_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_contrato_id` bigint(20) UNSIGNED DEFAULT NULL,
  `codigo_ficha` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `documento`, `pnombre`, `snombre`, `papellido`, `sapellido`, `telefono`, `correo`, `direccion`, `tipo_sangre_id`, `tipo_contrato_id`, `codigo_ficha`, `created_at`, `updated_at`, `user_id`) VALUES
(8, '8437347', 'Luisa', 'Carlos', 'Correa', 'Arrieta', '3012481020', 'pcapacho24@gmail.com', 'Carrera 112a # 90a-10', 7, 1, NULL, '2024-10-01 20:35:29', '2024-11-03 23:19:54', 10),
(17, '108827194', 'cindy', 'johanna', 'gualtero', NULL, '3145135853', 'cjgualtero@sena.edu.co', 'mz 3 c 1', 1, 1, NULL, '2024-10-08 03:15:29', '2024-10-08 03:15:29', 17),
(23, '123587469', 'manuela', NULL, 'Mora', 'nia', '3214569797', 'manuelas4@gmail.com', 'CRR 105 # 102-24', 7, 2, NULL, '2024-10-22 20:42:32', '2024-10-22 20:42:32', 27),
(27, '1038805081', 'Sandra', 'Miladys', 'Mora', 'Benitez', '3502768415', 'sandmorbe@gmail.com', 'Carrera 112a # 90a-10', 7, NULL, '2673033', '2024-11-02 13:36:33', '2024-11-02 13:36:33', 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa__formacions`
--

CREATE TABLE `programa__formacions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `duracion_meses` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `red_conocimiento_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `programa__formacions`
--

INSERT INTO `programa__formacions` (`id`, `nombre`, `codigo`, `version`, `descripcion`, `duracion_meses`, `created_at`, `updated_at`, `red_conocimiento_id`) VALUES
(5, 'ANALISIS Y DESARROLLO DE SOFTWARE', '574', '2024', 'fjyfhgfdjj', 27, '2024-10-22 20:28:15', '2024-10-22 20:28:15', 3),
(6, 'ANALISI Y DESARROLLO DE SISTEMAS', '2673007', '2024', 'PROGRAMA DE DESARROLLO DE APLICACIONES WEB , MOBILES Y DE ESCRITORIO', 24, '2024-10-29 22:46:32', '2024-10-29 22:46:32', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id_recurso` int(11) NOT NULL,
  `id_ambiente` bigint(20) UNSIGNED DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`id_recurso`, `id_ambiente`, `descripcion`, `fecha_registro`, `estado`) VALUES
(2, 93243, 'alsdjfk', '2024-11-01 15:51:47', 1),
(3, 93243, 'forestgump', '2024-11-01 15:51:58', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `red_conocimientos`
--

CREATE TABLE `red_conocimientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `codigo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `red_conocimientos`
--

INSERT INTO `red_conocimientos` (`id`, `nombre`, `descripcion`, `codigo`, `created_at`, `updated_at`) VALUES
(3, 'Programacion', 'Analista y desarrolladores de aplicaciones web y de escritorio', '574', '2024-10-22 02:14:44', '2024-10-22 02:14:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado_aprendizajes`
--

CREATE TABLE `resultado_aprendizajes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `intensidad_horaria` int(11) NOT NULL,
  `competencia_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_manually_edited` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `resultado_aprendizajes`
--

INSERT INTO `resultado_aprendizajes` (`id`, `codigo`, `descripcion`, `intensidad_horaria`, `competencia_id`, `created_at`, `updated_at`, `is_manually_edited`) VALUES
(12, '574', 'entornos basicos de htm, css y js', 60, 5, '2024-11-02 19:30:50', '2024-11-02 19:33:30', 1),
(13, '5741', 'crear paginas web basicas aplicando htm, css y js', 47, 5, '2024-11-02 19:31:38', '2024-11-02 19:33:30', 0),
(14, '5742', 'aplicar stiles de css y bootstrap a las paginas', 47, 5, '2024-11-02 19:32:20', '2024-11-02 19:33:30', 0),
(15, '5743', 'aplicar resposives a las paginas con bootstrap y los recursos', 46, 5, '2024-11-02 19:33:15', '2024-11-02 19:33:30', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `descripcion`) VALUES
(1, 'admin', ''),
(2, 'instructor', ''),
(3, 'aprendiz', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3ftELhlU45kEo3PWl3oCfuBOiaEHNNgn8L4tqQpf', 10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiekIzdjBJckNkRTZjTXJSVlh3Nks0RzZIbGFhN200dDJwdVRZWk9jcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTA5OiJodHRwOi8vbG9jYWxob3N0L2xhcmF2ZWwvdHJhYmFqb19maW5hbC9wdWJsaWMvcmVwb3J0ZXMtcHJvZ3JhbWFjaW9uL2RpYXJpbz9hbWJpZW50ZV9pZD05MzI0MyZmZWNoYT0yMDI0LTExLTA1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzMwODE1NDU1O319', 1730816430),
('8CH0CHHQrUaTtuGHyYBvZ5F0Ff8PRXS74OB4MoEw', 10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoia3NpbG53T2hrNk9ncHRqbmE2U0p6SzFzMXBTUnNBMENQbXp6bExJRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njc6Imh0dHA6Ly9sb2NhbGhvc3QvbGFyYXZlbC90cmFiYWpvX2ZpbmFsL3B1YmxpYy9yZXBvcnRlcy1wcm9ncmFtYWNpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3MzA4NTcwMTg7fX0=', 1730866888),
('AtAmh2bS8uOwz2dDEiBbTqCpNROokELIcFaN8XUi', 10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibENjNTFhTmtlSXRUT2ZjWERTUnB1aGhLaTZNRUZydzBONE41WWhLWCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjExNDoiaHR0cDovL2xvY2FsaG9zdC9sYXJhdmVsL3RyYWJham9fZmluYWwvcHVibGljL3JlcG9ydGVzLXByb2dyYW1hY2lvbi9zZW1hbmFsP2ZlY2hhX2luaWNpbz0yMDI0LTExLTA0Jmluc3RydWN0b3JfaWQ9Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzMwODE3NDE3O319', 1730823529),
('cNVXoW9HoEGWnLp6OJG4jLlf0lpgSxKRR83mC8xf', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR1FOS1NQUkRwQ0tpZ1JlY2h2S09pZXJUaFpSdVN6YTkzZUVxdW80aiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MDoiaHR0cDovL2xvY2FsaG9zdC9sYXJhdmVsL3NncGFjMi9wdWJsaWMvcmVwb3J0ZXMtcHJvZ3JhbWFjaW9uIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sb2NhbGhvc3QvbGFyYXZlbC9zZ3BhYzIvcHVibGljL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1730817398),
('eBcnbidSjS2qB97CeXU7fWl0BpCEIPKyFmgrFTrO', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMkdJZkdtb3VXSk1QWWM3NDdPTmtSeW9MYW9lY2ZOR1E4TEZHZTRJNCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDc6Imh0dHA6Ly9sb2NhbGhvc3QvbGFyYXZlbC9zZ3BhYzIvcHVibGljL3JlcG9ydGVzLXByb2dyYW1hY2lvbi9zZW1hbmFsP2ZlY2hhX2luaWNpbz0yMDI0LTExLTA0Jmluc3RydWN0b3JfaWQ9Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sb2NhbGhvc3QvbGFyYXZlbC9zZ3BhYzIvcHVibGljL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1730815432),
('GKi1zoa7Eqpjoz5G0NHq6vPI8IuMWtLpYLvZSYSl', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRFdEb0JBOEd5b3laRnRobHRNVEtPcE5ic0lWY1ZCVnJ6Sk8yTElPdyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDc6Imh0dHA6Ly9sb2NhbGhvc3QvbGFyYXZlbC9zZ3BhYzIvcHVibGljL3JlcG9ydGVzLXByb2dyYW1hY2lvbi9zZW1hbmFsP2ZlY2hhX2luaWNpbz0yMDI0LTExLTA0Jmluc3RydWN0b3JfaWQ9Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sb2NhbGhvc3QvbGFyYXZlbC9zZ3BhYzIvcHVibGljL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1730816642),
('jDEfWrndxTsIghNkIf3nQsTL3lQREkWANnSaan3L', 10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiQm0xZEpRU1pXYmhXVndZRWV6Z2RwV05xM1BMSUZuSERCRWpkMzVXQSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjk3OiJodHRwOi8vbG9jYWxob3N0L2xhcmF2ZWwvc2dwYWMyL3B1YmxpYy9yZXBvcnRlcy1wcm9ncmFtYWNpb24vZGlhcmlvP2FtYmllbnRlX2lkPSZmZWNoYT0yMDI0LTExLTA1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzMwODEzNzg3O319', 1730813794),
('MQSDUYh1rQVA1vcAi9dlsEM5NZLfa4HmzpQHDXyn', 10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiMnhOYmh6aFdpem9ZMmpQRnFZdmk1T0d3UlBIMGNUV2VXWU5OYmdTOSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjExNToiaHR0cDovL2xvY2FsaG9zdC9sYXJhdmVsL3RyYWJham9fZmluYWwvcHVibGljL3JlcG9ydGVzLXByb2dyYW1hY2lvbi9tZW5zdWFsP2FtYmllbnRlX2lkPSZpbnN0cnVjdG9yX2lkPSZtZXM9MjAyNC0xMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTczMDgxNjc5Nzt9fQ==', 1730817304),
('qBr6ybSlKq3B82alMECFPTDfzhhDFrubTJP3j2Nk', 10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYVJkMHNlMGJRaUtMTzlsUW1PbUJ3MFlwYlhyMjI5bzhqakkxQnAwbSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjY3OiJodHRwOi8vbG9jYWxob3N0L2xhcmF2ZWwvdHJhYmFqb19maW5hbC9wdWJsaWMvcmVwb3J0ZXMtcHJvZ3JhbWFjaW9uIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzMwODE2MjI2O319', 1730816249),
('U7aOyRDTQ2FHhp3HXj2Gtm3mJ4puwdmqCa5zjGnr', 10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiY1FtbjVudzZkbEc5NFcwSFVzWmRaRG56dDVxMW1kaFN0Q0pqSndxMSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjEwNDoiaHR0cDovL2xvY2FsaG9zdC9sYXJhdmVsL3RyYWJham9fZmluYWwvcHVibGljL3JlcG9ydGVzLXByb2dyYW1hY2lvbi9kaWFyaW8/YW1iaWVudGVfaWQ9JmZlY2hhPTIwMjQtMTEtMDUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3MzA4MTI2NzU7fX0=', 1730813769),
('vU9iPbJOuRveHbC3qYgqT4UO1oyVXm7N4uTGhP8y', 10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVmxZRXZqZnIzTDNRZnpyamlKOU1EWHBOeURYeURSREthZFdOOXZyRSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjEwNDoiaHR0cDovL2xvY2FsaG9zdC9sYXJhdmVsL3RyYWJham9fZmluYWwvcHVibGljL3JlcG9ydGVzLXByb2dyYW1hY2lvbi9kaWFyaW8/YW1iaWVudGVfaWQ9JmZlY2hhPTIwMjQtMTEtMDUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3MzA4MTQ1MDU7fX0=', 1730815376),
('YcdPorhb10DwVWex2QwmOXpX8Nwxxn95qXuBzogl', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOEVRTmw5Wk1BOHFDcWpKMUYyVWoxd1BtOFBWODlPc2NSNk05TWdEVSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMTQ6Imh0dHA6Ly9sb2NhbGhvc3QvbGFyYXZlbC90cmFiYWpvX2ZpbmFsL3B1YmxpYy9yZXBvcnRlcy1wcm9ncmFtYWNpb24vc2VtYW5hbD9mZWNoYV9pbmljaW89MjAyNC0xMS0wNCZpbnN0cnVjdG9yX2lkPSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUxOiJodHRwOi8vbG9jYWxob3N0L2xhcmF2ZWwvdHJhYmFqb19maW5hbC9wdWJsaWMvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1730847853);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ambientes`
--

CREATE TABLE `tipo_ambientes` (
  `id` int(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_ambientes`
--

INSERT INTO `tipo_ambientes` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'AUDITORIO', '2024-10-22 02:09:52', '2024-10-22 02:09:52'),
(2, 'METAL MECANICA', '2024-10-22 02:10:21', '2024-10-22 02:10:21'),
(3, 'CONECTIVIDAD', '2024-10-22 02:11:27', '2024-10-22 02:11:27'),
(4, 'TECNOLOGIA', '2024-10-22 02:11:53', '2024-10-22 02:11:53'),
(5, 'ADMINISTRATIVO', '2024-10-22 02:12:16', '2024-10-22 02:12:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `email_verified_at`, `password`, `remember_token`, `role_id`, `created_at`, `updated_at`) VALUES
(10, 'pcapacho24@gmail.com', NULL, '$2y$12$/qQSAk4ptfySwchPFcBj1.Wob0EcDaZVpZZknpCx.cMecx5ant7ta', NULL, 1, '2024-10-01 20:34:50', '2024-10-02 03:09:34'),
(11, 'juaco@gmail.com', NULL, '$2y$12$Pd5leTLwRG5GLHhdgIQuJO7bMSdf3Om9gRpAcQhq4PZuysimxl09q', NULL, 3, '2024-10-01 23:00:50', '2024-10-01 23:00:50'),
(17, 'cjgualtero@sena.edu.co', NULL, '$2y$12$8R61meaTq5m/whAGt8BuIO56wqGzDAL2JNdD/HFDj.K7I9uiHYFgW', NULL, 2, '2024-10-08 03:15:29', '2024-10-28 06:35:37'),
(27, 'manuelas4@gmail.com', NULL, '$2y$12$l/9HMHBJjy84kYGB5.eC9OtXxAS7ajn59AjZFpzcC1ZPa8VWAqZvq', NULL, 2, '2024-10-22 20:42:32', '2024-10-22 22:02:45'),
(31, 'sandmorbe@gmail.com', NULL, '$2y$12$1HNpH4X1z0cDCy8119Ad0.PKLzMvUrnPDpU6.OpMVkYWmPIe4CiSm', NULL, 3, '2024-11-02 13:36:33', '2024-11-02 13:36:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero` (`numero`),
  ADD UNIQUE KEY `alias` (`alias`),
  ADD KEY `estado` (`estado_id`),
  ADD KEY `tipo` (`tipo_id`),
  ADD KEY `tipo_2` (`tipo_id`),
  ADD KEY `id_red_conocimiento` (`red_conocimiento_id`),
  ADD KEY `id_red_conocimiento_2` (`red_conocimiento_id`);

--
-- Indices de la tabla `ambiente_programacions`
--
ALTER TABLE `ambiente_programacions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ambiente_programacions_fecha_idx` (`fecha`),
  ADD KEY `ambiente_programacions_estado_idx` (`estado`),
  ADD KEY `ambiente_programacions_ambiente_id_foreign` (`ambiente_id`),
  ADD KEY `ambiente_programacions_ficha_id_foreign` (`ficha_id`),
  ADD KEY `ambiente_programacions_jornada_id_foreign` (`jornada_id`),
  ADD KEY `ambiente_programacions_competencia_id_foreign` (`competencia_id`),
  ADD KEY `ambiente_programacions_persona_id_foreign` (`persona_id`),
  ADD KEY `resultado_aprendizaje_id` (`resultado_aprendizaje_id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cedulas_autorizadas`
--
ALTER TABLE `cedulas_autorizadas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedulas_autorizadas_documento_unique` (`documento`);

--
-- Indices de la tabla `competencias`
--
ALTER TABLE `competencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `competencias_codigo_unique` (`codigo`),
  ADD KEY `competencias_programa_formacion_id_foreign` (`programa_formacion_id`);

--
-- Indices de la tabla `competencia_instructor`
--
ALTER TABLE `competencia_instructor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competencia_instructor_persona_id_foreign` (`instructor_id`),
  ADD KEY `competencia_instructor_competencia_id_persona_id_index` (`competencia_id`,`instructor_id`);

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_ambiente`
--
ALTER TABLE `estado_ambiente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_novedad`
--
ALTER TABLE `estado_novedad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_recurso`
--
ALTER TABLE `estado_recurso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fichas_codigo_ficha_unique` (`codigo_ficha`),
  ADD KEY `fichas_jornada_id_foreign` (`jornada_id`),
  ADD KEY `fichas_programa_formacion_id_foreign` (`programa_formacion_id`),
  ADD KEY `fichas_red_conocimiento_id_foreign` (`red_conocimiento_id`),
  ADD KEY `instructor_lider` (`instructor_lider`);

--
-- Indices de la tabla `grupo_sanguineos`
--
ALTER TABLE `grupo_sanguineos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `instructor_red_conocimiento`
--
ALTER TABLE `instructor_red_conocimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_red_conocimiento_persona_id_foreign` (`persona_id`),
  ADD KEY `instructor_red_conocimiento_red_conocimiento_id_foreign` (`red_conocimiento_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jornadas`
--
ALTER TABLE `jornadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `novedad`
--
ALTER TABLE `novedad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado_novedad` (`estado`),
  ADD KEY `id_recurso` (`id_recurso`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`),
  ADD KEY `personas_tipo_sangre_id_foreign` (`tipo_sangre_id`),
  ADD KEY `personas_tipo_contrato_id_foreign` (`tipo_contrato_id`),
  ADD KEY `personas_user_id_foreign` (`user_id`),
  ADD KEY `personas_codigo_ficha_foreign` (`codigo_ficha`);

--
-- Indices de la tabla `programa__formacions`
--
ALTER TABLE `programa__formacions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `programa__formacions_codigo_unique` (`codigo`),
  ADD KEY `programa__formacions_red_conocimiento_id_foreign` (`red_conocimiento_id`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id_recurso`),
  ADD KEY `id_ambiente` (`id_ambiente`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `red_conocimientos`
--
ALTER TABLE `red_conocimientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `red_conocimientos_codigo_unique` (`codigo`);

--
-- Indices de la tabla `resultado_aprendizajes`
--
ALTER TABLE `resultado_aprendizajes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resultado_aprendizajes_codigo_unique` (`codigo`),
  ADD KEY `resultado_aprendizajes_competencia_id_foreign` (`competencia_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tipo_ambientes`
--
ALTER TABLE `tipo_ambientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93245;

--
-- AUTO_INCREMENT de la tabla `ambiente_programacions`
--
ALTER TABLE `ambiente_programacions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=524729;

--
-- AUTO_INCREMENT de la tabla `cedulas_autorizadas`
--
ALTER TABLE `cedulas_autorizadas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `competencias`
--
ALTER TABLE `competencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `competencia_instructor`
--
ALTER TABLE `competencia_instructor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_ambiente`
--
ALTER TABLE `estado_ambiente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `estado_novedad`
--
ALTER TABLE `estado_novedad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_recurso`
--
ALTER TABLE `estado_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `instructor_red_conocimiento`
--
ALTER TABLE `instructor_red_conocimiento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `jornadas`
--
ALTER TABLE `jornadas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `novedad`
--
ALTER TABLE `novedad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `programa__formacions`
--
ALTER TABLE `programa__formacions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id_recurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `red_conocimientos`
--
ALTER TABLE `red_conocimientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `resultado_aprendizajes`
--
ALTER TABLE `resultado_aprendizajes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_ambientes`
--
ALTER TABLE `tipo_ambientes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ambientes`
--
ALTER TABLE `ambientes`
  ADD CONSTRAINT `ambientes_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipo_ambientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ambientes_ibfk_2` FOREIGN KEY (`estado_id`) REFERENCES `estado_ambiente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ambientes_ibfk_3` FOREIGN KEY (`red_conocimiento_id`) REFERENCES `red_conocimientos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ambiente_programacions`
--
ALTER TABLE `ambiente_programacions`
  ADD CONSTRAINT `ambiente_programacions_ambiente_id_foreign` FOREIGN KEY (`ambiente_id`) REFERENCES `ambientes` (`id`),
  ADD CONSTRAINT `ambiente_programacions_competencia_id_foreign` FOREIGN KEY (`competencia_id`) REFERENCES `competencias` (`id`),
  ADD CONSTRAINT `ambiente_programacions_ficha_id_foreign` FOREIGN KEY (`ficha_id`) REFERENCES `fichas` (`id`),
  ADD CONSTRAINT `ambiente_programacions_ibfk_1` FOREIGN KEY (`resultado_aprendizaje_id`) REFERENCES `resultado_aprendizajes` (`id`),
  ADD CONSTRAINT `ambiente_programacions_jornada_id_foreign` FOREIGN KEY (`jornada_id`) REFERENCES `jornadas` (`id`),
  ADD CONSTRAINT `ambiente_programacions_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `competencia_instructor`
--
ALTER TABLE `competencia_instructor`
  ADD CONSTRAINT `competencia_instructor_competencia_id_foreign` FOREIGN KEY (`competencia_id`) REFERENCES `competencias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `competencia_instructor_persona_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD CONSTRAINT `fichas_ibfk_1` FOREIGN KEY (`instructor_lider`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `fichas_jornada_id_foreign` FOREIGN KEY (`jornada_id`) REFERENCES `jornadas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fichas_red_conocimiento_id_foreign` FOREIGN KEY (`red_conocimiento_id`) REFERENCES `red_conocimientos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `instructor_red_conocimiento`
--
ALTER TABLE `instructor_red_conocimiento`
  ADD CONSTRAINT `instructor_red_conocimiento_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `instructor_red_conocimiento_red_conocimiento_id_foreign` FOREIGN KEY (`red_conocimiento_id`) REFERENCES `red_conocimientos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `novedad`
--
ALTER TABLE `novedad`
  ADD CONSTRAINT `novedad_ibfk_1` FOREIGN KEY (`estado`) REFERENCES `estado_novedad` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `novedad_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id_recurso`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_codigo_ficha_foreign` FOREIGN KEY (`codigo_ficha`) REFERENCES `fichas` (`codigo_ficha`) ON DELETE SET NULL;

--
-- Filtros para la tabla `programa__formacions`
--
ALTER TABLE `programa__formacions`
  ADD CONSTRAINT `programa__formacions_red_conocimiento_id_foreign` FOREIGN KEY (`red_conocimiento_id`) REFERENCES `red_conocimientos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD CONSTRAINT `recurso_ibfk_1` FOREIGN KEY (`id_ambiente`) REFERENCES `ambientes` (`id`),
  ADD CONSTRAINT `recurso_ibfk_2` FOREIGN KEY (`estado`) REFERENCES `estado_recurso` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
