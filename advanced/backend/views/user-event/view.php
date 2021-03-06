<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\entities\UserEventEntity */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Event Entities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-event-entity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'group',
            'name',
            'event',
            'description',
            'sort',
            'is_public',
            'event_template',
            'status',
        ],
    ]) ?>

</div>
