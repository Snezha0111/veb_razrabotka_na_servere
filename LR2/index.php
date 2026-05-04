<!DOCTYPE html>
<html lang="ru">
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
            <p>Лабораторная работа 2</p>
        </header>
        <main>
            <div class="form-box">
                <h2>Форма обратной связи</h2>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $data = [
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'type' => $_POST['type'],
                        'message' => $_POST['message'],
                        'response' => $_POST['response'] ?? []
                    ];
                    
                    $ch = curl_init('https://httpbin.org/post');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
                    echo '<p style="color:green;">Отправлено! Код: ' . http_response_code() . '</p>';
                }
                ?>
                <form method="POST">
                    <input type="text" name="name" placeholder="Имя пользователя" required>
                    <input type="email" name="email" placeholder="E-mail пользователя" required>
                    
                    <select name="type" required>
                        <option value="">Тип обращения</option>
                        <option value="complaint">Жалоба</option>
                        <option value="suggestion">Предложение</option>
                        <option value="gratitude">Благодарность</option>
                    </select>
                    
                    <textarea name="message" rows="5" placeholder="Текст обращения" required></textarea>
                    
                    <label>Вариант ответа:</label>
                    <label>
                        <input type="checkbox" name="response[]" value="sms"> 
                        SMS
                    </label>
                    <label>
                        <input type="checkbox" name="response[]" value="email"> 
                        E-mail
                    </label>

                    <button type="submit">Отправить</button>
                    <a href="headers.php" class="btn">Перейти на 2 страницу</a>
                </form>
            </div>
        </main>
        
        <footer>
            Задание для самостоятельной работы "Feedback form"
        </footer>
    </div>

</body>
</html>