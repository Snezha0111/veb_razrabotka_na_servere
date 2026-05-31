<?php include __DIR__ . '/../header.php'; ?>

<h1><?= htmlspecialchars($article->getName()) ?></h1>

<p><strong>Автор:</strong> <?= htmlspecialchars($article->getAuthor()->getNickname()) ?></p>

<p><?= nl2br(htmlspecialchars($article->getText())) ?></p>

<p><small>Дата публикации: <?= $article->getCreatedAt() ?></small></p>

<p>
    <a href="/LR10/">← На главную</a> 
    <a href="/LR10/articles/<?= $article->getId() ?>/edit" style="color: lightseagreen;">Редактировать</a>
</p>

<?php include __DIR__ . '/../footer.php'; ?>