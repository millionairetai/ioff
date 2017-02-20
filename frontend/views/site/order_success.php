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
<div class="hasbg padding-top-30">
    <article id="contact-page" class="container">
        <section>
            <div class="row">
                <div class="col-md-8">
                    <!-- Default box -->
                    <div class="box box-widget">
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-sm-3 col-xs-6 border-right">
                                    <div class="description-block">
                                        <span class="description-text"><?= Yii::t('frontend', 'PLAN TYPE') ?></span>
                                        <h5 class="description-header"><?= $packageInfo['package_name']; ?>
                                        </h5>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6 border-right">
                                    <div class="description-block">
                                        <span class="description-text"><?= Yii::t('frontend', 'MAXIMUM USER') ?></span>
                                        <h5 class="description-header"><?= $model->maxUser != 0 ? $model->maxUser : Yii::t('common', 'Unlimited'); ?>
                                        </h5>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6 border-right">
                                    <div class="description-block">
                                        <span class="description-text"><?= Yii::t('frontend', 'MAXIMUM STORAGE') ?></span>
                                        <h5 class="description-header"><?= $model->maxStorage; ?> GB

                                        </h5>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block">
                                        <span class="description-text"><?= Yii::t('frontend', 'PRICE') ?></span>
                                        <h5 class="description-header"><?= $packageInfo['total_money']; ?> VND/<?= empty($model->numberMonth) ? Yii::t('common', 'Unlimited') : $model->numberMonth; ?> <?= strtolower(Yii::t('common', 'month')); ?>
                                        </h5>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                        </div>

                        <div class="box-body">
                            <div>
                                Đăng ký tài khoản thành công...
                            </div>
                            <?php if (!$packageInfo['is_free_plan_type']): ?>
                                <div>
                                    Xin vui lòng chuyển khoản đến số tài khoản <?= Yii::$app->params['number_credit_card'] ?>
                                    <br />
                                    CÔNG TY CỔ PHẦN IPL<br />
                                    Ngân hàng ACB chi nhánh Hồ Chí Minh - Số TK: <?= Yii::$app->params['number_credit_card'] ?>. <br />
                                    Nội dung chuyển khoản: [tên người thanh toán][tên công ty] [sđt] thanh toán iOfficez.<br />
                                    *Lưu ý: sau khi chuyển khoản vui lòng liên hệ mail: <?= Yii::$app->params['support_email'] ?> hoặc hotline: <?= Yii::$app->params['hot_line_number'] ?> để được hỗ trợ tốt nhất.<br />
                                </div>
                            <?php endif ?>
                            <br />
                            <a href="<?= Yii::$app->params['companyDomain'] ?>"><?= Yii::t('common', 'Go to login page') ?></a>
                        </div>
                    </div><!-- /.box -->

                </div>
            </div>
        </section>
    </article>
</div>