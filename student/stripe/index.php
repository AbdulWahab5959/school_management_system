<?php

require_once 'config.php';
require_once('../includes/login_check.php');


$errors = [];
$success = "";
$user_id = $_SESSION['student_id'];

if (isset($_SESSION["student_id"])) {
    $student_id = $_SESSION['student_id'];

    // SQL query to fetch student and class fee details
    $sql = "SELECT 
                student.id AS student_id,
                student.name AS student_name,
                student.email AS student_email,
                class.id AS class_id,
                class.name AS class_name,
                class.section AS class_section,
                class.fees AS class_fees,
                fees.start_date,
                fees.end_date
            FROM 
                student
            JOIN 
                fees ON student.id = fees.student_id
            JOIN 
                class ON class.id = fees.class_id
            WHERE 
                student.id = ?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $details = $result->fetch_all(MYSQLI_ASSOC);

    if ($details) {
        foreach ($details as $detail) {
            $studentId = $detail['student_id'];
            $studentName = $detail['student_name'];
            $studentEmail = $detail['student_email'];
            $classId = $detail['class_id'];
            $className = $detail['class_name'].''.$detail['class_section'] ;
            $classFee = $detail['class_fees']; 
        }  
    } else {
        $errors[] = "No records found.";
    }
} else {
    $errors[] = "Student ID not found in session.";
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stripe JS library -->
    <title>stripe_integration</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="js/checkout.js" STRIPE_PUBLISHABLE_KEY="<?php echo STRIPE_PUBLISHABLE_KEY; ?>" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Fee Payment </h3>
                </div>
                <div class="panel-body">
                    <!-- Display status message -->
                    <div id="paymentResponse" class="hidden"></div>

                    <!-- Display a payment form -->
                    <form id="paymentFrm" class="hidden">
                        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                        <input type="hidden" name="student_id" value="<?php echo isset($studentId) ? $studentId : ''; ?>">
                        <input type="hidden" name="class_id" value="<?php echo isset($classId) ? $classId : ''; ?>">
                        <input type="hidden" name="class_fee" value="<?php echo isset($classFee) ? $classFee : ''; ?>">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($studentName) ? $studentName : ''; ?>" placeholder="Enter Name" />
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($studentEmail) ? $studentEmail : ''; ?>" placeholder="Enter Email" />
                        </div>

                        <div class="form-group">
                            <label for="class_name">Class Name</label>
                            <input type="text" class="form-control" id="class_name" name="class_name" required value="<?php echo isset($className) ? $className : ''; ?>" placeholder="Enter Class Name" />
                        </div>

                        <div class="form-group">
                            <label for="class_fee">Class Fee</label>
                            <input type="text" class="form-control" id="class_fee" name="class_fee" required value="<?php echo isset($classFee) ? $classFee : ''; ?>" placeholder="Enter Class Fee" />
                        </div>



                        <div id="paymentElement">
                            <!--Stripe.js injects the Payment Element-->
                        </div>

                        <!-- Form submit button -->
                        <button id="submitBtn" class="btn btn-success">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="buttonText">Pay Now</span>
                        </button>
                    </form>


                    <!-- Display processing notification -->
                    <div id="frmProcess" class="hidden">
                        <span class="ring"></span> Processing...
                    </div>

                    <!-- Display re-initiate button -->
                    <div id="payReinit" class="hidden">
                        <button class="btn btn-primary" onClick="window.location.href=window.location.href.split('?')[0]"><i class="rload"></i>Re-initiate Payment</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>

</body>

</html>