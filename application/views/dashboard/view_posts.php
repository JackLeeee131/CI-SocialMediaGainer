<style>

    .title_size {
        font-size: 15px;
    }

    /* The container */
    .container {
        display: inline;
        position: relative;
        padding-left: 30px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 14px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 21px;
        width: 21px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after {
        top: 7px;
        left: 7px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: white;
    }
</style>

<body>


<div class="container-fluid">
    <div class="row">

        <main role="main" class="right-section">

            <h1 class="heading">View Posts</h1>

            <?php if ($this->session->flashdata('message_name')) { ?>
                <div class="alert alert-danger ">
                    <button class="close" data-close="alert"></button>
                    <span><?php echo $this->session->flashdata('message_name'); ?></span>
                </div>
            <?php } ?>


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


            <section class="row text-center placeholders">
                <?php
                $order_id = $insta_account[0]['order_id'];
                $order_status = $insta_account[0]['order_status'];
                $sub_package_detail = $this->common_model->get_table_data('tbl_sub_packages', '*', array('status' => 'Active', 'sub_package_id' => $insta_account[0]['tbl_subpkg_id']));
                $count_posts = $sub_package_detail[0]['likes_per_post'];

                for ($i = 1; $i <= $count_posts; $i++) {
                    $post_detail = $this->common_model->get_table_data('tbl_posts', '*', array('tbl_order_id' => $order_id, 'post_no' => $i), $row = 1);
                    ?>


                    <!-- edit featured posts -->
                    <div class="modal fade" id="edit_post_model_<?php echo $i; ?>" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="max-width: 600px !important;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: #ff0002" id="exampleModalLabel"> Edit
                                        Post </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                            id="close_poup_<?php echo $i; ?>">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php $attributes = array('class' => '', 'id' => 'update_post_' . $i, 'name' => 'update_post_' . $i);
                                echo form_open('accounts/update_post', $attributes); ?>

                                <input type="hidden" name="pkg_id"
                                       value="<?php echo $insta_account[0]['tbl_pkg_id']; ?>">
                                <input type="hidden" name="subpkg_id"
                                       value="<?php echo $insta_account[0]['tbl_subpkg_id']; ?>">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                <input type="hidden" name="post_no" value="<?php echo $i; ?>">


                                <div class="modal-body">


                                    <?php //echo '<pre>'; print_r($post_detail); echo '</pre>'; ?>


                                    <?php if (!empty($sub_package_detail[0]['likes'])) { ?>
                                        <div class="form-row align-items-center">
                                            <div class="col-lg-3 col-sm-3">
                                                <label class="title_size">Likes</label>
                                            </div>
                                            <div class="col-lg-2 col-sm-2">
                                                <input type="text"
                                                       value="<?php if (!empty($post_detail[0]['post_likes'])) {
                                                           echo $post_detail[0]['post_likes'];
                                                       } else {
                                                           echo $sub_package_detail[0]['likes'];
                                                       } ?>" name="likes" class="form-control mb-2"
                                                       id="like_field_<?php echo $i; ?>" placeholder="Likes">
                                            </div>

                                            <div class="col-lg-6 col-sm-6">
                                                <label><span
                                                            style="color: #ff0002; font-weight: bold"><?php echo $sub_package_detail[0]['likes']; ?> </span>
                                                    &nbsp;Max Likes as per the package</label>
                                            </div>
                                        </div>
                                    <?php } ?>




                                    <?php if (!empty($sub_package_detail[0]['views'])) { ?>
                                        <div class="form-row align-items-center">
                                            <div class="col-lg-3 col-sm-3">
                                                <label class="title_size">Views</label>
                                            </div>
                                            <div class="col-lg-2 col-sm-2">
                                                <input type="text"
                                                       value="<?php if (!empty($post_detail[0]['post_views'])) {
                                                           echo $post_detail[0]['post_views'];
                                                       } else {
                                                           echo $sub_package_detail[0]['views'];
                                                       } ?>" name="views" class="form-control mb-2"
                                                       id="inlineFormInput" placeholder="Views">
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <label><span
                                                            style="color: #ff0002; font-weight: bold"><?php echo $sub_package_detail[0]['views']; ?> </span>
                                                    &nbsp;Max Views as per the package</label>
                                            </div>
                                        </div>
                                    <?php } ?>








                                    <?php if (!empty($sub_package_detail[0]['comments'])) { ?>


                                        <div class="form-row align-items-center">


                                            <div class="col-lg-3 col-sm-3">
                                                <label class="title_size" style="padding-top: 5px">Comments</label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9" style="text-align: left; font-size: 14px">

                                                <label class="container">Admin Random List
                                                    <input value="default_comments"
                                                           class="comments_type_<?php echo $i; ?>" type="radio"
                                                           name="comments_type" id="comments_type" checked>
                                                    <span class="checkmark"></span>
                                                </label>

                                                <label class="container">Custom Comments
                                                    <input value="custom_comments"
                                                           class="comments_type_<?php echo $i; ?>" type="radio"
                                                           name="comments_type"
                                                           <?php if ($post_detail[0]['comments_type'] == 'custom_comments') { ?>checked <?php } ?>>
                                                    <span class="checkmark"></span>
                                                </label>


                                            </div>


                                            <!--  <div class="col-lg-5 col-sm-5">
    <label><span
    style="color: #ff0002; font-weight: bold"><?php /*echo $comments_remaining; */ ?> </span>
    Comments Remaining</label>
    </div>-->
                                        </div>


                                        <br>

                                        <div id="comments_error_<?php echo $i; ?>"
                                             style="display: none; color: #ff0002">
                                            <div class="form-row align-items-center">
                                                <?php
                                                $count_comments = $this->common_model->get_table_data('tbl_api_setup', '*', 'api_id=1', $row = 1);
                                                $comments_min = $count_comments[0]['comments_min'];
                                                ?>
                                                <div class="col-lg-8 col-sm-8">Minimum comments should be
                                                    <b><?php echo $comments_min; ?></b></div>
                                            </div>
                                            <br><br>
                                        </div>


                                        <div id="comments_box_<?php echo $i; ?>" style="display: none ">


                                            <div id="show_comment_list_<?php echo $i; ?>">


                                                <?php
                                                $replace_comments = str_replace("<br/>", ',', $post_detail[0]['comments_list']);
                                                $arr_comments = explode(',', $replace_comments);

                                                ?>

                                                <?php for ($count = 0; $count <= $sub_package_detail[0]['comments'] - 1; $count++) { ?>

                                                    <div class="form-row align-items-center" style="margin-top: 5px">
                                                        <div class="col-lg-3 col-sm-3"> <?php echo $count + 1; ?> </div>
                                                        <div class="col-lg-6 col-sm-6">
                                                            <input name="comment_list[]" type="text"
                                                                   class="form-control comments_box_custom_<?php echo $i; ?>"
                                                                   value="<?php if ($post_detail[0]['comments_type'] == 'custom_comments') {
                                                                       echo $arr_comments[$count];
                                                                   }; ?>">
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                            </div>
                                            <br>
                                        </div>


                                    <?php } ?>


                                    <script>


                                        <?php if($post_detail[0]['comments_type'] == 'custom_comments') { ?>
                                        $('#comments_box_<?php echo $i; ?>').css('display', 'block');
                                        <?php } ?>


                                        $('.comments_type_<?php echo $i; ?>').change(function () {
                                            if (this.value == 'custom_comments') {
                                                $('#comments_box_<?php echo $i; ?>').css('display', 'block');
                                                $('.comments_box_custom_<?php echo $i; ?>').prop('required', true);
                                            } else if (this.value == 'default_comments') {
                                                $('#comments_box_<?php echo $i; ?>').css('display', 'none');
                                                $('.comments_box_custom_<?php echo $i; ?>').prop('required', false);
                                            }
                                        });


                                        /*    function comment_list_post //  //echo $i; ?>(comment_ordered, order_id) {
                                            if (comment_ordered != '' && !(isNaN(comment_ordered))) {
                                            $.ajax({
                                            type: "POST",
                                            url: " //// echo base_url();?>dashboard/get_comment_list",
                                            async: false,
                                            data: {
                                            comment_ordered: comment_ordered,
                                            order_id: order_id
                                            },
                                            success: function (output) {

                                            if (comment_ordered == "") {
                                            $('#update_btn_/ //echo $i; ?>').prop('disabled', false);
                                            $('#comments_error_/ echo $i; ?>').css('display', 'none');
                                            } else {
                                            if (output == "0") {

                                            $('#update_btn_ echo $i; ?>').prop('disabled', true);
                                            $('#comments_box echo $i; ?>').css('display', 'none');
                                            $('#comments_error echo $i; ?>').css('display', 'block');
                                            } else {

                                            $('#update_btn echo $i; ?>').prop('disabled', false);
                                            $('#comments_error echo $i; ?>').css('display', 'none');
                                            $('#comments_box echo $i; ?>').css('display', 'block');
                                            $('#show_comment_list echo $i; ?>').html(output);

                                            $('.comments_box').each(function () {
                                            $sibling = // find a sibling to $this.
                                            $mainElement = $(this); // memorize $(this)
                                            $sibling.change(function ($mainElement) {
                                            return function () {
                                            if (this.value.indexOf('@') >= 1 || this.value.indexOf('@') == 0) {
                                            alert("Mentions or @usernames are not allowed");
                                            $(this).css('border', '2px solid red');
                                            $(':input[type="submit"]').prop('disabled', true);
                                            return false;
                                            } else {
                                            $(':input[type="submit"]').prop('disabled', false);
                                            $(this).css('border', '1px solid #ced4da');
                                            }
                                            }
                                            }($mainElement))
                                            });
                                            }
                                            }
                                            }
                                            });
                                            }
                                            }*/


                                        $('.comments_box_custom_<?php echo $i; ?>').each(function () {
                                            $sibling = // find a sibling to $this.
                                                $mainElement = $(this); // memorize $(this)
                                            $sibling.change(function ($mainElement) {
                                                return function () {


                                                    if (this.value.indexOf('@') >= 1 || this.value.indexOf('@') == 0) {
                                                        alert("Mentions or @usernames are not allowed");
                                                        $(this).css('border', '2px solid red');
                                                        $(':input[type="submit"]').prop('disabled', true);
                                                        return false;
                                                    } else {
                                                        $(':input[type="submit"]').prop('disabled', false);
                                                        $(this).css('border', '1px solid #ced4da');
                                                    }
                                                }
                                            }($mainElement))
                                        });


                                    </script>


                                </div>
                                <div class="modal-footer">
                                    <input type="submit" value="Update" class="btn btn-primary"
                                           id="update_btn_<?php echo $i; ?>">
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>


                    <script>
                        $('#update_post_<?php echo $i; ?>').submit(function () {
                            var res = true;
                            $(".comments_box_custom_<?php echo $i; ?>").each(function () {
                                if ($(this).val().indexOf('@') >= 1 || $(this).val().indexOf('@') == 0) {
                                    res = false;
                                }
                            });
                            return res;
                        });
                    </script>


                    <div class="col-lg-2">
                        <div class='package-box animated swing'>
                            <div class="body-content">
                                Post #<?php echo $i ?>
                            </div>


                            <?php if ($order_status == 'Done' || !empty($post_detail[0]['post_status']) && $post_detail[0]['post_status'] == 'Done') { ?>
                                <a href="#" class="edit-btn" style="padding:1px; border-radius: 0px 0px 10px 10px;">Completed</a>
                            <?php } else { ?>
                                <a href="#" class="edit-btn edit-btn-posts" data-toggle="modal"
                                   style="padding:2px; "
                                   data-target="#edit_post_model_<?php echo $i; ?>"
                                   id="edit_post_btn_<?php echo $i; ?>">Edit</a>
                            <?php } ?>


                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <script>
                        $("#edit_post_btn_<?php echo $i; ?>").click(function () {
                            $('#update_post_<?php echo $i; ?>').trigger("reset");
                        });
                    </script>

                <?php } ?>


                <div class="clearfix"></div>
            </section>


        </main>


    </div>
</div>


</body>
</html>
