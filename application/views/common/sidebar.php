<nav class="sidebar">
    <div class="nav-side-menu">
        <div class="menu-list">
            <ul id="menu-content" class="menu-content collapse out">
                <li>
                    <a href="<?php echo base_url(); ?>dashboard" <?php if($this->uri->segment(1) == 'dashboard') { ?>class="active"<?php }?>>
                        <i class="fa fa-tachometer"></i> Dashboard
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url();?>packages"<?php if($this->uri->segment(1) == 'packages') { ?>class="active"<?php }?>><i class="fa fa-clone"></i> Packages</a>
                </li>

                <!-- <li>
                    <a href="<?php echo base_url();?>custom_packages"<?php if($this->uri->segment(1) == 'custom_packages') { ?>class="active"<?php }?>><i class="fa fa-first-order"></i> One Time Order</a>
                </li> -->

                <li>
                    <a href="<?php echo base_url(); ?>Accounts/other_services"<?php if($this->uri->segment(2) == 'other_services') { ?>class="active"<?php }?>>
                        <i class="fa fa-bullhorn"></i> Other Services
                    </a>
                </li>

                <li data-toggle="collapse" data-target="#products" class="collapsed">
                    <a href="#" class="">
                        <i class="fa fa-gear"></i> Settings <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu collapse" id="products">
                        <li class="">
                            <a href="<?php echo base_url(); ?>settings/manage_account"<?php if($this->uri->segment(2) == 'manage_account') { ?>class="active"<?php }?>><i class="fa fa-cogs"></i> Manage Account</a>
                        </li>

                        <li><a href="<?php echo base_url(); ?>settings/past_orders"<?php if($this->uri->segment(2) == 'past_orders') { ?>class="active"<?php }?>><i class="fa fa-eye-slash"></i> View Past Orders</a></li>

                        <li><a href="<?php echo base_url(); ?>settings/faq"<?php if($this->uri->segment(2) == 'faq') { ?>class="active"<?php }?>><i class="fa fa-question-circle"></i> F.A.Q</a></li>

                        <li><a href="<?php echo base_url(); ?>settings/referral"<?php if($this->uri->segment(2) == 'referral') { ?>class="active"<?php }?>><i class="fa fa-question-circle"></i> Referral</a></li>
                    </ul>
                </li>
            </ul>

            <div class="help-icons hidden-xs-down">
                <span class="">
                    <a href="<?php echo base_url(); ?>settings/faq"><i class="fa fa-question-circle"></i></a>
                </span>

                <span>
                    <a href="<?php echo base_url(); ?>settings/contact"><i class="fa fa-envelope"></i></a>
                </span>
            </div>
        </div>
    </div>
</nav>