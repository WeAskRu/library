<?php

use app\models\Author;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $book */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($book, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($book, 'year_release')->textInput() ?>

    <?= $form->field($book, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($book, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($book, 'cover')->textInput(['maxlength' => true]) ?>

    <?= $form->field($book, 'authorIds')->dropDownList(
            Author::listAll('id', 'surname'),
            ['multiple' => true]
        )
    ?>

    <br/>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
