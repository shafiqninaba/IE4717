<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $category = $_POST['category'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $gender = $_POST['gender'];
    $stock = $_POST['stock'];
    $image = $_POST['image'];

    update_product($id, $category, $name, $price, $description, $gender, $stock, $image);
}

function update_product($id, $category, $name, $price, $description, $gender, $stock, $image) {
    include 'dbconnect.php';
    $id = $dbcnx->real_escape_string($id);
    $category = $dbcnx->real_escape_string($category);
    $name = $dbcnx->real_escape_string($name);
    $price = $dbcnx->real_escape_string($price);
    $description = $dbcnx->real_escape_string($description);
    $gender = $dbcnx->real_escape_string($gender);
    $stock = $dbcnx->real_escape_string($stock);
    $image = $dbcnx->real_escape_string($image);

    $sql = "SELECT * FROM product_info WHERE id=$id";
    $result = $dbcnx->query($sql);

    if ($result->num_rows > 0) {
        // product exists, update it
        $sql = "UPDATE product_info SET category='$category', pro_name='$name', price='$price', description='$description', gender='$gender', qty_in_stock='$stock', product_image='$image' WHERE id=$id";
        if ($dbcnx->query($sql) === TRUE) {
            echo "<script>alert('Record updated successfully'); window.location = 'admin_products.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . $dbcnx->error . "'); window.location = 'admin_products.php';</script>";
        }
    } else {
        // product does not exist, insert it
        $sql = "INSERT INTO product_info (id, category, pro_name, price, description, gender, qty_in_stock, product_image) VALUES ('$id', '$category', '$name', '$price', '$description', '$gender', '$stock', '$image')";
        if ($dbcnx->query($sql) === TRUE) {
            echo "<script>alert('Record inserted successfully'); window.location = 'admin_products.php';</script>";
        } else {
            echo "<script>alert('Error inserting record: " . $dbcnx->error . "'); window.location = 'admin_products.php';</script>";
        }
    }

    $dbcnx->close();
}
?>