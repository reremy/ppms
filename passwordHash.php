<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="<?php echo USER_BASE_URL; ?>/css/welcome.css">
</head>

<body>
    <?php
$passwordHash = password_hash('abcd1234----',PASSWORD_DEFAULT);
echo $passwordHash;
    ?>
</body>

</html>