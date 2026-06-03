<?php include __DIR__ . '/../header.php'; ?>

<div class="form-container">
    <h2>Редактировать комментарий</h2>
    
    <form method="POST" action="/KP_Guseva/books/<?= $book->getId() ?>/comments/<?= $comment->getId() ?>/update" class="comment-edit-form">
        <div class="form-group">
            <label for="text">Комментарий к книге "<?= htmlspecialchars($book->getTitle()) ?>"</label>
            <textarea id="text" name="text" rows="5" required><?= htmlspecialchars($comment->getText()) ?></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-submit">Сохранить</button>
            <a href="/KP_Guseva/books/<?= $book->getId() ?>" class="btn-cancel">Отмена</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>