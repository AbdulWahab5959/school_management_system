<?php

require_once('../includes/db.php');
if (isset($_GET['id'])) {
  $teacher_id = $_GET['id']; 
  $disable = 0;

  $date = date('Y-m-d H:i:s');

      $sql_update = "UPDATE teacher SET status=?, updated_at=? WHERE id=?";
      $stmt = $pdo->prepare($sql_update);
      if ($stmt->execute([$disable, $date, $teacher_id])) {
          $success[] = "teacher Disable successfully.";
          header("Location: teacher.php");
          exit();
      }
      else {
          $error[] = "Error updating teacher information.";
      }
  } 
 else {
  echo "Error: teacher ID not provided.";
}
?>