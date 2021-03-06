

<body>

<div class="container-fluid">
    <div class="row">

        <main role="main" class="right-section">

            <h1 class="heading">View Posts</h1>

            <?php if($this->session->flashdata('message_name')){ ?>
                <div class="alert alert-danger ">
                    <button class="close" data-close="alert"></button>
                    <span><?php echo $this->session->flashdata('message_name'); ?></span>
                </div>
            <?php }?>


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

            <section class="row text-center placeholders">
                <?php
                $username =  $insta_account[0]['instagram_name'];
                //$username =  'test1';
                $order_id =  $insta_account[0]['order_id'];
                $order_date =  $insta_account[0]['payment_date'];
                $order_status =  $insta_account[0]['order_status'];
                $instagram = new \InstagramScraper\Instagram();
                $medias = $instagram->getMedias($username, 30);
                $account = $instagram->getAccount($username);
                $is_private = $account->isPrivate();
                $sub_package_detail = $this->common_model->get_table_data('tbl_sub_packages','*',array('status'=> 'Active', 'sub_package_id' => $insta_account[0]['tbl_subpkg_id']), $row=1);

                if ($is_private != 1) {

                    for ($i = 0; $i <= $sub_package_detail[0]['likes_per_post'] - 1; $i++) {
                        if (!empty($medias[$i])) {
                            $media = $medias[$i];
                        }

                        $post_id = $media->getId();
                        $post_code = $media->getShortCode();
                        $post_pic_url = $media->getImageHighResolutionUrl();
                        $likes = $media->getLikesCount();
                        $comments = $media->getCommentsCount();
                        $post_type = $media->getType();
                        $post_date = date('Y-m-d H:i:s', $media->getCreatedTime());

                        $sum_qry = $this->common_model->get_table_data('tbl_posts', 'SUM(post_likes) AS post_likes, SUM(post_views) AS post_views, SUM(post_comments) AS post_comments, SUM(post_followers) AS post_followers ', array('tbl_order_id' => $order_id), $row = 1);
                        if (!empty($sum_qry) && !empty($sub_package_detail)) {
                            if (count($sum_qry) >= 1) {
                                $likes_remaining = $sub_package_detail[0]['likes'] - $sum_qry[0]['post_likes'];
                                $views_remaining = $sub_package_detail[0]['views'] - $sum_qry[0]['post_views'];
                                $comments_remaining = $sub_package_detail[0]['comments'] - $sum_qry[0]['post_comments'];
                                $followers_remaining = $sub_package_detail[0]['followers'] - $sum_qry[0]['post_followers'];
                            } else {
                                $likes_remaining = $sub_package_detail[0]['likes'];
                                $views_remaining = $sub_package_detail[0]['views'];
                                $comments_remaining = $sub_package_detail[0]['comments'];
                                $followers_remaining = $sub_package_detail[0]['followers'];
                            }
                        }


                        if ($post_date >= $order_date) {

                            $post_detail = $this->common_model->get_table_data('tbl_posts', '*', array('tbl_order_id' => $order_id, 'post_code' => $post_code), $row = 1);
                            $this->common_model->update_table('tbl_posts', array('post_code' => $post_code, 'post_status' => 'Pending'), array('post_code' => $i + 1));

                            ?>

                            <!-- edit posts -->
                            <div class="modal fade" id="edit_post_model_<?php echo $post_code; ?>" tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document" style="max-width: 650px !important;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color: #ff0002" id="exampleModalLabel"> Edit
                                                Post </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                                    id="close_poup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <?php $attributes = array('class' => '', 'id' => 'update_post', 'name' => 'update_post');
                                        echo form_open('accounts/update_post', $attributes); ?>

                                        <input type="hidden" name="pkg_id"
                                               value="<?php echo $insta_account[0]['tbl_pkg_id']; ?>">
                                        <input type="hidden" name="subpkg_id"
                                               value="<?php echo $insta_account[0]['tbl_subpkg_id']; ?>">
                                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                        <input type="hidden" name="post_code" value="<?php echo $post_code; ?>">
                                        <input type="hidden" name="post_status" value="Pending">


                                        <div class="modal-body">

                                            <?php if (!empty($sub_package_detail[0]['likes'])) { ?>
                                                <div class="form-row align-items-center">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label>Likes</label>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3">
                                                        <input type="text"
                                                               value="<?php if (!empty($post_detail[0]['post_likes'])) {
                                                                   echo $post_detail[0]['post_likes'];
                                                               } else {
                                                                   echo $sub_package_detail[0]['likes'];
                                                               } ?>" name="likes" class="form-control mb-2"
                                                               id="inlineFormInput" placeholder="Likes">
                                                    </div>
                                                    <div class="col-lg-5 col-sm-5">
                                                        <label><span
                                                                    style="color: #ff0002; font-weight: bold"><?php echo $likes_remaining; ?> </span>
                                                            Likes Remaining</label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($sub_package_detail[0]['views'])) { ?>
                                                <div class="form-row align-items-center">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label>Views</label>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3">
                                                        <input type="text"
                                                               value="<?php if (!empty($post_detail[0]['post_views'])) {
                                                                   echo $post_detail[0]['post_views'];
                                                               } else {
                                                                   echo $sub_package_detail[0]['views'];
                                                               } ?>" name="views" class="form-control mb-2"
                                                               id="inlineFormInput" placeholder="Views">
                                                    </div>
                                                    <div class="col-lg-5 col-sm-5">
                                                        <label><span
                                                                    style="color: #ff0002; font-weight: bold"><?php echo $views_remaining; ?> </span>
                                                            Views Remaining</label>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <?php if (!empty($sub_package_detail[0]['comments'])) { ?>
                                                <div class="form-row align-items-center">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label>Comments</label>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3">
                                                        <input type="text" name="comments"
                                                               class="form-control mb-2 comments_value_<?php echo $i; ?>"
                                                               id="comments"
                                                               onblur="comment_list_post_<?php echo $post_id; ?>(this.value,<?php echo $order_id; ?>)"
                                                               placeholder="Comments">
                                                    </div>
                                                    <div class="col-lg-5 col-sm-5">
                                                        <label><span
                                                                    style="color: #ff0002; font-weight: bold"><?php echo $comments_remaining; ?> </span>
                                                            Comments Remaining</label>
                                                    </div>
                                                </div>


                                                <br>

                                                <div id="comments_error_<?php echo $post_id; ?>"
                                                     style="display: none; color: #ff0002">
                                                    <div class="form-row align-items-center">
                                                        <?php
                                                        $count_comments = $this->common_model->get_table_data('tbl_api_setup', '*', 'api_id=1', $row = 1);
                                                        $comments_min = $count_comments[0]['comments_min'];
                                                        ?>
                                                        <div class="col-lg-6 col-sm-6">Minimum comments should be
                                                            <b><?php echo $comments_min; ?></b></div>
                                                    </div>
                                                    <br><br>
                                                </div>


                                                <div id="comments_box_<?php echo $post_id; ?>" style="display: none">
                                                    <div class="form-row align-items-center">
                                                        <div class="col-lg-12 col-sm-12" align="center">
                                                            <label style="color: #ff0002"><b>Comments List</b></label>
                                                        </div>
                                                    </div>

                                                    <div id="show_comment_list_<?php echo $post_id; ?>">
                                                    </div>
                                                    <br>
                                                </div>


                                            <?php } ?>


                                            <script>
                                                function comment_list_post_<?php echo $post_id; ?>(comment_ordered, order_id) {
                                                    if (comment_ordered != '' && !(isNaN(comment_ordered))) {
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url();?>dashboard/get_comment_list",
                                                            async: false,
                                                            data: {
                                                                comment_ordered: comment_ordered,
                                                                order_id: order_id
                                                            },
                                                            success: function (output) {
                                                                if (output == "0") {
                                                                    $('#update_btn_<?php echo $post_id; ?>').prop('disabled', true);
                                                                    $('#comments_box_<?php echo $post_id; ?>').css('display', 'none');
                                                                    $('#comments_error_<?php echo $post_id; ?>').css('display', 'block');
                                                                } else {
                                                                    $('#update_btn_<?php echo $post_id; ?>').prop('disabled', false);
                                                                    $('#comments_error_<?php echo $post_id; ?>').css('display', 'none');
                                                                    $('#comments_box_<?php echo $post_id; ?>').css('display', 'block');
                                                                    $('#show_comment_list_<?php echo $post_id; ?>').html(output);

                                                                    $('.comments_box').each(function () {
                                                                        $sibling = // find a sibling to $this.
                                                                            $mainElement = $(this); // memorize $(this)
                                                                        $sibling.change(function ($mainElement) {
                                                                            return function () {
                                                                                if (this.value.indexOf('@') >= 1) {
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
                                                        });
                                                    }
                                                }
                                            </script>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="Update" class="btn btn-primary"
                                                   id="update_btn_<?php echo $post_code; ?>">
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>


                            <!-- Posts Boxes -->
                            <div class="col-lg-2">
                                <div class='package-box animated swing'
                                     <?php if ($order_status == 'Done' || !empty($post_detail[0]['post_status']) && $post_detail[0]['post_status'] == 'Done') { ?>style="border: 2px solid #ff0002 !important;" <?php } ?>>
                                    <div class="body-content">
                                        Post #<?php echo $i + 1 . $likes;  ?>

                                        <div class="clearfix"></div>
                                    </div>
                                    <?php if ($order_status == 'Done' || !empty($post_detail[0]['post_status']) && $post_detail[0]['post_status'] == 'Done') { ?>
                                        <a href="#" class="edit-btn" style="padding:1px">Completed</a>
                                    <?php } else { ?>
                                        <a href="#" class="edit-btn edit-btn-posts" data-toggle="modal"
                                           data-target="#edit_post_model_<?php echo $post_code; ?>" style="padding:2px">Edit</a>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <?php
                        } else { ?>

                            <?php
                            $post_detail = $this->common_model->get_table_data('tbl_posts', '*', array('tbl_order_id' => $order_id, 'post_code' => $i), $row = 1);
                            ?>

                            <!-- edit featured posts -->
                            <div class="modal fade" id="edit_post_model_<?php echo $i; ?>" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document" style="max-width: 650px !important;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color: #ff0002" id="exampleModalLabel"> Edit
                                                Post </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                                    id="close_poup">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <?php $attributes = array('class' => '', 'id' => 'update_post', 'name' => 'update_post');
                                        echo form_open('accounts/update_post', $attributes); ?>

                                        <input type="hidden" name="pkg_id"
                                               value="<?php echo $insta_account[0]['tbl_pkg_id']; ?>">
                                        <input type="hidden" name="subpkg_id"
                                               value="<?php echo $insta_account[0]['tbl_subpkg_id']; ?>">
                                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                        <input type="hidden" name="post_code" value="<?php echo $i; ?>">
                                        <input type="hidden" name="post_status" value="Featured">


                                        <div class="modal-body">

                                            <?php if (!empty($sub_package_detail[0]['likes'])) { ?>
                                                <div class="form-row align-items-center">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label>Likes33</label>
                                                        <?php //echo '<pre>'; print_r($post_detail); echo '</pre>'; ?>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3">
                                                        <input type="text"
                                                               value="<?php if (!empty($post_detail[0]['post_likes'])) {
                                                                   echo $post_detail[0]['post_likes'];
                                                               } else {
                                                                   echo $sub_package_detail[0]['likes'];
                                                               } ?>" name="likes" class="form-control mb-2"
                                                               id="inlineFormInput" placeholder="Likes">
                                                    </div>
                                  
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($sub_package_detail[0]['views'])) { ?>
                                                <div class="form-row align-items-center">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label>Views</label>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3">
                                                        <input type="text"
                                                               value="<?php if (!empty($post_detail[0]['post_views'])) {
                                                                   echo $post_detail[0]['post_views'];
                                                               } else {
                                                                   echo $sub_package_detail[0]['views'];
                                                               } ?>" name="views" class="form-control mb-2"
                                                               id="inlineFormInput" placeholder="Views">
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <?php if (!empty($sub_package_detail[0]['comments'])) { ?>
                                                <div class="form-row align-items-center">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label>Comments</label>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3">
                                                        <input type="text" name="comments"
                                                               class="form-control mb-2 comments_value_<?php echo $i; ?>"
                                                               id="comments"
                                                               onblur="comment_list_post_<?php echo $i; ?>(this.value,<?php echo $order_id; ?>)"
                                                               placeholder="Comments">
                                                    </div>
                                       
                                                </div>


                                                <br>

                                                <div id="comments_error_<?php echo $i; ?>"
                                                     style="display: none; color: #ff0002">
                                                    <div class="form-row align-items-center">
                                                        <?php
                                                        $count_comments = $this->common_model->get_table_data('tbl_api_setup', '*', 'api_id=1', $row = 1);
                                                        $comments_min = $count_comments[0]['comments_min'];
                                                        ?>
                                                        <div class="col-lg-6 col-sm-6">Minimum comments should be
                                                            <b><?php echo $comments_min; ?></b></div>
                                                    </div>
                                                    <br><br>
                                                </div>


                                                <div id="comments_box_<?php echo $i; ?>" style="display: none">
                                                    <div class="form-row align-items-center">
                                                        <div class="col-lg-12 col-sm-12" align="center">
                                                            <label style="color: #ff0002"><b>Comments List</b></label>
                                                        </div>
                                                    </div>

                                                    <div id="show_comment_list_<?php echo $i; ?>">
                                                    </div>
                                                    <br>
                                                </div>


                                            <?php } ?>


                                            <script>
                                                function comment_list_post_<?php echo $i; ?>(comment_ordered, order_id) {
                                                    if (comment_ordered != '' && !(isNaN(comment_ordered))) {
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url();?>dashboard/get_comment_list",
                                                            async: false,
                                                            data: {
                                                                comment_ordered: comment_ordered,
                                                                order_id: order_id
                                                            },
                                                            success: function (output) {

                                                                if (comment_ordered == "") {
                                                                    $('#update_btn_<?php echo $i; ?>').prop('disabled', false);
                                                                    $('#comments_error_<?php echo $i; ?>').css('display', 'none');
                                                                } else {
                                                                    if (output == "0") {

                                                                        $('#update_btn_<?php echo $i; ?>').prop('disabled', true);
                                                                        $('#comments_box_<?php echo $i; ?>').css('display', 'none');
                                                                        $('#comments_error_<?php echo $i; ?>').css('display', 'block');
                                                                    } else {

                                                                        $('#update_btn_<?php echo $i; ?>').prop('disabled', false);
                                                                        $('#comments_error_<?php echo $i; ?>').css('display', 'none');
                                                                        $('#comments_box_<?php echo $i; ?>').css('display', 'block');
                                                                        $('#show_comment_list_<?php echo $i; ?>').html(output);

                                                                        $('.comments_box').each(function () {
                                                                            $sibling = // find a sibling to $this.
                                                                                $mainElement = $(this); // memorize $(this)
                                                                            $sibling.change(function ($mainElement) {
                                                                                return function () {
                                                                                    if (this.value.indexOf('@') >= 1) {
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
                                                }
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


                            <div class="col-lg-2">
                                <div class='package-box animated swing'
                                     <?php if ($order_status == 'Done' || !empty($post_detail[0]['post_status']) && $post_detail[0]['post_status'] == 'Done') { ?>style="border: 2px solid #ff0002 !important;" <?php } ?>>
                                    <div class="body-content">
                                        Post #<?php echo $i + 1 ?>
                                    </div>


                                    <?php if ($order_status == 'Done' || !empty($post_detail[0]['post_status']) && $post_detail[0]['post_status'] == 'Done') { ?>
                                        <a href="#" class="edit-btn" style="padding:1px">Completed</a>
                                    <?php } else { ?>
                                        <a href="#" class="edit-btn edit-btn-posts" data-toggle="modal"
                                           style="padding:2px"
                                           data-target="#edit_post_model_<?php echo $i + 1; ?>">Edit</a>
                                    <?php } ?>


                                    <div class="clearfix"></div>
                                </div><!--/ package -->
                            </div>


                        <?php
                        }
                    }

                } else { ?>

                    <div class="col-lg-8 col-sm-10 offset-lg-2 offset-sm-1">
                        <div class="boxstyle text-center">
                    <p align="center">This Account is Private. <br> Please change your account status to view this resource.
                    </p>
                    </div>
                    </div>
               <?php  }
                ?>

                <div class="clearfix"></div>
            </section>


        </main>

    </div>
</div>


</body>
</html>
