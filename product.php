
<?php
session_start();
/* var_dump($_SESSION); */

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $_SESSION["id"] = $_GET['id'];


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
require_once 'dbconnect.php';

    $id = $_SESSION["id"];

    $sql = "SELECT * FROM product_info WHERE id = $id";
    $product = $dbcnx->query($sql);
    $row = mysqli_fetch_assoc($product);
    $_SESSION["image"] = $row["product_image"];
    $_SESSION["name"] = $row["pro_name"];
    $_SESSION["price"] = $row["price"];
} 
else {
    echo 'Invalid product identifier.';
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>SneakerHive</title>
    <link rel="icon" href="images/favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>


<body>
    <div class= "header" id="myTopnav">
        <a class="" href="index.php" class="logo"><img src = images/LOGO.svg alt="sneakerhive logo"></a>
        <a class="active" href="shop.php">Shop</a>
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


    <div class = "single_pro">
        <section class = "pro_img">
            <img src = "<?php echo $_SESSION['image'] ?>" alt ="This product canot be diplayed">
        </section>

        <section class = "pro_desc">
            <h2><?php echo $_SESSION['name'] ?></h2>
            <form name = "liked" action = "addtoliked.php" method = "post">
                <button  onclick = "Toggle()" id = 'btn' class = 'btn' type="submit"><img src = images/heart_icon.svg alt=""></button>
            </form>
            <h3>$<?php echo $_SESSION['price'] ?></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa quos nulla repellendus hic deserunt corrupti illo aut voluptatibus nobis ipsum? Ab recusandae odio deserunt, dolores ipsum expedita repellendus animi numquam?</p>
            <p style="color: grey; margin: 19px 0px 3px;">Size (US)</p>
            <form name = "order" action = "addtocart.php" method = "post" onsubmit = "return orderValidation()">
                <ul class="size">
                    <li>
                    <input type="radio" id="6" name="size" value= "6">
                    <label for="6">6</label>
                    </li>
                    <li>
                    <input type="radio" id="7" name="size" value= "7">
                    <label for="7">7</label>
                    </li>
                    <li>
                    <input type="radio" id="8" name="size" value= "8">
                    <label for="8">8</label>
                    </li>
                    <li>
                    <input type="radio" id="9" name="size" value= "9">
                    <label for="9">9</label>
                    </li>
                    <li>
                    <input type="radio" id="10" name="size" value= "10">
                    <label for="10">10</label>
                    </li>
                    <li>
                    <input type="radio" id="11" name="size" value= "11">
                    <label for="11">11</label>
                    </li>
                    <li>
                    <input type="radio" id="12" name="size" value= "12">
                    <label for="12">12</label>
                    </li>
                </ul><br><br>
                <div class = "quantity" style="width:90px;">
                    <p style="color: grey; margin: 19px 0px 3px;">Quantity</p>
                    <input type = 'number' name ="quantity" min="1" value="1">
                </div>
                <button type="submit"> Add to cart </button>
            </form>
            <script>
                function orderValidation(){
                    var size = document.forms["order"]["size"]. value;

                    if (size == ''){
                        alert('Please select a size.');
                        return false;
                    }
                }
            </script>
        </section>
    </div>
    <script>
        var btn = document.getElementById('btn');
        Toggle(){
            if (btnvar.style.color == 'red'){
                btnvar.style.color = 'grey';
        }else{
            btnvar.style.color = 'red';
        }
        }
        btn.addEventListener('click', function() {
        btn.classList.toggle('active');
        });


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
