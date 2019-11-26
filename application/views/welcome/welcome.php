<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php

    $page_name = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if ($page_name == 'socialmediagainer') {

        $page_name = 'welcome';

    }

    $get_titles = $this->common_model->get_table_data('tbl_website_keywords', 'page_title', array('page_name' => $page_name));

    ?><title> <?php if (!empty($get_titles[0]['page_title'])) {

            echo trim($get_titles[0]['page_title']);

        } else {

            echo 'Social Media Gainer';

        } ?>

    </title>

    <meta name="description" content="<?php if (!empty($get_titles[0]['keyword_description'])) {

        echo $get_titles[0]['keyword_description'];

    } else {

        echo $page_name . ' - Social Media Gainer';

    } ?>"/>

    <meta name="keywords" content="<?php if (!empty($get_titles[0]['keywords'])) {

        echo $get_titles[0]['keywords'];

    } else {

        echo $page_name . ' - Social Media Gainer';

    } ?>"/>



    <meta name="Subject" content="Social Media Gainer">

    <meta name="copyright" content="Copyright reserved and all that stuff">

    <meta name="language" content="English">





    <!-- Bootstrap core CSS -->

    <link href="<?php echo base_url(); ?>assets/dist/css_landing_page/bootstrap.min.css" rel="stylesheet">



    <!-- Fontawesome CSS -->

    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">



    <!-- Custom styles for this template -->

    <link href="<?php echo base_url(); ?>assets/css/landing-style.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/css/owl.carousel.min.css" rel="stylesheet">





</head>



<body>



<!-- ***** Header Area Start ***** -->

<header class="header_area animated">

    <div class="container-fluid">

        <div class="row align-items-center">

            <!-- Menu Area Start -->

            <div class="col-12 col-lg-10">




                <div class="menu_area">

                    <nav class="navbar navbar-expand-lg navbar-light">

                        <!-- Logo -->

                        <a class="navbar-brand" href="#"><span class="front_logo_text"><img

                                        src="<?php echo base_url(); ?>assets/img/gainer-logo.png" alt=""

                                        class="front_logo"/> Social Media Gainer</span></a>

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ca-navbar"

                                aria-controls="ca-navbar" aria-expanded="false" aria-label="Toggle navigation"><span

                                    class="navbar-toggler-icon"></span></button>

                        <!-- Menu Area -->

                        <div class="collapse navbar-collapse" id="ca-navbar">

                            <ul class="navbar-nav ml-auto" id="nav">

                                <li class="nav-item active"><a class="nav-link" href="#home">Home</a></li>

                                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>

                                <li class="nav-item"><a class="nav-link" href="#flexibility">Flexibility</a></li>

                                <li class="nav-item"><a class="nav-link" href="#tracking">Tracking</a></li>


                                <li class="nav-item"><a class="nav-link" href="#tracking">Contact</a></li>

                            </ul>

                            <div class="sing-up-button d-lg-none">

                                <a href="<?php echo base_url(); ?>login/signup">Sign Up</a>

                            </div>

                        </div>

                    </nav>

                </div>

            </div>

            <!-- Signup btn -->

            <div class="col-12 col-lg-2">

                <div class="sing-up-button d-none d-lg-block">

                    <a href="<?php echo base_url(); ?>login/signup">Sign Up</a>

                </div>

            </div>

        </div>

    </div>

</header>

<!-- ***** Header Area End ***** -->



<!-- ***** Wellcome Area Start ***** -->

<section class="wellcome_area clearfix theme-animation___1utsH" id="home">

    <div class="container h-100">

        <div class="row h-100 align-items-center text-center">

            <div class="col-12 col-md">


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


                <div class="wellcome-heading">

                    <h2>Social Media Gainer</h2>

                    <h3>SMG</h3>

                    <p>Supercharge your social media profile, and skyrocket your account to the next level.</p>

                </div>

                <div class="get-start-area">

                    <a href="<?php echo base_url(); ?>login/signup" class="btn">Sign Up</a>

                    <a href="<?php echo base_url(); ?>login" class="btn">Sign In</a>

                </div>

            </div>

        </div>

    </div>



</section>

<!-- ***** Wellcome Area End ***** -->



<!-- ***** Special Area Start ***** -->

