<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$dsn = 'mysql:dbname=school_management_system;host=localhost';
$user = 'root';
$password = '';
 
try
{
	$pdo = new PDO($dsn,$user,$password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo "PDO error".$e->getMessage();
	die();
}
?>