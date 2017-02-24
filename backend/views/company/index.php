<?php

use yii\grid\GridView;
use yii\grid\SerialColumn;
use \yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
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
        <h3 class="box-title"><?= Yii::t('backend', 'Company list') ?></h3>
        <!--        <div class="tool-right">
                    <a class="btn btn-info ng-binding" href="add"><i class="fa fa-plus-square"></i> ThÃªm</a>
                </div>-->
    </div><!-- /.box-header -->      
    <div class="box-body list-item">
        <?php Pjax::begin(); ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $model,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                'email',
//                'address',
                'phone_no',
//                'domain',                
                'total_storage',
                'total_employee',
                [
                    'label' => Yii::t('common', 'Plan type'),
                    'value' => 'plan_type.name',
                    'filter' => ArrayHelper::map(common\models\PlanType::find()->all(), 'id', 'name')
                ],
                [
                    'label' => Yii::t('common', 'Status'),
                    'value' => 'status.name',
                ],
//                [
//                    'label' => Yii::t('common', 'Language'),
//                    'value' => 'language.name',
//                ],
                [
                    'attribute' => 'max_user_register',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (!empty($model->max_user_register)) {
                            return $model->max_user_register;
                        }

                        return Yii::t('common', 'Unlimited');
                    },
                ],
                'max_storage_register',
                [
                    'attribute' => 'start_date',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (!empty($model->start_date)) {
                            return Yii::$app->formatter->asDate($model->start_date);
                        }

                        return '--';
                    },
                ],
                [
                    'attribute' => 'expired_date',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (!empty($model->expired_date)) {
                            return Yii::$app->formatter->asDate($model->start_date);
                        }

                        return Yii::t('common', 'Unlimited');
                    },
                ],
//                [
////                    'header' => 'Action',
//                    'options' => ['style' => 'width:50px'],
//                    'class' => 'yii\grid\ActionColumn',
//                    'template' => '{update} {delete}',
//                ],
                [
                    'options' => ['style' => 'width:50px'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return \yii\helpers\Html::a('<div class="text-center"><em data-toggle="tooltip"
                                                            data-placement="top" title="Lịch sử thanh toán"
                                                            class="fa fa-external-link-square text-warning"></em></div>', (new yii\grid\ActionColumn())->createUrl('invoice/payment-history', $model, $model['id'], 1), [
                                        'title' => Yii::t('yii', 'view'),
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                            ]);
                        },
                            ]
                        ]
                    ],
                ])
                ?>     
                <?php Pjax::end(); ?>
    </div>                

</div>