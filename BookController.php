<?php

namespace App\Controller;

use App\Model\Book;
use App\Service\Templating;

class BookController
{
    public function indexAction(Templating $templating): string
    {
        $books = Book::findAll();
        return $templating->render('book/index.php', [
            'books' => $books,
        ]);
    }

    public function createAction(Templating $templating): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book = Book::fromArray($_POST['book']);
            $book->save();
            header('Location: /index.php?action=book-index');
            exit;
        }

        return $templating->render('book/create.php');
    }

    public function editAction(int $id, Templating $templating): string
    {
        $book = Book::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book->fromArray($_POST['book']);
            $book->save();
            header('Location: /index.php?action=book-index');
            exit;
        }

        return $templating->render('book/edit.php', [
            'book' => $book,
        ]);
    }

    public function showAction(int $id, Templating $templating): string
    {
        $book = Book::find($id);
        return $templating->render('book/show.php', [
            'book' => $book,
        ]);
    }

    public function deleteAction(int $id): void
    {
        $book = Book::find($id);
        if ($book) {
            $book->delete();
        }
        header('Location: /index.php?action=book-index');
        exit;
    }
}