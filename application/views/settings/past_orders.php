



<body>



















<div class="container-fluid">

    <div class="row">





        <main role="main" class="right-section">



            <h1 class="heading">Past Orders</h1>



            <section class="row placeholders">























                <div class="col-lg-12 col-sm-12">





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



                        <div class="box-body table-responsive">

                            <table class="table table-bordered table-hover">





                                <tr>

                                    <th style="width: 10px">#</th>

                                    <th>Order Name</th>

                                    <th>Order Price</th>

                                    <th>Order Quantity</th>

                                    <th>Instagram URL</th>

                                    <th>Payment Date</th>

                                    <th>Order Status</th>



                                </tr>







                                <?php  $i = 1; foreach($past_orders_detail as $custom_order) { ?>





                                    <tr>

                                        <td><?php echo $i++; ?></td>

                                        <td><?php echo $custom_order['package_name']; ?></td>

                                        <td><?php echo '$'.$custom_order['order_price']; ?></td>

                                        <td><?php echo $custom_order['total_order_qty']; ?></td>

                                        <td><?php echo $custom_order['instagram_url']; ?></td>

                                        <td><?php echo date('d-m-Y H:i:s', strtotime($custom_order['payment_date'])); ?></td>

                                        <td><?php echo $custom_order['order_status']; ?></td>



                                    </tr>





                                <?php } ?>

                                <?php if(count($past_orders_detail) == 0) { ?>



                                    <tr><td colspan="7" style="text-align: center; color: #ff0002"> <b> No Order Found </b></td></tr>



                                <?php } ?>



                            </table>

                        </div>



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

        $('.heading').css('right', 'calc(50% - 204px)');

    });

</script>





</body>

</html>

