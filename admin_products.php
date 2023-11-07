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

function get_all_products() {
    include 'dbconnect.php';
    // Define the query
    $sql = "SELECT * FROM product_info";

    // Execute the query
    $result = $dbcnx->query($sql);
    
    // Check the result
    if ($result->num_rows > 0) {
        // Fetch all rows into an array
        return $result;
    } else {
        return false;
    }
}
function get_product_by_id($id) {
    include 'dbconnect.php';
    // Define the query
    $sql = "SELECT * FROM product_info WHERE id = $id";

    // Execute the query
    $result = $dbcnx->query($sql);

    // Check the result
    if ($result->num_rows > 0) {
        // Fetch the row into an array
        return $result->fetch_assoc();
    } else {
        return false;
    }
}
if (isset($_GET['id'])) {
    $product = get_product_by_id($_GET['id']);
}
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
                <li><a href="admin_page.php">Dashboard</a></li>
                <li><a href="admin_newsletter.php">Send Newsletter</a></li>
                <li><a href="admin_products.php"><u>Edit Products</u></a></li>
                <li><a href="logout.php">Logout</a></li>
            
            </ul>
        </div>
        <div class="login-container signup">
        <h1 class="dashboard-title">Products</h1>
        <div class="dashboard">
        <div class="product-management">
    <h2>Edit Product</h2>
    <form action="edit_product.php" method="post">
        <label for="id">ID:</label>
        <input type="text" id="admin_product_id" name="id" value="<?php echo isset($product) ? $product['id'] : ''; ?>">
        <label for="category">Category:</label>
        <input type="text" id="admin_product_category" name="category" value="<?php echo isset($product) ? $product['category'] : ''; ?>">
        <label for="name">Name:</label>
        <input type="text" id="admin_product_name" name="name" value="<?php echo isset($product) ? $product['pro_name'] : ''; ?>">
        <label for="price">Price:</label>
        <input type="text" id="admin_product_price" name="price" value="<?php echo isset($product) ? $product['price'] : ''; ?>">
        <label for="description">Description:</label>
        <input type="text" id="admin_product_description" name="description" value="<?php echo isset($product) ? $product['description'] : ''; ?>">
        <label for="gender">Gender:</label>
        <input type="text" id="admin_product_gender" name="gender" value="<?php echo isset($product) ? $product['gender'] : ''; ?>">
        <label for="stock">Stock:</label>
        <input type="text" id="admin_product_stock" name="stock" value="<?php echo isset($product) ? $product['qty_in_stock'] : ''; ?>">
        <label for="image">Image Link:</label>
        <input type="text" id="admin_product_image" name="image" value="<?php echo isset($product) ? $product['product_image'] : ''; ?>">
        <span class="admin_product">
        <input  type="submit" value="Edit Product">
        </span>
    </form>
    <h2>Existing Products</h2>
    <div class="scrollable-table">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Edit</th>
            <th>Remove</th>
        </tr>
        <?php
        $products = get_all_products();
        while ($row = $products->fetch_assoc()) {
            $class = ($row['qty_in_stock'] == 0) ? 'out-of-stock' : '';
            echo "<tr class='$class'>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['pro_name'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['qty_in_stock'] . "</td>";
            echo "<td><a href='admin_products.php?id=" . $row['id'] . "'>Edit</a></td>";
            echo "<td><a href='remove_product.php?id=" . $row['id'] . "'>Remove</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    </div>
</div>
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