<?php include("config/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
</head>

<body>
    <div class="topNav">
        <div class="logo-container">
            <a href="http://localhost/ppms/admin/"><img src="http://localhost/ppms/img/icon.png" alt="logo"
                    class="logo"></a>
        </div>

        <div>
            <p>hello, admin</p>
        </div>
    </div>

    <div>
        <?php include("includes/sideNav.php") ?>
    </div>

    <div>
        <h2>admin dashboard</h2>
    </div>

    <script src="/ppms/admin/js/dropdown.js"></script>
</body>

</html>