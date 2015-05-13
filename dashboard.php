<?php
include ("lib/Init.php");
if (!isset($_SESSION["uid"])){
    session_destroy();
    session_start();
    header('Location: login.php');
    print 'You need to <a href="login.php">Log In</a>.';
    exit;
}
//Check the page we're looking at.
if (isset($_GET["view"])) {
    if ($_GET["view"] === "profile") {
        $currentNav = "profile";
    } else if ($_GET["view"] === "addEvent") {
        $currentNav = "addEvent";
    } else if ($_GET["view"] === "allEvents") {
        $currentNav = "allEvents";
    } else if ($_GET["view"] === "allCategories") {
        $currentNav = "allCategories";
    } else if ($_GET["view"] === "account") {
        $currentNav = "account";
    } else if ($_GET["view"] === "users") {
        $currentNav = "users";
    } else if ($_GET["view"] === "newUser") {
        $currentNav = "newUser";
    } else if ($_GET["view"] === "category") {
        $currentNav = "category";
    } else if ($_GET["view"] === "deleteCategory") {
        $currentNav = "deleteCategory";
    } else if ($_GET["view"] === "editEvent") {
        $currentNav = "editEvent";
    } else {
        $currentNav = "overview";
    }
} else {
    $currentNav = "overview";
}
?>
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

        <title>Calendar Dashboard</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/dashboard.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="css/jquery-ui.css">
        <script src="js/jquery.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="css/anytime.css" />
        <script src="js/anytime.js"></script>
        
        
        
        
