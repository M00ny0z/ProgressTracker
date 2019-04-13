<?php
  include("common.php");
  $db = get_PDO();

  if(isset($_POST["mode"]) && is_valid_mode($_POST["mode"])) {
    $mode = $_POST["mode"];
    if($mode === "add" || $mode === "removeAll" || $mode === "autoClass") {
      if(isset($_POST["class"])) {
        $class = $_POST["class"];
        if($mode === "add") {
          if(isset($_POST["assignment"]) && isset($_POST["duedate"])) {
            add_assignment();
          } else {
            handle_error("ERROR: NEED ASSIGNMENT OR DUEDATE");
          }
        } else if($mode === "removeAll") {
          remove_all();
        } else if($mode === "autoClass") {
          auto_add_class($class);
        }
      } else {
        handle_error("ERROR: NEED CLASS");
      }
    } else if($mode === "remove" || $mode === "update") {
      if(isset($_POST["assignment"])) {
        $assignment = $_POST["assignment"];
        if($mode === "update") {
          if(isset($_POST["timestamp"]) && isset($_POST["status"])) {
            update_assignment();
          } else {
            handle_error("ERROR: NEED TIMESTAMP AND STATUS");
          }
        } else if($mode === "remove") {
          remove_assignment();
        }
      } else {
        handle_error("ERROR: NEED ASSIGNMENT");
      }
    }
  }
  
  function is_valid_mode($mode) {
    $valid_modes = array("add", "remove", "update", "autoClass", "removeAll");
    return in_array($mode, $valid_modes);
  }

  function add_assignment($class, $assignment) {
    echo "Assignment " . $assignment . " for " . $class . "\n";
  }

  function update_assignment() {
    echo "Successfully updated";
  }


  // function add_assignment($netid, $class, $assignment, $duedate) {
  //   echo "Class: " . $class . " Assignment: " . $assignment . " Due date: " . $duedate;
  // }

?>
