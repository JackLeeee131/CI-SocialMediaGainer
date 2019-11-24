<link href="<?php echo base_url(); ?>assets/dist/css/ion.rangeSlider.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/dist/css/ion.rangeSlider.skinHTML5.css" rel="stylesheet">
<body>


<div class="container-fluid">
    <div class="row">


        <main role="main" class="right-section">

            <h1 class="heading">One Time Order</h1>

            <section class="row text-center placeholders">

                <div class="col-lg-12">

                    <div class="boxstyle-panel">

                        <div class="custom-tabs">

                            <ul class="nav nav-tabs nav-pills nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-Followers-tab" data-toggle="pill"
                                       href="#pills-Followers" role="tab" aria-controls="pills-Followers"
                                       aria-selected="true">Followers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-Likes-tab" data-toggle="pill" href="#pills-Likes"
                                       role="tab" aria-controls="pills-Likes" aria-selected="false">Likes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-Views-tab" data-toggle="pill" href="#pills-Views"
                                       role="tab" aria-controls="pills-Views" aria-selected="false">Views</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-likes_Views-tab" data-toggle="pill"
                                       href="#pills-likes_Views" role="tab" aria-controls="pills-likes_Views"
                                       aria-selected="false">Likes + Views</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-Comments-tab" data-toggle="pill"
                                       href="#pills-Comments" role="tab" aria-controls="pills-Comments"
                                       aria-selected="false">Comments</a>
                                </li>

                            </ul>


                            <div class="tab-content" id="pills-tabContent">


                                <div class="tab-pane fade show active" id="pills-Followers" role="tabpanel"
                                     aria-labelledby="pills-Followers-tab">
                                    <?php $attributes = array('class' => '', 'id' => 'custom_packages');
                                    echo form_open('custom_packages/confirm_followers_order', $attributes); ?>

                                    <input type="hidden" id="followers_price_value" name="followers_price_value"
                                           value="<?php if (!empty($range_data['followers_price'])) {
                                               echo $range_data['followers_price'];
                                           } ?>">
                                    <input type="hidden" id="followers_discount_value" name="followers_discount_value"
                                           value="<?php if (!empty($range_data['followers_discount'])) {
                                               echo $range_data['followers_discount'];
                                           } else {
                                               echo '0';
                                           } ?>">

                                    <div class="panel-header">
                                        <h4 class="pull-left">Minimum
                                            Followers <?php if (!empty($api_setup[0])) {
                                                echo $api_setup[0]['followers_min'];
                                            } ?></h4> <span id="validate_min_followers" style="color:#ff0002;"></span>
                                        <h4 class="pull-right">
                                            <span id="followers_price"
                                                  style="color: #48A44C"> $<?php if (!empty($range_data['followers_price'])) {
                                                    echo $range_data['followers_price'];
                                                } ?> </span>
                                            <span id="followers_discount"> ( <?php if (!empty($range_data['followers_discount'])) {
                                                    echo $range_data['followers_discount'];
                                                } else {
                                                    echo '0';
                                                } ?> % Discount)  </span></h4>

                                        <div class="clearfix"></div>
                                    </div>
                                    <input type="text" id="followers_range" name="followers" value=""/>


                                    <br/><br/>

                                    <div class="panel-header">

                                        <h3 class="pull-left">Instagram Profile URL</h3>
                                        <div class="form-group text-left">
                                            <input type="text" name="instagram_url" class="form-control"
                                                   id="instagram_name"
                                                   placeholder="Enter your Instagram Profile URL for Followers"
                                                   required>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <br>

                                    <div class="form-group text-left" style="margin-bottom: 10px">
                                        <label for="exampleInputEmail1">Are you want to receive the full order at
                                            once?</label>
                                    </div>

                                    <div style="padding-left: 20px">
                                        <div class="checkbox pull-left">
                                            <input value="yes" type="radio" name="followers_dripfeed"
                                                   id="followers_type" checked> Yes
                                        </div>


                                        <div class="checkbox pull-left" style="padding-left: 20px">
                                            <input value="no" type="radio" name="followers_dripfeed"
                                                   id="followers_dripfeed"> No
                                        </div>
                                    </div>


                                    <div class="form-group text-left" style="margin-bottom: 10px; display: none"
                                         id="followers_dripfeed_detail">
                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="row">


                                            <div class="col-md-2 pull-left" style="text-align: center;">
                                                <label for="exampleInputEmail1"
                                                       style="font-size: 14px; padding-top: 9px; text-align: right">

                                                    Receive Followers

                                                </label>
                                            </div>


                                            <div class="col-md-4 pull-left" style="text-align: center;">
                                                <select name="dripfeed_id" class="form-control" id="dripfeed_id_followers" onchange="validate_dripfeed_followers(this.value)">
                                                    <option value=""> Select Drip Feed Run Time</option>

                                                    <?php foreach ($dripfeed_detail_followers as $dripfeed) { ?>

                                                        <option value="<?php echo $dripfeed['dripfeed_id']; ?>"> <?php echo 'Drip Feed for ' . $dripfeed['dripfeed_run'] . ' Days + $' . $dripfeed['dripfeed_price'];; ?> </option>

                                                    <?php } ?>

                                                </select>
                                            </div>


                                        </div>
                                    </div>

                                    <script>

                                        function validate_dripfeed_followers(dripfeed_id) {
                                            var min_qty = '<?php echo $api_setup[0]['followers_min']; ?>';
                                            var post_qty = $('#followers_range').val();
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo base_url();?>custom_packages/validate_dripfeed",
                                                async: false,
                                                data: {dripfeed_id: dripfeed_id, min_qty: min_qty, post_qty: post_qty},
                                                dataType: 'json',
                                                success: function (output) {
                                                    if (output['response'] == 'error') {
                                                        $('#validate_min_followers').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty']);
                                                        $('#followers_submit_btn').prop('disabled', true);
                                                    } else {
                                                        $('#validate_min_followers').text("");
                                                        $('#followers_submit_btn').prop('disabled', false);

                                                    }
                                                }
                                            });
                                        }
                                    </script>




                                    <br>
                                    <button class="btn btn-success pull-right" id="followers_submit_btn"> Proceed <i
                                                class="fa fa-angle-double-right"></i></button>
                                    <div class="clearfix"></div>
                                    <?php echo form_close(); ?>
                                </div><!--/ tab content 1 -->





































                                <div class="tab-pane fade" id="pills-Likes" role="tabpanel"
                                     aria-labelledby="pills-Likes-tab">
                                    <?php $attributes = array('class' => '', 'id' => 'custom_packages');
                                    echo form_open('custom_packages/confirm_likes_order', $attributes); ?>

                                    <input type="hidden" id="likes_price_value" name="likes_price_value"
                                           value="<?php if (!empty($range_data['likes_price'])) {
                                               echo $range_data['likes_price'];
                                           } ?>">
                                    <input type="hidden" id="likes_discount_value" name="likes_discount_value"
                                           value="<?php if (!empty($range_data['likes_discount'])) {
                                               echo $range_data['likes_discount'];
                                           } else {
                                               echo '0';
                                           } ?>">
                                    <div class="panel-header">
                                        <h4 class="pull-left">Minimum
                                            Likes <?php if (!empty($api_setup[0])) {
                                                echo $api_setup[0]['likes_min'];
                                            } ?></h4> <span id="validate_min_likes" style="color:#ff0002;"></span>
                                        <h4 class="pull-right">
                                            <span id="likes_price"
                                                  style="color: #48A44C"> $<?php if (!empty($range_data['likes_price'])) {
                                                    echo $range_data['likes_price'];
                                                } ?> </span>
                                            <span id="likes_discount"> ( <?php if (!empty($range_data['likes_discount'])) {
                                                    echo $range_data['likes_discount'];
                                                } else {
                                                    echo '0';
                                                } ?> % Discount)  </span></h4>

                                        <div class="clearfix"></div>
                                    </div>


                                    <input type="text" id="likes_range" name="likes" value=""/>

                                    <br/><br/>
                                    <div class="panel-header">

                                        <h3 class="pull-left">Instagram Photo URL</h3>
                                        <div class="form-group text-left">
                                            <input type="text" name="instagram_url" class="form-control"
                                                   id="instagram_name"
                                                   placeholder="Enter your Instagram Photo URL for Likes" required>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <br>

                                    <div class="form-group text-left" style="margin-bottom: 10px">
                                        <label for="exampleInputEmail1">Are you want to receive the full order at
                                            once?</label>
                                    </div>

                                    <div style="padding-left: 20px">
                                        <div class="checkbox pull-left">
                                            <input value="yes" type="radio" name="likes_dripfeed" id="likes_type"
                                                   checked> Yes
                                        </div>


                                        <div class="checkbox pull-left" style="padding-left: 20px">
                                            <input value="no" type="radio" name="likes_dripfeed" id="likes_dripfeed"> No
                                        </div>
                                    </div>


                                    <div class="form-group text-left" style="margin-bottom: 10px; display: none"
                                         id="likes_dripfeed_detail">
                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="row">


                                            <div class="col-md-2 pull-left" style="text-align: center;">
                                                <label for="exampleInputEmail1"
                                                       style="font-size: 14px; padding-top: 9px; text-align: right">

                                                    Receive Likes

                                                </label>
                                            </div>


                                            <div class="col-md-4 pull-left" style="text-align: center;">
                                                <select name="dripfeed_id" id="dripfeed_id" class="form-control"
                                                        onchange="validate_dripfeed(this.value)">

                                                    <option value=""> Select Drip Feed Run Time</option>
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


                                    <script>

                                        function validate_dripfeed(dripfeed_id) {
                                            var min_qty = '<?php echo $api_setup[0]['likes_min']; ?>';
                                            var post_qty = $('#likes_range').val();
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo base_url();?>custom_packages/validate_dripfeed",
                                                async: false,
                                                data: {dripfeed_id: dripfeed_id, min_qty: min_qty, post_qty: post_qty},
                                                dataType: 'json',
                                                success: function (output) {
                                                    if (output['response'] == 'error') {
                                                        $('#validate_min_likes').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty']);
                                                        $('#likes_submit_btn').prop('disabled', true);
                                                    } else {
                                                        $('#validate_min_likes').text("");
                                                        $('#likes_submit_btn').prop('disabled', false);

                                                    }
                                                }
                                            });
                                        }
                                    </script>


                                    <br>
                                    <button class="btn btn-success pull-right" id="likes_submit_btn"> Proceed <i
                                                class="fa fa-angle-double-right"></i></button>
                                    <div class="clearfix"></div>
                                    <?php echo form_close(); ?>
                                </div><!--/ tab content 3 -->


                                <div class="tab-pane fade" id="pills-Views" role="tabpanel"
                                     aria-labelledby="ills-Views-tab">
                                    <?php $attributes = array('class' => '', 'id' => 'custom_packages');
                                    echo form_open('custom_packages/confirm_views_order', $attributes); ?>
                                    <input type="hidden" id="views_price_value" name="views_price_value"
                                           value="<?php if (!empty($range_data['views_price'])) {
                                               echo $range_data['views_price'];
                                           } ?>">
                                    <input type="hidden" id="views_discount_value" name="views_discount_value"
                                           value="<?php if (!empty($range_data['views_discount'])) {
                                               echo $range_data['views_discount'];
                                           } else {
                                               echo '0';
                                           } ?>">
                                    <div class="panel-header">
                                        <h4 class="pull-left">Minimum
                                            Views <?php if (!empty($api_setup[0])) {
                                                echo $api_setup[0]['views_min'];
                                            } ?></h4> <span id="validate_min_views" style="color:#ff0002;"></span>
                                        <h4 class="pull-right">
                                            <span id="views_price"
                                                  style="color: #48A44C"> $<?php if (!empty($range_data['views_price'])) {
                                                    echo $range_data['views_price'];
                                                } ?> </span>
                                            <span id="views_discount"> ( <?php if (!empty($range_data['views_discount'])) {
                                                    echo $range_data['views_discount'];
                                                } else {
                                                    echo '0';
                                                } ?> % Discount)  </span></h4>

                                        <div class="clearfix"></div>
                                    </div>
                                    <input type="text" id="views_range" name="views" value=""/>

                                    <br/><br/>
                                    <div class="panel-header">

                                        <h3 class="pull-left">Instagram Photo URL</h3>
                                        <div class="form-group text-left">
                                            <input type="text" name="instagram_url" class="form-control"
                                                   id="instagram_name"
                                                   placeholder="Enter your Instagram Photo URL for Likes" required>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <br>

                                    <div class="form-group text-left" style="margin-bottom: 10px">
                                        <label for="exampleInputEmail1">Are you want to receive the full order at
                                            once?</label>
                                    </div>

                                    <div style="padding-left: 20px">
                                        <div class="checkbox pull-left">
                                            <input value="yes" type="radio" name="views_dripfeed" id="views_type"
                                                   checked> Yes
                                        </div>


                                        <div class="checkbox pull-left" style="padding-left: 20px">
                                            <input value="no" type="radio" name="views_dripfeed" id="views_dripfeed"> No
                                        </div>
                                    </div>


                                    <div class="form-group text-left" style="margin-bottom: 10px; display: none"
                                         id="views_dripfeed_detail">
                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="row">


                                            <div class="col-md-2 pull-left" style="text-align: center;">
                                                <label for="exampleInputEmail1"
                                                       style="font-size: 14px; padding-top: 9px; text-align: right">

                                                    Receive Views

                                                </label>
                                            </div>


                                            <div class="col-md-4 pull-left" style="text-align: center;">
                                                <select name="dripfeed_id" id="dripfeed_id_views" class="form-control"
                                                        onchange="validate_dripfeed_views(this.value)">
                                                    <option value=""> Select Drip Feed Run Time</option>

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


                                    <script>

                                        function validate_dripfeed_views(dripfeed_id) {
                                            var min_qty = '<?php echo $api_setup[0]['views_min']; ?>';
                                            var post_qty = $('#views_range').val();
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo base_url();?>custom_packages/validate_dripfeed",
                                                async: false,
                                                data: {dripfeed_id: dripfeed_id, min_qty: min_qty, post_qty: post_qty},
                                                dataType: 'json',
                                                success: function (output) {
                                                    if (output['response'] == 'error') {
                                                        $('#validate_min_views').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty']);
                                                        $('#views_submit_btn').prop('disabled', true);
                                                    } else {
                                                        $('#validate_min_views').text("");
                                                        $('#views_submit_btn').prop('disabled', false);

                                                    }
                                                }
                                            });
                                        }
                                    </script>


                                    <br>
                                    <button class="btn btn-success pull-right" id="views_submit_btn"> Proceed <i
                                                class="fa fa-angle-double-right"></i></button>
                                    <div class="clearfix"></div>
                                    <?php echo form_close(); ?>
                                </div><!--/ tab content 3 -->


                                <div class="tab-pane fade" id="pills-likes_Views" role="tabpanel"
                                     aria-labelledby="ills-likes_Views-tab">
                                    <?php $attributes = array('class' => '', 'id' => 'custom_packages');
                                    echo form_open('custom_packages/confirm_likesViews_order', $attributes); ?>
                                    <input type="hidden" id="likes2_price_value" name="likes_price_value"
                                           value="<?php if (!empty($range_data['likes_price'])) {
                                               echo $range_data['likes_price'];
                                           } ?>">
                                    <input type="hidden" id="likes2_discount_value" name="likes_discount_value"
                                           value="<?php if (!empty($range_data['likes_discount'])) {
                                               echo $range_data['likes_discount'];
                                           } else {
                                               echo '0';
                                           } ?>">
                                    <div class="panel-header">
                                        <h4 class="pull-left">Minimum
                                            Likes <?php if (!empty($api_setup[0])) {
                                                echo $api_setup[0]['likes_min'];
                                            } ?></h4> <span id="validate_min_likes_2" style="color:#ff0002;"></span>
                                        <h4 class="pull-right">
                                            <span id="likes2_price"
                                                  style="color: #48A44C"> $<?php if (!empty($range_data['likes_price'])) {
                                                    echo $range_data['likes_price'];
                                                } ?> </span>
                                            <span id="likes2_discount"> ( <?php if (!empty($range_data['likes_discount'])) {
                                                    echo $range_data['likes_discount'];
                                                } else {
                                                    echo '0';
                                                } ?> % Discount)  </span></h4>

                                        <div class="clearfix"></div>
                                    </div>
                                    <input type="text" id="likes_2_range" name="likes" value=""/>
                                    <br/><br/>


                                    <input type="hidden" id="views2_price_value" name="views_price_value"
                                           value="<?php if (!empty($range_data['views_price'])) {
                                               echo $range_data['views_price'];
                                           } ?>">
                                    <input type="hidden" id="views2_discount_value" name="views_discount_value"
                                           value="<?php if (!empty($range_data['views_discount'])) {
                                               echo $range_data['views_discount'];
                                           } else {
                                               echo '0';
                                           } ?>">
                                    <div class="panel-header">
                                        <h4 class="pull-left">Minimum
                                            Views <?php if (!empty($api_setup[0])) {
                                                echo $api_setup[0]['views_min'];
                                            } ?></h4><span id="validate_min_views_2" style="color:#ff0002;"></span>
                                        <h4 class="pull-right">
                                            <span id="views2_price"
                                                  style="color: #48A44C"> $<?php if (!empty($range_data['views_price'])) {
                                                    echo $range_data['views_price'];
                                                } ?> </span>
                                            <span id="views2_discount"> ( <?php if (!empty($range_data['views_discount'])) {
                                                    echo $range_data['views_discount'];
                                                } else {
                                                    echo '0';
                                                } ?> % Discount)  </span></h4>

                                        <div class="clearfix"></div>
                                    </div>

                                    <input type="text" id="views_2_range" name="views" value=""/>

                                    <br/><br/>


                                    <div class="panel-header">

                                        <h3 class="pull-left">Instagram Photo URL</h3>
                                        <div class="form-group text-left">
                                            <input type="text" name="instagram_url" class="form-control"
                                                   id="instagram_name"
                                                   placeholder="Enter your Instagram Photo URL for Likes" required>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <br>

                                    <div class="form-group text-left" style="margin-bottom: 10px">
                                        <label for="exampleInputEmail1">Are you want to receive the full order at
                                            once?</label>
                                    </div>

                                    <div style="padding-left: 20px">
                                        <div class="checkbox pull-left">
                                            <input value="yes" type="radio" name="likes_views_dripfeed"
                                                   id="likes_views_type" checked> Yes
                                        </div>


                                        <div class="checkbox pull-left" style="padding-left: 20px">
                                            <input value="no" type="radio" name="likes_views_dripfeed"
                                                   id="likes_views_dripfeed"> No
                                        </div>
                                    </div>

                                    <div class="form-group text-left" style="margin-bottom: 10px; display: none"
                                         id="likes_views_dripfeed_detail">
                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="row">


                                            <div class="col-md-2 pull-left" style="text-align: center;">
                                                <label for="exampleInputEmail1"
                                                       style="font-size: 14px; padding-top: 9px; text-align: right">

                                                    Receive Likes / Views

                                                </label>
                                            </div>


                                            <div class="col-md-4 pull-left" style="text-align: center;">
                                                <select name="dripfeed_id" id="dripfeed_id_likes_views"
                                                        class="form-control"
                                                        onchange="validate_dripfeed_likes_views(this.value)">
                                                    <option value=""> Select Drip Feed Run Time</option>

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


                                    <script>
                                        function validate_dripfeed_likes_views(dripfeed_id) {
                                            var min_qty_views = '<?php echo $api_setup[0]['views_min']; ?>';
                                            var min_qty_likes = '<?php echo $api_setup[0]['likes_min']; ?>';

                                            var post_qty_views = $('#views_2_range').val();
                                            var post_qty_likes = $('#likes_2_range').val();

                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo base_url();?>custom_packages/validate_dripfeed_likes_views",
                                                async: false,
                                                data: {
                                                    dripfeed_id: dripfeed_id,
                                                    min_qty_views: min_qty_views,
                                                    min_qty_likes: min_qty_likes,
                                                    post_qty_views: post_qty_views,
                                                    post_qty_likes: post_qty_likes
                                                },
                                                dataType: 'json',
                                                success: function (output) {
                                                    if (output['response_likes_2'] == 'error' || output['response_views_2'] == 'error') {

                                                        if (output['response_views_2'] == 'error') {
                                                            $('#validate_min_views_2').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty_views_2']);

                                                        } if (output['response_likes_2'] == 'error') {
                                                            $('#validate_min_likes_2').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty_likes_2']);
                                                        }
                                                        $('#likes_views_submit_btn').prop('disabled', true);
                                                    } else {
                                                        $('#validate_min_views_2').text("");
                                                        $('#validate_min_likes_2').text("");
                                                        $('#likes_views_submit_btn').prop('disabled', false);

                                                    }
                                                }
                                            });
                                        }
                                    </script>


                                    <br>
                                    <button class="btn btn-success pull-right" id="likes_views_submit_btn"> Proceed <i
                                                class="fa fa-angle-double-right"></i></button>
                                    <div class="clearfix"></div>
                                    <?php echo form_close(); ?>
                                </div><!--/ tab content 3 -->


                                <div class="tab-pane fade" id="pills-Comments" role="tabpanel"
                                     aria-labelledby="ills-Comments-tab">
                                    <?php $attributes = array('class' => '', 'id' => 'custom_packages');
                                    echo form_open('custom_packages/confirm_comments_order', $attributes); ?>
                                    <input type="hidden" id="comments_price_value" name="comments_price_value"
                                           value="<?php if (!empty($range_data['comments_price'])) {
                                               echo $range_data['comments_price'];
                                           } ?>">
                                    <input type="hidden" id="comments_discount_value" name="comments_discount_value"
                                           value="<?php if (!empty($range_data['comments_discount'])) {
                                               echo $range_data['comments_discount'];
                                           } else {
                                               echo '0';
                                           } ?>">
                                    <div class="panel-header">
                                        <h4 class="pull-left">Minimum
                                            Comments <?php if (!empty($api_setup[0])) {
                                                echo $api_setup[0]['comments_min'];
                                            } ?></h4>
                                        <h4 class="pull-right">
                                            <span id="comments_price"
                                                  style="color: #48A44C"> $<?php if (!empty($range_data['comments_price'])) {
                                                    echo $range_data['comments_price'];
                                                } ?> </span>
                                            <span id="comments_discount"> ( <?php if (!empty($range_data['comments_discount'])) {
                                                    echo $range_data['comments_discount'];
                                                } else {
                                                    echo '0';
                                                } ?> % Discount)  </span></h4>

                                        <div class="clearfix"></div>
                                    </div>
                                    <input type="text" id="comments_range" name="comments" value=""/>

                                    <br/><br/>
                                    <div class="panel-header">

                                        <h3 class="pull-left">Instagram Photo URL</h3>
                                        <div class="form-group text-left">
                                            <input type="text" name="instagram_url" class="form-control"
                                                   id="instagram_name"
                                                   placeholder="Enter your Instagram Photo URL for Comments" required>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>


                                    <br>
                                    <button class="btn btn-success pull-right"> Proceed <i
                                                class="fa fa-angle-double-right"></i></button>
                                    <div class="clearfix"></div>
                                    <?php echo form_close(); ?>

                                </div><!--/ tab content 3 -->


                            </div>


                        </div><!--/ custom tab -->


                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>


        </main>


    </div>
