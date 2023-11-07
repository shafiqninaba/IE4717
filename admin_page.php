<?php
session_start();
// function: if user is logged in, return true, else return false
function logged_in() {
  return isset($_SESSION['valid_user']);
}

function is_admin() {
    if (isset($_SESSION['valid_user'])){
        if ($_SESSION['valid_user'] == 'admin@admin.com'  && $_SESSION['admin'] == false){
            $_SESSION['admin'] == true;
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
// php query SUM(order_total) from shop_order table
include 'dbconnect.php';
$query = "SELECT SUM(order_total) AS total FROM shop_order";
$result = $dbcnx->query($query);
$row = $result->fetch_assoc();
$total_revenue = $row['total'];

// php query most popular product_item_id from order_line table given qty column. inner join product_item_id with id in product_info table

$query = "SELECT pi.pro_name, SUM(ol.qty) AS total FROM order_line ol INNER JOIN product_info pi ON ol.product_item_id = pi.id GROUP BY ol.product_item_id ORDER BY total DESC LIMIT 1";

$result = $dbcnx->query($query);
$row = $result->fetch_assoc();

$most_popular_product_item_name = $row['pro_name'];
$most_popular_product_item_qty = $row['total'];

// php query out of stock products from product_info table given qty_in_stock column.
$query = "SELECT * FROM product_info WHERE qty_in_stock = 0";
$result = $dbcnx->query($query);
$out_of_stock_products = $result->num_rows;
// put the out of stock products, followed by its product_item_id in an array
$out_of_stock_products_list = "";
// while ($row = $result->fetch_assoc()){
//     $out_of_stock_products_list .= "<li>".$row['pro_name']." (".$row['id'].")</li>";
// }



?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>SneakerHive ADMIN</title>
    <link rel="icon" href="images/favicon.ico">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles.css">
    <script src="shipping_validation.js"></script>
</head>

<body>
    <div class= "header" id="myTopnav">
        <a class="" href="index.php" class="logo" ><img src = images/LOGO.svg alt="sneakerhive logo">ADMIN</a>
    </div>

    <div class="account-content-body">
        <div class="sidebar">
            <ul>
                <li><a href="admin_page.php"><u>Dashboard</u></a></li>
                <li><a href="admin_newsletter.php">Send Newsletter</a></li>
                <li><a href="admin_products.php">Edit Products</a></li>
                <li><a href="logout.php">Logout</a></li>
            
            </ul>
        </div>
        <div class="login-container signup">
        <h1 class="dashboard-title">Dashboard</h1>
        <div class="dashboard">
    
    <p class="dashboard-item"> Total revenue: $<?php echo number_format($total_revenue,2);?></p>
    <p class="dashboard-item"> Most popular product: <?php echo $most_popular_product_item_name;?></p>
    <p class="dashboard-item"> Quantity sold: <?php echo $most_popular_product_item_qty;?></p>
    <hr class="dashboard-divider">
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Product Name</th>
                <th>Product ID</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['pro_name'] . "</td>";
                echo "<td>" . $row['id'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        <caption>Out of stock products</caption>
    </table>
</div>        
    </div>
    </div>


    <footer>
    <div class = "footer">
</div>
    <div class="copyright">
      <p>&copy; 2023 SneakerHive. All Rights Reserved.</p>
      </div>
    
    </footer>
        

    
</body>
</html>