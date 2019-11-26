<!DOCTYPE html>
<html>
<head>
    <?php
        $page_name = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $get_titles = $this->common_model->get_table_data('tbl_website_keywords', '*', array('page_name' => $page_name));
    ?>

    <title> 
        <?php if (!empty($get_titles[0]['page_title'])) {
                echo $get_titles[0]['page_title'];
            } else {
                echo 'Social Media Gainer';
            } 
        ?> 
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

    <link href="<?php echo base_url(); ?>frontend_assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome CSS -->
    <link href="<?php echo base_url(); ?>frontend_assets/assets/css/font-awesome.min.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>frontend_assets/assets/js/morris.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
    <script src="<?php echo base_url(); ?>frontend_assets/assets/js/example.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>frontend_assets/assets/css/example.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frontend_assets/assets/css/morris.css">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>frontend_assets/assets/css/sb-admin.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>frontend_assets/assets/css/custom.css" rel="stylesheet">
    <link rel='stylesheet prefetch' href='https://daneden.github.io/animate.css/animate.min.css'>
</head>

<?php if ($this->session->userdata('user_id')) { ?>


    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="#">
                <span class="front_logo_text"><img src="<?php echo base_url(); ?>assets/img/gainer-sign-in-logo.png"
                                                   alt="Social Media Gainer"
                                                   class="front_logo"/> Social Media Gainer</span>

                <?php
                    $qry = $this->common_model->get_table_data('tbl_accounts', 'current_balance', array('user_id' => $this->session->userdata('user_id')));
                ?>
            </a>
            <a href="#!"><i class="fa fa-bars d-block d-sm-none fa-2x toggle-btn" style="color: #FFF;"
                            data-toggle="collapse" data-target="#menu-content"></i></a>

            <div class="navbar-collapse d-none d-sm-block justify-content-end user-info" id="">
                <p class="balance">
                    <a href="<?php echo base_url(); ?>logout" class="btn btn-outline-light">Logout</a>
                </p>
            </div>
        </nav>
    </header>


<?php } ?>









