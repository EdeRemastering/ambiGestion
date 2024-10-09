-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2024 a las 20:49:27
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
-- Base de datos: `proyecto_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambientes`
--

CREATE TABLE `ambientes` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `descripcion` varchar(100) NOT NULL,
  `tipo` int(11) NOT NULL,
  `estado` int(11) DEFAULT NULL,
  `red_de_conocimiento` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ambientes`
--

INSERT INTO `ambientes` (`id`, `numero`, `alias`, `capacidad`, `descripcion`, `tipo`, `estado`, `red_de_conocimiento`, `created_at`, `updated_at`) VALUES
(12, 3242, 'Taller IoT', 25, 'ñalsdjfñlasjdfñlaskdjfalkñfaslñdkf jañsdlkfjalsñdkfjañsldkfjañslkdfjañs lkdfjañlskdjfñalksd', 1, 1, 1, '2024-10-07 14:12:38', '2024-10-07 19:12:38'),
(1032, 32434, 'Sala de IA', 15, 'ñ', 1, 4, 1, '2024-10-05 21:38:41', '2024-10-06 02:38:41'),
(1143, 134234, 'Aula Blockchain', 30, 'cagada', 1, 3, 1, '2024-10-04 15:36:35', '2024-10-04 20:36:35'),
(5325, 12341423, 'Sala de Informática 2', 25, '', 1, 1, 1, '2024-10-01 20:15:32', NULL),
(6324, 14231, 'Aula 2023', 30, 'el mejor ()', 1, 1, 1, '2024-09-22 21:13:32', '2024-09-23 02:13:32'),
(8233, 41214, 'Sala de Videoconferencias', 20, 'jl', 1, 1, 1, '2024-10-07 16:42:02', '2024-10-07 21:42:02'),
(20032, 143223, 'biligüismo', 10, '', 1, 1, 1, '2024-10-01 20:15:32', NULL),
(93232, 14213, 'Laboratorio de Cloud', 20, '', 1, 1, 1, '2024-10-01 20:15:32', NULL),
(93239, 223, 'asdfaf', 32, 'asdf', 1, 1, 1, '2024-10-07 02:52:13', '2024-10-07 02:52:13'),
(93240, 23, 'aljsd', 32, 'lajkds', 1, 1, 1, '2024-10-07 02:52:27', '2024-10-07 02:52:27'),
(93241, 32, 'adsf', 32, 'ladsfj', 1, 1, 1, '2024-10-07 02:52:40', '2024-10-07 02:52:40');

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
-- Estructura de tabla para la tabla `competencias`
--

CREATE TABLE `competencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `programa_formacion_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `descripcion` varchar(256) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL,
  `fecha_solucion` timestamp NULL DEFAULT NULL,
  `descripcion_solucion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `novedad`
--

INSERT INTO `novedad` (`id`, `nombre`, `descripcion`, `fecha_registro`, `estado`, `fecha_solucion`, `descripcion_solucion`) VALUES
(1, 'pc dañado', 'se daño porque un niño lo golpfadseo', '2024-09-26 18:04:49', 1, NULL, ''),
(2, 'pc dañado', 'ruben lo patió', '2024-10-01 19:40:55', 1, NULL, ''),
(8, 'eder', 'dsfa', '2024-10-06 06:28:38', 1, NULL, ''),
(9, 'lkjkfas', 'aoksdfj', '2024-10-06 15:51:00', 6, NULL, '');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `documento`, `pnombre`, `snombre`, `papellido`, `sapellido`, `telefono`, `correo`, `direccion`, `tipo_sangre_id`, `tipo_contrato_id`, `created_at`, `updated_at`, `user_id`) VALUES
(8, '8437347', 'Luis', 'Carlos', 'Correa', 'Arrieta', '3012481020', 'pcapacho24@gmail.com', 'Carrera 112a # 90a-10', 7, 1, '2024-10-01 20:35:29', '2024-10-08 03:49:40', 10),
(12, '1028038615', 'Sebastian', NULL, 'Montiel', 'Espinosa', '3117887100', 'montiieel3@gmail.com', 'Barrio Nueva Civilizacion', 7, 1, '2024-10-01 23:13:27', '2024-10-01 23:13:27', 12),
(13, '1040373102', 'jhonny', 'javier', 'mosquera', 'moreno', '3008825320', 'jhonnymosquera16@gmail.com', 'pepe', 7, 1, '2024-10-01 23:54:35', '2024-10-01 23:54:35', 13),
(14, '1045492185', 'daniela', NULL, 'gomez', 'usuga', '3184998526', 'daniela@gmail.com', 'salvador', 7, 1, '2024-10-02 01:18:59', '2024-10-02 01:18:59', 14),
(17, '108827194', 'cindy', 'johanna', 'gualtero', NULL, '3145135853', 'cjgualtero@sena.edu.co', 'mz 3 c 1', 1, 1, '2024-10-08 03:15:29', '2024-10-08 03:15:29', 17);

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `programa__formacions`
--

