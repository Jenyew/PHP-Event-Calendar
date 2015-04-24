<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

 //DB configuration Constants
 define('_HOST_NAME_', 'localhost:3306');
 define('_USER_NAME_', 'XXXXXX');
 define('_DB_PASSWORD_', 'XXXXXX');
 define('_DATABASE_NAME_', 'XXXXXXX');
 
 //add includes here
define('APPLICATION_PATH', dirname( __FILE__ ) .DIRECTORY_SEPARATOR );
require_once(APPLICATION_PATH.DIRECTORY_SEPARATOR."DB.php");
