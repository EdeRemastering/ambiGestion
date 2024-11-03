-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2024 a las 05:20:21
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
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `horas_asignadas` int(11) DEFAULT NULL,
  `horas_restantes` int(11) DEFAULT NULL,
  `estado` enum('programado','en_curso','completado') NOT NULL DEFAULT 'programado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ambiente_programacions`
--

INSERT INTO `ambiente_programacions` (`id`, `ambiente_id`, `ficha_id`, `jornada_id`, `competencia_id`, `persona_id`, `fecha`, `hora_inicio`, `hora_fin`, `horas_asignadas`, `horas_restantes`, `estado`, `created_at`, `updated_at`) VALUES
(524645, 93243, 3, 2, 5, 17, '2024-10-29', '13:00:00', '19:00:00', 6, 194, 'programado', '2024-10-29 22:30:04', '2024-10-29 22:30:04'),
(524646, 93243, 3, 2, 5, 17, '2024-11-05', '13:00:00', '19:00:00', 6, 188, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524647, 93243, 3, 2, 5, 17, '2024-11-12', '13:00:00', '19:00:00', 6, 182, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524648, 93243, 3, 2, 5, 17, '2024-11-19', '13:00:00', '19:00:00', 6, 176, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524649, 93243, 3, 2, 5, 17, '2024-11-26', '13:00:00', '19:00:00', 6, 170, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524650, 93243, 3, 2, 5, 17, '2024-12-03', '13:00:00', '19:00:00', 6, 164, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524651, 93243, 3, 2, 5, 17, '2024-12-10', '13:00:00', '19:00:00', 6, 158, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524652, 93243, 3, 2, 5, 17, '2024-12-17', '13:00:00', '19:00:00', 6, 152, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524653, 93243, 3, 2, 5, 17, '2024-12-24', '13:00:00', '19:00:00', 6, 146, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524654, 93243, 3, 2, 5, 17, '2024-12-31', '13:00:00', '19:00:00', 6, 140, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524655, 93243, 3, 2, 5, 17, '2025-01-07', '13:00:00', '19:00:00', 6, 134, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524656, 93243, 3, 2, 5, 17, '2025-01-14', '13:00:00', '19:00:00', 6, 128, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524657, 93243, 3, 2, 5, 17, '2025-01-21', '13:00:00', '19:00:00', 6, 122, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524658, 93243, 3, 2, 5, 17, '2025-01-28', '13:00:00', '19:00:00', 6, 116, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524659, 93243, 3, 2, 5, 17, '2025-02-04', '13:00:00', '19:00:00', 6, 110, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524660, 93243, 3, 2, 5, 17, '2025-02-11', '13:00:00', '19:00:00', 6, 104, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524661, 93243, 3, 2, 5, 17, '2025-02-18', '13:00:00', '19:00:00', 6, 98, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524662, 93243, 3, 2, 5, 17, '2025-02-25', '13:00:00', '19:00:00', 6, 92, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524663, 93243, 3, 2, 5, 17, '2025-03-04', '13:00:00', '19:00:00', 6, 86, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524664, 93243, 3, 2, 5, 17, '2025-03-11', '13:00:00', '19:00:00', 6, 80, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524665, 93243, 3, 2, 5, 17, '2025-03-18', '13:00:00', '19:00:00', 6, 74, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524666, 93243, 3, 2, 5, 17, '2025-03-25', '13:00:00', '19:00:00', 6, 68, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524667, 93243, 3, 2, 5, 17, '2025-04-01', '13:00:00', '19:00:00', 6, 62, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524668, 93243, 3, 2, 5, 17, '2025-04-08', '13:00:00', '19:00:00', 6, 56, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524669, 93243, 3, 2, 5, 17, '2025-04-15', '13:00:00', '19:00:00', 6, 50, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524670, 93243, 3, 2, 5, 17, '2025-04-22', '13:00:00', '19:00:00', 6, 44, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524671, 93243, 3, 2, 5, 17, '2025-04-29', '13:00:00', '19:00:00', 6, 38, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524672, 93243, 3, 2, 5, 17, '2025-05-06', '13:00:00', '19:00:00', 6, 32, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524673, 93243, 3, 2, 5, 17, '2025-05-13', '13:00:00', '19:00:00', 6, 26, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524674, 93243, 3, 2, 5, 17, '2025-05-20', '13:00:00', '19:00:00', 6, 20, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524675, 93243, 3, 2, 5, 17, '2025-05-27', '13:00:00', '19:00:00', 6, 14, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524676, 93243, 3, 2, 5, 17, '2025-06-03', '13:00:00', '19:00:00', 6, 8, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524677, 93243, 3, 2, 5, 17, '2025-06-10', '13:00:00', '19:00:00', 6, 2, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524678, 93243, 3, 2, 5, 17, '2025-06-17', '13:00:00', '19:00:00', 2, 0, 'programado', '2024-10-29 22:32:49', '2024-10-29 22:32:49'),
(524679, 93243, 3, 2, 6, 23, '2024-10-30', '13:00:00', '19:00:00', 6, 194, 'programado', '2024-10-29 22:37:06', '2024-10-29 22:37:06'),
(524680, 93243, 3, 2, 6, 23, '2024-11-06', '13:00:00', '19:00:00', 6, 188, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524681, 93243, 3, 2, 6, 23, '2024-11-13', '13:00:00', '19:00:00', 6, 182, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524682, 93243, 3, 2, 6, 23, '2024-11-20', '13:00:00', '19:00:00', 6, 176, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524683, 93243, 3, 2, 6, 23, '2024-11-27', '13:00:00', '19:00:00', 6, 170, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524684, 93243, 3, 2, 6, 23, '2024-12-04', '13:00:00', '19:00:00', 6, 164, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524685, 93243, 3, 2, 6, 23, '2024-12-11', '13:00:00', '19:00:00', 6, 158, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524686, 93243, 3, 2, 6, 23, '2024-12-18', '13:00:00', '19:00:00', 6, 152, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524687, 93243, 3, 2, 6, 23, '2024-12-25', '13:00:00', '19:00:00', 6, 146, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524688, 93243, 3, 2, 6, 23, '2025-01-01', '13:00:00', '19:00:00', 6, 140, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524689, 93243, 3, 2, 6, 23, '2025-01-08', '13:00:00', '19:00:00', 6, 134, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524690, 93243, 3, 2, 6, 23, '2025-01-15', '13:00:00', '19:00:00', 6, 128, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524691, 93243, 3, 2, 6, 23, '2025-01-22', '13:00:00', '19:00:00', 6, 122, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524692, 93243, 3, 2, 6, 23, '2025-01-29', '13:00:00', '19:00:00', 6, 116, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524693, 93243, 3, 2, 6, 23, '2025-02-05', '13:00:00', '19:00:00', 6, 110, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524694, 93243, 3, 2, 6, 23, '2025-02-12', '13:00:00', '19:00:00', 6, 104, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524695, 93243, 3, 2, 6, 23, '2025-02-19', '13:00:00', '19:00:00', 6, 98, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524696, 93243, 3, 2, 6, 23, '2025-02-26', '13:00:00', '19:00:00', 6, 92, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524697, 93243, 3, 2, 6, 23, '2025-03-05', '13:00:00', '19:00:00', 6, 86, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524698, 93243, 3, 2, 6, 23, '2025-03-12', '13:00:00', '19:00:00', 6, 80, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524699, 93243, 3, 2, 6, 23, '2025-03-19', '13:00:00', '19:00:00', 6, 74, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524700, 93243, 3, 2, 6, 23, '2025-03-26', '13:00:00', '19:00:00', 6, 68, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524701, 93243, 3, 2, 6, 23, '2025-04-02', '13:00:00', '19:00:00', 6, 62, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524702, 93243, 3, 2, 6, 23, '2025-04-09', '13:00:00', '19:00:00', 6, 56, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524703, 93243, 3, 2, 6, 23, '2025-04-16', '13:00:00', '19:00:00', 6, 50, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524704, 93243, 3, 2, 6, 23, '2025-04-23', '13:00:00', '19:00:00', 6, 44, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524705, 93243, 3, 2, 6, 23, '2025-04-30', '13:00:00', '19:00:00', 6, 38, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524706, 93243, 3, 2, 6, 23, '2025-05-07', '13:00:00', '19:00:00', 6, 32, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524707, 93243, 3, 2, 6, 23, '2025-05-14', '13:00:00', '19:00:00', 6, 26, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524708, 93243, 3, 2, 6, 23, '2025-05-21', '13:00:00', '19:00:00', 6, 20, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524709, 93243, 3, 2, 6, 23, '2025-05-28', '13:00:00', '19:00:00', 6, 14, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524710, 93243, 3, 2, 6, 23, '2025-06-04', '13:00:00', '19:00:00', 6, 8, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524711, 93243, 3, 2, 6, 23, '2025-06-11', '13:00:00', '19:00:00', 6, 2, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524712, 93243, 3, 2, 6, 23, '2025-06-18', '13:00:00', '19:00:00', 2, 0, 'programado', '2024-10-29 22:37:48', '2024-10-29 22:37:48'),
(524713, 93244, 4, 1, 7, 23, '2024-10-29', '07:00:00', '13:00:00', 6, 44, 'programado', '2024-10-29 22:51:09', '2024-10-29 22:51:09'),
(524714, 93244, 4, 1, 7, 23, '2024-11-05', '07:00:00', '13:00:00', 6, 38, 'programado', '2024-10-29 22:51:24', '2024-10-29 22:51:24'),
(524715, 93244, 4, 1, 7, 23, '2024-11-12', '07:00:00', '13:00:00', 6, 32, 'programado', '2024-10-29 22:51:24', '2024-10-29 22:51:24'),
(524716, 93244, 4, 1, 7, 23, '2024-11-19', '07:00:00', '13:00:00', 6, 26, 'programado', '2024-10-29 22:51:24', '2024-10-29 22:51:24'),
(524717, 93244, 4, 1, 7, 23, '2024-11-26', '07:00:00', '13:00:00', 6, 20, 'programado', '2024-10-29 22:51:24', '2024-10-29 22:51:24'),
(524718, 93244, 4, 1, 7, 23, '2024-12-03', '07:00:00', '13:00:00', 6, 14, 'programado', '2024-10-29 22:51:24', '2024-10-29 22:51:24'),
(524719, 93244, 4, 1, 7, 23, '2024-12-10', '07:00:00', '13:00:00', 6, 8, 'programado', '2024-10-29 22:51:24', '2024-10-29 22:51:24'),
(524720, 93244, 4, 1, 7, 23, '2024-12-17', '07:00:00', '13:00:00', 6, 2, 'programado', '2024-10-29 22:51:24', '2024-10-29 22:51:24'),
(524721, 93244, 4, 1, 7, 23, '2024-12-24', '07:00:00', '13:00:00', 2, 0, 'programado', '2024-10-29 22:51:24', '2024-10-29 22:51:24');

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
-- Estructura de tabla para la tabla `estados_novedad`
--

