<?php
// Автозагрузка классов
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/src/' . $className . '.php';
});

// Маршрут из GET
$route = $_GET['route'] ?? '';

// Конфигурацию роутов
$routes = require __DIR__ . '/src/routes.php';

$isRouteFound = false;

foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}

if (!$isRouteFound) {
    echo 'Страница не найдена!';
    return;
}

// Удаляем полное совпадение
unset($matches[0]);

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

// Контроллер и вызов метод с аргументами
$controller = new $controllerName();
$controller->$actionName(...$matches);