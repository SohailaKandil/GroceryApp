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

    $product_name = "";
    $product_price_str = "";
    $product_discount_str = "0";
    $product_amount_str = "";
    $product_exp_date = "";

    $brand_name = "";
    $shareholder_name = "";
    $image_path = "";
    
    $error_message = "";
    $success_message = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $product_name = $_POST["product_name"];
        $product_price_str = $_POST["product_price"];
        $product_discount_str = $_POST["product_discount"];
        $product_amount_str = $_POST["amount"];
        $product_exp_date = $_POST["product_exp_date"];
        $brand_name = $_POST['brand_name'];
        $shareholder_name = $_POST['shareholder_name'];

        $product_price = (float)$product_price_str;
        $product_discount = (float)$product_discount_str;
        $product_amount = (float)$product_amount_str;
        // Check if the image is uploaded successfully
        if (isset ($_FILES ["image"])){
            $image_path = $_FILES ["image"];
            $image_name = $_FILES ["image"]["name"];
            $image_size = $_FILES ["image"]["size"];
            $image_tmp_name = $_FILES ["image"]["tmp_name"];
            $image_error = $_FILES ["image"]["error"];
            
            if($image_error == 0){
                if ($image_size < 125000){
                    $img_ex = pathinfo($image_name  , PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $new_img_name = uniqid("IMG-" , true) .".". $img_ex_lc;
                    $img_upload_path = "uploads/" . $new_img_name;
                    move_uploaded_file($image_tmp_name , $img_upload_path);        
                }
            }
            

        } else {
            echo "Error uploading file.";
        }
        

        do{
            
            if(empty($product_name) || empty($product_price_str) ||  empty($product_exp_date) || empty($brand_name)  || empty($image_path) ||empty($shareholder_name) || empty($product_amount_str)){
                $error_message = "you need to fill al the fields first before submitting";
                break;
            }
            
            $sql_brand_id = "SELECT brand_id FROM brands WHERE brand_name = '$brand_name'";
            $brand_id = $con -> query($sql_brand_id);
            if (!$brand_id) {
                die("Error happened: " . $con->error);
            }  
    
            
            $brand_id = $brand_id->fetch_assoc();
            $brand_id = $brand_id["brand_id"];
            $sql_insert = "INSERT INTO products (product_name , price , product_image , exp_date , discount ,brand_id , amount)  VALUES ('$product_name' , '$product_price' , '$new_img_name' ,'$product_exp_date' , '$product_discount' , '$brand_id' , '$product_amount'); " ;
            $result_insertion = $con -> query( $sql_insert );
            if (!$result_insertion) {
                $error_message = "data not inserted successfully";
                break;
            }

            $sql_shareholder_id = "SELECT shareholder_id FROM shareholders WHERE shareholder_name = '$shareholder_name'";
            $shareholder_id = $con -> query($sql_shareholder_id);
            if (!$shareholder_id) {
                die("Error happened: " . $con->error);
            } 
            $shareholder_id = $shareholder_id->fetch_assoc();
            $shareholder_id = $shareholder_id["shareholder_id"];
            $stakeholding_insert = "INSERT IGNORE INTO stakeholding (shareholders_id, brand_id) VALUES ('$shareholder_id' , '$brand_id');";
            $result_insertion_stakeholding = $con -> query($stakeholding_insert);
            if (!$result_insertion) {
                $error_message = "data not inserted successfully";
                break;
            }
            

            $product_name = "";
            $product_price_str = "";
            $product_discount_str = "0";
            $product_amount_str = "";
            $product_exp_date = "";

            $brand_name = "";
            $shareholder_name = "";
            $image_path = "";
            $product_price = (float)$product_price_str;
            $product_discount = (float)$product_discount_str;
            $product_amount = (float)$product_amount_str;

            //inserting the product in the database
            $success_message = "product added successfuly"; 

        }while (false);
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <title>AL andalus shop</title>
</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
    
    <div class="col-md-8">
    <h2> Add a new product </h2>

    <?php
    if( !empty($error_message)){
        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
    }
    else if( !empty($success_message) ){
        echo '<div class="alert alert-success" role="alert">' . $success_message . '</div>';
    }
    ?>

    <br>

      <form method = "post" enctype = "multipart/form-data">
        <div class="form-group">
          <label for="username" class="font-weight-bold">product name</label>
          <input type="text" class="form-control" id="username" placeholder="Enter product name" name = "product_name" value = "<?php echo $product_name; ?>">
        </div>
  
        <div class="form-group">
          <label for="price" class="font-weight-bold">product price</label>
          <input type="text" class="form-control" id="price" placeholder="Enter product price in egyptian pounds" name = "product_price" value = "<?php echo $product_price_str; ?>">
        </div>

        <div class="form-group">
          <label for="discount" class="font-weight-bold">discount</label>
          <input type="text" class="form-control" id="discount" placeholder="Enter the discount value" name = "product_discount"  value = "<?php echo $product_discount_str; ?>">
        </div>

        <div class="form-group">
          <label for="amount" class="font-weight-bold">Amount of product in stock</label>
          <input type="text" class="form-control" id="amount" placeholder="Enter Amount of product in stock" name = "amount" value = "<?php echo $product_amount_str; ?>">
        </div>

        <div class="form-group">
          <label for="productDate" class="font-weight-bold">Product Expiry Date</label>
          <input type="date" class="form-control" id="productDate" placeholder="Select expiry date" name = "product_exp_date" value = "<?php echo $product_exp_date; ?>">
        </div>

        <!-- Brand names dropdown -->
        <div class="form-group">
            <label class="font-weight-bold">Brand Name</label>

            <fieldset class="form-group">
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Select:</legend>
                    <div class="col-sm-10">
                        <?php 
                        $sql_brand = "SELECT DISTINCT brand_name FROM brands";
        
                        $result_brand = $con->query($sql_brand);
        
                        if (!$result_brand) {
                            die("Error happened: " . $con->error);
                        }

                        echo "<select class='form-select' name='brand_name' aria-label=''>";
                        echo "<option selected>Select a brand</option>";
                        
                        while ($row_brand = $result_brand->fetch_assoc()) {
                            $brand_name = $row_brand["brand_name"];
                            echo "<option value='$brand_name'>$brand_name</option>";    
                        }

                        echo "</select>";
                        ?>
                    </div>
                </div>
            </fieldset>
        </div>

        <!-- Shareholder names dropdown -->
        <div class="form-group">
            <label class="font-weight-bold">shareholder name</label>

            <fieldset class="form-group">
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Select:</legend>
                    <div class="col-sm-10">
                        <?php 

                        $sql_shareholder_name = "SELECT DISTINCT shareholder_name FROM shareholders";
                        $result_shareholder_name = $con->query($sql_shareholder_name);
        
                        if (!$result_shareholder_name) {
                            die("Error happened: " . $con->error);
                        }

                        echo "<select class='form-select' name='shareholder_name' aria-label=''>";
                        echo "<option selected>Select a name of shareholder</option>";
                        
                        while ($row_shareholder_name = $result_shareholder_name->fetch_assoc()) {
                            $shareholder_name = $row_shareholder_name["shareholder_name"];
                            echo "<option value='$shareholder_name'>$shareholder_name</option>";    
                        }

                        echo "</select>";
                        ?>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="form-group">
          <label for="imageUpload" class="font-weight-bold">Select Image</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="imageUpload" name = "image" accept=".jpg, .jpeg, .png">
            <label class="custom-file-label" for="imageUpload">Choose file</label>
          </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a type="button" class="btn btn-primary" href="products.php">Back</a>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>






