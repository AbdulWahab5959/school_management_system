<?php

require_once('../includes/db.php');
if (isset($_GET['id'])) {
  $class_id = $_GET['id'];
  $sql = "SELECT * FROM class WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$class_id]);
    $class = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($class) {
      
        $teacher_id = $class['teacher_id'];
        $sql = "DELETE FROM class WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        if ($stmt !== false) {
        $stmt->bindParam(':id', $class_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
        $date = date('Y-m-d H:i:s');
        $sql_update = "UPDATE teacher SET status=?, updated_at=? WHERE id=?";
        $stmt = $pdo->prepare($sql_update);
        if ($stmt->execute([0, $date, $teacher_id])) {
          header("Location: class.php");
          exit();
        }
        else {
            $error[] = "Error updating teacher information.";
        }
          
        
      } else {
          echo "Error: " . $stmt->errorInfo()[1];
      }
  } else {
      echo "Error: Unable to prepare SQL statement: " . $pdo->errorInfo()[2];
  }
    } else {
        $error[] = "Error: class not found.";
    }
} else {
  echo "Error: class ID not provided.";
}
?>