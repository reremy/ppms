<?php

$databaseHost = 'localhost';
$databaseUsername = 'root';
$databasePassword = '';
$databaseName = 'ppms';

define('BASE_URL', 'http://localhost/ppms');
define('USER_BASE_URL', 'http://localhost/ppms/user');
define('USER_BASE_PATH', '/user');

$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

?>