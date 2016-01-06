<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\calendar\event */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">

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
            'calendar_id',
            'employee_id',
            'name',
            'description:ntext',
            'description_parse:ntext',
            'address',
            'start_datetime',
            'end_datetime:datetime',
            'is_public:boolean',
            'datetime_created',
            'lastup_datetime',
            'lastup_employee_id',
            'disabled:boolean',
        ],
    ]) ?>

</div>
