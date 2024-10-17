<?php
require_once('../includes/db.php');

$name = '';
$fees = '';
$section = '';
$teacher_id = '';



if (isset($_GET["id"])) {
    $student_id = $_GET['id'];

    $sql = "SELECT * FROM student WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $id = $student['id'];
        $name = $student['name'];
        $email = $student['email'];
        $number = $student['phone'];
        $class_id = $student['class_id'];
        $address = $student['address'];
    } else {
        $error[] = "Error: student not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_update'])) {
    $student_id = $_POST['id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $class = trim($_POST['class']);
    $number = $_POST['PhoneNo'];
    $address = $_POST['address'];
    $status = 1;
    $new_password = $_POST['password']; 
    $confirm_password = $_POST['confirm_password']; 
    
    if ($new_password !== $confirm_password) {
        $error[] = "Password and Confirm Password do not match.";
    } else {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['profile_image']['name'];
            $image_tmp_name = $_FILES['profile_image']['tmp_name'];
            $image_folder = '../dashboard_assets/img/uploads/' . $image_name;
            move_uploaded_file($image_tmp_name, $image_folder);
        } else {
            $image_folder = '';
        }
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql_update = "UPDATE student SET name=?, email=?, class_id=?, phone=?, status=?, profileimage=?,  address=?, password=? WHERE id=?";
        $stmt = $pdo->prepare($sql_update);
        if ($stmt->execute([$name, $email, $class, $number, $image_folder, $status, $address, $hashed_password, $student_id])) {
            header("Location: student.php");
          exit();

        } else {
            $error[] = "Error updating student information.";
        }
    }
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
                                    <div class="card-title text-center ">Registration Form </div>
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
                                                <input type="hidden" name="id" value="<?php echo isset($student_id) ? $student_id : ''; ?>">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        name="name"
                                                        required
                                                        value="<?php echo isset($name) ? $name : ''; ?>"
                                                        placeholder="Enter Name" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="email2">Email Address</label>
                                                    <input
                                                        type="email"
                                                        class="form-control"
                                                        id="email"
                                                        name="email"
                                                        required
                                                        value="<?php echo isset($email) ? $email : ''; ?>"
                                                        placeholder="Enter Email" />
                                                    
                                                </div>

                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="password"
                                                        name="password"
                                                        required
                                                        placeholder="Password" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm_password">Confirm Password</label>
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="confirm_password"
                                                        name="confirm_password"
                                                        required
                                                        placeholder="Confirm Password" />
                                                </div> 
                                                    <?php
                                                    $s = "SELECT class.id, class.name, class.section, COUNT(student.id) AS max_student , class.strength
                                                    FROM class
                                                    LEFT JOIN student ON class.id = student.class_id
                                                    GROUP BY class.id, class.name, class.section, class.strength
                                                    HAVING COUNT(student.id) < class.strength";
                                                        $sth = $pdo->prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                                                        $sth->execute();
                                                        ?>
                                                        <div class="form-group">
                                                            <label for="class">Choose a class</label>
                                                            <select name="class" class="form-select">
                                                                <?php
                                                                if ($sth->rowCount() > 0) {
                                                                    while ($row = $sth->fetch()) {
                                                                        echo "<option value='" . $row["id"] . "'>" . $row["name"] . " " . $row["section"] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option>No classes available</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                <div class="form-group">
                                                    <label for="PhoneNo">Phone </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="PhoneNo"
                                                        name="PhoneNo"
                                                        required
                                                        value="<?php echo isset($number) ? $number : ''; ?>"
                                                        placeholder="Enter Phone Number" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="profile_image">Profile Image</label>
                                                    <input
                                                        type="file"
                                                        class="form-control-file"
                                                        id="profile_image"
                                                        name="profile_image" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <input
                                                        class="form-control"
                                                        id="address"
                                                        name="address"
                                                        rows="3"
                                                        required
                                                        value="<?php echo isset($address) ? $address : ''; ?>"
                                                        placeholder="Enter Address" />
                                                </div>

                                                <div class="card-action">
                                                    <button class="btn btn-success" type="submit" name="student_update">Submit</button>
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