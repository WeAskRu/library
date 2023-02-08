<?php

use app\models\Author;
use app\models\Book;
use app\services\BookAuthorService;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var bool $guest */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!$guest) { ?>
        <p>
            <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'year_release',
            'isbn',
            'description:ntext',
            [
                'label' => 'Cover',
                'format' => 'raw',
                'value' => function($book) {
                    return Html::img(
                        // random image
                        'https://randart.ru/art/JD99/wallpapers?h=100&w=100&q=100&cover=' . $book->cover,
                        ['alt' => $book->title],
                    );
                }
            ],
            [
                'label' => 'Authors',
                'format' => 'raw',
                'value' => function($book) {
                    $authors = BookAuthorService::getBooksAuthorsWithIndex($book->id);
                    return $authors === []
                        ? 'unknown'
                        : implode(
                        ', ',
                        array_map(
                            static fn(Author $author) => Html::a(
                                $author->getFullName(),
                                ['author/view', 'id' => $author->id]
                            ),
                            $authors
                        )
                    );
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => $guest ? '{view}' : '{view}</br>{update}</br>{delete}',
            ],
        ],
    ]); ?>


</div>
