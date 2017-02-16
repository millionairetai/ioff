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
        <h3 class="box-title">Danh sách hóa đơn</h3>
    </div><!-- /.box-header -->      
    <div class="box-body list-item">
        
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $model,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'company_name',
                'order_number',
                'expired_datetime:datetime',
                'status_name',
                'plan_type_name',
                'number_month',
                'max_user_register',
                'max_storage_register',
                [
                    'options' => ['style' => 'width:50px'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                ]
            ],
        ])
        ?>             
    </div>                

</div>