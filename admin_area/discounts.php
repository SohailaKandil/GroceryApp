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


  $sql = "SELECT * FROM  products WHERE
    DATEDIFF(exp_date, NOW()) BETWEEN 1 AND 13 
    OR DATEDIFF(exp_date, NOW()) BETWEEN 14 AND 30";


  $result = $con -> query($sql);

  if(!$result){
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
        <h2>List of products that will expire in the comming month</h2>
        <a type="button" class="btn btn-custom" href="index.php">Admin home</a>
        <a type="button" class="btn btn-custom" href="apply_discounts.php">Apply discounts</a> 
        <br>
        
        <table class="table">
          <thead>
              <tr>
                  <th scope="col">product_name</th>
                  <th scope="col">product_price</th>
                  <th scope="col">discount</th>
                  <th scope="col">expiration date</th>
              </tr>
          </thead>

          <tbody>
            <?php
              
              while ($row = $result -> fetch_assoc()){
                $discount = $row['discount'] *100 . "%";
                print_r("
                <tr>
                  <td scope='row'>{$row['product_name']}</td>
                  <td>{$row['price']}</td>
                  <td>{$discount}</td>
                  <td>{$row['exp_date']}</td>
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