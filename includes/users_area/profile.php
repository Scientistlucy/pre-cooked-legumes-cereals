<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('D:\Restaurantly\Restaurantly\includes\connect.php');
include('D:\Restaurantly\Restaurantly\Admin\functions\common_function.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo "Error: User is not logged in.";
    exit;
}

$username = $_SESSION['username'];
$get_user = "SELECT * FROM user_table WHERE username='$username'";
$result = mysqli_query($con, $get_user);
$row_fetch = mysqli_fetch_assoc($result);
$user_id = $row_fetch['user_id'];

// Initialize user details from database
$user_email = htmlspecialchars($row_fetch['user_email'] ?? '');
$user_contact = htmlspecialchars($row_fetch['user_mobile'] ?? '');
$user_address = htmlspecialchars($row_fetch['user_address'] ?? '');


// Add the image path logic
$user_image = !empty($row_fetch['user_image']) ? 'users_images/' . $row_fetch['user_image'] : '';


$get_ip_address = getIPAddress();

$invoice_number = mt_rand();
$order_date = date('Y-m-d H:i:s');

// Get cart details
$cart_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_address'";
$result_cart = mysqli_query($con, $cart_query);

if (mysqli_num_rows($result_cart) > 0) {
    while ($cart_item = mysqli_fetch_assoc($result_cart)) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        
        // Fetch product details
        $product_query = "SELECT * FROM products WHERE product_id='$product_id'";
        $result_product = mysqli_query($con, $product_query);
        $product = mysqli_fetch_assoc($result_product);
        $product_title = $product['product_title'];
        $amount = $product['product_price'] * $quantity;
        $product_image1 = $product['product_image1'];

        // Insert into user_orders table
        $insert_order = "INSERT INTO user_orders (order_id, user_id, amount, quantity, product_title, order_date, invoice_number, product_image1)
                         VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_order);
        mysqli_stmt_bind_param($stmt, "iidssss", $user_id, $amount, $quantity, $product_title, $order_date, $invoice_number, $product_image1);
        
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error inserting order: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    }
   
    
    // Clear the cart
    $clear_cart = "DELETE FROM cart_details WHERE ip_address='$get_ip_address'";
    mysqli_query($con, $clear_cart);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $user_contact = mysqli_real_escape_string($con, $_POST['user_contact']);
    $user_address = mysqli_real_escape_string($con, $_POST['user_address']);

    // Update user details in the database
    $update_query = "UPDATE user_table SET user_email='$user_email', user_mobile='$user_contact', user_address='$user_address' WHERE username='$username'";
    
    if (mysqli_query($con, $update_query)) {
        $_SESSION['success_message'] = "Profile updated successfully!";
    } else {
        // Log query and error for debugging
        echo "Query: " . $update_query . "<br>";
        echo "Error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre Cooked</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff6600;
            --primary-hover: #ff8533;
        }
        
        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 4px;
        }
        
        .btn-custom:hover {
            background-color: var(--primary-hover);
            color: white;
        }

        .profile-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .order-card {
            border-left: 4px solid var(--primary-color);
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .nav-pills .nav-link {
            color: var(--primary-color);
            cursor: pointer;
            padding: 10px 20px;
            margin-bottom: 5px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link:hover:not(.active) {
            background-color: rgba(255, 102, 0, 0.1);
        }

        .order-history {
            margin-top: 20px;
        }

        .order-date-group {
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .order-date-header {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            font-size: 1.1em;
            font-weight: bold;
        }

        .order-items {
            padding: 0;
        }

        .order-item {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .order-product {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .product-info {
            flex-grow: 1;
        }

        .order-summary {
            background-color: #f8f9fa;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-actions {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }
        
        /* Add styles for profile image container */
        .profile-image-container {
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 50%;
            margin: 0 auto 20px;
        }

        .profile-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--primary-color);">
        <div class="container">
            <a class="navbar-brand" href="#">Pre Cooked</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row">
            <!-- Replace the navigation pills section in your code with this: -->
<div class="col-md-3">
    <div class="profile-section text-center">
        <div class="profile-image-container">
        <img src="<?php echo htmlspecialchars($user_image); ?>" alt="Profile Picture" class="img-fluid">
        </div>
        <h4><?php echo htmlspecialchars($username); ?></h4>
        <p class="text-muted">Joined on <?php echo date('Y'); ?></p>
    </div>

    <div class="nav nav-pills flex-column" id="profileTabs" role="tablist">
        <button class="nav-link active" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
            Profile
        </button>
        <button class="nav-link" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">
            Order History
        </button>
    </div>
</div>

<!-- And replace the tab content section with this: -->
<div class="col-md-9">
    <div class="tab-content" id="profileTabsContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="profile-section">
                <h3>Edit Profile</h3>
                <form method="POST" action="profile.php">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="user_email" value="<?php echo htmlspecialchars($user_email); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="user_contact" value="<?php echo htmlspecialchars($user_contact); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="user_address" value="<?php echo htmlspecialchars($user_address); ?>" required>
                    </div>
                    <div class="profile-actions">
                        <button type="submit" class="btn-custom">Update Profile</button>
                        <button type="reset" class="btn-custom">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            <div class="order-history">
                <h3>Order History</h3>
                <?php
                // Your existing PHP code for orders here
                $orders_query = "SELECT DATE(order_date) as order_date, 
                               GROUP_CONCAT(order_id) as order_ids,
                               SUM(amount) as total_amount,
                               COUNT(*) as total_items
                               FROM user_orders 
                               WHERE user_id='$user_id' 
                               GROUP BY DATE(order_date) 
                               ORDER BY order_date DESC";
                $result_orders = mysqli_query($con, $orders_query);

                if (mysqli_num_rows($result_orders) > 0) {
                    while ($date_group = mysqli_fetch_assoc($result_orders)) {
                        echo '<div class="order-date-group">';
                        echo '<div class="order-date-header">';
                        echo date('F d, Y', strtotime($date_group['order_date']));
                        echo '</div>';
                        echo '<div class="order-items">';

                        $order_ids = explode(',', $date_group['order_ids']);
                        foreach ($order_ids as $order_id) {
                            $order_query = "SELECT * FROM user_orders WHERE order_id='$order_id'";
                            $result_order = mysqli_query($con, $order_query);
                            $order = mysqli_fetch_assoc($result_order);

                            echo '<div class="order-item">';
                            echo '<div class="order-details">';
                            echo '<div class="order-product">';
                            echo '<img src="/Restaurantly/assets/img/product/' . $order['product_image1'] . '" alt="Product" class="product-image">';

                            echo '<div class="product-info">';
                            echo '<h5>' . $order['product_title'] . '</h5>';
                            echo '<p>Quantity: ' . $order['quantity'] . '</p>';
                            echo '<p>Amount: KSh ' . number_format($order['amount'], 2) . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div>'; // End of order-items
                        echo '<div class="order-total">';
                        echo '<p><strong>Total Amount: KSh ' . number_format($date_group['total_amount'], 2) . '</strong></p>';
                        echo '</div>';
                        echo '</div>'; // End of order-date-group
                    }
                } else {
                    echo '<p>No orders found.</p>';
                }
                ?>

                
            </div>
        </div>
    </div>
</div>

<!-- And replace the JavaScript section with this: -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tabs
    const triggerTabList = document.querySelectorAll('#profileTabs button');
    triggerTabList.forEach(function(triggerEl) {
        const tabTrigger = new bootstrap.Tab(triggerEl);
        
        triggerEl.addEventListener('click', function(event) {
            event.preventDefault();
            tabTrigger.show();
        });
    });

    // Form validation
    const profileForm = document.querySelector('form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(event) {
            const emailInput = document.querySelector('input[name="user_email"]');
            const phoneInput = document.querySelector('input[name="user_contact"]');
            const addressInput = document.querySelector('input[name="user_address"]');

            if (!emailInput.value || !phoneInput.value || !addressInput.value) {
                event.preventDefault();
                alert('Please fill in all required fields.');
            }
        });

        // Reset button handler
        const resetButton = document.querySelector('button[type="reset"]');
        if (resetButton) {
            resetButton.addEventListener('click', function(event) {
                event.preventDefault();
                if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
                    profileForm.reset();
                }
            });
        }
    }
});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // When the form is submitted
    $('#updateProfileForm').on('submit', function(e) {
        e.preventDefault(); // Prevent normal form submission

        // Collect form data
        var formData = $(this).serialize();

        // Send data to update_profile.php using AJAX
        $.ajax({
            type: 'POST',
            url: 'update_profile.php',
            data: formData,
            success: function(response) {
                // If the update is successful, update the profile data on the page
                if (response.success) {
                    // Update the user profile display
                    $('input[name="user_email"]').val(response.user_email);
                    $('input[name="user_contact"]').val(response.user_contact);
                    $('input[name="user_address"]').val(response.user_address);
                    alert('Profile updated successfully!');
                } else {
                    alert('Error updating profile: ' + response.error);
                }
            },
            error: function() {
                alert('An error occurred while updating your profile.');
            }
        });
    });
});
</script>
