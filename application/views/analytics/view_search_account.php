<style>
    #graph,
    #graph2,
    #graph3 {
        min-height: 250px;
    }
    #graph3 svg {
        height: 262px;
    }
    .card-body {
        padding: 1rem
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

    #chartdiv {

        width: 100%;

        height: 500px;

    }


</style>


<script src="https://code.highcharts.com/highcharts.js"></script>

<script src="https://code.highcharts.com/modules/series-label.js"></script>

<script src="https://code.highcharts.com/modules/exporting.js"></script>


<body id="analytics">


<div class="loader" id="spinner" style="display:none  ">

    <canvas width="480px" height="480px" id="loader"></canvas>

    <h1>Loading</h1>

</div>


<div class="container-fluid" id="analytics_content">

    <div class="row">


        <main role="main" class="right-section">


            <h1 class="heading">Analytics</h1>


            <section class="row placeholders">


                <div class="col-lg-12">


                    <div class="account">

                        <div class="top-bar">

                            <div class="user-info">

                                <div class="profile-picture">

                                    <img src="<?php echo $profile_pic; ?>" class="avatar" width="56px" height="56px">

                                </div>

                                <div class="user-bio">

                                    <div class="names">

                                        <a href="https://www.instagram.com/chrissullivan794"
                                           style="display: inline-block;" class="profile-url"

                                           target="_blank"><p class="name"
                                                              style="color: black; font-weight: bold; font-size: 18px; margin-bottom: 0"><?php echo $searched_account; ?></p>
                                        </a>

                                        <p class="username" style="margin-bottom: 0">

                                            @<span><?php echo $instagram_username; ?></span></p>

                                    </div>

                                    <p class="bio"><span></span> <?php echo $instagram_profile_detail; ?></p>

                                </div>

                            </div>

                        </div>


                        <div class="account-info">

                            <div class="posts">

                                <p><?php echo $total_posts; ?></p>

                                <span>Total Posts</span>

                            </div>

                            <div class="followers">

                                <p><?php echo $total_followed_by; ?></p>

                                <span>Followers</span>

                            </div>

                            <div class="following">

                                <p><?php echo $total_followers; ?></p>

                                <span>Following</span>

                            </div>
                            <div class="avg-likes">

                                <p><?php echo number_format($instagram_data['avg_likes']); ?></p>

                                <span>Avg Likes</span>

                            </div>

                            <div class="avg-retweets">

                                <p><?php echo number_format($instagram_data['avg_comments']); ?></p>

                                <span>Avg Comments</span>

                            </div>

                            <div class="avg-engRate">

                                <p><?php

                                    $avg_likes_comments = $instagram_data['avg_likes'] + $instagram_data['avg_comments'];

                                    if (!empty($total_followed_by)) {
                                        $avg_engRate = ($avg_likes_comments / $total_followed_by) * 100;

                                        echo number_format($avg_engRate, 2) . '%';
                                    } else {
                                        echo '0%';
                                    }

                                    ?>

                                </p>

                                <span>Avg Engagement Rate</span>

                            </div>

                        </div>

                    </div>


                    <div class="clearfix"></div>

                    <br><br>


                    <div class="form-row">

                        <div class="col-lg-12 col-sm-3">

                            <div class="btn-group pull-left" role="group" aria-label="...">


                            </div>


                            <div class="btn-group pull-right" role="group" aria-label="...">

                                <button id="all" type="button" class="btn btn-default active"

                                        onclick="get_month_data('all', $('#inlineFormCustomSelect').val())">

                                    Engagements

                                </button>

                                <button id="likes" type="button" class="btn btn-default"

                                        onclick="get_month_data('likes', $('#inlineFormCustomSelect').val())">Likes

                                </button>

                                <button id="comments" class="btn btn-default"

                                        onclick="get_month_data('comments', $('#inlineFormCustomSelect').val())">

                                    Comments

                                </button>


                            </div>


                        </div>

                    </div>


                </div>

                <div class="col-lg-12">


                    <div class="boxstyle text-left margin-bottom text-center">

                        <h6 class="chart_heading">Data From current year and last 12 Posts</h6>

                        <div id="graph" class="prettyprint linenums"></div>

                        <script>
                            Morris.Bar({

                                element: 'graph',

                                data: [

                                    <?php

                                    foreach ($month_analytics as $month) {
                                        echo json_encode($month) . ',';
                                    }

                                    ?>

                                ],


                                xkey: 'month',

                                ykeys: ['Total Posts'],

                                labels: ['Posts']


                            });

                        </script>


                        <div class="clearfix"></div>

                    </div>


                    <div class="clearfix"></div>

                </div>


                <script>


                    function get_month_data(type, order_id) {


                        $('#spinner').css('display', 'block');

                        $('.container-fluid').css('opacity', '0.03');


                        if (type == 'all') {

                            $("#graph").empty();

                            Morris.Bar({

                                element: 'graph',

                                data: [

                                    <?php

                                    foreach ($month_analytics as $month) {
                                        echo json_encode($month) . ',';
                                    }

                                    ?>

                                ],


                                xkey: 'month',

                                ykeys: ['Total Posts'],

                                labels: ['Posts']


                            });


                            $('#spinner').css('display', 'none');

                            $('.container-fluid').css('opacity', 'unset');

                        } else {


                            $("#graph").empty();

                            var searched_account = "<?php echo $searched_account; ?>";

                            $.ajax({

                                url: '<?php echo base_url();?>analytics/search_account',

                                dataType: 'JSON',

                                type: 'POST',

                                data: {type: type, searched_account: searched_account},

                                timeout: 100000,

                                success: function (response) {

                                    Morris.Bar({

                                        element: 'graph',

                                        data: response,

                                        xkey: 'month',

                                        ykeys: ['total'],

                                        labels: ['Total ' + type],

                                        hideHover: 'auto',

                                        resize: true

                                    });

                                },

                                complete: function () {

                                    $('#spinner').css('display', 'none');

                                    $('.container-fluid').css('opacity', 'unset');


                                },

                                error: function (xmlhttprequest, textstatus, message) {

                                    if (textstatus === "timeout") {

                                        alert("Timeout");

                                    } else {

                                        alert(textstatus);

                                    }

                                }


                            });


                        }


                    }


                </script>


            </section>


        </main>


    </div>

</div>


<script>

    $('body').on('click', 'button', function () {

        $('button.active').removeClass('active');

        $(this).addClass('active');

    });

</script>


<script>


    Loadr = new (function Loadr(id) {

        // # Defines

        const max_size = 24;

        const max_particles = 1500;

        const min_vel = 20;

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


        this.start = function () {


        }


        this.done = function () {


        }


        setInterval(movementTick, 16);

        tick();


    })("loader");


    $(document).ready(function () {

        $('.heading').css('right', 'calc(50% - 87px)');

    });


</script>

</body>

</html>

