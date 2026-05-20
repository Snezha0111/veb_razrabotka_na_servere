<?php
function getMenu($activePage, $mysqli) {
    $menuItems = [
        'viewer' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];
    
    $html = '<div class="menu">';
    foreach ($menuItems as $key => $title) {
        $class = ($activePage == $key) ? 'select' : '';
        $html .= '<a href="index.php?p=' . $key . '" class="' . $class . '">' . $title . '</a>';
    }
    $html .= '</div>';
    
    // Подменю сортировки
    if ($activePage == 'viewer') {
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'byid';
        $html .= '<div class="submenu">';
        
        $sorts = [
            'byid' => 'По-умолчанию',
            'surname' => 'По фамилии',
            'birthdate' => 'По дате рождения'
        ];
        
        foreach ($sorts as $key => $title) {
            $class = ($sort == $key) ? 'select' : '';
            $html .= '<a href="index.php?p=viewer&sort=' . $key . '" class="' . $class . '">' . $title . '</a>';
        }
        $html .= '</div>';
    }
    
    return $html;
}
?>