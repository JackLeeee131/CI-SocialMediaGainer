
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

            <h1 class="heading">Dashboard</h1>

            <section class="row text-center placeholders" id="">


                <?php
                $i = 1;
                foreach($insta_users as $user_data) {
                    $username = $user_data['instagram_name'];

                    require (APPPATH.'\controllers\vendor\autoload.php');
                    $instagram_api = new \InstagramScraper\Instagram();
                    $account = $instagram_api->getAccount($username);
                    $is_private = $account->isPrivate();

                    if($is_private != 1) {

                        $profile_pic_url = $account->getProfilePicUrl();
                        $total_posts = $account->getMediaCount();
                        $following = $account->getFollowsCount();
                        $followers = $account->getFollowedByCount();

                        ?>

                        <!-- edit instagram name Modal -->
                        <div class="modal fade" id="insta_name_model_<?php echo $user_data['order_id']; ?>" tabindex="-1"
                             role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="color: #ff0002" id="exampleModalLabel"> Edit
                                            Instagram Name </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                                id="close_poup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php $attributes = array('class' => '', 'id' => 'update_instagram_name');
                                    echo form_open('accounts/update_instagram_name', $attributes); ?>
                                    <div class="modal-body">
                                        <div class="form-group text-left">
                                            <label for="exampleInputEmail1">Instagram Name</label>
                                            <input type="hidden" name="order_id"
                                                   value="<?php echo $user_data['order_id']; ?>">

                                            <input type="text" value="<?php echo $user_data['instagram_name']; ?>"
                                                   name="instagram_name" class="form-control" id="exampleInputEmail1"
                                                   aria-describedby="emailHelp" placeholder="Instagram Name" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Update" class="btn btn-primary" id="add_funds">
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                        <!-- package detail Modal -->
                        <div class="modal fade" id="package_model_<?php echo $user_data['order_id']; ?>" tabindex="-1"
                             role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="color: #ff0002" id="exampleModalLabel"> Package
                                            Detail </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                                id="close_poup">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php
                                    $data['sub_package_detail'] = $this->common_model->get_table_data('tbl_sub_packages', '*', array('status' => 'Active', 'sub_package_id' => $user_data['tbl_subpkg_id']), $row = 1);
                                    ?>

                                    <div class="modal-body">
                                        <div class="col-lg-12 col-sm-12" align="center">
                                            <div class='sub_pricing animated swing'
                                                 style="background: linear-gradient(60deg,#ffa726,#fb8c00); border: 1px solid #AD8859">
                                                <div class='animated text-center pulse infinite'>
                                                    <h2 style="font-size:40px;">
                                                        <sub>$</sub> <?php echo $data['sub_package_detail'][0]['price']; ?>
                                                    </h2>
                                                </div>
                                                <div class='content'>
                                                    <ul>

                                                        <?php if(!empty($data['sub_package_detail'][0]['likes'])) { ?>
                                                            <li>
                                                                <div class='fa fa-check'></div>
                                                                <b><?php echo $data['sub_package_detail'][0]['likes']; ?> </b>&nbsp;Total
                                                                Likes For
                                                                ( <?php echo $data['sub_package_detail'][0]['likes_per_post']; ?>
                                                                post )
                                                            </li>
                                                        <?php } ?>

                                                        <?php if(!empty($data['sub_package_detail'][0]['views'])) { ?>
                                                            <li>
                                                                <div class='fa fa-check'></div>
                                                                <b><?php echo $data['sub_package_detail'][0]['views']; ?> </b>&nbsp;
                                                                Total Views For
                                                                ( <?php echo $data['sub_package_detail'][0]['views_per_post']; ?>
                                                                post )
                                                            </li>
                                                        <?php } ?>

                                                        <?php if(!empty($data['sub_package_detail'][0]['comments'])) { ?>
                                                            <li>
                                                                <div class='fa fa-check'></div>
                                                                <b><?php echo $data['sub_package_detail'][0]['comments']; ?> </b>&nbsp;
                                                                Total Comments For
                                                                ( <?php echo $data['sub_package_detail'][0]['comments_per_post']; ?>
                                                                post )
                                                            </li>
                                                        <?php } ?>

                                                        <?php if(!empty($data['sub_package_detail'][0]['followers'])) { ?>
                                                            <li>
                                                                <div class='fa fa-check'></div>
                                                                <b><?php echo $data['sub_package_detail'][0]['followers']; ?> </b>&nbsp;
                                                                Total Followers For
                                                                ( <?php echo $data['sub_package_detail'][0]['followers_per_day']; ?>
                                                                days )
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>


                                                <div class='content remaining_detail'>
                                                    <ul>
                                                        <?php if(!empty($data['sub_package_detail'][0]['Likes'])) { ?>
                                                            <li>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($data['sub_package_detail'][0]['views'])) { ?>
                                                            <li>
                                                                <div class="remaining_title"> Remaining views</div>
                                                                <b> 0 </b>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($data['sub_package_detail'][0]['comments'])) { ?>
                                                            <li>
                                                                <div class="remaining_title"> Remaining comments</div>
                                                                <b> 0 </b>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($data['sub_package_detail'][0]['followers'])) { ?>
                                                            <li>
                                                                <div class="remaining_title"> Remaining followers</div>
                                                                <b> 0 </b>
                                                            </li>
                                                        <?php } ?>

                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3 col-sm-4">
                            <div class='package-box animated swing'>
                                <div class="img-header">
                                    <img src="<?php echo $profile_pic_url; ?>" width="100%" alt="Instagram Profile Picture"
                                         style="height: 100%;"/>

                                    <label class="switch">

                                        <input type="checkbox" data-toggle="toggle" id="package_status_<?php echo $user_data['order_id'];?>" value="<?php echo $user_data['package_status']; ?>" <?php if($user_data['package_status'] == 'active') { ?> checked <?php } ?> >


                                    </label>
                                </div>

                                <script>

                                    $(document).ready(function(){

                                        $('#package_status_<?php echo $user_data['order_id'];?>').on('change', function(){
                                            window.location.href= '<?php echo base_url();?>dashboard/update_package_status/<?php echo $user_data['order_id']; ?>/<?php echo $user_data['package_status']; ?>';
                                        });

                                    });

                                </script>


                                <div class="body-content">
                                    <h3><?php echo $user_data['instagram_name']; ?></h3>
                                    <div class="detail-list">
                                        <ul>
                                            <li>
                                                Posts <span><?php echo number_format($total_posts); ?></span>
                                            </li>
                                            <li>
                                                Followers <span><?php echo number_format($followers); ?></span>
                                            </li>
                                            <li>
                                                Following <span><?php echo number_format($following); ?></span>
                                            </li>
                                        </ul>
                                    </div><!-- / detail list-->
                                    <div class="clearfix"></div>
                                </div><!--/ body-content -->

                                <div>
                                    <a href="<?php echo base_url() . 'dashboard/view_posts/' . $user_data['order_id']; ?>"
                                       style="color: #0b93d5; font-size: 14px; font-weight: bold; text-align: center;">Edit
                                        Posts</a>
                                </div>

                                <a href="#" class="edit-btn edit-btn-posts" data-toggle="modal"
                                   data-target="#insta_name_model_<?php echo $user_data['order_id']; ?>">Edit Instagram
                                    Name</a>


                                <div class="clearfix"></div>
                            </div><!--/ package -->
                        </div>


                    <?php } else { ?>

                        <div class="col-lg-3 col-sm-4">
                            <div class='package-box animated swing'>
                                <div class="body-content">
                                    <p align="center" style="font-size: 14px; font-weight: bold ">
                                        <span style="color: #ff0002; font-size: 16px"> <?php echo $user_data['instagram_name']; ?> </span> <br>  <br> This Account is Private. <br> Please change your account status to use this resource.
                                    </p>

                                </div>
                            </div>
                        </div>



                    <?php  }
                    ?>

                <?php } ?>

                <div class="col-lg-3 col-sm-4">

                    <div class='add-plan animated swing'>

                        <a href="<?php echo base_url(); ?>packages"><i class="fa fa-user-plus fa-5x"></i></a>

                    </div>

                </div>

                <div class="clearfix"></div>
            </section>
