<?php

require_once('../includes/db.php');
if (isset($_GET['id'])) {
  $class_id = $_GET['id'];
  $sql = "SELECT * FROM class WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$class_id]);
    $class = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($class) {
      
        $sql = "DELETE FROM class WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        if ($stmt !== false) {
        $stmt->bindParam(':id', $class_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
       
          header("Location: class.php");
          exit();
        
          
        
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