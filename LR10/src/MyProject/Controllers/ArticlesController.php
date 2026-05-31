<?php
namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\View\View;

class ArticlesController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    // Просмотр одной статьи
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 'Страница не найдена', 404);
            return;
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article
        ]);
    }

    // Форма добавления статьи
    public function add()
    {
        $users = User::findAll();
        $this->view->renderHtml('articles/add.php', ['users' => $users], 'Добавить статью');
    }

    // Обработка создания статьи
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->renderHtml('errors/404.php', [], 'Страница не найдена', 404);
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $text = trim($_POST['text'] ?? '');
        $authorId = (int)($_POST['author_id'] ?? 0);

        $errors = [];
        if (empty($name)) $errors[] = 'Название статьи обязательно';
        if (empty($text)) $errors[] = 'Текст статьи обязателен';
        if ($authorId <= 0) $errors[] = 'Выберите автора';

        if (!empty($errors)) {
            $users = User::findAll();
            $this->view->renderHtml('articles/add.php', [
                'users' => $users,
                'errors' => $errors,
                'name' => $name,
                'text' => $text,
                'authorId' => $authorId
            ], 'Добавить статью');
            return;
        }

        $author = User::getById($authorId);
        $article = new Article();
        $article->setName($name);
        $article->setText($text);
        $article->setAuthor($author);
        $article->save();

        header('Location: /LR10/');
        exit;
    }

    // Форма редактирования статьи
    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 'Страница не найдена', 404);
            return;
        }

        $users = User::findAll();
        $this->view->renderHtml('articles/edit.php', [
            'article' => $article,
            'users' => $users
        ], 'Редактировать статью');
    }

    // Обработка обновления статьи
    public function update(int $articleId)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->renderHtml('errors/404.php', [], 'Страница не найдена', 404);
            return;
        }

        $article = Article::getById($articleId);
        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 'Страница не найдена', 404);
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $text = trim($_POST['text'] ?? '');
        $authorId = (int)($_POST['author_id'] ?? 0);

        $errors = [];
        if (empty($name)) $errors[] = 'Название статьи обязательно';
        if (empty($text)) $errors[] = 'Текст статьи обязателен';
        if ($authorId <= 0) $errors[] = 'Выберите автора';

        if (!empty($errors)) {
            $users = User::findAll();
            $this->view->renderHtml('articles/edit.php', [
                'article' => $article,
                'users' => $users,
                'errors' => $errors
            ], 'Редактировать статью');
            return;
        }

        $author = User::getById($authorId);
        $article->setName($name);
        $article->setText($text);
        $article->setAuthor($author);
        $article->save();

        header('Location: /LR10/articles/' . $articleId);
        exit;
    }
}