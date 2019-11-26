<html>
<head>

    <style>
        * {
            box-sizing: border-box;
        }

        #regForm {
            margin: 0px auto;
            min-width: 500px;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.8;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #d66162;
        }

        .sub_pricing .remaining_detail ul li:nth-child(2n) {
            background: #fffefd !important;
        }

        .remaining_title {
            display: inline-block;
        }

        html, body {
            padding: 0;
            margin: 0;
            overflow: none;
            width: 100%;
            height: 100%;
        }

        .page_loader {
            background: url('https://i.imgur.com/UMnw0tW.jpg');
            font-family: 'Ubuntu', sans-serif;
            background-position: center center;
            background-size: cover;
            color: #121212;
        }

        .loader {
            position: absolute;
            top: 50%;
            margin: -240px;
            left: 50%;
            width: 480px;
            height: 480px;
            z-index: 1;
        }

        .loader h1 {
            position: absolute;
            top: 0px;
            left: 0px;
            text-align: center;
            width: 100%;
            top: 0px;
            line-height: 420px;
            font-size: 24px;
            color: rgba(0, 0, 0, 0.24);
            font-weight: 100;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }

        @keyframes spin {
            from {
                transform: scale(1) rotate(0deg);
            }
            to {
                transform: scale(1) rotate(360deg);
            }
        }

        @-webkit-keyframes spin2 {
            from {
                -webkit-transform: rotate(0deg);
            }
            to {
                -webkit-transform: rotate(360deg);
            }
        }


    </style>
</head>

<body class="" id="">
<!--<body class="page_loader" id="dashboard_body">-->

    <div class="loader" id="spinner" style="display:block  ">
        <canvas width="480px" height="480px" id="loader"></canvas>
        <h1>Loading</h1>
    </div>

    <?php if ($this->session->userdata('welcome_message') == 1) { ?>
    <div id="announcement" class="announcement-modal">

        <div class="background-overlay"></div>

        <div id="regForm">

            <!-- One "tab" for each step in the form: -->

            <div class="tab">
                <div class="announcement-box">
                    <span class="vue-trans">
                        <div>
                            <div class="image-demonstration">
                            <div class="img"
                                style="background: url(<?php echo base_url(); ?>assets/img/gainer-sign-in-logo.png); width: 100%; height: 100%"></div>
                            </div>
                            <div class="text-demonstration">
                                <h3>Welcome to Social Media Gainer</h3>
                                <p>Let's go through a quick tour to explain you how everything is works!</p>
                            </div>
                        </div>
                    </span>
                </div>
            </div><!--/ tab -->


            <div class="tab">
                <div class="announcement-box">
                    <span class="vue-trans">
                        <div>
                            <div class="image-demonstration">
                                <div class="img"
                                    style="background: url(<?php echo base_url(); ?>assets/img/side_panel.png); width: 100%; height: 100%"></div>
                                </div>
                                <div class="text-demonstration">
                                    <h3>Use Our Side Panel!</h3>
                                    <p>Click the side button icons to access our website</p>
                                </div>
                         </div>
                    </span>
                </div>
            </div><!--/ tab -->


            <div class="tab">

                <div class="announcement-box">

                    <span class="vue-trans">
                        <div>
                        <div class="image-demonstration">
                        <div class="img"
                            style="background: url(<?php echo base_url(); ?>assets/img/socialmedia-1.png); width: 305px; background-size:305px 200px !important"></div>
                        </div>
                        <div class="text-demonstration">
                        <h3>Instagram Packages</h3>
                        <p>Start skyrocketing your accounts to new potentials. </p>
                        </div>
                        </div>
                    </span>

                </div>

            </div><!--/ tab -->

            <div class="tab">
                <div class="announcement-box">

                    <span class="vue-trans">
                        <div>
                        <div class="image-demonstration">
                        <div class="img"
                            style="background: url(<?php echo base_url(); ?>assets/img/user_settings.png); width: 305px;"></div>
                        </div>
                        <div class="text-demonstration">
                        <h3>Access your user settings</h3>
                        <p>Here you can manage your settings, where you can Manage Your Account, View Past Orders, read F.A.Q’s, and access the Referral Section.</p>
                        </div>
                        </div>
                    </span>
                </div>
            </div><!--/ tab -->


            <div class="tab">

                <div class="announcement-box">

                    <span class="vue-trans">
                        <div>
                        <div class="image-demonstration">
                        <div class="img" style="background: url(<?php echo base_url(); ?>assets/img/referral.png);"></div>
                        </div>
                        <div class="text-demonstration">
                        <h3>Referral Section</h3>
                        <p>Start earning money by recruiting people to the website with your unique referral ID, $$ </p>
                        </div>
                        </div>
                    </span>

                </div>
            </div><!--/ tab -->

            <div style="overflow:auto;">

                <button class="announcement-button back"
                    style="z-index: 1000000; position: relative;font-family: 'Roboto', sans-serif; background: #3d4155; border-radius: 0px 0px 0px 5px;" type="button"
                        announcement-button id="preBtn" onclick="Prevbtn(1)">Back
                </button>

                <button class="announcement-button"
                        style="font-family: 'Roboto', sans-serif;z-index: 1000000; position: relative; border-radius: 0px 0px 5px 0px; "
                        type="button"
                        announcement-button
                        id="nextBtn" onclick="nextPrev(1)">Next
                </button>

            </div><!--/ btn container -->

            <!-- Circles which indicates the steps of the form: -->
            <div style="text-align:center;margin-top:-90px;">
                <span class="step finish"></span>
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div>

        </div>
    </div>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab");

            x[n].style.display = "block";
            if (n == 5) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
                document.getElementById("nextBtn").innerHTML = "Submit";


            } else {
                document.getElementsByClassName("step")[currentTab].className += " finish";
                document.getElementById("nextBtn").innerHTML = "Next";
            }
        }

        function nextPrev(n) {
        // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
            x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
        // if you have reached the end of the form... :
            if (currentTab >= 5) {
        //...the form gets submitted:
        //document.getElementById("regForm").submit();
                $('#announcement').hide();
                return false;
            }
        // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function Prevbtn(n) {
            if (currentTab >= 1) {
                var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        // if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
                x[currentTab].style.display = "none";
                currentTab = currentTab - n;
        //...the form gets submitted:
            } else {
        //currentTab = 0;
                return false;
            }
        // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
        // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
        // If a field is empty...
                if (y[i].value == "") {
        // add an "invalid" class to the field:
                    y[i].className += " invalid";
        // and set the current valid status to false:
                    valid = false;
                }
            }
        // If the valid status is true, mark the step as finished and valid:

        //alert(currentTab);
            var tt = document.getElementsByClassName("step");

            document.getElementsByClassName("step")[currentTab].className += " finish";

            return valid; // return the valid status
        }

    </script>
