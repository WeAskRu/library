<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Создание таблиц: пользователи, книги, авторы, подписки на авторов
 * Примечание: Внешние ключи не добавляются так как замедляют вставку, изменение, удаление связанных ключей
 */
class m230207_061022_create_tables extends Migration
{
    private const DATABASE_NAME = 'library';

    private const SEPARATOR = '.';

    private const TABLE_BOOK = self::DATABASE_NAME . self::SEPARATOR . 'book';
    private const COLUMNS_BOOK = [
        'id' => Schema::TYPE_PK,
        'title' => Schema::TYPE_STRING . ' NOT NULL',
        'year_release' => Schema::TYPE_SMALLINT . ' NOT NULL',
        'isbn' => 'varchar(17) NOT NULL',
        'description' => Schema::TYPE_TEXT,
        'cover' => Schema::TYPE_STRING,
    ];

    private const TABLE_AUTHOR = self::DATABASE_NAME . self::SEPARATOR . 'author';
    private const COLUMNS_AUTHOR = [
        'id' => Schema::TYPE_PK,
        'surname' => Schema::TYPE_STRING . ' NOT NULL',
        'name' => Schema::TYPE_STRING . ' NOT NULL',
        'middle_name' => Schema::TYPE_STRING . ' NOT NULL',
    ];

    private const TABLE_BOOK_AUTHOR = self::DATABASE_NAME . self::SEPARATOR . 'book_author';
    private const COLUMNS_BOOK_AUTHOR = [
        'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        'book_id' => Schema::TYPE_INTEGER . ' NOT NULL',
    ];

    private const TABLE_AUTHOR_SUBSCRIPTION = self::DATABASE_NAME . self::SEPARATOR . 'author_subscription';
    private const COLUMNS_AUTHOR_SUBSCRIPTION = [
        'id' => Schema::TYPE_PK,
        'author_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        'phone' => 'varchar(18) NOT NULL',
    ];

    private const CREATE_TABLES = [
        self::TABLE_BOOK => self::COLUMNS_BOOK,
        self::TABLE_AUTHOR => self::COLUMNS_AUTHOR,
        self::TABLE_BOOK_AUTHOR => self::COLUMNS_BOOK_AUTHOR,
        self::TABLE_AUTHOR_SUBSCRIPTION => self::COLUMNS_AUTHOR_SUBSCRIPTION,
    ];

    private const CREATE_INDEXES = [
        self::TABLE_BOOK => [
            [
                'columns' => [
                    'isbn',
                ],
                'unique' => true,
            ],
        ],
        self::TABLE_BOOK_AUTHOR => [
            [
                'columns' => [
                    'author_id',
                    'book_id',
                ],
                'unique' => true,
            ],
        ],
        self::TABLE_AUTHOR => [
            [
                'columns' => [
                    'surname',
                    'name',
                    'middle_name',
                ],
                'unique' => true,
            ],
        ],
        self::TABLE_AUTHOR_SUBSCRIPTION => [
            [
                'columns' => [
                    'author_id',
                    'phone',
                ],
                'unique' => true,
            ],
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach (self::CREATE_TABLES as $table => $columns) {
            $this->createTable($table, $columns);
        }
        foreach (self::CREATE_INDEXES as $table => $indexes) {
            foreach ($indexes as $index)
            $this->createIndex(
                implode('__', $index['columns']),
                $table,
                $index['columns'],
                $index['unique']
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach (self::CREATE_TABLES as $table => $columns) {
            $this->dropTable($table);
        }
    }
}