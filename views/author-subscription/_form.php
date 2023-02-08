<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AuthorSubscription $authorSubscription */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="author-subscription-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($authorSubscription, 'author_id')->hiddenInput()->label(false) ?>

    <?= $form->field($authorSubscription, 'phone')->textInput(['maxlength' => true]) ?>

    <br/>
    <div class="form-group">
        <?= Html::submitButton('Subscribe on author ' . $authorSubscription->author->getFullName(), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
