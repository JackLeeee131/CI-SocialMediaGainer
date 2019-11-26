<!DOCTYPE html>
<html>
<head>

</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Track One Time order
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Payment Info</li>
            </ol>
        </section>
        <br>
        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Packages List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            <table class="table table-bordered table-hover">

                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Transaction Id</th>
                                    <th>User Name</th>
                                    <th> Email</th>
                                    <th>Order Name</th>
                                    <th>Order Quantity</th>
                                    <th>Order Price</th>
                                    <th>Payment Date</th>
                                    <th>Order Status</th>

                                </tr>


                                <?php  $i = 1; foreach($past_orders_detail as $custom_order) {   //echo '<pre>'; print_r($custom_order); echo '</pre>';?>


                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php if(!empty($custom_order['txn_id'])) { echo $custom_order['txn_id']; } else { echo 'N/A'; } ?></td>
                                        <td><?php echo $custom_order['username']; ?></td>
                                        <td><?php echo $custom_order['email']; ?></td>
                                        <td><?php echo $custom_order['package_name']; ?></td>
                                        <td><?php echo $custom_order['total_order_qty']; ?></td>
                                        <td><?php echo '$'.$custom_order['order_price']; ?></td>
                                        <td><?php echo $custom_order['payment_date']; ?></td>
                                        <td><?php echo $custom_order['order_status']; ?></td>

                                    </tr>

                                <?php } ?>
                                <?php if(count($past_orders_detail) == 0) { ?>

                                    <tr><td colspan="7" style="text-align: center; color: #ff0002"> <b> No Order Found </b></td></tr>

                                <?php } ?>

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>



<script src="<?php echo base_url();?>assets/jquery.js"></script>
<script src="<?php echo base_url();?>assets/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/validate_forms.js"></script>
</body>
</html>
