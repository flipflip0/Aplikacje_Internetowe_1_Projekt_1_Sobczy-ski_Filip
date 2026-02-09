<?php

namespace App\Model;

use App\Service\Config;
use PDO;

class Book
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $author = null;
    private ?string $description = null;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(?string $title): self { $this->title = $title; return $this; }

    public function getAuthor(): ?string { return $this->author; }
    public function setAuthor(?string $author): self { $this->author = $author; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }

    public static function findAll(): array
    {
        $config = new Config();
        $pdo = new PDO($config->get('db_dsn'), $config->get('db_user'), $config->get('db_pass'));
        $sql = 'SELECT * FROM book';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $books = [];
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $books[] = self::fromArray($result);
        }

        return $books;
    }

    public static function fromArray(array $array): self
    {
        $book = new self();
        $book->setId($array['id'] ?? null);
        $book->setTitle($array['title'] ?? null);
        $book->setAuthor($array['author'] ?? null);
        $book->setDescription($array['description'] ?? null);

        return $book;
    }

    public function save(): void
    {
        $config = new Config();
        $pdo = new PDO($config->get('db_dsn'), $config->get('db_user'), $config->get('db_pass'));

        if ($this->getId()) {
            $sql = 'UPDATE book SET title = :title, author = :author, description = :description WHERE id = :id';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':title' => $this->getTitle(),
                ':author' => $this->getAuthor(),
                ':description' => $this->getDescription(),
                ':id' => $this->getId(),
            ]);
        } else {
            $sql = 'INSERT INTO book (title, author, description) VALUES (:title, :author, :description)';
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':title' => $this->getTitle(),
                ':author' => $this->getAuthor(),
                ':description' => $this->getDescription(),
            ]);
            $this->setId((int)$pdo->lastInsertId());
        }
    }
    public static function find(int $id): ?self
    {
        $config = new \App\Service\Config();
        $pdo = new \PDO($config->get('db_dsn'), $config->get('db_user'), $config->get('db_pass'));
        $sql = 'SELECT * FROM book WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ? self::fromArray($result) : null;
    }

    public function delete(): void
    {
        $config = new \App\Service\Config();
        $pdo = new \PDO($config->get('db_dsn'), $config->get('db_user'), $config->get('db_pass'));
        $sql = 'DELETE FROM book WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $this->getId()]);
    }
}