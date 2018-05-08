<?php

use yii\grid\GridView;

$this->title = 'Danh sách dịch';
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
            <h3 class="box-title">Danh sách từ được dịch</h3>
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
//                'column_name',
                    'owner_table',
//                'language_name',
                    [
                        'attribute' => 'language_id',
                        'value' => 'language_name',
                        'filter' => yii\helpers\ArrayHelper::map(common\models\Language::find()->asArray()->all(), 'id', 'name')
                    ],
                    'translated_text',
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
</section>