CREATE TABLE `estados_novedad` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `nombre` varchar(255) NOT NULL,
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

INSERT INTO `fichas` (`id`, `codigo_ficha`, `nombre`, `fecha_inicio`, `fecha_fin`, `fecha_fin_lectiva`, `fecha_inicio_practica`, `hora_entrada`, `hora_salida`, `programa_formacion_id`, `red_conocimiento_id`, `jornada_id`, `created_at`, `updated_at`) VALUES
(3, '2673033', 'ADSO', '2023-01-23', '2025-04-23', '2024-10-23', '2024-10-24', '13:00:00', '19:00:00', 5, 3, 2, '2024-10-22 20:28:49', '2024-10-22 20:28:49'),
(4, '2673007', 'ADSI', '2024-09-29', '2026-09-29', '2026-03-29', '2026-03-30', '07:00:00', '13:00:00', 6, 3, 1, '2024-10-29 22:50:17', '2024-10-29 22:50:17');

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
(17, '2024_10_23_041026_create_competencia_instructor_table', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades`
--

CREATE TABLE `novedades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(8, '8437347', 'Luis', 'Carlos', 'Correa', 'Arrieta', '3012481020', 'pcapacho24@gmail.com', 'Carrera 112a # 90a-10', 7, 1, NULL, '2024-10-01 20:35:29', '2024-10-08 03:49:40', 10),
(12, '1028038615', 'Sebastian', NULL, 'Montiel', 'Espinosa', '3117887100', 'montiieel3@gmail.com', 'Barrio Nueva Civilizacion', 7, 1, '2673033', '2024-10-01 23:13:27', '2024-10-28 07:21:02', 12),
(13, '1040373102', 'jhonny', 'javier', 'mosquera', 'moreno', '3008825320', 'jhonnymosquera16@gmail.com', 'pepe', 7, 1, '2673033', '2024-10-01 23:54:35', '2024-10-28 07:21:15', 13),
(14, '1045492185', 'daniela', NULL, 'gomez', 'usuga', '3184998526', 'daniela@gmail.com', 'salvador', 7, 1, '2673033', '2024-10-02 01:18:59', '2024-10-28 07:21:38', 14),
(15, '1027950562', 'Jair', 'Stiven', 'Martinez', 'Palacios', '3227469143', 'mjairstiven@gmail.com', 'CAA83-06', 7, 1, '2673033', '2024-10-02 03:26:08', '2024-10-28 07:21:52', 15),
(16, '1038805081', 'Sandra', 'Miladys', 'Mora', 'Benitez', '3502768415', 'sandmorbe@gmail.com', 'Carrera 112a # 90a-10 11', 7, 1, '2673033', '2024-10-05 09:53:21', '2024-10-28 07:22:06', 16),
(17, '108827194', 'cindy', 'johanna', 'gualtero', NULL, '3145135853', 'cjgualtero@sena.edu.co', 'mz 3 c 1', 1, 1, NULL, '2024-10-08 03:15:29', '2024-10-08 03:15:29', 17),
(18, '1027', 'alexandra', 'yuliet', 'torres', 'viloria', '322', 'ale@gmail.com', 'porvenkr', 1, NULL, '2673033', '2024-10-08 23:43:44', '2024-10-28 07:22:18', 19),
(20, '1037134640', 'andres', 'camilo', 'acosta', 'correa', '3502768415', 'pcapacho24@hotmail.com', 'Carrera 112a # 90a-10', 7, NULL, '2673033', '2024-10-13 10:54:01', '2024-10-28 07:22:33', 24),
(21, '8456874', 'andres', 'manuel', 'romero', 'castro', '3214568787', 'pcapacho25@gmail.com', 'calle66', 6, NULL, '2673033', '2024-10-14 05:45:09', '2024-10-28 07:22:52', 25),
(22, '123458745', 'luis', 'Carlos', 'mosquera', 'Cordoba', '3214569898', 'luiscarlosc@gmail.com', 'Carrera 112a # 90a-10', 7, NULL, '2673033', '2024-10-22 20:30:41', '2024-10-22 20:30:41', 26),
(23, '123587469', 'manuela', NULL, 'Mora', 'nia', '3214569797', 'manuelas4@gmail.com', 'CRR 105 # 102-24', 7, 2, NULL, '2024-10-22 20:42:32', '2024-10-22 20:42:32', 27);

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
  `id_ambiente` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(8, '2', 'creacion de pagina html, css y js', 50, 5, '2024-10-28 07:00:17', '2024-10-28 08:00:42', 0),
(9, '3', 'etiquetado html', 50, 5, '2024-10-28 07:01:49', '2024-10-28 07:02:01', 1),
(10, '4', 'stylos css', 50, 5, '2024-10-28 07:02:35', '2024-10-28 07:02:48', 1),
(11, '5', 'javascript', 50, 5, '2024-10-28 07:03:32', '2024-10-28 08:00:42', 1);

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
('TGohcm8hAHTQYf6cZrzaYA4KOeAaeXgfwjYScXJU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmxuNFozQ2FXNzEyQzROQWpoaXJoWEZmUnNFRlRqNXFVOENYOXVpbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHA6Ly9zZ3BhYzIudGVzdCI7fX0=', 1730261904);

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
(10, 'Luis Carlos Correa Arrieta', 'pcapacho24@gmail.com', NULL, '$2y$12$/qQSAk4ptfySwchPFcBj1.Wob0EcDaZVpZZknpCx.cMecx5ant7ta', NULL, 1, '2024-10-01 20:34:50', '2024-10-02 03:09:34'),
(11, 'juaco', 'juaco@gmail.com', NULL, '$2y$12$Pd5leTLwRG5GLHhdgIQuJO7bMSdf3Om9gRpAcQhq4PZuysimxl09q', NULL, 3, '2024-10-01 23:00:50', '2024-10-01 23:00:50'),
(12, 'Sebastian Montiel', 'montiieel3@gmail.com', NULL, '$2y$12$PyT4Rg89rGVcAdgyd2bjSeKosA95jM6AsmbtZDdjTMQ8/NgusHiwK', NULL, 3, '2024-10-01 23:09:42', '2024-10-28 07:21:02'),
(13, 'jhonny mosquera', 'jhonnymosquera16@gmail.com', NULL, '$2y$12$0xw0LzvTZD5ZSItgXF96IuCjYFKc1KxXRtOmA26.o1BeVv1V3bXjm', NULL, 3, '2024-10-01 23:52:54', '2024-10-01 23:52:54'),
(14, 'daniela gomez', 'daniela@gmail.com', NULL, '$2y$12$F4o.sAuKmCn3tAZuOsSBSeU1skw.8XS.FOYYPJ/XkIjr39u0s.6By', NULL, 3, '2024-10-02 01:18:59', '2024-10-28 07:21:38'),
(15, 'Jair Martinez', 'mjairstiven@gmail.com', NULL, '$2y$12$ICNuu4zHmUfIMi9KAMWjwuS35HpNDrbXjO9DU8QK8BLUxeaqDyk.a', NULL, 3, '2024-10-02 03:26:08', '2024-10-28 07:21:52'),
(16, 'Sandra Mora', 'sandmorbe@gmail.com', NULL, '$2y$12$vwDj70EshPXcYnuPKeBr7uDTLAEK5M8rJrNourii/gRk2Av6LnYGe', NULL, 3, '2024-10-05 09:53:21', '2024-10-13 18:34:07'),
(17, 'cindy gualtero', 'cjgualtero@sena.edu.co', NULL, '$2y$12$8R61meaTq5m/whAGt8BuIO56wqGzDAL2JNdD/HFDj.K7I9uiHYFgW', NULL, 2, '2024-10-08 03:15:29', '2024-10-28 06:35:37'),
(19, 'alexandra torres', 'ale@gmail.com', NULL, '$2y$12$oFazcT/EO9XUBdG6amoPKOgiKwglHsMSI.oc7Dd4oRDeeGmyHWNpW', NULL, 3, '2024-10-08 23:43:44', '2024-10-28 07:22:18'),
(24, 'andres acosta', 'pcapacho24@hotmail.com', NULL, '$2y$12$3h2kNft9SH1ciAP3E4Xz/OVOn3OAXv7rJP0NjZcGZc3rGFti.7sky', NULL, 3, '2024-10-13 10:54:01', '2024-10-28 07:22:33'),
(25, 'andres romero', 'pcapacho25@gmail.com', NULL, '$2y$12$sDPdwkVmEqrJABzpkXW3EemwwtjniAA/AjPsFm8u3P7ffk9BIr/N.', NULL, 3, '2024-10-14 05:45:09', '2024-10-28 07:22:52'),
(26, 'lcCordoba', 'luiscarlosc@gmail.com', NULL, '$2y$12$Yf6BlCvppw29qkXMIUcYoep1xFVzE4f7P5iSnOcl2PwRxrI.pEqsW', NULL, 3, '2024-10-22 20:30:41', '2024-10-22 20:30:41'),
(27, 'manuela Mora', 'manuelas4@gmail.com', NULL, '$2y$12$l/9HMHBJjy84kYGB5.eC9OtXxAS7ajn59AjZFpzcC1ZPa8VWAqZvq', NULL, 2, '2024-10-22 20:42:32', '2024-10-22 22:02:45');

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
  ADD KEY `ambiente_programacions_persona_id_foreign` (`persona_id`);

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
-- Indices de la tabla `estados_novedad`
--
ALTER TABLE `estados_novedad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_ambiente`
--
ALTER TABLE `estado_ambiente`
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
  ADD KEY `fichas_red_conocimiento_id_foreign` (`red_conocimiento_id`);

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
-- Indices de la tabla `novedades`
--
ALTER TABLE `novedades`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=524722;

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
-- AUTO_INCREMENT de la tabla `estados_novedad`
--
ALTER TABLE `estados_novedad`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_ambiente`
--
ALTER TABLE `estado_ambiente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `novedades`
--
ALTER TABLE `novedades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `programa__formacions`
--
ALTER TABLE `programa__formacions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id_recurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32337;

--
-- AUTO_INCREMENT de la tabla `red_conocimientos`
--
ALTER TABLE `red_conocimientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `resultado_aprendizajes`
--
ALTER TABLE `resultado_aprendizajes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipo_ambientes`
--
ALTER TABLE `tipo_ambientes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  ADD CONSTRAINT `fichas_jornada_id_foreign` FOREIGN KEY (`jornada_id`) REFERENCES `jornadas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fichas_programa_formacion_id_foreign` FOREIGN KEY (`programa_formacion_id`) REFERENCES `programa__formacions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fichas_red_conocimiento_id_foreign` FOREIGN KEY (`red_conocimiento_id`) REFERENCES `red_conocimientos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `instructor_red_conocimiento`
--
ALTER TABLE `instructor_red_conocimiento`
  ADD CONSTRAINT `instructor_red_conocimiento_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `instructor_red_conocimiento_red_conocimiento_id_foreign` FOREIGN KEY (`red_conocimiento_id`) REFERENCES `red_conocimientos` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
