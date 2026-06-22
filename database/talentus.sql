-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-06-2026 a las 17:32:33
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
-- Estructura de tabla para la tabla `actas`
--

CREATE TABLE `actas` (
  `id` bigint UNSIGNED NOT NULL,
  `vehiculos_id` bigint UNSIGNED DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_instalacion` date DEFAULT NULL,
  `inicio_cobertura` date DEFAULT NULL,
  `fin_cobertura` date DEFAULT NULL,
  `fecha` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` year DEFAULT NULL,
  `sello` tinyint(1) NOT NULL DEFAULT '1',
  `fondo` tinyint(1) NOT NULL DEFAULT '1',
  `plataforma` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `ciudades_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anticipos_ventas`
--

CREATE TABLE `anticipos_ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `venta_id` bigint UNSIGNED DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `serie_correlativo_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_comprobante_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_venta_ref` decimal(12,4) DEFAULT NULL,
  `igv` decimal(12,4) DEFAULT NULL,
  `total_invoice_ref` decimal(12,4) DEFAULT NULL,
  `codigo_anticipo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `factor_anticipo` decimal(12,2) DEFAULT NULL,
  `fecha_emision_ref` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_states`
--

CREATE TABLE `auth_states` (
  `session` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autoreplies`
--

CREATE TABLE `autoreplies` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `device` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_keyword` enum('Equal','Contain') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Equal',
  `type` enum('text','image') COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `reply_when` enum('Group','Personal','All') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'All',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_quoted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banks`
--

CREATE TABLE `banks` (
  `id` bigint UNSIGNED NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `bank_id` bigint UNSIGNED NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cci` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_type_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `initial_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `show_in_documents` tinyint(1) NOT NULL DEFAULT '1',
  `establishment_id` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blasts`
--

CREATE TABLE `blasts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `campaign_id` bigint UNSIGNED NOT NULL,
  `receiver` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `type` enum('text','button','image','template','list') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('failed','success','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambios_lineas`
--

CREATE TABLE `cambios_lineas` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_cambio` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sim_card_id` bigint UNSIGNED DEFAULT NULL,
  `old_sim_card` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_numero` bigint UNSIGNED DEFAULT NULL,
  `new_numero` bigint UNSIGNED DEFAULT NULL,
  `fecha_suspencion` date DEFAULT NULL,
  `fecha_suspencion_fin` date DEFAULT NULL,
  `vehiculo_placa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_vehiculo_placa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonebook_id` bigint UNSIGNED NOT NULL,
  `delay` int NOT NULL DEFAULT '10',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('waiting','processing','failed','completed','paused') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `schedule` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `card_brands`
--

CREATE TABLE `card_brands` (
  `id` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cash`
--

CREATE TABLE `cash` (
  `id` bigint UNSIGNED NOT NULL,
  `saldo_inicial` decimal(12,2) NOT NULL DEFAULT '0.00',
  `saldo_inicial_pen` decimal(15,2) NOT NULL DEFAULT '0.00',
  `saldo_inicial_usd` decimal(15,2) NOT NULL DEFAULT '0.00',
  `saldo_actual` decimal(12,2) NOT NULL DEFAULT '0.00',
  `saldo_actual_pen` decimal(15,2) NOT NULL DEFAULT '0.00',
  `saldo_actual_usd` decimal(15,2) NOT NULL DEFAULT '0.00',
  `moneda` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `reference_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cash_documents`
--

CREATE TABLE `cash_documents` (
  `id` bigint UNSIGNED NOT NULL,
  `cash_id` bigint UNSIGNED NOT NULL,
  `factura_id` bigint UNSIGNED DEFAULT NULL,
  `recibo_id` bigint UNSIGNED DEFAULT NULL,
  `venta_id` bigint UNSIGNED DEFAULT NULL,
  `expense_payment_id` bigint UNSIGNED DEFAULT NULL,
  `compra_id` bigint UNSIGNED DEFAULT NULL,
  `cotizacion_id` bigint UNSIGNED DEFAULT NULL,
  `orden_trabajo_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cash_document_credits`
--

CREATE TABLE `cash_document_credits` (
  `id` bigint UNSIGNED NOT NULL,
  `cash_id` bigint UNSIGNED NOT NULL,
  `cash_id_processed` bigint UNSIGNED DEFAULT NULL,
  `factura_id` bigint UNSIGNED DEFAULT NULL,
  `recibo_id` bigint UNSIGNED DEFAULT NULL,
  `venta_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cash_document_payments`
--

CREATE TABLE `cash_document_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `cash_id` bigint UNSIGNED NOT NULL,
  `payment_id` bigint UNSIGNED NOT NULL,
  `cash_document_id` bigint UNSIGNED DEFAULT NULL,
  `cash_document_credit_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_equipo_gps` tinyint(1) NOT NULL DEFAULT '0',
  `es_servicio_monitoreo` tinyint(1) NOT NULL DEFAULT '0',
  `es_accesorios` tinyint(1) NOT NULL DEFAULT '0',
  `empresa_id` bigint UNSIGNED NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

CREATE TABLE `certificados` (
  `id` bigint UNSIGNED NOT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_instalacion` date NOT NULL,
  `fin_cobertura` date NOT NULL,
  `fecha` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` year DEFAULT NULL,
  `sello` tinyint(1) NOT NULL DEFAULT '1',
  `fondo` tinyint(1) NOT NULL DEFAULT '1',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `vehiculos_id` bigint UNSIGNED DEFAULT NULL,
  `ciudades_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accesorios` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados_antifatiga`
--

CREATE TABLE `certificados_antifatiga` (
  `id` bigint UNSIGNED NOT NULL,
  `fecha_emision` date DEFAULT NULL,
  `inicio_cobertura` date DEFAULT NULL,
  `fin_cobertura` date DEFAULT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `usuario_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `cliente_id` bigint UNSIGNED DEFAULT NULL,
  `cliente` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `sello` tinyint(1) NOT NULL DEFAULT '1',
  `fondo` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_instalacion` date DEFAULT NULL,
  `hash` text COLLATE utf8mb4_unicode_ci,
  `ciudades_id` bigint UNSIGNED DEFAULT NULL,
  `dispositivo_id` bigint UNSIGNED DEFAULT NULL,
  `imei_personalizado` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cambiar_imei` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados_velocimetros`
--

CREATE TABLE `certificados_velocimetros` (
  `id` bigint UNSIGNED NOT NULL,
  `vehiculos_id` bigint UNSIGNED DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `velocimetro_modelo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` year DEFAULT NULL,
  `sello` tinyint(1) NOT NULL DEFAULT '1',
  `fondo` tinyint(1) NOT NULL DEFAULT '1',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `ciudades_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacion` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `changes_models`
--

CREATE TABLE `changes_models` (
  `id` bigint UNSIGNED NOT NULL,
  `change_id` bigint UNSIGNED NOT NULL,
  `change_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original` text COLLATE utf8mb4_unicode_ci,
  `changes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `checklist_templates`
--

CREATE TABLE `checklist_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` enum('vehiculo','tablero','luces','accesorios','motor','neumaticos','documentos','otros') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'otros',
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `requiere_foto` tinyint(1) NOT NULL DEFAULT '0',
  `orden` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `empresa_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefijo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `razon_social` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_documento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_site` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ubigeo` text COLLATE utf8mb4_unicode_ci,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rubro_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `compras` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `ultima_compra` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_password_resets`
--

CREATE TABLE `cliente_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_users`
--

CREATE TABLE `cliente_users` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('titular','colaborador') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'titular',
  `estado` enum('pendiente','aprobado','rechazado','suspendido') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros`
--

CREATE TABLE `cobros` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `clientes_id` bigint UNSIGNED NOT NULL,
  `vehiculos_id` bigint UNSIGNED DEFAULT NULL,
  `plan_id` bigint UNSIGNED DEFAULT NULL,
  `periodo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MENSUAL',
  `monto` decimal(15,4) DEFAULT NULL,
  `descuento` decimal(15,2) NOT NULL DEFAULT '0.00',
  `divisa` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `tipo_pago` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `estado` enum('ACTIVO','SUSPENDIDO','CANCELADO','CORTESIA') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVO',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_detracciones`
--

CREATE TABLE `codigos_detracciones` (
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `porcentaje` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` bigint UNSIGNED NOT NULL,
  `proveedor_id` bigint UNSIGNED NOT NULL,
  `tipo_comprobante_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metodo_pago_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '009',
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_correlativo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_cambio` decimal(10,4) DEFAULT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `observacion` text COLLATE utf8mb4_unicode_ci COMMENT 'Observación detallada de la compra',
  `guias` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'Guías de remisión asociadas',
  `sub_total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `igv` decimal(11,4) DEFAULT NULL,
  `total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `total_percepcion` decimal(12,2) DEFAULT NULL COMMENT 'Total de percepción aplicada',
  `percepcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'Detalle de percepción',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `estado` enum('COMPLETADO','BORRADOR','ANULADO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BORRADOR',
  `pago_estado` enum('PENDIENTE','PARCIAL','PAID') COLLATE utf8mb4_unicode_ci DEFAULT 'PENDIENTE',
  `forma_pago` enum('CONTADO','CREDITO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CONTADO',
  `numero_cuotas` int NOT NULL DEFAULT '0',
  `cuotas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin COMMENT 'Detalle de cuotas para pago a crédito',
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras_factura`
--

CREATE TABLE `compras_factura` (
  `id` bigint UNSIGNED NOT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `nota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `proveedores_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_comprobante_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_hora_emision` datetime DEFAULT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_cambio` decimal(11,2) DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_gratuitas` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `sub_total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `icbper` decimal(11,4) DEFAULT NULL,
  `igv` decimal(11,4) DEFAULT NULL,
  `total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `cliente_id` bigint UNSIGNED DEFAULT NULL,
  `tipo_comprobante_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` bigint UNSIGNED DEFAULT NULL,
  `invoice_id_new` bigint UNSIGNED DEFAULT NULL,
  `correlativo_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie_correlativo_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sustento_id` bigint UNSIGNED NOT NULL,
  `sustento_texto` text COLLATE utf8mb4_unicode_ci,
  `ticket` text COLLATE utf8mb4_unicode_ci,
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
  `clase` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `numero_cuotas` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vence_cuotas` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detalle_cuotas` text COLLATE utf8mb4_unicode_ci,
  `invoice_forma_pago` enum('CONTADO','CREDITO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CONTADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` bigint UNSIGNED NOT NULL,
  `clientes_id` bigint UNSIGNED DEFAULT NULL,
  `cargo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_documento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_gerente` tinyint(1) NOT NULL DEFAULT '0',
  `is_cobros` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nota` text COLLATE utf8mb4_unicode_ci,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id` bigint UNSIGNED NOT NULL,
  `clientes_id` bigint UNSIGNED DEFAULT NULL,
  `fecha` date NOT NULL,
  `fecha_emision` datetime DEFAULT NULL,
  `sello` tinyint(1) NOT NULL DEFAULT '1',
  `fondo` tinyint(1) NOT NULL DEFAULT '1',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `ciudades_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `unique_hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` bigint UNSIGNED NOT NULL,
  `facturas_id` bigint UNSIGNED DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `producto_id` bigint UNSIGNED DEFAULT NULL,
  `cantidad` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `importe` decimal(11,2) DEFAULT NULL,
  `codigo` text COLLATE utf8mb4_unicode_ci,
  `importe_total` decimal(11,4) DEFAULT NULL,
  `igv` decimal(11,4) DEFAULT NULL,
  `compras_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_comprobantes`
--

CREATE TABLE `detalle_comprobantes` (
  `id` bigint UNSIGNED NOT NULL,
  `comprobante_id` bigint UNSIGNED DEFAULT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `codigo` text COLLATE utf8mb4_unicode_ci,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `unit` text COLLATE utf8mb4_unicode_ci,
  `unit_name` text COLLATE utf8mb4_unicode_ci,
  `codigo_afectacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_precio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `valor_unitario` decimal(11,4) NOT NULL,
  `precio_unitario` decimal(11,4) NOT NULL,
  `afecto_icbper` tinyint(1) NOT NULL DEFAULT '0',
  `icbper` decimal(11,4) DEFAULT NULL,
  `total_icbper` decimal(11,4) DEFAULT NULL,
  `igv` decimal(11,4) DEFAULT NULL,
  `porcentaje_igv` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `descuento_factor` decimal(11,5) DEFAULT NULL,
  `sub_total` decimal(11,4) DEFAULT NULL,
  `total` decimal(11,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_contratos`
--

CREATE TABLE `detalle_contratos` (
  `id` bigint UNSIGNED NOT NULL,
  `vehiculos_id` bigint UNSIGNED NOT NULL,
  `contratos_id` bigint UNSIGNED NOT NULL,
  `plan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_facturas`
--

CREATE TABLE `detalle_facturas` (
  `id` bigint UNSIGNED NOT NULL,
  `producto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` decimal(15,2) NOT NULL,
  `precio` decimal(15,2) NOT NULL,
  `descuento` decimal(15,2) DEFAULT NULL,
  `descuento_val` decimal(15,2) UNSIGNED DEFAULT NULL,
  `igv` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) NOT NULL,
  `facturas_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_guia_remision`
--

CREATE TABLE `detalle_guia_remision` (
  `id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED DEFAULT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` decimal(15,2) NOT NULL,
  `unidad_medida` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `guia_remision_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_presupuestos`
--

CREATE TABLE `detalle_presupuestos` (
  `id` bigint UNSIGNED NOT NULL,
  `producto` longtext COLLATE utf8mb4_unicode_ci,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `descuento_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo` text COLLATE utf8mb4_unicode_ci,
  `unit` text COLLATE utf8mb4_unicode_ci,
  `unit_name` text COLLATE utf8mb4_unicode_ci,
  `codigo_afectacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_precio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_unitario` decimal(11,4) NOT NULL,
  `precio_unitario` decimal(11,4) NOT NULL,
  `afecto_icbper` tinyint(1) NOT NULL DEFAULT '0',
  `icbper` decimal(11,4) DEFAULT NULL,
  `total_icbper` decimal(11,4) DEFAULT NULL,
  `porcentaje_igv` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` decimal(11,4) DEFAULT NULL,
  `cantidad` decimal(15,2) NOT NULL,
  `precio` decimal(15,2) DEFAULT NULL,
  `descuento` decimal(15,2) DEFAULT NULL,
  `descuento_val` decimal(15,2) DEFAULT NULL,
  `descuento_factor` decimal(11,5) DEFAULT NULL,
  `igv` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) NOT NULL,
  `presupuestos_id` bigint UNSIGNED DEFAULT NULL,
  `producto_id` bigint UNSIGNED DEFAULT NULL,
  `plan_id` bigint UNSIGNED DEFAULT NULL,
  `plan_features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_recibos`
--

CREATE TABLE `detalle_recibos` (
  `id` bigint UNSIGNED NOT NULL,
  `producto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `descripcion_pdf` text COLLATE utf8mb4_unicode_ci,
  `imeis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `descuento_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento` decimal(15,2) DEFAULT NULL,
  `descuento_val` decimal(15,2) UNSIGNED DEFAULT NULL,
  `cantidad` decimal(15,2) NOT NULL,
  `precio` decimal(15,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `recibos_id` bigint UNSIGNED DEFAULT NULL,
  `producto_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_recibos_pagos`
--

CREATE TABLE `detalle_recibos_pagos` (
  `id` bigint UNSIGNED NOT NULL,
  `producto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento` decimal(15,2) DEFAULT NULL,
  `descuento_val` decimal(15,2) UNSIGNED DEFAULT NULL,
  `cantidad` decimal(15,2) NOT NULL,
  `precio` decimal(15,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `recibos_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `producto_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_reportes`
--

CREATE TABLE `detalle_reportes` (
  `id` bigint UNSIGNED NOT NULL,
  `reportes_id` bigint UNSIGNED NOT NULL,
  `detalle` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detracciones`
--

CREATE TABLE `detracciones` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo_detraccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `porcentaje` decimal(12,2) NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `tipo_cambio` decimal(12,4) NOT NULL,
  `metodo_pago_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venta_id` bigint UNSIGNED DEFAULT NULL,
  `cuenta_bancaria` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devices`
--

CREATE TABLE `devices` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `body` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `webhook` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Connected','Disconnect') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Disconnect',
  `message_sent` bigint NOT NULL DEFAULT '0',
  `api_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `interno` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Dispositivo reservado para notificaciones internas del sistema',
  `es_postventa` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `device_history`
--

CREATE TABLE `device_history` (
  `id` bigint UNSIGNED NOT NULL,
  `work_order_id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED NOT NULL,
  `dispositivo_id` bigint UNSIGNED DEFAULT NULL,
  `imei` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accion_imei` enum('instalado','retirado','reemplazado','ninguna') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ninguna',
  `sim_card_id` bigint UNSIGNED DEFAULT NULL,
  `iccid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_linea` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accion_sim` enum('instalado','retirado','reemplazado','ninguna') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ninguna',
  `fecha_instalacion` datetime DEFAULT NULL,
  `fecha_retiro` datetime DEFAULT NULL,
  `dispositivo_anterior_id` bigint UNSIGNED DEFAULT NULL,
  `imei_anterior` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sim_card_anterior_id` bigint UNSIGNED DEFAULT NULL,
  `iccid_anterior` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `ubicacion_instalacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `device_maintenances`
--

CREATE TABLE `device_maintenances` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `tracking_device_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id_plattform` bigint UNSIGNED DEFAULT NULL,
  `tracking_device_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` enum('mantenimiento','suspension','reactivacion') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mantenimiento',
  `fecha` date NOT NULL,
  `motivo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notas` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `source` enum('manual','tracking') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispatchers`
--

CREATE TABLE `dispatchers` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_doc` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '6',
  `numero_doc` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razon_social` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_mtc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos`
--

CREATE TABLE `dispositivos` (
  `id` bigint UNSIGNED NOT NULL,
  `imei` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo_id` bigint UNSIGNED DEFAULT NULL,
  `of_client` tinyint(1) NOT NULL DEFAULT '0',
  `empresa_id` bigint UNSIGNED NOT NULL,
  `estado` enum('VENDIDO','STOCK') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'STOCK',
  `selled` tinyint(1) DEFAULT '0',
  `in_fota` tinyint(1) NOT NULL DEFAULT '0',
  `consultado` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispositivos_users`
--

CREATE TABLE `dispositivos_users` (
  `id` bigint UNSIGNED NOT NULL,
  `imei` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tecnico_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `guia_remision_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisas`
--

CREATE TABLE `divisas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `simbolo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_doc` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `numero_doc` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `licencia` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio_resumen`
--

CREATE TABLE `envio_resumen` (
  `id` bigint UNSIGNED NOT NULL,
  `correlativo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resumen` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `baja` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_xml` text COLLATE utf8mb4_unicode_ci,
  `clase` longtext COLLATE utf8mb4_unicode_ci,
  `code_sunat` text COLLATE utf8mb4_unicode_ci,
  `hash_cdr` text COLLATE utf8mb4_unicode_ci,
  `hash` text COLLATE utf8mb4_unicode_ci,
  `cdr_base64` text COLLATE utf8mb4_unicode_ci,
  `nombre_cdr` text COLLATE utf8mb4_unicode_ci,
  `xml_base64` text COLLATE utf8mb4_unicode_ci,
  `nota` text COLLATE utf8mb4_unicode_ci,
  `fe_mensaje_error` text COLLATE utf8mb4_unicode_ci,
  `estado_texto` text COLLATE utf8mb4_unicode_ci,
  `fe_estado` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fe_codigo_error` text COLLATE utf8mb4_unicode_ci,
  `fe_mensaje_sunat` text COLLATE utf8mb4_unicode_ci,
  `ticket` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `fecha_generacion` datetime DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio_resumen_detalle`
--

CREATE TABLE `envio_resumen_detalle` (
  `id` bigint UNSIGNED NOT NULL,
  `envio_resumen_id` bigint UNSIGNED DEFAULT NULL,
  `venta_id` bigint UNSIGNED DEFAULT NULL,
  `condicion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expense_method_types`
--

CREATE TABLE `expense_method_types` (
  `id` bigint UNSIGNED NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_card` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si requiere tarjeta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expense_payments`
--

CREATE TABLE `expense_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `expense_id` bigint UNSIGNED NOT NULL,
  `date_of_payment` date NOT NULL,
  `expense_method_type_id` bigint UNSIGNED NOT NULL,
  `has_card` tinyint(1) NOT NULL DEFAULT '0',
  `card_brand_id` bigint UNSIGNED DEFAULT NULL,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Número de referencia/operación',
  `payment` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` bigint UNSIGNED NOT NULL,
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie_numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `estado` enum('BORRADOR','COMPLETADO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BORRADOR',
  `pago_estado` enum('UNPAID','PAID') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `forma_pago` bigint UNSIGNED DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `tipo_venta` enum('CONTADO','CREDITO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CONTADO',
  `adelanto` decimal(15,2) DEFAULT NULL,
  `numero_cuotas` int DEFAULT NULL,
  `vence_cuotas` int DEFAULT NULL,
  `detalle_cuotas` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `nota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento` decimal(15,2) DEFAULT NULL,
  `descuento_val` bigint UNSIGNED DEFAULT NULL,
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
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `features`
--

CREATE TABLE `features` (
  `id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resettable_period` smallint UNSIGNED NOT NULL DEFAULT '0',
  `resettable_interval` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'month',
  `sort_order` mediumint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flotas`
--

CREATE TABLE `flotas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clientes_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group_metadata_cache`
--

CREATE TABLE `group_metadata_cache` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_jid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cached_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_remision`
--

CREATE TABLE `guia_remision` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `venta_id` bigint UNSIGNED DEFAULT NULL,
  `terceros_tipo_documento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terceros_num_doc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terceros_razon_social` text COLLATE utf8mb4_unicode_ci,
  `codigo_traslado` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motivo_traslado_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion_motivo_traslado` text COLLATE utf8mb4_unicode_ci,
  `modalidad_transporte_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_inicio_traslado` date DEFAULT NULL,
  `fecha_entrega_transportista` date DEFAULT NULL,
  `is_transport_m1l` tinyint(1) NOT NULL DEFAULT '0',
  `has_transport_driver_01` tinyint(1) NOT NULL DEFAULT '0',
  `transp_tipo_doc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transp_numero_doc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transp_razon_social` text COLLATE utf8mb4_unicode_ci,
  `transp_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transp_numero_mtc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transp_placa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placa_semirremolque` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_doc_chofer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_doc_chofer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chofer_nombre` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chofer_apellidos` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chofer_licencia` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peso` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad_items` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_contenedor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datos_puerto` text COLLATE utf8mb4_unicode_ci,
  `direccion_partida` text COLLATE utf8mb4_unicode_ci,
  `ubigeo_partida` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_llegada` text COLLATE utf8mb4_unicode_ci,
  `ubigeo_llegada` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_establecimiento_llegada` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_establecimiento_partida` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docu_rel_tipo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docu_rel_numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacion` text COLLATE utf8mb4_unicode_ci,
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
  `clase` longtext COLLATE utf8mb4_unicode_ci,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `tecnico_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `driver_id` bigint UNSIGNED DEFAULT NULL,
  `transport_id` bigint UNSIGNED DEFAULT NULL,
  `dispatcher_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `qr` text COLLATE utf8mb4_unicode_ci,
  `ticket` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` bigint UNSIGNED NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageable_id` bigint UNSIGNED NOT NULL,
  `imageable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe_tarea`
--

CREATE TABLE `informe_tarea` (
  `id` bigint UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `tarea_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_whitelists`
--

CREATE TABLE `ip_whitelists` (
  `id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kpis`
--

CREATE TABLE `kpis` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `tipo` enum('auto','manual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'auto',
  `meta` decimal(10,2) NOT NULL DEFAULT '0.00',
  `meta_minima` decimal(10,2) DEFAULT NULL,
  `unidad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '%',
  `frecuencia` enum('diario','semanal','mensual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'semanal',
  `responsable` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formula` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `es_wig` tinyint(1) NOT NULL DEFAULT '0',
  `orden` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kpi_alertas`
--

CREATE TABLE `kpi_alertas` (
  `id` bigint UNSIGNED NOT NULL,
  `kpi_id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `titulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `nivel` enum('info','advertencia','critico') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'advertencia',
  `resuelto` tinyint(1) NOT NULL DEFAULT '0',
  `resuelto_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kpi_resultados`
--

CREATE TABLE `kpi_resultados` (
  `id` bigint UNSIGNED NOT NULL,
  `kpi_id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `periodo_inicio` date NOT NULL,
  `periodo_fin` date NOT NULL,
  `valor_actual` decimal(10,2) NOT NULL DEFAULT '0.00',
  `valor_meta` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cumplimiento` decimal(8,2) NOT NULL DEFAULT '0.00',
  `semaforo` enum('verde','amarillo','rojo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rojo',
  `notas` text COLLATE utf8mb4_unicode_ci,
  `registrado_por` bigint UNSIGNED DEFAULT NULL,
  `calculado_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lid_mappings`
--

CREATE TABLE `lid_mappings` (
  `id` bigint UNSIGNED NOT NULL,
  `lid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pn` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas`
--

CREATE TABLE `lineas` (
  `id` bigint UNSIGNED NOT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operador_id` bigint UNSIGNED DEFAULT NULL,
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
-- Estructura de tabla para la tabla `mantenimientos`
--

CREATE TABLE `mantenimientos` (
  `id` bigint UNSIGNED NOT NULL,
  `numero` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalle_trabajo` text COLLATE utf8mb4_unicode_ci,
  `fecha_hora_mantenimiento` datetime NOT NULL,
  `notify_admin` tinyint(1) NOT NULL DEFAULT '1',
  `notify_client` tinyint(1) NOT NULL DEFAULT '0',
  `nota` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('PENDIENTE','COMPLETADA','CANCELADO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDIENTE',
  `vehiculo_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` bigint UNSIGNED NOT NULL,
  `from_user_id` bigint UNSIGNED DEFAULT NULL,
  `to_user_id` bigint UNSIGNED DEFAULT NULL,
  `messageable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageable_id` bigint UNSIGNED NOT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_certificado` int NOT NULL,
  `asunto` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contacto`
--

CREATE TABLE `mensajes_contacto` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_leido` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `from_user_id` bigint UNSIGNED NOT NULL,
  `to_user_id` bigint UNSIGNED NOT NULL,
  `asunto` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message_histories`
--

CREATE TABLE `message_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `device_id` bigint UNSIGNED NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` enum('success','failed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_by` enum('api','web') COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message_store`
--

CREATE TABLE `message_store` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remote_jid` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_id` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_me` tinyint(1) NOT NULL DEFAULT '0',
  `message_data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad_transporte`
--

CREATE TABLE `modalidad_transporte` (
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos_dispositivos`
--

CREATE TABLE `modelos_dispositivos` (
  `id` bigint UNSIGNED NOT NULL,
  `modelo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tecnologia` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificado` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caracteristicas` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos_traslado`
--

CREATE TABLE `motivos_traslado` (
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_traslado`
--

CREATE TABLE `motivo_traslado` (
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` bigint UNSIGNED NOT NULL,
  `origen` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destino` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `articulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito`
--

CREATE TABLE `nota_credito` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_comprobante_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_cambio` decimal(11,2) DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_gratuitas` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `sub_total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `icbper` decimal(11,4) DEFAULT NULL,
  `igv` decimal(11,4) DEFAULT NULL,
  `total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `cliente_id` bigint UNSIGNED DEFAULT NULL,
  `tipo_comprobante_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` bigint UNSIGNED DEFAULT NULL,
  `invoice_id_new` bigint UNSIGNED DEFAULT NULL,
  `correlativo_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie_correlativo_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sustento_id` bigint UNSIGNED NOT NULL,
  `sustento_texto` text COLLATE utf8mb4_unicode_ci,
  `fe_estado` tinyint(1) NOT NULL DEFAULT '0',
  `estado_texto` text COLLATE utf8mb4_unicode_ci,
  `fe_codigo_error` text COLLATE utf8mb4_unicode_ci,
  `fe_mensaje_error` text COLLATE utf8mb4_unicode_ci,
  `fe_mensaje_sunat` text COLLATE utf8mb4_unicode_ci,
  `nota` text COLLATE utf8mb4_unicode_ci,
  `nombre_xml` text COLLATE utf8mb4_unicode_ci,
  `xml_base64` text COLLATE utf8mb4_unicode_ci,
  `cdr_base64` text COLLATE utf8mb4_unicode_ci,
  `hash` text COLLATE utf8mb4_unicode_ci,
  `hash_cdr` text COLLATE utf8mb4_unicode_ci,
  `code_sunat` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito_detalles`
--

CREATE TABLE `nota_credito_detalles` (
  `id` bigint UNSIGNED NOT NULL,
  `nota_credito_id` bigint UNSIGNED DEFAULT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_debito`
--

CREATE TABLE `nota_debito` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_comprobante_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_cambio` decimal(11,2) DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_gratuitas` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `sub_total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `icbper` decimal(11,4) DEFAULT NULL,
  `igv` decimal(11,4) DEFAULT NULL,
  `total` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `cliente_id` bigint UNSIGNED DEFAULT NULL,
  `tipo_comprobante_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_id` bigint UNSIGNED DEFAULT NULL,
  `invoice_id_new` bigint UNSIGNED DEFAULT NULL,
  `correlativo_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie_correlativo_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sustento_id` bigint UNSIGNED NOT NULL,
  `sustento_texto` text COLLATE utf8mb4_unicode_ci,
  `fe_estado` tinyint(1) NOT NULL DEFAULT '0',
  `estado_texto` text COLLATE utf8mb4_unicode_ci,
  `fe_codigo_error` text COLLATE utf8mb4_unicode_ci,
  `fe_mensaje_error` text COLLATE utf8mb4_unicode_ci,
  `fe_mensaje_sunat` text COLLATE utf8mb4_unicode_ci,
  `nota` text COLLATE utf8mb4_unicode_ci,
  `nombre_xml` text COLLATE utf8mb4_unicode_ci,
  `xml_base64` text COLLATE utf8mb4_unicode_ci,
  `cdr_base64` text COLLATE utf8mb4_unicode_ci,
  `hash` text COLLATE utf8mb4_unicode_ci,
  `hash_cdr` text COLLATE utf8mb4_unicode_ci,
  `code_sunat` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_debito_detalles`
--

CREATE TABLE `nota_debito_detalles` (
  `id` bigint UNSIGNED NOT NULL,
  `nota_debito_id` bigint UNSIGNED DEFAULT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `cantidad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `old_sim_card_linea`
--

CREATE TABLE `old_sim_card_linea` (
  `id` bigint UNSIGNED NOT NULL,
  `linea_id` bigint UNSIGNED DEFAULT NULL,
  `old_sim_card` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operadores`
--

CREATE TABLE `operadores` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `have_api` tinyint(1) NOT NULL DEFAULT '0',
  `api_slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_operacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `nota` text COLLATE utf8mb4_unicode_ci,
  `documento` text COLLATE utf8mb4_unicode_ci,
  `divisa` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_cambio` decimal(8,4) NOT NULL DEFAULT '1.0000' COMMENT 'Tipo de cambio del documento',
  `monto` decimal(10,2) NOT NULL,
  `type_movement` enum('INGRESO','EGRESO') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Tipo de movimiento: INGRESO (ventas, recibos) o EGRESO (compras, gastos)',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Descripción automática del movimiento',
  `paymentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentable_id` bigint UNSIGNED NOT NULL,
  `unique_hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `cobros_id` bigint UNSIGNED DEFAULT NULL,
  `payment_method_id` text COLLATE utf8mb4_unicode_ci,
  `bank_account_id` bigint UNSIGNED DEFAULT NULL,
  `destination_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Tipo de destino polimórfico: Cash, BankAccount',
  `destination_id` bigint UNSIGNED DEFAULT NULL COMMENT 'ID del destino polimórfico',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_method_types`
--

CREATE TABLE `payment_method_types` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_card` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si requiere tarjeta de crédito/débito',
  `number_days` int DEFAULT NULL COMMENT 'Días de crédito',
  `charge` decimal(12,2) DEFAULT NULL COMMENT 'Comisión/recargo',
  `is_credit` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Define si es tipo crédito',
  `is_cash` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Define si es efectivo',
  `empresa_id` bigint UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos_cobros`
--

CREATE TABLE `periodos_cobros` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `cobros_id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `periodo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MENSUAL',
  `monto` decimal(15,4) NOT NULL,
  `divisa` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `tipo` enum('INICIAL','RENOVACION') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INICIAL',
  `estado` enum('PENDIENTE','FACTURADO','PAGADO','CANCELADO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDIENTE',
  `venta_id` bigint UNSIGNED DEFAULT NULL,
  `recibo_id` bigint UNSIGNED DEFAULT NULL,
  `fecha_pago` timestamp NULL DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sla_tier` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `signup_fee` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trial_period` smallint UNSIGNED NOT NULL DEFAULT '0',
  `trial_interval` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'day',
  `invoice_period` smallint UNSIGNED NOT NULL DEFAULT '0',
  `invoice_interval` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'month',
  `grace_period` smallint UNSIGNED NOT NULL DEFAULT '0',
  `grace_interval` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'day',
  `prorate_day` tinyint UNSIGNED DEFAULT NULL,
  `prorate_period` tinyint UNSIGNED DEFAULT NULL,
  `prorate_extend_due` tinyint UNSIGNED DEFAULT NULL,
  `active_subscribers_limit` smallint UNSIGNED DEFAULT NULL,
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `producto_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla`
--

CREATE TABLE `plantilla` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `razon_social` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fondo_contrato` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_documentos` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_firma` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fav_icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_documento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_comercial` text COLLATE utf8mb4_unicode_ci,
  `pais` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sunat_datos` text COLLATE utf8mb4_unicode_ci,
  `cuenta_detraccion` text COLLATE utf8mb4_unicode_ci,
  `modo` enum('produccion','local') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `afecto_igv` tinyint(1) NOT NULL DEFAULT '1',
  `mail_config` text COLLATE utf8mb4_unicode_ci,
  `bienes_selva` tinyint(1) NOT NULL DEFAULT '0',
  `servicios_selva` tinyint(1) NOT NULL DEFAULT '0',
  `ruta_xml` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta_cdr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ruta_cert` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `igv` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icbper` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terminos` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postventa_plantillas`
--

CREATE TABLE `postventa_plantillas` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `sector_id` bigint UNSIGNED DEFAULT NULL,
  `cuerpo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `archivo_tipo` enum('pdf','video') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_comprobante_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clientes_id` bigint UNSIGNED DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEN',
  `tipo_cambio` decimal(11,2) DEFAULT NULL,
  `metodo_pago_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `igv` decimal(11,4) DEFAULT NULL,
  `comision` decimal(11,4) DEFAULT NULL,
  `adelanto` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `numero_cuotas` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vence_cuotas` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detalle_cuotas` text COLLATE utf8mb4_unicode_ci,
  `anulado` enum('si','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `resumen` enum('si','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `pago_estado` enum('UNPAID','PAID') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `forma_pago` enum('CONTADO','CREDITO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CONTADO',
  `sub_total` decimal(10,2) DEFAULT NULL,
  `impuesto` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `sub_total_soles` decimal(10,2) DEFAULT NULL,
  `impuesto_soles` decimal(10,2) DEFAULT NULL,
  `total_soles` decimal(10,2) DEFAULT NULL,
  `tipoCambio` decimal(10,3) DEFAULT NULL,
  `igv_soles` decimal(11,2) DEFAULT NULL,
  `op_inafectas_soles` decimal(11,2) DEFAULT NULL,
  `op_exoneradas_soles` decimal(11,2) DEFAULT NULL,
  `op_gravadas_soles` decimal(11,2) DEFAULT NULL,
  `descuento_soles` decimal(11,2) DEFAULT NULL,
  `estado` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `features` tinyint(1) NOT NULL DEFAULT '0',
  `nota` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terminos` text COLLATE utf8mb4_unicode_ci,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `afecto_icbper` tinyint(1) NOT NULL DEFAULT '0',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `ventas` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `divisa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` enum('producto','servicio') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'producto',
  `es_servicio_cobro` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si es un servicio para facturar cobros de mensualidades',
  `es_dispositivo` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si el producto es un dispositivo que requiere modelo asociado',
  `categoria_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `is_favorite` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `unit_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `valor_unitario` decimal(18,4) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `modelo_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` bigint UNSIGNED NOT NULL,
  `razon_social` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_documento_id` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '6',
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_site` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Estructura de tabla para la tabla `recordatorios`
--

CREATE TABLE `recordatorios` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `fecha` date NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reportes_id` bigint UNSIGNED NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_cobros`
--

CREATE TABLE `registro_cobros` (
  `id` bigint UNSIGNED NOT NULL,
  `cobros_id` bigint UNSIGNED DEFAULT NULL,
  `tipo_pago` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id` bigint UNSIGNED NOT NULL,
  `vehiculos_id` bigint UNSIGNED DEFAULT NULL,
  `hora_t` time NOT NULL,
  `fecha_t` date NOT NULL,
  `fecha` date NOT NULL,
  `detalle` longtext COLLATE utf8mb4_unicode_ci,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `origen` enum('manual','auto') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'manual',
  `empresa_id` bigint UNSIGNED NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `atendido_por` bigint UNSIGNED DEFAULT NULL,
  `atendido_at` timestamp NULL DEFAULT NULL,
  `cerrado_at` timestamp NULL DEFAULT NULL,
  `horas_sin_transmision` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review`
--

CREATE TABLE `review` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_redirect` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubros_cliente`
--

CREATE TABLE `rubros_cliente` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `orden` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector_vehiculo`
--

CREATE TABLE `sector_vehiculo` (
  `sector_id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series`
--

CREATE TABLE `series` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_comprobante_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correlativo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sim_card`
--

CREATE TABLE `sim_card` (
  `id` bigint UNSIGNED NOT NULL,
  `sim_card` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lineas_id` bigint UNSIGNED DEFAULT NULL,
  `operador_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `estado` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sim_card_users`
--

CREATE TABLE `sim_card_users` (
  `id` bigint UNSIGNED NOT NULL,
  `sim_card` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tecnico_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `guia_remision_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sla_plan_rules`
--

CREATE TABLE `sla_plan_rules` (
  `id` bigint UNSIGNED NOT NULL,
  `plan_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tr_hours` decimal(8,3) NOT NULL,
  `ts_remote_hours` decimal(8,3) NOT NULL,
  `tr_business_hours` tinyint(1) NOT NULL DEFAULT '0',
  `ts_business_hours` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_solicitud` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detalle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio_solicitado` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placa` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_inicial` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_final` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_envio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_envio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `numero` text COLLATE utf8mb4_unicode_ci,
  `estado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `subscriber_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscriber_id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `timezone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` datetime DEFAULT NULL,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `periodo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MENSUAL',
  `canceled_at` datetime DEFAULT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscription_usage`
--

CREATE TABLE `subscription_usage` (
  `id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `feature_id` bigint UNSIGNED NOT NULL,
  `used` smallint UNSIGNED NOT NULL,
  `timezone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sustentos`
--

CREATE TABLE `sustentos` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE `tags` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` bigint UNSIGNED NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehiculos_id` bigint UNSIGNED DEFAULT NULL,
  `cliente_id` bigint UNSIGNED DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sim_card` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nuevo_numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nuevo_sim_card` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dispositivo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo_velocimetro` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_hora` datetime NOT NULL,
  `respuesta` tinyint(1) NOT NULL DEFAULT '0',
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_validacion` datetime DEFAULT NULL,
  `sent_message` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_termino` datetime DEFAULT NULL,
  `estado` enum('UNREAD','COMPLETE','PENDIENT','CANCELED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNREAD',
  `tipo_tarea_id` bigint UNSIGNED DEFAULT NULL,
  `imagen_url` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `tecnico_id` bigint UNSIGNED DEFAULT NULL,
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `mantenimiento_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teams`
--

CREATE TABLE `teams` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kpi_area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `team_user`
--

CREATE TABLE `team_user` (
  `id` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `role_in_team` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telescope_entries`
--

CREATE TABLE `telescope_entries` (
  `sequence` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telescope_entries_tags`
--

CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telescope_monitoring`
--

CREATE TABLE `telescope_monitoring` (
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED DEFAULT NULL,
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `first_response_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `due_at` timestamp NULL DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `ts_at` timestamp NULL DEFAULT NULL,
  `escalation_level` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_attachments`
--

CREATE TABLE `ticket_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `message_id` bigint UNSIGNED DEFAULT NULL,
  `uploaded_by` bigint UNSIGNED NOT NULL,
  `original_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_categories`
--

CREATE TABLE `ticket_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6B7280',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_events`
--

CREATE TABLE `ticket_events` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `actor_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_internal` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_relations`
--

CREATE TABLE `ticket_relations` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `related_ticket_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_sequences`
--

CREATE TABLE `ticket_sequences` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `year` year NOT NULL,
  `last_number` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_templates`
--

CREATE TABLE `ticket_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_afectacion`
--

CREATE TABLE `tipo_afectacion` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `codigo_afectacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_afectacion` text COLLATE utf8mb4_unicode_ci,
  `tipo_afectacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `letra` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cambios`
--

CREATE TABLE `tipo_cambios` (
  `id` bigint UNSIGNED NOT NULL,
  `fecha` date NOT NULL COMMENT 'Fecha del tipo de cambio',
  `compra` decimal(10,3) NOT NULL COMMENT 'Tipo de cambio de compra',
  `venta` decimal(10,3) NOT NULL COMMENT 'Tipo de cambio de venta',
  `fuente` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'factiliza' COMMENT 'Fuente de la consulta',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_comprobantes`
--

CREATE TABLE `tipo_comprobantes` (
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documentos`
--

CREATE TABLE `tipo_documentos` (
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_tareas`
--

CREATE TABLE `tipo_tareas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `afecta_mantenimiento` tinyint(1) DEFAULT '0',
  `costo` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transports`
--

CREATE TABLE `transports` (
  `id` bigint UNSIGNED NOT NULL,
  `marca` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placa` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tuc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `empresa_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubigeos`
--

CREATE TABLE `ubigeos` (
  `id` bigint UNSIGNED NOT NULL,
  `id_ubigeo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ubigeo_inei` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departamento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distrito` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `units`
--

CREATE TABLE `units` (
  `codigo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `estado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_documento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefonos` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `is_client` enum('si','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `series_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcm_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Firebase Cloud Messaging token para notificaciones push',
  `ciudad_id` bigint UNSIGNED DEFAULT NULL,
  `wa_group_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ID del grupo de WhatsApp del técnico (ej: 120363xxxxx@g.us)',
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` bigint UNSIGNED NOT NULL,
  `gpswox_id` bigint UNSIGNED DEFAULT NULL COMMENT 'ID del dispositivo en GPSWox',
  `gpswox_active` tinyint(1) DEFAULT NULL COMMENT 'Estado activo/inactivo del dispositivo en GPSWox',
  `gpswox_sincronizado_at` timestamp NULL DEFAULT NULL COMMENT 'Última sincronización con la plataforma GPSWox',
  `placa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motor` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_instalacion` date DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos_flotas`
--

CREATE TABLE `vehiculos_flotas` (
  `id` bigint UNSIGNED NOT NULL,
  `vehiculos_id` bigint UNSIGNED DEFAULT NULL,
  `flotas_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalles`
--

CREATE TABLE `ventas_detalles` (
  `id` bigint UNSIGNED NOT NULL,
  `ventas_id` bigint UNSIGNED NOT NULL,
  `producto_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo` text COLLATE utf8mb4_unicode_ci,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `descripcion_pdf` text COLLATE utf8mb4_unicode_ci,
  `imeis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `unit` text COLLATE utf8mb4_unicode_ci,
  `unit_name` text COLLATE utf8mb4_unicode_ci,
  `codigo_afectacion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_precio` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `valor_unitario` decimal(11,4) NOT NULL,
  `precio_unitario` decimal(11,4) NOT NULL,
  `afecto_icbper` tinyint(1) NOT NULL DEFAULT '0',
  `icbper` decimal(11,4) DEFAULT NULL,
  `total_icbper` decimal(11,4) DEFAULT NULL,
  `igv` decimal(11,4) DEFAULT NULL,
  `porcentaje_igv` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descuento` decimal(11,2) DEFAULT NULL,
  `descuento_factor` decimal(11,5) DEFAULT NULL,
  `sub_total` decimal(11,4) DEFAULT NULL,
  `total` decimal(11,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `whatsapp_groups`
--

CREATE TABLE `whatsapp_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `device_body` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `participant_count` int UNSIGNED NOT NULL DEFAULT '0',
  `synced_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wigs`
--

CREATE TABLE `wigs` (
  `id` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `titulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `meta` decimal(10,2) NOT NULL DEFAULT '100.00',
  `valor_actual` decimal(10,2) NOT NULL DEFAULT '0.00',
  `unidad` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '%',
  `responsable` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `formula` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` enum('auto','manual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'auto',
  `estado` enum('activo','completado','cancelado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `orden` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_orders`
--

CREATE TABLE `work_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_order_type_id` bigint UNSIGNED NOT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `cliente_id` bigint UNSIGNED DEFAULT NULL,
  `mantenimiento_id` bigint UNSIGNED DEFAULT NULL COMMENT 'Notificación de mantenimiento programado vinculada a esta orden',
  `presupuesto_id` bigint UNSIGNED DEFAULT NULL,
  `tecnico_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `empresa_id` bigint UNSIGNED NOT NULL,
  `fecha_programada` datetime NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_finalizacion` datetime DEFAULT NULL,
  `fecha_cerrado` datetime DEFAULT NULL,
  `estado` enum('pendiente','en_proceso','finalizado','cancelado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `es_proyecto` tinyint(1) NOT NULL DEFAULT '0',
  `titulo_proyecto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Título del proyecto cuando es_proyecto = true',
  `observaciones_inicial` text COLLATE utf8mb4_unicode_ci,
  `calificacion_cliente` tinyint DEFAULT NULL COMMENT 'Calificación del cliente 1-5 estrellas',
  `comentario_cliente` text COLLATE utf8mb4_unicode_ci,
  `calificado_at` timestamp NULL DEFAULT NULL,
  `sector` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Persona de contacto del cliente para la orden',
  `observaciones_tecnico` text COLLATE utf8mb4_unicode_ci,
  `observaciones_final` text COLLATE utf8mb4_unicode_ci,
  `motivo_cancelacion` text COLLATE utf8mb4_unicode_ci,
  `imei` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'IMEI del dispositivo GPS instalado (15 dígitos)',
  `iccid` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ICCID de la tarjeta SIM (19-20 dígitos)',
  `modelo_dispositivo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Modelo del dispositivo GPS instalado',
  `ubicacion_dispositivo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ubicación física del dispositivo en el vehículo',
  `fecha_termino` datetime DEFAULT NULL COMMENT 'Fecha y hora real de terminación del trabajo',
  `tipo_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `ubicacion_lat` decimal(10,8) DEFAULT NULL,
  `ubicacion_lng` decimal(11,8) DEFAULT NULL,
  `ubicacion_direccion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Dirección de texto libre del lugar de servicio',
  `tecnico_lat` decimal(10,8) DEFAULT NULL,
  `tecnico_lng` decimal(11,8) DEFAULT NULL,
  `tecnico_last_seen` timestamp NULL DEFAULT NULL,
  `wa_message_id` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ID del mensaje WA enviado al grupo del técnico',
  `wa_group_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'JID del grupo WA del técnico al momento del envío',
  `bloqueado` tinyint(1) NOT NULL DEFAULT '0',
  `verification_hash` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_status` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verification_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_order_accessories`
--

CREATE TABLE `work_order_accessories` (
  `id` bigint UNSIGNED NOT NULL,
  `work_order_id` bigint UNSIGNED NOT NULL,
  `producto_id` bigint UNSIGNED DEFAULT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `cantidad` int NOT NULL DEFAULT '1',
  `accion` enum('instalado','retirado','reemplazado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'instalado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_order_checklists`
--

CREATE TABLE `work_order_checklists` (
  `id` bigint UNSIGNED NOT NULL,
  `work_order_id` bigint UNSIGNED NOT NULL,
  `checklist_template_id` bigint UNSIGNED NOT NULL,
  `fase` enum('before','after') COLLATE utf8mb4_unicode_ci NOT NULL,
  `resultado` enum('ok','observado','no_aplica') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `inspeccionado_at` datetime DEFAULT NULL,
  `inspeccionado_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_order_items`
--

CREATE TABLE `work_order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `work_order_id` bigint UNSIGNED NOT NULL,
  `work_order_type_id` bigint UNSIGNED DEFAULT NULL,
  `vehiculo_id` bigint UNSIGNED DEFAULT NULL,
  `cliente_id` bigint UNSIGNED DEFAULT NULL,
  `placa` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_trabajo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mantenimiento',
  `notas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Notas inline, ej: cambio de chip',
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente' COMMENT 'pendiente / completado / omitido',
  `imei` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_sim` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `orden` smallint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_order_photos`
--

CREATE TABLE `work_order_photos` (
  `id` bigint UNSIGNED NOT NULL,
  `work_order_id` bigint UNSIGNED NOT NULL,
  `work_order_checklist_id` bigint UNSIGNED DEFAULT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'private',
  `mime_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED DEFAULT NULL,
  `tipo` enum('checklist','general','evidencia') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'evidencia',
  `fase` enum('before','after','proceso') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `uploaded_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_order_signatures`
--

CREATE TABLE `work_order_signatures` (
  `id` bigint UNSIGNED NOT NULL,
  `work_order_id` bigint UNSIGNED NOT NULL,
  `tipo` enum('recepcion','conformidad') COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'private',
  `nombre_firmante` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_firmante` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `documento_firmante` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `firmado_at` datetime NOT NULL,
  `tecnico_id` bigint UNSIGNED NOT NULL,
  `hash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_order_types`
--

CREATE TABLE `work_order_types` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `requiere_imei` tinyint(1) NOT NULL DEFAULT '0',
  `requiere_sim` tinyint(1) NOT NULL DEFAULT '0',
  `requiere_accesorios` tinyint(1) NOT NULL DEFAULT '0',
  `requiere_checklist` tinyint(1) NOT NULL DEFAULT '1',
  `costo_base` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `es_mantenimiento_programado` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica si este tipo se usa para mantenimientos programados',
  `muestra_sector` tinyint(1) NOT NULL DEFAULT '1',
  `muestra_plan` tinyint(1) NOT NULL DEFAULT '1',
  `muestra_accesorios_instalar` tinyint(1) NOT NULL DEFAULT '1',
  `muestra_alertas` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Muestra el apartado de alertas GPS a configurar en la orden',
  `tipo_equipo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'gps | sensor_adas | velocimetro | null = cualquier equipo',
  `requiere_modelo_dispositivo` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Solicitar modelo del dispositivo al crear la orden',
  `requiere_operador_sim` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'El técnico debe especificar el operador SIM al crear la orden',
  `requiere_alertas` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Las alertas son obligatorias en este tipo de orden',
  `empresa_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_order_type_costs`
--

CREATE TABLE `work_order_type_costs` (
  `id` bigint UNSIGNED NOT NULL,
  `work_order_type_id` bigint UNSIGNED NOT NULL,
  `tecnico_id` bigint UNSIGNED NOT NULL,
  `costo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `empresa_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actas`
--
ALTER TABLE `actas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actas_user_id_foreign` (`user_id`),
  ADD KEY `actas_vehiculos_id_foreign` (`vehiculos_id`),
  ADD KEY `actas_ciudades_id_foreign` (`ciudades_id`),
  ADD KEY `actas_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indices de la tabla `anticipos_ventas`
--
ALTER TABLE `anticipos_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anticipos_ventas_venta_id_foreign` (`venta_id`);

--
-- Indices de la tabla `auth_states`
--
ALTER TABLE `auth_states`
  ADD UNIQUE KEY `idxunique` (`session`,`id`),
  ADD KEY `idxsession` (`session`),
  ADD KEY `idxid` (`id`);

--
-- Indices de la tabla `autoreplies`
--
ALTER TABLE `autoreplies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autoreplies_user_id_foreign` (`user_id`),
  ADD KEY `autoreplies_device_index` (`device`);

--
-- Indices de la tabla `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_bank_id_foreign` (`bank_id`);

--
-- Indices de la tabla `blasts`
--
ALTER TABLE `blasts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blasts_user_id_foreign` (`user_id`),
  ADD KEY `blasts_campaign_id_status_index` (`campaign_id`,`status`);

--
-- Indices de la tabla `cambios_lineas`
--
ALTER TABLE `cambios_lineas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cambios_lineas_sim_card_id_foreign` (`sim_card_id`),
  ADD KEY `cambios_lineas_old_numero_foreign` (`old_numero`),
  ADD KEY `cambios_lineas_new_numero_foreign` (`new_numero`),
  ADD KEY `cambios_lineas_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaigns_phonebook_id_foreign` (`phonebook_id`),
  ADD KEY `campaigns_user_id_status_index` (`user_id`,`status`),
  ADD KEY `campaigns_sender_index` (`sender`);

--
-- Indices de la tabla `card_brands`
--
ALTER TABLE `card_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cash`
--
ALTER TABLE `cash`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_user_id_foreign` (`user_id`),
  ADD KEY `cash_empresa_id_foreign` (`empresa_id`),
  ADD KEY `cash_reference_number_index` (`reference_number`);

--
-- Indices de la tabla `cash_documents`
--
ALTER TABLE `cash_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_documents_cash_id_index` (`cash_id`),
  ADD KEY `cash_documents_factura_id_index` (`factura_id`),
  ADD KEY `cash_documents_recibo_id_index` (`recibo_id`),
  ADD KEY `cash_documents_venta_id_index` (`venta_id`);

--
-- Indices de la tabla `cash_document_credits`
--
ALTER TABLE `cash_document_credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_document_credits_cash_id_foreign` (`cash_id`),
  ADD KEY `cash_document_credits_cash_id_processed_foreign` (`cash_id_processed`),
  ADD KEY `cash_document_credits_status_index` (`status`);

--
-- Indices de la tabla `cash_document_payments`
--
ALTER TABLE `cash_document_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_document_payments_cash_document_id_foreign` (`cash_document_id`),
  ADD KEY `cash_document_payments_cash_id_index` (`cash_id`),
  ADD KEY `cash_document_payments_payment_id_index` (`payment_id`),
  ADD KEY `cash_document_payments_cash_document_credit_id_index` (`cash_document_credit_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorias_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificados_user_id_foreign` (`user_id`),
  ADD KEY `certificados_vehiculos_id_foreign` (`vehiculos_id`),
  ADD KEY `certificados_ciudades_id_foreign` (`ciudades_id`),
  ADD KEY `certificados_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `certificados_antifatiga`
--
ALTER TABLE `certificados_antifatiga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificados_antifatiga_ciudades_id_foreign` (`ciudades_id`),
  ADD KEY `certificados_antifatiga_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `certificados_antifatiga_usuario_id_foreign` (`usuario_id`),
  ADD KEY `certificados_antifatiga_empresa_id_foreign` (`empresa_id`),
  ADD KEY `certificados_antifatiga_cliente_id_foreign` (`cliente_id`),
  ADD KEY `certificados_antifatiga_dispositivo_id_foreign` (`dispositivo_id`);

--
-- Indices de la tabla `certificados_velocimetros`
--
ALTER TABLE `certificados_velocimetros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certificados_velocimetros_vehiculos_id_foreign` (`vehiculos_id`),
  ADD KEY `certificados_velocimetros_user_id_foreign` (`user_id`),
  ADD KEY `certificados_velocimetros_ciudades_id_foreign` (`ciudades_id`);

--
-- Indices de la tabla `changes_models`
--
ALTER TABLE `changes_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `changes_models_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `checklist_templates`
--
ALTER TABLE `checklist_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checklist_templates_empresa_id_categoria_index` (`empresa_id`,`categoria`),
  ADD KEY `checklist_templates_orden_index` (`orden`);

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clientes_empresa_id_foreign` (`empresa_id`),
  ADD KEY `clientes_tipo_documento_id_foreign` (`tipo_documento_id`),
  ADD KEY `clientes_user_id_foreign` (`user_id`),
  ADD KEY `clientes_rubro_id_foreign` (`rubro_id`);

--
-- Indices de la tabla `cliente_password_resets`
--
ALTER TABLE `cliente_password_resets`
  ADD KEY `cliente_password_resets_email_index` (`email`);

--
-- Indices de la tabla `cliente_users`
--
ALTER TABLE `cliente_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cliente_users_email_unique` (`email`),
  ADD KEY `cliente_users_cliente_id_foreign` (`cliente_id`),
  ADD KEY `cliente_users_estado_index` (`estado`);

--
-- Indices de la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cobros_clientes_id_foreign` (`clientes_id`),
  ADD KEY `cobros_vehiculos_id_foreign` (`vehiculos_id`),
  ADD KEY `cobros_plan_id_foreign` (`plan_id`),
  ADD KEY `cobros_empresa_id_estado_index` (`empresa_id`,`estado`),
  ADD KEY `cobros_empresa_id_clientes_id_index` (`empresa_id`,`clientes_id`),
  ADD KEY `cobros_empresa_id_fecha_vencimiento_estado_index` (`empresa_id`,`fecha_vencimiento`,`estado`);

--
-- Indices de la tabla `codigos_detracciones`
--
ALTER TABLE `codigos_detracciones`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_empresa_id_foreign` (`empresa_id`),
  ADD KEY `compra_tipo_comprobante_id_foreign` (`tipo_comprobante_id`);

--
-- Indices de la tabla `compras_factura`
--
ALTER TABLE `compras_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_factura_proveedores_id_foreign` (`proveedores_id`),
  ADD KEY `compras_factura_empresa_id_foreign` (`empresa_id`),
  ADD KEY `compras_fac_users` (`user_id`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comprobantes_tipo_comprobante_id_foreign` (`tipo_comprobante_id`),
  ADD KEY `comprobantes_cliente_id_foreign` (`cliente_id`),
  ADD KEY `comprobantes_invoice_id_foreign` (`invoice_id`),
  ADD KEY `comprobantes_invoice_id_new_foreign` (`invoice_id_new`),
  ADD KEY `comprobantes_sustento_id_foreign` (`sustento_id`),
  ADD KEY `comprobantes_user_id_foreign` (`user_id`),
  ADD KEY `comprobantes_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contactos_empresa_id_foreign` (`empresa_id`),
  ADD KEY `contactos_clientes_id_foreign` (`clientes_id`);

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_tag_id_foreign` (`tag_id`),
  ADD KEY `contacts_user_id_tag_id_index` (`user_id`,`tag_id`);

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contratos_empresa_id_foreign` (`empresa_id`),
  ADD KEY `contratos_ciudades_id_foreign` (`ciudades_id`),
  ADD KEY `contratos_clientes_id_foreign` (`clientes_id`),
  ADD KEY `contratos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_compras_facturas_id_foreign` (`facturas_id`),
  ADD KEY `detalle_compras_compras_id_foreign` (`compras_id`),
  ADD KEY `detalle_compras_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `detalle_comprobantes`
--
ALTER TABLE `detalle_comprobantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_comprobantes_comprobante_id_foreign` (`comprobante_id`),
  ADD KEY `detalle_comprobantes_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `detalle_contratos`
--
ALTER TABLE `detalle_contratos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_contratos_vehiculos_id_foreign` (`vehiculos_id`),
  ADD KEY `detalle_contratos_contratos_id_foreign` (`contratos_id`);

--
-- Indices de la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_facturas_facturas_id_foreign` (`facturas_id`),
  ADD KEY `detalle_facturas_producto_id_foreign` (`producto_id`),
  ADD KEY `detalle_facturas_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `detalle_guia_remision`
--
ALTER TABLE `detalle_guia_remision`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle_guia` (`guia_remision_id`),
  ADD KEY `fk_guia_d_producto` (`producto_id`);

--
-- Indices de la tabla `detalle_presupuestos`
--
ALTER TABLE `detalle_presupuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_presupuestos_presupuestos_id_foreign` (`presupuestos_id`),
  ADD KEY `detalle_presupuestos_producto_id_foreign` (`producto_id`),
  ADD KEY `detalle_presupuestos_empresa_id_foreign` (`empresa_id`),
  ADD KEY `detalle_presupuestos_plan_id_foreign` (`plan_id`);

--
-- Indices de la tabla `detalle_recibos`
--
ALTER TABLE `detalle_recibos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_recibos_recibos_id_foreign` (`recibos_id`),
  ADD KEY `detalle_recibos_producto_id_foreign` (`producto_id`),
  ADD KEY `detalle_recibos_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `detalle_recibos_pagos`
--
ALTER TABLE `detalle_recibos_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_recibos_pagos_recibos_id_foreign` (`recibos_id`),
  ADD KEY `detalle_recibos_pagos_empresa_id_foreign` (`empresa_id`),
  ADD KEY `detalle_recibos_pagos_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `detalle_reportes`
--
ALTER TABLE `detalle_reportes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_reportes_reportes_id_foreign` (`reportes_id`),
  ADD KEY `detalle_reportes_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `detracciones`
--
ALTER TABLE `detracciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detracciones_codigo_detraccion_foreign` (`codigo_detraccion`),
  ADD KEY `detracciones_metodo_pago_id_foreign` (`metodo_pago_id`),
  ADD KEY `detracciones_venta_id_foreign` (`venta_id`);

--
-- Indices de la tabla `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `devices_body_unique` (`body`),
  ADD UNIQUE KEY `devices_api_key_unique` (`api_key`),
  ADD KEY `devices_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `device_history`
--
ALTER TABLE `device_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_history_work_order_id_foreign` (`work_order_id`),
  ADD KEY `device_history_dispositivo_id_foreign` (`dispositivo_id`),
  ADD KEY `device_history_sim_card_id_foreign` (`sim_card_id`),
  ADD KEY `device_history_dispositivo_anterior_id_foreign` (`dispositivo_anterior_id`),
  ADD KEY `device_history_sim_card_anterior_id_foreign` (`sim_card_anterior_id`),
  ADD KEY `device_history_empresa_id_foreign` (`empresa_id`),
  ADD KEY `device_history_vehiculo_id_index` (`vehiculo_id`),
  ADD KEY `device_history_fecha_instalacion_index` (`fecha_instalacion`);

--
-- Indices de la tabla `device_maintenances`
--
ALTER TABLE `device_maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_maintenances_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `device_maintenances_user_id_foreign` (`user_id`),
  ADD KEY `device_maintenances_empresa_id_tipo_fecha_index` (`empresa_id`,`tipo`,`fecha`),
  ADD KEY `device_maintenances_empresa_id_vehiculo_id_index` (`empresa_id`,`vehiculo_id`),
  ADD KEY `device_maintenances_tracking_device_id_index` (`tracking_device_id`);

--
-- Indices de la tabla `dispatchers`
--
ALTER TABLE `dispatchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dispatchers_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dispositivos_imei_unique` (`imei`),
  ADD KEY `dispositivos_modelo_id_foreign` (`modelo_id`),
  ADD KEY `dispositivos_empresa_id_foreign` (`empresa_id`),
  ADD KEY `dispositivos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `dispositivos_users`
--
ALTER TABLE `dispositivos_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dispositivos_users_user_id_foreign` (`user_id`),
  ADD KEY `dispositivos_users_guia_remision_id_foreign` (`guia_remision_id`),
  ADD KEY `dispositivos_users_imei_foreign` (`imei`),
  ADD KEY `dispositivos_users_tecnico_id_foreign` (`tecnico_id`);

--
-- Indices de la tabla `divisas`
--
ALTER TABLE `divisas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `drivers_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `envio_resumen`
--
ALTER TABLE `envio_resumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `envio_resumen_user_id_foreign` (`user_id`),
  ADD KEY `envio_resumen_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `envio_resumen_detalle_envio_resumen_id_foreign` (`envio_resumen_id`),
  ADD KEY `envio_resumen_detalle_venta_id_foreign` (`venta_id`);

--
-- Indices de la tabla `expense_method_types`
--
ALTER TABLE `expense_method_types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `expense_payments`
--
ALTER TABLE `expense_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_payments_expense_id_index` (`expense_id`),
  ADD KEY `expense_payments_date_of_payment_index` (`date_of_payment`),
  ADD KEY `expense_payments_expense_method_type_id_index` (`expense_method_type_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facturas_empresa_id_foreign` (`empresa_id`),
  ADD KEY `facturas_clientes_id_foreign` (`clientes_id`),
  ADD KEY `facturas_presupuestos_id_foreign` (`presupuestos_id`),
  ADD KEY `facturas_user_id_foreign` (`user_id`),
  ADD KEY `facturas_forma_pago_foreign` (`forma_pago`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `features_plan_id_slug_unique` (`plan_id`,`slug`);

--
-- Indices de la tabla `flotas`
--
ALTER TABLE `flotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flotas_clientes_id_foreign` (`clientes_id`),
  ADD KEY `flotas_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `group_metadata_cache`
--
ALTER TABLE `group_metadata_cache`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_metadata_cache_session_id_group_jid_unique` (`session_id`,`group_jid`),
  ADD KEY `group_metadata_cache_session_id_index` (`session_id`),
  ADD KEY `group_metadata_cache_group_jid_index` (`group_jid`);

--
-- Indices de la tabla `guia_remision`
--
ALTER TABLE `guia_remision`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guia_remision_cliente_id_foreign` (`cliente_id`),
  ADD KEY `guia_remision_venta_id_foreign` (`venta_id`),
  ADD KEY `guia_remision_motivo_traslado_id_foreign` (`motivo_traslado_id`),
  ADD KEY `fk_guia_modalidad_t` (`modalidad_transporte_id`),
  ADD KEY `guia_remision_empresa_id_foreign` (`empresa_id`),
  ADD KEY `guia_remision_tecnico_id_foreign` (`tecnico_id`),
  ADD KEY `guia_remision_user_id_foreign` (`user_id`),
  ADD KEY `guia_remision_driver_id_foreign` (`driver_id`),
  ADD KEY `guia_remision_transport_id_foreign` (`transport_id`),
  ADD KEY `guia_remision_dispatcher_id_foreign` (`dispatcher_id`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `informe_tarea`
--
ALTER TABLE `informe_tarea`
  ADD PRIMARY KEY (`id`),
  ADD KEY `informe_tarea_tarea_id_foreign` (`tarea_id`),
  ADD KEY `informe_tarea_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `ip_whitelists`
--
ALTER TABLE `ip_whitelists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_whitelists_created_by_foreign` (`created_by`),
  ADD KEY `ip_whitelists_ip_address_is_active_index` (`ip_address`,`is_active`),
  ADD KEY `ip_whitelists_domain_is_active_index` (`domain`,`is_active`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `kpis`
--
ALTER TABLE `kpis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kpis_empresa_id_foreign` (`empresa_id`),
  ADD KEY `kpis_slug_index` (`slug`);

--
-- Indices de la tabla `kpi_alertas`
--
ALTER TABLE `kpi_alertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kpi_alertas_kpi_id_foreign` (`kpi_id`),
  ADD KEY `kpi_alertas_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `kpi_resultados`
--
ALTER TABLE `kpi_resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kpi_resultados_registrado_por_foreign` (`registrado_por`),
  ADD KEY `kpi_resultados_kpi_id_periodo_inicio_index` (`kpi_id`,`periodo_inicio`),
  ADD KEY `kpi_resultados_empresa_id_periodo_inicio_index` (`empresa_id`,`periodo_inicio`);

--
-- Indices de la tabla `lid_mappings`
--
ALTER TABLE `lid_mappings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lid_mappings_lid_unique` (`lid`),
  ADD UNIQUE KEY `lid_mappings_pn_unique` (`pn`),
  ADD KEY `lid_mappings_lid_pn_index` (`lid`,`pn`);

--
-- Indices de la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lineas_user_id_foreign` (`user_id`),
  ADD KEY `lineas_operador_id_foreign` (`operador_id`);

--
-- Indices de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mantenimientos_user_id_foreign` (`user_id`),
  ADD KEY `mantenimientos_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `mantenimientos_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajes_from_user_id_foreign` (`from_user_id`),
  ADD KEY `mensajes_to_user_id_foreign` (`to_user_id`),
  ADD KEY `mensajes_messageable_type_messageable_id_index` (`messageable_type`,`messageable_id`);

--
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_from_user_id_foreign` (`from_user_id`),
  ADD KEY `messages_to_user_id_foreign` (`to_user_id`);

--
-- Indices de la tabla `message_histories`
--
ALTER TABLE `message_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_histories_user_id_foreign` (`user_id`),
  ADD KEY `message_histories_device_id_created_at_index` (`device_id`,`created_at`),
  ADD KEY `message_histories_number_index` (`number`);

--
-- Indices de la tabla `message_store`
--
ALTER TABLE `message_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `msg_store_composite_idx` (`session_id`,`remote_jid`,`message_id`,`from_me`),
  ADD KEY `message_store_session_id_index` (`session_id`),
  ADD KEY `message_store_remote_jid_index` (`remote_jid`),
  ADD KEY `message_store_message_id_index` (`message_id`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modalidad_transporte`
--
ALTER TABLE `modalidad_transporte`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `modelos_dispositivos`
--
ALTER TABLE `modelos_dispositivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `motivos_traslado`
--
ALTER TABLE `motivos_traslado`
  ADD UNIQUE KEY `motivos_traslado_codigo_unique` (`codigo`);

--
-- Indices de la tabla `motivo_traslado`
--
ALTER TABLE `motivo_traslado`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nota_credito_tipo_comprobante_id_foreign` (`tipo_comprobante_id`),
  ADD KEY `nota_credito_cliente_id_foreign` (`cliente_id`),
  ADD KEY `nota_credito_invoice_id_foreign` (`invoice_id`),
  ADD KEY `nota_credito_invoice_id_new_foreign` (`invoice_id_new`),
  ADD KEY `nota_credito_sustento_id_foreign` (`sustento_id`),
  ADD KEY `nota_credito_user_id_foreign` (`user_id`),
  ADD KEY `nota_credito_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `nota_credito_detalles`
--
ALTER TABLE `nota_credito_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nota_credito_detalles_nota_credito_id_foreign` (`nota_credito_id`),
  ADD KEY `nota_credito_detalles_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `nota_debito`
--
ALTER TABLE `nota_debito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nota_debito_tipo_comprobante_id_foreign` (`tipo_comprobante_id`),
  ADD KEY `nota_debito_cliente_id_foreign` (`cliente_id`),
  ADD KEY `nota_debito_invoice_id_foreign` (`invoice_id`),
  ADD KEY `nota_debito_invoice_id_new_foreign` (`invoice_id_new`),
  ADD KEY `nota_debito_sustento_id_foreign` (`sustento_id`),
  ADD KEY `nota_debito_user_id_foreign` (`user_id`),
  ADD KEY `nota_debito_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `nota_debito_detalles`
--
ALTER TABLE `nota_debito_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nota_debito_detalles_nota_debito_id_foreign` (`nota_debito_id`),
  ADD KEY `nota_debito_detalles_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `old_sim_card_linea`
--
ALTER TABLE `old_sim_card_linea`
  ADD PRIMARY KEY (`id`),
  ADD KEY `old_sim_card_linea_user_id_foreign` (`user_id`),
  ADD KEY `old_sim_card_linea_linea_id_foreign` (`linea_id`);

--
-- Indices de la tabla `operadores`
--
ALTER TABLE `operadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_paymentable_type_paymentable_id_index` (`paymentable_type`,`paymentable_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_empresa_id_foreign` (`empresa_id`),
  ADD KEY `payments_cobros_id_foreign` (`cobros_id`),
  ADD KEY `payments_destination_index` (`destination_type`,`destination_id`),
  ADD KEY `payments_bank_account_id_foreign` (`bank_account_id`);

--
-- Indices de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `payment_method_types`
--
ALTER TABLE `payment_method_types`
  ADD PRIMARY KEY (`id`,`empresa_id`),
  ADD KEY `payment_method_types_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `periodos_cobros`
--
ALTER TABLE `periodos_cobros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periodos_cobros_cliente_id_foreign` (`cliente_id`),
  ADD KEY `periodos_cobros_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `periodos_cobros_venta_id_foreign` (`venta_id`),
  ADD KEY `periodos_cobros_recibo_id_foreign` (`recibo_id`),
  ADD KEY `periodos_cobros_empresa_id_estado_index` (`empresa_id`,`estado`),
  ADD KEY `periodos_cobros_empresa_id_fecha_fin_estado_index` (`empresa_id`,`fecha_fin`,`estado`),
  ADD KEY `periodos_cobros_cobros_id_index` (`cobros_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plans_slug_unique` (`slug`),
  ADD KEY `plans_producto_id_foreign` (`producto_id`),
  ADD KEY `plans_empresa_id_foreign` (`empresa_id`),
  ADD KEY `plans_sla_tier_index` (`sla_tier`);

--
-- Indices de la tabla `plantilla`
--
ALTER TABLE `plantilla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plantilla_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `postventa_plantillas`
--
ALTER TABLE `postventa_plantillas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postventa_plantillas_sector_id_foreign` (`sector_id`),
  ADD KEY `postventa_plantillas_empresa_id_sector_id_index` (`empresa_id`,`sector_id`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presupuestos_user_id_foreign` (`user_id`),
  ADD KEY `presupuestos_clientes_id_foreign` (`clientes_id`),
  ADD KEY `presupuestos_empresa_id_foreign` (`empresa_id`),
  ADD KEY `fk_tipo_c_presupuesto` (`tipo_comprobante_id`),
  ADD KEY `presupuestos_metodo_pago_id_foreign` (`metodo_pago_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_unit_code_foreign` (`unit_code`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `productos_user_id_foreign` (`user_id`),
  ADD KEY `productos_modelo_id_foreign` (`modelo_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedores_tipo_documento_id_index` (`tipo_documento_id`);

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
-- Indices de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recordatorios_user_id_foreign` (`user_id`),
  ADD KEY `recordatorios_reportes_id_foreign` (`reportes_id`);

--
-- Indices de la tabla `registro_cobros`
--
ALTER TABLE `registro_cobros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registro_cobros_cobros_id_foreign` (`cobros_id`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reportes_vehiculos_id_foreign` (`vehiculos_id`),
  ADD KEY `reportes_user_id_foreign` (`user_id`),
  ADD KEY `reportes_atendido_por_foreign` (`atendido_por`);

--
-- Indices de la tabla `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `rubros_cliente`
--
ALTER TABLE `rubros_cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rubros_cliente_empresa_id_is_active_index` (`empresa_id`,`is_active`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sectores_empresa_id_is_active_index` (`empresa_id`,`is_active`);

--
-- Indices de la tabla `sector_vehiculo`
--
ALTER TABLE `sector_vehiculo`
  ADD PRIMARY KEY (`sector_id`,`vehiculo_id`),
  ADD KEY `sector_vehiculo_vehiculo_id_foreign` (`vehiculo_id`);

--
-- Indices de la tabla `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `series_tipo_comprobante_id_foreign` (`tipo_comprobante_id`),
  ADD KEY `series_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `sim_card`
--
ALTER TABLE `sim_card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sim_card_sim_card_unique` (`sim_card`),
  ADD KEY `sim_card_lineas_id_foreign` (`lineas_id`),
  ADD KEY `sim_card_operador_id_foreign` (`operador_id`);

--
-- Indices de la tabla `sim_card_users`
--
ALTER TABLE `sim_card_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sim_card_users_user_id_foreign` (`user_id`),
  ADD KEY `sim_card_users_guia_remision_id_foreign` (`guia_remision_id`),
  ADD KEY `sim_card_users_sim_card_foreign` (`sim_card`),
  ADD KEY `sim_card_users_tecnico_id_foreign` (`tecnico_id`);

--
-- Indices de la tabla `sla_plan_rules`
--
ALTER TABLE `sla_plan_rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sla_plan_rules_plan_type_priority_unique` (`plan_type`,`priority`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_subscriber_type_subscriber_id_index` (`subscriber_type`,`subscriber_id`),
  ADD KEY `subscriptions_empresa_id_foreign` (`empresa_id`),
  ADD KEY `subscriptions_subscriber_id_subscriber_type_plan_id_index` (`subscriber_id`,`subscriber_type`,`plan_id`);

--
-- Indices de la tabla `subscription_usage`
--
ALTER TABLE `subscription_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_usage_subscription_id_feature_id_index` (`subscription_id`,`feature_id`);

--
-- Indices de la tabla `sustentos`
--
ALTER TABLE `sustentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sustentos_codigo_index` (`codigo`);

--
-- Indices de la tabla `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tags_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tareas_vehiculos_id_foreign` (`vehiculos_id`),
  ADD KEY `tareas_cliente_id_foreign` (`cliente_id`),
  ADD KEY `tareas_tipo_tarea_id_foreign` (`tipo_tarea_id`),
  ADD KEY `tareas_user_id_foreign` (`user_id`),
  ADD KEY `tareas_tecnico_id_foreign` (`tecnico_id`),
  ADD KEY `tareas_empresa_id_foreign` (`empresa_id`),
  ADD KEY `tareas_mantenimiento_id_foreign` (`mantenimiento_id`);

--
-- Indices de la tabla `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teams_empresa_id_name_unique` (`empresa_id`,`name`),
  ADD KEY `teams_is_active_index` (`is_active`),
  ADD KEY `teams_kpi_area_index` (`kpi_area`);

--
-- Indices de la tabla `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`),
  ADD KEY `team_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `telescope_entries`
--
ALTER TABLE `telescope_entries`
  ADD PRIMARY KEY (`sequence`),
  ADD UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  ADD KEY `telescope_entries_batch_id_index` (`batch_id`),
  ADD KEY `telescope_entries_family_hash_index` (`family_hash`),
  ADD KEY `telescope_entries_created_at_index` (`created_at`),
  ADD KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`);

--
-- Indices de la tabla `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD PRIMARY KEY (`entry_uuid`,`tag`),
  ADD KEY `telescope_entries_tags_tag_index` (`tag`);

--
-- Indices de la tabla `telescope_monitoring`
--
ALTER TABLE `telescope_monitoring`
  ADD PRIMARY KEY (`tag`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_code_unique` (`code`),
  ADD KEY `tickets_empresa_id_foreign` (`empresa_id`),
  ADD KEY `tickets_category_id_foreign` (`category_id`),
  ADD KEY `tickets_created_by_foreign` (`created_by`),
  ADD KEY `tickets_customer_id_index` (`customer_id`),
  ADD KEY `tickets_team_id_index` (`team_id`),
  ADD KEY `tickets_assigned_to_index` (`assigned_to`),
  ADD KEY `tickets_status_priority_index` (`status`,`priority`),
  ADD KEY `tickets_status_index` (`status`),
  ADD KEY `tickets_priority_index` (`priority`),
  ADD KEY `tickets_last_activity_at_index` (`last_activity_at`),
  ADD KEY `tickets_vehiculo_id_foreign` (`vehiculo_id`);

--
-- Indices de la tabla `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_attachments_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `ticket_attachments_ticket_id_index` (`ticket_id`),
  ADD KEY `ticket_attachments_message_id_index` (`message_id`);

--
-- Indices de la tabla `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_categories_empresa_id_name_unique` (`empresa_id`,`name`),
  ADD KEY `ticket_categories_is_active_index` (`is_active`);

--
-- Indices de la tabla `ticket_events`
--
ALTER TABLE `ticket_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_events_actor_id_foreign` (`actor_id`),
  ADD KEY `ticket_events_ticket_id_index` (`ticket_id`),
  ADD KEY `ticket_events_type_index` (`type`),
  ADD KEY `ticket_events_created_at_index` (`created_at`);

--
-- Indices de la tabla `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_messages_author_id_foreign` (`author_id`),
  ADD KEY `ticket_messages_ticket_id_index` (`ticket_id`),
  ADD KEY `ticket_messages_is_internal_index` (`is_internal`);

--
-- Indices de la tabla `ticket_relations`
--
ALTER TABLE `ticket_relations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_relations_ticket_id_related_ticket_id_unique` (`ticket_id`,`related_ticket_id`),
  ADD KEY `ticket_relations_related_ticket_id_foreign` (`related_ticket_id`),
  ADD KEY `ticket_relations_created_by_foreign` (`created_by`);

--
-- Indices de la tabla `ticket_sequences`
--
ALTER TABLE `ticket_sequences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_sequences_empresa_id_year_unique` (`empresa_id`,`year`);

--
-- Indices de la tabla `ticket_templates`
--
ALTER TABLE `ticket_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_templates_empresa_id_foreign` (`empresa_id`),
  ADD KEY `ticket_templates_created_by_foreign` (`created_by`);

--
-- Indices de la tabla `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipo_afectacion_codigo_unique` (`codigo`);

--
-- Indices de la tabla `tipo_cambios`
--
ALTER TABLE `tipo_cambios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipo_cambios_fecha_unique` (`fecha`),
  ADD KEY `tipo_cambios_fecha_index` (`fecha`);

--
-- Indices de la tabla `tipo_comprobantes`
--
ALTER TABLE `tipo_comprobantes`
  ADD UNIQUE KEY `tipo_comprobantes_codigo_unique` (`codigo`);

--
-- Indices de la tabla `tipo_documentos`
--
ALTER TABLE `tipo_documentos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tipo_tareas`
--
ALTER TABLE `tipo_tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_tareas_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transports_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `ubigeos`
--
ALTER TABLE `ubigeos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `units`
--
ALTER TABLE `units`
  ADD UNIQUE KEY `units_codigo_unique` (`codigo`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_series_id_foreign` (`series_id`),
  ADD KEY `users_ciudad_id_foreign` (`ciudad_id`);

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
-- Indices de la tabla `vehiculos_flotas`
--
ALTER TABLE `vehiculos_flotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculos_flotas_vehiculos_id_foreign` (`vehiculos_id`),
  ADD KEY `vehiculos_flotas_flotas_id_foreign` (`flotas_id`);

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
-- Indices de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_detalles_ventas_id_foreign` (`ventas_id`);

--
-- Indices de la tabla `whatsapp_groups`
--
ALTER TABLE `whatsapp_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `whatsapp_groups_user_id_device_body_group_id_unique` (`user_id`,`device_body`,`group_id`),
  ADD KEY `whatsapp_groups_user_id_device_body_index` (`user_id`,`device_body`);

--
-- Indices de la tabla `wigs`
--
ALTER TABLE `wigs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wigs_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `work_orders`
--
ALTER TABLE `work_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `work_orders_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `work_orders_verification_hash_unique` (`verification_hash`),
  ADD KEY `work_orders_work_order_type_id_foreign` (`work_order_type_id`),
  ADD KEY `work_orders_vehiculo_id_foreign` (`vehiculo_id`),
  ADD KEY `work_orders_cliente_id_foreign` (`cliente_id`),
  ADD KEY `work_orders_tecnico_id_foreign` (`tecnico_id`),
  ADD KEY `work_orders_created_by_foreign` (`created_by`),
  ADD KEY `work_orders_estado_index` (`estado`),
  ADD KEY `work_orders_fecha_programada_index` (`fecha_programada`),
  ADD KEY `work_orders_empresa_id_estado_index` (`empresa_id`,`estado`),
  ADD KEY `work_orders_mantenimiento_id_foreign` (`mantenimiento_id`),
  ADD KEY `work_orders_presupuesto_id_foreign` (`presupuesto_id`);

--
-- Indices de la tabla `work_order_accessories`
--
ALTER TABLE `work_order_accessories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_accessories_producto_id_foreign` (`producto_id`),
  ADD KEY `work_order_accessories_work_order_id_index` (`work_order_id`);

--
-- Indices de la tabla `work_order_checklists`
--
ALTER TABLE `work_order_checklists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wo_checklist_unique` (`work_order_id`,`checklist_template_id`,`fase`),
  ADD KEY `work_order_checklists_checklist_template_id_foreign` (`checklist_template_id`),
  ADD KEY `work_order_checklists_inspeccionado_by_foreign` (`inspeccionado_by`),
  ADD KEY `work_order_checklists_work_order_id_fase_index` (`work_order_id`,`fase`);

--
-- Indices de la tabla `work_order_items`
--
ALTER TABLE `work_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_items_work_order_id_foreign` (`work_order_id`),
  ADD KEY `work_order_items_vehiculo_id_foreign` (`vehiculo_id`);

--
-- Indices de la tabla `work_order_photos`
--
ALTER TABLE `work_order_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_photos_work_order_checklist_id_foreign` (`work_order_checklist_id`),
  ADD KEY `work_order_photos_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `work_order_photos_work_order_id_index` (`work_order_id`),
  ADD KEY `work_order_photos_tipo_index` (`tipo`);

--
-- Indices de la tabla `work_order_signatures`
--
ALTER TABLE `work_order_signatures`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `work_order_signatures_work_order_id_tipo_unique` (`work_order_id`,`tipo`),
  ADD KEY `work_order_signatures_tecnico_id_foreign` (`tecnico_id`),
  ADD KEY `work_order_signatures_work_order_id_index` (`work_order_id`),
  ADD KEY `work_order_signatures_tipo_index` (`tipo`);

--
-- Indices de la tabla `work_order_types`
--
ALTER TABLE `work_order_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_order_types_empresa_id_foreign` (`empresa_id`);

--
-- Indices de la tabla `work_order_type_costs`
--
ALTER TABLE `work_order_type_costs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_type_tecnico` (`work_order_type_id`,`tecnico_id`),
  ADD KEY `work_order_type_costs_tecnico_id_foreign` (`tecnico_id`),
  ADD KEY `work_order_type_costs_empresa_id_foreign` (`empresa_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actas`
--
ALTER TABLE `actas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `anticipos_ventas`
--
ALTER TABLE `anticipos_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `autoreplies`
--
ALTER TABLE `autoreplies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `blasts`
--
ALTER TABLE `blasts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cambios_lineas`
--
ALTER TABLE `cambios_lineas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cash`
--
ALTER TABLE `cash`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cash_documents`
--
ALTER TABLE `cash_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cash_document_credits`
--
ALTER TABLE `cash_document_credits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cash_document_payments`
--
ALTER TABLE `cash_document_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `certificados_antifatiga`
--
ALTER TABLE `certificados_antifatiga`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `certificados_velocimetros`
--
ALTER TABLE `certificados_velocimetros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `changes_models`
--
ALTER TABLE `changes_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `checklist_templates`
--
ALTER TABLE `checklist_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente_users`
--
ALTER TABLE `cliente_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cobros`
--
ALTER TABLE `cobros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras_factura`
--
ALTER TABLE `compras_factura`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_comprobantes`
--
ALTER TABLE `detalle_comprobantes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_contratos`
--
ALTER TABLE `detalle_contratos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_guia_remision`
--
ALTER TABLE `detalle_guia_remision`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_presupuestos`
--
ALTER TABLE `detalle_presupuestos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_recibos`
--
ALTER TABLE `detalle_recibos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_recibos_pagos`
--
ALTER TABLE `detalle_recibos_pagos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_reportes`
--
ALTER TABLE `detalle_reportes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detracciones`
--
ALTER TABLE `detracciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `device_history`
--
ALTER TABLE `device_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `device_maintenances`
--
ALTER TABLE `device_maintenances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dispatchers`
--
ALTER TABLE `dispatchers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dispositivos_users`
--
ALTER TABLE `dispositivos_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `divisas`
--
ALTER TABLE `divisas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envio_resumen`
--
ALTER TABLE `envio_resumen`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expense_method_types`
--
ALTER TABLE `expense_method_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expense_payments`
--
ALTER TABLE `expense_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `flotas`
--
ALTER TABLE `flotas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `group_metadata_cache`
--
ALTER TABLE `group_metadata_cache`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guia_remision`
--
ALTER TABLE `guia_remision`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informe_tarea`
--
ALTER TABLE `informe_tarea`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ip_whitelists`
--
ALTER TABLE `ip_whitelists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kpis`
--
ALTER TABLE `kpis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kpi_alertas`
--
ALTER TABLE `kpi_alertas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kpi_resultados`
--
ALTER TABLE `kpi_resultados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lid_mappings`
--
ALTER TABLE `lid_mappings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lineas`
--
ALTER TABLE `lineas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `message_histories`
--
ALTER TABLE `message_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `message_store`
--
ALTER TABLE `message_store`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modelos_dispositivos`
--
ALTER TABLE `modelos_dispositivos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota_credito_detalles`
--
ALTER TABLE `nota_credito_detalles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota_debito`
--
ALTER TABLE `nota_debito`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota_debito_detalles`
--
ALTER TABLE `nota_debito_detalles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `old_sim_card_linea`
--
ALTER TABLE `old_sim_card_linea`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operadores`
--
ALTER TABLE `operadores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periodos_cobros`
--
ALTER TABLE `periodos_cobros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plantilla`
--
ALTER TABLE `plantilla`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `postventa_plantillas`
--
ALTER TABLE `postventa_plantillas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_cobros`
--
ALTER TABLE `registro_cobros`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `review`
--
ALTER TABLE `review`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rubros_cliente`
--
ALTER TABLE `rubros_cliente`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `series`
--
ALTER TABLE `series`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sim_card`
--
ALTER TABLE `sim_card`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sim_card_users`
--
ALTER TABLE `sim_card_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sla_plan_rules`
--
ALTER TABLE `sla_plan_rules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subscription_usage`
--
ALTER TABLE `subscription_usage`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sustentos`
--
ALTER TABLE `sustentos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `telescope_entries`
--
ALTER TABLE `telescope_entries`
  MODIFY `sequence` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_events`
--
ALTER TABLE `ticket_events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_relations`
--
ALTER TABLE `ticket_relations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_sequences`
--
ALTER TABLE `ticket_sequences`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket_templates`
--
ALTER TABLE `ticket_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_cambios`
--
ALTER TABLE `tipo_cambios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_tareas`
--
ALTER TABLE `tipo_tareas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transports`
--
ALTER TABLE `transports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ubigeos`
--
ALTER TABLE `ubigeos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
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
-- AUTO_INCREMENT de la tabla `vehiculos_flotas`
--
ALTER TABLE `vehiculos_flotas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `whatsapp_groups`
--
ALTER TABLE `whatsapp_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `wigs`
--
ALTER TABLE `wigs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `work_orders`
--
ALTER TABLE `work_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `work_order_accessories`
--
ALTER TABLE `work_order_accessories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `work_order_checklists`
--
ALTER TABLE `work_order_checklists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `work_order_items`
--
ALTER TABLE `work_order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `work_order_photos`
--
ALTER TABLE `work_order_photos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `work_order_signatures`
--
ALTER TABLE `work_order_signatures`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `work_order_types`
--
ALTER TABLE `work_order_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `work_order_type_costs`
--
ALTER TABLE `work_order_type_costs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actas`
--
ALTER TABLE `actas`
  ADD CONSTRAINT `actas_ciudades_id_foreign` FOREIGN KEY (`ciudades_id`) REFERENCES `ciudades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `actas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `actas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `actas_vehiculos_id_foreign` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `anticipos_ventas`
--
ALTER TABLE `anticipos_ventas`
  ADD CONSTRAINT `anticipos_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `autoreplies`
--
ALTER TABLE `autoreplies`
  ADD CONSTRAINT `autoreplies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `blasts`
--
ALTER TABLE `blasts`
  ADD CONSTRAINT `blasts_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blasts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cambios_lineas`
--
ALTER TABLE `cambios_lineas`
  ADD CONSTRAINT `cambios_lineas_new_numero_foreign` FOREIGN KEY (`new_numero`) REFERENCES `lineas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cambios_lineas_old_numero_foreign` FOREIGN KEY (`old_numero`) REFERENCES `lineas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cambios_lineas_sim_card_id_foreign` FOREIGN KEY (`sim_card_id`) REFERENCES `sim_card` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cambios_lineas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_phonebook_id_foreign` FOREIGN KEY (`phonebook_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `campaigns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cash`
--
ALTER TABLE `cash`
  ADD CONSTRAINT `cash_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  ADD CONSTRAINT `cash_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `cash_documents`
--
ALTER TABLE `cash_documents`
  ADD CONSTRAINT `cash_documents_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cash` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cash_document_credits`
--
ALTER TABLE `cash_document_credits`
  ADD CONSTRAINT `cash_document_credits_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cash` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_document_credits_cash_id_processed_foreign` FOREIGN KEY (`cash_id_processed`) REFERENCES `cash` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `cash_document_payments`
--
ALTER TABLE `cash_document_payments`
  ADD CONSTRAINT `cash_document_payments_cash_document_credit_id_foreign` FOREIGN KEY (`cash_document_credit_id`) REFERENCES `cash_document_credits` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_document_payments_cash_document_id_foreign` FOREIGN KEY (`cash_document_id`) REFERENCES `cash_documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_document_payments_cash_id_foreign` FOREIGN KEY (`cash_id`) REFERENCES `cash` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_document_payments_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD CONSTRAINT `certificados_ciudades_id_foreign` FOREIGN KEY (`ciudades_id`) REFERENCES `ciudades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `certificados_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `certificados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `certificados_vehiculos_id_foreign` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `certificados_antifatiga`
--
ALTER TABLE `certificados_antifatiga`
  ADD CONSTRAINT `certificados_antifatiga_ciudades_id_foreign` FOREIGN KEY (`ciudades_id`) REFERENCES `ciudades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `certificados_antifatiga_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `certificados_antifatiga_dispositivo_id_foreign` FOREIGN KEY (`dispositivo_id`) REFERENCES `dispositivos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `certificados_antifatiga_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificados_antifatiga_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificados_antifatiga_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `certificados_velocimetros`
--
ALTER TABLE `certificados_velocimetros`
  ADD CONSTRAINT `certificados_velocimetros_ciudades_id_foreign` FOREIGN KEY (`ciudades_id`) REFERENCES `ciudades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `certificados_velocimetros_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificados_velocimetros_vehiculos_id_foreign` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `changes_models`
--
ALTER TABLE `changes_models`
  ADD CONSTRAINT `changes_models_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `checklist_templates`
--
ALTER TABLE `checklist_templates`
  ADD CONSTRAINT `checklist_templates_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clientes_rubro_id_foreign` FOREIGN KEY (`rubro_id`) REFERENCES `rubros_cliente` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `clientes_tipo_documento_id_foreign` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documentos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clientes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente_users`
--
ALTER TABLE `cliente_users`
  ADD CONSTRAINT `cliente_users_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD CONSTRAINT `cobros_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cobros_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cobros_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cobros_vehiculos_id_foreign` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `compras_tipo_comprobante_id_foreign` FOREIGN KEY (`tipo_comprobante_id`) REFERENCES `tipo_comprobantes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compras_factura`
--
ALTER TABLE `compras_factura`
  ADD CONSTRAINT `compras_fac_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `compras_factura_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compras_factura_proveedores_id_foreign` FOREIGN KEY (`proveedores_id`) REFERENCES `proveedores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD CONSTRAINT `comprobantes_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comprobantes_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comprobantes_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comprobantes_invoice_id_new_foreign` FOREIGN KEY (`invoice_id_new`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comprobantes_sustento_id_foreign` FOREIGN KEY (`sustento_id`) REFERENCES `sustentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comprobantes_tipo_comprobante_id_foreign` FOREIGN KEY (`tipo_comprobante_id`) REFERENCES `tipo_comprobantes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comprobantes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contactos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `contratos_ciudades_id_foreign` FOREIGN KEY (`ciudades_id`) REFERENCES `ciudades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contratos_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contratos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contratos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_compras_id_foreign` FOREIGN KEY (`compras_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compras_facturas_id_foreign` FOREIGN KEY (`facturas_id`) REFERENCES `compras_factura` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_compras_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_comprobantes`
--
ALTER TABLE `detalle_comprobantes`
  ADD CONSTRAINT `detalle_comprobantes_comprobante_id_foreign` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_comprobantes_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_contratos`
--
ALTER TABLE `detalle_contratos`
  ADD CONSTRAINT `detalle_contratos_contratos_id_foreign` FOREIGN KEY (`contratos_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_contratos_vehiculos_id_foreign` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  ADD CONSTRAINT `detalle_facturas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_facturas_facturas_id_foreign` FOREIGN KEY (`facturas_id`) REFERENCES `facturas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_facturas_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_guia_remision`
--
ALTER TABLE `detalle_guia_remision`
  ADD CONSTRAINT `fk_detalle_guia` FOREIGN KEY (`guia_remision_id`) REFERENCES `guia_remision` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_guia_d_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalle_presupuestos`
--
ALTER TABLE `detalle_presupuestos`
  ADD CONSTRAINT `detalle_presupuestos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_presupuestos_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `detalle_presupuestos_presupuestos_id_foreign` FOREIGN KEY (`presupuestos_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_presupuestos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalle_recibos`
--
ALTER TABLE `detalle_recibos`
  ADD CONSTRAINT `detalle_recibos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_recibos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_recibos_recibos_id_foreign` FOREIGN KEY (`recibos_id`) REFERENCES `recibos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_recibos_pagos`
--
ALTER TABLE `detalle_recibos_pagos`
  ADD CONSTRAINT `detalle_recibos_pagos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_recibos_pagos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_recibos_pagos_recibos_id_foreign` FOREIGN KEY (`recibos_id`) REFERENCES `recibos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_reportes`
--
ALTER TABLE `detalle_reportes`
  ADD CONSTRAINT `detalle_reportes_reportes_id_foreign` FOREIGN KEY (`reportes_id`) REFERENCES `reportes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_reportes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detracciones`
--
ALTER TABLE `detracciones`
  ADD CONSTRAINT `detracciones_codigo_detraccion_foreign` FOREIGN KEY (`codigo_detraccion`) REFERENCES `codigos_detracciones` (`codigo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `detracciones_metodo_pago_id_foreign` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodo_pago` (`codigo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `detracciones_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `device_history`
--
ALTER TABLE `device_history`
  ADD CONSTRAINT `device_history_dispositivo_anterior_id_foreign` FOREIGN KEY (`dispositivo_anterior_id`) REFERENCES `dispositivos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `device_history_dispositivo_id_foreign` FOREIGN KEY (`dispositivo_id`) REFERENCES `dispositivos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `device_history_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `device_history_sim_card_anterior_id_foreign` FOREIGN KEY (`sim_card_anterior_id`) REFERENCES `sim_card` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `device_history_sim_card_id_foreign` FOREIGN KEY (`sim_card_id`) REFERENCES `sim_card` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `device_history_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`),
  ADD CONSTRAINT `device_history_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `device_maintenances`
--
ALTER TABLE `device_maintenances`
  ADD CONSTRAINT `device_maintenances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `device_maintenances_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `dispatchers`
--
ALTER TABLE `dispatchers`
  ADD CONSTRAINT `dispatchers_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `dispositivos`
--
ALTER TABLE `dispositivos`
  ADD CONSTRAINT `dispositivos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dispositivos_modelo_id_foreign` FOREIGN KEY (`modelo_id`) REFERENCES `modelos_dispositivos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dispositivos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `dispositivos_users`
--
ALTER TABLE `dispositivos_users`
  ADD CONSTRAINT `dispositivos_users_guia_remision_id_foreign` FOREIGN KEY (`guia_remision_id`) REFERENCES `guia_remision` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dispositivos_users_imei_foreign` FOREIGN KEY (`imei`) REFERENCES `dispositivos` (`imei`),
  ADD CONSTRAINT `dispositivos_users_tecnico_id_foreign` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dispositivos_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `envio_resumen`
--
ALTER TABLE `envio_resumen`
  ADD CONSTRAINT `envio_resumen_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `envio_resumen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  ADD CONSTRAINT `envio_resumen_detalle_envio_resumen_id_foreign` FOREIGN KEY (`envio_resumen_id`) REFERENCES `envio_resumen` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `envio_resumen_detalle_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `expense_payments`
--
ALTER TABLE `expense_payments`
  ADD CONSTRAINT `expense_payments_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expense_payments_expense_method_type_id_foreign` FOREIGN KEY (`expense_method_type_id`) REFERENCES `expense_method_types` (`id`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `facturas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `facturas_forma_pago_foreign` FOREIGN KEY (`forma_pago`) REFERENCES `payment_methods` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `facturas_presupuestos_id_foreign` FOREIGN KEY (`presupuestos_id`) REFERENCES `presupuestos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `facturas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `flotas`
--
ALTER TABLE `flotas`
  ADD CONSTRAINT `flotas_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `flotas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `guia_remision`
--
ALTER TABLE `guia_remision`
  ADD CONSTRAINT `fk_guia_modalidad_t` FOREIGN KEY (`modalidad_transporte_id`) REFERENCES `modalidad_transporte` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `guia_remision_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `guia_remision_dispatcher_id_foreign` FOREIGN KEY (`dispatcher_id`) REFERENCES `dispatchers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `guia_remision_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `guia_remision_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `guia_remision_motivo_traslado_id_foreign` FOREIGN KEY (`motivo_traslado_id`) REFERENCES `motivo_traslado` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `guia_remision_tecnico_id_foreign` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `guia_remision_transport_id_foreign` FOREIGN KEY (`transport_id`) REFERENCES `transports` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `guia_remision_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `guia_remision_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `informe_tarea`
--
ALTER TABLE `informe_tarea`
  ADD CONSTRAINT `informe_tarea_tarea_id_foreign` FOREIGN KEY (`tarea_id`) REFERENCES `tareas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `informe_tarea_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ip_whitelists`
--
ALTER TABLE `ip_whitelists`
  ADD CONSTRAINT `ip_whitelists_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `kpis`
--
ALTER TABLE `kpis`
  ADD CONSTRAINT `kpis_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `kpi_alertas`
--
ALTER TABLE `kpi_alertas`
  ADD CONSTRAINT `kpi_alertas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kpi_alertas_kpi_id_foreign` FOREIGN KEY (`kpi_id`) REFERENCES `kpis` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `kpi_resultados`
--
ALTER TABLE `kpi_resultados`
  ADD CONSTRAINT `kpi_resultados_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kpi_resultados_kpi_id_foreign` FOREIGN KEY (`kpi_id`) REFERENCES `kpis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kpi_resultados_registrado_por_foreign` FOREIGN KEY (`registrado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `lineas`
--
ALTER TABLE `lineas`
  ADD CONSTRAINT `lineas_operador_id_foreign` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lineas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD CONSTRAINT `mantenimientos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `mantenimientos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `mantenimientos_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `mensajes_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_to_user_id_foreign` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `message_histories`
--
ALTER TABLE `message_histories`
  ADD CONSTRAINT `message_histories_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  ADD CONSTRAINT `nota_credito_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_credito_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `nota_credito_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `nota_credito_invoice_id_new_foreign` FOREIGN KEY (`invoice_id_new`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `nota_credito_sustento_id_foreign` FOREIGN KEY (`sustento_id`) REFERENCES `sustentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_credito_tipo_comprobante_id_foreign` FOREIGN KEY (`tipo_comprobante_id`) REFERENCES `tipo_comprobantes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_credito_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `nota_credito_detalles`
--
ALTER TABLE `nota_credito_detalles`
  ADD CONSTRAINT `nota_credito_detalles_nota_credito_id_foreign` FOREIGN KEY (`nota_credito_id`) REFERENCES `nota_credito` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nota_credito_detalles_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `nota_debito`
--
ALTER TABLE `nota_debito`
  ADD CONSTRAINT `nota_debito_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_debito_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `nota_debito_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `nota_debito_invoice_id_new_foreign` FOREIGN KEY (`invoice_id_new`) REFERENCES `ventas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `nota_debito_sustento_id_foreign` FOREIGN KEY (`sustento_id`) REFERENCES `sustentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_debito_tipo_comprobante_id_foreign` FOREIGN KEY (`tipo_comprobante_id`) REFERENCES `tipo_comprobantes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nota_debito_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `nota_debito_detalles`
--
ALTER TABLE `nota_debito_detalles`
  ADD CONSTRAINT `nota_debito_detalles_nota_debito_id_foreign` FOREIGN KEY (`nota_debito_id`) REFERENCES `nota_debito` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nota_debito_detalles_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `old_sim_card_linea`
--
ALTER TABLE `old_sim_card_linea`
  ADD CONSTRAINT `old_sim_card_linea_linea_id_foreign` FOREIGN KEY (`linea_id`) REFERENCES `lineas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `old_sim_card_linea_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_cobros_id_foreign` FOREIGN KEY (`cobros_id`) REFERENCES `cobros` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `payment_method_types`
--
ALTER TABLE `payment_method_types`
  ADD CONSTRAINT `payment_method_types_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `periodos_cobros`
--
ALTER TABLE `periodos_cobros`
  ADD CONSTRAINT `periodos_cobros_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `periodos_cobros_cobros_id_foreign` FOREIGN KEY (`cobros_id`) REFERENCES `cobros` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `periodos_cobros_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `periodos_cobros_recibo_id_foreign` FOREIGN KEY (`recibo_id`) REFERENCES `recibos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `periodos_cobros_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `periodos_cobros_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `plans_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `plans_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `plantilla`
--
ALTER TABLE `plantilla`
  ADD CONSTRAINT `plantilla_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `postventa_plantillas`
--
ALTER TABLE `postventa_plantillas`
  ADD CONSTRAINT `postventa_plantillas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `postventa_plantillas_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `fk_tipo_c_presupuesto` FOREIGN KEY (`tipo_comprobante_id`) REFERENCES `tipo_comprobantes` (`codigo`),
  ADD CONSTRAINT `presupuestos_clientes_id_foreign` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `presupuestos_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presupuestos_metodo_pago_id_foreign` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodo_pago` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presupuestos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_modelo_id_foreign` FOREIGN KEY (`modelo_id`) REFERENCES `modelos_dispositivos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `productos_unit_code_foreign` FOREIGN KEY (`unit_code`) REFERENCES `units` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `productos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Filtros para la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD CONSTRAINT `recordatorios_reportes_id_foreign` FOREIGN KEY (`reportes_id`) REFERENCES `reportes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recordatorios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registro_cobros`
--
ALTER TABLE `registro_cobros`
  ADD CONSTRAINT `registro_cobros_cobros_id_foreign` FOREIGN KEY (`cobros_id`) REFERENCES `cobros` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_atendido_por_foreign` FOREIGN KEY (`atendido_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reportes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reportes_vehiculos_id_foreign` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rubros_cliente`
--
ALTER TABLE `rubros_cliente`
  ADD CONSTRAINT `rubros_cliente_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD CONSTRAINT `sectores_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sector_vehiculo`
--
ALTER TABLE `sector_vehiculo`
  ADD CONSTRAINT `sector_vehiculo_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sector_vehiculo_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `series_tipo_comprobante_id_foreign` FOREIGN KEY (`tipo_comprobante_id`) REFERENCES `tipo_comprobantes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sim_card`
--
ALTER TABLE `sim_card`
  ADD CONSTRAINT `sim_card_lineas_id_foreign` FOREIGN KEY (`lineas_id`) REFERENCES `lineas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_card_operador_id_foreign` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `sim_card_users`
--
ALTER TABLE `sim_card_users`
  ADD CONSTRAINT `sim_card_users_guia_remision_id_foreign` FOREIGN KEY (`guia_remision_id`) REFERENCES `guia_remision` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_card_users_sim_card_foreign` FOREIGN KEY (`sim_card`) REFERENCES `sim_card` (`sim_card`),
  ADD CONSTRAINT `sim_card_users_tecnico_id_foreign` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_card_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tareas_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tareas_mantenimiento_id_foreign` FOREIGN KEY (`mantenimiento_id`) REFERENCES `mantenimientos` (`id`),
  ADD CONSTRAINT `tareas_tecnico_id_foreign` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tareas_tipo_tarea_id_foreign` FOREIGN KEY (`tipo_tarea_id`) REFERENCES `tipo_tareas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tareas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tareas_vehiculos_id_foreign` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `team_user`
--
ALTER TABLE `team_user`
  ADD CONSTRAINT `team_user_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `ticket_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD CONSTRAINT `ticket_attachments_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `ticket_messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_attachments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_attachments_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD CONSTRAINT `ticket_categories_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticket_events`
--
ALTER TABLE `ticket_events`
  ADD CONSTRAINT `ticket_events_actor_id_foreign` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ticket_events_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD CONSTRAINT `ticket_messages_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_messages_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticket_relations`
--
ALTER TABLE `ticket_relations`
  ADD CONSTRAINT `ticket_relations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ticket_relations_related_ticket_id_foreign` FOREIGN KEY (`related_ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_relations_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticket_sequences`
--
ALTER TABLE `ticket_sequences`
  ADD CONSTRAINT `ticket_sequences_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticket_templates`
--
ALTER TABLE `ticket_templates`
  ADD CONSTRAINT `ticket_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ticket_templates_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`);

--
-- Filtros para la tabla `tipo_tareas`
--
ALTER TABLE `tipo_tareas`
  ADD CONSTRAINT `tipo_tareas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `transports`
--
ALTER TABLE `transports`
  ADD CONSTRAINT `transports_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ciudad_id_foreign` FOREIGN KEY (`ciudad_id`) REFERENCES `ciudades` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_series_id_foreign` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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

--
-- Filtros para la tabla `vehiculos_flotas`
--
ALTER TABLE `vehiculos_flotas`
  ADD CONSTRAINT `vehiculos_flotas_flotas_id_foreign` FOREIGN KEY (`flotas_id`) REFERENCES `flotas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehiculos_flotas_vehiculos_id_foreign` FOREIGN KEY (`vehiculos_id`) REFERENCES `vehiculos` (`id`) ON DELETE SET NULL;

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

--
-- Filtros para la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  ADD CONSTRAINT `ventas_detalles_ventas_id_foreign` FOREIGN KEY (`ventas_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `whatsapp_groups`
--
ALTER TABLE `whatsapp_groups`
  ADD CONSTRAINT `whatsapp_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `wigs`
--
ALTER TABLE `wigs`
  ADD CONSTRAINT `wigs_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `work_orders`
--
ALTER TABLE `work_orders`
  ADD CONSTRAINT `work_orders_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `work_orders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `work_orders_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_orders_mantenimiento_id_foreign` FOREIGN KEY (`mantenimiento_id`) REFERENCES `mantenimientos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `work_orders_presupuesto_id_foreign` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `work_orders_tecnico_id_foreign` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `work_orders_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`),
  ADD CONSTRAINT `work_orders_work_order_type_id_foreign` FOREIGN KEY (`work_order_type_id`) REFERENCES `work_order_types` (`id`);

--
-- Filtros para la tabla `work_order_accessories`
--
ALTER TABLE `work_order_accessories`
  ADD CONSTRAINT `work_order_accessories_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `work_order_accessories_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `work_order_checklists`
--
ALTER TABLE `work_order_checklists`
  ADD CONSTRAINT `work_order_checklists_checklist_template_id_foreign` FOREIGN KEY (`checklist_template_id`) REFERENCES `checklist_templates` (`id`),
  ADD CONSTRAINT `work_order_checklists_inspeccionado_by_foreign` FOREIGN KEY (`inspeccionado_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `work_order_checklists_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `work_order_items`
--
ALTER TABLE `work_order_items`
  ADD CONSTRAINT `work_order_items_vehiculo_id_foreign` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `work_order_items_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `work_order_photos`
--
ALTER TABLE `work_order_photos`
  ADD CONSTRAINT `work_order_photos_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `work_order_photos_work_order_checklist_id_foreign` FOREIGN KEY (`work_order_checklist_id`) REFERENCES `work_order_checklists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_order_photos_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `work_order_signatures`
--
ALTER TABLE `work_order_signatures`
  ADD CONSTRAINT `work_order_signatures_tecnico_id_foreign` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `work_order_signatures_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `work_order_types`
--
ALTER TABLE `work_order_types`
  ADD CONSTRAINT `work_order_types_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `work_order_type_costs`
--
ALTER TABLE `work_order_type_costs`
  ADD CONSTRAINT `work_order_type_costs_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_order_type_costs_tecnico_id_foreign` FOREIGN KEY (`tecnico_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_order_type_costs_work_order_type_id_foreign` FOREIGN KEY (`work_order_type_id`) REFERENCES `work_order_types` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
