<?php
function getDeleteContent($mysqli) {
    $message = '';
    
    // Обработка удаления
    if (isset($_GET['delete_id'])) {
        $id = (int)$_GET['delete_id'];
        $res = mysqli_query($mysqli, "SELECT surname, name FROM contacts WHERE id=$id");
        $row = mysqli_fetch_assoc($res);
        $fio = $row['surname'] . ' ' . $row['name'];
        
        if (mysqli_query($mysqli, "DELETE FROM contacts WHERE id=$id")) {
            $message = '<div class="success">Запись с фамилией "' . htmlspecialchars($fio) . '" удалена</div>';
        } else {
            $message = '<div class="error">Ошибка при удалении</div>';
        }
    }
    
    // Список записей
    $result = mysqli_query($mysqli, "SELECT id, surname, name, lastname FROM contacts ORDER BY surname, name");
    
    $html = $message;
    $html .= '<div class="delete-links">';
    
    while ($row = mysqli_fetch_assoc($result)) {
        $initials = mb_substr($row['name'], 0, 1) . '.';
        if ($row['lastname']) $initials .= ' ' . mb_substr($row['lastname'], 0, 1) . '.';
        $fio = $row['surname'] . ' ' . $initials;
        
        $html .= '<div class="delete-item">
                    <span>' . htmlspecialchars($fio) . '</span>
                    <a href="index.php?p=delete&delete_id=' . $row['id'] . '" class="delete-btn" onclick="return confirm(\'Удалить запись?\')">Удалить</a>
                  </div>';
    }
    
    $html .= '</div>';
    return $html;
}
?>