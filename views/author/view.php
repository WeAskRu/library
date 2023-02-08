<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var bool $guest */
/** @var app\models\Author $author */

$this->title = $author->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="author-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!$guest) { ?>
            <?= Html::a('Update', ['update', 'id' => $author->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $author->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
        <?= Html::a('Subscribe on new release', ['author-subscription/create', 'author_id' => $author->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $author,
        'attributes' => [
            'id',
            'surname',
            'name',
            'middle_name',
        ],
    ]) ?>

</div>
