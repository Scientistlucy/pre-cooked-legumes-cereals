
<?php
session_start();

include('D:\Restaurantly\Restaurantly\includes\connect.php');

// Get the posted amount and phone number
$amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
$phone_number = isset($_POST['phone']) ? $_POST['phone'] : '';

// Check if the user is logged in and has a valid user_id
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];  // Retrieve the user ID from the session
    
    // Insert the payment record including user_id
    $insert_payment = "INSERT INTO payment (user_id, amount, phone_number, date) 
                       VALUES ('$user_id', '$amount', '$phone_number', NOW())";
    $result_query = mysqli_query($con, $insert_payment);
    
    if ($result_query) {
       
    } else {
        echo "Failed to insert payment: " . mysqli_error($con);
    }
} else {
    echo "Error: User not logged in.";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Pesa Payment</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --mpesa-green: #1b8d49;
            --mpesa-dark-green: #146c38;
            --mpesa-light-green: #e7f4eb;
            --gray-light: #f8f9fa;
            --border-color: #e0e0e0;
        }

        body {
            background-color: #f4f4f4;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f4f4f4 0%, #ffffff 100%);
        }

        .container {
            max-width: 600px;
            width: 100%;
            margin: 20px;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .mpesa-logo {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: var(--mpesa-light-green);
            border-radius: 12px;
        }

        .logo-text {
            color: var(--mpesa-green);
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 0;
        }

        .payment-info {
            background: var(--gray-light);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 4px solid var(--mpesa-green);
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .payment-info p {
            margin: 8px 0;
            color: #555;
            font-size: 15px;
        }

        .amount {
            font-size: 32px;
            font-weight: 700;
            color: var(--mpesa-green);
            margin: 15px 0;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #444;
            font-weight: 600;
            font-size: 15px;
        }

        input[type="tel"],
        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 15px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: var(--gray-light);
        }

        input:focus {
            outline: none;
            border-color: var(--mpesa-green);
            box-shadow: 0 0 0 3px rgba(27, 141, 73, 0.1);
            background: white;
        }

        .input-hint {
            color: #666;
            font-size: 13px;
            margin-top: 8px;
        }

        button {
            background: var(--mpesa-green);
            color: white;
            border: none;
            padding: 18px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(27, 141, 73, 0.2);
        }

        button:hover {
            background: var(--mpesa-dark-green);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(27, 141, 73, 0.25);
        }

        button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 8px;
            padding: 10px;
            background: #fff5f5;
            border-radius: 6px;
            border-left: 3px solid #dc3545;
        }

        .success {
            color: var(--mpesa-green);
            background: var(--mpesa-light-green);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        .steps {
            margin-top: 30px;
            padding: 25px;
            background: var(--gray-light);
            border-radius: 12px;
        }

        .steps h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }

        .steps ol {
            margin-left: 25px;
            color: #555;
        }

        .steps li {
            margin-bottom: 12px;
            line-height: 1.5;
            font-size: 15px;
        }

        .processing {
            display: none;
            text-align: center;
            padding: 30px;
        }

        .processing.active {
            display: block;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--mpesa-green);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .secure-badge svg {
            width: 20px;
            height: 20px;
            fill: var(--mpesa-green);
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
                margin: 10px;
            }

            .amount {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="mpesa-logo">
            <h2 class="logo-text">M-PESA PAYMENT</h2>
            <p style="color: #666; margin-top: 5px;">Fast, Secure, and Convenient</p>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $errors = [];
            
            if (empty($_POST["phone"])) {
                $errors[] = "Phone number is required";
            } elseif (!preg_match("/^(?:254|\+254|0)?([71](?:(?:0[0-8])|(?:[12][0-9])|(?:9[0-9])|(?:4[0-36])|(?:5[0-7])|(?:6[0-7])|(?:8[0-2]))([0-9]{6}))$/", $_POST["phone"])) {
                $errors[] = "Please enter a valid Safaricom phone number";
            }
            
            if (empty($_POST["amount"])) {
                $errors[] = "Amount is required";
            } elseif (!is_numeric($_POST["amount"]) || $_POST["amount"] <= 0) {
                $errors[] = "Please enter a valid amount";
            }

            if (empty($errors)) {
                // Display success message
                echo "<div class='success'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' style='vertical-align: middle; margin-right: 8px;'>
                        <path fill='currentColor' d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z'/>
                    </svg>
                    STK Push sent successfully! Please check your phone.</div>";
                
                // Add JavaScript redirect after 3 seconds
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'profile.php';
                    }, 3000);
                </script>";
            } else {
                echo "<div class='error'>" . implode("<br>", $errors) . "</div>";
            }
        }
        ?>

        <div class="payment-info">
            <p>Order Number: <strong>#<?php echo rand(1000, 9999); ?></strong></p>
            <p class="amount">KES <span id="displayAmount">0.00</span></p>
            <p>Payment Method: M-Pesa</p>
        </div>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="mpesaForm">
            <div class="form-group">
                <label for="phone">M-Pesa Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="254712345678" 
                    value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" 
                    required>
                <p class="input-hint">Enter your M-Pesa registered phone number starting with 254</p>
            </div>

            <div class="form-group">
                <label for="amount">Amount (KES)</label>
                <input type="number" id="amount" name="amount" min="1" step="1" 
                value="<?php echo isset($_SESSION['subtotal']) ? number_format($_SESSION['subtotal'], 2) : '0.00'; ?>" required>
                
                   
            </div>

            <button type="submit" id="payButton">Pay Now with M-Pesa</button>

            <div class="secure-badge">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>
                </svg>
                Secure Payment
            </div>
        </form>

        <div class="processing" id="processingPayment">
            <div class="spinner"></div>
            <p style="font-size: 18px; font-weight: 600; color: #333;">Processing your payment...</p>
            <p style="color: #666; margin-top: 10px;">Please check your phone for the M-Pesa prompt</p>
        </div>

        <div class="steps">
            <h3>How to Complete Your Payment</h3>
            <ol>
                <li>Enter your M-Pesa registered phone number in the format shown</li>
                <li>Click the "Pay Now" button to initiate payment</li>
                <li>Wait for the M-Pesa prompt on your phone</li>
                <li>Enter your M-Pesa PIN when prompted</li>
                <li>You will receive a confirmation message once the payment is complete</li>
            </ol>
        </div>
    </div>

    <script>
        document.getElementById('amount').addEventListener('input', function(e) {
            document.getElementById('displayAmount').textContent = parseFloat(e.target.value || 0).toLocaleString('en-KE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        });

        document.getElementById('mpesaForm').addEventListener('submit', function(e) {
            document.getElementById('payButton').disabled = true;
            document.getElementById('processingPayment').classList.add('active');
        });
    </script>
    
    <script>
    // Function to set the payment amount from the cart's subtotal
    function setPaymentAmount() {
        // Check if the parent page and subtotal element exist
        if (window.opener && window.opener.document) {
            const subtotalElement = window.opener.document.getElementById('subtotal');
            
            if (subtotalElement) {
                // Get the subtotal value and update the fields
                const subtotal = subtotalElement.textContent.trim();
                
                if (subtotal) {
                    const amountInput = document.getElementById('amount');
                    const displayAmountSpan = document.getElementById('displayAmount');
                    
                    // Set the value to the input and display span
                    amountInput.value = subtotal;
                    displayAmountSpan.textContent = parseFloat(subtotal).toLocaleString('en-KE', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            } else {
                console.warn('Subtotal element not found on parent page.');
            }
        } else {
            console.warn('Parent page not accessible.');
        }
    }

    // Call the function when the page loads
    window.onload = setPaymentAmount;
</script>

<script>
    // On page load, check the session subtotal
    window.onload = function() {
        const sessionSubtotal = <?php echo isset($_SESSION['subtotal']) ? $_SESSION['subtotal'] : 0; ?>;
        
        if (sessionSubtotal > 0) {
            const amountInput = document.getElementById('amount');
            const displayAmountSpan = document.getElementById('displayAmount');
            
            amountInput.value = sessionSubtotal;
            displayAmountSpan.textContent = sessionSubtotal.toLocaleString('en-KE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    };
</script>

</body>
</html>