<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $surname
 * @property string $name
 * @property string|null $middle_name
 */
class Author extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['surname', 'name'], 'required'],
            [['surname', 'name', 'middle_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'surname' => 'Surname',
            'name' => 'Name',
            'middle_name' => 'Middle Name',
        ];
    }

    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true): array
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

    public function getFullName(): string
    {
        if ($this->isNewRecord) {
            return '';
        }
        return sprintf('%s %s.%s.',
            $this->surname,
            mb_substr($this->name, 0, 1),
            mb_substr($this->middle_name, 0, 1),
        );
    }
}
