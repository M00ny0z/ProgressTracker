<?php
  // include("common.php");
  // $db = get_PDO();

  if(isset($_POST["mode"]) && is_valid_mode($_POST["mode"])) {
    $mode = $_POST["mode"];
    if($mode === "add" && isset($_POST["assignment"]) && isset($_POST["duedate"]) &&
      isset($_POST["class"])) {
      add_assignment($_POST["class"], $_POST["assignment"], $_POST["duedate"]);
    } else if($mode === "remove" && $_POST["assignment"]) {
      remove_assignment();
    } else if() {
      update_assignment();
    } else if() {
      add_class();
    } else if() {
      remove_all();
    }
  }

  function is_valid_mode($mode) {
    $valid_modes = array("add", "remove", "update", "autoClass", "removeAll");
    return in_array($mode, $valid_modes);
  }

  function add_assignment($netid, $class, $assignment, $duedate) {
    echo "Class: " . $class . " Assignment: " . $assignment . " Due date: " . $duedate;
  }
?>
