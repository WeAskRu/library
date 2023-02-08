<?php

declare(strict_types=1);

namespace app\services;

use app\models\Author;

class AuthorService
{
    public static function delete(int $authorId): bool
    {
        $transaction = Author::getDb()->beginTransaction();
        try {
            Author::deleteAll(['id' => $authorId]);
            BookAuthorService::delRelations(null, [$authorId]);

            $transaction->commit();
            return true;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
    }
}