<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function loadPermissions() {
    //load all perms for $_SESSION["uid"]~["perms"] = True
    $db = new DB;
    $db->queryAssoc("select * from permissions where user_id = :userid ", array("userid" => "1" ));// $_SESSION["uid"]));

    $result = $db->resultsArray;
    
    foreach ($result as $row) {
    if ($row["type"] == "USER") {
        print '$_SESSION["permissions"]["user"] = "'.$row["level"].'" <br />';
    } else {
        print '$_SESSION["permissions"]["'.$row["type"].'"]["'.$row["id"].'"] = "'.$row["level"].'" <br />';
    }
       // print "<br />This is the first thing in the loop.";
     
    
    }
    //put all user perms into $_SESSION["permissions"]["user"]~["perms"] = True
    //put all evnent perms into $_SESSION["permissions"]["events"]~["{eventid}"]~["perms"] = True
    
    
    return ;
}