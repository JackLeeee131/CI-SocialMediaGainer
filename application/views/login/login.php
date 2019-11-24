<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $page_name = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $get_titles = $this->common_model->get_table_data('tbl_website_keywords', '*', array('page_name' => $page_name));
    ?>

    <title> <?php if (!empty($get_titles[0]['page_title'])) {
            echo trim($get_titles[0]['page_title']);
        } else {
            echo 'Login to Social Media Gainer';
        } ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php if (!empty($get_titles[0]['keyword_description'])) {
        echo $get_titles[0]['keyword_description'];
    } else {
        echo $page_name . ' - Social Media Gainer';
    } ?>"/>
    <meta name="keywords" content="<?php if (!empty($get_titles[0]['keywords'])) {
        echo $get_titles[0]['keywords'];
    } else {
        echo $page_name . ' - Social Media Gainer';
    } ?>"/>

    <meta name="Subject" content="Social Media Gainer">
    <meta name="copyright" content="Copyright reserved and all that stuff">
    <meta name="language" content="English">


    <link href="<?php echo base_url(); ?>frontend_assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fontawesome CSS -->
    <link href="<?php echo base_url(); ?>frontend_assets/assets/css/font-awesome.min.css" rel="stylesheet">


    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>frontend_assets/assets/js/morris.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
    <script src="<?php echo base_url(); ?>frontend_assets/assets/js/example.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frontend_assets/assets/css/example.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frontend_assets/assets/css/morris.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/square/blue.css">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>frontend_assets/assets/css/sb-admin.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>frontend_assets/assets/css/custom.css" rel="stylesheet">
    <link rel='stylesheet prefetch' href='https://daneden.github.io/animate.css/animate.min.css'>


</head>


<body style="overflow: auto; height: 100%; background: rgb(31, 44, 54);">


<div class="container">


    <div class="" align="center" style="display: block;">
            <span class="front_logo_login"><img src="<?php echo base_url(); ?>assets/img/gainer-sign-in-logo.png"

                                                alt="Instagram Login" class="front_logo"/> Social Media Gainer</span>
    </div>


    <div id="LoginDiv" style="display: block;">


        <?php $attributes = array('class' => 'form-signin centered', 'id' => 'login_form');

        echo form_open('login/userlogin', $attributes); ?>


        <h2 class="form-signin-heading">Sign in</h2>


        <?php if ($this->session->flashdata('error_message')) { ?>

            <div class="alert alert-danger ">

                <button class="close" data-close="alert"></button>

                <span><?php echo $this->session->flashdata('error_message'); ?></span>

            </div>

        <?php } ?>

        <?php if ($this->session->flashdata('success_message')) { ?>

            <div class="alert alert-success">

                <button class="close" data-close="alert"></button>

                <span><?php echo $this->session->flashdata('success_message'); ?></span>

            </div>

        <?php } ?>


        <label for="inputEmail" class="sr-only">Email address</label>

        <input type="email" name="email" id="inputEmail" class="form-control control" placeholder="Email" required

               autocomplete="off">


        <label for="inputPassword" class="sr-only">Password</label>

        <input type="password" name="password" id="inputPassword" class="form-control control" placeholder="Password"

               required autocomplete="off">


        <!--            <div class="checkbox pull-left">

                        <label>

                            <input type="checkbox" value="remember-me"> Remember me

                        </label>

                    </div>-->


        <div class="pull-right">

            <a class="forget-password" onclick="authAjax('forgot')" style="cursor: pointer">Forgot Password


                <?php

                // $ref =  $this->input->get('ref', TRUE);

                // echo substr($aa, strrpos($aa, '-') + 1)

                ?>


            </a>

        </div>


        <div class="clearfix"></div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in to My Account</button>

        <p>Don't have an account yet ? <a onclick="authAjax('register')">Register </a></p>


        <?php echo form_close(); ?>


    </div><!-- / sign in -->


    <div id="RegisterDiv" style="display: none;">

        <?php $attributes = array('class' => 'form-signin centered', 'id' => 'reg_form');

        echo form_open('login/register', $attributes); ?>


        <h2 class="form-signin-heading">Register</h2>


        <input type="hidden" name="ref_id"

               value="<?php echo substr($this->input->get('ref', TRUE), strrpos($this->input->get('ref', TRUE), '-') + 1) ?>">


        <label for="inputEmail" class="sr-only">Username (optional)</label>

        <input type="text" name="reg_username" id="inputEmail" class="form-control control" placeholder="Username"

               required autofocus>


        <label for="inputEmail" class="sr-only">Email</label>

        <input type="email" name="reg_email" id="inputEmail" class="form-control control" placeholder="Email" required

               autofocus>


        <label for="inputPassword" class="sr-only">Password</label>

        <input type="password" minlength="6" name="reg_password" id="password" class="form-control control"

               placeholder="Password" required>


        <label for="inputPassword" class="sr-only">Confirm Password</label>

        <input type="password" minlength="6" name="reg_confirm_password" id="confirm_password"
               class="form-control control"

               placeholder="Confirm Password" required>


        <span id='pass_validate' style=" font-size: 14px; float: right"></span>


        <div class="checkbox pull-left">

            <label>

                <input type="checkbox" name="terms" id="terms" value="yes"> I Agree to the <a href="<?php echo base_url();?>welcome/terms"> Terms and

                    Conditions </a>

            </label>

        </div><!-- / check box



            <div class="pull-right">

                <a href="#" class="forget-password">

                    Re-Send Activation

                </a>

            </div><!-- / forget password-->


        <div class="clearfix"></div>

        <button class="btn btn-lg btn-primary btn-block" type="submit" id="reg_button">Register a New Account</button>

        <p>Already have an account? <a onclick="authAjax('login')">Sign in</a></p>

        <?php echo form_close(); ?>

    </div><!-- / register -->


