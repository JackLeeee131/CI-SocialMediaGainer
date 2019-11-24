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
                Payment Info Setup
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

                <!-- left column -->
                <div class="col-md-2"> </div>
                <!-- center column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Payment Info</h3>
                        </div>


                        <!-- /.box-header -->
                        <!-- form start -->

                        <?php if($this->session->flashdata('error_message')){ ?>
                            <div class="alert alert-danger ">
                                <button class="close" data-close="alert"></button>
                                <span><?php echo $this->session->flashdata('error_message'); ?></span>
                            </div>
                        <?php }?>
                        <?php if($this->session->flashdata('success_message')){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-close="alert"></button>
                                <span><?php echo $this->session->flashdata('success_message'); ?></span>
                            </div>
                        <?php }?>

                        <?php $attributes = array('class' => 'form-horizontal', 'id' => 'payment_setup');
                        echo form_open('admin/payment_setup/update_payment', $attributes); ?>
                                        <input type="hidden" name="payment_id" value="<?php if(!empty($edit_payment[0])){echo $edit_payment[0]['payment_id'];} ?>">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Payment Method</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="payment_method" disabled>
                                            <option value=""> Select Payment Method</option>
                                            <option value="Paypal" <?php if(!empty($edit_payment[0]) && $edit_payment[0]['payment_method'] == 'Paypal'){echo 'selected';} ?>>Paypal</option>
                                            <option value="CoinPayment" <?php if(!empty($edit_payment[0]) && $edit_payment[0]['payment_method'] == 'CoinPayment'){echo 'selected';} ?>>Coinpayments</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Minimum Amount</label>
                                    <div class="col-sm-6">
                                        <input type="text" value="<?php if(!empty($edit_payment[0])){echo $edit_payment[0]['minimum_amount'];} ?>" class="form-control" name="amount" placeholder="Amount">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-6">
                                        <input type="email" value="<?php if(!empty($edit_payment[0])){echo $edit_payment[0]['payment_email'];} ?>" class="form-control" name="email" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Message</label>
                                    <div class="col-sm-6">
                                       <textarea class="form-control" name="message"><?php if(!empty($edit_payment[0])){echo $edit_payment[0]['message'];}?></textarea>
                                    </div>
                                </div>

                            </div>



                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" class="btn btn-info pull-right" value="Update">
                            </div>
                            <!-- /.box-footer -->
                        <?php echo form_close(); ?>
                    </div>
                    <!-- /.box -->

                </div>
                <!-- right column -->
                <div class="col-md-2"> </div>

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
