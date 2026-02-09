<?php ob_start(); ?>
    <h1>Dodaj nową książkę</h1>
    <form action="/index.php?action=book-create" method="post">
        <label>Tytuł:</label><input type="text" name="book[title]" required><br>
        <label>Autor:</label><input type="text" name="book[author]" required><br>
        <label>Opis:</label><textarea name="book[description]"></textarea><br>
        <button type="submit">Zapisz</button>
    </form>
    <a href="/index.php?action=book-index">Powrót</a>
<?php $main = ob_get_clean(); include __DIR__ . '/../base.html.php'; ?>