INSERT INTO `programa__formacions` (`id`, `nombre`, `codigo`, `version`, `descripcion`, `duracion_meses`, `created_at`, `updated_at`) VALUES
(3, 'ANALISIS Y DESARROLLO DE SOFTWARE', '2673033', '2024', 'titulada', 27, '2024-10-08 12:19:04', '2024-10-08 12:19:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id_recurso` int(11) NOT NULL,
  `id_ambiente` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`id_recurso`, `id_ambiente`, `descripcion`, `fecha_registro`, `estado`) VALUES
(32333, 12, 'Cluster de GPUs para IA', '2024-09-21 05:00:00', 1),
(32334, 12, 'Nodos blockchain de prueba', '2024-09-22 05:00:00', 1),
(32335, 12, 'Kit de desarrollo IoT', '2024-09-23 05:00:00', 1),
(32336, 12, 'fulala', '2024-10-08 01:32:19', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `red_de_formacion`
--

CREATE TABLE `red_de_formacion` (
  `id_area_formacion` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `intensidad_horaria` int(11) NOT NULL,
  `competencia_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `resultado_aprendizajes`
--

INSERT INTO `resultado_aprendizajes` (`id`, `codigo`, `descripcion`, `intensidad_horaria`, `competencia_id`, `created_at`, `updated_at`) VALUES
(1, '1', 'aplicacion del lenguaje HTML, creacion e identificacion de las principales etiquetas del lenguaje', 15, 2, '2024-10-08 12:59:15', '2024-10-08 12:59:15');

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
('x6uUyZaciMoQW0HWykATT2xlHa34vTxpKSei5Cce', 10, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVU15dGZydmNiMmhBd0FuUlFyaGtmcWRpeGsyd1Z2eDA1N2dFTXVmZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHA6Ly9sb2NhbGhvc3QvbGFyYXZlbC90cmFiYWpvX2ZpbmFsL3B1YmxpYy9hZG1pbi9hbWJpZW50ZXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3Mjg0OTIwMjg7fX0=', 1728499501);

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
-- Estructura de tabla para la tabla `tipo_contratos`
--

CREATE TABLE `tipo_contratos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role_id`, `created_at`, `updated_at`) VALUES
(10, 'Luis Carlos Correa Arrieta', 'pcapacho24@gmail.com', NULL, '$2y$12$/qQSAk4ptfySwchPFcBj1.Wob0EcDaZVpZZknpCx.cMecx5ant7ta', 'lGAV2j2ILAniipUniv0WUtqkbGeLfk1fy1ajlnPkLcJ4ciFyGpi0EbWiAgRd', 1, '2024-10-01 20:34:50', '2024-10-02 03:09:34'),
(11, 'juaco', 'juaco@gmail.com', NULL, '$2y$12$Pd5leTLwRG5GLHhdgIQuJO7bMSdf3Om9gRpAcQhq4PZuysimxl09q', NULL, 3, '2024-10-01 23:00:50', '2024-10-01 23:00:50'),
(12, 'Sebastian', 'montiieel3@gmail.com', NULL, '$2y$12$PyT4Rg89rGVcAdgyd2bjSeKosA95jM6AsmbtZDdjTMQ8/NgusHiwK', NULL, 3, '2024-10-01 23:09:42', '2024-10-02 03:14:40'),
(13, 'jhonny mosquera', 'jhonnymosquera16@gmail.com', NULL, '$2y$12$0xw0LzvTZD5ZSItgXF96IuCjYFKc1KxXRtOmA26.o1BeVv1V3bXjm', NULL, 3, '2024-10-01 23:52:54', '2024-10-01 23:52:54'),
(14, 'daniela', 'daniela@gmail.com', NULL, '$2y$12$F4o.sAuKmCn3tAZuOsSBSeU1skw.8XS.FOYYPJ/XkIjr39u0s.6By', NULL, 3, '2024-10-02 01:18:59', '2024-10-02 01:18:59'),
(15, 'Jair', 'mjairstiven@gmail.com', NULL, '$2y$12$ICNuu4zHmUfIMi9KAMWjwuS35HpNDrbXjO9DU8QK8BLUxeaqDyk.a', NULL, 3, '2024-10-02 03:26:08', '2024-10-02 03:27:14'),
(16, 'sandra miladys mora benitez', 'sandmorbe@gmail.com', NULL, '$2y$12$4uLlCs84qiiGvR0FRqNgvOuyql/fh.Ng2ow9bILZ8w0126fZdUqN2', NULL, 3, '2024-10-05 09:53:21', '2024-10-05 09:53:21'),
(17, 'cindy johanna gualtero', 'cjgualtero@sena.edu.co', NULL, '$2y$12$8R61meaTq5m/whAGt8BuIO56wqGzDAL2JNdD/HFDj.K7I9uiHYFgW', NULL, 2, '2024-10-08 03:15:29', '2024-10-08 03:15:29'),
(19, 'alexandra', 'ale@gmail.com', NULL, '$2y$12$oFazcT/EO9XUBdG6amoPKOgiKwglHsMSI.oc7Dd4oRDeeGmyHWNpW', NULL, 3, '2024-10-08 23:43:44', '2024-10-08 23:43:44');

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
  ADD KEY `estado` (`estado`),
  ADD KEY `s` (`red_de_conocimiento`),
  ADD KEY `tipo` (`tipo`),
  ADD KEY `tipo_2` (`tipo`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `competencias_codigo_unique` (`codigo`),
  ADD KEY `competencias_programa_formacion_id_foreign` (`programa_formacion_id`);

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
-- Indices de la tabla `grupo_sanguineos`
--
ALTER TABLE `grupo_sanguineos`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `novedad`
--
ALTER TABLE `novedad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado_novedad` (`estado`);

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
  ADD KEY `personas_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `programa__formacions`
--
ALTER TABLE `programa__formacions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `programa__formacions_codigo_unique` (`codigo`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id_recurso`),
  ADD KEY `id_ambiente` (`id_ambiente`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `red_de_formacion`
--
ALTER TABLE `red_de_formacion`
  ADD PRIMARY KEY (`id_area_formacion`);

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
-- Indices de la tabla `tipo_ambiente`
--
ALTER TABLE `tipo_ambiente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_contratos`
--
ALTER TABLE `tipo_contratos`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93242;

--
-- AUTO_INCREMENT de la tabla `competencias`
--
ALTER TABLE `competencias`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `estado_novedad`
--
ALTER TABLE `estado_novedad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `estado_recurso`
--
ALTER TABLE `estado_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo_sanguineos`
--
ALTER TABLE `grupo_sanguineos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `novedad`
--
ALTER TABLE `novedad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `programa__formacions`
--
ALTER TABLE `programa__formacions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id_recurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32337;

--
-- AUTO_INCREMENT de la tabla `resultado_aprendizajes`
--
ALTER TABLE `resultado_aprendizajes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_ambiente`
--
ALTER TABLE `tipo_ambiente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_contratos`
--
ALTER TABLE `tipo_contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ambientes`
--
ALTER TABLE `ambientes`
  ADD CONSTRAINT `ambientes_ibfk_1` FOREIGN KEY (`estado`) REFERENCES `estado_ambiente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ambientes_ibfk_2` FOREIGN KEY (`tipo`) REFERENCES `tipo_ambiente` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `competencias`
--
ALTER TABLE `competencias`
  ADD CONSTRAINT `competencias_programa_formacion_id_foreign` FOREIGN KEY (`programa_formacion_id`) REFERENCES `programa__formacions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `novedad`
--
ALTER TABLE `novedad`
  ADD CONSTRAINT `novedad_ibfk_1` FOREIGN KEY (`estado`) REFERENCES `estado_novedad` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_tipo_contrato_id_foreign` FOREIGN KEY (`tipo_contrato_id`) REFERENCES `contratos` (`id`),
  ADD CONSTRAINT `personas_tipo_sangre_id_foreign` FOREIGN KEY (`tipo_sangre_id`) REFERENCES `grupo_sanguineos` (`id`),
  ADD CONSTRAINT `personas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD CONSTRAINT `recurso_ibfk_1` FOREIGN KEY (`id_ambiente`) REFERENCES `ambientes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recurso_ibfk_2` FOREIGN KEY (`estado`) REFERENCES `estado_recurso` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `resultado_aprendizajes`
--
ALTER TABLE `resultado_aprendizajes`
  ADD CONSTRAINT `resultado_aprendizajes_competencia_id_foreign` FOREIGN KEY (`competencia_id`) REFERENCES `competencias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
