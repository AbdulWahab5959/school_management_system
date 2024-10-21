<?php
require_once('../includes/db.php');

$name = '';
$email = '';
$number = '';
$address = '';

if (isset($_GET["id"])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM teacher WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC); 
    
    if ($teacher) {
        $name = $teacher['name'];
        $email = $teacher['email'];
        $number = $teacher['phone'];
        $address = $teacher['address'];

    } else {
        $error[] = "Error: teacher not found.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['profile_update'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $number = $_POST['PhoneNo'];
    $address = $_POST['address'];
    $date = date('Y-m-d H:i:s');

    $sql_update = "UPDATE teacher SET name=?, email=?, phone=?, address=?, updated_at=? WHERE id=?";
    $stmt = $pdo->prepare($sql_update);
    if ($stmt->execute([$name, $email, $number, $address, $date, $id])) {
        $success[] = "Teacher information updated successfully.";
        header("Location: teacher.php");
        exit();
    } else {
        $error[] = "Error updating teacher information.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('../includes/dashboard_header.php'); ?>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php require_once('includes/sidebar.inc.php'); ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <?php require_once('includes/navbar.inc.php'); ?>
            <!-- Dashboard started -->
            <div class="container">
                <div class="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title text-center">Teacher Form</div>
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

                                        if (isset($error) && count($error) > 0) {
                                            foreach ($error as $error_msg) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .
                                                    $error_msg .
                                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
                                                    '</div>';
                                            }
                                        }
                                        ?>
                                        <div class="col-md-4">
                                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">

                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($name) ? $name : ''; ?>" placeholder="Enter Name" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="email">Email Address</label>
                                                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($email) ? $email : ''; ?>" placeholder="Enter Email" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="PhoneNo">Phone</label>
                                                    <input type="text" class="form-control" id="PhoneNo" name="PhoneNo" required value="<?php echo isset($number) ? $number : ''; ?>" placeholder="Enter Phone Number" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address" required value="<?php echo isset($address) ? $address : ''; ?>" placeholder="Enter Address" />
                                                </div>

                                                <div class="card-action text-center">
                                                    <button class="btn btn-success" type="submit" name="profile_update">Submit</button>
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
    </div>
    <?php require_once('../includes/dashboard_footer.php'); ?>
</body>

</html>
