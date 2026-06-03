<?php include __DIR__ . '/../header.php'; ?>

<div class="books-header">
    <h2>Все книги</h2>
    <?php if (!empty($user)): ?>
        <a href="/KP_Guseva/books/add" class="btn-add">Добавить книгу</a>
    <?php endif; ?>
</div>

<!-- Поиск и сортировка -->
<div class="filters-section">
    <form method="GET" action="/KP_Guseva/" class="search-form">
        <div class="search-group">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                   placeholder="Поиск по названию, автору или описанию" class="search-input">
            <button type="submit" class="search-btn">Искать</button>
        </div>
        
        <div class="sort-group">
            <label>Сортировать по:</label>
            <select name="sort" class="sort-select" onchange="this.form.submit()">
                <option value="created_at" <?= $sortBy == 'created_at' ? 'selected' : '' ?>>Дате добавления</option>
                <option value="title" <?= $sortBy == 'title' ? 'selected' : '' ?>>Названию</option>
                <option value="author" <?= $sortBy == 'author' ? 'selected' : '' ?>>Автору</option>
                <option value="year" <?= $sortBy == 'year' ? 'selected' : '' ?>>Году издания</option>
            </select>
            
            <select name="order" class="order-select" onchange="this.form.submit()">
                <option value="DESC" <?= $sortOrder == 'DESC' ? 'selected' : '' ?>>По убыванию ↓</option>
                <option value="ASC" <?= $sortOrder == 'ASC' ? 'selected' : '' ?>>По возрастанию ↑</option>
            </select>
            
            <?php if (!empty($search)): ?>
                <a href="/KP_Guseva/" class="clear-btn">✖ Сбросить фильтры</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php if (!empty($search)): ?>
    <div class="search-info">
        Результаты поиска по запросу: <strong><?= htmlspecialchars($search) ?></strong>
    </div>
<?php endif; ?>

<?php if (empty($books)): ?>
    <div class="empty-message">
        <?php if (!empty($search)): ?>
            <p class="text-NaB">По вашему запросу ничего не найдено</p>
            <a href="/KP_Guseva/" class="btn-back">Вернуться к списку книг</a>
        <?php else: ?>
            <p>📚 На книжной полке пока что пусто. Начни заполнять ее!</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="books-grid">
        <?php foreach ($books as $book): ?>
            <div class="book-card">
                <div class="book-rating">⭐ <?= $book->getRating() ?? 'Нет оценки' ?></div>
                <h3><a href="/KP_Guseva/books/<?= $book->getId() ?>"><?= htmlspecialchars($book->getTitle()) ?></a></h3>
                <p class="book-author"><strong>Автор:</strong> <?= htmlspecialchars($book->getAuthor()) ?>
                    <?php if ($book->getYear()): ?>
                        <span class="book-year">(<?= $book->getYear() ?>)</span>
                    <?php endif; ?>
                </p>
                <p class="book-description"><?= htmlspecialchars(mb_substr($book->getDescription(), 0, 100)) ?>...</p>
                <p class="book-meta">
                    Добавил: <?= htmlspecialchars($book->getUser()->getNickname()) ?> |
                    Комментариев: <?= $book->getCommentsCount() ?>
                </p>
                <?php if (!empty($user) && ($book->getUserId() == $user->getId() || $user->isAdmin())): ?>
                    <div class="book-actions">
                        <a href="/KP_Guseva/books/<?= $book->getId() ?>/edit" class="btn-edit">Редактировать</a>
                        <a href="/KP_Guseva/books/<?= $book->getId() ?>/delete" class="btn-delete" onclick="return confirm('Удалить книгу?')">Удалить</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" class="page-link">← Назад</a>
            <?php endif; ?>
            
            <span class="page-current">Страница <?= $page ?> из <?= $totalPages ?></span>
            
            <?php if ($page < $totalPages): ?>
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>" class="page-link">Вперёд →</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>