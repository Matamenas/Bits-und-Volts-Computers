CREATE DATABASE customerDB;
 use customerDB;
 CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30),
    lastname VARCHAR(30),
    address VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(18),
    cart_id INT,
    FOREIGN KEY (cart_id) REFERENCES cart(id)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    stock INT,
    created_at TIMESTAMP
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    product_id INT,
    quantity INT,
    created_at TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customer(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
