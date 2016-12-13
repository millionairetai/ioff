<header class="main-header">
    <!-- Logo -->
    <a href="/#/home" class="logo">
        <span><b>I</b>OFFICEZ</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a  class="sidebar-toggle" data-toggle="offcanvas" role="button" id="control-menu">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <!-- search form -->
        <div class="containbox-search">
            <a class="show-form-search" ng-click="displaysearch = !displaysearch" href="javascript:void(0)"><i class="fa fa-search"></i></a>
            <div class="search-form" ng-show="displaysearch">
                <form action="#/search" method="get">
                    <!-- Single button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{searchGlobalType ? searchGlobalType: $root.$lang.task}} <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a ng-click="selectSearchGlobalType($root.$lang.task, 'task')">{{$root.$lang.task}}</a></li>
                            <li><a ng-click="selectSearchGlobalType($root.$lang.project, 'project')">{{$root.$lang.project}}</a></li>
                            <li><a ng-click="selectSearchGlobalType($root.$lang.event, 'event')">{{$root.$lang.event}}</a></li>
                        </ul>
                    </div>
                    <!---->
                    <div class="input-group">
                        <autocomplete ng-model="searchVal" attr-placeholder="<?php echo \Yii::t('common', 'Search');?>" 
                                      click-activation="false" data="searchGlobalItems" on-type="getSuggestSearchGlobal" on-select="showItemSearchGlobal"></autocomplete>
                        <!--<input type="text" name="q" class="input-search form-control" placeholder="<?php echo \Yii::t('common', 'Search'); ?>...">-->
                        <a href="#/search" id="search-btn" class="btn search-button"><i class="fa fa-search"></i></a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.search form -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown messages-menu">
                    <a  class="dropdown-toggle cursor-pointer" data-toggle="dropdown" ng-click="getNotifications()">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">{{$root.sum_notify}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Bạn có {{$root.sum_notify}} thông báo</li>
                        <li>
                            <div infinite-scroll-distance="3">
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li ng-repeat="notification in notifications"><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="/flies/employee/6.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            {{notification.type}}
                                        </h4>
                                        <p ng-bind-html="getHtml(notification.content)"></p>
                                        <small style="color:#888888;"><i class="fa fa-clock-o"></i> {{notification.datetime_created*1000 | date : 'medium'}}</small>
                                    </a>
                                </li><!-- end message -->
                            </ul>
                            </div>
                        </li>
                        <li class="footer"><a href="#/notify">{{$root.$lang.see_all}}</a></li>
                    </ul>
                </li>
                
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a  class="dropdown-toggle cursor-pointer" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">32</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="img/avatar5.png" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li><!-- end message -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a class="dropdown-toggle cursor-pointer" data-toggle="dropdown" ng-click="getMyTaskDropdownClick()">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">{{myTasks.total}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Bạn có {{myTasks.total}} công việc</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu" scrolly="getMyTaskDropdownScroll()">
                                <li ng-repeat="task in myTasks.task"><!-- Task item -->
                                    <a href="#/viewTask/{{task.id}}">
                                        <h3>
                                            {{task.name}}
                                            <small class="pull-right">{{task.completed_percent}}%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: {{task.completed_percent}}%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">{{task.completed_percent}}% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#/task">{{$root.$lang.see_all}}</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a class="dropdown-toggle cursor-pointer" data-toggle="dropdown">
                        <img src="<?php echo Yii::$app->user->identity->getImage(); ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo Yii::$app->user->identity->getFullname(); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo Yii::$app->user->identity->getImage(); ?>" class="img-circle" alt="User Image">
                            <p>
                                <a style="color: white;" href="#/viewEmployee/<?php echo Yii::$app->user->identity->id; ?>"><?php echo Yii::$app->user->identity->getFullname(); ?></a>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#/viewEmployee/<?php echo Yii::$app->user->identity->id; ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="index/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
