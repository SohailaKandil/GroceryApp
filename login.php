<?php
    include ("db_connection.php");
    $con = OpenCon();
    $name = "";
    $password = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $success = 0;
        $name = $_POST["username"];
        $password = $_POST["upassword"];

        $sql_check_credentials = "SELECT * FROM users WHERE user_name = '$name' and user_password = '$password' ";
        $result = $con -> query( $sql_check_credentials);
        if($result){
            $num = mysqli_num_rows($result);
            if($num > 0){
                session_start();
                $_SESSION["username"] = $name;
                $sql_rule = "SELECT rule FROM users WHERE user_name = '$name'";
                $result_rule = $con -> query( $sql_rule );
                $result_rule = $result_rule -> fetch_assoc();
                $rule = $result_rule["rule"];
                if ($rule == "user"){
                    header("location:home.php");
                }
                else if ($rule == "manager"){
                    header("location:admin_area/index.php");
                }
            }
            else{
                echo "wrong username or password";
            }
        }
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
    <h1 class = "text-center">Log in :) </h1>
    <div class= "container mt-5">
        <form action ="login.php" method = "post">

            <div class="mb-3">
                <label for="website_signup" class="form-label">User Name</label>
                <input type="text" class="form-control"
                placeholder = "Enter yor name please" name = "username">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name = "upassword" >
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
    <div class="container mt-5">
        <a href="register.php" class="btn btn-primary">Not signed up? go and make your account now :)</a>
    </div>
  </body>
</html>