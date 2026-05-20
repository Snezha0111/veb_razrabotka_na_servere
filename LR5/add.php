<?php
function getAddContent($mysqli) {
    $message = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button']) && $_POST['button'] == 'Добавить запись') {
        $surname = isset($_POST['surname']) ? htmlspecialchars(trim($_POST['surname'])) : '';
        $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
        $lastname = isset($_POST['lastname']) ? htmlspecialchars(trim($_POST['lastname'])) : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $birthdate = isset($_POST['date']) && !empty($_POST['date']) ? $_POST['date'] : null;
        $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
        $address = isset($_POST['location']) ? htmlspecialchars(trim($_POST['location'])) : '';
        $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
        $comment = isset($_POST['comment']) ? htmlspecialchars(trim($_POST['comment'])) : '';
        
        if (empty($surname) || empty($name)) {
            $message = '<div class="error">Ошибка: Фамилия и Имя обязательны</div>';
        } else {
            $sql = "INSERT INTO contacts (surname, name, lastname, gender, birthdate, phone, address, email, comment)
                    VALUES ('$surname', '$name', '$lastname', '$gender', " . ($birthdate ? "'$birthdate'" : "NULL") . ", '$phone', '$address', '$email', '$comment')";
            
            if (mysqli_query($mysqli, $sql)) {
                $message = '<div class="success">Запись добавлена</div>';
            } else {
                $message = '<div class="error">Ошибка: запись не добавлена</div>';
            }
        }
    }
    
    $html = $message;
    $html .= '<form name="form_add" method="post" class="add-form">
        <div class="column">
            <div class="add"><label>Фамилия *</label><input type="text" name="surname" placeholder="Фамилия" required></div>
            <div class="add"><label>Имя *</label><input type="text" name="name" placeholder="Имя" required></div>
            <div class="add"><label>Отчество</label><input type="text" name="lastname" placeholder="Отчество"></div>
            <div class="add">
                <label>Пол</label>
                <select name="gender">
                    <option value="мужской">мужской</option>
                    <option value="женский">женский</option>
                </select>
            </div>
            <div class="add"><label>Дата рождения</label><input type="date" name="date"></div>
            <div class="add"><label>Телефон</label><input type="text" name="phone" placeholder="Телефон"></div>
            <div class="add"><label>Адрес</label><input type="text" name="location" placeholder="Адрес"></div>
            <div class="add"><label>Email</label><input type="email" name="email" placeholder="Email"></div>
            <div class="add"><label>Комментарий</label><textarea name="comment" placeholder="Краткий комментарий"></textarea></div>
            <button type="submit" value="Добавить запись" name="button" class="form-btn">Добавить запись</button>
        </div>
    </form>';
    
    return $html;
}
?>