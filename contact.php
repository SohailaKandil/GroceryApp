<?php
    include 'db_connection.php';
    session_start();
    $con = OpenCon();
    
    if (isset($_SESSION["username"])) {
        $name = $_SESSION["username"];
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Form validation
        $name = htmlspecialchars(trim($_POST["name"]));
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        $message = htmlspecialchars(trim($_POST["message"]));
    
        if ($name && $email && $message) {
            // Connection to database
            $con = OpenCon();
    
            // Save to the database
            $stmt = $con->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $message);
            $stmt->execute();
            $stmt->close();
    
            // Close database connection
            CloseCon($con);
    
            // Redirect with success message
            header("Location: contact.php?success=true");
            exit();
        } else {
            // Redirect with error message
            header("Location: contact.php?error=true");
            exit();
        }
    }
    
    ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Andalus Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-custom">
        <div class="container">
            <a class="navbar-brand" href="index.php">Andalus Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4">Contact Us</h2>

        <?php
        // Display success/error messages if set in the URL
        if (isset($_GET['success']) && $_GET['success'] == 'true') {
            echo "<div class='alert alert-success'>Thank you! Your message has been received.</div>";
        } elseif (isset($_GET['error']) && $_GET['error'] == 'true') {
            echo "<div class='alert alert-danger'>Invalid form data. Please try again.</div>";
        }
        ?>

        <form action="" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name:</label>
                        <input type="text" class="form-control" id="name" name="name"  required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Your Message:</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-custom">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw8/6+PjoY4L2zzpG1uLEZt+QxDX+d8eU3foNkT5wApfY6xnyBuA2aQpUe0yHp"
        crossorigin="anonymous"></script>
</body>

</html>