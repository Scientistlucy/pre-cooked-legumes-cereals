<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');

// Fetch all users
$query = "SELECT user_id, user_password FROM user_table";
$result = mysqli_query($con, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['user_id'];
        $current_password = $row['user_password'];

        // Check if the password is hashed (e.g., bcrypt starts with $2y$ or $2b$)
        if (strpos($current_password, '$2y$') !== 0 && strpos($current_password, '$2b$') !== 0) {
            // Password is not hashed, so hash it
            $hashed_password = password_hash($current_password, PASSWORD_DEFAULT);

            // Update the hashed password in the database
            $update_query = "UPDATE user_table SET user_password = ? WHERE user_id = ?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "si", $hashed_password, $user_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "Password for user ID $user_id has been hashed successfully.<br>";
            } else {
                echo "Error updating password for user ID $user_id: " . mysqli_error($con) . "<br>";
            }
        } else {
            echo "Password for user ID $user_id is already hashed.<br>";
        }
    }
} else {
    echo "Error fetching users: " . mysqli_error($con);
}
?>
