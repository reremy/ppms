<?php
// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page or homepage
header("Location: http://localhost/ppms/login/loginPage.php");
exit();