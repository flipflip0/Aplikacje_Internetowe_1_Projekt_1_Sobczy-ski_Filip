<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Projekt - Książki</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 20px; display: flex; flex-direction: column; align-items: center; }
        nav { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 100%; max-width: 800px; margin-bottom: 20px; text-align: center; }
        nav a { margin: 0 15px; text-decoration: none; color: #2c3e50; font-weight: bold; }
        main { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 800px; min-height: 400px; }
        h1 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .book-item { padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .book-item:last-child { border-bottom: none; }
        .btn { padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 14px; transition: 0.3s; }
        .btn-primary { background: #3498db; color: #fff; }
        .btn-info { background: #ecf0f1; color: #2c3e50; }
        .btn:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <nav>
        <a href="/index.php?action=post-index">Posty</a>
        <a href="/index.php?action=book-index">Książki</a>
    </nav>
    <main>
        <?= $main ?? 'Brak treści do wyświetlenia' ?>
    </main>
</body>
</html>