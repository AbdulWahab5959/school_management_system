<?php
require_once('../includes/db.php');

$errors = [];
$success = "";

if (isset($_POST['update_password'])) {
    $currentPassword = trim($_POST['current_password']);
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $teacherId = $_SESSION['id'];

    if (!empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
        if ($newPassword === $confirmPassword) {
            $sql = "SELECT password FROM teacher WHERE id = :id";
            $handle = $pdo->prepare($sql);
            $params = ['id' => $teacherId];
            $handle->execute($params);
            $getRow = $handle->fetch(PDO::FETCH_ASSOC);

            if ($getRow && password_verify($currentPassword, $getRow['password'])) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateSql = "UPDATE teacher SET password = :password WHERE id = :id";
                $updateStmt = $pdo->prepare($updateSql);
                $updateParams = ['password' => $hashedPassword, 'id' => $teacherId];

                if ($updateStmt->execute($updateParams)) {
                    $success = "Password updated successfully!";
                } else {
                    $errors[] = "Error updating password. Please try again.";
                }
            } else {
                $errors[] = "Invalid current password.";
            }
        } else {
            $errors[] = "New password and confirm password do not match.";
        }
    } else {
        $errors[] = "All fields are required.";
    }
}


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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title text-center">Update Profile Information</div>
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

                            <div class="form-group">
                                <label for="PhoneNo">Phone</label>
                                <input type="text" class="form-control" id="PhoneNo" name="PhoneNo" required value="<?php echo isset($number) ? $number : ''; ?>" placeholder="Enter Phone Number" />
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required value="<?php echo isset($address) ? $address : ''; ?>" placeholder="Enter Address" />
                            </div>

                            <div class="card-action text-center">
                                <button class="btn btn-success" type="submit" name="profile_update">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title text-center">Change Password</div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required placeholder="Enter Current Password" />
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required placeholder="Enter New Password" />
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Confirm New Password" />
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="showPasswordCheck">
                                <label class="form-check-label" for="showPasswordCheck">Show Password</label>
                            </div>

                            <div class="card-action text-center">
                                <button class="btn btn-primary" type="submit" name="update_password">Update Password</button>
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
<?php require_once('../includes/dashboard_footer.php'); ?>
</body>

<script>
    const showPasswordCheck = document.getElementById('showPasswordCheck');
    const passwordFields = [document.getElementById('current_password'), document.getElementById('new_password'), document.getElementById('confirm_password')];

    showPasswordCheck.addEventListener('change', () => {
        passwordFields.forEach(field => {
            field.type = showPasswordCheck.checked ? 'text' : 'password';
        });
    });
    </script>

</html>