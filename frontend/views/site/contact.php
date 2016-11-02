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
        <li><a href="#">Home</a></li>
        <li><a href="#">Private</a></li>
        <li><a href="#">Pictures</a></li>
        <li class="active">Vacation</li>
    </ol>
</div>
<article id="contact-page" class="container">
    <section>
        <p>
            Đội ngũ hỗ trợ iOfficez<br/>
            Đồng hành 24/7 cùng công việc quản lý của hàng của bạn<br/>
            Văn phòng iOfficez<br/>
            216 Hoàng Văn Thụ, Phường 4, Quận Tân Bình, TP.HCM<br/>
            Email bộ phận tư vấn: support@ioffcez.com<br/>
            Email bộ phận Marketing: marketing@iofficez.com
        </p>
        <div class="clearfix">
            <div id="map" class="col-md-7">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.150071483846!2d106.66917041421478!3d10.799815861716109!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752928c58e6d39%3A0x8fc40781672e2da9!2zMjE0IEhvw6BuZyBWxINuIFRo4bulLCBwaMaw4budbmcgOCwgUGjDuiBOaHXhuq1uLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1472285520664"></iframe>
            </div>
            <div class="col-md-5">
                <form role="form" id="contactform">
                    <p><b>Liên hệ chúng tôi:</b></p>
                    <div class="form-group">
                        <label for="department">Gửi tới bộ phận</label>
                        <input type="text" name="department" id="department" class="form-control noround" placeholder="Chăm sóc khách hàng" tabindex="3">
                    </div>
                    <div class="form-group">
                        <label for="name"><span class="require">*</span> Họ tên:</label>
                        <input type="text" name="name" id="name" class="form-control noround" placeholder="Họ tên" tabindex="3">
                    </div>
                    <div class="form-group">
                        <label for="email"><span class="require">*</span> Email:</label>
                        <input type="email" name="email" id="email" class="form-control noround" placeholder="Địa chỉ" tabindex="3">
                    </div>
                    <div class="form-group">
                        <label for="phone"><span class="require">*</span> Điện thoại:</label>
                        <input type="text" name="phone" id="phone" class="form-control noround" placeholder="Email" tabindex="3">
                    </div>
                    <div class="form-group">
                        <label for="comment"><span class="require">*</span> Nội dung:</label>
                        <textarea name="comment" id="comment" class="form-control noround" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary noround">Gửi</button>
                </form>
            </div>
        </div>
    </section>
</article>