<?php }
$this->session->unset_userdata('welcome_message') ?>


<div class="container-fluid">
    <div class="row">


        <main role="main" class="right-section">
            <?php if ($this->session->flashdata('error_message')) { ?>
                <div class="alert alert-danger ">
                    <button class="close" data-close="alert"></button>
                    <span><?php echo $this->session->flashdata('error_message'); ?></span>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('success_message')) { ?>
                <div class="alert alert-success">
                    <button class="close" data-close="alert"></button>
                    <span><?php echo $this->session->flashdata('success_message'); ?></span>
                </div>
            <?php } ?>
            <div id="dashboard_data">

            </div>

            </div>
        </main>

</div>


<script>

    Loadr = new (function Loader(id) {
// # Defines
        const max_size = 24;
        const max_particles = 1500;
        const min_vel = 100;
        const max_generation_per_frame = 10;

// #Variables
// sometimes i wrote code horrible enouhg to make eyes bleed
        var canvas = document.getElementById(id);
        var ctx = canvas.getContext('2d');
        var height = canvas.height;
        var center_y = height / 2;
        var width = canvas.width;
        var center_x = width / 2;
        var animate = true;
        var particles = [];
        var last = Date.now(), now = 0;
        var died = 0, len = 0, dt;

        function isInsideHeart(x, y) {
            x = ((x - center_x) / (center_x)) * 3;
            y = ((y - center_y) / (center_y)) * -3;
// Simplest Equation of lurve
            var x2 = x * x;
            var y2 = y * y;
// Simplest Equation of lurve

            return (Math.pow((x2 + y2 - 1), 3) - (x2 * (y2 * y)) < 0);

        }

        function random(size, freq) {
            var val = 0;
            var iter = freq;

            do {
                size /= iter;
                iter += freq;
                val += size * Math.random();
            } while (size >= 1);

            return val;
        }

        function Particle() {
            var x = center_x;
            var y = center_y;
            var size = ~~random(max_size, 2.4);
            var x_vel = ((max_size + min_vel) - size) / 2 - (Math.random() * ((max_size + min_vel) - size));
            var y_vel = ((max_size + min_vel) - size) / 2 - (Math.random() * ((max_size + min_vel) - size));
            var nx = x;
            var ny = y;
            var r, g, b, a = 0.05 * size;

            this.draw = function () {
                r = ~~(255 * (x / width));
                g = ~~(255 * (1 - (y / height)));
                b = ~~(255 - r);
                ctx.fillStyle = 'rgba(' + r + ',' + g + ',' + b + ',' + a + ')';
                ctx.beginPath();
                ctx.arc(x, y, size, 0, Math.PI * 2, true);
                ctx.closePath();
                ctx.fill();
            }

            this.move = function (dt) {

                nx += x_vel * dt;
                ny += y_vel * dt;
                if (!isInsideHeart(nx, ny)) {
                    if (!isInsideHeart(nx, y)) {
                        x_vel *= -1;
                        return;
                    }

                    if (!isInsideHeart(x, ny)) {
                        y_vel *= -1;
                        return;
                    }
// Lets do the crazy furbidden
                    x_vel = -1 * y_vel;
                    y_vel = -1 * x_vel;
                    return;
                }

                x = nx;
                y = ny;
            }

        }

        function movementTick() {
            var len = particles.length;
            var dead = max_particles - len;
            for (var i = 0; i < dead && i < max_generation_per_frame; i++) {
                particles.push(new Particle());
            }

// Update the date
            now = Date.now();
            dt = last - now;
            dt /= 1000;
            last = now;
            particles.forEach(function (p) {
                p.move(dt);
            });
        }

        function tick() {

            ctx.clearRect(0, 0, width, height);
            particles.forEach(function (p) {
                p.draw();
            });

            requestAnimationFrame(tick);
        }


        setInterval(movementTick, 1);
        tick();

    })("loader");


</script>

<script>
    function getData() {
//div contains the loader
        $.get('<?php echo base_url();?>dashboard/get_dashboard_data', function (data) {
            $('#dashboard_data').html(data);
//hide the loader

            $('#spinner').fadeOut('');
            $('#loader').hide();
//build DataTable
        });
    }

    getData();


</script>
</body>
</html>
