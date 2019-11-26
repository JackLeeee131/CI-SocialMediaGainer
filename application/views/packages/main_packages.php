





<body>

<div class="container-fluid">

    <div class="row">

        <main role="main" class="right-section">

            <h1 class="heading">Packages</h1>

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

            <section class="row placeholders">

                <div class="col-lg-4 col-sm-6">

                    <a href="<?php echo base_url().'packages/sub_packages/'.$packages_list[0]['package_id'];?>">

                        <div class='pricing animated swing' style="background: linear-gradient(60deg,#ffa726,#fb8c00);">

                            <div class='animated text-center pulse infinite'>

                                <h2 style="font-size:40px;"><?php echo $packages_list[0]['package_name']; ?></h2>

                            </div>

                            <div class='content'>

                                <ul>
                                    <li> Likes </li>

                                    <li> View </li>
                                </ul>

                            </div>

                        </div>

                    </a>

                </div><!--/ plan box -->


                <div class="col-lg-4 col-sm-6">

                    <a href="<?php echo base_url().'packages/sub_packages/'.$packages_list[1]['package_id'];?>">                        <div class='pricing animated swing' style="background: linear-gradient(60deg,#ef5350,#e53935);">

                            <div class='animated text-center pulse infinite'>

                                <h2 style="font-size:40px;"><?php echo $packages_list[1]['package_name']; ?></h2>

                            </div>

                            <div class='content'>
                                <ul>
                                    <li> Likes </li>
                                    <li> Views </li>
                                    <li> Comments </li>
                                </ul>
                            </div>
                        </div>
                    </a>
                </div><!--/ plan box -->

                <div class="col-lg-4 col-sm-6">

                    <a href="<?php echo base_url().'packages/sub_packages/'.$packages_list[2]['package_id'];?>">                        <div class='pricing animated swing' style="background: linear-gradient(60deg,#ec407a,#d81b60);">

                            <div class='animated text-center pulse infinite'>

                                <h2 style="font-size:40px;"><?php echo $packages_list[2]['package_name']; ?></h2>

                            </div>

                            <div class='content'>

                                <ul>
                                    <li>
                                        Likes
                                    <li>
                                        Views
                                    </li>
                                    <li>
                                        Followers
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </a>
                </div><!--/ plan box -->

                <div class="col-lg-4 col-sm-6 offset-lg-2">

                    <a href="<?php echo base_url().'packages/sub_packages/'.$packages_list[3]['package_id'];?>">                        <div class='pricing animated swing' style="background: linear-gradient(60deg,#66bb6a,#43a047);">

                            <div class='animated text-center pulse infinite'>

                                <h2 style="font-size:40px;"><?php echo $packages_list[3]['package_name']; ?></h2>

                            </div>

                            <div class='content'>
                                <ul>

                                    <li>
                                        Likes
                                    </li>
                                    <li>
                                        Views
                                    </li>
                                    <li>
                                        Comments
                                    </li>
                                    <li>
                                        Followers
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </a>
                </div><!--/ plan box -->

                <div class="col-lg-4 col-sm-6">

                    <a href="<?php echo base_url().'packages/sub_packages/'.$packages_list[4]['package_id'];?>">                        <div class='pricing animated swing' style="background: linear-gradient(60deg,#26c6da,#00acc1);">

                            <div class='animated text-center pulse infinite'>

                                <h2 style="font-size:40px;"><?php echo $packages_list[4]['package_name']; ?></h2>

                            </div>

                            <div class='content'>

                                <ul>

                                    <li>  Special ID </li>

                                    <p style="padding: 15px; color: #ff0002; text-align: center">  Contact us if you would like something <br>

                                        that was not listed in the above packages</p>
                                </ul>

                            </div>
                       </div>
                    </a>
                </div><!--/ plan box -->
                <div class="clearfix"></div>
            </section>
        </main>
    </div>

</div>

<script>

    $(document).ready(function(){

        $('.heading').css('right', 'calc(50% - 208px)');

    });

</script>

</body>



</html>



