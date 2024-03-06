-- Creating our Database called 'ComputerDatabase' using the 'CREATE DATABASE' Keyword
CREATE DATABASE IF NOT EXISTS BitsUndVoltsFINAL;

-- We then want to use our Database called 'ComputerDatabase', so we switch
-- to it using the 'USE' Keyword
USE BitsUndVoltsFINAL;

-- Creating SignUp table first as it's referenced by the Customer table
CREATE TABLE SignUp (
    signUp_id INT PRIMARY KEY,
    cust_id INT,
    signUpDate DATE NOT NULL
);

-- Creating Customer table after SignUp and Checkout tables
CREATE TABLE Customer (
    cust_id INT PRIMARY KEY auto_increment,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    address VARCHAR(75) NOT NULL,
    emailAddress VARCHAR(50) NOT NULL,
    paymentType VARCHAR(75) NOT NULL,
    paymentDetails INT NOT NULL,
    userPassword VARCHAR (50) NOT NULL,
    signUp_id INT,
	FOREIGN KEY (signUp_id) REFERENCES SignUp (signUp_id)
);

-- Creating Checkout table before Customer table as it's referenced by the Customer table
CREATE TABLE Checkout (
    checkout_id INT PRIMARY KEY,
    deliveryType VARCHAR(75) NOT NULL,
    cust_id INT,
    FOREIGN KEY (cust_id) REFERENCES Customer (cust_id)
);

-- Creating LogIn table after Customer table as it references Customer table
CREATE TABLE LogIn (
    logIn_id INT PRIMARY KEY,
    cust_id INT,
    FOREIGN KEY (cust_id) REFERENCES Customer (cust_id)
);

-- Creating Product table after Customer table as Basket table references it
CREATE TABLE Product (
    product_id INT PRIMARY KEY,
    name VARCHAR(75) NOT NULL,
    description VARCHAR(75) NOT NULL,
    price DOUBLE NOT NULL,
    quantityStock INT NOT NULL
);

-- Creating Basket table after Customer and Product tables as it references both
CREATE TABLE Basket (
    basket_id INT PRIMARY KEY,
    cust_id INT,
    product_id INT,
    quantity INT NOT NULL,
    FOREIGN KEY (cust_id) REFERENCES Customer (cust_id),
    FOREIGN KEY (product_id) REFERENCES Product (product_id)
);

-- Creating CustomerService table after Customer table as it references Customer table
CREATE TABLE CustomerService (
    custService_id INT PRIMARY KEY,
    cust_id INT,
    description VARCHAR(200) NOT NULL,
    FOREIGN KEY (cust_id) REFERENCES Customer (cust_id)
);

-- Creating Orders table after Customer table as it references Customer table
CREATE TABLE Orders (
    order_id INT PRIMARY KEY,
    cust_id INT,
    orderDate VARCHAR(50) NOT NULL,
    subTotal DOUBLE NOT NULL,
    status VARCHAR(25) NOT NULL,
    FOREIGN KEY (cust_id) REFERENCES Customer (cust_id)
);

