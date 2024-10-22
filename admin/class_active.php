<?php
require_once('../includes/db.php');


if (isset($_GET["id"])) {
    $class_id = $_GET['id'];

    $sql = "SELECT * FROM class WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$class_id]);
    $class = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($class) {
       

        $sql_update = "UPDATE class SET status=1 , updated_at=? WHERE id=?";
        $stmt = $pdo->prepare($sql_update);
        $stmt->execute([$date, $class_id]);
                header("Location: class.php");
                exit();
        } 
        else {
            $error[] = "Error updating class information.";
        }
        }
        else {
            $error[] = "Error updating class information.";
        }


?>
