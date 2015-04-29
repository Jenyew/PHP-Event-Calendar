<?php
        include("lib/Init.php");

       
       /*
       $db = new DB;
       $db->queryAssoc("select email, password from users where email = \"test2@test.com\" ", array());
       $result = $db->resultsArray;
       print "<pre>";
        print_r ($result);
        print "<br />";
        print_r ($_POST);
        //Try to make the login function work in Users.php
       
       
       
       $loggedIn = logIn($_POST["username"],$_POST["password"]);
       if ($loggedIn["success"]) {
           print "I am logged in!<br />";
         
       } else {
           print "I am not logged in. D= <br />";
           print $loggedIn["errorMessage"];
       }
        $_POST["face"]["something"] = "Hello";
       print "<pre>";
        print_r ($_POST);
       print "</pre>";
       print "My Username is " . $_POST["username"];
       print "<br />";
       print "My Password is " . $_POST["face"]["something"];
       */ ?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action ="login.php" method ="POST" name ="login">
            <input type ="text" placeholder ="email" name ="email">
            <input type ="password" placeholder ="password" name ="password">
            <input type ="submit" value ="login" name="submit">    
        </form>
    </body>
</html>
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
<!--    <link rel="icon" href="../../favicon.ico">-->

    <title>Calendar Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
<?php
        if (isset($_POST['submit'])) {
           $loggedIn = logIn($_POST["email"],$_POST["password"]);
            if ($loggedIn["success"]) {
                print "<div class=\"alert alert-info\" role=\"alert\">";
                print "I am logged in!<br />";
                print "</div>";

            } else {
                print "<div class=\"alert alert-danger\" role=\"alert\">";
                print "I am not logged in. D= <br />";
                print $loggedIn["errorMessage"];
                print "</div>";
            }
        }
?>
        
        

        
      
      <form class="form-signin" action ="login.php" method ="POST" name ="login">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder ="Email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign In</button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
