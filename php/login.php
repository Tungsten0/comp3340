<?php
#login script
include '../config/db_connection.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //prevent sql injection
    $email = stripcslashes($email);
    $password = stripcslashes($password);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        setcookie('user_id', $row['id'], time() + (86400 * 30), "/");
        header('Location: /');
    } else {
        echo "Invalid email or password.";
        header('Location: /pages/login.html#error');
    }
}