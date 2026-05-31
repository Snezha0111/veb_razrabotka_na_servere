<?php
namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\Db;
use MyProject\View\View;

class ArticlesController
{
    private $view;
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Db();
    }

    public function view(int $articleId)
    {
        $result = $this->db->query(
            'SELECT * FROM `articles` WHERE id = :id;',
            [':id' => $articleId],
            Article::class
        );

        if ($result === []) {
            $this->view->renderHtml('errors/404.php', [], 'Страница не найдена', 404);
            return;
        }

        $article = $result[0];

        // Получаем автора статьи
        $authorResult = $this->db->query(
            'SELECT * FROM `users` WHERE id = :id;',
            [':id' => $article->getAuthorId()],
            User::class
        );

        /** @var User $author */
        $author = $authorResult[0] ?? null;

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
            'author' => $author
        ], $article->getName());
    }

    // === НОВЫЙ МЕТОД: показать форму добавления статьи ===
    public function add()
    {
        // Получаем список пользователей для выбора автора
        $users = $this->db->query('SELECT * FROM `users`;', [], User::class);
        
        $this->view->renderHtml('articles/add.php', [
            'users' => $users
        ], 'Добавить статью');
    }

    // === НОВЫЙ МЕТОД: обработать отправку формы ===
    public function create()
    {
        // Проверяем, что форма отправлена
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view->renderHtml('errors/404.php', [], 'Страница не найдена', 404);
            return;
        }

        // Получаем данные из формы
        $name = trim($_POST['name'] ?? '');
        $text = trim($_POST['text'] ?? '');
        $authorId = (int)($_POST['author_id'] ?? 0);

        // Валидация
        $errors = [];
        if (empty($name)) {
            $errors[] = 'Название статьи обязательно';
        }
        if (empty($text)) {
            $errors[] = 'Текст статьи обязателен';
        }
        if ($authorId <= 0) {
            $errors[] = 'Выберите автора';
        }

        if (!empty($errors)) {
            // Если есть ошибки — показываем форму снова с сообщениями
            $users = $this->db->query('SELECT * FROM `users`;', [], User::class);
            $this->view->renderHtml('articles/add.php', [
                'users' => $users,
                'errors' => $errors,
                'name' => $name,
                'text' => $text,
                'authorId' => $authorId
            ], 'Добавить статью');
            return;
        }

        // Сохраняем статью в базу данных
        $sql = 'INSERT INTO `articles` (name, text, author_id) VALUES (:name, :text, :author_id)';
        $this->db->query($sql, [
            ':name' => $name,
            ':text' => $text,
            ':author_id' => $authorId
        ]);

        // Перенаправляем на главную страницу
        header('Location: /LR9/');
        exit;
    }
}