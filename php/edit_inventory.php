<?php
include 'db_connection.php';

function send_email_to_manager($product_id) {
    // Fetch product details
    global $conn;
    $sql = "SELECT name, quantity FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($name, $quantity);
    $stmt->fetch();
    $stmt->close();

    $to = "manager@example.com";
    $subject = "Stock Alert: $name";
    $message = "The stock for $name (ID: $product_id) is below the threshold. Current quantity: $quantity.";
    $headers = "From: no-reply@example.com";

    mail($to, $subject, $message, $headers);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE products SET quantity = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $product_id);

    if ($stmt->execute()) {
        echo "Inventory updated successfully!";
        
        // Check if quantity is below the threshold and send notification if needed
        $threshold = 10; // Example threshold
        if ($quantity < $threshold) {
            send_email_to_manager($product_id);
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

