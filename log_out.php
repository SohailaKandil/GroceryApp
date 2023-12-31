<?php
    include 'db_connection.php';
    $con = OpenCon();
    session_start();

    if (isset($_SESSION["username"])) {
        // Unset the username session variable
        unset($_SESSION["username"]);
        // Redirect to index.php and exit
        header("location: index.php");
        exit();
    }
?>