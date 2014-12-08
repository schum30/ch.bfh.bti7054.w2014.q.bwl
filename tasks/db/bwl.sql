CREATE DATABASE bwl;
USE bwl;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `street` varchar(50) NOT NULL,
  `plz` int(4) NOT NULL,
  `city` varchar(50) NOT NULL,
  UNIQUE (`street`,`plz`,`city`)
);
CREATE TABLE IF NOT EXISTS `categories` (
  `name` varchar(50) PRIMARY KEY
);
CREATE TABLE IF NOT EXISTS `customers` (
  `name` varchar(50) PRIMARY KEY,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `addressId` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  FOREIGN KEY (`addressId`) REFERENCES `addresses` (`id`)
);
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `categoryName` varchar(50) NOT NULL,
  `manufacturer` varchar(80) NOT NULL,
  `description` text,
  `price` double NOT NULL,
  FOREIGN KEY (`categoryName`) REFERENCES `categories` (`name`)
);
CREATE TABLE IF NOT EXISTS `orderstatuses` (
  `status` varchar(15) PRIMARY KEY
);
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) PRIMARY KEY,
  `customerName` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL,
  FOREIGN KEY (`status`) REFERENCES `orderstatuses` (`status`),
  FOREIGN KEY (`customerName`) REFERENCES `customers` (`name`)
);
CREATE TABLE IF NOT EXISTS `orderdetails` (
  `orderId` int(11) NOT NULL DEFAULT '0',
  `productId` int(11) NOT NULL DEFAULT '0',
  `amountOrdered` int(11) DEFAULT NULL,
  `priceEach` double DEFAULT NULL,
  PRIMARY KEY (`orderId`,`productId`),
  FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`),
  FOREIGN KEY (`productId`) REFERENCES `products` (`id`)
);

INSERT categories (name) VALUES ('beer'),('wine'),('liquor');
