<?php
    include ("db_connection.php");
    $con = OpenCon();
    $product_id = "";
    if(isset($_GET["id"])){
        $product_id = $_GET["id"];
    }else{
        header("location: home.php");
    }

    $sql_product_details = "SELECT p.product_id , p.product_name , b.brand_name , p.product_image , p.price , p.discount , p.amount , p.exp_date , COUNT(pc.product_id) AS number_purchasing
    FROM products p , brands b , purchasing_cart pc
    WHERE p.brand_id = b.brand_id AND p.product_id = pc.product_id
    AND p.product_id = $product_id;";

    $sql_last_24 = "SELECT COUNT(pc.product_id) AS num_pur_last_24
    FROM purchasing_cart pc
    WHERE pc.product_id = $product_id
    AND pc.order_date >= DATE_SUB(NOW(), INTERVAL 24 HOUR);";

    $sql_boycot = "SELECT DISTINCT p.product_image , p.product_name , p.product_id ,GROUP_CONCAT(DISTINCT s.nationality) AS nationalities,
    CASE 
        WHEN SUM(s.nationality NOT IN ('egypt', 'algeria', 'morocco', 'jordan', 'yemen', 'pakistan', 'palestine', 'malaysia', 'brazil')) = 0 THEN 0
        ELSE 1
    END AS boycott
    FROM products p , brands b , stakeholding st  ,shareholders s
        WHERE p.brand_id = b.brand_id
        AND b.brand_id = st.brand_id
        AND st.shareholders_id = s.shareholder_id
        AND product_id = $product_id";

    $result_product_details = $con ->query($sql_product_details);
    $result = $result_product_details -> fetch_assoc();
    $result_product_last_24 = $con ->query($sql_last_24);
    $result_last_24 = $result_product_last_24 -> fetch_assoc();

    $message_for_boycott ="";
    $result_is_boycot = $con ->query($sql_boycot);
    $result_is_boycot = $result_is_boycot -> fetch_assoc();
    $result_is_boycot = $result_is_boycot ["boycott"];
    if($result_is_boycot == 0){
        $message_for_boycott = "Not a Boycott product";
    }
    else if($result_is_boycot == 1){
        $message_for_boycott = "a Boycott product";
    }

    $product_name = $result["product_name"];
    $product_price = $result["price"];
    $product_quantity = $result["amount"];
    $product_discount = $result["discount"];
    $product_image = $result["product_image"];
    $product_exp_date = $result["exp_date"];
    $brand_name = $result["brand_name"];
    $num_purchasing = $result["number_purchasing"];
    $num_purchasing_last_24 = $result_last_24["num_pur_last_24"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product Information Template</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Image -->
            <img src= '<?php echo  "admin_area/uploads/" . $product_image ; ?>' class="img-fluid" alt= <?php echo $product_name?>>
        </div>
        <div class="col-md-6">
            <!-- Information -->
            <h2><?php echo $product_name?></h2>
            <ul>            
                <li><strong>Brand:</strong> <?php echo $brand_name?></li>
                <li><strong>Price:</strong> <?php echo $product_price?> </li>
                <li><strong>Discount:</strong> <?php echo $product_discount *100 . "%"?></li>
                <li><strong>expiration date:</strong> <?php echo $product_exp_date?></li>
                <li><strong>Amount available:</strong> <?php echo $product_quantity?></li>
                <li><strong>Customers purchasing this product:</strong> <?php echo $num_purchasing?></li>
                <li><strong>Customers purchasing this product in the last 24 hours:</strong> <?php echo $num_purchasing_last_24?></li>
                <li><?php echo $message_for_boycott?></li>
            </ul>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js (Optional) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>

