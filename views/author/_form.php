<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Author $author */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="author-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($author, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($author, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($author, 'middle_name')->textInput(['maxlength' => true]) ?>

    <br/>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
