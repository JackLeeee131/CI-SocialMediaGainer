    <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Media</b>Gainer</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!--  <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                            <span class="hidden-xs"><?php echo ucfirst($this->session->userdata('username')); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                            <!--  <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->

                                <p>
                                    <?php echo ucfirst($this->session->userdata('username')); ?>
                                    <small>Member since <?php echo date('M. Y',strtotime($this->session->userdata('created_date'))); ?></small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url(); ?>admin/logout" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li><a href="<?php echo base_url();?>admin/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Instagram Packages</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url();?>admin/instagram_packages"><i class="fa fa-circle-o"></i> Instagram Packages</a></li>
                        <li><a href="<?php echo base_url();?>admin/sub_packages"><i class="fa fa-circle-o"></i> Sub Packages </a></li>
                    </ul>
                </li>


                <!-- <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>One Time Orders</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url();?>admin/package_setup"><i class="fa fa-circle-o"></i> Setup One Time Orders</a></li>
                        <li><a href="<?php echo base_url();?>admin/track_oneTime_orders"><i class="fa fa-circle-o"></i> Track One Time Orders </a></li>
                    </ul>
                </li> -->

                <li><a href="<?php echo base_url();?>admin/user_accounts"><i class="fa fa-dashboard"></i> <span>Account Status</span></a></li>
                <li><a href="<?php echo base_url();?>admin/api_setup"><i class="fa fa-dashboard"></i> <span>API & Key</span></a></li>
                <!-- <li><a href="<?php echo base_url();?>admin/manage_comments"><i class="fa fa-dashboard"></i> <span>Custom Comments</span></a></li> -->
                <li><a href="<?php echo base_url();?>admin/dripfeed"><i class="fa fa-dashboard"></i> <span>Dripfeed</span></a></li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Other Setup</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url();?>admin/setup"><i class="fa fa-circle-o"></i> IG Name Changing Setup</a></li>
                       <li><a href="<?php echo base_url();?>admin/setup/keywords_setup"><i class="fa fa-circle-o"></i> Website Keywords Setup</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>



