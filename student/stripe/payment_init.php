<?php 
 
// Include the configuration file 
require_once 'config.php'; 
 
// Include the Stripe PHP library 
require_once 'stripe-php/init.php'; 
 
// Set API key 
$stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY); 
 
// Retrieve JSON from POST body 
$jsonStr = file_get_contents('php://input'); 
$jsonObj = json_decode($jsonStr); 
 
if ($jsonObj->request_type == 'create_payment_intent') {
    $id = isset($jsonObj->id) ? trim($jsonObj->id) : '';
    $name = isset($jsonObj->name) ? trim($jsonObj->name) : '';
    $email = isset($jsonObj->email) ? trim($jsonObj->email) : '';
    $className = isset($jsonObj->item_name) ? trim($jsonObj->item_name) : '';
    $itemPrice = isset($jsonObj->item_price) ? (float)trim($jsonObj->item_price) : 0.0;
    $currency = isset($jsonObj->currency) ? trim($jsonObj->currency) : 'pkr';

    if (empty($name) || empty($email) || empty($className) || $itemPrice <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input data!']);
        exit;
    }

    try {
        $itemPriceCents = round($itemPrice * 100); // Convert price to cents
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $itemPriceCents,
            'currency' => $currency,
            'description' => "Fee submitted of $className  by id:$id , name: $name and email: $email account of $itemPrice ",
            'payment_method_types' => ['card'],
            'metadata' => [
                'customer_name' => $name,
                'customer_email' => $email,
                'item_name' => $className,
                'item_price' => $itemPrice
            ]
        ]);

     
        $output = [ 
            'id' => $paymentIntent->id, 
            'clientSecret' => $paymentIntent->client_secret 
        ]; 
     
        echo json_encode($output); 
    } catch (Error $e) { 
        http_response_code(500); 
        echo json_encode(['error' => $e->getMessage()]); 
    } 
}elseif($jsonObj->request_type == 'create_customer'){ 
    $payment_intent_id = !empty($jsonObj->payment_intent_id)?$jsonObj->payment_intent_id:''; 
    $name = !empty($jsonObj->name)?$jsonObj->name:''; 
    $email = !empty($jsonObj->email)?$jsonObj->email:''; 
 
    // Check if PaymentIntent already has a customer 
    if(!empty($payment_intent_id)){ 
        $paymentIntent = $stripe->paymentIntents->retrieve($payment_intent_id); 
        if(!empty($paymentIntent->customer)){ 
            $customer_id = $paymentIntent->customer; 
        } 
    } 
     
    // Add customer to stripe if not created already 
    if(empty($customer_id)){ 
        try {   
            $customer = $stripe->customers->create([ 
                'name' => $name,  
                'email' => $email 
            ]);  
            $customer_id = $customer->id; 
        }catch(Error $e) {   
            $api_error = $e->getMessage();   
        } 
    } 
     
    if(empty($api_error) && !empty($customer_id)){ 
        try { 
            // Update PaymentIntent with the customer ID 
            $paymentIntent = $stripe->paymentIntents->update($payment_intent_id, [ 
                'customer' => $customer_id 
            ]); 
        } catch (Error $e) {  
            $api_error = $e->getMessage();  
        } 
         
        if(empty($api_error) && $paymentIntent){ 
            $output = [ 
                'id' => $payment_intent_id, 
                'customer_id' => $customer_id 
            ]; 
            echo json_encode($output); 
        }else{ 
            http_response_code(500); 
            echo json_encode(['error' => $api_error]); 
        } 
    }else{ 
        http_response_code(500); 
        echo json_encode(['error' => $api_error]); 
    } 
}elseif($jsonObj->request_type == 'payment_insert'){ 
    $payment_intent = !empty($jsonObj->payment_intent)?$jsonObj->payment_intent:''; 
    $customer_id = !empty($jsonObj->customer_id)?$jsonObj->customer_id:''; 
     
    // Retrieve customer info 
    try {   
        $customer = $stripe->customers->retrieve($customer_id);  
    }catch(Error $e) {   
        $api_error = $e->getMessage();   
    } 
     
    // Check whether the charge was successful 
    if(!empty($payment_intent) && $payment_intent->status == 'succeeded'){ 
        // Transaction details  
        $transaction_id = $payment_intent->id; 
        $paid_amount = $payment_intent->amount; 
        $paid_amount = ($paid_amount/100); 
        $paid_currency = $payment_intent->currency; 
        $payment_status = $payment_intent->status; 
         
        $customer_name = $customer_email = ''; 
        if(!empty($customer)){ 
            $customer_name = !empty($customer->name)?$customer->name:''; 
            $customer_email = !empty($customer->email)?$customer->email:''; 
        } 
         
        // Check if any transaction data exists already with the same TXN ID 
        $sqlQ = "SELECT id FROM transactions WHERE txn_id = ?"; 
        $stmt = $db->prepare($sqlQ);  
        $stmt->bind_param("s", $transaction_id); 
        $stmt->execute(); 
        $stmt->bind_result($row_id); 
        $stmt->fetch(); 
         
        $payment_id = 0; 
        if(!empty($row_id)){ 
            $payment_id = $row_id; 
        }else{ 
            // Insert transaction data into the database 
            $sqlQ = "INSERT INTO transactions (customer_name,customer_email,item_name,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES (?,?,?,?,?,?,?,?,?,NOW(),NOW())"; 
            $stmt = $db->prepare($sqlQ); 
            $stmt->bind_param("sssdsdsss", $customer_name, $customer_email, $className, $itemPrice, $currency, $paid_amount, $paid_currency, $transaction_id, $payment_status); 
            $insert = $stmt->execute(); 
             
            if($insert){ 
                $payment_id = $stmt->insert_id; 
            } 
        } 
         
        $output = [ 
            'payment_txn_id' => base64_encode($transaction_id) 
        ]; 
        echo json_encode($output); 
    }else{ 
        http_response_code(500); 
        echo json_encode(['error' => 'Transaction has been failed!']); 
    } 
} 
 
?>