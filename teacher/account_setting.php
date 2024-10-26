<?php
require_once('../includes/db.php');
require_once('includes/login_check.php');


$errors = [];
$success = "";
$user_id =$_SESSION['teacher_id'] ;

if (isset($_POST['update_password'])) {
    $currentPassword = trim($_POST['current_password']);
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $teacherId = $_SESSION['teacher_id'];

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

if (isset($_SESSION["teacher_id"])) {
    $id = $_SESSION['teacher_id'];

    $sql = "SELECT * FROM teacher WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($teacher) {
        $name = $teacher['name'];
        $email = $teacher['email'];
        $number = $teacher['phone'];
        $address = $teacher['address'];
        $profile_image = $teacher['profileimage'];

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
        $success="Teacher information updated successfully.";
    } else {
        $error[] = "Error updating teacher information.";
    }
}
if (isset($_POST['image_profile'])) {
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_name = $_FILES['profile_picture']['name'];
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_types)) {
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_dir = '../uploads/';
            $upload_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                $teacher_id = $_SESSION['teacher_id'];

                $update_query = "UPDATE teacher SET profileimage = :profileimage WHERE id = :id";
                $stmt = $pdo->prepare($update_query);
                $stmt->bindParam(':profileimage', $upload_path);
                $stmt->bindParam(':id', $teacher_id, PDO::PARAM_INT);

                if ($stmt->execute()) {

                    $success = "Profile picture updated successfully!";
                    header("Location: account_setting.php");
                    exit();
                } else {
                    $errors[] = "Failed to update profile picture.";
                }
            } else {
                $errors[] = "Failed to upload the profile picture.";
            }
        } else {
            $errors[] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        $errors[] = "No file uploaded or an error occurred during the upload.";
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
                                        if (!empty($success) ) {
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
                        <div class="col-md-4">
                    
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
                                            <button class="btn btn-success" type="submit" name="profile_update">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
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
                        <div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <div class="card-title text-center">Profile Image</div>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <div class="form-group text-center mb-4">
                    <?php
                    $profile_image = !empty($teacher['profileimage']) ? $teacher['profileimage'] : 'default-profile.png'; // Fetch from DB
                    ?>
                    <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="img-thumbnail" width="150" height="150" />
                </div>
                
                <div class="form-group mb-3">
                    <label for="profile_picture">Update Profile Picture</label>
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" />
                </div>
                <div class="card-action text-center">
                    <button class="btn btn-primary" type="submit" name="image_profile">Profile Image</button>
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