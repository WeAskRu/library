<?php

use app\models\Author;
use app\models\Book;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var bool $guest */
/** @var Book $book */
/** @var Author[] $authors */

$this->title = $book->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!$guest) { ?>
            <?= Html::a('Update', ['update', 'id' => $book->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $book->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $book,
        'attributes' => [
            'id',
            'title',
            'year_release',
            'isbn',
            'description:ntext',
            'cover',
            [
                'label' => 'Authors',
                'format' => 'raw',
                'value' => $authors === []
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
                    ),
            ],
        ],
    ]) ?>

</div>
