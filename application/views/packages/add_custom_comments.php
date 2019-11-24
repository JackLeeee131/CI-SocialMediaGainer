

<body>








<div class="container-fluid">
    <div class="row">



        <main role="main" class="right-section">

            <h1 class="heading">Add Comments</h1>

            <section class="row text-center placeholders">

                <div class="col-lg-8 col-sm-10 offset-lg-2 offset-sm-1">

                    <div class="boxstyle text-left">

                        <?php $attributes = array('class' => '', 'id' => 'custom_comments_form', 'name' => 'comments_form');
                        echo form_open('custom_packages/confirm_comments_order/', $attributes); ?>

                        <?php

                        $order_qty = $this->uri->segment('3');
                        $ig_url = $this->uri->segment('4');
                        $order_price = $this->uri->segment('5');


                        ?>
                        <input type="hidden" name="add_comment" value="1">
                        <input type="hidden" name="post_comments" value="<?php if(!empty($order_qty)) { echo $order_qty; } else { echo $comments_data['post_comments'];} ?>">
                        <input type="hidden" name="instagram_url" value="<?php if(!empty($ig_url)) { echo $ig_url; } else { echo $comments_data['instagram_url'];} ?>">
                        <input type="hidden" name="comments_price_value" value="<?php if(!empty($order_price)) { echo $order_price; } else { echo $comments_data['order_price'];} ?>">

                        <input type="hidden" name="is_back" value="<?php if(!empty($order_price)) { echo 'yes'; } ?>">



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


                        <table class="table table-striped text-left">
                            <thead>
                            <tr>
                                <th scope="col" style="border-top:0px;">Select Comments</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input value="default_comments" type="radio" name="comments_type" id="comments_type" checked> Default Comments</td>
                            </tr>
                            <tr>
                                <td><input value="custom_comments" type="radio" name="comments_type" id="add_custom_comments"> Add Custom Comments</td>
                            </tr>
                            </tbody>
                        </table>










                        <div class="form-group text-left" style="display: none" id="custom_comments">
                            <label for="exampleInputEmail1">Add Comments </label>

<!--                            <span style="color: #ff0002">( Remaining: --><?php //echo $comments_data['post_comments'] - $count_comments[0]['comments_count']; ?><!-- )</span>-->
                            <?php

                            if(!empty($order_qty)) { $qty =  $order_qty; } else { $qty =  $comments_data['post_comments'];}
                            for($i = 1; $i <= $qty; $i++) {

                                ?>

                                <div class="form-row align-items-center">
                                    <div class="col-lg-1 col-sm-3"></div>
                                    <div class="col-lg-1 col-sm-3"> <?php echo $i; ?>  </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <input type="text" name="comment_list[]" class="form-control custom_comment_fields" id="custom_comments_field_<?php echo $i; ?>" aria-describedby="emailHelp" placeholder="" maxlength="100" style="margin-top: 10px">
                                    </div>
                                </div>


                                <script>

                                    $('#custom_comments_field_<?php echo $i; ?>').each(function() {
                                        $sibling = // find a sibling to $this.
                                            $mainElement = $(this); // memorize $(this)
                                        $sibling.change(function($mainElement) {
                                            return function() {
                                                if (this.value.indexOf('@') >= 1 || this.value.indexOf('@') ==  0) {

                                                    alert("Mentions or @usernames are not allowed");
                                                    $(this).css('border','2px solid red');
                                                    $('#custom_comments_field_<?php echo $i; ?>').focus();
                                                    $(':input[type="submit"]').prop('disabled', true);
                                                    return false;
                                                } else {
                                                    $(':input[type="submit"]').prop('disabled', false);
                                                    $(this).css('border','1px solid #ced4da');
                                                }
                                            }
                                        }($mainElement))
                                    });

                                    function validateForm_<?php echo $i; ?>() {
                                        var custom_comment_<?php echo $i; ?> = $('#custom_comments_field_<?php echo $i; ?>').val();
                                        alert(custom_comment_<?php echo $i; ?>);
                                        if (custom_comment_<?php echo $i; ?>.indexOf('@') >= 1) {
                                            alert("Mentions or @usernames are not allowed");
                                            return false;
                                        }
                                    }
                                    $('input:radio[name=comments_type]').change(function(){
                                        if (this.value == 'custom_comments') {
                                            $('#custom_comments').css('display', 'block');
                                            $('#comments_msg').css('display', 'block');
                                            $('#custom_comments_field_<?php echo $i; ?>').prop('required',true);
                                        } else if(this.value == 'default_comments') {
                                            $('#custom_comments').css('display', 'none');
                                            $('#comments_msg').css('display', 'none');
                                            $('#custom_comments_field_<?php echo $i; ?>').prop('required',false);
                                        }
                                    });
                                </script>



                            <?php } ?>
                        </div>




















                        <div class="form-group">
                            <input type="submit" class="btn btn-primary full-width" value="Send">
                        </div>


                        <div class="form-group text-left" style="font-size: 15px; color: #ff0002; display: none" id="comments_msg">
                            Please note that comments that include mentions or @usernames, will be cancelled and not refunded. 100 characters per one comment
                        </div>


                        <?php echo form_close(); ?>


                        <script>
                            $('#custom_comments_form').submit(function () {
                                var res = true;
                                $(".custom_comment_fields").each(function(){
                                    if($(this).val().indexOf('@') >= 1 || $(this).val().indexOf('@') == 0) {
                                        res = false;
                                    }
                                });
                                return res;
                            });
                        </script>



                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>


        </main>

    </div>
</div>






</body>
</html>
