<?php

use yii\grid\GridView;
use yii\grid\SerialColumn;
?>
<style type="text/css">
    .tool-right {
        position: absolute;
        right: 10px;
        top: 10px;
    }
</style>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('backend', 'Staff list') ?></h3>
        <div class="tool-right">
            <a class="btn btn-info ng-binding" href="add"><i class="fa fa-plus-square"></i> Thêm</a>
        </div>
    </div><!-- /.box-header -->      
    <div class="box-body list-item">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $model,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'username',
                'email',
                'address',
                'phone_no',
                [
                    'attribute' => 'name',
                    'label' => Yii::t('backend', 'Job'),
                    'value' => 'job.name',
                    'filter' => [ 'Sale' => 'Sale', 'Absent' => 'Absent', 'Leave' => 'Leave',],
                ],
//                [
//                    'label' => 'Authority name',
//                    'value' => 'authority.name',
//                ],
                [
//                    'header' => 'Action',
                    'options' => ['style' => 'width:50px'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ]
            ],
            
        ])
        ?>             
    </div>                

</div>