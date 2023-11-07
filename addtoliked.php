<?php
session_start();
require_once 'dbconnect.php'; 
// Check if user is logged in using the session variable
if (isset($_SESSION['valid_user'])) {
  if (isset($_POST['liked'])) {
    
    $productId = $_SESSION['id'];
    $userId = $_SESSION['user_id'];

    $query = "SELECT * FROM products_liked WHERE user_id = ? AND product_item_id = ?";
    $stmt = $dbcnx->prepare($query);
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo "Product already liked.";
        $query = "DELETE FROM products_liked WHERE user_id = ? AND product_item_id = ?";
        $stmt = $dbcnx->prepare($query);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        header("Location: product.php?id=$productId");
    } else {
        echo "Product liked.";
        $query = "INSERT INTO products_liked (user_id, product_item_id) VALUES (?, ?)";
        $stmt = $dbcnx->prepare($query);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        header("Location: product.php?id=$productId");
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}
      
}else{

  echo "<script>alert('You must log in before liking the product.'); window.location.href='login.php';</script>";
  
} 
?>