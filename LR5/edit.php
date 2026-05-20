<?php
function getEditContent($mysqli) {
    $message = '';
    
    $currentId = isset($_GET['id']) ? (int)$_GET['id'] : null;
    
    // Обработка изменения записи
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button']) && $_POST['button'] == 'Изменить запись') {
        $id = (int)$_POST['id'];
        
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
            $sql = "UPDATE contacts SET 
                    surname='$surname', 
                    name='$name', 
                    lastname='$lastname', 
                    gender='$gender', 
                    birthdate=" . ($birthdate ? "'$birthdate'" : "NULL") . ",
                    phone='$phone', 
                    address='$address', 
                    email='$email', 
                    comment='$comment' 
                    WHERE id=$id";
            
            if (mysqli_query($mysqli, $sql)) {
                $message = '<div class="success">Запись изменена</div>';
            } else {
                $message = '<div class="error">Ошибка: запись не изменена</div>';
            }
        }
    }
    
    // Получаем текущую запись
    $currentRow = null;
    if ($currentId) {
        $res = mysqli_query($mysqli, "SELECT * FROM contacts WHERE id=$currentId");
        $currentRow = mysqli_fetch_assoc($res);
    }
    
    if (!$currentRow) {
        $res = mysqli_query($mysqli, "SELECT * FROM contacts ORDER BY id LIMIT 1");
        $currentRow = mysqli_fetch_assoc($res);
        if ($currentRow) $currentId = $currentRow['id'];
    }
    
    // Список всех записей
    $listRes = mysqli_query($mysqli, "SELECT id, surname, name, lastname FROM contacts ORDER BY surname, name");
    
    $html = $message;
    $html .= '<div class="edit-links">';
    if (mysqli_num_rows($listRes) > 0) {
        while ($row = mysqli_fetch_assoc($listRes)) {
            $fio = $row['surname'] . ' ' . mb_substr($row['name'], 0, 1) . '.';
            if (!empty($row['lastname'])) {
                $fio .= ' ' . mb_substr($row['lastname'], 0, 1) . '.';
            }
            
            $class = ($currentId == $row['id']) ? 'currentRow' : '';
            $html .= '<a href="index.php?p=edit&id=' . $row['id'] . '" class="' . $class . '">' . htmlspecialchars($fio) . '</a>';
        }
    } else {
        $html .= '<div class="info">Записей пока нет</div>';
    }
    $html .= '</div>';
    
    // Форма редактирования
    if ($currentRow) {
        $birthdateValue = '';
        if (!empty($currentRow['birthdate']) && $currentRow['birthdate'] != '0000-00-00') {
            $birthdateValue = $currentRow['birthdate'];
        }
        
        $html .= '<form name="form_edit" method="post" class="add-form">
            <div class="column">
                <div class="add">
                    <label>Фамилия *</label>
                    <input type="text" name="surname" value="' . htmlspecialchars($currentRow['surname'] ?? '') . '" required>
                </div>
                <div class="add">
                    <label>Имя *</label>
                    <input type="text" name="name" value="' . htmlspecialchars($currentRow['name'] ?? '') . '" required>
                </div>
                <div class="add">
                    <label>Отчество</label>
                    <input type="text" name="lastname" value="' . htmlspecialchars($currentRow['lastname'] ?? '') . '">
                </div>
                <div class="add">
                    <label>Пол</label>
                    <select name="gender">
                        <option ' . (($currentRow['gender'] ?? '') == 'мужской' ? 'selected' : '') . '>мужской</option>
                        <option ' . (($currentRow['gender'] ?? '') == 'женский' ? 'selected' : '') . '>женский</option>
                    </select>
                </div>
                <div class="add">
                    <label>Дата рождения</label>
                    <input type="date" name="date" value="' . $birthdateValue . '">
                </div>
                <div class="add">
                    <label>Телефон</label>
                    <input type="text" name="phone" value="' . htmlspecialchars($currentRow['phone'] ?? '') . '">
                </div>
                <div class="add">
                    <label>Адрес</label>
                    <input type="text" name="location" value="' . htmlspecialchars($currentRow['address'] ?? '') . '">
                </div>
                <div class="add">
                    <label>Email</label>
                    <input type="email" name="email" value="' . htmlspecialchars($currentRow['email'] ?? '') . '">
                </div>
                <div class="add">
                    <label>Комментарий</label>
                    <textarea name="comment">' . htmlspecialchars($currentRow['comment'] ?? '') . '</textarea>
                </div>
                <input type="hidden" name="id" value="' . $currentRow['id'] . '">
                <button type="submit" value="Изменить запись" name="button" class="form-btn">Изменить запись</button>
            </div>
        </form>';
    } else {
        $html .= '<div class="info">Записей пока нет. <a href="index.php?p=add">Добавьте первую запись</a></div>';
    }
    
    return $html;
}
?>