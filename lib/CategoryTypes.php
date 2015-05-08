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
    } else {
        $data["title"] = "";
        $data["description"] = "";
    }
    
    print '<form class="form-createCategory" action ="dashboard.php?view=allCategories" method ="POST" name ="add_category">
        <h3 class="form-createCategory-heading">Create New Category</h3>
        <label for="inputTitle" class="sr-only">Category Title</label>
        <input name="title"  value="' . $data["title"] . '" type="title" id="inputTitle" class="form-control" placeholder ="Category Title" required autofocus>
        <label for="inputDescription" class="sr-only">Description</label>
        <textarea rows="2" name="description" class="responsive-input" placeholder="Category Description">' . $data["description"] . '</textarea>
        <td><a href = "dashboard.php?view=allCategories" class="btn btn-lg btn-primary" type="submit" name="submit">Create Category</a></td>
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
    unset($row);
    //print_r($result);


    foreach ($result as $row) {
        print "<tr>";
        print "<td>" . $row["title"] . "</td>";
        print "<td>" . $row["description"] . "</td>";

//        print "<td>";
//        if (isset($row["categories"])) {
//            foreach ($row["categories"] as $catid => $title) {
//                print '<a href = "dashboard.php?view=category&id=' . $catid . '" class="btn btn-xs btn-default">' . $title . '</a>';
//            }
//        }
//        print "</td>";
//            print "<td>
//                        <button type='button' class='btn btn-xs btn-default'>Meetings</button>
//                        <button type='button' class='btn btn-xs btn-default'>Staff</button>
//                        <button type='button' class='btn btn-xs btn-default'>10th Grade</button>
//                    </td>";
//        print '<td><a href = "dashboard.php?view=editEvent&eventid=' . $row["id"] . '" class="btn btn-xs btn-info">Edit Event</a></td>';
//        print "</tr>";
    }

//    print '
//                  <td>9:30AM Wednesday, April 29, 2015</td>
//                  <td>10:30AM Wednesday, April 29, 2015</td>
//                  <td>
//                      <button type="button" class="btn btn-xs btn-default">Meetings</button>
//                      <button type="button" class="btn btn-xs btn-default">Staff</button>
//                      <button type="button" class="btn btn-xs btn-default">10th Grade</button>
//                  </td>
//                  <td><button type="button" class="btn btn-xs btn-info">Edit Event</button></td>
//                </tr>';

    print '
              </tbody>
            </table>
          </div>';
}
