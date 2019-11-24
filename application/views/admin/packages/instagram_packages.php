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
                <li class="active">Packages</li>
            </ol>
        </section>

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
                                    <th>Package Name</th>
                                    <th>Package Description</th>
                                    <th>Package Status</th>
                                </tr>



                                <?php  $i = 1; foreach($packages_list as $package) { ?>


                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $package['package_name']; ?></td>
                                    <td><?php echo $package['package_description']; ?></td>
                                    <td><?php echo $package['package_status']; ?></td>


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
            $('#comments').css("display", "none");
            $('#followers').css("display", "none");
            $('#price').css("display", "block");
        }else if(package_id=="2"){
            $('#likes').css("display", "block");
            $('#views').css("display", "block");
            $('#comments').css("display", "block");
            $('#followers').css("display", "none");
            $('#price').css("display", "block");
        }else if(package_id=="3"){
            $('#likes').css("display", "none");
            $('#followers').css("display", "block");
            $('#views').css("display", "block");
            $('#comments').css("display", "block");
            $('#price').css("display", "block");
        }else if(package_id=="4"){
            $('#likes').css("display", "block");
            $('#views').css("display", "block");
            $('#comments').css("display", "block");
            $('#followers').css("display", "block");
            $('#price').css("display", "block");
        } else if(package_id=="5"){
            $('#likes').css("display", "block");
            $('#views').css("display", "block");
            $('#comments').css("display", "block");
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
