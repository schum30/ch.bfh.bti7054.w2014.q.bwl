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
  FOREIGN KEY (`categoryName`) REFERENCES `categories` (`name`),
  FULLTEXT (name,manufacturer,description)
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
INSERT INTO `addresses` (`id`, `street`, `plz`, `city`) VALUES
(0, 'M', 1234, 'Musterstadt');
INSERT INTO `customers` (`name`, `firstName`, `lastName`, `phone`, `addressId`, `password`) VALUES
('hm', 'Hans', 'Meier', '034 445 53 06', 0, 'password');
INSERT INTO `products` (`name`, `categoryName`, `manufacturer`, `description`, `price`) VALUES
('Bündner Röteli', 'liquor', 'Kindschi Söhne AG', 'ist ein naturreiner Likör mit 22 %vol. Alkohol. Getrocknete Kirschen werden zusammen mit einer natürlichen Gewürzmischung über eine längere Zeit in Kernobstbrand eingelegt. Nach der nötigen Reifezeit erfolgt die Fertigfabrikation, unter Beigabe von Kirschsaft und diversen Aromen. (z.B. Zimt, Vanille und Nelken). ', 29.95),
('Amber', 'beer', 'Aare Bier', 'Rotkupfer, Caramel, Bisquit, blumig, schöne Malzigkeit, frisch mit Charakter', 5.5),
('Rouvinez Fendant De Sierre', 'wine', 'Rouvinez', 'Frische Frucht mit Zitrus- und Blumennoten, rund und bekömmlich, angenehme Säure, süffig. Als Apéro, perfekt zu Fondue oder Käsespezialitäten.', 50);
