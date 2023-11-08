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

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>SneakerHive</title>
    <link rel="icon" href="images/favicon.ico">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class= "header" id="myTopnav">
        <a class="" href="index.php" class="logo"><img src = images/LOGO.svg alt="sneakerhive logo"></a>
        <a class="" href="shop.php">Shop</a>
        <a class="" href="about_us.php">About Us</a>
        <div class="header-right">
            <a class="<?php header_class(!logged_in()) ?>" href="liked.php"><img src = images/liked_icon.svg alt="liked products"></a>
            <a class="" href="cart.php"><span class="cart_count"><?php echo $_SESSION['cart_count']?></span><img src = images/shopping_bag.svg alt="shopping cart"></a>
            <a class="<?php header_class(!logged_in()) ?>" href="account.php"><img src = images/user_icon.svg alt="account"></a>
            <a class="active <?php header_class(logged_in()) ?>" href="login.php">Login</a>
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

    <div class="login-container">
        <h1>Welcome Back</h1>
        <form action="authmain.php" method="post" id="loginForm">
            <input type="text" name= "username" id="username" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p><i>Or <a href="signup.php">create an account</a></i></p>
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