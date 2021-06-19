-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 08, 2021 at 08:36 PM
-- Server version: 10.3.23-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lflsoftw_cambd`
--

-- --------------------------------------------------------

--
-- Table structure for table `adelanto`
--

CREATE TABLE `adelanto` (
  `id_adelanto` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `valor` int(11) NOT NULL,
  `fecha_registrado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_factura` int(11) DEFAULT NULL,
  `id_factura_general` int(11) DEFAULT NULL,
  `id_factura_supervisor` int(11) DEFAULT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asistencia`
--

CREATE TABLE `asistencia` (
  `id_asistencia` int(11) NOT NULL,
  `id_supervisor` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `asistencia`
--

INSERT INTO `asistencia` (`id_asistencia`, `id_supervisor`, `fecha`, `estado`) VALUES
(21, 37, '2021-01-28', 'finalizado'),
(22, 35, '2021-01-31', 'finalizado'),
(23, 36, '2021-02-02', 'finalizado'),
(24, 50, '2021-02-02', 'finalizado'),
(25, 35, '2021-02-02', 'finalizado'),
(26, 50, '2021-02-03', 'finalizado'),
(27, 35, '2021-02-03', 'finalizado'),
(28, 40, '2021-02-03', 'activo'),
(29, 35, '2021-02-04', 'finalizado'),
(30, 50, '2021-02-05', 'finalizado'),
(31, 36, '2021-02-05', 'finalizado'),
(32, 35, '2021-02-05', 'finalizado'),
(33, 37, '2021-02-05', 'finalizado'),
(34, 50, '2021-02-06', 'finalizado'),
(35, 36, '2021-02-06', 'finalizado'),
(36, 35, '2021-02-06', 'finalizado'),
(37, 37, '2021-02-07', 'activo'),
(38, 36, '2021-02-08', 'finalizado'),
(39, 50, '2021-02-08', 'finalizado');

-- --------------------------------------------------------

--
-- Table structure for table `asistencia_empleado`
--

CREATE TABLE `asistencia_empleado` (
  `id_asistencia_empleado` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_asistencia` int(11) NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `asistencia_empleado`
--

INSERT INTO `asistencia_empleado` (`id_asistencia_empleado`, `id_empleado`, `id_asistencia`, `estado`) VALUES
(44, 13, 21, 'registrado'),
(45, 27, 21, 'registrado'),
(46, 47, 21, 'registrado'),
(47, 23, 21, 'registrado'),
(48, 32, 22, 'sin registrar'),
(49, 33, 22, 'sin registrar'),
(50, 18, 22, 'registrado'),
(51, 28, 22, 'registrado'),
(52, 42, 22, 'sin registrar'),
(53, 22, 22, 'sin registrar'),
(54, 29, 22, 'registrado'),
(55, 20, 23, 'registrado'),
(56, 16, 23, 'registrado'),
(57, 26, 23, 'sin registrar'),
(58, 43, 23, 'registrado'),
(59, 15, 23, 'registrado'),
(60, 53, 23, 'registrado'),
(61, 34, 24, 'sin registrar'),
(62, 48, 24, 'registrado'),
(63, 41, 24, 'sin registrar'),
(64, 31, 24, 'registrado'),
(65, 32, 24, 'registrado'),
(66, 33, 24, 'registrado'),
(67, 18, 25, 'sin registrar'),
(68, 28, 25, 'sin registrar'),
(69, 42, 25, 'sin registrar'),
(70, 22, 25, 'sin registrar'),
(71, 29, 25, 'sin registrar'),
(72, 34, 26, 'sin registrar'),
(73, 48, 26, 'registrado'),
(74, 41, 26, 'registrado'),
(75, 31, 26, 'registrado'),
(76, 32, 26, 'registrado'),
(77, 33, 26, 'registrado'),
(78, 18, 27, 'registrado'),
(79, 28, 27, 'registrado'),
(80, 42, 27, 'registrado'),
(81, 22, 27, 'sin registrar'),
(82, 29, 27, 'registrado'),
(83, 30, 28, 'sin registrar'),
(84, 25, 28, 'sin registrar'),
(85, 19, 28, 'sin registrar'),
(86, 54, 28, 'sin registrar'),
(87, 18, 29, 'registrado'),
(88, 28, 29, 'registrado'),
(89, 42, 29, 'registrado'),
(90, 22, 29, 'sin registrar'),
(91, 29, 29, 'registrado'),
(92, 48, 30, 'registrado'),
(93, 41, 30, 'registrado'),
(94, 31, 30, 'registrado'),
(95, 33, 30, 'registrado'),
(96, 34, 30, 'sin registrar'),
(97, 53, 30, 'registrado'),
(98, 32, 30, 'registrado'),
(99, 32, 30, 'registrado'),
(100, 32, 30, 'registrado'),
(101, 14, 31, 'registrado'),
(102, 20, 31, 'registrado'),
(103, 16, 31, 'sin registrar'),
(104, 26, 31, 'sin registrar'),
(105, 43, 31, 'registrado'),
(106, 15, 31, 'sin registrar'),
(107, 29, 32, 'registrado'),
(108, 56, 32, 'registrado'),
(109, 18, 32, 'registrado'),
(110, 28, 32, 'registrado'),
(111, 42, 32, 'registrado'),
(112, 13, 33, 'registrado'),
(113, 27, 33, 'registrado'),
(114, 22, 33, 'registrado'),
(115, 47, 33, 'registrado'),
(116, 23, 33, 'registrado'),
(117, 17, 33, 'registrado'),
(118, 48, 34, 'registrado'),
(119, 41, 34, 'registrado'),
(120, 31, 34, 'registrado'),
(121, 33, 34, 'registrado'),
(122, 34, 34, 'sin registrar'),
(123, 32, 34, 'registrado'),
(124, 32, 34, 'registrado'),
(125, 32, 34, 'registrado'),
(126, 14, 35, 'sin registrar'),
(127, 20, 35, 'sin registrar'),
(128, 16, 35, 'sin registrar'),
(129, 26, 35, 'sin registrar'),
(130, 43, 35, 'sin registrar'),
(131, 15, 35, 'sin registrar'),
(132, 53, 35, 'sin registrar'),
(133, 29, 36, 'sin registrar'),
(134, 56, 36, 'sin registrar'),
(135, 18, 36, 'registrado'),
(136, 28, 36, 'registrado'),
(137, 42, 36, 'registrado'),
(138, 13, 37, 'sin registrar'),
(139, 27, 37, 'sin registrar'),
(140, 22, 37, 'sin registrar'),
(141, 47, 37, 'sin registrar'),
(142, 23, 37, 'sin registrar'),
(143, 17, 37, 'registrado'),
(144, 14, 38, 'registrado'),
(145, 20, 38, 'registrado'),
(146, 16, 38, 'sin registrar'),
(147, 26, 38, 'registrado'),
(148, 43, 38, 'registrado'),
(149, 15, 38, 'registrado'),
(150, 53, 38, 'registrado'),
(151, 48, 39, 'registrado'),
(152, 41, 39, 'registrado'),
(153, 31, 39, 'registrado'),
(154, 33, 39, 'sin registrar'),
(155, 34, 39, 'sin registrar'),
(156, 32, 39, 'sin registrar'),
(157, 32, 39, 'sin registrar'),
(158, 32, 39, 'sin registrar');

-- --------------------------------------------------------

--
-- Table structure for table `citas`
--

CREATE TABLE `citas` (
  `id_citas` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_fotografo` int(11) NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `citas`
--

INSERT INTO `citas` (`id_citas`, `id_empleado`, `id_fotografo`, `descripcion`, `fecha`, `hora`, `estado`) VALUES
(1, 4, 15, 'hola como estas estas', '2021-01-21', '05:00:00', 'antigua'),
(2, 4, 15, 'dsadadas', '2021-01-05', '14:21:42', 'antigua'),
(4, 4, 15, 'asdsdas', '0000-00-00', '00:00:00', 'antigua'),
(5, 4, 15, 'sdsdssd', '2021-01-26', '23:25:00', 'antigua'),
(6, 7, 15, 'sasdasda', '2021-01-29', '12:06:00', 'eliminado'),
(7, 12, 15, 'dsadasds', '2021-01-21', '00:24:00', 'antigua'),
(8, 17, 15, 'sdsdadsds', '2021-01-29', '12:24:00', 'pendiente'),
(9, 7, 15, 'adssdasda', '2021-01-29', '17:03:00', 'pendiente');

-- --------------------------------------------------------

--
-- Table structure for table `dolar`
--

CREATE TABLE `dolar` (
  `id_dolar` int(11) NOT NULL,
  `valor_dolar` int(11) NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `dolar`
--

INSERT INTO `dolar` (`id_dolar`, `valor_dolar`, `estado`, `fecha_registro`) VALUES
(1, 3500, 'inactivo', '2020-11-06 22:49:40'),
(2, 3200, 'inactivo', '2020-11-06 22:49:40'),
(3, 3200, 'inactivo', '2020-11-06 22:49:40'),
(4, 3200, 'inactivo', '2020-11-06 22:53:04'),
(5, 3544, 'inactivo', '2020-11-06 22:57:49'),
(6, 3500, 'inactivo', '2020-11-07 00:53:38'),
(7, 3600, 'inactivo', '2020-11-07 04:25:55'),
(8, 0, 'inactivo', '2020-11-30 15:24:50'),
(9, 4000, 'inactivo', '2020-11-30 15:24:58'),
(10, 4500, 'activo', '2020-11-30 20:19:21');

-- --------------------------------------------------------

--
-- Table structure for table `empleado_penalizacion`
--

CREATE TABLE `empleado_penalizacion` (
  `id_empleado_penalizacion` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_supervisor` int(11) NOT NULL,
  `id_penalizacion` int(11) NOT NULL,
  `puntos` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'Sin observación',
  `fecha_registrado` date NOT NULL DEFAULT current_timestamp(),
  `id_factura` int(11) DEFAULT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `empleado_penalizacion`
--

INSERT INTO `empleado_penalizacion` (`id_empleado_penalizacion`, `id_empleado`, `id_supervisor`, `id_penalizacion`, `puntos`, `descripcion`, `fecha_registrado`, `id_factura`, `estado`) VALUES
(17, 29, 35, 1, 200, 'Deja el room sucio.', '2021-01-29', NULL, 'sin registrar');

-- --------------------------------------------------------

--
-- Table structure for table `empleado_supervisor`
--

CREATE TABLE `empleado_supervisor` (
  `id_relacion_es` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_supervisor` int(11) NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `empleado_supervisor`
--

INSERT INTO `empleado_supervisor` (`id_relacion_es`, `id_empleado`, `id_supervisor`, `estado`) VALUES
(14, 18, 35, 'inactivo'),
(15, 28, 35, 'inactivo'),
(16, 29, 35, 'inactivo'),
(17, 31, 35, 'inactivo'),
(18, 13, 37, 'inactivo'),
(19, 14, 36, 'inactivo'),
(20, 15, 36, 'inactivo'),
(21, 16, 36, 'inactivo'),
(22, 17, 36, 'inactivo'),
(23, 20, 36, 'inactivo'),
(24, 22, 37, 'inactivo'),
(25, 23, 37, 'inactivo'),
(26, 26, 36, 'inactivo'),
(27, 27, 37, 'inactivo'),
(28, 32, 35, 'inactivo'),
(29, 33, 35, 'inactivo'),
(30, 34, 35, 'inactivo'),
(31, 19, 40, 'inactivo'),
(32, 25, 40, 'inactivo'),
(33, 30, 40, 'inactivo'),
(34, 41, 35, 'inactivo'),
(35, 46, 49, 'inactivo'),
(36, 34, 50, 'inactivo'),
(37, 48, 50, 'inactivo'),
(38, 41, 50, 'inactivo'),
(39, 31, 50, 'inactivo'),
(40, 45, 49, 'inactivo'),
(41, 46, 49, 'inactivo'),
(42, 34, 50, 'inactivo'),
(43, 48, 50, 'inactivo'),
(44, 41, 50, 'inactivo'),
(45, 31, 50, 'inactivo'),
(46, 14, 50, 'inactivo'),
(47, 14, 36, 'inactivo'),
(48, 14, 36, 'inactivo'),
(49, 20, 36, 'inactivo'),
(50, 16, 36, 'inactivo'),
(51, 26, 36, 'inactivo'),
(52, 43, 36, 'inactivo'),
(53, 15, 36, 'inactivo'),
(54, 32, 35, 'inactivo'),
(55, 33, 35, 'inactivo'),
(56, 18, 35, 'inactivo'),
(57, 28, 35, 'inactivo'),
(58, 42, 35, 'inactivo'),
(59, 13, 37, 'inactivo'),
(60, 27, 37, 'inactivo'),
(61, 22, 35, 'inactivo'),
(62, 47, 37, 'inactivo'),
(63, 23, 37, 'inactivo'),
(64, 30, 40, 'inactivo'),
(65, 25, 40, 'inactivo'),
(66, 19, 40, 'inactivo'),
(67, 17, 49, 'inactivo'),
(68, 45, 49, 'inactivo'),
(69, 46, 49, 'inactivo'),
(70, 29, 35, 'inactivo'),
(71, 46, 37, 'inactivo'),
(72, 52, 37, 'inactivo'),
(73, 53, 36, 'inactivo'),
(74, 54, 40, 'inactivo'),
(75, 32, 50, 'inactivo'),
(76, 33, 50, 'inactivo'),
(77, 14, 36, 'inactivo'),
(78, 48, 50, 'activo'),
(79, 41, 50, 'activo'),
(80, 31, 50, 'activo'),
(81, 33, 50, 'activo'),
(82, 34, 50, 'activo'),
(83, 53, 50, 'inactivo'),
(84, 14, 36, 'activo'),
(85, 20, 36, 'activo'),
(86, 16, 36, 'activo'),
(87, 26, 36, 'activo'),
(88, 43, 36, 'activo'),
(89, 15, 36, 'activo'),
(90, 29, 35, 'activo'),
(91, 56, 35, 'activo'),
(92, 18, 35, 'activo'),
(93, 28, 35, 'activo'),
(94, 42, 35, 'activo'),
(95, 59, 49, 'activo'),
(96, 58, 49, 'activo'),
(97, 45, 49, 'activo'),
(98, 61, 49, 'activo'),
(99, 13, 37, 'activo'),
(100, 27, 37, 'activo'),
(101, 22, 37, 'activo'),
(102, 47, 37, 'activo'),
(103, 23, 37, 'activo'),
(104, 17, 37, 'activo'),
(105, 46, 40, 'activo'),
(106, 52, 37, 'inactivo'),
(107, 57, 37, 'inactivo'),
(108, 54, 40, 'activo'),
(109, 19, 62, 'activo'),
(110, 25, 62, 'activo'),
(111, 30, 62, 'activo'),
(112, 32, 50, 'activo'),
(113, 32, 50, 'activo'),
(114, 32, 50, 'activo'),
(115, 57, 40, 'activo'),
(116, 52, 40, 'activo'),
(117, 53, 50, 'inactivo'),
(118, 24, 49, 'inactivo'),
(119, 53, 36, 'activo'),
(120, 24, 49, 'inactivo'),
(121, 24, 49, 'activo');

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_talento_humano` int(11) NOT NULL,
  `id_dolar` int(11) NOT NULL,
  `id_porcentaje_dias` int(11) DEFAULT NULL,
  `id_meta` int(11) NOT NULL,
  `estado_meta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `cant_dias` int(11) NOT NULL,
  `descuento` int(11) NOT NULL,
  `penalizacion_horas` int(11) NOT NULL,
  `total_horas` int(11) NOT NULL,
  `porcentaje_paga` int(11) NOT NULL,
  `total_a_pagar` int(11) NOT NULL,
  `fecha_registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estado_factura` varchar(100) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'sin registrar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `factura_general`
--

CREATE TABLE `factura_general` (
  `id_factura_general` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_sueldo` int(11) NOT NULL,
  `descuentos` int(11) NOT NULL,
  `total_a_pagar` int(11) NOT NULL,
  `fecha_registrado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `factura_supervisor`
--

CREATE TABLE `factura_supervisor` (
  `id_factura_supervisor` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `id_meta` int(11) NOT NULL,
  `id_sueldo` int(11) NOT NULL,
  `cant_horas` int(11) NOT NULL,
  `estado_meta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descuento` int(11) NOT NULL,
  `total_comision` int(11) NOT NULL,
  `total_paga` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estado_factura` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gastos`
--

CREATE TABLE `gastos` (
  `id_gasto` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `valor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `gastos`
--

INSERT INTO `gastos` (`id_gasto`, `id_empleado`, `descripcion`, `valor`, `fecha`, `fecha_registro`) VALUES
(1, 8, 'Prueba', 0, '2020-12-16', '2020-12-16 16:04:55'),
(5, 6, 'Prueba', 0, '2020-12-18', '2020-12-18 15:07:09');

-- --------------------------------------------------------

--
-- Table structure for table `horas_ingresos`
--

CREATE TABLE `horas_ingresos` (
  `id_horas_ingresos` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `horas_ingresos`
--

INSERT INTO `horas_ingresos` (`id_horas_ingresos`, `id_usuario`, `fecha`) VALUES
(0, 1, '2021-01-30 14:51:17'),
(1, 1, '2021-01-21 16:11:33'),
(2, 1, '2021-01-21 16:15:33'),
(3, 3, '2021-01-21 16:54:36'),
(4, 1, '2021-01-21 16:54:52'),
(5, 15, '2021-01-21 17:01:05'),
(6, 1, '2021-01-21 17:01:21'),
(7, 15, '2021-01-21 17:37:33'),
(8, 15, '2021-01-22 00:11:27'),
(9, 1, '2021-01-22 13:14:44'),
(10, 1, '2021-01-22 14:32:06'),
(11, 14, '2021-01-22 14:32:48'),
(12, 15, '2021-01-22 14:33:03'),
(13, 1, '2021-01-22 14:33:43'),
(14, 1, '2021-01-26 21:34:11'),
(15, 4, '2021-01-26 21:35:46'),
(16, 4, '2021-01-26 21:58:01'),
(17, 3, '2021-01-26 21:58:13'),
(18, 4, '2021-01-26 21:58:26'),
(19, 4, '2021-01-26 23:12:40'),
(20, 4, '2021-01-27 01:14:06'),
(21, 3, '2021-01-27 01:14:24'),
(22, 7, '2021-01-27 01:14:57'),
(23, 3, '2021-01-27 01:19:10'),
(24, 6, '2021-01-27 01:20:25'),
(25, 3, '2021-01-27 01:20:56'),
(26, 1, '2021-01-27 01:26:21'),
(27, 6, '2021-01-27 01:26:38'),
(28, 1, '2021-01-27 01:27:16'),
(29, 6, '2021-01-27 01:27:50'),
(30, 1, '2021-01-27 01:28:32'),
(31, 7, '2021-01-27 01:28:43'),
(32, 4, '2021-01-27 02:21:57'),
(33, 15, '2021-01-27 02:23:39'),
(34, 4, '2021-01-27 02:28:26'),
(35, 15, '2021-01-27 02:31:54'),
(36, 14, '2021-01-27 02:32:25'),
(37, 1, '2021-01-27 02:32:40'),
(38, 4, '2021-01-27 02:33:17'),
(39, 4, '2021-01-27 02:34:34'),
(40, 7, '2021-01-27 02:34:49'),
(41, 1, '2021-01-27 03:58:36'),
(42, 3, '2021-01-27 04:06:27'),
(43, 3, '2021-01-27 04:07:19'),
(44, 6, '2021-01-27 04:07:45'),
(45, 1, '2021-01-27 04:08:41'),
(46, 6, '2021-01-27 04:09:09'),
(47, 1, '2021-01-27 04:09:35'),
(48, 4, '2021-01-27 04:10:22'),
(49, 7, '2021-01-27 04:30:37'),
(50, 1, '2021-01-27 04:34:33'),
(51, 7, '2021-01-27 04:37:25'),
(52, 1, '2021-01-27 04:40:15'),
(53, 14, '2021-01-27 04:42:07'),
(54, 15, '2021-01-27 04:42:32'),
(55, 15, '2021-01-27 17:00:24'),
(56, 1, '2021-01-27 17:25:11'),
(57, 4, '2021-01-27 17:50:09'),
(58, 7, '2021-01-27 17:54:35'),
(59, 1, '2021-01-27 17:56:56'),
(60, 7, '2021-01-27 18:59:25'),
(61, 15, '2021-01-27 19:00:08'),
(62, 7, '2021-01-27 19:00:54'),
(63, 1, '2021-01-27 19:03:07'),
(64, 6, '2021-01-27 19:04:05'),
(65, 7, '2021-01-27 19:13:17'),
(66, 3, '2021-01-27 19:15:21'),
(67, 7, '2021-01-27 19:15:49'),
(68, 6, '2021-01-27 19:16:07'),
(69, 7, '2021-01-27 19:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `informe_empleados`
--

CREATE TABLE `informe_empleados` (
  `id_informe_empleado` int(11) NOT NULL,
  `id_supervisor` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `informe_empleados`
--

INSERT INTO `informe_empleados` (`id_informe_empleado`, `id_supervisor`, `id_empleado`, `descripcion`, `fecha`) VALUES
(0, 35, 18, 'Modelo realizo su show sin problemas se le hace acompañamiento tecnico y en comunicacion con usuarios', '2021-02-01'),
(5, 3, 7, 'hol hola', '2021-01-19'),
(6, 3, 7, 'dassdsdd', '2021-01-20');

-- --------------------------------------------------------

--
-- Table structure for table `ingresos`
--

CREATE TABLE `ingresos` (
  `id_ingreso` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `porcentaje` int(11) NOT NULL,
  `fecha_registro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

CREATE TABLE `metas` (
  `id_meta` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `num_horas` int(11) NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `metas`
--

INSERT INTO `metas` (`id_meta`, `id_empleado`, `id_administrador`, `descripcion`, `num_horas`, `estado`, `fecha_registro`) VALUES
(75, 31, 12, 'Primera quincena Febrero', 18000, 'sin registrar', '2021-01-26 23:37:36'),
(76, 50, 12, 'ninguna', 48500, 'sin registrar', '2021-01-26 23:37:36'),
(77, 41, 12, 'Meta Quincena', 11000, 'sin registrar', '2021-01-26 23:38:49'),
(78, 34, 12, 'Meta', 0, 'sin registrar', '2021-01-28 20:24:18'),
(79, 48, 12, 'Meta', 8000, 'sin registrar', '2021-01-28 20:25:00'),
(80, 14, 12, 'Meta', 18000, 'sin registrar', '2021-01-28 20:25:29'),
(81, 36, 12, 'ninguna', 86000, 'sin registrar', '2021-01-28 20:25:29'),
(82, 20, 12, 'Meta', 17000, 'sin registrar', '2021-01-28 20:25:49'),
(83, 16, 12, 'Meta', 10000, 'sin registrar', '2021-01-28 20:26:34'),
(84, 26, 12, 'Meta', 15000, 'sin registrar', '2021-01-28 20:27:03'),
(85, 43, 12, 'Meta', 14000, 'sin registrar', '2021-01-28 20:27:17'),
(86, 15, 12, 'Meta', 12000, 'sin registrar', '2021-01-28 20:27:39'),
(87, 29, 12, 'Meta', 13000, 'sin registrar', '2021-01-28 20:27:56'),
(88, 35, 12, 'ninguna', 93500, 'sin registrar', '2021-01-28 20:27:56'),
(89, 33, 12, 'Meta', 11500, 'sin registrar', '2021-01-28 20:28:27'),
(90, 18, 12, 'Meta', 37000, 'sin registrar', '2021-01-28 20:41:24'),
(91, 28, 12, 'Meta', 14500, 'sin registrar', '2021-01-28 20:42:09'),
(92, 42, 12, 'Meta', 20000, 'sin registrar', '2021-01-28 20:42:53'),
(93, 17, 12, 'Meta', 8000, 'sin registrar', '2021-01-28 20:43:24'),
(94, 49, 12, 'ninguna', 11500, 'sin registrar', '2021-01-28 20:43:24'),
(95, 45, 12, 'Meta', 3500, 'sin registrar', '2021-01-28 20:43:50'),
(96, 46, 12, 'Meta', 10000, 'sin registrar', '2021-01-28 20:44:06'),
(97, 13, 12, 'Meta', 10000, 'sin registrar', '2021-01-28 20:46:17'),
(98, 37, 12, 'ninguna', 58000, 'sin registrar', '2021-01-28 20:46:17'),
(99, 27, 12, 'Meta', 13000, 'sin registrar', '2021-01-28 20:47:00'),
(100, 22, 12, 'Meta', 9000, 'sin registrar', '2021-01-28 20:47:47'),
(101, 23, 12, 'Meta', 15000, 'sin registrar', '2021-01-28 20:48:10'),
(102, 47, 12, 'Meta', 10000, 'sin registrar', '2021-01-28 20:49:11'),
(103, 19, 12, 'Meta', 10000, 'sin registrar', '2021-01-28 20:49:50'),
(104, 40, 12, 'ninguna', 37000, 'sin registrar', '2021-01-28 20:49:50'),
(105, 30, 12, 'Meta', 12000, 'sin registrar', '2021-01-28 20:50:05'),
(106, 25, 12, 'Meta', 15000, 'sin registrar', '2021-01-28 20:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `paginas`
--

CREATE TABLE `paginas` (
  `id_pagina` int(11) NOT NULL,
  `url_pagina` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `paginas`
--

INSERT INTO `paginas` (`id_pagina`, `url_pagina`, `estado`) VALUES
(1, 'Chaturbate', 'activo'),
(2, 'StripChat', 'activo'),
(3, 'Camsoda', 'activo'),
(4, 'MyFreeCams', 'activo'),
(5, 'www.chaturbate.com/isabella1__', 'inactivo'),
(6, 'BongaCams', 'activo');

-- --------------------------------------------------------

--
-- Table structure for table `penalizaciones`
--

CREATE TABLE `penalizaciones` (
  `id_penalizacion` int(11) NOT NULL,
  `nombre_penalizacion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `puntos` int(11) NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `penalizaciones`
--

INSERT INTO `penalizaciones` (`id_penalizacion`, `nombre_penalizacion`, `puntos`, `estado`) VALUES
(1, 'Aseo', 200, 'activo'),
(2, 'Llegar tarde', 200, 'activo'),
(3, 'Exceso de uso del móvil', 150, 'activo');

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL,
  `documento` bigint(20) NOT NULL,
  `nombres` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ciudad` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `correo_personal` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `observaciones` text COLLATE utf8_spanish2_ci NOT NULL,
  `numero_cuenta_banco` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo_cuenta_banco` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre_banco` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`id_persona`, `documento`, `nombres`, `apellidos`, `fecha_nacimiento`, `sexo`, `ciudad`, `direccion`, `correo_personal`, `telefono`, `observaciones`, `numero_cuenta_banco`, `tipo_cuenta_banco`, `nombre_banco`, `foto`) VALUES
(6, 108802, 'maria juana', 'Lopez', '2020-03-18', 'masculino', 'pereira', '', '', '', '', '', '', '', '108802.jpg'),
(8, 1088, 'Omar', 'PAJON', '2020-11-04', 'masculino', 'pereira', 'belmontet', 'wiky@hotmail.com', '321456', 'ninguna', '3232132', 'nomina', 'banco', '1088.jpg'),
(11, 1088025816, 'Wiki ', 'Lopez', '1996-04-01', 'masculino', 'PEREIRA', 'calle 38 11-38 Guadalupe, Dosquebradas ', 'wikilopez0122@gmail.com', '3217437193', 'nn', '488403321315', 'ahorros', 'DAVIVIENDA', '1088025816.jpg'),
(12, 4518150, 'Admin', 'Gz', '1984-12-17', 'masculino', 'PEREIRA', '3148189020', 'admin@hotmail.com', '3148189020', 'No', '111', '1111', '1111', '4518150.jpg'),
(13, 1152200713, 'Natacha Mejia Echavarria', ' Mejia Echavarria', '1993-04-13', 'femenino', 'Pereira', 'Manzana 8 casa 13 villa alexandra', '2020romic2020@gmail.com', '3137249018', 'nn', '488416731740', 'Ahorros', 'Davivienda', '1152200713.jpg'),
(14, 1088257108, 'Alejandra Castrillon Rodriguez', 'Castrillon Rodriguez', '1988-02-28', 'femenino', 'pereira', 'Poblado 2 mz 7', '2020clarafiore2020@gmail.com', '3226838783', 'nn', '488417510754', 'nnCuenta de ahorros ', 'Davivienda ', '1088257108.jpg'),
(15, 1007732578, 'Sindy Yuliana Castro Ortiz', 'Castro Ortiz', '2000-11-22', 'femenino', 'Pereira', 'CALLE 15 #6-70 portal de la macarena (Dosquebradas) ', '2020karlascott2020@gmail.com', '3105488479 ', 'nn', '488408068622', 'ahorros', 'Davivienda ', '1007732578.png'),
(16, 29465313, 'Mónica  Lorena Giraldo ', ' Lorena Giraldo ', '1984-12-03', 'femenino', 'Dosquebradas', 'Campestre D manzana 12 casa 5 piso 2', '2020margaretcruz2020@gmail.com', '3213470061', 'nn', '488401413064', 'Ahorros', 'Davivienda ', '29465313.jpg'),
(17, 29916225, 'Diana Marcela Narvaez', 'Narvaez', '1985-08-09', 'femenino', 'pereira', 'nn', '2020sarajay2020@gmail.com', 'nn', 'nn', 'nn', 'nn', 'nn', '29916225.jpg'),
(18, 1087489661, 'Erica vallejo ', 'vallejo ', '1989-10-27', 'femenino', 'pereira', '72199376994', 'modelisabella1@gmail.com', '3113300115', 'nn', 'Ahorro', 'Bancolombia', 'nn', '1087489661.jpg'),
(19, 1010058846, 'jalime Xiomara Calle Henao', 'Calle Henao', '1998-05-26', 'femenino', 'pereira', 'La Virginia barrio balsillas carrera 5 #12-54', '2020sammyadams2020@gmail.com', '3217516805', 'nn', '128300091690', 'Ahorros', 'Davivienda ', '1010058846.jpg'),
(20, 1004670974, 'Jazmin Eliana Guzman ', 'Guzman ', '2000-02-20', 'femenino', 'Santa Rosa de cabal ', 'Vereda guacas finca La mañana ', '2020susantorres2020@gmail.com', '3137090970', 'nn', '03137090970 ', 'Ahorros daviplata ', 'Davivienda ', '1004670974.jpg'),
(21, 1004670974, 'Jazmin Eliana ', 'Guzman ', '2000-02-20', 'femenino', 'pereira', 'nn', '2020susantorres2020@gmail.com', 'nn', 'nn', 'nn', 'nn', 'nn', '1004670974.jpg'),
(22, 1088037756, 'jessica alejandra  largo restrepo ', ' largo restrepo ', '1999-05-05', 'femenino', 'Dosquebradas', 'Acgua', '2020meridadrone2020@gmail.com', '3217039709', 'nn', '03127662351', 'Ahorro a la mano', 'Bancolombia', '00.jpg'),
(23, 1088284830, 'Jessica Paola Lima Monsalve', 'Lima Monsalve', '1991-01-01', 'femenino', 'pereira', 'nn', '2020sarajones2020@gmail.com', 'nn', 'nn', 'nn', 'nn', 'nn', '1088284830.jpg'),
(24, 1088354081, 'juliana bañol', 'bañol', '1999-04-17', 'femenino', 'pereira', 'NA', '2021SarahSmithGZ2021@gmail.com', '3103972112', 'nn', 'Davivienda', '3103972112', 'Daviplata ', '1088354081.png'),
(25, 1012445716, 'Kimberly Penagos Ochoa', 'Penagos Ochoa', '1997-08-04', 'femenino', 'pereira', 'nn', '2020elettralexus2020@gmail.com', 'nn', 'nn', 'nn', 'nn', 'nn', '1012445716.png'),
(26, 33965493, 'Lina Maria Mafla Garcia', 'Mafla Garcia', '1983-01-12', 'femenino', 'pereira', 'nn', '2020jessicabell2020@gmail.com', 'nn', 'nn', 'nn', 'nn', 'nn', '33965493.png'),
(27, 1099375476, 'Maria Paula Diaz Amaya ', 'Diaz Amaya ', '1998-02-13', 'femenino', 'pereira', 'nn', '2020nicolekay2020@gmail.com', 'nn', 'nn', 'nn', 'nn', 'nn', '1099375476.png'),
(28, 1059704424, 'Maryury saldarriaga pinzon', 'saldarriaga pinzon', '1992-04-10', 'femenino', 'dosquebradas ', 'peatonal9 casa 68 el progreso', '2020valeriagarcia2020@gmail.com', '3145352400', 'nn', '488412117654', 'ahorros ', 'davivienda', '1059704424.png'),
(29, 1093231014, 'Sandra Milena  Ramirez Ceaz', ' Ramirez Ceaz', '1999-12-11', 'femenino', 'pereira', 'mz 58 casa 1 barrio guayaba', '2021laurentzaecs2020@gmail.com ', '3053295503', 'nn', '85200034339', 'cuenta de ahorros', 'bancolombia', '1093231014.jpg'),
(30, 1004776248, 'Sandra Yulieth Patiño Giraldo', 'Patiño Giraldo', '1999-07-10', 'femenino', 'pereira', 'Carrera 17 bis # 17b21 Mejía Robledo ', '2020julinesmith2020@gmail.com', '3205770114', 'nn', '488417547772', 'Cuenta de ahorros ', 'Davivienda', '1004776248.png'),
(31, 1007227612, 'Stefania Villa Cano ', 'Villa Cano ', '2000-08-11', 'femenino', 'pereira', 'Barrio Guadalupe cra 36b calle 70b 29 Apto 301', '2020diamondred2020@gmail.com', '3112068057', 'nn', '488415106852', 'Ahorros ', 'DAVIVIENDA', '1007227612.png'),
(32, 1088254107, 'Flor Stefany Meneses Bolaños', 'jelith ximena cuenca meneses ', '1985-01-29', 'femenino', 'Dosquebradas ', 'Carrera 19#22-32 la pradera dosquebradas ', '2020lilygrace2020@gmail.com', '3012165098', 'nn', 'Numero de cuenta Banco: * 3012165098', 'Ahorros', 'Davivienda', '1088254107.jpg'),
(33, 100672615, 'Jelith Ximena Cuenca Meneses ', 'Cuenaca Meneses ', '2000-02-23', 'femenino', 'pereira', 'nn', '2020lilygrace2020@gmail.com', 'nn', 'nn', 'nn', 'nn', 'nn', '100672615.png'),
(34, 1088023830, 'Jenny estefanya trejos M.', 'trejos M.', '1995-02-08', 'femenino', 'Dosquebradas', 'Mz14- Cs 11B Bosques 2', 'sophiaclarkgzstudios@gmail.com', '3234043984', 'nn', '3234043984', 'Daviplata', 'Davivienda', '1088023830.jpg'),
(35, 1088037640, 'Bryan Yulian', 'Londoño Alzate', '1999-04-29', 'masculino', 'Dosquebradas', 'progreso Dosquebradas ', 'bjla.0429@gmail.com', '3212465651', 'nn', '3212465651', 'ahorros', 'daviplata', '1088037640.jpg'),
(36, 1007224433, 'Adrian', 'Muños salazar', '1998-05-11', 'masculino', 'dosquebradas ', 'progreso Dosquebradas ', 'salazar160913@gmail.com', '3234444867', 'nn', '3212465651', 'ahorros ', 'daviplata', '1007224433.jpg'),
(37, 1111111111, 'Victor Alfonso ', 'Gonzalez Guevara', '1987-10-05', 'masculino', 'pereira', 'cra 7 # 7-51 ( primer piso ) Barrio Villavicencio', 'victorgonza1328@gmail.com ', '3165888087', 'nn', '3165888087', ' ahorros ', 'davi plata', '1111111111.jpg'),
(38, 1111111111, 'Victor Alfonso ', 'Gonzalez Guevara', '1987-10-05', 'masculino', 'pereira', 'cra 7 # 7-51 ( primer piso ) Barrio Villavicencio', 'victorgonza1328@gmail.com ', '3165888087', 'nn', '3165888087', ' ahorros ', 'davi plata', '1111111111.png'),
(39, 1111111111, 'Victor Alfonso ', 'Gonzalez Guevara', '1987-10-05', 'masculino', 'pereira', 'cra 7 # 7-51 ( primer piso ) Barrio Villavicencio', 'victorgonza1328@gmail.com ', '3165888087', 'nn', '3165888087', ' ahorros ', 'davi plata', '1111111111.png'),
(40, 1088351629, 'Santiago ', 'Cruz Soto ', '1998-10-28', 'masculino', 'Dosquebradas ', 'Calle 19 # 17-10 Santa Monica ', 'Santicruz28@gmail.com', '3134409137', 'ss', '3134409137', 'Ahorros', 'Nequi', '12221223211.jpg'),
(41, 1152717274, 'Valentina Martínez', 'Martínez', '1999-12-10', 'femenino', 'Pereira', 'Cuba montelivano ', '2020samanthasex2020@gmail.com', '321 7484890', 'bn', '488417116461', 'Ahorro ', 'Davivienda', '1152717274.png'),
(42, 2000000496, '(kataleya) dannys esther ospina', 'ospina', '1956-06-02', 'femenino', 'Dosquebradas', 'carrera 16 42-27', '2021kataleya2021@gmail.com', '3183973621', 'nn', '488414566296', 'ahorro', 'davivienda', '2000000496.png'),
(43, 1095828109, 'Eldy sandid Trujillo Almeida ', 'Trujillo Almeida ', '1996-03-22', 'femenino', 'Dosquebradas', 'Cra12b-35-70 2 piso guadalule ', '2020celestegarcia2020@gmail.com', '3222187298', 'nn', '24081964907 ', 'Ahorros ', 'Caja social ', '1095828109.jpg'),
(44, 42112442, 'Francy Elena ', 'Aguirre Ramírez ', '1974-08-12', 'femenino', 'Dosquebradas ', 'Carrera 29 # 9-53 la Okarina Japón ', '2021sabrinasoul2021@gmail.com', '3217243948', 'nn', '2021sabrinasoul2021@gmail.com', 'Ahorros', 'Davivienda ', '42112442.jpg'),
(45, 42112442, 'Francy Elena  Aguirre Ramírez ', ' Aguirre Ramírez ', '1974-12-08', 'masculino', 'Dosquebradas ', 'Carrera 29 # 9-53 la Okarina Japón ', '2021sabrinasoul2021@gmail.com', '3217243948', 'nn', '0550126200096397', '42112442', 'Davivienda ', '42112442.jpg'),
(46, 1010071367, 'Faisury Dahiana  Londoño Acuña ', ' Londoño Acuña ', '1999-03-06', 'femenino', 'Dosquebradas ', 'Vela 1 Mz 2 Cs 12  Frailes ', '2021luisagutierres2021@gmail.com', '11', '11', '11', '11', '11', '1010071367.jpg'),
(47, 1002670195, 'Yuliana  Villada ', ' Villada ', '2000-03-07', 'femenino', 'Santa Rosa ', 'Portal del prado cra 9 bis 31b21', '2020melanniecooper2020@gmail.com', '3223221260', '11', '3223221260', 'Ahorros', 'Davi plata ', '1002670195.png'),
(48, 42095460, 'Rosa isel castrillon Rodriguez ', 'Rosa isel castrillon Rodriguez ', '1969-08-19', 'femenino', 'Pereira', 'Poblado 2 mz 7 cs 17', '2021greicy2021@gmail.com', '3137419989', '11', '3137419989', 'Ahorros', 'Daviplata', '42095460.jpg'),
(49, 1007824645, 'supervisor 4', 'supervisor 4', '2000-05-13', 'femenino', 'Pereira ', 'Carrera 10 # 27-56', 'supervisor4@gmail.com', '3007868930', '11', '488416147137', 'Ahorros ', 'Davivienda', '1007824645.jpg'),
(50, 1088037458, 'Kevin Alexander ', 'Ocampo Portocarrero', '1999-04-17', 'masculino', 'Dosquebradas', 'Plan 1 Casa 14 Barrio Bellavista Dosquebadas ', 'kocampo2.ko@outlook.com', '3207043445', 'NN', '488417533103', 'ahorros', 'Davivienda ', '1088037458.jpg'),
(51, 1225092387, 'Jhoan ', 'Castrillon Bedoya', '1999-04-05', 'masculino', 'Pereira', 'mz 1 cs 7 jose maria cordoba ', 'jhoancastrillon7@gmail.com', '3142937673', 'nn', '3142937673', 'ahorro a la mano', 'nequi', '1225092387.jpg'),
(52, 1088356902, 'maria isabel ramirez benitez', 'maria isabel ramirez benitez', '1999-09-17', 'femenino', '1111', '11111', '2020mirandayepez2020@gmail.com', '111111', '1111', '1111', '11111', '11111', '111.jpg'),
(53, 1004737558, 'jenny melissa ortiz holguin', 'jenny melissa ortiz holguin', '2002-12-18', 'femenino', 'dosquebradas', '111111111', '2021liajacob2021@gmail.com', '3234920227', 'nn', '111111111', '111111111', '111111111', '1004737558.jpg'),
(54, 1004738653, 'angela yulieht rendon castaño', 'angela yulieht rendon castaño', '2001-11-15', 'femenino', 'pereira', '1111', '2021marilynclark2021@gmail.com', '11111', '1111', '111111', '111111', '1111', '1004738653.jpg'),
(55, 41, 'prueba', 'pruebalo', '2021-02-03', 'masculino', 'pereira', 'call', 'fe', '222', 'de', '2121', '121', '1212', '41.png'),
(56, 1193421408, 'dahyana garcia florez', 'dahyana garcia florez', '1999-12-04', 'femenino', 'pereira', 'cra8 bis #33B-22', '2021martinagarcia2021@gmail.com', '3103850127', 'nn', '03103850127', 'ahorros', 'bancolombia', '1193421408.jpg'),
(57, 1061778293, 'KAREN BEATRIZ CHITO MUÑOZ', 'KAREN BEATRIZ CHITO MUÑOZ', '1995-02-25', 'femenino', 'pereira', '11111', '2021marilynclark2021@gmail.com', '111111', 'nn', '1111111', '1111111', '11111', '1061778293.jpg'),
(58, 26633605, 'francis lineska arocha campos', 'francis lineska arocha campos ', '0000-00-00', 'femenino', 'pereira', '11111', '2021angelicavelez2021@gmail.com', '111111', 'nn', '11111', '1111111', '11111111', '26633605.jpg'),
(59, 26026566, 'yederlyn sarais ', 'yederlyn sarais ', '1995-11-21', 'femenino', 'pereira', '11111', '2021elisa2021@gmail.com', '1111', 'nn', '111', '1111111', '11111111', '26026566.jpg'),
(60, 42031971, 'Luisa Fernanda ', 'Cardona Lalinde', '1985-01-25', 'femenino', 'Dosquebradas', 'cll20 numero 20 24', 'luisa.cardona125@hotmail.com', '3218892335', '.', '3218892335', 'Daviplata', 'Davivienda', '42031971.jpg'),
(61, 1006320131, 'isabella zapata gomez ', 'isabella zapata gomez ', '2001-11-23', 'femenino', '11111', '11111', '2021sienamontes2021@gmail.com', '11111', 'nn', '1111111', '1111111', '11111111', '1006320131.jpg'),
(62, 11111, 'supervisor 7', 'supervisor 7', '0000-00-00', 'femenino', '11111', '11111', 'supervisor7@hotmail.com', '411111', 'nn', '1111', '1111111', '11111111', '11111.jpg'),
(63, 1088342351, 'sebastian zapata', 'zapata tabares', '1997-05-07', 'masculino', 'pereira', 'calle 31 # 5-59', 'sebastian.zapata.gzstd@gmail.com', '3146704073', 'nn', '0550488414920618', 'ahorros', 'davivienda', ''),
(64, 11111, 'supervisor 8', 'supervisor 8', '0000-00-00', 'masculino', '11111', '11111', 'supervisorsatelites@gmail.com', '77777', 'nn', '111111', '1111111', '111111', '11111.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `persona_pagina`
--

CREATE TABLE `persona_pagina` (
  `id_persona_pag` int(11) NOT NULL,
  `id_pagina` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `persona_pagina`
--

INSERT INTO `persona_pagina` (`id_persona_pag`, `id_pagina`, `id_persona`, `correo`, `clave`, `estado`) VALUES
(13, 5, 18, 'modelisabella1@gmail.com', '2021gz2021', 'inactivo'),
(14, 5, 18, 'isabella1__', '2020pereira2020', 'activo'),
(15, 1, 13, '_Amy_Harper', '2021pereira2021', 'activo'),
(16, 2, 13, 'amy_harper_', 'gz5tuD12o20', 'activo'),
(17, 3, 13, 'Amy-Harper', 'Stud1055020', 'activo'),
(18, 1, 23, 'Sarah_Jonnes_', '2020pereira2020', 'activo'),
(19, 4, 14, 'issa_jones', '2021gz2021', 'inactivo'),
(20, 2, 23, 'Sarah_J0nes', 'GZStud1020', 'activo'),
(21, 3, 23, 'MarianaSanin', 'MoDelo2020', 'activo'),
(22, 4, 23, 'issa_jones', '2021gz2021', 'activo'),
(23, 4, 13, 'RomyCarter', '2020pereira2020', 'activo'),
(24, 1, 28, 'kendal_morgan', '2020pereira2020', 'activo'),
(25, 2, 28, 'Kendal_Morgan', 'GZStud102020', 'activo'),
(26, 4, 28, 'Kendra_dee', 'GZStud1020', 'activo'),
(27, 3, 28, 'KiraSky', '2020pereira2020', 'activo'),
(28, 1, 18, 'Isabella1_', '2020pereira2020', 'activo'),
(29, 4, 18, 'lana_carter', 'GZStud1020', 'activo'),
(30, 2, 18, 'Isabella18_', 'GzStudi020', 'activo'),
(31, 3, 18, 'KiraSky', '2020pereira2020', 'activo'),
(32, 1, 30, 'Juline_Smith', '2020pereira2020', 'activo'),
(33, 4, 30, 'Juline_smiith', '2020pereira2020', 'activo'),
(34, 2, 30, 'Julinne_smitth_', '2020pereira2020', 'activo'),
(35, 3, 30, 'giadasilva', 'Modelo2020', 'activo'),
(36, 1, 42, 'Katalatin_g_', '2021gz2021', 'activo'),
(37, 4, 42, 'Kataleya_G', '2021gz2021', 'activo'),
(38, 2, 42, 'Katalatin_g', '2021gz2021', 'activo'),
(39, 3, 42, 'Kataleya-g', '2021gz2021', 'activo'),
(40, 1, 19, 'sammy_adamss', '2020pereira2020', 'activo'),
(41, 4, 19, 'Sammy_adams', '2020pereira2020', 'activo'),
(42, 2, 19, 'Sammy_adams', 'GZStud102', 'activo'),
(43, 3, 19, 'sammy-adams', 'GZStud102', 'activo'),
(44, 1, 47, 'melannie_cooper', 'GZStud1020', 'activo'),
(45, 4, 47, 'melaniecopper', 'GZStud1020', 'activo'),
(46, 2, 47, 'melannie_copper', 'GZStud1020', 'activo'),
(47, 1, 27, 'Nicole_Kay', '2021pereira2021', 'activo'),
(48, 4, 27, 'Nicole_Kay', '2021gz2021', 'activo'),
(49, 2, 27, 'nicole_kay', '2021pereira2021', 'activo'),
(50, 3, 27, 'nicole-kay', '05jlH6Vx4Cq9', 'activo'),
(51, 1, 26, '_Jessica_Bell', '2021pereira2021', 'activo'),
(52, 4, 26, 'Jessicabell_', '2020pereira2020', 'activo'),
(53, 2, 26, 'Jessica_Bell', '2021pereira2021', 'activo'),
(54, 3, 26, 'Jesssicabell', 'R70iGV70nwap', 'activo'),
(55, 1, 17, 'Mackenzie_Monroe', '2020pereira2020', 'inactivo'),
(56, 1, 17, '_Sara_Jay', 'GZStud1020', 'activo'),
(57, 4, 17, 'Saraa_Jay', 'GZStud1020', 'activo'),
(58, 2, 17, '_Sara_jay', 'GZStud1020', 'activo'),
(59, 3, 17, 'Sara-Jaay', 'DZAJWjnRSe9s', 'activo'),
(60, 1, 16, 'Margaretcruz', '2020pereira2020', 'activo'),
(61, 4, 16, 'Margaret_cruz', '2020pereira2020', 'activo'),
(62, 2, 16, 'Margaret_cruz', '2020pereira2020', 'activo'),
(63, 3, 16, 'April-johnson', '59oQRPjEFM04', 'activo'),
(64, 1, 41, 'Mackenzie_monroe', '2020pereira2020', 'activo'),
(65, 4, 41, 'MackenzieM_', 'GZStud1020', 'activo'),
(66, 2, 41, 'MackenzieMonroe', '2021gz2021', 'activo'),
(67, 3, 41, 'Sammantha-sex', 'UPC3oBfCEGHO', 'activo'),
(68, 1, 14, 'Clara_Fiore', 'GZStud1020', 'activo'),
(69, 4, 14, 'Clarafiore', 'GZStud1020', 'activo'),
(70, 2, 14, 'Clara_fiore', 'GZStud1020', 'activo'),
(71, 3, 14, 'Clara-fiore', 'Uvo7K8mXdqAw', 'activo'),
(72, 1, 22, 'Merida_Drone', 'GZstudios2020', 'activo'),
(73, 2, 22, 'Merida_Drone', '2021pereira2021', 'activo'),
(74, 1, 24, 'sarah_smithh_', '1088354081jb', 'activo'),
(75, 4, 24, 'Sarah_Smithh_', '2019pereira2019', 'activo'),
(76, 3, 24, 'SarahSmithh', 'GZP3r31r4Stud', 'activo'),
(77, 1, 29, 'Laurent_zaecs', '2021pereira2021', 'activo'),
(78, 2, 29, 'Laurent_zaecs', '2021pereira2021', 'activo'),
(79, 3, 29, 'KataMartinez', 'NQcx7mFnWM', 'activo'),
(80, 1, 15, 'Karla_scoth_', '2020pereira2020', 'activo'),
(81, 3, 15, 'Californiastar', 'mODELO2021', 'activo'),
(82, 1, 48, 'Greicy_1', '2021GZ2021', 'activo'),
(83, 1, 52, 'Miranda_1', 'turno3victor', 'activo'),
(84, 4, 52, 'Miranda_12', 'turno3victor', 'activo'),
(85, 2, 52, 'Miranda_12', 'turno3victor', 'activo'),
(86, 1, 43, 'Celestegarcia_1', '2021pereira2021', 'activo'),
(87, 2, 43, 'Celestegarciaa', 'GZStud1020', 'activo'),
(88, 3, 43, 'Celestegarcia-1', 'NdgZC2wSPU', 'activo'),
(89, 1, 20, 'Susan_torres', 'GZstudio2020', 'activo'),
(90, 2, 20, 'Susan_torres_', 'GZStud1020', 'activo'),
(91, 3, 20, 'Susan-torres', 'zfdGAA9SEyLn', 'activo'),
(92, 1, 45, 'Sabrina_soul', '2021gz2021', 'activo'),
(93, 2, 45, 'Sabrina_soul_', '2021gz2021', 'activo'),
(94, 1, 34, 'Sophiaclark_1', '2020pereira2020', 'activo'),
(95, 1, 25, 'elettra_lexus', 'GZStud1020', 'activo'),
(96, 4, 25, 'elettra_lexus', 'GZStud1020', 'activo'),
(97, 2, 25, 'elettra_lexus', 'GZStud1020', 'activo'),
(98, 3, 25, 'elettra-lexus', 'GZStud1020', 'activo'),
(99, 1, 31, '_diamond_red', '2021pereira2021', 'activo'),
(100, 4, 31, 'diamond_reds', 'GZStud1020', 'activo'),
(101, 2, 31, 'diamond_reds', 'GZStud1020', 'activo'),
(102, 3, 31, 'diamond-red', 'GZStud1020', 'activo'),
(103, 3, 48, '2021greicy2021@Gmail.Com', '2021gz2021', 'activo'),
(104, 1, 53, '2021liajacob2021@gmail.com', '2021gz2021', 'activo'),
(105, 2, 53, '2021liajacob2021@gmail.com', '2021gz2021', 'activo'),
(106, 1, 32, '2020lilygrace2020@Gmail.Com', '2021gz2021', 'activo'),
(107, 2, 32, '2020lilygrace2020@Gmail.Com', '2021gz2021', 'activo'),
(108, 3, 32, '2020lilygrace2020@Gmail.Com', '2021gz2021', 'activo'),
(109, 1, 33, '2020lilygrace2020@Gmail.Com', '2021gz2021', 'activo'),
(110, 2, 33, '2020lilygrace2020@Gmail.Com', '2021gz2021', 'activo'),
(111, 3, 33, '2020lilygrace2020@Gmail.Com', '2021gz2021', 'activo');

-- --------------------------------------------------------

--
-- Table structure for table `porcentajes_dias`
--

CREATE TABLE `porcentajes_dias` (
  `id_porcentajes_dias` int(11) NOT NULL,
  `cantidad_dias` int(11) NOT NULL,
  `estado_meta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `valor` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `porcentajes_dias`
--

INSERT INTO `porcentajes_dias` (`id_porcentajes_dias`, `cantidad_dias`, `estado_meta`, `valor`, `fecha_registro`, `estado`) VALUES
(11, 11, 'completa', 30, '2020-11-30 02:16:38', 'inactivo'),
(12, 11, 'incompleta', 30, '2020-11-30 02:17:06', 'activo'),
(13, 10, 'incompleta', 45, '2020-11-30 14:08:46', 'activo'),
(14, 10, 'completa', 50, '2020-11-30 14:08:59', 'activo'),
(15, 11, 'completa', 45, '2020-11-30 20:06:50', 'activo'),
(16, 1, 'completa', 20, '2020-12-18 14:21:51', 'activo'),
(17, 1, 'incompleta', 15, '2020-12-18 14:22:05', 'activo');

-- --------------------------------------------------------

--
-- Table structure for table `registro_horas`
--

CREATE TABLE `registro_horas` (
  `id_registro_horas` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_supervisor` int(11) NOT NULL,
  `id_pagina` int(11) NOT NULL,
  `cantidad_horas` int(11) NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `id_factura` int(11) DEFAULT NULL,
  `estado_registro` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `registro_horas`
--

INSERT INTO `registro_horas` (`id_registro_horas`, `id_empleado`, `id_supervisor`, `id_pagina`, `cantidad_horas`, `descripcion`, `fecha_registro`, `id_factura`, `estado_registro`) VALUES
(62, 28, 35, 1, 1903, 'CB', '2021-02-01', NULL, 'sin registrar'),
(63, 28, 35, 2, 80, 'SC', '2021-02-01', NULL, 'sin registrar'),
(64, 28, 35, 4, 105, 'MFC', '2021-02-01', NULL, 'sin registrar'),
(65, 28, 35, 3, 530, 'CS', '2021-02-01', NULL, 'sin registrar'),
(66, 29, 35, 2, 5, 'SC', '2021-02-01', NULL, 'sin registrar'),
(67, 29, 35, 3, 331, 'CS', '2021-02-01', NULL, 'sin registrar'),
(68, 18, 35, 1, 1596, 'CB', '2021-02-01', NULL, 'sin registrar'),
(69, 18, 35, 2, 752, 'SC', '2021-02-01', NULL, 'sin registrar'),
(70, 18, 35, 4, 143, 'MFC', '2021-02-01', NULL, 'sin registrar'),
(71, 18, 35, 3, 509, 'CS', '2021-02-01', NULL, 'sin registrar'),
(72, 31, 50, 1, 1147, 'Room 04', '2021-02-01', NULL, 'sin registrar'),
(73, 31, 50, 2, 6, 'room 04', '2021-02-01', NULL, 'sin registrar'),
(74, 31, 50, 4, 80, 'room 04', '2021-02-01', NULL, 'sin registrar'),
(75, 41, 50, 1, 144, 'room 05', '2021-02-01', NULL, 'sin registrar'),
(76, 41, 50, 2, 27, 'room 05', '2021-02-01', NULL, 'sin registrar'),
(77, 48, 50, 1, 165, 'room 01', '2021-02-01', NULL, 'sin registrar'),
(78, 48, 50, 3, 393, 'room 01', '2021-02-01', NULL, 'sin registrar'),
(79, 53, 36, 1, 1204, 'Room 10', '2021-02-02', NULL, 'sin registrar'),
(80, 53, 36, 2, 1873, 'Room 10', '2021-02-02', NULL, 'sin registrar'),
(81, 43, 36, 1, 34, 'Room 2', '2021-02-01', NULL, 'sin registrar'),
(82, 43, 36, 2, 4, 'Room 2', '2021-02-02', NULL, 'sin registrar'),
(83, 43, 36, 3, 49, 'Room 2', '2021-02-02', NULL, 'sin registrar'),
(84, 48, 50, 1, 620, 'room 01', '2021-02-02', NULL, 'sin registrar'),
(85, 26, 36, 1, 2, 'Room 9', '2021-02-02', NULL, 'sin registrar'),
(86, 48, 50, 3, 514, 'room 01', '2021-02-02', NULL, 'sin registrar'),
(87, 26, 36, 2, 144, 'Room 9', '2021-02-02', NULL, 'sin registrar'),
(88, 26, 36, 4, 40, 'Room 9', '2021-02-02', NULL, 'sin registrar'),
(89, 16, 36, 2, 5, 'Room 7', '2021-02-02', NULL, 'sin registrar'),
(90, 32, 50, 1, 596, 'Hermanas meneses', '2021-02-02', NULL, 'sin registrar'),
(91, 33, 50, 1, 596, 'hermanas meneses room 06', '2021-02-02', NULL, 'sin registrar'),
(92, 20, 36, 1, 1088, 'Room 10', '2021-02-02', NULL, 'sin registrar'),
(93, 32, 50, 2, 421, 'hermanas meneses room 06', '2021-02-02', NULL, 'sin registrar'),
(94, 20, 36, 2, 570, 'Room 10', '2021-02-02', NULL, 'sin registrar'),
(95, 33, 50, 2, 421, 'hermanas meneses room 06', '2021-02-02', NULL, 'sin registrar'),
(96, 14, 36, 1, 1102, 'Room 8', '2021-02-02', NULL, 'sin registrar'),
(97, 32, 50, 3, 248, 'hermanas meneses room 06', '2021-02-02', NULL, 'sin registrar'),
(98, 14, 36, 2, 362, 'Room 8', '2021-02-02', NULL, 'sin registrar'),
(99, 33, 50, 3, 248, 'hermanas meneses room 06', '2021-02-02', NULL, 'sin registrar'),
(100, 31, 50, 1, 1498, 'room 04', '2021-02-02', NULL, 'sin registrar'),
(101, 41, 50, 1, 943, 'room 05', '2021-02-02', NULL, 'sin registrar'),
(102, 41, 50, 4, 115, 'room 05', '2021-02-02', NULL, 'sin registrar'),
(103, 29, 35, 3, 7, 'CS', '2021-02-02', NULL, 'sin registrar'),
(104, 28, 35, 1, 6, 'CB', '2021-02-02', NULL, 'sin registrar'),
(105, 28, 35, 3, 507, 'CS', '2021-02-02', NULL, 'sin registrar'),
(106, 28, 35, 2, 157, 'SC', '2021-02-02', NULL, 'sin registrar'),
(107, 28, 35, 4, 58, 'MFC', '2021-02-02', NULL, 'sin registrar'),
(108, 28, 35, 1, 734, 'CB', '2021-02-02', NULL, 'sin registrar'),
(109, 18, 35, 2, 857, 'SC', '2021-02-02', NULL, 'sin registrar'),
(110, 18, 35, 4, 264, 'MFC', '2021-02-02', NULL, 'sin registrar'),
(111, 18, 35, 3, 850, 'CS', '2021-02-02', NULL, 'sin registrar'),
(112, 42, 35, 1, 10, 'CB', '2021-02-02', NULL, 'sin registrar'),
(113, 42, 35, 2, 102, 'SC', '2021-02-02', NULL, 'sin registrar'),
(114, 42, 35, 4, 110, 'MFC', '2021-02-02', NULL, 'sin registrar'),
(115, 42, 35, 3, 623, 'CS', '2021-02-02', NULL, 'sin registrar'),
(116, 48, 50, 1, 174, 'Room 01', '2021-02-03', NULL, 'sin registrar'),
(117, 48, 50, 3, 511, 'room 01', '2021-02-03', NULL, 'sin registrar'),
(118, 31, 50, 1, 1418, 'room 04', '2021-02-03', NULL, 'sin registrar'),
(119, 14, 36, 1, 1377, 'Room 8', '2021-02-03', NULL, 'sin registrar'),
(120, 14, 36, 2, 30, 'Room 8', '2021-02-03', NULL, 'sin registrar'),
(121, 20, 36, 1, 1485, 'Room 9', '2021-02-03', NULL, 'sin registrar'),
(122, 20, 36, 2, 349, 'Room 9', '2021-02-03', NULL, 'sin registrar'),
(123, 32, 50, 1, 904, 'hermanas meneses room 06', '2021-02-03', NULL, 'sin registrar'),
(124, 33, 50, 1, 904, 'hermanas meneses room 06', '2021-02-03', NULL, 'sin registrar'),
(125, 53, 36, 1, 456, 'Room 10', '2021-02-03', NULL, 'sin registrar'),
(126, 32, 50, 2, 33, 'hermanas menese room 06', '2021-02-03', NULL, 'sin registrar'),
(127, 33, 50, 2, 33, 'hermanas meneses room 06', '2021-02-03', NULL, 'sin registrar'),
(128, 53, 36, 2, 962, 'Room 10', '2021-02-03', NULL, 'sin registrar'),
(129, 32, 50, 3, 354, 'hermanas meneses room 06', '2021-02-03', NULL, 'sin registrar'),
(130, 33, 50, 3, 354, 'hermanas meneses room 06', '2021-02-03', NULL, 'sin registrar'),
(131, 16, 36, 2, 954, 'Room 7', '2021-02-03', NULL, 'sin registrar'),
(132, 41, 50, 1, 1182, 'room 05', '2021-02-03', NULL, 'sin registrar'),
(133, 41, 50, 2, 1, 'room 05', '2021-02-03', NULL, 'sin registrar'),
(134, 41, 50, 4, 164, 'room 05', '2021-02-03', NULL, 'sin registrar'),
(135, 43, 36, 1, 372, 'Room 2', '2021-02-03', NULL, 'sin registrar'),
(136, 43, 36, 2, 768, 'Room 2 ', '2021-02-03', NULL, 'sin registrar'),
(137, 43, 36, 3, 169, 'Room 2', '2021-02-03', NULL, 'sin registrar'),
(138, 29, 35, 1, 78, 'CB', '2021-02-03', NULL, 'sin registrar'),
(139, 18, 35, 1, 367, 'c', '2021-02-03', NULL, 'sin registrar'),
(140, 18, 35, 2, 1399, 's', '2021-02-03', NULL, 'sin registrar'),
(141, 18, 35, 3, 238, 'c', '2021-02-03', NULL, 'sin registrar'),
(142, 18, 35, 4, 72, 'm', '2021-02-03', NULL, 'sin registrar'),
(143, 28, 35, 1, 2747, 'c', '2021-02-03', NULL, 'sin registrar'),
(144, 28, 35, 2, 7, 's', '2021-02-03', NULL, 'sin registrar'),
(145, 28, 35, 4, 121, 'm', '2021-02-03', NULL, 'sin registrar'),
(146, 42, 35, 1, 88, 'c', '2021-02-03', NULL, 'sin registrar'),
(147, 42, 35, 2, 1565, 'sc', '2021-02-03', NULL, 'sin registrar'),
(148, 42, 35, 3, 776, 'cs', '2021-02-03', NULL, 'sin registrar'),
(149, 13, 37, 1, 27, '.', '2021-02-02', NULL, 'sin registrar'),
(150, 27, 37, 1, 349, '.', '2021-02-02', NULL, 'sin registrar'),
(151, 47, 37, 1, 1, '.', '2021-02-01', NULL, 'sin registrar'),
(152, 47, 37, 1, 5, '.', '2021-02-02', NULL, 'sin registrar'),
(153, 23, 37, 1, 894, '.', '2021-02-02', NULL, 'sin registrar'),
(154, 13, 37, 3, 3, '.', '2021-02-02', NULL, 'sin registrar'),
(155, 27, 37, 2, 4, '.', '2021-02-02', NULL, 'sin registrar'),
(156, 47, 37, 1, 110, '.', '2021-02-03', NULL, 'sin registrar'),
(157, 47, 37, 2, 18, '.', '2021-02-03', NULL, 'sin registrar'),
(158, 23, 37, 2, 7, '.', '2021-02-01', NULL, 'sin registrar'),
(159, 23, 37, 2, 551, '.', '2021-02-02', NULL, 'sin registrar'),
(160, 23, 37, 2, 551, '.', '2021-02-02', NULL, 'sin registrar'),
(161, 23, 37, 1, 223, '.', '2021-02-01', NULL, 'sin registrar'),
(162, 23, 37, 4, 31, '.', '2021-02-02', NULL, 'sin registrar'),
(163, 23, 37, 4, 285, '.', '2021-02-03', NULL, 'sin registrar'),
(164, 23, 37, 1, 365, '.', '2021-02-03', NULL, 'sin registrar'),
(165, 23, 37, 2, 10, '.', '2021-02-03', NULL, 'sin registrar'),
(166, 47, 37, 1, 110, '.', '2021-02-03', NULL, 'sin registrar'),
(167, 47, 37, 2, 18, '.', '2021-02-03', NULL, 'sin registrar'),
(168, 13, 37, 4, 138, '.', '2021-02-03', NULL, 'sin registrar'),
(169, 13, 37, 1, 73, '.', '2021-02-03', NULL, 'sin registrar'),
(170, 13, 37, 2, 3, '.', '2021-02-03', NULL, 'sin registrar'),
(171, 13, 37, 3, 3, '.', '2021-02-03', NULL, 'sin registrar'),
(172, 27, 37, 2, 4, '.', '2021-02-03', NULL, 'sin registrar'),
(173, 27, 37, 3, 82, '.', '2021-02-03', NULL, 'sin registrar'),
(174, 48, 50, 1, 378, 'room 01', '2021-02-04', NULL, 'sin registrar'),
(175, 48, 50, 3, 1270, 'room 01', '2021-02-04', NULL, 'sin registrar'),
(176, 41, 50, 1, 18, 'room 05', '2021-02-04', NULL, 'sin registrar'),
(177, 41, 50, 4, 2, 'room 05', '2021-02-04', NULL, 'sin registrar'),
(178, 31, 50, 1, 983, 'room 04', '2021-02-04', NULL, 'sin registrar'),
(179, 32, 50, 1, 23, 'hermanas meneses room 06', '2021-02-04', NULL, 'sin registrar'),
(180, 33, 50, 1, 23, 'hermanas meneses room 06', '2021-02-04', NULL, 'sin registrar'),
(181, 32, 50, 2, 251, 'hermanas meneses room 06', '2021-02-04', NULL, 'sin registrar'),
(182, 33, 50, 2, 251, 'hermanas meneses room 06', '2021-02-04', NULL, 'sin registrar'),
(183, 32, 50, 3, 185, 'hermanas meneses room 06', '2021-02-04', NULL, 'sin registrar'),
(184, 33, 50, 3, 185, 'hermanas meneses room 06', '2021-02-04', NULL, 'sin registrar'),
(185, 18, 35, 1, 536, 'CB', '2021-02-04', NULL, 'sin registrar'),
(186, 18, 35, 2, 1206, 'SC', '2021-02-04', NULL, 'sin registrar'),
(187, 18, 35, 3, 526, 'CS', '2021-02-04', NULL, 'sin registrar'),
(188, 18, 35, 4, 32, 'MFC', '2021-02-04', NULL, 'sin registrar'),
(189, 28, 35, 1, 668, 'CB', '2021-02-04', NULL, 'sin registrar'),
(190, 28, 35, 2, 261, 'SC', '2021-02-04', NULL, 'sin registrar'),
(191, 28, 35, 4, 566, 'MFC', '2021-02-04', NULL, 'sin registrar'),
(192, 28, 35, 3, 127, 'CS', '2021-02-04', NULL, 'sin registrar'),
(193, 28, 35, 3, 179, 'CS', '2021-02-04', NULL, 'sin registrar'),
(194, 42, 35, 1, 197, 'CB', '2021-02-04', NULL, 'sin registrar'),
(195, 42, 35, 2, 179, 'SC', '2021-02-04', NULL, 'sin registrar'),
(196, 42, 35, 3, 39, 'CS', '2021-02-04', NULL, 'sin registrar'),
(197, 29, 35, 1, 128, 'CB', '2021-02-04', NULL, 'sin registrar'),
(198, 29, 35, 2, 39, 'SC', '2021-02-04', NULL, 'sin registrar'),
(199, 29, 35, 3, 4, 'CS', '2021-02-04', NULL, 'sin registrar'),
(200, 22, 37, 1, 235, '.', '2021-02-01', NULL, 'sin registrar'),
(201, 22, 37, 1, 148, '.', '2021-02-02', NULL, 'sin registrar'),
(202, 22, 37, 1, 988, '.', '2021-02-03', NULL, 'sin registrar'),
(203, 22, 37, 1, 552, '.', '2021-02-04', NULL, 'sin registrar'),
(204, 22, 37, 2, 41, '.', '2021-02-01', NULL, 'sin registrar'),
(205, 22, 37, 2, 160, '.', '2021-02-02', NULL, 'sin registrar'),
(206, 22, 37, 2, 79, '.', '2021-02-03', NULL, 'sin registrar'),
(207, 22, 37, 2, 26, '.', '2021-02-04', NULL, 'sin registrar'),
(208, 22, 37, 2, 26, '.', '2021-02-04', NULL, 'sin registrar'),
(209, 17, 37, 1, 216, '.', '2021-02-02', NULL, 'sin registrar'),
(210, 17, 37, 1, 1, '.', '2021-02-03', NULL, 'sin registrar'),
(211, 17, 37, 1, 1, '.', '2021-02-03', NULL, 'sin registrar'),
(212, 17, 37, 1, 153, '.', '2021-02-04', NULL, 'sin registrar'),
(213, 17, 37, 2, 192, '.', '2021-02-02', NULL, 'sin registrar'),
(214, 17, 37, 2, 32, '.', '2021-02-03', NULL, 'sin registrar'),
(215, 17, 37, 2, 32, '.', '2021-02-03', NULL, 'sin registrar'),
(216, 17, 37, 2, 232, '.', '2021-02-04', NULL, 'sin registrar'),
(217, 17, 37, 3, 2, '.', '2021-02-03', NULL, 'sin registrar'),
(218, 17, 37, 3, 238, '.', '2021-02-04', NULL, 'sin registrar'),
(219, 17, 37, 4, 129, '.', '2021-02-02', NULL, 'sin registrar'),
(220, 23, 37, 1, 153, '.', '2021-02-04', NULL, 'sin registrar'),
(221, 23, 37, 1, 153, '.', '2021-02-04', NULL, 'sin registrar'),
(222, 17, 37, 3, 238, '.', '2021-02-04', NULL, 'sin registrar'),
(223, 17, 37, 4, 24, '.', '2021-02-04', NULL, 'sin registrar'),
(224, 17, 37, 2, 232, '.', '2021-02-04', NULL, 'sin registrar'),
(225, 27, 37, 1, 2521, '.', '2021-02-04', NULL, 'sin registrar'),
(226, 27, 37, 3, 336, '.', '2021-02-04', NULL, 'sin registrar'),
(227, 27, 37, 2, 13, '.', '2021-02-04', NULL, 'sin registrar'),
(228, 13, 37, 1, 72, '.', '2021-02-04', NULL, 'sin registrar'),
(229, 13, 37, 4, 71, '.', '2021-02-04', NULL, 'sin registrar'),
(230, 13, 37, 3, 165, '.', '2021-02-04', NULL, 'sin registrar'),
(231, 13, 37, 2, 2, '.', '2021-02-04', NULL, 'sin registrar'),
(232, 47, 37, 1, 558, '.', '2021-02-04', NULL, 'sin registrar'),
(233, 47, 37, 2, 36, '.', '2021-02-04', NULL, 'sin registrar'),
(234, 23, 37, 2, 192, '.', '2021-02-02', NULL, 'sin registrar'),
(235, 31, 50, 1, 1685, 'room 04', '2021-02-05', NULL, 'sin registrar'),
(236, 48, 50, 1, 396, 'room 01', '2021-02-05', NULL, 'sin registrar'),
(237, 48, 50, 3, 463, 'room 01', '2021-02-05', NULL, 'sin registrar'),
(238, 41, 50, 1, 339, 'room 05', '2021-02-05', NULL, 'sin registrar'),
(239, 33, 50, 1, 299, 'hermanas meneses room 06', '2021-02-05', NULL, 'sin registrar'),
(240, 32, 50, 1, 598, 'hermanas meneses room 06', '2021-02-05', NULL, 'sin registrar'),
(241, 32, 50, 2, 29, 'hermanas meneses romm 06', '2021-02-05', NULL, 'sin registrar'),
(242, 32, 50, 3, 581, 'hermanas meneses room 06', '2021-02-05', NULL, 'sin registrar'),
(243, 20, 36, 1, 1345, 'Room 10', '2021-02-05', NULL, 'sin registrar'),
(244, 20, 36, 2, 155, 'Room 10', '2021-02-05', NULL, 'sin registrar'),
(245, 14, 36, 1, 103, 'Room 8', '2021-02-05', NULL, 'sin registrar'),
(246, 14, 36, 2, 273, 'Room 8', '2021-02-05', NULL, 'sin registrar'),
(247, 14, 36, 4, 24, 'Room 8', '2021-02-05', NULL, 'sin registrar'),
(248, 16, 36, 2, 636, 'Room 7', '2021-02-05', NULL, 'sin registrar'),
(249, 29, 35, 1, 334, 'CB', '2021-02-05', NULL, 'sin registrar'),
(250, 29, 35, 3, 52, 'CS', '2021-02-05', NULL, 'sin registrar'),
(251, 29, 35, 2, 5, 'SC', '2021-02-05', NULL, 'sin registrar'),
(252, 42, 35, 1, 6, 'CB', '2021-02-05', NULL, 'sin registrar'),
(253, 42, 35, 2, 115, 'SC', '2021-02-05', NULL, 'sin registrar'),
(254, 42, 35, 3, 113, 'CS', '2021-02-05', NULL, 'sin registrar'),
(255, 28, 35, 1, 19, 'CB', '2021-02-05', NULL, 'sin registrar'),
(256, 18, 35, 1, 102, 'CB', '2021-02-05', NULL, 'sin registrar'),
(257, 18, 35, 1, 1091, 'CB', '2021-02-05', NULL, 'sin registrar'),
(258, 18, 35, 2, 1756, 'SC', '2021-02-05', NULL, 'sin registrar'),
(259, 18, 35, 3, 322, 'CS', '2021-02-05', NULL, 'sin registrar'),
(260, 18, 35, 4, 465, 'MFC', '2021-02-05', NULL, 'sin registrar'),
(261, 47, 37, 1, 1549, '.', '2021-02-05', NULL, 'sin registrar'),
(262, 47, 37, 2, 249, '.', '2021-02-05', NULL, 'sin registrar'),
(263, 22, 37, 1, 622, '.', '2021-02-05', NULL, 'sin registrar'),
(264, 17, 37, 2, 41, '.', '2021-02-05', NULL, 'sin registrar'),
(265, 17, 37, 4, 116, '.', '2021-02-05', NULL, 'sin registrar'),
(266, 17, 37, 3, 228, '.', '2021-02-05', NULL, 'sin registrar'),
(267, 17, 37, 1, 276, '.', '2021-02-05', NULL, 'sin registrar'),
(268, 13, 37, 4, 6, '.', '2021-02-05', NULL, 'sin registrar'),
(269, 13, 37, 1, 85, '.', '2021-02-05', NULL, 'sin registrar'),
(270, 13, 37, 2, 3, '.', '2021-02-05', NULL, 'sin registrar'),
(271, 13, 37, 3, 43, '.', '2021-02-05', NULL, 'sin registrar'),
(272, 27, 37, 1, 104, '.', '2021-02-05', NULL, 'sin registrar'),
(273, 43, 36, 2, 128, 'Room 2', '2021-02-05', NULL, 'sin registrar'),
(274, 43, 36, 3, 64, 'Room 2', '2021-02-05', NULL, 'sin registrar'),
(275, 41, 50, 1, 29, 'ROOM 05', '2021-02-06', NULL, 'sin registrar'),
(276, 48, 50, 1, 90, 'room 01', '2021-02-06', NULL, 'sin registrar'),
(277, 48, 50, 3, 349, 'room 01', '2021-02-06', NULL, 'sin registrar'),
(278, 43, 36, 1, 530, 'Room 2', '2021-02-05', NULL, 'sin registrar'),
(279, 32, 50, 1, 760, 'hermanas meneses room 06', '2021-02-06', NULL, 'sin registrar'),
(280, 32, 50, 2, 456, 'hermanas meneses room 06', '2021-02-06', NULL, 'sin registrar'),
(281, 20, 36, 1, 1557, 'Room 10', '2021-02-06', NULL, 'sin registrar'),
(282, 32, 50, 3, 137, 'hermanas meneses room 06', '2021-02-06', NULL, 'sin registrar'),
(283, 16, 36, 2, 21, 'Room 10', '2021-02-06', NULL, 'sin registrar'),
(284, 26, 36, 2, 259, 'Room 9', '2021-02-06', NULL, 'sin registrar'),
(285, 26, 36, 4, 20, 'Room 9', '2021-02-06', NULL, 'sin registrar'),
(286, 31, 50, 1, 1062, 'room 04', '2021-02-06', NULL, 'sin registrar'),
(287, 26, 36, 1, 57, 'Room 9', '2021-02-06', NULL, 'sin registrar'),
(288, 31, 50, 4, 325, 'Room 04', '2021-02-06', NULL, 'sin registrar'),
(289, 16, 36, 2, 156, 'Room 7', '2021-02-06', NULL, 'sin registrar'),
(290, 14, 36, 1, 232, 'Room 8', '2021-02-06', NULL, 'sin registrar'),
(291, 14, 36, 2, 308, 'Room 8 ', '2021-02-06', NULL, 'sin registrar'),
(292, 14, 36, 4, 54, 'Room 8', '2021-02-06', NULL, 'sin registrar'),
(293, 53, 36, 1, 465, 'Room 10', '2021-02-06', NULL, 'sin registrar'),
(294, 53, 36, 2, 1272, 'Room 10', '2021-02-06', NULL, 'sin registrar'),
(295, 28, 35, 1, 501, 'CB', '2021-02-06', NULL, 'sin registrar'),
(296, 28, 35, 2, 180, 'SC', '2021-02-06', NULL, 'sin registrar'),
(297, 28, 35, 4, 335, 'MFC', '2021-02-06', NULL, 'sin registrar'),
(298, 28, 35, 3, 7, 'cs', '2021-02-06', NULL, 'sin registrar'),
(299, 42, 35, 1, 339, 'cb', '2021-02-06', NULL, 'sin registrar'),
(300, 42, 35, 2, 77, 'sc', '2021-02-06', NULL, 'sin registrar'),
(301, 42, 35, 3, 1114, 'cs', '2021-02-06', NULL, 'sin registrar'),
(302, 47, 37, 2, 27, '.', '2021-02-06', NULL, 'sin registrar'),
(303, 47, 37, 1, 1005, '.', '2021-02-06', NULL, 'sin registrar'),
(304, 13, 37, 3, 43, '.', '2021-02-06', NULL, 'sin registrar'),
(305, 27, 37, 3, 357, '.', '2021-02-06', NULL, 'sin registrar'),
(306, 22, 37, 1, 811, '.', '2021-02-06', NULL, 'sin registrar'),
(307, 27, 37, 2, 95, '.', '2021-02-06', NULL, 'sin registrar'),
(308, 17, 37, 1, 1532, '.', '2021-02-06', NULL, 'sin registrar'),
(309, 17, 37, 2, 172, '.', '2021-02-06', NULL, 'sin registrar'),
(310, 17, 37, 3, 565, '.', '2021-02-06', NULL, 'sin registrar'),
(311, 23, 37, 4, 1, '.', '2021-02-06', NULL, 'sin registrar'),
(312, 23, 37, 2, 58, '.', '2021-02-07', NULL, 'sin registrar'),
(313, 17, 37, 4, 101, '.', '2021-02-07', NULL, 'sin registrar'),
(314, 23, 37, 3, 118, '.', '2021-02-07', NULL, 'sin registrar'),
(315, 17, 37, 1, 100, '.', '2021-02-07', NULL, 'sin registrar'),
(316, 53, 36, 1, 33, 'Room 10', '2021-02-01', NULL, 'sin registrar'),
(317, 53, 36, 2, 362, 'Room 10', '2021-02-01', NULL, 'sin registrar'),
(318, 53, 36, 1, 1293, 'Room 10', '2021-02-04', NULL, 'sin registrar'),
(319, 53, 36, 2, 771, 'Room 10', '2021-02-04', NULL, 'sin registrar'),
(320, 53, 36, 1, 301, 'Room 10', '2021-02-05', NULL, 'sin registrar'),
(321, 53, 36, 2, 556, 'Room 10', '2021-02-05', NULL, 'sin registrar'),
(322, 43, 36, 1, 372, 'Room 2', '2021-02-04', NULL, 'sin registrar'),
(323, 43, 36, 2, 40, 'Room 2', '2021-02-04', NULL, 'sin registrar'),
(324, 43, 36, 3, 4, 'Room 2', '2021-02-04', NULL, 'sin registrar'),
(325, 43, 36, 1, 0, 'Room 2', '2021-02-06', NULL, 'sin registrar'),
(326, 26, 36, 1, 0, 'Room 9', '2021-02-01', NULL, 'sin registrar'),
(327, 26, 36, 2, 494, 'Room 9', '2021-02-01', NULL, 'sin registrar'),
(328, 26, 36, 4, 10, 'Room 9', '2021-02-01', NULL, 'sin registrar'),
(329, 26, 36, 2, 50, 'Tokens Offline ', '2021-02-03', NULL, 'sin registrar'),
(330, 26, 36, 2, 42, 'Room 9', '2021-02-04', NULL, 'sin registrar'),
(331, 26, 36, 4, 4, 'Room 10', '2021-02-04', NULL, 'sin registrar'),
(332, 20, 36, 1, 320, 'Room 11', '2021-02-01', NULL, 'sin registrar'),
(333, 20, 36, 2, 772, 'Room 11', '2021-02-01', NULL, 'sin registrar'),
(334, 14, 36, 2, 555, 'Room 8', '2021-02-01', NULL, 'sin registrar'),
(335, 14, 36, 4, 259, 'Room 8', '2021-02-01', NULL, 'sin registrar'),
(336, 41, 50, 1, 531, 'room 05', '2021-02-08', NULL, 'sin registrar'),
(337, 20, 36, 1, 57, 'Room 11', '2021-02-08', NULL, 'sin registrar'),
(338, 41, 50, 4, 19, 'room 05', '2021-02-08', NULL, 'sin registrar'),
(339, 20, 36, 2, 213, 'Room 11', '2021-02-08', NULL, 'sin registrar'),
(340, 26, 36, 1, 11, 'Room 9', '2021-02-08', NULL, 'sin registrar'),
(341, 26, 36, 2, 278, 'Room 9', '2021-02-08', NULL, 'sin registrar'),
(342, 26, 36, 4, 67, 'Room 9', '2021-02-08', NULL, 'sin registrar'),
(343, 31, 50, 1, 648, 'room 04', '2021-02-08', NULL, 'sin registrar'),
(344, 31, 50, 4, 370, 'room 04', '2021-02-08', NULL, 'sin registrar'),
(345, 48, 50, 1, 445, 'room 01', '2021-02-08', NULL, 'sin registrar'),
(346, 15, 36, 1, 48, 'Room 2 ( Stripchat ) ', '2021-02-08', NULL, 'sin registrar'),
(347, 48, 50, 3, 249, 'room 01', '2021-02-08', NULL, 'sin registrar'),
(348, 15, 36, 3, 399, 'Room 2 ( Myfree ) ', '2021-02-08', NULL, 'sin registrar'),
(349, 14, 36, 1, 3, 'Room 8', '2021-02-08', NULL, 'sin registrar'),
(350, 14, 36, 2, 334, 'Room 8', '2021-02-08', NULL, 'sin registrar'),
(351, 14, 36, 4, 55, 'Room 8', '2021-02-08', NULL, 'sin registrar'),
(352, 53, 36, 1, 723, 'Room 10', '2021-02-08', NULL, 'sin registrar'),
(353, 53, 36, 2, 978, 'Room 10', '2021-02-08', NULL, 'sin registrar');

-- --------------------------------------------------------

--
-- Table structure for table `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `reportes`
--

INSERT INTO `reportes` (`id_reporte`, `id_tecnico`, `descripcion`, `fecha`) VALUES
(3, 14, 'hola como esta', '2021-01-19'),
(4, 14, 'dadssdasdd', '2021-01-21'),
(5, 14, 'sdsdasdsdsddssd', '2021-01-21');

-- --------------------------------------------------------

--
-- Table structure for table `sueldos_empleados`
--

CREATE TABLE `sueldos_empleados` (
  `id_sueldos_empleados` int(11) NOT NULL,
  `id_administrador` int(11) NOT NULL,
  `tipo_usuario` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `sueldo` int(11) NOT NULL,
  `fecha_registrado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `sueldos_empleados`
--

INSERT INTO `sueldos_empleados` (`id_sueldos_empleados`, `id_administrador`, `tipo_usuario`, `sueldo`, `fecha_registrado`, `estado`) VALUES
(6, 12, 'talento humano', 1400000, '2021-01-28 16:35:41', 'activo'),
(7, 12, 'supervisor', 1100000, '2021-01-28 16:36:26', 'inactivo'),
(8, 12, 'supervisor', 1100000, '2021-01-28 16:36:55', 'inactivo'),
(9, 12, 'supervisor', 1100000, '2021-01-28 16:37:08', 'inactivo'),
(10, 12, 'supervisor', 1100000, '2021-01-28 16:38:27', 'inactivo'),
(11, 12, 'supervisor', 1100000, '2021-01-28 16:39:00', 'inactivo'),
(12, 12, 'supervisor', 1100000, '2021-02-01 18:36:48', 'inactivo'),
(13, 12, 'supervisor', 1100000, '2021-02-01 18:37:05', 'inactivo'),
(14, 12, 'supervisor', 1100000, '2021-02-01 18:37:05', 'activo');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo_cuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_persona`, `correo`, `clave`, `tipo_cuenta`, `estado`) VALUES
(6, 6, 'talento@hotmail.com', '12345', 'talento humano', 'inactivo'),
(11, 11, 'wikilopez0122@gmail.com', '2021gz2021', 'administrador', 'activo'),
(12, 12, 'admin@hotmail.com', '12345', 'administrador', 'activo'),
(13, 13, '2020romic2020@gmail.com', '2021gz2021', 'empleado', 'activo'),
(14, 14, '2020clarafiore2020@gmail.com', 'nn', 'empleado', 'activo'),
(15, 15, '2020karlascott2020@gmail.com', '2021gz2021', 'empleado', 'activo'),
(16, 16, '2020margaretcruz2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(17, 17, '2020sarajay2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(18, 18, 'modelisabella1@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(19, 19, '2020sammyadams2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(20, 20, '2020susantorres2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(21, 21, '2020susantorres2020@gmail.com', '2020pereira2020', 'empleado', 'inactivo'),
(22, 22, '2020meridadrone2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(23, 23, '2020sarajones2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(24, 24, '2021SarahSmithGZ2021@gmail.com', '2021pereira2021', 'empleado', 'activo'),
(25, 25, '2020elettralexus2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(26, 26, '2020jessicabell2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(27, 27, '2020nicolekay2020@gmail.com', '2021gz2021', 'empleado', 'activo'),
(28, 28, '2020valeriagarcia2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(29, 29, '2021laurentzaecs2020@gmail.com', '2021pereira2021', 'empleado', 'activo'),
(30, 30, '2020julinesmith2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(31, 31, '2020diamondred2020@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(32, 32, '2020lilygrace2020@gmail.com', '2021prtrita2021', 'empleado', 'activo'),
(33, 33, '2020lilygrace2020@gmail.com', '2021pereira2021', 'empleado', 'activo'),
(34, 34, 'sophiaclarkgzstudios@gmail.com', '2020pereira2020', 'empleado', 'activo'),
(35, 35, 'bjla.0429@gmail.com', '2021gz2021', 'supervisor', 'activo'),
(36, 36, 'salazar160913@gmail.com', '2021gz2021', 'supervisor', 'activo'),
(37, 37, 'victorgonza1328@gmail.com', '2021gz2021', 'supervisor', 'activo'),
(38, 38, 'victorgonza1328@gmail.com', '2021gz2021', 'supervisor', 'inactivo'),
(39, 39, 'victorgonza1328@gmail.com', '2021gz2021', 'supervisor', 'inactivo'),
(40, 40, 'Santicruz28@gmail.com', '2021gz2021', 'supervisor', 'activo'),
(41, 41, '2020samanthasex2020@gmail.com', '2021gz2021', 'empleado', 'activo'),
(42, 42, '2021kataleya2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(43, 43, '2020celestegarcia2020@gmail.com', '2021gz2021', 'empleado', 'activo'),
(44, 44, '2021sabrinasoul2021@gmail.com', '2021gz2021', 'empleado', 'inactivo'),
(45, 45, '2021sabrinasoul2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(46, 46, '2021luisagutierres2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(47, 47, '2020melanniecooper2020@gmail.com', '2021gz2021', 'empleado', 'activo'),
(48, 48, '2021greicy2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(49, 49, 'supervisor4@gmail.com', '2021gz2021', 'supervisor', 'activo'),
(50, 50, 'kocampo2.ko@outlook.com', '2021gz2021', 'supervisor', 'activo'),
(51, 51, 'jhoancastrillon7@gmail.com', '2021gz2021', 'tecnico sistemas', 'activo'),
(52, 52, '2020mirandayepez2020@gmail.com', '2021gz2021', 'empleado', 'activo'),
(53, 53, '2021liajacob2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(54, 54, '2021marilynclark2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(55, 55, 'lfllondonog@gmail.com', '12345', 'empleado', 'inactivo'),
(56, 56, '2021martinagarcia2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(57, 57, '2021marilynclark2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(58, 58, '2021angelicavelez2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(59, 59, '2021elisa2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(60, 60, 'luisa.cardona125@hotmail.com', '2021gz2021', 'talento humano', 'activo'),
(61, 61, '2021sienamontes2021@gmail.com', '2021gz2021', 'empleado', 'activo'),
(62, 62, 'supervisor7@hotmail.com', '2021gz2021', 'supervisor', 'activo'),
(63, 63, 'sebastian.zapata.gzstd@gmail.com', '2021gz2021', 'fotografo', 'activo'),
(64, 64, 'supervisorsatelites@gmail.com', '2021gz2021', 'supervisor', 'activo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adelanto`
--
ALTER TABLE `adelanto`
  ADD PRIMARY KEY (`id_adelanto`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_administrador` (`id_administrador`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_factura_general` (`id_factura_general`),
  ADD KEY `id_factura_supervisor` (`id_factura_supervisor`);

--
-- Indexes for table `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_asistencia`),
  ADD KEY `id_supervisor` (`id_supervisor`);

--
-- Indexes for table `asistencia_empleado`
--
ALTER TABLE `asistencia_empleado`
  ADD PRIMARY KEY (`id_asistencia_empleado`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_asistencia` (`id_asistencia`);

--
-- Indexes for table `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_citas`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_fotografo` (`id_fotografo`);

--
-- Indexes for table `dolar`
--
ALTER TABLE `dolar`
  ADD PRIMARY KEY (`id_dolar`);

--
-- Indexes for table `empleado_penalizacion`
--
ALTER TABLE `empleado_penalizacion`
  ADD PRIMARY KEY (`id_empleado_penalizacion`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_supervisor` (`id_supervisor`),
  ADD KEY `id_penalizacion` (`id_penalizacion`),
  ADD KEY `id_factura` (`id_factura`);

--
-- Indexes for table `empleado_supervisor`
--
ALTER TABLE `empleado_supervisor`
  ADD PRIMARY KEY (`id_relacion_es`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_supervisor` (`id_supervisor`);

--
-- Indexes for table `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_talento_humano` (`id_talento_humano`),
  ADD KEY `id_dolar` (`id_dolar`),
  ADD KEY `id_porcentaje_dias` (`id_porcentaje_dias`),
  ADD KEY `id_meta` (`id_meta`);

--
-- Indexes for table `factura_general`
--
ALTER TABLE `factura_general`
  ADD PRIMARY KEY (`id_factura_general`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_sueldo` (`id_sueldo`);

--
-- Indexes for table `factura_supervisor`
--
ALTER TABLE `factura_supervisor`
  ADD PRIMARY KEY (`id_factura_supervisor`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_talento_humano` (`id_administrador`),
  ADD KEY `id_meta` (`id_meta`),
  ADD KEY `id_sueldo` (`id_sueldo`);

--
-- Indexes for table `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id_gasto`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indexes for table `horas_ingresos`
--
ALTER TABLE `horas_ingresos`
  ADD PRIMARY KEY (`id_horas_ingresos`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `informe_empleados`
--
ALTER TABLE `informe_empleados`
  ADD PRIMARY KEY (`id_informe_empleado`),
  ADD KEY `id_supervisor` (`id_supervisor`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indexes for table `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `id_factura` (`id_factura`);

--
-- Indexes for table `metas`
--
ALTER TABLE `metas`
  ADD PRIMARY KEY (`id_meta`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_administrador` (`id_administrador`);

--
-- Indexes for table `paginas`
--
ALTER TABLE `paginas`
  ADD PRIMARY KEY (`id_pagina`);

--
-- Indexes for table `penalizaciones`
--
ALTER TABLE `penalizaciones`
  ADD PRIMARY KEY (`id_penalizacion`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indexes for table `persona_pagina`
--
ALTER TABLE `persona_pagina`
  ADD PRIMARY KEY (`id_persona_pag`),
  ADD KEY `id_pagina` (`id_pagina`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indexes for table `porcentajes_dias`
--
ALTER TABLE `porcentajes_dias`
  ADD PRIMARY KEY (`id_porcentajes_dias`);

--
-- Indexes for table `registro_horas`
--
ALTER TABLE `registro_horas`
  ADD PRIMARY KEY (`id_registro_horas`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_supervisor` (`id_supervisor`),
  ADD KEY `id_pagina` (`id_pagina`),
  ADD KEY `id_factura` (`id_factura`);

--
-- Indexes for table `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `id_tecnico` (`id_tecnico`);

--
-- Indexes for table `sueldos_empleados`
--
ALTER TABLE `sueldos_empleados`
  ADD PRIMARY KEY (`id_sueldos_empleados`),
  ADD KEY `id_administrador` (`id_administrador`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_persona` (`id_persona`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adelanto`
--
ALTER TABLE `adelanto`
  MODIFY `id_adelanto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `asistencia_empleado`
--
ALTER TABLE `asistencia_empleado`
  MODIFY `id_asistencia_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `citas`
--
ALTER TABLE `citas`
  MODIFY `id_citas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dolar`
--
ALTER TABLE `dolar`
  MODIFY `id_dolar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `empleado_penalizacion`
--
ALTER TABLE `empleado_penalizacion`
  MODIFY `id_empleado_penalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `empleado_supervisor`
--
ALTER TABLE `empleado_supervisor`
  MODIFY `id_relacion_es` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `factura_general`
--
ALTER TABLE `factura_general`
  MODIFY `id_factura_general` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `factura_supervisor`
--
ALTER TABLE `factura_supervisor`
  MODIFY `id_factura_supervisor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id_gasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `metas`
--
ALTER TABLE `metas`
  MODIFY `id_meta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `paginas`
--
ALTER TABLE `paginas`
  MODIFY `id_pagina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penalizaciones`
--
ALTER TABLE `penalizaciones`
  MODIFY `id_penalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `persona_pagina`
--
ALTER TABLE `persona_pagina`
  MODIFY `id_persona_pag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `porcentajes_dias`
--
ALTER TABLE `porcentajes_dias`
  MODIFY `id_porcentajes_dias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `registro_horas`
--
ALTER TABLE `registro_horas`
  MODIFY `id_registro_horas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=354;

--
-- AUTO_INCREMENT for table `sueldos_empleados`
--
ALTER TABLE `sueldos_empleados`
  MODIFY `id_sueldos_empleados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adelanto`
--
ALTER TABLE `adelanto`
  ADD CONSTRAINT `adelanto_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adelanto_ibfk_2` FOREIGN KEY (`id_administrador`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adelanto_ibfk_3` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adelanto_ibfk_4` FOREIGN KEY (`id_factura_general`) REFERENCES `factura_general` (`id_factura_general`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `adelanto_ibfk_5` FOREIGN KEY (`id_factura_supervisor`) REFERENCES `factura_supervisor` (`id_factura_supervisor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_supervisor`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asistencia_empleado`
--
ALTER TABLE `asistencia_empleado`
  ADD CONSTRAINT `asistencia_empleado_ibfk_1` FOREIGN KEY (`id_asistencia`) REFERENCES `asistencia` (`id_asistencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asistencia_empleado_ibfk_3` FOREIGN KEY (`id_empleado`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `empleado_penalizacion`
--
ALTER TABLE `empleado_penalizacion`
  ADD CONSTRAINT `empleado_penalizacion_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleado_penalizacion_ibfk_2` FOREIGN KEY (`id_supervisor`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleado_penalizacion_ibfk_3` FOREIGN KEY (`id_penalizacion`) REFERENCES `penalizaciones` (`id_penalizacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleado_penalizacion_ibfk_4` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `empleado_supervisor`
--
ALTER TABLE `empleado_supervisor`
  ADD CONSTRAINT `empleado_supervisor_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleado_supervisor_ibfk_2` FOREIGN KEY (`id_supervisor`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_10` FOREIGN KEY (`id_meta`) REFERENCES `metas` (`id_meta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`id_talento_humano`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_4` FOREIGN KEY (`id_dolar`) REFERENCES `dolar` (`id_dolar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_9` FOREIGN KEY (`id_porcentaje_dias`) REFERENCES `porcentajes_dias` (`id_porcentajes_dias`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `factura_general`
--
ALTER TABLE `factura_general`
  ADD CONSTRAINT `factura_general_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_general_ibfk_2` FOREIGN KEY (`id_sueldo`) REFERENCES `sueldos_empleados` (`id_sueldos_empleados`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `factura_supervisor`
--
ALTER TABLE `factura_supervisor`
  ADD CONSTRAINT `factura_supervisor_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_supervisor_ibfk_4` FOREIGN KEY (`id_sueldo`) REFERENCES `sueldos_empleados` (`id_sueldos_empleados`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_supervisor_ibfk_6` FOREIGN KEY (`id_administrador`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_supervisor_ibfk_7` FOREIGN KEY (`id_meta`) REFERENCES `metas` (`id_meta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `metas`
--
ALTER TABLE `metas`
  ADD CONSTRAINT `metas_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `metas_ibfk_2` FOREIGN KEY (`id_administrador`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `persona_pagina`
--
ALTER TABLE `persona_pagina`
  ADD CONSTRAINT `persona_pagina_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persona_pagina_ibfk_2` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registro_horas`
--
ALTER TABLE `registro_horas`
  ADD CONSTRAINT `registro_horas_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registro_horas_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registro_horas_ibfk_3` FOREIGN KEY (`id_supervisor`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registro_horas_ibfk_4` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sueldos_empleados`
--
ALTER TABLE `sueldos_empleados`
  ADD CONSTRAINT `sueldos_empleados_ibfk_1` FOREIGN KEY (`id_administrador`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
