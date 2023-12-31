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


    $user_name ="";
    $password = "";
    $address = "";
    $phone = "";
    $error_message ="";
    $success_message = "";
    $rule = "manager";

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user_name = $_POST["username"];
        $password = $_POST["upassword"];
        $address = $_POST["address"];
        $phone = $_POST["phoneNumber"];

        //hash the password to make it secure using default hash function
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        if(empty($user_name) || empty($password) ||  empty($address) || empty($phone) ){
            $error_message = "You need to fill all the fields before submitting";
            
        } else {
            // Check if the user already exists in the database
            $check_user_query = "SELECT * FROM users WHERE user_name = ?";
            $check_stmt = mysqli_stmt_init($con);

            if (mysqli_stmt_prepare($check_stmt, $check_user_query)) {
                mysqli_stmt_bind_param($check_stmt, "s", $user_name);
                mysqli_stmt_execute($check_stmt);
                $result = mysqli_stmt_get_result($check_stmt);

                if (mysqli_num_rows($result) > 0) {
                    // User already exists, show an error message
                    $error_message = "This username is already registered. You can log in.";
                } else {
                    // User does not exist, proceed with registration
                    $sql_insert_user = "INSERT INTO users (address, phone, user_name, user_password , rule) VALUES (?, ?, ?, ? , ?)";
                    $stmt = mysqli_stmt_init($con);

                    if (mysqli_stmt_prepare($stmt, $sql_insert_user)) {
                        mysqli_stmt_bind_param($stmt, "sssss", $address, $phone, $user_name, $password_hash , $rule);
                        mysqli_stmt_execute($stmt);
                        $success_message = "You have successfully created your account";
                        session_start();
                        $_SESSION["username"] = $user_name;
                        header("location: welcome_admin.php");
                        exit();
                    } else {
                        $error_message = "Error in database.";
                    }

                    // Close the statement
                    mysqli_stmt_close($stmt);
                }

                // Close the result set
                mysqli_free_result($result);
            } else {
                $error_message = "Error in statement preparation for user check.";
            }

            // Close the statement
            mysqli_stmt_close($check_stmt);
        }

        // Close the connection
        mysqli_close($con);
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
    <h2 class="text-center">Add admin</h2>
    <?php
        if( !empty($error_message)){
            echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
        }
        else if( !empty($success_message) ){
            echo '<div class="alert alert-success" role="alert">' . $success_message . '</div>';
            header("location: index.php");
            exit();
        }
    ?>

    <div class="container mt-4">
        <form method="post">
            <div class="row">
                <div class="col-sm-12 col-md-6 offset-md-3">
                    <div class="mb-3">
                        <label for="website_signup" class="form-label">User Name *</label>
                        <input type="text" class="form-control" name="username"  required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="password" name="upassword" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address *</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <div class="form-group">
                        <label for="phoneNumber">Phone Number *</label>
                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber"
                            placeholder="Please enter a 11-digit phone number." pattern="[0-9]{11}" required>
                    </div>
                    <br>

                    <button type="submit" class="btn btn-custom w-100">Sign up</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container mt-5">
        <p class="text-center">Already signed up? <a href="login.php">Login Here</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw8/6+PjoY4L2zzpG1uLEZt+QxDX+d8eU3foNkT5wApfY6xnyBuA2aQpUe0yHp"
        crossorigin="anonymous"></script>
</body>

</html>
