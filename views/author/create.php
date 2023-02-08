<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Author $author */

$this->title = 'Create Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'author' => $author,
    ]) ?>

</div>
