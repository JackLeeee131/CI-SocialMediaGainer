

<body>









<div class="container-fluid">
    <div class="row">

        <main role="main" class="right-section">

            <h1 class="heading">Other Services</h1>

            <section class="row text-center placeholders">

                <div class="col-lg-8 col-sm-10 offset-lg-2 offset-sm-1">

                    <div class="boxstyle text-left">

                        <p align="center">Interested in growing other social media platforms? <br>Contact us by sending an email, and we will see what we can do!
                        </p>
                        <br>
                        <?php $attributes = array('class' => '', 'id' => 'other_services');
                        echo form_open('accounts/other_services', $attributes); ?>
                        <input type="hidden" name="email_subscription" value="1">



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


                            <div class="form-row align-items-center">
                                <div class="col-lg-8 col-sm-8">
                                    <label class="sr-only" for="inlineFormInput">Email</label>
                                    <input type="email" name="email" class="form-control mb-2" id="inlineFormInput" placeholder="Enter your email">
                                </div>

                                <div class="col-lg-4 col-sm-4">
                                    <button type="submit" class="btn btn-primary full-width mb-2">Subscribe</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>

                        <div class="social-media">
                            <a href="#" class="fa fa-facebook"></a>
                            <a href="#" class="fa fa-twitter"></a>
                            <a href="#" class="fa fa-google"></a>
                            <a href="#" class="fa fa-linkedin"></a>
                            <a href="#" class="fa fa-youtube"></a>
                            <a href="#" class="fa fa-instagram"></a>
                            <a href="#" class="fa fa-pinterest"></a>
                        </div><!--/ social media -->

                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
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
})

$(document).ready(function(){
    $('.heading').css('right', 'calc(50% - 219.5px)');
});

</script>


</body>
</html>
