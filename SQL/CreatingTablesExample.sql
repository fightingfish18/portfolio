USE wsmay1;

/*

William Smyth May
2014-02-16
Lab 3

PLEASE NOTE: For orderStatusID, it is either an int 1 for fulfilled, or 2 for unfulfilled, which is noticeable in my WHERE clauses for the queries.

*/

/* 1. Create a view that returns currently unfulfilled orders (return a list of all the productNames and their orderID where the orderStatus is unfulfilled) */

SELECT productName, co.orderID
FROM Customer_Orders co
JOIN Customer_Orders_Products cop ON co.orderID = cop.orderID
JOIN Products p ON cop.productID = p.productID
WHERE co.orderStatusID = 2;

/* 2. Create a view that returns the list of customer names and phone numbers for those with unfulfilled orders */

SELECT fName, lName, phone
FROM Customers c
JOIN Customer_Orders co ON co.customerID = c.customerID
WHERE co.orderStatusID = 2

/* Creating the tables in the database */

CREATE TABLE Customers
(
	[customerID] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	[fName] NCHAR (10) NOT NULL,
	[lName] NCHAR (10) NOT NULL,
	[phone] NCHAR (12) NOT NULL,
	[adressLine1] NCHAR (30) NOT NULL,
	[adressLine2] NCHAR (30),
	[city] NCHAR (30) NOT NULL,
	[state] NCHAR (30) NOT NULL,
	[zipCode] INT NOT NULL,
);

CREATE TABLE Products
(
	[productID] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	[productName] NCHAR (40) NOT NULL,
	[productVendorID] INT NOT NULL,
	[productDescription] NCHAR (1200) NOT NULL,
	[quantity] INT NOT NULL,
	[price] MONEY NOT NULL,
);

CREATE TABLE Addresses
(
	[addressID] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	[line1] NCHAR (45) NOT NULL,
	[line2] NCHAR (45),
	[city] NCHAR (20) NOT NULL,
	[zipCode] INT NOT NULL,
	[state] NCHAR (2),
);

CREATE TABLE Customer_Addresses
(
	[customerID] INT FOREIGN KEY REFERENCES Customers(customerID),
	[addressID] INT FOREIGN KEY REFERENCES Addresses(addressID),
);

CREATE TABLE Customers_Payment_Methods
(
	[paymentMethodID] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	[customerID] INT FOREIGN KEY REFERENCES Customers(customerID),
	[cardNumber] INT NOT NULL,
	[monthExp] INT NOT NULL,
	[yearExp] INT NOT NULL,
	[securityCode] INT NOT NULL,
);

CREATE TABLE Customer_Orders
(
	[orderID] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	[customerID] INT FOREIGN KEY REFERENCES Customers(customerID),
	[paymentMethodID] INT FOREIGN KEY REFERENCES Customers_Payment_Methods(paymentMethodID),
	[orderStatusID] INT NOT NULL,
	[datePlaced] DATETIME NOT NULL,
	[totalPrice] MONEY,
);

CREATE TABLE Customer_Orders_Products
(
	[orderID] INT FOREIGN KEY REFERENCES Customer_orders(orderID),
	[productID] INT FOREIGN KEY REFERENCES Products(productID),
	[quantity] INT,
);

/*	Inserting dummy data into each table */
INSERT INTO dbo.Addresses
	([line1], [city], [zipCode], [state])
VALUES
	('6202 Jordan Drive', 'Pearland', '72684', 'TX')

INSERT INTO dbo.Addresses
	([line1], [city], [zipCode], [state])
VALUES
	('139 Haryu Road', 'Longview', '98632', 'WA')

INSERT INTO dbo.Addresses
	([line1], [city], [zipCode], [state])
VALUES
	('1800 NE 47th Street', 'Seattle', '98105', 'WA')

INSERT INTO dbo.Addresses
	([line1], [line2], [city], [zipCode], [state])
VALUES
	('Haggett Hall', 'Room 409', 'Seattle', '98195', 'WA')

INSERT INTO dbo.Addresses
	([line1], [city], [zipCode], [state])
VALUES
	('1509 Ridgepark Road', 'Harrison', '72601', 'AR')

INSERT INTO dbo.Customers
	([fName], [lName], [phone], [state])
VALUES
	('John', 'Doe', '5555556666', 'VA')


INSERT INTO dbo.Customers
	([fName], [lName], [phone], [state])
VALUES
	('Jane', 'Deer', '5555556667', 'AR')

INSERT INTO dbo.Customers
	([fName], [lName], [phone], [state])
VALUES
	('Susie', 'Anthony', '5555556668', 'AK')

INSERT INTO dbo.Customers
	([fName], [lName], [phone], [state])
VALUES
	('Will', 'Black', '5555556669', 'TX')

INSERT INTO dbo.Customers
	([fName], [lName], [phone], [state])
VALUES
	('Lauren', 'Taylor', '5555556670', 'OR')

INSERT INTO dbo.Customers_Payment_Methods
	([customerID], [cardNumber], [monthExp], [yearExp], [securityCode])
