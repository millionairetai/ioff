<?php

$this->title = Yii::t('backend', 'Dashboard');
$message = \yii\helpers\Json::htmlEncode(
                \Yii::t('app', 'Button clicked!')
);

$this->registerJs('
    if (document.getElementById("barChart")) {
    var confixbarChart = {
        type: \'bar\',
        data: {
            labels: ' . $dashboard['revenue_per_month']['labels'] . ',
            datasets: [
               ' . $dashboard['revenue_per_month']['datasets'] . '
            ]
        },
        options: {
            scales: {
                xAxes: [{
                        barThickness: 20
                    }],
                yAxes: [{
                        ticks: {
                            max: 10000000000,
                            min: 0,
                            stepSize: 1000000000
                        }
                    }]
            },
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
        }
    };

    var ctxbarChart = document.getElementById("barChart").getContext("2d");
    var myBarChart = new Chart(ctxbarChart, confixbarChart);
}'
);

// HORIZONTAL CHART
$this->registerJs('if (document.getElementById("horizontal-chart")) {
    var config = {
        type: \'horizontalBar\',
        data: {
            labels: ' . $dashboard['staff_saling_revenue']['labels'] . ',
            datasets: [' . $dashboard['staff_saling_revenue']['datasets'] . ']
        },
        options: {
            scales: {
                yAxes: [{
                        barThickness: 20
                    }],
                xAxes: [{
                        ticks: {
                            max: 10000000000,
                            min: 0,
                            stepSize: 10000000
                        }
                    }]
            },
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
        }
    };
    var ctxhorizontalChart = document.getElementById("horizontal-chart").getContext("2d");
    var horizontalChart = new Chart(ctxhorizontalChart, config);
}');
?>
<section class="content">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-building-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Company</span>
                    <span class="info-box-number"><?= $dashboard['header']['total_new_company']; ?> company</span>
<!--                    <span class="progress-description">
                        13 free, 10 fee
                    </span>-->
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Revenue</span>
                    <span class="info-box-number"><?= $dashboard['header']['total_revenue_in_month']; ?><small></small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-line-chart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Percent</span>
                    <span class="info-box-number"><?= $dashboard['header']['increase_percent']; ?><small></small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-8">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Overview system</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" class="form-horizontal">
                        <div class="form-group">
                            <p class="col-sm-8 help-block text-right"></p>
                            <div class=" col-sm-4">
                                <select class="form-control">
                                    <option>Today</option>
                                    <option>This week</option>
                                    <option>This month</option>
                                    <option>This year</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <a class="pull-right" href="/company/report">View detail</a>
                    <h4>Used Storage</h4>
                    <p><?= $dashboard['company_overview']['total_disk']; ?>GB/ <?= $dashboard['company_overview']['used_total_storage']; ?> MB</p>
                    <div class="row">
                        <div class="col-md-7">
                            <table>
                                <tr>
                                    <td>
                                        <input type="text" class="knob" value="<?= $dashboard['company_overview']['percent_used_storage']; ?>" data-width="150" data-height="150" data-skin="tron" data-thickness=.2 data-fgColor="#3c8dbc">
                                    </td>
                                    <td>
                                        <p><b>Database: <?= $dashboard['company_overview']['used_storage_database']; ?> MB</b></p>
                                        <p><b>File: <?= $dashboard['company_overview']['used_storage_file']; ?> MB</b></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-5">
                            <h4>Companies & Users</h4>
                            <h5><?= $dashboard['company_overview']['total_company']; ?> companies</h5>
                            <ul>
                                <li><?= $dashboard['company_overview']['total_free_company']; ?> free</li>
                                <li><?= $dashboard['company_overview']['total_standard_company']; ?> standard</li>
                                <li><?= $dashboard['company_overview']['total_premium_company']; ?> premium</li>
                            </ul>
                            <b>Total: <?= $dashboard['company_overview']['total_user']; ?> users</b>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Monthly Recap Report</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" class="form-horizontal">
                        <div class="form-group">
                            <p class="col-sm-8 help-block text-right"></p>
                            <div class=" col-sm-4">
                                <select class="form-control">
                                    <option>Today</option>
                                    <option>This week</option>
                                    <option>This month</option>
                                    <option>This year</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <canvas id="barChart"></canvas>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Top saling</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" class="form-horizontal">
                        <div class="form-group">
                            <p class="col-sm-8 help-block text-right"></p>
                            <div class=" col-sm-4">
                                <select class="form-control">
                                    <option>Today</option>
                                    <option>This week</option>
                                    <option>This month</option>
                                    <option>This year</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <canvas id="horizontal-chart"></canvas>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Config system</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Name:</th>
                            <td>Centeroffice</td>
                        </tr>
                        <tr>
                            <th>Maintain mode:</th>
                            <td>FALSE</td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>

        <div class="col-md-4 padding-left-md-0">
            <?php if (!empty($dashboard['right_bar_company']['recently_company'])): ?>
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h3 class="box-title">New company</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <?php foreach ($dashboard['right_bar_company']['recently_company'] as $company): ?>
                                <li class="item">
                                    <div class="item-info">
                                        <h4 class="item-title"><?= $company['company_name'] ?></h4>
                                        <span class="item-description">
                                            <?= $company['plan_type_name'] ?> - <?= $company['company_datetime_created'] ?>
                                        </span>
                                        <!--<span class="item-price"> 3,000,000 VND</span>-->
                                        <!--<small>5 hours 30 minutes before</small>-->
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="box-footer text-center">
                        <a href="javascript:void(0)" class="uppercase">View All</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($dashboard['right_bar_company']['duedate_company'])): ?>
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <h3 class="box-title">Duedate company</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <?php foreach ($dashboard['right_bar_company']['duedate_company'] as $company): ?>
                                <li class="item">
                                    <div class="item-info">
                                        <h4 class="item-title"><?= $company['company_name'] ?></h4>
                                        <span class="item-description">
                                            <?= $company['plan_type_name'] ?> - <?= $company['expired_date'] ?>
                                        </span>
                                        <!--<span class="item-price"> 3,000,000 VND</span>-->
                                        <!--<small>5 hours 30 minutes before</small>-->
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="box-footer text-center">
                        <a href="/company/index" class="uppercase">View All</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>