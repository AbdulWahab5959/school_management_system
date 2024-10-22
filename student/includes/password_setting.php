<?php
require_once('../includes/db.php');

// Initialize error and success messages
$errors = [];
$success = "";

// Check if the form is submitted
if (isset($_POST['update_password'])) {
    $currentPassword = trim($_POST['current_password']);
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $teacherId = $_SESSION['id']; // Assuming the user is logged in

    // Validate input fields
    if (!empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
        // Check if new password and confirm password match
        if ($newPassword === $confirmPassword) {
            // Retrieve the current password from the database
            $sql = "SELECT password FROM teacher WHERE id = :id";
            $handle = $pdo->prepare($sql);
            $params = ['id' => $teacherId];
            $handle->execute($params);
            $getRow = $handle->fetch(PDO::FETCH_ASSOC);

            // Verify the current password
            if ($getRow && password_verify($currentPassword, $getRow['password'])) {
                // Hash the new password and update it in the database
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dashboard_assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../dashboard_assets/css/style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <h3 class="text-center mb-4">Update Password</h3>

                    <?php
                    if (!empty($success)) {
                        echo '<div class="alert alert-success">' . $success . '</div>';
                    }

                    if (!empty($errors)) {
                        foreach ($errors as $error) {
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                    }
                    ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="showPasswordCheck">
                            <label class="form-check-label" for="showPasswordCheck">Show Password</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="update_password" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const showPasswordCheck = document.getElementById('showPasswordCheck');
        const passwordFields = [document.getElementById('current_password'), document.getElementById('new_password'), document.getElementById('confirm_password')];

        showPasswordCheck.addEventListener('change', () => {
            passwordFields.forEach(field => {
                field.type = showPasswordCheck.checked ? 'text' : 'password';
            });
        });
    </script>

    <script src="../dashboard_assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
