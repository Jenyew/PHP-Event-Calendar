<?php
        include("lib/Init.php");
        if (isset($_POST['submit'])) {
           $loggedIn = logIn($_POST["username"],$_POST["password"]);
            if ($loggedIn["success"]) {
                print "I am logged in!<br />";

            } else {
                print "I am not logged in. D= <br />";
                print $loggedIn["errorMessage"];
            }
        }
       
       $db = new DB;
       $db->queryAssoc("select email from users where email = \"test2@test.com\" ", array());
       $result = $db->resultsArray;
       print "<pre>";
        print_r ($result);
        //Try to make the login function work in Users.php
       
       /*
       
       
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
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action ="login.php" method ="POST" name ="login">
            <input type ="text" placeholder ="username" name ="username">
            <input type ="password" placeholder ="password" name ="password">
            <input type ="submit" value ="login">    
        </form>
    </body>
</html>