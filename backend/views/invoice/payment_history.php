<?php
$this->title = 'Lịch sử thanh toán';
?>
<section class="content-header">
    <h1>Lịch sử thanh toán</h1>
</section>
<section class="content">
    <ul class="timeline-create">
        <?php if (!$invoices): ?>
            Không có dữ liệu
        <?php endif; ?>

        <?php foreach ($invoices as $invoice): ?>
            <li class='work'>
                <div class="relative">
                    <span class='date'><?= $invoice['datetime_created']; ?></span>
                    <span class='circle'></span>
                </div>
                <div class='content-timeline'>
                    <h3 class="timeline-header"><?= $invoice['plan_type_name']; ?> <?= !empty($invoice['number_month']) ? ' - ' . $invoice['number_month'] . ' ' . Yii::t('common', 'month') : ''; ?> </h3>
                    <a href="/invoice/detail?invoiceId=<?= $invoice['id']; ?>&companyId=<?= $companyId; ?>">
                        <h5>
                            <strong>
                                <div class="timeline-body">
                                    <?= $invoice['description']; ?>
                                </div>
                            </strong>    
                        </h5>
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="col-xs-12">
        <a href="/company/index" class="btn btn-default pull-left"><i class="fa fa-backward"></i> Quay lại</a>
    </div>
</section>