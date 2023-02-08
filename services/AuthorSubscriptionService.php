<?php

declare(strict_types=1);

namespace app\services;

use app\models\AuthorSubscription;
use app\models\Book;

class AuthorSubscriptionService
{
    public static function create(AuthorSubscription $authorSubscription): void
    {
        if ($authorSubscription->author === null) {
            throw new \InvalidArgumentException('Автор не найден');
        }
        $authorSubscription->phone = preg_replace('/[^0-9]/', '', $authorSubscription->phone);
        if (!$authorSubscription->save()) {
            throw new \Exception('Ошибка при добавлении подписки на автора');
        }
    }

    public static function notifySubscribers(int $authorId, Book $book): void
    {
        $phones = AuthorSubscription::find()->select('phone')->where(['author_id' => $authorId])->all();
    }
}