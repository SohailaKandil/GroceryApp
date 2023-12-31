<?php
    include 'db_connection.php';
    $con = OpenCon();
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location: ../index.php");
        exit(); // Make sure to exit after redirecting
    }
    $name = $_SESSION["username"] ;

    $product_id = $_GET["id"];

    $sql_get_product = "SELECT price , product_image , product_name , discount , amount FROM `products` WHERE product_id = $product_id";
    $result_get_product = $con ->query($sql_get_product);
    $result_get_product = $result_get_product -> fetch_assoc();

    $price = $result_get_product["price"];
    $product_name = $result_get_product["product_name"];
    $product_image = $result_get_product["product_image"];
    $amount = $result_get_product["amount"];
    $discount = $result_get_product["discount"];
    $price = $price * (1- $discount);

    if($amount == 0){
        header("Location: sorry_no_product.php");
        exit();
    }

    $order_address = "";
    $order_address = "";
    $error_message = "";
    $success_message = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $order_address = $_POST["address"];
        $order_phone = $_POST["phone"];
        $quantity = $_POST["quantity"];

        if(empty($order_address) || empty($order_address)){
            $error_message = "you need to fill al the fields first before submitting";
        }
        else{
            $success_message = "You have successfully purchased the product";
            $sql_get_user_id = "SELECT user_id FROM users WHERE user_name = '$name'";
            $result_user_id = $con -> query($sql_get_user_id);
            $user_id = $result_user_id -> fetch_assoc();
            $user_id = $user_id["user_id"];
    
            $sql_insert_order = "INSERT INTO orders (ordering_address , order_phone , product_id , quantity , user_id) VALUES ('$order_address' , '$order_phone' , $product_id , $quantity , $user_id)";

            if($result_insert_order = $con -> query($sql_insert_order)){
            }else{
                $error_message = "there was an error in adding your data";
            }

            $sql_delete_shoping_cart = "DELETE IGNORE FROM shopping_cart
            WHERE product_id = $product_id AND user_id = $user_id";
            $result_delete_cart = $con -> query($sql_delete_shoping_cart);
        }
    }
    
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Product Order Form</title>
    <style>
        .product-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007BFF; /* Bootstrap Blue */
            margin-top: 20px; /* Adjust this value as needed to lower the element */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Home Page Link at the Top -->
    <div class="text-center mb-3">
        <a href="home.php" class="btn btn-secondary">Back to Home</a>
    </div>

    <h2 class="text-center mb-4">Product Order Form</h2>

    <!-- Product Information (outside the form) -->
    <div class="row">
        <div class="col-md-6">
            <p class="product-name"><?php echo $product_name; ?></p>
        </div>
        <div class="col-md-6">
            <img src=<?php print_r("admin_area/uploads/" .$product_image);?> alt=<?php print_r($product_name);?> class="img-fluid">
        </div>
    </div>

    <form id="orderForm" method="post">
        <!-- Quantity Selection -->
        <div class="form-group">
            <label for="quantity">Select Quantity:</label>
            <select class="form-control" id="quantity" name="quantity" onchange="calculatePrice()">
                <?php 
                    for ($i = 1; $i <= $amount; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                ?>
            </select>
        </div>

        <!-- Calculated Price Display -->
        <div class="form-group">
            <label for="calculatedPrice">Calculated Price:</label>
            <input type="text" class="form-control" id="calculatedPrice" readonly>
        </div>

        <!-- Shipping Information -->
        <div class="form-group">
            <label for="address">Shipping Address:</label>
            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your shipping address"></textarea>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
        </div>

        <?php
            if (!empty($error_message)) {
                echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
            } else if (!empty($success_message)) {
                echo '<div class="alert alert-success" role="alert">' . $success_message . '</div>';
            }
        ?>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
    function calculatePrice() {
        // Get the selected quantity
        var quantity = document.getElementById("quantity").value;

        var productPrice = <?php print_r($price);?>;

        // Calculate the total price
        var totalPrice = quantity * productPrice;

        // Display the calculated price in the input field
        document.getElementById("calculatedPrice").value = "$" + totalPrice.toFixed(2);
    }
</script>

</body>
</html>
