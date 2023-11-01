<?php
session_start();
// function: if user is logged in, return true, else return false
function logged_in() {
  return isset($_SESSION['valid_user']);
}

function header_class($function){
  if ($function) {echo 'hidden';} else {echo '';}
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
    <div class= "header">
        <a class="" href="index.php" class="logo"><img src = images/LOGO.svg alt="sneakerhive logo"></a>
        <a class="" href="shop.php">Shop</a>
        <a class="" href="about_us.php">About Us</a>
        <div class="header-right">
            <a class="" href="#liked"><img src = images/liked_icon.svg alt="liked products"></a>
            <a class="" href="cart.php"><img src = images/shopping_bag.svg alt="shopping cart"></a>
            <a class="active" href="account.php"><img src = images/user_icon.svg alt="account"></a>
            <a class="" href="login.php">Login</a>
        </div>
    </div>

    <div class="account-content-body">
        <div class="sidebar">
            <ul>
                <li><a href="account.php">Profile Details</a></li>
                <li><a href="orders.php"><u>Track My Order</u></a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="track-order-container">
        <div class="track-order-container-top">
            <div class="progress-visual">
                <ol class="progtrckr">
                    <li class="progtrckr-done">Order Confirmed</li><!--
                 --><li class="progtrckr-todo">Out for delivery</li><!--
                 --><li class="progtrckr-todo">Delivered</li>
                </ol>
            </div>

        </div>
        <div class="track-order-container-bottom">
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
                        <tr>
                            <td>1.</td>
                            <td>Product here</td>
                            <td>1</td>
                            <td>US10</td>
                            <td>$100</td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Product here</td>
                            <td>1</td>
                            <td>US10</td>
                            <td>$100</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Product here</td>
                            <td>1</td>
                            <td>US10</td>
                            <td>$100</td>
                        </tr>
                        <tr id="subtotal">
                            <td colspan="4">Subtotal</td>
                            <td>$300</td>
                        </tr>
                        <tr>
                            <td colspan="4">Shipping</td>
                            <td>$3</td>
                        </tr>
                        <tr><td colspan="5"><hr></td></tr>
                        <tr>
                            <td colspan="4">Total</td>
                            <td>$303</td>
                        </tr>
                    </table>
        </div>
    </div>
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