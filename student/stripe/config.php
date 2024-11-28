<?php
session_start();
// Product Details 
// Minimum amount is $0.50 US 

define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51PKE43P4MlQ6Ml8IELvrOgrYshpeMOMt6DdXtJ3prtz7hcHVsymtOi4Py04sUVJlXY6PYQ9SDgah4l8c4XDjD7BB00zmZsGlai');
define('STRIPE_SECRET_KEY', 'sk_test_51PKE43P4MlQ6Ml8IppoPXJ2PNMmLmTjP5TdKX38RdxE90DQemiMXRffSu8K5Uk8CTSJrtWx6eJ4DB4liXSuH0HM100ZWWBKW0x');

// Database configuration  
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'school_management_system');

// Connect with the database  
$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Display error if failed to connect  
if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
} // Added closing bracket
