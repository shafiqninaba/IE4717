<?php
session_start();
if (isset($_GET['category_filter'])) {
    $_SESSION['category_filter'] = ($_GET['category_filter']);
    var_dump($_SESSION['category_filter']);
}
?>

