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
              <tbody>';

    $db = new DB;
    $db->queryAssoc("select * from category_types", array());
    if ($db->count < 1) {
        print "<tr><td>No categories.</td></tr>";
        return "</tbody></table></div>";
    }
    $result = $db->resultsArray;
    foreach ($result as $row) {
        print "<tr>";
        print '<td><a href = "dashboard.php?view=category&id=' . $row["category_id"] . '" class="btn btn-xs btn-default">' . $row["title"] . '</a></td>';
        print "<td style=\"text-align: left;\">" . $row["description"] . "</td>";
        
        //print delete button which calls deleteCategory method
//        print '<td><button class="btn btn-xs btn-danger" type="" name="submit">Delete Category</button></td>';
        print '<td><a href = "dashboard.php?view=deleteCategory&id=' . $row["category_id"] . '" class="btn btn-xs btn-danger">Delete Category</a></td>';
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
        $data["errorMessage"][] = "You do not have permission to create categories.";
        return $data;
    }
    if ($_SESSION["permissions"]["USER"]["ADMIN"] !== true) {
        $data["error"] = true;
        $data["errorMessage"][] = "You do not have permission to create categories.";
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

function deleteCategory($typeID) {
    //check perms
    loadPermissions();
    if (!isset($_SESSION["permissions"]["USER"]["ADMIN"])) {
        $data["error"] = true;
        $data["errorMessage"][] = "You do not have permission to delete categories.";
        return $data;
    }
    if ($_SESSION["permissions"]["USER"]["ADMIN"] !== true) {
        $data["error"] = true;
        $data["errorMessage"][] = "You do not have permission to delete categories.";
        return $data;
    }
    $data["error"] = false;
    
    //checks if category to be deleted exists
    $db = new DB;
    $db->queryAssoc('SELECT title FROM category_types WHERE category_id = :typeid ', array("typeid" => $typeID));
    if ($db->count < 1) {
        print '<h1 class="page-header"> ERROR:</h1> <p>It appears you are trying to delete a category that does not exist.';
        return;
    }
    
    //deletes category if it exists
    $db->sqlsave('DELETE FROM category_types WHERE category_id = :id ', array("id" => $typeID));
    if ($db->error) {
        $data["error"] = true;
        $data["errorMessage"][] = $db->errorMessage;
        return $data;
    }
    $db->sqlsave('DELETE FROM category_assigned WHERE category_id = :id ', array("id" => $typeID));
    if ($db->error) {
        $data["error"] = true;
        $data["errorMessage"][] = $db->errorMessage;
        return $data;
    }
    $data["notice"] = "<div class=\"alert alert-info\" role=\"alert\">Category has been deleted!</div>";
    return $data;
}

function showDeleteCategory($id) {
    print '<h1 class="page-header">Delete Category</h1>';
    $data = deleteCategory($id);
    if ($data["error"]) {
        print "<div class=\"alert alert-danger\" role=\"alert\">";
        foreach ($data["errorMessage"] as $message) {
            print $message . "<br />";
        }
        print "</div>";
    } else {
        print $data["notice"];
    }
    return;
}

function showCategory($id) {
    $db = new DB;
    $db->queryAssoc('SELECT title FROM category_types WHERE category_id = :id ', array("id" => $id));
    //check if the category id is valid
    if ($db->count < 1) {
        print '<h1 class="page-header"> Invaid Category ID</h1> <p>The category you are looking for does not seem to exist.';
        return;
    }
    //print header for page with category title
    $result = $db->resultsArray;
    print '<h1 class="page-header">All events for ' . $result[0]["title"] . '</h1>';
    
    //load all events assigned to this category id
    $db = new DB;
    $db->queryAssoc('select event_id from category_assigned where category_id = :id ', array("id" => $id));
    //check if there are any events assigned
    if ($db->count < 1) {
        print '<p>This category does not have any events in it.';
        return;
    }
    $result = $db->resultsArray;
    
    foreach ($result as $row){
        $db = new DB;
        $db->queryAssoc("select * from events where id = :id ", array("id" => $row["event_id"]));
        $tmp = $db->resultsArray[0];
        foreach ($tmp as $key => $value){
            $events[$row["event_id"]][$key] = $value;
        }
    }
    
    //print a table with the events in the same way as View all Events
    print '
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
    foreach ($events as &$row) {
        $db->queryAssoc("select category_id from category_assigned where event_id = :eventID ", array("eventID" => $row["id"]));
        $categories = $db->resultsArray;
        foreach ($categories as $f => $category) {
            $row["categories"][$category["category_id"]] = "";
        }
    }
    unset($row);
    foreach ($events as &$row) {
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
    foreach ($events as $row) {
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