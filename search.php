<?php
    include 'db_connection.php';
    $con = OpenCon();
    session_start();

    $name = "";
    $manager = 0;
    if (isset($_SESSION["username"])) {
        $name = $_SESSION["username"] ;
        $sql_rule = "SELECT rule FROM `users` WHERE user_name = '$name'";
        $result_rule = $con -> query($sql_rule);
        $result_rule = $result_rule->fetch_assoc();    
        if ($result_rule && isset($result_rule["rule"]) && $result_rule["rule"] == "manager") {
            $manager = 1;
        }
    }

    $search='';
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET['search'])){
            $search = strtolower($_GET['search']);
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocesry Andalus Store</title>
    <link rel="stylesheet" href="style.css">
    <!--BootStrap Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--font awesom link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--css file -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-custom">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- Home -->
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">Home</a>
                        </li>

                        <!-- log out -->
                        <?php 
                        if(!empty($name)) {
                            echo "<li class='nav-item'>";
                            echo "<a class='nav-link' href='log_out.php'>Log out</a>";
                            echo "</li>";
                        } 
                        ?>
                        
                        <!-- log in -->
                        <?php 
                        if(empty($name)) {
                            echo "<li class='nav-item'>";
                            echo "<a class='nav-link' href='login.php'>Log in</a>";
                            echo "</li>";
                        } 
                        ?>

                        <!-- register -->
                        <?php 
                            if(empty($name)) {
                                echo "<li class='nav-item'>";
                                   echo"<a class='nav-link' href='register.php'>Register</a>";
                                echo"</li>";
                            }   
                        ?>

                        <!-- admin page -->
                        <li class="nav-item">
                            <?php
                            if (!empty($manager)) {
                                echo "<a class='nav-link' href='admin_area/index.php'>Admin page</a>";
                            }
                            ?>
                        </li>
                        
                        <!-- shopping cart -->
                        <?php 
                            if(!empty($name)) {
                                echo "<li class='nav-item'>";
                                   echo"<a class='nav-link' href='shoping_cart.php'><i class='fa-solid fa-cart-shopping'></i></a>";
                                echo"</li>";
                            }
                        ?>
                    <!-- search part of the page -->
                    </ul>
                        <!-- search part of the page -->
                    <form class="d-flex ms-auto search-form" method='get' action='search.php'>
                        <div class="input-group">
                            <input class="form-control rounded-pill" type="text" name="search" placeholder="Search for products..." aria-label="Search" id='search'>
                            <button class="btn btn-light rounded-pill" name="submit" type="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    
                            <?php
                            if (!empty($search)) {
                                $search = strtolower($_GET['search']);         
                            }
                            ?>
                        </form>

                </div>
            </div>
        </nav>
        <!-- Second child -->
        <!-- Second child -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Search Results for <?php echo $search; ?></a>
                </li>
        
            </ul>
        </nav>
        <!-- third child -->
        <div class="bg-light">
        </div>

        <!-- fourth child -->
        <div class="row">
            <div class="col-md-12">
                <!-- products -->
                <div class="row">
                    <?php
                            if (!empty($search)) {
                                    //if the query is for the price

                                    if (preg_match('/^(\d+)-(\d+)$/', $search, $matches)) { // This PHP code uses a regular expression (regex) 
                                        // to check if the string stored in the variable $search matches a specific pattern.
                                        // preg_match(pattern, subject, matches)
                                        //pattern: The regular expression pattern you want to search for.
                                        //subject: The string you want to search within.x 
                                        //matches: (Optional) An array where the matched groups will be stored. 
                                        //If this parameter is provided, the function will populate this array with the matched values.
                                        // The preg_match function is used with the regular expression '/^(\d+)-(\d+)$/' 
                                        //to check if the string follows the pattern of having one or more digits, a hyphen, and then one or more digits again.
    
                                        $minPrice = $matches[1];
                                        $maxPrice = $matches[2];
    
                                        $sql="SELECT p.product_name, p.price, p.product_id , CASE WHEN DATEDIFF(p.exp_date,NOW()) BETWEEN 1 AND 13 THEN  '20%'
                                        WHEN DATEDIFF(p.exp_date,NOW()) BETWEEN 14 AND 30 THEN  '10%'
                                        ELSE  '0%' END AS Discount, 
                                        CASE WHEN DATEDIFF(p.exp_date,NOW()) BETWEEN 1 AND 13 THEN  p.price-(20*p.price/100)
                                        WHEN DATEDIFF(p.exp_date,NOW()) BETWEEN 14 AND 30 THEN  p.price-(10*p.price/100)
                                        ELSE   p.price-(0*p.price/100) END AS 'Price After Discount',
                                         p.exp_date, b.brand_name, GROUP_CONCAT(DISTINCT S.nationality) AS nationality,
                                        CASE WHEN COUNT( S.nationality) = COUNT( CASE WHEN LOWER(S.nationality) LIKE '%egypt%' THEN S.nationality END)
                                            AND COUNT( CASE WHEN LOWER(S.nationality) LIKE '%egypt%' THEN S.nationality END) > 0
                                            THEN 'All Egyptian'
                                            ELSE 'Not All Egyptian'
                                        END AS egyptian_status,
                                        COUNT(DISTINCT pc.user_id) AS num_users_purchasing,
                                        COUNT(DISTINCT (CASE WHEN pc.order_date >= NOW() - INTERVAL 24 HOUR THEN pc.user_id END)) AS recent_purchase_count,
                                        p.product_image
                                        FROM brands AS b  
                                        LEFT JOIN 	stakeholding AS K ON K.	brand_id=b.	brand_id
                                        LEFT JOIN shareholders AS S ON S.shareholder_id=K.shareholders_id   
                                        JOIN products AS p ON p.brand_id=b.brand_id
                                        LEFT JOIN purchasing_cart AS pc ON p.product_id = pc.product_id
                                        WHERE (p.price BETWEEN $minPrice AND $maxPrice)AND  DATEDIFF(p.exp_date,NOW()) >0
                                        GROUP BY p.product_id,b.brand_id;";
    
                                    } else {
    
                                        // If the input is not a price range, search by product name or brand name
                                        $sql="SELECT p.product_name, p.price, p.product_id , CASE WHEN DATEDIFF(p.exp_date,NOW()) BETWEEN 1 AND 13 THEN  '20%'
                                        WHEN DATEDIFF(p.exp_date,NOW()) BETWEEN 14 AND 30 THEN  '10%'
                                        ELSE  '0%' END AS Discount, 
                                        CASE WHEN DATEDIFF(p.exp_date,NOW()) BETWEEN 1 AND 13 THEN  p.price-(20*p.price/100)
                                        WHEN DATEDIFF(p.exp_date,NOW()) BETWEEN 14 AND 30 THEN  p.price-(10*p.price/100)
                                        ELSE   p.price-(0*p.price/100) END AS 'Price After Discount',
                                         p.exp_date, b.brand_name, GROUP_CONCAT(DISTINCT S.nationality) AS nationality,
                                        CASE WHEN COUNT( S.nationality) = COUNT( CASE WHEN LOWER(S.nationality) LIKE '%egypt%' THEN S.nationality END)
                                            AND COUNT( CASE WHEN LOWER(S.nationality) LIKE '%egypt%' THEN S.nationality END) > 0
                                            THEN 'All Egyptian'
                                            ELSE 'Not All Egyptian'
                                        END AS egyptian_status,
                                        COUNT(DISTINCT pc.user_id) AS num_users_purchasing,
                                        COUNT(DISTINCT (CASE WHEN pc.order_date >= NOW() - INTERVAL 24 HOUR THEN pc.user_id END)) AS recent_purchase_count,
                                        p.product_image
                                        FROM brands AS b  
                                        LEFT JOIN 	stakeholding AS K ON K.	brand_id=b.	brand_id
                                        LEFT JOIN shareholders AS S ON S.shareholder_id=K.shareholders_id   
                                        JOIN products AS p ON p.brand_id=b.brand_id
                                        LEFT JOIN purchasing_cart AS pc ON p.product_id = pc.product_id
                                        WHERE (LOWER(p.product_name) LIKE '%$search%' OR LOWER(b.brand_name) LIKE '%$search%')AND  DATEDIFF(p.exp_date,NOW()) >0
                                        GROUP BY p.product_id,b.brand_id;";
                                    }
                                    //part showing the data in the product card
                                    $result = mysqli_query($con, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $product_id = $row["product_id"];
                                        $product_name = $row["product_name"];
                                        $product_image = $row["product_image"];
    
                                        echo "<div class='col-md-4 mb-2'>";
                                        echo "<div class='card'>";
                                        echo "<img src='admin_area/uploads/$product_image' class='card-img-top' alt='...'>";
                                        echo "<div class='card-body'>";
                                        echo "<h5 class='card-title'>$product_name</h5>";
                                        if (!empty($name)){
                                            echo "<a href='shoping_cart.php?id=$product_id' class='btn btn-custom'>Add to cart</a> ";
                                        }
                                        echo "<a href='product_details.php?id=$product_id' class='btn btn-custom'>View more</a>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                }
                                                                                    
                    ?>
                </div>
            </div>
            
        <div class="bg-custom p-3 text-center">
            <p>Andalus store</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
            crossorigin="anonymous">
    </script>
</body>
</html>