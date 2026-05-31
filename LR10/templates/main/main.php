<?php include __DIR__ . '/../header.php'; ?>

<h2>Статьи:</h2>

<?php foreach ($articles as $article): ?>
    <div class="article-preview">
        <h3>
            <a href="/LR10/articles/<?= $article->getId() ?>"><?= htmlspecialchars($article->getName()) ?></a>
        </h3>
        <p><?= htmlspecialchars(mb_substr($article->getText(), 0, 200)) ?>...</p>
        <p><small>Автор: <?= htmlspecialchars($article->getAuthor()->getNickname()) ?></small></p>
        <p>
            <a href="/LR10/articles/<?= $article->getId() ?>/edit" style="color: lightseagreen;">Редактировать</a>
        </p>
        <hr>
    </div>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>