

<body>

<div class="container-fluid">
    <div class="row">

        <main role="main" class="right-section">

            <h1 class="heading">Contact</h1>

            <section class="row text-center placeholders">

                <div class="col-lg-8 col-sm-10 offset-lg-2 offset-sm-1">

                    <div class="boxstyle text-left">

                        <p>Please consider looking at the <a href="<?php echo base_url(); ?>settings/faq"> FAQ, </a> as the answers to most of your problems can be found there.

                            Keep in mind we receive many emails, so please be patient. We will reply to your ticket within the next 48 hours.
                            <br /><br />
                            In order for us to help you, please describe the problem you're having in great detail, stating dates, values and billing emails.</p>

                        <?php $attributes = array('class' => '', 'id' => 'contact');
                        echo form_open('settings/contact', $attributes); ?>

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

<input type="hidden" name="contact" value="1">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Email to contact you</label>
                                <input type="text" name="email" class="form-control" id="" placeholder="Email">
                            </div>


                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Subject</label>
                                <input type="text" name="subject" class="form-control" id="" placeholder="Subject">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Issue</label>
                                <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary full-width">Send</button>
                            </div>

                        <?php echo form_close(); ?>

                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>


        </main>


    </div>
</div>


<script>

$(document).ready(function(){
    $('.heading').css('right', 'calc(50% - 70px)');
});
</script>


</body>
</html>
