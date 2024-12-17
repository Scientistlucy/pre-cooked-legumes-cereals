<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get IP address
    function getIPAddress() {
        // Your existing getIPAddress function code here
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    $ip_address = getIPAddress();
    
    // Get POST data
    $product_id = isset($_POST['qty']) ? key($_POST['qty']) : null;
    $quantity = isset($_POST['qty'][$product_id]) ? (int)$_POST['qty'][$product_id] : null;

    if ($product_id && $quantity) {
        // Get product price
        $select_price = "SELECT product_price FROM products WHERE product_id = ?";
        $stmt = mysqli_prepare($con, $select_price);
        mysqli_stmt_bind_param($stmt, 'i', $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Calculate total price
            $base_price = floatval(str_replace('kshs ', '', $row['product_price']));
            $total_price = $base_price * $quantity;

            // Update cart
            $update_cart = "UPDATE cart_details SET quantity = ?, total_price = ? 
                          WHERE product_id = ? AND ip_address = ?";
            $update_stmt = mysqli_prepare($con, $update_cart);
            mysqli_stmt_bind_param($update_stmt, 'idis', $quantity, $total_price, $product_id, $ip_address);
            
            if (mysqli_stmt_execute($update_stmt)) {
                echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
            }
            mysqli_stmt_close($update_stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data received']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>