<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат get_headers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

   <div class="container">
        <header>
            <img src="Logo_Polytech_rus_main.jpg" width="200px" alt="Логотип МосПолитеха">
            <p>Лабораторная работа 2</p>
        </header>
        <main>
            <div class="form-box">
                <h2>Результат работы функции get_headers</h2>
                
                <textarea rows="20">
                <?php
                $headers = get_headers('https://httpbin.org', 1);
                print_r($headers);
                ?>
                </textarea>
                
                <br><br>
                <a href="index.php" class="btn">← Назад к форме</a>
            </div>
        </main>

        <footer>
            Задание для самостоятельной работы "Feedback form"
        </footer>
    </div>
</body>
</html>