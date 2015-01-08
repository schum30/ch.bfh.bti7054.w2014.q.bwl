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
INSERT INTO `products` (`id`,`name`, `categoryName`, `manufacturer`, `description`, `price`) VALUES
(1,'Amber', 'beer', 'Aare Bier', 'Rotkupfer, Caramel, Bisquit, blumig, schöne Malzigkeit, frisch mit Charakter', 5.5),
(2,'Ueli', 'beer', 'Ueli Bier', 'Hell und spritzig, altbewährt', 5.5),
(3,'Brandlöscher','beer','Appenzeller Bier','Amber, süsslich-herb, üppige Karamalznote, mittelkräftig und cremig',6.00),
(4,'Quöllfrisch','beer','Appenzeller Bier','Klares Gelb, harmonische Malz- und Hopfennoten, rund, geschmacksvoll und frisch',4.50),
(5,'Dude','beer','Bad Attitude','Ambergold, raffiniert-hopfig, Exotik, Pinie, Harz, kräftig und charaktervoll',4.00),
(6,'em Basler sy Bier','beer','Basler Bier','Hellgelb, harmonisch und rund, mittelkräftig, leicht malzig, frisch und süffig',5.00),
(7,'Boxer Old','beer','Bièrer du Boxer','Gelb, angenehm hopfig, dezent malzig, leicht bitter, aromatisch und frisch',5.00),
(8,'Maximus','beer','Egger Bier','Hellgelb, raffiniert hopfig, Gras, dezente Malznote, elegant mit guter Frische',4.50),
(9,'Maisgold','beer','Einsiedler Brauerei','Goldgelb, Mais, Butter, Getreide, cremig-elegant, dezent süss, harmonisch',3.80),
(10,'Öufi','beer','Öufi Brauerei','Gelb, toller Hopfen, Zitrus, aromatisch rund, herb, knackig-herb, frisch',3.80),
(11,'Bündner Röteli', 'liquor', 'Kindschi Söhne AG', 'ist ein naturreiner Likör mit 22 %vol. Alkohol. Getrocknete Kirschen werden zusammen mit einer natürlichen Gewürzmischung über eine längere Zeit in Kernobstbrand eingelegt. Nach der nötigen Reifezeit erfolgt die Fertigfabrikation, unter Beigabe von Kirschsaft und diversen Aromen. (z.B. Zimt, Vanille und Nelken). ', 29.95),
(12,'Willisauer Ringli Likör','liquor','Diwisa Distillerie','Ringli - der neue aromatische Liqueur mit dem milden Geschmack von Honig, Caramel und natürlichen Zitrus-Essenzen. Als Cocktail, Longdrink, "On the Rocks", im Kaffee oder Dessert. Ringli - absolut in der Vielfalt seiner Anwendung.Unverkennbar! Aussergwöhnlicher Geschmack im aussergewöhnlichen Design.',35),
(13,'Vieille Prune','liquor','Etter Distillerie','Vieille Prune ist eine wunderbare, zarte Pflümli-Spezialität aus kleinen Schweizer Löhrpflaumen. Nach 3 Jahren sorgsamer Pflege erhält diese seinen fruchtigen und feinaromatischen Geschmack.',45),
(14,'Baileys Irish Cream','liquor','Diageo','Baileys ist die umgangssprachliche Kurzform für Baileys Original Irish Cream, den Markennamen eines irischen Creamlikörs aus irischem Whiskey und Sahne mit einem Alkoholgehalt von 17 Vol.-%. Baileys gehört zum Diageo-Konzern.',35),
(15,'Rouvinez Fendant De Sierre', 'wine', 'Rouvinez', 'Frische Frucht mit Zitrus- und Blumennoten, rund und bekömmlich, angenehme Säure, süffig. Als Apéro, perfekt zu Fondue oder Käsespezialitäten.', 50),
(16,'Pinot Gris Dardagny','wine','Domaine Les Hutins','Frisches und fruchtbetontes Bukett, im Gaumen kräftige Quitten-Frucht, gleichzeitig sehr rund und weich, vollmundiges Finale. Als Apéro, zu Fisch, Spargeln oder kalten Platten.',50),
(17,'Roter Sauser','wine','Kellerei Stadium','Das Traubenerzeugnis mit Biss aus Hallau.Zweistern Stadium, herrlich prickelnd. Passt zu Wild, Braten, Marroni oder einfach so als Herbstgruss.',50),
(18,'Pinot Noir Wintersinger','wine','Siebe Dupf','Funkelnde lachsrosa Farbe, kräftige Aromen von roten Beeren, angenehm körperreicher Rosé, ein Hauch Zitrus. Als Apéro, zu Gemüse oder einfach so.',50),
(19,'Akkurat Rot','wine','Staatskellerei Zürich','Aroma von reifen Beeren, würzig und reich, samtige Tanninstruktur mit fruchtiger Fülle, langer beeriger Abgang. Zu kalten Platten, Geflügel, Käse oder einfach so.',50),
(20,'Totinger Blauburgunder','wine','Luzerner Weine','Angenehme, fruchtige Nase, frisches Beeren- und Säurespiel, harmonisch, elegant ausklingend. Zu kalten Platten, leichten Hauptgerichten, Geflügel oder Käse.',50);
