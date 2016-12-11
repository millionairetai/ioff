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
                <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              
            </li>
            <li>
              <a href="/controller/index">
                <i class="fa fa-th"></i> <span>Nhóm chức năng</span> 
              </a>
            </li>
            <li>
              <a href="/action/index">
                <i class="fa fa-calendar"></i> <span>Chức năng</span> 
              </a>
            </li>
            <li>
              <a href="/staff/index">
                <i class="fa fa-users"></i> <span>Nhân viên</span> 
              </a>
            </li>
            <li>
              <a href="/company/index">
                <i class="fa fa-empire"></i> <span>Công ty</span> 
              </a>
            </li>
            <li>
              <a href="/translation/index">
                <i class="fa fa-empire"></i> <span>Văn bản dịch</span> 
              </a>
            </li>
            <li>
                <a href="<?php echo Url::to('/index/logout')?>">
                <i class="fa fa-sign-out"></i> <span>Đăng xuất</span> 
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>