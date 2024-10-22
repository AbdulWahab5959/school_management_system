<?php

$password = '123';
$options = array("cost" => 4);
$hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);

echo $hashPassword;