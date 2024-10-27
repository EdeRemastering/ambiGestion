-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-10-2024 a las 23:34:02
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
-- Base de datos: `programacion_ambientes_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambientes`
--

CREATE TABLE `ambientes` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `alias` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `capacidad` int(11) NOT NULL DEFAULT current_timestamp(),
  `descripcion` varchar(100) NOT NULL,
  `tipo` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT current_timestamp(),
  `red_de_conocimiento` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ambientes`
--

INSERT INTO `ambientes` (`id`, `numero`, `alias`, `capacidad`, `descripcion`, `tipo`, `estado`, `red_de_conocimiento`, `created_at`, `updated_at`) VALUES
(12, 3242, 'Taller IoT', 25, 'pvp, manco j', 1, 2, 1, '2024-10-21 01:06:36', '2024-10-21 06:06:36'),
(1032, 32434, 'Sala de IA', 15, 'ñ', 1, 1, 1, '2024-10-18 22:57:57', '2024-10-19 03:57:57'),
(1143, 134234, 'Aula Blockchain', 30, 'Jajajajja', 1, 1, 7, '2024-10-21 00:51:42', '2024-10-21 05:51:42'),
(5325, 12341423, 'Sala de Informática 2', 25, '', 1, 1, 1, '2024-10-01 20:15:32', '2024-10-22 13:39:41'),
(6324, 14231, 'Aula 2023', 30, 'el mejor ()', 1, 1, 1, '2024-09-22 21:13:32', '2024-09-23 02:13:32'),
(8233, 41214, 'Sala de Videoconferencias', 20, 'jl', 1, 1, 1, '2024-10-07 16:42:02', '2024-10-07 21:42:02'),
(20032, 143223, 'biligüismo', 10, '', 1, 1, 1, '2024-10-01 20:15:32', '2024-10-22 13:39:41'),
(93232, 14213, 'Laboratorio de Cloud', 20, '', 1, 1, 1, '2024-10-01 20:15:32', '2024-10-22 13:39:41'),
(93239, 223, 'asdfaf', 32, 'asdf', 1, 1, 1, '2024-10-07 02:52:13', '2024-10-07 02:52:13'),
(93241, 32, 'Catorcenone', 32, 'ladsfj', 1, 4, 1, '2024-10-18 22:59:00', '2024-10-24 02:56:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_diarias`
--

