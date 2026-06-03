<?php include __DIR__ . '/../header.php'; ?>

<div class="auth-container">
    <h2>Регистрация</h2>
    
    <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST" action="/KP_Guseva/users/register" class="auth-form">
        <div class="form-group">
            <label for="nickname">Nickname *</label>
            <input type="text" id="nickname" name="nickname" value="<?= $_POST['nickname'] ?? '' ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required autocomplite="email">
        </div>
        
        <div class="form-group">
            <label for="password">Пароль * (минимум 6 символов)</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn-submit">Зарегистрироваться</button>
    </form>
    
    <p class="auth-link">Уже есть аккаунт? <a href="/KP_Guseva/users/login">Войдите</a></p>
</div>

<?php include __DIR__ . '/../footer.php'; ?>