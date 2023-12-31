<?php
    include 'db_connection.php';
    $con = OpenCon();
    session_start();

    $name = "";
    $manager = 0;
    if (isset($_SESSION["username"])) {
        $name = $_SESSION["username"];
        $sql_rule = "SELECT rule FROM `users` WHERE user_name = '$name'";
        $result_rule = $con -> query($sql_rule);
        $result_rule = $result_rule->fetch_assoc();    
        if ($result_rule && isset($result_rule["rule"]) && $result_rule["rule"] == "manager") {
            $manager = 1;
        }
    }


    $sql_ranges = "SELECT MIN(price) , MAX(price)
    FROM (SELECT
        price,
        FLOOR(price / 10) * 10 AS range_start
      FROM
        products
          )sub
    GROUP BY range_start
    ORDER BY range_start;";
    $result_ranges = $con -> query($sql_ranges);

    $sql_brands = "SELECT DISTINCT(brand_name) FROM brands";
    $result_brands = $con -> query($sql_brands);

    $sql_nat = "SELECT DISTINCT(nationality) FROM shareholders";
    $result_nat = $con -> query($sql_nat);


    $price_range_filter = $_GET['priceRange'];
    $brand_filter = $_GET['brandName'];
    $nat_filter = $_GET['brandNationality'];
    

    if (preg_match('/^(\d+) - (\d+)$/', $price_range_filter, $matches)) {
        $minPrice = $matches[1];
        $maxPrice = $matches[2];
    } else {
        // Handle the case when the pattern doesn't match
        // For example, set default values or display an error message
        $minPrice = "";
        $maxPrice = "";
    }
    $sql_filter = "";  
    $sql_filter = "SELECT DISTINCT p.product_image , p.product_name , p.product_id FROM products p , brands b , stakeholding st  ,shareholders s
    WHERE p.brand_id = b.brand_id
    AND b.brand_id = st.brand_id
    AND st.shareholders_id = s.shareholder_id";

    
    if(!empty($minPrice)  && !empty($maxPrice)) {
        $sql_filter .= " AND p.price BETWEEN $minPrice AND $maxPrice";  
    }

    if($brand_filter != "brandName") {
        $sql_filter .= " AND b.brand_name = '$brand_filter'";  
    }

    if($nat_filter != "brandNationality") {
        $sql_filter .= " AND s.nationality IN('$nat_filter')";
    }

    $result_filter = $con -> query($sql_filter);

      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Andalus Store</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg navbar-light bg-custom">
        <div class="container-fluid">
            <br>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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

                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>

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

                <li class="nav-item">
                    <?php
                    if (isset($_GET["no_boycott"])) {
                        echo "<span class='nav-link'>No boycott products</span>";
                    }
                    ?>
                </li>
            </ul>

            <!-- search part of the page ************************************** -->
            <form class="d-flex ms-auto search-form" method='get' action='search.php'>
                        <div class="input-group">
                            <input class="form-control rounded-pill" type="text" name="search" placeholder="Search for products..." aria-label="Search" id='search'>
                            <button class="btn btn-light rounded-pill" name="submit" type="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
            <!-- search part of the page ************************************** -->


                
        </div>
    </nav>

        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <?php 
                    if (!empty($name)){
                        $message = "Welcome " . $name;
                        echo "<li class='nav-item'>";
                        echo "<span class='nav-link'>$message</span>";
                        echo "</li>";
                    }
                ?>
            </ul>
        </nav>

        <div class="bg-light">
            <h3 class="text-center">Andalus Store </h3>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <?php
                        while ($row = $result_filter->fetch_assoc()) {
                            $product_id = $row["product_id"];
                            $product_name = $row["product_name"];
                            $product_image = $row["product_image"];

                            echo "<div class='col-md-4 mb-2'>";
                            echo "<div class='card'>";
                            echo "<img src='admin_area/uploads/$product_image' class='card-img-top' alt='...'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>$product_name</h5>";
                            if(!empty($name)){
                                echo "<a href='shoping_cart.php?id=$product_id' class='btn btn-custom'>Add to cart</a> ";
                            }    
                            echo "<a href='product_details.php?id=$product_id' class='btn btn-custom'>View more</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>


                <!-- filter part of the page ************************************** -->
               
    <div class="sidebar collapsed" id="sidebar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        
        <form class="" method='get' action='filter.php'>
            <h5>Filter</h5>
            <!-- No boycott-->
            <a href="home.php?no_boycott=1" class="btn btn-light">Remove All boycott products</a>

            <!-- price filter ************************************** -->
            <div class="mb-2">
                <label for="priceRange" class="form-label text-light">Price Range:</label>
                <select class="form-select" id="priceRange" name="priceRange">
                    <option value="priceRange">Select Price Range </option>
                    <?php 
                    while ($row = $result_ranges->fetch_assoc()) {
                        $min = $row["MIN(price)"];
                        $max = $row["MAX(price)"];
                        echo "<option value='$min - $max'>$min - $max</option>";
                    }
                    ?>   
                </select>
            </div>
            <!-- brand filter ************************************** -->  
            <div class="mb-2">
                <label for="brandName" class="form-label text-light">Brand Name:</label>
                <select class="form-select" id="brandName" name="brandName">
                    <option value="brandName">Select Brand Name</option>
                    <?php
                    while ($row = $result_brands->fetch_assoc()) {
                        $row = $row["brand_name"];
                        echo "<option value='$row'>$row</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- nationality filter ************************************** -->
            <div class="mb-2">
                <label for="brandNationality" class="form-label text-light">Brand Nationality:</label>
                <select class="form-select" id="brandNationality" name="brandNationality">
                    <option value="brandNationality">Select Nationality</option>
                    <?php
                    while ($row = $result_nat->fetch_assoc()) {
                        $row = $row["nationality"];
                        echo "<option value='$row'>$row</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-2">

              <div class="mb-2">
                <button type="submit" name='apply_filter' class="btn btn-light">Apply Filter</button>
                <button type="button" class="btn btn-secondary" onclick="resetFilter()">Reset</button>
             
        </form>
                </div>
            </div>
        </div>

        <div class="bg-custom p-3 text-center">
            <p>Andalus store</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
            crossorigin="anonymous"></script>

<script>
    // Function to set and save filter values in localStorage
    function applyFilter() {
        var priceRange = document.getElementById("priceRange").value;
        var brandName = document.getElementById("brandName").value;
        var brandNationality = document.getElementById("brandNationality").value;
        

        // Save values in localStorage
        localStorage.setItem("priceRange", priceRange);
        localStorage.setItem("brandName", brandName);
        localStorage.setItem("brandNationality", brandNationality);
        
    }
    // Function to load filter values from localStorage on page load
    function loadFilterValues() {
        var priceRange = localStorage.getItem("priceRange");
        var brandName = localStorage.getItem("brandName");
        var brandNationality = localStorage.getItem("brandNationality");
        ;

        // Set values in filter dropdowns if they exist in localStorage
        if (priceRange) {
            document.getElementById("priceRange").value = priceRange;
        }
        if (brandName) {
            document.getElementById("brandName").value = brandName;
        }
        if (brandNationality) {
            document.getElementById("brandNationality").value = brandNationality;
        }
      
    }

    

    // Function to reset filter values and clear localStorage
    function resetFilter() {
        document.getElementById("priceRange").selectedIndex = 0;
        document.getElementById("brandName").selectedIndex = 0;
        document.getElementById("brandNationality").selectedIndex = 0;
        

        // Clear values from localStorage
        localStorage.removeItem("priceRange");
        localStorage.removeItem("brandName");
        localStorage.removeItem("brandNationality");
        // Navigate to the "home.php" page
        window.location.href = 'home.php';
    }

   
    function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.querySelector('.container');

            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded-content');
        }

    // Call loadFilterValues on page load
    document.addEventListener("DOMContentLoaded", loadFilterValues);



</script>

</body>
</html>