<?php

use yii\grid\GridView;
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
        <h3 class="box-title">Functionoality group</h3>
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
                'column_name',
//                'id',
//                ['attribute' => 'translated_text', 'value' => 'translation.translated_text'],
                [
                    'attribute' => 'translated_text',
//                    'value' => 'translation.translated_text'
                ],
                [
                    'attribute' => 'language_id',
                    'value' => 'language.name',
                    'filter' => yii\helpers\ArrayHelper::map(common\models\Language::find()->asArray()->all(), 'id', 'name')
                ],
//                'translation.translated_text',
                'package_name',
//                'language_id',
//                'description',
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