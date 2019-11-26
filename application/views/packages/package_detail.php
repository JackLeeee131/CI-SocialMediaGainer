<body>


<div class="container-fluid">

    <div class="row">


        <main role="main" class="right-section">


            <h1 class="heading">Dashboard</h1>


            <section class="row text-center placeholders">


                <div class="col-lg-8 col-sm-10 offset-lg-2 offset-sm-1">


                    <?php $attributes = array('class' => '', 'id' => 'package_detail');

                    echo form_open('packages/confirm_package', $attributes); ?>


                    <input value="<?php echo $this->uri->segment('3'); ?>" type="hidden" name="sub_package_id">


                    <div class="boxstyle">


                        <a href="<?php echo base_url() . 'packages/sub_packages/' . $sub_package_detail[0]['tbl_package_id']; ?>"
                           class="btn btn-outline-secondary pull-left"><i class="fa fa-angle-double-left"></i> Back</a>


                        <!--                        <a href="#" class="btn btn-success pull-right">Proceed <i class="fa fa-angle-double-right"></i></a>-->

                        <div class="clearfix"></div>
                        <hr/>


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


                        <div class="form-group text-left">

                            <label for="exampleInputEmail1">Please Enter Instagram Name</label>

                            <input type="text" name="instagram_name" class="form-control" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="Instagram Name" required>

                        </div>


                        <?php if (!empty($sub_package_detail[0]['followers'])) { ?>

                        <?php } ?>


                        <?php // ?>


                        <table class="table text-left">

                            <thead>

                            <tr>

                                <th scope="col" style="border-top:0px;">Likes/Views</th>

                            </tr>

                            </thead>

                            <tbody>

                            <tr>

                                <td>
                                    <label>
                                        <input value="instant" type="radio" name="likes_type" id="likes_type" checked>
                                        Instant</td>
                                </label>
                            </tr>



                            <?php
                            $min_qty_likes = $api_setup[0]['likes_min'];
                            $min_qty_views = $api_setup[0]['views_min'];

                            $post_qty_likes = $sub_package_detail[0]['likes'];
                            $post_qty_views = $sub_package_detail[0]['views'];

                            $dripfeed_run = $max_dripfeed[0]['dripfeed_run'];

                            $calculate_post_likes = $post_qty_likes / $dripfeed_run;
                            $min_req_quantity_likes = $min_qty_likes * $dripfeed_run;

                            $calculate_post_views = $post_qty_views / $dripfeed_run;
                            $min_req_quantity_views = $min_qty_views * $dripfeed_run;

                            if ($calculate_post_likes >= $min_qty_likes && $calculate_post_views >= $min_qty_views) {
                                ?>

                                <tr>

                                    <td>
                                        <label>
                                            <input value="dripfeed" type="radio" name="likes_type" id="likes_dripfeed">
                                            Dripfeed
                                        </label>
                                    </td>

                                </tr>

                            <?php } ?>

                            </tbody>

                        </table>


                        <div class="clearfix"></div>




                        <div class="form-group text-left" style="margin-bottom: 10px; display:none "
                             id="dripfeed_detail">
                            <div class="row">


                                <div class="col-md-3 col-lg-2 pull-left">
                                    <label for="exampleInputEmail1" style="font-size: 14px; padding-top: 6px">

                                        Receive Likes / Views

                                    </label>
                                </div>


                                <div class="col-md-4 col-lg-5 pull-left">
                                    <select name="dripfeed_id" class="form-control">
                                        <?php foreach ($dripfeed_detail as $dripfeed) { ?>
                                            <option value="<?php echo $dripfeed['dripfeed_id']; ?>"> <?php echo $dripfeed['dripfeed_run'] . ' Times + $' . $dripfeed['dripfeed_price'];; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <span style="padding-top: 5px"> in </span>
                                <div class="col-md-4 pull-left">
                                    <select name="dripfeed_minutes" class="form-control">
                                        <option value="5"> 5 Minute Intervals</option>
                                        <option value="15"> 15 Minute Intervals</option>
                                        <option value="30"> 30 Minute Intervals</option>
                                        <option value="45"> 45 Minute Intervals</option>
                                        <option value="60"> 60 Minute Intervals</option>
                                    </select>
                                </div>


                            </div>
                        </div>


                        <div class="clearfix"></div>


                        <button class="btn btn-success pull-right"> Proceed <i class="fa fa-angle-double-right"></i>
                        </button>

                        <div class="clearfix"></div>

                    </div><!-- / boxstyle -->


                    <?php echo form_close(); ?>


                </div>


                <div class="clearfix"></div>

            </section>


        </main>


    </div>

</div>


<script>


    $('input:radio[name=likes_type]').change(function () {

        if (this.value == 'dripfeed') {

            $('#dripfeed_detail').css('display', 'block')

        } else if (this.value == 'instant') {

            $('#dripfeed_detail').css('display', 'none')

        }

    })

</script>


</body>

</html>

