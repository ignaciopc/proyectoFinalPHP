-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2025 a las 18:25:33
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
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Cítricos'),
(2, 'Tropicales'),
(3, 'Bayas'),
(4, 'Frutas de hueso'),
(5, 'Frutas de pepita');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedidos`
--

CREATE TABLE `lineas_pedidos` (
  `id` int(255) NOT NULL,
  `pedido_id` int(255) NOT NULL,
  `producto_id` int(255) NOT NULL,
  `unidades` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lineas_pedidos`
--

INSERT INTO `lineas_pedidos` (`id`, `pedido_id`, `producto_id`, `unidades`) VALUES
(5, 3, 49, 5),
(6, 3, 48, 5),
(7, 4, 49, 5),
(8, 4, 48, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(255) NOT NULL,
  `usuario_id` int(255) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `coste` float(200,2) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `provincia`, `localidad`, `direccion`, `coste`, `estado`, `fecha`, `hora`) VALUES
(1, 2, 'Madrid', 'Madrid', 'Calle Falsa 123', 350.98, 'Pendiente', '2025-03-02', '10:00:00'),
(2, 3, 'Barcelona', 'Barcelona', 'Avenida Real 456', 799.98, 'Confirmado', '2025-03-02', '15:30:00'),
(3, 4, 'ad', 'sfsf', 'sfsf', 28.50, 'confirm', '2025-03-02', '16:54:27'),
(4, 4, 'ad', 'sfsf', 'sfsf', 28.50, 'confirm', '2025-03-02', '16:54:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(255) NOT NULL,
  `categoria_id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` float(100,2) NOT NULL,
  `stock` int(255) NOT NULL,
  `oferta` varchar(2) NOT NULL,
  `fecha` date NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `precio`, `stock`, `oferta`, `fecha`, `imagen`) VALUES
(38, 1, 'Naranja', 'Dulce y jugosa, rica en vitamina C.', 1.50, 100, '0', '2025-03-02', 'naranja.jpg'),
(39, 1, 'Limón', 'Ácido y refrescante, ideal para bebidas.', 1.00, 80, '0', '2025-03-02', 'limon.jpg'),
(40, 1, 'Mandarina', 'Pequeña y fácil de pelar, perfecta para snacks.', 1.20, 90, '0', '2025-03-02', 'mandarina.jpg'),
(41, 2, 'Piña', 'Dulce y tropical, con un toque ácido.', 2.50, 50, '1', '2025-03-02', 'pina.jpg'),
(42, 2, 'Mango', 'Dulce y cremoso, muy aromático.', 3.00, 60, '0', '2025-03-02', 'mango.jpg'),
(43, 2, 'Coco', 'Fruta exótica con pulpa blanca y refrescante agua de coco.', 2.80, 40, '0', '2025-03-02', 'coco.jpg'),
(44, 3, 'Fresa', 'Pequeña, roja y jugosa, rica en antioxidantes.', 2.00, 70, '1', '2025-03-02', 'fresa.jpg'),
(45, 3, 'Frambuesa', 'Dulce y ácida, con textura suave.', 2.80, 50, '0', '2025-03-02', 'frambuesa.jpg'),
(46, 3, 'Mora', 'Fruta oscura y jugosa con sabor intenso.', 3.00, 40, '0', '2025-03-02', 'mora.jpg'),
(47, 4, 'Durazno', 'Dulce y jugoso, con piel aterciopelada.', 1.80, 90, '0', '2025-03-02', 'durazno.jpg'),
(48, 4, 'Cereza', 'Pequeña, roja y deliciosa.', 3.50, 60, '1', '2025-03-02', 'cereza.jpg'),
(49, 4, 'Albaricoque', 'Similar al durazno pero más pequeño y con sabor más suave.', 2.20, 50, '0', '2025-03-02', 'albaricoque.jpg'),
(50, 5, 'Manzana', 'Crujiente y jugosa, con variedad de sabores.', 1.50, 120, '0', '2025-03-02', 'manzana.jpg'),
(51, 5, 'Pera', 'Dulce y jugosa, con textura suave.', 1.70, 110, '0', '2025-03-02', 'pera.jpg'),
(52, 5, 'Uva', 'Pequeña y dulce, ideal para comer fresca o hacer vino.', 2.50, 100, '1', '2025-03-02', 'uva.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`, `imagen`) VALUES
(1, 'Admin', 'Admin', 'admin@admin.com ', 'contraseña', 'admin', NULL),
(2, 'Juan', 'Pérez', 'juan@ejemplo.com', 'contraseña123', 'cliente', NULL),
(3, 'Maria', 'López', 'maria@ejemplo.com', 'maria123', 'cliente', NULL),
(4, 'ignacio', 'palomar', 'ignacio78787@gmail.com', '$2y$10$PRmDbHLcmoikue1rLFI62u4pckWBFh/TerKx1iXL8WRcNE1fdSYMC', 'admin', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_linea_pedido` (`pedido_id`),
  ADD KEY `fk_linea_producto` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_usuario` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_categoria` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas_pedidos`
--
ALTER TABLE `lineas_pedidos`
  ADD CONSTRAINT `fk_linea_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_linea_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
