<!DOCTYPE html>
<html>
<head></head>


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
                                            <option value=""> Select Dripfeed Target</option>
                                            <option value="packages"> Packages </option>
                                            <option value="likes_views"> Custom one time Likes + Views </option>
                                            <option value="followers"> Custom one time Followers </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="dripfeed_runs" style="display: none">
                                    <label for="" class="col-sm-3 control-label">Dripfeed Runs</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="dripfeed_run">
                                            <option value=""> Select Dripfeed Run time</option>
                                            <option value="2"> 2 </option>
                                            <option value="3"> 3 </option>
                                            <option value="4"> 4 </option>
                                            <option value="5"> 5 </option>
                                            <option value="6"> 6 </option>
                                            <option value="7"> 7 </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Dripfeed Interval</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="dripfeed_interval" required>
                                            <option value=""> Select Dripfeed Interval</option>
                                            <option value="5"> 5 </option>
                                            <option value="10"> 10 </option>
                                            <option value="15"> 15 </option>
                                            <option value="20"> 20 </option>
                                            <option value="30"> 30 </option>
                                            <option value="50"> 50 </option>
                                            <option value="60"> 60 </option>

                                            <option value="12 hours"> 12 Hours </option>
                                            <option value="24 hours"> 24 Hours </option>
                                            <option value="2 days"> 2 Days </option>
                                            <option value="3 days"> 3 Days </option>
                                            <option value="4 days"> 4 Days </option>
                                            <option value="5 days"> 5 Days </option>
                                            <option value="6 days"> 6 Days </option>
                                            <option value="7 days"> 7 Days </option>
                                            <option value="8 days"> 8 Days </option>
                                            <option value="9 days"> 9 Days </option>
                                            <option value="10 days"> 10 Days </option>
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
                            <h3 class="box-title">Packages List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            <table class="table table-bordered table-hover">


                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Dripfeed For</th>
                                    <th>Dripfeed Run Time</th>
                                    <th>Dripfeed Interval</th>
                                    <th>Dripfeed Price</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>



                                <?php  $i = 1; foreach($dripfeed_detail as $dripfeed) { ?>


                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $dripfeed['dripfeed_for']; ?></td>
                                        <td><?php echo $dripfeed['dripfeed_run']; ?></td>
                                        <td><?php echo $dripfeed['dripfeed_interval']; ?></td>
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

        if (target == "packages") {
            $('#dripfeed_runs').css("display", "block");
        } else {
            $('#dripfeed_runs').css("display", "none");
        }
    }
</script>
</body>
</html>
