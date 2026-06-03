<?php include __DIR__ . '/../header.php'; ?>

<div class="error-page">
    <h1>404 — Страница не найдена</h1>
    <p><?= htmlspecialchars($error ?? 'Запрашиваемая страница не существует') ?></p>
    <a href="/KP_Guseva/" class="btn-back">Вернуться на главную</a>
</div>

<?php include __DIR__ . '/../footer.php'; ?>