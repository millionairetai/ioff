<?php 
use yii\helpers\Url;
?>
<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="treeview">
                <a ui-sref="home">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
            </li>
            <li>
              <a ui-sref="project">
                <i class="fa fa-th"></i> <span>Project</span> 
              </a>
            </li>
            <li>
              <a ui-sref="calendar">
                <i class="fa fa-calendar"></i> <span>Calendar</span> 
              </a>
            </li>
            <li>
              <a ui-sref="authority">
                <i class="fa fa-group"></i> <span>Authorities</span> 
              </a>
            </li>
            <li>
                <a href="<?php echo Url::to('index/logout')?>">
                <i class="fa fa-sign-out"></i> <span> Logout</span> 
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
