-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 21, 2024 at 04:32 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `InstitutoIdiomas`
--
CREATE DATABASE IF NOT EXISTS `InstitutoIdiomas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `InstitutoIdiomas`;

-- --------------------------------------------------------

--
-- Table structure for table `Idioma`
--

CREATE TABLE `Idioma` (
  `id_idioma` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `modulos` int(11) NOT NULL,
  `imagen` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Idioma`
--

INSERT INTO `Idioma` (`id_idioma`, `nombre`, `descripcion`, `modulos`, `imagen`) VALUES
(1, 'Ingles', 'Lengua de origen Europeo', 4, 'docs/img/6715885208fca7.71171835.png'),
(3, 'Italiano', 'Lengua precedente del latin', 3, 'docs/img/671587e11cf369.08464002.png'),
(4, 'Aleman', 'Lengua del grupo germánico', 2, 'docs/img/671588a82c2442.01981511.png'),
(55, 'Portugués', 'Es una lengua pluricéntrica', 3, 'docs/img/67143f6b47cc56.34888657.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `Profesor`
--

CREATE TABLE `Profesor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  `imagen` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Profesor`
--

INSERT INTO `Profesor` (`id`, `nombre`, `telefono`, `email`, `id_idioma`, `imagen`) VALUES
(1, 'Matias', 15336756, 'matias@idiomas.com', 1, 'docs/img/671586227c5889.95956014.png'),
(2, 'Carolina', 15654321, 'carolina@idiomas.com', 55, 'docs/img/671589a357f297.89609470.png'),
(9, 'Federico', 15928370, 'federico@idiomas.com', 3, 'docs/img/671586e853cf54.88526497.png'),
(11, 'Lucia ', 15233445, 'lucia@idiomas.com', 4, 'docs/img/67158650ee19f0.89962640.png'),
(13, 'Martin', 15807699, 'martin@idiomas.com', 55, 'docs/img/671581b1877884.68963486.png'),
(15, 'Milagros', 15135698, 'milagros@idiomas.com', 3, 'docs/img/67158111e1e991.58240608.png'),
(18, 'Florencia', 14563456, 'florencia@idiomas.com', 3, 'docs/img/67157e4384b341.10075678.png'),
(19, 'Mateo ', 15413456, 'mateo@idiomas.com', 1, 'docs/img/671582097787a8.28857388.png'),
(20, 'Luciana', 15467896, 'luciana@idiomas.com', 1, 'docs/img/6715848f3c6db2.18619763.png'),
(21, 'Agustin', 15336789, 'agustin@idiomas.com', 4, 'docs/img/6715890b70d544.97355485.png');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`) VALUES
(1, 'webadmin@web2.com', '$2y$10$1yrWhYguqF9Yj9G64T58.OD7OiBIpaSIn3eSH7KZubfJPXD2zJbRy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Idioma`
--
ALTER TABLE `Idioma`
  ADD PRIMARY KEY (`id_idioma`);

--
-- Indexes for table `Profesor`
--
ALTER TABLE `Profesor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_idioma` (`id_idioma`) USING BTREE;

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Idioma`
--
ALTER TABLE `Idioma`
  MODIFY `id_idioma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `Profesor`
--
ALTER TABLE `Profesor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Profesor`
--
ALTER TABLE `Profesor`
  ADD CONSTRAINT `profesor_ibfk_1` FOREIGN KEY (`id_idioma`) REFERENCES `Idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
