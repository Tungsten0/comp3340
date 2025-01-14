<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../config/db_connection.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $to = "leeshi@uwindsor.ca";
    $subject = "New Contact Form Submission";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        header('Location: ../login.html#msg_sent');
    } else {
        header('Location: ../login.html#msg_error');
    }
}
?>