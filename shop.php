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
// if reset button is clicked, unset all session variables
if (isset($_GET['reset'])) {
    unset($_SESSION['category_filter']);
    unset($_SESSION['search_result']);
    header("Location: shop.php");
}

if (isset($_SESSION['category_filter'])) {
    $category_filter_query = $_SESSION['category_filter_query'];
}

?>
<?php

    $num_results = 0;
    $max_items = 30;
    require_once 'dbconnect.php';
    if(isset($_SESSION['search_result']) && isset($_SESSION['category_filter'])){
        $search = $_SESSION['search_result'];
        $sql = "SELECT * FROM product_info WHERE pro_name LIKE '%$search%' AND category IN ($category_filter_query)";
        $all_product = $dbcnx->query($sql);
        $num_results = $all_product->num_rows;
        if ($num_results == 0) {
            echo "<script>alert('No items matched your search. Try some different keywords.'); window.location.href='shop.php';</script>";
            unset($_SESSION['search_result']);
        }
    }
    elseif (isset($_SESSION['category_filter'])){
        $sql = "SELECT * FROM product_info WHERE category IN ($category_filter_query)";
        $all_product = $dbcnx->query($sql);
        $num_results = $all_product->num_rows;
    }
    elseif (isset($_SESSION['search_result'])){
        $search = $_SESSION['search_result'];
        $sql = "SELECT * FROM product_info WHERE pro_name LIKE '%$search%'";
        $all_product = $dbcnx->query($sql);
        $num_results = $all_product->num_rows;
        if ($num_results == 0) {
            echo "<script>alert('No items matched your search. Try some different keywords.'); window.location.href='shop.php';</script>";
            unset($_SESSION['search_result']);
        }
    }
    else{
        $sql ="SELECT * FROM product_info";
        $all_product = $dbcnx->query($sql);
        $num_results = $all_product->num_rows; 
    }
?>
<?php
    $page = 0;
    if(isset($_GET['page'])&& !($_GET['page']== 1)){
        $page = ($_GET['page']);
        $start_from = ($page-1) * $max_items;
    }else{
        $start_from = 1;
    }
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <title>SneakerHive</title>
    <link rel="icon" href="images/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <hr style = "margin: 0%; background-color:white">


    <main>
        <div style = "background-color: black; color: white; padding: 1px 50px 20px; margin-bottom: 30px;">
            <h1 style = "font-weight:500; margin-bottom: 0px;">Catalogue</h1>
            <p style=" width: 30%">A curation of the most trending pieces in the footwear industry. From the latest releases to the most popular classics, we have it all. Take your time to pick out the best pieces for your collection.
            </p>
        </div>

        <section class = shop_main>
            <div class="shop_top">
            <a class ="searchbar">
                <form action = "search_and_filter.php" method = "GET">
                <input class="search" <?php if(isset($_SESSION['search_result'])){echo "value='".$_SESSION['search_result']."'";}else{echo 'placeholder="Search"';}?> type="text" name = "search">
                    <button type="submit" class="search-icon" ><img src="images/search_icon.svg" alt="search"></button>
                </form>
             </a>  
             </div>
             <div class="shop_bottom">
             <form method = "GET">
                <button type="submit" class="shop_button reset" name = "reset">Reset Filter</button>
        </form>
        </div>



        
        <div class="shop_bottom">
        <form action = "search_and_filter.php" class = "filters"  method = "GET">
    <h5 style = "font-size: 16px; margin-bottom: 10px;">Categories</h5>
    <label class="container">Trainers
        <input type="checkbox" value = 'Trainers' name = 'category_filter[]' <?php if (isset($_SESSION['category_filter']) && in_array('Trainers', $_SESSION['category_filter'])) {echo 'checked';} ?>>
        <span class="checkmark"></span>
    </label><br>

    <label class="container">Running Shoes
        <input type="checkbox" value = 'Running Shoes' name = 'category_filter[]' <?php if (isset($_SESSION['category_filter']) && in_array('Running Shoes', $_SESSION['category_filter'])) echo 'checked'; ?>>
        <span class="checkmark"></span>
    </label><br>

    <label class="container">Hi-Tops
        <input type="checkbox" value = 'Hi-Tops' name = 'category_filter[]' <?php if (isset($_SESSION['category_filter']) && in_array('Hi-Tops', $_SESSION['category_filter'])) echo 'checked'; ?>>
        <span class="checkmark"></span>
    </label><br>

    <label class="container">Canvas
        <input type="checkbox" value = 'Canvas' name = 'category_filter[]' <?php if (isset($_SESSION['category_filter']) && in_array('Canvas', $_SESSION['category_filter'])) echo 'checked'; ?>>
        <span class="checkmark"></span>
    </label><br>

    <label class="container">Flipflops & Sandals
        <input type="checkbox" value = 'Flip-Flops & Sandals' name = 'category_filter[]' <?php if (isset($_SESSION['category_filter']) && in_array('Flip-Flops & Sandals', $_SESSION['category_filter'])) echo 'checked'; ?>>
        <span class="checkmark"></span>
    </label><br>
    <button class="shop_button" type="submit"> Search </button>
</form>

            </form>
            <div class ="shop-container">

                <?php
                for ($i = $start_from; $i < $start_from + $max_items; $i++) {
                    if ($i > 0) {
                        mysqli_data_seek($all_product, $i-1);
                    }
                
                    $row = mysqli_fetch_assoc($all_product);
                
                    if ($row) {
                        $product_image = $row['product_image'];

                        $product_name = $row['pro_name'];
                        $_product_category = $row['category'];
                        $product_price = $row['price'];
                        $product_id = $row['id'];
                        $product_stock = $row['qty_in_stock'];
                ?>
                    <div class="pro" onclick="location.href='product.php?id=<?php echo $product_id;?>';">
                        <img src="<?php echo $product_image; ?>" alt="">
                        <div class="des">
                            <h5><?php echo $product_name; ?></h5>
                            <span><?php echo $_product_category; ?></span><br>
                            <span><?php echo $product_stock; ?> left in stock</span>
                            <h4>$<?php echo $product_price; ?></h4>
                        </div>
                    </div>
                <?php
                }else{
                    break;
                }
            }
                ?>
            </div>
        </div>
        </section>

        <section class ="pages">
        <div class = "page_num">
            <?php
                $num_pages = ceil($num_results / $max_items);
                for ($i = 1; $i <= $num_pages; $i++) {
                    echo "<a href='shop.php?page=".$i."'>".$i."</a>";
                }
            ?>
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
        <input type="text" name="newsletter_email" placeholder="Email Address" required>
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