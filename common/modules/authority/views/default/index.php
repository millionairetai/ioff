<?php

/* @var $this yii\web\View */
use common\modules\authority\Authority;
$this->title = 'Authority';
?>

<div class="authority-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
--------------11111
<?php 
echo Yii::t('authority', 'test');
//echo Yii::t('common', 'welcome');
 ?>