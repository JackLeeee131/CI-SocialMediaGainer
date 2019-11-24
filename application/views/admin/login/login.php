<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/square/blue.css">
</head>


<body class="hold-transition login-page">






<?php echo form_open('admin/login/userlogin'); ?>

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>SocialMedia</b>Gainer</a>
        </div>

        <?php if($this->session->flashdata('message_name')){ ?>
            <div class="alert alert-danger ">
                <button class="close" data-close="alert"></button>
                <span><?php echo $this->session->flashdata('message_name'); ?></span>
            </div>
        <?php }?>


        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="User Name" name="username">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
 <!--                   <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>-->
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <input type="submit" class="btn btn-primary btn-block btn-flat" value="Sign In">
                    </div>
                    <!-- /.col -->
                </div>
                <?php echo form_close(); ?>

            <!-- /.social-auth-links -->
<!--
            <a href="#">I forgot my password</a><br>
            <a href="#" class="text-center">Register a new membership</a>-->

        </div>
        <!-- /.login-box-body -->
    </div>


    <!-- jQuery 3 -->
    <script src="<?php echo base_url(); ?>assets/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url(); ?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>



</body>
</html>


