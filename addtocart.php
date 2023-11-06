<?php
session_start();
require_once 'dbconnect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $productId = $_SESSION['id'];


    $query = "INSERT INTO shopping_cart_item (product_item_id, size, qty) VALUES (?, ?, ?)";
    $stmt = $dbcnx->prepare($query);
    $stmt->bind_param("iss", $productId, $size, $quantity);

    if ($stmt->execute()) {

        echo "Product added to the cart successfully!";
        
    } else {

        echo "Error adding the product to the cart.";
    }

    $stmt->close();
} else {

    echo "Invalid request.";
}
?>