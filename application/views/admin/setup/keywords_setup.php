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
               Website Keywords Setup
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Website Keywords</li>
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
                        echo form_open('admin/setup/update_keywords', $attributes); ?>


                            <div class="box-body">

                                <div class="form-group box-header">
                                    <label for="" class="col-sm-4 control-label">Select Website Page :</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="keyword_id" required>
                                            <option value=""> Select Website Page</option>
                                            <?php foreach($website_keywords_detail as $keywords) { ?>
                                            <option value="<?php echo $keywords['keyword_id']; ?>" <?php if($keywords['keyword_id'] == $this->uri->segment(4)) { ?> selected <?php }?>> <?php echo $keywords['display_page_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group box-header">
                                    <label for="" class="col-sm-4 control-label">  Add Page Title :</label>
                                    <div class="col-sm-4">
                                        <?php $keyword_id = $this->uri->segment(4); ?>
                                        <input type="text" value="<?php if(!empty($keyword_id)){echo $website_keywords_detail[0]['page_title'];} ?>" class="form-control" name="page_title" placeholder="Page Title" required >
                                    </div>
                                </div>

                                <div class="form-group box-header">
                                    <label for="" class="col-sm-4 control-label">  Add Keywords :</label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control" name="keywords" required cols="1" rows="1"><?php if(!empty($keyword_id)){echo $website_keywords_detail[0]['keywords'];} ?></textarea>
                                    </div>
                                </div>


                                <div class="form-group box-header">
                                    <label for="" class="col-sm-4 control-label">  Keywords Description :</label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control" placeholder="Between 150 to 200 Characters" maxlength="200" name="keyword_description" required><?php if(!empty($keyword_id)){echo $website_keywords_detail[0]['keyword_description'];} ?></textarea>
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
            </div>



            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Pages List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            <table class="table table-bordered table-hover">


                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Page Name</th>
                                    <th> Page Title</th>
                                    <th> Keywords</th>
                                    <th> Description</th>
                                    <th>Edit</th>
                                </tr>

                                <?php  $i = 1; foreach($website_keywords_detail as $keywords) { ?>


                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $keywords['display_page_name']; ?></td>
                                        <td><?php if(!empty($keywords['page_title'])) { echo $keywords['page_title']; } else { echo 'N/A'; } ?></td>
                                        <td><?php if(!empty($keywords['keywords'])) { echo $keywords['keywords']; } else { echo 'N/A'; } ?></td>
                                        <td><?php if(!empty($keywords['keyword_description'])) { echo $keywords['keyword_description']; } else { echo 'N/A'; } ?></td>
                                        <td><a href="<?php echo base_url().'admin/setup/update_keywords/'.$keywords['keyword_id']; ?>"> Edit </a> </td>
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
