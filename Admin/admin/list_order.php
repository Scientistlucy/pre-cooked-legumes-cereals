

<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');
// At the top of your file, after database connection
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
?>
<style>
    .form-control {
        width: auto; /* Adjust width to fit content */
        min-width: 100px; /* Ensure dropdown is not too narrow */
        text-align: center; /* Center-align text for better appearance */
    }
</style>

<h3 class="text-center" style="color: var(--primary-color);">All Orders</h3>
<div style=" overflow-X: scroll;">
<table class="table table-bordered mt-5">
    <thead style="background-color: var(--primary-color);">
        <tr>
            <th> </th>
            <th>Amount</th>
           
            <th>Product Title</th>
            <th>Total Product</th>
            <th>Order Date</th>
            <th> Username</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>Location</th>
            <th>Postal Code</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="bg-dark text-light">
        <?php
        $get_orders = "
            SELECT u.*, d.fullname, d.email, d.number, d.address, d.location, d.postal_code ,u.status
            FROM user_orders u
            JOIN delivery_form d ON u.user_id = d.user_id
            
        ";
        $result = mysqli_query($con, $get_orders);
        $row_count = mysqli_num_rows($result);

        if ($row_count == 0) {
            echo "<h2 class='bg-danger text-center mt-5'>No Orders Yet</h2>";
        } else {
            $number = 0;
            while ($row_data = mysqli_fetch_assoc($result)) {
                $order_id = $row_data['order_id'];
                $user_id = $row_data['user_id'];
                $amount_due = $row_data['amount'];
              
                $total_product = $row_data['quantity'];
                $product_title = $row_data['product_title'];
                $order_date = $row_data['order_date'];
                $fullname = $row_data['fullname'];
                $email = $row_data['email'];
                $phone_number = $row_data['number'];
                $address = $row_data['address'];
                $location = $row_data['location'];
                $postal_code = $row_data['postal_code'];
                $status = $row_data['status'];
                $number++;

                echo "
                <tr>
                    <td>$number</td>
                    <td> Ksh $amount_due</td>
                   
                    <td>$product_title</td>
                    <td>$total_product</td>
                    <td>$order_date</td>
                    <td>$fullname</td>
                    <td>$email</td>
                    <td>$phone_number</td>
                    <td>$address</td>
                    <td>$location</td>
                    <td>$postal_code</td>
                   <td>
                        <form method='POST' class='d-flex justify-content-between'>
                            <select name='status_$order_id' class='form-control'>
                                <option value='Pending' " . ($status == 'Pending' ? 'selected' : '') . ">Pending</option>
                                <option value='Delivered' " . ($status == 'Delivered' ? 'selected' : '') . ">Delivered</option>
                            </select>
                            <input type='hidden' name='order_id' value='$order_id'>
                    </td>
                    <td>
                            <button type='submit' name='update_status' class='btn btn-primary btn-sm'>Update</button>
                        </form>
                    </td>
                </tr>";
            }
        }
        ?>
    </tbody>
</table>
    </div>
 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".status-dropdown").change(function () {
            var orderId = $(this).data("order-id");
            var newStatus = $(this).val();
            
            $.ajax({
                url: "update_status.php", // Point to a separate PHP file for handling updates
                method: "POST",
                data: {
                    order_id: orderId,
                    new_status: newStatus
                },
                success: function (response) {
                    alert(response.message);
                },
                error: function () {
                    alert("Failed to update status.");
                }
            });
        });
    });
</script>
