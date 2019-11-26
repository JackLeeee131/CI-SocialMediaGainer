
    <style>
        #graph,
        #graph2,
        #graph3{
            min-height: 250px;
        }
        #graph3 svg {
            height: 262px;
        }
    </style>
<body>

<div class="container-fluid">
    <div class="row">

        <main role="main" class="right-section">

            <h1 class="heading">Analytics</h1>

            <section class="row text-center placeholders">

                <div class="col-lg-12">
                <div class="form-row">
                    <div class="col-lg-12 col-sm-3">
                        <div class="btn-group pull-left" role="group" aria-label="...">
                                    <select class="custom-select mr-sm-8" id="inlineFormCustomSelect" onchange="get_month_data($('.btn-default.active').attr('id'), this.value)">
                                        <option value="" selected>All Instagram Accounts</option>

                                        <?php foreach($user_detail as $ig_accounts) { ?>
                                        <option value="<?php echo $ig_accounts['order_id']; ?>" > <?php echo ucfirst($ig_accounts['instagram_name']); ?></option>
                                        <?php } ?>
                                        <?php if(count($user_detail) == 0) { ?>

                                            <option value=""> No Account Found </option>

                                        <?php } ?>
                                    </select>
                        </div>

                        <div class="btn-group pull-right" role="group" aria-label="...">
                            <button id="all" type="button" class="btn btn-default active" onclick="get_month_data('all', $('#inlineFormCustomSelect').val())">All Engagements</button>
                            <button id="likes" type="button" class="btn btn-default" onclick="get_month_data('likes', $('#inlineFormCustomSelect').val())">Likes</button>
                            <button id="views" class="btn btn-default" onclick="get_month_data('views', $('#inlineFormCustomSelect').val())">Views</button>
                            <button id="comments" class="btn btn-default" onclick="get_month_data('comments', $('#inlineFormCustomSelect').val())">Comments</button>
                            <button id="followers" class="btn btn-default" onclick="get_month_data('followers', $('#inlineFormCustomSelect').val())">Followers</button>
                        </div>

                    </div>
                </div>

                </div>


                <div class="col-lg-12">

                    <div class="boxstyle text-left margin-bottom text-center">
                        <h6 class="chart_heading">Line Chart Month</h6>
                        <div id="graph"></div>
                        <script>
                            // Use Morris.Bar
                            var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

                            Morris.Line({
                                element: 'graph',
                                data: [
                                    <?php
                                    foreach($month_analytics as $month) {
                                        echo json_encode($month).',';
                                    }

                                    ?>
                                ],
                                xkey: 'month',
                                ykeys: ['likes', 'views', 'comments', 'followers'],
                                labels: ['Likes', 'Views', 'comments', 'Followers'],
                                xLabelFormat: function(x) { // <--- x.getMonth() returns valid index
                                    var month = months[x.getMonth()];
                                    return month;
                                },
                                dateFormat: function(x) {
                                    var month = months[new Date(x).getMonth()];
                                    return month;
                                }
                            });
                        </script>


                        <div class="clearfix"></div>
                    </div>

                    <div class="clearfix"></div>
                </div>


                <script>

                      function get_month_data(type, order_id) {
                          $("#graph").empty();
                          $("#graph2").empty();
                          $.ajax({
                              url: '<?php echo base_url();?>analytics/get_month_data',
                              dataType: 'JSON',
                              type: 'POST',
                              data: {type: type, order_id:order_id},
                              success: function(response) {

                                  if (type == "all") {

                                      if(order_id == "") {


                                          Morris.Line({
                                              element: 'graph',
                                              data: [
                                                  <?php
                                                  foreach ($month_analytics as $month) {
                                                      echo json_encode($month) . ',';
                                                  }
                                                  ?>
                                              ],
                                              xkey: 'month',
                                              ykeys: ['likes', 'views', 'comments', 'followers'],
                                              labels: ['Likes', 'Views', 'comments', 'Followers'],
                                              xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
                                                  var month = months[x.getMonth()];
                                                  return month;
                                              },
                                              dateFormat: function (x) {
                                                  var month = months[new Date(x).getMonth()];
                                                  return month;
                                              }
                                          });


                                          // Graph2 is a month Bar Chart

                                          Morris.Bar({
                                              element: 'graph2',
                                              data: [
                                                  <?php
                                                  foreach ($month_analytics as $month) {
                                                      echo json_encode($month) . ',';
                                                  }
                                                  ?>
                                              ],
                                              xkey: 'month',
                                              ykeys: ['likes', 'views', 'comments', 'followers'],
                                              labels: ['Likes', 'Views', 'comments', 'Followers'],

                                          });



                                      } else {

                                          Morris.Line({
                                              element: 'graph',
                                              data: response,
                                              xkey: 'month',
                                              ykeys: ['likes', 'views', 'comments', 'followers'],
                                              labels: ['Likes', 'Views', 'comments', 'Followers'],
                                              xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
                                                  var month = months[x.getMonth()];
                                                  return month;
                                              },
                                              dateFormat: function (x) {
                                                  var month = months[new Date(x).getMonth()];
                                                  return month;
                                              }
                                          });


                                          // Graph2 is a month Bar Chart

                                          Morris.Bar({
                                              element: 'graph2',
                                              data: response,
                                              xkey: 'month',
                                              ykeys: ['likes', 'views', 'comments', 'followers'],
                                              labels: ['Likes', 'Views', 'comments', 'Followers'],

                                          });

                                      }


                                  } else {
                                      Morris.Line({
                                          element: 'graph',
                                          data: response,
                                          xkey: 'month',
                                          ykeys: ['total', 'avg'],
                                          labels: ['Total ' + type, 'Average ' + type],
                                          hideHover: 'auto',
                                          resize: true,
                                          xLabelAngle: 60,
                                          xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
                                              var month = months[x.getMonth()];
                                              return month;
                                          },
                                          dateFormat: function (x) {
                                              var month = months[new Date(x).getMonth()];
                                              return month;
                                          }
                                      });

                                      Morris.Bar({
                                          element: 'graph2',
                                          data: response,
                                          xkey: 'month',
                                          ykeys: ['total'],
                                          labels: ['Total ' + type],
                                          hideHover: 'auto',
                                          resize: true,
                                          xLabelAngle: 30,
                                      });
                                  }
                              }
                          });
                      }

                      function get_account_data(order_id) {

                          $("#graph").empty();
                          $("#graph2").empty();
                          $.ajax({
                              url: '<?php echo base_url();?>analytics/get_month_data',
                              dataType: 'JSON',
                              type: 'POST',
                              data: {type: type},
                              success: function(response) {


                                  if (type == "all") {

                                      Morris.Line({
                                          element: 'graph',
                                          data: [
                                              <?php
                                              foreach($month_analytics as $month) {
                                                  echo json_encode($month).',';
                                              }
                                              ?>
                                          ],
                                          xkey: 'month',
                                          ykeys: ['likes', 'views', 'comments', 'followers'],
                                          labels: ['Likes', 'Views', 'comments', 'Followers'],
                                          xLabelFormat: function(x) { // <--- x.getMonth() returns valid index
                                              var month = months[x.getMonth()];
                                              return month;
                                          },
                                          dateFormat: function(x) {
                                              var month = months[new Date(x).getMonth()];
                                              return month;
                                          }
                                      });


                                      // Graph2 is a month Bar Chart

                                      Morris.Bar({
                                          element: 'graph2',
                                          data: [
                                              <?php
                                              foreach($month_analytics as $month) {
                                                  echo json_encode($month).',';
                                              }
                                              ?>
                                          ],
                                          xkey: 'month',
                                          ykeys: ['likes', 'views', 'comments', 'followers'],
                                          labels: ['Likes', 'Views', 'comments', 'Followers'],

                                      });


                                  } else {
                                      Morris.Line({
                                          element: 'graph',
                                          data: response,
                                          xkey: 'month',
                                          ykeys: ['total'],
                                          labels: ['Total ' + type],
                                          hideHover: 'auto',
                                          resize: true,
                                          xLabelAngle: 60,
                                          xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
                                              var month = months[x.getMonth()];
                                              return month;
                                          },
                                          dateFormat: function (x) {
                                              var month = months[new Date(x).getMonth()];
                                              return month;
                                          }
                                      });
                                      // Graph2 is a month Bar Chart

                                      Morris.Bar({
                                          element: 'graph2',
                                          data: response,
                                          xkey: 'month',
                                          ykeys: ['total'],
                                          labels: ['Total ' + type],
                                          hideHover: 'auto',
                                          resize: true,
                                          xLabelAngle: 30,
                                      });
                                  }
                              }
                          });

                      }


                </script>
                <div class="clearfix"></div>

                <div class="col-lg-6 col-sm-6">

                    <div class="boxstyle text-left margin-bottom text-center">
                        <h6 class="chart_heading">Bar Chart Month</h6>
                        <div id="graph2" class="prettyprint linenums"></div>
                        <script>
                            /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
                            var month_data = [
                                {"month": "Jan", "licensed": 3407, "sorned": 660},
                                {"month": "Feb", "licensed": 3351, "sorned": 629},
                                {"month": "Jun", "licensed": 2000, "sorned": 250}
                            ];
                            Morris.Bar({
                                element: 'graph2',
                                data: [
                                    <?php
                                    foreach($month_analytics as $month) {
                                        echo json_encode($month).',';
                                    }
                                    ?>
                                    ],
                                xkey: 'month',
                                ykeys: ['likes', 'views', 'comments', 'followers'],
                                labels: ['Likes', 'Views', 'comments', 'Followers'],
                                resize: true

                            });
                        </script>
                        <div class="clearfix"></div>
                    </div>

                </div><!-- / col lg sm 6 -->

                <div class="col-lg-6 col-sm-6">

                    <div class="boxstyle text-left margin-bottom text-center">
                        <h6 class="chart_heading">Bar Chart Year</h6>
                        <div id="graph3" class="prettyprint linenums"></div>
                        <script>

                            // Use Morris.Area instead of Morris.Line
                            var month_data = [
                                {"period": "2012", "licensed": 3407, "sorned": 660},
                                {"period": "2011", "licensed": 3351, "sorned": 629},
                                {"period": "2011", "licensed": 3269, "sorned": 618}
                            ];

                            Morris.Bar({
                                element: 'graph3',
                                data: [
                                    <?php
                                    foreach($year_analytics as $year) {
                                        echo json_encode($year).',';
                                    }
                                    ?>
                                ],
                                xkey: 'year',
                                ykeys: ['likes', 'views', 'comments', 'followers'],
                                labels: ['Likes', 'Views', 'comments', 'Followers'],
                                resize: true

                            });
                        </script>
                    </div>

                </div>

                <div class="clearfix"></div>
            </section>


        </main>


    </div>
</div>



    <script>
        $('body').on('click', 'button', function() {
        $('button.active').removeClass('active');
        $(this).addClass('active');
        });
    </script>



</body>
</html>
