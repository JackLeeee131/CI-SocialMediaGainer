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
                Instagram One Time Orders
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Instagram One Time Orders</li>
            </ol>
        </section>

        <!-- Main content -->
        <br>
        <section class="content">


            <div class="row">

                <div class="col-md-1"> </div>

                <!-- center column -->
                <div class="col-md-10">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Setup One Time Orders</h3>
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

                       <?php $attributes = array('class' => 'form-horizontal', 'id' => 'package_setup');
                        echo form_open('admin/package_setup/update_package_setup', $attributes); ?>

                        <div class="box-body">

                            <div class="form-group box-header with-border">
                                <label for="" class="col-sm-2 control-label">Likes:</label>

                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Min</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['likes_min_order'])) {echo $package_setup[0]['likes_min_order'];} ?>" class="form-control" name="likes_min_order" placeholder="Min can Order">
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Max</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['likes_max_order'])) {echo $package_setup[0]['likes_max_order'];} ?>" class="form-control" name="likes_max_order" placeholder="Max can Order">

                                </div>

                                <div class="col-sm-3 ">
                                    <label for="" class="col-sm-2 control-label">Price</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['likes_price'])) {echo $package_setup[0]['likes_price'];} ?>" class="form-control" name="likes_price" placeholder="Price">
                                </div>
                            </div>


                            <div class="form-group box-header with-border">
                                <label for="" class="col-sm-2 control-label">Views:</label>



                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Min</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['views_min_order'])) {echo $package_setup[0]['views_min_order'];} ?>" class="form-control" name="views_min_order" placeholder="Min can Order">
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Max</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['views_max_order'])) {echo $package_setup[0]['views_max_order'];} ?>" class="form-control" name="views_max_order" placeholder="Max can Order">

                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Price</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['views_price'])) {echo $package_setup[0]['views_price'];} ?>" class="form-control" name="views_price" placeholder="Price">
                                </div>
                            </div>


                            <div class="form-group box-header with-border">
                                <label for="" class="col-sm-2 control-label">Comments:</label>



                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Min</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['comments_min_order'])) {echo $package_setup[0]['comments_min_order']; }?>" class="form-control" name="comments_min_order" placeholder="Min can Order">
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Max</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['comments_max_order'])) {echo $package_setup[0]['comments_max_order']; } ?>" class="form-control" name="comments_max_order" placeholder="Max can Order">

                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Price</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['comments_price'])) {echo $package_setup[0]['comments_price'];} ?>" class="form-control" name="comments_price" placeholder="Price">
                                </div>
                            </div>


                            <div class="form-group box-header with-border">
                                <label for="" class="col-sm-2 control-label">Followers:</label>


                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Min</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['followers_min_order'])) {echo $package_setup[0]['followers_min_order'];} ?>" class="form-control" name="followers_min_order" placeholder="Min can Order">
                                </div>

                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Max</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['followers_max_order'])) {echo $package_setup[0]['followers_max_order'];} ?>" class="form-control" name="followers_max_order" placeholder="Max can Order">

                                </div>


                                <div class="col-sm-3">
                                    <label for="" class="col-sm-2 control-label">Price</label>
                                    <input type="text" value="<?php if(!empty($package_setup[0]['followers_price'])) {echo $package_setup[0]['followers_price'];} ?>" class="form-control" name="followers_price" placeholder="Price">
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
                <div class="col-md-1"> </div>

            </div>

            <div class="row">


                <div class="col-md-1"> </div>



                <!-- center column -->
                <div class="col-md-10">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">And Ranges</h3>
                        </div>

                        <!-- /.box-header -->
                        <!-- form start -->

                        <?php if($this->session->flashdata('error_message')){ ?>
                            <div class="alert alert-danger ">
                                <button class="close" data-close="alert"></button>
                                <span><?php echo $this->session->flashdata('error_message'); ?></span>
                            </div>
                        <?php }?>
                        <?php if($this->session->flashdata('success_message_range')){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-close="alert"></button>
                                <span><?php echo $this->session->flashdata('success_message_range'); ?></span>
                            </div>
                        <?php }?>

                        <?php $attributes = array('class' => 'form-horizontal', 'id' => 'package_setup');
                        echo form_open('admin/package_setup/add_customOrder_ranges', $attributes); ?>



                        <div class="box-body">

                            <div class="form-group box-header with-border">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Select </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="range_name" required>
                                            <option value="">Select</option>

                                            <option value="Likes">Likes</option>
                                            <option value="Views">Views</option>
                                            <option value="Comments">Comments</option>
                                            <option value="Followers">Followers</option>


                                        </select>
                                    </div>
                                </div>


                                <div class="form-group" id="likes">
                                    <label for="" class="col-sm-3 control-label">Range</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="range_from" placeholder="From" required>
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="range_to" placeholder="To" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"> Discount</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="range_discount" placeholder="Discount" required>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-info pull-right" value="Add">
                        </div>
                        <!-- /.box-footer -->
                        <?php echo form_close(); ?>
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-md-1"> </div>

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
                                    <th>Range For</th>
                                    <th>Range From</th>
                                    <th>Range To</th>
                                    <th>Discount</th>
                                    <th>Delete</th>
                                </tr>

                                <?php  $i = 1; foreach($range_setup as $range) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $range['range_name']; ?></td>
                                        <td><?php echo $range['range_from']; ?></td>
                                        <td><?php echo $range['range_to']; ?></td>
                                        <td><?php echo $range['range_discount']; ?></td>
                                        <td><a href="<?php echo base_url().'admin/package_setup/delete_customOrder_range/'.$range['range_id']; ?>"> Delete </a> </td>
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

</body>
</html>
