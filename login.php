<?php
    include ("db_connection.php");
    $con = OpenCon();
    $name = "";
    $password = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $success = 0;
        $name = $_POST["username"];
        $password = $_POST["upassword"];

        $sql_check_credentials = "SELECT * FROM users WHERE user_name = '$name'";
        $result = $con -> query( $sql_check_credentials);
        if($result){
            $num = mysqli_num_rows($result);
            if($num > 0){
                $result = $result->fetch_assoc();
                $database_password = $result["user_password"];
                if (password_verify($password , $database_password)){
                    session_start();
                    $_SESSION["username"] = $name;
                    $sql_rule = "SELECT rule FROM users WHERE user_name = '$name'";
                    $result_rule = $con -> query( $sql_rule );
                    $result_rule = $result_rule -> fetch_assoc();
                    $rule = $result_rule["rule"];
                    if ($rule == "user"){
                        header("location:home.php");
                        exit();
                    }
                    else if ($rule == "manager"){
                        header("location:admin_area/index.php");
                        exit();
                    }
                }
                else{
                    echo '<div class="alert alert-danger" role="alert">wrong name or password</div>';
                }
                
            }
            else{
                echo '<div class="alert alert-danger" role="alert">wrong name or password</div>';
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Andalus Store</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .btn-custom {
    background-color: #1359a0;
    color: #fff;
}
        </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Log in</h2>
        <form action="login.php" method="post">
            <div class="row">
                <div class="col-sm-12 col-md-6 offset-md-3">
                    <div class="mb-3">
                        <label for="website_signup" class="form-label">User Name</label>
                        <input type="text" class="form-control" placeholder="Enter your username please"
                            name="username">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="upassword"
                            placeholder="Enter your password please" name="password">
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Login</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container mt-5">
        <p class="text-center">Don't have an account? <a href="register.php">Register Here</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw8/6+PjoY4L2zzpG1uLEZt+QxDX+d8eU3foNkT5wApfY6xnyBuA2aQpUe0yHp"
        crossorigin="anonymous"></script>
</body>

</html>