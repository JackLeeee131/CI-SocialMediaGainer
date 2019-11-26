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
                Account Status
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Account Status</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="alert-success" style="display: none; padding: 10px;" id="funds_msg">
                <button class="close" data-close="alert"></button>
                <span>Funds Added Successfully</span>
            </div>
            <?php if($this->session->flashdata('error_message')){ ?>
                <div class="alert alert-danger">
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

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">User Accounts List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body ">
                            <table class="table table-bordered table-hover">


                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Referral %</th>
                                    <th>Money Spent</th>
                                    <th>Current Balance</th>
                                    <th>Add Funds</th>
                                    <th>Update Funds</th>
                                    <th>Status</th>
                                </tr>

                                <?php  $i = 1; foreach($accounts_list as $account) { ?>



                                   <?php $money_spent = $this->common_model->get_money_spent($account['user_id']); ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $account['username']; ?></td>
                                    <td><?php echo $account['email']; ?></td>

                                    <td class="col-sm-1">
                                        <input type="text" value="<?php if(!empty($account['referral'])) { echo $account['referral']; } else { echo '20';} ?>" onblur="update_referral(this.value,<?php echo $account['id']; ?>)" class="form-control">
                                    </td>

                                    <td><?php echo number_format($money_spent[0]['total_amount'], 2); ?></td>
                                    <td><?php echo $account['current_balance']; ?></td>

                                        <td class="col-sm-1">
                                        <input type="text" value="<?php echo $account['account_funds']; ?>" onblur="add_funds(this.value,<?php echo $account['id']; ?>)" class="form-control">
                                        </td>

                                    <td><a href="<?php echo base_url().'admin/user_accounts/update_funds/'.$account['id'];?>">Update Funds</a> </td>
                                    <td><a href="<?php echo base_url().'admin/user_accounts/update_status/'.$account['id'];?>" title="Change Status ( You can't be able to view the Banned users! )"  ><?php echo $account['status']; ?></a> </td>
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

    function add_funds(funds, id) {
        if(funds != '' && !(isNaN(funds))) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/user_accounts/add_funds",
                async: false,
                data: {user_id: id, funds: funds},
                success: function (output) {
                    // $('#funds_msg').css('display', 'block');
                }
            });
        }
    }

    function update_referral(referral, id) {
        if(referral != '' && !(isNaN(referral))) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/user_accounts/update_referral",
                async: false,
                data: {user_id: id, referral: referral},
                success: function (output) {
                    // $('#funds_msg').css('display', 'block');
                }
            });
        }
    }

</script>



<script src="<?php echo base_url();?>assets/jquery.js"></script>
<script src="<?php echo base_url();?>assets/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/validate_forms.js"></script>
</body>
</html>
