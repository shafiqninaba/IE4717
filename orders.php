<?php
session_start();
// function: if user is logged in, return true, else return false
function logged_in() {
  return isset($_SESSION['valid_user']);
}

function is_admin() {
    if (isset($_SESSION['valid_user'])){
        if ($_SESSION['valid_user'] == 'admin@admin.com'){
            header("Location: admin_page.php");
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}
is_admin();
// if not logged_in(), $_SESSION['cart_count'] = 0
if (!logged_in()) {
  $_SESSION['cart_count'] = 0;
}

function header_class($function){
  if ($function) {echo 'hidden';} else {echo '';}
}

function get_all_orders(){
    include "dbconnect.php";
    if (!logged_in()) {
        return array();
    }
    $user_id = $_SESSION['user_id'];
    $query = "SELECT id FROM shop_order WHERE user_id =".$user_id." ORDER BY id DESC";
    $result = $dbcnx->query($query);
    $orders = array();
    while ($row = $result->fetch_assoc()){
        $orders[] = $row;
    }
    if (count($orders) == 0) {
        return array();
    }
    return $orders;
}
include "dbconnect.php";
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>SneakerHive</title>
    <link rel="icon" href="images/favicon.ico">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <script src="shipping_validation.js"></script>
</head>

<body>
    <div class= "header" id="myTopnav">
        <a class="" href="index.php" class="logo"><img src = images/LOGO.svg alt="sneakerhive logo"></a>
        <a class="" href="shop.php">Shop</a>
        <a class="" href="about_us.php">About Us</a>
        <div class="header-right">
            <a class="<?php header_class(!logged_in()) ?>" href="liked.php"><img src = images/liked_icon.svg alt="liked products"></a>
            <a class="" href="cart.php"><span class="cart_count"><?php echo $_SESSION['cart_count']?></span><img src = images/shopping_bag.svg alt="shopping cart"></a>
            <a class="active <?php header_class(!logged_in()) ?>" href="account.php"><img src = images/user_icon.svg alt="account"></a>
            <a class="<?php header_class(logged_in()) ?>" href="login.php">Login</a>
        </div>
        <a class= "icon" href="javascript:void(0);" onclick="myFunction()">
            <img src = images/hamburger_menu.svg alt="menu">
        </a>
        <script>
            function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "header") {
                x.className += " responsive";
            } else {
                x.className = "header";
            }
            }
        </script>
    </div>

    <div class="account-content-body">
        <div class="sidebar">
            <ul>
                <li><a href="account.php">Profile Details</a></li>
                <li><a href="orders.php"><u>Track My Order</u></a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <?php

$orders = get_all_orders();
if (count($orders) == 0) {
    echo '<div class="track-order-container">';
    echo '<h2>You have no orders yet.</h2>';
    echo '</div>';
}
else {
foreach ($orders as $index=>$order) {
    $order_id = $order['id'];
    $query = "SELECT * FROM order_line INNER JOIN product_info ON order_line.product_item_id=product_info.id WHERE order_line.order_id =".$order_id;
    $result = $dbcnx->query($query);
    $order_items = array();
    while ($row = $result->fetch_assoc()){
        $order_items[] = $row;
    }


        ?>


        <div class="track-order-container">
        <div class="track-order-container-top">
            <div class="progress-visual">
                <?php $todo_array = array("progtrckr-done","progtrckr-todo")?>
                <ol class="progtrckr">
                <li class="progtrckr-done">Order Confirmed</li>
                <li class="<?php echo $todo_array[array_rand($todo_array,1)]?>">Out for delivery</li>
                <li class="progtrckr-todo">Delivered</li>
                </ol>
            </div>

        </div>
        <div class="track-order-container-bottom">
            <div class="order_summary">
                <h2>Order #<?php echo $order_id?></h2>
                <div>
                    <table>
                        <tr>
                            <td>No.</td>
                            <td>Item</td>
                            <td>Qty</td>
                            <td>Size</td>
                            <td>Price</td>
                        </tr>
                        <?php
    $total_price = 0;
    foreach($order_items as $item_index=>$item){
        echo '<tr>';
        echo '<td>'.($item_index+1).'.</td>';
        echo '<td>'.$item['pro_name'].'</td>';
        echo '<td>'.$item['qty'].'</td>';
        echo '<td>US'.$item['size'].'</td>';
        echo '<td>$'.$item['price'].'</td>';
        echo '</tr>';
        $total_price += $item['price']*$item['qty'];

    }
                        ?>
                        <tr id="subtotal">
                            <td colspan="4">Subtotal</td>
                            <td>$<?php echo $total_price?></td>
                        </tr>
                        <tr>
                            <td colspan="4">Shipping</td>
                            <td>$3</td>
                        </tr>
                        <tr><td colspan="5"><hr></td></tr>
                        <tr>
                            <td colspan="4">Total</td>
                            <td>$<?php echo $total_price+3?></td>
                        </tr>
                    </table>
        </div>
</div>
    </div>
    <hr>
    <?php 
        }
    }
        ?>
</div>
</div>
</div>
    <footer>
    <div class = "footer">
      <div class="newsletter footer-left"  >
      <h3 id="newsletter-title">Sign up for our newsletter</h3>
      <p id="newsletter-description">Be the first to know about our special offers, new product launches and events</p>
    </div>
    <div class="newsletter" id = "newsletter-form">
      <form action="submit_newsletter.php" method="POST">
        <input type="text" name="newsletter_email" placeholder="Email Address">
        <button type="submit" >Sign up</button>
      </form>
    </div>
    <div class="newsletter footer-right">
        <table>
            <tr><td><h4>Shop</h4></td>
                <td><h4>About</h4></td>
            </tr>
            <tr><td><a href="shop.php">Footwear</a></td>
                <td><a href="about_us.php">About us</a></td>
        </table>
    </div>
</div>
    <div class="copyright">
        <hr>
      <p>&copy; 2023 SneakerHive. All Rights Reserved.</p>
      </div>
    
    </footer>
        

    
</body>
</html>