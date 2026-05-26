-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-05-2026 a las 01:52:47
-- Versión del servidor: 8.4.3
-- Versión de PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sillage`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:108:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:15:\"ViewAny:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"View:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:14:\"Create:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:14:\"Update:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:14:\"Delete:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:17:\"DeleteAny:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:15:\"Restore:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:19:\"ForceDelete:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:22:\"ForceDeleteAny:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:18:\"RestoreAny:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:17:\"Replicate:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:15:\"Reorder:Cliente\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:14:\"ViewAny:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:11:\"View:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:13:\"Create:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:13:\"Update:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:13:\"Delete:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:16:\"DeleteAny:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:14:\"Restore:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:18:\"ForceDelete:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:21:\"ForceDeleteAny:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:17:\"RestoreAny:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:16:\"Replicate:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:14:\"Reorder:Compra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:21:\"ViewAny:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:18:\"View:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:20:\"Create:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:20:\"Update:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:20:\"Delete:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:23:\"DeleteAny:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:21:\"Restore:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:25:\"ForceDelete:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:28:\"ForceDeleteAny:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:24:\"RestoreAny:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:23:\"Replicate:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:21:\"Reorder:DetalleCompra\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:15:\"ViewAny:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:12:\"View:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:14:\"Create:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:14:\"Update:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"Delete:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"DeleteAny:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:15:\"Restore:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:19:\"ForceDelete:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:22:\"ForceDeleteAny:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:18:\"RestoreAny:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:17:\"Replicate:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:15:\"Reorder:Expense\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:15:\"ViewAny:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:12:\"View:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:14:\"Create:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:14:\"Update:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:14:\"Delete:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:17:\"DeleteAny:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:15:\"Restore:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:19:\"ForceDelete:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:22:\"ForceDeleteAny:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:18:\"RestoreAny:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:17:\"Replicate:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:15:\"Reorder:Product\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:17:\"ViewAny:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:14:\"View:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:16:\"Create:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:16:\"Update:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:16:\"Delete:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:19:\"DeleteAny:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:17:\"Restore:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:21:\"ForceDelete:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:24:\"ForceDeleteAny:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:20:\"RestoreAny:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:19:\"Replicate:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:17:\"Reorder:Proveedor\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:12:\"ViewAny:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:9:\"View:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:11:\"Create:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:11:\"Update:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:11:\"Delete:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:14:\"DeleteAny:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:12:\"Restore:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:16:\"ForceDelete:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:19:\"ForceDeleteAny:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:15:\"RestoreAny:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:14:\"Replicate:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:12:\"Reorder:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:12:\"ViewAny:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:9:\"View:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:11:\"Create:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:11:\"Update:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:11:\"Delete:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:14:\"DeleteAny:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:12:\"Restore:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:16:\"ForceDelete:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:19:\"ForceDeleteAny:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:15:\"RestoreAny:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:14:\"Replicate:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:12:\"Reorder:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:13:\"ViewAny:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:10:\"View:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:12:\"Create:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:12:\"Update:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:17:\"ForceDelete:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:13:\"Reorder:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:13:\"Restore:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:15:\"Replicate:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:15:\"DeleteAny:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:16:\"RestoreAny:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:20:\"ForceDeleteAny:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:12:\"Delete:Venta\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super_admin\";s:1:\"c\";s:3:\"web\";}}}', 1779815725);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `genero` enum('Hombre','Mujer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hombre',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `cedula`, `telefono`, `correo`, `direccion`, `genero`, `created_at`, `updated_at`) VALUES
(3, 'Wilmer', 'Helados Cali', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-23 19:38:19', '2026-05-24 04:43:54'),
(4, 'orlhey', 'gonzalez', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-23 20:50:21', '2026-05-23 20:50:21'),
(5, 'Efren ', 'Requena', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-23 22:46:41', '2026-05-23 22:46:41'),
(6, 'Lady ', 'cali', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-23 22:50:21', '2026-05-23 22:50:21'),
(7, 'Emilio', 'Emilio', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-23 23:08:38', '2026-05-23 23:08:38'),
(8, 'Francisco', 'Damaris', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-23 23:09:29', '2026-05-23 23:09:29'),
(9, 'francisco', 'otro', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-23 23:13:36', '2026-05-23 23:13:36'),
(10, 'oliver', 'mongua', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-23 23:16:02', '2026-05-23 23:16:02'),
(11, 'deivys', 'gamarra', '28731970', NULL, NULL, NULL, 'Hombre', '2026-05-23 23:17:20', '2026-05-23 23:17:20'),
(12, 'sorteo', 'perfume', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-23 23:19:32', '2026-05-23 23:19:32'),
(13, 'Ruth', 'Helados Cali', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 01:38:07', '2026-05-24 01:38:07'),
(14, 'Alexandra ', 'García', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 02:35:49', '2026-05-24 02:35:49'),
(15, 'Wilfredo', 'Berroterán', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 02:36:35', '2026-05-24 02:36:35'),
(16, 'Dioskary', 'Monroy', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 02:37:49', '2026-05-24 02:37:49'),
(17, 'Joel', 'Poyo', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 02:38:21', '2026-05-24 02:38:21'),
(18, 'Rafael', 'Berroteran', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 03:05:17', '2026-05-24 03:05:17'),
(19, 'Dayerling', 'Hidalgo', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 03:17:26', '2026-05-24 03:17:26'),
(20, 'Virginia', 'Parra', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 03:18:34', '2026-05-24 03:18:34'),
(21, 'Carolina', 'Helados Cali', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 03:20:37', '2026-05-24 03:20:37'),
(22, 'Maria', 'Torrealba Cali', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 03:21:30', '2026-05-24 03:21:30'),
(23, 'Anderson', 'Helados Cali', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 03:23:48', '2026-05-24 03:23:48'),
(24, 'Jesús', 'Helados Cali', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 03:24:49', '2026-05-24 03:24:49'),
(25, 'Ydalmy', 'Rivera', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 03:27:01', '2026-05-24 03:27:01'),
(26, 'Ydalmy', 'Perdomo', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 03:31:28', '2026-05-24 03:31:28'),
(27, 'Johana', 'Madrid', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 03:31:58', '2026-05-24 03:31:58'),
(28, 'Keyla', 'Helados Cali', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 03:37:24', '2026-05-24 03:37:24'),
(29, 'Valeria', 'Helados Cali', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 03:37:58', '2026-05-24 03:37:58'),
(30, 'Yeferson', 'Bodega', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 03:49:30', '2026-05-24 03:49:30'),
(31, 'Flaco', 'Bodega', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 03:50:23', '2026-05-24 03:50:23'),
(32, 'Emilio', 'Helados Cali', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 03:51:17', '2026-05-24 03:51:17'),
(33, 'Luis', 'Reyes', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 03:52:53', '2026-05-24 03:52:53'),
(34, 'Hederin', 'Tabate', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 03:56:47', '2026-05-24 03:56:47'),
(35, 'Orlhey', 'González', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-24 04:21:08', '2026-05-24 04:21:08'),
(36, 'Emily', 'Lezama', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-24 04:23:43', '2026-05-24 04:23:43'),
(37, 'Carlos', 'Mayol', '27088111', NULL, NULL, NULL, 'Hombre', '2026-05-24 21:44:05', '2026-05-24 21:44:05'),
(38, 'Marcos', 'Romero', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-25 19:47:42', '2026-05-25 19:47:42'),
(39, 'Renato', 'Leroux', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-25 21:19:24', '2026-05-25 21:19:24'),
(40, 'Franyelimar', 'Mireles', NULL, NULL, NULL, NULL, 'Mujer', '2026-05-25 21:24:58', '2026-05-25 21:24:58'),
(41, 'Francisco', 'Bloques', NULL, NULL, NULL, NULL, 'Hombre', '2026-05-26 04:54:41', '2026-05-26 04:54:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` bigint UNSIGNED NOT NULL,
  `proveedor_id` bigint UNSIGNED NOT NULL,
  `fecha_compra` date NOT NULL,
  `total_compra` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `proveedor_id`, `fecha_compra`, `total_compra`, `created_at`, `updated_at`) VALUES