<section class="special-area bg-white section_padding_100" id="features">

    <div class="container">

        <div class="row">

            <div class="col-12">

                <!-- Section Heading Area -->

                <div class="section-heading text-center">

                    <h2>Our Features</h2>

                    <div class="line-shape"></div>

                </div>

            </div>

        </div>



        <div class="row">

            <!-- Single Special Area -->

            <div class="col-12 col-md-4">

                <div class="single-special text-center wow fadeInUp" data-wow-delay="0.2s">

                    <div class="single-icon">

                        <i class="ti-mobile" aria-hidden="true"></i>

                    </div>

                    <h4>Easy to use</h4>

                    <p>Our platform was built with an easy to user interface. Get up and running in under 30 minutes! Still stuck? Reach out to our 24/7 support at any time!</p>

                </div>

            </div>

            <!-- Single Special Area -->

            <div class="col-12 col-md-4">

                <div class="single-special text-center wow fadeInUp" data-wow-delay="0.4s">

                    <div class="single-icon">

                        <i class="ti-ruler-pencil" aria-hidden="true"></i>

                    </div>

                    <h4>Powerful Design</h4>

                    <p>You can get viral as easy as a click of a button when purchasing our services . Rank top of your #hashtag, and gain real organic followers!</p>

                </div>

            </div>

            <!-- Single Special Area -->

            <div class="col-12 col-md-4">

                <div class="single-special text-center wow fadeInUp" data-wow-delay="0.6s">

                    <div class="single-icon">

                        <i class="ti-settings" aria-hidden="true"></i>

                    </div>

                    <h4>Customizability</h4>

                    <p>We have a variety  of packages that you can choose from. You can also customize many features, such as delivery speed, and much more!</p>

                </div>

            </div>

        </div>

    </div>

    <!-- Special Description Area -->


    <!-- Special Description Area -->

    <div class="pricing-plane-area section_padding_100">

        <div class="container">

            <div class="row">

                <div class="col-lg-6 col-xl-5 ml-xl-auto">

                    <div class="special_description_content">

                        <div class="section-heading text-center">

                            <h2>Our Network</h2>

                            <div class="line-shape"></div>

                        </div>

                        <p>With a network of hundreds of millions of users, Instagram is one of the most important social media platforms in this modern day. If you’re someone who wants to increase your engagement and popularity on Instagram, it would be very beneficial for you to buy one of our packages!</p>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="special_description_img">

                        <img src="<?php echo base_url(); ?>assets/img/bg-img/network.jpg" alt="">

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ***** Special Area End ***** -->


<!-- ***** Outstanding Flexibility start ***** -->
<section id="flexibility">
<div id="DIV_2">
    <div id="DIV_1">
        <div id="DIV_3">

            <div class="section-heading text-center">
                <h2>Outstanding Flexibility</h2>
                <div class="line-shape"></div>
            </div>


        </div>

        <div id="DIV_63">
            <div id="DIV_64">
                <div id="DIV_65">
                    <div id="DIV_66">
                        <ul id="UL_67">
                            <li id="LI_68">
                                <div id="DIV_69">
                                    <i class="fa fa-heart"></i>
                                </div>
                                <div id="DIV_71">
                                    <h3 id="H3_72">
                                        Organic Likes
                                    </h3>
                                    <div id="DIV_73">
                                        <p id="P_74">
                                            Engage in our exclusive network ready to delivery meaningful impressions for your Instagram page.  Real accounts providing real engagement.
                                        </p>
                                    </div>
                                </div>
                                <div id="DIV_75">
                                </div>
                            </li>
                            <li id="LI_76">
                                <div id="DIV_77">
                                    <i class="fa fa-bar-chart"></i>
                                </div>
                                <div id="DIV_79">
                                    <h3 id="H3_80">
                                        Unmatched Growth
                                    </h3>
                                    <div id="DIV_81">
                                        <p id="P_82">
                                            Your account will be subject to tons of impressions all directed to help you hit the explore page.
                                        </p>
                                    </div>
                                </div>

                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="DIV_92">
            <div id="DIV_93">
                <div id="DIV_94">
                    <div id="DIV_95">
                        <div id="DIV_96">
                            <div id="DIV_97">
                                <img src="<?php echo base_url();?>assets/img/landing_header.png" width="333" height="635" alt="" id="IMG_98" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="DIV_99">
            <div id="DIV_100">
                <div id="DIV_101">
                    <div id="DIV_102">
                        <ul id="UL_103">
                            <li id="LI_104">
                                <div id="DIV_105">
                                    <i class="fa fa-cog"></i>
                                </div>
                                <div id="DIV_107">
                                    <h3 id="H3_108">
                                        Additional Features
                                    </h3>
                                    <div id="DIV_109">
                                        <p id="P_110">
                                            Our software makes it easy to utilize your accounts giving you full control, organic likes, and an unparalleled level of return to your social media pages.
                                        </p>
                                    </div>
                                </div>
                                <div id="DIV_111">
                                </div>
                            </li>
                            <li id="LI_112">
                                <div id="DIV_113">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div id="DIV_115">
                                    <h3 id="H3_116">
                                        Friendly Software
                                    </h3>
                                    <div id="DIV_117">
                                        <p id="P_118">
                                            Easy to use website that simplifies your life and assists you instead of complicating things.
                                        </p>
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<!-- ***** Outstanding Flexibility start end ***** -->







