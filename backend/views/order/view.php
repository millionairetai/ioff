<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Controller;

$this->title = 'Thông tin đơn đặt hàng';
?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">
            Thông tin đơn đặt hàng
        </h3>
    </div><!-- /.box-header -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> iOfficez, ltd.
                    <small class="pull-right">
                        Ngày: <?= $invoiceInfo['date_invoice']; ?>
                    </small><br />
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                Từ
                <address>
                    <strong>iOfficez, Inc.</strong><br>
                    <?= $invoiceInfo['address_from']; ?><br>
                    <!--San Francisco, CA 94107<br>-->
                    Điện thoại: <?= $invoiceInfo['phone_from']; ?><br>
                    Email: <?= $invoiceInfo['email_from']; ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                Đến
                <address>
                    <strong><?= $invoiceInfo['fullname_to']; ?></strong><br>
                    <?= $invoiceInfo['address_to']; ?><br>
                    <!--                    San Francisco, CA 94107<br>-->
                    Điện thoại: <?= $invoiceInfo['phone_to']; ?><br>
                    Email: <?= $invoiceInfo['email_to']; ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <!--<b>Hóa đơn #007612</b><br>-->
                <br>
                <b>Order ID:</b> <?= $invoiceInfo['order_no']; ?><br>
                <!--<b>Payment Due:</b> 2/22/2014<br>-->
                <b>Tài khoản:</b> <?= $invoiceInfo['account']; ?>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Miểu tả</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><?= $invoiceInfo['product_name']; ?></td>
                            <td><?= $invoiceInfo['description']; ?></td>
                            <td><?= $invoiceInfo['subtotal']; ?> VND</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <!--<p class="lead">Phương thức thanh toán:</p>-->
                Hình thức thanh toán
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    Chuyển khoản ngân hàng đến số tài khoản 1039390902<br>
                    CÔNG TY CỔ PHẦN IPL<br>

                </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <!--<p class="lead">Amount Due 2/22/2014</p>-->

                <div class="table-responsive">
                    <table class="table">
                        <tbody><tr>
                                <th style="width:50%">Tiền:</th>
                                <td><?= $invoiceInfo['subtotal']; ?> VND</td>
                            </tr>
                            <tr>
                                <th>Thuế </th>
                                <td><?= $invoiceInfo['tax_percent']; ?></td>
                            </tr>
<!--                            <tr>
                                <th>Shipping:</th>
                                <td>$5.80</td>
                            </tr>-->
                            <tr>
                                <th>Tổng tiền:</th>
                                <td><?= $invoiceInfo['total']; ?> VND</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <?php
        $form = ActiveForm::begin([
                    'id' => 'health-form',
                    'options' => [
                        'class' => '',
                        'role' => 'form'
                    ],
                ])
        ?>
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="print?id=<?= $invoiceInfo['id']; ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> In</a> 
                <a href="index" class="btn btn-default pull-left"><i class="fa fa-backward"></i> Quay lại</a>
                <?php if ($invoiceInfo['is_wait_pay']): ?>
                    <input type="submit" value="Hoàn tất hóa đơn" class="btn btn-primary pull-right" style="margin-right: 5px;" /> 
                <?php endif; ?>
                <?php if ($invoiceInfo['is_payed']): ?>
                    <span style="color: green;" class="pull-right"><strong>Đã hoàn thành</strong></span>
                <?php endif; ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </section>
</div>
