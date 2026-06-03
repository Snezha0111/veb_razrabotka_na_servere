<?php
namespace MyProject\Controllers;

use MyProject\Models\Books\Book;

class MainController extends AbstractController
{
    public function main()
    {
        // Получаем параметры поиска и сортировки из GET
        $search = trim($_GET['search'] ?? '');
        $sortBy = $_GET['sort'] ?? 'created_at';
        $sortOrder = $_GET['order'] ?? 'DESC';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $perPage = 6;

        // Получаем общее количество книг (с учётом поиска)
        $totalCount = Book::getTotalCountWithFilters($search);
        $totalPages = ceil($totalCount / $perPage);

        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }

        // Получаем книги с применением фильтров
        $books = Book::findWithFilters($search, $sortBy, $sortOrder, $page, $perPage);

        $this->view->renderHtml('main/main.php', [
            'books' => $books,
            'search' => $search,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
}