<?php

require_once('../includes/db.php');
if (isset($_GET['id'])) {
  $student_id = $_GET['id']; 
  $disable = 0;

  $date = date('Y-m-d H:i:s');

      $sql_update = "UPDATE student SET status=?, class_id=?,  updated_at=? WHERE id=?";
      $stmt = $pdo->prepare($sql_update);
      if ($stmt->execute([$disable, null,  $date, $student_id])) {
          $success[] = "student Disable successfully.";
          header("Location: student.php");
          exit();
      }
      
      else {
          $error[] = "Error updating student information.";
      }
  } 
 else {
  echo "Error: student ID not provided.";
}
?>