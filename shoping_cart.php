<?php
    include 'db_connection.php';
    $con = OpenCon();
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location: index.php");
        exit(); // Make sure to exit after redirecting
    }
    $name = $_SESSION["username"] ;

    $product_id = "";
    if(isset($_GET["id"])){
        $product_id = $_GET["id"];
    }
    if(!empty($product_id)){
        $sql_get_user_id = "SELECT user_id FROM users WHERE user_name = '$name'";
        $result_user_id = $con -> query($sql_get_user_id);
        $user_id = $result_user_id -> fetch_assoc();
        $user_id = $user_id["user_id"];

        $sql_insert_cart = "INSERT IGNORE INTO shopping_cart (product_id , user_id) VALUES ($product_id,$user_id);";
        $result_insert_cart = $con -> query($sql_insert_cart);
    }

    $sql_view_cart = "SELECT s.product_id , u.user_name , p.product_name , p.price , p.discount , p.amount , ((p.price)-(p.price * p.discount)) AS price_after_discount
        FROM shopping_cart s, products p , users u
        WHERE s.product_id = p.product_id
        AND s.user_id = u.user_id
        AND u.user_name = '$name'";
    $result_view_cart = $con -> query($sql_view_cart);
    $num_products = 0;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Times New Roman', serif;
            font-size: 18px;

        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        .cart-container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .checkout-btn {
            background-color: #1359a0;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .home-link {
            position: absolute;
            left: 10px;
            top: 10px;
            color: #fff;
            text-decoration: none;
        }

        .welcome-message {
            position: absolute;
            top: 40px;
            left: 10px;
            color: #fff;
        }
    </style>
</head>
<body>

    <header>
        <h1>Shopping Cart</h1>
        <a class="home-link" href="home.php">Home</a>
        <p class="welcome-message">Welcome <?php echo $name;?></p>
    </header>
    

    <div class="container cart-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Final price</th>
                    <th>Available amount</th>
                    <th>Buy</th>
                    <th>View product</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <!-- rows of the table in purchasing cart -->
                <?php
                    while ($row_cart = $result_view_cart->fetch_assoc()) {
                        $num_products +=1;
                        $product_id = $row_cart["product_id"];
                        $product_name = $row_cart["product_name"];
                        $product_price = $row_cart["price"];
                        $product_discount = $row_cart["discount"] *100 . "%";
                        $product_amount = $row_cart["amount"];
                        $product_price_after = $row_cart["price_after_discount"];

                        echo "<tr>";
                            echo"<td>$product_name</td>";
                            echo"<td>$product_price . LE</td>";
                            echo"<td>$product_discount</td>";
                            echo"<td>$product_price_after</td>";
                            echo"<td>$product_amount</td>";
                            echo "<td><a class='btn btn-light checkout-btn' href='buy_form.php?id=$product_id'>Buy</a></td>";
                            echo "<td><a class='btn btn-light checkout-btn' href='product_details.php?id=$product_id'>View</a></td>";
                            echo "<td><a class='btn btn-light checkout-btn' href='delete_from_cart.php?id=$product_id'>Remove</a></td>";
                        echo"</tr>";
                    }        
                ?>
            </tbody>
        </table>

        <div class="text-right">
            <p>Number of products in cart: <?php print_r($num_products);?></p>
        </div>

        
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
