CREATE DATABASE IF NOT EXISTS customerDB;
USE customerDB;

SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    created_at TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    stock INT,
    created_at TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_date TIMESTAMP,
    total_amount DECIMAL(10,2),
    status ENUM('pending','processing','completed','cancelled'),
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);

CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT,
    product_id INT,
    quantity INT,
    shipping_cost DECIMAL(10,2),
    FOREIGN KEY (cart_id) REFERENCES cart(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_id INT,
    ticket_date TIMESTAMP,
    issue_text TEXT,
    status ENUM('open','closed'),
    FOREIGN KEY (customer_id) REFERENCES customer(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

CREATE TABLE IF NOT EXISTS customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30),
    lastname VARCHAR(30),
    address VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(18),
    cart_id INT,
    FOREIGN KEY (cart_id) REFERENCES cart(id)
);

SET FOREIGN_KEY_CHECKS = 1;

-- Insert B650 MotherBoard
INSERT INTO products (name, description, price) 
VALUES ('B650 MotherBoard', 'High-performance motherboard suitable for gaming and professional use.', 149.99);

-- Insert Corsair 4000D
INSERT INTO products (name, description, price) 
VALUES ('Corsair 4000D', 'Mid-tower computer case with ample space for high-end components and excellent airflow.', 89.99);

-- Insert Corsair RM1000
INSERT INTO products (name, description, price) 
VALUES ('Corsair RM1000', '1000W power supply unit (PSU) with 80 PLUS Gold efficiency certification.', 179.99);

-- Insert Ryzen 7 5250X
INSERT INTO products (name, description, price) 
VALUES ('Ryzen 7 5250X', '8-core, 16-thread processor from AMD, ideal for gaming and multitasking.', 349.99);

-- Insert GTX 1080ti
INSERT INTO products (name, description, price) 
VALUES ('GTX 1080ti', 'High-performance graphics card with 11GB GDDR5X memory, suitable for 4K gaming and VR.', 499.99);

-- Insert 4TB Hard Disk
INSERT INTO products (name, description, price) 
VALUES ('4TB Hard Disk', 'High-capacity hard disk drive (HDD) for storing large amounts of data.', 99.99);

-- Insert AIO Cooler
INSERT INTO products (name, description, price) 
VALUES ('AIO Cooler', 'All-in-one liquid CPU cooler for efficient cooling and low noise levels.', 79.99);

-- Insert 2x8GB RAM
INSERT INTO products (name, description, price) 
VALUES ('2x8GB RAM', '16GB DDR4 memory kit (2x8GB) for fast and reliable performance.', 79.99);

-- Insert 1TB Solid State Drive
INSERT INTO products (name, description, price) 
VALUES ('1TB Solid State Drive', 'High-speed solid state drive (SSD) with 1TB capacity for fast boot times and data access.', 149.99);


-- Insert Admin Account
INSERT INTO customer (firstname, lastname, address, email, password) 
VALUES ('Admin', 'Mister', '123 Admin St', 'Admin123@gmail.com', 'admin');

-- Insert Regular Account
INSERT INTO customer (firstname, lastname, address, email, password) 
VALUES ('Test', 'User', '456 Regular St', 'testuser@gmail.com', 'test');