<!--        <script>
            $(function () {
                $("#datepicker").datepicker();
            });
        </script>-->


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Event Calendar</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <!--<li><a href="#">Settings</a></li>-->
                        <li><a href="dashboard.php?view=profile">Profile</a></li>
                        <li><a href="login.php?status=logout">Log Out</a></li>
                    </ul>
                    <form class="navbar-form navbar-right">
                        <input type="text" class="form-control" placeholder="Search...">
                    </form>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li <?php
                        if ($currentNav == "overview") {
                            print 'class="active"';
                        }
                        ?> ><a href="dashboard.php?view=overview">Overview <span class="sr-only">(current)</span></a></li>
                        <li <?php
                        if ($currentNav == "addEvent") {
                            print 'class="active"';
                        }
                        ?> ><a href="dashboard.php?view=addEvent">Add Event</a></li>
                        <li <?php
                            if ($currentNav == "allEvents") {
                                print 'class="active"';
                            }
                            ?> ><a href="dashboard.php?view=allEvents">View All Events</a></li>
                        <li <?php
                            if ($currentNav == "allCategories") {
                                print 'class="active"';
                            }
                            ?> ><a href="dashboard.php?view=allCategories">View All Categories</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li <?php
                        if ($currentNav == "account") {
                            print 'class="active"';
                        }
                            ?> ><a href="dashboard.php?view=account">Account Settings</a></li>
                        <li <?php
                        if ($currentNav == "users") {
                            print 'class="active"';
                        }
                            ?> ><a href="dashboard.php?view=users">List All Users</a></li>
                        <li <?php
                        if ($currentNav == "newUser") {
                            print 'class="active"';
                        }
                            ?> ><a href="dashboard.php?view=newUser">Create New User</a></li>
                        <!--<li><a href=""></a></li>-->
                        <!--<li><a href="">More navigation</a></li>-->
                    </ul>
                    <!--<ul class="nav nav-sidebar">-->
                    <!--<li><a href="">Nav item again</a></li>-->
                    <!--<li><a href="">One more nav</a></li>-->
                    <!--<li><a href="">Another nav item</a></li>-->
                    <!--</ul>-->
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                    <?php
                    if (isset($_GET["view"])) {
                        if ($_GET["view"] === "profile") {
                            print '<h1 class="page-header">Profile</h1>';
                            showProfile();
                        } else if ($_GET["view"] === "addEvent") {
                            if (isset($_POST["submit"])) {
                                print '<h1 class="page-header">Add New Event</h1>';
                                $data = showAddEvent($_POST);
                            } else {
                                print '<h1 class="page-header">Add New Event</h1>';
                                showAddEvent();
                            }
                        } else if ($_GET["view"] === "allEvents") {
                            print '<h1 class="page-header">All Events</h1>';
                            showAllEvents();
                        } else if ($_GET["view"] === "allCategories") {
                            
                            if (isset($_POST["submit"])) {
                                print '<h1 class="page-header">Categories</h1>';
                                $data = showAllCategories($_POST);
                            } else {
                                print '<h1 class="page-header">Categories</h1>';
                                showAllCategories();
                            }
                        
                        } else if ($_GET["view"] === "account") {
                            if (isset($_POST["submit"])) {
                                print '<h1 class="page-header">Account Settings</h1>';
                                $data = showAccount($_POST);
                            } else {
                                print '<h1 class="page-header">Account Settings</h1>';
                                showAccount();
                            }
                        } else if ($_GET["view"] === "users") {
                            print '<h1 class="page-header">All Users</h1>';
                            showUsers();
                        } else if ($_GET["view"] === "newUser") {
                            if (isset($_POST["submit"])) {
                                print '<h1 class="page-header">Add New User</h1>';
                                $data = showNewUser($_POST);
                            } else {
                                print '<h1 class="page-header">Add New User</h1>';
                                showNewUser();
                            }
                        } else if ($_GET["view"] === "category") {
                            showCategory($_GET["id"]);
                        } else if ($_GET["view"] === "deleteCategory") {
                            showDeleteCategory($_GET["id"]);
                        } else {
                            print '<h1 class="page-header">Overview</h1>';
                        }
                    } else {
                        print '<h1 class="page-header">Overview</h1>';
                    }
                    ?>
                    <!--
                              <div class="row placeholders">
                                <div class="col-xs-6 col-sm-3 placeholder">
                                  <img data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail">
                                  <h4>Label</h4>
                                  <span class="text-muted">Something else</span>
                                </div>
                                <div class="col-xs-6 col-sm-3 placeholder">
                                  <img data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail">
                                  <h4>Label</h4>
                                  <span class="text-muted">Something else</span>
                                </div>
                                <div class="col-xs-6 col-sm-3 placeholder">
                                  <img data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail">
                                  <h4>Label</h4>
                                  <span class="text-muted">Something else</span>
                                </div>
                                <div class="col-xs-6 col-sm-3 placeholder">
                                  <img data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail">
                                  <h4>Label</h4>
                                  <span class="text-muted">Something else</span>
                                </div>
                              </div>
                    
                              <h2 class="sub-header">Section title</h2>
                              <div class="table-responsive">
                                <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Header</th>
                                      <th>Header</th>
                                      <th>Header</th>
                                      <th>Header</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>1,001</td>
                                      <td>Lorem</td>
                                      <td>ipsum</td>
                                      <td>dolor</td>
                                      <td>sit</td>
                                    </tr>
                                    <tr>
                                      <td>1,002</td>
                                      <td>amet</td>
                                      <td>consectetur</td>
                                      <td>adipiscing</td>
                                      <td>elit</td>
                                    </tr>
                                    <tr>
                                      <td>1,003</td>
                                      <td>Integer</td>
                                      <td>nec</td>
                                      <td>odio</td>
                                      <td>Praesent</td>
                                    </tr>
                                    <tr>
                                      <td>1,003</td>
                                      <td>libero</td>
                                      <td>Sed</td>
                                      <td>cursus</td>
                                      <td>ante</td>
                                    </tr>
                                    <tr>
                                      <td>1,004</td>
                                      <td>dapibus</td>
                                      <td>diam</td>
                                      <td>Sed</td>
                                      <td>nisi</td>
                                    </tr>
                                    <tr>
                                      <td>1,005</td>
                                      <td>Nulla</td>
                                      <td>quis</td>
                                      <td>sem</td>
                                      <td>at</td>
                                    </tr>
                                    <tr>
                                      <td>1,006</td>
                                      <td>nibh</td>
                                      <td>elementum</td>
                                      <td>imperdiet</td>
                                      <td>Duis</td>
                                    </tr>
                                    <tr>
                                      <td>1,007</td>
                                      <td>sagittis</td>
                                      <td>ipsum</td>
                                      <td>Praesent</td>
                                      <td>mauris</td>
                                    </tr>
                                    <tr>
                                      <td>1,008</td>
                                      <td>Fusce</td>
                                      <td>nec</td>
                                      <td>tellus</td>
                                      <td>sed</td>
                                    </tr>
                                    <tr>
                                      <td>1,009</td>
                                      <td>augue</td>
                                      <td>semper</td>
                                      <td>porta</td>
                                      <td>Mauris</td>
                                    </tr>
                                    <tr>
                                      <td>1,010</td>
                                      <td>massa</td>
                                      <td>Vestibulum</td>
                                      <td>lacinia</td>
                                      <td>arcu</td>
                                    </tr>
                                    <tr>
                                      <td>1,011</td>
                                      <td>eget</td>
                                      <td>nulla</td>
                                      <td>Class</td>
                                      <td>aptent</td>
                                    </tr>
                                    <tr>
                                      <td>1,012</td>
                                      <td>taciti</td>
                                      <td>sociosqu</td>
                                      <td>ad</td>
                                      <td>litora</td>
                                    </tr>
                                    <tr>
                                      <td>1,013</td>
                                      <td>torquent</td>
                                      <td>per</td>
                                      <td>conubia</td>
                                      <td>nostra</td>
                                    </tr>
                                    <tr>
                                      <td>1,014</td>
                                      <td>per</td>
                                      <td>inceptos</td>
                                      <td>himenaeos</td>
                                      <td>Curabitur</td>
                                    </tr>
                                    <tr>
                                      <td>1,015</td>
                                      <td>sodales</td>
                                      <td>ligula</td>
                                      <td>in</td>
                                      <td>libero</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>-->
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="js/ie10-viewport-bug-workaround.js"></script>
        <script>
        AnyTime.picker( "field1",
          { format: "%W, %M %D, %z - %h:%i %p", firstDOW: 1 } );
       
        </script>
<!--        <script>
            $(function () {
                $("#datepicker").datepicker();
            });
        </script>-->
    </body>
</html>