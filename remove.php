<?php
  include("common.php");
  $db = get_PDO();

  if(isset($_POST["mode"])) {
    $mode = $_POST["mode"];
    if($mode === "removeAll") {
      if(isset($_POST["class"])){
        remove_all($_POST["class"]);
      } else {
        handle_error("NEED A CLASS TO REMOVE FROM");
      }
    } else if(isset($_POST["assignment"])) {
      remove_assignment($_POST["assignment"]);
    } else {
      handle_error("NEED AN ASSIGNMENT TO REMOVE");
    }
  } else {
    handle_error("NEED A VALID MODE");
  }

  function remove_all($class) {
    remove_assignment($class);
  }

  function remove_assignment($assignment) {
    echo "Successfully removed";
  }
?>
