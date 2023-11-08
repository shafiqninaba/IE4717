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
        <a class="active" href="about_us.php">About Us</a>
        <div class="header-right">
            <a class="<?php header_class(!logged_in()) ?>" href="liked.php"><img src = images/liked_icon.svg alt="liked products"></a>
            <a class="" href="cart.php"><span class="cart_count"><?php echo $_SESSION['cart_count']?></span><img src = images/shopping_bag.svg alt="shopping cart"></a>
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
<div class="flex-wrapper">
    <div class="aboutus">
    <h1 class="aboutus-title">About Us</h1>
    <h2 class="aboutus-subtitle"><i>Who We Are</i></h2>
    <p class="aboutus-text">We are SneakerHive, a Singapore-based online store that sells sneakers from various brands and styles. We are passionate about sneakers and we want to share our love for them with you. Whether you are looking for casual, sporty, or trendy sneakers, we have something for you.</p>
    <h2 class="aboutus-subtitle"><i>What We Do</i></h2>
    <p class="aboutus-text">We offer a wide range of sneakers at affordable prices. You can browse our catalog and find your perfect pair in just a few clicks. We also provide fast and free shipping within Singapore, as well as easy returns and exchanges. Our customer service team is always ready to assist you with any questions or issues you may have.</p>
    <h2 class="aboutus-subtitle"><i>Why Choose Us</i></h2>
    <p class="aboutus-text">We are more than just a sneaker store. We are a community of sneaker enthusiasts who value quality, style, and comfort. We care about our customers and we want to make your shopping experience enjoyable and satisfying. We also support local and global causes that align with our values, such as environmental sustainability and social justice. By choosing us, you are not only getting a great pair of sneakers, but also making a positive impact on the world.</p>
    <h2 class="aboutus-subtitle"><i>Join Us</i></h2>
    <p class="aboutus-text">If you share our passion for sneakers, we invite you to join our hive. You can follow us on social media, subscribe to our newsletter, or join our loyalty program to get the latest updates, exclusive deals, and rewards. You can also contact us anytime via email, phone, or chat. We would love to hear from you and get your feedback.<br>
Thank you for choosing SneakerHive. We hope you enjoy your sneakers as much as we do.</p>
    <h4 class="aboutus-closing"><i>Happy Shopping!<br>- The SneakerHive Team</i></h4>
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
        </div>

    
</body>
</html>