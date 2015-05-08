<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function showAllCategories($data = array()) {
    //Show all categories in main part of dashboard.
    if ($data != array()) {
        //clear errors
        $data["error"] = false;
        $data["errorMessage"] = array();
        

        $data["title"] = trim($data["title"]);
        $data["description"] = trim($data["description"]);
        if ($data["title"] == "") {
            $data["error"] = true;
            $data["errorMessage"][] = "Title cannot be empty.";
        }
        
        if (!$data["error"]) {
            $data = createCategory($data);
            
        }
        if (!$data["error"]) {
            print "Thank you, category has been created.<br />";
            print '<br /><br /><td><a href = "dashboard.php?view=allCategories" class="btn btn-sm btn-info">Back</a></td>';
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
    }
    
    print '<form class="form-createCategory" action ="dashboard.php?view=allCategories" method ="POST" name ="add_category">
        <h3 class="form-createCategory-heading">Create New Category</h3>
        <label for="inputTitle" class="sr-only">Category Title</label>
        <input name="title"  value="' . $data["title"] . '" type="text" id="inputTitle" class="form-control" placeholder ="Category Title" required autofocus>
        <label for="inputDescription" class="sr-only">Description</label>
        <textarea rows="2" name="description" class="responsive-input" placeholder="Category Description" required>' . $data["description"] . '</textarea>
        <button class="btn btn-lg btn-primary" type="submit" name="submit">Create Category</button>
      </form>';
//    return $data;
    print '
          <h3 class="sub-header">All Categories</h3>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Description</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
                <tr>';

    $db = new DB;
    $db->queryAssoc("select * from category_types", array());
    if ($db->count < 1) {
        print "<tr><td>No categories.</td></tr>";
        return "</tbody></table></div>";
    }
    $result = $db->resultsArray;
//    foreach ($result as &$row) {
//        $db->queryAssoc("select category_id from category_assigned where event_id = :eventID ", array("eventID" => $row["id"]));
//        $categories = $db->resultsArray;
//        foreach ($categories as $f => $category) {
//            $row["categories"][$category["category_id"]] = "";
//        }
//    }
//    unset($row);
//    foreach ($result as &$row) {
//        if (isset($row["categories"])) {
//            foreach ($row["categories"] as $catid => $f) {
//                $db->queryAssoc("select title from category_types where category_id = :categoryID ", array("categoryID" => $catid));
//                if ($db->count > 0) {
//                    $title = $db->resultsArray[0]["title"];
//                    $row["categories"][$catid] = $title;
//                }
//            }
//        }
//    }
//    unset($row);
    //print_r($result);

    foreach ($result as $row) {
        print "<tr>";
        print "<td>" . $row["title"] . "</td>";
        print "<td>" . $row["description"] . "</td>";
        print "</tr>";
    }
    print '
              </tbody>
            </table>
          </div>';

}
function createCategory($data) {
    if ($data == array()) {
        $data["error"] = true;
        $data["errorMessage"][] = "Create Category array cannot have no arguments.";
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
    $data["title"] = trim($data["title"]);
    $data["description"] = trim($data["description"]);
    if ($data["title"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Title cannot be empty.";
    }
    if ($data["description"] == "") {
        $data["error"] = true;
        $data["errorMessage"][] = "Description cannot be empty.";
    }

    if ($data["error"]) {
        return $data;
    }
    
    $db = new DB;
    //$params will be safely injected into the query where :index = the value of that index in the array.
    $params = array("title" => $data["title"],
        "description" => $data["description"]);
    $db->sqlSave("INSERT INTO category_types (title, description) VALUES ( :title , :description ) ", $params);

    if ($db->error) {
        $data["error"] = true;
        $data["errorMessage"][] = $db->errorMessage;
        return $data;
    }
    $data["error"] = false;
    return $data;
}