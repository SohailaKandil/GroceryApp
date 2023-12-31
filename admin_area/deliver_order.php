<?php 
    include ("../db_connection.php");
    $con = OpenCon();
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location: ../index.php");
        exit(); // Make sure to exit after redirecting
    }
    $name = $_SESSION["username"] ;
  
    $sql_rule = "SELECT rule FROM `users` WHERE user_name = '$name'";
    $result_rule = $con -> query($sql_rule);
    $result_rule = $result_rule->fetch_assoc();
    if ($result_rule["rule"] == "user") {
        header("location: ../home.php");
        exit(); // Make sure to exit after redirecting
    }

    $order_id = "";
    if(isset($_GET["id"])){
        $order_id = $_GET["id"];
    }
    $sql_insert_purchasing = "INSERT IGNORE INTO purchasing_cart (ordering_address , order_date , order_id , order_phone , product_id , quantity , user_id)
    SELECT ordering_address , order_date , order_id , order_phone , product_id , quantity , user_id
    FROM orders
    WHERE order_id = $order_id;";
    $result_delete_order = $con -> query($sql_insert_purchasing);

    $sql_delete_order ="DELETE FROM orders WHERE order_id = $order_id;";
    $result_delete_order = $con -> query($sql_delete_order);
    header("location: view_orders.php?");
    exit;
?>