<?php
namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Books\Book;
use MyProject\Models\Comments\Comment;

class CommentsController extends AbstractController
{
    // Добавление комментария
    public function add(int $bookId)
    {
        if ($this->user === null) {
            header('Location: /KP_Guseva/users/login');
            exit;
        }

        $book = Book::getById($bookId);
        if ($book === null) {
            throw new NotFoundException();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = trim($_POST['text'] ?? '');

            if (empty($text)) {
                header('Location: /KP_Guseva/books/' . $bookId);
                exit;
            }

            $comment = new Comment();
            $comment->setText($text);
            $comment->setBookId($bookId);
            $comment->setUserId($this->user->getId());
            $comment->save();
        }

        header('Location: /KP_Guseva/books/' . $bookId);
        exit;
    }

    // Форма редактирования комментария
    public function edit(int $bookId, int $commentId)
    {
        if ($this->user === null) {
            header('Location: /KP_Guseva/users/login');
            exit;
        }

        $book = Book::getById($bookId);
        if ($book === null) {
            throw new NotFoundException();
        }

        $comment = Comment::getById($commentId);
        if ($comment === null) {
            throw new NotFoundException();
        }

        // Только автор комментария или админ могут редактировать
        if ($comment->getUserId() !== $this->user->getId() && !$this->user->isAdmin()) {
            header('Location: /KP_Guseva/books/' . $bookId);
            exit;
        }

        $this->view->renderHtml('comments/edit.php', [
            'book' => $book,
            'comment' => $comment
        ], 'Редактировать комментарий');
    }

    // Обработка обновления комментария
    public function update(int $bookId, int $commentId)
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

        $comment = Comment::getById($commentId);
        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($comment->getUserId() !== $this->user->getId() && !$this->user->isAdmin()) {
            header('Location: /KP_Guseva/books/' . $bookId);
            exit;
        }

        $text = trim($_POST['text'] ?? '');
        if (empty($text)) {
            header('Location: /KP_Guseva/books/' . $bookId);
            exit;
        }

        $comment->setText($text);
        $comment->save();

        header('Location: /KP_Guseva/books/' . $bookId);
        exit;
    }

    // Удаление комментария
    public function delete(int $bookId, int $commentId)
    {
        if ($this->user === null) {
            header('Location: /KP_Guseva/users/login');
            exit;
        }

        $comment = Comment::getById($commentId);
        if ($comment === null) {
            throw new NotFoundException();
        }

        if ($comment->getUserId() !== $this->user->getId() && !$this->user->isAdmin()) {
            header('Location: /KP_Guseva/books/' . $bookId);
            exit;
        }

        $comment->delete();
        header('Location: /KP_Guseva/books/' . $bookId);
        exit;
    }
}