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
               Instagram Name Changing Setup
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Instagram Name</li>
            </ol>
        </section>
<br>
        <!-- Main content -->
        <section class="content">


            <div class="row">

                <!-- left column -->
                <div class="col-md-1"> </div>
                <!-- center column -->
                <div class="col-md-10">
                    <!-- general form elements -->
                    <div class="box box-primary">

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


                        <?php $attributes = array('class' => 'form-horizontal', 'id' => 'setup');
                        echo form_open('admin/setup/update_igName_changeSetup', $attributes); ?>


                            <div class="box-body">

                                <div class="form-group box-header">
                                    <label for="" class="col-sm-4 control-label">Maximum number to change Account :</label>
                                    <div class="col-sm-3">
                                        <input type="number" value="<?php if(!empty($ig_name_setup_detail[0])){echo $ig_name_setup_detail[0]['change_time'];} ?>" class="form-control" name="change_time" placeholder="Maximum Number" required >
                                    </div>
                                </div>

                                <div class="form-group box-header">
                                    <label for="" class="col-sm-4 control-label">Price :</label>
                                    <div class="col-sm-3">
                                        <input type="number" value="<?php if(!empty($ig_name_setup_detail[0])){echo $ig_name_setup_detail[0]['change_price'];} ?>" class="form-control" name="change_price" placeholder="Price" required step="any" >
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
                <div class="col-md-1"> </div>

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
