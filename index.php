<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <!--<link rel="icon" href="../../favicon.ico">-->

        <title>PHP Event Calendar</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/justified-nav.css" rel="stylesheet">

        <!-- FullCalendar -->
        <link rel='stylesheet' href='css/fullcalendar.css' />
        <script src='js/jquery.js'></script>
        <script src='js/moment.js'></script>
        <script src='js/fullcalendar.min.js'></script>
        
        <link rel='stylesheet' href='css/jquery.qtip.css' />
        <script src='js/jquery.qtip.min.js'></script>
        

        
        <script>
            $(document).ready(function() {

                // page is now ready, initialize the calendar...

                $('#calendar').fullCalendar({
                    // put your options and callbacks here
                    events: [
                        <?php
                        //load all events
                        include("lib/Init.php");
                        $db = new DB;
                        $db->queryAssoc("SELECT * FROM events");
                        $results = $db->resultsArray;
                        //set $first true
                        $first = true;
                        //foreach
                        foreach ($results as $result) {
                            //if first { set first = false;
                            if ($first) {
                                $first = false;
                            }
                            //} else { print "},"; }
                            else {
                                print "},";
                            }
                            //print all array elements
                            print "id     : " . "'" . $result["id"] . "'" . ",<br />";
                            print "title  : " . "'" . $result["title"] . "'" . ",<br />";
                            print "start  : " . "'" . $result["start"] . "'" . ",<br />";
                            print "end    : " . "'" . $result["end"] . "'" . ",<br />";
                            print "description: " . "'" . $result["description"] . "'";
                        }
                        //end foreach
                        print "}";
                        
                        ?>
                        {
                            id     : '1',
                            title  : 'event1',
                            start  : '2015-05-13',
                            //url    : 'index.php?event=1',
                            description: 'This is a cool event'
                        },
                        {
                            title  : 'event2',
                            start  : '2015-05-13',
                            end    : '2015-05-14'
                        },
                        {
                            title  : 'event2',
                            start  : '2015-05-13',
                            end    : '2015-05-16'
                        },
                        {
                            title  : 'event3',
                            start  : '2015-05-13T12:30:00',
                            allDay : false // will make the time show
                        }
                    ],
                    eventRender: function(event, element) {
                        element.qtip({
                            content: event.description
                        });
                    }
                })

            });
        </script>
        
 
            
            
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="container">

            <!-- The justified navigation menu is meant for single line per list item.
                 Multiple lines will require custom code not provided by Bootstrap. -->
            <div class="masthead">
                 <div class="row">
                    <div class="col-lg-8">
                        <h3 class="text-muted">PHP Event Calendar <span style="font-size: 0.5em; font-style: italic;">//By Robbert Press</span></h3>
                    </div>
                     <div class="col-lg-4" style="text-align: right;">
                        <a href = "dashboard.php" class="btn btn-lg btn-primary ">Log In</a>
                    </div>
                 </div>
                
<!--                <nav>
                    <ul class="nav nav-justified">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Downloads</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>-->
            </div>

            <!-- Jumbotron -->
            <div class="jumbotron">
                <div id='calendar'></div>
<!--                <h1>Marketing stuff!</h1>
                <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet.</p>
                <p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p>-->
            </div>

            <!-- Example row of columns -->
<!--            <div class="row">
                <div class="col-lg-4">
                    <h2>Safari bug warning!</h2>
                    <p class="text-danger">As of v8.0, Safari exhibits a bug in which resizing your browser horizontally causes rendering errors in the justified nav that are cleared upon refreshing.</p>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <h2>Heading</h2>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <h2>Heading</h2>
                    <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
                    <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
                </div>
            </div>-->

            <!-- Site footer -->
            <footer class="footer">
                <p>&copy; Robbert Press 2015</p>
            </footer>

        </div> <!-- /container -->


        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>
