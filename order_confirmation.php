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

function get_latest_order_details(){
    include "dbconnect.php";
    $user_id = $_SESSION['user_id'];
    $query = "SELECT
    shop_order.id,
    shop_order.order_date,
    user_info.first_name,
    user_info.last_name,
    user_info.mobile_number,
    user_info.delivery_address
    
FROM
    shop_order
INNER JOIN user_info ON shop_order.user_id = user_info.id
WHERE
    shop_order.user_id = ".$user_id."
ORDER BY
    shop_order.order_date
DESC
LIMIT 1";
    $result = $dbcnx->query($query);
    $order_details = array();
    while ($row = $result->fetch_assoc()){
        $order_details[] = $row;
    }
    return $order_details[0];
}

// function to send email
function send_mail($order_details){
    $to      = 'f32ee@localhost';
$subject = 'Your SneakerHive order has been received [#'.$order_details['id'].']';
$message = "Dear " . $order_details['first_name'] . " " . $order_details['last_name'] . ",\n\nThank you for shopping with SneakerHive! Your order (#" . $order_details['id'] . ") has been confirmed and will be shipped to:\n\n" . $order_details['delivery_address'] . "\n\nIf you have any questions or concerns, please don't hesitate to contact us at f32ee@localhost.\n\nBest regards,\nThe SneakerHive Team\n\n\n\nThis is an automated email. Please do not reply to this email.";
$headers = 'From: f32ee@localhost' . "\r\n" .
    'Reply-To: f32ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers,'-ff32ee@localhost');
}

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
            <a class="active" href="cart.php"><img src = images/shopping_bag.svg alt="shopping cart"></a>
          <a class="<?php header_class(!logged_in()) ?>" href="account.php"><img src = images/user_icon.svg alt="account"></a>
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
    </div>
    <div class="order_confirmation_title">
        <h1>Thank you for shopping with us!</h1>
        <p>Your order has been confirmed. An email confirmation will be sent to <b><?php echo $_SESSION['valid_user']?></b> shortly.</p>
    </div>
<div class="cart_body_content order_confirmation">
    <div class="cart_items order_confirmation_left">
    <?php $order_details = get_latest_order_details();
    send_mail($order_details);
    ?>
            <h3><u>Here are your order details:</u></h3>
            <p><b>Order Number:</b> #<?php echo $order_details['id']?></p>
            <p><b>Customer:</b> <?php echo $order_details['first_name'].' '.$order_details['last_name']?></p>
            <p><b> Contact:</b> <?php echo $order_details['mobile_number']?></p>
            <p><b> Order Date:</b> <?php echo $order_details['order_date']?></p>
            <p><b> Shipping address:</b> <?php echo $order_details['delivery_address']?></p>
    </div>
<div class="order_summary">
    <h2>Order Summary</h2>
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
        foreach ($_SESSION['cart_items'] as $index=>$item) {
            ?>
            <tr>
                <td><?php echo $index+1?></td>
                <td><?php echo $item['pro_name'] ?></td>
                <td><?php echo $item['qty'] ?></td>
                <td><?php echo 'US'.$item['size'] ?></td>
                <td>$<?php echo $item['qty']*$item['price'] ?></td>
            </tr>
            <?php
            $total_price += $item['qty']*$item['price'];
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
            <tr><td><a href="#shop">Women's</a></td>
                <td><a href="#shop">About us</a></td>
            </tr>
            <tr><td><a href="#shop">Men's</a></td></tr>
            <tr><td><a href="#shop">Kids'</a></td></tr>
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