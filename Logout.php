<?php
session_start();
// Remove all session variables (which has username)
$_SESSION = array();
header("Location: index.php");
?>
