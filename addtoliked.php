<?php
session_start();
require_once 'dbconnect.php'; 
// Check if user is logged in using the session variable
if (isset($_SESSION['valid_user'])) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $productId = $_SESSION['id'];
      $userId = $_SESSION['user_id'];

      $query = "INSERT INTO products_liked (user_id,product_item_id) VALUES (?,?)";
      $stmt = $dbcnx->prepare($query);
      $stmt->bind_param("ii",$userId, $productId);
      $stmt->execute();
      $stmt->close();
  } else {
      echo "Invalid request.";
  }
      
}else{

  echo "<script>alert('You must log in before liking the product.'); window.location.href='login.php';</script>";
  
} 
?>