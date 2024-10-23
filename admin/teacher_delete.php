<?php
require_once('../includes/db.php');
require_once('includes/login_checks.php');


if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];
    $sql = "DELETE FROM teacher WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    if ($stmt !== false) {
        $stmt->bindParam(':id', $teacher_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: teacher.php");
            exit();
        } else {
            echo "Error deleting teacher.";
        }
    } else {
        echo "Error: Unable to prepare SQL statement.";
    }
} else {
    echo "Error: Teacher ID not provided.";
}
?>
