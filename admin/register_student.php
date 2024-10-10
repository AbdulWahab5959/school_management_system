<?php

require_once('../includes/db.php');

if (isset($_POST['submit'])) {
    if (
        isset($_POST['name'], $_POST['address'], $_POST['email'], $_POST['password'], $_POST['PhoneNo']) &&
        !empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['email']) && 
        !empty($_POST['password']) && !empty($_POST['PhoneNo'])
    ) {

        $name = trim($_POST['name']);
        $address = trim($_POST['address']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['PhoneNo']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        
        if ($password === $confirm_password) {
            $options = array("cost" => 4);
            $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
            $date = date('Y-m-d H:i:s');

           
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql = 'SELECT * FROM student WHERE email = :email';
                $stmt = $pdo->prepare($sql);
                $p = ['email' => $email];
                $stmt->execute($p);

              
                if ($stmt->rowCount() == 0) {
                    
                    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                        $image_name = $_FILES['profile_image']['name'];
                        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
                        $image_folder = '../dashboard_assets/img/uploads/' . $image_name;
                        move_uploaded_file($image_tmp_name, $image_folder);
                    } else {
                        $image_folder = ''; 
                    }

                    $sql = "INSERT INTO student (name,  phone, email, `password`, profileimage, address,  created_at, updated_at) 
                            VALUES (:name,  :phone, :email, :password, :profileimage, :address,  :created_at, :updated_at)";

                    try {
                        $handle = $pdo->prepare($sql);
                        $params = [
                            ':name' => $name,
                            ':address' => $address,
                            ':phone' => $phone,
                            ':email' => $email,
                            ':password' => $hashPassword,
                            ':profileimage' => $image_folder,
                            ':created_at' => $date,
                            ':updated_at' => $date
                        ];

                        $handle->execute($params);
                        $success[] = 'Student has been registered successfully';
                    } catch (PDOException $e) {
                        $errors[] = $e->getMessage();
                    }
                } else {
                    $errors[] = 'Email address already registered';
                }
            } else {
                $errors[] = "Email address is not valid";
            }
        } else {
            $errors[] = "Passwords do not match";
        }
    } else {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errors[] = 'Name is required';
        }

        if (!isset($_POST['address']) || empty($_POST['address'])) {
            $errors[] = 'Address is required';
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors[] = 'Email is required';
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors[] = 'Password is required';
        }

        if (!isset($_POST['PhoneNo']) || empty($_POST['PhoneNo'])) {
            $errors[] = 'Phone number is required';
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
        href="../dashboard_assets/img/kaiadmin/favicon.ico"
        type="image/x-icon" />
    <link rel="stylesheet" href="../dashboard_assets/css/bootstrap.min.css" />

    <link rel="stylesheet" href="../dashboard_assets/css/style.css">
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
                    <h1> Welcome Back </h1>
                    <a class="btn bg-light text-black" href="index.php">Go Back Home</a>
                </div>
            </div>
            <div class="col-right">
                <div class="login-form">
                    <h2>Register</h2>
                    <form method="POST" enctype='multipart/form-data' action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <p>
                            <label for="name"> Name:<span>*</span></label>
                            <input type="text" id="name" name="name" placeholder="Name" required>
                        </p>
                        <p>
                            <label for="email"> Email address:<span>*</span></label>
                            <input type="text" id="email" name="email" placeholder="Username or Email" required>
                        </p>
                        <p>
                            <label for="PhoneNo">Phone Number:<span>*</span></label>
                            <input type="text" id="PhoneNo" name="PhoneNo" placeholder="Phone Number" required>
                        </p>
                        <p>
                            <label for="password">Password:<span>*</span></label>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                        </p>
                        <p>
                            <label for="confirm_password">Password:<span>*</span></label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                        </p>
                        <p>
                            <label for="profile_image">Profile Image:<span>*</span></label>
                            <input type="file" id="profile_image" name="profile_image" placeholder="Upload your profile picture" required>
                        </p>     
                        <p>
                            <label for="address">Address:<span>*</span></label>
                            <textarea  id="address" name="address" ></textarea>
                        </p>     
                        <p>
                            <input type="submit" name="submit" value="Sing Up" />
                        </p>
                       
                    </form>
                </div>
            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="../dashboard_assets/js/core/bootstrap.min.js"></script>
</body>

</html>