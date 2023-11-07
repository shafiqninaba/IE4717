<?php
    session_start();

        // search result from GET request
if (isset($_GET['search'])) {
    $_SESSION['search_result'] = ($_GET['search']);
} 
//category filter from GET request
if (isset($_GET['category_filter'])) {
    
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

header("Location: shop.php");

?>