<?php

use yii\helpers\Url;
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="#home">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            <li>
                <a href="#activity">
                    <i class="fa fa-thumbs-up"></i> <span>Activity</span> 
                </a>
            </li>
            <li>
                <a href="#project">
                    <i class="fa fa-th"></i> <span>Project</span> 
                </a>
            </li>
            <li>
                <a href="#task">
                    <i class="fa fa-tasks"></i> <span>Task</span> 
                </a>
            </li>
            <li>
                <a href="#calendar">
                    <i class="fa fa-calendar"></i> <span>Calendar</span> 
                </a>
            </li>
            <li>
                <a href="#employee">
                    <i class="fa fa-user"></i> <span>Employee</span> 
                </a>
            </li>
            <li>
                <a href="#authority">
                    <i class="fa fa-group"></i> <span>Authorities</span> 
                </a>
            </li>
            <li>
                <a href="#company">
                    <i class="fa fa-star-o"></i> <span>Company</span> 
                </a>
            </li>
            <li>
                <a href="#company">
                    <i class="fa fa-bars"></i> <span>Department</span> 
                </a>
            </li>
            <li>
                <a href="#report">
                    <i class="fa fa-line-chart"></i> <span>Report</span> 
                </a>
            </li>
            <li>
                <a href="#company">
                    <i class="fa fa-file"></i> <span>File</span> 
                </a>
            </li>
            <li>
                <a href="#company">
                    <i class="fa fa-cc-mastercard"></i> <span>Invoice</span> 
                </a>
            </li>
            <li>
                <a href="<?php echo Url::to('index/logout') ?>">
                    <i class="fa fa-sign-out"></i> <span> Logout</span> 
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
