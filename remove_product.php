<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    remove_product($id);
}

function remove_product($id) {
    include 'dbconnect.php';
    $id = $dbcnx->real_escape_string($id);

    $sql = "DELETE FROM product_info WHERE id=$id";
    if ($dbcnx->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location = 'admin_products.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $dbcnx->error . "'); window.location = 'admin_products.php';</script>";
    }
    $dbcnx->close();
}
?>