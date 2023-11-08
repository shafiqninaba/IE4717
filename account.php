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

include 'dbconnect.php';
if (logged_in()) {
  $username = $_SESSION['valid_user'];
} else {
  header("Location: login.php");
  exit();
}

// query to get user details
$query = 'SELECT * FROM user_info WHERE user_id = ?';
$stmt = $dbcnx->prepare($query);

$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
// store results in $result
$result = $stmt->get_result();  
$num_results = $result->num_rows;
$row = $result->fetch_assoc();
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$mobile_number = $row['mobile_number'];
$gender = $row['gender'];
$date_of_birth = $row['date_of_birth'];
$delivery_address = $row['delivery_address'];

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
    </div>

    <div class="account-content-body">
        <div class="sidebar">
            <ul>
                <li><a href="account.php"><u>Profile Details</u></a></li>
                <li><a href="orders.php">Track My Order</a></li>
                <li><a href="logout.php">Logout</a></li>
            
            </ul>
        </div>
        <div class="login-container signup">
            <h1>Profile Details</h1>
            <form action="edit_account_details.php" method="POST" class="signup-form" onsubmit="return validateForm()">
                <table>
                    <tr>
                        <td colspan="2"><label for="username">Email</label>
                        <input type="text" name="email" id="email" required value='<?php echo $username; ?>'></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label for="password">Password</label>
                        <input type="password" name="password" id="password" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" required></td>
                    </tr>
                    <tr>
                        <td><label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" required value='<?php echo $first_name; ?>'></td>
                    
                        <td><label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" required value='<?php echo $last_name; ?>'></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" required>
                                <option value="male" <?php if($gender == 'male'){echo 'selected';} ?>>Male</option>
                                <option value="female" <?php if($gender == 'female') {echo 'selected';} ?>>Female</option>
                                <option value="other" <?php if($gender == 'other') {echo 'selected';} ?>>Other</option>
                            </select>
                        </td>
                        <td>
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" id="dob" required value='<?php echo $date_of_birth; ?>'>
    
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="phone">Mobile Number</label>
                            <input type="text" name="mobile" id="mobile" required value='<?php echo $mobile_number; ?>'>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><label for="address">Address</label>
                        <input type="text" name="address" id="address" required value='<?php echo $delivery_address; ?>'></td>
                    </tr>
                </table>
                <button type="submit">Edit</button>
            </form>
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