<?php
// logout.php
session_start();
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session
header("Location: SignUp.php"); // Redirect to SignUp.php
exit();
?>
