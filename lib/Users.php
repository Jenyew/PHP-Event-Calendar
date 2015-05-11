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
function logIn($email, $pass) {
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
    $db->queryAssoc("select * from users where email = :email ", array("email" => $email));
    //If the email exists, it will return a row and count would be 1.
    if ($db->count < 1) {
        return array("success" => false, "errorMessage" => "Email does not exist.");
    }
    $result = $db->resultsArray[0];

    if (password_verify($pass, $result["password"])) {
        //Checks if password entered matches actual password taken from database.
        //check if user account is active
        if (!$result["active"]) {
            return array("success" => false, "errorMessage" => "This account has been disabled. Please contact and administrator.");
        }

        //check if account has expired
        //if ( expire time is < current time) {
        //update database: set account active to false.
        //error message and return "Your account has expired. Please contact and administrator."
        //}
        //save user info in SESSION
        $_SESSION["userLoggedIn"] = true;
        $_SESSION["uid"] = $result["id"];
        $_SESSION["email"] = $result["email"];
        $_SESSION["first_name"] = $result["firstName"];
        $_SESSION["last_name"] = $result["lastName"];

        return array("success" => true, "errorMessage" => "");
    } else {
        return array("success" => false, "errorMessage" => "Incorrect password!");
    }
}

function logOut() {
    session_destroy();
}

