<?php

#add user form from admin dashboard

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //include '../config/db_connection.php';

    $servername = "auth-db1539.hstgr.io";
    $username = "u144000044_admin";
    $password = "dZ4XmOZ2a";
    $dbname = "u144000044_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
    }

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $permission = $_POST['permissions'];

    //prevent sql injection
    $fname = stripcslashes($fname);
    $lname = stripcslashes($lname);
    $username = stripcslashes($username);
    $email = stripcslashes($email);
    $password = stripcslashes($password);
    $fname = mysqli_real_escape_string($conn, $fname);
    $lname = mysqli_real_escape_string($conn, $lname);
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    //hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Prevent SQL injection using prepared statements
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, fist_name, last_name, role) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        // Hash password
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters
        $stmt->bind_param("ssssss", $username, $password_hashed, $email, $fname, $lname, $permission);

        // Execute statement
        if ($stmt->execute()) {
            echo "User added successfully.";
            // header('Location: /pages/Add_User.html');
        } else {
            echo "User add failed: " . $stmt->error;
            // header('Location: /pages/Add_User.html#error');
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Preparation failed: " . $conn->error;
    }

    // Close connection
    $conn->close();
}