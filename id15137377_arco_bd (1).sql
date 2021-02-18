-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-02-2021 a las 04:08:44
-- Versión del servidor: 8.0.18
-- Versión de PHP: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id15137377_arco_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_clientes`
--

CREATE TABLE `cat_clientes` (
  `id_Cliente` int(7) NOT NULL,
  `nombre_Cliente` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pApellido_Cliente` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razonSocial_Cliente` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfc_Cliente` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion_Cliente` int(7) NOT NULL,
  `correo_Cliente` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel_Cliente` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_Entidad` int(2) NOT NULL,
  `estadoRegistroC` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cat_clientes`
--

INSERT INTO `cat_clientes` (`id_Cliente`, `nombre_Cliente`, `pApellido_Cliente`, `razonSocial_Cliente`, `rfc_Cliente`, `direccion_Cliente`, `correo_Cliente`, `tel_Cliente`, `tipo_Entidad`, `estadoRegistroC`) VALUES
(0, '', '', '', '', 1, '', '', 1, 0),
(1, 'Mahonry', 'Santiago', 'Mahonry Santiago Cordova', 'SACM941114GJ7', 1, 'correo@hotmail.com', '9212670933', 1, 1),
(2, 'Morian', 'Cordova', 'Morian Cordova', 'AAA010101AAA', 2, 'morian@correo2.com', '2222222222', 1, 1),
(3, 'Jairo', 'Santiago', 'Jairo Santiago', 'AAA010101AAA', 3, 'Jairo.contaiblidad@hotmail.com', '9212670555', 1, 1),
(4, 'Proveedorcuatro', 'ApellidoProveedorcuatro', 'Razon Social Proveedor 4', 'AAA010101AAA', 4, 'Correo@proveedor4.com', '4444444444', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_direccionclientes`
--

CREATE TABLE `cat_direccionclientes` (
  `id_Direccion` int(7) NOT NULL,
  `calle_Cliente` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroEx_Cliente` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeroInt_Cliente` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colonia_Cliente` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad_Cliente` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_Cliente` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cat_direccionclientes`
--

INSERT INTO `cat_direccionclientes` (`id_Direccion`, `calle_Cliente`, `numeroEx_Cliente`, `numeroInt_Cliente`, `colonia_Cliente`, `ciudad_Cliente`, `estado_Cliente`) VALUES
(1, 'Calle 1', '193', '62', 'Las Gaviotas', 'Zapopan', 2),
(2, 'Calle 2', '192', '25', 'Colonia', 'Minatitlan', 16),
(3, 'Calle1', '22244', '2', 'Colonia Jairo', 'Ciudad Jairo', 2),
(4, 'Calle 4', '4', '44', 'Colonia 4', 'Allende', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estado`
--

CREATE TABLE `cat_estado` (
  `id_Estado` int(10) NOT NULL,
  `nombre_Estado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cat_estado`
--

INSERT INTO `cat_estado` (`id_Estado`, `nombre_Estado`) VALUES
(1, 'Aguascalientes'),
(2, 'Baja California'),
(3, 'Baja California Sur'),
(4, 'Campeche'),
(5, 'Coahuila'),
(6, 'Colima'),
(7, 'Chiapas'),
(8, 'Chihuahua'),
(9, 'CDMX'),
(10, 'Durango'),
(11, 'Guanajuato'),
(12, 'Guerrero'),
(13, 'Hidalgo'),
(14, 'Jalisco'),
(15, 'Estado de Mexico'),
(16, 'Michoacan'),
(17, 'Morelos'),
(18, 'Nayarit'),
(19, 'Nuevo León'),
(20, 'Oaxaca'),
(21, 'Puebla'),
(22, 'Queretaro'),
(23, 'Quintana Roo'),
(24, ' San Luis Potosí '),
(25, 'Sinaloa'),
(26, 'Sonora'),
(27, 'Tabasco'),
(28, 'Tamaulipas'),
(29, 'Tlaxcala'),
(30, 'Veracruz'),
(31, 'Yucatán'),
(32, 'Zacatecas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_producto`
--

CREATE TABLE `cat_producto` (
  `id_Producto` int(50) NOT NULL,
  `nombre_Producto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_Producto` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_Producto` double NOT NULL,
  `precio_Producto` double NOT NULL,
  `unidad_Producto` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `existencia_Producto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cat_producto`
--

INSERT INTO `cat_producto` (`id_Producto`, `nombre_Producto`, `descripcion_Producto`, `costo_Producto`, `precio_Producto`, `unidad_Producto`, `existencia_Producto`) VALUES
(1, 'Jabon Liquido Salvo', 'Jabon Liquido Salvo de 725ml', 20, 25, 'Pza', 17),
(2, 'Jabon', 'Jabon de Pepino', 30, 45.5, 'Pza', 108),
(3, 'Esponja', 'Esponja Amarilla', 20, 30, 'Pza', 50),
(4, 'Papel cuatro', 'Papael 4 rollos', 44, 45, 'PAQ', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listadomovimientos`
--

CREATE TABLE `listadomovimientos` (
  `idMovimiento` int(50) NOT NULL,
  `claveProducto` int(50) NOT NULL,
  `nombreProducto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidadProducto` float NOT NULL,
  `precioProducto` double NOT NULL,
  `precioTotalProducto` double NOT NULL,
  `idDocumentoVenta` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `listadomovimientos`
--

INSERT INTO `listadomovimientos` (`idMovimiento`, `claveProducto`, `nombreProducto`, `cantidadProducto`, `precioProducto`, `precioTotalProducto`, `idDocumentoVenta`) VALUES
(181, 1, 'Esponja', 10, 60, 600, 68),
(182, 1, 'Esponja', 10, 60, 600, 68),
(183, 1, 'Esponja', 10, 60, 600, 69),
(185, 3, 'Jabon Liquido Salvo', 10, 25, 250, 69),
(186, 3, 'Jabon Liquido Salvo', 10, 25, 250, 69),
(189, 1, 'Esponja', 10, 60, 600, 70),
(190, 1, 'Esponja', 10, 60, 600, 70),
(191, 1, 'Esponja', 10, 60, 600, 72),
(193, 1, 'Esponja', 1, 60, 60, 75),
(194, 2, 'Jabon', 10, 45.5, 455, 75),
(195, 2, 'Jabon', 10, 45.5, 455, 75),
(196, 1, 'Esponja', 5, 60, 300, 75),
(197, 1, 'Esponja', 5, 60, 300, 75),
(199, 1, 'Esponja', 10, 60, 600, 76),
(200, 1, 'Esponja', 10, 60, 600, 76),
(201, 1, 'Esponja', 10, 60, 600, 76),
(202, 1, 'Esponja', 10, 60, 600, 76),
(203, 1, 'Esponja', 10, 60, 600, 76),
(204, 1, 'Esponja', 10, 60, 600, 76),
(205, 1, 'Esponja', 10, 60, 600, 76),
(206, 1, 'Esponja', 10, 60, 600, 76),
(222, 1, 'Esponja', 10, 60, 600, 78),
(223, 1, 'Esponja', 10, 60, 600, 78),
(226, 1, 'Esponja', 8, 60, 480, 79),
(227, 2, 'Jabon', 5, 45.5, 227.5, 80),
(230, 1, 'Esponja', 10, 60, 600, 81),
(231, 2, 'Jabon', 10, 45.5, 455, 81),
(232, 3, 'Jabon Liquido Salvo', 10, 25, 250, 81),
(233, 3, 'Jabon Liquido Salvo', 10, 25, 250, 81),
(238, 2, 'Jabon', 2, 45.5, 91, 82),
(239, 1, 'Jabon Liquido Salvo', 2, 25, 50, 82),
(240, 3, 'Esponja', 10, 30, 300, 80),
(242, 1, 'Jabon Liquido Salvo', 1, 25, 25, 77),
(244, 1, 'Jabon Liquido Salvo', 10, 25, 250, 83),
(246, 1, 'Jabon Liquido Salvo', 10, 25, 250, 83);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listado_entrada`
--

CREATE TABLE `listado_entrada` (
  `idEntrada` int(50) NOT NULL,
  `fechaEntrada` date NOT NULL,
  `idProveedorEntrada` int(7) NOT NULL,
  `idProductoEntrada` int(50) NOT NULL,
  `cantidadEntrada` float NOT NULL,
  `numeroEntrada` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listado_venta`
--

CREATE TABLE `listado_venta` (
  `idVenta` int(50) NOT NULL,
  `fechaVenta` date NOT NULL,
  `id_ClienteVenta` int(7) NOT NULL,
  `subtotalVenta` double NOT NULL,
  `ivaVenta` double NOT NULL,
  `totalVenta` double NOT NULL,
  `numeroVenta` int(11) NOT NULL,
  `estadoRegistroV` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `listado_venta`
--

INSERT INTO `listado_venta` (`idVenta`, `fechaVenta`, `id_ClienteVenta`, `subtotalVenta`, `ivaVenta`, `totalVenta`, `numeroVenta`, `estadoRegistroV`) VALUES
(68, '2021-01-22', 0, 0, 0, 0, 1, 1),
(69, '2021-01-23', 1, 1100, 176, 1276, 69, 1),
(70, '2021-01-23', 0, 0, 0, 0, 70, 1),
(71, '2021-01-23', 0, 0, 0, 0, 71, 1),
(72, '2021-01-23', 0, 0, 0, 0, 72, 1),
(73, '2021-01-23', 0, 0, 0, 0, 73, 1),
(74, '2021-01-23', 0, 0, 0, 0, 74, 1),
(75, '2021-01-23', 1, 1570, 251.2, 1821.2, 75, 1),
(76, '2021-01-23', 1, 4800, 768, 5568, 76, 2),
(77, '2021-01-23', 1, 25, 4, 29, 77, 2),
(78, '2021-01-23', 1, 1200, 192, 1392, 78, 2),
(79, '2021-01-26', 1, 480, 76.8, 556.8, 79, 2),
(80, '2021-01-26', 2, 527.5, 84.4, 611.9, 80, 2),
(81, '2021-01-28', 2, 1555, 248.8, 1803.8, 81, 2),
(82, '2021-02-12', 1, 141, 22.56, 163.56, 82, 2),
(83, '2021-02-13', 1, 250, 40, 290, 83, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipoUsuario` int(10) NOT NULL,
  `tipo_Usuario` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipoUsuario`, `tipo_Usuario`) VALUES
(1, 'Administrador'),
(2, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(20) NOT NULL,
  `password_Usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_Usuario` int(10) NOT NULL,
  `nombre_Usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo_Usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tabla de usuarios';

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `password_Usuario`, `tipo_Usuario`, `nombre_Usuario`, `correo_Usuario`) VALUES
(1, 'Mahonry123', 1, 'Administrador', 'admin.@gmail.com'),
(4, 'claudia123', 2, 'Claudia', 'Claudia@hotmail.com'),
(5, '2125007m', 1, 'Mahonry', 'logicasolid@hotmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cat_clientes`
--
ALTER TABLE `cat_clientes`
  ADD PRIMARY KEY (`id_Cliente`),
  ADD UNIQUE KEY `id_Cliente` (`id_Cliente`),
  ADD KEY `direccion_Cliente` (`direccion_Cliente`);

--
-- Indices de la tabla `cat_direccionclientes`
--
ALTER TABLE `cat_direccionclientes`
  ADD PRIMARY KEY (`id_Direccion`),
  ADD KEY `estado_Cliente` (`estado_Cliente`);

--
-- Indices de la tabla `cat_estado`
--
ALTER TABLE `cat_estado`
  ADD PRIMARY KEY (`id_Estado`);

--
-- Indices de la tabla `cat_producto`
--
ALTER TABLE `cat_producto`
  ADD PRIMARY KEY (`id_Producto`);

--
-- Indices de la tabla `listadomovimientos`
--
ALTER TABLE `listadomovimientos`
  ADD PRIMARY KEY (`idMovimiento`),
  ADD KEY `claveProducto` (`claveProducto`),
  ADD KEY `idDocumentoVenta` (`idDocumentoVenta`);

--
-- Indices de la tabla `listado_entrada`
--
ALTER TABLE `listado_entrada`
  ADD PRIMARY KEY (`idEntrada`),
  ADD KEY `idProveedorEntrada` (`idProveedorEntrada`),
  ADD KEY `idProductoEntrada` (`idProductoEntrada`);

--
-- Indices de la tabla `listado_venta`
--
ALTER TABLE `listado_venta`
  ADD PRIMARY KEY (`idVenta`),
  ADD UNIQUE KEY `numeroVenta` (`numeroVenta`),
  ADD KEY `id_ClienteVenta` (`id_ClienteVenta`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipoUsuario`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD KEY `tipo_Usuario` (`tipo_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cat_estado`
--
ALTER TABLE `cat_estado`
  MODIFY `id_Estado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `listadomovimientos`
--
ALTER TABLE `listadomovimientos`
  MODIFY `idMovimiento` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT de la tabla `listado_entrada`
--
ALTER TABLE `listado_entrada`
  MODIFY `idEntrada` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `listado_venta`
--
ALTER TABLE `listado_venta`
  MODIFY `idVenta` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cat_clientes`
--
ALTER TABLE `cat_clientes`
  ADD CONSTRAINT `cat_clientes_ibfk_1` FOREIGN KEY (`direccion_Cliente`) REFERENCES `cat_direccionclientes` (`id_Direccion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `cat_direccionclientes`
--
ALTER TABLE `cat_direccionclientes`
  ADD CONSTRAINT `cat_direccionclientes_ibfk_1` FOREIGN KEY (`estado_Cliente`) REFERENCES `cat_estado` (`id_Estado`);

--
-- Filtros para la tabla `listadomovimientos`
--
ALTER TABLE `listadomovimientos`
  ADD CONSTRAINT `listadomovimientos_ibfk_1` FOREIGN KEY (`claveProducto`) REFERENCES `cat_producto` (`id_Producto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `listadomovimientos_ibfk_2` FOREIGN KEY (`idDocumentoVenta`) REFERENCES `listado_venta` (`idVenta`);

--
-- Filtros para la tabla `listado_entrada`
--
ALTER TABLE `listado_entrada`
  ADD CONSTRAINT `listado_entrada_ibfk_1` FOREIGN KEY (`idProductoEntrada`) REFERENCES `cat_producto` (`id_Producto`),
  ADD CONSTRAINT `listado_entrada_ibfk_2` FOREIGN KEY (`idProveedorEntrada`) REFERENCES `cat_clientes` (`id_Cliente`);

--
-- Filtros para la tabla `listado_venta`
--
ALTER TABLE `listado_venta`
  ADD CONSTRAINT `listado_venta_ibfk_1` FOREIGN KEY (`id_ClienteVenta`) REFERENCES `cat_clientes` (`id_Cliente`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`tipo_Usuario`) REFERENCES `tipo_usuario` (`id_tipoUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
