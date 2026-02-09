<?php ob_start(); ?>

<h1>Lista Książek</h1>
<div style="margin-bottom: 20px;">
    <a href="/index.php?action=book-create" class="btn btn-primary"> + Dodaj nową książkę</a>
</div>

<div class="book-list">
    <?php if (empty($books)): ?>
        <p>Baza jest pusta. Dodaj coś!</p>
    <?php else: ?>
        <?php foreach ($books as $book): ?>
            <div class="book-item">
                <div>
                    <strong><?= htmlspecialchars($book->getTitle()) ?></strong><br>
                    <small style="color: #7f8c8d;"><?= htmlspecialchars($book->getAuthor()) ?></small>
                </div>
                <div>
                    <a href="/index.php?action=book-show&id=<?= $book->getId() ?>" class="btn btn-info">Szczegóły</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php 
$main = ob_get_clean(); 
include __DIR__ . '/../base.html.php'; 
?>