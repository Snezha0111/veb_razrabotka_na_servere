<?php
require_once 'menu.php';

// Подключения к БД
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'phone_book');

$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno()) {
    die('Ошибка подключения к БД: ' . mysqli_connect_error());
}

// Пункт меню
$page = isset($_GET['p']) ? $_GET['p'] : 'viewer';
$allowed = ['viewer', 'add', 'edit', 'delete'];
if (!in_array($page, $allowed)) $page = 'viewer';
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>notebook</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="Logo_Polytech_rus_main.jpg" width="200px" alt="Логотип">
        <p>Лабораторная работа №5</p>
    </header>
    
    <?php echo getMenu($page, $mysqli); ?>
    
    <main>
        <?php
        switch ($page) {
            case 'viewer':
                include 'viewer.php';
                echo getViewerContent($mysqli);
                break;
            case 'add':
                include 'add.php';
                echo getAddContent($mysqli);
                break;
            case 'edit':
                include 'edit.php';
                echo getEditContent($mysqli);
                break;
            case 'delete':
                include 'delete.php';
                echo getDeleteContent($mysqli);
                break;
        }
        ?>
    </main>
    
    <footer>
        Задание для самостоятельной работы "Notebook"
    </footer>
</body>
</html>