<?php

declare(strict_types=1);

namespace app\services;

use app\models\Author;
use app\models\AuthorSubscription;
use app\models\Book;
use app\models\BookAuthor;
use app\services\senders\SenderService;
use app\services\senders\SmsSenderService;

class BookAuthorService
{
    /**
     * @return Author[]
     */
    public static function getBooksAuthorsWithIndex(int ...$bookIds): array
    {
        $authors = [];
        $bookAuthors = BookAuthor::find()->with('author')->where(['book_id' => $bookIds])->all();
        foreach ($bookAuthors as $bookAuthor) {
            $authors[$bookAuthor->author_id] = $bookAuthor->author;
        }
        return $authors;
    }

    public static function addRelations(int $bookId, array $authorIds): void
    {
        foreach ($authorIds as $authorId) {
            $bookAuthor = new BookAuthor();
            $bookAuthor->author_id = $authorId;
            $bookAuthor->book_id = $bookId;
            if (!$bookAuthor->save()) {
                throw new \Exception('Ошибка при добавлении связи автора и книги');
            }
            self::notifySubscribers($authorId, $bookId);
        }
    }

    public static function delRelations(?array $bookIds, ?array $authorIds): void
    {
        if (!$bookIds && !$authorIds) {
            return;
        }
        $condition = [];
        if ($bookIds !== null) {
            $condition['book_id'] = $bookIds;
        }
        if ($authorIds !== null) {
            $condition['author_id'] = $authorIds;
        }
        BookAuthor::deleteAll($condition);
    }

    public static function notifySubscribers(int $authorId, int $bookId): void
    {
        $author = Author::findOne($authorId);
        $book = Book::findOne($bookId);
        $authorSubscriptions = AuthorSubscription::findAll(['author_id' => $authorId]);
        $message = "Релиз новой книги {$book->title} от автора {$author->getFullName()}";

        foreach ($authorSubscriptions as $authorSubscription) {
            // @todo Поставить в очередь сообщений (например, RabbitMQ)
            self::sendMessage(
                new SmsSenderService(),
                $authorSubscription->phone,
                $message
            );
        }
    }

    public static function sendMessage(SenderService $sender, string $to, string $message): void
    {
        $sender->setTo($to)->setMessage($message)->send();
    }
}