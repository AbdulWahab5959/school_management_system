<?php
require_once('../includes/db.php');

if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];
    $disable = 0;
    $date = date('Y-m-d H:i:s');

    // Update teacher status
    $sql_update = "UPDATE teacher SET status=?, updated_at=? WHERE id=?";
    $stmt = $pdo->prepare($sql_update);

    if ($stmt->execute([$disable, $date, $teacher_id])) {
        // Check for classes assigned to the teacher
        $sql = "SELECT * FROM class WHERE teacher_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$teacher_id]);
        $class = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($class) {
            // Update class to remove teacher association
            $sql_update = "UPDATE class SET status=?, teacher_id=? WHERE teacher_id=?";
            $stmt = $pdo->prepare($sql_update);

            if ($stmt->execute([0, NULL, $teacher_id])) {
                header("Location: teacher.php");
                exit();
            } else {
                $error[] = "Error updating class information.";
            }
        } else {
            $error[] = "No classes found for this teacher.";
        }
    } else {
        $error[] = "Error updating teacher status.";
    }
} else {
    echo "Error: Teacher ID not provided.";
}
?>
