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
</head>

<body>
    <div class= "header" id="myTopnav">
      <a class="" href="index.php" class="logo"><img src = images/LOGO.svg alt="sneakerhive logo"></a>
      <a class="" href="shop.php">Shop</a>
      <a class="" href="about_us.php">About Us</a>
      <div class="header-right">
          <a class="" href="#liked"><img src = images/liked_icon.svg alt="liked products"></a>
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

<div class = index>
    <h1>Set the trends.</h1>
    <p style = " margin-bottom:40px">Whether you are looking for casual, sporty, or trendy sneakers, we have something for you. At SneakerHive, we don't follow the trends.<br><b><i>We set them.<i><b></p>
</div>

<div class="slideshow-container">

    <div class="mySlides fade">
      <div class="numbertext">1 / 3</div>
      <img src="images/shoe1.jpeg" style="width:100%">
    </div>
  
    <div class="mySlides fade">
      <div class="numbertext">2 / 3</div>
      <img src="images/shoe2.jpeg" style="width:100%">
    </div>
  
    <div class="mySlides fade">
      <div class="numbertext">3 / 3</div>
      <img src="images/shoe3.jpeg" style="width:100%">
    </div>
  
    <!--  Next and previous buttons  -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>
  <br>
    <!-- The dots/circles -->
    <div style="text-align:center; margin-bottom: 40px;">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
    
 
  

  <script>
    let slideIndex = 1;
    showSlides(slideIndex);
    
    function plusSlides(n) {
      showSlides(slideIndex += n);
    }
    
    function currentSlide(n) {
      showSlides(slideIndex = n);
    }
    
    function showSlides(n) {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      if (n > slides.length) {slideIndex = 1}    
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " active";
    }
    </script>




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