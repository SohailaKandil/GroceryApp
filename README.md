# GroceryApp

## Overview

This project is a web application for a grocery store, aiming to integrate databases with web development technologies. 

## Technologies Used

- **Database:** MySQL Database Management System (DBMS)
- **Backend:** PHP
- **Frontend:** HTML and CSS
- **Repository Hosting:** [GitHub](https://github.com/alaaamoheb/GroceryApp)

### Key Features
It offers a range of features to enhance the user experience, including:
- **Product Details:** Comprehensive information on each product, including brand, price, discount, expiration date, and more.
- **Filtering Capability:** Robust product search and filtering based on price range, brand names, and nationalities.
- **Search Functionality:** Easy product search by name, brand, or price range.
- **Shopping Cart:** Personalized shopping cart for users with the option to add or remove items.
- **Product Statistics:** Displays the number of users who have purchased a specific product.
- **User Accounts:** User registration and authentication with personalized sessions.

### Administrator Privileges
- View undelivered orders, manage product information, add/delete products, and utilize standard user functionalities.

### Special Features
- **Simulate Payment Process:** Simulates the payment process for a realistic shopping experience.
- **Random Discounts:** Implement random discounts for near-expiry products to attract users. This can be integrated into the "/discounts.php" endpoint in the admin page .
- **Nationality Information:** Displays product nationality details if it's 100% Egyptian.
- **Execluding Boycut Products:** Users can exclude boycotted products—those with shareholders solely from specific countries.
## App Endpoints

- `/register.php`: Register a new user account.
- `/login.php`: Log in to the application.
- `/logout.php`: Log out of the application.
- `/product_details.php`: View details of specific products.
- `/contact.php`: Contact the team.
- `/about_us.php`: View information about the app and the team.
- `/search.php`: Search for products.
- `/filter.php`: Filter the products.
- `/shopping_cart.php`: Add a grocery item to the shopping cart.
- `/buy_form.php`: Process the payment.


