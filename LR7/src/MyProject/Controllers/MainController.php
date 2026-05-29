<?php
namespace MyProject\Controllers;

use MyProject\View\View;

class MainController
{
    private $view;

    public function __construct()
    {
        // Путь к папке с шаблонами (относительно этого файла)
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    // Главная страница
    public function main()
    {
        $articles = [
            ['name' => 'Статья 1', 'text' => 'Текст статьи 1'],
            ['name' => 'Статья 2', 'text' => 'Текст статьи 2'],
        ];
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }

    // Обо мне
    public function aboutMe(string $name)
    {
        $this->view->renderHtml('main/about.php', ['name' => $name]);
    }

    // прощание
    public function sayBye(string $name)
    {
        $this->view->renderHtml('main/bye.php', ['name' => $name]);
    }
}