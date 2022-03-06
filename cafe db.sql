CREATE DATABASE `CafeteriaDB` ;
 
 use CafeteriaDB ;

CREATE TABLE `Users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `finame` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `image_url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `Products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `Price` double DEFAULT NULL,
  `image_url` varchar(200) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `desc` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `by_admin` tinyint DEFAULT NULL,
  `room` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_order_fk_idx` (`user_id`),
  CONSTRAINT `user_order_fk` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Order_Product` (
  `order_id` int NOT NULL,
  `prd_id` int NOT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`order_id`,`prd_id`),
  KEY `order_product_fk_idx` (`prd_id`),
  CONSTRAINT `order_product_fk` FOREIGN KEY (`prd_id`) REFERENCES `Products` (`id`),
  CONSTRAINT `product_order_fk` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  `room` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_user_fk_idx` (`user_id`),
  CONSTRAINT `cart_user_fk` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `Cart_Product` (
  `cart_id` int NOT NULL,
  `prd_id` int NOT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`cart_id`,`prd_id`),
  KEY `cart_prd_fk_idx` (`prd_id`),
  CONSTRAINT `cart_prd_fk` FOREIGN KEY (`prd_id`) REFERENCES `Products` (`id`),
  CONSTRAINT `prd_cart_fk` FOREIGN KEY (`cart_id`) REFERENCES `Carts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# add category

CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



ALTER TABLE `CafeteriaDB`.`Products` 
ADD COLUMN `category_id` INT NULL AFTER `desc`,
ADD INDEX `product_category_fk_idx` (`category_id` ASC) VISIBLE;
;
ALTER TABLE `CafeteriaDB`.`Products` 
ADD CONSTRAINT `product_category_fk`
  FOREIGN KEY (`category_id`)
  REFERENCES `CafeteriaDB`.`category` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



# specifying enumerates

ALTER TABLE cafeteriadb.users MODIFY COLUMN role enum("admin", "user") DEFAULT "user";

ALTER TABLE cafeteriadb.orders MODIFY COLUMN by_admin enum("yes", "no") DEFAULT "no";


