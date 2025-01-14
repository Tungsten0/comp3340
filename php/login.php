<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']); // Check if remember me is checked

    // Prevent SQL injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Check if username exists
    $check_username = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $check_username->store_result();

    // If username exists
    if ($check_username->num_rows > 0) {
        // Retrieve user data
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        // Decrypt password and verify
        if (password_verify($password, $row['password'])) {
            $cookie_expiration = $remember ? time() + (86400 * 30) : time() + (1800); // 30 days or 30 minutes

            // Set cookies: user id, name, and role
            if (setcookie('uid', $row['user_id'], $cookie_expiration, "/") &&
                setcookie('username', $row['username'], $cookie_expiration, "/") &&
                setcookie('name', $row['first_name'], $cookie_expiration, "/") &&
                setcookie('role', $row['role'], $cookie_expiration, "/")) {

                $check_username->close();
                $conn->close();
                header('Location: /');
            } else {
                echo '<script>console.log("Cookies could not be set.");</script>';
                $check_username->close();
                $conn->close();
                header('Location: ../login.html#cookie_error');
            }
        } else {
            echo '<script>console.log("Password is incorrect.");</script>';
            $check_username->close();
            $conn->close();
            header('Location: ../login.html#pass_error');
        }
    } else {
        echo '<script>console.log("Username does not exist.");</script>';
        $check_username->close();
        $conn->close();
        header('Location: ../login.html#uname_error');
    }
    $check_username->close();
    $conn->close();
} else {
    header("Location: ../index.php");
}
?>
