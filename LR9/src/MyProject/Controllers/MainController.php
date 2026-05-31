<?php
namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Services\Db;
use MyProject\View\View;

class MainController
{
    private $view;
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Db();
    }

    // Главная страница — статьи из БД
    public function main()
    {
        $articles = $this->db->query('SELECT * FROM `articles` ORDER BY id DESC;', [], Article::class);
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