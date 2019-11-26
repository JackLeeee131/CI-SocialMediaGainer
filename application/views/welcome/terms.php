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
                        <a class="navbar-brand" href="<?php echo base_url(); ?>welcome"><span
                                    class="front_logo_text"><img
                                        src="<?php echo base_url(); ?>assets/img/gainer-logo.png" alt=""
                                        class="front_logo"/> Social Media Gainer</span></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ca-navbar"
                                aria-controls="ca-navbar" aria-expanded="false" aria-label="Toggle navigation"><span
                                    class="navbar-toggler-icon"></span></button>
                        <!-- Menu Area -->
                        <div class="collapse navbar-collapse" id="ca-navbar">
                            <ul class="navbar-nav ml-auto" id="nav">


                                <li class="nav-item active"><a class="nav-link" href="<?php echo base_url(); ?>welcome">Home</a></li>

                                <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>welcome#features">Features</a></li>

                                <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>welcome#flexibility">Flexibility</a></li>

                                <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>welcome#tracking">Tracking</a></li>


                                <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>welcome#contact">Contact</a></li>

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


<!-- *****  Terms & Conditions Area Start ***** -->
<section class="special-area bg-white section_padding_100">
    <!-- Special Description Area -->
    <div class="special_description_area mt-150" style="margin-top: 80px">
        <div class="container">
            <div class="text-box">


                <h4 style="text-align: center">Terms of Service</h4>

                <br>
                <p>Please read these Terms and Conditions ("Terms", "Terms and Conditions", "Terms of Service")
                    carefully before using the https://socialmediagainer.com website (the "Service") operated by
                    SocialMediaGainer ("us", "we", or "our").</p>
                <p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these
                    Terms. These Terms apply to all visitors, users and others who access or use the Service.</p>
                <p>We may collect personal identification information from Users in a variety of ways, including, but
                    not limited to, when Users visit our site, register on the site, place an order, subscribe to the
                    newsletter, fill out a form, and in connection with other activities, services, features or
                    resources we make available on our Site. Users may be asked for, as appropriate, name, email
                    address, mailing address, phone number. Users may, however, visit our Site anonymously. We will
                    collect personal identification information from Users only if they voluntarily submit such
                    information to us. Users can always refuse to supply personally identification information, except
                    that it may prevent them from engaging in certain Site related activities.</p>
                <p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part
                    of the terms then you may not access the Service.</p>


                <h4>Accounts</h4>

                <p>When you create an account with us, you must provide us information that is accurate, complete, and
                    current at all times. Failure to do so constitutes a breach of the Terms, which may result in
                    immediate termination of your account on our Service.</p>
                <p>You are responsible for safeguarding the password that you use to access the Service and for any
                    activities or actions under your password, whether your password is with our Service or a
                    third-party service.</p>
                <p>You agree not to disclose your password to any third party. You must notify us immediately upon
                    becoming aware of any breach of security or unauthorized use of your account.</p>


                <h4>Links To Other Web Sites</h4>

                <p>Our Service may contain links to third-party web sites or services that are not owned or controlled
                    by SocialMediaGainer.</p>
                <p>SocialMediaGainer has no control over, and assumes no responsibility for, the content, privacy
                    policies, or practices of any third party web sites or services. You further acknowledge and agree
                    that SocialMediaGainer shall not be responsible or liable, directly or indirectly, for any damage or
                    loss caused or alleged to be caused by or in connection with use of or reliance on any such content,
                    goods or services available on or through any such web sites or services.</p>
                <p>We strongly advise you to read the terms and conditions and privacy policies of any third-party web
                    sites or services that you visit.</p>


                <h4>Termination</h4>


                <p>All provisions of the Terms which by their nature should survive termination shall survive
                    termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity
                    and limitations of liability.</p>
                <p>We may terminate or suspend your account immediately, without prior notice or liability, for any
                    reason whatsoever, including without limitation if you breach the Terms.</p>
                <p>All provisions of the Terms which by their nature should survive termination shall survive
                    termination, including, without limitation, ownership provisions, warranty.</p>


                <h4>Governing Law</h4>

                <p>These Terms shall be governed and construed in accordance with the laws of the United States of
                    America, without regard to its conflict of law provisions.</p>

                <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those
                    rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the
                    remaining provisions of these Terms will remain in effect. These Terms constitute the entire
                    agreement between us regarding our Service, and supersede and replace any prior agreements we might
                    have between us regarding the Service.</p>


                <h4>Changes</h4>

                <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a
                    revision is material we will try to provide at least 30 days notice prior to any new terms taking
                    effect. What constitutes a material change will be determined at our sole discretion.</p>

                <p>By continuing to access or use our Service after those revisions become effective, you agree to be
                    bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>


                <h4>Refund Policy</h4>

                <p>All sales are final, as there will be no refund for anything purchased on our website. We provide 24/7 support if you need any assistance.</p>




                <h4>Contact Us</h4>

                <p>If you have any questions about these Terms, please contact us: support@socialmediagainer.com</p>


            </div>
        </div>
    </div>
    <!-- Special Description Area -->
</section><!-- ***** Terms & Conditions Area End ***** -->


<!-- ***** Footer Area Start ***** -->
<footer class="footer-social-icon text-center section_padding_70 clearfix">
    <!-- footer logo -->
    <div class="footer-text">
        <h2><img src="<?php echo base_url(); ?>assets/img/gainer-logo.png" alt=""/></h2>
    </div>

    <div class="footer-menu">
        <nav>
            <ul>
                <li><a href="<?php echo base_url(); ?>">About</a></li>
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


</body>

</html>
