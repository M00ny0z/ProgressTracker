<?php
  include("common.php");
  $db = get_PDO();

  if(isset($_POST["mode"])) {
    $mode = $_POST["mode"];
    if(isset($_POST["class"])) {
      if($mode === "autoClass"){
        auto_add_class($_POST["class"]);
      } else {
        if(isset($_POST["assignment"])) {
          add_assignment($_POST["class"], $_POST["assignment"]);
        } else {
          handle_error("NEED AN ASSIGNMENT NAME");
        }
      }
    } else {
      handle_error("NEED A CLASS TO REMOVE FROM");
    }
  } else {
    handle_error("NEED A VALID MODE");
  }

  function add_assignment($class, $assignment) {
    echo "Assignment " . $assignment . " for " . $class . "\n";
  }

  function auto_add_class($class) {
    header("Content-type: text/plain");
    $assignments = explode(",", file_get_contents("Classes/" . $class . ".txt"));
    for($i = 0; $i < count($assignments) - 1; $i++) {
      $assignment = replace_all($assignments[$i], "_", " ");
      add_assignment($class, $assignment);
    }
  }
?>
