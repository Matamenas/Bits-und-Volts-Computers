-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema bitsundvoltsfinal2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bitsundvoltsfinal2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bitsundvoltsfinal2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `bitsundvoltsfinal2` ;

-- -----------------------------------------------------
-- Table `bitsundvoltsfinal2`.`checkout`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitsundvoltsfinal2`.`checkout` (
  `checkout_id` INT NOT NULL AUTO_INCREMENT,
  `deliveryType` VARCHAR(75) NOT NULL,
  PRIMARY KEY (`checkout_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `bitsundvoltsfinal2`.`basket`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitsundvoltsfinal2`.`basket` (
  `basket_id` INT NOT NULL AUTO_INCREMENT,
  `quantity` INT NOT NULL,
  `Checkout_checkout_id` INT NOT NULL,
  PRIMARY KEY (`basket_id`, `Checkout_checkout_id`),
  INDEX `fk_Basket_Checkout1_idx` (`Checkout_checkout_id` ASC) VISIBLE,
  CONSTRAINT `fk_Basket_Checkout1`
    FOREIGN KEY (`Checkout_checkout_id`)
    REFERENCES `bitsundvoltsfinal2`.`checkout` (`checkout_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `bitsundvoltsfinal2`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitsundvoltsfinal2`.`customer` (
  `cust_id` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(50) NOT NULL,
  `lastName` VARCHAR(50) NOT NULL,
  `address` VARCHAR(75) NOT NULL,
  `emailAddress` VARCHAR(50) NOT NULL,
  `paymentType` VARCHAR(75) NOT NULL,
  `paymentDetails` INT NOT NULL,
  `userPassword` VARCHAR(255),
  PRIMARY KEY (`cust_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `bitsundvoltsfinal2`.`customerservice`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitsundvoltsfinal2`.`customerservice` (
  `custService_id` INT NOT NULL AUTO_INCREMENT,
  `dateOfService` DATE NOT NULL,
  `description` VARCHAR(200) NOT NULL,
  `Customer_cust_id` INT NOT NULL,
  PRIMARY KEY (`custService_id`),
  INDEX `fk_CustomerService_Customer1_idx` (`Customer_cust_id` ASC) VISIBLE,
  CONSTRAINT `fk_CustomerService_Customer1`
    FOREIGN KEY (`Customer_cust_id`)
    REFERENCES `bitsundvoltsfinal2`.`customer` (`cust_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `bitsundvoltsfinal2`.`login`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitsundvoltsfinal2`.`login` (
  `logIn_id` INT NOT NULL AUTO_INCREMENT,
  `Customer_cust_id` INT NOT NULL,
  PRIMARY KEY (`logIn_id`),
  `userPassword` VARCHAR(255),
  INDEX `fk_LogIn_Customer1_idx` (`Customer_cust_id` ASC) VISIBLE,
  CONSTRAINT `fk_LogIn_Customer1`
    FOREIGN KEY (`Customer_cust_id`)
    REFERENCES `bitsundvoltsfinal2`.`customer` (`cust_id`))
    
    
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `bitsundvoltsfinal2`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitsundvoltsfinal2`.`orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `cust_id` INT NULL DEFAULT NULL,
  `orderDate` VARCHAR(50) NOT NULL,
  `subTotal` DOUBLE NOT NULL,
  `status` VARCHAR(25) NOT NULL,
  `Basket_basket_id` INT NOT NULL,
  PRIMARY KEY (`order_id`, `Basket_basket_id`),
  INDEX `cust_id` (`cust_id` ASC) VISIBLE,
  INDEX `fk_Orders_Basket1_idx` (`Basket_basket_id` ASC) VISIBLE,
  CONSTRAINT `fk_Orders_Basket1`
    FOREIGN KEY (`Basket_basket_id`)
    REFERENCES `bitsundvoltsfinal2`.`basket` (`basket_id`),
  CONSTRAINT `orders_ibfk_1`
    FOREIGN KEY (`cust_id`)
    REFERENCES `bitsundvoltsfinal2`.`customer` (`cust_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `bitsundvoltsfinal2`.`product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitsundvoltsfinal2`.`product` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(75) NOT NULL,
  `description` VARCHAR(75) NOT NULL,
  `price` DOUBLE NOT NULL,
  `quantityStock` INT NOT NULL,
  `Basket_basket_id` INT NOT NULL,
  `Basket_Checkout_checkout_id` INT NOT NULL,
  PRIMARY KEY (`product_id`),
  INDEX `fk_Product_Basket1_idx` (`Basket_basket_id` ASC, `Basket_Checkout_checkout_id` ASC) VISIBLE,
  CONSTRAINT `fk_Product_Basket1`
    FOREIGN KEY (`Basket_basket_id` , `Basket_Checkout_checkout_id`)
    REFERENCES `bitsundvoltsfinal2`.`basket` (`basket_id` , `Checkout_checkout_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `bitsundvoltsfinal2`.`signup`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bitsundvoltsfinal2`.`signup` (
  `signUp_id` INT NOT NULL AUTO_INCREMENT,
  `Customer_cust_id` INT NULL DEFAULT NULL,
  `signUpDate` DATE NOT NULL,
  `cust_id` INT NOT NULL,
  PRIMARY KEY (`signUp_id`),
  INDEX `fk_SignUp_Customer1_idx` (`Customer_cust_id` ASC) VISIBLE,
  CONSTRAINT `fk_SignUp_Customer1`
    FOREIGN KEY (`Customer_cust_id`)
    REFERENCES `bitsundvoltsfinal2`.`customer` (`cust_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;