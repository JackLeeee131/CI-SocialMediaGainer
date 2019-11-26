

<body>


<div class="container-fluid">
    <div class="row">


        <main role="main" class="right-section">

            <h1 class="heading">Sub Packages</h1>
            <section class="row placeholders">
                <?php
                $colors =  array('0' => 'linear-gradient(60deg,#ffa726,#fb8c00)',
                    '1' =>'linear-gradient(60deg,#ef5350,#e53935)',
                    '2' =>'linear-gradient(60deg,#ec407a,#d81b60)',
                    '3' =>'linear-gradient(60deg,#66bb6a,#43a047)',
                    '4' =>'linear-gradient(60deg,#26c6da,#00acc1)',
                    '5' =>'linear-gradient(60deg,#3D4155,#3D4155)',
                    '6' =>'linear-gradient(60deg,#FFD093,#FFD093)',
                    '7' =>'linear-gradient(60deg,##FFFFB1,##FFFFB1)', );
                $i = 0;
                foreach($sub_packages_list as $sub_package) {
                    ?>

                    <div class="col-lg-3 col-sm-3">
                        <a href="<?php echo base_url().'packages/package_detail/'.$sub_package['sub_package_id'];?>">
                            <div class='sub_pricing animated swing' style="background: <?php if($i < 0)  {echo  $colors[$i++]; }?> ">

                                <div class='animated text-center pulse infinite'>
                                    <h2 style="font-size:40px;"><sub>$</sub> <?php echo $sub_package['price']; ?></h2>
                                </div>
                                <div class='content'>
                                    <ul>

                                        <?php if(!empty($sub_package['likes'])) { ?>
                                            <li>
                                                <div class='fa fa-check'></div>
                                                <b><?php echo number_format($sub_package['likes']); ?> </b>&nbsp; Likes  For ( <?php echo $sub_package['likes_per_post']; ?> post )
                                            </li>
                                        <?php } ?>

                                        <?php if(!empty($sub_package['views'])) { ?>
                                            <li>
                                                <div class='fa fa-check'></div>
                                                <b><?php echo number_format($sub_package['views']); ?> </b>&nbsp; Views For ( <?php echo $sub_package['likes_per_post']; ?> post )
                                            </li>
                                        <?php } ?>

                                        <?php if(!empty($sub_package['comments'])) { ?>
                                            <li>
                                                <div class='fa fa-check'></div>
                                                <b><?php echo number_format($sub_package['comments']); ?> </b>&nbsp; Comments For ( <?php echo $sub_package['likes_per_post']; ?> post )
                                            </li>
                                        <?php } ?>

                                        <?php if(!empty($sub_package['followers'])) { ?>
                                            <li>
                                                <div class='fa fa-check'></div>
                                                <b><?php echo number_format($sub_package['followers']); ?> </b>&nbsp; Followers ( <?php echo $sub_package['followers_per_day']; ?> per day )
                                            </li>
                                        <?php } ?>

                                    </ul>

                                </div>
                            </div>
                        </a>
                    </div>

                <?php }?>

                <div class="clearfix"></div>
            </section>


        </main>

    </div>
</div>



<script>
    $(document).ready(function(){
        $('.heading').css('right', 'calc(50% - 217.5px)');
    });
</script>
</body>
</html>
