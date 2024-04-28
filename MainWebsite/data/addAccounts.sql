USE customerDB;

-- Insert Admin Account
INSERT INTO customer (firstname, lastname, address, email, password) 
VALUES ('Admin', 'Mister', '123 Admin St', 'Admin123@gmail.com', 'admin');

-- Insert Regular Account
INSERT INTO customer (firstname, lastname, address, email, password) 
VALUES ('Test', 'User', '456 Regular St', 'testuser@gmail.com', 'test');