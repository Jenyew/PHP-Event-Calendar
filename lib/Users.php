<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Logs in the user by checking whether the username exists in the database first
 * then by checking if the password matches the database password.
 * @param string $username  The user logging in.
 * @param string $pass  Their password.
 * @return array  Success boolean on whether or not login was valid and errorMessage.
 */
function logIn($username,$pass) {
    //check if username exists
    $db = new PDO('mysql:host=localhost;dbname=testdb;charset=utf8', 'root', '');
    $result = $db->query("SELECT * FROM table");
    print_r($result);
    //Create a fake php file to print this.
    
    $userExists = false;
    if ($userExists) {
            //get user_pass
        $userPass = "password";
        if ($userPass == $pass) {
            return array("success" => true, "errorMessage" => "");
        } else {
            return array("success" => false, "errorMessage" => "Incorrect password!");
        }
    } else {
        return array("success" => false, "errorMessage" => "Incorrect username!");
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
