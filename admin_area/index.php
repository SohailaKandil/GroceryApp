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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
    crossorigin="anonymous">
    <!-- css file -->
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- First child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <h6 class="nav-link"> <?php echo "Welcome  $name" ?> </h6>
                        </li>
                        <li class="nav-item">
                            <div class="button text-center mx-1">
                                <a href="../log_out.php" class="btn btn-primary" ml-6>Log out</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class="button text-center mx-1">
                                <a href="../home.php"  class="btn btn-primary" ml-6>Home page</a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
        <!-- second child -->
        <div class="bg-light">
            <h3 class="text-center p-2">Manage Details</h3>
        </div>


        <!-- third child -->
        <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                <div class="p-3">
                    <a href="#"><img src="../images/one.jpeg" alt="" class="admin_image"></a>
                </div>
                <!-- Buttons -->
                <div class="button text-center mx-1">
                    <a href="products.php" class="btn btn-primary" ml-6>View Products</a>
                </div>

                <div class="button text-center mx-1">
                    <a href="view_orders.php" class="btn btn-primary" ml-6>View orders</a>
                </div>
            </div>
        </div>

        <!-- last child -->
<div class="bg-info p-3 text-center footer">
    <p>Andalus store</p>
</div>
</div>

<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
crossorigin="anonymous"></script>  
</body>
</html>
