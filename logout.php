<?php
  session_start();
  
  // store to test if they *were* logged in
  $old_user = $_SESSION['valid_user']; 
  $old_id = $_SESSION['user_id'];
  $old_product_id = $_SESSION['id'];
  unset($_SESSION['valid_user']);
  unset($_SESSION['user_id']);
  unset($_SESSION['id']);
  session_destroy();
  header("Location: index.php");
?>