</div> <!-- /container -->


<script>


    $(document).ready(function () {

        // on form submit

        $("#reg_form").on('submit', function () {

            // to each unchecked checkbox

            if ($('#terms').is(':checked') && $('#password').val() == $('#confirm_password').val()) {

                return true;

            } else {

                if (!$('#terms').is(':checked')) {

                    alert("You must accept the terms and conditions!");

                } else {

                    $('#pass_validate').html('Password Not Matching').css('color', 'red');

                }

                return false;

            }


        })

    });


    $('#password, #confirm_password').on('keyup', function () {

        if ($('#password').val() == $('#confirm_password').val()) {

            $('#pass_validate').html('Matching').css('color', 'green');

        } else

            $('#pass_validate').html('Password Not Matching').css('color', 'red');

    });


</script>


<div class="form-signin white rounded centered form" id="ForgotDiv" style="display:none">


    <h2 class="form-signin-heading">Forgot Password</h2>


    <div id="ForgotPwForm_errors"></div>

    <div id="ForgotPwForm_loading" style="display: none; text-align: center; margin-bottom: 15px;">

    </div>


    <?php $attributes = array('class' => '', 'id' => 'ForgotPwForm');

    echo form_open('login/forgot_password', $attributes); ?>


    <label for="inputPassword" class="sr-only">Password</label>

    <input type="email" name="email" id="email" class="form-control control" autocomplete="off"

           placeholder="Registration Email" required>


    <input type="submit" class="btn btn-lg btn-primary btn-block" id="ForgotPwForm_submit" name="ForgotPwForm_submit"

           value="Submit">

    <?php echo form_close(); ?>


    <p class="txt-center" style="margin-top: 0px;">Remember your password?

        <a onclick="authAjax('login')">Go Back</a>

    </p>

</div>


<div class="form-signin white rounded centered form" id="update_passwordDiv" style="display:none">

    <h2 class="form-signin-heading">Update Password</h2>


    <div id="ForgotPwForm_errors"></div>

    <div id="ForgotPwForm_loading" style="display: none; text-align: center; margin-bottom: 15px;">

    </div>


    <?php $attributes = array('class' => '', 'id' => 'ForgotPwForm');

    echo form_open('login/update_password', $attributes); ?>


    <!--<input type="hidden" name="email" class="form-control control" placeholder="New emaillll"

           value='<?php /*echo $email; */?>'>-->


    <label for="inputPassword" class="sr-only">New Password</label>

    <input type="password" minlength="6" name="password" id="inputPassword" class="form-control control"

           placeholder="New Password" required>


    <label for="inputPassword" class="sr-only">Confirm Password</label>

    <input type="password" minlength="6" name="confirm_password" id="inputPassword" class="form-control control"

           placeholder="Confirm Password" required>


    <input type="submit" class="btn btn-lg btn-primary btn-block" id="ForgotPwForm_submit" name="ForgotPwForm_submit"

           value="Update">

    <?php echo form_close(); ?>


    <p class="txt-center" style="margin-top: 0px;">Remember your password?

        <a onclick="authAjax('login')">Go Back</a>

    </p>

</div>


<script type="text/javascript" src="<?php echo base_url(); ?>frontend_assets/assets/js/jquery.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>frontend_assets/assets/js/drop-down.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>frontend_assets/assets/js/custom.js"></script>


<?php if ($this->session->flashdata('signup')) { ?>

    <script>

        authAjax('register');

    </script>

<?php } ?>





<?php if ($this->session->flashdata('update_password')) { ?>

    <script>

        authAjax('update_password');

    </script>

<?php } ?>



<?php

$ref = $this->input->get('ref', TRUE);

if (!empty($ref)) { ?>

    <script>

        authAjax('register');

    </script>

<?php } ?>


</body>


</html>


