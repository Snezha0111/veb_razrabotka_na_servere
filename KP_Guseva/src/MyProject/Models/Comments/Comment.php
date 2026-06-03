<?php
namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Books\Book;
use MyProject\Models\Users\User;

class Comment extends ActiveRecordEntity
{
    protected $bookId;
    protected $userId;
    protected $text;
    protected $createdAt;
    protected $updatedAt;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function setBookId(int $bookId): void
    {
        $this->bookId = $bookId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUser(): User
    {
        return User::getById($this->userId);
    }

    public function getBook(): Book
    {
        return Book::getById($this->bookId);
    }

    public static function findByBookId(int $bookId): array
    {
        $db = \MyProject\Services\Db::getInstance();
        return $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE book_id = :bookId ORDER BY id DESC;',
            [':bookId' => $bookId],
            static::class
        );
    }

    public static function getCountByBookId(int $bookId): int
    {
        $db = \MyProject\Services\Db::getInstance();
        $result = $db->query(
            'SELECT COUNT(*) as count FROM `' . static::getTableName() . '` WHERE book_id = :bookId;',
            [':bookId' => $bookId]
        );
        return $result ? (int)$result[0]->count : 0;
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}