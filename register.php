<?php

require_once('includes/db.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['name'], $_POST['user_type'], $_POST['email'], $_POST['password']) && 
        !empty($_POST['name']) && !empty($_POST['user_type']) && !empty($_POST['email']) && !empty($_POST['password'])) {

        $Name = trim($_POST['name']);
        $user_type = trim($_POST['user_type']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        if ($password == $confirm_password) {
            $options = array("cost" => 4);
            $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
            $date = date('Y-m-d H:i:s');

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql = 'select * from staff where email = :email';
                $stmt = $pdo->prepare($sql);
                $p = ['email' => $email];
                $stmt->execute($p);

                if ($stmt->rowCount() == 0) {
                    $sql = "insert into staff (name, user_type, email, `password`, created_at, updated_at) 
                            values(:name, :user_type, :email, :password, :created_at, :updated_at)";

                    try {
                        $handle = $pdo->prepare($sql);
                        $params = [
                            ':name' => $Name,
                            ':user_type' => $user_type,
                            ':email' => $email,
                            ':password' => $hashPassword,
                            ':created_at' => $date,
                            ':updated_at' => $date
                        ];

                        $handle->execute($params);
                        $success [] = 'User has been created successfully';
                    } catch (PDOException $e) {
                        $errors[] = $e->getMessage();
                    }
                } else {
                    $vauser_type = $Name;
                    $valuser_type = $user_type;
                    $valEmail = '';
                    $valPassword = $password;

                    $errors[] = 'Email address already registered';
                }
            } else {
                $errors[] = "Email address is not valid";
            }
        } else {
            $errors[] = "Passwords are not the same";
        }
    } else {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errors[] = 'First name is required';
        } else {
            $vauser_type = $_POST['name'];
        }

        if (!isset($_POST['user_type']) || empty($_POST['user_type'])) {
            $errors[] = 'User type is required';
        } else {
            $valuser_type = $_POST['user_type'];
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors[] = 'Email is required';
        } else {
            $valEmail = $_POST['email'];
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors[] = 'Password is required';
        } else {
            $valPassword = $_POST['password'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> User Login</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link
        rel="icon"
        href="dashboard_assets/img/kaiadmin/favicon.ico"
        type="image/x-icon" />
    <link rel="stylesheet" href="dashboard_assets/css/bootstrap.min.css" />

    <link rel="stylesheet" href="dashboard_assets/css/style.css">
</head>

<body>
    <div class="wrapper">
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

        <div class="container">
            <div class="col-left">
                <div class="login-text">
                    <h1> Welcome </h1>
                    <p>I You have account.<br>It's totally free.</p>
                    <a class="btn" href="login.php">Sign In</a>
                </div>
            </div>
            <div class="col-right">
                <div class="login-form">
                    <h2>Register</h2>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <p>
                            <label for="name"> Name<span>*</span></label>
                            <input type="text" id="name" name="name" placeholder="Name" required>
                        </p>
                        <p>
                            <label for="email"> Email address<span>*</span></label>
                            <input type="text" id="email" name="email" placeholder="Username or Email" required>
                        </p>
                        <p>
                            <label for="password">Password<span>*</span></label>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                        </p>
                        <p>
                            <label for="confirm_password">Password<span>*</span></label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                        </p>
                               <p>
                                
                               </p>    
                        <p>
                            <input type="submit" name="submit" value="Sing Up" />
                        </p>
                        <p>
                            <a href="">Forget Password?</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="dashboard_assets/js/core/bootstrap.min.js"></script>
</body>

</html>