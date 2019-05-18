<?php
  include("common.php");
  $db = get_PDO();
  $NETID = "em66";

  if(isset($_POST["mode"])) {
    $mode = $_POST["mode"];
    if(isset($_POST["class"])) {
      $class = $_POST["class"];
      if($mode === "autoClass"){
        auto_add_class($class, $db);
      } else if($mode === "addAssign"){
        if(isset($_POST["assignment"])) {
          add_assignment($class, $_POST["assignment"], $db);
        } else {
          handle_error("NEED AN ASSIGNMENT NAME");
        }
      } else if($mode === "addClass") {
        add_class($class, $db, $NETID);
      }
    } else {
      handle_error("NEED A CLASS TO ADD TO");
    }
  } else {
    handle_error("NEED A VALID MODE");
  }

  function add_class($class, $db, $NETID) {
    try {
      $query = "INSERT INTO Enrolls(class, netid) VALUES" .
               "('" . $class . "', '" . $NETID . "');";
      $db->query($query);
      $stmt = $db->prepare($query);
    } catch(PDOException $ex) {
      handle_error("Didnt work!");
    }
  }

  /**
   * Adds an assignment specified by the user to the database
   * @param $class {string} - The class to add the assignment to the database for
   * @param $assignment {string} - The assignment name
  */
  function add_assignment($class, $assignment, $db) {
    try {
      $query = "INSERT INTO Assignments" .
        " (netid, class, name, completion, grade, duedate, turnin) VALUES " .
        "(:netid, :class, :name, :completion, :grade, :duedate, :turnin);";
      $stmt = $db->prepare($query);
      $params = array("netid" => "em66",
                      "class" => $class,
                      "name" => $assignment,
                      "completion" => 0,
                      "grade" => NULL,
                      "duedate" => "2019-04-25 09:33:20",
                      "turnin" => NULL);
      $stmt->execute($params);
      $stmt->closeCursor();
    } catch(PDOException $ex) {
      handle_error(DATABASE_ERROR);
    }
  }

  /**
   * Adds an assignment specified by the user to the database
   * @param $class {string} - The class to add the assignment to the database for
   * @param $assignment {string} - The assignment name
  */
  function auto_add_class($class, $db) {
    header("Content-type: text/plain");
    $assignments = file("Classes/" . $class . ".txt");
    for($i = 0; $i < count($assignments); $i++) {
      $assignment = replace_all($assignments[$i], "_", " ");
      $assignment = substr($assignment, 0, strlen($assignment) - 2);
      add_assignment($class, $assignment, $db);
    }
  }
?>
