<!--connect file-->
<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');
?>

<h3 class="text-center" style="color: var(--primary-color);">All User Inquiries</h3>
<table class="table table-bordered mt-5">
    <thead style="background-color: var(--primary-color);">
        <?php
        // Query to fetch data from the contact_messages table
        $get_inquiries = "SELECT * FROM contact_messages";
        $result_inquiries = mysqli_query($con, $get_inquiries);
        $row_count = mysqli_num_rows($result_inquiries);

        echo "<tr>
            <th></th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
        </tr>
        </thead>
        <tbody class='bg-dark text-light'>";
        
        // Check if there are no rows
        if ($row_count == 0) {
            echo "<h2 class='bg-danger text-center mt-5'>No Inquiries Yet</h2>";
        } else {
            $number = 0;
            // Fetch and display data
            while ($row_data = mysqli_fetch_assoc($result_inquiries)) {
                $id = $row_data['id'];
                $name = $row_data['name'];
                $email = $row_data['email'];
                $subject = $row_data['subject'];
                $message = $row_data['message'];
                $number++;
                echo "
                <tr>
                    <td>$number</td>
                    <td>$name</td>
                    <td>$email</td>
                    <td>$subject</td>
                    <td>$message</td>
                </tr>";
            }
        }
        ?>
    </tbody>
</table>
