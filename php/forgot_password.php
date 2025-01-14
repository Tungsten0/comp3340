<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';
    $email = $_POST['email'];

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Insert the reset request into the database
        $stmt = $conn->prepare('INSERT INTO password_reset_requests (email, request_time) VALUES (?, NOW())');
        if ($stmt->execute([$email])) {
            header('Location: ../login.html#submitted');
        } else {
            header('Location: ../login.html#reset_error');
        }
    } else {
        header('Location: ../login.html#rerror');
    }
}
?>
