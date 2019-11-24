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
                Dripfeed Info Setup
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dripfeed Info</li>
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
                            <h3 class="box-title">Edit Dripfeed Info</h3>
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
                        echo form_open('admin/dripfeed/update_dripfeed', $attributes); ?>
                                        <input type="hidden" name="dripfeed_id" value="<?php if(!empty($edit_dripfeed[0])){echo $edit_dripfeed[0]['dripfeed_id'];} ?>">


                        <div class="box-body">

                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Dripfeed For</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="dripfeed_for" id="dripfeed_for" required onchange="show_dripfeed_run(this.value)">
                                        <option value=""> Dripfeed For </option>
                                        <option value="packages" <?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_for'] == 'packages'){echo 'selected';} ?>> Likes / Views </option>
                                        <option value="followers" <?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_for'] == 'followers'){echo 'selected';} ?>> One Time Order Followers </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="package_dropdown" style="display: ">
                                <label for="" class="col-sm-3 control-label">Dripfeed Runs</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="dripfeed_run" required onchange="show_dripfeed_run(this.value)">
                                        <option value=""> Select Dripfeed Run</option>
                                        <option value="2"<?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '2'){echo 'selected';} ?>> 2 </option>
                                        <option value="3"<?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '3'){echo 'selected';} ?>> 3 </option>
                                        <option value="4"<?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '4'){echo 'selected';} ?>> 4 </option>
                                        <option value="5"<?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '5'){echo 'selected';} ?>> 5 </option>
                                        <option value="6"<?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '6'){echo 'selected';} ?>> 6 </option>
                                        <option value="7"<?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '7'){echo 'selected';} ?>> 7 </option>
                                    </select>
                                </div>
                            </div>




                            <div class="form-group" id="followers_dropdown" style="display: none">
                                <label for="" class="col-sm-3 control-label">Days</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="dripfeed_run_follower">
                                        <option value=""> Select No of Days </option>
                                        <option value="2" <?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '2'){echo 'selected';} ?>> 2 Days </option>
                                        <option value="3" <?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '3'){echo 'selected';} ?>> 3 Days</option>
                                        <option value="4" <?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '4'){echo 'selected';} ?>> 4 Days </option>
                                        <option value="5" <?php if(!empty($edit_dripfeed[0]) && $edit_dripfeed[0]['dripfeed_run'] == '5'){echo 'selected';} ?>> 5 Days </option>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Dripfeed Price</label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php if(!empty($edit_dripfeed[0]['dripfeed_price'])){echo $edit_dripfeed[0]['dripfeed_price'];} ?>" name="dripfeed_price" class="form-control" placeholder="Dripfeed Price" required>
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
<script>


    $(document).ready(function () {
        var dripfeed_for = $('#dripfeed_for').val();
        if(dripfeed_for == "followers") {

            $('#package_dropdown').css("display", "none");
            $('#followers_dropdown').css("display", "block");
        }

    });
    function show_dripfeed_run(target) {
        if (target == "followers") {
            $('#package_dropdown').css("display", "none");
            $('#followers_dropdown').css("display", "block");
        } else {
            $('#followers_dropdown').css("display", "none");
            $('#package_dropdown').css("display", "block");

        }
    }
</script>
</body>
</html>
