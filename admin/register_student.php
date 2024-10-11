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
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        name="name"
                                                        required
                                                        placeholder="Enter Name" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="email2">Email Address</label>
                                                    <input
                                                        type="email"
                                                        class="form-control"
                                                        id="email2"
                                                        name="email"
                                                        required
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

                                                <div class="form-group">
                                                    <label for="PhoneNo">Phone </label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="PhoneNo"
                                                        name="PhoneNo"
                                                        required
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
                                                    <textarea
                                                        class="form-control"
                                                        id="address"
                                                        name="address"
                                                        rows="3"
                                                        required
                                                        placeholder="Enter Address"></textarea>
                                                </div>

                                                <div class="card-action">
                                                    <button class="btn btn-success" type="submit" name="submit">Submit</button>
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