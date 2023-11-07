<?php
    session_start();
    if (isset($_GET['search'])) {
        $_SESSION['search_result'] = ($_GET['search']);
        header("Location: shop.php");
    } 

?>