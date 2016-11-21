<?php

use yii\widgets\ActiveForm;
?>
<div class="container">
    <div class="row">
        <div class="register-box">
            <?php $form = ActiveForm::begin(); ?>
                <h2>Confirming registration on iofficez</h2>
                <hr/>
                <p><b><?= Yii::t('common', 'Email') ?></b>: <?= $$registration->email ?></p>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" tabindex="1">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" tabindex="2">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->field($$registration, 'password', ['template' => '{input}'])->passwordInput(['placeholder' => \Yii::t('common', 'Password'), 'tabindex' => 3]); ?>
                </div>
                <div class="form-group">
                    
                </div>
                <hr/>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label class="">
                                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
                <a href="login" class="text-center">I already have a membership</a>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
