<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');
include('D:\Restaurantly\Restaurantly\Admin\functions\common_function.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Restaurantly</title>
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
        
        .registration-container {
            max-width: 700px;
            width: 100%;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin: auto;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-container">
            <h2 class="text-center text-primary mb-4">New User Registration</h2>
            <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <!-- Username -->
                <div class="mb-4">
                    <label for="user_username" class="form-label">Username</label>
                    <input type="text" id="user_username" class="form-control" 
                           placeholder="Enter your username" 
                           name="user_username" required>
                    <div class="invalid-feedback">
                        Please enter your username.
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="user_email" class="form-label">Email</label>
                    <input type="email" id="user_email" class="form-control" 
                           placeholder="Enter your email" 
                           name="user_email" required>
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>

                <!-- User Image -->
                <div class="mb-4">
                    <label for="user_image" class="form-label">User Image</label>
                    <input type="file" id="user_image" class="form-control" name="user_image">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="user_password" class="form-label">Password</label>
                    <input type="password" id="user_password" class="form-control" 
                           placeholder="Enter your password" 
                           name="user_password" required minlength="8">
                    <div class="invalid-feedback">
                        Password must be at least 8 characters long.
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="conf_user_password" class="form-label">Confirm Password</label>
                    <input type="password" id="conf_user_password" class="form-control" 
                           placeholder="Confirm password" 
                           name="conf_user_password" required>
                    <div class="invalid-feedback">
                        Please confirm your password.
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="user_address" class="form-label">Address</label>
                    <input type="text" id="user_address" class="form-control" 
                           placeholder="Enter your address" 
                           name="user_address" required>
                    <div class="invalid-feedback">
                        Please enter your address.
                    </div>
                </div>

                <!-- Contact -->
                <div class="mb-4">
                    <label for="user_contact" class="form-label">Contact</label>
                    <input type="text" id="user_contact" class="form-control" 
                           placeholder="Enter your mobile number" 
                           name="user_contact" required>
                    <div class="invalid-feedback">
                        Please enter a valid contact number.
                    </div>
                </div>

                <!-- Register Button -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2" name="user_register">
                        Register
                    </button>
                </div>
                <p class="text-center mt-3">
                    Already have an account? 
                    <a href="userlogin.php" class="text-primary">Login</a>
                </p>
            </form>
        </div>
    </div>

    <!-- PHP Code -->
    <?php
    if (isset($_POST['user_register'])) {
        $user_username = $_POST['user_username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $conf_user_password = $_POST['conf_user_password'];
        $user_address = $_POST['user_address'];
        $user_contact = $_POST['user_contact'];
        $user_image = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $_FILES['user_image']['name']);
        $user_image_tmp = $_FILES['user_image']['tmp_name'];
        $user_ip = getIPAddress();

        // Select query
        $select_query = "SELECT * FROM user_table WHERE username='$user_username' OR user_email='$user_email'";
        $result = mysqli_query($con, $select_query);
        $rows_count = mysqli_num_rows($result);
        if ($rows_count > 0) {
            echo "<script>alert('Username and Email already exist')</script>";
        } elseif ($user_password != $conf_user_password) {
            echo "<script>alert('Passwords do not match')</script>";
        } else {


             // Hash the password
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
            if (!move_uploaded_file($user_image_tmp, "D:/Restaurantly/Restaurantly/includes/users_area/users_images/$user_image")) {
                echo "<script>alert('Failed to upload image. Check directory path and permissions.')</script>";
            }
           // Insert user into the database
        $insert_query = "INSERT INTO user_table (username, user_email, user_password, user_image, user_ip, user_address, user_mobile) 
        VALUES ('$user_username', '$user_email', '$hashed_password', '$user_image', '$user_ip', '$user_address', '$user_contact')";
            $sql_execute = mysqli_query($con, $insert_query);
            echo "<script>alert('Registration successful!')</script>";
        }

        // Cart items check
        $select_cart_items = "SELECT * FROM cart_details WHERE ip_address='$user_ip'";
        $result_cart = mysqli_query($con, $select_cart_items);
        $rows_count_cart = mysqli_num_rows($result_cart);
        if ($rows_count_cart > 0) {
            $_SESSION['username'] = $user_username;
            echo "<script>alert('You have items in your cart')</script>";
            echo "<script>window.open('userlogin.php','_self')</script>";
        } else {
            echo "<script>window.open('index.php','_self')</script>";
        }
    }
    ?>

    <script>
        // Form validation
        (function () {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
