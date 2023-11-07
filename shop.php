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
<?php
    $num_results = 0;
    $max_items = 30;
    require_once 'dbconnect.php';
    if(isset($_GET['search'])){
        $search = ($_GET['search']);
        $sql = "SELECT * FROM product_info WHERE pro_name LIKE '%$search%'";
        $all_product = $dbcnx->query($sql);
        $num_results = $all_product->num_rows;

        if ($num_results == 0) {
            echo "<script>alert('No items matched your search. Try some different keywords.'); window.location.href='shop.php';</script>";
        }

    }elseif(isset($GET['search']) && (isset($_GET['type1']) || isset($_GET['type2']) || isset($_GET['type3']) || isset($_GET['type4']) || isset($_GET['type5']))){
        $trainers = $_GET['type1'];
        $runningshoes = $_GET['type2'];
        $hitops = $_GET['type3'];
        $canvas = $_GET['type4'];
        $flipflopssandals = $_GET['type5']; 
        $search =$GET['search'];
        echo $trainers;

        $sql = "SELECT * FROM product_info WHERE pro_name LIKE '%$search%' AND category IN ('$trainers', '$canvas', '$flipflops', '$hitops', '$flipflopssandals')";
        $all_product = $dbcnx->query($sql);
        $num_results = $all_product->num_rows;

    }else{
        require_once 'dbconnect.php';
        $sql ="SELECT * FROM product_info ";
        $all_product = $dbcnx->query($sql);
        $num_results = $all_product->num_rows; 
    }
?>
<?php
    $page = 0;
    if(isset($_GET['page'])){
        $page = ($_GET['page']);
        $start_from = ($page - 1) * $max_items;
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
            <a id ="wrapper">
                <form action = shop.php method = "GET">
                    <input class="search" placeholder="Search" type="text" name = "search">
                    <button type="submit" class="search-icon" ><img src="images/search_icon.svg" alt="search"></button>
                </form>
             </a>  
            <a class="" href="liked.php"><img src = images/liked_icon.svg alt="liked products"></a>
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
            <form class = "filters" action ="shop.php" method = "GET">
                <h5 style = "font-size: 16px; margin-bottom: 10px;">Categoreies</h5>
                <label class="container">Trainers
                    <input type="checkbox" value = 'Trainers' name = 'type1'>
                    <span class="checkmark"></span>
                </label><br>
                  
                <label class="container">Running Shoes
                    <input type="checkbox" value = 'Running Shoes' name = 'type2'>
                    <span class="checkmark"></span>
                </label><br>
                  
                <label class="container">Hi-Tops
                    <input type="checkbox" value = 'Hi-Tops' name = 'type3'>
                    <span class="checkmark"></span>
                </label><br>
                  
                <label class="container">Canvas
                    <input type="checkbox" value = 'Canvas' name = 'type4'>
                    <span class="checkmark"></span>
                </label><br>
                  
                <label class="container">Flipflops & Sandals
                    <input type="checkbox" value = 'Flipflops & Sandals' name = 'type5'>
                    <span class="checkmark"></span>
                </label><br>
                <button type="submit"> Search </button>

            </form>
            <div class ="shop-container">

                <?php
                for ($i = $start_from; $i < $start_from + $max_items; $i++) {
                    if ($i > 0) {
                        mysqli_data_seek($all_product, $i);
                    }
                
                    $row = mysqli_fetch_assoc($all_product);
                
                    if ($row) {
                        $product_image = $row['product_image'];
                        $product_name = $row['pro_name'];
                        $product_price = $row['price'];
                        $product_id = $row['id'];
                ?>
                    <div class="pro" onclick="location.href='product.php?id=<?php echo $product_id;?>';">
                        <img src="<?php echo $product_image; ?>" alt="">
                        <div class="des">
                            <h5><?php echo $product_name; ?></h5>
                            <span>Brand</span>
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