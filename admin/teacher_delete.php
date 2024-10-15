<?php
require_once('../includes/db.php');

if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];
    $disable = 0;
    $date = date('Y-m-d H:i:s');

    $sql = "DELETE FROM teacher WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt !== false) {
        $stmt->bindParam(':id', $teacher_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $sql = "SELECT * FROM class WHERE teacher_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$teacher_id]);
            $class = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($class) {
                $sql_update = "UPDATE class SET status=?, teacher_id=? WHERE teacher_id=?";
                $stmt = $pdo->prepare($sql_update);

                if ($stmt->execute([0, NULL, $teacher_id])) {
                    header("Location: teacher.php");
                    exit();
                } else {
                    echo "Error updating class information.";
                }
            } else {
                echo "No classes found for this teacher.";
            }
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
