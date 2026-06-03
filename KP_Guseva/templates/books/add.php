<?php include __DIR__ . '/../header.php'; ?>

<div class="form-container">
    <h2>Добавить книгу</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="/KP_Guseva/books/create" class="book-form">
        <div class="form-group">
            <label for="title">Название книги *</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($title ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label for="author">Автор *</label>
            <input type="text" id="author" name="author" value="<?= htmlspecialchars($author ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label for="year">Год издания</label>
            <input type="number" id="year" name="year" min="1000" max="<?= date('Y') ?>" 
                   value="<?= htmlspecialchars($year ?? '') ?>" placeholder="например: 2020">
        </div>
        
        <div class="form-group">
            <label for="description">Описание *</label>
            <textarea id="description" name="description" rows="6" required><?= htmlspecialchars($description ?? '') ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="rating">Оценка (1-5, необязательно)</label>
            <select id="rating" name="rating">
                <option value="">-- Выберите оценку --</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>" <?= (($rating ?? 0) == $i) ? 'selected' : '' ?>><?= $i ?> ⭐</option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-submit">Добавить книгу</button>
            <a href="/KP_Guseva/" class="btn-cancel">Отмена</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>