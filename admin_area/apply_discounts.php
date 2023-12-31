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

    $sql_discounts = $sql_discounts = "UPDATE products p
    SET discount = CASE
        WHEN DATEDIFF(p.exp_date, NOW()) BETWEEN 1 AND 13 THEN 0.2  
        WHEN DATEDIFF(p.exp_date, NOW()) BETWEEN 14 AND 30 THEN 0.1 
        ELSE p.discount
    END";

    $con->query($sql_discounts);
    header("location: discounts.php")

?>

