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
  FOREIGN KEY (`categoryName`) REFERENCES `categories` (`name`),
  FULLTEXT (name,manufacturer,description)
);
CREATE TABLE `options`(
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `size` int(11) NOT NULL
);
CREATE TABLE `productsOptions`(
	`productId` int(11) NOT NULL,
    `optionId` int(11) NOT NULL,
    `price` double NOT NULL,
    PRIMARY KEY (`productId`, `optionId`),
    FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
    FOREIGN KEY (`optionId`) REFERENCES `options` (`id`)
);
CREATE TABLE IF NOT EXISTS `orderstatuses` (
  `status` varchar(15) PRIMARY KEY
);
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
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

INSERT INTO categories (name) VALUES ('beer'),('wine'),('liquor');
INSERT INTO `addresses` (`id`, `street`, `plz`, `city`) VALUES
(0, 'Mustergasse 11', 1234, 'Musterstadt');
INSERT INTO `customers` (`name`, `firstName`, `lastName`, `phone`, `addressId`, `password`) VALUES
('hm', 'Hans', 'Meier', '034 445 53 06', 0, 'password');
INSERT INTO `products` (`id`,`name`, `categoryName`, `manufacturer`, `description`) VALUES
(1,'Amber', 'beer', 'Aare Bier', 'Rotkupfer, Caramel, Bisquit, blumig, schöne Malzigkeit, frisch mit Charakter'),
(2,'Ueli', 'beer', 'Ueli Bier', 'Hell und spritzig, altbewährt'),
(3,'Brandlöscher','beer','Appenzeller Bier','Amber, süsslich-herb, üppige Karamalznote, mittelkräftig und cremig'),
(4,'Quöllfrisch','beer','Appenzeller Bier','Klares Gelb, harmonische Malz- und Hopfennoten, rund, geschmacksvoll und frisch'),
(5,'Dude','beer','Bad Attitude','Ambergold, raffiniert-hopfig, Exotik, Pinie, Harz, kräftig und charaktervoll'),
(6,'em Basler sy Bier','beer','Basler Bier','Hellgelb, harmonisch und rund, mittelkräftig, leicht malzig, frisch und süffig'),
(7,'Boxer Old','beer','Bièrer du Boxer','Gelb, angenehm hopfig, dezent malzig, leicht bitter, aromatisch und frisch'),
(8,'Maximus','beer','Egger Bier','Hellgelb, raffiniert hopfig, Gras, dezente Malznote, elegant mit guter Frische'),
(9,'Maisgold','beer','Einsiedler Brauerei','Goldgelb, Mais, Butter, Getreide, cremig-elegant, dezent süss, harmonisch'),
(10,'Öufi','beer','Öufi Brauerei','Gelb, toller Hopfen, Zitrus, aromatisch rund, herb, knackig-herb, frisch'),
(11,'Bündner Röteli', 'liquor', 'Kindschi Söhne AG', 'ist ein naturreiner Likör mit 22 %vol. Alkohol. Getrocknete Kirschen werden zusammen mit einer natürlichen Gewürzmischung eingelegt.'),
(12,'Willisauer Ringli Likör','liquor','Diwisa Distillerie','Ringli - der neue aromatische Liqueur mit dem milden Geschmack von Honig, Caramel und natürlichen Zitrus-Essenzen.'),
(13,'Vieille Prune','liquor','Etter Distillerie','Vieille Prune ist eine wunderbare, zarte Pflümli-Spezialität aus kleinen Schweizer Löhrpflaumen.'),
(14,'Baileys Irish Cream','liquor','Diageo','Baileys ist die umgangssprachliche Kurzform für Baileys Original Irish Cream.'),
(15,'Rouvinez Fendant De Sierre', 'wine', 'Rouvinez', 'Frische Frucht mit Zitrus- und Blumennoten, rund und bekömmlich, angenehme Säure, süffig.'),
(16,'Pinot Gris Dardagny','wine','Domaine Les Hutins','Frisches und fruchtbetontes Bukett, im Gaumen kräftige Quitten-Frucht, gleichzeitig sehr rund und weich, vollmundiges Finale.'),
(17,'Roter Sauser','wine','Kellerei Stadium','Das Traubenerzeugnis mit Biss aus Hallau.Zweistern Stadium, herrlich prickelnd. Passt zu Wild, Braten, Marroni oder einfach so als Herbstgruss.'),
(18,'Pinot Noir Wintersinger','wine','Siebe Dupf','Funkelnde lachsrosa Farbe, kräftige Aromen von roten Beeren, angenehm körperreicher Rosé, ein Hauch Zitrus. Als Apéro, zu Gemüse oder einfach so.'),
(19,'Akkurat Rot','wine','Staatskellerei Zürich','Aroma von reifen Beeren, würzig und reich, samtige Tanninstruktur mit fruchtiger Fülle, langer beeriger Abgang.'),
(20,'Tottinger','wine','Luzerner Weine','Angenehme, fruchtige Nase, frisches Beeren- und Säurespiel, harmonisch, elegant ausklingend. Zu kalten Platten, leichten Hauptgerichten, Geflügel oder Käse.'),
(21,'Gin Mare','liquor','Global Premium Brands SA','Spanier produzieren nicht nur Wein. Auch im Gin Herstellen sind sie Meister. Der GIN MARE ist der Beweis dafür.');
INSERT INTO `options` (`id`,`size`) VALUES (1,33),(2,50),(3,70),(4,100);
INSERT INTO `productsOptions` (`productId`,`optionId`,`price`) VALUES (1,1,3.30),(1,2,5.50),(2,1,3.30),(2,2,5.50),(3,1,4.00),(3,2,6.00),(4,1,2.50),(4,2,4.00),(5,1,3.00),(5,2,5.00),(6,1,2.00),(6,2,3.00),(7,1,1.95),(7,2,2.50),(8,1,2.50),(8,2,4.00),(9,1,1.80),(9,2,2.40),(10,1,3.00),(10,2,5.00);
INSERT INTO `productsOptions` (`productId`,`optionId`,`price`) VALUES (11,3,29.90),(11,4,39.90),(12,3,35.90),(12,4,48.90),(13,3,30.00),(13,4,40.00),(14,3,30.00),(14,4,40.00),(15,3,30.00),(15,4,40.00),(16,3,30.00),(16,4,40.00),(17,3,30.00),(17,4,40.00),(18,3,30.00),(18,4,40.00),(19,3,30.00),(19,4,40.00),(20,3,30.00),(20,4,40.00),(21,3,30.00),(21,4,40.00);
