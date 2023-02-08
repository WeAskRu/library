<?php

declare(strict_types=1);

namespace app\services;

use app\models\Book;

class BookService
{
    public static function save(Book $book): bool
    {
        $newAuthorIds = !$book->authorIds
            ? []
            : array_map('intval', array_filter($book->authorIds));
        $oldAuthorIds = $book->isNewRecord
            ? []
            : array_map('intval', array_keys(BookAuthorService::getBooksAuthorsWithIndex($book->id)));

        $bookSaved = false;
        if ($book->isNewRecord) {
            if (!$book->save()) {
                throw new \Exception('Ошибка при сохранении книги');
            }
            $bookSaved = true;
        }

        $transaction = Book::getDb()->beginTransaction();
        try {
            if (!$bookSaved) {
                if (!$book->save()) {
                    throw new \Exception('Ошибка при сохранении книги');
                }
            }

            BookAuthorService::addRelations(
                $book->id,
                array_diff(
                    $newAuthorIds,
                    $oldAuthorIds,
                )
            );
            BookAuthorService::delRelations(
                [$book->id],
                array_diff(
                    $oldAuthorIds,
                    $newAuthorIds,
                )
            );

            $transaction->commit();
            return true;
        } catch(\Throwable $e) {
            var_dump($e->getMessage());
            $transaction->rollBack();
            return false;
        }
    }

    public static function delete(int $bookId): bool
    {
        $transaction = Book::getDb()->beginTransaction();
        try {
            Book::deleteAll(['id' => $bookId]);
            BookAuthorService::delRelations([$bookId], null);

            $transaction->commit();
            return true;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
    }
}