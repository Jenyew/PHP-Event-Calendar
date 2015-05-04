<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function loadPermissions() {
    $_SESSION["permissions"] = array();
    /* stores perms like this in SESSION
    $_SESSION["permissions"]["USER"] = "ADMIN"
    $_SESSION["permissions"]["CATEGORY"]["1"] = "ADMIN"
    $_SESSION["permissions"]["EVENT"]["1"] = "ADMIN" 
     */
    //load all perms for $_SESSION["uid"]~["perms"] = True
    $db = new DB;
    $db->queryAssoc("select * from permissions where user_id = :userid ", array("userid" => $_SESSION["uid"] ));// $_SESSION["uid"]));

    $result = $db->resultsArray;
    
    foreach ($result as $row) {
    if ($row["type"] == "USER") {
        $_SESSION["permissions"]["USER"][$row["level"]] = TRUE;
    } else {
       $_SESSION["permissions"][$row["type"]][$row["id"]][$row["level"]] = TRUE;
    }
     
    
    }
//        print "<br /><pre>";
//        print_r ($_SESSION);
    //put all user perms into $_SESSION["permissions"]["user"]~["perms"] = True
    //put all evnent perms into $_SESSION["permissions"]["events"]~["{eventid}"]~["perms"] = True
    
    
    return ;
}