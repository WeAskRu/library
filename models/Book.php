<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property int $year_release
 * @property string $isbn
 * @property string|null $description
 * @property string|null $cover
 */
class Book extends ActiveRecord
{
    public $authorIds;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'year_release', 'isbn'], 'required'],
            [['year_release'], 'integer'],
            [['description'], 'string'],
            [['title', 'cover'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 17],
            [['isbn'], 'unique'],
            [['authorIds'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year_release' => 'Year Release',
            'isbn' => 'ISBN',
            'description' => 'Description',
            'cover' => 'Cover',
        ];
    }

    private function getAuthors(): ActiveQuery
    {
        return $this
            ->hasMany(Author::className(), ['id' => 'author_id'])
            ->viaTable(BookAuthor::tableName(), ['book_id' => 'id']);
    }

    public function withAuthors(): self
    {
        $this->authorIds = array_column($this->getAuthors()->select('id')->all(), 'id');
        return $this;
    }
}
