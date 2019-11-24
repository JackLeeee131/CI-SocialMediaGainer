



<body>

















<div class="container-fluid">

    <div class="row">





        <main role="main" class="right-section">



            <h1 class="heading">Confirm Package Order</h1>



            <section class="row text-center placeholders">



                <div class="col-lg-8 col-sm-10 offset-lg-2 offset-sm-1">



                    <div class="boxstyle">

                        <a href="<?php echo base_url().'packages/package_detail/'.$package_data['sub_package_id'];?>" class="btn btn-outline-secondary pull-left"><i class="fa fa-angle-double-left"></i> Back</a>









                        <a href="<?php echo base_url().'packages/confirmed_pay/'.$package_data['sub_package_id'].'/'.$order_id;?>" class="btn btn-success pull-right" id="confirm_link"> Confirmed & Pay <i class="fa fa-angle-double-right"></i></a>









                        <div class="clearfix"></div><hr />



                        <form>

                            <div class="form-group text-left">

                                <label for="exampleInputEmail1"><b>Instagram Name</b></label>

                                <input type="email" value="<?php echo $package_data['instagram_name']; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Please Enter Instagram Name" disabled>

                            </div>



                        </form>



                        <table class="table table-striped text-left">

                            <thead>

                            <tr>

                                <th scope="col" style="border-top:0px; padding-left:0px;">Selected Package</th>

                            </tr>

                            </thead>

                            <tbody>

                            <tr>

                                <td><?php echo $package_data['package_name'] . ' (' . $package_data['package_description'] . ' )'; ?></td>

                            </tr>



                            </tbody>

                        </table>



                        <table class="table table-striped text-left">

                            <thead>

                            <tr>

                                <th scope="col" style="border-top:0px; padding-left:0px;">Checkout Total</th>

                            </tr>

                            </thead>

                            <tbody>

                            <tr>

                                <td>$<?php echo $package_data['price']; ?></td>

                            </tr>



                            </tbody>

                        </table>

















                        <div class="clearfix"></div>

                    </div><!-- / boxstyle -->



                </div>



                <div class="clearfix"></div>

            </section>





        </main>





    </div>

</div>





<script>



    $('input:radio[name=likes_type]').change(function(){

        if (this.value == 'dripfeed') {

            $('#dripfeed_detail').css('display', 'block')

        } else if(this.value == 'instant') {

            $('#dripfeed_detail').css('display', 'none')

        }

    });



    $(document).ready(function(){

        $('.heading').css('right', 'calc(50% - 132px)');

    });



</script>





</body>

</html>

