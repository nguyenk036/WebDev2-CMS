<?php

//start session
session_start();

//end session
unset($_SESSION['user_id']);

//redirect to home page
header("Location: home.php");

?>