</div>

<script src="<?php echo base_url(); ?>assets/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/ion.rangeSlider.min.js"></script>
<script>
    $("#followers_range").ionRangeSlider({
        min: <?php echo $api_setup[0]['followers_min']; ?>,
        max: <?php echo $custom_package_setup[0]['followers_max_order']; ?>,
        onFinish: function (data) {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "<?php echo base_url();?>custom_packages/get_followers_data",
                data: {followers_order: data['from']},
                success: function (output) {
                    $('#followers_price').text("$" + output['followers_price']);
                    $('#followers_discount').text("( " + output['followers_discount'] + "% Discount )");
                    $('#followers_price_value').val(output['followers_price']);
                    $('#followers_discount_value').val(output['followers_discount']);
                }
            });


            var min_qty = '<?php echo $api_setup[0]['followers_min']; ?>';
            var post_qty = $('#followers_range').val();
            var dripfeed_id = $('#dripfeed_id_followers').val();

            if (dripfeed_id != '') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>custom_packages/validate_dripfeed",
                    async: false,
                    data: {dripfeed_id: dripfeed_id, min_qty: min_qty, post_qty: post_qty},
                    dataType: 'json',
                    success: function (output) {
                        if (output['response'] == 'error') {
                            $('#validate_min_followers').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty']);
                            $('#followers_submit_btn').prop('disabled', true);
                        } else {
                            $('#validate_min_followers').text("");
                            $('#followers_submit_btn').prop('disabled', false);

                        }
                    }
                });
            }


        }
    });


    $("#likes_range").ionRangeSlider({
        min: <?php echo $api_setup[0]['likes_min']; ?>,
        max: <?php echo $custom_package_setup[0]['likes_max_order']; ?>,
        onFinish: function (data) {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: " <?php //  echo base_url();?>custom_packages/get_likes_data",
                data: {likes_order: data['from']},
                success: function (output) {
                    $('#likes_price').text("$" + output['likes_price']);
                    $('#likes_discount').text("( " + output['likes_discount'] + "% Discount )");
                    $('#likes_price_value').val(output['likes_price']);
                    $('#likes_discount_value').val(output['likes_discount']);
                }
            });

            var min_qty = '<?php echo $api_setup[0]['likes_min']; ?>';
            var post_qty = $('#likes_range').val();
            var dripfeed_id = $('#dripfeed_id').val();

            if (dripfeed_id != '') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>custom_packages/validate_dripfeed",
                    async: false,
                    data: {dripfeed_id: dripfeed_id, min_qty: min_qty, post_qty: post_qty},
                    dataType: 'json',
                    success: function (output) {
                        if (output['response'] == 'error') {
                            $('#validate_min_likes').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty']);
                            $('#likes_submit_btn').prop('disabled', true);
                        } else {
                            $('#validate_min_likes').text("");
                            $('#likes_submit_btn').prop('disabled', false);

                        }
                    }
                });
            }

        }
    });


    $("#views_range").ionRangeSlider({
        min: <?php echo $api_setup[0]['views_min']; ?>,
        max: <?php echo $custom_package_setup[0]['views_max_order']; ?>,
        onFinish: function (data) {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "<?php echo base_url();?>custom_packages/get_views_data",
                data: {views_order: data['from']},
                success: function (output) {
                    $('#views_price').text("$" + output['views_price']);
                    $('#views_discount').text("( " + output['views_discount'] + "% Discount )");
                    $('#views_price_value').val(output['views_price']);
                    $('#views_discount_value').val(output['views_discount']);
                }
            });

            var min_qty = '<?php echo $api_setup[0]['views_min']; ?>';
            var post_qty = $('#views_range').val();
            var dripfeed_id = $('#dripfeed_id_views').val();
            if (dripfeed_id != '') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>custom_packages/validate_dripfeed",
                    async: false,
                    data: {dripfeed_id: dripfeed_id, min_qty: min_qty, post_qty: post_qty},
                    dataType: 'json',
                    success: function (output) {
                        if (output['response'] == 'error') {
                            $('#validate_min_views').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty']);
                            $('#views_submit_btn').prop('disabled', true);
                        } else {
                            $('#validate_min_views').text("");
                            $('#views_submit_btn').prop('disabled', false);

                        }
                    }
                });
            }

        }
    });


    $("#likes_2_range").ionRangeSlider({
        min: <?php echo $api_setup[0]['likes_min']; ?>,
        max: <?php echo $custom_package_setup[0]['likes_max_order']; ?>,
        onFinish: function (data) {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "<?php echo base_url();?>custom_packages/get_likes_data",
                data: {likes_order: data['from']},
                success: function (output) {
                    $('#likes2_price').text("$" + output['likes_price']);
                    $('#likes2_discount').text("( " + output['likes_discount'] + "% Discount )");
                    $('#likes2_price_value').val(output['likes_price']);
                    $('#likes2_discount_value').val(output['likes_discount']);
                }
            });


            var min_qty = '<?php echo $api_setup[0]['likes_min']; ?>';
            var post_qty = $('#likes_2_range').val();
            var dripfeed_id = $('#dripfeed_id_likes_views').val();

            if (dripfeed_id != '') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>custom_packages/validate_dripfeed",
                    async: false,
                    data: {dripfeed_id: dripfeed_id, min_qty: min_qty, post_qty: post_qty},
                    dataType: 'json',
                    success: function (output) {
                        if (output['response'] == 'error') {
                            $('#validate_min_likes_2').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty']);
                            $('#likes_views_submit_btn').prop('disabled', true);
                        } else {
                            $('#validate_min_likes_2').text("");
                            $('#likes_views_submit_btn').prop('disabled', false);

                        }
                    }
                });
            }


        }
    });


    $("#views_2_range").ionRangeSlider({
        min: <?php echo $api_setup[0]['views_min']; ?>,
        max: <?php echo $custom_package_setup[0]['views_max_order']; ?>,
        onFinish: function (data) {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "<?php echo base_url();?>custom_packages/get_views_data",
                data: {views_order: data['from']},
                success: function (output) {
                    $('#views2_price').text("$" + output['views_price']);
                    $('#views2_discount').text("( " + output['views_discount'] + "% Discount )");
                    $('#views2_price_value').val(output['views_price']);
                    $('#views2_discount_value').val(output['views_discount']);
                }
            });


            var min_qty = '<?php echo $api_setup[0]['views_min']; ?>';
            var post_qty = $('#views_2_range').val();
            var dripfeed_id = $('#dripfeed_id_likes_views').val();
            if (dripfeed_id != '') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>custom_packages/validate_dripfeed",
                    async: false,
                    data: {dripfeed_id: dripfeed_id, min_qty: min_qty, post_qty: post_qty},
                    dataType: 'json',
                    success: function (output) {
                        if (output['response'] == 'error') {
                            $('#validate_min_views_2').text("Dripfeed will run " + output['dripfeed_run'] + " Times, So minimum quantity should be " + output['min_qty']);
                            $('#likes_views_submit_btn').prop('disabled', true);
                        } else {
                            $('#validate_min_views_2').text("");
                            $('#likes_views_submit_btn').prop('disabled', false);

                        }
                    }
                });
            }
        }
    });


    $("#comments_range").ionRangeSlider({
        min: <?php echo $api_setup[0]['comments_min']; ?>,
        max: <?php echo $custom_package_setup[0]['comments_max_order']; ?>,
        onFinish: function (data) {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "<?php echo base_url();?>custom_packages/get_comments_data",
                data: {comments_order: data['from']},
                success: function (output) {
                    $('#comments_price').text("$" + output['comments_price']);
                    $('#comments_discount').text("( " + output['comments_discount'] + "% Discount )");
                    $('#comments_price_value').val(output['comments_price']);
                    $('#comments_discount_value').val(output['comments_discount']);
                }
            });
        }
    });


    $('input:radio[name=likes_dripfeed]').change(function () {
        if (this.value == 'no') {
            $('#likes_dripfeed_detail').css('display', 'block')
        } else if (this.value == 'yes') {
            $('#likes_dripfeed_detail').css('display', 'none')
        }
    });

    $('input:radio[name=views_dripfeed]').change(function () {
        if (this.value == 'no') {
            $('#views_dripfeed_detail').css('display', 'block')
        } else if (this.value == 'yes') {
            $('#views_dripfeed_detail').css('display', 'none')
        }
    });

    $('input:radio[name=followers_dripfeed]').change(function () {
        if (this.value == 'no') {
            $('#followers_dripfeed_detail').css('display', 'block')
        } else if (this.value == 'yes') {
            $('#followers_dripfeed_detail').css('display', 'none')
        }
    });

    $('input:radio[name=likes_views_dripfeed]').change(function () {
        if (this.value == 'no') {
            $('#likes_views_dripfeed_detail').css('display', 'block')
        } else if (this.value == 'yes') {
            $('#likes_views_dripfeed_detail').css('display', 'none')
        }
    });

    $(document).ready(function () {
        $('.heading').css('right', 'calc(50% - 114px)');
    });

</script>


</body>
</html>
