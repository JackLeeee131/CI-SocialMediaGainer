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
                Packages
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Sub Packages</li>
            </ol>
        </section>

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
                            <h3 class="box-title">Add Sub Packages</h3>
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


                        <?php $attributes = array('class' => 'form-horizontal', 'id' => 'package');
                        echo form_open('admin/sub_packages/add_sub_package', $attributes); ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"> Main Package</label>

                                <div class="col-sm-8">
                                    <select class="form-control" name="package_id" onchange="view_package_detail(this.value)">
                                        <option value="">Select Package</option>
                                        <?php  foreach($packages_list as $package) { ?>
                                            <option value="<?php echo $package['package_id']; ?>"><?php echo $package['package_name'] . ' (' . $package['package_description'] . ' )'; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="display: none" id="likes">
                                <label for="" class="col-sm-3 control-label">Likes</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="likes" placeholder="Likes">
                                </div>

                            </div>

                            <div class="form-group" style="display: none" id="views">
                                <label for="" class="col-sm-3 control-label">Views</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="views" placeholder="Views">
                                </div>
                                <div class="col-sm-4">
                                    <input type="hidden" class="form-control" name="views_per_post" placeholder="Per Post">
                                </div>
                            </div>

                            <div class="form-group" style="display: none" id="comments">
                                <label for="" class="col-sm-3 control-label">Comments</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="comments" placeholder="Comments">
                                </div>
                                <div class="col-sm-4">
                                    <input type="hidden" class="form-control" name="comments_per_post" placeholder="Per Post">
                                </div>
                            </div>

                            <div class="form-group" style="display: none" id="per_post">
                                <label for="" class="col-sm-3 control-label">Per Post</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="likes_per_post" placeholder="Likes / Views / Comments Per Post">
                                </div>
                            </div>


                            <div class="form-group" style="display: none" id="followers">
                                <label for="" class="col-sm-3 control-label">Followers</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="followers" placeholder="Followers">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="followers_per_day" placeholder="PER DAY ( API Minimum )">
                                </div>
                            </div>


                            <div class="form-group" style="display: none" id="price">
                                <label for="" class="col-sm-3 control-label">Price</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="price" placeholder="Price">
                                </div>
                            </div>

                            <div class="form-group" style="display: none" id="special_id">
                                <label for="" class="col-sm-3 control-label">Special ID</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="special_order_id" placeholder="Special Order ID">
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Add Sub Package</button>
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
                            <h3 class="box-title">Sub Packages List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Package Name</th>
                                    <th>Likes</th>
                                    <th>Views</th>
                                    <th>Comments</th>
                                    <th>Followers</th>
                                    <th>Price</th>
                                    <th>Special Order ID</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>

                                <?php  $i = 1; foreach($sub_packages_list as $sub_package) { ?>


                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $sub_package['package_name'] . ' (' . $sub_package['package_description'] .' )'; ?></td>
                                        <td><?php if($sub_package['likes'] != 0) {echo $sub_package['likes'];} else { echo '';} ?></td>
                                        <td><?php echo $sub_package['views']; ?></td>
                                        <td><?php if($sub_package['comments'] != 0) {echo $sub_package['comments'];} else { echo '';} ?></td>
                                        <td><?php if($sub_package['followers'] != 0) {echo $sub_package['followers'];} else { echo '';} ?></td>
                                        <td><?php echo $sub_package['price']; ?></td>
                                        <td><?php echo $sub_package['special_id']; ?></td>
                                        <td><a href="<?php echo base_url().'admin/sub_packages/update_sub_package/'.$sub_package['sub_package_id']; ?>"> Edit </a> </td>
                                        <td><a href="<?php echo base_url().'admin/sub_packages/delete_sub_package/'.$sub_package['sub_package_id']; ?>"> Delete </a> </td>
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


<script type="text/javascript" >
    function view_package_detail(package_id){
        //alert(st);attendance_leave

        if(package_id=="1"){
            $('#likes').css("display", "block");
            $('#views').css("display", "block");
            $('#per_post').css("display", "block");
            $('#comments').css("display", "none");
            $('#followers').css("display", "none");
            $('#price').css("display", "block");
        }else if(package_id=="2"){
            $('#likes').css("display", "block");
            $('#views').css("display", "block");
            $('#comments').css("display", "block");
            $('#per_post').css("display", "block");
            $('#followers').css("display", "none");
            $('#price').css("display", "block");
        }else if(package_id=="3"){
            $('#likes').css("display", "block");
            $('#followers').css("display", "block");
            $('#views').css("display", "block");
            $('#comments').css("display", "none");
            $('#per_post').css("display", "block");
            $('#price').css("display", "block");
        }else if(package_id=="4"){
            $('#likes').css("display", "block");
            $('#views').css("display", "block");
            $('#comments').css("display", "block");
            $('#per_post').css("display", "block");

            $('#followers').css("display", "block");
            $('#price').css("display", "block");
        } else if(package_id=="5"){
            $('#likes').css("display", "block");
            $('#views').css("display", "block");
            $('#comments').css("display", "block");
            $('#per_post').css("display", "block");

            $('#followers').css("display", "block");
            $('#special_id').css("display", "block");
            $('#price').css("display", "block");
        }
    }
</script>



<script src="<?php echo base_url();?>assets/jquery.js"></script>
<script src="<?php echo base_url();?>assets/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/validate_forms.js"></script>
</body>
</html>
