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
  $sql = "SELECT p.product_name , p.product_id , p.price , p.discount , p.exp_date , GROUP_CONCAT(DISTINCT b.brand_name) AS brand_name , GROUP_CONCAT(DISTINCT s.shareholder_name) AS shareholder_name , GROUP_CONCAT(DISTINCT s.nationality) AS nationality
  FROM products p , brands b , stakeholding st , shareholders s 
  WHERE 
  p.brand_id = b.brand_id AND
  b.brand_id = st.brand_id AND
  st.shareholders_id = s.shareholder_id
  GROUP BY p.product_id";


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
        <h2>List of products</h2>
        <a type="button" class="btn btn-custom" href="index.php">Admin home</a>
        <a type="button" class="btn btn-custom" href="add_product_page.php">Add product</a> 
        <br>
        
        <table class="table">
          <thead>
              <tr>
                  <th scope="col">product_name</th>
                  <th scope="col">product_price</th>
                  <th scope="col">discount</th>
                  <th scope="col">brand name</th>
                  <th scope="col">expiration date</th>
                  <th scope="col">shareholders names</th>
                  <th scope="col">shareholders nationalities</th>
                  <th scope="col">action</th>
              </tr>
          </thead>

          <tbody>
            <?php
              
              while ($row = $result -> fetch_assoc()){
                print_r("
                <tr>
                  <td scope='row'>{$row['product_name']}</td>
                  <td>{$row['price']}</td>
                  <td>{$row['discount']}</td>
                  <td>{$row['brand_name']}</td>
                  <td>{$row['exp_date']}</td>
                  <td>{$row['shareholder_name']}</td>
                  <td>{$row['nationality']}</td>
                  <td>
                      <a type='button' class='btn btn-custom' href='delete_product.php?id={$row['product_id']}'>Delete</a>
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






















<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
crossorigin="anonymous"></script>  
</body>
</html>