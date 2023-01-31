CREATE DATABASE `blog`;
USE `blog`;

CREATE TABLE `user`(
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` CHAR(60) NOT NULL
);

CREATE TABLE `post`(
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `text` TEXT NOT NULL,
  `date` DATE NOT NULL,
  `user_id` INT NOT NULL,
  FOREIGN KEY(`user_id`) REFERENCES `user`(`id`)
);
