<?php

use yii\widgets\ActiveForm;
?>
<div class="container">
    <div class="row">
        <div class="forget-password">
            <form class="form-horizontal" role="form">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3>Tìm tài khoản của bạn</h3>
                        <span>
                            Chúng tôi có thể giúp bạn đặt lại mật khẩu của mình bằng địa chỉ email được liên kết với tài khoản của bạn.
                        </span>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail" class="col-xs-2 control-label"><i class="fa fa-envelope"></i></label>
                            <div class="col-xs-7 no-padding">
                                <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary btn-flat">Tìm kiếm</button>
                            <button type="submit" class="btn btn-danger btn-flat">Hủy</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
