<?php
#login script
include '../config/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //prevent sql injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    //check if username exists
    $check_username = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $check_username->store_result();

    //if username exists
    if ($check_username->num_rows > 0) {
        //unhash password and verify
        if(password_verify($password, $row['password'])) {
            echo "Password is correct.";

            //retrieve user data
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //set cookies user id and role
                setcookie('uid', $row['id'], time() + (1800), "/"); // 1800 seconds = 30 minutes
                setcookie('role', $row['role'], time() + (1800), "/"); // 1800 seconds = 30 minutes
                $check_username->close();
                $conn->close();
                header('Location: /');
            } else {
                echo "Invalid username or password.";
                $check_username->close();
                $conn->close();
                header('Location: /pages/login.html#error');
            }
        } else {
            echo "Password is incorrect.";
        }
    } else {
        echo "Username doesnt exist.";
    }
    $check_username->close();
    $conn->close();
    header('Location: /pages/login.html#error');
}