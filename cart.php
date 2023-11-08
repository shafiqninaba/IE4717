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

// function to get shopping cart items
function get_shopping_cart(){

    include "dbconnect.php";

    if (!logged_in()) {
        return array();
    }
    $user_id = $_SESSION['user_id'];
    $query = "SELECT shopping_cart_item.id,product_info.id AS product_item_id,product_info.qty_in_stock,product_info.pro_name,product_info.price,product_info.product_image,shopping_cart_item.size,shopping_cart_item.qty FROM shopping_cart_item INNER JOIN product_info ON shopping_cart_item.product_item_id=product_info.id WHERE shopping_cart_item.user_id =".$user_id;
    $result = $dbcnx->query($query);
    $cart = array();
    while ($row = $result->fetch_assoc()){
        $cart[] = $row;
    }
    return $cart;

}
// function to delete item from shopping cart
function delete_shopping_cart_item($product_item_id){

    include "dbconnect.php";
    $query = "DELETE FROM shopping_cart_item WHERE id =".$product_item_id;
    $result = $dbcnx->query($query);
}
if(isset($_POST['remove_button'])) { 
    delete_shopping_cart_item($_POST['remove_button']);
} 

// function to checkout items in shopping cart
function checkout_items($cart_items,$user_id,$order_total){
    include "dbconnect.php";
                // update product_info table to reduce stock
        foreach ($cart_items as $index=>$item) {
            $product_item_id = $item['product_item_id'];
            $qty = $item['qty'];
            // update product_info table to reduce stock

            $sql = "UPDATE product_info SET qty_in_stock = qty_in_stock - ? WHERE id = ?";
            $stmt = $dbcnx->prepare($sql);
            $stmt->bind_param('ii', $qty,$product_item_id);
            $stmt->execute();
            $stmt->free_result();
        }
        // insert data into site_user table
        $sql = "INSERT INTO shop_order (user_id,order_total) VALUES (?, ?)";
        $stmt = $dbcnx->prepare($sql);
        $stmt->bind_param('id', $user_id,$order_total);
        $stmt->execute();
    
        // get the user id of the newly inserted row
        $shop_order_id = $stmt->insert_id;
        $stmt->free_result();
        
        // insert $cart_items data into order_line table
        foreach ($cart_items as $index=>$item) {
            $product_item_id = $item['product_item_id'];
            $qty = $item['qty'];
            $price = $item['price'];
            $size = $item['size'];
            $sql = "INSERT INTO order_line (product_item_id,order_id,qty,size,price) VALUES (?,?,?,?,?)";
            $stmt = $dbcnx->prepare($sql);
            $stmt->bind_param('iiiid', $product_item_id,$shop_order_id,$qty,$size,$price);
            $stmt->execute();
            $stmt->free_result();
        }

        // remove items from shopping cart after checking out
        foreach ($cart_items as $index=>$item) {
            delete_shopping_cart_item($item['id']);
        }
header("Location: payment.php");

}

// function to edit qty and size of item in shopping cart
function edit_shopping_cart_item($product_item_id,$qty,$size){
    include "dbconnect.php";
    // if qty and size are empty, javascsript alert to enter qty and size
    if ($qty == "" || $size == ""){
        echo "<script>alert('Please enter quantity and size')</script>";
        return;
    }
    $query = "UPDATE shopping_cart_item SET qty =".$qty.", size =".$size." WHERE id =".$product_item_id." AND user_id =".$_SESSION['user_id'];
    $result = $dbcnx->query($query);
}
if(isset($_POST['size']) || isset($_POST['quantity'])) { 
    edit_shopping_cart_item($_POST['product_item_id'],$_POST['quantity'],$_POST['size']);
} 

