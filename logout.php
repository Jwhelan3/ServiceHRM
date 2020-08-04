<?php

session_start();

//Destroy the session and redirect the user to the homepage
unset($_SESSION);
session_destroy();

header("Location: index.php");

?>