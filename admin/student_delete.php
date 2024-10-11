<?php

require_once('../includes/db.php');
if (isset($_GET['id'])) {
  $student_id = $_GET['id'];

  $sql = "DELETE FROM student WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  if ($stmt !== false) {
      $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);

      if ($stmt->execute()) {
        $success[] = "student information deleted successfully.";
          header("Location: student.php");
          exit();
      } else {
          echo "Error: " . $stmt->errorInfo()[1];
      }
  } else {
      echo "Error: Unable to prepare SQL statement: " . $pdo->errorInfo()[2];
  }
} else {
  echo "Error: student ID not provided.";
}
?>