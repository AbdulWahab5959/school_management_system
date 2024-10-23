<?php
require_once('../includes/db.php');
require_once('includes/login_checks.php');


if (isset($_GET["id"])) {
    $student_id = $_GET['id'];
    $date = date('Y-m-d H:i:s');

    $sql_update = "UPDATE student SET updated_at=? , status=1 WHERE id = ?";
    $stmt = $pdo->prepare($sql_update);
    if ($stmt->execute([ $date, $student_id])) {
        header("Location: student.php");
        exit();
    } else {
        echo "Error updating student class status.";
    }
} else {
    echo "Error: Student ID not provided.";
}
?>
