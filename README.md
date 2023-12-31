# GroceryApp

## Overview

This project is a web application for a grocery store, aiming to integrate databases with web development technologies. 

## Technologies Used

- **Database:** MySQL Database Management System (DBMS)
- **Backend:** PHP.
- **Frontend:** HTML and CSS. (Bootstrap)
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

- `https://andalosstore.000webhostapp.com/register.php`: Register a new user account.
- `https://andalosstore.000webhostapp.com/login.php`: Log in to the application.
- `https://andalosstore.000webhostapp.com/product_details.php?id=27`: View details of specific products.
- `https://andalosstore.000webhostapp.com/contact.php`: Contact the team.
- `https://andalosstore.000webhostapp.com/about_us.php`: View information about the app and the team.
- `https://andalosstore.000webhostapp.com/search.php?search=7-10&submit=`: Search for products.
- `https://andalosstore.000webhostapp.com/filter.php?priceRange=20+-+28&brandName=egypt+foods&brandNationality=egypt&apply_filter=`: Filter the products.
- `https://andalosstore.000webhostapp.com/shoping_cart.php?id=27p`: Add a grocery item to the shopping cart.
- `https://andalosstore.000webhostapp.com/buy_form.php?id=27`: Process the payment.

## How to Run The Project

1. Clone the repository:
 git clone https://github.com/alaaamoheb/GroceryApp
2. Ensure that your server supports PHP and is configured correctly.
3. Place the project files in the root directory of your server.
4. Access the application through your server's URL, using the provided endpoints.
5. Update any configuration files (e.g., database configuration) according to your environment.

## Collaborators
[ [Alaa Moheb](https://github.com/alaaamoheb) - [Sohaila Kandil](https://github.com/SohailaKandil) - [Abdulrahman Essam](https://github.com/A-Ess12) - [Omnia Nabil](https://github.com/omniaEjust)]
