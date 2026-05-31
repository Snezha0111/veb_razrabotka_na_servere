-- Active: 1779285509231@@localhost@3306
-- Создание базы данных
CREATE DATABASE `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blog`;

-- Таблица пользователей
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nickname` varchar(128) NOT NULL,
    `email` varchar(255) NOT NULL,
    `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
    `role` enum('admin','user') NOT NULL,
    `password_hash` varchar(255) NOT NULL,
    `auth_token` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nickname` (`nickname`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Таблица статей
CREATE TABLE `articles` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `author_id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `text` text NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Добавляем пользователей
INSERT INTO `users` (`nickname`, `email`, `is_confirmed`, `role`, `password_hash`, `auth_token`) VALUES
('admin', 'admin@gmail.com', 1, 'admin', 'hash1', 'token1'),
('user', 'user@gmail.com', 1, 'user', 'hash2', 'token2');

-- Добавляем статьи
INSERT INTO `articles` (`author_id`, `name`, `text`) VALUES
(1, 'Статья №1', 'Текст первой статьи. Предположим, что здесь очень важный текст. и на него надо смотреть с соответсвующим лицом'),
(1, 'Статья №2', 'Текст второй статьи. А здесь что-то очень веселое... Было когда-то');