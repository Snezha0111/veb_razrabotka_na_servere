<?php include __DIR__ . '/../header.php'; ?>

<h2>Статьи из базы данных:</h2>

<?php foreach ($articles as $article): ?>
    <h3>
        <a href="/LR9/articles/<?= $article->getId() ?>"><?= htmlspecialchars($article->getName()) ?></a>
    </h3>
    <p><?= htmlspecialchars($article->getText()) ?></p>
    <hr>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>