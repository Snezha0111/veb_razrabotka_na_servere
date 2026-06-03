<?php
namespace MyProject\Models\Books;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Users\User;
use MyProject\Services\Db;  

class Book extends ActiveRecordEntity
{
    protected $userId;
    protected $title;
    protected $author;
    protected $description;
    protected $rating;
    protected $year;
    protected $createdAt;
    protected $updatedAt;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): void
    {
        $this->year = $year;
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

    public function getComments(): array
    {
        return Comment::findByBookId($this->id);
    }

    public function getCommentsCount(): int
    {
        return Comment::getCountByBookId($this->id);
    }


     /* Поиск книг с сортировкой и пагинацией*/
    public static function findWithFilters(
        string $search = '',
        string $sortBy = 'created_at',
        string $sortOrder = 'DESC',
        int $page = 1,
        int $perPage = 6
    ): array {
        $db = Db::getInstance();
        $offset = ($page - 1) * $perPage;

        // Карта соответствия полей для сортировки
        $sortMap = [
            'title' => 'title',
            'author' => 'author',
            'year' => 'year',
            'created_at' => 'created_at'
        ];

        $orderBy = $sortMap[$sortBy] ?? 'created_at';
        $orderDir = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';

        // Построение WHERE для поиска
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = " WHERE title LIKE :search OR author LIKE :search OR description LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }

        $sql = "SELECT * FROM `" . static::getTableName() . "`"
            . $whereClause
            . " ORDER BY {$orderBy} {$orderDir}"
            . " LIMIT {$offset}, {$perPage}";

        return $db->query($sql, $params, static::class);
    }

    /*Общее количество книг*/
    public static function getTotalCountWithFilters(string $search = ''): int
    {
        $db = Db::getInstance();

        if (empty($search)) {
            return self::getTotalCount();
        }

        $sql = "SELECT COUNT(*) as count FROM `" . static::getTableName() . "`
                WHERE title LIKE :search OR author LIKE :search OR description LIKE :search";
        $result = $db->query($sql, [':search' => '%' . $search . '%']);

        return $result ? (int)$result[0]->count : 0;
    }

    protected static function getTableName(): string
    {
        return 'books';
    }
    
}