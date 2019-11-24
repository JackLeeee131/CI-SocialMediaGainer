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
                Dripfeed Setup
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
                            <h3 class="box-title">Add Dripfeed Info</h3>
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

                        <?php $attributes = array('class' => 'form-horizontal', 'id' => 'dripfeed_setup');
                        echo form_open('admin/dripfeed/add_dripfeed', $attributes); ?>

                            <div class="box-body">



                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Dripfeed For</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="dripfeed_for" required onchange="show_dripfeed_run(this.value)">
                                            <option value=""> Dripfeed For </option>
                                            <option value="packages"> Likes / Views </option>
                                            <option value="followers"> One Time Order Followers </option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group" id="package_dropdown" style="display:">
                                    <label for="" class="col-sm-3 control-label">Dripfeed Runs</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="dripfeed_run">
                                            <option value=""> Select Dripfeed Run</option>
                                            <option value="2"> 2 </option>
                                            <option value="3"> 3 </option>
                                            <option value="4"> 4 </option>
                                            <option value="5"> 5 </option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group" id="followers_dropdown" style="display: none">
                                    <label for="" class="col-sm-3 control-label">Days</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="dripfeed_run_follower">
                                            <option value=""> Select No of Days </option>
                                            <option value="2"> 2 Days </option>
                                            <option value="3"> 3 Days</option>
                                            <option value="4"> 4 Days </option>
                                            <option value="5"> 5 Days </option>
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Dripfeed Price</label>
                                    <div class="col-sm-6">
                                      <input type="text" name="dripfeed_price" class="form-control" placeholder="Dripfeed Price" required>
                                    </div>
                                </div>

                            </div>



                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="submit" class="btn btn-info pull-right" value="Save">
                            </div>
                            <!-- /.box-footer -->
                        <?php echo form_close(); ?>
                    </div>
                    <!-- /.box -->

                </div>
                <!-- right column -->
                <div class="col-md-2"> </div>

            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Dripfeed List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            <table class="table table-bordered table-hover">


                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="text-align: center">Dripfeed For</th>
                                    <th style="text-align: center">Dripfeed Runs</th>
                                    <th>Dripfeed Price</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>



                                <?php  $i = 1; foreach($dripfeed_detail as $dripfeed) { ?>

                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td align="center"><?php if(!empty($dripfeed['dripfeed_for']) && $dripfeed['dripfeed_for'] == 'packages') {echo 'Likes / Views';} else { echo 'One Time order Followers';}  ?></td>
                                        <td align="center"><?php echo $dripfeed['dripfeed_run']; ?></td>
                                        <td><?php echo $dripfeed['dripfeed_price']; ?></td>
                                        <td><a href="<?php echo base_url().'admin/dripfeed/update_dripfeed/'.$dripfeed['dripfeed_id']; ?>"> Edit </a> </td>
                                        <td><a href="<?php echo base_url().'admin/dripfeed/delete_dripfeed/'.$dripfeed['dripfeed_id']; ?>"> Delete </a> </td>
                                    </tr>

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
<script>
    function show_dripfeed_run(target) {
        //alert(st);attendance_leave

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
