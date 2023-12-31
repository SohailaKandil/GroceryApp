<?php 
    include 'db_connection.php';
    $con = OpenCon();
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location: index.php");
        exit(); // Make sure to exit after redirecting
    }
    $name = $_SESSION["username"] ;
    $sql_get_user_id = "SELECT user_id FROM users WHERE user_name = '$name'";
    $result_user_id = $con -> query($sql_get_user_id);
    $user_id = $result_user_id -> fetch_assoc();
    $user_id = $user_id["user_id"];

    $product_id = "";
    if(isset($_GET["id"])){
        $product_id = $_GET["id"];
    }
    $sql_delete_cart ="DELETE FROM shopping_cart
    WHERE $user_id = 1 AND product_id = $product_id;";
    $result_delete = $con -> query($sql_delete_cart);
    header("location: home.php?");
    exit;
?>