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
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="#home">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              
            </li>
            <li>
              <a href="#project">
                <i class="fa fa-th"></i> <span>Project</span> 
              </a>
            </li>
            <li>
              <a href="#calendar">
                <i class="fa fa-calendar"></i> <span>Calendar</span> 
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