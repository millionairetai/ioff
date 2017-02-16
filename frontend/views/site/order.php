<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Order</li>
    </ol>
</div>
<article id="contact-page" class="container">
    <section>
        <div class="row">
            <?php
            $form = ActiveForm::begin(['id' => 'form-signup', 'action' => '/site/order', 'fieldConfig' => [
                            'template' => "{input}",
                            'options' => [
                                'tag' => 'span'
                            ]
            ]]);
            ?>
            <div class="col-md-8">
                <!-- Default box -->
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-text"><?= Yii::t('frontend', 'PLAN TYPE') ?></span>
                                    <h5 class="description-header"><?= $packageInfo['package_name']; ?>
                                    <?= $form->field($model, 'plan_type')->hiddenInput()->label(false); ?></h5>
                                    </h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-text"><?= Yii::t('frontend', 'MAXIMUM USER') ?></span>
                                    <h5 class="description-header"><?= $model->maxUser != 0 ? $model->maxUser : Yii::t('common', 'Unlimited'); ?>
                                        <?= $form->field($model, 'maxUser')->hiddenInput()->label(false); ?></h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-text"><?= Yii::t('frontend', 'MAXIMUM STORAGE') ?></span>
                                    <h5 class="description-header"><?= $model->maxStorage; ?> GB
                                        <?= $form->field($model, 'maxStorage')->hiddenInput()->label(false); ?>
                                    </h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block">
                                    <span class="description-text"><?= Yii::t('frontend', 'PRICE') ?></span>
                                    <h5 class="description-header"><?= $packageInfo['total_money']; ?> VND/<?= empty($model->numberMonth) ? Yii::t('common', 'Unlimited') : $model->numberMonth; ?> <?= strtolower(Yii::t('common', 'month')) ?>
                                    <?= $form->field($model, 'numberMonth')->hiddenInput()->label(false); ?></h5>
                                    </h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table borderless">
                            <caption><h4>1. <?= Yii::t('common', 'Invoice') ?></h4></caption>
                            <tbody>
                                <tr>
                                    <th><?= Yii::t('common', 'Company name') ?>:</th>
                                    <td><?= $model->companyName; ?>
                                        <?= $form->field($model, 'companyName')->hiddenInput()->label(false); ?></td>
                                </tr>
                                <tr>
                                    <th><?= Yii::t('common', 'Firstname') ?>:</th>
                                    <td><?= $model->firstname; ?>
                                        <?= $form->field($model, 'firstname')->hiddenInput()->label(false); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= Yii::t('common', 'Lastname') ?>:</th>
                                    <td><?= $model->lastname; ?>
                                        <?= $form->field($model, 'lastname')->hiddenInput()->label(false); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= Yii::t('common', 'Phone no') ?>:</th>
                                    <td><?= $model->phoneNo; ?>
                                        <?= $form->field($model, 'phoneNo')->hiddenInput()->label(false); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><?= $model->email; ?>
                                        <?= $form->field($model, 'email')->hiddenInput()->label(false); ?>
                                        <?= $form->field($model, 'password')->hiddenInput()->label(false); ?>
                                        <?= $form->field($model, 'rePassword')->hiddenInput()->label(false); ?>
                                        <?= $form->field($model, 'maxUser')->hiddenInput()->label(false); ?>
                                        <?= $form->field($model, 'maxStorage')->hiddenInput()->label(false); ?>
                                        <?= $form->field($model, 'numberMonth')->hiddenInput()->label(false); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table borderless">
                            <caption><h4>2. <?= Yii::t('common', 'Payment') ?> (* Nếu đăng ký gói Free bạn có thể bỏ qua thông tin này)</h4></caption>
                            <tbody>
                                <tr>
                                    <th><?= Yii::t('common', 'Method payment') ?>:</th>
                                    <td><?= Yii::t('common', 'Bank transfer') ?> đến số tài khoản <?= Yii::$app->params['number_credit_card'] ?>
                                        <br />
                                        CÔNG TY CỔ PHẦN IPL<br />
                                        Ngân hàng ACB chi nhánh Hồ Chí Minh - Số TK: <?= Yii::$app->params['number_credit_card'] ?>. <br />
                                        Nội dung chuyển khoản: [tên người thanh toán][tên công ty] [sđt] thanh toán iOfficez.<br />
                                        *Lưu ý: sau khi chuyển khoản vui lòng liên hệ mail: <?= Yii::$app->params['support_email'] ?> hoặc hotline: <?= Yii::$app->params['hot_line_number'] ?> để được hỗ trợ tốt nhất.<br />
                                    </td>
                                </tr>
<!--                                <tr>
                                    <th colspan="2">Red Invoice</th>
                                </tr>-->
                                <tr>
                                    <th><?= Yii::t('common', 'Company name') ?>:</th>
                                    <td><?= $model->companyName; ?>
                                        <?= $form->field($model, 'companyName')->hiddenInput()->label(false); ?>
                                    </td>
                                </tr>
<!--                                <tr>
                                    <th>Type of company:</th>
                                    <td>Ho Chi Minh</td>
                                </tr>-->
                                <tr>
                                    <th><?= Yii::t('common', 'Tax') ?>:</th>
                                    <td>0</td>
                                </tr>
<!--                                <tr>
                                    <th>City:</th>
                                    <td>Ho Chi Minh</td>
                                </tr>
                                <tr>
                                    <th>Province:</th>
                                    <td>Ho Chi Minh</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>Input address of ward...</td>
                                </tr>-->
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('common', 'Complete'), ['class' => 'btn btn-primary noround', 'name' => 'complete-register']) ?>
                    </div>
                </div><!-- /.box -->

            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </section>
</article>