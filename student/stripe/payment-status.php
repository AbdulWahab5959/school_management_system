<?php 
// Include the configuration file  
require_once 'config.php'; 

// Include the database connection file  
require_once 'dbConnect.php'; 

$payment_ref_id = $statusMsg = ''; 
$status = 'error'; 

// Check whether the payment ID is not empty 
if(!empty($_GET['pid'])){ 
    $payment_txn_id  = base64_decode($_GET['pid']); 
    
    // Fetch transaction data from the database 
    $sqlQ = "SELECT id,txn_id,paid_amount,paid_amount_currency,payment_status,customer_name,customer_email FROM transactions WHERE txn_id = ?"; 
    $stmt = $db->prepare($sqlQ);  
    $stmt->bind_param("s", $payment_txn_id); 
    $stmt->execute(); 
    $stmt->store_result(); 

    if($stmt->num_rows > 0){ 
        // Get transaction details 
        $stmt->bind_result($payment_ref_id, $txn_id, $paid_amount, $paid_amount_currency, $payment_status, $customer_name, $customer_email); 
        $stmt->fetch(); 
        
        $status = 'success'; 
        $statusMsg = 'Your Payment has been Successful!'; 
    }else{ 
        $statusMsg = "Transaction has been failed!"; 
    } 
}else{ 
    header("Location: index.php"); 
    exit; 
} 
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<style>
    .card {
        width: 100%;
        margin: 0 auto;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        background-color: #ffffff;
    }
    .card-header {
        background-color: seagreen;
        color: #ffffff;
        padding: 20px;
        border-radius: 10px 10px 0 0;
        text-align: center;
    }
    .card-header h1 {
        font-size: 24px;
        margin-bottom: 0;
    }
    .card-body {
        padding: 20px;
    }
    .card-body h4 {
        font-size: 20px;
        margin-top: 10px;
    }
    .card-body p {
        font-size: 16px;
    }
</style>
<body>
<div class="container mt-5">
    <div class="row ">
        <div class="col-md-3"></div>
        <div class="col-md-6 justify-content-center">
            <div class="card <?php echo ($status == 'success') ? 'border-success' : 'border-danger'; ?>">
                <div class="card-header <?php echo ($status == 'success') ? 'bg-success text-white' : 'bg-danger text-white'; ?>">
                    <h1 class="card-title"><?php echo $statusMsg; ?></h1>
                </div>
                <div class="card-body">
                    <?php if(!empty($payment_ref_id)){ ?>
                        <h4>Customer Payment Information</h4>
                        <p><b>Reference Number:</b> <?php echo $payment_ref_id; ?></p>
                        <p><b>Transaction ID:</b> <?php echo $txn_id; ?></p>
                        <p><b>Paid Amount:</b> <?php echo $paid_amount.' '.$paid_amount_currency; ?></p>
                        <p><b>Name:</b> <?php echo $customer_name; ?></p>
                        <p><b>Email:</b> <?php echo $customer_email; ?></p>
                        <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
                        
                        <?php }else{ ?>
                            <h1 class="text-danger">Your Payment has failed!</h1>
                            <p class="text-danger"><?php echo $statusMsg; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    
</body>
</html>
