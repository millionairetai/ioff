<?php

$this->title = 'Thống kê công ty';

$this->registerJs('if (document.getElementById("companyReportChart")) {
    var confixbarChart = {
        type: \'bar\',
        data: {
            labels: ' . $report['chart']['labels'] . ',
            datasets: [
                {
                    label: "Số công ty",
                    backgroundColor: "#00a65a",
                    data: ' . $report['chart']['data'] . '
                }
            ]
        },
        options: {
            scales: {
                xAxes: [{
                        barThickness: 20
                    }],
                yAxes: [{
                        ticks: {
                            max: 100,
                            min: 0,
                            stepSize: 10
                        }
                    }]
            },
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
        }
    };
    var ctxbarChart = document.getElementById("companyReportChart").getContext("2d");
    var myBarChart = new Chart(ctxbarChart, confixbarChart);
}
');
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Báo cáo công ty</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
<!--                    <form role="form" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6 text-right">
                                <select>
                                    <option>Today</option>
                                    <option>This week</option>
                                    <option>This month</option>
                                    <option>This year</option>
                                </select>
                            </div>
                            <div class=" col-sm-3">
                                Package:
                                <select>
                                    <option>Standard</option>
                                    <option>advance</option>
                                </select>
                            </div>
                        </div>
                    </form>-->
                    <div class="row">
                        <div class="col-md-5">
                            <h4>Thống kê theo từng loại:</h4>
                            <h5><?= $report['company']['total_company'] ?> công ty</h5>
                            <ul>
                                <li>Gói free: <?= $report['company']['total_free_company'] ?> công ty</li>
                                <li>Gói standard: <?= $report['company']['total_standard_company'] ?> công ty</li>
                                <li>Gói premium: <?= $report['company']['total_premium_company'] ?> công ty</li>
                            </ul>
                        </div>

                        <div class="col-md-7">
                            <h4>Dung lượng lưu trữ</h4>
                            <p><?= $report['company']['total_used_storage'] ?> MB / <?= $report['company']['total_disk'] ?> MB</p>
                            <table>
                                <tr>
                                    <td>
                                        <input type="text" class="knob" value="<?= $report['company']['percent_used_storage'] ?>" data-width="150" data-height="150" data-skin="tron" data-thickness=.2 data-fgColor="#3c8dbc">
                                    </td>
                                    <td>
                                        <p><b>Database: <?= $report['company']['used_storage_database'] ?> MB</b></p>
                                        <p><b>File: <?= $report['company']['used_storage_file'] ?> MB</b></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <p class="text-center">
                        <strong>Thống kê số lượng công ty theo tháng</strong>
                    </p>
                    <canvas id="companyReportChart"></canvas>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <!--        <div class="col-md-4 padding-left-md-0">
                    <div class="box box-widget">
                        <div class="box-header with-border">
                            <h3 class="box-title">New company</h3>
        
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                             /.box-tools 
                        </div>
                         /.box-header 
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                <li class="item">
                                    <div class="item-info">
                                        <h4 class="item-title">iCare company</h4>
                                        <span class="item-description">
                                            register D package
                                        </span>
                                        <span class="item-price"> 3,000,000 VND</span>
                                        <small>5 hours 30 minutes before</small>
                                    </div>
                                </li>
                                 /.item 
                                <li class="item">
                                    <div class="item-info">
                                        <h4 class="item-title">iCare company</h4>
                                        <span class="item-description">
                                            register D package
                                        </span>
                                        <span class="item-price"> 3,000,000 VND</span>
                                        <small>5 hours 30 minutes before</small>
                                    </div>
                                </li>
                                 /.item 
                                <li class="item">
                                    <div class="item-info">
                                        <h4 class="item-title">iCare company</h4>
                                        <span class="item-description">
                                            register D package
                                        </span>
                                        <span class="item-price"> 3,000,000 VND</span>
                                        <small>5 hours 30 minutes before</small>
                                    </div>
                                </li>
                                 /.item 
                            </ul>
                        </div>
                        <div class="box-footer text-center">
                            <a href="javascript:void(0)" class="uppercase">View All</a>
                        </div>
                    </div>
                    <div class="box box-widget">
                        <div class="box-header with-border">
                            <h3 class="box-title">Duedate company</h3>
        
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                             /.box-tools 
                        </div>
                         /.box-header 
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                <li class="item">
                                    <div class="item-info">
                                        <h4 class="item-title">iCare company</h4>
                                        <span class="item-description">
                                            register D package
                                        </span>
                                        <span class="item-price"> 3,000,000 VND</span>
                                        <small>5 hours 30 minutes before</small>
                                    </div>
                                </li>
                                 /.item 
                                <li class="item">
                                    <div class="item-info">
                                        <h4 class="item-title">iCare company</h4>
                                        <span class="item-description">
                                            register D package
                                        </span>
                                        <span class="item-price"> 3,000,000 VND</span>
                                        <small>5 hours 30 minutes before</small>
                                    </div>
                                </li>
                                 /.item 
                                <li class="item">
                                    <div class="item-info">
                                        <h4 class="item-title">iCare company</h4>
                                        <span class="item-description">
                                            register D package
                                        </span>
                                        <span class="item-price"> 3,000,000 VND</span>
                                        <small>5 hours 30 minutes before</small>
                                    </div>
                                </li>
                                 /.item 
                            </ul>
                        </div>
                        <div class="box-footer text-center">
                            <a href="javascript:void(0)" class="uppercase">View All</a>
                        </div>
                    </div>
                </div>-->
    </div>
</section>