function saveUserData($data) {
    //Validate input
    $data["email"] = trim($data["email"]);
    $data["first_name"] = trim($data["first_name"]);
    $data["last_name"] = trim($data["last_name"]);

    if ($data["email"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Email cannot be empty.";
    }
    if ($data["first_name"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Please enter first name.";
    }
    if ($data["last_name"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Please enter last name.";
    }
    if ($data["error"]) {
        return $data;
    }


    //Save data to database if there are no issues.
    //update DB
    $db = new DB;
    //$params will be safely injected into the query where :index = the value of that index in the array.
    $params = array("id" => $_SESSION["uid"],
        "email" => $data["email"],
        "firstName" => $data["first_name"],
        "lastName" => $data["last_name"]);
    $db->sqlSave("UPDATE users SET email = :email, firstName = :firstName, lastName = :lastName WHERE id = :id ", $params);

    if ($db->error) {
        $data["error"] = true;
        $data["errorMessage"][] = $db->errorMessage;
        return $data;
    }
    
    //reload sessions info
    $_SESSION["email"] = $data["email"];
    $_SESSION["first_name"] = $data["first_name"];
    $_SESSION["last_name"] = $data["last_name"];
    
    
    
    $data["error"] = false;
    return $data;
}

function loadUserData() {
    //Load data from a row for user from database.
}

function createUser($data) {
    if ($data == array()) {
        $data["error"] = true;
        $data["errorMessage"][] = "Create User array cannot have no arguments.";
        return;
    }
    //check perms
    loadPermissions();
    if (!isset($_SESSION["permissions"]["USER"]["ADMIN"])) {
        $data["error"] = true;
        $data["errorMessage"][] = "You do not have permission to create users.";
        return $data;
    }
    if ($_SESSION["permissions"]["USER"]["ADMIN"] !== true) {
        $data["error"] = true;
        $data["errorMessage"][] = "You do not have permission to create users.";
        return $data;
    }

    $data["error"] = false;
    $data["email"] = trim($data["email"]);
    $data["password"] = trim($data["password"]);
    $data["password2"] = trim($data["password2"]);
    $data["first_name"] = trim($data["first_name"]);
    $data["last_name"] = trim($data["last_name"]);
    if ($data["email"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Email cannot be empty.";
    }
    if ($data["password"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Password cannot be empty.";
    }
    if ($data["first_name"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Please enter first name.";
    }
    if ($data["last_name"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Please enter last name.";
    }
    if ($data["password"] !== $data["password2"]) {
        $data["error"] = true;
        $data["errorMessage"][] = "Passwords do not match.";
    }

    if ($data["error"]) {
        return $data;
    }
    $db = new DB;
    //$params will be safely injected into the query where :index = the value of that index in the array.
    $params = array("email" => $data["email"],
        "password" => password_hash($data["password"], PASSWORD_BCRYPT),
        "firstname" => $data["first_name"],
        "lastname" => $data["last_name"]);
    $db->sqlSave("INSERT INTO users (email, password, firstName, lastName, active) VALUES ( :email , :password , :firstname , :lastname , \"1\" ) ", $params);

    if ($db->error) {
        $data["error"] = true;
        $data["errorMessage"][] = $db->errorMessage;
        return $data;
    }
    $data["error"] = false;
    return $data;
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

function showAccount($data = array()) {
    //Show account info in main part of dashboard.
    if ($data != array()) {
        //clear errors
        $data["error"] = false;
        $data["errorMessage"] = array();

        //info form logic
        if ($data["submit"] == "info") {
            $data = saveUserData($data);
            if (!$data["error"]) {
                print "Thank you, account information has been updated.<br />";
                return $data;
            }
            print "<div class=\"alert alert-danger\" role=\"alert\">";
            foreach ($data["errorMessage"] as $message) {
                print $message . "<br />";
            }
            print "</div>";
        }




        //pass form logic
        if ($data["submit"] == "pass") {
            $data = changePass($data);
            if (!$data["error"]) {
                print "Thank you, password has been updated.<br />";
                return $data;
            }
            print "<div class=\"alert alert-danger\" role=\"alert\">";
            foreach ($data["errorMessage"] as $message) {
                print $message . "<br />";
            }
            print "</div>";
        }

    } else {
        $data["email"] = $_SESSION["email"];
        $data["first_name"] = $_SESSION["first_name"];
        $data["last_name"] = $_SESSION["last_name"];
    }
    //Need email, first name, last name, password.

    print '<form class="form-accountchange" action ="dashboard.php?view=account" method ="POST" name ="new_user">
        <h3 class="form-signin-heading">Use this form to edit your account info.</h3>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email"  value="' . $data["email"] . '" type="email" id="inputEmail" class="form-control" placeholder ="Email" required autofocus>
        <label for="inputFirstName" class="sr-only">First Name</label>
        <input name="first_name" value="' . $data["first_name"] . '" type="text" id="inputFirstName" class="form-control" placeholder="First Name" required>
        <label for="inputLastName" class="sr-only">Last Name</label>
        <input name="last_name" value="' . $data["last_name"] . '" type="text" id="inputLastName" class="form-control" placeholder="Last Name" required>
        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary" type="submit" value="info" name="submit">Update Account</button>
      </form>';


    //change pass form
    print '<form class="form-passchange" action ="dashboard.php?view=account" method ="POST" name ="new_user">
        <h3 class="form-signin-heading">Use this form to change your password.</h3>
        <label for="inputPassword" class="sr-only">OldPass</label>
        <input name="password"  value="" type="password" id="inputPassword" class="form-control" placeholder ="Current Password" required >
        <label for="inputPasswordNew" class="sr-only">Password</label>
        <input name="passwordNew" type="password" id="inputPasswordNew" class="form-control" placeholder="New Password" required>
        <label for="inputPasswordNew2" class="sr-only">Password2</label>
        <input name="passwordNew2" type="password" id="inputPasswordNew2" class="form-control" placeholder="Re-Enter New Password" required>
        
        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary" type="submit" value="pass" name="submit">Change Password</button>
      </form>';
    return $data;
}

function showUsers() {
    //Show all users in main part of dashboard.
    print '

          <h3 class="sub-header">All Users</h3>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Email</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Active</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>foo@test.com</td>
                  <td>John</td>
                  <td>Smith</td>
                  <td><span class="label label-success">Active</span></td>
                  <td><button type="button" class="btn btn-xs btn-info">Edit User</button></td>
                </tr>
                <tr>
                  <td>bar@test.com</td>
                  <td>Jane</td>
                  <td>Anderson</td>
                  <td><span class="label label-success">Active</span></td>
                  <td><button type="button" class="btn btn-xs btn-info">Edit User</button></td>
                </tr>
                <tr>
                  <td>test@test.com</td>
                  <td>Gary</td>
                  <td>White</td>
                  <td><span class="label label-danger">Disabled</span></td>
                  <td><button type="button" class="btn btn-xs btn-info">Edit User</button></td>
                </tr>
                
              </tbody>
            </table>
          </div>';
}

function showNewUser($data = array()) {
    loadPermissions();
    if (!isset($_SESSION["permissions"]["USER"]["ADMIN"])) {
        $data["error"] = true;
        $data["errorMessage"][] = "You do not have permission to create users.";
        print "<div class=\"alert alert-danger\" role=\"alert\">";
        foreach ($data["errorMessage"] as $message) {
            print $message . "<br />";
        }


        print "</div>";
        return $data;
    }
    if ($_SESSION["permissions"]["USER"]["ADMIN"] !== true) {
        $data["error"] = true;
        print "<div class=\"alert alert-danger\" role=\"alert\">";
        foreach ($data["errorMessage"] as $message) {
            print $message . "<br />";
        }


        print "</div>";
        $data["errorMessage"][] = "You do not have permission to create users.";
        return $data;
    }


    if ($data != array()) {
        //clear errors
        $data["error"] = false;
        $data["errorMessage"] = array();





        $data["email"] = trim($data["email"]);
        $data["password"] = trim($data["password"]);
        $data["password2"] = trim($data["password2"]);
        $data["first_name"] = trim($data["first_name"]);
        $data["last_name"] = trim($data["last_name"]);
        if ($data["email"] == "") {
            $data["error"] = true;
            $data["errorMessage"][] = "Email cannot be empty.";
        }
        if ($data["password"] == "") {
            $data["error"] = true;
            $data["errorMessage"][] = "Password cannot be empty.";
        }
        if ($data["first_name"] == "") {
            $data["error"] = true;
            $data["errorMessage"][] = "Please enter first name.";
        }
        if ($data["last_name"] == "") {
            $data["error"] = true;
            $data["errorMessage"][] = "Please enter last name.";
        }
        if ($data["password"] !== $data["password2"]) {
            $data["error"] = true;
            $data["errorMessage"][] = "Passwords do not match.";
        }
        if (!$data["error"]) {
            $data = createUser($data);
        }
        if (!$data["error"]) {
            print "Thank you, user has been created.<br />";
            return $data;
        }
        print "<div class=\"alert alert-danger\" role=\"alert\">";
        foreach ($data["errorMessage"] as $message) {
            print $message . "<br />";
        }


        print "</div>";
    } else {
        $data["email"] = "";
        $data["first_name"] = "";
        $data["last_name"] = "";
    }
    //Need email, first name, last name, password.

    print '<form class="form-signin" action ="dashboard.php?view=newUser" method ="POST" name ="new_user">
        <h2 class="form-signin-heading">Please Enter New User Information</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email"  value="' . $data["email"] . '" type="email" id="inputEmail" class="form-control" placeholder ="Email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPassword2" class="sr-only">Password2</label>
        <input name="password2" type="password" id="inputPassword2" class="form-control" placeholder="Re-Enter Password" required>
        <label for="inputFirstName" class="sr-only">First Name</label>
        <input name="first_name" value="' . $data["first_name"] . '" type="text" id="inputFirstName" class="form-control" placeholder="First Name" required>
        <label for="inputLastName" class="sr-only">Last Name</label>
        <input name="last_name" value="' . $data["last_name"] . '" type="text" id="inputLastName" class="form-control" placeholder="Last Name" required>
        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Create New User</button>
      </form>';
    return $data;
}

function changePass($data) {
    //validate $data
    $data["password"] = trim($data["password"]);
    $data["passwordNew"] = trim($data["passwordNew"]);
    $data["passwordNew2"] = trim($data["passwordNew2"]);

    if ($data["password"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Password cannot be empty.";
    }
    if ($data["passwordNew"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "New password cannot be empty.";
    }
    if ($data["passwordNew2"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Please confirm your new password.";
    }
    if ($data["passwordNew"] !== $data["passwordNew2"]) {
            $data["error"] = true;
            $data["errorMessage"][] = "New passwords do not match.";
    }
    
    
    
    //check if current password matches
    $db = new DB;
    $db->queryAssoc("select password from users where id = :id ", array("id" => $_SESSION["uid"]));
    $result = $db->resultsArray[0];

    if (password_verify($data["password"], $result["password"])) {
        $data["error"] = false;
    } else {
        $data["error"] = true;
        $data["errorMessage"][] = "Current password incorrect.";
        $data["email"] = $_SESSION["email"];
        $data["first_name"] = $_SESSION["first_name"];
        $data["last_name"] = $_SESSION["first_name"];
        return $data;
    }
    //check if new password is the same as the old password
    if (password_verify($data["passwordNew"], $result["password"])) {
        $data["error"] = true;
        $data["errorMessage"][] = "New password cannot be same as previous password.";
        $data["email"] = $_SESSION["email"];
        $data["first_name"] = $_SESSION["first_name"];
        $data["last_name"] = $_SESSION["first_name"];
        return $data;
    }
    //update pass
    $db = new DB;
    //$params will be safely injected into the query where :index = the value of that index in the array.
    $params = array("id" => $_SESSION["uid"],
        "password" => password_hash($data["passwordNew"], PASSWORD_BCRYPT));
    $db->sqlSave("UPDATE users SET password = :password WHERE id = :id ", $params);

    if ($db->error) {
        $data["error"] = true;
        $data["errorMessage"][] = $db->errorMessage;
        return $data;
    }
    $data["error"] = false;
    return $data;
}
