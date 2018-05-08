<?php

use yii\grid\GridView;
use yii\grid\SerialColumn;

$this->title = 'Chức năng';
?>
<style type="text/css">
    .tool-right {
        position: absolute;
        right: 10px;
        top: 10px;
    }
</style>
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Chức năng</h3>
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
                    'controller_column_name',
                    'column_name',
                    'is_display_menu',
                    'is_check',
                    'url',
//                'description',
                    [
                        'options' => ['style' => 'width:50px'],
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                    ]
                ],
            ])
            ?>             
        </div>                

    </div>
</section>