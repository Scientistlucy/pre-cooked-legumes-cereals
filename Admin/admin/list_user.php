<!--connect file-->
<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');
?>

<h3 class="text-center" style="color: var(--primary-color);">All Users</h3>
<table class="table table-bordered mt-5">
    <thead style="background-color: var(--primary-color);">
        <?php
        $get_payment = "SELECT * FROM user_table";
        $result_payments = mysqli_query($con, $get_payment);
        $row_count = mysqli_num_rows($result_payments);

        echo "<tr>
            <th></th>
            <th>Username</th>
            <th>User Email</th>
            <th>User Address</th>
            <th>User Mobile</th>
        </tr>
        </thead>
        <tbody class='bg-dark text-light'>";
        
        if ($row_count == 0) {
            echo "<h2 class='bg-danger text-center mt-5'>No Users Yet</h2>";
        } else {
            $number = 0;
            while ($row_data = mysqli_fetch_assoc($result_payments)) {
                $user_id = $row_data['user_id'];
                $username = $row_data['username'];
                $user_email = $row_data['user_email'];
                $user_address = $row_data['user_address'];
                $user_mobile = $row_data['user_mobile'];
                $number++;
                echo "
                <tr>
                    <td>$number</td>
                    <td>$username</td>
                    <td>$user_email</td>
                    <td>$user_address</td>
                    <td>$user_mobile</td>
                </tr>";
            }
        }
        ?>
    </tbody>
</table>
