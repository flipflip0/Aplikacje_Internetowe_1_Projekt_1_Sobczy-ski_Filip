<?php ob_start(); ?>
<h1><?= $book->getTitle() ?></h1>
<p><strong>Autor:</strong> <?= $book->getAuthor() ?></p>
<p><?= $book->getDescription() ?></p>
<a href="/index.php?action=book-index">Powrót</a> | 
<a href="/index.php?action=book-edit&id=<?= $book->getId() ?>">Edytuj</a>
<?php $main = ob_get_clean(); include __DIR__ . '/../base.html.php'; ?>