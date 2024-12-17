<?php
ob_start();
include('D:\Restaurantly\Restaurantly\includes\connect.php');

// Handle status updates
if (isset($_POST['update_status']) && isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $status_field = 'status_' . $order_id;
    
    if (isset($_POST[$status_field])) {
        $new_status = mysqli_real_escape_string($con, $_POST[$status_field]);
        $update_query = "UPDATE user_orders SET status = '$new_status' WHERE order_id = '$order_id'";
        $result = mysqli_query($con, $update_query);
        
        if ($result) {
            echo "<script>alert('Order status updated successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update status: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Handle CSV Export
if (isset($_POST['export_csv'])) {

    // Clean the output buffer
ob_clean();

    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="orders_report.csv"');
    
    $output = fopen('php://output', 'w');
    
    // Add CSV headers
    fputcsv($output, array('Number', 'Amount', 'Product Title', 'Total Product', 'Order Date', 
                          'Full Name', 'Email', 'Phone Number', 'Address', 'Location', 
                          'Postal Code', 'Status'));
    
    $get_orders = "SELECT u.*, d.fullname, d.email, d.number, d.address, d.location, d.postal_code, u.status
                   FROM user_orders u
                   JOIN delivery_form d ON u.user_id = d.user_id";
    $result = mysqli_query($con, $get_orders);
    $number = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
        $number++;
        fputcsv($output, array(
            $number,
            $row['amount'],
            $row['product_title'],
            $row['quantity'],
            $row['order_date'],
            $row['fullname'],
            $row['email'],
            $row['number'],
            $row['address'],
            $row['location'],
            $row['postal_code'],
            $row['status']
        ));
    }
    fclose($output);
    exit();
}
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    
    <style>
        .form-control {
            width: auto;
            min-width: 100px;
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        
        .bg-dark {
            background-color: #212529;
        }
        .text-light {
            color: #fff;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Export and Print Buttons -->
    <style>
.action-buttons {
    display: flex;
    gap: 15px;
    padding: 20px;
    justify-content:center;
    background-color: #f8f9fa;
    border-radius: 8px;
    margin: 20px 0;
}

.export-btn, .print-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.export-btn {
    background-color: #28a745;
    color: white;
}

.export-btn:hover {
    background-color: #218838;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.print-btn {
    background-color: #ffa500;
    color: white;
}

.print-btn:hover {
    background-color: #ff8c00;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-icon {
    width: 16px;
    height: 16px;
    fill: currentColor;
}

@media print {
    .action-buttons {
        display: none;
    }
     /* Landscape orientation for better fit */
     @page {
            size: landscape;
        }

        @media print {
            .no-print {
                display: none;
            }
            @page {
                size: landscape;
                margin: 1cm;
            }
            .table th, .table td {
                font-size: 12px;
                padding: 5px;
            }
        }
}
</style>

<div class="action-buttons">
    <form method="POST" style="display: inline;">
        <button type="submit" name="export_csv" class="export-btn">
            <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 16l-4-4h3V4h2v8h3l-4 4zm9-13h-6v2h4.586L12 12.586 13.414 14 21 6.414V11h2V3h-2z" fill="currentColor"/>
            </svg>
            Export to CSV
        </button>
    </form>
    <button onclick="window.print()" class="print-btn">
        <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M19 8h-1V3H6v5H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zM8 5h8v3H8V5zm8 14H8v-4h8v4zm2-4v-2H6v2H4v-4c0-.55.45-1 1-1h14c.55 0 1 .45 1 1v4h-2z" fill="currentColor"/>
        </svg>
        Print Report
    </button>
</div>
<div style="display: flex; justify-content: center;">
  <h3 style="color: var(--primary-color);">All Orders</h3>
</div>

    <div style="overflow-X: scroll;">
        <table class="table table-bordered mt-5">
            <thead style="background-color: var(--primary-color);">
                <tr>
                    <th></th>
                    <th>Amount</th>
                    <th>Product Title</th>
                    <th>Total Product</th>
                    <th>Order Date</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Location</th>
                    <th>Postal Code</th>
                    <th>Status</th>
                   
                </tr>
            </thead>
            <tbody class="bg-dark text-light">
                <?php
                $get_orders = "SELECT u.*, d.fullname, d.email, d.number, d.address, d.location, d.postal_code, u.status
                              FROM user_orders u
                              JOIN delivery_form d ON u.user_id = d.user_id";
                $result = mysqli_query($con, $get_orders);
                $row_count = mysqli_num_rows($result);

                if ($row_count == 0) {
                    echo "<tr><td colspan='13'><h2 class='bg-danger text-center mt-5'>No Orders Yet</h2></td></tr>";
                } else {
                    $number = 0;
                    while ($row_data = mysqli_fetch_assoc($result)) {
                        $order_id = $row_data['order_id'];
                        $number++;
                        ?>
                        <tr>
                            <td><?php echo $number; ?></td>
                            <td><?php echo $row_data['amount']; ?></td>
                            <td><?php echo $row_data['product_title']; ?></td>
                            <td><?php echo $row_data['quantity']; ?></td>
                            <td><?php echo $row_data['order_date']; ?></td>
                            <td><?php echo $row_data['fullname']; ?></td>
                            <td><?php echo $row_data['email']; ?></td>
                            <td><?php echo $row_data['number']; ?></td>
                            <td><?php echo $row_data['address']; ?></td>
                            <td><?php echo $row_data['location']; ?></td>
                            <td><?php echo $row_data['postal_code']; ?></td>
                            <td><?php echo $row_data['status']; ?></td>
                            
                            
                           
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>