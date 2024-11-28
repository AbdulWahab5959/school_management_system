// Get API Key
let STRIPE_PUBLISHABLE_KEY = document.currentScript.getAttribute('STRIPE_PUBLISHABLE_KEY');

// Create an instance of the Stripe object and set your publishable API key
const stripe = Stripe(STRIPE_PUBLISHABLE_KEY);

let elements; // Define card elements
const paymentFrm = document.querySelector("#paymentFrm"); // Select payment form element

// Get payment_intent_client_secret param from URL
const clientSecretParam = new URLSearchParams(window.location.search).get(
    "payment_intent_client_secret"
);

// Check whether the payment_intent_client_secret is already exist in the URL
setProcessing(true);
if(!clientSecretParam){
    setProcessing(false);
    
    // Create an instance of the Elements UI library and attach the client secret
    initialize();
}

// Check the PaymentIntent creation status
checkStatus();

// Attach an event handler to payment form
paymentFrm.addEventListener("submit", handleSubmit);

// Fetch a payment intent and capture the client secret
let payment_intent_id;
let clientSecret;

async function initialize() {
    // Gather form data
    const form = document.getElementById("paymentFrm");
    const formData = new FormData(form);

    // Extract relevant fields from the form
    var id = formData.get("student_id");
    const name = formData.get("name");
    const email = formData.get("email");
    const className = formData.get("class_name");
    const classFee = parseFloat(formData.get("class_fee"));
    console.log(id);
    // Validate data
    if (!id || !name || !email || !className || isNaN(classFee) || classFee <= 0) {
        alert("Please fill out all required fields with valid information.");
        return;
    }

    // Create payment intent with Stripe
    try {
        const response = await fetch("payment_init.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                request_type: 'create_payment_intent',
                id: id,
                name: name,
                email: email,
                item_name: className,
                item_price: classFee,
                currency: 'pkr' 
            }),
        });

        const data = await response.json();
        payment_intent_id = data.id;
        clientSecret = data.clientSecret;

        // Set up Stripe elements
        const appearance = {
            theme: 'stripe',
            rules: {
                '.Label': {
                    fontWeight: 'bold',
                    textTransform: 'uppercase',
                }
            }
        };
        elements = stripe.elements({ clientSecret, appearance });

        const paymentElement = elements.create("payment");
        paymentElement.mount("#paymentElement");
    } catch (error) {
        console.error("Error initializing payment:", error);
        alert("Failed to initialize payment. Please try again.");
    }
}

// Card form submit handler
async function handleSubmit(e) {
    e.preventDefault();
    setLoading(true);

    let customer_name = document.getElementById("name").value;
    let customer_email = document.getElementById("email").value;

    try {
        const response = await fetch("payment_init.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                request_type: 'create_customer',
                payment_intent_id: payment_intent_id,
                name: customer_name,
                email: customer_email
            }),
        });

        const { id, customer_id } = await response.json();

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                // Make sure to change this to your payment completion page
                return_url: window.location.href + '?customer_id=' + customer_id,
            },
        });

        if (error.type === "card_error" || error.type === "validation_error") {
            showMessage(error.message);
        } else {
            showMessage("An unexpected error occurred.");
        }

    } catch (error) {
        console.error("Error processing payment:", error);
        showMessage("Failed to process payment. Please try again.");
    }

    setLoading(false);
}



// Fetch the PaymentIntent status after payment submission
async function checkStatus() {
    const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
    );
    
    const customerID = new URLSearchParams(window.location.search).get(
        "customer_id"
    );
    
    if (!clientSecret) {
        return;
    }
    
    const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);
    
    if (paymentIntent) {
        switch (paymentIntent.status) { 
            case "succeeded":
                //showMessage("Payment succeeded!");
                
                // Post the transaction info to the server-side script and redirect to the payment status page
                fetch("payment_init.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ request_type:'payment_insert', payment_intent: paymentIntent, customer_id: customerID }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.payment_txn_id) {
                        window.location.href = 'payment-status.php?pid='+data.payment_txn_id;
                    } else {
                        showMessage(data.error);
                        setReinit();
                    }
                })
                .catch(console.error);
                
                break;
            case "processing":
                showMessage("Your payment is processing.");
                setReinit();
                break;
            case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                setReinit();
                break;
            default:
                showMessage("Something went wrong.");
                setReinit();
                break;
        }
    } else {
        showMessage("Something went wrong.");
        setReinit();
    }
}


// Display message
function showMessage(messageText) {
    const messageContainer = document.querySelector("#paymentResponse");
    
    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;
    
    setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageContainer.textContent = "";
    }, 5000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submitBtn").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#buttonText").classList.add("hidden");
    } else {
        // Enable the button and hide spinner
        document.querySelector("#submitBtn").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#buttonText").classList.remove("hidden");
    }
}

// Show a spinner on payment form processing
function setProcessing(isProcessing) {
    if (isProcessing) {
        paymentFrm.classList.add("hidden");
        document.querySelector("#frmProcess").classList.remove("hidden");
    } else {
        paymentFrm.classList.remove("hidden");
        document.querySelector("#frmProcess").classList.add("hidden");
    }
}

// Show payment re-initiate button
function setReinit() {
    document.querySelector("#frmProcess").classList.add("hidden");
    document.querySelector("#payReinit").classList.remove("hidden");
}