<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\entities\CommentEntity */

$this->title = 'Create Answer Comment Entity';
$this->params['breadcrumbs'][] = ['label' => 'Answer Comment Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-entity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
