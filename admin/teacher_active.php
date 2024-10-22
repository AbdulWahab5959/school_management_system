<?php
require_once('../includes/db.php');

if (isset($_GET["id"])) {
    $teacher_id = $_GET['id'];
    $status = 1; 
    $date = date('Y-m-d H:i:s');


    $sql_update = "UPDATE teacher SET status = ?, updated_at=? WHERE id = ?";

    
    $stmt = $pdo->prepare($sql_update);
    if ($stmt->execute([$status, $date, $teacher_id])) {
        header("Location: teacher.php");
        exit();
    } else {
        echo "Error: Could not update the teacher's status.";
    }
} else {
    echo "Error: Teacher ID not provided.";
}
?>
