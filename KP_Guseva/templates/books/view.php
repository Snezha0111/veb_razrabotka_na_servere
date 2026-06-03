<?php include __DIR__ . '/../header.php'; ?>

<div class="book-detail">
    <div class="book-detail-header">
        <h1><?= htmlspecialchars($book->getTitle()) ?></h1>
        <div class="book-detail-rating">⭐ <?= $book->getRating() ?? 'Нет оценки' ?></div>
    </div>
    
    <p class="book-detail-author">Автор: <?= htmlspecialchars($book->getAuthor()) ?></p>
    <p class="book-detail-user">Добавил: <?= htmlspecialchars($book->getUser()->getNickname()) ?></p>
    
    <div class="book-detail-description">
        <h3>Описание:</h3>
        <p><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
    </div>
    
    <?php if (!empty($user) && ($book->getUserId() == $user->getId() || $user->isAdmin())): ?>
        <div class="book-detail-actions">
            <a href="/KP_Guseva/books/<?= $book->getId() ?>/edit" class="btn-edit">Редактировать</a>
            <a href="/KP_Guseva/books/<?= $book->getId() ?>/delete" class="btn-delete" onclick="return confirm('Удалить книгу?')">Удалить</a>
        </div>
    <?php endif; ?>
    
    <div class="comments-section">
        <h3>Комментарии (<?= $book->getCommentsCount() ?>)</h3>
        
        <?php if (!empty($user)): ?>
            <form method="POST" action="/KP_Guseva/books/<?= $book->getId() ?>/comments/add" class="comment-form">
                <textarea name="text" placeholder="Напишите комментарий..." rows="3" required></textarea>
                <button type="submit" class="btn-submit">Отправить</button>
            </form>
        <?php else: ?>
            <p class="login-prompt"><a href="/KP_Guseva/users/login">Войдите</a>, чтобы оставить комментарий</p>
        <?php endif; ?>
        
        <div class="comments-list">
            <?php foreach ($book->getComments() as $comment): ?>
                <div class="comment">
                    <div class="comment-header">
                        <strong><?= htmlspecialchars($comment->getUser()->getNickname()) ?></strong>
                        <span class="comment-date"><?= $comment->getCreatedAt() ?></span>
                        <?php if (!empty($user) && ($comment->getUserId() == $user->getId() || $user->isAdmin())): ?>
                            <div class="comment-actions">
                                <a href="/KP_Guseva/books/<?= $book->getId() ?>/comments/<?= $comment->getId() ?>/edit">✏</a>
                                <a href="/KP_Guseva/books/<?= $book->getId() ?>/comments/<?= $comment->getId() ?>/delete" onclick="return confirm('Удалить комментарий?')">🗑</a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="comment-text"><?= nl2br(htmlspecialchars($comment->getText())) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>