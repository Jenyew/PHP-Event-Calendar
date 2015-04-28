<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Logs in the user by checking whether the username exists in the database first
 * then by checking if the password matches the database password.
 * @param string $email  The user logging in.
 * @param string $pass  Their password.
 * @return array  Success boolean on whether or not login was valid and errorMessage.
 */

function logIn($email,$pass) {
    //check if username exists
    $email = trim($email);
    $pass = trim($pass);
    if ($email == "") {
        return array("success" => false, "errorMessage" => "Email cannot be blank.");
    }
    if ($pass == "") {
        return array("success" => false, "errorMessage" => "Password cannot be blank.");
    }
    
    
        
    $db = new DB;
    $db->queryAssoc("select email, password from users where email = :email ", array("email" => $email));
    //If the email exists, it will return a row and count would be 1.
    if ($db->count < 1) {
        return array("success" => false, "errorMessage" => "Email does not exist.");
    }
    $result = $db->resultsArray[0];

    
    if (password_verify ($pass, $result["password"])) {
        //Checks if password entered matches actual password taken from database.
        $_SESSION["userLoggedIn"] = true;
            return array("success" => true, "errorMessage" => "");
    } else {
            return array("success" => false, "errorMessage" => "Incorrect password!");
    }
}

function logOut() {
    session_destroy();
}

function saveUserData() {
    //Validate input
    if ($example == "") {
        return $error; //Data cannot be blank.
    }
    
    
    
    //Save data to database if there are no issues.
}

function loadUserData() {
    //Load data from a row for user from database.
}

function createUser() {
    //Validate user input
    //and insert new row to database.
}

function deleteUser() {
    //Delete row in database.
}

function loadAllUsers() {
    //Load data for all users from database.
}

function showProfile() {
    //Show profile in main part of dashboard.
    print "This is my profile!";
}

function showAccount() {
    //Show account info in main part of dashboard.
    print "This is my account info!";
}

function showUsers() {
    //Show all users in main part of dashboard.
    print "These are all the users!";
}

function showNewUser($data = array()) {
    //Show create new user in main part of dashboard.
    print "This is where I create new users!";
    //Need email, first name, last name, password.
    if ($data["password"] !== $data["password2"]) {
        $data["error"] = true;
        $data["errorMessage"] = "Passwords do not match.";
    }
    print '<form class="form-signin" action ="dashboard.php?view=newUser" method ="POST" name ="new_user">
        <h2 class="form-signin-heading">Please Enter New User Information</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email"  value="'.$data["email"].'" type="email" id="inputEmail" class="form-control" placeholder ="Email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPassword2" class="sr-only">Password2</label>
        <input name="password2" type="password" id="inputPassword2" class="form-control" placeholder="Re-Enter Password" required>
        <label for="inputFirstName" class="sr-only">First Name</label>
        <input name="first_name" value="'.$data["first_name"].'" type="text" id="inputFirstName" class="form-control" placeholder="First Name" required>
        <label for="inputLastName" class="sr-only">Last Name</label>
        <input name="last_name" value="'.$data["last_name"].'" type="text" id="inputLastName" class="form-control" placeholder="Last Name" required>
        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Create New User</button>
      </form>';
    return $data;
}
