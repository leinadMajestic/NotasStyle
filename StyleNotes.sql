-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2016 at 12:55 AM
-- Server version: 5.6.28
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `StyleNotes`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad_Items`
--

CREATE TABLE `ad_Items` (
  `IdItems` int(11) NOT NULL,
  `IdNotas` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `IdProveedor` int(11) NOT NULL,
  `pos` int(2) NOT NULL COMMENT 'Posicion que ocupa el item dentro del GRID',
  `Piezas` int(11) NOT NULL,
  `Subtotal` varchar(10) NOT NULL,
  `IVA` varchar(10) NOT NULL,
  `Total` varchar(10) NOT NULL COMMENT 'Precio final que pagará el cliente',
  `PrecioLista` varchar(10) NOT NULL COMMENT 'Precio de lista del producto',
  `Cotizado` varchar(10) NOT NULL COMMENT 'Costo estimado del proveedor al entregar el producto',
  `GastoL` varchar(10) NOT NULL COMMENT 'Gasto que hace Luis',
  `GastoM` varchar(10) NOT NULL COMMENT 'Gasto que hace Memo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ad_Notas`
--

CREATE TABLE `ad_Notas` (
  `IdNotas` int(11) NOT NULL,
  `Folio` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Status` int(1) NOT NULL,
  `Subtotal` varchar(10) NOT NULL,
  `IVA` varchar(10) NOT NULL,
  `Total` varchar(10) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `Comentarios` text NOT NULL,
  `Factura` int(1) NOT NULL COMMENT 'Indica si requirió factura 1=si, 0=no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `in_clientes`
--

CREATE TABLE `in_clientes` (
  `IdCliente` int(11) NOT NULL,
  `Empresa` varchar(256) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Email` varchar(256) NOT NULL,
  `Contacto` varchar(512) NOT NULL,
  `Puesto` varchar(256) NOT NULL,
  `Direccion` text NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `in_estatus`
--

CREATE TABLE `in_estatus` (
  `IdEstatus` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Estatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `in_productos`
--

CREATE TABLE `in_productos` (
  `IdProducto` int(11) NOT NULL,
  `Nombre` varchar(256) NOT NULL,
  `SKU` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `in_proveedores`
--

CREATE TABLE `in_proveedores` (
  `IdProveedor` int(11) NOT NULL,
  `Empresa` varchar(256) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Email` varchar(256) NOT NULL,
  `Contacto` varchar(512) NOT NULL,
  `Puesto` varchar(256) NOT NULL,
  `Direccion` text NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `in_usuarios`
--

CREATE TABLE `in_usuarios` (
  `IdUsuarios` int(11) NOT NULL,
  `Usuario` varchar(40) NOT NULL,
  `Clave` varchar(40) NOT NULL,
  `Nombre` varchar(256) NOT NULL,
  `Apellidos` varchar(256) NOT NULL,
  `Nivel` varchar(2) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Email` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `in_usuarios`
--

INSERT INTO `in_usuarios` (`IdUsuarios`, `Usuario`, `Clave`, `Nombre`, `Apellidos`, `Nivel`, `Telefono`, `Email`) VALUES
(1, 'sistemas', '883ad57e4913cb0db7472ec216c9c80041e88d63', 'Daniel', 'Huerta', 'WB', '3333685529', 'programacion@stylepublicidad.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad_Items`
--
ALTER TABLE `ad_Items`
  ADD PRIMARY KEY (`IdItems`);

--
-- Indexes for table `ad_Notas`
--
ALTER TABLE `ad_Notas`
  ADD PRIMARY KEY (`IdNotas`);

--
-- Indexes for table `in_clientes`
--
ALTER TABLE `in_clientes`
  ADD PRIMARY KEY (`IdCliente`);

--
-- Indexes for table `in_estatus`
--
ALTER TABLE `in_estatus`
  ADD PRIMARY KEY (`IdEstatus`);

--
-- Indexes for table `in_productos`
--
ALTER TABLE `in_productos`
  ADD PRIMARY KEY (`IdProducto`);

--
-- Indexes for table `in_proveedores`
--
ALTER TABLE `in_proveedores`
  ADD PRIMARY KEY (`IdProveedor`);

--
-- Indexes for table `in_usuarios`
--
ALTER TABLE `in_usuarios`
  ADD PRIMARY KEY (`IdUsuarios`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ad_Items`
--
ALTER TABLE `ad_Items`
  MODIFY `IdItems` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ad_Notas`
--
ALTER TABLE `ad_Notas`
  MODIFY `IdNotas` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `in_clientes`
--
ALTER TABLE `in_clientes`
  MODIFY `IdCliente` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `in_estatus`
--
ALTER TABLE `in_estatus`
  MODIFY `IdEstatus` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `in_productos`
--
ALTER TABLE `in_productos`
  MODIFY `IdProducto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `in_proveedores`
--
ALTER TABLE `in_proveedores`
  MODIFY `IdProveedor` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `in_usuarios`
--
ALTER TABLE `in_usuarios`
  MODIFY `IdUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
