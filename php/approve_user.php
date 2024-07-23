<?php
echo "in approve_user.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';
    echo "in post";
    $action = $_POST['action'];
    $username = $_POST['username'];

    if($action == 'approve') {
        echo "in approve";
        $stmt = $conn->prepare("UPDATE registration SET approved = 1 WHERE username = ?");
        $stmt2 = $conn->prepare("INSERT INTO users (username, password, email, first_name, last_name, role) SELECT username, password, email, first_name, last_name, role FROM registration WHERE username = ?");
        $stmt2->bind_param("s", $username);
    } else {
        echo "in disapprove";
        $stmt = $conn->prepare("UPDATE registration SET approved = 0 WHERE username = ?");
    }

    $stmt->bind_param("s", $username);

    echo "before execute";
    if ($stmt->execute() && ($action != 'approve' || $stmt2->execute())) {
        echo "in execute";
        // Redirect without prior output
        header('Location: ../pages/admin_dashboard.html#user_approved');
        exit();
    } else {
        echo "in else";
        // Output should be avoided before header() call
        // You can log errors for debugging
        error_log("User approval failed: " . $stmt->error . " " . ($action == 'approve' ? $stmt2->error : ""));
        header('Location: ../pages/admin_dashboard.html#approve_error');
        exit();
    }

    $stmt->close();
    if ($action == 'approve') {
        $stmt2->close();
    }

    $conn->close();
    echo "end";
}

?>
