<?php
require_once('../includes/db.php');
require_once('includes/login_checks.php');


if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];
    $disable = 0;
    $date = date('Y-m-d H:i:s');
    $sql_update = "UPDATE teacher SET status=?, updated_at=? WHERE id=?";
    $stmt = $pdo->prepare($sql_update);
    
    if ($stmt->execute([$disable, $date, $teacher_id])) {
        header("Location: teacher.php");
        exit();
    } else {
        echo "Error updating teacher status.";
    }
} else {
    echo "Error: Teacher ID not provided.";
}
?>
