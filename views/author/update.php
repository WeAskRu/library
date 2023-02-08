<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Author $author */

$this->title = 'Update Author: ' . $author->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $author->getFullName(), 'url' => ['view', 'id' => $author->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="author-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'author' => $author,
    ]) ?>

</div>
