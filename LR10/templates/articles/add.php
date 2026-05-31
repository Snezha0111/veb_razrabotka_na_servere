<?php include __DIR__ . '/../header.php'; ?>

<h1>Добавить новую статью</h1>

<?php if (!empty($errors)): ?>
    <div class="error-messages">
        <?php foreach ($errors as $error): ?>
            <p style="color: red;">❌ <?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="/LR10/articles/create" class="add-article-form">
    <div class="form-group">
        <label for="name">Название статьи:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="text">Текст статьи:</label>
        <textarea id="text" name="text" rows="10" required><?= htmlspecialchars($text ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label for="author_id">Автор:</label>
        <select id="author_id" name="author_id" required>
            <option value="">-- Выберите автора --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->getId() ?>" <?= (($authorId ?? 0) == $user->getId()) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user->getNickname()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn-submit">Сохранить статью</button>
    <a href="/LR10/" class="btn-cancel">Отмена</a>
</form>

<?php include __DIR__ . '/../footer.php'; ?>