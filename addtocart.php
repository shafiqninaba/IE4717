<?php
session_start();
require_once 'dbconnect.php'; 
// Check if user is logged in using the session variable
if (!isset($_SESSION['valid_user'])) {
  echo "<script>alert('You must log in before adding to your shopping cart!'); window.location.href='login.php';</script>";
      
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $productId = $_SESSION['id'];


    $query = "INSERT INTO shopping_cart_item (product_item_id,user_id, size, qty) VALUES (?,?, ?, ?)";
    $stmt = $dbcnx->prepare($query);
    $stmt->bind_param("iiss", $productId,$_SESSION['user_id'], $size, $quantity);
    $stmt->execute();
    $stmt->close();
    header("Location: shop.php");
    
    } else {
        echo "Invalid request.";
    }
