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
        <a class="active" href="shop.php">Shop</a>
        <a class="" href="about_us.php">About Us</a>
        <div class="header-right">
            <a class="" href="#liked"><img src = images/liked_icon.svg alt="liked products"></a>
            <a class="" href="cart.php"><img src = images/shopping_bag.svg alt="shopping cart"></a>
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
    <hr style = "margin: 0%; background-color:white">


    <main>
        <div style = "background-color: black; color: white; padding: 1px 50px 20px; margin-bottom: 30px;">
            <h1 style = "font-weight:500; margin-bottom: 0px;">Shop Men's</h1>
            <p style=" width: 30%">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Praesentium, cupiditate eius consectetur assumenda quod dignissimos, eos, 
                officia veritatis dolorem iusto quisquam eveniet nam repellat voluptate sequi dicta. 
                Aspernatur, necessitatibus quam.
            </p>
        </div>

        <section class = shop_main>
            <div class = "filters">
                <h4 style = "font-size: 20px;">Filters</h4>
                <label class="container">Liked
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                  </label><br>
                <h5 style = "font-size: 16px; margin-bottom: 10px;">Categoreies</h5>
                <label class="container">Lifestyle
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label><br>
                  
                <label class="container">Basketball
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label><br>
                  
                <label class="container">Football
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label><br>
                  
                <label class="container">Tennis
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label><br>
                  
                <label class="container">Court
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label><br>
                  

            </div>
            <div class ="shop-container">
                <div class="pro">
                    <img src = "images/placeholder.png" alt = "">
                    <div class = "des">
                        <h5>Product1</h5>
                        <span>Brand</span>
                        <h4>$99</h4>
                    </div>
                </div>
                <div class="pro">
                    <img src = "images/placeholder.png" alt = "">
                    <div class = "des">
                        <h5>Product1</h5>
                        <span>Brand</span>
                        <h4>$99</h4>
                    </div>
                </div>
                <div class="pro">
                    <img src = "images/placeholder.png" alt = "">
                    <div class = "des">
                        <h5>Product1</h5>
                        <span>Brand</span>
                        <h4>$99</h4>
                    </div>
                </div>
                <div class="pro">
                    <img src = "images/placeholder.png" alt = "">
                    <div class = "des">
                        <h5>Product1</h5>
                        <span>Brand</span>
                        <h4>$99</h4>
                    </div>
                </div>
                <div class="pro">
                    <img src = "images/placeholder.png" alt = "">
                    <div class = "des">
                        <h5>Product1</h5>
                        <span>Brand</span>
                        <h4>$99</h4>
                    </div>
                </div>
                <div class="pro">
                    <img src = "images/placeholder.png" alt = "">
                    <div class = "des">
                        <h5>Product1</h5>
                        <span>Brand</span>
                        <h4>$99</h4>
                    </div>
                </div>
                <div class="pro">
                    <img src = "images/placeholder.png" alt = "">
                    <div class = "des">
                        <h5>Product1</h5>
                        <span>Brand</span>
                        <h4>$99</h4>
                    </div>
                </div>
                <div class="pro">
                    <img src = "images/placeholder.png" alt = "">
                    <div class = "des">
                        <h5>Product1</h5>
                        <span>Brand</span>
                        <h4>$99</h4>
                    </div>
                </div>
                <div class="pro">
                    <img src = "images/placeholder.png" alt = "">
                    <div class = "des">
                        <h5>Product1</h5>
                        <span>Brand</span>
                        <h4>$99</h4>
                    </div>
                </div>
            </div>
        </section>


    </main>


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