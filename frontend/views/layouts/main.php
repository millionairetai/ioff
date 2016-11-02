<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <header>
            <div class="container">
                <nav class="clearfix">
                    <p class="text-right">
                        <a class="navmobile" href="javascript:void(0)"><i class="glyphicon glyphicon-th-list"></i> Menu</a>
                        <a href="index.html"><i class="glyphicon glyphicon-home"></i></a>
                    </p>
                    <ul class="clearfix">
                        <li><a href="/site/index">Trang chủ</a></li>
                        <li><a href="javascript:void(0)" onclick="jumpto('#feature');">Tính năng</a></li>
                        <li><a href="javascript:void(0)" onclick="jumpto('#pricelist');">Bảng giá</a></li>
                        <li><a href="javascript:void(0)">Hình ảnh</a></li>
                        <li><a href="javascript:void(0)" onclick="jumpto('#customer');">Khách hàng</a></li>
                        <li><a href="/site/contact">Hỗ trợ</a></li>
                        <li><a href="javascript:void(0)">Tin tức</a></li>
                        <li><a href="javascript:void(0)">Về iOffice</a></li>
                    </ul>
                </nav>
            </div>
            <div class="header">
                <div class="container">
                    <figure class="logo"><img src="/image/logo.jpg" alt=""/></figure>
                    <div id="mobile-login">
                        <a href="javascript:void(0)" class="btn btn-default">Đăng nhập</a>
                    </div>
                    <div id="loginform" role="dialog">
                        <form class="form-inline">
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputEmail3">Email address</label>
                                <input type="email" class="form-control noround" id="exampleInputEmail3" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputPassword3">Password</label>
                                <input type="password" class="form-control noround" id="exampleInputPassword3" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-default noround">Đăng nhập</button>
                        </form>
                        <a href="javascript:void(0)">Quên tài khoản</a>
                    </div>
                </div>
            </div>
        </header>
        <!--End header-->
        <div class="wrap">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <!--End footer-->
    <footer>
        <div class="ftop clearfix">
            <div class="container">
                <div id="fcontact" class="clearfix">
                    <div class="fhotline">
                        <h3><span>HỖ TRỢ</span> NHANH</h3>
                        <dl><dt>HOTLINE</dt><dd>1900 0676</dd></dl>
                    </div>
                    <div class="femail">
                        <dl>
                            <dt>Email bộ phận tư vấn</dt>
                            <dd>support@iofficez.vn</dd>
                            <dt>Email bộ phận tiếp thị</dt>
                            <dd>marketing@iofficez.vn</dd>
                        </dl>
                    </div>
                    <div class="clearfix"></div>
                    <div class="flogo"><img src="/image/f_logo.png" alt=""/></div>
                    <h1>CÔNG TY CỔ PHẦN I.P.L</h1>
                    <p>216 Hoàng Văn Thụ, P. 4,<br/>Q. Tân Bình, TP. HCM</p>

                </div>
                <div id="fabout">
                    <p class="cllink">Về iOfficez</p>
                    <ul>
                        <li><a href="">> Trang chủ</a></li>
                        <li><a href="">> MobiWork DMS giúp gì?</a></li>
                        <li><a href="">> Bảng giá</a></li>
                        <li><a href="">> Hỗ trợ</a></li>
                        <li><a href="">> Kiến thức</a></li>
                        <li><a href="">> Liên hệ</a></li>
                        <li><a href="">> Tuyển dụng</a></li>
                    </ul>
                    <p><img src="/image/f_banner03.png" alt=""/></p>
                </div>
                <div id="fapp">
                    <p class="cllink">TRÊN TRÌNH DUYỆT WEB</p>
                    <p><img src="/image/f_link01.png" alt=""/></p>
                    <p class="marg0">iOFFICEZ DMS</p>
                    <p class="cllink marg60">TRÊN THIẾT BỊ DI ĐỘNG</p>
                    <p class="marg40"><img src="/image/f_banner01.png" alt=""/></p>
                    <p><img src="/image/f_banner02.png" alt=""/></p>
                </div>
            </div>
        </div>
        <div class="fbot">
            <p>Copyrigh 2016 by<br/>Công ty cổ phần I.P.L<br/>Chúng tôi xây dựng sản phẩm<br/>Mã số doanh nghiệp: 0310140399 | Điện thoại: 1900 6076 | Email:info@iofficez.vn</p>
            <ul>
                <li><a href="">Chính sách bảo hành</a></li>
                <li><a href="">Chính sách bảo mật thông tin</a></li>
                <li><a href="">Thỏa thuận sử dụng dịch vụ </a></li>
            </ul>

            <ul class="fnav">
                <li><a href=""><img src="/image/f_nav01.png" alt=""/></a></li>
                <li><a href=""><img src="/image/f_nav02.png" alt=""/></a></li>
                <li><a href=""><img src="/image/f_nav03.png" alt=""/></a></li>
            </ul>
        </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php $this->endBody() ?>
    <script type="text/javascript">
        jQuery("#mobile-login a").click(function () {
            jQuery("#loginform form").before("<div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal'>&times;</button><h4 class='modal-title'>Đăng nhập</h4></div><div class='modal-body'><div id='flat'></div></div></div>");
            jQuery("#loginform #flat").before(jQuery("#loginform form"));
            jQuery("#loginform").addClass("modal fade");
            jQuery("#loginform").modal("show");
        });
    </script>
    <script>
        function jumpto(element) {
            var elementOffset = $(element).offset().top - 128;
            $('html, body').animate({
                scrollTop: elementOffset
            }, 500);
        }
    </script>
</body>
</html>
<?php $this->endPage() ?>
