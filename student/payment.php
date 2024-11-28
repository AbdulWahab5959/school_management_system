<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');


$errors = [];
$success = "";
$user_id = $_SESSION['student_id'];



if (isset($_SESSION["student_id"])) {
    $id = $_SESSION['student_id'];

    $sql = "SELECT * FROM student WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $name = $student['name'];
        $email = $student['email'];
    } else {
        $error[] = "Error: student not found.";
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
                        <?php
                        if (!empty($success)) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' .
                                $success .
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' .
                                '</div>';
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
                        <div class="col-md-3">

                            
                        </div>

                        <div class="col-md-6">
                        <div class="card">
                                <div class="card-header">
                                    <div class="card-title text-center">Fees Payments</div>
                                </div>
                                <div class="card-body">
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
                                        <div class="card-action text-center">
                                            <button class="btn btn-success" type="submit" name="profile_update">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('../includes/dashboard_footer.php'); ?>
</body>
</html>