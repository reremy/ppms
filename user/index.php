<?php include("../config/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="http://localhost/ppms/welcome.css">

    <style>
    .product-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin: 20px;
    }

    .product-card {
        width: 200px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        background-color: #fff;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .product-card h3 {
        font-size: 1.2em;
        margin: 10px 0;
        color: #333;
    }

    .product-card p {
        font-size: 0.9em;
        color: #666;
        margin: 0 10px 10px;
    }
    </style>
</head>

<body>
    <div class="userTopNav">
        <div class="logo-container">
            <a href="http://localhost/ppms/user/index.php"><img src="http://localhost/ppms/img/logo.png" alt="logo"
                    class="logo"></a>
        </div>

        <div class="userNav">
            <!-- user navigation:home|blogs|reviews -->
            <?php include("includes/userNav.php"); ?>
        </div>

        <div>
            <!-- "Hi, username", cart icon, profile icon, sign out icon -->
            <p>hello, username</p>

            <a href="http://localhost/ppms/user/modules/cart/cart_action.php"><i class="fa fa-shopping-cart"></i></a>

            <a href="http://localhost/ppms/user/modules/profile/profile.php"><i class="fa fa-user"></i></a>

            <a href="http://localhost/ppms/signout/logout.php"><i class="fa fa-sign-out"></i></a>
        </div>

        <div>
            <!-- Include the products.php here -->
            <?php include("../user/modules/product/products.php"); ?>
        </div>
    </div>
</body>

</html>