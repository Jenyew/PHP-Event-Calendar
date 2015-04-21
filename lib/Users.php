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
    
}

function loadUserData() {
    
}

function createUser() {
    
}

function deleteUser() {
    
}

function loadAllUsers() {
    
}
