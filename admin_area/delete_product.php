<?php 
    include ("../db_connection.php");
    $con = OpenCon();
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location: ../index.php");
        exit(); 
    }
    $name = $_SESSION["username"] ;
  
    $sql_rule = "SELECT rule FROM `users` WHERE user_name = '$name'";
    $result_rule = $con -> query($sql_rule);
    $result_rule = $result_rule->fetch_assoc();
    if ($result_rule["rule"] == "user") {
        header("location: ../home.php");
        exit(); 
    }

    $product_id = "";
    if(isset($_GET["id"])){
        $product_id = $_GET["id"];
    }
    else{
        header("location: products.php");
        exit();
    }

    // Delete from orders
    $sql_delete_orders = "DELETE IGNORE FROM orders WHERE product_id = $product_id;";
    $result_delete_orders = $con->query($sql_delete_orders);

    // Delete from purchasing_cart
    $sql_delete_purchasing_cart = "DELETE IGNORE FROM purchasing_cart WHERE product_id = $product_id;";
    $result_delete_purchasing_cart = $con->query($sql_delete_purchasing_cart);

    // Delete from shopping_cart
    $sql_delete_shopping_cart = "DELETE IGNORE FROM shopping_cart WHERE product_id = $product_id;";
    $result_delete_shopping_cart = $con->query($sql_delete_shopping_cart);

    // Delete from products
    $sql_delete_product = "DELETE FROM products WHERE product_id = $product_id;";
    $result_delete_product = $con->query($sql_delete_product);


    // Redirect after deletion
    header("location: products.php");
    exit();
?>