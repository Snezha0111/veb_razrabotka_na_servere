<?php
namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Books\Book;

class BooksController extends AbstractController
{
    // Просмотр одной книги
    public function view(int $bookId)
    {
        $book = Book::getById($bookId);
        if ($book === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('books/view.php', ['book' => $book], $book->getTitle());
    }

    // Форма добавления книги
    public function add()
    {
        if ($this->user === null) {
            header('Location: /KP_Guseva/users/login');
            exit;
        }

        $this->view->renderHtml('books/add.php', [], 'Добавить книгу');
    }

    // Обработка создания книги
    public function create()
    {
        if ($this->user === null) {
            header('Location: /KP_Guseva/users/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new NotFoundException();
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $rating = !empty($_POST['rating']) ? (int)$_POST['rating'] : null;
        $year = !empty($_POST['year']) ? (int)$_POST['year'] : null;  // ← НОВОЕ

        $errors = [];
        if (empty($title)) $errors[] = 'Название книги обязательно';
        if (empty($author)) $errors[] = 'Автор обязателен';
        if (empty($description)) $errors[] = 'Описание обязательно';

        if (!empty($errors)) {
            $this->view->renderHtml('books/add.php', [
                'errors' => $errors,
                'title' => $title,
                'author' => $author,
                'year' => $year,
                'description' => $description,
                'rating' => $rating
            ], 'Добавить книгу');
            return;
        }

        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setDescription($description);
        $book->setRating($rating);
        $book->setYear($year);  // ← НОВОЕ
        $book->setUserId($this->user->getId());
        $book->save();

        header('Location: /KP_Guseva/books/' . $book->getId());
        exit;
    }

    // Форма редактирования книги
    public function edit(int $bookId)
    {
        if ($this->user === null) {
            header('Location: /KP_Guseva/users/login');
            exit;
        }

        $book = Book::getById($bookId);
        if ($book === null) {
            throw new NotFoundException();
        }

        // Проверка прав: только автор или админ могут редактировать
        if ($book->getUserId() !== $this->user->getId() && !$this->user->isAdmin()) {
            header('Location: /KP_Guseva/books/' . $bookId);
            exit;
        }

        $this->view->renderHtml('books/edit.php', ['book' => $book], 'Редактировать книгу');
    }

    // Обработка обновления книги
    public function update(int $bookId)
    {
        if ($this->user === null) {
            header('Location: /KP_Guseva/users/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new NotFoundException();
        }

        $book = Book::getById($bookId);
        if ($book === null) {
            throw new NotFoundException();
        }

        if ($book->getUserId() !== $this->user->getId() && !$this->user->isAdmin()) {
            header('Location: /KP_Gusevay/books/' . $bookId);
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $rating = !empty($_POST['rating']) ? (int)$_POST['rating'] : null;
        $year = !empty($_POST['year']) ? (int)$_POST['year'] : null;  // ← НОВОЕ

        $errors = [];
        if (empty($title)) $errors[] = 'Название книги обязательно';
        if (empty($author)) $errors[] = 'Автор обязателен';
        if (empty($description)) $errors[] = 'Описание обязательно';

        if (!empty($errors)) {
            $this->view->renderHtml('books/edit.php', [
                'book' => $book,
                'errors' => $errors
            ], 'Редактировать книгу');
            return;
        }

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setDescription($description);
        $book->setRating($rating);
        $book->setYear($year);  // ← НОВОЕ
        $book->save();

        header('Location: /KP_Guseva/books/' . $bookId);
        exit;
    }

    // Удаление книги
    public function delete(int $bookId)
    {
        if ($this->user === null) {
            header('Location: /KP_Guseva/users/login');
            exit;
        }

        $book = Book::getById($bookId);
        if ($book === null) {
            throw new NotFoundException();
        }

        if ($book->getUserId() !== $this->user->getId() && !$this->user->isAdmin()) {
            header('Location: /KP_Guseva/books/' . $bookId);
            exit;
        }

        $book->delete();
        header('Location: /KP_Guseva/');
        exit;
    }
}