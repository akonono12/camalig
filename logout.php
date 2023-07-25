<?php
session_start();
session_unset($_SESSION['user_id']);
session_unset($_SESSION['access']);
 
header("location:login.html");
?>