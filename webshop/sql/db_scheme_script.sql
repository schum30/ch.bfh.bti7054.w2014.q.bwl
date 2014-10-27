CREATE TABLE Beverage(
	ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Name varchar(30) NOT NULL,
	Manufacturer varchar(30),
	Picture blob,
	Description	varchar(500),
	Type varchar(10),
	ABV int
);
CREATE TABLE Bottle(
	ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Type	varchar(30),
	BeverageType varchar(30),
	BottleSize int
);
CREATE TABLE BeverageBottle(
	ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    IdBeverage int,
	IdBottle int,
	Price decimal(5,2),
	Depot decimal(5,2),
    FOREIGN KEY (idBeverage) REFERENCES Beverage(ID),
    FOREIGN KEY (idBottle) REFERENCES Bottle(ID)
);
CREATE TABLE Box(
	ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Price decimal(5,2),
	BoxSize int,
	BeverageType varchar(30),
	MinBottleSize int,
	MaxBottleSize int
);
CREATE TABLE Customer(
	ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	FirstName varchar(30),
	LastName varchar(30),
	Address varchar(30),
	EMail varchar(30),
);
CREATE TABLE Order(
	ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	CustomerID int,
	DeliveryAddress varchar(30),
	OrderDate date,
	OrderState varchar(30),
	FOREIGN KEY(CustomerID) REFERENCES Customer(ID)
);
CREATE TABLE OrderedBottle(
	BottleID int,
	Price decimal(5,2),
	Depot decimal(5,2),
	Quantity int,
	OrderID int,
	PRIMARY KEY(BottleID, OrderID),
	FOREIGN KEY(BottleID) REFERENCES Bottle(ID),
	FOREIGN KEY(OrderID) REFERENCES Order(ID),
);

INSERT INTO Beverage
(Name, Manufacturer, Type, ABV)
VALUES
('Aare Bier Amber', 'Aare Bier', 'Bier', 5);

INSERT INTO Bottle
(Type, BeverageType, BottleSize)
VALUES
('Flasche','Bier',50);

INSERT INTO BeverageBottle
(IdBeverage,IdBottle,Price,Depot)
VALUES
(1,1,3.30,0.30);

INSERT INTO Box
(Price, BoxSize, BeverageType, MinBottleSize, MaxBottleSize)
VALUES
(4.95,6, 'Bier', 50, 50)
