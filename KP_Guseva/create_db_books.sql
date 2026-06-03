-- Создание базы данных
CREATE DATABASE `book_diary` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `book_diary`;

-- Таблица пользователей
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nickname` varchar(128) NOT NULL,
    `email` varchar(255) NOT NULL,
    `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
    `role` enum('admin', 'user') NOT NULL DEFAULT 'user',
    `password_hash` varchar(255) NOT NULL,
    `auth_token` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `nickname` (`nickname`),
    UNIQUE KEY `email` (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- Таблица книг
CREATE TABLE `books` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `title` varchar(255) NOT NULL,
    `author` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `rating` int(1) DEFAULT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- Таблица комментариев
CREATE TABLE `comments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `book_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `text` text NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `book_id` (`book_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
    CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- Добавляем тестового пользователя
INSERT INTO
    `users` (
        `nickname`,
        `email`,
        `is_confirmed`,
        `role`,
        `password_hash`,
        `auth_token`
    )
VALUES (
        'admin',
        'admin@example.com',
        1,
        'admin',
        '$2y$10$YourHashHere',
        'test_token'
    );
-- Для пароля "admin123" используйте: password_hash('admin123', PASSWORD_DEFAULT)

ALTER TABLE `books`
ADD `year` INT(4) NULL DEFAULT NULL AFTER `rating`;

-- Добавляем 10 тестовых книг
INSERT INTO `books` (`user_id`, `title`, `author`, `description`, `rating`, `year`) VALUES
(2, 'Война и мир', 'Лев Толстой', 'Роман-эпопея о жизни русского общества в эпоху Napoleonic wars', 5, 1869),
(1, 'Преступление и наказание', 'Фёдор Достоевский', 'Роман о моральных дилеммах и психологии преступника', 5, 1866),
(3, 'Мастер и Маргарита', 'Михаил Булгаков', 'Мистический роман о дьяволе, посетившем советскую Москву', 5, 1967),
(1, 'Анна Каренина', 'Лев Толстой', 'Трагическая история любви замужней женщины', 4, 1877),
(2, 'Отцы и дети', 'Иван Тургенев', 'Роман о конфликте поколений и нигилизме', 4, 1862),
(2, 'Тихий Дон', 'Михаил Шолохов', 'Эпопея о жизни донского казачества', 5, 1940),
(1, 'Двенадцать стульев', 'Илья Ильф, Евгений Петров', 'Сатирический роман о поисках сокровищ', 5, 1928),
(4, 'Собачье сердце', 'Михаил Булгаков', 'Повесть о профессоре, превратившем собаку в человека', 5, 1925);