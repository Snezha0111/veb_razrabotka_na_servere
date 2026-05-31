<?php include __DIR__ . '/../header.php'; ?>

<h1><?= htmlspecialchars($article->getName()) ?></h1>

<p><strong>Автор:</strong> <?= htmlspecialchars($author->getNickname()) ?></p>

<p><?= nl2br(htmlspecialchars($article->getText())) ?></p>

<p><small>Дата публикации: <?= $article->getCreatedAt() ?></small></p>

<p><a href="/LR9/">На главную</a></p>

<?php include __DIR__ . '/../footer.php'; ?>