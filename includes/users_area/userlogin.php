<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');
include('D:\Restaurantly\Restaurantly\Admin\functions\common_function.php');
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Restaurantly</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #ff6600;
            --primary-hover: #e65c00;
        }
        
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-container {
            max-width: 600px;
            width: 100%;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(255, 102, 0, 0.3);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container mx-auto">
            <h2 class="text-center text-primary mb-4">Welcome Back</h2>
            
            <form action="" method="post" class="needs-validation" novalidate>
                <!-- Username field -->
                <div class="mb-4">
                    <label for="user_username" class="form-label">Username</label>
                    <input type="text" id="user_username" class="form-control" 
                           placeholder="Enter your username" 
                           name="user_username" required>
                    <div class="invalid-feedback">
                        Please enter your username.
                    </div>
                </div>
                
                <!-- Password field -->
                <div class="mb-4">
                    <label for="user_password" class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="user_password" class="form-control" 
                               placeholder="Enter your password" 
                               name="user_password" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback">
                        Please enter your password.
                    </div>
                </div>
                
                <!-- Login button -->
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary py-2" name="user_login">
                        Login
                    </button>
                </div>
                
                <!-- Register link -->
                <p class="text-center mb-0">
                    Don't have an account? 
                    <a href="userregistration.php" class="text-primary">Register</a>
                </p>
            </form>
        </div>
    </div>
    
    <?php
    if (isset($_POST['user_login'])) {
        // Check if form fields are set
        if (isset($_POST['user_username']) && isset($_POST['user_password'])) {
            // Get the form values
            $user_username = $_POST['user_username'];
            $user_password = $_POST['user_password'];
    
            // Query to check user credentials
            $select_query = "SELECT * FROM user_table WHERE username='$user_username'";
            $result = mysqli_query($con, $select_query);
    
            if ($result && mysqli_num_rows($result) > 0) {
                // Fetch user details
                $user_data = mysqli_fetch_assoc($result);
    
                // Verify password
                if (password_verify($user_password, $user_data['user_password'])) {
                    // Save user information in session
                    $_SESSION['username'] = $user_data['username'];
                    $_SESSION['user_id'] = $user_data['user_id'];
    
                    $user_ip = getIPAddress();
    
                    // Check for cart items
                    $select_query_cart = "SELECT * FROM cart_details WHERE ip_address='$user_ip'";
                    $select_cart = mysqli_query($con, $select_query_cart);
                    $row_count_cart = mysqli_num_rows($select_cart);
    
                    if ($row_count_cart == 0) {
                        echo "<script>alert('Login successful')</script>";
                        echo "<script>window.open('profile.php', '_self')</script>";
                    } else {
                        echo "<script>alert('Login successful')</script>";
                        echo "<script>window.open('order_form.php', '_self')</script>";
                    }
                } else {
                    // Invalid password
                    echo "<script>alert('Invalid Credentials')</script>";
                }
            } else {
                // Invalid username
                echo "<script>alert('Invalid Credentials')</script>";
            }
        }
    }
    ?>
    <script>
        // Enable form validation
        (function () {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();
        
        // Password toggle visibility
        function togglePassword() {
            const passwordInput = document.getElementById('user_password');
            const icon = document.querySelector('.password-toggle i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
