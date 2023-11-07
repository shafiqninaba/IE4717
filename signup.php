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
    <div class= "header" id="myTopnav">
        <a class="" href="index.php" class="logo"><img src = images/LOGO.svg alt="sneakerhive logo"></a>
        <a class="" href="shop.php">Shop</a>
        <a class="" href="about_us.php">About Us</a>
        <div class="header-right">
            <a class="" href="#liked"><img src = images/liked_icon.svg alt="liked products"></a>
            <a class="" href="cart.php"><span class="cart_count"><?php echo $_SESSION['cart_count']?></span><img src = images/shopping_bag.svg alt="shopping cart"></a>
            <a class="" href="account.php"><img src = images/user_icon.svg alt="account"></a>
            <a class="active" href="login.php">Login</a>
        </div>
    </div>
    <!-- signup form -->
    <div class="login-container signup">
        <h1>Create an Account</h1>
        <form action="register.php" method = "post" class="signup-form" onsubmit="return validateForm()">
            <table>
                <tr>
                    <td colspan="2"><label for="email">Email</label>
                    <input type="text" name ="email" id="email" required></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="password">Password</label>
                    <input type="password" name ="password" id="password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="confirm_password">Confirm Password</label>
                    <input type="password" name ="confirm_password" id="confirm_password" required></td>
                </tr>
                <tr>
                    <td><label for="firstname">First Name</label>
                    <input type="text" name ="firstname" id="firstname" required></td>
                
                    <td><label for="lastname">Last Name</label>
                    <input type="text" name ="lastname" id="lastname" required></td>
                </tr>
                <tr>
                    <td>
                        <label for="gender">Gender</label>
                        <select name ="gender" id="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </td>
                    <td>
                    <label for="dob">Date of Birth</label>
                    <input type="date" name= "dob" id="dob" required>

                </tr>
                <tr>
                    <td colspan="2">
                        <label for="phone">Mobile Number</label>
                        <input type="text" name= "mobile" id="mobile" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><label for="address">Address</label>
                    <input type="text" name= "address" id="address" required></td>
                </tr>
            </table>
            <button type="submit">Create</button>
        </form>
        <p><i>Already have an account? <a href="login.php">Login here</a></i></p>
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