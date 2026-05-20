CREATE DATABASE IF NOT EXISTS `readle_management`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `readle_management`;

CREATE TABLE IF NOT EXISTS `books` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `book_name` VARCHAR(180) NOT NULL,
    `author_name` VARCHAR(180) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `category` VARCHAR(120) NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    `book_image` LONGBLOB NOT NULL,
    `image_name` VARCHAR(255) NOT NULL,
    `image_mime` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
