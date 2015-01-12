-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Jan 2015 um 23:31
-- Server Version: 5.6.21
-- PHP-Version: 5.6.3

CREATE SCHEMA bwl;
USE bwl;

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
`id` int(11) NOT NULL,
  `street` varchar(50) NOT NULL,
  `plz` int(4) NOT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `addresses`
--

INSERT INTO `addresses` (`id`, `street`, `plz`, `city`) VALUES
(0, 'Mustergasse 11', 1234, 'Musterstadt');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`name`) VALUES
('beer'),
('liquor'),
('wine');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `name` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `addressId` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `customers`
--

INSERT INTO `customers` (`name`, `firstName`, `lastName`, `phone`, `addressId`, `password`) VALUES
('hm', 'Hans', 'Meier', '034 445 53 06', 0, 'password');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `options`
--

CREATE TABLE IF NOT EXISTS `options` (
`id` int(11) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `options`
--

INSERT INTO `options` (`id`, `size`) VALUES
(1, 33),
(2, 50),
(3, 70),
(4, 100);

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
`id` int(11) NOT NULL,
  `customerName` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
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
`id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `categoryName` varchar(50) NOT NULL,
  `manufacturer` varchar(80) NOT NULL,
  `description_de` text,
  `description_en` text,
  `description_fr` text
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `categoryName`, `manufacturer`, `description_de`, `description_en`, `description_fr`) VALUES
(1, 'Amber', 'beer', 'Aare Bier', 'Rotkupfer, Caramel, Bisquit, blumig, schöne Malzigkeit, frisch mit Charakter', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(2, 'Ueli', 'beer', 'Ueli Bier', 'Hell und spritzig, altbewährt', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(3, 'Brandlöscher', 'beer', 'Appenzeller Bier', 'Amber, süsslich-herb, üppige Karamalznote, mittelkräftig und cremig', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(4, 'Quöllfrisch', 'beer', 'Appenzeller Bier', 'Klares Gelb, harmonische Malz- und Hopfennoten, rund, geschmacksvoll und frisch', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(5, 'Dude', 'beer', 'Bad Attitude', 'Ambergold, raffiniert-hopfig, Exotik, Pinie, Harz, kräftig und charaktervoll', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(6, 'em Basler sy Bier', 'beer', 'Basler Bier', 'Hellgelb, harmonisch und rund, mittelkräftig, leicht malzig, frisch und süffig', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(7, 'Boxer Old', 'beer', 'Bièrer du Boxer', 'Gelb, angenehm hopfig, dezent malzig, leicht bitter, aromatisch und frisch', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(8, 'Maximus', 'beer', 'Egger Bier', 'Hellgelb, raffiniert hopfig, Gras, dezente Malznote, elegant mit guter Frische', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(9, 'Maisgold', 'beer', 'Einsiedler Brauerei', 'Goldgelb, Mais, Butter, Getreide, cremig-elegant, dezent süss, harmonisch', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(10, 'Öufi', 'beer', 'Öufi Brauerei', 'Gelb, toller Hopfen, Zitrus, aromatisch rund, herb, knackig-herb, frisch', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(11, 'Bündner Röteli', 'liquor', 'Kindschi Söhne AG', 'ist ein naturreiner Likör mit 22 %vol. Alkohol. Getrocknete Kirschen werden zusammen mit einer natürlichen Gewürzmischung eingelegt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(12, 'Willisauer Ringli Likör', 'liquor', 'Diwisa Distillerie', 'Ringli - der neue aromatische Liqueur mit dem milden Geschmack von Honig, Caramel und natürlichen Zitrus-Essenzen.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(13, 'Vieille Prune', 'liquor', 'Etter Distillerie', 'Vieille Prune ist eine wunderbare, zarte Pflümli-Spezialität aus kleinen Schweizer Löhrpflaumen.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(14, 'Baileys Irish Cream', 'liquor', 'Diageo', 'Baileys ist die umgangssprachliche Kurzform für Baileys Original Irish Cream.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(15, 'Rouvinez Fendant De Sierre', 'wine', 'Rouvinez', 'Frische Frucht mit Zitrus- und Blumennoten, rund und bekömmlich, angenehme Säure, süffig.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(16, 'Pinot Gris Dardagny', 'wine', 'Domaine Les Hutins', 'Frisches und fruchtbetontes Bukett, im Gaumen kräftige Quitten-Frucht, gleichzeitig sehr rund und weich, vollmundiges Finale.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(17, 'Roter Sauser', 'wine', 'Kellerei Stadium', 'Das Traubenerzeugnis mit Biss aus Hallau.Zweistern Stadium, herrlich prickelnd. Passt zu Wild, Braten, Marroni oder einfach so als Herbstgruss.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(18, 'Pinot Noir Wintersinger', 'wine', 'Siebe Dupf', 'Funkelnde lachsrosa Farbe, kräftige Aromen von roten Beeren, angenehm körperreicher Rosé, ein Hauch Zitrus. Als Apéro, zu Gemüse oder einfach so.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(19, 'Akkurat Rot', 'wine', 'Staatskellerei Zürich', 'Aroma von reifen Beeren, würzig und reich, samtige Tanninstruktur mit fruchtiger Fülle, langer beeriger Abgang.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(20, 'Tottinger', 'wine', 'Luzerner Weine', 'Angenehme, fruchtige Nase, frisches Beeren- und Säurespiel, harmonisch, elegant ausklingend. Zu kalten Platten, leichten Hauptgerichten, Geflügel oder Käse.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
(21, 'Gin Mare', 'liquor', 'Global Premium Brands SA', 'Spanier produzieren nicht nur Wein. Auch im Gin Herstellen sind sie Meister. Der GIN MARE ist der Beweis dafür.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `productsoptions`
--

CREATE TABLE IF NOT EXISTS `productsoptions` (
  `productId` int(11) NOT NULL,
  `optionId` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `productsoptions`
--

INSERT INTO `productsoptions` (`productId`, `optionId`, `price`) VALUES
(1, 1, 3.3),
(1, 2, 5.5),
(2, 1, 3.3),
(2, 2, 5.5),
(3, 1, 4),
(3, 2, 6),
(4, 1, 2.5),
(4, 2, 4),
(5, 1, 3),
(5, 2, 5),
(6, 1, 2),
(6, 2, 3),
(7, 1, 1.95),
(7, 2, 2.5),
(8, 1, 2.5),
(8, 2, 4),
(9, 1, 1.8),
(9, 2, 2.4),
(10, 1, 3),
(10, 2, 5),
(11, 3, 29.9),
(11, 4, 39.9),
(12, 3, 35.9),
(12, 4, 48.9),
(13, 3, 30),
(13, 4, 40),
(14, 3, 30),
(14, 4, 40),
(15, 3, 30),
(15, 4, 40),
(16, 3, 30),
(16, 4, 40),
(17, 3, 30),
(17, 4, 40),
(18, 3, 30),
(18, 4, 40),
(19, 3, 30),
(19, 4, 40),
(20, 3, 30),
(20, 4, 40),
(21, 3, 30),
(21, 4, 40);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `addresses`
--
ALTER TABLE `addresses`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `street` (`street`,`plz`,`city`);

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`name`);

--
-- Indizes für die Tabelle `customers`
--
ALTER TABLE `customers`
 ADD PRIMARY KEY (`name`), ADD KEY `addressId` (`addressId`);

--
-- Indizes für die Tabelle `options`
--
ALTER TABLE `options`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `orderdetails`
--
ALTER TABLE `orderdetails`
 ADD PRIMARY KEY (`orderId`,`productId`), ADD KEY `productId` (`productId`);

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`id`), ADD KEY `status` (`status`), ADD KEY `customerName` (`customerName`);

--
-- Indizes für die Tabelle `orderstatuses`
--
ALTER TABLE `orderstatuses`
 ADD PRIMARY KEY (`status`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`id`), ADD KEY `categoryName` (`categoryName`), ADD FULLTEXT KEY `name` (`name`,`manufacturer`,`description_de`,`description_en`,`description_fr`);

--
-- Indizes für die Tabelle `productsoptions`
--
ALTER TABLE `productsoptions`
 ADD PRIMARY KEY (`productId`,`optionId`), ADD KEY `optionId` (`optionId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `addresses`
--
ALTER TABLE `addresses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `options`
--
ALTER TABLE `options`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `customers`
--
ALTER TABLE `customers`
ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`addressId`) REFERENCES `addresses` (`id`);

--
-- Constraints der Tabelle `orderdetails`
--
ALTER TABLE `orderdetails`
ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`),
ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`id`);

--
-- Constraints der Tabelle `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`status`) REFERENCES `orderstatuses` (`status`),
ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`customerName`) REFERENCES `customers` (`name`);

--
-- Constraints der Tabelle `products`
--
ALTER TABLE `products`
ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoryName`) REFERENCES `categories` (`name`);

--
-- Constraints der Tabelle `productsoptions`
--
ALTER TABLE `productsoptions`
ADD CONSTRAINT `productsoptions_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
ADD CONSTRAINT `productsoptions_ibfk_2` FOREIGN KEY (`optionId`) REFERENCES `options` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
