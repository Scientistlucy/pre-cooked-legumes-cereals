
<!--connect file-->
<?php


// Start the session at the very beginning
session_start();

// Include database connection
include('D:\Restaurantly\Restaurantly\includes\connect.php');

// Debug session information
if (!isset($_SESSION['user_id'])) {
    // Log session status
    error_log('Session user_id not set. Current session data: ' . print_r($_SESSION, true));
    
    echo "<script>window.open('userlogin.php', '_self');</script>";
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
// Use prepared statement to prevent SQL injection
$query = "SELECT username, user_email, user_mobile FROM user_table WHERE user_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $name = $user['username'];
    $email = $user['user_email'];
    $phone = $user['user_mobile']; // Removed extra spaces in the key
} else {
    error_log('No user found with ID: ' . $user_id);
    $name = $email = $phone = ""; // Default empty values
}

// Rest of your HTML and form processing code follows...
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Order Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            outline: none;
            border-color: #ff6600;
            box-shadow: 0 0 5px rgba(255, 102, 0, 0.2);
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .col {
            flex: 1;
        }

        button {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            border-radius: 4px;
        }

        button:hover {
            background-color: #ff8533;
        }

        .error {
            color: #ff6600;
            font-size: 14px;
            margin-top: 5px;
        }

        @media (max-width: 600px) {
            .row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delivery Order Form</h1>
        <?php
        
        
        
       
         // Adjust this line to include your DB connection file

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Initialize error array
            $errors = [];
            
            // Validate name
            if (empty($_POST["name"])) {
                $errors[] = "Name is required";
            }
            
            // Validate email
            if (empty($_POST["email"])) {
                $errors[] = "Email is required";
            } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            }
            
            // Validate phone
            if (empty($_POST["phone"])) {
                $errors[] = "Phone number is required";
            }
            
            // Validate address
            if (empty($_POST["address"])) {
                $errors[] = "Address is required";
            }

            // If no errors, process the form
            if (empty($errors)) {
                // Sanitize inputs
                $fullname = mysqli_real_escape_string($con, $_POST['name']);
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $number = mysqli_real_escape_string($con, $_POST['phone']);
                $address = mysqli_real_escape_string($con, $_POST['address']);
                $location = mysqli_real_escape_string($con, $_POST['city']);
                $postal_code = mysqli_real_escape_string($con, $_POST['postal']);

               // Assuming user_id is set in session after user login
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$insert_delivery = "INSERT INTO delivery_form (fullname, email, number, address, location, postal_code, user_id) 
                    VALUES ('$fullname', '$email', '$number', '$address', '$location', '$postal_code', '$user_id')";

                // Execute the query
                $result_query = mysqli_query($con, $insert_delivery);

                if ($result_query) {
                    echo "<script>alert('Delivery details are submitted successfully')</script>";
                    echo "<script>window.open('mpesa.php', '_self')</script>";
                } else {
                    echo "<script>alert('Error submitting delivery details')</script>";
                }
            } else {
                // Display errors
                echo "<div class='error'>";
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
                echo "</div>";
            }
        }
        ?>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Delivery Address *</label>
                <textarea id="address" name="address" required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="city">Location *</label>
                        <input type="text" id="city" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="postal">Postal Code *</label>
                        <input type="text" id="postal" name="postal" value="<?php echo isset($_POST['postal']) ? htmlspecialchars($_POST['postal']) : ''; ?>" required>
                    </div>
                </div>
            </div>

            <button type="submit">Submit Order</button>
        </form>
    </div>
</body>
</html>
