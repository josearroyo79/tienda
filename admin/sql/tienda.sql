-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-01-2020 a las 18:55:31
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--
CREATE DATABASE IF NOT EXISTS `tienda` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `tienda`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` text COLLATE utf8_spanish_ci NOT NULL,
  `marca` text COLLATE utf8_spanish_ci NOT NULL,
  `precio` text COLLATE utf8_spanish_ci NOT NULL,
  `unidades` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `tipo`, `marca`, `precio`, `unidades`, `imagen`) VALUES
(2, 'CamiÃ³n de bomberos', '6-10', 'Playmobil', '180.94', '15', '83ca376134160b7e5c983a7224e1142c.jpeg'),
(3, 'Moto de juguete', '6-10', 'Ducati', '124.19', '3', '27706b97c8612922e2c944477157532d.jpeg'),
(4, 'MuÃ±eco Baby Boom', '3-6', 'BabyBoom', '45.99', '54', 'ab635b9564a5700e86eee5eaffd4f63a.jpeg'),
(5, 'Oso de Peluche', '0-3', 'Douglas', '14.95', '7', '4b4de8b0457dcbb4f26f0115630db23f.jpeg'),
(6, 'Monopoly', '6-10', 'Monopoly', '19.99', '8', '788cf11e62a68e565831572330576c55.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` text COLLATE utf8_spanish_ci NOT NULL,
  `correo` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(9) NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `correo`, `password`, `tipo`, `telefono`, `imagen`, `fecha`) VALUES
(42, 'Administrador', 'Admin', 'admin@admin.com', 'admin', 'ADMIN', 654654654, '480c32be7c507eb4946e4b511809737b.png', '01/01/2020'),
(43, 'Pepito', 'Prueba', 'prueba@prueba.com', 'prueba', 'USER', 666666666, '06e466d1c9bb911b315f988803dabbf4.png', '27/01/2020');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
