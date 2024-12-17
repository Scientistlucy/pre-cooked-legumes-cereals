<!-- Connect file -->
<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');
?>

<h3 class="text-center" style="color: var(--primary-color);">All Payments</h3>
<table class="table table-bordered mt-5">
<thead style="background-color: var(--primary-color);">
    <?php
    // Modified query to select mode_of_payment
    $get_payment = "SELECT 
                        p.payment_id, 
                        p.amount, 
                        p.phone_number, 
                        p.date, 
                        p.mode_of_payment,  -- Fetch mode of payment
                        u.user_id, 
                        u.username
                    FROM 
                        payment p
                    JOIN 
                        user_table u ON p.user_id = u.user_id";
    $result_payments = mysqli_query($con, $get_payment);
    $row_count = mysqli_num_rows($result_payments);

    echo "<tr>
            <th></th>
            <th>Amount</th>
            <th>Phone Number</th>
            <th>User ID</th>
            <th>Username</th>
            <th>Mode of Payment</th> <!-- New column for mode of payment -->
            <th>Payment Date</th>
          </tr>
    </thead>
    <tbody class='bg-dark text-light'>";
    
    if ($row_count == 0) {
        echo "<h2 class='bg-danger text-center mt-5'>No payments received yet</h2>";
    } else {
        $number = 0;
        while ($row_data = mysqli_fetch_assoc($result_payments)) {
            $payment_id = $row_data['payment_id'];
            $amount = $row_data['amount'];
            $phone_number = $row_data['phone_number'];
            $date = $row_data['date'];
            $user_id = $row_data['user_id'];
            $username = $row_data['username'];
            $mode_of_payment = $row_data['mode_of_payment']; // Fetch mode_of_payment
            $number++;
            
            echo "
            <tr>
                <td>$number</td>
                <td>Ksh $amount</td>
                <td>$phone_number</td>
                <td>$user_id</td>
                <td>$username</td>
                <td>$mode_of_payment</td> <!-- Display mode of payment -->
                <td>$date</td>
            </tr>";
        }
    }
    ?>
</tbody>
</table>
