<?php
    session_start();

        // search result from GET request
if (isset($_GET['search'])) {
    $_SESSION['search_result'] = ($_GET['search']);
} 
//category filter from GET request
elseif (isset($_GET['category_filter'])) {
    echo "category filter GET REQUEST";
    $_SESSION['category_filter'] = ($_GET['category_filter']);
    $category_filter_query = "";
    foreach($_SESSION['category_filter'] as $category){
        $category_filter_query .= "'$category'";
        // if not the last element, add a comma
        if ($category !== end($_SESSION['category_filter'])){
            $category_filter_query .= ",";
        }
    }
    $_SESSION['category_filter_query'] = $category_filter_query;
}
elseif (isset($_SESSION['category_filter']) && isset($_GET['category_filter']) == null) {
    echo "category filter second";
    unset($_SESSION['category_filter']);
}


header("Location: shop.php");

?>