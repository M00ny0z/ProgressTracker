<?php
  include("common.php");
  $db = get_PDO();
  $NETID = "em66";

  if(isset($_GET["mode"]) && is_valid_mode($_GET["mode"])) {
    $mode = $_GET["mode"];
    if($mode === "getClasses") {
      header("Content-Type: application/json");
      $output = array();
      $output["classes"] = get_classes($NETID, $db);
      print(json_encode($output));
    } else if($mode === "getAssigns") {
      if(isset($_GET["class"])) {
        $class = $_GET["class"];
        header("Content-Type: application/json");
        $output = array();
        $output["assignments"] = get_assignments($NETID, $db, $class);
        print(json_encode($output));
      } else {
        handle_error("NEED A VALID CLASS TO GET ASSIGNMENTS FOR!");
      }
    }
  }

  function get_assignments($NETID, $db, $class) {
    try {
      $assign_list = array();
      $query = "SELECT *
                FROM Assignments a
                WHERE a.class = " . "'" . $class . "';";
      $assignments = $db->query($query);
      foreach($assignments as $ass) {
        $new_assignment = array();
        $new_assignment["name"] = $ass["name"];
        $new_assignment["completion"] = $ass["completion"];
        $new_assignment["grade"] = $ass["grade"];
        $new_assignment["duedate"] = $ass["duedate"];
        $new_assignment["turnin"] = $ass["turnin"];
        array_push($assign_list, $new_assignment);
      }
      return $assign_list;
    } catch(PDOException $ex) {
      handle_error("Doesnt work!");
    }
  }

  function get_classes($NETID, $db) {
    try {
      $class_list = array();
      $query = "SELECT e.class
                FROM Enrolls e
                WHERE e.netid = '" . $NETID . "';";
      $classes = $db->query($query);
      foreach($classes as $class) {
        array_push($class_list, $class["class"]);
      }
      return $class_list;
    } catch(PDOException $ex) {
      handle_error("Doesnt work!");
    }
  }

  function is_valid_mode($param) {
    $VALID_MODES = array("getClasses", "getAssigns");
    return in_array($param, $VALID_MODES);
  }
?>
