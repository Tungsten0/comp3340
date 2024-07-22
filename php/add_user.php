<?

#add user form from admin dashboard
include '../config/db_connection.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
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

    $sql = "INSERT INTO users (fist_name, last_name, username, email, password, role) VALUES ('$fname', '$lname', '$username', '$email', '$password', '$permission')";
    $result = $conn->query($sql);

    if ($result) {
        echo "User added successfully.";
        //header('Location: /pages/Add_User.html');
    } else {
        echo "User add failed.";
        //header('Location: /pages/Add_User.html#error');
    }
}