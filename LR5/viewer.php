<?php
function getViewerContent($mysqli) {
    // Какая сортировка
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'byid';
    
    // по фамилии по алфавиту
    if ($sort == 'surname') {
        $orderBy = "surname ASC, name ASC";
    } elseif ($sort == 'birthdate') {
        // по др по возрастанию
        $orderBy = "CASE WHEN birthdate IS NULL THEN 1 ELSE 0 END, birthdate ASC";
    } else {
        $orderBy = "id ASC";
    }
    
    // Пагинация
    $page = isset($_GET['pg']) ? (int)$_GET['pg'] : 0;
    $limit = 10;
    $offset = $page * $limit;
    
    // Общее количество записей
    $totalRes = mysqli_query($mysqli, "SELECT COUNT(*) as cnt FROM contacts");
    $totalRow = mysqli_fetch_assoc($totalRes);
    $total = $totalRow['cnt'];
    $totalPages = ceil($total / $limit);
    
    if ($total == 0) {
        return '<div class="info">В записной книжке пока нет контактов</div>';
    }
    
    // Вывод
    $sql = "SELECT * FROM contacts ORDER BY $orderBy LIMIT $offset, $limit";
    $result = mysqli_query($mysqli, $sql);
    
    $html = '<div class="viewer-container">';
    $html .= '<table class="contacts-table">';
    $html .= '<tr>
                <th>ФИО</th>
                <th>Пол</th>
                <th>Дата рождения</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Адрес</th>
                <th>Комментарий</th>
            </tr>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        $fio = trim($row['surname'] . ' ' . $row['name'] . ' ' . $row['lastname']);
        
        // дата
        $birth = '';
        if (!empty($row['birthdate']) && $row['birthdate'] != '0000-00-00') {
            $birth = date('d.m.Y', strtotime($row['birthdate']));
        }
        
        $html .= '<tr>
                    <td>' . htmlspecialchars($fio) . '</td>
                    <td>' . ($row['gender'] ?? '') . '</td>
                    <td>' . $birth . '</td>
                    <td>' . htmlspecialchars($row['phone'] ?? '') . '</td>
                    <td>' . htmlspecialchars($row['email'] ?? '') . '</td>
                    <td>' . htmlspecialchars($row['address'] ?? '') . '</td>
                    <td>' . htmlspecialchars($row['comment'] ?? '') . '</td>
                  </tr>';
    }
    $html .= '</table>';
    
    // пагинация
    if ($totalPages > 1) {
        $html .= '<div class="pagination">';
        for ($i = 0; $i < $totalPages; $i++) {
            $class = ($i == $page) ? 'current' : '';
            $html .= '<a href="index.php?p=viewer&sort=' . $sort . '&pg=' . $i . '" class="' . $class . '">' . ($i + 1) . '</a>';
        }
        $html .= '</div>';
    }
    
    $html .= '</div>';
    return $html;
}
?>