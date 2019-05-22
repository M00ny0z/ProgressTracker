<?php
  include("common.php");
  $db = get_PDO();
  $NETID = "em66";

  if(isset($_POST["mode"])) {
    $mode = $_POST["mode"];
    if(isset($_POST["class"])) {
      $class = $_POST["class"];
      if($mode === "removeClass") {
        remove_class($class, $NETID, $db);
      } else if(isset($_POST["assignment"]) && $mode === "removeAssign") {
        remove_assignment($_POST["assignment"], $class, $NETID, $db);
      } else {
        handle_error("NEED AN ASSIGNMENT TO REMOVE");
      }
    } else {
      handle_error("NEED A CLASS TO REMOVE FROM");
    }
  } else {
    handle_error("NEED A VALID MODE");
  }

  /**
   * Removes all of the assignments of a specified class, essentially removes the class from the
   * user
   * @param $class {string} - The class to remove from the user
  */
  function remove_class($class, $netid, $db) {
    try {
      $query = "DELETE
                FROM Assignments
                WHERE netid = '" . $netid . "' AND class = '" . $class . "';";
      $db->query($query);
      $stmt = $db->prepare($query);
    } catch(PDOException $ex) {
      handle_error(DATABASE_ERROR, $ex);
    }

    try {
      $query = "DELETE
                FROM Enrolls
                WHERE netid = '" . $netid . "' AND class = '" . $class . "';";
      $db->query($query);
      $stmt = $db->prepare($query);
    } catch(PDOException $ex) {
      handle_error(DATABASE_ERROR, $ex);
    }
  }



  /**
   * Removes a specified assignment of a specified class
   * user
   * @param $class {string} - The class to remove from the user
  */
  function remove_assignment($assignment, $class, $netid, $db) {
    try {
      $query = "DELETE
                FROM Assignments
                WHERE name = " . "'" . $assignment . "' AND netid = '" . $netid . "' AND "
                . "class = '" . $class . "';";
      $db->query($query);
      $stmt = $db->prepare($query);
    } catch(PDOException $ex) {
      handle_error(DATABASE_ERROR, $ex);
    }
  }
?>
