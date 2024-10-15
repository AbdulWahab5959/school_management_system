<?php

require_once('../includes/db.php');
if (isset($_GET['id'])) {
  $class_id = $_GET['id']; 
  $disable = 0;
  $date = date('Y-m-d H:i:s');
  $sql = "SELECT * FROM class WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$class_id]);
    $class = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($class) {
        $teacher_id = $class['teacher_id'];
    } else {
        $error[] = "Error: class not found.";
    }
      $sql_update = "UPDATE class SET status=?, teacher_id=?,  updated_at=? WHERE id=?";
      $stmt = $pdo->prepare($sql_update);
      if ($stmt->execute([$disable, null,  $date, $class_id])) {
        $sql_update = "UPDATE teacher SET status=?, updated_at=? WHERE id=?";
        $stmt = $pdo->prepare($sql_update);
        if ($stmt->execute([$disable, $date, $teacher_id])) {
            $success[] = "teacher Disable successfully.";
            header("Location: class.php");
              exit();
        }
        else {
            $error[] = "Error updating teacher information.";
        }
      }
      
      else {
          $error[] = "Error updating class information.";
      }
  } 
 else {
  echo "Error: class ID not provided.";
}
?>