(3, 2, '2026-05-19', 1038.15, '2026-05-20 04:45:19', '2026-05-23 21:56:36'),
(4, 3, '2026-05-20', 105.00, '2026-05-20 19:49:42', '2026-05-20 19:49:42'),
(6, 2, '2026-04-26', 966.57, '2026-05-24 03:04:20', '2026-05-24 03:47:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` bigint UNSIGNED NOT NULL,
  `compra_id` bigint UNSIGNED NOT NULL,
  `nombre_perfume` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca_perfume` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mililitros` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int NOT NULL,
  `costo_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `compra_id`, `nombre_perfume`, `marca_perfume`, `mililitros`, `cantidad`, `costo_unitario`, `subtotal`, `created_at`, `updated_at`) VALUES
(3, 3, 'Blue Men', 'Nautica', '100', 1, 13.60, 13.60, '2026-05-20 04:45:19', '2026-05-23 21:56:36'),
(4, 3, 'Pure Blue Men', 'Nautica', '100', 1, 15.30, 15.30, '2026-05-20 04:48:33', '2026-05-21 20:55:39'),
(5, 3, 'Voyage N83 Men', 'Nautica', '100', 1, 17.00, 17.00, '2026-05-20 04:48:33', '2026-05-21 20:55:39'),
(6, 3, 'Asad Men', 'Lattafa', '100', 2, 25.50, 51.00, '2026-05-20 04:48:33', '2026-05-21 20:55:39'),
(7, 3, 'Club De Nuit Intense', 'Armaf', '100', 1, 28.90, 28.90, '2026-05-20 04:48:33', '2026-05-21 20:55:39'),
(8, 3, 'Amber Oud Gold Edition', 'Al Haramain', '100', 1, 57.80, 57.80, '2026-05-20 04:48:33', '2026-05-21 20:55:39'),
(9, 3, 'Odyssey Marshmallow Gourmand Edition Men', 'Armaf', '100', 1, 34.85, 34.85, '2026-05-20 04:48:33', '2026-05-20 04:48:33'),
(10, 3, '9Pm Elixir', 'Afnan', '100', 2, 43.35, 86.70, '2026-05-20 05:12:24', '2026-05-21 20:55:39'),
(11, 3, 'Yara Moi Women', 'Lattafa', '100', 1, 22.95, 22.95, '2026-05-20 05:12:24', '2026-05-20 05:12:24'),
(12, 3, 'Yara Candy', 'Lattafa', '100', 1, 23.80, 23.80, '2026-05-20 05:12:24', '2026-05-21 20:55:39'),
(13, 3, 'Pride Art Of Universe Unisex', 'Lattafa', '100', 1, 45.05, 45.05, '2026-05-20 05:12:24', '2026-05-20 05:12:24'),
(14, 3, 'Historic Sahara Unisex', 'Afnan', '100', 1, 39.95, 39.95, '2026-05-20 05:12:25', '2026-05-20 05:12:25'),
(15, 3, ' Odyssey Mandarin Sky', 'Armaf', '100', 2, 34.00, 68.00, '2026-05-20 05:12:25', '2026-05-21 20:55:39'),
(16, 3, 'Nitro Red Intensely', 'Dumont', '100', 1, 45.05, 45.05, '2026-05-20 05:12:25', '2026-05-20 05:12:25'),
(17, 3, 'Badee Al Oud Sublime ', 'Lattafa', '100', 1, 22.10, 22.10, '2026-05-20 05:12:25', '2026-05-21 20:55:39'),
(18, 3, 'Club De Nuit Preciux', 'Armaf', '100', 1, 51.00, 51.00, '2026-05-20 05:12:25', '2026-05-21 20:55:39'),
(19, 3, 'Asad Elixir Men', 'Lattafa', '100', 1, 34.00, 34.00, '2026-05-20 05:12:25', '2026-05-21 20:55:39'),
(20, 3, 'Odyssey Bahamas', 'Armaf', '100', 1, 41.95, 41.95, '2026-05-20 05:12:25', '2026-05-20 05:12:25'),
(21, 3, 'Odyssey Black Men', 'Armaf', '100', 1, 29.75, 29.75, '2026-05-20 05:12:25', '2026-05-20 05:12:25'),
(22, 3, 'Atheeri Women', 'Lattafa', '100', 1, 34.85, 34.85, '2026-05-20 05:12:25', '2026-05-20 05:12:25'),
(23, 3, 'Badee Al Oud \"Oud For Glory\"', 'Lattafa', '100', 1, 27.20, 27.20, '2026-05-20 05:12:25', '2026-05-21 20:55:39'),
(24, 3, 'Bullet Gun Metal Pour Homme', 'Bharara', '75', 1, 21.25, 21.25, '2026-05-20 05:12:25', '2026-05-20 05:12:25'),
(25, 3, 'Beauty Bullet Gold Men', 'Bharara', '75', 1, 21.25, 21.25, '2026-05-20 05:12:25', '2026-05-20 05:12:25'),
(26, 3, 'Red 360 Men', 'Perry Elis', '100', 1, 31.45, 31.45, '2026-05-20 05:12:25', '2026-05-21 20:55:39'),
(27, 3, '360 Red Women', 'Perry Ellis', '100', 1, 32.30, 32.30, '2026-05-20 05:12:25', '2026-05-21 20:55:39'),
(28, 3, 'Her Confession', 'Lattafa', '100', 1, 41.65, 41.65, '2026-05-20 05:12:25', '2026-05-20 05:12:25'),
(29, 3, 'Girl Women', 'Guess', '100', 1, 19.55, 19.55, '2026-05-20 05:12:25', '2026-05-20 05:12:25'),
(30, 3, '212 Men', 'Carolina Herrera', '100', 1, 79.90, 79.90, '2026-05-20 05:12:25', '2026-05-21 20:55:39'),
(31, 4, 'Game of Spades Royale', 'Jo Milano Paris', '100', 1, 105.00, 105.00, '2026-05-20 19:49:42', '2026-05-20 19:49:42'),
(34, 6, 'Eros Flame', 'Versace', '100', 1, 80.04, 80.04, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(35, 6, '9PM Rebel', 'Afnan', '100', 1, 38.28, 38.28, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(36, 6, '9PM Elixir', 'Afnan', '100', 1, 44.37, 44.37, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(37, 6, 'King Men', 'Bharara', '100', 1, 57.42, 57.42, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(38, 6, 'Hayaati', 'Lattafa', '100', 2, 19.14, 38.28, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(39, 6, 'Asad Bourbon', 'Lattafa', '100', 2, 33.93, 67.86, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(40, 6, 'Asad Men', 'Lattafa', '100', 3, 26.10, 78.30, '2026-05-24 03:04:20', '2026-05-24 03:54:06'),
(41, 6, 'Gold Women', 'Guess', '100', 3, 25.23, 75.69, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(42, 6, 'Women', 'Guess', '100', 3, 22.62, 67.86, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(43, 6, 'Yara Candy', 'Lattafa', '100', 1, 24.36, 24.36, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(44, 6, 'Yara Elixir', 'Lattafa', '100', 1, 34.80, 34.80, '2026-05-24 03:04:20', '2026-05-24 03:54:06'),
(45, 6, 'Khamrah Qahwha', 'Lattafa', '100', 2, 28.71, 57.42, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(46, 6, 'Khamrah', 'Lattafa', '100', 1, 33.93, 33.93, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(47, 6, 'His Confesion', 'Lattafa', '100', 2, 42.63, 85.26, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(48, 6, 'Nitro Red', 'Dumont', '100', 1, 35.67, 35.67, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(49, 6, 'Club de Nuit Elixir', 'Armaf', '100', 1, 38.28, 38.28, '2026-05-24 03:04:20', '2026-05-24 03:04:20'),
(50, 6, 'Odysey Mandarin Sky 200ML', 'Armaf', '200', 1, 49.59, 49.59, '2026-05-24 03:04:20', '2026-05-24 03:54:06'),
(51, 6, 'Amber Oud Gold Edition', 'Al Haramain', '100', 1, 59.16, 59.16, '2026-05-24 03:04:20', '2026-05-24 03:04:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `metodo_pago` text COLLATE utf8mb4_unicode_ci,
  `cantidad` int NOT NULL,
  `pago_cuota` enum('Si','No') COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_cuota` enum('2 Cuotas','3 Cuotas') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primera_cuota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `segunda_cuota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tercera_cuota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `venta_id`, `product_id`, `metodo_pago`, `cantidad`, `pago_cuota`, `numero_cuota`, `primera_cuota`, `segunda_cuota`, `tercera_cuota`, `precio_unitario`, `subtotal`, `created_at`, `updated_at`) VALUES
(3, 4, 5, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 180.00, 180.00, '2026-05-23 23:40:04', '2026-05-23 23:40:04'),
(7, 8, 3, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 28.00, 28.00, '2026-05-24 02:49:01', '2026-05-24 02:49:01'),
(8, 9, 30, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 70.00, 70.00, '2026-05-24 02:51:43', '2026-05-24 02:51:43'),
(10, 9, 23, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 76.00, 76.00, '2026-05-24 03:02:08', '2026-05-24 03:02:08'),
(11, 10, 28, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 60.00, 60.00, '2026-05-24 03:09:00', '2026-05-24 03:09:00'),
(12, 11, 13, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 45.00, 45.00, '2026-05-24 03:10:22', '2026-05-24 03:10:22'),
(13, 12, 21, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 80.00, 80.00, '2026-05-24 03:14:30', '2026-05-24 05:36:54'),
(14, 13, 12, '[\"Pago Movil\"]', 1, 'Si', '2 Cuotas', '$32.5 (Fecha: 23-05-2026)', '$32.5 (Fecha: 07-06-2026)', NULL, 65.00, 65.00, '2026-05-24 03:16:24', '2026-05-26 05:50:33'),
(15, 14, 10, '[\"Pago Movil\"]', 1, 'Si', '2 Cuotas', '$25 (Fecha: 23-05-2026)', '$25 (Fecha: 07-06-2026)', NULL, 50.00, 50.00, '2026-05-24 03:18:02', '2026-05-26 05:42:52'),
(16, 15, 11, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 65.00, 65.00, '2026-05-24 05:39:07', '2026-05-24 05:39:07'),
(17, 15, 14, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 50.00, 50.00, '2026-05-24 05:39:07', '2026-05-24 05:39:07'),
(18, 16, 9, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 105.00, 105.00, '2026-05-24 06:36:23', '2026-05-24 06:36:23'),
(19, 17, 8, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 160.00, 160.00, '2026-05-24 06:37:35', '2026-05-24 06:37:35'),
(20, 18, 17, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 28.00, 28.00, '2026-05-24 06:38:11', '2026-05-24 06:38:11'),
(21, 19, 16, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 30.00, 30.00, '2026-05-24 06:42:14', '2026-05-24 06:42:14'),
(22, 19, 32, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 40.00, 40.00, '2026-05-24 06:42:14', '2026-05-24 06:42:14'),
(23, 20, 33, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 120.00, 120.00, '2026-05-24 07:14:00', '2026-05-24 07:14:00'),
(24, 20, 34, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 115.00, 115.00, '2026-05-24 07:14:00', '2026-05-24 07:14:00'),
(25, 21, 35, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 58.00, 58.00, '2026-05-24 07:18:21', '2026-05-24 07:18:21'),
(26, 21, 36, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 54.00, 54.00, '2026-05-24 07:18:21', '2026-05-24 07:18:21'),
(27, 22, 38, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 65.00, 65.00, '2026-05-24 07:19:03', '2026-05-24 07:19:03'),
(28, 23, 14, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 50.00, 50.00, '2026-05-24 07:21:08', '2026-05-24 07:21:08'),
(29, 24, 35, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 58.00, 58.00, '2026-05-24 07:22:02', '2026-05-24 07:22:22'),
(30, 25, 10, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 50.00, 50.00, '2026-05-24 07:24:03', '2026-05-24 07:24:18'),
(31, 26, 10, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 50.00, 50.00, '2026-05-24 07:26:19', '2026-05-24 07:26:19'),
(32, 27, 36, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 54.00, 54.00, '2026-05-24 07:27:21', '2026-05-24 07:27:21'),
(33, 28, 35, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 58.00, 58.00, '2026-05-24 07:31:42', '2026-05-24 07:31:42'),
(34, 29, 36, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 54.00, 54.00, '2026-05-24 07:32:14', '2026-05-24 07:32:14'),
(35, 30, 41, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 75.00, 75.00, '2026-05-24 07:34:26', '2026-05-24 07:34:26'),
(37, 32, 12, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 65.00, 65.00, '2026-05-24 07:38:18', '2026-05-24 07:38:18'),
(38, 33, 42, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 76.00, 76.00, '2026-05-24 07:41:28', '2026-05-24 07:41:28'),
(39, 34, 43, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 35.00, 35.00, '2026-05-24 07:49:43', '2026-05-24 07:49:43'),
(40, 35, 44, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 65.00, 65.00, '2026-05-24 07:50:35', '2026-05-24 07:50:35'),
(41, 36, 9, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 105.00, 105.00, '2026-05-24 07:51:02', '2026-05-24 07:51:02'),
(42, 37, 45, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 70.00, 70.00, '2026-05-24 07:52:09', '2026-05-24 07:52:09'),
(43, 38, 46, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 90.00, 90.00, '2026-05-24 07:53:06', '2026-05-24 07:53:06'),
(44, 39, 37, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 50.00, 50.00, '2026-05-24 07:56:26', '2026-05-24 07:56:26'),
(45, 40, 47, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 60.00, 60.00, '2026-05-24 07:57:49', '2026-05-24 07:57:49'),
(47, 41, 43, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 35.00, 35.00, '2026-05-24 08:23:25', '2026-05-24 08:23:25'),
(48, 42, 19, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 45.00, 45.00, '2026-05-24 08:24:00', '2026-05-24 08:24:00'),
(49, 43, 12, NULL, 1, 'Si', NULL, NULL, NULL, NULL, 65.00, 65.00, '2026-05-24 08:24:46', '2026-05-24 08:24:46'),
(55, 49, 44, '[\"Pago Movil\"]', 1, 'Si', '3 Cuotas', '$21.67 (Fecha: 25-05-2026)', '$21.67 (Fecha: 09-06-2026)', '$21.67 (Fecha: 24-06-2026)', 65.00, 65.00, '2026-05-25 19:48:25', '2026-05-25 19:48:25'),
(56, 50, 22, '[\"USDT\"]', 1, 'No', NULL, NULL, NULL, NULL, 55.00, 55.00, '2026-05-25 21:20:10', '2026-05-25 21:20:10'),
(57, 51, 29, '[\"Pago Movil\"]', 1, 'No', NULL, NULL, NULL, NULL, 65.00, 65.00, '2026-05-25 21:27:55', '2026-05-25 21:27:55'),
(58, 52, 10, '[\"Pago Movil\"]', 1, 'No', NULL, NULL, NULL, NULL, 50.00, 50.00, '2026-05-26 04:56:28', '2026-05-26 04:56:28'),
(59, 53, 48, '[\"Pago Movil\"]', 1, 'Si', '2 Cuotas', '$57.5 (Fecha: 26-05-2026)', '$57.5 (Fecha: 10-06-2026)', NULL, 115.00, 115.00, '2026-05-26 05:00:19', '2026-05-26 05:09:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Mercancía',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_08_000002_create_proveedors_table', 1),
(5, '2026_05_09_022108_create_products_table', 1),
(6, '2026_05_09_030610_create_expenses_table', 1),
(7, '2026_05_10_004129_add_flags_to_products_table', 1),
(8, '2026_05_11_193233_create_clientes_table', 1),
(9, '2026_05_12_173850_create_permission_tables', 1),
(10, '2026_05_17_235527_create_compras_table', 1),
(11, '2026_05_17_235550_create_detalle_compras_table', 1),
(12, '2026_05_18_031112_create_ventas_table', 2),
(13, '2026_05_18_031120_create_detalle_ventas_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'ViewAny:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(2, 'View:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(3, 'Create:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(4, 'Update:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(5, 'Delete:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(6, 'DeleteAny:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(7, 'Restore:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(8, 'ForceDelete:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(9, 'ForceDeleteAny:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(10, 'RestoreAny:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(11, 'Replicate:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(12, 'Reorder:Cliente', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(13, 'ViewAny:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(14, 'View:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(15, 'Create:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(16, 'Update:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(17, 'Delete:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(18, 'DeleteAny:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(19, 'Restore:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(20, 'ForceDelete:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(21, 'ForceDeleteAny:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(22, 'RestoreAny:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(23, 'Replicate:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(24, 'Reorder:Compra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(25, 'ViewAny:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(26, 'View:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(27, 'Create:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(28, 'Update:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(29, 'Delete:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(30, 'DeleteAny:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(31, 'Restore:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(32, 'ForceDelete:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(33, 'ForceDeleteAny:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(34, 'RestoreAny:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(35, 'Replicate:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(36, 'Reorder:DetalleCompra', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(37, 'ViewAny:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(38, 'View:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(39, 'Create:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(40, 'Update:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(41, 'Delete:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(42, 'DeleteAny:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(43, 'Restore:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(44, 'ForceDelete:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(45, 'ForceDeleteAny:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(46, 'RestoreAny:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(47, 'Replicate:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(48, 'Reorder:Expense', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(49, 'ViewAny:Product', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(50, 'View:Product', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(51, 'Create:Product', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(52, 'Update:Product', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(53, 'Delete:Product', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(54, 'DeleteAny:Product', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31'),
(55, 'Restore:Product', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(56, 'ForceDelete:Product', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(57, 'ForceDeleteAny:Product', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(58, 'RestoreAny:Product', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(59, 'Replicate:Product', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(60, 'Reorder:Product', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(61, 'ViewAny:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(62, 'View:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(63, 'Create:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(64, 'Update:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(65, 'Delete:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(66, 'DeleteAny:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(67, 'Restore:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(68, 'ForceDelete:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(69, 'ForceDeleteAny:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(70, 'RestoreAny:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(71, 'Replicate:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(72, 'Reorder:Proveedor', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(73, 'ViewAny:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(74, 'View:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(75, 'Create:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(76, 'Update:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(77, 'Delete:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(78, 'DeleteAny:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(79, 'Restore:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(80, 'ForceDelete:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(81, 'ForceDeleteAny:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(82, 'RestoreAny:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(83, 'Replicate:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(84, 'Reorder:User', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(85, 'ViewAny:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(86, 'View:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(87, 'Create:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(88, 'Update:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(89, 'Delete:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(90, 'DeleteAny:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(91, 'Restore:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(92, 'ForceDelete:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(93, 'ForceDeleteAny:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(94, 'RestoreAny:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(95, 'Replicate:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(96, 'Reorder:Role', 'web', '2026-05-18 05:43:32', '2026-05-18 05:43:32'),
(97, 'ViewAny:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(98, 'View:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(99, 'Create:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(100, 'Update:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(101, 'ForceDelete:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(102, 'Reorder:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(103, 'Restore:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(104, 'Replicate:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(105, 'DeleteAny:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(106, 'RestoreAny:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(107, 'ForceDeleteAny:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36'),
(108, 'Delete:Venta', 'web', '2026-05-18 07:18:36', '2026-05-18 07:18:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca_perfume` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `wholesale_price` decimal(10,2) DEFAULT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `metodo_pago` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `precio_divisa` decimal(10,2) DEFAULT NULL,
  `is_exclusive` tinyint(1) NOT NULL DEFAULT '0',
  `is_offer` tinyint(1) NOT NULL DEFAULT '0',
  `offer_price` decimal(10,2) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `marca_perfume`, `stock`, `wholesale_price`, `retail_price`, `metodo_pago`, `precio_divisa`, `is_exclusive`, `is_offer`, `offer_price`, `description`, `image`, `created_at`, `updated_at`) VALUES
