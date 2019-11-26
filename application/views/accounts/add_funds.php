<html>
    <body>

        <div class="container-fluid">
            <div class="row">

                <main role="main" class="right-section">

                    <h1 class="heading">Add Funds</h1>

                    <section class="row text-center placeholders">

                        <div class="col-lg-8 col-sm-10 offset-lg-2 offset-sm-1">

                            <!-- Button trigger modal -->
                            <button type="button" id="funds_error" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="display: none">
                                Add Funds
                            </button>


                            <?php if($this->session->flashdata('funds_error')){ ?>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color: #ff0002" id="exampleModalLabel">Balance Error </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_poup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        Your account balance is empty, Please add funds now!
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="cancel_funds" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" id="add_funds">Add Funds Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>



                                <?php $attributes = array('class' => '', 'id' => 'add_funds');
                                echo form_open('add_funds/add_funds', $attributes); ?>


                                <input value="<?php echo $this->uri->segment('3');?>" type="hidden" name="sub_package_id">

                                <div class="boxstyle">
                                    <br>
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


                                    <div class="form-group text-left">
                                        <label for="exampleInputEmail1">Payment Method</label>
                                        <select name="payment_id" class="form-control" required>
                                            <?php foreach($payment_list as $payment_type) { ?>
                                                <option value="<?php echo $payment_type['payment_id']; ?>"> <?php echo $payment_type['payment_method'];?> ( Minimum: <?php echo $payment_type['minimum_amount']; ?>$) </option>

                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group text-left">
                                        <label for="exampleInputEmail1">Amount</label>
                                        <input type="text" name="amount" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Amount" required>
                                    </div>

                                    <div class="clearfix"></div>

                                    <button class="btn btn-success pull-right"> Proceed <i class="fa fa-angle-double-right"></i> </button>
                                <div class="clearfix"></div>
                                    <br>

                                    <div class="form-group text-left" style="font-size: 15px; color: #ff0002">
                                        <?php if(!empty($payment_list[0]['message'])) { echo $payment_list[0]['message']; } ?>
                                    </div>

                                    <div class="form-group text-left" style="font-size: 15px; color: #ff0002">
                                        <?php if(!empty($payment_list[1]['message'])) { echo $payment_list[1]['message']; }?>
                                    </div>

                                </div><!-- / boxstyle -->

                                <?php echo form_close(); ?>

                        </div>

                        <div class="clearfix"></div>
                    </section>

                </main>

            </div>
        </div>


        <script>
            $(document).ready(function () {
                $('#funds_error').click();
                $('#cancel_funds').click(function () {
                    var base_url = '<?php echo base_url()."dashboard"; ?>';
                    window.location = base_url;
                });
                $('#close_poup').click(function () {
                    var base_url = '<?php echo base_url()."dashboard"; ?>';
                    window.location = base_url;
                })  ;
                $('#add_funds').click(function () {
                    var base_url = '<?php echo base_url()."dashboard"; ?>';
                    $('#exampleModal').modal('toggle');
                })
            });

            $(document).ready(function(){
                $('.heading').css('right', 'calc(50% - 203px)');
            });
        </script>

    </body>
</html>
