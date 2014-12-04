-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 04. Dez 2014 um 14:16
-- Server Version: 5.6.20
-- PHP-Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `bwl`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `addressId` int(11) NOT NULL,
  `street` varchar(50) NOT NULL,
  `plz` int(4) NOT NULL,
  `city` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `categoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customerName` varchar(50) NOT NULL,
  `customerFirstName` varchar(50) NOT NULL,
  `customerLastName` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `addressId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orderdetails`
--

CREATE TABLE IF NOT EXISTS `orderdetails` (
  `orderId` int(11) NOT NULL DEFAULT '0',
  `productId` int(11) NOT NULL DEFAULT '0',
  `amountOrdered` int(11) DEFAULT NULL,
  `priceEach` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderId` int(11) NOT NULL,
  `customerName` varchar(50) DEFAULT NULL,
  `orderDate` datetime DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orderstatuses`
--

CREATE TABLE IF NOT EXISTS `orderstatuses` (
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `productId` int(11) NOT NULL,
  `productName` varchar(80) NOT NULL,
  `productCategory` varchar(50) NOT NULL,
  `productManufacturer` varchar(80) NOT NULL,
  `productDescription` text,
  `productPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
 ADD PRIMARY KEY (`addressId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`categoryName`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
 ADD PRIMARY KEY (`customerName`), ADD KEY `addressId` (`addressId`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
 ADD PRIMARY KEY (`orderId`,`productId`), ADD KEY `productId` (`productId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`orderId`), ADD KEY `status` (`status`), ADD KEY `customerName` (`customerName`);

--
-- Indexes for table `orderstatuses`
--
ALTER TABLE `orderstatuses`
 ADD PRIMARY KEY (`status`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`productId`), ADD KEY `productCategory` (`productCategory`);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `customers`
--
ALTER TABLE `customers`
ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`addressId`) REFERENCES `addresses` (`addressId`);

--
-- Constraints der Tabelle `orderdetails`
--
ALTER TABLE `orderdetails`
ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`),
ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints der Tabelle `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`status`) REFERENCES `orderstatuses` (`status`),
ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`customerName`) REFERENCES `customers` (`customerName`);

--
-- Constraints der Tabelle `products`
--
ALTER TABLE `products`
ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`productCategory`) REFERENCES `categories` (`categoryName`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
