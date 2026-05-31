<?php
namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\View\View;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    // Главная страница — статьи из БД
    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles]);
    }

    // Обо мне
    public function aboutMe(string $name)
    {
        $this->view->renderHtml('main/about.php', ['name' => $name]);
    }

    // Приветствие
    public function sayHello(string $name)
    {
        $this->view->renderHtml('main/hello.php', ['name' => $name], 'Страница приветствия');
    }

    // Прощание
    public function sayBye(string $name)
    {
        $this->view->renderHtml('main/bye.php', ['name' => $name]);
    }
}