-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-02-2026 a las 23:51:25
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
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `id` bigint UNSIGNED NOT NULL,
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie_numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `tipo_cambio` decimal(8,4) NOT NULL DEFAULT '0.0000' COMMENT 'Tipo de cambio usado al momento de la emisión',
  `estado` enum('BORRADOR','COMPLETADO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BORRADOR',
  `pago_estado` enum('UNPAID','PAID') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `forma_pago` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `tipo_venta` enum('CONTADO','CREDITO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CONTADO',
  `nota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  `unique_hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presupuestos_id` bigint UNSIGNED DEFAULT NULL,
  `clientes_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos_pagos`
--

CREATE TABLE `recibos_pagos` (
  `id` bigint UNSIGNED NOT NULL,
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie_numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `estado` enum('BORRADOR','COMPLETADO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BORRADOR',
  `pago_estado` enum('UNPAID','PAID') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `forma_pago` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `tipo_pago` enum('CONTADO','CREDITO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CONTADO',
  `nota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  `clientes_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `tipo_venta` enum('CONTADO','CREDITO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CONTADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_comprobante_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_operacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0101',
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_hora_emision` datetime DEFAULT NULL,
  `fecha_vencimiento` date NOT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_cambio` decimal(11,2) DEFAULT NULL,
  `metodo_pago_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_gratuitas` decimal(11,2) DEFAULT NULL,
  `igv_op` decimal(11,2) NOT NULL DEFAULT '0.00',
  `descuento` decimal(11,2) NOT NULL,
  `tipo_descuento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento_factor` decimal(11,5) DEFAULT NULL,
  `icbper` decimal(11,4) DEFAULT NULL,
  `sub_total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `igv` decimal(11,4) DEFAULT NULL,
  `adelanto` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `pago_anticipado` tinyint(1) NOT NULL DEFAULT '0',
  `numero_cuotas` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vence_cuotas` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detalle_cuotas` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `anulado` enum('si','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `resumen` enum('si','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `estado` enum('COMPLETADO','BORRADOR') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BORRADOR',
  `pago_estado` enum('UNPAID','PAID') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `forma_pago` enum('CONTADO','CREDITO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CONTADO',
  `fe_estado` tinyint(1) NOT NULL DEFAULT '0',
  `estado_texto` text COLLATE utf8mb4_unicode_ci,
  `fe_codigo_error` text COLLATE utf8mb4_unicode_ci,
  `fe_mensaje_error` text COLLATE utf8mb4_unicode_ci,
  `fe_mensaje_sunat` text COLLATE utf8mb4_unicode_ci,
  `nota` text COLLATE utf8mb4_unicode_ci,
  `nombre_xml` text COLLATE utf8mb4_unicode_ci,
  `nombre_cdr` text COLLATE utf8mb4_unicode_ci,
  `xml_base64` text COLLATE utf8mb4_unicode_ci,
  `cdr_base64` text COLLATE utf8mb4_unicode_ci,
  `hash` text COLLATE utf8mb4_unicode_ci,
  `hash_cdr` text COLLATE utf8mb4_unicode_ci,
  `code_sunat` text COLLATE utf8mb4_unicode_ci,
  `id_baja` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nota_credito_id` bigint UNSIGNED DEFAULT NULL,
  `nota_debito_id` bigint UNSIGNED DEFAULT NULL,
  `bienes_selva` tinyint(1) NOT NULL DEFAULT '0',
  `servicios_selva` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `clase` longtext COLLATE utf8mb4_unicode_ci,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `presupuestos_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recibos_empresa_id_foreign` (`empresa_id`),
  ADD KEY `recibos_presupuestos_id_foreign` (`presupuestos_id`),
  ADD KEY `recibos_clientes_id_foreign` (`clientes_id`),
  ADD KEY `recibos_user_id_foreign` (`user_id`),
  ADD KEY `recibos_forma_pago_foreign` (`forma_pago`);

--
-- Indices de la tabla `recibos_pagos`
--
ALTER TABLE `recibos_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recibos_pagos_empresa_id_foreign` (`empresa_id`),
  ADD KEY `recibos_pagos_clientes_id_foreign` (`clientes_id`),
  ADD KEY `recibos_pagos_user_id_foreign` (`user_id`),
  ADD KEY `recibos_pagos_forma_pago_foreign` (`forma_pago`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_tipo_comprobante_id_foreign` (`tipo_comprobante_id`),
  ADD KEY `ventas_cliente_id_foreign` (`cliente_id`),
  ADD KEY `ventas_metodo_pago_id_foreign` (`metodo_pago_id`),
  ADD KEY `ventas_user_id_foreign` (`user_id`),
  ADD KEY `ventas_nota_credito_id_foreign` (`nota_credito_id`),
  ADD KEY `ventas_nota_debito_id_foreign` (`nota_debito_id`),
  ADD KEY `ventas_empresa_id_foreign` (`empresa_id`),
  ADD KEY `ventas_presupuestos_id_foreign` (`presupuestos_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recibos_pagos`
--
ALTER TABLE `recibos_pagos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD CONSTRAINT `recibos_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recibos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recibos_forma_pago_foreign` FOREIGN KEY (`forma_pago`) REFERENCES `payment_method_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recibos_presupuestos_id_foreign` FOREIGN KEY (`presupuestos_id`) REFERENCES `presupuestos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recibos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `recibos_pagos`
--
ALTER TABLE `recibos_pagos`
  ADD CONSTRAINT `recibos_pagos_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recibos_pagos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recibos_pagos_forma_pago_foreign` FOREIGN KEY (`forma_pago`) REFERENCES `metodo_pago` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recibos_pagos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ventas_metodo_pago_id_foreign` FOREIGN KEY (`metodo_pago_id`) REFERENCES `payment_method_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_nota_credito_id_foreign` FOREIGN KEY (`nota_credito_id`) REFERENCES `nota_credito` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_nota_debito_id_foreign` FOREIGN KEY (`nota_debito_id`) REFERENCES `nota_debito` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_presupuestos_id_foreign` FOREIGN KEY (`presupuestos_id`) REFERENCES `presupuestos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ventas_tipo_comprobante_id_foreign` FOREIGN KEY (`tipo_comprobante_id`) REFERENCES `tipo_comprobantes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
