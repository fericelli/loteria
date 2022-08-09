-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2018 a las 15:12:45
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apuestas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apuesta`
--

CREATE TABLE `apuesta` (
  `codigo` varchar(40) NOT NULL,
  `jugada` varchar(20) NOT NULL,
  `loteria` varchar(40) NOT NULL,
  `banca` varchar(20) NOT NULL,
  `ganancia` int(11) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(40) NOT NULL,
  `sorteo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `apuesta`
--

INSERT INTO `apuesta` (`codigo`, `jugada`, `loteria`, `banca`, `ganancia`, `fecha`, `hora`, `sorteo`) VALUES
('javier-6197502843', 'Toro', 'Animalitos', 'javier', 4000, '2018-09-26', '10:09:36', '16:00'),
('javier-6197502843', 'Ciempiés', 'Animalitos', 'javier', 4000, '2018-09-26', '10:09:36', '16:00'),
('javier-6197502843', 'Rana', 'Animalitos', 'javier', 4000, '2018-09-26', '10:09:36', '16:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancas`
--

CREATE TABLE `bancas` (
  `nombre` varchar(40) NOT NULL,
  `usuario` varchar(40) NOT NULL,
  `creador` varchar(50) NOT NULL,
  `usuariocreador` varchar(50) NOT NULL,
  `bloqueo` varchar(2) NOT NULL,
  `porcentageganancia` double NOT NULL,
  `mac` varchar(40) NOT NULL,
  `ultimasesion` varchar(40) NOT NULL,
  `telefono` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bancas`
--

INSERT INTO `bancas` (`nombre`, `usuario`, `creador`, `usuariocreador`, `bloqueo`, `porcentageganancia`, `mac`, `ultimasesion`, `telefono`) VALUES
('dani', 'dani', 'recolector', 'daniela', 'no', 10, '', '', '648661'),
('Prueba', 'Prueba', 'administrador', 'Admin', 'no', 0, '', '', '244'),
('la china', 'lachina', 'recolector', 'daniela', 'no', 15, '', '', '04241935349'),
('aaa', 'aa', 'administrador', 'admin', 'no', 14, '', '', '556466'),
('javier', 'javier', 'administrador', 'admin', 'no', 10, '', '', '33553'),
('toñin', 'toñin', 'administrador', 'admin', 'no', 10, '', '', '1212121212');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlapuesta`
--

CREATE TABLE `controlapuesta` (
  `banca` varchar(40) NOT NULL,
  `loteria` varchar(40) NOT NULL,
  `sorteo` varchar(60) NOT NULL,
  `apuesta` double NOT NULL,
  `ganancia` double NOT NULL,
  `hora` varchar(15) NOT NULL,
  `jugada` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `controlapuesta`
--

INSERT INTO `controlapuesta` (`banca`, `loteria`, `sorteo`, `apuesta`, `ganancia`, `hora`, `jugada`) VALUES
('javier', 'Animalitos', '11:00', 1000, 40000, '20:09:43', 'Camello'),
('javier', 'Animalitos', '11:00', 1000, 40000, '20:09:43', 'Cebra'),
('javier', 'Animalitos', '11:00', 1000, 40000, '20:09:43', 'Iguana'),
('javier', 'Animalitos', '11:00', 1000, 40000, '20:09:43', 'Pavo Real');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controldinero`
--

CREATE TABLE `controldinero` (
  `banca` varchar(40) NOT NULL,
  `usuariocreador` varchar(40) NOT NULL,
  `fecha` varchar(40) NOT NULL,
  `sorteo` varchar(40) NOT NULL,
  `gananciabanca` double NOT NULL,
  `gananciarecolector` double NOT NULL,
  `ganancia` double NOT NULL,
  `pagorecolector` varchar(10) NOT NULL,
  `premiosresponsables` double NOT NULL,
  `loteria` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `controldinero`
--

INSERT INTO `controldinero` (`banca`, `usuariocreador`, `fecha`, `sorteo`, `gananciabanca`, `gananciarecolector`, `ganancia`, `pagorecolector`, `premiosresponsables`, `loteria`) VALUES
('dani', 'daniela', '2018-01-25', '09:00', 4800, 2400, 800, '', 0, 'Animalitos'),
('la china', 'daniela', '2018-01-25', '09:00', 4800, 2400, 800, '', 0, 'Animalitos'),
('aaa', 'administrador', '2018-12-05', '09:00', 42, 0, 258, '', 0, 'Animalitos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controldinerobanca`
--

CREATE TABLE `controldinerobanca` (
  `banca` varchar(40) NOT NULL,
  `usuariocreador` varchar(40) NOT NULL,
  `tipodeusuariocreador` varchar(40) NOT NULL,
  `loteria` varchar(40) NOT NULL,
  `fecha` varchar(40) NOT NULL,
  `sorteo` varchar(40) NOT NULL,
  `dinero` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `controldinerobanca`
--

INSERT INTO `controldinerobanca` (`banca`, `usuariocreador`, `tipodeusuariocreador`, `loteria`, `fecha`, `sorteo`, `dinero`) VALUES
('dani', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '10:00', 0),
('dani', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '11:00', 0),
('dani', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '12:00', 0),
('dani', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '13:00', 0),
('dani', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '16:00', 0),
('dani', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '17:00', 0),
('dani', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '18:00', 0),
('dani', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '19:00', 0),
('la china', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '10:00', 0),
('la china', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '11:00', 0),
('la china', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '12:00', 0),
('la china', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '13:00', 0),
('la china', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '16:00', 0),
('la china', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '17:00', 0),
('la china', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '18:00', 0),
('la china', 'daniela', 'recolector', 'Animalitos', '2018-01-25', '19:00', 0),
('javier', 'administrador', 'administrador', 'Animalitos', '2018-09-26', '09:00', 0),
('javier', 'administrador', 'administrador', 'Animalitos', '2018-09-26', '10:00', 0),
('javier', 'administrador', 'administrador', 'Animalitos', '2018-09-26', '11:00', 0),
('javier', 'administrador', 'administrador', 'Animalitos', '2018-09-26', '12:00', 0),
('javier', 'administrador', 'administrador', 'Animalitos', '2018-09-26', '13:00', 0),
('javier', 'administrador', 'administrador', 'Animalitos', '2018-09-26', '16:00', 300),
('javier', 'administrador', 'administrador', 'Animalitos', '2018-09-26', '17:00', 0),
('javier', 'administrador', 'administrador', 'Animalitos', '2018-09-26', '18:00', 0),
('javier', 'administrador', 'administrador', 'Animalitos', '2018-09-26', '19:00', 0),
('aaa', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '10:00', 0),
('aaa', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '11:00', 0),
('aaa', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '12:00', 0),
('aaa', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '13:00', 0),
('aaa', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '16:00', 0),
('aaa', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '17:00', 0),
('aaa', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '18:00', 0),
('aaa', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '19:00', 0),
('toñin', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '10:00', 0),
('toñin', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '11:00', 0),
('toñin', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '12:00', 0),
('toñin', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '13:00', 0),
('toñin', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '16:00', 0),
('toñin', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '17:00', 0),
('toñin', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '18:00', 0),
('toñin', 'administrador', 'administrador', 'Animalitos', '2018-12-05', '19:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlsorteo`
--

CREATE TABLE `controlsorteo` (
  `fecha` varchar(50) NOT NULL,
  `sorteo` varchar(50) NOT NULL,
  `loteria` varchar(50) NOT NULL,
  `jugada` varchar(50) NOT NULL,
  `dinero` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `controlsorteo`
--

INSERT INTO `controlsorteo` (`fecha`, `sorteo`, `loteria`, `jugada`, `dinero`) VALUES
('2018-12-05', '10:00', 'Animalitos', 'Águila', 0),
('2018-12-05', '10:00', 'Animalitos', 'Alacrán', 0),
('2018-12-05', '10:00', 'Animalitos', 'Araña', 0),
('2018-12-05', '10:00', 'Animalitos', 'Ardilla', 0),
('2018-12-05', '10:00', 'Animalitos', 'Ballena', 0),
('2018-12-05', '10:00', 'Animalitos', 'Búho', 0),
('2018-12-05', '10:00', 'Animalitos', 'Burro', 0),
('2018-12-05', '10:00', 'Animalitos', 'Caballo', 0),
('2018-12-05', '10:00', 'Animalitos', 'Caimán', 0),
('2018-12-05', '10:00', 'Animalitos', 'Camello', 0),
('2018-12-05', '10:00', 'Animalitos', 'Carnero', 0),
('2018-12-05', '10:00', 'Animalitos', 'Cebra', 0),
('2018-12-05', '10:00', 'Animalitos', 'Chivo', 0),
('2018-12-05', '10:00', 'Animalitos', 'Ciempiés', 0),
('2018-12-05', '10:00', 'Animalitos', 'Cochino', 0),
('2018-12-05', '10:00', 'Animalitos', 'Conejo', 0),
('2018-12-05', '10:00', 'Animalitos', 'Culebra', 0),
('2018-12-05', '10:00', 'Animalitos', 'Delfín', 0),
('2018-12-05', '10:00', 'Animalitos', 'Elefante', 0),
('2018-12-05', '10:00', 'Animalitos', 'Gallina', 0),
('2018-12-05', '10:00', 'Animalitos', 'Gallo', 0),
('2018-12-05', '10:00', 'Animalitos', 'Gato', 0),
('2018-12-05', '10:00', 'Animalitos', 'Hipopótamo', 0),
('2018-12-05', '10:00', 'Animalitos', 'Hormiga', 0),
('2018-12-05', '10:00', 'Animalitos', 'Iguana', 0),
('2018-12-05', '10:00', 'Animalitos', 'Jirafa', 0),
('2018-12-05', '10:00', 'Animalitos', 'Lapa', 0),
('2018-12-05', '10:00', 'Animalitos', 'León', 0),
('2018-12-05', '10:00', 'Animalitos', 'Mono', 0),
('2018-12-05', '10:00', 'Animalitos', 'Murciélago', 0),
('2018-12-05', '10:00', 'Animalitos', 'Oso', 0),
('2018-12-05', '10:00', 'Animalitos', 'Oveja', 0),
('2018-12-05', '10:00', 'Animalitos', 'Paloma', 0),
('2018-12-05', '10:00', 'Animalitos', 'Pavo', 0),
('2018-12-05', '10:00', 'Animalitos', 'Pavo Real', 0),
('2018-12-05', '10:00', 'Animalitos', 'Perico', 0),
('2018-12-05', '10:00', 'Animalitos', 'Perro', 0),
('2018-12-05', '10:00', 'Animalitos', 'Pescado', 0),
('2018-12-05', '10:00', 'Animalitos', 'Pulpo', 0),
('2018-12-05', '10:00', 'Animalitos', 'Rana', 0),
('2018-12-05', '10:00', 'Animalitos', 'Ratón', 0),
('2018-12-05', '10:00', 'Animalitos', 'Tigre', 0),
('2018-12-05', '10:00', 'Animalitos', 'Toro', 0),
('2018-12-05', '10:00', 'Animalitos', 'Tortuga', 0),
('2018-12-05', '10:00', 'Animalitos', 'Vaca', 0),
('2018-12-05', '10:00', 'Animalitos', 'Venado', 0),
('2018-12-05', '10:00', 'Animalitos', 'Zamuro', 0),
('2018-12-05', '10:00', 'Animalitos', 'Zorro', 0),
('2018-12-05', '11:00', 'Animalitos', 'Águila', 0),
('2018-12-05', '11:00', 'Animalitos', 'Alacrán', 0),
('2018-12-05', '11:00', 'Animalitos', 'Araña', 0),
('2018-12-05', '11:00', 'Animalitos', 'Ardilla', 0),
('2018-12-05', '11:00', 'Animalitos', 'Ballena', 0),
('2018-12-05', '11:00', 'Animalitos', 'Búho', 0),
('2018-12-05', '11:00', 'Animalitos', 'Burro', 0),
('2018-12-05', '11:00', 'Animalitos', 'Caballo', 0),
('2018-12-05', '11:00', 'Animalitos', 'Caimán', 0),
('2018-12-05', '11:00', 'Animalitos', 'Camello', 0),
('2018-12-05', '11:00', 'Animalitos', 'Carnero', 0),
('2018-12-05', '11:00', 'Animalitos', 'Cebra', 0),
('2018-12-05', '11:00', 'Animalitos', 'Chivo', 0),
('2018-12-05', '11:00', 'Animalitos', 'Ciempiés', 0),
('2018-12-05', '11:00', 'Animalitos', 'Cochino', 0),
('2018-12-05', '11:00', 'Animalitos', 'Conejo', 0),
('2018-12-05', '11:00', 'Animalitos', 'Culebra', 0),
('2018-12-05', '11:00', 'Animalitos', 'Delfín', 0),
('2018-12-05', '11:00', 'Animalitos', 'Elefante', 0),
('2018-12-05', '11:00', 'Animalitos', 'Gallina', 0),
('2018-12-05', '11:00', 'Animalitos', 'Gallo', 0),
('2018-12-05', '11:00', 'Animalitos', 'Gato', 0),
('2018-12-05', '11:00', 'Animalitos', 'Hipopótamo', 0),
('2018-12-05', '11:00', 'Animalitos', 'Hormiga', 0),
('2018-12-05', '11:00', 'Animalitos', 'Iguana', 0),
('2018-12-05', '11:00', 'Animalitos', 'Jirafa', 0),
('2018-12-05', '11:00', 'Animalitos', 'Lapa', 0),
('2018-12-05', '11:00', 'Animalitos', 'León', 0),
('2018-12-05', '11:00', 'Animalitos', 'Mono', 0),
('2018-12-05', '11:00', 'Animalitos', 'Murciélago', 0),
('2018-12-05', '11:00', 'Animalitos', 'Oso', 0),
('2018-12-05', '11:00', 'Animalitos', 'Oveja', 0),
('2018-12-05', '11:00', 'Animalitos', 'Paloma', 0),
('2018-12-05', '11:00', 'Animalitos', 'Pavo', 0),
('2018-12-05', '11:00', 'Animalitos', 'Pavo Real', 0),
('2018-12-05', '11:00', 'Animalitos', 'Perico', 0),
('2018-12-05', '11:00', 'Animalitos', 'Perro', 0),
('2018-12-05', '11:00', 'Animalitos', 'Pescado', 0),
('2018-12-05', '11:00', 'Animalitos', 'Pulpo', 0),
('2018-12-05', '11:00', 'Animalitos', 'Rana', 0),
('2018-12-05', '11:00', 'Animalitos', 'Ratón', 0),
('2018-12-05', '11:00', 'Animalitos', 'Tigre', 0),
('2018-12-05', '11:00', 'Animalitos', 'Toro', 0),
('2018-12-05', '11:00', 'Animalitos', 'Tortuga', 0),
('2018-12-05', '11:00', 'Animalitos', 'Vaca', 0),
('2018-12-05', '11:00', 'Animalitos', 'Venado', 0),
('2018-12-05', '11:00', 'Animalitos', 'Zamuro', 0),
('2018-12-05', '11:00', 'Animalitos', 'Zorro', 0),
('2018-12-05', '12:00', 'Animalitos', 'Águila', 0),
('2018-12-05', '12:00', 'Animalitos', 'Alacrán', 0),
('2018-12-05', '12:00', 'Animalitos', 'Araña', 0),
('2018-12-05', '12:00', 'Animalitos', 'Ardilla', 0),
('2018-12-05', '12:00', 'Animalitos', 'Ballena', 0),
('2018-12-05', '12:00', 'Animalitos', 'Búho', 0),
('2018-12-05', '12:00', 'Animalitos', 'Burro', 0),
('2018-12-05', '12:00', 'Animalitos', 'Caballo', 0),
('2018-12-05', '12:00', 'Animalitos', 'Caimán', 0),
('2018-12-05', '12:00', 'Animalitos', 'Camello', 0),
('2018-12-05', '12:00', 'Animalitos', 'Carnero', 0),
('2018-12-05', '12:00', 'Animalitos', 'Cebra', 0),
('2018-12-05', '12:00', 'Animalitos', 'Chivo', 0),
('2018-12-05', '12:00', 'Animalitos', 'Ciempiés', 0),
('2018-12-05', '12:00', 'Animalitos', 'Cochino', 0),
('2018-12-05', '12:00', 'Animalitos', 'Conejo', 0),
('2018-12-05', '12:00', 'Animalitos', 'Culebra', 0),
('2018-12-05', '12:00', 'Animalitos', 'Delfín', 0),
('2018-12-05', '12:00', 'Animalitos', 'Elefante', 0),
('2018-12-05', '12:00', 'Animalitos', 'Gallina', 0),
('2018-12-05', '12:00', 'Animalitos', 'Gallo', 0),
('2018-12-05', '12:00', 'Animalitos', 'Gato', 0),
('2018-12-05', '12:00', 'Animalitos', 'Hipopótamo', 0),
('2018-12-05', '12:00', 'Animalitos', 'Hormiga', 0),
('2018-12-05', '12:00', 'Animalitos', 'Iguana', 0),
('2018-12-05', '12:00', 'Animalitos', 'Jirafa', 0),
('2018-12-05', '12:00', 'Animalitos', 'Lapa', 0),
('2018-12-05', '12:00', 'Animalitos', 'León', 0),
('2018-12-05', '12:00', 'Animalitos', 'Mono', 0),
('2018-12-05', '12:00', 'Animalitos', 'Murciélago', 0),
('2018-12-05', '12:00', 'Animalitos', 'Oso', 0),
('2018-12-05', '12:00', 'Animalitos', 'Oveja', 0),
('2018-12-05', '12:00', 'Animalitos', 'Paloma', 0),
('2018-12-05', '12:00', 'Animalitos', 'Pavo', 0),
('2018-12-05', '12:00', 'Animalitos', 'Pavo Real', 0),
('2018-12-05', '12:00', 'Animalitos', 'Perico', 0),
('2018-12-05', '12:00', 'Animalitos', 'Perro', 0),
('2018-12-05', '12:00', 'Animalitos', 'Pescado', 0),
('2018-12-05', '12:00', 'Animalitos', 'Pulpo', 0),
('2018-12-05', '12:00', 'Animalitos', 'Rana', 0),
('2018-12-05', '12:00', 'Animalitos', 'Ratón', 0),
('2018-12-05', '12:00', 'Animalitos', 'Tigre', 0),
('2018-12-05', '12:00', 'Animalitos', 'Toro', 0),
('2018-12-05', '12:00', 'Animalitos', 'Tortuga', 0),
('2018-12-05', '12:00', 'Animalitos', 'Vaca', 0),
('2018-12-05', '12:00', 'Animalitos', 'Venado', 0),
('2018-12-05', '12:00', 'Animalitos', 'Zamuro', 0),
('2018-12-05', '12:00', 'Animalitos', 'Zorro', 0),
('2018-12-05', '13:00', 'Animalitos', 'Águila', 0),
('2018-12-05', '13:00', 'Animalitos', 'Alacrán', 0),
('2018-12-05', '13:00', 'Animalitos', 'Araña', 0),
('2018-12-05', '13:00', 'Animalitos', 'Ardilla', 0),
('2018-12-05', '13:00', 'Animalitos', 'Ballena', 0),
('2018-12-05', '13:00', 'Animalitos', 'Búho', 0),
('2018-12-05', '13:00', 'Animalitos', 'Burro', 0),
('2018-12-05', '13:00', 'Animalitos', 'Caballo', 0),
('2018-12-05', '13:00', 'Animalitos', 'Caimán', 0),
('2018-12-05', '13:00', 'Animalitos', 'Camello', 0),
('2018-12-05', '13:00', 'Animalitos', 'Carnero', 0),
('2018-12-05', '13:00', 'Animalitos', 'Cebra', 0),
('2018-12-05', '13:00', 'Animalitos', 'Chivo', 0),
('2018-12-05', '13:00', 'Animalitos', 'Ciempiés', 0),
('2018-12-05', '13:00', 'Animalitos', 'Cochino', 0),
('2018-12-05', '13:00', 'Animalitos', 'Conejo', 0),
('2018-12-05', '13:00', 'Animalitos', 'Culebra', 0),
('2018-12-05', '13:00', 'Animalitos', 'Delfín', 0),
('2018-12-05', '13:00', 'Animalitos', 'Elefante', 0),
('2018-12-05', '13:00', 'Animalitos', 'Gallina', 0),
('2018-12-05', '13:00', 'Animalitos', 'Gallo', 0),
('2018-12-05', '13:00', 'Animalitos', 'Gato', 0),
('2018-12-05', '13:00', 'Animalitos', 'Hipopótamo', 0),
('2018-12-05', '13:00', 'Animalitos', 'Hormiga', 0),
('2018-12-05', '13:00', 'Animalitos', 'Iguana', 0),
('2018-12-05', '13:00', 'Animalitos', 'Jirafa', 0),
('2018-12-05', '13:00', 'Animalitos', 'Lapa', 0),
('2018-12-05', '13:00', 'Animalitos', 'León', 0),
('2018-12-05', '13:00', 'Animalitos', 'Mono', 0),
('2018-12-05', '13:00', 'Animalitos', 'Murciélago', 0),
('2018-12-05', '13:00', 'Animalitos', 'Oso', 0),
('2018-12-05', '13:00', 'Animalitos', 'Oveja', 0),
('2018-12-05', '13:00', 'Animalitos', 'Paloma', 0),
('2018-12-05', '13:00', 'Animalitos', 'Pavo', 0),
('2018-12-05', '13:00', 'Animalitos', 'Pavo Real', 0),
('2018-12-05', '13:00', 'Animalitos', 'Perico', 0),
('2018-12-05', '13:00', 'Animalitos', 'Perro', 0),
('2018-12-05', '13:00', 'Animalitos', 'Pescado', 0),
('2018-12-05', '13:00', 'Animalitos', 'Pulpo', 0),
('2018-12-05', '13:00', 'Animalitos', 'Rana', 0),
('2018-12-05', '13:00', 'Animalitos', 'Ratón', 0),
('2018-12-05', '13:00', 'Animalitos', 'Tigre', 0),
('2018-12-05', '13:00', 'Animalitos', 'Toro', 0),
('2018-12-05', '13:00', 'Animalitos', 'Tortuga', 0),
('2018-12-05', '13:00', 'Animalitos', 'Vaca', 0),
('2018-12-05', '13:00', 'Animalitos', 'Venado', 0),
('2018-12-05', '13:00', 'Animalitos', 'Zamuro', 0),
('2018-12-05', '13:00', 'Animalitos', 'Zorro', 0),
('2018-12-05', '16:00', 'Animalitos', 'Águila', 0),
('2018-12-05', '16:00', 'Animalitos', 'Alacrán', 0),
('2018-12-05', '16:00', 'Animalitos', 'Araña', 0),
('2018-12-05', '16:00', 'Animalitos', 'Ardilla', 0),
('2018-12-05', '16:00', 'Animalitos', 'Ballena', 0),
('2018-12-05', '16:00', 'Animalitos', 'Búho', 0),
('2018-12-05', '16:00', 'Animalitos', 'Burro', 0),
('2018-12-05', '16:00', 'Animalitos', 'Caballo', 0),
('2018-12-05', '16:00', 'Animalitos', 'Caimán', 0),
('2018-12-05', '16:00', 'Animalitos', 'Camello', 0),
('2018-12-05', '16:00', 'Animalitos', 'Carnero', 0),
('2018-12-05', '16:00', 'Animalitos', 'Cebra', 0),
('2018-12-05', '16:00', 'Animalitos', 'Chivo', 0),
('2018-12-05', '16:00', 'Animalitos', 'Ciempiés', 0),
('2018-12-05', '16:00', 'Animalitos', 'Cochino', 0),
('2018-12-05', '16:00', 'Animalitos', 'Conejo', 0),
('2018-12-05', '16:00', 'Animalitos', 'Culebra', 0),
('2018-12-05', '16:00', 'Animalitos', 'Delfín', 0),
('2018-12-05', '16:00', 'Animalitos', 'Elefante', 0),
('2018-12-05', '16:00', 'Animalitos', 'Gallina', 0),
('2018-12-05', '16:00', 'Animalitos', 'Gallo', 0),
('2018-12-05', '16:00', 'Animalitos', 'Gato', 0),
('2018-12-05', '16:00', 'Animalitos', 'Hipopótamo', 0),
('2018-12-05', '16:00', 'Animalitos', 'Hormiga', 0),
('2018-12-05', '16:00', 'Animalitos', 'Iguana', 0),
('2018-12-05', '16:00', 'Animalitos', 'Jirafa', 0),
('2018-12-05', '16:00', 'Animalitos', 'Lapa', 0),
('2018-12-05', '16:00', 'Animalitos', 'León', 0),
('2018-12-05', '16:00', 'Animalitos', 'Mono', 0),
('2018-12-05', '16:00', 'Animalitos', 'Murciélago', 0),
('2018-12-05', '16:00', 'Animalitos', 'Oso', 0),
('2018-12-05', '16:00', 'Animalitos', 'Oveja', 0),
('2018-12-05', '16:00', 'Animalitos', 'Paloma', 0),
('2018-12-05', '16:00', 'Animalitos', 'Pavo', 0),
('2018-12-05', '16:00', 'Animalitos', 'Pavo Real', 0),
('2018-12-05', '16:00', 'Animalitos', 'Perico', 0),
('2018-12-05', '16:00', 'Animalitos', 'Perro', 0),
('2018-12-05', '16:00', 'Animalitos', 'Pescado', 0),
('2018-12-05', '16:00', 'Animalitos', 'Pulpo', 0),
('2018-12-05', '16:00', 'Animalitos', 'Rana', 0),
('2018-12-05', '16:00', 'Animalitos', 'Ratón', 0),
('2018-12-05', '16:00', 'Animalitos', 'Tigre', 0),
('2018-12-05', '16:00', 'Animalitos', 'Toro', 0),
('2018-12-05', '16:00', 'Animalitos', 'Tortuga', 0),
('2018-12-05', '16:00', 'Animalitos', 'Vaca', 0),
('2018-12-05', '16:00', 'Animalitos', 'Venado', 0),
('2018-12-05', '16:00', 'Animalitos', 'Zamuro', 0),
('2018-12-05', '16:00', 'Animalitos', 'Zorro', 0),
('2018-12-05', '17:00', 'Animalitos', 'Águila', 0),
('2018-12-05', '17:00', 'Animalitos', 'Alacrán', 0),
('2018-12-05', '17:00', 'Animalitos', 'Araña', 0),
('2018-12-05', '17:00', 'Animalitos', 'Ardilla', 0),
('2018-12-05', '17:00', 'Animalitos', 'Ballena', 0),
('2018-12-05', '17:00', 'Animalitos', 'Búho', 0),
('2018-12-05', '17:00', 'Animalitos', 'Burro', 0),
('2018-12-05', '17:00', 'Animalitos', 'Caballo', 0),
('2018-12-05', '17:00', 'Animalitos', 'Caimán', 0),
('2018-12-05', '17:00', 'Animalitos', 'Camello', 0),
('2018-12-05', '17:00', 'Animalitos', 'Carnero', 0),
('2018-12-05', '17:00', 'Animalitos', 'Cebra', 0),
('2018-12-05', '17:00', 'Animalitos', 'Chivo', 0),
('2018-12-05', '17:00', 'Animalitos', 'Ciempiés', 0),
('2018-12-05', '17:00', 'Animalitos', 'Cochino', 0),
('2018-12-05', '17:00', 'Animalitos', 'Conejo', 0),
('2018-12-05', '17:00', 'Animalitos', 'Culebra', 0),
('2018-12-05', '17:00', 'Animalitos', 'Delfín', 0),
('2018-12-05', '17:00', 'Animalitos', 'Elefante', 0),
('2018-12-05', '17:00', 'Animalitos', 'Gallina', 0),
('2018-12-05', '17:00', 'Animalitos', 'Gallo', 0),
('2018-12-05', '17:00', 'Animalitos', 'Gato', 0),
('2018-12-05', '17:00', 'Animalitos', 'Hipopótamo', 0),
('2018-12-05', '17:00', 'Animalitos', 'Hormiga', 0),
('2018-12-05', '17:00', 'Animalitos', 'Iguana', 0),
('2018-12-05', '17:00', 'Animalitos', 'Jirafa', 0),
('2018-12-05', '17:00', 'Animalitos', 'Lapa', 0),
('2018-12-05', '17:00', 'Animalitos', 'León', 0),
('2018-12-05', '17:00', 'Animalitos', 'Mono', 0),
('2018-12-05', '17:00', 'Animalitos', 'Murciélago', 0),
('2018-12-05', '17:00', 'Animalitos', 'Oso', 0),
('2018-12-05', '17:00', 'Animalitos', 'Oveja', 0),
('2018-12-05', '17:00', 'Animalitos', 'Paloma', 0),
('2018-12-05', '17:00', 'Animalitos', 'Pavo', 0),
('2018-12-05', '17:00', 'Animalitos', 'Pavo Real', 0),
('2018-12-05', '17:00', 'Animalitos', 'Perico', 0),
('2018-12-05', '17:00', 'Animalitos', 'Perro', 0),
('2018-12-05', '17:00', 'Animalitos', 'Pescado', 0),
('2018-12-05', '17:00', 'Animalitos', 'Pulpo', 0),
('2018-12-05', '17:00', 'Animalitos', 'Rana', 0),
('2018-12-05', '17:00', 'Animalitos', 'Ratón', 0),
('2018-12-05', '17:00', 'Animalitos', 'Tigre', 0),
('2018-12-05', '17:00', 'Animalitos', 'Toro', 0),
('2018-12-05', '17:00', 'Animalitos', 'Tortuga', 0),
('2018-12-05', '17:00', 'Animalitos', 'Vaca', 0),
('2018-12-05', '17:00', 'Animalitos', 'Venado', 0),
('2018-12-05', '17:00', 'Animalitos', 'Zamuro', 0),
('2018-12-05', '17:00', 'Animalitos', 'Zorro', 0),
('2018-12-05', '18:00', 'Animalitos', 'Águila', 0),
('2018-12-05', '18:00', 'Animalitos', 'Alacrán', 0),
('2018-12-05', '18:00', 'Animalitos', 'Araña', 0),
('2018-12-05', '18:00', 'Animalitos', 'Ardilla', 0),
('2018-12-05', '18:00', 'Animalitos', 'Ballena', 0),
('2018-12-05', '18:00', 'Animalitos', 'Búho', 0),
('2018-12-05', '18:00', 'Animalitos', 'Burro', 0),
('2018-12-05', '18:00', 'Animalitos', 'Caballo', 0),
('2018-12-05', '18:00', 'Animalitos', 'Caimán', 0),
('2018-12-05', '18:00', 'Animalitos', 'Camello', 0),
('2018-12-05', '18:00', 'Animalitos', 'Carnero', 0),
('2018-12-05', '18:00', 'Animalitos', 'Cebra', 0),
('2018-12-05', '18:00', 'Animalitos', 'Chivo', 0),
('2018-12-05', '18:00', 'Animalitos', 'Ciempiés', 0),
('2018-12-05', '18:00', 'Animalitos', 'Cochino', 0),
('2018-12-05', '18:00', 'Animalitos', 'Conejo', 0),
('2018-12-05', '18:00', 'Animalitos', 'Culebra', 0),
('2018-12-05', '18:00', 'Animalitos', 'Delfín', 0),
('2018-12-05', '18:00', 'Animalitos', 'Elefante', 0),
('2018-12-05', '18:00', 'Animalitos', 'Gallina', 0),
('2018-12-05', '18:00', 'Animalitos', 'Gallo', 0),
('2018-12-05', '18:00', 'Animalitos', 'Gato', 0),
('2018-12-05', '18:00', 'Animalitos', 'Hipopótamo', 0),
('2018-12-05', '18:00', 'Animalitos', 'Hormiga', 0),
('2018-12-05', '18:00', 'Animalitos', 'Iguana', 0),
('2018-12-05', '18:00', 'Animalitos', 'Jirafa', 0),
('2018-12-05', '18:00', 'Animalitos', 'Lapa', 0),
('2018-12-05', '18:00', 'Animalitos', 'León', 0),
('2018-12-05', '18:00', 'Animalitos', 'Mono', 0),
('2018-12-05', '18:00', 'Animalitos', 'Murciélago', 0),
('2018-12-05', '18:00', 'Animalitos', 'Oso', 0),
('2018-12-05', '18:00', 'Animalitos', 'Oveja', 0),
('2018-12-05', '18:00', 'Animalitos', 'Paloma', 0),
('2018-12-05', '18:00', 'Animalitos', 'Pavo', 0),
('2018-12-05', '18:00', 'Animalitos', 'Pavo Real', 0),
('2018-12-05', '18:00', 'Animalitos', 'Perico', 0),
('2018-12-05', '18:00', 'Animalitos', 'Perro', 0),
('2018-12-05', '18:00', 'Animalitos', 'Pescado', 0),
('2018-12-05', '18:00', 'Animalitos', 'Pulpo', 0),
('2018-12-05', '18:00', 'Animalitos', 'Rana', 0),
('2018-12-05', '18:00', 'Animalitos', 'Ratón', 0),
('2018-12-05', '18:00', 'Animalitos', 'Tigre', 0),
('2018-12-05', '18:00', 'Animalitos', 'Toro', 0),
('2018-12-05', '18:00', 'Animalitos', 'Tortuga', 0),
('2018-12-05', '18:00', 'Animalitos', 'Vaca', 0),
('2018-12-05', '18:00', 'Animalitos', 'Venado', 0),
('2018-12-05', '18:00', 'Animalitos', 'Zamuro', 0),
('2018-12-05', '18:00', 'Animalitos', 'Zorro', 0),
('2018-12-05', '19:00', 'Animalitos', 'Águila', 0),
('2018-12-05', '19:00', 'Animalitos', 'Alacrán', 0),
('2018-12-05', '19:00', 'Animalitos', 'Araña', 0),
('2018-12-05', '19:00', 'Animalitos', 'Ardilla', 0),
('2018-12-05', '19:00', 'Animalitos', 'Ballena', 0),
('2018-12-05', '19:00', 'Animalitos', 'Búho', 0),
('2018-12-05', '19:00', 'Animalitos', 'Burro', 0),
('2018-12-05', '19:00', 'Animalitos', 'Caballo', 0),
('2018-12-05', '19:00', 'Animalitos', 'Caimán', 0),
('2018-12-05', '19:00', 'Animalitos', 'Camello', 0),
('2018-12-05', '19:00', 'Animalitos', 'Carnero', 0),
('2018-12-05', '19:00', 'Animalitos', 'Cebra', 0),
('2018-12-05', '19:00', 'Animalitos', 'Chivo', 0),
('2018-12-05', '19:00', 'Animalitos', 'Ciempiés', 0),
('2018-12-05', '19:00', 'Animalitos', 'Cochino', 0),
('2018-12-05', '19:00', 'Animalitos', 'Conejo', 0),
('2018-12-05', '19:00', 'Animalitos', 'Culebra', 0),
('2018-12-05', '19:00', 'Animalitos', 'Delfín', 0),
('2018-12-05', '19:00', 'Animalitos', 'Elefante', 0),
('2018-12-05', '19:00', 'Animalitos', 'Gallina', 0),
('2018-12-05', '19:00', 'Animalitos', 'Gallo', 0),
('2018-12-05', '19:00', 'Animalitos', 'Gato', 0),
('2018-12-05', '19:00', 'Animalitos', 'Hipopótamo', 0),
('2018-12-05', '19:00', 'Animalitos', 'Hormiga', 0),
('2018-12-05', '19:00', 'Animalitos', 'Iguana', 0),
('2018-12-05', '19:00', 'Animalitos', 'Jirafa', 0),
('2018-12-05', '19:00', 'Animalitos', 'Lapa', 0),
('2018-12-05', '19:00', 'Animalitos', 'León', 0),
('2018-12-05', '19:00', 'Animalitos', 'Mono', 0),
('2018-12-05', '19:00', 'Animalitos', 'Murciélago', 0),
('2018-12-05', '19:00', 'Animalitos', 'Oso', 0),
('2018-12-05', '19:00', 'Animalitos', 'Oveja', 0),
('2018-12-05', '19:00', 'Animalitos', 'Paloma', 0),
('2018-12-05', '19:00', 'Animalitos', 'Pavo', 0),
('2018-12-05', '19:00', 'Animalitos', 'Pavo Real', 0),
('2018-12-05', '19:00', 'Animalitos', 'Perico', 0),
('2018-12-05', '19:00', 'Animalitos', 'Perro', 0),
('2018-12-05', '19:00', 'Animalitos', 'Pescado', 0),
('2018-12-05', '19:00', 'Animalitos', 'Pulpo', 0),
('2018-12-05', '19:00', 'Animalitos', 'Rana', 0),
('2018-12-05', '19:00', 'Animalitos', 'Ratón', 0),
('2018-12-05', '19:00', 'Animalitos', 'Tigre', 0),
('2018-12-05', '19:00', 'Animalitos', 'Toro', 0),
('2018-12-05', '19:00', 'Animalitos', 'Tortuga', 0),
('2018-12-05', '19:00', 'Animalitos', 'Vaca', 0),
('2018-12-05', '19:00', 'Animalitos', 'Venado', 0),
('2018-12-05', '19:00', 'Animalitos', 'Zamuro', 0),
('2018-12-05', '19:00', 'Animalitos', 'Zorro', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlsorteofinalizado`
--

CREATE TABLE `controlsorteofinalizado` (
  `banca` varchar(40) NOT NULL,
  `gananciabanca` double NOT NULL,
  `gananciarecolector` double NOT NULL,
  `gananciajugadores` varchar(40) NOT NULL,
  `efectivobanca` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dineroapostado`
--

CREATE TABLE `dineroapostado` (
  `loteria` varchar(40) NOT NULL,
  `sorteo` varchar(40) NOT NULL,
  `fecha` varchar(40) NOT NULL,
  `dinero` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dineroapostado`
--

INSERT INTO `dineroapostado` (`loteria`, `sorteo`, `fecha`, `dinero`) VALUES
('Animalitos', '10:00', '2018-12-05', 0),
('Animalitos', '11:00', '2018-12-05', 0),
('Animalitos', '12:00', '2018-12-05', 0),
('Animalitos', '13:00', '2018-12-05', 0),
('Animalitos', '16:00', '2018-12-05', 0),
('Animalitos', '17:00', '2018-12-05', 0),
('Animalitos', '18:00', '2018-12-05', 0),
('Animalitos', '19:00', '2018-12-05', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dinerobanca`
--

CREATE TABLE `dinerobanca` (
  `usuario` varchar(40) NOT NULL,
  `dinero` double NOT NULL,
  `premiosporpagar` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dinerosortearbanca`
--

CREATE TABLE `dinerosortearbanca` (
  `dinero` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dinerosortearbanca`
--

INSERT INTO `dinerosortearbanca` (`dinero`) VALUES
(0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ganadores`
--

CREATE TABLE `ganadores` (
  `codigo` varchar(40) NOT NULL,
  `banca` varchar(40) NOT NULL,
  `jugada` varchar(40) NOT NULL,
  `loteria` varchar(40) NOT NULL,
  `ganancia` varchar(40) NOT NULL,
  `fecha` varchar(40) NOT NULL,
  `sorteo` varchar(40) NOT NULL,
  `hora` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ganancia`
--

CREATE TABLE `ganancia` (
  `socios` varchar(40) NOT NULL,
  `porcentage` double NOT NULL,
  `ganancia` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ganancia`
--

INSERT INTO `ganancia` (`socios`, `porcentage`, `ganancia`) VALUES
('otros', 0, 2528.4),
('programador', 30, 1083.6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadas`
--

CREATE TABLE `jugadas` (
  `codigoapuesta` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `loteria` varchar(100) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `bloqueo` varchar(2) NOT NULL,
  `tipojugada` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `jugadas`
--

INSERT INTO `jugadas` (`codigoapuesta`, `nombre`, `loteria`, `imagen`, `bloqueo`, `tipojugada`) VALUES
('09', 'Águila', 'Animalitos', 'imagenes/Animalitos/Águila.png', '', 'normal'),
('04', 'Alacrán', 'Animalitos', 'imagenes/Animalitos/Alacrán.png', '', 'normal'),
('39', 'Araña', 'Animalitos', 'imagenes/Animalitos/Araña.png', '', 'normal'),
('32', 'Ardilla', 'Animalitos', 'imagenes/Animalitos/Ardilla.png', '', 'normal'),
('00', 'Ballena', 'Animalitos', 'imagenes/Animalitos/Ballena.png', '', 'especial'),
('40', 'Búho', 'Animalitos', 'imagenes/Animalitos/Búho.png', '', 'normal'),
('18', 'Burro', 'Animalitos', 'imagenes/Animalitos/Burro.png', '', 'normal'),
('12', 'Caballo', 'Animalitos', 'imagenes/Animalitos/Caballo.png', '', 'normal'),
('30', 'Caimán', 'Animalitos', 'imagenes/Animalitos/Caimán.png', '', 'normal'),
('22', 'Camello', 'Animalitos', 'imagenes/Animalitos/Camello.png', '', 'normal'),
('01', 'Carnero', 'Animalitos', 'imagenes/Animalitos/Carnero.png', '', 'normal'),
('23', 'Cebra', 'Animalitos', 'imagenes/Animalitos/Cebra.png', '', 'normal'),
('19', 'Chivo', 'Animalitos', 'imagenes/Animalitos/Chivo.png', '', 'normal'),
('03', 'Ciempiés', 'Animalitos', 'imagenes/Animalitos/Ciempiés.png', '', 'normal'),
('20', 'Cochino', 'Animalitos', 'imagenes/Animalitos/Cochino.png', '', 'normal'),
('41', 'Conejo', 'Animalitos', 'imagenes/Animalitos/Conejo.png', '', 'normal'),
('36', 'Culebra', 'Animalitos', 'imagenes/Animalitos/Culebra.png', '', 'normal'),
('0', 'Delfín', 'Animalitos', 'imagenes/Animalitos/Delfín.png', '', 'especial'),
('29', 'Elefante', 'Animalitos', 'imagenes/Animalitos/Elefante.png', '', 'normal'),
('25', 'Gallina', 'Animalitos', 'imagenes/Animalitos/Gallina.png', '', 'normal'),
('21', 'Gallo', 'Animalitos', 'imagenes/Animalitos/Gallo.png', '', 'normal'),
('11', 'Gato', 'Animalitos', 'imagenes/Animalitos/Gato.png', '', 'normal'),
('42', 'Hipopótamo', 'Animalitos', 'imagenes/Animalitos/Hipopótamo.png', '', 'normal'),
('44', 'Hormiga', 'Animalitos', 'imagenes/Animalitos/Hormiga.png', '', 'normal'),
('24', 'Iguana', 'Animalitos', 'imagenes/Animalitos/Iguana.png', '', 'normal'),
('35', 'Jirafa', 'Animalitos', 'imagenes/Animalitos/Jirafa.jpg', '', 'normal'),
('31', 'Lapa', 'Animalitos', 'imagenes/Animalitos/Lapa.png', '', 'normal'),
('05', 'León', 'Animalitos', 'imagenes/Animalitos/León.png', '', 'normal'),
('13', 'Mono', 'Animalitos', 'imagenes/Animalitos/Mono.png', '', 'normal'),
('43', 'Murciélago', 'Animalitos', 'imagenes/Animalitos/Murciélago.png', '', 'normal'),
('16', 'Oso', 'Animalitos', 'imagenes/Animalitos/Oso.png', '', 'normal'),
('45', 'Oveja', 'Animalitos', 'imagenes/Animalitos/Oveja.png', '', 'normal'),
('14', 'Paloma', 'Animalitos', 'imagenes/Animalitos/Paloma.png', '', 'normal'),
('17', 'Pavo', 'Animalitos', 'imagenes/Animalitos/Pavo.png', '', 'normal'),
('46', 'Pavo Real', 'Animalitos', 'imagenes/Animalitos/Pavo Real.png', '', 'normal'),
('07', 'Perico', 'Animalitos', 'imagenes/Animalitos/Perico.png', '', 'normal'),
('27', 'Perro', 'Animalitos', 'imagenes/Animalitos/Perro.png', '', 'normal'),
('33', 'Pescado', 'Animalitos', 'imagenes/Animalitos/Pescado.png', '', 'normal'),
('38', 'Pulpo', 'Animalitos', 'imagenes/Animalitos/Pulpo.png', '', 'normal'),
('06', 'Rana', 'Animalitos', 'imagenes/Animalitos/Rana.png', '', 'normal'),
('08', 'Ratón', 'Animalitos', 'imagenes/Animalitos/Ratón.png', '', 'normal'),
('10', 'Tigre', 'Animalitos', 'imagenes/Animalitos/Tigre.png', '', 'normal'),
('02', 'Toro', 'Animalitos', 'imagenes/Animalitos/Toro.png', '', 'normal'),
('37', 'Tortuga', 'Animalitos', 'imagenes/Animalitos/Tortuga.png', '', 'normal'),
('26', 'Vaca', 'Animalitos', 'imagenes/Animalitos/Vaca.png', '', 'normal'),
('34', 'Venado', 'Animalitos', 'imagenes/Animalitos/Venado.png', '', 'normal'),
('28', 'Zamuro', 'Animalitos', 'imagenes/Animalitos/Zamuro.png', '', 'normal'),
('15', 'Zorro', 'Animalitos', 'imagenes/Animalitos/Zorro.png', '', 'normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadasganadoras`
--

CREATE TABLE `jugadasganadoras` (
  `sorteo` datetime NOT NULL,
  `loteria` varchar(40) NOT NULL,
  `jugada` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `jugadasganadoras`
--

INSERT INTO `jugadasganadoras` (`sorteo`, `loteria`, `jugada`) VALUES
('2018-01-23 09:00:00', 'Animalitos', 'Delfín'),
('2018-01-23 10:00:00', 'Animalitos', 'Águila'),
('2018-01-23 11:00:00', 'Animalitos', 'Pavo Real'),
('2018-01-23 12:00:00', 'Animalitos', 'Perico'),
('2018-01-23 13:00:00', 'Animalitos', 'Lapa'),
('2018-01-23 16:00:00', 'Animalitos', 'Búho'),
('2018-01-23 17:00:00', 'Animalitos', 'Carnero'),
('2018-01-23 18:00:00', 'Animalitos', 'Pavo'),
('2018-01-23 19:00:00', 'Animalitos', 'Culebra'),
('2018-01-25 09:00:00', 'Animalitos', 'Hormiga'),
('2018-12-05 09:00:00', 'Animalitos', 'Cebra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loterias`
--

CREATE TABLE `loterias` (
  `loteria` varchar(100) NOT NULL,
  `valorapuesta` int(50) NOT NULL,
  `bloqueo` varchar(2) NOT NULL,
  `diascaducaciontiket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `loterias`
--

INSERT INTO `loterias` (`loteria`, `valorapuesta`, `bloqueo`, `diascaducaciontiket`) VALUES
('Animalitos', 40, 'no', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `porcentajes`
--

CREATE TABLE `porcentajes` (
  `nombre` varchar(30) NOT NULL,
  `porcentaje` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `porcentajes`
--

INSERT INTO `porcentajes` (`nombre`, `porcentaje`) VALUES
('banca', 10),
('bancorecolector', 10),
('recolector', 10),
('sorteos', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recolectores`
--

CREATE TABLE `recolectores` (
  `nombre` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `creador` varchar(50) NOT NULL,
  `usuariocreador` varchar(50) NOT NULL,
  `bloqueo` varchar(2) NOT NULL,
  `porcentageganancia` double NOT NULL,
  `telefono` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recolectores`
--

INSERT INTO `recolectores` (`nombre`, `usuario`, `creador`, `usuariocreador`, `bloqueo`, `porcentageganancia`, `telefono`) VALUES
('daniela', 'daniela', 'administrador', 'admin', 'no', 20, '66214'),
('juan de dios', 'j', 'administrador', 'admin', 'no', 20, '02392452176'),
('myrailys', 'myrailys', 'administrador', 'admin', 'no', 20, '04241935343');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sorteo`
--

CREATE TABLE `sorteo` (
  `loteria` varchar(100) NOT NULL,
  `hora` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sorteo`
--

INSERT INTO `sorteo` (`loteria`, `hora`) VALUES
('Animalitos', '09:00'),
('Animalitos', '10:00'),
('Animalitos', '11:00'),
('Animalitos', '12:00'),
('Animalitos', '13:00'),
('Animalitos', '16:00'),
('Animalitos', '17:00'),
('Animalitos', '18:00'),
('Animalitos', '19:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traductor`
--

CREATE TABLE `traductor` (
  `codigo` int(11) NOT NULL,
  `frase` text NOT NULL,
  `idioma` varchar(5) NOT NULL,
  `traduccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `traductor`
--

INSERT INTO `traductor` (`codigo`, `frase`, `idioma`, `traduccion`) VALUES
(1, 'ingrese el nombre de usuario', 'es', 'Ingrese El Nombre De Usuario'),
(2, 'usuario no registrado', 'es', 'Usuario No Registrado'),
(3, 'usuario', 'es', 'Usuario'),
(4, 'contraseña', 'es', 'Contraseña'),
(5, 'iniciar sesion', 'es', 'Iniciar Sesión'),
(6, 'ingrese la contraseña', 'es', 'Ingrese la Contraseña'),
(7, 'contraseña incorecta', 'es', 'Contraseña Incorecta'),
(8, 'ingresar', 'es', 'Ingresar'),
(9, 'cancelar', 'es', 'Cancelar'),
(10, 'Apuestas', 'es', 'Apuestas'),
(11, 'seleccione una loteria', 'es', 'Seleccione Una Lotería'),
(12, 'seleccione un sorteo', 'es', 'Seleccione Un Sorteo'),
(13, 'Menu', 'es', 'Menú');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nick` varchar(40) NOT NULL,
  `clave` varchar(40) NOT NULL,
  `tipodeusuario` varchar(40) NOT NULL,
  `bloqueo` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nick`, `clave`, `tipodeusuario`, `bloqueo`) VALUES
('aa', '', 'banca', 'no'),
('admin', '', 'administrador', 'no'),
('dani', '244809', 'banca', 'no'),
('daniela', '244809', 'recolector', 'no'),
('j', '5445', 'recolector', 'no'),
('javier', '', 'banca', 'no'),
('lachina', '1004', 'banca', 'no'),
('myrailys', '', 'recolector', 'no'),
('Prueba', '1234', 'banca', 'no'),
('toñin', '', 'banca', 'no');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dinerosortearbanca`
--
ALTER TABLE `dinerosortearbanca`
  ADD PRIMARY KEY (`dinero`);

--
-- Indices de la tabla `ganancia`
--
ALTER TABLE `ganancia`
  ADD PRIMARY KEY (`socios`);

--
-- Indices de la tabla `jugadas`
--
ALTER TABLE `jugadas`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `loterias`
--
ALTER TABLE `loterias`
  ADD PRIMARY KEY (`loteria`);

--
-- Indices de la tabla `porcentajes`
--
ALTER TABLE `porcentajes`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `recolectores`
--
ALTER TABLE `recolectores`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `traductor`
--
ALTER TABLE `traductor`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nick`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `traductor`
--
ALTER TABLE `traductor`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
