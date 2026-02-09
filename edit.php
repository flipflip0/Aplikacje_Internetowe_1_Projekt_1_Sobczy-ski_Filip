<?php ob_start(); ?>

<h1>Edytuj książkę</h1>

<form action="/index.php?action=book-edit&id=<?= $book->getId() ?>" method="post" style="display: flex; flex-direction: column; gap: 15px;">
    <div style="display: flex; flex-direction: column; gap: 5px;">
        <label for="title">Tytuł:</label>
        <input type="text" id="title" name="book[title]" value="<?= htmlspecialchars($book->getTitle()) ?>" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <div style="display: flex; flex-direction: column; gap: 5px;">
        <label for="author">Autor:</label>
        <input type="text" id="author" name="book[author]" value="<?= htmlspecialchars($book->getAuthor()) ?>" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <div style="display: flex; flex-direction: column; gap: 5px;">
        <label for="description">Opis:</label>
        <textarea id="description" name="book[description]" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; min-height: 100px;"><?= htmlspecialchars($book->getDescription()) ?></textarea>
    </div>

    <div style="margin-top: 10px; display: flex; gap: 10px;">
        <button type="submit" class="btn btn-primary" style="border: none; cursor: pointer;">Zapisz zmiany</button>
        <a href="/index.php?action=book-index" class="btn btn-info">Anuluj</a>
    </div>
</form>

<?php 
$main = ob_get_clean(); 
include __DIR__ . '/../base.html.php'; 
?>