VALUES
	(01, 6079777740112233, 12, 15, 000)

INSERT INTO dbo.Customers_Payment_Methods
	([customerID], [cardNumber], [monthExp], [yearExp], [securityCode])
VALUES
	(05, 6079777740112234, 12, 15, 000)

INSERT INTO dbo.Customers_Payment_Methods
	([customerID], [cardNumber], [monthExp], [yearExp], [securityCode])
VALUES
	(02, 6079777740112235, 12, 15, 000)

INSERT INTO dbo.Customers_Payment_Methods
	([customerID], [cardNumber], [monthExp], [yearExp], [securityCode])
VALUES
	(03, 6079777740112236, 12, 15, 000)

INSERT INTO dbo.Customers_Payment_Methods
	([customerID], [cardNumber], [monthExp], [yearExp], [securityCode])
VALUES
	(04, 6079777740112237, 12, 15, 000)

INSERT INTO dbo.Vendors
	([vendorName], [vendorPhone], [vendorEmail])
VALUES
	('Amazon', '7778889999', 'amazon@amazon.com')

INSERT INTO dbo.Vendors
	([vendorName], [vendorPhone], [vendorEmail])
VALUES
	('Tiger Direct', '6778889999', 'tiger@gmail.com')

INSERT INTO dbo.Vendors
	([vendorName], [vendorPhone], [vendorEmail])
VALUES
	('Buy.com', '5778889999', 'buy@buy.com')

INSERT INTO dbo.Vendors
	([vendorName], [vendorPhone], [vendorEmail])
VALUES
	('WalMart', '4778889999', 'walmart@hotmail.com')

INSERT INTO dbo.Vendors
	([vendorName], [vendorPhone], [vendorEmail])
VALUES
	('Costco', '3778889999', 'John@costco.com')

INSERT INTO dbo.Products
	([productName], [productVendorID], [productDescription], [quantity], [price])
VALUES
	('Spang', 01, 'Something Awesome', 8, 12.50)

INSERT INTO dbo.Products
	([productName], [productVendorID], [productDescription], [quantity], [price])
VALUES
	('Eggs', 02, 'A basic egg', 120, .50)

INSERT INTO dbo.Products
	([productName], [productVendorID], [productDescription], [quantity], [price])
VALUES
	('Tablet', 03, 'Nexus 10', 5, 399.99)

INSERT INTO dbo.Products
	([productName], [productVendorID], [productDescription], [quantity], [price])
VALUES
	('Mouse', 04, 'A Logitech Mouse', 10, 79.99)

INSERT INTO dbo.Products
	([productName], [productVendorID], [productDescription], [quantity], [price])
VALUES
	('Keyboard', 05, 'Mechanical Keyboard', 15, 119.99)

INSERT INTO dbo. Customer_Orders
	([customerID], [paymentMethodID], [orderStatusID], [datePlaced], [totalPrice])
VALUES
	(01, 02, 02, 01/18/2014, 100)
	
INSERT INTO dbo. Customer_Orders
	([customerID], [paymentMethodID], [orderStatusID], [datePlaced], [totalPrice])
VALUES
	(02, 04, 02, 01/18/2014, 80)

INSERT INTO dbo. Customer_Orders
	([customerID], [paymentMethodID], [orderStatusID], [datePlaced], [totalPrice])
VALUES
	(03, 05, 01, 12/14/2013, 120)

INSERT INTO dbo. Customer_Orders
	([customerID], [paymentMethodID], [orderStatusID], [datePlaced], [totalPrice])
VALUES
	(04, 06, 01, 11/15/2013, 10)

INSERT INTO dbo. Customer_Orders
	([customerID], [paymentMethodID], [orderStatusID], [datePlaced], [totalPrice])
VALUES
	(05, 03, 02, 02/14/2014, 1000)
	
INSERT INTO dbo.Customer_Orders_Products
	([orderID], [productID], [quantity])
VALUES
	(02, 01, 5)

INSERT INTO dbo.Customer_Orders_Products
	([orderID], [productID], [quantity])
VALUES
	(03, 02, 1)

INSERT INTO dbo.Customer_Orders_Products
	([orderID], [productID], [quantity])
VALUES
	(04, 03, 3)

INSERT INTO dbo.Customer_Orders_Products
	([orderID], [productID], [quantity])
VALUES
	(05, 04, 2)

INSERT INTO dbo.Customer_Orders_Products
	([orderID], [productID], [quantity])
VALUES
	(06, 05, 5)

INSERT INTO dbo.Customer_Addresses
	([customerID], [addressID])
VALUES
	(01, 01)

INSERT INTO dbo.Customer_Addresses
	([customerID], [addressID])
VALUES
	(02, 02)

INSERT INTO dbo.Customer_Addresses
	([customerID], [addressID])
VALUES
	(03, 03)

INSERT INTO dbo.Customer_Addresses
	([customerID], [addressID])
VALUES
	(04, 04)

INSERT INTO dbo.Customer_Addresses
	([customerID], [addressID])
VALUES
	(05, 05)


