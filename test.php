<?php 
//  array of random colors
$main_array = array();
$main_array[] = "blue";
$main_array[] = "green";
$main_array[] = "red";
$main_array[] = NULL;

// $color_array = array("blue", "green", "red", "yellow", "orange", "purple", "pink", "black", "white", "grey");

// echo json encode $color_array but replace [ and ] with ( and )
echo str_replace(array("[", "]"), array("(", ")"), json_encode($main_array));
?>