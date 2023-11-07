<?php
    include "dbconnect.php";
    if (isset($_GET['search'])) {
        $search = ($_GET['search']);
        $sql = "SELECT * FROM product_info WHERE name LIKE '%$search%'";
        $_SESSION['search_result'] = $dbcnx->query($sql);
        
        header("Location: shop.php");
        exit;
    } else{

        echo "<script>alert('No items matched your search. Try some different keywords.'); window.location.href='shop.php';</script>";
        
    }

?>