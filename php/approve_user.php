<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config/db_connection.php';
    $action = $_POST['action'];
    $username = $_POST['username'];

    if($action == 'approve') {
        $stmt = $conn->prepare("UPDATE registration SET status = 'approved' WHERE username = ?");
        $stmt2 = $conn->prepare("INSERT INTO users (username, password, email, first_name, last_name, role) SELECT username, password, email, first_name, last_name, role FROM registration WHERE username = ?");
        $stmt2->bind_param("s", $username);
    } else {
        $stmt = $conn->prepare("UPDATE registration SET status = 'denied' WHERE username = ?");
    }

    $stmt->bind_param("s", $username);

    if ($stmt->execute() && ($action != 'approve' || $stmt2->execute())) {
        // Redirect without prior output
        header('Location: ../pages/Add_User.php#user_action_success');
        exit();
    } else {
        error_log("User approval failed: " . $stmt->error . " " . ($action == 'approve' ? $stmt2->error : ""));
        header('Location: ../pages/Add_User.php#approve_error');
        exit();
    }

    $stmt->close();
    if ($action == 'approve') {
        $stmt2->close();
    }

    $conn->close();
}

