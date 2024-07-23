<?
#register php script
#temporarily display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    //prevent sql injection
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $email = stripcslashes($email);
    $password = stripcslashes($password);
    $fname = stripcslashes($fname);
    $lname = stripcslashes($lname);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $fname = mysqli_real_escape_string($conn, $fname);
    $lname = mysqli_real_escape_string($conn, $lname);

    //check if username already exists
    $check_username = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $check_username->store_result();

    //if username already exists
    if ($check_username->num_rows > 0) {
        ?> <script>console.log("Username already exists.");</script> <?php
        header('Location: /pages/login.html#user_exists');
    } else {
        $stmt = $conn->prepare("INSERT INTO registration (username, password, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)");

        if ($stmt) {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssss", $username, $password_hashed, $email, $fname, $lname);

            if ($stmt->execute()) {
                ?> <script>console.log("User added successfully.");</script> <?php
                header('Location: /pages/login.html#user_added');
            } else {
                ?> <script>console.log("User add failed: " . $stmt->error);</script> <?php
                header('Location: /pages/register.html#add_error');
            }
            $stmt->close();
        } else {
            ?> <script>console.log("Preparation failed: " . $conn->error);</script> <?php
            header('Location: /pages/register.html#prep_error');
        }
    }
}