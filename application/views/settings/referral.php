

<style>

    #disable_link{

        background: #f0f6ff

    }

</style>

<body>



<div class="container-fluid">

    <div class="row">





        <main role="main" class="right-section">



            <h1 class="heading">Referral</h1>



            <section class="row placeholders">





                <div class="col-lg-6 col-md-10 col-sm-10 offset-lg-3 offset-sm-1">





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



                        <form class="col-lg-12 col-sm-12">

                            <h3>Check out</h3>

                            <div class="form-group">

                                <label for="exampleInputEmail1">Total People Referred</label>

                                <input name="total_referral" type="text" value="<?php if(!empty($user_detail[0]['total_ref'])) {echo $user_detail[0]['total_ref']; } ?>" class="form-control" id="" aria-describedby="emailHelp" placeholder="0" disabled>

                            </div>

                            <div class="form-group">

                                <label for="exampleInputEmail1">Current Available Commission</label>

                                <input name="total_amount" type="text" value="$<?php if(!empty($account_detail[0]['available_commission'])) {echo $account_detail[0]['available_commission']; } else { echo '0.00';} ?>" disabled class="form-control" id="" aria-describedby="emailHelp" placeholder="0.00$">

                            </div>





                            <div class="">

                                <label for="exampleInputEmail1">Commission Rate: &nbsp; <b> <?php if(!empty($account_detail[0]['referral'])) {echo $account_detail[0]['referral']; } ?>% </b> </label>

                            </div>

                            <div class="">

                                <label for="exampleInputEmail1">Commission Earned to Date: &nbsp;  <b> $<?php if(!empty($account_detail[0]['total_checkout'])) {echo $account_detail[0]['total_checkout']; } else { echo '0';}?> </b> </label>

                            </div>







                            <a href="#" class="btn btn-primary full-width" data-toggle="modal" style="margin-top: 7px;" <?php if(!empty($account_detail[0]['available_commission']) && $account_detail[0]['available_commission'] > 1) {?> data-target="#checkout_model"  <?php } ?> >Check out</a>



                        </form>



                        <div class="clearfix"></div>

                    </div>

                    <br />

                    <div class="boxstyle">





                        <form class="col-lg-12 col-sm-12">


                            <h3>Customer Referral</h3>
                            <div class="form-group">

                                <label for="exampleInputEmail1">Referral Link</label>

                                <input id="content" name="referral_id" type="text" value="<?php if(!empty($user_detail[0]['referral_link'])) {echo $user_detail[0]['referral_link']; } ?>" class="form-control" readonly>

                            </div>





                            <a class="btn btn-primary full-width" data-clipboard-target="#content" href="#" onclick="copy_ref()">Copy</a>

                        </form>



                        <div class="clearfix"></div>

                    </div>



                </div>

            </section>





        </main>



        <!-- checkout Modal -->

        <div class="modal fade" id="checkout_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" style="color: #ff0002" id="exampleModalLabel"> Checkout </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_poup">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <?php $attributes = array('class' => '', 'id' => 'update_instagram_name');

                    echo form_open('settings/checkout_referral', $attributes); ?>

                    <div class="modal-body">

                        <div class="form-group">

                            <label for="exampleInputEmail1">Paypal Email Address</label>

                            <input name="paypal_email" type="email" class="form-control" id="" aria-describedby="emailHelp" placeholder="Paypal Email" required>

                        </div>

                        <div class="form-group">

                            <label for="exampleInputEmail1">Amount</label>

                            <input name="checkout_amount" type="number" class="form-control" id="" aria-describedby="emailHelp" placeholder="Amount" required>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <input type="submit" value="Submit" class="btn btn-primary" id="add_funds">

                    </div>

                    <?php echo form_close(); ?>

                </div>

            </div>

        </div>

    </div>

</div>





<script>

    function copy_ref() {

        var copyText = document.getElementById("content");

        copyText.select();

        document.execCommand("Copy");

    }

    $(document).ready(function(){

        $('.heading').css('right', 'calc(50% - 200.5px)');

    });

</script>





</body>

</html>

