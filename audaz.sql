-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 01:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `audaz`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cat_empleados`
--

CREATE TABLE `cat_empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `paterno` varchar(45) DEFAULT NULL,
  `materno` varchar(45) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cat_empleados`
--

INSERT INTO `cat_empleados` (`id_empleado`, `nombre`, `paterno`, `materno`, `fecha_inicio`) VALUES
(2, 'Ana Karen', 'Padron', 'De Dios ', '2022-08-01'),
(3, 'Dario ', 'Pimentel', 'Martinez', '2022-08-01'),
(4, 'Hugo', 'Medrano', 'Ruiz', '2022-08-01'),
(5, 'Ma del Carmen', 'Padron ', 'Hernandez', '2022-08-01');

-- --------------------------------------------------------

--
-- Table structure for table `cat_eventos`
--

CREATE TABLE `cat_eventos` (
  `id_evento` int(11) NOT NULL,
  `evento` varchar(200) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cat_eventos`
--

INSERT INTO `cat_eventos` (`id_evento`, `evento`, `fecha_inicio`, `fecha_termino`) VALUES
(2, 'Fenapo', '2022-08-05', '2022-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `cat_presentaciones`
--

CREATE TABLE `cat_presentaciones` (
  `id_presentacion` int(11) NOT NULL,
  `presentacion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cat_presentaciones`
--

INSERT INTO `cat_presentaciones` (`id_presentacion`, `presentacion`) VALUES
(1, 'PRUEBA'),
(3, '750 ml'),
(4, '375 ml'),
(5, '2 ltrs'),
(6, '16 onz');

-- --------------------------------------------------------

--
-- Table structure for table `cat_productos`
--

CREATE TABLE `cat_productos` (
  `id_producto` int(11) NOT NULL,
  `id_sabor` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `precio` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cat_productos`
--

INSERT INTO `cat_productos` (`id_producto`, `id_sabor`, `id_presentacion`, `precio`) VALUES
(2, 2, 3, 300.00),
(3, 2, 4, 180.00),
(4, 4, 4, 300.00);

-- --------------------------------------------------------

--
-- Table structure for table `cat_sabores`
--

CREATE TABLE `cat_sabores` (
  `id_sabor` int(11) NOT NULL,
  `sabor` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cat_sabores`
--

INSERT INTO `cat_sabores` (`id_sabor`, `sabor`) VALUES
(2, 'Piñon'),
(3, 'Pistache'),
(4, 'Capuchino'),
(5, 'Mazapan'),
(6, 'Bayas del Huerto'),
(7, 'Arandano'),
(8, 'Cedrón '),
(9, 'Tamarindo'),
(10, 'Nuez'),
(11, 'Refresco sprite'),
(12, 'Refresco Squirt'),
(13, 'Vaso 16onz');

-- --------------------------------------------------------

--
-- Table structure for table `entradas`
--

CREATE TABLE `entradas` (
  `id_entradas` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_entradas` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `fecha_hora_acceso` datetime DEFAULT '0000-00-00 00:00:00',
  `fecha_hora_fin` datetime DEFAULT '0000-00-00 00:00:00',
  `accion` varchar(45) DEFAULT NULL,
  `hizo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `usuario`, `fecha_hora_acceso`, `fecha_hora_fin`, `accion`, `hizo`) VALUES
(29, 1, '2022-08-04 04:49:30', '2022-08-04 04:49:30', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(30, 1, '2022-08-04 04:49:35', '2022-08-04 04:49:35', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(31, 1, '2022-08-04 04:49:41', '2022-08-04 04:49:41', 'CERRAR SESIÓN', 'USUARIO 1 CERRÓ SESIÓN'),
(32, 1, '2022-08-04 05:01:17', '2022-08-04 05:01:17', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(33, 1, '2022-08-04 05:01:21', '2022-08-04 05:01:21', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(34, 1, '2022-08-04 05:02:36', '2022-08-04 05:02:36', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(35, 1, '2022-08-04 05:06:56', '2022-08-04 05:06:56', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(36, 1, '2022-08-04 05:07:31', '2022-08-04 05:07:31', 'CREAR USUARIO', 'USUARIO 13 CREADO'),
(37, 1, '2022-08-04 05:07:40', '2022-08-04 05:07:40', 'CERRAR SESIÓN', 'USUARIO 1 CERRÓ SESIÓN'),
(38, 1, '2022-08-04 05:08:07', '2022-08-04 05:08:07', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(39, 1, '2022-08-04 05:08:38', '2022-08-04 05:08:38', 'CERRAR SESIÓN', 'USUARIO 1 CERRÓ SESIÓN'),
(40, 13, '2022-08-04 05:10:08', '2022-08-04 05:10:08', 'CERRAR SESIÓN', 'USUARIO 13 CERRÓ SESIÓN'),
(41, 1, '2022-08-04 05:10:10', '2022-08-04 05:10:10', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(42, 1, '2022-08-04 05:10:50', '2022-08-04 05:10:50', 'CERRAR SESIÓN', 'USUARIO 1 CERRÓ SESIÓN'),
(43, 13, '2022-08-04 05:11:43', '2022-08-04 05:11:43', 'CERRAR SESIÓN', 'USUARIO 13 CERRÓ SESIÓN'),
(44, 1, '2022-08-04 05:11:48', '2022-08-04 05:11:48', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(45, 13, '2022-08-04 05:13:40', '2022-08-04 05:13:40', 'INICIAR SESIÓN', 'USUARIO 13 INICIÓ SESIÓN'),
(46, 1, '2022-08-04 05:41:53', '2022-08-04 05:41:53', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(47, 1, '2022-08-05 09:23:53', '2022-08-05 09:23:53', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(48, 1, '2022-08-10 11:40:04', '2022-08-10 11:40:04', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(49, 1, '2022-08-11 07:11:45', '2022-08-11 07:11:45', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(50, 1, '2022-08-13 07:45:09', '2022-08-13 07:45:09', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(51, 1, '2022-08-13 08:26:14', '2022-08-13 08:26:14', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(52, 1, '2022-08-19 02:39:26', '2022-08-19 02:39:26', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(53, 1, '2022-08-19 04:50:04', '2022-08-19 04:50:04', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(54, 1, '2022-08-19 04:53:07', '2022-08-19 04:53:07', 'CERRAR SESIÓN', 'USUARIO 1 CERRÓ SESIÓN'),
(55, 1, '2022-08-22 10:20:23', '2022-08-22 10:20:23', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(56, 1, '2022-08-22 10:20:53', '2022-08-22 10:20:53', 'CERRAR SESIÓN', 'USUARIO 1 CERRÓ SESIÓN'),
(57, 1, '2023-05-08 07:51:03', '2023-05-08 07:51:03', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(58, 1, '2023-05-24 08:28:00', '2023-05-24 08:28:00', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(59, 1, '2023-05-24 08:28:12', '2023-05-24 08:28:12', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(60, 1, '2023-06-23 11:54:56', '2023-06-23 11:54:56', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(61, 1, '2024-02-07 05:44:28', '2024-02-07 05:44:28', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(62, 1, '2024-04-11 06:15:40', '2024-04-11 06:15:40', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(63, 1, '2024-04-11 06:48:59', '2024-04-11 06:48:59', 'CERRAR SESIÓN', 'USUARIO 1 CERRÓ SESIÓN'),
(64, 1, '2024-04-11 06:49:03', '2024-04-11 06:49:03', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN'),
(65, 1, '2024-04-11 06:49:35', '2024-04-11 06:49:35', 'INICIAR SESIÓN', 'USUARIO 1 INICIÓ SESIÓN');

-- --------------------------------------------------------

--
-- Table structure for table `log_alertas`
--

CREATE TABLE `log_alertas` (
  `id` int(11) NOT NULL,
  `fecha_hora_alerta` datetime DEFAULT current_timestamp(),
  `correos_alerta` text DEFAULT NULL,
  `correo` text DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salidas`
--

CREATE TABLE `salidas` (
  `id_salidas` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_evento` varchar(45) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_vendida` double NOT NULL,
  `cantidad_degustacion` double NOT NULL,
  `cantidad_cortesia` double NOT NULL,
  `cantidad_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `authKey` varchar(45) DEFAULT NULL,
  `privilegio` int(11) DEFAULT NULL,
  `pass_actualizado` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `authKey`, `privilegio`, `pass_actualizado`) VALUES
(1, 'admin', '$2y$13$ipCNZDT1XWO7IPjTRqmNEe1pf/xpQRCoZhE2swd9ABE4aiGhDBwJa', '3UIKXt1hfEXA3CnAX5y6Kc_GRRc_jHWn', 1, '1'),
(13, 'jose.padron@grupotic.com.mx', '$2y$13$zSLG0ITebFdpH6yfsPszoeh6AbCCKoT5peXVdlKQFYOKYkYMoVT0i', '7HXMJqzjOkS0TUE0IChaAbAmM6J10WLs', 1, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `cat_empleados`
--
ALTER TABLE `cat_empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indexes for table `cat_eventos`
--
ALTER TABLE `cat_eventos`
  ADD PRIMARY KEY (`id_evento`);

--
-- Indexes for table `cat_presentaciones`
--
ALTER TABLE `cat_presentaciones`
  ADD PRIMARY KEY (`id_presentacion`);

--
-- Indexes for table `cat_productos`
--
ALTER TABLE `cat_productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indexes for table `cat_sabores`
--
ALTER TABLE `cat_sabores`
  ADD PRIMARY KEY (`id_sabor`);

--
-- Indexes for table `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id_entradas`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_alertas`
--
ALTER TABLE `log_alertas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`id_salidas`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cat_empleados`
--
ALTER TABLE `cat_empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cat_eventos`
--
ALTER TABLE `cat_eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cat_presentaciones`
--
ALTER TABLE `cat_presentaciones`
  MODIFY `id_presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cat_productos`
--
ALTER TABLE `cat_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cat_sabores`
--
ALTER TABLE `cat_sabores`
  MODIFY `id_sabor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `log_alertas`
--
ALTER TABLE `log_alertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