CREATE TABLE `asignaciones_diarias` (
  `id` int(11) NOT NULL,
  `programacion` int(11) DEFAULT NULL,
  `dia` int(11) DEFAULT NULL,
  `instructor_asignado` bigint(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaciones_diarias`
--

INSERT INTO `asignaciones_diarias` (`id`, `programacion`, `dia`, `instructor_asignado`, `created_at`) VALUES
(71, NULL, 1, NULL, '2024-10-26 01:05:27'),
(88, NULL, 1, NULL, '2024-10-26 02:32:50'),
(89, NULL, 2, NULL, '2024-10-26 02:32:50'),
(90, NULL, 3, NULL, '2024-10-26 02:32:50'),
(91, NULL, 4, NULL, '2024-10-26 02:32:50'),
(92, NULL, 5, NULL, '2024-10-26 02:32:50'),
(93, NULL, 6, NULL, '2024-10-26 02:32:50'),
(94, NULL, 7, NULL, '2024-10-26 02:32:50'),
(104, NULL, 1, NULL, '2024-10-26 03:38:40'),
(105, NULL, 2, NULL, '2024-10-26 03:38:40'),
(106, NULL, 3, NULL, '2024-10-26 03:38:40'),
(107, NULL, 5, NULL, '2024-10-26 03:38:40'),
(108, NULL, 6, NULL, '2024-10-26 03:38:40'),
(109, NULL, 7, NULL, '2024-10-26 03:38:40'),
(110, NULL, 2, NULL, '2024-10-26 03:46:52'),
(111, NULL, 1, NULL, '2024-10-26 14:06:55'),
(112, NULL, 2, NULL, '2024-10-26 14:06:55'),
(114, 29, 1, 1, '2024-10-27 01:06:13'),
(115, 29, 2, 2, '2024-10-27 01:06:13'),
(118, 30, 1, 2, '2024-10-27 17:45:25'),
(119, 30, 2, 1, '2024-10-27 17:45:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `competencias`
--

CREATE TABLE `competencias` (
  `id` bigint(20) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `programa_formacion_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `competencias`
--

INSERT INTO `competencias` (`id`, `codigo`, `descripcion`, `programa_formacion_id`, `created_at`, `updated_at`) VALUES
(2, '225547', 'creacion e implementacion del lenguaje HTML, CSS, JAVA SCRIPT, y frenware como BOOTSTRAP', 3, '2024-10-08 12:40:46', '2024-10-08 12:40:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id` bigint(20) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `descripcion`) VALUES
(1, 'Vinculado'),
(2, 'Contratista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias`
--

CREATE TABLE `dias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dias`
--

INSERT INTO `dias` (`id`, `nombre`) VALUES
(1, 'domingo'),
(2, 'lunes'),
(3, 'martes'),
(4, 'miercoles'),
(5, 'jueves'),
(6, 'viernes'),
(7, 'sabado');

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
(1, 'disponible'),
(2, 'ocupado'),
(3, 'mantenimiento'),
(4, 'fuera_de_servicio');

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
(2, 'en_curso'),
(3, 'solucionado'),
(4, 'en_revision'),
(5, 'aprobada'),
(6, 'rechazada'),
(7, 'en_proceso');

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
(2, 'mantenimiento'),
(3, 'fuera_de_servicio'),
(6, 'prestado'),
(7, 'perdido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `id_ficha` int(11) NOT NULL,
  `id_programa_formacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `jornada` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`id_ficha`, `id_programa_formacion`, `nombre`, `jornada`, `fecha_inicio`, `fecha_fin`, `created_at`, `updated_at`) VALUES
(78, 9, 'jk', 2, '2024-10-16 00:00:00', '2024-10-29 00:00:00', '2024-10-24 22:13:24', '2024-10-24 22:13:24'),
(87868, 8, 'hkjl', 1, '2024-10-04 00:00:00', '2024-10-16 00:00:00', '2024-10-24 22:00:17', '2024-10-24 22:00:17'),
(99382, 9, 'analisis e informatica', 1, '2024-10-28 00:00:00', '2024-11-07 00:00:00', '2024-10-26 08:46:07', '2024-10-26 08:46:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_sanguineos`
--

CREATE TABLE `grupo_sanguineos` (
  `id` bigint(20) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) NOT NULL,
  `reserved_at` int(10) NOT NULL DEFAULT current_timestamp(),
  `available_at` int(10) NOT NULL,
  `created_at` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `options` mediumtext NOT NULL DEFAULT current_timestamp(),
  `cancelled_at` int(11) NOT NULL DEFAULT current_timestamp(),
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornadas`
--

CREATE TABLE `jornadas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jornadas`
--

INSERT INTO `jornadas` (`id`, `nombre`) VALUES
(1, 'mañana'),
(2, 'tarde'),
(3, 'diurna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_09_20_193142_create_roles_table', 2),
(5, '2024_09_20_193231_create_grupo_sanguineos_table', 2),
(6, '2024_09_20_193303_create_contratos_table', 2),
(7, '2024_09_20_195854_create_contratos_table', 3),
(8, '2024_09_20_195911_create_roles_table', 4),
(9, '2024_09_20_195934_create_grupo_sanguineos_table', 5),
(10, '2024_09_20_195948_create_personas_table', 5),
(11, '2024_09_21_023426_add_user_id_to_personas_table', 6),
(12, '2024_09_21_064622_add_user_id_to_personas_table', 7),
(13, '2024_09_26_022237_add_name_column_to_roles_table', 8),
(14, '2024_10_07_212146_create_resultados_table', 9),
(15, '2024_10_07_212241_create_programas_table', 9),
(16, '2024_10_07_212411_create_competencias_table', 9),
(17, '2024_10_08_045207_create_programa_formacions_table', 10),
(18, '2024_10_08_050726_create_programa__formacions_table', 11),
(19, '2024_10_08_072228_create_competencias_table', 12),
(20, '2024_10_08_074537_create_resultado_aprendizajes_table', 13),
(21, '2024_10_08_184209_make_tipo_contrato_id_nullable_in_personas_table', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedad`
--

CREATE TABLE `novedad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `recurso` int(11) DEFAULT NULL,
  `descripcion` varchar(256) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL,
  `fecha_solucion` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion_solucion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `novedad`
--

INSERT INTO `novedad` (`id`, `nombre`, `recurso`, `descripcion`, `fecha_registro`, `estado`, `fecha_solucion`, `descripcion_solucion`) VALUES
(1, 'pc dañado', NULL, 'se daño porque un niño lo golpfadseo', '2024-09-26 18:04:49', 1, '2024-10-24 05:00:00', 'khj'),
(2, 'pc dañado', NULL, 'ruben lo patió', '2024-10-01 19:40:55', 1, '2024-10-22 13:39:41', ''),
(8, 'eder', NULL, 'dsfa', '2024-10-06 06:28:38', 1, '2024-10-22 13:39:41', ''),
(9, 'lkjkfas', NULL, 'aoksdfj', '2024-10-06 15:51:00', 6, '2024-10-22 13:39:41', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(20) NOT NULL,
  `documento` varchar(255) NOT NULL,
  `pnombre` varchar(255) NOT NULL,
  `snombre` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `papellido` varchar(255) NOT NULL,
  `sapellido` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `telefono` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `tipo_sangre_id` bigint(20) NOT NULL,
  `tipo_contrato_id` bigint(20) NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `documento`, `pnombre`, `snombre`, `papellido`, `sapellido`, `telefono`, `correo`, `direccion`, `tipo_sangre_id`, `tipo_contrato_id`, `created_at`, `updated_at`, `user_id`) VALUES
(1, '1032178212', 'Eder', 'Luis', 'Mestra', 'Morelo', '3215482232', 'EDERLUISMESTRA9@GMAIL.COM', 'luisa te amo mi vida <3', 7, 1, '2024-10-26 20:46:22', '2024-10-27 12:51:34', 1),
(2, '1032177822', 'Luisa', 'Fernanda', 'Galvis', 'Fernandez', '3113391450', 'luisa@gmail.com', 'OBRERO BLOQUE 4 MANZANA 33 CASA 12', 8, 1, '2024-10-26 23:19:24', '2024-10-26 23:19:24', 2),
(3, '1111111111', 'ruben', 'de jesús', 'zapata', 'quiroz', '3215482237', 'ruben@gmail.com', 'none', 2, 1, '2024-10-27 13:13:22', '2024-10-27 13:13:22', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programaciones`
--

CREATE TABLE `programaciones` (
  `id` int(11) NOT NULL,
  `ficha` int(11) DEFAULT NULL,
  `ambiente` int(11) DEFAULT NULL,
  `instructor_asignante` bigint(20) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programaciones`
--

INSERT INTO `programaciones` (`id`, `ficha`, `ambiente`, `instructor_asignante`, `hora_inicio`, `hora_fin`, `fecha_inicio`, `fecha_fin`, `estado`, `created_at`, `updated_at`) VALUES
(29, 87868, 12, 1, '07:00:00', '13:00:00', '2024-10-26', '2024-10-27', 'activo', '2024-10-26 20:50:16', '2024-10-26 20:50:16'),
(30, 87868, 1143, 2, '07:00:00', '13:00:00', '2024-10-16', '2024-10-25', 'activo', '2024-10-27 22:39:01', '2024-10-27 22:45:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `version` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `red_conocimiento` int(11) NOT NULL,
  `duracion_meses` int(3) NOT NULL,
  `requisitos_ingreso` varchar(100) NOT NULL,
  `requisitos_formacion` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id`, `nombre`, `version`, `fecha_creacion`, `red_conocimiento`, `duracion_meses`, `requisitos_ingreso`, `requisitos_formacion`, `created_at`, `updated_at`) VALUES
(8, 'Adso Sobra', 1, '2024-10-03 00:00:00', 2, 12, 'si', 'no', '2024-10-19 02:44:49', '2024-10-19 07:44:49'),
(9, 'Adso', 5, '2024-10-29 00:00:00', 2, 25, 'Yes', 'Not', '2024-10-07 19:48:50', '2024-10-07 19:48:50'),
(10, 'adsi', 1, '2024-10-20 19:53:44', 1, 12, 'N/A', 'N/A', '2024-10-21 05:53:44', '2024-10-21 05:53:44'),
(11, 'Ambientesololesjafsdklf', 32, '2024-10-21 14:23:29', 1, 23, 'ñljasdf', 'ñaljkdfs', '2024-10-22 00:23:29', '2024-10-22 00:23:29'),
(12, 'añjsdfk', 2, '2024-10-21 14:24:33', 1, 23, 'asd', 'fda', '2024-10-22 00:24:33', '2024-10-22 00:24:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id_recurso` int(11) NOT NULL,
  `id_ambiente` int(11) NOT NULL DEFAULT current_timestamp(),
  `descripcion` text NOT NULL DEFAULT current_timestamp(),
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`id_recurso`, `id_ambiente`, `descripcion`, `fecha_registro`, `estado`) VALUES
(32333, 93239, 'Cluster de GPUs para IA', '2024-09-21 05:00:00', 1),
(32334, 12, 'Nodos blockchain de prueba', '2024-09-22 05:00:00', 1),
(32335, 12, 'Kit de desarrollo IoT', '2024-09-23 05:00:00', 1),
(32336, 12, 'fulala', '2024-10-08 01:32:19', 1),
(32337, 20032, 'kjkljhkjkññkjkj', '2024-10-18 12:16:57', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `red_de_formacion`
--

CREATE TABLE `red_de_formacion` (
  `id_area_formacion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `red_de_formacion`
--

INSERT INTO `red_de_formacion` (`id_area_formacion`, `nombre`) VALUES
(1, 'tics'),
(2, 'tocs'),
(7, 'Cloud Computing'),
(8, 'Inteligencia Artificial'),
(9, 'Blockchain'),
(10, 'Internet de las Cosas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado_aprendizajes`
--

CREATE TABLE `resultado_aprendizajes` (
  `id` bigint(20) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `duracion_horas` int(11) DEFAULT 0,
  `intensidad_horaria` int(11) NOT NULL DEFAULT 0,
  `competencia_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultado_aprendizajes`
--

INSERT INTO `resultado_aprendizajes` (`id`, `codigo`, `descripcion`, `duracion_horas`, `intensidad_horaria`, `competencia_id`, `created_at`, `updated_at`) VALUES
(1, '1', 'aplicacion del lenguaje HTML, creacion e identificacion de las principales etiquetas del lenguaje', 200, 0, 2, '2024-10-08 12:59:15', '2024-10-08 12:59:15');

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
(2, 'instructor_lider', ''),
(3, 'instructor', ''),
(4, 'aprendiz', '');

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
('jGK6Ht0MXzGKv8ijkdjPw3PQ27gCH2kXvu1rHLK1', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRjRGR1poU3BFek43ZjFhelpVUlppY2pod1NpVDB5ZmNEem9RZDAySyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjYxOiJodHRwOi8vbG9jYWxob3N0L2xhcmF2ZWwvdHJhYmFqb19maW5hbC9wdWJsaWMvYWRtaW4vcHJvZ3JhbWFzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3MzAwNjM1NzI7fX0=', 1730067452);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ambiente`
--

CREATE TABLE `tipo_ambiente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_ambiente`
--

INSERT INTO `tipo_ambiente` (`id`, `nombre`) VALUES
(1, 'tecnología'),
(2, 'carnicería'),
(3, 'administrativo'),
(4, 'secretariado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 'eder', 'EDERLUISMESTRA9@GMAIL.COM', '2024-10-26 15:46:22', '$2y$12$u2KjrNYMYUTQLBG.Rw5OBuJrLVbue58Cpjv1Oep3JXVHKmeyap9l6', 'XoIqmlsFyO9Nn7dSJsZsTCCqxfXsDLcCHNMsX6shEprVf1RfhEjY9ELpsG38', 1, '2024-10-26 20:46:22', '2024-10-26 20:46:22'),
(2, 'LuiSunflower', 'luisa@gmail.com', '2024-10-26 18:19:24', '$2y$12$tzAbVHPgq0g394RjOFEsk.4zZToOeotsDU0MM/pi7mXzW7JGsCN76', 'OY6fncQydQJD5u2LYDbeuSjDrV3GwFPWalic4f3SwwM744caALUg30duABMt', 2, '2024-10-26 23:19:24', '2024-10-26 23:19:24'),
(3, 'Ruben', 'ruben@gmail.com', '2024-10-27 08:13:22', '$2y$12$qJrRIXwqYqVwk/K/xql6rOdqn3SqfkCHyZIMQgWDUKRf2gIkYpkna', 'MT9dn9eThcI5QcfAJu61Ywiz5P1SgXPXIi7XsgWJ7Qrj7q7DxdgrGJXQ7fB5', 3, '2024-10-27 13:13:22', '2024-10-27 13:13:22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaciones_diarias`
--
ALTER TABLE `asignaciones_diarias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_asignado` (`instructor_asignado`),
  ADD KEY `asignaciones_diarias_ibfk_1` (`programacion`),
  ADD KEY `asignaciones_diarias_ibfk_2` (`dia`);

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
-- Indices de la tabla `competencias`
--
ALTER TABLE `competencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dias`
--
ALTER TABLE `dias`
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
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`id_ficha`),
  ADD UNIQUE KEY `id_ficha` (`id_ficha`),
  ADD KEY `jornada` (`jornada`),
  ADD KEY `id_programa_formacion` (`id_programa_formacion`);

--
-- Indices de la tabla `grupo_sanguineos`
--
ALTER TABLE `grupo_sanguineos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tipo_sangre_id` (`tipo_sangre_id`),
  ADD KEY `tipo_contrato_id` (`tipo_contrato_id`);

--
-- Indices de la tabla `programaciones`
--
ALTER TABLE `programaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_asignante` (`instructor_asignante`),
  ADD KEY `ficha` (`ficha`),
  ADD KEY `programaciones_ibfk_1` (`ambiente`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id_recurso`);

--
-- Indices de la tabla `red_de_formacion`
--
ALTER TABLE `red_de_formacion`
  ADD PRIMARY KEY (`id_area_formacion`);

--
-- Indices de la tabla `resultado_aprendizajes`
--
ALTER TABLE `resultado_aprendizajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tipo_ambiente`
--
ALTER TABLE `tipo_ambiente`
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
-- AUTO_INCREMENT de la tabla `asignaciones_diarias`
--
ALTER TABLE `asignaciones_diarias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de la tabla `dias`
--
ALTER TABLE `dias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `jornadas`
--
ALTER TABLE `jornadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `programaciones`
--
ALTER TABLE `programaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones_diarias`
--
ALTER TABLE `asignaciones_diarias`
  ADD CONSTRAINT `asignaciones_diarias_ibfk_1` FOREIGN KEY (`programacion`) REFERENCES `programaciones` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asignaciones_diarias_ibfk_2` FOREIGN KEY (`dia`) REFERENCES `dias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `asignaciones_diarias_ibfk_3` FOREIGN KEY (`instructor_asignado`) REFERENCES `personas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD CONSTRAINT `fichas_ibfk_1` FOREIGN KEY (`jornada`) REFERENCES `jornadas` (`id`),
  ADD CONSTRAINT `fichas_ibfk_2` FOREIGN KEY (`id_programa_formacion`) REFERENCES `programas` (`id`);

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`tipo_sangre_id`) REFERENCES `grupo_sanguineos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `personas_ibfk_3` FOREIGN KEY (`tipo_contrato_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `programaciones`
--
ALTER TABLE `programaciones`
  ADD CONSTRAINT `programaciones_ibfk_1` FOREIGN KEY (`ambiente`) REFERENCES `ambientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `programaciones_ibfk_2` FOREIGN KEY (`instructor_asignante`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `programaciones_ibfk_3` FOREIGN KEY (`ficha`) REFERENCES `fichas` (`id_ficha`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