<!-- ***** How it works start *****====== -->
<div id="how_works_DIV_2">
    <div id="how_works_DIV_1">

        <div id="how_works_DIV_3">
            <div id="how_works_DIV_4">
                <div id="how_works_DIV_5">
                    <div id="how_works_DIV_6">
                        <figure id="FIGURE_7">
                            <div id="how_works_DIV_8">
                                <img src="<?php echo base_url();?>assets/img/bg-img/how-works.png" width="1111" height="802" alt="scr-004" id="IMG_9" />
                            </div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <div id="how_works_DIV_10">
            <div id="how_works_DIV_11">
                <div id="how_works_DIV_12">
                    <div id="how_works_DIV_13">
                        <div class="section-heading">
                            <h2>How it Works</h2>
                            <div class="line-shape" style="margin-left: calc(0% - 0px);"></div>
                        </div>
                    </div>

                    <div id="how_works_DIV_18">
                        <div id="how_works_DIV_19">
                            <div id="how_works_DIV_20">
                                <div id="how_works_DIV_21">
                                    <div id="how_works_DIV_22">
                                        <div id="how_works_DIV_23">
                                            <i id="I_24"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="how_works_DIV_25">
                                <div id="how_works_DIV_26">
                                    <h3 id="H3_27">
                                        	Packages
                                    </h3>
                                </div>
                                <div id="how_works_DIV_28">
                                    We offer a variety of different packages to give you the best value.  If you have a larger order or would like to discuss a customized plan to suit your needs, don't hesitate to contact us!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="how_works_DIV_29">
                        <div id="how_works_DIV_30">
                            <div id="how_works_DIV_31">
                                <div id="how_works_DIV_32">
                                    <div id="how_works_DIV_33">
                                        <div id="how_works_DIV_34">
                                            <i id="I_35"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="how_works_DIV_36">
                                <div id="how_works_DIV_37">
                                    <h3 id="H3_38">
                                        	Enter Details
                                    </h3>
                                </div>
                                <div id="how_works_DIV_39">
                                    Provide us with your Instagram username and your email we'll get started with your order right away.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="how_works_DIV_40">
                        <div id="how_works_DIV_41">
                            <div id="how_works_DIV_42">
                                <div id="how_works_DIV_43">
                                    <div id="how_works_DIV_44">
                                        <div id="how_works_DIV_45">
                                            <i id="I_46"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="how_works_DIV_47">
                                <div id="how_works_DIV_48">
                                    <h3 id="H3_49">
                                        	Skyrocket!
                                    </h3>
                                </div>
                                <div id="how_works_DIV_50">
                                    Get ready for take-off.  Your package will start coming in within minutes!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="how_works_DIV_51">
                    </div>
                </div>
            </div>
        </div>
        <div id="how_works_DIV_52">
            <div id="how_works_DIV_53">
                <div id="how_works_DIV_54">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ***** How it works end *****====== -->









<!-- ***** Cool Facts Area Start ***** -->

