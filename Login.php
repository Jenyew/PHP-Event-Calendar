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
        <pre>
        <?php
        // put your code here
       include("lib/Users.php");
       $loggedIn = logIn($_POST["username"],$_POST["password"]);
       if ($loggedIn) {
           print "I am logged in!";
         
       } else {
           print "I am not logged in. D=";
       }
        $_POST["face"]["something"] = "Hello";
       print_r ($_POST);
       print "My Username is " . $_POST["username"];
       print "<br />";
       print "My Password is " . $_POST["face"]["something"];
        ?>
        </pre>
    </body>
</html>
