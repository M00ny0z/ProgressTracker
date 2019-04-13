<?php
  include("common.php");
  $db = get_PDO();
  if(isset($_POST["mode"])) {
    $mode = $_POST["mode"];
    if(isset($_POST["value"])) {
      $value = $_POST["value"];
      if(isset($_POST["class"]) && is_valid_class($_POST["class"]) && isset($_POST["assignment"])) {
        $class = $_POST["class"];
        $assignment = $_POST["assignment"];
        if($mode === "duedate") {
          if(is_valid_date($value)) {
            update_duedate($class, $assignment, $value);
          } else {
            handle_error("NEED A VALID DATE");
          }
        } else {
          if(is_valid_completion($value)) {
            update_completion($class, $assignment, $value);
          } else {
            handle_error("NEED A VALID COMPLETION STATUS");
          }
        }
      } else {
        handle_error("NEED A VALID CLASS AND ASSIGNMENT");
      }
    } else {
      handle_error("NEED AN UPDATE VALUE");
    }
  } else {
    handle_error("NEED A VALID MODE TO OPERATE");
  }

  function update_completion($class, $assignment, $value) {

  }

  function update_duedate($class, $assignment, $value) {

  }

  function is_valid_completion($status) {

  }

  function is_valid_date($date) {

  }
?>