<section class="cool_facts_area clearfix" id="tracking">

    <div class="container">

        <div class="row">



            <div class="col-lg-6">

                <div class="special_description_img">

                    <img src="<?php echo base_url(); ?>assets/img/bg-img/account-tracking.png" alt="">

                </div>

            </div>



            <div class="col-lg-6 col-xl-5 ml-xl-auto">

                <div class="special_description_content">

                    <div class="section-heading">

                        <h2 style="color: #fffefd">Account Tracking</h2>

                        <div class="line-shape" style="background: #fffefd; margin-left: calc(0% - 0px);"></div>

                    </div>
                    <p style="color: #FFF;">Social Media Gainer uses real time data, which allows you to analyze your growth, activity, and engagement data at any point of the day.  This will also analyze your competition!</p>

                </div>

            </div>



        </div>

    </div>

</section>



<section class="footer-contact-area section_padding_100 clearfix" id="contact">

    <div class="container">

        <div class="row">

            <div class="col-md-6">

                <!-- Heading Text  -->

                <div class="section-heading">

                    <h2>Get In Touch With Us!</h2>

                    <div class="line-shape"></div>

                </div>

                <div class="footer-text">

                    <p>Please use this contact form for general enquiries or support requests, we'll get back to you as soon as we can. </p>

                </div>


            </div>

            <div class="col-md-6">

                <!-- Form Start-->

                <div class="contact_from">

                    <?php $attributes = array('class' => '', 'id' => 'contact');
                    echo form_open('welcome/contact', $attributes); ?>
                        <!-- Message Input Area Start -->

                        <div class="contact_input_area">

                            <div class="row">

                                <!-- Single Input Area Start -->

                                <div class="col-md-12">

                                    <div class="form-group">

                                        <input type="text" class="form-control" name="name" id="name"

                                               placeholder="Your Name" required>

                                    </div>

                                </div>

                                <!-- Single Input Area Start -->

                                <div class="col-md-12">

                                    <div class="form-group">

                                        <input type="email" class="form-control" name="email" id="email"

                                               placeholder="Your E-mail" required>

                                    </div>

                                </div>

                                <!-- Single Input Area Start -->

                                <div class="col-12">

                                    <div class="form-group">

                                        <textarea name="message" class="form-control" id="message" cols="30" rows="4"

                                                  placeholder="Your Message *" required></textarea>

                                    </div>

                                </div>

                                <!-- Single Input Area Start -->

                                <div class="col-12">

                                    <button type="submit" class="btn submit-btn">Send Now</button>

                                </div>

                            </div>

                        </div>

                        <!-- Message Input Area End -->

                    <?php echo form_close(); ?>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ***** Contact Us Area End ***** -->



<!-- ***** Footer Area Start ***** -->

<footer class="footer-social-icon text-center section_padding_70 clearfix">

    <!-- footer logo -->

    <div class="footer-text">

        <h2><img src="<?php echo base_url(); ?>assets/img/gainer-logo.png" alt=""/></h2>

    </div>

  

    <div class="footer-menu">

        <nav>

            <ul>

                <li><a href="#home">About</a></li>

                <li><a href="<?php echo base_url(); ?>welcome/terms">Terms &amp; Conditions</a></li>

            </ul>

        </nav>

    </div>

    <!-- Foooter Text-->

    <div class="copyright-text">

        <!-- ***** Removing this text is now allowed! This template is licensed under CC BY 3.0 ***** -->

        <p> © 2018 SocialMediaGainer. All Rights Reserved.</p>

    </div>

</footer>

<!-- ***** Footer Area Start ***** -->





<!-- Jquery-2.2.4 JS -->

<script src="<?php echo base_url(); ?>assets/js/jquery-2.2.4.min.js"></script>

<!-- Popper js -->

<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>

<!-- Bootstrap-4 Beta JS -->

<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

<!-- All Plugins JS -->

<script src="<?php echo base_url(); ?>assets/js/plugins.js"></script>

<!-- Slick Slider Js-->

<script src="<?php echo base_url(); ?>assets/js/slick.min.js"></script>

<!-- Footer Reveal JS -->

<script src="<?php echo base_url(); ?>assets/js/footer-reveal.min.js"></script>

<!-- Active JS -->

<script src="<?php echo base_url(); ?>assets/js/active.js"></script>

</body>



</html>

