<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AuthorSubscription $authorSubscription */

$this->title = 'Subscribe on author ' . $authorSubscription->author->getFullName();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-subscription-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'authorSubscription' => $authorSubscription,
    ]) ?>

</div>
