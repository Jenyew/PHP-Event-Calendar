<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function createEvent($data) {
    if ($data == array()) {
        $data["error"] = true;
        $data["errorMessage"][] = "Create Event array cannot have no arguments.";
        return;
    }
    //check perms
    loadPermissions();
    if (!isset($_SESSION["permissions"]["USER"]["ADMIN"])) {
        $data["error"] = true;
        $data["errorMessage"][] = "You do not have permission to create events.";
        return $data;
    }
    if ($_SESSION["permissions"]["USER"]["ADMIN"] !== true) {
        $data["error"] = true;
        $data["errorMessage"][] = "You do not have permission to create events.";
        return $data;
    }

    $data["error"] = false;
    $data["title"] = trim($data["title"]);
    $data["description"] = trim($data["description"]);
    $data["startTime"] = trim($data["startTime"]);
    $data["endTime"] = trim($data["endTime"]);
    if ($data["title"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Email cannot be empty.";
    }
    if ($data["description"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Password cannot be empty.";
    }
    if ($data["startTime"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Please enter first name.";
    }
    if ($data["endTime"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Please enter last name.";
    }





    if ($data["error"]) {
        return $data;
    }
    $db = new DB;
    //$params will be safely injected into the query where :index = the value of that index in the array.
    $params = array("title" => $data["title"],
        "description" => $data["description"],
        "start" => $data["startTime"],
        "end" => $data["endTime"],
        "author" => $_SESSION["uid"]   );
    $db->sqlSave("INSERT INTO events (title, description, start, end, author) VALUES ( :title , :description , :start , :end , :author ) ", $params);

    if ($db->error) {
        $data["error"] = true;
        $data["errorMessage"][] = $db->errorMessage;
        return $data;
    }
    $data["error"] = false;
    return $data;
}

function showAddEvent($data = array()) {
    if ($data != array()) {
        //clear errors
        $data["error"] = false;
        $data["errorMessage"] = array();

        $data["title"] = trim($data["title"]);
        $data["description"] = trim($data["description"]);
        $data["startTime"] = trim($data["startTime"]);
        $data["endTime"] = trim($data["endTime"]);
        if ($data["title"] == "") {
            $data["error"] = true;
            $data["errorMessage"][] = "Title cannot be empty.";
        }
        if ($data["startTime"] == "") {
            $data["error"] = true;
            $data["errorMessage"][] = "Start Time must be set.";
        }
        if ($data["endTime"] == "") {
            $data["error"] = true;
            $data["errorMessage"][] = "End Time must be set.";
        }
        //Need to check if start date is before end date.
        
            $A = new DateTime(); 
            $A->setTimestamp(strtotime($data["startTime"]));

            $B = new DateTime(); 
            $B->setTimestamp(strtotime($data["endTime"])); 

        if ($A > $B) {
            $data["error"] = true;
            $data["errorMessage"][] = "Start Time must be before End Time.";
        }
        if (!$data["error"]) {
            $data = createEvent($data);
        }
        if (!$data["error"]) {
            print "Thank you, event has been created.<br />";
            print "<br />";
            print "<br />";
            print '<a href = "dashboard.php?view=newUser" class="btn btn-lg btn-info">Back</a>';
            return $data;
        }
        print "<div class=\"alert alert-danger\" role=\"alert\">";
        foreach ($data["errorMessage"] as $message) {
            print $message . "<br />";
        }


        print "</div>";
    } else {
        $data["title"] = "";
        $data["description"] = "";
        $data["startTime"] = "";
        $data["endTime"] = "";
    }
    //Need email, first name, last name, password.

    print '<form class="form-createEvent" action ="dashboard.php?view=addEvent" method ="POST" name ="add_event">
        <h2 class="form-createEvent-heading">Please Enter Event Information</h2>
        <label for="inputTitle" class="sr-only">Event Title</label>
        <input name="title"  value="' . $data["title"] . '" type="title" id="inputTitle" class="form-control" placeholder ="Event Title" required autofocus>
        <label for="inputDescription" class="sr-only">Description</label>
        <textarea rows="4" name="description" class="responsive-input" placeholder="Event Description">' . $data["description"] . '</textarea>
        <br /><br />
        <input name="startTime" type="text" id="field1" size="50"
            value="' . $data["startTime"] . '" />
        
        <input name="endTime" type="text" id="field2" size="50"
            value="' . $data["endTime"] . '" />
        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Create Event</button>
      </form>';
    return $data;
}

function showAllEvents() {
    //Show all events in main part of dashboard.
    //Todays Events
//    print '
//          <h3 class="sub-header">Events Today</h3>
//          <div class="table-responsive">
//            <table class="table table-striped">
//              <thead>
//                <tr>
//                  <th>Title</th>
//                  <th>Start Time</th>
//                  <th>End Time</th>
//                  <th>Category</th>
//                  <th> </th>
//                </tr>
//              </thead>
//              <tbody>
//                <tr>
//                
//                </tr>
//              </tbody>
//            </table>
//          </div>';
    //This week's Events
//    print '
//          <h3 class="sub-header">Events This Week</h3>
//          <div class="table-responsive">
//            <table class="table table-striped">
//              <thead>
//                <tr>
//                  <th>Title</th>
//                  <th>Start Time</th>
//                  <th>End Time</th>
//                  <th>Category</th>
//                  <th> </th>
//                </tr>
//              </thead>
//              <tbody>
//                <tr>
//                
//                </tr>
//                <tr>
//                
//                </tr>
//              </tbody>
//            </table>
//          </div>';
    //All events today or after
    print '
          <h3 class="sub-header">All Events</h3>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>Category</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
                <tr>';

    $db = new DB;
    $db->queryAssoc("select * from events", array());
    if ($db->count < 1) {
        print "<tr><td>No current events.</td></tr>";
        return "</tbody></table></div>";
    }
    $result = $db->resultsArray;
    foreach ($result as &$row) {
        $db->queryAssoc("select category_id from category_assigned where event_id = :eventID ", array("eventID" => $row["id"]));
        $categories = $db->resultsArray;
        foreach ($categories as $f => $category) {
            $row["categories"][$category["category_id"]] = "";
        }
    }
    unset($row);
    foreach ($result as &$row) {
        if (isset($row["categories"])) {
            foreach ($row["categories"] as $catid => $f) {
                $db->queryAssoc("select title from category_types where category_id = :categoryID ", array("categoryID" => $catid));
                if ($db->count > 0) {
                    $title = $db->resultsArray[0]["title"];
                    $row["categories"][$catid] = $title;
                }
            }
        }
    }
    unset($row);
    foreach ($result as $row) {
        print "<tr>";
        print "<td>" . $row["title"] . "</td>";
        print "<td>" . $row["description"] . "</td>";
        print "<td>" . $row["start"] . "</td>";
        print "<td>" . $row["end"] . "</td>";

        print "<td>";
        if (isset($row["categories"])) {
            foreach ($row["categories"] as $catid => $title) {
                print '<a href = "dashboard.php?view=category&id=' . $catid . '" class="btn btn-xs btn-default">' . $title . '</a>';
            }
        }
        print "</td>";
        print '<td><a href = "dashboard.php?view=editEvent&eventid=' . $row["id"] . '" class="btn btn-xs btn-info">Edit Event</a></td>';
        print "</tr>";
    }
    print '
              </tbody>
            </table>
          </div>';
}
