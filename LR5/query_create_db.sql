CREATE DATABASE phone_book;

USE phone_book;

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surname VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    lastname VARCHAR(100),
    gender ENUM('мужской', 'женский'),
    birthdate DATE,
    phone VARCHAR(20),
    address TEXT,
    email VARCHAR(100),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);