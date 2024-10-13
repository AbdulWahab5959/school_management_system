<?php
require_once('../includes/db.php');

$name = '';
$fees = '';
$section = '';


if (isset($_GET["id"])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM class WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $class = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($class) {
        $id = $class['id'];
        $class_name = $class['name'];
        $fees = $class['fees'];
        $section = $class['section'];
        $teacher_id = $class['teacher_id'];
    } else {
        $error[] = "Error: class not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_update'])) {
    $id = $_POST['id'];
    $fees = $_POST['fees'];
    $name = $_POST['name'];
    $teacher = $_POST['teacher'];
    $section = $_POST['section'];
    $date = date('Y-m-d H:i:s');

        $sql_update = "UPDATE class SET name=?, fees=?,  section=?, teacher_id=?, updated_at=? WHERE id=?";
        $stmt = $pdo->prepare($sql_update);
        if ($stmt->execute([$name, $fees, $section, $teacher, $date, $id])) {
            $success[] = "class information updated successfully.";
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
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('../includes/dashboard_header.php')
    ?>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php
        require_once('includes/sidebar.inc.php')
        ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <?php
            require_once('includes/navbar.inc.php')
            ?>
            <!-- Dashboard started -->
            <div class="container">
                <div class="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title text-center ">Register Class Form </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mx-auto d-flex justify-content-center">
                                        <?php
                                        if (isset($success) && count($success) > 0) {
                                            foreach ($success as $success_msg) {
                                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' .
                                                    $success_msg .
                                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
                                                    '</div>';
                                            }
                                        }

                                        if (isset($errors) && count($errors) > 0) {
                                            foreach ($errors as $error_msg) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .
                                                    $error_msg .
                                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
                                                    '</div>';
                                            }
                                        }
                                        ?>
                                        <div class="col-md-4 col-lg-6">
                                            <form method="POST" enctype='multipart/form-data' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                                            <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        name="name"
                                                        required
                                                        value="<?php echo isset($class_name) ? $class_name : ''; ?>"
                                                        placeholder="Enter Name" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="fees">Fees</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="fees"
                                                        name="fees"
                                                        min="1000"
                                                        max="5000"
                                                        required
                                                        value="<?php echo isset($fees) ? $fees : ''; ?>"
                                                        placeholder="Enter Fees Between 1000 to 5000 " />

                                                </div>
                                                <div class="form-group">
                                                    <label for="section">Choose a Section</label>
                                                    <select class="form-select" name="section" id="section">
                                                    <option value="A" <?php echo $section == 'A'?'selected':'';?>>A</option>
                                                    <option value="B" <?php echo $section == 'B'?'selected':'';?>>B</option>
                                                    <option value="C" <?php echo $section == 'C'?'selected':'';?>>C</option>
                            
                                                    </select>
                                                </div>
                                                <?php
                                                    $s = "SELECT teacher.id, teacher.name 
                                                    FROM teacher  
                                                    LEFT JOIN class  
                                                    ON teacher.id = class.teacher_id 
                                                    WHERE class.teacher_id IS NULL OR class.teacher_id='$teacher_id'";
                                                $sth = $pdo->prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                                                $sth->execute();
                                                ?>
                                                
                                                <div class="form-group">
                                                    <label for="teacher">Choose a Teacher</label>

                                                    <select name="teacher" class="form-select">
                                                        <?php
                                                        if ($sth->rowCount() > 0) {
                                                            while ($row = $sth->fetch()){ 
                                                                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option>No teachers available</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="card-action">
                                                    <button class="btn btn-success" type="submit" name="class_update">Submit</button>
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once('../includes/dashboard_footer.php')
    ?>

</body>

</html>