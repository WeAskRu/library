<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Author $author */

$this->title = 'Success subscription on author: ' . $author->getFullName();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-subscription-create">

    <h1><?= Html::encode($this->title) ?></h1>

</div>
