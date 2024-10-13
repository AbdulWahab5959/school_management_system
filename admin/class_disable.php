<?php

require_once('../includes/db.php');
if (isset($_GET['id'])) {
  $class_id = $_GET['id']; 
  $disable = 0;

  $date = date('Y-m-d H:i:s');

      $sql_update = "UPDATE class SET status=?, teacher_id=?,  updated_at=? WHERE id=?";
      $stmt = $pdo->prepare($sql_update);
      if ($stmt->execute([$disable, null,  $date, $class_id])) {
          $success[] = "class Disable successfully.";
          header("Location: class.php");
          exit();
      }
      
      else {
          $error[] = "Error updating class information.";
      }
  } 
 else {
  echo "Error: class ID not provided.";
}
?>