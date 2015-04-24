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
    $db->queryAssoc("select email, password from users where email = $email", array());
    //If the email exists, it will return a row and count would be 1.
    if ($db->count < 1) {
        return array("success" => false, "errorMessage" => "Email does not exist.");
    }
    $result = $db->resultsArray[0];
    
    if ($pass === $result[password]) {
        //Checks if password entered matches actual password taken from database.
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
