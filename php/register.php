<?
#register php script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    //prevent sql injection
    $email = stripcslashes($email);
    $password = stripcslashes($password);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    $result = $conn->query($sql);

    if ($result) {
        echo "Registration successful.";
        header('Location: /pages/login.html');
    } else {
        echo "Registration failed.";
        header('Location: /pages/register.html#error');
    }
}