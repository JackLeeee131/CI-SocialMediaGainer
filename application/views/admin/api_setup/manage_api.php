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
                API & Key
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">API & Key</li>
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
                        <div class="box-header with-border">
                            <h3 class="box-title">Update API Setup</h3>
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


                        <?php $attributes = array('class' => 'form-horizontal', 'id' => 'api_setup');
                        echo form_open('admin/api_setup/update_api_setup', $attributes); ?>



                            <div class="box-body">

                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Likes Service Id</label>
                                    <div class="col-sm-2">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['likes_service_id'];} ?>" class="form-control" name="likes_service_id" placeholder="Likes ID">
                                    </div>

                                    <label for="" class="col-sm-3 control-label">Views Service Id</label>
                                    <div class="col-sm-2">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['views_service_id'];} ?>" class="form-control" name="views_service_id" placeholder="Views ID">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">Comments Service Id</label>
                                    <div class="col-sm-2">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['comments_service_id'];} ?>" class="form-control" name="comments_service_id" placeholder="Comments ID">
                                    </div>

                                    <label for="" class="col-sm-3 control-label">Followers Service Id</label>
                                    <div class="col-sm-2">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['followers_service_id'];} ?>" class="form-control" name="followers_service_id" placeholder="Followers ID">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">API Key</label>
                                    <div class="col-sm-7">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['api_key'];} ?>" class="form-control" name="api_key" placeholder="API KEY">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-3 control-label">API Url</label>
                                    <div class="col-sm-7">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['api_url'];} ?>" class="form-control" name="api_url" placeholder="API URL">
                                    </div>
                                </div>



                                <div class="form-group box-header with-border">
                                    <label for="" class="col-sm-3 control-label">Likes :</label>

                                    <div class="col-sm-3">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['likes_min'];} ?>" class="form-control" name="likes_min" placeholder="Minimum Can Order" >
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['likes_max'];} ?>" class="form-control" name="likes_max" placeholder="Maximum Can Order">
                                    </div>
                                </div>

                                <div class="form-group box-header with-border">
                                    <label for="" class="col-sm-3 control-label">Views :</label>

                                    <div class="col-sm-3">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['views_min'];} ?>" class="form-control" name="views_min" placeholder="Minimum Can Order" >
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['views_max'];} ?>" class="form-control" name="views_max" placeholder="Maximum Can Order">
                                    </div>
                                </div>

                                <div class="form-group box-header with-border">
                                    <label for="" class="col-sm-3 control-label">Comments :</label>

                                    <div class="col-sm-3">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['comments_min'];} ?>" class="form-control" name="comments_min" placeholder="Minimum Can Order" >
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['comments_max'];} ?>" class="form-control" name="comments_max" placeholder="Maximum Can Order">
                                    </div>
                                </div>

                                <div class="form-group box-header with-border">
                                    <label for="" class="col-sm-3 control-label">Followers :</label>

                                    <div class="col-sm-3">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['followers_min'];} ?>" class="form-control" name="followers_min" placeholder="Minimum Can Order" >
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" value="<?php if(!empty($api_detail[0])){echo $api_detail[0]['followers_max'];} ?>" class="form-control" name="followers_max" placeholder="Maximum Can Order">
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
