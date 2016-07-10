<?php 
use yii\helpers\Url;
?>
<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="img/avatar5.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->getFullname(); ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
        
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
                <i class="fa fa-th"></i> <span>Functionality group</span> 
              </a>
            </li>
            <li>
              <a href="/action/index">
                <i class="fa fa-calendar"></i> <span>Functionality</span> 
              </a>
            </li>
            <li>
                <a href="<?php echo Url::to('/index/logout')?>">
                <i class="fa fa-sign-out"></i> <span> Logout</span> 
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>