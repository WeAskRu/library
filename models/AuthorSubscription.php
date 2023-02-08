<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "author_subscription".
 *
 * @property int $id
 * @property int $author_id
 * @property string $phone
 * @property Author $author
 */
class AuthorSubscription extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'author_subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['author_id', 'phone'], 'required'],
            [['author_id', 'phone'], 'integer'],
            [['phone'], 'string', 'max' => 18],
            [['author_id', 'phone'], 'unique', 'targetAttribute' => ['author_id', 'phone']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'phone' => 'Phone',
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
}
