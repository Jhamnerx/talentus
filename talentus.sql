-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-02-2026 a las 04:37:07
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `talentus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

CREATE TABLE `lineas` (
  `id` bigint UNSIGNED NOT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operador` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_sim_card` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `estado` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `fecha_suspencion` timestamp NULL DEFAULT NULL,
  `date_to_suspend` timestamp NULL DEFAULT NULL,
  `baja` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sim_card`
--

CREATE TABLE `sim_card` (
  `id` bigint UNSIGNED NOT NULL,
  `sim_card` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lineas_id` bigint UNSIGNED DEFAULT NULL,
  `operador` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `estado` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` bigint UNSIGNED NOT NULL,
  `gpswox_id` bigint UNSIGNED DEFAULT NULL COMMENT 'ID del dispositivo en GPSWox',
  `placa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_instalacion` date DEFAULT NULL,
  `dispositivo_imei` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_imei` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sim_card_id` bigint UNSIGNED DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_sim_card` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clientes_id` bigint UNSIGNED DEFAULT NULL,
  `dispositivos_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `estado` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_dispositivos`
--

CREATE TABLE `vehiculos_dispositivos` (
  `id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `imei` text COLLATE utf8mb4_unicode_ci,
  `fecha_instalacion` date DEFAULT NULL,
  `fecha_desinstalacion` date DEFAULT NULL,
  `hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dispositivo_id` bigint UNSIGNED DEFAULT NULL,
  `is_principal` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lineas_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `sim_card`
--
ALTER TABLE `sim_card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sim_card_sim_card_unique` (`sim_card`),
  ADD KEY `sim_card_lineas_id_foreign` (`lineas_id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehiculos_numero_unique` (`numero`),
  ADD KEY `vehiculos_clientes_id_foreign` (`clientes_id`),
  ADD KEY `vehiculos_dispositivos_id_foreign` (`dispositivos_id`),
  ADD KEY `vehiculos_sim_card_id_foreign` (`sim_card_id`),
  ADD KEY `vehiculos_empresa_id_foreign` (`empresa_id`),
  ADD KEY `vehiculos_gpswox_id_index` (`gpswox_id`);

--
-- Indices de la tabla `vehiculos_dispositivos`
--
ALTER TABLE `vehiculos_dispositivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculos_dispositivos_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `vehiculos_dispositivos_dispositivo_id_foreign` (`dispositivo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lineas`
--
ALTER TABLE `lineas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sim_card`
--
ALTER TABLE `sim_card`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vehiculos_dispositivos`
--
ALTER TABLE `vehiculos_dispositivos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD CONSTRAINT `lineas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `sim_card`
--
ALTER TABLE `sim_card`
  ADD CONSTRAINT `sim_card_lineas_id_foreign` FOREIGN KEY (`lineas_id`) REFERENCES `lineas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehiculos_dispositivos_id_foreign` FOREIGN KEY (`dispositivos_id`) REFERENCES `dispositivos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehiculos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehiculos_sim_card_id_foreign` FOREIGN KEY (`sim_card_id`) REFERENCES `sim_card` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `vehiculos_dispositivos`
--
ALTER TABLE `vehiculos_dispositivos`
  ADD CONSTRAINT `vehiculos_dispositivos_dispositivo_id_foreign` FOREIGN KEY (`dispositivo_id`) REFERENCES `dispositivos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehiculos_dispositivos_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
