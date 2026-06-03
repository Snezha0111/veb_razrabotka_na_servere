<?php include __DIR__ . '/../header.php'; ?>

<div class="error-page">
    <h1>500 — Ошибка сервера</h1>
    <p><?= htmlspecialchars($error ?? 'Что-то пошло не так') ?></p>
    <a href="/KP_Guseva/" class="btn-back">Вернуться на главную</a>
</div>

<?php include __DIR__ . '/../footer.php'; ?>