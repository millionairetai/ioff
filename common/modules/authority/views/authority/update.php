<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\authority\models\Action */

$this->title = Yii::t('authority', 'Update {modelClass}: ', [
    'modelClass' => 'Action',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('authority', 'Actions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('authority', 'Update');
?>
<div class="action-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
