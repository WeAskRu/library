<?php

use app\models\BookAuthor;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var BookAuthor[] $bookAuthors */

$this->title = 'Authors top 10';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authors-top">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    foreach ($bookAuthors as $bookAuthor) {
        echo $bookAuthor->countBooks . ' - ' . $bookAuthor->author->getFullName() . '<br/>';
    }
    ?>

</div>
