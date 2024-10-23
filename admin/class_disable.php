<?php
require_once('../includes/db.php');

if (isset($_GET['id'])) {
    $class_id = $_GET['id'];
    $disable = 0;
    $date = date('Y-m-d H:i:s');

    $sql_update = "UPDATE class SET status = ?, updated_at = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql_update);

    if ($stmt->execute([$disable, $date, $class_id])) {
        header("Location: class.php");
        exit();
    } else {
        echo "Error updating class status.";
    }
} else {
    echo "Error: class ID not provided.";
}
?>
