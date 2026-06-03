<?php
return [
    // Главная страница
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    
    // Книги
    '~^books/(\d+)$~' => [\MyProject\Controllers\BooksController::class, 'view'],
    '~^books/add$~' => [\MyProject\Controllers\BooksController::class, 'add'],
    '~^books/create$~' => [\MyProject\Controllers\BooksController::class, 'create'],
    '~^books/(\d+)/edit$~' => [\MyProject\Controllers\BooksController::class, 'edit'],
    '~^books/(\d+)/update$~' => [\MyProject\Controllers\BooksController::class, 'update'],
    '~^books/(\d+)/delete$~' => [\MyProject\Controllers\BooksController::class, 'delete'],
    
    // Комментарии
    '~^books/(\d+)/comments/add$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
    '~^books/(\d+)/comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^books/(\d+)/comments/(\d+)/update$~' => [\MyProject\Controllers\CommentsController::class, 'update'],
    '~^books/(\d+)/comments/(\d+)/delete$~' => [\MyProject\Controllers\CommentsController::class, 'delete'],
    
    // Пользователи
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
];