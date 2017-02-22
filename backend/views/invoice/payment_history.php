<?php 
    $this->title = 'Lịch sử thanh toán';
?>
<section class="content-header">
    <h1>PAYMENT HISTORY</h1>
</section>
<section class="content">
    <ul class="timeline-create">
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
</section>