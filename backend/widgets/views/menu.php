<?php

use yii\helpers\Url;
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
                <a href="/">
                    <i class="fa fa-dashboard"></i> <span>Màn hình chính</span> <i class="fa pull-right"></i>
                </a>

            </li>
            <li>
                <a href="/invoice/revenue">
                    <i class="fa fa-money"></i> <span>Doanh thu</span> <i class="fa pull-right"></i>
                </a>
            </li>
            <li class="active">
                <a href="/company/index">
                    <i class="fa fa-empire"></i> <span>Công ty</span> 
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="/company/index"><i class="fa fa-circle-o"></i> Danh sách</a></li>
                    <li><a href="/company/report"><i class="fa fa-circle-o"></i> Thống kê</a></li>
                </ul>
            </li>
            <li>
                <a href="/order/index">
                    <i class="fa fa-credit-card"></i> <span>Hoá đơn</span> 
                </a>
            </li>
            <li>
                <a href="/staff/index">
                    <i class="fa fa-users"></i> <span>Nhân viên</span> 
                </a>
            </li>
            <li>
                <a href="/controller/index">
                    <i class="fa fa-th"></i> <span>Nhóm chức năng</span> 
                </a>
            </li>
            <li>
                <a href="/action/index">
                    <i class="fa  fa-certificate"></i> <span>Chức năng</span> 
                </a>
            </li>
            <li>
                <a href="/translation/index">
                    <i class="fa fa-empire"></i> <span>Văn bản dịch</span> 
                </a>
            </li>
            <li>
                <a href="<?php echo Url::to('/index/logout') ?>">
                    <i class="fa fa-sign-out"></i> <span>Đăng xuất</span> 
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>