
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Revenue</span>
                            <span class="info-box-number"><?= $data['total_revenue_in_month'] ?><small></small></span>
                            <span class="progress-description">
                                <?= $data['total_company'] ?> Companies
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-line-chart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Percent</span>
                            <span class="info-box-number"><?= $data['increase_percent'] ?><small></small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

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
                    <div class="clearfix">
                        <p class="text-center"><strong>Bảng thống kê</strong></p>
                        <table class="table table-striped">
                            <tbody>
                                <?php foreach ($data['invoice_each_plan_type'] as $value): ?>
                                    <tr>
                                        <td><?= $value['plan_type_name'] ?></td>
                                        <td><?= $value['total_money'] ?></td>
                                        <td><?= $value['total_company'] ?> companies</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-center"><strong>Biểu đồ</strong></p>
                    <canvas id="horizontal-chart"></canvas>
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