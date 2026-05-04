<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        echo "<link rel='stylesheet' href='style.css'>";
    ?>
</head>
<body>
    <div class="container">
        <header>
            <img src="Logo_Polytech_rus_main.jpg" width="200px" alt="Логотип МосПолитеха">
            <p>Лабораторная работа 1</p>
        </header>
        <main>
            <p><?php 
                date_default_timezone_set('Europe/Moscow');
                echo "Hello, world!<br>Московсое время: ".date('H:i:s');
            ?></p>
        </main>
        <footer>
            <p>Задание для самостоятельной работы «Hello, World!»</p>
        </footer>
    </div>
</body>
</html>