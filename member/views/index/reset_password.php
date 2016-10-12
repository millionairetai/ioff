<?php

use yii\widgets\ActiveForm;
?>
<div class="container">
    <div class="box reset-password">
        <div class="box-header with-border">
            <h3 class="text-center box-title">Thay đổi mật khẩu </h3>
        </div>
        <div class="box-body">
            <div class="col-md-4">
                <div class="box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="http://member.centeroffice.dev/flies/employee/profileImageDefault.jpg" alt="User profile picture">
                    <h3 class="profile-username text-center">Nina Mcintire</h3>
                </div>
            </div>
            <div class="col-md-8">
                <form role="form">
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" id="inputNewpassword" placeholder="Mật khẩu mới">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" id="inputRenewPassword" placeholder="Nhập lại mật khẩu mới">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-flat">Thay đổi</button>
                        </div>
                    </div>
                </form><!-- End form-->
            </div>
        </div>
    </div>
</div>