(3, 'Blue Men', 'Nautica', 0, 13.60, 28.00, 'USDT', NULL, 0, 0, NULL, 'Nautica Blue de Nautica es una fragancia de la familia olfativa Aromática Acuática para Hombres. Nautica Blue se lanzó en 2005. La Nariz detrás de esta fragrancia es Maurice Roucel. Las Notas de Salida son piña, bergamota y durazno (melocotón); las Notas de Corazón son nenúfar (lirio de agua) y jazmín; las Notas de Fondo son sándalo, almizcle y cedro.', 'products/01KS1FQV5KBKW7EJ8DJ8883MZ1.jpg', '2026-05-20 05:20:14', '2026-05-23 22:49:01'),
(5, 'Game of Spades Royale', 'Jo Milano Paris', 0, 105.00, 180.00, 'USDT', NULL, 1, 0, NULL, NULL, 'products/01KS32RJYT08HXF5TJE9CDARW2.jpg', '2026-05-20 20:16:08', '2026-05-23 19:40:04'),
(6, 'Nitro Red Intensely', 'Dumont', 1, 45.05, 90.00, '[\"USDT\",\"Wally\",\"Zelle\",\"Pago Movil\",\"Zinli\",\"Cash\"]', NULL, 0, 0, NULL, 'Nitro Red Intensely de Dumont es una fragancia de la familia olfativa para Hombres. Esta fragrancia es nueva. Nitro Red Intensely se lanzó en 2025. La Nariz detrás de esta fragrancia es Quentin Roussel. Las Notas de Salida son melón, durazno (melocotón), manzana y bergamota; las Notas de Corazón son ámbar, sal de mar, cedro y lirio de los valles (muguete); las Notas de Fondo son ámbar, sándalo, pachulí y musgo.', NULL, '2026-05-20 20:22:22', '2026-05-26 05:07:36'),
(7, 'Club De Nuit Intense', 'Armaf', 1, 28.90, 55.00, 'USDT', NULL, 0, 0, NULL, 'Club de Nuit Intense Man de Armaf es una fragancia de la familia olfativa Amaderada Especiada para Hombres. Club de Nuit Intense Man se lanzó en 2015. Las Notas de Salida son limón (lima ácida), piña, bergamota, grosellas negras y manzana; las Notas de Corazón son abedul, jazmín y rosa; las Notas de Fondo son almizcle, ámbar gris, pachulí y vainilla.', 'products/01KS33HWXKY1Y2SHQQDS2FW07C.jpg', '2026-05-20 20:29:58', '2026-05-20 20:29:58'),
(8, '212 Men', 'Carolina Herrera', 0, 79.90, 160.00, 'USDT', NULL, 1, 0, NULL, '212 Men de Carolina Herrera es una fragancia de la familia olfativa Almizcle Amaderado Floral para Hombres. 212 Men se lanzó en 1999. 212 Men fue creada por Alberto Morillas, Rosendo Mateu y Ann Gottlieb. Las Notas de Salida son notas verdes, toronja (pomelo), especias, bergamota, lavanda y petit grain; las Notas de Corazón son jengibre, violeta, gardenia y salvia; las Notas de Fondo son almizcle, sándalo, incienso, vetiver, madera de gaiac y ládano.', 'products/01KS33T4B4XJ9EE8V1QYZYR5SH.jpg', '2026-05-20 20:34:27', '2026-05-24 02:37:35'),
(9, 'Amber Oud Gold Edition', 'Al Haramain', 0, 59.16, 105.00, 'USDT', NULL, 0, 0, NULL, 'Amber Oud Gold Edition de Al Haramain Perfumes es una fragancia de la familia olfativa Oriental Vainilla para Hombres y Mujeres. Amber Oud Gold Edition se lanzó en 2024. Las Notas de Salida son bergamota y notas verdes; las Notas de Corazón son melón, piña, ámbar y Acorde goloso; las Notas de Fondo son vainilla, almizcle y notas amaderadas.', NULL, '2026-05-20 21:17:24', '2026-05-24 05:06:12'),
(10, 'Asad Men', 'Lattafa', 0, 26.10, 50.00, 'USDT', NULL, 0, 0, NULL, 'Asad de Lattafa Perfumes es una fragancia de la familia olfativa Oriental para Hombres. Asad se lanzó en 2021. Las Notas de Salida son pimienta negra, tabaco y piña; las Notas de Corazón son pachulí, café y iris; las Notas de Fondo son vainilla, ámbar, Madera seca, benjuí y ládano.', NULL, '2026-05-20 21:30:45', '2026-05-26 04:56:28'),
(11, 'Odyssey Marshmallow Gourmand Edition Men', 'Armaf', 0, 34.85, 65.00, 'USDT', NULL, 0, 0, NULL, 'Odyssey Marshmallow de Armaf es una fragancia de la familia olfativa Floral Frutal Gourmand para Hombres y Mujeres. Esta fragrancia es nueva. Odyssey Marshmallow se lanzó en 2025. Las Notas de Salida son coco, manzana, limón (lima ácida), peonía y lirio de los valles (muguete); las Notas de Corazón son malvavisco (bombón), fresa, chabacano, durazno (melocotón), frambuesa y flor de azahar del naranjo; las Notas de Fondo son Queso mascarpone, vainilla, praliné, almizcle, haba tonka y ámbar.', 'products/01KS38V4MYMRB0M8KRDT741RA9.jpg', '2026-05-20 22:02:23', '2026-05-24 01:39:07'),
(12, '9Pm Elixir', 'Afnan', 0, 44.37, 65.00, 'USDT', NULL, 0, 0, NULL, '9PM Elixir de Afnan es una fragancia oriental especiada para hombres y mujeres. Se trata de una fragancia nueva, lanzada en 2025. Su creador es Imran Fazlani. Las notas de salida son cardamomo, nuez moscada y elemí; las notas de corazón son pimienta de Jamaica, cuero y lavanda; y las notas de fondo son vainilla, pachulí, ládano y jara.', NULL, '2026-05-20 22:06:38', '2026-05-24 05:03:35'),
(13, 'Yara Moi Women', 'Lattafa', 0, 22.95, 45.00, 'USDT', NULL, 0, 0, NULL, 'Yara Moi de Lattafa Perfumes es una fragancia para mujer. Yara Moi se lanzó en 2022. Sus notas de salida son jazmín y melocotón; las notas de corazón son caramelo y ámbar; y las notas de fondo son pachulí y sándalo.', 'products/01KS398ZMBCJE148HJPB6N6870.jpg', '2026-05-20 22:09:57', '2026-05-23 23:10:22'),
(14, 'Yara Candy', 'Lattafa', 0, 23.80, 50.00, 'USDT', NULL, 0, 0, NULL, 'Yara Candy de Lattafa Perfumes es una fragancia floral frutal gourmand para mujer. Se trata de una fragancia nueva, lanzada en 2024. Sus notas de salida son grosella negra y mandarina verde; las notas de corazón son caramelo de fresa y gardenia; y las notas de fondo son vainilla, almizcle, ámbar y sándalo.', 'products/01KS39EZKSSD4KGPWH3C6MJ2TQ.jpg', '2026-05-20 22:13:13', '2026-05-24 03:21:08'),
(15, 'Pride Art Of Universe Unisex', 'Lattafa', 1, 45.05, 95.00, 'USDT', NULL, 0, 0, NULL, 'Art Of Universe de Lattafa Perfumes es una fragancia cítrica aromática para mujeres y hombres. Se trata de una fragancia nueva, lanzada en 2025. Sus notas de salida son mandarina, jengibre, bergamota y menta; las notas de corazón son pera y flor de naranjo; y las notas de fondo son almizcle, ámbar y cedro.', 'products/01KS39PX33ZX30RTHYGPV6PMB6.jpg', '2026-05-20 22:17:33', '2026-05-20 22:17:33'),
(16, 'Pure Blue Men', 'Nautica', 0, 15.30, 30.00, 'USDT', NULL, 0, 0, NULL, 'Pure Blue de Nautica es una fragancia de la familia olfativa Aromática Fougère para Hombres y Mujeres. Esta fragrancia es nueva. Pure Blue se lanzó en 2024. Las Notas de Salida son naranja, lima (limón verde) y eucalipto; las Notas de Corazón son Notas marinas, ámbar y abedul; las Notas de Fondo son vainilla de Madagascar, cedro y almizcle.', 'products/01KS5KRMD94327GR2VSSES27SA.jpg', '2026-05-21 19:51:44', '2026-05-24 02:42:14'),
(17, 'Voyage N83 Men', 'Nautica', 0, 17.00, 28.00, 'USDT', NULL, 0, 0, NULL, 'Nautica Voyage N-83 de Nautica es una fragancia de la familia olfativa Aromática Acuática para Hombres. Nautica Voyage N-83 se lanzó en 2013. Las Notas de Salida son notas marinas, menta piperita y petit grain; las Notas de Corazón son lavanda, cardamomo y nuez moscada; las Notas de Fondo son almizcle, cedro y sándalo.', 'products/01KS5KWS85V2NTKTM0F4C6D3E0.jpg', '2026-05-21 19:54:00', '2026-05-24 02:38:11'),
(18, 'Historic Sahara Unisex', 'Afnan', 1, 39.95, 87.00, 'USDT', NULL, 0, 0, NULL, 'Historic Sahara de Afnan es una fragancia de la familia olfativa Oriental Vainilla para Hombres y Mujeres. Esta fragrancia es nueva. Historic Sahara se lanzó en 2025. La Nariz detrás de esta fragrancia es Imran Fazlani. Las Notas de Salida son cardamomo, canela y bergamota; las Notas de Corazón son vainilla, azúcar y elemí; las Notas de Fondo son praliné, almendra, haba tonka, almizcle y ambroxan.', 'products/01KS5KZE0WWQQW3QQ7TACRZNWB.jpg', '2026-05-21 19:55:27', '2026-05-21 19:55:27'),
(19, 'Badee Al Oud Sublime ', 'Lattafa', 0, 22.10, 45.00, 'USDT', NULL, 0, 0, NULL, 'Bade\'e Al Oud Sublime de Lattafa Perfumes es una fragancia de la familia olfativa Amaderada Aromática para Hombres y Mujeres. Bade\'e Al Oud Sublime se lanzó en 2023. Las Notas de Salida son manzana, lichi y rosa; las Notas de Corazón son ciruela y jazmín; las Notas de Fondo son musgo, vainilla y pachulí.', 'products/01KS5M6A11KPQC8BENGGHRQGEK.jpg', '2026-05-21 19:59:12', '2026-05-24 04:24:00'),
(20, 'Club De Nuit Preciux', 'Armaf', 1, 51.00, 115.00, 'USDT', NULL, 0, 0, NULL, 'Club de Nuit Precieux I de Armaf es una fragancia de la familia olfativa Oriental Amaderada para Hombres y Mujeres. Club de Nuit Precieux I se lanzó en 2024. Las Notas de Salida son piña, limón (lima ácida), bergamota, caramelo, pimienta rosa, pera y pimienta negra; las Notas de Corazón son musgo de roble, madera blanca, jazmín, lirio de los valles (muguete) y anís; las Notas de Fondo son ambroxan, almizcle blanco, cedro, pachulí, ámbar, cuero y vainilla.', 'products/01KS5MQZ4MBMW7JVZZPMZ88TDP.jpg', '2026-05-21 20:08:51', '2026-05-21 20:08:51'),
(21, 'Odyssey Bahamas', 'Armaf', 0, 41.95, 80.00, 'USDT', NULL, 0, 0, NULL, 'Odyssey BA HA MAS de Armaf es una fragancia de la familia olfativa Aromática Acuática para Hombres y Mujeres. Esta fragrancia es nueva. Odyssey BA HA MAS se lanzó en 2025. Las Notas de Salida son Melón cantalupo, melón, Algas, sal, pera, manzana Granny Smith y ciruela; las Notas de Corazón son Notas acuáticas, nenúfar (lirio de agua), musgo de roble y Incienso; las Notas de Fondo son almizcle, ámbar, azúcar y cedro.', 'products/01KS5N3WAGEQRWZADM46X2QKJH.jpg', '2026-05-21 20:15:21', '2026-05-21 20:15:21'),
(22, 'Odyssey Black Men', 'Armaf', 0, 29.75, 65.00, '[\"USDT\",\"Wally\",\"Zelle\",\"Pago Movil\",\"Cash\",\"Zinli\"]', 55.00, 0, 0, NULL, 'Odyssey Homme de Armaf es una fragancia de la familia olfativa Oriental para Hombres. Las Notas de Salida son cardamomo, mandarina y neroli; las Notas de Corazón son flor de azahar del naranjo y rosa; las Notas de Fondo son vainilla, sándalo, notas amaderadas y ámbar.', NULL, '2026-05-21 20:23:18', '2026-05-25 21:20:10'),
(23, 'Atheeri Women', 'Lattafa', 0, 34.85, 76.00, 'USDT', NULL, 0, 0, NULL, 'Atheeri de Lattafa Perfumes es una fragancia de la familia olfativa Oriental Floral para Mujeres. Esta fragrancia es nueva. Atheeri se lanzó en 2025. Las Notas de Salida son flor de pasionaria y Gota del rocío; las Notas de Corazón son orquídea y jazmín; las Notas de Fondo son vainilla y Amberwood.', 'products/01KS5NR2Q0H0V375511HERAAZZ.jpg', '2026-05-21 20:26:23', '2026-05-23 22:51:43'),
(24, 'Badee Al Oud \"Oud For Glory\"', 'Lattafa', 1, 27.20, 56.00, 'USDT', NULL, 0, 0, NULL, 'Bade\'e Al Oud Oud for Glory de Lattafa Perfumes es una fragancia de la familia olfativa Oriental Amaderada para Hombres y Mujeres. Bade\'e Al Oud Oud for Glory se lanzó en 2020. Las Notas de Salida son azafrán, nuez moscada y lavanda; las Notas de Corazón son madera de oud y pachulí; las Notas de Fondo son madera de oud, pachulí y almizcle.', 'products/01KS5Q1FDZBEVABAZ71E2A48P4.jpg', '2026-05-21 20:49:00', '2026-05-23 23:14:30'),
(25, 'Red 360 Men', 'Perry Elis', 1, 31.45, 65.00, 'USDT', NULL, 0, 0, NULL, '360 ° Red for Men de Perry Ellis es una fragancia oriental especiada para hombres. Fue lanzada en 2003. El perfumista detrás de esta fragancia es Jean-Louis Grauby. Las notas de salida son lima, bergamota, canela, naranja, mandarina, clavo y nuez moscada; las notas de corazón son lavanda y cilantro; las notas de fondo son almizcle, pachulí, cedro rojo, vetiver, sándalo y musgo de roble.', 'products/01KS5QNW93DAFZWS4AQECNWE0N.jpg', '2026-05-21 21:00:08', '2026-05-21 21:00:08'),
(26, 'Bullet Gun Metal Pour Homme', 'Bharara', 1, 21.25, 45.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-23 21:46:16', '2026-05-23 21:46:16'),
(27, 'Beauty Bullet Gold Men', 'Bharara', 1, 21.25, 45.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-23 21:46:42', '2026-05-23 21:46:42'),
(28, ' Odyssey Mandarin Sky', 'Armaf', 1, 34.00, 60.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-23 21:47:44', '2026-05-23 23:09:00'),
(29, '360 Red Women', 'Perry Ellis', 0, 32.30, 65.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-23 21:50:35', '2026-05-25 21:27:55'),
(30, 'Asad Elixir Men', 'Lattafa', 0, 34.00, 70.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-23 21:51:33', '2026-05-23 22:51:43'),
(31, 'Her Confession', 'Lattafa', 1, 41.65, 115.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-23 22:12:17', '2026-05-23 22:12:17'),
(32, 'Girl Women', 'Guess', 0, 19.55, 40.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 02:40:48', '2026-05-24 02:42:14'),
(33, 'Eros Flame', 'Versace', 0, 80.04, 120.00, 'USDT', NULL, 1, 0, NULL, NULL, 'products/01KSBHESENGP589QDJBE9G2DNY.jpg', '2026-05-24 03:06:51', '2026-05-24 03:14:00'),
(34, 'His Confesion', 'Lattafa', 1, 42.63, 115.00, 'USDT', NULL, 0, 0, NULL, NULL, 'products/01KSBHQTPMVDVHGYD1ZZ9J3DGK.jpg', '2026-05-24 03:11:47', '2026-05-24 03:14:00'),
(35, 'Gold Women', 'Guess', 0, 25.23, 58.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:15:20', '2026-05-24 03:31:42'),
(36, 'Women', 'Guess', 0, 22.62, 54.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:15:44', '2026-05-24 03:32:14'),
(37, 'Khamrah Qahwha', 'Lattafa', 0, 28.71, 50.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:16:28', '2026-05-24 03:56:26'),
(38, 'Khamrah', 'Lattafa', 0, 33.93, 65.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:16:39', '2026-05-24 03:19:03'),
(41, 'Club de Nuit Elixir', 'Armaf', 0, 38.28, 75.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:33:52', '2026-05-24 03:34:26'),
(42, 'Nitro Red', 'Dumont', 0, 35.67, 76.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:41:04', '2026-05-24 03:41:28'),
(43, 'Hayaati', 'Lattafa', 0, 19.14, 35.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:49:06', '2026-05-24 04:23:25'),
(44, 'Asad Bourbon', 'Lattafa', 0, 33.93, 65.00, NULL, NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:49:15', '2026-05-25 19:48:25'),
(45, 'Yara Elixir', 'Lattafa', 0, 34.80, 70.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:51:35', '2026-05-24 03:52:09'),
(46, 'Odysey Mandarin Sky 200ML', 'Armaf', 0, 49.59, 90.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:52:39', '2026-05-24 03:54:20'),
(47, '9PM Rebel', 'Afnan', 0, 38.28, 60.00, 'USDT', NULL, 0, 0, NULL, NULL, NULL, '2026-05-24 03:57:24', '2026-05-24 03:57:49'),
(48, 'King Men', 'Bharara', 0, 57.42, 115.00, '[\"USDT\",\"Wally\",\"Zelle\",\"Cash\",\"Zinli\",\"Pago Movil\"]', 90.00, 0, 0, NULL, NULL, NULL, '2026-05-24 20:09:48', '2026-05-26 05:00:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `rif`, `contacto`, `direccion`, `created_at`, `updated_at`) VALUES
(2, 'CASA DUBAI INTERNATIONAL C.A.', 'J-411774766', '0424 9093532', 'SECTOR PLAZA CBO', '2026-05-20 04:43:58', '2026-05-20 04:43:58'),
(3, 'FANTASY PERFUMES LA CANDELARIA', NULL, '0422-3003572', 'CARACAS, LA CANDELARIA, CC SAMBIL', '2026-05-20 19:40:30', '2026-05-20 19:40:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2026-05-18 05:43:31', '2026-05-18 05:43:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('HfqGRx1WS5BaE5uceSP5KesmzurH9uNQVgZnEnmf', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiSlM4dWxPamdKTUtVTFFpVDNHTFJIbERmcnZNRmd2WjlvT0hxREcwbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kZXRhbGxlLXZlbnRhcy8xNC9lZGl0IjtzOjU6InJvdXRlIjtzOjQ0OiJmaWxhbWVudC5hZG1pbi5yZXNvdXJjZXMuZGV0YWxsZS12ZW50YXMuZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiI1MWIyNDE5ODJkNThkMmQ5OTdjMDVlNTczMTEzNzgzZGYwYTNmZjAxOTIwOGIxOWY1OThiYzRmMWViNjliNjY4IjtzOjY6InRhYmxlcyI7YTozOntzOjQwOiIwM2IyYmViYmVmYjZlZWRlMGY0NGMxYTEwMDAxYWI3Ml9jb2x1bW5zIjthOjEyOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6Im1hcmNhX3BlcmZ1bWUiO3M6NToibGFiZWwiO3M6MTM6Ik1hcmNhIHBlcmZ1bWUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWUiO3M6NToibGFiZWwiO3M6NDoiTmFtZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToic3RvY2siO3M6NToibGFiZWwiO3M6NToiU3RvY2siO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE1OiJ3aG9sZXNhbGVfcHJpY2UiO3M6NToibGFiZWwiO3M6MTU6Ildob2xlc2FsZSBwcmljZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTI6InJldGFpbF9wcmljZSI7czo1OiJsYWJlbCI7czoxMjoiUmV0YWlsIHByaWNlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToibWV0b2RvX3BhZ28iO3M6NToibGFiZWwiO3M6MTY6Ik3DqXRvZG9zIGRlIFBhZ28iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJwcmVjaW9fZGl2aXNhIjtzOjU6ImxhYmVsIjtzOjEzOiJQcmVjaW8gZGl2aXNhIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMjoiaXNfZXhjbHVzaXZlIjtzOjU6ImxhYmVsIjtzOjEyOiJJcyBleGNsdXNpdmUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjg6ImlzX29mZmVyIjtzOjU6ImxhYmVsIjtzOjg6IklzIG9mZmVyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6OTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToib2ZmZXJfcHJpY2UiO3M6NToibGFiZWwiO3M6MTE6Ik9mZmVyIHByaWNlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjExO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6ImEwNzI1ZDRhMGJmNDhhMDFmZWU4OWJlMjU0ZTNmMGU2X2NvbHVtbnMiO2E6OTp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjg6InZlbnRhLmlkIjtzOjU6ImxhYmVsIjtzOjU6IlZlbnRhIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoicHJvZHVjdF9pZCI7czo1OiJsYWJlbCI7czo4OiJQcm9kdWN0byI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MjA6InZlbnRhLmNsaWVudGUubm9tYnJlIjtzOjU6ImxhYmVsIjtzOjc6IkNsaWVudGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjIyOiJwcm9kdWN0by5tYXJjYV9wZXJmdW1lIjtzOjU6ImxhYmVsIjtzOjU6Ik1hcmNhIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJjYW50aWRhZCI7czo1OiJsYWJlbCI7czo4OiJDYW50aWRhZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTU6InByZWNpb191bml0YXJpbyI7czo1OiJsYWJlbCI7czoxNToiUHJlY2lvIHVuaXRhcmlvIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJzdWJ0b3RhbCI7czo1OiJsYWJlbCI7czo4OiJTdWJ0b3RhbCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjg7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiNTUxODU3NmJjMjdlYzcxYWIwYzMxOTAwOTU3ZjA3MzVfY29sdW1ucyI7YTo2OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTQ6ImNsaWVudGUubm9tYnJlIjtzOjU6ImxhYmVsIjtzOjc6IkNsaWVudGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJ2ZW5kZWRvci5uYW1lIjtzOjU6ImxhYmVsIjtzOjg6IlZlbmRlZG9yIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToiZmVjaGFfdmVudGEiO3M6NToibGFiZWwiO3M6NToiRmVjaGEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjExOiJ0b3RhbF92ZW50YSI7czo1OiJsYWJlbCI7czo1OiJUb3RhbCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319fXM6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1779760245),
('xi8ZJQQkLSLxjK10VBmZmmW5tvq4Ow5ofhk0Ynlx', NULL, '127.0.0.1', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXdOVENMZzNhaDNURzl1RWlJY0ZEakw1ZEFZd0Q3Qmlxckc2aEx4NCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1779756062);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$LDn5G83XgwSVn8MfZsYcGuoVrPgWOimLnTH1uo0yj8n2vE48J7NgW', NULL, '2026-05-18 05:43:56', '2026-05-18 05:43:56'),
(2, 'deivys gamarra', 'gamarraynunezd@gmail.com', NULL, '$2y$12$QT1Ab9uOT0mcvb3g12tEfusXbkuXXvafTevz0GKfkIN1rTRHsHape', 'dK3T8VvsCPwIBCOlByup1I5kangyC7cp1AxMcFPyLbwZ5J6ffvvmmynkhI5W', '2026-05-23 19:23:47', '2026-05-23 19:23:47'),
(3, 'Alejandro', 'alejandrorivera221200@gmail.com', NULL, '$2y$12$JXxJGOcjfv1sWaiTayrcs.fBAHqt2j.D35iePqmSFaArEEU0uoW8K', '53mBqxJQ0AboeXTDM4boX1wWWn6UGbfhlUPAOtShGh4W21wFEHx7XtCUFu1T', '2026-05-23 19:26:25', '2026-05-24 01:33:36'),
(4, 'orlhey gonzalez', 'orlhey47@gmail.com', NULL, '$2y$12$nW.46GuMyVbalJDv8hUyNeRw/vLJTeKq0LDY4Ev.reBmL/gK1Bkby', 'OddCRejVkLgKPyBUhQBV67L4i5qiBBKdV9ymo4pedMpfjgL5Ri9nZU2EnpQf', '2026-05-23 19:27:16', '2026-05-23 19:27:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `fecha_venta` date NOT NULL,
  `total_venta` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `cliente_id`, `user_id`, `fecha_venta`, `total_venta`, `created_at`, `updated_at`) VALUES
(4, 3, 3, '2026-05-23', 180.00, '2026-05-23 19:40:04', '2026-05-23 19:40:04'),
(8, 5, 3, '2026-05-23', 28.00, '2026-05-23 22:49:01', '2026-05-23 22:49:01'),
(9, 6, 3, '2026-05-23', 146.00, '2026-05-23 22:51:43', '2026-05-23 23:02:08'),
(10, 7, 3, '2026-05-23', 60.00, '2026-05-23 23:09:00', '2026-05-23 23:09:00'),
(11, 8, 3, '2026-05-23', 45.00, '2026-05-23 23:10:22', '2026-05-23 23:10:22'),
(12, 9, 3, '2026-05-23', 80.00, '2026-05-23 23:14:30', '2026-05-24 01:36:54'),
(13, 10, 2, '2026-05-23', 65.00, '2026-05-23 23:16:24', '2026-05-23 23:16:24'),
(14, 11, 3, '2026-05-23', 50.00, '2026-05-23 23:18:02', '2026-05-23 23:18:02'),
(15, 13, 3, '2026-05-23', 115.00, '2026-05-24 01:39:07', '2026-05-24 01:39:07'),
(16, 14, 3, '2026-05-23', 105.00, '2026-05-24 02:36:23', '2026-05-24 02:36:23'),
(17, 15, 3, '2026-05-23', 160.00, '2026-05-24 02:37:35', '2026-05-24 02:37:35'),
(18, 16, 3, '2026-05-23', 28.00, '2026-05-24 02:38:11', '2026-05-24 02:38:11'),
(19, 17, 3, '2026-05-23', 70.00, '2026-05-24 02:42:14', '2026-05-24 02:42:14'),
(20, 18, 3, '2026-04-27', 235.00, '2026-05-24 03:14:00', '2026-05-24 03:48:14'),
(21, 19, 3, '2026-04-27', 112.00, '2026-05-24 03:18:21', '2026-05-24 03:46:56'),
(22, 20, 3, '2026-04-27', 65.00, '2026-05-24 03:19:03', '2026-05-24 03:46:43'),
(23, 21, 3, '2026-04-27', 50.00, '2026-05-24 03:21:08', '2026-05-24 03:46:30'),
(24, 22, 3, '2026-04-27', 58.00, '2026-05-24 03:22:02', '2026-05-24 03:46:22'),
(25, 23, 3, '2026-04-27', 50.00, '2026-05-24 03:24:03', '2026-05-24 03:46:00'),
(26, 24, 3, '2026-04-27', 50.00, '2026-05-24 03:26:19', '2026-05-24 03:44:54'),
(27, 25, 3, '2026-04-27', 54.00, '2026-05-24 03:27:21', '2026-05-24 03:44:46'),
(28, 26, 3, '2026-04-27', 58.00, '2026-05-24 03:31:42', '2026-05-24 03:44:37'),
(29, 27, 3, '2026-04-27', 54.00, '2026-05-24 03:32:14', '2026-05-24 03:44:29'),
(30, 13, 3, '2026-04-27', 75.00, '2026-05-24 03:34:26', '2026-05-24 03:43:14'),
(32, 29, 3, '2026-04-27', 65.00, '2026-05-24 03:38:18', '2026-05-24 03:42:41'),
(33, 19, 3, '2026-04-27', 76.00, '2026-05-24 03:41:28', '2026-05-24 03:42:06'),
(34, 30, 3, '2026-04-27', 35.00, '2026-05-24 03:49:43', '2026-05-24 03:50:03'),
(35, 31, 3, '2026-04-27', 65.00, '2026-05-24 03:50:35', '2026-05-24 03:54:55'),
(36, 27, 3, '2026-04-27', 105.00, '2026-05-24 03:51:02', '2026-05-24 03:55:03'),
(37, 7, 3, '2026-04-27', 70.00, '2026-05-24 03:52:09', '2026-05-24 03:55:08'),
(38, 33, 3, '2026-04-27', 90.00, '2026-05-24 03:53:06', '2026-05-24 03:55:31'),
(39, 26, 3, '2026-05-23', 50.00, '2026-05-24 03:56:26', '2026-05-24 03:56:26'),
(40, 34, 3, '2026-05-23', 60.00, '2026-05-24 03:57:49', '2026-05-24 03:57:49'),
(41, 35, 4, '2026-04-27', 85.00, '2026-05-24 04:23:25', '2026-05-24 04:25:09'),
(42, 36, 4, '2026-05-24', 45.00, '2026-05-24 04:24:00', '2026-05-24 04:24:00'),
(43, 20, 3, '2026-05-24', 65.00, '2026-05-24 04:24:46', '2026-05-24 04:24:46'),
(49, 38, 3, '2026-05-25', 65.00, '2026-05-25 19:48:25', '2026-05-25 19:48:25'),
(50, 39, 3, '2026-05-25', 55.00, '2026-05-25 21:20:10', '2026-05-25 21:20:10'),
(51, 40, 3, '2026-05-25', 65.00, '2026-05-25 21:27:55', '2026-05-25 21:27:55'),
(52, 41, 3, '2026-05-26', 50.00, '2026-05-26 04:56:28', '2026-05-26 04:56:28'),
(53, 41, 3, '2026-05-26', 115.00, '2026-05-26 05:00:19', '2026-05-26 05:09:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_proveedor_id_foreign` (`proveedor_id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_compras_compra_id_foreign` (`compra_id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_venta_id_foreign` (`venta_id`),
  ADD KEY `detalle_ventas_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
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
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_cliente_id_foreign` (`cliente_id`),
  ADD KEY `ventas_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_proveedor_id_foreign` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`);

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_compra_id_foreign` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

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
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
