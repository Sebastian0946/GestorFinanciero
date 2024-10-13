-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2024 a las 19:17:55
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
-- Base de datos: `gestor_financiero`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas`
--

CREATE TABLE `alertas` (
  `id_alerta` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `fecha_alerta` datetime DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `alertas`
--

INSERT INTO `alertas` (`id_alerta`, `id_usuario`, `mensaje`, `fecha_alerta`, `leido`) VALUES
(1, 1, 'Has alcanzado el 80% de tu presupuesto mensual.', '2024-10-02 11:00:48', 0),
(2, 2, 'Se ha registrado un nuevo gasto en la categoría \"Transporte\".', '2024-10-02 11:00:48', 0),
(3, 3, 'Quedan 5 días para el cierre del presupuesto mensual.', '2024-10-02 11:00:48', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `tipo` enum('ingreso','gasto') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `tipo`) VALUES
(1, 'Salario', 'ingreso'),
(2, 'Freelance', 'ingreso'),
(3, 'Venta de Activos', 'ingreso'),
(4, 'Alquiler', 'gasto'),
(5, 'Comida', 'gasto'),
(6, 'Transporte', 'gasto'),
(7, 'Entretenimiento', 'gasto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id_gasto` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `Motivo` varchar(250) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id_gasto`, `id_usuario`, `id_categoria`, `descripcion`, `monto`, `Motivo`, `fecha`) VALUES
(1, 1, 4, 'Pago del alquiler', 1000000.00, NULL, '2024-09-02'),
(2, 1, 5, 'Compra de comida', 200000.00, NULL, '2024-09-03'),
(3, 2, 6, 'Transporte público', 150000.00, NULL, '2024-09-04'),
(4, 3, 7, 'Suscripción de streaming', 30000.00, NULL, '2024-09-05'),
(5, 2, 7, 'Cine', 45000.00, NULL, '2024-09-06'),
(6, 24, 5, 'Papas fritas', 5000.00, NULL, '0000-00-00'),
(36, 24, 4, 'Compra de frutas', 15000.00, 'Compra mensual de frutas', '2024-05-05'),
(37, 24, 4, 'Compra de verduras', 12000.00, 'Compra mensual de verduras', '2024-05-10'),
(38, 24, 5, 'Almuerzo en restaurante', 25000.00, 'Almuerzo de trabajo', '2024-05-15'),
(39, 24, 5, 'Cena familiar', 30000.00, 'Cena con la familia', '2024-05-20'),
(40, 24, 6, 'Compra de productos de limpieza', 8000.00, 'Compra para el hogar', '2024-05-25'),
(41, 24, 5, 'Compra de pan', 5000.00, 'Pan semanal', '2024-05-28'),
(42, 24, 4, 'Compra de carne', 20000.00, 'Compra mensual de carne', '2024-06-05'),
(43, 24, 4, 'Compra de lácteos', 18000.00, 'Compra de lácteos', '2024-06-10'),
(44, 24, 5, 'Cenando fuera', 30000.00, 'Cena con amigos', '2024-06-15'),
(45, 24, 5, 'Gas para cocina', 9000.00, 'Recarga de gas', '2024-06-20'),
(46, 24, 6, 'Suscripción a gimnasio', 40000.00, 'Pago mensual', '2024-06-25'),
(47, 24, 6, 'Compra de snacks', 5000.00, 'Snacks para la semana', '2024-06-28'),
(48, 24, 6, 'Compra de juguetes', 7000.00, 'Regalo para el niño', '2024-07-05'),
(49, 24, 6, 'Alquiler de películas', 15000.00, 'Películas para ver en casa', '2024-07-10'),
(50, 24, 7, 'Almuerzo de trabajo', 25000.00, 'Almuerzo con clientes', '2024-07-15'),
(51, 24, 7, 'Gastos de transporte', 10000.00, 'Transporte público', '2024-07-20'),
(52, 24, 6, 'Compra de gasolina', 12000.00, 'Gasolina para el auto', '2024-07-25'),
(53, 24, 6, 'Compra de herramientas', 20000.00, 'Herramientas para el hogar', '2024-07-28'),
(54, 24, 7, 'Cuidado personal', 6000.00, 'Visita a la peluquería', '2024-08-05'),
(55, 24, 7, 'Compra de libros', 12000.00, 'Libros para el estudio', '2024-08-10'),
(56, 24, 5, 'Mantenimiento de auto', 30000.00, 'Revisión mecánica', '2024-08-15'),
(57, 24, 5, 'Suscripción a servicio de streaming', 10000.00, 'Entretenimiento mensual', '2024-08-20'),
(58, 24, 4, 'Visita al médico', 80000.00, 'Chequeo anual', '2024-08-25'),
(59, 24, 6, 'Alquiler de equipo de camping', 50000.00, 'Salida de fin de semana', '2024-09-05'),
(60, 24, 6, 'Compra de ropa', 150000.00, 'Ropa de verano', '2024-09-10'),
(61, 24, 5, 'Gastos de vacaciones', 1200000.00, 'Vacaciones familiares', '2024-09-15'),
(62, 24, 5, 'Almuerzo de negocios', 35000.00, 'Reunión con proveedores', '2024-09-20'),
(63, 24, 4, 'Gastos de escolaridad', 60000.00, 'Libros y útiles escolares', '2024-09-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id_ingreso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `Motivo` varchar(250) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id_ingreso`, `id_usuario`, `id_categoria`, `descripcion`, `monto`, `Motivo`, `fecha`) VALUES
(1, 1, 1, 'Salario mensual', 3000000.00, 'Salio mensual', '2024-09-01'),
(2, 2, 2, 'Proyecto freelance', 1500000.00, 'Proyecto vendido', '2024-09-03'),
(3, 3, 1, 'Salario mensual', 2500000.00, 'Bono', '2024-09-05'),
(4, 3, 3, 'Venta de bicicleta', 500000.00, 'Venta', '2024-09-07'),
(5, 24, 3, 'Play 4 ', 1500000.00, 'Venta', '2024-10-06'),
(6, 24, 3, 'Venta de pasteles', 2000.00, 'venta de pasteles', '2024-10-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id_presupuesto` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`id_presupuesto`, `id_usuario`, `monto_total`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 1, 2500000.00, '2024-09-01', '2024-09-30'),
(2, 2, 1800000.00, '2024-09-01', '2024-09-30'),
(3, 3, 3200000.00, '2024-09-01', '2024-09-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `fecha_registro`) VALUES
(1, 'Juan Pérez', 'juan.perez@email.com', 'password123', '2024-10-02 11:00:48'),
(2, 'María Gómez', 'maria.gomez@email.com', 'password456', '2024-10-02 11:00:48'),
(3, 'Carlos Sánchez', 'carlos.sanchez@email.com', 'password789', '2024-10-02 11:00:48'),
(4, 'Juan Sebastian', 'example.sebas@gmail.com', '0946', '2024-10-02 11:09:44'),
(24, 'Juan Sebastian Cabrera salazar', 'cano19651311@gmail.com', '$2y$10$Zi5eN5AuMST7Ps9XJ57Ai.PFAmr9yaSySmualqI4B2zJtaQz8Jzvy', '2024-10-05 16:01:10'),
(25, 'asdasdas', 'dasdasdas@gmail', '$2y$10$W/NDeZWP1W6e.DiH2Om0reAy/eLBj.Q1wYX3XjnoGbQMIsXH0guQK', '2024-10-06 08:10:30'),
(27, 'dasdasdas', 'wwwww@gmail', '$2y$10$GHu9MGi3KeUD6oFy56NY5OLWB/9ubH743pLivx4AIyrZRxu.v1QlW', '2024-10-06 08:14:12'),
(31, 'Maria Carlota Mercedez', 'sebascraft0946@gmail.com', '$2y$10$L4qiUraEd0Y4WcRJJQSan.IBg14NIa77U8Y0iQlYQRjFqncq8Rv4a', '2024-10-10 12:16:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`id_alerta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id_gasto`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id_presupuesto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alertas`
--
ALTER TABLE `alertas`
  MODIFY `id_alerta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id_gasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `gastos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `ingresos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL;

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
