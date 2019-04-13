<?php
  include("common.php");
  $db = get_PDO();

  if(isset($_POST["mode"])) {
    $mode = $_POST["mode"];
    if(isset($_POST["class"])) {
      $class = $_POST["class"];
      if($mode === "removeAll") {
        remove_all($class);
      } else if(isset($_POST["assignment"])) {
        remove_assignment($_POST["assignment"]);
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
  function remove_all($class) {
    remove_assignment($class);
  }

  /**
   * Removes a specified assignment of a specified class
   * user
   * @param $class {string} - The class to remove from the user
  */
  function remove_assignment($assignment, $class) {
    echo "Successfully removed";
  }
?>
