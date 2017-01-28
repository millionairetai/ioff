<?php

use yii\helpers\Url;
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="#activity/all">
                    <i class="fa fa-thumbs-up"></i> <span>{{$root.$lang.activity}}</span> 
                </a>
            </li>
            <li>
                <a href="#project">
                    <i class="fa fa-bullhorn"></i> <span>{{$root.$lang.annoucement}}</span> 
                </a>
            </li>
            <li>
                <a href="#project">
                    <i class="fa fa-asterisk"></i> <span>{{$root.$lang.requestment}}</span> 
                </a>
            </li>
            <li>
                <a href="#project">
                    <i class="fa fa-th"></i> <span>{{$root.$lang.project}}</span> 
                </a>
            </li>
            <li>
                <a href="#task">
                    <i class="fa fa-tasks"></i> <span>{{$root.$lang.task}}</span> 
                </a>
            </li>
            <li>
                <a href="#calendar">
                    <i class="fa fa-calendar"></i> <span>{{$root.$lang.calendar_title}}</span> 
                </a>
            </li>
            <li>
                <a href="#employee">
                    <i class="fa fa-user"></i> <span>{{$root.$lang.employee}}</span> 
                </a>
            </li>
            <li ng-show="$root.auth.authority.index || $root.auth.is_admin">
                <a href="#authority">
                    <i class="fa fa-group"></i> <span>{{$root.$lang.authority}}</span> 
                </a>
            </li>
            <li>
                <a href="#company">
                    <i class="fa fa-star-o"></i> <span>{{$root.$lang.company}}</span> 
                </a>
            </li>
            <li>
                <a href="#department">
                    <i class="fa fa-bars"></i> <span>{{$root.$lang.department}}</span> 
                </a>
            </li>
            <li>
                <a href="#report">
                    <i class="fa fa-line-chart"></i> <span>{{$root.$lang.report}}</span> 
                </a>
            </li>
            <li ng-show="$root.auth.requestment_category.index || $root.auth.is_admin">
                <a href="#requestmentCategory">
                    <i class="fa fa-spinner"></i> <span>{{$root.$lang.requestment_category}}</span> 
                </a>
            </li>
            <li>
                <a href="#company">
                    <i class="fa fa-file"></i> <span>{{$root.$lang.file}}</span> 
                </a>
            </li>
            <li>
                <a href="#company">
                    <i class="fa fa-cc-mastercard"></i> <span>{{$root.$lang.invoice}}</span> 
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
