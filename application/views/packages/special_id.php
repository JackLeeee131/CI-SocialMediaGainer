

<body>

<div class="container-fluid">
    <div class="row">



        <main role="main" class="right-section">

            <h1 class="heading">Special ID</h1>

            <section class="row text-center placeholders">

                <div class="col-lg-8 col-sm-10 offset-lg-2 offset-sm-1">

                    <div class="boxstyle text-left">

                        <?php $attributes = array('class' => '', 'id' => 'special_id');
                        echo form_open('packages/special_id/', $attributes); ?>

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


                        <div class="form-group text-left">
                            <label for="exampleInputEmail1">Special Service Id</label>
                            <input type="text" name="special_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Special Id" required>
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


</body>
</html>
