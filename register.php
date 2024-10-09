<?php

require_once('includes/db.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['name'], $_POST['email'], $_POST['password']) && 
        !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {

        $Name = trim($_POST['name']);
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
                    $sql = "insert into staff (name, email, `password`, created_at, updated_at) 
                            values(:name, :email, :password, :created_at, :updated_at)";

                    try {
                        $handle = $pdo->prepare($sql);
                        $params = [
                            ':name' => $Name,
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
                    $valName = $Name;
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
            $errors[] = 'Name is required';
        } else {
            $valName = $_POST['name'];
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
