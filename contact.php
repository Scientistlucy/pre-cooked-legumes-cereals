<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


// Include database connection
include('D:\Restaurantly\Restaurantly\includes\connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize form data
    $name = $con->real_escape_string($_POST['name']);
    $email = $con->real_escape_string($_POST['email']);
    $subject = $con->real_escape_string($_POST['subject']);
    $message = $con->real_escape_string($_POST['message']);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Execute the statement
    if ($stmt->execute()) {
        // Show success message and redirect to contact.php
        echo "<script type='text/javascript'>
                alert('Your message has been sent. Thank you!');
                window.location.href = 'contact.php';
              </script>";
    } else {
        // Show error message
        echo "<script type='text/javascript'>
                alert('Error: " . $stmt->error . "');
                window.location.href = 'contact.php';
              </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
}
?>

 