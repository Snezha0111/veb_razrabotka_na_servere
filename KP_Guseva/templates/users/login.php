<?php include __DIR__ . '/../header.php'; ?>

<div class="auth-container">
    <h2>Вход</h2>
    
    <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST" action="/KP_Guseva/users/login" class="auth-form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required autocomplite="email">
        </div>
        
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn-submit">Войти</button>
    </form>
    
    <p class="auth-link">Нет аккаунта? <a href="/KP_Guseva/users/register">Зарегистрируйтесь</a></p>
</div>

<?php include __DIR__ . '/../footer.php'; ?>