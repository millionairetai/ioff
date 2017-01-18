<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\PlanType;

$this->title = 'iofficez - Kết nối nhân viên';
?>
<section id="register" class="contain-box">
    <div  class="container clearfix">
        <div id="regform">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <p>iOfficez kết nối nhân viên và công việc trong doanh nghiệp</p>

            <?= $form->field($model, 'companyName')->label(false)->textInput(['placeholder' => Yii::t('common', 'Company name'), 'autofocus' => true, 'class' => 'form-control noround']) ?>

            <?= $form->field($model, 'firstname')->label(false)->textInput(['placeholder' => Yii::t('common', 'First name'), 'class' => 'form-control noround']) ?>

            <?= $form->field($model, 'lastname')->label(false)->textInput(['placeholder' => Yii::t('common', 'Last name'), 'class' => 'form-control noround']) ?>

            <?= $form->field($model, 'email')->label(false)->textInput(['placeholder' => Yii::t('common', 'Email'), 'class' => 'form-control noround']) ?>

            <?= $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => Yii::t('common', 'Password'), 'class' => 'form-control noround']) ?>
            
            <?= $form->field($model, 'rePassword')->label(false)->passwordInput(['placeholder' => Yii::t('common', 'Re-Password'), 'class' => 'form-control noround']) ?>

            <?=
            $form->field($model, 'plan_type_id')->label(false)->dropDownList(
                    ArrayHelper::map(PlanType::find()->select(['id', 'name'])->all(), 'id', 'name'), ['prompt' => Yii::t('common', 'Select'), 'class' => 'form-control noround']
            )
            ?>

            <p><a href="#">Xem thông tin chi tiết các gói</a></p>

            <p>Bằng cách nhấp vào đăng ký, bạn đồng ý với các <a href="/site/term">điều khoản của chúng tôi</a> và rằng bạn đã đọc <a href="/site/term">chính sách dữ liệu</a> của chúng tôi, bao gồm sử dụng cookie.</p>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('common', 'Register'), ['class' => 'btn btn-primary noround', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div><!-- Regform -->
    </div><!-- Container -->
</section>
<section id="feature" class="contain-box">
    <h3 class="h3-title">IOFFICEZ</h3>
    <p class="text-center">
        Tăng hiệu suất làm việc,tăng doanh thu doanh thu doanh nghiệp bạn<br/>
        Những tính năng nổi bật
    </p>
    <div class="container fixHeight">
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/mang-xa-hoi.png" alt=""/></div>
            </div>
            <dl>
                <dt>MẠNG XÃ HỘI DN</dt>
                <dd>Đăng bài, bình luận, theo dõi like,kết nối với các nhân viên khác</dd>
            </dl>
        </div><!--item feature-->
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/thong-bao.png" alt=""/></div>
            </div>
            <dl>
                <dt>THÔNG BÁO</dt>
                <dd>Thông báo tất cả mọi thứ có liên quan tới bạn</dd>
            </dl>
        </div><!--item feature-->
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/cong-viec.png" alt=""/></div>
            </div>
            <dl>
                <dt>CÔNG VIỆC</dt>
                <dd>Quản lý công việc của bạn theo dự án công việc bạn đang theo dõi</dd>
            </dl>
        </div><!--item feature-->
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/lich.png" alt=""/></div>
            </div>
            <dl>
                <dt>LỊCH</dt>
                <dd>Xem các lịch và sự kiện trong doanh nghiệp</dd>
            </dl>
        </div><!--item feature-->
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/yeu-cau.png" alt=""/></div>
            </div>
            <dl>
                <dt>YÊU CẦU</dt>
                <dd>Gửi yêu cầu tới cấp trên người khác gửi tới</dd>
            </dl>
        </div><!--item feature-->
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/thong-bao-dn.png" alt=""/></div>
            </div>
            <dl>
                <dt>THÔNG BÁO DN</dt>
                <dd>Thông báo tin tức nội bộ trong doanh nghiệp</dd>
            </dl>
        </div><!--item feature-->
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/bao-cao.png" alt=""/></div>
            </div>
            <dl>
                <dt>BÁO CÁO</dt>
                <dd>Xem báo cáo công việc của bạn và công việc theo dõi, phân công</dd>
            </dl>
        </div><!--item feature-->
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/phan-quyen.png" alt=""/></div>
            </div>
            <dl>
                <dt>PHÂN QUYỀN ĐỘNG</dt>
                <dd>Cấp quyền, hạn chế quyền khi sử dụng chức năng của nhân viên</dd>
            </dl>
        </div><!--item feature-->
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/tat-ca-thiet-bi.png" alt=""/></div>
            </div>
            <dl>
                <dt>TẤT CẢ THIẾT BỊ</dt>
                <dd>Sử dụng nó với tất cả các loại thiết bị hiện đại như: Smartphone, tablet</dd>
            </dl>
        </div><!--item feature-->
        <div class="item-feature">
            <div class="nvntable">
                <div class="image nvncell"><img src="/image/icon/sms.png" alt=""/></div>
            </div>
            <dl>
                <dt>SMS</dt>
                <dd>Gửi tin nhắn tới nhân viên</dd>
            </dl>
        </div><!--item feature-->
    </div><!--Container-->
    <p class="text-center"><a href="javascript:void(0)" class="btn btn-primary noround">Đăng ký</a></p>
</section><!--Feature-->
<section id="subcribe" class="contain-box">
    <div class="container">
        <div class="col-md-6">
            <p>Để là <span class="regular">người đầu tiên</span> biết được <span>những chức năng mới</span></p>
        </div>
        <div class="col-md-6">
            <?php $subscribeForm = ActiveForm::begin(['id' => 'form-subscribe']); ?>

            <div class="row">
                <div class="col-xs-12 col-xs-8 col-sm-6">
                    <?= $subscribeForm->field($subscribeModel, 'email')->label(false)->textInput(['placeholder' => 'your@email.com', 'class' => 'form-control noround', 'tabindex' =>"1"]) ?>
                </div>
                <div class="col-xs-12 col-xs-4 col-sm-6"><?= Html::submitButton('SUBSCRIBE', ['class' => 'btn btn-subcribe noround', 'name' => 'subscribe-button']) ?></div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
<section id="pricelist" class="contain-box">
    <h3 class="h3-title">BẢNG GIÁ</h3>
    <p class="text-center">Ba gói chính với nhiều tính năng hữu ích</p>
    <div class="container fixHeight">
        <div class="price-free">
            <div class="item-pricelist text-center border-solid">
                <h4>Free</h4>
                <p class="price">0$/tháng</p>
                <p>
                    Tối đa 5 người dùng<br/>
                    500MB lưu trữ<br/>
                    Sử dụng tất cả các chức năng
                </p>
                <p class="text-center"><a href="javascript:void(0)" class="btn btn-primary noround">Đăng ký</a></p>
            </div>
        </div>
        <div class="price-standard">
            <div class="item-pricelist text-center border-solid">
                <h4>Standard</h4>
                <p class="price">$/tháng</p>
                <p>
                    Được chọn người dùng tối đa <br/>
                    Được chọn dung lượng lưu trữ tối đa<br/>
                    Sử dụng tất cả các chức năng
                </p>
                <p class="text-center"><a href="javascript:void(0)" class="btn btn-primary noround">Đăng ký</a></p>
            </div>
        </div>
        <div class="price-professional">
            <div class="item-pricelist text-center border-solid">
                <h4>Professional</h4>
                <p class="price">50$/tháng</p>
                <p>
                    Người dùng không giới hạn<br/>
                    10GB lưu trữ đầu miễn phí<br/>
                    Thêm 5GB/5$/tháng<br/>
                    Sử dụng tất cả các chức năng
                </p>
                <p class="text-center"><a href="javascript:void(0)" class="btn btn-primary noround">Đăng ký</a></p>
            </div>
        </div>
    </div><!--Container-->
</section><!--Pricelist-->
<section id="social" class="contain-box">
    <div class="container">
        <div class="imgright marg30 clearfix">
            <div class="image"><img src="/image/index01.jpg" alt=""/></div>
            <dl>
                <dt>Mạng xã hội doanh nghiệp</dt>
                <dd>
                    Giao tiếp như bạn đã làm trong các mạng xã hội khác, chỉ với các quy tắc của riêng bạn. Viết bài và cập nhật, chia sẽ file, thích và bình luận chỉ là cách bạn muốn nó.
                </dd>
            </dl>
        </div>
        <div class="imgleft clearfix">
            <div class="image"><img src="/image/index02.jpg" alt=""/></div>
            <dl>
                <dt>Khả năng không giới hạn</dt>
                <dd>
                    Với module bạn có thể sửa đổi bất cứ điều gì, không gian, hồ sơ và những thứ khác theo yêu cầu của bạn, bất cứ điều gì bạn đang thiếu trên các mạng xã hội khác, bạn có thể xây dựng nó.
                </dd>
            </dl>
        </div>
    </div>
</section>
<section id="customer" class="hasbg contain-box">
    <div class="container">
        <h3 class="h3-title">KHÁCH HÀNG TIÊU BIỂU</h3>
        <p class="text-center">
            Nhiều khách hàng sử dụng iOffice và đã nâng cao hiệu suất công việc, tăng doanh thu<br/>
            cho công ty rút ngắn thời gian và chi phí cho việc thực hiện công việc
        </p>
        <div class="listcustomer clearfix">
            <div class="item-customer"><img src="/image/customer01.jpg" alt=""/></div>
            <div class="item-customer"><img src="/image/customer02.jpg" alt=""/></div>
            <div class="item-customer"><img src="/image/customer03.jpg" alt=""/></div>
            <div class="item-customer"><img src="/image/customer04.jpg" alt=""/></div>
            <div class="item-customer"><img src="/image/customer05.jpg" alt=""/></div>
        </div>
        <p class="text-center"><a href="javascript:void(0)" class="btn btn-primary noround">Đăng ký</a></p>
    </div>
</section>