$cart_items = get_shopping_cart();
$_SESSION['cart_count'] = count($cart_items);
$_SESSION['cart_items'] = $cart_items;
if(isset($_POST['checkout-button'])) { 
    checkout_items($cart_items, $_SESSION['user_id'], $_POST['checkout-button']);
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
            <a class="active" href="cart.php"><span class="cart_count"><?php echo $_SESSION['cart_count']?></span><img src = images/shopping_bag.svg alt="shopping cart"></a>
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
            function validateQuantity(form) {
    var quantityInput = form.form.quantity;
    var min = parseInt(quantityInput.min);
    var max = parseInt(quantityInput.max);
    var quantity = parseInt(quantityInput.value);
    if (quantity < min || quantity > max) {
        alert("Quantity must be between " + min + " and " + max);
        quantityInput.value = quantityInput.defaultValue;
        return false;
    }
    return true;
}
        </script>
    </div>
    </div>
<?php if (logged_in() && count($cart_items)>0){
    
    ?>
    <div class= "flex-wrapper">
<div class="cart_body_content">
    <div class="cart_items">
        <h1>Your cart</h1>
        <p>Not ready to checkout? <a href="shop.php">Continue shopping</a></p>
    <?php
        foreach ($cart_items as $index=>$item) {
            ?>
            <div class="cart_item">
                <div class="cart_item_image">
                    <img src="<?php echo $item['product_image'] ?>" alt="Image for <?php echo $item['pro_name'] ?>">
                </div>
                <div class="cart_item_details">
                    <h3><?php echo $item['pro_name'] ?></h3>
<form method="POST" onsubmit="return validateQuantity()">
                    <input type="hidden" name="product_item_id" value="<?php echo $item['id'] ?>">
                    <div class = "quantity_cart">
                    <label for="size">Size (US):</label>
                    <input type='number' name="size" min="5" max="12" value="<?php echo $item['size'] ?>" onchange="this.form.submit();">
        </div>
                    <div class = "quantity_cart">
                    <label for = "quantity">Quantity:</label>
                    <input type = 'number' name ="quantity" min="1" max="<?php echo $item['qty_in_stock']?>" value="<?php echo $item['qty'] ?>" onchange="if(!validateQuantity(this)) { return false; } this.form.submit();">
                    </div>
        </form>
                    <p>Price: $<?php echo $item['price'] ?></p>
                </div>
                <div class="cart_item_remove">
                    <form method="POST">
                    <button title="Remove item" name="remove_button" value="<?php echo $item['id'] ?>" onclick="return confirm('Are you sure you want to remove this item?')">X</button>
                </form>
                
                </div>
        </div>
        <hr>
        <?php
}
?>
</div>
<div class="order_summary fixed">
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
            <?php

        $cart_items = get_shopping_cart();
        $total_price = 0;
        foreach ($cart_items as $index=>$item) {
            ?>
            <tr>
                <td><?php echo $index+1?></td>
                <td><?php echo $item['pro_name'] ?></td>
                <td><?php echo $item['qty'] ?></td>
                <td><?php echo 'US'.$item['size'] ?></td>
                <td>$<?php echo $item['qty']*$item['price'] ?></td>
            </tr>
            <?php
            $total_price += $item['qty']*$item['price'];
}
?>
            <tr id="subtotal">
                <td colspan="4">Subtotal</td>
                <td>$<?php echo $total_price+3;?></td>
            </tr>
            <tr>
                <td colspan="4">Shipping</td>
                <td>$3</td>
            </tr>
            <tr><td colspan="5"><hr></td></tr>
            <tr>
                <td colspan="4">Total</td>
                <td>$<?php echo $total_price+3;?></td>
            </tr>
        </table>
        <form method="POST">
        <button name="checkout-button" id="checkout-button" value="<?php echo $total_price+3;?>">Checkout</button>
</form>
    </div>
</div>
</div>

<?php }
elseif (logged_in() && count($cart_items)==0){?>
    <div class= "flex-wrapper">
    <div class="cart_body_content">
    <div class="cart_items">
        <h1>Your cart</h1>

        <p>Your cart is empty. <a href="shop.php">Continue browsing</a> to add items to your cart.</p>
</div>
</div>

<?php }
    

else{?>
<div class="cart_body_content">
    <div class="cart_items">
        <h1>Your cart</h1>

        <p>Please <a href="login.php">login</a> to view your cart. Or <a href="shop.php">Continue browsing</a></p>
</div>
</div>


<?php }?>
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
</div>

    
</body>
</html>