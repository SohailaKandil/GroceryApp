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

  $sql_view_orders = "SELECT o.order_id , o.ordering_address , o.order_date , o.order_phone , p.product_name ,p.price, p.discount , o.product_id , o.quantity , u.user_name , o.quantity * p.price AS total_order_price
  FROM orders o , products p , users u
  WHERE o.product_id = p.product_id
  AND o.user_id = u.user_id";

  $result_orders = $con -> query($sql_view_orders);

  if(!$result_orders){
    die("Error happened: " . $con -> error);
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Andalus Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .btn-custom {
        background-color: #1359a0;
        color: #fff;
        }
        body {
        font-family: 'Times New Roman', serif;
        font-size: 18px;
    }

    </style>
  </head>

  <body>
    <div class="container my-5">
        <h2>List of Products</h2>
        <a type="button" class="btn btn-custom" href="index.php">Admin Home</a> 
        <br>
        <table class="table">
          <thead>
              <tr>
                  <th scope="col">product name</th>
                  <th scope="col">user_name</th>
                  <th scope="col">order date</th>
                  <th scope="col">User Phone</th>
                  <th scope="col">User address</th>
                  <th scope="col">Total order price</th>
                  <th scope="col">quantity</th>
                  <th scope="col">action</th>
              </tr>
          </thead>

          <tbody>
            <?php
              
              while ($row =  $result_orders -> fetch_assoc()){
                print_r("
                <tr>
                  <td scope='row'>{$row['product_name']}</td>
                  <td>{$row['user_name']}</td>
                  <td>{$row['order_date']}</td>
                  <td>{$row['order_phone']}</td>
                  <td>{$row['ordering_address']}</td>
                  <td>{$row['total_order_price']}</td>
                  <td>{$row['quantity']}</td>
                  <td>
                      <a type='button' class='btn btn-custom' href='deliver_order.php?id={$row['order_id']}'>Order delivered</a>
                  </td>
                </tr>
                ");

              }
            ?>
          </tbody>
      </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>