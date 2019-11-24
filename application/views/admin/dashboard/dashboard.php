<!DOCTYPE html>
<html>
<head>
<style>
    .small-box .icon {
        top:7px
    }
</style>
</head>


<body class="hold-transition skin-blue sidebar-mini">





<div class="wrapper">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->




            <!-- Small boxes (Stat box) -->
            <div class="row">

                <?php if($this->session->flashdata('error_message')) { ?>
                    <div class="alert alert-danger ">
                        <button class="close" data-close="alert"></button>
                        <span><?php echo $this->session->flashdata('error_message'); ?></span>
                    </div>
                <?php } ?>
                <?php if($this->session->flashdata('success_message')) { ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button>
                        <span><?php echo $this->session->flashdata('success_message'); ?></span>
                    </div>
                <?php } ?>


                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php if(!empty($dashboard_data['total_reg_users'])) { echo $dashboard_data['total_reg_users']; } else {echo 0;} ; ?></h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php if(!empty($dashboard_data['total_accounts'])) { echo $dashboard_data['total_accounts']; } else {echo 0;} ; ?><sup style="font-size: 20px"></sup></h3>

                            <p>Active Accounts</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php if(!empty($dashboard_data['total_users_balance'])) { echo number_format($dashboard_data['total_users_balance']); } else {echo 0;} ; ?></h3>

                            <p>Total Current Balance</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-card"></i>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php if(!empty($dashboard_data['total_money_spent'])) { echo number_format($dashboard_data['total_money_spent']); } else {echo 0;} ; ?></h3>

                            <p>Money Spent</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3><?php if(!empty($dashboard_data['available_commission'])) { echo $dashboard_data['available_commission']; } else {echo 0;} ; ?></h3>

                            <p>Available Commission</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3><?php if(!empty($dashboard_data['total_checkout'])) { echo $dashboard_data['total_checkout']; } else {echo 0;} ; ?></h3>

                            <p>Commission Earned</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>

                <!-- ./col -->
            </div>







        <!--        <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">CPU Traffic</span>
                                <span class="info-box-number">90<small>%</small></span>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Likes</span>
                                <span class="info-box-number">41,410</span>
                            </div>

                        </div>

                    </div>


                    <div class="clearfix visible-sm-block"></div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Sales</span>
                                <span class="info-box-number">760</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">New Members</span>
                                <span class="info-box-number">2,000</span>
                            </div>
                        </div>
                    </div>
                </div>-->



    </section>
</div>
</div>





</body>
</html>
