<?php
session_start();
    if(isset($_GET['type1'])){
        $_SESSION['trainers'] = $_GET['type1'];
    }else{
        $_SESSION['trainers'] = "";
    }

    if(isset($_GET['type2'])){
        $_SESSION['runningshoes'] = $_GET['type2'];
    }else{
        $_SESSION['runningshoes'] = "";
    }

    if(isset($_GET['type3'])){
        $_SESSION['hitops'] = $_GET['type3'];
    }else{
        $_SESSION['hitops'] = "";
    }

    if(isset($_GET['type4'])){
        $_SESSION['canvas'] = $_GET['type4'];
    }else{
        $_SESSION['canvas'] = "";
    }

    if(isset($_GET['type5'])){
        $_SESSION['flipflopssandals'] = $_GET['type5'];
    }else{
        $_SESSION['flipflopssandals'] = "";
    }
    // var_dump($_SESSION);    
    header("Location: shop.php");
?>

