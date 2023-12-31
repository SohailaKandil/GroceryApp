<?php
    include "db_connection.php" ;
    $con = opencon();
    $user_name ="";
    $password = "";
    $address = "";
    $phone = "";
    $error_message ="";
    $success_message = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user_name = $_POST["username"];
        $password = $_POST["upassword"];
        $address = $_POST["address"];
        $phone = $_POST["phoneNumber"];
        
        do{
            if(empty($user_name) || empty($password) ||  empty($address) || empty($phone) ){
                $error_message = "you need to fill al the fields first before submitting";
                break;
            }
            $sql_insert_user = "INSERT INTO users (address , phone , user_name , user_password , rule)  VALUES ('$address' , '$phone' , '$user_name' , '$password' , 'user');";
            $result_insertion = $con -> query( $sql_insert_user);
            if (!$result_insertion) {
                $error_message = "data not inserted successfully";
                break;
            }

            $user_name ="";
            $password = "";
            $address = "";
            $phone = "";
        }while (false);

        session_start();
        $_SESSION["username"] = $user_name;
        header("location: home.php");
        exit();
        
    }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Andalus shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <h1 class = "text-center">Sign up :)</h1>
    <?php 
        if (!empty($error_message)) {
            echo $error_message;
        }
    ?>
    <div class= "container mt-5">
        <form  method = "post">

            <div class="mb-3">
                <label for="website_signup" class="form-label">User Name</label>
                <input type="text" class="form-control" name = "username">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password *</label>
                <input type="password" class="form-control" id="password" name = "upassword" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address *</label>
                <input type="text" class="form-control" id="address" name = "address" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Phone Number *</label>
                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Please enter a 11-digit phone number." pattern="[0-9]{11}" required>
            </div>
            <br>

            <button type="submit" class="btn btn-primary w-100" > Sign up</button>
        </form>
    </div>
    <div class="container mt-5">
        <a href="login.php" class="btn btn-primary">already signed up? go to the log in page</a>
    </div>
  </body>
</html>