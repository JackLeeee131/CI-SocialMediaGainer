

<body>

<div class="container-fluid">

    <div class="row">


        <main role="main" class="right-section">



            <h1 class="heading">Manage Account</h1>



            <section class="row placeholders">



                <div class="col-lg-6 col-sm-10 offset-lg-3 offset-sm-1">



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





                    <div class="boxstyle">



                        <?php $attributes = array('class' => '', 'id' => 'manage_account');

                        echo form_open('settings/update_user', $attributes); ?>



                        <input type="hidden" name="user_id" value="<?php if(!empty($user_detail[0]['user_id'])) {echo $user_detail[0]['user_id'];} ?>">

                        <div class="form-group">

                            <label for="exampleInputEmail1">Name</label>

                            <input type="text" name="username" value="<?php if(!empty($user_detail[0]['username'])) {echo $user_detail[0]['username'];} ?>" class="form-control" id="" aria-describedby="emailHelp" placeholder="User Name" required>

                        </div>

                        <div class="form-group">

                            <label for="exampleInputEmail1">Email</label>

                            <input type="email" name="email" value="<?php if(!empty($user_detail[0]['email'])) {echo $user_detail[0]['email'];} ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" required>

                        </div>

                        <!--

                        <div class="form-group">

                            <label for="exampleInputEmail1">Skype</label>

                            <input type="text" name="skype" value="<?php /*if(!empty($user_detail[0]['skype'])) {echo $user_detail[0]['skype'];} */?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" required>

                        </div>-->


                        <br>

                        <div class="form-group">

                            <h4 for="exampleInputPassword1">Change Password</h4>
                            <hr />

                        </div>

                        <div class="form-group">

                            <label for="exampleInputPassword1">New Password</label>

                            <input type="password" name="new_password" class="form-control" id="exampleInputPassword2" placeholder="New Password">

                        </div>

                        <div class="form-group">

                            <label for="exampleInputPassword1">Confirm New Password</label>

                            <input type="password" name="confirm_password" class="form-control" id="exampleInputPassword3" placeholder="Confirm Password">

                        </div>

                        <button type="submit" class="btn btn-primary full-width">Save</button>

                        <?php echo form_close(); ?>

                        <div class="clearfix"></div>

                    </div>

                </div>

            </section>

        </main>

    </div>

</div>

<script>

    $(document).ready(function(){

        $('.heading').css('right', 'calc(50% - 204px)');

    });

</script>

</body>

</html>

